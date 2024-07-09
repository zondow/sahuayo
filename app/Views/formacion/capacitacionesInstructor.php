<style>

    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] { -moz-appearance:textfield; }

    .select2-container {
        width: 100% !important;
    }

    .dtp div.dtp-date, .dtp div.dtp-time{
        background-color: #001689 !important;
    }
    .dtp > .dtp-content > .dtp-date-view > header.dtp-header {
        background-color: #001689 !important;
    }
</style>
<div class="row">
    <div class="col-xl-12">
        <div class="card-box">

            <div class="row">
                <div class="col-md-12 table-responsive">
                    <table class="datatableCapacitacion table table-hover m-0 table-centered  table-actions-bar dt-responsive nowrap" cellspacing="0" width="100%" >
                        <thead>
                        <tr>
                            <th>Acciones</th>
                            <th>Estatus</th>
                            <th>Nombre</th>
                            <th>Fecha(s)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if(!empty($capacitaciones)){
                            foreach ($capacitaciones as $capacitacion) {

                                ?>
                                <tr>
                                    <td>
                                        <a href="<?=base_url('Formacion/informacionCapacitacionInstructor/'.encryptDecrypt('encrypt',$capacitacion['cap_CapacitacionID']))?>"  class="btn btn-warning waves-light waves-effect " title="Información de la capacitación" type="button" style="color:#fff">
                                            <i class="fa fa-info"></i>
                                        </a>
                                        <a href="#"  class="btn btn-dark waves-light waves-effect btnComentarios " data-id="<?=$capacitacion['cap_CapacitacionID']?>" title="Comentarios del instructor" type="button" style="color:#fff">
                                            <i class=" fab fa-stack-exchange  "></i>
                                        </a>
                                    </td>

                                    <?php if(!empty($capacitacion['cap_CursoID'])){
                                        $nombre=$capacitacion['cur_Nombre'];
                                    }else{
                                        $nombre=$capacitacion['cap_CursoNombre'];
                                    }

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
                                    switch ($capacitacion['cap_Estado']){
                                        case 'Registrada': echo '<td class="w-15"><span class="badge badge-dark">Registrada</span></td>'; break;
                                        case 'Enviada': echo '<td class="w-15"><span class="badge badge-warning">Publicada/enviada</span></td>'; break;
                                        case 'En curso': echo '<td class="w-15"><span class="badge badge-info">En curso</span></td>'; break;
                                        case 'Terminada': echo '<td class="w-15"><span class="badge badge-danger">Terminada</span></td>'; break;
                                    }
                                    ?>
                                    <td><?=$nombre?></td>
                                    <td><?=$fechas?></td>
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

<!--------------- Modal comentarios ----------------->
<div id="modalAddComentarios" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Comentarios del instructor</h4>
            </div>
            <form id="formComentarios" action="<?=base_url('Formacion/saveComentariosInstructor')?>" method="post" autocomplete="off" >
                <input type="hidden" name="cap_CapacitacionID" id="cap_CapacitacionID" value="0">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12" >
                            <div class="form-group">
                                <label for="cap_ComentariosInstructor">Por favor describa el material o recursos que necesita para implementar la capacitación, asi como algun comentario u observaciones.</label>
                                <textarea type="text" class="form-control" rows="3" name="cap_ComentariosInstructor" id="cap_ComentariosInstructor" ></textarea>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>


