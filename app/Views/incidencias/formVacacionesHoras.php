<?php defined('FCPATH') or exit('No direct script access allowed');
$antiguedad = date_diff(new DateTime(date('Y/m/d', time())), new DateTime(date('Y/m/d', strtotime($empleado['emp_FechaIngreso']))));
$txtAntiguedad = " {$antiguedad->format('%Y')} años y {$antiguedad->format('%m')} meses";
?>
<div class="col-lg-12">
    <div class="card">
        <ul class="row profile_state list-unstyled">
            <li class="col-lg-4 col-md-4 col-6">
                <div class="body">
                    <i class="zmdi zmdi-collection-item-1 text-success"></i>
                    <h4><?= $diasLey ?></h4>
                    <span>Días del periodo</span>
                </div>
            </li>
            <li class="col-lg-4 col-md-4 col-6">
                <div class="body">
                    <i class="zmdi zmdi-calendar-check text-info"></i>
                    <h4><?= $diasRestantes ?></h4>
                    <span>Días disponibles</span>
                </div>
            </li>
            <li class="col-lg-4 col-md-4 col-6">
                <div class="body">
                    <i class="zmdi zmdi-time-countdown text-success"></i>
                    <h4><?= $horasExtra ?></h4>
                    <span>Horas pendientes de disfrutar</span>
                </div>
            </li>
        </ul>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="header">
                    <h2><strong>Solicitud de Vacaciones a Horas</strong></h2>
                </div>
                <form method="post" id="vacacionesForm" action="<?= base_url("Incidencias/crearCambioHorasVac") ?>" autocomplete="off">
                    <input type="hidden" name="diasRestantes" value="<?= $diasRestantes ?>">
                    <div class="row col-md-12">
                        <div class="col-md-3">
                            <label>* Día(s): </label>
                            <div>
                                <input type="number" min="0" max="<?= $diasRestantes ?>" placeholder="0" class="form-control " name="diasVacaciones" id="diasVacaciones" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label>Horas: </label>
                            <div>
                                <input readonly class="form-control " name="horasVacaciones" id="horasVacaciones" required>
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
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card ">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover m-0 table-centered tickets-list table-actions-bar dt-responsive datatableVacaciones" cellspacing="0" width="100%" id="tVacaciones">
                        <thead>
                            <tr>
                                <th>Fecha de Solicitud</th>
                                <th>Dias - Horas</th>
                                <th>Estatus</th>
                                <th width="5%">Acciones</th>
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
                                        case 'PENDIENTE':
                                            $badge = 'badge-info';
                                            $estatus = 'PENDIENTE';
                                            break;
                                        case 'AUTORIZADO_RH':
                                            $badge = 'badge-success';
                                            $estatus = 'APLICADO';
                                            break;
                                        case 'RECHAZADO_RH':
                                            $badge = 'badge-danger';
                                            $estatus = 'RECHAZADO';
                                            break;
                                    }
                                    echo '<tr>';
                                    echo '<td >' . longDateTime($registro['vach_Fecha'],' de ') . '</td>';
                                    echo '<td >' . $registro['vach_Dias'] . ' Días - ' . $registro['vach_Horas'] . ' Horas</td>';
                                    echo '<td ><span class="badge ' . $badge . ' p-1">' . $estatus . '</span></td>';
                                    echo '<td class="text-center ">
                                <button href="' . base_url("PDF/imprimirSolicitudVacacionesHoras/" . encryptDecrypt('encrypt', $registro['vach_VacacionHorasID'])) . '" class="btn btn-warning btn-icon btn-icon-mini btn-round hidden-sm-down show-pdf" data-title="Solicitud de vacaciones" title="Formato de solicitud"><i class="zmdi zmdi-local-printshop"></i></button>';
                                    echo '</td>';
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
</div>