<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<style>
    .dtp div.dtp-date,
    .dtp div.dtp-time {
        background-color: #001689 !important;
    }

    .dtp>.dtp-content>.dtp-date-view>header.dtp-header {
        background-color: #001689 !important;
    }
</style>
<div class="card">
    <div class="card-body">
        <div class="col-md-12 mb-2 text-right">
            <?php if (revisarPermisos('Agregar', $this)) { ?>
                <button id="btnAddHorario" class="btn btn-success btn-round ">
                    <i class="zmdi zmdi-plus"></i> Agregar
                </button>
            <?php } ?>
        </div>
        <div class="col-md-12">
            <div>
                <table id="tblHorarios" class="table table-hover  m-0 table-centered tickets-list table-actions-bar dt-responsive " cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Tolerancia</th>
                            <th>Estatus</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>