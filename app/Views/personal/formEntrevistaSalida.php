<?php defined("FCPATH") or die("No direct script access allowed.") ?>
<div class="mb-4 row">
    <div class="col-12">
        <div class="card">
            <div class="card-body m-2">
                <form role="form" action="<?= base_url("Personal/entrevistaSalida/" . $bajaID) ?>" method="post" autocomplete="off" novalidate>
                    <h4><b>ENTREVISTA DE SALIDA</b></h4>
                    <div class="form-row">
                        <div class="form-group col-md-9"></div>
                        <div class="form-group col-md-3">
                            <label for="txtFechaEntrevista">*Fecha de entrevista</label>
                            <input id="txtFechaEntrevista" name="txtFechaEntrevista" type="text" class="form-control datepicker" data-position="bottom" placeholder="Fecha de la entrevista" value="<?= date("Y-m-d") ?>" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-5">
                            <label>*Nombre</label>
                            <input type="text" class="form-control" placeholder="Nombre" value="<?php if (isset($datos['nombre'])) echo $datos['nombre']; ?>" readonly>
                            <input id="txtEmpleadoID" name="txtEmpleadoID" value="<?php if (isset($datos['empleadoID'])) echo $datos['empleadoID']; ?>" readonly hidden>
                        </div>
                        <div class="form-group col-md-3">
                            <label>*Departamento</label>
                            <input type="text" class="form-control" placeholder="Departamento" value="<?php if (isset($datos['departamento'])) echo $datos['departamento']; ?>" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label>*Último puesto desempeñado</label>
                            <input type="text" class="form-control" placeholder="Último puesto desempeñado" value="<?php if (isset($datos['puesto'])) echo $datos['puesto']; ?>" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label>*Fecha de ingreso</label>
                            <input type="text" class="form-control" placeholder="Fecha de ingreso" value="<?php if (isset($datos['fechaIngreso'])) echo $datos['fechaIngreso']; ?>" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">*Nombre del jefe inmediato</label>
                            <input id="" name="" type="text" class="form-control" placeholder="Nombre del jefe inmediato" value="<?php if (isset($datos['jefe'])) echo $datos['jefe']; ?>" readonly>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">*Puesto</label>
                            <input id="" name="" type="text" class="form-control" placeholder="Puesto" value="<?php if (isset($datos['puestoJefe'])) echo $datos['puestoJefe']; ?>" readonly>
                        </div>
                    </div>
                    <br>


                    <label class="mt-3">
                        <b>Por favor responder las siguientes preguntas, seleccionando la opción que se adecua a tu situación. </b>
                    </label>
                    <br>
                    <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">1</div>
                    <label>
                        ¿Cuál es el motivo de salida?
                    </label>
                    <div class="form-row">
                        <select id="ent_Pregunta1" class="select2" name="ent_Pregunta1[]" style="width: 100%" multiple="multiple" style="width: 100%">
                            <option value="Oferta de trabajo con mejor salario">Oferta de trabajo con mejor salario </option>
                            <option value="Oferta de trabajo con mejores prestaciones">Oferta de trabajo con mejores prestaciones</option>
                            <option value="Oferta de trabajo con mejor puesto">Oferta de trabajo con mejor puesto </option>
                            <option value="Condiciones laborales">Condiciones laborales</option>
                            <option value="Sueldo">Sueldo </option>
                            <option value="Horarios">Horarios</option>
                            <option value="Distancia">Distancia</option>
                            <option value="Prestaciones">Prestaciones</option>
                            <option value="Falta de Herramientas de trabajo">Falta de Herramientas de trabajo</option>
                            <option value="Ambiente laboral">Ambiente laboral</option>
                            <option value="Problemas con el jefe inmediato">Problemas con el jefe inmediato</option>
                            <option value="Situación personal">Situación personal</option>
                            <option value="Enfermedad">Enfermedad</option>
                            <option value="Problemas familiares">Problemas familiares</option>
                            <option value="Hijos">Hijos</option>
                            <option value="Despido">Despido</option>
                        </select>
                    </div>
                    <br>
                    <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">2</div>
                    <label>
                        ¿Cuánto tiempo llevas planeando tu salida?
                    </label>
                    <div class="form-row">
                        <select id="ent_Pregunta2" class="select2" name="ent_Pregunta2" style="width: 100%" style="width: 100%">
                            <option value="" hidden>Seleccione</option>
                            <option value="De 1 día a 1 semana">De 1 día a 1 semana</option>
                            <option value="De 1 a 2 semanas">De 1 a 2 semanas</option>
                            <option value="De 3 semanas a 1 mes">De 3 semanas a 1 mes</option>
                        </select>
                    </div>
                    <br>
                    <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">3</div>
                    <label>
                        ¿Cómo consideras el ambiente laboral dentro de la empresa?
                    </label>
                    <div class="form-row ">
                        <div class="col-md-6">
                            <label for="ent_Pregunta3_1" class="col-form-label">Con tus compañeros de trabajo </label>
                            <select id="ent_Pregunta3_1" class="select2" name="ent_Pregunta3_1" style="width: 100%" style="width: 100%">
                                <option value="" hidden>Seleccione</option>
                                <option value="Bueno">Bueno</option>
                                <option value="Regular">Regular</option>
                                <option value="Malo">Malo</option>
                            </select>
                        </div>
                        <div class=" col-md-6">
                            <label for="ent_Pregunta3_2" class="col-form-label">Con tu jefe directo</label>
                            <select id="ent_Pregunta3_2" class="select2" name="ent_Pregunta3_2" style="width: 100%" style="width: 100%">
                                <option value="" hidden>Seleccione</option>
                                <option value="Bueno">Bueno</option>
                                <option value="Regular">Regular</option>
                                <option value="Malo">Malo</option>
                            </select>
                        </div>
                        <label for="ent_ComentariosP3" class="col-form-label">Comentarios</label>
                        <textarea class="form-control" rows="2" id="ent_ComentariosP3" name="ent_ComentariosP3"></textarea>
                    </div>
                    <br>

                    <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">4</div>
                    <label>
                        ¿Qué tan realistas fueron las expectativas establecidas para usted?
                    </label>
                    <div class="form-row">
                        <select id="ent_Pregunta4" class="select2" name="ent_Pregunta4" style="width: 100%" style="width: 100%">
                            <option value="" hidden>Seleccione</option>
                            <option value="Bueno">Bueno</option>
                            <option value="Regular">Regular</option>
                            <option value="Malo">Malo</option>
                        </select>
                    </div>
                    <br>

                    <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">5</div>
                    <label>
                        En general ¿Qué tan equitativo fue el trato que recibió?
                    </label>
                    <div class="form-row">
                        <select id="ent_Pregunta5" class="select2" name="ent_Pregunta5" style="width: 100%" style="width: 100%">
                            <option value="" hidden>Seleccione</option>
                            <option value="Bueno">Bueno</option>
                            <option value="Regular">Regular</option>
                            <option value="Malo">Malo</option>
                        </select>
                    </div>
                    <br>

                    <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">6</div>
                    <label>
                        ¿Con que frecuencia sintió que sus aportaciones fueron reconocidas?
                    </label>
                    <div class="form-row">
                        <select id="ent_Pregunta6" class="select2" name="ent_Pregunta6" style="width: 100%" style="width: 100%">
                            <option value="" hidden>Seleccione</option>
                            <option value="Siempre">Siempre </option>
                            <option value="La mayor parte del tiempo">La mayor parte del tiempo</option>
                            <option value="De vez en cuando">De vez en cuando</option>
                            <option value="Nunca">Nunca</option>
                        </select>
                    </div>
                    <br>

                    <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">7</div>
                    <label>
                        En una semana típica ¿Con que frecuencia se sintió estresado /a en el Trabajo?
                    </label>
                    <div class="form-row">
                        <select id="ent_Pregunta7" class="select2" name="ent_Pregunta7" style="width: 100%" style="width: 100%">
                            <option value="" hidden>Seleccione</option>
                            <option value="Con extremada frecuencia">Con extremada frecuencia </option>
                            <option value="Con mucha frecuencia">Con mucha frecuencia</option>
                            <option value="No con tanta Frecuencia">No con tanta Frecuencia</option>
                            <option value="Con ninguna frecuencia">Con ninguna frecuencia</option>
                        </select>
                    </div>
                    <br>

                    <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">8</div>
                    <label>
                        En general ¿Cuánto le gusto trabajar en Caja Alianza?
                    </label>
                    <div class="form-row">
                        <select id="ent_Pregunta8" class="select2" name="ent_Pregunta8" style="width: 100%" style="width: 100%">
                            <option value="" hidden>Seleccione</option>
                            <option value="Muchísimo">Muchísimo</option>
                            <option value="Mucho">Mucho</option>
                            <option value="Moderadamente">Moderadamente</option>
                            <option value="Un poco">Un poco</option>
                        </select>
                    </div>
                    <br>

                    <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">9</div>
                    <label>
                        ¿Qué tan difícil fue para usted equilibrar su vida laboral y su vida personal mientras trabajo en Caja Alianza?
                    </label>
                    <div class="form-row">
                        <select id="ent_Pregunta9" class="select2" name="ent_Pregunta9" style="width: 100%" style="width: 100%">
                            <option value="" hidden>Seleccione</option>
                            <option value="Extremadamente difícil">Extremadamente difícil</option>
                            <option value="Muy difícil">Muy difícil</option>
                            <option value="Algo difícil">Algo difícil</option>
                            <option value="Nada difícil">Nada difícil</option>
                        </select>
                    </div>
                    <br>


                    <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">10</div>
                    <label>
                        Si pudieras mejorar algo dentro de Caja Alianza, ¿Qué sería?
                    </label>
                    <div class="form-row">
                        <textarea class="form-control" rows="2" id="ent_Pregunta10" name="ent_Pregunta10"></textarea>
                    </div>
                    <br>

                    <div class="form-row mt-3 text-center">
                        <div class="form-group col-md-12">
                            <button id="btnGuardarEntrevistaSalida" type="submit" id="" class="mb-2 btn btn-success btn-round">
                                <span class="label">Guardar</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: 'Seleccione una opción',
            allowClear: true,
            width: 'resolve'
        });
    });
</script>