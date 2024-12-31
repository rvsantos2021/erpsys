<div class="modal-header table-primary">
    <h4 class="modal-title text-primary">Nova Conta a Pagar</h4>
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
                        <div class="form-group col-md-6">
                            <label>Fornecedor</label>
                            <select name="fornecedor_id" class="js-basic-single form-control" data-js-container=".modal" required>
                                <option value="">Selecione</option>
                                <?php foreach($fornecedores as $fornecedor): ?>
                                    <option value="<?= $fornecedor->id ?>"><?= $fornecedor->razao_social ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Classificação da Conta</label>
                            <select name="classificacao_conta_id" class="js-basic-single form-control" data-js-container=".modal">
                                <option value="">Selecione</option>
                                <?php foreach($classificacoes as $classificacao): ?>
                                    <option value="<?= $classificacao->id ?>"><?= $classificacao->nome ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Número do Documento</label>
                            <input type="text" name="numero_documento" class="form-control" placeholder="Número do documento">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Forma de Pagamento</label>
                            <select name="forma_pagamento_id" class="js-basic-single form-control" data-js-container=".modal">
                                <option value="">Selecione</option>
                                <?php foreach($formasPagamento as $forma): ?>
                                    <option value="<?= $forma->id ?>"><?= $forma->nome ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Tipo de Conta</label>
                            <select name="tipo_conta" class="js-basic-single form-control" id="tipoConta" data-js-container=".modal">
                                <option value="AVULSA">Avulsa</option>
                                <option value="PARCELADA">Parcelada</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6" id="parcelaContainer" style="display:none;">
                            <label>Número de Parcelas</label>
                            <input type="number" name="total_parcelas" class="form-control" min="1" max="12" placeholder="Número de parcelas">
                        </div>
                    </div>                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Valor Total</label>
                            <div class="input-group">
                                <span class="input-group-text">R$</span>
                                <!-- <input type="text" name="valor_total" class="form-control mask-money" data-mask placeholder="0,00" required> -->
                                <input type="text" name="valor_total" class="form-control mask-money" placeholder="0,00" required />
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Data de Vencimento</label>
                            <input type="date" name="data_vencimento" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Descrição</label>
                            <textarea name="descricao" class="form-control" rows="3" placeholder="Descrição adicional"></textarea>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
    <?= $this->include('mentor/layout/_response'); ?>
    <div class="modal-footer">
        <button type="button" class="btn btn-square btn-inverse-success fixed-button-width modal-confirm-form">Salvar</button>
        <button type="button" class="btn btn-square btn-inverse-primary fixed-button-width modal-dismiss-form" data-dismiss="modal">Fechar</button>
    </div>
</form>

<script type="text/javascript">
$(document).ready(function() {
    // Tipo de Conta (Avulsa/Parcelada)
    $('#tipoConta').on('change', function() {
        const parcelaContainer = $('#parcelaContainer');
        const selectedValue = $(this).val();
        
        if (selectedValue === 'PARCELADA') {
            parcelaContainer.show();
            $('input[name="total_parcelas"]').prop('required', true);
        } else {
            parcelaContainer.hide();
            $('input[name="total_parcelas"]').prop('required', false).val('');
        }
    });

    // Inicializar Select2 para todos os selects
    $(".js-basic-single").select2({
        dropdownParent: $("#modalCadastro")
    });
});