<div class="modal-header">
    <h5 class="modal-title">Realizar Baixa</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form id="formBaixa">
    <input type="hidden" name="id" value="<?= $conta->id ?>">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Valor Total</label>
                <input type="text" class="form-control" value="<?= number_format($conta->valor_total, 2, ',', '.') ?>" readonly>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Valor Pago</label>
                <input type="text" name="valor_pago" class="form-control mask-money" required>
            </div>
            <div class="col-md-12 mb-3">
                <label class="form-label">Observações</label>
                <textarea name="observacoes" class="form-control"></textarea>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-success">Confirmar Baixa</button>
    </div>
</form>

<script>
$(document).ready(function() {
    $('.mask-money').mask('#.##0,00', {reverse: true});
});
</script>