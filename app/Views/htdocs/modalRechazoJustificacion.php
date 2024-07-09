<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div class="modal-demo" id="rechazoModal" >
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><b class="fa fa-warning"></b> Rechazar</h4>
            <button class="close" type="button" onclick="Custombox.modal.close();" data-dismiss="modal" style="border-left-width: 2px;margin-bottom: 1rem;margin-right: -3rem ;margin-top: -2rem;">&times;</button>
        </div>
        <form action="" id="justificacionRechazo" name="justificacionRechazo" method="post" autocomplete="off" role="form" enctype="multipart/form-data">
            <div class="modal-body">
                ¿Está seguro que desea <strong><span id="rechazoTema"></span></strong>?, escriba la justificación.
                <br/>
                <br/>
                <textarea id="justificacion" name="justificacion" class="form-control" placeholder="Escriba la justificación"></textarea>
            </div>
            <div class="modal-footer">
                <button class="btn btn-light" onclick="Custombox.modal.close();">Cancelar</button>
                <button type="submit"  class="btn btn-primary waves-effect waves-light">Confirmar</button>

            </div>
        </form>
    </div>

</div>
