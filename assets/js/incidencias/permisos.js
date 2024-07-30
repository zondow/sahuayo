(function ($) {
    $("#divMisHoras").hide();
    $("#divHoraSalida").hide();
    $("#divHoraRegreso").hide();

    var frmPermiso = $("#frmPermiso");
    var btnRegistarPermiso = $("#btnRegistarPermiso");
    var txtFechaInicio = $("#txtFechaInicio");
    var txtFechaFin = $("#txtFechaFin");
    var txtTipoPermiso = $("#txtTipoPermiso");

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
                className: "btn l-slategray",
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
                "sPrevious": "<i class='zmdi zmdi-caret-left'>"
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
                } else if (txtTipoPermiso.val() === "7") {
                    if ($("#txtHoraI").val() != "" && $("#txtHoraF").val() != "") {
                        var timeStart = new Date($("#txtFechaInicio").val() + " " + $("#txtHoraI").val()).getHours();
                        var timeEnd = new Date($("#txtFechaFin").val() + " " + $("#txtHoraF").val()).getHours();
                        var hourDiff = timeEnd - timeStart;
                        if (hourDiff <= $("#totalHoras").val()) {
                            guardarPermiso();
                        } else {
                            showNotification("warning", "El rango de tiempo que elegiste excede tus horas", "top");
                        }
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
            $("#divMisHoras").show();
            $("#divHoraSalida").show();
            $("#divHoraRegreso").show();
        } else {
            $(".timepicker").prop('required', false);
            $("#divMisHoras").hide();
            $("#divHoraSalida").hide();
            $("#divHoraRegreso").hide();
        }
    });

})(jQuery);