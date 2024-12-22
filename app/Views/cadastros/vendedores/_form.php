                    <link href="<?php echo site_url('assets/'); ?>vendor/selectize/css/selectize.bootstrap4.css" rel="stylesheet">

                    <div class="row">
                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                            <legend class="legend"> <i class="fa fa-user"></i> Identificação</legend>
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label for="cpnj" id="labelCNPJ">CNPJ</label>
                                    <input type="text" class="form-control input-sm" name="cnpj" placeholder="CNPJ" value="<?php echo $table->cnpj; ?>" data-plugin-masked-input data-input-mask="99.999.999/9999-99" required />
                                </div>
                                <div class="col-md-2">
                                    <label for="inscricao_estadual" id="labelIE">Inscr. Estadual</label>
                                    <input type="text" class="form-control input-sm" name="inscricao_estadual" placeholder="Inscr. Estadual" value="<?php echo $table->inscricao_estadual; ?>" />
                                </div>
                                <div class="col-md-2">
                                    <label for="data_nascimento" id="labelData">Data Fundação</label>
                                    <input type="date" class="form-control input-sm" name="data_nascimento" value="<?php echo $table->data_nascimento; ?>" />
                                </div>
                                <div class="col-md-6">
                                    <div class="radio-custom radio-success custom-control-inline float-right">
                                        <input type="radio" id="tipo-pf" name="tipo" class="custom-control-input" value="F" <?php echo ($table->tipo == 'F' ? 'checked' : ''); ?> />
                                        <label class="custom-control-label" for="tipo-pf">Pessoa Física</label>
                                    </div>
                                    <div class="radio-custom radio-warning custom-control-inline float-right">
                                        <input type="radio" id="tipo-pj" name="tipo" class="custom-control-input" value="J" <?php echo ($table->tipo == 'J' ? 'checked' : ''); ?> />
                                        <label class="custom-control-label" for="tipo-pj">Pessoa Jurídica</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-7">
                                    <label for="razao_social" id='labelRazao'>Razão Social</label>
                                    <input type="text" class="form-control input-sm" name="razao_social" placeholder="Razão Social" value="<?php echo $table->razao_social; ?>" required />
                                </div>
                                <div class="col-md-5">
                                    <label for="nome_fantasia" id='labelFantasia'>Nome Fantasia</label>
                                    <input type="text" class="form-control input-sm" name="nome_fantasia" placeholder="Nome Fantasia" value="<?php echo $table->nome_fantasia; ?>" />
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                            <legend class="legend"> <i class="fa fa-comment"></i> Contato</legend>
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label for="telefone">Telefone</label>
                                    <input type="text" class="form-control input-sm" name="telefone" placeholder="Telefone" value="<?php echo $table->telefone; ?>" data-plugin-masked-input data-input-mask="(99) 9999-9999" />
                                </div>
                                <div class="col-md-2">
                                    <label for="celular">Celular</label>
                                    <input type="text" class="form-control input-sm" name="celular" placeholder="Celular" value="<?php echo $table->celular; ?>" data-plugin-masked-input data-input-mask="(99) 99999-9999" />
                                </div>
                                <div class="col-md-8">
                                    <label for="email">E-mail</label>
                                    <input type="email" class="form-control input-sm" name="email" placeholder="E-mail" value="<?php echo $table->email; ?>" />
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                            <legend class="legend"> <i class="fa fa-money"></i> Financeiro</legend>
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label for="perc_comissao">% Comissão</label>
                                    <input type="text" class="form-control input-sm text-right" name="perc_comissao" placeholder="Ex.: 2,00%" value="<?php echo formatPercent($table->perc_comissao, false); ?>" />
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                            <legend class="legend"> <i class="fa fa-file-text"></i> Informações Adicionais</legend>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="obs">Observações</label>
                                    <textarea class="form-control" rows="3" name="obs"><?php echo $table->obs; ?></textarea>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <?= $this->include('layout/_response'); ?>

                    <script src="<?php echo site_url('assets/'); ?>vendor/selectize/js/selectize.min.js"></script>
                    <script src="<?php echo site_url('assets/'); ?>vendor/jquery-maskedinput/jquery.maskedinput.js"></script>
                    <script src="<?php echo site_url('assets/'); ?>javascripts/theme.js"></script>
                    <script src="<?php echo site_url('assets/'); ?>javascripts/theme.init.js"></script>
                    <script src="<?php echo site_url('assets/'); ?>javascripts/forms/examples.validation.js"></script>

                    <script type="text/javascript">
                        $(document).ready(function() {
                            $('.selectize').selectize();

                            var cnpj = '<?php echo $table->cnpj; ?>';

                            $('input[name="tipo"]').change(function() {
                                updateLabels();
                            });

                            if ($('[name="tipo"]').val() == '') {
                                $('[name="tipo"]').val('F');
                            }

                            $('[name="perc_comissao"]').blur(function() {
                                var perc_comissao = $(this).val().replace(" ", "");

                                $(this).val(formatValorDecimal(perc_comissao));
                            });

                            $('[name="cnpj"]').val(cnpj);
                        });
                    </script>