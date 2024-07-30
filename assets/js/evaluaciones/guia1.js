$(document).ready(function (e) {
    var FechaInicio = $("#FechaInicio").val();
    var FechaFin = $("#FechaFin").val();
    var SucursalID = $("#SucursalID").val();

    if(FechaFin && FechaInicio && SucursalID){
        var tblEvaluados = $("#tblEvaluados").DataTable({
        destroy: true,
        lengthMenu: [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "Todos"]],
        fixedHeader: true,
        //scrollY: "200px",
        scrollCollapse: true,
        scrollX: true,
        paging: true,
        ajax: {
            url: BASE_URL + "Evaluaciones/ajaxGetEvaluadosG1/"+FechaInicio+"/"+FechaFin+"/"+SucursalID,
            dataType: "json",
            type: "POST",
            "processing": true,
            "serverSide": true
        },
        columns: [
            {"data": "num"},
            {"data": "col_Nombre"},
            {"data": "valoracion"},
        ],
        columnDefs: [
            {targets: 0, className: 'text-center'},
            {targets: 1, className: 'text-center'},
            {targets: 2, className: 'text-center'},
        ],
        responsive: true,
        stateSave: false,
        //dom: 'Blfrtip',
        dom: '<"row"<"col-md-6"l><"col-md-6 text-center"f><"col-md-9 cls-export-buttons"B>>rtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Colaboradores evaluados Guia I',
                text: '<i class="fa fa-file-excel-o"></i>&nbsp;Excel',
                titleAttr: "Exportar a excel",
                className: "btn btn-ligth",
                autoFilter: true,
                exportOptions: {
                    columns: ':visible'
                },
            },
            {
                extend: 'pdfHtml5',
                title: 'Colaboradores evaluados Guia I',
                text: '<i class="fa fa-file-pdf-o"></i>&nbsp;PDF',
                titleAttr: "Exportar a PDF",
                className: "btn btn-ligth",
                orientation: 'landscape',
                pageSize: 'LETTER',
                exportOptions: {
                    columns: [0, ':visible']
                }
            },
            {
                extend: 'colvis',
                text: 'Columnas',
                className: "btn l-slategray",
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
        "order": [[0, "asc"]],
        "processing": false
        });
    }
    $("#date-range").datepicker({
        daysOfWeekDisabled:[0],
        format: "yyyy-mm-dd",
        toggleActive: !0,
        todayHighlight: true,
        autoclose: true,
    }).on('changeDate', function (e) {
        $("#fFin").focus();
    });

    //Enviar el id del cliente
    $('#btn').click(function(e){
        fInicio = $("#fInicio").val();
        fFin = $("#fFin").val();
        sucursal = $("#sucursal").val();
        window.open(BASE_URL + "Evaluaciones/resultadosGuiaI/" + fInicio+"/"+fFin+"/"+sucursal, "_self");
    });
});