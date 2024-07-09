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
                        <div class="col-12">
                            <div class="mt-3">
                                <h6><?= $diasRestantes ?> días</h6>
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
            <h4 class="header-title mb-4">Solicitud de Vacaciones</h4>
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

                <button type="submit" class="btn btn-success mb-0" id="btnRegistrar" data-loading-text="<i class='iconsminds-loading-3'></i> Registrando...">
                        <i class="dripicons-plus"></i> Registrar
                    </button>
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
                            <th>Fecha inicio</th>
                            <th>Fecha fin</th>
                            <th>Días ocupados</th>
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
                                switch ($registro['vac_Estatus']) {
                                    case 'PENDIENTE':
                                        $badge = 'badge-dark';
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
                                echo '<td class="text-center ">
                                <a href="' . base_url("PDF/imprimirSolicitudVacaciones/" . encryptDecrypt('encrypt', $registro['vac_VacacionesID'])) . '" class="btn btn-info btn-block waves-light waves-effect show-pdf" data-title="Solicitud de vacaciones" title="Formato de solicitud"><i class="dripicons-print"></i></a>';
                                if ($registro['vac_Estatus'] === 'PENDIENTE') {
                                    echo '<a href="#" data-id="' . encryptDecrypt('encrypt', $registro['vac_VacacionesID']) . '" class="btn btn-danger btn-block waves-light waves-effect borrarVacacion"  title="Eliminar solicitud"><i class="dripicons-trash"></i></a>';
                                }
                                echo '</td>';
                                echo '<td ><b>' . $registro['vac_FechaInicio'] . '</b></td>';
                                echo '<td ><b>' . $registro['vac_FechaFin'] . '</b></td>';
                                $dias = calculoDias($registro['vac_VacacionesID'], $this, session('sucursal'), $registro['vac_FechaInicio'], $registro['vac_FechaFin'],$registro['vac_EmpleadoID']);
                                echo '<td ><b>' . $dias . '</b></td>';
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