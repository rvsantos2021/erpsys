<?= $this->extend('/mentor/layout/main'); ?>

<?= $this->section('title'); ?>
<?= APP_NAME . ' - ' . APP_VERSION . ' - ' . $title; ?>
<?= $this->endSection(); ?>

<?= $this->section('styles'); ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<!-- begin row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card card-statistics">
            <div class="card-header">
                <a href="<?= site_url('/fornecedores'); ?>" data-toggle="tooltip" data-original-title="Voltar" class="btn btn-sm btn-square btn-inverse-primary fixed-button-width float-right">
                    <i class="ti ti-arrow-left"></i> Voltar
                </a>
            </div>
            <div class="card-body">
                <?php echo form_open('/', ['id' => 'form', 'class' => 'form-validate'], ['id' => "$table->id"]) ?>
                <input type="hidden" name="method" value="<?= $method; ?>" />
                <?php echo $this->include('mentor/cadastros/fornecedores/_form'); ?>
                <?php echo form_close(); ?>
            </div>
            <div class="card-footer">
                <div class="float-right">
                    <button type="button" class="btn btn-sm btn-square btn-inverse-success fixed-button-width confirm-form">
                        <i class="ti ti-save"></i> Salvar
                    </button>
                    <a href="<?= site_url('/fornecedores'); ?>" data-toggle="tooltip" data-original-title="Voltar" class="btn btn-sm btn-square btn-inverse-primary fixed-button-width">
                        <i class="ti ti-arrow-left"></i> Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<!-- custom app -->
<script src="<?= site_url('mentor/assets/'); ?>js/cadastros/fornecedores.js"></script>
<script src="<?= site_url('mentor/assets/'); ?>js/common.js" data-route="fornecedores"></script>
<?= $this->endSection(); ?>