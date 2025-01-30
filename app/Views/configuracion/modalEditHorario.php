<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="modalEditHorario" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" style="max-width: 910px !important;" role="document">
        <div class="modal-content" style="max-width: 910px !important;">
            <div class="modal-header">
                <h5 class="title">&nbsp;Editar horario</h5>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <form id="frmHorarioEdit" action="#" method="post" autocomplete="off" role="form">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="nombre">*Nombre</label>
                            <input id="txtNombreEdit" name="txtNombreEdit" class="form-control">
                            <input id="txtHorarioID" name="txtHorarioID" class="form-control" hidden>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nombre">*Tolerancia</label>
                            <input id="txtToleranciaEdit" name="txtToleranciaEdit" class="form-control numeric">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th><b>Lunes</b></th>
                                    <th><b>Martes</b></th>
                                    <th><b>Miércoles</b></th>
                                    <th><b>Jueves</b></th>
                                    <th><b>Viernes</b></th>
                                    <th><b>Sábado</b></th>
                                    <th><b>Domingo</b></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><b>Descanso</b></td>
                                    <td>
                                        <div class="custom-control custom-checkbox ">
                                            <input type="checkbox" class="custom-control-input" id="ckLunes_Edit" name="ckLunes">
                                            <label class="custom-control-label" for="ckLunes_Edit"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox ">
                                            <input type="checkbox" class="custom-control-input" id="ckMartes_Edit" name="ckMartes">
                                            <label class="custom-control-label" for="ckMartes_Edit"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox ">
                                            <input type="checkbox" class="custom-control-input" id="ckMiercoles_Edit" name="ckMiercoles">
                                            <label class="custom-control-label" for="ckMiercoles_Edit"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox ">
                                            <input type="checkbox" class="custom-control-input" id="ckJueves_Edit" name="ckJueves">
                                            <label class="custom-control-label" for="ckJueves_Edit"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox ">
                                            <input type="checkbox" class="custom-control-input" id="ckViernes_Edit" name="ckViernes">
                                            <label class="custom-control-label" for="ckViernes_Edit"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox ">
                                            <input type="checkbox" class="custom-control-input" id="ckSabado_Edit" name="ckSabado">
                                            <label class="custom-control-label" for="ckSabado_Edit"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox ">
                                            <input type="checkbox" class="custom-control-input" id="ckDomingo_Edit" name="ckDomingo">
                                            <label class="custom-control-label" for="ckDomingo_Edit"></label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <i class="fe-corner-up-right text-success" style="font-size: x-large"></i><br>
                                        Entrada
                                    </td>
                                    <td>
                                        <input name="lunesE" id="lunesE_Edit" class="form-control timepicker text-center" value="00:00" >
                                    </td>
                                    <td>
                                        <input name="martesE" id="martesE_Edit" class="form-control timepicker text-center" value="00:00" >
                                    </td>
                                    <td>
                                        <input name="miercolesE" id="miercolesE_Edit" class="form-control timepicker text-center" value="00:00" >
                                    </td>
                                    <td>
                                        <input name="juevesE" id="juevesE_Edit" class="form-control timepicker text-center" value="00:00" >
                                    </td>
                                    <td>
                                        <input name="viernesE" id="viernesE_Edit" class="form-control timepicker text-center" value="00:00" >
                                    </td>
                                    <td>
                                        <input name="sabadoE" id="sabadoE_Edit" class="form-control timepicker text-center" value="00:00" >
                                    </td>
                                    <td>
                                        <input name="domingoE" id="domingoE_Edit" class="form-control timepicker text-center" value="00:00" >
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <i class="fe-corner-down-left text-danger" style="font-size: x-large"></i><br>
                                        Salida
                                    </td>
                                    <td>
                                        <input name="lunesS" id="lunesS_Edit" class="form-control timepicker text-center" value="00:00" >
                                    </td>
                                    <td>
                                        <input name="martesS" id="martesS_Edit" class="form-control timepicker text-center" value="00:00" >
                                    </td>
                                    <td>
                                        <input name="miercolesS" id="miercolesS_Edit" class="form-control timepicker text-center" value="00:00" >
                                    </td>
                                    <td>
                                        <input name="juevesS" id="juevesS_Edit" class="form-control timepicker text-center" value="00:00" >
                                    </td>
                                    <td>
                                        <input name="viernesS" id="viernesS_Edit" class="form-control timepicker text-center" value="00:00" >
                                    </td>
                                    <td>
                                        <input name="sabadoS" id="sabadoS_Edit" class="form-control timepicker text-center" value="00:00" >
                                    </td>
                                    <td>
                                        <input name="domingoS" id="domingoS_Edit" class="form-control timepicker text-center" value="00:00" >
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer row">
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-round btn-light" data-dismiss="modal"> Cancelar</button>
                        <button id="btnActualizarHorario" type="button" class="btn btn-round btn-success"> Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>