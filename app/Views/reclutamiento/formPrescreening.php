<!-- ======== HEDER ========= -->
<?php defined('FCPATH') or exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Prescreening</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url("assets/images/thigo/1.ico") ?>" />

    <!-- GC CSS FILES -->
    <?php
    if (isset($css_files)) {
        foreach ($css_files as $file) : ?>
            <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
    <?php endforeach;
    } ?>

    <!-- CUSTOM STYLES -->
    <?php
    if (isset($styles)) {
        foreach ($styles as $style) {
            echo '<link href="' . $style . '" rel="stylesheet" type="text/css" />';
        } //foreach
    } //if scripts
    ?>

    <!-- App css -->
    <link href="<?= base_url("assets/css/bootstrap.css") ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url("assets/css/icons.min.css") ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url("assets/libs/jquery-toast/jquery.toast.min.css") ?>" rel="stylesheet" type="text/css" />
    <link href="<?= base_url("assets/css/app.css") ?>" rel="stylesheet" type="text/css" />

    <!-- LOAD JQUERY FIRST -->
    <script src="<?= base_url("assets/js/jquery-3.3.1.min.js") ?>"></script>
</head>

<body>
    <script>
        const BASE_URL = '<?= base_url() ?>';
    </script>
    <!-- Begin page -->
    <div id="wrapper">

        <!-- Main -->
        <div class="content">
            <style>
                .select2-container {
                    width: 100% !important;
                }

                p {
                    text-align: justify;
                    hyphens: auto
                }

                .btn-secondary {
                    background-color: #f8e018 !important;
                    border: #f8e018 !important;
                    color: #fff !important;
                }

                .btn-success {
                    background-color: #001689 !important;
                    border: #001689 !important;
                    color: #fff !important;
                }
            </style>

            <?php
            $nombreEmpresa = getSetting('nombre_empresa', $this);
            ?>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 survey-app p-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="m-4">
                                    <br>
                                    <h1 class="text-dark"><strong><?= getSetting('nombre_empresa', $this) ?> (Reclutamiento)</strong></h1>
                                </div>
                                <div class="tab-content mb-4">
                                    <!-- TAB PRE-SCREENING -->
                                    <div class="tab-pane show active" id="tabPrescreening">
                                        <div class="row">
                                            <div class="col-12 col-lg-12">

                                                <div class="m-4">
                                                    <p class="mb-3" style="font-size: 26px;line-height: 26px;">
                                                        Agradecemos tu interés en integrarte a <b><?= $nombreEmpresa ?></b>; 
                                                        para conocerte mejor y programar una entrevista, necesitamos que por favor nos envíes este formato.
                                                    </p>
                                                    <p class="mb-3" style="font-size: 20px;line-height: 20px">En <b><?= $nombreEmpresa ?></b>
                                                        nos comprometemos a resguardar la información que nos proporcionas de manera confidencial de acuerdo a la Ley.
                                                        <hr>
                                                    </p>
                                                    <div class="row">
                                                        <div class="col-md-10">
                                                            
                                                            <p style="font-size:18px;hyphens: auto">Autorizo que mis datos personales y sensibles, se utilicen de manera interna en <b><?= $nombreEmpresa ?></b> conforme a los términos y condiciones del presente aviso de privacidad.</p>
                                                        </div>
                                                        <div class="form-group col-md-2 text-center align-self-center">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="autorizoS" name="autorizo" class="custom-control-input" value="SI" checked>
                                                                <label class="custom-control-label" for="autorizoS">Si</label>
                                                            </div>
                                                            <div class="custom-control custom-radio">
                                                                &nbsp;<input type="radio" id="autorizoN" name="autorizo" class="custom-control-input" value="NO">
                                                                <label class="custom-control-label" for="autorizoN">No</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr />
                                                    <br />
                                                    <div id="formPreScreening">
                                                        <form class="needs-validation mb-5" role="form" action="<?= base_url("Reclutamiento/addPreScreening") ?>" method="post" enctype="multipart/form-data" autocomplete="off" novalidate>
                                                            <input type="hidden" id="fechaActual" name="fechaActual" value="<?= date('Y-m-d') ?>">
                                                            <input type="hidden" id="solicitudPersonalID" name="solicitudPersonalID" value="<?= $solicitudPersonalID ?>">

                                                            <div class="text-right mt-2 mb-2">
                                                                <label style="font-size: 16px">Fecha: <?= longDate(date('Y-m-d'), ' de ') ?></label>
                                                            </div>

                                                            <div class="mb-4">
                                                                <h4 class="mt-3">DATOS PERSONALES</h4>
                                                                <hr>
                                                                <div class="form-row mb-2">
                                                                    <div class="col-md-6">
                                                                        <label for="nombreCandidato">Nombre</label>
                                                                        <input type="text" class="form-control" id="nombreCandidato" name="nombreCandidato" placeholder="Nombre(s) Apellido Paterno Apellido Materno" required>
                                                                        <div class="invalid-feedback" style="font-size: 90% !important;">
                                                                            Ingresa tu nombre
                                                                        </div>
                                                                    </div>
                                                                    <!--
                                                            <div class="col-md-3">
                                                                <label for="fechaNacimiento">Fecha de nacimiento</label>
                                                                <input id=fechaNacimiento" name="fechaNacimiento" type="text" class="form-control datepicker" data-position="bottom" placeholder="Fecha de nacimiento" required>
                                                                <div class="invalid-feedback" style="font-size: 90% !important;">
                                                                    Ingresa su fecha de nacimiento
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <label for="estadoCivil">Estado civil</label>
                                                                <select class="form-control select2" id="estadoCivil" name="estadoCivil" required>
                                                                    <option value="" hidden>Seleccione una opción</option>
                                                                    <option value="Soltero/a">Soltero/a</option>
                                                                    <option value="Casado/a">Casado/a</option>
                                                                    <option value="Divorciado/a">Divorciado/a</option>
                                                                    <option value="Viudo/a">Viudo/a</option>
                                                                </select>
                                                                <div class="invalid-feedback" style="font-size: 90% !important;">
                                                                    Seleccione su estado civil
                                                                </div>
                                                            </div>
