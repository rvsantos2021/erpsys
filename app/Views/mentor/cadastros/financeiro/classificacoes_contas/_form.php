                <div class="form-row">
                    <div class="form-group col-md-3">
                        <div class="text-center">
                            <img class="img-fluid" src="<?php echo site_url('assets/images/avatar-plano-contas.png'); ?>" alt="Classificação" />
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
                                    <label>Nome</label>
                                    <input type="text" class="form-control" name="descricao" value="<?php echo $table->descricao; ?>" />
                                </div>
                            </div>
                            <div class="form-row selects-contant">
                                <div class="form-group col-md-4">
                                    <label for="tipo">Tipo</label>
                                    <select class="js-basic-single form-control" id="tipo" name="tipo" data-js-container=".modal">
                                        <option value="" <?php echo $table->tipo === '' ? 'selected' : ''; ?>>--- Selecione ---</option>
                                        <option value="P" <?php echo $table->tipo === 'P' ? 'selected' : ''; ?>>Despesa</option>
                                        <option value="R" <?php echo $table->tipo === 'R' ? 'selected' : ''; ?>>Receita</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-8">
                                    <label for="id_pai">Classificação Pai</label>
                                    <select class="js-basic-single form-control" id="id_pai" name="id_pai" data-js-container=".modal">
                                        <option value="">--- Selecione ---</option>
                                        <?php foreach ($classificacoes as $classificacao) { ?>
                                            <option value="<?php echo $classificacao->id; ?>" <?php echo $table->id_pai === $classificacao->id ? 'selected' : ''; ?>><?php echo $classificacao->codigo.' - '.$classificacao->descricao; ?></option>
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