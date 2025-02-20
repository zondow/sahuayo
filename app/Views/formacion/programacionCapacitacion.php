<style>
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }

    .dtp div.dtp-date,
    .dtp div.dtp-time {
        background-color: #001689 !important;
    }

    .dtp>.dtp-content>.dtp-date-view>header.dtp-header {
        background-color: #001689 !important;
    }
</style>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <?php if (revisarPermisos('Agregar', 'programaCapacitacion')) { ?>
                        <div class="col-md-12 text-right">
                            <button href="#" id="btnAddCapacitacion" class="btn btn-success btn-round mb-4">
                                <i class="zmdi zmdi-plus"></i> Agregar
                            </button>
                        </div>
                    <?php } ?>
                    <div class="col-md-12 table-responsive">
                        <table class="datatableCapacitacion table table-hover " cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Estatus</th>
                                    <th>No.</th>
                                    <th>Nombre del tema de capacitación</th>
                                    <th>Objetivo</th>
                                    <th>Dirigido a</th>
                                    <th>Fecha y hora</th>
                                    <th>Lugar</th>
                                    <th>Costo</th>
                                    <th>Imparte</th>
                                    <th>Participantes</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($capacitaciones)) : ?>
                                    <?php
                                    $count = 1;
                                    foreach ($capacitaciones as $capacitacion) :
                                        // Obtener fechas
                                        $fechas = json_decode($capacitacion['cap_Fechas'], true);
                                        $txtFechas = '';
                                        $fechaFin = '';
                                        $imparte = '';
                                        foreach ($fechas as $i => $fecha) :
                                            $txtFechas .= '<span class="badge badge-info">' . shortDate($fecha['fecha'], '-') . ' de ' . shortTime($fecha['inicio']) . ' a ' . shortTime($fecha['fin']) . '</span>';
                                            if ($i == count($fechas) - 1) $fechaFin = $fecha['fecha'];
                                        endforeach;

                                        // Obtener quién imparte la capacitación
                                        if ($capacitacion['cap_Tipo'] === "INTERNO" && !empty($capacitacion['cap_InstructorID'])) {
                                            $instructor = db()->query("SELECT I.*, E.emp_Nombre FROM instructor I JOIN empleado E ON E.emp_EmpleadoID=I.ins_EmpleadoID WHERE ins_InstructorID=" . $capacitacion['cap_InstructorID'])->getRowArray();
                                            $imparte = $instructor['emp_Nombre'];
                                        } elseif (!empty($capacitacion['cap_ProveedorCursoID'])) {
                                            $proveedor = consultar_dato('proveedor', '*', "pro_ProveedorID=" . $capacitacion['cap_ProveedorCursoID']);
                                            $imparte = $proveedor['pro_Nombre'];
                                        }

                                        // Obtener cantidad de participantes
                                        $participantesTotal = consultar_datos('capacitacionempleado', '*', "cape_CapacitacionID=" . $capacitacion['cap_CapacitacionID']);
                                    ?>
                                        <tr>
                                            <!-- Estado -->
                                            <td class="w-15">
                                                <span class="badge <?= $capacitacion['cap_Estado'] === 'Registrada' ? 'badge-info' : ($capacitacion['cap_Estado'] === 'Enviada' ? 'badge-warning' : ($capacitacion['cap_Estado'] === 'En curso' ? 'badge-success' : 'badge-danger')) ?>">
                                                    <?= $capacitacion['cap_Estado'] ?>
                                                </span>
                                            </td>

                                            <!-- Otros campos -->
                                            <td><?= $count ?></td>
                                            <td><?= $capacitacion['cur_Nombre'] ?></td>
                                            <td><?= $capacitacion['cur_Objetivo'] ?></td>
                                            <td><?= $capacitacion['cap_Dirigido'] ?></td>
                                            <td><?= $txtFechas ?></td>
                                            <td><?= $capacitacion['cap_Lugar'] ?></td>
                                            <td>$<?= number_format($capacitacion['cap_Costo'], 2, '.', ',') ?></td>
                                            <td><?= $imparte ?></td>
                                            <td><?= count($participantesTotal) ?></td>

                                            <!-- Botones -->
                                            <td>
                                                <?php if (revisarPermisos('Editar', 'programaCapacitacion')) : ?>
                                                    <button class="btn btn-info btn-icon btn-icon-mini btn-round hidden-sm-down btnEditCapacitacion mb-1" type="button" style="color:#fff" data-id="<?= $capacitacion['cap_CapacitacionID'] ?>">
                                                        <i class="zmdi zmdi-edit"></i>
                                                    </button>
                                                <?php endif; ?>

                                                <?php if (revisarPermisos('Ver', 'programaCapacitacion')) : ?>
                                                    <button data-href="<?= base_url('Formacion/participantesCapacitacion/' . encryptDecrypt('encrypt', $capacitacion['cap_CapacitacionID'])) ?>" class="btn btn-warning btn-block btn-icon btn-icon-mini btn-round hidden-sm-down mb-1" title="Información de la capacitación" type="button" style="color:#fff">
                                                        <i class="zmdi zmdi-info-outline"></i>
                                                    </button>
                                                <?php endif; ?>

                                                <button href="#" class="btn btn-dark mb-1  btn-icon btn-icon-mini btn-round hidden-sm-down btnComentarios" data-id="<?= $capacitacion['cap_CapacitacionID'] ?>" title="Comentarios del instructor" type="button" style="color:#fff">
                                                    <i class="zmdi zmdi-comment-alt-text"></i>
                                                </button>

                                                <?php if ($capacitacion['cap_Estado'] != "Terminada") : ?>
                                                    <?php if (revisarPermisos('Ver', 'programaCapacitacion')) :
                                                        $participantes = db()->table("capacitacionempleado")->getWhere(['cape_CapacitacionID' => $capacitacion['cap_CapacitacionID']])->getRowArray();
                                                        if ($participantes) : ?>
                                                            <button href="#" class="btn btn-success mb-1 btn-icon btn-icon-mini btn-round hidden-sm-down btnEnviarConvocatoriaCap" data-id="<?= $capacitacion['cap_CapacitacionID'] ?>" type="button" title="Enviar convocatoria" style="color:#fff">
                                                                <i class="zmdi zmdi-mail-send"></i>
                                                            </button>
                                                    <?php endif;
                                                    endif; ?>

                                                    <?php if (revisarPermisos('Editar', 'programaCapacitacion')) : ?>
                                                        <button class="btn btn-danger btn-icon btn-icon-mini btn-round hidden-sm-down btnTerminarCapacitacion mb-1" type="button" style="color:#fff" data-id="<?= $capacitacion['cap_CapacitacionID'] ?>">
                                                            <i class="zmdi zmdi-calendar-alt"></i>
                                                        </button>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php
                                        $count++;
                                    endforeach;
                                    ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--------------- Modal Agregar ----------------->
