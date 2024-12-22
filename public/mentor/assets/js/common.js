const route = document.currentScript.getAttribute('data-route');

/**
 * Abrir o modal de inclusão de dados
 */
$(document).on('click', '.btn-add', function (e) {
    e.preventDefault();

    var dataURL = route + '/add';
    var title = $(this).attr('data-original-title');

    $('#modalFormLabel').html(title);

    $('.modal-body-form').load(dataURL, function () {
        $('#modalForm').modal({
            show: true
        });
    });
});

/**
 * Abrir o modal de edição de dados
 */
$('#datatable').on('click', '.btn-edit', function (e) {
    e.preventDefault();

    var id = $(this).attr('data-id');
    var dataURL = route + '/edit/' + id;
    var title = $(this).attr('title');

    $('#modalFormLabel').html(title);

    $('.modal-body-form').load(dataURL, function () {
        $('#modalForm').modal({
            show: true
        });
    });
});

/**
 * Abrir o modal de visualização de dados
 */
$('#datatable').on('click', '.btn-view', function (e) {
    e.preventDefault();

    var id = $(this).attr('data-id');
    var dataURL = route + '/show/' + id;
    var title = $(this).attr('title');

    $('#modalViewLabel').html(title);

    $('.modal-body-view').load(dataURL, function () {
        $('#modalView').modal({
            show: true
        });
    });
});

/**
 * Abrir o modal de exclusão de registros
 */
$('#datatable').on('click', '.btn-del', function (e) {
    e.preventDefault();

    var id = $(this).attr('data-id');
    var dataURL = route + '/delete/' + id;
    var title = $(this).attr('title');

    $('#modalDeleteLabel').html(title);

    $('.modal-body-delete').load(dataURL, function () {
        $('#modalDelete').modal({
            show: true
        });
    });

    $('.modal-confirm-del').text('Excluir');
});

/**
 * Abrir o modal de restore de registros
 */
$('#datatable').on('click', '.btn-undo', function (e) {
    e.preventDefault();

    var id = $(this).attr('data-id');
    var dataURL = route + '/undo/' + id;
    var title = $(this).attr('title');

    $('#modalDeleteLabel').html(title);

    $('.modal-body-delete').load(dataURL, function () {
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
            beforeSend: function () {
                $('#response').html('');
            },
            success: function (response) {
                if (!response.error) {
                    if (response.info) {
                        $('#response').html('<div class="alert alert-icon alert-inverse-info alert-dismissible fade show" role="alert"><i class="fa fa-info-circle"></i>' + response.info + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="ti ti-close"></i></button></div>');
                    }
                    else if (response.success) {
                        $('#response').html('<div class="alert alert-icon alert-inverse-success alert-dismissible fade show" role="alert"><i class="fa fa-info-circle"></i>' + response.success + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="ti ti-close"></i></button></div>');
                    }
                }

                if (response.error) {
                    var output = '<div class="alert alert-icon alert-inverse-danger alert-dismissible fade show" role="alert"><i class="fa fa-info-circle"></i>' + response.error;

                    if (response.errors_model) {
                        output += '<ul class="">';

                        $.each(response.errors_model, function (key, value) {
                            output += '<li class="text-danger">' + value + '</li>';
                        });

                        output += '</ul>';
                    }

                    output += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="ti ti-close"></i></button></div>';

                    $('#response').html(output);

                    $($this).text('Salvar');
                    $($this).removeAttr('disabled');
                }

                if ($method == 'update') {
                    $('.btn-save-form').removeAttr('disabled');
                }

                $('#datatable').DataTable().ajax.reload();

                setTimeout(function () {
                    $($this).text('Salvar');
                    $($this).removeAttr('disabled');

                    $('#modalForm').modal('hide');
                }, 1000);
            },
            error: function () {
                $('#response').html('<div class="alert alert-icon alert-inverse-danger alert-dismissible fade show" role="alert"><i class="fa fa-info-circle"></i>Não foi possível processar a solicitação. Por favor, entre em contato com o Suporte Técnico.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="ti ti-close"></i></button></div>');

                $($this).text('Salvar');
                $($this).removeAttr('disabled');
            }
        });
    }
});

/**
 * Botão Excluir / Restaurar
 */
$(document).on('click', '.modal-confirm-del', function (e) {
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

    $.ajax({
        type: 'POST',
        url: route + '/' + $method + '/' + id,
        beforeSend: function () {
            $('#response').html('');
        },
        success: function (response) {
            if (!response.error) {
                if (response.info) {
                    $('#response').html('<div class="alert alert-icon alert-inverse-info alert-dismissible fade show" role="alert"><i class="fa fa-info-circle"></i>' + response.info + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="ti ti-close"></i></button></div>');
                }
                if (response.success) {
                    $('#response').html('<div class="alert alert-icon alert-inverse-success alert-dismissible fade show" role="alert"><i class="fa fa-info-circle"></i>' + response.success + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="ti ti-close"></i></button></div>');
                }
            }

            if (response.error) {
                var output = '<div class="alert alert-icon alert-inverse-danger alert-dismissible fade show" role="alert"><i class="fa fa-info-circle"></i>' + response.error;

                if (response.errors_model) {
                    output += '<ul class="">';

                    $.each(response.errors_model, function (key, value) {
                        output += '<li class="text-danger">' + value + '</li>';
                    });

                    output += '</ul>';
                }

                output += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="ti ti-close"></i></button></div>';

                $('#response').html(output);

                $($this).text($label);
                $($this).removeAttr('disabled');
            }

            $('#datatable').DataTable().ajax.reload();

            setTimeout(function () {
                $($this).text($label);
                $($this).removeAttr('disabled');

                $('#modalDelete').modal('hide');
            }, 1000);
        },
        error: function () {
            $('#response').html('<div class="alert alert-icon alert-inverse-danger alert-dismissible fade show" role="alert"><i class="fa fa-info-circle"></i>Não foi possível processar a solicitação. Por favor, entre em contato com o Suporte Técnico.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="ti ti-close"></i></button></div>');

            $($this).text($label);
            $($this).removeAttr('disabled');
        }
    });
});

function replaceAll(string, token, newtoken) {
    while (string.indexOf(token) !== -1) {
        string = string.replace(token, newtoken);
    }

    return string;
}

function formatValorDecimal(v) {
    if (v == "") {
        return "0,00";
    }

    if (v.indexOf(",") == 0) {
        v = "0" + v.toString();
    }

    v = v.toString();
    v = replaceAll(v, ".", "");
    v = v.replace(",", ".");
    v = parseFloat(v);
    v = v.toFixed(2);
    v = v.toString();
    v = replaceAll(v, ".", "");
    v = v.replace(/(\d{2})$/, ",$1");
    v = v.replace(/(\d+)(\d{3},\d{2})$/g, "$1.$2");

    var qtdLoop = (v.length - 3) / 3; var count = 0;
    while (qtdLoop > count) {
        count++;
        v = v.replace(/(\d+)(\d{3}.*)/, "$1.$2");
    }

    v = v.replace(/^(0)(\d)/g, "$2");

    return v
}

function roundTo(number, upto) {
    if (number.indexOf(",") == 0) {
        number = "0" + number.toString();
    }

    number = number.toString();
    number = replaceAll(number, ".", "");
    number = number.replace(",", ".");
    number = parseFloat(number);
    number = number.toFixed(upto);
    number = number.toString();
    number = replaceAll(number, ".", ",");

    return number;
}

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