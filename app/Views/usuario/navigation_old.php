<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<?php
$numero = (int)session('numero');
$permisos = json_decode(session('permisos'), 1);

$configuracion = array('roles','diasInhabiles','prestaciones','horarios','configuracionExpediente','configuracionPermisos');
$catalogos = array('puestos','departamentos','areas','horarios','cooperativas');
$personal = array('empleados','organigrama');
$evaluaciones = array('periodoEvaluacion','resultadosClimaLaboral','resultadosCompetencias');
$formacion = array('competencias','proveedores','cursos','instructores','resultadosEvaluacionDesCom','planeacionCapacitacion','programaCapacitacion');

$evaluacion = array('periodoEvaluacion','empleadosDesempeno270','competencias','empleadosCompetencia','resultadosCompetencias','evaluacionDepartamentos',
    'departamentosEmpresa','resultadosDepartamento','resultadosClimaLaboral','evaluacionSucursales','resultadosSucursal','resultadosDesempeno270','departamentosGlobal');
$reclutamiento = array('requisicionPersonal','seguimientoReqPer','carteraCandidatos');
//$materiales=array('categoriaMaterial','activoFijo');

$comunicados=array('comunicados','');

$incidencias=array('importarlistaAsistencia','reporteAsistencia');

?>
<!--- Sidemenu -->
<div id="sidebar-menu">
    <ul class="metismenu" id="side-menu">

        <li>
            <a href="<?= base_url("Usuario/index")?>">
                <i class="fe-home"></i>
                <span> Inicio</span>
            </a>
        </li>


        <?php
        ///////// CONFIGURACION /////////
        if (showMenu($configuracion,$permisos)) {
            echo '<li>
                <a href="javascript: void(0);">
                    <i class="dripicons-gear"></i>
                    <span> Configuración </span>
                    <span class="menu-arrow"></span>
                </a>';

            if (showMenu($configuracion,$permisos)) {
                echo '
                        <ul class="nav-second-level" aria-expanded="false">';
                             addMenuOption('Configuracion', 'roles',$permisos ,'Roles');
                             addMenuOption('Configuracion', 'diasInhabiles',$permisos ,'Días inhabiles');
                             addMenuOption('Configuracion', 'prestaciones',$permisos ,'Prestaciones');
                            ?> 
                            <li>
                                <a href="javascript: void(0);" aria-expanded="false">Horarios
                                    <span class="menu-arrow"></span>
                                </a>
                                    <ul class="nav-third-level nav" aria-expanded="false">
                                        <?php 
                                        addMenuOption('Configuracion', 'horarios',$permisos ,'Crear Horarios'); 
                                        addMenuOption('Configuracion', 'guardias',$permisos ,'Generar guardias'); 
                                        ?>
                                    </ul>
                            </li>
                            <?php 
                             addMenuOption('Configuracion', 'configuracionExpediente',$permisos ,'Expediente');
                             addMenuOption('Configuracion', 'configuracionPermisos',$permisos ,'Permisos');
                echo '  </ul>
              </li>';
            }
        }

        ///////// CATALOGOS /////////
        if (showMenu($catalogos,$permisos)) {
            echo '<li>
                <a href="javascript: void(0);">
                    <i class="fe-layers"></i>
                    <span> Catálogos </span>
                    <span class="menu-arrow"></span>
                </a>';

            if (showMenu($catalogos,$permisos)) {
                echo '
                        <ul class="nav-second-level" aria-expanded="false">';
                addMenuOption('Catalogos', 'departamentos',$permisos ,'Departamentos');
                addMenuOption('Catalogos', 'areas',$permisos ,'Areas');
                addMenuOption('Catalogos', 'puestos',$permisos ,'Puestos');
                addMenuOption('Catalogos','cooperativas',$permisos,'Cooperativas');
                echo '  </ul>
              </li>';
            }
        }
        ?>

    <li>
        <a href="javascript: void(0);">
            <i class="fas fa-exclamation"></i>
            <span> Incidencias </span>
            <span class="menu-arrow"></span>
        </a>
        <ul class="nav-second-level" aria-expanded="false">
           <?php if (showMenu($incidencias,$permisos)){ ?>
            <li>
                <a href="javascript: void(0);" aria-expanded="false">Asistencia
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-third-level nav" aria-expanded="false">
                    <?php 
                    addMenuOption('Incidencias', 'importarlistaAsistencia',$permisos ,'Importar');
                    addMenuOption('Incidencias', 'reporteAsistencia',$permisos ,'Reporte de asistencia');
                    ?>
                </ul>
            </li>
            <?php } ?>
            <li>
                <a href="javascript: void(0);" aria-expanded="false">Vacaciones
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-third-level nav" aria-expanded="false">
                    <li>
                        <a href="<?=base_url("Incidencias/misVacaciones")?>">Mis vacaciones</a>
                    </li>
                    <?php if (isJefe($this)) { ?>
                    <li>
                        <a href="<?=base_url("Incidencias/vacacionesMisEmpleados")?>">Autorizar vacaciones</a>
                    </li>
                    <?php }
                    addMenuOption('Incidencias', 'listVacaciones/aplicar',$permisos ,'Aplicar vacaciones');
                    ?>
                </ul>
            </li>
            <li>
                <a href="javascript: void(0);" aria-expanded="false">Permisos
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-third-level nav" aria-expanded="false">
                    <li><a href="<?= base_url("Incidencias/misPermisos")?>">Mis permisos</a></li>
                    <?php if(isJefe($this)){ ?>
                    <li><a href="<?= base_url("Incidencias/permisosMisEmpleados")?>">Autorizar permisos</a></li>
                    <?php }
                    addMenuOption('Incidencias', 'aplicarPermisos',$permisos ,'Aplicar permisos');
                    ?>
                </ul>
            </li>
            <li>
                <a href="javascript: void(0);" aria-expanded="false">Horas extra
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-third-level nav" aria-expanded="false">
                    <li><a href="<?= base_url("Incidencias/controlHorasExtra")?>">Control de mis horas extra</a></li>
                    <?php if(isJefe($this)){ ?>
                    <li><a href="<?= base_url("Incidencias/horasExtraMisEmpleados")?>">Autorizar reportes</a></li>
                    <?php } 
                    addMenuOption('Incidencias', 'aplicarReporteHoras',$permisos ,'Aplicar reportes');
                    ?>
                </ul>
            </li>
            <li>
                <a href="javascript: void(0);" aria-expanded="false">Salidas
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-third-level nav" aria-expanded="false">
                    <li><a href="<?= base_url("Incidencias/reporteSalidas")?>">Mis informes</a></li>
                    <?php if(isJefe($this)){ ?>
                    <li><a href="<?= base_url("Incidencias/informeSalidasMisEmpleados")?>">Autorizar informes</a></li>
                    <?php } 
                    addMenuOption('Incidencias', 'aplicarInformeSalidas',$permisos ,'Aplicar informes');
                    ?>
                </ul>
            </li>
            <li><a href="<?= base_url("Incidencias/incapacidad")?>">Incapacidad</a></li>
            <?php
            addMenuOption('Incidencias', 'sanciones',$permisos ,'Sanciones');
            ?>
            <li>
                <a href="javascript: void(0);" aria-expanded="false">Anticipos
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-third-level nav" aria-expanded="false">
                    <li><a href="<?=base_url("Incidencias/misAnticipos")?>">Mis anticipos</a></li>
                    <?php if(isJefe($this)){ ?>
                    <li><a href="<?= base_url("Incidencias/anticiposMisEmpleados")?>">Autorizar anticipos</a></li>
                    <?php }?>
                    <?php
                    $permisos = json_decode(session('permisos'), 1);
                    if(revisarPermisos('Aplicar anticipos (DTH)',$this,'anticipos'))
                        addMenuOption('Incidencias', 'anticiposEmpleados',$permisos ,'Aplicar anticipos',1);
                    if(revisarPermisos('Aprobar anticipos(Dirección general)',$this,'anticipos'))
                        addMenuOption('Incidencias', 'aprobarAnticiposEmpleados',$permisos ,'Aprobar anticipos',1);
                    ?>
                    <li><a href="<?=base_url("Incidencias/simuladorAnticipo")?>">Simulador</a></li>
                    <?php
                    if(revisarPermisos('Configuración simulador anticipos',$this,'anticipos'))
                        addMenuOption('Incidencias', 'configSimulador',$permisos ,'Configuración simulador',1); ?>
                </ul>
            </li>
        </ul>
    </li>
     <?php
     ///////// PERSONAL /////////
     if (showMenu($personal,$permisos)) {
        echo '<li>
                <a href="javascript: void(0);">
                    <i class="fa fa-users"></i>
                    <span> Personal </span>
                    <span class="menu-arrow"></span>
                </a>';

        if (showMenu($personal,$permisos)) {
            echo '
                <ul class="nav-second-level" aria-expanded="false">';
                    addMenuOption('Personal', 'empleados',$permisos ,'Empleados');
                    addMenuOption('Personal', 'organigrama',$permisos ,'Organigrama');
                echo '  </ul>
            </li>';
        }
        }
    ?>
       <!-- <li>
            <a href="javascript: void(0);">
                <i class="fas fa-file-download"></i>
                <span> Solicitudes de bajas </span>
                <span class="menu-arrow"></span>
            </a>
            <ul class="nav-second-level" aria-expanded="false">
                <li><a href="<?/*=base_url("Personal/misSolicitudesBajas")*/?>">Mis solicitudes</a></li>
            </ul>
        </li>-->


        <!----//// FORMACION /////----->

           <li>
           <a href="javascript: void(0);">
               <i class="fas fa-school"></i>
               <span> Formación </span>
               <span class="menu-arrow"></span>
           </a>
               <ul class="nav-second-level" aria-expanded="false">
           <?php if (showMenu($formacion,$permisos)) {
                echo '<li><a href="javascript: void(0);" aria-expanded="false">Catalogos<span class="menu-arrow"></span></a>';
                echo '<ul class="nav-third-level nav" aria-expanded="false">';
                        addMenuOption('CH', 'competencias',$permisos ,'Competencias');
                        addMenuOption('Formacion', 'proveedores',$permisos ,'Proveedores');
                        addMenuOption('Formacion', 'cursos',$permisos ,'Cursos');
                        addMenuOption('Formacion', 'instructores',$permisos ,'Instructores');
                    echo '</ul></li>';
                addMenuOption('Evaluaciones', 'resultadosEvaluacionDesCom',$permisos ,'Resultados evaluaciones');
                addMenuOption('Formacion', 'planeacionCapacitacion',$permisos ,'Plan de capacitación');
                addMenuOption('Formacion', 'programaCapacitacion',$permisos ,'Programa de capacitación');
           }

           if(isInstructor()){?>
               <li><a href="<?=base_url("Formacion/capacitacionesInstructor")?>">Capacitaciones</a></li>
           <?php } ?>
               <li><a href="<?=base_url("Formacion/misCapacitaciones")?>">Mis capacitaciónes</a></li>
               </ul>
           </li>

    <!----//// EVALUACIONES /////----->
        <li>
           <a href="javascript: void(0);">
               <i class="far fa-newspaper "></i>
               <span> Evaluaciones </span>
               <span class="menu-arrow"></span>
           </a>
            <ul class="nav-second-level nav" aria-expanded="false">
           <?php if (showMenu($personal,$permisos)) {
                echo '
               ';
                addMenuOption('Evaluaciones', 'periodoEvaluacion',$permisos ,'Periodo de Evaluación');
           } ?>
                <li><a href="javascript: void(0);" aria-expanded="false">Desempeño<span class="menu-arrow"></span></a>
                <ul class="nav-third-level nav" aria-expanded="false">
                <li><a href="<?=base_url("Evaluaciones/empleadosDesempeno270")?>">Realizar evaluación</a></li>

           <?php addMenuOption('Evaluaciones', 'resultadosDesempeno270',$permisos ,'Resultados de Desempeño') ?>
                </ul></li>

                <li><a href="javascript: void(0);" aria-expanded="false">Competencias<span class="menu-arrow"></span></a>
                <ul class="nav-third-level nav" aria-expanded="false">
           <?php if(isJefe($this)){
                    echo '<li><a href="'.base_url("Evaluaciones/empleadosCompetencia").'">Evaluar competencias</a></li>';
                }else{
                    echo '<li><a href="'.base_url("Evaluaciones/competencias/".session('id')).'">Realizar evaluación</a></li>';
                }
                addMenuOption('Evaluaciones', 'resultadosCompetencias',$permisos ,'Resultados de competencias')
           ?>
              </ul></li>

                <li><a href="javascript: void(0);" aria-expanded="false">Departamentos<span class="menu-arrow"></span></a>
                <ul class="nav-third-level nav" aria-expanded="false">
                <li><a href="<?=base_url("Evaluaciones/evaluacionDepartamentos")?>">Realizar evaluacón</a></li>
