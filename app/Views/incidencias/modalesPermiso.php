<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<style>
    .select2-container{
        width: 100% !important;
    }
</style>

<div class="modal fade in" id="modalAutorizarPermiso" style="background-color:rgba(10, 10, 10, 0.5);">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><b class="iconsminds-danger"></b> Confirmación</h4>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <form id="formAutPermiso">
                <div class="modal-body row">
                    <div class="col-md-12">
                        ¿Está seguro que desea <strong>Autorizar la solicitud de permiso</strong>?
                    </div>
                    <div class="col-md-12 mt-3">
                        <div class="form-group">
                            <label><strong>* Tipo de permiso</strong></label>
                            <select name="per_Tipo" id="per_Tipo" class="form-control select2 col-md-12">
                                <option value="" hidden> Seleccione </option>
                                <option value="SIN GOCE DE SUELDO">Sin Goce de Sueldo</option>
                                <option value="COMPENSACIÓN DE TIEMPO">Compensación de Tiempo</option>
                                <option value="PERMISO CON GOCE DE SUELDO">Permiso con goce de sueldo</option>
                                <option value="DESCUENTO POR PATERNIDAD">Descuento por paternidad</option>
                            </select>
                        </div>
                    </div>
                    <br/>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label><strong>* Justifique</strong></label>
                            <textarea name="per_JustificacionAut" id="per_JustificacionAut" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" id="confirmAutorizo" class="btn btn-light">Confirmar</a>
                    <button class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade in" id="modalRechazarPermiso" style="background-color:rgba(10, 10, 10, 0.5);">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><b class="fa fa-warning"></b> Confirmación</h4>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                ¿Está seguro que desea <strong>rechazar la solicitud de permiso</strong>?
                <br/>
                <br/>
                <label><strong>* Justifique</strong></label>
                <textarea name="per_Justificacion" id="per_JustificacionRech" class="form-control"></textarea>
            </div>
            <div class="modal-footer">
                <a href="#" id="confirmRechazo" class="btn btn-light">Confirmar</a>
                <button class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>




