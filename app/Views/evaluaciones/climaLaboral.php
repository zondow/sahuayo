<style>
    .svg-computer {
        height: 300px;
    }

    .br-wrapper {
        margin-left: 40px,  !important;
    }
</style>
<?php
if ($permitir) {
    if ($fechaEstatus > 0) {
?>
        <div class="row">
            <div class=" container-fluid ">
                <div class="row card-body">
                    <div class="survey-app ">
                        <div class="row">
                            <div class="col-lg-4  mb-2">
                                <div class="card mb-2">
                                    <div class="card-body">
                                        <h4 class=" text-center mb-2">Instrucciones</h4>
                                        <p class="text-justify">
                                            Esta evaluación tiene como objetivo evaluar el grado de satisfacción laboral o comodidad de los colaboradores con la caja. Esta ofrece una imagen de la percepción de los trabajadores sobre las cuestiones que se muestran continuación.<br>Contesta honestamente las preguntas y dejanos tus sugerencias o comentarios, los atenderemos con gusto.
                                        </p>
                                        <div class="row">
                                            <svg id="Layer_1" class="svg-computer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 424.2 424.2">
                                                <style>
                                                    .st0 {
                                                        fill: none;
                                                        stroke: rgba(122, 125, 127, 0.72);
                                                        stroke-width: 5;
                                                        stroke-linecap: round;
                                                        stroke-linejoin: round;
                                                        stroke-miterlimit: 10;
                                                    }
                                                </style>
                                                <g id="Layer_2">
                                                    <path class="st0" d="M339.7 289h-323c-2.8 0-5-2.2-5-5V55.5c0-2.8 2.2-5 5-5h323c2.8 0 5 2.2 5 5V284c0 2.7-2.2 5-5 5z"></path>
                                                    <path class="st0" d="M26.1 64.9h304.6v189.6H26.1zM137.9 288.5l-3.2 33.5h92.6l-4.4-33M56.1 332.6h244.5l24.3 41.1H34.5zM340.7 373.7s-.6-29.8 35.9-30.2c36.5-.4 35.9 30.2 35.9 30.2h-71.8z"></path>
                                                    <path class="st0" d="M114.2 82.8v153.3h147V82.8zM261.2 91.1h-147"></path>
                                                    <path class="st0" d="M124.5 105.7h61.8v38.7h-61.8zM196.6 170.2H249v51.7h-52.4zM196.6 105.7H249M196.6 118.6H249M196.6 131.5H249M196.6 144.4H249M124.5 157.3H249M124.5 170.2h62.2M124.5 183.2h62.2M124.5 196.1h62.2M124.5 209h62.2M124.5 221.9h62.2"></path>
                                                </g>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-8">
                                <form action="<?= base_url("Evaluaciones/saveEvaluacionClimaLaboral") ?>" method="post">
                                    <div class="sortable-survey">
                                        <div>
                                            <input type="hidden" name="empleadoID" value="<?= $empleadoID ?>">
                                            <!--AMBIENTE FISICO-->
                                            <div class="card question d-flex mb-2 ">
                                                <div class="d-flex flex-grow-1 min-width-zero">
                                                    <div class="card-body align-self-center d-flex flex-column flex-md-row justify-content-between min-width-zero align-items-md-center">
                                                        <p class="list-item-heading mb-0 ">
                                                            <label class="text-dark">AMBIENTE FISICO</label>
                                                        </p>
                                                    </div>
                                                    <div class="custom-control custom-checkbox pl-1 align-self-center pr-4">
                                                        <button class="btn btn-primary icon-button btn-rounded btn-sm rotate-icon-click rotate" type="button" data-toggle="collapse" data-target="#qAmbienteFisico" aria-expanded="true" aria-controls="qAmbienteFisico">
                                                            <i class="fe-chevron-down with-rotate-icon"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="question-collapse collapse " id="qAmbienteFisico">
                                                    <div class="card-body pt-0">
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">1</div>
                                                        <p> ¿El espacio para desarrollar mi trabajo es el adecuado?</p>
                                                        <select name="AF1" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">2</div>
                                                        <p> ¿Hay una adecuada ventilación e iluminación en mi área de trabajo?</p>
                                                        <select name="AF2" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">3</div>
                                                        <p> ¿El mobiliario, herramientas y equipo de trabajo son los adecuados y funcionales para realizar mi trabajo?</p>
                                                        <select name="AF3" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">4</div>
                                                        <p> ¿La Caja me capacita para prevenir accidentes?</p>
                                                        <select name="AF4" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--FORMACION Y CAPACITACION-->
                                            <div class="card question d-flex mb-2 ">
                                                <div class="d-flex flex-grow-1 min-width-zero">
                                                    <div class="card-body align-self-center d-flex flex-column flex-md-row justify-content-between min-width-zero align-items-md-center">
                                                        <p class="list-item-heading mb-0 ">
                                                            <label class="text-dark">FORMACIÓN Y CAPACITACIÓN</label>
                                                        </p>
                                                    </div>
                                                    <div class="custom-control custom-checkbox pl-1 align-self-center pr-4">
                                                        <button class="btn btn-primary icon-button btn-rounded btn-sm rotate-icon-click rotate" type="button" data-toggle="collapse" data-target="#qFormacionCapacitacion" aria-expanded="true" aria-controls="qFormacionCapacitacion">
                                                            <i class="fe-chevron-down with-rotate-icon"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="question-collapse collapse " id="qFormacionCapacitacion">
                                                    <div class="card-body pt-0">
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">5</div>
                                                        <p> ¿Conozco la capacitación que se me proporcionará en el transcurso del año?</p>
                                                        <select name="FC1" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">6</div>
                                                        <p>¿La Caja me da facilidades para capacitarme?</p>
                                                        <select name="FC2" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">7</div>
                                                        <p> ¿Recibo capacitación para actualizar los conocimientos de mi trabajo?</p>
                                                        <select name="FC3" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">8</div>
                                                        <p> ¿Creo que tengo la oportunidad de desarrollarme profesionalmente en la organización?</p>
                                                        <select name="FC4" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">9</div>
                                                        <p> ¿Conozco claramente cuáles son mis funciones y responsabilidades?</p>
                                                        <select name="FC5" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">10</div>
                                                        <p> ¿Cuando necesito información se donde consultarla?</p>
                                                        <select name="FC6" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">11</div>
                                                        <p> ¿Conozco las políticas y la forma de trabajo de mi departamento?</p>
                                                        <select name="FC7" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--lIDERAZGO-->
                                            <div class="card question d-flex mb-2 ">
                                                <div class="d-flex flex-grow-1 min-width-zero">
                                                    <div class="card-body align-self-center d-flex flex-column flex-md-row justify-content-between min-width-zero align-items-md-center">
                                                        <p class="list-item-heading mb-0 ">
                                                            <label class="text-dark">LIDERAZGO</label>
                                                        </p>
                                                    </div>
                                                    <div class="custom-control custom-checkbox pl-1 align-self-center pr-4">
                                                        <button class="btn btn-primary icon-button btn-rounded btn-sm rotate-icon-click rotate" type="button" data-toggle="collapse" data-target="#qLiderazgo" aria-expanded="true" aria-controls="qLiderazgo">
                                                            <i class="fe-chevron-down with-rotate-icon"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="question-collapse collapse " id="qLiderazgo">
                                                    <div class="card-body pt-0">
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">12</div>
                                                        <p> ¿Mi jefe valora mis ideas, opiniones, sugerencias y las toma en cuenta?</p>
                                                        <select name="LI1" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">13</div>
                                                        <p> ¿La orientación que me da mi jefe me ayuda a realizar mejor mi trabajo?</p>
                                                        <select name="LI2" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">14</div>
                                                        <p> ¿Mi jefe tiene platicas conmigo para comentarme sobre mis áreas de oportunidad con el fin de mejorar?</p>
                                                        <select name="LI3" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">15</div>
                                                        <p> ¿Mi jefe demuestra un dominio y conocimiento de sus funciones?</p>
                                                        <select name="LI4" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">16</div>
                                                        <p> ¿Mi jefe es coherente con lo que dice y hace?</p>
                                                        <select name="LI5" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">17</div>
                                                        <p> ¿Mi jefe se preocupa por mi bienestar y las necesidades que tengo?</p>
                                                        <select name="LI6" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">18</div>
                                                        <p> ¿Mi jefe tiene disposicion cuando lo requiero?</p>
                                                        <select name="LI7" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">19</div>
                                                        <p> ¿Mi jefe se preocupa por mantener un buen clima en el equipo?</p>
                                                        <select name="LI8" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">20</div>
                                                        <p> ¿Mi jefe me felicita o reconoce cuando realizo bien mi trabajo?</p>
                                                        <select name="LI9" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">21</div>
                                                        <p> ¿En mi departamento o sucursal se da un trato justo y equitativo a todos los empleados?</p>
                                                        <select name="LI10" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">22</div>
                                                        <p> ¿Mi jefe es claro y específico al definir los objetivos del trabajo o del departamento?</p>
                                                        <select name="LI11" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--RELACIONES EN EL TRABAJO-->
                                            <div class="card question d-flex mb-2 ">
                                                <div class="d-flex flex-grow-1 min-width-zero">
                                                    <div class="card-body align-self-center d-flex flex-column flex-md-row justify-content-between min-width-zero align-items-md-center">
                                                        <p class="list-item-heading mb-0 ">
                                                            <label class="text-dark">RELACIONES EN EL TRABAJO</label>
                                                        </p>
                                                    </div>
                                                    <div class="custom-control custom-checkbox pl-1 align-self-center pr-4">
                                                        <button class="btn btn-primary icon-button btn-rounded btn-sm rotate-icon-click rotate" type="button" data-toggle="collapse" data-target="#qRelacionesT" aria-expanded="true" aria-controls="qRelacionesT">
                                                            <i class="fe-chevron-down with-rotate-icon"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="question-collapse collapse " id="qRelacionesT">
                                                    <div class="card-body pt-0">
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">23</div>
                                                        <p> ¿Puedo confiar en mis compañeros de trabajo?</p>
                                                        <select name="RT1" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">24</div>
                                                        <p> ¿En mi departamento o sucursal se fomenta el compañerismo y la unión entre los colaboradores?</p>
                                                        <select name="RT2" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">25</div>
                                                        <p> ¿La relación con mi jefe es cordial y respetuosa?</p>
                                                        <select name="RT3" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">26</div>
                                                        <p> ¿Recibo buen trato por parte de mis compañeros de la caja?</p>
                                                        <select name="RT4" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">27</div>
                                                        <p> ¿Tengo la confianza de acercarme a mi jefe directo para preguntar sobre algo que no tengo claro?</p>
                                                        <select name="RT5" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">28</div>
                                                        <p> ¿Recibo apoyo por parte de mis compañeros de trabajo si enfrento problemas para desarrollar mi trabajo?</p>
                                                        <select name="RT6" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">29</div>
                                                        <p> ¿Considero que existe un buen ambiente de trabajo?</p>
                                                        <select name="RT7" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">30</div>
                                                        <p> ¿Las personas con las que me relaciono en la organización actúan con respeto y de manera ética?</p>
                                                        <select name="RT8" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">31</div>
                                                        <p> ¿Me siento parte de mi equipo de trabajo?</p>
                                                        <select name="RT9" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">32</div>
                                                        <p> ¿Cuando hay mucho trabajo nos apoyamos en las actividades para terminarlas a tiempo?</p>
                                                        <select name="RT10" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--SENTIDO DE PERTENENCIA-->
                                            <div class="card question d-flex mb-2 ">
                                                <div class="d-flex flex-grow-1 min-width-zero">
                                                    <div class="card-body align-self-center d-flex flex-column flex-md-row justify-content-between min-width-zero align-items-md-center">
                                                        <p class="list-item-heading mb-0 ">
                                                            <label class="text-dark">SENTIDO DE PERTENENCIA</label>
                                                        </p>
                                                    </div>
                                                    <div class="custom-control custom-checkbox pl-1 align-self-center pr-4">
                                                        <button class="btn btn-primary icon-button btn-rounded btn-sm rotate-icon-click rotate" type="button" data-toggle="collapse" data-target="#qPertenencia" aria-expanded="true" aria-controls="qPertenencia">
                                                            <i class="fe-chevron-down with-rotate-icon"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="question-collapse collapse " id="qPertenencia">
                                                    <div class="card-body pt-0">
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">33</div>
                                                        <p> ¿Conozco cuál es el objetivo de la Caja y trabajo con base a ello para poder lograrlo?</p>
                                                        <select name="PE1" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">34</div>
                                                        <p> ¿Me involucro en las actividades de la Caja?</p>
                                                        <select name="PE2" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">35</div>
                                                        <p> ¿Me identifico con la misión, la vision y los valores de la Caja?</p>
                                                        <select name="PE3" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">36</div>
                                                        <p> ¿En mi departamento o sucursal se actúa conforme a los valores de la Caja?</p>
                                                        <select name="PE4" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">37</div>
                                                        <p> ¿Me siento comprometido(a) con mi trabajo para lograr el objetivo de la Caja?</p>
                                                        <select name="PE5" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">38</div>
                                                        <p> ¿Pienso que la organización es un buen lugar para trabajar y me gustaría continuar trabajando aquí?</p>
                                                        <select name="PE6" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">39</div>
                                                        <p> ¿Me siento orgulloso(a) de trabajar para la organización?</p>
                                                        <select name="PE7" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--SATISFACCION LABORAL-->
                                            <div class="card question d-flex mb-2 ">
                                                <div class="d-flex flex-grow-1 min-width-zero">
                                                    <div class="card-body align-self-center d-flex flex-column flex-md-row justify-content-between min-width-zero align-items-md-center">
                                                        <p class="list-item-heading mb-0 ">
                                                            <label class="text-dark">SATISFACCIÓN LABORAL</label>
                                                        </p>
                                                    </div>
                                                    <div class="custom-control custom-checkbox pl-1 align-self-center pr-4">
                                                        <button class="btn btn-primary icon-button btn-rounded btn-sm rotate-icon-click rotate" type="button" data-toggle="collapse" data-target="#qSatisfaccion" aria-expanded="true" aria-controls="qSatisfaccion">
                                                            <i class="fe-chevron-down with-rotate-icon"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="question-collapse collapse " id="qSatisfaccion">
                                                    <div class="card-body pt-0">
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">40</div>
                                                        <p> ¿Estoy satisfecho(a) con el desempeño de mi trabajo?</p>
                                                        <select name="SL1" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">41</div>
                                                        <p> ¿Estoy satisfecho(a) con el puesto que tengo actualmente?</p>
                                                        <select name="SL2" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">42</div>
                                                        <p> ¿Es interesante el trabajo que desempeño en la Caja?</p>
                                                        <select name="SL3" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">43</div>
                                                        <p> ¿Mi trabajo me ofrece retos y la oportunidad de seguir mejorando?</p>
                                                        <select name="SL4" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">44</div>
                                                        <p> ¿La caja me proporciona oportunidades de crecimiento económico y profesional?</p>
                                                        <select name="SL5" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">45</div>
                                                        <p> ¿Mi capacidad profesional está de acuerdo a las tareas y responsabilidades asignadas?</p>
                                                        <select name="SL6" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">46</div>
                                                        <p> ¿Siento que la organización me valora?</p>
                                                        <select name="SL7" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">47</div>
                                                        <p> ¿Desde mi ingreso pienso que la Caja se ha ido transformando en un mejor lugar para trabajar?</p>
                                                        <select name="SL8" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">48</div>
                                                        <p> ¿Considero que mi sueldo está bien remunerado?</p>
                                                        <select name="SL9" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--COMUNICACION-->
                                            <div class="card question d-flex mb-2 ">
                                                <div class="d-flex flex-grow-1 min-width-zero">
                                                    <div class="card-body align-self-center d-flex flex-column flex-md-row justify-content-between min-width-zero align-items-md-center">
                                                        <p class="list-item-heading mb-0 ">
                                                            <label class="text-dark">COMUNICACIÓN</label>
                                                        </p>
                                                    </div>
                                                    <div class="custom-control custom-checkbox pl-1 align-self-center pr-4">
                                                        <button class="btn btn-primary icon-button btn-rounded btn-sm rotate-icon-click rotate" type="button" data-toggle="collapse" data-target="#qComunicacion" aria-expanded="true" aria-controls="qComunicacion">
                                                            <i class="fe-chevron-down with-rotate-icon"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="question-collapse collapse " id="qComunicacion">
                                                    <div class="card-body pt-0">
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">49</div>
                                                        <p> ¿Conozco los canales de comunicación de la Caja?</p>
                                                        <select name="COM1" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">50</div>
                                                        <p> ¿La comunicación interna dentro de mi departamento o sucursal funciona correctamente?</p>
                                                        <select name="COM2" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">51</div>
                                                        <p> ¿Mi departamento o sucursal se reúnen por lo menos una vez al mes para ver avances en las metas y objetivos?</p>
                                                        <select name="COM3" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">52</div>
                                                        <p> ¿La comunicación sobre los resultados y marcha de la compañía es clara y transparente?</p>
                                                        <select name="COM4" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">53</div>
                                                        <p> ¿Los comunicados internos me proporcionan información útil?</p>
                                                        <select name="COM5" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">54</div>
                                                        <p> ¿Se me comunica de forma oportuna la información que requiero para mi trabajo?</p>
                                                        <select name="COM6" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">55</div>
                                                        <p> ¿Estoy enterado(a) de situaciones y cambios de la Caja a través de mi jefe?</p>
                                                        <select name="COM7" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px">56</div>
                                                        <p> ¿Se me comunica de forma oportuna la información de los servicios y promociones de la Caja?</p>
                                                        <select name="COM8" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--Comentarios-->
                                            <div class="card question d-flex mb-2 ">
                                                <div class="d-flex flex-grow-1 min-width-zero">
                                                    <div class="card-body align-self-center d-flex flex-column flex-md-row justify-content-between min-width-zero align-items-md-center">
                                                        <p class="list-item-heading mb-0 ">
                                                            <label class="text-dark">COMENTARIOS Y/O SUGERENCIAS</label>
                                                        </p>
                                                    </div>
                                                    <div class="custom-control custom-checkbox pl-1 align-self-center pr-4">
                                                        <button class="btn btn-primary icon-button btn-rounded btn-sm rotate-icon-click rotate" type="button" data-toggle="collapse" data-target="#qComentarios" aria-expanded="true" aria-controls="qComentarios">
                                                            <i class="fe-chevron-down with-rotate-icon"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="question-collapse collapse " id="qComentarios">
                                                    <div class="card-body pt-0">
                                                        <textarea class="form-control" placeholder="Inserte comentario y/o sugerencia" id="comentario" name="comentario"> </textarea>
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-success  mb-2">
                                            <i class="fe-save"></i>
                                            Guardar
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php } else {
        echo '<div class="content card-box">
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
                        <h4 style="color: #001689">Esta evaluación ya fue realizada o no esta disponible por el momento. </h4>
                    </div>
                </div>
              </div>
          </div>';
    }
} else {
    echo '<div class="content card-box">
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
                    <h4 style="color: #001689">Esta evaluación ya fue realizada o no esta disponible por el momento. </h4>
                </div>
            </div>
          </div>
       </div>';
}
?>
<script>
    $(document).ready(function(e) {
        $(".rating").each(function() {
            var current = $(this).data("currentRating");
            var readonly = $(this).data("readonly");
            $(this).barrating({
                theme: "bars-movie",
                initialRating: current,
                readonly: readonly
            });
        });
    });
</script>