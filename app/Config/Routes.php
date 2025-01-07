<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

/**
 * Controller Home
 */
$routes->add('/', 'Home::dynamicRoute');
$routes->add('home', 'Home::dynamicRoute');

/**
 * Controller Login
 */
$routes->group('login', function ($routes) {});

$routes->get('login', 'Login::login');
$routes->get('logout', 'Login::logout');
$routes->get('login/forgot', 'Login::forgot_password');
$routes->get('login/reset/(:any)', 'Login::reset/$1');
$routes->get('login/authenticate', 'Login::authenticate');

$routes->post('login/forgot_process', 'Login::forgot_proccess');
$routes->post('login/reset_proccess', 'Login::reset_proccess');

/****************************************************************************************************
 *  Acessos
 ****************************************************************************************************/

/**
 * Controller Users
 */
$routes->get('usuarios', 'Users::index');
$routes->get('usuarios/add', 'Users::add');
$routes->get('usuarios/edit/(:num)', 'Users::edit/$1');
$routes->get('usuarios/show/(:num)', 'Users::show/$1');
$routes->get('usuarios/delete/(:num)', 'Users::delete/$1');
$routes->get('usuarios/undo/(:num)', 'Users::undo/$1');
$routes->get('usuarios/grupos/(:num)', 'Users::groups/$1');
$routes->get('usuarios/fetch_groups/(:num)', 'Users::fetch_groups/$1');
$routes->get('usuarios/view_photo/(:num)', 'Users::view_photo/$1');

$routes->post('usuarios/remove/(:num)', 'Users::remove/$1');
$routes->post('usuarios/restore/(:num)', 'Users::restore/$1');
$routes->post('usuarios/fetch', 'Users::fetch');
$routes->post('usuarios/insert', 'Users::insert');
$routes->post('usuarios/update', 'Users::update');
$routes->post('usuarios/groups_save', 'Users::groups_save');

/**
 * Controller Groups
 */
$routes->get('grupos', 'Groups::index');
$routes->get('grupos/add', 'Groups::add');
$routes->get('grupos/edit/(:num)', 'Groups::edit/$1');
$routes->get('grupos/show/(:num)', 'Groups::show/$1');
$routes->get('grupos/delete/(:num)', 'Groups::delete/$1');
$routes->get('grupos/undo/(:num)', 'Groups::undo/$1');
$routes->get('grupos/permissoes/(:num)', 'Groups::permissions/$1');
$routes->get('grupos/fetch_permissions/(:num)', 'Groups::fetch_permissions/$1');

$routes->post('grupos/remove/(:num)', 'Groups::remove/$1');
$routes->post('grupos/restore/(:num)', 'Groups::restore/$1');
$routes->post('grupos/fetch', 'Groups::fetch');
$routes->post('grupos/insert', 'Groups::insert');
$routes->post('grupos/update', 'Groups::update');
$routes->post('grupos/permissions_save', 'Groups::permissions_save');

/**
 * Controller Permissions
 */
$routes->get('permissoes', 'Permissions::index');
$routes->get('permissoes/add', 'Permissions::add');
$routes->get('permissoes/edit/(:num)', 'Permissions::edit/$1');
$routes->get('permissoes/show/(:num)', 'Permissions::show/$1');
$routes->get('permissoes/delete/(:num)', 'Permissions::delete/$1');
$routes->get('permissoes/undo/(:num)', 'Permissions::undo/$1');

$routes->post('permissoes/remove/(:num)', 'Permissions::remove/$1');
$routes->post('permissoes/restore/(:num)', 'Permissions::restore/$1');
$routes->post('permissoes/fetch', 'Permissions::fetch');
$routes->post('permissoes/insert', 'Permissions::insert');
$routes->post('permissoes/update', 'Permissions::update');


/****************************************************************************************************
 *  Estoque
 ****************************************************************************************************/
