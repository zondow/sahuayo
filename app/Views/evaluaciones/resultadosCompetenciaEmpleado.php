<div class="row">
    <div class="col-12">
        <div class="card-box">

            <div class="row">
                <div class="col-lg-12">

                    <div class="col-md-12 text-right">
                        <?php if (!is_null($lastEC)) {
                            echo '<a href="' . base_url('PDF/resultadosEvaluacionCompetencias/' . encryptDecrypt('encrypt', $empleado['emp_EmpleadoID'])) . '" id="printReporteCompetencias" class="btn btn-secondary"><i class="dripicons-print"></i> Imprimir resultados</a>';
                        } ?>
                    </div>


                    <div class="container task-detail" id="reporteCompetencias">

                        <ul class="list-group  list-group-horizontal">

                            <li class="list-group-item border-0">
                                <img class="rounded-circle avatar-xl img-thumbnail" src="<?= fotoPerfil(encryptDecrypt('encrypt', $empleado['emp_EmpleadoID'])) ?>">
                            </li>
                            <li class="list-group-item border-0">
                                <h4>Evaluado</h4>
                                <h5><?= $empleado['emp_Nombre'] ?></h5>
                                <p style="margin-bottom: 5px;"><?= $empleado['pue_Nombre'] ?></p>
                                <div class="row" style="margin-left: 0px;">
                                    <i class="fe-calendar pt-1"></i>
                                    <p class="mb-1 ml-1"><?= (!is_null($lastEC)) ? $lastEC['evac_Fecha'] : 'No disponible' ?></p>
                                </div>
                            </li>
                            <?php if (!empty($jefe)) { ?>
                                <li class="list-group-item border-0">
                                    <img class="rounded-circle avatar-xl img-thumbnail" src="<?= fotoPerfil(encryptDecrypt('encrypt', $jefe['emp_EmpleadoID'])) ?>">
                                </li>
                                <li class="list-group-item border-0">
                                    <h4>Jefe</h4>
                                    <h5><?= $jefe['emp_Nombre'] ?></h5>
                                    <p style="margin-bottom: 5px;"><?= $jefe['pue_Nombre'] ?></p>
                                    <div class="row" style="margin-left: 0px;">
                                        <i class="fe-calendar pt-1"></i>
                                        <p class="mb-1 ml-1"><?= (!is_null($lastEC['evac_FechaJefe'])) ? $lastEC['evac_FechaJefe'] : 'No disponible' ?></p>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>

                        <?php if (!is_null($lastEC)) { ?>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0 table-bordered ">
                                        <thead class="thead-dark" align="center">
                                            <tr>
                                                <th class="col-sm-6" style="vertical-align:middle">Competencia</th>
                                                <th class="col-sm-6" style="vertical-align:middle">Tipo</th>
                                                <th class="col-sm-2" style="vertical-align:middle">Nivel</th>
                                                <th class="col-sm-2" style="vertical-align:middle">Calificación evaluado</th>
                                                <th class="col-sm-2" style="vertical-align:middle">Porcentaje evaluado</th>
                                                <th class="col-sm-2" style="vertical-align:middle">Calificación jefe</th>
                                                <th class="col-sm-2" style="vertical-align:middle">Porcentaje jefe</th>
                                                <th class="col-sm-2" style="vertical-align:middle">Calificación </th>
                                                <th class="col-sm-2" style="vertical-align:middle">Porcentaje </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $suma = 0;
                                            $promedio = 0;
                                            $porcentajePromedio = 0;
                                            $promedioTotal = 0;
                                            $porcentajeTotal = 0;
                                            foreach ($lastEC['calificaciones'] as $calificacio) {
                                                $suma += $calificacio['Nivel'];
                                                $promedio = ($calificacio['Valor'] + $calificacio['calJefe']) / 2;
                                                $porcentajePromedio = ($calificacio['porcentaje'] + $calificacio['porJefe']) / 2;
                                            ?>
                                                <tr>
                                                    <td><?= $calificacio['comNombre'] ?> </td>
                                                    <td align="center" style="vertical-align:middle"><?= strtoupper($calificacio['com_Tipo']) ?></td>
                                                    <td align="center" style="vertical-align:middle"><?= $calificacio['Nivel'] ?></td>
                                                    <td align="center" style="vertical-align:middle"><?= number_format($calificacio['Valor'], 2, '.', ',') ?></td>
                                                    <td align="center" style="vertical-align:middle"><?= number_format($calificacio['porcentaje'], 2, '.', ',') . ' %' ?></td>
                                                    <td align="center" style="vertical-align:middle"><?= number_format($calificacio['calJefe'], 2, '.', ',') ?></td>
                                                    <td align="center" style="vertical-align:middle"><?= number_format($calificacio['porJefe'], 2, '.', ',') . ' %' ?></td>
                                                    <td align="center" style="vertical-align:middle"><?= number_format($promedio, 2, '.', ',') ?></td>
                                                    <td align="center" style="vertical-align:middle"><?= number_format($porcentajePromedio, 2, '.', ',') . ' %' ?></td>
                                                </tr>
                                            <?php
                                                $promedioTotal += $promedio;
                                                $porcentajeTotal += $porcentajePromedio;
                                            }
                                            ?>
                                            <tr class="table-success">
                                                <td style="vertical-align:middle">Total nivel</td>
                                                <td align="center" style="vertical-align:middle"></td>
                                                <td align="center" style="vertical-align:middle"><?= number_format($suma, 2, '.', ',') ?></td>
                                                <td align="center" style="vertical-align:middle"></td>
                                                <td align="center" style="vertical-align:middle"></td>
                                                <td align="center" style="vertical-align:middle"></td>
                                                <td align="center" style="vertical-align:middle">Total</td>
                                                <td align="center" style="vertical-align:middle"><?= number_format($promedioTotal, 2, '.', ',') ?></td>
                                                <td align="center" style="vertical-align:middle"><?= number_format($porcentajeTotal, 2, '.', ',') . ' %' ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="pt-5 text-center">
                                <h4>Calificación: <?= number_format($porcentajeTotal, 2, '.', ',') . ' %' ?></h4>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <h4 class="mb-4 text-center">Sociales y Actitudinales</h4>
                                    <div class="dashboard-donut-chart">
                                        <canvas id="competenciasChart0"></canvas>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <h4 class="mb-4 text-center">Tecnicas y Funcionales</h4>
                                    <div class="dashboard-donut-chart">
                                        <canvas id="competenciasChart1"></canvas>
                                    </div>
                                </div>
                            </div>

                        <?php } else { ?>

                            <div class="text-center">
                                <svg id="Layer_1" class="svg-computer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 424.2 424.2">
                                    <style>
                                        .st0 {
                                            fill: none;
                                            stroke: rgba(122, 125, 127, 0.72);
                                            stroke-width: 5;
                                            stroke-linecap: round;
                                            stroke-linejoin: round;
                                            stroke-miterlimit: 10;
                                        }
                                    </style>
                                    <g id="Layer_2">
                                        <path class="st0" d="M339.7 289h-323c-2.8 0-5-2.2-5-5V55.5c0-2.8 2.2-5 5-5h323c2.8 0 5 2.2 5 5V284c0 2.7-2.2 5-5 5z"></path>
                                        <path class="st0" d="M26.1 64.9h304.6v189.6H26.1zM137.9 288.5l-3.2 33.5h92.6l-4.4-33M56.1 332.6h244.5l24.3 41.1H34.5zM340.7 373.7s-.6-29.8 35.9-30.2c36.5-.4 35.9 30.2 35.9 30.2h-71.8z"></path>
                                        <path class="st0" d="M114.2 82.8v153.3h147V82.8zM261.2 91.1h-147"></path>
                                        <path class="st0" d="M124.5 105.7h61.8v38.7h-61.8zM196.6 170.2H249v51.7h-52.4zM196.6 105.7H249M196.6 118.6H249M196.6 131.5H249M196.6 144.4H249M124.5 157.3H249M124.5 170.2h62.2M124.5 183.2h62.2M124.5 196.1h62.2M124.5 209h62.2M124.5 221.9h62.2"></path>
                                    </g>
                                </svg>
                                <h4 class="text-danger">El resultado de esta evaluacion no se encuentra disponible por el momento. </h4>
                            </div>

                        <?php } ?>
                    </div>
                </div><!-- end col -->
            </div>

        </div>
    </div>
</div>

<?php if (!is_null($lastEC)) { ?>
    <script>
        $(document).ready(function(e) {
            var chartTooltip = {
                backgroundColor: "rgba(118,118,118,0.91)",
                titleFontColor: "#2a2a2a",
                borderColor: "rgba(209,209,209,0.87)",
                borderWidth: 1.5,
                bodyFontColor: "#ffffff",
                bodySpacing: 10,
                xPadding: 15,
                yPadding: 15,
                cornerRadius: 0.15,
                displayColors: false,
                callbacks: {
                    title: function(tooltipItem, data) {
                        return "COMPETENCIA: " + data.labels[tooltipItem[0].index];
                    },
                    label: function(tooltipItem) {
                        var text = '';
                        if (tooltipItem.datasetIndex == 0 || tooltipItem.datasetIndex == 1) {
                            text = 'Nivel observado: ';
                            if (tooltipItem.yLabel >= 0 && tooltipItem.yLabel <= 20) {
                                text += 'Carece de la competencia';
                            } else if (tooltipItem.yLabel > 20 && tooltipItem.yLabel <= 40) {
                                text += 'No demostrada';
                            } else if (tooltipItem.yLabel > 40 && tooltipItem.yLabel <= 60) {
                                text += 'En desarrollo';
                            } else if (tooltipItem.yLabel > 60 && tooltipItem.yLabel <= 80) {
                                text += 'Competente';
                            } else if (tooltipItem.yLabel > 80 && tooltipItem.yLabel <= 100) {
                                text += 'Experto';
                            }
                        } else if (tooltipItem.datasetIndex == 2) {
                            text = 'Nivel solicitado: ';
                            switch (Number(tooltipItem.yLabel)) {
                                case 20:
                                    text += 'Muy bajo';
                                    break;
                                case 40:
                                    text += 'Bajo';
                                    break;
                                case 60:
                                    text += 'Medio';
                                    break;
                                case 80:
                                    text += 'Alto';
                                    break;
                                case 100:
                                    text += 'Experto';
                                    break;
                            }
                        }
                        return text;
                    }
                }
            };

            <?php for ($i = 0; $i <= 1; $i++) { ?>
                // Resultados Evaluacion
                if (document.getElementById("competenciasChart<?= $i ?>")) {
                    var marksData = {
                        labels: [
                            <?php foreach ($lastEC['calificaciones'] as $competencia) {
                                if ($i == 0 && $competencia['com_Tipo'] == 'Sociales y Actitudinales') {
                                    echo "'" . $competencia['comNombre'] . "',";
                                } elseif ($i == 1 && $competencia['com_Tipo'] == 'Tecnicas y Funcionales') {
                                    echo "'" . $competencia['comNombre'] . "',";
                                }
                            } ?>
                        ],
                        datasets: [{
                                label: "Calificación empleado",
                                backgroundColor: "rgb(241, 128, 36, 0.4)",
                                borderColor: 'rgb(241, 128, 36)',
                                data: [
                                    <?php foreach ($lastEC['calificaciones'] as $calificacion) {
                                        if ($i == 0 && $calificacion['com_Tipo'] == 'Sociales y Actitudinales') {
                                            $auto = round($calificacion['Valor'], 2);
                                            echo "'" . $auto . "',";
                                        } elseif ($i == 1 && $calificacion['com_Tipo'] == 'Tecnicas y Funcionales') {
                                            $auto = round($calificacion['Valor'], 2);
                                            echo "'" . $auto . "',";
                                        }
                                    } ?>
                                ]
                            },
                            {
                                label: "Calificación jefe",
                                backgroundColor: "rgba(78,196,164,0.4)",
                                borderColor: 'rgb(42,140,121)',
                                data: [
                                    <?php foreach ($lastEC['calificaciones'] as $calificacion) {
                                        if ($i == 0 && $calificacion['com_Tipo'] == 'Sociales y Actitudinales') {
                                            $jefe = round($calificacion['calJefe'], 2);
                                            echo "'" . $jefe . "',";
                                        } elseif ($i == 1 && $calificacion['com_Tipo'] == 'Tecnicas y Funcionales') {
                                            $jefe = round($calificacion['calJefe'], 2);
                                            echo "'" . $jefe . "',";
                                        }
                                    } ?>
                                ]
                            },
                            {
                                label: "Calificación esperada",
                                backgroundColor: "rgba(63,104,227,0.4)",
                                borderColor: 'rgb(63,104,227)',
                                data: [
                                    <?php foreach ($lastEC['calificaciones'] as $competencia) {
                                        if ($i == 0 && $competencia['com_Tipo'] == 'Sociales y Actitudinales') {
                                            $nivel = 0;
                                            switch ($competencia['Nivel']) {
                                                case 1:
                                                    $nivel = 20;
                                                    break;
                                                case 2:
                                                    $nivel = 40;
                                                    break;
                                                case 3:
                                                    $nivel = 60;
                                                    break;
                                                case 4:
                                                    $nivel = 80;
                                                    break;
                                                case 5:
                                                    $nivel = 100;
                                                    break;
                                            }
                                            echo "'" . $nivel . "',";
                                        } elseif ($i == 1 && $competencia['com_Tipo'] == 'Tecnicas y Funcionales') {
                                            $nivel = 0;
                                            switch ($competencia['Nivel']) {
                                                case 1:
                                                    $nivel = 20;
                                                    break;
                                                case 2:
                                                    $nivel = 40;
                                                    break;
                                                case 3:
                                                    $nivel = 60;
                                                    break;
                                                case 4:
                                                    $nivel = 80;
                                                    break;
                                                case 5:
                                                    $nivel = 100;
                                                    break;
                                            }
                                            echo "'" . $nivel . "',";
                                        }
                                    } ?>
                                ]
                            }
                        ]
                    };

                    let commpetencias = document.getElementById("competenciasChart<?= $i ?>");
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
                        guardarImagen(<?= $i ?>);
                    }, 1000);
                }
            <?php } ?>

            //Guardar imagenes Graficas
            function guardarImagen(id) {
                var elementid = 'competenciasChart' + id;
                var canvasCompetenciasChart = document.getElementById(elementid);

                var dataCompetenciasChart = canvasCompetenciasChart.toDataURL('image/jpg', 1.0);

                //Ajax guardar imagen
                $.ajax({
                    url: BASE_URL + '/Evaluaciones/ajax_guardarImagenECompetencias/' + id,
                    type: 'post',
                    cache: false,
                    data: {
                        img: dataCompetenciasChart
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
<?php } ?>