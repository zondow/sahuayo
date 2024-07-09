<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<link href="<?= base_url("assets/plugins/fileinput/css/fileinput.css") ?>" media="all" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">
<link href="<?= base_url("assets/plugins/fileinput/themes/explorer-fas/theme.css") ?>" media="all" rel="stylesheet" type="text/css" />
<script src="<?= base_url("assets/plugins/fileinput/js/fileinput.js") ?>" type="text/javascript"></script>
<script src="<?= base_url("assets/plugins/fileinput/js/locales/es.js") ?>" type="text/javascript"></script>
<script src="<?= base_url("assets/plugins/fileinput/themes/fas/theme.js") ?>" type="text/javascript"></script>
<script src="<?= base_url("assets/plugins/fileinput/themes/explorer-fas/theme.js") ?>" type="text/javascript"></script>
<div class="row">
    <div class="col-md-12">
        <div class="card-box">
            <form id="formMaterial" method="post" enctype="multipart/form-data">
                <input name="id" id="idCapsula" value="<?= $capsulaID ?>" hidden>
                <div class="form-group col-md-12">
                    <label for="numero">* Numero de orden </label>
                    <input type="text" id="numero" class="form-control" name="numero" placeholder="Escriba el numero de orden" required>
                </div>
                <div class="form-group col-md-12">
                    <label for="titulo">* Titulo</label>
                    <input type="text" id="titulo" class="form-control" name="titulo" placeholder="Escriba el titulo del contenido" required>
                </div>
                <div class="col-md-12">
                    <div class="form-group ">
                        <label for="titulo">* Material didactico</label>
                        <div class="file-loading">
                            <input id="fileMaterial" name="fileMaterial" type="file" class="file">
                        </div>
                    </div>
                </div>
            </form>
            <div class="col-md-12 ">
                <a href="#" id="btnSubirMaterial" class="btn btn-success">Guardar</a>
            </div>
        </div>
    </div><!-- end col -->
</div>


<div class="row">
    <?php
    if (!empty($videos)) {
        foreach ($videos as $video) {
            $url = base_url("/assets/uploads/capsulas/" . $video['con_CapsulaID'] . "/" . $video['con_Archivo']);
            echo '<div class="col-md-4 ">
                    <div class="file-man-box card-box rounded  " >
                        <a href="" data-id="' . $video['con_ContenidoCapsulaID'] . '"  data-archivo="' . $video['con_Archivo'] . '" class="file-close borrarContenido"><i class="mdi mdi-close-circle"></i></a>
                        <div class="file-img-box">
                            <video width="100%" controls="controls" preload="metadata">
                                <source src="' . $url . '" >
                            </video>
                        </div>
                        <div class="file-man-title">
                            <h5 class="mb-0 text-overflow"># ' . $video['con_NumOrden'] . '</h5>
                            <p class="mb-0">' . $video['con_Titulo'] . '</p>
                        </div>
                        <div class="text-right">
                            <button type="button" class="btn btn-outline-info btn-rounded btn-sm waves-light waves-effect verVistas" data-id="' . $video['con_ContenidoCapsulaID'] . '"><i class="mdi mdi-account-group "></i></button>
                        </div>
                    </div>
                </div>';
        }
    } else {
        echo '<div class="col-lg-12 col-xl-12"><div class="alert alert-warning text-center" role="alert"><b>No hay contenido para esta cápsula educativa.</b></div></div>';
    }
    ?>
</div>
<!--------------- Modal  ----------------->
<div id="modalVerVistas" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Seguimiento del contenido </h4>
            </div>
            <div class="modal-body">
                <div class="row" id="divVistas">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<script>
    $('#fileMaterial').fileinput({
        theme: 'fas',
        language: 'es',
        uploadUrl: '#',
        allowedFileExtensions: ['pptx', 'pdf', 'png', 'jpg', 'jpeg', 'mp4'],
        dropZoneEnabled: false,
        showUpload: false,
    });
</script>