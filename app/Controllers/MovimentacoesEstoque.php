<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\MovimentoEstoque;

class MovimentacoesEstoque extends BaseController
{
    protected $db;
    protected $produtoModel;
    protected $movimentoModel;
    protected $tipoModel;
    protected $depositoModel;
    protected $estoqueDepositoModel;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->produtoModel = new \App\Models\ProdutoModel();
        $this->movimentoModel = new \App\Models\MovimentoEstoqueModel();
        $this->tipoModel = new \App\Models\TipoMovimentoModel();
        $this->depositoModel = new \App\Models\DepositoProdutoModel();
        $this->estoqueDepositoModel = new \App\Models\EstoqueDepositoModel();
    }

    /**
     * Método que exibe a view de listagem de ajustes de estoque
     * 
     * @return view
     */
    public function ajustes()
    {
        if ($this->getLoggedUserData() == '') {
            return redirect()->to(site_url("login"))->with("message-info", "Verifique suas credenciais e tente novamente!");
        }

        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('list-ajustes'))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $data = array(
            'menu'    => 'Estoque',
            'submenu' => 'Movimentos',
            'title'   => 'Ajustes',
        );

        return view('estoque/ajustes/list', $data);
    }

    /**
     * Metodo chamado via AJAX que retorna um JSON com os dados de todos os ajustes
     * 
     * @return JSON
     */
    public function ajustes_fetch()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $columns = array(
            0 => 'id',
            1 => 'produto_descricao',
            2 => 'quantidade',
            3 => 'movimento',
            4 => 'data_movimento',
            5 => 'descricao',
        );

        $draw = isset($_POST['draw']) ? (int)$_POST['draw'] : 10;
        $start = isset($_POST['start']) ? (int)$_POST['start'] : 0;
        $rowPerPage = isset($_POST['length']) ? (int)$_POST['length'] : 10;
        $columnIndex = isset($_POST['order'][0]['column']) ? $_POST['order'][0]['column'] : 0;
        $orderColumn = isset($_POST['columns'][$columnIndex]['data']) ? $_POST['columns'][$columnIndex]['data'] : 0;
        $orderDir = isset($_POST['order']) ? $_POST['order'][0]['dir'] : '';

        if (isset($_POST['search'])) {
            if ($_POST['search']['value'] != '') {
                $search = $_POST['search']['value'];
            } else {
                $search = '';
            }
        } else {
            $search = '';
        }

        if ($orderColumn == '') {
            $orderColumn = 0;
        }

        $params_array = array(
            'start' => $start,
            'rowperpage' => $rowPerPage,
            'search' => $search,
            'order' => $columns[$orderColumn],
            'dir' => $orderDir,
        );

        $movimentos = $this->movimentoModel->getMovimentos($params_array);
        $rowsTotal = $this->movimentoModel->countMovimentos($search);

        $rows = 0;
        $data = array();

        foreach ($movimentos as $produto) {
            $act_view  = '<button data-toggle="tooltip" data-original-title="Visualizar" title="Visualizar" data-id="' . $produto->id . '" data-modulo="view" class="btn btn-xs btn-default text-primary btn-width-27 btn-view"><i class="fa fa-eye"></i></button>';

            $sub_array = array();

            $sub_array[] = $produto->produto_id;
            $sub_array[] = $produto->produto_descricao;
            $sub_array[] = formatPercent($produto->quantidade, false, 2);
            $sub_array[] = setTipoMovimento($produto->movimento);
            $sub_array[] = $produto->deposito;
            $sub_array[] = formatDateTime($produto->data_movimento);
            $sub_array[] = $produto->descricao;
            $sub_array[] = $act_view . $produto->buttonsControl();

            $data[] = $sub_array;
            $rows++;
        }

        $json = array(
            'draw' => intval($draw),
            'recordsTotal' => intval($rowsTotal),
            'recordsFiltered' => intval($rowsTotal),
            'data' => $data,
        );

        echo json_encode($json);
    }

    /**
     * Método que retorna a view de importação de XML
     * 
     * @return view
     */
    public function ajustes_import()
    {
        if ($this->getLoggedUserData() == '') {
            return redirect()->to(site_url("login"))->with("message-info", "Verifique suas credenciais e tente novamente!");
        }

        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('criar-ajustes'))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $data = array(
            'title' => 'Importar XML',
        );

        return view('estoque/ajustes/_import', $data);
    }

    /**
     * Método que faz a leitura do xml
     * 
     * @return string or Exception
     */
    public function ajustes_upload()
    {
        $file = $this->request->getFile('xml');
        $xml  = simplexml_load_file($file);

        foreach ($xml->NFe->infNFe->det as $item) {
            if ($item->prod->cEAN != "SEM GTIN") {
                $produto = $this->produtoModel
                    ->where('codigo_barras', $item->prod->cEAN)
                    ->first();
            } else {
                $produto = $this->produtoModel
                    ->where('referencia', (string)$item->prod->cProd)
                    ->first();
            }

            try {
                $this->db->transStart(); // Inicia a transação

                $movimento = [];

                $prod_descricao = $item->prod->xProd;
                $prod_quantidade = $item->prod->qCom;

                if (!empty($produto)) {
                    $movimento['tipo_movimento_id'] = 0;
                    $movimento['deposito_id']       = 0;
                    $movimento['produto_id']        = $produto->id;
                    $movimento['produto_descricao'] = $produto->descricao;
                    $movimento['data_movimento']    = date('Y-m-d H:i:s');
                    $movimento['descricao']         = '';
                    $movimento['movimento']         = 'E';
                    $movimento['quantidade']        = $prod_quantidade;
                    $movimento['valor']             = 0;
                    $movimento['valor_total']       = 0;
                    $movimento['estoque']           = $produto->estoque_real + $prod_quantidade;
                    $movimento['status']            = 0;
                } else {
                    $movimento['tipo_movimento_id'] = 0;
                    $movimento['deposito_id']       = 0;
                    $movimento['produto_id']        = 0;
                    $movimento['produto_descricao'] = $prod_descricao;
                    $movimento['data_movimento']    = date('Y-m-d H:i:s');
                    $movimento['descricao']         = '';
                    $movimento['movimento']         = 'E';
                    $movimento['quantidade']        = $prod_quantidade;
                    $movimento['valor']             = 0;
                    $movimento['valor_total']       = 0;
                    $movimento['estoque']           = $prod_quantidade;
                    $movimento['status']            = 0;
                }

                $ajuste = new MovimentoEstoque($movimento);

                if (!$this->movimentoModel->protect(false)->insert($ajuste, false)) {
                    throw new \Exception('Erro ao inserir um dos produtos.');
                }

                $this->db->transComplete(); // Finaliza a transação

                if ($this->db->transStatus() === false) {
                    throw new \Exception('Erro ao completar a transação.');
                }
            } catch (\Exception $e) {
                $this->db->transRollback(); // Reverte as mudanças em caso de erro

                return $e->getMessage();
            }
        }

        return 'ok';
    }

    /**
     * Método que retorna a view do ajuste que está sendo processado no momento
     * 
     * @return view
     */
    public function ajustes_view()
    {
        if ($this->getLoggedUserData() == '') {
            return redirect()->to(site_url("login"))->with("message-info", "Verifique suas credenciais e tente novamente!");
        }

        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('criar-ajustes'))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $data = array(
            'menu'       => 'Estoque',
            'submenu'    => 'Movimentos',
            'title'      => 'Ajustes',
            'movimentos' => $this->movimentoModel->getMovimentosTemp([]),
            'produtos'   => $this->produtoModel->getAllProdutos(),
            'tipos'      => $this->tipoModel->getAllTipoMovimentos(),
            'depositos'  => $this->depositoModel->getAllDepositos(),
        );

        return view('estoque/ajustes/view_list', $data);
    }

    /**
     * Método que realiza o update das informações do produto
     */
    public function ajustes_update()
    {
        $data = $this->request->getVar();

        $data['quantidade'] = convertDecimal($data['quantidade']);

        $tipo = $this->tipoModel
            ->where('id', $data['tipo_movimento_id'])
            ->first();

        $data['movimento'] = $tipo->movimento;

        $this->movimentoModel
            ->where('id', $data['id'])
            ->set($data)
            ->update();

        session()->setFlashdata(
            'message-success',
            'Dados alterados com sucesso!'
        );

        return redirect()->to("/estoque/ajustes/view/#mov_{$data['id']}");
    }

    /**
     * Método que exclui o produto da movimentação de ajuste
     * 
     * @param int $id
     */
    public function ajustes_delete(int $id)
    {
        $this->movimentoModel
            ->where('id', $id)
            ->delete();

        $movimento = $this->movimentoModel
            ->withDeleted(true)
            ->find($id);

        $movimento->active = false;

        $this->movimentoModel->protect(false)
            ->save($movimento);

        $ajuste = $this->movimentoModel
            ->where('status', 0)
            ->withDeleted(false)
            ->find();

        if (empty($ajuste)) {
            session()->setFlashdata(
                'message-info',
                'Todos os produtos importados foram excluídos, refaça o processo!'
            );

            return redirect()->to('estoque/ajustes');
        } else {
            session()->setFlashdata(
                'message-success',
                'Produto excluído com sucesso!'
            );

            return redirect()->to('estoque/ajustes/view');
        }
    }

    public function ajustes_complete()
    {
        try {
            $this->db->transStart(); // Inicia a transação

            $produtos = $this->movimentoModel
                ->where('status', 0)
                ->withDeleted(false)
                ->findAll();

            foreach ($produtos as $produto) {
                $movimento_id = $produto->id;
                $produto_id = $produto->produto_id;
                $deposito_id = $produto->deposito_id;

                // Buscar os dados na tabela de produtos
                $produto_estoque = $this->produtoModel
                    ->where('id', $produto_id)
                    ->withDeleted(false)
                    ->first();

                $estoque_atual = $produto_estoque->estoque_atual;
                $reservado_atual = $produto_estoque->estoque_reservado;

                if ($produto->movimento == 'E') {
                    $saldo_atualizado = $estoque_atual + $produto->quantidade;

                    if ($produto->deposito_id == 1) { // Depósito "RESERVA"
                        $reservado_atualizado = $reservado_atual + $produto->quantidade;
                    } else {
                        $reservado_atualizado = $reservado_atual;
                    }
                } else if ($produto->movimento == 'S') {
                    $saldo_atualizado = $estoque_atual - $produto->quantidade;

                    if ($produto->deposito_id == 1) { // Depósito "RESERVA"
                        $reservado_atualizado = $reservado_atual - $produto->quantidade;
                    } else {
                        $reservado_atualizado = $reservado_atual;
                    }
                } else if ($produto->movimento == 'T') {
                    $saldo_atualizado = $estoque_atual;
                    // TODO: criar opção para transferências entre depósitos
                    $reservado_atualizado = $reservado_atual;
                }

                $estoque_real = $saldo_atualizado - $reservado_atualizado;

                // Atualizar os saldos na tabela de produtos
                if (!$this->produtoModel
                    ->protect(false)
                    ->where('id', $produto_id)
                    ->set('estoque_atual', $saldo_atualizado)
                    ->set('estoque_real', $estoque_real)
                    ->set('estoque_reservado', $reservado_atualizado)
                    ->update()) {
                    throw new \Exception('Falha ao atualizar o produto: ' . implode(', ', $this->produtoModel->errors()));
                }

                // Verificar se já existe registro na tabela estoque_depositos
                $estoque_deposito = $this->estoqueDepositoModel
                    ->where('produto_id', $produto_id)
                    ->where('deposito_id', $deposito_id)
                    ->withDeleted(false)
                    ->first();

                // Se não existir, inclui o saldo na tabela estoque_depositos
                if (empty($estoque_deposito)) {
                    $data_deposito = [
                        'produto_id'  => $produto_id,
                        'deposito_id' => $deposito_id,
                        'estoque'     => $produto->quantidade,
                    ];

                    $estoque_deposito = new MovimentoEstoque($data_deposito);

                    if (!$this->estoqueDepositoModel->protect(false)->insert($estoque_deposito, false)) {
                        throw new \Exception('Falha ao inserir o estoque no depósito: ' . implode(', ', $this->estoqueDepositoModel->errors()));
                    }
                } else { // Caso já exista, apenas atualiza o saldo na tabela estoque_depositos
                    $estoque_id = $estoque_deposito->id;

                    if (!$this->estoqueDepositoModel
                        ->protect(false)
                        ->where('id', $estoque_id)
                        ->set('estoque', $estoque_real)
                        ->update()) {
                        throw new \Exception('Falha ao atualizar o estoque no depósito: ' . implode(', ', $this->estoqueDepositoModel->errors()));
                    }
                }

                // Atualizar a tabela estoque_movimentos
                if (!$this->movimentoModel
                    ->protect(false)
                    ->where('id', $movimento_id)
                    ->set('descricao', 'Ajuste realizado via importação de XML')
                    ->set('estoque', $estoque_real)
                    ->set('status', 1)
                    ->update()) {
                    throw new \Exception('Falha ao atualizar a movimentação: ' . implode(', ', $this->movimentoModel->errors()));
                }
            }

            $this->db->transComplete(); // Finaliza a transação

            if ($this->db->transStatus() === false) {
                throw new \Exception('Erro ao completar a transação.');
            }

            session()->setFlashdata(
                'message-success',
                'Ajuste finalizado com sucesso!'
            );

            return redirect()->to("/estoque/ajustes");
        } catch (\Exception $e) {
            $this->db->transRollback(); // Reverte as mudanças em caso de erro

            session()->setFlashdata(
                'message-error',
                $e->getMessage()
            );

            return redirect()->to("/estoque/ajustes/view");
        }
    }

    /**
     * Método que exibe a view de listagem de transferências de estoque
     * 
     * @return view
     */
    public function transferencias()
    {
        if ($this->getLoggedUserData() == '') {
            return redirect()->to(site_url("login"))->with("message-info", "Verifique suas credenciais e tente novamente!");
        }

        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('list-transferencias'))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $data = array(
            'menu'    => 'Estoque',
            'submenu' => 'Movimentos',
            'title'   => 'Transferências',
        );

        return view('estoque/transferencias/list', $data);
    }

    /**
     * Método que exibe a view de listagem de compras de produtos
     * 
     * @return view
     */
    public function compras()
    {
        if ($this->getLoggedUserData() == '') {
            return redirect()->to(site_url("login"))->with("message-info", "Verifique suas credenciais e tente novamente!");
        }

        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('list-compras'))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $data = array(
            'menu'    => 'Estoque',
            'submenu' => 'Movimentos',
            'title'   => 'Compras',
        );

        return view('estoque/compras/list', $data);
    }
}
