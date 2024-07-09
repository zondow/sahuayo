<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-12">
        <div class="card-box">
            <div class="row">
                <div class="col-md-12 mb-2">
                    <div class="col-md-8 text-left">
                        <a href="#" class="btn btn-success waves-light waves-effect addUsuario"><i class="dripicons-plus" ></i>Agregar</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div>
                        <table id="tblUsuarios" class="table table-hover  m-0 table-centered tickets-list table-actions-bar dt-responsive " cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th width="5%">Acciones</th>
                                <th>Nombre</th>
                                <th>Departamento</th>
                                <th>Puesto</th>
                                <th>Estado</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--------------- Modal  ----------------->
<div class="modal fade" id="modalUsuario" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="tituloModal">Agregar usuario</h4>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <form id="formUsuario" method="post" autocomplete="off" role="form">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="emp_EmpleadoID"> * Colaborador </label>
                            <select id="emp_EmpleadoID" name="emp_EmpleadoID" class="select2 form-control" data-placeholder="Seleccione " style="width: 100%" required>
                                <?php
                                    foreach ($colaboradores as $colaborador){
                                        echo '<option value="'.$colaborador['emp_EmpleadoID'].'">'.trim($colaborador['emp_Nombre']).'</option>';
                                    }//foreach
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer ">
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-light" data-dismiss="modal"><span class="iconsminds-close"></span> Cancelar</button>
                        <button type="button" class="btn btn-success" id="btnGuardar"><span class="iconsminds-yes"></span> Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>