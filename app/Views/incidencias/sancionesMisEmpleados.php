<?php defined('FCPATH') or exit('No direct script access allowed'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="card-box">
            <!-- end row -->
            <div class="table-responsive">
                <table id="datatableActas" class="table mt-4 table-hover m-0 table-centered tickets-list table-actions-bar ">
                    <thead>
                    <tr>
                        <th width="5%">Acciones</th>
                        <th>#</th>
                        <th>Colaborador</th>
                        <th>Fecha de los hechos</th>
                        <th>Fecha de registro</th>
                        <th>Observaciones</th>
                        <th>Tipo</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(!empty($actas)){
                        $count=0;
                        foreach ($actas as $acta) {
                            $dir = base_url()."/assets/uploads/actasadmin/".$acta['act_Documento'];
                            if(substr($acta['act_Documento'],-3) === "pdf"){
                                $archivo='<a href="' . $dir .'" class="btn btn-info waves-light btn-block waves-effect show-pdf" data-title="Imprimir acta administrativa" style="color: white" title="Imprimir documento" ><i class="dripicons-print"></i></a>';
                            }else if(substr($acta['act_Documento'],-3) === "jpg"){
                                $archivo='<a href="' . $dir .'"  data-lightbox="roadtrip" data-title="Ver acta administrativa" class="btn btn-info btn-block waves-light  waves-effect " style="color: white" title="Imprimir documento" ><i class="dripicons-print"></i></a>';
                            }else if(substr($acta['act_Documento'],-3) === "png"){
                                $archivo='<a href="' . $dir .'"  data-lightbox="roadtrip" data-title="Ver acta administrativa" class="btn btn-info btn-block waves-light  waves-effect " style="color: white" title="Imprimir documento" ><i class="dripicons-print"></i></a>';
                            }else if(substr($acta['act_Documento'],-4) === "jpeg"){
                                $archivo='<a href="' . $dir .'"  data-lightbox="roadtrip" data-title="Ver acta administrativa" class="btn btn-info btn-block waves-light  waves-effect " style="color: white" title="Imprimir documento" ><i class="dripicons-print"></i></a>';
                            }else $archivo='';

                            $tipo='';
                            switch ($acta['act_Tipo']){
                                case 'Llamada de atención verbal': $tipo= '<span class="badge badge-dark">Llamada de atención verbal</span>'; break;
                                case 'Amonestación': $tipo= '<span class="badge badge-info">Amonestación <br> (Carta Extrañamiento)</span>'; break;
                                case 'Compromiso por escrito': $tipo= '<span class="badge badge-warning">Compromiso por escrito</span>'; break;
                                case 'Acta administrativa': $tipo= '<span class="badge badge-danger">Acta administrativa</span>'; break;
                                case 'Suspension': $tipo= '<span class="badge badge-purple">Suspención</span>'; break;
                            }
                            ?>
                            <tr>
                                <td >
                                    <?=$archivo?>
                                </td>
                                <td><?=$count+=1?></td>
                                <td><?=$acta['emp_Nombre']?></td>
                                <td><?=$acta['act_FechaRealizo']?></td>
                                <td><?=$acta['act_FechaRegistro']?></td>
                                <td><?=$acta['act_Observaciones']?></td>
                                <td><?=$tipo?></td>
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

<script>
$(document).ready(function(e) {
    

    $("#archivo").fileinput({
        showUpload: false,
        dropZoneEnabled: false,
        language: "es",
        mainClass: "input-group",
        allowedFileExtensions: ["pdf","png","jpeg","jpg"]
    });
});
</script>