<div id="modalAddCapacitacion" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Programa de capacitación</h4>
            </div>
            <form id="formCapacitacion" action="<?= base_url('Formacion/addCapacitacion') ?>" method="post" autocomplete="off" role="form">
                <input type="hidden" name="cap_CapacitacionID" id="cap_CapacitacionID" value="0">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cap_CursoID">* Curso </label>
                                <select type="text" class="select2" name="cap_CursoID" id="cap_CursoID" required>
                                    <option hidden value="">Seleccione</option>
                                    <?php foreach ($cursos as $curso) {
                                        echo '<option value="' . $curso['cur_CursoID'] . '">' . $curso['cur_Nombre'] . '</option>';
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="cap_Lugar">* Lugar</label>
                                <input name="cap_Lugar" id="cap_Lugar" class="form-control" placeholder="Escriba el nombre del lugar" required>
                            </div>
                        </div>

                        <div class="col-md-12">

                            <h5 style="vertical-align: middle !important;" for="">*Días &nbsp;&nbsp;
                                <i id="btnNuevoDia" class="zmdi zmdi-plus-circle-o btnAddDia" style="color: #00c100" data-toggle="tooltip" data-placement="top" title="Agregar Registro" required></i>
                                <i id="btnEliminarDia" class="zmdi zmdi-minus-circle-outline btnRemoveDia" style="color: red" data-toggle="tooltip" data-placement="top" title="Quitar Registro"></i>
                            </h5>
                            <div id="divDias" class=" mb-2 ">
                                <div id="dia_1" class="row dia1">
                                    <div class="form-group col-md-4">
                                        <label for="fecha1"> * Fecha </label>
                                        <input type="text" class="form-control datepicker" id="fecha1" name="fecha[]" placeholder=" Seleccione" required>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="inicio1">* Hora inicio</label>
                                        <input id="inicio1" name="inicio[]" placeholder="Seleccione" class="form-control timepicker">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="fin1">*Hora fin</label>
                                        <input type="text" id="fin1" name="fin[]" placeholder="Seleccione" class="form-control timepicker">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="cap_Costo">* Costo</label>
                                <input type="number" min="0" name="cap_Costo" id="cap_Costo" class="form-control" placeholder="Escriba el costo" required>

                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="cap_Tipo">* Tipo</label>
                                <select type="text" class="select2" name="cap_Tipo" id="cap_Tipo" required>
                                    <option hidden value="">Seleccione</option>
                                    <option value="INTERNO">INTERNO</option>
                                    <option value="EXTERNO">EXTERNO</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4" id="divProv">
                            <div class="form-group">
                                <label for="cap_ProveedorCursoID">* Proveedor</label>
                                <select type="text" class="select2" name="cap_ProveedorCursoID" id="cap_ProveedorCursoID" required>
                                    <option hidden value="">Seleccione</option>
                                    <?php foreach ($proveedores as $proveedor) {
                                        echo '<option value="' . $proveedor['pro_ProveedorID'] . '">' . $proveedor['pro_Nombre'] . '</option>';
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4" id="divInstructor">
                            <div class="form-group">
                                <label for="cap_ProveedorCursoID">* Instructor</label>
                                <select type="text" class="select2" name="cap_InstructorID" id="cap_InstructorID" required>
                                    <option hidden value="">Seleccione</option>
                                    <?php foreach ($instructores as $instructor) {
                                        echo '<option value="' . $instructor['ins_InstructorID'] . '">' . $instructor['ins_Nombre'] . '</option>';
                                    } ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="cap_Comprobante">* Constancia </label>
                                <select type="text" class="select2" name="cap_Comprobante" id="cap_Comprobante" required>
                                    <option hidden value="">Seleccione</option>
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4" id="selectComprobante">
                            <div class="form-group">
                                <label for="selectImagen">Selecciona comprobante:</label>
                                <select class="select2" id="cap_TipoComprobante" name="cap_TipoComprobante">
                                    <option hidden value="">Selecciona una imagen</option>
                                    <option value="1">Comprobante 1</option>
                                    <option value="2">Comprobante 2</option>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <img id="selectImagen" src="" class="img-fluid">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="cap_Calificacion"> Calificación aprobatoria </label>
                                <input type="number" min="0" max="10" class="form-control restrictCalificacion" name="cap_CalAprobatoria" id="cap_CalAprobatoria" placeholder="0.0">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="cap_Dirigido"> Dirigido a </label>
                                <textarea name="cap_Dirigido" id="cap_Dirigido" class="form-control" rows="2" placeholder="Personal al que va dirigido"></textarea>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="cap_Objetivo">* Observaciones</label>
                                <textarea name="cap_Observaciones" id="cap_Observaciones" class="form-control" rows="3" placeholder="Escriba observaciones" required></textarea>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <div class="text-right col-md-12">
                        <button type="button" class="btn btn-light btn-round" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success btn-round">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!--------------- Modal comentarios ----------------->
<div id="modalAddComentarios" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Comentarios del instructor</h4>
            </div>
            <form id="formComentarios" method="post" autocomplete="off">
                <input type="hidden" name="cap_CapacitacionID" id="cap_CapacitacionID" value="0">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="cap_ComentariosInstructor">Recursos que el instructor necesita para implementar la capacitación, asi como los comentario u observaciones.</label>
                                <textarea type="text" class="form-control" rows="3" name="cap_ComentariosInstructor" id="cap_ComentariosInstructor"></textarea>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="text-right col-md-12">
                        <button type="button" class="btn btn-light btn-round waves-effect" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            dropdownParent: $('#modalAddCapacitacion'), // Usamos el modal como parent directo
            placeholder: 'Seleccione una opción',
            allowClear: true,
            width: 'resolve'
        });
    });
</script>