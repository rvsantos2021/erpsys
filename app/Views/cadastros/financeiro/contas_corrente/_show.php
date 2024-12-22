            <div class="modal-wrapper-custom">
                <div class="col-lg-12">
                    <section class="panel panel-group">
                        <header>
                            <div class="widget-profile-info">
                                <div class="profile-picture">
                                    <img src="<?php echo site_url('assets/images/avatar-conta-corrente.png'); ?>">
                                </div>
                                <div class="profile-info">
                                    <h4 class="name text-semibold"><?php echo 'AGÊNCIA: ' . $conta->agencia . '- CONTA: ' . $conta->numero; ?></h4>
                                    <h5 class="name text-warning text-semibold"><?php echo $conta->descricao; ?></h5>
                                    <div class="profile-footer">
                                        <p>
                                            <strong>Status:</strong> <?php echo ($conta->active == true ? '<span class="text-success">Ativo</span>' : '<span class="text-danger">Inativo</span>'); ?>
                                        </p>
                                        <p>
                                            <strong>Criação:</strong> <?php echo formatDateTime($conta->created_at); ?>
                                        </p>
                                        <p>
                                            <strong>Últ. Atualização:</strong> <?php echo formatDateTime($conta->updated_at); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </header>
                    </section>
                </div>
            </div>