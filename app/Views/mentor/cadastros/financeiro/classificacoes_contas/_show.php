                <div class="form-row">
                    <div class="form-group col-md-3">
                        <div class="text-center">
                            <img class="img-fluid" src="<?php echo site_url('assets/images/avatar-plano-contas.png'); ?>" alt="Classificação" />
                        </div>
                    </div>
                    <div class="form-group col-md-9">
                        <fieldset class="border pr-4 pl-4 rounded">
                            <legend class="legend"> <i class="fa fa-bookmark"></i> Dados Gerais</legend>
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label>Código</label>
                                    <input type="text" class="form-control" name="codigo" value="<?php echo $table->codigo; ?>" disabled />
                                </div>
                                <div class="form-group col-md-10">
                                    <label>Nome</label>
                                    <input type="text" class="form-control" name="descricao" value="<?php echo $table->descricao; ?>" disabled />
                                </div>
                            </div>
                            <div class="form-row selects-contant">
                                <div class="form-group col-md-4">
                                    <label for="tipo">Tipo</label>
                                    <select class="js-basic-single form-control" id="tipo" name="tipo" data-js-container=".modal" disabled>
                                        <option value="" <?php echo $table->tipo === '' ? 'selected' : ''; ?>>--- Selecione ---</option>
                                        <option value="P" <?php echo $table->tipo === 'P' ? 'selected' : ''; ?>>Despesa</option>
                                        <option value="R" <?php echo $table->tipo === 'R' ? 'selected' : ''; ?>>Receita</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-8">
                                    <label for="id_pai">Classificação Pai</label>
                                    <select class="js-basic-single form-control" id="id_pai" name="id_pai" data-js-container=".modal" disabled>
                                        <option value="">--- Selecione ---</option>
                                        <?php foreach ($classificacoes as $classificacao) { ?>
                                            <option value="<?php echo $classificacao->id; ?>" <?php echo $table->id_pai === $classificacao->id ? 'selected' : ''; ?>><?php echo $classificacao->codigo.' - '.$classificacao->descricao; ?></option>
                                        <?php } ?>
                                    </select>
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