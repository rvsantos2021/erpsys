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
                        <button type="button" data-bs-toggle="modal" data-bs-target="#modalCadastro" class="btn btn-sm btn-square btn-inverse-success fixed-button-width float-right btn-add">
                            <i class="ti ti-plus"></i> Nova conta
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form id="formFiltro" class="mb-4">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="form-label">Período de Vencimento</label>
                            <div class="input-group">
                                <input type="date" name="data_vencimento_inicio" class="form-control" value="<?= $filtro_data_inicio ?>" />
                                <span class="input-group-text">até</span>
                                <input type="date" name="data_vencimento_fim" class="form-control" value="<?= $filtro_data_fim ?>" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Cliente</label>
                            <select name="cliente_id" class="js-basic-single form-control form-select">
                                <option value="">Todos</option>
                                <?php foreach($clientes as $cliente): ?>
                                    <option value="<?= $cliente->id ?>">
                                        <?= $cliente->nome_fantasia === '' ? $cliente->razao_social : $cliente->nome_fantasia; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="js-basic-single form-control form-select">
                                <option value="">Todos</option>
                                <option value="PENDENTE">Pendente</option>
                                <option value="PARCIAL">Parcial</option>
                                <option value="RECEBIDO">Recebido</option>
                                <option value="CANCELADO">Cancelado</option>
                                <option value="ATRASADO">Atrasado</option>
                            </select>
                        </div>
                        <div class="col-md-3 align-self-end text-right">
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
                    <table id="datatableContasReceber" class="table mb-0" style="width: 100%;">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col"class="col-1">Documento</th>
                                <th scope="col" class="col-3">Cliente</th>
                                <th scope="col">Descrição</th>
                                <th scope="col" class="col-2 text-right">Valor</th>
                                <th scope="col" class="col-1">Vencimento</th>
                                <th scope="col" class="col-1">Status</th>
                                <th scope="col" class="col-1">Ações</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot class="thead-light">
                            <tr>
                                <th scope="col" class="col-1">Documento</th>
                                <th scope="col" class="col-3">Cliente</th>
                                <th scope="col">Descrição</th>
                                <th scope="col" class="col-2 text-right">Valor</th>
                                <th scope="col" class="col-1">Vencimento</th>
                                <th scope="col" class="col-1">Status</th>
                                <th scope="col" class="col-1">Ações</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Cadastro -->
<div class="modal fade" id="modalCadastro" tabindex="-1" role="dialog" aria-labelledby="modalForm" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-50-width" role="document">
        <div class="modal-content" id="modalCadastroContent"></div>
    </div>
</div>

<!-- Modal Edição -->
<div class="modal fade" id="modalEdicao" tabindex="-1" role="dialog" aria-labelledby="modalForm" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-50-width" role="document">
        <div class="modal-content" id="modalEdicaoContent"></div>
    </div>
</div>

<!-- Modal Baixa -->
<div class="modal fade" id="modalBaixa" tabindex="-1" role="dialog" aria-labelledby="modalForm" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-50-width" role="document">
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
<!-- custom app -->
<script src="<?= site_url('mentor/assets/'); ?>js/financeiro/contas-receber.js"></script>
<script src="<?= site_url('mentor/assets/'); ?>js/common.js" data-route="contasreceber"></script>
<?= $this->endSection() ?>