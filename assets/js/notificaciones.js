(function ($) {
    notificacionList();
    const audio = new Audio(BASE_URL + "assets/notificacion/notificacion.mp3");
    var myVar = setInterval(notificacion, 30000);
    var myVar2 = setInterval(notificacionList, 30000);

    function notificacion() {
        $.ajax({
            url: BASE_URL + "Usuario/getNotificacionesPush",
            type: "GET",
            dataType: "json",
            success: function (data) {
                let notificaciones = data.notificaciones;
                $.each(notificaciones, function (key, value) {
                    audio.play();
                    showNotification('bg-blue-grey', value.not_Titulo+ ' <br> '+value.not_Descripcion, 'bottom', 'right', '', '');
                });
            }
        });
    }

    function notificacionList() {

        $("#itemsNotificaciones").empty();
        $.ajax({
            url: BASE_URL + "Usuario/getNotificacionesList",
            type: "GET",
            dataType: "json",
            success: function (data) {
                let notificaciones = data.notificaciones;
                let visible = data.style;
                $("#itemsNotificaciones").append(notificaciones);
                if (visible == true) {
                    $('#notify').css('visibility', 'visible');
                }else {
                    $('#notify').css('visibility', 'hidden');
                }
            }
        });
    }

    $("body").on("click", ".checkNotificacion", function (evt) {
        evt.preventDefault();
        let id = $(this).data('id');
        let link = $(this).data('link');
        let fd = { id: id, link: link };
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
    });

    $("body").on("click", ".borrarNotificaciones", function (evt) {
        evt.preventDefault();
        $.ajax({
            url: BASE_URL + "Usuario/ajax_limpiarNotifaciones",
            type: "POST",
            dataType: "json"
        }).done(function (data) {
            if (data === "success") {
                $('#bell').removeClass('bell');
                notificacionList();
            }
        }).fail(function () { });
    });


    function showNotification(colorName, text, placementFrom, placementAlign, animateEnter, animateExit) {
        if (colorName === null || colorName === '') { colorName = 'bg-black'; }
        if (text === null || text === '') { text = ''; }
        if (animateEnter === null || animateEnter === '') { animateEnter = 'animated fadeInDown'; }
        if (animateExit === null || animateExit === '') { animateExit = 'animated fadeOutUp'; }
        var allowDismiss = true;

        $.notify({
            message: text
        },
            {
                type: colorName,
                allow_dismiss: allowDismiss,
                newest_on_top: true,
                timer: 6000,
                placement: {
                    from: placementFrom,
                    align: placementAlign
                },
                animate: {
                    enter: animateEnter,
                    exit: animateExit
                },
                template: '<div data-notify="container" class="bootstrap-notify-container alert alert-dismissible {0} ' + (allowDismiss ? "p-r-35" : "") + '" role="alert">' +
                    '<span data-notify="icon"></span> ' +
                    '<span data-notify="title">{1}</span> ' +
                    '<span data-notify="message">{2}</span>' +
                    '<div class="progress" data-notify="progressbar">' +
                    '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                    '</div>' +
                    '<a href="{3}" target="{4}" data-notify="url"></a>' +
                    '</div>'
            });
    }
})(jQuery);

