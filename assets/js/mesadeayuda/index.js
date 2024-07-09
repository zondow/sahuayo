$(document).ready(function (e) {

    $("#loadTicket").hide();
    $("#cancelTicket").show();
    $("#guardarTicket").show();

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
                        window.open(BASE_URL+"MesaAyuda/misTickets",'_self');
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