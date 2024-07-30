
$(document).ready(function (e) {

    $(".datepicker").datepicker({
        autoclose:!0,
        format: "yyyy-mm-dd",
        daysOfWeek:["D","L","M","M","J","V","S"],
        monthNames:["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],
        todayHighlight:!0
    });

    $('body').on('click', '.modal-colaborador', function(e) {
        e.preventDefault();
        $('#formColaborador')[0].reset();

        $('#tituloModal').html('Nuevo empleado');
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
        //$("#emp_TipoEmp").val(null).trigger('change')
        document.getElementById("emp_Numero").readOnly = false;
        $("#modalColaborador").modal("show");

    });

    $('body').on('click', '.editar', function(e) {
        e.preventDefault();
        $('#tituloModal').html('Editar empleado');

        let colaboradorID = $(this).data('id');
        $("#formColaborador")[0].reset();
        //document.getElementById("emp_Numero").readOnly = true;
        ajaxInfoColaborador(colaboradorID);
        $("#modalColaborador").modal("show");
    });

    var form = $("#formColaborador");
    var nombre = $("#emp_Nombre");
    var direccion = $("#emp_DireccionID");
    var sexo = $("#emp_Sexo");
    var fechaNacimiento = $("#emp_FechaNacimiento");
    var estadoCivil =$("#emp_EstadoCivil");
    var curp = $("#emp_Curp");
    var rfc = $("#emp_Rfc");
    var nss = $("#emp_Nss");
    var tipoSanguineo =$("#emp_TipoSangre");
    var hijos =$("#emp_Hijos");
    var estudios =$("#emp_Estudios");
    var numero = $("#emp_Numero");
    var fechaIngreso = $("#emp_FechaIngreso");
    var area = $("#selectArea");
    var departamento = $("#selectDepartamento");
    var puesto = $("#selectPuesto");
    var horario = $("#selhorario");
    var jefe = $("#selectJefe");
    var rol = $("#selectRol");
    var estatusContratacion =$("#emp_EstatusContratacion");
    var tipoPrestaciones =$("#emp_TipoPrestaciones");
    //var tipoEmp =$("#emp_TipoEmp");
    var nombreEmergencia =$("#emp_NombreEmergencia");
    var numeroEmergencia =$("#emp_NumeroEmergecia");
    var emp_Parentesco =$("#emp_Parentesco");
    var nombreEmergencia2 =$("#emp_NombreEmergencia2");
    var numeroEmergencia2 =$("#emp_NumeroEmergecia2");
    var emp_Parentesco2 =$("#emp_Parentesco2");

    var salMensual = $("#emp_SalarioMensual");
    var salMensualIntegrado = $("#emp_SalarioMensualIntegrado");

    var idChecador=$("#emp_ChecadorID");

    var salDiario = $("#emp_SalarioDiario");
    var salDiarioIntegrado = $("#emp_SalarioDiarioIntegrado");
    //var numSocio=$("#emp_NumSocio");
    //var numNomina=$("#emp_NumeroNomina");
    //var colonia=$("#emp_Colonia");

    $('body').on('click', '.bntGuardarEmpleado', function(evt) {
        evt.preventDefault();
        /*if(nombre.val() !== "" &&  direccion.val()!=="" && sexo.val() !== "" && fechaNacimiento.val() !== "" && estadoCivil.val()!==""
            && curp.val() !== "" && rfc.val() !== "" && nss.val()!==""
            && numero.val()!=="" && fechaIngreso.val() !== "" && area.val()!=="" && departamento.val()!=="" && puesto.val() !== ""
            && horario.val() !== "" && jefe.val()!=="" && rol.val() !== "" && estatusContratacion.val() !== "" && tipoPrestaciones.val()!==""
            && $("#emp_SucursalID").val() !== "" && idChecador.val() !== "" && salMensual.val() !== "" && salMensualIntegrado.val() !== ""
            && salDiario.val() !== "" && salDiarioIntegrado.val() !== "" /*&& numSocio.val() !== "" && numNomina.val() !== "" && tipoEmp.val() !==""*/
        //) {

            $.ajax({
                url: BASE_URL + "Personal/ajax_saveColaborador",
                type: "POST",
                data: form.serialize(),
                dataType: "json"
            }).done(function (data) {
                //location.reload()
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
            }).always(function (e) {});//ajax
        /*}else{
            $.toast({
                text:"Por favor llene los campos requeridos.",
                icon: "error",
                loader: true,
                loaderBg: '#c6c372',
                position: 'top-right',
                allowToastClose : true,
            });
        }*/
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
                $("#emp_EntidadFederativa").val(data.result.emp_EntidadFederativa);
                $("#emp_EntidadFederativa").select2().trigger('change');
                setTimeout(function () {
                    $("#emp_Municipio").val(data.result.emp_Municipio);
                    $("#emp_Municipio").select2().trigger('change');
                },300);
                $("#emp_Pais").val(data.result.emp_Pais);
                $("#emp_FechaNacimiento").val(data.result.emp_FechaNacimiento);
                $("#emp_Telefono").val(data.result.emp_Telefono);
                $("#emp_Celular").val(data.result.emp_Celular);
                $("#emp_Sexo").val(data.result.emp_Sexo);
                $("#emp_Sexo").select2().trigger('change');
                $("#emp_EstadoCivil").val(data.result.emp_EstadoCivil);
                $("#emp_EstadoCivil").select2().trigger('change');
                $("#emp_Curp").val(data.result.emp_Curp);
                $("#emp_Rfc").val(data.result.emp_Rfc);
                $("#emp_Nss").val(data.result.emp_Nss);
                $("#emp_TipoSangre").val(data.result.emp_TipoSangre);
                $("#emp_Hijos").val(data.result.emp_Hijos);
                $("#emp_NoHijos").val(data.result.emp_NoHijos);
                $("#emp_Estudios").val(data.result.emp_Estudios);
                $("#emp_Estudios").select2().trigger('change');
                $("#emp_Titulo").val(data.result.emp_Titulo);
                $("#emp_Titulo").select2().trigger('change');
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
                /*if(data.result.emp_Numero!=''){
                    document.getElementById("emp_Numero").readOnly = true;
                }else{*/
                    document.getElementById("emp_Numero").readOnly = false;
                //}
                /*
                $("#emp_NumeroNomina").val(data.result.emp_NumeroNomina);
                if(data.result.emp_NumeroNomina!=''){
                    document.getElementById("emp_NumeroNomina").readOnly = true;
                }else{
                    document.getElementById("emp_NumeroNomina").readOnly = false;
                }*/
                //Seccion ID del Checador (read Only)
                /*$("#emp_ChecadorID").val(data.result.emp_ChecadorID);
                if(data.result.emp_ChecadorID!=''){
                    document.getElementById("emp_ChecadorID").readOnly = true;
                }else{
                    document.getElementById("emp_ChecadorID").readOnly = false;
                }*/
                $("#emp_FechaIngreso").val(data.result.emp_FechaIngreso);
                $("#selectSucursal").val(data.result.emp_SucursalID);
                $("#selectSucursal").select2().trigger('change');
                $("#selectArea").val(data.result.emp_AreaID);
                $("#selectArea").select2().trigger('change');
                $("#selectDepartamento").val(data.result.emp_DepartamentoID);
                $("#selectDepartamento").select2().trigger('change');
                $("#selectPuesto").val(data.result.emp_PuestoID);
                $("#selectPuesto").select2().trigger('change');
                $("#selhorario").val(data.result.emp_HorarioID);
                $("#selhorario").select2().trigger('change');
                $("#selectJefe").val(data.result.emp_Jefe);
                $("#selectJefe").select2().trigger('change');
                $("#selectRol").val(data.result.emp_Rol);
                $("#selectRol").select2().trigger('change');
                $("#emp_SalarioMensual").val(data.result.emp_SalarioMensual);
                $("#emp_SalarioMensualIntegrado").val(data.result.emp_SalarioMensualIntegrado);
                $("#emp_EstatusContratacion").val(data.result.emp_EstatusContratacion);
                $("#emp_EstatusContratacion").select2().trigger('change');
                $("#emp_TipoPrestaciones").val(data.result.emp_TipoPrestaciones);
                $("#emp_TipoPrestaciones").select2().trigger('change');
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
                //$("#emp_SBC").val(data.result.emp_SBC);
                //$("#emp_Colonia").val(data.result.emp_Colonia);
                //$("#emp_NumSocio").val(data.result.emp_NumSocio);
                //$("#emp_TipoEmp").val(data.result.emp_TipoEmp);
                //$("#emp_TipoEmp").select2().trigger('change');
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


    var tblEmpleados = $("#tblEmpleados").DataTable({
        destroy: true,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        ajax: {
            url: BASE_URL + "Personal/ajax_getEmpleadosActivos",
            dataType: "json",
            type: "POST",
            "processing": true,
            "serverSide": true
        },
        columns: [
            { "data": "acciones",render: function(data,type,row){return acciones(data,type,row)}},
            { "data": "emp_Numero"},
            { "data": "emp_Nombre"},
            { "data": "pue_Nombre" },
            { "data": "are_Nombre" },
            { "data": "dep_Nombre"},
            { "data": "suc_Sucursal" },
            { "data": "emp_Rfc" },
            { "data": "emp_Correo" },
            { "data": "emp_Celular" },
            { "data": "emp_Estado" },
        ],
        columnDefs: [
            {targets:0,className: 'text-center'},
        ],
        dom:'<"row"<"col-md-4"l><"col-md-4 text-center"f><"col-md-4 cls-export-buttons"B>>rtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Empleados Activos',
                text: '<i class="fa fa-file-excel-o"></i>&nbsp;Excel',
                titleAttr: "Exportar a excel",
                className: "btn l-slategray",
                autoFilter: true,
                exportOptions: {
                    columns: ':visible'
                },
            },
            {
                extend: 'colvis',
                text: 'Columnas',
                className: "btn btn-light",
            }
        ],
        responsive:true,
        stateSave:false,
        language: {
            paginate: {
                previous: "<i class='mdi mdi-chevron-left'>",
                next: "<i class='mdi mdi-chevron-right'>"
            },
            search: "_INPUT_",
            searchPlaceholder: "Buscar...",
            lengthMenu: "Registros por página _MENU_",
            info:"Mostrando _START_ a _END_ de _TOTAL_ registros",
            infoEmpty:"Mostrando 0 a 0 de 0 registros",
            zeroRecords: "No hay datos para mostrar",
            loadingRecords: "Cargando...",
            infoFiltered:"(filtrado de _MAX_ registros)",
            "processing": "Procesando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":    "<i class='mdi mdi-chevron-right'>",
                "sPrevious": "<i class='zmdi zmdi-caret-left'>"
            },
        },
        "order": [[ 1, "asc" ]],
        "processing":true,
        /*drawCallback: function () {
            $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
        }*/
    });

    function acciones(data,type,row) {
        let button = '';

        button+='<div class="btn-group">\n' +
            '        <button type="button" class="btn btn-light dropdown-toggle waves-effect" data-toggle="dropdown" aria-expanded="false"> Acciones <i class="mdi mdi-chevron-down"></i> </button>\n' +
            '        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1" x-placement="bottom-start" >\n';
            if(revisarPermisos('Editar','empleados')) {
                button+='            <a class="dropdown-item editar"  data-id="' + row['emp_EmpleadoID'] + '" href="#">Editar</a>\n';
            }
            if(revisarPermisos('Acceso','empleados')) {
                button+='            <a class="dropdown-item acceso" data-id="' + row['emp_EmpleadoID'] + '" href="#">Datos de acceso</a> \n';
            }
            if(revisarPermisos('Contratos','empleados')) {
                 button+='            <a class="dropdown-item" href="'+BASE_URL+'Personal/contrato/'+ row['emp_EmpleadoID']+'">Contrato</a>\n' ;
            }
            if(revisarPermisos('Onboarding','empleados')) {
                button+='            <a class="dropdown-item " href="'+BASE_URL+'Personal/onboarding/'+ row['emp_EmpleadoID']+'">Onboarding (entrada) </a>\n' ;
            }
            if(revisarPermisos('Expediente','empleados')) {
                button+='            <a class="dropdown-item" href="'+BASE_URL+'Personal/expediente/'+ row['emp_EmpleadoID']+'/usuario">Expediente</a>\n';
            }
            if(revisarPermisos('Baja','empleados')) {
                button+='            <a class="dropdown-item" data-action="dar de baja al empleado seleccionado" href="">Dar de baja</a>\n';
            }
            if(revisarPermisos('Suspender','empleados')) {
                button+='            <a class="dropdown-item activarSuspender" data-estado="' + row['emp_Estado'] + '" data-id="' + row['emp_EmpleadoID'] + '"  href="">Cambiar estado</a>\n';
            }
            if(revisarPermisos('Foto','empleados')) {
                button+='            <a class="dropdown-item btnModalFoto" data-id="' + row['emp_EmpleadoID'] + '"  href="">Foto</a>\n';
            }
            button+='<a class="dropdown-item show-pdf" data-title="Kardex" href="'+BASE_URL+'PDF/reporteIncidencias/'+row['emp_EmpleadoID']+'" >Kardex</a>';
            button+='     </div>\n</div>';

        return button;
    }

    ////Cambiar estado del colaborador ////
    $("body").on("click",".activarSuspender",function (e) {
        var empleadoID = $(this).data("id");
        var estado = $(this).data("estado");

        if(estado==='Activo'){
            txt='¿Estás seguro que deseas suspender la cuenta del empleado seleccionado ?';
            est='Suspendido';
        } else if(estado==='Suspendido'){
            txt='¿Estás seguro que deseas activar la cuenta del empleado seleccionado ?';
            est='Activo';
        }

        let fd  = {"empleadoID":empleadoID,"estado":est};
        Swal.fire({
            title: '',
            text: txt,
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#f72800",
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if(result.value)
                ajaxCambiarEstado(fd);
        })
    });

    function ajaxCambiarEstado(fd){
        $.ajax({
            url: BASE_URL + "Personal/ajaxCambiarEstadoEmpleado",
            cache: false,
            type: 'post',
            dataType: 'json',
            data:fd
        }).done(function (data) {
            if(data.code === 1) {
                $.toast({
                    text:'Se cambio el estado del empleado seleccionado.',
                    icon: "success",
                    loader: true,
                    loaderBg: '#c6c372',
                    position: 'top-right',
                    allowToastClose : true,
                });
                setTimeout(function (e) {
                    location.reload();
                }, 1200);
            }
            else {
                $.toast({text: "¡Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.!", icon: "error", loader: false, position: 'top-right',allowToastClose : false});
            }

        }).fail(function (data) {
            $.toast({text: "¡Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.!", icon: "error", loader: false, position: 'top-right',allowToastClose : false});
        }).always(function (e) {

        });//ajax
    }


    /// Subir foto al colaborador///
    $('body').on('click', '.btnModalFoto', function(e) {
        e.preventDefault();
        let colaboradorID = $(this).data('id');
        $("#FEID").val(colaboradorID)
        $("#modalFotoColaborador").modal("show");
    });

    //Subir convocatoria
    var bntGuardarFoto= $("#bntGuardarFoto");
    var frmFotoColaborador = $("#frmFotoColaborador");

    bntGuardarFoto.click(function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        if($("#fileFotoEmpleado").val() !== '' ){

            var form = frmFotoColaborador[0];
            var dataForm = new FormData(form);
            var empleadoID=$("#FEID").val();

            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: BASE_URL + "Personal/ajaxSubirFotoEmpleado/"+empleadoID,
                data: dataForm,
                processData: false,
                contentType: false,
                cache: false,
                dataType: "json",
                beforeSend: function () {
                    Swal.fire({
                        title: 'Guardando fotografía.',
                        text: 'Por favor espere mientras guardamos la foto del empleado.',
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
                $("#fileFotoEmpleado").val('');
                if (data.code === 1) {
                    swal.fire({
                        title: "¡Foto guardada exitosamente!",
                        text: "",
                        icon: 'success',
                    }).then(() => {

                        location.reload();
                    });

                } else {
                    swal.fire({
                        title: '¡Tuvimos un problema!',
                        type: 'error',
                        text: 'Ocurrio un error al tratar de guardar la foto,por favor intente de nuevo.',
                    }).then(() => {
                        location.reload();
                    });
                }
            });
        }else{
            $.toast({
                text: "Asegurece de que haya seleccionado un archivo. Intente nuevamente.",
                icon: "warning",
                loader: true,
                loaderBg: '#c6c372',
                position: 'top-right',
                allowToastClose: true,
            });
        }
    });


});


