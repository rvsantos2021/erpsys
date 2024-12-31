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
                                    <input type="text" class="form-control" name="nome" value="<?php echo $table->nome; ?>" disabled />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-check mb-1 pb-1">
                                        <input type="checkbox" class="form-check-input" name="financeiro" <?php echo $table->financeiro == 1 ? 'checked' : ''; ?> disabled />
                                        <label>Gerar Movimento Financeiro</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-1 pb-1">
                                        <input type="checkbox" class="form-check-input" name="desconto" <?php echo $table->desconto == 1 ? 'checked' : ''; ?> disabled />
                                        <label>Permitir Desconto</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-1 pb-1">
                                        <input type="checkbox" class="form-check-input" name="contas_pagar" <?php echo $table->contas_pagar == 1 ? 'checked' : ''; ?> disabled />
                                        <label>Disponibilizar no Contas a Pagar</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check mb-1 pb-1">
                                        <input type="checkbox" class="form-check-input" name="contas_receber" <?php echo $table->contas_receber == 1 ? 'checked' : ''; ?> disabled />
                                        <label>Disponibilizar no Contas a Receber</label>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                            <legend class="legend"> <i class="ti ti-info-alt"></i> Logs</legend>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label>Cadastrado em</label>
                                    <input type="text" class="form-control" name="created_at" value="<?php echo formatDateTime($table->created_at); ?>" disabled />
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Última atualização</label>
                                    <input type="text" class="form-control" name="updated_at" value="<?php echo formatDateTime($table->updated_at); ?>" disabled />
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Excluído em</label>
                                    <input type="text" class="form-control" name="deleted_at" value="<?php echo formatDateTime($table->deleted_at); ?>" disabled />
                                </div>
                                <div class="form-group col-md-3">
                                    <div class="form-check float-right">
                                        <input type="checkbox" class="form-check-input" name="active" <?php echo $table->active == 1 ? 'checked' : ''; ?> />
                                        <label>Ativo</label>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>