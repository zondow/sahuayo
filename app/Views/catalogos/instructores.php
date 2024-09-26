
<div class="row  mb-3 text-right">
    <?php
    if(revisarPermisos('Agregar','instructores')) {?>
    <div class=" col-md-12 " >
        <a href="#" class="btn btn-success btn-round modalInst" ><i class="zmdi zmdi-plus"></i> Agregar </a>

    </div>
    <?php } ?>
</div>
<div class="row clearfix" >
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="body" >
                <table id="datatable" class="table table-hover m-0 table-centered table-actions-bar dt-responsive" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            
                            <th>Nombre</th>
                            <th>Criterio de selección</th>
                            <th>Teléfono</th>
                            <th>Correo</th>
                            <th>Acciones</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($instructores as $instructor) {
                        $style = '';
                        $estatus = '';
                        if(revisarPermisos('Baja','instructores')) {
                            if ($instructor['ins_Estatus'] == 1) {
                                $estatus = '<a class="btn btn-icon btn-icon-mini btn-round btn-primary btnActivo" title="Click para cambiar estatus a inactivo" href="' . base_url("Catalogos/estatusInstructor/0/" . encryptDecrypt('encrypt',$instructor['ins_InstructorID']) ) . '"><i class="zmdi zmdi-check-circle pt-2"></i></a>';
                            } else {
                                $estatus = '<a class="btn btn-icon btn-icon-mini btn-round btn-primary"  title="Click para cambiar estatus a activo" href="' . base_url("Catalogos/estatusInstructor/1/" . encryptDecrypt('encrypt',$instructor['ins_InstructorID']) ) . '"><i class="zmdi zmdi-check-circle pt-2"></i></a>';
                                $style = 'style="background-color: #e6e6e6"';
                            }
                        }
                                        
                    ?>
                        <tr <?=$style?>>
                           
                            <td><?= $instructor['ins_Nombre']?></td>
                            <td><?= $instructor['ins_CriterioSeleccion']?></td>
                            <td><?= $instructor['emp_Telefono']?></td>
                            <td><?= $instructor['emp_Correo']?></td>
                            <?php
                            ?>
                            <td>
                                <?php
                                    if(revisarPermisos('Editar','instructores')) {
                                        echo '<a type = "button" class="btn btn-icon btn-icon-mini btn-round btn-info editarInstructor" data-id = "'.$instructor['ins_InstructorID'].'" style = "color:#FFFFFF" ><i class="zmdi zmdi-edit pt-2" ></i > </a >';
                                    }
                                    echo $estatus
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
<!--Modales-->
<div class="modal fade in" id="modalInstructor" style="background-color:rgba(10, 10, 10, 0.5);">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><b class="iconsminds-next"></b>Instructor</h4>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <form action="<?=base_url('Catalogos/addInstructor')?>" id="formInstructor" name="formInstructor" method="post" autocomplete="off" role="form" enctype="multipart/form-data">
                <div class="modal-body">

                    <div class="form-row">
                        <div class="form-group col-md-12">
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
                        <div class="form-group col-md-12">
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
                    <div class="col-md-12 text-right">
                        <button class="btn btn-dark btn-round" data-dismiss="modal">Cancelar</button>
                        <button type="submit" id="updatePT" class="btn btn-success btn-round">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function (e) {
    $('.select2').select2({
        dropdownParent: $('#modalInstructor .modal-body'),
        placeholder: 'Seleccione una opción',
        allowClear: true,
        width: 'resolve'
    });
});
</script>
