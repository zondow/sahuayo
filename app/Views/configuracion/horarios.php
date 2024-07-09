<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<style>

    .dtp div.dtp-date, .dtp div.dtp-time{
        background-color: #001689 !important;
    }
    .dtp > .dtp-content > .dtp-date-view > header.dtp-header {
        background-color: #001689 !important;
    }

</style>
<div class="row">
    <div class="col-md-12">
        <div class="card-box">
            <div class="row">
                <div class="col-md-12 mb-2">
                    <?php if(revisarPermisos('Agregar',$this)){ ?>
                        <a href="#" id="btnAddHorario" class="btn btn-success waves-light waves-effect"><i class="dripicons-plus" style="top: 2px !important; position: relative"></i> Agregar</a>
                    <?php } ?>
                </div>
                <div class="col-md-12">
                    <div>
                        <table id="tblHorarios" class="table table-hover  m-0 table-centered tickets-list table-actions-bar dt-responsive " cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th width="20%">Acciones</th>
                                <th width="50%">Nombre</th>
                                <th width="10%">Tolerancia</th>
                                <th width="20%">Estatus</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>