<?php
$result = db()->query('SELECT fun_Nombre, fun_Modulo FROM funcion WHERE fun_Estatus = 1')->getResultArray();
foreach ($result as $row) {
    ${strtolower($row['fun_Modulo'])}[] = $row['fun_Nombre'];
}
?>
<li class="header">Inicio</li>
<li class="active"> <a href="<?= base_url("Usuario/index") ?>"><i class="zmdi zmdi-home"></i><span>Dashboard</span></a></li>
<?php if (showMenu($configuracion)) { ?>
    <li class="header">Configuracion y Catalogos</li>
    <li> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-settings"></i><span>Configuración</span> </a>
        <ul class="ml-menu">
            <?php
            echo addMenuOption('roles', 'Configuracion', 'Roles y permisos');
            echo addMenuOption('diasInhabiles', 'Configuracion', 'Dias Inhabiles');
            echo addMenuOption('prestaciones', 'Configuracion', 'Prestaciones');
            echo addMenuOption('configuracionPermisos', 'Configuracion', 'Permisos');
            echo addMenuOption('configuracionExpediente', 'Configuracion', 'Expedientes');
            echo showSubMenu(array(['horarios','Configuracion','Crear Horarios'],['guardias','Configuracion','Guardias']),'Horarios');
            echo addMenuOption('configChecklistIngresoEgreso','Configuracion','Onboarding y Offboarding');
            ?>
            
        </ul>
    </li>
<?php } ?>
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
<li class="header">Personal</li>
<li> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-accounts"></i><span>Colaboradores</span> </a>
    <ul class="ml-menu">
        <li><a href="basic-form-elements.html">Basic Form Elements</a> </li>
        <li><a href="advanced-form-elements.html">Advanced Form Elements</a> </li>
        <li><a href="form-examples.html">Form Examples</a> </li>
        <li><a href="form-validation.html">Form Validation</a> </li>
        <li><a href="form-wizard.html">Form Wizard</a> </li>
        <li><a href="form-editors.html">Editors</a> </li>
        <li><a href="form-upload.html">File Upload</a></li>
    </ul>
</li>
<li class="header">Incidencias</li>
<li> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-flight-takeoff"></i><span>Vacaciones</span> </a>
    <ul class="ml-menu">
        <li> <a href="ec-dashboard.html">Dashboard</a></li>
        <li> <a href="ec-product.html">Product</a></li>
        <li> <a href="ec-product-List.html">Product List</a></li>
        <li> <a href="ec-product-detail.html">Product detail</a></li>
    </ul>
</li>
<li> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-assignment-check"></i><span>Permisos</span> </a>
    <ul class="ml-menu">
        <li><a href="widgets-app.html">Apps Widgets</a></li>
        <li><a href="widgets-data.html">Data Widgets</a></li>
    </ul>
</li>
<li> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-pin-assistant"></i><span>Asistencia</span> </a>
    <ul class="ml-menu">
        <li><a href="sign-in.html">Sign In</a> </li>
        <li><a href="sign-up.html">Sign Up</a> </li>
        <li><a href="forgot-password.html">Forgot Password</a> </li>
        <li><a href="404.html">Page 404</a> </li>
        <li><a href="500.html">Page 500</a> </li>
        <li><a href="page-offline.html">Page Offline</a> </li>
        <li><a href="locked.html">Locked Screen</a> </li>
    </ul>
</li>
<li> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-time-countdown"></i><span>Horas Extra</span> </a>
    <ul class="ml-menu">
        <li><a href="blank.html">Blank Page</a> </li>
        <li> <a href="image-gallery.html">Image Gallery</a> </li>
        <li><a href="profile.html">Profile</a></li>
        <li><a href="timeline.html">Timeline</a></li>
        <li><a href="pricing.html">Pricing</a></li>
        <li><a href="invoices.html">Invoices</a></li>
        <li><a href="search-results.html">Search Results</a></li>
    </ul>
</li>
<li> <a href="javascript:void(0);" class="menu-toggle"><i class="zmdi zmdi-car"></i><span>Salidas</span> </a>
    <ul class="ml-menu">
        <li> <a href="google.html">Google Map</a> </li>
        <li> <a href="yandex.html">YandexMap</a> </li>
        <li> <a href="jvectormap.html">jVectorMap</a> </li>
    </ul>
</li>