<?php

namespace App\Controllers;

use App\Entities\TabelaPreco;

class TabelasPrecos extends BaseController
{
    protected $db;
    protected $tabelaModel;

    private $viewFolder = '/cadastros/estoque/tabelas_precos';
    private $route = 'tabelas';

    /**
     * Método que valida se a tabela existe. Caso exista retorna um object com os dados da tabela, caso
     * não exista, retorna um Exception.
     *
     * @param int $id
     *
     * @return object ou Exception
     */
    private function validation_tabela(int $id = null)
    {
        if (!$id || !$tabela = $this->tabelaModel->withDeleted(true)->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Tabela de Preço ID: $id não encontrada!");
        }

        return $tabela;
    }

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->tabelaModel = new \App\Models\TabelaPrecoModel();
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
            'title' => 'Tabelas de Preços',
        ];

        return view(APP_THEME.$this->viewFolder.'/list', $data);
    }

    /**
     * Metodo chamado via AJAX que retorna um JSON com os dados de todas as tabelas.
     *
     * @return JSON
     */
    public function fetch()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $columns = [
            0 => 'tabelas_precos.id',
            1 => 'tabelas_precos.descricao',
            2 => 'tabelas_precos.active',
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

        $tabelas = $this->tabelaModel->getTabelas($params_array);
        $rowsTotal = $this->tabelaModel->countTabelas($search);

        $rows = 0;
        $data = [];

        foreach ($tabelas as $tabela) {
            if (APP_THEME == 'mentor') {
                $act_view = '<button title="Visualizar Tabela de Preços" data-id="'.$tabela->id.'" data-modulo="view" class="btn btn-sm btn-icon btn-outline-dark btn-round btn-view"><i class="ti ti-eye"></i></button>';
                $act_edit = '<button title="Editar Tabela de Preços" data-id="'.$tabela->id.'" data-modulo="edit" class="btn btn-sm btn-icon btn-outline-primary btn-round btn-edit"><i class="ti ti-pencil"></i></button>';

                $status = ($tabela->active == true ? '<span class="btn btn-sm btn-icon btn-round btn-inverse-success"><i class="ti ti-unlock" title="Ativo"></i></span>' : '<span class="btn btn-sm btn-icon btn-round btn-inverse-danger"><i class="ti ti-lock" title="Inativo"></i></span>');
            } else {
                $act_view = '<button data-toggle="tooltip" data-original-title="Visualizar Tabela de Preço" title="Visualizar Tabela de Preço" data-id="'.$tabela->id.'" data-modulo="view" class="btn btn-xs btn-default text-primary btn-width-27 btn-view"><i class="fa fa-eye"></i></button>';
                $act_edit = '<button data-toggle="tooltip" data-original-title="Editar Tabela de Preço" title="Editar Tabela de Preço" data-id="'.$tabela->id.'" data-modulo="edit" class="btn btn-xs btn-default btn-width-27 btn-edit"><i class="fas fa-edit"></i></button>';

                $status = ($tabela->active == true ? '<span class="btn btn-xs btn-default rounded-circle-custom text-success" data-toggle="tooltip" data-original-title="Ativo"><i class="fa fa-unlock" title="Ativo"></i></span>' : '<span class="btn btn-xs btn-default rounded-circle-custom text-danger" data-toggle="tooltip" data-original-title="Inativo"><i class="fa fa-lock" title="Inativo"></i></span>');
            }
            $sub_array = [];

            $sub_array[] = $tabela->id;
            $sub_array[] = $tabela->descricao;
            $sub_array[] = $status;
            $sub_array[] = $act_view.$act_edit.$tabela->buttonsControl();

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
     * Método que retorna a view de inclusão de tabela.
     *
     * @return view
     */
    public function add()
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('listar-'.$this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>'.$this->getLoggedUserData()->name.'</b> não possui permissão para acessar este módulo.');
        }

        $tabela = new TabelaPreco();

        $data = [
            'title' => 'Nova Tabela de Preço',
            'method' => 'insert',
            'viewpath' => APP_THEME.$this->viewFolder,
            'form' => 'form',
            'response' => 'response',
            'table' => $tabela,
        ];

        return view(APP_THEME.'/layout/modals/_modal', $data);
    }

    /**
     * Método que retorna a view de inclusão de tabela.
     *
     * @return view
     */
    public function add_modal()
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('listar-'.$this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>'.$this->getLoggedUserData()->name.'</b> não possui permissão para acessar este módulo.');
        }

        $tabela = new TabelaPreco();

        $data = [
            'title' => 'Nova Tabela de Preço',
            'method' => 'insert',
            'viewpath' => APP_THEME.$this->viewFolder,
            'form' => 'formAddTabela',
            'response' => 'responseTabela',
            'table' => $tabela,
        ];

        return view(APP_THEME.'/layout/modals/_modal', $data);
    }

    /**
     * Método que faz o insert dos dados da tabela.
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

        $tabela = new TabelaPreco($post);

        try {
            $this->db->transStart(); // Inicia a transação

            // Insere a tabela
            if (!$this->tabelaModel->protect(false)->insert($tabela, true)) {
                throw new \Exception('Erro ao inserir a tabela de preço.');
            }

            $tabela_id = $this->tabelaModel->getInsertID();

            $this->db->transComplete(); // Finaliza a transação

            if ($this->db->transStatus() === false) {
                throw new \Exception('Erro ao completar a transação.');
            }

            if (!$this->tabelaModel->errors()) {
                $return['success'] = 'Dados salvos com sucesso!';
            } else {
                $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
                $return['errors_model'] = $this->tabelaModel->errors();
            }

            $return['id'] = $tabela_id;
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
     * Método que retorna a view de edição dos dados da tabela.
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

        $tabela = $this->validation_tabela($id);

        $data = [
            'title' => 'Editar Tabela de Preço',
            'method' => 'update',
            'viewpath' => APP_THEME.$this->viewFolder,
            'form' => 'form',
            'response' => 'response',
            'table' => $tabela,
        ];

        return view(APP_THEME.'/layout/modals/_modal', $data);
    }

    /**
     * Método que faz o update dos dados da tabela.
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

            $tabela = $this->validation_tabela($post['id']);
            $tabela->fill($post);

            if ($tabela->hasChanged()) {
                $this->tabelaModel->protect(false)->save($tabela);
            }

            $this->db->transComplete(); // Finaliza a transação

            if ($this->db->transStatus() === false) {
                throw new \Exception('Erro ao salvar os dados.');
            }

            if (!$this->tabelaModel->errors()) {
                $return['success'] = 'Dados salvos com sucesso!';
            } else {
                $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
                $return['errors_model'] = $this->tabelaModel->errors();
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
     * Método que retorna a view de deleção da tabela.
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

        $tabela = $this->validation_tabela($id);

        $data = [
            'title' => 'Excluir',
            'method' => 'delete',
            'table' => $tabela,
        ];

        return view(APP_THEME.$this->viewFolder.'/_delete', $data);
    }

    /**
     * Método que faz a deleção da tabela.
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

        $tabela = $this->validation_tabela($id);

        $this->tabelaModel->delete($tabela->id);

        $tabela->active = false;

        $this->tabelaModel->protect(false)->save($tabela);

        if (!$this->tabelaModel->errors()) {
            $return['success'] = 'Removido com sucesso!';
        } else {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $this->tabelaModel->errors();
        }

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view de restore da tabela.
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

        $tabela = $this->validation_tabela($id);

        $data = [
            'title' => 'Restaurar',
            'method' => 'restore',
            'table' => $tabela,
        ];

        return view(APP_THEME.$this->viewFolder.'/_restore', $data);
    }

    /**
     * Método que faz o restore da tabela.
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

        $tabela = $this->validation_tabela($id);

        $tabela->deleted_at = null;
        $tabela->active = true;

        $this->tabelaModel->protect(false)->save($tabela);

        if (!$this->tabelaModel->errors()) {
            $return['success'] = 'Restaurado com sucesso!';
        } else {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $this->tabelaModel->errors();
        }

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view de visualização dos dados da tabela.
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

        $tabela = $this->validation_tabela($id);

        $data = [
            'title' => 'Visualizar',
            'table' => $tabela,
        ];

        return view(APP_THEME.$this->viewFolder.'/_show', $data);
    }
}
