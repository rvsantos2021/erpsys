<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\SituacaoTributaria;

class SituacoesTributarias extends BaseController
{
    protected $db;
    protected $situacaoModel;

    private $viewFolder = '/cadastros/fiscais/csts';
    private $route = 'csts';

    /**
     * Método que valida se a situação tributária existe. Caso exista retorna um object com os dados da situação tributária, caso
     * não exista, retorna um Exception
     * 
     * @param integer $id
     * @return Object ou Exception
     */
    private function validation_situacao(int $id = null)
    {
        if (!$id || !$situacao = $this->situacaoModel->withDeleted(true)->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Situação Tributária ID: $id não encontrada!");
        }

        return $situacao;
    }

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->situacaoModel = new \App\Models\SituacaoTributariaModel();
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
            'menu'    => 'Fiscal',
            'submenu' => 'Cadastros',
            'title'   => 'CST / CSOSN',
        );

        return view($this->viewFolder . '/list', $data);
    }

    /**
     * Metodo chamado via AJAX que retorna um JSON com os dados de todos os depósitos
     * 
     * @return JSON
     */
    public function fetch()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $columns = array(
            0 => 'situacoes_tributarias.cst',
            1 => 'situacoes_tributarias.descricao',
            2 => 'situacoes_tributarias.tabela',
            3 => 'situacoes_tributarias.operacao',
            4 => 'situacoes_tributarias.active',
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

        $situacaos = $this->situacaoModel->getCSTs($params_array);
        $rowsTotal = $this->situacaoModel->countCSTs($search);

        $rows = 0;
        $data = array();

        foreach ($situacaos as $situacao) {
            $act_view  = '<button data-toggle="tooltip" data-original-title="Visualizar CST / CSOSN" title="Visualizar CST / CSOSN" data-id="' . $situacao->id . '" data-modulo="view" class="btn btn-xs btn-default text-primary btn-width-27 btn-view"><i class="fa fa-eye"></i></button>';
            $act_edit  = '<button data-toggle="tooltip" data-original-title="Editar CST / CSOSN" title="Editar CST / CSOSN" data-id="' . $situacao->id . '" data-modulo="edit" class="btn btn-xs btn-default btn-width-27 btn-edit"><i class="fas fa-edit"></i></button>';

            $sub_array = array();

            $sub_array[] = $situacao->cst;
            $sub_array[] = $situacao->descricao;
            $sub_array[] = $situacao->tabelaControl();
            $sub_array[] = $situacao->operacaoControl();
            $sub_array[] = ($situacao->active == true ? '<span class="btn btn-xs btn-default rounded-circle-custom text-success" data-toggle="tooltip" data-original-title="Ativo"><i class="fa fa-unlock" title="Ativo"></i></span>' : '<span class="btn btn-xs btn-default rounded-circle-custom text-danger" data-toggle="tooltip" data-original-title="Inativo"><i class="fa fa-lock" title="Inativo"></i></span>');
            $sub_array[] = $act_view . $act_edit . $situacao->buttonsControl();

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
     * Método que retorna a view de inclusão de Situação Tributária
     * 
     * @return view
     */
    public function add()
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('listar-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $situacao = new SituacaoTributaria();

        $data = array(
            'title'    => 'Nova Situação Tributária',
            'method'   => 'insert',
            'viewpath' => APP_THEME . $this->viewFolder,
            'form'     => 'form',
            'response' => 'response',
            'table'    => $situacao,
        );

        // return view($this->viewFolder . '/_add', $data);
        return view(APP_THEME . '/layout/modals/_modal', $data);
    }

    /**
     * Método que faz o insert dos dados da Situação Tributária
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

        $situacao = new SituacaoTributaria($post);

        try {
            $this->db->transStart(); // Inicia a transação

            // Insere o depósito
            if (!$this->situacaoModel->protect(false)->insert($situacao, true)) {
                throw new \Exception('Erro ao inserir a situação tributária.');
            }

            $situacao_id = $this->situacaoModel->getInsertID();

            $this->db->transComplete(); // Finaliza a transação

            if ($this->db->transStatus() === false) {
                throw new \Exception('Erro ao completar a transação.');
            }

            if (!$this->situacaoModel->errors()) {
                $return['success'] = 'Dados salvos com sucesso!';
            } else {
                $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
                $return['errors_model'] = $this->situacaoModel->errors();
            }

            $return['id'] = $situacao_id;

            return $this->response->setJSON($return);
        } catch (\Exception $e) {
            $this->db->transRollback(); // Reverte as mudanças em caso de erro

            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $e->getMessage();

            return $this->response->setJSON($return);
        }
    }

    /**
     * Método que retorna a view de edição dos dados da Situação Tributária
     * 
     * @param $id
     * @return view
     */
    public function edit(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('editar-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $situacao = $this->validation_situacao($id);

        $data = array(
            'title'    => 'Editar Situação Tributária',
            'method'   => 'update',
            'viewpath' => APP_THEME . $this->viewFolder,
            'form'     => 'form',
            'response' => 'response',
            'table'    => $situacao,
        );

        // return view($this->viewFolder . '/_edit', $data);
        return view(APP_THEME . '/layout/modals/_modal', $data);
    }

    /**
     * Método que faz o update dos dados da Situação Tributária
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

            $situacao = $this->validation_situacao($post['id']);
            $situacao->fill($post);

            if ($situacao->hasChanged()) {
                $this->situacaoModel->protect(false)->save($situacao);
            }

            $this->db->transComplete(); // Finaliza a transação

            if ($this->db->transStatus() === false) {
                throw new \Exception('Erro ao salvar os dados.');
            }

            if (!$this->situacaoModel->errors()) {
                $return['success'] = 'Dados salvos com sucesso!';
            } else {
                $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
                $return['errors_model'] = $this->situacaoModel->errors();
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
     * Método que retorna a view de deleção da Situação Tributária
     * 
     * @param $id
     * @return view
     */
    public function delete(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('excluir-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $situacao = $this->validation_situacao($id);

        $data = array(
            'title'    => 'Excluir',
            'method'   => 'delete',
            'situacao' => $situacao,
        );

        return view($this->viewFolder . '/_delete', $data);
    }

    /**
     * Método que faz a deleção da Situação Tributária
     * 
     * @param $id
     * @return redirect
     */
    public function remove(int $id = null)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $situacao = $this->validation_situacao($id);

        $this->situacaoModel->delete($situacao->id);

        $situacao->active = false;

        $this->situacaoModel->protect(false)->save($situacao);

        if (!$this->situacaoModel->errors()) {
            $return['success'] = 'Removido com sucesso!';
        } else {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $this->situacaoModel->errors();
        }

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view de restore da Situação Tributária
     * 
     * @param $id
     * @return view
     */
    public function undo(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('excluir-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $situacao = $this->validation_situacao($id);

        $data = [
            'title'    => 'Restaurar',
            'method'   => 'restore',
            'situacao' => $situacao,
        ];

        return view($this->viewFolder . '/_restore', $data);
    }

    /**
     * Método que faz o restore da Situação Tributária
     * 
     * @param $id
     * @return redirect
     */
    public function restore(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('editar-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $situacao = $this->validation_situacao($id);

        $situacao->deleted_at = null;
        $situacao->active = true;

        $this->situacaoModel->protect(false)->save($situacao);

        if (!$this->situacaoModel->errors()) {
            $return['success'] = 'Restaurado com sucesso!';
        } else {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $this->situacaoModel->errors();
        }

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view de visualização dos dados da Situação Tributária
     * 
     * @param $id
     * @return view
     */
    public function show(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('listar-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $situacao = $this->validation_situacao($id);

        $data = array(
            'title'    => 'Visualizar',
            'situacao' => $situacao,
        );

        return view($this->viewFolder . '/_show', $data);
    }
}
