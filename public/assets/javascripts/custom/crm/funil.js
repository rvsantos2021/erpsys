var $route = 'funil';
var tableDataEtapas = [];

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
            'targets': 2,
            'className': 'center',
            'orderable': 'false',
            "order": []
        },
        {
            'targets': 3,
            'className': 'center',
            'orderable': 'false',
            "order": []
        },]
    });

    $('#modalForm').on('shown.bs.modal', function() {
        $('[name="descricao"]').focus();
    });
});

$('#table-list').on('click', '.btn-etapa', function (e) {
    e.preventDefault();

    var id = $(this).closest('tr').attr('id');
    var dataURL = $route + '/etapas/' + id;
    var title = 'Etapas do Funil de Vendas';

    $('#modalEtapaLabel').html(title);

    $('.modal-body-etapa').load(dataURL, function () {
        $('#modalEtapa').modal({
            show: true
        });
    });

    $('#modalEtapa').on('shown.bs.modal', function () {
        $('[name="etapa"]').focus();
    });
});

$(document).on('click', '.btn-add-etapa', function (e) {
    var etapa = $('[name="etapa"]').val();

    if (etapa == '') {
        return;
    }

    var etapaExists = tableDataEtapas.some(function (item) {
        return item.etapa === etapa;
    });

    if (etapaExists) {
        Swal.fire({
            icon: 'info',
            width: 300,
            title: 'Atenção!',
            html: 'A etapa informada já está cadastrada!',
        })

        return;
    }

    var newRow = $('<tr>');

    newRow.append($('<td>').html('<input type="hidden" name="etapa_nome[]" value="' + etapa + '" /><span>' + etapa + '</span>'));
    newRow.append($('<td class="center">').html('<button type="button" data-toggle="tooltip" data-original-title="Excluir" title="Excluir" data-etapa="' + etapa + '" class="btn btn-xs btn-default btn-width-27 btn-del-etapa"><i class="fas fa-trash-alt text-danger"></i></button>'));

    $('#table-etapas tbody').append(newRow);

    tableDataEtapas.push({
        etapa: etapa
    });

    $('[name="etapa"]').val('');
});

$(document).on('click', '.modal-confirm-etapa', function (e) {
    e.preventDefault();

    var $this = this;
    var $method = 'etapas_save';
    var $validator = $("#formEtapa").validate();

    if ($validator.form()) {
        var formData = new FormData($("form[id='formEtapa']")[0]);

        $($this).attr('disabled', 'disabled');
        $($this).text("Aguarde...");

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
                        $('#response').html('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + response.info + '</div>');
                    }
                    if (response.success) {
                        $('#response').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + response.success + '</div>');
                    }
                }

                if (response.error) {
                    var output = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + response.error;

                    if (response.errors_model) {
                        output += '<ul class="">';

                        $.each(response.errors_model, function (key, value) {
                            output += '<li class="text-danger">' + value + '</li>';
                        });

                        output += '</ul>';
                    }

                    output += '</div>';

                    $('#response').html(output);

                    $($this).val('Salvar');
                    $($this).removeAttr('disabled');
                }

                setTimeout(function () {
                    $('#modalEtapa').modal('hide');
                }, 1000);

                //$('#table-etapas').DataTable().ajax.reload();

                $($this).text('Salvar');
                $($this).removeAttr('disabled');
            },
            error: function () {
                $('#response').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Não foi possível processar a solicitação. Por favor, entre em contato com o Suporte Técnico.</div>');
                $($this).text('Salvar');
                $($this).removeAttr('disabled');
            }
        });
    }
});
