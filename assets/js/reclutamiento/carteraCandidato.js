$(document).ready(function (e) {

    $("#tblCartera").DataTable({
        destroy: true,
        lengthMenu: [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "Todos"]],
        fixedHeader: true,
        //scrollY: "200px",
        scrollCollapse: true,
        scrollX: true,
        paging: true,
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
                title: 'Cartera de candidatos',
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
                title: 'Cartera de candidatos',
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
        "order": [[4, "asc"]],
        "processing": false
    });

    $("body").on("click", ".observacionesBtn", function (e) {
        e.preventDefault();
        candidatoID = $(this).data('id');
        document.getElementById('candidatoIDInput').value = candidatoID;
        getRegistroObservaciones(candidatoID);
        $("#modalCambios").modal("show");
    });

    function getRegistroObservaciones(candidatoID) {
        $.ajax({
            url: BASE_URL + "Reclutamiento/ajax_getRegistroObservaciones",
            type: "POST",
            data: "candidatoID=" + candidatoID,
            dataType: "json"
        }).done(function (data) {
            if (data.response === "success") {
                $('#can_Observacion').summernote('disable');
                $('#candidatoID').val(data.info.candidatoID);
                if (data.info.can_Observacion !== "") {
                    $('#can_Observacion').summernote('code', data.info.can_Observacion);
                } else {
                    $('#can_Observacion').summernote();
                }
            }
        }).fail(function () {
            $.toast({
                text: "Ocurrido un error, por favor intente nuevamente.",
                icon: "error",
                loader: true,
                loaderBg: '#c6c372',
                position: 'top-right',
                allowToastClose: true,
            });
        });
    }

    $("body").on("click", ".cambioSolicitudBtn", function (e) {
        e.preventDefault();
        candidatoID = $(this).data('id');
        document.getElementById('candidatoIDInput').value = candidatoID;
        getSolicitudes(candidatoID);
        $("#modalNuevaSolicitud").modal("show");
    });

    function getSolicitudes(candidatoID) {
        $.ajax({
            url: BASE_URL + "Reclutamiento/ajax_getRegistroObservaciones",
            type: "POST",
            data: "candidatoID=" + candidatoID,
            dataType: "json"
        }).done(function (data) {
            if (data.response === "success") {
                $('#can_Observacion').summernote('disable');
                $('#candidatoID').val(data.info.candidatoID);
                if (data.info.can_Observacion !== "") {
                    $('#can_Observacion').summernote('code', data.info.can_Observacion);
                } else {
                    $('#can_Observacion').summernote();
                }
            }
        }).fail(function () {
            $.toast({
                text: "Ocurrido un error, por favor intente nuevamente.",
                icon: "error",
                loader: true,
                loaderBg: '#c6c372',
                position: 'top-right',
                allowToastClose: true,
            });
        });
    }

    $('#can_Observacion').summernote({
        //placeholder: 'Hello bootstrap 4',
        toolbar: false,
        tabsize: 2,
        height: 400,
        lang: 'es-ES' // default: 'en-US'
    });

    $('#selectSolicitudID').select2({
        minimumResultsForSearch: Infinity,
        minimumResultsForSearch: '',
        language: {

            noResults: function () {

                return "No hay resultado";
            },
            searching: function () {

                return "Buscando..";
            }
        }
    });
});
