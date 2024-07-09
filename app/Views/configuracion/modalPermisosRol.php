<?php defined('FCPATH') or exit('No direct script access allowed'); ?>

<style>
    .mySidebar {
        overflow-y: scroll;
        scrollbar-width: thin;
        height: 500px !important;
    }
</style>
<div class="modal fade" id="modalSavePermisosRol" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title">Permisos del rol</h4>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <form id="formPermisos" action="<?= base_url("Configuracion/savePermisosRol") ?>" method="post" autocomplete="off" role="form">
                <input id="rol_RolIDP" name="rol_RolID" value="0" hidden>
                <div class="col-md-4 pt-2 text-right mb-3">
                    <input id="txtSearch" type="text" class="form-control search" placeholder="Buscar...">
                </div>
                <div class="modal-body mySidebar ">
                    <div id="bodyRolPermisos" class="row">

                    </div>

                </div>
                <div class="modal-footer">
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-light" data-dismiss="modal"><span class="iconsminds-close"></span> Cancelar</button>
                        <button type="submit" class="btn btn-success"><span class="iconsminds-yes"></span> Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>