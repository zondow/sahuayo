$(document).ready(function (e) {
    var tblPermisos = $("#tblPermisos").DataTable({
        destroy: true,
        lengthMenu: [[10, 25, 50,100,500, -1], [10, 25, 50,100,500, "Todos"]],
        fixedHeader: true,
        //scrollY: "200px",
        scrollCollapse: true,
        scrollX:        true,
        paging:         true,
        ajax: {
            url: BASE_URL + "Incidencias/ajax_getPermisosAplicar",
            dataType: "json",
            type: "POST",
            "processing": true,
            "serverSide": true
        },
        columns: [
            { "data": "num"},
            { "data": "emp_Nombre"},
            { "data": "suc_Sucursal"},
            { "data": "tipoPermiso"},
            { "data": "per_Fecha"},
            { "data": "per_FechaInicio"},
            { "data": "per_FechaFin"},
            { "data": "per_DiasSolicitados"},
            { "data": "per_TipoPermiso"},
            { "data": "per_Justificacion"},
            { "data": "per_Estado",render: function (data,type,row) {return estatusPermisoAplicar(data)}},
            { "data": "per_PermisoID",render: function(data,type,row){return accionesPermisosAplicar(data,type,row)}},
        ],
        columnDefs: [
            {targets:0,className: 'text-center'},
            {targets:2,className: 'text-center'},
        ],
        responsive:true,
        stateSave:false,
        //dom: 'Blfrtip',
        dom:'<"row"<"col-md-4"l><"col-md-4 text-center"f><"col-md-4 cls-export-buttons"B>>rtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Permisos aplicados',
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
                title: 'Permisos aplicados',
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
        order:false,
        "processing":false
    });

    $("body").on("click",".btnAplicarPermiso",function (e) {
        var permisoID = $(this).data("permiso");

        Swal.fire({
            title: 'Aplicar solicitud',
            text: '¿Esta seguro que desea aplicar la solicitud de permiso?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if(result.value)
                ajax_aplicarPermiso(permisoID,$(this));
        })//swal
    });

    $("body").on("click",".btnRechazarPermiso",function (e) {
        var permisoID = $(this).data("permiso");

        Swal.fire({
            title: 'Rechazar solicitud',
            text: '¿Esta seguro que desea rechazar la solicitud de permiso?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if(result.value)
                ajax_rechazarPermiso(permisoID,$(this));
        })//swal
    });

    $("body").on("click",".btnDeclinarPermiso",function (e) {
        var permisoID = $(this).data("permiso");

        Swal.fire({
            title: 'Declinar solicitud',
            text: '¿Esta seguro que desea declinar la solicitud de permiso?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            html: '<textarea id="txtObsDeclinar" placeholder="Escriba el motivo" ' +
                'class="swal2-textarea" style="display: flex;" style="resize: none;"></textarea>',
        }).then((result) => {
            if(result.value)
                ajax_DeclinarPermiso(permisoID,$("#txtObsDeclinar").val());
        })//swal
    });

    /***FUNCTIONS****/
    function accionesPermisosAplicar(data,type,row){
        var urlImprimir = BASE_URL+'PDF/imprimirPermiso/'+data;

        var btnImprimir = ' <button href="' + urlImprimir +'"'+
            'class="btn btn-warning btn-icon btn-icon-mini btn-round hidden-sm-down waves-light waves-effect show-pdf" data-title="Solicitud de permiso" title="Formato de solicitud">'+
            '<i class="zmdi zmdi-local-printshop"></i></button>';


        var autorizaciones = '';
        var estatus = row.per_Estado;
        if(estatus == 'AUTORIZADO_JEFE'){
            autorizaciones = '<button href="#" data-permiso="'+data+'" class="btn btn-success btn-icon btn-icon-mini btn-round hidden-sm-down btnAplicarPermiso" title="Aplicar">' +
            '<i class="zmdi zmdi-check"></i></button>';
            autorizaciones += '<button href="#" data-permiso="'+data+'" class="btn btn-danger btn-icon btn-icon-mini btn-round hidden-sm-down btnRechazarPermiso" title="Rechazar">' +
                '<i class="zmdi zmdi-close"></i></button>';
        }

        if(row.per_Estado == 'AUTORIZADO_RH'){
            autorizaciones += '<button href="#" data-permiso="'+data+'" class="btn btn-dark btn-icon btn-icon-mini btn-round hidden-sm-down btnDeclinarPermiso" title="Declinar">' +
                '<i class="zmdi zmdi-minus-circle"></i></button>';
        }

        return btnImprimir + autorizaciones;
    }//accionesPermisosAutorizar

    function estatusPermisoAplicar(estatus){

        var html = '';
        switch (estatus){
            case 'PENDIENTE':html = '<span class="badge badge-dark p-1">PENDIENTE</span>';break;
            case 'AUTORIZADO_JEFE':html = '<span class="badge badge-success p-1">AUTORIZADO JEFE</span>'; break;
            case 'AUTORIZADO_RH':html = '<span class="badge badge-info p-1">APLICADO</span>'; break;
            case 'RECHAZADO_JEFE':html = '<span class="badge badge-danger p-1">RECHAZADO JEFE</span>'; break;
            case 'RECHAZADO_RH':html = '<span class="badge badge-danger p-1">RECHAZADO</span>'; break;
            case 'DECLINADO':html = '<span class="badge badge-light-danger p-1">DECLINADO</span>'; break;
        }//switch

        return html;
    }//estatusPermisoAutorizar

    function ajax_aplicarPermiso(permisoID,button){

        $.ajax({
            url: BASE_URL+'Incidencias/ajax_aplicarPermiso',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: {permisoID:permisoID}
        }).done(function(data){
            if (data.code === 1){
                tblPermisos.ajax.reload();
                Swal.fire({
                    type: 'success',
                    title: '¡Permiso autorizado!',
                    text: 'El permiso se aplicó correctamente',
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

    }//ajax_aplicarPermiso

    function ajax_rechazarPermiso(permisoID,button){

        $.ajax({
            url: BASE_URL+'Incidencias/ajax_rechazarPermiso',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: {permisoID:permisoID}
        }).done(function(data){
            if (data.code === 1){
                tblPermisos.ajax.reload();
                Swal.fire({
                    type: 'success',
                    title: '¡Permiso no aplicado!',
                    text: 'El permiso se rechazo correctamente',
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

    }//ajax_rechazarPermiso

    function ajax_DeclinarPermiso(permisoID,obs){

        if(obs !== ""){
            $.ajax({
                url: BASE_URL+'Incidencias/ajax_declinarPermiso',
                cache: false,
                type: 'post',
                dataType: 'json',
                data: {permisoID:permisoID,obs:obs}
            }).done(function(data){
                if (data.code === 1){
                    tblPermisos.ajax.reload();
                    Swal.fire({
                        type: 'success',
                        title: '¡Permiso declinado!',
                        text: 'El permiso se declino correctamente',
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

});