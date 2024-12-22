        <div class="row">
            <div class="col-lg-12">
                <div class="block">
                    <div class="block-body">
                        <?php echo form_open('/', ['id' => 'form-comp'], ['produto_id' => "$produto->id"]) ?>
                        <section class="panel panel-group">
                            <header>
                                <div class="mt-3">
                                    <h4 class="mb-1"><?php echo $produto->descricao; ?></h4>
                                    <input type="hidden" name="id" value="<?php echo $produto->id ?>" />
                                </div>
                            </header>
                        </section>
                        <?php echo form_close(); ?>
                        <div id="response_comp"></div>
                    </div>
                </div>
            </div>
        </div>