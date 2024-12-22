var $route = '/vendedores';

(function (window, document, $, undefined) {

    if ($('[name="tipo"]').val() == '') {
        $('[name="tipo"]').val('J');
    }

    if ($('[name="method"]').val() == 'insert') {
        $("#tipo-pj").prop("checked", true);
    }

    updateLabels();

    $('#modalForm').on('shown.bs.modal', function () {
        if ($('[name="method"]').val() == 'insert') {
            $('[name="cnpj"]').focus();
        }
        else {
            $('[name="razao_social"]').focus();
        }
    });

})(window, document, window.jQuery);

$('input[name="tipo"]').change(function () {
    updateLabels();
});

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
