var $route = '/estoque/produtos';
var tableDataPreco = [];
var tableDataFornec = [];

$(document).ready(function () {
    $(".js-basic-single").select2();

    $('[name="peso_bruto"]').blur(function () {
        var peso_bruto = $(this).val().replace(" ", "");

        $(this).val(roundTo(peso_bruto, 4));
    });

    $('[name="peso_liquido"]').blur(function () {
        var peso_liquido = $(this).val().replace(" ", "");

        $(this).val(roundTo(peso_liquido, 4));
    });

    $('[name="estoque_inicial"]').blur(function () {
        var estoque_inicial = $(this).val().replace(" ", "");

        $(this).val(roundTo(estoque_inicial, 2));
    });

    $('[name="estoque_minimo"]').blur(function () {
        var estoque_minimo = $(this).val().replace(" ", "");

        $(this).val(roundTo(estoque_minimo, 2));
    });

    $('[name="estoque_maximo"]').blur(function () {
        var estoque_maximo = $(this).val().replace(" ", "");

        $(this).val(roundTo(estoque_maximo, 2));
    });

    $('[name="estoque_atual"]').blur(function () {
        var estoque_atual = $(this).val().replace(" ", "");

        $(this).val(roundTo(estoque_atual, 2));
    });

    $('[name="estoque_reservado"]').blur(function () {
        var estoque_reservado = $(this).val().replace(" ", "");

        $(this).val(roundTo(estoque_reservado, 2));
    });

    $('[name="estoque_real"]').blur(function () {
        var estoque_real = $(this).val().replace(" ", "");

        $(this).val(roundTo(estoque_real, 2));
    });

    $('[name="custo_bruto"]').blur(function () {
        var custo_bruto = $(this).val().replace(" ", "");

        setCustoReal();

        $(this).val(formatValorDecimal(custo_bruto));
    });

    $('[name="custo_perc_ipi"]').blur(function () {
        var custo_perc_ipi = $(this).val().replace(" ", "");
        var custo_valor_ipi = calcularValor(converterParaNumero($('[name="custo_bruto"]').val()), converterParaNumero(custo_perc_ipi));

        $('[name="custo_valor_ipi"]').val(formatValorDecimal(custo_valor_ipi));
        $(this).val(formatValorDecimal(custo_perc_ipi));

        setCustoReal();
    });

    $('[name="custo_valor_ipi"]').blur(function () {
        var custo_valor_ipi = $(this).val().replace(" ", "");
        var custo_final = parseFloat(converterParaNumero($('[name="custo_bruto"]').val()) + converterParaNumero(custo_valor_ipi));
        var custo_perc_ipi = calcularPercentual(converterParaNumero($('[name="custo_bruto"]').val()), custo_final);

        $(this).val(formatValorDecimal(custo_valor_ipi));
        $('[name="custo_perc_ipi"]').val(formatValorDecimal(custo_perc_ipi));

        setCustoReal();
    });

    $('[name="custo_perc_st"]').blur(function () {
        var custo_perc_st = $(this).val().replace(" ", "");
        var custo_valor_st = calcularValor(converterParaNumero($('[name="custo_bruto"]').val()), converterParaNumero(custo_perc_st));

        $(this).val(formatValorDecimal(custo_perc_st));
        $('[name="custo_valor_st"]').val(formatValorDecimal(custo_valor_st));

        setCustoReal();
    });

    $('[name="custo_valor_st"]').blur(function () {
        var custo_valor_st = $(this).val().replace(" ", "");
        var custo_final = parseFloat(converterParaNumero($('[name="custo_bruto"]').val()) + converterParaNumero(custo_valor_st));
        var custo_perc_st = calcularPercentual(converterParaNumero($('[name="custo_bruto"]').val()), custo_final);

        $(this).val(formatValorDecimal(custo_valor_st));
        $('[name="custo_perc_st"]').val(formatValorDecimal(custo_perc_st));

        setCustoReal();
    });

    $('[name="custo_perc_frete"]').blur(function () {
        var custo_perc_frete = $(this).val().replace(" ", "");
        var custo_valor_frete = calcularValor(converterParaNumero($('[name="custo_bruto"]').val()), converterParaNumero(custo_perc_frete));

        $(this).val(formatValorDecimal(custo_perc_frete));
        $('[name="custo_valor_frete"]').val(formatValorDecimal(custo_valor_frete));

        setCustoReal();
    });

    $('[name="custo_valor_frete"]').blur(function () {
        var custo_valor_frete = $(this).val().replace(" ", "");
        var custo_final = parseFloat(converterParaNumero($('[name="custo_bruto"]').val()) + converterParaNumero(custo_valor_frete));
        var custo_perc_frete = calcularPercentual(converterParaNumero($('[name="custo_bruto"]').val()), custo_final);

        $(this).val(formatValorDecimal(custo_valor_frete));
        $('[name="custo_perc_frete"]').val(formatValorDecimal(custo_perc_frete));

        setCustoReal();
    });

    $('[name="custo_perc_desconto"]').blur(function () {
        var custo_perc_desconto = $(this).val().replace(" ", "");
        var custo_valor_desconto = calcularValor(converterParaNumero($('[name="custo_bruto"]').val()), converterParaNumero(custo_perc_desconto));

        $(this).val(formatValorDecimal(custo_perc_desconto));
        $('[name="custo_valor_desconto"]').val(formatValorDecimal(custo_valor_desconto));

        setCustoReal();
    });

    $('[name="custo_valor_desconto"]').blur(function () {
        var custo_valor_desconto = $(this).val().replace(" ", "");
        var custo_final = parseFloat(converterParaNumero($('[name="custo_bruto"]').val()) + converterParaNumero(custo_valor_desconto));
        var custo_perc_desconto = calcularPercentual(converterParaNumero($('[name="custo_bruto"]').val()), custo_final);

        $(this).val(formatValorDecimal(custo_valor_desconto));
        $('[name="custo_perc_desconto"]').val(formatValorDecimal(custo_perc_desconto));

        setCustoReal();
    });

    $('[name="custo_real"]').blur(function () {
        var custo_real = $(this).val().replace(" ", "");

        $(this).val(formatValorDecimal(custo_real));
    });

    $('[name="margem_lucro"]').blur(function () {
        var margem_lucro = $(this).val().replace(" ", "");
        var custo_real = converterParaNumero($('[name="custo_real"]').val());
        var valor_venda = converterParaNumero(calcularValor(custo_real, converterParaNumero(margem_lucro)));
        valor_venda = converterParaNumeroBrasileiro(valor_venda + custo_real);

        $(this).val(formatValorDecimal(margem_lucro));
        $('[name="valor_venda"]').val(formatValorDecimal(valor_venda));
    });

    $('[name="valor_venda"]').blur(function () {
        var valor_venda = $(this).val().replace(" ", "");

        $(this).val(formatValorDecimal(valor_venda));
    });
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

// Incluir Preço de Venda
$(document).on('click', '.btn-inc-preco', function (e) {
    var id_tabela = $('[name="tabela"]').val();
    var tabela = $('[name="tabela"]').find(':selected').text();
    var margem_lucro = $('[name="margem_lucro"]').val();
    var valor_venda = $('[name="valor_venda"]').val();

    if ((id_tabela == '') || (margem_lucro == '') || (valor_venda == '')) {
        return;
    }

    var tabelaExists = tableDataPreco.some(function (item) {
        return item.id_tabela === id_tabela;
    });

    if (tabelaExists) {
        Swal.fire({
            icon: 'info',
            width: 300,
            title: 'Atenção!',
            html: 'Já existe Valor de Venda cadastrado para essa Tabela!',
        })

        return;
    }

    var newRow = $('<tr>');

    newRow.append($('<td>').html('<input type="hidden" name="pre_tab[]" value="' + id_tabela + '" /><span>' + tabela + '</span>'));
    newRow.append($('<td>').html('<input type="hidden" name="pre_mar[]" value="' + margem_lucro + '" /><span class="float-right">' + margem_lucro + '</span>'));
    newRow.append($('<td>').html('<input type="hidden" name="pre_vlr[]" value="' + valor_venda + '" /><span class="float-right">' + valor_venda + '</span>'));
    newRow.append($('<td class="text-center">').html('<button type="button" data-toggle="tooltip" data-original-title="Excluir" title="Excluir" data-tabela="' + id_tabela + '" class="btn btn-sm btn-icon btn-outline-danger btn-round btn-del-tabela"><i class="ti ti-trash"></i></button>'));

    $('#table-precos tbody').append(newRow);

    tableDataPreco.push({
        id_tabela: id_tabela,
        tabela: tabela,
        margem_lucro: margem_lucro,
        valor_venda: valor_venda
    });

    $('[name="tabela"]').val('').trigger('change');
    $('[name="margem_lucro"]').val('');
    $('[name="valor_venda"]').val('');
});

// Incluir Fornecedor
$(document).on('click', '.btn-inc-fornec', function (e) {
    var id_fornecedor = $('[name="fornecedor"]').val();
    var fornecedor = $('[name="fornecedor"]').find(':selected').text();
    var codigo_fornecedor = $('[name="codigo_fornecedor"]').val();

    if ((id_fornecedor == '') || (codigo_fornecedor == '')) {
        return;
    }

    var fornecExists = tableDataFornec.some(function (item) {
        return item.id_fornecedor === id_fornecedor;
    });

    if (fornecExists) {
        Swal.fire({
            icon: 'info',
            width: 300,
            title: 'Atenção!',
            html: 'Já existe Fornecedor cadastrado!',
        })

        return;
    }

    var newRow = $('<tr>');

    newRow.append($('<td>').html('<input type="hidden" name="for_id[]" value="' + id_fornecedor + '" /><span>' + fornecedor + '</span>'));
    newRow.append($('<td>').html('<input type="hidden" name="for_cod[]" value="' + codigo_fornecedor + '" /><span>' + codigo_fornecedor + '</span>'));
    newRow.append($('<td class="text-center">').html('<button type="button" data-toggle="tooltip" data-original-title="Excluir" title="Excluir" data-fornecedor="' + id_fornecedor + '" class="btn btn-sm btn-icon btn-outline-danger btn-round btn-del-fornec"><i class="ti ti-trash"></i></button>'));

    $('#table-fornecedores tbody').append(newRow);

    tableDataFornec.push({
        id_fornecedor: id_fornecedor,
        fornecedor: fornecedor,
        codigo_fornecedor: codigo_fornecedor
    });

    $('[name="fornecedor"]').val('').trigger('change');
    $('[name="codigo_fornecedor"]').val('');
});

// Excluir estoque
$('#lista-estoque').on('click', '.btn-del-estoque', function () {
    Swal.fire({
        title: 'Confirma a exclusão?',
        text: "Essa ação não poderá ser revertida.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    }).then((result) => {
        if (result.value == true) {
            var row = $(this).closest('tr');

            row.remove();

            Swal.fire(
                'Excluído!',
                'O endereço selecionado foi excluído.',
                'success'
            )
        }
    })
});

// Excluir preços
$('#lista-precos').on('click', '.btn-del-preco', function () {
    Swal.fire({
        title: 'Confirma a exclusão?',
        text: "Essa ação não poderá ser revertida.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    }).then((result) => {
        if (result.value == true) {
            var row = $(this).closest('tr');

            row.remove();

            Swal.fire(
                'Excluído!',
                'O endereço selecionado foi excluído.',
                'success'
            )
        }
    })
});

// Excluir fornecedores
$('#lista-fornecedores').on('click', '.btn-del-fornec', function () {
    Swal.fire({
        title: 'Confirma a exclusão?',
        text: "Essa ação não poderá ser revertida.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    }).then((result) => {
        if (result.value == true) {
            var row = $(this).closest('tr');

            row.remove();

            Swal.fire(
                'Excluído!',
                'O endereço selecionado foi excluído.',
                'success'
            )
        }
    })
});

// Excluir imagens
$('#lista-imagens').on('click', '.btn-del-imagem', function () {
    Swal.fire({
        title: 'Confirma a exclusão?',
        text: "Essa ação não poderá ser revertida.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    }).then((result) => {
        if (result.value == true) {
            var row = $(this).closest('tr');

            row.remove();

            Swal.fire(
                'Excluído!',
                'A imagem selecionada foi excluída.',
                'success'
            )
        }
    })
});

function setCustoReal() {
    var custo_bruto = converterParaNumero($('[name="custo_bruto"]').val());
    var custo_valor_ipi = converterParaNumero($('[name="custo_valor_ipi"]').val());
    var custo_valor_st = converterParaNumero($('[name="custo_valor_st"]').val());
    var custo_valor_frete = converterParaNumero($('[name="custo_valor_frete"]').val());
    var custo_valor_desconto = converterParaNumero($('[name="custo_valor_desconto"]').val());
    var custo_real = converterParaNumeroBrasileiro((custo_bruto + custo_valor_ipi + custo_valor_st + custo_valor_frete) - custo_valor_desconto);

    $('[name="custo_real"]').val(formatValorDecimal(custo_real));
}

