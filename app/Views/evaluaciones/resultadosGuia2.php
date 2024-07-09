<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card-box">
            <div class="row" style="padding-bottom: 1%">
                <div class="col-md-12 text-left">
                    <label>* Selecciona la sucursal</label>
                    <select class="form-control select2-single" name="sucursal" id="sucursal" required>
                        <?php foreach ($sucursales as $sucursal) { ?>
                            <option value="<?= encryptDecrypt('encrypt', $sucursal['suc_SucursalID']) ?>"><?= $sucursal['suc_Sucursal'] ?></option>
                        <?php } ?>
                        <option value="<?= encryptDecrypt('encrypt', '0') ?>">TODAS</option>
                    </select>
                </div>
            </div>
            <div class="row" style="padding-bottom: 4%">
                <div class="col-md-12 text-left">
                    <label>* Selecciona el periodo</label>
                    <div class="input-daterange input-group" id="date-range">
                        <input type="text" class="form-control" id="fInicio" name="fInicio" placeholder="Seleccione inicio " required>
                        <input type="text" class="form-control" id="fFin" name="fFin" placeholder=" Seleccione fin " required>
                    </div>
                    <br>
                    <div class="text-right">
                        <button id="btn" name="btn" type="button" class="btn btn-success">Buscar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row" <?= $style ?>>
    <div class="col-12">
        <div class="card-box">
            <h4 class="header-title mb-3">Total Calificación</h4>
            <div class="card-box mb-0 widget-chart-two shadow-none" dir="ltr">
                <div class="float-right">
                    <div style="display:inline;width:80px;height:80px;">
                        <canvas width="80" height="80"></canvas>
                        <?php
                        $calificacionNiveles = [
                            ['min' => 0, 'max' => 19, 'color' => '#00c0f3', 'nivel' => 'Nulo'],
                            ['min' => 20, 'max' => 44, 'color' => '#16a53f', 'nivel' => 'Bajo'],
                            ['min' => 45, 'max' => 69, 'color' => '#ffff00', 'nivel' => 'Medio'],
                            ['min' => 70, 'max' => 89, 'color' => '#ff8000', 'nivel' => 'Alto'],
                            ['min' => 90, 'max' => PHP_INT_MAX, 'color' => '#ff3600', 'nivel' => 'Muy Alto']
                        ];
                        foreach ($calificacionNiveles as $nivelInfo) {
                            if ($calificacionFinal >= $nivelInfo['min'] && $calificacionFinal <= $nivelInfo['max']) {
                                $color = $nivelInfo['color'];
                                $nivel = $nivelInfo['nivel'];
                                break;
                            }
                        }
                        $necesidadA = db()->query("SELECT * FROM necesidadaccion WHERE nac_NivelRiesgo='" . $nivel . "'")->getRowArray();
                        ?>
                        <input data-plugin="knob" data-width="80" data-height="80" data-linecap="round" data-fgcolor="<?= $color ?>" value="<?= number_format($calificacionFinal, 2, '.', ',') ?>" data-skin="tron" data-angleoffset="180" data-readonly="true" data-thickness=".1" readonly="readonly" style="width: 44px; height: 26px; position: absolute; vertical-align: middle;
                               margin-top: 26px; margin-left: -62px; border: 0px none;
                               background: rgba(0, 0, 0, 0) none repeat scroll 0% 0%; font: bold 16px Arial;
                               text-align: center; color: rgb(10, 207, 151); padding: 0px; appearance: none;">
                    </div>
                </div>
                <div class="widget-chart-two-content text-center">
                    <p class="text-muted mb-0 mt-2">Calificación final</p>
                    <h3 class=""><?= number_format($calificacionFinal, 2, '.', ',') . ' (' . $nivel . ')' ?></h3><br>
                    <p class="text-muted mb-0 mt-2"><?= $necesidadA['nac_NecesidadAccion'] ?></p>
                </div>

            </div>
            <!-- end row -->
        </div>
    </div>
