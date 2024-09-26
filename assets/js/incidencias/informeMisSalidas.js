(function ($) {

    var formSalidas = $("#formSalidas");
    var btnGuardar = $("#btnGuardar");

    var tblSalidas = $("#tblSalidas").DataTable({
        destroy: true,
        lengthMenu: [[10, 25, 50,100,500, -1], [10, 25, 50,100,500, "Todos"]],
        fixedHeader: true,
        //scrollY: "200px",
        scrollCollapse: true,
        scrollX:        true,
        paging:         true,
        ajax: {
            url: BASE_URL + "Incidencias/ajax_getMisSalidas",
            dataType: "json",
            type: "POST",
            "processing": true,
            "serverSide": true
        },
        columns: [
            { "data": "count"},
            { "data": "rep_Semana"},
            { "data": "rep_Dias"},
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
                title: 'Mis salidas',
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
                title: 'Mis salidas',
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

        var urlImprimir = BASE_URL+'PDF/imprimirInformeSalidas/'+row.rep_ReporteSalidaID;

        var btnImprimir = ' <button href="' + urlImprimir +'"'+
            'class="btn btn-warning btn-icon btn-icon-mini btn-round hidden-sm-down show-pdf" data-title="Informe de salidas" title="Formato informe">'+
            '<i class="zmdi zmdi-local-printshop"></i></button>';

        var btnEliminar = '';
        var btnEnviar = '';
        if(row.rep_Estado == 'CREADO') {
            btnEliminar = '<button href="#" class="btn btn-danger btn-icon btn-icon-mini btn-round hidden-sm-down btnEliminarInforme" ' +
                'data-id="'+row.rep_ReporteSalidaID+'" title="Eliminar">' +
                '<i class="zmdi zmdi-delete"></i></button>';
            btnEnviar = '<button href="#" class="btn btn-info btn-icon btn-icon-mini btn-round hidden-sm-down btnEnviarInforme" ' +
            'data-id="'+row.rep_ReporteSalidaID+'" title="Enviar">' +
            '<i class="zmdi zmdi-mail-send"></i></button>';
        }//if

        return btnImprimir + btnEliminar + btnEnviar;
    }//accionesPermisosEmpleado

    function estatus(data,type,row){
        var html = data;
        switch (data){
            case 'CREADO':html = '<span class="badge badge-purple p-1">CREADO</span>';break;
            case 'PENDIENTE':html = '<span class="badge badge-dark p-1">PENDIENTE</span>';break;
            case 'AUTORIZADO':html = '<span class="badge badge-warning p-1">AUTORIZADO</span>';break;
            case 'APLICADO':html = '<span class="badge badge-success p-1">APLICADO</span>';break;
            case 'RECHAZADO':html = '<span class="badge badge-danger p-1">RECHAZADO</span>';break;
            case 'RECHAZADO_RH':html = '<span class="badge badge-danger p-1">RECHAZADO</span>';break;
        }//switch

        return html;
    }//estatusPermisoEmpleado

    var DIAS = 1;

    $btnNuevoDia = $("#btnNuevoDia");
    $divDias = $("#divDias");
    $btnEliminarDia = $("#btnEliminarDia");

    //Agregar dia
    $btnNuevoDia.click(function (){
        if(DIAS < 5) {
            DIAS ++;

            value = $("#txtFechas").val();
            firstDate = moment(value, "YYYY-MM-DD").day(1).format("YYYY-MM-DD");
            lastDate =  moment(value, "YYYY-MM-DD").day(6).format("YYYY-MM-DD");

            diasSemana(firstDate,lastDate,DIAS);

            getSocaps(DIAS);


            //ID de inicio 2
            var html = '<div id="dia_'+DIAS+'" class="form-row border-primary border-bottom mb-2">' +
                    '     <div class="form-group col-md-6">' +
                    '         <label for="fecha'+DIAS+'"> * Fecha </label>' +
                    '        <select class="select2" id="fecha'+DIAS+'" name="fecha[]"  >'+
                    '        </select>' +
                    '     </div>' +
                    '     <div class="form-group col-md-6">' +
                    '         <label for="socap'+DIAS+'"> * Sucursal/Lugar  </label>' +
                    '               <select class="select2"  id="socap'+DIAS+'" name="socap[]" >' +
                    '            </select>'+
                    '     </div>' +
                    '     <div class="form-group col-md-6">' +
                    '         <label for="objetivo'+DIAS+'"> * Objetivo de la visita </label>' +
                    '         <textarea rows="2" class="form-control" id="objetivo'+DIAS+'" name="objetivo[]" placeholder="Escriba el objetivo"  required></textarea>' +
                    '     </div>' +
                    '     <div class="form-group col-md-6">' +
                    '         <label for="logros'+DIAS+'"> * Logros obtenidos </label>' +
                    '         <textarea rows="2" class="form-control" id="logros'+DIAS+'" name="logros[]" placeholder="Escriba los logros"  required></textarea>' +
                    '     </div>' +
                    ' </div>';

            $divDias.append(html);
            $("#fecha" + DIAS).select2({
                placeholder: 'Seleccione una opción',
                allowClear: true,
                width: 'resolve'
            });
            $("#socap"+DIAS).select2();

        }

    });//Agregar

    //Eliminar dia
    $btnEliminarDia.click(function (){
        if(DIAS > 1) {
            $("#dia_" + DIAS).remove();
            DIAS--;
        }
    });//Eliminar

    //Guardar
    btnGuardar.click(function (evt) {
        evt.preventDefault();
        btnGuardar.html('<i class="fas fa-spinner fa-pulse"></i>&nbsp; Guardando...');
        $.ajax({
            url: BASE_URL + "Incidencias/ajaxAddReporteSalidas",
            type: "POST",
            data: formSalidas.serialize(),
            dataType: "json"
        }).done(function (data) {
            btnGuardar.html('Guardar');
            if(data.code === 1) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Reporte registrado!',
                    text: 'El reporte se guardó correctamente',
                    showConfirmButton: false,
                    timer: 2000
                });
                setTimeout(function () {
                    window.location.reload();
                }, 1200);
            }
            else if(data.code == 2)
                showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");
            else
                showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");
        }).always(function(e){
            btnGuardar.html('Guardar');
        });//ajax

    });

    //Eliminar reporte
    $("body").on("click",".btnEliminarInforme",function (e) {
        var salidaID = $(this).data("id");

        Swal.fire({
            title: 'Eliminar informe',
            text: '¿Esta seguro que desea eliminar el informe de salidas?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value)
                ajax_deleteInforme(salidaID);
        })

    });

    function ajax_deleteInforme(salidaID){
        $.ajax({
            url: BASE_URL+'Incidencias/ajax_deleteReporteSalidas',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: {salidaID:salidaID}
        }).done(function(data){
            if (data.code === 1){
                tblSalidas.ajax.reload();
                Swal.fire({
                    icon: 'success',
                    title: '¡Informe eliminado!',
                    text: 'El informe de salidas se elimino correctamente.',
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


    //Enviar reporte
    $("body").on("click",".btnEnviarInforme",function (e) {
        var salidaID = $(this).data("id");
        Swal.fire({
            title: 'Enviar informe',
            text: '¿Esta seguro que desea enviar a revisión el informe de salidas?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value)
                ajax_sendInforme(salidaID,$(this));
        })

    });

    function ajax_sendInforme(salidaID,button){

        $.ajax({
            url: BASE_URL+'Incidencias/ajax_enviarReporteSalidas',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: {salidaID:salidaID}
        }).done(function(data){
            if (data.code === 1){
                tblSalidas.ajax.reload();
                Swal.fire({
                    icon: 'success',
                    title: '¡Informe enviado!',
                    text: 'El informe de salidas se envio correctamente.',
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


    /**CONFGURACION***/
    var startDate,
        endDate;

    $('#txtFechas').datepicker({
        autoclose: true,
        format :'yyyy/mm/dd',
        forceParse :false,
        todayHighlight:!0,
        daysOfWeekDisabled: [0],
    }).on("changeDate", function(e) {

        firstDate = moment($('#txtFechas').val(), "YYYY-MM-DD").day(1).format("YYYY-MM-DD");
        lastDate =  moment($('#txtFechas').val(), "YYYY-MM-DD").day(6).format("YYYY-MM-DD");
        $("#txtFechas").val(firstDate + "   al   " + lastDate);

        diasSemana(firstDate,lastDate,1);
    });


    function diasSemana(inicio,fin,id){
        $("#fecha"+id).empty();
        $.ajax({
            url: BASE_URL+'Incidencias/ajaxGetDiasSemana',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: {inicio:inicio,fin:fin}
        }).done(function(data){

            let selFechas='';
            $.each(data.data, (index, value) =>{
                selFechas+= '<option value='+value.fecha+'>'+ value.nombreFecha +'</option>';
            });
            $("#fecha"+id).append(selFechas);
        }).fail(function(data){
            showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");
        }).always(function(e){
        });//ajax
    }

    function getSocaps(id) {
        $("#socap"+id).empty();
        $.ajax({
            url: BASE_URL + "Incidencias/ajaxGetSocaps",
            type: 'post',
            dataType: 'json',
        }).done(function (data) {

            selsocap= '';
            console.log(data);
            jQuery.each(data.data,function (i,val) {
                selsocap+= '<option value='+val.suc_SucursalID+'>'+ val.suc_Sucursal +'</option>';
            });
            selsocap+='<option value="0"> FEDERACION </option>';
            selsocap+='<option value="10001"> OTRO </option>';
            $("#socap"+id).append(selsocap);
        }).fail(function (data) {
            showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");
        }).always(function (e) {});//ajax
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