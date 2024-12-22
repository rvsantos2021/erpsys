var $route = '/crm/contatos';

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
        $('[name="nome"]').focus();
    });

})(window, document, window.jQuery);