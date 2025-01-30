<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 table-responsive">
                        <table class="dtMisCapacitaciones table table-hover m-0 dt-responsive nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Estado</th>
                                    <th>Nombre</th>
                                    <th>Imparte</th>
                                    <th>Fecha(s)</th>
                                    <th>Lugar</th>
                                    <th>Calificación</th>
                                    <th>Observaciones</th>
                                    <th width="5%">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (!empty($capacitaciones)) {
                                    foreach ($capacitaciones as $capacitacion) {
                                        // Determinar quién imparte la capacitación
                                        $imparte = "";
                                        if ($capacitacion['cap_Tipo'] === "INTERNO" && !empty($capacitacion['cap_InstructorID'])) {
                                            $instructor = db()->query("SELECT E.emp_Nombre FROM instructor I JOIN empleado E ON E.emp_EmpleadoID = I.ins_EmpleadoID WHERE I.ins_InstructorID = ?", [$capacitacion['cap_InstructorID']])->getRowArray();
                                            $imparte = $instructor['emp_Nombre'];
                                        } elseif (!empty($capacitacion['cap_ProveedorCursoID'])) {
                                            $proveedor = db()->query("SELECT pro_Nombre FROM proveedor WHERE pro_ProveedorID = ?", [$capacitacion['cap_ProveedorCursoID']])->getRowArray();
                                            $imparte = $proveedor['pro_Nombre'];
                                        }

                                        // Nombre del curso
                                        $nombre = !empty($capacitacion['cap_CursoID']) ? $capacitacion['cur_Nombre'] : $capacitacion['cap_CursoNombre'];

                                        // Fechas de la capacitación
                                        $fechasJSON = json_decode($capacitacion['cap_Fechas']);
                                        $fechas = '';
                                        foreach ($fechasJSON as $index => $fj) {
                                            $fechas .= '<span class="badge badge-info">' . shortDate($fj->fecha) . ' de ' . shortTime($fj->inicio) . ' a ' . shortTime($fj->fin) . '</span>';
                                            if ($index < count($fechasJSON) - 1) $fechas .= '<br>';
                                        }

                                        // Calificación y comprobante
                                        $calificacion = $capacitacion['cape_Calificacion'] > 0.0 ? $capacitacion['cape_Calificacion'] : '';
                                        $comprobante = '';
                                        if ($capacitacion['cape_Calificacion'] >= $capacitacion['cap_CalAprobatoria'] && db()->query("SELECT * FROM encuestacapacitacion WHERE ent_CapacitacionID = ? AND ent_EmpleadoID = ?", [$capacitacion['cape_CapacitacionID'], session('id')])->getRowArray()) {
                                            $comprobante = '<button href="' . base_url("PDF/imprimirComprobanteCapacitacion/" . encryptDecrypt('encrypt', $capacitacion['cape_CapacitacionEmpleadoID'])) . '" class="btn btn-block btn-icon btn-icon-mini btn-round hidden-sm-down mb-1 btn-success show-pdf" data-title="Comprobante de la capacitación" title="Comprobante de la capacitación"><i class="zmdi zmdi-assignment-account"></i></button><br>';
                                        }

                                        // Estado de la capacitación
                                        $estado = [
                                            'Registrada' => 'badge-info',
                                            'Enviada' => 'badge-warning',
                                            'En curso' => 'badge-success',
                                            'Terminada' => 'badge-danger'
                                        ][$capacitacion['cap_Estado']] ?? '';

                                ?>
                                        <tr>
                                            <td class="w-15"><span class="badge <?= $estado ?>"><?= $capacitacion['cap_Estado'] ?></span></td>
                                            <td><?= $nombre ?></td>
                                            <td><?= $imparte ?></td>
                                            <td><?= $fechas ?></td>
                                            <td><?= $capacitacion['cap_Lugar'] ?></td>
                                            <td><?= $calificacion ?></td>
                                            <td><?= $capacitacion['cap_Observaciones'] ?></td>
                                            <td>
                                                <button onclick="window.location.href='<?= base_url("Formacion/infoCapacitacionParticipante/" . encryptDecrypt('encrypt', $capacitacion['cap_CapacitacionID'])) ?>'" class="btn btn-warning btn-block btn-icon btn-icon-mini btn-round hidden-sm-down" title="Información de la capacitación">
                                                    <i class="fa fa-info"></i>
                                                </button>
                                                <?= $comprobante ?>
                                            </td>
                                        </tr>
                                <?php }
                                }
                                ?>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>