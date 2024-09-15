$(document).ready(function (e) {

    $("#loadTicket").hide();
    $("#cancelTicket").show();
    $("#guardarTicket").show();

    $("#tableTickets").DataTable({
        responsive:false,
        stateSave:false,
        //dom: 'Blfrtip',
        dom:'<"row"<"col-md-4"l><"col-md-4 text-center"f><"col-md-4 cls-export-buttons"B>>rtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Mis tickets',
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
            infoFiltered:"(filtrado de _MAX_ registros)",
            "processing": "Procesando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "<i class='zmdi zmdi-caret-right'>",
                "sPrevious": "<i class='zmdi zmdi-caret-left'>"
            },

        },
        "order": [[ 1, "desc" ]],
        "processing":false
    });

    $("body").on("click", ".modalCrearTicket", function (evt) {
        evt.preventDefault();
        $("#modalAddTicket").modal("show");
    });

    $("#descripcionTicket").summernote({
        tabsize: 2,
        height: 150,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['table', ['table']],
            ['insert',],
        ],
        lang: "es-ES", // default: 'en-US'
    });

    var formTicket =$("#formTicket");
    $("#guardarTicket").click(function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        if($("#tituloTicket").val() !== '' && $("#areaTicket").val() !== '' &&
            $("#servicioTicket").val() !== ''  &&  $("#descripcionTicket").val() !== ''){

            var form = formTicket[0];
            var dataForm = new FormData(form);
            //ocultar botones
            $("#loadTicket").show();
            $("#cancelTicket").hide();
            $("#guardarTicket").hide();
            $.ajax({
                type: "POST",
                enctype: "multipart/form-data",
                url: BASE_URL + "MesaAyuda/ajax_addTicket",
                data: dataForm,
                processData: false,
                contentType: false,
                cache: false,
                dataType: "json",
                beforeSend: function () {
                    Swal.fire({
                        title: 'Guardando ticket.',
                        text: 'Por favor espere mientras registramos el ticket.',
                        timer: 100000,
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
                data = JSON.parse(JSON.stringify(data));
                if (data.code === 1) {
                    Swal.fire({
                        title: "Ticket registrado exitosamente!",
                        text: "Pronto uno de nuestros agentes se comunicara contigo",
                        icon: 'success',
                    }).then(() => {
                        location.reload();
                    });

                } else {
                    Swal.fire({
                        title: '¡Tuvimos un problema!',
                        icon: 'error',
                        text: 'Ocurrio un error al tratar de guardar el ticket,por favor intente de nuevo.',
                    }).then(() => {
                        location.reload();
                    });
                }
            });
        }else{
            showNotification("warning","Asegurece de llenar todos los campos. Intente nuevamente.");
        }
    });


    $("body").on("change", "#areaTicket", function (e) {
        e.preventDefault();
        let area = $("#areaTicket").val();
        if (area !== "Seleccione") {
          $.ajax({
            url: BASE_URL + "MesaAyuda/ajax_getServicioByArea/",
            type: "POST",
            async: true,
            cache: false,
            dataType: "json",
            data: { area: area },
          })
            .done(function (data) {
              if (data.response === "success") {
                count = 1;
                $.each(data.result, function (key, value) {
                  if (count === 1) $row = "<option value='" + value.ser_ServicioID + "'>" + value.ser_Servicio + " </option>";
                  else $row += "<option value='" + value.ser_ServicioID + "'>" + value.ser_Servicio + " </option>";
                  count = 2;
                });
                $("#servicioTicket").html("").select2({});
                $("#servicioTicket").append($row);
              }
            }).fail(function () {
                showNotification("error","Ocurrido un error, por favor intente nuevamente.");
            });
        } else {
            showNotification("warning","Seleccione un área.");
        }
    });


    $("#pregunta1").hide();
    $("#pregunta2").hide();
    $("#pregunta3").hide();

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

    $("#archivoTicket").fileinput({
        theme: 'fas',
        language: 'es',
        uploadUrl: '#',
        allowedFileExtensions: ['zip', 'docx', 'xlsx', 'pptx', 'pdf', 'png', 'jpg', 'jpeg','doc','ppt','xls'],
        maxFileSize:20000,
        dropZoneEnabled: false,
        showUpload: false,
    });

    $(".select2").select2();

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