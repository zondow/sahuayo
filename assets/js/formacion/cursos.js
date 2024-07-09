$(document).ready(function(e) {
    $(".select2").select2();
    // Plugin file para logo
    $(".input-filestyle").filestyle('placeholder', 'Seleccione un archivo (.pdf , .png , .jpg , .jpeg)');

    $('#cur_Temario').summernote({
        //placeholder: 'Hello bootstrap 4',
        tabsize: 1,
        height: 400,
        lang: 'es-ES' // default: 'en-US'
    });
    $("#datatable").DataTable({
        language:
            {
                paginate: {
                    previous:"<i class='mdi mdi-chevron-left'>",
                    next:"<i class='mdi mdi-chevron-right'>"
                },
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla.",
                "sInfo":           "",
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
                    "sNext":     "<i class='mdi mdi-chevron-right'>",
                    "sPrevious": "<i class='mdi mdi-chevron-left'>"
                },
            },
        dom:'<"row"<"col-md-4"l><"col-md-4 text-center"f><"col-md-4 cls-export-buttons"B>>rtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Catalogo de cursos',
                text: '<i class="fa fa-file-excel-o"></i>&nbsp;Excel',
                titleAttr: "Exportar a excel",
                className: "btn btn-warning",
                autoFilter: true,
                exportOptions: {
                    columns: ':visible'
                },
            },
            {
                extend: 'pdfHtml5',
                title: 'Catalogo de cursos',
                text: '<i class="fa fa-file-pdf-o"></i>&nbsp;PDF',
                titleAttr: "Exportar a PDF",
                className: "btn btn-warning",
                orientation: 'landscape',
                pageSize: 'LETTER',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'colvis',
                text: 'Columnas',
                className: "btn btn-light",
            }
        ],
    });

    $("body").on("click", ".modalCursos", function (evt) {
        evt.preventDefault();
        $("#formCursos")[0].reset();
        $("#cur_CursoID").val(0);
        $("#modalCurso").modal("show");
    });

    $("body").on("click", ".editarCurso", function (evt) {
        evt.preventDefault();
        $("#formCursos")[0].reset();
        let cursoID = $(this).data('id');
        $.ajax({
            url: BASE_URL + "Formacion/ajax_getInfoCurso/"+cursoID ,
            type: "POST",
            async:true,
            cache:false,
            dataType: "json"
        }).done(function (data){

            if(data.response === "success"){
                $("#cur_CursoID").val(data.result.cur_CursoID);
                $("#cur_Nombre").val(data.result.cur_Nombre);
                $("#cur_Objetivo").val(data.result.cur_Objetivo);
                $("#cur_Horas").val(data.result.cur_Horas);
                //$("#cur_Temario").summernote('reset');
                $("#cur_Temario").summernote('code',data.result.cur_Temario);
                $("#cur_Modalidad").val(data.result.cur_Modalidad);
                $("#cur_Modalidad").select2().trigger('change');

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
        $("#modalCurso").modal("show");
    });


});