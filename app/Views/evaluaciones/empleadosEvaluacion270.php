<div class="mt-3" id="test-list">

    <div class="row">
        <h3 class="col-md-4 mb-3">Mi evaluación</h3>
        <h3 class="col-md-4 mb-3"></h3>
        <h3 class="col-md-4 mb-3">Jefe</h3>

        <div class="col-md-4">
            <div class="text-center card-box ribbon-box ">
                <div class="member-card ">
                    <div class="thumb-lg member-thumb mx-auto">
                        <img src="<?= fotoPerfil(encryptDecrypt('encrypt', $empleados['empleado']['emp_EmpleadoID'])) ?>" class="rounded-circle avatar-xl img-thumbnail" alt="profile-image">
                    </div>
                    <div>
                        <h4 class="nombre"><?= $empleados['empleado']['emp_Nombre'] ?></h4>
                        <h4><span class="badge badge-blue "> Número de Empleado: <strong><?= $empleados['empleado']['emp_Numero'] ?></strong></span></h4>
                    </div>
                    <div class="mt-2">
                        <div class="row">
                            <div class="col-6">
                                <div class="mt-3">
                                    <h6 class="departamento"><?= $empleados['empleado']['are_Nombre'] ?></h6>
                                    <p class="mb-0 text-muted">Área</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mt-3">
                                    <h6 class="puesto"><?= $empleados['empleado']['pue_Nombre'] ?></h6>
                                    <p class="mb-0 text-muted">Puesto</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-2">
                        <?php

                        use App\Models\EvaluacionesModel;

                        $model = new EvaluacionesModel();
                        $realizada = $model->evaluacionDesempeno270Realizada($empleadoID, $empleados['empleado']['emp_EmpleadoID']);
                        $ocultar = (is_null($realizada)) ? '' : 'hidden';
                        ?>
                        <a href="<?= base_url("Evaluaciones/desempeno270/" . encryptDecrypt('encrypt', $empleados['empleado']['emp_EmpleadoID'])) ?>" class="btn btn-success btn-block waves-effect waves-light mb-0" <?= $ocultar ?>>
                            <i class="fe-edit"></i>&nbsp; Realizar evaluación
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <div class="text-center card-box ribbon-box ">
                <div class="member-card ">
                    <div class="thumb-lg member-thumb mx-auto">
                        <img src="<?= fotoPerfil(encryptDecrypt('encrypt', $empleados['jefe']['emp_EmpleadoID'])) ?>" class="rounded-circle avatar-xl img-thumbnail" alt="profile-image">
                    </div>
                    <div>
                        <h4 class="nombre"><?= $empleados['jefe']['emp_Nombre'] ?></h4>
                        <h4><span class="badge badge-blue "> Número de Empleado: <strong><?= $empleados['jefe']['emp_Numero'] ?></strong></span></h4>
                    </div>
                    <div class="mt-2">
                        <div class="row">
                            <div class="col-6">
                                <div class="mt-3">
                                    <h6 class="departamento"><?= $empleados['jefe']['are_Nombre'] ?></h6>
                                    <p class="mb-0 text-muted">Área</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mt-3">
                                    <h6 class="puesto"><?= $empleados['jefe']['pue_Nombre'] ?></h6>
                                    <p class="mb-0 text-muted">Puesto</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-2">
                        <?php

                        $realizada = $model->evaluacionDesempeno270Realizada($empleadoID, $empleados['jefe']['emp_EmpleadoID']);
                        $ocultar = (is_null($realizada)) ? '' : 'hidden';
                        ?>
                        <a href="<?= base_url("Evaluaciones/desempeno270/" . encryptDecrypt('encrypt', $empleados['jefe']['emp_EmpleadoID'])) ?>" class="btn btn-success btn-block waves-effect waves-light mb-0" <?= $ocultar ?>>
                            <i class="fe-edit"></i>&nbsp; Realizar evaluación
                        </a>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <ul class="list row pl-0">

        <h3 class="col-md-12 mb-3">Colegas</h3>
        <?php
        foreach ($empleados['colegas'] as $colega) {
            $realizada = $model->evaluacionDesempeno270Realizada($empleadoID, $colega['emp_EmpleadoID']);
            $ocultar = (is_null($realizada)) ? '' : 'hidden';
        ?>
            <div class="col-lg-4 ">
                <div class="text-center card-box ribbon-box ">
                    <div class="member-card ">
                        <div class="thumb-lg member-thumb mx-auto">
                            <img src="<?= fotoPerfil(encryptDecrypt('encrypt', $colega['emp_EmpleadoID'])) ?>" class="rounded-circle avatar-xl img-thumbnail" alt="profile-image">
                        </div>
                        <div>
                            <h4 class="nombre"><?= $colega['emp_Nombre'] ?></h4>
                            <h4><span class="badge badge-blue "> Número de Empleado: <strong><?= $colega['emp_Numero'] ?></strong></span></h4>
                        </div>
                        <div class="mt-2">
                            <div class="row">
                                <div class="col-6">
                                    <div class="mt-3">
                                        <h6 class="departamento"><?= $colega['are_Nombre'] ?></h6>
                                        <p class="mb-0 text-muted">Área</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mt-3">
                                        <h6 class="puesto"><?= $colega['pue_Nombre'] ?></h6>
                                        <p class="mb-0 text-muted">Puesto</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-2">
                            <a href="<?= base_url("Evaluaciones/desempeno270/" . encryptDecrypt('encrypt', $colega['emp_EmpleadoID'])) ?>" class="btn btn-success btn-block waves-effect waves-light mb-0" <?= $ocultar ?>>
                                <i class="fe-edit"></i>&nbsp; Realizar evaluación
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>

        <h3 class="col-md-12 mb-3">Subordinados</h3>
        <?php
        foreach ($empleados['subordinados'] as $subordinado) {
            $realizada = $model->evaluacionDesempeno270Realizada($empleadoID, $subordinado['emp_EmpleadoID']);
            $ocultar = (is_null($realizada)) ? '' : 'hidden';
        ?>
            <div class="col-lg-4 ">
                <div class="text-center card-box ribbon-box ">
                    <div class="member-card ">
                        <div class="thumb-lg member-thumb mx-auto">
                            <img src="<?= fotoPerfil(encryptDecrypt('encrypt', $subordinado['emp_EmpleadoID'])) ?>" class="rounded-circle avatar-xl img-thumbnail" alt="profile-image">
                        </div>
                        <div>
                            <h4 class="nombre"><?= $subordinado['emp_Nombre'] ?></h4>
                            <h4><span class="badge badge-blue "> Número de Empleado: <strong><?= $subordinado['emp_Numero'] ?></strong></span></h4>
                        </div>
                        <div class="mt-2">
                            <div class="row">
                                <div class="col-6">
                                    <div class="mt-3">
                                        <h6 class="departamento"><?= $subordinado['are_Nombre'] ?></h6>
                                        <p class="mb-0 text-muted">Área</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mt-3">
                                        <h6 class="puesto"><?= $subordinado['pue_Nombre'] ?></h6>
                                        <p class="mb-0 text-muted">Puesto</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-2">
                            <a href="<?= base_url("Evaluaciones/desempeno270/" . encryptDecrypt('encrypt', $subordinado['emp_EmpleadoID'])) ?>" class="btn btn-success btn-block waves-effect waves-light mb-0" <?= $ocultar ?>>
                                <i class="fe-edit"></i>&nbsp; Realizar evaluación
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>

    </ul>

</div>