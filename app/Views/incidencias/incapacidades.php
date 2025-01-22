<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="col-md-12 text-right">
                    <button class="btn btn-round btn-success waves-effect waves-light mb-4" type="button" data-toggle="modal" data-target="#modalAddIncapacidad">
                        <i class="zmdi zmdi-plus"></i> Agregar
                    </button>
                </div>
                <div class="table-responsive">
                    <table id="datatableIncapacidades" class="table mt-4 table-hover m-0 table-centered tickets-list table-actions-bar">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Folio</th>
                                <th>Tipo</th>
                                <th>Fecha de registro</th>
                                <th>Colaborador</th>
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
                            <?php if (!empty($incapacidades)) {
                                $count = 0;
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

                                    // Definir estatus y estilos de badge
                                    $statusMap = [
                                        'Pendiente' => ['badge-info', 'PENDIENTE DE REVISIÓN'],
                                        'Autorizada' => ['badge-success', 'AUTORIZADA'],
                                        'Rechazada' => ['badge-danger', 'RECHAZADA']
                                    ];
                                    list($badgeColor, $titulo) = $statusMap[$incapacidad['inc_Estatus']] ?? ['', ''];
                            ?>
                                    <tr>
                                        <td><?= ++$count ?></td>
                                        <td><?= $incapacidad['inc_Folio'] ?></td>
                                        <td><?= $incapacidad['inc_Tipo'] ?></td>
                                        <td><?= shortDate($incapacidad['inc_FechaRegistro'], ' de ') ?></td>
                                        <?php if (revisarPermisos('Autorizar', 'incapacidad')) { ?>
                                            <td><?= $incapacidad['emp_Nombre'] ?></td>
                                        <?php } ?>
                                        <td><?= shortDate($incapacidad['inc_FechaInicio'], ' de ') ?></td>
                                        <td><?= shortDate($incapacidad['inc_FechaFin'], ' de ') ?></td>
                                        <td><?= $incapacidad['inc_Dias'] ?></td>
                                        <td><?= $incapacidad['inc_Motivos'] ?></td>
                                        <td><span class="badge <?= $badgeColor ?>"><?= $titulo ?></span></td>
                                        <td><?= $incapacidad['inc_Justificacion'] ?></td>
                                        <td>
                                            <?php if ($incapacidad['inc_Estatus'] == 'Pendiente' && (int)session("id") === (int)$incapacidad['inc_EmpleadoID']) { ?>
                                                <button href="#" data-id="<?= encryptDecrypt('encrypt', $incapacidad['inc_IncapacidadID']) ?>" class="btn btn-danger btn-icon btn-icon-mini btn-round hidden-sm-down borrarIncapacidad" style="color: white" title="Eliminar">
                                                    <i class="zmdi zmdi-delete"></i>
                                                </button>
                                            <?php } ?>
                                            <?= $archivo ?>
                                        </td>
                                    </tr>
                            <?php }
                            } ?>
                        </tbody>
                    </table>
                </div>
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
                        <select name="tipoEnfermedad" id="tipoEnfermedad" class="select2" data-placeholder="Seleccione" required>
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
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-light btn-round" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success btn-round">Guardar</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="imageModalLabel">Ver imagen</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid" alt="Imagen">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(e) {
        $('.select2').select2({
            dropdownParent: $('#modalAddIncapacidad .modal-body'),
            placeholder: 'Seleccione una opción',
            allowClear: true,
            width: 'resolve'
        });
    });
</script>