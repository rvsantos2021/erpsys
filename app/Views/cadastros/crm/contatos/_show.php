            <div class="modal-wrapper-custom">
                <div class="col-lg-12">
                    <section class="panel panel-group">
                        <header>
                            <div class="widget-profile-info">
                                <div class="profile-picture">
                                    <img src="<?php echo site_url('assets/images/avatar-user.png'); ?>">
                                </div>
                                <div class="profile-info">
                                    <h4 class="name text-semibold"><?php echo $contato->nome; ?></h4>
                                    <h5 class="name text-warning text-semibold"><?php echo esc($contato->cargo); ?></h5>
                                    <h6 class="name"><?php echo esc($contato->email); ?></h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Celular:</strong> <?php echo $contato->celular; ?>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <strong>Telefone</strong> <?php echo $contato->telefone; ?>
                                        </div>
                                    </div>
                                    <div class="profile-footer">
                                        <p>
                                            <span>
                                                <strong>Status:</strong> <?php echo ($contato->active == true ? '<span class="text-success">Ativo</span>' : '<span class="text-danger">Inativo</span>'); ?>
                                            </span>
                                        </p>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Criação:</strong> <?php echo formatDateTime($contato->created_at); ?>
                                        </div>
                                        <div class="col-md-6 text-right">
                                            <strong>Últ. Atualização:</strong> <?php echo formatDateTime($contato->updated_at); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </header>
                    </section>
                </div>
            </div>