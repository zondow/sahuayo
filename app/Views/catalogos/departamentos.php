<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<?php
$db = \Config\Database::connect();
?>
<div class="content pt-0">
    <div class="row mb-3">
        <div class="col-md-12 text-right">
            <?php if (revisarPermisos('Agregar', $this)) { ?>
                <button type="button" data-toggle="modal" data-target="#addDepartamento" class="btn btn-success btn-round"> <i class="zmdi zmdi-plus"></i> Agregar </button>
            <?php } ?>
            <?php if (revisarPermisos('Exportar', $this)) { ?>
                <a href="<?= base_url('Excel/generarExcelDepartamentos'); ?>" class="btn btn-warning btn-round"><i class="zmdi zmdi-cloud-download"></i> Exportar</a>
            <?php } ?>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4 pt-2 text-right">
            <input id="txtSearch" type="text" class="form-control search" placeholder="Buscar...">
        </div>
        <div class="col-md-8 pt-2 text-right ">
            <span class="text-muted text-small pt-1">Mostrando <b><?= isset($departamentos) ? count($departamentos) : 0 ?> </b> departamentos</span>
        </div>
    </div>

    <div class="row" id="contenido-departamentos">
    <?php
        if (!empty($departamentos)) {
            $totalColaboradores = $db->query("SELECT COUNT(*) AS 'total' FROM empleado WHERE emp_Estatus=1")->getRowArray();
            foreach ($departamentos as $departamento) {
                $style = '';
                $estatus = '';
            
                $departamentoID = (int)$departamento['dep_DepartamentoID'];
                $noColaboradores = $db->query("SELECT COUNT(*) AS 'total' FROM empleado WHERE emp_Estatus=1 AND emp_DepartamentoID=$departamentoID")->getRowArray();
                $puestos = $db->query("SELECT DISTINCT(emp_PuestoID) AS puestos FROM empleado WHERE emp_Estatus=1 AND emp_DepartamentoID=$departamentoID")->getResultArray();
                $colaboradores = $db->query("SELECT emp_Nombre, emp_EmpleadoID FROM empleado WHERE emp_Estatus=1 AND emp_DepartamentoID=$departamentoID ORDER BY emp_Nombre ASC LIMIT 5")->getResultArray();
                
                if (revisarPermisos('Baja', $this)) {
                    $depStatus = (int)$departamento['dep_Estatus'];
                    $encryptedID = encryptDecrypt('encrypt', $departamentoID);
                    
                    if ($depStatus == 1) {
                        $estatus .= '<a role="button" class="activarInactivar" data-id="' . $encryptedID . '" data-estado="0" title="Da clic para cambiar a Inactivo"><i class="zmdi zmdi-check-circle"></i></a>';
                                
                    } else {
                        $estatus .= '<a role"button" class="activarInactivar" data-id="' . $encryptedID . '" data-estado="1" title="Da clic para cambiar a Activo"><i class="zmdi zmdi-check-circle"></i></a>';
                        $style = 'style="background-color: #e6e6e6"';
                    }
                }
                ?>
                <div class="col-lg-4 col-md-6 col-sm-12 card-d">
                    <div class="card project_widget " <?= $style ?>>
                        <div class="header">
                            <p><h2><strong class="find_Nombre"><?= strtoupper($departamento['dep_Nombre']) ?> </strong> </h2></p>
                            <ul class="header-dropdown">
                                <?php if (revisarPermisos('Editar', $this)) { ?>
                                    <li class="edit">
                                        <a role="button" class="editar" id="departamentoID" data-id="<?= $encryptedID?>" href="#" title="Da clic para editar"><i class="zmdi zmdi-edit"></i></a>
                                    </li>
                               <?php } ?>
                               <li>
                                <?=$estatus?>
                               </li>
                                
                            </ul>
                        </div>
                        
                        <div class="body">
                            <div class="row">
                                <div class="col-6">
                                    <h5><?= $noColaboradores['total'] ?></h5>
                                    <small>Colaboradores</small>
                                </div>
                                <div class="col-6">
                                    <h5><?=count($puestos)?></h5>
                                    <small>Puestos</small>
                                </div>                        
                            </div>
                            <ul class="list-unstyled team-info ">
                                <?php if ($departamento['dep_JefeID'] == NULL) {
                                    echo '<label">Jefe :  <span class="badge badge-danger"> Sin asignar</span> </label>';
                                } else {
                                    echo '<label">Jefe : ' . nombreEmpleadoById($departamento['dep_JefeID']);
                                } ?>
                            </ul>
                            <ul class="list-unstyled team-info m-t-20">
                                <li class="m-r-15"><small>Team</small></li>
                                <?php
                                if (!empty($colaboradores)) {
                                    foreach ($colaboradores as $colaborador) { ?>
                                        <li>
                                            <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?= $colaborador['emp_Nombre'] ?>">
                                                <img src="<?= fotoPerfil(encryptDecrypt('encrypt', $colaborador['emp_EmpleadoID'])) ?>" class="rounded-circle avatar-sm" alt="friend" />
                                            </a>
                                        </li>
                                <?php  }
                                }
                                ?>
                            </ul>
                            <div class="progress-container">
                                <span class="progress-badge">Colaboradores</span>
                                <div class="progress">
                                    <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="<?= ($noColaboradores['total'] / $totalColaboradores['total']) * 100 ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= ($noColaboradores['total'] / $totalColaboradores['total']) * 100 ?>%;">
                                        <span class="progress-value"><?= round(($noColaboradores['total'] / $totalColaboradores['total']) * 100, 2) ?>%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- end col-->
                <?php
            }
        }
        ?>

    </div>
