!function (l) {
    "use strict";
    var e = function () {
        this.$body = l("body"),
            this.$calendar = l("#calendarAgenda");
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
                //Eventos
                /*{
                    events: function(start, end, timezone, callback) {

                        $.ajax({
                            url: BASE_URL+"Agenda/ajax_getEventosColaborador",
                            method:'post',
                            dataType: 'json',
                            success: function(msg) {
                                var events = msg.events;
                                callback(events);
                            }
                        });

                    },
                },*/
                //Cumpleaños
                {
                    events: function (start, end, timezone, callback) {

                        $.ajax({
                            url: BASE_URL + "Usuario/ajax_getCumpleanios",
                            method: 'post',
                            dataType: 'json',
                            /*data: {
                                'inicio':start.format('YYYY-MM-DD'),
                                'fin':end.format('YYYY-MM-DD'),
                            },*/
                            success: function (msg) {
                                var events = msg.events;
                                callback(events);
                            }
                        });

                    },
                },
                //Inhabiles Ley
                {
                    events: function (start, end, timezone, callback) {

                        $.ajax({
                            url: BASE_URL + "Usuario/ajax_getInhabilesLey",
                            method: 'post',
                            dataType: 'json',
                            success: function (msg) {
                                var events = msg.events;
                                callback(events);
                            }
                        });

                    },
                },
                //Inhabiles empresa
                {
                    events: function (start, end, timezone, callback) {

                        $.ajax({
                            url: BASE_URL + "Usuario/ajax_getInhabiles",
                            method: 'post',
                            dataType: 'json',
                            success: function (msg) {
                                var events = msg.events;
                                callback(events);
                            }
                        });

                    },
                },
                //Aniversarios
                {
                    events: function (start, end, timezone, callback) {

                        $.ajax({
                            url: BASE_URL + "Usuario/ajax_getAniversario",
                            method: 'post',
                            dataType: 'json',
                            success: function (msg) {
                                var events = msg.events;
                                callback(events);
                            }
                        });

                    },
                },
                //Periodos evaluaciones
                {
                    events: function (start, end, timezone, callback) {

                        $.ajax({
                            url: BASE_URL + "Usuario/ajax_getEvaluaciones",
                            method: 'post',
                            dataType: 'json',
                            success: function (msg) {
                                var events = msg.events;
                                callback(events);
                            }
                        });

                    },
                },
                //Capacitaciones
                {
                    events: function (start, end, timezone, callback) {

                        $.ajax({
                            url: BASE_URL + "Usuario/ajax_getCapacitaciones",
                            method: 'post',
                            dataType: 'json',
                            success: function (msg) {
                                var events = msg.events;
                                callback(events);
                            }
                        });

                    },
                },
                //Vacaciones
                {
                    events: function (start, end, timezone, callback) {

                        $.ajax({
                            url: BASE_URL + "Usuario/ajax_getVacaciones",
                            method: 'post',
                            dataType: 'json',
                            success: function (msg) {
                                var events = msg.events;
                                callback(events);
                            }
                        });

                    },
                },
                //Guardias
                {
                    events: function (start, end, timezone, callback) {

                        $.ajax({
                            url: BASE_URL + "Usuario/ajax_getGuardia",
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
            dayClick: function (date) {
                dia(date);
            },
            eventClick: function (calEvent) {
                if (calEvent.tipo !== "evento") {
                    verFechasImportantes(calEvent);
                } else {
                    verEvento(calEvent);
                }
            },
            eventDrop: function (event, delta, revertFunc) {
                moverEventoDrop(event);
            },
            eventRender: function (event, element, view) {
                return ['all', event.tipo].indexOf($('#selector').val()) >= 0
            }
        })
    },
        l.CalendarApp = new e
}(window.jQuery),
    function (e) {
        "use strict";
        window.jQuery.CalendarApp.init()
    }();

    getPrestaciones();
    felicitacionCumple();
    felicitacionAniversario();

$('#selector').on('change', function () {
    $('#calendarAgenda').fullCalendar('rerenderEvents');
})

function verFechasImportantes(calEvent) {
    var title = calEvent.title;
    var img = calEvent.img;
    var tipo = calEvent.tipo;
    //var fechaInicio = calEvent.start._i;
    //var fechaFin = calEvent.end._i;

    if (tipo === "cumple") {
        imagen = img;
        Swal.fire({
            title: title,
            imageUrl: imagen,
            imageWidth: 300,
            imageHeight: 300,
        });
    } else if (tipo === "aniversario") {
        imagen = img;
        Swal.fire({
            title: title,
            imageUrl: imagen,
            imageWidth: 300,
            imageHeight: 300,
        });
    } else if (tipo === "vacaciones") {
        imagen = BASE_URL + "assets/images/iconsCalendario/vacaciones.png";
        swal({
            title: title,
            text: "<img class='iconCalendario' src='" + imagen + "' >",
            html: true,
            showCancelButton: false,
            confirmButtonColor: "#4ec4a4",
            confirmButtonText: "Ok",
            closeOnConfirm: true,
        });
    } else if (tipo === "capacitacion") {
        if(img != null){
            imagen = BASE_URL + img;
            Swal.fire({
                title: '',
                position: 'top',
                imageUrl: imagen,
                imageWidth: 300,
                imageHeight: 300,
            });
        }else{
            Swal.fire(title);
        }
    } else {
        Swal.fire(title);
    }
}

$("body").on("click", ".verInfoIncidencias", function (evt) {
    evt.preventDefault();
    $("#verKardexColab").empty();
    let empleadoID = $(this).data('id');
    $.ajax({
        url: BASE_URL + "Usuario/ajax_getInfoIncidenciasByEmpleado/" + empleadoID,
        type: "POST",
        async: true,
        cache: false,
        dataType: "json"
    }).done(function (data) {
        if (data.response === "success") {
            console.log(data.result);
            $("#fotoPefil").attr("src", data.result.fotoPerfil);
            $("#empleadoNombre").html(data.result.nombre);
            $("#puestoEmpleado").html(data.result.puesto);
            $("#FIngreso").html(data.result.fechaIngreso);
            $("#Antiguedad").html(data.result.antiguedad);
            $("#vacCorrespondientes").html(data.result.diasley);
            $("#vacTomados").html(data.result.ocupados);
            $("#vacPendientes").html(data.result.diasRestantes);
            $("#diasPTomados").html(data.result.permisosTomados);
            $("#horas").html(data.result.horas);
            //$("#verKardexColab").append('<a class="btn btn-primary waves-effect" target="_blank"><i class="mdi mdi-calendar-account"></i> Ver kardex</a>');
            $("#verKardexColab").append('<a href="'+BASE_URL+ 'PDF/reporteIncidencias/'+empleadoID+'"  class="btn btn-primary waves-effect" target="_blank"><i class="mdi mdi-calendar-account"></i> Ver kardex</a>');


        }
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
    $("#modalInfoIncidencias").modal("show");
});

$("body").on("click", ".verInfoRetardo", function (evt) {
    evt.preventDefault();
    $("#modalInfoRetardos").modal("show");
});

$("body").on("click", ".verInfoPermisos", function (evt) {
    evt.preventDefault();
    $("#modalInfoPermisos").modal("show");
});

$("body").on("click", ".verMisSanciones", function (evt) {
    evt.preventDefault();
    window.location.href = BASE_URL+"Incidencias/misSanciones";
});


function getPrestaciones() {
    $.ajax({
        url: BASE_URL + "Usuario/ajaxGetMisPrestaciones",
        method: 'post',
        dataType: 'json',
    }).done(function (data) {
        $("#vacaciones").html(data.vacaciones);
        $("#prima").html(data.prima);
        $("#aguinaldo").html(data.aguinaldo);
        $(".antiguedad").html(data.antiguedad);
        $("#diasley").html(data.diasley);
        $("#horasExtra").html(data.horasExtra);
    }).fail(function (data) { });
}

function felicitacionCumple(){

    $.ajax({
        url: BASE_URL + "Usuario/ajax_felicitacion",
        type: "POST",
        dataType: "json"
    }).done(function (data) {
        //audio.play();
        Swal.fire({
            title: data.titulo,
            padding: '3em',
            color: '#1d9add',
            html:data.video,
            customClass:'swal-wide',
            
            })

    }).fail(function (data) {
    }).always(function () {
    });
}

function felicitacionAniversario(){

    $.ajax({
        url: BASE_URL + "Usuario/ajax_felicitacionAniv",
        type: "POST",
        dataType: "json"
    }).done(function (data) {
        //audio.play();
        Swal.fire({
            title: data.titulo,
            padding: '3em',
            color: '#1d9add',
            html:data.video,
            customClass:'swal-wide',
            
            })

    }).fail(function (data) {
    }).always(function () {
    });
}

// - - Datetimepicker - -
/*$('.bs-datetimepicker').datetimepicker({
    format: 'YYYY-MM-DD HH:mm:00',
    sideBySide: true,
    stepping: 5,
    minDate: moment(),
    showClear: true,
    keepOpen: false,
    ignoreReadonly: true,
    tooltips: {
        today: 'Hoy',
        clear: 'Limpiar selección',
        close: 'Cerrar',
        selectMonth: 'Seleccionar Mes',
        prevMonth: 'Mes Anterior',
        nextMonth: 'Siguiente Mes',
        selectYear: 'Seleccionar Año',
        prevYear: 'Año Anterior',
        nextYear: 'Siguiente Año',
        selectDecade: 'Seleccionar Década',
        prevDecade: 'Década Anterior',
        nextDecade: 'Siguiente Década',
        prevCentury: 'Siglo Anterior',
        nextCentury: 'Siguiente Siglo'
    }
});*/