$routes->group('estoque', function ($routes) {
    /**
     * Controller DepositosProdutos
     */
    $routes->get('depositos', 'DepositosProdutos::index');
    $routes->get('depositos/add', 'DepositosProdutos::add');
    $routes->get('depositos/add_modal', 'DepositosProdutos::add_modal');
    $routes->get('depositos/edit/(:num)', 'DepositosProdutos::edit/$1');
    $routes->get('depositos/show/(:num)', 'DepositosProdutos::show/$1');
    $routes->get('depositos/delete/(:num)', 'DepositosProdutos::delete/$1');
    $routes->get('depositos/undo/(:num)', 'DepositosProdutos::undo/$1');

    $routes->post('depositos/remove/(:num)', 'DepositosProdutos::remove/$1');
    $routes->post('depositos/restore/(:num)', 'DepositosProdutos::restore/$1');
    $routes->post('depositos/fetch', 'DepositosProdutos::fetch');
    $routes->post('depositos/insert', 'DepositosProdutos::insert');
    $routes->post('depositos/update', 'DepositosProdutos::update');

    /**
     * Controller MarcasProdutos
     */
    $routes->get('marcas', 'MarcasProdutos::index');
    $routes->get('marcas/add', 'MarcasProdutos::add');
    $routes->get('marcas/add_modal', 'MarcasProdutos::add_modal');
    $routes->get('marcas/edit/(:num)', 'MarcasProdutos::edit/$1');
    $routes->get('marcas/show/(:num)', 'MarcasProdutos::show/$1');
    $routes->get('marcas/delete/(:num)', 'MarcasProdutos::delete/$1');
    $routes->get('marcas/undo/(:num)', 'MarcasProdutos::undo/$1');

    $routes->post('marcas/remove/(:num)', 'MarcasProdutos::remove/$1');
    $routes->post('marcas/restore/(:num)', 'MarcasProdutos::restore/$1');
    $routes->post('marcas/fetch', 'MarcasProdutos::fetch');
    $routes->post('marcas/insert', 'MarcasProdutos::insert');
    $routes->post('marcas/update', 'MarcasProdutos::update');

    /**
     * Controller ModelosProdutos
     */
    $routes->get('modelos', 'ModelosProdutos::index');
    $routes->get('modelos/add', 'ModelosProdutos::add');
    $routes->get('modelos/add_modal', 'ModelosProdutos::add_modal');
    $routes->get('modelos/edit/(:num)', 'ModelosProdutos::edit/$1');
    $routes->get('modelos/show/(:num)', 'ModelosProdutos::show/$1');
    $routes->get('modelos/delete/(:num)', 'ModelosProdutos::delete/$1');
    $routes->get('modelos/undo/(:num)', 'ModelosProdutos::undo/$1');

    $routes->post('modelos/remove/(:num)', 'ModelosProdutos::remove/$1');
    $routes->post('modelos/restore/(:num)', 'ModelosProdutos::restore/$1');
    $routes->post('modelos/fetch', 'ModelosProdutos::fetch');
    $routes->post('modelos/insert', 'ModelosProdutos::insert');
    $routes->post('modelos/update', 'ModelosProdutos::update');

    /**
     * Controller SecoesProdutos
     */
    $routes->get('secoes', 'SecoesProdutos::index');
    $routes->get('secoes/add', 'SecoesProdutos::add');
    $routes->get('secoes/add_modal', 'SecoesProdutos::add_modal');
    $routes->get('secoes/edit/(:num)', 'SecoesProdutos::edit/$1');
    $routes->get('secoes/show/(:num)', 'SecoesProdutos::show/$1');
    $routes->get('secoes/delete/(:num)', 'SecoesProdutos::delete/$1');
    $routes->get('secoes/undo/(:num)', 'SecoesProdutos::undo/$1');

    $routes->post('secoes/remove/(:num)', 'SecoesProdutos::remove/$1');
    $routes->post('secoes/restore/(:num)', 'SecoesProdutos::restore/$1');
    $routes->post('secoes/fetch', 'SecoesProdutos::fetch');
    $routes->post('secoes/insert', 'SecoesProdutos::insert');
    $routes->post('secoes/update', 'SecoesProdutos::update');

    /**
     * Controller GruposProdutos
     */
    $routes->get('grupos', 'GruposProdutos::index');
    $routes->get('grupos/add', 'GruposProdutos::add');
    $routes->get('grupos/add_modal', 'GruposProdutos::add_modal');
    $routes->get('grupos/edit/(:num)', 'GruposProdutos::edit/$1');
    $routes->get('grupos/show/(:num)', 'GruposProdutos::show/$1');
    $routes->get('grupos/delete/(:num)', 'GruposProdutos::delete/$1');
    $routes->get('grupos/undo/(:num)', 'GruposProdutos::undo/$1');

    $routes->post('grupos/remove/(:num)', 'GruposProdutos::remove/$1');
    $routes->post('grupos/restore/(:num)', 'GruposProdutos::restore/$1');
    $routes->post('grupos/fetch', 'GruposProdutos::fetch');
    $routes->post('grupos/insert', 'GruposProdutos::insert');
    $routes->post('grupos/update', 'GruposProdutos::update');

    /**
     * Controller UnidadesProdutos
     */
    $routes->get('unidades', 'UnidadesProdutos::index');
    $routes->get('unidades/add', 'UnidadesProdutos::add');
    $routes->get('unidades/add_modal', 'UnidadesProdutos::add_modal');
    $routes->get('unidades/edit/(:num)', 'UnidadesProdutos::edit/$1');
    $routes->get('unidades/show/(:num)', 'UnidadesProdutos::show/$1');
    $routes->get('unidades/delete/(:num)', 'UnidadesProdutos::delete/$1');
    $routes->get('unidades/undo/(:num)', 'UnidadesProdutos::undo/$1');

    $routes->post('unidades/remove/(:num)', 'UnidadesProdutos::remove/$1');
    $routes->post('unidades/restore/(:num)', 'UnidadesProdutos::restore/$1');
    $routes->post('unidades/fetch', 'UnidadesProdutos::fetch');
    $routes->post('unidades/insert', 'UnidadesProdutos::insert');
    $routes->post('unidades/update', 'UnidadesProdutos::update');

    /**
     * Controller TiposProdutos
     */
    $routes->get('tiposproduto', 'TiposProdutos::index');
    $routes->get('tiposproduto/add', 'TiposProdutos::add');
    $routes->get('tiposproduto/edit/(:num)', 'TiposProdutos::edit/$1');
    $routes->get('tiposproduto/show/(:num)', 'TiposProdutos::show/$1');
    $routes->get('tiposproduto/delete/(:num)', 'TiposProdutos::delete/$1');
    $routes->get('tiposproduto/undo/(:num)', 'TiposProdutos::undo/$1');

    $routes->post('tiposproduto/remove/(:num)', 'TiposProdutos::remove/$1');
    $routes->post('tiposproduto/restore/(:num)', 'TiposProdutos::restore/$1');
    $routes->post('tiposproduto/fetch', 'TiposProdutos::fetch');
    $routes->post('tiposproduto/insert', 'TiposProdutos::insert');
    $routes->post('tiposproduto/update', 'TiposProdutos::update');

    /**
     * Controller Produtos
     */
    $routes->get('produtos', 'Produtos::index');
    $routes->get('produtos/add', 'Produtos::add');
    $routes->get('produtos/import', 'Produtos::import');
    $routes->get('produtos/edit/(:num)', 'Produtos::edit/$1');
    $routes->get('produtos/show/(:num)', 'Produtos::show/$1');
    $routes->get('produtos/delete/(:num)', 'Produtos::delete/$1');
    $routes->get('produtos/undo/(:num)', 'Produtos::undo/$1');
    $routes->get('produtos/photo/(:num)', 'Produtos::photo/$1');
    $routes->get('produtos/show_photo/(:any)', 'Produtos::show_photo/$1');
    $routes->get('produtos/composicao/(:num)', 'Produtos::composicao/$1');

    $routes->post('produtos/remove/(:num)', 'Produtos::remove/$1');
    $routes->post('produtos/restore/(:num)', 'Produtos::restore/$1');
    $routes->post('produtos/fetch', 'Produtos::fetch');
    $routes->post('produtos/insert', 'Produtos::insert');
    $routes->post('produtos/update', 'Produtos::update');
    $routes->post('produtos/upload', 'Produtos::upload');
    $routes->post('produtos/photo/upload', 'Produtos::photo_upload');

    /**
     * Controller TabelasPrecos
     */
    $routes->get('tabelasprecos', 'TabelasPrecos::index');
    $routes->get('tabelasprecos/add', 'TabelasPrecos::add');
    $routes->get('tabelasprecos/add_modal', 'TabelasPrecos::add_modal');
    $routes->get('tabelasprecos/edit/(:num)', 'TabelasPrecos::edit/$1');
    $routes->get('tabelasprecos/show/(:num)', 'TabelasPrecos::show/$1');
    $routes->get('tabelasprecos/delete/(:num)', 'TabelasPrecos::delete/$1');
    $routes->get('tabelasprecos/undo/(:num)', 'TabelasPrecos::undo/$1');

    $routes->post('tabelasprecos/remove/(:num)', 'TabelasPrecos::remove/$1');
    $routes->post('tabelasprecos/restore/(:num)', 'TabelasPrecos::restore/$1');
    $routes->post('tabelasprecos/fetch', 'TabelasPrecos::fetch');
    $routes->post('tabelasprecos/insert', 'TabelasPrecos::insert');
    $routes->post('tabelasprecos/update', 'TabelasPrecos::update');

    /**
     * Controller TiposMovimentos
     */
    $routes->get('tiposmovimento', 'TiposMovimentos::index');
    $routes->get('tiposmovimento/add', 'TiposMovimentos::add');
    $routes->get('tiposmovimento/edit/(:num)', 'TiposMovimentos::edit/$1');
    $routes->get('tiposmovimento/show/(:num)', 'TiposMovimentos::show/$1');
    $routes->get('tiposmovimento/delete/(:num)', 'TiposMovimentos::delete/$1');
    $routes->get('tiposmovimento/undo/(:num)', 'TiposMovimentos::undo/$1');

    $routes->post('tiposmovimento/remove/(:num)', 'TiposMovimentos::remove/$1');
    $routes->post('tiposmovimento/restore/(:num)', 'TiposMovimentos::restore/$1');
    $routes->post('tiposmovimento/fetch', 'TiposMovimentos::fetch');
    $routes->post('tiposmovimento/insert', 'TiposMovimentos::insert');
    $routes->post('tiposmovimento/update', 'TiposMovimentos::update');

    /**
     * Controller MovimentacoesEstoque
     */
    $routes->get('ajustes', 'MovimentacoesEstoque::ajustes');
    $routes->get('ajustes/import', 'MovimentacoesEstoque::ajustes_import');
    $routes->get('ajustes/view', 'MovimentacoesEstoque::ajustes_view');
    $routes->get('ajustes/del/(:num)', 'MovimentacoesEstoque::ajustes_delete/$1');
    $routes->get('ajustes/delete/(:num)', 'MovimentacoesEstoque::ajustes_delete_modal/$1');
    $routes->get('ajustes/complete', 'MovimentacoesEstoque::ajustes_complete');

    $routes->post('ajustes/fetch', 'MovimentacoesEstoque::ajustes_fetch');
    $routes->post('ajustes/upload', 'MovimentacoesEstoque::ajustes_upload');
    $routes->post('ajustes/update', 'MovimentacoesEstoque::ajustes_update');
});

