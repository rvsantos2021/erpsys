            <div class="modal-wrapper-custom">
                <div class="col-lg-12">
                    <section class="panel panel-group">
                        <header>
                            <div class="widget-profile-info">
                                <div class="profile-picture">
                                    <img src="<?php echo site_url('assets/images/avatar-forma-pagamento.png'); ?>">
                                </div>
                                <div class="profile-info">
                                    <h4 class="name text-semibold"><?php echo $forma->nome; ?></h4>
                                    <div class="profile-footer">
                                        <p class="text-left">
                                            <strong>Gerar Movimento Financeiro:</strong> <?php echo ($forma->financeiro == true ? '<span class="text-success">Sim</span>' : '<span class="text-danger">Não</span>'); ?>
                                        </p>
                                        <p class="text-left">
                                            <strong>Permitir Desconto:</strong> <?php echo ($forma->desconto == true ? '<span class="text-success">Sim</span>' : '<span class="text-danger">Não</span>'); ?>
                                        </p>
                                        <p class="text-left">
                                            <strong>Disponibilizar no Contas a Pagar:</strong> <?php echo ($forma->contas_pagar == true ? '<span class="text-success">Sim</span>' : '<span class="text-danger">Não</span>'); ?>
                                        </p>
                                        <p class="text-left">
                                            <strong>Disponibilizar no Contas a Receber:</strong> <?php echo ($forma->contas_receber == true ? '<span class="text-success">Sim</span>' : '<span class="text-danger">Não</span>'); ?>
                                        </p>
                                        <hr />
                                        <p>
                                            <strong>Status:</strong> <?php echo ($forma->active == true ? '<span class="text-success">Ativo</span>' : '<span class="text-danger">Inativo</span>'); ?>
                                        </p>
                                        <p>
                                            <strong>Criação:</strong> <?php echo formatDateTime($forma->created_at); ?>
                                        </p>
                                        <p>
                                            <strong>Últ. Atualização:</strong> <?php echo formatDateTime($forma->updated_at); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </header>
                    </section>
                </div>
            </div>