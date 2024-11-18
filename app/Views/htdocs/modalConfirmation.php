<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel"><b class="fa fa-warning"></b> Confirmación</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    &times;
                </button>
            </div>
            <div class="modal-body">
                ¿Está seguro que desea <strong><span id="confirmTema"></span></strong>?
                <br/><br/><br/><br/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light btn-round" data-bs-dismiss="modal">Cancelar</button>
                <a href="#" id="confirmLink" class="btn btn-success btn-round">Confirmar</a>
            </div>
        </div>
    </div>
</div>

<!-- <div class="modal-demo" id="confirmModal" >
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title"><b class="fa fa-warning"></b> Confirmación</h4>
            <button class="close" type="button" onclick="Custombox.modal.close();" data-dismiss="modal" style="border-left-width: 2px;margin-bottom: 1rem;margin-right: -3rem ;margin-top: -2rem;">&times;</button>
        </div>
        <div class="modal-body">
            ¿Está seguro que desea <strong><span id="confirmTema"></span></strong>?
            <br/>
            <br/>
            <br/>
            <br/>
        </div>
        <div class="modal-footer">
            <button class="btn btn-light" onclick="Custombox.modal.close();">Cancelar</button>
            <a href="#" id="confirmLink" class="btn btn-primary">Confirmar</a>
        </div>
    </div>
</div>-->
