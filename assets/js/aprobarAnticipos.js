$(document).ready(function (e) {
    var modalDocsAnticipo = $("#modalDocsAnticipo");

    var tblAnticipos = $("#tblAnticipos").DataTable({
        destroy: true,
        lengthMenu: [[10, 25, 50,100,500, -1], [10, 25, 50,100,500, "Todos"]],
        fixedHeader: true,
        //scrollY: "200px",
        scrollCollapse: true,
        scrollX:        true,
        paging:         true,
        ajax: {
            url: BASE_URL + "Incidencias/ajax_getAnticiposAprobar",
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
                title: 'Anticipos',
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
                updateEstatusAnticipo(anticipoID,"AUTORIZADO_DIRECCION",$(this),'');
        })//swal
    });

    $("body").on("click",".btnRecAnticipo",function (e) {
        var anticipoID = $(this).data("anticipo");

        Swal.fire({
            title: 'Rechazar anticipo',
            text: '¿Esta seguro que desea rechazar el anticipo?',
            icon: 'question',
            html:'<div class="row"><div class="col-md-12"><label>*Comentarios:</label>' +
            '<textarea id="txtRazonRechazo" class="form-control" placeholder="Escribe la razón por la cual no se autoriza el anticipo"></textarea>' +
            '</div></div>',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            preConfirm: function () {
                var razon = $("#txtRazonRechazo").val().trim();

                if(razon != "")
                    return true;
                else {
                    showNotification("warning", "¡Escribe la razón por la cual no se autoriza el anticipo!")
                    return false;
                }
            }
        }).then((result) => {

            var razon = $("#txtRazonRechazo").val().trim();
            if(result.value)
                updateEstatusAnticipo(anticipoID, "RECHAZADO_DIRECCION",$(this),razon);
        })//swal
    });

    /****************FUNCTIONS******************/

    function accionesAnticipo(data,type,row){

        var urlImprimir = BASE_URL+'PDF/imprimirSolicitudAnticipo/'+data;
        var urlImprimirPagare = BASE_URL+'PDF/imprimirPagareAnticipo/'+data;

        var btnImprimir = ' <a href="' + urlImprimir +'"'+
            'class="btn btn-info btn-block waves-light waves-effect show-pdf" data-title="Solicitud de anticipo">'+
            '<i class="zmdi zmdi-local-printshop"></i>&nbsp; Imprimir anticipo</a>';

        var btnFiles = ' <button type="button" data-anticipo="'+data+'" data-estatus="'+row.ant_Estado+'" '+
            'class="btn btn-primary btn-block waves-light waves-effect btnDocumentacion">'+
            '<i class="dripicons-folder"></i>&nbsp; Documentación</button>';


        var btnImprimirPagare = '';
        if(row.ant_Estado == 'AUTORIZADO_DIRECCION') {
            btnImprimirPagare = ' <a href="' + urlImprimirPagare + '"' +
                'class="btn btn-warning btn-block waves-light waves-effect show-pdf" data-title="Pagaré">' +
                '<i class="zmdi zmdi-local-printshop"></i>&nbsp; Imprimir pagaré</a>';
        }


        var btnRechazar = '';
        var btnAutorizar = '';
        if(row.ant_Estado == 'AUTORIZADO_RH') {
            btnAutorizar = '<button type="button" class="btn btn-success btn-block waves-light waves-effect btnAutAnticipo" ' +
                'data-anticipo="'+data+'"><i class="zmdi zmdi-check"></i>&nbsp; Autorizar</button>';

            btnRechazar = '<button type="button" class="btn btn-danger btn-block waves-light waves-effect btnRecAnticipo" ' +
                'data-anticipo="'+data+'"><i class="zmdi zmdi-close"></i>&nbsp; Rechazar</button>';

        }//if
        return btnImprimir + btnImprimirPagare + btnFiles + btnAutorizar + btnRechazar;
    }//accionesAnticipo

    function estatusAnticipo(st){
        var html = st;
        switch (st){
            case "PENDIENTE":
            case "AUTORIZADO_JEFE":
            case "AUTORIZADO_RH":
                html =  '<span class="badge label-table badge-warning pt-1 pb-1 pr-2 pl-2">PENDIENTE</span>';
                break;
            case "RECHAZADO_RH":
                html =  '<span class="badge label-table badge-danger pt-1 pb-1 pr-2 pl-2">RECHAZADO</span>';
                break;
            case "AUTORIZADO_DIRECCION":
                html =  '<span class="badge label-table badge-success pt-1 pb-1 pr-2 pl-2">AUTORIZADO</span>';
                break;
            case "RECHAZADO_DIRECCION":
                html =  '<span class="badge label-table badge-danger pt-1 pb-1 pr-2 pl-2">RECHAZADO</span>';
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

    function updateEstatusAnticipo(anticipoID,estatus,button,obs = ''){
        if(estatus == 'RECHAZADO_DIRECCION')
            button.html('<i class="fas fa-spinner fa-pulse"></i>&nbsp; Rechazando...');
        else
            button.html('<i class="fas fa-spinner fa-pulse"></i>&nbsp; Autorizando...');

        $.ajax({
            url: BASE_URL+'Incidencias/ajax_updateEstatusAnticipoDireccion',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: {anticipoID:anticipoID, estatus:estatus, obs:obs}
        }).done(function(data){
            if (data.code === 1){
                tblAnticipos.ajax.reload();
                var title = estatus == 'AUTORIZADO_DIRECCION' ? '¡Anticipo autorizado correctamente!' : '¡Anticipo rechazado correctamente!';
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
            if(estatus == 'RECHAZADO_DIRECCION')
                button.html('<i class="zmdi zmdi-close"></i>&nbsp; Rechazar');
            else
                button.html('<i class="zmdi zmdi-check"></i>&nbsp; Autorizar');
        });//ajax
    }//updateEstatusAnticipo
});