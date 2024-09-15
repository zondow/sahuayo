$(document).ready(function (e) {
    var modalDocsAnticipo = $("#modalDocsAnticipo");
    var modalAspectosAnticipo = $("#modalAspectosAnticipo");
    var btnGuardarAspectos = $("#btnGuardarAspectos");

    var tblAnticipos = $("#tblAnticipos").DataTable({
        destroy: true,
        lengthMenu: [[10, 25, 50,100,500, -1], [10, 25, 50,100,500, "Todos"]],
        fixedHeader: true,
        //scrollY: "200px",
        scrollCollapse: true,
        scrollX:        true,
        paging:         true,
        ajax: {
            url: BASE_URL + "Incidencias/ajax_getAnticiposMisEmpleados",
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
                title: 'Anticipos colaboradores',
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
                title: 'Anticipos colaboradores',
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
                "sNext":    "<i class='zmdi zmdi-caret-right'>",
                "sPrevious": "<i class='zmdi zmdi-caret-left'>"
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
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if(result.value)
                updateEstatusAnticipo(anticipoID,"AUTORIZADO_JEFE");
        })//swal
    });

    $("body").on("click",".btnRecAnticipo",function (e) {
        var anticipoID = $(this).data("anticipo");

        Swal.fire({
            title: 'Rechazar anticipo',
            text: '¿Esta seguro que desea rechazar el anticipo?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if(result.value)
                updateEstatusAnticipo(anticipoID,"RECHAZADO_JEFE");
        })//swal
    });

    $("body").on("click",".btnAspectos",function (e) {
        var anticipoID = $(this).data("anticipo");
        var estatus = $(this).data("estatus");

        btnGuardarAspectos.data("anticipo",anticipoID);

        const estate = ['PENDIENTE', 'AUTORIZADO_JEFE', 'RECHAZADO_JEFE'];

        if(!estate.includes(estatus))
            btnGuardarAspectos.hide();
        getAspectosAnticipo(anticipoID);
    });

    btnGuardarAspectos.click(function (e) {
        var anticipoID = $(this).data("anticipo");

        var p1 = $("#txtHistorial").val();
        var p2 = $("#txtRetiros").val();
        var p3 = $("#txtAhorro").val();
        var p4 = $("#txtLibreActas").val();

        if (p1 != "") {
            if (p2 != "") {
                if (p3 != "") {
                    if (p4 != "") {
                        var fd = new FormData();
                        fd.append("p1", p1);
                        fd.append("p2", p2);
                        fd.append("p3", p3);
                        fd.append("p4", p4);
                        fd.append("anticipoID", anticipoID);
                        guardarAspectosAnticipo(fd);
                    }
                    else
                        showNotification("warning", "¡Selecciona la respuesta para la pregunta 4!")
                }
                else
                    showNotification("warning", "¡Selecciona la respuesta para la pregunta 3!")
            }
            else
                showNotification("warning", "¡Selecciona la respuesta para la pregunta 2!")
        }
        else
            showNotification("warning", "¡Selecciona la respuesta para la pregunta 1!")
    });

    modalAspectosAnticipo.on('hidden.bs.modal', function () {
        $("#txtHistorial").val(0).trigger("change");
        $("#txtRetiros").val(0).trigger("change");
        $("#txtAhorro").val(0).trigger("change");
        $("#txtLibreActas").val(0).trigger("change");
    });

    /****************FUNCTIONS******************/

    function accionesAnticipo(data,type,row){

        var urlImprimir = BASE_URL+'PDF/imprimirSolicitudAnticipo/'+data;
        var urlImprimirPagare = BASE_URL+'PDF/imprimirPagareAnticipo/'+data;

        var btnImprimir = ' <a href="' + urlImprimir +'"'+
            'class="btn btn-info btn-block waves-light waves-effect show-pdf" data-title="Solicitud de anticipo">'+
            '<i class="zmdi zmdi-local-printshop"></i>&nbsp; Imprimir anticipo</a>';

        var btnFiles = ' <button type="button" data-anticipo="'+data+'" data-estatus="'+row.ant_Estado+'" '+
            'class="btn btn-dark btn-block waves-light waves-effect btnDocumentacion">'+
            '<i class="dripicons-folder"></i>&nbsp; Documentación</button>';

        var btnAspectos = ' <button type="button" data-anticipo="'+data+'" data-estatus="'+row.ant_Estado+'" '+
            'class="btn btn-purple btn-block waves-light waves-effect btnAspectos">'+
            '<i class="dripicons-document-edit "></i>&nbsp; Aspectos</button>';

        var btnImprimirPagare = '';
        if(row.ant_Estado == 'AUTORIZADO_DIRECCION') {
            btnImprimirPagare = ' <a href="' + urlImprimirPagare + '"' +
                'class="btn btn-warning btn-block waves-light waves-effect show-pdf" data-title="Pagaré">' +
                '<i class="zmdi zmdi-local-printshop"></i>&nbsp; Imprimir pagaré</a>';
        }

        var btnRechazar = '';
        var btnAutorizar = '';
        if(row.ant_Estado == 'PENDIENTE') {
            btnAutorizar = '<button type="button" class="btn btn-success btn-block waves-light waves-effect btnAutAnticipo" ' +
                'data-anticipo="'+data+'"><i class="zmdi zmdi-check"></i>&nbsp; Autorizar</button>';

            btnRechazar = '<button type="button" class="btn btn-danger btn-block waves-light waves-effect btnRecAnticipo" ' +
                'data-anticipo="'+data+'"><i class="zmdi zmdi-close"></i>&nbsp; Rechazar</button>';

        }//if
        return btnImprimir + btnImprimirPagare + btnFiles + btnAspectos + btnAutorizar + btnRechazar;
    }//accionesAnticipo

    function estatusAnticipo(st){
        var html = st;
        switch (st){
            case "PENDIENTE":
                html =  '<span class="badge label-table badge-warning pt-1 pb-1 pr-2 pl-2">PENDIENTE</span>';
                break;
            case "AUTORIZADO_JEFE":
                html =  '<span class="badge label-table badge-info pt-1 pb-1 pr-2 pl-2">AUTORIZADO</span>';
                break;
            case "RECHAZADO_JEFE":
                html =  '<span class="badge label-table badge-danger pt-1 pb-1 pr-2 pl-2">RECHAZADO</span>';
                break;
            case "AUTORIZADO_RH":
                html =  '<span class="badge label-table badge-info pt-1 pb-1 pr-2 pl-2">AUTORIZADO DTH</span>';
                break;
            case "RECHAZADO_RH":
                html =  '<span class="badge label-table badge-danger pt-1 pb-1 pr-2 pl-2">RECHAZADO DTH</span>';
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
            url: BASE_URL+'Incidencias/ajax_updateEstatusAnticipo',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: {anticipoID:anticipoID, estatus:estatus}
        }).done(function(data){
            if (data.code === 1){
                tblAnticipos.ajax.reload();
                var title = estatus == 'AUTORIZADO_JEFE' ? '¡Anticipo autorizado correctamente!' : '¡Anticipo rechazado correctamente!';
                Swal.fire({
                    icon: 'success',
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

    function guardarAspectosAnticipo(fd){
        $.ajax({
            url: BASE_URL+'Incidencias/ajax_guardarAspectosAnticipo',
            cache: false,
            contentType: false,
            processData: false,
            type: 'post',
            dataType: 'json',
            data: fd
        }).done(function(data){
            if (data.code === 1){
                tblAnticipos.ajax.reload();
                modalAspectosAnticipo.modal('toggle');
                Swal.fire({
                    icon: 'success',
                    title: '¡Información actualizada!',
                    text: 'Los aspectos se guardaron correctamente',
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
    }//guardarAspectosAnticipo

    function getAspectosAnticipo(anticipoID){
        $.ajax({
            url: BASE_URL+'Incidencias/ajax_getAspectosAnticipo',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: {anticipoID:anticipoID}
        }).done(function(data){
            if (data.code === 1){
                $("#txtHistorial").val(data.aspectos.p1).trigger("change");
                $("#txtRetiros").val(data.aspectos.p2).trigger("change");
                $("#txtAhorro").val(data.aspectos.p3).trigger("change");
                $("#txtLibreActas").val(data.aspectos.p4).trigger("change");
                modalAspectosAnticipo.modal("show");
            }
            else
                showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");

        }).fail(function(data){
            showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");
        }).always(function(e){
        });//ajax
    }//getAspectosAnticipo

    $(".select2").select2();


});