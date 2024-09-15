$(document).ready(function(e) {

    $(".select2-multiple").select2({
        language: "es",
        selectOnClose: false,
        allowClear: true,
        placeholder: " Seleccione",

    });

    $(".select2").select2();


    var tblPoliticas = $("#tblPoliticas").DataTable({
        destroy: true,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        ajax: {
            url: BASE_URL + "Comunicados/ajax_getPoliticas",
            dataType: "json",
            type: "POST",
            "processing": true,
        },
        columns: [
            { "data": "acciones",render: function(data,type,row){return acciones(data,type,row)}},
            { "data": "no"},
            { "data": "nombre"},
            { "data": "documento"},
            { "data": "puestos"},
            { "data": "estatus",render: function(data,type,row){return estado(data,type,row)}},
        ],
        columnDefs: [
            {targets:0,className: 'text-center'},
        ],
        dom:'<"row"<"col-md-6"l><"col-md-6 text-center"f><"col-md-6 cls-export-buttons"B>>rtip',
        responsive:true,
        stateSave:false,
        language: {
            paginate: {
                previous: "<i class='zmdi zmdi-caret-left'>",
                next: "<i class='zmdi zmdi-caret-right'>"
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
                "sNext":    "<i class='zmdi zmdi-caret-right'>",
                "sPrevious": "<i class='zmdi zmdi-caret-left'>"
            },
        },
        "order": [[ 3, "desc" ]],
        "processing":true,

    });

    function acciones(data,type,row){
        let button = '';
        if(revisarPermisos('Editar','normativaInterna'))
            button+=' <a type="button" class="btn btn-info waves-effect waves-light editarPolitica" title="Editar politica" data-id="'+row['id']+'" style="color:#FFFFFF"><i class="fa fa-edit"></i> </a>';
        if(revisarPermisos('Documentos','normativaInterna'))
            button+=' <a type="button" class="btn btn-warning waves-effect waves-light historialPolitica" title="Historial de documentos" data-id="'+row['id']+'" style="color:#FFFFFF"><i class="far fa-folder-open"></i> </a><br>';
        if(revisarPermisos('Cambios','normativaInterna'))
        button+=' <a type="button" class="btn btn-secondary waves-effect waves-light cambiosPolitica" title="Historial de cambios" data-id="'+row['id']+'" style="color:#FFFFFF"><i class=" fas fa-history"></i> </a><br>';
        button+=' <a type="button" class="btn btn-dark waves-effect waves-light colaboradoresPolitica" title="Colaboradores" data-id="'+row['id']+'" style="color:#FFFFFF"><i class=" fa fa-users"></i> </a><br>';
        return button;
    }

    function estado(data,type,row){

        if(revisarPermisos('Eliminar','normativaInterna'))
        return row['estatus'] === 1 ?
            '<a class="badge badge-success activarInactivar" data-id="'+row['id']+'" data-estado="'+row['estatus']+'"  title="Click para cambiar estatus" style="color: #ffffff">Activo</a>' :
            '<a class="badge badge-danger activarInactivar" data-id="'+row['id']+'" data-estado="'+row['estatus']+'" title="Click para cambiar estatus" style="color: #ffffff">Inactivo</a>';
    }

    var form = $("#form");
    var nombre = $("#pol_Nombre");
    var archivo = $("#filePolitica");
    var puestos = $("#pol_Puestos");
    var modal = $("#modalPolitica");
    var btnGuardar= $("#guardar");


    $("body").on("click",".btnModalPolitica",function (e) {
        e.preventDefault();
        form[0].reset();

        puestos.select2('').trigger('change');
        $("#titleModal").html('Nueva política / reglamento');
        $("#pol_PoliticaID").val(0);
        modal.modal("show");
    });


    btnGuardar.click(function (e){
        e.preventDefault();
        e.stopImmediatePropagation();

        if(archivo.val() !== "") {

            $.ajax({
                enctype: "multipart/form-data",
                url: BASE_URL + "Comunicados/ajax_savePolitica",
                type: "post",
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                data:new FormData(document.getElementById('form'))
            }).done(function (data) {
                if (data.code === 1) {
                    tblPoliticas.ajax.reload();
                    modal.modal('toggle');

                    $.toast({
                        text: "La politica se guardo correctamente.",
                        icon: "success",
                        loader: true,
                        loaderBg: '#c6c372',
                        position: 'top-right',
                        allowToastClose: true,
                    });
                }else if (data.code === 2) {
                    tblPoliticas.ajax.reload();
                    modal.modal('toggle');

                    $.toast({
                        text: "La información se actualizo correctamente.",
                        icon: "success",
                        loader: true,
                        loaderBg: '#c6c372',
                        position: 'top-right',
                        allowToastClose: true,
                    });
                }else if (data.code === 0) {
                    $.toast({
                        text: "Por favor llene los campos requeridos.",
                        icon: "warning",
                        loader: true,
                        loaderBg: '#c6c372',
                        position: 'top-right',
                        allowToastClose: true,
                    });
                }else{
                    $.toast({
                        text: "Ocurrio un problema al tartar de guardar, por favor intente nuevamente.",
                        icon: "error",
                        loader: true,
                        loaderBg: '#c6c372',
                        position: 'top-right',
                        allowToastClose: true,
                    });
                }
            }).fail(function () {
                $.toast({
                    text: "Ocurrido un error, por favor intente mas tarde.",
                    icon: "error",
                    loader: true,
                    loaderBg: '#c6c372',
                    position: 'top-right',
                    allowToastClose: true,
                });
            });
        }else{
            $.toast({
                text: "Por favor llene los campos requeridos.",
                icon: "warning",
                loader: true,
                loaderBg: '#c6c372',
                position: 'top-right',
                allowToastClose: true,
            });
        }
    });


    $('body').on('click', '.editarPolitica', function(e) {
        e.preventDefault();
        form[0].reset();
        puestos.select2('').trigger('change');
        $("#titleModal").html('Editar política / reglamento');
        let politicaID = $(this).data('id');
        getInfoPolitica(politicaID);
        modal.modal("show");

    });

    function getInfoPolitica(politicaID){
        form[0].reset();
        $.ajax({
            url: BASE_URL + "Comunicados/ajax_getInfoPolitica" ,
            type: "POST",
            dataType: "json",
            data:'idPolitica='+politicaID
        }).done(function (data){
            if(data.code === 1){
                $("#pol_PoliticaID").val(data.result.pol_PoliticaID);
                $("#pol_Nombre").val(data.result.pol_Nombre);
                let puesto = JSON.parse(data.result.pol_Puestos);
                $("#pol_Puestos").val(puesto).trigger('change');

            }else{
                $.toast({
                    text: "Ocurrido un problema al consultar la información, por favor intente nuevamente.",
                    icon: "error",
                    loader: true,
                    loaderBg: '#c6c372',
                    position: 'top-right',
                    allowToastClose : true,
                });
            }
        }).fail(function () {
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


    $("body").on("click",".activarInactivar",function (e) {
        var politicaID = $(this).data("id");
        var estado = $(this).data("estado");

        if(estado===1){
            txt='¿Estás seguro que deseas inactivar la política seleccionada?';
            est=0;
        } else if(estado===0){
            txt='¿Estás seguro que deseas activar la política seleccionada?';
            est=1;
        }

        let fd  = {"politicaID":politicaID,"estado":est};
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
            url: BASE_URL + "Comunicados/ajaxCambiarEstadoPolitica",
            cache: false,
            type: 'post',
            dataType: 'json',
            data:fd
        }).done(function (data) {
            if(data.code === 1) {
                tblPoliticas.ajax.reload();
                $.toast({
                    text:'Se cambio el estado de la pólitica seleccionada.',
                    icon: "success",
                    loader: true,
                    loaderBg: '#c6c372',
                    position: 'top-right',
                    allowToastClose : true,
                });
            }
            else {
                $.toast({text: "¡Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.!", icon: "error", loader: false, position: 'top-right',allowToastClose : false});
            }

        }).fail(function (data) {
            $.toast({text: "¡Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.!", icon: "error", loader: false, position: 'top-right',allowToastClose : false});
        }).always(function (e) {

        });//ajax
    }

    let modalCambios=$("#modalCambios");
    $('body').on('click', '.cambiosPolitica', function(e) {
        e.preventDefault();
        $("#formCambios")[0].reset();
        let politicaID = $(this).data('id');
        getCambiosPolitca(politicaID);
        modalCambios.modal("show");
    });

    function getCambiosPolitca(politicaID){
        $.ajax({
            url: BASE_URL + "Comunicados/ajax_getCombiosPolitica" ,
            type: "POST",
            data:"politicaID="+politicaID,
            dataType: "json"
        }).done(function (data){
            if(data.response === "success"){
                $('#politicaID').val(data.info.pol_PoliticaID);
                if(data.info.pol_Cambios !== ""){
                    $('#pol_Cambios').summernote('code',data.info.pol_Cambios);
                }else{
                    $('#pol_Cambios').summernote();
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


    $('#pol_Cambios').summernote({
        //placeholder: 'Hello bootstrap 4',
        tabsize: 2,
        height: 400,
        lang: 'es-ES' // default: 'en-US'
    });
    let modalHistorialDoctos=$("#modalHistDoctos");
    $('body').on('click', '.historialPolitica', function(e) {
        e.preventDefault();
        let politicaID = $(this).data('id');
        gethistorialPolitca(politicaID);
        modalHistorialDoctos.modal("show");
    });


    function gethistorialPolitca(politicaID){
        $("#historial").empty();
        $.ajax({
            url: BASE_URL + "Comunicados/ajax_getHistorialPolitica" ,
            type: "POST",
            data:"politicaID="+politicaID,
            dataType: "json"
        }).done(function (data){

            $("#historial").html(data.historial);

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

    //Borrar documento
    $('body').on('click', '.borrarDocto',function(evt){
        evt.preventDefault();
        $politicaID=$(this).data('id');
        $archivo=$(this).data('archivo');
        var post = {}
        post.$politicaID=$politicaID;
        post.$archivo=$archivo;

        $.ajax({
            url: BASE_URL + "Comunicados/ajax_borrarDocumentoPolitica",
            type: "POST",
            data: post,
            success: function(data){

                datos=JSON.parse(data);

                if(datos.response==="success"){
                    $.toast({
                        text: "Documento borrado",
                        icon: "success",
                        loader: true,
                        loaderBg: '#c6c372',
                        position: 'top-right',
                        allowToastClose : true,
                    });

                    gethistorialPolitca($politicaID);
                    tblPoliticas.ajax.reload();

                }
            }
        });

    });



    $("body").on("click",".btnModalComCambios",function (e) {
        e.preventDefault();
        $("#modalNotifCambios").modal("show");
        getPoliticas();
    });

    function getPoliticas(){
        $("#pol_Politicas").empty();
        $.ajax({
            url: BASE_URL+"Comunicados/ajax_getPoliticasSel",
            method:'post',
            dataType: 'json',
        }).done(function (data) {
            console.log
            var $row ='';
            $.each(data.info, function (key, value) {
                $row += "<option value='" + value.pol_PoliticaID + "'>" + value.pol_Nombre + "</option>";
            });
            $("#pol_Politicas").append($row);
            $("#pol_Politicas").trigger('change');
        });
    }

    $("body").on("click", "#btnNotifCambios", function (evt) {
        evt.preventDefault();
        let politicas = $("#pol_Politicas").val();
        swal.fire({
            title: '<strong>Confirmación</strong>',
            icon: 'question',
            text: '¿Esta seguro que desea notificar el cambio de las normativas a los puestos correpondientes?',
            showCancelButton:true,
            closeOnConfirm: false,
            cancelButtonText: ' Cerrar',
        }).then((result) => {
            if (result.value) {
                enviarComunicado(politicas);
            }
        });
    });

    function enviarComunicado(politicas){
        $.ajax({
            type: "POST",
            url: BASE_URL + "Comunicados/ajaxEnviarNotiCambioPoliticas",
            data: 'politicas='+politicas,
            dataType: "json",
            beforeSend: function () {
                swal.fire({
                    title: 'Enviando la notificacion de cambio.',
                    text: 'Por favor espere mientras se envian los correos correspondientes.',
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
            if (data.response === 1) {
                swal.fire({
                    title: "¡Correos enviados exitosamente!",
                    text: "",
                    icon: 'success',
                }).then(() => {

                    location.reload();
                });

            } else {
                swal.fire({
                    title: '¡Tuvimos un problema!',
                    type: 'error',
                    text: 'Ocurrio un error al tratar de enviar los correos,por favor intente de nuevo.',
                }).then(() => {
                    location.reload();
                });
            }
        });
    }


    $("body").on("click", ".colaboradoresPolitica", function (evt) {
        evt.preventDefault();
        politicaID=$(this).data('id');
        getColaboradores(politicaID);
        $("#modalRemitentes").modal('show');
    });


    function getColaboradores(politicaID){
        var tblColaboradores = $("#tableColaboradores").DataTable({
            destroy: true,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            ajax: {
                url: BASE_URL + "Comunicados/ajax_getColaboradoresPolitica/"+politicaID,
                dataType: "json",
                type: "POST",
                "processing": true,
            },
            columns: [
                { "data": "numero"},
                { "data": "emp_Nombre"},
                { "data": "visto"},
                { "data": "enterado"},
            ],
            columnDefs: [
                {targets:0,className: 'text-center'},
            ],
            dom:'<"row"<"col-md-6"l><"col-md-6 text-center"f><"col-md-6 cls-export-buttons"B>>rtip',
            responsive:true,
            stateSave:false,
            language: {
                paginate: {
                    previous: "<i class='zmdi zmdi-caret-left'>",
                    next: "<i class='zmdi zmdi-caret-right'>"
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
                    "sNext":    "<i class='zmdi zmdi-caret-right'>",
                    "sPrevious": "<i class='zmdi zmdi-caret-left'>"
                },
            },
            "order": [[ 0, "asc" ]],
            "processing":true,

        });
    }



    $("body").on('keydown', '.numeric', function(e){
        var key = e.which;
        if ((key >= 48 && key <= 57) ||         //standard digits
            (key >= 96 && key <= 105) ||        //digits (numeric keyboard)
            key === 190 || //.
            key === 110 ||  //. (numeric keyboard)
            key === 8 || //retorno de carro
            key === 37 || // <--
            key === 39 || // -->
            key === 46 || //Supr
            key === 173 || //-
            key === 109 || //- (numeric keyboard)
            key === 9 //Tab
        ){
            return true;
        }//if
        return false;
    });//.numeric.keyup


});