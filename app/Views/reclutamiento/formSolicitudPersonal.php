<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="<?= base_url('Reclutamiento/addSolicitudPersonal') ?>" method="post" autocomplete="off" role="form">
                    <div class="card-box text-center" style="border-radius: 15px">
                        <h4 class="text-uppercase font-weight-bold" style="color: #00acc1 !important;">Generales</h4>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-4 mb-3">
                                <label class="control-label"> Sucursal:</label>
                                <input class="form-control" value="<?= $empleado['suc_Sucursal'] ?>" name="sucursal" id="sucursal" readonly required>
                            </div>
                            <div class="col-4">
                                <label class="control-label"> Departamento:</label>
                                <input class="form-control" value="<?= $empleado['dep_Nombre'] ?>" name="departamento" id="departamento" readonly required>

                            </div>
                            <div class="col-4">
                                <label class="control-label"> Fecha:</label>
                                <div class="">
                                    <input class="form-control datepicker" name="fechaSolicitud" id="fechaSolicitud" value="<?= date('Y-m-d') ?>" readonly required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr style="width:100%;text-align:left;margin-left:0">
                    <div class="card-box text-center" style="border-radius: 15px">
                        <h4 class="text-uppercase font-weight-bold" style="color: #00acc1 !important;">Datos Del Solicitante</h4>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                <label class="control-label"> Nombre:</label>
                                <input class="form-control" value="<?= $empleado['emp_Nombre'] ?>" name="nombreJefe" id="nombreJefe" readonly required>
                                <input class="form-control" hidden value="<?= encryptDecrypt('encrypt', $empleado['emp_EmpleadoID']) ?>" name="Jefe" id="Jefe" readonly required>
                            </div>
                            <div class="col-6">
                                <label class="control-label"> Puesto:</label>
                                <div class="">
                                    <input class="form-control " name="puestoJefe" id="puestoJefe" value="<?= $empleado['pue_Nombre'] ?>" readonly required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr style="width:100%;text-align:left;margin-left:0">
                    <div class="card-box text-center" style="border-radius: 15px">
                        <h4 class="text-uppercase font-weight-bold" style="color: #00acc1 !important;">Datos Del Puesto Vacante</h4>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12">
                                <label class="control-label"> * Motivo de la requisición:</label>
                                <select id="puesto" name="puesto" class="select2" required>
                                    <option hidden>Seleccione</option>
                                    <option value="Nuevo">Nueva creación *</option>
                                    <option value="Sustitucion">Sustitución</option>
                                    <option value="Incremento">Incremento de plantilla</option>
                                </select>

                                <footer class="text-muted" style="font-size: 10px;">* En caso de puestos de Nueva Creación, favor de anexar Perfil de Puesto.</footer>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" id="divSustituyeA">
                        <hr style="width:100%;text-align:left;margin-left:0">
                        <div class="row">
                            <div class="col-4">
                                <label class="control-label">* Sustituye a:</label>
                                <input class="form-control " name="sustituyeEmpleado" id="sustituyeEmpleado">
                            </div>
                            <div class="col-4">
                                <label class="control-label">* Motivo de salida:</label>
                                <input class="form-control " name="motivoSalida" id="motivoSalida">
                            </div>
                            <div class="col-4">
                                <label class="control-label">* Fecha de salida:</label>
                                <input class="form-control datepicker" name="fechaSalida" id="fechaSalida">
                            </div>
                        </div>
                    </div>
                    <hr style="width:100%;text-align:left;margin-left:0">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-7 mb-3">
                                <label class="control-label"> * Nombre del puesto:</label>
                                <select class="select2" name="nombrePuesto" id="nombrePuesto" required>
                                    <option hidden>Seleccione</option>
                                    <?php foreach ($puestos as  $puesto) { ?>
                                        <option value="<?= encryptDecrypt('encrypt', $puesto['pue_PuestoID']) ?>"><?= $puesto['pue_Nombre'] ?></option>
                                    <?php } ?>
                                    <option value="Nuevo Puesto">Nuevo Puesto</option>
                                </select>
                            </div>
                            <div class="col-5" id="divNuevoPuesto">
                                <label class="control-label"> * Nuevo puesto:</label>
                                <input class="form-control " name="nombreNPuesto" id="nombreNPuesto">
                            </div>
                            <div class="col-6 mb-3">
                                <label class="control-label"> * Departamento:</label>
                                <select class="select2" name="departamentoVac" id="departamentoVac" required>
                                    <option hidden>Seleccione</option>
                                    <?php foreach ($departamentos as $departamento) { ?>
                                        <option value="<?= encryptDecrypt('encrypt', $departamento['dep_DepartamentoID']) ?>"><?= $departamento['dep_Nombre'] ?></option>
                                    <?php } ?>
                                    <option value="Nuevo departamento">Nuevo Departamento</option>
                                </select>
                            </div>
                            <div class="col-6 mb-3" id="divNuevoDepartamento">
                                <label class="control-label"> * Nuevo departamento:</label>
                                <input class="form-control " name="nombreNDepartamento" id="nombreNDepartamento">
                            </div>
                            <div class="col-6">
                                <label class="control-label"> * Área:</label>
                                <select class="select2" name="areaVac" id="areaVac" required>
                                    <option hidden>Seleccione</option>
                                    <?php foreach ($areas as $area) { ?>
                                        <option value="<?= encryptDecrypt('encrypt', $area['are_AreaID']) ?>"><?= $area['are_Nombre'] ?></option>
                                    <?php } ?>
                                    <option value="Nueva area">Nueva Área</option>
                                </select>
                            </div>
                            <div class="col-5" id="divNuevaArea">
                                <label class="control-label"> * Nueva área:</label>
                                <input class="form-control " name="nombreNArea" id="nombreNArea">
                            </div>
                            <div class="col-12 mb-3">
                                <label class="control-label"> * Personal a su cargo:</label>
                                <select id="personalCargo" name="personalCargo" class="select2">
                                    <option hidden>Seleccione</option>
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                            <div class="col-12" id="divPuestoC">
                                <label class="control-label"> Puesto(s):</label>
                                <select class="select2" multiple="multiple" name="puestosCoordina[]" id="puestosCoordina">
                                    <?php foreach ($puestos as  $puesto) { ?>
                                        <option value="<?= $puesto['pue_PuestoID'] ?>"><?= $puesto['pue_Nombre'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr style="width:100%;text-align:left;margin-left:0">
                    <div class="card-box text-center" style="border-radius: 15px">
                        <h4 class="text-uppercase font-weight-bold" style="color: #00acc1 !important;">Requisitos del puesto</h4>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-4">
                                <label class="control-label"> * Escolaridad:</label>
                                <select class="select2" name="escolaridad" id="escolaridad" required>
                                    <option hidden>Seleccione</option>
                                    <option value="Secundaria">Secundaria</option>
                                    <option value="Preparatoria">Preparatoria</option>
                                    <option value="Secretariado">Secretariado</option>
                                    <option value="Secretariado EspIng">Secretariado (Español-Ingles)</option>
                                    <option value="Carrera Tecnica">Carrera técnica</option>
                                    <option value="Carrera Comercial">Carrera Comercial</option>
                                    <option value="Profesional">Profesional</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                            <div class="col-4" id="divCarrera">
                                <label> * Carrera</label>
                                <input class="form-control" id="carrera" name="carrera">
                            </div>
                            <div class="col-4" id="divEspecificar">
                                <label> * Especificar</label>
                                <input class="form-control" id="especificar" name="especificar">
                            </div>
                            <div class="col-4" id="divPostGrado">
                                <label> Post-grado</label>
                                <input class="form-control" id="postGrado" name="postGrado">
                            </div>
                            <div class="col-4" id="divOtroEsp">
                                <label> * Especificar</label>
                                <input class="form-control" id="otroEspecificar" name="otroEspecificar">
                            </div>
                        </div>
                    </div>
                    <hr style="width:100%;text-align:left;margin-left:0">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-4 mb-3">
                                <label class="control-label"> * Experiencia:</label>
                                <select class="select2" name="experiencia" id="experiencia" required>
                                    <option hidden>Seleccione</option>
                                    <option value="Sin Experiencia">Sin Experiencia</option>
                                    <option value="Con Experiencia">Con Experiencia</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" id="divExp">
                        <div class="row">
                            <div class="col-4">
                                <label class="control-label"> * Años:</label>
                                <input type="number" min="0" class="form-control " name="yearsExp" id="yearsExp">
                            </div>
                            <div class="col-6">
                                <label class="control-label"> * Área:</label>
                                <input class="form-control " name="areaExp" id="areaExp">
                            </div>
                        </div>
                    </div>
                    <hr style="width:100%;text-align:left;margin-left:0">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12">
                                <label class="control-label"> * Especificación de Perfil/Puesto:</label>
                                <textarea id="perfilP" name="perfilP" class="form-control" required></textarea>
                            </div>
                        </div>
                    </div>
                    <hr style="width:100%;text-align:left;margin-left:0">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-4">
                                <label class="control-label"> * Edad:</label>
                                <input type="number" min="1" id="edad" name="edad" class="form-control" required>
                            </div>
                            <div class="col-4">
                                <label class="control-label"> * Sexo:</label>
                                <select id="sexo" name="sexo" class="select2" required>
                                    <option hidden>Seleccione</option>
                                    <option value="Hombre">Hombre</option>
                                    <option value="Mujer">Mujer</option>
                                    <option value="Indistinto">Indistinto</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <label class="control-label"> * Estado civil:</label>
                                <select id="ecivil" name="ecivil" class="select2" required>
                                    <option hidden>Seleccione</option>
                                    <option value="Soltero">Soltero</option>
                                    <option value="Casado">Casado</option>
                                    <option value="Indistinto">Indistinto</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <hr style="width:100%;text-align:left;margin-left:0">
                    <div class="card-box text-center" style="border-radius: 15px">
                        <h4 class="text-uppercase font-weight-bold" style="color: #00acc1 !important;">Especificación de la contratación</h4>
                    </div>
                    <div class="col-12">
                        <div class="row">
                            <div class="col-4">
                                <label class="control-label"> * Contrato por tiempo:</label>
                                <select id="contratoTiempo" name="contratoTiempo" class="select2" required>
                                    <option hidden>Seleccione</option>
                                    <option value="Determinado">Determinado</option>
                                    <option value="Indeterminado">Indeterminado</option>
                                </select>
                            </div>
                            <div class="col-4" id="divTiempoC">
                                <label class="control-label"> * Tiempo:</label>
                                <input id="tiempoDeterminado" name="tiempoDeterminado" class="form-control">
                            </div>
                        </div>
                    </div>
                    <hr style="width:100%;text-align:left;margin-left:0">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <label class="control-label"> * Fecha de ingreso/inicio:</label>
                                <input id="fIngreso" name="fIngreso" class="form-control datepicker" placeholder="La fecha de ingreso debe de ser minimo 20 dias posterior al registro de solicitud" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label class="control-label"> * Sueldo contratación:</label>
                                <input type="number" min="1" id="sueldoContratacion" name="sueldoContratacion" class="form-control" required>
                            </div>
                            <div class="col-6">
                                <label class="control-label"> * Sueldo planta:</label>
                                <input type="number" min="1" id="sueldoPlanta" name="sueldoPlanta" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <hr style="width:100%;text-align:left;margin-left:0">
                    <div class="text-right" style="padding-top: 2%">
                        <button id="guardar" type="submit" class="btn btn-success btn-round guardar">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: 'Seleccione una opción',
            allowClear: true,
            width: 'resolve'
        });
    });
</script>