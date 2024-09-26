<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<style>
    .divdrop {
        border: 2px dashed black;
        background-color: rgba(182, 191, 226, 0.04);
        border-radius: 10px;
        border-color: rgb(231, 114, 52);
        cursor: pointer;
    }
</style>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="header">
                <h5 class="text-center">EXPEDIENTE DE <?= strtoupper($empleado) ?></h5>
            </div>
            <div class="body"> 
                <!-- Nav tabs -->
                <ul class="nav nav-tabs row text-center">
                    <li class="nav-item col-md-6"><a class="nav-link active" data-toggle="tab" href="#docs"><i class="zmdi zmdi-folder-person"></i> DOCUMENTOS</a></li>
                    <li class="nav-item col-md-6"><a class="nav-link" data-toggle="tab" href="#carga"><i class="zmdi zmdi-cloud-upload"></i> CARGA DE ARCHIVOS</a></li>
                </ul>                        
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane in active" id="docs"> 
                        <div class="panel-group" id="accordion_1" role="tablist" aria-multiselectable="true">
                            <div class="panel panel-primary">
                                <div class="panel-heading" role="tab" id="headingOne_1">
                                    <h6 class="panel-title"> <a role="button" data-toggle="collapse" data-parent="#accordion_1" href="#collapseOne_1" 
                                            aria-expanded="true" aria-controls="collapseOne_1"> Externos </a> </h6>
                                </div>
                                <div id="collapseOne_1" class="panel-collapse collapse in collapse show" role="tabpanel" aria-labelledby="headingOne_1">
                                    <div class="panel-body"> 
                                    <?php
                                    foreach ($C1 as $exp) { ?>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="alert l-slategray" role="alert">
                                                    <h6><b><?= strtoupper($exp['exp_Nombre']) ?></b></h6>
                                                </div>
                                            </div>
                                            <?php
                                            $archivos = historialExpediente($exp['exp_ExpedienteID'], $empleadoID);
                                            foreach ($archivos as $archivo) {
                                                $rest = strtolower(substr($archivo['url'], -3));
                                                if ($rest == "jpg" || $rest == "peg" || $rest == "png") {
                                                    $imagen = base_url('/assets/images/file_icons/' . $rest . '.svg');
                                                }
                                                if ($rest == "pdf") {
                                                    $imagen = base_url('/assets/images/file_icons/pdf.svg');
                                                }

                                                if ($rest == "ocx" || $rest == 'doc') {
                                                    $imagen = base_url('/assets/images/file_icons/doc.svg');
                                                }

                                                if ($rest == "iff") {
                                                    $imagen = base_url('/assets/images/file_icons/tif.svg');
                                                }

                                                $archivoNombre = explode('/', $archivo['url']);
                                                $count = count($archivoNombre) - 1;
                                                $nombre = explode('.', $archivoNombre[$count]);
                                            ?>
                                                <div class="col-1 text-right">
                                                    <div class="file-man-box rounded mb-3">
                                                        <a href="" class="file-close"><i class="zmdi zmdi-close-circle"></i></a>
                                                        <br>
                                                        <div class="file-img-box">
                                                            <img src="<?= $imagen ?>"  alt="icon" width="80" height="80">
                                                        </div>
                                                        <br>
                                                        <div class="file-man-title">
                                                            <h6 class="mb-0 text-overflow"><?= $nombre[0] ?></h6>
                                                            <a href="<?= $archivo['url'] ?>" target="_blank" class="file-download"><i class="zmdi zmdi-download"></i> </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-primary">
                                <div class="panel-heading" role="tab" id="headingTwo_1">
                                    <h6 class="panel-title"> <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_1" href="#collapseTwo_1" aria-expanded="false"
                                            aria-controls="collapseTwo_1"> Internos </a> </h6>
                                </div>
                                <div id="collapseTwo_1" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo_1">
                                    <div class="panel-body"> 
                                    <?php
                                    foreach ($C2 as $exp) { ?>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="alert l-slategray" role="alert">
                                                    <h6><b><?= strtoupper($exp['exp_Nombre']) ?></b></h6>
                                                </div>
                                            </div>
                                            <?php
                                            $archivos = historialExpediente($exp['exp_ExpedienteID'], $empleadoID);


                                            foreach ($archivos as $archivo) {

                                                $rest = strtolower(substr($archivo['url'], -3));
                                                if ($rest == "jpg" || $rest == "peg" || $rest == "png") {
                                                    $imagen = base_url('/assets/images/file_icons/' . $rest . '.svg');
                                                }
                                                if ($rest == "pdf") {
                                                    $imagen = base_url('/assets/images/file_icons/pdf.svg');
                                                }

                                                if ($rest == "ocx" || $rest == 'doc') {
                                                    $imagen = base_url('/assets/images/file_icons/doc.svg');
                                                }

                                                if ($rest == "tiff") {
                                                    $imagen = base_url('/assets/images/file_icons/tif.svg');
                                                }

                                                $archivoNombre = explode('/', $archivo['url']);
                                                $count = count($archivoNombre) - 1;
                                                $nombre = explode('.', $archivoNombre[$count]);
                                            ?>
                                                <div class="col-1 text-right">
                                                    <div class="file-man-box rounded mb-3">
                                                        <a href="" class="file-close"><i class="zmdi zmdi-close-circle"></i></a>
                                                        <br>
                                                        <div class="file-img-box">
                                                            <img src="<?= $imagen ?>"  alt="icon" width="80" height="80">
                                                        </div>
                                                        <br>
                                                        <div class="file-man-title">
                                                            <h6 class="mb-0 text-overflow"><?= $nombre[0] ?></h6>
                                                            <a href="<?= $archivo['url'] ?>" target="_blank" class="file-download"><i class="zmdi zmdi-download"></i> </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>

                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="carga"> 
                        <div class="row">
                            <?php foreach ($expedientes as $exp) { ?>
                                <div class="col-lg-3 col-xl-3">
                                    <div class="file-man-box rounded mb-3">
                                        <h6 class="mb-0 text-overflow text-center pb-2"><?= $exp['exp_Nombre']; ?></h6>
                                        <div class="file-img-box " hidden>
                                            <img src="<?= base_url('assets/images/file_icons/bmp.svg') ?>" alt="icon" width="80" height="80">
                                        </div>
                                        <form id="iddrop<?= $exp['exp_ExpedienteID']; ?>" class="dropzone divdrop" action="/ajax_file_upload_handler/" enctype="multipart/form-data" method="post">
                                            <div class="fallback">
                                                <input name="file" type="file" required>
                                            </div>

                                            <div class="dz-message needsclick text-center">
                                                <i class="h1 text-muted icon ion-arrow-up-a"></i>
                                                <span class="text-muted">Arrastra o da click para subir el archivo.</span>
                                            </div>

                                        </form>
                                        
                                        <div id="idbox<?= $exp['exp_ExpedienteID'] ?>" class="file-img-box">
                                            <img id="idicon<?= $exp['exp_ExpedienteID'] ?>" src="" class="avatar-lg" alt="icon"  width="80" height="80">
                                        </div>
                                        <div class="text-right">
                                            <?php if (revisarPermisos('Eliminar', $this)) { ?>
                                                <a href="" id="iddel<?= $exp['exp_ExpedienteID']; ?>" data-title="<?= $exp['exp_Nombre']; ?>" class="file-download btndel" data-empleadoid="<?= $empleadoID; ?>" data-expedienteid="<?= $exp['exp_ExpedienteID']; ?>" style="padding-right: 30px;"><i class="mdi c"></i> </a>
                                            <?php } ?>
                                            <a href="" id="idimg<?= $exp['exp_ExpedienteID']; ?>" data-lightbox="<?= $exp['exp_Nombre']; ?>" data-title="<?= $exp['exp_Nombre']; ?>" class="file-download"><i class="zmdi zmdi-eye "></i></a>
                                            <a href="" id="idpdf<?= $exp['exp_ExpedienteID']; ?>" title="Imprimir <?= $exp['exp_Nombre']; ?>" data-title="<?= $exp['exp_Nombre']; ?>" class="file-download show-pdf"><i class="zmdi zmdi-eye "></i> </a>

                                        </div>
                                        <div class="file-man-title">
                                            <p class="mb-0 text-overflow" id="idtxt<?= $exp['exp_ExpedienteID']; ?>">Sin subir</p>
                                            <p hidden class="mb-0" id="idsize<?= $exp['exp_ExpedienteID']; ?>"><small>0.0 kb</small></p>
                                        </div>
                                        <?php
                                        $archivo = fileExpediente($exp['exp_ExpedienteID'], $empleadoID);

                                        if (empty($archivo)) {
                                            echo ' <script>
                                                    $("#idbox' . $exp['exp_ExpedienteID'] . '").hide();
                                                    $("#idpdf' . $exp['exp_ExpedienteID'] . '").hide();
                                                    $("#iddel' . $exp['exp_ExpedienteID'] . '").hide();
                                                    $("#idimg' . $exp['exp_ExpedienteID'] . '").hide();
                                                    $("#iddrop' . $exp['exp_ExpedienteID'] . '").show();
                                                    </script>';
                                        } else {
                                            $rest = strtolower(substr($archivo[0]['url'], -3));
                                            $archivoNombre = explode('/', $archivo[0]['url']);

                                            $count = count($archivoNombre) - 1;
                                            $fechaNArchivo = explode('.', $archivoNombre[$count]);
                                            $longitud = strlen($fechaNArchivo[0]);
                                            $fechaArchivo = substr($fechaNArchivo[0], 0, $longitud);
                                            $fechaActual = date('Y-m-d');
                                            $diferencia = diferenciaMeses($fechaActual, $fechaArchivo);
                                            echo ' <script>
                                                    $("#idbox' . $exp['exp_ExpedienteID'] . '").hide();
                                                    $("#idpdf' . $exp['exp_ExpedienteID'] . '").hide();
                                                    $("#iddel' . $exp['exp_ExpedienteID'] . '").hide();
                                                    $("#idimg' . $exp['exp_ExpedienteID'] . '").hide();
                                                    $("#iddrop' . $exp['exp_ExpedienteID'] . '").show();
                                                    </script>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(e) {

        <?php foreach ($expedientes as $exp) { ?>
            var $nombre = $("#iddrop<?= $exp['exp_ExpedienteID'] ?>");
            $($nombre).dropzone({
                url: BASE_URL + "Personal/ajax_GuardarExpediente/<?= $exp['exp_ExpedienteID'] ?>/<?= $empleadoID ?>",
                acceptedFiles: ".docx, .pdf, .png, .jpg, .jpeg,.doc,.JPG,.JPEG,.tiff,.TIFF",
                maxFiles: 1,
                addRemoveLinks: true,
                error: function(result) {
                    arrorTipo(<?= $exp['exp_ExpedienteID'] ?>);
                },
                success: function(file) {

                    agregado();


                    var nombre = <?= $exp['exp_ExpedienteID'] ?>;
                    data = JSON.parse(file.xhr.response);
                    dir = data.dir
                    ext = data.ext
                    base = data.base

                    $("#iddrop" + nombre).hide();
                    $("#idbox" + nombre).show();
                    $("#idtxt" + nombre).text('Cargado');
                    $("#iddel" + nombre).show();

                    if (ext === "pdf") {
                        $("#idpdf" + nombre).attr("href", dir); // Set herf value
                        $("#idpdf" + nombre).show();
                        $("#idimg" + nombre).hide();
                        $("#idicon" + nombre).attr("src", base + "/assets/images/file_icons/pdf.svg");
                    }

                    if (ext === "docx") {
                        $("#idpdf" + nombre).attr("href", dir); // Set herf value
                        $("#idpdf" + nombre).show();
                        $("#idimg" + nombre).hide();
                        $("#idicon" + nombre).attr("src", base + "/assets/images/file_icons/doc.svg");
                        $("#idpdf" + nombre).removeClass("show-pdf");
                    }

                    if (ext === "jpg" || ext === "jpeg" || ext === "png" || ext === "JPG" ||
                        ext === "JPEG") {
                        $("#idimg" + nombre).attr("href", dir); // Set herf value
                        $("#idpdf" + nombre).hide();
                        $("#idimg" + nombre).show();
                        $("#idicon" + nombre).attr("src", base + "/assets/images/file_icons/" + ext + ".svg");

                    }

                    if (ext === "tiff" || ext === "TIFF") {
                        $("#idimg" + nombre).attr("href", dir); // Set herf value
                        $("#idpdf" + nombre).hide();
                        $("#idimg" + nombre).show();
                        $("#idicon" + nombre).attr("src", base + "/assets/images/file_icons/tif.svg");

                    }

                }
            });
        <?php } ?>

        function agregado() {
            $.toast({
                text: "Archivo agregado",
                icon: "success",
                loader: true,
                loaderBg: '#c6c372',
                position: 'top-right',
                allowToastClose: true,
            });
        }

        function arrorTipo($nombreFile) {
            $.toast({
                text: "Solo se permiten archivos PDF, JPG, PNG, TIFF, JPEG Y WORD",
                icon: "danger",
                loader: true,
                loaderBg: '#c6c372',
                position: 'top-right',
                allowToastClose: true,
            });

            var myDropzone = Dropzone.forElement("#iddrop" + $nombreFile);
            myDropzone.removeAllFiles(true);

        }

    });
</script>