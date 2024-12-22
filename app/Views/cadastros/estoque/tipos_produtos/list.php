<?php echo $this->section('scripts'); ?>
<?php echo $this->endSection(); ?>

<?php echo $this->extend('layout/main'); ?>

<?php echo $this->section('title'); ?>
<?php echo APP_NAME . ' - ' . APP_VERSION . ' - ' . $title; ?>
<?php echo $this->endSection(); ?>

<?php echo $this->section('styles'); ?>
<link rel="stylesheet" href="<?php echo site_url('assets/'); ?>vendor/jquery-datatables-bs3/assets/css/datatables.css" />
<link rel="stylesheet" href="<?php echo site_url('assets/'); ?>stylesheets/datatables/buttons.dataTables.css" />
<link rel="stylesheet" href="<?php echo site_url('assets/'); ?>stylesheets/datatables/dataTables.css" />
<link rel="stylesheet" href="<?php echo site_url('assets/'); ?>vendor/pnotify/pnotify.custom.css" />
<?php echo $this->endSection(); ?>

<?php echo $this->section('content'); ?>
<section class="panel panel-featured panel-featured-custom">
    <div class="panel-heading">
        <h2 class="panel-title"><?php echo $title; ?></h2>
        <div class='panel-actions'>
            <button data-toggle="tooltip" data-original-title="Novo Tipo de Produto" data-modulo="add" class="btn btn-xs btn-default btn-add"><i class="fa fa-plus"></i></button>
        </div>
    </div>
    <div class="panel-body">
        <table class="table table-hover table-responsive mb-none" id="table-list" style="width: 100%;">
            <thead class="panel-featured panel-featured-custom text-custom">
                <tr>
                    <th class="col-xs-1">ID</th>
                    <th>DESCRIÇÃO</th>
                    <th class="center col-xs-1">PRODUTO</th>
                    <th class="center col-xs-1">SERVIÇO</th>
                    <th class="center col-xs-1">MAT. PRIMA</th>
                    <th class="center col-xs-1">STATUS</th>
                    <th class="center col-xs-1">AÇÕES</th>
                </tr>
            </thead>
            <tfoot class="panel-featured panel-featured-custom text-custom">
                <tr>
                </tr>
            </tfoot>
        </table>
    </div>
</section>

<!-- begin modalView -->
<div class="modal fade modal-header-color modal-block-warning" role="dialog" id="modalView" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="min-width: 35%">
        <?= $this->include('layout/modals/_modalview') ?>
    </div>
</div>
<!-- end modalView -->

<!-- begin modalForm -->
<div class="modal fade modal-header-color modal-block-warning" role="dialog" id="modalForm" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="min-width: 40%">
        <?= $this->include('layout/modals/_modalform') ?>
    </div>
</div>
<!-- end modalForm -->

<!-- begin modalDelete -->
<div class="modal fade modal-header-color modal-block-warning" role="dialog" id="modalDelete" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="min-width: 30%">
        <?= $this->include('layout/modals/_modaldelete') ?>
    </div>
</div>
<!-- end modalDelete -->
<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<script src="<?php echo site_url('assets/'); ?>javascripts/tables/jquery.dataTables.min.js"></script>
<script src="<?php echo site_url('assets/'); ?>javascripts/tables/dataTables.buttons.min.js"></script>
<script src="<?php echo site_url('assets/'); ?>javascripts/tables/buttons/buttons.flash.min.js"></script>
<script src="<?php echo site_url('assets/'); ?>javascripts/tables/ajax/jszip.min.js"></script>
<script src="<?php echo site_url('assets/'); ?>javascripts/tables/ajax/pdfmake.min.js"></script>
<script src="<?php echo site_url('assets/'); ?>javascripts/tables/ajax/vfs_fonts.js"></script>
<script src="<?php echo site_url('assets/'); ?>javascripts/tables/buttons/buttons.html5.min.js"></script>
<script src="<?php echo site_url('assets/'); ?>javascripts/tables/buttons/buttons.print.min.js"></script>
<script src="<?php echo site_url('assets/'); ?>vendor/jquery-datatables-bs3/assets/js/datatables.js"></script>
<script src="<?php echo site_url('assets/'); ?>vendor/jquery-autosize/jquery.autosize.js"></script>
<script src="<?php echo site_url('assets/'); ?>vendor/jquery-validation/jquery.validate.js"></script>
<script src="<?php echo site_url('assets/'); ?>vendor/loadingoverlay/loadingoverlay.min.js"></script>
<script src="<?php echo site_url('assets/'); ?>vendor/pnotify/pnotify.custom.js"></script>
<script src="<?php echo site_url('assets/'); ?>javascripts/custom/common.js" data-route="tiposproduto"></script>
<script src="<?php echo site_url('assets/'); ?>javascripts/custom/tipos_produto.js"></script>
<?php echo $this->endSection(); ?>