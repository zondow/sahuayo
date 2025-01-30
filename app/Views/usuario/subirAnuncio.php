<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<link href="<?= base_url("assets/plugins/fileinput/css/fileinput.css") ?>" media="all" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">
<link href="<?= base_url("assets/plugins/fileinput/themes/explorer-fas/theme.css") ?>" media="all" rel="stylesheet" type="text/css" />
<script src="<?= base_url("assets/plugins/fileinput/js/fileinput.js") ?>" type="text/javascript"></script>
<script src="<?= base_url("assets/plugins/fileinput/js/locales/es.js") ?>" type="text/javascript"></script>
<script src="<?= base_url("assets/plugins/fileinput/themes/fas/theme.js") ?>" type="text/javascript"></script>
<script src="<?= base_url("assets/plugins/fileinput/themes/explorer-fas/theme.js") ?>" type="text/javascript"></script>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="col-md-12 mb-2 text-right">
                    <a href="#" class="btn btn-success btn-round btnModalGaleria">
                        <i class="zmdi zmdi-plus"></i> Agregar
                    </a>
                </div>
                <div class="table-responsive">
                    <table id="tblGestion" class=" table table-hover " cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Fecha de registro</th>
                                <th>Estatus</th>
                                <th width="5%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!--------------- Modal  ----------------->
<div id="modalGaleria" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="titleModal">Agregar nuevo anuncio</h4>
            </div>
            <form id="form" action="<?= base_url('Comunicados/addAnuncio') ?>" method="post" autocomplete="off" role="form" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="anu_Titulo">* Nombre </label>
                            <input type="text" id="anu_Titulo" class="form-control " name="anu_Titulo" required placeholder="Escriba el nombre del anuncio (recuerda no repetir nombres)">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="anu_Estatus">* ¿Habilitar para empleados? </label>
                            <select type="text" id="anu_Estatus" class="select2" required name="anu_Estatus">
                                <option value="No">No</option>
                                <option value="Si">Si</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="files" class="col-form-label">* Foto o Video</label>
                            <div class="file-loading">
                                <input id="files" required name="files" type="file" class="file">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-light  btn-round" data-dismiss="modal">Cancelar</button>
                        <button id="guardar" type="submit" class="btn btn-success btn-round">Guardar</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
<!--------------- Modal  ----------------->
<div id="modalEditGaleria" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="titleModal">Editar anuncio</h4>
            </div>
            <form id="formEdit" action="<?= base_url('Usuario/editAnuncio') ?>" method="post" autocomplete="off" role="form" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="anu_Titulo">* Nombre </label>
                            <input type="text" id="anu_Titulo" class="form-control " name="anu_Titulo" required placeholder="Escriba el nombre del anuncio (recuerda no repetir nombres)">
                            <input type="text" hidden id="anu_AnuncioID" name="anu_AnuncioID">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Cancelar</button>
                        <button id="guardar" type="submit" class="btn btn-primary waves-effect waves-light">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            dropdownParent: $('#modalGaleria .modal-body'), // Usamos el modal como parent directo
            placeholder: 'Seleccione una opción',
            allowClear: true,
            width: 'resolve'
        });
    });

    $('#files').fileinput({
        theme: 'fas',
        language: 'es',
        uploadUrl: '#',
        allowedFileExtensions: ['jpg', 'jpeg', 'png', 'mp4', 'mkv', 'avi', 'mov'],
        dropZoneEnabled: false,
        showUpload: false,
    });
</script>