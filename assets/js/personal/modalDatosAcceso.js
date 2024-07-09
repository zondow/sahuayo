$(document).ready(function (e) {

    $('body').on('click', '.acceso', function(e) {
        e.preventDefault();
        let colaboradorID = $(this).data('id');
        ajaxInfoAccesoColaborador(colaboradorID);
        $("#modalDatosAcceso").modal("show");
        $("#spiner").hide();
    });

    $('body').on('click', '#btnGuardarEnviarAcceso', function(evt) {
        evt.preventDefault();
        $formulario = $("#formDatosAcceso");

        data = new FormData($formulario[0]);
        let colaboradorID = $("#idColabA").val();
        $.ajax({
            url: BASE_URL + "Personal/ajax_generarDatosAcceso/"+colaboradorID ,
            type: "POST",
            data: data,
            async:true,
            cache:false,
            processData: false,
            contentType: false,
            dataType: "json",
            beforeSend: function () {
                $("#btnGuardarEnviarAcceso").hide();
                $("#spiner").show();
            }
        }).done(function (data){
            //location.reload()
            if(data.response === "success"){

                $.toast({
                    text: "Se envio un correo con los datos de acceso del colaborador.",
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


function ajaxInfoAccesoColaborador(colaboradorID){
    $.ajax({
        url: BASE_URL + "Personal/ajax_getInfoColaborador/"+colaboradorID ,
        type: "POST",
        async:true,
        cache:false,
        dataType: "json"
    }).done(function (data){

        if(data.response === "success"){
            $("#emp_Correo").val(data.result.emp_Correo);
            $("#emp_Passworde").val(data.result.emp_Password);
            $("#idColabA").val(data.result.emp_EmpleadoID);
            $("#username").val(data.result.emp_Username);
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
}