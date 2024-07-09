<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card-box">
            <div class="row">
                <?php
                if (revisarPermisos('Agregar', $this)) { ?>
                    <div class="mb-2 col-md-2 text-left">
                        <a href="#" class="btn btn-success waves-effect waves-light modalCursos"><i class="mdi mdi-plus"></i> Agregar </a>
                    </div>
                <?php } ?>
            </div>
            <div class="table-responsive">
                <table id="datatable" class="table mt-4 table-hover m-0 table-centered tickets-list table-actions-bar ">
                    <thead>
                        <tr>
                            <th>Acciones</th>
                            <th>Nombre</th>
                            <th>Objetivo</th>
                            <th>Modalidad</th>
                            <th>Horas</th>
                            <th>Estatus</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cursos as $curso) { ?>
                            <tr>
                                <td>
                                    <?php
                                    if (revisarPermisos('Editar', $this)) {
                                        echo '<a type = "button" class="btn btn-info waves-effect waves-light editarCurso mb-1" data-id = "' . encryptDecrypt('encrypt',$curso['cur_CursoID']) . '" style = "color:#FFFFFF" ><i class="fa fa-edit" ></i > </a >';
                                    }
                                    $url = cursoImagen($curso['cur_CursoID']);
                                    if (!empty($url)) {
                                        if (substr($url[0]['url'], -3) == "pdf") {
                                            $archivo = '<a href="' . $url[0]['url'] . '" class="btn btn-dark waves-light waves-effect show-pdf" data-title="Ver Imagen" style="color: white" ><i class="fas fa-eye "></i></a>';
                                        } else if (substr($url[0]['url'], -3) == "jpg" || substr($url[0]['url'], -4) == "jpeg" || substr($url[0]['url'], -3) == "png") {
                                            $archivo = '<div style="padding-left: 2%"><a href="' . $url[0]['url'] . '"  data-lightbox="roadtrip" data-title="Ver Imagen" class="btn btn-dark aves-light  waves-effect " style="color: white" ><i class="fas fa-eye "></i></a>';
                                        } else $archivo = '';
                                        echo $archivo;
                                    }
                                    ?>

                                </td>
                                <td><?= $curso['cur_Nombre'] ?></td>
                                <td><?= $curso['cur_Objetivo'] ?></td>
                                <td><?= $curso['cur_Modalidad'] ?></td>
                                <td><?= $curso['cur_Horas'] ?></td>
                                <?php
                                if (revisarPermisos('Baja', $this)) {
                                    if ($curso['cur_Estatus'] == 1) {
                                        $estatus = '<a class="btn btn-outline-success btn-rounded waves-light waves-effect pt-0 pb-0 btnActivo" title="Click para cambiar estatus" href="' . base_url("Formacion/estatusCurso/0/" . encryptDecrypt('encrypt',$curso['cur_CursoID'])) . '" >Activo</a>';
                                    } else {
                                        $estatus = '<a class="btn btn-outline-danger btn-rounded waves-light waves-effect pt-0 pb-0"  title="Click para cambiar estatus" href="' . base_url("Formacion/estatusCurso/1/" . encryptDecrypt('encrypt',$curso['cur_CursoID'])) . '">Inactivo</a>';
                                    }
                                } else {
                                    if ($curso['cur_CursoID'] == 1) {
                                        $estatus = '<a class="btn btn-outline-success btn-rounded waves-light waves-effect pt-0 pb-0 btnActivo" href="#" >Activo</a>';
                                    } else {
                                        $estatus = '<a class="btn btn-outline-danger btn-rounded waves-light waves-effect pt-0 pb-0"  href="#" >Inactivo</a>';
                                    }
                                }
                                ?>
                                <td><?= $estatus ?></td>
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
                <h4 class="modal-title"><b class="iconsminds-next"></b> Curso</h4>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <form action="<?= base_url('Formacion/addCurso') ?>" id="formCursos" name="formCursos" method="post" autocomplete="off" role="form" enctype="multipart/form-data">
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
                            <select name="cur_Modalidad" id="cur_Modalidad" class="form-control select2" required style="width: 100% !important;">
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
                    <button class="btn btn-light" data-dismiss="modal">Cancelar</button>
                    <button type="submit" id="updatePT" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>