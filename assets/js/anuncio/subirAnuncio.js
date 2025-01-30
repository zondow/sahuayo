$(document).ready(function (e) {

    var tblPoliticas = $("#tblGestion").DataTable({
        destroy: true,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        ajax: {
            url: BASE_URL + "Comunicados/ajax_getAnuncio",
            dataType: "json",
            type: "POST",
            "processing": true,
        },
        columns: [
            { "data": "anu_Titulo" },
            { "data": "anu_FechaRegistro" },
            { "data": "estatus", render: function (data, type, row) { return estado(data, type, row) } },
            { "data": "acciones", render: function (data, type, row) { return acciones(data, type, row) } },
        ],
        columnDefs: [
            { targets: 0, className: 'text-center' },
        ],
        dom: '<"row"<"col-md-6"l><"col-md-6 text-center"f><"col-md-6 cls-export-buttons"B>>rtip',
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
        "order": [[2, "desc"]],
        "processing": true,

    });

    function acciones(data, type, row) {
        let button = '';
        if (row['archivo']) {
            button += '<button onclick="window.open(\'' + row['archivo'] + '\', \'_blank\')" class="btn btn-info btn-icon btn-icon-mini btn-round hidden-sm-down" title="Ver anuncio" style="color:#FFFFFF"><i class="zmdi zmdi-eye"></i></button>';
        }
        button += ' <button href="' + BASE_URL + 'Comunicados/borrarAnuncio/' + row['anu_AnuncioID'] + '" class="btn btn-danger btn-icon btn-icon-mini btn-round hidden-sm-down " title="Borrar" style="color:#FFFFFF"><i class="zmdi zmdi-delete"></i> </button>';
        return button;
    }

    function estado(data, type, row) {
        return row['anu_Estatus'] == 1
            ? '<span class="badge badge-info btnActivo" data-href="' + BASE_URL + 'Comunicados/estatusAnuncio/0/' + row['anu_AnuncioID'] + '" title="Click para cambiar estatus">Activo</span>'
            : '<span class="badge badge-default btnInactivo" data-href="' + BASE_URL + 'Comunicados/estatusAnuncio/1/' + row['anu_AnuncioID'] + '" title="Click para cambiar estatus">Inactivo</span>';
    }

    // Código jQuery para capturar el clic y redirigir
    $(document).on('click', '.btnActivo, .btnInactivo', function () {
        const href = $(this).data('href');
        window.location.href = href;
    });


    $("body").on("click", ".btnModalGaleria", function (e) {
        e.preventDefault();
        $("#form")[0].reset();
        $("#modalGaleria").modal("show");
    });

    $("body").on("click", ".btnEditGaleria", function (e) {
        e.preventDefault();
        $("#formEdit")[0].reset();

        $("#gal_Galeria").val($(this).data('id'));
        $("#gal_NombreE").val($(this).data('nombre'));
        $("#modalEditGaleria").modal("show");
    });

});