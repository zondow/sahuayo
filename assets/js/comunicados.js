$(document).ready(function(e) {

    $('#com_Descripcion').summernote({
        tabsize: 2,
        height: 300,
        lang: 'es-ES' // default: 'en-US'
    });

    $(".select2-multiple").select2({
        language: "es",
        selectOnClose: false,
        allowClear: true,
        placeholder: " Seleccione",

    });


    var tblComunicados = $("#datatableComunicados").DataTable({
        destroy: true,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
        ajax: {
            url: BASE_URL + "Comunicados/ajax_getComunicados",
            dataType: "json",
            type: "POST",
            "processing": true,
        },
        columns: [
            { "data": "acciones",render: function(data,type,row){return acciones(data,type,row)}},
            { "data": "com_Estado",render: function(data,type,row){return estado(data,type,row)}},
            { "data": "com_Asunto"},
            { "data": "com_Fecha"},
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
        if(row['com_Estado'] === 'Creado'){
            button+=' <a type="button" class="btn btn-danger waves-effect waves-light eliminarComunicado" title="Eliminar comunicado" data-id="'+row['com_ComunicadoID']+'" style="color:#FFFFFF"><i class="fa fa-trash"></i> </a>';
            button+=' <a type="button" class="btn btn-primary waves-effect waves-light enviarComunicado" title="Enviar comunicado" data-id="'+row['com_ComunicadoID']+'" style="color:#FFFFFF"><i class="zmdi zmdi-mail-send"></i> </a>';
        }
        button+=' <a type="button" class="btn btn-warning waves-effect waves-light verComunicado" title="Ver comunicado" data-id="'+row['com_ComunicadoID']+'" style="color:#FFFFFF"><i class="fa fa-eye"></i> </a>';
        button+=' <a type="button" class="btn btn-info waves-effect waves-light verRemitentes" title="Ver destinatarios" data-id="'+row['com_ComunicadoID']+'" style="color:#FFFFFF"><i class="fa fa-users"></i> </a><br>';
        return button;
    }

    function estado(data,type,row){

            return row['com_Estado'] === 'Creado' ?
                '<span class="badge badge-info ">Creado</span>' :
                '<span class="badge badge-success ">Enviado</span>';
    }

    var form = $("#formComunicado");
    var asunto = $("#com_Asunto");
    var descripcion = $("#com_Descripcion");

    var empleados = $("#com_Empleados");
    var modalComunicado = $("#modalComunicado");
    var btnGuardar= $("#btnGuardar");

    var divFiltros=$("#filtros");
    divFiltros.hide();

    $("body").on("click",".btnComunicado",function (e) {
        e.preventDefault();
        form[0].reset();

        descripcion.summernote("");
        modalComunicado.modal("show");
    });

    $("#divColaboradores").hide();
    $("body").on("change","#filtro",function (e){
        e.preventDefault();
        tipo= $("#filtro").val();
        if(tipo === 'empleados'){
            $("#divColaboradores").hide();
            $("#com_Empleados").prop('required',false);
        }else{
            $("#divColaboradores").show();
            $("#com_Empleados").prop('required',true);
        }

    });

    btnGuardar.click(function (e){
        e.preventDefault();

        if(asunto.val() !== "" || descripcion.val() !== "" ) {

            $.ajax({
                url: BASE_URL + "Comunicados/ajax_saveComunicado",
                type: "post",
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                data:new FormData(document.getElementById('formComunicado'))
            }).done(function (data) {
                if (data.code === 1) {
                    tblComunicados.ajax.reload();
                    modalComunicado.modal('toggle');

                    $.toast({
                        text: "El comunicado se creo correctamente.",
                        icon: "success",
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




    $("body").on("click",".verRemitentes",function (e) {
        e.preventDefault();
        let comunicadoID = $(this).data('id');
        getRemitentes(comunicadoID);
        $("#modalRemitentes").modal("show");
    });

    function getRemitentes(comunicadoID){
        var tblRemitentes = $("#tableRemitentes").DataTable({
            destroy: true,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            ajax: {
                url: BASE_URL + "Comunicados/ajax_getRemitentesComunicados/"+comunicadoID,
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

    $("body").on("click", ".enviarComunicado", function (evt) {
        evt.preventDefault();
        let idComunicado=$(this).data('id');

        swal.fire({
            title: '<strong>Confirmación</strong>',
            icon: 'question',
            text: '¿Esta seguro que desea enviar el comunicado?',
            showCancelButton:true,
            closeOnConfirm: false,
            cancelButtonText: ' Cerrar',
        }).then((result) => {
            if (result.value) {
                enviarComunicado(idComunicado);
            }
        });
    });

    function enviarComunicado(idComunicado){
        $.ajax({
            type: "POST",
            url: BASE_URL + "Comunicados/ajaxEnviarComunicado",
            data: 'idComunicado='+idComunicado,
            dataType: "json",
            beforeSend: function () {
                swal.fire({
                    title: 'Enviando el comunicado.',
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
                    title: "¡Comunicado enviado exitosamente!",
                    text: "",
                    icon: 'success',
                }).then(() => {

                    location.reload();
                });

            } else {
                swal.fire({
                    title: '¡Tuvimos un problema!',
                    type: 'error',
                    text: 'Ocurrio un error al tratar de enviar el comunicado,por favor intente de nuevo.',
                }).then(() => {
                    location.reload();
                });
            }
        });
    }


    $("body").on("click",".eliminarComunicado",function (e) {
        var comunicadoID = $(this).data("id");
        let fd  = {"comunicadoID":comunicadoID};
        Swal.fire({
            title: '',
            text: '¿Esta seguro que desea eliminar el comunicado?',
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#f72800",
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if(result.value)
                ajaxEliminarComunicado(fd);
        })
    });

    function ajaxEliminarComunicado(fd){
        $.ajax({
            url: BASE_URL + "Comunicados/ajaxEliminarComunicado",
            cache: false,
            type: 'post',
            dataType: 'json',
            data:fd
        }).done(function (data) {
            if(data.code === 1) {
                tblComunicados.ajax.reload();
                $.toast({
                    text:'Se elimino el comunicado seleccionado.',
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



    $("body").on("click", ".verComunicado", function (evt) {
        evt.preventDefault();
        var data2 = {}
        data2.comunicadoID=$(this).data('id');
        $.ajax({
            url: BASE_URL + "Comunicados/ajax_verComunicado",
            type: "POST",
            data: data2,
            success: function(data){
                dat=JSON.parse(data)
                dat=dat.com
                $("#temFecCom").text("");
                $("#temAsuntoCom").text("");
                $('#temDesCom').html("");
                $("#temFecCom").text(dat.com_Fecha);
                $('#temDesCom').append(dat.com_Descripcion);
                $('#temAsuntoCom').text(dat.com_Asunto);
                $("#modalVerComunicado").modal("show");
            }
        })

    });
});