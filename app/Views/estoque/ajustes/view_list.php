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
            <button data-toggle="tooltip" data-original-title="Novo Ajuste" data-modulo="add" class="btn btn-xs btn-default btn-width-22 btn-add"><i class="fa fa-plus"></i></button>
            <button data-toggle="tooltip" data-original-title="Importar" data-modulo="import" class="btn btn-xs btn-info btn-width-22 btn-import"><i class="fas fa-file-code"></i></button>
        </div>
    </div>
    <div class="panel-body">
        <?php echo $this->include('layout/_messages'); ?>
        <?php $num = 0; ?>
        <?php foreach ($movimentos as $movimento): ?>
            <?php $num++; ?>
            <?php echo form_open('/estoque/ajustes/update', ['id' => 'form', 'class' => 'form-validate'], ['id' => "$movimento->id"]) ?>
            <section id="<?= "mov_{$movimento->id}" ?>" class="panel panel-featured panel-featured-warning">
                <header class="panel-heading">
                    <h5 class="m-0 text-dark">
                        PRODUTO Nº <?= $num ?>
                    </h5>
                </header>
                <div class="panel-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label>Descrição</label>
                            <input type="text" class="form-control input-sm" name="produto_descricao" value="<?= $movimento->produto_descricao ?>" disabled />
                        </div>
                        <?php if ($movimento->produto_id == 0): ?>
                            <div class="col-md-5">
                                <label class="text-danger">Produto não encontrado! Selecione abaixo...</label>
                                <select data-plugin-selectTwo class="form-control input-sm" name="produto_id" data-plugin-options='{ "placeholder": "Selecione o Tipo", "allowClear": false }' required>
                                    <option value="" selected="">-- Selecione --</option>
                                    <?php foreach ($produtos as $produto): ?>
                                        <option value="<?= $produto->id ?>" <?= ($movimento->produto_id === $produto->id ? 'selected' : ''); ?>><?= $produto->descricao ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-1">
                                <a href="/estoque/ajustes/del/<?= $movimento->id ?>" class="btn btn-sm btn-default text-danger mt-26 float-right btn-del-pro"><i class="fas fa-trash"></i></a>
                            </div>
                            <?php $apto = false ?>
                        <?php else: ?>
                            <div class="col-md-2">
                                <label>Código de Barras</label>
                                <input type="text" class="form-control input-sm" name="codigo_barras" value="<?= $movimento->codigo_barras ?>" disabled />
                            </div>
                            <div class="col-md-2">
                                <label>Referência</label>
                                <input type="text" class="form-control input-sm" name="referencia" value="<?= $movimento->referencia ?>" disabled />
                            </div>
                            <div class="col-md-2">
                                <label>Código NCM</label>
                                <input type="text" class="form-control input-sm" name="codigo_ncm" value="<?= $movimento->codigo_ncm ?>" disabled />
                            </div>
                            <input type="hidden" name="produto_id" value="<?= $movimento->produto_id ?>" />
                            <?php if (($movimento->tipo_movimento_id == 0) || ($movimento->deposito_id == 0) || ($movimento->quantidade == 0)): ?>
                                <?php $apto = false ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-2">
                            <label>Tipo de Ajuste</label>
                            <select data-plugin-selectTwo class="form-control input-sm" name="tipo_movimento_id" data-plugin-options='{ "placeholder": "Selecione o Tipo", "allowClear": false }' required>
                                <option value="" selected="">-- Selecione --</option>
                                <?php foreach ($tipos as $tipo): ?>
                                    <option value="<?= $tipo->id ?>" <?= ($movimento->tipo_movimento_id === $tipo->id ? 'selected' : ''); ?>><?= $tipo->descricao ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Depósito</label>
                            <select data-plugin-selectTwo class="form-control input-sm" name="deposito_id" data-plugin-options='{ "placeholder": "Selecione o Tipo", "allowClear": false }' required>
                                <option value="" selected="">-- Selecione --</option>
                                <?php foreach ($depositos as $deposito): ?>
                                    <option value="<?= $deposito->id ?>" <?= ($movimento->deposito_id === $deposito->id ? 'selected' : ''); ?>><?= $deposito->descricao ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <label>Quantidade</label>
                            <input type="text" class="form-control input-sm text-right" name="quantidade" value="<?= formatPercent($movimento->quantidade, false, 4) ?>" required />
                        </div>
                        <div class="col-md-5">
                        </div>
                        <div class="col-md-1">
                            <?php if ($movimento->produto_id != 0): ?>
                                <a href="/estoque/ajustes/del/<?= $movimento->id ?>" class="btn btn-sm btn-default text-danger mt-26 float-right btn-del-pro"><i class="fas fa-trash"></i></a>
                            <?php endif; ?>
                            <button type="submit" class="btn btn-sm btn-default text-success mt-26 float-right"><i class="fas fa-check"></i></button>
                        </div>
                    </div>
                </div>
            </section>
            <?php echo form_close(); ?>
        <?php endforeach ?>
        <div class="form-group row">
            <div class="col-md-12" style="text-align: right">
                <button type="button" class="btn btn-success" onclick="window.location.href = '/estoque/ajustes/complete'" <?= (isset($apto)) ? 'disabled' : '' ?>><i class="fas fa-save"></i> Finalizar</button>
            </div>
        </div>
    </div>
</section>
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
<script src="<?php echo site_url('assets/'); ?>javascripts/custom/common.js" data-route="ajustes"></script>
<script src="<?php echo site_url('assets/'); ?>javascripts/custom/estoque/ajustes.js"></script>
<?php echo $this->endSection(); ?>