(function ($) {

    var tblSalidas = $("#tblSalidas").DataTable({
        destroy: true,
        lengthMenu: [[10, 25, 50,100,500, -1], [10, 25, 50,100,500, "Todos"]],
        fixedHeader: true,
        scrollCollapse: true,
        scrollX:        true,
        paging:         true,
        ajax: {
            url: BASE_URL + "Incidencias/ajax_getInformesSalidas",
            dataType: "json",
            type: "POST",
            "processing": true,
            "serverSide": true
        },
        columns: [
            { "data": "acciones",render: function(data,type,row){return acciones(data,type,row)}},
            { "data": "count"},
            { "data": "rep_FechaRegistro"},
            { "data": "emp_Nombre"},
            { "data": "rep_Semana"},
            { "data": "totalDias"},
            { "data": "rep_Dias"},
            { "data": "rep_ObservacionesRJ"},
            { "data": "rep_Estado",render: function (data,type,row) {return estatus(data)}}
        ],
        columnDefs: [
            {targets:0,className: 'text-center'},
        ],
        responsive:true,
        stateSave:false,
        //dom: 'Blfrtip',
        dom:'<"row"<"col-md-4"l><"col-md-4 text-center"f><"col-md-4 cls-export-buttons"B>>rtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Salidas colaboradores',
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
                title: 'Salidas colaboradores',
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
                className: "btn btn-light",
            }
        ],
        language: {
            paginate: {
                previous:"<i class='zmdi zmdi-caret-left'>",
                next:"<i class='zmdi zmdi-caret-right'>"
            },
            search: "_INPUT_",
            searchPlaceholder: "Buscar...",
            lengthMenu: "Registros por página _MENU_",
            info:"Mostrando _START_ a _END_ de _TOTAL_ registros",
            infoEmpty:"Mostrando 0 a 0 de 0 registros",
            zeroRecords: "No hay datos para mostrar",
            loadingRecords: "Cargando...",
            infoFiltered:"(filtrado de _MAX_ registros)",
            "processing": "Procesando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "<i class='zmdi zmdi-caret-right'>",
                "sPrevious": "<i class='zmdi zmdi-caret-left'>"
            },

        },
        "order": [[ 1, "asc" ]],
        "processing":false
    });




    function acciones(data,type,row){

        var urlImprimir = BASE_URL+'PDF/imprimirInformeSalidas/'+row.rep_ReporteSalidaID;

        var btnImprimir = ' <a href="' + urlImprimir +'"'+
            'class="btn btn-info btn-block waves-light waves-effect show-pdf" data-title="Informe de salidas" title="Fromato de informe">'+
            '<i class="dripicons-print"></i></a>';

        var btnAutorizar = '';
        var btnRechazar = '';
        if(row.rep_Estado == 'AUTORIZADO') {
            btnAutorizar = '<a href="#" class="btn btn-primary btn-block waves-light waves-effect btnRevisar" ' +
                'data-id="'+row.rep_ReporteSalidaID+'" data-accion="APLICAR" title="Aplicar">' +
                '<i class="fa fa-check"></i></a>';
            btnRechazar = '<a href="#" class="btn btn-danger btn-block waves-light waves-effect btnRevisar" ' +
            'data-id="'+row.rep_ReporteSalidaID+'" data-accion="RECHAZAR" title="Rechazar">' +
            '<i class="fa fa-times"></i></a>';
        }//if

        return btnImprimir + btnAutorizar + btnRechazar;
    }

    function estatus(data,type,row){
        var html = data;
        switch (data){
            case 'PENDIENTE':html = '<span class="badge badge-dark p-1">PENDIENTE</span>';break;
            case 'AUTORIZADO':html = '<span class="badge badge-warning p-1">AUTORIZADO</span>';break;
            case 'APLICADO':html = '<span class="badge badge-success p-1">APLICADO</span>';break;
            case 'RECHAZADO':html = '<span class="badge badge-danger p-1">RECHAZADO</span>';break;
            case 'RECHAZADO_RH':html = '<span class="badge badge-danger p-1">RECHAZADO</span>';break;
        }//switch

        return html;
    }

    //Enviar reporte
    $("body").on("click",".btnRevisar",function (e) {
        var salidaID = $(this).data("id");
        var accion = $(this).data("accion");

        if(accion === "APLICAR"){
            titulo="Aplicar informe";
            text = "¿Esta seguro que desea aplicar el informe de salidas?";
            html="";
        }else{
            titulo="Rechazar informe";
            text = "¿Esta seguro que desea rechazar el informe de salidas?";
            html= '<textarea id="txtObservaciones" placeholder="Escribe aquí algunas observaciones" ' +
                  'class="swal2-textarea" style="display: flex;" style="resize: none;"></textarea>';
        }

        Swal.fire({
            title: titulo,
            text: text,
            type: 'question',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            html : html
        }).then((result) => {
            if (result.value)
                ajax_revisarInforme(salidaID,accion, $("#txtObservaciones").val(), $(this));
        })

    });

    function ajax_revisarInforme(salidaID,accion,observaciones,button){
        button.html('<i class="fas fa-spinner fa-pulse"></i>&nbsp; Revisando...');
        $.ajax({
            url: BASE_URL+'Incidencias/ajax_revisarReporteSalidasCH',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: {salidaID:salidaID,accion:accion,observaciones:observaciones}
        }).done(function(data){
            if (data.code === 1){
                tblSalidas.ajax.reload();
                Swal.fire({
                    type: 'success',
                    title: 'Informe revisado!',
                    text: 'El informe de salidas se reviso correctamente.',
                    showConfirmButton: false,
                    timer: 2000
                })
            }else{
                showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");
            }
        }).fail(function(data){
            showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");
        }).always(function(e){
        });
    }


    function showNotification(tipo,msg){
        $.toast({
            text:msg,
            icon: tipo,
            loader: true,
            loaderBg: '#c6c372',
            position: 'top-right',
            allowToastClose : true,
        });
    }//showNotification

})(jQuery);