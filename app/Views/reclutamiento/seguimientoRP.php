<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<link href="<?= base_url("assets/plugins/fileinput/css/fileinput.css") ?>" media="all" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">
<link href="<?= base_url("assets/plugins/fileinput/themes/explorer-fas/theme.css") ?>" media="all" rel="stylesheet" type="text/css" />
<script src="<?= base_url("assets/plugins/fileinput/js/fileinput.js") ?>" type="text/javascript"></script>
<script src="<?= base_url("assets/plugins/fileinput/js/locales/es.js") ?>" type="text/javascript"></script>
<script src="<?= base_url("assets/plugins/fileinput/themes/fas/theme.js") ?>" type="text/javascript"></script>
<script src="<?= base_url("assets/plugins/fileinput/themes/explorer-fas/theme.js") ?>" type="text/javascript"></script>

<style>
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }

    .select2-container {
        width: 100% !important;
    }

    /* scrolltable rules */
    .table_fija {
        margin-top: 20px;
        display: inline-block;
        overflow: auto;
    }

    .th_fija div {
        margin-top: -20px;
        position: absolute;
    }

    /* design */
    .table_fija {
        border-collapse: collapse;
    }

    .tr_fja:nth-child(even) {
        background: #EEE;
    }

    .dtp div.dtp-date,
    .dtp div.dtp-time {
        background-color: #001689 !important;
    }

    .dtp>.dtp-content>.dtp-date-view>header.dtp-header {
        background-color: #001689 !important;
    }

    .dtp .p10>a {
        color: #f8e018 !important;
    }

    .dtp table.dtp-picker-days tr>td>a.selected {
        background: #f8e018 !important;
    }
</style>