-->
                                                                    <div class="col-md-4">
                                                                        <label for="numeroTelefono">Número de teléfono</label>
                                                                        <input type="text" class="form-control" id="numeroTelefono" name="numeroTelefono" placeholder="Ej.: (462) 000 00 00" pattern="[() 0-9]+" minlength="10" maxlength="20" required>
                                                                        <div class="invalid-feedback" style="font-size: 90% !important;">
                                                                            Ingresa tu número de teléfono
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                                <!--
                                                        <div class="form-row mb-2">
                                                            <div class="col-md-4">
                                                                <label for="numeroTelefono">Número de teléfono</label>
                                                                <input type="text" class="form-control" id="numeroTelefono" name="numeroTelefono"
                                                                       placeholder="Ej.: (462) 000 00 00" pattern="[() 0-9]+" minlength="10" maxlength="20" required>
                                                                <div class="invalid-feedback" style="font-size: 90% !important;">
                                                                    Ingresa tu número de teléfono
                                                                </div>
                                                            </div>
-->
                                                                <div class="form-row mb-2">
                                                                    <div class="col-md-4">
                                                                        <label for="correoElectronico">Correo electrónico</label>
                                                                        <input type="email" class="form-control" id="correoElectronico" name="correoElectronico" placeholder="Ej.: tucorreo@correo.com" required>
                                                                        <div class="invalid-feedback" style="font-size: 90% !important;">
                                                                            Ingresa tu correo electrónico
                                                                        </div>
                                                                    </div>
                                                                    <!--
                                                                    <div class="col-md-8">
                                                                        <label for="domicilio">Domicilio donde vive actualmente</label>
                                                                        <input type="text" class="form-control" id="domicilio" name="domicilio" placeholder="Calle #num Colonia, Ciudad, Estado" required>
                                                                        <div class="invalid-feedback" style="font-size: 90% !important;">
                                                                            Ingresa tu domicilio
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
            -->
                                                    </div>
