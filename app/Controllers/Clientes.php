<?php

namespace App\Controllers;

use App\Entities\Cliente;
use App\Entities\ClienteEndereco;

class Clientes extends BaseController
{
    protected $db;
    protected $clienteModel;
    protected $enderecoModel;
    protected $cidadeModel;

    private $viewFolder = '/cadastros/clientes';
    private $route = 'clientes';

    /**
     * Método que valida se o cliente existe. Caso exista retorna um object com os dados do cliente, caso
     * não exista, retorna um Exception.
     *
     * @param int $id
     *
     * @return object ou Exception
     */
    private function validation_cliente(int $id = null)
    {
        if (!$id || !$cliente = $this->clienteModel->withDeleted(true)->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Cliente ID: $id não encontrado!");
        }

        return $cliente;
    }

    /**
     * Método que valida se o endereço do cliente existe. Caso exista retorna um object com os dados do endereço, caso
     * não exista, retorna um Exception.
     *
     * @param int $id
     *
     * @return object ou Exception
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
        $this->clienteModel = new \App\Models\ClienteModel();
        $this->enderecoModel = new \App\Models\ClienteEnderecoModel();
        $this->cidadeModel = new \App\Models\CidadeModel();
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
            'title' => 'Clientes',
        ];

        return view(APP_THEME.$this->viewFolder.'/list', $data);
    }

    /**
     * Metodo chamado via AJAX que retorna um JSON com os dados de todos as clientes.
     *
     * @return JSON
     */
    public function fetch()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $columns = [
            0 => 'clientes.id',
            1 => 'clientes.razao_social',
            2 => 'clientes.nome_fantasia',
            3 => 'clientes.cnpj',
            4 => 'clientes.email',
            5 => 'clientes.active',
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

        $clientes = $this->clienteModel->getClientes($params_array);
        $rowsTotal = $this->clienteModel->countClientes($search);

        $rows = 0;
        $data = [];

        foreach ($clientes as $cliente) {
            if (APP_THEME == 'mentor') {
                $act_view = '<button title="Visualizar Cliente" data-id="'.$cliente->id.'" data-modulo="view" class="btn btn-sm btn-icon btn-outline-dark btn-round btn-view"><i class="ti ti-eye"></i></button>';
                $act_edit = '<a href="'.site_url('/clientes/edit/'.$cliente->id).'" title="Editar Cliente" data-id="'.$cliente->id.'" data-modulo="edit" class="btn btn-sm btn-icon btn-outline-primary btn-round"><i class="ti ti-pencil"></i></a>';

                $email = $cliente->email != '' ? '<a href="mailto:'.$cliente->email.'" class="btn btn-sm btn-icon btn-round btn-inverse-info" data-toggle="tooltip" data-html="true" data-original-title="'.$cliente->email.'" title="'.$cliente->email.'"><i class="fa fa-envelope"></i></a>' : '';
                $status = ($cliente->active == true ? '<span class="btn btn-sm btn-icon btn-round btn-inverse-success"><i class="ti ti-unlock" title="Ativo"></i></span>' : '<span class="btn btn-sm btn-icon btn-round btn-inverse-danger"><i class="ti ti-lock" title="Inativo"></i></span>');
            } else {
                $act_view = '<button data-toggle="tooltip" data-original-title="Visualizar" title="Visualizar" data-id="'.$cliente->id.'" data-modulo="view" class="btn btn-xs btn-default text-primary btn-width-27 btn-view"><i class="fa fa-eye"></i></button>';
                $act_edit = '<button data-toggle="tooltip" data-original-title="Editar" title="Editar" data-id="'.$cliente->id.'" data-modulo="edit" class="btn btn-xs btn-default btn-width-27 btn-edit"><i class="fas fa-edit"></i></button>';

                $email = $cliente->email != '' ? '<a href="mailto:'.$cliente->email.'" class="btn btn-xs btn-info rounded-circle img-fluid" data-toggle="tooltip" data-html="true" data-original-title="'.$cliente->email.'" title="'.$cliente->email.'"><i class="fa fa-envelope"></i></a>' : '';
                $status = ($cliente->active == true ? '<span class="text-success"><i class="fa fa-unlock" title="Ativo"></i></span>' : '<span class="text-danger"><i class="fa fa-lock" title="Inativo"></i></span>');
            }

            $sub_array = [];

            $sub_array[] = $cliente->id;
            $sub_array[] = $cliente->razao_social;
            $sub_array[] = $cliente->nome_fantasia;
            $sub_array[] = $cliente->cnpj;
            $sub_array[] = $email;
            $sub_array[] = $status;
            $sub_array[] = $act_view.$act_edit.$cliente->buttonsControl();

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
     * Método que retorna a view de inclusão de cliente.
     *
     * @return view
     */
    public function add()
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('criar-'.$this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>'.$this->getLoggedUserData()->name.'</b> não possui permissão para acessar este módulo.');
        }

        $cliente = new Cliente();

        $data = [
            'menu' => 'Cadastros',
            'submenu' => 'Cliente',
            'title' => 'Novo Cliente',
            'method' => 'insert',
            'viewpath' => APP_THEME.$this->viewFolder,
            'form' => 'form',
            'response' => 'response',
            'table' => $cliente,
            'cidades' => $this->cidadeModel->getAllCidades(),
            'enderecos' => $this->enderecoModel->getEnderecoscliente(0),
        ];

        if (APP_THEME == 'mentor') {
            return view(APP_THEME.$this->viewFolder.'/form', $data);
        } else {
            return view(APP_THEME.'/layout/modals/_modal', $data);
        }
    }

    /**
     * Método que faz o insert dos dados do cliente.
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
                    'cep' => $cep,
                    'logradouro' => $post['end_log'][$index],
                    'numero' => $post['end_nro'][$index],
                    'complemento' => $post['end_cpl'][$index],
                    'bairro' => $post['end_bai'][$index],
                    'cidade_id' => $post['end_cid'][$index],
                    'tipo' => $post['end_tip'][$index],
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

        // Define o tipo de cliente (Física ou Jurídica)
        $post['tipo'] = strlen($post['cnpj']) == 18 ? 'J' : 'F';

        // print_r($post);
        // exit();

        $cliente = new Cliente($post);

        try {
            $this->db->transStart(); // Inicia a transação

            // Insere a cliente
            if (!$this->clienteModel->protect(false)->insert($cliente, true)) {
                throw new \Exception('Erro ao inserir o Cliente.');
            }

            $cliente_id = $this->clienteModel->getInsertID();

            // Insere os endereços
            foreach ($enderecos_data as $endereco_data) {
                $endereco_data['cliente_id'] = $cliente_id;
                $endereco_data['active'] = true;

                $endereco = new ClienteEndereco($endereco_data);

                if (!$this->enderecoModel->protect(false)->insert($endereco, false)) {
                    throw new \Exception('Erro ao inserir um dos endereços.');
                }
            }

            $this->db->transComplete(); // Finaliza a transação

            if ($this->db->transStatus() === false) {
                throw new \Exception('Erro ao completar a transação.');
            }

            if (!$this->clienteModel->errors()) {
                $return['success'] = 'Dados salvos com sucesso!';
            } else {
                $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
                $return['errors_model'] = $this->clienteModel->errors();
            }

            $return['id'] = $cliente_id;

            return $this->response->setJSON($return);
        } catch (\Exception $e) {
            $this->db->transRollback(); // Reverte as mudanças em caso de erro

            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $e->getMessage();

            return $this->response->setJSON($return);
        }
    }

    /**
     * Método que retorna a view de edição dos dados do cliente.
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

        $cliente = $this->validation_cliente($id);

        $data = [
            'menu' => 'Cadastros',
            'submenu' => 'Cliente',
            'title' => 'Editar Cliente',
            'method' => 'update',
            'viewpath' => APP_THEME.$this->viewFolder,
            'form' => 'form',
            'response' => 'response',
            'cidades' => $this->cidadeModel->getAllCidades(),
            'table' => $cliente,
            'enderecos' => $this->enderecoModel->getEnderecosCliente($id),
        ];

        if (APP_THEME == 'mentor') {
            return view(APP_THEME.$this->viewFolder.'/form', $data);
        } else {
            // return view(APP_THEME . $this->viewFolder . '/_edit', $data);
            return view(APP_THEME.'/layout/modals/_modal', $data);
        }
    }

    /**
     * Método que faz o update dos dados do cliente.
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
                    'id' => $post['end_id'][$index] ?? null,
                    'cep' => $cep,
                    'logradouro' => $post['end_log'][$index],
                    'numero' => $post['end_nro'][$index],
                    'complemento' => $post['end_cpl'][$index],
                    'bairro' => $post['end_bai'][$index],
                    'cidade_id' => $post['end_cid'][$index],
                    'tipo' => $post['end_tip'][$index],
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

        // Define o tipo de cliente (PF ou PJ)
        $post['tipo'] = strlen($post['cnpj']) == 18 ? 'J' : 'F';

        try {
            $this->db->transStart(); // Inicia a transação

            $cliente = $this->validation_cliente($post['id']);
            $cliente->fill($post);

            if ($cliente->hasChanged()) {
                $this->clienteModel->protect(false)->save($cliente);
            }

            // IDs de endereços recebidos do formulário
            $enderecos_ids = array_filter(array_column($enderecos_data, 'id'));

            // Exclui (soft delete) endereços que não estão no formulário
            if (!empty($enderecos_ids)) {
                $this->enderecoModel->where('cliente_id', $cliente->id)
                    ->whereNotIn('id', $enderecos_ids)
                    ->set(['active' => false])
                    ->delete(null, false);
            } else {
                // Se nenhum endereço foi enviado, inativa todos os endereços da cliente
                $this->enderecoModel->where('cliente_id', $cliente->id)
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
                    $endereco_data['cliente_id'] = $cliente->id;
                    $endereco_data['active'] = true;

                    $this->enderecoModel->insert($endereco_data, false);
                }
            }

            $this->db->transComplete(); // Finaliza a transação

            if ($this->db->transStatus() === false) {
                throw new \Exception('Erro ao salvar os dados.');
            }

            if (!$this->clienteModel->errors()) {
                $return['success'] = 'Dados salvos com sucesso!';
            } else {
                $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
                $return['errors_model'] = $this->clienteModel->errors();
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
     * Método que retorna a view de deleção do cliente.
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

        $cliente = $this->validation_cliente($id);

        $data = [
            'title' => 'Excluir',
            'method' => 'delete',
            'cliente' => $cliente,
        ];

        return view(APP_THEME.$this->viewFolder.'/_delete', $data);
    }

    /**
     * Método que faz a deleção da cliente.
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

        $cliente = $this->validation_cliente($id);

        $this->clienteModel->delete($cliente->id);

        $cliente->active = false;

        $this->clienteModel->protect(false)->save($cliente);

        if (!$this->clienteModel->errors()) {
            $return['success'] = 'Removido com sucesso!';
        } else {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $this->clienteModel->errors();
        }

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view de restore da cliente.
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

        $cliente = $this->validation_cliente($id);

        $data = [
            'title' => 'Restaurar',
            'method' => 'restore',
            'cliente' => $cliente,
        ];

        return view(APP_THEME.$this->viewFolder.'/_restore', $data);
    }

    /**
     * Método que faz o restore da cliente.
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

        $cliente = $this->validation_cliente($id);

        $cliente->deleted_at = null;
        $cliente->active = true;

        $this->clienteModel->protect(false)->save($cliente);

        if (!$this->clienteModel->errors()) {
            $return['success'] = 'Restaurado com sucesso!';
        } else {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $this->clienteModel->errors();
        }

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view de visualização dos dados do cliente.
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

        $cliente = $this->validation_cliente($id);

        $data = [
            'menu' => 'Cadastros',
            'title' => 'Visualizar',
            'cliente' => $cliente,
            'enderecos' => $this->enderecoModel->getEnderecosCliente($id),
        ];

        return view(APP_THEME.$this->viewFolder.'/_show', $data);
    }
}
