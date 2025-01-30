$(document).ready(function (e) {
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
           
            { "data": "emp_Foto",render: function(data,type,row){return foto(data,type,row)}},
            { "data": "emp_Numero"},
            { "data": "acciones",render: function(data,type,row){return acciones(data,type,row)}},
            { "data": "emp_Nombre"},
            { "data": "jefe" },
            { "data": "emp_Correo" },
            { "data": "pue_Nombre"},
            { "data": "dep_Nombre" },
            { "data": "suc_Sucursal" },
            { "data": "emp_Direccion" },
            { "data": "emp_Curp" },
            { "data": "emp_Rfc" },
            { "data": "emp_Nss" },
            { "data": "emp_EstadoCivil" },
            { "data": "emp_FechaIngreso" },
            { "data": "emp_FechaNacimiento" },
            { "data": "emp_Telefono" },
            { "data": "emp_Celular" },
            { "data": "emp_Sexo" },
            { "data": "emp_SalarioMensual" },
            { "data": "emp_SalarioMensualIntegrado" },
            { "data": "emp_CodigoPostal" },
            { "data": "emp_Municipio" },
            { "data": "emp_EntidadFederativa" },
            { "data": "emp_Pais" },
            { "data": "emp_EstatusContratacion" },
            { "data": "emp_TipoPrestaciones" },
            { "data": "emp_Rol" },
            { "data": "emp_Horario" },
            { "data": "emp_NumeroEmergencia" },
            { "data": "emp_NombreEmergencia" },
            { "data": "emp_Parentesco" },
        ],
        columnDefs: [
            {targets:0,className: 'text-center'},
        ],
        dom:'<"row"<"col-md-4"l><"col-md-4 text-center"f><"col-md-4 cls-export-buttons"B>>rtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Empleados Activos',
                text: '<i class="zmdi zmdi-collection-text"></i>&nbsp;Excel',
                titleAttr: "Exportar a excel",
                className: "btn l-slategray btn-round",
                autoFilter: true,
                exportOptions: {
                    columns: ':visible'
                },
            },
            {
                extend: 'colvis',
                text: 'Columnas',
                className: "btn l-slategray btn-round",
            }
        ],
        responsive:true,
        stateSave:false,
        language: {
            paginate: {
                previous: "<i class='zmdi zmdi-chevron-left'>",
                next: "<i class='zmdi zmdi-chevron-right'>"
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
                "sNext":    "<i class='zmdi zmdi-chevron-right'>",
                "sPrevious": "<i class='zmdi zmdi-chevron-left'>"
            },
        },
        "order": [[ 1, "asc" ]],
        "processing":true,
        
    });

   // Agregar filtros de columna
$("#tblEmpleados thead tr").clone(true).appendTo("#tblEmpleados thead");
$("#tblEmpleados thead tr:eq(1) th").each(function(i) {
    if (i != 0) {  // No agregar filtro en la columna de imagen (emp_Foto)
        var title = $(this).text();
        $(this).html('<input type="text" class="column_filter" placeholder="Buscar ' + title + '" />');
        $('input', this).on('keyup change', function() {
            if (tblEmpleados.column(i).search() !== this.value) {
                tblEmpleados
                    .column(i)
                    .search(this.value)
                    .draw();
            }
        });
    }
});

// Asegurarse de que los inputs se muestran correctamente
$(window).on('resize', function() {
    // Recarga de la tabla después de un cambio en el tamaño de la ventana
    tblEmpleados.columns.adjust().draw();
});

    function acciones(data,type,row) {
        let button = '';
             button += '<div class="header">'+
             '<ul class="header-dropdown">' +
                '<li class="dropdown">' +
                    '<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">' +
                        '<i class="zmdi zmdi-more"></i>' +
                    '</a>' +
                
            '<ul class="dropdown-menu dropdown-menu-right">';

            if (revisarPermisos('Editar', 'empleados')) {
                button += '            <li><a class="editar" data-id="' + row['emp_EmpleadoID'] + '" href="#">Editar</a></li>';
            }
            if (revisarPermisos('Acceso', 'empleados')) {
                button += '            <li><a class="acceso" data-id="' + row['emp_EmpleadoID'] + '" href="#">Datos de acceso</a></li>';
            }
            if (revisarPermisos('Contratos', 'empleados')) {
                button += '            <li><a href="' + BASE_URL + 'Personal/contrato/' + row['emp_EmpleadoID'] + '">Contrato</a></li>';
            }
            if (revisarPermisos('Onboarding', 'empleados')) {
                button += '            <li><a class="onboarding" data-id="' + row['emp_EmpleadoID'] + '" href="#">Onboarding (entrada)</a></li>';
            }
            if (revisarPermisos('Expediente', 'empleados')) {
                button += '            <li><a href="' + BASE_URL + 'Personal/expediente/' + row['emp_EmpleadoID'] + '/usuario">Expediente</a></li>';
            }
            if (revisarPermisos('Baja', 'empleados')) {
                button += '            <li><a data-action="dar de baja al empleado seleccionado" href="#">Dar de baja</a></li>';
            }
            if (revisarPermisos('Suspender', 'empleados')) {
                button += '            <li><a class="activarSuspender" data-estado="' + row['emp_Estado'] + '" data-id="' + row['emp_EmpleadoID'] + '" href="#">Cambiar estado</a></li>';
            }
            if (revisarPermisos('Foto', 'empleados')) {
                button += '            <li><a class="btnModalFoto" data-id="' + row['emp_EmpleadoID'] + '" href="#">Foto</a></li>';
            }

            button += ' <li><a class="show-pdf" data-title="Kardex" href="' + BASE_URL + 'PDF/reporteIncidencias/' + row['emp_EmpleadoID'] + '">Kardex</a></li>';

            button+='</li></ul></div>';

        return button;
    }

    function foto(data,type,row) {
        let foto ='<img src="' + row['emp_Foto'] + '" class="rounded-circle avatar" data-lightbox="' + row['emp_Foto'] + '" data-title="" alt="">';
        return foto;
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

    //Subir foto
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
                        text: 'Por favor espere mientras se guarda la foto del colaborador.',
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