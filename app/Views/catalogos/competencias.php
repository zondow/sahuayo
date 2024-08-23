
<div class="row">
    <div class="col-md-12 text-right">
        <?php if(revisarPermisos('Agregar',$this)){ ?>
        <a href="#" class="btn btn-round btn-success mt-2 mb-4 modal-competencias">
            <i class="zmdi zmdi-plus"></i>
            Agregar
        </a>
        <?php } ?>
    </div>
</div>
<div class="row clearfix" >
    <div class="col-lg-12 col-md-12 col-sm-12">
        <div class="card">
            <div class="body">
                <table class="table table-hover m-0 table-centered table-actions-bar dt-responsive" cellspacing="0" width="100%"  id="tLocales">
                    <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Tipo</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(!empty($competenciasLocales)){
                        $count=0;
                        
                        foreach ($competenciasLocales as $cLocales){
                            $style = '';
                            $estatus = '';

                            // Manejo del estatus de la competencia si se tienen permisos
                            if (revisarPermisos('Baja', $this)) {
                                $compStatus =(int)$cLocales['com_Estatus'];
                                
                                if ($compStatus === 1) {
                                    $estatus .= '<a role="button" class="btn btn-icon  btn-icon-mini btn-round btn-primary " title="Da clic para cambiar a Inactivo" href="' . base_url('Catalogos/updateCompetenciaEstatus/' .encryptDecrypt('encrypt', $cLocales['com_CompetenciaID']) . '/'.encryptDecrypt('encrypt', 0)) . '"><i class="zmdi zmdi-check-circle pt-2"></i></a>';
                                } else {
                                    $estatus .= '<a role="button" class="btn btn-icon  btn-icon-mini btn-round btn-primary "  title="Da clic para cambiar a Activo" href="' . base_url('Catalogos/updateCompetenciaEstatus/' . encryptDecrypt('encrypt', $cLocales['com_CompetenciaID']) . '/'.encryptDecrypt('encrypt', 1)) . '" ><i class="zmdi zmdi-check-circle pt-2"></i></a>';
                                    $style = 'style="background-color: #e6e6e6"';
                                }
                            }

                            echo '<tr '.$style.'>';
                            echo '<td class="w-15"><b>'.$cLocales['com_Nombre'].'</b></td>';
                            echo '<td class="w-50"><div class="col-md-12"><p style="text-align: justify">'.$cLocales['com_Descripcion'].'</p></div></td>';
                            if($cLocales['com_Tipo'] == 'Sociales y Actitudinales'){
                                echo '<td class="w-15"><label class="badge badge-success">'.$cLocales['com_Tipo'].'</label></td>';
                            }else {
                                echo '<td class="w-15"><label class="badge badge-secondary">'.$cLocales['com_Tipo'].'</label></td>';
                            }
                            echo '<td class="text-center ">';
                            if(revisarPermisos('Editar',$this)) {
                                echo '<a href="#" class="btn btn-info btn-icon  btn-icon-mini btn-round modal-competencias" data-id="' . $cLocales['com_CompetenciaID'] . '"><i class="zmdi zmdi-edit pt-2 "></i></a>';
                            }
                            /*if(revisarPermisos('Claves',$this)) {
                                echo '<a href="#" class="btn btn-dark btn-icon  btn-icon-mini btn-round  veraclave" title="Acciones clave" data-id="' . $cLocales['com_CompetenciaID'] . '"><i class="zmdi zmdi-check-square"></i></a>';
                            }*/
                                echo $estatus ;
                            echo  '</td>';
                            echo '</tr>';
                        }
                    }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

