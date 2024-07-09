<div class="row">
    <div class="col-xl-12">
        <div class="card-box">
            <div class="row">
                <div class="col-md-12 table-responsive">
                    <table class="dtMisCapacitaciones table table-hover m-0 dt-responsive nowrap" cellspacing="0" width="100%" >
                        <thead>
                        <tr>
                            <th width="5%" >Acciones</th>
                            <th>Estado</th>
                            <th>Nombre</th>
                            <th>Imparte</th>
                            <th>Fecha(s)</th>
                            <th>Lugar</th>
                            <th>Calificación</th>
                            <th>Observaciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if(!empty($capacitaciones)){
                            $imparte="";
                            foreach ($capacitaciones as $capacitacion) {
                                if($capacitacion['cap_Tipo'] === "INTERNO"){
                                    if(!empty($capacitacion['cap_InstructorID'])) {
                                        $instructor = db()->query("SELECT I.*, E.emp_Nombre FROM instructor I 
                                        JOIN empleado E ON E.emp_EmpleadoID=I.ins_EmpleadoID
                                        WHERE ins_InstructorID=" . $capacitacion['cap_InstructorID'])->getRowArray();
                                        $imparte=$instructor['emp_Nombre'];
                                    }
                                }else{
                                    if(!empty($capacitacion['cap_ProveedorCursoID'])) {
                                        $proveedor = db()->query("SELECT * FROM proveedor WHERE pro_ProveedorID=" . $capacitacion['cap_ProveedorCursoID'])->getRowArray();
                                        $imparte=$proveedor['pro_Nombre'];
                                    }
                                }

                                if(!empty($capacitacion['cap_CursoID']))$nombre=$capacitacion['cur_Nombre'];
                                else $nombre=$capacitacion['cap_CursoNombre'];
                                $fechasJSON = json_decode($capacitacion['cap_Fechas']);
                                $fechas ='';
                                $totalFJ=count($fechasJSON);$i=0;
                                $fechaFin = '';
                                foreach($fechasJSON as $fj){
                                    $fechas.= '<span class="badge badge-dark">'.shortDate($fj->fecha).' de '.shortTime($fj->inicio).' a '.shortTime($fj->fin).'</span>';
                                    $i++;
                                    if($i<$totalFJ) $fechas.='<br>';
                                    if ($i == $totalFJ) $fechaFin = $fj->fecha;
                                }

                                $encuesta = db()->query("SELECT * FROM encuestacapacitacion WHERE ent_CapacitacionID=".$capacitacion['cape_CapacitacionID']. " AND ent_EmpleadoID=".session('id'))->getRowArray();
                                $comprobante='';
                                if($capacitacion['cape_Calificacion'] >= $capacitacion['cap_CalAprobatoria'] && $encuesta){
                                    $comprobante='<a href="'.base_url("PDF/imprimirComprobanteCapacitacion/".encryptDecrypt('encrypt',$capacitacion['cape_CapacitacionEmpleadoID'])).'" class="btn btn-block mb-1  btn-sm btn-warning waves-light waves-effect show-pdf" data-title="Comprobante de la capacitación" title="Comprobante de la capacitación"><i class=" mdi mdi-medal"></i></a><br>';
                                }
                                if($capacitacion['cape_Calificacion']>0.0){
                                    $calificacion = $capacitacion['cape_Calificacion'];
                                }else{
                                    $calificacion ='';
                                }

                                ?>
                                <tr>
                                    <td>
                                        <a href="<?=base_url("Formacion/infoCapacitacionParticipante/".encryptDecrypt('encrypt',$capacitacion['cap_CapacitacionID']))?>" class="btn btn-block mb-1 btn-sm btn-success waves-light waves-effect"   title="Información de la capacitacion"><i class="fa fa-info"></i></a><br>
                                        <?=$comprobante?>
                                    </td>
                                    <?php
                                    switch ($capacitacion['cap_Estado']){
                                        case 'Registrada': echo '<td class="w-15"><span class="badge badge-dark">Registrada</span></td>'; break;
                                        case 'Enviada': echo '<td class="w-15"><span class="badge badge-warning">Publicada/enviada</span></td>'; break;
                                        case 'En curso': echo '<td class="w-15"><span class="badge badge-info">En curso</span></td>'; break;
                                        case 'Terminada': echo '<td class="w-15"><span class="badge badge-danger">Terminada</span></td>'; break;
                                    }
                                    //if($fechaFin>date('Y-m-d'))echo '<td class="w-15"><span class="badge badge-danger">Terminada</span></td>';
                                    ?>
                                    <td><?=$nombre?></td>
                                    <td><?=$imparte?></td>
                                    <td><?=$fechas?></td>
                                    <td><?=$capacitacion['cap_Lugar']?></td>
                                    <td><?=$calificacion?></td>
                                    <td><?=$capacitacion['cap_Observaciones']?></td>
                                </tr>
                            <?php }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
