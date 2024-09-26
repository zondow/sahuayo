<?php defined('FCPATH') OR exit('No direct script access allowed'); ?>
<?php
$de0a4=json_encode(array(0,1,2,3,4));
$de4a0=json_encode(array(4,3,2,1,0));
for($i=1;$i<=72;$i++){
    $pregunta[$i]=array('numero'=>$i);
    switch($i){
        case 1:case 4:case 23:case 24:case 25:case 26:case 27:case 28:case 30:case 31:case 32:case 33:case 33:case 34:case 35:case 36:case 37:case 38:case 39:case 40:case 41:case 42:case 43:case 44:case 45:case 46:case 47:case 48:case 49:case 50:case 51:case 52:case 53:case 55:case 56:case 57:
            $pregunta[$i]['respuesta']=$de0a4;break;
        default: $pregunta[$i]['respuesta']=$de4a0;break;
    }
    switch ($i){
        case 1: $pregunta[$i]['pregunta']='El espacio donde trabajo me permite realizar mis actividades de manera segura e higiénica';break;
        case 2: $pregunta[$i]['pregunta']='Mi trabajo me exige hacer mucho esfuerzo físico';break;
        case 3: $pregunta[$i]['pregunta']='Me preocupa sufrir un accidente en mi trabajo';break;
        case 4: $pregunta[$i]['pregunta']='Considero que en mi trabajo se aplican las normas de seguridad y salud en el trabajo';break;
        case 5: $pregunta[$i]['pregunta']='Considero que las actividades que realizo son peligrosas';break;
        case 6: $pregunta[$i]['pregunta']='Por la cantidad de trabajo que tengo debo quedarme tiempo adicional a mi turno';break;
        case 7: $pregunta[$i]['pregunta']='Por la cantidad de trabajo que tengo debo trabajar sin parar';break;
        case 8: $pregunta[$i]['pregunta']='Considero que es necesario mantener un ritmo de trabajo acelerado';break;
        case 9: $pregunta[$i]['pregunta']='Mi trabajo exige que esté muy concentrado';break;
        case 10: $pregunta[$i]['pregunta']='Mi trabajo requiere que memorice mucha información';break;
        case 11: $pregunta[$i]['pregunta']='En mi trabajo tengo que tomar decisiones difíciles muy rápido';break;
        case 12: $pregunta[$i]['pregunta']='Mi trabajo exige que atienda varios asuntos al mismo tiempo';break;
        case 13: $pregunta[$i]['pregunta']='En mi trabajo soy responsable de cosas de mucho valor';break;
        case 14: $pregunta[$i]['pregunta']='Respondo ante mi jefe por los resultados de toda mi área de trabajo';break;
        case 15: $pregunta[$i]['pregunta']='En el trabajo me dan órdenes contradictorias';break;
        case 16: $pregunta[$i]['pregunta']='Considero que en mi trabajo me piden hacer cosas innecesarias';break;
        case 17: $pregunta[$i]['pregunta']='Trabajo horas extras más de tres veces a la semana';break;
        case 18: $pregunta[$i]['pregunta']='Mi trabajo me exige laborar en días de descanso,festivos o fines de semana';break;
        case 19: $pregunta[$i]['pregunta']='Considero que el tiempo en el trabajo es mucho y perjudica mis actividades familiares o personales';break;
        case 20: $pregunta[$i]['pregunta']='Debo atender asuntos de trabajo cuando estoy en casa';break;
        case 21: $pregunta[$i]['pregunta']='Pienso en las actividades familiares o personales cuando estoy en mi trabajo';break;
        case 22: $pregunta[$i]['pregunta']='Pienso que mis responsabilidades familiares afectan mi trabajo';break;
        case 23: $pregunta[$i]['pregunta']='Mi trabajo permite que desarrolle nuevas habilidades';break;
        case 24: $pregunta[$i]['pregunta']='En mi trabajo puedo aspirar a un mejor puesto';break;
        case 25: $pregunta[$i]['pregunta']='Durante mi jornada de trabajo puedo tomar pausas cuando las necesito';break;
        case 26: $pregunta[$i]['pregunta']='Puedo decidir cuánto trabajo realizo durante la jornada laboral';break;
        case 27: $pregunta[$i]['pregunta']='Puedo decidir la velocidad a la que realizo mis actividades en mi trabajo';break;
        case 28: $pregunta[$i]['pregunta']='Puedo cambiar el orden de las actividades que realizo en mi trabajo';break;
        case 29: $pregunta[$i]['pregunta']='Los cambios que se presentan en mi trabajo dificultan mi labor';break;
        case 30: $pregunta[$i]['pregunta']='Cuando se presentan cambios en mi trabajo se tienen en cuenta mis ideas o aportaciones';break;
        case 31: $pregunta[$i]['pregunta']='Me informan con claridad cuáles son mis funciones';break;
        case 32: $pregunta[$i]['pregunta']='Me explican claramente los resultados que debo obtener en mi trabajo';break;
        case 33: $pregunta[$i]['pregunta']='Me explican claramente los objetivos de mi trabajo';break;
        case 34: $pregunta[$i]['pregunta']='Me informan con quién puedo resolver problemas o asuntos de trabajo';break;
        case 35: $pregunta[$i]['pregunta']='Me permiten asistir a capacitaciones relacionadas con mi trabajo';break;
        case 36: $pregunta[$i]['pregunta']='Recibo capacitación útil para hacer mi trabajo';break;
        case 37: $pregunta[$i]['pregunta']='Mi jefe ayuda a organizar mejor el trabajo';break;
        case 38: $pregunta[$i]['pregunta']='Mi jefe tiene en cuenta mis puntos de vista y opiniones';break;
        case 39: $pregunta[$i]['pregunta']='Mi jefe me comunica a tiempo la información relacionada con el trabajo';break;
        case 40: $pregunta[$i]['pregunta']='La orientación que me da mi jefe me ayuda a realizar mejor mi trabajo';break;
        case 41: $pregunta[$i]['pregunta']='Mi jefe ayuda a solucionar los problemas que se presentan en el trabajo';break;
        case 42: $pregunta[$i]['pregunta']='Puedo confiar en mis compañeros de trabajo';break;
        case 43: $pregunta[$i]['pregunta']='Entre compañeros solucionamos los problemas de trabajo de forma respetuosa';break;
        case 44: $pregunta[$i]['pregunta']='En mi trabajo me hacen sentir parte del grupo';break;
        case 45: $pregunta[$i]['pregunta']='Cuando tenemos que realizar trabajo de equipo los compañeros colaboran';break;
        case 46: $pregunta[$i]['pregunta']='Mis compañeros de trabajo me ayudan cuando tengo dificultades';break;
        case 47: $pregunta[$i]['pregunta']='Me informan sobre lo que hago bien en mi trabajo';break;
        case 48: $pregunta[$i]['pregunta']='La forma como evalúan mi trabajo en mi centro de trabajo me ayuda a mejorar mi desempeño';break;
        case 49: $pregunta[$i]['pregunta']='En mi centro de trabajo me pagan a tiempo mi salario';break;
        case 50: $pregunta[$i]['pregunta']='El pago que recibo es el que merezco por el trabajo que realizo';break;
        case 51: $pregunta[$i]['pregunta']='Si obtengo los resultados esperados en mi trabajo me recompensan o reconocen';break;
        case 52: $pregunta[$i]['pregunta']='Las personas que hacen bien el trabajo pueden crecer laboralmente';break;
        case 53: $pregunta[$i]['pregunta']='Considero que mi trabajo es estable';break;
        case 54: $pregunta[$i]['pregunta']='En mi trabajo existe continua rotación de personal';break;
        case 55: $pregunta[$i]['pregunta']='Siento orgullo de laborar en este centro de trabajo';break;
        case 56: $pregunta[$i]['pregunta']='Me siento comprometido con mi trabajo';break;
        case 57: $pregunta[$i]['pregunta']='En mi trabajo puedo expresarme libremente sin interrupciones';break;
        case 58: $pregunta[$i]['pregunta']='Recibo críticas constantes a mi persona y/o trabajo';break;
        case 59: $pregunta[$i]['pregunta']='Recibo burlas, calumnias, difamaciones, humillaciones o ridiculizaciones';break;
        case 60: $pregunta[$i]['pregunta']='Se ignora mi presencia o se me excluye de las reuniones de trabajo y en la toma de decisiones';break;
        case 61: $pregunta[$i]['pregunta']='Se manipulan las situaciones de trabajo para hacerme parecer un mal trabajador';break;
        case 62: $pregunta[$i]['pregunta']='Se ignoran mis éxitos laborales y se atribuyen a otros trabajadores';break;
        case 63: $pregunta[$i]['pregunta']='Me bloquean o impiden las oportunidades que tengo para obtener ascenso o mejora en mi trabajo';break;
        case 64: $pregunta[$i]['pregunta']='He presenciado actos de violencia en mi centro de trabajo';break;
        case 65: $pregunta[$i]['pregunta']='Atiendo clientes o usuarios muy enojados';break;
        case 66: $pregunta[$i]['pregunta']='Mi trabajo me exige atender personas muy necesitadas de ayuda o enfermas';break;
        case 67: $pregunta[$i]['pregunta']='Para hacer mi trabajo debo demostrar sentimientos distintos a los míos';break;
        case 68: $pregunta[$i]['pregunta']='Mi trabajo me exige atender situaciones de violencia';break;
        case 69: $pregunta[$i]['pregunta']='Comunican tarde los asuntos de trabajo';break;
        case 70: $pregunta[$i]['pregunta']='Dificultan el logro de los resultados del trabajo';break;
        case 71: $pregunta[$i]['pregunta']='Cooperan poco cuando se necesita';break;
        case 72: $pregunta[$i]['pregunta']='Ignoran las sugerencias para mejorar su trabajo';break;
    }
}
$tema1='Para responder las preguntas siguientes considere las condiciones ambientales de su centro de trabajo.';
$tema2='Para responder a las preguntas siguientes piense en la cantidad y ritmo de trabajo que tiene.';
$tema3='Las preguntas siguientes están relacionadas con el esfuerzo mental que le exige su trabajo.';
$tema4='Las preguntas siguientes están relacionadas con las actividades que realiza en su trabajo y las responsabilidades que tiene.';
$tema5='Las preguntas siguientes están relacionadas con su jornada de trabajo.';
$tema6='Las preguntas siguientes están relacionadas con las decisiones que puede tomar en su trabajo.';
$tema7='Las preguntas siguientes están relacionadas con cualquier tipo de cambio que ocurra en su trabajo (considere los últimos cambios realizados).';
$tema8='Las preguntas siguientes están relacionadas con la capacitación e información que se le proporciona sobre su trabajo.';
$tema9='Las preguntas siguientes están relacionadas con el o los jefes con quien tiene contacto.';
$tema10='Las preguntas siguientes se refieren a las relaciones con sus compañeros.';
$tema11='Las preguntas siguientes están relacionadas con la información que recibe sobre su rendimiento en el trabajo, el reconocimiento, el sentido de pertenencia y la estabilidad que le ofrece su trabajo.';
$tema12='Las preguntas siguientes están relacionadas con actos de violencia laboral (malos tratos, acoso, hostigamiento, acoso psicológico).';
$tema13='Las preguntas siguientes están relacionadas con la atención a clientes y usuarios.';
$tema14='En mi trabajo debo brindar servicio a clientes o usuarios:';
$tema15='Soy jefe de otros trabajadores:';
?>

