<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div class="container-fluid">
    <div class="row clearfix">
        <div class="col-lg-4 col-md-12">
            <div class="card member-card">
                <div class="header l-blush-azul">
                    <h6 class="m-t-10"><?= session('nombre') ?></h6>
                </div>
                <div class="member-img">
                    <a href="#" class="">
                        <img src="<?= fotoPerfil(encryptDecrypt('encrypt', session('id'))); ?>" class="rounded-circle" alt="profile-image">
                    </a>
                </div>
                <div class="body">
                    <div class="col-12">
                        <p class="text-muted"><?= session('nombrePuesto') ?></p>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <p class="text-muted">Total de solicitudes</p>
                        </div>
                        <div class="col-4">
                            <h5>852</h5>
                            <small>Vacaciones</small>
                        </div>
                        <div class="col-4">
                            <h5>13k</h5>
                            <small>Permisos</small>
                        </div>
                        <div class="col-4">
                            <h5>234</h5>
                            <small>Incapacidades</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#about">Datos laborales</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#friends">Datos personales</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane body active" id="about">
                        <small class="text-muted">Usuario: </small>
                        <p><?= $informacion['username']; ?></p>
                        <hr>
                        <small class="text-muted">Correo: </small>
                        <p><?= isset($informacion['correo']) ? trim($informacion['correo']) : ''; ?></p>
                        <hr>
                        <small class="text-muted">Número de colaborador: </small>
                        <p><?= isset($informacion['noEmpleado']) ? trim($informacion['noEmpleado']) : '' ?></p>
                        <hr>
                        <small class="text-muted">Fecha de ingreso: </small>
                        <p><?= isset($informacion['ingreso']) ? longDate($informacion['ingreso'], ' de ') : '' ?></p>
                        <hr>
                        <small class="text-muted">Departamento: </small>
                        <p><?= isset($informacion['departamento']) ? trim($informacion['departamento']) : '' ?></p>
                        <hr>
                        <small class="text-muted">Jefe: </small>
                        <p><?= isset($informacion['jefe']) ? ucwords(strtolower($informacion['jefe'])) : '' ?></p>
                        <hr>
                        <div class="header">
                            <h2><strong>Cambiar contraseña</strong></h2>
                        </div>
                        <div class="panel-body pt-3">
                            <div class="form-group">
                                <strong class="text-muted">Usuario</strong>
                                <input type="text" class="form-control" value="<?= isset($informacion['username']) ? trim($informacion['username']) : '' ?>" readonly />
                            </div>
                            <div class="form-group">
                                <strong class="text-muted">Contraseña</strong>
                                <div style="position: relative">
                                    <input id="txtPassword" type="password" placeholder="Ecribe mínimo 8 caracteres." class="form-control" autocomplete="off" />
                                    <span id="lblEye" class="fa fa-eye-slash"></span>
                                </div>
                                <span id="lblPassword" style="font-size: 12px; color:#dd0100"></span>

                                <div id="pswd_info">
                                    <small>La contraseña debería cumplir con los siguientes requerimientos:</small>
                                    <ul>
                                        <li id="capital"><small>Al menos debería tener <div class="badge bg-dark" style="border-radius:10px;color:white;">una letra en mayúsculas</div></small></li>
                                        <li id="number"><small>Al menos debería tener <div class="badge bg-dark" style="border-radius:10px;color:white;">un número</div></small></li>
                                        <li id="length"><small>Debería tener <div class="badge bg-dark" style="border-radius:10px;color:white;">8 carácteres</div> como mínimo</small></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <button id="btnactualizarPw" type="button" class="btn btn-round btn-info waves-light waves-effect">
                                    <i class="dripicons-checkmark pt-1"></i>
                                    Actualizar
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane body" id="friends">
                        <small class="text-muted">Fecha de nacimiento: </small>
                        <p><?= isset($informacion['nacimiento']) ? longDate($informacion['nacimiento'], ' de ') : '' ?></p>
                        <hr>
                        <small class="text-muted">Telefono: </small>
                        <p><?= isset($informacion['telefono']) ? trim($informacion['telefono']) : '' ?></p>
                        <hr>
                        <small class="text-muted">Estado civil: </small>
                        <p><?= isset($informacion['estadoCivil']) ? trim($informacion['estadoCivil']) : '' ?></p>
                        <hr>
                        <?php if ($informacion['estadoCivil'] == 'CASADO (A)') { ?>
                            <small class="text-muted">CURP: </small>
                            <p><?= isset($informacion['fechaMatrimonio']) ? longDate($informacion['fechaMatrimonio'], ' de ') : '' ?></p>
                            <hr>
                        <?php } ?>
                        <small class="text-muted">CURP: </small>
                        <p><?= isset($informacion['curp']) ? trim($informacion['curp']) : '' ?></p>
                        <hr>
                        <small class="text-muted">RFC: </small>
                        <p><?= isset($informacion['rfc']) ? trim($informacion['rfc']) : '' ?></p>
                        <hr>
                        <small class="text-muted">NSS: </small>
                        <p><?= isset($informacion['nss']) ? trim($informacion['nss']) : '' ?></p>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-md-12">
            <div class="card">
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#project">Generales</a></li>
                    <!--<li class="nav-item"><a class="nav-link" data-toggle="tab" href="#timeline">Timeline</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#usersettings">Setting</a></li>-->
                </ul>
            </div>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="project">
                    <div class="row clearfix">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="card project_widget">
                                    <div class="header">
                                        <h2><strong>Mi departamento</strong><small class="text-muted"><?= session('departamentoNombre') ?></small></h2>
                                    </div>
                                    <div class="body">
                                        <ul class="list-unstyled team-info m-t-20">
                                            <li class="m-r-15"><small>Team</small></li>
                                            <?php $colaboradores = db()->query("SELECT emp_EmpleadoID,emp_Nombre FROM empleado WHERE emp_DepartamentoID=? AND emp_EmpleadoID != ?", [session('departamento'), session('id')])->getResultArray();
                                            if ($colaboradores) {
                                                foreach ($colaboradores as $col) {
                                                    echo '<li><img src="' . fotoPerfil(encryptDecrypt('encrypt', $col['emp_EmpleadoID'])) . '" alt="' . $col['emp_Nombre'] . '" title="' . $col['emp_Nombre'] . '"></li>';
                                                }
                                            } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="card project_widget">
                                    <div class="header">
                                        <h2><strong>Mis recibos de nomina</strong></h2>
                                    </div>
                                    <div class="body">
                                        <div id="recibosNomina"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="card project_widget">
                                <div class="header">
                                    <h2><strong>Perfil de puesto</strong></h2>
                                </div>
                                <div class="body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group mb-1">
                                                <label class="pr-2">Puesto:</label>
                                                <span><?= $val_Puesto ?? '' ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-1">
                                                <label class="pr-2">Reporta a:</label>
                                                <div class="bootstrap-tagsinput" style="border: none; padding: 0px">
                                                    <?php
                                                    if (isset($perfilPuesto)) {
                                                        if (isset($perfilPuesto['puestosReporta'])) {
                                                            $puestosReporta = $perfilPuesto['puestosReporta'];
                                                            if (count($puestosReporta)) {
                                                                foreach ($puestosReporta as $pue) {
                                                                    echo '<span class="tag badge badge-warning" >' . trim($pue['puesto']) . '</span>';
                                                                }
                                                            } else
                                                                echo '<span class="tag badge badge-warning">No hay información disponible</span>';
                                                        } else
                                                            echo '<span class="tag badge badge-warning">No hay información disponible</span>';
                                                    } else
                                                        echo '<span class="tag badge badge-warning">No hay información disponible</span>';
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-1">
                                                <label class="pr-2">Coordina a:</label>
                                                <div class="bootstrap-tagsinput" style="border: none; padding: 0px">
                                                    <?php
                                                    if (isset($perfilPuesto)) {
                                                        if (isset($perfilPuesto['puestosCoordina'])) {
                                                            $puestosCoordina = $perfilPuesto['puestosCoordina'];
                                                            if (count($puestosCoordina)) {
                                                                foreach ($puestosCoordina as $pue) {
                                                                    echo '<span class="tag badge badge-warning">' . trim($pue['puesto']) . '</span>';
                                                                }
                                                            } else
                                                                echo '<span class="tag badge badge-warning">No hay información disponible</span>';
                                                        } else
                                                            echo '<span class="tag badge badge-warning">No hay información disponible</span>';
                                                    } else
                                                        echo '<span class="tag badge badge-warning">No hay información disponible</span>';
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-1">
                                                <label class="pr-2">Horario:</label>
                                                <span><?= $val_Horario ?? '' ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-1">
                                                <label class="pr-2">Contrato:</label>
                                                <span><?= $val_Contrato ?? '' ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-1">
                                                <label class="pr-2">Género:</label>
                                                <span><?= $val_Genero ?? '' ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-1">
                                                <label class="pr-2">Edad:</label>
                                                <span><?= $val_Edad ?? '' ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-1">
                                                <label class="pr-2">Estado civil:</label>
                                                <span><?= $val_EstadoCivil ?? '' ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-1">
                                                <label class="pr-2">Idioma:</label>
                                                <span><?= $val_Idioma ?? '' ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-1">
                                                <label class="pr-2">Nivel de idioma:</label>
                                                <span><?= $val_nivelIdioma ?? '' ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-1">
                                                <label class="pr-2">Escolaridad:</label>
                                                <span><?= $val_Escolaridad ?? '' ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-1">
                                                <label class="pr-2">Años experiencia:</label>
                                                <span><?= $val_Experiencia ?? '' ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-1">
                                                <label class="pr-6">Departamento:</label>
                                                <span><?= $val_Departamento ?? '' ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-1">
                                                <label class="pr-2">Conocimientos:</label>
                                                <p style="text-align: justify"><?= $val_conocimientos ?? '' ?></p>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group mb-1">
                                                <label class="pr-2">Objetivo:</label>
                                                <p style="text-align: justify"><?= $val_objetivo ?? '' ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 mt-1">
                                            <label>Funciones</label>
                                        </div>
                                        <div class="col-md-12">
                                            <ul class="list-unstyled transaction-list  mb-4">
                                                <?php
                                                if (isset($perfilPuesto)) {
                                                    if (isset($perfilPuesto['funciones'])) {
                                                        $funciones = json_decode($perfilPuesto['funciones'], true);
                                                        $total = count($funciones);
                                                        if ($total) {
                                                            for ($i = 1; $i <= $total; $i++)
                                                                echo '<li class="text-muted" style="border-bottom: none; text-align: justify"><span>' . $i . '.-  ' . trim($funciones['F' . $i]) . '</span></li>';
                                                        } else
                                                        echo '<blockquote><p class="blockquote blockquote-primary"> No hay funciones para este puesto </p> </blockquote>';
                                                    } else
                                                    echo '<blockquote><p class="blockquote blockquote-primary"> No hay funciones para este puesto </p> </blockquote>';
                                                } else
                                                echo '<blockquote><p class="blockquote blockquote-primary"> No hay funciones para este puesto </p> </blockquote>';
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label>Competencias</label>
                                        </div>
                                        <div class="col-md-12">
                                            <ul class="list-unstyled transaction-list  mb-1">
                                                <?php
                                                if (isset($competenciasPuesto)) {
                                                    if (count($competenciasPuesto)) {
                                                        $i = 1;
                                                        foreach ($competenciasPuesto as $compue) {
                                                            $claves = $db->query("SELECT * FROM clavecompetencia WHERE cla_CompetenciaID=" . $compue['com_CompetenciaID'])->getResultArray();
                                                            echo '<li style="border-bottom: none;"><span>' . $i . '.-  ' . trim($compue['com_Nombre']) . '</span></li>';
                                                            $i++;

                                                            foreach ($claves as $clave) {
                                                                echo '<li style="border-bottom: none; padding-left: 30px">' . trim($clave['cla_ClaveAccion']) . '</li>';
                                                            }
                                                        }
                                                    } else {
                                                        echo '<blockquote><p class="blockquote blockquote-primary"> No hay competencias asignadas a este puesto </p> </blockquote>';
                                                    }
                                                } else {
                                                    echo '<blockquote><p class="blockquote blockquote-primary"> No hay competencias asignadas a este puesto </p> </blockquote>';
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                        <div class="col-md-12 mb-2 text-right">
                                            <?php
                                            echo $puestoPDFbtn ?? '';
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div role="tabpanel" class="tab-pane" id="timeline">
                </div>
                <div role="tabpanel" class="tab-pane" id="usersettings">
                </div>
            </div>
        </div>
    </div>
</div>