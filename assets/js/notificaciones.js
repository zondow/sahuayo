(function ($) {
    notificacionList();
    var myVar = setInterval(notificacion, 120000);
    const audio = new Audio("https://federacion.thigo.mx/assets/notificacion/juntos-607.mp3");

    var myVar2 =setInterval(notificacionList, 120000);

    function notificacion() {
        $.ajax({
            url: BASE_URL + "Usuario/getNotificacionesPush",
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
                        icon: BASE_URL + 'assets/images/thigo/1.png',
                        onClick: function () {
                            borrarNotificacion(fd);
                            this.close();
                        },
                        timeout: 6000
                    });

                });
            }
        });
    }

    function notificacionList() {
        
        $("#items").empty();
        $.ajax({
            url: BASE_URL + "Usuario/getNotificacionesList",
            type: "GET",
            dataType: "json",
            success: function (data) {
                let notificaciones = data.notificaciones;
                let total = data.total;
                let clase = data.class;
                
                $("#items").append(notificaciones);
                $("#totalNotif").html(total);
                $("#bell").addClass(clase);
                
            }
        });
    }



    function myStopFunction() {
        clearInterval(myVar);
        clearInterval(myVar2);

    }

    function borrarNotificacion(fd) {
        myStopFunction();
        $.ajax({
            url: BASE_URL + "Usuario/ajax_notificacionVista",
            type: "POST",
            data: fd,
            dataType: "json"
        }).done(function (data) {
            if (data.response === "success") {
                $(location).attr('href', BASE_URL + data.link);
            }
        }).fail(function () { });
    }

    $("body").on("click", ".checkNotificacion", function (evt) {
        evt.preventDefault();
        let id = $(this).data('id');
        let link = $(this).data('link');
        let fd  = {id:id,link:link};
        $.ajax({
            url: BASE_URL + "Usuario/ajax_notificacionVista",
            type: "POST",
            data:fd,
            dataType: "json"
        }).done(function (data){
            if(data.response === "success"){
                $(location).attr('href',BASE_URL+data.link);
            }
        }).fail(function () {});
    });

    $("body").on("click", ".borrarNotificaciones", function (evt) {
        evt.preventDefault();
        $.ajax({
            url: BASE_URL + "Usuario/ajax_limpiarNotifaciones",
            type: "POST",
            dataType: "json"
        }).done(function (data){
            if(data === "success"){
                $('#bell').removeClass('bell');
                notificacionList();
            }
        }).fail(function () {});
    });

    $("body").on("click", ".borrarNotificacionesTicket", function (evt) {
        evt.preventDefault();
        $.ajax({
            url: BASE_URL + "Usuario/ajax_limpiarNotifacionesTicket",
            type: "POST",
            dataType: "json"
        }).done(function (data){
            if(data === "success"){
                $('#bellTicket').removeClass('ticketIcon');
                notificacionTicketList();
            }
        }).fail(function () {});
    });


})(jQuery);

