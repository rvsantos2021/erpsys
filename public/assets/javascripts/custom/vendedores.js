var $route = 'vendedores';
var tableDataEnd = [];

$(document).ready(function() {
    $('#table-list').DataTable({
        dom: 'Bfrtip',
        buttons: [
            { 
                'extend': 'excelHtml5', 
                'text': '<i class="fa fa-file-excel-o"></i>',
                'exportOptions': {
                    columns: [ 0,1,2 ]
                }
            },
            { 
                'extend': 'csvHtml5', 
                'text': '<i class="fa fa-file-text"></i>',
                'exportOptions': {
                    columns: [ 0,1,2 ]
                }
            },
            { 
                'extend': 'pdfHtml5', 
                'text': '<i class="fa fa-file-pdf-o"></i>', 
                'exportOptions': {
                    columns: [ 0,1,2 ]
                }
            },
            { 
                'extend': 'print', 
                'text': '<i class="fa fa-print"></i>',
                'exportOptions': {
                    columns: [ 0,1,2 ]
                }
            },
        ],
        "fnCreatedRow": function(nRow, aData) {
            $(nRow).attr('id', aData[0]);
            $(nRow).attr('name', aData[1]);
        },
        'oLanguage': language_PTBR,
        'serverSide': 'true',
        'processing': 'true',
        'paging': 'true',
        'ordering': 'false',
        'order': [],
        'ajax': {
            'url': $route + '/fetch',
            'type': 'post',
            data: function (d) {
                d.csrfName = csrfHash;
            },
            error: function(err){
                console.log(err.responseText);
            }
        },
        'columnDefs': [{
            'targets': 4,
            'className': 'center',
            'orderable': 'false',
            "order": []
        },
        {
            'targets': 5,
            'className': 'center',
            'orderable': 'false',
            "order": []
        },
        {
            'targets': 6,
            'className': 'center',
            'orderable': 'false',
            "order": []
        },]
    });

    $('#modalForm').on('shown.bs.modal', function() {
        if ($('[name="method"]').val() == 'insert') {
            $("#tipo-pf").prop("checked", true);
        }

        updateLabels();

        $('[name="cnpj"]').focus();
    });
});

function updateLabels() {
    if ($('#tipo-pf').is(':checked')) {
        $('[name="tipo"]').val('F');

        $('#labelCNPJ').text('CPF');
        $('#labelIE').text('RG');
        $('#labelRazao').text('Nome');
        $('#labelFantasia').text('Apelido');
        $('#labelData').text('Data Nascimento');

        $('[name="cnpj"]').attr({
            placeholder: 'CPF', 
            maxlength : '14'
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

        $('[name="cnpj"]').data('input-mask', '999.999.999-99');
        $('[name="cnpj"]').mask('999.999.999-99', {reverse: true});   
    } else if ($('#tipo-pj').is(':checked')) {
        $('[name="tipo"]').val('J');

        $('#labelCNPJ').text('CNPJ');
        $('#labelIE').text('Inscr. Estadual');
        $('#labelRazao').text('Razão Social');
        $('#labelFantasia').text('Nome Fantasia');
        $('#labelData').text('Data Fundação');

        $('[name="cnpj"]').attr({
            placeholder: 'CNPJ', 
            maxlength : '18'
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

        $('[name="cnpj"]').data('input-mask', '99.999.999/9999-99');
        $('[name="cnpj"]').mask('99.999.999/9999-99', {reverse: true});
    }
}
