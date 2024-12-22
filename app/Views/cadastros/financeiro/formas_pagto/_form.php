                    <div class="row">
                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                            <legend class="legend"> <i class="fa fa-user"></i> Identificação</legend>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="nome">Nome</label>
                                    <input type="text" class="form-control input-sm" name="nome" placeholder="Forma de Pagamento" value="<?php echo $table->nome; ?>" required />
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="checkbox-custom checkbox-primary">
                                        <input type="checkbox" name="financeiro" <?php echo ($table->financeiro == 1 ? 'checked' : ''); ?> />
                                        <label for="financeiro">Gerar Movimento Financeiro</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="checkbox-custom checkbox-warning">
                                        <input type="checkbox" name="desconto" <?php echo ($table->desconto == 1 ? 'checked' : ''); ?> />
                                        <label for="desconto">Permitir Desconto</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="checkbox-custom checkbox-info">
                                        <input type="checkbox" name="contas_pagar" <?php echo ($table->contas_pagar == 1 ? 'checked' : ''); ?> />
                                        <label for="contas_pagar">Disponibilizar no Contas a Pagar</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="checkbox-custom checkbox-success">
                                        <input type="checkbox" name="contas_receber" <?php echo ($table->contas_receber == 1 ? 'checked' : ''); ?> />
                                        <label for="contas_receber">Disponibilizar no Contas a Receber</label>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <?= $this->include('layout/_response'); ?>

                    <script src="<?php echo site_url('assets/'); ?>javascripts/theme.js"></script>
                    <script src="<?php echo site_url('assets/'); ?>javascripts/theme.init.js"></script>
                    <script src="<?php echo site_url('assets/'); ?>javascripts/forms/examples.validation.js"></script>