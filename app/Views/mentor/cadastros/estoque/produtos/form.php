<?php echo $this->extend('/mentor/layout/main'); ?>

<?php echo $this->section('title'); ?>
<?php echo APP_NAME.' - '.APP_VERSION.' - '.$title; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('styles'); ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>
<!-- begin row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card card-statistics">
            <div class="card-header">
                <a href="<?php echo site_url('/estoque/produtos'); ?>" data-toggle="tooltip" data-original-title="Voltar" class="btn btn-sm btn-square btn-inverse-primary fixed-button-width float-right">
                    <i class="ti ti-arrow-left"></i> Voltar
                </a>
            </div>
            <div class="card-body">
                <?php echo form_open('/', ['id' => 'form', 'class' => 'form-validate'], ['id' => "$table->id"]); ?>
                <input type="hidden" name="method" value="<?php echo $method; ?>" />
                <?php echo $this->include('mentor/cadastros/estoque/produtos/_form'); ?>
                <?php echo form_close(); ?>
            </div>
            <div class="card-footer">
                <div class="float-right">
                    <button type="button" class="btn btn-sm btn-square btn-inverse-success fixed-button-width confirm-form">
                        <i class="ti ti-save"></i> Salvar
                    </button>
                    <a href="<?php echo site_url('/estoque/produtos'); ?>" data-toggle="tooltip" data-original-title="Voltar" class="btn btn-sm btn-square btn-inverse-primary fixed-button-width">
                        <i class="ti ti-arrow-left"></i> Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<!-- custom app -->
<script src="<?php echo site_url('mentor/assets/'); ?>js/estoque/produtos_form.js"></script>
<script src="<?php echo site_url('mentor/assets/'); ?>js/common.js" data-route="produtos"></script>
<?php echo $this->endSection(); ?>