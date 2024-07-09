(function ($) {
    notificacionTicketList();
    const audio = new Audio("https://federacion.thigo.mx/assets/notificacion/juntos-607.mp3");
    var myVar = setInterval(notificacionPushTicket, 60000);
    var myVar2 =setInterval(notificacionTicketList, 60000);
    function notificacionPushTicket() {
        $.ajax({
            url: BASE_URL + "Usuario/getNotificacionesPushTicket",
            type: "GET",
            dataType: "json",
            success: function (data) {
                let notificaciones = data.notificaciones;
                $.each(notificaciones, function (key, value) {

                    let id = value.not_NotificacionID;
                    let link = value.not_URL;
                    let fd = { id: id, link: link };
                    audio.play();
                    Push.create(value.not_Titulo, {
                        body: value.not_Descripcion,
                        icon: BASE_URL + 'assets/images/mesa/11.png',
                        onClick: function () {
                            borrarNotificacionTicket(fd);
                            this.close();
                        },
                        timeout: 6000
                    });

                });
            }
        });
    }
    function notificacionTicketList() {
        $("#itemsTicket").empty();
        $.ajax({
            url: BASE_URL + "Usuario/getNotificacionesTicketList",
            type: "GET",
            dataType: "json",
            success: function (data) {
                let notificaciones = data.notificaciones;
                let total = data.total;
                let clase = data.class;

                $("#itemsTicket").append(notificaciones);
                $("#totalNotifTicket").html(total);
                $("#bellTicket").addClass(clase);

            }
        });
    }
    function borrarNotificacionTicket(fd) {
        myStopFunction();
        $.ajax({
            url: BASE_URL + "Usuario/ajax_notificacionVistaTicket",
            type: "POST",
            data: fd,
            dataType: "json"
        }).done(function (data) {
            if (data.response === "success") {
                $(location).attr('href', data.link);
            }
        }).fail(function () { });
    }
    $("body").on("click", ".checkNotificacionTicket", function (evt) {
        evt.preventDefault();
        let id = $(this).data('id');
        let link = $(this).data('link');
        let fd  = {id:id,link:link};
        $.ajax({
            url: BASE_URL + "Usuario/ajax_notificacionVistaTicket",
            type: "POST",
            data:fd,
            dataType: "json"
        }).done(function (data){
            if(data.response === "success"){
                $(location).attr('href',data.link);
            }
        }).fail(function () {});
    });
})(jQuery);

