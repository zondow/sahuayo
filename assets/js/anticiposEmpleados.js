$(document).ready(function (e) {
    var modalDocsAnticipo = $("#modalDocsAnticipo");
    var modalDetallesAnticipo = $("#modalDetallesAnticipo");
    var btnGuardarDetalles = $("#btnGuardarDetalles");

    var tblAnticipos = $("#tblAnticipos").DataTable({
        destroy: true,
        lengthMenu: [[10, 25, 50,100,500, -1], [10, 25, 50,100,500, "Todos"]],
        fixedHeader: true,
        //scrollY: "200px",
        scrollCollapse: true,
        scrollX:        true,
        paging:         true,
        ajax: {
            url: BASE_URL + "Incidencias/ajax_getAnticiposEmpleados",
            dataType: "json",
            type: "POST",
            "processing": true,
            "serverSide": true
        },
        columns: [
            { "data": "ant_AnticipoID",render: function(data,type,row){return accionesAnticipo(data,type,row)}},
            { "data": "ant_FechaSolicitud"},
            { "data": "solicita"},
            { "data": "ant_Estado",render: function (data,type,row) {return estatusAnticipo(data)}},
            { "data": "ant_MontoSolicitado",render: function(data,type,row){return number_format(data)}},
            { "data": "ant_MontoAutorizado",render: function(data,type,row){return number_format(data)}},
            { "data": "ant_Observaciones"},
        ],
        columnDefs: [
            {targets:0,className: 'text-center'},
            {targets:3,className: 'text-center'},
        ],
        responsive:true,
        stateSave:false,
        //dom: 'Blfrtip',
        dom:'<"row"<"col-md-4"l><"col-md-4 text-center"f><"col-md-4 cls-export-buttons"B>>rtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Anticipos',
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
                title: 'Anticipos',
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
        language: {
            paginate: {
                previous:"<i class='mdi mdi-chevron-left'>",
                next:"<i class='mdi mdi-chevron-right'>"
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
                "sNext":    "<i class='mdi mdi-chevron-right'>",
                "sPrevious": "<i class='mdi mdi-chevron-left'>"
            },

        },
        "order": [[ 1, "desc" ]],
        "processing":false
    });

    $("body").on("click",".btnDocumentacion",function (e) {
        var anticipoID = $(this).data("anticipo");
        var st = $(this).data("estatus");

        $("#txtAnticipoFilesID").val(anticipoID);
        $("#txtEstatusAnticipo").val(st);
        getArchivosAnticipo(anticipoID);
    });

    $("body").on("click",".btnAutAnticipo",function (e) {
        var anticipoID = $(this).data("anticipo");

        Swal.fire({
            title: 'Autorizar anticipo',
            text: '¿Esta seguro que desea autorizar el anticipo?',
            type: 'question',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if(result.value)
                updateEstatusAnticipo(anticipoID,"AUTORIZADO_RH");
        })//swal
    });

    $("body").on("click",".btnRecAnticipo",function (e) {
        var anticipoID = $(this).data("anticipo");

        Swal.fire({
            title: 'Rechazar anticipo',
            text: '¿Esta seguro que desea rechazar el anticipo?',
            type: 'question',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if(result.value)
                updateEstatusAnticipo(anticipoID,"RECHAZADO_RH");
        })//swal
    });

    $("body").on("click",".btnDetalles",function (e) {
        var anticipoID = $(this).data("anticipo");
        var estatus = $(this).data("estatus");

        btnGuardarDetalles.data("anticipo",anticipoID);

        const estate = ['AUTORIZADO_JEFE', 'AUTORIZADO_RH', 'RECHAZADO_RH'];

        if(!estate.includes(estatus))
            btnGuardarDetalles.hide();
        getDetallesAnticipo(anticipoID);
    });

    btnGuardarDetalles.click(function (e) {
        var mesesDerecho = $("#txtMesesDerecho").val();
        var montoAutorizado = $("#txtMontoAutorizado").val();
        var finalidad = $("#txtFinalidad").val();
        var pagos = $("#txtPagos").val();
        var montoPago = $("#txtMontoPago").val();
        var ultimoPago = $("#txtUltimoPago").val();
        var salarioDiario = $("#txtSalarioDiario").val();
        var salarioMensual = $("#txtSalarioMensual").val();
        var fondoAhorro = $("#txtFondoAhorro").val();
        var despensa = $("#txtDespensa").val();
        var observaciones = $("#txtObservaciones").val();

        if(mesesDerecho >= 0 ){
            if(montoAutorizado >= 0 ){
                if(pagos>0){
                    if(montoPago > 0){
                        if(salarioDiario > 0){
                            if(salarioMensual > 0){
                                var fd = new FormData();
                                fd.append("mesesDerecho",mesesDerecho);
                                fd.append("montoAutorizado",montoAutorizado);
                                fd.append("finalidad",finalidad);
                                fd.append("pagos",pagos);
                                fd.append("montoPago",montoPago);
                                fd.append("ultimoPago",ultimoPago);
                                fd.append("salarioDiario",salarioDiario);
                                fd.append("salarioMensual",salarioMensual);
                                fd.append("fondoAhorro",fondoAhorro);
                                fd.append("despensa",despensa);
                                fd.append("obs",observaciones);
                                fd.append("anticipoID",$(this).data("anticipo"));
                                guardarDetallesAnticipo(fd);
                            }
                            else
                                showNotification("warning","¡Escribe el salario mensual!")
                        }
                        else
                            showNotification("warning","¡Escribe el salario diario!")
                    }
                    else
                        showNotification("warning","Escribe el monto de cada pago")
                }
                else
                    showNotification("warning","¡Esbre el número de pagos!")
            }
            else
                showNotification("warning","¡Escribe el monto autorizado!")
        }
        else
            showNotification("warning","¡Ingresa los meses a los que tiene derecho el empleado!")
    });


    /****************FUNCTIONS******************/

    function accionesAnticipo(data,type,row){

        var urlImprimir = BASE_URL+'PDF/imprimirSolicitudAnticipo/'+data;
        var urlImprimirPagare = BASE_URL+'PDF/imprimirPagareAnticipo/'+data;

        var btnImprimir = ' <a href="' + urlImprimir +'"'+
            'class="btn btn-info btn-block waves-light waves-effect show-pdf" data-title="Solicitud de anticipo">'+
            '<i class="dripicons-print"></i>&nbsp; Imprimir anticipo</a>';

        var btnFiles = ' <button type="button" data-anticipo="'+data+'" data-estatus="'+row.ant_Estado+'" '+
            'class="btn btn-primary btn-block waves-light waves-effect btnDocumentacion">'+
            '<i class="dripicons-folder"></i>&nbsp; Documentación</button>';


        var btnDetalles = ' <button type="button" data-anticipo="'+data+'" data-estatus="'+row.ant_Estado+'" '+
            'class="btn btn-purple btn-block waves-light waves-effect btnDetalles">'+
            '<i class="dripicons-checklist"></i>&nbsp; Detalles</button>';

        var btnImprimirPagare = '';
        if(row.ant_Estado == 'AUTORIZADO_DIRECCION') {
            btnImprimirPagare = ' <a href="' + urlImprimirPagare + '"' +
                'class="btn btn-warning btn-block waves-light waves-effect show-pdf" data-title="Pagaré">' +
                '<i class="dripicons-print"></i>&nbsp; Imprimir pagaré</a>';
        }

        var btnRechazar = '';
        var btnAutorizar = '';
        if(row.ant_Estado == 'AUTORIZADO_JEFE') {
            btnAutorizar = '<button type="button" class="btn btn-success btn-block waves-light waves-effect btnAutAnticipo" ' +
                'data-anticipo="'+data+'"><i class="fa fa-check"></i>&nbsp; Autorizar</button>';

            btnRechazar = '<button type="button" class="btn btn-danger btn-block waves-light waves-effect btnRecAnticipo" ' +
                'data-anticipo="'+data+'"><i class="fa fa-times"></i>&nbsp; Rechazar</button>';

        }//if
        return btnImprimir + btnImprimirPagare + btnFiles + btnDetalles + btnAutorizar + btnRechazar;
    }//accionesAnticipo

    function estatusAnticipo(st){
        var html = st;
        switch (st){
            case "PENDIENTE":
            case "AUTORIZADO_JEFE":
                html =  '<span class="badge label-table badge-warning pt-1 pb-1 pr-2 pl-2">PENDIENTE</span>';
                break;
            case "AUTORIZADO_RH":
                html =  '<span class="badge label-table badge-info pt-1 pb-1 pr-2 pl-2">AUTORIZADO</span>';
                break;
            case "RECHAZADO_RH":
                html =  '<span class="badge label-table badge-danger pt-1 pb-1 pr-2 pl-2">RECHAZADO</span>';
                break;
            case "AUTORIZADO_DIRECCION":
                html =  '<span class="badge label-table badge-success pt-1 pb-1 pr-2 pl-2">AUTORIZADO<br><br> DIRECCIÓN GENERAL</span>';
                break;
            case "RECHAZADO_DIRECCION":
                html =  '<span class="badge label-table badge-danger pt-1 pb-1 pr-2 pl-2">RECHAZADO<br><br> DIRECCIÓN GENERAL</span>';
                break;
        }//switch
        return html;
    }//estatusAnticipo

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

    //Formato de moneda
    function number_format(amount) {

        if(!isNaN(amount) && amount > 0){
            amount =  '$ ' + amount.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
        }
        else
        {
            amount = ' $ 0.00';
        }

        return amount;
    }//number_format

    function getArchivosAnticipo(anticipoID){
        $.ajax({
            url: BASE_URL+'Incidencias/ajax_getArchivosAnticipo',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: {anticipoID:anticipoID}
        }).done(function(data){
            if (data.code === 1){
                modalDocsAnticipo.modal("show");
                var files = data.files;
                for(f in files){

                    if(files[f].existe == 1){
                        $("#cntEmpty_" + files[f].file).addClass("ocultar");
                        $("#cntFill_" + files[f].file).removeClass("ocultar");
                        $("#urlFile_" + files[f].file).attr("href", files[f].url);
                        $("#urlIcon_" + files[f].file).attr("src", files[f].icon);
                        $("#urlFile_" + files[f].file).attr("target", "_blank");
                        $(".btnDeleteFile").hide();
                    }
                    else
                    {
                        $(".frmUpFile").html('<a id="urlFile_pagare" href="#">\n' +
                            '<div class="cntent2 text-center align-center">\n' +
                            '<span class="dz-message" style="color:#808080">No se subio el archivo</span>' +
                            '</div></a>');
                    }
                }
            }
        }).fail(function(data){
        }).always(function(e){
        });//ajax
    }//getArchivosAnticipo

    function updateEstatusAnticipo(anticipoID,estatus){
        $.ajax({
            url: BASE_URL+'Incidencias/ajax_updateEstatusAnticipoDTH',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: {anticipoID:anticipoID, estatus:estatus}
        }).done(function(data){
            if (data.code === 1){
                tblAnticipos.ajax.reload();
                var title = estatus == 'AUTORIZADO_RH' ? '¡Anticipo autorizado correctamente!' : '¡Anticipo rechazado correctamente!';
                Swal.fire({
                    type: 'success',
                    title: title,
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
    }//updateEstatusAnticipo

    function getDetallesAnticipo(anticipoID){
        $.ajax({
            url: BASE_URL+'Incidencias/ajax_getDetallesAnticipo',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: {anticipoID:anticipoID}
        }).done(function(data){
            if (data.code === 1){
                var detalles = data.detalles;
                $("#txtMesesDerecho").val(detalles.mesesDerecho);
                $("#txtMontoSolicitado").val(detalles.montoSolicitado);
                $("#txtMontoAutorizado").val(detalles.montoAutorizado);
                $("#txtFinalidad").val(detalles.finalidad);
                $("#txtPagos").val(detalles.noPagos);
                $("#txtMontoPago").val(detalles.montoPago);
                $("#txtUltimoPago").val(detalles.ultimoPago);
                $("#txtSalarioDiario").val(detalles.salarioDiario);
                $("#txtSalarioMensual").val(detalles.salarioMensual);
                $("#txtFondoAhorro").val(detalles.fondoAhorro);
                $("#txtDespensa").val(detalles.despensa);
                $("#txtSalarioIntegrado").val(detalles.salarioIntegrado);
                $("#txtObservaciones").val(detalles.observaciones);
                modalDetallesAnticipo.modal("show");
            }
            else
                showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");

        }).fail(function(data){
            showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");
        }).always(function(e){
        });//ajax
    }//getDetallesAnticipo

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

    function guardarDetallesAnticipo(fd) {
        $.ajax({
            url: BASE_URL+'Incidencias/ajax_guardarDetallesAnticipo',
            cache: false,
            contentType: false,
            processData: false,
            type: 'post',
            dataType: 'json',
            data: fd
        }).done(function(data){
            if (data.code === 1){
                tblAnticipos.ajax.reload();
                modalDetallesAnticipo.modal('toggle');
                Swal.fire({
                    type: 'success',
                    title: '¡Datos guardados!',
                    text: 'El anticipo se actualizó correctamente',
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
    }
});