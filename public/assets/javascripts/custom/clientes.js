var $route = 'clientes';
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
            $("#tipo-pj").prop("checked", true);
        }

        updateLabels();

        $('[name="cnpj"]').focus();
    });
});

$(document).on('click', '.btn-cep', function (e) {
    var $cep = $('[name="cep"]').val();

    if ($cep.length == 9) {
        $.ajax({
            type: 'GET',
            url: 'vendors/buscarcep',
            data: {
                cep: $cep
            },
            dataType: 'json',
            beforeSend: function() {
                $('.cep-error').html('');
                $('#form').LoadingOverlay('show');
            },
            success: function(response) {
                if (response.error) {
                    $('.cep-error').html(response.error);

                    $('#form').LoadingOverlay('hide', true);
                }
                else {
                    $('[name="logradouro"]').val(response.logradouro);
                    $('[name="bairro"]').val(response.bairro);

                    if (response.cod_ibge) {
                        getIdCidade(response.cod_ibge);
                    }

                    $('#form').LoadingOverlay('hide', true);

                    $('[name="logradouro"]').focus();    
                }
            },
            error: function(error) {
                $('#form').LoadingOverlay('hide', true);
                $('.cep-error').html('Serviço indisponível');

                console.log(error);
            }
        });   
    }
});

$(document).on('click', '.btn-add-end', function(e) {
    var cep = $('[name="cep"]').val();
    var logradouro = $('[name="logradouro"]').val();
    var numero = $('[name="numero"]').val();
    var complemento = $('[name="complemento"]').val();
    var bairro = $('[name="bairro"]').val();
    var cidade = $('[name="cidade"]').val();
    var cidade_uf = $('[name="cidade"]').text();
    var tipo = $('[name="tipo_end"]').val();
    var tipo_end = $('[name="tipo_end"]').text();

    if ((cep == '') && (logradouro == '') && (numero == '') && (complemento == '') && (bairro == '') && (cidade == '') && (tipo_end == '')) {
        return;
    }

    var cepExists = tableDataEnd.some(function(item) {
        return item.cep === cep;
    });

    if (cepExists) {
        Swal.fire({
            icon: 'info',
            width: 300,
            title: 'Atenção!',
            html: 'O endereço informado já está cadastrado!',
        })

        return;
    }

    var newRow = $('<tr>');

    newRow.append($('<td>').html('<input type="hidden" name="end_cep[]" value="' + cep + '" /><span>' + cep + '</span>'));
    newRow.append($('<td>').html('<input type="hidden" name="end_log[]" value="' + logradouro + '" /><span>' + logradouro + '</span>'));
    newRow.append($('<td>').html('<input type="hidden" name="end_nro[]" value="' + numero + '" /><span>' + numero + '</span>'));
    newRow.append($('<td>').html('<input type="hidden" name="end_cpl[]" value="' + complemento + '" /><span>' + complemento + '</span>'));
    newRow.append($('<td>').html('<input type="hidden" name="end_bai[]" value="' + bairro + '" /><span>' + bairro + '</span>'));
    newRow.append($('<td>').html('<input type="hidden" name="end_cid[]" value="' + cidade + '" /><span>' + cidade_uf + '</span>'));
    newRow.append($('<td>').html('<input type="hidden" name="end_tip[]" value="' + tipo + '" /><span>' + tipo_end + '</span>'));
    newRow.append($('<td class="center">').html('<button type="button" data-toggle="tooltip" data-original-title="Excluir" title="Excluir" data-cep="' + cep + '" class="btn btn-xs btn-default btn-width-27 btn-del-end"><i class="fas fa-trash-alt text-danger"></i></button>'));

    $('#table-enderecos tbody').append(newRow);

    tableDataEnd.push({
        cep: cep,
        logradouro: logradouro,
        numero: numero,
        complemento: complemento,
        bairro: bairro,
        cidade: cidade,
        tipo: tipo
    });

    $('[name="cep"]').val('');
    $('[name="logradouro"]').val('');
    $('[name="numero"]').val('');
    $('[name="complemento"]').val('');
    $('[name="bairro"]').val('');
    $('[name="cidade"]').val('');
    $('[name="tipo"]').val('');

    document.getElementById("cidade").selectize.setValue(0);
    document.getElementById("tipo_end").selectize.setValue(0);
});

function getIdCidade($cod_ibge) {
    $.ajax({
        type: 'GET',
        url: 'cidades/buscaridcidade',
        data: {
            cod_ibge: $cod_ibge
        },
        dataType: 'json',
        success: function(response) {
            $('[name="id_cidade"]').val(response[0].id);
            
            document.getElementById("cidade").selectize.setValue($('[name="id_cidade"]').val());
        },
        error: function(error) {
            console.log(error);
        }
    });   
}

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
