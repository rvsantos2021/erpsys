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
                                    <input type="text" class="form-control" name="nome" value="<?php echo $table->nome; ?>" required />
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="data_nascimento" id="labelData">Data Fundação</label>
                                    <input type="date" class="form-control" name="data_nascimento" value="<?php echo $table->data_nascimento; ?>" />
                                </div>
                            </div>
                            <div class="form-row selects-contant">
                                <div class="form-group col-md-5">
                                    <label for="cargo_id">Cargo</label>
                                    <select class="js-basic-single form-control" id="cargo_id" name="cargo_id">
                                        <option value="">--- Selecione ---</option>
                                        <?php foreach ($cargos as $cargo) { ?>
                                            <option value="<?php echo $cargo->id; ?>" <?php echo $table->cargo_id === $cargo->id ? 'selected' : ''; ?>><?php echo $cargo->descricao; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-7">
                                    <label for="cliente_id">Cliente</label>
                                    <select class="js-basic-single form-control" name="cliente_id">
                                        <option value="">--- Selecione ---</option>
                                        <?php foreach ($clientes as $cliente) { ?>
                                            <option value="<?php echo $cliente->id; ?>" <?php echo $table->cliente_id === $cliente->id ? 'selected' : ''; ?>><?php echo $cliente->razao_social; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset class="border pt-2 pb-2 pr-4 pl-4 mb-2 rounded">
                            <legend class="legend"> <i class="fa fa-comment"></i> Contato</legend>
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label>Telefone</label>
                                    <input type="text" class="form-control inputmask" name="telefone" value="<?php echo $table->telefone; ?>" />
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Celular</label>
                                    <input type="text" class="form-control inputmask" name="celular" value="<?php echo $table->celular; ?>" />
                                </div>
                                <div class="form-group col-md-8">
                                    <label>E-mail</label>
                                    <input type="email" class="form-control" name="email" value="<?php echo $table->email; ?>" />
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <?php echo $this->include('mentor/layout/_response'); ?>

                <script type="text/javascript">
                    $(document).ready(function() {
                        $(".js-basic-single").select2({
                            dropdownParent: $("#modalForm")
                        });
                    });
                </script>