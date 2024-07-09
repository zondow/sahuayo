<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<style>
    .select2-container{
        width: 100% !important;
    }
</style>
<div class="row">
    <div class="col-12">
        <div class="card-box">
            <table class="table table-hover m-0 table-centered tickets-list table-actions-bar dt-responsive datatable" cellspacing="0" width="100%" id="tVacaciones">
                <thead>
                <tr>
                    <th width="5%">Acciones</th>
                    <th class="w-10">Fecha</th>
                    <th class="w-40">Solicita</th>
                    <th class="w-40">Puesto solicitado</th>
                    <th class="w-40">Estado</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if(!empty($solicitudes))
                   foreach ($solicitudes as $solicitud){
                       echo '<tr>';
                       echo '<td>';
                       echo '<a type="button" href="'.base_url("Reclutamiento/infoReqPer/".encryptDecrypt('encrypt',$solicitud['sol_SolicitudPersonalID'])).'" class="btn btn-info waves-effect waves-light  btn-block" style="color:#FFFFFF;" title="Seguimiento"><i class="far fa-eye "></i> </a>';
                       echo '</td>';
                       echo '<td class="w-10">'.$solicitud['sol_Fecha'].'</td>';
                       echo '<td class="w-40">'.$solicitud['emp_Nombre'].'</td>';
                       if($solicitud['pue_Nombre']){
                           $puesto =$solicitud['pue_Nombre'];
                       }else{
                           $puesto = $solicitud['sol_Puesto'];
                       }
                       echo '<td class="w-40">'.$puesto.'</td>';
                       if($solicitud['sol_Estatus']==1){
                            echo '<td><span class="badge badge-info">EN PROCESO</span></td>';
                       }else{
                            echo '<td><span class="badge badge-dark">TERMINADA</span></td>';
                       }
                       echo '</tr>';
                    }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $(".datatable").DataTable({
            language:
                {
                    paginate: {
                        previous:"<i class='mdi mdi-chevron-left'>",
                        next:"<i class='mdi mdi-chevron-right'>"
                    },
                    "sProcessing":     "Procesando...",
                    "sLengthMenu":     "Mostrar _MENU_ registros",
                    "sZeroRecords":    "No se encontraron resultados",
                    "sEmptyTable":     "Ningún dato disponible en esta tabla.",
                    "sInfo":           "",
                    "sInfoEmpty":      "",
                    "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix":    "",
                    "sSearch":         "Buscar:",
                    "sUrl":            "",
                    "sInfoThousands":  ",",
                    "sLoadingRecords": "Cargando...",
                },
        });
    
    });
</script>