<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div class="content pt-0">
    <div class="row mb-3">
            <div class="col-md-12 mt-2 ">
                <?php if(revisarPermisos('Agregar',$this)){ ?>
                <button type="button" id="addCapsula" class="btn btn-success waves-effect waves-light" ><i class="dripicons-plus" style="top: 2px !important; position: relative"></i> Agregar</button>
                <?php } ?>
            </div>
    </div>
    <div class="row">
        <div class="col-md-3 mb-3">
            <input id="txtSearch" type="text" class="form-control search" placeholder="Buscar...">
        </div>
    </div>
    <div class="row" id="divCapsulas">
    </div>
</div>

<!--------------- Modal  ----------------->
<div id="modalCapsula" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="titleModal"></h4>
            </div>
            <form id="formCapsula"  method="post" autocomplete="off" role="form">
                <div class="modal-body">
                    <input id="id" name="cap_CapsulaID" hidden >
                    <div class="form-group col-md-12">
                        <label for="titulo">* Titulo</label>
                        <input type="text" id="titulo" class="form-control" name="cap_Titulo"  placeholder="Escriba el titulo de la cápsula" required>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="descripcion">* Descripción</label>
                        <textarea class="form-control" rows="1" id="descripcion" name="cap_Descripcion" placeholder="Escriba una descripción de la cápsula"></textarea>
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