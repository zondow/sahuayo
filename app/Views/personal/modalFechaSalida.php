<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div id="modalFechaSalida" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="tituloModal">Fecha de salida</h5>
            </div>
            <form id="formColaborador" method="post" autocomplete="off">
                <div class="modal-body">
                    <div class="tab-content">
                        <div class="tab-pane show active" id="personales">
                            <div class="col-md-12">
                                <label class="col-form-label">Fecha de salida</label>
                                <input type="text" class="form-control datepicker" id="baj_FechaBaja" name="baj_FechaBaja" placeholder="Seleccione la fecha de salida">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-right">
                    <button type="button" class="btn btn-round btn-lightlu" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-round btn-success bntGuardarFecha">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>