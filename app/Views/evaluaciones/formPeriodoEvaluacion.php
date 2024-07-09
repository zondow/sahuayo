<div class="row">
    <div class="col-md-12">
        <div class="card-box">
            <div class="row">
                <?php if (revisarPermisos('Agregar', $this)) { ?>
                    <div class="mb-2 col-md-2 text-left">
                        <a href="#" class="btn btn-success btn-block mb-1 modalPeriodoEvaluacion"><b class="dripicons-plus"></b> Agregar</a>
                    </div>
                <?php } ?>
            </div>
            <div>
                <table id="datatablePeriodo" class="table mt-0 table-hover m-0 table-centered  dt-responsive " cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th style="width: 170px !important;">Acciones</th>
                            <th>Tipo de evaluación</th>
                            <th>Inicio</th>
                            <th>Fin</th>
                            <th>Estatus</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>

<div class="modal fade in" id="modalPeriodoEv" style="background-color:rgba(10, 10, 10, 0.5);">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><b class="iconsminds-next"></b> Período de evaluación</h4>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <form id="formPeriodo" method="post" autocomplete="off">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12" style="padding-bottom: 1%">
                            <label>* Tipo de evaluación</label>
                            <select id="eva_Tipo" name="eva_Tipo" class="selectpicker">
                                <option value="0" hidden>Seleccione</option>
                                <option value="Desempeño">Desempeño</option>
                                <option value="Competencias">Competencias</option>
                                <option value="Clima Laboral">Clima Laboral</option>
                                <option value="Nom035">Nom 035</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12" style="padding-bottom: 1%">
                            <label>* Periodo</label>
                            <div class="input-daterange input-group" id="date-range">
                                <input type="text" class="form-control" id="fInicio" name="fInicio" placeholder="Seleccione inicio " required>
                                <input type="text" class="form-control" id="fFin" name="fFin" placeholder=" Seleccione fin " required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btnSavePeriodo" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>