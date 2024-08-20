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
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div  class="body table-responsive" id="contenido-puestos">
                <?php
                if (isset($puestos)) {
                    if (count($puestos)) {
                        $html = '<table class="table">
                                    <thead>
                                        <tr>
                                            <th>Puesto</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
                                    
                        foreach ($puestos as $puesto) {
                            $pueNombre = trim($puesto['pue_Nombre']) ?: "Sin nombre";
                            $puestoID = $puesto['pue_PuestoID'];
                            $perfiles = db()->query("SELECT COUNT(*) AS 'total' FROM perfilpuesto WHERE per_PuestoID=" . (int)encryptDecrypt('decrypt', $puestoID))->getRowArray();
                            $puestoPDFbtn = ($perfiles['total'] > 0) ?  base_url("PDF/perfilPuestoPdf/" . $puesto['pue_PuestoID']) : '';
                            $PerfilPuesto = ($perfiles['total'] > 0) ?  'checked' : '';
                            $styleBtnPuesto = ($perfiles['total'] > 0) ?  '' : 'btn-simple disabledPDF';

                            $html .= '<tr>
                                        <td class="find_Nombre"><strong>' . strtoupper($pueNombre) . '</strong></td>
                                        <td>';
                                            
                                            if (revisarPermisos('Editar', $this)) {
                                                $html .= '<a role="button" class="btn btn-info btn-icon  btn-icon-mini btn-round  btnCambiarNombre" data-nombre="' . $pueNombre . '" data-id="' . $puestoID . '" title="Da clic para editar el puesto" href="#"><i class="zmdi zmdi-edit pt-2"></i></a>';
                                            }
                                            if (revisarPermisos('Eliminar', $this)) {
                                                $html .= ' <a role="button" class="btn btn-danger btn-icon  btn-icon-mini btn-round  eliminar" data-id="' . $puestoID . '" title="Da clic para eliminar el puesto" href="#"><i class="zmdi zmdi-close pt-2"></i></a>';
                                            }
                                            
                           
                                            if (revisarPermisos('Perfil', $this)) {
                                                $html .= '<a role="button" class="btn btn btn-dark  btn-icon  btn-icon-mini btn-round " href="' . base_url("Catalogos/crearPerfilPuesto/" . $puestoID) . '"><i class="zmdi zmdi-assignment-account pt-2"></i></a>';
                                            }
                                        
                                            if (revisarPermisos('Perfil', $this)) {
                                                $html .= '<a role="button" class="btn btn-warning btn-icon  btn-icon-mini btn-round  ' . $styleBtnPuesto . '" href="' . $puestoPDFbtn . '"><i class="zmdi zmdi-collection-pdf pt-2"></i></a>';
                                            }
                            $html .= '</td>
                                    </tr>';
                        }

                        $html .= '</tbody>
                                </table>';

                        echo $html;
                    } else {
                        echo '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                                No hay puestos disponibles
                            </div>';
                    }
                } else {
                    echo '<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                            No hay puestos disponibles
                        </div>';
                }
                ?>
                </div>
            </div>
        </div>
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

<script>
    $(document).ready(function(e) {
        $("#txtSearch").on("keyup", function() {
            var input = document.getElementById("txtSearch");
            var filter = input.value.toUpperCase();
            var table = document.getElementById("contenido-puestos");
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