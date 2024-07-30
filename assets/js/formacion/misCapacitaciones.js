$(document).ready(function(e) {


    $(".dtMisCapacitaciones").DataTable({
        dom:'<"row"<"col-md-4"l><"col-md-4 text-center"f><"col-md-4 cls-export-buttons"B>>rtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Capacitaciones',
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
                title: 'Capacitaciones',
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
        language:
            {
                paginate: {
                    previous:"<i class='zmdi zmdi-caret-left'>",
                    next:"<i class='zmdi zmdi-caret-right'>"
                },
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla.",
                "sInfo":           "",
                "sInfoEmpty":      "",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sPrevious":     "<i class='mdi mdi-chevron-left'>",
                    "sNext": "<i class='mdi mdi-chevron-right'>"
                },
            },
        drawCallback:function(){
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded")}
    });


});