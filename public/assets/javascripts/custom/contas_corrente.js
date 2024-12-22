var $route = 'contascorrente';

$(document).ready(function() {
    $('#table-list').DataTable({
        dom: 'Bfrtip',
        buttons: [
            { 
                'extend': 'excelHtml5', 
                'text': '<i class="fa fa-file-excel-o"></i>',
                'exportOptions': {
                    columns: [ 0,1,2,3,4 ]
                }
            },
            { 
                'extend': 'csvHtml5', 
                'text': '<i class="fa fa-file-text"></i>',
                'exportOptions': {
                    columns: [ 0,1,2,3,4 ]
                }
            },
            { 
                'extend': 'pdfHtml5', 
                'text': '<i class="fa fa-file-pdf-o"></i>', 
                'exportOptions': {
                    columns: [ 0,1,2,3,4 ]
                }
            },
            { 
                'extend': 'print', 
                'text': '<i class="fa fa-print"></i>',
                'exportOptions': {
                    columns: [ 0,1,2,3,4 ]
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
        $('[name="banco_id"]').focus();
    });
});
