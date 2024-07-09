$(document).ready(function (e) {
    $("#resEncuesta").hide();
    let tiketID =$("#comt_TicketID").val();
    encuesta(tiketID);

    getComentarios();
    $("#spiner").hide();

    $("#comentarioTicket").summernote({
        height: 300,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['table', ['table']],
            //['insert', ['link', 'picture']],
        ],
        lang: "es-ES", // default: 'en-US'
    });

    var btnGuardar= $("#saveComentario");
    var formComentario =$("#formCometario");

    btnGuardar.click(function (e){
        e.preventDefault();
        e.stopImmediatePropagation();

        if($("#comentarioTicket").val() !== "") {
            var form = formComentario[0];
            var dataForm = new FormData(form);
            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: BASE_URL + "MesaAyuda/ajax_SaveComentarioTicket",
                data: dataForm,
                processData: false,
                contentType: false,
                cache: false,
                dataType: "json",
                beforeSend: function () {
                    btnGuardar.hide();
                    $("#spiner").show();
                }
            }).done(function (data) {
                if (data.code === 1) {
                    $('#comentarioTicket').summernote('reset');
                    $("#archivosTicket").val('');
                    formComentario.trigger("reset");
                    getComentarios();
                    showNotification("success","El comentario se envio correctamente.");
                    $("#spiner").hide();
                    btnGuardar.show();
                }else{
                    showNotification("error","Ocurrio un problema al tartar de enviar, por favor intente nuevamente.");
                }
            }).fail(function () {
                showNotification("error","Ocurrido un error, por favor intente mas tarde.");
            });
        }else{
            showNotification("warning","Por favor llene los campos requeridos.");
        }
    });

    function getComentarios() {
        $("#totalComentarios").html('')
        $("#divComentarios").empty();
        $.ajax({
            url: BASE_URL + "MesaAyuda/ajax_GetComentariosTicket/"+$("#comt_TicketID").val(),
            type: "POST",
            dataType: "json",
        }).done(function (data) {
            $("#totalComentarios").html('Respuestas ('+data.total+')');
            $("#divComentarios").html(data.comentarios);

        }).fail(function () {
            showNotification("error","Ocurrido un error, por favor intente nuevamente.");
        });
    }

    ///////// ENCUESTA ////////////
    function encuesta(tiketID){
        $("#ticketID").val(tiketID);
        $.ajax({
            url: BASE_URL + "MesaAyuda/getEncuesta",
            type: "post",
            dataType: "json",
            data:{tiketID:tiketID},
        }).done(function (data) {
            if(data.mostrar == 1){$("#modalEncuesta").modal('show');$("#resEncuesta").show();}
            else if(data.mostrar == 0) $("#resEncuesta").hide();
        }).fail(function () {
            showNotification("error","Ocurrido un error, por favor intente nuevamente.");
        });
    }

    $("#pregunta1").hide();
    $("#pregunta2").hide();
    $("#pregunta3").hide();

    $("input[name$='P1']").click(function() {
        var respuesta = $(this).val();
        if(respuesta === 'necesitaMejorar' || respuesta === 'regular'){
            $("#pregunta1").show();
            $('#P1Comentario').prop('required',true);
        }else{
            $("#pregunta1").hide();
            $('#P1Comentario').removeAttr('required');
        }
    });
    $("input[name$='P2']").click(function() {
        var respuesta = $(this).val();
        if(respuesta === 'necesitaMejorar' || respuesta === 'regular'){
            $('#P2Comentario').prop('required',true);
            $("#pregunta2").show();
        }else{
            $("#pregunta2").hide();
            $('#P2Comentario').removeAttr('required');
        }
    });
    $("input[name$='P3']").click(function() {
        var respuesta = $(this).val();
        if(respuesta === 'necesitaMejorar' || respuesta === 'regular'){
            $('#P3Comentario').prop('required',true);
            $("#pregunta3").show();
        }else{
            $("#pregunta3").hide();
            $('#P3Comentario').removeAttr('required');
        }
    });

    $(".btnEncuesta").click(function (e) {
        var idTicket = $(this).data("id");

        $('#modalEncuesta').removeAttr('data-backdrop');
        $('#modalEncuesta').removeAttr('data-keyboard');
        $("input[type=radio]").attr('disabled', true);
        $("#comentario").attr('readonly', true);
        $(".veCliente").hide();
        $("#modalEncuesta").modal("show");

        $.ajax({
            url: BASE_URL + "MesaAyuda/getEncuestaResultados",
            type: 'post',
            data: 'idTicket='+idTicket,
            dataType: 'json',
        }).done(function (data) {
            if (data.code == 1) {
                switch (data.encuesta['enc_Pregunta1']){
                    case "necesitaMejorar":
                        $("#P1_1").prop("checked", true);
                        $("#P1Comentario").html(data.encuesta['enc_ComPregunta1']);
                        $("#P1Comentario").attr('readonly', true);
                        $("#pregunta1").show();
                        break;
                    case "regular":
                        $("#P1_2").prop("checked", true);
                        $("#P1Comentario").html(data.encuesta['enc_ComPregunta1']);
                        $("#P1Comentario").attr('readonly', true);
                        $("#pregunta1").show();
                        break;
                    case "bueno":
                        $("#P1_3").prop("checked", true);$("#pregunta1").hide();
                        break;
                    case "muybueno":
                        $("#P1_4").prop("checked", true);$("#pregunta1").hide();
                        break;
                    case "excelente":
                        $("#P1_5").prop("checked", true);$("#pregunta1").hide();
                        break;
                }

                switch (data.encuesta['enc_Pregunta2']){
                    case "necesitaMejorar":
                        $("#P2_1").prop("checked", true);
                        $("#P2Comentario").html(data.encuesta['enc_ComPregunta2']);
                        $("#P2Comentario").attr('readonly', true);
                        $("#pregunta2").show();
                        break;
                    case "regular":
                        $("#P2_2").prop("checked", true);
                        $("#P2Comentario").html(data.encuesta['enc_ComPregunta2']);
                        $("#P2Comentario").attr('readonly', true);
                        $("#pregunta2").show();
                        break;
                    case "bueno":
                        $("#P2_3").prop("checked", true);$("#pregunta2").hide();
                        break;
                    case "muybueno":
                        $("#P2_4").prop("checked", true);$("#pregunta2").hide();
                        break;
                    case "excelente":
                        $("#P2_5").prop("checked", true);$("#pregunta2").hide();
                        break;
                }

                switch (data.encuesta['enc_Pregunta3']){
                    case "necesitaMejorar":
                        $("#P3_1").prop("checked", true);
                        $("#P3Comentario").html(data.encuesta['enc_ComPregunta3']);
                        $("#P3Comentario").attr('readonly', true);
                        $("#pregunta3").show();
                        break;
                    case "regular":
                        $("#P3_2").prop("checked", true);
                        $("#P3Comentario").html(data.encuesta['enc_ComPregunta3']);
                        $("#P3Comentario").attr('readonly', true);
                        $("#pregunta3").show();
                        break;
                    case "bueno":
                        $("#P3_3").prop("checked", true);$("#pregunta3").hide();
                        break;
                    case "muybueno":
                        $("#P3_4").prop("checked", true);$("#pregunta3").hide();
                        break;
                    case "excelente":
                        $("#P3_5").prop("checked", true);$("#pregunta3").hide();
                        break;
                }

                $("#comentario").html(data.encuesta['enc_Comentario']);
            }
        }).fail(function (data) {
            showNotification("error","Ocurrido un error, por favor intente nuevamente.");
        });
    });


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