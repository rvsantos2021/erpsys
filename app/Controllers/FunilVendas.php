<?php

namespace App\Controllers;

use App\Entities\FunilVenda;

class FunilVendas extends BaseController
{
    protected $db;
    protected $funilModel;
    protected $etapaModel;

    private $viewFolder = '/cadastros/crm/funil_vendas';
    private $route = 'funil';

    /**
     * Método que valida se o registro existe. Caso exista retorna um object com os dados do registro, caso
     * não exista, retorna um Exception.
     *
     * @param int $id
     *
     * @return object ou Exception
     */
    private function validation_funil(int $id = null)
    {
        if (!$id || !$funil = $this->funilModel->withDeleted(true)->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Funil de Venda ID: $id não encontrado!");
        }

        return $funil;
    }

    /**
     * Método que valida se o registro existe. Caso exista retorna um object com os dados do registro, caso
     * não exista, retorna um Exception.
     *
     * @param int $id
     *
     * @return object ou Exception
     */
    private function validation_etapa(int $id = null)
    {
        if (!$id || !$etapa = $this->etapaModel->withDeleted(true)->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Etapa do Funil de Venda ID: $id não encontrada!");
        }

        return $etapa;
    }

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->funilModel = new \App\Models\FunilVendaModel();
        $this->etapaModel = new \App\Models\FunilVendaEtapaModel();
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
            'menu' => 'CRM',
            'submenu' => 'Cadastros',
            'title' => 'Funil de Vendas',
        ];

        return view(APP_THEME.$this->viewFolder.'/list', $data);
    }

    /**
     * Metodo chamado via AJAX que retorna um JSON com os dados de todos os registros.
     *
     * @return JSON
     */
    public function fetch()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $columns = [
            0 => 'funil_vendas.id',
            1 => 'funil_vendas.descricao',
            2 => 'funil_vendas.active',
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

        $funis = $this->funilModel->getFunisVendas($params_array);
        $rowsTotal = $this->funilModel->countFunisVendas($search);

        $rows = 0;
        $data = [];

        foreach ($funis as $funil) {
            if (APP_THEME == 'mentor') {
                $act_view = '<button title="Visualizar Funil de Venda" data-id="'.$funil->id.'" data-modulo="view" class="btn btn-sm btn-icon btn-outline-dark btn-round btn-view"><i class="ti ti-eye"></i></button>';
                $act_edit = '<button title="Editar Funil de Venda" data-id="'.$funil->id.'" data-modulo="edit" class="btn btn-sm btn-icon btn-outline-primary btn-round btn-edit"><i class="ti ti-pencil"></i></button>';
                $act_etap = '<button title="Etapas do Funil" data-id="'.$funil->id.'" class="btn btn-sm btn-icon btn-outline-warning btn-round btn-etapa"><i class="ti ti-menu-alt"></i></button>';

                $status = ($funil->active == true ? '<span class="btn btn-sm btn-icon btn-round btn-inverse-success"><i class="ti ti-unlock" title="Ativo"></i></span>' : '<span class="btn btn-sm btn-icon btn-round btn-inverse-danger"><i class="ti ti-lock" title="Inativo"></i></span>');
            } else {
                $act_view = '<button data-toggle="tooltip" data-original-title="Visualizar Funil de Venda" title="Visualizar Funil de Venda" data-id="'.$funil->id.'" data-modulo="view" class="btn btn-xs btn-default text-primary btn-width-27 btn-view"><i class="fa fa-eye"></i></button>';
                $act_edit = '<button data-toggle="tooltip" data-original-title="Editar Funil de Venda" title="Editar Funil de Venda" data-id="'.$funil->id.'" data-modulo="edit" class="btn btn-xs btn-default btn-width-27 btn-edit"><i class="fas fa-edit"></i></button>';
                $act_etap = '<button data-toggle="tooltip" data-original-title="Etapas do Funil" title="Etapas do Funil" data-id="'.$funil->id.'" class="btn btn-xs btn-default text-warning btn-width-27 btn-etapa"><i class="fas fa-th-list"></i></button>';

                $status = ($funil->active == true ? '<span class="btn btn-xs btn-default rounded-circle-custom text-success" data-toggle="tooltip" data-original-title="Ativo"><i class="fa fa-unlock" title="Ativo"></i></span>' : '<span class="btn btn-xs btn-default rounded-circle-custom text-danger" data-toggle="tooltip" data-original-title="Inativo"><i class="fa fa-lock" title="Inativo"></i></span>');
            }

            $sub_array = [];

            $sub_array[] = $funil->id;
            $sub_array[] = $funil->descricao;
            $sub_array[] = $status;
            $sub_array[] = $act_etap.$act_view.$act_edit.$funil->buttonsControl();

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
     * Método que retorna a view de inclusão de funil.
     *
     * @return view
     */
    public function add()
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('criar-'.$this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>'.$this->getLoggedUserData()->name.'</b> não possui permissão para acessar este módulo.');
        }

        $funil = new FunilVenda();

        $data = [
            'title' => 'Novo Funil de Venda',
            'method' => 'insert',
            'viewpath' => APP_THEME.$this->viewFolder,
            'form' => 'form',
            'response' => 'response',
            'table' => $funil,
        ];

        return view(APP_THEME.'/layout/modals/_modal', $data);
    }

    /**
     * Método que retorna a view de inclusão de funil.
     *
     * @return view
     */
    public function add_modal()
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('criar-'.$this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>'.$this->getLoggedUserData()->name.'</b> não possui permissão para acessar este módulo.');
        }

        $funil = new FunilVenda();

        $data = [
            'title' => 'Novo Funil de Venda',
            'method' => 'insert',
            'viewpath' => APP_THEME.$this->viewFolder,
            'form' => 'formAddFunil',
            'response' => 'responseFunil',
            'table' => $funil,
        ];

        return view(APP_THEME.'/layout/modals/_modal', $data);
    }

    /**
     * Método que faz o insert dos dados do funil.
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

        $funil = new FunilVenda($post);

        try {
            $this->db->transStart(); // Inicia a transação

            // Insere o funil
            if (!$this->funilModel->protect(false)->insert($funil, true)) {
                throw new \Exception('Erro ao inserir o funil.');
            }

            $segmento_id = $this->funilModel->getInsertID();

            $this->db->transComplete(); // Finaliza a transação

            if ($this->db->transStatus() === false) {
                throw new \Exception('Erro ao completar a transação.');
            }

            if (!$this->funilModel->errors()) {
                $return['success'] = 'Dados salvos com sucesso!';
            } else {
                $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
                $return['errors_model'] = $this->funilModel->errors();
            }

            $return['id'] = $segmento_id;
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
     * Método que retorna a view de edição dos dados do funil.
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

        $funil = $this->validation_funil($id);

        $data = [
            'title' => 'Editar Funil de Venda',
            'method' => 'update',
            'viewpath' => APP_THEME.$this->viewFolder,
            'form' => 'form',
            'response' => 'response',
            'table' => $funil,
        ];

        return view(APP_THEME.'/layout/modals/_modal', $data);
    }

    /**
     * Método que faz o update dos dados do funil.
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

            $funil = $this->validation_funil($post['id']);
            $funil->fill($post);

            if ($funil->hasChanged()) {
                $this->funilModel->protect(false)->save($funil);
            }

            $this->db->transComplete(); // Finaliza a transação

            if ($this->db->transStatus() === false) {
                throw new \Exception('Erro ao salvar os dados.');
            }

            if (!$this->funilModel->errors()) {
                $return['success'] = 'Dados salvos com sucesso!';
            } else {
                $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
                $return['errors_model'] = $this->funilModel->errors();
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
     * Método que retorna a view de deleção do funil.
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

        $funil = $this->validation_funil($id);

        $data = [
            'title' => 'Excluir',
            'method' => 'delete',
            'table' => $funil,
        ];

        return view(APP_THEME.$this->viewFolder.'/_delete', $data);
    }

    /**
     * Método que faz a deleção do funil.
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

        $funil = $this->validation_funil($id);

        $this->funilModel->delete($funil->id);

        $funil->active = false;

        $this->funilModel->protect(false)->save($funil);

        if (!$this->funilModel->errors()) {
            $return['success'] = 'Removido com sucesso!';
        } else {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $this->funilModel->errors();
        }

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view de restore do funil.
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

        $funil = $this->validation_funil($id);

        $data = [
            'title' => 'Restaurar',
            'method' => 'restore',
            'table' => $funil,
        ];

        return view(APP_THEME.$this->viewFolder.'/_restore', $data);
    }

    /**
     * Método que faz o restore do funil.
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

        $funil = $this->validation_funil($id);

        $funil->deleted_at = null;
        $funil->active = true;

        $this->funilModel->protect(false)->save($funil);

        if (!$this->funilModel->errors()) {
            $return['success'] = 'Restaurado com sucesso!';
        } else {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $this->funilModel->errors();
        }

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view de visualização dos dados do funil.
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

        $funil = $this->validation_funil($id);

        $data = [
            'title' => 'Visualizar',
            'table' => $funil,
        ];

        return view(APP_THEME.$this->viewFolder.'/_show', $data);
    }

    /**
     * Método que retorna a view de visualização das etapas do funil.
     *
     * @param $id
     *
     * @return view
     */
    public function etapas(int $id = null)
    {
        $funil = $this->validation_funil($id);

        $data = [
            'title' => 'Etapas',
            'table' => $funil,
            'etapas' => $this->etapaModel->getEtapasFunilVendas($id),
        ];

        return view(APP_THEME.$this->viewFolder.'/_etapas', $data);
    }

    /**
     * Método que retorna a view de visualização das etapas do funil.
     *
     * @param $id
     *
     * @return view
     */
    public function etapas_save()
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

        $funil = $this->validation_funil($post['id']);

        $etapas_data = [];

        if (isset($post['etapa_nome'])) {
            $ordem = 1;

            foreach ($post['etapa_nome'] as $index => $etapa) {
                $etapas_data[] = [
                    'id' => $post['etapa_id'][$index] ?? null,
                    'descricao' => $etapa,
                    'ordem' => $ordem,
                    'funil_id' => $funil->id,
                    'active' => true,
                ];

                $ordem = $ordem + 1;
            }
        }

        try {
            $this->db->transStart(); // Inicia a transação

            // IDs de etapas recebidos do formulário
            $etapas_ids = array_filter(array_column($etapas_data, 'id'));

            // Exclui (soft delete) etapas que não estão no formulário
            if (!empty($etapas_ids)) {
                $this->etapaModel->where('funil_id', $funil->id)
                    ->whereNotIn('id', $etapas_ids)
                    ->set(['active' => false])
                    ->delete(null, false);
            } else {
                // Se nenhuma etapa foi enviada, inativa todas asetapas do funil
                $this->etapaModel->where('funil_id', $funil->id)
                    ->set(['active' => false])
                    ->delete(null, false);
            }

            // Atualiza ou insere os endereços
            foreach ($etapas_data as $etapa_data) {
                if (!empty($etapa_data['id'])) {
                    // Atualiza a etapa existente
                    $etapa = $this->validation_etapa($etapa_data['id']);
                    $etapa->fill($etapa_data);

                    if ($etapa->hasChanged()) {
                        $this->etapaModel->protect(false)->save($etapa);
                    }
                } else {
                    // Insere novo endereço
                    $this->etapaModel->insert($etapa_data, false);
                }
            }

            $this->db->transComplete(); // Finaliza a transação

            if ($this->db->transStatus() === false) {
                throw new \Exception('Erro ao salvar os dados.');
            }

            if (!$this->etapaModel->errors()) {
                $return['success'] = 'Dados salvos com sucesso!';
            } else {
                $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
                $return['errors_model'] = $this->etapaModel->errors();
            }

            return $this->response->setJSON($return);
        } catch (\Exception $e) {
            $this->db->transRollback(); // Reverte as mudanças em caso de erro

            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $e->getMessage();

            return $this->response->setJSON($return);
        }
    }
}
