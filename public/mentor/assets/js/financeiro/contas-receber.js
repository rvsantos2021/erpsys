var $route = '/financeiro/contasreceber';
var table;

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

    table = $('#datatableContasReceber').DataTable({
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
            { data: 'cliente_nome' },
            { data: 'descricao' },
            { data: 'valor_total' },
            { data: 'data_vencimento' },
            { data: 'status' },
            { data: 'acoes', orderable: false }
        ],
        columnDefs: [
            {
                targets: 3, // Índice da coluna de valor
                className: 'text-right',
                render: $.fn.dataTable.render.number('.', ',', 2, 'R$ ')
            },
            {
                targets: 5, // Índice da coluna de status
                className: 'text-center',
                orderable: false
            },
            {
                targets: 6, // Índice da coluna de ações
                className: 'text-center',
                orderable: false
            }
        ],
    });

    // Filtrar
    $('#btnFiltrar').on('click', function() {
        table.ajax.reload();
    });

    // Limpar Filtro
    $('#btnLimparFiltro').on('click', function() {
        $('#formFiltro')[0].reset();
        table.ajax.reload();
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
                    table.ajax.reload();
                } else {
                    toastr.error(response.message);
                }
            }
        });
    });

    // Abrir Modal de Edição
    $(document).on('click', '.btn-edt', function() {
        const id = $(this).data('id');
        $.ajax({
            url: $route + '/edit/' + id,
            success: function(response) {
                $('#modalEdicaoContent').html(response);
                $('#modalEdicao').modal('show');
                
                // Reinicializar Select2 após carregar o conteúdo
                setTimeout(function() {
                    $('.js-basic-single').select2({
                        dropdownParent: $('#modalEdicao'),
                    });
                }, 100);
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
                    table.ajax.reload();
                } else {
                    toastr.error(response.message);
                }
            }
        });
    });

    // Abrir Modal de Baixar Conta
    $(document).on('click', '.btn-pay', function() {
        const id = $(this).data('id');
        $.ajax({
            url: $route + '/receivable/' + id,
            success: function(response) {
                $('#modalBaixaContent').html(response);
                $('#modalBaixa').modal('show');

                // Reinicializar Select2 após carregar o conteúdo
                setTimeout(function() {
                    $('.js-basic-single').select2({
                        dropdownParent: $('#modalBaixa'),
                    });
                }, 100);
            }
        });
    });

    // Abrir Modal de Upload
    $(document).on('click', '.btn-upl', function() {
        const id = $(this).data('id');
        $.ajax({
            url: $route + '/upload/' + id,
            success: function(response) {
                $('#modalUploadContent').html(response);
                $('#modalUpload').modal('show');
            }
        });
    });

    // Exclusão de conta
    $(document).on('click', '.btn-del', function() {
        const id = $(this).data('id');
        const $button = $(this);
        
        console.log('ID da conta para exclusão:', id); // Log de depuração
        
        // Confirmar exclusão
        Swal.fire({
            title: 'Confirma a Exclusão?',
            text: 'A exclusão do lançamento será irreversível!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, excluir!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            console.log('Resposta do usuário:', result.value); // Log de depuração
            if (result.value) {
                $.ajax({
                    url: $route + '/delete',
                    type: 'POST',
                    dataType: 'json',
                    contentType: 'application/x-www-form-urlencoded', // Definir tipo de conteúdo
                    data: { id: id }, // Enviar como form-urlencoded
                    success: function(response) {
                        console.log('Resposta da exclusão:', response); // Log de depuração
                        
                        if (response.status) {
                            Swal.fire(
                                'Excluído!',
                                response.message,
                                'success'
                            );
                            
                            // Atualizar botão para restaurar
                            $button.removeClass('btn-outline-danger btn-del')
                                .addClass('btn-outline-success btn-restore')
                                .find('i').removeClass('ti-trash').addClass('ti-reload');
                            
                            // Recarregar tabela
                            table.ajax.reload(null, false);
                        } else {
                            Swal.fire(
                                'Erro!',
                                response.message,
                                'error'
                            );
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Erro na exclusão:', xhr.responseText); // Log de erro
                        console.error('Status:', xhr.status);
                        console.error('Erro:', error);
                        
                        Swal.fire(
                            'Erro!',
                            'Não foi possível excluir a conta: ' + (xhr.responseJSON?.message || error),
                            'error'
                        );
                    }
                });
            }
        });
    });

    $(".js-basic-single").select2({
        placeholder: "Todos",
        allowClear: true
    });

    $('#modalCadastro, #modalEdicao').on('shown.bs.modal', function () {
        $('[name="descricao"]').focus();
    });

    $('#modalBaixa').on('shown.bs.modal', function () {
        $('[name="valor_pago"]').focus();
    });

    // Reinicializar Select2 nos filtros após fechar modal
    $('#modalEdicao, #modalCadastro, #modalBaixa').on('hidden.bs.modal', function () {
        $(".js-basic-single").select2({
            placeholder: "Todos",
            allowClear: true
        });
    });
});

