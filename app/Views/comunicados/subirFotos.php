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
                                <th>Fecha</th>
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
                <h4 class="modal-title" id="titleModal">Agregar nueva galería</h4>
            </div>
            <form id="form" action="<?= base_url('Comunicados/addFotos') ?>" method="post" autocomplete="off" role="form" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="gal_Nombre">* Nombre </label>
                            <input type="text" id="gal_Nombre" class="form-control " name="gal_Nombre" required placeholder="Escriba el nombre de la galería (recuerda no repetir nombres)">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="gal_Estatus">* ¿Habilitar para empleados? </label>
                            <select type="text" id="gal_Estatus" class="select2" required name="gal_Estatus">
                                <option value="0">No</option>
                                <option value="1">Si</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="fileFotos" class="col-form-label">* Fotos</label>
                            <div class="file-loading">
                                <input id="fileFotos" required name="fileFotos[]" type="file" class="file" multiple="multiple">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-right col-md-12">
                        <button type="button" class="btn btn-light btn-round" data-dismiss="modal">Cancelar</button>
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
                <h4 class="modal-title" id="titleModal">Agregar nueva galería</h4>
            </div>
            <form id="formEdit" action="<?= base_url('Comunicados/editGaleria') ?>" method="post" autocomplete="off" role="form" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="gal_Nombre">* Nombre </label>
                            <input type="text" id="gal_NombreE" class="form-control " name="gal_NombreE" required placeholder="Escriba el nombre de la galería (recuerda no repetir nombres)">
                            <input type="text" hidden id="gal_Galeria" name="gal_Galeria">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-right col-md-12">
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
    $('#fileFotos').fileinput({
        theme: 'fas',
        language: 'es',
        uploadUrl: '#',
        allowedFileExtensions: ['jpg', 'jpeg', 'png'],
        dropZoneEnabled: false,
        showUpload: false,
    });
</script>