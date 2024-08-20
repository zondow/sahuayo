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

    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="body table-responsive" id="contenido-departamentos">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Departamento</th>
                                <th>Colaboradores</th>
                                <th>Puestos</th>
                                <th>Jefe</th>
                                <th>Colaboradores (Fotos)</th>
                                <th>% del Total</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
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
                                            $estatus .= '<a role="button" class="btn btn-icon  btn-icon-mini btn-round  btn-primary  activarInactivar" data-id="' . $encryptedID . '" data-estado="0" title="Da clic para cambiar a Inactivo" href="#"><i class="zmdi zmdi-check-circle pt-2"></i></a>';
                                        } else {
                                            $estatus .= '<a role="button" class="btn btn-icon  btn-icon-mini btn-round  btn-primary  activarInactivar" data-id="' . $encryptedID . '" data-estado="1" title="Da clic para cambiar a Activo" href="#"><i class="zmdi zmdi-check-circle pt-2"></i></a>';
                                            $style = 'style="background-color: #e6e6e6"';
                                        }
                                    }

                                    $jefe = $departamento['dep_JefeID'] == NULL ? '<span class="badge badge-danger"> Sin asignar</span>' : nombreEmpleadoById($departamento['dep_JefeID']);
                                    ?>
                                    <tr <?= $style ?>>
                                        <td class="find_Nombre"><strong><?= strtoupper($departamento['dep_Nombre']) ?></strong></td>
                                        <td><?= $noColaboradores['total'] ?></td>
                                        <td><?= count($puestos) ?></td>
                                        <td><?= $jefe ?></td>
                                        <td>
                                            <ul class="list-unstyled team-info">
                                                <?php
                                                if (!empty($colaboradores)) {
                                                    foreach ($colaboradores as $colaborador) { ?>
                                                        <li style="display:inline-block;">
                                                            <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?= $colaborador['emp_Nombre'] ?>">
                                                                <img src="<?= fotoPerfil(encryptDecrypt('encrypt', $colaborador['emp_EmpleadoID'])) ?>" class="rounded-circle avatar-sm" alt="friend" />
                                                            </a>
                                                        </li>
                                                <?php  }
                                                }
                                                ?>
                                            </ul>
                                        </td>
                                        <td>
                                            <?= round(($noColaboradores['total'] / $totalColaboradores['total']) * 100, 2) ?>%
                                        </td>
                                        <td>
                                            <?php if (revisarPermisos('Editar', $this)) { ?>
                                                <a role="button" class="btn btn-icon  btn-icon-mini btn-round  btn-info editar" id="departamentoID" data-id="<?= $encryptedID ?>" href="#" title="Da clic para editar"><i class="zmdi zmdi-edit pt-2"></i></a>
                                            <?php } ?>
                                            <?= $estatus ?>
                                        </td>
                                    </tr>
                                <?php
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
                        <select id="selectJefeID" name="dep_JefeID" class="chosen-select"  required>
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
            var input = document.getElementById("txtSearch");
            var filter = input.value.toUpperCase();
            var table = document.getElementById("contenido-departamentos");
            var rows = table.getElementsByTagName("tr");
        
            for (var i = 0; i < rows.length; i++) {
                var descripcionCell = rows[i].getElementsByClassName("find_Nombre")[0];
                if (descripcionCell) {
                    var txtValue = descripcionCell.textContent || descripcionCell.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        rows[i].style.display = "";
                    } else {
                        rows[i].style.display = "none";
                    }
                }       
            }
        });
    });
</script>