<!--                <li><a href="--><?//=base_url("Evaluaciones/resultadosDepartamento")?><!--">Resultados de mi departamento</a></li>-->
           <?php addMenuOption('Evaluaciones', 'departamentosEmpresa',$permisos ,'Resultados por departamento') ?>
           <?php addMenuOption('Evaluaciones', 'departamentosGlobal',$permisos ,'Resultados globales') ?>
                </ul></li>

                <li><a href="javascript: void(0);" aria-expanded="false">Clima Laboral <span class="menu-arrow"></span></a>
                <ul class="nav-third-level nav" aria-expanded="false">
                <li><a href="<?=base_url("Evaluaciones/evaluacionClimaLaboral")?>">Realizar evalución</a></li>
           <?php addMenuOption('Evaluaciones', 'resultadosClimaLaboral',$permisos ,'Resultados de la empresa') ?>
                </ul></li>
            </ul>
        </li>
        <?php
        ///////// Reclutamiento /////////
        if (showMenu($reclutamiento,$permisos)) {
            echo '<li>
            <a href="javascript: void(0);">
                <i class="fab fa-creative-commons-by "></i>
                <span> Reclutamiento </span>
                <span class="menu-arrow"></span>
            </a>';
            $jefeSolicitud=$db->query("SELECT COUNT(can_CandidatoID) as 'candidatos' FROM solicitudpersonal JOIN candidato ON can_SolicitudPersonalID=sol_SolicitudPersonalID WHERE can_Estatus='AUT_A_FINAL' AND sol_EmpleadoID=".session("id"))->getRowArray();

            if (showMenu($reclutamiento,$permisos)) {
                echo '
            <ul class="nav-second-level" aria-expanded="false">';
                addMenuOption('Reclutamiento', 'requisicionPersonal',$permisos ,'Requisición de Personal');
                addMenuOption('Reclutamiento', 'seguimientoReqPer',$permisos ,'Seguimiento de requisición de personal');
                addMenuOption('Reclutamiento', 'carteraCandidatos',$permisos ,'Cartera de candidato');
                if($jefeSolicitud['candidatos']>0){
                    echo '<li><a href="'.base_url("Reclutamiento/seleccionCandidatos").'">Selección de candidatos</a></li>';
                }
                echo '  
            </ul>
        </li>';
            }
        }
        ?>


        <?php
        ///////// MATERIALES /////////
        /*if (showMenu($materiales,$permisos)) {
            echo '<li>
                <a href="javascript: void(0);">
                    <i class="fas fa-cubes"></i>
                    <span> Materiales </span>
                    <span class="menu-arrow"></span>
                </a>';

            if (showMenu($materiales,$permisos)) {
                echo '
                <ul class="nav-second-level" aria-expanded="false">';
                addMenuOption('Materiales', 'categoriaMaterial',$permisos ,'Categorias');
                addMenuOption('Materiales', 'activoFijo',$permisos ,'Activo fijo');
                echo '  </ul>
            </li>';
            }
        }*/
        ?>

        <!----//// COMUNICADOS /////----->
        <?php
        if (showMenu($comunicados,$permisos)) {?>
        <li>
            <a href="<?= base_url("CH/comunicados")?>">
                <i class="mdi mdi-email-edit"></i>
                <span> Comunicados</span>
            </a>
        </li>
        <?php } ?>
        <li>
            <a href="<?= base_url("Usuario/misComunicados")?>">
                <i class="mdi mdi-email-multiple-outline"></i>
                <span>Mis comunicados</span>
            </a>
        </li>

</ul>

</div>
