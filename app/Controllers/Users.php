<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\User;

class Users extends BaseController
{
    private $userModel;
    private $groupModel;
    private $userGroupModel;
    private $viewFolder = '/cadastros/acessos/usuarios';
    private $route = 'usuarios';

    /**
     * Método que valida se o usuário existe. Caso exista retorna um object com os dados do usuário, caso
     * não exista, retorna um Exception.
     *
     * @param int $id
     *
     * @return object ou Exception
     */
    private function validation_user(int $id = null)
    {
        if (!$id || !$user = $this->userModel->withDeleted(true)->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Usuário ID: $id não encontrado!");
        }

        return $user;
    }

    private function remove_image(string $image)
    {
        $filepath = WRITEPATH . "uploads/usuarios/$image";

        if (is_file($filepath)) {
            unlink($filepath);
        }
    }

    private function manipulate_image(string $filepath)
    {
        $year = date('Y');

        service('image')->withFile($filepath)
            ->fit(300, 300, 'center')
            ->save($filepath);

        \Config\Services::image('imagick')->withFile($filepath)
            ->text("PRSystem $year", [
                'color' => '#fff',
                'opacity' => 0.5,
                'withShadow' => true,
                'hAlign' => 'center',
                'vAlign' => 'bottom',
                'fontSize' => 10,
            ])
            ->save($filepath);
    }

    public function __construct()
    {
        $this->userModel = new \App\Models\UserModel();
        $this->groupModel = new \App\Models\GroupModel();
        $this->userGroupModel = new \App\Models\UserGroupModel();
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
            return redirect()->back()->with('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $data = [
            'menu'  => 'Acessos',
            'title' => 'Usuários',
        ];

        return view(APP_THEME . $this->viewFolder . '/list', $data);
    }

