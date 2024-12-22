var tableDataPreco = [];
var tableDataFornec = [];

$(document).ready(function () {
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

        calcularCustoReal();

        $(this).val(formatValorDecimal(custo_bruto));
    });

    $('[name="custo_perc_ipi"]').blur(function () {
        var custo_perc_ipi = $(this).val().replace(" ", "");
        var custo_valor_ipi = calcularValor(converterParaNumero($('[name="custo_bruto"]').val()), converterParaNumero(custo_perc_ipi));

        $('[name="custo_valor_ipi"]').val(formatValorDecimal(custo_valor_ipi));
        $(this).val(formatValorDecimal(custo_perc_ipi));

        calcularCustoReal();
    });

    $('[name="custo_valor_ipi"]').blur(function () {
        var custo_valor_ipi = $(this).val().replace(" ", "");
        var custo_final = parseFloat(converterParaNumero($('[name="custo_bruto"]').val()) + converterParaNumero(custo_valor_ipi));
        var custo_perc_ipi = calcularPercentual(converterParaNumero($('[name="custo_bruto"]').val()), custo_final);
        
        $(this).val(formatValorDecimal(custo_valor_ipi));
        $('[name="custo_perc_ipi"]').val(formatValorDecimal(custo_perc_ipi));

        calcularCustoReal();
    });

    $('[name="custo_perc_st"]').blur(function () {
        var custo_perc_st = $(this).val().replace(" ", "");
        var custo_valor_st = calcularValor(converterParaNumero($('[name="custo_bruto"]').val()), converterParaNumero(custo_perc_st));

        $(this).val(formatValorDecimal(custo_perc_st));
        $('[name="custo_valor_st"]').val(formatValorDecimal(custo_valor_st));

        calcularCustoReal();
    });

    $('[name="custo_valor_st"]').blur(function () {
        var custo_valor_st = $(this).val().replace(" ", "");
        var custo_final = parseFloat(converterParaNumero($('[name="custo_bruto"]').val()) + converterParaNumero(custo_valor_st));
        var custo_perc_st = calcularPercentual(converterParaNumero($('[name="custo_bruto"]').val()), custo_final);

        $(this).val(formatValorDecimal(custo_valor_st));
        $('[name="custo_perc_st"]').val(formatValorDecimal(custo_perc_st));

        calcularCustoReal();
    });

    $('[name="custo_perc_frete"]').blur(function () {
        var custo_perc_frete = $(this).val().replace(" ", "");
        var custo_valor_frete = calcularValor(converterParaNumero($('[name="custo_bruto"]').val()), converterParaNumero(custo_perc_frete));

        $(this).val(formatValorDecimal(custo_perc_frete));
        $('[name="custo_valor_frete"]').val(formatValorDecimal(custo_valor_frete));

        calcularCustoReal();
    });

    $('[name="custo_valor_frete"]').blur(function () {
        var custo_valor_frete = $(this).val().replace(" ", "");
        var custo_final = parseFloat(converterParaNumero($('[name="custo_bruto"]').val()) + converterParaNumero(custo_valor_frete));
        var custo_perc_frete = calcularPercentual(converterParaNumero($('[name="custo_bruto"]').val()), custo_final);

        $(this).val(formatValorDecimal(custo_valor_frete));
        $('[name="custo_perc_frete"]').val(formatValorDecimal(custo_perc_frete));

        calcularCustoReal();
    });

    $('[name="custo_perc_desconto"]').blur(function () {
        var custo_perc_desconto = $(this).val().replace(" ", "");
        var custo_valor_desconto = calcularValor(converterParaNumero($('[name="custo_bruto"]').val()), converterParaNumero(custo_perc_desconto));

        $(this).val(formatValorDecimal(custo_perc_desconto));
        $('[name="custo_valor_desconto"]').val(formatValorDecimal(custo_valor_desconto));

        calcularCustoReal();
    });

    $('[name="custo_valor_desconto"]').blur(function () {
        var custo_valor_desconto = $(this).val().replace(" ", "");
        var custo_final = parseFloat(converterParaNumero($('[name="custo_bruto"]').val()) + converterParaNumero(custo_valor_desconto));
        var custo_perc_desconto = calcularPercentual(converterParaNumero($('[name="custo_bruto"]').val()), custo_final);

        $(this).val(formatValorDecimal(custo_valor_desconto));
        $('[name="custo_perc_desconto"]').val(formatValorDecimal(custo_perc_desconto));

        calcularCustoReal();
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

function calcularCustoReal() {
    var custo_bruto = converterParaNumero($('[name="custo_bruto"]').val());
    var custo_valor_ipi = converterParaNumero($('[name="custo_valor_ipi"]').val());
    var custo_valor_st = converterParaNumero($('[name="custo_valor_st"]').val());
    var custo_valor_frete = converterParaNumero($('[name="custo_valor_frete"]').val());
    var custo_valor_desconto = converterParaNumero($('[name="custo_valor_desconto"]').val());
    var custo_real = converterParaNumeroBrasileiro((custo_bruto + custo_valor_ipi + custo_valor_st + custo_valor_frete) - custo_valor_desconto);

    $('[name="custo_real"]').val(formatValorDecimal(custo_real));
}

// Abrir o modal de cadastro de unidades
$('.btn-add-unidade').on('click', function () {
    var dataURL = 'unidades/add_modal';
    var title = 'Nova Unidade';

    $('#modalAddUnidadeLabel').html(title);

    $('.modal-body-add-unidade').load(dataURL, function () {
        $('#modalAddUnidade').modal({
            show: true
        });
    });
});

// Submeter o formulário de cadastro de nova unidade
$(document).on('click', '.modal-confirm-unidade', function (e) {
    e.preventDefault();

    var $this = this;
    var $validator = $("#formAddUnidade").validate();

    if ($validator.form()) {
        var formData = new FormData($("form[id='formAddUnidade']")[0]);

        $($this).attr('disabled', 'disabled');
        $($this).text("Aguarde...");

        $.ajax({
            type: 'POST',
            url: 'unidades/insert',
            data: formData,
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#responseUnidade').html('');
            },
            success: function (response) {
                if (!response.error) {
                    if (response.info) {
                        $('#responseUnidade').html('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + response.info + '</div>');
                    }
                    if (response.success) {
                        $('#responseUnidade').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + response.success + '</div>');
                    }
                }

                if (response.error) {
                    var output = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + response.error;

                    if (response.errors_model) {
                        output += '<ul class="">';

                        if (Array.isArray(response.errors_model)) {
                            $.each(response.errors_model, function (key, value) {
                                output += '<li class="text-danger">' + value + '</li>';
                            });
                        } else {
                            output += '<li class="text-danger">' + response.errors_model + '</li>';
                        }

                        output += '</ul>';
                    }

                    output += '</div>';

                    $('#responseUnidade').html(output);
                }

                if (response.error) { } else {
                    var unidadeNova = new Option(response.descricao, response.id, true, true);

                    $('[name="unidade_entrada_id"]').append(unidadeNova).trigger('change');
                    $('[name="unidade_saida_id"]').append(unidadeNova).trigger('change');

                    setTimeout(function () {
                        $('#modalAddUnidade').modal('hide');
                    }, 1000);
                }

                $($this).text('Salvar');
                $($this).removeAttr('disabled');
            },
            error: function () {
                $('#responseUnidade').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Não foi possível processar a solicitação. Por favor, entre em contato com o Suporte Técnico.</div>');
                $($this).text('Salvar');
                $($this).removeAttr('disabled');
            }
        });
    }
});

$('#modalAddUnidade').on('shown.bs.modal', function () {
    $('[name="descricao"]').focus();
});

// Abrir o modal de cadastro de marcas
$('.btn-add-marca').on('click', function () {
    var dataURL = 'marcas/add_modal';
    var title = 'Nova Marca';

    $('#modalAddMarcaLabel').html(title);

    $('.modal-body-add-marca').load(dataURL, function () {
        $('#modalAddMarca').modal({
            show: true
        });
    });
});

// Submeter o formulário de cadastro de nova marca
$(document).on('click', '.modal-confirm-marca', function (e) {
    e.preventDefault();

    var $this = this;
    var $validator = $("#formAddMarca").validate();

    if ($validator.form()) {
        var formData = new FormData($("form[id='formAddMarca']")[0]);

        $($this).attr('disabled', 'disabled');
        $($this).text("Aguarde...");

        $.ajax({
            type: 'POST',
            url: 'marcas/insert',
            data: formData,
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#responseMarca').html('');
            },
            success: function (response) {
                if (!response.error) {
                    if (response.info) {
                        $('#responseMarca').html('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + response.info + '</div>');
                    }
                    if (response.success) {
                        $('#responseMarca').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + response.success + '</div>');
                    }
                }

                if (response.error) {
                    var output = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + response.error;

                    if (response.errors_model) {
                        output += '<ul class="">';

                        if (Array.isArray(response.errors_model)) {
                            $.each(response.errors_model, function (key, value) {
                                output += '<li class="text-danger">' + value + '</li>';
                            });
                        } else {
                            output += '<li class="text-danger">' + response.errors_model + '</li>';
                        }

                        output += '</ul>';
                    }

                    output += '</div>';

                    $('#responseMarca').html(output);
                }

                if (response.error) { } else {
                    var marcaNova = new Option(response.descricao, response.id, true, true);

                    $('[name="marca_id"]').append(marcaNova).trigger('change');

                    setTimeout(function () {
                        $('#modalAddMarca').modal('hide');
                    }, 1000);
                }

                $($this).text('Salvar');
                $($this).removeAttr('disabled');
            },
            error: function () {
                $('#responseMarca').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Não foi possível processar a solicitação. Por favor, entre em contato com o Suporte Técnico.</div>');
                $($this).text('Salvar');
                $($this).removeAttr('disabled');
            }
        });
    }
});

