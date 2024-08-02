<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mb-2">
                        <div class="col-md-12 text-right">
                            <?php if (revisarPermisos('Agregar', $this)) { ?>
                                <!-- <a href="#" class="btn btn-info waves-light waves-effect addRol">Agregar</a> -->
                                <button class="btn btn-success btn-round addRol">
                                    <i class="zmdi zmdi-plus"></i> Agregar
                                </button>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-2">
                        <table class="table m-0 table-centered dt-responsive cls-table" id="tblRoles" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade " id="modalAddEditRol" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="tituloModalRol"></h4>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <form id="formRol" action="<?= base_url("Configuracion/saveRol") ?>" method="post" autocomplete="off" role="form">
                <input id="rol_RolID" name="rol_RolID" value="0" hidden>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="rol_Nombre"><span class="red_label">*</span> Nombre</label>
                            <input class="form-control" id="rol_Nombre" name="rol_Nombre" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer ">
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-round btn-light" data-dismiss="modal"><span class="iconsminds-close"></span> Cancelar</button>
                        <button type="submit" class="btn btn-round btn-success"><span class="iconsminds-yes"></span> Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>