<?php defined('FCPATH') or exit('No direct script access allowed'); ?>



<div class="row mb-4">
    <?php
    if(revisarPermisos('Agregar',$this)) {?>
    <div class="col-md-12 text-right" >
        <a href="#" class="btn btn-success btn-round modalProveedores" ><i class="zmdi zmdi-plus"></i> Agregar </a>

    </div>
    <?php } ?>
</div>
<div class="row clearfix" >
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="body">
                <div class="table-responsive">
                    <table id="datatableProveedores" class="table table-hover m-0 table-centered table-actions-bar dt-responsive" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                
                                <th>Proveedor</th>
                                <th>Correo</th>
                                <th>Teléfono</th>
                                <th>Institucion</th>
                            
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($proveedores as $proveedor){ 
                            $style = '';
                            $estatus = '';
                            
                            if(revisarPermisos('Baja',$this)) {
                                if ($proveedor['pro_Estatus'] == 1) {
                                    $estatus = '<a class="btn btn-icon btn-icon-mini btn-round btn-primary btnActivo" title="Click para cambiar estatus a inactivo" href="' . base_url("Catalogos/estatusProveedor/0/" . encryptDecrypt('encrypt',$proveedor['pro_ProveedorID'])) . '" ><i class="zmdi zmdi-check-circle pt-2"></i></a>';
                                } else {
                                    $estatus = '<a class="btn btn-icon btn-icon-mini btn-round btn-primary "  title="Click para cambiar estatus a activo" href="' . base_url("Catalogos/estatusProveedor/1/" . encryptDecrypt('encrypt',$proveedor['pro_ProveedorID'])) . '" ><i class="zmdi zmdi-check-circle pt-2"></i></a>';
                                    $style = 'style="background-color: #e6e6e6"';
                                }
                            }

                            ?>
                            <tr <?=$style?>>
                                <td><?=$proveedor['pro_Nombre']?></td>
                                <td><?=$proveedor['pro_Correo']?></td>
                                <td><?=$proveedor['pro_Telefono']?></td>
                                <td><?=$proveedor['pro_Institucion']?></td>
                                <td>
                                    <?php
                                    if(revisarPermisos('Editar',$this)) {
                                        echo '<a type = "button" class="btn btn-icon btn-icon-mini btn-round btn-info  editarProveedor" data-id = "'.$proveedor['pro_ProveedorID'].'" style = "color:#FFFFFF" ><i class="zmdi zmdi-edit pt-2" ></i > </a >';
                                        echo $estatus;
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Modales-->
<div class="modal fade in" id="modalProv" style="background-color:rgba(10, 10, 10, 0.5);">
    <div class="modal-dialog ">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><b class="iconsminds-next"></b> Proveedor</h4>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <form action="<?=base_url('Catalogos/addProveedor')?>" id="formProveedores" name="formProveedores"  method="post" autocomplete="off">
                <div class="modal-body">

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>
                                * Nombre:
                            </label>
                            <input name="pro_Nombre" id="pro_Nombre" placeholder="Escriba el nombre" class="form-control" required>
                            <input name="pro_ProveedorID" id="pro_ProveedorID" hidden>
                        </div>
                        <div class="form-group col-md-12">
                            <label>
                                * Empresa:
                            </label>
                            <input name="pro_Institucion" id="pro_Institucion" placeholder="Escriba la Institución"  class="form-control" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>
                                * Correo:
                            </label>
                            <input name="pro_Correo" id="pro_Correo" placeholder="Escriba el correo"  class="form-control" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label>
                                * Teléfono:
                            </label>
                            <input name="pro_Telefono" id="pro_Telefono" placeholder="Escriba el teléfono" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-md-12 text-right">
                        <button class="btn btn-dark btn-round" data-dismiss="modal">Cancelar</button>
                        <button type="submit" id="updatePT" class="btn btn-success btn-round">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
