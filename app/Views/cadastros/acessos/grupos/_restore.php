            <div class="modal-wrapper-custom">
                <div class="col-lg-12">
                    <h4 class="text-success text-semibold">Confirma o restore do grupo?</h4>
                    <section class="panel panel-group">
                        <header>
                            <div class="widget-profile-info">
                                <div class="profile-picture">
                                    <img src="<?php echo site_url('assets/images/avatar-group.png'); ?>">
                                </div>
                                <div class="profile-info">
                                    <h4 class="name text-semibold"><?php echo $group->name; ?></h4>
                                    <p class="role"><?php echo esc($group->description); ?></p>
                                    <div class="profile-footer">
                                        <p>
                                            <strong>Excluído em:</strong> <?php echo formatDateTime($group->deleted_at); ?>
                                        </p>
                                    </div>
                                </div>
                                <input type="hidden" name="id" value="<?php echo $group->id ?>" />
                                <input type="hidden" name="method_del" value="restore" />
                            </div>
                        </header>
                    </section>
                </div>
            </div>