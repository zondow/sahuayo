<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="col-md-12 text-right">
                    <?php if (revisarPermisos('Agregar', 'incapacidad')) { ?>
                        <button class="btn btn-success btn-round waves-effect waves-light mb-4" type="button" data-toggle="modal" data-target="#modalAddActa"><b class="dripicons-plus"></b>Registar sanción</button>
                    <?php } ?>
                </div>
                <div class="table-responsive">
                    <table id="datatableActas" class="table mt-4 table-hover m-0 table-centered tickets-list table-actions-bar ">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th># Socio</th>
                                <th>Colaborador</th>
                                <th>Sucursal</th>
                                <th>Fecha de los hechos</th>
                                <th>Fecha de registro</th>
                                <th>Observaciones</th>
                                <th>Tipo</th>
                                <th width="5%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($actas)) {
                                $count = 0;
                                $extMap = [
                                    'pdf' => '<button href="%s" class="btn btn-warning btn-icon btn-icon-mini btn-round hidden-sm-down show-pdf" data-title="Imprimir acta administrativa" style="color: white" title="Imprimir documento"><i class="zmdi zmdi-local-printshop"></i></button>',
                                    'jpg' => '<button onclick="verImagen(\'%s\', \'%s\')" class="btn btn-warning btn-icon btn-icon-mini btn-round hidden-sm-down" style="color: white" data-title="Ver acta administrativa" title="Ver imagen"><i class="zmdi zmdi-image"></i></button>',
                                    'png' => '<button onclick="verImagen(\'%s\', \'%s\')" class="btn btn-warning btn-icon btn-icon-mini btn-round hidden-sm-down" style="color: white" data-title="Ver acta administrativa" title="Ver imagen"><i class="zmdi zmdi-image"></i></button>',
                                    'jpeg' => '<button onclick="verImagen(\'%s\', \'%s\')" class="btn btn-warning btn-icon btn-icon-mini btn-round hidden-sm-down" style="color: white" data-title="Ver acta administrativa" title="Ver imagen"><i class="zmdi zmdi-image"></i></button>'
                                ];

                                $tipoMap = [
                                    'Llamada de atención verbal' => '<span class="badge badge-dark">Llamada de atención verbal</span>',
                                    'Amonestación' => '<span class="badge badge-info">Amonestación <br> (Carta Extrañamiento)</span>',
                                    'Compromiso por escrito' => '<span class="badge badge-warning">Compromiso por escrito</span>',
                                    'Acta administrativa' => '<span class="badge badge-danger">Acta administrativa</span>',
                                    'Suspension' => '<span class="badge badge-purple">Suspensión</span>'
                                ];

                                foreach ($actas as $acta) {
                                    $dir = base_url() . "/assets/uploads/actasadmin/" . $acta['act_Documento'];
                                    $ext = strtolower(pathinfo($acta['act_Documento'], PATHINFO_EXTENSION));
                                    $archivo = isset($extMap[$ext]) ? sprintf($extMap[$ext], $dir, $ext) : '';

                                    $tipo = $tipoMap[$acta['act_Tipo']] ?? '';

                                    echo "<tr>
                                        <td>" . ++$count . "</td>
                                        <td>{$acta['emp_Numero']}</td>
                                        <td>{$acta['emp_Nombre']}</td>
                                        <td>{$acta['suc_Sucursal']}</td>
                                        <td>{$acta['act_FechaRealizo']}</td>
                                        <td>{$acta['act_FechaRegistro']}</td>
                                        <td>{$acta['act_Observaciones']}</td>
                                        <td>{$tipo}</td>
                                        <td>
                                            {$archivo}
                                            " . (revisarPermisos('Eliminar', 'incapacidad') ? '<button href="#" data-id="' . encryptDecrypt('encrypt', $acta['act_ActaAdministrativaID']) . '" class="btn btn-danger btn-icon btn-icon-mini btn-round hidden-sm-down eliminarSancion" style="color: white" title="Eliminar"><i class="zmdi zmdi-delete"></i></button>' : '') . "
                                        </td>
                                    </tr>";
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

<!--------------- Modal Agregar ----------------->
<div id="modalAddActa" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog ">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Registrar sanción</h4>
            </div>
            <form action="<?= base_url('Incidencias/addActaAdministrativa') ?>" method="post" autocomplete="off" role="form" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group ">
                        <label class="col-form-label">* Fecha</label>
                        <input type="text" class="form-control datepicker" id="fecha" name="fecha" required placeholder="Seleccione fecha de ingreso">
                    </div>

                    <div class="form-group ">
                        <label for="empleado">* Empleado inculpado</label>
                        <select id="empleado" name="empleado" class="select2" style="width: 100%" required>
                            <option value="" hidden>Seleccione</option>
                            <?php
                            foreach ($empleados as $empleado) {
                                echo '<option value="' . $empleado["emp_EmpleadoID"] . '">' . $empleado["emp_Nombre"] . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group ">
                        <label for="tipo">* Tipo</label>
                        <select id="tipo" name="tipo" class="select2" style="width: 100%" required>
                            <option value="" hidden>Seleccione</option>
                            <option value="Llamada de atención verbal">Llamada de atención verbal</option>
                            <option value="Amonestación">Amonestación (Carta Extrañamiento)</option>
                            <option value="Compromiso por escrito">Compromiso por escrito</option>
                            <option value="Acta administrativa">Acta administrativa</option>
                            <option value="Suspension">Suspensión</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="archivo">Documento:</label>
                        <input type="file" class="form-control file" id="archivo" name="archivo" accept="image/png, image/jpeg, .pdf">
                    </div>

                    <div class="form-group">
                        <label for="observaciones"> Observaciones</label>
                        <textarea id="observaciones" name="observaciones" class="form-control" rows="3" placeholder="Escriba alguna observación que quiera agregar. (Opcional)"></textarea>
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
<!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Ver imagen</h5>
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


        $("#archivo").fileinput({
            showUpload: false,
            dropZoneEnabled: false,
            language: "es",
            mainClass: "input-group",
            allowedFileExtensions: ["pdf", "png", "jpeg", "jpg"]
        });
        $('.select2').select2({
            dropdownParent: $('#modalAddActa .modal-body'),
            placeholder: 'Seleccione una opción',
            allowClear: true,
            width: 'resolve'
        });
    });
</script>