$('#lista-etapas').on('click', '.btn-del-etapa', function () {
    Swal.fire({
        title: 'Confirma a exclusão?',
        text: "Essa ação não poderá ser revertida.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sim',
        cancelButtonText: 'Não'
    }).then((result) => {
        if (result.value == true) {
            var row = $(this).closest('tr');

            row.remove();

            Swal.fire(
                'Excluído!',
                'A etapa selecionada foi excluído.',
                'success'
            )
        }
    })
});
