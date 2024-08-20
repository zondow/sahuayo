<?php defined('FCPATH') or exit('No direct script access allowed'); ?>

<div class="card">
    <div class="card-body">
        <div class="col-md-12 text-right" style="padding-bottom: 2%">
            <?php if (revisarPermisos('Agregar', $this)) { ?>
                <button class="btn btn-success btn-round btnAddExpediente">
                    <i class="zmdi zmdi-plus"></i> Agregar
                </button>
            <?php } ?>
        </div>
        <table class="table table-hover  m-0 table-centered tickets-list table-actions-bar dt-responsive " cellspacing="0" width="100%" id="datatable">
            <thead>
                <tr>
                    <th>Categoría</th>
                    <th>Número</th>
                    <th>Nombre</th>
                    <th>Estatus</th>
                </tr>
            </thead>

            <tbody>
                <?php
                if (isset($expedientes)) {
                    foreach ($expedientes as $expediente) {
                        $html = '<tr>';
                        $html .= '<td>' . $expediente['exp_Categoria'] . '</td>';
                        $html .= '<td>' . $expediente['exp_Numero'] . '</td>';
                        $html .= '<td>' . $expediente['exp_Nombre'] . '</td>';

                        if (revisarPermisos('Baja', $this)) {
                            $estatus = $expediente['exp_Estatus'] == 1 ?
                                '<a href="' . base_url("Configuracion/estatusExpediente/0/" . encryptDecrypt('encrypt', $expediente['exp_ExpedienteID'])) . '"><span class="badge badge-info btnActivo" title="Click para cambiar estatus">Activo</span></a>' :
                                '<a href="' . base_url("Configuracion/estatusExpediente/1/" . encryptDecrypt('encrypt', $expediente['exp_ExpedienteID'])) . '"><span class="badge badge-default btnInactivo" title="Click para cambiar estatus">Inactivo</span></a>';
                        } else {
                            $estatus = $expediente['exp_Estatus'] == 1 ? '<span class="badge badge-info" >Activo</span> ' :  '<span class="badge badge-default ">Inactivo</span> ';
                        }

                        $html .= '<td>' . $estatus . '</td>';
                        $html .= '</tr>';
                        echo $html;
                    } //foreach
                } //if
                ?>

            </tbody>
        </table>
    </div>
</div>
<!--Modal-->
<div id="modalExpediente" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Expediente</h4>
            </div>
            <form id="formExpediente" action="<?= base_url('Configuracion/addExpediente') ?>" method="post" autocomplete="off" role="form">
                <div id="dep" class="modal-body">
                    <div class="form-group">
                        <label for="nombre">* Nombre</label>
                        <input type="text" id="nombre" class="form-control" name="nombre" placeholder="Escriba el nombre" required>
                        <input id="expedienteID" name="expedienteID" hidden>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label for="categoria">* Categoria</label>
                            <select id="categoria" class="chosen-select" name="categoria">
                                <option hidden value="">Seleccione</option>
                                <option value="Externos">Externos</option>
                                <option value="Internos">Internos</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="numero">* No.</label>
                            <input type="text" id="numero" class="form-control numeric" name="numero" placeholder="Numero" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer row">
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-round btn-light waves-effect" data-dismiss="modal">Cancelar</button>
                        <button id="guardar" type="submit" class="btn btn-round btn-success waves-effect waves-light guardar">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>