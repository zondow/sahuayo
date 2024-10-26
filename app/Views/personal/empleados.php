


<div class="content pt-0">
    <div class="row mb-3">
        <div class="col-md-12 mt-2 text-right">
            <?php if (revisarPermisos('Agregar', 'empleados')) { ?>
                <a href="#" class="btn btn-success btn-round modal-colaborador"> <i class="zmdi zmdi-plus"></i> Agregar </a>
            <?php } ?>
            <?php 
             if(revisarPermisos('Exportar', 'empleados')){ ?>
                <a href="<?= base_url('Excel/generarExcelTodosEmpleados');?>" class="btn btn-info btn-round" ><i class="zmdi zmdi-cloud-download"></i> Exportar Todos</a>
            <?php } ?>
        </div>
    </div>
</div>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="body"> 
                <!-- Nav tabs -->
                <ul class="nav nav-tabs row ">
                    <li class="nav-item col-md-6 text-center ">
                        <a href="<?= base_url("Personal/empleados") ?>" class="nav-link active"  >Activos</a>
                    </li>
                    <li class="nav-item col-md-6 text-center ">
                        <a href="<?= base_url("Personal/bajaEmpleados") ?>" class="nav-link" >Bajas</a>
                    </li>
                </ul>                      
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane in active">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="card">
                                <div class="body" >
                                    <table  id="tblEmpleados" class=" table table-hover m-0 table-centered table-responsive dt-responsive  " cellspacing="0" width="100%" >
                                        <thead>
                                        <tr>
                                            <th>Foto</th>
                                            <th>No. de empleado</th>
                                            <th>Acciones</th>
                                            <th>Nombre</th>
                                            <th>Jefe</th>
                                            <th>Correo</th>
                                            <th>Puesto</th>
                                            <th>Departamento</th>
                                            <th>Sucursal</th>
                                            <th>Dirección</th>
                                            <th>CURP</th>
                                            <th>RFC</th>
                                            <th>NSS</th>
                                            <th>Estado Civil</th>
                                            <th>Fecha de Ingreso</th>
                                            <th>Fecha de Nacimiento</th>
                                            <th>Telefono</th>
                                            <th>Celular</th>
                                            <th>Sexo</th>
                                            <th>Salario Mensual</th>
                                            <th>Salario Mensual Integrado</th>
                                            <th>C.P.</th>
                                            <th>Ciudad</th>
                                            <th>Estado</th>
                                            <th>País</th>
                                            <th>Tipo de Contrato</th>
                                            <th>Tipo de Prestación</th>
                                            <th>Rol</th>
                                            <th>Horario</th>
                                            <th>Número de Emergencia</th>
                                            <th>Persona de Emergencia</th>
                                            <th>Parentesco de Emergencia</th>
                                        </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" > <b>Profile Content</b>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="card">
                                <div class="body" >
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
            </div>
        </div>
    </div>
</div>
