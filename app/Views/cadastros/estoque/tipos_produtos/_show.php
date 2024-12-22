            <div class="modal-wrapper-custom">
                <div class="col-lg-12">
                    <section class="panel panel-group">
                        <header>
                            <div class="widget-profile-info">
                                <div class="profile-picture">
                                    <img src="<?php echo site_url('assets/images/avatar-tipo-produto.png'); ?>">
                                </div>
                                <div class="profile-info">
                                    <h4 class="name text-semibold"><?php echo $tipo->descricao; ?></h4>
                                    <div class="profile-footer">
                                        <p class="text-left">
                                            <strong>Produto:</strong> <?php echo ($tipo->produto == true ? '<span class="text-success">Sim</span>' : '<span class="text-danger">Não</span>'); ?>
                                        </p>
                                        <p class="text-left">
                                            <strong>Serviço:</strong> <?php echo ($tipo->servico == true ? '<span class="text-success">Sim</span>' : '<span class="text-danger">Não</span>'); ?>
                                        </p>
                                        <p class="text-left">
                                            <strong>Matéria-prima:</strong> <?php echo ($tipo->materia_prima == true ? '<span class="text-success">Sim</span>' : '<span class="text-danger">Não</span>'); ?>
                                        </p>
                                        <hr />
                                        <p>
                                            <strong>Status:</strong> <?php echo ($tipo->active == true ? '<span class="text-success">Ativo</span>' : '<span class="text-danger">Inativo</span>'); ?>
                                        </p>
                                        <p>
                                            <strong>Criação:</strong> <?php echo formatDateTime($tipo->created_at); ?>
                                        </p>
                                        <p>
                                            <strong>Últ. Atualização:</strong> <?php echo formatDateTime($tipo->updated_at); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </header>
                    </section>
                </div>
            </div>