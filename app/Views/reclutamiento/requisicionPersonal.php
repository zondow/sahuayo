<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<style>
    .select2-container {
        width: 100% !important;
    }
</style>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 text-right">
                        <?php if (revisarPermisos('Crear', 'requisicionPersonal')) { ?>
                            <a href="<?= base_url("Reclutamiento/nuevaSolicitudPersonal") ?>" class="btn btn-success btn-round mt-2 mb-4">
                                <i class="dripicons-plus" style="top: 2px !important; position: relative"></i>
                                Nueva solicitud de personal
                            </a>
                        <?php } ?>
                    </div>
                </div>

                <table class="table table-hover m-0 table-centered tickets-list table-actions-bar dt-responsive datatableSolicitudPersonal" cellspacing="0" width="100%" id="tVacaciones">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Solicita</th>
                            <th>Puesto solicitado</th>
                            <th>Observaciones</th>
                            <th class=" text-center">Estatus</th>
                            <th class=" text-center">Estado</th>
                            <th width="5%">Acciones</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($solicitudes as $solicitud) : ?>
                            <tr>
                                <td><?= shortDate($solicitud['sol_Fecha'], ' de ') ?></td>
                                <td><?= $solicitud['emp_Nombre'] ?></td>
                                <td>
                                    <?= $solicitud['sol_PuestoID'] > 0 && empty($solicitud['sol_NuevoPuesto'])
                                        ? $solicitud['pue_Nombre']
                                        : $solicitud['sol_NuevoPuesto'] ?>
                                </td>
                                <td><?= $solicitud['sol_JustificacionRechazada'] ?></td>
                                <td class="text-center">
                                    <span class="badge  <?= $solicitud['sol_DirGeneralAutorizada'] === 'PENDIENTE' ? 'badge-info' : ($solicitud['sol_DirGeneralAutorizada'] === 'RECHAZADA' ? 'badge-danger' : 'badge-success') ?>">
                                        <?= $solicitud['sol_DirGeneralAutorizada'] ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="badge <?= $solicitud['sol_Estatus'] == 1 ? 'badge-info' : 'badge-danger' ?>">
                                        <?= $solicitud['sol_Estatus'] == 1 ? 'EN CURSO' : 'TERMINADA' ?>
                                    </span>
                                </td>
                                <td>
                                    <button href="<?= base_url("PDF/imprimirSolicitudPersonal/" . encryptDecrypt('encrypt', $solicitud['sol_SolicitudPersonalID'])) ?>" class="show-pdf btn btn-info btn-icon btn-icon-mini btn-round hidden-sm-down" style="color:#FFFFFF;" data-title="Solicitud de personal">
                                        <i class="zmdi zmdi-local-printshop"></i>
                                    </button>
                                    <?php if (revisarPermisos('Autorizar', 'requisicionPersonal') && $solicitud['sol_DirGeneralAutorizada'] === 'PENDIENTE') : ?>
                                        <button class="btn btn-success btn-icon btn-icon-mini btn-round hidden-sm-down" title="Autorizar" onclick="window.location.href='<?= base_url("Reclutamiento/cambiarEstatusReqPersonal/AUTORIZADA/" . encryptDecrypt('encrypt', $solicitud['sol_SolicitudPersonalID'])) ?>'">
                                            <i class="zmdi zmdi-check"></i>
                                        </button>
                                        <button data-action="rechazar requisición de personal" data-href="<?= base_url("Reclutamiento/cambiarEstatusReqPersonal/RECHAZADA/" . encryptDecrypt('encrypt', $solicitud['sol_SolicitudPersonalID'])) ?>" class="btn btn-danger btn-icon btn-icon-mini btn-round hidden-sm-down modal-rechazo" style="color:#FFFFFF" title="Rechazar">
                                            <i class="zmdi zmdi-close"></i>
                                        </button>
                                    <?php endif; ?>

                                    <?php if ($solicitud['sol_EmpleadoID'] == session('id')) : ?>
                                        <?php $candidatos = db()->query("SELECT COUNT(*) as 'total' FROM candidato C JOIN solicitudpersonal S ON S.sol_SolicitudPersonalID = C.can_SolicitudPersonalID WHERE C.can_Estatus = 'SEL_SOLICITANTE' AND S.sol_SolicitudPersonalID = ?", [$solicitud['sol_SolicitudPersonalID']])->getRowArray();
                                        if ($candidatos['total'] > 0) : ?>
                                            <button data-id="<?= encryptDecrypt('encrypt', $solicitud['sol_SolicitudPersonalID']) ?>" class="btn btn-success btn-icon btn-icon-mini btn-round hidden-sm-down btnCandidatos" title="Candidatos Finalista">
                                                <i class="fas fa-flag-checkered"></i>
                                            </button>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!--------------- Modal autorizar solicitud de personal ----------------->
