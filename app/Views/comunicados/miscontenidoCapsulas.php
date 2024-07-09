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
            <h4><?=$infoCapsula['cap_Titulo']?></h5>
            <p><?=$infoCapsula['cap_Descripcion']?></p>
        </div>
    </div>
    <?php
    foreach ($videos as $video) {
        $url = base_url("/assets/uploads/capsulas/".$video['con_CapsulaID']."/".$video['con_Archivo']);
        echo '<div class="col-md-6 videocapsula"  data-titulo="'.$video['con_Titulo'].'" data-url="'.$url.'" data-id="'. encryptDecrypt('encrypt',$video['con_ContenidoCapsulaID']).'">
                <div class="file-man-box card-box rounded " >
                    <div class="file-img-box">
                        <video width="100%" preload="metadata">
                            <source src="' . $url . '#t=0.5" >
                        </video>
                    </div>
                    <div class="file-man-title">
                        <h5 class="mb-0 text-overflow"># ' .$video['con_NumOrden']. '</h5>
                        <p class="mb-0">' .$video['con_Titulo']. '</p>
                    </div>
                </div>
            </div>';
    } ?>
</div>
<!--------------- Modal  ----------------->
<div class="modal fade in" id="modalVerVideo" style="background-color:rgba(10, 10, 10, 0.5);">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><b class="iconsminds-next"></b> </h4>
                <button class="close" type="button" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 text-justify" id="capsula">
                    </div>
                </div>
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