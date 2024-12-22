<?php

namespace App\Controllers;

use App\Entities\Vendedor;

class Vendedores extends BaseController
{
    protected $db;
    protected $vendedorModel;

    private $viewFolder = '/cadastros/vendedores';
    private $route = 'vendedores';

    /**
     * Método que valida se o vendedor existe. Caso exista retorna um object com os dados do vendedor, caso
     * não exista, retorna um Exception.
     *
     * @param int $id
     *
     * @return object ou Exception
     */
    private function validation_vendedor(int $id = null)
    {
        if (!$id || !$vendedor = $this->vendedorModel->withDeleted(true)->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Vendedor ID: $id não encontrado!");
        }

        return $vendedor;
    }

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->vendedorModel = new \App\Models\VendedorModel();
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
            'menu' => 'Cadastros',
            'title' => 'Vendedores',
        ];

        return view(APP_THEME.$this->viewFolder.'/list', $data);
    }

    /**
     * Metodo chamado via AJAX que retorna um JSON com os dados de todos os vendedores.
     *
     * @return JSON
     */
    public function fetch()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $columns = [
            0 => 'vendedores.id',
            1 => 'vendedores.razao_social',
            2 => 'vendedores.nome_fantasia',
            3 => 'vendedores.cnpj',
            4 => 'vendedores.email',
            5 => 'vendedores.active',
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

        $vendedores = $this->vendedorModel->getVendedores($params_array);
        $rowsTotal = $this->vendedorModel->countVendedores($search);

        $rows = 0;
        $data = [];

        foreach ($vendedores as $vendedor) {
            if (APP_THEME == 'mentor') {
                $act_view = '<button title="Visualizar Vendedor" data-id="'.$vendedor->id.'" data-modulo="view" class="btn btn-sm btn-icon btn-outline-dark btn-round btn-view"><i class="ti ti-eye"></i></button>';
                $act_edit = '<button title="Editar Vendedor" data-id="'.$vendedor->id.'" data-modulo="edit" class="btn btn-sm btn-icon btn-outline-primary btn-round btn-edit"><i class="ti ti-pencil"></i></button>';

                $email = $vendedor->email != '' ? '<a href="mailto:'.$vendedor->email.'" class="btn btn-sm btn-icon btn-round btn-inverse-info" data-toggle="tooltip" data-html="true" data-original-title="'.$vendedor->email.'" title="'.$vendedor->email.'"><i class="fa fa-envelope"></i></a>' : '';
                $status = ($vendedor->active == true ? '<span class="btn btn-sm btn-icon btn-round btn-inverse-success"><i class="ti ti-unlock" title="Ativo"></i></span>' : '<span class="btn btn-sm btn-icon btn-round btn-inverse-danger"><i class="ti ti-lock" title="Inativo"></i></span>');
            } else {
                $act_view = '<button data-toggle="tooltip" data-original-title="Visualizar Vendedor" title="Visualizar Vendedor" data-id="'.$vendedor->id.'" data-modulo="view" class="btn btn-xs btn-default text-primary btn-width-27 btn-view"><i class="fa fa-eye"></i></button>';
                $act_edit = '<button data-toggle="tooltip" data-original-title="Editar Vendedor" title="Editar Vendedor" data-id="'.$vendedor->id.'" data-modulo="edit" class="btn btn-xs btn-default btn-width-27 btn-edit"><i class="fas fa-edit"></i></button>';

                $email = $vendedor->email != '' ? '<a href="mailto:'.$vendedor->email.'" class="btn btn-xs btn-info rounded-circle img-fluid" data-toggle="tooltip" data-html="true" data-original-title="'.$vendedor->email.'" title="'.$vendedor->email.'"><i class="fa fa-envelope"></i></a>' : '';
                $status = ($vendedor->active == true ? '<span class="text-success"><i class="fa fa-unlock" title="Ativo"></i></span>' : '<span class="text-danger"><i class="fa fa-lock" title="Inativo"></i></span>');
            }

            $sub_array = [];

            $sub_array[] = $vendedor->id;
            $sub_array[] = $vendedor->razao_social;
            $sub_array[] = $vendedor->nome_fantasia;
            $sub_array[] = $vendedor->cnpj;
            $sub_array[] = $email;
            $sub_array[] = $status;
            $sub_array[] = $act_view.$act_edit.$vendedor->buttonsControl();

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
     * Método que retorna a view de inclusão de vendedor.
     *
     * @return view
     */
    public function add()
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('listar-'.$this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>'.$this->getLoggedUserData()->name.'</b> não possui permissão para acessar este módulo.');
        }

        $vendedor = new Vendedor();

        $data = [
            'title' => 'Novo Vendedor',
            'method' => 'insert',
            'viewpath' => APP_THEME.$this->viewFolder,
            'form' => 'form',
            'response' => 'response',
            'table' => $vendedor,
        ];

        // return view(APP_THEME . $this->viewFolder . '/_add', $data);
        return view(APP_THEME.'/layout/modals/_modal', $data);
    }

    /**
     * Método que faz o insert dos dados do vendedor.
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

        $perc_comissao = str_replace(',', '.', str_replace('.', '', $post['perc_comissao']));
        $post['perc_comissao'] = $perc_comissao;

        // Define o tipo de vendedor (Física ou Jurídica)
        $post['tipo'] = strlen($post['cnpj']) == 18 ? 'J' : 'F';

        $vendedor = new Vendedor($post);

        try {
            $this->db->transStart(); // Inicia a transação

            // Insere a vendedor
            if (!$this->vendedorModel->protect(false)->insert($vendedor, true)) {
                //print_r($this->db->getLastQuery());
                throw new \Exception('Erro ao inserir o Vendedor.');
            }

            $vendedor_id = $this->vendedorModel->getInsertID();

            $this->db->transComplete(); // Finaliza a transação

            if ($this->db->transStatus() === false) {
                throw new \Exception('Erro ao completar a transação.');
            }

            if (!$this->vendedorModel->errors()) {
                $return['success'] = 'Dados salvos com sucesso!';
            } else {
                $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
                $return['errors_model'] = $this->vendedorModel->errors();
            }

            $return['id'] = $vendedor_id;

            return $this->response->setJSON($return);
        } catch (\Exception $e) {
            $this->db->transRollback(); // Reverte as mudanças em caso de erro

            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $e->getMessage();

            return $this->response->setJSON($return);
        }
    }

    /**
     * Método que retorna a view de edição dos dados do vendedor.
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

        $vendedor = $this->validation_vendedor($id);

        $data = [
            'title' => 'Editar Vendedor',
            'method' => 'update',
            'viewpath' => APP_THEME.$this->viewFolder,
            'form' => 'form',
            'response' => 'response',
            'table' => $vendedor,
        ];

        // return view(APP_THEME . $this->viewFolder . '/_edit', $data);
        return view(APP_THEME.'/layout/modals/_modal', $data);
    }

    /**
     * Método que faz o update dos dados do vendedor.
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

        //$perc_comissao = str_replace(',', '.', str_replace('.', '', $post['perc_comissao']));
        //$post['perc_comissao'] = $perc_comissao;
        $post['perc_comissao'] = convertDecimal($post['perc_comissao']);

        // Define o tipo de vendedor (PF ou PJ)
        $post['tipo'] = strlen($post['cnpj']) == 18 ? 'J' : 'F';

        try {
            $this->db->transStart(); // Inicia a transação

            $vendedor = $this->validation_vendedor($post['id']);
            $vendedor->fill($post);

            if ($vendedor->hasChanged()) {
                $this->vendedorModel->protect(false)->save($vendedor);
            }

            $this->db->transComplete(); // Finaliza a transação

            if ($this->db->transStatus() === false) {
                throw new \Exception('Erro ao salvar os dados.');
            }

            if (!$this->vendedorModel->errors()) {
                $return['success'] = 'Dados salvos com sucesso!';
            } else {
                $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
                $return['errors_model'] = $this->vendedorModel->errors();
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
     * Método que retorna a view de deleção do vendedor.
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

        $vendedor = $this->validation_vendedor($id);

        $data = [
            'title' => 'Excluir',
            'method' => 'delete',
            'table' => $vendedor,
        ];

        return view(APP_THEME.$this->viewFolder.'/_delete', $data);
    }

    /**
     * Método que faz a deleção da vendedor.
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

        $vendedor = $this->validation_vendedor($id);

        $this->vendedorModel->delete($vendedor->id);

        $vendedor->active = false;

        $this->vendedorModel->protect(false)->save($vendedor);

        if (!$this->vendedorModel->errors()) {
            $return['success'] = 'Removido com sucesso!';
        } else {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $this->vendedorModel->errors();
        }

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view de restore do vendedor.
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

        $vendedor = $this->validation_vendedor($id);

        $data = [
            'title' => 'Restaurar',
            'method' => 'restore',
            'table' => $vendedor,
        ];

        return view(APP_THEME.$this->viewFolder.'/_restore', $data);
    }

    /**
     * Método que faz o restore do vendedor.
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

        $vendedor = $this->validation_vendedor($id);

        $vendedor->deleted_at = null;
        $vendedor->active = true;

        $this->vendedorModel->protect(false)->save($vendedor);

        if (!$this->vendedorModel->errors()) {
            $return['success'] = 'Restaurado com sucesso!';
        } else {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $this->vendedorModel->errors();
        }

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view de visualização dos dados do vendedor.
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

        $vendedor = $this->validation_vendedor($id);

        $data = [
            'menu' => 'Cadastros',
            'title' => 'Visualizar',
            'table' => $vendedor,
        ];

        return view(APP_THEME.$this->viewFolder.'/_show', $data);
    }
}
