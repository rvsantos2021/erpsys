                <div class="form-row">
                    <div class="form-group col-md-3">
                        <div class="text-center">
                            <img class="img-fluid" src="<?php echo site_url('assets/images/avatar-grupo-produto.png'); ?>" alt="Grupo" />
                        </div>
                    </div>
                    <div class="form-group col-md-9">
                        <fieldset class="border pb-4 pr-4 pl-4 rounded">
                            <legend class="legend"> <i class="fa fa-bookmark"></i> Dados Gerais</legend>
                            <div class="form-row">
                                <div class="form-group col-md-2">
                                    <label>Código</label>
                                    <input type="text" class="form-control" name="codigo" value="<?php echo $table->codigo; ?>" disabled />
                                </div>
                                <div class="form-group col-md-10">
                                    <label>Descrição</label>
                                    <input type="text" class="form-control" name="descricao" placeholder="Descrição" value="<?php echo $table->descricao; ?>" required />
                                </div>
                            </div>
                            <div class="form-row selects-contant">
                                <div class="form-group col-md-12">
                                    <label for="id_pai">Grupo Pai</label>
                                    <select class="js-basic-single form-control" id="id_pai" name="id_pai" data-js-container=".modal">
                                        <option value="">--- Selecione ---</option>
                                        <?php foreach ($grupos as $grupo) { ?>
                                            <option value="<?php echo $grupo->id; ?>" <?php echo $table->id_pai === $grupo->id ? 'selected' : ''; ?>><?php echo $grupo->codigo.' - '.$grupo->descricao; ?></option>
                                        <?php } ?>
                                    </select>
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