$(document).ready(function (e) {

    var btnAddAnticipo = $("#btnAddAnticipo");
    var modalAddAnticipo = $("#modalAddAnticipo");
    var btnGuardarAnticipo = $("#btnGuardarAnticipo");
    var txtMontoMaximo = $("#txtMontoMaximo");
    var modalDocsAnticipo = $("#modalDocsAnticipo");
    var frmAnticipo = document.getElementById("frmAnticipo");

    var tblAnticipos = $("#tblAnticipos").DataTable({
        destroy: true,
        lengthMenu: [[10, 25, 50,100,500, -1], [10, 25, 50,100,500, "Todos"]],
        fixedHeader: true,
        //scrollY: "200px",
        scrollCollapse: true,
        scrollX:        true,
        paging:         true,
        ajax: {
            url: BASE_URL + "Incidencias/ajax_getMisAnticipos",
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
                title: 'Mis Anticipos',
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
                title: 'Mis Anticipos',
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

    btnAddAnticipo.click(function (e) {
        modalAddAnticipo.modal('show');
    });

    btnGuardarAnticipo.click(function (e) {
        var lugar = $("#txtLugar").val();
        var noSocio = $("#txtNoSocio").val();
        var domicilio = $("#txtDomicilio").val();
        var estadoCivil = $("#txtEstadoCivil").val();
        var sexo = $("#txtSexo").val();
        var montoSolicitado = $("#txtMondoSolicitado").val();

        if(lugar != ''){

            if(noSocio != ''){
                if(domicilio != ''){
                    if(estadoCivil != ''){
                        if(sexo != ''){
                            if(montoSolicitado > 0)
                                guardarAnticipo($(this), new FormData(frmAnticipo));
                            else
                                showNotification("warning","¡Escribe el monto a slicitar!")
                        }
                        else
                            showNotification("warning","¡Selecciona el sexo!")
                    }
                    else
                        showNotification("warning","¡Selecciona el estado civil!")
                }
                else
                    showNotification("warning","¡Escribe el domicilio!")
            }
            else
                showNotification("warning","¡Escribe el no de socio!")
        }
        else
            showNotification("warning","¡Escribe el lugar!")
    });

    modalAddAnticipo.on('hidden.bs.modal', function () {
       clear()
    });

    $("body").on("click",".btnEliminarAnticipo",function (e) {
        var anticipoID = $(this).data("anticipo");

        Swal.fire({
            title: 'Eliminar anticipo',
            text: '¿Esta seguro que desea eliminar el anticipo?',
            type: 'question',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
        }).then((result) => {
            if(result.value)
                eliminarAnticipo(anticipoID,$(this));
        })//swal
    });

    $("body").on("click",".btnDocumentacion",function (e) {
        var anticipoID = $(this).data("anticipo");
        var st = $(this).data("estatus");

        $("#txtAnticipoFilesID").val(anticipoID);
        $("#txtEstatusAnticipo").val(st);
        getArchivosAnticipo(anticipoID);
    });

    $("#txtMondoSolicitado").blur(function (e) {
        var value = $(this).val();
        var maximo = txtMontoMaximo.data("monto");

        if(value > maximo){
            Swal.fire({
                type: 'warning',
                title:number_format(maximo.toFixed(2).toString()),
                text: 'Es el monto máximo que puedes solicitar',
                showConfirmButton: true,
            });
            $(this).val(maximo);
        }//if
    });
    /****************FUNCTIONS******************/

    function accionesAnticipo(data,type,row){

        var urlImprimir = BASE_URL+'PDF/imprimirSolicitudAnticipo/'+data;
        var urlImprimirPagare = BASE_URL+'PDF/imprimirPagareAnticipo/'+data;

        var btnImprimir = ' <a href="' + urlImprimir +'"'+
            'class="btn btn-info btn-block waves-light waves-effect show-pdf" data-title="Solicitud de anticipo">'+
            '<i class="dripicons-print"></i>&nbsp; Imprimir anticipo</a>';

        var btnImprimirPagare = '';
        if(row.ant_Estado == 'AUTORIZADO_DIRECCION') {
            btnImprimirPagare = ' <a href="' + urlImprimirPagare + '"' +
                'class="btn btn-warning btn-block waves-light waves-effect show-pdf" data-title="Pagaré">' +
                '<i class="dripicons-print"></i>&nbsp; Imprimir pagaré</a>';
        }

        var btnFiles = ' <button type="button" data-anticipo="'+data+'" data-estatus="'+row.ant_Estado+'" '+
            'class="btn btn-success btn-block waves-light waves-effect btnDocumentacion">'+
            '<i class="dripicons-folder"></i>&nbsp; Documentación</button>';

        var btnEliminar = '';
        if(row.ant_Estado == 'PENDIENTE') {
            btnEliminar = '<button type="button" class="btn btn-danger btn-block waves-light waves-effect btnEliminarAnticipo" ' +
                'data-anticipo="'+data+'"><i class="dripicons-trash"></i>&nbsp; Eliminar</button>';

        }//if
        return btnImprimir + btnImprimirPagare +btnFiles + btnEliminar;
    }//accionesAnticipo

    function estatusAnticipo(st){
        var html = st;
        switch (st){
            case "PENDIENTE":
                html =  '<span class="badge label-table badge-warning pt-1 pb-1 pr-2 pl-2">PENDIENTE</span>';
                break;
            case "AUTORIZADO_JEFE":
                html =  '<span class="badge label-table badge-info pt-1 pb-1 pr-2 pl-2">AUTORIZADO<br><br> JEFE INMEDIATO</span>';
                break;
            case "RECHAZADO_JEFE":
                html =  '<span class="badge label-table badge-danger pt-1 pb-1 pr-2 pl-2">RECHAZADO<br><br> JEFE INMEDIATO</span>';
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

    $(".select2").select2();

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

    function guardarAnticipo(button,frm){
        button.html('<i class="fas fa-spinner fa-pulse"></i>&nbsp; Guardando...');
        $.ajax({
            url: BASE_URL+'Incidencias/ajax_solicitarAnticipo',
            cache: false,
            contentType: false,
            processData: false,
            type: 'post',
            dataType: 'json',
            data: frm
        }).done(function(data){
            button.html('<span class="fa fa-save"></span> Guardar');
            if (data.code === 1){
                tblAnticipos.ajax.reload();
                modalAddAnticipo.modal('toggle');
                clear();
                Swal.fire({
                    type: 'success',
                    title: '¡Anticipo registrado!',
                    text: 'El anticipo se guardó correctamente',
                    showConfirmButton: false,
                    timer: 2000
                })
            }else{
                showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");
            }//if-else
        }).fail(function(data){
            showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");
        }).always(function(e){
            button.html('<span class="fa fa-save"></span> Guardar');
        });//ajax
    }//guardarAnticipo

    function eliminarAnticipo(anticipoID,button){
        button.html('<i class="fas fa-spinner fa-pulse"></i>&nbsp; Eliminando...');
        $.ajax({
            url: BASE_URL+'Incidencias/ajax_eliminarAnticipo',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: {anticipoID:anticipoID}
        }).done(function(data){
            button.html('<i class="dripicons-trash"></i>&nbsp; Eliminar');
            if (data.code === 1){
                tblAnticipos.ajax.reload();
                Swal.fire({
                    type: 'success',
                    title: '¡Anticipo eliminado!',
                    text: 'El anticipo se eliminó correctamente',
                    showConfirmButton: false,
                    timer: 3000
                })
            }else{
                showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");
            }//if-else
        }).fail(function(data){
            showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.","top");
        }).always(function(e){
            button.html('<i class="dripicons-trash"></i>&nbsp; Eliminar');
        });//ajax

    }//ajax_aplicarPermiso

    function clear(){
        $('#frmAnticipo')[0].reset();
        $("#txtSucursal").val(0).trigger('change');
        $("#txtEstadoCivil").val(0).trigger('change');
        $("#txtSexo").val(0).trigger('change');
    }//clear

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
                    }
                    else
                    {
                        $("#cntEmpty_" + files[f].file).removeClass("ocultar");
                        $("#cntFill_" + files[f].file).addClass("ocultar");
                        $("#urlFile_" + files[f].file).attr("href", "#");
                        $("#urlIcon_" + files[f].file).attr("src", "#");
                        $("#urlFile_" + files[f].file).attr("target", "");
                    }
                }
            }
        }).fail(function(data){
        }).always(function(e){
        });//ajax
    }//getArchivosAnticipo



});