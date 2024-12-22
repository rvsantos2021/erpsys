            <div class="modal-wrapper-custom">
                <div class="col-lg-12">
                    <h4 class="text-success text-semibold">Confirma o restore do usuário?</h4>
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
                                            <strong>Excluído em:</strong> <?php echo formatDateTime($user->deleted_at); ?>
                                        </p>
                                    </div>
                                </div>
                                <input type="hidden" name="id" value="<?php echo $user->id ?>" />
                                <input type="hidden" name="method_del" value="restore" />
                            </div>
                        </header>
                    </section>
                </div>
            </div>