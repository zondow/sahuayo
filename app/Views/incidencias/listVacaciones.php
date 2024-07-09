<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-12">
        <div class="card-box ">
            <div class="table-responsive">
                <table class="table table-hover m-0 table-centered tickets-list table-actions-bar dt-responsive datatableVacaciones" cellspacing="0" width="100%" id="tVacaciones">
                    <thead>
                        <tr>
                            <th width="5%">Acciones</th>
                            <th>Colaborador</th>
                            <th>Sucursal</th>
                            <th>Fecha registro</th>
                            <th>Fecha inicio</th>
                            <th>Fecha fin</th>
                            <th>Dias</th>
                            <th>Estatus</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        if (count($listVacaciones) > 0) {
                            $count = 0;
                            $estatus = ($type === "aplicar") ? "AUTORIZADO_RH" : "AUTORIZADO";
                            foreach ($listVacaciones as $vacacion) {
                                echo '<tr>';
                                echo '<td>';
                                echo '<a href="' . base_url("PDF/imprimirSolicitudVacaciones/" . encryptDecrypt('encrypt', $vacacion['vac_VacacionesID'])) . '" class="btn btn-info btn-block waves-light waves-effect show-pdf" data-title="Solicitud de vacaciones" title="Formato solicitud"><i class="dripicons-print"></i></a>';
                                if ($vacacion['vac_Estatus'] === "PENDIENTE" || $vacacion['vac_Estatus'] === "AUTORIZADO" || $vacacion['vac_Estatus'] === "AUTORIZADO_GO") {
                                    echo '<a data-id="' . encryptDecrypt('encrypt', $vacacion['vac_VacacionesID']) . '" data-type="' . $type . '" data-estatus="' . $estatus . '" href="#" class="btn btn-success btn-block autorizarRechazar" id="btnAplicar" title="Aplicar" ><i class="fa fa-check"></i></a>';
                                    echo '<a data-id="' . encryptDecrypt('encrypt', $vacacion['vac_VacacionesID']) . '" data-type="' . $type . '" data-estatus="RECHAZADO" href="#" class="btn btn-danger btn-block autorizarRechazar" id="btnRechazar" title="Rechazar"><i class="fa fa-times"></i></a>';
                                } else if ($vacacion['vac_Estatus'] === "AUTORIZADO_RH") {
                                    echo '<a data-id="' . encryptDecrypt('encrypt', $vacacion['vac_VacacionesID']) . '"  href="#" class="btn btn-dark btn-block declinarVacaciones" title="Declinar"><i class="mdi mdi-diameter-variant"></i></a>';
                                }
                                echo '</td>';
                                echo '<td class="w-30"><b>' . $vacacion['emp_Nombre'] . '</b></td>';
                                echo '<td class="w-30"><b>' . $vacacion['suc_Sucursal'] . '</b></td>';
                                echo '<td class="w-15"><b>' . $vacacion['vac_FechaRegistro'] . '</b></td>';
                                echo '<td class="w-15"><b>' . $vacacion['vac_FechaInicio'] . '</b></td>';
                                echo '<td class="w-15"><b>' . $vacacion['vac_FechaFin'] . '</b></td>';
                                //$dias = calculoDias($vacacion['vac_VacacionesID'], $this, $vacacion['emp_SucursalID'], $vacacion['vac_FechaInicio'], $vacacion['vac_FechaFin']);
                                echo '<td class="w-15"><b>' . $vacacion['vac_Disfrutar'] . '</b></td>';
                                switch ($vacacion['vac_Estatus']) {
                                    case 'PENDIENTE': echo '<td class="w-15"><span class="badge badge-info">PENDIENTE</span></td>'; break;
                                    case 'AUTORIZADO': echo '<td class="w-15"><span class="badge badge-warning">AUTORIZADA JEFE</span></td>'; break;
                                    case 'RECHAZADO': echo '<td class="w-15"><span class="badge badge-danger">RECHAZADA</span></td>'; break;
                                    case 'AUTORIZADO_GO': echo '<td class="w-15"><span class="badge badge-warning">AUTORIZADA GERENTE OPERATIVO</span></td>'; break;
                                    case 'AUTORIZADO_RH': echo '<td class="w-15"><span class="badge badge-success">APLICADO</span></td>'; break;
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
</div>