const route = document.currentScript.getAttribute('data-route');

/**
 * Abrir o modal de visualização de dados
 */
$('#table-list').on('click', '.btn-view', function(e) {
    e.preventDefault();

    //var id = $(this).closest('tr').attr('id');
    var id = $(this).attr('data-id');
    var dataURL = route + '/show/' + id;
    var title = $(this).attr('data-original-title');

    $('#modalViewLabel').html(title);

    $('.modal-body-view').load(dataURL, function() {
        $('#modalView').modal({
            show: true
        });
    });
});

/**
 * Abrir o modal de inclusão de dados
 */
$(document).on('click', '.btn-add', function(e) {
    e.preventDefault();

    var dataURL = route + '/add';
    var title = $(this).attr('data-original-title');

    $('#modalFormLabel').html(title);

    $('.modal-body-form').load(dataURL, function() {
        $('#modalForm').modal({
            show: true
        });
    });
});

/**
 * Abrir o modal de edição de dados
 */
$('#table-list').on('click', '.btn-edit', function(e) {
    e.preventDefault();

    //var id = $(this).closest('tr').attr('id');
    var id = $(this).attr('data-id');
    var dataURL = route + '/edit/' + id;
    var title = $(this).attr('data-original-title');

    $('#modalFormLabel').html(title);

    $('.modal-body-form').load(dataURL, function() {
        $('#modalForm').modal({
            show: true
        });
    });
});

/**
 * Abrir o modal de exclusão de registros
 */
$('#table-list').on('click', '.btn-del', function(e) {
    e.preventDefault();

    //var id = $(this).closest('tr').attr('id');
    var id = $(this).attr('data-id');
    var dataURL = route + '/delete/' + id;
    var title = $(this).attr('data-original-title');

    $('#modalDeleteLabel').html(title);

    $('.modal-body-delete').load(dataURL, function() {
        $('#modalDelete').modal({
            show: true
        });
    });

    $('.modal-confirm-del').text('Excluir');
});

/**
 * Abrir o modal de restore de registros
 */
$('#table-list').on('click', '.btn-undo', function(e) {
    e.preventDefault();

    //var id = $(this).closest('tr').attr('id');
    var id = $(this).attr('data-id');
    var dataURL = route + '/undo/' + id;
    var title = $(this).attr('data-original-title');

    $('#modalDeleteLabel').html(title);

    $('.modal-body-delete').load(dataURL, function() {
        $('#modalDelete').modal({
            show: true
        });
    });

    $('.modal-confirm-del').text('Restaurar');
});

/**
 * Botão Salvar
 */
$(document).on('click', '.modal-confirm-form', function (e) {
    e.preventDefault();

    var $this = this;
    var $method = $('[name="method"]').val();
    var $validator = $("#form").validate();

    if (($method == 'update') && (route == 'usuarios')) {
        $('[name="password"]').removeAttr('required')
        $('[name="password_confirmation"]').removeAttr('required')
    }
    
    if ($validator.form()) {
        var formData = new FormData($("form[id='form']")[0]);

        $($this).attr('disabled', 'disabled');
        $($this).text("Aguarde...");

        $.ajax({
            type: 'POST',
            url: route + '/' + $method,
            data: formData,
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('#response').html('');
            },
            success: function(response) {
                if (!response.error) {
                    if (response.info) {
                        $('#response').html('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + response.info + '</div>');
                    }
                    else if (response.success) {
                        $('#response').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + response.success + '</div>');
                    }
                }

                if (response.error) {
                    var output = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + response.error;

                    if (response.errors_model) {
                        output += '<ul class="">';

                        $.each(response.errors_model, function(key, value) {
                            output += '<li class="text-danger">' + value + '</li>';
                        });

                        output += '</ul>';
                    }

                    output += '</div>';

                    $('#response').html(output);

                    $($this).val('Salvar');
                    $($this).removeAttr('disabled');
                }

                if ($method == 'update') {
                    $('.btn-save-form').removeAttr('disabled');
                }

                if (response.error) {
                }
                else {
                    setTimeout(function() {
                        $('#modalForm').modal('hide');

                        if (response.info) {
                            $title = 'Informação';
                            $text = response.info;
                            $type = 'info';
                        }
                        else if (response.success) {
                            $title = 'Sucesso';
                            $text = response.success;
                            $type = 'success';
                        }
                        else {
                            $title = 'Erro';
                            $text = 'Verifique o(s) erro(s) ocorrido(s)';
                            $type = 'error';
                        }

                        new PNotify({
                            title: $title,
                            text: $text,
                            type: $type,
                        });
                    }, 1000);
                }

                $('#table-list').DataTable().ajax.reload();

                $($this).text('Salvar');
                $($this).removeAttr('disabled');
            },
            error: function() {
                $('#response').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Não foi possível processar a solicitação. Por favor, entre em contato com o Suporte Técnico.</div>');

                $($this).text('Salvar');
                $($this).removeAttr('disabled');
            }
        });
    }
});

