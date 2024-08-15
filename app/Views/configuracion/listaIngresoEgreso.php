<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<style>
    .btnActivo {
        color: #0acf97;
        border-color: #0acf97;
    }

    .btnActivo:hover {
        color: white;
        border-color: #0acf97;
        background-color: #0acf97 !important;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="col-md-12 mb-2 text-right">
                    <?php if (revisarPermisos('Agregar', $this)) { ?>
                        <button class="btn btn-success btn-round" id="btnAddChecklist">
                            <i class="zmdi zmdi-plus"></i> Agregar
                        </button>
                    <?php } ?>
                </div>
                <div class="col-md-12">
                    <div>
                        <table id="tblCheklist" class="table table-hover m-0 table-centered tickets-list table-actions-bar dt-responsive" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tipo</th>
                                    <th>Nombre</th>
                                    <th>Responsable</th>
                                    <th>Estatus</th>
                                    <th>Acciones</th>

                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--------------- Modal  ----------------->
<div class="modal fade" id="modalAddChecklist" tabindex="-1" role="dialog">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title">&nbsp;Añadir al checklist</h4>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="txtNombre">*Nombre</label>
                        <input id="txtNombre" name="txtNombre" placeholder="Escribe el nombre" class="form-control">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="txtReponsable">*Responsable (s)</label>
                        <select id="txtResponsable" name="txtResponsable[]" class="show-tick" multiple="multiple" data-live-search="true" data-placeholder="Seleccionar responsable (s)"  data-width="100%">
                            <?php
                            foreach ($empleados as $emp) {
                                echo '<option value="' . $emp['emp_EmpleadoID'] . '">' . $emp['emp_Nombre'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label for="txtTipo">*Tipo</label>
                        <select id="txtTipo" name="txtTipo" class="show-tick" data-placeholder="Seleccionar tipo" data-width="100%">
                            <option hidden>Seleccione</option>
                            <option value="Ingreso">Ingreso</option>
                            <option value="Egreso">Egreso</option>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label for="txtRequerido">*Requerido</label>
                        <select id="txtRequerido" name="txtRequerido" class="show-tick" data-placeholder="Seleccionar" data-width="100%">
                            <option hidden>Seleccione</option>
                            <option value="1">Si</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer ">
                <div class="col-md-12 text-right">
                    <button type="button" class="btn btn-round btn-light" data-dismiss="modal"> Cancelar</button>
                    <button id="btnGuardarChecklist" type="button" class="btn btn-round btn-primary"> Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!--------------- Modal  ----------------->
<div class="modal fade" id="modalEditChecklist" tabindex="-1" role="dialog">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title"></i>Editar checklist</h4>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="txt_Nombre">*Nombre</label>
                        <input id="txt_Nombre" name="txt_Nombre" placeholder="Escribe el nombre" class="form-control">
                        <input id="txt_CatalogoID" name="txt_CatalogoID" placeholder="Escribe el nombre" class="form-control" hidden>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="txt_Responsable">*Responsable</label>
                        <select id="txt_Responsable" name="txt_Responsable" class="form-control select2-multiple" multiple="multiple" data-placeholder="Seleccionar responsable (s)" data-width="100%">

                            <?php
                            foreach ($empleados as $emp) {
                                echo '<option value="' . $emp['emp_EmpleadoID'] . '">' . $emp['emp_Nombre'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="txt_Tipo">*Tipo</label>
                        <select id="txt_Tipo" name="txt_Tipo" class="select-tom" data-placeholder="Seleccionar tipo" data-width="100%">
                            <option hidden>Seleccione</option>
                            <option value="Ingreso">Ingreso</option>
                            <option value="Egreso">Egreso</option>
                        </select>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="txt_Requerido">*Requerido</label>
                        <select id="txt_Requerido" name="txt_Requerido" class="select-tom" data-placeholder="Seleccionar" data-width="100%">
                            <option hidden>Seleccione</option>
                            <option value="1">Si</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer ">
                <div class="col-md-12 text-right">
                    <button type="button" class="btn btn-round btn-light" data-dismiss="modal"> Cancelar</button>
                    <button id="btnUpdateChecklist" type="button" class="btn btn-round btn-primary"> Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>