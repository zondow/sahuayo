<?php defined('FCPATH') or exit('No direct script access allowed'); ?>

<div class="row clearfix">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="body"> 
                <!-- Nav tabs -->
                <ul class="nav nav-tabs row ">
                    <li class="nav-item col-md-6 text-center ">
                        <a href="<?= base_url("Personal/empleados") ?>" class="nav-link">Activos</a>
                    </li>
                    <li class="nav-item col-md-6 text-center ">
                        <a href="<?= base_url("Personal/bajaEmpleados") ?>" class="nav-link active" >Bajas</a>
                    </li>
                </ul>                      
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane ">
                    </div>
                    <div role="tabpanel" class="tab-pane in active" >
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="card">
                                <div class="body" >
                                    <table id="tblEmpleadosBaja" class="table table-hover m-0 table-centered table-responsive dt-responsive" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>No. de empleado</th>
                                                <th>Nombre</th>
                                                <th>Acciones</th>
                                                <th>Fecha de baja</th>
                                                <th>Motivo</th>                                                
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
