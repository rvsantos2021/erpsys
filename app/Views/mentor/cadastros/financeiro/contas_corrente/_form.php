                <div class="form-row">
                    <div class="form-group col-md-3">
                        <div class="text-center">
                            <img class="img-fluid" src="<?php echo site_url('assets/images/avatar-conta-corrente.png'); ?>" alt="Conta Corrente" />
                        </div>
                    </div>
                    <div class="form-group col-md-9">
                        <fieldset class="border pb-4 pr-4 pl-4 rounded">
                            <legend class="legend"> <i class="fa fa-bookmark"></i> Dados Gerais</legend>
                            <div class="form-row">
                                <div class="form-group col-md-7">
                                    <label for="banco_id">Banco</label>
                                    <select class="js-basic-single form-control" id="banco_id" name="banco_id" data-js-container=".modal">
                                        <option value="">--- Selecione ---</option>
                                        <?php foreach ($bancos as $banco) { ?>
                                            <option value="<?php echo $banco->id; ?>" <?php echo $table->banco_id === $banco->id ? 'selected' : ''; ?>><?php echo $banco->descricao; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Número</label>
                                    <input type="text" class="form-control" name="numero" placeholder="Número" value="<?php echo $table->numero; ?>" required />
                                </div>
                                <div class="form-group col-md-2">
                                    <label>Agência</label>
                                    <input type="text" class="form-control" name="agencia" placeholder="Agência" value="<?php echo $table->agencia; ?>" required />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Descrição</label>
                                    <input type="text" class="form-control" name="descricao" placeholder="Descrição" value="<?php echo $table->descricao; ?>" required />
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