<?php
if(empty($evaluacion)){ ?>
<div class="container-fluid" >
<div class="row">
    <div class="col-12 survey-app p-3">
        <div class="card">
            <div class="card-body">
                <div class="m-4">
                    <br>
                    <h3 class="text-dark text-center"><strong class="text-info">ENCUESTA DE FACTORES DE RIESGO PSICOSOCIAL EN EL TRABAJO NOM-035-STPS-2018</strong></h3>
                    <br>
                    <div class="card-footer ">
                        <br/>
                        <div class="header">
                            <h2><strong>Instrucciones y consideraciones:</strong></h2>
                        </div>
                        <br/>
                        <div class="col-12">
                            <p>
                                La presente encuesta es totalmente confidencial, puede estar seguro de que la información que se obtenga a partir de sus respuestas será usada de la manera más profesional y responsable posible.  Para esta encuesta no existen respuestas correctas o incorrectas, conteste de la manera más honesta que le sea posible.
                                A continuación, se presentan una serie de afirmaciones con las que usted puede o no estar de acuerdo. Para responder, debe indicar con una &nbsp;&nbsp;<span class="font-16" style="color: #eb5b2d">&#10007</span> &nbsp; la opción que le parece más correcta para cada afirmación.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="tab-content ">
                    <!-- TAB PRE-SCREENING -->
                    <div class="tab-pane show active" id="tabPrescreening">
                        <div class="row">
                            <div class="col-12 col-lg-12">
                                <div class="m-4">
                                    <hr/><br/>
                                    <div id="formPreScreening">
                                        <form class="needs-validation mb-5" role="form" action="<?=base_url("Evaluaciones/addGuia3")?>" method="post" enctype="multipart/form-data" autocomplete="off" novalidate>
                                            <input type="hidden" id="fechaActual" name="fechaActual" value="<?= date('Y-m-d') ?>">
                                            <input type="hidden" id="evaluado" name="evaluado" value="<?= $evaluadoID ?>">
                                            <div class="text-right ">
                                                <div class="header">
                                                    <h2><strong>Fecha: <?= longDate(date('Y-m-d'), ' de ') ?></strong></h2>
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <label>
                                                    Por favor  marca con una &nbsp;&nbsp;<span class="font-16" style="color: #eb5b2d">&#10007</span>  &nbsp; el grado en que consideras que la compañía cumple de acuerdo a la siguiente escala de evaluación:
                                                </label><!--INSTRUCCIONES-->
                                                <table class="data-table data-table-scrollable responsive nowrap" style="width: 100%">
                                                    <thead style="display: none;">
                                                    <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td><span class="badge badge-light font-13"><b>S</b>&nbsp;&nbsp;&nbsp;Siempre</span></td>
                                                        <td><span class="badge badge-light font-13"><b>CS</b>&nbsp;&nbsp;&nbsp;Casi siempre</span></td>
                                                        <td><span class="badge badge-light font-13"><b>AV</b>&nbsp;&nbsp;&nbsp;Algunas veces</span></td>
                                                        <td><span class="badge badge-light font-13"><b>CN</b>&nbsp;&nbsp;&nbsp;Casi nunca</span></td>
                                                        <td><span class="badge badge-light font-13"><b>N</b>&nbsp;&nbsp;&nbsp;Nunca</span></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php ?>


                                            <div class="mb-4">
                                                <hr>
                                                <div class="header">
                                                        <h2><strong><?=$tema1?></strong></h2></div>
                                                <div style="overflow: auto;">
                                                    <table id="tbl_A" class="data-table responsive nowrap table-bordered table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th width="55%"></th>
                                                            <th width="6%">Siempre</th>
                                                            <th width="10%">Casi siempre</th>
                                                            <th width="10%">Algunas veces</th>
                                                            <th width="10%">Casi nunca</th>
                                                            <th width="6%">Nunca</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php for($i=1;$i<=5;$i++){?>
                                                        <tr>
                                                            <td><?=$i?>) <?=$pregunta[$i]['pregunta'] ?></td>
                                                            <?php $respuestas = json_decode($pregunta[$i]['respuesta']);
                                                                $n=1;
                                                                foreach($respuestas as $respuesta){
                                                                    switch($n){
                                                                        case 1: $id="S_".$i;break;
                                                                        case 2: $id="CS_".$i;break;
                                                                        case 3: $id="AV_".$i;break;
                                                                        case 4: $id="CN_".$i;break;
                                                                        case 5: $id="N_".$i;break;
                                                                    }
                                                                    $n++;
                                                                    ?>
                                                                    <td id="<?=$id?>" class="tdClick" data-row="<?=$i?>" data-valor="<?=$respuesta?>"></td>
                                                                <?php
                                                                }
                                                            ?>
                                                            <input id="txtP<?=$i?>" name="txtP<?=$i?>" type="text" class="form-control txt-hidden" readonly required >
                                                        </tr>
                                                        <?php }?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <br>

                                                <div class="header">
                                                        <h2><strong><?=$tema2?></strong></h2></div>
                                                <div style="overflow: auto;">
                                                    <table id="tbl_B" class="data-table responsive nowrap table-bordered table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th width="55%"></th>
                                                            <th width="6%">Siempre</th>
                                                            <th width="10%">Casi siempre</th>
                                                            <th width="10%">Algunas veces</th>
                                                            <th width="10%">Casi nunca</th>
                                                            <th width="6%">Nunca</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php for($i=6;$i<=8;$i++){?>
                                                        <tr>
                                                            <td><?=$i?>) <?=$pregunta[$i]['pregunta'] ?></td>
                                                            <?php $respuestas = json_decode($pregunta[$i]['respuesta']);
                                                                $n=1;
                                                                foreach($respuestas as $respuesta){
                                                                    switch($n){
                                                                        case 1: $id="S_".$i;break;
                                                                        case 2: $id="CS_".$i;break;
                                                                        case 3: $id="AV_".$i;break;
                                                                        case 4: $id="CN_".$i;break;
                                                                        case 5: $id="N_".$i;break;
                                                                    }
                                                                    $n++;
                                                                    ?>
                                                                    <td id="<?=$id?>" class="tdClick" data-row="<?=$i?>" data-valor="<?=$respuesta?>"></td>
                                                                <?php
                                                                }
                                                            ?>
                                                            <input id="txtP<?=$i?>" name="txtP<?=$i?>" type="text" class="form-control txt-hidden" readonly required >
                                                        </tr>
                                                        <?php }?>
                                                        </tbody>
                                                    </table>
                                                </div>


                                                <br>
                                                <div class="header">
                                                        <h2><strong><?=$tema3?></strong></h2></div>
                                                <div style="overflow: auto;">
                                                    <table id="tbl_C" class="data-table responsive nowrap table-bordered table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th width="55%"></th>
                                                            <th width="6%">Siempre</th>
                                                            <th width="10%">Casi siempre</th>
                                                            <th width="10%">Algunas veces</th>
                                                            <th width="10%">Casi nunca</th>
                                                            <th width="6%">Nunca</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php for($i=9;$i<=12;$i++){?>
                                                        <tr>
                                                            <td><?=$i?>) <?=$pregunta[$i]['pregunta'] ?></td>
                                                            <?php $respuestas = json_decode($pregunta[$i]['respuesta']);
                                                                $n=1;
                                                                foreach($respuestas as $respuesta){
                                                                    switch($n){
                                                                        case 1: $id="S_".$i;break;
                                                                        case 2: $id="CS_".$i;break;
                                                                        case 3: $id="AV_".$i;break;
                                                                        case 4: $id="CN_".$i;break;
                                                                        case 5: $id="N_".$i;break;
                                                                    }
                                                                    $n++;
                                                                    ?>
                                                                    <td id="<?=$id?>" class="tdClick" data-row="<?=$i?>" data-valor="<?=$respuesta?>"></td>
                                                                <?php
                                                                }
                                                            ?>
                                                            <input id="txtP<?=$i?>" name="txtP<?=$i?>" type="text" class="form-control txt-hidden" readonly required >
                                                        </tr>
                                                        <?php }?>
                                                        </tbody>
                                                    </table>
                                                </div>


                                                <br>
                                                <div class="header">
                                                        <h2><strong><?=$tema4?></strong></h2></div>
                                                <div style="overflow: auto;">
                                                    <table id="tbl_C" class="data-table responsive nowrap table-bordered table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th width="55%"></th>
                                                            <th width="6%">Siempre</th>
                                                            <th width="10%">Casi siempre</th>
                                                            <th width="10%">Algunas veces</th>
                                                            <th width="10%">Casi nunca</th>
                                                            <th width="6%">Nunca</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php for($i=13;$i<=16;$i++){?>
                                                        <tr>
                                                            <td><?=$i?>) <?=$pregunta[$i]['pregunta'] ?></td>
                                                            <?php $respuestas = json_decode($pregunta[$i]['respuesta']);
                                                                $n=1;
                                                                foreach($respuestas as $respuesta){
                                                                    switch($n){
                                                                        case 1: $id="S_".$i;break;
                                                                        case 2: $id="CS_".$i;break;
                                                                        case 3: $id="AV_".$i;break;
                                                                        case 4: $id="CN_".$i;break;
                                                                        case 5: $id="N_".$i;break;
                                                                    }
                                                                    $n++;
                                                                    ?>
                                                                    <td id="<?=$id?>" class="tdClick" data-row="<?=$i?>" data-valor="<?=$respuesta?>"></td>
                                                                <?php
                                                                }
                                                            ?>
                                                            <input id="txtP<?=$i?>" name="txtP<?=$i?>" type="text" class="form-control txt-hidden" readonly required >
                                                        </tr>
                                                        <?php }?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <br>
                                                <div class="header">
                                                        <h2><strong><?=$tema5?></strong></h2></div>
                                                <div style="overflow: auto;">
                                                    <table id="tbl_C" class="data-table responsive nowrap table-bordered table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th width="55%"></th>
                                                            <th width="6%">Siempre</th>
                                                            <th width="10%">Casi siempre</th>
                                                            <th width="10%">Algunas veces</th>
                                                            <th width="10%">Casi nunca</th>
                                                            <th width="6%">Nunca</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php for($i=17;$i<=22;$i++){?>
                                                        <tr>
                                                            <td><?=$i?>) <?=$pregunta[$i]['pregunta'] ?></td>
                                                            <?php $respuestas = json_decode($pregunta[$i]['respuesta']);
                                                                $n=1;
                                                                foreach($respuestas as $respuesta){
                                                                    switch($n){
                                                                        case 1: $id="S_".$i;break;
                                                                        case 2: $id="CS_".$i;break;
                                                                        case 3: $id="AV_".$i;break;
                                                                        case 4: $id="CN_".$i;break;
                                                                        case 5: $id="N_".$i;break;
                                                                    }
                                                                    $n++;
                                                                    ?>
                                                                    <td id="<?=$id?>" class="tdClick" data-row="<?=$i?>" data-valor="<?=$respuesta?>"></td>
                                                                <?php
                                                                }
                                                            ?>
                                                            <input id="txtP<?=$i?>" name="txtP<?=$i?>" type="text" class="form-control txt-hidden" readonly required >
                                                        </tr>
                                                        <?php }?>
                                                        </tbody>
                                                    </table>
                                                </div>


                                                <br>
                                                <div class="header">
                                                        <h2><strong><?=$tema6?></strong></h2></div>
                                                <div style="overflow: auto;">
                                                    <table id="tbl_C" class="data-table responsive nowrap table-bordered table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th width="55%"></th>
                                                            <th width="6%">Siempre</th>
                                                            <th width="10%">Casi siempre</th>
                                                            <th width="10%">Algunas veces</th>
                                                            <th width="10%">Casi nunca</th>
                                                            <th width="6%">Nunca</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php for($i=23;$i<=28;$i++){?>
                                                        <tr>
                                                            <td><?=$i?>) <?=$pregunta[$i]['pregunta'] ?></td>
                                                            <?php $respuestas = json_decode($pregunta[$i]['respuesta']);
                                                                $n=1;
                                                                foreach($respuestas as $respuesta){
                                                                    switch($n){
                                                                        case 1: $id="S_".$i;break;
                                                                        case 2: $id="CS_".$i;break;
                                                                        case 3: $id="AV_".$i;break;
                                                                        case 4: $id="CN_".$i;break;
                                                                        case 5: $id="N_".$i;break;
                                                                    }
                                                                    $n++;
                                                                    ?>
                                                                    <td id="<?=$id?>" class="tdClick" data-row="<?=$i?>" data-valor="<?=$respuesta?>"></td>
                                                                <?php
                                                                }
                                                            ?>
                                                            <input id="txtP<?=$i?>" name="txtP<?=$i?>" type="text" class="form-control txt-hidden" readonly required >
                                                        </tr>
                                                        <?php }?>
                                                        </tbody>
                                                    </table>
                                                </div>


                                                <br>
                                                <div class="header">
                                                        <h2><strong><?=$tema7?></strong></h2></div>
                                                <div style="overflow: auto;">
                                                    <table id="tbl_C" class="data-table responsive nowrap table-bordered table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th width="55%"></th>
                                                            <th width="6%">Siempre</th>
                                                            <th width="10%">Casi siempre</th>
                                                            <th width="10%">Algunas veces</th>
                                                            <th width="10%">Casi nunca</th>
                                                            <th width="6%">Nunca</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php for($i=29;$i<=30;$i++){?>
                                                        <tr>
                                                            <td><?=$i?>) <?=$pregunta[$i]['pregunta'] ?></td>
                                                            <?php $respuestas = json_decode($pregunta[$i]['respuesta']);
                                                                $n=1;
                                                                foreach($respuestas as $respuesta){
                                                                    switch($n){
                                                                        case 1: $id="S_".$i;break;
                                                                        case 2: $id="CS_".$i;break;
                                                                        case 3: $id="AV_".$i;break;
                                                                        case 4: $id="CN_".$i;break;
                                                                        case 5: $id="N_".$i;break;
                                                                    }
                                                                    $n++;
                                                                    ?>
                                                                    <td id="<?=$id?>" class="tdClick" data-row="<?=$i?>" data-valor="<?=$respuesta?>"></td>
                                                                <?php
                                                                }
                                                            ?>
                                                            <input id="txtP<?=$i?>" name="txtP<?=$i?>" type="text" class="form-control txt-hidden" readonly required >
                                                        </tr>
                                                        <?php }?>
                                                        </tbody>
                                                    </table>
                                                </div>


                                                <br>
                                                <div class="header">
                                                        <h2><strong><?=$tema8?></strong></h2></div>
                                                <div style="overflow: auto;">
                                                    <table id="tbl_C" class="data-table responsive nowrap table-bordered table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th width="55%"></th>
                                                            <th width="6%">Siempre</th>
                                                            <th width="10%">Casi siempre</th>
                                                            <th width="10%">Algunas veces</th>
                                                            <th width="10%">Casi nunca</th>
                                                            <th width="6%">Nunca</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php for($i=31;$i<=36;$i++){?>
                                                        <tr>
                                                            <td><?=$i?>) <?=$pregunta[$i]['pregunta'] ?></td>
                                                            <?php $respuestas = json_decode($pregunta[$i]['respuesta']);
                                                                $n=1;
                                                                foreach($respuestas as $respuesta){
                                                                    switch($n){
                                                                        case 1: $id="S_".$i;break;
                                                                        case 2: $id="CS_".$i;break;
                                                                        case 3: $id="AV_".$i;break;
                                                                        case 4: $id="CN_".$i;break;
                                                                        case 5: $id="N_".$i;break;
                                                                    }
                                                                    $n++;
                                                                    ?>
                                                                    <td id="<?=$id?>" class="tdClick" data-row="<?=$i?>" data-valor="<?=$respuesta?>"></td>
                                                                <?php
                                                                }
                                                            ?>
                                                            <input id="txtP<?=$i?>" name="txtP<?=$i?>" type="text" class="form-control txt-hidden" readonly required >
                                                        </tr>
                                                        <?php }?>
                                                        </tbody>
                                                    </table>
                                                </div>


                                                <br>
                                                <div class="header">
                                                        <h2><strong><?=$tema9?></strong></h2></div>
                                                <div style="overflow: auto;">
                                                    <table id="tbl_C" class="data-table responsive nowrap table-bordered table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th width="55%"></th>
                                                            <th width="6%">Siempre</th>
                                                            <th width="10%">Casi siempre</th>
                                                            <th width="10%">Algunas veces</th>
                                                            <th width="10%">Casi nunca</th>
                                                            <th width="6%">Nunca</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php for($i=37;$i<=41;$i++){?>
                                                        <tr>
                                                            <td><?=$i?>) <?=$pregunta[$i]['pregunta'] ?></td>
                                                            <?php $respuestas = json_decode($pregunta[$i]['respuesta']);
                                                                $n=1;
                                                                foreach($respuestas as $respuesta){
                                                                    switch($n){
                                                                        case 1: $id="S_".$i;break;
                                                                        case 2: $id="CS_".$i;break;
                                                                        case 3: $id="AV_".$i;break;
                                                                        case 4: $id="CN_".$i;break;
                                                                        case 5: $id="N_".$i;break;
                                                                    }
                                                                    $n++;
                                                                    ?>
                                                                    <td id="<?=$id?>" class="tdClick" data-row="<?=$i?>" data-valor="<?=$respuesta?>"></td>
                                                                <?php
                                                                }
                                                            ?>
                                                            <input id="txtP<?=$i?>" name="txtP<?=$i?>" type="text" class="form-control txt-hidden" readonly required >
                                                        </tr>
                                                        <?php }?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <br>
                                                <div class="header">
                                                        <h2><strong><?=$tema10?></strong></h2></div>
                                                <div style="overflow: auto;">
                                                    <table id="tbl_C" class="data-table responsive nowrap table-bordered table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th width="55%"></th>
                                                            <th width="6%">Siempre</th>
                                                            <th width="10%">Casi siempre</th>
                                                            <th width="10%">Algunas veces</th>
                                                            <th width="10%">Casi nunca</th>
                                                            <th width="6%">Nunca</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php for($i=42;$i<=46;$i++){?>
                                                        <tr>
                                                            <td><?=$i?>) <?=$pregunta[$i]['pregunta'] ?></td>
                                                            <?php $respuestas = json_decode($pregunta[$i]['respuesta']);
                                                                $n=1;
                                                                foreach($respuestas as $respuesta){
                                                                    switch($n){
                                                                        case 1: $id="S_".$i;break;
                                                                        case 2: $id="CS_".$i;break;
                                                                        case 3: $id="AV_".$i;break;
                                                                        case 4: $id="CN_".$i;break;
                                                                        case 5: $id="N_".$i;break;
                                                                    }
                                                                    $n++;
                                                                    ?>
                                                                    <td id="<?=$id?>" class="tdClick" data-row="<?=$i?>" data-valor="<?=$respuesta?>"></td>
                                                                <?php
                                                                }
                                                            ?>
                                                            <input id="txtP<?=$i?>" name="txtP<?=$i?>" type="text" class="form-control txt-hidden" readonly required >
                                                        </tr>
                                                        <?php }?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <br>
                                                <div class="header">
                                                        <h2><strong><?=$tema11?></strong></h2></div>
                                                <div style="overflow: auto;">
                                                    <table id="tbl_C" class="data-table responsive nowrap table-bordered table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th width="55%"></th>
                                                            <th width="6%">Siempre</th>
                                                            <th width="10%">Casi siempre</th>
                                                            <th width="10%">Algunas veces</th>
                                                            <th width="10%">Casi nunca</th>
                                                            <th width="6%">Nunca</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php for($i=47;$i<=56;$i++){?>
                                                        <tr>
                                                            <td><?=$i?>) <?=$pregunta[$i]['pregunta'] ?></td>
                                                            <?php $respuestas = json_decode($pregunta[$i]['respuesta']);
                                                                $n=1;
                                                                foreach($respuestas as $respuesta){
                                                                    switch($n){
                                                                        case 1: $id="S_".$i;break;
                                                                        case 2: $id="CS_".$i;break;
                                                                        case 3: $id="AV_".$i;break;
                                                                        case 4: $id="CN_".$i;break;
                                                                        case 5: $id="N_".$i;break;
                                                                    }
                                                                    $n++;
                                                                    ?>
                                                                    <td id="<?=$id?>" class="tdClick" data-row="<?=$i?>" data-valor="<?=$respuesta?>"></td>
                                                                <?php
                                                                }
                                                            ?>
                                                            <input id="txtP<?=$i?>" name="txtP<?=$i?>" type="text" class="form-control txt-hidden" readonly required >
                                                        </tr>
                                                        <?php }?>
                                                        </tbody>
                                                    </table>
                                                </div>


                                                <br>
                                                <div class="header">
                                                        <h2><strong><?=$tema12?></strong></h2></div>
                                                <div style="overflow: auto;">
                                                    <table id="tbl_C" class="data-table responsive nowrap table-bordered table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th width="55%"></th>
                                                            <th width="6%">Siempre</th>
                                                            <th width="10%">Casi siempre</th>
                                                            <th width="10%">Algunas veces</th>
                                                            <th width="10%">Casi nunca</th>
                                                            <th width="6%">Nunca</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php for($i=57;$i<=64;$i++){?>
                                                        <tr>
                                                            <td><?=$i?>) <?=$pregunta[$i]['pregunta'] ?></td>
                                                            <?php $respuestas = json_decode($pregunta[$i]['respuesta']);
                                                                $n=1;
                                                                foreach($respuestas as $respuesta){
                                                                    switch($n){
                                                                        case 1: $id="S_".$i;break;
                                                                        case 2: $id="CS_".$i;break;
                                                                        case 3: $id="AV_".$i;break;
                                                                        case 4: $id="CN_".$i;break;
                                                                        case 5: $id="N_".$i;break;
                                                                    }
                                                                    $n++;
                                                                    ?>
                                                                    <td id="<?=$id?>" class="tdClick" data-row="<?=$i?>" data-valor="<?=$respuesta?>"></td>
                                                                <?php
                                                                }
                                                            ?>
                                                            <input id="txtP<?=$i?>" name="txtP<?=$i?>" type="text" class="form-control txt-hidden" readonly required >
                                                        </tr>
                                                        <?php }?>
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>
                                            <hr>
                                            <div class="header">
                                                        <h2><strong><?=$tema13?></strong></h2></div>
                                            <div class="mb-4">
                                                <div class="header">
                                                        <h2><strong><?=$tema14?></strong></h2></div>
                                                <div class="form-row text-center">
                                                    <div class="form-group col-6">
                                                        <div class="custom-control custom-radio" >
                                                            <input type="radio" id="rdoClientes_SI" name="rdoClientes" class="custom-control-input"  value="SI" required>
                                                            <label class="custom-control-label" for="rdoClientes_SI">SI</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-6">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="rdoClientes_NO" name="rdoClientes" class="custom-control-input" value="NO" required>
                                                            <label class="custom-control-label" for="rdoClientes_NO">NO</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div style="overflow: auto;" id="tablaGDiv">
                                                    <table id="tbl_G" class="data-table responsive nowrap table-bordered table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th width="55%"></th>
                                                            <th width="6%">Siempre</th>
                                                            <th width="10%">Casi siempre</th>
                                                            <th width="10%">Algunas veces</th>
                                                            <th width="10%">Casi nunca</th>
                                                            <th width="6%">Nunca</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php for($i=65;$i<=68;$i++){?>
                                                        <tr>
                                                            <td><?=$i?>) <?=$pregunta[$i]['pregunta'] ?></td>
                                                            <?php $respuestas = json_decode($pregunta[$i]['respuesta']);
                                                                $n=1;
                                                                foreach($respuestas as $respuesta){
                                                                    switch($n){
                                                                        case 1: $id="S_".$i;break;
                                                                        case 2: $id="CS_".$i;break;
                                                                        case 3: $id="AV_".$i;break;
                                                                        case 4: $id="CN_".$i;break;
                                                                        case 5: $id="N_".$i;break;
                                                                    }
                                                                    $n++;
                                                                    ?>
                                                                    <td id="<?=$id?>" class="tdClick" data-row="<?=$i?>" data-valor="<?=$respuesta?>"></td>
                                                                <?php
                                                                }
                                                            ?>
                                                            <input id="txtP<?=$i?>" name="txtP<?=$i?>" type="text" class="form-control txt-hidden" readonly required >
                                                        </tr>
                                                        <?php }?>

                                                        </tbody>
                                                    </table>
                                                </div>
                                                <br>
                                            </div>

                                            <div class="mb-4">
                                                <hr>
                                                <div class="header">
                                                        <h2><strong><?=$tema15?></strong></h2></div>
                                                <div class="form-row text-center">
                                                    <div class="form-group col-6">
                                                        <div class="custom-control custom-radio" >
                                                            <input type="radio" id="rdoJefe_SI" name="rdoJefe" class="custom-control-input"  value="SI" required>
                                                            <label class="custom-control-label" for="rdoJefe_SI">SI</label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-6">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="rdoJefe_NO" name="rdoJefe" class="custom-control-input" value="NO" required>
                                                            <label class="custom-control-label" for="rdoJefe_NO">NO</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div style="overflow: auto;" id="tablaJDiv">
                                                    <table id="tbl_G" class="data-table responsive nowrap table-bordered table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th width="55%"></th>
                                                            <th width="6%">Siempre</th>
                                                            <th width="10%">Casi siempre</th>
                                                            <th width="10%">Algunas veces</th>
                                                            <th width="10%">Casi nunca</th>
                                                            <th width="6%">Nunca</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php for($i=69;$i<=72;$i++){?>
                                                        <tr>
                                                            <td><?=$i?>) <?=$pregunta[$i]['pregunta'] ?></td>
                                                            <?php $respuestas = json_decode($pregunta[$i]['respuesta']);
                                                                $n=1;
                                                                foreach($respuestas as $respuesta){
                                                                    switch($n){
                                                                        case 1: $id="S_".$i;break;
                                                                        case 2: $id="CS_".$i;break;
                                                                        case 3: $id="AV_".$i;break;
                                                                        case 4: $id="CN_".$i;break;
                                                                        case 5: $id="N_".$i;break;
                                                                    }
                                                                    $n++;
                                                                    ?>
                                                                    <td id="<?=$id?>" class="tdClick" data-row="<?=$i?>" data-valor="<?=$respuesta?>"></td>
                                                                <?php
                                                                }
                                                            ?>
                                                            <input id="txtP<?=$i?>" name="txtP<?=$i?>" type="text" class="form-control txt-hidden" readonly required >
                                                        </tr>
                                                        <?php }?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <br>
                                            </div>
                                            <div class="col-md-12 text-right">
                                                <br>
                                                <button type="submit" class="btn btn-round btn-success"><b class="iconsminds-yes"></b> Guardar Evaluación</button> <br>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php }else{ ?>
    <div class="content card">
            <div class="row card-body">
                <div class="col-md-4"></div>
                <div class="col-md-4" style="margin-top: 9%;margin-bottom: 9%">
                    <div class="text-center">
                        <div id="lottie-animation-check" style="width: 300px; height: 250px;"></div>
                        <p class="lead" style="text-align: center;vertical-align: center;padding-bottom: 4px"><strong>¡Gracias!<br>Su evaluación ha sido enviada.</strong></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<script>
$(document).ready(function(e){
    lottie.loadAnimation({
        container: document.getElementById('lottie-animation-check'), // El contenedor donde se mostrará la animación
        renderer: 'svg', // Tipo de renderizado, puede ser "svg", "canvas" o "html"
        loop: true, // Si la animación debe reproducirse en bucle
        autoplay: true, // Si la animación debe empezar automáticamente
        path: "<?= base_url('/assets/images/evaluaciones/check.json') ?>", // Ruta del archivo JSON de la animación envuelta en comillas        
    });
    $("#tablaGDiv").hide();
    $("#tablaJDiv").hide();

    $("#rdoClientes_SI").change(function (evt) {
        evt.preventDefault();
        $('#rdoClientes_SI:checked').val();
        <?php for($i=65;$i<=68;$i++){?>
        $("#txtP<?=$i?>").prop('required',true);
        <?php } ?>
        $("#tablaGDiv").show();
    });
    $("#rdoClientes_NO").change(function (evt) {
        evt.preventDefault();
        $('#rdoClientes_NO:checked').val();
        $("#tablaGDiv").hide();
        <?php for($i=65;$i<=68;$i++){?>
        $("#txtP<?=$i?>").prop('required',false);
        <?php } ?>
    });

    $("#rdoJefe_SI").change(function (evt) {
        evt.preventDefault();
        $('#rdoJefe_SI:checked').val();
        <?php for($i=69;$i<=72;$i++){?>
        $("#txtP<?=$i?>").prop('required',true);
        <?php } ?>
        $("#tablaJDiv").show();
    });
    $("#rdoJefe_NO").change(function (evt) {
        evt.preventDefault();
        $('#rdoJefe_NO:checked').val();
        $("#tablaJDiv").hide();
        <?php for($i=69;$i<=72;$i++){?>
        $("#txtP<?=$i?>").prop('required',false);
        <?php } ?>
    });

    //Cell click
    $(".tdClick").click(function(e){
        var row = $(this).data("row");
        var valor = $(this).data("valor");
        clearRow(row);

        setInputValue(row,valor);
        $(this).html("&#10007");
    });//Cell click

    //Guardar valor en input
    function setInputValue(row,value){

        <?php for ($i=1;$i<=72;$i++){ ?>
        if(row === <?=$i?>){
            $("#txtP<?=$i?>").val(value);
        }
        <?php } ?>
    }//setInputValue

    //Limpiar row
    function clearRow(row){
        $("#S_"+row).html('');
        $("#CS_"+row).html('');
        $("#AV_"+row).html('');
        $("#CN_"+row).html('');
        $("#N_"+row).html('');
    }//clearRow

});
</script>