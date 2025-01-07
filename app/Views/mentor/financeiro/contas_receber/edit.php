<div class="modal-header table-primary">
    <h4 class="modal-title text-primary">Editar Conta a Receber</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form id="formEdicao">
    <input type="hidden" name="id" value="<?= $conta->id ?>">
    <div class="modal-body">
        <div class="form-row">
            <div class="form-group col-md-12">
                <fieldset class="border pb-4 pr-4 pl-4 rounded">
                    <legend class="legend"><i class="ti ti-file-description"></i> Dados da Conta</legend>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Descrição</label>
                            <input type="text" name="descricao" class="form-control" placeholder="Descrição" value="<?= $conta->descricao ?>" maxlength="100" required />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Cliente</label>
                            <select name="cliente_id" class="js-basic-single form-control" data-js-container=".modal" required>
                                <option value="">Selecione</option>
                                <?php foreach($clientes as $cliente): ?>
                                    <option value="<?= $cliente->id ?>" <?= $cliente->id == $conta->cliente_id ? 'selected' : '' ?>>
                                        <?= $cliente->nome_fantasia === '' ? $cliente->razao_social : $cliente->nome_fantasia; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Classificação da Conta</label>
                            <select name="classificacao_conta_id" class="js-basic-single form-control" data-js-container=".modal" required>
                                <option value="">Selecione</option>
                                <?php foreach($classificacoes as $classificacao): ?>
                                    <option value="<?= $classificacao->id ?>" <?= $classificacao->id == $conta->classificacao_conta_id ? 'selected' : '' ?>>
                                        <?= $classificacao->descricao ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label>Nº Documento</label>
                            <input type="text" name="numero_documento" class="form-control" placeholder="Documento" value="<?= $conta->numero_documento ?>" maxlength="50" />
                        </div>
                        <div class="form-group col-md-4">
                            <label>Forma de Pagamento</label>
                            <select name="forma_pagamento_id" class="js-basic-single form-control" data-js-container=".modal">
                                <option value="">Selecione</option>
                                <?php foreach($formasPagamento as $forma): ?>
                                    <option value="<?= $forma->id ?>" <?= $forma->id == $conta->forma_pagamento_id ? 'selected' : '' ?>>
                                        <?= $forma->nome ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Valor Total</label>
                            <div class="input-group">
                                <span class="input-group-text">R$</span>
                                <input type="text" name="valor_total" class="form-control money text-right" placeholder="0,00" value="<?= number_format($conta->valor_total, 2, ',', '.') ?>" maxlength="12" required />
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Data de Vencimento</label>
                            <input type="date" name="data_vencimento" class="form-control" value="<?= str_replace(' 00:00:00', '', $conta->data_vencimento) ?>" required />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Conta</label>
                            <select name="conta_corrente_id" class="js-basic-single form-control" data-js-container=".modal">
                                <option value="">Selecione</option>
                                <?php foreach($contasCorrente as $contaCorrente): ?>
                                    <option value="<?= $contaCorrente->id ?>" <?= $contaCorrente->id == $conta->conta_corrente_id ? 'selected' : '' ?>><?= $contaCorrente->descricao ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-8">
                            <div class="form-check float-right">
                                <input type="checkbox" class="form-check-input" id="previsao" name="previsao" <?= $conta->previsao ? 'checked' : '' ?> />
                                <label for="previsao">Previsão</label>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-square btn-inverse-success fixed-button-width modal-confirm-cr">Salvar</button>
        <button type="button" class="btn btn-square btn-inverse-primary fixed-button-width modal-dismiss-cr" data-dismiss="modal">Fechar</button>
    </div>
</form>

<script src="<?= site_url('mentor/assets/'); ?>js/financeiro/contas-receber-form.js" data-method="edit"></script>