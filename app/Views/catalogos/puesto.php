<?php defined("FCPATH") or die("No direct script access allowed.") ?>
<style>
    #txtSearch{
    }
</style>
<div class="content pt-0">
    <div class="row mb-3">
        <div class="col-md-12 mt-1 ">
            <?php if(revisarPermisos('Agregar',$this)){ ?>
            <button type="button" data-toggle="modal" data-target="#addPuesto" class="btn btn-success waves-effect waves-light mb-2" ><i class="mdi mdi-plus"></i> Agregar</button>
            <?php } ?>
        </div>
        <div class="col-md-12 text-right ">
            <?php if(revisarPermisos('Exportar',$this)){ ?>
                <a href="<?= base_url("Excel/generarExcelPuestos") ?>" class="btn btn-warning " ><i class="mdi mdi-cloud-download"></i> Exportar</a>
            <?php } ?>
        </div>
        <div class="col-md-3 pt-2">
            <input id="txtSearch" type="text" class="form-control search" placeholder="Buscar...">
        </div>
        <div class="col-md-9 text-right pt-2">
            <span class="text-muted text-small pt-1">Mostrando <b><?=isset($puestos) ? count($puestos): 0?> </b> puestos</span>
        </div>
    </div>
    <div id="contenido-puestos" class="row">
        <?php
            if(isset($puestos)){
                if(count($puestos)){
                    foreach($puestos as $puesto){
                        $pueNombre = trim($puesto['pue_Nombre']) ? trim($puesto['pue_Nombre']) : "Sin nombre";
                        $puestoID=$puesto['pue_PuestoID'];
                        //$competencias=db()->query("SELECT COUNT(*) AS 'total' FROM competenciapuesto WHERE cmp_PuestoID=".(int)encryptDecrypt('decrypt',$puestoID))->getRowArray();
                        $puestoPDFbtn="";
                        $perfiles=db()->query("SELECT COUNT(*) AS 'total' FROM perfilpuesto WHERE per_PuestoID=".(int)encryptDecrypt('decrypt',$puestoID))->getRowArray();
                        if((int)$perfiles['total']>0){
                            $puestoPDFbtn='<a class="btn btn-warning btn-block waves-light mb-3 " href="'.base_url("PDF/perfilPuestoPdf/".$puesto['pue_PuestoID']).'"><i class="fas fa-file-pdf "></i> Exportar a PDF</a>';
                        }

                        $html = '
                        <div class="col-md-4 card-puesto" >
                            <div class="company-card card-box ribbon-box" >
                                <div class="dropdown float-right">
                                        <a href="#" class="dropdown-toggle card-drop arrow-none" data-toggle="dropdown"
                                           aria-expanded="false">
                                            <h3 class="m-0 text-muted"><i class="mdi mdi-dots-horizontal"></i></h3>
                                        </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="btnGroupDrop1">';
                                    if(revisarPermisos('Editar',$this))
                                        $html .='<a class="dropdown-item btnCambiarNombre" href=""data-nombre="'.$puesto['pue_Nombre'].'"  data-id="'.$puesto['pue_PuestoID'].'" title="Da clic para cambiar el nombre del puesto" >Editar</a>';
                                    if(revisarPermisos('Eliminar',$this))
                                        $html .=   '<a class="dropdown-item eliminar" href="#" data-id="'. $puesto['pue_PuestoID'] .'"  title="Da clic para eliminar el puesto"> Eliminar </a>';
                                    //$html .=   '<a class="dropdown-item" href="' . base_url("Catalogos/checklistSalida/" . $puesto['pue_PuestoID']) . '"> Checklist salida </a>';
                        $html .=  '</div>
                                </div>
                                <br><br>
                                <div class="company-detail mb-3 col-md-12 text-center" >
                                    <h1><i class="dripicons-article"></i></h1>
                                </div>
                                <div class="company-detail mb-3 text-center">
                                    <h4 class="mb-1 find_Nombre">'.$pueNombre.'</h4>
                                </div>
                                <div class="text-center">';
                                if(revisarPermisos('Perfil',$this)) {
                                    $html .= '<a class="btn btn-dark btn-block waves-light waves-effect" href="' . base_url("Catalogos/crearPerfilPuesto/" . $puesto['pue_PuestoID']) . '"><i class="dripicons-clipboard"></i> Perfil de puesto</a>
                                         ' . $puestoPDFbtn;
                                }
                                $html.='</div>
                            </div>
                        </div>';
                        echo $html;
                    }//foreach
                }
                else
                {
                    echo '
                    
                    <div class="col-md-12" >
                        <div class="alert alert-danger alert-dismissible fade show text-center" 
                        role="alert">
                            No hay puestos disponibles  
                        </div>
                    </div>';
                }//if count
            }
            else
            {
                echo '
                  
                    <div class="col-md-12" >
                        <div class="alert alert-danger alert-dismissible fade show text-center" 
                        role="alert">
                            No hay puestos disponibles  
                        </div>
                    </div>';
            }//if isset
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
                    <!--<div class="form-group">
                        <label for="nivel">* Nivel</label>
                        <select id="nivel" name="nivel" class="select2 form-control" data-placeholder="Seleccionar" style="width: 100%" required>
                            <option value="1"> 1</option>
                            <option value="2"> 2</option>
                            <option value="3A"> 3A</option>
                            <option value="3A1">3A1</option>
                            <option value="3B"> 3B</option>
                            <option value="4A"> 4A</option>
                            <option value="4B"> 4B</option>
                            <option value="4C"> 4C</option>
                            <option value="4C1"> 4C1</option>
                            <option value="5A"> 5A</option>
                            <option value="5B"> 5B</option>
                            <option value="5B1"> 5B1</option>
                            <option value="5C"> 5C</option>
                            <option value="5D"> 5D</option>
                            <option value="5D1"> 5D1</option>
                            <option value="5E"> 5E</option>
                        </select>
                    </div>-->
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--------------- Modal cambiar nombre ----------------->
<div id="cmPuesto" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Cambiar nombre</h4>
            </div>
            <form action="<?=base_url('Catalogos/updateNombrePuesto')?>" method="post" autocomplete="off" role="form">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nombre">* Nombre</label>
                        <input id="cminpuestoid" name="cminpuestoid" hidden>
                        <input type="text" id="cminnombre" class="form-control" name="nombre"  placeholder="Escriba el nombre" required>
                    </div>
                    <!--<div class="form-group">
                        <label for="nivele">* Nivel</label>
                        <select id="nivele" name="nivele" class="select2 form-control" data-placeholder="Seleccionar" style="width: 100%" required>
                            <option value="1"> 1</option>
                            <option value="2"> 2</option>
                            <option value="3A"> 3A</option>
                            <option value="3A1">3A1</option>
                            <option value="3B"> 3B</option>
                            <option value="4A"> 4A</option>
                            <option value="4B"> 4B</option>
                            <option value="4C"> 4C</option>
                            <option value="4C1"> 4C1</option>
                            <option value="5A"> 5A</option>
                            <option value="5B"> 5B</option>
                            <option value="5B1"> 5B1</option>
                            <option value="5C"> 5C</option>
                            <option value="5D"> 5D</option>
                            <option value="5D1"> 5D1</option>
                            <option value="5E"> 5E</option>
                        </select>
                    </div>-->
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function (e) {
        $("#txtSearch").on("keyup", function() {

            var  a; var i; var txtValue;
            var input = document.getElementById("txtSearch");
            var filter = input.value.toUpperCase();
            var contenido = document.getElementById("contenido-puestos");
            var carPuestos = contenido.getElementsByClassName("card-puesto");

            for (i = 0; i < carPuestos.length; i++) {
                a = carPuestos[i].getElementsByClassName("find_Nombre")[0];
                txtValue = a.textContent || a.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    carPuestos[i].style.display = "";
                } else {
                    carPuestos[i].style.display = "none";
                }
            }//for
        });
    });
</script>