<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<style>
    .picture {
        width: 120px;
        height: 120px;
        background-color: #d7d7d7;
        border: 2px solid transparent;
        color: #FFFFFF;
        border-radius: 50%;
        margin: 5px auto;
        overflow: hidden;
        transition: all 0.2s;
        -webkit-transition: all 0.2s;
    }

    .picture-container {
        position: relative;
        cursor: pointer;
        text-align: center;
    }


    .doc>input[type="file"] {
        cursor: pointer;
        display: block;
        height: 100%;
        left: 0;
        opacity: 0 !important;
        position: absolute;
        top: 0;
        width: 100%;
        text-align: center;
    }


    #lblEye {
        font-size: 15px;
        position: absolute;
        right: 15px;
        bottom: 10px;
        cursor: pointer;
    }

    .invalid {
        padding-left: 22px;
        line-height: 24px;
        color: #ec3f41;
    }

    .valid {
        padding-left: 22px;
        line-height: 24px;
        color: #3a7d34;
    }

    #pswd_info {
        display: none;
    }
</style>
<?php
$val_Puesto = '';
$val_Horario = '';
$val_Contrato = '';
$val_Genero = '';
$val_Edad = '';
$val_EstadoCivil = '';
$val_Idioma = '';
$val_nivelIdioma = '';
$val_Escolaridad = '';
$val_Experiencia = '';
$val_Departamento = '';
$val_objetivo = '';
$val_ingreso = '';
$val_nacimiento = '';
$val_curp = '';
$val_rfc = '';
$val_nss = '';
$val_telefono = '';
$val_conocimientos = '';
if (isset($perfilPuesto)) {
    $val_Puesto = isset($perfilPuesto['puesto']) ? trim($perfilPuesto['puesto']) : "";
    $val_Horario = isset($perfilPuesto['horario']) ? trim($perfilPuesto['horario']) : "";
    $val_Contrato = isset($perfilPuesto['tipoContrato']) ? trim($perfilPuesto['tipoContrato']) : "";
    $val_Genero = isset($perfilPuesto['genero']) ? trim($perfilPuesto['genero']) : "";
    $val_Edad = isset($perfilPuesto['edad']) ? trim($perfilPuesto['edad']) : "";
    $val_EstadoCivil = isset($perfilPuesto['estadoCivil']) ? trim($perfilPuesto['estadoCivil']) : "";
    $val_Idioma = isset($perfilPuesto['idioma']) ? trim($perfilPuesto['idioma']) : "";
    $val_nivelIdioma = isset($perfilPuesto['idiomaNivel']) ? trim($perfilPuesto['idiomaNivel']) : "";
    $val_Escolaridad = isset($perfilPuesto['escolaridad']) ? trim($perfilPuesto['escolaridad']) : "";
    $val_Experiencia = isset($perfilPuesto['aniosExperiencia']) ? trim($perfilPuesto['aniosExperiencia']) : "";
    $val_Departamento = isset($perfilPuesto['departamento']) ? trim($perfilPuesto['departamento']) : "";
    $val_objetivo = isset($perfilPuesto['objetivo']) ? trim($perfilPuesto['objetivo']) : "";
    $val_ingreso = isset($perfilPuesto['ingreso']) ? trim($perfilPuesto['ingreso']) : "";
    $val_nacimiento = isset($perfilPuesto['nacimiento']) ? trim($perfilPuesto['nacimiento']) : "";
    $val_curp = isset($perfilPuesto['curp']) ? trim($perfilPuesto['curp']) : "";
    $val_rfc = isset($perfilPuesto['rfc']) ? trim($perfilPuesto['rfc']) : "";
    $val_nss = isset($perfilPuesto['nss']) ? trim($perfilPuesto['nss']) : "";
    $val_telefono = isset($perfilPuesto['telefono']) ? trim($perfilPuesto['telefono']) : "";
    $val_conocimientos = isset($perfilPuesto['conocimientos']) ? trim($perfilPuesto['conocimientos']) : "";
} //if


//alain - boton de exportar pdf
$db = \Config\Database::connect();
$puestoPDFbtn = "";
$puestoID = (int)session('puesto');
$perfiles = $db->query("SELECT COUNT(*) AS 'total' FROM perfilpuesto WHERE per_PuestoID=" . $puestoID)->getRowArray();
if ((int)$perfiles['total'] > 0) {
    $puestoPDFbtn = '<a class="btn btn-warning" href="' . base_url("PDF/perfilPuestoPdf/" . $puestoID) . '" ><i class="fas fa-file-pdf "></i> Exportar a PDF</a>';
}

