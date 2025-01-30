$(document).ready(function (e) {
    var tblEmpleados = $("#tblEmpleadosBaja").DataTable({
        destroy: true,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        ajax: {
            url: BASE_URL + "Personal/ajax_getEmpleadosBaja",
            dataType: "json",
            type: "POST",
            "processing": true,
            "serverSide": true
        },
        columns: [
            { "data": "numero" },
            { "data": "emp_Numero" },
            { "data": "emp_Nombre" },
            { "data": "acciones", render: function (data, type, row) { return acciones(data, type, row) } },
            { "data": "baj_FechaBaja" },
            { "data": "baj_MotivoBaja" },
            { "data": "pue_Nombre" },
            { "data": "dep_Nombre" },
            { "data": "suc_Sucursal" },
            { "data": "emp_Rfc" },
            { "data": "emp_Curp" },
            { "data": "emp_Nss" },
            { "data": "emp_Correo" },
            { "data": "emp_Direccion" },
            { "data": "emp_EstadoCivil" },
            { "data": "emp_FechaIngreso" },
            { "data": "emp_FechaNacimiento" },
            { "data": "emp_Telefono" },
            { "data": "emp_Celular" },
            { "data": "emp_Sexo" },
            { "data": "emp_SalarioMensual" },
            { "data": "emp_SalarioMensualIntegrado" },
            { "data": "emp_CodigoPostal" },
            { "data": "emp_Municipio" },
            { "data": "emp_EntidadFederativa" },
            { "data": "emp_Pais" },
            { "data": "emp_EstatusContratacion" },
            { "data": "emp_TipoPrestaciones" },
            { "data": "emp_NombreEmergencia" },
            { "data": "emp_NumeroEmergencia" },
            { "data": "emp_Parentesco" },

        ],
        columnDefs: [
            { targets: 1, className: 'text-center' },
        ],
        dom: '<"row"<"col-md-4"l><"col-md-4 text-center"f><"col-md-4 cls-export-buttons"B>>rtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Bajas del personal',
                text: '<i class="zmdi zmdi-collection-text"></i>&nbsp;Excel',
                titleAttr: "Exportar a excel",
                className: "btn l-slategray btn-round",
                autoFilter: true,
                exportOptions: {
                    columns: [0, ':visible'],
                },
            },
            {
                extend: 'colvis',
                text: 'Columnas',
                className: "btn l-slategray btn-round",
            }
        ],
        responsive: true,
        stateSave: false,
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
        "processing": true,
        /*drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
        }*/
    });

    function acciones(data, type, row) {
        let button = '';
        button += '<div class="header">' +
            '<ul class="header-dropdown">' +
            '<li class="dropdown">' +
            '<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">' +
            '<i class="zmdi zmdi-more"></i>' +
            '</a>' +
            '<ul class="dropdown-menu dropdown-menu-right">';

        button += '<li><a class="fechaSalida" data-id="' + row['baj_BajaEmpleadoID'] + '" href="#">Fecha de salida</a></li>';

        if (row['entrevista_realizada'] !== null) {
            button += '<li><a href="' + BASE_URL+'PDF/imprimirEntrevistaSalida/' + row['entrevista_realizada']['ent_EntrevistaSalidaID'] + '" target="_blank">Imprimir entrevista</a></li>';
        } else {
            button += '<li><a href="' + BASE_URL+'Personal/entrevistaSalida/' + row['baj_BajaEmpleadoID'] + '">Realizar entrevista</a></li>';
        }

        button += '<li><a href="' + BASE_URL+'PDF/imprimirHojaLiberacion/' + row['baj_BajaEmpleadoID']+ '" target="_blank">Hoja de liberación</a></li>';
        button += '<li><a href="' + BASE_URL+'Personal/offboarding/' + row['baj_BajaEmpleadoID'] + '" target="_blank">Offboarding (salida)</a></li>';
        button += '</ul></li></ul></div>';

        return button;
    }


});

let colaboradorID;
$('body').on('click', '.fechaSalida', function (e) {
    e.preventDefault();
    $('#tituloModal').html('Editar');
    colaboradorID = $(this).data('id');
    $("#modalFechaSalida").modal("show");
});

$(".datepicker").datepicker({
    daysOfWeekDisabled: [0],
    autoclose: !0,
    format: "yyyy-mm-dd",
    daysOfWeek: ["D", "L", "M", "M", "J", "V", "S"],
    monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
    //todayHighlight:!0
});

$('body').on('click', '.bntGuardarFecha', function (evt) {
    evt.preventDefault();
    // Agregar el id al formulario para unirlo ala data del formulario
    $('#formColaborador').append('<input type="hidden" name="colaboradorID" value="' + colaboradorID + '">');
    var formData = $('#formColaborador');
    $.ajax({
        url: BASE_URL + "Personal/ajax_saveFechaBaja",
        type: "POST",
        data: formData.serialize(),
        dataType: "json"
    }).done(function (data) {
        //location.reload()
        if (data.code === 0) {
            $.toast({
                text: data.msg,
                icon: "error",
                loader: true,
                loaderBg: '#c6c372',
                position: 'top-right',
                allowToastClose: true,
            });
        } else if (data.code === 1) {
            $("#modalFechaSalida").modal('toggle');
            $.toast({
                text: data.msg,
                icon: "success",
                loader: true,
                loaderBg: '#c6c372',
                position: 'top-right',
                allowToastClose: true,
            });
            setTimeout(function (e) {
                location.reload();
            }, 1200);
        } else {
            $.toast({
                text: "Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.",
                icon: "error",
                loader: true,
                loaderBg: '#c6c372',
                position: 'top-right',
                allowToastClose: true,
            });
        }
    }).fail(function (data) {
        $.toast({
            text: "Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.",
            icon: "error",
            loader: true,
            loaderBg: '#c6c372',
            position: 'top-right',
            allowToastClose: true,
        });
    }).always(function (e) { });//ajax
});