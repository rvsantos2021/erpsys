                <div class="form-row">
                    <div class="form-group col-md-3">
                        <div class="text-center">
                            <img class="img-fluid" src="<?php echo site_url('assets/images/avatar-unidade.png'); ?>" alt="Unidade" />
                        </div>
                    </div>
                    <div class="form-group col-md-9">
                        <fieldset class="border pr-4 pl-4 rounded">
                            <legend class="legend"> <i class="fa fa-bookmark"></i> Dados Gerais</legend>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Nome</label>
                                    <input type="text" class="form-control" name="descricao" value="<?php echo $table->descricao; ?>" disabled />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="entrada" name="movimento" value="E" <?php echo $table->movimento == 'E' ? 'checked' : ''; ?> disabled />
                                        <label for="entrada" class="form-check-label">Entrada</label>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="saida" name="movimento" value="S" <?php echo $table->movimento == 'S' ? 'checked' : ''; ?> disabled />
                                        <label for="saida" class="form-check-label">Saída</label>
                                    </div>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="transferencia" name="movimento" value="S" <?php echo $table->movimento == 'T' ? 'checked' : ''; ?> disabled />
                                        <label for="transferencia" class="form-check-label">Transferência</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="estoque" name="estoque" <?php echo $table->estoque == 1 ? 'checked' : ''; ?> disabled />
                                        <label for="estoque" class="form-check-label">Movimenta Estoque</label>
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
                                        <input type="checkbox" class="form-check-input" name="active" <?php echo $table->active == 1 ? 'checked' : ''; ?> disabled />
                                        <label>Ativo</label>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>