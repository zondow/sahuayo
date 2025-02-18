<?php defined('FCPATH') or exit('No direct script access allowed');

$tipoPregunta = [
    'seleccion'     => ['inicio' => '<select class="form-control select2" style="width: 100%;"', 'fin' => '</select>'],
    'multiple'      => ['inicio' => '<select class="form-control select2" multiple style="width: 100%;"', 'fin' => '</select>'],
    'abierta'       => ['inicio' => '<input type="text" class="form-control"', 'fin' => ''],
    'rango'         => ['inicio' => '<input type="text" class="sliderbar"', 'fin' => ''],
    'satisfaccion'  => ['inicio' => '<select class="rating" data-current-rating="-1"', 'fin' => '</select>']
];

$preguntaSelect = ['seleccion', 'multiple', 'rango', 'satisfaccion'];
$i = 1;
?>

<style>
    .br-wrapper {
        margin-left: 40px !important;
    }
    .br-widget a {
        position: relative;
    }
    .br-widget a:hover::after {
        content: attr(data-rating-text);
        position: absolute;
        top: -30px;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(0, 0, 0, 0.7);
        color: #fff;
        padding: 5px 8px;
        border-radius: 5px;
        font-size: 12px;
        white-space: nowrap;
        z-index: 10;
    }
    .rating-container {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        margin-top: 10px;
    }
</style>

<div class="container-fluid">
    <form action="<?= base_url('Evaluaciones/saveEvaluacion') ?>" method="post">
        <input type="hidden" name="evaluadoID" value="<?= encrypt($evaluadoID)?>">
        <input type="hidden" name="plantillaID" value="<?= encrypt($plantillaID)?>">
        <input type="hidden" name="cuestionarioID" value="<?= encrypt($plantillaID)?>">
        <div class="row">
            <?php foreach ($preguntas as $pregunta) : ?>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center">
                            <div class="form-group">
                                <div class="question-q-box mt-0 float-left text-white rounded-circle text-center" 
                                    style="margin-right: 10px; width: 2%; background-color: <?= $pregunta['pre_Obligatoria'] ? '#ec3b57' : '#f4e231' ?> !important">
                                    <?= $i ?>
                                </div>
                                <p><strong><?= $pregunta['pre_Obligatoria'] ? '*' : '' ?> <?= $pregunta['gru_Titulo'] ?> - </strong><?= $pregunta['pre_Texto'] ?></p>

                                <?php if ($pregunta['pre_TipoRespuesta'] == 'satisfaccion') : ?>
                                    <div class="rating-container">
                                <?php endif; ?>

                                <?= $tipoPregunta[$pregunta['pre_TipoRespuesta']]['inicio'] ?>
                                    name="<?= $pregunta['pre_PreguntaID'] . ($pregunta['pre_TipoRespuesta'] == 'multiple' ? '[]' : '') ?>"
                                    id="<?= $pregunta['pre_PreguntaID'] ?>"
                                    <?= $pregunta['pre_Obligatoria'] ? 'required' : '' ?>
                                >

                                <?php if (in_array($pregunta['pre_TipoRespuesta'], $preguntaSelect)) : ?>
                                    <?php foreach ($pregunta['respuestas'] as $respuesta) : ?>
                                        <option value="<?= $respuesta['res_RespuestaID'] ?>">
                                            <?= htmlspecialchars($respuesta['res_Texto']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                                <?= $tipoPregunta[$pregunta['pre_TipoRespuesta']]['fin'] ?>

                                <?php if ($pregunta['pre_TipoRespuesta'] == 'satisfaccion') : ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php $i++; endforeach; ?>

            <div class="form-group col-md-12 text-center">
                <button type="submit" class="btn btn-success btn-round mb-2">
                    <i class="fe-save"></i> Enviar
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: 'Seleccione una opción',
            allowClear: true,
            width: 'resolve'
        });

        $(".sliderbar").ionRangeSlider({
            skin: "modern",
            grid: true,
            min: 0,
            max: 100,
            from: 0,
            values: ["0", "10", "20", "30", "40", "50", "60", "70", "80", "90", "100"],
            postfix: " %"
        });

        $(".rating").each(function() {
            $(this).barrating({
                theme: "bars-movie",
                initialRating: $(this).data("currentRating"),
                readonly: $(this).data("readonly")
            });
        });
    });
</script>
