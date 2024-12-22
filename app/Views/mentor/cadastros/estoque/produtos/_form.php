                <div class="form-row">
                    <div class="form-group col-md-12">
                        <div class="tab tab-vertical">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active show" id="produto-tab" data-toggle="tab" href="#produto" role="tab" aria-controls="produto" aria-selected="true">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="precos-tab" data-toggle="tab" href="#precos" role="tab" aria-controls="precos" aria-selected="false">Preços</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="estoque-tab" data-toggle="tab" href="#estoque" role="tab" aria-controls="estoque" aria-selected="false">Estoque</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="fornecedores-tab" data-toggle="tab" href="#fornecedores" role="tab" aria-controls="fornecedores" aria-selected="false">Fornecedores</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="imagens-tab" data-toggle="tab" href="#imagens" role="tab" aria-controls="imagens" aria-selected="false">Imagens</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <?php echo $this->include('mentor/cadastros/estoque/produtos/_tab_produto'); ?>
                                <?php echo $this->include('mentor/cadastros/estoque/produtos/_tab_estoque'); ?>
                                <?php echo $this->include('mentor/cadastros/estoque/produtos/_tab_precos'); ?>
                                <?php echo $this->include('mentor/cadastros/estoque/produtos/_tab_fornecedores'); ?>
                                <?php echo $this->include('mentor/cadastros/estoque/produtos/_tab_imagens'); ?>
                            </div>
                        </div>                    
                    </div>
                </div>
                <?php echo $this->include('mentor/layout/_response'); ?>
