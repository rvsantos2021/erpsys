<?php

namespace App\Controllers;

use App\Entities\Produto;
use App\Entities\ProdutoFornecedor;
use App\Entities\ProdutoImagem;
use App\Entities\ProdutoPreco;

class Produtos extends BaseController
{
    protected $db;
    protected $produtoModel;
    protected $tipoProdutoModel;
    protected $unidadeModel;
    protected $marcaModel;
    protected $modeloModel;
    protected $grupoModel;
    protected $secaoModel;
    protected $tabelaModel;
    protected $depositoModel;
    protected $fornecedorModel;
    protected $estoqueModel;
    protected $precoModel;
    protected $prodFornecModel;
    protected $cidadeModel;
    protected $enderecoModel;
    protected $imagemModel;

    private $viewFolder = '/cadastros/estoque/produtos';
    private $route = 'produtos';

    /**
     * Método que valida se o produto existe. Caso exista retorna um object com os dados do produto, caso
     * não exista, retorna um Exception.
     *
     * @param int $id
     *
     * @return object ou Exception
     */
    private function validation_produto(int $id = null)
    {
        if (!$id || !$produto = $this->produtoModel->withDeleted(true)->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Produto ID: $id não encontrado!");
        }

        return $produto;
    }

    /**
     * Método que valida se o preço do produto existe. Caso exista retorna um object com os dados do preço, caso
     * não exista, retorna um Exception.
     *
     * @param int $id
     *
     * @return object ou Exception
     */
    private function validation_preco(int $id = null)
    {
        if (!$id || !$preco = $this->precoModel->withDeleted(true)->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Preço ID: $id não encontrado!");
        }

        return $preco;
    }

    /**
     * Método que valida se o fornecedor do produto existe. Caso exista retorna um object com os dados do fornecedor, caso
     * não exista, retorna um Exception.
     *
     * @param int $id
     *
     * @return object ou Exception
     */
    private function validation_fornecedor_produto(int $id = null)
    {
        if (!$id || !$fornecedor = $this->prodFornecModel->withDeleted(true)->find($id)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Fornecedor ID: $id não encontrado!");
        }

        return $fornecedor;
    }

    private function remove_image(string $image)
    {
        $filepath = WRITEPATH."uploads/produtos/$image";

        if (is_file($filepath)) {
            unlink($filepath);
        }
    }

