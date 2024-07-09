$(document).ready(function(e) {
    getCapsulas();

    function getCapsulas() {
        $("#divCapsulas").empty();
        $.ajax({
            url: BASE_URL + "Comunicados/ajaxGetCapsulas",
            type: "POST",
            dataType: "json"
        }).done(function (data) {

            $("#divCapsulas").html(data.capsulas);

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


    var form = $("#formCapsula");
    var titulo = $("#titulo");
    var descripcion = $("#descripcion");
    var modal = $("#modalCapsula");
    var btnGuardar= $("#guardar");

    $('#descripcion').summernote({
        tabsize: 1,
        height: 200,
        lang: 'es-ES' // default: 'en-US'
    });

   
    $("body").on("click","#addCapsula",function (e) {
        e.preventDefault();
        form[0].reset();
        descripcion.summernote("");

        $("#titleModal").html('Nueva cápsula');
        $("#id").val(0);
        modal.modal("show");
    });

    $("body").on("click",".editarCapsula",function (e) {
        e.preventDefault();
        form[0].reset();
        $("#titleModal").html('Editar cápsula');
        let capsulaID = $(this).data('id');
        $("#id").val(capsulaID);
        getInfoCapsula(capsulaID);
        modal.modal("show");
    });

    btnGuardar.click(function (e){
        e.preventDefault();
        e.stopImmediatePropagation();

        if(titulo.val() !== "" && descripcion.val() !== "" ) {

            $.ajax({
                url: BASE_URL + "Comunicados/ajaxSaveCapsula",
                type: "post",
                dataType: "json",
                data:form.serialize()
            }).done(function (data) {
                if (data.code === 1) {
                    getCapsulas();
                    modal.modal('toggle');

                    $.toast({
                        text: "La cooperativa se guardo correctamente.",
                        icon: "success",
                        loader: true,
                        loaderBg: '#c6c372',
                        position: 'top-right',
                        allowToastClose: true,
                    });
                }else if (data.code === 2) {
                    getCapsulas();
                    modal.modal('toggle');

                    $.toast({
                        text: "La información se actualizo correctamente.",
                        icon: "success",
                        loader: true,
                        loaderBg: '#c6c372',
                        position: 'top-right',
                        allowToastClose: true,
                    });
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

    function getInfoCapsula(capsulaID){
    
        $.ajax({
            url: BASE_URL + "Comunicados/ajaxGetInfoCapsula" ,
            type: "POST",
            dataType: "json",
            data:'capsulaID='+capsulaID
        }).done(function (data){
            if(data.code === 1){
                $("#id").val(capsulaID);
                $("#titulo").val(data.result.cap_Titulo);
                $("#descripcion").summernote('code',data.result.cap_Descripcion);
               
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
        var capsulaID = $(this).data("id");
        var estado = $(this).data("estado");

        if(estado===1){
            txt='¿Estás seguro que deseas inactivar la cápsula seleccionada?';
            est=0;
        } else if(estado===0){
            txt='¿Estás seguro que deseas activar la cápsula seleccionada?';
            est=1;
        }

        let fd  = {"capsulaID":capsulaID,"estado":est};
        Swal.fire({
            title: '',
            text: txt,
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#001689",
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if(result.value)
                ajaxCambiarEstado(fd);
        })
    });

    function ajaxCambiarEstado(fd){
        $.ajax({
            url: BASE_URL + "Comunicados/ajaxCambiarEstadoCapsula",
            cache: false,
            type: 'post',
            dataType: 'json',
            data:fd
        }).done(function (data) {
            if(data.code === 1) {
               getCapsulas();
                $.toast({
                    text:'Se cambio el estado de la cápsula seleccionada.',
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


    $('#txtSearch').keyup(function(){
        var nombres = $('.nombre');
        var buscando = $(this).val();
        var item='';
        for( var i = 0; i < nombres.length; i++ ){
            item = $(nombres[i]).html().toLowerCase();
            for(var x = 0; x < item.length; x++ ){
                if( buscando.length == 0 || item.indexOf( buscando ) > -1 ){
                    $(nombres[i]).parents('.item').show();
                }else{
                    $(nombres[i]).parents('.item').hide();
                }
            }
        }
    });
});

