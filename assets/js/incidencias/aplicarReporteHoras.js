(function ($) {
    
    var tblSalidas = $("#tblHoras").DataTable({
        destroy: true,
        lengthMenu: [[10, 25, 50,100,500, -1], [10, 25, 50,100,500, "Todos"]],
        fixedHeader: true,
        scrollCollapse: true,
        scrollX:        true,
        paging:         true,
        ajax: {
            url: BASE_URL + "Incidencias/ajax_getReportesHoras",
            dataType: "json",
            type: "POST",
            "processing": true,
            "serverSide": true
        },
        columns: [
            { "data": "count"},
            { "data": "suc_Sucursal"},
            { "data": "emp_Nombre"},
            { "data": "rep_Fecha"},
            { "data": "rep_HoraInicio"},
            { "data": "rep_HoraFin"},
            { "data": "rep_Horas"},
            { "data": "rep_Motivos"},
            { "data": "rep_TipoPago",render: function(data,type,row){return tipoPago(data,type,row)}},
            { "data": "observaciones"},
            { "data": "rep_Estado",render: function (data,type,row) {return estatus(data)}},
            { "data": "acciones",render: function(data,type,row){return acciones(data,type,row)}},
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
                title: 'Solicitudes horas extra colaboradores',
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
                title: 'Solicitudes horas extra colaboradores',
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
        "order": [[ 0, "desc" ]],
        "processing":false
    });


    function acciones(data,type,row){

        var urlImprimir = BASE_URL+'PDF/imprimirReporteHorasExtra/'+row.rep_ReporteHoraExtraID;

        var btnImprimir = ' <button href="' + urlImprimir +'"'+
            'class="btn btn-warning btn-icon btn-icon-mini btn-round hidden-sm-down show-pdf" data-title="Reporte horas extra" title="Fromato de reporte">'+
            '<i class="zmdi zmdi-local-printshop"></i></button>';

        var btnAutorizar = '';
        var btnRechazar = '';
        if(row.rep_Estado == 'AUTORIZADO') {
            btnAutorizar = '<button href="#" class="btn btn-primary btn-icon btn-icon-mini btn-round hidden-sm-down btnRevisar" ' +
                'data-id="'+row.rep_ReporteHoraExtraID+'" data-accion="APLICAR" title="Aplicar">' +
                '<i class="zmdi zmdi-check"></i></button>';
            btnRechazar = '<button href="#" class="btn btn-danger btn-icon btn-icon-mini btn-round hidden-sm-down btnRevisar" ' +
            'data-id="'+row.rep_ReporteHoraExtraID+'" data-accion="RECHAZAR" title="Rechazar">' +
            '<i class="zmdi zmdi-close"></i></button>';
        }//if

        if(row.rep_Estado == 'APLICADO'){
            btnAutorizar = '<button href="#" class="btn btn-success btn-icon btn-icon-mini btn-round hidden-sm-down btnPagado" ' +
            'data-id="'+row.rep_ReporteHoraExtraID+'" data-accion="PAGADO" title="Marcar como pagado">' +
            '<i class="zmdi zmdi-badge-check"></i></button>';
        }

        if(row.rep_Estado == 'APLICADO' || row.rep_Estado == 'PAGADO'){
            btnAutorizar += '<button href="#" data-id="'+row.rep_ReporteHoraExtraID+'" class="btn btn-dark btn-icon btn-icon-mini btn-round hidden-sm-down btnDeclinar" title="Declinar">' +
            '<i class="zmdi zmdi-minus-circle "></i></button>';
        }

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
            case 'PAGADO':html = '<span class="badge badge-info p-1">PAGADO</span>';break;
            case 'DECLINADO':html = '<span class="badge badge-light-danger p-1">DECLINADO</span>';break;
        }//switch

        return html;
    }

    function tipoPago(data,type,row){
        var html = data;
        switch (data){
            case 'Nomina':html = '<span class="badge badge-success p-1">Via nomina</span>';break;
            case 'Tiempo por tiempo':html = '<span class="badge badge-warning p-1">Tiempo por tiempo</span>';break;
            case null: html='<span class="badge badge-info p-1">Pendiente</span>';
        }//switch

        return html;
    }

    //Enviar reporte
    $("body").on("click",".btnRevisar",function (e) {
        var reporteID = $(this).data("id");
        var accion = $(this).data("accion");
        
        if(accion === "APLICAR"){
            titulo="Aplicar solicitud";
            text = "¿Esta seguro que desea aplicar la solicitud de horas extra?";
            html="";
        }else{
            titulo="Rechazar solicitud";
            text = "¿Esta seguro que desea rechazar la solicitud de horas extra?";
            html= '<textarea id="txtObservaciones" placeholder="Escribe aquí algunas observaciones" ' +
                  'class="swal2-textarea" style="display: flex;" style="resize: none;"></textarea>';
        }

        Swal.fire({
            title: titulo,
            text: text,
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            html : html
        }).then((result) => {
            if (result.value)
                ajax_revisarInforme(reporteID,accion, $("#txtObservaciones").val(), $(this));
        })

    });

    function ajax_revisarInforme(reporteID,accion,observaciones,button){
        $.ajax({
            url: BASE_URL+'Incidencias/ajax_revisarReporteHorasCH',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: {reporteID:reporteID,accion:accion,observaciones:observaciones}
        }).done(function(data){
            if (data.code === 1){
                tblSalidas.ajax.reload();
                Swal.fire({
                    icon: 'success',
                    title: 'Reporte revisado!',
                    text: 'El reporte de horas extra se reviso correctamente.',
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


     //Marcar como pagado
     $("body").on("click",".btnPagado",function (e) {
        var salidaID = $(this).data("id");
        var accion = $(this).data("accion");

        Swal.fire({
            html: '¿Esta seguro que desea marcar la solicitud de horas extra como pagada?<br><label>* Seleccione el tipo</label>' +
            '<select id="txtTipo" class="form-control" required >' +
            '<option value="Nomina">Pago via nomina</option>' +
            '<option value="Tiempo por tiempo">Pago tiempo por tiempo</option>' +
            '</select>',
  
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if (result.value)
                ajax_pagarInforme(salidaID,accion, $("#txtTipo").val(), $(this));
        })

    });


    function ajax_pagarInforme(salidaID,accion,tipo,button){
        $.ajax({
            url: BASE_URL+'Incidencias/ajax_ReporteHorasExtraPagado',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: {salidaID:salidaID,accion:accion,tipo:tipo}
        }).done(function(data){
            if (data.code === 1){
                tblSalidas.ajax.reload();
                Swal.fire({
                    icon: 'success',
                    title: 'Solicitud pagada!',
                    text: 'La solicitud de horas extra se marco como pagada correctamente.',
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


    $("body").on("click",".btnDeclinar",function (e) {
        var reporteID = $(this).data("id");

        Swal.fire({
            title: 'Declinar las horas aplicadas',
            text: '¿Esta seguro que desea declinar las horas extra aplicadas?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            html: '<textarea id="txtObsDeclinar" placeholder="Escriba el motivo" ' +
                'class="swal2-textarea" style="display: flex;" style="resize: none;"></textarea>',
        }).then((result) => {
            if(result.value)
                ajax_Declinar(reporteID,$("#txtObsDeclinar").val(),$(this));
        })//swal
    });


    function ajax_Declinar(reporteID,obs,buton){

        if(obs !== ""){
            $.ajax({
                url: BASE_URL+'Incidencias/ajax_declinarHorasExtra',
                cache: false,
                type: 'post',
                dataType: 'json',
                data: {reporteID:reporteID,obs:obs}
            }).done(function(data){
                if (data.code === 1){
                    tblSalidas.ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: '¡Reporte declinado!',
                        text: 'El reporte de horas extra se declino correctamente',
                        showConfirmButton: false,
                        timer: 2000
                    })
                }else{
                    showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");
                }//if-else
            }).fail(function(data){
                showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");
            }).always(function(e){
            });//ajax
        }else{
            showNotification("error","Por favor escriba el motivo.","top");
        }
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