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
<div id="modalClave" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="">Acciones Clave</h4>
            </div>
            <div class="modal-body">

                <form id="formCla" >
                    <div class="row">
                        <div class="col-md-7">
                            <textarea  class="form-control" id="txtclave" placeholder="* Agrega una acción clave" required></textarea>
                        </div>
                        <div class="col-md-3">
                            <input type="number"  class="form-control" id="cla_NoOrden" placeholder="* No. de orden" required>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btnaddClav btn-primary ml-2">Agregar</button>
                        </div>
                    </div>
                </form>

                <div class="row">
                    <div class="col-12 p-4 table-responsive ">
                        <table class="table table-hover" cellspacing="0" width="100%" id="datatableClave">
                            <thead>
                            <tr>
                                <th >No. de Orden</th>
                                <th >Acción Clave</th>
                                <th >Acciones</th>
                            </tr>
                            </thead>
                            <tbody id="tbodyCla">
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
