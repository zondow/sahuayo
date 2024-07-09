<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
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

    .svg-computer {
        height: 300px;
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
                            <h1 class="text-dark text-center"><strong>Evaluación de Acontecimientos Traumáticos Severos</strong></h1>
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

                                                    <div class="text-right mt-2 mb-2">
                                                        <label style="font-size: 16px">Fecha: <?= longDate(date('Y-m-d'), ' de ') ?></label>
                                                    </div>
                                                    <div class="mb-4">
                                                        <h4 class="mt-3">I.- ACONTECIMIENTO TRAUMÁTICO SEVERO</h4>
                                                        <hr>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">1</div>
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
                                                        <h4 class="mt-3">II.- RECUERDOS PERSISTENTES SOBRE EL ACONTECIMIENTO (DURANTE EL ÚLTIMO MES)</h4>
                                                        <hr>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px"><?php echo $i = 1 ?></div>
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
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px"><?= $i += 1 ?></div>
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
                                                        <h4 class="mt-3">III.- ESFUERZO POR EVITAR CIRCUNSTANCIAS PARECIDAS O ASOCIADAS AL ACONTECIMIENTO (DURANTE EL ÚLTIMO MES)</h4>
                                                        <hr>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px"><?php echo $i = 1 ?></div>
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
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px"><?= $i += 1 ?></div>
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
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px"><?= $i += 1 ?></div>
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
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px"><?= $i += 1 ?></div>
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
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px"><?= $i += 1 ?></div>
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
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px"><?= $i += 1 ?></div>
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
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px"><?= $i += 1 ?></div>
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
                                                        <h4 class="mt-3">IV.- AFECTACIÓN (DURANTE EL ÚLTIMO MES)</h4>
                                                        <hr>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px"><?php echo $i = 1 ?></div>
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
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px"><?= $i += 1 ?></div>
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
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px"><?= $i += 1 ?></div>
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
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px"><?= $i += 1 ?></div>
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
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px"><?= $i += 1 ?></div>
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
                                                        <button type="submit" class="btn btn-success"><b class="iconsminds-yes"></b> Guardar Evaluación</button> <br>
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
        <div class="content card-box">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4" style="margin-top: 9%;margin-bottom: 9%">
                    <div class="text-center">
                        <svg id="Layer_1" class="svg-computer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 424.2 424.2">
                            <style>
                                .st0{fill:none;stroke:rgba(122,125,127,0.72);stroke-width:5;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;}
                            </style>
                            <g id="Layer_2">
                                <path class="st0" d="M339.7 289h-323c-2.8 0-5-2.2-5-5V55.5c0-2.8 2.2-5 5-5h323c2.8 0 5 2.2 5 5V284c0 2.7-2.2 5-5 5z"></path>
                                <path class="st0" d="M26.1 64.9h304.6v189.6H26.1zM137.9 288.5l-3.2 33.5h92.6l-4.4-33M56.1 332.6h244.5l24.3 41.1H34.5zM340.7 373.7s-.6-29.8 35.9-30.2c36.5-.4 35.9 30.2 35.9 30.2h-71.8z"></path>
                                <path class="st0" d="M114.2 82.8v153.3h147V82.8zM261.2 91.1h-147"></path>
                                <path class="st0" d="M124.5 105.7h61.8v38.7h-61.8zM196.6 170.2H249v51.7h-52.4zM196.6 105.7H249M196.6 118.6H249M196.6 131.5H249M196.6 144.4H249M124.5 157.3H249M124.5 170.2h62.2M124.5 183.2h62.2M124.5 196.1h62.2M124.5 209h62.2M124.5 221.9h62.2"></path>
                            </g>
                        </svg>
                        <h4 style="color: #001689">Esta evaluación ya fue realizada. </h4>
                    </div>
                </div>
            </div>
        </div>';
    }
} else {
    echo '
    <div class="content card-box">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4" style="margin-top: 9%;margin-bottom: 9%">
                <div class="text-center">
                    <svg id="Layer_1" class="svg-computer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 424.2 424.2">
                        <style>
                            .st0{fill:none;stroke:rgba(122,125,127,0.72);stroke-width:5;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;}
                        </style>
                        <g id="Layer_2">
                            <path class="st0" d="M339.7 289h-323c-2.8 0-5-2.2-5-5V55.5c0-2.8 2.2-5 5-5h323c2.8 0 5 2.2 5 5V284c0 2.7-2.2 5-5 5z"></path>
                            <path class="st0" d="M26.1 64.9h304.6v189.6H26.1zM137.9 288.5l-3.2 33.5h92.6l-4.4-33M56.1 332.6h244.5l24.3 41.1H34.5zM340.7 373.7s-.6-29.8 35.9-30.2c36.5-.4 35.9 30.2 35.9 30.2h-71.8z"></path>
                            <path class="st0" d="M114.2 82.8v153.3h147V82.8zM261.2 91.1h-147"></path>
                            <path class="st0" d="M124.5 105.7h61.8v38.7h-61.8zM196.6 170.2H249v51.7h-52.4zM196.6 105.7H249M196.6 118.6H249M196.6 131.5H249M196.6 144.4H249M124.5 157.3H249M124.5 170.2h62.2M124.5 183.2h62.2M124.5 196.1h62.2M124.5 209h62.2M124.5 221.9h62.2"></path>
                        </g>
                    </svg>
                    <h4 style="color: #001689">Esta evaluación no esta disponible por el momento. </h4>
                </div>
            </div>
        </div>
    </div>';
} ?>