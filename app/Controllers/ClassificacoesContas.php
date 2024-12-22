<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\ClassificacaoConta;

class ClassificacoesContas extends BaseController
{
    protected $db;
    protected $classificacaoModel;

    private $viewFolder = '/cadastros/financeiro/classificacoes_contas';
    private $route = 'classificacoescontas';

    /**
     * Método que valida se a classificação existe. Caso exista retorna um object com os dados da classificação, caso
     * não exista, retorna um Exception
     * 
     * @param integer $id
     * @return Object ou Exception
     */
    private function validation_classificacao(int $id = null)
    {
        if (!$id || !$classificacao = $this->classificacaoModel->withDeleted(true)->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Classificação ID: $id não encontrada!");
        }

        return $classificacao;
    }

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->classificacaoModel = new \App\Models\ClassificacaoContaModel();
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
            'title'   => 'Classificações de Contas',
        );

        return view($this->viewFolder . '/list', $data);
    }

    /**
     * Metodo chamado via AJAX que retorna um JSON com os dados de todas as classificações
     * 
     * @return JSON
     */
    public function fetch()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $columns = array(
            0 => 'classificacoes_contas.codigo',
            1 => 'classificacoes_contas.descricao',
            2 => 'classificacoes_contas.tipo',
            3 => 'classificacoes_contas.active',
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

        $classificacaos = $this->classificacaoModel->getClassificacoes($params_array);
        $rowsTotal = $this->classificacaoModel->countClassificacoes($search);

        $rows = 0;
        $data = array();

        foreach ($classificacaos as $classificacao) {
            $act_view  = '<button data-toggle="tooltip" data-original-title="Visualizar Classificação" title="Visualizar Classificação" data-id="' . $classificacao->id . '" data-modulo="view" class="btn btn-xs btn-default text-primary btn-width-27 btn-view"><i class="fa fa-eye"></i></button>';
            $act_edit  = '<button data-toggle="tooltip" data-original-title="Editar Classificação" title="Editar Classificação" data-id="' . $classificacao->id . '" data-modulo="edit" class="btn btn-xs btn-default btn-width-27 btn-edit"><i class="fas fa-edit"></i></button>';


            if (($classificacao->id_pai == null) || ($classificacao->id_pai == 0)) {
                $style = '';
            } else if (substr_count($classificacao->codigo, '.') == 1) {
                $style = 'tab1';
            } else if (substr_count($classificacao->codigo, '.') == 2) {
                $style = 'tab2';
            } else if (substr_count($classificacao->codigo, '.') == 3) {
                $style = 'tab3';
            } else if (substr_count($classificacao->codigo, '.') == 4) {
                $style = 'tab4';
            } else if (substr_count($classificacao->codigo, '.') == 5) {
                $style = 'tab5';
            }

            $sub_array = array();

            $sub_array[] = ($style == '' ? $classificacao->codigo : '<' . $style . '>' . $classificacao->codigo . '</' . $style . '>');
            $sub_array[] = ($style == '' ? $classificacao->descricao : '<' . $style . '>' . $classificacao->descricao . '</' . $style . '>');
            $sub_array[] = ($classificacao->tipo == 'P' ? '<span class="label label-danger">Despesa</span>' : '<span class="label label-success">Receita</span>');
            $sub_array[] = ($classificacao->active == true ? '<span class="btn btn-xs btn-default rounded-circle-custom text-success" data-toggle="tooltip" data-original-title="Ativo"><i class="fa fa-unlock" title="Ativo"></i></span>' : '<span class="btn btn-xs btn-default rounded-circle-custom text-danger" data-toggle="tooltip" data-original-title="Inativo"><i class="fa fa-lock" title="Inativo"></i></span>');
            $sub_array[] = $act_view . $act_edit . $classificacao->buttonsControl();

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
     * Método que retorna a view de inclusão de classificação
     * 
     * @return view
     */
    public function add()
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('listar-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $classificacao = new ClassificacaoConta();

        $data = array(
            'title'          => 'Nova Classificação',
            'method'         => 'insert',
            'viewpath'       => APP_THEME . $this->viewFolder,
            'form'           => 'form',
            'response'       => 'response',
            'table'          => $classificacao,
            'classificacoes' => $this->classificacaoModel->getAllClassificacoes(),
        );

        // return view($this->viewFolder . '/_add', $data);
        return view(APP_THEME . '/layout/modals/_modal', $data);
    }

    /**
     * Método que faz o insert dos dados da classificação
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

        $codigo = $this->classificacaoModel->getCodigoClassificacao($post['id_pai']);
        $post['codigo'] = $codigo;

        $classificacao = new ClassificacaoConta($post);

        try {
            $this->db->transStart(); // Inicia a transação

            // Insere a classificação
            if (!$this->classificacaoModel->protect(false)->insert($classificacao, true)) {
                throw new \Exception('Erro ao inserir a classificação.');
            }

            $classificacao_id = $this->classificacaoModel->getInsertID();

            $this->db->transComplete(); // Finaliza a transação

            if ($this->db->transStatus() === false) {
                throw new \Exception('Erro ao completar a transação.');
            }

            if (!$this->classificacaoModel->errors()) {
                $return['success'] = 'Dados salvos com sucesso!';
            } else {
                $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
                $return['errors_model'] = $this->classificacaoModel->errors();
            }

            $return['id'] = $classificacao_id;

            return $this->response->setJSON($return);
        } catch (\Exception $e) {
            $this->db->transRollback(); // Reverte as mudanças em caso de erro

            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $e->getMessage();

            return $this->response->setJSON($return);
        }
    }

    /**
     * Método que retorna a view de edição dos dados da classificação
     * 
     * @param $id
     * @return view
     */
    public function edit(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('editar-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        helper('form');

        $classificacao = $this->validation_classificacao($id);

        $data = array(
            'title'          => 'Editar Classificação',
            'method'         => 'update',
            'viewpath'       => APP_THEME . $this->viewFolder,
            'form'           => 'form',
            'response'       => 'response',
            'table'          => $classificacao,
            'classificacoes' => $this->classificacaoModel->getAllClassificacoes(),
        );

        // return view($this->viewFolder . '/_edit', $data);
        return view(APP_THEME . '/layout/modals/_modal', $data);
    }

    /**
     * Método que faz o update dos dados da classificação
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

        $classificacao_atual = $this->validation_classificacao($post['id']);
        $id_pai_atual = ($post['id_pai'] == null ? 0 : $post['id_pai']);
        $codigo = $this->classificacaoModel->getCodigoClassificacao($post['id_pai']);

        if ($classificacao_atual->id_pai != $id_pai_atual) {
            $post['codigo'] = $codigo;
        }

        try {
            $this->db->transStart(); // Inicia a transação

            $classificacao = $this->validation_classificacao($post['id']);
            $classificacao->fill($post);

            if ($classificacao->hasChanged()) {
                $this->classificacaoModel->protect(false)->save($classificacao);
            }

            $this->db->transComplete(); // Finaliza a transação

            if ($this->db->transStatus() === false) {
                throw new \Exception('Erro ao salvar os dados.');
            }

            if (!$this->classificacaoModel->errors()) {
                $return['success'] = 'Dados salvos com sucesso!';
            } else {
                $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
                $return['errors_model'] = $this->classificacaoModel->errors();
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
     * Método que retorna a view de deleção da classificação
     * 
     * @param $id
     * @return view
     */
    public function delete(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('excluir-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $classificacao = $this->validation_classificacao($id);

        $data = array(
            'title'         => 'Excluir',
            'method'        => 'delete',
            'classificacao' => $classificacao,
        );

        return view($this->viewFolder . '/_delete', $data);
    }

    /**
     * Método que faz a deleção da classificação
     * 
     * @param $id
     * @return redirect
     */
    public function remove(int $id = null)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $classificacao = $this->validation_classificacao($id);

        $this->classificacaoModel->delete($classificacao->id);

        $classificacao->active = false;

        $this->classificacaoModel->protect(false)->save($classificacao);

        if (!$this->classificacaoModel->errors()) {
            $return['success'] = 'Removido com sucesso!';
        } else {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $this->classificacaoModel->errors();
        }

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view de restore da classificação
     * 
     * @param $id
     * @return view
     */
    public function undo(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('excluir-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $classificacao = $this->validation_classificacao($id);

        $data = [
            'title'         => 'Restaurar',
            'method'        => 'restore',
            'classificacao' => $classificacao,
        ];

        return view($this->viewFolder . '/_restore', $data);
    }

    /**
     * Método que faz o restore da classificação
     * 
     * @param $id
     * @return redirect
     */
    public function restore(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('editar-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $classificacao = $this->validation_classificacao($id);

        $classificacao->deleted_at = null;
        $classificacao->active = true;

        $this->classificacaoModel->protect(false)->save($classificacao);

        if (!$this->classificacaoModel->errors()) {
            $return['success'] = 'Restaurado com sucesso!';
        } else {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $this->classificacaoModel->errors();
        }

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view de visualização dos dados da classificação
     * 
     * @param $id
     * @return view
     */
    public function show(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('listar-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $classificacao = $this->validation_classificacao($id);

        $data = array(
            'title'         => 'Visualizar',
            'classificacao' => $classificacao,
        );

        return view($this->viewFolder . '/_show', $data);
    }
}
