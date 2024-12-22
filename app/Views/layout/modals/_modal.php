        <div class="panel-body">
            <div class="modal-wrapper-custom">
                <?= form_open('/', ['id' => 'form', 'class' => 'form-validate'], ['id' => "$table->id"]) ?>
                <input type="hidden" name="method" value="<?= $method; ?>" />
                <?= $this->include($viewpath . '/_form'); ?>
                <?= form_close(); ?>
            </div>
        </div>