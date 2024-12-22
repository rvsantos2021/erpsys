            <div class="modal-wrapper-custom">
                <div class="col-lg-12">
                    <h4 class="text-success text-semibold">Confirma o restore do Grupo Tributário?</h4>
                    <section class="panel panel-group">
                        <header>
                            <div class="widget-profile-info">
                                <div class="profile-picture">
                                    <img src="<?php echo site_url('assets/images/avatar-marca.png'); ?>">
                                </div>
                                <div class="profile-info">
                                    <h4 class="name text-semibold"><?php echo $grupo->cst . ' - ' . $grupo->descricao; ?></h4>
                                    <div class="profile-footer">
                                        <p>
                                            <strong>Excluído em:</strong> <?php echo formatDateTime($grupo->deleted_at); ?>
                                        </p>
                                    </div>
                                </div>
                                <input type="hidden" name="id" value="<?php echo $grupo->id ?>" />
                                <input type="hidden" name="method_del" value="restore" />
                            </div>
                        </header>
                    </section>
                </div>
            </div>

            <script src="<?php echo site_url('assets/'); ?>javascripts/theme.js"></script>
            <script src="<?php echo site_url('assets/'); ?>javascripts/theme.init.js"></script>
            <script src="<?php echo site_url('assets/'); ?>javascripts/forms/examples.validation.js"></script>