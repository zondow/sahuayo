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
            { "data": "num" },
            { "data": "tipoPermiso" },
            { "data": "per_FechaInicio" },
            { "data": "per_FechaFin" },
            { "data": "per_DiasSolicitados" },
            { "data": "per_Motivos" },
            { "data": "per_Estado", render: function (data, type, row) { return estatusPermisoEmpleado(data) } },
            { "data": "per_PermisoID", render: function (data, type, row) { return accionesPermisosEmpleado(data, type, row) } },
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
                title: 'Mis permisos',
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
                previous: "<i class='zmdi zmdi-caret-left'>",
                next: "<i class='zmdi zmdi-caret-right'>"
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
                "sNext": "<i class='zmdi zmdi-caret-right'>",
                "sPrevious": "<i class='zmdi zmdi-caret-left'>"
            },

        },
        "order": [[0, "desc"]],
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
                } else if (txtTipoPermiso.val() === "7" || txtTipoPermiso.val() === "8" || txtTipoPermiso.val() === "9") {
                    if ($("#txtHoraI").val() != "" && $("#txtHoraF").val() != "") {
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
        // Rehabilitar temporalmente txtFechaFin si está deshabilitado
        const txtFechaFin = $("#txtFechaFin");
        const isDisabled = txtFechaFin.prop('disabled');

        if (isDisabled) {
            txtFechaFin.prop('disabled', false);
        }
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
                    icon: 'success',
                    title: '¡Permiso registrado!',
                    text: 'La solicitud de permiso se creo y envio a revisón correctamente',
                    showConfirmButton: false,
                    timer: 2000
                }).then(function() {
                    location.reload(); // Recargar la página
                });
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
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value)
                ajax_deletePermiso(permisoID);
        })//swal

    });

    /**CONFGURACION***/

    $("#date-range").datepicker({
        daysOfWeekDisabled: [0],
        format: "yyyy-mm-dd",
        toggleActive: !0,
        todayHighlight: true,
        autoclose: true,
        //startDate: new Date(),
    }).on('changeDate', function (e) {
        $("#txtFechaFin").focus();
    });

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
        var btnImprimir = '<button href="' + urlImprimir + '" class="btn btn-warning btn-icon btn-icon-mini btn-round hidden-sm-down show-pdf" data-title="Solicitud de permiso" title="Formato de solicitud"><i class="zmdi zmdi-local-printshop"></i></button>';

        var btnEliminar = '';
        if (row.per_Estado == 'PENDIENTE') {
            btnEliminar = '<button href="#" data-permiso="' + data + '" class="btn btn-danger  btn-icon btn-icon-mini btn-round hidden-sm-down btnEliminarPermiso" title="Eliminar solicitud"><i class="zmdi zmdi-delete"></i></button>';
        }//if

        return btnImprimir + btnEliminar;
    }//accionesPermisosEmpleado

    function estatusPermisoEmpleado(data) {
        var html = data;
        switch (data) {
            case 'PENDIENTE': html = '<span class="badge badge-info p-1">PENDIENTE</span>'; break;
            case 'AUTORIZADO_JEFE': html = '<span class="badge badge-warning p-1">AUTORIZADO JEFE</span>'; break;
            case 'AUTORIZADO_GG': html = '<span class="badge badge-success p-1">AUTORIZADO GERENTE GENERAL</span>'; break;
            case 'AUTORIZADO_GO': html = '<span class="badge badge-success p-1">AUTORIZADO GERENTE OPERATIVO</span>'; break;
            case 'AUTORIZADO_RH': html = '<span class="badge badge-success p-1">APLICADO</span>'; break;
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
                    icon: 'success',
                    title: '¡Solicitud eliminada!',
                    text: 'La solicitud de permiso se elimino correctamente',
                    showConfirmButton: false,
                    timer: 2000
                }).then(function() {
                    location.reload(); // Recargar la página
                });
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
            up: 'zmdi zmdi-caret-up',
            down: 'zmdi zmdi-caret-down',
        }
    });

    $("#txtTipoPermiso").change(function () {
        const valuesToShow = ["7", "8", "9"];
        const shouldShow = valuesToShow.includes($("#txtTipoPermiso").val());

        $(".timepicker").prop('required', shouldShow);
        $("#divMisHoras, #divHoraSalida, #divHoraRegreso").toggle(shouldShow);

        // Deshabilitar o habilitar el campo txtFechaFin
        $("#txtFechaFin").prop('disabled', shouldShow).prop('required', !shouldShow);

        // Si deshabilitas txtFechaFin, puedes limpiar su valor
        if (shouldShow) {
            $("#txtFechaFin").val(''); // Opcional: Limpia el valor si el campo se deshabilita
        }
    });

    $("#txtFechaInicio").change(function () {
        const tipoPermiso = $("#txtTipoPermiso").val();
        const fechaInicio = $(this).val();

        if (tipoPermiso === "7" || tipoPermiso === "8") {
            // Si es 7 u 8, txtFechaFin será el mismo día que txtFechaInicio
            $("#txtFechaFin").val(fechaInicio);
        } else if (tipoPermiso === "9" && fechaInicio) {
            // Si es 9, calcula 6 meses a partir de txtFechaInicio
            const fecha = new Date(fechaInicio);
            fecha.setMonth(fecha.getMonth() + 6); // Sumar 6 meses
            const anio = fecha.getFullYear();
            const mes = ("0" + (fecha.getMonth() + 1)).slice(-2); // Agrega un 0 delante si es necesario
            const dia = ("0" + fecha.getDate()).slice(-2); // Agrega un 0 delante si es necesario
            const fechaFin = `${anio}-${mes}-${dia}`;

            $("#txtFechaFin").val(fechaFin);
        } else {
            $("#txtFechaFin").val(""); // Limpia el valor si no aplica
        }
    });

    $("#txtTipoPermiso").change(function () {
        $("#txtFechaInicio").trigger("change"); // Re-ejecuta la lógica cuando cambia el tipo de permiso
    });


})(jQuery);