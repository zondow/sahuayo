<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div class="mb-4 row">
    <div class="col-12">
        <div class="card">
            <?php if (
                $dominio['ambienteTrabajo'] !== null &&  $dominio['cargaTrabajo'] !== null
                &&  $dominio['faltaControl'] !== null &&  $dominio['jornadaTrabajo'] !== null
                &&  $dominio['interferencia'] !== null &&  $dominio['liderazgo'] !== null
                &&  $dominio['relacionTrabajo'] !== null &&  $dominio['violencia'] !== null
            ) { ?>
                <div class="card-body m-2">
                    <div class="col-12">
                        <div class="header">
                            <h2><strong>Dominio</strong></h2>
                        </div>
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
                        <div class="header">
                            <h2><strong>Categoria</strong></h2>
                        </div>
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
                                        if ($liderazgo < 7) {
                                            $nulo = '<td class="text-center" style="background-color: #00c0f3;color:#fff "> &#10007</td>';
                                        } elseif ($liderazgo >= 7 && $liderazgo < 10) {
                                            $bajo = '<td class="text-center" style="background-color: #16a53f;color:#fff"> &#10007</td>';
                                        } elseif ($liderazgo >= 10 && $liderazgo < 13) {
                                            $medio = '<td class="text-center" style="background-color: #ffff00;color:#fff"> &#10007</td>';
                                        } elseif ($liderazgo >= 13 && $liderazgo < 16) {
                                            $alto = '<td class="text-center" style="background-color: #ff8000;color:#fff"> &#10007</td>';
                                        } elseif ($liderazgo > 16) {
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
                    <hr>
                    <div class="col-12">
                        <div class="header">
                            <h2><strong>Calificación Final</strong></h2>
                        </div>
                        <div style="overflow: auto;">
                            <table id="tbl_Final" class="data-table responsive nowrap table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="40%">Calificación</th>
                                        <th width="10%" style="background-color: #00c0f3;color:#fff">Nulo o despreciable</th>
                                        <th width="10%" style="background-color: #16a53f;color:#fff">Bajo</th>
                                        <th width="10%" style="background-color: #ffff00;color:#fff">Medio</th>
                                        <th width="10%" style="background-color: #ff8000;color:#fff">Alto</th>
                                        <th width="10%" style="background-color: #ff3600;color:#fff">Muy Alto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php
                                        $cf = $ambienteTrabajo + $factores + $organizacion + $liderazgo;
                                        $nulo = '<td class="text-center"></td>';
                                        $bajo = '<td class="text-center"></td>';
                                        $medio = '<td class="text-center"></td>';
                                        $alto = '<td class="text-center"></td>';
                                        $muyalto = '<td class="text-center"></td>';
                                        if ($cf < 20) {
                                            $nulo = '<td class="text-center" style="background-color: #00c0f3;color:#fff "> &#10007</td>';
                                        } elseif ($cf >= 20 && $cf < 45) {
                                            $bajo = '<td class="text-center" style="background-color: #16a53f;color:#fff"> &#10007</td>';
                                        } elseif ($cf >= 45 && $cf < 70) {
                                            $medio = '<td class="text-center" style="background-color: #ffff00;color:#fff"> &#10007</td>';
                                        } elseif ($cf >= 70 && $cf < 90) {
                                            $alto = '<td class="text-center" style="background-color: #ff8000;color:#fff"> &#10007</td>';
                                        } elseif ($cf >= 90) {
                                            $muyalto = '<td class="text-center" style="background-color: #ff3600;color:#fff"> &#10007</td>';
                                        }
                                        ?>
                                        <td class="text-center"><?= $cf ?></td>
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
                        <div class="header">
                            <h2><strong>Criterios para la toma de acciones</strong></h2>
                        </div>
                        <div style="overflow: auto;">
                            <table id="tbl_Criterios" class="data-table responsive nowrap table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th width="20%" style="background-color: #00c0f3;color:#fff">Nulo o despreciable</th>
                                        <th width="20%" style="background-color: #16a53f;color:#fff">Bajo</th>
                                        <th width="20%" style="background-color: #ffff00;color:#fff">Medio</th>
                                        <th width="20%" style="background-color: #ff8000;color:#fff">Alto</th>
                                        <th width="20%" style="background-color: #ff3600;color:#fff">Muy Alto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-justify">El riesgo resulta despreciable por lo que no se requiere medidas adicionales.</td>
                                        <td class="text-justify">Es necesario una mayor difusión de la política de prevención de riesgos psicosociales y programas para: la prevención de los factores de riesgo psicosocial, la promoción de un entorno organizacional favorable y la prevención de la violencia laboral.</td>
                                        <td class="text-justify">Se requiere revisar la política de prevención de riesgos psicosociales y programas para la prevención de los factores de riesgo psicosocial, la promoción de un entorno organizacional favorable y la prevención de la violencia laboral, así como reforzar su aplicación y difusión, mediante un Programa de intervención.</td>
                                        <td class="text-justify">Se requiere realizar un análisis de cada categoría y dominio, de manera que se puedan determinar las acciones de intervención apropiadas a través de un Programa de intervención, que podrá incluir una evaluación específica* y deberá incluir una campaña de sensibilización, revisar la política de prevención de riesgos psicosociales y programas para la prevención de los factores de riesgo psicosocial, la promoción de un entorno organizacional favorable y la prevención de la violencia laboral, así como reforzar su aplicación y difusión.</td>
                                        <td class="text-justify">Se requiere realizar el análisis de cada categoría y dominio para establecer las acciones de intervención apropiadas, mediante un Programa de intervención que deberá incluir evaluaciones específicas*, y contemplar campañas de sensibilización, revisar la política de prevención de riesgos psicosociales y programas para la prevención de los factores de riesgo psicosocial, la promoción de un entorno organizacional favorable y la prevención de la violencia laboral, así como reforzar su aplicación y difusión.</td>
                                    </tr>
                                </tbody>
                            </table>
                            <p class="text-muted text-center">* Evaluación específica: Aquella que se integra por el estudio a profundidad de los factores de riesgo psicosocial a través de instrumentos cuantitativos (cuestionarios), cualitativos (entrevistas) o mixtos y, en su caso, clínicos, capaces de evaluar el entorno organizacional y el efecto a la salud de los trabajadores para establecer las medidas de control y seguimiento de estos factores. Por ejemplo, la identificación del síndrome de estar quemado por el trabajo (burnout) o acoso psicológico (mobbing), entre otros.</p>
                        </div>
                        <br>
                    </div>
                </div>
            <?php } else { ?>
                <div class="card-body m-2">
                    <div class="col-12">
                        <div class="card border-secondary" style="background-color: #d3d3d3">
                            <div class="card-body text-center">
                                <p class="card-text "> El colaborador aun no ha llenado la evaluación.</p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>