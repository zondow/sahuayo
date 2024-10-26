
<div class="col-lg-12 col-md-12 col-sm-12">
    <div class="card">
        <div class="header">
            <h2><strong><?=$plantilla["pla_Nombre"]?></strong></h2>
            <ul class="header-dropdown">
                <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li><a href="javascript:void(0);">Action</a></li>
                        <li><a href="javascript:void(0);">Another action</a></li>
                        <li><a href="javascript:void(0);">Something else</a></li>
                    </ul>
                </li>
                
            </ul>
        </div>
        <div class="body">
            <div id="wizard_horizontal">
                <h2>Cuestionario</h2>
                <section>
                <div class="container mt-4">
    <div class="row">
        <!-- Barra lateral para Grupos de Preguntas -->
        <div class="col-md-3">
            <h4>Grupos de Preguntas</h4>
            <ul class="list-group" id="grupo_lista">
                <!-- Los grupos se añadirán aquí dinámicamente -->
            </ul>
            <button id="add_group" class="btn btn-primary btn-block mt-3">Añadir Grupo</button>
        </div>

        <!-- Área principal para Preguntas -->
        <div class="col-md-9">
            <h4 id="grupo_titulo">Seleccione un grupo para añadir preguntas</h4>
            <div id="preguntas_container" class="mt-3">
                <!-- Preguntas y respuestas se añadirán aquí dinámicamente -->
            </div>
            <button id="add_question" class="btn btn-secondary mt-3" disabled>Añadir Pregunta</button>
        </div>
    </div>
    <button id="save_evaluation" class="btn btn-success mt-4">Guardar Evaluación</button>
</div>

