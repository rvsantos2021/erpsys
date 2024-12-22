        <div class="row">
            <div class="col-lg-12">
                <div class="block">
                    <div class="block-body">
                        <?php echo form_open_multipart('/', ['id' => 'form-photo'], ['id' => "$user->id"]) ?>
                        <input type="hidden" name="method" value="upload" />
                        <div class="form-group">
                            <h5 class="card-title text-primary"><?php echo $user->name; ?></h5>
                        </div>
                        <div class="form-group">
                            <a href="mailto:<?php echo esc($user->email); ?>" target="_blank"><?php echo esc($user->email); ?></a>
                        </div>
                        <hr class="border-secondary" />
                        <div class="form-group">
                            <label class="form-control-label">Imagem</label>
                            <input type="file" name="photo" class="form-control" required />
                            <div class="invalid-feedback">É necessário escolher uma imagem.</div>
                        </div>
                        <?php echo form_close(); ?>
                        <div id="response_photo"></div>
                    </div>
                </div>
            </div>
        </div>