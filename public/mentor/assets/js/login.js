$(document).ready(function() {
    $("#signInForm").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 5
            },
        },
        messages: {
            email: "Informe seu e-mail de usuário",
            password: {
                required: "Informe sua senha",
                minlength: "Sua senha deve ter, pelo menos, 5 caracteres"
            },
        },
        errorElement: "em",
        errorPlacement: function(error, element) {
            error.addClass("text-danger");

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

    $('#signInForm').on('submit', function(e) {
        e.preventDefault();

        if (($('[name="email"]').val() == '') || ($('[name="password"]').val() == '')) {
            return false;
        }

        $.ajax({
            type: 'POST',
            url: 'login/authenticate',
            data: new FormData(this),
            dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function() {
                $('#response').html('');
                $('.btn-login').text('Aguarde...');
                $('.btn-login').attr('disabled', 'disabled');
            },
            success: function(response) {
                $('[name="csrf_token_erpsys"]').val(response.token);

                if (!response.error) {
                    window.location.href = response.redirect;
                }

                if (response.error) {
                    var response = '<div class="alert alert-icon alert-inverse-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="ti ti-close"></i></button>' + response.error;

                    if (response.errors_model) {
                        response += '<ul class="list-unstyled">';

                        $.each(response.errors_model, function(key, value) {
                            response += '<li class="text-danger">' + value + '</li>';
                        });

                        response += '</ul>';
                    }

                    response += '</div>';

                    $('#response').html(response);
                    $('.btn-login').text('Entrar');
                    $('.btn-login').removeAttr('disabled');
                }
            },
            error: function(error) {
                if (error.responseJSON.message) {
                    $('#response').html('<div class="alert alert-icon alert-inverse-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="ti ti-close"></i></button>' + error.responseJSON.message + '</div>');
                }
                else {
                    $('#response').html('<div class="alert alert-icon alert-inverse-danger alert-dismissible fade show" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><i class="ti ti-close"></i></button>Não foi possível processar a solicitação. Por favor, entre em contato com o Suporte Técnico.</div>');
                }
                $('.btn-login').text('Entrar');
                $('.btn-login').removeAttr('disabled');
            }
        });
    });
});
