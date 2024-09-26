$(document).ready(function () {

    fInicio = $("#FechaInicio").val();
    fFin = $("#FechaFin").val();
    SucursalID = $("#SucursalID").val();

    $("#date-range").datepicker({
        daysOfWeekDisabled:[0],
        format: "yyyy-mm-dd",
        toggleActive: !0,
        todayHighlight: true,
        autoclose: true,
    }).on('changeDate', function (e) {
        $("#fFin").focus();
    });

    //Enviar el id del cliente
    $('#btn').click(function(e){
        fInicio = $("#fInicio").val();
        fFin = $("#fFin").val();
        sucursal = $("#sucursal").val();
        window.open(BASE_URL + "Evaluaciones/resultadosGuiaIII/" + fInicio+"/"+fFin+"/"+sucursal, "_self");
    });

    if(fInicio && fFin){
        var tbl = $("#datatable").DataTable({
            destroy: true,
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
            ajax: {
                url: BASE_URL + "Evaluaciones/ajax_getEvaluadosG3/"+fInicio+"/"+fFin+"/"+SucursalID,
                dataType: "json",
                type: "POST",
                "processing": true,
            },
            columns: [
                {"data": "acciones", render: function (data, type, row) {return acciones(data, type, row)}},
                {"data": "emp_Nombre"},
                {"data": "calificacion"},
            ],
            columnDefs: [
                {targets: 0, className: 'text-center'},
            ],
            dom:'<"row"<"col-md-6"l><"col-md-6 text-center"f><"col-md-9 cls-export-buttons"B>>rtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    title: 'Evaluados Guia II',
                    text: '<i class="zmdi zmdi-collection-text"></i>&nbsp;Excel',
                    titleAttr: "Exportar a excel",
                    className: "btn l-slategray btn-round",
                    autoFilter: true,
                    exportOptions: {
                        columns: ':visible'
                    },
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Evaluados Guia II',
                    text: '<i class="zmdi zmdi-collection-pdf"></i>&nbsp;PDF',
                    titleAttr: "Exportar a PDF",
                    className: "btn l-slategray btn-round",
                    orientation: 'landscape',
                    pageSize: 'LETTER',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'colvis',
                    text: 'Columnas',
                    className: "btn btn-ligth",
                }
            ],
            responsive: true,
            stateSave: false,
            language: {
                paginate: {
                    previous: "<i class='zmdi zmdi-caret-left'>",
                    next: "<i class='zmdi zmdi-caret-right'>"
                },
                search: "_INPUT_",
                searchPlaceholder: "Buscar...",
                lengthMenu: "Registros por página _MENU_",
                info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                infoEmpty: "Mostrando 0 a 0 de 0 registros",
                zeroRecords: "No hay datos para mostrar",
                loadingRecords: "Cargando...",
                infoFiltered: "(filtrado de _MAX_ registros)",
                "processing": "Procesando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "<i class='zmdi zmdi-caret-right'>",
                    "sPrevious": "<i class='zmdi zmdi-caret-left'>"
                },
            },
            "order": [[1, "asc"]],
            "processing": true,

        });
    }
    function acciones(data,type,row){
        let id = row['id'];
        let output = '';
            output+= '<td><a type="button" href="'+BASE_URL+'Evaluaciones/resultadoEvaluadoGuia3/'+id+'/'+fInicio+'/'+fFin+'" style="color: #FFFFFF" class="btn btn-block waves-effect waves-light btn-info btn-sm "> <i class=" mdi mdi-file-document-box-check-outline' +
                '                                                     "></i> Ver Resultados</a></td>';
        return output;
    }//accionesHorario

    $.ajax({
        url: BASE_URL + 'Evaluaciones/ajax_getDominiosG3/'+fInicio+"/"+fFin+"/"+SucursalID,
        cache: false,
        type: 'post',
        dataType: 'json',
    }).done(function (data) {
        $("#bodyTable").append(
            '<tr> ' +
            '<td style="background-color: #eacd11;color:#fff">Bajo Riesgo</td>' +
            '<td >'+data.bajo[0]+'</td>' +
            '<td >'+data.bajo[1]+'</td>' +
            '<td >'+data.bajo[2]+'</td>' +
            '<td >'+data.bajo[3]+'</td>' +
            '<td >'+data.bajo[4]+'</td>' +
            '<td >'+data.bajo[5]+'</td>' +
            '<td >'+data.bajo[6]+'</td>' +
            '<td >'+data.bajo[7]+'</td>' +
            '<td >'+data.bajo[8]+'</td>' +
            '<td >'+data.bajo[9]+'</td>' +
            '</tr>' +
            '<tr> ' +
            '<td style="background-color: #16a53f;color:#fff">Riesgo Mediano</td>' +
            '<td >'+data.medio[0]+'</td>' +
            '<td >'+data.medio[1]+'</td>' +
            '<td >'+data.medio[2]+'</td>' +
            '<td >'+data.medio[3]+'</td>' +
            '<td >'+data.medio[4]+'</td>' +
            '<td >'+data.medio[5]+'</td>' +
            '<td >'+data.medio[6]+'</td>' +
            '<td >'+data.medio[7]+'</td>' +
            '<td >'+data.medio[8]+'</td>' +
            '<td >'+data.medio[9]+'</td>' +
            '</tr>' +
            '<tr> ' +
            '<td style="background-color: #ff3600;color:#fff">Alto Riesgo</td>' +
            '<td >'+data.alto[0]+'</td>' +
            '<td >'+data.alto[1]+'</td>' +
            '<td >'+data.alto[2]+'</td>' +
            '<td >'+data.alto[3]+'</td>' +
            '<td >'+data.alto[4]+'</td>' +
            '<td >'+data.alto[5]+'</td>' +
            '<td >'+data.alto[6]+'</td>' +
            '<td >'+data.alto[7]+'</td>' +
            '<td >'+data.alto[8]+'</td>' +
            '<td >'+data.alto[9]+'</td>' +
            '</tr>'
        );

        var barChartData = {
            labels: [
                "Condiciones del ambiente de trabajo",
                "Carga de trabajo",
                "Falta de control en el trabajo",
                "Jornada de trabajo",
                "Interferencia en la relacion trabajo familia",
                "Liderazgo",
                "Relaciones en el trabajo",
                "Violencia",
                "Reconocimiento del desempeño",
                "Insuficiente sentido de pertenencia"
            ],
            datasets: [
                {
                    label: "Bajo Riesgo",
                    backgroundColor: "#ffff00",
                    borderColor: "#ffff00",
                    borderWidth: 1,
                    data: data.bajo
                },
                {
                    label: "Riesgo Mediano",
                    backgroundColor: "#16a53f",
                    borderColor: "#16a53f",
                    borderWidth: 1,
                    data :data.medio
                },
                {
                    label: "Alto Riesgo",
                    backgroundColor: "#ff3131",
                    borderColor: "#ff3131",
                    borderWidth: 1,
                    data :data.alto
                }
            ]
        };
        var chartOptions = {
            responsive: true,
            legend: {
                position: "top"
            },
            title: {
                display: true,
                text: "Prevalencia de Riesgos Psicosociales"
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,stepSize: 10
                    }
                }]
            },

        }

        var ctx = document.getElementById("canvas").getContext("2d");
        window.myBar = new Chart(ctx, {
            type: "bar",
            data: barChartData,
            options: chartOptions,
        });

    });//ajax

    setTimeout(function(){
        guardarImagenes();
        $(".show-pdf").show();
    }, 1000);

    //Guardar imagenes Graficas
    function guardarImagenes() {
        var idCentro=$("#CT").val();
        var canvasGrafica = document.getElementById('canvas');
        var dataGrafica = canvasGrafica.toDataURL('image/png',1.0);

        var imgs = dataGrafica;

        //Ajax guardar imagen
        $.ajax({
            url: BASE_URL+'Evaluaciones/ajaxGuardarInterpG3/',
            type: 'post',
            cache: false,
            async: false,
            data: {
                img:imgs,
                fechaI:fInicio,
                fechaF:fFin,
            }
        }).done(function(data){
            //console.log("La imagen se guardó correctamente");
        }).fail(function(data){
            //console.log("Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.");
            //console.log(data);
        }).always(function(e){
        });//Ajax guardar imagen

    }

});

