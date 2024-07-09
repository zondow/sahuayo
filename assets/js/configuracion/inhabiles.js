!function(l){
    "use strict";
        var e=function(){
            this.$body=l("body"),
            this.$calendar=l("#calendarInhabiles")
        };

        e.prototype.init=function(){
            var e=new Date,
                t=(e.getDate(),e.getMonth(),e.getFullYear(),
                    new Date(l.now())),

            a=this;
            a.$calendarObj=a.$calendar.fullCalendar({
                defaultView: "month",
                //quitar domingo
                //hiddenDays: [ 0 ],
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'],
                buttonText: {
                    today: "Hoy",
                    month: "Mes",
                    week: "Semana",
                    day: "Día",
                    list: "Lista"
                },
                height: l(window).height(),
                header: {left: "prev,next today", center: "title", right: "month,agendaWeek,agendaDay"},
                eventSources: [
                    {
                        events: function(start, end, timezone, callback) {

                            $.ajax({
                                url: BASE_URL+"Configuracion/ajax_getDiasInhabiles",
                                method:'post',
                                dataType: 'json',
                                success: function(msg) {
                                    var events = msg.events;
                                    callback(events);
                                }
                            });
                        },
                    },
                    {
                        events: function(start, end, timezone, callback) {

                            $.ajax({
                                url: BASE_URL+"Configuracion/ajax_getDiasInhabilesLey",
                                method:'post',
                                dataType: 'json',
                                success: function(msg) {
                                    var events = msg.events;
                                    callback(events);
                                }
                            });
                        },
                    }

                ],
                dayClick: function(date) {
                    if(revisarPermisos('Agregar','diasInhabiles'))
                    nuevoDia(date);

                },

                eventClick: function(calEvent) {

                    //Consultar informacion del dia
                    var id = calEvent.ID;
                    var bd = calEvent.bd;
                    var eliminar = calEvent.eliminar;
                    $("#idEvt").val(id);
                    if(eliminar==='no'){
                        $('#botonEliminar').hide();
                    }else if(eliminar==='si'){
                        $('#botonEliminar').show();
                    }
                    verDia(id,bd);

                    $("#deleteDiaIn").click(function (evt) {
                        evt.preventDefault();
                        evt.stopImmediatePropagation();
                        eliminarDia();
                    });
                }

            })},
        l.CalendarApp=new e
       }(window.jQuery),
    function(e){"use strict";
        window.jQuery.CalendarApp.init()}();

//Crear un nuevo evento
function nuevoDia(date){

    var $form = $("#formInhabiles");
    var $fecha = $("#dia_Fecha");
    var $motivo = $("#dia_Motivo");
    var $sucursal = $("#sucursales");

    $form[0].reset();
    $("#modalDiaInhabil").removeData();
    selSucursales();
    $("#modalDiaInhabil").modal("show");

    $("#fecha").html(date.format('DD - MM - YYYY'));
    $fecha.val(date.format());

    //Modal para agregar dia inhabil
    $("#addDiaIn").click(function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        if($motivo.val() === '' || $sucursal.val() === ''  ||  $("#dia_MedioDia").val() ===''){
            $.toast({
                text: "Escriba el motivo del dia no laboral, seleccione la sucursal y seleccione si es mediodía o completo.",
                icon: "warning",
                loader: true,
                loaderBg: '#c6c372',
                position: 'top-right',
                allowToastClose : true,
            });
        }else{
            $.ajax({
                url: BASE_URL+'Configuracion/ajax_addDiaInhabil',
                type: 'post',
                dataType: 'json',
                data: $form.serialize()
            }).done(function(data){
                if (data.response === 'success'){
                    $.toast({
                        text: "Dia Inhabil registrado correctamente.",
                        icon: "success",
                        loader: true,
                        loaderBg: '#c6c372',
                        position: 'top-right',
                        allowToastClose : true,
                    });
                    $("#modalDiaInhabil").modal("hide");
                    $("#calendarInhabiles").fullCalendar('refetchEvents');
                    $("#calendarInhabiles").fullCalendar('gotoDate', data.fecha );
                }else{
                    $.toast({
                        text: "Ocurrio un error, por favor intente mas tarde.",
                        icon: "error",
                        loader: true,
                        loaderBg: '#c6c372',
                        position: 'top-right',
                        allowToastClose : true,
                    });
                }
            }).fail(function(){
                $.toast({
                    text: "Ocurrio un error, por favor intente mas tarde.",
                    icon: "error",
                    loader: true,
                    loaderBg: '#c6c372',
                    position: 'top-right',
                    allowToastClose : true,
                });
            });
        }
    });
}//end nuevo dia

//Ver la informacion del evento
function verDia(id,bd){

    $.ajax({
        url: BASE_URL + 'Configuracion/ajax_getDiaInhabil/' + id +'/'+bd,
        dataType: 'json',
    }).done(function (data) {
        if (data.response === 'success'){
            var motivo = decodeURIComponent(data.dia.dia_Motivo);
            $("#infoMotivo").html(motivo);
            $("#txtSucrsales").html(data.dia.sucursal);
        }
    }).fail(function (error) {
        $.toast({
            text: "Ocurrio un error, por favor intente mas tarde.",
            icon: "error",
            loader: true,
            loaderBg: '#c6c372',
            position: 'top-right',
            allowToastClose : true,
        });
    });

    $("#infoDiaInhabil").modal("show");
}


//Eliminar Dia
function eliminarDia(){
    $.ajax({
        url: BASE_URL+'Configuracion/ajax_eliminarDiaInhabil/'+ $("#idEvt").val(),
        dataType: 'json',
    }).done(function(data){
        if (data.response === 'success'){
            $.toast({
                text: "Dia inhabil eliminado.",
                icon: "success",
                loader: true,
                loaderBg: '#c6c372',
                position: 'top-right',
                allowToastClose : true,
            });
            $("#infoDiaInhabil").modal("hide");
            $("#calendarInhabiles").fullCalendar('refetchEvents');
        }
    }).fail(function(error){
        $.toast({
            text: "Ocurrio un error, por favor intente mas tarde.",
            icon: "error",
            loader: true,
            loaderBg: '#c6c372',
            position: 'top-right',
            allowToastClose : true,
        });
    });
}

$(".select2-multiple").select2({
    language: "es",
    selectOnClose: false,
    allowClear: true,
    placeholder: " Seleccione",

});

function selSucursales(){
    $("#sucursales").empty();
    $.ajax({
        url: BASE_URL+"Configuracion/ajax_getSucursales",
        method:'post',
        dataType: 'json',
    }).done(function (data) {
        var $row ='';
        $row += "<option value='0'>TODAS</option>";
        $.each(data.info, function (key, value) {
            $row += "<option value='" + value.suc_SucursalID + "'>" + value.suc_Sucursal + "</option>";
        });
        $("#sucursales").append($row);
        $("#sucursales").trigger('change');

    });
}