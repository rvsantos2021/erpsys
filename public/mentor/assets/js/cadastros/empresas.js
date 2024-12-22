var $route = '/empresas';
var tableDataEnd = [];

(function (window, document, $, undefined) {

    $(function () {
        var dataTable = jQuery(".table-wrapper");

        if (dataTable.length > 0) {
            $('#datatable').DataTable({
                'bLengthChange': false,
                'bPaginate': true,
                'bSortable': true,
                'oLanguage': language_PTBR,
                'serverSide': true,
                'processing': true,
                'ajax': {
                    'url': $route + '/fetch',
                    'type': 'post',
                    data: function (d) {
                        d.csrfName = csrfHash;
                    },
                    error: function (err) {
                        console.log(err.responseText);
                    }
                },
                'columnDefs': [{
                    'targets': 4,
                    'className': 'text-center',
                    'orderable': 'false',
                    "order": []
                }, 
                {
                    'targets': 5,
                    'className': 'text-center',
                    'orderable': 'false',
                    "order": []
                },
                {
                    'targets': 6,
                    'className': 'text-center',
                    'orderable': 'false',
                    "order": []
                },]
            });
        }
    });

    $('.js-basic-single').select2();

    if ($('[name="tipo"]').val() == '') {
        $('[name="tipo"]').val('J');
    }

    if ($('[name="method"]').val() == 'insert') {
        $("#tipo-pj").prop("checked", true);
    }

    updateLabels();

    if ($('[name="method"]').val() == 'insert') {
        $('[name="cnpj"]').focus();
    }
    else {
        $('[name="razao_social"]').focus();
    }

})(window, document, window.jQuery);

$('input[name="tipo"]').change(function () {
    updateLabels();
});

/**
 * Botão Salvar
 */
$(document).on('click', '.confirm-form', function (e) {
    e.preventDefault();

    var $this = this;
    var $method = $('[name="method"]').val();
    var $validator = $("#form").validate();

    if ($validator.form()) {
        var formData = new FormData($("form[id='form']")[0]);

        $($this).attr('disabled', 'disabled');
        $($this).html('<i class="ti ti-timer"></i> Aguarde...');

        $.ajax({
            type: 'POST',
            url: $route + '/' + $method,
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

                    $($this).html('<i class="ti ti-save"></i> Salvar');
                    $($this).removeAttr('disabled');
                }

                if ($method == 'update') {
                    $('.btn-save-form').removeAttr('disabled');
                }

                if (!response.error) {
                    setTimeout(function () {
                        $($this).html('<i class="ti ti-save"></i> Salvar');
                        $($this).removeAttr('disabled');

                        window.location.href = $route;
                    }, 1000);
                }
            },
            error: function ($error) {
                $('#response').html('<div class="alert alert-icon alert-inverse-danger alert-dismissible fade show" role="alert"><i class="fa fa-info-circle"></i>Não foi possível processar a solicitação. Por favor, entre em contato com o Suporte Técnico.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="ti ti-close"></i></button></div>');

                $($this).html('<i class="ti ti-save"></i> Salvar');
                $($this).removeAttr('disabled');
            }
        });
    }
});

/**
 * Botão Buscar por CEP
 */
$(document).on('click', '.btn-cep', function (e) {
    e.preventDefault();

    var $this = this;
    var $cep = $('[name="cep"]').val();

    if ($cep.length == 9) {
        $.ajax({
            type: 'GET',
            url: '/vendors/buscarcep',
            data: {
                cep: $cep
            },
            dataType: 'json',
            beforeSend: function () {
                $('.cep-error').html('');

                $($this).attr('disabled', 'disabled');
                $($this).html('<i class="ti ti-timer"></i>');
            },
            success: function (response) {
                if (response.error) {
                    $('.cep-error').html(response.error);

                    $($this).html('<i class="fa fa-search"></i>');
                    $($this).removeAttr('disabled');
                }
                else {
                    $('[name="logradouro"]').val(response.logradouro);
                    $('[name="bairro"]').val(response.bairro);
                    $('[name="cidade_nome"]').val(response.cidade);
                    $('[name="cidade_uf"]').val(response.uf);

                    if (response.cod_ibge) {
                        getIdCidade(response.cod_ibge);
                    }

                    $($this).html('<i class="fa fa-search"></i>');
                    $($this).removeAttr('disabled');

                    $('[name="logradouro"]').focus();
                }
            },
            error: function (error) {
                $($this).html('<i class="fa fa-search"></i>');
                $($this).removeAttr('disabled');

                $('.cep-error').html('Serviço indisponível');

                console.log(error);
            }
        });
    }
});

/**
 * Botão Adicionar Endereço
 */
