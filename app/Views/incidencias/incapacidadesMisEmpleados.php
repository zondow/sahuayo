<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tincapacidades" class="table mt-4 table-hover m-0 table-centered tickets-list table-actions-bar datatableIncapacidades">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Tipo</th>
                                <th>Fecha de registro</th>
                                <th>Inicio</th>
                                <th>Fin</th>
                                <th>Días</th>
                                <th>Descripción</th>
                                <th>Estatus</th>
                                <th>Justificación</th>
                                <th width="5%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($incapacidades)) {
                                foreach ($incapacidades as $incapacidad) {
                                    $dir = base_url() . "/assets/uploads/incapacidades/" . $incapacidad['inc_EmpleadoID'] . "/" . $incapacidad['inc_Archivo'];
                                    $ext = pathinfo($incapacidad['inc_Archivo'], PATHINFO_EXTENSION);

                                    // Definir acciones para archivos
                                    $archivo = '';
                                    if (in_array($ext, ['pdf', 'jpg', 'png', 'jpeg'])) {
                                        $archivo = '<button href="' . $dir . '" class="btn btn-warning btn-icon btn-icon-mini btn-round hidden-sm-down ' . ($ext === 'pdf' ? 'show-pdf' : '') . '" ' . ($ext !== 'pdf' ? 'onclick="verImagen(\'' . $dir . '\', \'' . $ext . '\')"' : '') . ' style="color: white" title="Imprimir comprobante" data-title="Ver incapacidad">
                                                        <i class="zmdi zmdi-local-printshop"></i>
                                                    </button>';
                                    }
                            ?>
                                    <tr>
                                        <td><?= $incapacidad['emp_Nombre'] ?></td>
                                        <td><?= $incapacidad['inc_Tipo'] ?></td>
                                        <td><?= shortDate($incapacidad['inc_FechaRegistro'],' de ') ?></td>
                                        <td><?= shortDate($incapacidad['inc_FechaInicio'],' de ') ?></td>
                                        <td><?= shortDate($incapacidad['inc_FechaFin'],' de ') ?></td>
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
                                        <td>
                                            <?= $archivo ?>
                                        </td>
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
</div>