$('#modalAddMarca').on('shown.bs.modal', function () {
    $('[name="descricao"]').focus();
});

// Abrir o modal de cadastro de modelos
$('.btn-add-modelo').on('click', function () {
    var dataURL = 'modelos/add_modal';
    var title = 'Novo Modelo';

    $('#modalAddModeloLabel').html(title);

    $('.modal-body-add-modelo').load(dataURL, function () {
        $('#modalAddModelo').modal({
            show: true
        });
    });
});

// Submeter o formulário de cadastro de novo modelo
$(document).on('click', '.modal-confirm-modelo', function (e) {
    e.preventDefault();

    var $this = this;
    var $validator = $("#formAddModelo").validate();

    if ($validator.form()) {
        var formData = new FormData($("form[id='formAddModelo']")[0]);

        $($this).attr('disabled', 'disabled');
        $($this).text("Aguarde...");

        $.ajax({
            type: 'POST',
            url: 'modelos/insert',
            data: formData,
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#responseModelo').html('');
            },
            success: function (response) {
                if (!response.error) {
                    if (response.info) {
                        $('#responseModelo').html('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + response.info + '</div>');
                    }
                    if (response.success) {
                        $('#responseModelo').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + response.success + '</div>');
                    }
                }

                if (response.error) {
                    var output = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + response.error;

                    if (response.errors_model) {
                        output += '<ul class="">';

                        if (Array.isArray(response.errors_model)) {
                            $.each(response.errors_model, function (key, value) {
                                output += '<li class="text-danger">' + value + '</li>';
                            });
                        } else {
                            output += '<li class="text-danger">' + response.errors_model + '</li>';
                        }

                        output += '</ul>';
                    }

                    output += '</div>';

                    $('#responseModelo').html(output);
                }

                if (response.error) { } else {
                    var modeloNovo = new Option(response.descricao, response.id, true, true);

                    $('[name="modelo_id"]').append(modeloNovo).trigger('change');

                    setTimeout(function () {
                        $('#modalAddModelo').modal('hide');
                    }, 1000);
                }

                $($this).text('Salvar');
                $($this).removeAttr('disabled');
            },
            error: function () {
                $('#responseModelo').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Não foi possível processar a solicitação. Por favor, entre em contato com o Suporte Técnico.</div>');
                $($this).text('Salvar');
                $($this).removeAttr('disabled');
            }
        });
    }
});

