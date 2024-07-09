<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<?php function nombreempleado($id)
{
    return db()->query("select emp_Nombre from empleado where emp_EmpleadoID =?",array($id))->getRowArray()['emp_Nombre'];
}
$db = \Config\Database::connect();
?>
<div class="content pt-0">
    <div class="row mb-3">
        <div class="col-md-12 mt-2 ">
            <?php if (revisarPermisos('Agregar', $this)) { ?>
                <button type="button" data-toggle="modal" data-target="#addDepartamento" class="btn btn-success waves-effect waves-light"><i class="dripicons-plus" style="top: 2px !important; position: relative"></i> Agregar</button>
            <?php } ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12  text-right">
            <?php if (revisarPermisos('Exportar', $this)) { ?>
                <a href="<?= base_url('Excel/generarExcelDepartamentos'); ?>" class="btn btn-warning"><i class="mdi mdi-cloud-download"></i> Exportar</a>
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
            foreach ($departamentos as $departamento) {
                $style = '';
                $estatus = '';
                $totalColaboradores = $db->query("SELECT COUNT(*) AS 'total' FROM empleado WHERE emp_Estatus= 1 ")->getRowArray();
                $noColaboradores = $db->query("SELECT COUNT(*) AS 'total' FROM empleado WHERE emp_Estatus=1 AND emp_DepartamentoID=" . (int)$departamento['dep_DepartamentoID'])->getRowArray();
                $puestos = $db->query("SELECT DISTINCT(emp_PuestoID) as puestos FROM empleado  WHERE emp_Estatus=1 AND emp_DepartamentoID=" . (int)$departamento['dep_DepartamentoID'])->getResultArray();
                $colaboradores = $db->query("SELECT emp_Nombre , emp_EmpleadoID FROM empleado WHERE emp_Estatus=1 AND emp_DepartamentoID=" . (int)$departamento['dep_DepartamentoID'] . " ORDER BY emp_Nombre ASC LIMIT 5")->getResultArray();

                if (revisarPermisos('Baja', $this)) {
                    if ($departamento['dep_Estatus'] == 1) {
                        $estatus .= '<a class="dropdown-item activarInactivar" href="#" data-id="' . encryptDecrypt('encrypt', $departamento['dep_DepartamentoID']) . '" data-estado="0" title="Da clic para cambiar a Inactivo">
                                   Inactivo </a>';
                        if (revisarPermisos('Editar', $this)) {
                            $estatus .= '<a class="dropdown-item editar" id="departamentoID" data-id="' . encryptDecrypt('encrypt', $departamento['dep_DepartamentoID']) . '" href="#">Editar</a>';
                        }
                    } else {
                        $estatus .= '<a class="dropdown-item activarInactivar" href="#" data-id="' . encryptDecrypt('encrypt', $departamento['dep_DepartamentoID']) . '" data-estado="1" title="Da clic para cambiar a Activo">
                                    Activo</a>';
                        $style = 'style="background-color: #e6e6e6"';
                    }
                }
        ?>
                <div class="col-xl-4 card-d">
                    <div class="card-box project-box" <?= $style ?>>
                        <div class="dropdown float-right">
                            <a href="#" class="dropdown-toggle card-drop arrow-none" data-toggle="dropdown" aria-expanded="false">
                                <h3 class="m-0 text-muted"><i class="mdi mdi-dots-horizontal"></i></h3>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="btnGroupDrop1">
                                <?= $estatus ?>

                            </div>
                        </div>
                        <h6 class=" mb-2"><span class="text-dark find_Nombre"><?= $departamento['dep_Nombre'] ?></span></h6>
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <h3 class="mb-0"><?= $noColaboradores['total'] ?></h3>
                                <p class="text-muted">Colaboradores</p>
                            </li>
                            <li class="list-inline-item">
                                <h3 class="mb-0"><?= count($puestos) ?></h3>
                                <p class="text-muted">Puestos</p>
                            </li>
                        </ul>
                        <div class="project-members mb-3">
                            <?php if ($departamento['dep_JefeID'] == NULL) {
                                echo '<label class="mr-3 ">Jefe :<span class="badge badge-danger " style="position: static"> Sin asignar</span> </label>';
                            } else {
                                echo '<label class="mr-3 ">Jefe : ' . nombreempleado($departamento['dep_JefeID']);
                            } ?>
                        </div>
                        <div class="project-members mb-3">
                            <label class="mr-3">Team :</label>
                            <?php
                            if (!empty($colaboradores)) {
                                foreach ($colaboradores as $colaborador) { ?>

                                    <a href="#" data-toggle="tooltip" data-placement="top" title="" data-original-title="<?= $colaborador['emp_Nombre'] ?>">
                                        <img src="<?= fotoPerfil(encryptDecrypt('encrypt', $colaborador['emp_EmpleadoID'])) ?>" class="rounded-circle avatar-sm" alt="friend" />
                                    </a>
                            <?php  }
                            }
                            ?>
                            <?php if ($noColaboradores['total'] > 5) { ?>
                                <a data-toggle="tooltip" data-placement="top" title="">
                                    <img src="<?= base_url("assets/images/add.png") ?>" class="rounded-circle avatar-sm" alt="friend" />
                                </a>
                            <?php } ?>
                        </div>
                        <label>Colaboradores de la empresa: <span class="text-primary"><?= $noColaboradores['total'] ?>/<?= $totalColaboradores['total'] ?></span></label>
                        <div class="progress mb-1" style="height: 7px;">
                            <div class="progress-bar" role="progressbar" aria-valuenow="<?= $noColaboradores['total'] ?>" aria-valuemin="0" aria-valuemax="<?= $totalColaboradores['total'] ?>" style="width: <?= $noColaboradores['total'] ?>%;">
                            </div>
                        </div>
                    </div>
                </div><!-- end col-->
        <?php }
        } ?>
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
                        <select id="selectJefeID" name="dep_JefeID" class=" form-control" data-placeholder="Asignar jefe de departamento" style="width: 100%" required>
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
                    <input id="id" name="id" hidden>
                    <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Cancelar</button>
                    <button id="guardar" type="submit" class="btn btn-primary waves-effect waves-light guardar">Guardar</button>
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

        $('#selectJefeID').select2({
            minimumResultsForSearch: Infinity,
            minimumResultsForSearch: '',
            language: {
                noResults: function() {
                    return "No hay resultado";
                },
                searching: function() {
                    return "Buscando..";
                }
            }
        });
    });
</script>