/****************************************************************************************************
 *  Faturamento
 ****************************************************************************************************/
$routes->group('faturamento', function ($routes) {
    /**
     * Controller Orcamentos
     */
    $routes->get('orcamentos', 'Orcamentos::index');
    $routes->get('orcamentos/add', 'Orcamentos::add');
    $routes->get('orcamentos/edit/(:num)', 'Orcamentos::edit/$1');
    $routes->get('orcamentos/show/(:num)', 'Orcamentos::show/$1');
    $routes->get('orcamentos/delete/(:num)', 'Orcamentos::delete/$1');
    $routes->get('orcamentos/undo/(:num)', 'Orcamentos::undo/$1');

    $routes->post('orcamentos/remove/(:num)', 'Orcamentos::remove/$1');
    $routes->post('orcamentos/restore/(:num)', 'Orcamentos::restore/$1');
    $routes->post('orcamentos/fetch', 'Orcamentos::fetch');
    $routes->post('orcamentos/insert', 'Orcamentos::insert');
    $routes->post('orcamentos/update', 'Orcamentos::update');

    /**
     * Controller Pedidos
     */
    $routes->get('pedidos', 'Pedidos::index');
    $routes->get('pedidos/add', 'Pedidos::add');
    $routes->get('pedidos/edit/(:num)', 'Pedidos::edit/$1');
    $routes->get('pedidos/show/(:num)', 'Pedidos::show/$1');
    $routes->get('pedidos/delete/(:num)', 'Pedidos::delete/$1');
    $routes->get('pedidos/undo/(:num)', 'Pedidos::undo/$1');

    $routes->post('pedidos/remove/(:num)', 'Pedidos::remove/$1');
    $routes->post('pedidos/restore/(:num)', 'Pedidos::restore/$1');
    $routes->post('pedidos/fetch', 'Pedidos::fetch');
    $routes->post('pedidos/insert', 'Pedidos::insert');
    $routes->post('pedidos/update', 'Pedidos::update');
});

