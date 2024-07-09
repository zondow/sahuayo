<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div id="modalDatosAcceso" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Datos de acceso</h4>
            </div>
            <div class="modal-body">
                <form id="formDatosAcceso" method="post" autocomplete="off">
                    <input hidden id="idColabA" name="idColabA">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label class="col-form-label">* Correo</label>
                            <input type="text" class="form-control" id="emp_Correo" name="emp_Correo" required placeholder="Escriba el correo electronico">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-form-label"> Usuario</label>
                            <input type="text" class="form-control" id="username" readonly>
                        </div>
                        <div class="form-group col-md-6" id="passworde" name="passworde">
                            <label class="col-form-label">* Contraseña</label>
                            <input type="password" class="form-control" id="emp_Passworde" name="emp_Passworde" required placeholder="Escriba la contraseña">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button  id="btnGuardarEnviarAcceso" type="button"  class="btn btn-success ">Guardar y enviar</button>
                        <div id="spiner" >
                            <p>Enviando correo.</p>
                            <div class="sk-three-bounce">
                                <div class="sk-child sk-bounce1"></div>
                                <div class="sk-child sk-bounce2"></div>
                                <div class="sk-child sk-bounce3"></div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>