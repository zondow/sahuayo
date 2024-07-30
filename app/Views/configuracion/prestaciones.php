<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="header">
                <h2><strong>Configuración de prestaciones</strong></h2>
            </div>
            <ul class="nav nav-tabs">
                <li class="nav-item" style="width: 50%; text-align:center;"><a href="#ley" class="nav-link active" data-toggle="tab"><i class="zmdi zmdi-balance"></i> De Ley</a></li>
                <li class="nav-item" style="width: 50%; text-align:center;"><a href="#adicionales" class="nav-link" data-toggle="tab"><i class="zmdi zmdi-collection-plus"></i> Adicionales</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane show active" id="ley">
                    <div class="header">
                        <h2><strong>Prima por prestaciones de servicio en días no laborales</strong></h2>
                    </div>
                    <div class="row" style="padding:2%;">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="badge bg-green float-md-right" style="border-radius:10px">Día no laboral </div>
                                <table class="table table-borderless table-sm mb-0">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" value="200" readonly>
                                                        <span class="input-group-addon" style="background:#e3e3e3;">%</span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="badge bg-green float-md-right" style="border-radius:10px">Dia domingo </div>
                                <table class="table table-borderless table-sm mb-0">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" value="225" readonly>
                                                        <span class="input-group-addon" style="background:#e3e3e3;">%</span>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <form method="post" action="<?= base_url("Configuracion/guardarPrestacionesActuales") ?>" autocomplete="off">
                                <input name="tipo" value="Actual" hidden>
                                <div class="header">
                                    <h2><strong>Vacaciones</strong></h2>
                                </div>
                                <div class="row card-box" style="padding: 2%;">
                                    <?php
                                    for ($i = 1; $i <= $rangos; $i++) { ?>
                                        <div class="form-group col-md-3 ">
                                            <span class="badge bg-green float-md-right" style="border-radius: 10px;"><?= $i ?> Añ<?= $i == 1 ? 'o' : 'os' ?></span>
                                            <div class=" input-group ">
                                                <input type="number" name="dias[]" class="form-control" min="1" value="<?= !empty($vacaciones[$i - 1]['dias']) ? $vacaciones[$i - 1]['dias'] : 1 ?>" required>
                                                <span class="input-group-addon">días</span>
                                            </div>
                                            <input type="hidden" name="periodo[]" value="<?= $i ?>">
                                        </div>
                                    <?php } ?>
                                </div>
                                <hr>
                                <div class="header">
                                    <h2><strong>Prima vacacional</strong></h2>
                                </div>
                                <div class="row" style="padding: 2%;">
                                    <?php
                                    for ($i = 1; $i <= $rangosPrima; $i++) { ?>
                                        <div class="col-md-3">
                                            <div class="card">
                                                <div class="badge bg-green float-md-right" style="border-radius:10px"><?= $i ?> Añ<?= $i == 1 ? 'o' : 'os' ?></div>
                                                <div class=" input-group ">
                                                    <input type="number" name="prima[]" class="form-control" min="1" value="<?= !empty($prima[$i - 1]['prima']) ? $prima[$i - 1]['prima'] : 1 ?>" required>
                                                    <span class="input-group-addon" style="border-left: 0 none;">%</span>
                                                    <input type="hidden" name="periodoP[]" value="<?= $i ?>">
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <hr>
                                <div class="header">
                                    <h2><strong>Aguinaldo</strong></h2>
                                </div>
                                <div class="row" style="padding: 2%;">
                                    <?php
                                    for ($i = 1; $i <= $rangosAguinaldo; $i++) { ?>
                                        <div class="col-md-3">
                                            <div class="card">
                                                <div class="badge bg-green float-md-right" style="border-radius:10px"><?= $i ?> Añ<?= $i == 1 ? 'o' : 'os' ?></div>
                                                <div class=" input-group ">
                                                    <input type="number" name="aguinaldo[]" class="form-control" min="1" value="<?= !empty($aguinaldo[$i - 1]['aguinaldo']) ? $aguinaldo[$i - 1]['aguinaldo'] : 1 ?>" required>
                                                    <span class="input-group-addon" style="border-left: 0 none;">días</span>
                                                    <input type="hidden" name="periodoA[]" value="<?= $i ?>">
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <?php if (revisarPermisos('Agregar', $this)) { ?>
                                    <button type="submit" class="btn btn-primary float-md-right"> Guardar</button>
                                <?php } ?>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="adicionales">
                    <form action="<?= base_url('Configuracion/guardarPrestacionesAadicionales') ?>" method="post" autocomplete="off">
                        <div class="header">
                            <h2><strong>Prestamo de empleado</strong></h2>
                        </div>
                        <div class="row" style="padding: 2%;">
                            <?php
                            for ($i = 1; $i <= 5; $i++) { ?>
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="badge bg-green float-md-right" style="border-radius:10px"><?= $i ?> Añ<?= $i == 1 ? 'o' : 'os' ?></div>
                                        <div class=" input-group ">
                                            <input type="number" name="diasPrestamo[]" class="form-control" min="1" value="<?= !empty($prestamo[$i - 1]['dias']) ? $prestamo[$i - 1]['dias'] : 1 ?>" required>
                                            <span class="input-group-addon" style="border-left: 0 none;">días</span>
                                        </div>
                                        <div class="input-group">
                                            <input type="number" name="plazo[]" class="form-control" min="1" step="any" value="<?= ($prestamo) ? $prestamo[$i - 1]['plazo'] : "12" ?>" required>
                                            <span class="input-group-addon" style="border-left: 0 none;">Plazo (Meses)</span>
                                        </div>
                                        <input type="hidden" name="periodoPrestamos[]" value="<?= $i ?>">
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <?php if (revisarPermisos('Agregar', $this)) { ?>
                            <button type="submit" class="btn btn-primary float-md-right"> Guardar</button>
                        <?php } ?>
                    </form>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div>