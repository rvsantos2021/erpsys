<?php

namespace App\Controllers;

use App\Entities\TipoMovimento;

class TiposMovimentos extends BaseController
{
    protected $db;
    protected $tipoModel;

    private $viewFolder = '/cadastros/estoque/tipos_movimentos';
    private $route = 'tiposmovimento';

    /**
     * Método que valida se o tipo de movimento existe. Caso exista retorna um object com os dados do tipo de movimento, caso
     * não exista, retorna um Exception.
     *
     * @param int $id
     *
     * @return object ou Exception
     */
    private function validation_tipo(int $id = null)
    {
        if (!$id || !$tipo = $this->tipoModel->withDeleted(true)->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Tipo de Movimento ID: $id não encontrado!");
        }

        return $tipo;
    }

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->tipoModel = new \App\Models\TipoMovimentoModel();
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
            'title' => 'Tipos de Movimento',
        ];

        return view(APP_THEME.$this->viewFolder.'/list', $data);
    }

    /**
     * Metodo chamado via AJAX que retorna um JSON com os dados de todos os tipos de movimentos.
     *
     * @return JSON
     */
    public function fetch()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $columns = [
            0 => 'tipos_movimentos.id',
            1 => 'tipos_movimentos.descricao',
            2 => 'tipos_movimentos.movimento',
            3 => 'tipos_movimentos.estoque',
            4 => 'tipos_movimentos.active',
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

        $tipos = $this->tipoModel->getTipoMovimentos($params_array);
        $rowsTotal = $this->tipoModel->countTipoMovimentos($search);

        $rows = 0;
        $data = [];

        foreach ($tipos as $tipo) {
            if (APP_THEME == 'mentor') {
                $act_view = '<button title="Visualizar Tipo de Movimento" data-id="'.$tipo->id.'" data-modulo="view" class="btn btn-sm btn-icon btn-outline-dark btn-round btn-view"><i class="ti ti-eye"></i></button>';
                $act_edit = '<button title="Editar Tipo de Movimento" data-id="'.$tipo->id.'" data-modulo="edit" class="btn btn-sm btn-icon btn-outline-primary btn-round btn-edit"><i class="ti ti-pencil"></i></button>';

                $estoque = ($tipo->estoque == true ? '<span class="btn btn-sm btn-icon btn-round btn-inverse-success"><i class="ti ti-check" title="Sim"></i></span>' : '<span class="btn btn-sm btn-icon btn-round btn-inverse-danger"><i class="ti ti-na" title="Não"></i></span>');
                $status = ($tipo->active == true ? '<span class="btn btn-sm btn-icon btn-round btn-inverse-success"><i class="ti ti-unlock" title="Ativo"></i></span>' : '<span class="btn btn-sm btn-icon btn-round btn-inverse-danger"><i class="ti ti-lock" title="Inativo"></i></span>');
            } else {
                $act_view = '<button data-toggle="tooltip" data-original-title="Visualizar Tipo de Movimento" title="Visualizar Tipo de Movimento" data-id="'.$tipo->id.'" data-modulo="view" class="btn btn-xs btn-default text-primary btn-width-27 btn-view"><i class="fa fa-eye"></i></button>';
                $act_edit = '<button data-toggle="tooltip" data-original-title="Editar Tipo de Movimento" title="Editar Tipo de Movimento" data-id="'.$tipo->id.'" data-modulo="edit" class="btn btn-xs btn-default btn-width-27 btn-edit"><i class="fas fa-edit"></i></button>';

                $estoque = ($tipo->estoque == true ? '<span class="text-success">SIM</span>' : '<span class="text-danger">NÃO</span>');
                $status = ($tipo->active == true ? '<span class="btn btn-xs btn-default rounded-circle-custom text-success" data-toggle="tooltip" data-original-title="Ativo"><i class="fa fa-unlock" title="Ativo"></i></span>' : '<span class="btn btn-xs btn-default rounded-circle-custom text-danger" data-toggle="tooltip" data-original-title="Inativo"><i class="fa fa-lock" title="Inativo"></i></span>');
            }

            $sub_array = [];

            $sub_array[] = $tipo->id;
            $sub_array[] = $tipo->descricao;
            $sub_array[] = $tipo->labelMovimentoControl();
            $sub_array[] = $estoque;
            $sub_array[] = $status;
            $sub_array[] = $act_view.$act_edit.$tipo->buttonsControl();

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
     * Método que retorna a view de inclusão de tipo de movimento.
     *
     * @return view
     */
    public function add()
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('listar-'.$this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>'.$this->getLoggedUserData()->name.'</b> não possui permissão para acessar este módulo.');
        }

        $tipo = new TipoMovimento();

        $data = [
            'title' => 'Novo Tipo de Movimento',
            'method' => 'insert',
            'viewpath' => APP_THEME.$this->viewFolder,
            'table' => $tipo,
            'form' => 'form',
            'response' => 'response',
        ];

        return view(APP_THEME.'/layout/modals/_modal', $data);
    }

    /**
     * Método que faz o insert dos dados do tipo de movimento.
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

        if (APP_THEME == 'mentor') {
            if (isset($post['estoque'])) {
                $post['estoque'] = ($post['estoque'] == 'on' ? true : false);
            } else {
                $post['estoque'] = false;
            }
        }

        $tipo = new TipoMovimento($post);

        try {
            $this->db->transStart(); // Inicia a transação

            // Insere o tipo de movimento
            if (!$this->tipoModel->protect(false)->insert($tipo, true)) {
                throw new \Exception('Erro ao inserir o tipo de movimento.');
            }

            $tipo_id = $this->tipoModel->getInsertID();

            $this->db->transComplete(); // Finaliza a transação

            if ($this->db->transStatus() === false) {
                throw new \Exception('Erro ao completar a transação.');
            }

            if (!$this->tipoModel->errors()) {
                $return['success'] = 'Dados salvos com sucesso!';
            } else {
                $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
                $return['errors_model'] = $this->tipoModel->errors();
            }

            $return['id'] = $tipo_id;

            return $this->response->setJSON($return);
        } catch (\Exception $e) {
            $this->db->transRollback(); // Reverte as mudanças em caso de erro

            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $e->getMessage();

            return $this->response->setJSON($return);
        }
    }

    /**
     * Método que retorna a view de edição dos dados do tipo de movimento.
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

        $tipo = $this->validation_tipo($id);

        $data = [
            'title' => 'Editar Tipo de Movimento',
            'method' => 'update',
            'viewpath' => APP_THEME.$this->viewFolder,
            'form' => 'form',
            'response' => 'response',
            'table' => $tipo,
        ];

        return view(APP_THEME.'/layout/modals/_modal', $data);
    }

    /**
     * Método que faz o update dos dados do tipo de movimento.
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

        if (APP_THEME == 'mentor') {
            if (isset($post['estoque'])) {
                $post['estoque'] = ($post['estoque'] == 'on' ? true : false);
            } else {
                $post['estoque'] = false;
            }
        }

        try {
            $this->db->transStart(); // Inicia a transação

            $tipo = $this->validation_tipo($post['id']);
            $tipo->fill($post);

            if ($tipo->hasChanged()) {
                $this->tipoModel->protect(false)->save($tipo);
            }

            $this->db->transComplete(); // Finaliza a transação

            if ($this->db->transStatus() === false) {
                throw new \Exception('Erro ao salvar os dados.');
            }

            if (!$this->tipoModel->errors()) {
                $return['success'] = 'Dados salvos com sucesso!';
            } else {
                $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
                $return['errors_model'] = $this->tipoModel->errors();
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
     * Método que retorna a view de deleção do tipo de movimento.
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

        $tipo = $this->validation_tipo($id);

        $data = [
            'title' => 'Excluir',
            'method' => 'delete',
            'table' => $tipo,
        ];

        return view(APP_THEME.$this->viewFolder.'/_delete', $data);
    }

    /**
     * Método que faz a deleção do tipo de movimento.
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

        $tipo = $this->validation_tipo($id);

        $this->tipoModel->delete($tipo->id);

        $tipo->active = false;

        $this->tipoModel->protect(false)->save($tipo);

        if (!$this->tipoModel->errors()) {
            $return['success'] = 'Removido com sucesso!';
        } else {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $this->tipoModel->errors();
        }

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view de restore do tipo de movimento.
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

        $tipo = $this->validation_tipo($id);

        $data = [
            'title' => 'Restaurar',
            'method' => 'restore',
            'table' => $tipo,
        ];

        return view(APP_THEME.$this->viewFolder.'/_restore', $data);
    }

    /**
     * Método que faz o restore do tipo de movimento.
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

        $tipo = $this->validation_tipo($id);

        $tipo->deleted_at = null;
        $tipo->active = true;

        $this->tipoModel->protect(false)->save($tipo);

        if (!$this->tipoModel->errors()) {
            $return['success'] = 'Restaurado com sucesso!';
        } else {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $this->tipoModel->errors();
        }

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view de visualização dos dados do tipo de movimento.
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

        $tipo = $this->validation_tipo($id);

        $data = [
            'title' => 'Visualizar',
            'table' => $tipo,
        ];

        return view(APP_THEME.$this->viewFolder.'/_show', $data);
    }
}
