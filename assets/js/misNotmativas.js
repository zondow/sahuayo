$(document).ready(function (e) {

    var tblNormativas = $("#datatableNormativas").DataTable({
        destroy: true,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        ajax: {
            url: BASE_URL + "Usuario/ajax_getNormativas",
            dataType: "json",
            type: "POST",
            "processing": true,
        },
        columns: [
            { "data": "no" },
            { "data": "nombre" },
            { "data": "documento" },
            {
                "data": "acciones", render: function (data, type, row) {
                    return acciones(data, type, row)
                }
            },
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
        "order": [[1, "asc"]],
        "processing": true,

    });

    function acciones(data, type, row) {
        let button = '';
        button += ' <button class="btn btn-secondary btn-icon btn-icon-mini btn-round hidden-sm-down cambiosPolitica" title="Historial de cambios" data-id="' + row['id'] + '" style="color:#FFFFFF"><i class=" fas fa-history"></i> </button><br>';
        if (row['enterado'] == 0)
            button += ' <button class="btn btn-success btn-icon btn-icon-mini btn-round hidden-sm-down enteradoPolitica" title="Marcar como enterado" data-id="' + row['idNoti'] + '" style="color:#FFFFFF"><i class="zmdi zmdi-check"></i> </button>';
        return button;
    }


    $("body").on("click", ".enteradoPolitica", function (e) {
        var politicaID = $(this).data("id");
        let fd = { "politicaID": politicaID };
        Swal.fire({
            title: '',
            text: '¿Esta seguro que desea marcar como enterado?',
            icon: "question",
            showCancelButton: true,
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.value)
                ajaxEnteradoComunicado(fd);
        })
    });

    function ajaxEnteradoComunicado(fd) {
        $.ajax({
            url: BASE_URL + "Usuario/ajaxEnteradoPolitica",
            cache: false,
            type: 'post',
            dataType: 'json',
            data: fd
        }).done(function (data) {
            if (data.code === 1) {
                tblNormativas.ajax.reload();
                $.toast({
                    text: 'La normativa se marco como enterado.',
                    icon: "success",
                    loader: true,
                    loaderBg: '#c6c372',
                    position: 'top-right',
                    allowToastClose: true,
                });
            } else {
                $.toast({
                    text: "¡Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.!",
                    icon: "error",
                    loader: false,
                    position: 'top-right',
                    allowToastClose: false
                });
            }

        }).fail(function (data) {
            $.toast({
                text: "¡Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.!",
                icon: "error",
                loader: false,
                position: 'top-right',
                allowToastClose: false
            });
        }).always(function (e) {

        });//ajax
    }

    //Marcar politica como visto
    $("body").on("click", ".vistoPolitica", function (e) {
        //evt.preventDefault();

        var politicaID = $(this).data("id");
        let fd = { "politicaID": politicaID };
        $.ajax({
            url: BASE_URL + "Usuario/ajaxVistoPolitica",
            cache: false,
            type: "POST",
            dataType: 'json',
            data: fd,
        }).done(function (data) {
            if (data.code === 1) {
                console.log('La normativa se marco como enterado.');
            } else {
                console.log('Normativa ya marcada')
            }
        }).fail(function (data) {
            $.toast({
                text: "¡Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo!",
                icon: "error",
                loader: false,
                position: 'top-right',
                allowToastClose: false
            });
        })
    });//Marcar politica como visto

    let modalCambios = $("#modalCambios");
    $('body').on('click', '.cambiosPolitica', function (e) {
        e.preventDefault();
        let politicaID = $(this).data('id');
        getCambiosPolitca(politicaID);
        modalCambios.modal("show");
    });

    function getCambiosPolitca(politicaID) {
        $.ajax({
            url: BASE_URL + "Comunicados/ajax_getCombiosPolitica",
            type: "POST",
            data: "politicaID=" + politicaID,
            dataType: "json"
        }).done(function (data) {
            if (data.response === "success") {
                $('#divCambios').html(data.info.pol_Cambios);
                if (data.info.pol_Cambios !== null) {
                    $('#divCambios').html(data.info.pol_Cambios);
                } else {
                    $('#divCambios').html('<div class="col-md-12 alert l-slategray text-center" style="border-radius:50px">No hay actualización del la normativa.</div>');
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

    //Mostrar reporte en ventana modal
    $('body').on('click', '.show-pdf', function (evt) {
        evt.preventDefault();
        //Mostrar la modal
        var $this = $(this);
        var href = $this.attr("href");
        var title = $this.attr("data-title");
        $("#modalPdf").modal("show");
        $("#modalTitlePdf").text(title);
        $("#iframePdf").attr("src", href);
    });//.show-pdf
});