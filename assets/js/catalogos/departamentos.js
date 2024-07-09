$('body').on('click', '.editar', function(e) {
    e.preventDefault();
    $("#departamento")[0].reset();
    let departamentoID = $(this).data('id');
    $.ajax({
        url: BASE_URL + "Catalogos/ajax_getInfoDepartamento/"+departamentoID ,
        type: "POST",
        async:true,
        cache:false,
        dataType: "json"
    }).done(function (data){

        if(data.response === "success"){
            $("#id").val(data.result.dep_DepartamentoID);
            $("#nombre").val(data.result.dep_Nombre);
            $("#selectJefeID").val(data.result.dep_JefeID);
            $("#selectJefeID").select2().trigger('change');

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

    $("#addDepartamento").modal("show");

    $('body').on('click', '.guardar', function(evt) {
        evt.preventDefault();
        $formulario = $("#departamento");

        data = new FormData($formulario[0]);
        let departamentoID = $("#id").val();
        $.ajax({
            url: BASE_URL + "Catalogos/ajax_editarDepartamento/"+departamentoID ,
            type: "POST",
            data: data,
            async:true,
            cache:false,
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            dataType: "json"
        }).done(function (data){
            //location.reload()
            if(data.response === "success"){

                $.toast({
                    text: "Los datos se guardaron correctamente",
                    icon: "success",
                    loader: true,
                    loaderBg: '#c6c372',
                    position: 'top-right',
                    allowToastClose : true,
                });
                setTimeout(function (e) {
                    location.reload();
                }, 1200);
            } else {
                $.toast({
                    text: "Ha ocurrido un error",
                    icon: "error",
                    loader: true,
                    loaderBg: '#c6c372',
                    position: 'top-right',
                    allowToastClose : true,
                });
            }
        });

    });
});


$("body").on("click",".activarInactivar",function (e) {
    var departamentoID = $(this).data("id");
    var estado = $(this).data("estado");

    if(estado===1){
        txt='¿Estás seguro que deseas inactivar el registro seleccionado?';
        est=1;
    } else if(estado===0){
        txt='¿Estás seguro que deseas activar el registro seleccionado?';
        est=0;
    }

    let fd  = {"departamentoID":departamentoID,"estado":est};
    Swal.fire({
        title: '',
        text: txt,
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#f72800",
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if(result.value)
            ajaxCambiarEstado(fd);
    })
});

function ajaxCambiarEstado(fd){
    $.ajax({
        url: BASE_URL + "Catalogos/ajaxUpdateDepEstatus",
        cache: false,
        type: 'post',
        dataType: 'json',
        data:fd
    }).done(function (data) {
        if(data.code === 1) {

            $.toast({
                text:'Se cambio el estado registro seleccionado.',
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