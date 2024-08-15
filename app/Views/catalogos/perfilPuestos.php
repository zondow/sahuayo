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
                <h3></h3>
                <input id="PuestoID" name="PuestoID" hidden value="<?= $PuestoID ?>">
            </form>
        </div>
    </div>
</div>


       <!-- Example Tab -->
       <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="header">
                    <h2><strong><?= strtoupper($nombrePuesto)?></strong></h2>
                    
                </div>
                <div class="body"> 
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs">
                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#generales">GENERALES</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#objetivo">OBJETIVO</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#funciones">FUNCIONES</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#competencias">COMPETENCIAS</a></li>
                    </ul>                        
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane in active" id="generales"> 
                    
                            <div class="col-md-12 ">
                                <div class="row clearfix">
                                    <div class=" col-md-4">
                             
                                   
                                        <label for="selectDepartamento" class="col-form-label">*Departamento</label>
                                        <select id="selectDepartamento" name="selectDepartamento" class="chosen-select"  required style="width: 100%;">
                                            <option value="" hidden>Seleccione</option>
                                            <?php
                                            foreach ($departamentos as $departamento) {
                                                $sel = "";
                                                if (isset($puestosDep) && $puestosDep === $departamento['dep_DepartamentoID']) {
                                                    $sel = 'selected';
                                                }
                                                echo "<option $sel value='{$departamento['dep_DepartamentoID']}'>{$departamento['dep_Nombre']}</option>";
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
                                        <input type="text" class="form-control" id="inputEscolaridad" name="inputEscolaridad" placeholder="Carrera, escolaridad" value="<?= (isset($perfilpuesto['per_Escolaridad'])) ? $perfilpuesto['per_Escolaridad'] : '' ?>" required>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="inputAnosEx" class="col-form-label">*Años de experiencia</label>
                                        <input type="number" min="0" max="50" class="form-control re" id="inputAnosEx" name="inputAnosEx" placeholder="Años" required value="<?= (isset($perfilpuesto['per_AnosExperiencia'])) ? $perfilpuesto['per_AnosExperiencia'] : '' ?>">
                                    </div>
                                </div>
                                <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="inputEdad" class="col-form-label">*Edad</label>
                                    <input type="text" class="form-control" id="inputEdad" name="inputEdad" placeholder="Edad" value="<?= (isset($perfilpuesto['per_Edad'])) ? $perfilpuesto['per_Edad'] : '' ?>" required>
                                </div>
                                <div class="form-group col-md-8 ">
                                    <label for="inputConocimiento" class="col-form-label">* Conocimientos</label>
                                    <textarea class="form-control" rows="10" id="inputConocimiento" name="inputConocimiento" placeholder="Escribir los conocimientos" required><?= (isset($perfilpuesto['per_Conocimientos'])) ? $perfilpuesto['per_Conocimientos'] : '' ?></textarea>

                                </div>
                            </div>
                        </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="objetivo"> 
                            <div class="row col-md-12">
                                <div class="form-group col-md-12">
                                    <label for="inputObjetivo" class="col-form-label">* Objetivo del puesto</label>
                                    <textarea class="form-control" id="inputObjetivo" name="inputObjetivo" placeholder="Escribir objetivo" required><?= (isset($perfilpuesto['per_Objetivo'])) ? $perfilpuesto['per_Objetivo'] : '' ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="funciones"> 
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <button id="agregarFuncion" class="btn btn-success btn-icon  btn-icon-mini btn-round">
                                        <i class="zmdi zmdi-plus-circle-o"></i>
                                    </button>
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
                                                        <div class="form-group col-md-1  pt-3">
                                                            <button class=" btn btn-danger btn-icon  btn-icon-mini btn-roun btnEliminar " data-id="<?= $contador ?>"><i class="zmdi zmdi-minus-circle-outline"></i></button>
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
                        </div>
                        <div role="tabpanel" class="tab-pane" id="competencias"> 
                           
                                <div class="row col-md-12">
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
                                    <div class="col-md-5">
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
                                    <div class="col-md-1 text-center">
                                        <br>
                                        <button id="btnAsignar" class="btn btn-primary btn-icon  btn-icon-mini btn-round ">
                                            <i class="zmdi zmdi zmdi-check"></i>
                                        </button>
                                    </div>
                                </div>
                            
                            
                                <div class="col-md-8 pt-1"></div>
                                <div class="col-md-4 pt-1">
                                    <div class="form-group">
                                        <input id="tblCom-search" type="text" placeholder="Buscar" class="form-control" autocomplete="on">
                                    </div>
                                </div>
                                
                            
                        
                       
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12 text-right">
                                <button id="guardar" type="submit" class="btn btn-primary waves-effect waves-light text-right">Guardar</button>
                            </div>
                        </div>
                </div>
            </div>
        </div>
      
