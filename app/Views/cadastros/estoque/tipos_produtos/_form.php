                    <div class="row">
                        <fieldset class="border pt-2 pb-4 pr-4 pl-4 mb-2 rounded">
                            <legend class="legend"> <i class="fa fa-user"></i> Identificação</legend>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="descricao">Nome</label>
                                    <input type="text" class="form-control input-sm" name="descricao" placeholder="Descrição" value="<?php echo $table->descricao; ?>" required />
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="checkbox-custom checkbox-primary">
                                        <input type="checkbox" name="produto" <?php echo ($table->produto == 1 ? 'checked' : ''); ?> />
                                        <label for="produto">Produto</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="checkbox-custom checkbox-warning">
                                        <input type="checkbox" name="servico" <?php echo ($table->servico == 1 ? 'checked' : ''); ?> />
                                        <label for="servico">Serviço</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="checkbox-custom checkbox-info">
                                        <input type="checkbox" name="materia_prima" <?php echo ($table->materia_prima == 1 ? 'checked' : ''); ?> />
                                        <label for="materia_prima">Matéria-Prima</label>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <?= $this->include('layout/_response'); ?>

                    <script src="<?php echo site_url('assets/'); ?>javascripts/theme.js"></script>
                    <script src="<?php echo site_url('assets/'); ?>javascripts/theme.init.js"></script>
                    <script src="<?php echo site_url('assets/'); ?>javascripts/forms/examples.validation.js"></script>