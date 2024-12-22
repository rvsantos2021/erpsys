                    <div class="row">
                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                            <legend class="legend"> <i class="fa fa-user"></i> Identificação</legend>
                            <div class="form-group row">
                                <div class="col-md-10">
                                    <label>Nome</label>
                                    <input type="text" class="form-control input-sm" name="nome" placeholder="Nome" value="<?php echo $table->nome; ?>" maxlength="50" required />
                                </div>
                                <div class="col-md-2">
                                    <label>Data Nascimento</label>
                                    <input type="date" class="form-control input-sm" name="data_nascimento" value="<?php echo $table->data_nascimento; ?>" />
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-5">
                                    <label>Cargo</label>
                                    <div class="input-group btn-group">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-sm btn-default btn-add-cargo"><i class="fa fa-plus"></i></button>
                                        </div>
                                        <select data-plugin-selectTwo class="form-control input-sm" name="cargo_id" data-plugin-options='{ "placeholder": "Informe o Cargo", "allowClear": true }'>
                                            <option value=""></option>
                                            <?php foreach ($cargos as $cargo) : ?>
                                                <option value="<?php echo $cargo->id; ?>" <?php echo ($table->cargo_id === $cargo->id ? 'selected' : ''); ?>><?php echo $cargo->descricao; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <label>Cliente</label>
                                    <div class="input-group btn-group">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-sm btn-default btn-add-cliente"><i class="fa fa-plus"></i></button>
                                        </div>
                                        <select data-plugin-selectTwo class="form-control input-sm" name="cliente_id" data-plugin-options='{ "placeholder": "Informe o Cliente", "allowClear": true }'>
                                            <option value=""></option>
                                            <?php foreach ($clientes as $cliente) : ?>
                                                <option value="<?php echo $cliente->id; ?>" <?php echo ($table->cliente_id === $cliente->id ? 'selected' : ''); ?>><?php echo $cliente->razao_social; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-2">
                                    <label>Telefone</label>
                                    <input type="text" class="form-control input-sm" name="telefone" placeholder="Telefone" value="<?php echo $table->telefone; ?>" data-plugin-masked-input data-input-mask="(99) 9999-9999" />
                                </div>
                                <div class="col-md-2">
                                    <label>Celular</label>
                                    <input type="text" class="form-control input-sm" name="celular" placeholder="Celular" value="<?php echo $table->celular; ?>" data-plugin-masked-input data-input-mask="(99) 99999-9999" />
                                </div>
                                <div class="col-md-8">
                                    <label>E-mail</label>
                                    <input type="email" class="form-control input-sm" name="email" placeholder="E-mail" value="<?php echo $table->email; ?>" />
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <?= $this->include('layout/_response'); ?>

                    <script src="<?php echo site_url('assets/'); ?>vendor/jquery-maskedinput/jquery.maskedinput.js"></script>
                    <script src="<?php echo site_url('assets/'); ?>javascripts/theme.js"></script>
                    <script src="<?php echo site_url('assets/'); ?>javascripts/theme.init.js"></script>
                    <script src="<?php echo site_url('assets/'); ?>javascripts/forms/examples.validation.js"></script>