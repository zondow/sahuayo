<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-hover m-0 table-centered tickets-list table-actions-bar dt-responsive datatable" cellspacing="0" width="100%" id="tVacaciones">
                    <thead>
                        <tr>
                            <th class="w-10">Fecha</th>
                            <th class="w-40">Solicita</th>
                            <th class="w-40">Puesto solicitado</th>
                            <th class="w-40">Estado</th>
                            <th width="5%">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($solicitudes)) : ?>
                            <?php foreach ($solicitudes as $solicitud) : ?>
                                <tr>
                                    <td class="w-10"><?= longDate($solicitud['sol_Fecha'], ' de ') ?></td>
                                    <td class="w-40"><?= $solicitud['emp_Nombre'] ?></td>
                                    <td class="w-40"><?= $solicitud['pue_Nombre'] ?: $solicitud['sol_Puesto'] ?></td>
                                    <td>
                                        <span class="badge <?= $solicitud['sol_Estatus'] == 1 ? 'badge-info' : 'badge-danger' ?>">
                                            <?= $solicitud['sol_Estatus'] == 1 ? 'EN PROCESO' : 'TERMINADA' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-info btn-icon btn-icon-mini btn-round hidden-sm-down" style="color:#FFFFFF;" title="Seguimiento" onclick="window.location.href='<?= base_url('Reclutamiento/infoReqPer/' . encryptDecrypt('encrypt', $solicitud['sol_SolicitudPersonalID'])) ?>'">
                                            <i class="far fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(".datatable").DataTable({
            language: {
                paginate: {
                    previous: "<i class='zmdi zmdi-caret-left'>",
                    next: "<i class='zmdi zmdi-caret-right'>"
                },
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla.",
                "sInfo": "",
                "sInfoEmpty": "",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix": "",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
            },
        });

    });
</script>