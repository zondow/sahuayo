$(document).ready(function (e) {

    $("body").on("click", "#btnNotificarIngreso", function (evt) {
        evt.preventDefault();
        let empleadoID = $(this).data("id");
        swal.fire({
            title: '<strong>Confirmación</strong>',
            icon: 'question',
            text: '¿Esta seguro que desea notificar el nuevo ingreso a las areas correpondientes?',
            showCancelButton:true,
            closeOnConfirm: false,
            cancelButtonText: ' Cerrar',
        }).then((result) => {
            if (result.value) {
                enviarComunicado(empleadoID);
            }
        });
    });

    function enviarComunicado(empleadoID){
        $.ajax({
            type: "POST",
            url: BASE_URL + "Personal/ajaxEnviarNotiNuevoIngreso",
            data: 'empleadoID='+empleadoID,
            dataType: "json",
            beforeSend: function () {
                swal.fire({
                    title: 'Enviando la notificacion de nuevo ingreso.',
                    text: 'Por favor espere mientras se envian los correos correspondientes.',
                    timer: 20000,
                    onBeforeOpen: () => {
                        Swal.showLoading()
                        timerInterval = setInterval(() => {
                            Swal.getContent().querySelector('strong')
                                .textContent = Swal.getTimerLeft();
                        }, 1000);
                    },
                    onClose: () => {
                        clearInterval(timerInterval);
                    }
                });
            }
        }).done(function (data) {
            data = JSON.parse(JSON.stringify(data));
            if (data.response === 1) {
                swal.fire({
                    title: "¡Correos enviados exitosamente!",
                    text: "",
                    icon: 'success',
                }).then(() => {

                    location.reload();
                });

            } else {
                swal.fire({
                    title: '¡Tuvimos un problema!',
                    type: 'error',
                    text: 'Ocurrio un error al tratar de enviar los correos,por favor intente de nuevo.',
                }).then(() => {
                    location.reload();
                });
            }
        });
    }
    

});