<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="rechazoModal" tabindex="-1" aria-labelledby="rechazoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rechazoModalLabel"><b class="fa fa-warning"></b> Rechazar</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    &times;
                </button>
            </div>
            <form action="" id="justificacionRechazo" name="justificacionRechazo" method="post" autocomplete="off" role="form" enctype="multipart/form-data">
                <div class="modal-body">
                    ¿Está seguro que desea <strong><span id="rechazoTema"></span></strong>?, escriba la justificación.
                    <br />
                    <br />
                    <textarea id="justificacion" name="justificacion" class="form-control" placeholder="Escriba la justificación"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light btn-round" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success btn-round">Confirmar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- old version -->
<!--<div class="modal-demo" id="rechazoModal" style="display: none;">
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
</div>-->