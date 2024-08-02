$(document).ready(function (e) {
    $(".select2").select2();
    $("body").on("click",".btnCambiarNombre",function (e) {
        e.preventDefault();
        let puestoID = $(this).data("id");
        let nombre = $(this).data("nombre");

        $('#cminpuestoid').val(puestoID);
        $('#cminnombre').val(nombre);
        $("#nivele").select2().trigger('change');
        $('#cmPuesto').modal("show");

    });//btnCambiarNombre

    $("body").on("click",".eliminar",function (e) {
        var puestoID = $(this).data("id");
        txt='¿Estás seguro que deseas eliminar el puesto seleccionado?';
        let fd  = {"puestoID":puestoID,"estado":0};
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
            url: BASE_URL + "Catalogos/updatePuestoEstatus",
            cache: false,
            type: 'post',
            dataType: 'json',
            data:fd
        }).done(function (data) {
            if(data.code === 1) {

                $.toast({
                    text:'Se cambio el estado del puesto seleccionado.',
                    icon: "success",
                    loader: true,
                    loaderBg: '#c6c372',
                    position: 'top-right',
                    allowToastClose : true,
                });
                setTimeout(function () {
                    window.location.reload();
                }, 1200);
            }
            else {
                $.toast({text: "¡Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.!", icon: "error", loader: false, position: 'top-right',allowToastClose : false});
            }

        }).fail(function (data) {
            $.toast({text: "¡Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.!", icon: "error", loader: false, position: 'top-right',allowToastClose : false});
        }).always(function (e) {

        });//ajax
    }

    $("#txtSearch").on("keyup", function() {

        var  a; var i; var txtValue;
        var input = document.getElementById("txtSearch");
        var filter = input.value.toUpperCase();
        var contenido = document.getElementById("contenido-puestos");
        var carPuestos = contenido.getElementsByClassName("card-puesto");

        for (i = 0; i < carPuestos.length; i++) {
            a = carPuestos[i].getElementsByClassName("find_Nombre")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                carPuestos[i].style.display = "";
            } else {
                carPuestos[i].style.display = "none";
            }
        }//for
    });

})