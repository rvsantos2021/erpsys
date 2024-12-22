                <?php echo form_open('/', ['id' => 'form', 'class' => 'form-validate'], ['id' => "$table->id"]); ?>
                <input type="hidden" name="method" value="<?php echo $method; ?>" />
                <?php echo $this->include($viewpath.'/_form'); ?>
                <?php echo form_close(); ?>