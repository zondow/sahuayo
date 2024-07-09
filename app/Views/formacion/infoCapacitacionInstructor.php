<link href="<?=base_url("assets/plugins/fileinput/css/fileinput.css")?>" media="all" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">
<link href="<?=base_url("assets/plugins/fileinput/themes/explorer-fas/theme.css")?>" media="all" rel="stylesheet" type="text/css"/>
<script src="<?=base_url("assets/plugins/fileinput/js/fileinput.js")?>" type="text/javascript"></script>
<script src="<?=base_url("assets/plugins/fileinput/js/locales/es.js")?>" type="text/javascript"></script>
<script src="<?=base_url("assets/plugins/fileinput/themes/fas/theme.js")?>" type="text/javascript"></script>
<script src="<?=base_url("assets/plugins/fileinput/themes/explorer-fas/theme.js")?>" type="text/javascript"></script>

<style>

    .header_fijo {
        width: 100%;
        table-layout: fixed;
        border-collapse: collapse;
    }
    .header_fijo thead {
        background-color: #333;
        color: #FDFDFD;
    }
    .header_fijo thead tr {
        display: block;
        position: relative;
    }
    .header_fijo tbody {
        display: block;
        overflow: auto;
        width: 100%;
        height: 300px;
    }
</style>

<?php
$curso="";
$imparte="";
$txtImparte="";

if(!empty($capacitacionInfo['cap_CursoID']))$curso=$capacitacionInfo['cur_Nombre'];
else $curso=$capacitacionInfo['cap_CursoNombre'];

