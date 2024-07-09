<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<style>
    .btn-secondary {
        background-color: #f8e018 !important;
        border: #f8e018 !important;
        color: #fff !important;
    }

    .btn-light {
        background-color: #e3eaef !important;
        border: #e3eaef !important;
        color: #313a46 !important;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="card-box">
            <!-- end row -->

            <div class="table-responsive">
                <table id="tincapacidades" class="table mt-4 table-hover m-0 table-centered tickets-list table-actions-bar datatableIncapacidades">
                    <thead>
                        <tr>
                            <th width="5%">Acciones</th>
                            <th>Nombre</th>
                            <th>Tipo</th>
                            <th>Fecha de registro</th>
                            <th>Inicio</th>
                            <th>Fin</th>
                            <th>Días</th>
                            <th>Descripción</th>
                            <th>Estatus</th>
                            <th>Justificación</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($incapacidades)) {
                            foreach ($incapacidades as $incapacidad) {
                                $dir = base_url() . "/assets/uploads/incapacidades/" . $incapacidad['inc_EmpleadoID'] . "/" . $incapacidad['inc_Archivo'];
                                if (substr($incapacidad['inc_Archivo'], -3) == "pdf") {
                                    $archivo = '<a href="' . $dir . '" class="btn btn-info waves-light btn-block waves-effect show-pdf" data-title="Imprimir comprobante incapacidad" style="color: white" title="Imprimir comprobante" ><i class="dripicons-print"></i></a>';
                                } else if (substr($incapacidad['inc_Archivo'], -3) == "jpg") {
                                    $archivo = '<a href="' . $dir . '"  data-lightbox="roadtrip" data-title="Ver incapacidad" class="btn btn-info btn-block waves-light  waves-effect " style="color: white" title="Imprimir comprobante"><i class="dripicons-print"></i></a>';
                                } else if (substr($incapacidad['inc_Archivo'], -3) == "png") {
                                    $archivo = '<a href="' . $dir . '"  data-lightbox="roadtrip" data-title="Ver incapacidad" class="btn btn-info btn-block waves-light  waves-effect " style="color: white" title="Imprimir comprobante" ><i class="dripicons-print"></i></a>';
                                } else if (substr($incapacidad['inc_Archivo'], -4) == "jpeg") {
                                    $archivo = '<a href="' . $dir . '"  data-lightbox="roadtrip" data-title="Ver incapacidad" class="btn btn-info btn-block waves-light  waves-effect " style="color: white" title="Imprimir comprobante"><i class="dripicons-print"></i></a>';
                                } else $archivo = '';

                        ?>
                                <tr>
                                    <td>
                                        <?= $archivo ?>
                                    </td>
                                    <td><?= $incapacidad['emp_Nombre'] ?></td>
                                    <td><?= $incapacidad['inc_Tipo'] ?></td>
                                    <td><?= $incapacidad['inc_FechaRegistro'] ?></td>
                                    <td><?= $incapacidad['inc_FechaInicio'] ?></td>
                                    <td><?= $incapacidad['inc_FechaFin'] ?></td>
                                    <td><?= $incapacidad['inc_Dias'] ?></td>
                                    <td><?= $incapacidad['inc_Motivos'] ?></td>
                                    <?php
                                    if ($incapacidad['inc_Estatus'] == 'Pendiente') {
                                        $badgeColor = 'badge badge-info';
                                        $titulo = 'PENDIENTE DE REVISIÓN';
                                    } elseif ($incapacidad['inc_Estatus'] === 'Autorizada') {
                                        $badgeColor = 'badge badge-success';
                                        $titulo = 'AUTORIZADA';
                                    } elseif ($incapacidad['inc_Estatus'] === 'Rechazada') {
                                        $badgeColor = 'badge badge-danger';
                                        $titulo = 'RECHAZADA';
                                    } ?>
                                    <td>
                                        <span class="<?= $badgeColor ?>"><?= $titulo ?></span>
                                    </td>
                                    <td><?= $incapacidad['inc_Justificacion'] ?></td>

                                </tr>
                        <?php }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>