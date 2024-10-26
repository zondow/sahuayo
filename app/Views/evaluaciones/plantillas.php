<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div class="content pt-0">
    <div class="row mb-3">
        <div class="col-md-12 mt-2 text-right">
            <?php if (revisarPermisos('Agregar', 'plantilla')) { ?>
                <button type="button" id="addplantilla" class="btn btn-success btn-round"> <i class="zmdi zmdi-plus"></i> Agregar </button>
            <?php } ?>
        </div>
    </div>
</div>

<div class="row clearfix" >
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="body" >
                    <table class="table table-hover m-0 table-centered table-actions-bar dt-responsive" id="tblplantillas" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Creado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (!empty($plantillas)) {
                            
                            $num=1;
                            foreach ($plantillas as $plantilla) {
                                $style = '';
                                $estatus = '';
            
                                if ((int)$plantilla['pla_Estatus'] === 0) {
                                    $estatus = '<a role="button" class="btn btn-primary btn-icon  btn-icon-mini btn-round  activarInactivar" data-id="' . $plantilla["pla_PlantillaID"] . '" data-estado="' . $plantilla["pla_Estatus"] . '" title="Da clic para cambiar a Activo" href="#"><i class="zmdi zmdi-check-circle pt-2"></i></a>';
                                    $style = 'style="background-color: #e6e6e6"';
                                } else {
                                    $estatus = '<a role="button" class="btn btn-primary btn-icon  btn-icon-mini btn-round activarInactivar" data-id="' . $plantilla["pla_PlantillaID"] . '" data-estado="' . $plantilla["pla_Estatus"] . '" title="Da clic para cambiar a Inactivo" href="#"><i class="zmdi zmdi-check-circle pt-2"></i></a>';
                                }
            
                                echo '<tr ' . $style . '>
                                            <td>'.$num.'</td>
                                            <td ><strong>' . strtoupper($plantilla['pla_Nombre']) . '</strong></td>
                                            <td>' . date('d-m-Y', strtotime($plantilla['pla_Fecha'])) . '</td>
                                            <td>
                                                <a role="button" class="btn btn-info btn-icon  btn-icon-mini btn-round  editarplantilla" data-id="' . $plantilla["pla_PlantillaID"] . '" title="Da clic para editar" href="#"><i class="zmdi zmdi-edit pt-2"></i></a> 
                                                ' . $estatus . '
                                                <a role="button" class="btn btn-warning btn-icon  btn-icon-mini btn-round" href="' . base_url("Evaluaciones/addEvaluacionDesempeno/" .  $plantilla["pla_PlantillaID"]) .'" title="Da clic para crear la evaluacion" ><i class="zmdi zmdi-assignment pt-2"></i></a> 
                                            </td>
                                        </tr>';
                                $num ++;
                            }
                        } 
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    
    </div>
</div>

<!--------------- Modal  ----------------->
<div id="modalplantilla" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="titleModal"></h4>
            </div>
            <form id="formplantilla" method="post" autocomplete="off" role="form">
                <div class="modal-body">
                    <input id="id" name="pla_PlantillaID" hidden>
                    <input id="tipo" name="pla_Tipo" value="desempeño" hidden>
                    <div class="form-group col-md-12">
                        <label for="nombre">* Nombre </label>
                        <input type="text" id="nombre" class="form-control" name="pla_Nombre" placeholder="Escriba el nombre" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-light btn-round" data-dismiss="modal">Cancelar</button>
                        <button id="guardar" type="button" class="btn btn-success btn-round">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
