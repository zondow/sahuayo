<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<style>
    .datepicker .datepicker-days tr:hover td {
        color: #000;
        background: #e5e2e3;
        border-radius: 0;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <div class="card-box">
            <div class="row">
                <div class="col-md-2 mb-2 ">
                    <?php if (revisarPermisos('Agregar', $this)) { ?>
                        <a href="#" id="addGuardia" class="btn btn-success waves-light waves-effect"><i class="dripicons-plus" style="top: 2px !important; position: relative"></i> Agregar</a>
                    <?php } ?>
                </div>
                <div class="col-md-2 mb-2">
                        <a href="#" id="addGuardia" class="btn btn-secondary waves-light waves-effect btnModalImportarGuardia"><i class="far fa-file-excel " style="top: 2px !important; position: relative"></i> Importar masivo</a>
                </div>
                <div class="col-md-12">
                    <div>
                        <table id="tblGuardia" class="table table-hover text-center m-0 table-centered tickets-list table-actions-bar dt-responsive " cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="5%">Acciones</th>
                                    <th>Colaborador</th>
                                    <th>Fecha Inicio</th>
                                    <th>Fecha Fin</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--------------- Modal  ----------------->
<div class="modal fade" id="modalAddGuardia" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title">&nbsp;Nueva guardia</h4>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <form id="frmGuardia" action="<?= site_url('Configuracion/addGuardia') ?>" method="post" autocomplete="off" role="form">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="nombre"> *Nombre</label>
                            <select style="width: 100%;" id="colaborador" name="colaborador" class="form-control select2">
                                <option hidden>Seleccione</option>
                                <?php foreach ($empleados as $empleado) { ?>
                                    <option value="<?= encryptDecrypt('encrypt', $empleado['emp_EmpleadoID']) ?>"><?= $empleado['emp_Nombre'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nombre"> *Semana</label>
                            <input type="text" class="input-sm form-control datepicker" name="txtFechas" id="txtFechas" placeholder="Selecciona la semana" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer ">
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-light" data-dismiss="modal"> Cancelar</button>
                        <button type="submit" class="btn btn-success"> Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>