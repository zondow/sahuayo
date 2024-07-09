<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div class="content pt-0">
    <div class="row mb-3">
        <div class="col-md-12 mt-2 ">
            <?php if (revisarPermisos('Agregar', $this)) { ?>
                <button type="button" id="addArea" class="btn btn-success waves-effect waves-light"><i class="dripicons-plus" style="top: 2px !important; position: relative"></i> Agregar</button>
            <?php } ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3 mb-3">
        <input id="txtSearch" type="text" class="form-control search" placeholder="Buscar...">
    </div>
</div>
<div class="row" id="divAreas">
</div>
</div>

<!--------------- Modal  ----------------->
<div id="modalArea" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="titleModal"></h4>
            </div>
            <form id="formArea" method="post" autocomplete="off" role="form">
                <div class="modal-body">
                    <input id="id" name="are_AreaID" hidden>
                    <div class="form-group col-md-12">
                        <label for="nombre">* Area </label>
                        <input type="text" id="nombre" class="form-control" name="are_Nombre" placeholder="Escriba el nombre" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Cancelar</button>
                    <button id="guardar" type="button" class="btn btn-primary waves-effect waves-light">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>