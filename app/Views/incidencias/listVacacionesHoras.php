<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover m-0 table-centered tickets-list table-actions-bar dt-responsive datatableVacaciones" cellspacing="0" width="100%" id="tVacaciones">
                        <thead>
                            <tr>
                                <th>Colaborador</th>
                                <th>Sucursal</th>
                                <th>Fecha registro</th>
                                <th>Días-Horas</th>
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
                                    echo '<td class="w-15">' . shortDateTime($vacacion['vach_Fecha'],' de ') . '</td>';
                                    echo '<td class="w-15">' . $vacacion['vach_Dias'] . ' Días - ' . $vacacion['vach_Horas'] . ' Horas</td>';
                                    switch ($vacacion['vach_Estatus']) {
                                        case 'PENDIENTE':
                                            echo '<td class="w-15"><span class="badge badge-info">PENDIENTE</span></td>';
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
                                    echo '<button href="' . base_url("PDF/imprimirSolicitudVacacionesHoras/" . encryptDecrypt('encrypt', $vacacion['vach_VacacionHorasID'])) . '" class="btn btn-warning btn-icon btn-icon-mini btn-round hidden-sm-down show-pdf" data-title="Solicitud de horas-vacaciones" title="Formato solicitud"><i class="zmdi zmdi-local-printshop"></i></button>';
                                    if ($vacacion['vach_Estatus'] === "PENDIENTE") {
                                        echo '<button data-id="' . encryptDecrypt('encrypt', $vacacion['vach_VacacionHorasID']) . '" data-estatus="AUTORIZADO_RH" href="#" class="btn btn-success  btn-icon btn-icon-mini btn-round hidden-sm-down  autorizarRechazar" id="btnAplicar" title="Aplicar" ><i class="zmdi zmdi-check"></i></button>';
                                        echo '<button data-id="' . encryptDecrypt('encrypt', $vacacion['vach_VacacionHorasID']) . '" data-estatus="RECHAZADO_RH" href="#" class="btn btn-danger  btn-icon btn-icon-mini btn-round hidden-sm-down  autorizarRechazar" id="btnRechazar" title="Rechazar"><i class="zmdi zmdi-close"></i></button>';
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