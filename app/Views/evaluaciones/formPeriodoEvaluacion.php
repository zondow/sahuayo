<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="col-md-12 text-right">
                    <?php if (revisarPermisos('Agregar', 'periodoEvaluacion')) { ?>
                        <a href="#" class="btn btn-success btn-round mb-1 modalPeriodoEvaluacion"><i class="zmdi zmdi-plus"></i> Agregar</a>
                    <?php } ?>
                </div>
                <div>
                    <table id="datatablePeriodo" class="table mt-0 table-hover m-0 table-centered  dt-responsive " cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Tipo de evaluación</th>
                                <th>Inicio</th>
                                <th>Fin</th>
                                <th>Estatus</th>
                                <th>Acciones</th>
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
                <h4 class="modal-title"><b class="iconsminds-next"></b> Período de evaluación</h5>
                    <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <form id="formPeriodo" method="post" autocomplete="off">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12" style="padding-bottom: 1%">
                            <label>* Tipo de evaluación</label>
                            <select id="eva_Tipo" name="eva_Tipo" class="select2">
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
                    <div class="text-right col-md-12">
                        <button class="btn btn-light btn-round" data-dismiss="modal">Cancelar</button>
                        <button type="button" id="btnSavePeriodo" class="btn btn-success btn-round">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(e) {
        $('.select2').select2({
            dropdownParent: $('#modalPeriodoEv .modal-body'),
            placeholder: 'Seleccione una opción',
            allowClear: true,
            width: 'resolve'
        });
    });
</script>