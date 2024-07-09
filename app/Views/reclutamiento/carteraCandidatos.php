<?php defined('FCPATH') or exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-md-12">
        <div class="card-box">
            <div class="row">
                <div class="col-md-12">
                    <div>
                        <table id="tblCartera" class="table table-hover  m-0 table-centered tickets-list table-actions-bar dt-responsive " cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="10%";>Acciones</th>
                                    <th>Nombre</th>
                                    <th>Celular</th>
                                    <th>Correo</th>
                                    <th>Solicito para</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($candidatos as $candidato) {
                                    if ($candidato['can_Estatus'] === 'CARTERA') { ?>
                                        <?php $urlcv = CVCandidato($candidato['can_SolicitudPersonalID'], $candidato['can_CandidatoID']); ?>
                                        <tr>
                                        <td>
                                                        <div style="width: 50%;"> <a type="button" href="<?= $urlcv[0] ?>" class="btn btn-info waves-effect waves-light show-pdf btn-block mb-1" data-title="CV de <?= strtoupper($candidato['can_Nombre']) ?>" style="color:#FFFFFF;" title="Ver CV"><i class="dripicons-print" style="font-size: 12px"></i></a></div>
                                                        <div style="width: 50%;"> <a type="button" class="btn btn-dark waves-effect waves-light observacionesBtn btn-block mb-1" data-id="<?= encryptDecrypt('encrypt', $candidato['can_CandidatoID']) ?>" style="color:#FFFFFF;" title="Agregar Observaciones"><i class=" dripicons-blog" style="font-size: 12px"></i></a></div>
                                                        <div style="width: 50%;"> <a type="button" class="btn btn-success waves-effect waves-light cambioSolicitudBtn btn-block" data-id="<?= encryptDecrypt('encrypt', $candidato['can_CandidatoID']) ?>" style="color:#FFFFFF;" title="Agregar a nueva solicitud"><i class=" dripicons-plus" style="font-size: 12px"></i></a></div>
                                                    </td>
                                            <td><?= $candidato['can_Nombre'] ?></td>
                                            <td><?= $candidato['can_Telefono'] ?></td>
                                            <td><?= $candidato['can_Correo'] ?></td>
                                            <td><?= $candidato["pue_Nombre"] ?></td>
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

<!--------------- Modal agregar observaciones ----------------->
<div id="modalCambios" class="modal fade " tabindex="-" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Observaciones</h4>
            </div>
            <form id="formObservaciones" action="<?= site_url('Reclutamiento/saveObservaciones/'. encryptDecrypt('encrypt', $candidato['can_CandidatoID'])) ?>" method="post" autocomplete="off">

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


<!--------------- Modal cambiar solicitud ----------------->
<div id="modalNuevaSolicitud" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Agregar a vacante</h4>
            </div>
            <form id="departamento" action="<?=base_url('Reclutamiento/updateCandidato') ?>" method="post" autocomplete="off" role="form">
                <div id="dep" class="modal-body">
                    <div class="form-group">
                        <label for="selectSolicitudID">* Puesto en requisicion </label>
                        <select  id="selectSolicitudID" name="sol_SolicitudPersonalID" class=" form-control" data-placeholder="Agregar a requisicion en proceso" style="width: 100%" required>
                            <option hidden value=""></option>
                            <?php
                            if(!empty($solicitudes)){
                             foreach($solicitudes as $solicitud){ ?>
                             <?php if($solicitud['pue_Nombre']){
                                        $puesto =$solicitud['pue_Nombre'];
                                    }else{
                                        $puesto = $solicitud['sol_Puesto'];
                                    }?>
                                <option value="<?= $solicitud['sol_SolicitudPersonalID']; ?>"><?= $puesto; ?></option>
                            <?php }
                            }else{
                                echo '<option value="" disabled>No hay solicitudes de requisicion disponibles</option>';
                            } ?>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <input  name="candidatoID" value= <?=encryptDecrypt('encrypt', $candidato['can_CandidatoID'])?>  hidden >
                    <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Cancelar</button>
                    <button id="guardar" type="submit" class="btn btn-primary waves-effect waves-light guardar">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>