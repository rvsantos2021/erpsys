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
                <a href="<?= site_url('/clientes/add'); ?>" data-toggle="tooltip" data-original-title="Incluir Cliente" data-modulo="add" class="btn btn-sm btn-square btn-inverse-success fixed-button-width float-right">
                    <i class="ti ti-plus"></i> Incluir
                </a>
            </div>
            <div class="card-body">
                <div class="table-wrapper table-responsive">
                    <table id="datatable" class="table mb-0" style="width: 100%;">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="col-1">ID</th>
                                <th scope="col">Nome / Razão Social</th>
                                <th scope="col">Apelido / Nome Fantasia</th>
                                <th scope="col" class="col-2">CPF / CNPJ</th>
                                <th scope="col" class="text-center col-1">E-mail</th>
                                <th scope="col" class="text-center col-1">Status</th>
                                <th scope="col" class="text-center col-1">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot class="thead-light">
                            <tr>
                                <th scope="col" class="col-1">ID</th>
                                <th scope="col">Nome / Razão Social</th>
                                <th scope="col">Apelido / Nome Fantasia</th>
                                <th scope="col" class="col-2">CPF / CNPJ</th>
                                <th scope="col" class="text-center col-1">E-mail</th>
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

<!-- begin modalView -->
<div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-labelledby="modalView" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="min-width: 80%">
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
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<!-- custom app -->
<script src="<?= site_url('mentor/assets/'); ?>js/cadastros/clientes.js"></script>
<script src="<?= site_url('mentor/assets/'); ?>js/common.js" data-route="clientes"></script>
<?= $this->endSection(); ?>