var $route = 'grupos';

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
            $(nRow).attr('email', aData[2]);
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
            'targets': 3,
            'className': 'center',
            'orderable': 'false',
            "order": []
        },
        {
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
        },]
    });
});

$('#table-list').on('click', '.btn-perm', function(e) {
    e.preventDefault();

    var id = $(this).closest('tr').attr('id');
    var dataURL = $route + '/permissoes/' + id;
    var title = $(this).attr('title');

    $('#modalPermissionLabel').html(title);

    $('.modal-body-permission').load(dataURL, function() {
        $('#modalPermission').modal({
            show: true
        });
    });
});

$(document).on('click', '.modal-confirm-perm', function (e) {
    e.preventDefault();

    var $this = this;
    var $method = $('[name="method"]').val();
    var $validator = $("#formPermission").validate();
    
    if ($validator.form()) {
        var formData = new FormData($("form[id='formPermission']")[0]);

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
            beforeSend: function() {
                $('#response').html('');
            },
            success: function(response) {
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

                        $.each(response.errors_model, function(key, value) {
                            output += '<li class="text-danger">' + value + '</li>';
                        });

                        output += '</ul>';
                    }

                    output += '</div>';

                    $('#response').html(output);

                    $($this).val('Salvar');
                    $($this).removeAttr('disabled');
                }

                setTimeout(function() {
                    $('#modalGroup').modal('hide');
                }, 1000);

                $('#table-groups').DataTable().ajax.reload();

                $($this).text('Salvar');
                $($this).removeAttr('disabled');
            },
            error: function() {
                $('#response').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Não foi possível processar a solicitação. Por favor, entre em contato com o Suporte Técnico.</div>');
                $($this).text('Salvar');
                $($this).removeAttr('disabled');
            }
        });
    }
});
