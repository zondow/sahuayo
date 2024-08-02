<?php defined("FCPATH") or die("No direct script access allowed.") ?>
<style>
        .disabledPDF {
            color: gray;
            cursor: default;
            text-decoration: none;
        }
 
    </style>
<div class="content pt-0">
    <div class="row mb-3">
        <div class="col-md-12 text-right">
            <?php if(revisarPermisos('Agregar',$this)){ ?>
            <button type="button" data-toggle="modal" data-target="#addPuesto" class="btn btn-success btn-round" ><i class="zmdi zmdi-plus"></i> Agregar</button>
            <?php } ?>
            <?php if(revisarPermisos('Exportar',$this)){ ?>
                <a href="<?= base_url("Excel/generarExcelPuestos") ?>" class="btn btn-warning btn-round" ><i class="zmdi zmdi-cloud-download"></i> Exportar</a>
            <?php } ?>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-4 pt-2 text-right">
            <input id="txtSearch" type="text" class="form-control search" placeholder="Buscar...">
        </div>
        <div class="col-md-8 pt-2 text-right ">
            <span class="text-muted text-small pt-1">Mostrando <b><?= isset($puestos) ? count($puestos) : 0 ?> </b> puestos</span>
        </div>
    </div>
    
    <div id="contenido-puestos" class="row">
        <?php
            if (isset($puestos)) {
                if (count($puestos)) {
                    foreach ($puestos as $puesto) {
                        $pueNombre = trim($puesto['pue_Nombre']) ?: "Sin nombre";
                        $puestoID = $puesto['pue_PuestoID'];
                        $perfiles = db()->query("SELECT COUNT(*) AS 'total' FROM perfilpuesto WHERE per_PuestoID=" . (int)encryptDecrypt('decrypt', $puestoID))->getRowArray();
                        $puestoPDFbtn = ($perfiles['total'] > 0) ?  base_url("PDF/perfilPuestoPdf/" . $puesto['pue_PuestoID']) : '';
                        $styleBtnPuesto = ($perfiles['total'] > 0) ?  '' : 'btn-simple disabledPDF';
            
                        $html = '
                        <div class="col-md-4 card-puesto">
                            <div class="card project_widget ">
                                <div class="header ">
                                    <p><h2><strong class="find_Nombre">' . strtoupper($puesto['pue_Nombre']) . ' </strong> </h2></p>
                                    <ul class="header-dropdown">';
                                    if (revisarPermisos('Editar', $this)) {
                                        $html .= '<li>
                                                    <a role="button" class="btnCambiarNombre" data-nombre="' . $puesto['pue_Nombre'] . '" data-id="' . $puesto['pue_PuestoID'] . '" title="Da clic para editar el puesto"><i class="zmdi zmdi-edit"></i></a>
                                                </li>';
                                    }
                                    if (revisarPermisos('Eliminar', $this)) {
                                        $html .= '<li>
                                                    <a role="button" class="eliminar" data-id="' . $puesto['pue_PuestoID'] . '" title="Da clic para eliminar el puesto"><i class="zmdi zmdi-close"></i></a>
                                                </li>';
                                    }
                                    $html .= '</ul>
                                </div>
                                <div class="body ">
                                    <div class="row">';
                                    if (revisarPermisos('Perfil', $this)) {
                                        $html .= '
                                            <div class="col-6">
                                                <a class="btn btn-dark btn-block btn-round" href="' . base_url("Catalogos/crearPerfilPuesto/" . $puesto['pue_PuestoID']) . '"><i class="zmdi zmdi-assignment-account"></i> Perfil de puesto</a>
                                            </div>
                                            <div class="col-6">
                                                <a class="btn btn-warning btn-round btn-block '.$styleBtnPuesto.'" href="' . $puestoPDFbtn . '"><i class="zmdi zmdi-collection-pdf"></i> Exportar a PDF</a>
                                            </div>';
                                    }
                        $html .= '</div>
                                </div>
                            </div>
                        </div>';
                        echo $html;
                    }
                } else {
                    echo '
                    <div class="col-md-12">
                        <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                            No hay puestos disponibles
                        </div>
                    </div>';
                }
            } else {
                echo '
                <div class="col-md-12">
                    <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                        No hay puestos disponibles
                    </div>
                </div>';
            }
            ?>
    </div>
</div>

<!--------------- Modal Agregar ----------------->
<div id="addPuesto" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Nuevo puesto</h4>
            </div>
            <form action="<?=base_url('Catalogos/addPuesto')?>" method="post" autocomplete="off" role="form">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nombre">* Nombre</label>
                        <input type="text" class="form-control" name="nombre"  placeholder="Escriba el nombre" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-light btn-round" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success btn-round">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!--------------- Modal editar puesto ----------------->
<div id="cmPuesto" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Editar puesto</h4>
            </div>
            <form action="<?=base_url('Catalogos/updateNombrePuesto')?>" method="post" autocomplete="off" role="form">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nombre">* Nombre</label>
                        <input id="cminpuestoid" name="cminpuestoid" hidden>
                        <input type="text" id="cminnombre" class="form-control" name="nombre"  placeholder="Escriba el nombre" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-md-12 text-right">
                        <button type="button" class="btn btn-light btn-round" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success btn-round">Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