</div>

<!--------------- Modal  ----------------->
<div id="addDepartamento" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Nuevo departamento</h4>
            </div>
            <form id="departamento" action="<?= base_url('Catalogos/addDepartamento') ?>" method="post" autocomplete="off" role="form">
                <div id="dep" class="modal-body">
                    <div class="form-group">
                        <label for="nombre">* Nombre</label>
                        <input type="text" id="nombre" class="form-control" name="nombre" placeholder="Escriba el nombre" required>
                    </div>
                    <div class="form-group">
                        <label for="selectJefeID">* Jefe del departamento </label>
                        <select id="selectJefeID" name="dep_JefeID" class=" select2 form-control"  required>
                            <option hidden value=""></option>
                            <?php
                            if (!empty($empleados)) {
                                foreach ($empleados as $empleado) { ?>
                                    <option value="<?= $empleado['emp_EmpleadoID']; ?>"><?= $empleado['emp_Nombre']; ?></option>
                            <?php }
                            } else {
                                echo '<option value="" disabled>No hay empleados disponibles</option>';
                            } ?>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-md-12 text-right">
                        <input id="id" name="id" hidden>
                        <button type="button" class="btn btn-light btn-round" data-dismiss="modal">Cancelar</button>
                        <button id="guardar" type="submit" class="btn btn-success btn-round guardar">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(e) {
        $("#txtSearch").on("keyup", function() {
            var a;
            var i;
            var txtValue;
            var input = document.getElementById("txtSearch");
            var filter = input.value.toUpperCase();
            var contenido = document.getElementById("contenido-departamentos");
            var card = contenido.getElementsByClassName("card-d");

            for (i = 0; i < card.length; i++) {
                a = card[i].getElementsByClassName("find_Nombre")[0];
                txtValue = a.textContent || a.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    card[i].style.display = "";
                } else {
                    card[i].style.display = "none";
                }
            } //for
        });


       $(".select2").select2({
            closeOnSelect: true,
            dropdownParent: $("#addDepartamento"),
            minimumResultsForSearch: 0,
       });

    });
</script>