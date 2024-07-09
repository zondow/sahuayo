<div class="content">
    <!-- Start Content-->
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <div class="col-md-12 text-left" style="padding-bottom: 2%">
                        <?php if(revisarPermisos('Agregar',$this)){ ?>
                        <a type="button" style="color: #FFFFFF" class=" btnAddSucursal btn btn-success waves-effect waves-light"><i class="dripicons-plus"></i> Agregar</a>
                        <?php } ?>
                    </div>
                    <table class="table table-hover m-0 table-centered tickets-list table-actions-bar  dt-responsive nowrap" cellspacing="0" width="100%" id="datatable">
                        <thead>
                        <tr>
                            <th>Acciones</th>
                            <th>Sucursal</th>
                            <th>Estatus</th>
                        </tr>
                        </thead>

                        <tbody>
                        <?php
                        if(isset($sucursales)){
                            foreach($sucursales as $sucursal){
                                $html = '<tr>';
                                if(revisarPermisos('Editar',$this)) {
                                    $html .= '<td><a type="button" class="btn btn-info waves-effect waves-light editarSucursal" data-id="' .encryptDecrypt('encrypt',$sucursal['suc_SucursalID']) . '" style="color:#FFFFFF"><i class="fa fa-edit"></i></a></td>';
                                }
                                $html .= '<td>'.$sucursal['suc_Sucursal'].'</td>';

                                if(revisarPermisos('Baja',$this)) {
                                    if ($sucursal['suc_Estatus'] == 1) {
                                        $estatus = '<a class="btn btn-outline-success btn-rounded waves-light waves-effect pt-0 pb-0 btnActivo" title="Click para cambiar estatus" href="' . base_url("Catalogos/estatusSucursal/0/" . encryptDecrypt('encrypt',$sucursal['suc_SucursalID']) ) . '" >Activo</a>';
                                    } else {
                                        $estatus = '<a class="btn btn-outline-danger btn-rounded waves-light waves-effect pt-0 pb-0 "  title="Click para cambiar estatus" href="' . base_url("Catalogos/estatusSucursal/1/" . encryptDecrypt('encrypt',$sucursal['suc_SucursalID'])) . '" >Inactivo</a>';
                                    }
                                }else{
                                    if ($sucursal['suc_Estatus'] == 1) {
                                        $estatus = '<a class="btn btn-outline-success btn-rounded waves-light waves-effect pt-0 pb-0 btnActivo" >Activo</a>';
                                    } else {
                                        $estatus = '<a class="btn btn-outline-danger btn-rounded waves-light waves-effect pt-0 pb-0 ">Inactivo</a>';
                                    }
                                }
                                $html .= '<td>'.$estatus.'</td>';
                                $html .= '</tr>';
                                echo $html;
                            }//foreach
                        }//if
                        ?>

                        </tbody>
                    </table>
                </div>
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
                <h4 class="modal-title" id="myModalLabel">Sucursal</h4>
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
                    <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Cancelar</button>
                    <button id="guardar" type="submit" class="btn btn-primary waves-effect waves-light guardar">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>