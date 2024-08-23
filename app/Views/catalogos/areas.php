<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div class="content pt-0">
    <div class="row mb-3">
        <div class="col-md-12 mt-2 text-right">
            <?php if (revisarPermisos('Agregar', $this)) { ?>
                <button type="button" id="addArea" class="btn btn-success btn-round"> <i class="zmdi zmdi-plus"></i> Agregar </button>
            <?php } ?>
        </div>
    </div>
</div>

<div class="row clearfix" >
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="body" >
                    <table class="table table-hover m-0 table-centered table-actions-bar dt-responsive" id="tblAreas" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Área</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if (!empty($areas)) {
                            
                
                            foreach ($areas as $area) {
                                $style = '';
                                $estatus = '';
            
                                if ((int)$area['are_Estatus'] === 0) {
                                    $estatus = '<a role="button" class="btn btn-primary btn-icon  btn-icon-mini btn-round  activarInactivar" data-id="' . $area["are_AreaID"] . '" data-estado="' . $area["are_Estatus"] . '" href="#"><i class="zmdi zmdi-check-circle pt-2"></i></a>';
                                    $style = 'style="background-color: #e6e6e6"';
                                } else {
                                    $estatus = '<a role="button" class="btn btn-primary btn-icon  btn-icon-mini btn-round activarInactivar" data-id="' . $area["are_AreaID"] . '" data-estado="' . $area["are_Estatus"] . '" href="#"><i class="zmdi zmdi-check-circle pt-2"></i></a>';
                                }
            
                                echo '<tr ' . $style . '>
                                            <td ><strong>' . strtoupper($area['are_Nombre']) . '</strong></td>
                                            <td>
                                                <a role="button" class="btn btn-info btn-icon  btn-icon-mini btn-round  editarArea" data-id="' . $area["are_AreaID"] . '" title="Da clic para editar" href="#"><i class="zmdi zmdi-edit pt-2"></i></a> 
                                                ' . $estatus . '
                                            </td>
                                        </tr>';
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
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-light btn-round" data-dismiss="modal">Cancelar</button>
                        <button id="guardar" type="button" class="btn btn-success btn-round">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
