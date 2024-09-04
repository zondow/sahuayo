(function ($) {
    //por horas
    $("#divMisHoras").hide();
    $("#divHoraSalida").hide();
    $("#divHoraRegreso").hide();
    $("#divTipoPermisoHora").hide();
    $("#divSolicitud").hide();

    //lactancia
    $("#divLactancia").hide();
    $("#txtFechaInicioLicencia").hide();
    $("#txtFechaFinLicencia").hide();
    $("#divHoraSalidaLicencia").hide();
    $("#divHoraRegresoLicencia").hide();
    $("#divHoraSalidaLicencia2").hide();
    $("#divHoraRegresoLicencia2").hide();

    //dias Administrativos
    $("#divPermisoAdmin").hide();
    $("#divDiasAdmin").hide();
    $("#divHorasAdmin").hide();


    var frmPermiso = $("#frmPermiso");
    var btnRegistarPermiso = $("#btnRegistarPermiso");
    var txtFechaInicio = $("#txtFechaInicio");
    //console.log(txtFechaInicio);
    var txtFechaFin = $("#txtFechaFin");
    var txtTipoPermiso = $("#txtTipoPermiso");
    var txtPermisoPor = $("#txtPermisoPor");

    var tblPermisos = $("#tblPermisos").DataTable({
        destroy: true,
        lengthMenu: [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "Todos"]],
        fixedHeader: true,
        //scrollY: "200px",
        scrollCollapse: true,
        scrollX: true,
        paging: true,
        ajax: {
            url: BASE_URL + "Incidencias/ajax_getPermisosByEmpleadoID",
            dataType: "json",
            type: "POST",
            "processing": true,
            "serverSide": true
        },
        columns: [
            { "data": "per_PermisoID", render: function (data, type, row) { return accionesPermisosEmpleado(data, type, row) } },
            { "data": "tipoPermiso" },
            { "data": "per_FechaInicio" },
            { "data": "per_FechaFin" },
            { "data": "per_DiasSolicitados" },
            { "data": "per_Motivos" },
            { "data": "per_Estado", render: function (data, type, row) { return estatusPermisoEmpleado(data) } }
        ],
        columnDefs: [
            { targets: 0, className: 'text-center' },
            { targets: 2, className: 'text-center' },
        ],
        responsive: true,
        stateSave: false,
        //dom: 'Blfrtip',
        dom: '<"row"<"col-md-4"l><"col-md-4 text-center"f><"col-md-4 cls-export-buttons"B>>rtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Mis permisos',
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
                title: 'Mis permisos',
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
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>"
            },
            search: "_INPUT_",
            searchPlaceholder: "Buscar...",
            lengthMenu: "Registros por página _MENU_",
            info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
            infoEmpty: "Mostrando 0 a 0 de 0 registros",
            zeroRecords: "No hay datos para mostrar",
            loadingRecords: "Cargando...",
            infoFiltered: "(filtrado de _MAX_ registros)",
            "processing": "Procesando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "<i class='mdi mdi-chevron-right'>",
                "sPrevious": "<i class='mdi mdi-chevron-left'>"
            },

        },
        "order": [[2, "asc"]],
        "processing": false
    });

    //Pregunta por fecha Aniv y Cumpleaños
    function fechaTipoPermiso(permiso, fechaInicio) {
        $.ajax({
            url: BASE_URL + "Incidencias/ajax_fechaColaborador/" + txtTipoPermiso.val() + "/" + txtFechaInicio.val(),
            type: "POST",
            dataType: "json"
        }).done(function (data) {
            if (data.code === '1') {
                guardarPermiso();
            } else if (data.code === '2') {
                showNotification("error", "La fecha que seleccionaste no se encuentra dentro de la regla de este permiso.", "top");
            } else {
                showNotification("error", "Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.", "top");
            }
        });//ajax
    }

    //Crear Permisos
    btnRegistarPermiso.click(function (evt) {
        evt.preventDefault();
        if (txtTipoPermiso.val() != "") {
            if (txtFechaInicio.val() != "" || txtFechaFin.val() != "") {
                if (txtTipoPermiso.val() === "1" || txtTipoPermiso.val() === "3") {
                    fechaTipoPermiso(txtTipoPermiso.val(), txtFechaInicio.val());
                } else if (txtTipoPermiso.val() === "7") {//Permiso por horas
                    if ($("#txtHoraI").val() != "" && $("#txtHoraF").val() != "") {
                        var timeStart = new Date($("#txtFechaInicio").val() + " " + $("#txtHoraI").val()).getHours();
                        var timeEnd = new Date($("#txtFechaFin").val() + " " + $("#txtHoraF").val()).getHours();
                        var hourDiff = timeEnd - timeStart;
                        if(txtPermisoPor.val() === 'porHoras'){
                            if (timeStart < timeEnd) {
                                if (hourDiff <= $("#totalHoras").val()) {
                                    guardarPermiso();
                                } else {
                                    showNotification("warning", "El rango de tiempo que elegiste excede tus horas", "top");
                                }
                            }else{
                                showNotification("warning", "Registro incorrecto", "top");
                            }
                        }else if(txtPermisoPor.val() === 'negociacionJefe'){
                            if (timeStart <= timeEnd) {
                                guardarPermiso();
                            }else{
                                showNotification("warning", "Registro incorrecto", "top");
                            }
                        }
                    } else {
                        showNotification("warning", "El rango de tiempo que elegiste esta vacio", "top");
                    }
                }else if (txtTipoPermiso.val() === "8") {//Dia administrativo
                    //if($("#tipoPermisoAdmin").val() != "" && $("#tipoPermisoAdmin").val())
                    if($("#tipoPermisoAdmin").val() === '2'){
                        if ($("#txtHoraI").val() != $("#txtHoraF").val()) {
                            var timeStart = new Date($("#txtFechaInicio").val() + " " + $("#txtHoraI").val()).getHours();
                            var timeEnd = new Date($("#txtFechaFin").val() + " " + $("#txtHoraF").val()).getHours();
                            var hourDiff = timeEnd - timeStart;
                            if (timeStart < timeEnd) {
                                if (hourDiff <= $("#totalHorasAdmin").val()) {
                                    guardarPermiso();
                                } else {
                                    showNotification("warning", "El rango de tiempo que elegiste excede tus horas", "top");
                                }
                            } else {
                                showNotification("warning", "Registro incorrecto", "top");
                            }
                        }else {
                            showNotification("warning", "El rango de tiempo que elegiste esta vacio", "top");
                        }
                    }else{
                        guardarPermiso();
                    }
                }else if (txtTipoPermiso.val() === "9") {//Licencia por lactancia
                    if ($("#txtHoraILicencia").val() != "" && $("#txtHoraFLicencia").val() != "") {
                        var timeStart = new Date($("#txtFechaInicioLicencia").val() + " " + $("#txtHoraILicencia").val()).getHours();
                        var timeEnd = new Date($("#txtFechaFinLicencia").val() + " " + $("#txtHoraFLicencia").val()).getHours();
                        var hourDiff = timeEnd - timeStart;
                        guardarPermiso();
                    } else {
                        showNotification("warning", "El rango de tiempo que elegiste esta vacio", "top");
                    }
                } else {
                    guardarPermiso();
                }
            } else {
                showNotification("warning", "Todos los campos son obligatorios.", "top");
            }
        } else {
            showNotification("warning", "Seleccione el tipo de permiso.", "top");
        }
    });

    function guardarPermiso() {
        btnRegistarPermiso.html('<i class="fas fa-spinner fa-pulse"></i>&nbsp; Guardando...');
        $.ajax({
            url: BASE_URL + "Incidencias/ajax_crearPermiso",
            type: "POST",
            data: frmPermiso.serialize(),
            dataType: "json"
        }).done(function (data) {
            btnRegistarPermiso.html('<span class="fe-plus"></span> Registrar');
            if (data.code === 1) {
                $('#frmPermiso')[0].reset();
                $("#txtTipoPermiso").val(0).trigger('change');
                tblPermisos.ajax.reload();
                Swal.fire({
                    type: 'success',
                    title: '¡Permiso registrado!',
                    text: 'La solicitud de permiso se creo y envio a revisón correctamente',
                    showConfirmButton: false,
                    timer: 2000
                })
                setTimeout(function () { window.location.href = BASE_URL+"Incidencias/misPermisos"; }, 600);
            }
            else if (data.code === 2)
                showNotification("error", data.msg, "top");
            else
                showNotification("error", "Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.", "top");
        }).always(function (e) {
            btnRegistarPermiso.html('<span class="fe-plus"></span> Registrar');
        });//ajax
    }

    $("body").on("click", ".btnEliminarPermiso", function (e) {
        var permisoID = $(this).data("permiso");

        Swal.fire({
            title: 'Eliminar solicitud',
            text: '¿Esta seguro que desea eliminar la solicitud de permiso?',
            type: 'question',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value)
                ajax_deletePermiso(permisoID);
        })//swal

    });

    /**CONFGURACION***/
    $(".datepicker").datepicker({
        autoclose: !0,
        daysOfWeekDisabled: [0],
        todayHighlight: !0,
        orientation: "bottom",
        format: "yyyy-mm-dd",
        daysOfWeek: ["D", "L", "M", "M", "J", "V", "S"],
        monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
    });

    $(".select2").select2();

    function showNotification(tipo, msg) {
        $.toast({
            text: msg,
            icon: tipo,
            loader: true,
            loaderBg: '#c6c372',
            position: 'top-right',
            allowToastClose: true,
        });
    }//showNotification

    function accionesPermisosEmpleado(data, type, row) {

        var urlImprimir = BASE_URL + 'PDF/imprimirPermiso/' + data;
        var btnImprimir = ' <a href="' + urlImprimir + '"' +
            'class="btn btn-info btn-block waves-light waves-effect show-pdf" data-title="Solicitud de permiso">' +
            '<i class="dripicons-print" title="Formato de solicitud"></i></a>';

        var btnEliminar = '';
        if (row.per_Estado == 'PENDIENTE') {
            btnEliminar = '<a href="#" class="btn btn-danger btn-block waves-light waves-effect btnEliminarPermiso" ' +
                'data-action="eliminar esta solicitud de permiso" data-permiso="' + data + '">' +
                '<i class="dripicons-trash" title="Eliminar"></i>&nbsp</a>';

        }//if

        return btnImprimir + btnEliminar;
    }//accionesPermisosEmpleado

    function estatusPermisoEmpleado(data) {
        var html = data;
        switch (data) {
            case 'PENDIENTE': html = '<span class="badge badge-dark p-1">PENDIENTE</span>'; break;
            case 'AUTORIZADO_JEFE': html = '<span class="badge badge-success p-1">AUTORIZADO JEFE</span>'; break;
            case 'AUTORIZADO_GG': html = '<span class="badge badge-success p-1">AUTORIZADO GERENTE GENERAL</span>'; break;
            case 'AUTORIZADO_GO': html = '<span class="badge badge-success p-1">AUTORIZADO GERENTE OPERATIVO</span>'; break;
            case 'AUTORIZADO_RH': html = '<span class="badge badge-info p-1">APLICADO</span>'; break;
            case 'RECHAZADO_JEFE': html = '<span class="badge badge-danger p-1">RECHAZADO JEFE</span>'; break;
            case 'RECHAZADO_GG': html = '<span class="badge badge-danger p-1">RECHAZADO GERENTE GENERAL</span>'; break;
            case 'RECHAZADO_GO': html = '<span class="badge badge-danger p-1">RECHAZADO GERENTE OPERATIVO</span>'; break;
            case 'RECHAZADO_RH': html = '<span class="badge badge-danger p-1">RECHAZADO</span>'; break;
            case 'DECLINADO': html = '<span class="badge badge-light-danger p-1">DECLINADO</span>'; break;
            case 'AUTORIZADO': html = '<span class="badge badge-success p-1">AUTORIZADO</span>'; break;
            case 'RECHAZADO': html = '<span class="badge badge-danger p-1">RECHAZADO</span>'; break;
            case 'PRE-AUTORIZADO': html = '<span class="badge badge-purple p-1">PRE-AUTORIZADO</span>'; break;
        }//switch

        return html;
    }//estatusPermisoEmpleado

    function ajax_deletePermiso(permisoID) {
        $.ajax({
            url: BASE_URL + 'Incidencias/ajax_deletePermiso',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: { permisoID: permisoID }
        }).done(function (data) {
            if (data.code === 1) {
                tblPermisos.ajax.reload();
                Swal.fire({
                    type: 'success',
                    title: '¡Solicitud eliminada!',
                    text: 'La solicitud de permiso se elimino correctamente',
                    showConfirmButton: false,
                    timer: 2000
                })
            } else {
                showNotification("error", "Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.", "top");
            }//if-else
        }).fail(function (data) {
            showNotification("error", "Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.", "top");
        }).always(function (e) {
        });//ajax

    }//ajax_deletePermiso

    $('.timepicker').timepicker({
        use24hours: true,
        format: "HH:mm",
        showMeridian: false,
        icons: {
            up: 'fas fa-angle-up',
            down: 'fas fa-angle-down',
        }
    });


    $("#txtTipoPermiso").change(function (evt) {
        if ($("#txtTipoPermiso").val() === "7") {
            $(".timepicker").prop('required', true);
            $("#divMisHoras").hide();
            $("#divHoraSalida").hide();
            $("#divHoraRegreso").hide();
            $("#txtFechaInicioLicencia").hide();
            $("#txtFechaFinLicencia").hide();
            $("#divHoraSalidaLicencia2").hide();
            $("#divHoraRegresoLicencia2").hide();
            $("#txtFechaInicio").show();
            $("#txtFechaFin").show();
            $("#divLactancia").hide();
            $("#divHoraSalidaLicencia").hide();
            $("#divHoraRegresoLicencia").hide();
            $("#txtHoraI").show();
            $("#txtHoraF").show();
            $("#divPermisoAdmin").hide();
            $("#divDiasAdmin").hide();
            $("#divHorasAdmin").hide();
            $("#divTipoPermisoHora").show();
            $("#divSolicitud").hide();
            $("#txtPermisoHora").val('');
            $("#txtFechaFin").datepicker("destroy");
            // Establecer el campo como solo lectura
            $("#txtFechaFin").prop("readonly", true);
            $("#txtFechaInicio").change(function (evt) {
                $("#txtFechaFin").val($("#txtFechaInicio").val());
            });
            $("#txtPermisoHora").change(function (evt) {
                //console.log('here');
                //console.log($("#txtPermisoPor").val());
                //console.log($("#txtPermisoHora").val());
                $("#divMisHoras").hide();
                $("#divHoraSalida").hide();
                $("#divHoraRegreso").hide();
                $("#divSolicitud").show();
                $("#txtPermisoPor").val('');
                $("#txtPermisoPor").change(function (evt) {

                    if ($("#txtPermisoPor").val() === "porHoras" && $("#txtPermisoHora").val() === "llegarTarde") {
                        console.log('here1');
                        $("#divMisHoras").show();
                        $("#divHoraSalida").hide();
                        $("#divHoraRegreso").show();
                        $("#labelFin").html('Hora ingreso');
                        $("#txtHoraF").prop('required', true);
                        $("#txtHoraI").prop('required', true);
                        consultarHorarioDia(txtFechaInicio.val(), 'entrada');
                    } else if ($("#txtPermisoPor").val() === 'negociacionJefe' && $("#txtPermisoHora").val() === "llegarTarde") {
                        console.log('here2');
                        $("#divMisHoras").hide();
                        $("#divHoraSalida").hide();
                        $("#divHoraRegreso").show();
                        $("#labelFin").html('Hora ingreso');
                        $("#txtHoraF").prop('required', true);
                        $("#txtHoraI").prop('required', true);
                        consultarHorarioDia(txtFechaInicio.val(), 'entrada');
                    } else if ($("#txtPermisoPor").val() === "porHoras" && $("#txtPermisoHora").val() === "salirTemprano") {
                        console.log('here3');
                        $("#divMisHoras").show();
                        $("#divHoraSalida").show();
                        $("#divHoraRegreso").hide();
                        $("#labelInicio").html('Hora salida');
                        $("#txtHoraI").prop('required', true);
                        $("#txtHoraF").prop('required', true);
                        consultarHorarioDia(txtFechaInicio.val(), 'salida');
                    } else if ($("#txtPermisoPor").val() === 'negociacionJefe' && $("#txtPermisoHora").val() === "salirTemprano") {
                        console.log('here4');
                        $("#divMisHoras").hide();
                        $("#divHoraSalida").show();
                        $("#divHoraRegreso").hide();
                        $("#labelInicio").html('Hora salida');
                        $("#txtHoraI").prop('required', true);
                        $("#txtHoraF").prop('required', true);
                        consultarHorarioDia(txtFechaInicio.val(), 'salida');
                    } else if ($("#txtPermisoPor").val() === "porHoras" && $("#txtPermisoHora").val() === "porHoras") {
                        console.log('here5');
                        $("#divMisHoras").show();
                        $("#divHoraSalida").show();
                        $("#divHoraRegreso").show();
                        $("#labelInicio").html('Hora salida');
                        $("#labelFin").html('Hora regreso');
                        $("#txtHoraI").prop('required', true);
                        $("#txtHoraF").prop('required', true);
                        //consultarHorarioDia(txtFechaInicio.val(),'salida');
                    } else if ($("#txtPermisoPor").val() === 'negociacionJefe' && $("#txtPermisoHora").val() === "porHoras") {
                        console.log('here6');
                        $("#divMisHoras").hide();
                        $("#divHoraSalida").show();
                        $("#divHoraRegreso").show();
                        $("#labelInicio").html('Hora salida');
                        $("#labelFin").html('Hora regreso');
                        $("#txtHoraI").prop('required', true);
                        $("#txtHoraF").prop('required', true);
                        //consultarHorarioDia(txtFechaInicio.val(),'salida');
                    }
                });

            });
            //Dia administrativo
        }else if($("#txtTipoPermiso").val() === "8"){
            $(".timepicker").prop('required', true);
            $("#divMisHoras").hide();
            $("#txtFechaInicio").hide();
            $("#txtFechaFin").hide();
            $("#txtHoraI").hide();
            $("#txtHoraF").hide();
            $("#divHoraSalida").hide();
            $("#divHoraRegreso").hide();
            $("#txtFechaInicioLicencia").hide();
            $("#txtFechaFinLicencia").hide();
            $("#divHoraSalidaLicencia").hide();
            $("#divHoraRegresoLicencia").hide();
            $("#divHoraSalidaLicencia2").hide();
            $("#divHoraRegresoLicencia2").hide();
            $("#divTipoPermisoHora").hide();
            $("#divSolicitud").hide();
            //$("#tipoLicencia").hide();
            $("#divLactancia").hide();
            $("#divPermisoAdmin").show();
            $("#tipoPermisoAdmin").change(function (evt) {
                if ($("#tipoPermisoAdmin").val() === "1") {
                    $("#divDiasAdmin").show();
                    $("#divHorasAdmin").hide();
                    $("#txtHoraI").hide();
                    $("#txtHoraF").hide();
                    $("#divHoraSalida").hide();
                    $("#divHoraRegreso").hide();
                }else{
                    $("#divHorasAdmin").show();
                    $("#divHoraSalida").show();
                    $("#divHoraRegreso").show();
                    $("#divDiasAdmin").hide();
                    $("#txtHoraI").show();
                    $("#txtHoraF").show();
                }

            });

            $("#txtFechaFinLicencia").datepicker("destroy");
            // Establecer el campo como solo lectura
            $("#txtFechaFinLicencia").prop("readonly", true);
            $("#txtFechaInicioLicencia").show();
            $("#txtFechaFinLicencia").show();
            $("#txtFechaInicioLicencia").change(function (evt) {
                $("#txtFechaFinLicencia").val($("#txtFechaInicioLicencia").val());
            });
            //Licencia por Lactancia
        }else if($("#txtTipoPermiso").val() === "9"){
            $(".timepicker").prop('required', true);
            $("#divMisHoras").hide();
            $("#txtFechaInicio").hide();
            $("#txtFechaFin").hide();
            $("#txtHoraI").hide();
            $("#txtHoraF").hide();
            $("#divHoraSalida").hide();
            $("#divHoraRegreso").hide();
            $("#divLactancia").show();
            $("#divPermisoAdmin").hide();
            $("#divDiasAdmin").hide();
            $("#divHorasAdmin").hide();
            $("#divTipoPermisoHora").hide();
            $("#divSolicitud").hide();



            $("#txtFechaFinLicencia").datepicker("destroy");
            // Establecer el campo como solo lectura
            $("#txtFechaFinLicencia").prop("readonly", true);
            $("#txtFechaInicioLicencia").show();
            $("#txtFechaFinLicencia").show();
            $("#txtFechaInicioLicencia").change(function (evt) {
                var fechaInicio = $("#txtFechaInicioLicencia").val();
                var fechaInicioDate = new Date(fechaInicio);
                fechaInicioDate.setMonth(fechaInicioDate.getMonth() + 6);

                var year = fechaInicioDate.getFullYear();
                var month = fechaInicioDate.getMonth() + 1; // Se suma 1 porque los meses en JavaScript van de 0 a 11
                var day = fechaInicioDate.getDate();

                var fechaFin = year + '-' + (month < 10 ? '0' + month : month) + '-' + (day < 10 ? '0' + day : day);
                $("#txtFechaFinLicencia").val(fechaFin);
            });

            $("#tipoLicencia").change(function (evt) {
                if ($("#tipoLicencia").val() === "1") {
                    $("#divHoraSalidaLicencia").show();
                    $("#divHoraRegresoLicencia").show();
                    $("#divHoraSalidaLicencia2").hide();
                    $("#divHoraRegresoLicencia2").hide();
                    $("#txtHoraI").hide();
                    $("#txtHoraF").hide();
                    $("#divMisHoras").hide();
                    $("#txtFechaInicio").hide();
                    $("#txtFechaFin").hide();
                    //$("#divHoraRegresoLicencia input").prop('readonly', true);
                    $("#txtHoraILicencia").change(function (evt) {
                        // Obtener el valor de la hora de salida
                        var horaSalida = $("#txtHoraILicencia").val();
                        // Dividir la hora en partes
                        var partesHora = horaSalida.split(':');
                        // Obtener la hora y los minutos
                        var hora = partesHora[0];
                        var minutos = partesHora[1];
                        // Añadir un cero delante si la hora es menor que 10
                        hora = hora.padStart(2, '0');
                        // Reconstruir la hora en el formato deseado
                        var horaFormateada = hora + ':' + minutos;
                        // Crear el objeto Date con la hora formateada
                        var horaSalidaDate = new Date('2000-01-01T' + horaFormateada);
                        horaSalidaDate.setHours(horaSalidaDate.getHours() + 1);
                        var hour = horaSalidaDate.getHours();
                        var minutos = horaSalidaDate.getMinutes();
                        var horaRegreso = (hour < 10 ? '0' + hour : hour) + ':' + (minutos < 10 ? '0' + minutos : minutos);

                        $("#txtHoraFLicencia").val(horaRegreso);
                        $("#txtHoraILicencia2").val('');
                        $("#txtHoraFLicencia2").val('');
                    });

                }else{
                    $("#divHoraSalidaLicencia").show();
                    $("#divHoraRegresoLicencia").show();
                    $("#divHoraSalidaLicencia2").show();
                    $("#divHoraRegresoLicencia2").show();
                    $("#divMisHoras").hide();
                    $("#txtFechaInicio").hide();
                    $("#txtFechaFin").hide();
                    $("#txtHoraI").hide();
                    $("#txtHoraF").hide();
                    //$("#divHoraRegresoLicencia input").prop('readonly', true);
                    $("#txtHoraILicencia").change(function (evt) {
                        // Obtener el valor de la hora de salida
                        var horaSalida = $("#txtHoraILicencia").val();
                        // Dividir la hora en partes
                        var partesHora = horaSalida.split(':');
                        // Obtener la hora y los minutos
                        var hora = partesHora[0];
                        var minutos = partesHora[1];
                        // Añadir un cero delante si la hora es menor que 10
                        hora = hora.padStart(2, '0');
                        // Reconstruir la hora en el formato deseado
                        var horaFormateada = hora + ':' + minutos;
                        // Crear el objeto Date con la hora formateada
                        var horaSalidaDate = new Date('2000-01-01T' + horaFormateada);
                        horaSalidaDate.setMinutes(horaSalidaDate.getMinutes() + 30);
                        var hour = horaSalidaDate.getHours();
                        var minutos = horaSalidaDate.getMinutes();
                        var horaRegreso30 = (hour < 10 ? '0' + hour : hour) + ':' + (minutos < 10 ? '0' + minutos : minutos);
                        console.log(hour);
                        // Establecer el valor de $("#divHoraRegresoLicencia")
                        $("#txtHoraFLicencia").val(horaRegreso30);
                    });

                    $("#txtHoraILicencia2").change(function (evt) {
                        // Obtener el valor de la hora de salida
                        var horaSalida = $("#txtHoraILicencia2").val();
                        // Dividir la hora en partes
                        var partesHora = horaSalida.split(':');
                        // Obtener la hora y los minutos
                        var hora = partesHora[0];
                        var minutos = partesHora[1];
                        // Añadir un cero delante si la hora es menor que 10
                        hora = hora.padStart(2, '0');
                        // Reconstruir la hora en el formato deseado
                        var horaFormateada = hora + ':' + minutos;
                        // Crear el objeto Date con la hora formateada
                        var horaSalidaDate = new Date('2000-01-01T' + horaFormateada);
                        horaSalidaDate.setMinutes(horaSalidaDate.getMinutes() + 30);
                        var hour = horaSalidaDate.getHours();
                        var minutos = horaSalidaDate.getMinutes();
                        var horaRegreso302 = (hour < 10 ? '0' + hour : hour) + ':' + (minutos < 10 ? '0' + minutos : minutos);
                        // Establecer el valor de $("#divHoraRegresoLicencia")
                        console.log(horaRegreso302);
                        $("#txtHoraFLicencia2").val(horaRegreso302);
                    });
                }
            });
        }else {
            $(".timepicker").prop('required', false);
            $("#divMisHoras").hide();
            $("#divHoraSalida").hide();
            $("#divHoraRegreso").hide();
            $("#divLactancia").hide();
            $("#txtFechaInicioLicencia").hide();
            $("#txtFechaFinLicencia").hide();
            $("#txtFechaInicio").show();
            $("#txtFechaFin").show();
            $("#divHoraSalidaLicencia").hide();
            $("#divHoraRegresoLicencia").hide();
            $("#divHoraSalidaLicencia2").hide();
            $("#divHoraRegresoLicencia2").hide();
            $("#divPermisoAdmin").hide();
            $("#divDiasAdmin").hide();
            $("#divHorasAdmin").hide();
            $("#divTipoPermisoHora").hide();
            $("#divSolicitud").hide();
            $("#txtFechaFin").prop("readonly", false);



        }
    });

    function consultarHorarioDia(dia, tipo) {
        $.ajax({
            url: BASE_URL + 'Incidencias/ajax_getHorarioColaborador',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: { dia: dia, tipo: tipo }
        }).done(function (data) {

            if (tipo === 'entrada') {
                $("#txtHoraI").val(data.hora);
            } else {
                $("#txtHoraF").val(data.hora);
            }

        }).fail(function (data) {
        }).always(function (e) {
        });//ajax
    }

})(jQuery);