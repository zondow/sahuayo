<div class="row">
    <div class="col-md-12">
        <div class="card-box">
            <div class="row">
                <?php
                if(revisarPermisos('Agregar',$this)) {?>
                <div class="mb-2 col-md-2 text-left" >
                    <a href="#" class="btn btn-success waves-effect waves-light modalInst" ><i class="mdi mdi-plus"></i> Agregar </a>

                </div>
                <?php } ?>
            </div>
            <div class="table-responsive">
                <table id="datatable" class="table mt-4 table-hover m-0 table-centered tickets-list table-actions-bar ">
                    <thead>
                        <tr>
                            <th>Acciones</th>
                            <th>Nombre</th>
                            <th>Criterio de selección</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Estatus</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($instructores as $instructor) {?>
                        <tr>
                            <td>
                                <?php
                                if(revisarPermisos('Editar',$this)) {
                                    echo '<a type = "button" class="btn btn-info waves-effect waves-light editarInstructor" data-id = "'.$instructor['ins_InstructorID'].'" style = "color:#FFFFFF" ><i class="fa fa-edit" ></i > </a >';
                                }
                                ?>
                            </td>
                            <td><?= $instructor['ins_Nombre']?></td>
                            <td><?= $instructor['ins_CriterioSeleccion']?></td>
                            <td><?= $instructor['emp_Telefono']?></td>
                            <td><?= $instructor['emp_Correo']?></td>
                            <?php
                            if(revisarPermisos('Baja',$this)) {
                                if ($instructor['ins_Estatus'] == 1) {
                                    $estatus = '<a class="btn btn-outline-success btn-rounded waves-light waves-effect pt-0 pb-0 btnActivo" title="Click para cambiar estatus" href="' . base_url("Formacion/estatusInstructor/0/" . encryptDecrypt('encrypt',$instructor['ins_InstructorID']) ) . '">Activo</a>';
                                } else {
                                    $estatus = '<a class="btn btn-outline-danger btn-rounded waves-light waves-effect pt-0 pb-0"  title="Click para cambiar estatus" href="' . base_url("Formacion/estatusInstructor/1/" . encryptDecrypt('encrypt',$instructor['ins_InstructorID']) ) . '">Inactivo</a>';
                                }
                            }else{
                                if ($instructor['ins_Estatus'] == 1) {
                                    $estatus = '<a class="btn btn-outline-success btn-rounded waves-light waves-effect pt-0 pb-0 btnActivo" title="Click para cambiar estatus" href="#" >Activo</a>';
                                } else {
                                    $estatus = '<a class="btn btn-outline-danger btn-rounded waves-light waves-effect pt-0 pb-0"  title="Click para cambiar estatus" href="#" >Inactivo</a>';
                                }
                            }?>
                            <td><?=$estatus?></td>
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
<div class="modal fade in" id="modalInstructor" style="background-color:rgba(10, 10, 10, 0.5);">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><b class="iconsminds-next"></b>Instructor</h4>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <form action="<?=base_url('Formacion/addInstructor')?>" id="formInstructor" name="formInstructor" method="post" autocomplete="off" role="form" enctype="multipart/form-data">
                <div class="modal-body">

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>
                                * Nombre:
                            </label>
                            <input name="ins_InstructorID" id="ins_InstructorID" hidden>
                            <select name="ins_EmpleadoID" id="ins_EmpleadoID" class="form-control select2" required style="width: 100% !important;">
                                <option value="" hidden>Seleccione</option>
                                <?php foreach ($empleados as $empleado){?>
                                    <option value="<?=$empleado['emp_EmpleadoID']?>"><?=$empleado['emp_Nombre']?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>
                                * Criterio de selección:
                            </label>
                            <br>
                            <select name="ins_CriterioSeleccion" id="ins_CriterioSeleccion" class="form-control select2" required style="width: 100% !important;">
                                <option value="" hidden>Seleccione</option>
                                <option value="Experto en el tema">Experto en el tema</option>
                                <option value="Experiencia">Experiencia</option>
                                <option value="Vocación">Vocación</option>
                            </select> 
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    <button type="submit" id="updatePT" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>


