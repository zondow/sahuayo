
<div class="content pt-0">
    <div class="row mb-3">
        <div class="col-md-12 mt-2 text-right">
            <?php if (revisarPermisos('Agregar', 'sucursales')) { ?>
                <button type="button"  class="btn btn-success btn-round btnAddSucursal"> <i class="zmdi zmdi-plus"></i> Agregar </button>
            <?php } ?>
        </div>
    </div>
</div>

<div class="row clearfix" >
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="body" >
                <table class="table table-hover m-0 table-centered table-actions-bar dt-responsive" id="tblSucursales" cellspacing="0" width="100%" >
                    <thead>
                    <tr>
                        <th>Sucursal</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php

                    if (!empty($sucursales)) {
                        foreach ($sucursales as $sucursal) {
                            $style = '';
                            $estatus = '';

                            // Obtener el ID de la sucursal
                            $sucursalID = (int)$sucursal['suc_SucursalID'];

                            // Manejo del estatus de la sucursal si se tienen permisos
                            if (revisarPermisos('Baja', 'sucursales')) {
                                $sucStatus = (int)$sucursal['suc_Estatus'];
                                $encryptedID = encryptDecrypt('encrypt', $sucursalID);

                                if ($sucStatus == 1) {
                                    $estatus .= '<a role="button" class="btn btn-icon  btn-icon-mini btn-round btn-primary activarInactivar" data-id="' . $encryptedID . '" data-estado="0" title="Da clic para cambiar a Inactivo" href="#"><i class="zmdi zmdi-check-circle pt-2"></i></a>';
                                } else {
                                    $estatus .= '<a role="button" class="btn btn-icon  btn-icon-mini btn-round btn-primary activarInactivar" data-id="' . $encryptedID . '" data-estado="1" title="Da clic para cambiar a Activo" href="#"><i class="zmdi zmdi-check-circle pt-2"></i></a>';
                                    $style = 'style="background-color: #e6e6e6"';
                                }
                            }

                            ?>
                            <tr <?= $style ?>>
                                <td><strong><?= strtoupper(htmlspecialchars($sucursal['suc_Sucursal'])) ?></strong></td>
                                <td>
                                    <?php if (revisarPermisos('Editar', 'sucursales')) { ?>
                                        <a type="button" class="btn btn-info btn-icon  btn-icon-mini btn-round editarSucursal" data-id="<?= $encryptedID ?>" style="color:#FFFFFF"><i class="zmdi zmdi-edit pt-2"></i></a>
                                    <?php } ?>
                                    <?= $estatus ?>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
            
       
 
<!--Modal-->
<div id="modalSucursal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel"></h4>
            </div>
            <form id="formSucursal" action="<?=base_url('Catalogos/addSucursal')?>" method="post" autocomplete="off" role="form">
                <div id="dep" class="modal-body">
                    <div class="form-group">
                        <label for="nombre">* Nombre</label>
                        <input type="text" id="suc_Sucursal" class="form-control" name="suc_Sucursal"  placeholder="Escriba el nombre" required>
                        <input id="suc_SucursalID" name="suc_SucursalID" hidden>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-light btn-round" data-dismiss="modal">Cancelar</button>
                        <button id="guardar" type="submit" class="btn btn-round btn-success guardar">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

