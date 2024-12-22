            <div class="modal-wrapper-custom">
                <div class="col-lg-12">
                    <h4 class="text-danger text-semibold">Confirma a exclusão do depósito?</h4>
                    <section class="panel panel-group">
                        <header>
                            <div class="widget-profile-info">
                                <div class="profile-picture">
                                    <img src="<?php echo site_url('assets/images/avatar-deposito.png'); ?>">
                                </div>
                                <div class="profile-info">
                                    <h4 class="name text-semibold"><?php echo $deposito->descricao; ?></h4>
                                    <div class="profile-footer">
                                        <p>
                                            <strong>Últ. Atualização:</strong> <?php echo formatDateTime($deposito->updated_at); ?>
                                        </p>
                                    </div>
                                </div>
                                <input type="hidden" name="id" value="<?php echo $deposito->id ?>" />
                                <input type="hidden" name="method_del" value="remove" />
                            </div>
                        </header>
                    </section>
                </div>
            </div>