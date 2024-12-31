                <div class="form-row">
                    <div class="form-group col-md-3">
                        <div class="text-center">
                            <img class="img-fluid" src="<?php echo site_url('assets/images/avatar-condicao-pagamento.png'); ?>" alt="Condição de Pagamento" />
                        </div>
                    </div>
                    <div class="form-group col-md-9">
                        <fieldset class="border pr-4 pl-4 rounded">
                            <legend class="legend"> <i class="fa fa-bookmark"></i> Dados Gerais</legend>
                            <div class="form-row">
                                <div class="form-group col-md-8">
                                    <label>Descrição</label>
                                    <input type="text" class="form-control" name="nome" value="<?php echo $table->nome; ?>" disabled />
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="tabela_id">Tabela de Preço</label>
                                    <select class="js-basic-single form-control" id="tabela_id" name="tabela_id" data-js-container=".modal" disabled>
                                        <option value="">--- Selecione ---</option>
                                        <?php foreach ($tabelas as $tabela) { ?>
                                            <option value="<?php echo $tabela->id; ?>" <?php echo $table->tabela_id === $tabela->id ? 'selected' : ''; ?>><?php echo $tabela->descricao; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="entrada" id="entrada" <?php echo $table->entrada == 1 ? 'checked' : ''; ?> disabled />
                                        <label for="entrada">Exige Entrada</label>
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label>% Entrada</label>
                                    <input type="text" class="form-control text-right" name="perc_entrada" value="<?php echo $table->perc_entrada; ?>" disabled />
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Nº Parcelas</label>
                                    <input type="number" class="form-control" name="qtd_parcelas" value="<?php echo $table->qtd_parcelas; ?>" disabled />
                                </div>
                                <div class="form-group col-md-2">
                                    <label>1ª Parcela</label>
                                    <input type="number" class="form-control" name="dias_parcela1" value="<?php echo $table->dias_parcela1; ?>" disabled />
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Entre Parcela</label>
                                    <input type="number" class="form-control" name="dias_parcelas" value="<?php echo $table->dias_parcelas; ?>" disabled />
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