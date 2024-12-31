var $route = '/financeiro/contaspagar';

$(document).ready(function() {
    // Adicionar método serializeObject se não existir
    if (!$.fn.serializeObject) {
        $.fn.serializeObject = function() {
            var o = {};
            var a = this.serializeArray();
            $.each(a, function() {
                if (o[this.name]) {
                    if (!o[this.name].push) {
                        o[this.name] = [o[this.name]];
                    }
                    o[this.name].push(this.value || '');
                } else {
                    o[this.name] = this.value || '';
                }
            });
            return o;
        };
    }
    
    const datatableContasPagar = $('#datatableContasPagar').DataTable({
        processing: true,
        serverSide: true,
        'oLanguage': language_PTBR,
        ajax: {
            url: $route + '/fetch',
            type: 'POST',
            data: function(d) {
                return $.extend(d, $('#formFiltro').serializeObject());
            }
        },
        columns: [
            { data: 'numero_documento' },
            { data: 'fornecedor_nome' },
            { data: 'valor_total' },
            { data: 'data_vencimento' },
            { data: 'status' },
            { data: 'acoes', orderable: false }
        ]
    });

    // Filtrar
    $('#btnFiltrar').on('click', function() {
        datatableContasPagar.ajax.reload();
    });

    // Limpar Filtro
    $('#btnLimparFiltro').on('click', function() {
        $('#formFiltro')[0].reset();
        datatableContasPagar.ajax.reload();
    });

    // Abrir Modal de Cadastro
    $('.btn-add').on('click', function() {
        $.ajax({
            url: $route + '/add',
            success: function(response) {
                $('#modalCadastroContent').html(response);
                $('#modalCadastro').modal('show');
            },
            error: function(xhr, status, error) {
                console.error("Erro ao carregar modal:", error);
                alert("Erro ao carregar o formulário. Por favor, tente novamente.");
            }
        });
    });

    // Processar Cadastro
    $(document).on('submit', '#formCadastro', function(e) {
        e.preventDefault();
        $.ajax({
            url: $route + '/store',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    toastr.success(response.message);
                    $('#modalCadastro').modal('hide');
                    datatableContasPagar.ajax.reload();
                } else {
                    toastr.error(response.message);
                }
            }
        });
    });

    // Abrir Modal de Edição
    $(document).on('click', '.btn-edit', function() {
        const id = $(this).data('id');
        $.ajax({
            url: $route + '/edit/' + id,
            success: function(response) {
                $('#modalEdicaoContent').html(response);
                $('#modalEdicao').modal('show');
            }
        });
    });

    // Processar Edição
    $(document).on('submit', '#formEdicao', function(e) {
        e.preventDefault();
        const id = $(this).find('[name="id"]').val();
        $.ajax({
            url: $route + '/update/' + id,
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status) {
                    toastr.success(response.message);
                    $('#modalEdicao').modal('hide');
                    datatableContasPagar.ajax.reload();
                } else {
                    toastr.error(response.message);
                }
            }
        });
    });

    // Baixa
    $(document).on('click', '.btn-baixa', function() {
        const id = $(this).data('id');
        $.ajax({
            url: $route + '/baixa/' + id,
            success: function(response) {
                $('#modalBaixaContent').html(response);
                $('#modalBaixa').modal('show');
            }
        });
    });

    // Upload
    $(document).on('click', '.btn-upload', function() {
        const id = $(this).data('id');
        $.ajax({
            url: $route + '/upload/' + id,
            success: function(response) {
                $('#modalUploadContent').html(response);
                $('#modalUpload').modal('show');
            }
        });
    });

    $(".js-basic-single").select2({
        placeholder: "Selecione uma opção",
        allowClear: true
    });
});
