$(document).ready(function () {
    var tblTickets =  $("#tblTickets").DataTable({
        destroy: true,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        fixedHeader: true,
        //scrollY: "200px",
        scrollCollapse: true,
        scrollX:        true,
        paging:         true,
        ajax: {
            url: BASE_URL + "MesaAyuda/ajax_TicketsVencidosAgenteTabla/"+$("#empID").val(),
            dataSrc: '',
        },
        columns: [
            { "data": "acciones", render: function(data,type,row){return acciones(data,type,row)} },
            { "data": "tipo",render: function(data,type,row){return tipo(data,type,row)}},
            { "data": "tic_FechaHoraRegistro"},
            { "data": "numero"},
            { "data": "cooperativa"},
            { "data": "prioridad",render: function(data,type,row){return prioridad(data,type,row)} },
            { "data": "estatus",render: function(data,type,row){return estado(data,type,row)} },
            { "data": "fechaTerminoP"},
        ],
        responsive:true,
        stateSave:false,
        dom:'<"row"<"col-md-4"l><"col-md-4 text-center"f><"col-md-4 cls-export-buttons"B>>rtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Tickets',
                text: '<i class="fa fa-file-excel-o"></i>&nbsp;Excel',
                titleAttr: "Exportar a excel",
                className: "btn btn-warning",
                autoFilter: true,
                exportOptions: {
                    columns: ':visible'
                },
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
            infoFiltered:"(filtrado de _MAX_ registros)"
        },
        "order": [[ 3, "desc" ]],
        "processing":true
    });


    function acciones(data,type,row){
        let output = '';
        let id = row.tic_TicketID;
        output += '<a class="btn btn-info" href="'+BASE_URL+'MesaAyuda/ticket/'+id+'/1"><b class=" mdi mdi-information-variant"></b></a>';
        return output;
    }//acciones

    function prioridad(data,type,row){
        var html = data;
        switch (data){
            case 'BAJA' :html = '<span class="badge badge-success p-1">Baja</span>';break;
            case 'MEDIA' :html = '<span class="badge badge-info p-1">Media</span>';break;
            case 'ALTA' :html = '<span class="badge badge-warning p-1">Alta</span>';break;
            case 'URGENTE' :html = '<span class="badge badge-danger p-1">Urgente</span>';break;
        }//switch
        return html;
    }

    function estado(data,type,row){
        var html = data;
        switch (data){
            case 'ABIERTO' :html = '<span class="badge badge-light p-1">Abierto</span><br>';break;
            case 'ESPERA_SOLICITANTE' :html = '<span class="badge badge-light p-1">Espera de respuesta del solicitante</span><br>';break;
            case 'ESPERA_PROVEEDOR' :html = '<span class="badge badge-light p-1">Espera de respuesta del proveedor</span><br>';break;
            case 'RESUELTO' :html = '<span class="badge badge-light p-1">Resuelto</span><br>';break;
            case 'CERRADO' :html = '<span class="badge badge-light p-1">Cerrado</span><br>';break;
        }//switch
        return html;
    }

    function tipo(data,type,row){
        var html = data;
        switch (data){
            case 'normal' :html = '<span class="badge badge-dark p-1">Normal</span><br>';break;
            case 'generico' :html = '<span class="badge badge-light p-1">Genérico</span><br>';break;
        }//switch
        return html;
    }
});

