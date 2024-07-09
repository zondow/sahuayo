<style>
    .svg-computer {
        height: 300px;
    }
</style>
<div class="content card-box">

    <?php
    if (!empty($fechaEstatus)) {
        if ($permitir) {
            if ($competencias != null) {
    ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center">
                            <h3 class="">Evaluación de competencias</h3>
                            <h4 class=""><?= $puestoInfo['pue_Nombre'] ?></h4>
                            <p class="text-muted font-15">
                                A continuación encontrarás listadas las competencias correspondientes a tú puesto.<br> Lee
                                cada una de ellas cuidadosamente y después
                                califícate según creas que sea tu desempeño .
                            </p>
                        </div>
                    </div><!-- end col -->
                </div><!-- end row -->

                <form action="<?= base_url('Evaluaciones/saveEvaluacionCompetenciaEmpleado') ?>" method="post" autocomplete="off">
                    <input type="hidden" name="empleadoID" value="<?= $empleadoID ?>">
                    <input type="hidden" name="idPeriodo" value="<?= encryptDecrypt('encrypt', $fechaEstatus) ?>">
                    <div class="row">
                        <?php
                        $i = 1;
                        $x = 1;
                        foreach ($competencias as $competencia) {

                            $sql = "SELECT * FROM clavecompetencia WHERE cla_CompetenciaID=?";
                            $preguntas = db()->query($sql, array($competencia['com_CompetenciaID']))->getResultArray();

                        ?>
                            <div class="col-md-12">
                                <!-- Question/Answer -->
                                <h5 class="text-center"><?= $competencia['com_Nombre'] ?></h5>
                                <p class="text-muted text-justify font-15"><?= $competencia['com_Descripcion'] ?></p>
                                <input type="hidden" name="nivel<?= $x ?>" value="<?= $competencia['cmp_Nivel'] ?>">
                                <input type="text" hidden name="idcomp<?= $x ?>" value="<?= $competencia['com_CompetenciaID'] ?>">
                            </div>

                            <?php
                            foreach ($preguntas as $pregunta) { ?>

                                <div class="col-md-6">
                                    <div>
                                        <div class="question-q-box mt-1 float-left bg-secondary text-white rounded-circle text-center" style="background-color: #f8e018 !important"><?= $i ?></div>
                                        <div class="overflow-hidden pl-3">
                                            <p class=" text-justify"><?= $pregunta['cla_ClaveAccion'] ?></p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12 ">
                                            <input type="text" class="sliderbar" name="valor<?= $x ?>[]" required>
                                            <input type="text" hidden name="idclave" value="<?= $pregunta['cla_ClaveCompetenciaID'] ?>">
                                        </div>
                                    </div>
                                </div>
                            <?php
                                $i++;
                            } ?>
                        <?php $x++;
                        } ?>
                    </div><!-- end row -->
                    <input type="hidden" name="countComp" value="<?= count($competencias) ?>">
                    <input type="hidden" name="countClaves" value="<?= $i ?>">
                    <div class="col-md-12 ">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-success"><i class="fe-save"></i> Guardar</button>
                        </div>
                    </div>
                </form>

    <?php } else {
                echo '<div class="row">
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
                        <h4 style="color: #001689">Su perfil de puesto aun no está listo. </h4>
                    </div>
                </div>
                </div>';
            }
        } else {
            echo '<div class="row">
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
                </div>';
        }
    } else {
        echo '<div class="row">
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
            </div>';
    }
    ?>


</div>


<script>
    $(document).ready(function() {

        $(".sliderbar").ionRangeSlider({
            skin: "modern",
            grid: !0,
            min: 0,
            max: 100,
            from: 0,
            values: ["0", "10", "20", "30", "40", "50", "60", "70", "80", "90", "100"],
            postfix: " "
        });

    });
</script>