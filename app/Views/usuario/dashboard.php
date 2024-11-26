<?php defined('FCPATH') or exit('No direct script access allowed');
$diasVacaciones = diasPendientes(session('id'));
$diasVacacionesLey = diasLey(session('fechaIngreso'));
$porcentajeVacaciones = ($diasVacaciones * 100) / $diasVacacionesLey;
$primaVacacional = prima(session('fechaIngreso'));
$aguinaldo = aguinaldo(session('fechaIngreso'));
$estilosIconos = [
    0 => [' col-blue', ' zmdi zmdi-assignment-check'],
    1 => [' col-blue', ' zmdi zmdi-assignment-check'],
    2 => [' col-amber', ' zmdi zmdi-assignment-alert'],
    3 => [' col-amber', ' zmdi zmdi-assignment-alert']
];
if ($retardos > 3) {
    $estilo = ' col-red';
    $icono = ' zmdi zmdi-assignment-alert';
} else {
    [$estilo, $icono] = $estilosIconos[$retardos];
}

?>
<div class="col-md-12 mt-2 ">
    <ul class="nav nav-tabs d-flex justify-content-end">
        <li class="nav-item"><a href="#midashboard" class="nav-link active" data-toggle="tab"><i class="zmdi zmdi-pin-account"></i> Mi dashboard</a></li>
        <?php if (isJefe()) : ?>
            <li class="nav-item"><a href="#dashboardjefe" class="nav-link" data-toggle="tab"><i class="zmdi zmdi-accounts-alt"></i> Mis colaboradores</a></li>
        <?php endif; ?>
        <?php if (isRH()) : ?>
            <li class="nav-item"><a href="#dashboardrh" class="nav-link" data-toggle="tab"><i class="zmdi zmdi-developer-board"></i> Mi dashboard RH</a></li>
        <?php endif; ?>
    </ul>

    <div class="tab-content">
        <div class="tab-pane show active" id="midashboard">
            <div class="row">
                <div class="col-md-12 row">
                    <div class="col-md-4">
                        <div class="card social_widget2">
                            <div class="body data text-center" style="height: 80%;">
                                <ul class="list-unstyled m-b-0">
                                    <li class="m-b-30">
                                        <img src="<?= $bienvenida['icon'] ?>" style="width:15%;">
                                        <h4 class="m-t-0 m-b-0"><?= $bienvenida['mensaje'] ?></h4>
                                        <span><?= get_nombre_dia(date('Y-m-d')) . ' ' . longDate(date('Y-m-d'), ' de ') ?></span>
                                    </li>
                                    <li class="m-b-0">
                                        <i class="zmdi zmdi-comment-text col-red"></i>
                                        <h4 class="m-t-0 m-b-0">365</h4>
                                        <span>Comments</span>
                                    </li>
                                </ul>
                            </div>
                            <div class="name facebook">
                                <ul class="list-unstyled m-b-30">
                                    <li class="m-b-25">
                                        <div class="progress-container">
                                            <span class="progress-badge">Vacaciones</span>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="<?= $diasVacaciones ?>" aria-valuemin="0" aria-valuemax="<?= $diasVacacionesLey ?>" style="width: <?= $porcentajeVacaciones ?>%;">
                                                    <span class="progress-value"><?= $diasVacaciones . ' / ' . $diasVacacionesLey ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="m-b-25">
                                        <div class="progress-container">
                                            <span class="progress-badge">Prima vacacional</span>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="<?= $primaVacacional ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $primaVacacional ?>%;">
                                                    <span class="progress-value"><?= $primaVacacional ?>%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="m-b-25">
                                        <div class="progress-container">
                                            <span class="progress-badge">Aguinaldo</span>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;">
                                                    <span class="progress-value"><?= $aguinaldo ?> días</span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <h5><?= $bienvenida['genero'] . ' ' . $bienvenida['nombre'] ?></h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="col-md-12">
                            <div class="card">
                                <ul class="row profile_state list-unstyled">
                                    <li class="col-lg-4 col-md-4 col-6">
                                        <div class="body verInfoRetardo">
                                            <i class="<?= $icono . $estilo ?>"></i>
                                            <h4><?= $retardos ?></h4>
                                            <span>Retardos</span>
                                        </div>
                                    </li>
                                    <li class="col-lg-4 col-md-4 col-6">
                                        <div class="body verInfoPermisos">
                                            <i class="zmdi zmdi-thumb-up col-amber"></i>
                                            <h4>Permisos</h4>
                                            <span>Información</span>
                                        </div>
                                    </li>
                                    <li class="col-lg-4 col-md-4 col-6">
                                        <div class="body text-center">
                                            <i class="zmdi zmdi-time-countdown col-green"></i>
                                            <h4><?= $horasExtra + $horasAdministrativas; ?></h4>
                                            <span>Mis horas</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card">
                                <ul class="row profile_state list-unstyled">
                                    <li class="col-lg-12">
                                        <a href="<?= base_url('PDF/reporteIncidencias/' . encryptDecrypt('encrypt', session('id'))) ?>" class="body btn btn-link text-decoration-none" target="_blank">
                                            <i class="zmdi zmdi-assignment-account col-amber"></i>
                                            <h4>Ver</h4>
                                            <span>Kardex</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Mis vacaciones y permisos pendientes</strong></h2>
                        </div>
                        <div class="body table-responsive">
                            <table class="table table-hover m-b-0">
                                <thead>
                                    <tr>
                                        <th>Tipo</th>
                                        <th>Fechas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($vacacionesPermisosPendientes as $vp) { ?>
                                        <tr>
                                            <td><?= $vp['tipo'] ?></td>
                                            <td>
                                                <?= $vp['fechas'] ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-body">
                            <div class="header">
                                <h2><strong>Fechas importantes</strong></h2>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <select class="form-control " id="selector">
                                        <option value="all">Todos</option>
                                        <option value="cumple">Cumpleaños</option>
                                        <option value="aniversario">Aniversarios</option>
                                        <option value="inhabil">Inhabiles</option>
                                        <option value="inhabilLey">Inhabiles de ley</option>
                                        <option value="evaluacion">Periodos de evaluación</option>
                                        <option value="capacitacion">Capacitaciones</option>
                                        <option value="vacaciones">Mis Vacaciones</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 text-center">
                                <span class="badge badge-info badge-pill font-13">Cumpleaños</span>
                                <span class="badge badge-warning badge-pill font-13">Aniversario</span>
                                <span class="badge badge-success badge-pill font-13">Día inhabil</span>
                                <span class="badge badge-danger badge-pill font-13">Día inhabil de ley</span>
                            </div>
                            <div id="calendarAgenda"></div>
                        </div>
                    </div>
                </div>
                <?php if ($galeria) { ?>
                    <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="body">
                                <div id="demo2" class="carousel slide" data-ride="carousel">
                                    <?php
                                    $fotografias = galeriaFotos();
                                    $totalFotografias = count($fotografias);
                                    if ($totalFotografias > 0) : ?>
                                        <!-- Indicators -->
                                        <ul class="carousel-indicators">
                                            <?php for ($i = 0; $i < $totalFotografias; $i++) : ?>
                                                <li data-target="#demo2" data-slide-to="<?= $i ?>" class="<?= $i === 0 ? 'active' : '' ?>"></li>
                                            <?php endfor; ?>
                                        </ul>
                                        <!-- Slides -->
                                        <div class="carousel-inner">
                                            <?php foreach ($fotografias as $key => $foto) : ?>
                                                <div class="carousel-item <?= $key === 0 ? 'active' : '' ?>">
                                                    <img src="<?= htmlspecialchars($foto) ?>" class="img-fluid" alt="Foto <?= $key + 1 ?>">
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <!-- Controls -->
                                        <a class="carousel-control-prev" href="#demo2" data-slide="prev">
                                            <span class="carousel-control-prev-icon"></span>
                                        </a>
                                        <a class="carousel-control-next" href="#demo2" data-slide="next">
                                            <span class="carousel-control-next-icon"></span>
                                        </a>
                                    <?php else : ?>
                                        <p class="text-center">No hay fotografías disponibles.</p>
                                    <?php endif; ?>
                                </div>
                                <div class="header">
                                    <h2><strong><?= strtoupper($galeria['gal_Nombre']) ?></strong></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }
                if ($anuncio) { ?>
                    <div class="col-lg-6 col-md-12">
                        <div class="card">
                            <div class="body">
                                <?= getAnuncio($anuncio); ?>
                                <div class="header">
                                    <h2><strong>Anuncios</strong></h2>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>

            </div>
        </div>
        <div class="tab-pane show" id="dashboardjefe">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="header">
                                <h2><strong>Vacaciones y permisos de mis colaboradores</strong></h2>
                            </div>
                            <div id="calendarVacPerMisEmpleados"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="card ">
                        <div class="header">
                            <h2><strong>Mi Equipo</strong></h2>
                        </div>
                        <div class="body">
                            <ul class="inbox-widget list-unstyled clearfix">
                                <?php foreach ($misEmpleados as $empleado) { ?>
                                    <li class="inbox-inner"><a href="#">
                                        </a>
                                        <div class="inbox-item"><a href="#">
                                                <div class="inbox-img"> <img src="<?= fotoPerfil(encrypt($empleado['emp_EmpleadoID'])) ?>" class="rounded" alt=""> </div>
                                                <div class="inbox-item-info">
                                                    <p class="author"><?= $empleado['emp_Nombre'] ?></p>
                                                    <p class="inbox-message"><strong>Puesto: </strong><?= $empleado['pue_Nombre'] ?></p>
                                                    <p class="inbox-message"><strong>Correo: </strong><?= $empleado['emp_Correo'] ?></p>
                                                    <p class="inbox-date">Antigüedad <?= shortDate($empleado['emp_FechaIngreso'], ' de ') ?></p>
                                                </div>
                                            </a>
                                        </div>

                                    </li>
                                <?php } ?>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane show" id="dashboardrh">
            <div class="row">
                <div class="card">
                    <div class="header">
                        <h2><strong>Información de Colaboradores</strong></h2>
                    </div>
                    <div class="card widget_2">
                        <ul class="row clearfix list-unstyled m-b-0">
                            <?php $totalEmpleados = array_sum(array_column($generoEmpleados, 'num'));
                            foreach ($generoEmpleados as $gemp) {
                                $color = ($gemp['genero'] == 'Masculino') ? 'l-green' : 'l-blush';
                                $porcentaje = ($gemp['num'] * 100) / $totalEmpleados; ?>
                                <li class="col-md-6">
                                    <div class="body">
                                        <div class="row">
                                            <div class="col-7">
                                                <h5 class="m-t-0"><?= $gemp['genero'] ?></h5>
                                            </div>
                                            <div class="col-5 text-right">
                                                <h2 class="">
                                                    <?= $gemp['num'] ?>
                                                </h2>
                                                <small class="info">de <?= $totalEmpleados ?> Colaboradores</small>
                                            </div>
                                            <div class="col-12">
                                                <div class="progress m-t-20" value="<?= $porcentaje ?>" type="success">
                                                    <div class="progress-bar <?= $color ?>" role="progressbar" aria-valuenow="<?= $porcentaje ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $porcentaje ?>%;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-6">
                            <div class="card">
                                <div class="header">
                                    <h2><strong>Ingresos</strong></h2>
                                </div>
                                <div class="body">
                                    <div class="row">
                                        <div class="col-sm-6 col-6 m-b-10">
                                            <small class="text-muted">Mes</small>
                                            <h5 class="m-b-0"><?= $empleadosIngresos['month'] ?></h5>
                                        </div>
                                        <div class="col-sm-6 col-6 m-b-10">
                                            <small class="text-muted">Año</small>
                                            <h5 class="m-b-0"><?= $empleadosIngresos['year'] ?></h5>
                                        </div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar l-turquoise" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 87%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="card">
                                <div class="header">
                                    <h2><strong>Bajas</strong></h2>
                                </div>
                                <div class="body">
                                    <div class="row">
                                        <div class="col-sm-6 col-6 m-b-10">
                                            <small class="text-muted">Mes</small>
                                            <h5 class="m-b-0"><?= $empleadosEgresos['month'] ?></h5>
                                        </div>
                                        <div class="col-sm-6 col-6 m-b-10">
                                            <small class="text-muted">Año</small>
                                            <h5 class="m-b-0"><?= $empleadosEgresos['year'] ?></h5>
                                        </div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar l-turquoise" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 87%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="card">
                                <div class="header">
                                    <h2><strong>Incapacidades</strong></h2>
                                </div>
                                <div class="body">
                                    <div class="row">
                                        <div class="col-sm-6 col-6 m-b-10">
                                            <small class="text-muted">Mes</small>
                                            <h5 class="m-b-0"><?= $empleadosIncapacidades['month'] ?></h5>
                                        </div>
                                        <div class="col-sm-6 col-6 m-b-10">
                                            <small class="text-muted">Año</small>
                                            <h5 class="m-b-0"><?= $empleadosIncapacidades['year'] ?></h5>
                                        </div>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar l-turquoise" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 87%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Personal por Sucursal</strong></h2>
                        </div>
                        <div class="body table-responsive">
                            <table class="table table-hover m-b-0">
                                <thead>
                                    <tr>
                                        <th>Sucursal</th>
                                        <th>N° Empleados</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($empleadosSucursal as $es) { ?>
                                        <tr>
                                            <td><?= $es['suc_Sucursal'] ?></td>
                                            <td>
                                                <?= $es['num'] ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Personal por Departamento</strong></h2>
                        </div>
                        <div class="body table-responsive">
                            <table class="table table-hover m-b-0">
                                <thead>
                                    <tr>
                                        <th>Departamento</th>
                                        <th>N° Empleados</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($empleadosDepartamento as $ed) { ?>
                                        <tr>
                                            <td><?= $ed['dep_Nombre'] ?></td>
                                            <td>
                                                <?= $ed['num'] ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="header">
                            <h2><strong>Personal por Antigüedad</strong></h2>
                        </div>
                        <div class="body table-responsive">
                            <table class="table table-hover m-b-0">
                                <thead>
                                    <tr>
                                        <th>Antigüedad</th>
                                        <th>Empleados</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($empleadosAntiguedad as $ea) { ?>
                                        <tr>
                                            <td><?= $ea['antiguedad_anios'] ?></td>
                                            <td>
                                                <?= $ea['num'] ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
<!--Modal info permisos-->
<div class="modal fade in" id="modalInfoPermisos" style="background-color:rgba(10, 10, 10, 0.5);">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b class="iconsminds-next"></b> Información de permisos</h5>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-borderless mb-0 text-center" style="width:inherit;">
                            <thead>
                                <tr>
                                    <th>Tipo de permiso</th>
                                    <th>Días otorgados</th>
                                    <th>Reglas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Aniversario de boda</td>
                                    <td>1</td>
                                    <td>Solo el día de aniversario proporcionado y que sea dia habil.</td>
                                </tr>
                                <tr>
                                    <td>Cumpleaños (solteros)</td>
                                    <td>1</td>
                                    <td>Solo tu fecha de cumpleaños y que sea dia habil.</td>
                                </tr>
                                <tr>
                                    <td>Matrimonio (solteros proximos a casarse)</td>
                                    <td>2</td>
                                    <td>Dos días, el día de la boda (civil o religiosa) según lo declare el empleado y el día inmediato siguiente hábil (No transferible)</td>
                                </tr>
                                <tr>
                                    <td>Por fallecimiento</td>
                                    <td>3</td>
                                    <td>Ninguna</td>
                                </tr>
                                <tr>
                                    <td>Por nacimiento (hombres)</td>
                                    <td>5</td>
                                    <td>Ninguna</td>
                                </tr>
                                <tr>
                                    <td>Sin goce de sueldo</td>
                                    <td>(no mayor a 30 días)</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Modal info retardos-->
<div class="modal fade in" id="modalInfoRetardos" style="background-color:rgba(10, 10, 10, 0.5);">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><b class="iconsminds-next"></b> Información de retardos</h5>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 text-justify">

                        <p>Segun el Art. 23:<br>
                            A los Empleados operarios que no cumplan lo dispuesto en el artículo 9 del presente Reglamento, relativo a la puntualidad, les serán aplicables en su orden las siguientes sanciones:
                        </p>
                        <ul class="">
                            <li>I. Amonestación por escrito al Empleado que en el término de un periodo menual tenga descuentos en su bono por puntualidad en ambas quincenas.</li>
                            <li>II. Se decontará 1 día de salario al empleado que al término de un periodo bimetral compute descuentos en las cuatro quincenas.</li>
                            <li>III. En caso de que se acumulen tres amonestaciones por escrito, en el término de tres meses consecutivos, el Empleado se hará acreedor a un descuento de tres días de salario.</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>