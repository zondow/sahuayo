<?php defined('FCPATH') or exit('No direct script access allowed');
//Dias Restantes
$diasRestantes = $diasPendientes;
$fecha = new DateTime(date('Y/m/d', strtotime($empleado['emp_FechaIngreso']))); // Creo un objeto DateTime de la fecha ingresada
$fecha_hoy =  new DateTime(date('Y/m/d', time())); // Creo un objeto DateTime de la fecha de hoy
$antiguedad = date_diff($fecha_hoy, $fecha);
$txtAntiguedad = " {$antiguedad->format('%Y')} años y {$antiguedad->format('%m')} meses";

?>

<div class="row">
    <div class="col-lg-4">
        <div class="text-center card-box ribbon-box">
            <div class="member-card">
                <div class="thumb-lg member-thumb mx-auto">
                    <img src="<?= fotoPerfil($idEmpleado) ?>" class="rounded-circle avatar-xl img-thumbnail" alt="profile-image">
                </div>
                <div>
                    <h4 class="nombre"><?= $empleado['emp_Nombre'] ?></h4>
                    <label class="col-md-12 mb-0">Puesto</label>
                    <span class="text-muted"><?= $empleado['pue_Nombre'] ?></span>
                    <h4><span class="badge badge-light"> Número de Empleado: <strong><?= $empleado['emp_Numero'] ?></strong></span></h4>
                    <h4><span class="badge badge-light"> Fecha de Ingreso: <strong><?= shortDate($empleado['emp_FechaIngreso']) ?></strong></span></h4>
                    <h4><span class="badge badge-light">Antiguedad: <strong><?= $txtAntiguedad ?></strong></span></h4>
                </div>
                <div class="mt-2">
                    <div class="row">
                        <div class="col-6">
                            <div class="mt-3">
                                <h6><?= $diasRestantes ?> días</h6>
                                <p class="mb-0 text-muted">Pendientes de disfrutar</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mt-3">
                                <h6><?= $horasExtra ?> horas</h6>
                                <p class="mb-0 text-muted">Pendientes de disfrutar</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card-box">
            <h4 class="header-title mb-4">Solicitud de Vacaciones a Horas</h4>
            <form method="post" id="vacacionesForm" action="<?= base_url("Incidencias/crearCambioHorasVac") ?>" autocomplete="off">
                <input type="hidden" name="diasRestantes" value="<?= $diasRestantes ?>">
                <div class="row col-md-12">
                    <div class="col-md-3">
                        <label>* Día(s): </label>
                        <div>
                            <input type="number" min="0" max="<?=$diasRestantes?>" placeholder="0" class="form-control " name="diasVacaciones" id="diasVacaciones" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Horas: </label>
                        <div>
                            <input readonly class="form-control " name="horasVacaciones" id="horasVacaciones"  required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label> Observaciones: </label>
                        <textarea class="form-control" placeholder="-- Escriba algunas observaciones (opcional) --" name="vach_Observaciones" id="vac_Observaciones" rows="2"></textarea>
                    </div>
                </div>
                <?php if ($diasRestantes > 0) { ?>
                    <button type="submit" class="btn btn-success mb-0" id="btnRegistrar" data-loading-text="<i class='iconsminds-loading-3'></i> Registrando...">
                        <i class="dripicons-plus"></i> Registrar
                    </button>
                <?php } else { ?>
                    <div class="alert alert-warning">Has alcanzado el límite de vacaciones permitidas o no cumples con la antigüedad para solicitar vacaciones.</div>
                <?php } ?>
            </form>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card-box ">
            <div class="table-responsive">
                <table class="table table-hover m-0 table-centered tickets-list table-actions-bar dt-responsive datatableVacaciones" cellspacing="0" width="100%" id="tVacaciones">
                    <thead>
                        <tr>
                            <th width="5%">Acciones</th>
                            <th>Fecha de Solicitud</th>
                            <th>Dias - Horas</th>
                            <th>Estatus</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count($registros) > 0) {
                            $count = 0;
                            foreach ($registros as $registro) {
                                $badge = '';
                                $estatus = '';
                                switch ($registro['vach_Estatus']) {
                                    case 'PENDIENTE': $badge = 'badge-dark'; $estatus = 'PENDIENTE'; break;
                                    case 'AUTORIZADO_RH': $badge = 'badge-success'; $estatus = 'APLICADO'; break;
                                    case 'RECHAZADO_RH': $badge = 'badge-danger'; $estatus = 'RECHAZADO'; break;
                                }
                                echo '<tr>';
                                echo '<td class="text-center ">
                                <a href="' . base_url("PDF/imprimirSolicitudVacacionesHoras/" . encryptDecrypt('encrypt', $registro['vach_VacacionHorasID'])) . '" class="btn btn-info btn-block waves-light waves-effect show-pdf" data-title="Solicitud de vacaciones" title="Formato de solicitud"><i class="dripicons-print"></i></a>';
                                echo '</td>';
                                echo '<td ><b>' . shortDateTime($registro['vach_Fecha']) . '</b></td>';
                                echo '<td ><b>' . $registro['vach_Dias'] . ' Días - '.$registro['vach_Horas'].' Horas</b></td>';
                                echo '<td ><span class="badge ' . $badge . ' p-1">' . $estatus . '</span></td>';
                                echo '</tr>';
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>