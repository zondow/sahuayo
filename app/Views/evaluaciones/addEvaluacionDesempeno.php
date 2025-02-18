<style>
    .new_friend_list {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        /* Ajusta el tamaño de los elementos automáticamente */
        gap: 30px;
        justify-content: center;
        /* Centra el grid */
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .new_friend_list li {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
</style>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="header">
                <h2><strong><?= $plantilla["pla_Nombre"] ?></strong></h2>
                <ul class="header-dropdown">
                    <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li><a href="javascript:void(0);">Action</a></li>
                            <li><a href="javascript:void(0);">Another action</a></li>
                            <li><a href="javascript:void(0);">Something else</a></li>
                        </ul>
                    </li>
                    <li class="remove">
                        <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                    </li>
                </ul>
            </div>
            <div class="body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#cuestionario">CUESTIONARIO</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#evaluados">EVALUADOS</a></li>
                    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#asignacion">ASIGNACIÓN</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane in active" id="cuestionario">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="card">
                                <div class="body">
                                    <!-- Botón para guardar evaluación -->
                                    <div class="col-md-12 text-right ">
                                        <button id="save_evaluation" class="btn btn-round btn-success"><i class="zmdi zmdi-save"></i> Guardar </button>
                                    </div>
                                    <!-- Campo de entrada para el nombre del nuevo grupo -->
                                    <div class="form-group">
                                        <label>Nombre del Grupo</label>
                                        <input type="text" id="grupo_nombre" class="form-control" placeholder="Escribe el nombre del grupo">
                                    </div>
                                    <button type="button" id="add_group" class="btn btn-primary btn-round"> <i class="zmdi zmdi-plus"></i> Añadir Grupo </button>

                                    <!-- Contenedor de grupos -->
                                    <div id="grupos_container">
                                        <!-- Grupos de preguntas y respuestas se añadirán aquí dinámicamente -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="evaluados">
                        <div class="col-md-12 text-right ">
                            <button type="button" id="abrirModalEvaluados" class="btn btn-success btn-round"> <i class="zmdi zmdi-plus"></i> Agregar </button>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="card">
                                <div class="body">
                                    <table id="tblCuestionarioEvaluados" class=" table table-hover m-0 table-centered  dt-responsive  " cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Foto</th>
                                                <th>Nombre</th>
                                                <th>Puesto</th>
                                                <th>Departamento</th>
                                                <th>Sucursal</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="asignacion">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                                <span class="badge bg-success badge-pill font-13" style="color:white"> Autoevaluación </span>
                                <span class="badge bg-primary badge-pill font-13" style="color:white"> Compañero </span>
                                <span class="badge bg-warning badge-pill font-13" style="color:white"> Equipo a cargo</span>
                                <span class="badge bg-info badge-pill font-13" style="color:white"> Responsable directo</span>
                                <span class="badge bg-secondary badge-pill font-13" style="color:white"> Otro </span>
                            </div>
                            <div class="card">
                                <div class="body">
                                    <table id="tblCuestionarioEvaluadosEvaluadores" class=" table table-hover m-0 table-centered  dt-responsive  " cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Foto</th>
                                                <th>Nombre</th>
                                                <th>Puesto</th>
                                                <th>Departamento</th>
                                                <th>Sucursal</th>
                                                <th>Evaluadores</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!--------------- Modal Evaluados  ----------------->
<div id="modalEvaluados" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="titleModal"></h4>
            </div>
            <div class="modal-body">
                <table id="tablaEmpleados" class=" table table-hover m-0 table-centered  dt-responsive  " cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Foto</th>
                            <th>Nombre</th>
                            <th>Puesto</th>
                            <th>Departamento</th>
                            <th>Sucursal</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!--------------- Modal Asignacion ------------------>
<div class="modal fade" id="modalAsignarNivel" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Asignar evaluadores</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formAsignarNivel">
                    <input type="hidden" id="evaluadoID" name="evaluadoID">
                    <input type="hidden" id="cuestionarioID" name="cuestionarioID">
                    <input type="hidden" id="plantillaID" name="plantillaID" value="<?= $plantillaID ?>">
                    <div class="form-group">
                        <label for="empleadoNombre">Evaluado</label>
                        <input type="text" class="form-control" id="empleadoNombre" name="empleadoNombre" readonly>
                    </div>

                    <div class="form-group">
                        <label for="empleadoID">Evaluador</label>
                        <select class="form-control select2" id="empleadoID" name="empleadoID[]" multiple style="width: 100%;">
                            <option value="">Seleccione un empleado</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nivelEvaluacion">Nivel de Evaluación</label>
                        <select class="form-control select2" id="nivelEvaluacion" name="nivelEvaluacion">
                            <option value="autoevaluacion">Autoevaluación</option>
                            <option value="companero">Compañero</option>
                            <option value="equipo">Equipo a cargo</option>
                            <option value="responsable">Responsable directo</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="col-md-12 text-right">
                    <button type="button" class="btn btn-secondary btn-round" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success btn-round" id="btnGuardarAsignacion">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--------------- Modal Evaluadores ------------------>
<div class="modal fade" id="modalEvaluadores" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content ">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Asignar evaluadores</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="empleadoNombre">Evaluado</label>
                    <input type="text" class="form-control" id="evaluadoNombre" readonly>
                </div>
                <div class="form-group">
                    <label for="empleadoID">Evaluador</label>
                    <textarea class="form-control" id="evaluadoresNombre" readonly></textarea>
                </div>
                <div class="form-group">
                    <label for="nivelEvaluacion">Nivel de Evaluación</label>
                    <input type="text" class="form-control" id="nivelEvaluacionEvaluadores" readonly>
                </div>
            </div>
            <div class="modal-footer">
                <div class="col-md-12 text-right">
                    <button type="button" class="btn btn-secondary btn-round" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        /////////////////// CUESTIONARIO /////////////////
        const evaluation = [];
        let CuestionarioID = <?= $plantilla['pla_PlantillaID'] ?>;
        const deletedQuestions = [];

        // Cargar la evaluación desde la base de datos
        $.ajax({
            url: BASE_URL + 'Evaluaciones/ajax_getEvaluacion',
            type: 'POST',
            data: {
                cuestionarioID: CuestionarioID
            },
            dataType: 'json',
            success: function(response) {
                const data = response;
                // Llenar la estructura de evaluación con los datos
                data.forEach(grupo => {
                    const grupoIndex = evaluation.length;
                    evaluation.push({
                        nombre: grupo.nombre,
                        preguntas: grupo.preguntas.map(pregunta => ({
                            id: pregunta.id,
                            texto: pregunta.texto,
                            tipo: pregunta.tipo,
                            ponderacion: pregunta.ponderacion,
                            obligatoria: pregunta.obligatoria,
                            respuestas: pregunta.respuestas
                        }))
                    });

                    // Renderizar el grupo
                    $('#grupos_container').append(`
                        <div class="card mt-4 grupo" data-group-index="${grupoIndex}">
                            <div class="card-header">
                                <h5>Grupo: ${grupo.nombre}</h5>
                                <button type="button" class="btn btn-secondary btn-sm btn-round add_question"> <i class="zmdi zmdi-plus"></i>  Añadir Pregunta </button>
                            </div>
                            <div class="card-body preguntas_container">
                                <!-- Preguntas y respuestas de este grupo se añadirán aquí -->
                            </div>
                        </div>
                    `);

                    // Renderizar las preguntas de cada grupo
                    grupo.preguntas.forEach((pregunta, preguntaIndex) => {
                        renderPreguntas(grupoIndex, pregunta, preguntaIndex);
                    });
                });
            },
            error: function() {
                $.toast({
                    text: "Hubo un error al cargar los datos de la evaluación.",
                    icon: "error",
                    loader: true,
                    position: 'top-right',
                    allowToastClose: false
                });
            }
        });

        // Añadir nuevo grupo
        $('#add_group').click(function() {
            const grupoNombre = $('#grupo_nombre').val().trim();
            if (!grupoNombre) {
                $.toast({
                    text: "Por favor ingrese el nombre del grupo.",
                    icon: "error",
                    loader: true,
                    position: 'top-right',
                    allowToastClose: false
                });
                return;
            }
            $('#grupo_nombre').val(''); // Limpiar el campo después de agregar el grupo

            const grupo = {
                nombre: grupoNombre,
                preguntas: []
            };
            evaluation.push(grupo);

            const grupoIndex = evaluation.length - 1;
            $('#grupos_container').append(`
                <div class="card mt-4 grupo" data-group-index="${grupoIndex}">
                    <div class="card-header">
                        <h5>Grupo: ${grupoNombre}</h5>
                        <button type="button" class="btn btn-secondary btn-sm btn-round add_question"> <i class="zmdi zmdi-plus"></i>  Añadir Pregunta </button>
                    </div>
                    <div class="card-body preguntas_container">
                        <!-- Preguntas y respuestas de este grupo se añadirán aquí -->
                    </div>
                </div>
            `);
        });

        // Añadir nueva pregunta
        $('#grupos_container').on('click', '.add_question', function() {
            const grupoIndex = $(this).closest('.grupo').data('group-index');
            const pregunta = {
                texto: '',
                tipo: 'multiple',
                respuestas: [],
                obligatoria: false,
                ponderacion: 0
            };
            evaluation[grupoIndex].preguntas.push(pregunta);
            renderPreguntas(grupoIndex);
        });

        // Renderizar preguntas del grupo actual con botón de eliminación
        function renderPreguntas(grupoIndex, pregunta = {}, preguntaIndex = evaluation[grupoIndex].preguntas.length - 1) {
            const grupo = evaluation[grupoIndex];
            const $preguntasContainer = $(`[data-group-index="${grupoIndex}"] .preguntas_container`);

            // Limpiar las preguntas antes de renderizar
            $preguntasContainer.empty();

            // Renderizar las preguntas actuales
            grupo.preguntas.forEach((pregunta, preguntaIndex) => {
                $preguntasContainer.append(`
                    <div class="card  pregunta" data-question-index="${preguntaIndex}">
                        <div class="card-body">
                            <div class="form-group text-right">
                                <button type="button" class="btn btn-danger btn-sm btn-round remove_question mt-2"><i class="zmdi zmdi-delete"></i></button>
                            </div>
                            <div class="form-group">
                                <label>Pregunta</label>
                                <input type="text" class="form-control pregunta_texto" placeholder="Escribe la pregunta" value="${pregunta.texto}">
                            </div>
                            <div class="form-group">
                                <label>Ponderación</label>
                                <input type="number" class="form-control pregunta_ponderacion" placeholder="Asignar ponderación" value="${pregunta.ponderacion}" min="0">
                            </div>
                            <div class="form-group">
                                <label>Tipo de Pregunta</label>
                                <select class="form-control pregunta_tipo">
                                    <option value="seleccion" ${pregunta.tipo === 'seleccion' ? 'selected' : ''}>Elección Única</option>
                                    <option value="multiple" ${pregunta.tipo === 'multiple' ? 'selected' : ''}>Elección Múltiple</option>
                                    <option value="abierta" ${pregunta.tipo === 'abierta' ? 'selected' : ''}>Abierta</option>
                                    <option value="rango" ${pregunta.tipo === 'rango' ? 'selected' : ''}>Rango</option>
                                    <option value="satisfaccion" ${pregunta.tipo === 'satisfaccion' ? 'selected' : ''}>Satisfacción</option>
                                </select>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input pregunta_obligatoria" ${pregunta.obligatoria ? 'checked' : ''}>
                                <label class="form-check-label">Obligatoria</label>
                            </div>
                            <br>
                            <button type="button" class="btn btn-info btn-sm btn-round add_answer mt-2"><i class="zmdi zmdi-plus"></i>  Añadir Respuesta </button>
                           
                            <div class="respuestas_container mt-2">
                                ${pregunta.respuestas.map((respuesta, i) => `
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control respuesta_texto" value="${respuesta}">
                                        <div class="input-group-append">
                                            <button class="btn btn-danger btn-sm btn-round remove_answer mt-2" type="button"><i class="zmdi zmdi-delete"></i> </button>
                                        </div>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    </div>
                `);
            });
        }

        // Evento para eliminar una pregunta
        $('#grupos_container').on('click', '.remove_question', function() {
            const grupoIndex = $(this).closest('.grupo').data('group-index');
            const preguntaIndex = $(this).closest('.pregunta').data('question-index');
            const preguntaId = evaluation[grupoIndex].preguntas[preguntaIndex].id; // Obtener el ID de la pregunta
            evaluation[grupoIndex].preguntas.splice(preguntaIndex, 1);
            renderPreguntas(grupoIndex);
            deletedQuestions.push(preguntaId);
        });

        // Añadir nueva respuesta
        $('#grupos_container').on('click', '.add_answer', function() {
            const grupoIndex = $(this).closest('.grupo').data('group-index');
            const preguntaIndex = $(this).closest('.pregunta').data('question-index');
            evaluation[grupoIndex].preguntas[preguntaIndex].respuestas.push('');
            renderPreguntas(grupoIndex);
        });

        // Eliminar respuesta
        $('#grupos_container').on('click', '.remove_answer', function() {
            const grupoIndex = $(this).closest('.grupo').data('group-index');
            const preguntaIndex = $(this).closest('.pregunta').data('question-index');
            const respuestaIndex = $(this).closest('.input-group').index();
            evaluation[grupoIndex].preguntas[preguntaIndex].respuestas.splice(respuestaIndex, 1);
            renderPreguntas(grupoIndex);
        });

        // Guardar evaluación
        $('#save_evaluation').click(function() {
            evaluation.forEach(grupo => {
                grupo.preguntas.forEach(pregunta => {
                    pregunta.texto = pregunta.texto || '';
                    if (pregunta.tipo !== 'abierta') {
                        pregunta.respuestas = pregunta.respuestas.filter(r => r.trim() !== '');
                    }


                    grupo.preguntas = grupo.preguntas.filter(pregunta => pregunta.texto.trim() !== '');

                });
            });

            $.ajax({
                url: BASE_URL + "Evaluaciones/guardarCuestionarioCompleto",
                type: "POST",
                dataType: 'json',
                data: {
                    evaluation: JSON.stringify(evaluation),
                    cuestionarioID: CuestionarioID,
                    deletedQuestions: JSON.stringify(deletedQuestions)
                },
                success: function() {
                    $.toast({
                        text: "Evaluación guardada exitosamente.",
                        icon: "success",
                        loader: true,
                        position: 'top-right',
                        allowToastClose: false
                    });
                    location.reload();
                },
                error: function() {
                    $.toast({
                        text: "Hubo un error al guardar la evaluación.",
                        icon: "error",
                        loader: true,
                        position: 'top-right',
                        allowToastClose: false
                    });
                }
            });
        });

        // Guardar el contenido del campo en `evaluation` al escribir
        $('#grupos_container').on('input', '.pregunta_texto', function() {
            const grupoIndex = $(this).closest('.grupo').data('group-index');
            const preguntaIndex = $(this).closest('.pregunta').data('question-index');
            evaluation[grupoIndex].preguntas[preguntaIndex].texto = $(this).val();
        });

        $('#grupos_container').on('change', '.pregunta_tipo', function() {
            const grupoIndex = $(this).closest('.grupo').data('group-index');
            const preguntaIndex = $(this).closest('.pregunta').data('question-index');
            evaluation[grupoIndex].preguntas[preguntaIndex].tipo = $(this).val();
        });

        $('#grupos_container').on('change', '.pregunta_obligatoria', function() {
            const grupoIndex = $(this).closest('.grupo').data('group-index');
            const preguntaIndex = $(this).closest('.pregunta').data('question-index');
            evaluation[grupoIndex].preguntas[preguntaIndex].obligatoria = $(this).is(':checked');
        });

        $('#grupos_container').on('input', '.respuesta_texto', function() {
            const grupoIndex = $(this).closest('.grupo').data('group-index');
            const preguntaIndex = $(this).closest('.pregunta').data('question-index');
            const respuestaIndex = $(this).closest('.input-group').index();
            evaluation[grupoIndex].preguntas[preguntaIndex].respuestas[respuestaIndex] = $(this).val();
        });

        // Guardar el valor de la ponderación
        $('#grupos_container').on('input', '.pregunta_ponderacion', function() {
            const grupoIndex = $(this).closest('.grupo').data('group-index');
            const preguntaIndex = $(this).closest('.pregunta').data('question-index');
            evaluation[grupoIndex].preguntas[preguntaIndex].ponderacion = parseFloat($(this).val()) || 0;
        });



        ///////////// EVALUADOS /////////////////////
        var modal = $("#modalEvaluados");
        $('#abrirModalEvaluados').click(function() {

            $("#titleModal").html('Agregar evaluados');
            modal.modal("show");
        });

        var tblEmpleados = $("#tablaEmpleados").DataTable({
            destroy: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "Todos"]
            ],
            ajax: {
                url: BASE_URL + "Personal/ajax_getEmpleadosActivos",
                dataType: "json",
                type: "POST",
                "processing": true,
                "serverSide": true
            },
            columns: [

                {
                    "data": "emp_Foto",
                    render: function(data, type, row) {
                        return foto(data, type, row)
                    }
                },
                {
                    "data": "emp_Nombre"
                },
                {
                    "data": "pue_Nombre"
                },
                {
                    "data": "dep_Nombre"
                },
                {
                    "data": "suc_Sucursal"
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `<input type="checkbox" class="select-checkbox" value="${row.emp_EmpleadoID}">`;
                    },
                    orderable: false,
                    className: 'text-center select-checkbox-column'
                },


            ],
            columnDefs: [{
                    targets: 0,
                    className: 'text-center'
                },
                {
                    orderable: false,
                    targets: '_all'
                }
            ],
            responsive: true,
            stateSave: false,
            language: {
                paginate: {
                    previous: "<i class='zmdi zmdi-chevron-left'>",
                    next: "<i class='zmdi zmdi-chevron-right'>"
                },
                search: "_INPUT_",
                searchPlaceholder: "Buscar...",
                lengthMenu: "Registros por página _MENU_",
                info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                infoEmpty: "Mostrando 0 a 0 de 0 registros",
                zeroRecords: "No hay datos para mostrar",
                loadingRecords: "Cargando...",
                infoFiltered: "(filtrado de _MAX_ registros)",
                "processing": "Procesando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "<i class='zmdi zmdi-chevron-right'>",
                    "sPrevious": "<i class='zmdi zmdi-chevron-left'>"
                },
            },
            "order": [],
            "processing": true,
            dom: '<"top"B>rt<"bottom"lip><"clear">', // Añadir el botón en la parte superior
            buttons: [{
                text: 'Guardar',
                className: 'btn btn-success',
                action: function() {
                    var seleccionados = [];

                    // Recorre cada checkbox seleccionado
                    $("#tablaEmpleados input.select-checkbox:checked").each(function() {
                        seleccionados.push($(this).val());
                    });

                    if (seleccionados.length > 0) {
                        // Llamada AJAX para enviar los IDs seleccionados al servidor
                        $.ajax({
                            url: BASE_URL + "Evaluaciones/guardarEvaluadosSeleccionados",
                            type: "POST",
                            dataType: "json",
                            data: {
                                ids: seleccionados,
                                cuestionarioID: CuestionarioID
                            },
                            success: function(response) {
                                if (response.status === 'success') {
                                    $.toast({
                                        text: response.message,
                                        icon: "success",
                                        loader: true,
                                        position: 'top-right',
                                        allowToastClose: false
                                    });

                                    tblEmpleados.ajax.reload(); // Recargar la tabla después de guardar
                                    tblCuestionarioEvaluados.ajax.reload();
                                } else {
                                    $.toast({
                                        text: response.message,
                                        icon: "error",
                                        loader: true,
                                        position: 'top-right',
                                        allowToastClose: false
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                console.log("Error:", error);
                                alert("Hubo un error al guardar los evaluados.");
                            }
                        });
                    } else {
                        $.toast({
                            text: "Por favor, selecciona al menos un registro.",
                            icon: "warning",
                            loader: true,
                            position: 'top-right',
                            allowToastClose: false
                        });
                    }
                }
            }],
            initComplete: function() {
                // Agregar checkbox "Seleccionar todo" en el encabezado
                var headerCheckbox = $('<input type="checkbox" class="select-all-checkbox">');
                $("#tablaEmpleados thead th.select-checkbox-column").html(headerCheckbox);

                // Manejar el clic en el checkbox del encabezado
                headerCheckbox.on('click', function() {
                    var isChecked = $(this).prop('checked');
                    $("#tablaEmpleados input.select-checkbox").prop('checked', isChecked);
                });

                // Asegurarse de que si se seleccionan o deseleccionan todos, se actualice el encabezado
                $("#tablaEmpleados tbody").on('change', 'input.select-checkbox', function() {
                    var totalCheckboxes = $("#tablaEmpleados input.select-checkbox").length;
                    var totalChecked = $("#tablaEmpleados input.select-checkbox:checked").length;

                    // Si todos los checkboxes están seleccionados, marcar el checkbox del encabezado
                    $(".select-all-checkbox").prop('checked', totalCheckboxes === totalChecked);
                });
            }

        });

        function foto(data, type, row) {
            let foto = '<img src="' + row['emp_Foto'] + '" class="rounded-circle avatar" data-lightbox="' + row['emp_Foto'] + '" data-title="" alt="" style="width: 50px; height: 50px;" >';
            return foto;
        }

        // Agregar filtros de columna
        $("#tablaEmpleados thead tr").clone(true).appendTo("#tablaEmpleados thead");
        $("#tablaEmpleados thead tr:eq(1) th").each(function(i) {
            if (i != 0) { // No agregar filtro en la columna de imagen (emp_Foto)
                var title = $(this).text();
                $(this).html('<input type="text" class="column_filter" placeholder="Buscar ' + title + '" />');
                $('input', this).on('keyup change', function() {
                    if (tblEmpleados.column(i).search() !== this.value) {
                        tblEmpleados
                            .column(i)
                            .search(this.value)
                            .draw();
                    }
                });
            }
        });

        // Asegurarse de que los inputs se muestran correctamente
        $(window).on('resize', function() {
            // Recarga de la tabla después de un cambio en el tamaño de la ventana
            tblEmpleados.columns.adjust().draw();
        });

        var tblCuestionarioEvaluados = $("#tblCuestionarioEvaluados").DataTable({
            destroy: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "Todos"]
            ],
            ajax: {
                url: BASE_URL + "Evaluaciones/ajax_getEvaluadosCuestionario",
                type: "POST",
                dataType: "json",
                data: {
                    cuestionarioID: CuestionarioID,
                    plantillaID: "<?= $plantillaID ?>"
                }
            },
            columns: [{
                    "data": "emp_Foto",
                    render: function(data, type, row) {
                        return foto(data, type, row); // Renderiza la imagen
                    }
                },
                {
                    "data": "emp_Nombre"
                },
                {
                    "data": "pue_Nombre"
                },
                {
                    "data": "dep_Nombre"
                },
                {
                    "data": "suc_Sucursal"
                },
                {
                    // Columna de acciones
                    "data": null,
                    render: function(data, type, row) {
                        return `
                                <button class="btn btn-danger btn-icon btn-icon-mini btn-round btn-eliminar-evaluado" title="Eliminar evaluado"
                                    data-id="${row.eva_EvaluadoCuestionarioID}">
                                    <i class="zmdi zmdi-delete"></i> 
                                </button>
                                <button class="btn btn-primary btn-icon btn-icon-mini btn-round btn-asignar-nivel" title="Agregar evaluadores"
                                    data-id="${row.eva_CuestionarioID}" data-empleado="${row.emp_EmpleadoID}" data-emp="${row.emp_Nombre}">
                                    <i class="zmdi zmdi-plus"></i>
                                </button>
                            `;

                    }
                }
            ],
            dom: '<"row"<"col-md-4"l><"col-md-4 text-center"f><"col-md-4 cls-export-buttons"B>>rtip',
            buttons: [{
                    extend: 'excelHtml5',
                    title: 'Empleados Activos',
                    text: '<i class="zmdi zmdi-collection-text"></i>&nbsp;Excel',
                    titleAttr: "Exportar a excel",
                    className: "btn l-slategray btn-round",
                    autoFilter: true,
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'colvis',
                    text: 'Columnas',
                    className: "btn l-slategray btn-round"
                }
            ],
            responsive: true,
            stateSave: false,
            language: {
                paginate: {
                    previous: "<i class='zmdi zmdi-chevron-left'>",
                    next: "<i class='zmdi zmdi-chevron-right'>"
                },
                search: "_INPUT_",
                searchPlaceholder: "Buscar...",
                lengthMenu: "Registros por página _MENU_",
                info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                infoEmpty: "Mostrando 0 a 0 de 0 registros",
                zeroRecords: "No hay datos para mostrar",
                loadingRecords: "Cargando...",
                infoFiltered: "(filtrado de _MAX_ registros)",
                processing: "Procesando..."
            },
            processing: true
        });

        var tblCuestionarioEvaluadosEvaluadores = $("#tblCuestionarioEvaluadosEvaluadores").DataTable({
            destroy: true,
            lengthMenu: [
                [10, 25, 50, -1],
                [10, 25, 50, "Todos"]
            ],
            ajax: {
                url: BASE_URL + "Evaluaciones/ajax_getEvaluadosEvaluadoresCuestionario",
                type: "POST",
                dataType: "json",
                data: {
                    cuestionarioID: CuestionarioID,
                    plantillaID: "<?= $plantillaID ?>"
                }
            },
            columns: [{
                    "data": "emp_Foto",
                    render: function(data, type, row) {
                        return foto(data, type, row); // Renderiza la imagen
                    }
                },
                {
                    "data": "emp_Nombre"
                },
                {
                    "data": "pue_Nombre"
                },
                {
                    "data": "dep_Nombre"
                },
                {
                    "data": "suc_Sucursal"
                },
                {
                    "data": "evaluadores"
                },
            ],
            dom: '<"row"<"col-md-4"l><"col-md-4 text-center"f><"col-md-4 cls-export-buttons"B>>rtip',
            buttons: [{
                    extend: 'excelHtml5',
                    title: 'Evaluados-Evaluadores',
                    text: '<i class="zmdi zmdi-collection-text"></i>&nbsp;Excel',
                    titleAttr: "Exportar a excel",
                    className: "btn l-slategray btn-round",
                    autoFilter: true,
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'colvis',
                    text: 'Columnas',
                    className: "btn l-slategray btn-round"
                }
            ],
            responsive: true,
            stateSave: false,
            language: {
                paginate: {
                    previous: "<i class='zmdi zmdi-chevron-left'>",
                    next: "<i class='zmdi zmdi-chevron-right'>"
                },
                search: "_INPUT_",
                searchPlaceholder: "Buscar...",
                lengthMenu: "Registros por página _MENU_",
                info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                infoEmpty: "Mostrando 0 a 0 de 0 registros",
                zeroRecords: "No hay datos para mostrar",
                loadingRecords: "Cargando...",
                infoFiltered: "(filtrado de _MAX_ registros)",
                processing: "Procesando..."
            },
            processing: true
        });

        function fotoEvaluados(data, type, row) {
            let foto = '<img src="' + row['emp_Foto'] + '" class="rounded-circle avatar" data-lightbox="' + row['emp_Foto'] + '" data-title="" alt="">';
            return foto;
        }


        $('#tblCuestionarioEvaluados').on('click', '.btn-eliminar-evaluado', function() {
            const id = $(this).data('id'); // Obtener el ID del registro

            // Mostrar SweetAlert2
            Swal.fire({
                title: 'Confirmación',
                text: "¿Estás seguro de eliminar el empleado selecionado?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'OK',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                    // Si el usuario confirma, realizar la eliminación
                    $.ajax({
                        url: BASE_URL + "Evaluaciones/eliminarEvaluadoCuestionario",
                        type: "POST",
                        dataType: "json",
                        data: {
                            idEvaluado: id
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire(
                                    'Eliminado!',
                                    'El empleado ha sido eliminado correctamente.',
                                    'success'
                                );
                                tblCuestionarioEvaluados.ajax.reload(); // Recarga la tabla
                            } else {
                                Swal.fire(
                                    'Error!',
                                    'Hubo un problema al eliminar el empleado.',
                                    'error'
                                );
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error("Error:", error);
                            Swal.fire(
                                'Error!',
                                'No se pudo completar la operación.',
                                'error'
                            );
                        }
                    });
                }
            });
        });

        $('#tblCuestionarioEvaluados').on('click', '.btn-asignar-nivel', function() {
            const cuestionarioID = $(this).data('id');
            const evaluadoID = $(this).data('empleado');
            const empleadoNombre = $(this).data('emp');

            $('#evaluadoID').val(evaluadoID);
            $('#empleadoNombre').val(empleadoNombre);
            $('#cuestionarioID').val(cuestionarioID);
            $('#modalAsignarNivel').modal('show');
            cargarEvaluadores();
        });

        $('#tblCuestionarioEvaluados').on('click', '.btn-ver-evaluador', function() {
            const cuestionarioID = $(this).data('id');
            const evaluadoID = $(this).data('empleado');
            const empleadoNombre = $(this).data('emp');
            cargarEvaluadoresByID(cuestionarioID, evaluadoID);
            $('#modalEvaluadores').modal('show');
        });

        function cargarEvaluadores() {
            $('#empleadoID').empty().append('<option value="">Cargando...</option>');

            $.ajax({
                url: BASE_URL + 'Personal/ajax_getEmpleadosActivos',
                type: 'POST',
                dataType: 'json',
                success: function(data) {

                    // Remover mensaje de "Cargando"
                    $('#empleadoID').empty().append('<option value="">Seleccione un empleado</option>');

                    // Recorrer los resultados y añadir al select
                    data.data.forEach(function(item) {
                        $('#empleadoID').append(
                            `<option value="${item.emp_EmpleadoID}">${item.emp_Nombre} - ${item.pue_Nombre} - ${item.suc_Sucursal}</option>`
                        );
                    });
                },
                error: function() {
                    alert('Error al cargar los empleados.');
                }
            });
        }

        function cargarEvaluadoresByID(cuestionarioID, evaluadoID) {

            $.ajax({
                url: BASE_URL + 'Evaluaciones/ajax_getInfoEvaluadores',
                type: 'POST',
                data: {
                    cuestionarioID: cuestionarioID,
                    evaluadoID: evaluadoID,
                    plantillaID: "<?= $plantillaID ?>"
                },
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    $("#evaluadoNombre").val(data.data.evaluado);
                    $("#evaluadoresNombre").val(data.data.evaluadores);
                    $("#nivelEvaluacionEvaluadores").val(data.data.eva_NivelEvaluacion);
                }
            });
        }

        // Definir la función globalmente
        window.eliminarEvaluador = function(element) {
            let evaluadorID = element.getAttribute("data-evaluadorid");
            let evaluadoID = element.getAttribute("data-evaluado");
            let cuestionarioID = element.getAttribute("data-cuestionario");
            let plantillaID = element.getAttribute("data-plantilla");
            let nivel = element.getAttribute("data-nivel");

            console.log(`Eliminar evaluador ID: ${evaluadorID}, Evaluado: ${evaluadoID}`);

            $.ajax({
                url: BASE_URL + 'Evaluaciones/ajax_eliminarEvaluador',
                type: 'POST',
                data: {
                    evaluadorID: evaluadorID,
                    evaluadoID: evaluadoID,
                    cuestionarioID: cuestionarioID,
                    plantillaID: plantillaID,
                    nivel: nivel
                },
                success: function(response) {
                    if (response.success) {
                        $(element).fadeOut(); // Oculta el badge eliminado
                        tblCuestionarioEvaluadosEvaluadores.ajax.reload(); // Recarga la tabla
                        tblCuestionarioEvaluados.ajax.reload(); // Recarga la tabla
                        $.toast({
                            text: "Evaluador eliminado",
                            icon: "success",
                            position: 'top-right'
                        });
                    } else {
                        $.toast({
                            text: "Error al eliminar",
                            icon: "error",
                            position: 'top-right'
                        });
                    }
                }
            });
        };



        //Sube PDF del CV
        $("#btnGuardarAsignacion").click(function() {
            let empleadoID = $("#empleadoID").val(),
                nivelEvaluacion = $("#nivelEvaluacion").val();
            if (empleadoID && nivelEvaluacion) {
                $.ajax({
                    url: BASE_URL + "Evaluaciones/ajax_guardarNivelEvaluacionEvaluadoEvaluador/",
                    type: "POST",
                    data: new FormData($("#formAsignarNivel")[0]),
                    dataType: "json",
                    cache: false,
                    contentType: false,
                    processData: false
                }).done(data => {
                    console.log(data);
                    if (data.success == true) {
                        tblCuestionarioEvaluados.ajax.reload(); // Recarga la tabla
                        $.toast({
                            text: "¡Relación guardada correctamente!",
                            icon: "success",
                            loader: true,
                            position: 'top-right',
                            allowToastClose: false
                        });
                    } else {
                        $.toast({
                            text: "¡Ocurrió un error. Inténtalo de nuevo!",
                            icon: "warning",
                            loader: true,
                            position: 'top-right',
                            allowToastClose: false
                        });
                    }

                });
            } else {
                $.toast({
                    text: "Por favor, rellena los campos.",
                    icon: "warning",
                    loader: true,
                    position: 'top-right',
                    allowToastClose: false
                });

            }
        });




        $('.select2').select2({
            dropdownParent: $('#modalAsignarNivel .modal-body'),
            placeholder: 'Seleccione una opción',
            allowClear: true,
            width: 'resolve'
        });
    });
</script>