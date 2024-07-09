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
                            <th>Días-Horas</th>
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
                                echo '<a href="' . base_url("PDF/imprimirSolicitudVacacionesHoras/" . encryptDecrypt('encrypt', $vacacion['vach_VacacionHorasID'])) . '" class="btn btn-info btn-block waves-light waves-effect show-pdf" data-title="Solicitud de horas-vacaciones" title="Formato solicitud"><i class="dripicons-print"></i></a>';
                                if ($vacacion['vach_Estatus'] === "PENDIENTE" ) {
                                    echo '<a data-id="' . encryptDecrypt('encrypt', $vacacion['vach_VacacionHorasID']) . '" data-estatus="AUTORIZADO_RH" href="#" class="btn btn-success btn-block autorizarRechazar" id="btnAplicar" title="Aplicar" ><i class="fa fa-check"></i></a>';
                                    echo '<a data-id="' . encryptDecrypt('encrypt', $vacacion['vach_VacacionHorasID']) . '" data-estatus="RECHAZADO_RH" href="#" class="btn btn-danger btn-block autorizarRechazar" id="btnRechazar" title="Rechazar"><i class="fa fa-times"></i></a>';
                                }
                                echo '</td>';
                                echo '<td class="w-30"><b>' . $vacacion['emp_Nombre'] . '</b></td>';
                                echo '<td class="w-30"><b>' . $vacacion['suc_Sucursal'] . '</b></td>';
                                echo '<td class="w-15"><b>' .shortDateTime($vacacion['vach_Fecha']) . '</b></td>';
                                echo '<td class="w-15"><b>' . $vacacion['vach_Dias'] . ' Días - '.$vacacion['vach_Horas'].' Horas</b></td>';
                                switch ($vacacion['vach_Estatus']) {
                                    case 'PENDIENTE': echo '<td class="w-15"><span class="badge badge-info">PENDIENTE</span></td>'; break;
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