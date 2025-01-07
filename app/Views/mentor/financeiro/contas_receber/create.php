<div class="modal-header table-primary">
    <h4 class="modal-title text-primary">Nova Conta a Receber</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<form id="formCadastro">
    <div class="modal-body">
        <div class="form-row">
            <div class="form-group col-md-12">
                <fieldset class="border pb-4 pr-4 pl-4 rounded">
                    <legend class="legend"><i class="ti ti-file-description"></i> Dados da Conta</legend>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Descrição</label>
                            <input type="text" name="descricao" class="form-control" placeholder="Descrição" maxlength="100" required />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Cliente</label>
                            <select name="cliente_id" class="js-basic-single form-control" data-js-container=".modal" required>
                                <option value="">Selecione</option>
                                <?php foreach($clientes as $cliente): ?>
                                    <option value="<?= $cliente->id ?>">
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
                                    <option value="<?= $classificacao->id ?>"><?= $classificacao->descricao ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-2">
                            <label>Nº Documento</label>
                            <input type="text" name="numero_documento" class="form-control" placeholder="Documento" maxlength="50" />
                        </div>
                        <div class="form-group col-md-4">
                            <label>Forma de Pagamento</label>
                            <select name="forma_pagamento_id" class="js-basic-single form-control" data-js-container=".modal">
                                <option value="">Selecione</option>
                                <?php foreach($formasPagamento as $forma): ?>
                                    <option value="<?= $forma->id ?>"><?= $forma->nome ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Valor Total</label>
                            <div class="input-group">
                                <span class="input-group-text">R$</span>
                                <input type="text" name="valor_total" class="form-control money text-right" placeholder="0,00" maxlength="12" required />
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Data de Vencimento</label>
                            <input type="date" name="data_vencimento" class="form-control" required />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>Conta</label>
                            <select name="conta_corrente_id" class="js-basic-single form-control" data-js-container=".modal">
                                <option value="">Selecione</option>
                                <?php foreach($contasCorrente as $contaCorrente): ?>
                                    <option value="<?= $contaCorrente->id ?>"><?= $contaCorrente->descricao ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Tipo de Conta</label>
                            <select name="tipo_conta" id="tipoConta" class="form-control">
                                <option value="avulsa">Avulsa</option>
                                <option value="parcelada">Parcelada</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2" id="parcelasContainer" style="display:none;">
                            <label>Número de Parcelas</label>
                            <input type="number" name="numero_parcelas" id="numeroParcelas" class="form-control" min="1" max="360">
                        </div>                        
                        <div class="form-group col-md-3">
                            <div class="form-check float-right">
                                <input type="checkbox" class="form-check-input" id="previsao" name="previsao" />
                                <label for="previsao">Previsão</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <!-- Grid para Provisão de Parcelas -->
                        <div class="col-md-12" id="gridParcelasContainer" style="display:none;">
                            <label>Previsão de Parcelas</label>
                            <div class="parcelas-grid-container" style="min-height: 130px; max-height: 130px; overflow-y: auto;">
                                <table class="table table-sm mb-0" id="gridParcelas">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col" class="col-1">Parcela</th>
                                            <th scope="col"></th>
                                            <th scope="col" class="col-2 text-right">Valor</th>
                                            <th scope="col" class="col-1">Vencimento</th>
                                        </tr>
                                    </thead>
                                    <tbody id="corpoGridParcelas">
                                        <!-- Parcelas serão geradas dinamicamente via JavaScript -->
                                    </tbody>
                                </table>
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

<script src="<?= site_url('mentor/assets/'); ?>js/financeiro/contas-receber-form.js" data-method="create"></script>
