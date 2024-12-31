<div class="modal-header">
    <h5 class="modal-title">Upload de Documento</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form id="formUpload" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $conta->id ?>">
    <div class="modal-body">
        <div class="row">
            <div class="col-md-12 mb-3">
                <label class="form-label">Selecione o Documento</label>
                <input type="file" name="documento" class="form-control" accept=".pdf,.jpg,.jpeg,.png" required>
            </div>
            <div class="col-md-12 mb-3">
                <label class="form-label">Descrição do Documento</label>
                <input type="text" name="descricao" class="form-control">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </div>
</form>

<script>
$(document).ready(function() {
    $('#formUpload').on('submit', function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        
        $.ajax({
            url: '<?= site_url('contas-pagar/upload/' . $conta->id) ?>',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    toastr.success(response.message);
                    $('#modalUpload').modal('hide');
                } else {
                    toastr.error(response.message);
                }
            }
        });
    });
});
</script>