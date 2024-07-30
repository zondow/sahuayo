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
            url: BASE_URL + "Incidencias/ajax_getPermisosAutorizar",
            dataType: "json",
            type: "POST",
            "processing": true,
            "serverSide": true
        },
        columns: [
            { "data": "per_PermisoID",render: function(data,type,row){return accionesPermisosAutorizar(data,type,row)}},
            { "data": "per_Fecha"},
            { "data": "emp_Nombre"},
            { "data": "tipoPermiso"},
            { "data": "per_FechaInicio"},
            { "data": "per_FechaFin"},
            { "data": "per_DiasSolicitados"},
            { "data": "per_Motivos"},
            { "data": "per_Estado",render: function (data,type,row) {return estatusPermisoAutorizar(data)}}
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
                title: 'Permisos de mis colaboradores',
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
                title: 'Permisos de mis colaboradores',
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
        //"order": [[ 1, "desc" ]],
        order:false,
        "processing":false
    });

    $("body").on("click",".btnAutorizarPermiso",function (e) {
        var permisoID = $(this).data("permiso");
        var tipo = $(this).data("tipo");
        var estado =$(this).data("estado");


        /*if(tipo == 5 && estado=='PENDIENTE'){
            Swal.fire({
                title: 'Autorizar solicitud',
                text: '¿Esta seguro que desea autorizar la solicitud de permiso?',
                type: 'question',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                html: '<label>* Seleccione el tipo</label>' +
                    '<select id="txtTipo" class="form-control" required >' +
                    '<option value="CON GOCE DE SUELDO">CON GOCE DE SUELDO</option>' +
                    '<option value="SIN GOCE DE SUELDO">SIN GOCE DE SUELDO</option>' +
                    '</select>' +
                    '<textarea id="txtObservaciones" placeholder="Escribe aquí algunas observaciones" ' +
                    'class="swal2-textarea" style="display: flex;" style="resize: none;"></textarea>',
            }).then((result) => {
                if(result.value)
                    ajax_autorizarPermisoAusencia(permisoID, $("#txtObservaciones").val(),$("#txtTipo").val());
            })//swal
        }else{*/
            Swal.fire({
                title: 'Autorizar solicitud',
                text: '¿Esta seguro que desea autorizar la solicitud de permiso?',
                type: 'question',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
            }).then((result) => {
                if(result.value)
                    ajax_autorizarPermiso(permisoID);
            })//swal
        //}

    });

    $("body").on("click",".btnRechazarPermiso",function (e) {
        var permisoID = $(this).data("permiso");

        Swal.fire({
            title: 'Rechazar permiso',
            text: '¿Esta seguro que desea rechazar el permiso?',
            type: 'question',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            html: '<textarea id="txtObsRechazar" placeholder="Escribe aquí algunas observaciones" ' +
            'class="swal2-textarea" style="display: flex;" style="resize: none;"></textarea>',
        }).then((result) => {
            if(result.value)
                ajax_rechazarPermiso(permisoID,$("#txtObsRechazar").val());
        })//swal
    });
    /***FUNCTIONS***/

    function accionesPermisosAutorizar(data,type,row){
        var urlImprimir = BASE_URL+'PDF/imprimirPermiso/'+data;

        var btnImprimir = ' <a href="' + urlImprimir +'"'+
            'class="btn btn-info btn-block waves-light waves-effect show-pdf" data-title="Solicitud de permiso" title="Formato de solicitud">'+
            '<i class="dripicons-print" ></i></a>';

        var autorizaciones = '';
        if(row.per_Estado == 'PENDIENTE') {
            autorizaciones = '<a href="#" data-permiso="'+data+'" data-tipo="'+row.per_TipoID+'" data-estado="'+row.per_Estado+'" class="btn btn-success btn-block btnAutorizarPermiso"  title="Autorizar" >' +
                '<i class="fa fa-check"></i></a>';

            autorizaciones += '<a href="#" data-permiso="'+data+'" class="btn btn-danger btn-block btnRechazarPermiso" title="Rechazar">' +
                '<i class="fa fa-times" ></i></a>';
        }//if
        return btnImprimir + autorizaciones;
    }//accionesPermisosAutorizar

    function estatusPermisoAutorizar(estatus){

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

    function ajax_autorizarPermiso(permisoID,obs){
        $(".btnAutorizarPermiso").html('<i class="fas fa-spinner fa-pulse"></i>&nbsp; Autorizando...');
        $.ajax({
            url: BASE_URL+'Incidencias/ajax_autorizarPermiso',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: {permisoID:permisoID,obs:obs}
        }).done(function(data){
            if (data.code === 1){
                tblPermisos.ajax.reload();
                Swal.fire({
                    type: 'success',
                    title: '¡Permiso autorizado!',
                    text: 'El permiso se autorizo correctamente',
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

    }//ajax_autorizarPermiso

    function ajax_autorizarPermisoAusencia(permisoID,obs,tipo){
        $(".btnAutorizarPermiso").html('<i class="fas fa-spinner fa-pulse"></i>&nbsp; Autorizando...');
        if (tipo !== ""){
            $.ajax({
                url: BASE_URL+'Incidencias/ajax_autorizarPermiso',
                cache: false,
                type: 'post',
                dataType: 'json',
                data: {permisoID:permisoID,obs:obs,tipo:tipo}
            }).done(function(data){
                if (data.code === 1){
                    tblPermisos.ajax.reload();
                    Swal.fire({
                        type: 'success',
                        title: '¡Permiso autorizado!',
                        text: 'El permiso se autorizo correctamente',
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
            showNotification("error","Por favor seleccione le tipo de permiso.","top");
        }

    }

    function ajax_rechazarPermiso(permisoID,obs){
        $(".btnRechazarPermiso").html('<i class="fas fa-spinner fa-pulse"></i>&nbsp; Rechazando...');

        $.ajax({
            url: BASE_URL+'Incidencias/ajax_rechazarPermiso',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: {permisoID:permisoID,obs:obs}
        }).done(function(data){
            if (data.code === 1){
                tblPermisos.ajax.reload();
                Swal.fire({
                    type: 'success',
                    title: '¡Permiso rechazado!',
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