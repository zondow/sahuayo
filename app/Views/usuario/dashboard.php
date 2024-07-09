<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<?php $db = \Config\Database::connect(); ?>
<style>
    .fc-title {
        color: #ffffff;
    }

    .slimscroll {
        max-height: 400px !important;
        height: 500px !important;
    }

    .iconCalendario {
        width: 120px !important;
    }

    .swal-wide {
        width: 700px;
    }

    .wave {
        animation-name: wave-animation;
        /* Refers to the name of your @keyframes element below */
        animation-duration: 2.5s;
        /* Change to speed up or slow down */
        animation-iteration-count: infinite;
        /* Never stop waving :) */
        transform-origin: 70% 70%;
        /* Pivot around the bottom-left palm */
        display: inline-block;
    }

    @keyframes wave-animation {
        0% {
            transform: rotate(0.0deg)
        }

        10% {
            transform: rotate(14.0deg)
        }

        /* The following five values can be played with to make the waving more or less extreme */
        20% {
            transform: rotate(-8.0deg)
        }

        30% {
            transform: rotate(14.0deg)
        }

        40% {
            transform: rotate(-4.0deg)
        }

        50% {
            transform: rotate(10.0deg)
        }

        60% {
            transform: rotate(0.0deg)
        }

        /* Reset for the last half to pause */
        100% {
            transform: rotate(0.0deg)
        }
    }
