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
            window.open(BASE_URL + "MesaAyuda/infoEstadistica/4/" +$fechaInicio.val()+"/"+$fechaFin.val(), "_self");
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
            url: BASE_URL + "MesaAyuda/ajax_PrioridadTicketsPeriodoTabla/"+$("#fechaInicio").val()+'/'+$("#fechaFin").val(),
            dataSrc: '',
        },
        columns: [
            { "data": "acciones", render: function(data,type,row){return acciones(data,type,row)} },
            { "data": "tipo",render: function(data,type,row){return tipo(data,type,row)}},
            { "data": "prioridad",render: function(data,type,row){return prioridad(data,type,row)} },
            { "data": "tic_FechaHoraRegistro"},
            { "data": "numero"},
            { "data": "agente"},
            { "data": "estatus",render: function(data,type,row){return estado(data,type,row)} },
        ],
        responsive:true,
        stateSave:false,
        dom:'<"row"<"col-md-4"l><"col-md-4 text-center"f><"col-md-4 cls-export-buttons"B>>rtip',
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Tickets',
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
            infoFiltered:"(filtrado de _MAX_ registros)"
        },
        "order": [[ 4, "desc" ]],
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
            url: BASE_URL + "MesaAyuda/ajax_PrioridadTicketsPeriodo/"+$("#fechaInicio").val()+'/'+$("#fechaFin").val(),
            method: "GET",
            dataType: "json",
            success: function (response) {
                var data = {
                    labels: response.prioridad,
                    datasets: [{
                        data: response.ticket,
                        backgroundColor: ["#009246", "#4eb7eb", "#e7b416", "#cc3232"],
                        hoverBackgroundColor: ["#009246", "#4eb7eb", "#e7b416", "#cc3232"],
                        hoverBorderColor: "#fff",
                    },],
                }, options = {
                    tooltips: {
                        callbacks: {
                            label: function (tooltipItem, data) {
                                var dataset = data.datasets[tooltipItem.datasetIndex];
                                var total = response.totalTickets;
                                var currentValue = dataset.data[tooltipItem.index];
                                var percentage = parseFloat((currentValue / total * 100).toFixed(2));
                                return currentValue + " Tickets - " + percentage + "%";
                            },
                        },
                    },
                    legend: {
                        position: "right",
                        labels: {
                            generateLabels: function (chart) {
                                var data = chart.data;
                                if (data.labels.length && data.datasets.length) {
                                    return data.labels.map(function (label, i) {
                                        var meta = chart.getDatasetMeta(0);
                                        var ds = data.datasets[0];
                                        var arc = meta.data[i];
                                        var custom = arc && arc.custom || {};
                                        var getValueAtIndexOrDefault = Chart.helpers.getValueAtIndexOrDefault;
                                        var arcOpts = chart.options.elements.arc;
                                        var fill = custom.backgroundColor ? custom.backgroundColor : getValueAtIndexOrDefault(ds.backgroundColor, i, arcOpts.backgroundColor);
                                        var stroke = custom.borderColor ? custom.borderColor : getValueAtIndexOrDefault(ds.borderColor, i, arcOpts.borderColor);
                                        var bw = custom.borderWidth ? custom.borderWidth : getValueAtIndexOrDefault(ds.borderWidth, i, arcOpts.borderWidth);
                                        var currentValue = ds.data[i];
                                        var percentage = parseFloat((currentValue / response.totalTickets * 100).toFixed(2));
                                        return {
                                            text: label + " - " + currentValue + " Tickets (" + percentage + "%)",
                                            fillStyle: fill,
                                            strokeStyle: stroke,
                                            lineWidth: bw,
                                            hidden: isNaN(ds.data[i]) || meta.data[i].hidden,
                                            index: i
                                        };
                                    });
                                }
                                return [];
                            }
                        }
                    },
                };

                self.respChart($("#ticketsPrioridad"), "Pie", data, options);
            }
        });
    }


    $.ChartJs = new RespChart();
    $.ChartJs.Constructor = RespChart;
    $.ChartJs.init();
});

