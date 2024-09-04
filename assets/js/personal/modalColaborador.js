
$(document).ready(function (e) {

    $(".datepicker").datepicker({
        autoclose:!0,
        format: "yyyy-mm-dd",
        daysOfWeek:["D","L","M","M","J","V","S"],
        monthNames:["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],
        todayHighlight:!0
    });

    $("body").on("change","#emp_EstadoID",function (e){
        e.preventDefault();
        let estado = $("#emp_EstadoID").val();
        let ciudad =$("#emp_CiudadID").val();
        cargarCuidades(estado, ciudad);
    });

    function cargarCuidades(estado , ciudad){
        $.ajax({
            url: BASE_URL + "Personal/ajax_getCiudadByEstado/" ,
            type: "POST",
            async:true,
            cache:false,
            dataType: "json",
            data: {estado:estado, ciudad:ciudad}
        }).done(function (data){
            if(data.response === "success"){
                $("#emp_CiudadID").empty();

                $.each(data.result, function(index, item) {
                    var selected = item.selected ? 'selected' : '';
                    $('#emp_CiudadID').append(new Option(item.ciu_nombre, item.id_ciudad, false, selected));
                });
                if (ciudad) {
                    $('#emp_CiudadID').val(ciudad).trigger('change');
                }
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

    function limpiarform(){
        $('#formColaborador')[0].reset();
        $('#selectPuesto').val(null).trigger('change');
        $('#selectJefe').val(null).trigger('change');
        $('#selectArea').val(null).trigger('change');
        $('#selectDepartamento').val(null).trigger('change');
        $('#emp_DireccionID').val(null).trigger('change');
        $('#emp_SucursalID').val(null).trigger('change');
        $('#selhorario').val(null).trigger('change');
        $('#selectRol').val(null).trigger('change');
        $('#emp_EstadoCivil').val(null).trigger('change');
        $('#emp_EstatusContratacion').val(null).trigger('change');
        $('#emp_TipoPrestaciones').val(null).trigger('change');
        $('#emp_Abreviatura').val(null).trigger('change');
        $('#emp_NivelEstudio').val(null).trigger('change');
        $("#emp_SucursalID").val(null).trigger('change');
        $("#emp_EstadoID").val(null).trigger('change');
        $("#emp_CiudadID").val(null).trigger('change');
        $("#emp_Sexo").val(null).trigger('change');
        $("#emp_TipoSangre").val(null).trigger('change');
        $("#emp_Hijos").val(null).trigger('change');
        $("#emp_Estudios").val(null).trigger('change');
        $("#emp_Titulo").val(null).trigger('change');
        $("#selectSucursal").val(null).trigger('change');
    }

    $('body').on('click', '.modal-colaborador', function(e) {
        e.preventDefault();
        $('#tituloModal').html('Agregar colaborador');
        limpiarform();
        document.getElementById("emp_Numero").readOnly = false;
        $("#modalColaborador").modal("show");

    });

    $('body').on('click', '.editar', function(e) {
        e.preventDefault();
        $('#tituloModal').html('Editar colaborador');

        let colaboradorID = $(this).data('id');
        limpiarform();
        ajaxInfoColaborador(colaboradorID);
        $("#modalColaborador").modal("show");
    });

    var form = $("#formColaborador");
    
    $('body').on('click', '.bntGuardarEmpleado', function(evt) {
        evt.preventDefault();
    
        $.ajax({
            url: BASE_URL + "Personal/ajax_saveColaborador",
            type: "POST",
            data: form.serialize(),
            dataType: "json"
        }).done(function (data) {
            
            if (data.code === 0) {
                $.toast({
                    text:data.msg,
                    icon: "error",
                    loader: true,
                    loaderBg: '#c6c372',
                    position: 'top-right',
                    allowToastClose : true,
                });
            } else if (data.code === 1) {
                $("#modalColaborador").modal('toggle');
                $.toast({
                    text:data.msg,
                    icon: "success",
                    loader: true,
                    loaderBg: '#c6c372',
                    position: 'top-right',
                    allowToastClose : true,
                });
                setTimeout(function (e) {
                    location.reload();
                }, 1200);
            } else if (data.code === 2) {
                $("#modalColaborador").modal('toggle');
                $.toast({
                    text:data.msg,
                    icon: "success",
                    loader: true,
                    loaderBg: '#c6c372',
                    position: 'top-right',
                    allowToastClose : true,
                });
                setTimeout(function (e) {
                    location.reload();
                }, 1200);

            } else if (data.code === 3) {
                $.toast({
                    text:data.msg,
                    icon: "info",
                    loader: true,
                    loaderBg: '#c6c372',
                    position: 'top-right',
                    allowToastClose : true,
                });

            } else if (data.code === 4) {
                $.toast({
                    text:data.msg,
                    icon: "info",
                    loader: true,
                    loaderBg: '#c6c372',
                    position: 'top-right',
                    allowToastClose : true,
                });

            }else {
                $.toast({
                    text:"Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.",
                    icon: "error",
                    loader: true,
                    loaderBg: '#c6c372',
                    position: 'top-right',
                    allowToastClose : true,
                });
            }
        }).fail(function (data) {
            $.toast({
                text:"Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.",
                icon: "error",
                loader: true,
                loaderBg: '#c6c372',
                position: 'top-right',
                allowToastClose : true,
            });
        }).always(function (e) {});
        
    });


    function ajaxInfoColaborador(colaboradorID){
        $.ajax({
            url: BASE_URL + "Personal/ajax_getInfoColaborador/"+colaboradorID ,
            type: "POST",
            async:true,
            cache:false,
            dataType: "json"
        }).done(function (data){

            if(data.response === "success"){
                $("#emp_EmpleadoID").val(data.result.emp_EmpleadoID);
                $("#emp_Nombre").val(data.result.emp_Nombre);
                $("#emp_Direccion").val(data.result.emp_Direccion);
                $("#emp_CodigoPostal").val(data.result.emp_CodigoPostal);
                $("#emp_EstadoID").val(data.result.emp_EstadoID);
                $("#emp_EstadoID").trigger('change');
                $("#emp_CiudadID").val(data.result.emp_CiudadID);
                cargarCuidades(data.result.emp_EstadoID,data.result.emp_CiudadID)
                $("#emp_Pais").val(data.result.emp_Pais);
                $("#emp_FechaNacimiento").val(data.result.emp_FechaNacimiento);
                $("#emp_Telefono").val(data.result.emp_Telefono);
                $("#emp_Celular").val(data.result.emp_Celular);
                $("#emp_Sexo").val(data.result.emp_Sexo);
                $("#emp_Sexo").trigger('change');
                $("#emp_EstadoCivil").val(data.result.emp_EstadoCivil);
                $("#emp_EstadoCivil").trigger('change');
                $("#emp_Curp").val(data.result.emp_Curp);
                $("#emp_Rfc").val(data.result.emp_Rfc);
                $("#emp_Nss").val(data.result.emp_Nss);
                $("#emp_TipoSangre").val(data.result.emp_TipoSangre);
                $("#emp_TipoSangre").trigger('change');
                $("#emp_Hijos").val(data.result.emp_Hijos);
                $("#emp_Hijos").trigger('change');
                $("#emp_NoHijos").val(data.result.emp_NoHijos);
                $("#emp_Estudios").val(data.result.emp_Estudios);
                $("#emp_Estudios").trigger('change');
                $("#emp_Titulo").val(data.result.emp_Titulo);
                $("#emp_Titulo").trigger('change');
                $("#emp_Carrera").val(data.result.emp_Carrera);
                $("#emp_Cedula").val(data.result.emp_Cedula);
                $("#emp_Institucion").val(data.result.emp_Institucion);
                $("#emp_Estudios2").val(data.result.emp_Estudios2);
                $("#emp_Cedula2").val(data.result.emp_Cedula2);
                $("#emp_Institucion2").val(data.result.emp_Institucion2);
                $("#emp_Estudios3").val(data.result.emp_Estudios3);
                $("#emp_Cedula3").val(data.result.emp_Cedula3);
                $("#emp_Institucion3").val(data.result.emp_Institucion3);
                $("#emp_Numero").val(data.result.emp_Numero);
                document.getElementById("emp_Numero").readOnly = false;
                
                $("#emp_FechaIngreso").val(data.result.emp_FechaIngreso);
                $("#selectSucursal").val(data.result.emp_SucursalID);
                $("#selectSucursal").trigger('change');
                $("#selectArea").val(data.result.emp_AreaID);
                $("#selectArea").trigger('change');
                $("#selectDepartamento").val(data.result.emp_DepartamentoID);
                $("#selectDepartamento").trigger('change');
                $("#selectPuesto").val(data.result.emp_PuestoID);
                $("#selectPuesto").trigger('change');
                $("#selhorario").val(data.result.emp_HorarioID);
                $("#selhorario").trigger('change');
                $("#selectJefe").val(data.result.emp_Jefe);
                $("#selectJefe").trigger('change');
                $("#selectRol").val(data.result.emp_Rol);
                $("#selectRol").trigger('change');
                $("#emp_SalarioMensual").val(data.result.emp_SalarioMensual);
                $("#emp_SalarioMensualIntegrado").val(data.result.emp_SalarioMensualIntegrado);
                $("#emp_EstatusContratacion").val(data.result.emp_EstatusContratacion);
                $("#emp_EstatusContratacion").trigger('change');
                $("#emp_TipoPrestaciones").val(data.result.emp_TipoPrestaciones);
                $("#emp_TipoPrestaciones").trigger('change');
                $("#emp_NombreEmergencia").val(data.result.emp_NombreEmergencia);
                $("#emp_NumeroEmergencia").val(data.result.emp_NumeroEmergencia);
                $("#emp_Parentesco").val(data.result.emp_Parentesco);
                $("#emp_NombreEmergencia2").val(data.result.emp_NombreEmergencia2);
                $("#emp_NumeroEmergencia2").val(data.result.emp_NumeroEmergencia2);
                $("#emp_Parentesco2").val(data.result.emp_Parentesco2);
                $("#emp_CtaVales").val(data.result.emp_CtaVales);
                $("#emp_FechaMatrimonio").val(data.result.emp_FechaMatrimonio);
                $("#emp_SalarioDiario").val(data.result.emp_SalarioDiario);
                $("#emp_SalarioDiarioIntegrado").val(data.result.emp_SalarioDiarioIntegrado);
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

});


