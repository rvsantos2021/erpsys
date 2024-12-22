            <div class="modal-wrapper-custom">
                <div class="col-lg-12">
                    <h4 class="text-success text-semibold">Confirma o restore da empresa?</h4>
                    <section class="panel panel-group">
                        <header>
                            <div class="widget-profile-info">
                                <div class="profile-picture">
                                    <img src="<?php echo site_url('assets/images/avatar-empresa.png'); ?>">
                                </div>
                                <div class="profile-info">
                                    <h4 class="name text-semibold"><?php echo $empresa->razao_social; ?></h4>
                                    <h5 class="name text-warning text-semibold"><?php echo esc($empresa->nome_fantasia); ?></h5>
                                    <div class="profile-footer">
                                        <p>
                                            <strong>Excluído em:</strong> <?php echo formatDateTime($empresa->deleted_at); ?>
                                        </p>
                                    </div>
                                </div>
                                <input type="hidden" name="id" value="<?php echo $empresa->id ?>" />
                                <input type="hidden" name="method_del" value="restore" />
                            </div>
                        </header>
                    </section>
                </div>
            </div>