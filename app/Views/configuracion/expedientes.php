<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div class="content">
    <!-- Start Content-->
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <div class="col-md-12 text-left" style="padding-bottom: 2%">
                        <?php if (revisarPermisos('Agregar', $this)) { ?>
                            <a type="button" style="color: #FFFFFF" class=" btnAddExpediente btn btn-success waves-effect waves-light"><i class="dripicons-plus"></i> Agregar</a>
                        <?php } ?>
                    </div>
                    <table class="table table-hover  m-0 table-centered tickets-list table-actions-bar dt-responsive " cellspacing="0" width="100%" id="datatable">
                        <thead>
                            <tr>
                                <!--<th>Acciones</th>-->
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

                                    if (revisarPermisos('Editar', $this)) {
                                        //$html .= '<td><a type="button" class="btn btn-info waves-effect waves-light editarExpediente" data-id="' . $expediente['exp_ExpedienteID'] . '" style="color:#FFFFFF"><i class="fa fa-edit"></i> </a></td>';
                                    } else {
                                        $html .= '<td></td>';
                                    }

                                    $html .= '<td>' . $expediente['exp_Categoria'] . '</td>';
                                    $html .= '<td>' . $expediente['exp_Numero'] . '</td>';
                                    $html .= '<td>' . $expediente['exp_Nombre'] . '</td>';

                                    if (revisarPermisos('Baja', $this)) {
                                        if ($expediente['exp_Estatus'] == 1) {
                                            $estatus = '<a class="btn btn-outline-success btn-rounded waves-light waves-effect pt-0 pb-0 btnActivo" title="Click para cambiar estatus" href="' . base_url("Configuracion/estatusExpediente/0/" . encryptDecrypt('encrypt', $expediente['exp_ExpedienteID'])) . '">Activo</a>';
                                        } else {
                                            $estatus = '<a class="btn btn-outline-danger btn-rounded waves-light waves-effect pt-0 pb-0 btnInactivo" title="Click para cambiar estatus" href="' . base_url("Configuracion/estatusExpediente/1/" . encryptDecrypt('encrypt', $expediente['exp_ExpedienteID'])) . '">Inactivo</a>';
                                        }
                                    } else {
                                        if ($expediente['exp_Estatus'] == 1) {
                                            $estatus = '<a class="btn btn-outline-success btn-rounded waves-light waves-effect pt-0 pb-0 btnActivo" >Activo</a>';
                                        } else {
                                            $estatus = '<a class="badge badge-danger"  style="color: #ffffff;padding: 3.5%;font-size: 10px">INACTIVO</a>';
                                        }
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
        </div>
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
                        <div class="form-group col-md-10">
                            <label for="categoria">* Categoria</label>
                            <select id="categoria" class="form-control" name="categoria">
                                <option hidden value="">Seleccione</option>
                                <option value="Externos">Externos</option>
                                <option value="Internos">Internos</option>
                            </select>
                        </div>
                        <div class="form-group col-md-2">
                            <label for="numero">* No.</label>
                            <input type="text" id="numero" class="form-control numeric" name="numero" placeholder="Numero" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Cancelar</button>
                    <button id="guardar" type="submit" class="btn btn-primary waves-effect waves-light guardar">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>