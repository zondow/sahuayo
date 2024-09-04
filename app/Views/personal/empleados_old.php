<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<style>
    ul.pagination li a {
        color: white;
        background-color: rgb(112, 191, 150);
        float: left;
        padding: 8px 16px;

    }
    ul.pagination li a:hover:not(.active) {background-color: #ddd;}
</style>
<script src="//cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>

<ul class="nav nav-pills navtab-bg nav-justified">
    <li class="nav-item">
        <a href="<?= base_url("Personal/empleados") ?>" class="nav-link active">
            <i class="fe-user"></i><span class="d-none d-lg-inline-block ml-2" style="font-size: 18px"><strong>Activos</strong></span>
        </a>
    </li>
    <li class="nav-item">
        <a href="<?= base_url("Personal/bajaEmpleados") ?>" class="nav-link ">
            <i class="fe-user-minus"></i> <span class="d-none d-lg-inline-block ml-2" style="font-size: 18px"><strong>Bajas</strong></span>
        </a>
    </li>
</ul>
<div class="tab-content">
    <div class="row mb-1">
        <div class="col-md-8 text-left">
            <?php if(revisarPermisos('Agregar',$this)){ ?>
            <a href="#" class="btn btn-success waves-light waves-effect modal-colaborador">
                <i class="dripicons-plus" style="top: 2px !important; position: relative"></i>
                Nuevo empleado
            </a>
            <?php } ?>
        </div>
        <div class="col-md-4 text-right">
            <?php if(revisarPermisos('Exportar',$this)){ ?>
            <a href="<?= base_url('Excel/generarExcelDirectorioEmpleados');?>" class="btn btn-secondary" ><i class="mdi mdi-cloud-download"></i> Directorio</a>
            <?php } ?>
        </div>
    </div>
    <div class="row  mb-2 text-right">
        <div class="col-md-4 offset-8 text-right mb-1">
            <?php if(revisarPermisos('Exportar',$this)){ ?>
            <a href="<?= base_url('Excel/generarExcelEmpleados');?>" class="btn btn-warning" ><i class="mdi mdi-cloud-download"></i> Exportar</a>
            <?php } ?>
        </div>
        <div class="col-md-4 offset-8 text-right">
            <?php if(revisarPermisos('Exportar',$this)){ ?>
            <a href="<?= base_url('Excel/generarExcelTodosEmpleados');?>" class="btn btn-info" ><i class="mdi mdi-cloud-download"></i> Exportar Todos</a>
            <?php } ?>
        </div>
    </div>

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
            <div id="test-list">
                <div class="row  mb-3">
                    <div class="col-md-4 " >
                        <input type="text" class="search form-control float-right " placeholder="Buscar">
                    </div>

                    <div class="col-md-8 pt-2 text-right ">
                        <span class="text-muted text-small pt-1">Mostrando <b><?=isset($colaboradores) ? count($colaboradores): 0?> </b> empleados</span>
                    </div>
                </div>
                <ul class="list row pl-0">
                    <?php
                    foreach ($colaboradores as $colaborador){
                        if($colaborador['emp_Estado']=== 'Activo')$badge='<span class="badge badge-success" >'.$colaborador['emp_Estado'].'</span>';
                        else $badge='<span class="badge badge-danger" >'.$colaborador['emp_Estado'].'</span>';
                        ?>
                        <div class="col-lg-4 ">
                            <div class="text-center card-box ribbon-box ">
                                <div class="dropdown float-right">
                                    <a href="#" class="dropdown-toggle card-drop arrow-none" data-toggle="dropdown" aria-expanded="false">
                                        <h3 class="m-0 text-muted"><i class="mdi mdi-dots-horizontal"></i></h3>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="btnGroupDrop1">
                                        <?php if(revisarPermisos('Editar',$this)){ ?>
                                        <a class="dropdown-item editar" id="colaboradorID" data-id="<?= $colaborador['emp_EmpleadoID']?>" href="#">Editar</a>
                                        <?php } ?>
                                        <?php if(revisarPermisos('Acceso',$this)){ ?>
                                        <a class="dropdown-item acceso" id="colaboradorID" data-id="<?= $colaborador['emp_EmpleadoID']?>" href="#">Datos de acceso</a>
                                        <?php } ?>
                                        <?php if(revisarPermisos('Contratos',$this)){ ?>
                                        <a class="dropdown-item" href="<?=base_url("Personal/contrato/".$colaborador['emp_EmpleadoID'])?>">Contrato</a>
                                        <?php } ?>
                                        <?php if(revisarPermisos('Onboarding',$this)){ ?>
                                        <a class="dropdown-item" href="<?=base_url("Personal/onboarding/".$colaborador['emp_EmpleadoID'])?>">Onboarding (entrada)</a>
                                        <?php } ?>
                                        <?php if(revisarPermisos('Expediente',$this)){ ?>
                                        <a class="dropdown-item "  href="<?=base_url("Personal/expediente/".$colaborador['emp_EmpleadoID']."/".encryptDecrypt('encrypt',(int)session("id")))?>">Expediente</a>
                                        <?php } ?>
                                       <!-- <?php /*if(revisarPermisos('Kardex',$this)){ */?>
                                        <a class="dropdown-item show-pdf" data-title="Kardex" href="<?/*=base_url("PDF/reporteKardex/".$colaborador['emp_EmpleadoID'])*/?>">Kardex</a> -->
                                        <?php /*} */?>
                                        <?php if(revisarPermisos('Baja',$this)){ ?>
                                        <a class="dropdown-item" data-action="dar de baja al empleado seleccionado" href="<?=base_url("Personal/formBajaEmpleado/".$colaborador['emp_EmpleadoID'])?>">Dar de baja</a>
                                        <?php } ?>
                                       <?php if(revisarPermisos('Suspender',$this)){ ?>
                                            <a class="dropdown-item activarSuspender" data-estado="<?= $colaborador['emp_Estado']?>" data-id="<?= $colaborador['emp_EmpleadoID']?>" href="#">Cambiar estado</a>
                                       <?php } ?>
                                        <?php if(revisarPermisos('Foto',$this)){ ?>
                                        <a class="dropdown-item btnModalFoto"  data-id="<?= $colaborador['emp_EmpleadoID']?>" href="#">Foto</a>
                                        <?php } ?>
                                        <a class="dropdown-item show-pdf" data-title="Kardex" href="<?=base_url('PDF/reporteIncidencias/'.$colaborador['emp_EmpleadoID'])?>" >Kardex</a>
                                    </div>
                                </div>
                                <div class="member-card ">
                                    <div class="thumb-lg member-thumb mx-auto">
                                        <img src="<?=fotoPerfil($colaborador['emp_EmpleadoID'])?>" class="rounded-circle avatar-xl img-thumbnail" alt="profile-image">
                                    </div>
                                    <div >
                                        <h4 class="nombre"><?= $colaborador['emp_Nombre']?></h4>
                                        <h4 class="numero"><span class="badge badge-blue "> Número de Empleado: <strong><?= $colaborador['emp_Numero']?></strong></span></h4>

                                        <span class="text-muted" > RFC | </span><span class="rfc"><?= $colaborador['emp_Rfc']?><br></span>
                                        <span class="text-muted" > Fecha de Ingreso | </span><?= shortDate($colaborador['emp_FechaIngreso'], '/')?><br>
                                        <span class="text-muted" > Correo | </span><span class="correo"><?= $colaborador['emp_Correo']?></span><br>
                                        <span class="text-muted" > Celular | </span><span class="celular"><?= $colaborador['emp_Celular']?></span><br>
                                        <?=$badge?>

                                    </div>
                                    <div class="mt-2">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mt-3">
                                                    <h6 class="puesto"><?= $colaborador['pue_Nombre']?></h6>
                                                    <p class="mb-0 text-muted">Puesto</p>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mt-3">
                                                    <h6 class="departamento"><?= $colaborador['dep_Nombre']?></h6>
                                                    <p class="mb-0 text-muted">Departamento</p>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h6 class="area"><?= $colaborador['suc_Sucursal']?></h6>
                                                <p class="mb-0 text-muted">Sucursal</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end col -->

                        <?php
                    }
                    ?>

                </ul>
                <ul class="pagination pagination-split mt-0 float-right">
                    <li>
                        <a class="page-item active"></a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="tab-pane " id="lista">
            <div class="row">
                <div class="col-12">
                    <div class="card-box ">
                        <table id="tblEmpleados" class=" table table-hover m-0 table-centered table-responsive dt-responsive " cellspacing="0" width="100%" >
                            <thead>
                            <tr>
                                <th></th>
                                <th>No. de empleado</th>
                                <th>Nombre</th>
                                <th>Puesto</th>
                                <th>Area</th>
                                <th>Departamento</th>
                                <th>Sucursal</th>
                                <th>RFC</th>
                                <th>Correo</th>
                                <th>Celular</th>
                                <th>Estado</th>
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
</div>

<script>
    var monkeyList = new List('test-list', {
        valueNames: ['nombre','puesto','area','departamento','correo','numero','rfc','celular'],
        page: 9,
        pagination: true
    });



</script>




