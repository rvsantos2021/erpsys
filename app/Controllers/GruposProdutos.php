<?php

namespace App\Controllers;

use App\Entities\GrupoProduto;

class GruposProdutos extends BaseController
{
    protected $db;
    protected $grupoModel;

    private $viewFolder = '/cadastros/estoque/grupos';
    private $route = 'grupos';

    /**
     * Método que valida se o grupo existe. Caso exista retorna um object com os dados do grupo, caso
     * não exista, retorna um Exception.
     *
     * @param int $id
     *
     * @return object ou Exception
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
        $this->grupoModel = new \App\Models\GrupoProdutoModel();
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
            'menu' => 'Estoque',
            'submenu' => 'Cadastros',
            'title' => 'Grupos',
        ];

        return view(APP_THEME.$this->viewFolder.'/list', $data);
    }

    /**
     * Metodo chamado via AJAX que retorna um JSON com os dados de todos os grupos.
     *
     * @return JSON
     */
    public function fetch()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $columns = [
            0 => 'produtos_grupos.codigo',
            1 => 'produtos_grupos.descricao',
            2 => 'produtos_grupos.active',
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

        $grupos = $this->grupoModel->getGrupos($params_array);
        $rowsTotal = $this->grupoModel->countGrupos($search);

        $rows = 0;
        $data = [];

        foreach ($grupos as $grupo) {
            if (APP_THEME == 'mentor') {
                $act_view = '<button title="Visualizar Grupo" data-id="'.$grupo->id.'" data-modulo="view" class="btn btn-sm btn-icon btn-outline-dark btn-round btn-view"><i class="ti ti-eye"></i></button>';
                $act_edit = '<button title="Editar Grupo" data-id="'.$grupo->id.'" data-modulo="edit" class="btn btn-sm btn-icon btn-outline-primary btn-round btn-edit"><i class="ti ti-pencil"></i></button>';

                $status = ($grupo->active == true ? '<span class="btn btn-sm btn-icon btn-round btn-inverse-success"><i class="ti ti-unlock" title="Ativo"></i></span>' : '<span class="btn btn-sm btn-icon btn-round btn-inverse-danger"><i class="ti ti-lock" title="Inativo"></i></span>');
            } else {
                $act_view = '<button data-toggle="tooltip" data-original-title="Visualizar Grupo" title="Visualizar Grupo" data-id="'.$grupo->id.'" data-modulo="view" class="btn btn-xs btn-default text-primary btn-width-27 btn-view"><i class="fa fa-eye"></i></button>';
                $act_edit = '<button data-toggle="tooltip" data-original-title="Editar Grupo" title="Editar Grupo" data-id="'.$grupo->id.'" data-modulo="edit" class="btn btn-xs btn-default btn-width-27 btn-edit"><i class="fas fa-edit"></i></button>';

                $status = ($grupo->active == true ? '<span class="btn btn-xs btn-default rounded-circle-custom text-success" data-toggle="tooltip" data-original-title="Ativo"><i class="fa fa-unlock" title="Ativo"></i></span>' : '<span class="btn btn-xs btn-default rounded-circle-custom text-danger" data-toggle="tooltip" data-original-title="Inativo"><i class="fa fa-lock" title="Inativo"></i></span>');
            }

            if (($grupo->id_pai == null) || ($grupo->id_pai == 0)) {
                $style = '';
            } elseif (substr_count($grupo->codigo, '.') == 1) {
                $style = 'tab1';
            } elseif (substr_count($grupo->codigo, '.') == 2) {
                $style = 'tab2';
            } elseif (substr_count($grupo->codigo, '.') == 3) {
                $style = 'tab3';
            } elseif (substr_count($grupo->codigo, '.') == 4) {
                $style = 'tab4';
            } elseif (substr_count($grupo->codigo, '.') == 5) {
                $style = 'tab5';
            }

            $sub_array = [];

            $sub_array[] = ($style == '' ? $grupo->codigo : '<'.$style.'>'.$grupo->codigo.'</'.$style.'>');
            $sub_array[] = ($style == '' ? $grupo->descricao : '<'.$style.'>'.$grupo->descricao.'</'.$style.'>');
            $sub_array[] = $status;
            $sub_array[] = $act_view.$act_edit.$grupo->buttonsControl();

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
     * Método que retorna a view de inclusão de grupo.
     *
     * @return view
     */
    public function add()
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('listar-'.$this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>'.$this->getLoggedUserData()->name.'</b> não possui permissão para acessar este módulo.');
        }

        $grupo = new GrupoProduto();

        $data = [
            'title' => 'Novo Grupo',
            'method' => 'insert',
            'viewpath' => APP_THEME.$this->viewFolder,
            'table' => $grupo,
            'grupos' => $this->grupoModel->getAllGrupos(),
            'form' => 'form',
            'response' => 'response',
        ];

        return view(APP_THEME.'/layout/modals/_modal', $data);
    }

    /**
     * Método que retorna a view de inclusão de grupo.
     *
     * @return view
     */
    public function add_modal()
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('listar-'.$this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>'.$this->getLoggedUserData()->name.'</b> não possui permissão para acessar este módulo.');
        }

        $grupo = new GrupoProduto();

        $data = [
            'title' => 'Novo Grupo',
            'method' => 'insert',
            'viewpath' => APP_THEME.$this->viewFolder,
            'form' => 'formAddGrupo',
            'response' => 'responseGrupo',
            'table' => $grupo,
            'grupos' => $this->grupoModel->getAllGrupos(),
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

        // Limpa os dados desnecessários do POST
        $fields_to_unset = [
            'method',
        ];

        foreach ($fields_to_unset as $field) {
            unset($post[$field]);
        }

        $codigo = $this->grupoModel->getCodigoGrupo($post['id_pai']);
        $post['codigo'] = $codigo;

        $grupo = new GrupoProduto($post);

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
            $return['descricao'] = $post['descricao'];

            return $this->response->setJSON($return);
        } catch (\Exception $e) {
            $this->db->transRollback(); // Reverte as mudanças em caso de erro

            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $e->getMessage();

            return $this->response->setJSON($return);
        }
    }

