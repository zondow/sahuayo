$(document).ready(function () {
    $('#datatable').DataTable({
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
        "order": [[ 1, "asc" ]],
        dom:'<"row"<"col-md-4"l><"col-md-4 text-center"f><"col-md-4 cls-export-buttons"B>>rtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Sucursales',
                text: '<i class="fa fa-file-excel-o"></i>&nbsp;Excel',
                titleAttr: "Exportar a excel",
                className: "btn l-slategray",
                autoFilter: true,
                exportOptions: {
                    columns: ':visible'
                },
            },
            {
                extend: 'pdfHtml5',
                title: 'Sucursales',
                text: '<i class="fa fa-file-pdf-o"></i>&nbsp;PDF',
                titleAttr: "Exportar a PDF",
                className: "btn l-slategray",
                orientation: 'landscape',
                pageSize: 'LETTER',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'colvis',
                text: 'Columnas',
                className: "btn l-slategray",
            }
        ],
    });

    $("body").on("click",".btnAddSucursal",function (e) {
        e.preventDefault();
        $("#formSucursal")[0].reset();
        $("#suc_SucursalID").val(0);
        $("#modalSucursal").modal("show");
    });
    $('body').on('click', '.editarSucursal', function(e) {
        e.preventDefault();
        $("#formSucursal")[0].reset();
        let sucursalID = $(this).data('id');
        $.ajax({
            url: BASE_URL + "Catalogos/ajax_getInfoSucursal/"+sucursalID ,
            type: "POST",
            async:true,
            cache:false,
            dataType: "json"
        }).done(function (data){
            if(data.response === "success"){
                $("#suc_SucursalID").val(data.result.suc_SucursalID);
                $("#suc_Sucursal").val(data.result.suc_Sucursal);
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

        $("#modalSucursal").modal("show");


    });
});