<script>
    $(document).ready(function () {
        const evaluation = [];

        // Añadir nuevo grupo
        $('#add_group').click(function () {
            const grupoNombre = prompt("Ingrese el nombre del grupo:");
            if (!grupoNombre) return;

            const grupo = {
                nombre: grupoNombre,
                preguntas: []
            };
            evaluation.push(grupo);

            const grupoIndex = evaluation.length - 1;
            $('#grupo_lista').append(`
                <li class="list-group-item grupo-item" data-group-index="${grupoIndex}">
                    ${grupoNombre}
                </li>
            `);

            // Activar la opción de añadir preguntas para el nuevo grupo
            $('.grupo-item').removeClass('active');
            $(`[data-group-index="${grupoIndex}"]`).addClass('active');
            $('#grupo_titulo').text(grupoNombre);
            $('#add_question').prop('disabled', false);
            renderPreguntas(grupoIndex);
        });

        // Cambiar de grupo al hacer clic
        $('#grupo_lista').on('click', '.grupo-item', function () {
            const grupoIndex = $(this).data('group-index');
            $('.grupo-item').removeClass('active');
            $(this).addClass('active');
            $('#grupo_titulo').text(evaluation[grupoIndex].nombre);
            $('#add_question').prop('disabled', false);
            renderPreguntas(grupoIndex);
        });

        // Añadir nueva pregunta
        $('#add_question').click(function () {
            const grupoIndex = $('.grupo-item.active').data('group-index');
            if (grupoIndex === undefined) return;

            const pregunta = { texto: '', tipo: 'multiple', respuestas: [], obligatoria: false };
            evaluation[grupoIndex].preguntas.push(pregunta);
            renderPreguntas(grupoIndex);
        });

        // Renderizar preguntas del grupo actual
        function renderPreguntas(grupoIndex) {
            const grupo = evaluation[grupoIndex];
            $('#preguntas_container').empty();

            grupo.preguntas.forEach((pregunta, preguntaIndex) => {
                $('#preguntas_container').append(`
                    <div class="card mt-2 pregunta" data-question-index="${preguntaIndex}">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Pregunta</label>
                                <input type="text" class="form-control pregunta_texto" placeholder="Escribe la pregunta" value="${pregunta.texto}">
                            </div>
                            <div class="form-group">
                                <label>Tipo de Pregunta</label>
                                <select class="form-control pregunta_tipo">
                                    <option value="multiple" ${pregunta.tipo === 'multiple' ? 'selected' : ''}>Elección Múltiple</option>
                                    <option value="texto" ${pregunta.tipo === 'texto' ? 'selected' : ''}>Texto</option>
                                </select>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input pregunta_obligatoria" ${pregunta.obligatoria ? 'checked' : ''}>
                                <label class="form-check-label">Obligatoria</label>
                            </div>
                            <button type="button" class="btn btn-info btn-sm add_answer mt-2">Añadir Respuesta</button>
                            <div class="respuestas_container mt-2">
                                ${pregunta.respuestas.map((respuesta, i) => `
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control respuesta_texto" value="${respuesta}">
                                        <div class="input-group-append">
                                            <button class="btn btn-danger remove_answer" type="button">X</button>
                                        </div>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    </div>
                `);
            });
        }

        // Añadir nueva respuesta
        $('#preguntas_container').on('click', '.add_answer', function () {
            const grupoIndex = $('.grupo-item.active').data('group-index');
            const preguntaIndex = $(this).closest('.pregunta').data('question-index');

            evaluation[grupoIndex].preguntas[preguntaIndex].respuestas.push('');
            renderPreguntas(grupoIndex);
        });

        // Eliminar respuesta
        $('#preguntas_container').on('click', '.remove_answer', function () {
            const grupoIndex = $('.grupo-item.active').data('group-index');
            const preguntaIndex = $(this).closest('.pregunta').data('question-index');
            const respuestaIndex = $(this).closest('.input-group').index();

            evaluation[grupoIndex].preguntas[preguntaIndex].respuestas.splice(respuestaIndex, 1);
            renderPreguntas(grupoIndex);
        });

        // Guardar evaluación
        $('#save_evaluation').click(function () {
            evaluation.forEach(grupo => {
                grupo.preguntas.forEach(pregunta => {
                    pregunta.texto = pregunta.texto || 'Nueva Pregunta';
                    pregunta.respuestas = pregunta.respuestas.filter(r => r); // Eliminar respuestas vacías
                });
            });

            $.ajax({
                url: 'guardar_evaluacion.php',
                type: 'POST',
                data: { evaluation: JSON.stringify(evaluation) },
                success: function () {
                    alert('Evaluación guardada exitosamente');
                    location.reload();
                },
                error: function () {
                    alert('Hubo un error al guardar la evaluación');
                }
            });
        });
    });
</script>
                </section>
                <h2>Evaluadores</h2>
                <section>
                    <p>Donec mi sapien, hendrerit nec egestas a, rutrum vitae dolor. Nullam venenatis diam ac
                        ligula elementum pellentesque. In lobortis sollicitudin felis non eleifend. Morbi
                        tristique tellus est, sed tempor elit. Morbi varius, nulla quis condimentum dictum,
                        nisi elit condimentum magna, nec venenatis urna quam in nisi. Integer hendrerit sapien
                        a diam adipiscing consectetur. In euismod augue ullamcorper leo dignissim quis elementum
                        arcu porta. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum leo
                        velit, blandit ac tempor nec, ultrices id diam. Donec metus lacus, rhoncus sagittis
                        iaculis nec, malesuada a diam. Donec non pulvinar urna. Aliquam id velit lacus. </p>
                </section>
                <h2>Evaluados</h2>
                <section>
                    <p> Morbi ornare tellus at elit ultrices id dignissim lorem elementum. Sed eget nisl at justo
                        condimentum dapibus. Fusce eros justo, pellentesque non euismod ac, rutrum sed quam.
                        Ut non mi tortor. Vestibulum eleifend varius ullamcorper. Aliquam erat volutpat.
                        Donec diam massa, porta vel dictum sit amet, iaculis ac massa. Sed elementum dui
                        commodo lectus sollicitudin in auctor mauris venenatis. </p>
                </section>
                <h2>Resultados</h2>
                <section>
                    <p> Quisque at sem turpis, id sagittis diam. Suspendisse malesuada eros posuere mauris vehicula
                        vulputate. Aliquam sed sem tortor. Quisque sed felis ut mauris feugiat iaculis nec
                        ac lectus. Sed consequat vestibulum purus, imperdiet varius est pellentesque vitae.
                        Suspendisse consequat cursus eros, vitae tempus enim euismod non. Nullam ut commodo
                        tortor. </p>
                </section>
            </div>
        </div>
    </div>
</div>