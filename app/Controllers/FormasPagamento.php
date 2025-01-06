<?php

namespace App\Controllers;

use App\Entities\FormaPagamento;

class FormasPagamento extends BaseController
{
    protected $db;
    protected $formaModel;

    private $viewFolder = '/cadastros/financeiro/formas_pagto';
    private $route = 'formas';

    /**
     * Método que valida se a forma de pagamento existe. Caso exista retorna um object com os dados da forma de pagamento, caso
     * não exista, retorna um Exception.
     *
     * @param int $id
     *
     * @return object ou Exception
     */
    private function validation_forma(int $id = null)
    {
        if (!$id || !$forma = $this->formaModel->withDeleted(true)->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Forma de Pagamento ID: $id não encontrada!");
        }

        return $forma;
    }

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->formaModel = new \App\Models\FormaPagamentoModel();
    }

    /**
     * Método que retorna a view com todos os registros da tabela.
     *
     * @return view
     */
    public function index()
    {
        if ($this->getLoggedUserData() == '') {
            return redirect()->to(site_url('login'))->with('message-info', 'Verifique suas credenciais e tente novamente!');
        }

        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('listar-'.$this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>'.$this->getLoggedUserData()->name.'</b> não possui permissão para acessar este módulo.');
        }

        $data = [
            'menu' => 'Financeiro',
            'submenu' => 'Cadastros',
            'title' => 'Formas de Pagamento',
        ];

        return view(APP_THEME.$this->viewFolder.'/list', $data);
    }

    /**
     * Metodo chamado via AJAX que retorna um JSON com os dados de todos as formas de pagamento.
     *
     * @return JSON
     */
    public function fetch()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $columns = [
            0 => 'formas_pagamento.id',
            1 => 'formas_pagamento.nome',
            2 => 'formas_pagamento.financeiro',
            3 => 'formas_pagamento.desconto',
            4 => 'formas_pagamento.contas_receber',
            5 => 'formas_pagamento.contas_pagar',
            6 => 'formas_pagamento.active',
        ];

        $draw = isset($_POST['draw']) ? (int) $_POST['draw'] : 10;
        $start = isset($_POST['start']) ? (int) $_POST['start'] : 0;
        $rowPerPage = isset($_POST['length']) ? (int) $_POST['length'] : 10;
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

        $params_array = [
            'start' => $start,
            'rowperpage' => $rowPerPage,
            'search' => $search,
            'order' => $columns[$orderColumn],
            'dir' => $orderDir,
        ];

        $formas = $this->formaModel->getFormasPagamento($params_array);
        $rowsTotal = $this->formaModel->countFormasPagamento($search);

        $rows = 0;
        $data = [];

        foreach ($formas as $forma) {
            if (APP_THEME == 'mentor') {
                $act_view = '<button title="Visualizar Forma de Pagamento" data-id="'.$forma->id.'" data-modulo="view" class="btn btn-sm btn-icon btn-outline-dark btn-round btn-view"><i class="ti ti-eye"></i></button>';
                $act_edit = '<button title="Editar Forma de Pagamento" data-id="'.$forma->id.'" data-modulo="edit" class="btn btn-sm btn-icon btn-outline-primary btn-round btn-edit"><i class="ti ti-pencil"></i></button>';

                $status = ($forma->active == true ? '<span class="btn btn-sm btn-icon btn-round btn-inverse-success"><i class="ti ti-unlock" title="Ativo"></i></span>' : '<span class="btn btn-sm btn-icon btn-round btn-inverse-danger"><i class="ti ti-lock" title="Inativo"></i></span>');
            } else {
                $act_view = '<button data-toggle="tooltip" data-original-title="Visualizar" title="Visualizar" data-id="'.$forma->id.'" data-modulo="view" class="btn btn-xs btn-default text-primary btn-width-27 btn-view"><i class="fa fa-eye"></i></button>';
                $act_edit = '<button data-toggle="tooltip" data-original-title="Editar" title="Editar" data-id="'.$forma->id.'" data-modulo="edit" class="btn btn-xs btn-default btn-width-27 btn-edit"><i class="fas fa-edit"></i></button>';

                $status = ($forma->active == true ? '<span class="btn btn-xs btn-default rounded-circle-custom text-success" data-toggle="tooltip" data-original-title="Ativo"><i class="fa fa-unlock" title="Ativo"></i></span>' : '<span class="btn btn-xs btn-default rounded-circle-custom text-danger" data-toggle="tooltip" data-original-title="Inativo"><i class="fa fa-lock" title="Inativo"></i></span>');
            }

            $sub_array = [];

            $sub_array[] = $forma->id;
            $sub_array[] = $forma->nome;
            $sub_array[] = ($forma->financeiro == true ? '<span class="btn btn-xs btn-default rounded-circle-custom text-success" data-toggle="tooltip" data-original-title="Sim"><i class="fa fa-check" title="Sim"></i></span>' : '<span class="btn btn-xs btn-default rounded-circle-custom text-danger" data-toggle="tooltip" data-original-title="Não"><i class="fa fa-times" title="Não"></i></span>');
            $sub_array[] = ($forma->desconto == true ? '<span class="btn btn-xs btn-default rounded-circle-custom text-success" data-toggle="tooltip" data-original-title="Sim"><i class="fa fa-check" title="Sim"></i></span>' : '<span class="btn btn-xs btn-default rounded-circle-custom text-danger" data-toggle="tooltip" data-original-title="Não"><i class="fa fa-times" title="Não"></i></span>');
            $sub_array[] = ($forma->contas_receber == true ? '<span class="btn btn-xs btn-default rounded-circle-custom text-success" data-toggle="tooltip" data-original-title="Sim"><i class="fa fa-check" title="Sim"></i></span>' : '<span class="btn btn-xs btn-default rounded-circle-custom text-danger" data-toggle="tooltip" data-original-title="Não"><i class="fa fa-times" title="Não"></i></span>');
            $sub_array[] = ($forma->contas_pagar == true ? '<span class="btn btn-xs btn-default rounded-circle-custom text-success" data-toggle="tooltip" data-original-title="Sim"><i class="fa fa-check" title="Sim"></i></span>' : '<span class="btn btn-xs btn-default rounded-circle-custom text-danger" data-toggle="tooltip" data-original-title="Não"><i class="fa fa-times" title="Não"></i></span>');
            $sub_array[] = $status;
            $sub_array[] = $act_view.$act_edit.$forma->buttonsControl();

            $data[] = $sub_array;
            ++$rows;
        }

        $json = [
            'draw' => intval($draw),
            'recordsTotal' => intval($rowsTotal),
            'recordsFiltered' => intval($rowsTotal),
            'data' => $data,
        ];

        echo json_encode($json);
    }

    /**
     * Método que retorna a view de inclusão de forma de pagamento.
     *
     * @return view
     */
    public function add()
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('listar-'.$this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>'.$this->getLoggedUserData()->name.'</b> não possui permissão para acessar este módulo.');
        }

        $forma = new FormaPagamento();

        $data = [
            'title' => 'Nova Forma de Pagamento',
            'method' => 'insert',
            'viewpath' => APP_THEME.$this->viewFolder,
            'form' => 'form',
            'response' => 'response',
            'table' => $forma,
        ];

        return view(APP_THEME.'/layout/modals/_modal', $data);
    }

    /**
     * Método que faz o insert dos dados da forma de pagamento.
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

        if (isset($post['financeiro'])) {
            $post['financeiro'] = ($post['financeiro'] == 'on' ? true : false);
        } else {
            $post['financeiro'] = false;
        }

        if (isset($post['desconto'])) {
            $post['desconto'] = ($post['desconto'] == 'on' ? true : false);
        } else {
            $post['desconto'] = false;
        }

        if (isset($post['contas_pagar'])) {
            $post['contas_pagar'] = ($post['contas_pagar'] == 'on' ? true : false);
        } else {
            $post['contas_pagar'] = false;
        }

        if (isset($post['contas_receber'])) {
            $post['contas_receber'] = ($post['contas_receber'] == 'on' ? true : false);
        } else {
            $post['contas_receber'] = false;
        }

        // Limpa os dados desnecessários do POST
        $fields_to_unset = [
            'method',
        ];

        foreach ($fields_to_unset as $field) {
            unset($post[$field]);
        }

        $forma = new FormaPagamento($post);

        try {
            $this->db->transStart(); // Inicia a transação

            // Insere a forma de pagamento
            if (!$this->formaModel->protect(false)->insert($forma, true)) {
                throw new \Exception('Erro ao inserir a forma de pagamento.');
            }

            $forma_id = $this->formaModel->getInsertID();

            $this->db->transComplete(); // Finaliza a transação

            if ($this->db->transStatus() === false) {
                throw new \Exception('Erro ao completar a transação.');
            }

            if (!$this->formaModel->errors()) {
                $return['success'] = 'Dados salvos com sucesso!';
            } else {
                $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
                $return['errors_model'] = $this->formaModel->errors();
            }

            $return['id'] = $forma_id;

            return $this->response->setJSON($return);
        } catch (\Exception $e) {
            $this->db->transRollback(); // Reverte as mudanças em caso de erro

            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $e->getMessage();

            return $this->response->setJSON($return);
        }
    }

    /**
     * Método que retorna a view de edição dos dados da forma de pagamento.
     *
     * @param $id
     *
     * @return view
     */
    public function edit(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('editar-'.$this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>'.$this->getLoggedUserData()->name.'</b> não possui permissão para acessar este módulo.');
        }

        $forma = $this->validation_forma($id);

        $data = [
            'title' => 'Editar Forma de Pagamento',
            'method' => 'update',
            'viewpath' => APP_THEME.$this->viewFolder,
            'form' => 'form',
            'response' => 'response',
            'table' => $forma,
        ];

        return view(APP_THEME.'/layout/modals/_modal', $data);
    }

    /**
     * Método que faz o update dos dados da forma de pagamento.
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

        if (isset($post['financeiro'])) {
            $post['financeiro'] = ($post['financeiro'] == 'on' ? true : false);
        } else {
            $post['financeiro'] = false;
        }

        if (isset($post['desconto'])) {
            $post['desconto'] = ($post['desconto'] == 'on' ? true : false);
        } else {
            $post['desconto'] = false;
        }

        if (isset($post['contas_pagar'])) {
            $post['contas_pagar'] = ($post['contas_pagar'] == 'on' ? true : false);
        } else {
            $post['contas_pagar'] = false;
        }

        if (isset($post['contas_receber'])) {
            $post['contas_receber'] = ($post['contas_receber'] == 'on' ? true : false);
        } else {
            $post['contas_receber'] = false;
        }

        // Limpa os dados desnecessários do POST
        $fields_to_unset = [
            'method',
        ];

        foreach ($fields_to_unset as $field) {
            unset($post[$field]);
        }

        try {
            $this->db->transStart(); // Inicia a transação

            $forma = $this->validation_forma($post['id']);
            $forma->fill($post);

            if ($forma->hasChanged()) {
                $this->formaModel->protect(false)->save($forma);
            }

            $this->db->transComplete(); // Finaliza a transação

            if ($this->db->transStatus() === false) {
                throw new \Exception('Erro ao salvar os dados.');
            }

            if (!$this->formaModel->errors()) {
                $return['success'] = 'Dados salvos com sucesso!';
            } else {
                $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
                $return['errors_model'] = $this->formaModel->errors();
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
     * Método que retorna a view de deleção da forma de pagamento.
     *
     * @param $id
     *
     * @return view
     */
    public function delete(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('excluir-'.$this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>'.$this->getLoggedUserData()->name.'</b> não possui permissão para acessar este módulo.');
        }

        $forma = $this->validation_forma($id);

        $data = [
            'title' => 'Excluir',
            'method' => 'delete',
            'table' => $forma,
        ];

        return view(APP_THEME.$this->viewFolder.'/_delete', $data);
    }

    /**
     * Método que faz a deleção da forma de pagamento.
     *
     * @param $id
     *
     * @return redirect
     */
    public function remove(int $id = null)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $forma = $this->validation_forma($id);

        $this->formaModel->delete($forma->id);

        $forma->active = false;

        $this->formaModel->protect(false)->save($forma);

        if (!$this->formaModel->errors()) {
            $return['success'] = 'Removido com sucesso!';
        } else {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $this->formaModel->errors();
        }

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view de restore da forma de pagamento.
     *
     * @param $id
     *
     * @return view
     */
    public function undo(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('excluir-'.$this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>'.$this->getLoggedUserData()->name.'</b> não possui permissão para acessar este módulo.');
        }

        $forma = $this->validation_forma($id);

        $data = [
            'title' => 'Restaurar',
            'method' => 'restore',
            'table' => $forma,
        ];

        return view(APP_THEME.$this->viewFolder.'/_restore', $data);
    }

    /**
     * Método que faz o restore da forma de pagamento.
     *
     * @param $id
     *
     * @return redirect
     */
    public function restore(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('editar-'.$this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>'.$this->getLoggedUserData()->name.'</b> não possui permissão para acessar este módulo.');
        }

        $forma = $this->validation_forma($id);

        $forma->deleted_at = null;
        $forma->active = true;

        $this->formaModel->protect(false)->save($forma);

        if (!$this->formaModel->errors()) {
            $return['success'] = 'Restaurado com sucesso!';
        } else {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $this->formaModel->errors();
        }

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view de visualização dos dados da forma de pagamento.
     *
     * @param $id
     *
     * @return view
     */
    public function show(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('listar-'.$this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>'.$this->getLoggedUserData()->name.'</b> não possui permissão para acessar este módulo.');
        }

        $forma = $this->validation_forma($id);

        $data = [
            'title' => 'Visualizar',
            'table' => $forma,
        ];

        return view(APP_THEME.$this->viewFolder.'/_show', $data);
    }
}
