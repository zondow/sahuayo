<style>
    .br-wrapper {
        margin-left: 40px,  !important;
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

                            <div class="card">
                                <div class="header">
                                    <h2><strong>Instrucciones</strong></h2>
                                </div>
                                <div class="body row">
                                    <div class="col-md-4">
                                        <!--<img src="https://cdn.svgator.com/images/2022/03/Speed-SVG-illustration-CSS_Square.svg" fetchpriority="high" alt="How to Optimize SVG Animations to Improve Your Page Speed Insights Score">-->
                                        <div id="lottie-animation" style="width: 250px; height: 250px;"></div>

                                    </div>
                                    <div class="col-md-8 mt-4">
                                        <p class="text-justify">
                                            Esta evaluación tiene como objetivo evaluar el grado de satisfacción laboral o comodidad de los colaboradores con la caja. Esta ofrece una imagen de la percepción de los trabajadores sobre las cuestiones que se muestran continuación.<br>Contesta honestamente las preguntas y dejanos tus sugerencias o comentarios, los atenderemos con gusto.
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-12">
                                <form action="<?= base_url("Evaluaciones/saveEvaluacionClimaLaboral") ?>" method="post">
                                    <div class="sortable-survey">
                                        <div>
                                            <input type="hidden" name="empleadoID" value="<?= $empleadoID ?>">
                                            <!--AMBIENTE FISICO-->
                                            <div class="card question d-flex mb-2 ">
                                                <div class="d-flex flex-grow-1 min-width-zero">
                                                    <div class="card-body align-self-center d-flex flex-column flex-md-row justify-content-between min-width-zero align-items-md-center">
                                                        <div class="header">
                                                            <h2><strong>AMBIENTE FISICO</strong></h2>
                                                        </div>
                                                    </div>
                                                    <div class="custom-control custom-checkbox pl-1 align-self-center pr-4">
                                                        <button class="btn btn-info icon-button btn-round btn-sm rotate-icon-click rotate" type="button" data-toggle="collapse" data-target="#qAmbienteFisico" aria-expanded="true" aria-controls="qAmbienteFisico">
                                                            <i class="zmdi zmdi-caret-down with-rotate-icon"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="question-collapse collapse " id="qAmbienteFisico">
                                                    <div class="card-body pt-0">
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">1</div>
                                                        <p> ¿El espacio para desarrollar mi trabajo es el adecuado?</p>
                                                        <select name="AF1" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">2</div>
                                                        <p> ¿Hay una adecuada ventilación e iluminación en mi área de trabajo?</p>
                                                        <select name="AF2" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">3</div>
                                                        <p> ¿El mobiliario, herramientas y equipo de trabajo son los adecuados y funcionales para realizar mi trabajo?</p>
                                                        <select name="AF3" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">4</div>
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
                                                        <div class="header">
                                                            <h2><strong>FORMACIÓN Y CAPACITACIÓN</strong></h2>
                                                        </div>
                                                    </div>
                                                    <div class="custom-control custom-checkbox pl-1 align-self-center pr-4">
                                                        <button class="btn btn-info icon-button btn-round btn-sm rotate-icon-click rotate" type="button" data-toggle="collapse" data-target="#qFormacionCapacitacion" aria-expanded="true" aria-controls="qFormacionCapacitacion">
                                                            <i class="zmdi zmdi-caret-down with-rotate-icon"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="question-collapse collapse " id="qFormacionCapacitacion">
                                                    <div class="card-body pt-0">
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">5</div>
                                                        <p> ¿Conozco la capacitación que se me proporcionará en el transcurso del año?</p>
                                                        <select name="FC1" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">6</div>
                                                        <p>¿La Caja me da facilidades para capacitarme?</p>
                                                        <select name="FC2" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">7</div>
                                                        <p> ¿Recibo capacitación para actualizar los conocimientos de mi trabajo?</p>
                                                        <select name="FC3" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">8</div>
                                                        <p> ¿Creo que tengo la oportunidad de desarrollarme profesionalmente en la organización?</p>
                                                        <select name="FC4" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">9</div>
                                                        <p> ¿Conozco claramente cuáles son mis funciones y responsabilidades?</p>
                                                        <select name="FC5" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">10</div>
                                                        <p> ¿Cuando necesito información se donde consultarla?</p>
                                                        <select name="FC6" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">11</div>
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
                                                        <div class="header">
                                                            <h2><strong>LIDERAZGO</strong></h2>
                                                        </div>
                                                    </div>
                                                    <div class="custom-control custom-checkbox pl-1 align-self-center pr-4">
                                                        <button class="btn btn-info icon-button btn-round btn-sm rotate-icon-click rotate" type="button" data-toggle="collapse" data-target="#qLiderazgo" aria-expanded="true" aria-controls="qLiderazgo">
                                                            <i class="zmdi zmdi-caret-down with-rotate-icon"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="question-collapse collapse " id="qLiderazgo">
                                                    <div class="card-body pt-0">
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">12</div>
                                                        <p> ¿Mi jefe valora mis ideas, opiniones, sugerencias y las toma en cuenta?</p>
                                                        <select name="LI1" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">13</div>
                                                        <p> ¿La orientación que me da mi jefe me ayuda a realizar mejor mi trabajo?</p>
                                                        <select name="LI2" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">14</div>
                                                        <p> ¿Mi jefe tiene platicas conmigo para comentarme sobre mis áreas de oportunidad con el fin de mejorar?</p>
                                                        <select name="LI3" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">15</div>
                                                        <p> ¿Mi jefe demuestra un dominio y conocimiento de sus funciones?</p>
                                                        <select name="LI4" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">16</div>
                                                        <p> ¿Mi jefe es coherente con lo que dice y hace?</p>
                                                        <select name="LI5" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">17</div>
                                                        <p> ¿Mi jefe se preocupa por mi bienestar y las necesidades que tengo?</p>
                                                        <select name="LI6" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">18</div>
                                                        <p> ¿Mi jefe tiene disposicion cuando lo requiero?</p>
                                                        <select name="LI7" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">19</div>
                                                        <p> ¿Mi jefe se preocupa por mantener un buen clima en el equipo?</p>
                                                        <select name="LI8" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">20</div>
                                                        <p> ¿Mi jefe me felicita o reconoce cuando realizo bien mi trabajo?</p>
                                                        <select name="LI9" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">21</div>
                                                        <p> ¿En mi departamento o sucursal se da un trato justo y equitativo a todos los empleados?</p>
                                                        <select name="LI10" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">22</div>
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
                                                        <div class="header">
                                                            <h2><strong>RELACIONES EN EL TRABAJO</strong></h2>
                                                        </div>
                                                    </div>
                                                    <div class="custom-control custom-checkbox pl-1 align-self-center pr-4">
                                                        <button class="btn btn-info icon-button btn-round btn-sm rotate-icon-click rotate" type="button" data-toggle="collapse" data-target="#qRelacionesT" aria-expanded="true" aria-controls="qRelacionesT">
                                                            <i class="zmdi zmdi-caret-down with-rotate-icon"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="question-collapse collapse " id="qRelacionesT">
                                                    <div class="card-body pt-0">
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">23</div>
                                                        <p> ¿Puedo confiar en mis compañeros de trabajo?</p>
                                                        <select name="RT1" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">24</div>
                                                        <p> ¿En mi departamento o sucursal se fomenta el compañerismo y la unión entre los colaboradores?</p>
                                                        <select name="RT2" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">25</div>
                                                        <p> ¿La relación con mi jefe es cordial y respetuosa?</p>
                                                        <select name="RT3" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">26</div>
                                                        <p> ¿Recibo buen trato por parte de mis compañeros de la caja?</p>
                                                        <select name="RT4" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">27</div>
                                                        <p> ¿Tengo la confianza de acercarme a mi jefe directo para preguntar sobre algo que no tengo claro?</p>
                                                        <select name="RT5" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">28</div>
                                                        <p> ¿Recibo apoyo por parte de mis compañeros de trabajo si enfrento problemas para desarrollar mi trabajo?</p>
                                                        <select name="RT6" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">29</div>
                                                        <p> ¿Considero que existe un buen ambiente de trabajo?</p>
                                                        <select name="RT7" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">30</div>
                                                        <p> ¿Las personas con las que me relaciono en la organización actúan con respeto y de manera ética?</p>
                                                        <select name="RT8" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">31</div>
                                                        <p> ¿Me siento parte de mi equipo de trabajo?</p>
                                                        <select name="RT9" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">32</div>
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
                                                        <div class="header">
                                                            <h2><strong>SENTIDO DE PERTENENCIA</strong></h2>
                                                        </div>
                                                    </div>
                                                    <div class="custom-control custom-checkbox pl-1 align-self-center pr-4">
                                                        <button class="btn btn-info icon-button btn-round btn-sm rotate-icon-click rotate" type="button" data-toggle="collapse" data-target="#qPertenencia" aria-expanded="true" aria-controls="qPertenencia">
                                                            <i class="zmdi zmdi-caret-down with-rotate-icon"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="question-collapse collapse " id="qPertenencia">
                                                    <div class="card-body pt-0">
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">33</div>
                                                        <p> ¿Conozco cuál es el objetivo de la Caja y trabajo con base a ello para poder lograrlo?</p>
                                                        <select name="PE1" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">34</div>
                                                        <p> ¿Me involucro en las actividades de la Caja?</p>
                                                        <select name="PE2" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">35</div>
                                                        <p> ¿Me identifico con la misión, la vision y los valores de la Caja?</p>
                                                        <select name="PE3" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">36</div>
                                                        <p> ¿En mi departamento o sucursal se actúa conforme a los valores de la Caja?</p>
                                                        <select name="PE4" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">37</div>
                                                        <p> ¿Me siento comprometido(a) con mi trabajo para lograr el objetivo de la Caja?</p>
                                                        <select name="PE5" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">38</div>
                                                        <p> ¿Pienso que la organización es un buen lugar para trabajar y me gustaría continuar trabajando aquí?</p>
                                                        <select name="PE6" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">39</div>
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
                                                        <div class="header">
                                                            <h2><strong>SATISFACCIÓN LABORAL</strong></h2>
                                                        </div>
                                                    </div>
                                                    <div class="custom-control custom-checkbox pl-1 align-self-center pr-4">
                                                        <button class="btn btn-info icon-button btn-round btn-sm rotate-icon-click rotate" type="button" data-toggle="collapse" data-target="#qSatisfaccion" aria-expanded="true" aria-controls="qSatisfaccion">
                                                            <i class="zmdi zmdi-caret-down with-rotate-icon"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="question-collapse collapse " id="qSatisfaccion">
                                                    <div class="card-body pt-0">
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">40</div>
                                                        <p> ¿Estoy satisfecho(a) con el desempeño de mi trabajo?</p>
                                                        <select name="SL1" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">41</div>
                                                        <p> ¿Estoy satisfecho(a) con el puesto que tengo actualmente?</p>
                                                        <select name="SL2" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">42</div>
                                                        <p> ¿Es interesante el trabajo que desempeño en la Caja?</p>
                                                        <select name="SL3" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">43</div>
                                                        <p> ¿Mi trabajo me ofrece retos y la oportunidad de seguir mejorando?</p>
                                                        <select name="SL4" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">44</div>
                                                        <p> ¿La caja me proporciona oportunidades de crecimiento económico y profesional?</p>
                                                        <select name="SL5" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">45</div>
                                                        <p> ¿Mi capacidad profesional está de acuerdo a las tareas y responsabilidades asignadas?</p>
                                                        <select name="SL6" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">46</div>
                                                        <p> ¿Siento que la organización me valora?</p>
                                                        <select name="SL7" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">47</div>
                                                        <p> ¿Desde mi ingreso pienso que la Caja se ha ido transformando en un mejor lugar para trabajar?</p>
                                                        <select name="SL8" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">48</div>
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
                                                        <div class="header">
                                                            <h2><strong>COMUNICACIÓN</strong></h2>
                                                        </div>
                                                    </div>
                                                    <div class="custom-control custom-checkbox pl-1 align-self-center pr-4">
                                                        <button class="btn btn-info icon-button btn-round btn-sm rotate-icon-click rotate" type="button" data-toggle="collapse" data-target="#qComunicacion" aria-expanded="true" aria-controls="qComunicacion">
                                                            <i class="zmdi zmdi-caret-down with-rotate-icon"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="question-collapse collapse " id="qComunicacion">
                                                    <div class="card-body pt-0">
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">49</div>
                                                        <p> ¿Conozco los canales de comunicación de la Caja?</p>
                                                        <select name="COM1" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">50</div>
                                                        <p> ¿La comunicación interna dentro de mi departamento o sucursal funciona correctamente?</p>
                                                        <select name="COM2" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">51</div>
                                                        <p> ¿Mi departamento o sucursal se reúnen por lo menos una vez al mes para ver avances en las metas y objetivos?</p>
                                                        <select name="COM3" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">52</div>
                                                        <p> ¿La comunicación sobre los resultados y marcha de la compañía es clara y transparente?</p>
                                                        <select name="COM4" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">53</div>
                                                        <p> ¿Los comunicados internos me proporcionan información útil?</p>
                                                        <select name="COM5" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">54</div>
                                                        <p> ¿Se me comunica de forma oportuna la información que requiero para mi trabajo?</p>
                                                        <select name="COM6" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">55</div>
                                                        <p> ¿Estoy enterado(a) de situaciones y cambios de la Caja a través de mi jefe?</p>
                                                        <select name="COM7" class="rating" data-current-rating="-1" required>
                                                            <option value="1" data-html="Nunca">1</option>
                                                            <option value="2" data-html="Casi Nunca">2</option>
                                                            <option value="3" data-html="A Veces">3</option>
                                                            <option value="4" data-html="Casi Siempre">4</option>
                                                            <option value="5" data-html="Siempre">5</option>
                                                        </select>
                                                        <br>
                                                        <div class="question-q-box mt-0 float-left bg-warning text-white rounded-circle text-center" style="margin-right: 10px; width:2%; background-color:#f4e231 !important">56</div>
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
                                                        <div class="header">
                                                            <h2><strong>COMENTARIOS Y/O SUGERENCIAS</strong></h2>
                                                        </div>
                                                    </div>
                                                    <div class="custom-control custom-checkbox pl-1 align-self-center pr-4">
                                                        <button class="btn btn-info icon-button btn-round btn-sm rotate-icon-click rotate" type="button" data-toggle="collapse" data-target="#qComentarios" aria-expanded="true" aria-controls="qComentarios">
                                                            <i class="zmdi zmdi-caret-down with-rotate-icon"></i>
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
                                        <button type="submit" class="btn btn-success btn-round  mb-2">
                                            <i class="fe-save"></i>
                                            Enviar
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
        echo '<div class="content card">
            <div class="card-body row">
                <div class="col-md-4"></div>
                <div class="col-md-4" style="margin-top: 9%;margin-bottom: 9%">
                    <div class="text-center">
                        <div id="lottie-animation-no-disponible" style="width: 300px; height: 250px;"></div>
                        <h4 style="color: #001689">Esta evaluación ya fue realizada o no esta disponible por el momento. </h4>
                    </div>
                </div>
              </div>
          </div>';
    }
} else {
    echo '<div class="content card">
            <div class="card-body row">
            <div class="col-md-4"></div>
            <div class="col-md-4" style="margin-top: 9%;margin-bottom: 9%">
                <div class="text-center">
                    <div id="lottie-animation-no-disponible" style="width: 300px; height: 250px;"></div>
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