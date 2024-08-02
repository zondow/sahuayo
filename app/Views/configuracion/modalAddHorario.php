<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="modalAddHorario" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title">&nbsp;Nuevo horario</h4>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <form id="frmHorario" action="#" method="post" autocomplete="off" role="form">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label for="nombre"><span style="color:red">*</span>Nombre</label>
                            <input id="txtNombre" name="txtNombre" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nombre"><span style="color:red">*</span>Tolerancia</label>
                            <input id="txtTolerancia" name="txtTolerancia" class="form-control numeric">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 text-center table-responsive">
                            <table id="tableAddHorario" class="table">
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
                                            <input type="checkbox" class="custom-control-input" id="ckLunes" name="ckLunes">
                                            <label class="custom-control-label" for="ckLunes"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox ">
                                            <input type="checkbox" class="custom-control-input" id="ckMartes" name="ckMartes">
                                            <label class="custom-control-label" for="ckMartes"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox ">
                                            <input type="checkbox" class="custom-control-input" id="ckMiercoles" name="ckMiercoles">
                                            <label class="custom-control-label" for="ckMiercoles"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox ">
                                            <input type="checkbox" class="custom-control-input" id="ckJueves" name="ckJueves">
                                            <label class="custom-control-label" for="ckJueves"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox ">
                                            <input type="checkbox" class="custom-control-input" id="ckViernes" name="ckViernes">
                                            <label class="custom-control-label" for="ckViernes"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox ">
                                            <input type="checkbox" class="custom-control-input" id="ckSabado" name="ckSabado">
                                            <label class="custom-control-label" for="ckSabado"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="custom-control custom-checkbox ">
                                            <input type="checkbox" class="custom-control-input" id="ckDomingo" name="ckDomingo">
                                            <label class="custom-control-label" for="ckDomingo"></label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <i class="fe-corner-up-right text-success" style="font-size: x-large"></i><br>
                                        Entrada
                                    </td>
                                    <td>
                                        <input name="lunesE" id="lunesE" class="form-control timepicker text-center" value="00:00" >
                                    </td>
                                    <td>
                                        <input name="martesE" id="martesE" class="form-control timepicker text-center" value="00:00" >
                                    </td>
                                    <td>
                                        <input name="miercolesE" id="miercolesE" class="form-control timepicker text-center" value="00:00" >
                                    </td>
                                    <td>
                                        <input name="juevesE" id="juevesE" class="form-control timepicker text-center" value="00:00" >
                                    </td>
                                    <td>
                                        <input name="viernesE" id="viernesE" class="form-control timepicker text-center" value="00:00" >
                                    </td>
                                    <td>
                                        <input name="sabadoE" id="sabadoE" class="form-control timepicker text-center" value="00:00" >
                                    </td>
                                    <td>
                                        <input name="domingoE" id="domingoE" class="form-control timepicker text-center" value="00:00" >
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <i class="fe-corner-down-left text-danger" style="font-size: x-large"></i><br>
                                        Salida
                                    </td>
                                    <td>
                                        <input name="lunesS" id="lunesS" class="form-control timepicker text-center" value="00:00" >
                                    </td>
                                    <td>
                                        <input name="martesS" id="martesS" class="form-control timepicker text-center" value="00:00" >
                                    </td>
                                    <td>
                                        <input name="miercolesS" id="miercolesS" class="form-control timepicker text-center" value="00:00" >
                                    </td>
                                    <td>
                                        <input name="juevesS" id="juevesS" class="form-control timepicker text-center" value="00:00" >
                                    </td>
                                    <td>
                                        <input name="viernesS" id="viernesS" class="form-control timepicker text-center" value="00:00" >
                                    </td>
                                    <td>
                                        <input name="sabadoS" id="sabadoS" class="form-control timepicker text-center" value="00:00" >
                                    </td>
                                    <td>
                                        <input name="domingoS" id="domingoS" class="form-control timepicker text-center" value="00:00" >
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
                        <button id="btnGuardarHorario" type="button" class="btn btn-round btn-success"> Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>