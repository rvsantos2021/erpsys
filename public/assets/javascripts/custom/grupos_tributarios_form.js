$(document).ready(function () {
    $('[name="aliquota"]').blur(function () {
        var aliquota = $(this).val().replace(" ", "");

        $(this).val(formatValorDecimal(aliquota));
    });

    $('[name="reducao"]').blur(function () {
        var reducao = $(this).val().replace(" ", "");

        $(this).val(formatValorDecimal(reducao));
    });
});
