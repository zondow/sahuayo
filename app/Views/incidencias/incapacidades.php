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

            <div class="col-md-12">
                <div class="mb-2  ">
                    <button class="btn btn-success waves-effect waves-light mb-4" type="button" data-toggle="modal" data-target="#modalAddIncapacidad"><b class="dripicons-plus"></b> Registrar incapacidad</button>
                </div>
            </div>

            <div class="table-responsive">
                <table id="datatableIncapacidades" class="table mt-4 table-hover m-0 table-centered tickets-list table-actions-bar ">
                    <thead>
                        <tr>
                            <th width="5%">Acciones</th>
                            <th>#</th>
                            <th>Folio</th>
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
                            $count = 0;
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
                                        <?php
                                        if ($incapacidad['inc_Estatus'] == 'Pendiente') {
                                            if ((int)session("id") == (int)$incapacidad['inc_EmpleadoID']) { ?>
                                                <a href="#" data-id="<?= encryptDecrypt('encrypt', $incapacidad['inc_IncapacidadID']) ?>" class="btn btn-warning btn-block waves-light btn-small waves-effect borrarIncapacidad" style="color: white" title="Eliminar"><i class="dripicons-trash"></i></a>
                                        <?php   }
                                        }
                                        ?>
                                        <?= $archivo ?>
                                    </td>
                                    <td><?= $count += 1 ?></td>
                                    <td><?= $incapacidad['inc_Folio'] ?></td>
                                    <td><?= $incapacidad['inc_Tipo'] ?></td>
                                    <td><?= $incapacidad['inc_FechaRegistro'] ?></td>
                                    <?php if (revisarPermisos('Autorizar', $this)) { ?>
                                        <td><?= $incapacidad['emp_Nombre'] ?></td>
                                    <?php } ?>
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

<!--------------- Modal  ----------------->
<div id="modalAddIncapacidad" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Registar incapacidad</h4>
            </div>
            <form action="<?= base_url('Incidencias/addIncapacidad') ?>" method="post" autocomplete="off" role="form" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="motivos">* Folio </label>
                        <input type="text" name="folio" class="form-control" placeholder="Escriba el número de folio" required>
                    </div>
                    <div class="form-group">
                        <label for="date-range"> * Fecha inicio incapacidad: </label>
                        <input type="text" class="form-control datepicker" name="fechaInicio" placeholder="Fecha de inicio de incapacidad" required>
                    </div>
                    <div class="form-group">
                        <label for="date-range"> * Días de incapacidad: </label>
                        <input type="number" min="1" class="form-control" name="diasIncapacidad" placeholder="Escriba días de incapacidad. Ejemplo: 2" required>
                    </div>
                    <div class="form-group">
                        <label for="tipoEnfermedad" class="col-form-label">*Tipo de incapacidad</label>
                        <select name="tipoEnfermedad" id="tipoEnfermedad" class="form-control " data-placeholder="Seleccione" required>
                            <option value="" hidden>Seleccione</option>
                            <option value="ENFERMEDAD GENERAL">Enfermedad general</option>
                            <option value="RIESGO TRABAJO">Enfermedad por riesgo de trabajo</option>
                            <option value="MATERNIDAD">Maternidad</option>
                            <option value="COVID">COVID</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="motivos">* Motivo </label>
                        <textarea name="motivos" class="form-control" rows="3" placeholder="Descripción precisa de los hechos y su ubicación" required></textarea>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="archivo">* Documento:</label>
                        <input type="file" class="input-filestyle" id="archivo" name="archivo" accept="image/png, image/jpeg, .pdf" required="required">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>