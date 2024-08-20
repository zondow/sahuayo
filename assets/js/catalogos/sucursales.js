$(document).ready(function () {
   
    $("body").on("click",".btnAddSucursal",function (e) {
        e.preventDefault();
        $("#formSucursal")[0].reset();
        $("#suc_SucursalID").val(0);
        $("#myModalLabel").html('Nueva Sucursal');
        $("#modalSucursal").modal("show");
    });

    $('body').on('click', '.editarSucursal', function(e) {
        e.preventDefault();
        $("#myModalLabel").html('Editar Sucursal');
        $("#formSucursal")[0].reset();
        let sucursalID = $(this).data('id');
        $.ajax({
            url: BASE_URL + "Catalogos/ajax_getInfoSucursal/"+sucursalID ,
            type: "POST",
            async:true,
            cache:false,
            dataType: "json"
        }).done(function (data){
            if(data.response === "success"){
                $("#suc_SucursalID").val(data.result.suc_SucursalID);
                $("#suc_Sucursal").val(data.result.suc_Sucursal);
            }
        }).fail(function () {
            $.toast({
                text: "Ocurrido un error, por favor intente nuevamente.",
                icon: "error",
                loader: true,
                loaderBg: '#c6c372',
                position: 'top-right',
                allowToastClose : true,
            });
        });

        $("#modalSucursal").modal("show");
    });


    $("body").on("click",".activarInactivar",function (e) {
        var sucursalID = $(this).data("id");
        var estado = $(this).data("estado");

        if(estado === 0){
            txt='¿Estás seguro que deseas inactivar la sucursal seleccionada?';
            est=0;
        } else {
            txt='¿Estás seguro que deseas activar la sucursal seleccionada?';
            est=1;
        }

        let fd  = {"sucursalID":sucursalID,"estado":est};
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
            url: BASE_URL + "Catalogos/ajaxCambiarEstadoSucursal",
            cache: false,
            type: 'post',
            dataType: 'json',
            data:fd
        }).done(function (data) {
            if(data.code === 1) {
                $.toast({
                    text:'Se cambio el estado de la sucursal seleccionada.',
                    icon: "success",
                    loader: true,
                    loaderBg: '#c6c372',
                    position: 'top-right',
                    allowToastClose : true,
                });
                setTimeout(function () {
                    window.location.reload();
                }, 1300);
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

