<?php defined('FCPATH') or exit('No direct script access allowed'); ?>

<div class="row mb-3">
    <?php
    if (revisarPermisos('Agregar', 'cursos')) { ?>
        <div class="col-md-12 text-right">
            <a href="#" class="btn btn-success btn-round modalCursos"><i class="zmdi zmdi-plus"></i> Agregar </a>
        </div>
    <?php } ?>
</div>
<div class="row clearfix" >
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="body">
                <table id="datatable" class="table table-hover m-0 table-centered table-actions-bar dt-responsive " cellspacing="0" width="100%" >
                    <thead>
                        <tr>
                            
                            <th>Nombre</th>
                            <th>Objetivo</th>
                            <th>Modalidad</th>
                            <th>Horas</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cursos as $curso) { 
                        $style = '';
                        $estatus = '';    

                        if (revisarPermisos('Baja', 'cursos')) {
                            if ($curso['cur_Estatus'] == 1) {
                                $estatus = '<a class="btn btn-icon btn-icon-mini btn-round btn-primary btnActivo" title="Click para cambiar estatus a inactivo" href="' . base_url("Catalogos/estatusCurso/0/" . encryptDecrypt('encrypt',$curso['cur_CursoID'])) . '" ><i class="zmdi zmdi-check-circle pt-2"></i></a>';
                            } else {
                                $estatus = '<a class="btn btn-icon btn-icon-mini btn-round btn-primary "  title="Click para cambiar estatus a activo" href="' . base_url("Catalogos/estatusCurso/1/" . encryptDecrypt('encrypt',$curso['cur_CursoID'])) . '"><i class="zmdi zmdi-check-circle pt-2"></i></a>';
                                $style = 'style="background-color: #e6e6e6"';
                            }
                        }
                        ?>
                            <tr <?=$style?>>
                                <td><?= $curso['cur_Nombre'] ?></td>
                                <td><?= $curso['cur_Objetivo'] ?></td>
                                <td><?= $curso['cur_Modalidad'] ?></td>
                                <td><?= $curso['cur_Horas'] ?></td>
                                <td>
                                    <?php
                                        if (revisarPermisos('Editar', 'cursos')) {
                                            echo '<a type = "button" class="btn btn-icon  btn-icon-mini btn-round btn-info editarCurso " data-id = "' . encryptDecrypt('encrypt',$curso['cur_CursoID']) . '" style = "color:#FFFFFF" ><i class="zmdi zmdi-edit pt-2" ></i > </a >';
                                        }
                                        echo $estatus ;
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
<div class="modal fade in" id="modalCurso" style="background-color:rgba(10, 10, 10, 0.5);">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="title"> </h4>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <form action="<?= base_url('Catalogos/addCurso') ?>" id="formCursos" name="formCursos" method="post" autocomplete="off" role="form" enctype="multipart/form-data">
                <div class="modal-body">

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>
                                * Nombre:
                            </label>
                            <input name="cur_CursoID" id="cur_CursoID" hidden>
                            <input name="cur_Nombre" id="cur_Nombre" placeholder="Escriba el nombre" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>
                                * Objetivo:
                            </label>
                            <textarea name="cur_Objetivo" id="cur_Objetivo" placeholder="Escriba el objetivo" class="form-control" required></textarea>
                        </div>

                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>
                                * Modalidad:
                            </label>
                            <br>
                            <select name="cur_Modalidad" id="cur_Modalidad" class="chosen-select" required style="width: 100% !important;">
                                <option value="" hidden>Seleccione</option>
                                <option value="Presencial">Presencial</option>
                                <option value="En linea">En linea</option>
                                <option value="Mixto">Mixto</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>
                                * Cantidad de horas:
                            </label>
                            <input type="number" min="1" name="cur_Horas" id="cur_Horas" placeholder="Escriba la cantidad de horas" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>* Temario:</label>
                            <textarea class="form-control" id="cur_Temario" name="cur_Temario" placeholder="Temario" required></textarea>
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