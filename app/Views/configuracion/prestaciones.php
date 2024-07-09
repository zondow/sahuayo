<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card-box">
            <h4 class="header-title mb-4">Configuración de prestaciones</h4>
            <ul class="nav nav-pills navtab-bg nav-justified pull-in ">
                <li class="nav-item">
                    <a href="#ley" data-toggle="tab" aria-expanded="false" class="nav-link active">
                        <i class="fas fa-balance-scale"></i><span class="d-none d-sm-inline-block ml-2">De ley</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#adicionales" data-toggle="tab" aria-expanded="true" class="nav-link ">
                        <i class="fas fa-medal"></i> <span class="d-none d-sm-inline-block ml-2">Adicionales</span>
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane show active" id="ley">
                    <h4>PRIMA POR PRESTACIONES DE SERVICIO EN DIAS NO LABORABLES</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card-box ribbon-box">
                                <div class="ribbon ribbon-success" style="background-color: #797979;">Día no laboral </div>
                                <table class="table table-borderless table-sm mb-0">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" value="200" readonly>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">%</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card-box ribbon-box">
                                <div class="ribbon ribbon-success" style="background-color: #797979;">Dia domingo </div>
                                <table class="table table-borderless table-sm mb-0">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <input type="number" class="form-control" value="225" readonly>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">%</span>
                                                        </div>
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
                                <h4>VACACIONES</h4>
                                <div class="row card-box">
                                    <?php
                                    for ($i = 1; $i <= $rangos; $i++) { ?>
                                        <div class="form-group col-md-3 ">
                                            <h4><label class=" col-form-label badge " style="background-color: #797979;"><?= $i ?> Añ<?= $i == 1 ? 'o' : 'os' ?> </label></h4>
                                            <div class=" input-group ">
                                                <input type="number" name="dias[]" class="form-control" min="1" value="<?= !empty($vacaciones[$i - 1]['dias']) ? $vacaciones[$i - 1]['dias'] : 1 ?>" required>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">días</span>
                                                </div>
                                            </div>
                                            <input type="hidden" name="periodo[]" value="<?= $i ?>">
                                        </div>
                                    <?php } ?>
                                </div>
                                <hr>
                                <h4>PRIMA VACACIONAL</h4>
                                <div class="row">
                                    <?php
                                    for ($i = 1; $i <= $rangosPrima; $i++) { ?>
                                        <div class="col-md-3">
                                            <div class="card-box ribbon-box">
                                                <div class="ribbon ribbon-success" style="background-color: #797979;"><?= $i ?> Añ<?= $i == 1 ? 'o' : 'os' ?></div>
                                                <div class=" input-group ">
                                                    <input type="number" name="prima[]" class="form-control" min="1" value="<?= !empty($prima[$i - 1]['prima']) ? $prima[$i - 1]['prima'] : 1 ?>" required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">%</span>
                                                    </div>
                                                    <input type="hidden" name="periodoP[]" value="<?=$i?>">
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <hr>
                                <h4>AGUINALDO</h4>
                                <div class="row">
                                    <?php
                                    for ($i = 1; $i <= $rangosAguinaldo; $i++) { ?>
                                        <div class="col-md-3">
                                            <div class="card-box ribbon-box">
                                                <div class="ribbon ribbon-success" style="background-color: #797979;"><?= $i ?> Añ<?= $i == 1 ? 'o' : 'os' ?></div>
                                                <div class=" input-group ">
                                                    <input type="number" name="aguinaldo[]" class="form-control" min="1" value="<?= !empty($aguinaldo[$i - 1]['aguinaldo']) ? $aguinaldo[$i - 1]['aguinaldo'] : 1 ?>" required>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">días</span>
                                                    </div>
                                                    <input type="hidden" name="periodoA[]" value="<?=$i?>">
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                                <?php if (revisarPermisos('Agregar', $this)) { ?>
                                    <button type="submit" class="btn btn-primary"> Guardar</button>
                                <?php } ?>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="adicionales">
                    <form action="<?= base_url('Configuracion/guardarPrestacionesAadicionales') ?>" method="post" autocomplete="off">
                        <h4>PRESTAMO DE EMPLEADO</h4>
                        <div class="row">
                            <?php
                            for ($i = 1; $i <= 5; $i++) { ?>
                                <div class="col-md-4">
                                    <div class="card-box ribbon-box">
                                        <div class="ribbon ribbon-success" style="background-color: #797979;"><?= $i ?> Añ<?= $i == 1 ? 'o' : 'os' ?></div>
                                        <div class=" input-group ">
                                            <input type="number" name="diasPrestamo[]" class="form-control" min="1" value="<?= !empty($prestamo[$i - 1]['dias']) ? $prestamo[$i - 1]['dias'] : 1 ?>" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">días</span>
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <input type="number" name="plazo[]" class="form-control" min="1" step="any" value="<?= ($prestamo) ? $prestamo[$i-1]['plazo'] : "12" ?>" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">Plazo (Meses)</span>
                                            </div>
                                        </div>
                                        <input type="hidden" name="periodoPrestamos[]" value="<?=$i?>">
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <?php if (revisarPermisos('Agregar', $this)) { ?>
                            <button type="submit" class="btn btn-primary"> Guardar</button>
                        <?php } ?>
                    </form>
                </div>
            </div>
        </div>
    </div> <!-- end col -->
</div>