$(document).ready(function () {
    $('.selectize').selectize();
});

$('.btn-add-banco').on('click', function () {
    var dataURL = 'bancos/add_modal';
    var title = 'Novo Banco';

    $('#modalAddBancoLabel').html(title);

    $('.modal-body-add-banco').load(dataURL, function () {
        $('#modalAddBanco').modal({
            show: true
        });
    });
});

// Submeter o formulário de cadastro de novo banco
$(document).on('click', '.modal-confirm-banco', function (e) {
    e.preventDefault();

    var $this = this;
    var $validator = $("#formAddBanco").validate();

    if ($validator.form()) {
        var formData = new FormData($("form[id='formAddBanco']")[0]);

        $($this).attr('disabled', 'disabled');
        $($this).text("Aguarde...");

        $.ajax({
            type: 'POST',
            url: 'bancos/insert',
            data: formData,
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                $('#responseBanco').html('');
            },
            success: function (response) {
                if (!response.error) {
                    if (response.info) {
                        $('#responseBanco').html('<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + response.info + '</div>');
                    }
                    if (response.success) {
                        $('#responseBanco').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + response.success + '</div>');
                    }
                }

                if (response.error) {
                    var output = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + response.error;

                    if (response.errors_model) {
                        output += '<ul class="">';

                        if (Array.isArray(response.errors_model)) {
                            $.each(response.errors_model, function (key, value) {
                                output += '<li class="text-danger">' + value + '</li>';
                            });
                        } else {
                            output += '<li class="text-danger">' + response.errors_model + '</li>';
                        }

                        output += '</ul>';
                    }

                    output += '</div>';

                    $('#responseBanco').html(output);

                    $($this).val('Salvar');
                    $($this).removeAttr('disabled');
                }

                if (response.error) { } else {
                    var bancoNovo = new Option(response.descricao, response.id, true, true);

                    $('[name="banco_id"]').append(bancoNovo).trigger('change');

                    setTimeout(function () {
                        $('#modalAddBanco').modal('hide');
                    }, 1000);
                }
            },
            error: function () {
                $('#responseBanco').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Não foi possível processar a solicitação. Por favor, entre em contato com o Suporte Técnico.</div>');
                $($this).text('Salvar');
                $($this).removeAttr('disabled');
            }
        });
    }
});