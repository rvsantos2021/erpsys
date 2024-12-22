var $route = '/crm/funil';
var tableDataEtapas = [];

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
                        'targets': 2,
                        'className': 'text-center',
                        'orderable': 'false',
                        "order": []
                    },
                    {
                        'targets': 3,
                        'className': 'text-center',
                        'orderable': 'false',
                        "order": []
                    },
                ]
            });
        }
    });

    $('#modalForm').on('shown.bs.modal', function () {
        $('[name="descricao"]').focus();
    });

})(window, document, window.jQuery);

$('#datatable').on('click', '.btn-etapa', function (e) {
    e.preventDefault();

    var id = $(this).attr('data-id');
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
    newRow.append($('<td class="center">').html('<button type="button" data-toggle="tooltip" data-original-title="Excluir" title="Excluir" data-etapa="' + etapa + '" class="btn btn-sm btn-icon btn-outline-danger btn-round btn-del-etapa"><i class="ti ti-trash"></i></button>'));

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
