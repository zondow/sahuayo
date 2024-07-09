<?php defined("FCPATH") or die("No direct script access allowed."); ?>

<div class="mb-4 row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body m-2">
                <h4>HOJA DE LIBERACIÓN</h4>
                <form class="needs-validation" role="form" action="<?= base_url("Personal/formBajaEmpleado") ?>" method="post" enctype="multipart/form-data" autocomplete="off" novalidate>
                    <!--FECHA,EMPLEADO,MOTIVOS-->
                    <input type="text" id="txtEmpleadoID" name="txtEmpleadoID" class="form-control" required hidden value="<?= encryptDecrypt('encrypt', $empleado['emp_EmpleadoID']) ?>">
                    <div class="form-row">
                        <div class="form-group col-md-3 offset-md-9 align-self-end">
                            <label for="txtSolicitud">*Fecha solicitud</label>
                            <input id="txtSolicitud" name="txtSolicitud" type="text" class="form-control datepicker" data-position="bottom" placeholder="Fecha baja" value="<?= date("Y-m-d") ?>" readonly>
                            <div class="invalid-feedback" style="font-size: 90% !important;">
                                Ingresa la fecha de la baja
                            </div>
                        </div>
                    </div>
                    <div class="form-row mt-2">
                        <div class="form-group col-md-12">
                            <label for="txtMotivoBaja">*Motivo</label>
                            <textarea id="txtMotivoBaja" name="txtMotivoBaja" type="text" class="form-control" placeholder="Escribe los motivos de la baja" required></textarea>
                            <div class="invalid-feedback" style="font-size: 90% !important;">
                                Ingresa el motivo de la baja
                            </div>
                        </div>
                    </div>
                    <!--RESGUARDOS TI-->
                    <?php if (!empty($equipoI)) { ?>

                        <hr>
                        <h5 class="mt-4 mb-2">Equipo informático</h5>
                        <?php
                        $i = 1;
                        foreach ($equipoI as $item) {
                        ?>
                            <input name="equipoID[]" type="hidden" value="<?= $item['equi_EquipoID'] ?>">
                            <input id="txtTipo<?= $i ?>" name="txtTipo[]" type="hidden" value="<?= $item['equi_Tipo'] ?>">
                            <label class="mt-1 mb-1"><?= $item['equi_Tipo'] ?></label>
                            <div class="form-row mb-1">
                                <div class="form-group col-md-4">
                                    <label for="txtEquipoMarca<?= $i ?>">Marca</label>
                                    <input id="txtEquipoMarca<?= $i ?>" name="txtEquipoMarca[]" type="text" class="form-control" placeholder="Marca del equipo" value="<?= $item['equi_Marca'] ?>" readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="txtEquipoModelo<?= $i ?>">Modelo</label>
                                    <input id="txtEquipoModelo<?= $i ?>" name="txtEquipoModelo[]" type="text" class="form-control" placeholder="Modelo del equipo" value="<?= $item['equi_Modelo'] ?>" readonly>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="txtEquipoColor<?= $i ?>">Color</label>
                                    <input id="txtEquipoColor<?= $i ?>" name="txtEquipoColor[]" type="text" class="form-control" placeholder="Color del equipo" value="<?= $item['equi_Color'] ?>" readonly>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="txtEquipoObservaciones<?= $i ?>">Observaciones</label>
                                    <textarea id="txtEquipoObservaciones<?= $i ?>" name="txtEquipoObservaciones[]" type="text" class="form-control" placeholder="Observaciones"></textarea>
                                </div>
                            </div>
                    <?php
                            $i++;
                        }
                    }
                    ?>

                    <hr>
                    <h5 class="mt-3">Lista de contraseñas</h5>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="txtCorreo">Correo</label>
                            <input id="txtCorreo" name="txtCorreo" type="text" class="form-control" placeholder="Escribe tu correo">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="txtContrasenaCorreo">Contraseña</label>
                            <input id="txtContrasenaCorreo" name="txtContrasenaCorreo" type="text" class="form-control" placeholder="Escribe la contraseña de tu correo">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="txtTelefono">Teléfono</label>
                            <input id="txtTelefono" name="txtTelefono" type="text" class="form-control" placeholder="Escribe tu número de teléfono">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="txtContrasenaTelefono">Contraseña</label>
                            <input id="txtContrasenaTelefono" name="txtContrasenaTelefono" type="text" class="form-control" placeholder="Escribe la contraseña de tu teléfono">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="txtComputadora">Computadora</label>
                            <input id="txtComputadora" name="txtComputadora" type="text" class="form-control" placeholder="Escribe el usuario">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="txtContrasenaComputadora">Contraseña</label>
                            <input id="txtContrasenaComputadora" name="txtContrasenaComputadora" type="text" class="form-control" placeholder="Escribe la contraseña de tu computadora">
                        </div>
                    </div>
                    <!--SITIOS WEB-->
                    <hr>
                    <div id="divSitiosWeb">
                        <h5 style="vertical-align: middle !important;" for="">Sitios web&nbsp;&nbsp;
                            <i id="btnNuevoSitio" class="fe-plus-circle btnAddSitio" style="color: #00c100" data-toggle="tooltip" data-placement="top" title="Agregar sitio"></i>
                            <i id="btnEliminarSitio" class="fe-minus-circle btnRemoveSitio" style="color: red" data-toggle="tooltip" data-placement="top" title="Quitar sitio"></i>
                        </h5>
                        <div id="sitio_1" class="form-row">
                            <div class="form-group col-md-4">
                                <label for="txtUrlSitio1">URL</label>
                                <input id="txtUrlSitio1" name="txtUrlSitio1" type="text" class="form-control" placeholder="Escribe la url del sitio">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="txtUserSitio1">Usuario</label>
                                <input id="txtUserSitio1" name="txtUserSitio1" type="text" class="form-control" placeholder="Escribe el usuario">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="txtContrasenaSitio1">Contraseña</label>
                                <input id="txtContrasenaSitio1" name="txtContrasenaSitio1" type="text" class="form-control" placeholder="Escribe la contraseña del sitio">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="txtComentarios">Comentarios</label>
                            <textarea id="txtComentarios" name="txtComentarios" type="text" class="form-control" placeholder="Comentarios"></textarea>
                        </div>
                    </div>
                    <!--BUTTONS VOLVER Y GUARDAR-->
                    <div class="col-12 mt-3 text-center">
                        <button type="submit" id="" class="mb-2 btn btn-success">
                            <span class="label">&nbsp;Guardar</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>