<?php defined('FCPATH') or exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div>
                            <table id="tblCartera" class="table table-hover  m-0 table-centered tickets-list table-actions-bar dt-responsive " cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Celular</th>
                                        <th>Correo</th>
                                        <th>Solicito para</th>
                                        <th width="10%" ;>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($candidatos as $candidato) {
                                        if ($candidato['can_Estatus'] === 'CARTERA') { ?>
                                            <?php $urlcv = CVCandidato($candidato['can_SolicitudPersonalID'], $candidato['can_CandidatoID']); ?>
                                            <tr>
                                                <td><?= $candidato['can_Nombre'] ?></td>
                                                <td><?= $candidato['can_Telefono'] ?></td>
                                                <td><?= $candidato['can_Correo'] ?></td>
                                                <td><?= $candidato["pue_Nombre"] ?></td>
                                                <td>
                                                    <button href="<?= $urlcv[0] ?>" class="btn btn-warning  btn-icon btn-icon-mini btn-round hidden-sm-down show-pdf " data-title="CV de <?= strtoupper($candidato['can_Nombre']) ?>" style="color:#FFFFFF;" title="Ver CV"><i class="zmdi zmdi-local-printshop"></i></button>
                                                    <button class="btn btn-info  btn-icon btn-icon-mini btn-round hidden-sm-down observacionesBtn " data-id="<?= encryptDecrypt('encrypt', $candidato['can_CandidatoID']) ?>" style="color:#FFFFFF;" title="Agregar Observaciones"><i class=" zmdi zmdi-comment-alt-text"></i></button>
                                                    <button class="btn btn-success  btn-icon btn-icon-mini btn-round hidden-sm-down cambioSolicitudBtn " data-id="<?= encryptDecrypt('encrypt', $candidato['can_CandidatoID']) ?>" style="color:#FFFFFF;" title="Agregar a nueva solicitud"><i class="zmdi zmdi-file-add"></i></button>
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

<!--------------- Modal agregar observaciones ----------------->
<div id="modalCambios" class="modal fade " tabindex="-" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Observaciones</h4>
            </div>
            <form id="formObservaciones" action="<?= site_url('Reclutamiento/saveObservaciones/' . encryptDecrypt('encrypt', $candidato['can_CandidatoID'])) ?>" method="post" autocomplete="off">

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
                <div class="modal-footer text-right">
                    <button type="button" class="btn btn-light btn-round" data-dismiss="modal">Cerrar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!--------------- Modal cambiar solicitud ----------------->
<div id="modalNuevaSolicitud" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Agregar a vacante</h4>
            </div>
            <form id="departamento" action="<?= base_url('Reclutamiento/updateCandidato') ?>" method="post" autocomplete="off" role="form">
                <div id="dep" class="modal-body">
                    <div class="form-group">
                        <label for="selectSolicitudID">* Puesto en requisicion </label>
                        <select id="selectSolicitudID" name="sol_SolicitudPersonalID" class="select2" data-placeholder="Agregar a requisicion en proceso" style="width: 100%" required>
                            <option hidden value=""></option>
                            <?php
                            if (!empty($solicitudes)) {
                                foreach ($solicitudes as $solicitud) { ?>
                                    <?php if ($solicitud['pue_Nombre']) {
                                        $puesto = $solicitud['pue_Nombre'];
                                    } else {
                                        $puesto = $solicitud['sol_Puesto'];
                                    } ?>
                                    <option value="<?= $solicitud['sol_SolicitudPersonalID']; ?>"><?= $puesto; ?></option>
                            <?php }
                            } else {
                                echo '<option value="" disabled>No hay solicitudes de requisicion disponibles</option>';
                            } ?>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <input name="candidatoID" value=<?= encryptDecrypt('encrypt', $candidato['can_CandidatoID']) ?> hidden>
                    <button type="button" class="btn btn-light btn-round" data-dismiss="modal">Cancelar</button>
                    <button id="guardar" type="submit" class="btn btn-success btn-round  guardar">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            dropdownParent: $('#modalNuevaSolicitud .modal-body'), // Usamos el modal como parent directo
            placeholder: 'Seleccione una opción',
            allowClear: true,
            width: 'resolve'
        });
    });
</script>