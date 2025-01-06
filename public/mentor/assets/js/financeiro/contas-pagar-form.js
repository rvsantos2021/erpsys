var $route = '/financeiro/contaspagar';
var $method = document.currentScript.getAttribute('data-method');

$(document).ready(function() {
    // Mostrar/esconder campos de parcelamento
    $('#tipoConta').change(function() {
        var tipoSelecionado = $(this).val();

        $('#parcelasContainer').toggle(tipoSelecionado === 'parcelada');
        $('#gridParcelasContainer').toggle(tipoSelecionado === 'parcelada');
    });

    // Gerar grid de parcelas
    $('#numeroParcelas, input[name="valor"]').on('change', function() {
        var numeroParcelas = parseInt($('#numeroParcelas').val()) || 1;
        var valorTotal = converterParaNumero($('input[name="valor_total"]').val()) || 0;
        var dataVencimento = $('input[name="data_vencimento"]').val();
        var corpoGrid = $('#corpoGridParcelas');

        corpoGrid.empty();

        // Função para calcular parcelas com precisão
        function calcularParcelas(total, numeroParcelas) {
            // Multiplicar por 100 para trabalhar com inteiros
            let totalCentavos = Math.round(total * 100);
            let parcelaCentavos = Math.floor(totalCentavos / numeroParcelas);
            let resto = totalCentavos % numeroParcelas;

            let parcelas = [];
            for (let i = 0; i < numeroParcelas; i++) {
                let valorParcela = parcelaCentavos + (i < resto ? 1 : 0);
                parcelas.push(valorParcela / 100);
            }

            return parcelas;
        }

        // Calcular parcelas
        var parcelas = calcularParcelas(valorTotal, numeroParcelas);

        parcelas.forEach((valorParcelaAtual, index) => {
            // Calcular data de vencimento para cada parcela
            var dataVencimentoParcela = moment(dataVencimento).add(index, 'months').format('YYYY-MM-DD');
            // Converter para formato brasileiro e formatar
            valorParcelaAtual = converterParaNumeroBrasileiro(valorParcelaAtual);
            valorParcelaAtual = formatValorDecimal(valorParcelaAtual);

            var linha = `
                <tr>
                    <td>${index + 1}/${numeroParcelas}</td>
                    <td></td>
                    <td>
                        <input type="text" name="parcela_valor[]" 
                            class="form-control money text-right parcela-valor" 
                            value="${valorParcelaAtual}" 
                            step="0.01">
                    </td>
                    <td>
                        <input type="date" name="parcela_data_vencimento[]" 
                            class="form-control parcela-data" 
                            value="${dataVencimentoParcela}">
                    </td>
                </tr>
            `;

            corpoGrid.append(linha);
        });

        // Verificar se o total das parcelas bate com o valor total
        var totalParcelas = corpoGrid.find('input[name="parcela_valor[]"]')
            .map(function() {
                return converterParaNumero($(this).val());
            }).get().reduce((a, b) => a + b, 0);
    });

    // Inicializar Select2 para todos os selects
    $(".js-basic-single").select2({
        dropdownParent: $($method == 'edit' ? "#modalEdicao" : "#modalCadastro")
    });

    $('input[name="valor_total"]').blur(function() {
        $(this).val(formatValorDecimal($(this).val()));
    });

    $('input[name="valor_desconto"]').blur(function() {
        var valorDesconto = converterParaNumero($(this).val().replace(" ", ""));
        var valorAcrescimo = converterParaNumero($('input[name="valor_acrescimo"]').val());
        var valorTotal = converterParaNumero($('[name="valor_total"]').val());
        var valorPago = valorTotal - valorDesconto + valorAcrescimo;

        $(this).val(formatValorDecimal($(this).val()));
        $('[name="valor_pago"]').val(formatValorDecimal(valorPago));
    });

    $('input[name="valor_acrescimo"]').blur(function() {
        var valorAcrescimo = converterParaNumero($(this).val().replace(" ", ""));
        var valorDesconto = converterParaNumero($('input[name="valor_desconto"]').val());
        var valorTotal = converterParaNumero($('[name="valor_total"]').val());
        var valorPago = valorTotal - valorDesconto + valorAcrescimo;

        $(this).val(formatValorDecimal($(this).val()));
        $('[name="valor_pago"]').val(formatValorDecimal(valorPago));
    });

    $('input[name="valor_pago"]').blur(function() {
        $(this).val(formatValorDecimal($(this).val()));
    });
});

$('.modal-confirm-cp').on('click', function(e) {
    e.preventDefault();

    // Verificar se é formulário de cadastro, edição ou baixa
    var form = $('#formCadastro, #formEdicao, #formBaixa').filter(':visible');
    var isEdicao = form.attr('id') === 'formEdicao';
    var isBaixa = form.attr('id') === 'formBaixa';
    var url = isBaixa ? $route + '/paybill' : isEdicao ? $route + '/update' : $route + '/store';

    // Validar campos obrigatórios
    var isValid = true;

    // Limpar validações anteriores
    form.find('.is-invalid').removeClass('is-invalid');
    form.find('.select2-selection').removeClass('border-danger');

    // Validar campos de texto e inputs normais
    form.find('input[required], textarea[required]').each(function() {
        if (!$(this).val()) {
            $(this).addClass('is-invalid');
            isValid = false;
        }
    });

    // Validar selects (incluindo Select2)
    form.find('select[required]').each(function() {
        var $select = $(this);
        var $select2Container = $select.next('.select2-container');
        
        if (!$select.val()) {
            $select2Container.find('.select2-selection').addClass('border-danger');
            isValid = false;
        }
    });
    
    if (!isValid) {
        toastr.warning('Por favor, preencha todos os campos obrigatórios.');
        return;
    }
    
    // Preparar dados do formulário
    var formData = form.serialize();
    
    // Enviar dados para o servidor
    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                toastr.success(response.message);
                $('#modalCadastro, #modalEdicao, #modalBaixa').modal('hide');
                
                // Atualizar tabela de contas a pagar
                atualizarTabelaContasPagar();
            } else {
                toastr.error(response.message || 'Erro ao salvar a conta.');
            }
        },
        error: function(xhr, status, error) {
            toastr.error('Ocorreu um erro ao salvar a conta: ' + error);
            console.error(xhr.responseText);
        }
    });
});

// Função para atualizar tabela de contas a pagar
function atualizarTabelaContasPagar() {
    if (typeof table !== 'undefined' && table !== null) {
        table.ajax.reload(null, false);
    } else {
        console.warn('Tabela de contas a pagar não inicializada');
    }
}