/****************************************************************************************************
 *  Financeiro
 ****************************************************************************************************/
$routes->group('financeiro', function ($routes) {

    $routes->get('dashboard', 'DashboardFinanceiro::index');    
    /**
     * Controller FormasPagamento
     */
    $routes->get('formaspgto', 'FormasPagamento::index');
    $routes->get('formaspgto/add', 'FormasPagamento::add');
    $routes->get('formaspgto/edit/(:num)', 'FormasPagamento::edit/$1');
    $routes->get('formaspgto/show/(:num)', 'FormasPagamento::show/$1');
    $routes->get('formaspgto/delete/(:num)', 'FormasPagamento::delete/$1');
    $routes->get('formaspgto/undo/(:num)', 'FormasPagamento::undo/$1');

    $routes->post('formaspgto/remove/(:num)', 'FormasPagamento::remove/$1');
    $routes->post('formaspgto/restore/(:num)', 'FormasPagamento::restore/$1');
    $routes->post('formaspgto/fetch', 'FormasPagamento::fetch');
    $routes->post('formaspgto/insert', 'FormasPagamento::insert');
    $routes->post('formaspgto/update', 'FormasPagamento::update');

    /**
     * Controller CondicoesPagamento
     */
    $routes->get('condicoespgto', 'CondicoesPagamento::index');
    $routes->get('condicoespgto/add', 'CondicoesPagamento::add');
    $routes->get('condicoespgto/edit/(:num)', 'CondicoesPagamento::edit/$1');
    $routes->get('condicoespgto/show/(:num)', 'CondicoesPagamento::show/$1');
    $routes->get('condicoespgto/delete/(:num)', 'CondicoesPagamento::delete/$1');
    $routes->get('condicoespgto/undo/(:num)', 'CondicoesPagamento::undo/$1');

    $routes->post('condicoespgto/remove/(:num)', 'CondicoesPagamento::remove/$1');
    $routes->post('condicoespgto/restore/(:num)', 'CondicoesPagamento::restore/$1');
    $routes->post('condicoespgto/fetch', 'CondicoesPagamento::fetch');
    $routes->post('condicoespgto/insert', 'CondicoesPagamento::insert');
    $routes->post('condicoespgto/update', 'CondicoesPagamento::update');

    /**
     * Controller Bancos
     */
    $routes->get('bancos', 'Bancos::index');
    $routes->get('bancos/add', 'Bancos::add');
    $routes->get('bancos/add_modal', 'Bancos::add_modal');
    $routes->get('bancos/edit/(:num)', 'Bancos::edit/$1');
    $routes->get('bancos/show/(:num)', 'Bancos::show/$1');
    $routes->get('bancos/delete/(:num)', 'Bancos::delete/$1');
    $routes->get('bancos/undo/(:num)', 'Bancos::undo/$1');

    $routes->post('bancos/remove/(:num)', 'Bancos::remove/$1');
    $routes->post('bancos/restore/(:num)', 'Bancos::restore/$1');
    $routes->post('bancos/fetch', 'Bancos::fetch');
    $routes->post('bancos/insert', 'Bancos::insert');
    $routes->post('bancos/update', 'Bancos::update');

    /**
     * Controller ClassificacoesContas
     */
    $routes->get('classificacoescontas', 'ClassificacoesContas::index');
    $routes->get('classificacoescontas/add', 'ClassificacoesContas::add');
    $routes->get('classificacoescontas/edit/(:num)', 'ClassificacoesContas::edit/$1');
    $routes->get('classificacoescontas/show/(:num)', 'ClassificacoesContas::show/$1');
    $routes->get('classificacoescontas/delete/(:num)', 'ClassificacoesContas::delete/$1');
    $routes->get('classificacoescontas/undo/(:num)', 'ClassificacoesContas::undo/$1');

    $routes->post('classificacoescontas/remove/(:num)', 'ClassificacoesContas::remove/$1');
    $routes->post('classificacoescontas/restore/(:num)', 'ClassificacoesContas::restore/$1');
    $routes->post('classificacoescontas/fetch', 'ClassificacoesContas::fetch');
    $routes->post('classificacoescontas/insert', 'ClassificacoesContas::insert');
    $routes->post('classificacoescontas/update', 'ClassificacoesContas::update');

    /**
     * Controller TiposCobrancas
     */
    $routes->get('tiposcobranca', 'TiposCobrancas::index');
    $routes->get('tiposcobranca/add', 'TiposCobrancas::add');
    $routes->get('tiposcobranca/edit/(:num)', 'TiposCobrancas::edit/$1');
    $routes->get('tiposcobranca/show/(:num)', 'TiposCobrancas::show/$1');
    $routes->get('tiposcobranca/delete/(:num)', 'TiposCobrancas::delete/$1');
    $routes->get('tiposcobranca/undo/(:num)', 'TiposCobrancas::undo/$1');

    $routes->post('tiposcobranca/remove/(:num)', 'TiposCobrancas::remove/$1');
    $routes->post('tiposcobranca/restore/(:num)', 'TiposCobrancas::restore/$1');
    $routes->post('tiposcobranca/fetch', 'TiposCobrancas::fetch');
    $routes->post('tiposcobranca/insert', 'TiposCobrancas::insert');
    $routes->post('tiposcobranca/update', 'TiposCobrancas::update');

    /**
     * Controller ContasCorrentes
     */
    $routes->get('contascorrente', 'ContasCorrentes::index');
    $routes->get('contascorrente/add', 'ContasCorrentes::add');
    $routes->get('contascorrente/edit/(:num)', 'ContasCorrentes::edit/$1');
    $routes->get('contascorrente/show/(:num)', 'ContasCorrentes::show/$1');
    $routes->get('contascorrente/delete/(:num)', 'ContasCorrentes::delete/$1');
    $routes->get('contascorrente/undo/(:num)', 'ContasCorrentes::undo/$1');

    $routes->post('contascorrente/remove/(:num)', 'ContasCorrentes::remove/$1');
    $routes->post('contascorrente/restore/(:num)', 'ContasCorrentes::restore/$1');
    $routes->post('contascorrente/fetch', 'ContasCorrentes::fetch');
    $routes->post('contascorrente/insert', 'ContasCorrentes::insert');
    $routes->post('contascorrente/update', 'ContasCorrentes::update');

    /**
     * Controller ContasPagar
     */
    $routes->get('contaspagar', 'ContasPagar::index');
    $routes->get('contaspagar/add', 'ContasPagar::create');
    $routes->get('contaspagar/edit/(:num)', 'ContasPagar::edit/$1');
    $routes->get('contaspagar/view/(:num)', 'ContasPagar::view/$1');
    $routes->get('contaspagar/payable/(:num)', 'ContasPagar::payable/$1');
    $routes->get('contaspagar/attach/(:num)', 'ContasPagar::attach/$1');

    $routes->post('contaspagar/remove/(:num)', 'ContasPagar::remove/$1');
    $routes->post('contaspagar/fetch', 'ContasPagar::datatables');
    $routes->post('contaspagar/store', 'ContasPagar::store');
    $routes->post('contaspagar/update', 'ContasPagar::update');
    $routes->post('contaspagar/delete', 'ContasPagar::delete');
    $routes->post('contaspagar/paybill', 'ContasPagar::paybill');

    /**
     * Controller ContasReceber
     */
    $routes->get('contasreceber', 'ContasReceber::index');
    $routes->get('contasreceber/add', 'ContasReceber::create');
    $routes->get('contasreceber/edit/(:num)', 'ContasReceber::edit/$1');
    $routes->get('contasreceber/view/(:num)', 'ContasReceber::view/$1');
    $routes->get('contasreceber/receivable/(:num)', 'ContasReceber::receivable/$1');
    $routes->get('contasreceber/attach/(:num)', 'ContasReceber::attach/$1');

    $routes->post('contasreceber/remove/(:num)', 'ContasReceber::remove/$1');
    $routes->post('contasreceber/fetch', 'ContasReceber::datatables');
    $routes->post('contasreceber/store', 'ContasReceber::store');
    $routes->post('contasreceber/update', 'ContasReceber::update');
    $routes->post('contasreceber/delete', 'ContasReceber::delete');
    $routes->post('contasreceber/receive', 'ContasReceber::receive');
});

