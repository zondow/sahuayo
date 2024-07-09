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
                    "sNext":     "<i class='mdi mdi-chevron-right'>",
                    "sPrevious": "<i class='mdi mdi-chevron-left'>"
                },
            },
        dom:'<"row"<"col-md-4"l><"col-md-4 text-center"f><"col-md-4 cls-export-buttons"B>>rtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Documentación expediente',
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
                title: 'Documentación expediente',
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

    $("body").on("click",".btnAddExpediente",function (e) {
        e.preventDefault();
        $("#formExpediente")[0].reset();
        $("#expedienteID").val(0);
        $("#renovacion").show();
        $("#modalExpediente").modal("show");
    });

    var tiempo = $("#tiempo");
    $("body").on("change",tiempo,function (e){
        e.preventDefault();
        if (tiempo.val() === '0' ){
            $("#duracion").prop('required',false);
        }else {
            $("#duracion").prop('required',true);
        }
    });

    $('body').on('click', '.editarExpediente', function(e) {
        e.preventDefault();
        $("#formExpediente")[0].reset();
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
                $("#categoria").val(data.result.exp_Categoria).change();
                $("#numero").val(data.result.exp_Numero);
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
        $("#renovacion").hide();
        $("#modalExpediente").modal("show");


    });


    $("body").on('keydown', '.numeric', function(e){
        var key = e.which;
        if ((key >= 48 && key <= 57) ||         //standard digits
            (key >= 96 && key <= 105) ||        //digits (numeric keyboard)
            key === 190 || //.
            key === 110 ||  //. (numeric keyboard)
            key === 8 || //retorno de carro
            key === 37 || // <--
            key === 39 || // -->
            key === 46 || //Supr
            key === 173 || //-
            key === 109 || //- (numeric keyboard)
            key === 9 //Tab
        ){
            return true;
        }//if
        return false;
    });//.numeric.keyup
});

