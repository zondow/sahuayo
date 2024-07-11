<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="row">
                <div class="col-lg-12">
                    <div id="calendarInhabiles"></div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div>

    </div>
</div>
<div id="modalDiaInhabil" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close " data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Día inhábil</h4>
            </div>
            <form id="formInhabiles" method="post" autocomplete="off" role="form">
                <div class="modal-body">
                    <input class="form-control" id="dia_Fecha" name="dia_Fecha" hidden>
                    <div class="col-md-12 text-center">
                        <strong>Día: <label id="fecha"></label></strong>
                    </div>
                    <div class="col-md-12">
                        <label for="motivo"><b>* Motivo de asueto</b></label>
                        <textarea class="form-control" id="dia_Motivo" name="dia_Motivo"></textarea>
                    </div>
                    <br>
                    <div class="col-md-12">
                        <label for="motivo"><b>* Sucursal</b></label>
                        <select id="sucursales" name="sucursales[]" class="select2 form-control select2-multiple" style="width: 100%" multiple="multiple" style="width: 100%">
                        </select>
                    </div>
                    <br>
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <label for="motivo"><b>* Tipo</b></label>
                                <select class="form-control show-tick">
                                    <option value="" hidden>Seleccione</option>
                                    <option value="0">Día completo</option>
                                    <option value="1">Mediodía</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect " data-dismiss="modal">Cancelar</button>
                    <button type="button" id="addDiaIn" class="btn btn-primary waves-effect waves-light">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="infoDiaInhabil" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close " data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Día inhabil</h4>
            </div>
            <input name="idEvt" id="idEvt" hidden>
            <div class="modal-body">
                <div class="col-md-12">
                    <label for="motivo"><b>Motivo de asueto</b></label>
                    <textarea class="form-control" id="infoMotivo" name="dia_Motivo" readonly></textarea>
                </div>
                <br>
                <div class="col-md-12">
                    <label for="motivo"><b>Sucursal</b></label>
                    <p id="txtSucrsales"></p>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light waves-effect " data-dismiss="modal">Cancelar</button>
                <?php if (revisarPermisos('Eliminar', $this)) { ?>
                    <div id="botonEliminar" name="botonEliminar">
                        <button type="button" id="deleteDiaIn" name="deleteDiaIn" class="btn btn-primary waves-effect waves-light">Eliminar</button>
                    </div>
                <?php } ?>
            </div>

        </div>
    </div>
</div>