$('#modalAddModelo').on('shown.bs.modal', function () {
    $('[name="descricao"]').focus();
});

// Abrir o modal de cadastro de grupos
$('.btn-add-grupo').on('click', function () {
    var dataURL = 'grupos/add_modal';
    var title = 'Novo Grupo';

    $('#modalAddGrupoLabel').html(title);

    $('.modal-body-add-grupo').load(dataURL, function () {
        $('#modalAddGrupo').modal({
            show: true
        });
    });
});

// Submeter o formulário de cadastro de novo grupo
$(document).on('click', '.modal-confirm-grupo', function (e) {
    e.preventDefault();

    var $this = this;
    var $validator = $("#formAddGrupo").validate();

    if ($validator.form()) {
        var formData = new FormData($("form[id='formAddGrupo']")[0]);

        $($this).attr('disabled', 'disabled');
        $($this).text("Aguarde...");

        $.ajax({
            type: 'POST',
            url: 'grupos/insert',
            data: formData,
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#responseGrupo').html('');
            },
            success: function (response) {
                if (!response.error) {
                    if (response.info) {
                        $('#responseGrupo').html('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + response.info + '</div>');
                    }
                    if (response.success) {
                        $('#responseGrupo').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + response.success + '</div>');
                    }
                }

                if (response.error) {
                    var output = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + response.error;

                    if (response.errors_model) {
                        output += '<ul class="">';

                        if (Array.isArray(response.errors_model)) {
                            $.each(response.errors_model, function (key, value) {
                                output += '<li class="text-danger">' + value + '</li>';
                            });
                        } else {
                            output += '<li class="text-danger">' + response.errors_model + '</li>';
                        }

                        output += '</ul>';
                    }

                    output += '</div>';

                    $('#responseGrupo').html(output);
                }

                if (response.error) { } else {
                    var modeloNovo = new Option(response.descricao, response.id, true, true);

                    $('[name="grupo_id"]').append(modeloNovo).trigger('change');

                    setTimeout(function () {
                        $('#modalAddGrupo').modal('hide');
                    }, 1000);
                }

                $($this).text('Salvar');
                $($this).removeAttr('disabled');
            },
            error: function () {
                $('#responseGrupo').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Não foi possível processar a solicitação. Por favor, entre em contato com o Suporte Técnico.</div>');
                $($this).text('Salvar');
                $($this).removeAttr('disabled');
            }
        });
    }
});

