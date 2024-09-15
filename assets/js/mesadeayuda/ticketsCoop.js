$(".datatableTickets").DataTable({
    responsive:true,
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

$(".btnEncuesta").click(function (e) {
    var idTicket = $(this).data("id");

    $('#modalEncuesta').removeAttr('data-backdrop');
    $('#modalEncuesta').removeAttr('data-keyboard');
    $("input[type=radio]").attr('disabled', true);
    $("#comentario").attr('readonly', true);
    $(".veCliente").hide();
    $("#modalEncuesta").modal("show");

    $.ajax({
        url: BASE_URL + "Usuario/getEncuestaResultados",
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