<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card-box text-center" style="border-radius: 15px">
                            <h4 class="text-uppercase font-weight-bold" style="color: #00acc1 !important;">Información de la solicitud</h4>
                        </div>
                    </div>
                    <div class="col-12 table-responsive">
                        <table class="table table-bordered table-striped ">
                            <tbody>
                                <tr>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <div class="header">
                                            <h2><strong>Puesto:</strong></h2>
                                        </div>
                                    </td>
                                    <?php
                                    $nuevoP = '';
                                    if ($solicitud['sol_Puesto'] === 'Nuevo') {
                                        $nuevoP = '(Nuevo Puesto) ' . $solicitud['sol_NuevoPuesto'];
                                    } ?>
                                    <td colspan="5" class="text-center" style="vertical-align: middle;"><?= $nuevoP . $solicitud['pue_Nombre'] ?></td>
                                </tr>
                                <tr>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <div class="header">
                                            <h2><strong>Área:</strong></h2>
                                        </div>
                                    </td>
                                    <?php
                                    $area = '';
                                    if ($solicitud['sol_AreaVacanteID'] > 0) {
                                        $area = $solicitud['are_Nombre'];
                                    } else {
                                        $area = $solicitud['sol_NuevaArea'];
                                    }
                                    ?>
                                    <td colspan="2" class="text-center" style="vertical-align: middle;"><?= $area ?></td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <div class="header">
                                            <h2><strong>Departamento:</strong></h2>
                                        </div>
                                    </td>
                                    <?php
                                    $departamento = '';
                                    if ($solicitud['sol_DepartamentoVacanteID'] > 0) {
                                        $departamento = $solicitud['dep_Nombre'];
                                    } else {
                                        $departamento = $solicitud['sol_NuevoDepartamento'];
                                    }
                                    ?>
                                    <td colspan="2" class="text-center" style="vertical-align: middle;"><?= $departamento ?></td>
                                </tr>
                                <tr>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <div class="header">
                                            <h2><strong>Solicito:</strong></h2>
                                        </div>
                                    </td>
                                    <td colspan="2" class="text-center" style="vertical-align: middle;"><?= $solicitud['emp_Nombre'] ?></td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <div class="header">
                                            <h2><strong>Fecha de ingreso:</strong></h2>
                                        </div>
                                    </td>
                                    <td colspan="2" class="text-center" style="vertical-align: middle;"><?= longDate($solicitud['sol_FechaIngreso'], ' de ') ?></td>
                                </tr>
                                <tr>
                                    <?php switch ($solicitud['sol_Contrato']) {
                                        case 'Determinado':
                                            $colspan = 2;
                                            break;
                                        case 'Indeterminado':
                                            $colspan = 4;
                                            break;
                                    }
                                    ?>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <div class="header">
                                            <h2><strong>Contrato:</strong></h2>
                                        </div>
                                    </td>
                                    <td colspan="<?= $colspan ?>" class="text-center" style="vertical-align: middle;"><?= $solicitud['sol_Contrato'] ?></td>
                                    <?php if ($solicitud['sol_Contrato'] === 'Determinado') { ?>
                                        <td class="text-center" style="vertical-align: middle;">
                                            <div class="header">
                                                <h2><strong>Tiempo:</strong></h2>
                                            </div>
                                        </td>
                                        <td colspan="<?= $colspan ?>" class="text-center" style="vertical-align: middle;"><?= $solicitud['sol_TiempoContrato'] ?></td>
                                    <?php } ?>
                                </tr>
                                <tr>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <div class="header">
                                            <h2><strong>Escolaridad:</strong></h2>
                                        </div>
                                    </td>
                                    <td class="text-center" style="vertical-align: middle;"><?= $solicitud['sol_Escolaridad'] ?></td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <div class="header">
                                            <h2><strong>Especialidad:</strong></h2>
                                        </div>
                                    </td>
                                    <?php
                                    $esp = '';
                                    if (!empty($solicitud['sol_EspecificarCarreraTC'])) {
                                        $esp .= $solicitud['sol_EspecificarCarreraTC'] . ' ';
                                    }
                                    if (!empty($solicitud['sol_EspecificarCarreraProf'])) {
                                        $esp .= $solicitud['sol_EspecificarCarreraProf'] . ' ';
                                    }
                                    if (!empty($solicitud['sol_Postgrado'])) {
                                        $esp .= $solicitud['sol_Postgrado'] . ' ';
                                    }
                                    if (!empty($solicitud['sol_Otro'])) {
                                        $esp .= $solicitud['sol_Otro'] . ' ';
                                    }
                                    ?>
                                    <td class="text-center" style="vertical-align: middle;"><?= $esp ?></td>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <div class="header">
                                            <h2><strong>Experiencia:</strong></h2>
                                        </div>
                                    </td>
                                    <?php
                                    $experiencia = $solicitud['sol_Experiencia'];
                                    if ($solicitud['sol_AnosExp'] > 0) {
                                        $experiencia .= '<br>Años exp:' . $solicitud['sol_AnosExp'];
                                    }
                                    if (!empty($solicitud['sol_AreaExp'])) {
                                        $experiencia .= ' <br>Área:' . $solicitud['sol_AreaExp'];
                                    }
                                    ?>
                                    <td class="text-center" style="vertical-align: middle;"><?= $experiencia ?></td>
                                <tr>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <div class="header">
                                            <h2><strong>Objetivo del puesto:</strong></h2>
                                        </div>
                                    </td>
                                    <td colspan="5" class="text-center" style="vertical-align: middle;"><?= $solicitud['sol_EspPerfilPuesto'] ?></td>
                                </tr>
                                <tr>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <div class="header">
                                            <h2><strong>Enlace del prescreening:</strong></h2>
                                        </div>
                                    </td>
                                    <td colspan="6" class="text-center" style="vertical-align: middle;">
                                        <?php echo ($solicitud['sol_Estatus'] == 1) ? base_url('Reclutamiento/prescreening/' . $encryptedID) : '<span class="badge badge-danger">Solicitud Terminada</span>'; ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>


                    <hr style="width:100%;text-align:left;margin-left:0">
                    <div class="col-md-12 mt-2">
                        <ul class="nav nav-tabs">
                            <li class="nav-item" style="width: 20%; text-align:center;"><a href="#noaptos" class="nav-link" data-toggle="tab"><i class="zmdi zmdi-mood-bad"></i> No aptos</a></li>
                            <li class="nav-item" style="width: 20%; text-align:center;"><a href="#candidatos" class="nav-link <?= $tabcandidato ?>" data-toggle="tab"><i class="zmdi zmdi-accounts-list"></i> Candidatos</a></li>
                            <li class="nav-item" style="width: 20%; text-align:center;"><a href="#entrevista" class="nav-link <?= $tabentrevista ?>" data-toggle="tab"><i class="zmdi zmdi-comments"></i> Entrevista</a></li>
                            <li class="nav-item" style="width: 20%; text-align:center;"><a href="#psicometria" class="nav-link <?= $tabpsico ?>" data-toggle="tab"><i class="fas fa-brain"></i> Psicometría</a></li>
                            <li class="nav-item" style="width: 20%; text-align:center;"><a href="#final" class="nav-link <?= $tabfinal ?>" data-toggle="tab"><i class="zmdi zmdi-flag"></i> Selección Final</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane show " id="noaptos">
                                <div class="col-12 table-responsive">
                                    <table id="tblParticipantes" class="nowrap table mt-4 table-hover m-0 table-centered datatable">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Celular</th>
                                                <th>Correo</th>
                                                <th>Rechazado en</th>
                                                <th>Observación de rechazo</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($candidatos as $candidato) {
                                                if ($candidato['can_Estatus'] === 'RECHAZADO_REVISION' || $candidato['can_Estatus'] === 'RECHAZADO_ENTREVISTA' || $candidato['can_Estatus'] === 'RECHAZADO_PSICOMETRIA' || $candidato['can_Estatus'] === 'CARTERA' && $candidato['can_HitorialRechazo'] === '1') { ?>
                                                    <tr>
                                                        <td><?= $candidato['can_Nombre'] ?></td>
                                                        <td><?= $candidato['can_Telefono'] ?></td>
                                                        <td><?= $candidato['can_Correo'] ?></td>
                                                        <td>
                                                            <?php if ($candidato['can_Estatus'] === 'RECHAZADO_ENTREVISTA') { ?>
                                                                <span class="badge badge-danger">Rechazado en Entrevista</span>
                                                            <?php } elseif ($candidato['can_Estatus'] === 'RECHAZADO_PSICOMETRIA') { ?>
                                                                <span class="badge badge-danger">Rechazado en Psicometría</span>
                                                            <?php } elseif ($candidato['can_Estatus'] === 'RECHAZADO_REVISION') { ?>
                                                                <span class="badge badge-danger">Rechazado en Revision</span>
                                                            <?php } elseif ($candidato['can_Estatus'] === 'CARTERA') { ?>
                                                                <span class="badge badge-info">Rechazado y agregado a cartera</span>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <?= $candidato['can_Rechazo'] ?>

                                                        </td>
                                                        <td>
                                                            <button class="btn btn-info observacionesBtn btn-icon btn-icon-mini btn-round hidden-sm-down" data-id="<?= encryptDecrypt('encrypt', $candidato['can_CandidatoID']) ?>" style="color:#FFFFFF;" title="Agregar Observaciones"><i class=" zmdi zmdi-comment-alt-text"></i></button>
                                                            <?php if ($candidato['can_Estatus'] != 'CARTERA') { ?>
                                                                <button data-candidato="<?= $candidato['can_Nombre'] ?>" data-id="<?= encryptDecrypt('encrypt', $candidato['can_CandidatoID']) ?>" data-estatus="<?= $candidato['can_Estatus'] ?>" class="btn btn-warning btn-icon btn-icon-mini btn-round hidden-sm-down carteraBtn " style="color:#FFFFFF;" title="Guardar en cartera"><i class="fas fa-user-plus "></i></button>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                            <?php }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane show <?= $tabcandidato ?>" id="candidatos">
                                <div class="row">
                                    <?php if ($solicitudP['sol_Estatus'] > 0) { ?>
                                        <div class="col-3" style="padding-bottom: 2%">
                                            <a class="btn btn-success btn-round addCandidato" title="Agregar Candidato" data-id="<?= encryptDecrypt('encrypt', $solicitud['sol_SolicitudPersonalID']) ?>" type="button" style="color: #ffffff;"><i class="dripicons-plus" style="top: 2px !important; position: relative"></i> Agregar Candidatos</a>
                                        </div>

                                    <?php } ?>
                                </div>
                                <div class="col-12 table-responsive">
                                    <table id="tblParticipantes" class="nowrap table mt-4 table-hover m-0 table-centered datatable">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Celular</th>
                                                <th>Correo</th>
                                                <th width="5%">Autorizar/Rechazar</th>
                                                <th width="15%">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($candidatos as $candidato) {
                                                if ($candidato['can_Estatus'] === 'REVISION') { ?>
                                                    <?php $urlcv = CVCandidato($candidato['can_SolicitudPersonalID'], $candidato['can_CandidatoID'])[0];
                                                    ?>
                                                    <tr>

                                                        <td><?= $candidato['can_Nombre'] ?></td>
                                                        <td><?= $candidato['can_Telefono'] ?></td>
                                                        <td><?= $candidato['can_Correo'] ?></td>
                                                        <td>
                                                            <button data-id="<?= encryptDecrypt('encrypt', $candidato['can_CandidatoID']) ?>" data-estatus="AUT_ENTREVISTA" class="btn btn-success autorizarBtn btn-icon btn-icon-mini btn-round hidden-sm-down" style="color:#FFFFFF;border-color:#55c927;background-color: #55c927 !important;" title="Autorizar"><i class="zmdi zmdi-check"></i></button>
                                                            <button data-id="<?= encryptDecrypt('encrypt', $candidato['can_CandidatoID']) ?>" data-estatus="RECHAZADO_REVISION" class="btn btn-danger rechazarBtn btn-icon btn-icon-mini btn-round hidden-sm-down" style="color:#FFFFFF" title="Rechazar"><i class="zmdi zmdi-close "></i></button>
                                                        </td>
                                                        <td>
                                                            <button href="<?= $urlcv ?>" class="btn btn-warning show-pdf btn-icon btn-icon-mini btn-round hidden-sm-down" data-title="CV de <?= strtoupper($candidato['can_Nombre']) ?>" style="color:#FFFFFF;" title="Ver CV"><i class="zmdi zmdi-local-printshop"></i></button>
                                                            <button class="btn btn-info observacionesBtn btn-icon btn-icon-mini btn-round hidden-sm-down" data-id="<?= encryptDecrypt('encrypt', $candidato['can_CandidatoID']) ?>" style="color:#FFFFFF;" title="Agregar Observaciones"><i class=" zmdi zmdi-comment-alt-text"></i></button>
                                                        </td>
                                                    </tr>
                                            <?php }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane show <?= $tabentrevista ?>" id="entrevista">
                                <div class="col-12 table-responsive">
                                    <table id="tblParticipantes" class="nowrap table mt-4 table-hover m-0 table-centered datatable">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Celular</th>
                                                <th>Correo</th>
                                                <th width="5%">Autorizar/Rechazar</th>
                                                <th width="5%">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($candidatos as $candidato) {
                                                if ($candidato['can_Estatus'] === 'AUT_ENTREVISTA') { ?>
                                                    <?php $urlcv = CVCandidato($candidato['can_SolicitudPersonalID'], $candidato['can_CandidatoID'])[0]; ?>
                                                    <tr>
                                                        <td><?= $candidato['can_Nombre'] ?></td>
                                                        <td><?= $candidato['can_Telefono'] ?></td>
                                                        <td><?= $candidato['can_Correo'] ?></td>
                                                        <td>
                                                            <button data-id="<?= encryptDecrypt('encrypt', $candidato['can_CandidatoID']) ?>" data-estatus="AUT_PSICOMETRIA" class="btn btn-success autorizarBtn btn-icon btn-icon-mini btn-round hidden-sm-down" style="color:#FFFFFF;border-color:#55c927;background-color: #55c927 !important;" title="Autorizar"><i class="zmdi zmdi-check"></i></button>
                                                            <button data-id="<?= encryptDecrypt('encrypt', $candidato['can_CandidatoID']) ?>" data-estatus="RECHAZADO_ENTREVISTA" class="btn btn-danger rechazarBtn btn-icon btn-icon-mini btn-round hidden-sm-down" style="color:#FFFFFF" title="Rechazar"><i class="zmdi zmdi-close "></i></button>
                                                        </td>
                                                        <td>
                                                            <button href="<?= $urlcv ?>" class="btn btn-warning show-pdf btn-icon btn-icon-mini btn-round hidden-sm-down" data-title="CV de <?= strtoupper($candidato['can_Nombre']) ?>" style="color:#FFFFFF;" title="Ver CV"><i class="zmdi zmdi-local-printshop"></i></button>
                                                            <button class="btn btn-info observacionesBtn btn-icon btn-icon-mini btn-round hidden-sm-down" data-id="<?= encryptDecrypt('encrypt', $candidato['can_CandidatoID']) ?>" style="color:#FFFFFF;" title="Agregar Observaciones"><i class=" zmdi zmdi-comment-alt-text"></i></button>
                                                        </td>
                                                    </tr>
                                            <?php }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane show <?= $tabpsico ?>" id="psicometria">
                                <div class="col-12 table-responsive">
                                    <table id="tblParticipantes" class="nowrap table mt-4 table-hover m-0 table-centered datatable">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Celular</th>
                                                <th>Correo</th>
                                                <th>Autorizar/Rechazar</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($candidatos as $candidato) {
                                                if ($candidato['can_Estatus'] === 'AUT_PSICOMETRIA') { ?>
                                                    <?php $urlcv = CVCandidato($candidato['can_SolicitudPersonalID'], $candidato['can_CandidatoID'])[0]; ?>
                                                    <tr>
                                                        <td><?= $candidato['can_Nombre'] ?></td>
                                                        <td><?= $candidato['can_Telefono'] ?></td>
                                                        <td><?= $candidato['can_Correo'] ?></td>
                                                        <td>
                                                            <button data-id="<?= encryptDecrypt('encrypt', $candidato['can_CandidatoID']) ?>" data-estatus="AUT_FINAL" class="btn btn-success autorizarBtn btn-icon btn-icon-mini btn-round hidden-sm-down" style="color:#FFFFFF;border-color:#55c927;background-color: #55c927 !important;" title="Autorizar"><i class="zmdi zmdi-check"></i></button>
                                                            <button data-id="<?= encryptDecrypt('encrypt', $candidato['can_CandidatoID']) ?>" data-estatus="RECHAZADO_PSICOMETRIA" class="btn btn-danger rechazarBtn btn-icon btn-icon-mini btn-round hidden-sm-down" style="color:#FFFFFF" title="Rechazar"><i class="zmdi zmdi-close "></i></button>
                                                        </td>
                                                        <td>
                                                            <button href="<?= $urlcv ?>" class="btn btn-warning show-pdf btn-icon btn-icon-mini btn-round hidden-sm-down" data-title="CV de <?= strtoupper($candidato['can_Nombre']) ?>" style="color:#FFFFFF;" title="Ver CV"><i class="zmdi zmdi-local-printshop"></i></button>
                                                            <button class="btn btn-info observacionesBtn btn-icon btn-icon-mini btn-round hidden-sm-down" data-id="<?= encryptDecrypt('encrypt', $candidato['can_CandidatoID']) ?>" style="color:#FFFFFF;" title="Agregar Observaciones"><i class=" zmdi zmdi-comment-alt-text"></i></button>
                                                        </td>
                                                    </tr>
                                            <?php }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane show <?= $tabfinal ?>" id="final">
                                <div class="row text-center">
                                    <?php
                                    $comprobacionCanSol = db()->query("SELECT COUNT(can_CandidatoID)as 'can' FROM candidato WHERE can_Estatus='SELECCIONADO_RH' AND can_SolicitudPersonalID=" . $solicitud['sol_SolicitudPersonalID'])->getRowArray();
                                    if ($solicitudP['sol_Estatus'] > 0 && $comprobacionCanSol['can'] > 0) { ?>
                                        <div class="col-12 text-right" style="padding-bottom: 2%; padding-right: 5%">
                                            <a class="btn btn-danger btn-round cerrarSolicitud" title="Cerrar Solicitud de Personal" data-id="<?= encryptDecrypt('encrypt', $solicitud['sol_SolicitudPersonalID']) ?>" type="button" style="color: #ffffff;"><i class="fas fa-ban " style="top: 2px !important; position: relative"></i> Cerrar Solicitud</a>
                                        </div>
                                    <?php } ?>
                                    <?php
                                    $comprobacionCanSol = db()->query("SELECT COUNT(can_CandidatoID)as 'can' FROM candidato WHERE can_Estatus='SEL_SOLICITANTE' AND can_SolicitudPersonalID=" . $solicitud['sol_SolicitudPersonalID'])->getRowArray();
                                    if ($solicitudP['sol_Estatus'] > 0 && $comprobacionCanSol['can'] > 0) { ?>
                                        <div class="card-box text-center col-md-12" style="border-radius: 15px">
                                            <h4 class="text-uppercase font-weight-bold" style="color: #00acc1 !important;">En espera de resolucion de solicitante.</h4>
                                        </div>
                                    <?php } ?>
                                    <?php
                                    $can = db()->query("SELECT COUNT(can_CandidatoID)as 'can' FROM candidato WHERE can_Estatus='AUT_FINAL' AND can_SolicitudPersonalID=" . $solicitud['sol_SolicitudPersonalID'])->getRowArray();
                                    if ($can['can'] > 0) {
                                    ?>
                                        <div class="col-md-12"></div>
                                        <div class="col-12 text-right" style="padding-bottom: 2%">
                                            <button class="btn btn-warning btn-round notificacionFinal" title="Enviar Notificación para seleccion final" data-id="<?= encryptDecrypt('encrypt', $solicitud['sol_SolicitudPersonalID']) ?>" type="button" style="color: #ffffff;"><i class="fas fa-bell" style="top: 2px !important; position: relative"></i> Enviar Notificación a solicitante</button>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="col-12 table-responsive">
                                    <table id="tblParticipantes" class="nowrap table mt-4 table-hover m-0 table-centered datatable">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Celular</th>
                                                <th>Correo</th>
                                                <th width="5%">Decisiones</th>
                                                <th width="5%">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($candidatos as $candidato) {
                                                if ($candidato['can_Estatus'] === 'AUT_FINAL' || $candidato['can_Estatus'] === 'SELECCIONADO' || $candidato['can_Estatus'] === 'NO_SELECCIONADO' || $candidato['can_Estatus'] === 'SELECCIONADO_RH' || ($candidato['can_Estatus'] === 'CARTERA' && $candidato['can_HitorialRechazo'] != '1')) { ?>
                                                    <?php $urlcv = CVCandidato($candidato['can_SolicitudPersonalID'], $candidato['can_CandidatoID'])[0]; ?>
                                                    <tr>

                                                        <td><?= $candidato['can_Nombre'] ?></td>
                                                        <td><?= $candidato['can_Telefono'] ?></td>
                                                        <td><?= $candidato['can_Correo'] ?></td>
                                                        <td>
                                                            <?php if ($candidato['can_Estatus'] === 'AUT_FINAL') { ?>
                                                                <span class="badge badge-info">En seleccion del solicitante</span>
                                                            <?php } elseif ($candidato['can_Estatus'] === 'SELECCIONADO') { ?>
                                                                <button data-candidato="<?= $candidato['can_Nombre'] ?>" data-id="<?= encryptDecrypt('encrypt', $candidato['can_CandidatoID']) ?>" class="btn btn-success  btn-icon btn-icon-mini btn-round hidden-sm-down seleccionadoBtn" style="color:#FFFFFF;" title="Agregar a plantilla"><i class="fas fa-user-check"></i></button>
                                                            <?php } elseif ($candidato['can_Estatus'] === 'NO_SELECCIONADO') { ?>
                                                                <button data-candidato="<?= $candidato['can_Nombre'] ?>" data-id="<?= encryptDecrypt('encrypt', $candidato['can_CandidatoID']) ?>" data-estatus="<?= $candidato['can_Estatus'] ?>" class="btn btn-warning  btn-icon btn-icon-mini btn-round hidden-sm-down carteraBtn " style="color:#FFFFFF;" title="Guardar en cartera"><i class="fas fa-user-plus "></i></button>
                                                            <?php } elseif ($candidato['can_Estatus'] === 'SELECCIONADO_RH') { ?>
                                                                <span class="badge badge-info">En plantilla</span><br><br>
                                                            <?php } elseif ($candidato['can_Estatus'] === 'CARTERA') { ?>
                                                                <span class="badge badge-warning">En cartera</span>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <button href="<?= $urlcv ?>" class="btn btn-warning show-pdf btn-icon btn-icon-mini btn-round hidden-sm-down" data-title="CV de <?= strtoupper($candidato['can_Nombre']) ?>" style="color:#FFFFFF;" title="Ver CV"><i class="zmdi zmdi-local-printshop"></i></button>
                                                            <button class="btn btn-info observacionesBtn btn-icon btn-icon-mini btn-round hidden-sm-down" data-id="<?= encryptDecrypt('encrypt', $candidato['can_CandidatoID']) ?>" style="color:#FFFFFF;" title="Agregar Observaciones"><i class=" zmdi zmdi-comment-alt-text"></i></button>
                                                        </td>
                                                    </tr>
                                            <?php }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--------------- Modal add candidato ----------------->
<div id="modalAddCandidato" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content modal-lg">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Subir candidato</h4>
            </div>
            <form id="formAddCandidato" action="<?= base_url('Reclutamiento/addCandidato') ?>" method="post" autocomplete="off" role="form" enctype="multipart/form-data">
                <input name="modalAdd_SolPer" id="modalAdd_SolPer" hidden>
                <div class="modal-body">
                    <div class="form-group">
                        <label>* Nombre</label>
                        <input id="modalAdd_Nombre" name="modalAdd_Nombre" class="form-control" placeholder="Nombre del candidato" required>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>* Celular</label>
                            <input id="modalAdd_Celular" name="modalAdd_Celular" class="form-control" placeholder="Escriba el celular del candidato" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>* Correo</label>
                            <input type="email" id="modalAdd_Correo" name="modalAdd_Correo" class="form-control" placeholder="Escriba el correo del candidato" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label> * CV</label>
                        <div class="file-loading">
                            <input id="fileCV" name="fileCV" type="file" class="file">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-round" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success btn-round">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--------------- Modal agregar observaciones ----------------->
<div id="modalCambios" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Observaciones</h4>
            </div>
            <form id="formObservaciones" action="<?= site_url('Reclutamiento/saveObservaciones/' . $solicitudPersonalID) ?>" method="post" autocomplete="off">
                <input type="hidden" name="candidatoID" id="candidatoIDInput" value="0">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="can_Observacion">Agregue observaciones si lo ve necesario, indicando en que fase del proceso se encuentra el candidato.</label>
                                <textarea type="text" class="form-control" rows="3" name="can_Observacion" id="can_Observacion"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-round" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success btn-round">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#fileCV').fileinput({
        theme: 'fas',
        language: 'es',
        uploadUrl: '#',
        allowedFileExtensions: ['pdf'],
        dropZoneEnabled: false,
        showUpload: false,
    });
</script>