$('#modalAddGrupo').on('shown.bs.modal', function () {
    $('[name="descricao"]').focus();
});

// Abrir o modal de cadastro de seções
$('.btn-add-secao').on('click', function () {
    var dataURL = 'secoes/add_modal';
    var title = 'Nova Seção';

    $('#modalAddSecaoLabel').html(title);

    $('.modal-body-add-secao').load(dataURL, function () {
        $('#modalAddSecao').modal({
            show: true
        });
    });
});

// Submeter o formulário de cadastro de nova seção
$(document).on('click', '.modal-confirm-secao', function (e) {
    e.preventDefault();

    var $this = this;
    var $validator = $("#formAddSecao").validate();

    if ($validator.form()) {
        var formData = new FormData($("form[id='formAddSecao']")[0]);

        $($this).attr('disabled', 'disabled');
        $($this).text("Aguarde...");

        $.ajax({
            type: 'POST',
            url: 'secoes/insert',
            data: formData,
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#responseSecao').html('');
            },
            success: function (response) {
                if (!response.error) {
                    if (response.info) {
                        $('#responseSecao').html('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + response.info + '</div>');
                    }
                    if (response.success) {
                        $('#responseSecao').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + response.success + '</div>');
                    }
                }

                if (response.error) {
                    var output = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + response.error;

                    if (response.errors_model) {
                        output += '<ul class="">';

                        if (Array.isArray(response.errors_model)) {
                            $.each(response.errors_model, function (key, value) {
                                output += '<li class="text-danger">' + value + '</li>';
                            });
                        } else {
                            output += '<li class="text-danger">' + response.errors_model + '</li>';
                        }

                        output += '</ul>';
                    }

                    output += '</div>';

                    $('#responseSecao').html(output);
                }

                if (response.error) { } else {
                    var secaoNova = new Option(response.descricao, response.id, true, true);

                    $('[name="secao_id"]').append(secaoNova).trigger('change');

                    setTimeout(function () {
                        $('#modalAddSecao').modal('hide');
                    }, 1000);
                }

                $($this).text('Salvar');
                $($this).removeAttr('disabled');
            },
            error: function () {
                $('#responseSecao').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Não foi possível processar a solicitação. Por favor, entre em contato com o Suporte Técnico.</div>');
                $($this).text('Salvar');
                $($this).removeAttr('disabled');
            }
        });
    }
});

$('#modalAddSecao').on('shown.bs.modal', function () {
    $('[name="descricao"]').focus();
});

// Abrir o modal de cadastro de tabela de preços
$('.btn-add-tabela').on('click', function () {
    var dataURL = 'tabelasprecos/add_modal';
    var title = 'Nova Tabela';

    $('#modalAddTabelaLabel').html(title);

    $('.modal-body-add-tabela').load(dataURL, function () {
        $('#modalAddTabela').modal({
            show: true
        });
    });
});

