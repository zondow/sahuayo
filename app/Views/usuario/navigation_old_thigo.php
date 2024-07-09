<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<?php
$numero = (int)session('numero');
$permisos = json_decode(session('permisos'), 1);
//var_dump($permisos);exit();
$configuracion = array('roles', 'diasInhabiles', 'prestaciones', 'horarios', 'configuracionPermisos', 'configChecklistIngresoEgreso');
$catalogos = array('puestos', 'departamentos', 'areas', 'horarios', 'cooperativas', 'sucursales');
$personal = array('empleados', 'organigrama', 'recibosNomina');
$reportesPersonal = array('reporteQuinquenio');
$evaluacion = array('periodoEvaluacion','resultadosClimaLaboral', 'departamentosGlobal','resultadosGuiaI', 'resultadosGuiaII');
$comunicados = array('comunicados','normativaInterna');
$formacion = array('proveedores','cursos','instructores','programaCapacitacion','competencias');
$horasextra = array('controlHorasExtra','aplicarReporteHoras');
$reportesIncidencias = array('reporteHorasVacacionesEmpleados');
$reclutamientoRH = array( 'seguimientoReqPer', 'carteraCandidatos');
$reclutamiento = array('requisicionPersonal');
$incidencias = array('importarlistaAsistencia', 'reporteAsistencia','reporteBonoPuntualidad');
$galeria = array('subirFotos');
$anuncio = array('anuncios');
$capsulas = array('administrarCapsulas');

?>

