<div id="modalCompetencias" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Competencia</h4>
            </div>
            <div class="modal-body">
                <form id="formCompetencias" method="post" autocomplete="off">

                    <input type="hidden" name="competenciaID" id="competenciaID" value="">

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="com_Nombre" class="col-form-label">* Nombre</label>
                            <input type="text" class="form-control" id="com_Nombre" name="com_Nombre">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="com_Descripcion" class="col-form-label">* Descripción</label>
                            <textarea class="form-control" rows="3" id="com_Descripcion" name="com_Descripcion"></textarea>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="com_Tipo" class="col-form-label">* Tipo</label>
                            <select class="form-control select2" name="com_Tipo" id="com_Tipo">
                                <option value="Sociales y Actitudinales">Sociales y Actitudinales</option>
                                <option value="Tecnicas y Funcionales">Tecnicas y Funcionales</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="col-md-12 text-right">
                    <button type="button" class="btn btn-dark btn-round" data-dismiss="modal">Cancelar</button>
                    <a href="#" id="guardarCompetencia" class="btn btn-success btn-round">Guardar</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function (e) {
    $('.select2').select2({
        dropdownParent: $('#modalCompetencias .modal-body'),
        placeholder: 'Seleccione una opción',
        allowClear: true,
        width: 'resolve'
    });
});
</script>