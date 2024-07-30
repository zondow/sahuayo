$(document).ready(function (e) {
    $(".select2").select2();

    var tblUsuarios =  $("#tblUsuarios").DataTable({
        destroy: true,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        fixedHeader: true,
        //scrollY: "200px",
        scrollCollapse: true,
        scrollX:        true,
        paging:         true,
        ajax: {
            url: BASE_URL + "MesaAyuda/ajax_getUsuariosMesa",
            dataType: "json",
            type: "POST",
        },
        columns: [
            { "data": "acciones", render: function(data,type,row){return acciones(data,type,row)}},
            { "data": "emp_Nombre"},
            { "data": "dep_Nombre"},
            { "data": "pue_Nombre"},
            { "data": "usu_Estatus", render: function(data,type,row){return estado(data,type,row)}},
        ],
        responsive:true,
        stateSave:false,
        dom:'<"row"<"col-md-4"l><"col-md-4 text-center"f><"col-md-4 cls-export-buttons"B>>rtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Usuarios',
                text: '<i class="fa fa-file-excel-o"></i>&nbsp;Excel',
                titleAttr: "Exportar a excel",
                className: "btn l-slategray",
                autoFilter: true,
                exportOptions: {
                    columns: ':visible'
                },
            },
            {
                extend: 'pdfHtml5',
                title: 'Usuarios',
                text: '<i class="fa fa-file-pdf-o"></i>&nbsp;PDF',
                titleAttr: "Exportar a PDF",
                className: "btn l-slategray",
                orientation: 'landscape',
                pageSize: 'LETTER',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'colvis',
                text: 'Columnas',
                className: "btn btn-light",
            }
        ],
        language: {
            paginate: {
                previous:"<i class='zmdi zmdi-caret-left'>",
                next:"<i class='zmdi zmdi-caret-right'>"
            },
            search: "_INPUT_",
            searchPlaceholder: "Buscar...",
            lengthMenu: "Registros por página _MENU_",
            info:"Mostrando _START_ a _END_ de _TOTAL_ registros",
            infoEmpty:"Mostrando 0 a 0 de 0 registros",
            zeroRecords: "No hay datos para mostrar",
            loadingRecords: "Cargando...",
            infoFiltered:"(filtrado de _MAX_ registros)"
        },
        "order": [[ 1, "asc" ]],
        "processing":true
    });

    function acciones(data,type,row){
        let output = '';
        let id = row.usu_UsuarioID;
        let estatus = row.usu_Estatus;
        if(estatus == 1){
            output += '<a href="#" class="btn btn-danger cambiarEstatus" data-id="' + id + '" data-estatus="' + estatus + '" title="Inactivar" ><i class="fas fa-minus-circle "></i></a>';
        }else{
            output += '<a href="#" class="btn btn-secondary cambiarEstatus" data-id="' + id + '" data-estatus="' + estatus + '" title="Activar" ><i class=" fas fa-plus-circle  "></i></a>';
        }
        return output;
    }//acciones

    function estado(data,type,row){
        var html = data;
        switch (data){
            case '1' :html = '<span class="badge badge-secondary p-1">Activo</span>';break;
            case '0' :html = '<span class="badge badge-danger p-1">Inactivo</span>';break;
        }//switch
        return html;
    }


    function limpiarForm() {
        $('#formUsuario')[0].reset();
        $("#emp_EmpleadoID").val(0).trigger('change');
    }

    $('body').on('click','.addUsuario',function(evt){
        evt.preventDefault();
        limpiarForm();
        $("#modalUsuario").modal('show');
    });

    $("#btnGuardar").click(function (e) {
        let usuario =$("#emp_EmpleadoID");
    
        if(usuario.val() != '' ) {
            let formData = $('#formUsuario').serialize();
            $.ajax({
                url: BASE_URL + "MesaAyuda/ajaxSaveUsuarioMesa",
                type: "POST",
                data: formData,
                dataType: "json",
                beforeSend: function () {
                    Swal.fire({
                        title: 'Generando usuario.',
                        text: 'Por favor espere mientras se guarda el usuario correspondiente.',
                        timer: 20000,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                            timerInterval = setInterval(() => {}, 1000);
                        },
                        onClose: () => {
                            clearInterval(timerInterval);
                        }
                    });
                }
            }).done(function (data) {
                if (data.code == 1){
                    tblUsuarios.ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Usuario agregado',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    $("#modalUsuario").modal('hide');
                }else if(data.code == 2){
                    Swal.fire({
                        icon: 'error',
                        title:'Usuario registrado anteriormente',
                        text: 'El colaborador seleccionado ya se encuentra activo en la mesa de ayuda.',
                        showConfirmButton: false,
                        timer: 3000
                    });
                  
                }else showNotification("error","Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.");
            }).fail(function () {
                showNotification("error","Ocurrido un error, por favor intente mas tarde.");
            });
        }else showNotification("warning","Por favor asigne la prioridad y seleccione la fecha de respuesta estimada.");
    });
    
    //Cambiar estatus 
    $("body").on("click",".cambiarEstatus",function (e) {
        let usuarioID = $(this).data("id");
        let estatus= $(this).data("estatus");
        
        if(estatus == 1) txt="inactivar";
        else txt="activar";

        Swal.fire({
            title: txt.charAt(0).toUpperCase()+txt.slice(1)+ ' usuario',
            text: '¿Esta seguro que desea '+txt+' el usuario seleccionado?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.value)
                ajax_EstatusMesa(usuarioID,estatus);
        })

    });

    function ajax_EstatusMesa(usuarioID,estatus){
        if(estatus == 1){
            txt='inactivado' ; txt2='inactivo'; es=0;
        }else{
            txt='activado'; txt2='activo';es=1;
        }

        $.ajax({
            url: BASE_URL+'MesaAyuda/ajaxEstatusUsuarioMesa',
            dataType: 'json',
            type: 'post',
            data: {usuarioID:usuarioID,estatus:es}
        }).done(function(data){
            if (data.code == 1){
                tblUsuarios.ajax.reload();
                Swal.fire({
                    icon: 'success',
                    title: 'Usuario '+txt+'',
                    text: 'Se '+txt2+' el acceso al usuario a la seccion de Mesa de ayuda.',
                    showConfirmButton: false,
                    timer: 2000
                })
            }else{
                $.toast({
                    text: "Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.",
                    icon: "error",
                    loader: true,
                    loaderBg: '#c6c372',
                    position: 'top-right',
                    allowToastClose : true,
                });
            }
        }).fail(function(data){
            $.toast({
                text: "Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.",
                icon: "error",
                loader: true,
                loaderBg: '#c6c372',
                position: 'top-right',
                allowToastClose : true,
            });
        }).always(function(e){
        });
    }



    function showNotification(tipo,msg){
        $.toast({
            text:msg,
            icon: tipo,
            loader: true,
            loaderBg: '#c6c372',
            position: 'top-right',
            allowToastClose : true,
        });
    }//showNotification
});