<div class="modal fade in" id="modalAplicarSolicitudPersonal" style="background-color:rgba(10, 10, 10, 0.5);">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><b class="iconsminds-danger"></b> Confirmación</h4>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <form id="formAutSolicitud" method="post" action="<?= site_url("Reclutamiento/aplicarSolicitudPersonal") ?>">
                <div class="modal-body row">
                    <div class="col-md-12">
                        ¿Está seguro que desea <strong>enviar a revisión la solicitud de personal</strong>?
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="form-group">
                            <input type="hidden" name="idSolicitud" id="idSolicitud">
                            <label><strong>* ¿Quien revisara y autorizará la solicitud de personal?</strong></label>
                            <select name="sol_Autoriza" id="sol_Autoriza" class="form-control select2 col-md-12" required>
                                <option value="" hidden> Seleccione </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--------------- Modal seleccion candidatos por solicitante ----------------->
<div id="modalselectCandidato" class="modal fade" role="toolbar" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Candidatos Finalistas</h4>
            </div>
            <form id="formSelCandidatos" method="post" autocomplete="off" role="form" enctype="multipart/form-data">
                <input id="solicitudID" name="solicitudID" hidden>
                <input id="nVacantes" name="nVacantes" hidden>
                <div class="modal-body">
                    <div leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="height:auto !important;width:100% !important; font-family: Helvetica,Arial,sans-serif !important; margin-left: 5px;margin-top: 5px;margin-bottom: 5px;">
                        <table id="tableCandidatos" class="table table-hover m-0 table-centered  table-actions-bar dt-responsive datatableSolicitudPersonal" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Candidato</th>
                                    <th>Seleccionar</th>
                                    <th width="2%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-round btn-round" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btnSelCandidatos" class="btn btn-success btn-round">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--------------- Modal seleccion de candidato final ----------------->
<!--------------- 
<div id="modalselectFinal" class="modal fade in show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-xl ">
        <div class="modal-content ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Candidatos Final</h4>
            </div>
            <form id="formSelCandidatos" method="post" autocomplete="off" role="form" enctype="multipart/form-data">
                <input id="solicitudID" name="solicitudID" hidden>
                <input id="nVacantes" name="nVacantes" hidden>
                <div class="modal-body">
                    <div class="table-responsive" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0" style="height:auto !important;width:100% !important; font-family: Helvetica,Arial,sans-serif !important; margin-left: 5px;margin-top: 5px;margin-bottom: 5px;">
                        <table id="tableFinalistas" class="table table-hover  m-0 table-centered table-actions-bar dt-responsive datatableSolicitudPersonal" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th class="w-auto text-center">Acciones</th>
                                    <th class="w-auto">Candidato</th>
                                    <th class="w-auto text-center">Seleccionar</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
----------------->

<!--------------- Modal agregar observaciones ----------------->
<div id="modalCambios" class="modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
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
                                <textarea type="text" class="form-control" rows="3" name="can_Observacion" id="can_Observacion" readonly="true"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
