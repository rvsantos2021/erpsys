<?= $this->extend('/mentor/layout/main') ?>

<?= $this->section('title'); ?>
<?= APP_NAME . ' - ' . APP_VERSION . ' - ' . $title; ?>
<?= $this->endSection(); ?>

<?= $this->section('styles'); ?>
<?= $this->endSection(); ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        
                    </div>
                    <div class="col-auto">
                        <button type="button" data-bs-toggle="modal" data-bs-target="#modalCadastro" class="btn btn-sm btn-square btn-inverse-success fixed-button-width float-right btn-add"">
                            <i class="ti ti-plus"></i> Nova conta
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form id="formFiltro" class="mb-4">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label">Período de Emissão</label>
                            <div class="input-group">
                                <input type="date" name="data_emissao_inicio" class="form-control">
                                <span class="input-group-text">até</span>
                                <input type="date" name="data_emissao_fim" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Fornecedor</label>
                            <select name="fornecedor_id" class="js-basic-single form-control form-select">
                                <option value="">Todos</option>
                                <?php foreach($fornecedores as $fornecedor): ?>
                                    <option value="<?= $fornecedor->id ?>"><?= $fornecedor->razao_social ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="js-basic-single form-control form-select">
                                <option value="">Todos</option>
                                <option value="PENDENTE">Pendente</option>
                                <option value="PARCIAL">Parcial</option>
                                <option value="PAGO">Pago</option>
                                <option value="CANCELADO">Cancelado</option>
                            </select>
                        </div>
                        <div class="col-md-3 align-self-end">
                            <button type="button" class="btn btn-secondary" id="btnFiltrar">
                                <i class="ti ti-filter"></i> Filtrar
                            </button>
                            <button type="button" class="btn btn-outline-secondary" id="btnLimparFiltro">
                                <i class="ti ti-refresh"></i> Limpar
                            </button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table id="datatableContasPagar" class="table mb-0" style="width: 100%;">
                        <thead class="thead-light">
                            <tr>
                                <th>Documento</th>
                                <th>Fornecedor</th>
                                <th>Valor</th>
                                <th>Vencimento</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot class="thead-light">
                            <tr>
                                <th>Documento</th>
                                <th>Fornecedor</th>
                                <th>Valor</th>
                                <th>Vencimento</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Cadastro -->
<div class="modal fade" id="modalCadastro" tabindex="-1" role="dialog" aria-labelledby="modalForm" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" id="modalCadastroContent"></div>
    </div>
</div>

<!-- Modal Edição -->
<div class="modal fade" id="modalEdicao" tabindex="-1" role="dialog" aria-labelledby="modalForm" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" id="modalEdicaoContent"></div>
    </div>
</div>

<!-- Modal Baixa -->
<div class="modal fade" id="modalBaixa" tabindex="-1" role="dialog" aria-labelledby="modalForm" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" id="modalBaixaContent"></div>
    </div>
</div>

<!-- Modal Upload -->
<div class="modal fade" id="modalUpload" tabindex="-1" role="dialog" aria-labelledby="modalForm" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" id="modalUploadContent"></div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<!-- Máscara de input -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/inputmask/5.0.6/jquery.inputmask.min.js"></script>
<!-- custom app -->
<script src="<?= site_url('mentor/assets/'); ?>js/financeiro/contas-pagar.js"></script>
<script src="<?= site_url('mentor/assets/'); ?>js/common.js" data-route="contaspagar"></script>
<?= $this->endSection() ?>