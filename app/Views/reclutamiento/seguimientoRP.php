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
        <div class="card-box">

            <div class="row">
                <div class="col-12">
                    <div class="card-box widget-flat border-blue bg-success text-white" style="background-color: #001689!important;border-radius: 15px">
                        <i class="fas fa-clipboard-list" style="right: 5%;left:auto;"></i>
                        <h4 class="text-uppercase font-weight-bold text-white"><b>Información de la solicitud</b></h4>
                    </div>
                </div>
                <div class="col-12 table-responsive">
                    <table class="table table-bordered table-striped ">
                        <tbody>
                            <tr>
                                <td><span class="badge badge-dark">Puesto:</span></td>
                                <?php
                                $nuevoP = '';
                                if ($solicitud['sol_Puesto'] === 'Nuevo') {
                                    $nuevoP = '(Nuevo Puesto) ' . $solicitud['sol_NuevoPuesto'];
                                } ?>
                                <td colspan="5"><?= $nuevoP . $solicitud['pue_Nombre'] ?></td>
                            </tr>
                            <tr>
                                <td><span class="badge badge-dark">Área:</span></td>
                                <?php
                                $area = '';
                                if ($solicitud['sol_AreaVacanteID'] > 0) {
                                    $area = $solicitud['are_Nombre'];
                                } else {
                                    $area = $solicitud['sol_NuevaArea'];
                                }
                                ?>
                                <td colspan="2"><?= $area ?></td>
                                <td><span class="badge badge-dark">Departamento:</span></td>
                                <?php
                                $departamento = '';
                                if ($solicitud['sol_DepartamentoVacanteID'] > 0) {
                                    $departamento = $solicitud['dep_Nombre'];
                                } else {
                                    $departamento = $solicitud['sol_NuevoDepartamento'];
                                }
                                ?>
                                <td colspan="2"><?= $departamento ?></td>
                            </tr>
                            <tr>
                                <td><span class="badge badge-dark">Solicito:</span></td>
                                <td colspan="2"><?= $solicitud['emp_Nombre'] ?></td>
                                <td><span class="badge badge-dark">Fecha de ingreso:</span></td>
                                <td colspan="2"><?= shortDate($solicitud['sol_FechaIngreso'], ' de ') ?></td>
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
                                <td><span class="badge badge-dark">Contrato:</span></td>
                                <td colspan="<?= $colspan ?>"><?= $solicitud['sol_Contrato'] ?></td>
                                <?php if ($solicitud['sol_Contrato'] === 'Determinado') { ?>
                                    <td><span class="badge badge-dark">Tiempo:</span></td>
                                    <td colspan="<?= $colspan ?>"><?= $solicitud['sol_TiempoContrato'] ?></td>
                                <?php } ?>
                            </tr>
                            <tr>
                                <td><span class="badge badge-dark">Escolaridad:</span></td>
                                <td><?= $solicitud['sol_Escolaridad'] ?></td>
                                <td><span class="badge badge-dark">Especialidad:</span></td>
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
                                <td><?= $esp ?></td>
                                <td><span class="badge badge-dark">Experiencia:</span></td>
                                <?php
                                $experiencia = $solicitud['sol_Experiencia'];
                                if ($solicitud['sol_AnosExp'] > 0) {
                                    $experiencia .= '<br>Años exp:' . $solicitud['sol_AnosExp'];
                                }
                                if (!empty($solicitud['sol_AreaExp'])) {
                                    $experiencia .= ' <br>Área:' . $solicitud['sol_AreaExp'];
                                }
                                ?>
                                <td><?= $experiencia ?></td>
                            <tr>
                                <td><span class="badge badge-dark">Objetivo del puesto:</span></td>
                                <td colspan="5"><?= $solicitud['sol_EspPerfilPuesto'] ?></td>
                            </tr>
                            <tr>
                                <td><span class="badge badge-dark">Link del prescreening</span></td>
                                <td colspan="6">
                                    <?php echo ($solicitud['sol_Estatus'] == 1) ? base_url('Reclutamiento/prescreening/' . $encryptedID) : '<span class="badge badge-danger">Solicitud Terminada</span>'; ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>


                <hr style="width:100%;text-align:left;margin-left:0">
                <div class="col-md-12 mt-2">
                    <ul class="nav nav-pills nav-fill navtab-bg pull-in ">
                        <li class="nav-item">
                            <a href="#noaptos" data-toggle="tab" aria-expanded="false" class="nav-link ">
                                <i class="fas fa-user-alt-slash "></i><span class="d-none d-sm-inline-block ml-2">No aptos</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#candidatos" data-toggle="tab" aria-expanded="false" class="nav-link <?= $tabcandidato ?>">
                                <i class="fas fa-users"></i><span class="d-none d-sm-inline-block ml-2">Candidatos</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#entrevista" data-toggle="tab" aria-expanded="false" class="nav-link <?= $tabentrevista ?>">
                                <i class="fas fa-clipboard-list"></i><span class="d-none d-sm-inline-block ml-2">Entrevista</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#psicometria" data-toggle="tab" aria-expanded="false" class="nav-link <?= $tabpsico ?>">
                                <i class="fas fa-brain"></i><span class="d-none d-sm-inline-block ml-2">Psicometría</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#final" data-toggle="tab" aria-expanded="false" class="nav-link <?= $tabfinal ?>">
                                <i class="fas fa-flag-checkered"></i><span class="d-none d-sm-inline-block ml-2">Selección Final</span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane show " id="noaptos">
                            <div class="col-12 table-responsive">
                                <table id="tblParticipantes" class="nowrap table mt-4 table-hover m-0 table-centered datatable">
                                    <thead>
                                        <tr>
                                            <th>Acciones</th>
                                            <th>Nombre</th>
                                            <th>Celular</th>
                                            <th>Correo</th>
                                            <th>Rechazado en</th>
                                            <th>Observación de rechazo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($candidatos as $candidato) {
                                            if ($candidato['can_Estatus'] === 'RECHAZADO_REVISION' || $candidato['can_Estatus'] === 'RECHAZADO_ENTREVISTA' || $candidato['can_Estatus'] === 'RECHAZADO_PSICOMETRIA' || $candidato['can_Estatus'] === 'CARTERA' && $candidato['can_HitorialRechazo'] === '1') { ?>
                                                <tr>
                                                    <td>
                                                        <div style="width: 50%;"> <a type="button" class="btn btn-dark waves-effect waves-light observacionesBtn btn-block" data-id="<?= encryptDecrypt('encrypt', $candidato['can_CandidatoID']) ?>" style="color:#FFFFFF;" title="Agregar Observaciones"><i class=" dripicons-blog" style="font-size: 12px"></i></a></div>
                                                        <?php if ($candidato['can_Estatus'] != 'CARTERA') { ?>
                                                        <div style="width: 50%;"><a type="button" data-candidato="<?= $candidato['can_Nombre'] ?>" data-id="<?= encryptDecrypt('encrypt', $candidato['can_CandidatoID']) ?>" data-estatus="<?= $candidato['can_Estatus'] ?>" class="btn btn-warning waves-effect waves-light carteraBtn btn-block" style="color:#FFFFFF;" title="Guardar en cartera"><i class="fas fa-user-plus "></i></a></div>
                                                        <?php } ?>
                                                    </td>
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
                                        <a class="btn btn-primary addCandidato" title="Agregar Candidato" data-id="<?= encryptDecrypt('encrypt', $solicitud['sol_SolicitudPersonalID']) ?>" type="button" style="color: #ffffff;"><i class="dripicons-plus" style="top: 2px !important; position: relative"></i> Agregar Candidatos</a>
                                    </div>
                                
                                <?php } ?>
                            </div>
                            <div class="col-12 table-responsive">
                                <table id="tblParticipantes" class="nowrap table mt-4 table-hover m-0 table-centered datatable">
                                    <thead>
                                        <tr>
                                            <th width="15%">Acciones</th>
                                            <th>Nombre</th>
                                            <th>Celular</th>
                                            <th>Correo</th>
                                            <th width="5%">Autorizar/Rechazar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($candidatos as $candidato) {
                                            if ($candidato['can_Estatus'] === 'REVISION') { ?>
                                                <?php $urlcv = CVCandidato($candidato['can_SolicitudPersonalID'], $candidato['can_CandidatoID']);
                                                ?>
                                                <tr>
                                                    <td>
                                                        <div style="width: 50%;"> <a type="button" href="<?= $urlcv[0] ?>" class="btn btn-info waves-effect waves-light show-pdf btn-block mb-1" data-title="CV de <?= strtoupper($candidato['can_Nombre']) ?>" style="color:#FFFFFF;" title="Ver CV"><i class="zmdi zmdi-local-printshop" style="font-size: 12px"></i></a></div>
                                                        <div style="width: 50%;"> <a type="button" class="btn btn-dark waves-effect waves-light observacionesBtn btn-block" data-id="<?= encryptDecrypt('encrypt', $candidato['can_CandidatoID']) ?>" style="color:#FFFFFF;" title="Agregar Observaciones"><i class=" dripicons-blog" style="font-size: 12px"></i></a></div>
                                                    </td>
                                                    <td><?= $candidato['can_Nombre'] ?></td>
                                                    <td><?= $candidato['can_Telefono'] ?></td>
                                                    <td><?= $candidato['can_Correo'] ?></td>
                                                    <td>
                                                        <div style="width: 30%;padding-bottom:1%"><a type="button" data-id="<?= encryptDecrypt('encrypt', $candidato['can_CandidatoID']) ?>" data-estatus="AUT_ENTREVISTA" class="btn btn-success waves-effect waves-light autorizarBtn btn-block" style="color:#FFFFFF;border-color:#55c927;background-color: #55c927 !important;" title="Autorizar"><i class="fas fa-check "></i></a></div>
                                                        <div style="width: 30%;"><a type="button" data-id="<?= encryptDecrypt('encrypt', $candidato['can_CandidatoID']) ?>" data-estatus="RECHAZADO_REVISION" class="btn btn-danger waves-effect waves-light rechazarBtn btn-block" style="color:#FFFFFF" title="Rechazar"><i class="fas fa-times "></i></a></div>
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
                                            <th width="5%">Acciones</th>
                                            <th>Nombre</th>
                                            <th>Celular</th>
                                            <th>Correo</th>
                                            <th width="5%">Autorizar/Rechazar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($candidatos as $candidato) {
                                            if ($candidato['can_Estatus'] === 'AUT_ENTREVISTA') { ?>
                                                <?php $urlcv = CVCandidato($candidato['can_SolicitudPersonalID'], $candidato['can_CandidatoID']); ?>
                                                <tr>
                                                    <td>
                                                        <div style="width: 50%;"> <a type="button" href="<?= $urlcv[0] ?>" class="btn btn-info waves-effect waves-light show-pdf btn-block mb-1" data-title="CV de <?= strtoupper($candidato['can_Nombre']) ?>" style="color:#FFFFFF;" title="Ver CV"><i class="zmdi zmdi-local-printshop" style="font-size: 12px"></i></a></div>
                                                        <div style="width: 50%;"> <a type="button" class="btn btn-dark waves-effect waves-light observacionesBtn btn-block" data-id="<?= encryptDecrypt('encrypt', $candidato['can_CandidatoID']) ?>" style="color:#FFFFFF;" title="Agregar Observaciones"><i class=" dripicons-blog" style="font-size: 12px"></i></a></div>
                                                    </td>
                                                    <td><?= $candidato['can_Nombre'] ?></td>
                                                    <td><?= $candidato['can_Telefono'] ?></td>
                                                    <td><?= $candidato['can_Correo'] ?></td>
                                                    <td>
                                                        <div style="width: 30%;padding-bottom:1%"><a type="button" data-id="<?= encryptDecrypt('encrypt', $candidato['can_CandidatoID']) ?>" data-estatus="AUT_PSICOMETRIA" class="btn btn-success waves-effect waves-light autorizarBtn btn-block" style="color:#FFFFFF;border-color:#55c927;background-color: #55c927 !important;" title="Autorizar"><i class="fas fa-check "></i></a></div>
                                                        <div style="width: 30%;"><a type="button" data-id="<?= encryptDecrypt('encrypt', $candidato['can_CandidatoID']) ?>" data-estatus="RECHAZADO_ENTREVISTA" class="btn btn-danger waves-effect waves-light rechazarBtn btn-block" style="color:#FFFFFF" title="Rechazar"><i class="fas fa-times "></i></a></div>
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
                                            <th>Acciones</th>
                                            <th>Nombre</th>
                                            <th>Celular</th>
                                            <th>Correo</th>
                                            <th>Autorizar/Rechazar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($candidatos as $candidato) {
                                            if ($candidato['can_Estatus'] === 'AUT_PSICOMETRIA') { ?>
                                                <?php $urlcv = CVCandidato($candidato['can_SolicitudPersonalID'], $candidato['can_CandidatoID']); ?>
                                                <tr>
                                                    <td>
                                                        <div style="width: 50%;"> <a type="button" href="<?= $urlcv[0] ?>" class="btn btn-info waves-effect waves-light show-pdf btn-block mb-1" data-title="CV de <?= strtoupper($candidato['can_Nombre']) ?>" style="color:#FFFFFF;" title="Ver CV"><i class="zmdi zmdi-local-printshop" style="font-size: 12px"></i></a></div>
                                                        <div style="width: 50%;"> <a type="button" class="btn btn-dark waves-effect waves-light observacionesBtn btn-block" data-id="<?= encryptDecrypt('encrypt', $candidato['can_CandidatoID']) ?>" style="color:#FFFFFF;" title="Agregar Observaciones"><i class=" dripicons-blog" style="font-size: 12px"></i></a></div>

                                                    </td>
                                                    <td><?= $candidato['can_Nombre'] ?></td>
                                                    <td><?= $candidato['can_Telefono'] ?></td>
                                                    <td><?= $candidato['can_Correo'] ?></td>
                                                    <td>
                                                        <div style="width: 30%;padding-bottom:1%"><a type="button" data-id="<?= encryptDecrypt('encrypt', $candidato['can_CandidatoID']) ?>" data-estatus="AUT_FINAL" class="btn btn-success waves-effect waves-light autorizarBtn btn-block" style="color:#FFFFFF;border-color:#55c927;background-color: #55c927 !important;" title="Autorizar"><i class="fas fa-check "></i></a></div>
                                                        <div style="width: 30%;"><a type="button" data-id="<?= encryptDecrypt('encrypt', $candidato['can_CandidatoID']) ?>" data-estatus="RECHAZADO_PSICOMETRIA" class="btn btn-danger waves-effect waves-light rechazarBtn btn-block" style="color:#FFFFFF" title="Rechazar"><i class="fas fa-times "></i></a></div>
                                                    </td>
                                                </tr>
                                        <?php }
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane show <?= $tabfinal ?>" id="final">
                            <div class="row">
                                <?php 
                                $comprobacionCanSol = db()->query("SELECT COUNT(can_CandidatoID)as 'can' FROM candidato WHERE can_Estatus='SELECCIONADO_RH' AND can_SolicitudPersonalID=" . $solicitud['sol_SolicitudPersonalID'])->getRowArray();
                                if ($solicitudP['sol_Estatus'] > 0 && $comprobacionCanSol['can']>0) { ?>
                                    <div class="col-12 text-right" style="padding-bottom: 2%; padding-right: 5%">
                                        <a class="btn btn-danger cerrarSolicitud" title="Cerrar Solicitud de Personal" data-id="<?= encryptDecrypt('encrypt', $solicitud['sol_SolicitudPersonalID']) ?>" type="button" style="color: #ffffff;"><i class="fas fa-ban " style="top: 2px !important; position: relative"></i> Cerrar Solicitud</a>
                                    </div>
                                <?php } ?>
                                <?php 
                                $comprobacionCanSol = db()->query("SELECT COUNT(can_CandidatoID)as 'can' FROM candidato WHERE can_Estatus='SEL_SOLICITANTE' AND can_SolicitudPersonalID=" . $solicitud['sol_SolicitudPersonalID'])->getRowArray();
                                if ($solicitudP['sol_Estatus'] > 0 && $comprobacionCanSol['can']>0) { ?>
                                    <div class="alert alert-dark rounded col-md-12" role="alert">
                                        <br>
                                        <p class="lead" style="text-align: center;vertical-align: center;padding-bottom: 4px">En espera de resolucion de solicitante.</p>
                                    </div>
                                <?php } ?>
                                <?php
                                $can = db()->query("SELECT COUNT(can_CandidatoID)as 'can' FROM candidato WHERE can_Estatus='AUT_FINAL' AND can_SolicitudPersonalID=" . $solicitud['sol_SolicitudPersonalID'])->getRowArray();
                                if ($can['can'] > 0) {
                                ?>
                                    <div class="col-md-12"></div>
                                    <div class="col-12 text-right" style="padding-bottom: 2%">
                                        <a class="btn btn-info notificacionFinal" title="Enviar Notificación para seleccion final" data-id="<?= encryptDecrypt('encrypt', $solicitud['sol_SolicitudPersonalID']) ?>" type="button" style="color: #ffffff;"><i class="fas fa-bell" style="top: 2px !important; position: relative"></i> Enviar Notificación a solicitante</a>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="col-12 table-responsive">
                                <table id="tblParticipantes" class="nowrap table mt-4 table-hover m-0 table-centered datatable">
                                    <thead>
                                        <tr>
                                            <th width="5%">Acciones</th>
                                            <th>Nombre</th>
                                            <th>Celular</th>
                                            <th>Correo</th>
                                            <th width="5%">Decisiones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($candidatos as $candidato) {
                                            if ($candidato['can_Estatus'] === 'AUT_FINAL' || $candidato['can_Estatus'] === 'SELECCIONADO' || $candidato['can_Estatus'] === 'NO_SELECCIONADO' || $candidato['can_Estatus'] === 'SELECCIONADO_RH' || ($candidato['can_Estatus'] === 'CARTERA' && $candidato['can_HitorialRechazo'] != '1')) { ?>
                                                <?php $urlcv = CVCandidato($candidato['can_SolicitudPersonalID'], $candidato['can_CandidatoID']); ?>
                                                <tr>
                                                    <td>
                                                    <div style="width: 50%;"> <a type="button" href="<?= $urlcv[0] ?>" class="btn btn-info waves-effect waves-light show-pdf btn-block mb-1" data-title="CV de <?= strtoupper($candidato['can_Nombre']) ?>" style="color:#FFFFFF;" title="Ver CV"><i class="zmdi zmdi-local-printshop" style="font-size: 12px"></i></a></div>
                                                    <div style="width: 50%;"> <a type="button" class="btn btn-dark waves-effect waves-light observacionesBtn btn-block" data-id="<?= encryptDecrypt('encrypt', $candidato['can_CandidatoID']) ?>" style="color:#FFFFFF;" title="Agregar Observaciones"><i class=" dripicons-blog" style="font-size: 12px"></i></a></div>
                                                    </td>
                                                    <td><?= $candidato['can_Nombre'] ?></td>
                                                    <td><?= $candidato['can_Telefono'] ?></td>
                                                    <td><?= $candidato['can_Correo'] ?></td>
                                                    <td>
                                                        <?php if ($candidato['can_Estatus'] === 'AUT_FINAL') { ?>
                                                            <span class="badge badge-info">En seleccion del solicitante</span>
                                                        <?php } elseif ($candidato['can_Estatus'] === 'SELECCIONADO') { ?>
                                                            <div  style="width: 50%;"><br>
                                                            <a type="button" data-candidato="<?= $candidato['can_Nombre'] ?>" data-id="<?= encryptDecrypt('encrypt', $candidato['can_CandidatoID']) ?>" class="btn btn-success waves-effect waves-light btn-block seleccionadoBtn" style="color:#FFFFFF;" title="Agregar a plantilla"><i class="fas fa-user-check"></i></a></div>
                                                        <?php } elseif ($candidato['can_Estatus'] === 'NO_SELECCIONADO') { ?>
                                                            <div style="width: 50%;"><a type="button" data-candidato="<?= $candidato['can_Nombre'] ?>" data-id="<?= encryptDecrypt('encrypt', $candidato['can_CandidatoID']) ?>" data-estatus="<?= $candidato['can_Estatus'] ?>" class="btn btn-warning waves-effect waves-light carteraBtn btn-block" style="color:#FFFFFF;" title="Guardar en cartera"><i class="fas fa-user-plus "></i></a></div>
                                                        <?php } elseif ($candidato['can_Estatus'] === 'SELECCIONADO_RH') { ?>
                                                            <span class="badge badge-info">En plantilla</span><br><br>
                                                        <?php } elseif ($candidato['can_Estatus'] === 'CARTERA') { ?>
                                                            <span class="badge badge-warning">En cartera</span>
                                                        <?php } ?>
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
                    <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Guardar</button>
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
                    <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Guardar</button>
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