                <div class="form-group">
                    <div class="text-center">
                        <?php if ($user->photo == null) : ?>
                            <img src="<?= site_url('assets/images/avatar-user.png'); ?>" class="rounded-circle" alt="Foto não cadastrada" />
                        <?php else : ?>
                            <img src="<?= site_url("users/show_photo/$user->photo"); ?>" class="rounded-circle" alt="Foto do usuário" />
                        <?php endif; ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="text-center">
                        <a href="#" class="btn btn-primary btn-sm mt-3 openPopupPhoto">Alterar Foto</a>
                    </div>
                </div>