    /**
     * Método que retorna a view de edição dos dados do grupo.
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

        helper('form');

        $grupo = $this->validation_grupo($id);

        $data = [
            'title' => 'Editar Grupo',
            'method' => 'update',
            'viewpath' => APP_THEME.$this->viewFolder,
            'form' => 'form',
            'response' => 'response',
            'table' => $grupo,
            'grupos' => $this->grupoModel->getAllGrupos(),
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

        // Limpa os dados desnecessários do POST
        $fields_to_unset = [
            'method',
        ];

        foreach ($fields_to_unset as $field) {
            unset($post[$field]);
        }

        $grupo_atual = $this->validation_grupo($post['id']);
        $id_pai_atual = ($post['id_pai'] == null ? 0 : $post['id_pai']);
        $codigo = $this->grupoModel->getCodigoGrupo($post['id_pai']);

        if ($grupo_atual->id_pai != $id_pai_atual) {
            $post['codigo'] = $codigo;
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

        $grupo = $this->validation_grupo($id);

        $data = [
            'title' => 'Excluir',
            'method' => 'delete',
            'table' => $grupo,
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

        $grupo = $this->validation_grupo($id);

        $data = [
            'title' => 'Restaurar',
            'method' => 'restore',
            'table' => $grupo,
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
     * Método que retorna a view de visualização dos dados do grupo.
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

        $grupo = $this->validation_grupo($id);

        $data = [
            'title' => 'Visualizar',
            'table' => $grupo,
        ];

        return view(APP_THEME.$this->viewFolder.'/_show', $data);
    }
}