?>
<div class="content pt-0">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <!-- meta -->
                <div class="profile-user-box card-box bg-dark">
                    <div class="row">
                        <div class="col-sm-6">

                            <span class="float-left mr-2">
                                <div class="thumb-lg member-thumb mx-auto">
                                    <img src="<?= fotoPerfil(encryptDecrypt('encrypt', session("id"))) ?>" class="rounded-circle avatar-xl img-thumbnail" alt="profile-image">
                                </div>
                            </span>
                            <div class="media-body text-white">
                                <h4 class=" text-white font-18"><?= isset($informacion['nombre']) ? trim($informacion['nombre']) : '' ?></h4>
                                <p class="font-13"><?= isset($informacion['puesto']) ? trim($informacion['puesto']) : '' ?></p>
                                <p class="font-13"><?= isset($informacion['departamento']) ? trim($informacion['departamento']) : '' ?></p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-right">
                                <a href="<?php

                                            echo base_url('Personal/expediente/' . encryptDecrypt('encrypt', session("id")));

                                            ?>" type="button" class="btn btn-light waves-effect">
                                    <i class="mdi mdi-folder-outline   mr-1"></i> Expediente
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ meta -->
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4">
                <!-- Personal-Information -->
                <div class="card-box">
                    <h4 class="header-title">Información personal</h4>
                    <div class="panel-body">
                        <div class="text-left">
                            <p class="text-muted font-13">
                                <strong>No. empleado:</strong>
                                <span>
                                    <?= isset($informacion['noEmpleado']) ? trim($informacion['noEmpleado']) : '' ?>
                                </span>
                            </p>
                            <p class="text-muted font-13">
                                <strong>Fecha de ingreso:</strong>
                                <span>
                                    <?= isset($informacion['ingreso']) ? trim($informacion['ingreso']) : '' ?>
                                </span>
                            </p>
                            <p class="text-muted font-13">
                                <strong>Fecha de nacimiento:</strong>
                                <span>
                                    <?= isset($informacion['nacimiento']) ? trim($informacion['nacimiento']) : '' ?>
                                </span>
                            </p>
                            <p class="text-muted font-13">
                                <strong>CURP:</strong>
                                <span>
                                    <?= isset($informacion['curp']) ? trim($informacion['curp']) : '' ?>
                                </span>
                            </p>
                            <p class="text-muted font-13">
                                <strong>RFC:</strong>
                                <span>
                                    <?= isset($informacion['rfc']) ? trim($informacion['rfc']) : '' ?>
                                </span>
                            </p>

                            <p class="text-muted font-13">
                                <strong>NSS:</strong>
                                <span>
                                    <?= isset($informacion['nss']) ? trim($informacion['nss']) : '' ?>
                                </span>
                            </p>

                            <p class="text-muted font-13">
                                <strong>Telefono:</strong>
                                <span>
                                    <?= isset($informacion['telefono']) ? trim($informacion['telefono']) : '' ?>
                                </span>
                            </p>

                            <p class="text-muted font-13">
                                <strong>Dirección:</strong>
                                <span>
                                    <?= isset($informacion['direccion']) ? trim($informacion['direccion']) : '' ?>
                                </span>
                            </p>

                            <p class="text-muted font-13">
                                <strong>Estado Civil:</strong>
                                <span>
                                    <?= isset($informacion['estadoCivil']) ? trim($informacion['estadoCivil']) : '' ?>
                                    <?php if($informacion['estadoCivil'] =='CASADO (A)'){
                                        echo shortDate($informacion['fechaMatrimonio'],' de ');
                                    } ?>
                                </span>
                            </p>

                        </div>
                    </div>
                    <hr>
                    <h4 class="header-title">Cambiar contraseña</h4>
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
                                    <li id="letter"><small>Al menos debería tener <span class="badge badge-dark">una letra</span></small></li>
                                    <li id="capital"><small>Al menos debería tener <span class="badge badge-dark">una letra en mayúsculas</span></small></li>
                                    <li id="number"><small>Al menos debería tener <span class="badge badge-dark">un número</span></small></li>
                                    <li id="length"><small>Debería tener <span class="badge badge-dark">8 carácteres</span> como mínimo</small></li>
                                </ul>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <button id="btnactualizarPw" type="button" class="btn btn-success waves-light waves-effect">
                                <i class="dripicons-checkmark pt-1"></i>
                                Actualizar
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Personal-Information -->
                <div class="card-box ribbon-box">
                    <div class="ribbon " style="background-color:#797979  ">Mi departamento</div>
                    <div class="clearfix"></div>
                    <div class="inbox-widget" style="overflow-y: auto; max-height: 370px">
                        <?php
                        if (isset($colaboradores)) {
                            if (count($colaboradores)) {

                                foreach ($colaboradores as $col) {
                                    $url = fotoPerfil(encryptDecrypt('encrypt', $col['emp_EmpleadoID']));
                                    $html = '<a href="#">';
                                    $html .= '<div class="inbox-item">';
                                    $html .= '<div class="inbox-item-img"><img src="' . $url . '" class="rounded-circle" alt=""></div>';
                                    $html .= '<p class="inbox-item-author">' . trim($col['emp_Nombre']) . '</p>';
                                    $html .= '<p class="inbox-item-text">' . trim($col['emp_Correo']) . '</p>';
                                    $html .= '</div>';
                                    $html .= '</a>';
                                    echo $html;
                                } //foreach
                            } else {
                                echo '
                                <div class="alert alert-light alert-dismissible bg-light text-dark border-0 fade show text-center" role="alert">
                                    No hay colaboradores para mostrar
                                </div>';
                            } //if count
                        } else {
                            echo '
                            <div class="alert alert-light alert-dismissible bg-light text-dark border-0 fade show text-center" role="alert">
                                No hay colaboradores para mostrar
                            </div>';
                        } //if isset
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="card-box tilebox-one">
                            <i class="dripicons-brightness-max float-right text-muted"></i>
                            <h6 class="text-muted text-uppercase mt-0">Vacaciones</h6>
                            <h2 class="" data-plugin="counterup"><?= $incidencias['vacaciones'] ?></h2>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card-box tilebox-one">
                            <i class="dripicons-bookmarks float-right text-muted"></i>
                            <h6 class="text-muted text-uppercase mt-0">Permisos</h6>
                            <h2 class=""><span data-plugin="counterup"><?= $incidencias['permisos'] ?></span></h2>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="card-box tilebox-one">
                            <i class="dripicons-pulse float-right text-muted"></i>
                            <h6 class="text-muted text-uppercase mt-0">Incapacidades</h6>
                            <h2 class="" data-plugin="counterup"><?= $incidencias['incapacidades'] ?></h2>
                        </div>
                    </div>
                </div>
                <div class="card-box">
                    <h4 class="header-title mb-3">Perfil de puesto</h4>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-1">
                                <label class="pr-2">Puesto:</label>
                                <span><?= $val_Puesto ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
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
                        <div class="col-md-6">
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
                        <div class="col-md-6">
                            <div class="form-group mb-1">
                                <label class="pr-2">Horario:</label>
                                <span><?= $val_Horario ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-1">
                                <label class="pr-2">Contrato:</label>
                                <span><?= $val_Contrato ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-1">
                                <label class="pr-2">Género:</label>
                                <span><?= $val_Genero ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-1">
                                <label class="pr-2">Edad:</label>
                                <span><?= $val_Edad ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-1">
                                <label class="pr-2">Estado civil:</label>
                                <span><?= $val_EstadoCivil ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-1">
                                <label class="pr-2">Idioma:</label>
                                <span><?= $val_Idioma ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-1">
                                <label class="pr-2">Nivel de idioma:</label>
                                <span><?= $val_nivelIdioma ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-1">
                                <label class="pr-2">Escolaridad:</label>
                                <span><?= $val_Escolaridad ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-1">
                                <label class="pr-2">Años experiencia:</label>
                                <span><?= $val_Experiencia ?></span>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group mb-1">
                                <label class="pr-6">Departamento:</label>
                                <span><?= $val_Departamento ?></span>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-1">
                                <label class="pr-2">Conocimientos:</label>
                                <p style="text-align: justify"><?= $val_conocimientos ?></p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-1">
                                <label class="pr-2">Objetivo:</label>
                                <p style="text-align: justify"><?= $val_objetivo ?></p>
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
                                $emptyFunciones = '<li><div class="alert alert-light text-center">No hay funciones para este puesto</div></li>';
                                if (isset($perfilPuesto)) {
                                    if (isset($perfilPuesto['funciones'])) {
                                        $funciones = json_decode($perfilPuesto['funciones'], true);
                                        $total = count($funciones);
                                        if ($total) {
                                            for ($i = 1; $i <= $total; $i++)
                                                echo '<li style="border-bottom: none; text-align: justify"><span>' . $i . '.-  ' . trim($funciones['F' . $i]) . '</span></li>';
                                        } else
                                            echo $emptyFunciones;
                                    } else
                                        echo $emptyFunciones;
                                } else
                                    echo $emptyFunciones;
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
                                $emptyCompetencias = '<li><div class="alert alert-light text-center">No hay competencias asignadas a este puesto</div></li>';
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
                                    } else
                                        echo $emptyCompetencias;
                                } else
                                    echo $emptyCompetencias;
                                ?>
                            </ul>
                        </div>
                        <div class="col-md-12 mb-2 text-right">
                            <?php
                            echo $puestoPDFbtn;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card-box">
                    <h4 class="header-title">Mis recibos de nómina</h4>
                    <div id="recibosNomina"></div>
                </div>
            </div>
        </div>
    </div> <!-- end container-fluid -->
</div> <!-- end content -->