<?php

namespace App\Controllers;

use App\Entities\Group;

class Groups extends BaseController
{
    private $groupModel;
    private $permissionModel;
    private $permissionGroupModel;
    private $viewFolder = '/cadastros/acessos/grupos';
    private $route = 'grupos';

    /**
     * Método que valida se o grupo de usuários existe. Caso exista retorna um object com os dados do grupo, caso
     * não exista, retorna um Exception.
     *
     * @param int $id
     *
     * @return object ou Exception
     */
    private function validation_group(int $id = null)
    {
        if (!$id || !$group = $this->groupModel->withDeleted(true)->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Grupo de Usuários ID: $id não encontrado!");
        }

        return $group;
    }

    public function __construct()
    {
        $this->groupModel = new \App\Models\GroupModel();
        $this->permissionModel = new \App\Models\PermissionModel();
        $this->permissionGroupModel = new \App\Models\PermissionGroupModel();
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
            'menu' => 'Acessos',
            'title' => 'Grupos de Usuários',
        ];

        return view(APP_THEME.$this->viewFolder.'/list', $data);
    }

    /**
     * Metodo chamado via AJAX que retorna um JSON com os dados de todos os grupos de usuários.
     *
     * @return JSON
     */
    public function fetch()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $columns = [
            0 => 'groups.id',
            1 => 'groups.name',
            2 => 'groups.description',
            3 => 'groups.display',
            4 => 'groups.active',
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

        $groups = $this->groupModel->getGroups($params_array);
        $rowsTotal = $this->groupModel->countGroups($search);

        $rows = 0;
        $data = [];

        foreach ($groups as $group) {
            if (APP_THEME == 'mentor') {
                $act_view = '<button title="Visualizar Grupo de Usuários" data-id="'.$group->id.'" data-modulo="view" class="btn btn-sm btn-icon btn-outline-dark btn-round btn-view"><i class="ti ti-eye"></i></button>';
                $act_edit = '<button title="Editar Grupo de Usuários" data-id="'.$group->id.'" data-modulo="edit" class="btn btn-sm btn-icon btn-outline-primary btn-round btn-edit"><i class="ti ti-pencil"></i></button>';
                $act_group = '<button title="Permissões do Grupo" data-id="'.$group->id.'" class="btn btn-sm btn-icon btn-outline-warning btn-round btn-perm"><i class="ti ti-user"></i></button>';

                if ($group->display == true) {
                    $display = '<span class="btn btn-sm btn-icon btn-round btn-inverse-success" data-toggle="tooltip" data-html="true" data-original-title="Exibir" title="Exibir"><i class="ti ti-check"></i></span>';
                } else {
                    $display = '<span class="btn btn-sm btn-icon btn-round btn-inverse-warning" data-toggle="tooltip" data-html="true" data-original-title="Não exibir" title="Não exibir"><i class="ti ti-close"></i></span>';
                }

                $status = ($group->active == true ? '<span class="btn btn-sm btn-icon btn-round btn-inverse-success"><i class="ti ti-unlock" title="Ativo"></i></span>' : '<span class="btn btn-sm btn-icon btn-round btn-inverse-danger"><i class="ti ti-lock" title="Inativo"></i></span>');
            } else {
                $act_view = '<button data-toggle="tooltip" data-original-title="Visualizar" title="Visualizar" data-id="'.$group->id.'" data-modulo="view" class="btn btn-xs btn-default text-primary btn-width-27 btn-view"><i class="fa fa-eye"></i></button>';
                $act_edit = '<button data-toggle="tooltip" data-original-title="Editar" title="Editar" data-id="'.$group->id.'" data-modulo="edit" class="btn btn-xs btn-default btn-width-27 btn-edit"><i class="fas fa-edit"></i></button>';
                $act_group = '<button data-toggle="tooltip" data-original-title="Permissões" title="Permissões" data-id="'.$group->id.'" class="btn btn-xs btn-default text-warning btn-width-27 btn-perm"><i class="fa fa-users"></i></button>';

                if ($group->display == true) {
                    $display = '<span data-toggle="tooltip" data-html="true" data-original-title="Exibir" title="Exibir"><i class="fa fa-check text-success"></i></span>';
                } else {
                    $display = '<span data-toggle="tooltip" data-html="true" data-original-title="Não exibir" title="Não exibir"><i class="fa fa-ban text-danger"></i></span>';
                }

                $status = ($group->active == true ? '<span class="text-success"><i class="fa fa-unlock" title="Ativo"></i></span>' : '<span class="text-danger"><i class="fa fa-lock" title="Inativo"></i></span>');
            }

            $sub_array = [];

            $sub_array[] = $group->id;
            $sub_array[] = $group->name;
            $sub_array[] = $group->description;
            $sub_array[] = $display;
            $sub_array[] = $status;
            $sub_array[] = $act_group.$act_view.$act_edit.$group->buttonsControl();

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
     * Método que retorna a view de inclusão de grupo de usuários.
     *
     * @return view
     */
    public function add()
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('criar-'.$this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>'.$this->getLoggedUserData()->name.'</b> não possui permissão para acessar este módulo.');
        }

        $group = new Group();

        $data = [
            'title' => 'Inclusão',
            'method' => 'insert',
            'form' => 'form',
            'response' => 'response',
            'viewpath' => APP_THEME.$this->viewFolder,
            'table' => $group,
        ];

        return view(APP_THEME.'/layout/modals/_modal', $data);
    }

    /**
     * Método que faz o insert dos dados do grupo.
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

        if (isset($post['display'])) {
            $post['display'] = ($post['display'] == 'on' ? true : false);
        } else {
            $post['display'] = false;
        }

        $post['active'] = true;

        $group = new Group($post);

        if ($this->groupModel->protect(false)->insert($group, false)) {
            session()->setFlashdata('message-success', 'Dados salvos com sucesso!');

            $return['success'] = 'Dados salvos com sucesso!';
            $return['id'] = $this->groupModel->getInsertID();

            return $this->response->setJSON($return);
        }

        $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
        $return['errors_model'] = $this->groupModel->errors();

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view (modal) de edição dos dados do grupo.
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

        $group = $this->validation_group($id);

        // if ($group->id < 3) {
        //     return redirect()->back()->with('message-warning', 'O Grupo de Usuários <b>' . esc($group->name) . '</b> não pode ser editado!');
        // }

        $data = [
            'title' => 'Editar',
            'method' => 'update',
            'form' => 'form',
            'response' => 'response',
            'viewpath' => APP_THEME.$this->viewFolder,
            'table' => $group,
        ];

        return view(APP_THEME.'/layout/modals/_modal', $data);
    }

    /**
     * Método que faz o update dos dados do grupo.
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

        if (isset($post['display'])) {
            $post['display'] = ($post['display'] == 'on' ? true : false);
        } else {
            $post['display'] = false;
        }

        $group = $this->validation_group($post['id']);
        $group->fill($post);

        if ($group->hasChanged() == false) {
            $return['info'] = 'Nenhum dado foi alterado';

            return $this->response->setJSON($return);
        }

        if ($this->groupModel->protect(false)->save($group)) {
            session()->setFlashdata('message-success', 'Dados salvos com sucesso!');

            $return['success'] = 'Dados salvos com sucesso!';

            return $this->response->setJSON($return);
        }

        $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
        $return['errors_model'] = $this->groupModel->errors();

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view de deleção do grupo.
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

        $group = $this->validation_group($id);

        // if ($group->id < 3) {
        //     return redirect()->back()->with('message-warning', 'O Grupo de Usuários <b>' . esc($group->name) . '</b> não pode ser excluído!');
        // }

        $data = [
            'title' => 'Excluir',
            'method' => 'delete',
            'group' => $group,
        ];

        return view(APP_THEME.$this->viewFolder.'/_delete', $data);
    }

    /**
     * Método que faz a deleção do grupo.
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

        $group = $this->validation_group($id);

        $this->groupModel->delete($group->id);

        $group->active = false;

        $this->groupModel->protect(false)->save($group);

        if (!$this->groupModel->errors()) {
            $return['success'] = 'Removido com sucesso!';
        } else {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $this->groupModel->errors();
        }

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view de restore do grupo.
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

        $group = $this->validation_group($id);

        $data = [
            'title' => 'Restaurar',
            'method' => 'restore',
            'group' => $group,
        ];

        return view(APP_THEME.$this->viewFolder.'/_restore', $data);
    }

    /**
     * Método que faz o restore do grupo.
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

        $group = $this->validation_group($id);

        $group->deleted_at = null;
        $group->active = true;

        $this->groupModel->protect(false)->save($group);

        if (!$this->groupModel->errors()) {
            $return['success'] = 'Restaurado com sucesso!';
        } else {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $this->groupModel->errors();
        }

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view (modal) de visualização dos dados do grupo.
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

        $group = $this->validation_group($id);

        $data = [
            'title' => 'Visualizar',
            'group' => $group,
        ];

        return view(APP_THEME.$this->viewFolder.'/_show', $data);
    }

    /**
     * Método que retorna a view de permissões do grupo.
     */
    public function permissions(int $id = null)
    {
        $group = $this->validation_group($id);

        // if ($group->id < 3) {
        //     return redirect()->back()->with('message-warning', 'O Grupo de Usuários <b>' . esc($group->name) . '</b> não precisa ter registro de permissões!');
        // }

        if ($group->id > 2) {
            $group->permissions = $this->permissionGroupModel->recoverGroupPermissions($group->id, 10);
            $group->pager = $this->permissionGroupModel->pager;
        }

        if (!empty($group->permissions)) {
            $permissions_existing = array_column($group->permissions, 'permission_id');
            $permissions_list = $this->permissionModel->whereNotIn('id', $permissions_existing)->findAll();
        } else {
            $permissions_list = $this->permissionModel->findAll();
        }

        $permissions = $this->permissionGroupModel->findGroupPermissions($id);

        $data = [
            'title' => 'Permissões do Grupo',
            'group' => $group,
            'permissions' => $permissions,
            'permissions_list' => $permissions_list,
        ];

        return view(APP_THEME.$this->viewFolder.'/_permissions', $data);
    }

    /**
     * Método que salva as permissõs do grupo.
     */
    public function permissions_save()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $return = [];
        $return['token'] = csrf_hash();

        $post = $this->request->getPost();

        unset($post['method']);

        $group = $this->validation_group($post['id']);

        if (empty($post['permission_id'])) {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = ['permissao_id' => 'Selecione uma ou mais permissões para salvar'];

            return $this->response->setJSON($return);
        }

        $permissions_push = [];

        foreach ($post['permission_id'] as $permission) {
            array_push($permissions_push, [
                'group_id' => $group->id,
                'permission_id' => $permission,
            ]);
        }

        if ($this->permissionGroupModel->insertBatch($permissions_push)) {
            session()->setFlashdata('message-success', 'Dados salvos com sucesso!');

            $return['success'] = 'Dados salvos com sucesso!';

            return $this->response->setJSON($return);
        }
    }

    /**
     * Método que retorna a view de deleção do grupo.
     */
    public function permission_delete(int $id = null)
    {
        if (!$this->getLoggedUserData()->validatePermissionLoggedUser('excluir-permissoes-grupos')) {
            session()->setFlashdata('message-warning', 'O usuário <b>'.$this->getLoggedUserData()->name.'</b> não possui permissão para acessar este módulo.');

            return view(APP_THEME.'/layout/_noaccess');
        }

        $permission = $this->permissionGroupModel->where('id', $id)->find();

        if ($permission->id < 3) {
            return redirect()->back()->with('message-warning', 'Esta permissão não pode ser excluída!');
        }

        $data = [
            'title' => 'Excluir Permissão do Grupo de Usuários',
            'permission' => $permission,
        ];

        return view(APP_THEME.$this->viewFolder.'/_del_permission', $data);
    }

    /**
     * Metodo chamado via AJAX que retorna um JSON com os dados de todos as permissoes do grupo.
     *
     * @return JSON
     */
    public function fetch_permissions(int $id)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $permissions = $this->permissionGroupModel->findGroupPermissions($id);

        $data = [];

        foreach ($permissions as $permission) {
            $data[] = [
                'description' => esc($permission->description),
                'actions' => anchor("groups/permission_delete/$permission->id", '<i class="fas fa-trash-alt text-danger" title="Excluir"></i>', 'title="Excluir" class="btn btn-xs btn-default text-danger btn-width-27 btn-del"'),
            ];
        }

        $return = [
            'data' => $data,
        ];

        return $this->response->setJSON($return);
    }
}
