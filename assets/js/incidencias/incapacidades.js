$(document).ready(function (e) {
    $(".select2-single").select2({
        language: "es",
        selectOnClose: true
    });

    $(".datepicker").datepicker({
        daysOfWeekDisabled: [0],
        todayHighlight: !0,
        autoclose: !0,
        format: "yyyy-mm-dd",
        daysOfWeek: ["D", "L", "M", "M", "J", "V", "S"],
        monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
    });

    // Plugin file para logo
    $(".input-filestyle").filestyle('placeholder', 'Seleccione un archivo (.pdf , .png , .jpg , .jpeg)');

    $("#datatableIncapacidades").DataTable({
        responsive: true,
        stateSave: false,
        //dom: 'Blfrtip',
        dom: '<"row"<"col-md-4"l><"col-md-4 text-center"f><"col-md-4 cls-export-buttons"B>>rtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Incapacidades',
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
                title: 'Incapacidades',
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
        "order": [[1, "asc"]],
        "processing": false
    });
    $("body").on("click", ".borrarIncapacidad", function (e) {
        var incapacidadID = $(this).data("id");
        txt = '¿Estás seguro que deseas eliminar la incapacidad?';

        let fd = { "incapacidadID": incapacidadID };
        Swal.fire({
            title: '',
            text: txt,
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.value)
                ajaxCambiarEstado(fd);
        })
    });
    function ajaxCambiarEstado(fd) {
        $.ajax({
            url: BASE_URL + "Incidencias/ajax_eliminarIncapacidad",
            cache: false,
            type: 'post',
            dataType: 'json',
            data: fd
        }).done(function (data) {
            if (data.code === 1) {
                $.toast({
                    text: 'La incapacidad de elimino correctamente.',
                    icon: "success",
                    loader: true,
                    loaderBg: '#c6c372',
                    position: 'top-right',
                    allowToastClose: true,
                });
                setTimeout(function () {
                    window.location.reload();
                }, 1200);
            }
            else {
                $.toast({ text: "¡Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.!", icon: "error", loader: false, position: 'top-right', allowToastClose: false });
            }

        }).fail(function (data) {
            $.toast({ text: "¡Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.!", icon: "error", loader: false, position: 'top-right', allowToastClose: false });
        }).always(function (e) {

        });//ajax
    }
});