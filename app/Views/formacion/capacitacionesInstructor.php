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

    .dtp div.dtp-date,
    .dtp div.dtp-time {
        background-color: #001689 !important;
    }

    .dtp>.dtp-content>.dtp-date-view>header.dtp-header {
        background-color: #001689 !important;
    }
</style>
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <table class="datatableCapacitacion table table-hover m-0 table-centered  table-actions-bar dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Estatus</th>
                                    <th>Nombre</th>
                                    <th>Fecha(s)</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($capacitaciones)) {
                                    $estadoClasses = [
                                        'Registrada' => 'badge-info',
                                        'Enviada' => 'badge-warning',
                                        'En curso' => 'badge-success',
                                        'Terminada' => 'badge-danger'
                                    ];

                                    foreach ($capacitaciones as $capacitacion) {
                                        // Definir nombre del curso
                                        $nombre = !empty($capacitacion['cap_CursoID']) ? $capacitacion['cur_Nombre'] : $capacitacion['cap_CursoNombre'];

                                        // Generar las fechas
                                        $fechas = '';
                                        $fechasJSON = json_decode($capacitacion['cap_Fechas']);
                                        foreach ($fechasJSON as $i => $fj) {
                                            $fechas .= '<span class="badge badge-info">' . shortDate($fj->fecha) . ' de ' . shortTime($fj->inicio) . ' a ' . shortTime($fj->fin) . '</span>';
                                            if ($i < count($fechasJSON) - 1) {
                                                $fechas .= '<br>';
                                            }
                                        }

                                        // Obtener el estado y la clase correspondiente
                                        $estadoClass = $estadoClasses[$capacitacion['cap_Estado']] ?? 'badge-info';
                                ?>
                                        <tr>
                                            <td class="w-15"><span class="badge <?= $estadoClass ?>"><?= $capacitacion['cap_Estado'] ?></span></td>
                                            <td><?= $nombre ?></td>
                                            <td><?= $fechas ?></td>
                                            <td>
                                                <button onclick="window.location.href='<?= base_url('Formacion/informacionCapacitacionInstructor/' . encryptDecrypt('encrypt', $capacitacion['cap_CapacitacionID'])) ?>'" class="btn btn-warning btn-icon btn-icon-mini btn-round hidden-sm-down" title="Información de la capacitación" type="button" style="color:#fff">
                                                    <i class="fa fa-info"></i>
                                                </button>

                                                <button href="#" class="btn btn-dark btn-icon btn-icon-mini btn-round hidden-sm-down btnComentarios" data-id="<?= $capacitacion['cap_CapacitacionID'] ?>" title="Comentarios del instructor" type="button" style="color:#fff">
                                                    <i class="fab fa-stack-exchange"></i>
                                                </button>
                                            </td>
                                        </tr>
                                <?php }
                                }
                                ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--------------- Modal comentarios ----------------->
<div id="modalAddComentarios" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Comentarios del instructor</h4>
            </div>
            <form id="formComentarios" action="<?= base_url('Formacion/saveComentariosInstructor') ?>" method="post" autocomplete="off">
                <input type="hidden" name="cap_CapacitacionID" id="cap_CapacitacionID" value="0">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="cap_ComentariosInstructor">Por favor describa el material o recursos que necesita para implementar la capacitación, asi como algun comentario u observaciones.</label>
                                <textarea type="text" class="form-control" rows="3" name="cap_ComentariosInstructor" id="cap_ComentariosInstructor"></textarea>
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