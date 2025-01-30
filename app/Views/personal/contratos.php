<?php defined('FCPATH') or exit('No direct script access allowed'); ?>

<div class="col-md-12">
    <div class="row">
        <div class="col-md-12 text-right" style="padding-bottom: 2%">
            <?php /*if(revisarPermisos('Agregar',$this)){ */ ?>
            <a type="button" style="color: #FFFFFF" class=" btnAddContrato btn btn-success waves-effect waves-light"><i class="dripicons-plus"></i> Agregar</a>
            <?php /*} */ ?>
        </div>
        <?php
        if (!empty($contratos)) {
            foreach ($contratos as $contrato) {
                $icono = base_url("assets/images/file_icons/png.svg");
                switch ($contrato['con_TipoContrato']) {
                    case 'Trabajo Tiempo Determinado':
                        $url = base_url("PDF/trabajoTDeterminado/" . encryptDecrypt('encrypt', $contrato['con_ContratoID']) . "/" . $empleado['emp_EmpleadoID']);
                        break;
                    case 'Trabajo Tiempo Indeterminado':
                        $url = base_url("PDF/trabajoTIndeterminado/" . encryptDecrypt('encrypt', $contrato['con_ContratoID']) . "/" . $empleado['emp_EmpleadoID']);
                        break;
                    case 'Contrato Confidencialidad':
                        $url = base_url("PDF/confidencialidadColaboradores/" . encryptDecrypt('encrypt', $contrato['con_ContratoID']) . "/" . $empleado['emp_EmpleadoID']);
                        break;
                }
        ?>
                <div class="col-md-6 ">
                    <div class="card">
                        <div class="card-body">
                            <div class="file-man-box rounded">
                                <div class="file-img-box">
                                    <iframe src="<?= $url ?>" frameborder="no" width="100%" style="min-height: 500px;">
                                    </iframe>
                                </div>

                                <div class="file-man-title">
                                    <h5 style="overflow: hidden"><?= $contrato['con_TipoContrato'] ?></h5>
                                    <p>
                                        <small>Contrato <?= (($contrato['con_Fecha'] == "0000-00-00") ? 'Indefinido' : $contrato['con_Fecha']) ?></small>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        <?php }
        } else {
            echo '<div class="col-lg-12 col-xl-12"><div class="alert alert-warning text-center" style="border-radius:6px;" role="alert"><b>El empleado no tiene contratos generados por el sistema.</b></div></div>';
        } ?>
    </div>
</div>
<!--------------- Modal  ----------------->
<div id="modalContrato" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Contrato</h4>
            </div>
            <form id="formContrato" action="<?= site_url('Personal/addContrato') ?>" method="post" autocomplete="off" role="form">
                <div id="dep" class="modal-body">
                    <div class="form-group">
                        <label for="nombre">* Tipo de contrato</label>
                        <select id="con_TipoContrato" class="select2" name="con_TipoContrato" required>
                            <option hidden value="">Seleccione</option>
                            <option value="Trabajo Tiempo Determinado">Trabajo Tiempo Determinado</option>
                            <option value="Trabajo Tiempo Indeterminado">Trabajo Tiempo Indeterminado</option>
                        </select>
                        <input id="con_EmpleadoID" name="con_EmpleadoID" value="<?= $empleado['emp_EmpleadoID'] ?>" hidden>
                    </div>
                    <div class="form-group" id="salarioDeterminado">
                        <label for="salario">* Salario Quincenal (Determinado)</label>
                        <input type="number" id="con_SalarioDeterminado" name="con_SalarioDeterminado" min="0" required style="width: 100%;">
                    </div>
                    <div class="form-group" id="salarioIndeterminado">
                        <label for="salario">* Salario Quincenal (Indeterminado)</label>
                        <input type="number" id="con_SalarioIndeterminado" name="con_SalarioIndeterminado" min="0" style="width: 100%;">
                    </div>
                    <div class="form-group" id="vales">
                        <label for="salario">* Vales de despensa</label>
                        <input type="number" id="con_Vales" name="con_Vales" min="0" required style="width: 100%;">
                    </div>
                    
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-round" data-dismiss="modal">Cancelar</button>
                    <button id="guardar" type="submit" class="btn btn-success btn-round guardar">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(e) {
        $('.select2').select2({
            dropdownParent: $('#modalContrato .modal-body'), // Usamos el modal como parent directo
            placeholder: 'Seleccione una opción',
            allowClear: true,
            width: 'resolve'
        });

        $("#date-range").datepicker({
            daysOfWeekDisabled: [0],
            format: "yyyy-mm-dd",
            toggleActive: !0,
            todayHighlight: true,
            autoclose: true,
        }).on('changeDate', function(e) {
            $("#con_FechaFin").focus();
        });
    });
</script>