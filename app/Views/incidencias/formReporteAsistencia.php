<?php defined('FCPATH') or exit('No direct script access allowed');
$url = 'https://view.officeapps.live.com/op/embed.aspx?src=https://sahuayo.thigo.mx/assets/uploads/reporteAsistencia/' . date('Y') . '/' . date('m') . '/reporteAsistencia.xlsx';
?>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="header">
                    <h2><strong>Generar reporte</strong></h2>
                </div>
                <p class="sub-header">Seleccione un rango de fechas para el reporte de asistencia.</p>

                <div class="row">
                    <div class="col-12">
                        <form method="post" action="<?= base_url("Excel/reporteAsistencias") ?>" class="form-horizontal" autocomplete="off">
                            <div class="form-group row">
                                <label class="col-3 col-form-label"> * Periodo: </label>
                                <div class="col-9">
                                    <div class="input-daterange input-group" id="date-range">
                                        <input type="text" class="form-control" name="fechaInicio" placeholder="Seleccione" required>
                                        <input type="text" class="form-control" id="fechaFin" name="fechaFin" placeholder="Seleccione" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-0 justify-content-end row text-right">
                                <div class="col-9">
                                    <button type="submit" id="btnConsultar" class="btn btn-success waves-effect waves-light">Consultar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="header">
                    <h2><strong>Recuperar fecha</strong></h2>
                </div>
                <p class="sub-header">Seleccione la fecha.</p>

                <div class="row">
                    <div class="col-12">
                        <form method="post" action="<?= base_url("Biometrico/cronJobBiometricoFallaVista") ?>" class="form-horizontal" autocomplete="off">
                            <div class="form-group row">
                                <label class="col-3 col-form-label"> * Fecha: </label>
                                <div class="col-9">
                                    <div class="input-group">
                                        <input type="text" class="form-control datepicker" name="fechaRecuperacion" placeholder="Seleccione" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-0 justify-content-end row text-right">
                                <div class="col-9">
                                    <button type="submit" id="btnConsultar" class="btn btn-success waves-effect waves-light">Consultar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="header">
                    <h2><strong>Reporte del mes de <?= numMeses(date('m')) . ' de ' . date('Y') ?></strong></h2>
                </div>
                <iframe id="iframeid" src="<?= $url ?>" width='100%' height='565px' frameborder='0'> </iframe>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="header">
                    <h2><strong>Reportes mensuales</strong></h2>
                </div>
                <div id="reportes"></div>
            </div>
        </div>
    </div>
</div>