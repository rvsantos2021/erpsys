                <div class="form-row">
                    <div class="form-group col-md-3">
                        <div class="text-center">
                            <?php if ($user->photo == null) : ?>
                                <img src="<?= site_url('assets/images/avatar-user.png'); ?>" class="rounded-circle" alt="Foto não cadastrada" />
                            <?php else : ?>
                                <img src="<?= site_url("users/show_photo/$user->photo"); ?>" class="rounded-circle" alt="Foto do usuário" />
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group col-md-9">
                        <fieldset class="border pr-4 pl-4 rounded">
                            <legend class="legend"> <i class="fa fa-bookmark"></i> Dados Gerais</legend>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Nome</label>
                                    <input type="text" class="form-control" name="name" value="<?= $user->name; ?>" disabled />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>E-mail (Login)</label>
                                    <input type="email" class="form-control" name="email" value="<?= $user->email; ?>" disabled />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label>Cadastrado em</label>
                                    <input type="text" class="form-control" name="created_at" value="<?= formatDateTime($user->created_at); ?>" disabled />
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Última atualização</label>
                                    <input type="text" class="form-control" name="updated_at" value="<?= formatDateTime($user->updated_at); ?>" disabled />
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Excluído em</label>
                                    <input type="text" class="form-control" name="deleted_at" value="<?= formatDateTime($user->deleted_at); ?>" disabled />
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                </div>
                                <div class="form-group col-md-4">
                                </div>
                                <div class="form-group col-md-4">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="active" <?= ($user->active == 1 ? 'checked' : ''); ?> />
                                        <label>Ativo</label>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>