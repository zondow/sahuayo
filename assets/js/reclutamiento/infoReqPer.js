$(document).ready(function (e) {

    var tblDatatable = $('.datatable').DataTable({
        language:
        {
            paginate: {
                previous: "<i class='zmdi zmdi-caret-left'>",
                next: "<i class='zmdi zmdi-caret-right'>"
            },
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla.",
            "sInfo": "",
            "sInfoEmpty": "",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "<i class='zmdi zmdi-caret-right'>",
                "sPrevious": "<i class='zmdi zmdi-caret-left'>"
            },
        },
        "order": [[0, "desc"]],
        "columnDefs": [
            {
                //"targets": [ 14,4 ],
                "visible": false,
                "searchable": false
            }
        ],
    });

    //abrir modal link contraseñ
    $('body').on('click', '.addCandidato', function (e) {
        e.preventDefault();
        $('#formAddCandidato')[0].reset();
        let solPerID = $(this).data('id');
        $("#modalAdd_SolPer").val(solPerID);
        $("#modalAddCandidato").modal("show");
    });

    $("body").on("click", ".observacionesBtn", function (e) {
        e.preventDefault();
        candidatoID = $(this).data('id');
        document.getElementById('candidatoIDInput').value = candidatoID;
        //document.getElementById('formObservaciones').submit();
        getRegistroObservaciones(candidatoID);
        $("#modalCambios").modal("show");
    });

    function getRegistroObservaciones(candidatoID){

        $.ajax({
            url: BASE_URL + "Reclutamiento/ajax_getRegistroObservaciones" ,
            type: "POST",
            data:"candidatoID="+candidatoID,
            dataType: "json"
        }).done(function (data){
            if(data.response === "success"){
                $('#candidatoID').val(data.info.candidatoID);
                $('#can_Observacion').val(data.info.can_Observacion);
                /*if(data.info.can_Observacion !== ""){
                    $('#can_Observacion').summernote('code',data.info.can_Observacion);
                }else{
                    $('#can_Observacion').summernote();
                }*/
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

    /*$('#can_Observacion').summernote({
        //placeholder: 'Hello bootstrap 4',
        tabsize: 2,
        height: 400,
        lang: 'es-ES' // default: 'en-US'
    });*/

    //Enviar notificacion a solicitante
    $("body").on("click", ".notificacionGerente", function (e) {
        var candidatoID = $(this).data("id");
        var estatus = 'AUT_GERENTE';
        Swal.fire({
            title: 'Enviar Notificación a Gerente',
            text: '¿Esta seguro que desea enviar la notificación?',
            type: "question",
            showCancelButton: true,
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.value)
                ajaxCambiarEstatusCandidato(candidatoID, estatus, '');
        })
    });

    //Autorizar
    $("body").on("click", ".autorizarBtn", function (e) {
        var candidatoID = $(this).data("id");
        var estatus = $(this).data("estatus");

        Swal.fire({
            title: 'Autorizar candidato a siguiente fase',
            text: '¿Esta seguro de autorizar el candidato?',
            type: "question",
            showCancelButton: true,
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.value)
                ajaxCambiarEstatusCandidato(candidatoID, estatus, '');
        })
    });

    //Rechazar
    $("body").on("click", ".rechazarBtn", function (e) {
        var candidatoID = $(this).data("id");
        var estatus = $(this).data("estatus");

        Swal.fire({
            title: 'Rechazar candidato',
            text: '¿Esta seguro de rechazar el candidato?',
            type: "question",
            showCancelButton: true,
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
            html: '<textarea id="txtObsDeclinar" placeholder="Escriba el motivo" ' +
                'class="swal2-textarea" style="display: flex;" style="resize: none;"></textarea>',
        }).then((result) => {
            if (result.value)
                var ObsDeclinar = $("#txtObsDeclinar").val();
                var ObsDeclinar = ObsDeclinar.trim() === "" ? "Sin observaciones" : ObsDeclinar;
                ajaxCambiarEstatusCandidato(candidatoID, estatus, ObsDeclinar);
        })
    });

    //Enviar notificacion a solicitante final
    $("body").on("click", ".notificacionFinal", function (e) {
        var candidatoID = $(this).data("id");
        var estatus = 'SEL_SOLICITANTE';
        Swal.fire({
            title: 'Enviar Notificación a Gerente',
            text: '¿Esta seguro que desea enviar la notificación?',
            type: "question",
            showCancelButton: true,
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.value)
                ajaxCambiarEstatusCandidato(candidatoID, estatus, '');
        })
    });

    //guardar en carter
    $("body").on("click", ".carteraBtn", function (e) {
        var candidatoID = $(this).data("id");
        var candidato = $(this).data("candidato");
        var estatus = $(this).data("estatus");


        Swal.fire({
            title: 'Guardar candidato en cartera de candidatos',
            text: '¿Esta seguro que desea guardar al candidato ' + candidato + '?',
            type: "question",
            showCancelButton: true,
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.value){
                ajaxCarteraCandidato(candidatoID, estatus);
            }
        })
    });

    //cerrar solicitud
    $("body").on("click", ".cerrarSolicitud", function (e) {
        var solicitudID = $(this).data("id");

        Swal.fire({
            title: 'Cerrar solicitud de personal',
            text: '¿Esta seguro que desea cerrar la solicitud de personal?',
            type: "question",
            showCancelButton: true,
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.value)
                ajaxCerrarSolicitud(solicitudID);
        })
    });


    function ajaxCambiarEstatusCandidato(candidatoID, estatus, Observacion) {
        $("#btnAplicar").html('<i class="fas fa-spinner fa-pulse"></i>&nbsp; Aplicando...');
        $.ajax({
            url: BASE_URL + 'Reclutamiento/ajax_CambiarEstatusCandidato',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: { candidatoID: candidatoID, estatus: estatus, Observacion: Observacion }
        }).done(function (data) {
            if (data.code === 1) {
                Swal.fire({
                    icon: 'success',
                    title: data.mensaje,
                    text: data.mensaje,
                    showConfirmButton: false,
                    timer: 2000
                })
                setTimeout(function () { window.location.href = data.url; }, 400);

            } else {
                $.toast({
                    text: "Ocurrido un error, por favor intente nuevamente.",
                    icon: "error",
                    loader: true,
                    loaderBg: '#c6c372',
                    position: 'top-right',
                    allowToastClose: true,
                });
            }//if-else
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

    //Boton contratado
    $("body").on("click", ".seleccionadoBtn", function (e) {
        var candidatoID = $(this).data("id");
        var candidato = $(this).data("candidato");
        var estatus = 'SELECCIONADO_RH';

        Swal.fire({
            title: 'Seleccionar candidato',
            text: '',
            type: "question",
            html: '<form class="text-center">¿Esta seguro que desea seleccionar al candidato ' + candidato + '? <br><br> Seleccione la fecha de ingreso<br><input class="form-control datepicker" type="date" id="fechaIngreso" name="fechaIngreso" required></form>',
            showCancelButton: true,
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.value)
                ajaxSeleccionarCandidato(candidatoID, estatus, $("#fechaIngreso").val());
        })
    });

    function ajaxSeleccionarCandidato(candidatoID, estatus, fechaIngreso) {
        //$("#btnAplicar").html('<i class="fas fa-spinner fa-pulse"></i>&nbsp; Seleccionando...');
        /*Swal.fire({
            type: 'info',
            title: 'Cargando...',
            text: 'Espere un momento por favor',
            showConfirmButton: false,
            timer: 1000
        })*/
        $.ajax({
            url: BASE_URL + 'Reclutamiento/ajax_SeleccionandoCandidato',
            cache: false,
            type: 'post',
            dataType: 'json',beforeSend: function () {
                swal.fire({
                    title: 'Guardando informacion.',
                    text: 'Por favor espere mientras se realiza el proceso.',
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
            },
            data: { candidatoID: candidatoID, estatus: estatus, fechaIngreso: fechaIngreso }
        }).done(function (data) {
            //$("body").html('<i class="fas fa-spinner fa-pulse"></i>&nbsp; Seleccionando...');
            if (data.code === 1) {
                Swal.fire({
                    icon: 'success',
                    title: data.mensaje,
                    text: data.mensaje,
                    showConfirmButton: false,
                    timer: 6000
                })
                //setTimeout(function () { window.location.reload(); }, 400);
                setTimeout(function () {
                    window.location.reload();
                }, 1500);

            } else {
                $.toast({
                    text: "Ocurrido un error, por favor intente nuevamente.",
                    icon: "error",
                    loader: true,
                    loaderBg: '#c6c372',
                    position: 'top-right',
                    allowToastClose: true,
                });
            }//if-else
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

    function ajaxCarteraCandidato(candidatoID, estatus) {
        $("#btnAplicar").html('<i class="fas fa-spinner fa-pulse"></i>&nbsp; Aplicando...');
        $.ajax({
            url: BASE_URL + 'Reclutamiento/ajax_CarteraCandidato',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: { candidatoID: candidatoID, estatus: estatus }
        }).done(function (data) {
            if (data.code === 1) {
                Swal.fire({
                    icon: 'success',
                    title: data.mensaje,
                    text: data.mensaje,
                    showConfirmButton: false,
                    timer: 2000
                })
                setTimeout(function () { window.location.href = data.url; }, 400);
            } else {
                $.toast({
                    text: "Ocurrido un error, por favor intente nuevamente.",
                    icon: "error",
                    loader: true,
                    loaderBg: '#c6c372',
                    position: 'top-right',
                    allowToastClose: true,
                });
            }//if-else
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

    function ajaxCerrarSolicitud(solicitudID) {
        $("#btnAplicar").html('<i class="fas fa-spinner fa-pulse"></i>&nbsp; Aplicando...');
        $.ajax({
            url: BASE_URL + 'Reclutamiento/ajax_CerrarSolicitud',
            cache: false,
            type: 'post',
            dataType: 'json',
            data: { solicitudID: solicitudID }
        }).done(function (data) {
            if (data.code === 1) {
                Swal.fire({
                    icon: 'success',
                    title: data.mensaje,
                    text: data.mensaje,
                    showConfirmButton: false,
                    timer: 2000
                })
                setTimeout(function () { window.location.href = data.url; }, 400);

            } else {
                $.toast({
                    text: "Ocurrido un error, por favor intente nuevamente.",
                    icon: "error",
                    loader: true,
                    loaderBg: '#c6c372',
                    position: 'top-right',
                    allowToastClose: true,
                });
            }//if-else
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

    $(".select2").select2();
    $(".select2-multiple").select2({
        language: "es",

    });

    $('.datetimepicker').bootstrapMaterialDatePicker({
        format: 'Y-M-D HH:mm',
        clearButton: false,
        date: true,
        lang: 'es',
        cancelText: 'Cancelar',
        okText: 'Aceptar',
    });

    $(".datepicker").datepicker({
        autoclose: !0,
        daysOfWeekDisabled: [0],
        todayHighlight: !0,
        orientation: "bottom",
        format: "yyyy-mm-dd",
        daysOfWeek: ["D", "L", "M", "M", "J", "V", "S"],
        monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
    });
});