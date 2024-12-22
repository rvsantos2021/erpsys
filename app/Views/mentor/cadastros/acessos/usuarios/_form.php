                <div class="form-row">
                    <div class="form-group col-md-3">
                        <div class="text-center">
                            <?php if ($table->photo == null) { ?>
                                <img src="<?php echo site_url('assets/images/avatar-user.png'); ?>" class="rounded-circle" alt="" title="" />
                            <?php } else { ?>
                                <img src="<?php echo site_url("users/show_photo/$table->photo"); ?>" class="rounded-circle" alt="" title="" />
                            <?php } ?>
                        </div>
                        <div class="text-center">
                            <?php if ($method == 'update') { ?>
                                <a href="#" class="btn btn-primary btn-sm mt-3 openPopupPhoto">Alterar Foto</a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="form-group col-md-9">
                        <fieldset class="border pb-4 pr-4 pl-4 rounded">
                            <legend class="legend"> <i class="fa fa-bookmark"></i> Dados Gerais</legend>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Nome</label>
                                    <input type="text" class="form-control" name="name" placeholder="Nome" value="<?php echo $table->name; ?>" required />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>E-mail (Login)</label>
                                    <input type="email" class="form-control" name="email" placeholder="E-mail" value="<?php echo $table->email; ?>" autocomplete="email" required />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Senha</label>
                                    <input type="password" class="form-control" name="password" placeholder="Senha" autocomplete="current-password" required />
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Confirmar Senha</label>
                                    <input type="password" class="form-control" name="password_confirmation" placeholder="Confirmar Senha" autocomplete="current-password" required />
                                </div>
                            </div>
                            <?php if ($method == 'update') { ?>
                            <div class="form-group">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="active" name="active" <?php echo ($table->active == 1 ? 'checked' : ''); ?> />
                                    <label for="active" class="form-check-label">Ativo</label>
                                </div>
                            </div>
                            <?php } ?>
                            <!--
                            <div class="form-group">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="change_password" name="change_password" <?php echo ($table->change_password == 1 ? 'checked' : ''); ?> />
                                    <label for="change_password" class="form-check-label">Pedir para alterar senha no próximo Login</label>
                                </div>
                            </div>
                            -->
                        </fieldset>
                    </div>
                </div>
                <?php echo $this->include('mentor/layout/_response'); ?>