/****************************************************************************************************
 *  Fiscal
 ****************************************************************************************************/
$routes->group('fiscal', function ($routes) {
    /**
     * Controller CFOPs
     */
    $routes->get('cfops', 'CFOPs::index');
    $routes->get('cfops/add', 'CFOPs::add');
    $routes->get('cfops/edit/(:num)', 'CFOPs::edit/$1');
    $routes->get('cfops/show/(:num)', 'CFOPs::show/$1');
    $routes->get('cfops/delete/(:num)', 'CFOPs::delete/$1');
    $routes->get('cfops/undo/(:num)', 'CFOPs::undo/$1');

    $routes->post('cfops/remove/(:num)', 'CFOPs::remove/$1');
    $routes->post('cfops/restore/(:num)', 'CFOPs::restore/$1');
    $routes->post('cfops/fetch', 'CFOPs::fetch');
    $routes->post('cfops/insert', 'CFOPs::insert');
    $routes->post('cfops/update', 'CFOPs::update');

    /**
     * Controller SituacoesTributarias
     */
    $routes->get('csts', 'SituacoesTributarias::index');
    $routes->get('csts/add', 'SituacoesTributarias::add');
    $routes->get('csts/edit/(:num)', 'SituacoesTributarias::edit/$1');
    $routes->get('csts/show/(:num)', 'SituacoesTributarias::show/$1');
    $routes->get('csts/delete/(:num)', 'SituacoesTributarias::delete/$1');
    $routes->get('csts/undo/(:num)', 'SituacoesTributarias::undo/$1');

    $routes->post('csts/remove/(:num)', 'SituacoesTributarias::remove/$1');
    $routes->post('csts/restore/(:num)', 'SituacoesTributarias::restore/$1');
    $routes->post('csts/fetch', 'SituacoesTributarias::fetch');
    $routes->post('csts/insert', 'SituacoesTributarias::insert');
    $routes->post('csts/update', 'SituacoesTributarias::update');

    /**
     * Controller GruposTributarios
     */
    $routes->get('grupostributarios', 'GruposTributarios::index');
    $routes->get('grupostributarios/add', 'GruposTributarios::add');
    $routes->get('grupostributarios/edit/(:num)', 'GruposTributarios::edit/$1');
    $routes->get('grupostributarios/show/(:num)', 'GruposTributarios::show/$1');
    $routes->get('grupostributarios/delete/(:num)', 'GruposTributarios::delete/$1');
    $routes->get('grupostributarios/undo/(:num)', 'GruposTributarios::undo/$1');

    $routes->post('grupostributarios/remove/(:num)', 'GruposTributarios::remove/$1');
    $routes->post('grupostributarios/restore/(:num)', 'GruposTributarios::restore/$1');
    $routes->post('grupostributarios/fetch', 'GruposTributarios::fetch');
    $routes->post('grupostributarios/insert', 'GruposTributarios::insert');
    $routes->post('grupostributarios/update', 'GruposTributarios::update');
});

