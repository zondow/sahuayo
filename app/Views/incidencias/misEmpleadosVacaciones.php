<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card-box">
            <h2 class="header-title">Calendario de vacaciones</h2>
            <div id="calendarVacaciones"></div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card-box ribbon-box">
            <table class="table table-hover m-0 table-centered tickets-list table-actions-bar dt-responsive datatableVacaciones" cellspacing="0" width="100%" id="tVacaciones">
                <thead>
                    <tr>
                        <th width="5%">Acciones</th>
                        <th>Colaborador</th>
                        <th>Sucursal</th>
                        <th>Fecha inicio</th>
                        <th>Fecha fin</th>
                        <th>Estatus</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($listVacaciones) > 0) {
                        $count = 0;
                        foreach ($listVacaciones as $vacacion) {
                            echo '<tr>';
                            echo '<td>';
                            echo '<a href="' . base_url("PDF/imprimirSolicitudVacaciones/" . encryptDecrypt('encrypt', $vacacion['vac_VacacionesID'])) . '" class="btn btn-info btn-block  waves-light waves-effect show-pdf" data-title="Solicitud de vacaciones"  title="Formato solicitud" ><i class="dripicons-print"></i></a>';

                            if ($vacacion['vac_Estatus'] === "PENDIENTE") {
                                echo '<a href="#" id="btnAutorizar" class="btn btn-success btn-block autorizarRechazar" data-estatus="AUTORIZADO" data-id="' . encryptDecrypt('encrypt', $vacacion['vac_VacacionesID']) . '" title="Autorizar" ><i class="fa fa-check"></i></a>';
                                echo '<a href="#" id="btnRechazar" class="btn btn-danger btn-block autorizarRechazar" data-estatus="RECHAZADO" data-id="' . encryptDecrypt('encrypt', $vacacion['vac_VacacionesID']) . '" title="Rechazar" ><i class="fa fa-times"></i></a>';
                            }
                            echo '</td>';
                            echo '<td class="w-30"><b>' . $vacacion['emp_Nombre'] . '</b></td>';
                            echo '<td class="w-30"><b>' . $vacacion['suc_Sucursal'] . '</b></td>';
                            echo '<td class="w-15"><b>' . $vacacion['vac_FechaInicio'] . '</b></td>';
                            echo '<td class="w-15"><b>' . $vacacion['vac_FechaFin'] . '</b></td>';
                            switch ($vacacion['vac_Estatus']) {
                                case 'PENDIENTE': echo '<td class="w-15"><span class="badge badge-info">PENDIENTE</span></td>'; break;
                                case 'AUTORIZADO': echo '<td class="w-15"><span class="badge badge-warning">AUTORIZADA</span></td>'; break;
                                case 'RECHAZADO': echo '<td class="w-15"><span class="badge badge-danger">RECHAZADA</span></td>'; break;
                                case 'AUTORIZADO_RH': echo '<td class="w-15"><span class="badge badge-success">APLICADA</span></td>'; break;
                                case 'RECHAZADO_RH': echo '<td class="w-15"><span class="badge badge-danger">RECHAZADA</span></td>'; break;
                                case 'DECLINADO': echo '<td class="w-15"><span class="badge badge-light-danger">DECLINADO</span></td>'; break;
                            }
                            echo '</tr>';
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>