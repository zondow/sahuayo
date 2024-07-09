<style>
    .svg-computer {
        height: 300px;
    }
</style>
<div class="content card-box">

    <?php
    if (!is_null($periodo)) {
        if ($permitir) {
            if (!is_null($funciones)) {
    ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center">
                            <h3 class="">Evaluación de desempeño 270°</h3>
                            <div class="m-3">
                                <div class="thumb-lg member-thumb mx-auto">
                                    <img src="<?= fotoPerfil(encryptDecrypt('encrypt', $empleadoInfo['emp_EmpleadoID'])) ?>" class="rounded-circle avatar-xl img-thumbnail" alt="profile-image">
                                </div>
                                <div>
                                    <h4 class="nombre"><?= $empleadoInfo['emp_Nombre'] ?></h4>
                                </div>
                            </div>

                            <h4 class=""><?= $puestoInfo['pue_Nombre'] ?></h4>
                            <p class="text-muted font-15">
                                A continuación encontrarás listadas las funciones correspondientes a tú puesto.<br> Lee cada una de ellas cuidadosamente y después
                                califícate según creas que sea tu desempeño realizando esa función.<br> Las calificaciones son en porcentajes y estos van de 0 a 100 en
                                intervalos de diez en diez.
                            </p>
                        </div>
                    </div><!-- end col -->
                </div><!-- end row -->

                <form action="<?= base_url('Evaluaciones/saveRespuestasDesempeno270') ?>" method="post" autocomplete="off">
                    <input type="hidden" name="empleadoID" value="<?= $empleadoID ?>">
                    <input type="hidden" name="evaluadorID" value="<?= $evaluadorID ?>">
                    <input type="hidden" name="periodoID" value="<?= $periodo['eva_EvaluacionID'] ?>">
                    <div class="row col-md-12 pt-3">
                        <?php
                        $i = 0;
                        foreach ($funciones as $key => $value) {
                            $clase = '';
                            if (!($i % 2)) $clase = ' offset-lg-1 ';
                        ?>
                            <input type="hidden" name="Q<?= $key ?>" value="<?= $value ?>">
                            <div class="col-md-5 pb-5 <?= $clase ?>">
                                <!-- Question/Answer -->
                                <div>
                                    <div class="question-q-box mt-1 float-left bg-secondary text-white rounded-circle text-center" style="background-color: #f8e018 !important"><?= $i + 1 ?></div>
                                    <div class="overflow-hidden pl-3">
                                        <p class=" text-justify"><?= $value ?></p>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-11 offset-md-1">
                                        <input type="text" class="sliderbar" id="<?= $key ?>" name="<?= $key ?>" required>
                                    </div>
                                </div>
                            </div>

                        <?php
                            $i++;
                        } ?>

                    </div><!-- end row -->
                    <div class="row">
                        <div class="col-md-12 pl-5 pr-5 pb-5">
                            <div class="form-group">
                                <label for="observaciones">Observaciones: </label>
                                <textarea class="form-control" rows="5" id="observaciones" name="observaciones"></textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="QFcount" value="<?= $i ?>">
                    <div class="row pb-3">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-success"><i class="fe-save"></i> Guardar evaluación</button>
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
                            <h4  style="color: #001689">Su perfil de puesto aun no está listo. </h4>
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
            postfix: " %"
        });

    });
</script>