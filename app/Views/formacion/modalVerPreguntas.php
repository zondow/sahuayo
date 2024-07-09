<style>
    #datatablePre {
        table-layout: fixed;
        width: 100% !important;
    }
    #datatablePre td,
    #datatablePre th{
        width: auto !important;
        white-space: normal;
        text-overflow: ellipsis;
        overflow: hidden;
        word-break: break-all;
        word-break: break-word;
    }
</style>
<div id="modalVerPreguntas" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="">Preguntas de la competencia</h4>
            </div>
            <div class="modal-body">

                <form id="formPre" >
                    <div class="row">
                        <div class="col-md-10">
                            <textarea  class="form-control" id="txtpregunta" placeholder="* Agrega una pregunta" required></textarea>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btnaddPre btn-primary ml-2">Agregar</button>
                        </div>
                    </div>
                </form>

                <div class="row">
                    <div class="col-12 p-4 table-responsive table-responsive">
                        <table class="table table-hover m-0 table-centered tickets-list table-actions-bar dt-responsive nowrap" cellspacing="0" width="100%" id="datatablePre">
                            <thead>
                            <tr>
                                <th >Pregunta</th>
                                <th >Acciones</th>
                            </tr>
                            </thead>
                            <tbody id="tbodyPre">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
