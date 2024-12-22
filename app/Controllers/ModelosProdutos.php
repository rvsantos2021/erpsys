<?php

namespace App\Controllers;

use App\Entities\ModeloProduto;

class ModelosProdutos extends BaseController
{
    protected $db;
    protected $modeloModel;

    private $viewFolder = '/cadastros/estoque/modelos';
    private $route = 'modelos';

    /**
     * Método que valida se o modelo existe. Caso exista retorna um object com os dados do modelo, caso
     * não exista, retorna um Exception.
     *
     * @param int $id
     *
     * @return object ou Exception
     */
    private function validation_modelo(int $id = null)
    {
        if (!$id || !$modelo = $this->modeloModel->withDeleted(true)->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Modelo ID: $id não encontrado!");
        }

        return $modelo;
    }

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->modeloModel = new \App\Models\ModeloProdutoModel();
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
            'title' => 'Modelos',
        ];

        return view(APP_THEME.$this->viewFolder.'/list', $data);
    }

    /**
     * Metodo chamado via AJAX que retorna um JSON com os dados de todos os modelos.
     *
     * @return JSON
     */
    public function fetch()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $columns = [
            0 => 'produtos_modelos.id',
            1 => 'produtos_modelos.descricao',
            2 => 'produtos_modelos.active',
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

        $modelos = $this->modeloModel->getModelos($params_array);
        $rowsTotal = $this->modeloModel->countModelos($search);

        $rows = 0;
        $data = [];

        foreach ($modelos as $modelo) {
            if (APP_THEME == 'mentor') {
                $act_view = '<button title="Visualizar Modelo" data-id="'.$modelo->id.'" data-modulo="view" class="btn btn-sm btn-icon btn-outline-dark btn-round btn-view"><i class="ti ti-eye"></i></button>';
                $act_edit = '<button title="Editar Modelo" data-id="'.$modelo->id.'" data-modulo="edit" class="btn btn-sm btn-icon btn-outline-primary btn-round btn-edit"><i class="ti ti-pencil"></i></button>';

                $status = ($modelo->active == true ? '<span class="btn btn-sm btn-icon btn-round btn-inverse-success"><i class="ti ti-unlock" title="Ativo"></i></span>' : '<span class="btn btn-sm btn-icon btn-round btn-inverse-danger"><i class="ti ti-lock" title="Inativo"></i></span>');
            } else {
                $act_view = '<button data-toggle="tooltip" data-original-title="Visualizar Modelo" title="Visualizar Modelo" data-id="'.$modelo->id.'" data-modulo="view" class="btn btn-xs btn-default text-primary btn-width-27 btn-view"><i class="fa fa-eye"></i></button>';
                $act_edit = '<button data-toggle="tooltip" data-original-title="Editar Modelo" title="Editar Modelo" data-id="'.$modelo->id.'" data-modulo="edit" class="btn btn-xs btn-default btn-width-27 btn-edit"><i class="fas fa-edit"></i></button>';

                $status = ($modelo->active == true ? '<span class="btn btn-xs btn-default rounded-circle-custom text-success" data-toggle="tooltip" data-original-title="Ativo"><i class="fa fa-unlock" title="Ativo"></i></span>' : '<span class="btn btn-xs btn-default rounded-circle-custom text-danger" data-toggle="tooltip" data-original-title="Inativo"><i class="fa fa-lock" title="Inativo"></i></span>');
            }

            $sub_array = [];

            $sub_array[] = $modelo->id;
            $sub_array[] = $modelo->descricao;
            $sub_array[] = $status;
            $sub_array[] = $act_view.$act_edit.$modelo->buttonsControl();

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
     * Método que retorna a view de inclusão de modelo.
     *
     * @return view
     */
    public function add()
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('listar-'.$this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>'.$this->getLoggedUserData()->name.'</b> não possui permissão para acessar este módulo.');
        }

        $modelo = new ModeloProduto();

        $data = [
            'title' => 'Novo Modelo',
            'method' => 'insert',
            'viewpath' => APP_THEME.$this->viewFolder,
            'form' => 'form',
            'response' => 'response',
            'table' => $modelo,
        ];

        return view(APP_THEME.'/layout/modals/_modal', $data);
    }

    /**
     * Método que retorna a view de inclusão de modelo.
     *
     * @return view
     */
    public function add_modal()
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('listar-'.$this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>'.$this->getLoggedUserData()->name.'</b> não possui permissão para acessar este módulo.');
        }

        $modelo = new ModeloProduto();

        $data = [
            'title' => 'Novo Modelo',
            'method' => 'insert',
            'viewpath' => APP_THEME.$this->viewFolder,
            'form' => 'formAddModelo',
            'response' => 'responseModelo',
            'table' => $modelo,
        ];

        return view(APP_THEME.'/layout/modals/_modal', $data);
    }

    /**
     * Método que faz o insert dos dados do modelo.
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

        $modelo = new ModeloProduto($post);

        try {
            $this->db->transStart(); // Inicia a transação

            // Insere o modelo
            if (!$this->modeloModel->protect(false)->insert($modelo, true)) {
                throw new \Exception('Erro ao inserir o modelo.');
            }

            $modelo_id = $this->modeloModel->getInsertID();

            $this->db->transComplete(); // Finaliza a transação

            if ($this->db->transStatus() === false) {
                throw new \Exception('Erro ao completar a transação.');
            }

            if (!$this->modeloModel->errors()) {
                $return['success'] = 'Dados salvos com sucesso!';
            } else {
                $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
                $return['errors_model'] = $this->modeloModel->errors();
            }

            $return['id'] = $modelo_id;
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
     * Método que retorna a view de edição dos dados do modelo.
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

        $modelo = $this->validation_modelo($id);

        $data = [
            'title' => 'Editar Modelo',
            'method' => 'update',
            'viewpath' => APP_THEME.$this->viewFolder,
            'form' => 'form',
            'response' => 'response',
            'table' => $modelo,
        ];

        return view(APP_THEME.'/layout/modals/_modal', $data);
    }

    /**
     * Método que faz o update dos dados do modelo.
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

            $modelo = $this->validation_modelo($post['id']);
            $modelo->fill($post);

            if ($modelo->hasChanged()) {
                $this->modeloModel->protect(false)->save($modelo);
            }

            $this->db->transComplete(); // Finaliza a transação

            if ($this->db->transStatus() === false) {
                throw new \Exception('Erro ao salvar os dados.');
            }

            if (!$this->modeloModel->errors()) {
                $return['success'] = 'Dados salvos com sucesso!';
            } else {
                $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
                $return['errors_model'] = $this->modeloModel->errors();
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
     * Método que retorna a view de deleção do modelo.
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

        $modelo = $this->validation_modelo($id);

        $data = [
            'title' => 'Excluir',
            'method' => 'delete',
            'table' => $modelo,
        ];

        return view(APP_THEME.$this->viewFolder.'/_delete', $data);
    }

    /**
     * Método que faz a deleção do modelo.
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

        $modelo = $this->validation_modelo($id);

        $this->modeloModel->delete($modelo->id);

        $modelo->active = false;

        $this->modeloModel->protect(false)->save($modelo);

        if (!$this->modeloModel->errors()) {
            $return['success'] = 'Removido com sucesso!';
        } else {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $this->modeloModel->errors();
        }

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view de restore do modelo.
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

        $modelo = $this->validation_modelo($id);

        $data = [
            'title' => 'Restaurar',
            'method' => 'restore',
            'table' => $modelo,
        ];

        return view(APP_THEME.$this->viewFolder.'/_restore', $data);
    }

    /**
     * Método que faz o restore do modelo.
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

        $modelo = $this->validation_modelo($id);

        $modelo->deleted_at = null;
        $modelo->active = true;

        $this->modeloModel->protect(false)->save($modelo);

        if (!$this->modeloModel->errors()) {
            $return['success'] = 'Restaurado com sucesso!';
        } else {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $this->modeloModel->errors();
        }

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view de visualização dos dados do modelo.
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

        $modelo = $this->validation_modelo($id);

        $data = [
            'title' => 'Visualizar',
            'table' => $modelo,
        ];

        return view(APP_THEME.$this->viewFolder.'/_show', $data);
    }
}
