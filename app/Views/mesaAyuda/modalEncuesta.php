<style>
    .respuestas {
        text-align: center;
        width: 20%;
    }

    .custom-control-label::after, .custom-control-label::before {
        top: -1px;
        left: -1px;
        width: 50px;
        height: 50px;
        border: none;
    }

    .custom-control-label::after {display: none;}

    .img-encuesta {
        vertical-align: middle;
        border-style: none;
        position: sticky;
    }

    .td-encuesta {
        padding-block: 10px;
    }
</style>

<!--------------- Modal encuesta ----------------->
<div id="modalEncuesta" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false" >
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Encuesta de satisfacción de servicio</h4>
            </div>
            <form action="<?=base_url('MesaAyuda/saveEncuesta')?>" id="formEncuesta" method="post" autocomplete="off" role="form">
                <input  id="ticketID" name="ticketID" hidden>
                <div class="modal-body">
                    <p> En la Federación Alianza nos importa tu opinión y queremos conocerla.Por favor,
                        dedique un poco de tiempo en responder esta encuesta. La cara triste a la izquierda
                        indica <b>"Muy insatisfecho"</b> y la cara sonriente a la derecha indica <b>"Muy satisfecho".</b>
                    </p>
                    <table style="width: 100%">
                        <tr>
                            <td colspan="5"><label> Oportunidad de respuesta</label></td>
                        </tr>
                        <tr>
                            <td class="respuestas td-encuesta">
                                <div class="custom-control custom-radio">
                                    Necesita Mejorar
                                    <br>
                                    <input type="radio" id="P1_1" name="P1" class="custom-control-input" value="necesitaMejorar" required>
                                    <label class="custom-control-label" for="P1_1"><img class="img-encuesta" src="<?= base_url('assets/images/icons8/icons8-sad.png') ?>"></label>
                                </div>
                            </td>
                            <td class="respuestas td-encuesta">
                                <div class="custom-control custom-radio">
                                    Regular
                                    <br>
                                    <input type="radio" id="P1_2" name="P1" class="custom-control-input" value="regular" required>
                                    <label class="custom-control-label" for="P1_2"><img class="img-encuesta" src="<?= base_url('assets/images/icons8/icons8-boring.png') ?>"></label>
                                </div>
                            </td>
                            <td class="respuestas td-encuesta" >
                                <div class="custom-control custom-radio">
                                    Bueno
                                    <br>
                                    <input type="radio" id="P1_3" name="P1" class="custom-control-input" value="bueno" required >
                                    <label class="custom-control-label" for="P1_3"><img class="img-encuesta" src="<?= base_url('assets/images/icons8/icons8-neutral.png') ?>"></label>
                                </div>
                            </td>
                            <td class="respuestas td-encuesta">
                                <div class="custom-control custom-radio">
                                    Muy bueno
                                    <br>
                                    <input type="radio" id="P1_4" name="P1" class="custom-control-input" value="muybueno" required >
                                    <label class="custom-control-label" for="P1_4"><img class="img-encuesta" src="<?= base_url('assets/images/icons8/icons8-happy.png') ?>"></label>
                                </div>
                            </td>
                            <td class="respuestas td-encuesta">
                                <div class="custom-control custom-radio">
                                    Excelente
                                    <br>
                                    <input type="radio" id="P1_5" name="P1" class="custom-control-input" value="excelente" required>
                                    <label class="custom-control-label" for="P1_5"><img class="img-encuesta" src="<?= base_url('assets/images/icons8/icons8-smiling.png') ?>"></label>
                                </div>
                            </td>
                        </tr>
                        <tr id="pregunta1">
                            <td colspan="5">
                                ¿Por que?
                                <textarea name="P1Comentario" id="P1Comentario" rows="1" style="width: 100%"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5"><label>Efectividad de la solución </label></td>
                        </tr>
                        <tr>
                            <td class="respuestas td-encuesta">
                                <div class="custom-control custom-radio">
                                    Necesita Mejorar
                                    <br>
                                    <input type="radio" id="P2_1" name="P2" class="custom-control-input" value="necesitaMejorar" required>
                                    <label class="custom-control-label" for="P2_1"><img class="img-encuesta" src="<?= base_url('assets/images/icons8/icons8-sad.png') ?>"></label>
                                </div>
                            </td>
                            <td class="respuestas td-encuesta">
                                <div class="custom-control custom-radio">
                                    Regular
                                    <br>
                                    <input type="radio" id="P2_2" name="P2" class="custom-control-input" value="regular" required>
                                    <label class="custom-control-label" for="P2_2"><img class="img-encuesta" src="<?= base_url('assets/images/icons8/icons8-boring.png') ?>"></label>
                                </div>
                            </td>
                            <td class="respuestas td-encuesta">
                                <div class="custom-control custom-radio">
                                    Bueno
                                    <br>
                                    <input type="radio" id="P2_3" name="P2" class="custom-control-input" value="bueno" required>
                                    <label class="custom-control-label" for="P2_3"><img class="img-encuesta" src="<?= base_url('assets/images/icons8/icons8-neutral.png') ?>"></label>
                                </div>
                            </td>
                            <td class="respuestas td-encuesta">
                                <div class="custom-control custom-radio">
                                    Muy bueno
                                    <br>
                                    <input type="radio" id="P2_4" name="P2" class="custom-control-input" value="muybueno" required>
                                    <label class="custom-control-label" for="P2_4"><img class="img-encuesta" src="<?= base_url('assets/images/icons8/icons8-happy.png') ?>"></label>
                                </div>
                            </td>
                            <td class="respuestas td-encuesta">
                                <div class="custom-control custom-radio">
                                    Excelente
                                    <br>
                                    <input type="radio" id="P2_5" name="P2" class="custom-control-input" value="excelente" required>
                                    <label class="custom-control-label" for="P2_5"><img class="img-encuesta" src="<?= base_url('assets/images/icons8/icons8-smiling.png') ?>"></label>
                                </div>
                            </td>
                        </tr>
                        <tr id="pregunta2">
                            <td colspan="5">
                                ¿Por que?
                                <textarea name="P2Comentario" id="P2Comentario" rows="1" style="width: 100%"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5"><label> Actitud de servicio </label></td>
                        </tr>
                        <tr>
                            <td class="respuestas td-encuesta">
                                <div class="custom-control custom-radio">
                                    Necesita Mejorar
                                    <br>
                                    <input type="radio" id="P3_1" name="P3" class="custom-control-input" value="necesitaMejorar" required>
                                    <label class="custom-control-label" for="P3_1"><img class="img-encuesta" src="<?= base_url('assets/images/icons8/icons8-sad.png') ?>"></label>
                                </div>
                            </td>
                            <td class="respuestas td-encuesta">
                                <div class="custom-control custom-radio">
                                    Regular
                                    <br>
                                    <input type="radio" id="P3_2" name="P3" class="custom-control-input" value="regular" required>
                                    <label class="custom-control-label" for="P3_2"><img class="img-encuesta" src="<?= base_url('assets/images/icons8/icons8-boring.png') ?>"></label>
                                </div>
                            </td>
                            <td class="respuestas td-encuesta">
                                <div class="custom-control custom-radio">
                                    Bueno
                                    <br>
                                    <input type="radio" id="P3_3" name="P3" class="custom-control-input" value="bueno" required>
                                    <label class="custom-control-label" for="P3_3"><img class="img-encuesta" src="<?= base_url('assets/images/icons8/icons8-neutral.png') ?>"></label>
                                </div>
                            </td>
                            <td class="respuestas td-encuesta">
                                <div class="custom-control custom-radio">
                                    Muy bueno
                                    <br>
                                    <input type="radio" id="P3_4" name="P3" class="custom-control-input" value="muybueno" required>
                                    <label class="custom-control-label" for="P3_4"><img class="img-encuesta" src="<?= base_url('assets/images/icons8/icons8-happy.png') ?>"></label>
                                </div>
                            </td>
                            <td class="respuestas td-encuesta">
                                <div class="custom-control custom-radio">
                                    Excelente
                                    <br>
                                    <input type="radio" id="P3_5" name="P3" class="custom-control-input" value="excelente" required>
                                    <label class="custom-control-label" for="P3_5"><img class="img-encuesta" src="<?= base_url('assets/images/icons8/icons8-smiling.png') ?>"></label>
                                </div>
                            </td>
                        </tr>
                        <tr id="pregunta3">
                            <td colspan="5">
                                ¿Por que?
                                <textarea name="P3Comentario" id="P3Comentario" rows="1" style="width: 100%"></textarea>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="5"><label> Comentarios o sugerencias:</label></td>
                        </tr>
                        <tr>
                            <td colspan="5"><textarea name="comentario" id="comentario" rows="2" style="width: 100%"></textarea></td>
                        </tr>
                    </table>
                </div>

                <div class="modal-footer">
                    <button  type="submit" class="btn btn-primary waves-effect waves-light veCliente">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
