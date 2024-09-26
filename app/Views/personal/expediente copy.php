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
    <div class="col-12">
        <div class="card-box">
            <h5 class="mb-2">Carga de archivos</h5>
            <div class="row">

                <?php foreach ($expedientes as $exp) { ?>
                    <div class="col-lg-4 col-xl-3">
                        <div class="file-man-box rounded mb-3">
                            <h5 class="mb-0 text-overflow text-center pb-2"><?= $exp['exp_Nombre']; ?></h5>
                            <div class="file-img-box " hidden>
                                <img src="<?= base_url('assets/images/file_icons/bmp.svg') ?>" alt="icon">
                            </div>
                            <?php //if(revisarPermisos('Agregar',$this)){
                            ?>
                            <form id="iddrop<?= $exp['exp_ExpedienteID']; ?>" class="dropzone divdrop" action="/ajax_file_upload_handler/" enctype="multipart/form-data" method="post">
                                <div class="fallback">
                                    <input name="file" type="file" required>
                                </div>

                                <div class="dz-message needsclick text-center">
                                    <i class="h1 text-muted icon ion-arrow-up-a"></i>
                                    <h4 class="text-muted">Arrastra o da click para subir el archivo.</h4>
                                </div>

                            </form>
                            <?php /*}else{ ?>

                                <div class="dz-message needsclick text-center">
                                    <i class="h1 text-muted icon ion-arrow-up-a"></i>
                                    <h4 class="text-muted">No se ha subido archivo.</h4>
                                </div>
                            <?php } */ ?>
                            <div id="idbox<?= $exp['exp_ExpedienteID'] ?>" class="file-img-box">
                                <img id="idicon<?= $exp['exp_ExpedienteID'] ?>" src="" class="avatar-lg" alt="icon">
                            </div>
                            <div>
                                <?php if (revisarPermisos('Eliminar', $this)) { ?>
                                    <a href="" id="iddel<?= $exp['exp_ExpedienteID']; ?>" data-title="<?= $exp['exp_Nombre']; ?>" class="file-download btndel" data-empleadoid="<?= $empleadoID; ?>" data-expedienteid="<?= $exp['exp_ExpedienteID']; ?>" style="padding-right: 30px;"><i class="mdi c"></i> </a>
                                <?php } ?>
                                <a href="" id="idimg<?= $exp['exp_ExpedienteID']; ?>" data-lightbox="<?= $exp['exp_Nombre']; ?>" data-title="<?= $exp['exp_Nombre']; ?>" class="file-download"><i class="mdi mdi-eye "></i></a>
                                <a href="" id="idpdf<?= $exp['exp_ExpedienteID']; ?>" title="Imprimir <?= $exp['exp_Nombre']; ?>" data-title="<?= $exp['exp_Nombre']; ?>" class="file-download show-pdf"><i class="mdi mdi-eye "></i> </a>

                            </div>
                            <div class="file-man-title">
                                <h5 class="mb-0 text-overflow" id="idtxt<?= $exp['exp_ExpedienteID']; ?>">Sin subir</h5>
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
    </div><!-- end col -->
</div>
<!--Historial-->
<div class="row">
    <div class="col-12">
        <div class="card-box">
            <h3 class=" mb-4 text-center">EXPEDIENTE DE <?= strtoupper($empleado) ?></h3>
            <div class="card-box widget-flat border-blue bg-success text-white" style="background-color: #001689!important;border-radius: 15px">
                <i class="fas fa-clipboard-list" style="right: 5%;left:auto;"></i>
                <h4 class="text-uppercase font-weight-bold text-white">EXTERNOS.</h4>
            </div>

            <?php
            foreach ($C1 as $exp) { ?>
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-blue" role="alert">
                            <h5><b><?= strtoupper($exp['exp_Nombre']) ?></b></h5>
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
                        <div class="col-2">
                            <div class="file-man-box rounded mb-3 text-rig">
                                <a href="" class="file-close"><i class="mdi mdi-close-circle"></i></a>
                                <div class="file-img-box">
                                    <img src="<?= $imagen ?>" class="avatar-lg" alt="icon">
                                </div>
                                <a href="<?= $archivo['url'] ?>" target="_blank" class="file-download"><i class="mdi mdi-download"></i> </a>
                                <div class="file-man-title">
                                    <h5 class="mb-0 text-overflow"><?= $nombre[0] ?></h5>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>

            <div class="card-box widget-flat border-blue bg-success text-white" style="background-color: #001689!important;border-radius: 15px">
                <i class="fas fa-clipboard-list" style="right: 5%;left:auto;"></i>
                <h4 class="text-uppercase font-weight-bold text-white">INTERNOS.</h4>
            </div>

            <?php
            foreach ($C2 as $exp) { ?>
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-blue" role="alert">
                            <h5><b><?= strtoupper($exp['exp_Nombre']) ?></b></h5>
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
                        <div class="col-2">
                            <div class="file-man-box rounded mb-3">
                                <a href="" class="file-close"><i class="mdi mdi-close-circle"></i></a>
                                <div class="file-img-box">
                                    <img src="<?= $imagen ?>" class="avatar-lg" alt="icon">
                                </div>
                                <a href="<?= $archivo['url'] ?>" target="_blank" class="file-download"><i class="mdi mdi-download"></i> </a>
                                <div class="file-man-title">
                                    <h5 class="mb-0 text-overflow"><?= $nombre[0] ?></h5>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div><!-- end col -->
</div>
<!-- end row -->

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
                    $("#idtxt" + nombre).text('Subido');
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