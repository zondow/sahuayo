<?php defined('FCPATH') or exit('No direct script access allowed');
if (empty($evaluacion)) { ?>
    <div class="row">
        <div class="col-12 survey-app p-3">
            <div class="card">
                <div class="card-body">
                    <div class="m-4">
                        <br>
                        <h3 class="text-dark text-center"><strong class="text-info">ENCUESTA DE FACTORES DE RIESGO PSICOSOCIAL EN EL TRABAJO NOM-035-STPS-2018</strong></h3>
                        <br>
                        <div class="card-footer ">
                            <br />
                            <div class="header">
                                <h2><strong>Instrucciones y consideraciones:</strong></h2>
                            </div>
                            <br />
                            <div class="col-12">
                                <p>
                                    La presente encuesta es totalmente confidencial, puede estar seguro de que la información que se obtenga a partir de sus respuestas será usada de la manera más profesional y responsable posible. Para esta encuesta no existen respuestas correctas o incorrectas, conteste de la manera más honesta que le sea posible.
                                    A continuación, se presentan una serie de afirmaciones con las que usted puede o no estar de acuerdo. Para responder, debe indicar con una &nbsp;&nbsp;<span class="font-16" style="color: #eb5b2d">&#10007</span> &nbsp; la opción que le parece más correcta para cada afirmación.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content ">
                        <!-- TAB PRE-SCREENING -->
                        <div class="tab-pane show active" id="tabPrescreening">
                            <div class="row">
                                <div class="col-12 col-lg-12">
                                    <div class="m-4">
                                        <hr /><br />
                                        <div id="formPreScreening">
                                            <form class="needs-validation mb-5" role="form" action="<?= base_url("Evaluaciones/addGuia2") ?>" method="post" enctype="multipart/form-data" autocomplete="off" novalidate>
                                                <input type="hidden" id="fechaActual" name="fechaActual" value="<?= date('Y-m-d') ?>">
                                                <input type="hidden" id="evaluado" name="evaluado" value="<?= $evaluadoID ?>">
                                                <div class="text-right ">
                                                    <div class="header">
                                                        <h2><strong>Fecha: <?= longDate(date('Y-m-d'), ' de ') ?></strong></h2>
                                                    </div>
                                                </div>
                                                <div class="mb-4">
                                                    <label>
                                                        Por favor marca con una &nbsp;&nbsp;<span class="font-16" style="color: #eb5b2d">&#10007</span> &nbsp; el grado en que consideras que la compañía cumple de acuerdo a la siguiente escala de evaluación:
                                                    </label>
                                                    <!--INSTRUCCIONES-->
                                                    <table class="data-table data-table-scrollable responsive nowrap" style="width: 100%">
                                                        <thead style="display: none;">
                                                            <tr>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><span class="badge badge-light font-13"><b>S</b>&nbsp;&nbsp;&nbsp;Siempre</span></td>
                                                                <td><span class="badge badge-light font-13"><b>CS</b>&nbsp;&nbsp;&nbsp;Casi siempre</span></td>
                                                                <td><span class="badge badge-light font-13"><b>AV</b>&nbsp;&nbsp;&nbsp;Algunas veces</span></td>
                                                                <td><span class="badge badge-light font-13"><b>CN</b>&nbsp;&nbsp;&nbsp;Casi nunca</span></td>
                                                                <td><span class="badge badge-light font-13"><b>N</b>&nbsp;&nbsp;&nbsp;Nunca</span></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="mb-4">
                                                    <hr>
                                                    <div class="header">
                                                        <h2><strong>A) Para responder las preguntas siguientes considere las condiciones de su centro de trabajo, así como la cantidad y ritmo de trabajo.</strong></h2>
                                                    </div>
                                                    <div style="overflow: auto;">
                                                        <table id="tbl_A" class="data-table responsive nowrap table-bordered table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th width="55%"></th>
                                                                    <th width="6%">Siempre</th>
                                                                    <th width="10%">Casi siempre</th>
                                                                    <th width="10%">Algunas veces</th>
                                                                    <th width="10%">Casi nunca</th>
                                                                    <th width="6%">Nunca</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td><?= $i = 1 ?>) Mi trabajo me exige hacer mucho esfuerzo físico</td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly required>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) Me preocupa sufrir un accidente en mi trabajo</td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly required>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) Considero que las actividades que realizo son peligrosas</td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly required>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) Por la cantidad de trabajo que tengo debo quedarme tiempo adicional a mi turno</td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly required>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) Por la cantidad de trabajo que tengo debo trabajar sin parar </td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly required>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) Considero que es necesario mantener un ritmo de trabajo acelerado</td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly required>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) Mi trabajo exige que esté muy concentrado</td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly required>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) Mi trabajo requiere que memorice mucha información</td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly required>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) Mi trabajo exige que atienda varios asuntos al mismo tiempo</td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly required>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <br>
                                                </div>
                                                <div class="mb-4">
                                                    <hr>
                                                    <div class="header">
                                                        <h2><strong>B) Las preguntas siguientes están relacionadas con las actividades que realiza en su trabajo y las responsabilidades que tiene.</strong></h2>
                                                    </div>
                                                    <div style="overflow: auto;">
                                                        <table id="tbl_B" class="data-table responsive nowrap table-bordered table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th width="55%"></th>
                                                                    <th width="6%">Siempre</th>
                                                                    <th width="10%">Casi siempre</th>
                                                                    <th width="10%">Algunas veces</th>
                                                                    <th width="10%">Casi nunca</th>
                                                                    <th width="6%">Nunca</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) En mi trabajo soy responsable de cosas de mucho valor</td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly required>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) Respondo ante mi jefe por los resultados de toda mi área de trabajo</td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly required>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) En mi trabajo me dan órdenes contradictorias</td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly required>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) Considero que en mi trabajo me piden hacer cosas innecesarias</td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly required>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <br>
                                                </div>
                                                <div class="mb-4">
                                                    <hr>
                                                    <div class="header">
                                                        <h2><strong>C) Las preguntas siguientes están relacionadas con el tiempo destinado a su trabajo y sus responsabilidades familiares.</strong></h2>
                                                    </div>
                                                    <div style="overflow: auto;">
                                                        <table id="tbl_C" class="data-table responsive nowrap table-bordered table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th width="55%"></th>
                                                                    <th width="6%">Siempre</th>
                                                                    <th width="10%">Casi siempre</th>
                                                                    <th width="10%">Algunas veces</th>
                                                                    <th width="10%">Casi nunca</th>
                                                                    <th width="6%">Nunca</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) Trabajo horas extras más de tres veces a la semana</td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly required>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) Mi trabajo me exige laborar en días de descanso, festivos o fines de semana</td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly required>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) Considero que el tiempo en el trabajo es mucho y perjudica mis actividades familiares o personales</td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly required>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) Pienso en las actividades familiares o personales cuando estoy en mi trabajo</td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly required>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <br>
                                                </div>
                                                <div class="mb-4">
                                                    <hr>
                                                    <div class="header">
                                                        <h2><strong>D) Las preguntas siguientes están relacionadas con las decisiones que puede tomar en su trabajo.</strong></h2>
                                                    </div>
                                                    <div style="overflow: auto;">
                                                        <table id="tbl_D" class="data-table responsive nowrap table-bordered table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th width="55%"></th>
                                                                    <th width="6%">Siempre</th>
                                                                    <th width="10%">Casi siempre</th>
                                                                    <th width="10%">Algunas veces</th>
                                                                    <th width="10%">Casi nunca</th>
                                                                    <th width="6%">Nunca</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) Mi trabajo permite que desarrolle nuevas habilidades </td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly required>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) En mi trabajo puedo aspirar a un mejor puesto</td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly required>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) Durante mi jornada de trabajo puedo tomar pausas cuando las necesito</td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly required>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) Puedo decidir la velocidad a la que realizo mis actividades en mi trabajo</td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly required>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) Puedo cambiar el orden de las actividades que realizo en mi trabajo</td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly required>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <br>
                                                </div>
                                                <div class="mb-4">
                                                    <hr>
                                                    <div class="header">
                                                        <h2><strong>E) Las preguntas siguientes están relacionadas con la capacitación e información que recibe sobre su trabajo.</strong></h2>
                                                    </div>
                                                    <div style="overflow: auto;">
                                                        <table id="tbl_E" class="data-table responsive nowrap table-bordered table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th width="55%"></th>
                                                                    <th width="6%">Siempre</th>
                                                                    <th width="10%">Casi siempre</th>
                                                                    <th width="10%">Algunas veces</th>
                                                                    <th width="10%">Casi nunca</th>
                                                                    <th width="6%">Nunca</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) Me informan con claridad cuáles son mis funciones </td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly required>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) Me explican claramente los resultados que debo obtener en mi trabajo</td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly required>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) Me informan con quién puedo resolver problemas o asuntos de trabajo</td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly required>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) Me permiten asistir a capacitaciones relacionadas con mi trabajo</td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly required>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) Recibo capacitación útil para hacer mi trabajo</td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly required>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <br>
                                                </div>
                                                <div class="mb-4">
                                                    <hr>
                                                    <div class="header">
                                                        <h2><strong>F) Las preguntas siguientes se refieren a las relaciones con sus compañeros de trabajo y su jefe.</strong></h2>
                                                    </div>
                                                    <div style="overflow: auto;">
                                                        <table id="tbl_F" class="data-table responsive nowrap table-bordered table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th width="55%"></th>
                                                                    <th width="6%">Siempre</th>
                                                                    <th width="10%">Casi siempre</th>
                                                                    <th width="10%">Algunas veces</th>
                                                                    <th width="10%">Casi nunca</th>
                                                                    <th width="6%">Nunca</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) Mi jefe tiene en cuenta mis puntos de vista y opiniones </td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly required>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) Mi jefe ayuda a solucionar los problemas que se presentan en el trabajo</td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly required>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) Puedo confiar en mis compañeros de trabajo</td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly required>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) Cuando tenemos que realizar trabajo de equipo los compañeros colaboran</td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly required>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) Mis compañeros de trabajo me ayudan cuando tengo dificultades</td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly required>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) En mi trabajo puedo expresarme libremente sin interrupciones</td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly required>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) Recibo críticas constantes a mi persona y/o trabajo</td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly required>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) Recibo burlas, calumnias, difamaciones, humillaciones o ridiculizaciones</td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly required>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) Se ignora mi presencia o se me excluye de las reuniones de trabajo y en la toma de decisiones</td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly required>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) Se manipulan las situaciones de trabajo para hacerme parecer un mal trabajador</td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly required>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) Se ignoran mis éxitos laborales y se atribuyen a otros trabajadores</td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly required>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) Me bloquean o impiden las oportunidades que tengo para obtener ascenso o mejora en mi trabajo</td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly required>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) He presenciado actos de violencia en mi centro de trabajo</td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly required>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <br>
                                                </div>
                                                <div class="mb-4">
                                                    <hr>
                                                    <div class="header">
                                                        <h2><strong>G) Las preguntas siguientes están relacionadas con la atención a clientes y usuarios.</strong></h2>
                                                    </div>
                                                    <label>
                                                        En mi trabajo debo brindar servicio a clientes o usuarios:
                                                    </label>
                                                    <div class="form-row text-center">
                                                        <div class="form-group col-6">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="rdoClientes_SI" name="rdoClientes" class="custom-control-input" value="SI" required>
                                                                <label class="custom-control-label" for="rdoClientes_SI">SI</label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-6">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="rdoClientes_NO" name="rdoClientes" class="custom-control-input" value="NO" required>
                                                                <label class="custom-control-label" for="rdoClientes_NO">NO</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div style="overflow: auto;" id="tablaGDiv">
                                                        <table id="tbl_G" class="data-table responsive nowrap table-bordered table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th width="55%"></th>
                                                                    <th width="6%">Siempre</th>
                                                                    <th width="10%">Casi siempre</th>
                                                                    <th width="10%">Algunas veces</th>
                                                                    <th width="10%">Casi nunca</th>
                                                                    <th width="6%">Nunca</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                <tr>
                                                                    <td><?= $i += 1 ?>) Atiendo clientes o usuarios muy enojados</td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) Mi trabajo me exige atender personas muy necesitadas de ayuda o enfermas</td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) Para hacer mi trabajo debo demostrar sentimientos distintos a los míos</td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <br>
                                                </div>
                                                <div class="mb-4">
                                                    <hr>
                                                    <div class="header">
                                                        <h2><strong>H) Las siguientes preguntas están relacionadas con las actitudes de los trabajadores que supervisa.</strong></h2>
                                                    </div>
                                                    <label>
                                                        Soy jefe de otros trabajadores:
                                                    </label>
                                                    <div class="form-row text-center">
                                                        <div class="form-group col-6">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="rdoJefe_SI" name="rdoJefe" class="custom-control-input" value="SI" required>
                                                                <label class="custom-control-label" for="rdoJefe_SI">SI</label>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-6">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="rdoJefe_NO" name="rdoJefe" class="custom-control-input" value="NO" required>
                                                                <label class="custom-control-label" for="rdoJefe_NO">NO</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div style="overflow: auto;" id="tablaJDiv">
                                                        <table id="tbl_G" class="data-table responsive nowrap table-bordered table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th width="55%"></th>
                                                                    <th width="6%">Siempre</th>
                                                                    <th width="10%">Casi siempre</th>
                                                                    <th width="10%">Algunas veces</th>
                                                                    <th width="10%">Casi nunca</th>
                                                                    <th width="6%">Nunca</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>

                                                                <tr>
                                                                    <td><?= $i += 1 ?>) Comunican tarde los asuntos de trabajo</td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) Dificultan el logro de los resultados del trabajo</td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $i += 1 ?>) Ignoran las sugerencias para mejorar su trabajo</td>
                                                                    <td id="S_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="4"></td>
                                                                    <td id="CS_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="3"></td>
                                                                    <td id="AV_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="2"></td>
                                                                    <td id="CN_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="1"></td>
                                                                    <td id="N_<?= $i ?>" class="tdClick" data-row="<?= $i ?>" data-valor="0"></td>
                                                                    <input id="txtP<?= $i ?>" name="txtP<?= $i ?>" type="text" class="form-control txt-hidden" readonly>
                                                                </tr>
                                                            </tbody>
                                                        </table>
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
} ?>


