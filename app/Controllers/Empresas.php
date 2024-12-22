<?php

namespace App\Controllers;

use App\Entities\Empresa;
use App\Entities\EmpresaEndereco;

class Empresas extends BaseController
{
    protected $db;
    protected $empresaModel;
    protected $enderecoModel;
    protected $cidadeModel;

    private $viewFolder = '/cadastros/empresas';
    private $route = 'empresas';

    /**
     * Método que valida se a empresa existe. Caso exista retorna um object com os dados da empresa, caso
     * não exista, retorna um Exception.
     *
     * @param int $id
     *
     * @return object ou Exception
     */
    private function validation_empresa(int $id = null)
    {
        if (!$id || !$empresa = $this->empresaModel->withDeleted(true)->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Empresa ID: $id não encontrada!");
        }

        return $empresa;
    }

    /**
     * Método que valida se o endereço da empresa existe. Caso exista retorna um object com os dados do endereço, caso
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

    private function remove_image(string $image)
    {
        $filepath = WRITEPATH."uploads/empresas/$image";

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
        $this->db = \Config\Database::connect();
        $this->empresaModel = new \App\Models\EmpresaModel();
        $this->enderecoModel = new \App\Models\EmpresaEnderecoModel();
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
            'title' => 'Empresas',
        ];

        return view(APP_THEME.$this->viewFolder.'/list', $data);
    }

    /**
     * Metodo chamado via AJAX que retorna um JSON com os dados de todos as empresas.
     *
     * @return JSON
     */
    public function fetch()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $columns = [
            0 => 'empresas.id',
            1 => 'empresas.razao_social',
            2 => 'empresas.nome_fantasia',
            3 => 'empresas.cnpj',
            4 => 'empresas.email',
            5 => 'empresas.active',
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

        $empresas = $this->empresaModel->getEmpresas($params_array);
        $rowsTotal = $this->empresaModel->countEmpresas($search);

        $rows = 0;
        $data = [];

        foreach ($empresas as $empresa) {
            if (APP_THEME == 'mentor') {
                $act_view = '<button title="Visualizar Empresa" data-id="'.$empresa->id.'" data-modulo="view" class="btn btn-sm btn-icon btn-outline-dark btn-round btn-view"><i class="ti ti-eye"></i></button>';
                $act_edit = '<a href="'.site_url('/empresas/edit/'.$empresa->id).'" title="Editar Empresa" data-id="'.$empresa->id.'" data-modulo="edit" class="btn btn-sm btn-icon btn-outline-primary btn-round"><i class="ti ti-pencil"></i></a>';

                $email = $empresa->email != '' ? '<a href="mailto:'.$empresa->email.'" class="btn btn-sm btn-icon btn-round btn-inverse-info" data-toggle="tooltip" data-html="true" data-original-title="'.$empresa->email.'" title="'.$empresa->email.'"><i class="fa fa-envelope"></i></a>' : '';
                $status = ($empresa->active == true ? '<span class="btn btn-sm btn-icon btn-round btn-inverse-success"><i class="ti ti-unlock" title="Ativo"></i></span>' : '<span class="btn btn-sm btn-icon btn-round btn-inverse-danger"><i class="ti ti-lock" title="Inativo"></i></span>');
            } else {
                $act_view = '<button data-toggle="tooltip" data-original-title="Visualizar" title="Visualizar" data-id="'.$empresa->id.'" data-modulo="view" class="btn btn-xs btn-default text-primary btn-width-27 btn-view"><i class="fa fa-eye"></i></button>';
                $act_edit = '<button data-toggle="tooltip" data-original-title="Editar" title="Editar" data-id="'.$empresa->id.'" data-modulo="edit" class="btn btn-xs btn-default btn-width-27 btn-edit"><i class="fas fa-edit"></i></button>';

                $email = $empresa->email != '' ? '<a href="mailto:'.$empresa->email.'" class="btn btn-xs btn-info rounded-circle img-fluid" data-toggle="tooltip" data-html="true" data-original-title="'.$empresa->email.'" title="'.$empresa->email.'"><i class="fa fa-envelope"></i></a>' : '';
                $status = ($empresa->active == true ? '<span class="text-success"><i class="fa fa-unlock" title="Ativo"></i></span>' : '<span class="text-danger"><i class="fa fa-lock" title="Inativo"></i></span>');
            }

            $sub_array = [];

            $sub_array[] = $empresa->id;
            $sub_array[] = $empresa->razao_social;
            $sub_array[] = $empresa->nome_fantasia;
            $sub_array[] = $empresa->cnpj;
            $sub_array[] = $email;
            $sub_array[] = $status;
            $sub_array[] = $act_view.$act_edit.$empresa->buttonsControl();

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
     * Método que retorna a view de inclusão de empresa.
     *
     * @return view
     */
    public function add()
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('listar-'.$this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>'.$this->getLoggedUserData()->name.'</b> não possui permissão para acessar este módulo.');
        }

        $empresa = new Empresa();

        $data = [
            'menu' => 'Cadastros',
            'submenu' => 'Empresas',
            'title' => 'Incluir',
            'viewpath' => APP_THEME.$this->viewFolder,
            'method' => 'insert',
            'form' => 'form',
            'response' => 'response',
            'table' => $empresa,
            'cidades' => $this->cidadeModel->getAllCidades(),
            'enderecos' => $this->enderecoModel->getEnderecosEmpresa(0),
        ];

        if (APP_THEME == 'mentor') {
            return view(APP_THEME.$this->viewFolder.'/form', $data);
        } else {
            return view(APP_THEME.'/layout/modals/_modal', $data);
        }
    }

    /**
     * Método que faz o insert dos dados da empresa.
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

        // Define o tipo de empresa (Física ou Jurídica)
        $post['tipo'] = strlen($post['cnpj']) == 18 ? 'J' : 'F';

        // print_r($post);
        // exit();

        $empresa = new Empresa($post);

        try {
            $this->db->transStart(); // Inicia a transação

            // Insere a empresa
            if (!$this->empresaModel->protect(false)->insert($empresa, true)) {
                throw new \Exception('Erro ao inserir a empresa.');
            }

            $empresa_id = $this->empresaModel->getInsertID();

            // Insere os endereços
            foreach ($enderecos_data as $endereco_data) {
                $endereco_data['empresa_id'] = $empresa_id;
                $endereco_data['active'] = true;

                $endereco = new EmpresaEndereco($endereco_data);

                if (!$this->enderecoModel->protect(false)->insert($endereco, false)) {
                    throw new \Exception('Erro ao inserir um dos endereços.');
                }
            }

            $this->db->transComplete(); // Finaliza a transação

            if ($this->db->transStatus() === false) {
                throw new \Exception('Erro ao completar a transação.');
            }

            if (!$this->empresaModel->errors()) {
                $return['success'] = 'Dados salvos com sucesso!';
            } else {
                $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
                $return['errors_model'] = $this->empresaModel->errors();
            }

            $return['id'] = $empresa_id;

            return $this->response->setJSON($return);
        } catch (\Exception $e) {
            $this->db->transRollback(); // Reverte as mudanças em caso de erro

            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $e->getMessage();

            return $this->response->setJSON($return);
        }
    }

    /**
     * Método que retorna a view de edição dos dados da empresa.
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

        $empresa = $this->validation_empresa($id);

        $data = [
            'menu' => 'Cadastros',
            'submenu' => 'Empresas',
            'title' => 'Editar',
            'method' => 'update',
            'viewpath' => APP_THEME.$this->viewFolder,
            'form' => 'form',
            'response' => 'response',
            'cidades' => $this->cidadeModel->getAllCidades(),
            'table' => $empresa,
            'enderecos' => $this->enderecoModel->getEnderecosEmpresa($id),
        ];

        if (APP_THEME == 'mentor') {
            return view(APP_THEME.$this->viewFolder.'/form', $data);
        } else {
            // return view(APP_THEME . $this->viewFolder . '/_edit', $data);
            return view(APP_THEME.'/layout/modals/_modal', $data);
        }
    }

    /**
     * Método que faz o update dos dados da empresa.
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

        // Define o tipo de empresa (PF ou PJ)
        $post['tipo'] = strlen($post['cnpj']) == 18 ? 'J' : 'F';

        try {
            $this->db->transStart(); // Inicia a transação

            $empresa = $this->validation_empresa($post['id']);
            $empresa->fill($post);

            if ($empresa->hasChanged()) {
                $this->empresaModel->protect(false)->save($empresa);
            }

            // IDs de endereços recebidos do formulário
            $enderecos_ids = array_filter(array_column($enderecos_data, 'id'));

            // Exclui (soft delete) endereços que não estão no formulário
            if (!empty($enderecos_ids)) {
                $this->enderecoModel->where('empresa_id', $empresa->id)
                    ->whereNotIn('id', $enderecos_ids)
                    ->set(['active' => false])
                    ->delete(null, false);
            } else {
                // Se nenhum endereço foi enviado, inativa todos os endereços da empresa
                $this->enderecoModel->where('empresa_id', $empresa->id)
                    ->set(['active' => false])
                    ->delete(null, false);
            }

            // Atualiza ou insere os endereços
            foreach ($enderecos_data as $endereco_data) {
                if (!empty($endereco_data['id'])) {
                    // Atualiza o endereço existente
                    $endereco = $this->validation_endereco($endereco_data['id']);
                    $endereco_data['active'] = true;
                    $endereco->fill($endereco_data);

                    if ($endereco->hasChanged()) {
                        $this->enderecoModel->protect(false)->save($endereco);
                    }
                } else {
                    // Insere novo endereço
                    $endereco_data['empresa_id'] = $empresa->id;
                    $endereco_data['active'] = true;

                    $this->enderecoModel->insert($endereco_data, false);
                }
            }

            $this->db->transComplete(); // Finaliza a transação

            if ($this->db->transStatus() === false) {
                throw new \Exception('Erro ao salvar os dados.');
            }

            if (!$this->empresaModel->errors()) {
                $return['success'] = 'Dados salvos com sucesso!';
                $return['redirect'] = redirect()->to(site_url('/empresas'))->with('message-success', 'Dados salvos com sucesso!');
            } else {
                $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
                $return['errors_model'] = $this->empresaModel->errors();
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
     * Método que retorna a view de deleção da empresa.
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

        $empresa = $this->validation_empresa($id);

        $data = [
            'title' => 'Excluir',
            'method' => 'delete',
            'empresa' => $empresa,
        ];

        return view(APP_THEME.$this->viewFolder.'/_delete', $data);
    }

    /**
     * Método que faz a deleção da empresa.
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

        $empresa = $this->validation_empresa($id);

        $this->empresaModel->delete($empresa->id);

        if ($empresa->photo != null) {
            $this->remove_image($empresa->photo);
        }

        $empresa->photo = null;
        $empresa->active = false;

        $this->empresaModel->protect(false)->save($empresa);

        if (!$this->empresaModel->errors()) {
            $return['success'] = 'Removido com sucesso!';
        } else {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $this->empresaModel->errors();
        }

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view de restore da empresa.
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

        $empresa = $this->validation_empresa($id);

        $data = [
            'title' => 'Restaurar',
            'method' => 'restore',
            'empresa' => $empresa,
        ];

        return view(APP_THEME.$this->viewFolder.'/_restore', $data);
    }

    /**
     * Método que faz o restore da empresa.
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

        $empresa = $this->validation_empresa($id);

        $empresa->deleted_at = null;
        $empresa->active = true;

        $this->empresaModel->protect(false)->save($empresa);

        if (!$this->empresaModel->errors()) {
            $return['success'] = 'Restaurado com sucesso!';
        } else {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $this->empresaModel->errors();
        }

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view de visualização dos dados da empresa.
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

        $empresa = $this->validation_empresa($id);

        $data = [
            'menu' => 'Cadastros',
            'title' => 'Visualizar',
            'empresa' => $empresa,
            'enderecos' => $this->enderecoModel->getEnderecosEmpresa($id),
        ];

        return view(APP_THEME.$this->viewFolder.'/_show', $data);
    }

    // PAREI AQUI...

    /**
     * Método que retorna a view (modal) de edição da foto da empresa.
     */
    public function edit_photo(int $id = null)
    {
        if (!$this->getLoggedUserData()->validatePermissionLoggedUser('editar-empresas')) {
            session()->setFlashdata('message-warning', 'O usuário <b>'.$this->getLoggedUserData()->name.'</b> não possui permissão para acessar este módulo.');

            return view('Layout/_noaccess');
        }

        $empresa = $this->validation_empresa($id);

        $data = [
            'title' => 'Alterar foto da Empresa',
            'empresa' => $empresa,
        ];

        return view(APP_THEME.$this->viewFolder.'/_photo', $data);
    }

    /**
     * Método que faz o upload da foto da empresa.
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
                'ext_in' => 'Formato não permitido.',
            ],
        ];

        $validation->setRules($rules, $messages);

        if ($validation->withRequest($this->request)->run() == false) {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $validation->getErrors();

            return $this->response->setJSON($return);
        }

        $post = $this->request->getPost();
        $user = $this->validation_empresa($post['id']);
        $file = $this->request->getFile('photo');

        list($width, $heigth) = getimagesize($file->getPathName());

        if ($width < '100' || $heigth < '100') {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = ['dimension' => 'A imagem não pode ser menor que 100 x 100px'];

            return $this->response->setJSON($return);
        }

        $filepath = $file->store('empresas');
        $filepath = WRITEPATH."uploads/$filepath";
        $year = date('Y');

        $this->manipulate_image($filepath);

        $photo_ant = $user->photo;
        $user->photo = $file->getName();

        if ($this->empresaModel->save($user)) {
            session()->setFlashdata('message-success', 'Imagem atualizada com sucesso!');

            $return['success'] = 'Imagem atualizada com sucesso!';

            if ($photo_ant != null) {
                $this->remove_image($photo_ant);
            }

            return $this->response->setJSON($return);
        }
    }

    /**
     * Método que exibe a foto do usuário.
     */
    public function show_photo(string $image = null)
    {
        if ($image != null) {
            $this->showImage('empresas', $image);
        }
    }

    /**
     * Metodo chamado via AJAX que retorna um JSON com os dados de todos os endereços da empresa.
     *
     * @return JSON
     */
    public function fetch_enderecos(int $id)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $enderecos = $this->empresaModel->findEnderecos($id);

        $data = [];

        foreach ($enderecos as $endereco) {
            $data[] = [
                'cep' => esc($endereco->cep),
                'logradouro' => esc($endereco->logradouro),
                'numero' => esc($endereco->numero),
                'complemento' => esc($endereco->complemento),
                'bairro' => esc($endereco->bairro),
                'cidade_uf' => esc($endereco->cidade_uf),
                'tipo' => $endereco->tipo,
                'actions' => anchor("empresas/endereco_delete/$endereco->id", '<i class="fas fa-trash-alt text-danger" title="Excluir"></i>', 'title="Excluir" class="btn btn-xs btn-default text-danger btn-width-27 btn-del"'),
            ];
        }

        $return = [
            'data' => $data,
        ];

        return $this->response->setJSON($return);
    }
}
