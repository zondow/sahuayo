<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="modalEditCatalogoPermiso" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" style="max-width: 350px !important;" role="document">
        <div class="modal-content" style="max-width: 350px !important;">
            <div class="modal-header">
                <h4 class="title">Editar tipo de permiso</h4>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        <label for="nombre"> *Nombre</label>
                        <input id="txtNombre" class="form-control" readonly>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="nombre"> *Dias otorgados</label>
                        <input id="txtDias" class="form-control numeric">
                    </div>
                </div>
            </div>
            <div class="modal-footer row">
                <div class="col-md-12 text-right">
                    <button type="button" class="btn btn-round btn-light" data-dismiss="modal"> Cancelar</button>
                    <button id="btnUpdate" type="button" class="btn btn-round btn-success"> Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>