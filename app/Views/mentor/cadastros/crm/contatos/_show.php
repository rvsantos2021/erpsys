                <div class="form-row">
                    <div class="form-group col-md-2">
                        <div class="text-center">
                            <img src="<?php echo site_url('assets/images/avatar-vendedor.png'); ?>" class="rounded-circle" alt="Contato" />
                        </div>
                    </div>
                    <div class="form-group col-md-10">
                        <fieldset class="border pb-2 pr-4 pl-4 rounded">
                            <legend class="legend"> <i class="fa fa-bookmark"></i> Dados Gerais</legend>
                            <div class="form-row">
                                <div class="form-group col-md-10">
                                    <label>Nome</label>
                                    <input type="text" class="form-control" name="nome" value="<?php echo $table->nome; ?>" disabled />
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="data_nascimento" id="labelData">Data Fundação</label>
                                    <input type="date" class="form-control" name="data_nascimento" value="<?php echo $table->data_nascimento; ?>" disabled />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label>Cargo</label>
                                    <input type="text" class="form-control" name="cargo" value="<?php echo $table->cargo; ?>" disabled />
                                </div>
                                <div class="form-group col-md-7">
                                    <label>Cliente</label>
                                    <input type="text" class="form-control" name="cliente" value="<?php echo $table->razao_social; ?>" disabled />
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="border pt-2 pb-2 pr-4 pl-4 mb-2 rounded">
                            <legend class="legend"> <i class="fa fa-comment"></i> Contato</legend>
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label>Telefone</label>
                                    <input type="text" class="form-control inputmask" name="telefone" value="<?php echo $table->telefone; ?>" disabled />
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Celular</label>
                                    <input type="text" class="form-control inputmask" name="celular" value="<?php echo $table->celular; ?>" disabled />
                                </div>
                                <div class="form-group col-md-8">
                                    <label>E-mail</label>
                                    <input type="email" class="form-control" name="email" value="<?php echo $table->email; ?>" disabled />
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="border pt-2 pb-2 pr-4 pl-4 mb-2 rounded">
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
