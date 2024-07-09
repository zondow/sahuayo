$(document).ready(function (e) {
    $("#divSustituyeA").hide();
    $("#divPuestoC").hide();
    $("#divCarrera").hide();
    $("#divEspecificar").hide();
    $("#divPostGrado").hide();
    $("#divOtroEsp").hide();
    $("#divExp").hide();
    $("#divTiempoC").hide();
    $("#divNuevoPuesto").hide();
    $("#divNuevoDepartamento").hide();
    $("#divNuevaArea").hide();

    $("#puesto").change(function (evt) {
        evt.preventDefault();
        if ($("#puesto").val() === "Sustitucion") {
            $("#divSustituyeA").show();
            //required
            $("#sustituyeEmpleado").prop('required', true);
            $("#motivoSalida").prop('required', true);
            $("#fechaSalida").prop('required', true);
        } else {
            $("#divSustituyeA").hide();
            //no required
            $("#sustituyeEmpleado").prop('required', false);
            $("#motivoSalida").prop('required', false);
            $("#fechaSalida").prop('required', false);
        }
    });
    $("#personalCargo").change(function (evt) {
        evt.preventDefault();
        if ($("#personalCargo").val() === "Si") {
            $("#divPuestoC").show();
        } else {
            $("#divPuestoC").hide();
        }
    });
    $("#escolaridad").change(function (evt) {
        evt.preventDefault();
        if ($("#escolaridad").val() === "Carrera Tecnica" || $("#escolaridad").val() === "Carrera Comercial") {
            //show
            $("#divEspecificar").show();
            //hide
            $("#divCarrera").hide();
            $("#divPostGrado").hide();
            $("#divOtroEsp").hide();
            //required
            $("#especificar").prop('required', true);
            //norequired
            $("#carrera").prop('required', false);
            $("#postGrado").prop('required', false);
            $("#otroEspecificar").prop('required', false);
        } else if ($("#escolaridad").val() === "Profesional") {
            //show
            $("#divCarrera").show();
            $("#divPostGrado").show();
            //hide
            $("#divEspecificar").hide();
            $("#divOtroEsp").hide();
            //required
            $("#carrera").prop('required', true);
            //norequired
            $("#especificar").prop('required', false);
            $("#otroEspecificar").prop('required', false);
        } else if ($("#escolaridad").val() === "Otro") {
            //show
            $("#divOtroEsp").show();
            //hide
            $("#divCarrera").hide();
            $("#divEspecificar").hide();
            $("#divPostGrado").hide();
            //required
            $("#otroEspecificar").prop('required', true);
            //norequired
            $("#especificar").prop('required', false);
            $("#carrera").prop('required', false);
            $("#postGrado").prop('required', false);
        } else {
            //hide
            $("#divCarrera").hide();
            $("#divEspecificar").hide();
            $("#divPostGrado").hide();
            $("#divOtroEsp").hide();
            //norequired
            $("#otroEspecificar").prop('required', false);
            $("#especificar").prop('required', false);
            $("#carrera").prop('required', false);
            $("#postGrado").prop('required', false);
        }
    });
    $("#experiencia").change(function (evt) {
        evt.preventDefault();
        if ($("#experiencia").val() === "Con Experiencia") {
            //show
            $("#divExp").show();
            //required
            $("#yearsExp").prop('required', true);
            $("#areaExp").prop('required', true);
        } else if ($("#experiencia").val() === "Sin Experiencia") {
            //hide
            $("#divExp").hide();
            //norequired
            $("#yearsExp").prop('required', false);
            $("#areaExp").prop('required', false);
        }
    });
    $("#contratoTiempo").change(function (evt) {
        evt.preventDefault();
        if ($("#contratoTiempo").val() === "Determinado") {
            //show
            $("#divTiempoC").show();
            //required
            $("#tiempoDeterminado").prop('required', true);
        } else {
            //hide
            $("#divTiempoC").hide();
            //norequired
            $("#tiempoDeterminado").prop('required', false);
        }
    });
    $("#nombrePuesto").change(function (evt) {
        evt.preventDefault();
        if ($("#nombrePuesto").val() === "Nuevo Puesto") {
            //show
            $("#divNuevoPuesto").show();
            //required
            $("#nombreNPuesto").prop('required', true);
            //limpiar input y select
            $("#sexo").val('');
            $("#ecivil").val('');
            $("#perfilP").val('');
            $("#edad").val('');
            $("#personalCargo").val('').trigger('change');
            $("#puestosCoordina").val('').trigger('change');
        } else {
            //hide
            $("#divNuevoPuesto").hide();
            //norequired
            $("#nombreNPuesto").prop('required', false);
            $.ajax({
                url: BASE_URL + "Reclutamiento/ajaxInfoPuesto/" + $("#nombrePuesto").val(),
                type: "POST",
                dataType: 'json',
            }).done(function (data) {
                if (data.code === 1) {
                    switch (data.result.per_Genero) {
                        case 'MASCULINO': $("#sexo").val('Hombre'); break;
                        case 'FEMENINO': $("#sexo").val('Mujer'); break;
                        case 'INDISTINTO': $("#sexo").val('Indistinto'); break;
                    }
                    switch (data.result.per_EstadoCivil) {
                        case 'SOLTERO': $("#ecivil").val('Soltero'); break;
                        case 'CASADO': $("#ecivil").val('Casado'); break;
                        case 'INDISTINTO': $("#ecivil").val('Indistinto'); break;
                    }
                    $("#perfilP").val(data.result.per_Objetivo);
                    $("#edad").val(data.result.per_Edad);
                    console.log(data.result.per_PuestoCoordina);
                    if (data.result.per_PuestoCoordina) {
                        setTimeout(function () { $("#personalCargo").val('Si').trigger('change'); }, 200);
                        var obj = JSON.parse(data.result.per_PuestoCoordina);
                        $("#puestosCoordina").val(obj);
                        $("#puestosCoordina").select2().trigger('change');
                    }

                } else if (data.code === 2) {
                    $("#personalCargo").val('').trigger('change');
                    $("#puestosCoordina").val('').trigger('change');
                    $.toast({
                        text: "El puesto no tiene un perfil.",
                        icon: "error",
                        loader: true,
                        loaderBg: '#c6c372',
                        position: 'top-right',
                        allowToastClose: true,
                    });
                } else {
                    $.toast({
                        text: "Ocurrido un error, por favor intente nuevamente.",
                        icon: "error",
                        loader: true,
                        loaderBg: '#c6c372',
                        position: 'top-right',
                        allowToastClose: true,
                    });
                }
            }).fail(function (data) {
                $.toast({
                    text: "Ocurrido un error, por favor intente nuevamente.",
                    icon: "error",
                    loader: true,
                    loaderBg: '#c6c372',
                    position: 'top-right',
                    allowToastClose: true,
                });
            }).always(function (e) {
            });//ajax
        }
    });
    $("#departamentoVac").change(function (evt) {
        evt.preventDefault();
        if ($("#departamentoVac").val() === "Nuevo departamento") {
            //show
            $("#divNuevoDepartamento").show();
            //required
            $("#nombreNDepartamento").prop('required', true);
        } else {
            //hide
            $("#divNuevoDepartamento").hide();
            //required
            $("#nombreNDepartamento").val('');
            $("#nombreNDepartamento").prop('required', false);
        }
    });
    $("#areaVac").change(function (evt) {
        evt.preventDefault();
        if ($("#areaVac").val() === "Nueva area") {
            //show
            $("#divNuevaArea").show();
            //required
            $("#nombreNArea").prop('required', true);
        } else {
            //hide
            $("#divNuevaArea").hide();
            //required
            $("#nombreNArea").val('');
            $("#nombreNArea").prop('required', false);
        }
    });

    $(".select2").select2({ language: "es", });
    $(".select2-multiple").select2({
        language: "es",
    });

    // Obtén la fecha actual
    var fechaActual = new Date();

    // Calcula la fecha final (fecha actual + 20 días)
    var fechaFinal = new Date();
    fechaFinal.setDate(fechaActual.getDate() + 20);

    //datepicker estandar
    $("#fechaSalida").datepicker({
        daysOfWeekDisabled:[0],
        autoclose:!0,
        format: "yyyy-mm-dd",
        daysOfWeek:["D","L","M","M","J","V","S"],
        monthNames:["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],
        todayHighlight:!0
    });//

    //datepicker con restriccion 20 dias fechaingreso
    $("#fIngreso").datepicker({
        autoclose: true,
        todayHighlight: true,
        orientation: "bottom",
        format: "yyyy-mm-dd",
        daysOfWeek: ["D", "L", "M", "M", "J", "V", "S"],
        monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
        beforeShowDay: function (date) {
            // Obtiene la fecha actual
            var today = new Date();
    
            // Suma 20 días a la fecha actual
            var limitDate = new Date(today);
            limitDate.setDate(today.getDate() + 20);
    
            // Convierte las fechas a formato de comparación
            date = new Date(date.getFullYear(), date.getMonth(), date.getDate());
            today = new Date(today.getFullYear(), today.getMonth(), today.getDate());
            limitDate = new Date(limitDate.getFullYear(), limitDate.getMonth(), limitDate.getDate());
    
            // Si la fecha es igual o posterior a la fecha límite, la deshabilita
            if (date <= today || date >= today && date <= limitDate) {
                return {
                    enabled: false
                };
            }
    
            // Habilita las demás fechas
            return {
                enabled: true
            };
        }
    });
    //

/*    $("#fIngreso").datepicker({
        autoclose: true,
        todayHighlight: true,
        orientation: "bottom",
        format: "yyyy-mm-dd",
        daysOfWeek: ["D", "L", "M", "M", "J", "V", "S"],
        monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
        beforeShowDay: function (date) {
            // Obtiene la fecha actual
            var today = new Date();
    
            // Suma 20 días a la fecha actual
            var limitDate = new Date(today);
            limitDate.setDate(today.getDate() + 20);
    
            // Convierte las fechas a formato de comparación
            date = new Date(date.getFullYear(), date.getMonth(), date.getDate());
            today = new Date(today.getFullYear(), today.getMonth(), today.getDate());
            limitDate = new Date(limitDate.getFullYear(), limitDate.getMonth(), limitDate.getDate());
    
            // Si la fecha es igual o posterior a la fecha límite, la deshabilita
            if (date >= today && date <= limitDate) {
                return {
                    enabled: false
                };
            }
    
            // Habilita las demás fechas
            return {
                enabled: true
            };
        }
    });
    */
});