<?php defined('FCPATH') or exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-md-6 col-xl-6">
        <div class="card">
            <div class="company-card card-body ">
                <div class="float-left mr-3">
                    <img src="<?= fotoPerfil($colaborador['emp_EmpleadoID']) ?>" alt="logo" class="company-logo avatar-xl rounded" style="height: 8rem !important;width:8rem !important">
                </div>
                <div class="company-detail mb-4">
                    <h4 class="mb-1"><?= $colaborador['emp_Nombre'] ?></h4>
                    <p><?= $colaborador['pue_Nombre'] ?></p>
                </div><br>
                <h5 class="text-center">Progreso</h5>
                <div class="progress" style="height: 18px;">
                    <?php $porcentaje = (int)$total === 0 ? 0 : ((int)$totalCheck * 100) / (int)$total; ?>
                    <div class="progress-bar progress-bar-striped progress-bar-animated " role="progressbar" aria-valuenow="<?= $porcentaje ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $porcentaje ?>%"> <?= $porcentaje ?> %</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-6">
        <div class="card">
            <div class="company-card card-body">
                <div class="mt-2">
                    <h4 class="text-center">Checklist de egreso</h3>
                        <form action="<?= base_url("Personal/saveOffboarding") ?>" class="form" role="form" method="post" autocomplete="off">
                            <input hidden name="col" value="<?= $empleadoID ?>">
                            <div class="row mt-2 pt-3 text-justify">
                                <?php foreach ($checklist as $ck) { ?>
                                    <div class="col-lg-12 offset-lg-1">
                                        <div class="checkbox checkbox-warning checkbox-circle">
                                            <?php
                                            $catalogoID = '["' . $ck['cat_CatalogoID'] . '"]';
                                            $check = consultar_dato('checklistempleado', 'COUNT(che_ChecklistEmpleadoID) as "existe"', "JSON_CONTAINS(che_CatalogoChecklistSalidaID, '$catalogoID')");
                                            $checked = $check['existe'] == 1 ? 'checked' : '';
                                            ?>
                                            <input id="<?= $ck['cat_CatalogoID'] ?>" name="check[]" value="<?= $ck['cat_CatalogoID'] ?>" type="checkbox" <?= $checked ?>>
                                            <label for="<?= $ck['cat_CatalogoID'] ?>">
                                                <?= $ck['cat_Requerido'] == 1 ? '<b class="text-primary">' . $ck['cat_Nombre'] . '</b>' : $ck['cat_Nombre'] ?>
                                            </label>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <br>
                            <div class="col-md-12 text-right">
                                <button id="guardar" type="submit" class="btn btn-success btn-round guardar">Guardar</button>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>