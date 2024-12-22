            <div class="modal-wrapper-custom">
                <div class="col-lg-12">
                    <section class="panel panel-group">
                        <header>
                            <div class="widget-profile-info">
                                <div class="profile-picture">
                                    <img src="<?php echo site_url('assets/images/avatar-condicao-pagamento.png'); ?>">
                                </div>
                                <div class="profile-info">
                                    <h4 class="name text-semibold"><?php echo $condicao->nome; ?></h4>
                                    <div class="profile-footer">
                                        <div class="form-group row">
                                            <div class="col-md-4 text-left">
                                                <strong>Tabela de Preços</strong>
                                            </div>
                                            <div class="col-md-4 text-left">
                                                <strong>Exige perc. de entrada</strong>
                                            </div>
                                            <div class="col-md-4 text-left">
                                                <strong>Perc. de entrada</strong>
                                            </div>
                                            <div class="col-md-4 text-left">
                                                <?php echo $tabela[0]->descricao; ?>
                                            </div>
                                            <div class="col-md-4 text-left">
                                                <?php echo ($condicao->entrada == true ? '<span class="text-success">SIM</span>' : '<span class="text-danger">NÃO</span>'); ?>
                                            </div>
                                            <div class="col-md-4 text-left">
                                                <?php echo formatPercent($condicao->perc_entrada, true, 0); ?>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-4 text-left">
                                                <strong>Quantidade de parcelas</strong>
                                            </div>
                                            <div class="col-md-4 text-left">
                                                <strong>Dias 1ª parcela</strong>
                                            </div>
                                            <div class="col-md-4 text-left">
                                                <strong>Dias entre parcelas</strong>
                                            </div>
                                            <div class="col-md-4 text-left">
                                                <?php echo $condicao->qtd_parcelas; ?>
                                            </div>
                                            <div class="col-md-4 text-left">
                                                <?php echo $condicao->dias_parcela1; ?>
                                            </div>
                                            <div class="col-md-4 text-left">
                                                <?php echo $condicao->dias_parcelas; ?>
                                            </div>
                                        </div>
                                        <hr />
                                        <p>
                                            <strong>Status:</strong> <?php echo ($condicao->active == true ? '<span class="text-success">Ativo</span>' : '<span class="text-danger">Inativo</span>'); ?>
                                        </p>
                                        <p>
                                            <strong>Criação:</strong> <?php echo formatDateTime($condicao->created_at); ?>
                                        </p>
                                        <p>
                                            <strong>Últ. Atualização:</strong> <?php echo formatDateTime($condicao->updated_at); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </header>
                    </section>
                </div>
            </div>