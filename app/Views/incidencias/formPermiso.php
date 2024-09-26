<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div class="row clearfix">
    <div class="col-lg-12">
        <div class="card">
            <ul class="row profile_state list-unstyled">
                <?php if ($horasExtra > 0) { ?>
                    <li class="col-lg-6 col-md-6 col-6">
                        <div class="body">
                            <i class="zmdi zmdi-timer col-blue"></i>
                            <h4><?= $horasExtra ?></h4>
                            <span>Horas extra disponibles</span>
                        </div>
                    </li>
                <?php } ?>
                <li class="col-lg-6 col-md-6 col-6">
                    <div class="body">
                        <i class="zmdi zmdi-calendar-alt col-amber"></i>
                        <h4><?= $horasAdministrativas ?></h4>
                        <span>Horas administrativas disponibles</span>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="collapse show" id="frmRegistroPermiso">
                    <form id="frmPermiso" method="post" autocomplete="off">
                        <div class="position-relative row form-group">
                            <div class="col-md-12 mb-2">
                                <label>*Tipo de permiso</label>
                                <select name="txtTipoPermiso" id="txtTipoPermiso" class="select2" data-placeholder="Seleccionar tipo de permiso" style="width: 100% !important;" required>
                                    <option value="" hidden>Seleccione</option>
                                    <?php
                                    if (!empty($catalogoPermisos)) {
                                        foreach ($catalogoPermisos as $cat) {
                                            $id = (int)$cat['cat_CatalogoPermisoID'];
                                            $name = $cat['cat_Nombre'];

                                            // Condiciones para ocultar opciones
                                            if (($empleado['emp_EstadoCivil'] === 'CASADO (A)' && $cat['cat_Identificador'] === 'permisoCumpleanios') ||
                                                ($empleado['emp_EstadoCivil'] === 'SOLTERO (A)' && $cat['cat_Identificador'] === 'aniversarioBoda') ||
                                                ($cat['cat_Identificador'] === 'permisoHoras' && $horasExtra <= 0) ||
                                                ($empleado['emp_Sexo'] === 'Masculino' && $cat['cat_Identificador'] == 'licenciaLactancia') ||
                                                ($empleado['emp_Sexo'] !== 'Masculino' && $cat['cat_Identificador'] == 'permisoNacimiento')
                                            ) {
                                                continue; // Salta a la siguiente iteración, omitiendo la opción
                                            }

                                            echo "<option value='$id'>$name</option>";
                                        }
                                    } else {
                                        echo '<option disabled>No hay tipos de permisos registrados</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <div class="position-relative form-group">
                                    <label>*Período del permiso</label>
                                    <div>
                                        <div class="input-daterange input-group" id="date-range">
                                            <input type="text" class="form-control " name="txtFechaInicio" id="txtFechaInicio" placeholder="Inicio" required>
                                            <input type="text" class="form-control " name="txtFechaFin" id="txtFechaFin" placeholder="Fin" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6" id="divHoraSalida">
                                <div class="position-relative form-group">
                                    <label id="labelInicio">Hora Inicio</label>
                                    <input class="form-control timepicker" style="right: unset !important;" placeholder="Seleccione la hora" id="txtHoraI" name="txtHoraI">
                                </div>
                            </div>
                            <div class="col-md-6" id="divHoraRegreso">
                                <div class="position-relative form-group">
                                    <label id="labelFin">Hora Fin</label>
                                    <input class="form-control timepicker" style="right: unset !important;" placeholder="Seleccione la hora" id="txtHoraF" name="txtHoraF">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="position-relative form-group">
                                    <label for="per_Motivos" class="">
                                        <span>Motivos</span>
                                    </label>
                                    <textarea name="txtMotivos" id="txtMotivos" placeholder="Motivo del permiso" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 text-right align-self-center">
                                <button class="btn btn-round btn-success" id="btnRegistarPermiso"><span><i class="fe-plus"></i> Registrar</span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Tabla de mis permiso-->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table id="tblPermisos" class="table table-hover m-0 table-centered tickets-list table-actions-bar dt-responsive" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tipo permiso</th>
                            <th>Fecha de inicio</th>
                            <th>Fecha de fin</th>
                            <th>Días</th>
                            <th>Motivos</th>
                            <th>Estatus</th>
                            <th width="5%">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(e) {
        $('.select2').select2({
            //dropdownParent: $('#modalAddGuardia .modal-body'),
            placeholder: 'Seleccione una opción',
            allowClear: true,
            width: 'resolve'
        });
    });
</script>