<div id="sidebar-menu">
    <ul class="metismenu" id="side-menu">
        <li>
            <a href="<?= base_url("Usuario/index") ?>">
                <i class="fe-home"></i>
                <span> Inicio</span>
            </a>
        </li>
        <?php
        ///////// CONFIGURACION /////////
        if (showMenu($configuracion, $permisos)) {
            echo '<li>
                <a href="javascript: void(0);">
                    <i class="dripicons-gear"></i>
                    <span> Configuración </span>
                    <span class="menu-arrow"></span>
                </a>';

            if (showMenu($configuracion, $permisos)) {
                echo '
                        <ul class="nav-second-level" aria-expanded="false">';
                addMenuOption('Configuracion', 'roles', $permisos, 'Roles');
                addMenuOption('Configuracion', 'diasInhabiles', $permisos, 'Días inhabiles');
                addMenuOption('Configuracion', 'prestaciones', $permisos, 'Prestaciones');?>
                <li>
                    <a href="javascript: void(0);" aria-expanded="false">Horarios
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-third-level nav" aria-expanded="false">
                        <?php
                        addMenuOption('Configuracion', 'horarios', $permisos, 'Crear Horarios');
                        addMenuOption('Configuracion', 'guardias', $permisos, 'Guardias');
                        ?>
                    </ul>
                </li>
                <?php
                addMenuOption('Configuracion', 'configuracionPermisos', $permisos, 'Permisos');
                addMenuOption('Configuracion', 'configuracionExpediente', $permisos, 'Expediente');
                addMenuOption('Configuracion', 'configChecklistIngresoEgreso', $permisos, 'Checklist ingreso/egreso');
                echo '  </ul>
              </li>';
            }
        }
        ///////// CATALOGOS /////////
        if (showMenu($catalogos, $permisos)) {
            echo '<li>
                        <a href="javascript: void(0);">
                            <i class="fe-layers"></i>
                            <span> Catálogos </span>
                            <span class="menu-arrow"></span>
                        </a>';

            if (showMenu($catalogos, $permisos)) {
                echo '
                                <ul class="nav-second-level" aria-expanded="false">';
                addMenuOption('Catalogos', 'sucursales', $permisos, 'Sucursales');
                addMenuOption('Catalogos', 'departamentos', $permisos, 'Departamentos');
                addMenuOption('Catalogos', 'areas', $permisos, 'Areas');
                addMenuOption('Catalogos', 'puestos', $permisos, 'Puestos');
                //addMenuOption('Catalogos', 'cooperativas', $permisos, 'Cooperativas');
                echo '  </ul>
                      </li>';
            }
        }
        ///////// PERSONAL /////////
        if (showMenu($personal, $permisos)) {
            echo '<li>
                <a href="javascript: void(0);">
                    <i class="fa fa-users"></i>
                    <span> Personal </span>
                    <span class="menu-arrow"></span>
                </a>';

            if (showMenu($personal, $permisos)) {
                echo '
                <ul class="nav-second-level" aria-expanded="false">';
                addMenuOption('Personal', 'empleados', $permisos, 'Empleados');
                addMenuOption('Personal', 'organigrama', $permisos, 'Organigrama');
                addMenuOption('Personal', 'recibosNomina', $permisos, 'Recibos de nómina');


                ///////// REPORTES DE PERSONAL /////////
                if (showMenu($reportesPersonal, $permisos)) {
                    echo '<li>
                        <a href="javascript: void(0);">
                            <span> Reportes </span>
                            <span class="menu-arrow"></span>
                        </a>';

                    if (showMenu($reportesPersonal, $permisos)) {
                        echo '
                        <ul class="nav-second-level" aria-expanded="false">';
                        addMenuOption('Personal', 'reporteQuinquenio', $permisos, 'Quinquenios');
                        echo '  </ul>
                    </li>';
                    }
                }
                echo '  </ul>
            </li>';
            }
        }
        ///////// INCIDENCIAS //////
        ?>
        <li>
            <a href="javascript: void(0);">
                <i class="fas fa-exclamation"></i>
                <span> Incidencias </span>
                <span class="menu-arrow"></span>
            </a>
            <ul class="nav-second-level" aria-expanded="false">
                <?php if (showMenu($incidencias, $permisos)) { ?>
                    <li>
                        <a href="javascript: void(0);" aria-expanded="false">Asistencia
                            <span class="menu-arrow"></span>
                        </a>
                        <ul class="nav-third-level nav" aria-expanded="false">
                            <?php
                            addMenuOption('Incidencias', 'reporteAsistencia', $permisos, 'Reporte de asistencia');

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
                            <a href="<?= base_url("Incidencias/misVacaciones") ?>">Mis vacaciones</a>
                        </li>
                        <?php if (isJefe($this)) { ?>
                            <li>
                                <a href="<?= base_url("Incidencias/vacacionesMisEmpleados") ?>">Autorizar vacaciones</a>
                            </li>
                        <?php }
                        addMenuOption('Incidencias', 'listVacaciones/aplicar', $permisos, 'Aplicar vacaciones');
                        ?>
                        <li>
                            <a href="<?= base_url("Incidencias/cambioVacacionesHoras") ?>">Cambiar Vacaciones por horas</a>
                        </li>
                        <?php addMenuOption('Incidencias', 'aplicarCambioHorasVac', $permisos, 'Aplicar vacaciones-horas'); ?>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" aria-expanded="false">Permisos
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-third-level nav" aria-expanded="false">
                        <li><a href="<?= base_url("Incidencias/misPermisos") ?>">Mis permisos</a></li>
                        <?php if (isJefe($this)) { ?>
                            <li><a href="<?= base_url("Incidencias/permisosMisEmpleados") ?>">Autorizar permisos</a></li>
                        <?php }
                        addMenuOption('Incidencias', 'aplicarPermisos', $permisos, 'Aplicar permisos');
                        ?>
                    </ul>
                </li>
                <?php if(in_array(session('id'),[7,19,41,50,105])){ ?>
                <li>
                    <a href="javascript: void(0);" aria-expanded="false">Horas extra
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-third-level nav" aria-expanded="false">
                        <li><a href="<?= base_url("Incidencias/controlHorasExtra") ?>">Control de mis horas extra</a></li>
                        <?php
                        if (isJefe($this)) echo '<li><a href="' . base_url("Incidencias/horasExtraMisEmpleados") . '">Autorizar reportes</a></li>';
                        addMenuOption('Incidencias', 'aplicarReporteHoras', $permisos, 'Aplicar reportes');
                        ?>
                    </ul>
                </li>
                <?php } ?>
                <li>
                    <a href="javascript: void(0);" aria-expanded="false">Salidas
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-third-level nav" aria-expanded="false">
                        <li><a href="<?= base_url("Incidencias/reporteSalidas") ?>">Mis salidas</a></li>
                        <?php if (isJefe($this)) { ?>
                            <li><a href="<?= base_url("Incidencias/informeSalidasMisEmpleados") ?>">Autorizar salidas</a></li>
                        <?php }
                        addMenuOption('Incidencias', 'aplicarInformeSalidas', $permisos, 'Aplicar salidas');
                        ?>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" aria-expanded="false">Incapacidad
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-third-level nav" aria-expanded="false">
                        <li><a href="<?= base_url("Incidencias/misIncapacidades") ?>">Mis incapacidades</a></li>
                        <?php
                        if (isJefe($this)) {
                            echo '<li><a href="' . base_url("Incidencias/incapacidadesMisEmpleados") . '">Incapacidades de Colaboradores</a></li>';
                        }
                        addMenuOption('Incidencias', 'incapacidad', $permisos, 'Revisar Incapacidades');
                        ?>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" aria-expanded="false">Sanciones
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="nav-third-level nav" aria-expanded="false">
                        <li><a href="<?= base_url("Incidencias/misSanciones") ?>">Mis sanciones</a></li>
                        <?php
                        if (isJefe($this)) {
                            echo '<li><a href="' . base_url("Incidencias/sancionesMisEmpleados") . '">Sanciones de Colaboradores</a></li>';
                        }
                        addMenuOption('Incidencias', 'sanciones', $permisos, 'Crear sanciones');
                        ?>
                    </ul>
                </li>
                <?php
                ///////// REPORTES DE INCIDENCIAS /////////
                if (showMenu($reportesIncidencias, $permisos)) {
                    echo '<li>
                        <a href="javascript: void(0);">
                            <span> Reportes </span>
                            <span class="menu-arrow"></span>
                        </a>';

                    if (showMenu($reportesIncidencias, $permisos)) {
                        echo '
                        <ul class="nav-second-level" aria-expanded="false">';
                        addMenuOption('Incidencias', 'reporteHorasVacacionesEmpleados', $permisos, 'Vacaciones y Horas extra');
                        addMenuOption('Incidencias', 'reportePeriodo', $permisos, 'Vacaciones (Periodo)');
                        echo '  </ul>
                    </li>';
                    }
                }
                ?>
            </ul>
        </li>
        <!----//// EVALUACIONES /////-->
        <li>
            <a href="javascript: void(0);">
                <i class="mdi mdi-format-list-checks"></i>
                <span> Evaluaciones </span>
                <span class="menu-arrow"></span>
            </a>
            <ul class="nav-second-level nav" aria-expanded="false">
                <?php if (showMenu($evaluacion, $permisos)) {
                    echo '
               ';
                    addMenuOption('Evaluaciones', 'periodoEvaluacion', $permisos, 'Periodo de Evaluación');
                } ?>

                <li><a href="javascript: void(0);" aria-expanded="false">Desempeño<span class="menu-arrow"></span></a>
                    <ul class="nav-third-level nav" aria-expanded="false">
                        <li><a href="<?= base_url("Evaluaciones/empleadosDesempeno270") ?>">Realizar evaluación</a></li>

                        <?php addMenuOption('Evaluaciones', 'resultadosDesempeno270', $permisos, 'Resultados de Desempeño') ?>
                    </ul>
                </li>

                <li><a href="javascript: void(0);" aria-expanded="false">Competencias<span class="menu-arrow"></span></a>
                    <ul class="nav-third-level nav" aria-expanded="false">
                        <?php if (isJefe($this)) {
                            echo '<li><a href="' . base_url("Evaluaciones/empleadosCompetencia") . '">Evaluar competencias</a></li>';
                        } else {
                            echo '<li><a href="' . base_url("Evaluaciones/competencias/" . encryptDecrypt('encrypt', session('id'))) . '">Realizar evaluación</a></li>';
                        }
                        addMenuOption('Evaluaciones', 'resultadosCompetencias', $permisos, 'Resultados de competencias')
                        ?>
                    </ul>
                </li>

                <li><a href="javascript: void(0);" aria-expanded="false">Clima Laboral <span class="menu-arrow"></span></a>
                    <ul class="nav-third-level nav" aria-expanded="false">
                        <li><a href="<?= base_url("Evaluaciones/evaluacionClimaLaboral") ?>">Realizar evalución</a></li>
                        <?php addMenuOption('Evaluaciones', 'resultadosClimaLaboral', $permisos, 'Resultados') ?>
                    </ul>
                </li>

                <li><a href="javascript: void(0);" aria-expanded="false">Nom 035 <span class="menu-arrow"></span></a>
                    <ul class="nav-third-level nav" aria-expanded="false">
                        <li><a href="<?= base_url("Evaluaciones/nom035") ?>">Realizar evaluación</a></li>
                        <?php addMenuOption('Evaluaciones', 'resultadosGuiaI', $permisos, 'Resultados de la guia I') ?>
                        <?php addMenuOption('Evaluaciones', 'resultadosGuiaII', $permisos, 'Resultados de la guia II') ?>
                        <?php addMenuOption('Evaluaciones', 'resultadosGuiaIII', $permisos, 'Resultados de la guia III') ?>

                    </ul>
                </li>
            </ul>
        </li>

        <!---- RECLUTAMIENTO --------->
        <?php
        if (showMenu($reclutamiento, $permisos)) {
            echo '<li>
            <a href="javascript: void(0);">
                <i class="fab fa-creative-commons-by "></i>
                <span> Reclutamiento </span>
                <span class="menu-arrow"></span>
            </a>';
            //$jefeSolicitud = $db->query("SELECT COUNT(can_CandidatoID) as 'candidatos' FROM solicitudpersonal JOIN candidato ON can_SolicitudPersonalID=sol_SolicitudPersonalID WHERE can_Estatus='AUT_A_FINAL' AND sol_EmpleadoID=" . session("id"))->getRowArray();

            if (showMenu($reclutamiento, $permisos)) {
                echo '<ul class="nav-second-level" aria-expanded="false">';
                addMenuOption('Reclutamiento', 'requisicionPersonal', $permisos, 'Requisición de Personal');
                addMenuOption('Reclutamiento', 'seguimientoReqPer', $permisos, 'Seguimiento de requisición de personal');
                addMenuOption('Reclutamiento', 'carteraCandidatos', $permisos, 'Cartera de candidato');
                echo '</ul>
            </li>';
            }
        }
        ?>

        <!----//// FORMACION /////----->

        <li>
            <a href="javascript: void(0);">
                <i class="fas fa-school"></i>
                <span> Formación </span>
                <span class="menu-arrow"></span>
            </a>
            <ul class="nav-second-level" aria-expanded="false">
                <?php if (showMenu($formacion, $permisos)) {
                    echo '<li><a href="javascript: void(0);" aria-expanded="false">Catalogos<span class="menu-arrow"></span></a>';
                    echo '<ul class="nav-third-level nav" aria-expanded="false">';
                    addMenuOption('Formacion', 'cursos', $permisos, 'Cursos');
                    addMenuOption('Formacion', 'instructores', $permisos, 'Instructores');
                    addMenuOption('Formacion', 'proveedores', $permisos, 'Proveedores');
                    addMenuOption('Formacion', 'competencias', $permisos, 'Competencias');

                    echo '</ul></li>';
                    addMenuOption('Formacion', 'programaCapacitacion', $permisos, 'Programa de capacitación');
                }

                if (isInstructor()) { ?>
                    <li><a href="<?= base_url("Formacion/capacitacionesInstructor") ?>">Capacitaciones</a></li>
                <?php } ?>
                <li><a href="<?= base_url("Formacion/misCapacitaciones") ?>">Mis capacitaciones</a></li>
            </ul>
        </li>

        <!---//// COMUNICADOS /////----->
        <?php

        if (showMenu($comunicados, $permisos)) { ?>

            <li>
                <a>
                    <i class="dripicons-broadcast"></i>
                    <span> Comunicados </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-second-level " aria-expanded="false">
                    <li><a href="<?= base_url("Comunicados/comunicados") ?>">Gestion de comunicados</a></li>
                    <li><a href="<?= base_url("Comunicados/misComunicados") ?>">Mis comunicados </a></li>
                </ul>
            </li>

        <?php } else { ?>
            <li>
                <a href="<?= base_url("Comunicados/misComunicados") ?>">
                    <i class="dripicons-broadcast"></i>
                    <span>Mis comunicados</span>
                </a>
            </li>
        <?php } ?>

        <!----//// NORMATIVA /////----->
        <?php
        if (showMenu($comunicados, $permisos)) { ?>

            <li>
                <a>
                    <i class="fas fa-gavel"></i>
                    <span> Reglamentos </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-second-level " aria-expanded="false">
                    <li><a href="<?= base_url("Comunicados/normativaInterna") ?>">Gestión de documentos</a></li>
                    <li><a href="<?= base_url("Usuario/normativa") ?>">Mis reglamentos </a></li>
                </ul>
            </li>

        <?php } else { ?>
            <li>
                <a href="<?= base_url("Usuario/normativa") ?>">
                    <i class="fas fa-gavel"></i>
                    <span> Mis reglamentos </span>
                </a>
            </li>
        <?php } ?>
                <!------ Anuncios --------->
                <?php
        if (showMenu($anuncio, $permisos)) { ?>
            <li>
                <a href="<?= base_url("Usuario/anuncio") ?>">
                    <i class="fas fa-video"></i>
                    <span> Anuncios </span>
                </a>
            </li>
        <?php } ?>
        <!------ GALERIA --------->
        <?php
        if (showMenu($galeria, $permisos)) { ?>
            <li>
                <a>
                    <i class="dripicons-photo-group"></i>
                    <span> Galería </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-second-level " aria-expanded="false">
                    <li><a href="<?= base_url("Comunicados/subirFotos") ?>">Subir fotos</a></li>
                    <li><a href="<?= base_url("Comunicados/galeriaFotos") ?>">Galería de fotos </a></li>
                </ul>
            </li>
        <?php } else { ?>
            <li>
                <a href="<?= base_url("Comunicados/galeriaFotos") ?>">
                    <i class="dripicons-photo-group"></i>
                    <span>Galería de fotos</span>
                </a>
            </li>
        <?php } ?>
        <!------ CAPSULAS EDUCATIVAS --------->
        <?php
        if (showMenu($capsulas, $permisos)) { ?>
            <li>
                <a>
                    <i class="mdi mdi-cast-education "></i>
                    <span> Cápsulas educativas </span>
                    <span class="menu-arrow"></span>
                </a>
                <ul class="nav-second-level " aria-expanded="false">
                    <li><a href="<?= base_url("Comunicados/administrarCapsulas") ?>">Administrar cápsulas</a></li>
                    <li><a href="<?= base_url("Comunicados/misContenidos") ?>">Mis cápsulas</a></li>
                </ul>
            </li>
        <?php } else { ?>
            <li>
                <a href="<?= base_url("Comunicados/misContenidos") ?>">
                    <i class="mdi mdi-cast-education "></i>
                    <span>Cápsulas </span>
                </a>
            </li>
        <?php } ?>
        <!----//// MESA DE AYUDA /////----->
        <hr>
        <?php
        /*if (isSolicitanteMesa() || administradorID()) {?>
        <li>
            <a href="<?= base_url("MesaAyuda/index")?>">
                <i><img src = "<?=base_url('assets/images/iconsmesa/iconoMenu2.svg')?>" width="18px" /></i>
                <span> Mesa de ayuda </span>
            </a>
        </li>
        <?php }*/?>
    </ul>
</div>