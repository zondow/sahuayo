!function(l){
    "use strict";
    var e=function(){
        this.$body=l("body"),
            this.$calendar=l("#calendarVacaciones");
    };

    e.prototype.init=function(){
        var e=new Date,
            t=(e.getDate(),e.getMonth(),e.getFullYear(),
                new Date(l.now())),
            a=this;
        a.$calendarObj=a.$calendar.fullCalendar({
            defaultView: "month",
            weekends:true,
            eventOverlap: false,
            dragabble: false,
            nowIndicator: true,
            editable:false,
            eventDurationEditable: false,
            slotDuration: '00:10:00',
            minTime: "08:00:00",
            maxTime: "21:00:00",
            //quitar domingo
            hiddenDays: [ 0 ],
            allDaySlot:false,
            //no muestra la hora
            displayEventTime: false,
            businessHours:{
                dow: [ 1, 2, 3, 4,5,6 ],
                start:'08:00',
                end:'21:00'
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

            height: 450,
            header: {left: "prev,next today", center: "title", right: "month,agendaWeek,agendaDay"},
            eventSources:[
                //Vacaciones
                {
                    events: function(start, end, timezone, callback) {

                        $.ajax({
                            url: BASE_URL+"Incidencias/ajax_getVacacionesEmpleadosJefe",
                            method:'post',
                            dataType: 'json',
                            success: function(msg) {
                                var events = msg.events;
                                callback(events);

                            }
                        });

                    },
                },
            ],
            dayClick: function(date) {
                dia(date);
            },
            eventClick: function(calEvent) {
                verVacacion(calEvent);
            }
        })},
        l.CalendarApp=new e
}(window.jQuery),
    function(e){"use strict";
        window.jQuery.CalendarApp.init()}();

function verVacacion(calEvent) {
    var title = calEvent.title;

    Swal.fire({
        title: "Solicitud de vacaciones",
        text: title+' ha solicitado vacaciones '+calEvent.periodo,
        showCancelButton: false,
        confirmButtonColor: "#4ec4a4",
        confirmButtonText: "Ok",
        closeOnConfirm: true,
    });
}