<script>
    $(document).ready(function(e) {
        lottie.loadAnimation({
            container: document.getElementById('lottie-animation-no-disponible'), // El contenedor donde se mostrará la animación
            renderer: 'svg', // Tipo de renderizado, puede ser "svg", "canvas" o "html"
            loop: true, // Si la animación debe reproducirse en bucle
            autoplay: true, // Si la animación debe empezar automáticamente
            path: "<?= base_url('/assets/images/evaluaciones/no_disponible.json') ?>", // Ruta del archivo JSON de la animación envuelta en comillas        
        });

        $("#tablaGDiv").hide();
        $("#tablaJDiv").hide();

        $("#rdoClientes_SI").change(function(evt) {
            evt.preventDefault();
            $('#rdoClientes_SI:checked').val();
            <?php for ($i = 41; $i <= 43; $i++) { ?>
                $("#txtP<?= $i ?>").prop('required', true);
            <?php } ?>
            $("#tablaGDiv").show();
        });
        $("#rdoClientes_NO").change(function(evt) {
            evt.preventDefault();
            $('#rdoClientes_NO:checked').val();
            $("#tablaGDiv").hide();
            <?php for ($i = 41; $i <= 43; $i++) { ?>
                $("#txtP<?= $i ?>").prop('required', false);
            <?php } ?>
        });

        $("#rdoJefe_SI").change(function(evt) {
            evt.preventDefault();
            $('#rdoJefe_SI:checked').val();
            <?php for ($i = 44; $i <= 46; $i++) { ?>
                $("#txtP<?= $i ?>").prop('required', true);
            <?php } ?>
            $("#tablaJDiv").show();
        });
        $("#rdoJefe_NO").change(function(evt) {
            evt.preventDefault();
            $('#rdoJefe_NO:checked').val();
            $("#tablaJDiv").hide();
            <?php for ($i = 44; $i <= 46; $i++) { ?>
                $("#txtP<?= $i ?>").prop('required', false);
            <?php } ?>
        });

        //Cell click
        $(".tdClick").click(function(e) {
            var row = $(this).data("row");
            var valor = $(this).data("valor");
            clearRow(row);

            setInputValue(row, valor);
            $(this).html("&#10007");
        }); //Cell click

        //Guardar valor en input
        function setInputValue(row, value) {

            <?php for ($i = 1; $i <= 46; $i++) { ?>
                if (row === <?= $i ?>) {
                    $("#txtP<?= $i ?>").val(value);
                }
            <?php } ?>
        } //setInputValue

        //Limpiar row
        function clearRow(row) {
            $("#S_" + row).html('');
            $("#CS_" + row).html('');
            $("#AV_" + row).html('');
            $("#CN_" + row).html('');
            $("#N_" + row).html('');
        } //clearRow

    });
</script>