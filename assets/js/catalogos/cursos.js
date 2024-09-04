$(document).ready(function(e) {
    
    // Plugin file para logo
    $(".input-filestyle").filestyle('placeholder', 'Seleccione un archivo (.pdf , .png , .jpg , .jpeg)');

    
    //CKEditor
    CKEDITOR.replace('cur_Temario');
    CKEDITOR.config.height = 300;
      

    $("#datatable").DataTable({
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
                title: 'Catalogo de Cursos',
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
                title: 'Catalogo de Cursos',
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
                className: "btn btn-light btn-round",
            }
        ],
    });

    $("body").on("click", ".modalCursos", function (evt) {
        evt.preventDefault();
        $("#title").text("Nuevo Curso");
        $("#formCursos")[0].reset();
        $("#cur_CursoID").val(0);
        $("#modalCurso").modal("show");
    });

    $("body").on("click", ".editarCurso", function (evt) {
        evt.preventDefault();
        $("#title").text("Editar Curso");
        $("#formCursos")[0].reset();
        let cursoID = $(this).data('id');
        $.ajax({
            url: BASE_URL + "Catalogos/ajax_getInfoCurso/"+cursoID ,
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
                CKEDITOR.instances['cur_Temario'].setData(data.result.cur_Temario);

                $("#cur_Modalidad").val(data.result.cur_Modalidad);
                $("#cur_Modalidad").trigger('chosen:updated');

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