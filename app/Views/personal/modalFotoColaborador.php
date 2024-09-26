<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<link href="<?=base_url("assets/plugins/fileinput/css/fileinput.css")?>" media="all" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">
<link href="<?=base_url("assets/plugins/fileinput/themes/explorer-fas/theme.css")?>" media="all" rel="stylesheet" type="text/css"/>
<script src="<?=base_url("assets/plugins/fileinput/js/fileinput.js")?>" type="text/javascript"></script>
<script src="<?=base_url("assets/plugins/fileinput/js/locales/es.js")?>" type="text/javascript"></script>
<script src="<?=base_url("assets/plugins/fileinput/themes/fas/theme.js")?>" type="text/javascript"></script>
<script src="<?=base_url("assets/plugins/fileinput/themes/explorer-fas/theme.js")?>" type="text/javascript"></script>


<div class="modal fade" id="modalFotoColaborador" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title">Foto del colaborador</h4>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <div class="col-md-12 pt-3">
                <form id="frmFotoColaborador" class="form" role="form" action="#" method="post" enctype="multipart/form-data" autocomplete="off">
                    <input id="FEID" name="FEID" hidden >
                    <div class="form-group ">
                        <div class="file-loading">
                            <input id="fileFotoEmpleado" name="fileFotoEmpleado" type="file" class="file"   >
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="col-md-12 text-right">
                    <button type="button" class="btn btn-dark btn-round" data-dismiss="modal">Cancelar</button>
                    <button  type="button" id="bntGuardarFoto"  class="btn btn-success btn-round" >Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $('#fileFotoEmpleado').fileinput({
        theme: 'fas',
        language: 'es',
        uploadUrl: '#',
        allowedFileExtensions: ['png','jpg','JPG'],
        dropZoneEnabled: false,
        showUpload:false,
    });

</script>