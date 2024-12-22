var csrfName = $('meta.csrf').attr('name');
var csrfHash = $('meta.csrf').attr('content');

$.ajaxPrefilter(function(options,originalOptions,jqXHR) {
    jqXHR.setRequestHeader('X-CSRF-Token', csrfHash);
});

language_PTBR = {
    "sEmptyTable": "Nenhum registro encontrado",
    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
    "sInfoPostFix": "",
    "sInfoThousands": ".",
    "sLengthMenu": "_MENU_ resultados por página",
    "sLoadingRecords": "Carregando...",
    "sProcessing": "Carregando... Aguarde...",
    "sZeroRecords": "Nenhum registro encontrado",
    "sSearch": "",
    "sSearchPlaceholder": "",
    "oPaginate": {
        "sNext": '<span class="fa fa-chevron-right"></span>',
        "sPrevious": '<span class="fa fa-chevron-left"></span>',
        "sFirst": "Primeiro",
        "sLast": "Último"
    },
    "oAria": {
        "sSortAscending": ": Ordenar colunas de forma ascendente",
        "sSortDescending": ": Ordenar colunas de forma descendente"
    },
    "select": {
        "rows": {
            "_": "Selecionado %d linhas",
            "0": "Nenhuma linha selecionada",
            "1": "Selecionado 1 linha"
        }
    }
};

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
