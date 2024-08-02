$(document).ready(function(e) {
    getAreas();

    function getAreas() {
        $("#divAreas").empty();
        $.ajax({
            url: BASE_URL + "Catalogos/ajaxGetAreas",
            type: "POST",
            dataType: "json"
        }).done(function (data) {

            $("#divAreas").html(data.areas);

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


    var form = $("#formArea");
    var nombre = $("#nombre");

    var modal = $("#modalArea");
    var btnGuardar= $("#guardar");

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
                    getAreas();
                    modal.modal('toggle');

                    $.toast({
                        text: "El area se guardo correctamente.",
                        icon: "success",
                        loader: true,
                        loaderBg: '#c6c372',
                        position: 'top-right',
                        allowToastClose: true,
                    });
                }else if (data.code === 2) {
                    getAreas();
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


    $('#txtSearch').keyup(function(){
       
        var a;
        var i;
        var txtValue;
        var input = document.getElementById("txtSearch");
        var filter = input.value.toUpperCase();
        var contenido = document.getElementById("divAreas");
        var card = contenido.getElementsByClassName("item");

        for (i = 0; i < card.length; i++) {
            a = card[i].getElementsByClassName("find_Nombre")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                card[i].style.display = "";
            } else {
                card[i].style.display = "none";
            }
        } //for
    });
});