</div>
<div class="row" <?= $style ?>>
    <div class="col-6">
        <div class="card-box">
            <input hidden id="FechaInicio" name="FechaInicio" value="<?= ($FechaInicio === null) ? '' : $FechaInicio  ?>">
            <input hidden id="FechaFin" name="FechaFin" value="<?= ($FechaFin === null) ? '' : $FechaFin  ?>">
            <input hidden id="SucursalID" name="SucursalID" value="<?= ($SucursalID === null) ? '' : $SucursalID  ?>">

            <table class="table table-hover m-0 table-centered tickets-list table-actions-bar  dt-responsive nowrap" cellspacing="0" width="100%" id="datatable">
                <thead>
                    <tr>
                        <th>Acciones</th>
                        <th>Nombre</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-6">
        <div class="card-box">
            <div class="file-man-box rounded mb-3">
                <div class="file-img-box">
                    <iframe src="<?= $url ?>" frameborder="no" width="100%" style="min-height: 500px;">
                    </iframe>
                </div>

                <div class="file-man-title">
                    <h5 class="mb-0 " style="overflow: hidden">Evaluaciones aplicadas Guia I
                    </h5>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="row" <?= $style ?>>
    <div class="col-12">
        <div class="card-box">
            <a href="<?= base_url("PDF/interpretacionG2CentroTrabajo/" . $FechaInicio . "/" . $FechaFin) ?>" class="btn btn-secondary show-pdf" style="color: white" data-title="Resultados" target="_blank"><i class="fa fa-print"></i> Imprimir resultados</a>
            <div class="col-12">
                <div id="container">
                    <canvas id="canvas"></canvas>
                </div>
            </div>
            <div class="col-12">
                <div style="overflow: auto;" class="text-center" id="divTabla">
                    <table id="tbl_Dominios" class="data-table responsive nowrap table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="10%"></th>
                                <th width="10%">Condiciones del ambiente de trabajo</th>
                                <th width="10%">Carga de trabajo</th>
                                <th width="10%">Falta de control en el trabajo</th>
                                <th width="10%">Jornada de trabajo</th>
                                <th width="10%">Interf. en la relación trab-fam</th>
                                <th width="10%">Liderazgo</th>
                                <th width="10%">Relaciones en el trabajo</th>
                                <th width="10%">Violencia</th>
                            </tr>
                        </thead>
                        <tbody id="bodyTable">
                        </tbody>
                    </table>
                </div>
            </div>
            <hr>
            <div class="col-12">
                <label>
                    <h3>Dominio</h3>
                </label>
                <div style="overflow: auto;">
                    <table id="tbl_Dominio" class="data-table responsive nowrap table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="40%">Dominio</th>
                                <th width="10%">Calificación</th>
                                <th width="10%" style="background-color: #00c0f3;color:#fff">Nulo o despreciable</th>
                                <th width="10%" style="background-color: #16a53f;color:#fff">Bajo</th>
                                <th width="10%" style="background-color: #ffff00;color:#fff">Medio</th>
                                <th width="10%" style="background-color: #ff8000;color:#fff">Alto</th>
                                <th width="10%" style="background-color: #ff3600;color:#fff">Muy Alto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Condiciones en el ambiente de trabajo</td>
                                <?php
                                $nulo = '<td class="text-center"></td>';
                                $bajo = '<td class="text-center"></td>';
                                $medio = '<td class="text-center"></td>';
                                $alto = '<td class="text-center"></td>';
                                $muyalto = '<td class="text-center"></td>';
                                if ($dominio['ambienteTrabajo'] < 3) {
                                    $nulo = '<td class="text-center" style="background-color: #00c0f3;color:#fff "> &#10007</td>';
                                } elseif ($dominio['ambienteTrabajo'] >= 3 && $dominio['ambienteTrabajo'] < 5) {
                                    $bajo = '<td class="text-center" style="background-color: #16a53f;color:#fff"> &#10007</td>';
                                } elseif ($dominio['ambienteTrabajo'] >= 5 && $dominio['ambienteTrabajo'] < 7) {
                                    $medio = '<td class="text-center" style="background-color: #ffff00;color:#fff"> &#10007</td>';
                                } elseif ($dominio['ambienteTrabajo'] >= 7 && $dominio['ambienteTrabajo'] < 9) {
                                    $alto = '<td class="text-center" style="background-color: #ff8000;color:#fff"> &#10007</td>';
                                } elseif ($dominio['ambienteTrabajo'] >= 9) {
                                    $muyalto = '<td class="text-center" style="background-color: #ff3600;color:#fff"> &#10007</td>';
                                }
                                ?>
                                <td class="text-center"><?= $dominio['ambienteTrabajo'] ?></td>
                                <?= $nulo ?>
                                <?= $bajo ?>
                                <?= $medio ?>
                                <?= $alto ?>
                                <?= $muyalto ?>
                            </tr>
                            <tr>
                                <td>Carga de Trabajo</td>
                                <?php
                                $nulo = '<td class="text-center"></td>';
                                $bajo = '<td class="text-center"></td>';
                                $medio = '<td class="text-center"></td>';
                                $alto = '<td class="text-center"></td>';
                                $muyalto = '<td class="text-center"></td>';
                                if ($dominio['cargaTrabajo'] < 12) {
                                    $nulo = '<td class="text-center" style="background-color: #00c0f3;color:#fff "> &#10007</td>';
                                } elseif ($dominio['cargaTrabajo'] >= 12 && $dominio['cargaTrabajo'] < 16) {
                                    $bajo = '<td class="text-center" style="background-color: #16a53f;color:#fff"> &#10007</td>';
                                } elseif ($dominio['cargaTrabajo'] >= 16 && $dominio['cargaTrabajo'] < 20) {
                                    $medio = '<td class="text-center" style="background-color: #ffff00;color:#fff"> &#10007</td>';
                                } elseif ($dominio['cargaTrabajo'] >= 20 && $dominio['cargaTrabajo'] < 24) {
                                    $alto = '<td class="text-center" style="background-color: #ff8000;color:#fff"> &#10007</td>';
                                } elseif ($dominio['cargaTrabajo'] >= 24) {
                                    $muyalto = '<td class="text-center" style="background-color: #ff3600;color:#fff"> &#10007</td>';
                                }
                                ?>
                                <td class="text-center"><?= $dominio['cargaTrabajo'] ?></td>
                                <?= $nulo ?>
                                <?= $bajo ?>
                                <?= $medio ?>
                                <?= $alto ?>
                                <?= $muyalto ?>
                            </tr>
                            <tr>
                                <td>Falta de control sobre el trabajo</td>
                                <?php
                                $nulo = '<td class="text-center"></td>';
                                $bajo = '<td class="text-center"></td>';
                                $medio = '<td class="text-center"></td>';
                                $alto = '<td class="text-center"></td>';
                                $muyalto = '<td class="text-center"></td>';
                                if ($dominio['faltaControl'] < 5) {
                                    $nulo = '<td class="text-center" style="background-color: #00c0f3;color:#fff "> &#10007</td>';
                                } elseif ($dominio['faltaControl'] >= 5 && $dominio['faltaControl'] < 8) {
                                    $bajo = '<td class="text-center" style="background-color: #16a53f;color:#fff"> &#10007</td>';
                                } elseif ($dominio['faltaControl'] >= 8 && $dominio['faltaControl'] < 11) {
                                    $medio = '<td class="text-center" style="background-color: #ffff00;color:#fff"> &#10007</td>';
                                } elseif ($dominio['faltaControl'] >= 11 && $dominio['faltaControl'] < 14) {
                                    $alto = '<td class="text-center" style="background-color: #ff8000;color:#fff"> &#10007</td>';
                                } elseif ($dominio['faltaControl'] >= 14) {
                                    $muyalto = '<td class="text-center" style="background-color: #ff3600;color:#fff"> &#10007</td>';
                                }
                                ?>
                                <td class="text-center"><?= $dominio['faltaControl'] ?></td>
                                <?= $nulo ?>
                                <?= $bajo ?>
                                <?= $medio ?>
                                <?= $alto ?>
                                <?= $muyalto ?>
                            </tr>
                            <tr>
                                <td>Jornada de trabajo</td>
                                <?php
                                $nulo = '<td class="text-center"></td>';
                                $bajo = '<td class="text-center"></td>';
                                $medio = '<td class="text-center"></td>';
                                $alto = '<td class="text-center"></td>';
                                $muyalto = '<td class="text-center"></td>';
                                if ($dominio['jornadaTrabajo'] < 1) {
                                    $nulo = '<td class="text-center" style="background-color: #00c0f3;color:#fff "> &#10007</td>';
                                } elseif ($dominio['jornadaTrabajo'] >= 1 && $dominio['jornadaTrabajo'] < 2) {
                                    $bajo = '<td class="text-center" style="background-color: #16a53f;color:#fff"> &#10007</td>';
                                } elseif ($dominio['jornadaTrabajo'] >= 2 && $dominio['jornadaTrabajo'] < 4) {
                                    $medio = '<td class="text-center" style="background-color: #ffff00;color:#fff"> &#10007</td>';
                                } elseif ($dominio['jornadaTrabajo'] >= 4 && $dominio['jornadaTrabajo'] < 6) {
                                    $alto = '<td class="text-center" style="background-color: #ff8000;color:#fff"> &#10007</td>';
                                } elseif ($dominio['jornadaTrabajo'] >= 6) {
                                    $muyalto = '<td class="text-center" style="background-color: #ff3600;color:#fff"> &#10007</td>';
                                }
                                ?>
                                <td class="text-center"><?= $dominio['jornadaTrabajo'] ?></td>
                                <?= $nulo ?>
                                <?= $bajo ?>
                                <?= $medio ?>
                                <?= $alto ?>
                                <?= $muyalto ?>
                            </tr>
                            <tr>
                                <td>Interferencia en la relación trabajo familia</td>
                                <?php
                                $nulo = '<td class="text-center"></td>';
                                $bajo = '<td class="text-center"></td>';
                                $medio = '<td class="text-center"></td>';
                                $alto = '<td class="text-center"></td>';
                                $muyalto = '<td class="text-center"></td>';
                                if ($dominio['interferencia'] < 1) {
                                    $nulo = '<td class="text-center" style="background-color: #00c0f3;color:#fff "> &#10007</td>';
                                } elseif ($dominio['interferencia'] >= 1 && $dominio['interferencia'] < 2) {
                                    $bajo = '<td class="text-center" style="background-color: #16a53f;color:#fff"> &#10007</td>';
                                } elseif ($dominio['interferencia'] >= 2 && $dominio['interferencia'] < 4) {
                                    $medio = '<td class="text-center" style="background-color: #ffff00;color:#fff"> &#10007</td>';
                                } elseif ($dominio['interferencia'] >= 4 && $dominio['interferencia'] < 6) {
                                    $alto = '<td class="text-center" style="background-color: #ff8000;color:#fff"> &#10007</td>';
                                } elseif ($dominio['interferencia'] >= 6) {
                                    $muyalto = '<td class="text-center" style="background-color: #ff3600;color:#fff"> &#10007</td>';
                                }
                                ?>
                                <td class="text-center"><?= $dominio['interferencia'] ?></td>
                                <?= $nulo ?>
                                <?= $bajo ?>
                                <?= $medio ?>
                                <?= $alto ?>
                                <?= $muyalto ?>
                            </tr>
                            <tr>
                                <td>Liderazgo</td>
                                <?php
                                $nulo = '<td class="text-center"></td>';
                                $bajo = '<td class="text-center"></td>';
                                $medio = '<td class="text-center"></td>';
                                $alto = '<td class="text-center"></td>';
                                $muyalto = '<td class="text-center"></td>';
                                if ($dominio['liderazgo'] < 3) {
                                    $nulo = '<td class="text-center" style="background-color: #00c0f3;color:#fff "> &#10007</td>';
                                } elseif ($dominio['liderazgo'] >= 3 && $dominio['liderazgo'] < 5) {
                                    $bajo = '<td class="text-center" style="background-color: #16a53f;color:#fff"> &#10007</td>';
                                } elseif ($dominio['liderazgo'] >= 5 && $dominio['liderazgo'] < 8) {
                                    $medio = '<td class="text-center" style="background-color: #ffff00;color:#fff"> &#10007</td>';
                                } elseif ($dominio['liderazgo'] >= 8 && $dominio['liderazgo'] < 11) {
                                    $alto = '<td class="text-center" style="background-color: #ff8000;color:#fff"> &#10007</td>';
                                } elseif ($dominio['liderazgo'] >= 11) {
                                    $muyalto = '<td class="text-center" style="background-color: #ff3600;color:#fff"> &#10007</td>';
                                }
                                ?>
                                <td class="text-center"><?= $dominio['liderazgo'] ?></td>
                                <?= $nulo ?>
                                <?= $bajo ?>
                                <?= $medio ?>
                                <?= $alto ?>
                                <?= $muyalto ?>
                            </tr>
                            <tr>
                                <td>Relaciones en el trabajo</td>
                                <?php
                                $nulo = '<td class="text-center"></td>';
                                $bajo = '<td class="text-center"></td>';
                                $medio = '<td class="text-center"></td>';
                                $alto = '<td class="text-center"></td>';
                                $muyalto = '<td class="text-center"></td>';
                                if ($dominio['relacionTrabajo'] < 5) {
                                    $nulo = '<td class="text-center" style="background-color: #00c0f3;color:#fff "> &#10007</td>';
                                } elseif ($dominio['relacionTrabajo'] >= 5 && $dominio['relacionTrabajo'] < 8) {
                                    $bajo = '<td class="text-center" style="background-color: #16a53f;color:#fff"> &#10007</td>';
                                } elseif ($dominio['relacionTrabajo'] >= 8 && $dominio['relacionTrabajo'] < 11) {
                                    $medio = '<td class="text-center" style="background-color: #ffff00;color:#fff"> &#10007</td>';
                                } elseif ($dominio['relacionTrabajo'] >= 11 && $dominio['relacionTrabajo'] < 14) {
                                    $alto = '<td class="text-center" style="background-color: #ff8000;color:#fff"> &#10007</td>';
                                } elseif ($dominio['relacionTrabajo'] >= 14) {
                                    $muyalto = '<td class="text-center" style="background-color: #ff3600;color:#fff"> &#10007</td>';
                                }
                                ?>
                                <td class="text-center"><?= $dominio['relacionTrabajo'] ?></td>
                                <?= $nulo ?>
                                <?= $bajo ?>
                                <?= $medio ?>
                                <?= $alto ?>
                                <?= $muyalto ?>
                            </tr>
                            <tr>
                                <td>Violencia</td>
                                <?php
                                $nulo = '<td class="text-center"></td>';
                                $bajo = '<td class="text-center"></td>';
                                $medio = '<td class="text-center"></td>';
                                $alto = '<td class="text-center"></td>';
                                $muyalto = '<td class="text-center"></td>';
                                if ($dominio['violencia'] < 7) {
                                    $nulo = '<td class="text-center" style="background-color: #00c0f3;color:#fff "> &#10007</td>';
                                } elseif ($dominio['violencia'] >= 7 && $dominio['violencia'] < 10) {
                                    $bajo = '<td class="text-center" style="background-color: #16a53f;color:#fff"> &#10007</td>';
                                } elseif ($dominio['violencia'] >= 10 && $dominio['violencia'] < 13) {
                                    $medio = '<td class="text-center" style="background-color: #ffff00;color:#fff"> &#10007</td>';
                                } elseif ($dominio['violencia'] >= 13 && $dominio['violencia'] < 16) {
                                    $alto = '<td class="text-center" style="background-color: #ff8000;color:#fff"> &#10007</td>';
                                } elseif ($dominio['violencia'] >= 16) {
                                    $muyalto = '<td class="text-center" style="background-color: #ff3600;color:#fff"> &#10007</td>';
                                }
                                ?>
                                <td class="text-center"><?= $dominio['violencia'] ?></td>
                                <?= $nulo ?>
                                <?= $bajo ?>
                                <?= $medio ?>
                                <?= $alto ?>
                                <?= $muyalto ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <br>
            </div>
            <hr>
            <div class="col-12">
                <label>
                    <h3>Categoria</h3>
                </label>
                <div style="overflow: auto;">
                    <table id="tbl_Categoria" class="data-table responsive nowrap table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="40%">Categoria</th>
                                <th width="10%">Calificación</th>
                                <th width="10%" style="background-color: #00c0f3;color:#fff">Nulo o despreciable</th>
                                <th width="10%" style="background-color: #16a53f;color:#fff">Bajo</th>
                                <th width="10%" style="background-color: #ffff00;color:#fff">Medio</th>
                                <th width="10%" style="background-color: #ff8000;color:#fff">Alto</th>
                                <th width="10%" style="background-color: #ff3600;color:#fff">Muy Alto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Ambiente de trabajo</td>
                                <?php
                                $ambienteTrabajo = $dominio['ambienteTrabajo'];
                                $nulo = '<td class="text-center"></td>';
                                $bajo = '<td class="text-center"></td>';
                                $medio = '<td class="text-center"></td>';
                                $alto = '<td class="text-center"></td>';
                                $muyalto = '<td class="text-center"></td>';
                                if ($ambienteTrabajo < 3) {
                                    $nulo = '<td class="text-center" style="background-color: #00c0f3;color:#fff "> &#10007</td>';
                                } elseif ($ambienteTrabajo >= 3 && $ambienteTrabajo < 5) {
                                    $bajo = '<td class="text-center" style="background-color: #16a53f;color:#fff"> &#10007</td>';
                                } elseif ($ambienteTrabajo >= 5 && $ambienteTrabajo < 7) {
                                    $medio = '<td class="text-center" style="background-color: #ffff00;color:#fff"> &#10007</td>';
                                } elseif ($ambienteTrabajo >= 7 && $ambienteTrabajo < 9) {
                                    $alto = '<td class="text-center" style="background-color: #ff8000;color:#fff"> &#10007</td>';
                                } elseif ($ambienteTrabajo >= 9) {
                                    $muyalto = '<td class="text-center" style="background-color: #ff3600;color:#fff"> &#10007</td>';
                                }
                                ?>
                                <td class="text-center"><?= $ambienteTrabajo ?></td>
                                <?= $nulo ?>
                                <?= $bajo ?>
                                <?= $medio ?>
                                <?= $alto ?>
                                <?= $muyalto ?>
                            </tr>
                            <tr>
                                <td>Factores propios de la actividad</td>
                                <?php
                                $factores = (int)$dominio['cargaTrabajo'] + (int)$dominio['faltaControl'];
                                $nulo = '<td class="text-center"></td>';
                                $bajo = '<td class="text-center"></td>';
                                $medio = '<td class="text-center"></td>';
                                $alto = '<td class="text-center"></td>';
                                $muyalto = '<td class="text-center"></td>';
                                if ($factores < 10) {
                                    $nulo = '<td class="text-center" style="background-color: #00c0f3;color:#fff "> &#10007</td>';
                                } elseif ($factores >= 10 && $factores < 20) {
                                    $bajo = '<td class="text-center" style="background-color: #16a53f;color:#fff"> &#10007</td>';
                                } elseif ($factores >= 20 && $factores < 30) {
                                    $medio = '<td class="text-center" style="background-color: #ffff00;color:#fff"> &#10007</td>';
                                } elseif ($factores >= 30 && $factores < 40) {
                                    $alto = '<td class="text-center" style="background-color: #ff8000;color:#fff"> &#10007</td>';
                                } elseif ($factores >= 40) {
                                    $muyalto = '<td class="text-center" style="background-color: #ff3600;color:#fff"> &#10007</td>';
                                }
                                ?>
                                <td class="text-center"><?= $factores ?></td>
                                <?= $nulo ?>
                                <?= $bajo ?>
                                <?= $medio ?>
                                <?= $alto ?>
                                <?= $muyalto ?>
                            </tr>
                            <tr>
                                <td>Organización del tiempo de trabajo</td>
                                <?php
                                $organizacion = (int)$dominio['jornadaTrabajo'] + (int)$dominio['interferencia'];
                                $nulo = '<td class="text-center"></td>';
                                $bajo = '<td class="text-center"></td>';
                                $medio = '<td class="text-center"></td>';
                                $alto = '<td class="text-center"></td>';
                                $muyalto = '<td class="text-center"></td>';
                                if ($organizacion < 4) {
                                    $nulo = '<td class="text-center" style="background-color: #00c0f3;color:#fff "> &#10007</td>';
                                } elseif ($organizacion >= 4 && $organizacion < 6) {
                                    $bajo = '<td class="text-center" style="background-color: #16a53f;color:#fff"> &#10007</td>';
                                } elseif ($organizacion >= 6 && $organizacion < 9) {
                                    $medio = '<td class="text-center" style="background-color: #ffff00;color:#fff"> &#10007</td>';
                                } elseif ($organizacion >= 9 && $organizacion < 12) {
                                    $alto = '<td class="text-center" style="background-color: #ff8000;color:#fff"> &#10007</td>';
                                } elseif ($organizacion >= 12) {
                                    $muyalto = '<td class="text-center" style="background-color: #ff3600;color:#fff"> &#10007</td>';
                                }
                                ?>
                                <td class="text-center"><?= $organizacion ?></td>
                                <?= $nulo ?>
                                <?= $bajo ?>
                                <?= $medio ?>
                                <?= $alto ?>
                                <?= $muyalto ?>
                            </tr>
                            <tr>
                                <td>Liderazgo y relaciones en el trabajo</td>
                                <?php
                                $liderazgo = (int)$dominio['liderazgo'] + (int)$dominio['relacionTrabajo'] + (int)$dominio['violencia'];
                                $nulo = '<td class="text-center"></td>';
                                $bajo = '<td class="text-center"></td>';
                                $medio = '<td class="text-center"></td>';
                                $alto = '<td class="text-center"></td>';
                                $muyalto = '<td class="text-center"></td>';
                                if ($liderazgo < 10) {
                                    $nulo = '<td class="text-center" style="background-color: #00c0f3;color:#fff "> &#10007</td>';
                                } elseif ($liderazgo >= 10 && $liderazgo < 18) {
                                    $bajo = '<td class="text-center" style="background-color: #16a53f;color:#fff"> &#10007</td>';
                                } elseif ($liderazgo >= 18 && $liderazgo < 28) {
                                    $medio = '<td class="text-center" style="background-color: #ffff00;color:#fff"> &#10007</td>';
                                } elseif ($liderazgo >= 28 && $liderazgo < 38) {
                                    $alto = '<td class="text-center" style="background-color: #ff8000;color:#fff"> &#10007</td>';
                                } elseif ($liderazgo >= 38) {
                                    $muyalto = '<td class="text-center" style="background-color: #ff3600;color:#fff"> &#10007</td>';
                                }
                                ?>
                                <td class="text-center"><?= $liderazgo ?></td>
                                <?= $nulo ?>
                                <?= $bajo ?>
                                <?= $medio ?>
                                <?= $alto ?>
                                <?= $muyalto ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <br>
            </div>
        </div>
    </div>

</div>