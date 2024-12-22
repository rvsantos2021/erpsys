                <div class="row">
                    <div class="col-md-4">
                        <div class="text-center">
                            <img src="<?php echo site_url('assets/images/avatar-group.png'); ?>" class="custom-picture rounded-circle" alt="" title="" />
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="checkbox-custom checkbox-success custom-control-inline float-right">
                                    <input type="checkbox" name="active" <?php echo ($table->active == 1 ? 'checked' : ''); ?> />
                                    <label for="active">Ativo</label>
                                </div>
                            </div>
                        </div>
                        <fieldset class="border pb-4 pr-4 pl-4 mb-2 rounded">
                            <legend class="legend"> <i class="fa fa-bookmark"></i> Dados Gerais</legend>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="name">Nome</label>
                                    <input type="text" class="form-control" name="name" placeholder="Nome" value="<?php echo $table->name; ?>" required />
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label for="email">Descrição</label>
                                    <textarea class="form-control" name="description" rows="3" data-plugin-maxlength maxlength="100"><?php echo esc($table->description); ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="checkbox-custom checkbox-default custom-control-inline">
                                        <input type="checkbox" name="display" <?php echo ($table->display == 1 ? 'checked' : ''); ?> />
                                        <label for="display">Exibir</label>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <?= $this->include('layout/_response'); ?>

                <script src="<?php echo site_url('assets/'); ?>javascripts/theme.js"></script>
                <script src="<?php echo site_url('assets/'); ?>javascripts/theme.init.js"></script>
                <script src="<?php echo site_url('assets/'); ?>javascripts/forms/examples.validation.js"></script>