                <div class="row">
                    <div class="col-md-4">
                        <div class="text-center">
                            <?php if ($table->photo == null) : ?>
                                <img src="<?php echo site_url('assets/images/avatar-user.png'); ?>" class="custom-picture rounded-circle" alt="" title="" />
                            <?php else : ?>
                                <img src="<?php echo site_url("users/show_photo/$table->photo"); ?>" class="custom-picture rounded-circle" alt="" title="" />
                            <?php endif; ?>
                        </div>
                        <div class="text-center">
                            <?php if ($method == "update") : ?>
                                <!-- <a href="<?php echo site_url("users/edit_photo/$table->id"); ?>" class="btn btn-primary btn-sm mt-3 openPopupPhoto">Alterar Foto</a> -->
                                <a href="#" class="btn btn-primary btn-sm mt-3 openPopupPhoto">Alterar Foto</a>
                            <?php endif; ?>
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
                                    <label for="email">E-mail (Login)</label>
                                    <input type="email" class="form-control" name="email" placeholder="E-mail" value="<?php echo $table->email; ?>" autocomplete="email" required />
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label for="password">Senha</label>
                                    <input type="password" class="form-control" name="password" placeholder="Senha" autocomplete="current-password" required />
                                </div>
                                <div class="col-md-6">
                                    <label for="confirm_password">Confirmar Senha</label>
                                    <input type="password" class="form-control" name="password_confirmation" placeholder="Confirmar Senha" autocomplete="current-password" required />
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="checkbox-custom checkbox-default custom-control-inline">
                                        <input type="checkbox" id="change_password" name="change_password" />
                                        <label for="change_password">Pedir para alterar senha no próximo Login</label>
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