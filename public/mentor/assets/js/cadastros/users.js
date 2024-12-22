var $route = '/usuarios';

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
                {
                    'targets': 4,
                    'className': 'text-center',
                    'orderable': 'false',
                    "order": []
                },
                {
                    'targets': 5,
                    'className': 'text-center',
                    'orderable': 'false',
                    "order": []
                },
                ]
            });
        }
    });

    $('#modalForm').on('shown.bs.modal', function () {
        $('[name="name"]').focus();
    });

})(window, document, window.jQuery);

/**
 * Abrir o modal de visualização da foto
 */
$('#datatable').on('click', '.btn-photo', function (e) {
    e.preventDefault();

    var id = $(this).attr('data-id');
    var dataURL = $route + '/view_photo/' + id;
    var title = $(this).attr('alt');

    $('#modalViewLabel').html(title);

    $('.modal-body-view').load(dataURL, function () {
        $('#modalView').modal({
            show: true
        });
    });
});

/**
 * Abrir o modal de grupos de usuários
 */
$('#datatable').on('click', '.btn-grupo', function (e) {
    e.preventDefault();

    var id = $(this).attr('data-id');
    var dataURL = route + '/grupos/' + id;
    var title = $(this).attr('title');

    $('#modalGroupLabel').html(title);

    $('.modal-body-group').load(dataURL, function () {
        $('#modalGroup').modal({
            show: true
        });
    });
});

/**
 * Botão Salvar Grupos
 */
$(document).on('click', '.modal-confirm-group', function (e) {
    e.preventDefault();

    var $this = this;
    var $method = $('[name="method"]').val();
    var $validator = $("#formGroup").validate();
    
    if ($validator.form()) {
        var formData = new FormData($("form[id='formGroup']")[0]);

        $($this).attr('disabled', 'disabled');
        $($this).text("Aguarde...");

        $.ajax({
            type: 'POST',
            url: $route + '/groups_save',
            data: formData,
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#response').html('');
            },
            success: function (response) {
                if (response.info) {
                    $('#response').html('<div class="alert alert-icon alert-inverse-info alert-dismissible fade show" role="alert"><i class="fa fa-info-circle"></i>' + response.info + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="ti ti-close"></i></button></div>');
                }
                else if (response.success) {
                    $('#response').html('<div class="alert alert-icon alert-inverse-success alert-dismissible fade show" role="alert"><i class="fa fa-info-circle"></i>' + response.success + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="ti ti-close"></i></button></div>');
                }

                if (response.error) {
                    var output = '<div class="alert alert-icon alert-inverse-danger alert-dismissible fade show" role="alert"><i class="fa fa-info-circle"></i>' + response.error;

                    if (response.errors_model) {
                        output += '<ul class="">';

                        $.each(response.errors_model, function (key, value) {
                            output += '<li class="text-danger">' + value + '</li>';
                        });

                        output += '</ul>';
                    }

                    output += '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="ti ti-close"></i></button></div>';

                    $('#response').html(output);

                    $($this).val('Salvar');
                    $($this).removeAttr('disabled');
                }

                setTimeout(function () {
                    $($this).text('Salvar');
                    $($this).removeAttr('disabled');

                    $('#modalGroup').modal('hide');
                }, 1000);
            },
            error: function () {
                $('#response').html('<div class="alert alert-icon alert-inverse-danger alert-dismissible fade show" role="alert"><i class="fa fa-info-circle"></i>Não foi possível processar a solicitação. Por favor, entre em contato com o Suporte Técnico.<button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="ti ti-close"></i></button></div>');

                $($this).text('Salvar');
                $($this).removeAttr('disabled');
            }
        });
    }
});