/**
 * Botão Excluir / Restaurar
 */
$(document).on('click', '.modal-confirm-del', function(e) {
    e.preventDefault();

    var $this = this;
    var $method = $('[name="method_del"]').val();
    var id = $('[name="id"]').val();

    $($this).attr('disabled', 'disabled');
    $($this).text("Aguarde...");

    if ($method == 'remove') {
        $label = 'Excluir';
    }
    else {
        $label = 'Restaurar';
    }

    $($this).text($label);

    $.ajax({
        type: 'POST',
        url: $route + '/' + $method + '/' + id,
        beforeSend: function() {
            $('#response').html('');
        },
        success: function(response) {
            if (!response.error) {
                if (response.info) {
                    $('#response').html('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + response.info + '</div>');
                }
                if (response.success) {
                    $('#response').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + response.success + '</div>');
                }
            }

            if (response.error) {
                var output = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + response.error;

                if (response.errors_model) {
                    output += '<ul class="">';

                    $.each(response.errors_model, function(key, value) {
                        output += '<li class="text-danger">' + value + '</li>';
                    });

                    output += '</ul>';
                }

                output += '</div>';

                $('#response').html(output);

                $($this).text($label);
                $($this).removeAttr('disabled');
            }

            setTimeout(function() {
                $('#modalDelete').modal('hide');

                if (response.info) {
                    $title = 'Informação';
                    $text = response.info;
                    $type = 'info';
                }
                else if (response.success) {
                    $title = 'Sucesso';
                    $text = response.success;
                    $type = 'success';
                }
                else {
                    $title = 'Erro';
                    $text = 'Verifique o(s) erro(s) ocorrido(s)';
                    $type = 'error';
                }

                new PNotify({
                    title: $title,
                    text: $text,
                    type: $type,
                });
            }, 1000);

            $('#table-list').DataTable().ajax.reload();

            $($this).text($label);
            $($this).removeAttr('disabled');
        },
        error: function() {
            $('#response').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Não foi possível processar a solicitação. Por favor, entre em contato com o Suporte Técnico.</div>');

            $($this).text($label);
            $($this).removeAttr('disabled');
        }
    });
});

/***
 * Função para converter número no formato brasileiro para o formato numérico padrão
 */
function converterParaNumero(valor) {
    // Remove os pontos de milhar e substitui a vírgula decimal por um ponto
    return parseFloat(valor.replace(/\./g, '').replace(',', '.'));
}

/***
 * Função para converter número no formato numérico padrão para o formato brasileiro
 */
function converterParaNumeroBrasileiro(valor) {
    // Converte o número para o formato com ponto de milhar e vírgula decimal
    return valor.toFixed(2)  // Limita a 2 casas decimais
        .replace('.', ',')  // Substitui o ponto decimal por vírgula
        .replace(/\B(?=(\d{3})+(?!\d))/g, '.');  // Adiciona ponto como separador de milhar
}

/**
 * Função que calcula o valor baseado em um valor base e um percentual
 */
function calcularValor(valorInicial, percentual) {
    percentual = percentual / 100;

    valor = valorInicial * percentual;
    valor = converterParaNumeroBrasileiro(valor);

    return valor;
}

function calcularPercentual(valorInicial, valorFinal) {
    valor = ((valorFinal - valorInicial) / valorInicial) * 100;
    valor = converterParaNumeroBrasileiro(valor);

    return valor;
}