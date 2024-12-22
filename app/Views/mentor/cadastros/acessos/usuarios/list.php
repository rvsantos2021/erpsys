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
                <button data-toggle="tooltip" data-original-title="Incluir Usuário" data-modulo="add" class="btn btn-sm btn-square btn-inverse-success fixed-button-width float-right btn-add">
                    <i class="ti ti-plus"></i> Incluir
                </button>
            </div>
            <div class="card-body">
                <div class="table-wrapper table-responsive">
                    <table id="datatable" class="table mb-0" style="width: 100%;">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="col-1">ID</th>
                                <th scope="col">Nome</th>
                                <th scope="col" class="text-center col-1">E-mail</th>
                                <th scope="col" class="text-center col-1">Foto</th>
                                <th scope="col" class="text-center col-1">Status</th>
                                <th scope="col" class="text-center col-1">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot class="thead-light">
                            <tr>
                                <th scope="col" class="col-1">ID</th>
                                <th scope="col">Nome</th>
                                <th scope="col" class="text-center col-1">E-mail</th>
                                <th scope="col" class="text-center col-1">Foto</th>
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
        <?= $this->include('mentor/layout/modals/_modalform') ?>
    </div>
</div>
<!-- end modalForm -->

<!-- begin modalView -->
<div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-labelledby="modalView" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <?= $this->include('mentor/layout/modals/_modalview') ?>
    </div>
</div>
<!-- end modalView -->

<!-- begin modalDelete -->
<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-labelledby="modalDelete" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <?= $this->include('mentor/layout/modals/_modaldelete') ?>
    </div>
</div>
<!-- end modalDelete -->

<!-- begin modalGroup -->
<div class="modal fade" id="modalGroup" tabindex="-1" role="dialog" aria-labelledby="modalGroup" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header table-primary">
                <h4 class="modal-title text-primary" id="modalGroupLabel"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal-body-group">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-square btn-inverse-success fixed-button-width modal-confirm-group">Salvar</button>
                <button type="button" class="btn btn-square btn-inverse-primary fixed-button-width modal-dismiss-group" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<!-- end modalGroup -->
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<!-- custom app -->
<script src="<?= site_url('mentor/assets/'); ?>js/cadastros/users.js"></script>
<script src="<?= site_url('mentor/assets/'); ?>js/common.js" data-route="usuarios"></script>
<?= $this->endSection(); ?>