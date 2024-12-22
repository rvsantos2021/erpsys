            <div class="modal-wrapper-custom">
                <div class="col-lg-12">
                    <section class="panel panel-group">
                        <header>
                            <div class="widget-profile-info">
                                <div class="profile-picture">
                                    <?php if ($user->photo == null) : ?>
                                        <img src="<?php echo site_url('assets/images/avatar-user.png'); ?>">
                                    <?php else : ?>
                                        <img src="<?php echo site_url("users/show_photo/$user->photo"); ?>">
                                    <?php endif; ?>
                                </div>
                                <div class="profile-info">
                                    <h4 class="name text-semibold"><?php echo $user->name; ?></h4>
                                    <h5 class="role">
                                        <a href="mailto:<?php echo esc($user->email); ?>" target="_blank"><?php echo esc($user->email); ?></a>
                                    </h5>
                                    <div class="profile-footer">
                                        <p>
                                            <strong>Status:</strong> <?php echo ($user->active == true ? '<span class="text-success">Ativo</span>' : '<span class="text-danger">Inativo</span>'); ?>
                                        </p>
                                        <p>
                                            <strong>Criação:</strong> <?php echo formatDateTime($user->created_at); ?>
                                        </p>
                                        <p>
                                            <strong>Últ. Atualização:</strong> <?php echo formatDateTime($user->updated_at); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </header>
                    </section>
                </div>
            </div>