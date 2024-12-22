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
                <button data-toggle="tooltip" data-original-title="Incluir Depósito" data-modulo="add" class="btn btn-sm btn-square btn-inverse-success fixed-button-width float-right btn-add">
                    <i class="ti ti-plus"></i> Incluir
                </button>
            </div>
            <div class="card-body">
                <div class="table-wrapper table-responsive">
                    <table id="datatable" class="table mb-0" style="width: 100%;">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="col-1">ID</th>
                                <th scope="col">Descrição</th>
                                <th scope="col" class="text-center col-1">Status</th>
                                <th scope="col" class="text-center col-1">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot class="thead-light">
                            <tr>
                                <th scope="col" class="col-1">ID</th>
                                <th scope="col">Descrição</th>
                                <th scope="col" class="text-center col-1">Status</th>
                                <th scope="col" class="text-center col-1">Ações</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end row -->

<!-- begin modalForm -->
<div class="modal fade" id="modalForm" tabindex="-1" role="dialog" aria-labelledby="modalForm" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <?php echo $this->include('mentor/layout/modals/_modalform'); ?>
    </div>
</div>
<!-- end modalForm -->

<!-- begin modalView -->
<div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-labelledby="modalView" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="min-width: 50%">
        <?php echo $this->include('mentor/layout/modals/_modalview'); ?>
    </div>
</div>
<!-- end modalView -->

<!-- begin modalDelete -->
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDelete" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <?php echo $this->include('mentor/layout/modals/_modaldelete'); ?>
    </div>
</div>
<!-- end modalDelete -->
<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<!-- custom app -->
<script src="<?php echo site_url('mentor/assets/'); ?>js/estoque/depositos.js"></script>
<script src="<?php echo site_url('mentor/assets/'); ?>js/common.js" data-route="depositos"></script>
<?php echo $this->endSection(); ?>