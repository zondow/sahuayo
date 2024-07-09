<?php defined('FCPATH') or exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-md-12">
        <div class="card-box">
            <h4 class="header-title mb-4">SOLICITUD DE HORAS EXTRA</h4>
            <form method="post" id="formHoras" autocomplete="off">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="fecha"> * Fecha </label>
                        <input type="text" class="input-sm form-control datepicker" name="fecha" id="fecha" placeholder="Seleccione" required/>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="horaSalida">* Hora inicio</label>
                        <input type="text" class="input-sm form-control timepicker" name="horaInicio" id="horaInicio" placeholder="Seleccione" required />
                    </div>
                    <div class="form-group col-md-4">
                        <label for="horaRegreso">* Hora fin</label>
                        <input type="text" class="input-sm form-control timepicker" name="horaFin" id="horaFin" placeholder="Seleccione" required/>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="motivos"> * Motivo, evento o trabajo realizado </label>
                        <textarea rows="2" class="form-control" id="motivos" name="motivos" placeholder="Escriba el motivo" required></textarea>
                    </div>
                </div>
                <button type="submit" id="btnGuardar" class="btn btn-primary waves-effect waves-light">Guardar</button>
            </form>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="card-box">
            <table id="tblHoras" class="table table-hover m-0 table-centered tickets-list table-actions-bar dt-responsive" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th width="5%">Acciones</th>
                    <th >#</th>
                    <th >Dia</th>
                    <th >Total horas</th>
                    <th >Motivos</th>
                    <th >Tipo de pago</th>
                    <th >Estatus</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>