<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div id="modalColaborador" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="tituloModal">Colaborador</h4>
            </div>
            <form id="formColaborador" method="post" autocomplete="off">
                    <input id="emp_EmpleadoID" name="emp_EmpleadoID" value="0" hidden>
                    <div class="modal-body">
                        <ul class="nav nav-tabs row">
                            <li class="nav-item col-md-3">
                                <a href="#personales" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                    <i class="far fa-address-card "></i><span class="d-none d-sm-inline-block ml-2"> PERSONALES</span>
                                </a>
                            </li>
                            <li class="nav-item col-md-3">
                                <a href="#estudios" data-toggle="tab" aria-expanded="true" class="nav-link ">
                                    <i class="fas fa-book-reader"></i> <span class="d-none d-sm-inline-block ml-2"> ESCOLARES</span>
                                </a>
                            </li>
                            <li class="nav-item col-md-3">
                                <a href="#institucionales" data-toggle="tab" aria-expanded="false" class="nav-link">
                                    <i class="fas fa-building"></i> <span class="d-none d-sm-inline-block ml-2"> INSTITUCIONALES</span>
                                </a>
                            </li>
                            <li class="nav-item col-md-3">
                                <a href="#emergencias" data-toggle="tab" aria-expanded="false" class="nav-link">
                                    <i class=" 	fa fa-plus-square"></i> <span class="d-none d-sm-inline-block ml-2"> EMERGENCIA</span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane show active" id="personales">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="col-form-label">* Nombre</label>
                                            <input type="text" class="form-control" id="emp_Nombre" name="emp_Nombre" placeholder="Escriba el nombre completo" >
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="col-form-label">* Dirección</label>
                                            <input type="text" class="form-control" id="emp_Direccion" name="emp_Direccion" required placeholder="Calle,Numero y Colonia">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="col-form-label"> Código postal </label>
                                            <input type="text" class="form-control" id="emp_CodigoPostal" name="emp_CodigoPostal" placeholder="Escriba el código postal">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="col-form-label"> Estado</label>
                                            <select name="emp_EstadoID" id="emp_EstadoID" class="form-control select2"  style="width: 100% !important;">
                                                <option value="" hidden>Seleccione</option>
                                                <?php foreach ($estados as $estado){ ?>
                                                <option value="<?=$estado['id_estado']?>"><?=strtoupper($estado['est_nombre'])?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="col-form-label"> Ciudad</label>
                                            <select name="emp_CiudadID" id="emp_CiudadID"  class="form-control select2"  style="width: 100% !important;">
                                                <option value="" hidden>Seleccione</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="col-form-label"> País </label>
                                            <input type="text" class="form-control" id="emp_Pais" name="emp_Pais" placeholder="Escriba el país">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="col-form-label"> * Fecha de nacimiento</label>
                                            <input type="text" class="form-control datepicker" id="emp_FechaNacimiento" name="emp_FechaNacimiento" required placeholder="Seleccione la fecha de nacimiento">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="col-form-label"> Teléfono</label>
                                            <input type="text" class="form-control"  id="emp_Telefono" name="emp_Telefono" placeholder="Escriba el teléfono">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="col-form-label"> Celular</label>
                                            <input type="text" class="form-control" id="emp_Celular" name="emp_Celular" placeholder="Escriba el número de celular">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="col-form-label">* CURP</label>
                                            <input type="text" class="form-control"  id="emp_Curp" required name="emp_Curp"  placeholder="Escriba el CURP">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="col-form-label">* RFC</label>
                                            <input type="text" class="form-control"  id="emp_Rfc" required minlength="11" maxlength="13" name="emp_Rfc"  placeholder="Escriba el RFC">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="col-form-label">* NSS</label>
                                            <input type="text" class="form-control onlyNumbers"  id="emp_Nss" name="emp_Nss"  placeholder="Escriba el NSS">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="col-form-label"> * Sexo </label>
                                            <select class="form-control select2" id="emp_Sexo" name="emp_Sexo" required data-placeholder="Seleccione" style="width: 100%" >
                                                <option value="" hidden>  Seleccione </option>
                                                <option value="Masculino" >Masculino</option>
                                                <option value="Femenino">Femenino</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label class="col-form-label">* Estado civil</label>
                                            <select id="emp_EstadoCivil" name="emp_EstadoCivil" class="select2 form-control" data-placeholder="Seleccionar" style="width: 100%" required>
                                                <option value="SOLTERO (A)"> SOLTERO (A)</option>
                                                <option value="CASADO (A)"> CASADO (A)</option>
                                                <option value="DIVORCIADO (A)"> DIVORCIADO (A)</option>
                                                <option value="UNION LIBRE"> UNION LIBRE</option>
                                                <option value="OTRO"> OTRO</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="col-form-label"> Fecha de matrimonio</label>
                                            <input type="text" class="form-control datepicker" id="emp_FechaMatrimonio" name="emp_FechaMatrimonio"  placeholder="Seleccione la fecha ">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="col-form-label"> Tipo sanguineo</label>
                                            <select class="form-control select2"  id="emp_TipoSangre" name="emp_TipoSangre" >
                                                <option hidden>Seleccione</option>
                                                <option value="A+">A positivo (A +)</option>
                                                <option value="A-">A negativo (A-)</option>
                                                <option value="B+">B positivo (B +)</option>
                                                <option value="B-">B negativo (B-)</option>
                                                <option value="AB+">AB positivo (AB+)</option>
                                                <option value="AB-">AB negativo (AB-)</option>
                                                <option value="O+">O positivo (O+)</option>
                                                <option value="O-">O negativo (O-)</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="col-form-label"> Hijos</label>
                                            <select class="form-control select2"  id="emp_Hijos" name="emp_Hijos" >
                                                <option hidden>Seleccione</option>
                                                <option value="SI">SI</option>
                                                <option value="NO">NO</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="col-form-label"> No. de hijos</label>
                                            <input type="number" class="form-control onlyNumbers"  id="emp_NoHijos" name="emp_NoHijos"  value="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane " id="estudios">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label class="col-form-label">  Nivel de estudio </label>
                                            <select id="emp_Estudios" name="emp_Estudios" class="select2 form-control" data-placeholder="Seleccionar" style="width: 100%" >
                                                <option value="SIN ESTUDIOS"> SIN ESTUDIOS</option>
                                                <option value="PRIMARIA"> PRIMARIA</option>
                                                <option value="SECUNDARIA"> SECUNDARIA</option>
                                                <option value="PREPARATORIA"> PREPARATORIA</option>
                                                <option value="TECNICO"> TECNICO</option>
                                                <option value="PASANTE"> PASANTE</option>
                                                <option value="LICENCIATURA"> LICENCIATURA</option>
                                                <option value="INGENIERIA"> INGENIERIA</option>
                                                <option value="MAESTRIA"> MAESTRIA</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="">
                                        <?php for($i=1;$i<=3;$i++){ ?>
                                            <?php if($i<=1){
                                                $n ='';$titulo=1;$col=3;$label='Estudios';$idname='emp_Carrera';
                                            }else{
                                                $n=$i;$titulo=0;$col=4;$label='Otros Estudios';$idname='emp_Estudios';
                                            }?>
                                            <hr><label><?=$label?></label>
                                            <div class="row">
                                            <div class="form-group col-md-<?=$col?>">
                                                <label class="col-form-label"> Carrera </label>
                                                <input id="<?=$idname?><?=$n?>" name="<?=$idname?><?=$n?>" class="form-control" placeholder="Escriba la carrera" >
                                            </div>
                                            <?php if($titulo>0){ ?>
                                            <div class="form-group col-md-<?=$col?>">
                                                <label class="col-form-label">  Título </label>
                                                <select id="emp_Titulo" name="emp_Titulo" class="form-control select2" data-placeholder="Seleccionar" style="width: 100%" >
                                                    <option hidden>Seleccione</option>
                                                    <option value="SI"> SI</option>
                                                    <option value="NO"> NO</option>
                                                </select>
                                            </div>
                                            <?php } ?>
                                            <div class="form-group col-md-<?=$col?>">
                                                <label class="col-form-label"> Institución </label>
                                                <input id="emp_Institucion<?=$n?>" name="emp_Institucion<?=$n?>" class="form-control" placeholder="Escriba la carrera" >
                                            </div>
                                            <div class="form-group col-md-<?=$col?>">
                                                <label class="col-form-label"> Cédula </label>
                                                <input id="emp_Cedula<?=$n?>" name="emp_Cedula<?=$n?>" class="form-control" placeholder="Escriba la cédula"  >
                                            </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="institucionales">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="form-group col-md-4">
                                            <label class="col-form-label">* Número interno</label>
                                            <input type="text" class="form-control onlyNumbers"  id="emp_Numero" name="emp_Numero" required placeholder="Escriba el número">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="col-form-label">* Fecha de ingreso</label>
                                            <input type="text" class="form-control datepicker" id="emp_FechaIngreso" name="emp_FechaIngreso" required placeholder="Seleccione fecha de ingreso">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="col-form-label">* Sucursal</label>
                                            <select id="selectSucursal" name="emp_SucursalID" class="select2 form-control" data-placeholder="Asignar sucursal" style="width: 100%" >
                                                <?php
                                                if(isset($sucursales)){
                                                    if(count($sucursales)){
                                                        echo '<option value=""></option>';
                                                        foreach ($sucursales as $sucursal){
                                                            echo '<option value="'.encryptDecrypt('encrypt',$sucursal['suc_SucursalID']).'">'.trim($sucursal['suc_Sucursal']).'</option>';
                                                        }//foreach
                                                    } else {
                                                        echo '<option value="0" disabled>No hay sucursales disponibles</option>';
                                                    }//if count
                                                } else {
                                                    echo '<option value="0" disabled>No hay sucursales disponibles</option>';
                                                }//if isset
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="col-form-label">* Area</label>
                                            <select  id="selectArea" name="emp_AreaID" class="select2 form-control" data-placeholder="Asignar area" style="width: 100%" required>
                                                <?php
                                                if(isset($areas)){
                                                    if(count($areas)){
                                                        echo '<option value=""></option>';
                                                        foreach ($areas as $area){
                                                            echo '<option value="'.encryptDecrypt('encrypt',$area['are_AreaID']).'">'.trim($area['are_Nombre']).'</option>';
                                                        }//foreach
                                                    } else {
                                                        echo '<option value="0" disabled>No hay areas disponibles</option>';
                                                    }//if count
                                                } else {
                                                    echo '<option value="0" disabled>No hay areas disponibles</option>';
                                                }//if isset
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="col-form-label">* Departamento</label>
                                            <select id="selectDepartamento" name="emp_DepartamentoID" class="select2 form-control" data-placeholder="Asignar departamento" style="width: 100%" >
                                                <?php
                                                if(isset($departamentos)){
                                                    if(count($departamentos)){
                                                        echo '<option value=""></option>';
                                                        foreach ($departamentos as $departamento){
                                                            echo '<option value="'.encryptDecrypt('encrypt',$departamento['dep_DepartamentoID']).'">'.trim($departamento['dep_Nombre']).'</option>';
                                                        }//foreach
                                                    } else {
                                                        echo '<option value="0" disabled>No hay departamentos disponibles</option>';
                                                    }//if count
                                                } else {
                                                    echo '<option value="0" disabled>No hay departamentos disponibles</option>';
                                                }//if isset
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="col-form-label">* Puesto</label>
                                            <select  id="selectPuesto" name="emp_PuestoID" class="select2 form-control" data-placeholder="Asignar puesto" style="width: 100%" required>
                                                <?php
                                                if(isset($puestos)){
                                                    if(count($puestos)){
                                                        echo '<option value=""></option>';
                                                        foreach ($puestos as $puesto){
                                                            echo '<option value="'.encryptDecrypt('encrypt',$puesto['pue_PuestoID']).'">'.trim($puesto['pue_Nombre']).'</option>';
                                                        }//foreach
                                                    } else {
                                                        echo '<option value="0" disabled>No hay puestos disponibles</option>';
                                                    }//if count
                                                } else {
                                                    echo '<option value="0" disabled>No hay puestos disponibles</option>';
                                                }//if isset
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="col-form-label">* Horario: </label>
                                            <select id="selhorario" name="emp_HorarioID" class="select2 form-control" data-placeholder="Seleccionar horario" style="width: 100%" >
                                                <?php
                                                if(isset($horarios)){
                                                    if(count($horarios)){
                                                        echo '<option value=""></option>';
                                                        foreach ($horarios as $horario){
                                                            echo '<option value="'.encryptDecrypt('encrypt',$horario['hor_HorarioID']).'">'.trim($horario['hor_Nombre']).'</option>';
                                                        }//foreach
                                                    } else {
                                                        echo '<option value="0" disabled>No hay horarios disponibles</option>';
                                                    }//if count
                                                } else {
                                                    echo '<option value="0" disabled>No hay horarios disponibles</option>';
                                                }//if isset
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="col-form-label">* Jefe</label>
                                            <select id="selectJefe" name="emp_Jefe" class="select2 form-control" data-placeholder="Asignar jefe" style="width: 100%" required>
                                                <?php
                                                if(isset($colaboradores)){
                                                    if(count($colaboradores)){
                                                        echo '<option value=""></option>';
                                                        foreach ($colaboradores as $colaborador){
                                                            echo '<option value="'.$colaborador['emp_Numero'].'">'.trim($colaborador['emp_Nombre']).'</option>';
                                                        }//foreach
                                                    } else {
                                                        echo '<option value="0" disabled>No hay colaboradores disponibles</option>';
                                                    }//if count
                                                } else {
                                                    echo '<option value="0" disabled>No hay colaboradores disponibles</option>';
                                                }//if isset
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="col-form-label">* Rol</label>
                                            <select id="selectRol" name="emp_Rol" class="select2 form-control" data-placeholder="Seleccionar rol" style="width: 100%" required>
                                                <option value="<?=encryptDecrypt('encrypt',0)?>">Colaborador</option>
                                                <?php
                                                if(isset($roles)){
                                                    if(count($roles)){
                                                        echo '<option value=""></option>';
                                                        foreach ($roles as $rol){
                                                            echo '<option value="'.encryptDecrypt('encrypt',$rol['rol_RolID']).'">'.trim($rol['rol_Nombre']).'</option>';
                                                        }//foreach
                                                    } else {
                                                        echo '<option value="0" disabled>No hay roles disponibles</option>';
                                                    }//if count
                                                } else {
                                                    echo '<option value="0" disabled>No hay roles disponibles</option>';
                                                }//if isset
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="col-form-label">* Salario diario </label>
                                            <input type="number" step="any" class="form-control" id="emp_SalarioDiario" name="emp_SalarioDiario" placeholder="Escriba la cantidad ">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="col-form-label">* Salario diario integrado </label>
                                            <input type="number" step="any" class="form-control" id="emp_SalarioDiarioIntegrado" name="emp_SalarioDiarioIntegrado" placeholder="Escriba la cantidad" >
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="col-form-label">* Salario mensual </label>
                                            <input type="number" step="any" class="form-control" id="emp_SalarioMensual" name="emp_SalarioMensual" placeholder="Escriba la cantidad ">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="col-form-label">* Salario mensual integrado </label>
                                            <input type="number" step="any" class="form-control" id="emp_SalarioMensualIntegrado" name="emp_SalarioMensualIntegrado" placeholder="Escriba la cantidad" >
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="col-form-label">* Estatus de contratación</label>
                                            <select id="emp_EstatusContratacion" name="emp_EstatusContratacion" class="select2 form-control" data-placeholder="Seleccionar" style="width: 100%" required>
                                                <option value="DETERMINADO"> DETERMINADO</option>
                                                <option value="INDETERMINADO"> INDETERMINADO</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="emergencias">
                                <div class="col-md-12">
                                    <div class="row">
                                    <?php for($i=1;$i<=2;$i++){
                                        if($i<=1){
                                            $n='';
                                        }else{
                                            $n=$i;
                                        }
                                        ?>
                                        <div class="form-group col-md-4">
                                            <label class="col-form-label"> Nombre del contacto de emergencia </label>
                                            <input type="text" class="form-control" id="emp_NombreEmergencia<?=$n?>" name="emp_NombreEmergencia<?=$n?>" placeholder="Escriba el nombre" >
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="col-form-label"> Parentesco </label>
                                            <input type="text" class="form-control" id="emp_Parentesco<?=$n?>" name="emp_Parentesco<?=$n?>" placeholder="Escriba el parentesco" >
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="col-form-label"> Número del contacto de emergencia </label>
                                            <input type="text" class="form-control" id="emp_NumeroEmergencia<?=$n?>" name="emp_NumeroEmergencia<?=$n?>" placeholder="Escriba el numero" >
                                        </div>
                                    <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer ">
                        <div class="col-md-12 text-right">
                            <button type="button" class="btn btn-dark btn-round" data-dismiss="modal">Cancelar</button>
                            <button  type="button"  class="btn btn-success btn-round bntGuardarEmpleado" >Guardar</button>
                        </div>
                    </div>
                </form>
        </div>
    </div>
</div>
<script>
$(document).ready(function (e) {
    $('.select2').select2({
        dropdownParent: $('#modalColaborador .modal-body'),
        placeholder: 'Seleccione una opción',
        allowClear: true,
        width: 'resolve'
    });
});
</script>