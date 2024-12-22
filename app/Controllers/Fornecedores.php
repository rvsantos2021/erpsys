<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Fornecedor;
use App\Entities\FornecedorEndereco;

class Fornecedores extends BaseController
{
    protected $db;
    protected $fornecedorModel;
    protected $enderecoModel;
    protected $cidadeModel;

    private $viewFolder = '/cadastros/fornecedores';
    private $route = 'fornecedores';

    /**
     * Método que valida se o fornecedor existe. Caso exista retorna um object com os dados do fornecedor, caso
     * não exista, retorna um Exception
     * 
     * @param integer $id
     * @return Object ou Exception
     */
    private function validation_fornecedor(int $id = null)
    {
        if (!$id || !$fornecedor = $this->fornecedorModel->withDeleted(true)->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Fornecedor ID: $id não encontrado!");
        }

        return $fornecedor;
    }

    /**
     * Método que valida se o endereço do fornecedor existe. Caso exista retorna um object com os dados do endereço, caso
     * não exista, retorna um Exception
     * 
     * @param integer $id
     * @return Object ou Exception
     */
    private function validation_endereco(int $id = null)
    {
        if (!$id || !$endereco = $this->enderecoModel->withDeleted(true)->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Endereço ID: $id não encontrado!");
        }

        return $endereco;
    }

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->fornecedorModel = new \App\Models\FornecedorModel();
        $this->enderecoModel = new \App\Models\FornecedorEnderecoModel();
        $this->cidadeModel = new \App\Models\CidadeModel();
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
            'menu'  => 'Cadastros',
            'title' => 'Fornecedores',
        );

        return view(APP_THEME . $this->viewFolder . '/list', $data);
    }

    /**
     * Metodo chamado via AJAX que retorna um JSON com os dados de todos as fornecedores
     * 
     * @return JSON
     */
    public function fetch()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $columns = array(
            0 => 'fornecedores.id',
            1 => 'fornecedores.razao_social',
            2 => 'fornecedores.nome_fantasia',
            3 => 'fornecedores.cnpj',
            4 => 'fornecedores.email',
            5 => 'fornecedores.active',
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

        $fornecedores = $this->fornecedorModel->getFornecedores($params_array);
        $rowsTotal = $this->fornecedorModel->countFornecedores($search);

        $rows = 0;
        $data = array();

        foreach ($fornecedores as $fornecedor) {
            if (APP_THEME == 'mentor') {
                $act_view  = '<button title="Visualizar Fornecedor" data-id="' . $fornecedor->id . '" data-modulo="view" class="btn btn-sm btn-icon btn-outline-dark btn-round btn-view"><i class="ti ti-eye"></i></button>';
                $act_edit  = '<a href="' . site_url('/fornecedores/edit/' . $fornecedor->id) . '" title="Editar Fornecedor" data-id="' . $fornecedor->id . '" data-modulo="edit" class="btn btn-sm btn-icon btn-outline-primary btn-round"><i class="ti ti-pencil"></i></a>';

                $email     = $fornecedor->email != '' ? '<a href="mailto:' . $fornecedor->email . '" class="btn btn-sm btn-icon btn-round btn-inverse-info" data-toggle="tooltip" data-html="true" data-original-title="' . $fornecedor->email . '" title="' . $fornecedor->email . '"><i class="fa fa-envelope"></i></a>' : '';
                $status    = ($fornecedor->active == true ? '<span class="btn btn-sm btn-icon btn-round btn-inverse-success"><i class="ti ti-unlock" title="Ativo"></i></span>' : '<span class="btn btn-sm btn-icon btn-round btn-inverse-danger"><i class="ti ti-lock" title="Inativo"></i></span>');
            } else {
                $act_view  = '<button data-toggle="tooltip" data-original-title="Visualizar" title="Visualizar" data-id="' . $fornecedor->id . '" data-modulo="view" class="btn btn-xs btn-default text-primary btn-width-27 btn-view"><i class="fa fa-eye"></i></button>';
                $act_edit  = '<button data-toggle="tooltip" data-original-title="Editar" title="Editar" data-id="' . $fornecedor->id . '" data-modulo="edit" class="btn btn-xs btn-default btn-width-27 btn-edit"><i class="fas fa-edit"></i></button>';

                $email     = $fornecedor->email != '' ? '<a href="mailto:' . $fornecedor->email . '" class="btn btn-xs btn-info rounded-circle img-fluid" data-toggle="tooltip" data-html="true" data-original-title="' . $fornecedor->email . '" title="' . $fornecedor->email . '"><i class="fa fa-envelope"></i></a>' : '';
                $status    = ($fornecedor->active == true ? '<span class="text-success"><i class="fa fa-unlock" title="Ativo"></i></span>' : '<span class="text-danger"><i class="fa fa-lock" title="Inativo"></i></span>');
            }

            $sub_array = array();

            $sub_array[] = $fornecedor->id;
            $sub_array[] = $fornecedor->razao_social;
            $sub_array[] = $fornecedor->nome_fantasia;
            $sub_array[] = $fornecedor->cnpj;
            $sub_array[] = $email;
            $sub_array[] = $status;
            $sub_array[] = $act_view . $act_edit . $fornecedor->buttonsControl();

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
     * Método que retorna a view de inclusão de fornecedor
     * 
     * @return view
     */
    public function add()
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('listar-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $fornecedor = new Fornecedor();

        $data = array(
            'menu'      => 'Cadastros',
            'submenu'   => 'Fornecedores',
            'title'     => 'Incluir',
            'method'    => 'insert',
            'viewpath'  => APP_THEME . $this->viewFolder,
            'form'      => 'form',
            'response'  => 'response',
            'table'     => $fornecedor,
            'cidades'   => $this->cidadeModel->getAllCidades(),
            'enderecos' => $this->enderecoModel->getEnderecosFornecedor(0),
        );

        if (APP_THEME == 'mentor') {
            return view(APP_THEME . $this->viewFolder . '/form', $data);
        } else {
            // return view(APP_THEME . $this->viewFolder . '/_add', $data);
            return view(APP_THEME . '/layout/modals/_modal', $data);
        }
    }

    /**
     * Método que retorna a view de inclusão de fornecedor
     * 
     * @return view
     */
    public function add_modal()
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('listar-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $fornecedor = new Fornecedor();

        $data = array(
            'title'     => 'Novo Fornecedor',
            'method'    => 'insert',
            'viewpath'  => APP_THEME . $this->viewFolder,
            'form'      => 'formAddFornecedor',
            'response'  => 'responseFornecedor',
            'table'     => $fornecedor,
            'cidades'   => $this->cidadeModel->getAllCidades(),
            'enderecos' => $this->enderecoModel->getEnderecosFornecedor(0),
        );

        // return view(APP_THEME . $this->viewFolder . '/_add', $data);
        return view(APP_THEME . '/layout/modals/_modal', $data);
    }

    /**
     * Método que faz o insert dos dados do fornecedor
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

        // Extrai os dados de endereços do POST
        $enderecos_data = [];

        if (isset($post['end_cep'])) {
            foreach ($post['end_cep'] as $index => $cep) {
                $enderecos_data[] = [
                    'cep'         => $cep,
                    'logradouro'  => $post['end_log'][$index],
                    'numero'      => $post['end_nro'][$index],
                    'complemento' => $post['end_cpl'][$index],
                    'bairro'      => $post['end_bai'][$index],
                    'cidade_id'   => $post['end_cid'][$index],
                    'tipo'        => $post['end_tip'][$index],
                ];
            }
        }

        // Limpa os dados desnecessários do POST
        $fields_to_unset = [
            'cep',
            'logradouro',
            'numero',
            'complemento',
            'bairro',
            'cidade',
            'tipo_end',
            'method',
            'end_id',
            'end_cep',
            'end_log',
            'end_nro',
            'end_cpl',
            'end_bai',
            'end_cid',
            'end_tip',
            'cidade_id',
            'cidade_nome',
            'cidade_uf',
        ];

        foreach ($fields_to_unset as $field) {
            unset($post[$field]);
        }

        // Define o tipo de fornecedor (Física ou Jurídica)
        $post['tipo'] = strlen($post['cnpj']) == 18 ? 'J' : 'F';

        $fornecedor = new Fornecedor($post);

        try {
            $this->db->transStart(); // Inicia a transação

            // Insere a fornecedor
            if (!$this->fornecedorModel->protect(false)->insert($fornecedor, true)) {
                //print_r($this->db->getLastQuery());
                throw new \Exception('Erro ao inserir o Fornecedor.');
            }

            $fornecedor_id = $this->fornecedorModel->getInsertID();

            // Insere os endereços
            foreach ($enderecos_data as $endereco_data) {
                $endereco_data['fornecedor_id'] = $fornecedor_id;
                $endereco_data['active'] = true;

                $endereco = new FornecedorEndereco($endereco_data);

                if (!$this->enderecoModel->protect(false)->insert($endereco, false)) {
                    throw new \Exception('Erro ao inserir um dos endereços.');
                }
            }

            $this->db->transComplete(); // Finaliza a transação

            if ($this->db->transStatus() === false) {
                throw new \Exception('Erro ao completar a transação.');
            }

            if (!$this->fornecedorModel->errors()) {
                $return['success'] = 'Dados salvos com sucesso!';
            } else {
                $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
                $return['errors_model'] = $this->fornecedorModel->errors();
            }

            $return['id'] = $fornecedor_id;
            $return['razao_social'] = $post['razao_social'];

            return $this->response->setJSON($return);
        } catch (\Exception $e) {
            $this->db->transRollback(); // Reverte as mudanças em caso de erro

            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $e->getMessage();

            return $this->response->setJSON($return);
        }
    }

    /**
     * Método que retorna a view de edição dos dados do fornecedor
     * 
     * @param $id
     * @return view
     */
    public function edit(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('editar-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $fornecedor = $this->validation_fornecedor($id);

        $data = array(
            'menu'      => 'Cadastros',
            'submenu'   => 'Fornecedores',
            'title'     => 'Editar',
            'method'    => 'update',
            'viewpath'  => APP_THEME . $this->viewFolder,
            'form'      => 'form',
            'response'  => 'response',
            'cidades'   => $this->cidadeModel->getAllCidades(),
            'table'     => $fornecedor,
            'enderecos' => $this->enderecoModel->getEnderecosFornecedor($id),
        );

        if (APP_THEME == 'mentor') {
            return view(APP_THEME . $this->viewFolder . '/form', $data);
        } else {
            // return view(APP_THEME . $this->viewFolder . '/_edit', $data);
            return view(APP_THEME . '/layout/modals/_modal', $data);
        }
    }

    /**
     * Método que faz o update dos dados do fornecedor
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

        // Extrai os dados de endereços do POST
        $enderecos_data = [];

        if (isset($post['end_cep'])) {
            foreach ($post['end_cep'] as $index => $cep) {
                $enderecos_data[] = [
                    'id'          => $post['end_id'][$index] ?? null,
                    'cep'         => $cep,
                    'logradouro'  => $post['end_log'][$index],
                    'numero'      => $post['end_nro'][$index],
                    'complemento' => $post['end_cpl'][$index],
                    'bairro'      => $post['end_bai'][$index],
                    'cidade_id'   => $post['end_cid'][$index],
                    'tipo'        => $post['end_tip'][$index],
                ];
            }
        }

        // Limpa os dados desnecessários do POST
        $fields_to_unset = [
            'cep',
            'logradouro',
            'numero',
            'complemento',
            'bairro',
            'cidade',
            'tipo_end',
            'method',
            'end_id',
            'end_cep',
            'end_log',
            'end_nro',
            'end_cpl',
            'end_bai',
            'end_cid',
            'end_tip',
            'cidade_id',
            'cidade_nome',
            'cidade_uf',
        ];

        foreach ($fields_to_unset as $field) {
            unset($post[$field]);
        }

        // Define o tipo de fornecedor (PF ou PJ)
        $post['tipo'] = strlen($post['cnpj']) == 18 ? 'J' : 'F';

        try {
            $this->db->transStart(); // Inicia a transação

            $fornecedor = $this->validation_fornecedor($post['id']);
            $fornecedor->fill($post);

            if ($fornecedor->hasChanged()) {
                $this->fornecedorModel->protect(false)->save($fornecedor);
            }

            // IDs de endereços recebidos do formulário
            $enderecos_ids = array_filter(array_column($enderecos_data, 'id'));

            // Exclui (soft delete) endereços que não estão no formulário
            if (!empty($enderecos_ids)) {
                $this->enderecoModel->where('fornecedor_id', $fornecedor->id)
                    ->whereNotIn('id', $enderecos_ids)
                    ->set(['active' => false])
                    ->delete(null, false);
            } else {
                // Se nenhum endereço foi enviado, inativa todos os endereços da fornecedor
                $this->enderecoModel->where('fornecedor_id', $fornecedor->id)
                    ->set(['active' => false])
                    ->delete(null, false);
            }

            // Atualiza ou insere os endereços
            foreach ($enderecos_data as $endereco_data) {
                if (!empty($endereco_data['id'])) {
                    // Atualiza o endereço existente
                    $endereco = $this->validation_endereco($endereco_data['id']);
                    $endereco->fill($endereco_data);

                    if ($endereco->hasChanged()) {
                        $this->enderecoModel->protect(false)->save($endereco);
                    }
                } else {
                    // Insere novo endereço
                    $endereco_data['fornecedor_id'] = $fornecedor->id;
                    $endereco_data['active'] = true;

                    $this->enderecoModel->insert($endereco_data, false);
                }
            }

            $this->db->transComplete(); // Finaliza a transação

            if ($this->db->transStatus() === false) {
                throw new \Exception('Erro ao salvar os dados.');
            }

            if (!$this->fornecedorModel->errors()) {
                $return['success'] = 'Dados salvos com sucesso!';
            } else {
                $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
                $return['errors_model'] = $this->fornecedorModel->errors();
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
     * Método que retorna a view de deleção do fornecedor
     * 
     * @param $id
     * @return view
     */
    public function delete(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('excluir-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $fornecedor = $this->validation_fornecedor($id);

        $data = array(
            'title'      => 'Excluir',
            'method'     => 'delete',
            'fornecedor' => $fornecedor,
        );

        return view(APP_THEME . $this->viewFolder . '/_delete', $data);
    }

    /**
     * Método que faz a deleção da fornecedor
     * 
     * @param $id
     * @return redirect
     */
    public function remove(int $id = null)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $fornecedor = $this->validation_fornecedor($id);

        $this->fornecedorModel->delete($fornecedor->id);

        $fornecedor->active = false;

        $this->fornecedorModel->protect(false)->save($fornecedor);

        if (!$this->fornecedorModel->errors()) {
            $return['success'] = 'Removido com sucesso!';
        } else {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $this->fornecedorModel->errors();
        }

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view de restore da fornecedor.
     * 
     * @param $id
     * @return view
     */
    public function undo(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('excluir-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $fornecedor = $this->validation_fornecedor($id);

        $data = [
            'title'      => 'Restaurar',
            'method'     => 'restore',
            'fornecedor' => $fornecedor,
        ];

        return view(APP_THEME . $this->viewFolder . '/_restore', $data);
    }

    /**
     * Método que faz o restore da fornecedor
     * 
     * @param $id
     * @return redirect
     */
    public function restore(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('editar-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $fornecedor = $this->validation_fornecedor($id);

        $fornecedor->deleted_at = null;
        $fornecedor->active = true;

        $this->fornecedorModel->protect(false)->save($fornecedor);

        if (!$this->fornecedorModel->errors()) {
            $return['success'] = 'Restaurado com sucesso!';
        } else {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $this->fornecedorModel->errors();
        }

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view de visualização dos dados do fornecedor
     * 
     * @param $id
     * @return view
     */
    public function show(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('listar-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $fornecedor = $this->validation_fornecedor($id);

        $data = array(
            'menu'       => 'Cadastros',
            'title'      => 'Visualizar',
            'fornecedor' => $fornecedor,
            'enderecos'  => $this->enderecoModel->getEnderecosFornecedor($id),
        );

        return view(APP_THEME . $this->viewFolder . '/_show', $data);
    }
}
