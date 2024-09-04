$(document).ready(function(e) {
   
    $("#datatable").DataTable({
        destroy: true,
        lengthMenu: [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "Todos"]],
        fixedHeader: true,
        scrollX: true,
        paging: true,
        responsive: true,
        stateSave: false,
        dom: '<"row"<"col-md-4"l><"col-md-4 text-center"f><"col-md-4 cls-export-buttons"B>>rtip',
        language:
            {
                paginate: {
                    previous:"<i class='zmdi zmdi-caret-left'>",
                    next:"<i class='zmdi zmdi-caret-right'>"
                },
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla.",
                "sInfo":           "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "sInfoEmpty":      "",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "<i class='zmdi zmdi-caret-right'>",
                    "sPrevious": "<i class='zmdi zmdi-caret-left'>"
                },
            },
        dom:'<"row"<"col-md-4"l><"col-md-4 text-center"f><"col-md-4 cls-export-buttons"B>>rtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Catalogo de instructores',
                text: '<i class="zmdi zmdi-collection-text"></i>&nbsp;Excel',
                titleAttr: "Exportar a excel",
                className: "btn l-slategray btn-round",
                autoFilter: true,
                exportOptions: {
                    columns: ':visible'
                },
            },
            {
                extend: 'pdfHtml5',
                title: 'Catalogo de instructores',
                text: '<i class="zmdi zmdi-collection-pdf"></i>&nbsp;PDF',
                titleAttr: "Exportar a PDF",
                className: "btn l-slategray btn-round",
                orientation: 'landscape',
                pageSize: 'LETTER',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'colvis',
                text: 'Columnas',
                className: "btn l-slategray btn-round",
            }
        ],
    });

    $("body").on("click", ".modalInst", function (evt) {
        evt.preventDefault();
        $("#formInstructor")[0].reset();
        $("#ins_InstructorID").val(0);
        $("#modalInstructor").modal("show");
    });

    $("body").on("click", ".editarInstructor", function (evt) {
        evt.preventDefault();
        $("#formInstructor")[0].reset();
        $('#ins_EmpleadoID').prop('disabled', 'disabled');
        let instructorID = $(this).data('id');
        $.ajax({
            url: BASE_URL + "Catalogos/ajax_getInfoInstructor/"+instructorID ,
            type: "POST",
            async:true,
            cache:false,
            dataType: "json"
        }).done(function (data){

            if(data.response === "success"){
                $("#ins_InstructorID").val(data.result.ins_InstructorID);
                $("#ins_EmpleadoID").val(data.result.ins_EmpleadoID);
                $("#ins_EmpleadoID").trigger('change');
                $("#ins_CriterioSeleccion").val(data.result.ins_CriterioSeleccion);
                $("#ins_CriterioSeleccion").trigger('change');

            }
        }).fail(function () {
            $.toast({
                text: "Ocurrido un error, por favor intente nuevamente.",
                icon: "error",
                loader: true,
                loaderBg: '#c6c372',
                position: 'top-right',
                allowToastClose : true,
            });
        });
        $("#modalInstructor").modal("show");
    });

});