<?php defined("FCPATH") or die("No direct script access allowed.");
$tipoContrato = (is_array($perfilpuesto) && array_key_exists('per_TipoContrato', $perfilpuesto)) ? $perfilpuesto['per_TipoContrato'] : null;
$genero = (is_array($perfilpuesto) && array_key_exists('per_Genero', $perfilpuesto)) ? $perfilpuesto['per_Genero'] : null;
$estadoCivil = (is_array($perfilpuesto) && array_key_exists('per_EstadoCivil', $perfilpuesto)) ? $perfilpuesto['per_EstadoCivil'] : null;
$horario = (is_array($perfilpuesto) && array_key_exists('per_Horario', $perfilpuesto)) ? $perfilpuesto['per_Horario'] : null;

?>
<div class="row">
    <div class="col-md-12">
        <div class="card-box">
            <form action="<?= base_url('Catalogos/updatePerfilPuesto'); ?>" method="post" autocomplete="off">
                <h3><?= $nombrePuesto ?></h3>
                <input id="PuestoID" name="PuestoID" hidden value="<?= $PuestoID ?>">
                <div class="form-group text-center" style="margin-bottom: 0px;">
                    <h4>Datos Generales</h4>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="selectDepartamento" class="col-form-label">*Departamento</label>
                        <select id="selectDepartamento" name="selectDepartamento" class="form-control select2" data-placeholder="Seleccione" required>
                            <option value="" hidden>Seleccione</option>
                            <?php
                            foreach ($departamentos as $departamento) {
                                $sel = "";
                                if (isset($puestosDep)) {
                                    if ($puestosDep === $departamento['dep_DepartamentoID']) $sel = 'selected';
                                }
                                echo " <option $sel value='{$departamento['dep_DepartamentoID']}'>{$departamento['dep_Nombre']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="selectReporta" class="col-form-label">Puesto al que reporta</label>
                        <select id="selectReporta" name="selectReporta[]" class="select2 form-control select2-multiple" multiple="multiple" multiple data-placeholder="Seleccione">
                            <?php
                            $se = "";
                            if (isset($puestosR)) {
                                foreach ($puestosR as $item) {
                                    if ($item === "0") {
                                        $se = "selected";
                                    }
                                }
                            }
                            echo ' <option value="0" ' . $se . '>Ninguno</option>';
                            foreach ($puestos as $puesto) {
                                $sel = "";
                                if (isset($puestosR)) {
                                    foreach ($puestosR as $item) {
                                        if ($item === $puesto['pue_PuestoID']) $sel = 'selected';
                                    }
                                }
                                echo " <option $sel value='{$puesto['pue_PuestoID']}'>{$puesto['pue_Nombre']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="selectCoordina" class="col-form-label">Puesto al que coordina</label>
                        <select id="selectCoordina" name="selectCoordina[]" class="select2 form-control select2-multiple" multiple="multiple" multiple data-placeholder="Seleccione">
                            <?php

                            $se = "";
                            if (isset($puestosC)) {
                                foreach ($puestosC as $item) {
                                    if ($item === "0") {
                                        $se = "selected";
                                    }
                                }
                            }
                            echo ' <option value="0" ' . $se . '>Ninguno</option>';
                            foreach ($puestos as $puesto) {
                                $sel = "";
                                if (isset($puestosC)) {
                                    foreach ($puestosC as $item) {
                                        if ($item === $puesto['pue_PuestoID']) $sel = 'selected';
                                    }
                                }
                                echo " <option $sel value='{$puesto['pue_PuestoID']}'>{$puesto['pue_Nombre']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="selectContrato" class="col-form-label">*Contrato</label>
                        <select name="selectContrato" id="selectContrato" class="form-control select2" data-placeholder="Seleccione Contrato" required>
                            <option value="" hidden>Seleccione</option>
                            <option <?php if ($tipoContrato == 'MEDIO') echo 'selected' ?> value="MEDIO">Medio</option>
                            <option <?php if ($tipoContrato == 'COMPLETO') echo 'selected' ?> value="COMPLETO">Completo</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="selectGenero" class="col-form-label ">*Género</label>
                        <select name="selectGenero" id="selectGenero" class="form-control select2" data-placeholder="Seleccione Genero" required>
                            <option value="" hidden>Seleccione</option>
                            <option <?php if ($genero === 'FEMENINO') echo 'selected' ?> value="FEMENINO">Femenino</option>
                            <option <?php if ($genero === 'MASCULINO') echo 'selected' ?> value="MASCULINO">Masculino</option>
                            <option <?php if ($genero === 'INDISTINTO') echo 'selected' ?> value="INDISTINTO">Indistinto</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="selectEC" class="col-form-label">*Estado civil</label>
                        <select id="selectEC" name="selectEC" class="form-control select2" data-placeholder="Seleccione Estado civil" required>
                            <option value="" hidden>Seleccione</option>
                            <option <?php if ($estadoCivil == 'SOLTERO') echo 'selected' ?> value="SOLTERO">Soltero</option>
                            <option <?php if ($estadoCivil == 'CASADO') echo 'selected' ?> value="CASADO">Casado</option>
                            <option <?php if ($estadoCivil == 'INDISTINTO') echo 'selected' ?> value="INDISTINTO">Indistinto</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="selectHorario" class="col-form-label">*Horario</label>
                        <select name="selectHorario" id="selectHorario" class="form-control select2" data-placeholder="Seleccione Horario" required>
                            <option value="" hidden>Seleccione</option>
                            <option <?php if ($horario == 'DIURNO') echo 'selected' ?> value="DIURNO">Diurno</option>
                            <option <?php if ($horario == 'NOCTURNO') echo 'selected' ?> value="NOCTURNO">Nocturno</option>
                            <option <?php if ($horario == 'MIXTO') echo 'selected' ?> value="MIXTO">Mixto</option>
                            <option <?php if ($horario == 'HORAS') echo 'selected' ?> value="HORAS">Horas</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputEscolaridad" class="col-form-label">*Escolaridad</label>
                        <textarea class="form-control" id="inputEscolaridad" name="inputEscolaridad" placeholder="Carrera, escolaridad" required><?= (isset($perfilpuesto['per_Escolaridad'])) ? $perfilpuesto['per_Escolaridad'] : '' ?></textarea>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputAnosEx" class="col-form-label">*Años de experiencia</label>
                        <input type="number" min="0" max="50" class="form-control re" id="inputAnosEx" name="inputAnosEx" placeholder="Años" required value="<?= (isset($perfilpuesto['per_AnosExperiencia'])) ? $perfilpuesto['per_AnosExperiencia'] : '' ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputEdad" class="col-form-label">*Edad</label>
                        <input type="text" class="form-control" id="inputEdad" name="inputEdad" placeholder="Edad" value="<?= (isset($perfilpuesto['per_Edad'])) ? $perfilpuesto['per_Edad'] : '' ?>" required>
                    </div>
                    <div class="row col-md-12">
                        <div class="form-group col-md-12   ">
                            <h4 for="inputConocimiento">Conocimientos</h4>
                            <textarea class="form-control" cols="50" rows="10" id="inputConocimiento" name="inputConocimiento" placeholder="Escribir los conocimientos" required><?= (isset($perfilpuesto['per_Conocimientos'])) ? $perfilpuesto['per_Conocimientos'] : '' ?></textarea>

                        </div>
                    </div>
                    <div class="row col-md-12">
                        <div class="form-group col-md-12  text-center">
                            <h4 for="inputObjetivo">Objetivo del puesto</h4>
                        </div>
                    </div>

                    <div class="row col-md-12">
                        <div class="form-group col-md-12">
                            <textarea class="form-control" id="inputObjetivo" name="inputObjetivo" placeholder="Escribir objetivo" required><?= (isset($perfilpuesto['per_Objetivo'])) ? $perfilpuesto['per_Objetivo'] : '' ?></textarea>
                        </div>
                    </div>
                    <hr width="100%" style="margin-top: 0px;">
                    <div class="row col-md-12">
                        <div class="form-group col-md-12 text-center">
                            <h4 style="padding-bottom: 0px;">Funciones de puesto</h4>
                        </div>
                    </div>
                    <div class="row col-md-12">
                        <div class="form-group col-md-11">
                            <textarea class="form-control" name="Funciones[]" placeholder="Escribir función" required><?= $puestosF['F1'] ?? '' ?></textarea>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <div id="funciones" class="form-group col-md-11" name="contador">
                            <?php
                            $contador = 0;
                            if (!empty($puestosF)) {
                                $contador = 1;
                                $numFunciones = count($puestosF);
                                if (isset($puestosF)) {
                                    if (count($puestosF) > 0) {
                                        for ($i = 2; $i < $numFunciones + 1; $i++) {
                                            $contador++;
                            ?>
                                            <div class="row" id="divF<?= $contador ?>">
                                                <div class="form-group col-md-11">
                                                    <textarea class="form-control" name="Funciones[]" placeholder="Escribir función" required><?= $puestosF['F' . $i] ?></textarea>
                                                </div>
                                                <div class="form-group col-md-1 text-center pt-3">
                                                    <button class="btn btn-danger  btnEliminar text-center" data-id="<?= $contador ?>"><i class="dripicons-trash"></i></button>
                                                </div>
                                            </div>
                            <?php }
                                    }
                                }
                            }
                            ?>
                        </div>
                    </div>
                    <script>
                        var contador = <?= $contador ?>
                    </script>
                    <div class="form-group col-md-12 text-center">
                        <button id="agregarFuncion" type="button" class="btn btn-success waves-effect waves-light">Agregar</button>
                    </div>
                    <hr width="100%">
                    <div class="row">
                        <div class="form-group col-md-12 ">
                            <button id="guardar" type="submit" class="btn btn-primary waves-effect waves-light text-right">Guardar</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>
<div class="row col-md-12">
    <div class="col-md-12">
        <div class="card-box">
            <div class="form-group text-center" style="margin-bottom: 0px;">
                <h4>Competencias</h4>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>*Competencias</label>
                        <select id="selectCompetencias" class="select2 form-control" data-placeholder="Seleccionar competencia" style="width: 100%">
                            <?php
                            if (isset($competencias)) {
                                if (count($competencias)) {
                                    echo '<option value=""></option>';
                                    foreach ($competencias as $c) {
                                        echo '<option value="' . $c['com_CompetenciaID'] . '">' . trim($c['com_Nombre']) . '</option>';
                                    } //foreach
                                } else {
                                    echo '<option value="0" disabled>No hay competencias disponibles</option>';
                                } //if count
                            } else {
                                echo '<option value="0" disabled>No hay competencias disponibles</option>';
                            } //if isset
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <label>*Nivel</label>
                    <select id="selectNivel" class="select2 form-control" data-placeholder="Seleccionar nivel" style="width: 100%">
                        <option value=""></option>
                        <option value="1">Bajo</option>
                        <option value="2">Minimo</option>
                        <option value="3">Medio</option>
                        <option value="4">Alto</option>
                        <option value="5">Experto</option>
                    </select>
                </div>
                <div class="col-md-3 text-center">
                    <label>&nbsp;</label><br>
                    <button id="btnAsignar" class="btn btn-primary width-md waves-effect waves-light">
                        Asignar
                    </button>
                </div>
            </div>
            <hr>
            <div class="row p-2">
                <div class="col-md-8 pt-1"></div>
                <div class="col-md-4 pt-1">
                    <div class="form-group">
                        <input id="tblCom-search" type="text" placeholder="Buscar" class="form-control" autocomplete="on">
                    </div>
                </div>
            </div>
            <div class="row pb-2 pl-2 pr-2 pt-0">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table id="tblCompetencias" class="table table-striped table-bordered toggle-circle mb-0" data-page-size="7">
                            <thead>
                                <tr>
                                    <th data-toggle="true">Competencia</th>
                                    <th>Nivel</th>
                                    <th>Tipo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody id="rowsCompetencias">
                                <!--js-->
                            </tbody>
                            <tfoot>
                                <tr class="active">
                                    <td colspan="4">
                                        <div class="text-right">
                                            <ul class="pagination pagination-split justify-content-end footable-pagination"></ul>
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>