<?php
$result = db()->query('SELECT fun_Nombre, fun_Modulo FROM funcion WHERE fun_Estatus = 1')->getResultArray();
foreach ($result as $row) {
    ${strtolower($row['fun_Modulo'])}[] = $row['fun_Nombre'];
}
?>
<li class="header">Inicio</li>
<li class="active"> <a href="<?= base_url("Usuario/index") ?>"><i class="zmdi zmdi-home"></i><span>Dashboard</span></a></li>
<?php if (showMenu($configuracion)) : ?>
    <li class="header">Configuracion y Catalogos</li>
    <li> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-settings"></i><span>Configuración</span> </a>
        <ul class="ml-menu">
            <?php
            echo addMenuOption('roles', 'Configuracion', 'Roles y permisos');
            echo addMenuOption('diasInhabiles', 'Configuracion', 'Dias Inhabiles');
            echo addMenuOption('prestaciones', 'Configuracion', 'Prestaciones');
            echo addMenuOption('configuracionPermisos', 'Configuracion', 'Permisos');
            echo addMenuOption('configuracionExpediente', 'Configuracion', 'Expedientes');
            echo showSubMenu(array(['horarios', 'Configuracion', 'Crear Horarios'], ['guardias', 'Configuracion', 'Guardias']), 'Horarios');
            echo addMenuOption('configChecklistIngresoEgreso', 'Configuracion', 'Onboarding y Offboarding');
            ?>

        </ul>
    </li>
<?php endif; 
    if(showMenu($catalogos)):?>
<li> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-book"></i><span>Catalogos</span> </a>
    <ul class="ml-menu">
        <?php
        echo addMenuOption('sucursales', 'Catalogos', 'Sucursales');
        echo addMenuOption('departamentos', 'Catalogos', 'Departamentos');
        echo addMenuOption('areas', 'Catalogos', 'Areas');
        echo addMenuOption('puestos', 'Catalogos', 'Puestos');
        echo addMenuOption('competencias', 'Catalogos', 'Competencias');
        echo addMenuOption('cursos', 'Catalogos', 'Cursos');
        echo addMenuOption('proveedores', 'Catalogos', 'Proveedores de capacitación');
        echo addMenuOption('instructores', 'Catalogos', 'Instructores de capacitación');

        ?>
    </ul>
</li>
<?php endif; ?>
<li class="header">Personal</li>
<li> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-accounts"></i><span>Colaboradores</span> </a>
    <ul class="ml-menu">
    <?php
        echo addMenuOption('empleados', 'Personal', 'Plantilla');
        echo addMenuOption('organigrama', 'Personal', 'Organigrama');
        echo addMenuOption('recibosNomina', 'Personal', 'Recibos de nómina');
        echo showSubMenu(array(['reporteQuinquenio', 'Personal', 'Quinquenios']), 'Reportes');
        ?>
    </ul>
</li>
<li class="header">Incidencias</li>
<li> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-flight-takeoff"></i><span>Vacaciones</span> </a>
    <ul class="ml-menu">
        <li><a href="<?= base_url('Incidencias/misVacaciones') ?>">Mis Vacaciones</a></li>
        <?php if (isJefe($this)) : ?><li><a href="<?= base_url("Incidencias/vacacionesMisEmpleados") ?>">Autorizar vacaciones</a></li><?php endif;
        echo addMenuOption('listVacaciones', 'Incidencias', 'Aplicar vacaciones');?>
        <li><a href="<?= base_url("Incidencias/cambioVacacionesHoras") ?>">Cambiar Vacaciones por horas</a></li>
        <?php echo addMenuOption('aplicarCambioHorasVac', 'Incidencias', 'Aplicar Cambio de Vacaciones a Horas') ?>
    </ul>
</li>
<li> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-assignment-check"></i><span>Permisos</span> </a>
    <ul class="ml-menu">
        <li><a href="<?= base_url("Incidencias/misPermisos") ?>">Mis permisos</a></li>
        <?php if (isJefe($this)) : ?><li><a href="<?= base_url("Incidencias/permisosMisEmpleados") ?>">Autorizar permisos</a></li> <?php endif;
        echo addMenuOption('aplicarPermisos','Incidencias', 'Aplicar permisos');
        ?>
    </ul>
</li>
<li> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-pin-assistant"></i><span>Asistencia</span> </a>
    <ul class="ml-menu">
    <?= addMenuOption('reporteAsistencia','Incidencias','Reporte de asistencia');?>
    </ul>
</li>
<?php if(in_array(session('id'),[7,19,41,50,105])): ?>
<li> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-time-countdown"></i><span>Horas Extra</span> </a>
    <ul class="ml-menu">
        <li><a href="<?= base_url("Incidencias/controlHorasExtra") ?>">Control de mis horas extra</a></li>
        <?php
        if (isJefe($this)) : ?> <li><a href="<?= base_url("Incidencias/horasExtraMisEmpleados") ?>">Autorizar Horas Extra</a></li> <?php endif;
        echo addMenuOption('aplicarReporteHoras','Incidencias','Aplicar Horas Extra');
        ?>
    </ul>
</li>
<?php endif; ?>
<li> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-car"></i><span>Salidas</span> </a>
    <ul class="ml-menu">
        <li><a href="<?= base_url("Incidencias/reporteSalidas") ?>">Mis salidas</a></li>
        <?php if (isJefe($this)) { ?>
            <li><a href="<?= base_url("Incidencias/informeSalidasMisEmpleados") ?>">Autorizar salidas</a></li>
        <?php }
        echo addMenuOption('aplicarInformeSalidas','Incidencias', 'Aplicar salidas');
        ?>
    </ul>
</li>
<li> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-hospital-alt"></i><span>Incapacidades</span> </a>
    <ul class="ml-menu">
    <li><a href="<?= base_url("Incidencias/misIncapacidades") ?>">Mis incapacidades</a></li>
        <?php if (isJefe($this)) { ?>
            <li><a href="<?= base_url("Incidencias/incapacidadesMisEmpleados")?>">Incapacidades de Colaboradores</a></li>
        <?php }
        echo addMenuOption('incapacidad','Incidencias', 'Revisar Incapacidades');
        ?>
    </ul>
</li>
<li> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-card-alert"></i><span>Sanciones</span> </a>
    <ul class="ml-menu">
    <li><a href="<?= base_url("Incidencias/misSanciones") ?>">Mis sanciones</a></li>
        <?php if (isJefe($this)) { ?>
            <li><a href="<?= base_url("Incidencias/sancionesMisEmpleados") ?>">Sanciones de Colaboradores</a></li>
        <?php }
        echo addMenuOption('sanciones','Incidencias', 'Crear sanciones');
        ?>
    </ul>
</li>