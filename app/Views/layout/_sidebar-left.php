            <aside id="sidebar-left" class="sidebar-left">
                <div class="sidebar-header">
                    <div class="sidebar-title">
                        Menu Principal
                    </div>
                    <div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
                        <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
                    </div>
                </div>
                <div class="nano">
                    <div class="nano-content">
                        <nav id="menu" class="nav-main" role="navigation">
                            <ul class="nav nav-main">
                                <li class="<?= (url_is('/') || url_is('home*') ? 'nav-expanded nav-active' : ''); ?>">
                                    <?php
                                    if (userIsLogged()->is_customer) {
                                        $home = site_url('/customer');
                                    } else if (userIsLogged()->is_vendor) {
                                        $home = site_url('/vendor');
                                    } else {
                                        $home = site_url('/home');
                                    }
                                    ?>
                                    <a href="<?= $home; ?>">
                                        <i class="fa fa-home" aria-hidden="true"></i>
                                        <span>Home</span>
                                    </a>
                                </li>

                                <!-- Cadastros - Início -->
                                <li class="nav-parent <?= (url_is('empresas*') || url_is('clientes*') || url_is('vendedores*') || url_is('fornecedores*') || url_is('transportadoras*') ? 'nav-expanded nav-active' : ''); ?>">
                                    <a>
                                        <i class="fa fa-database" aria-hidden="true"></i>
                                        <span>Cadastros</span>
                                    </a>
                                    <ul class="nav nav-children">
                                        <?php if ((userIsLogged()->id == 1) || (userIsLogged()->id == 2)) { ?>
                                            <li class="<?= (url_is('empresas*') ? 'nav-active' : ''); ?>">
                                                <a href="<?= site_url('/empresas'); ?>">
                                                    <i class="fas fa-store" aria-hidden="true"></i>
                                                    <span>Empresas</span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-clientes'))) { ?>
                                            <li class="<?= (url_is('clientes*') ? 'nav-active' : ''); ?>">
                                                <a href="<?= site_url('/clientes'); ?>">
                                                    <i class="fa fa-users" aria-hidden="true"></i>
                                                    <span>Clientes</span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-vendedores'))) { ?>
                                            <li class="<?= (url_is('vendedores*') ? 'nav-active' : ''); ?>">
                                                <a href="<?= site_url('/vendedores'); ?>">
                                                    <i class="fas fa-user-tie" aria-hidden="true"></i>
                                                    <span>Vendedores</span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-fornecedores'))) { ?>
                                            <li class="<?= (url_is('fornecedores*') ? 'nav-active' : ''); ?>">
                                                <a href="<?= site_url('/fornecedores'); ?>">
                                                    <i class="fa fa-building" aria-hidden="true"></i>
                                                    <span>Fornecedores</span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-transportadoras'))) { ?>
                                            <li class="<?= (url_is('transportadoras*') ? 'nav-active' : ''); ?>">
                                                <a href="<?= site_url('/transportadoras'); ?>">
                                                    <i class="fas fa-truck" aria-hidden="true"></i>
                                                    <span>Transportadoras</span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </li>
                                <!-- Cadastros - Final -->

                                <!-- Estoque - Início -->
                                <li class="nav-parent <?= (url_is('estoque/produtos*') || url_is('estoque/depositos*') || url_is('estoque/grupos*') || url_is('estoque/marcas*') || url_is('estoque/modelos*') || url_is('estoque/secoes*') || url_is('estoque/unidades*') || url_is('estoque/tiposproduto*') || url_is('estoque/tabelasprecos*') || url_is('estoque/tiposmovimento*') || url_is('estoque/ajustes*') || url_is('estoque/transferencias*') || url_is('estoque/compras*') ? 'nav-expanded nav-active' : ''); ?>">
                                    <a>
                                        <i class="fa fa-cubes" aria-hidden="true"></i>
                                        <span>Estoque</span>
                                    </a>
                                    <ul class="nav nav-children">
                                        <li class="nav-parent">
                                            <a>Cadastros</a>
                                            <ul class="nav nav-children">
                                                <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-produtos'))) { ?>
                                                    <li class="<?= (url_is('estoque/produtos*') ? 'nav-active' : ''); ?>">
                                                        <a href="<?= site_url('/estoque/produtos'); ?>">
                                                            <i class="fa fa-cubes" aria-hidden="true"></i>
                                                            <span>Produtos</span>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                                <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-depositos'))) { ?>
                                                    <li class="<?= (url_is('estoque/depositos*') ? 'nav-active' : ''); ?>">
                                                        <a href="<?= site_url('/estoque/depositos'); ?>">
                                                            <i class="fas fa-warehouse" aria-hidden="true"></i>
                                                            <span>Depósitos</span>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                                <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-marcas'))) { ?>
                                                    <li class="<?= (url_is('estoque/marcas*') ? 'nav-active' : ''); ?>">
                                                        <a href="<?= site_url('/estoque/marcas'); ?>">
                                                            <i class="fa fa-tag" aria-hidden="true"></i>
                                                            <span>Marcas</span>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                                <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-modelos'))) { ?>
                                                    <li class="<?= (url_is('estoque/modelos*') ? 'nav-active' : ''); ?>">
                                                        <a href="<?= site_url('/estoque/modelos'); ?>">
                                                            <i class="fas fa-flag" aria-hidden="true"></i>
                                                            <span>Modelos</span>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                                <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-secoes'))) { ?>
                                                    <li class="<?= (url_is('estoque/secoes*') ? 'nav-active' : ''); ?>">
                                                        <a href="<?= site_url('/estoque/secoes'); ?>">
                                                            <i class="fa fa-th" aria-hidden="true"></i>
                                                            <span>Seções</span>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                                <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-gruposprodutos'))) { ?>
                                                    <li class="<?= (url_is('estoque/grupos*') ? 'nav-active' : ''); ?>">
                                                        <a href="<?= site_url('/estoque/grupos'); ?>">
                                                            <i class="fa fa-th-large" aria-hidden="true"></i>
                                                            <span>Grupos</span>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                                <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-unidades'))) { ?>
                                                    <li class="<?= (url_is('estoque/unidades*') ? 'nav-active' : ''); ?>">
                                                        <a href="<?= site_url('/estoque/unidades'); ?>">
                                                            <i class="fa fa-cube" aria-hidden="true"></i>
                                                            <span>Unidades</span>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                                <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-tiposproduto'))) { ?>
                                                    <li class="<?= (url_is('estoque/tiposproduto*') ? 'nav-active' : ''); ?>">
                                                        <a href="<?= site_url('/estoque/tiposproduto'); ?>">
                                                            <i class="fas fa-tv" aria-hidden="true"></i>
                                                            <span>Tipos de Produto</span>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                                <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-tabelaspreco'))) { ?>
                                                    <li class="<?= (url_is('estoque/tabelasprecos*') ? 'nav-active' : ''); ?>">
                                                        <a href="<?= site_url('/estoque/tabelasprecos'); ?>">
                                                            <i class="fas fa-dollar-sign" aria-hidden="true"></i>
                                                            <span>Tabelas de Preços</span>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                                <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-tiposmovimento'))) { ?>
                                                    <li class="<?= (url_is('estoque/tiposmovimento*') ? 'nav-active' : ''); ?>">
                                                        <a href="<?= site_url('/estoque/tiposmovimento'); ?>">
                                                            <i class="fas fa-dolly" aria-hidden="true"></i>
                                                            <span>Tipos de Movimento</span>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </li>
                                        <li class="nav-parent">
                                            <a>Movimentos</a>
                                            <ul class="nav nav-children">
                                                <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-compras'))) { ?>
                                                    <li class="<?= (url_is('estoque/compras*') ? 'nav-active' : ''); ?>">
                                                        <a href="<?= site_url('/estoque/compras'); ?>">
                                                            <i class="fas fa-store" aria-hidden="true"></i>
                                                            <span>Compras</span>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                                <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-ajustes'))) { ?>
                                                    <li class="<?= (url_is('estoque/ajustes*') ? 'nav-active' : ''); ?>">
                                                        <a href="<?= site_url('/estoque/ajustes'); ?>">
                                                            <i class="fas fa-pallet" aria-hidden="true"></i>
                                                            <span>Ajustes</span>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                                <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-transferencias'))) { ?>
                                                    <li class="<?= (url_is('estoque/transferencias*') ? 'nav-active' : ''); ?>">
                                                        <a href="<?= site_url('/estoque/transferencias'); ?>">
                                                            <i class="fa fa-exchange-alt" aria-hidden="true"></i>
                                                            <span>Transferências</span>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <!-- Estoque - Final -->

                                <!-- Faturamento - Início -->
                                <li class="nav-parent <?= (url_is('faturamento/orcamentos*') || url_is('faturamento/pedidos*') ? 'nav-expanded nav-active' : ''); ?>">
                                    <a>
                                        <i class="fas fa-shopping-cart" aria-hidden="true"></i>
                                        <span>Faturamento</span>
                                    </a>
                                    <ul class="nav nav-children">
                                        <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-orcamentos'))) { ?>
                                            <li class="<?= (url_is('faturamento/orcamentos*') ? 'nav-active' : ''); ?>">
                                                <a href="<?= site_url('/faturamento/orcamentos'); ?>">
                                                    <i class="fas fa-file-alt" aria-hidden="true"></i>
                                                    <span>Orçamentos</span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-pedidos'))) { ?>
                                            <li class="<?= (url_is('faturamento/pedidos*') ? 'nav-active' : ''); ?>">
                                                <a href="<?= site_url('/faturamento/pedidos'); ?>">
                                                    <i class="fas fa-file-powerpoint" aria-hidden="true"></i>
                                                    <span>Pedidos</span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </li>
                                <!-- Faturamento - Final -->

                                <!-- Financeiro - Início -->
                                <li class="nav-parent <?= (url_is('financeiro/condicoespgto*') || url_is('financeiro/formaspgto*') || url_is('financeiro/classificacoescontas*') || url_is('financeiro/tiposcobranca*') || url_is('financeiro/bancos*') || url_is('financeiro/contascorrente*') ? 'nav-expanded nav-active' : ''); ?>">
                                    <a>
                                        <i class="fa fa-money" aria-hidden="true"></i>
                                        <span>Financeiro</span>
                                    </a>
                                    <ul class="nav nav-children">
                                        <li class="nav-parent">
                                            <a>Cadastros</a>
                                            <ul class="nav nav-children">
                                                <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-condicoespgto'))) { ?>
                                                    <li class="<?= (url_is('financeiro/condicoespgto*') ? 'nav-active' : ''); ?>">
                                                        <a href="<?= site_url('/financeiro/condicoespgto'); ?>">
                                                            <i class="fa fa-calendar" aria-hidden="true"></i>
                                                            <span>Condições de Pagamento</span>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                                <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-formaspgto'))) { ?>
                                                    <li class="<?= (url_is('financeiro/formaspgto*') ? 'nav-active' : ''); ?>">
                                                        <a href="<?= site_url('/financeiro/formaspgto'); ?>">
                                                            <i class="fa fa-credit-card" aria-hidden="true"></i>
                                                            <span>Formas de Pagamento</span>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                                <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-classificacoescontas'))) { ?>
                                                    <li class="<?= (url_is('financeiro/classificacoescontas*') ? 'nav-active' : ''); ?>">
                                                        <a href="<?= site_url('/financeiro/classificacoescontas'); ?>">
                                                            <i class="fa fa-bars" aria-hidden="true"></i>
                                                            <span>Classificações de Contas</span>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                                <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-tiposcobranca'))) { ?>
                                                    <li class="<?= (url_is('financeiro/tiposcobranca*') ? 'nav-active' : ''); ?>">
                                                        <a href="<?= site_url('/financeiro/tiposcobranca'); ?>">
                                                            <i class="fab fa-apple-pay" aria-hidden="true"></i>
                                                            <span>Tipos de Cobrança</span>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                                <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-bancos'))) { ?>
                                                    <li class="<?= (url_is('financeiro/bancos*') ? 'nav-active' : ''); ?>">
                                                        <a href="<?= site_url('/financeiro/bancos'); ?>">
                                                            <i class="fa fa-bank" aria-hidden="true"></i>
                                                            <span>Bancos</span>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                                <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-contascorrente'))) { ?>
                                                    <li class="<?= (url_is('financeiro/contascorrente*') ? 'nav-active' : ''); ?>">
                                                        <a href="<?= site_url('/financeiro/contascorrente'); ?>">
                                                            <i class="fas fa-money-check" aria-hidden="true"></i>
                                                            <span>Contas Corrente</span>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </li>
                                        <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-contaspagar'))) { ?>
                                            <li>
                                                <a href="<?= site_url('/financeiro/contaspagar'); ?>">
                                                    <i class="fas fa-money-check-alt"></i>
                                                    <span>Contas a Pagar</span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-contasreceber'))) { ?>
                                            <li>
                                                <a href="<?= site_url('/financeiro/contasreceber'); ?>">
                                                    <i class="fas fa-money-bill"></i>
                                                    <span>Contas a Receber</span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </li>
                                <!-- Financeiro - Final -->

                                <!-- Fiscal - Início -->
                                <li class="nav-parent <?= (url_is('fiscal/cfops*') || url_is('fiscal/grupostributarios*') || url_is('fiscal/csts*') ? 'nav-expanded nav-active' : ''); ?>">
                                    <a>
                                        <i class="fas fa-file-signature" aria-hidden="true"></i>
                                        <span>Fiscal</span>
                                    </a>
                                    <ul class="nav nav-children">
                                        <li class="nav-parent">
                                            <a>Cadastros</a>
                                            <ul class="nav nav-children">
                                                <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-cfops'))) { ?>
                                                    <li class="<?= (url_is('fiscal/cfops*') ? 'nav-active' : ''); ?>">
                                                        <a href="<?= site_url('/fiscal/cfops'); ?>">
                                                            <i class="fas fa-file-alt" aria-hidden="true"></i>
                                                            <span>CFOP's</span>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                                <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-csts'))) { ?>
                                                    <li class="<?= (url_is('fiscal/csts*') ? 'nav-active' : ''); ?>">
                                                        <a href="<?= site_url('/fiscal/csts'); ?>">
                                                            <i class="fas fa-clone" aria-hidden="true"></i>
                                                            <span>CST / CSOSN</span>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                                <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-grupostributarios'))) { ?>
                                                    <li class="<?= (url_is('fiscal/grupostributarios*') ? 'nav-active' : ''); ?>">
                                                        <a href="<?= site_url('/fiscal/grupostributarios'); ?>">
                                                            <i class="fas fa-file" aria-hidden="true"></i>
                                                            <span>Grupos Tributários</span>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </li>
                                        <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-nfe'))) { ?>
                                            <li class="<?= (url_is('fiscal/nfe*') ? 'nav-active' : ''); ?>">
                                                <a href="<?= site_url('/fiscal/nfe'); ?>">
                                                    <i class="fas fa-file-alt" aria-hidden="true"></i>
                                                    <span>NF-e</span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </li>
                                <!-- Fiscal - Final -->

                                <!-- CRM - Início -->
                                <li class="nav-parent <?= (url_is('crm/segmentos*') || url_is('crm/cargos*') || url_is('crm/funil*') || url_is('crm/contatos*') || url_is('crm/negociacoes*') || url_is('crm/tarefas*') ? 'nav-expanded nav-active' : ''); ?>">
                                    <a>
                                        <i class="fas fa-address-card" aria-hidden="true"></i>
                                        <span>CRM</span>
                                    </a>
                                    <ul class="nav nav-children">
                                        <li class="nav-parent">
                                            <a>Cadastros</a>
                                            <ul class="nav nav-children">
                                                <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-segmentos'))) { ?>
                                                    <li class="<?= (url_is('crm/segmentos*') ? 'nav-active' : ''); ?>">
                                                        <a href="<?= site_url('/crm/segmentos'); ?>">
                                                            <i class="fas fa-stamp" aria-hidden="true"></i>
                                                            <span>Segmentos</span>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                                <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-cargos'))) { ?>
                                                    <li class="<?= (url_is('crm/cargos*') ? 'nav-active' : ''); ?>">
                                                        <a href="<?= site_url('/crm/cargos'); ?>">
                                                            <i class="fas fa-user-graduate" aria-hidden="true"></i>
                                                            <span>Cargos</span>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                                <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-funil'))) { ?>
                                                    <li class="<?= (url_is('crm/funil*') ? 'nav-active' : ''); ?>">
                                                        <a href="<?= site_url('/crm/funil'); ?>">
                                                            <i class="fas fa-filter" aria-hidden="true"></i>
                                                            <span>Funil de Vendas</span>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </li>
                                        <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-contatos'))) { ?>
                                            <li class="<?= (url_is('crm/contatos*') ? 'nav-active' : ''); ?>">
                                                <a href="<?= site_url('/crm/contatos'); ?>">
                                                    <i class="fas fa-user-tie" aria-hidden="true"></i>
                                                    <span>Contatos</span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-negociacoes'))) { ?>
                                            <li class="<?= (url_is('crm/negociacoes*') ? 'nav-active' : ''); ?>">
                                                <a href="<?= site_url('/crm/negociacoes'); ?>">
                                                    <i class="fas fa-business-time" aria-hidden="true"></i>
                                                    <span>Negociações</span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                        <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-tarefas'))) { ?>
                                            <li class="<?= (url_is('crm/tarefas*') ? 'nav-active' : ''); ?>">
                                                <a href="<?= site_url('/crm/tarefas'); ?>">
                                                    <i class="fas fa-tasks" aria-hidden="true"></i>
                                                    <span>Tarefas</span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </li>
                                <!-- CRM - Final -->

                                <!-- Acessos - Início -->
                                <?php if (userIsLogged()->is_admin) { ?>
                                    <li class="nav-parent <?= (url_is('usuarios*') || url_is('grupos*') || url_is('permissoes*') ? 'nav-expanded nav-active' : ''); ?>">
                                        <a>
                                            <i class="fa fa-bars" aria-hidden="true"></i>
                                            <span>Acessos</span>
                                        </a>
                                        <ul class="nav nav-children">
                                            <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-usuarios'))) { ?>
                                                <li class="<?= (url_is('usuarios*') ? 'nav-active' : ''); ?>">
                                                    <a href="<?= site_url('/usuarios'); ?>">
                                                        <i class="fa fa-user" aria-hidden="true"></i>
                                                        <span>Usuários</span>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                            <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-grupos'))) { ?>
                                                <li class="<?= (url_is('grupos*') ? 'nav-active' : ''); ?>">
                                                    <a href="<?= site_url('/grupos'); ?>">
                                                        <i class="fa fa-users" aria-hidden="true"></i>
                                                        <span>Grupos</span>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                            <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-permissoes'))) { ?>
                                                <li class="<?= (url_is('permissoes*') ? 'nav-active' : ''); ?>">
                                                    <a href="<?= site_url('/permissoes'); ?>">
                                                        <i class="fas fa-check-double" aria-hidden="true"></i>
                                                        <span>Permissões</span>
                                                    </a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                <?php } ?>
                                <!-- Acessos - Final -->
                            </ul>
                        </nav>
                    </div>
                </div>
            </aside>