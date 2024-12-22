                    <div class="row">
                        <div class="col-md-12">
                            <div class="tabs tabs-warning">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#produto" data-toggle="tab">Produto</a>
                                    </li>
                                    <li>
                                        <a href="#estoque" data-toggle="tab">Estoque</a>
                                    </li>
                                    <li>
                                        <a href="#precos" data-toggle="tab">Preços</a>
                                    </li>
                                    <li>
                                        <a href="#fornecedores" data-toggle="tab">Fornecedores</a>
                                    </li>
                                    <li>
                                        <a href="#imagens" data-toggle="tab">Imagens</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <?php echo $this->include('cadastros/estoque/produtos/_tab_produto'); ?>
                                    <?php echo $this->include('cadastros/estoque/produtos/_tab_estoque'); ?>
                                    <?php echo $this->include('cadastros/estoque/produtos/_tab_precos'); ?>
                                    <?php echo $this->include('cadastros/estoque/produtos/_tab_fornecedores'); ?>
                                    <?php echo $this->include('cadastros/estoque/produtos/_tab_imagens'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?= $this->include('layout/_response'); ?>

                    <script src="<?php echo site_url('assets/'); ?>javascripts/theme.js"></script>
                    <script src="<?php echo site_url('assets/'); ?>javascripts/theme.init.js"></script>
                    <script src="<?php echo site_url('assets/'); ?>javascripts/forms/examples.validation.js"></script>
                    <script src="<?php echo site_url('assets/'); ?>javascripts/custom/estoque/produtos_form.js"></script>