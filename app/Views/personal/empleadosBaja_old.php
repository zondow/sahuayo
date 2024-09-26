<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<script src="//cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>
<style>
    ul.pagination li a {
        color: white;
        background-color: rgb(112, 191, 150);
        float: left;
        padding: 8px 16px;

    }

    ul.pagination li a:hover:not(.active) {
        background-color: #ddd;
    }
</style>


<ul class="nav nav-pills navtab-bg nav-justified">
    <li class="nav-item">
        <a href="<?= base_url("Personal/empleados") ?>" class="nav-link ">
            <i class="fe-user"></i><span class="d-none d-lg-inline-block ml-2" style="font-size: 18px"><strong>Activos</strong></span>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= base_url("Personal/bajaEmpleados") ?>" class="nav-link active">
            <i class="fe-user-minus"></i> <span class="d-none d-lg-inline-block ml-2" style="font-size: 18px"><strong>Bajas</strong></span>
        </a>
    </li>
</ul>
<ul class="nav nav-tabs ">
    <li class="nav-item">
        <a href="#tarjetas" data-toggle="tab" aria-expanded="false" class="nav-link active">
            <i class="fe-credit-card"></i><span class="d-none d-sm-inline-block ml-2">Tarjetas</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="#lista" data-toggle="tab" aria-expanded="true" class="nav-link">
            <i class="fe-list"></i> <span class="d-none d-sm-inline-block ml-2">Lista</span>
        </a>
    </li>
