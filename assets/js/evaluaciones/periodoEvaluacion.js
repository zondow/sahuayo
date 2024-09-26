$(document).ready(function (e) {

    var modalPeriodo = $("#modalPeriodoEv");
    var form = $("#formPeriodo");
    var tipo = $("#eva_Tipo");
    var fInicio = $("#fInicio");
    var fFin = $("#fFin");
    var btnSave = $("#btnSavePeriodo");


    $("body").on("click", ".modalPeriodoEvaluacion", function (evt) {
        evt.preventDefault();
        $("#formPeriodo")[0].reset();
        modalPeriodo.modal("show");
    });


    btnSave.click(function (e) {
        btnSave.html('<i class="fas fa-spinner fa-pulse"></i>&nbsp; Guardando...');
        if (tipo.val() !== "" && fInicio.val() !== "" && fFin.val() !== "") {

            $.ajax({
                url: BASE_URL + 'Evaluaciones/ajax_savePeriodoEvaluacion',
                type: 'post',
                dataType: 'json',
                data: form.serialize()
            }).done(function (data) {
                btnSave.html('<span class="fa fa-save"></span> Guardar');
                if (data.code === 1) {
                    tblPeriodos.ajax.reload();
                    modalPeriodo.modal('toggle');
                    Swal.fire({
                        icon: 'success',
                        title: data.msg,
                        text: 'El perido de evaluación se registro correctamente y ' +
                            'se notifico a los colaboradores.',
                        showConfirmButton: false,
                        timer: 2000
                    })
                } else if (data.code === 2) {
                    showNotification("warning", data.msg, "top");
                } else {
                    showNotification("error", data.msg, "top");
                }
            }).fail(function (data) {
                showNotification("error", "Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.", "top");
            }).always(function (e) {
            });//ajax

        } else {
            showNotification("error", "Llene los campos requeridos", "top");
        }
    });


    //dar de baja
    $('body').on('click', '.btnEliminarPeriodo', function (e) {
        e.preventDefault();
        var $idDato = $(this).data('id');
        Swal.fire({
            title: '<strong>Eliminar periodo</strong>',
            icon: 'question',
            text: '¿Esta seguro que desea eliminar el periodo de evaluación seleccionado?',
            showCancelButton: true,
            closeOnConfirm: false,
            cancelButtonText: ' Cerrar',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: BASE_URL + "Evaluaciones/ajax_bajaPeriodoEvaluacion",
                    type: "POST",
                    dataType: "json",
                    data: "id=" + $idDato
                }).done(function (data) {
                    if (data.code == 1) {
                        tblPeriodos.ajax.reload();
                        $.toast({
                            text: "El periodo de evaluacion se ha dado de baja.",
                            icon: "success",
                            loader: true,
                            loaderBg: '#c6c372',
                            position: 'top-right',
                            allowToastClose: true,
                        });
                    } else {
                        showNotification("error", "Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.", "top");
                    }
                });
            }
        });

    });


    var tblPeriodos = $("#datatablePeriodo").DataTable({
        destroy: true,
        lengthMenu: [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "Todos"]],
        fixedHeader: true,
        scrollCollapse: true,
        scrollX: true,
        paging: true,
        ajax: {
            url: BASE_URL + "Evaluaciones/ajax_getPeriodos",
            dataType: "json",
            type: "POST",
            "processing": true,
            "serverSide": true
        },
        columns: [
            { "data": "eva_Tipo" },
            { "data": "eva_FechaInicio" },
            { "data": "eva_FechaFin" },
            { "data": "estado" },
            { "data": "eva_EvaluacionID", render: function (data, type, row) { return acciones(data, type, row) } },
        ],
        responsive: true,
        stateSave: false,
        //dom: 'Blfrtip',
        dom: '<"row"<"col-md-4"l><"col-md-4 text-center"f><"col-md-4 cls-export-buttons"B>>rtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Mis vacaciones',
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
                title: 'Mis vacaciones',
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
        "order": [[2, "desc"]],
        "processing": false
    });

    function acciones(data, type, row) {
        let output = '';
        if (revisarPermisos('Baja', 'periodoEvaluacion'))
            if (row['eva_Estatus'] === 1) {
                output += '<button type="button" data-id="' + row['eva_EvaluacionID'] + '"' +
                    'class="btn btn-danger  btn-icon btn-icon-mini btn-round hidden-sm-down btnEliminarPeriodo">' +
                    '<i class="zmdi zmdi-delete"></i></button>';
            }
        return output;
    }


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

    $("#date-range").datepicker({
        daysOfWeekDisabled: [0],
        format: "yyyy-mm-dd",
        toggleActive: !0,
        todayHighlight: true,
        autoclose: true,
    }).on('changeDate', function (e) {
        $("#fechaFin").focus();
    });

});