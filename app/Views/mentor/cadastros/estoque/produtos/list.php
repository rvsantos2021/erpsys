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
                <a href="<?php echo site_url('/produtos/add'); ?>" data-toggle="tooltip" data-original-title="Incluir Produto" data-modulo="add" class="btn btn-sm btn-square btn-inverse-success fixed-button-width float-right">
                    <i class="ti ti-plus"></i> Incluir
                </a>
                <button data-toggle="tooltip" data-original-title="Importar XML" data-modulo="import" class="btn btn-sm btn-square btn-inverse-info fixed-button-width float-right btn-import">
                    <i class="ti ti-import"></i> Importar
                </button>
            </div>
            <div class="card-body">
                <div class="table-wrapper table-responsive">
                    <table id="datatable" class="table mb-0" style="width: 100%;">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col" class="col-1">ID</th>
                                <th scope="col" class="col-1">Código NCM</th>
                                <th scope="col" class="col-1">Referência</th>
                                <th scope="col">Descrição</th>
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
                                <th scope="col" class="col-1">Código NCM</th>
                                <th scope="col" class="col-1">Referência</th>
                                <th scope="col">Descrição</th>
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

<!-- begin modalView -->
<div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-labelledby="modalView" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document" style="min-width: 80%">
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

<!-- begin modalPhoto -->
<div class="modal fade" id="modalPhoto" tabindex="-1" role="dialog" aria-labelledby="modalPhoto" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="min-width: 35%">
        <div class="modal-content">
            <div class="modal-header table-primary">
                <h4 class="modal-title text-primary" id="modalPhotoLabel"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal-body-photo">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-square btn-inverse-success fixed-button-width modal-confirm-photo">Salvar</button>
                <button type="button" class="btn btn-square btn-inverse-primary fixed-button-width modal-dismiss-photo" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<!-- end modalPhoto -->

<!-- begin modalImport -->
<div class="modal fade" id="modalImport" tabindex="-1" role="dialog" aria-labelledby="modalImport" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <?php echo $this->include('mentor/layout/modals/_modalimport'); ?>
    </div>
</div>
<!-- end modalImport -->

<!-- begin modalComposicao -->
<div class="modal fade" id="modalComposicao" tabindex="-1" role="dialog" aria-labelledby="modalComposicao" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header table-primary">
                <h4 class="modal-title text-primary" id="modalComposicaoLabel"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body modal-body-comp">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-square btn-inverse-success fixed-button-width modal-confirm-comp">Salvar</button>
                <button type="button" class="btn btn-square btn-inverse-primary fixed-button-width modal-dismiss-comp" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
<!-- end modalComposicao -->
<?php echo $this->endSection(); ?>

<?php echo $this->section('scripts'); ?>
<!-- custom app -->
<script src="<?php echo site_url('mentor/assets/'); ?>js/estoque/produtos.js"></script>
<script src="<?php echo site_url('mentor/assets/'); ?>js/common.js" data-route="produtos"></script>
<?php echo $this->endSection(); ?>