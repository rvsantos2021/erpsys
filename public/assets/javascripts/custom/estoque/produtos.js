var $route = 'produtos';

$(document).ready(function() {
    $('#table-list').DataTable({
        dom: 'Bfrtip',
        buttons: [
            { 
                'extend': 'excelHtml5', 
                'text': '<i class="fa fa-file-excel-o"></i>',
                'exportOptions': {
                    columns: [0, 1, 2, 3]
                }
            },
            { 
                'extend': 'csvHtml5', 
                'text': '<i class="fa fa-file-text"></i>',
                'exportOptions': {
                    columns: [0, 1, 2, 3 ]
                }
            },
            { 
                'extend': 'pdfHtml5', 
                'text': '<i class="fa fa-file-pdf-o"></i>', 
                'exportOptions': {
                    columns: [0, 1, 2, 3 ]
                }
            },
            { 
                'extend': 'print', 
                'text': '<i class="fa fa-print"></i>',
                'exportOptions': {
                    columns: [0, 1, 2, 3 ]
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
        $('[name="descricao"]').focus();
    });
});

/**
 * Abrir o modal de inclusão de nova imagem
 */
$('#table-list').on('click', '.btn-photo', function (e) {
    e.preventDefault();

    var id = $(this).attr('data-id');
    var dataURL = $route + '/photo/' + id;
    var title = $(this).attr('data-original-title');

    $('#modalPhotoLabel').html(title);

    $('.modal-body-photo').load(dataURL, function () {
        $('#modalPhoto').modal({
            show: true
        });
    });
});

/**
 * Botão Salvar (inclusão de imagem)
 */
$(document).on('click', '.modal-confirm-photo', function (e) {
    e.preventDefault();

    var $this = this;
    var $validator = $("#form-photo").validate();

    if ($validator.form()) {
        var formData = new FormData($("form[id='form-photo']")[0]);

        $($this).attr('disabled', 'disabled');
        $($this).text("Aguarde...");

        $.ajax({
            url: $route + '/photo/upload',
            type: 'POST',
            data: formData,
            success: function (result) {
                if (result === 'ok') {
                    window.location = '/estoque/produtos';
                }
                else {
                    // if (result.indexOf('Não foi possível ler o arquivo') > 0) {
                    //     $('label[for=xml]').text('Não foi possível ler o arquivo');
                    // }
                    // else if (result.indexOf('Arquivo fora do padrão configurado.') > 0) {
                    //     $('label[for=xml]').text('Arquivo fora do padrão!');
                    // }
                    // else {
                    //     $('#response').html('Ocorreu um erro ao importar o arquivo. A operação foi abortada');
                    // }

                    console.log('----- ERROR ----- ');
                    console.log(result);

                    $($this).prop('disabled', false);
                }
            },
            error: function (ex) {
                console.log('----- ERROR ----- ');
                console.log(ex.responseText);

                $($this).prop('disabled', false);
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
});

/**
 * Abrir o modal de importação de XML
 */
$(document).on('click', '.btn-import', function (e) {
    e.preventDefault();

    var dataURL = $route + '/import';
    var title = 'Importar XML';

    $('#modalImportLabel').html(title);

    $('.modal-body-import').load(dataURL, function () {
        $('#modalImport').modal({
            show: true
        });
    });
});

/**
 * Botão Continuar (Importação de XML)
 */
$(document).on('click', '.modal-continue-form', function (e) {
    e.preventDefault();

    var $this = this;
    var $validator = $("#form").validate();

    if ($validator.form()) {
        var formData = new FormData($("form[id='form']")[0]);

        $($this).attr('disabled', 'disabled');
        $($this).text("Aguarde...");

        $("#dynamic")
            .css("width", "0%")
            .attr("aria-valuenow", 0)
            .text("0%");

        $.ajax({
            xhr: function () {
                var xhr = new window.XMLHttpRequest();

                xhr.upload.addEventListener("progress", function (evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = evt.loaded / evt.total;
                        percentComplete = parseInt(percentComplete * 100);
                        $("#dynamic")
                            .css("width", percentComplete + "%")
                            .attr("aria-valuenow", percentComplete)
                            .text(percentComplete + "%");
                    }
                }, false);

                return xhr;
            },
            url: $route + '/upload',
            type: 'POST',
            data: formData,
            success: function (result) {
                if (result === 'ok') {
                    window.location = $route;
                }
                else {
                    if (result.indexOf('Não foi possível ler o arquivo') > 0) {
                        $('label[for=xml]').text('Não foi possível ler o arquivo');
                    }
                    else if (result.indexOf('Arquivo fora do padrão configurado.') > 0) {
                        $('label[for=xml]').text('Arquivo fora do padrão!');
                    }
                    else {
                        $('#response').html('Ocorreu um erro ao importar o arquivo. A operação foi abortada');
                    }

                    console.log('----- ERROR ----- ');
                    console.log(result);

                    $($this).prop('disabled', false);
                    
                    window.location = $route;
                }
            },
            error: function (ex) {
                console.log('----- ERROR ----- ');
                console.log(ex.responseText);

                $($this).prop('disabled', false);

                window.location = $route;
            },
            cache: false,
            contentType: false,
            processData: false
        });
    }
});
