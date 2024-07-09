!function (l) {
    "use strict";
    var e = function () {
        this.$body = l("body"),
            this.$calendar = l("#calendarOperativo");
    };

    e.prototype.init = function () {
        var e = new Date,
            t = (e.getDate(), e.getMonth(), e.getFullYear(),
                new Date(l.now())),
            a = this;
        a.$calendarObj = a.$calendar.fullCalendar({
            defaultView: "month",
            weekends: true,
            eventOverlap: false,
            dragabble: true,
            nowIndicator: true,
            editable: true,
            eventDurationEditable: false,
            slotDuration: '00:10:00',
            minTime: "08:00:00",
            maxTime: "21:00:00",
            //quitar domingo
            //hiddenDays: [ 0 ],
            //juntar eventos
            dayMaxEventRows: true, // for all non-TimeGrid views
            eventLimit:true,
            eventLimitText: ' eventos',
            views: {
                month: {
                    eventLimit: 2
                }
            },
            allDaySlot: true,
            //no muestra la hora
            displayEventTime: false,
            businessHours: {
                dow: [1, 2, 3, 4, 5, 6],
                start: '08:00',
                end: '21:00'
            },
            selectable: true,
            selectHelper: true,
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
            buttonText: {
                today: "Hoy",
                month: "Mes",
                week: "Semana",
                day: "Día",
                list: "Lista"
            },
            height: 650,
            header: { left: "prev,next today", center: "title", right: "month,agendaWeek,agendaDay" },
            eventSources: [
                //Incidencias
                {
                    events: function (start, end, timezone, callback) {

                        $.ajax({
                            url: BASE_URL + "Usuario/equipoOperativo",
                            method: 'post',
                            dataType: 'json',
                            success: function (msg) {
                                var events = msg.events;
                                callback(events);
                            }
                        });

                    },
                },
            ],

            eventClick: function (calEvent) {
                verFormato(calEvent);
            },


        })
    },
        l.CalendarApp = new e
}(window.jQuery),
    function (e) {
        "use strict";
        window.jQuery.CalendarApp.init()
    }();


function verFormato (calEvent) {
    var title = calEvent.title;
    var sucursal = calEvent.sucursal;
    var tipo = calEvent.tipo;
    var id = calEvent.id;
    //var fechaInicio = calEvent.start._i;
    //var fechaFin = calEvent.end._i;
    $("#modalTitlePdf").empty();
    if (tipo === "vacaciones") {
        $("#modalPdf").modal("show");
        $("#modalTitlePdf").append('Nombre del colaborador: '+title +'<br>  Sucursal: '+sucursal);
        $("#iframePdf").attr("src", BASE_URL+"PDF/imprimirSolicitudVacaciones/"+id);

    } else if (tipo === "permisos") {
        $("#modalPdf").modal("show");
        $("#modalTitlePdf").append('Nombre del colaborador: '+title +'<br>  Sucursal: '+sucursal);
        $("#iframePdf").attr("src", BASE_URL+"PDF/imprimirPermiso/"+id);
    }else if (tipo === "incapacidades") {
        Swal.fire({
            title: '<strong>Incapacidad</strong>',
            icon: '',
            html:
              'Nombre del colaborador: <b>'+title+'</b><br> ' +
              'Sucursal: <b>'+sucursal+'</b><br> ',
            showCloseButton: true,
            showCancelButton: false,
            showConfirmButton:false,

          })
    }
}