// Abrir Modal de Edição
function edit(id) {
    $.ajax({
        url: $route + '/edit/' + id,
        success: function(response) {
            $('#modalEdicaoContent').html(response);
            $('#modalEdicao').modal('show');
            
            // Reinicializar Select2 após carregar o conteúdo
            setTimeout(function() {
                $('.js-basic-single').select2({
                    dropdownParent: $('#modalEdicao'),
                });
            }, 100);
        }
    });
}

// Abrir Modal de Visualizar Conta
function view(id) {
    $.ajax({
        url: $route + '/view/' + id,
        success: function(response) {
            $('#modalBaixaContent').html(response);
            $('#modalBaixa').modal('show');

            // Reinicializar Select2 após carregar o conteúdo
            setTimeout(function() {
                $('.js-basic-single').select2({
                    dropdownParent: $('#modalBaixa'),
                });
            }, 100);
        }
    });
}

// Abrir Modal de Baixar Conta
function receivable(id) {
    $.ajax({
        url: $route + '/receivable/' + id,
        success: function(response) {
            $('#modalBaixaContent').html(response);
            $('#modalBaixa').modal('show');

            // Reinicializar Select2 após carregar o conteúdo
            setTimeout(function() {
                $('.js-basic-single').select2({
                    dropdownParent: $('#modalBaixa'),
                });
            }, 100);
        }
    });
}

// Abrir Modal de Upload
function upload(id) {
    $.ajax({
        url: $route + '/attach/' + id,
        success: function(response) {
            $('#modalUploadContent').html(response);
            $('#modalUpload').modal('show');
        }
    });
}

// Exclusão de conta
function remove(id) {
    // Confirmar exclusão
    Swal.fire({
        title: 'Confirma a Exclusão?',
        text: 'A exclusão do lançamento será irreversível!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim, excluir!',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        console.log('Resposta do usuário:', result.value); // Log de depuração
        if (result.value) {
            $.ajax({
                url: $route + '/delete',
                type: 'POST',
                dataType: 'json',
                contentType: 'application/x-www-form-urlencoded', // Definir tipo de conteúdo
                data: { id: id }, // Enviar como form-urlencoded
                success: function(response) {
                    console.log('Resposta da exclusão:', response); // Log de depuração
                    
                    if (response.status) {
                        Swal.fire(
                            'Excluído!',
                            response.message,
                            'success'
                        );
                        
                        // Atualizar botão para restaurar
                        $button.removeClass('btn-outline-danger btn-del')
                            .addClass('btn-outline-success btn-restore')
                            .find('i').removeClass('ti-trash').addClass('ti-reload');
                        
                        // Recarregar tabela
                        table.ajax.reload(null, false);
                    } else {
                        Swal.fire(
                            'Erro!',
                            response.message,
                            'error'
                        );
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Erro na exclusão:', xhr.responseText); // Log de erro
                    console.error('Status:', xhr.status);
                    console.error('Erro:', error);
                    
                    Swal.fire(
                        'Erro!',
                        'Não foi possível excluir a conta: ' + (xhr.responseJSON?.message || error),
                        'error'
                    );
                }
            });
        }
    });
}