<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Transportadora;
use App\Entities\TransportadoraEndereco;

class Transportadoras extends BaseController
{
    protected $db;
    protected $transportadoraModel;
    protected $enderecoModel;
    protected $cidadeModel;

    private $viewFolder = '/cadastros/transportadoras';
    private $route = 'transportadoras';

    /**
     * Método que valida se a transportadora existe. Caso exista retorna um object com os dados do transportadora, caso
     * não exista, retorna um Exception
     * 
     * @param integer $id
     * @return Object ou Exception
     */
    private function validation_transportadora(int $id = null)
    {
        if (!$id || !$transportadora = $this->transportadoraModel->withDeleted(true)->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Transportadora ID: $id não encontrada!");
        }

        return $transportadora;
    }

    /**
     * Método que valida se o endereço da transportadora existe. Caso exista retorna um object com os dados do endereço, caso
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
        $this->transportadoraModel = new \App\Models\TransportadoraModel();
        $this->enderecoModel = new \App\Models\TransportadoraEnderecoModel();
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
            'title' => 'Transportadoras',
        );

        return view(APP_THEME . $this->viewFolder . '/list', $data);
    }

    /**
     * Metodo chamado via AJAX que retorna um JSON com os dados de todos as transportadoras
     * 
     * @return JSON
     */
    public function fetch()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $columns = array(
            0 => 'transportadoras.id',
            1 => 'transportadoras.razao_social',
            2 => 'transportadoras.nome_fantasia',
            3 => 'transportadoras.cnpj',
            4 => 'transportadoras.email',
            5 => 'transportadoras.active',
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

        $transportadoras = $this->transportadoraModel->getTransportadoras($params_array);
        $rowsTotal = $this->transportadoraModel->countTransportadoras($search);

        $rows = 0;
        $data = array();

        foreach ($transportadoras as $transportadora) {
            if (APP_THEME == 'mentor') {
                $act_view  = '<button title="Visualizar Transportadora" data-id="' . $transportadora->id . '" data-modulo="view" class="btn btn-sm btn-icon btn-outline-dark btn-round btn-view"><i class="ti ti-eye"></i></button>';
                $act_edit  = '<a href="' . site_url('/transportadoras/edit/' . $transportadora->id) . '" title="Editar Transportadora" data-id="' . $transportadora->id . '" data-modulo="edit" class="btn btn-sm btn-icon btn-outline-primary btn-round"><i class="ti ti-pencil"></i></a>';

                $email     = $transportadora->email != '' ? '<a href="mailto:' . $transportadora->email . '" class="btn btn-sm btn-icon btn-round btn-inverse-info" data-toggle="tooltip" data-html="true" data-original-title="' . $transportadora->email . '" title="' . $transportadora->email . '"><i class="fa fa-envelope"></i></a>' : '';
                $status    = ($transportadora->active == true ? '<span class="btn btn-sm btn-icon btn-round btn-inverse-success"><i class="ti ti-unlock" title="Ativo"></i></span>' : '<span class="btn btn-sm btn-icon btn-round btn-inverse-danger"><i class="ti ti-lock" title="Inativo"></i></span>');
            } else {
                $act_view  = '<button data-toggle="tooltip" data-original-title="Visualizar" title="Visualizar" data-id="' . $transportadora->id . '" data-modulo="view" class="btn btn-xs btn-default text-primary btn-width-27 btn-view"><i class="fa fa-eye"></i></button>';
                $act_edit  = '<button data-toggle="tooltip" data-original-title="Editar" title="Editar" data-id="' . $transportadora->id . '" data-modulo="edit" class="btn btn-xs btn-default btn-width-27 btn-edit"><i class="fas fa-edit"></i></button>';

                $email     = $transportadora->email != '' ? '<a href="mailto:' . $transportadora->email . '" class="btn btn-xs btn-info rounded-circle img-fluid" data-toggle="tooltip" data-html="true" data-original-title="' . $transportadora->email . '" title="' . $transportadora->email . '"><i class="fa fa-envelope"></i></a>' : '';
                $status    = ($transportadora->active == true ? '<span class="text-success"><i class="fa fa-unlock" title="Ativo"></i></span>' : '<span class="text-danger"><i class="fa fa-lock" title="Inativo"></i></span>');
            }

            $sub_array = array();

            $sub_array[] = $transportadora->id;
            $sub_array[] = $transportadora->razao_social;
            $sub_array[] = $transportadora->nome_fantasia;
            $sub_array[] = $transportadora->cnpj;
            $sub_array[] = $email;
            $sub_array[] = $status;
            $sub_array[] = $act_view . $act_edit . $transportadora->buttonsControl();

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
     * Método que retorna a view de inclusão da transportadora
     * 
     * @return view
     */
    public function add()
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('listar-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $transportadora = new Transportadora();

        $data = array(
            'menu'      => 'Cadastros',
            'submenu'   => 'Transportadora',
            'title'     => 'Incluir',
            'method'    => 'insert',
            'viewpath'  => APP_THEME . $this->viewFolder,
            'form'      => 'form',
            'response'  => 'response',
            'table'     => $transportadora,
            'cidades'   => $this->cidadeModel->getAllCidades(),
            'enderecos' => $this->enderecoModel->getEnderecosTransportadora(0),
        );

        if (APP_THEME == 'mentor') {
            return view(APP_THEME . $this->viewFolder . '/form', $data);
        } else {
            // return view(APP_THEME . $this->viewFolder . '/_add', $data);
            return view(APP_THEME . '/layout/modals/_modal', $data);
        }
    }

    /**
     * Método que retorna a view de inclusão de transportadora
     * 
     * @return view
     */
    public function add_modal()
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('listar-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $transportadora = new Transportadora();

        $data = array(
            'title'     => 'Nova Transportadora',
            'method'    => 'insert',
            'viewpath'  => APP_THEME . $this->viewFolder,
            'form'      => 'formAddTransportadora',
            'response'  => 'responseTransportadora',
            'table'     => $transportadora,
            'cidades'   => $this->cidadeModel->getAllCidades(),
            'enderecos' => $this->enderecoModel->getEnderecosTransportadora(0),
        );

        // return view(APP_THEME . $this->viewFolder . '/_add', $data);
        return view(APP_THEME . '/layout/modals/_modal', $data);
    }

    /**
     * Método que faz o insert dos dados da transportadora
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

        // Define o tipo de transportadora (Física ou Jurídica)
        $post['tipo'] = strlen($post['cnpj']) == 18 ? 'J' : 'F';

        $transportadora = new Transportadora($post);

        try {
            $this->db->transStart(); // Inicia a transação

            // Insere a transportadora
            if (!$this->transportadoraModel->protect(false)->insert($transportadora, true)) {
                //print_r($this->db->getLastQuery());
                throw new \Exception('Erro ao inserir a Transportadora.');
            }

            $transportadora_id = $this->transportadoraModel->getInsertID();

            // Insere os endereços
            foreach ($enderecos_data as $endereco_data) {
                $endereco_data['transportadora_id'] = $transportadora_id;
                $endereco_data['active'] = true;

                $endereco = new TransportadoraEndereco($endereco_data);

                if (!$this->enderecoModel->protect(false)->insert($endereco, false)) {
                    throw new \Exception('Erro ao inserir um dos endereços.');
                }
            }

            $this->db->transComplete(); // Finaliza a transação

            if ($this->db->transStatus() === false) {
                throw new \Exception('Erro ao completar a transação.');
            }

            if (!$this->transportadoraModel->errors()) {
                $return['success'] = 'Dados salvos com sucesso!';
            } else {
                $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
                $return['errors_model'] = $this->transportadoraModel->errors();
            }

            $return['id'] = $transportadora_id;
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
     * Método que retorna a view de edição dos dados da transportadora
     * 
     * @param $id
     * @return view
     */
    public function edit(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('editar-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $transportadora = $this->validation_transportadora($id);

        $data = array(
            'menu'      => 'Cadastros',
            'submenu'   => 'Transportadora',
            'title'     => 'Editar',
            'method'    => 'update',
            'viewpath'  => APP_THEME . $this->viewFolder,
            'form'      => 'form',
            'response'  => 'response',
            'cidades'   => $this->cidadeModel->getAllCidades(),
            'table'     => $transportadora,
            'enderecos' => $this->enderecoModel->getEnderecosTransportadora($id),
        );

        if (APP_THEME == 'mentor') {
            return view(APP_THEME . $this->viewFolder . '/form', $data);
        } else {
            // return view(APP_THEME . $this->viewFolder . '/_edit', $data);
            return view(APP_THEME . '/layout/modals/_modal', $data);
        }
    }

    /**
     * Método que faz o update dos dados da transportadora
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

        // Define o tipo de transportadora (PF ou PJ)
        $post['tipo'] = strlen($post['cnpj']) == 18 ? 'J' : 'F';

        try {
            $this->db->transStart(); // Inicia a transação

            $transportadora = $this->validation_transportadora($post['id']);
            $transportadora->fill($post);

            if ($transportadora->hasChanged()) {
                $this->transportadoraModel->protect(false)->save($transportadora);
            }

            // IDs de endereços recebidos do formulário
            $enderecos_ids = array_filter(array_column($enderecos_data, 'id'));

            // Exclui (soft delete) endereços que não estão no formulário
            if (!empty($enderecos_ids)) {
                $this->enderecoModel->where('transportadora_id', $transportadora->id)
                    ->whereNotIn('id', $enderecos_ids)
                    ->set(['active' => false])
                    ->delete(null, false);
            } else {
                // Se nenhum endereço foi enviado, inativa todos os endereços da transportadora
                $this->enderecoModel->where('transportadora_id', $transportadora->id)
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
                    $endereco_data['transportadora_id'] = $transportadora->id;
                    $endereco_data['active'] = true;

                    $this->enderecoModel->insert($endereco_data, false);
                }
            }

            $this->db->transComplete(); // Finaliza a transação

            if ($this->db->transStatus() === false) {
                throw new \Exception('Erro ao salvar os dados.');
            }

            if (!$this->transportadoraModel->errors()) {
                $return['success'] = 'Dados salvos com sucesso!';
            } else {
                $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
                $return['errors_model'] = $this->transportadoraModel->errors();
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
     * Método que retorna a view de deleção da transportadora
     * 
     * @param $id
     * @return view
     */
    public function delete(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('excluir-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $transportadora = $this->validation_transportadora($id);

        $data = array(
            'title'          => 'Excluir',
            'method'         => 'delete',
            'transportadora' => $transportadora,
        );

        return view(APP_THEME . $this->viewFolder . '/_delete', $data);
    }

    /**
     * Método que faz a deleção da transportadora
     * 
     * @param $id
     * @return redirect
     */
    public function remove(int $id = null)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $transportadora = $this->validation_transportadora($id);

        $this->transportadoraModel->delete($transportadora->id);

        $transportadora->active = false;

        $this->transportadoraModel->protect(false)->save($transportadora);

        if (!$this->transportadoraModel->errors()) {
            $return['success'] = 'Removido com sucesso!';
        } else {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $this->transportadoraModel->errors();
        }

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view de restore da transportadora.
     * 
     * @param $id
     * @return view
     */
    public function undo(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('excluir-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $transportadora = $this->validation_transportadora($id);

        $data = [
            'title'          => 'Restaurar',
            'method'         => 'restore',
            'transportadora' => $transportadora,
        ];

        return view(APP_THEME . $this->viewFolder . '/_restore', $data);
    }

    /**
     * Método que faz o restore da transportadora
     * 
     * @param $id
     * @return redirect
     */
    public function restore(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('editar-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $transportadora = $this->validation_transportadora($id);

        $transportadora->deleted_at = null;
        $transportadora->active = true;

        $this->transportadoraModel->protect(false)->save($transportadora);

        if (!$this->transportadoraModel->errors()) {
            $return['success'] = 'Restaurado com sucesso!';
        } else {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $this->transportadoraModel->errors();
        }

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view de visualização dos dados da transportadora
     * 
     * @param $id
     * @return view
     */
    public function show(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('listar-' . $this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>' . $this->getLoggedUserData()->name . '</b> não possui permissão para acessar este módulo.');
        }

        $transportadora = $this->validation_transportadora($id);

        $data = array(
            'menu'           => 'Cadastros',
            'title'          => 'Visualizar',
            'transportadora' => $transportadora,
            'enderecos'      => $this->enderecoModel->getEnderecosTransportadora($id),
        );

        return view(APP_THEME . $this->viewFolder . '/_show', $data);
    }
}