$(document).on('click', '.btn-add-end', function (e) {
    var cep = $('[name="cep"]').val();
    var logradouro = $('[name="logradouro"]').val();
    var numero = $('[name="numero"]').val();
    var complemento = $('[name="complemento"]').val();
    var bairro = $('[name="bairro"]').val();
    var cidade_id = $('[name="cidade_id"]').val();
    var cidade = $('[name="cidade_nome"]').val();
    var cidade_uf = $('[name="cidade_uf"]').val();
    var localidade = cidade + '/' + cidade_uf;
    var tipo = $('[name="tipo_end"]').val();
    var tipo_end = $('[name="tipo_end"]').select2('data')[0].text;

    if ((cep == '') && (logradouro == '') && (numero == '') && (complemento == '') && (bairro == '') && (cidade == '') && (tipo_end == '')) {
        return;
    }

    var cepExists = tableDataEnd.some(function (item) {
        return item.cep === cep;
    });

    if (cepExists) {
        swal({
            type: 'info',
            title: 'Atenção!',
            html: 'O endereço informado já está cadastrado!',
        });

        return;
    }

    var newRow = $('<tr>');

    newRow.append($('<td>').html('<input type="hidden" name="end_cep[]" value="' + cep + '" /><span>' + cep + '</span>'));
    newRow.append($('<td>').html('<input type="hidden" name="end_log[]" value="' + logradouro + '" /><span>' + logradouro + '</span>'));
    newRow.append($('<td>').html('<input type="hidden" name="end_nro[]" value="' + numero + '" /><span>' + numero + '</span>'));
    newRow.append($('<td>').html('<input type="hidden" name="end_cpl[]" value="' + complemento + '" /><span>' + complemento + '</span>'));
    newRow.append($('<td>').html('<input type="hidden" name="end_bai[]" value="' + bairro + '" /><span>' + bairro + '</span>'));
    newRow.append($('<td>').html('<input type="hidden" name="end_cid[]" value="' + cidade_id + '" /><span>' + localidade + '</span>'));
    newRow.append($('<td>').html('<input type="hidden" name="end_tip[]" value="' + tipo + '" /><span>' + tipo_end + '</span>'));
    newRow.append($('<td class="text-center">').html('<button type="button" data-toggle="tooltip" data-original-title="Excluir" title="Excluir" data-cep="' + cep + '" class="btn btn-sm btn-icon btn-outline-danger btn-round btn-del-end"><i class="ti ti-trash"></i></button>'));

    $('#table-enderecos tbody').append(newRow);

    tableDataEnd.push({
        cep: cep,
        logradouro: logradouro,
        numero: numero,
        complemento: complemento,
        bairro: bairro,
        cidade: cidade_id,
        tipo: tipo
    });

    $('[name="cep"]').val('');
    $('[name="logradouro"]').val('');
    $('[name="numero"]').val('');
    $('[name="complemento"]').val('');
    $('[name="bairro"]').val('');
    $('[name="cidade"]').val('');
    $('[name="tipo"]').val('');
    $('[name="cidade"]').val('');
    $('[name="tipo_end"]').val('');

    $('[name="cidade"]').trigger('change');
    $('[name="tipo_end"]').trigger('change');
});

/**
 * Retorna o ID da Cidade pelo Código IBGE
 */
function getIdCidade($cod_ibge) {
    $.ajax({
        type: 'GET',
        url: '/cidades/buscaridcidade',
        data: {
            cod_ibge: $cod_ibge
        },
        dataType: 'json',
        success: function (response) {
            var $cidade_id = response[0].id;

            $('[name="cidade_id"]').val($cidade_id);
            $('[name="cidade"]').val($cidade_id);
            $('[name="cidade"]').trigger('change'); 
        },
        error: function (error) {
            console.log(error);
        }
    });
}

/**
 * Atualiza os labels conforme o Tipo de Pessoa (Física ou Jurídica)
 */
function updateLabels() {
    if ($('#tipo-pf').is(':checked')) {
        $('[name="tipo"]').val('F');

        $('#labelCNPJ').text('CPF');
        $('#labelIE').text('RG');
        $('#labelRazao').text('Nome');
        $('#labelFantasia').text('Apelido');

        $('[name="cnpj"]').attr({
            placeholder: 'CPF',
            maxlength: '14'
        });

        $('[name="inscricao_estadual"]').attr({
            placeholder: 'RG'
        });

        $('[name="razao_social"]').attr({
            placeholder: 'Nome'
        });

        $('[name="nome_fantasia"]').attr({
            placeholder: 'Apelido'
        });

        $('#cnpj').addClass('invisible');
        $('#cpf').removeClass('invisible');
        $('#cnpj').prop('disabled', true);
        $('#cpf').prop('disabled', false);
    } else if ($('#tipo-pj').is(':checked')) {
        $('[name="tipo"]').val('J');

        $('#labelCNPJ').text('CNPJ');
        $('#labelIE').text('Inscr. Estadual');
        $('#labelRazao').text('Razão Social');
        $('#labelFantasia').text('Nome Fantasia');

        $('[name="cnpj"]').attr({
            placeholder: 'CNPJ',
            maxlength: '18'
        });

        $('[name="inscricao_estadual"]').attr({
            placeholder: 'Inscr. Estadual'
        });

        $('[name="razao_social"]').attr({
            placeholder: 'Razão Social'
        });

        $('[name="nome_fantasia"]').attr({
            placeholder: 'Nome Fantasia'
        });

        $('#cnpj').removeClass('invisible');
        $('#cpf').addClass('invisible');
        $('#cnpj').prop('disabled', false);
        $('#cpf').prop('disabled', true);
    }
}