<!--
                                                    <div class="mb-4" id="divEstudios">
                                                        <h4 class="mb-3">ESTUDIOS</h4>
                                                        <hr>
                                                        <div class="form-row">
                                                            <div class="col-md-5">
                                                                <label for="nivelEstudio">Último nivel de estudios concluido</label>
                                                                <select class="form-control select2" id="nivelEstudio" name="nivelEstudio" required>
                                                                    <option value="" hidden>Seleccione una opción</option>
                                                                    <option value="Estudiante">Estudiante</option>
                                                                    <option value="Egresado">Egresado</option>
                                                                    <option value="Bachillerato o Carrera Tecnica">Bachillerato o Carrera Tecnica</option>
                                                                    <option value="Titulado">Titulado</option>
                                                                </select>
                                                                <div class="invalid-feedback" style="font-size: 90% !important;">
                                                                    Seleccione su último nivel de estudios concluido
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-row" id="LicPos">
                                                            <div class="col-md-5">
                                                                <label for="queEstudia">Nombre de la carrera cursada</label>
                                                                <input type="text" class="form-control" id="carreraCursada" name="carreraCursada">
                                                                <div class="invalid-feedback" style="font-size: 90% !important;">
                                                                    Indique que el nombre de la carrera cursada
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 align-self-center">
                                                                <label for="titulado">¿Esta titulado/a?</label>
                                                                <div class="row">
                                                                    <div class="custom-control custom-radio col-md-6 text-center">
                                                                        <input type="radio" id="tituladoS" name="titulado" class="custom-control-input" value="SI" required>
                                                                        <label class="custom-control-label" for="tituladoS">SI</label>
                                                                        <div class="invalid-feedback mt-1" style="font-size: 90% !important;">
                                                                            Indique si esta titulado
                                                                        </div>
                                                                    </div>
                                                                    <div class="custom-control custom-radio col-md-6 text-center">
                                                                        <input type="radio" id="tituladoN" name="titulado" class="custom-control-input" value="NO" required>
                                                                        <label class="custom-control-label" for="tituladoN">NO</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
            -->
                                                        <!--<div class="form-row" id="estudiandoActualmente">
                                                            <div class="col-md-4" id="divqueEstudia">
                                                                <label for="queEstudia">¿Qué estudia?</label>
                                                                <input type="text" class="form-control" id="queEstudia" name="queEstudia">
                                                                <div class="invalid-feedback" style="font-size: 90% !important;">
                                                                    Indique que estudia
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4" id="divdondeEstudia">
                                                                <label for="dondeEstudia">¿Dónde estudia (lugar)?</label>
                                                                <input type="text" class="form-control" id="dondeEstudia" name="dondeEstudia">
                                                                <div class="invalid-feedback" style="font-size: 90% !important;">
                                                                    Indique donde estudia
                                                                </div>
                                                            </div>
                                                        </div>-->
                                                    </div>

                                                    <!--<div class="mb-4">
                                                        <h4 class="mb-3">DATOS GENERALES</h4>
                                                        <hr>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px"><?= $i = 1 ?></div>
                                                        <div class="form-row mb-3">
                                                            <div class="col-6">
                                                                <label for="conducir">¿Sabes conducir un vehículo estándar?</label>
                                                                <select class="form-control select2" id="conducir" name="conducir" required>
                                                                    <option value="" hidden>Seleccione una opción</option>
                                                                    <option value="Si">Sí</option>
                                                                    <option value="No">No</option>
                                                                </select>
                                                                <div class="invalid-feedback" style="font-size: 90% !important;">
                                                                    Seleccione si sabe conducir vehículo estándar
                                                                </div>
                                                            </div>
                                                            <div class="col-6" id="licenciaV">
                                                                <label class="mb-1">¿Tienes licencia vigente?</label>
                                                                <select class="form-control select2" id="licenciaVigente" name="licenciaVigente" required>
                                                                    <option value="" hidden>Seleccione una opción</option>
                                                                    <option value="Si">Sí</option>
                                                                    <option value="No">No</option>
                                                                </select>
                                                                <div class="invalid-feedback" style="font-size: 90% !important;">
                                                                    Seleccione si sabe conducir vehículo estándar
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px"><?= $i += 1 ?></div>
                                                        <div class="form-row mb-3">
                                                            <div class="col-md-12">
                                                                <label class="mb-1">Menciona 3 fortalezas que consideras posees para desempeñar el puesto solicitado: </label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="fortaleza1">Fortaleza 1</label>
                                                                <input type="text" class="form-control" id="fortaleza1" name="fortaleza1" required>
                                                                <div class="invalid-feedback" style="font-size: 90% !important;">
                                                                    Este campo es obligatorio
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="fortaleza2">Fortaleza 2</label>
                                                                <input type="text" class="form-control" id="fortaleza2" name="fortaleza2" required>
                                                                <div class="invalid-feedback" style="font-size: 90% !important;">
                                                                    Este campo es obligatorio
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="fortaleza1">Fortaleza 3</label>
                                                                <input type="text" class="form-control" id="fortaleza3" name="fortaleza3" required>
                                                                <div class="invalid-feedback" style="font-size: 90% !important;">
                                                                    Este campo es obligatorio
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px"><?= $i += 1 ?></div>
                                                        <div class="form-row mb-3">
                                                            <div class="col-md-12">
                                                                <label class="mb-1">Menciona 3 áreas de oportunidad que necesitas desarrollar para desempeñarte mejor:</label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="area1">Área de oportunidad 1</label>
                                                                <input type="text" class="form-control" id="area1" name="area1" required>
                                                                <div class="invalid-feedback" style="font-size: 90% !important;">
                                                                    Este campo es obligatorio
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="area2">Área de oportunidad 2</label>
                                                                <input type="text" class="form-control" id="area2" name="area2" required>
                                                                <div class="invalid-feedback" style="font-size: 90% !important;">
                                                                    Este campo es obligatorio
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <label for="area3">Área de oportunidad 3</label>
                                                                <input type="text" class="form-control" id="area3" name="area3" required>
                                                                <div class="invalid-feedback" style="font-size: 90% !important;">
                                                                    Este campo es obligatorio
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px"><?= $i += 1 ?></div>
                                                        <div class="form-row mb-3">
                                                            <div class="col-md-12 mb-12">
                                                                <label class="mb-1">Algún comentario que consideres importante mencionar:</label>
                                                                <textarea type="text" class="form-control" id="comentario" name="comentario"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>-->
                                                    <div class="col-12" id="divCV">
                                                        <div class="m-4">
                                                            <p style="font-size: 26px;line-height: 26px;">Por favor envié su Currículum Vitae (CV) en formato PDF.</p>
                                                        </div>
                                                        <div class="m-4">
                                                            <!--<input type="file" class="form-control file" id="inputCV" name="inputCV" data-msg-placeholder="" required>-->
                                                            <input type="file" class="input-filestyle" id="archivo" name="archivo" accept=".pdf" required="required">
                                                        </div>
                                                    </div>


                                                    <div class="card-footer mt-4" id="divEnviar">
                                                        <br />
                                                        <div class="col-md-12" style="text-align: center">
                                                            <b>Firma del candidato<br> (se considera firma electrónica el envió del presente formulario del candidato)</b>
                                                        </div>
                                                        <br />
                                                        <div class="col-md-12">
                                                            <p>
                                                                Ratifico que la información proporcionada en este documento es veraz y estoy de acuerdo en que la empresa
                                                                “<?= $nombreEmpresa ?>” con motivo de mi postulación realizar las investigaciones que juzgue convenientes, con motivo de
                                                                mi postulación, y me doy por enterado que la información que se obtenga se manejará de manera confidencia
                                                                tal como lo establece su aviso de privacidad el cual se menciona al inicio del presente documento.
                                                            </p>
                                                        </div>
                                                        <div class="text-right">
                                                            <button id="" class="btn btn-success" type="submit"><i class="fe-send"></i> Enviar PRE-SCREENING</button>
                                                        </div>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script>
            $(document).ready(function(e) {

                var $curp = $('#curp');
                var $rfc = $('#rfc');
                var $estudia = $('input:radio[name=estudia]');
                var $trabajo = $('input:radio[name=trabajo]');
                var $autorizo = $('input:radio[name=autorizo]');
                var $cv = $('#inputCV');
                //var $btnPreScreening = $('#btnEnviarPreScreening');
                var $btnSubir = $('#btnSubirCVCandidato');
                $(".input-filestyle").filestyle('placeholder', 'Seleccione un archivo (.pdf )');

                $(".datepicker").datepicker({
                    autoclose: !0,
                    todayHighlight: !0,
                    format: "yyyy-mm-dd",
                    daysOfWeek: ["D", "L", "M", "M", "J", "V", "S"],
                    monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                });

                $(".select2").select2();

                //input CV
                if ($cv.fileinput) {
                    $cv.fileinput({
                        showUpload: false,
                        dropZoneEnabled: false,
                        language: "es",
                        mainClass: "input-group",
                        allowedFileExtensions: ["pdf"]
                    });
                }



                //Mostar y Ocultar inputs
                $estudia.change(function() {
                    var estudia = $('input:radio[name=estudia]:checked').val();

                    if (estudia == 'SI') {
                        $('#queEstudia').attr('required', 'required');
                        $('#dondeEstudia').attr('required', 'required');
                        $('#horarioEstudia').attr('required', 'required');
                        //muestra
                        $('#divqueEstudia').show();
                        $('#divdondeEstudia').show();
                        $('#divhorarioEstudia').show();
                    } else if (estudia == 'NO') {
                        $('#queEstudia').removeAttr('required');
                        $('#dondeEstudia').removeAttr('required');
                        $('#horarioEstudia').removeAttr('required');
                        //Oculta
                        $('#divqueEstudia').hide();
                        $('#divdondeEstudia').hide();
                        $('#divhorarioEstudia').hide();
                    }
                });

                $("#LicPos").hide();
                $("#estudiandoActualmente").hide();
                $("body").on("change", "#nivelEstudio", function(e) {
                    e.preventDefault();
                    nivelEstudio = $("#nivelEstudio").val();
                    if ((nivelEstudio === 'Titulado')) {
                        $("#LicPos").show();
                        $("#estudiandoActualmente").hide();

                        $("#carreraCursada").prop('required', true);
                        $("#tituladoS").prop('required', true);
                        $("#tituladoN").prop('required', true);
                        $("#queEstudia").prop('required', false);
                        $("#dondeEstudia").prop('required', false);

                    } else {
                        $("#LicPos").hide();

                        $("#carreraCursada").prop('required', false);
                        $("#tituladoS").prop('required', false);
                        $("#tituladoN").prop('required', false);
                        $("#queEstudia").prop('required', true);
                        $("#dondeEstudia").prop('required', true);
                    }
                });
                $("#licenciaV").hide();
                $("body").on("change", "#conducir", function(e) {
                    e.preventDefault();
                    conducir = $("#conducir").val();
                    if (conducir === 'Si') {
                        $("#licenciaV").show();

                        $("#licenciaVigente").prop('required', true);

                    } else {
                        $("#licenciaV").hide();

                        $("#licenciaVigente").prop('required', false);
                    }
                });

                $trabajo.change(function() {
                    var trabajo = $('input:radio[name=trabajo]:checked').val();

                    if (trabajo == 'SI') {
                        $('#puestoSolicitadoAnterior').attr('required', 'required');
                        $('#fechaPuestoAnterior').attr('required', 'required');
                        //Muestra
                        $('#divpuestoSolicitadoAnterior').show();
                        $('#divfechaPuestoAnterior').show();
                    } else if (trabajo == 'NO') {
                        $('#puestoSolicitadoAnterior').removeAttr('required');
                        $('#fechaPuestoAnterior').removeAttr('required');
                        //Oculta
                        $('#divpuestoSolicitadoAnterior').hide();
                        $('#divfechaPuestoAnterior').hide()
                    }
                });

                $autorizo.change(function() {
                    var autorizo = $('input:radio[name=autorizo]:checked').val();

                    if (autorizo == 'SI') {
                        //Muestra
                        $('#formPreScreening').show();
                        $("#divEstudios").show();
                        $("#divCV").show();
                        $("#divEnviar").show();
                    } else if (autorizo == 'NO') {
                        //Oculta
                        $('#formPreScreening').hide();
                        $("#divEstudios").hide();
                        $("#divCV").hide();
                        $("#divEnviar").hide();
                        $.toast({
                            text: 'Debe autorizar que sus datos puedan ser utilizados por <?= $nombreEmpresa ?>',
                            icon: 'info',
                            loader: true,
                            loaderBg: '#c6c372',
                            position: 'top-right',
                            allowToastClose: true,
                        });
                    }
                });

                //Sube PDF del CV
                $btnSubir.click(function() {
                    if ($cv.val() != '') {
                        var form = $("#formSubirCVCandidato")[0];
                        var data = new FormData(form);

                        $.ajax({
                            url: BASE_URL + "Usuario/ajax_guardarCVCandidato/",
                            type: "POST",
                            data: data,
                            dataType: "json",
                            cache: false,
                            contentType: false,
                            processData: false
                        }).done(function(data) {
                            if (data.response === "success") {
                                location.reload();
                                toastr['success']("¡Archivo guardado correctamente!", "¡Correcto!");
                            } else toastr['warning']("¡Ocurrio un error. Inténtalo de nuevo!", "¡Error!");
                        });
                    } else {
                        toastr['warning']("Por favor seleccione un archivo.", "¡Error!");
                    }
                });
            });
        </script>

        <!-- ======== FOOTER ========= -->
    </div> <!-- end container-fluid -->

    </div> <!-- end wrapper -->


    <!-- Vendor js -->
    <script src="<?= base_url("assets/js/vendor.min.js") ?>"></script>

    <?php
    //GROCERY CRUD JS
    if (isset($js_files)) {
        foreach ($js_files as $file) : ?>

            <script src="<?php echo $file; ?>"></script>
    <?php endforeach;
    } ?>
    <?php

    //CUSTOM SCRIPTS
    if (isset($scripts)) {
        foreach ($scripts as $script) {
            echo '<script src="' . $script . '" type="text/javascript"></script>';
        } //foreach
    } //if scripts
    ?>
    <!-- App js -->
    <script src="<?= base_url("assets/libs/jquery-toast/jquery.toast.min.js") ?>"></script>
    <script src="<?= base_url("assets/js/app.min.js") ?>"></script>
    <script type="text/javascript">
        <?php if (isset($_SESSION['response'])) { ?>
            $.toast({
                text: "<?= $_SESSION['txttoastr'] ?>",
                icon: "<?= $_SESSION['response'] ?>",
                loader: true,
                loaderBg: '#c6c372',
                position: 'top-right',
                allowToastClose: true,
            });

        <?php } //if 
        ?>
    </script>
</body>

</html>