</ul>
<div class="tab-content">
    <div class="tab-pane active" id="tarjetas">
        <div id="test-list-baja">
            <div class="row  mb-3">
                <div class="col-md-4 ">
                    <input type="text" class="search form-control float-right " placeholder="Buscar">
                </div>

                <div class="col-md-8 pt-2 text-right ">
                    <span class="text-muted text-small pt-1">Mostrando <b><?= isset($colaboradoresbaja) ? count($colaboradoresbaja) : 0 ?> </b> empleados</span>
                </div>
            </div>

            <?php if (!empty($colaboradoresbaja)) { ?>
                <ul class="list row pl-0">
                    <?php
                    foreach ($colaboradoresbaja as $colaboradorbaja) {
                    ?>
                        <div class="col-lg-4 ">
                            <div class="text-center card-box ribbon-box ">
                                <div class="member-card ">
                                    <div class="dropdown float-right">
                                        <a href="#" class="dropdown-toggle card-drop arrow-none" data-toggle="dropdown" aria-expanded="false">
                                            <h3 class="m-0 text-muted"><i class="mdi mdi-dots-horizontal"></i></h3>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="btnGroupDrop1">
                                            <a href="<?= base_url('Personal/offboarding/' . $colaboradorbaja['baj_EmpleadoID']) ?>" class="dropdown-item editar">Offboarding (salida)</a>
                                            <a class="dropdown-item fechaSalida" id="colaboradorID" data-id="<?= $colaboradorbaja['emp_EmpleadoID']?>" href="#">Fecha de salida</a>
                                        </div>
                                    </div>
                                    <div class="thumb-lg member-thumb mx-auto">
                                        <img src="<?= fotoPerfil($colaboradorbaja['emp_EmpleadoID']) ?>" class="rounded-circle avatar-xl img-thumbnail" alt="profile-image">
                                    </div>
                                    <div class="col-md-12">
                                        <h4 class="nombre"><?= $colaboradorbaja['emp_Nombre'] ?></h4>
                                        <span class="text-muted"> RFC | </span><span class="rfc"><?= $colaboradorbaja['emp_Rfc'] ?><br></span>
                                        <span class="text-muted"> Fecha de Ingreso | </span><?= shortDate($colaboradorbaja['emp_FechaIngreso'], '/') ?><br>
                                        <span class="text-muted"> Correo | </span><span class="correo"><?= $colaboradorbaja['emp_Correo'] ?></span>

                                    </div>
                                    <div class="row mt-2">
                                        <div class="col-6">
                                            <div class="mt-3">
                                                <h6 class="departamento"><?= $colaboradorbaja['dep_Nombre'] ?></h6>
                                                <p class="mb-0 text-muted">Departamento</p>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mt-3">
                                                <h6 class="puesto"><?= $colaboradorbaja['pue_Nombre'] ?></h6>
                                                <p class="mb-0 text-muted">Puesto</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center mt-2">
                                        <?php
                                        $sql = "SELECT *
                                                    FROM entrevistasalida ES
                                                    WHERE ES.ent_BajaID=?
                                                    ORDER BY ent_BajaID ASC";
                                        $entrevistaSalida = db()->query($sql, array(encryptDecrypt('decrypt', $colaboradorbaja['baj_BajaEmpleadoID'])))->getRowArray();
                                        if (is_null($entrevistaSalida)) {
                                            echo '<a href="' . base_url("Personal/entrevistaSalida/" . $colaboradorbaja['baj_BajaEmpleadoID']) . '" class="btn btn-dark btn-block waves-light waves-effect">
                                                        <i class="dripicons-clipboard"></i>&nbsp; Realizar entrevista de salida
                                                      </a>';
                                        } else {
                                            echo '<a href="' . base_url("PDF/imprimirEntrevistaSalida/" . $entrevistaSalida['ent_EntrevistaSalidaID']) . '"
                                                        class="btn btn-blue btn-block waves-light waves-effect show-pdf" data-title="Entrevista de salida">
                                                        <i class="zmdi zmdi-local-printshop"></i>&nbsp; Imprimir entrevista de salida
                                                      </a>';
                                        }

                                        echo '<a href="' . base_url("PDF/imprimirHojaLiberacion/" .  $colaboradorbaja['baj_BajaEmpleadoID']) . '"
                                                        class="btn btn-primary btn-block waves-light waves-effect show-pdf" data-title="Hoja de liberación">
                                                        <i class="zmdi zmdi-local-printshop"></i>&nbsp; Imprimir hoja de liberación
                                                    </a>';
                                        ?>

                                    </div>

                                </div>
                            </div>
                        </div> <!-- end col -->

                    <?php } ?>
                </ul>
                <ul class="pagination pagination-split mt-0 float-right">
                    <li>
                        <a class="page-item active"></a>
                    </li>
                </ul>
            <?php } else { ?>
                <div class="row ">
                    <div class="col-md-12">
                        <div class=" alert alert-info text-center"> No hay registros a mostar.</div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="tab-pane " id="lista">
        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <table id="tblEmpleadosBaja" class="table table-hover m-0 table-centered table-responsive dt-responsive" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Fecha de baja</th>
                                <th>Motivo</th>
                                <th>No. de empleado</th>
                                <th>Nombre</th>
                                <th>Puesto</th>
                                <th>Departamento</th>
                                <th>Sucursal</th>
                                <th>RFC</th>
                                <th>CURP</th>
                                <th>NSS</th>
                                <th>Correo</th>
                                <th>Dirección</th>
                                <th>Estado civil</th>
                                <th>Fecha de Ingreso</th>
                                <th>Fecha de nacimiento</th>
                                <th>Telefono</th>
                                <th>Celular</th>
                                <th>Sexo</th>
                                <th>Salario mensual</th>
                                <th>Salario mensual integrado</th>
                                <th>Codigo Postal</th>
                                <th>Ciudad</th>
                                <th>Estado</th>
                                <th>Pais</th>
                                <th>Tipo de contratación</th>
                                <th>Tipo de prestaciones</th>
                                <th>Persona emergencia</th>
                                <th>Numero de emergencia</th>
                                <th>Parentezco</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var monkeyList = new List('test-list-baja', {
        valueNames: ['nombre', 'puesto', 'departamento', 'correo', 'numero', 'rfc'],
        page: 9,
        pagination: true
    });
</script>