/****************************************************************************************************
 *  CRM
 ****************************************************************************************************/
$routes->group('crm', function ($routes) {
    /**
     * Controller Segmentos
     */
    $routes->get('segmentos', 'Segmentos::index');
    $routes->get('segmentos/add', 'Segmentos::add');
    $routes->get('segmentos/add_modal', 'Segmentos::add_modal');
    $routes->get('segmentos/edit/(:num)', 'Segmentos::edit/$1');
    $routes->get('segmentos/show/(:num)', 'Segmentos::show/$1');
    $routes->get('segmentos/delete/(:num)', 'Segmentos::delete/$1');
    $routes->get('segmentos/undo/(:num)', 'Segmentos::undo/$1');

    $routes->post('segmentos/remove/(:num)', 'Segmentos::remove/$1');
    $routes->post('segmentos/restore/(:num)', 'Segmentos::restore/$1');
    $routes->post('segmentos/fetch', 'Segmentos::fetch');
    $routes->post('segmentos/insert', 'Segmentos::insert');
    $routes->post('segmentos/update', 'Segmentos::update');

    /**
     * Controller Cargos
     */
    $routes->get('cargos', 'Cargos::index');
    $routes->get('cargos/add', 'Cargos::add');
    $routes->get('cargos/add_modal', 'Cargos::add_modal');
    $routes->get('cargos/edit/(:num)', 'Cargos::edit/$1');
    $routes->get('cargos/show/(:num)', 'Cargos::show/$1');
    $routes->get('cargos/delete/(:num)', 'Cargos::delete/$1');
    $routes->get('cargos/undo/(:num)', 'Cargos::undo/$1');

    $routes->post('cargos/remove/(:num)', 'Cargos::remove/$1');
    $routes->post('cargos/restore/(:num)', 'Cargos::restore/$1');
    $routes->post('cargos/fetch', 'Cargos::fetch');
    $routes->post('cargos/insert', 'Cargos::insert');
    $routes->post('cargos/update', 'Cargos::update');

    /**
     * Controller Contatos
     */
    $routes->get('contatos', 'Contatos::index');
    $routes->get('contatos/add', 'Contatos::add');
    $routes->get('contatos/add_modal', 'Contatos::add_modal');
    $routes->get('contatos/edit/(:num)', 'Contatos::edit/$1');
    $routes->get('contatos/show/(:num)', 'Contatos::show/$1');
    $routes->get('contatos/delete/(:num)', 'Contatos::delete/$1');
    $routes->get('contatos/undo/(:num)', 'Contatos::undo/$1');

    $routes->post('contatos/remove/(:num)', 'Contatos::remove/$1');
    $routes->post('contatos/restore/(:num)', 'Contatos::restore/$1');
    $routes->post('contatos/fetch', 'Contatos::fetch');
    $routes->post('contatos/insert', 'Contatos::insert');
    $routes->post('contatos/update', 'Contatos::update');

    /**
     * Controller FunilVendas
     */
    $routes->get('funil', 'FunilVendas::index');
    $routes->get('funil/add', 'FunilVendas::add');
    $routes->get('funil/add_modal', 'FunilVendas::add_modal');
    $routes->get('funil/edit/(:num)', 'FunilVendas::edit/$1');
    $routes->get('funil/show/(:num)', 'FunilVendas::show/$1');
    $routes->get('funil/delete/(:num)', 'FunilVendas::delete/$1');
    $routes->get('funil/undo/(:num)', 'FunilVendas::undo/$1');
    $routes->get('funil/etapas/(:num)', 'FunilVendas::etapas/$1');

    $routes->post('funil/remove/(:num)', 'FunilVendas::remove/$1');
    $routes->post('funil/restore/(:num)', 'FunilVendas::restore/$1');
    $routes->post('funil/fetch', 'FunilVendas::fetch');
    $routes->post('funil/insert', 'FunilVendas::insert');
    $routes->post('funil/update', 'FunilVendas::update');
    $routes->post('funil/etapas_save', 'FunilVendas::etapas_save');
    $routes->post('funil/etapas_fetch/(:num)', 'FunilVendas::etapas_fetch/$1');
});

