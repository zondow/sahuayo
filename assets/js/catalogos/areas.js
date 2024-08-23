$(document).ready(function(e) {
 
    var form = $("#formArea");
    var nombre = $("#nombre");
    var modal = $("#modalArea");
    var btnGuardar= $("#guardar");

    var tblAreas = $("#tblAreas").DataTable({
        destroy: true,
        lengthMenu: [[10, 25, 50, 100, 500, -1], [10, 25, 50, 100, 500, "Todos"]],
        fixedHeader: true,
        scrollX: true,
        paging: true,
        responsive: true,
        stateSave: false,
        dom: '<"row"<"col-md-4"l><"col-md-4 text-center"f><"col-md-4 cls-export-buttons"B>>rtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Catalogo de Areas',
                text: '<i class="zmdi zmdi-collection-text"></i>&nbsp;Excel',
                titleAttr: "Exportar a excel",
                className: "btn l-slategray",
                autoFilter: true,
                exportOptions: {
                    columns: ':visible'
                },
            },
            {
                extend: 'pdfHtml5',
                title: 'Catalogo de Areas',
                text: '<i class="zmdi zmdi-collection-pdf"></i>&nbsp;PDF',
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
                className: "btn l-slategray",
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




    $("body").on("click","#addArea",function (e) {
        e.preventDefault();
        form[0].reset();
        $("#titleModal").html('Nueva area');
        $("#id").val(0);
        modal.modal("show");
    });

    $("body").on("click",".editarArea",function (e) {
        e.preventDefault();
        form[0].reset();
        $("#titleModal").html('Editar area');
        let areaID = $(this).data('id');
        $("#id").val(areaID);
        getInfoArea(areaID);
        modal.modal("show");
    });

    btnGuardar.click(function (e){
        e.preventDefault();
        e.stopImmediatePropagation();

        if(nombre.val() !== "") {

            $.ajax({
                url: BASE_URL + "Catalogos/ajaxSaveArea",
                type: "post",
                dataType: "json",
                data:form.serialize()
            }).done(function (data) {
                if (data.code === 1) {
                    
                    modal.modal('toggle');

                    $.toast({
                        text: "El area se guardo correctamente.",
                        icon: "success",
                        loader: true,
                        loaderBg: '#c6c372',
                        position: 'top-right',
                        allowToastClose: true,
                    });
                    setTimeout(function () {
                        window.location.reload();
                    }, 1200);
                }else if (data.code === 2) {
                    
                    modal.modal('toggle');

                    $.toast({
                        text: "La información se actualizo correctamente.",
                        icon: "success",
                        loader: true,
                        loaderBg: '#c6c372',
                        position: 'top-right',
                        allowToastClose: true,
                    });
                    setTimeout(function () {
                        window.location.reload();
                    }, 1200);
                }else{
                    $.toast({
                        text: "Ocurrio un problema al tartar de guardar, por favor intente nuevamente.",
                        icon: "error",
                        loader: true,
                        loaderBg: '#c6c372',
                        position: 'top-right',
                        allowToastClose: true,
                    });
                }
            }).fail(function () {
                $.toast({
                    text: "Ocurrido un error, por favor intente mas tarde.",
                    icon: "error",
                    loader: true,
                    loaderBg: '#c6c372',
                    position: 'top-right',
                    allowToastClose: true,
                });
            });
        }else{
            $.toast({
                text: "Por favor llene los campos requeridos.",
                icon: "warning",
                loader: true,
                loaderBg: '#c6c372',
                position: 'top-right',
                allowToastClose: true,
            });
        }
    });

    function getInfoArea(areaID){

        $.ajax({
            url: BASE_URL + "Catalogos/ajaxGetInfoArea" ,
            type: "POST",
            dataType: "json",
            data:'areaID='+areaID
        }).done(function (data){
            if(data.code === 1){
                $("#id").val(areaID);
                $("#nombre").val(data.result.are_Nombre);
            }else{
                $.toast({
                    text: "Ocurrido un problema al consultar la información, por favor intente nuevamente.",
                    icon: "error",
                    loader: true,
                    loaderBg: '#c6c372',
                    position: 'top-right',
                    allowToastClose : true,
                });
            }
        }).fail(function () {
            $.toast({
                text: "Ocurrio un error, por favor intente mas tarde.",
                icon: "error",
                loader: true,
                loaderBg: '#c6c372',
                position: 'top-right',
                allowToastClose : true,
            });
        });
    }

    $("body").on("click",".activarInactivar",function (e) {
        var areaID = $(this).data("id");
        var estado = $(this).data("estado");

        if(estado===1){
            txt='¿Estás seguro que deseas inactivar el area seleccionada?';
            est=0;
        } else if(estado===0){
            txt='¿Estás seguro que deseas activar el area seleccionada?';
            est=1;
        }

        let fd  = {"areaID":areaID,"estado":est};
        Swal.fire({
            title: '',
            text: txt,
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if(result.value)
                ajaxCambiarEstado(fd);
        })
    });

    function ajaxCambiarEstado(fd){
        $.ajax({
            url: BASE_URL + "Catalogos/ajaxCambiarEstadoArea",
            cache: false,
            type: 'post',
            dataType: 'json',
            data:fd
        }).done(function (data) {
            if(data.code === 1) {
               getAreas();
                $.toast({
                    text:'Se cambio el estado del area seleccionada.',
                    icon: "success",
                    loader: true,
                    loaderBg: '#c6c372',
                    position: 'top-right',
                    allowToastClose : true,
                });
            }
            else {
                $.toast({text: "¡Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.!", icon: "error", loader: false, position: 'top-right',allowToastClose : false});
            }

        }).fail(function (data) {
            $.toast({text: "¡Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.!", icon: "error", loader: false, position: 'top-right',allowToastClose : false});
        }).always(function (e) {

        });//ajax
    }
});

