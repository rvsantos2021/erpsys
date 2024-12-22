        <div class="row">
            <div class="col-lg-12">
                <div class="block">
                    <div class="block-body">
                        <?php echo form_open_multipart('/', ['id' => 'form-photo'], ['produto_id' => "$produto->id"]) ?>
                        <section class="panel panel-group">
                            <header>
                                <div class="widget-profile-info">
                                    <div class="profile-picture">
                                        <img src="<?php echo site_url('assets/images/avatar-produto.png'); ?>">
                                    </div>
                                    <div class="profile-info">
                                        <h4 class="name text-semibold"><?php echo $produto->descricao; ?></h4>
                                        <div class="profile-footer"></div>
                                    </div>
                                    <input type="hidden" name="id" value="<?php echo $produto->id ?>" />
                                </div>
                                <div class="form-group">
                                    <label>Descrição</label>
                                    <input type="text" class="form-control input-sm" name="descricao" placeholder="Descrição" maxlength="50" />
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Imagem</label>
                                    <input type="file" name="photo" class="form-control input-sm" required />
                                </div>
                                <div class="form-group">
                                    <div class="checkbox-custom checkbox-warning">
                                        <input type="checkbox" name="destaque" />
                                        <label>Destaque</label>
                                    </div>
                                </div>
                            </header>
                        </section>
                        <?php echo form_close(); ?>
                        <div id="response_photo"></div>
                    </div>
                </div>
            </div>
        </div>