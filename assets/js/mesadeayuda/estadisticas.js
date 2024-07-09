$(document).ready(function () {
    (function ($) {
        "use strict";
        function RespChart() { }
        RespChart.prototype.respChart = function (chart, type, data, options) {
            var ctx = chart.get(0).getContext("2d"), $parent = $(chart).parent();

            function resizeChart() {
                chart.attr("width", $parent.width());
                ctx.clearRect(0, 0, chart.width(), chart.height());
                if (chart.chart) {
                    chart.chart.destroy(); // Elimina la gráfica anterior
                }
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
            //Tendencia de tickets
            var self = this;
            $.ajax({
                url: BASE_URL + "MesaAyuda/ajax_CreadosVResueltoByMes",
                method: "GET",
                dataType: "json",
                success: function (response) {
                    var maxTickets = Math.max(...response.ticketsCreados, ...response.ticketsResueltos);
                    var data = {
                        labels: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic",],
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
                            tooltips: {
                                mode: "index",
                                intersect: false,
                            },
                            hover: { mode: "nearest", intersect: true },
                            scales: {
                                xAxes: [{ display: true, gridLines: { color: "rgba(0,0,0,0.1)" } },],
                                yAxes: [{
                                    gridLines: {
                                        color: "rgba(255,255,255,0.05)",
                                        fontColor: "#fff",
                                    },
                                    ticks: { max: maxTickets, min: 0, stepSize: 5 },
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

                },
            });
            //Tickets por prioridad
            $.ajax({
                url: BASE_URL + "MesaAyuda/ajax_PrioridadTickets",
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
            //Tickets por estatus
            $.ajax({
                url: BASE_URL + "MesaAyuda/ajax_TicketsEstatus",
                method: "GET",
                dataType: "json",
                success: function (response) {
                    var data = {
                        labels: response.estatus,
                        datasets: [{
                            label: "Tickets",
                            backgroundColor: "rgba(153,170,181, 0.3)",
                            borderColor: "#99aab5",
                            borderWidth: 1,
                            hoverBackgroundColor: "rgba(153,170,181, 0.7)",
                            hoverBorderColor: "#99aab5",
                            data: response.ticket,
                        },],
                    },
                        options = {
                            scales: {
                                xAxes: [{
                                    gridLines: {
                                        offsetGridLines: true
                                    },
                                }],
                                yAxes: [{
                                    ticks: {
                                        stepSize: 5
                                    }
                                }]
                            },
                            animation: {
                                duration: 500,
                                easing: "easeOutQuart",
                                onComplete: function () {
                                    var ctx = this.chart.ctx;
                                    ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
                                    ctx.textAlign = 'center';
                                    ctx.textBaseline = 'bottom';

                                    this.data.datasets.forEach(function (dataset) {
                                        for (var i = 0; i < dataset.data.length; i++) {
                                            var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
                                                scale_max = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._yScale.maxHeight;
                                            ctx.fillStyle = '#444';
                                            var y_pos = model.y - 5;
                                            // Make sure data value does not get overflown and hidden
                                            // when the bar's value is too close to max value of scale
                                            // Note: The y value is reverse, it counts from top down
                                            if ((scale_max - model.y) / scale_max >= 0.93)
                                                y_pos = model.y + 20;
                                            ctx.fillText(dataset.data[i], model.x, y_pos);
                                        }
                                    });
                                }
                            }
                        };
                    self.respChart($("#ticketsEstatus"), "Bar", data, options);
                }
            });
            //Tickets genericos por coop
            $.ajax({
                url: BASE_URL + "MesaAyuda/ajax_TicketsGCoop",
                method: "GET",
                dataType: "json",
                success: function (response) {
                    var data = {
                        labels: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic",],
                        datasets: [{
                            label: "Creados",
                            backgroundColor: "rgba(0,91,150, 0.3)",
                            borderColor: "#005b96",
                            borderWidth: 1,
                            hoverBackgroundColor: "rgba(0,91,150, 0.7)",
                            hoverBorderColor: "#005b96",
                            data: response.tickets,
                        },],
                    },
                        options = {
                            scales: {
                                xAxes: [{
                                    barPercentage: 0.5,
                                    barThickness: 6,
                                    maxBarThickness: 8,
                                    minBarLength: 2,
                                    gridLines: {
                                        offsetGridLines: true
                                    },
                                }],
                                yAxes: [{
                                    ticks: {
                                        stepSize: 5
                                    }
                                }]
                            },
                            animation: {
                                duration: 500,
                                easing: "easeOutQuart",
                                onComplete: function () {
                                    var ctx = this.chart.ctx;
                                    ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
                                    ctx.textAlign = 'center';
                                    ctx.textBaseline = 'bottom';

                                    this.data.datasets.forEach(function (dataset) {
                                        for (var i = 0; i < dataset.data.length; i++) {
                                            var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
                                                scale_max = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._yScale.maxHeight;
                                            ctx.fillStyle = '#444';
                                            var y_pos = model.y - 5;
                                            // Make sure data value does not get overflown and hidden
                                            // when the bar's value is too close to max value of scale
                                            // Note: The y value is reverse, it counts from top down
                                            if ((scale_max - model.y) / scale_max >= 0.93)
                                                y_pos = model.y + 20;
                                            ctx.fillText(dataset.data[i], model.x, y_pos);
                                        }
                                    });
                                }
                            }
                        };
                    self.respChart($("#ticketsGCoop"), "Bar", data, options);
                }
            });
        };

        $.ChartJs = new RespChart();
        $.ChartJs.Constructor = RespChart;
    })(window.jQuery);

    (function ($) {
        "use strict";
        $.ChartJs.init();
    })(window.jQuery);



    //Botones estadistica 1
    $("#btnMinG1").hide();
    $('#btnExpG1').on('click', function () {
        var scrollPosicion = $(window).scrollTop();
        $("#div1").removeClass('col-md-7');
        $("#div1").addClass('col-md-12');
        $("#creadoVresuelto").width(100);
        $("#btnExpG1").hide();
        $("#btnMinG1").show();
        $('#div1').animate({
            width: '100%'
        }, 500, function () {
            // Restaura la posición de la vista después de la animación
            $(window).scrollTop(scrollPosicion);
        });
    });

    $("#btnMinG1").click(function () {
        var scrollPosicion = $(window).scrollTop();
        $("#div1").removeClass('col-md-12');
        $("#div1").addClass('col-md-7');
        $("#creadoVresuelto").width(250);
        $("#btnExpG1").show();
        $("#btnMinG1").hide();
        $('#div1').animate({
            width: '50%'
        }, 500, function () {
            // Restaura la posición de la vista después de la animación
            $(window).scrollTop(scrollPosicion);
        });
    });

    //Botones estadistica 4
    $("#btnMinG4").hide();
    $("#btnExpG4").click(function () {
        var scrollPosicion = $(window).scrollTop();
        $("#div4").removeClass('col-md-6');
        $("#div4").addClass('col-md-12');
        $("#ticketsPrioridad").width(100);
        $("#btnExpG4").hide();
        $("#btnMinG4").show();
        $('#div4').animate({
            width: '100%'
        }, 500, function () {
            // Restaura la posición de la vista después de la animación
            $(window).scrollTop(scrollPosicion);
        });
    });

    $("#btnMinG4").click(function () {
        var scrollPosicion = $(window).scrollTop();
        $("#div4").removeClass('col-md-12');
        $("#div4").addClass('col-md-6');
        $("#ticketsPrioridad").width(250);
        $("#btnExpG4").show();
        $("#btnMinG4").hide();
        $('#div4').animate({
            width: '50%'
        }, 500, function () {
            // Restaura la posición de la vista después de la animación
            $(window).scrollTop(scrollPosicion);
        });
    });


    //Botones estadistica 5
    $("#btnMinG5").hide();
    $("#btnExpG5").click(function () {
        var scrollPosicion = $(window).scrollTop();
        $("#div5").removeClass('col-md-6');
        $("#div5").addClass('col-md-12');
        $("#ticketsEstatus").width(100);
        $("#btnExpG5").hide();
        $("#btnMinG5").show();
        $('#div5').animate({
            width: '100%'
        }, 500, function () {
            // Restaura la posición de la vista después de la animación
            $(window).scrollTop(scrollPosicion);
        });
    });

    $("#btnMinG5").click(function () {
        var scrollPosicion = $(window).scrollTop();
        $("#div5").removeClass('col-md-12');
        $("#div5").addClass('col-md-6');
        $("#ticketsEstatus").width(250);
        $("#btnExpG5").show();
        $("#btnMinG5").hide();
        $('#div5').animate({
            width: '50%'
        }, 500, function () {
            // Restaura la posición de la vista después de la animación
            $(window).scrollTop(scrollPosicion);
        });
    });

    //Botones estadistica 6
    $("#btnMinG6").hide();
    $("#btnExpG6").click(function () {
        var scrollPosicion = $(window).scrollTop();
        $("#div6").removeClass('col-md-6');
        $("#div6").addClass('col-md-12');
        $("#ticketsGCoop").width(100);
        $("#btnExpG6").hide();
        $("#btnMinG6").show();
        $('#div6').animate({
            width: '100%'
        }, 500, function () {
            // Restaura la posición de la vista después de la animación
            $(window).scrollTop(scrollPosicion);
        });
    });

    $("#btnMinG6").click(function () {
        var scrollPosicion = $(window).scrollTop();
        $("#div6").removeClass('col-md-12');
        $("#div6").addClass('col-md-6');
        $("#ticketsGCoop").width(250);
        $("#btnExpG6").show();
        $("#btnMinG6").hide();
        $('#div6').animate({
            width: '50%'
        }, 500, function () {
            // Restaura la posición de la vista después de la animación
            $(window).scrollTop(scrollPosicion);
        });
    });

    setInterval(function () {
        $.ChartJs.init();
    }, 300000); // 5 minutos en milisegundos
}(window.jQuery));


