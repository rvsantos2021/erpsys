                <div class="form-row">
                    <div class="form-group col-md-3">
                        <div class="text-center">
                            <img class="img-fluid" src="<?php echo site_url('assets/images/avatar-forma-pagamento.png'); ?>" alt="Forma de Pagamento" />
                        </div>
                    </div>
                    <div class="form-group col-md-9">
                        <fieldset class="border pr-4 pl-4 rounded">
                            <legend class="legend"> <i class="fa fa-bookmark"></i> Dados Gerais</legend>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Nome</label>
                                    <input type="text" class="form-control" name="nome" value="<?php echo $table->nome; ?>" />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-check mb-1 pb-1">
                                        <input type="checkbox" class="form-check-input" id="financeiro" name="financeiro" <?php echo $table->financeiro == 1 ? 'checked' : ''; ?> />
                                        <label for="financeiro">Gerar Movimento Financeiro</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-1 pb-1">
                                        <input type="checkbox" class="form-check-input" id="desconto" name="desconto" <?php echo $table->desconto == 1 ? 'checked' : ''; ?> />
                                        <label for="desconto">Permitir Desconto</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-1 pb-1">
                                        <input type="checkbox" class="form-check-input" id="contas_pagar" name="contas_pagar" <?php echo $table->contas_pagar == 1 ? 'checked' : ''; ?> />
                                        <label for="contas_pagar">Disponibilizar no Contas a Pagar</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-1 pb-1">
                                        <input type="checkbox" class="form-check-input" id="contas_receber" name="contas_receber" <?php echo $table->contas_receber == 1 ? 'checked' : ''; ?> />
                                        <label for="contas_receber">Disponibilizar no Contas a Receber</label>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <?php echo $this->include('mentor/layout/_response'); ?>