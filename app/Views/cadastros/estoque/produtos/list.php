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
            <button data-toggle="tooltip" data-original-title="Novo Produto" data-modulo="add" class="btn btn-xs btn-default btn-add"><i class="fa fa-plus"></i></button>
            <button data-toggle="tooltip" data-original-title="Importar XML" data-modulo="import" class="btn btn-xs btn-info btn-width-22 btn-import"><i class="fas fa-file-code"></i></button>
        </div>
    </div>
    <div class="panel-body">
        <?php echo $this->include('layout/_messages'); ?>
        <table class="table table-hover table-responsive mb-none" id="table-list" style="width: 100%;">
            <thead class="panel-featured panel-featured-custom text-custom">
                <tr>
                    <th class="col-xs-1">ID</th>
                    <th class="col-xs-1">CÓDIGO NCM</th>
                    <th class="col-xs-1">REFERÊNCIA</th>
                    <th>DESCRIÇÃO</th>
                    <th class="center col-xs-1">FOTO</th>
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
    <div class="modal-dialog modal-dialog-centered" style="min-width: 40%">
        <?= $this->include('layout/modals/_modalview') ?>
    </div>
</div>
<!-- end modalView -->

<!-- begin modalForm -->
<div class="modal fade modal-header-color modal-block-warning" role="dialog" id="modalForm" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="min-width: 60%">
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

<!-- begin modalImport -->
<div class="modal fade modal-header-color modal-block-warning" role="dialog" id="modalImport" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="min-width: 30%">
        <?= $this->include('layout/modals/_modalimport') ?>
    </div>
</div>
<!-- end modalImport -->

<!-- begin modalPhoto -->
<div class="modal fade modal-header-color modal-block-warning" role="dialog" id="modalPhoto" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="min-width: 35%">
        <section class="panel">
            <header class="panel-heading">
                <h2 class="panel-title" id="modalPhotoLabel"></h2>
            </header>
            <div class="panel-body modal-body-photo">
            </div>
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-warning fixed-button-width modal-confirm-photo">Salvar</button>
                        <button type="button" class="btn btn-default fixed-button-width modal-dismiss-photo" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </footer>
        </section>
    </div>
</div>
<!-- end modalPhoto -->

<!-- begin modalViewPhoto -->
<div class="modal fade modal-header-color modal-block-warning" role="dialog" id="modalViewPhoto" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="min-width: 35%">
        <section class="panel">
            <header class="panel-heading">
                <h2 class="panel-title" id="modalViewPhotoLabel"></h2>
            </header>
            <div class="panel-body modal-body-view-photo">
            </div>
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-default fixed-button-width modal-dismiss-photo" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </footer>
        </section>
    </div>
</div>
<!-- end modalViewPhoto -->

<!-- begin modalAddUnidade -->
<div class="modal modal-unidade fade modal-header-color modal-block-warning" role="dialog" id="modalAddUnidade" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="min-width: 35%">
        <section class="panel">
            <header class="panel-heading">
                <h2 class="panel-title" id="modalAddUnidadeLabel"></h2>
            </header>
            <div class="panel-body modal-body-add-unidade">
            </div>
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-warning fixed-button-width modal-confirm-unidade">Salvar</button>
                        <button type="button" class="btn btn-default fixed-button-width modal-dismiss-unidade" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </footer>
        </section>
    </div>
</div>
<!-- end modalAddUnidade -->

<!-- begin modalAddMarca -->
<div class="modal modal-marca fade modal-header-color modal-block-warning" role="dialog" id="modalAddMarca" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="min-width: 35%">
        <section class="panel">
            <header class="panel-heading">
                <h2 class="panel-title" id="modalAddMarcaLabel"></h2>
            </header>
            <div class="panel-body modal-body-add-marca">
            </div>
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-warning fixed-button-width modal-confirm-marca">Salvar</button>
                        <button type="button" class="btn btn-default fixed-button-width modal-dismiss-marca" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </footer>
        </section>
    </div>
</div>
<!-- end modalAddMarca -->

<!-- begin modalAddModelo -->
<div class="modal modal-modelo fade modal-header-color modal-block-warning" role="dialog" id="modalAddModelo" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="min-width: 35%">
        <section class="panel">
            <header class="panel-heading">
                <h2 class="panel-title" id="modalAddModeloLabel"></h2>
            </header>
            <div class="panel-body modal-body-add-modelo">
            </div>
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-warning fixed-button-width modal-confirm-modelo">Salvar</button>
                        <button type="button" class="btn btn-default fixed-button-width modal-dismiss-modelo" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </footer>
        </section>
    </div>
</div>
<!-- end modalAddModelo -->

<!-- begin modalAddGrupo -->
<div class="modal modal-grupo fade modal-header-color modal-block-warning" role="dialog" id="modalAddGrupo" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="min-width: 35%">
        <section class="panel">
            <header class="panel-heading">
                <h2 class="panel-title" id="modalAddGrupoLabel"></h2>
            </header>
            <div class="panel-body modal-body-add-grupo">
            </div>
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-warning fixed-button-width modal-confirm-grupo">Salvar</button>
                        <button type="button" class="btn btn-default fixed-button-width modal-dismiss-grupo" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </footer>
        </section>
    </div>
</div>
<!-- end modalAddGrupo -->

<!-- begin modalAddSecao -->
<div class="modal modal-secao fade modal-header-color modal-block-warning" role="dialog" id="modalAddSecao" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="min-width: 35%">
        <section class="panel">
            <header class="panel-heading">
                <h2 class="panel-title" id="modalAddSecaoLabel"></h2>
            </header>
            <div class="panel-body modal-body-add-secao">
            </div>
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-warning fixed-button-width modal-confirm-secao">Salvar</button>
                        <button type="button" class="btn btn-default fixed-button-width modal-dismiss-secao" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </footer>
        </section>
    </div>
</div>
<!-- end modalAddSecao -->

<!-- begin modalAddTabela -->
<div class="modal modal-tabela fade modal-header-color modal-block-warning" role="dialog" id="modalAddTabela" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="min-width: 35%">
        <section class="panel">
            <header class="panel-heading">
                <h2 class="panel-title" id="modalAddTabelaLabel"></h2>
            </header>
            <div class="panel-body modal-body-add-tabela">
            </div>
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-warning fixed-button-width modal-confirm-tabela">Salvar</button>
                        <button type="button" class="btn btn-default fixed-button-width modal-dismiss-tabela" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </footer>
        </section>
    </div>
</div>
<!-- end modalAddTabela -->

<!-- begin modalAddFornecedor -->
<div class="modal modal-fornecedor fade modal-header-color modal-block-warning" role="dialog" id="modalAddFornecedor" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="min-width: 66%">
        <section class="panel">
            <header class="panel-heading">
                <h2 class="panel-title" id="modalAddFornecedorLabel"></h2>
            </header>
            <div class="panel-body modal-body-add-fornecedor">
            </div>
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-warning fixed-button-width modal-confirm-fornecedor">Salvar</button>
                        <button type="button" class="btn btn-default fixed-button-width modal-dismiss-fornecedor" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </footer>
        </section>
    </div>
</div>
<!-- end modalAddFornecedor -->
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
<script src="<?php echo site_url('assets/'); ?>javascripts/custom/common.js" data-route="produtos"></script>
<script src="<?php echo site_url('assets/'); ?>javascripts/custom/estoque/produtos.js"></script>
<script src="<?php echo site_url('assets/'); ?>javascripts/ui-elements/examples.lightbox.js"></script>
<?php echo $this->endSection(); ?>