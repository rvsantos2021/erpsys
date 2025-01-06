                <div class="form-row">
                    <div class="form-group col-md-3">
                        <div class="text-center">
                            <img class="img-fluid" src="<?php echo site_url('assets/images/avatar-conta-corrente.png'); ?>" alt="Conta Corrente" />
                        </div>
                    </div>
                    <div class="form-group col-md-9">
                        <fieldset class="border pr-4 pl-4 rounded">
                            <legend class="legend"> <i class="fa fa-bookmark"></i> Dados Gerais</legend>
                            <div class="form-row">
                                <div class="form-group col-md-7">
                                    <label for="banco_id">Banco</label>
                                    <select class="js-basic-single form-control" id="banco_id" name="banco_id" data-js-container=".modal" disabled>
                                        <option value="">--- Selecione ---</option>
                                        <?php foreach ($bancos as $banco) { ?>
                                            <option value="<?php echo $banco->id; ?>" <?php echo $table->banco_id === $banco->id ? 'selected' : ''; ?>><?php echo $banco->descricao; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Número</label>
                                    <input type="text" class="form-control" name="numero" placeholder="Número" value="<?php echo $table->numero; ?>" disabled />
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Agência</label>
                                    <input type="text" class="form-control" name="agencia" placeholder="Agência" value="<?php echo $table->agencia; ?>" disabled />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Descrição</label>
                                    <input type="text" class="form-control" name="descricao" placeholder="Descrição" value="<?php echo $table->descricao; ?>" disabled />
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