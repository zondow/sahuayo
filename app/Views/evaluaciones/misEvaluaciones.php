<?php defined('FCPATH') or exit('No direct script access allowed'); 
$nivelesEvaluacion = [
    'autoevaluacion' => 'Auto Evaluación', 
    'companero' => 'Compañero', 
    'equipo' => 'Equipo', 
    'responsable' => 'Responsable', 
    'otro' => 'Otro'
];
?>
<div role="tabpanel" class="tab-pane active">
    <?php foreach ($evaluacionesActivas as $ev):?>
        <div class="col-md-4">
            <div class="card">
                <div class="header">
                    <h2><strong><?= htmlspecialchars($ev['nombre']) ?></strong></h2>
                </div>
                <ul>
                    <li><strong>Tipo: </strong><?= ucwords(strtolower($ev['tipo'])) ?></li>
                    <li><strong>Nivel: </strong> 
                        <?= $nivelesEvaluacion[$ev['nivelEvaluacion']] ?? 'Desconocido' ?>
                    </li>
                    <li><strong>Colaborador: </strong><?=$ev['nombreEvaluado']?></li>
                </ul>
                <div class="body text-center">
                    <p><strong>Del:</strong> <?= $ev['fechaInicio'] ?> <strong>al:</strong> <?= $ev['fechaFin'] ?></p>
                   <?php if(!$ev['res_RespuestaEvaluadorID']){?> 
                    <a href="<?= base_url('Evaluaciones/evaluacion/' . encrypt($ev['plantillaID'].','.$ev['eva_EmpleadoID'])) ?>" 
                       class="btn btn-info btn-round">Realizar evaluación</a>                               
                    <?php }else{ ?>
                        <a href="#" class="btn btn-success btn-round">Realizada</a>      
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
