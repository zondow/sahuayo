<div class="row">
    <div class="col-md-12">
        <div class="card-box">
            <div class="row m-1">
                <div class="col-md-12">
                    <label class="col-form-label"> * Colaborador: </label>
                    <select class="form-control select2" name="empleadoID" id="empleadoID" style="width: 100%" required>
                        <option value="" hidden>Seleccione un colaborador</option>
                        <?php foreach ($empleados as $empleado) { ?>
                            <option value="<?= $empleado['id'] ?>"><?= $empleado['nombre'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="row m-1 mt-5">
                <div class="col-md-12 col-xl-12">
                    <table class="table table-hover m-0 table-centered tickets-list table-actions-bar dt-responsive" cellspacing="0" width="100%" id="tPeriodos">
                        <thead>
                            <tr>
                                <th style="width: 25%">Acciones</th>
                                <th style="width: 25%">Fecha de registro</th>
                                <th style="width: 25%">Fecha de inicio</th>
                                <th style="width: 25%">Fecha de fin</th>
                            </tr>
                        </thead>
                        <tbody id="tbPeriodos">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(e) {

        $(".select2").select2();

        crearTabla();

        $('body').on('change', '#empleadoID', function(evt) {
            evt.preventDefault();

            let empleadoID = $("#empleadoID").val();

            if (empleadoID !== '') {

                $.ajax({
                    url: BASE_URL + "Evaluaciones/ajaxGetEvaluaciones",
                    type: "POST",
                    data: "empleadoID=" + empleadoID,
                    dataType: "json"
                }).done(function(data) {
                    let html = '';
                    if (data.response === "success") {

                        $.each(data.periodos, function(key, value) {
                            html += '<tr>';
                            html += '<td> ' +
                                '<a href="' + BASE_URL + "Evaluaciones/resultadoDesempeno270/" + value.evad_PeriodoID + "/" + value.evad_EmpleadoID + "/" + 1 + '" class="btn btn-success btn-block waves-light waves-effect"> ' +
                                '<i class="dripicons-print"></i>&nbsp; Ver resultados ' +
                                '</a> ' +
                                '</td>';
                            html += '<td><b>' + value.eva_FechaRegistro + '</b></td>';
                            html += '<td><b>' + value.eva_FechaInicio + '</b></td>';
                            html += '<td><b>' + value.eva_FechaFin + '</b></td>';
                            html += '</tr>';
                        });

                        $("#tPeriodos").DataTable().destroy();
                        $("#tbPeriodos").html(html);
                        crearTabla();

                        $.toast({
                            text: "Se encontraron " + data.periodos.length + " periodos",
                            icon: "success",
                            loader: true,
                            loaderBg: '#c6c372',
                            position: 'top-right',
                            allowToastClose: true,
                        });

                        //setTimeout(location.reload(), 3000);
                    }
                });
            } else {
                $.toast({
                    text: "Seleccione un empleado.",
                    icon: "warning",
                    loader: true,
                    loaderBg: '#c6c372',
                    position: 'top-right',
                    allowToastClose: true,
                });
            }

        });

        <?php if (!is_null($empleadoID)) {
            echo '$("#empleadoID").val(' . $empleadoID . ').trigger("change")';
        } ?>

        function crearTabla() {
            $("#tPeriodos").DataTable({
                language: {
                    paginate: {
                        previous: "<i class='mdi mdi-chevron-left'>",
                        next: "<i class='mdi mdi-chevron-right'>"
                    },
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla.",
                    "sInfo": "",
                    "sInfoEmpty": "",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                },
                drawCallback: function() {
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
                }
            });
        }

    });
</script>