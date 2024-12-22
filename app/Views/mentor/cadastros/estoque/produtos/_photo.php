        <div class="row">
            <div class="col-lg-12">
                <div class="block">
                    <div class="block-body">
                        <?php echo form_open_multipart('/', ['id' => 'form-photo'], ['produto_id' => "$produto->id"]) ?>
                        <section class="panel panel-group">
                            <header>
                                <div class="mt-3">
                                    <h4 class="mb-1"><?php echo $produto->descricao; ?></h4>
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
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="destaque" name="destaque" <?php echo $produto->destaque == 1 ? 'checked' : ''; ?> />
                                        <label for="destaque" class="form-check-label">Destaque</label>
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