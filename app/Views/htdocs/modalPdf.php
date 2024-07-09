<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<!-- MODAL -->
<div  id="modalPdf" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="width: 95%; max-width:990px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="" class="modal-title"><b class="iconsminds-printer"></b> <span id="modalTitlePdf"></span> </h5>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <iframe id="iframePdf" frameborder="no" width="100%" style="min-height: 600px;">

                </iframe>
            </div>
        </div>
    </div>
</div>