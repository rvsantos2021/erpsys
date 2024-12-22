            <div class="modal-wrapper-custom">
                <div class="col-lg-12">
                    <section class="panel panel-group">
                        <header>
                            <div class="widget-profile-info">
                                <div class="profile-picture">
                                    <img src="<?php echo site_url('assets/images/avatar-unidade.png'); ?>">
                                </div>
                                <div class="profile-info">
                                    <h4 class="name text-semibold"><?php echo $unidade->descricao; ?></h4>
                                    <div class="profile-footer">
                                        <p>
                                            <strong>Status:</strong> <?php echo ($unidade->active == true ? '<span class="text-success">Ativo</span>' : '<span class="text-danger">Inativo</span>'); ?>
                                        </p>
                                        <p>
                                            <strong>Criação:</strong> <?php echo formatDateTime($unidade->created_at); ?>
                                        </p>
                                        <p>
                                            <strong>Últ. Atualização:</strong> <?php echo formatDateTime($unidade->updated_at); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </header>
                    </section>
                </div>
            </div>