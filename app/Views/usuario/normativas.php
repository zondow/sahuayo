<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-box">
            <table id="datatableNormativas" class="table table-hover m-0 table-centered nowrap" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Documento</th>
                        <th width="5%">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div> <!-- end Col -->

<!--------------- Modal cambios politica ----------------->
<div id="modalCambios" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h5 class="modal-title" id="myModalLabel">Historial de cambios</h5>
            </div>
            <div class="modal-body">
                <div class="row" id="divCambios">

                </div>
            </div>

            <div class="modal-footer text-right">
                <button type="button" class="btn btn-round" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL -->
<div id="modalPdf" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 95%; max-width:990px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="" class="modal-title"><b class="iconsminds-printer"></b> <span id="modalTitlePdf"></span> </h5>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body" style="position:relative">
                <div style="width:97%;height:45px;position:absolute"></div>
                <iframe id="iframePdf" frameborder="no" width="100%" style="min-height: 600px;">
                </iframe>
            </div>
        </div>
    </div>
</div>