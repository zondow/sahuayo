<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card-box">
            <!-- end row -->
            <div class="row">
                <div class="mb-2 col-md-3 text-left">
                    <?php if (revisarPermisos('Agregar', $this)) { ?>
                        <button class="btn btn-success waves-effect waves-light mb-4" type="button" data-toggle="modal" data-target="#modalAddActa"><b class="dripicons-plus"></b>Registar sanción</button>
                    <?php } ?>
                </div>
            </div>
            <div class="table-responsive">
                <table id="datatableActas" class="table mt-4 table-hover m-0 table-centered tickets-list table-actions-bar ">
                    <thead>
                        <tr>
                            <th width="5%">Acciones</th>
                            <th>#</th>
                            <th># Socio</th>
                            <th>Colaborador</th>
                            <th>Sucursal</th>
                            <th>Fecha de los hechos</th>
                            <th>Fecha de registro</th>
                            <th>Observaciones</th>
                            <th>Tipo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($actas)) {
                            $count = 0;
                            foreach ($actas as $acta) {
                                $dir = base_url() . "/assets/uploads/actasadmin/" . $acta['act_Documento'];
                                if (substr($acta['act_Documento'], -3) === "pdf") {
                                    $archivo = '<a href="' . $dir . '" class="btn btn-info waves-light btn-block waves-effect show-pdf" data-title="Imprimir acta administrativa" style="color: white" title="Imprimir documento" ><i class="dripicons-print"></i></a>';
                                } else if (substr($acta['act_Documento'], -3) === "jpg") {
                                    $archivo = '<a href="' . $dir . '"  data-lightbox="roadtrip" data-title="Ver acta administrativa" class="btn btn-info btn-block waves-light  waves-effect " style="color: white" title="Imprimir documento" ><i class="dripicons-print"></i></a>';
                                } else if (substr($acta['act_Documento'], -3) === "png") {
                                    $archivo = '<a href="' . $dir . '"  data-lightbox="roadtrip" data-title="Ver acta administrativa" class="btn btn-info btn-block waves-light  waves-effect " style="color: white" title="Imprimir documento" ><i class="dripicons-print"></i></a>';
                                } else if (substr($acta['act_Documento'], -4) === "jpeg") {
                                    $archivo = '<a href="' . $dir . '"  data-lightbox="roadtrip" data-title="Ver acta administrativa" class="btn btn-info btn-block waves-light  waves-effect " style="color: white" title="Imprimir documento" ><i class="dripicons-print"></i></a>';
                                } else $archivo = '';

                                $tipo = '';
                                switch ($acta['act_Tipo']) {
                                    case 'Llamada de atención verbal':
                                        $tipo = '<span class="badge badge-dark">Llamada de atención verbal</span>';
                                        break;
                                    case 'Amonestación':
                                        $tipo = '<span class="badge badge-info">Amonestación <br> (Carta Extrañamiento)</span>';
                                        break;
                                    case 'Compromiso por escrito':
                                        $tipo = '<span class="badge badge-warning">Compromiso por escrito</span>';
                                        break;
                                    case 'Acta administrativa':
                                        $tipo = '<span class="badge badge-danger">Acta administrativa</span>';
                                        break;
                                    case 'Suspension':
                                        $tipo = '<span class="badge badge-purple">Suspención</span>';
                                        break;
                                }
                        ?>
                                <tr>
                                    <td>
                                        <?= $archivo ?>
                                        <?php if (revisarPermisos('Eliminar', $this)) ?>
                                        <a href="#" data-id="<?= encryptDecrypt('encrypt', $acta['act_ActaAdministrativaID']) ?>" class="btn btn-danger btn-block waves-light btn-small waves-effect eliminarSancion" style="color: white" title="Eliminar"><i class="dripicons-trash"></i></a>

                                    </td>
                                    <td><?= $count += 1 ?></td>
                                    <td><?= $acta['emp_Numero'] ?></td>
                                    <td><?= $acta['emp_Nombre'] ?></td>
                                    <td><?= $acta['suc_Sucursal'] ?></td>
                                    <td><?= $acta['act_FechaRealizo'] ?></td>
                                    <td><?= $acta['act_FechaRegistro'] ?></td>
                                    <td><?= $acta['act_Observaciones'] ?></td>
                                    <td><?= $tipo ?></td>
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
                        <select id="empleado" name="empleado" class="form-control  select2-single" style="width: 100%" required>
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
                        <select id="tipo" name="tipo" class="form-control  select2-single" style="width: 100%" required>
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

<script>
    $(document).ready(function(e) {


        $("#archivo").fileinput({
            showUpload: false,
            dropZoneEnabled: false,
            language: "es",
            mainClass: "input-group",
            allowedFileExtensions: ["pdf", "png", "jpeg", "jpg"]
        });
    });
</script>