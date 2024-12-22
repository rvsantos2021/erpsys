<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Permission;

class Permissions extends BaseController
{
    private $permissionModel;
    private $viewFolder = '/cadastros/acessos/permissoes';
    private $route = 'permissoes';

    /**
     * Método que valida se o permissao existe. Caso exista retorna um object com os dados da permissão, caso
     * não exista, retorna um Exception
     * 
     * @param integer $id
     * @return Object ou Exception
     */
    private function validation_permission(int $id = null)
    {
        if (!$id || !$permission = $this->permissionModel->withDeleted(true)->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Permissão de Acesso ID: $id não encontrada!");
        }

        return $permission;
    }

    public function __construct()
    {
        $this->permissionModel = new \App\Models\PermissionModel();
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
            'menu'  => 'Acessos',
            'title' => 'Permissões de Acesso',
        );

        return view(APP_THEME . $this->viewFolder . '/list', $data);
    }

    /**
     * Metodo chamado via AJAX que retorna um JSON com os dados de todas as permissões de acesso
     * 
     * @return JSON
     */
    public function fetch()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $columns = array(
            0 => 'permissions.id',
            1 => 'permissions.name',
            2 => 'permissions.description',
            3 => 'permissions.active',
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

        $permissions = $this->permissionModel->getPermissions($params_array);
        $rowsTotal = $this->permissionModel->countPermissions($search);

        $rows = 0;
        $data = array();

        foreach ($permissions as $permission) {
            if (APP_THEME == 'mentor') {
                $act_view  = '<button title="Visualizar Permissão de Acesso" data-id="' . $permission->id . '" data-modulo="view" class="btn btn-sm btn-icon btn-outline-dark btn-round btn-view"><i class="ti ti-eye"></i></button>';
                $act_edit  = '<button title="Editar Permissão de Acesso" data-id="' . $permission->id . '" data-modulo="edit" class="btn btn-sm btn-icon btn-outline-primary btn-round btn-edit"><i class="ti ti-pencil"></i></button>';

                $status = ($permission->active == true ? '<span class="btn btn-sm btn-icon btn-round btn-inverse-success"><i class="ti ti-unlock" title="Ativo"></i></span>' : '<span class="btn btn-sm btn-icon btn-round btn-inverse-danger"><i class="ti ti-lock" title="Inativo"></i></span>');
            } else {
                $act_view  = '<button data-toggle="tooltip" data-original-title="Visualizar" title="Visualizar" data-id="' . $permission->id . '" data-modulo="view" class="btn btn-xs btn-default text-primary btn-width-27 btn-view"><i class="fa fa-eye"></i></button>';
                $act_edit  = '<button data-toggle="tooltip" data-original-title="Editar" title="Editar" data-id="' . $permission->id . '" data-modulo="edit" class="btn btn-xs btn-default btn-width-27 btn-edit"><i class="fas fa-edit"></i></button>';

                $status = ($permission->active == true ? '<span class="text-success"><i class="fa fa-unlock" title="Ativo"></i></span>' : '<span class="text-danger"><i class="fa fa-lock" title="Inativo"></i></span>');
            }

            $sub_array = array();

            $sub_array[] = $permission->id;
            $sub_array[] = $permission->name;
            $sub_array[] = $permission->description;
            $sub_array[] = $status;
            $sub_array[] = $act_view . $act_edit . $permission->buttonsControl();

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
     * Método que retorna a view de inclusão de permissão de acesso
     * 
     * @return view
     */
    public function add()
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('criar-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $permission = new Permission();

        $data = array(
            'menu'     => 'Acessos',
            'title'    => 'Inclusão',
            'method'   => 'insert',
            'viewpath' => APP_THEME . $this->viewFolder,
            'form'     => 'form',
            'response' => 'response',
            'table'    => $permission,
        );

        // return view(APP_THEME . $this->viewFolder . '/_add', $data);
        return view(APP_THEME . '/layout/modals/_modal', $data);
    }

    /**
     * Método que faz o insert dos dados da permissão de acesso
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

        unset($post['method']);

        $post['active'] = true;

        $permission = new Permission($post);

        if ($this->permissionModel->protect(false)->insert($permission, false)) {
            session()->setFlashdata('message-success', 'Dados salvos com sucesso!');

            $return['success'] = 'Dados salvos com sucesso!';
            $return['id'] = $this->permissionModel->getInsertID();

            return $this->response->setJSON($return);
        }

        $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
        $return['errors_model'] = $this->permissionModel->errors();

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view de edição dos dados da permissão de acesso
     * 
     * @param $id
     * @return view
     */
    public function edit(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('editar-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $permission = $this->validation_permission($id);

        $data = array(
            'title'    => 'Editar',
            'method'   => 'update',
            'viewpath' => APP_THEME . $this->viewFolder,
            'form'     => 'form',
            'response' => 'response',
            'table'    => $permission,
        );

        // return view(APP_THEME . $this->viewFolder . '/_edit', $data);
        return view(APP_THEME . '/layout/modals/_modal', $data);
    }

    /**
     * Método que faz o update dos dados da permissão de acesso
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

        unset($post['method']);

        $permission = $this->validation_permission($post['id']);
        $permission->fill($post);

        if ($permission->hasChanged() == false) {
            $return['info'] = 'Nenhum dado foi alterado';

            return $this->response->setJSON($return);
        }

        if ($this->permissionModel->protect(false)->save($permission)) {
            session()->setFlashdata('message-success', 'Dados salvos com sucesso!');

            $return['success'] = 'Dados salvos com sucesso!';

            return $this->response->setJSON($return);
        }

        $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
        $return['errors_model'] = $this->permissionModel->errors();

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view de deleção da permissão de acesso
     * 
     * @param $id
     * @return view
     */
    public function delete(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('excluir-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $permission = $this->validation_permission($id);

        $data = array(
            'title'      => 'Excluir',
            'method'     => 'delete',
            'permission' => $permission,
        );

        return view(APP_THEME . $this->viewFolder . '/_delete', $data);
    }

    /**
     * Método que faz a deleção da permissão de acesso
     * 
     * @param $id
     * @return redirect
     */
    public function remove(int $id = null)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $permission = $this->validation_permission($id);

        $this->permissionModel->delete($permission->id);

        $permission->active = false;

        $this->permissionModel->protect(false)->save($permission);

        if (!$this->permissionModel->errors()) {
            $return['success'] = 'Removido com sucesso!';
        } else {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $this->permissionModel->errors();
        }

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view de restore da permissão
     * 
     * @param $id
     * @return view
     */
    public function undo(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('excluir-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $permission = $this->validation_permission($id);

        $data = [
            'title'      => 'Restaurar',
            'method'     => 'restore',
            'permission' => $permission,
        ];

        return view(APP_THEME . $this->viewFolder . '/_restore', $data);
    }

    /**
     * Método que faz o restore da permissão de acesso
     * 
     * @param $id
     * @return redirect
     */
    public function restore(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('excluir-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $permission = $this->validation_permission($id);

        $permission->deleted_at = null;
        $permission->active = true;

        $this->permissionModel->protect(false)->save($permission);

        if (!$this->permissionModel->errors()) {
            $return['success'] = 'Restaurado com sucesso!';
        } else {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $this->permissionModel->errors();
        }

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view (modal) de visualização dos dados da permissão de acesso
     * 
     * @param $id
     * @return view
     */
    public function show(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('listar-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $permission = $this->validation_permission($id);

        $data = array(
            'menu'       => 'Acessos',
            'title'      => 'Visualizar',
            'permission' => $permission,
        );

        return view(APP_THEME . $this->viewFolder . '/_show', $data);
    }
}