</style>
<div class="content">
    <!-- Start Content-->
    <div class="container-fluid">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="card  text-center" style="background-image: url(https://thigo.mx/assets/video/banner_pumm.jpg) ;width: 100%; height: 300px;background-size: cover; background-position: center center;">
                        <video src="https://thigo.mx/assets/video/video_pumm.mp4" type="video" controls="controls" id="videoqatar" style="width: 40%;display:block;margin-left:auto;margin-right:auto;margin-top: auto;margin-bottom: auto;border-radius:20px;"></video>
                    </div>
                </div>
                <div class="col-md-<?= (date('m') == 12) ? 9 : 12; ?>">
                    <h4 class="font-weight-normal text-muted" style="margin-bottom: -10px !important;">
                        <?php
                        $horario = date('H:i');
                        if ($horario >= '06:00' && $horario <= '11:59') {
                            $mensaje = "Buenos días";
                            $icon = 'fe-sunrise';
                            $color = '#f7cd5d';
                        } elseif ($horario >= '12:00' && $horario <= '12:59') {
                            $mensaje = "Buen día";
                            $icon = 'fe-sun ';
                            $color = '#fce391';
                        } elseif ($horario >= '13:00' && $horario <= '18:59') {
                            $mensaje = "Buenas tardes";
                            $icon = 'fe-sunset';
                            $color = '#fb9062';
                        } elseif ($horario >= '19:00') {
                            $mensaje = "Buenas noches";
                            $icon = 'fe-moon';
                            $color = '#546bab';
                        } elseif ($horario <= '05:59') {
                            $mensaje = "Buenas noches";
                            $icon = 'fe-moon';
                            $color = '#546bab';
                        }
                        ?><?= $mensaje ?> <i class="<?= $icon ?>" style="color: <?= $color ?>;"></i>
                    </h4>
                    <h3 class="mb-4"><i class="mdi mdi-hand-right text-success wave"></i> <?= $welcome ?> </h3>
                </div>
                <?php if (date('m') == 12) { ?>
                    <div class="col-md-3">
                        <div class="card-box tilebox-one border border-primary " style="background-color: #0C1E42;">
                            <div class="christmas">
                                <h6 class="text-muted text-uppercase mt-0 text-center" style="padding-top: 82%;">Felices fiestas les desea el equipo de THIGO</h6>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="col-md-3">
                    <div class="card-box tilebox-one border border-primary">
                        <i class=" fas fa-umbrella-beach  float-right text-muted"></i>
                        <h6 class="text-muted text-uppercase mt-0">Dias de vacaciones</h6>
                        <h2><span data-plugin="counterup" id='vacaciones'></span> dias</h2>
                        <span class="text-muted">restantes</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card-box tilebox-one border border-primary">
                        <i class=" fas fa-business-time  float-right text-muted"></i>
                        <h6 class="text-muted text-uppercase mt-0">Total de horas extra</h6>
                        <h2 data-plugin="counterup" id="horasExtra"></h2>
                        <span class="text-muted">a la fecha</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card-box tilebox-one border border-primary">
                        <i class="fas fa-percent float-right text-muted"></i>
                        <h6 class="text-muted text-uppercase mt-0">Prima vacacional</h6>
                        <h2><span data-plugin="counterup" id='prima'></span>%</h2>
                        <span class="badge badge-primary antiguedad"> </span> <span class="text-muted">años de antiguedad</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card-box tilebox-one border border-primary">
                        <i class="icon-rocket  float-right text-muted"></i>
                        <h6 class="text-muted text-uppercase mt-0">Aguinaldo</h6>
                        <h2><span data-plugin="counterup" id='aguinaldo'></span> dias</h2>
                        <span class="badge badge-primary antiguedad"> </span> <span class="text-muted">años de antiguedad</span>
                    </div>
                </div>
                <?php
                switch ($retardos) {
                    case 0:
                        $estilo = 'bg-success';
                        break;
                    case 1:
                        $estilo = 'bg-success';
                        break;
                    case 2:
                        $estilo = 'bg-warning';
                        break;
                    case 3:
                        $estilo = 'bg-warning';
                        break;
                    default:
                        $estilo = 'bg-danger';
                        break;
                }
                ?>
                <div class="col-md-6 col-xl-4 text-left verInfoRetardo" title="Click para mas información">
                    <div class="card-box widget-flat border-success <?= $estilo ?> text-white">
                        <i class="fas fa-clock" style="right:0 !important;left:auto !important;"></i>
                        <h3 class="text-white"><?= $retardos ?></h3>
                        <p class="text-uppercase font-13 mb-2 font-weight-bold">Retardos</p>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4 text-left verInfoPermisos" title="Click para mas información">
                    <div class="card-box widget-flat border-success bg-default text-black">
                        <i class="fas fa-clipboard-check" style="right:0 !important;left:auto !important;"></i>
                        <h3 class="text-black">Permisos</h3>
                        <p class="text-uppercase font-13 mb-2 font-weight-bold">informacion</p>
                    </div>
                </div>
                <div class="col-md-6 col-xl-4 text-left verMisSanciones" title="Click para mas información">
                    <div class="card-box widget-flat border-success text-white" style="background-color: #345a8f !important;">
                        <i class="fas fa-exclamation" style="right:0 !important;left:auto !important;"></i>
                        <h3 class="text-white"><?= $misSanciones ?></h3>
                        <p class="text-uppercase font-13 mb-2 font-weight-bold">sanciones</p>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="card-box">
                        <h2 class="header-title">Fechas importantes</h2>
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
                            <span class="badge badge-purple badge-pill font-13">Cumpleaños</span>
                            <span class="badge badge-primary badge-pill font-13">Aniversario</span>
                            <span class="badge badge-success badge-pill font-13">Día inhabil</span>
                            <span class="badge badge-danger badge-pill font-13">Día inhabil de ley</span>
                        </div>
                        <div id="calendarAgenda"></div>
                    </div>
                </div>
            </div>
            <?php if ($anuncio) { ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card-box tilebox-one border ">
                            <h2 class="header-title">Anuncios </h2>
                            <?= getAnuncio($anuncio); ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <div class="row">
                <?php if (isJefe()) {
                    $col = 'col-md-8'; ?>
                    <div class="col-md-4">
                        <div class="card-box" style="height: 500px;">
                            <h4 class="header-title mb-3">Colaboradores a cargo</h4>

                            <div class="inbox-widget slimscroll" style="max-height: 370px;">
                                <?php
                                if (!empty($colaboradores)) {
                                    foreach ($colaboradores as $colaborador) {
                                        $sql = "SELECT E.emp_EmpleadoID AS 'id', E.emp_Nombre AS 'nombre','Permiso' AS 'evento',
                                            P.per_FechaInicio AS 'inicio', P.per_FechaFin AS 'fin','permiso' AS 'tipo' FROM empleado E
                                        JOIN permiso P ON P.per_EmpleadoID=E.emp_EmpleadoID
                                     WHERE E.emp_EmpleadoID= ?  AND P.per_Estado='AUTORIZADO_RH'
                                        AND CURDATE() BETWEEN per_FechaInicio AND P.per_FechaFin
                                        ORDER BY inicio LIMIT 1";
                                        $permiso = $db->query($sql, array($colaborador['emp_EmpleadoID']))->getRowArray();

                                        $sql1 = "SELECT E.emp_EmpleadoID AS 'id', E.emp_Nombre AS 'nombre','Vacaciones' AS 'evento',
                                            V.vac_FechaInicio AS 'inicio', V.vac_FechaFin AS 'fin','vacacion' AS 'tipo' FROM empleado E
                                        JOIN vacacion V ON V.vac_EmpleadoID=E.emp_EmpleadoID
                                     WHERE E.emp_EmpleadoID= ? AND V.vac_Estatus ='AUTORIZADO_RH'
                                        AND  CURDATE() BETWEEN V.vac_FechaInicio AND V.vac_FechaFin
                                         ORDER BY inicio LIMIT 1";
                                        $vacaciones = $db->query($sql1, array($colaborador['emp_EmpleadoID']))->getRowArray();

                                        $sql2 = "SELECT E.emp_EmpleadoID AS 'id', E.emp_Nombre AS 'nombre','Incapacidad' AS 'evento',
                                            I.inc_FechaInicio AS 'inicio', I.inc_FechaFin AS 'fin','incapacidad' AS 'tipo' FROM empleado E
                                        JOIN incapacidad I ON I.inc_EmpleadoID=E.emp_EmpleadoID
                                     WHERE E.emp_EmpleadoID= ? AND  I.inc_Estatus = 'Autorizada'
                                       AND  CURDATE() BETWEEN I.inc_FechaInicio AND I.inc_FechaFin
                                         ORDER BY inicio LIMIT 1";
                                        $incapacidad = $db->query($sql2, array($colaborador['emp_EmpleadoID']))->getRowArray();

                                        $url = fotoPerfil(encryptDecrypt('encrypt', $colaborador['emp_EmpleadoID']));
                                        $tipo = '<div class="badge badge-pill badge-success">Activo</div>';
                                        $periodo = "";

                                        if (!empty($permiso)) {
                                            $tipo = '<div class="badge badge-pill badge-info">Permiso</div>';
                                            $periodo = shortDate($permiso['inicio'], ' de ') . " al " . shortDate($permiso['fin'], ' de ');
                                        } else if (!empty($vacaciones)) {
                                            $tipo = '<div class="badge badge-pill badge-dark">Vacaciones</div>';
                                            $periodo = shortDate($vacaciones['inicio'], ' de ') . " al " . shortDate($vacaciones['fin'], ' de ');
                                        } else if (!empty($incapacidad)) {
                                            $tipo = '<div class="badge badge-pill badge-warning">Incapacidad</div>';
                                            $periodo = shortDate($incapacidad['inicio'], ' de ') . " al " . shortDate($incapacidad['fin'], ' de ');
                                        }
                                ?>
                                        <a href="#" class="verInfoIncidencias" data-id="<?= encryptDecrypt('encrypt', $colaborador['emp_EmpleadoID']) ?>">
                                            <div class="inbox-item">
                                                <div class="text-right">
                                                    <p class="inbox-item-date"><?= $tipo ?></p>
                                                </div>
                                                <div class="inbox-item-img"><img src="<?= $url ?>" class="rounded-circle shadow" alt=""></div>
                                                <p class="inbox-item-author"><?= $colaborador['emp_Nombre'] ?></p>
                                                <p class="inbox-item-text"><?= $periodo ?></p>

                                            </div>
                                        </a>
                                <?php }
                                } ?>
                            </div>
                        </div>
                    </div>
                <?php } else {
                    $col = 'col-md-12';
                }
                if ($galeria) { ?>
                    <div class="<?= $col ?>">
                        <div class="card-box">
                            <h4 class="header-title mb-3"> <?= strtoupper($galeria['gal_Nombre']) ?> </h4>
                            <div class="fotorama" data-autoplay="true">
                                <?php $fotografias = galeriaFotos();
                                foreach ($fotografias as $foto) { ?>
                                    <img src="<?= $foto ?>">
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                <?php }


                if (session('puesto') === '16' || session('puesto') === '1') { ?>
                    <div class="col-md-8">
                        <div class="card-box">
                            <h2 class="header-title">Incidencias del personal <?= session('puesto') === '16' ? 'operativo' : ''; ?> </h2>
                            <div class="col-md-12 text-center">
                                <span class="badge badge-primary badge-pill font-13">Vacaciones</span>
                                <span class="badge badge-success badge-pill font-13">Permisos</span>
                                <span class="badge badge-dark badge-pill font-13">Incapacidades</span>
                            </div>
                            <div id="calendarOperativo"></div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<!--Modales-->
<div class="modal fade in" id="modalInfoIncidencias" style="background-color:rgba(10, 10, 10, 0.5);">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><b class="iconsminds-next"></b> Información de Incidencias</h4>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card" style="border-color:#5a6771;">
                            <div class="card-body text-center">
                                <div class="inbox-item-img">
                                    <img id="fotoPefil" src="" class="rounded-circle shadow" style="width: 60%" alt="">
                                </div>
                                <h4 class="card-title" id="empleadoNombre"></h4>
                                <h5 class="text-muted" id="puestoEmpleado"></h5>
                            </div>
                            <ul class="list-group list-group-flush text-center">
                                <label>Fecha de ingreso</label>
                                <li class="list-group-item" id="FIngreso"></li>
                                <label>Antigüedad</label>
                                <li class="list-group-item" id="Antiguedad"></li>
                            </ul>
                            <ul class="list-group list-group-flush text-center">
                                <li class="list-group-item" id="verKardexColab">
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <div class='col-m-4'>
                                    <div class='card-box widget-flat border-warning bg-warning text-white'>
                                        <i class='fas fa-umbrella-beach '></i>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h3 class='text-white'>Días de Vacaciones</h3>
                                            </div>
                                            <div class="col-md-4">
                                                <h3 class='text-white' id="vacCorrespondientes"></h3>
                                                <p class='text-uppercase font-13 mb-2 font-weight-bold'>correspondientes</p>
                                            </div>
                                            <div class="col-md-4">
                                                <h3 class='text-white' id="vacTomados"></h3>
                                                <p class='text-uppercase font-13 mb-2 font-weight-bold'>tomados</p>
                                            </div>
                                            <div class="col-md-4">
                                                <h3 class='text-white' id="vacPendientes"></h3>
                                                <p class='text-uppercase font-13 mb-2 font-weight-bold'>pendientes</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class='col-m-4'>
                                    <div class='card-box widget-flat border-success bg-success text-white'><i class='fas fa-calendar-day  '></i>
                                        <h3 class='text-white' id="diasPTomados"></h3>
                                        <p class='text-uppercase font-13 mb-2 font-weight-bold'>Días de permisos tomados</p>
                                    </div>
                                </div>
                                <!--<div class='col-m-4'>
                                    <div class='card-box widget-flat border-info bg-info text-white' style="background-color: #1d9add !important;border-color:#1d9add !important;">
                                        <i class='far fa-clock '></i>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h3 class='text-white' id="horas"></h3>
                                                <p class='text-uppercase font-13 mb-2 font-weight-bold'>Horas extra acumuladas</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Modal info retardos-->
<div class="modal fade in" id="modalInfoRetardos" style="background-color:rgba(10, 10, 10, 0.5);">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><b class="iconsminds-next"></b> Información de retardos</h4>
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
            <div class="modal-footer">
                <a href="<?= base_url('PDF/reporteIncidencias/' . encryptDecrypt('encrypt', session('id'))) ?>" class="btn btn-primary waves-effect" target="_blank"><i class="mdi mdi-calendar-account"></i> Ver kardex</a>
            </div>
        </div>
    </div>
</div>
<!--Modal info permisos-->
<div class="modal fade in" id="modalInfoPermisos" style="background-color:rgba(10, 10, 10, 0.5);">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><b class="iconsminds-next"></b> Información de permisos</h4>
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