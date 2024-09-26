<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<style>
    p {
        text-align: justify;
        hyphens: auto
    }
</style>

<?php
if (!is_null($periodo)) {
    if ($permitir) { ?>
        <div class="row">
            <div class="col-12 survey-app p-3">
                <div class="card">
                    <div class="card-body">
                        <div class="m-4">
                            <br>
                            <h1 class="text-dark text-center"><strong class="text-info">Evaluación de Acontecimientos Traumáticos Severos</strong></h1>
                        </div>
                        <div class="tab-content mb-4">
                            <!-- TAB PRE-SCREENING -->
                            <div class="tab-pane show active" id="tabPrescreening">
                                <div class="row">
                                    <div class="col-12 col-lg-12">
                                        <div class="m-4">
                                            <hr /><br />
                                            <div id="formPreScreening">
                                                <form class="needs-validation mb-5" role="form" action="<?= base_url("Evaluaciones/addGuia1") ?>" method="post" enctype="multipart/form-data" autocomplete="off" novalidate>
                                                    <input type="hidden" id="fechaActual" name="fechaActual" value="<?= date('Y-m-d') ?>">
                                                    <input type="hidden" id="evaluado" name="evaluado" value="<?= $evaluadoID ?>">

                                                    <div class="text-right ">
                                                        <div class="header">
                                                            <h2><strong>Fecha: <?= longDate(date('Y-m-d'), ' de ') ?></strong></h2>
                                                        </div>
                                                    </div>
                                                    <div class="mb-4">
                                                        <div class="header">
                                                            <h2><strong>I.- ACONTECIMIENTO TRAUMÁTICO SEVERO</strong></h2>
                                                        </div>
                                                        <hr>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">1</div>
                                                        <label>
                                                            ¿Ha presenciado o sufrido alguna vez, durante o con motivo del trabajo un acontecimiento
                                                            como los siguientes:
                                                            <br>&#8594 Accidente que tenga como consecuencia la muerte, la pérdida de un miembro o una lesión grave?
                                                            <br>&#8594 Asaltos?
                                                            <br>&#8594 Actos violentos que derivaron en lesiones graves?
                                                            <br>&#8594 Secuestro?
                                                            <br>&#8594 Amenazas?, o
                                                            <br>&#8594 Cualquier otro que ponga en riesgo su vida o salud, y/o la de otras personas?
                                                        </label>
                                                        <div class="form-row text-center">
                                                            <div class="form-group col-6">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" id="rdoATS_SI" name="rdoATS_ATS" class="custom-control-input" value="SI" required>
                                                                    <label class="custom-control-label" for="rdoATS_SI">SI</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-6">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" id="rdoATS_NO" name="rdoATS_ATS" class="custom-control-input" value="NO" required>
                                                                    <label class="custom-control-label" for="rdoATS_NO">NO</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                    </div>
                                                    <div class="mb-4" id="recuerdosDiv">
                                                        <div class="header">
                                                            <h2><strong>II.- RECUERDOS PERSISTENTES SOBRE EL ACONTECIMIENTO (DURANTE EL ÚLTIMO MES)</strong></h2>
                                                        </div>
                                                        <hr>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important"><?php echo $i = 1 ?></div>
                                                        <label>
                                                            ¿Ha tenido recuerdos recurrentes sobre el acontecimiento que le provocan malestares?
                                                        </label>
                                                        <div class="form-row text-center">
                                                            <div class="form-group col-6">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" id="rdoREC<?= $i ?>_SI" name="rdoATS_REC<?= $i ?>" class="custom-control-input" value="SI">
                                                                    <label class="custom-control-label" for="rdoREC<?= $i ?>_SI">SI</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-6">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" id="rdoREC<?= $i ?>_NO" name="rdoATS_REC<?= $i ?>" class="custom-control-input" value="NO">
                                                                    <label class="custom-control-label" for="rdoREC<?= $i ?>_NO">NO</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important"><?= $i += 1 ?></div>
                                                        <label>
                                                            ¿Ha tenido sueños de carácter recurrente sobre el acontecimiento, que le producen malestar?
                                                        </label>
                                                        <div class="form-row text-center">
                                                            <div class="form-group col-6">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" id="rdoREC<?= $i ?>_SI" name="rdoATS_REC<?= $i ?>" class="custom-control-input" value="SI">
                                                                    <label class="custom-control-label" for="rdoREC<?= $i ?>_SI">SI</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-6">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" id="rdoREC<?= $i ?>_NO" name="rdoATS_REC<?= $i ?>" class="custom-control-input" value="NO">
                                                                    <label class="custom-control-label" for="rdoREC<?= $i ?>_NO">NO</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                    </div>
                                                    <div class="mb-4" id="esfuerzoDiv">
                                                        <div class="header">
                                                            <h2><strong>III.- ESFUERZO POR EVITAR CIRCUNSTANCIAS PARECIDAS O ASOCIADAS AL ACONTECIMIENTO (DURANTE EL ÚLTIMO MES)</strong></h2>
                                                        </div>
                                                        <hr>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important"><?php echo $i = 1 ?></div>
                                                        <label>
                                                            ¿Se ha esforzado por evitar todo tipo de sentimientos, conversaciones o situaciones que le puedan recordar el acontecimiento?
                                                        </label>
                                                        <div class="form-row text-center">
                                                            <div class="form-group col-6">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" id="rdoESF<?= $i ?>_SI" name="rdoATS_ESF<?= $i ?>" class="custom-control-input" value="SI">
                                                                    <label class="custom-control-label" for="rdoESF<?= $i ?>_SI">SI</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-6">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" id="rdoESF<?= $i ?>_NO" name="rdoATS_ESF<?= $i ?>" class="custom-control-input" value="NO">
                                                                    <label class="custom-control-label" for="rdoESF<?= $i ?>_NO">NO</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important"><?= $i += 1 ?></div>
                                                        <label>
                                                            ¿Se ha esforzado por evitar todo tipo de actividades, lugares o personas que motivan recuerdos del acontecimiento?
                                                        </label>
                                                        <div class="form-row text-center">
                                                            <div class="form-group col-6">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" id="rdoESF<?= $i ?>_SI" name="rdoATS_ESF<?= $i ?>" class="custom-control-input" value="SI">
                                                                    <label class="custom-control-label" for="rdoESF<?= $i ?>_SI">SI</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-6">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" id="rdoESF<?= $i ?>_NO" name="rdoATS_ESF<?= $i ?>" class="custom-control-input" value="NO">
                                                                    <label class="custom-control-label" for="rdoESF<?= $i ?>_NO">NO</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important"><?= $i += 1 ?></div>
                                                        <label>
                                                            ¿Ha tenido dificultad para recordar alguna parte importante del evento?
                                                        </label>
                                                        <div class="form-row text-center">
                                                            <div class="form-group col-6">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" id="rdoESF<?= $i ?>_SI" name="rdoATS_ESF<?= $i ?>" class="custom-control-input" value="SI">
                                                                    <label class="custom-control-label" for="rdoESF<?= $i ?>_SI">SI</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-6">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" id="rdoESF<?= $i ?>_NO" name="rdoATS_ESF<?= $i ?>" class="custom-control-input" value="NO">
                                                                    <label class="custom-control-label" for="rdoESF<?= $i ?>_NO">NO</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important"><?= $i += 1 ?></div>
                                                        <label>
                                                            ¿Ha disminuido su interés en sus actividades cotidianas?
                                                        </label>
                                                        <div class="form-row text-center">
                                                            <div class="form-group col-6">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" id="rdoESF<?= $i ?>_SI" name="rdoATS_ESF<?= $i ?>" class="custom-control-input" value="SI">
                                                                    <label class="custom-control-label" for="rdoESF<?= $i ?>_SI">SI</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-6">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" id="rdoESF<?= $i ?>_NO" name="rdoATS_ESF<?= $i ?>" class="custom-control-input" value="NO">
                                                                    <label class="custom-control-label" for="rdoESF<?= $i ?>_NO">NO</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important"><?= $i += 1 ?></div>
                                                        <label>
                                                            ¿Se ha sentido usted alejado o distante de los demás?
                                                        </label>
                                                        <div class="form-row text-center">
                                                            <div class="form-group col-6">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" id="rdoESF<?= $i ?>_SI" name="rdoATS_ESF<?= $i ?>" class="custom-control-input" value="SI">
                                                                    <label class="custom-control-label" for="rdoESF<?= $i ?>_SI">SI</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-6">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" id="rdoESF<?= $i ?>_NO" name="rdoATS_ESF<?= $i ?>" class="custom-control-input" value="NO">
                                                                    <label class="custom-control-label" for="rdoESF<?= $i ?>_NO">NO</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important"><?= $i += 1 ?></div>
                                                        <label>
                                                            ¿Ha notado que tiene dificultad para expresar sus sentimientos?
                                                        </label>
                                                        <div class="form-row text-center">
                                                            <div class="form-group col-6">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" id="rdoESF<?= $i ?>_SI" name="rdoATS_ESF<?= $i ?>" class="custom-control-input" value="SI">
                                                                    <label class="custom-control-label" for="rdoESF<?= $i ?>_SI">SI</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-6">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" id="rdoESF<?= $i ?>_NO" name="rdoATS_ESF<?= $i ?>" class="custom-control-input" value="NO">
                                                                    <label class="custom-control-label" for="rdoESF<?= $i ?>_NO">NO</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important"><?= $i += 1 ?></div>
                                                        <label>
                                                            ¿Ha tenido la impresión de que su vida se va a acortar, que va a morir antes que otras personas o que tiene un futuro limitado?
                                                        </label>
                                                        <div class="form-row text-center">
                                                            <div class="form-group col-6">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" id="rdoESF<?= $i ?>_SI" name="rdoATS_ESF<?= $i ?>" class="custom-control-input" value="SI">
                                                                    <label class="custom-control-label" for="rdoESF<?= $i ?>_SI">SI</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-6">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" id="rdoESF<?= $i ?>_NO" name="rdoATS_ESF<?= $i ?>" class="custom-control-input" value="NO">
                                                                    <label class="custom-control-label" for="rdoESF<?= $i ?>_NO">NO</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                    </div>
                                                    <div class="mb-4" id="afectacionDiv">
                                                        <div class="header">
                                                            <h2><strong>IV.- AFECTACIÓN (DURANTE EL ÚLTIMO MES)</strong></h2>
                                                        </div>
                                                        <hr>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important"><?php echo $i = 1 ?></div>
                                                        <label>
                                                            ¿Ha tenido usted dificultades para dormir?
                                                        </label>
                                                        <div class="form-row text-center">
                                                            <div class="form-group col-6">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" id="rdoAFE<?= $i ?>_SI" name="rdoATS_AFE<?= $i ?>" class="custom-control-input" value="SI">
                                                                    <label class="custom-control-label" for="rdoAFE<?= $i ?>_SI">SI</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-6">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" id="rdoAFE<?= $i ?>_NO" name="rdoATS_AFE<?= $i ?>" class="custom-control-input" value="NO">
                                                                    <label class="custom-control-label" for="rdoAFE<?= $i ?>_NO">NO</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important"><?= $i += 1 ?></div>
                                                        <label>
                                                            ¿Ha estado particularmente irritable o le han dado arranques de coraje?
                                                        </label>
                                                        <div class="form-row text-center">
                                                            <div class="form-group col-6">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" id="rdoAFE<?= $i ?>_SI" name="rdoATS_AFE<?= $i ?>" class="custom-control-input" value="SI">
                                                                    <label class="custom-control-label" for="rdoAFE<?= $i ?>_SI">SI</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-6">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" id="rdoAFE<?= $i ?>_NO" name="rdoATS_AFE<?= $i ?>" class="custom-control-input" value="NO">
                                                                    <label class="custom-control-label" for="rdoAFE<?= $i ?>_NO">NO</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important"><?= $i += 1 ?></div>
                                                        <label>
                                                            ¿Ha tenido dificultad para concentrarse?
                                                        </label>
                                                        <div class="form-row text-center">
                                                            <div class="form-group col-6">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" id="rdoAFE<?= $i ?>_SI" name="rdoATS_AFE<?= $i ?>" class="custom-control-input" value="SI">
                                                                    <label class="custom-control-label" for="rdoAFE<?= $i ?>_SI">SI</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-6">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" id="rdoAFE<?= $i ?>_NO" name="rdoATS_AFE<?= $i ?>" class="custom-control-input" value="NO">
                                                                    <label class="custom-control-label" for="rdoAFE<?= $i ?>_NO">NO</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important"><?= $i += 1 ?></div>
                                                        <label>
                                                            ¿Ha estado nervioso o constantemente en alerta?
                                                        </label>
                                                        <div class="form-row text-center">
                                                            <div class="form-group col-6">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" id="rdoAFE<?= $i ?>_SI" name="rdoATS_AFE<?= $i ?>" class="custom-control-input" value="SI">
                                                                    <label class="custom-control-label" for="rdoAFE<?= $i ?>_SI">SI</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-6">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" id="rdoAFE<?= $i ?>_NO" name="rdoATS_AFE<?= $i ?>" class="custom-control-input" value="NO">
                                                                    <label class="custom-control-label" for="rdoAFE<?= $i ?>_NO">NO</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important"><?= $i += 1 ?></div>
                                                        <label>
                                                            ¿Se ha sobresaltado fácilmente por cualquier cosa?
                                                        </label>
                                                        <div class="form-row text-center">
                                                            <div class="form-group col-6">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" id="rdoAFE<?= $i ?>_SI" name="rdoATS_AFE<?= $i ?>" class="custom-control-input" value="SI">
                                                                    <label class="custom-control-label" for="rdoAFE<?= $i ?>_SI">SI</label>
                                                                </div>
                                                            </div>
                                                            <div class="form-group col-6">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" id="rdoAFE<?= $i ?>_NO" name="rdoATS_AFE<?= $i ?>" class="custom-control-input" value="NO">
                                                                    <label class="custom-control-label" for="rdoAFE<?= $i ?>_NO">NO</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                    </div>
                                                    <div class="col-md-12 text-right">
                                                        <br>
                                                        <button type="submit" class="btn btn-round btn-success"><b class="iconsminds-yes"></b> Guardar Evaluación</button> <br>
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
<?php } else {
        echo '
        <div class="content card">
            <div class="row card-body">
                <div class="col-md-4"></div>
                <div class="col-md-4" style="margin-top: 9%;margin-bottom: 9%">
                    <div class="text-center">
                        <div id="lottie-animation-no-disponible" style="width: 300px; height: 250px;"></div>
                        <h4 style="color: #001689">Esta evaluación ya fue realizada. </h4>
                    </div>
                </div>
            </div>
        </div>';
    }
} else {
    echo '
    <div class="content card">
        <div class="row card-body">
            <div class="col-md-4"></div>
            <div class="col-md-4" style="margin-top: 9%;margin-bottom: 9%">
                <div class="text-center">
                    <div id="lottie-animation-no-disponible" style="width: 300px; height: 250px;"></div>
                    <h4 style="color: #001689">Esta evaluación no esta disponible por el momento. </h4>
                </div>
            </div>
        </div>
    </div>';
} ?>
<script>
    $(document).ready(function(e) {
        lottie.loadAnimation({
            container: document.getElementById('lottie-animation'), // El contenedor donde se mostrará la animación
            renderer: 'svg', // Tipo de renderizado, puede ser "svg", "canvas" o "html"
            loop: true, // Si la animación debe reproducirse en bucle
            autoplay: true, // Si la animación debe empezar automáticamente
            path: "<?= base_url('/assets/images/evaluaciones/checklist.json') ?>", // Ruta del archivo JSON de la animación envuelta en comillas        
        });
        lottie.loadAnimation({
            container: document.getElementById('lottie-animation-no-disponible'), // El contenedor donde se mostrará la animación
            renderer: 'svg', // Tipo de renderizado, puede ser "svg", "canvas" o "html"
            loop: true, // Si la animación debe reproducirse en bucle
            autoplay: true, // Si la animación debe empezar automáticamente
            path: "<?= base_url('/assets/images/evaluaciones/no_disponible.json') ?>", // Ruta del archivo JSON de la animación envuelta en comillas        
        });
    });
</script>