            <div class="modal-wrapper-custom">
                <div class="col-lg-12">
                    <h4 class="text-success text-semibold">Confirma o restore do Contato?</h4>
                    <section class="panel panel-group">
                        <header>
                            <div class="widget-profile-info">
                                <div class="profile-picture">
                                    <img src="<?php echo site_url('assets/images/avatar-user.png'); ?>">
                                </div>
                                <div class="profile-info">
                                    <h4 class="name text-semibold"><?php echo $contato->nome; ?></h4>
                                    <h5 class="name text-warning text-semibold"><?php echo esc($contato->razao_social); ?></h5>
                                    <div class="profile-footer">
                                        <p>
                                            <strong>Excluído em:</strong> <?php echo formatDateTime($contato->deleted_at); ?>
                                        </p>
                                    </div>
                                </div>
                                <input type="hidden" name="id" value="<?php echo $contato->id ?>" />
                                <input type="hidden" name="method_del" value="restore" />
                            </div>
                        </header>
                    </section>
                </div>
            </div>

            <script src="<?php echo site_url('assets/'); ?>javascripts/theme.js"></script>
            <script src="<?php echo site_url('assets/'); ?>javascripts/theme.init.js"></script>
            <script src="<?php echo site_url('assets/'); ?>javascripts/forms/examples.validation.js"></script>