    /**
     * Metodo chamado via AJAX que retorna um JSON com os dados de todos os usuários
     *
     * @return JSON
     */
    public function fetch()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $columns = array(
            0 => 'users.id',
            1 => 'users.name',
            2 => 'users.email',
            3 => 'users.photo',
            4 => 'users.active',
            5 => ''
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

        $users = $this->userModel->getUsers($params_array);
        $rowsTotal = $this->userModel->countUsers($search);

        $rows = 0;
        $data = array();

        foreach ($users as $user) {
            if ($user->photo != null) {
                $image = [
                    'src' => site_url("users/show_photo/$user->photo"),
                    'class' => 'rounded-circle img-fluid btn-photo',
                    'alt' => $user->name,
                    'width' => '30',
                    'data-id' => $user->id,
                ];
            } else {
                $image = [
                    'src' => site_url('assets/images/avatar-user.png'),
                    'class' => 'rounded-circle img-fluid cursor-pointer btn-photo',
                    'alt' => 'Usuário sem foto cadastrada',
                    'width' => '30',
                    'data-id' => $user->id,
                ];
            }

            if (APP_THEME == 'mentor') {
                $act_view  = '<button title="Visualizar Usuário" data-id="' . $user->id . '" data-modulo="view" class="btn btn-sm btn-icon btn-outline-dark btn-round btn-view"><i class="ti ti-eye"></i></button>';
                $act_edit  = '<button title="Editar Usuário" data-id="' . $user->id . '" data-modulo="edit" class="btn btn-sm btn-icon btn-outline-primary btn-round btn-edit"><i class="ti ti-pencil"></i></button>';
                $act_group = '<button title="Grupos do Usuário" data-id="' . $user->id . '" class="btn btn-sm btn-icon btn-outline-warning btn-round btn-grupo"><i class="ti ti-user"></i></button>';

                $email     = $user->email != '' ? '<a href="mailto:' . $user->email . '" class="btn btn-sm btn-icon btn-round btn-inverse-info" data-toggle="tooltip" data-html="true" data-original-title="' . $user->email . '" title="' . $user->email . '"><i class="fa fa-envelope"></i></a>' : '';
                $photo     = '<span style="cursor: pointer;">' . $user->photo = img($image) . '</span>';
                $status    = ($user->active == true ? '<span class="btn btn-sm btn-icon btn-round btn-inverse-success"><i class="ti ti-unlock" title="Ativo"></i></span>' : '<span class="btn btn-sm btn-icon btn-round btn-inverse-danger"><i class="ti ti-lock" title="Inativo"></i></span>');
            } else {
                $act_view  = '<button data-toggle="tooltip" data-original-title="Visualizar" title="Visualizar" data-id="' . $user->id . '" data-modulo="view" class="btn btn-xs btn-default text-primary btn-width-27 btn-view"><i class="fa fa-eye"></i></button>';
                $act_edit  = '<button data-toggle="tooltip" data-original-title="Editar" title="Editar" data-id="' . $user->id . '" data-modulo="edit" class="btn btn-xs btn-default btn-width-27 btn-edit"><i class="fas fa-edit"></i></button>';
                $act_group = '<button data-toggle="tooltip" data-original-title="Grupos" title="Grupos" data-id="' . $user->id . '" class="btn btn-xs btn-default text-warning btn-width-27 btn-group"><i class="fa fa-users"></i></button>';

                $email     = $user->email != '' ? '<a href="mailto:' . $user->email . '" class="btn btn-xs btn-info rounded-circle img-fluid" data-toggle="tooltip" data-html="true" data-original-title="' . $user->email . '" title="' . $user->email . '"><i class="fa fa-envelope"></i></a>' : '';
                $photo     = $user->photo = img($image);
                $status    = ($user->active == true ? '<span class="text-success"><i class="fa fa-unlock" title="Ativo"></i></span>' : '<span class="text-danger"><i class="fa fa-lock" title="Inativo"></i></span>');
            }

            $sub_array = array();

            $sub_array[] = $user->id;
            $sub_array[] = $user->name;
            $sub_array[] = $email;
            $sub_array[] = $photo;
            $sub_array[] = $status;

            $sub_array[] = $act_group . $act_view . $act_edit . $user->buttonsControl();

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
     * Método que retorna a view de inclusão de usuário
     * 
     * @return view
     */
    public function add()
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('criar-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $user = new User();

        $data = [
            'title'    => 'Novo Usuário',
            'method'   => 'insert',
            'viewpath' => APP_THEME . $this->viewFolder,
            'form'     => 'form',
            'response' => 'response',
            'table'    => $user,
        ];

        return view(APP_THEME . '/layout/modals/_modal', $data);
    }

    /**
     * Método que faz o insert dos dados do usuário
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
        unset($post['change_password']);

        $post['active'] = false;

        $user = new User($post);

        if ($this->userModel->protect(false)->insert($user, false)) {
            session()->setFlashdata('message-success', 'Dados salvos com sucesso!');

            $return['success'] = 'Dados salvos com sucesso!';
            $return['id'] = $this->userModel->getInsertID();

            return $this->response->setJSON($return);
        }

        $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
        $return['errors_model'] = $this->userModel->errors();

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view (modal) de edição dos dados do usuário
     * 
     * @param $id
     * @return view
     */
    public function edit(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('editar-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $user = $this->validation_user($id);

        $data = [
            'title'    => 'Editar Usuário',
            'method'   => 'update',
            'viewpath' => APP_THEME . $this->viewFolder,
            'form'     => 'form',
            'response' => 'response',
            'table'    => $user,
        ];

        return view(APP_THEME . '/layout/modals/_modal', $data);
    }

    /**
     * Método que faz o update dos dados do usuário
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

        if (empty($post['password'])) {
            unset($post['password']);
            unset($post['password_confirmation']);
        }

        unset($post['method']);

        if (isset($post['active'])) {
            $post['active'] = ($post['active'] == 'on' ? true : false);
        } else {
            $post['active'] = false;
        }

        $user = $this->validation_user($post['id']);
        $user->fill($post);

        if ($user->hasChanged() == false) {
            $return['info'] = 'Nenhum dado foi alterado';

            return $this->response->setJSON($return);
        }

        if ($this->userModel->protect(false)->save($user)) {
            session()->setFlashdata('message-success', 'Dados salvos com sucesso!');

            $return['success'] = 'Dados salvos com sucesso!';

            return $this->response->setJSON($return);
        }

        $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
        $return['errors_model'] = $this->userModel->errors();

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view de deleção do usuário
     * 
     * @param $id
     * @return view
     */
    public function delete(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('excluir-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $user = $this->validation_user($id);

        $data = [
            'title'  => 'Excluir',
            'method' => 'delete',
            'user'   => $user,
        ];

        return view(APP_THEME . $this->viewFolder . '/_delete', $data);
    }

    /**
     * Método que faz a deleção do usuário
     * 
     * @param $id
     * @return redirect
     */
    public function remove(int $id = null)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $user = $this->validation_user($id);

        $this->userModel->delete($user->id);

        if ($user->photo != null) {
            $this->remove_image($user->photo);
        }

        $user->active = false;

        $this->userModel->protect(false)->save($user);

        if (!$this->userModel->errors()) {
            $return['success'] = 'Removido com sucesso!';
        } else {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $this->userModel->errors();
        }

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view de restore do usuário
     * 
     * @param $id
     * @return view
     */
    public function undo(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('excluir-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $user = $this->validation_user($id);

        $data = [
            'title'  => 'Restaurar',
            'method' => 'restore',
            'user'   => $user,
        ];

        return view(APP_THEME . $this->viewFolder . '/_restore', $data);
    }

    /**
     * Método que faz o restore do usuário
     * 
     * @param $id
     * @return redirect
     */
    public function restore(int $id = null)
    {
        if (!$this->getLoggedUserData()->validatePermissionLoggedUser('editar-usuarios')) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $user = $this->validation_user($id);

        $user->deleted_at = null;
        $user->active = true;

        $this->userModel->protect(false)->save($user);

        if (!$this->userModel->errors()) {
            $return['success'] = 'Restaurado com sucesso!';
        } else {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $this->userModel->errors();
        }

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view (modal) de visualização dos dados do usuário
     * 
     * @param $id
     * @return view
     */
    public function show(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('listar-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $user = $this->validation_user($id);

        $data = [
            'title' => 'Visualizar',
            'user'  => $user,
        ];

        return view(APP_THEME . $this->viewFolder . '/_show', $data);
    }

    /**
     * Método que retorna a view (modal) de visualização da foto do usuário
     * 
     * @param $id
     * @return view
     */
    public function view_photo(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('listar-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $user = $this->validation_user($id);

        $data = [
            'title' => 'Visualizar Foto',
            'user'  => $user,
        ];

        return view(APP_THEME . $this->viewFolder . '/_show-photo', $data);
    }

    /**
     * Método que exibe a foto do usuário
     * 
     * @param $image
     */
    public function show_photo(string $image = null)
    {
        if ($image != null) {
            $this->showImage('usuarios', $image);
        }
    }


    /**
     * Método que retorna a view (modal) de edição da foto do usuário
     * 
     * @param $id
     * @return view
     */
    public function edit_photo(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('editar-usuarios'))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');

            return view('Layout/_noaccess');
        }

        $user = $this->validation_user($id);

        $data = [
            'title' => 'Alterar foto do Usuário',
            'user'  => $user,
        ];

        return view(APP_THEME . $this->viewFolder . '/_photo', $data);
    }

    /**
     * Método que faz o upload da foto do usuário
     * 
     * @return json
     */
    public function upload()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $return = [];
        $return['token'] = csrf_hash();

        $validation = service('validation');

        $rules = [
            'photo' => 'uploaded[photo]|max_size[photo,1024]|ext_in[photo,png,jpg,jpeg,webp]',
        ];

        $messages = [
            'photo' => [
                'uploaded' => 'É necessário escolher uma imagem.',
                'max_size' => 'Tamanho da imagem maior que o permitido',
                'ext_in'   => 'Formato não permitido.',
            ],
        ];

        $validation->setRules($rules, $messages);

        if ($validation->withRequest($this->request)->run() == false) {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $validation->getErrors();

            return $this->response->setJSON($return);
        }

        $post = $this->request->getPost();
        $user = $this->validation_user($post['id']);
        $file = $this->request->getFile('photo');

        list($width, $heigth) = getimagesize($file->getPathName());

        if ($width < '100' || $heigth < '100') {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = ['dimension' => 'A imagem não pode ser menor que 100 x 100px'];

            return $this->response->setJSON($return);
        }

        $filepath = $file->store('usuarios');
        $filepath = WRITEPATH . "uploads/$filepath";

        $this->manipulate_image($filepath);

        $photo_ant = $user->photo;
        $user->photo = $file->getName();

        if ($this->userModel->save($user)) {
            session()->setFlashdata('message-success', 'Imagem atualizada com sucesso!');

            $return['success'] = 'Imagem atualizada com sucesso!';

            if ($photo_ant != null) {
                $this->remove_image($photo_ant);
            }

            return $this->response->setJSON($return);
        }
    }

    /**
     * Método que retorna a view de grupos do usuário
     * 
     * @param $id
     * @return view
     */
    public function groups(int $id = null)
    {
        if (!$this->getLoggedUserData()->validatePermissionLoggedUser('editar-usuarios')) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');

            return view(APP_THEME . '/layout/_noaccess');
        }

        $user = $this->validation_user($id);

        $user->groups = $this->userGroupModel->recoverGroupsUser($user->id, 10);
        $user->pager = $this->userGroupModel->pager;

        if (!empty($user->groups)) {
            $groups_existing = array_column($user->groups, 'group_id');
            // $groups_list = $this->groupModel->where('id != ', 2)    // Grupo de Clientes não pode ser utilizado
            //     ->whereNotIn('id', $groups_existing)
            //     ->findAll();
            $groups_list = $this->groupModel
                ->whereNotIn('id', $groups_existing)
                ->findAll();
        } else {
            // $groups_list = $this->groupModel->where('id != ', 2)    // Grupo de Clientes não pode ser utilizado
            //     ->findAll();
            $groups_list = $this->groupModel
                ->findAll();
        }

        $groups = $this->userGroupModel->findGroupsUser($id);

        // Não deixa um cliente alterar o grupo
        // if (in_array(2, array_column($user->groups, 'group_id'))) {
        //     session()->setFlashdata('message-warning', 'Não é possível alterar o Grupo de um Usuário do Grupo Cliente.');

        //     return view(APP_THEME . '/layout/_messages');
        // }

        $data = [
            'title'       => 'Grupos do Usuário',
            'user'        => $user,
            'groups'      => $groups,
            'groups_list' => $groups_list,
        ];

        return view(APP_THEME . $this->viewFolder . '/_groups', $data);
    }

    /**
     * Metodo chamado via AJAX que retorna um JSON com os dados de todos os grupos do usuário
     *
     * @param $id
     * @return JSON
     */
    public function fetch_groups(int $id)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $groups = $this->userGroupModel->findGroupsUser($id);

        $data = [];

        foreach ($groups as $group) {
            $data[] = [
                'name' => esc($group->name),
                'actions' => anchor("users/group_delete/$group->id", '<i class="fas fa-trash-alt text-danger" title="Excluir"></i>', 'title="Excluir" class="btn btn-xs btn-default text-danger btn-width-27 btn-del"'),
            ];
        }

        $return = [
            'data' => $data,
        ];

        return $this->response->setJSON($return);
    }

    /**
     * Método que salva os grupos do usuário
     */
    public function groups_save()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $return = [];
        $return['token'] = csrf_hash();

        $post = $this->request->getPost();

        unset($post['method']);

        $user = $this->validation_user($post['id']);

        if (empty($post['group_id'])) {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = ['group_id' => 'Selecione um ou mais grupos para salvar'];

            return $this->response->setJSON($return);
        }

        // Grupo Clientes
        // if (in_array(2, $post['group_id'])) {
        //     $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
        //     $return['errors_model'] = ['group_id' => 'O Grupo <strong>Clientes</strong> não pode ser atribuído manualmente'];

        //     return $this->response->setJSON($return);
        // }

        // Grupo Administrador
        if (in_array(1, $post['group_id'])) {
            $adminGroup = [
                'user_id'  => $user->id,
                'group_id' => 1,
            ];

            if ($this->userGroupModel->insert($adminGroup)) {
                $this->userGroupModel->where('user_id', $user->id)
                    ->where('group_id !=', 1)
                    ->delete();

                session()->setFlashdata('message-success', 'Dados salvos com sucesso!');

                $return['success'] = 'Dados salvos com sucesso!';

                return $this->response->setJSON($return);
            }
        }

        $groups_push = [];

        foreach ($post['group_id'] as $group) {
            array_push($groups_push, [
                'user_id'  => $user->id,
                'group_id' => $group,
            ]);
        }

        if ($this->userGroupModel->insertBatch($groups_push)) {
            session()->setFlashdata('message-success', 'Dados salvos com sucesso!');

            $return['success'] = 'Dados salvos com sucesso!';

            return $this->response->setJSON($return);
        }
    }

    /**
     * Método que retorna a view de deleção do grupo
     * 
     * @param $id
     */
    public function group_delete(int $id = null)
    {
        if (!$this->getLoggedUserData()->validatePermissionLoggedUser('editar-usuarios')) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');

            return view('Layout/_noaccess');
        }

        $group = $this->userGroupModel->where('id', $id)->find();

        if ($group->id == 2) {
            return redirect()->back()->with('message-warning', 'O Grupo <strong>Clientes</strong> não pode ser excluído!');
        }

        $data = [
            'title'      => 'Excluir Grupo de Acesso',
            'permission' => $group,
        ];

        return view($this->viewFolder . '/_delete_group', $data);
    }

    /**
     * Método que retorna a view (modal) de edição da senha do usuário.
     */
    public function change_password()
    {
        $data = [
            'title' => 'Alterar Senha',
        ];

        return view('Acessos/Usuarios/_change_password', $data);
    }

    /**
     * Método que faz a troca da senha do usuário
     * 
     * @return JSON
     */
    public function update_password()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $user = userIsLogged();

        $return = [];
        $return['token'] = csrf_hash();

        $current_password = $this->request->getPost('current_password');

        if ($user->verifyPassword($current_password) == false) {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = ['current_password' => 'A senha atual é inválida.'];

            return $this->response->setJSON($return);
        }

        $user->fill($this->request->getPost());

        if ($user->hasChanged() == false) {
            $return['info'] = 'Nenhum dado foi alterado';

            return $this->response->setJSON($return);
        }

        if ($this->userModel->save($user)) {
            session()->setFlashdata('message-success', 'Dados salvos com sucesso!');

            $return['success'] = 'Senha atualizada com sucesso!';

            return $this->response->setJSON($return);
        }

        $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
        $return['errors_model'] = $this->userModel->errors();

        return $this->response->setJSON($return);
    }
}
