$(document).ready(function () {
    $('#datatable').DataTable({
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
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
            },
        "order": [[ 0, "desc" ]],
        "columnDefs": [
            {
                //"targets": [ 14,4 ],
                "visible": false,
                "searchable": false
            }
        ],
        /*"drawCallback": function () {
            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
        }*/
    });

    $("#salarioIndeterminado").hide();
    $("body").on("change","#con_TipoContrato",function (e){
        e.preventDefault();
        tipoContrato = $("#con_TipoContrato").val();
        if(tipoContrato==='Trabajo Tiempo Determinado'  ){
            /*Ocultar*/
            $("#salarioIndeterminado").hide();
            /*Mostrar*/
        }else{
            /*Ocultar*/
            /*Mostrar*/
            $("#salarioIndeterminado").show();

        }
    });

    $("body").on("click",".btnAddContrato",function (e) {
        e.preventDefault();
        $("#formContrato")[0].reset();
        $("#con_ContratoID").val(0);
        $("#modalContrato").modal("show");
    });
    $('body').on('click', '.editarContrato', function(e) {
        e.preventDefault();
        $("#formContrato")[0].reset();
        let expedienteID = $(this).data('id');
        $.ajax({
            url: BASE_URL + "Configuracion/ajax_getInfoExpediente/"+expedienteID ,
            type: "POST",
            async:true,
            cache:false,
            dataType: "json"
        }).done(function (data){
            if(data.response === "success"){
                $("#expedienteID").val(data.result.exp_ExpedienteID);
                $("#nombre").val(data.result.exp_Nombre);
                $("#tiempo").val(data.result.exp_RenovacionTiempo).change();
                $("#duracion").val(data.result.exp_RenovacionDuracion).change();
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

        $("#modalContrato").modal("show");


    });
});

