$(document).ready(function (e) {
    var btnUpdate = $("#btnUpdate");
    var modalEditCatalogoPermiso = $("#modalEditCatalogoPermiso");

    var tblConfigPermisos = $("#tblConfigPermisos").DataTable({
        destroy: true,
        lengthMenu: [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "Todos"]],
        fixedHeader: true,
        //scrollY: "200px",
        scrollCollapse: true,
        scrollX: true,
        paging: true,
        ajax: {
            url: BASE_URL + "Configuracion/ajax_getConfiguracionPermisos",
            dataType: "json",
            type: "POST",
            "processing": true,
            "serverSide": true
        },
        columns: [
            { "data": "cat_Nombre" },
            { "data": "cat_Dias" },
            { "data": "cat_Estatus", render: function (data, type, row) { return estatus(data, type, row) } },
            { "data": "cat_CatalogoPermisoID", render: function (data, type, row) { return acciones(data, type, row) } },

        ],
        columnDefs: [
            { targets: 2, className: 'text-center' },
            { targets: 3, className: 'text-center' },
        ],
        responsive: true,
        stateSave: false,
        //dom: 'Blfrtip',
        dom: '<"row"<"col-md-4"l><"col-md-4 text-center"f><"col-md-4 cls-export-buttons"B>>rtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Configuración de permisos',
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
                title: 'Configuración de permisos',
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
        "order": [[0, "asc"]],
        "processing": false
    });

    $('body').on('click', '.btnEditar', function (e) {
        var id = $(this).data("catalogo");
        ajax_getTipoPermiso(id);
    });

    btnUpdate.click(function (e) {
        var catalogoID = $(this).data("catalogo");
        var dias = $("#txtDias").val();
        var estatus = $("#txtEstatus").val();

        if (dias >= 0) {
            if (estatus != "") {
                var fd = new FormData();
                fd.append("id", catalogoID);
                fd.append("dias", dias);
                ajax_updateTipoPermiso(fd);
            }
            else
                showNotification("error", "¡Selecciona el estatus!");
        }
        else
            showNotification("error", "¡Ingresa el número de días otorgados!");
    });

    /*******************FUNCTIONS***************/
    function estatus(data, type, row) {
        return row['cat_Estatus'] == 1 ?
            '<span class="badge badge-info" >Activo</span>' :
            '<span class="badge badge-default" >Inactivo</span>';
    }//estatusHorario

    function acciones(data, type, row) {
        let output = '';
        if (revisarPermisos('Editar', 'configuracionPermisos')){
            output += '<button type="button" data-catalogo="' + row['cat_CatalogoPermisoID'] + '" class="btn btn-info btn-icon btn-icon-mini btn-round hidden-sm-down btnEditar"><i class="zmdi zmdi-edit" title="Editar"></i></button>';
        }
        estatus_btn = row['cat_Estatus'] == 1 ? 'Inactivo' : 'Activo';
        output +='<a role="button" class="btn btn-icon  btn-icon-mini btn-round btn-primary activarInactivar" data-id="' + row['cat_CatalogoPermisoID'] + '"  data-estado="' + row['cat_Estatus'] + '" title="Da clic para cambiar a '+estatus_btn+'" href="#"><i class="zmdi zmdi-check-circle pt-2"></i></a>';
        return output;
    }//accionesHorario



    $("body").on("click", ".activarInactivar", function (e) {
        var permiso = $(this).data("id");
        var estado = $(this).data("estado");

        if (estado === 1) {
            txt = '¿Estás seguro que deseas inactivar el registro seleccionado?';
            est = 0;
        } else if (estado === 0) {
            txt = '¿Estás seguro que deseas activar el registro seleccionado?';
            est = 1;
        }

        let fd = { "permisoID": permiso, "estado": est };
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
            url: BASE_URL + "Configuracion/ajaxCambiarEstadoPermiso",
            cache: false,
            type: 'post',
            dataType: 'json',
            data: fd
        }).done(function (data) {
            if (data.code === 1) {
                tblConfigPermisos.ajax.reload();
                $.toast({
                    text: 'Se cambio el estado del resgistro seleccionado.',
                    icon: "success",
                    loader: true,
                    loaderBg: '#c6c372',
                    position: 'top-right',
                    allowToastClose: true,
                });
            }
            else {
                $.toast({ text: "¡Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.!", icon: "error", loader: false, position: 'top-right', allowToastClose: false });
            }

        }).fail(function (data) {
            $.toast({ text: "¡Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.!", icon: "error", loader: false, position: 'top-right', allowToastClose: false });
        }).always(function (e) {

        });//ajax
    }



    function ajax_getTipoPermiso(catalogoID) {
        $.ajax({
            url: BASE_URL + 'Configuracion/ajax_getCatalogoPermisoById',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: { catalogoID: catalogoID }
        }).done(function (data) {
            if (data.code === 1) {
                setInfo(data.catalogo, catalogoID);
                modalEditCatalogoPermiso.modal('show');
            } else {
                showNotification("error", "Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.", "top");
            }//if-else
        }).fail(function (data) {
            showNotification("error", "Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.", "top");
        }).always(function (e) {
        });//ajax
    }//ajax_getTipoPermiso

    function ajax_updateTipoPermiso(fd) {
        $.ajax({
            url: BASE_URL + 'Configuracion/ajax_updateCatalogoPermisos',
            cache: false,
            contentType: false,
            processData: false,
            type: 'post',
            dataType: 'json',
            data: fd
        }).done(function (data) {
            if (data.code === 1) {
                tblConfigPermisos.ajax.reload();
                modalEditCatalogoPermiso.modal('toggle');
                showNotification("success", "¡El tipo de permiso se actualizo exitosamente!", "top");
            } else {
                showNotification("error", "Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.", "top");
            }//if-else
        }).fail(function (data) {
            showNotification("error", "Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.", "top");
        }).always(function (e) {
        });//ajax
    }//ajax_updateTipoPermiso

    function setInfo(info, catalogoID) {
        btnUpdate.data("catalogo", catalogoID);
        $("#txtNombre").val(info.cat_Nombre);
        $("#txtDias").val(info.cat_Dias);
        $("#txtEstatus").val(info.cat_Estatus).trigger('change');
    }//setInfo

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

    $("body").on('keydown', '.numeric', function (e) {
        var key = e.which;
        if ((key >= 48 && key <= 57) ||         //standard digits
            (key >= 96 && key <= 105) ||        //digits (numeric keyboard)
            key === 190 || //.
            key === 110 ||  //. (numeric keyboard)
            key === 8 || //retorno de carro
            key === 37 || // <--
            key === 39 || // -->
            key === 46 || //Supr
            key === 173 || //-
            key === 109 || //- (numeric keyboard)
            key === 9 //Tab
        ) {
            return true;
        }//if
        return false;
    });//.numeric.keyup


});
