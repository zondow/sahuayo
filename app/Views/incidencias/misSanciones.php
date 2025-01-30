<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatableActas" class="table mt-4 table-hover m-0 table-centered tickets-list table-actions-bar ">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Fecha de los hechos</th>
                                <th>Fecha de registro</th>
                                <th>Observaciones</th>
                                <th>Tipo</th>
                                <th width="5%">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!empty($actas)) {
                                $count = 0;
                                $extMap = [
                                    'pdf' => '<button href="%s" class="btn btn-warning btn-icon btn-icon-mini btn-round hidden-sm-down show-pdf" data-title="Imprimir acta administrativa" style="color: white" title="Imprimir documento"><i class="zmdi zmdi-local-printshop"></i></button>',
                                    'jpg' => '<button onclick="verImagen(\'%s\', \'%s\')" class="btn btn-warning btn-icon btn-icon-mini btn-round hidden-sm-down" style="color: white" data-title="Ver acta administrativa" title="Ver imagen"><i class="zmdi zmdi-image"></i></button>',
                                    'png' => '<button onclick="verImagen(\'%s\', \'%s\')" class="btn btn-warning btn-icon btn-icon-mini btn-round hidden-sm-down" style="color: white" data-title="Ver acta administrativa" title="Ver imagen"><i class="zmdi zmdi-image"></i></button>',
                                    'jpeg' => '<button onclick="verImagen(\'%s\', \'%s\')" class="btn btn-warning btn-icon btn-icon-mini btn-round hidden-sm-down" style="color: white" data-title="Ver acta administrativa" title="Ver imagen"><i class="zmdi zmdi-image"></i></button>'
                                ];

                                foreach ($actas as $acta) {
                                    $dir = base_url() . "/assets/uploads/actasadmin/" . $acta['act_Documento'];
                                    $ext = strtolower(pathinfo($acta['act_Documento'], PATHINFO_EXTENSION));
                                    $archivo = isset($extMap[$ext]) ? sprintf($extMap[$ext], $dir, $ext) : '';

                                    $tipoMap = [
                                        'Llamada de atención verbal' => '<span class="badge badge-dark">Llamada de atención verbal</span>',
                                        'Amonestación' => '<span class="badge badge-info">Amonestación <br> (Carta Extrañamiento)</span>',
                                        'Compromiso por escrito' => '<span class="badge badge-warning">Compromiso por escrito</span>',
                                        'Acta administrativa' => '<span class="badge badge-danger">Acta administrativa</span>',
                                        'Suspension' => '<span class="badge badge-purple">Suspensión</span>'
                                    ];
                                    $tipo = $tipoMap[$acta['act_Tipo']] ?? '';

                                    echo "<tr>
                                        <td>" . ++$count . "</td>
                                        <td>".longDate($acta['act_FechaRealizo'], ' de ')."</td>
                                        <td>".longDate($acta['act_FechaRegistro'], ' de ')."</td>
                                        <td>{$acta['act_Observaciones']}</td>
                                        <td>{$tipo}</td>
                                        <td>{$archivo}</td>
                                    </tr>";
                                }
                            }
                            ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="imageModalLabel">Ver imagen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid" alt="Imagen">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(e) {
        $("#archivo").fileinput({
            showUpload: false,
            dropZoneEnabled: false,
            language: "es",
            mainClass: "input-group",
            allowedFileExtensions: ["pdf", "png", "jpeg", "jpg"]
        });
    });
</script>