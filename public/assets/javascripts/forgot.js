$(document).ready(function() {
    $("#forgotForm").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
        },
        messages: {
            email: "Informe seu e-mail de usuário",
        },
        errorElement: "em",
        errorPlacement: function(error, element) {
            error.addClass("help-block");

            if (element.prop("type") === "checkbox") {
                error.insertAfter(element.parent("label"));
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function(element, errorClass, validClass) {
            $(element).parents(".form-group").addClass("has-error").removeClass("has-success");
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents(".form-group").addClass("has-success").removeClass("has-error");
        }
    });

    $('#forgotForm').on('submit', function(e) {
        e.preventDefault();

        if ($('[name="email"]').val() == '') {
            return false;
        }

        $.ajax({
            type: 'POST',
            url: 'forgot_process',
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('#response').html('');
                $('.btn-forgot').text('Aguarde...');
                $('.btn-forgot').attr('disabled', 'disabled');
            },
            success: function(response) {
                $('[name="csrf_token_erpsys"]').val(response.token);

                if (!response.error) {
                    $('#response').html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + response.success + '</div>');
                }

                if (response.error) {
                    var response = '<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + response.error;

                    if (response.errors_model) {
                        response += '<ul class="list-unstyled">';

                        $.each(response.errors_model, function(key, value) {
                            response += '<li class="text-danger">' + value + '</li>';
                        });

                        response += '</ul>';
                    }

                    response += '</div>';

                    $('#response').html(response);
                }
                
                $('.btn-forgot').text('Enviar');
                $('.btn-forgot').removeAttr('disabled');
            },
            error: function(error) {
                if (error.responseJSON.message) {
                    $('#response').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + error.responseJSON.message + '</div>');
                }
                else {
                    $('#response').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Não foi possível processar a solicitação. Por favor, entre em contato com o Suporte Técnico.</div>');
                }
                $('.btn-forgot').text('Enviar');
                $('.btn-forgot').removeAttr('disabled');
            }
        });
    });
});