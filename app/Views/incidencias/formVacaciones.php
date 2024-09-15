<?php defined('FCPATH') or exit('No direct script access allowed');
$antiguedad = date_diff(new DateTime(date('Y/m/d', time())), new DateTime(date('Y/m/d', strtotime($empleado['emp_FechaIngreso']))));
$txtAntiguedad = " {$antiguedad->format('%Y')} años y {$antiguedad->format('%m')} meses";
?>
<div class="col-lg-12">
    <div class="card">
        <ul class="row profile_state list-unstyled">
            <li class="col-lg-3 col-md-3 col-6">
                <div class="body">
                    <i class="zmdi zmdi-calendar-alt col-amber"></i>
                    <h4><?= shortDate($empleado['emp_FechaIngreso']) ?></h4>
                    <span>Fecha de Ingreso</span>
                </div>
            </li>
            <li class="col-lg-3 col-md-3 col-6">
                <div class="body">
                    <i class="zmdi zmdi-timer col-blue"></i>
                    <h4><?= $txtAntiguedad ?></h4>
                    <span>Antigüedad</span>
                </div>
            </li>
            <li class="col-lg-2 col-md-2 col-6">
                <div class="body">
                    <i class="zmdi zmdi-collection-item-1 text-success"></i>
                    <h4><?= $diasLey ?></h4>
                    <span>Días del periodo</span>
                </div>
            </li>
            <li class="col-lg-2 col-md-2 col-6">
                <div class="body">
                    <i class="zmdi zmdi-calendar-check col-red"></i>
                    <h4><?= $diasRestantes ?></h4>
                    <span>Días disponibles</span>
                </div>
            </li>
            <li class="col-lg-2 col-md-2 col-6">
                <div class="body">
                    <i class="zmdi zmdi-check text-success"></i>
                    <h4><?= count($registros) ?></h4>
                    <span>Solicitudes tomadas</span>
                </div>
            </li>
        </ul>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="body">
                <div class="header">
                    <h2><strong>Solicitud de Vacaciones</strong></h2>
                </div>
                <form method="post" id="vacacionesForm" action="<?= base_url("Incidencias/crearVacaciones") ?>" autocomplete="off">
                    <input type="hidden" name="diasRestantes" value="<?= $diasRestantes ?>">
                    <div class="form-group">
                        <label>* Período: </label>
                        <div>
                            <div class="input-daterange input-group" id="date-range">
                                <input type="text" class="form-control " name="vac_FechaInicio" id="vac_FechaInicio" placeholder="Inicio" required>
                                <input type="text" class="form-control " name="vac_FechaFin" id="vac_FechaFin" placeholder="Fin" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label> Observaciones: </label>
                        <textarea class="form-control" placeholder="-- Escriba algunas observaciones (opcional) --" name="vac_Observaciones" id="vac_Observaciones" rows="2"></textarea>
                    </div>

                    <!--<?php if ($diasRestantes > 0) { ?>
                    <button type="submit" class="btn btn-success mb-0" id="btnRegistrar" data-loading-text="<i class='iconsminds-loading-3'></i> Registrando...">
                        <i class="dripicons-plus"></i> Registrar
                    </button>
                <?php } else { ?>
                    <div class="alert alert-warning">Has alcanzado el límite de vacaciones permitidas o no cumples con la antigüedad para solicitar vacaciones.</div>
                <?php } ?>-->
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-success btn-round mb-0" id="btnRegistrar" data-loading-text="<i class='iconsminds-loading-3'></i> Registrando...">
                            <i class="dripicons-plus"></i> Registrar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="body">
                <div class="header">
                    <h2><strong>Mis Solicitudes de Vacaciones</strong></h2>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover m-0 table-centered tickets-list table-actions-bar dt-responsive datatableVacaciones" cellspacing="0" width="100%" id="tVacaciones">
                        <thead>
                            <tr>
                                <th>Fecha inicio</th>
                                <th>Fecha fin</th>
                                <th>Días ocupados</th>
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
                                    switch ($registro['vac_Estatus']) {
                                        case 'PENDIENTE':
                                            $badge = 'badge-info';
                                            $estatus = 'PENDIENTE';
                                            break;
                                        case 'AUTORIZADO':
                                            $badge = 'badge-warning';
                                            $estatus = 'AUTORIZADO';
                                            break;
                                        case 'RECHAZADO':
                                            $badge = 'badge-danger';
                                            $estatus = 'RECHAZADO';
                                            break;
                                        case 'AUTORIZADO_RH':
                                            $badge = 'badge-success';
                                            $estatus = 'APLICADO';
                                            break;
                                        case 'RECHAZADO_RH':
                                            $badge = 'badge-danger';
                                            $estatus = 'RECHAZADO';
                                            break;
                                        case 'AUTORIZADO_GO':
                                            $badge = 'badge-success';
                                            $estatus = 'AUTORIZADO GERENTE OPERATIVO';
                                            break;
                                        case 'RECHAZADO_GO':
                                            $badge = 'badge-danger';
                                            $estatus = 'RECHAZADO GERENTE OPERATIVO';
                                            break;
                                        case 'DECLINADO':
                                            $badge = 'badge-light-danger';
                                            $estatus = 'DECLINADO';
                                            break;
                                    }
                                    echo '<tr>';
                                    echo '<td >' . shortDate($registro['vac_FechaInicio'],' de ') . '</td>';
                                    echo '<td >' . shortDate($registro['vac_FechaFin'],' de ') . '</td>';
                                    $dias = calculoDias($registro['vac_VacacionesID'], session('sucursal'), $registro['vac_FechaInicio'], $registro['vac_FechaFin'], $registro['vac_EmpleadoID']);
                                    echo '<td >' . $dias . '</td>';
                                    echo '<td ><span class="badge ' . $badge . ' p-1">' . $estatus . '</span></td>';
                                    echo '<td class="text-center ">
                                <button href="' . base_url("PDF/imprimirSolicitudVacaciones/" . encryptDecrypt('encrypt', $registro['vac_VacacionesID'])) . '" class="btn btn-warning btn-icon btn-icon-mini btn-round hidden-sm-down show-pdf" data-title="Solicitud de vacaciones" title="Formato de solicitud"><i class="zmdi zmdi-local-printshop"></i></button>';
                                    if ($registro['vac_Estatus'] === 'PENDIENTE') {
                                        echo '<button href="#" data-id="' . encryptDecrypt('encrypt', $registro['vac_VacacionesID']) . '" class="btn btn-danger  btn-icon btn-icon-mini btn-round hidden-sm-down borrarVacacion"  title="Eliminar solicitud"><i class="zmdi zmdi-delete"></i></button>';
                                    }
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