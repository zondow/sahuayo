(function ($) {

    var tblSalidas = $("#tblIncapacidades").DataTable({
        destroy: true,
        lengthMenu: [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "Todos"]],
        fixedHeader: true,
        scrollCollapse: true,
        scrollX: true,
        paging: true,
        ajax: {
            url: BASE_URL + "Incidencias/ajax_getSolicitudIncapacidades",
            dataType: "json",
            type: "POST",
            "processing": true,
            "serverSide": true
        },
        columns: [
            { "data": "acciones", render: function (data, type, row) { return acciones(data, type, row) } },
            { "data": "count" },
            { "data": "inc_Folio" },
            { "data": "inc_Tipo" },
            { "data": "emp_Nombre" },
            { "data": "inc_FechaRegistro" },
            { "data": "inc_FechaInicio" },
            { "data": "inc_FechaFin" },
            { "data": "inc_Dias" },
            { "data": "inc_Motivos" },
            { "data": "inc_Estatus", render: function (data, type, row) { return estatus(data) } },
            { "data": "inc_Justificacion" },
        ],
        columnDefs: [
            { targets: 0, className: 'text-center' },
        ],
        responsive: true,
        stateSave: false,
        //dom: 'Blfrtip',
        dom: '<"row"<"col-md-4"l><"col-md-4 text-center"f><"col-md-4 cls-export-buttons"B>>rtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Solicitudes horas extra colaboradores',
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
                title: 'Solicitudes horas extra colaboradores',
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
        "order": [[1, "desc"]],
        "processing": false
    });

    function acciones(data,type,row){

        var urlImprimir = BASE_URL+'assets/uploads/incapacidades/' + row.inc_EmpleadoID+ "/" + row.inc_Archivo;
        var btnImprimir = ' <a href="' + urlImprimir +'"'+
            ' class="btn btn-info waves-light btn-block waves-effect show-pdf" data-title="Imprimir comprobante incapacidad" style="color: white" title="Imprimir comprobante">'+
            '<i class="dripicons-print"></i></a>';

        var btnAutorizar = '';
        var btnRechazar = '';
        if(row.inc_Estatus == 'Pendiente') {
            btnAutorizar = '<a href="#" class="btn btn-primary btn-block waves-light waves-effect btnRevisar" ' +
                'data-id="'+row.inc_IncapacidadID+'" data-accion="Autorizar" title="Autorizar">' +
                '<i class="fa fa-check"></i></a>';
            btnRechazar = '<a href="#" class="btn btn-danger btn-block waves-light waves-effect btnRevisar" ' +
            'data-id="'+row.inc_IncapacidadID+'" data-accion="Rechazar" title="Rechazar">' +
            '<i class="fa fa-times"></i></a>';
        }//if

        return btnImprimir + btnAutorizar + btnRechazar;
    }

    function estatus(data, type, row) {
        var html = data;
        switch (data) {
            case 'Pendiente': html = '<span class="badge badge-dark p-1">PENDIENTE</span>'; break;
            case 'Autorizada': html = '<span class="badge badge-success p-1">AUTORIZADO</span>'; break;
            case 'Rechazada': html = '<span class="badge badge-danger p-1">RECHAZADO</span>'; break;
        }//switch

        return html;
    }

    //Enviar reporte
    $("body").on("click", ".btnRevisar", function (e) {
        var reporteID = $(this).data("id");
        var accion = $(this).data("accion");

        if (accion === "Autorizar") {
            titulo = "Autorizar solicitud";
            text = "¿Esta seguro que desea Autorizar la solicitud de incapacidad?";
            html = "";
        } else {
            titulo = "Rechazar solicitud";
            text = "¿Esta seguro que desea rechazar la solicitud de incapacidad?";
            html = '<textarea id="txtObservaciones" placeholder="Escribe aquí la justificacion de rechazo" ' +
                'class="swal2-textarea" style="display: flex;" style="resize: none;"></textarea>';
        }
        Swal.fire({
            title: titulo,
            text: text,
            type: 'question',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
            html: html
        }).then((result) => {
            if (result.value)
                ajax_revisarIncapacidad(reporteID, accion, $("#txtObservaciones").val(), $(this));
        })
    });

    function ajax_revisarIncapacidad(reporteID, accion, observaciones, button) {
        button.html('<i class="fas fa-spinner fa-pulse"></i>&nbsp; Revisando...');
        $.ajax({
            url: BASE_URL + 'Incidencias/ajax_revisarIncapacidades',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: { reporteID: reporteID, accion: accion, observaciones: observaciones }
        }).done(function (data) {
            if (data.code === 1) {
                tblSalidas.ajax.reload();
                Swal.fire({
                    type: 'success',
                    title: 'Reporte revisado!',
                    text: 'El reporte de horas extra se reviso correctamente.',
                    showConfirmButton: false,
                    timer: 2000
                })
            } else {
                showNotification("error", "Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.", "top");
            }
        }).fail(function (data) {
            showNotification("error", "Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.", "top");
        }).always(function (e) {
        });
    }
})(jQuery);