    private function manipulate_image(string $filepath)
    {
        $year = date('Y');

        service('image')->withFile($filepath)
            ->fit(1200, 1200, 'center')
            ->save($filepath);

        \Config\Services::image('imagick')->withFile($filepath)
            ->text(APP_NAME, [
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
        $this->produtoModel = new \App\Models\ProdutoModel();
        $this->tipoProdutoModel = new \App\Models\TipoProdutoModel();
        $this->unidadeModel = new \App\Models\UnidadeProdutoModel();
        $this->marcaModel = new \App\Models\MarcaProdutoModel();
        $this->modeloModel = new \App\Models\ModeloProdutoModel();
        $this->grupoModel = new \App\Models\GrupoProdutoModel();
        $this->secaoModel = new \App\Models\SecaoProdutoModel();
        $this->tabelaModel = new \App\Models\TabelaPrecoModel();
        $this->depositoModel = new \App\Models\DepositoProdutoModel();
        $this->fornecedorModel = new \App\Models\FornecedorModel();
        $this->estoqueModel = new \App\Models\EstoqueDepositoModel();
        $this->precoModel = new \App\Models\ProdutoPrecoModel();
        $this->prodFornecModel = new \App\Models\ProdutoFornecedorModel();
        $this->cidadeModel = new \App\Models\CidadeModel();
        $this->enderecoModel = new \App\Models\FornecedorEnderecoModel();
        $this->imagemModel = new \App\Models\ProdutoImagemModel();
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
            'title' => 'Produtos',
        ];

        return view(APP_THEME.$this->viewFolder.'/list', $data);
    }

    /**
     * Metodo chamado via AJAX que retorna um JSON com os dados de todos os produtos.
     *
     * @return JSON
     */
    public function fetch()
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $columns = [
            0 => 'produtos.id',
            1 => 'produtos.codigo_ncm',
            2 => 'produtos.referencia',
            3 => 'produtos.descricao',
            4 => 'produtos.photo',
            5 => 'produtos.active',
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

        $produtos = $this->produtoModel->getProdutos($params_array);
        $rowsTotal = $this->produtoModel->countProdutos($search);

        $rows = 0;
        $data = [];

        foreach ($produtos as $produto) {
            if (APP_THEME == 'mentor') {
                $act_view = '<button title="Visualizar Produto" data-id="'.$produto->id.'" data-modulo="view" class="btn btn-sm btn-icon btn-outline-dark btn-round btn-view"><i class="ti ti-eye"></i></button>';
                $act_edit = '<a href="'.site_url('/produtos/edit/'.$produto->id).'" title="Editar Produto" data-id="'.$produto->id.'" data-modulo="edit" class="btn btn-sm btn-icon btn-outline-primary btn-round"><i class="ti ti-pencil"></i></a>';
                $act_phot = '<button title="Incluir Imagem" data-id="'.$produto->id.'" class="btn btn-sm btn-icon btn-outline-warning btn-round btn-photo"><i class="ti ti-image"></i></button>';
                $act_comp = '<button title="Composição" data-id="'.$produto->id.'" class="btn btn-sm btn-icon btn-outline-default btn-round btn-comp"><i class="ti ti-list"></i></button>';

                $status = ($produto->active == true ? '<span class="btn btn-sm btn-icon btn-round btn-inverse-success"><i class="ti ti-unlock" title="Ativo"></i></span>' : '<span class="btn btn-sm btn-icon btn-round btn-inverse-danger"><i class="ti ti-lock" title="Inativo"></i></span>');
            } else {
                $act_view = '<button data-toggle="tooltip" data-original-title="Visualizar Produto" title="Visualizar Produto" data-id="'.$produto->id.'" data-modulo="view" class="btn btn-xs btn-default text-primary btn-width-27 btn-view"><i class="fa fa-eye"></i></button>';
                $act_edit = '<button data-toggle="tooltip" data-original-title="Editar Produto" title="Editar Produto" data-id="'.$produto->id.'" data-modulo="edit" class="btn btn-xs btn-default btn-width-27 btn-edit"><i class="fas fa-edit"></i></button>';
                $act_phot = '<button data-toggle="tooltip" data-original-title="Incluir Imagem" title="Incluir Imagem" data-id="'.$produto->id.'" data-modulo="photo" class="btn btn-xs btn-default text-warning btn-width-27 btn-photo"><i class="fas fa-camera"></i></button>';
                $act_comp = '<button data-toggle="tooltip" data-original-title="Composição" title="Composição" data-id="'.$produto->id.'" data-modulo="composicao" class="btn btn-xs btn-default btn-width-27 btn-comp"><i class="fas fa-list"></i></button>';

                $status = ($produto->active == true ? '<span class="btn btn-xs btn-default rounded-circle-custom text-success" data-toggle="tooltip" data-original-title="Ativo"><i class="fa fa-unlock" title="Ativo"></i></span>' : '<span class="btn btn-xs btn-default rounded-circle-custom text-danger" data-toggle="tooltip" data-original-title="Inativo"><i class="fa fa-lock" title="Inativo"></i></span>');
            }

            if ($produto->photo != null) {
                $url_image = site_url("estoque/produtos/show_photo/$produto->photo");
                $image = [
                    'src' => site_url("estoque/produtos/show_photo/$produto->photo"),
                    'class' => 'img-fluid',
                    'alt' => $produto->referencia,
                    'title' => 'Ampliar',
                    'data-id' => $produto->id,
                    'width' => '32',
                ];
            } else {
                $url_image = site_url('assets/images/avatar-produto.png');
                $image = [
                    'src' => site_url('assets/images/avatar-produto.png'),
                    'class' => 'rounded-circle img-fluid',
                    'alt' => 'Produto sem foto cadastrada',
                    'title' => 'Ampliar',
                    'data-id' => $produto->id,
                    'width' => '32',
                ];
            }

            if (APP_THEME == 'mentor') {
                $link_image = '<a href="'.$url_image.'" target="_blank">'.$produto->photo = img($image).'</a>';
            } else {
                $link_image = '<div class="img-thumbnail">'.'<a href="'.$url_image.'" target="_blank">'.$produto->photo = img($image).'</a>'.'</div>';
            }

            $sub_array = [];

            $sub_array[] = $produto->id;
            $sub_array[] = $produto->codigo_ncm;
            $sub_array[] = $produto->referencia;
            $sub_array[] = $produto->descricao;
            $sub_array[] = $link_image;
            $sub_array[] = $status;
            $sub_array[] = $act_comp.$act_phot.$act_view.$act_edit.$produto->buttonsControl();

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
     * Método que retorna a view de inclusão de produto.
     *
     * @return view
     */
    public function add()
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('criar-'.$this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>'.$this->getLoggedUserData()->name.'</b> não possui permissão para acessar este módulo.');
        }

        $produto = new Produto();

        $data = [
            'menu' => 'Estoque',
            'submenu' => 'Cadastros',
            'title' => 'Novo Produto',
            'method' => 'insert',
            'viewpath' => APP_THEME.$this->viewFolder,
            'form' => 'form',
            'response' => 'response',
            'table' => $produto,
            'tipos' => $this->tipoProdutoModel->getAllTipoProdutos(),
            'unidades' => $this->unidadeModel->getAllUnidades(),
            'marcas' => $this->marcaModel->getAllMarcas(),
            'modelos' => $this->modeloModel->getAllModelos(),
            'grupos' => $this->grupoModel->getAllGrupos(),
            'secoes' => $this->secaoModel->getAllSecoes(),
            'tabelas' => $this->tabelaModel->getAllTabelas(),
            'depositos' => $this->depositoModel->getAllDepositos(),
            'fornecedores' => $this->fornecedorModel->getAllFornecedores(),
            'estoques' => $this->estoqueModel->getEstoqueProduto(0),
            'precos' => $this->precoModel->getPrecosProduto(0),
            'prod_fornecedores' => $this->prodFornecModel->getFornecedoresProduto(0),
            'imagens' => $this->imagemModel->getImagensProduto(0),
        ];

        if (APP_THEME == 'mentor') {
            return view(APP_THEME.$this->viewFolder.'/form', $data);
        } else {
            return view(APP_THEME.'/layout/modals/_modal', $data);
        }
    }

    /**
     * Método que faz o insert dos dados do produto.
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

        if (isset($post['estoque'])) {
            $post['estoque'] = ($post['estoque'] == 'on' ? true : false);
        } else {
            $post['estoque'] = false;
        }

        $post['peso_bruto'] = convertDecimal($post['peso_bruto']);
        $post['peso_liquido'] = convertDecimal($post['peso_liquido']);
        $post['estoque_inicial'] = convertDecimal($post['estoque_inicial']);
        $post['estoque_minimo'] = convertDecimal($post['estoque_minimo']);
        $post['estoque_maximo'] = convertDecimal($post['estoque_maximo']);
        $post['estoque_atual'] = convertDecimal($post['estoque_atual']);
        $post['estoque_reservado'] = convertDecimal($post['estoque_reservado']);
        $post['estoque_real'] = convertDecimal($post['estoque_real']);
        $post['custo_bruto'] = convertDecimal($post['custo_bruto']);
        $post['custo_perc_desconto'] = convertDecimal($post['custo_perc_desconto']);
        $post['custo_valor_desconto'] = convertDecimal($post['custo_valor_desconto']);
        $post['custo_perc_ipi'] = convertDecimal($post['custo_perc_ipi']);
        $post['custo_valor_ipi'] = convertDecimal($post['custo_valor_ipi']);
        $post['custo_perc_st'] = convertDecimal($post['custo_perc_st']);
        $post['custo_valor_st'] = convertDecimal($post['custo_valor_st']);
        $post['custo_perc_frete'] = convertDecimal($post['custo_perc_frete']);
        $post['custo_valor_frete'] = convertDecimal($post['custo_valor_frete']);
        $post['custo_real'] = convertDecimal($post['custo_real']);

        // Extrai os dados de preços do POST
        $precos_data = [];

        if (isset($post['pre_tab'])) {
            foreach ($post['pre_tab'] as $index => $tab_pre) {
                $precos_data[] = [
                    'id' => $post['pre_id'][$index] ?? null,
                    'produto_id' => null,
                    'tabela_id' => $tab_pre,
                    'preco_custo' => $post['custo_real'],
                    'perc_lucro' => convertDecimal($post['pre_mar'][$index]),
                    'preco_venda' => convertDecimal($post['pre_vlr'][$index]),
                    'active' => true,
                ];
            }
        }

        // Extrai os dados de fornecedores do POST
        $fornecs_data = [];

        if (isset($post['for_id'])) {
            foreach ($post['for_id'] as $index => $prod_fornec) {
                $fornecs_data[] = [
                    'id' => $post['fornec_id'][$index] ?? null,
                    'produto_id' => null,
                    'fornecedor_id' => $prod_fornec,
                    'codigo' => $post['for_cod'][$index],
                    'active' => true,
                ];
            }
        }

        // Limpa os dados desnecessários do POST
        $fields_to_unset = [
            'method',
            'deposito',
            'quantidade',
            'tabela',
            'margem_lucro',
            'valor_venda',
            'fornecedor',
            'codigo_fornecedor',
            'pre_id',
            'pre_tab',
            'pre_mar',
            'pre_vlr',
            'fornec_id',
            'for_id',
            'for_cod',
        ];

        foreach ($fields_to_unset as $field) {
            unset($post[$field]);
        }

        $produto = new Produto($post);

        try {
            $this->db->transStart(); // Inicia a transação

            // Insere a produto
            if (!$this->produtoModel->protect(false)->insert($produto, true)) {
                throw new \Exception('Erro ao inserir o produto.');
            }

            $produto_id = $this->produtoModel->getInsertID();

            // Insere os precos
            foreach ($precos_data as $preco_data) {
                $preco_data['produto_id'] = $produto_id;
                //$preco_data['active'] = true;

                $preco = new ProdutoPreco($preco_data);

                if (!$this->precoModel->protect(false)->insert($preco, false)) {
                    throw new \Exception('Erro ao inserir um dos preços.');
                }
            }

            // Insere os fornecedores
            foreach ($fornecs_data as $fornec_data) {
                $fornec_data['produto_id'] = $produto_id;

                $fornecedor = new ProdutoFornecedor($fornec_data);

                if (!$this->prodFornecModel->protect(false)->insert($fornecedor, false)) {
                    throw new \Exception('Erro ao inserir um dos fornecedores.');
                }
            }

            $this->db->transComplete(); // Finaliza a transação

            if ($this->db->transStatus() === false) {
                throw new \Exception('Erro ao completar a transação.');
            }

            if (!$this->produtoModel->errors()) {
                $return['success'] = 'Dados salvos com sucesso!';
            } else {
                $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
                $return['errors_model'] = $this->produtoModel->errors();
            }

            $return['id'] = $produto_id;

            return $this->response->setJSON($return);
        } catch (\Exception $e) {
            $this->db->transRollback(); // Reverte as mudanças em caso de erro

            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $e->getMessage();

            return $this->response->setJSON($return);
        }
    }

    /**
     * Método que retorna a view de edição dos dados do produto.
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

        $produto = $this->validation_produto($id);

        $data = [
            'menu' => 'Estoque',
            'submenu' => 'Cadastros',
            'title' => 'Editar Produto',
            'method' => 'update',
            'viewpath' => APP_THEME.$this->viewFolder,
            'form' => 'form',
            'response' => 'response',
            'table' => $produto,
            'tipos' => $this->tipoProdutoModel->getAllTipoProdutos(),
            'unidades' => $this->unidadeModel->getAllUnidades(),
            'marcas' => $this->marcaModel->getAllMarcas(),
            'modelos' => $this->modeloModel->getAllModelos(),
            'grupos' => $this->grupoModel->getAllGrupos(),
            'secoes' => $this->secaoModel->getAllSecoes(),
            'tabelas' => $this->tabelaModel->getAllTabelas(),
            'depositos' => $this->depositoModel->getAllDepositos(),
            'fornecedores' => $this->fornecedorModel->getAllFornecedores(),
            'estoques' => $this->estoqueModel->getEstoqueProduto($id),
            'precos' => $this->precoModel->getPrecosProduto($id),
            'prod_fornecedores' => $this->prodFornecModel->getFornecedoresProduto($id),
            'imagens' => $this->imagemModel->getImagensProduto($id),
        ];

        if (APP_THEME == 'mentor') {
            return view(APP_THEME.$this->viewFolder.'/form', $data);
        } else {
            return view(APP_THEME.'/layout/modals/_modal', $data);
        }
    }

    /**
     * Método que faz o update dos dados do produto.
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

        if (isset($post['estoque'])) {
            $post['estoque'] = ($post['estoque'] == 'on' ? true : false);
        } else {
            $post['estoque'] = false;
        }

        $post['peso_bruto'] = convertDecimal($post['peso_bruto']);
        $post['peso_liquido'] = convertDecimal($post['peso_liquido']);
        $post['estoque_inicial'] = convertDecimal($post['estoque_inicial']);
        $post['estoque_minimo'] = convertDecimal($post['estoque_minimo']);
        $post['estoque_maximo'] = convertDecimal($post['estoque_maximo']);
        $post['estoque_atual'] = convertDecimal($post['estoque_atual']);
        $post['estoque_reservado'] = convertDecimal($post['estoque_reservado']);
        $post['estoque_real'] = convertDecimal($post['estoque_real']);
        $post['custo_bruto'] = convertDecimal($post['custo_bruto']);
        $post['custo_perc_desconto'] = convertDecimal($post['custo_perc_desconto']);
        $post['custo_valor_desconto'] = convertDecimal($post['custo_valor_desconto']);
        $post['custo_perc_ipi'] = convertDecimal($post['custo_perc_ipi']);
        $post['custo_valor_ipi'] = convertDecimal($post['custo_valor_ipi']);
        $post['custo_perc_st'] = convertDecimal($post['custo_perc_st']);
        $post['custo_valor_st'] = convertDecimal($post['custo_valor_st']);
        $post['custo_perc_frete'] = convertDecimal($post['custo_perc_frete']);
        $post['custo_valor_frete'] = convertDecimal($post['custo_valor_frete']);
        $post['custo_real'] = convertDecimal($post['custo_real']);

        // Extrai os dados de preços do POST
        $precos_data = [];

        if (isset($post['pre_tab'])) {
            foreach ($post['pre_tab'] as $index => $tab_pre) {
                $precos_data[] = [
                    'id' => $post['pre_id'][$index] ?? null,
                    'produto_id' => $post['id'],
                    'tabela_id' => $tab_pre, //$post['pre_tab'][$index],
                    'preco_custo' => $post['custo_real'],
                    'perc_lucro' => convertDecimal($post['pre_mar'][$index]),
                    'preco_venda' => convertDecimal($post['pre_vlr'][$index]),
                    'active' => true,
                ];
            }
        }

        // Extrai os dados de fornecedores do POST
        $fornecs_data = [];

        if (isset($post['for_id'])) {
            foreach ($post['for_id'] as $index => $prod_fornec) {
                $fornecs_data[] = [
                    'id' => $post['fornec_id'][$index] ?? null,
                    'produto_id' => $post['id'],
                    'fornecedor_id' => $prod_fornec,
                    'codigo' => $post['for_cod'][$index],
                    'active' => true,
                ];
            }
        }

        // Extrai os dados de imagens do POST
        $imagens_data = [];

        if (isset($post['imagem_id'])) {
            foreach ($post['imagem_id'] as $index => $prod_imagem) {
                $imagens_data[] = [
                    'id' => $prod_imagem,
                    'active' => true,
                ];
            }
        }

        // Limpa os dados desnecessários do POST
        $fields_to_unset = [
            'method',
            'deposito',
            'quantidade',
            'tabela',
            'margem_lucro',
            'valor_venda',
            'fornecedor',
            'codigo_fornecedor',
            'pre_id',
            'pre_tab',
            'pre_mar',
            'pre_vlr',
            'fornec_id',
            'for_id',
            'for_cod',
            'imagem_id',
            'estoque_id',
            'deposito_id',
        ];

        foreach ($fields_to_unset as $field) {
            unset($post[$field]);
        }

        // print_r($post);
        // print_r($precos_data);
        // print_r($fornecs_data);
        // print_r($this->db->getLastQuery()->getQuery());

        try {
            $this->db->transStart(); // Inicia a transação

            $produto = $this->validation_produto($post['id']);

            // IDs de imagens recebidos do formulário
            $imagens_ids = array_filter(array_column($imagens_data, 'id'));

            // Exclui (soft delete) imgens que não estão no formulário
            if (!empty($imagens_ids)) {
                $this->imagemModel->where('produto_id', $produto->id)
                    ->whereNotIn('id', $imagens_ids)
                    ->set(['active' => false])
                    ->delete(null, false);
            } else {
                // Se nenhuma imagem foi enviada, inativa todas as imagens do produto
                $post['photo'] = null;

                $this->imagemModel->where('produto_id', $produto->id)
                    ->set(['active' => false])
                    ->delete(null, false);
            }

            $produto->fill($post);

            if ($produto->hasChanged()) {
                $this->produtoModel->protect(false)->save($produto);
            }

            // IDs de precos recebidos do formulário
            $precos_ids = array_filter(array_column($precos_data, 'id'));

            // Exclui (soft delete) preços que não estão no formulário
            if (!empty($precos_ids)) {
                $this->precoModel->where('produto_id', $produto->id)
                    ->whereNotIn('id', $precos_ids)
                    ->set(['active' => false])
                    ->delete(null, false);
            } else {
                $produto->photo = null;
                // Se nenhum preço foi enviado, inativa todos os preços do produto
                $this->precoModel->where('produto_id', $produto->id)
                    ->set(['active' => false])
                    ->delete(null, false);
            }

            // Atualiza ou insere os preços
            foreach ($precos_data as $preco_data) {
                if (!empty($preco_data['id'])) {
                    // Atualiza o preço existente
                    $preco = $this->validation_preco($preco_data['id']);

                    $preco->fill($preco_data);

                    if ($preco->hasChanged()) {
                        $this->precoModel->protect(false)->save($preco);
                    }
                } else {
                    // Insere novo preço
                    $this->precoModel->insert($preco_data, false);
                }
            }

            // IDs de fornecedores recebidos do formulário
            $fornec_ids = array_filter(array_column($fornecs_data, 'id'));

            // Exclui (soft delete) fornecedores que não estão no formulário
            if (!empty($fornec_ids)) {
                $this->prodFornecModel->where('produto_id', $produto->id)
                    ->whereNotIn('id', $fornec_ids)
                    ->set(['active' => false])
                    ->delete(null, false);
            } else {
                // Se nenhum fornecedor foi enviado, inativa todos os fornecedores do produto
                $this->prodFornecModel->where('produto_id', $produto->id)
                    ->set(['active' => false])
                    ->delete(null, false);
            }

            // Atualiza ou insere os fornecedores
            foreach ($fornecs_data as $fornec_data) {
                if (!empty($fornec_data['id'])) {
                    // Atualiza o fornecedor existente
                    $fornec = $this->validation_fornecedor_produto($fornec_data['id']);
                    $fornec->fill($fornec_data);

                    if ($fornec->hasChanged()) {
                        $this->prodFornecModel->protect(false)->save($fornec);
                    }
                } else {
                    // Insere novo fornecedor
                    $this->prodFornecModel->insert($fornec_data, false);
                }
            }

            $this->db->transComplete(); // Finaliza a transação

            if ($this->db->transStatus() === false) {
                throw new \Exception('Erro ao salvar os dados.');
            }

            if (!$this->produtoModel->errors()) {
                $return['success'] = 'Dados salvos com sucesso!';
            } else {
                $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
                $return['errors_model'] = $this->produtoModel->errors();
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
     * Método que retorna a view de deleção do produto.
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

        $produto = $this->validation_produto($id);

        $data = [
            'title' => 'Excluir',
            'method' => 'delete',
            'table' => $produto,
        ];

        return view(APP_THEME.$this->viewFolder.'/_delete', $data);
    }

    /**
     * Método que faz a deleção do produto.
     *
     * @param $id
     *
     * @return json
     */
    public function remove(int $id = null)
    {
        if (!$this->request->isAJAX()) {
            return redirect()->back();
        }

        $produto = $this->validation_produto($id);

        $this->produtoModel->delete($produto->id);

        $produto->active = false;

        $this->produtoModel->protect(false)->save($produto);

        if (!$this->produtoModel->errors()) {
            $return['success'] = 'Removido com sucesso!';
        } else {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $this->produtoModel->errors();
        }

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view de restore do produto.
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

        $produto = $this->validation_produto($id);

        $data = [
            'title' => 'Restaurar',
            'method' => 'restore',
            'table' => $produto,
        ];

        return view(APP_THEME.$this->viewFolder.'/_restore', $data);
    }

    /**
     * Método que faz o restore do produto.
     *
     * @param $id
     *
     * @return json
     */
    public function restore(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('editar-'.$this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>'.$this->getLoggedUserData()->name.'</b> não possui permissão para acessar este módulo.');
        }

        $produto = $this->validation_produto($id);

        $produto->deleted_at = null;
        $produto->active = true;

        $this->produtoModel->protect(false)->save($produto);

        if (!$this->produtoModel->errors()) {
            $return['success'] = 'Restaurado com sucesso!';
        } else {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $this->produtoModel->errors();
        }

        return $this->response->setJSON($return);
    }

    /**
     * Método que retorna a view de visualização dos dados do produto.
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

        $produto = $this->validation_produto($id);

        $data = [
            'title' => 'Visualizar Produto',
            'method' => 'show',
            'table' => $produto,
            'tipos' => $this->tipoProdutoModel->getAllTipoProdutos(),
            'unidades' => $this->unidadeModel->getAllUnidades(),
            'marcas' => $this->marcaModel->getAllMarcas(),
            'modelos' => $this->modeloModel->getAllModelos(),
            'grupos' => $this->grupoModel->getAllGrupos(),
            'secoes' => $this->secaoModel->getAllSecoes(),
            'tabelas' => $this->tabelaModel->getAllTabelas(),
            'depositos' => $this->depositoModel->getAllDepositos(),
            'fornecedores' => $this->fornecedorModel->getAllFornecedores(),
            'estoques' => $this->estoqueModel->getEstoqueProduto($id),
            'precos' => $this->precoModel->getPrecosProduto($id),
            'prod_fornecedores' => $this->prodFornecModel->getFornecedoresProduto($id),
            'imagens' => $this->imagemModel->getImagensProduto($id),
        ];

        return view(APP_THEME.$this->viewFolder.'/_show', $data);
    }

    /**
     * Método que renderiza o código de barras.
     *
     * @param $barcode
     *
     * @return barcode
     */
    public function barcode(string $barcode)
    {
        // Make Barcode object of Code128 encoding.
        $barcode = (new \Picqer\Barcode\Types\TypeEan13())->getBarcode($barcode);
        // Output the barcode as HTML in the browser with a HTML Renderer
        $renderer = new \Picqer\Barcode\Renderers\HtmlRenderer();

        return $renderer->render($barcode);
    }

    /**
     * Método que retorna a view de inclusão de fotos.
     *
     * @param $id
     *
     * @return view
     */
    public function photo(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('criar-'.$this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>'.$this->getLoggedUserData()->name.'</b> não possui permissão para acessar este módulo.');
        }

        $produto = $this->validation_produto($id);

        $data = [
            'title' => 'Incluir Imagem',
            'produto' => $produto,
        ];

        return view(APP_THEME.$this->viewFolder.'/_photo', $data);
    }

    /**
     * Método que faz o upload da imagem do produto.
     *
     * @return json
     */
    public function photo_upload()
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

        if (isset($post['destaque'])) {
            $post['destaque'] = ($post['destaque'] == 'on' ? true : false);
        } else {
            $post['destaque'] = false;
        }

        $produto = $this->validation_produto($post['produto_id']);
        $file = $this->request->getFile('photo');

        // print_r($post);
        // echo '--------';
        // print_r($file);

        list($width, $heigth) = getimagesize($file->getPathName());

        if ($width < '150' || $heigth < '150') {
            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = ['dimension' => 'A imagem não pode ser menor que 150 x 150px'];

            return $this->response->setJSON($return);
        }

        try {
            $this->db->transStart(); // Inicia a transação

            $filepath = $file->store('produtos');
            $filepath = WRITEPATH."uploads/$filepath";

            $this->manipulate_image($filepath);

            $imagem = new ProdutoImagem($post);
            $imagem->photo = $file->getName();

            if ($post['destaque'] == true) {
                $produto->photo = $imagem->photo;

                $this->produtoModel->save($produto);
            }

            $this->imagemModel->insert($imagem);

            $this->db->transComplete(); // Finaliza a transação

            if ($this->db->transStatus() === false) {
                throw new \Exception('Erro ao salvar os dados.');
            }

            if (!$this->imagemModel->errors()) {
                session()->setFlashdata('message-success', 'Imagem incluída com sucesso!');

                $return['success'] = 'Imagem incluída com sucesso!';
            } else {
                $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
                $return['errors_model'] = $this->imagemModel->errors();
            }

            //return $this->response->setJSON($return);
            return 'ok';
        } catch (\Exception $e) {
            $this->db->transRollback(); // Reverte as mudanças em caso de erro

            $return['error'] = 'Verifique o(s) erro(s) abaixo e tente novamente';
            $return['errors_model'] = $e->getMessage();

            return $this->response->setJSON($return);
        }
    }

    /**
     * Método que exibe a imagem em destaque do produto.
     *
     * @param $image
     */
    public function show_photo(string $image = null)
    {
        if ($image != null) {
            $this->showImage('produtos', $image);
        }
    }

    /**
     * Método que retorna a view de importação de XML
     *
     * @return view
     */
    public function import()
    {
        if ($this->getLoggedUserData() == '') {
            return redirect()->to(site_url('login'))->with('message-info', 'Verifique suas credenciais e tente novamente!');
        }

        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('criar-'.$this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>'.$this->getLoggedUserData()->name.'</b> não possui permissão para acessar este módulo.');
        }

        $data = [
            'title' => 'Importar XML',
        ];

        return view(APP_THEME.$this->viewFolder.'/_import', $data);
    }

    /**
     * Método que faz a leitura do xml e a inclusão de produto(s)
     *
     * @return string or Exception
     */
    public function upload()
    {
        try {
            $this->db->transStart(); // Inicia a transação

            $file = $this->request->getFile('xml');
            $xml = simplexml_load_file($file);

            $emitente = $xml->NFe->infNFe->emit;

            $fornecedor = $this->fornecedorModel
                ->where('cnpj', formatCnpjCpf($emitente->CNPJ))
                ->first();

            if ($fornecedor == null) {
                $cidade = $this->cidadeModel
                    ->where('cod_ibge', (string) $emitente->enderEmit->cMun)
                    ->first();

                // print_r($this->db->getLastQuery());

                $data_fornecedor = [
                    'tipo' => 'J',
                    'razao_social' => (string) $emitente->xNome,
                    'nome_fantasia' => (string) $emitente->xFant,
                    'cnpj' => formatCnpjCpf((string) $emitente->CNPJ),
                    'inscricao_estadual' => (string) $emitente->IE,
                    'obs' => 'Cadastro realizado via importação de XML',
                    'id_antigo' => 0,
                ];

                if (!$this->fornecedorModel->protect(false)->insert($data_fornecedor, true)) {
                    throw new \Exception('Falha ao inserir fornecedor: '.implode(', ', $this->fornecedorModel->errors()));
                }

                $fornecedor_id = $this->fornecedorModel->getInsertID();

                $data_endereco = [
                    'fornecedor_id' => $fornecedor_id,
                    'tipo' => 'C',
                    'cep' => (string) $emitente->enderEmit->CEP,
                    'logradouro' => (string) $emitente->enderEmit->xLgr,
                    'numero' => (string) $emitente->enderEmit->nro,
                    'complemento' => (string) $emitente->enderEmit->xCpl,
                    'bairro' => (string) $emitente->enderEmit->xBairro,
                    'cidade_id' => $cidade->id,
                ];

                $this->enderecoModel->protect(false)->insert($data_endereco, false);

                $fornecedor = $this->fornecedorModel->find($fornecedor_id);
            }

            // Array para armazenar os códigos já inseridos nesta transação
            $arrDescricao = [];

            foreach ($xml->NFe->infNFe->det as $item) {
                $xProd = (string) $item->prod->xProd;

                // Verifica se o código já foi inserido nesta importação
                if (isset($arrDescricao[$xProd])) {
                    // Se já foi inserido, pula para o próximo item
                    continue;
                }

                // Adiciona o código ao array temporário
                $arrDescricao[$xProd] = true;

                if ((string) $item->prod->cEAN != 'SEM GTIN') {
                    $produto = $this->produtoModel
                        ->where('codigo_barras', (string) $item->prod->cEAN)
                        ->first();

                    if (empty($produto)) {
                        $produto = $this->produtoModel
                            ->where('referencia', (string) $item->prod->cProd)
                            ->first();
                    }
                } else {
                    $produto = $this->produtoModel
                        ->where('referencia', (string) $item->prod->cProd)
                        ->first();
                }

                $unidade = $this->unidadeModel
                    ->where('abreviatura', (string) $item->prod->uCom)
                    ->first();

                if (empty($produto)) {
                    $data_produto = [
                        'tipo_id' => 1,
                        'codigo_barras' => (string) $item->prod->cEAN,
                        'descricao' => (string) $item->prod->xProd,
                        'codigo_ncm' => (string) $item->prod->NCM,
                        'referencia' => (string) $item->prod->cProd,
                        'unidade_entrada_id' => empty($unidade) ? 1 : $unidade->id,
                        'unidade_saida_id' => empty($unidade) ? 1 : $unidade->id,
                        'marca_id' => 1,
                        'modelo_id' => 1,
                        'grupo_id' => 1,
                        'secao_id' => 1,
                        'estoque' => 1,
                        'custo_bruto' => (float) $item->prod->vUnCom,
                        'custo_real' => (float) $item->prod->vUnCom,
                    ];

                    $produto_id = $this->produtoModel->protect(false)->insert($data_produto, true);

                    if (!$produto_id) {
                        throw new \Exception('Falha ao inserir produto: '.implode(', ', $this->produtoModel->errors()));
                    }

                    $data_fornec = [
                        'produto_id' => $produto_id,
                        'fornecedor_id' => $fornecedor->id,
                        'codigo' => (string) $item->prod->cProd,
                    ];

                    $this->prodFornecModel->protect(false)->insert($data_fornec, false);
                }
            }

            $this->db->transComplete(); // Finaliza a transação após o loop

            if ($this->db->transStatus() === false) {
                throw new \Exception('Erro ao completar a transação.');
            }

            session()->setFlashdata('message-success', 'Produto(s) cadastrado(s) com sucesso!');

            return 'ok';
        } catch (\Exception $e) {
            $this->db->transRollback(); // Reverte as mudanças em caso de erro

            session()->setFlashdata('message-error', $e->getMessage());

            return $e->getMessage();
        }
    }

    /**
     * Método que retorna a view de inclusão de composição
     *
     * @param $id
     *
     * @return view
     */
    public function composicao(int $id = null)
    {
        if ((!$this->getLoggedUserData()->is_admin) || (!$this->getLoggedUserData()->validatePermissionLoggedUser('criar-'.$this->route))) {
            session()->setFlashdata('message-warning', 'O usuário <b>'.$this->getLoggedUserData()->name.'</b> não possui permissão para acessar este módulo.');
        }

        $produto = $this->validation_produto($id);

        $data = [
            'title' => 'Configurar Composição do Produto',
            'produto' => $produto,
        ];

        return view(APP_THEME.$this->viewFolder.'/_composicao', $data);
    }
}
