$(document).ready(function () {

    /**CONFGURACION***/
    $("#date-range").datepicker({
        format: "yyyy-mm-dd",
        toggleActive: !0,
        todayHighlight: true,
        autoclose: true,
    }).on('changeDate', function (e) {
        $("#fechaFin").focus();
    });

    var $fechaInicio =$("#fechaInicio");
	var $fechaFin =$("#fechaFin");
	
	var $btnConsultar = $("#btnConsultar");

    $btnConsultar.click(function (e) {
		e.preventDefault();
		if($fechaInicio.val() !== "" && $fechaFin.val() !== "" ){
            window.open(BASE_URL + "MesaAyuda/infoEstadistica/1/" +$fechaInicio.val()+"/"+$fechaFin.val(), "_self");
		}else{
			$.toast({
				text: "Asegurece de seleccionar el periodo .",
				icon: "warning",
				loader: true,
				loaderBg: '#c6c372',
				position: 'top-right',
				allowToastClose: true,
			});
		}
	});


    var tblTickets =  $("#tblTickets").DataTable({
        destroy: true,
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        fixedHeader: true,
        //scrollY: "200px",
        scrollCollapse: true,
        scrollX:        true,
        paging:         true,
        ajax: {
            url: BASE_URL + "MesaAyuda/ajax_InfoCreadosVResueltoByMesPeriodoTabla/"+$("#fechaInicio").val()+'/'+$("#fechaFin").val(),
            dataSrc: '',
        },
        columns: [
            { "data": "acciones", render: function(data,type,row){return acciones(data,type,row)} },
            { "data": "tipo",render: function(data,type,row){return tipo(data,type,row)}},
            { "data": "tic_FechaHoraRegistro"},
            { "data": "numero"},
            { "data": "agente"},
            { "data": "estatus",render: function(data,type,row){return estado(data,type,row)} },
            { "data": "prioridad",render: function(data,type,row){return prioridad(data,type,row)} }
        ],
        responsive:true,
        stateSave:false,
        dom:'<"row"<"col-md-4"l><"col-md-4 text-center"f><"col-md-4 cls-export-buttons"B>>rtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Tickets',
                text: '<i class="fa fa-file-excel-o"></i>&nbsp;Excel',
                titleAttr: "Exportar a excel",
                className: "btn btn-warning",
                autoFilter: true,
                exportOptions: {
                    columns: ':visible'
                },
            },
            {
                extend: 'colvis',
                text: 'Columnas',
                className: "btn btn-light",
            }
        ],
        language: {
            paginate: {
                previous:"<i class='mdi mdi-chevron-left'>",
                next:"<i class='mdi mdi-chevron-right'>"
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
        "order": [[ 3, "desc" ]],
        "processing":true
    });


    function acciones(data,type,row){
        let output = '';
        let id = row.tic_TicketID;
        output += '<a class="btn btn-info" href="'+BASE_URL+'MesaAyuda/ticket/'+id+'/1"><b class=" mdi mdi-information-variant"></b></a>';
        return output;
    }//acciones

    function prioridad(data,type,row){
        var html = data;
        switch (data){
            case 'BAJA' :html = '<span class="badge badge-success p-1">Baja</span>';break;
            case 'MEDIA' :html = '<span class="badge badge-info p-1">Media</span>';break;
            case 'ALTA' :html = '<span class="badge badge-warning p-1">Alta</span>';break;
            case 'URGENTE' :html = '<span class="badge badge-danger p-1">Urgente</span>';break;
        }//switch
        return html;
    }

    function estado(data,type,row){
        var html = data;
        switch (data){
            case 'ABIERTO' :html = '<span class="badge badge-light p-1">Abierto</span><br>';break;
            case 'ESPERA_SOLICITANTE' :html = '<span class="badge badge-light p-1">Espera de respuesta del solicitante</span><br>';break;
            case 'ESPERA_PROVEEDOR' :html = '<span class="badge badge-light p-1">Espera de respuesta del proveedor</span><br>';break;
            case 'RESUELTO' :html = '<span class="badge badge-light p-1">Resuelto</span><br>';break;
            case 'CERRADO' :html = '<span class="badge badge-light p-1">Cerrado</span><br>';break;
        }//switch
        return html;
    }

    function tipo(data,type,row){
        var html = data;
        switch (data){
            case 'normal' :html = '<span class="badge badge-dark p-1">Normal</span><br>';break;
            case 'generico' :html = '<span class="badge badge-light p-1">Genérico</span><br>';break;
        }//switch
        return html;
    }


    function RespChart() { }
    RespChart.prototype.respChart = function (chart, type, data, options) {
        var ctx = chart.get(0).getContext("2d"), $parent = $(chart).parent();

        function resizeChart() {
            chart.attr("width", $parent.width());
            switch (type) {
                case "Line": new Chart(ctx, { type: "line", data: data, options: options }); break;
                case "Bar": new Chart(ctx, { type: "bar", data: data, options: options }); break;
                case "horizontalBar": new Chart(ctx, { type: "horizontalBar", data: data, options: options }); break;
                case "Pie": new Chart(ctx, { type: "pie", data: data, options: options }); break;
            }
        }

        $(window).resize(resizeChart);
        resizeChart();
    };

    RespChart.prototype.init = function () {
        var self = this;
        $.ajax({
            url: BASE_URL + "MesaAyuda/ajax_InfoCreadosVResueltoByMesPeriodo/"+$("#fechaInicio").val()+'/'+$("#fechaFin").val(),
            method: "GET",
            dataType: "json",
            success: function (response) {
                var maxTickets = Math.max(...response.ticketsCreados, ...response.ticketsResueltos);
                var data = {
                    labels: response.meses,
                    datasets: [
                        {
                            label: "Creados",
                            fill: false,
                            backgroundColor: "#4eb7eb",
                            borderColor: "#4eb7eb",
                            data: response.ticketsCreados,
                        },
                        {
                            label: "Resueltos",
                            fill: false,
                            backgroundColor: "#ffbf00",
                            borderColor: "#ffbf00",
                            borderDash: [5, 5],
                            data: response.ticketsResueltos,
                        },
                    ],
                },
                    options = {
                        responsive: true,
                        tooltips: { mode: "index", intersect: false },
                        hover: { mode: "nearest", intersect: true },
                        scales: {
                            xAxes: [{ display: true, gridLines: { color: "rgba(0,0,0,0.1)" } },],
                            yAxes: [{
                                gridLines: {
                                    color: "rgba(255,255,255,0.05)",
                                    fontColor: "#fff",
                                },
                                ticks: { max: maxTickets, min: 0, stepSize: 1 },
                            },],
                        },
                        animation: {
                            duration: 500,
                            easing: "easeOutQuart",
                            onComplete: function () {
                                var ctx = this.chart.ctx;
                                ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, "normal", Chart.defaults.global.defaultFontFamily);
                                ctx.textAlign = "center";
                                ctx.textBaseline = "bottom";
                                this.data.datasets.forEach(function (dataset) {
                                    for (var i = 0; i < dataset.data.length; i++) {
                                    var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
                                        scale_max = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._yScale.maxHeight;
                                    ctx.fillStyle = "#444";
                                    var y_pos = model.y - 5;
                                    if ((scale_max - model.y) / scale_max >= 0.93)
                                        y_pos = model.y + 20;
                                    ctx.fillText(dataset.data[i], model.x, y_pos);
                                    }
                                });
                            },
                        },
                    };
                self.respChart($("#creadoVresuelto"), "Line", data, options);

            }
        });
    }


    $.ChartJs = new RespChart();
    $.ChartJs.Constructor = RespChart;
    $.ChartJs.init();

});