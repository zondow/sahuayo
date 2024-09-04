$(document).ready(function(e) {

    $("#tLocales").DataTable({
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
        "order": [[ 1, "asc" ]],
        dom:'<"row"<"col-md-4"l><"col-md-4 text-center"f><"col-md-4 cls-export-buttons"B>>rtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Catalogo de competencias',
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
                title: 'Catalogo de competencias',
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

    /*ACCIONES CLAVE*/

    //Variables
    var $verclave= $('#modalClave');
    var $formCla=$('#formCla');
    var $CompID;

    //Agregar Pregunta
    $("body").on("click",".btnaddClav",function(e){
        e.preventDefault();
        $formCla[0].reportValidity();
        var table = $('#datatableClave').DataTable();

        if ($formCla[0].checkValidity()){
            var clave=$('#txtclave').val();
            var orden=$('#cla_NoOrden').val();
            var data2 = {}
            data2.competenciaID=$CompID;
            data2.clave=clave;
            data2.orden=orden;

            $.ajax({
                url: BASE_URL + "Formacion/ajax_addAClaveCompetencia/",
                type: "POST",
                data: data2,
                success: function(data){

                    dat=JSON.parse(data);
                    dat=dat.id;

                    table.row.add( [
                        orden,
                        clave,
                        '<button type="button" class="btn btn-icon waves-effect btnDelPre waves-light btn-danger" data-id="'+dat+'"> <i class="fas fa-times"></i> </button>',
                    ] ).draw( false );

                    $.toast({
                        text: "Acción clave agregada",
                        icon: "success",
                        loader: true,
                        loaderBg: '#c6c372',
                        position: 'top-right',
                        allowToastClose : true,
                    });

                }
            });
        }
        $formCla[0].reset();
    });

    //Alain - Modal ver preguntas
    var flag=0;
    $("body").on("click",".veraclave",function(e){
        e.preventDefault();
        $("#formCla")[0].reset();
        $verclave.modal('show');

        if(flag==1){
            var table = $('#datatableClave').DataTable();
            table.destroy();
        }

        var data2 = {}
        data2.competenciaID=$(this).data('id');

        $CompID=$(this).data('id');


        $.ajax({
            url: BASE_URL + "Formacion/ajax_regresarAccionesClaveCompetencia/",
            type: "POST",
            data: data2,
            success: function(data){

                dat=JSON.parse(data)
                dat=dat.acciones;

                $("#tbodyCla").empty();

                var contador=0;
                $.each(dat, function (index, item) {
                    contador++;
                    var row = "<tr>" +
                        "<td>"+item.cla_NoOrden+"</td>" +
                        "<td>"+item.cla_ClaveAccion+"</td>" +
                        "<td>"+'<button type="button" class="btn btn-icon btnDelCla waves-effect waves-light btn-danger" data-id="'+item.cla_ClaveCompetenciaID+'"> <i class="fas fa-times"></i> </button>'+"</td>" +
                        "</tr>";
                    $("#tbodyCla").append(row);

                });

                $('#datatableClave').DataTable({
                    "columns": [
                        { "width": "10%" },
                        { "width": "80%" },
                        { "width": "20%" },
                    ],
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
                                "sNext":     "<i class='zmdi zmdi-caret-right'>",
                                "sPrevious": "<i class='zmdi zmdi-caret-left'>"
                            },
                        },
                });

                flag=1;

            }
        })


    });

    $("body").on("click",".btnDelCla",function(e){
        e.preventDefault();

        var data2 = {};
        data2.claveID=$(this).data('id');

        var tr=$(this).parents('tr');

        $.ajax({
            url: BASE_URL + "Formacion/ajax_borrarAccionClaveCompetencia/",
            type: "POST",
            data: data2,
            success: function(data){

                $.toast({
                    text: "Acción clave eliminada correctamente",
                    icon: "success",
                    loader: true,
                    loaderBg: '#c6c372',
                    position: 'top-right',
                    allowToastClose : true,
                });

                var table = $('#datatableClave').DataTable();

                table
                    .row( tr )
                    .remove()
                    .draw();

            }
        })


    });
});