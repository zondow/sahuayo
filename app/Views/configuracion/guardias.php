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
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="ml-auto d-flex align-items-center">
                        <div class="mr-2">
                            <?php if (revisarPermisos('Agregar', $this)) { ?>
                                <button id="addGuardia" class="btn btn-success btn-round">
                                    <i class="zmdi zmdi-plus"></i> Agregar
                                </button>
                            <?php } ?>
                        </div>
                        <div>
                            <button class="btn btn-success btn-round btnModalImportarGuardia" style="background-color: #1c693f;">
                                <i class="zmdi zmdi-import-export"></i> Importar masivo
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div>
                        <table id="tblGuardia" class="table table-hover text-center m-0 table-centered tickets-list table-actions-bar dt-responsive " cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Colaborador</th>
                                    <th>Fecha Inicio</th>
                                    <th>Fecha Fin</th>
                                    <th width="5%">Acciones</th>
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
            <form id="frmGuardia" action="<?= base_url('Configuracion/addGuardia') ?>" method="post" autocomplete="off" role="form">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-8">
                            <label for="nombre"> <span style="color:red">*</span>Nombre</label>
                            <select id="colaborador" name="colaborador" class="select2 ">
                                <option></option>
                                <?php foreach ($empleados as $empleado) { ?>
                                    <option value="<?= encryptDecrypt('encrypt', $empleado['emp_EmpleadoID']) ?>"><?= $empleado['emp_Nombre'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-4" style="padding-top: 1%;">
                            <label for="nombre"> <span style="color:red">*</span>Semana</label>
                            <input type="text" class="datepicker" name="txtFechas" id="txtFechas" placeholder="Selecciona la semana" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer ">
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-round btn-light" data-dismiss="modal"> Cancelar</button>
                        <button type="submit" class="btn btn-round btn-success"> Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(e) {

        $('#txtFechas').datepicker({
            autoclose: true,
            format: 'yyyy/mm/dd',
            forceParse: false,
            todayHighlight: !0,
            daysOfWeekDisabled: [0],
            appendTo: ".modal-body",
        }).on("changeDate", function(e) {
            firstDate = moment($('#txtFechas').val(), "YYYY-MM-DD").day(1).format("YYYY-MM-DD");
            lastDate = moment($('#txtFechas').val(), "YYYY-MM-DD").day(6).format("YYYY-MM-DD");
            $("#txtFechas").val(firstDate + "   al   " + lastDate);
        });

        $('.select2').select2({
            dropdownParent: $('#modalAddGuardia .modal-body'),
            placeholder: 'Seleccione una opción',
            allowClear: true,
            width: 'resolve'
        });
    });
</script>