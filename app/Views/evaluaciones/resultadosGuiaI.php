<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card-box">
            <div class="row" style="padding-bottom: 1%">
                <div class="col-md-12 text-left">
                    <label>* Selecciona la sucursal</label>
                    <select class="form-control select2-single" name="sucursal" id="sucursal" required>
                        <?php foreach ($sucursales as $sucursal) { ?>
                            <option value="<?= encryptDecrypt('encrypt', $sucursal['suc_SucursalID']) ?>"><?= $sucursal['suc_Sucursal'] ?></option>
                        <?php } ?>
                        <option value="<?= encryptDecrypt('encrypt', '0') ?>">TODAS</option>
                    </select>
                </div>
            </div>
            <div class="row" style="padding-bottom: 4%">
                <div class="col-md-12 text-left">
                    <label>* Selecciona el periodo</label>
                    <div class="input-daterange input-group" id="date-range">
                        <input type="text" class="form-control" id="fInicio" name="fInicio" placeholder="Seleccione inicio " required>
                        <input type="text" class="form-control" id="fFin" name="fFin" placeholder=" Seleccione fin " required>
                    </div>
                    <br>
                    <div class="text-right">
                        <button id="btn" name="btn" type="button" class="btn btn-success">Buscar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row" <?= $style ?>>

    <input hidden id="FechaInicio" name="FechaInicio" value="<?= ($FechaInicio === null) ? '' : $FechaInicio ?>">
    <input hidden id="FechaFin" name="FechaFin" value="<?= ($FechaFin === null) ? '' : $FechaFin ?>">
    <input hidden id="SucursalID" name="SucursalID" value="<?= ($SucursalID === null) ? '' : $SucursalID ?>">

    <div class="col-6 ">
        <div class="card-box">
            <div class="file-man-box rounded mb-3">
                <div class="file-img-box">
                    <iframe src="<?= $url ?>" frameborder="no" width="100%" style="min-height: 500px;">
                    </iframe>
                </div>

                <div class="file-man-title">
                    <h5 class="mb-0 " style="overflow: hidden">Evaluaciones aplicadas Guia I
                    </h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card-box">
            <div class="row mb-4">
                <div class="col-md-12">
                    <div>
                        <table id="tblEvaluados" class="table table-hover  m-0 table-centered tickets-list table-actions-bar dt-responsive " cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="10%">#</th>
                                    <th width="20%">Colaborador</th>
                                    <th width="10%">Requiere una valoración clinica</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>