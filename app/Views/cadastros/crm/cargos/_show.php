            <div class="modal-wrapper-custom">
                <div class="col-lg-12">
                    <section class="panel panel-group">
                        <header>
                            <div class="widget-profile-info">
                                <div class="profile-picture">
                                    <img src="<?php echo site_url('assets/images/avatar-modelo.png'); ?>">
                                </div>
                                <div class="profile-info">
                                    <h4 class="name text-semibold"><?php echo $cargo->descricao; ?></h4>
                                    <div class="profile-footer">
                                        <p>
                                            <strong>Status:</strong> <?php echo ($cargo->active == true ? '<span class="text-success">Ativo</span>' : '<span class="text-danger">Inativo</span>'); ?>
                                        </p>
                                        <p>
                                            <strong>Criação:</strong> <?php echo formatDateTime($cargo->created_at); ?>
                                        </p>
                                        <p>
                                            <strong>Últ. Atualização:</strong> <?php echo formatDateTime($cargo->updated_at); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </header>
                    </section>
                </div>
            </div>