if($capacitacionInfo['cap_Tipo'] === "INTERNO"){
    if(!empty($capacitacionInfo['cap_InstructorID'])) {
        $instructor = db()->query("SELECT I.*, E.emp_Nombre FROM instructor I 
                                        JOIN empleado E ON E.emp_EmpleadoID=I.ins_EmpleadoID
                                        WHERE ins_InstructorID=" . $capacitacionInfo['cap_InstructorID'])->getRowArray();
        $imparte=$instructor['emp_Nombre'];
        $txtImparte="Nombre del instructor";
    }
}else{
    if(!empty($capacitacionInfo['cap_ProveedorCursoID'])) {
        $proveedor = db()->query("SELECT * FROM proveedor WHERE pro_ProveedorID=" . $capacitacionInfo['cap_ProveedorCursoID'])->getRowArray();
        $imparte=$proveedor['pro_Nombre'];
        $txtImparte="Nombre del proveedor";
    }
}

$fechasJSON = json_decode($capacitacionInfo['cap_Fechas']);
$fechas ='';
$totalFJ=count($fechasJSON);$i=0;
$arrFechas=array();
foreach($fechasJSON as $fj){
    $fechas.= shortDate($fj->fecha).' de '.shortTime($fj->inicio).' a '.shortTime($fj->fin);
    array_push($arrFechas,$fj->fecha);
    $i++;
    if($i<$totalFJ) $fechas.='<br>';
}


//$arrFechas=json_decode($capacitacionInfo['cap_Fechas']);


$arrAsi=array();
foreach ($asistencia as $item) {
    array_push($arrAsi,$item['asi_Fecha']);
}


$fechasDisponibles=array();
foreach ($arrFechas as $item){
    if(in_array($item,$arrAsi)){
    }else{
        array_push($fechasDisponibles,$item);
    }
}



?>

<div class="row">
    <div class="col-xl-12">
        <div class="card-box">

            <div class="row">

                <div class="col-md-12">
                    <table class="table table-bordered table-striped ">
                        <thead>
                        <tr>
                            <th colspan="6" class="text-center">
                                <div class="card-box widget-flat border-blue bg-success text-white" style="background-color: #001689!important;border-radius: 15px">
                                    <i class="fas fa-clipboard-list" style="right: 5%;left:auto;"></i>
                                    <h4 class="text-uppercase font-weight-bold text-white">Información de la capacitación</h4>
                                </div>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><span class="badge badge-info">Nombre del Curso:</span></td>
                            <td colspan="5"><?= $curso ?></td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-info">>Tipo:</span></td>
                            <td><?= $capacitacionInfo['cap_Tipo']  ?></td>
                            <td><span class="badge badge-info">Modalidad:</span></td>
                            <td><?= $capacitacionInfo['cur_Modalidad']  ?></td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-info">Fechas:</span></td>
                            <td colspan="3"><?= $fechas ?></td>
                        </tr>
                        <tr>
                            <td><span class="badge badge-info"><?= $txtImparte?></span></td>
                            <td colspan="5"><?= $imparte ?></td>
                        <tr>
                            <td><span class="badge badge-info">Objetivo:</span></td>
                            <td colspan="5"><?= $capacitacionInfo['cur_Objetivo'] ?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>


                <div class="col-md-12 mt-4">
                    <ul class="nav nav-pills navtab-bg nav-justified pull-in ">
                        <li class="nav-item">
                            <a href="#participantes" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                <i class="fas fa-users"></i><span class="d-none d-sm-inline-block ml-2">Participantes</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#material" data-toggle="tab" aria-expanded="true" class="nav-link ">
                                <i class="fas fa-wrench"></i> <span class="d-none d-sm-inline-block ml-2">Material</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#asistencia" data-toggle="tab" aria-expanded="true" class="nav-link ">
                                <i class="fas fa-clipboard-list"></i> <span class="d-none d-sm-inline-block ml-2">Asistencia</span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane show active" id="participantes">
                            <input name="cap_CapacitacionID" id="cap_CapacitacionID" value="<?= (int)$capacitacionInfo['cap_CapacitacionID'] ?>" hidden>
                            <table id="tblParticipantes" class="table cls-table m-0 table-bordered dt-responsive" cellspacing="0" width="100%" >
                                <thead>
                                <tr>
                                    <th>Acciones</th>
                                    <th>No. de socio</th>
                                    <th>Nombre</th>
                                    <th>Puesto</th>
                                    <th>Departamento</th>
                                    <th>Sucursal</th>
                                    <th>Calificación</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane show " id="material">
                            <!--Material-->
                            <div class="col-12">
                                <div class="col-md-12">
                                    <form id="formMaterial" method="post" enctype="multipart/form-data">
                                        <div class="form-group ">
                                            <div class="file-loading">
                                                <input id="fileMaterial" name="fileMaterial[]" type="file" class="file" multiple  >
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-12">
                                    <a href="#" id="btnSubirMaterial" class="btn btn-light">Guardar</a>
                                </div>
                                <br>
                                <h4 class="header-title mb-4">Material</h4>
                                <div class="row">
                                    <!--<button type="button" class="btn btn-custom btn-rounded w-md waves-effect waves-light float-right"><i class="mdi mdi-upload"></i> Upload Files</button>-->
                                    <?php
                                    $materiales=materialesCapacitacion((int)$capacitacionInfo['cap_CapacitacionID']);
                                    if(!empty($materiales)) {
                                        $cantidadMateriales = count($materiales);
                                        $colmd = $cantidadMateriales / 12;
                                        foreach ($materiales as $material) { ?>
                                            <?php
                                            $rest = strtolower(substr($material, -3));
                                            if ($rest == "jpg" || $rest == "peg" || $rest == "png") {
                                                $imagen = base_url('assets/images/file_icons/' . $rest . '.svg');
                                            }
                                            if ($rest == "pdf") {
                                                $imagen = base_url('assets/images/file_icons/pdf.svg');
                                            }
                                            if ($rest == "ocx" || $rest == 'doc') {
                                                $imagen = base_url('assets/images/file_icons/doc.svg');
                                            }
                                            if ($rest == "xsl" || $rest == 'slx' || $rest == 'lsx') {
                                                $imagen = base_url('assets/images/file_icons/xls.svg');
                                            }
                                            if ($rest == "zip") {
                                                $imagen = base_url('assets/images/file_icons/zip.svg');
                                            }
                                            if ($rest == "ptx") {
                                                $imagen = base_url('assets/images/file_icons/ppt.svg');
                                            }
                                            $archivoNombre = explode('/', $material);
                                            $count = count($archivoNombre)-1;
                                            $nombre = explode('.', $archivoNombre[$count]);
                                            ?>
                                            <div class="col-lg-3">
                                                <div class="file-man-box rounded mb-3">
                                                    <a href="" id="borrarMaterial" data-id="<?=$capacitacionInfo['cap_CapacitacionID']?>" data-archivo="<?=$nombre[0].'.'.$nombre[1]?>" class="file-close"><i class="mdi mdi-close-circle"></i></a>
                                                    <div class="file-img-box">
                                                        <img src="<?= $imagen ?>" class="avatar-lg" alt="icon">
                                                    </div>
                                                    <a href="<?= $material ?>" class="file-download"><i
                                                            class="mdi mdi-download"></i> </a>
                                                    <div class="file-man-title">
                                                        <h5 class="mb-0 text-overflow"><?= substr($nombre[0], 0, 20) ?></h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php

                                        }
                                    }?>

                                </div><!-- end col -->
                            </div>
                        </div>
                        <div class="tab-pane show " id="asistencia" >

                            <ul class="nav nav-tabs tabs-bordered nav-justified">
                                <li class="nav-item">
                                    <a href="#pase" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                        <i class="fe-monitor"></i><span class="d-none d-sm-inline-block ml-2">Pase de lista</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#listas" data-toggle="tab" aria-expanded="true" class="nav-link">
                                        <i class="fa fa-list"></i> <span class="d-none d-sm-inline-block ml-2">Listas de asistencia</span>
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active"  id="pase">
                                    <form id="formAsistencia">
                                        <div class="row">
                                            <div class="form-group col-md-6" style="padding-bottom: 1%">
                                                <label>* Fecha</label>
                                                <select id="asi_Fecha" name="asi_Fecha" class="form-control" >
                                                    <option value="" hidden>Seleccione</option>
                                                    <?php
                                                    if(!empty($fechasDisponibles)){
                                                        foreach ($fechasDisponibles as $item) {?>
                                                            <option value="<?=$item?>" ><?=$item?></option>
                                                        <?php } } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <input name="asi_CapacitacionID" id="asi_CapacitacionID" value="<?= (int)$capacitacionInfo['cap_CapacitacionID'] ?>" hidden>
                                        <table id="tblListaAsistencia" class=" table cls-table m-0 table-bordered dt-responsive" cellspacing="0" width="100%"  >
                                            <thead>
                                            <tr>
                                                <th   >No. de socio</th>
                                                <th  >Nombre</th>
                                                <th  >Asistencia</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                        <div class="row ">
                                            <div class="form-group col-md-12 ">
                                                <br>
                                                <button  type="button" id="btnSaveAsistencia"  class="mb-2 btn btn-success ">
                                                    Guardar
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="listas">
                                     <div class="row">
                                         <?php
                                         foreach ($arrAsi as $item){
                                         ?>
                                         <div class="col-md-4">
                                             <div class="file-man-box rounded mb-3">
                                                 <div class="file-img-box">
                                                     <img src="<?= base_url('assets/images/file_icons/pdf.svg')?>" class="avatar-lg" alt="icon">
                                                 </div>
                                                 <a href="<?=base_url('PDF/imprimrlistaAsistencia/'.$capacitacionInfo['cap_CapacitacionID']."/".$item)?>" target="_blank" class="file-download"><i class="mdi mdi-download"></i> </a>
                                                 <div class="file-man-title">
                                                     <h5 class="mb-0 text-overflow"><?=$item?>.pdf</h5>
                                                 </div>
                                             </div>
                                         </div>
                                        <?php } ?>
                                     </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!--------------- Modal Calificacion ----------------->
<div id="modalCalificacion" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Asignar calificacion</h4>
            </div>
            <form id="formAsignarCalificacion">
                <input name="cape_CapacitacionEmpleadoID" id="cape_CapacitacionEmpleadoID" hidden>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="cape_Calificacion">Calificación total de la capacitación</label>
                            <input name="cape_Calificacion" id="cape_Calificacion" type="number" step="any" min="0" class="form-control restrictCalificacion" placeholder="0.00" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnAsiganrCalificacion" class="btn btn-primary">Guardar</button>
                    <button class="btn btn-light" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>

    $('#fileMaterial').fileinput({
        theme: 'fas',
        language: 'es',
        uploadUrl: '#',
        allowedFileExtensions: ['zip','docx','xlsx','pptx','pdf','png','jpg','jpeg'],
        dropZoneEnabled: false,
        showUpload:false,
    });


</script>