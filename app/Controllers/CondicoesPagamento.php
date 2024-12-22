<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\CondicaoPagamento;

class CondicoesPagamento extends BaseController
{
    protected $db;
    protected $condicaoModel;
    protected $tabelaModel;

    private $viewFolder = '/cadastros/financeiro/condicoes_pagto';
    private $route = 'condicoes';

    /**
     * Método que valida se a condição de pagamento existe. Caso exista retorna um object com os dados da condição de pagamento, caso
     * não exista, retorna um Exception
     * 
     * @param integer $id
     * @return Object ou Exception
     */
    private function validation_condicao(int $id = null)
    {
        if (!$id || !$condicao = $this->condicaoModel->withDeleted(true)->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Condição de Pagamento ID: $id não encontrada!");
        }

        return $condicao;
    }

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->condicaoModel = new \App\Models\CondicaoPagamentoModel();
        $this->tabelaModel = new \App\Models\TabelaPrecoModel();
    }

    /**
     * Método que retorna a view com todos os registros da tabela
     * 
     * @return view
     */
    public function index()
    {
        if ($this->getLoggedUserData() == '') {
            return redirect()->to(site_url("login"))->with("message-info", "Verifique suas credenciais e tente novamente!");
        }

        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('listar-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $data = array(
            'menu'    => 'Financeiro',
            'submenu' => 'Cadastros',
            'title'   => 'Condições de Pagamento',
        );

        return view($this->viewFolder . '/list', $data);
    }

    /**
     * Metodo chamado via AJAX que retorna um JSON com os dados de todos as condicoes de pagamento
     * 
     * @return JSON
     */
    public function fetch()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $columns = array(
            0 => 'condicoes_pagamento.id',
            1 => 'condicoes_pagamento.nome',
            2 => 'condicoes_pagamento.entrada',
            3 => 'condicoes_pagamento.perc_entrada',
            4 => 'condicoes_pagamento.qtd_parcelas',
            5 => 'condicoes_pagamento.dias_parcela1',
            6 => 'condicoes_pagamento.dias_parcelas',
            7 => 'condicoes_pagamento.tabela_id',
            8 => 'condicoes_pagamento.active',
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

        $condicoes = $this->condicaoModel->getCondicoesPagamento($params_array);
        $rowsTotal = $this->condicaoModel->countCondicoesPagamento($search);

        $rows = 0;
        $data = array();

        foreach ($condicoes as $condicao) {
            $act_view  = '<button data-toggle="tooltip" data-original-title="Visualizar" title="Visualizar" data-id="' . $condicao->id . '" data-modulo="view" class="btn btn-xs btn-default text-primary btn-width-27 btn-view"><i class="fa fa-eye"></i></button>';
            $act_edit  = '<button data-toggle="tooltip" data-original-title="Editar" title="Editar" data-id="' . $condicao->id . '" data-modulo="edit" class="btn btn-xs btn-default btn-width-27 btn-edit"><i class="fas fa-edit"></i></button>';

            $sub_array = array();

            $sub_array[] = $condicao->id;
            $sub_array[] = $condicao->nome;
            $sub_array[] = ($condicao->entrada == true ? '<span class="btn btn-xs btn-default rounded-circle-custom text-success" data-toggle="tooltip" data-original-title="Sim"><i class="fa fa-check" title="Sim"></i></span>' : '<span class="btn btn-xs btn-default rounded-circle-custom text-danger" data-toggle="tooltip" data-original-title="Não"><i class="fa fa-times" title="Não"></i></span>');
            $sub_array[] = $condicao->perc_entrada;
            $sub_array[] = $condicao->qtd_parcelas;
            $sub_array[] = $condicao->dias_parcela1;
            $sub_array[] = $condicao->dias_parcelas;
            $sub_array[] = $condicao->tabela;
            $sub_array[] = ($condicao->active == true ? '<span class="btn btn-xs btn-default rounded-circle-custom text-success" data-toggle="tooltip" data-original-title="Ativo"><i class="fa fa-unlock" title="Ativo"></i></span>' : '<span class="btn btn-xs btn-default rounded-circle-custom text-danger" data-toggle="tooltip" data-original-title="Inativo"><i class="fa fa-lock" title="Inativo"></i></span>');
            $sub_array[] = $act_view . $act_edit . $condicao->buttonsControl();

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
     * Método que retorna a view de inclusão de condição de pagamento
     * 
     * @return view
     */
    public function add()
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('listar-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $condicao = new CondicaoPagamento();

        $data = array(
            'title'    => 'Nova Condição de Pagamento',
            'method'   => 'insert',
            'viewpath' => APP_THEME . $this->viewFolder,
            'form'     => 'form',
            'response' => 'response',
            'table'    => $condicao,
            'tabelas'  => $this->tabelaModel->getAllTabelas(),
        );

        // return view($this->viewFolder . '/_add', $data);
        return view(APP_THEME . '/layout/modals/_modal', $data);
    }

    /**
     * Método que faz o insert dos dados da condição de pagamento
     * 
     * @return json
     */
    public function insert()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $return = [];
        $return['token'] = csrf_hash();

        $post = $this->request->getPost();

        // Limpa os dados desnecessários do POST
        $fields_to_unset = [
            'method',
        ];

        foreach ($fields_to_unset as $field) {
            unset($post[$field]);
        }

        $condicao = new CondicaoPagamento($post);

        try {
            $this->db->transStart(); // Inicia a transação

            // Insere a condição de pagamento
            if (!$this->condicaoModel->protect(false)->insert($condicao, true)) {
                throw new \Exception('Erro ao inserir a condição de pagamento.');
            }

            $condicao_id = $this->condicaoModel->getInsertID();

            $this->db->transComplete(); // Finaliza a transação

            if ($this->db->transStatus() === false) {
                throw new \Exception('Erro ao completar a transação.');
            }

            if (!$this->condicaoModel->errors()) {
                $return['success'] = 'Dados salvos com sucesso!';
            } else {
                $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
                $return['errors_model'] = $this->condicaoModel->errors();
            }

            $return['id'] = $condicao_id;

            return $this->response->setJSON($return);
        } catch (\Exception $e) {
            $this->db->transRollback(); // Reverte as mudanças em caso de erro

            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $e->getMessage();

            return $this->response->setJSON($return);
        }
    }

    /**
     * Método que retorna a view de edição dos dados da condição de pagamento
     * 
     * @param $id
     * @return view
     */
    public function edit(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('editar-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $condicao = $this->validation_condicao($id);

        $data = array(
            'title'    => 'Editar Condição de Pagamento',
            'method'   => 'update',
            'viewpath' => APP_THEME . $this->viewFolder,
            'form'     => 'form',
            'response' => 'response',
            'table'    => $condicao,
            'tabelas'  => $this->tabelaModel->getAllTabelas(),
        );

        // return view($this->viewFolder . '/_edit', $data);
        return view(APP_THEME . '/layout/modals/_modal', $data);
    }

    /**
     * Método que faz o update dos dados da condição de pagamento
     * 
     * @return json
     */
    public function update()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $return = [];
        $return['token'] = csrf_hash();

        $post = $this->request->getPost();

        // Limpa os dados desnecessários do POST
        $fields_to_unset = [
            'method',
        ];

        foreach ($fields_to_unset as $field) {
            unset($post[$field]);
        }

        try {
            $this->db->transStart(); // Inicia a transação

            $condicao = $this->validation_condicao($post['id']);
            $condicao->fill($post);

            if ($condicao->hasChanged()) {
                $this->condicaoModel->protect(false)->save($condicao);
            }

            $this->db->transComplete(); // Finaliza a transação

            if ($this->db->transStatus() === false) {
                throw new \Exception('Erro ao salvar os dados.');
            }

            if (!$this->condicaoModel->errors()) {
                $return['success'] = 'Dados salvos com sucesso!';
            } else {
                $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
                $return['errors_model'] = $this->condicaoModel->errors();
            }

            return $this->response->setJSON($return);
        } catch (\Exception $e) {
            $this->db->transRollback(); // Reverte as mudanças em caso de erro

            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $e->getMessage();

            return $this->response->setJSON($return);
        }
    }

    /**
     * Método que retorna a view de deleção da condição de pagamento
     * 
     * @param $id
     * @return view
     */
    public function delete(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('excluir-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $condicao = $this->validation_condicao($id);

        $data = array(
            'title'    => 'Excluir',
            'method'   => 'delete',
            'condicao' => $condicao,
        );

        return view($this->viewFolder . '/_delete', $data);
    }

    /**
     * Método que faz a deleção da condição de pagamento
     * 
     * @param $id
     * @return redirect
     */
    public function remove(int $id = null)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $condicao = $this->validation_condicao($id);

        $this->condicaoModel->delete($condicao->id);

        $condicao->active = false;

        $this->condicaoModel->protect(false)->save($condicao);

        if (!$this->condicaoModel->errors()) {
            $return['success'] = 'Removido com sucesso!';
        } else {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $this->condicaoModel->errors();
        }

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view de restore da condição de pagamento.
     * 
     * @param $id
     * @return view
     */
    public function undo(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('excluir-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $condicao = $this->validation_condicao($id);

        $data = [
            'title'    => 'Restaurar',
            'method'   => 'restore',
            'condicao' => $condicao,
        ];

        return view($this->viewFolder . '/_restore', $data);
    }

    /**
     * Método que faz o restore da condição de pagamento
     * 
     * @param $id
     * @return redirect
     */
    public function restore(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('editar-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $condicao = $this->validation_condicao($id);

        $condicao->deleted_at = null;
        $condicao->active = true;

        $this->condicaoModel->protect(false)->save($condicao);

        if (!$this->condicaoModel->errors()) {
            $return['success'] = 'Restaurado com sucesso!';
        } else {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $this->condicaoModel->errors();
        }

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view de visualização dos dados da condição de pagamento
     * 
     * @param $id
     * @return view
     */
    public function show(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('listar-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $condicao = $this->validation_condicao($id);

        $data = array(
            'title'    => 'Visualizar',
            'condicao' => $condicao,
            'tabela'   => $this->tabelaModel->getTabelaById($condicao->tabela_id),
        );

        return view($this->viewFolder . '/_show', $data);
    }
}
