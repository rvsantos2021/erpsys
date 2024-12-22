<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\CFOP;

class CFOPs extends BaseController
{
    protected $db;
    protected $cfopModel;

    private $viewFolder = '/cadastros/fiscais/cfops';
    private $route = 'cfops';

    /**
     * Método que valida se o CFOP existe. Caso exista retorna um object com os dados do CFOP, caso
     * não exista, retorna um Exception
     * 
     * @param integer $id
     * @return Object ou Exception
     */
    private function validation_cfop(int $id = null)
    {
        if (!$id || !$cfop = $this->cfopModel->withDeleted(true)->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("CFOP ID: $id não encontrado!");
        }

        return $cfop;
    }

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->cfopModel = new \App\Models\CFOPModel();
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
            'title'   => "CFOP's",
        );

        return view($this->viewFolder . '/list', $data);
    }

    /**
     * Metodo chamado via AJAX que retorna um JSON com os dados de todos os CFOPs
     * 
     * @return JSON
     */
    public function fetch()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $columns = array(
            0 => 'cfops.cfop',
            1 => 'cfops.descricao',
            2 => 'cfops.origem_destino',
            3 => 'cfops.active',
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

        $cfops = $this->cfopModel->getCFOPs($params_array);
        $rowsTotal = $this->cfopModel->countCFOPs($search);

        $rows = 0;
        $data = array();

        foreach ($cfops as $cfop) {
            $act_view  = '<button data-toggle="tooltip" data-original-title="Visualizar CFOP" title="Visualizar CFOP" data-id="' . $cfop->id . '" data-modulo="view" class="btn btn-xs btn-default text-primary btn-width-27 btn-view"><i class="fa fa-eye"></i></button>';
            $act_edit  = '<button data-toggle="tooltip" data-original-title="Editar CFOP" title="Editar CFOP" data-id="' . $cfop->id . '" data-modulo="edit" class="btn btn-xs btn-default btn-width-27 btn-edit"><i class="fas fa-edit"></i></button>';

            $sub_array = array();

            $sub_array[] = $cfop->cfop;
            $sub_array[] = $cfop->descricao;
            $sub_array[] = ($cfop->origem_destino == 'D' ? 'MESMO ESTADO' : ($cfop->origem_destino == 'F' ? 'OUTRO ESTADO' : ''));
            $sub_array[] = ($cfop->active == true ? '<span class="btn btn-xs btn-default rounded-circle-custom text-success" data-toggle="tooltip" data-original-title="Ativo"><i class="fa fa-unlock" title="Ativo"></i></span>' : '<span class="btn btn-xs btn-default rounded-circle-custom text-danger" data-toggle="tooltip" data-original-title="Inativo"><i class="fa fa-lock" title="Inativo"></i></span>');
            $sub_array[] = $act_view . $act_edit . $cfop->buttonsControl();

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
     * Método que retorna a view de inclusão de CFOP
     * 
     * @return view
     */
    public function add()
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('listar-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $cfop = new CFOP();

        $data = array(
            'title'    => 'Novo CFOP',
            'method'   => 'insert',
            'viewpath' => APP_THEME . $this->viewFolder,
            'table'    => $cfop,
            'form'     => 'form',
            'response' => 'response',
        );

        // return view($this->viewFolder . '/_add', $data);
        return view(APP_THEME . '/layout/modals/_modal', $data);
    }

    /**
     * Método que faz o insert dos dados do CFOP
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

        $cfop = new CFOP($post);

        try {
            $this->db->transStart(); // Inicia a transação

            // Insere o CFOP
            if (!$this->cfopModel->protect(false)->insert($cfop, true)) {
                throw new \Exception('Erro ao inserir o CFOP.');
            }

            $cfop_id = $this->cfopModel->getInsertID();

            $this->db->transComplete(); // Finaliza a transação

            if ($this->db->transStatus() === false) {
                throw new \Exception('Erro ao completar a transação.');
            }

            if (!$this->cfopModel->errors()) {
                $return['success'] = 'Dados salvos com sucesso!';
            } else {
                $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
                $return['errors_model'] = $this->cfopModel->errors();
            }

            $return['id'] = $cfop_id;

            return $this->response->setJSON($return);
        } catch (\Exception $e) {
            $this->db->transRollback(); // Reverte as mudanças em caso de erro

            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $e->getMessage();

            return $this->response->setJSON($return);
        }
    }

    /**
     * Método que retorna a view de edição dos dados do CFOP
     * 
     * @param $id
     * @return view
     */
    public function edit(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('editar-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $cfop = $this->validation_cfop($id);

        $data = array(
            'title'    => 'Editar CFOP',
            'method'   => 'update',
            'viewpath' => APP_THEME . $this->viewFolder,
            'table'    => $cfop,
            'form'     => 'form',
            'response' => 'response',
        );

        // return view($this->viewFolder . '/_edit', $data);
        return view(APP_THEME . '/layout/modals/_modal', $data);
    }

    /**
     * Método que faz o update dos dados do CFOP
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

            $cfop = $this->validation_cfop($post['id']);
            $cfop->fill($post);

            if ($cfop->hasChanged()) {
                $this->cfopModel->protect(false)->save($cfop);
            }

            $this->db->transComplete(); // Finaliza a transação

            if ($this->db->transStatus() === false) {
                throw new \Exception('Erro ao salvar os dados.');
            }

            if (!$this->cfopModel->errors()) {
                $return['success'] = 'Dados salvos com sucesso!';
            } else {
                $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
                $return['errors_model'] = $this->cfopModel->errors();
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
     * Método que retorna a view de deleção do CFOP
     * 
     * @param $id
     * @return view
     */
    public function delete(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('excluir-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $cfop = $this->validation_cfop($id);

        $data = array(
            'title'  => 'Excluir',
            'method' => 'delete',
            'cfop'   => $cfop,
        );

        return view($this->viewFolder . '/_delete', $data);
    }

    /**
     * Método que faz a deleção do CFOP
     * 
     * @param $id
     * @return redirect
     */
    public function remove(int $id = null)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $cfop = $this->validation_cfop($id);

        $this->cfopModel->delete($cfop->id);

        $cfop->active = false;

        $this->cfopModel->protect(false)->save($cfop);

        if (!$this->cfopModel->errors()) {
            $return['success'] = 'Removido com sucesso!';
        } else {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $this->cfopModel->errors();
        }

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view de restore da CFOP
     * 
     * @param $id
     * @return view
     */
    public function undo(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('excluir-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $cfop = $this->validation_cfop($id);

        $data = [
            'title'  => 'Restaurar',
            'method' => 'restore',
            'cfop'   => $cfop,
        ];

        return view($this->viewFolder . '/_restore', $data);
    }

    /**
     * Método que faz o restore do CFOP
     * 
     * @param $id
     * @return redirect
     */
    public function restore(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('editar-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $cfop = $this->validation_cfop($id);

        $cfop->deleted_at = null;
        $cfop->active = true;

        $this->cfopModel->protect(false)->save($cfop);

        if (!$this->cfopModel->errors()) {
            $return['success'] = 'Restaurado com sucesso!';
        } else {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $this->cfopModel->errors();
        }

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view de visualização dos dados do CFOP
     * 
     * @param $id
     * @return view
     */
    public function show(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('listar-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $cfop = $this->validation_cfop($id);

        $data = array(
            'title' => 'Visualizar',
            'cfop'  => $cfop,
        );

        return view($this->viewFolder . '/_show', $data);
    }
}
