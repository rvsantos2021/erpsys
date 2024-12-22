$(document).ready(function() {
    $("#resetForm").validate({
        rules: {
            password: {
                required: true,
                minlength: 6
            },
            password_confirmation: {
                required: true,
                minlength: 6
            },
        },
        messages: {
            password: {
                required: "Informe sua senha",
                minlength: "Sua senha deve ter, pelo menos, 6 caracteres"
            },
            password_confirmation: {
                required: "Confirme sua senha",
                minlength: "Sua senha deve ter, pelo menos, 6 caracteres"
            },
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

    $('#resetForm').on('submit', function(e) {
        e.preventDefault();

        if (($('[name="email"]').val() == '') || ($('[name="password"]').val() == '')) {
            return false;
        }

        $.ajax({
            type: 'POST',
            url: '/login/reset_proccess',
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('#response').html('');
                $('.btn-reset').text('Aguarde...');
                $('.btn-reset').attr('disabled', 'disabled');
            },
            success: function(response) {
                $('[name="csrf_token_erpsys"]').val(response.token);

                if (!response.error) {
                    window.location.href = '/login';
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
                    $('.btn-reset').text('Redefinir');
                    $('.btn-reset').removeAttr('disabled');
                }
            },
            error: function(error) {
                if (error.responseJSON.message) {
                    $('#response').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' + error.responseJSON.message + '</div>');
                }
                else {
                    $('#response').html('<div class="alert alert-danger"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>Não foi possível processar a solicitação. Por favor, entre em contato com o Suporte Técnico.</div>');
                }
                $('.btn-reset').text('Redefinir');
                $('.btn-reset').removeAttr('disabled');
            }
        });
    });
});