// Submeter o formulário de cadastro de nova tabela de preços
$(document).on('click', '.modal-confirm-tabela', function (e) {
    e.preventDefault();

    var $this = this;
    var $validator = $("#formAddTabela").validate();

    if ($validator.form()) {
        var formData = new FormData($("form[id='formAddTabela']")[0]);

        $($this).attr('disabled', 'disabled');
        $($this).text("Aguarde...");

        $.ajax({
            type: 'POST',
            url: 'tabelasprecos/insert',
            data: formData,
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#responseTabela').html('');
            },
            success: function (response) {
                if (!response.error) {
                    if (response.info) {
                        $('#responseTabela').html('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + response.info + '</div>');
                    }
                    if (response.success) {
                        $('#responseTabela').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + response.success + '</div>');
                    }
                }

                if (response.error) {
                    var output = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + response.error;

                    if (response.errors_model) {
                        output += '<ul class="">';

                        if (Array.isArray(response.errors_model)) {
                            $.each(response.errors_model, function (key, value) {
                                output += '<li class="text-danger">' + value + '</li>';
                            });
                        } else {
                            output += '<li class="text-danger">' + response.errors_model + '</li>';
                        }

                        output += '</ul>';
                    }

                    output += '</div>';

                    $('#responseTabela').html(output);
                }

                if (response.error) { } else {
                    var tabelaNova = new Option(response.descricao, response.id, true, true);

                    $('[name="tabela"]').append(tabelaNova).trigger('change');

                    setTimeout(function () {
                        $('#modalAddTabela').modal('hide');
                    }, 1000);
                }

                $($this).text('Salvar');
                $($this).removeAttr('disabled');
            },
            error: function () {
                $('#responseTabela').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Não foi possível processar a solicitação. Por favor, entre em contato com o Suporte Técnico.</div>');
                $($this).text('Salvar');
                $($this).removeAttr('disabled');
            }
        });
    }
});

$('#modalAddTabela').on('shown.bs.modal', function () {
    $('[name="descricao"]').focus();
});

// Abrir o modal de cadastro de fornecedores
$('.btn-add-fornecedor').on('click', function () {
    var dataURL = '/fornecedores/add_modal';
    var title = 'Novo Fornecedor';

    $('#modalAddFornecedorLabel').html(title);

    $('.modal-body-add-fornecedor').load(dataURL, function () {
        $('#modalAddFornecedor').modal({
            show: true
        });
    });
});

// Submeter o formulário de cadastro de novo fornecedor
$(document).on('click', '.modal-confirm-fornecedor', function (e) {
    e.preventDefault();

    var $this = this;
    var $validator = $("#formAddFornecedor").validate();

    if ($validator.form()) {
        var formData = new FormData($("form[id='formAddFornecedor']")[0]);

        $($this).attr('disabled', 'disabled');
        $($this).text("Aguarde...");

        $.ajax({
            type: 'POST',
            url: 'fornecedores/insert',
            data: formData,
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#responseFornecedor').html('');
            },
            success: function (response) {
                if (!response.error) {
                    if (response.info) {
                        $('#responseFornecedor').html('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + response.info + '</div>');
                    }
                    if (response.success) {
                        $('#responseFornecedor').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + response.success + '</div>');
                    }
                }

                if (response.error) {
                    var output = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + response.error;

                    if (response.errors_model) {
                        output += '<ul class="">';

                        if (Array.isArray(response.errors_model)) {
                            $.each(response.errors_model, function (key, value) {
                                output += '<li class="text-danger">' + value + '</li>';
                            });
                        } else {
                            output += '<li class="text-danger">' + response.errors_model + '</li>';
                        }

                        output += '</ul>';
                    }

                    output += '</div>';

                    $('#responseFornecedor').html(output);
                }

                if (response.error) { } else {
                    var fornecedorNovo = new Option(response.razao_social, response.id, true, true);

                    $('[name="fornecedor"]').append(fornecedorNovo).trigger('change');

                    setTimeout(function () {
                        $('#modalAddFornecedor').modal('hide');
                    }, 1000);
                }

                $($this).text('Salvar');
                $($this).removeAttr('disabled');
            },
            error: function () {
                $('#responseFornecedor').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Não foi possível processar a solicitação. Por favor, entre em contato com o Suporte Técnico.</div>');
                $($this).text('Salvar');
                $($this).removeAttr('disabled');
            }
        });
    }
});

$('#modalAddFornecedor').on('shown.bs.modal', function () {
    $('[name="cnpj"]').focus();
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
    newRow.append($('<td class="center">').html('<button type="button" data-toggle="tooltip" data-original-title="Excluir" title="Excluir" data-tabela="' + id_tabela + '" class="btn btn-xs btn-default btn-width-27 btn-del-tabela"><i class="fas fa-trash-alt text-danger"></i></button>'));

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
    newRow.append($('<td class="center">').html('<button type="button" data-toggle="tooltip" data-original-title="Excluir" title="Excluir" data-fornecedor="' + id_fornecedor + '" class="btn btn-xs btn-default btn-width-27 btn-del-tabela"><i class="fas fa-trash-alt text-danger"></i></button>'));

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
