<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-hover m-0 table-centered table-responsive tickets-list table-actions-bar dt-responsive datatableVacaciones" cellspacing="0" width="100%" id="tVacaciones">
                    <thead>
                        <tr>
                            <th>Colaborador</th>
                            <th>Sucursal</th>
                            <th>Fecha registro</th>
                            <th>Periodo</th>
                            <th>Dias</th>
                            <th>Estatus</th>
                            <th width="5%">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        if (count($listVacaciones) > 0) {
                            $count = 0;
                            foreach ($listVacaciones as $vacacion) {
                                echo '<tr>';

                                echo '<td class="w-30">' . $vacacion['emp_Nombre'] . '</td>';
                                echo '<td class="w-30">' . $vacacion['suc_Sucursal'] . '</td>';
                                echo '<td class="w-15">' . shortDateTime($vacacion['vac_FechaRegistro'], ' de ') . '</td>';
                                echo '<td class="w-15">' . shortDate($vacacion['vac_FechaInicio'], ' de ') . ' al ' . shortDate($vacacion['vac_FechaFin'], ' de ') . '</td>';
                                echo '<td class="w-15">' . $vacacion['vac_Disfrutar'] . '</td>';
                                switch ($vacacion['vac_Estatus']) {
                                    case 'PENDIENTE':
                                        echo '<td class="w-15"><span class="badge badge-info">PENDIENTE</span></td>';
                                        break;
                                    case 'AUTORIZADO':
                                        echo '<td class="w-15"><span class="badge badge-warning">AUTORIZADA JEFE</span></td>';
                                        break;
                                    case 'RECHAZADO':
                                        echo '<td class="w-15"><span class="badge badge-danger">RECHAZADA</span></td>';
                                        break;
                                    case 'AUTORIZADO_GO':
                                        echo '<td class="w-15"><span class="badge badge-warning">AUTORIZADA GERENTE OPERATIVO</span></td>';
                                        break;
                                    case 'AUTORIZADO_RH':
                                        echo '<td class="w-15"><span class="badge badge-success">APLICADO</span></td>';
                                        break;
                                    case 'RECHAZADO_RH':
                                        echo '<td class="w-15"><span class="badge badge-danger">RECHAZADA</span></td>';
                                        break;
                                    case 'DECLINADO':
                                        echo '<td class="w-15"><span class="badge badge-light-danger">DECLINADO</span></td>';
                                        break;
                                }
                                echo '<td>';
                                echo '<button href="' . base_url("PDF/imprimirSolicitudVacaciones/" . encryptDecrypt('encrypt', $vacacion['vac_VacacionesID'])) . '" class="btn btn-warning btn-icon btn-icon-mini btn-round hidden-sm-down  show-pdf" data-title="Solicitud de vacaciones" title="Formato solicitud"><i class="zmdi zmdi-local-printshop"></i></button>';
                                if ($vacacion['vac_Estatus'] === "PENDIENTE" || $vacacion['vac_Estatus'] === "AUTORIZADO" || $vacacion['vac_Estatus'] === "AUTORIZADO_GO") {
                                    echo '<button data-id="' . encryptDecrypt('encrypt', $vacacion['vac_VacacionesID']) . '" data-type="aplicar" data-estatus="AUTORIZADO_RH" href="#" class="btn btn-success  btn-icon btn-icon-mini btn-round hidden-sm-down autorizarRechazar" id="btnAplicar" ><i class="zmdi zmdi-check"></i></button>';
                                    echo '<button data-id="' . encryptDecrypt('encrypt', $vacacion['vac_VacacionesID']) . '" data-type="aplicar" data-estatus="RECHAZADO" href="#" class="btn btn-danger  btn-icon btn-icon-mini btn-round hidden-sm-down autorizarRechazar" id="btnRechazar"><i class="zmdi zmdi-close"></i></button>';
                                } else if ($vacacion['vac_Estatus'] === "AUTORIZADO_RH") {
                                    echo '<button data-id="' . encryptDecrypt('encrypt', $vacacion['vac_VacacionesID']) . '"  href="#" class="btn btn-dark  btn-icon btn-icon-mini btn-round hidden-sm-down declinarVacaciones" title="Declinar"><i class="zmdi zmdi-minus-circle"></i></button>';
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