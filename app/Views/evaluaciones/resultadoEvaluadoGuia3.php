<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div class="mb-4 row">
    <div class="col-12">
        <div class="card">
            <?php if($dominio['ambienteTrabajo']!==null &&  $dominio['cargaT']!==null
                &&  $dominio['faltaC']!==null &&  $dominio['jornadaT']!==null
                &&  $dominio['interferencia']!==null &&  $dominio['liderazgo']!==null
                &&  $dominio['relacionT']!==null &&  $dominio['violencia']!==null
                &&  $dominio['reconocimiento']!==null &&  $dominio['insuficiente']!==null
                ){?>
            <div class="card-body m-2">
                <div class="col-12">
                    <label><h3>Dominio</h3></label>
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
                                $dominio['ambienteTrabajo']=number_format($dominio['ambienteTrabajo'],2);
                                $nulo = '<td class="text-center"></td>';$bajo = '<td class="text-center"></td>';$medio = '<td class="text-center"></td>';$alto = '<td class="text-center"></td>';$muyalto = '<td class="text-center"></td>';
                                if($dominio['ambienteTrabajo']< 5){
                                    $nulo = '<td class="text-center" style="background-color: #00c0f3;color:#fff "> &#10007</td>';
                                }elseif($dominio['ambienteTrabajo'] >= 5 && $dominio['ambienteTrabajo'] <9){
                                    $bajo = '<td class="text-center" style="background-color: #16a53f;color:#fff"> &#10007</td>';
                                }elseif($dominio['ambienteTrabajo'] >= 9 && $dominio['ambienteTrabajo'] <11){
                                    $medio= '<td class="text-center" style="background-color: #ffff00;color:#fff"> &#10007</td>';
                                }elseif($dominio['ambienteTrabajo'] >= 11 && $dominio['ambienteTrabajo'] <14){
                                    $alto= '<td class="text-center" style="background-color: #ff8000;color:#fff"> &#10007</td>';
                                }elseif($dominio['ambienteTrabajo'] >=14){
                                    $muyalto= '<td class="text-center" style="background-color: #ff3600;color:#fff"> &#10007</td>';
                                }
                                ?>
                                <td class="text-center"><?=$dominio['ambienteTrabajo']?></td>
                                <?= $nulo ?>
                                <?= $bajo ?>
                                <?= $medio ?>
                                <?= $alto ?>
                                <?= $muyalto ?>
                            </tr>
                            <tr>
                                <td>Carga de Trabajo</td>
                                <?php
                                $dominio['cargaT']=number_format($dominio['cargaT'],2);
                                $nulo = '<td class="text-center"></td>';$bajo = '<td class="text-center"></td>';$medio = '<td class="text-center"></td>';$alto = '<td class="text-center"></td>';$muyalto = '<td class="text-center"></td>';
                                if($dominio['cargaT']< 15){
                                    $nulo = '<td class="text-center" style="background-color: #00c0f3;color:#fff "> &#10007</td>';
                                }elseif($dominio['cargaT'] >= 15 && $dominio['cargaT'] <21){
                                    $bajo = '<td class="text-center" style="background-color: #16a53f;color:#fff"> &#10007</td>';
                                }elseif($dominio['cargaT'] >= 21 && $dominio['cargaT'] <27){
                                    $medio= '<td class="text-center" style="background-color: #ffff00;color:#fff"> &#10007</td>';
                                }elseif($dominio['cargaT'] >= 27 && $dominio['cargaT'] <37){
                                    $alto= '<td class="text-center" style="background-color: #ff8000;color:#fff"> &#10007</td>';
                                }elseif($dominio['cargaT'] >=37){
                                    $muyalto= '<td class="text-center" style="background-color: #ff3600;color:#fff"> &#10007</td>';
                                }
                                ?>
                                <td class="text-center" ><?=$dominio['cargaT']?></td>
                                <?= $nulo ?>
                                <?= $bajo ?>
                                <?= $medio ?>
                                <?= $alto ?>
                                <?= $muyalto ?>
                            </tr>
                            <tr>
                                <td>Falta de control sobre el trabajo</td>
                                <?php
                                $dominio['faltaC']=number_format($dominio['faltaC'],2);
                                $nulo = '<td class="text-center"></td>';$bajo = '<td class="text-center"></td>';$medio = '<td class="text-center"></td>';$alto = '<td class="text-center"></td>';$muyalto = '<td class="text-center"></td>';
                                if($dominio['faltaC']< 11){
                                    $nulo = '<td class="text-center" style="background-color: #00c0f3;color:#fff "> &#10007</td>';
                                }elseif($dominio['faltaC'] >= 11 && $dominio['faltaC'] <16){
                                    $bajo = '<td class="text-center" style="background-color: #16a53f;color:#fff"> &#10007</td>';
                                }elseif($dominio['faltaC'] >= 16 && $dominio['faltaC'] <21){
                                    $medio= '<td class="text-center" style="background-color: #ffff00;color:#fff"> &#10007</td>';
                                }elseif($dominio['faltaC'] >= 21 && $dominio['faltaC'] <25){
                                    $alto= '<td class="text-center" style="background-color: #ff8000;color:#fff"> &#10007</td>';
                                }elseif($dominio['faltaC'] >=25){
                                    $muyalto= '<td class="text-center" style="background-color: #ff3600;color:#fff"> &#10007</td>';
                                }
                                ?>
                                <td class="text-center" ><?=$dominio['faltaC']?></td>
                                <?= $nulo ?>
                                <?= $bajo ?>
                                <?= $medio ?>
                                <?= $alto ?>
                                <?= $muyalto ?>
                            </tr>
                            <tr>
                                <td>Jornada de trabajo</td>
                                <?php
                                $dominio['jornadaT']=number_format($dominio['jornadaT'],2);
                                $nulo = '<td class="text-center"></td>';$bajo = '<td class="text-center"></td>';$medio = '<td class="text-center"></td>';$alto = '<td class="text-center"></td>';$muyalto = '<td class="text-center"></td>';
                                if($dominio['jornadaT']< 1){
                                    $nulo = '<td class="text-center" style="background-color: #00c0f3;color:#fff "> &#10007</td>';
                                }elseif($dominio['jornadaT'] >= 1 && $dominio['jornadaT'] <2){
                                    $bajo = '<td class="text-center" style="background-color: #16a53f;color:#fff"> &#10007</td>';
                                }elseif($dominio['jornadaT'] >= 2 && $dominio['jornadaT'] <4){
                                    $medio= '<td class="text-center" style="background-color: #ffff00;color:#fff"> &#10007</td>';
                                }elseif($dominio['jornadaT'] >= 4 && $dominio['jornadaT'] <6){
                                    $alto= '<td class="text-center" style="background-color: #ff8000;color:#fff"> &#10007</td>';
                                }elseif($dominio['jornadaT'] >=6){
                                    $muyalto= '<td class="text-center" style="background-color: #ff3600;color:#fff"> &#10007</td>';
                                }
                                ?>
                                <td class="text-center" ><?=$dominio['jornadaT']?></td>
                                <?= $nulo ?>
                                <?= $bajo ?>
                                <?= $medio ?>
                                <?= $alto ?>
                                <?= $muyalto ?>
                            </tr>
                            <tr>
                                <td>Interferencia en la relación trabajo familia</td>
                                <?php
                                $dominio['interferencia']=number_format($dominio['interferencia'],2);
                                $nulo = '<td class="text-center"></td>';$bajo = '<td class="text-center"></td>';$medio = '<td class="text-center"></td>';$alto = '<td class="text-center"></td>';$muyalto = '<td class="text-center"></td>';
                                if($dominio['interferencia']< 4){
                                    $nulo = '<td class="text-center" style="background-color: #00c0f3;color:#fff "> &#10007</td>';
                                }elseif($dominio['interferencia'] >= 4 && $dominio['interferencia'] <6){
                                    $bajo = '<td class="text-center" style="background-color: #16a53f;color:#fff"> &#10007</td>';
                                }elseif($dominio['interferencia'] >= 6 && $dominio['interferencia'] <8){
                                    $medio= '<td class="text-center" style="background-color: #ffff00;color:#fff"> &#10007</td>';
                                }elseif($dominio['interferencia'] >= 8 && $dominio['interferencia'] <10){
                                    $alto= '<td class="text-center" style="background-color: #ff8000;color:#fff"> &#10007</td>';
                                }elseif($dominio['interferencia'] >=10){
                                    $muyalto= '<td class="text-center" style="background-color: #ff3600;color:#fff"> &#10007</td>';
                                }
                                ?>
                                <td class="text-center" ><?=$dominio['interferencia']?></td>
                                <?= $nulo ?>
                                <?= $bajo ?>
                                <?= $medio ?>
                                <?= $alto ?>
                                <?= $muyalto ?>
                            </tr>
                            <tr>
                                <td>Liderazgo</td>
                                <?php
                                $dominio['liderazgo']=number_format($dominio['liderazgo'],2);
                                $nulo = '<td class="text-center"></td>';$bajo = '<td class="text-center"></td>';$medio = '<td class="text-center"></td>';$alto = '<td class="text-center"></td>';$muyalto = '<td class="text-center"></td>';
                                if($dominio['liderazgo']< 9){
                                    $nulo = '<td class="text-center" style="background-color: #00c0f3;color:#fff "> &#10007</td>';
                                }elseif($dominio['liderazgo'] >= 9 && $dominio['liderazgo'] <12){
                                    $bajo = '<td class="text-center" style="background-color: #16a53f;color:#fff"> &#10007</td>';
                                }elseif($dominio['liderazgo'] >= 12 && $dominio['liderazgo'] <16){
                                    $medio= '<td class="text-center" style="background-color: #ffff00;color:#fff"> &#10007</td>';
                                }elseif($dominio['liderazgo'] >= 16 && $dominio['liderazgo'] <20){
                                    $alto= '<td class="text-center" style="background-color: #ff8000;color:#fff"> &#10007</td>';
                                }elseif($dominio['liderazgo'] >=20){
                                    $muyalto= '<td class="text-center" style="background-color: #ff3600;color:#fff"> &#10007</td>';
                                }
                                ?>
                                <td class="text-center" ><?=$dominio['liderazgo']?></td>
                                <?= $nulo ?>
                                <?= $bajo ?>
                                <?= $medio ?>
                                <?= $alto ?>
                                <?= $muyalto ?>
                            </tr>
                            <tr>
                                <td>Relaciones en el trabajo</td>
                                <?php
                                $dominio['relacionT']=number_format($dominio['relacionT'],2);
                                $nulo = '<td class="text-center"></td>';$bajo = '<td class="text-center"></td>';$medio = '<td class="text-center"></td>';$alto = '<td class="text-center"></td>';$muyalto = '<td class="text-center"></td>';
                                if($dominio['relacionT']< 10){
                                    $nulo = '<td class="text-center" style="background-color: #00c0f3;color:#fff "> &#10007</td>';
                                }elseif($dominio['relacionT'] >= 10 && $dominio['relacionT'] <13){
                                    $bajo = '<td class="text-center" style="background-color: #16a53f;color:#fff"> &#10007</td>';
                                }elseif($dominio['relacionT'] >= 13 && $dominio['relacionT'] <17){
                                    $medio= '<td class="text-center" style="background-color: #ffff00;color:#fff"> &#10007</td>';
                                }elseif($dominio['relacionT'] >= 17 && $dominio['relacionT'] <21){
                                    $alto= '<td class="text-center" style="background-color: #ff8000;color:#fff"> &#10007</td>';
                                }elseif($dominio['relacionT'] >=21){
                                    $muyalto= '<td class="text-center" style="background-color: #ff3600;color:#fff"> &#10007</td>';
                                }
                                ?>
                                <td class="text-center" ><?=$dominio['relacionT']?></td>
                                <?= $nulo ?>
                                <?= $bajo ?>
                                <?= $medio ?>
                                <?= $alto ?>
                                <?= $muyalto ?>
                            </tr>
                            <tr>
                                <td>Violencia</td>
                                <?php
                                $dominio['violencia']=number_format($dominio['violencia'],2);
                                $nulo = '<td class="text-center"></td>';$bajo = '<td class="text-center"></td>';$medio = '<td class="text-center"></td>';$alto = '<td class="text-center"></td>';$muyalto = '<td class="text-center"></td>';
                                if($dominio['violencia']< 7){
                                    $nulo = '<td class="text-center" style="background-color: #00c0f3;color:#fff "> &#10007</td>';
                                }elseif($dominio['violencia'] >= 7 && $dominio['violencia'] <10){
                                    $bajo = '<td class="text-center" style="background-color: #16a53f;color:#fff"> &#10007</td>';
                                }elseif($dominio['violencia'] >= 10 && $dominio['violencia'] <13){
                                    $medio= '<td class="text-center" style="background-color: #ffff00;color:#fff"> &#10007</td>';
                                }elseif($dominio['violencia'] >= 13 && $dominio['violencia'] <16){
                                    $alto= '<td class="text-center" style="background-color: #ff8000;color:#fff"> &#10007</td>';
                                }elseif($dominio['violencia'] >=16){
                                    $muyalto= '<td class="text-center" style="background-color: #ff3600;color:#fff"> &#10007</td>';
                                }
                                ?>
                                <td class="text-center" ><?=$dominio['violencia']?></td>
                                <?= $nulo ?>
                                <?= $bajo ?>
                                <?= $medio ?>
                                <?= $alto ?>
                                <?= $muyalto ?>
                            </tr>
                            <tr>
                            <td>Reconocimiento del desempeño</td>
                            <?php
                            $dominio['reconocimiento']=number_format($dominio['reconocimiento'],2);
                            $nulo = '<td class="text-center"></td>';$bajo = '<td class="text-center"></td>';$medio = '<td class="text-center"></td>';$alto = '<td class="text-center"></td>';$muyalto = '<td class="text-center"></td>';
                            if($dominio['reconocimiento']< 6){
                                $nulo = '<td class="text-center" style="background-color: #00c0f3;color:#fff "> &#10007</td>';
                            }elseif($dominio['reconocimiento'] >= 6 && $dominio['reconocimiento'] <10){
                                $bajo = '<td class="text-center" style="background-color: #16a53f;color:#fff"> &#10007</td>';
                            }elseif($dominio['reconocimiento'] >= 10 && $dominio['reconocimiento'] <14){
                                $medio= '<td class="text-center" style="background-color: #ffff00;color:#fff"> &#10007</td>';
                            }elseif($dominio['reconocimiento'] >= 14 && $dominio['reconocimiento'] <18){
                                $alto= '<td class="text-center" style="background-color: #ff8000;color:#fff"> &#10007</td>';
                            }elseif($dominio['reconocimiento'] >=18){
                                $muyalto= '<td class="text-center" style="background-color: #ff3600;color:#fff"> &#10007</td>';
                            }
                            ?>
                            <td class="text-center" ><?=$dominio['reconocimiento']?></td>
                            <?= $nulo ?>
                            <?= $bajo ?>
                            <?= $medio ?>
                            <?= $alto ?>
                            <?= $muyalto ?>
                        </tr>

                        <tr>
                            <td>Insuficiente sentido de pertenencia</td>
                            <?php
                            $dominio['insuficiente']=number_format($dominio['insuficiente'],2);
                            $nulo = '<td class="text-center"></td>';$bajo = '<td class="text-center"></td>';$medio = '<td class="text-center"></td>';$alto = '<td class="text-center"></td>';$muyalto = '<td class="text-center"></td>';
                            if($dominio['insuficiente']< 4){
                                $nulo = '<td class="text-center" style="background-color: #00c0f3;color:#fff "> &#10007</td>';
                            }elseif($dominio['insuficiente'] >= 4 && $dominio['insuficiente'] <6){
                                $bajo = '<td class="text-center" style="background-color: #16a53f;color:#fff"> &#10007</td>';
                            }elseif($dominio['insuficiente'] >= 6 && $dominio['insuficiente'] <8){
                                $medio= '<td class="text-center" style="background-color: #ffff00;color:#fff"> &#10007</td>';
                            }elseif($dominio['insuficiente'] >= 8 && $dominio['insuficiente'] <10){
                                $alto= '<td class="text-center" style="background-color: #ff8000;color:#fff"> &#10007</td>';
                            }elseif($dominio['insuficiente'] >=10){
                                $muyalto= '<td class="text-center" style="background-color: #ff3600;color:#fff"> &#10007</td>';
                            }
                            ?>
                            <td class="text-center" ><?=$dominio['insuficiente']?></td>
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
                    <label><h3>Categoria</h3></label>
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
                                $nulo = '<td class="text-center"></td>';$bajo = '<td class="text-center"></td>';$medio = '<td class="text-center"></td>';$alto = '<td class="text-center"></td>';$muyalto = '<td class="text-center"></td>';
                                if($ambienteTrabajo< 5){
                                    $nulo = '<td class="text-center" style="background-color: #00c0f3;color:#fff "> &#10007</td>';
                                }elseif($ambienteTrabajo >= 5 && $ambienteTrabajo <9){
                                    $bajo = '<td class="text-center" style="background-color: #16a53f;color:#fff"> &#10007</td>';
                                }elseif($ambienteTrabajo >= 9 && $ambienteTrabajo <11){
                                    $medio= '<td class="text-center" style="background-color: #ffff00;color:#fff"> &#10007</td>';
                                }elseif($ambienteTrabajo >= 11 && $ambienteTrabajo<14){
                                    $alto= '<td class="text-center" style="background-color: #ff8000;color:#fff"> &#10007</td>';
                                }elseif($ambienteTrabajo >=14){
                                    $muyalto= '<td class="text-center" style="background-color: #ff3600;color:#fff"> &#10007</td>';
                                }
                                ?>
                                <td class="text-center"><?=$ambienteTrabajo?></td>
                                <?= $nulo ?>
                                <?= $bajo ?>
                                <?= $medio ?>
                                <?= $alto ?>
                                <?= $muyalto ?>
                            </tr>
                            <tr>
                                <td>Factores propios de la actividad</td>
                                <?php
                                $factores = $dominio['cargaT']+$dominio['faltaC'];
                                $nulo = '<td class="text-center"></td>';$bajo = '<td class="text-center"></td>';$medio = '<td class="text-center"></td>';$alto = '<td class="text-center"></td>';$muyalto = '<td class="text-center"></td>';
                                if($factores< 15){
                                    $nulo = '<td class="text-center" style="background-color: #00c0f3;color:#fff "> &#10007</td>';
                                }elseif($factores >= 15 && $factores <30){
                                    $bajo = '<td class="text-center" style="background-color: #16a53f;color:#fff"> &#10007</td>';
                                }elseif($factores >= 30 && $factores <45){
                                    $medio= '<td class="text-center" style="background-color: #ffff00;color:#fff"> &#10007</td>';
                                }elseif($factores >= 45 && $factores <60){
                                    $alto= '<td class="text-center" style="background-color: #ff8000;color:#fff"> &#10007</td>';
                                }elseif($factores >=60){
                                    $muyalto= '<td class="text-center" style="background-color: #ff3600;color:#fff"> &#10007</td>';
                                }
                                ?>
                                <td class="text-center" ><?=$factores?></td>
                                <?= $nulo ?>
                                <?= $bajo ?>
                                <?= $medio ?>
                                <?= $alto ?>
                                <?= $muyalto ?>
                            </tr>
                            <tr>
                                <td>Organización del tiempo de trabajo</td>
                                <?php
                                $organizacion = $dominio['jornadaT']+$dominio['interferencia'];
                                $nulo = '<td class="text-center"></td>';$bajo = '<td class="text-center"></td>';$medio = '<td class="text-center"></td>';$alto = '<td class="text-center"></td>';$muyalto = '<td class="text-center"></td>';
                                if($organizacion< 5){
                                    $nulo = '<td class="text-center" style="background-color: #00c0f3;color:#fff "> &#10007</td>';
                                }elseif($organizacion >= 5 && $organizacion <7){
                                    $bajo = '<td class="text-center" style="background-color: #16a53f;color:#fff"> &#10007</td>';
                                }elseif($organizacion >= 7 && $organizacion <10){
                                    $medio= '<td class="text-center" style="background-color: #ffff00;color:#fff"> &#10007</td>';
                                }elseif($organizacion >= 10 && $organizacion <13){
                                    $alto= '<td class="text-center" style="background-color: #ff8000;color:#fff"> &#10007</td>';
                                }elseif($organizacion >=13){
                                    $muyalto= '<td class="text-center" style="background-color: #ff3600;color:#fff"> &#10007</td>';
                                }
                                ?>
                                <td class="text-center" ><?=$organizacion?></td>
                                <?= $nulo ?>
                                <?= $bajo ?>
                                <?= $medio ?>
                                <?= $alto ?>
                                <?= $muyalto ?>
                            </tr>
                            <tr>
                                <td>Liderazgo y relaciones en el trabajo</td>
                                <?php
                                $liderazgo = $dominio['liderazgo']+$dominio['relacionT']+$dominio['violencia'];
                                $nulo = '<td class="text-center"></td>';$bajo = '<td class="text-center"></td>';$medio = '<td class="text-center"></td>';$alto = '<td class="text-center"></td>';$muyalto = '<td class="text-center"></td>';
                                if($liderazgo< 14){
                                    $nulo = '<td class="text-center" style="background-color: #00c0f3;color:#fff "> &#10007</td>';
                                }elseif($liderazgo >= 14 && $liderazgo <29){
                                    $bajo = '<td class="text-center" style="background-color: #16a53f;color:#fff"> &#10007</td>';
                                }elseif($liderazgo >= 29 && $liderazgo <42){
                                    $medio= '<td class="text-center" style="background-color: #ffff00;color:#fff"> &#10007</td>';
                                }elseif($liderazgo >= 42 && $liderazgo <58){
                                    $alto= '<td class="text-center" style="background-color: #ff8000;color:#fff"> &#10007</td>';
                                }elseif($liderazgo >=58){
                                    $muyalto= '<td class="text-center" style="background-color: #ff3600;color:#fff"> &#10007</td>';
                                }
                                ?>
                                <td class="text-center" ><?=$liderazgo?></td>
                                <?= $nulo ?>
                                <?= $bajo ?>
                                <?= $medio ?>
                                <?= $alto ?>
                                <?= $muyalto ?>
                            </tr>
                            <tr>
                            <td>Entorno Organizacional</td>
                            <?php
                            $entorno = $dominio['reconocimiento']+$dominio['insuficiente'];
                            $nulo = '<td class="text-center"></td>';$bajo = '<td class="text-center"></td>';$medio = '<td class="text-center"></td>';$alto = '<td class="text-center"></td>';$muyalto = '<td class="text-center"></td>';
                            if($entorno< 10){
                                $nulo = '<td class="text-center" style="background-color: #00c0f3;color:#fff "> &#10007</td>';
                            }elseif($entorno >= 10 && $entorno <14){
                                $bajo = '<td class="text-center" style="background-color: #16a53f;color:#fff"> &#10007</td>';
                            }elseif($entorno >= 14 && $entorno <18){
                                $medio= '<td class="text-center" style="background-color: #ffff00;color:#fff"> &#10007</td>';
                            }elseif($entorno >= 18 && $entorno <23){
                                $alto= '<td class="text-center" style="background-color: #ff8000;color:#fff"> &#10007</td>';
                            }elseif($entorno >=23){
                                $muyalto= '<td class="text-center" style="background-color: #ff3600;color:#fff"> &#10007</td>';
                            }
                            ?>
                            <td class="text-center" ><?=$entorno?></td>
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
                    <label><h3>Calificación Final</h3></label>
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
                                $cf=$ambienteTrabajo+$factores+$organizacion+$liderazgo+$entorno;
                                $nulo = '<td class="text-center"></td>';$bajo = '<td class="text-center"></td>';$medio = '<td class="text-center"></td>';$alto = '<td class="text-center"></td>';$muyalto = '<td class="text-center"></td>';
                                if($cf< 50){
                                    $nulo = '<td class="text-center" style="background-color: #00c0f3;color:#fff "> &#10007</td>';
                                }elseif($cf >= 50 && $cf <75){
                                    $bajo = '<td class="text-center" style="background-color: #16a53f;color:#fff"> &#10007</td>';
                                }elseif($cf >= 75 && $cf <99){
                                    $medio= '<td class="text-center" style="background-color: #ffff00;color:#fff"> &#10007</td>';
                                }elseif($cf >= 99 && $cf<140){
                                    $alto= '<td class="text-center" style="background-color: #ff8000;color:#fff"> &#10007</td>';
                                }elseif($cf >=140){
                                    $muyalto= '<td class="text-center" style="background-color: #ff3600;color:#fff"> &#10007</td>';
                                }
                                ?>
                                <td class="text-center"><?=$cf?></td>
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
                    <label><h3>Criterios para la toma de acciones</h3></label>
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
            <?php }else{ ?>
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
