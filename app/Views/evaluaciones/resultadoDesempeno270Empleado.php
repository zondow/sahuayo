<style>
    td,
    th {
        vertical-align: middle;
        text-align: center;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="card-box">

            <div class="row">
                <div class="col-lg-12">

                    <div class="col-md-12 text-right">
                        <?php

                        if (!is_null($resultados['funciones'])) {
                            echo '<a href="' . base_url('PDF/resultadosEvaluacionDesemp/' . $empleado['emp_EmpleadoID'] . "/" . $periodoID) . '" id="printReporteDesemp" class="btn btn-secondary" target="_blank" ><i class="dripicons-print"></i> Imprimir resultados</a>';
                        }
                        ?>
                    </div>

                    <div class="container task-detail" id="reporteDesempeno">

                        <ul class="list-group  list-group-horizontal">
                            <li class="list-group-item border-0">
                                <img class="rounded-circle avatar-xl img-thumbnail" src="<?= fotoPerfil(encryptDecrypt('encrypt', $empleado['emp_EmpleadoID'])) ?>">
                            </li>
                            <li class="list-group-item border-0">
                                <h5><?= $empleado['emp_Nombre'] ?></h5>
                                <p style="margin-bottom: 5px;"><?= $empleado['pue_Nombre'] ?></p>
                                <div class="row" style="margin-left: 0px;">
                                    <i class="fe-calendar pt-1"></i>
                                    <p class="mb-1 ml-1"><?= $periodoInfo['eva_FechaInicio'] . ' a ' . $periodoInfo['eva_FechaFin'] ?></p>
                                </div>
                            </li>
                        </ul>


                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0 table-bordered ">
                                    <thead class="thead-dark" align="center">
                                        <tr>
                                            <th style="width: 10%">ID</th>
                                            <th style="width: 40%">Función</th>
                                            <th style="width: 10%">Calificación colaborador</th>
                                            <th style="width: 10%">Calificación jefe</th>
                                            <th style="width: 10%">Calificación pares</th>
                                            <th style="width: 10%">Calificación subordinados</th>
                                            <th style="width: 10%">Promedio función</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $promedioFT = 0;
                                        $countFT = 0;
                                        foreach ($resultados['funciones'] as $key => $val) {

                                            $promedioF = 0;
                                            $count = 0;

                                            $auto = 'No disponible';
                                            if ((!is_null($resultados['evaAuto']['resultados']))) {
                                                $auto = round($resultados['evaAuto']['resultados'][$key]['Calificacion'], 2);
                                                $promedioF += $auto;
                                                $count++;
                                            }

                                            $jefe = 'No disponible';
                                            if ((!is_null($resultados['evaJefe']['resultados']))) {
                                                $jefe = round($resultados['evaJefe']['resultados'][$key]['Calificacion'], 2);
                                                $promedioF += $jefe;
                                                $count++;
                                            }

                                            $pares = 'No disponible';
                                            if ((!is_null($resultados['evaPares']['resultados']))) {
                                                $pares = round($resultados['evaPares']['resultados'][$key]['Promedio'], 2);
                                                $promedioF += $pares;
                                                $count++;
                                            }

                                            $sub = 'No disponible';
                                            if ((!is_null($resultados['evaSub']['resultados']))) {
                                                $sub = round($resultados['evaSub']['resultados'][$key]['Promedio'], 2);
                                                $promedioF += $sub;
                                                $count++;
                                            }


                                            if ($count > 0) {
                                                $promedioF = round($promedioF / $count, 2);
                                                $promedioFT += $promedioF;
                                                $countFT++;
                                            } else {
                                                $promedioF = 'No disponible';
                                            }
                                        ?>
                                            <tr>
                                                <td><?= $key ?></td>
                                                <td><?= $val ?></td>
                                                <td><?= $auto ?></td>
                                                <td><?= $jefe ?></td>
                                                <td><?= $pares ?></td>
                                                <td><?= $sub ?></td>
                                                <td class="table-success"><?= $promedioF ?></td>
                                            </tr>
                                        <?php
                                        }
                                        $auto = (!is_null($resultados['evaAuto']['promedio'])) ? round($resultados['evaAuto']['promedio'], 2) : 'No disponible';
                                        $jefe = (!is_null($resultados['evaJefe']['promedio'])) ? round($resultados['evaJefe']['promedio'], 2) : 'No disponible';
                                        $pares = (!is_null($resultados['evaPares']['promedio'])) ? round($resultados['evaPares']['promedio'], 2) : 'No disponible';
                                        $sub = (!is_null($resultados['evaSub']['promedio'])) ? round($resultados['evaSub']['promedio'], 2) : 'No disponible';
                                        $promedioFT = ($countFT > 0) ? round($promedioFT / $countFT, 2) : 'No disponible';
                                        ?>
                                        <tr class="table-success">
                                            <td colspan="2">Promedio Evaluador</td>
                                            <td><?= $auto ?></td>
                                            <td><?= $jefe ?></td>
                                            <td><?= $pares ?></td>
                                            <td><?= $sub ?></td>
                                            <td></td>
                                        </tr>
                                        <tr class="table-warning">
                                            <td colspan="2" style="text-align: center;vertical-align:middle">Total</td>
                                            <td colspan="5"><?= $promedioFT ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-12 col-lg-12">
                            <div class="mb-4">
                                <div class="card-body">
                                    <div class="dashboard-donut-chart">
                                        <canvas id="desempChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div><!-- end col -->
            </div>

        </div>
    </div>
</div>

<script>
    $(document).ready(function(e) {


        var chartTooltip = {
            backgroundColor: "#f9f9f9",
            titleFontColor: '#212940',
            borderColor: '#ffb734',
            borderWidth: 0.5,
            bodyFontColor: '#060606',
            bodySpacing: 10,
            xPadding: 15,
            yPadding: 15,
            cornerRadius: 0.15,
            displayColors: false,
            callbacks: {
                title: function(tooltipItem, data) {
                    return data.labels[tooltipItem[0].index];
                },
                label: function(tooltipItem) {
                    return tooltipItem.yLabel;
                }
            }

        };

        // Resultados Evaluacion
        if (document.getElementById("desempChart")) {
            var marksData = {
                labels: [
                    <?php foreach ($resultados['funciones'] as $key => $val) {
                        echo "'" . $key . "',";
                    } ?>
                ],
                datasets: [{
                        label: "Calificación colaborador",
                        backgroundColor: "rgb(241, 128, 36, 0.4)",
                        borderColor: 'rgb(241, 128, 36)',
                        data: [
                            <?php foreach ($resultados['funciones'] as $key => $val) {
                                $auto = round($resultados['evaAuto']['resultados'][$key]['Calificacion'], 2);
                                echo "'" . $auto . "',";
                            } ?>
                        ]
                    },
                    {
                        label: "Calificación jefe",
                        backgroundColor: "rgba(78,196,164,0.4)",
                        borderColor: 'rgb(42,140,121)',
                        data: [
                            <?php foreach ($resultados['funciones'] as $key => $val) {
                                $jefe=0 ;
                                if(!is_null($resultados['evaJefe']['resultados'])){
                                    $jefe = round($resultados['evaJefe']['resultados'][$key]['Calificacion'], 2);
                                }
                                echo "'" . $jefe . "',";

                            } ?>
                        ]
                    },
                    {
                        label: "Calificación pares",
                        backgroundColor: "rgba(63,104,227,0.4)",
                        borderColor: 'rgb(63,104,227)',
                        data: [
                            <?php foreach ($resultados['funciones'] as $key => $val) {
                                $pares = 0;
                                if(!is_null($resultados['evaPares']['resultados'])){
                                    $pares = round($resultados['evaPares']['resultados'][$key]['Promedio'], 2);
                                }
                                echo "'" . $pares . "',";
                            } ?>
                        ]
                    },
                    {
                        label: "Calificación subordinados",
                        backgroundColor: "rgba(255,53,77,0.4)",
                        borderColor: 'rgb(255,53,56)',
                        data: [
                            <?php foreach ($resultados['funciones'] as $key => $val) {
                                $sub = 0;
                                if(!is_null($resultados['evaSub']['resultados'])){
                                    $sub = round($resultados['evaSub']['resultados'][$key]['Promedio'], 2);
                                }
                                echo "'" . $sub . "',";
                            } ?>
                        ]
                    }
                ]
            };

            let commpetencias = document.getElementById("desempChart");
            var comp = new Chart(commpetencias, {
                type: "radar",
                data: marksData,
                options: {
                    scale: {
                        angleLines: {
                            display: false
                        },
                        ticks: {
                            suggestedMin: 0,
                            suggestedMax: 100
                        }
                    },
                    plugins: {
                        datalabels: {
                            display: false
                        }
                    },
                    tooltips: chartTooltip
                }

            });

            setTimeout(function() {
                guardarImagen();
            }, 1000);
        }

        //Guardar imagenes Graficas
        function guardarImagen() {
            var canvasDesempenoChart = document.getElementById('desempChart');

            var dataDesempenoChart = canvasDesempenoChart.toDataURL('image/jpg', 1.0);

            //Ajax guardar imagen
            $.ajax({
                url: BASE_URL + '/Evaluaciones/ajax_guardarImagenEDesemp/',
                type: 'post',
                cache: false,
                data: {
                    img: dataDesempenoChart
                }
            }).done(function(data) {
                console.log("La imagen se guardó correctamente");
            }).fail(function(data) {
                console.log("Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.");
                //console.log(data);
            }).always(function(e) {}); //Ajax guardar imagen
        }
    });
</script>