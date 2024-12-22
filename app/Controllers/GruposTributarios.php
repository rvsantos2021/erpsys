<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\GrupoTributario;

class GruposTributarios extends BaseController
{
    protected $db;
    protected $grupoModel;

    private $viewFolder = '/cadastros/fiscais/grupos_tributarios';
    private $route = 'grupostributarios';

    /**
     * Método que valida se o grupo existe. Caso exista retorna um object com os dados do grupo, caso
     * não exista, retorna um Exception
     * 
     * @param integer $id
     * @return Object ou Exception
     */
    private function validation_grupo(int $id = null)
    {
        if (!$id || !$grupo = $this->grupoModel->withDeleted(true)->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Grupo ID: $id não encontrado!");
        }

        return $grupo;
    }

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->grupoModel = new \App\Models\GrupoTributarioModel();
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
            'title'   => 'Grupos Tributários',
        );

        return view($this->viewFolder . '/list', $data);
    }

    /**
     * Metodo chamado via AJAX que retorna um JSON com os dados de todos os grupos
     * 
     * @return JSON
     */
    public function fetch()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $columns = array(
            0 => 'grupos_tributarios.id',
            1 => 'grupos_tributarios.descricao',
            2 => 'grupos_tributarios.cst',
            3 => 'grupos_tributarios.tipo_grupo',
            4 => 'grupos_tributarios.aliquota',
            5 => 'grupos_tributarios.reducao',
            6 => 'grupos_tributarios.active',
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

        $grupos = $this->grupoModel->getGruposTributarios($params_array);
        $rowsTotal = $this->grupoModel->countGruposTributarios($search);

        $rows = 0;
        $data = array();

        foreach ($grupos as $grupo) {
            $act_view  = '<button data-toggle="tooltip" data-original-title="Visualizar Grupo" title="Visualizar Grupo" data-id="' . $grupo->id . '" data-modulo="view" class="btn btn-xs btn-default text-primary btn-width-27 btn-view"><i class="fa fa-eye"></i></button>';
            $act_edit  = '<button data-toggle="tooltip" data-original-title="Editar Grupo" title="Editar Grupo" data-id="' . $grupo->id . '" data-modulo="edit" class="btn btn-xs btn-default btn-width-27 btn-edit"><i class="fas fa-edit"></i></button>';

            $sub_array = array();

            $sub_array[] = $grupo->id;
            $sub_array[] = $grupo->descricao;
            $sub_array[] = $grupo->cst;
            $sub_array[] = $grupo->tipo_grupo;
            $sub_array[] = '<span class="float-right mr-4">' . formatPercent($grupo->aliquota, true, 2) . '</span>';
            $sub_array[] = '<span class="float-right mr-4">' . formatPercent($grupo->reducao, true, 2) . '</span>';
            $sub_array[] = ($grupo->active == true ? '<span class="btn btn-xs btn-default rounded-circle-custom text-success" data-toggle="tooltip" data-original-title="Ativo"><i class="fa fa-unlock" title="Ativo"></i></span>' : '<span class="btn btn-xs btn-default rounded-circle-custom text-danger" data-toggle="tooltip" data-original-title="Inativo"><i class="fa fa-lock" title="Inativo"></i></span>');
            $sub_array[] = $act_view . $act_edit . $grupo->buttonsControl();

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
     * Método que retorna a view de inclusão de grupo
     * 
     * @return view
     */
    public function add()
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('listar-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $grupo = new GrupoTributario();

        $data = array(
            'title'    => 'Novo Grupo Tributário',
            'method'   => 'insert',
            'viewpath' => APP_THEME . $this->viewFolder,
            'table'    => $grupo,
            'form'     => 'form',
            'response' => 'response',
        );

        // return view($this->viewFolder . '/_add', $data);
        return view(APP_THEME . '/layout/modals/_modal', $data);
    }

    /**
     * Método que retorna a view de inclusão de grupo
     * 
     * @return view
     */
    public function add_modal()
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('listar-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $grupo = new GrupoTributario();

        $data = array(
            'title'    => 'Novo Grupo',
            'method'   => 'insert',
            'viewpath' => APP_THEME . $this->viewFolder,
            'form'     => 'formAddGrupo',
            'response' => 'responseGrupo',
            'table'    => $grupo,
        );

        // return view($this->viewFolder . '/_add', $data);
        return view(APP_THEME . '/layout/modals/_modal', $data);
    }

    /**
     * Método que faz o insert dos dados do grupo
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

        $grupo = new GrupoTributario($post);

        try {
            $this->db->transStart(); // Inicia a transação

            // Insere o grupo
            if (!$this->grupoModel->protect(false)->insert($grupo, true)) {
                throw new \Exception('Erro ao inserir o grupo.');
            }

            $grupo_id = $this->grupoModel->getInsertID();

            $this->db->transComplete(); // Finaliza a transação

            if ($this->db->transStatus() === false) {
                throw new \Exception('Erro ao completar a transação.');
            }

            if (!$this->grupoModel->errors()) {
                $return['success'] = 'Dados salvos com sucesso!';
            } else {
                $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
                $return['errors_model'] = $this->grupoModel->errors();
            }

            $return['id'] = $grupo_id;

            return $this->response->setJSON($return);
        } catch (\Exception $e) {
            $this->db->transRollback(); // Reverte as mudanças em caso de erro

            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $e->getMessage();

            return $this->response->setJSON($return);
        }
    }

    /**
     * Método que retorna a view de edição dos dados do grupo
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

        $grupo = $this->validation_grupo($id);

        $data = array(
            'title'    => 'Editar Grupo Tributário',
            'method'   => 'update',
            'viewpath' => APP_THEME . $this->viewFolder,
            'form'     => 'form',
            'response' => 'response',
            'table'    => $grupo,
        );

        // return view($this->viewFolder . '/_edit', $data);
        return view(APP_THEME . '/layout/modals/_modal', $data);
    }

    /**
     * Método que faz o update dos dados do grupo
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

            $grupo = $this->validation_grupo($post['id']);
            $grupo->fill($post);

            if ($grupo->hasChanged()) {
                $this->grupoModel->protect(false)->save($grupo);
            }

            $this->db->transComplete(); // Finaliza a transação

            if ($this->db->transStatus() === false) {
                throw new \Exception('Erro ao salvar os dados.');
            }

            if (!$this->grupoModel->errors()) {
                $return['success'] = 'Dados salvos com sucesso!';
            } else {
                $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
                $return['errors_model'] = $this->grupoModel->errors();
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
     * Método que retorna a view de deleção do grupo
     * 
     * @param $id
     * @return view
     */
    public function delete(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('excluir-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $grupo = $this->validation_grupo($id);

        $data = array(
            'title'  => 'Excluir',
            'method' => 'delete',
            'grupo'  => $grupo,
        );

        return view($this->viewFolder . '/_delete', $data);
    }

    /**
     * Método que faz a deleção do grupo
     * 
     * @param $id
     * @return redirect
     */
    public function remove(int $id = null)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $grupo = $this->validation_grupo($id);

        $this->grupoModel->delete($grupo->id);

        $grupo->active = false;

        $this->grupoModel->protect(false)->save($grupo);

        if (!$this->grupoModel->errors()) {
            $return['success'] = 'Removido com sucesso!';
        } else {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $this->grupoModel->errors();
        }

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view de restore do grupo
     * 
     * @param $id
     * @return view
     */
    public function undo(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('excluir-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $grupo = $this->validation_grupo($id);

        $data = [
            'title'  => 'Restaurar',
            'method' => 'restore',
            'grupo'  => $grupo,
        ];

        return view($this->viewFolder . '/_restore', $data);
    }

    /**
     * Método que faz o restore do grupo
     * 
     * @param $id
     * @return redirect
     */
    public function restore(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('editar-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $grupo = $this->validation_grupo($id);

        $grupo->deleted_at = null;
        $grupo->active = true;

        $this->grupoModel->protect(false)->save($grupo);

        if (!$this->grupoModel->errors()) {
            $return['success'] = 'Restaurado com sucesso!';
        } else {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $this->grupoModel->errors();
        }

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view de visualização dos dados do grupo
     * 
     * @param $id
     * @return view
     */
    public function show(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('listar-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $grupo = $this->validation_grupo($id);

        $data = array(
            'title' => 'Visualizar',
            'grupo' => $grupo,
        );

        return view($this->viewFolder . '/_show', $data);
    }
}
