                    <div class="sidebar-nav scrollbar scroll_light">
                        <ul class="metismenu " id="sidebarNav">
                            <li class="nav-static-title">MENU</li>
                            <?php
                            if (userIsLogged()->is_customer) {
                                $home = site_url('/customer');
                            } elseif (userIsLogged()->is_vendor) {
                                $home = site_url('/vendor');
                            } else {
                                $home = site_url('/home');
                            }
                            ?>
                            <li class="<?php echo url_is('/') || url_is('home*') ? 'active' : ''; ?>">
                                <a href="<?php echo $home; ?>" aria-expanded="false">
                                    <i class="nav-icon ti ti-home"></i>
                                    <span class="nav-title">Home</span>
                                </a>
                            </li>

                            <!-- Cadastros - Início -->
                            <li class="<?php echo url_is('empresas*') || url_is('clientes*') || url_is('vendedores*') || url_is('fornecedores*') || url_is('transportadoras*') ? 'active' : ''; ?>">
                                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                                    <i class="nav-icon ti ti-harddrives"></i>
                                    <span class="nav-title">Cadastros</span>
                                </a>
                                <ul aria-expanded="false">
                                    <?php if (userIsLogged()->id == 1) { ?>
                                        <li class="<?php echo url_is('empresas*') ? 'active' : ''; ?>">
                                            <a href="<?php echo site_url('/empresas'); ?>">Empresas</a>
                                        </li>
                                    <?php } ?>
                                    <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-clientes'))) { ?>
                                        <li class="<?php echo url_is('clientes*') ? 'active' : ''; ?>">
                                            <a href="<?php echo site_url('/clientes'); ?>">Clientes</a>
                                        </li>
                                    <?php } ?>
                                    <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-vendedores'))) { ?>
                                        <li class="<?php echo url_is('vendedores*') ? 'active' : ''; ?>">
                                            <a href="<?php echo site_url('/vendedores'); ?>">Vendedores</a>
                                        </li>
                                    <?php } ?>
                                    <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-fornecedores'))) { ?>
                                        <li class="<?php echo url_is('fornecedores*') ? 'active' : ''; ?>">
                                            <a href="<?php echo site_url('/fornecedores'); ?>">Fornecedores</a>
                                        </li>
                                    <?php } ?>
                                    <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-transportadoras'))) { ?>
                                        <li class="<?php echo url_is('transportadoras*') ? 'active' : ''; ?>">
                                            <a href="<?php echo site_url('/transportadoras'); ?>">Transportadoras</a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <!-- Cadastros - Final -->

                            <!-- Acessos - Início -->
                            <?php if (userIsLogged()->is_admin) { ?>
                                <li class="<?php echo url_is('usuarios*') || url_is('grupos*') || url_is('permissoes*') ? 'active' : ''; ?>">
                                    <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                                        <i class="nav-icon ti ti-lock"></i>
                                        <span class="nav-title">Acessos</span>
                                    </a>
                                    <ul aria-expanded="false">
                                        <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-usuarios'))) { ?>
                                            <li class="<?php echo url_is('usuarios*') ? 'active' : ''; ?>">
                                                <a href="<?php echo site_url('/usuarios'); ?>">Usuários</a>
                                            </li>
                                        <?php } ?>
                                        <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-grupos'))) { ?>
                                            <li class="<?php echo url_is('grupos*') ? 'active' : ''; ?>">
                                                <a href="<?php echo site_url('/grupos'); ?>">Grupos</a>
                                            </li>
                                        <?php } ?>
                                        <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-permissoes'))) { ?>
                                            <li class="<?php echo url_is('permissoes*') ? 'active' : ''; ?>">
                                                <a href="<?php echo site_url('/permissoes'); ?>">Permissões</a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </li>
                            <?php } ?>
                            <!-- Acessos - Final -->

                            <!-- Estoque - Início -->
                            <li class="<?php echo url_is('estoque/produtos*') || url_is('estoque/depositos*') || url_is('estoque/grupos*') || url_is('estoque/marcas*') || url_is('estoque/modelos*') || url_is('estoque/secoes*') || url_is('estoque/unidades*') || url_is('estoque/tiposproduto*') || url_is('estoque/tabelasprecos*') || url_is('estoque/tiposmovimento*') || url_is('estoque/ajustes*') || url_is('estoque/transferencias*') || url_is('estoque/compras*') ? 'active' : ''; ?>">
                                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                                    <i class="nav-icon ti ti-package"></i><span class="nav-title">Estoque</span>
                                </a>
                                <ul aria-expanded="false">
                                    <li class="scoop-hasmenu <?php echo url_is('estoque/produtos*') || url_is('estoque/depositos*') || url_is('estoque/grupos*') || url_is('estoque/marcas*') || url_is('estoque/modelos*') || url_is('estoque/secoes*') || url_is('estoque/unidades*') || url_is('estoque/tiposproduto*') || url_is('estoque/tabelasprecos*') || url_is('estoque/tiposmovimento*') ? 'active' : ''; ?>">
                                        <a class="has-arrow" href="javascript: void(0);">Cadastros</a>
                                        <ul aria-expanded="false">
                                            <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-produtos'))) { ?>
                                                <li class="<?php echo url_is('estoque/produtos*') ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('/estoque/produtos'); ?>">Produtos</a>
                                                </li>
                                            <?php } ?>
                                            <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-depositos'))) { ?>
                                                <li class="<?php echo url_is('estoque/depositos*') ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('/estoque/depositos'); ?>">Depósitos</a>
                                                </li>
                                            <?php } ?>
                                            <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-marcas'))) { ?>
                                                <li class="<?php echo url_is('estoque/marcas*') ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('/estoque/marcas'); ?>">Marcas</a>
                                                </li>
                                            <?php } ?>
                                            <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-modelos'))) { ?>
                                                <li class="<?php echo url_is('estoque/modelos*') ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('/estoque/modelos'); ?>">Modelos</a>
                                                </li>
                                            <?php } ?>
                                            <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-secoes'))) { ?>
                                                <li class="<?php echo url_is('estoque/secoes*') ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('/estoque/secoes'); ?>">Seções</a>
                                                </li>
                                            <?php } ?>
                                            <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-gruposprodutos'))) { ?>
                                                <li class="<?php echo url_is('estoque/grupos*') ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('/estoque/grupos'); ?>">Grupos</a>
                                                </li>
                                            <?php } ?>
                                            <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-unidades'))) { ?>
                                                <li class="<?php echo url_is('estoque/unidades*') ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('/estoque/unidades'); ?>">Unidades</a>
                                                </li>
                                            <?php } ?>
                                            <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-tiposproduto'))) { ?>
                                                <li class="<?php echo url_is('estoque/tiposproduto*') ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('/estoque/tiposproduto'); ?>">Tipos de Produto</a>
                                                </li>
                                            <?php } ?>
                                            <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-tabelaspreco'))) { ?>
                                                <li class="<?php echo url_is('estoque/tabelasprecos*') ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('/estoque/tabelasprecos'); ?>">Tabelas de Preços</a>
                                                </li>
                                            <?php } ?>
                                            <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-tiposmovimento'))) { ?>
                                                <li class="<?php echo url_is('estoque/tiposmovimento*') ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('/estoque/tiposmovimento'); ?>">Tipos de Movimento</a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                    <li class="scoop-hasmenu <?php echo url_is('estoque/ajustes*') || url_is('estoque/transferencias*') || url_is('estoque/compras*') ? 'active' : ''; ?>">
                                        <a class="has-arrow" href="javascript: void(0);">Movimentos</a>
                                        <ul aria-expanded="false">
                                            <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-compras'))) { ?>
                                                <li class="<?php echo url_is('estoque/compras*') ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('/estoque/compras'); ?>">Compras</a>
                                                </li>
                                            <?php } ?>
                                            <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-ajustes'))) { ?>
                                                <li class="<?php echo url_is('estoque/ajustes*') ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('/estoque/ajustes'); ?>">Ajustes</a>
                                                </li>
                                            <?php } ?>
                                            <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-transferencias'))) { ?>
                                                <li class="<?php echo url_is('estoque/transferencias*') ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('/estoque/transferencias'); ?>">Transferências</a>
                                                </li>
                                            <?php } ?>

                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <!-- Estoque - Final -->

                            <!-- Faturamento - Início -->
                            <li class="<?php echo url_is('faturamento/orcamentos*') || url_is('faturamento/pedidos*') ? 'active' : ''; ?>">
                                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                                    <i class="nav-icon ti ti-shopping-cart"></i><span class="nav-title">Faturamento</span>
                                </a>
                                <ul aria-expanded="false">
                                    <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-orcamentos'))) { ?>
                                        <li class="<?php echo url_is('orcamentos*') ? 'active' : ''; ?>">
                                            <a href="<?php echo site_url('/faturamento/orcamentos'); ?>">Orçamentos</a>
                                        </li>
                                    <?php } ?>
                                    <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-pedidos'))) { ?>
                                        <li class="<?php echo url_is('pedidos*') ? 'active' : ''; ?>">
                                            <a href="<?php echo site_url('/faturamento/pedidos'); ?>">Pedidos</a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <!-- Faturamento - Final -->

                            <!-- Financeiro - Início -->
                            <li class="<?php echo url_is('financeiro/condicoespgto*') || url_is('financeiro/formaspgto*') || url_is('financeiro/classificacoescontas*') || url_is('financeiro/tiposcobranca*') || url_is('financeiro/bancos*') || url_is('financeiro/contascorrente*') ? 'active' : ''; ?>">
                                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                                    <i class="nav-icon ti ti-money"></i><span class="nav-title">Financeiro</span>
                                </a>
                                <ul aria-expanded="false">
                                    <li class="scoop-hasmenu <?php echo url_is('financeiro/condicoespgto*') || url_is('financeiro/formaspgto*') || url_is('financeiro/classificacoescontas*') || url_is('financeiro/tiposcobranca*') || url_is('financeiro/bancos*') || url_is('financeiro/contascorrente*') ? 'active' : ''; ?>">
                                        <a class="has-arrow" href="javascript: void(0);">Cadastros</a>
                                        <ul aria-expanded="false">
                                            <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-condicoespgto'))) { ?>
                                                <li class="<?php echo url_is('financeiro/condicoespgto*') ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('/financeiro/condicoespgto'); ?>">Cond. Pagamento</a>
                                                </li>
                                            <?php } ?>
                                            <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-formaspgto'))) { ?>
                                                <li class="<?php echo url_is('financeiro/formaspgto*') ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('/financeiro/formaspgto'); ?>">Formas Pagamento</a>
                                                </li>
                                            <?php } ?>
                                            <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-classificacoescontas'))) { ?>
                                                <li class="<?php echo url_is('financeiro/classificacoescontas*') ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('/financeiro/classificacoescontas'); ?>">Classificação Contas</a>
                                                </li>
                                            <?php } ?>
                                            <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-tiposcobranca'))) { ?>
                                                <li class="<?php echo url_is('financeiro/tiposcobranca*') ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('/financeiro/tiposcobranca'); ?>">Tipos de Cobrança</a>
                                                </li>
                                            <?php } ?>
                                            <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-bancos'))) { ?>
                                                <li class="<?php echo url_is('financeiro/bancos*') ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('/financeiro/bancos'); ?>">Bancos</a>
                                                </li>
                                            <?php } ?>
                                            <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-contascorrente'))) { ?>
                                                <li class="<?php echo url_is('financeiro/contascorrente*') ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('/financeiro/contascorrente'); ?>">Contas Corrente</a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                    <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-contaspagar'))) { ?>
                                        <li class="<?php echo url_is('financeiro/contaspagar*') ? 'active' : ''; ?>">
                                            <a href="<?php echo site_url('/financeiro/contaspagar'); ?>">Contas a Pagar</a>
                                        </li>
                                    <?php } ?>
                                    <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-contasreceber'))) { ?>
                                        <li class="<?php echo url_is('financeiro/contasreceber*') ? 'active' : ''; ?>">
                                            <a href="<?php echo site_url('/financeiro/contasreceber'); ?>">Contas a Receber</a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <!-- Financeiro - Final -->

                            <!-- Fiscal - Início -->
                            <li class="<?php echo url_is('fiscal/cfops*') || url_is('fiscal/grupostributarios*') || url_is('fiscal/csts*') ? 'nav-expanded active' : ''; ?>">
                                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                                    <i class="nav-icon ti ti-harddrives"></i><span class="nav-title">Fiscal</span>
                                </a>
                                <ul aria-expanded="false">
                                    <li class="scoop-hasmenu">
                                        <a class="has-arrow" href="javascript: void(0);">Cadastros</a>
                                        <ul aria-expanded="false">
                                            <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-cfops'))) { ?>
                                                <li class="<?php echo url_is('fiscal/cfops*') ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('/fiscal/cfops'); ?>">CFOP's</a>
                                                </li>
                                            <?php } ?>
                                            <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-csts'))) { ?>
                                                <li class="<?php echo url_is('fiscal/csts*') ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('/fiscal/csts'); ?>">CST / CSOSN</a>
                                                </li>
                                            <?php } ?>
                                            <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-grupostributarios'))) { ?>
                                                <li class="<?php echo url_is('fiscal/grupostributarios*') ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('/fiscal/grupostributarios'); ?>">Grupos Tributários</a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                    <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-nfe'))) { ?>
                                        <li class="<?php echo url_is('fiscal/nfe*') ? 'active' : ''; ?>">
                                            <a href="<?php echo site_url('/fiscal/nfe'); ?>">NF-e</a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <!-- Fiscal - Final -->

                            <!-- CRM - Início -->
                            <li class="<?php echo url_is('crm/segmentos*') || url_is('crm/cargos*') || url_is('crm/funil*') || url_is('crm/contatos*') || url_is('crm/negociacoes*') || url_is('crm/tarefas*') ? 'nav-expanded active' : ''; ?>">
                                <a class="has-arrow" href="javascript:void(0)" aria-expanded="false">
                                    <i class="nav-icon ti ti-agenda"></i><span class="nav-title">CRM</span>
                                </a>
                                <ul aria-expanded="false">
                                    <li class="scoop-hasmenu <?php echo url_is('crm/segmentos*') || url_is('crm/cargos*') || url_is('crm/funil*') ? 'nav-expanded active' : ''; ?>">
                                        <a class="has-arrow" href="javascript: void(0);">Cadastros</a>
                                        <ul aria-expanded="false">
                                            <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-segmentos'))) { ?>
                                                <li class="<?php echo url_is('crm/segmentos*') ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('/crm/segmentos'); ?>">Segmentos</a>
                                                </li>
                                            <?php } ?>
                                            <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-cargos'))) { ?>
                                                <li class="<?php echo url_is('crm/cargos*') ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('/crm/cargos'); ?>">Cargos</a>
                                                </li>
                                            <?php } ?>
                                            <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-funil'))) { ?>
                                                <li class="<?php echo url_is('crm/funil*') ? 'active' : ''; ?>">
                                                    <a href="<?php echo site_url('/crm/funil'); ?>">Funil de Vendas</a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </li>
                                    <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-contatos'))) { ?>
                                        <li class="<?php echo url_is('crm/contatos*') ? 'active' : ''; ?>">
                                            <a href="<?php echo site_url('/crm/contatos'); ?>">Contatos</a>
                                        </li>
                                    <?php } ?>
                                    <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-negociacoes'))) { ?>
                                        <li class="<?php echo url_is('crm/negociacoes*') ? 'active' : ''; ?>">
                                            <a href="<?php echo site_url('/crm/negociacoes'); ?>">Negociações</a>
                                        </li>
                                    <?php } ?>
                                    <?php if ((userIsLogged()->is_admin) || (userIsLogged()->validatePermissionLoggedUser('listar-tarefas'))) { ?>
                                        <li class="<?php echo url_is('crm/tarefas*') ? 'active' : ''; ?>">
                                            <a href="<?php echo site_url('/crm/tarefas'); ?>">Tarefas</a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </li>
                            <!-- CRM - Final -->
                        </ul>
                    </div>