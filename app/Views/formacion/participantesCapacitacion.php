<link href="<?=base_url("assets/plugins/fileinput/css/fileinput.css")?>" media="all" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">
<link href="<?=base_url("assets/plugins/fileinput/themes/explorer-fas/theme.css")?>" media="all" rel="stylesheet" type="text/css"/>
<script src="<?=base_url("assets/plugins/fileinput/js/fileinput.js")?>" type="text/javascript"></script>
<script src="<?=base_url("assets/plugins/fileinput/js/locales/es.js")?>" type="text/javascript"></script>
<script src="<?=base_url("assets/plugins/fileinput/themes/fas/theme.js")?>" type="text/javascript"></script>
<script src="<?=base_url("assets/plugins/fileinput/themes/explorer-fas/theme.js")?>" type="text/javascript"></script>

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

    /* scrolltable rules */
    .table_fija  {  display: inline-block; overflow: auto; }
    .th_fija div {  position: absolute; }

    /* design */
    .table_fija { border-collapse: collapse; }
    .tr_fja:nth-child(even) { background: #EEE; }


</style>

<?php
$curso="";
$imparte="";
$txtImparte="";

if(!empty($capacitacionInfo['cap_CursoID']))$curso=$capacitacionInfo['cur_Nombre'];


if($capacitacionInfo['cap_Tipo'] === "INTERNO"){
    if(!empty($capacitacionInfo['cap_InstructorID'])) {
        $instructor = db()->query("SELECT I.*, E.emp_Nombre FROM instructor I 
                                        JOIN empleado E ON E.emp_EmpleadoID=I.ins_EmpleadoID
                                        WHERE ins_InstructorID=" . $capacitacionInfo['cap_InstructorID'])->getRowArray();
        $imparte=$instructor['emp_Nombre'];
        $txtImparte="Nombre del instructor:";
    }
}else{
    if(!empty($capacitacionInfo['cap_ProveedorCursoID'])) {
        $proveedor = db()->query("SELECT * FROM proveedor WHERE pro_ProveedorID=" . $capacitacionInfo['cap_ProveedorCursoID'])->getRowArray();
        $imparte=$proveedor['pro_Nombre'];
        $txtImparte="Nombre del proveedor";
    }
}


$fechas=json_decode($capacitacionInfo['cap_Fechas'],true);

$txtFechas="";
$arrFechas=array();
for ($i = 0; $i < count($fechas); $i++) {
    $txtFechas.=shortDate($fechas[$i]['fecha'],'-').' de '.shortTime($fechas[$i]['inicio']).' a '.shortTime($fechas[$i]['fin']).'<br>';
    array_push($arrFechas,$fechas[$i]['fecha']);
}



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

$comprobante="";

if($capacitacionInfo['cap_Comprobante'] === "SI"){
    if($capacitacionInfo['cap_TipoComprobante'] === "1"){
    $comprobante="comprobante.png";
    }
    elseif($capacitacionInfo['cap_TipoComprobante'] === "2"){
        $comprobante="comprobante2.png";
    }
}

?>

<?php

//Encuesta Satisfaccion
$arrayPreguntas = array(
    array("num" => 1, "pregunta" => "Al empezar se plantearon los objetivos y el programa detallado del curso.", "field" => "ent_Metodologia1a"),
    array("num" => 2, "pregunta" => "La forma en que se llevo a cabo este curso me ayudo a aprender.", "field" => "ent_Metodologia1b"),
    array("num" => 3, "pregunta" => "Los materiales del curso han sido utiles para el aprendizaje.", "field" => "ent_Metodologia1c"),
    array("num" => 4, "pregunta" => "La calidad del material entregado ha sido adecuado.", "field" => "ent_Metodologia1d"),
    array("num" => 5, "pregunta" => "La evaluación se ha realizado de forma adecuada.", "field" => "ent_Metodologia1e"),
    array("num" => 6, "pregunta" => "El ponente cumplió con el programa planteado para el curso.", "field" => "ent_Instructor1a"),
    array("num" => 7, "pregunta" => "El ponente se expresa con claridad.", "field" => "ent_Instructor1b"),
    array("num" => 8, "pregunta" => "El ponente demuestra conocimiento actualizado de su materia.", "field" => "ent_Instructor1c"),
    array("num" => 9, "pregunta" => "El ponente promueve que los alumnos expresen sus ideas.", "field" => "ent_Instructor1d"),
    array("num" => 10, "pregunta" => "El ponente atiende adecuadamente las preguntas de los participantes.", "field" => "ent_Instructor1e"),
    array("num" => 11, "pregunta" => "El ponente se apego a los tiempos establecidos del curso.", "field" => "ent_Instructor1f"),
    array("num" => 12, "pregunta" => "Los medios técnicos utilizados fueron adecuados (cañon, bocina, etc.).", "field" => "ent_Organizacion1a"),
    array("num" => 13, "pregunta" => "El aula o espacio utilizado fue adecuado(aire acondicionado, sillas,etc.).", "field" => "ent_Organizacion1b"),
    array("num" => 14, "pregunta" => "Lo aprendido en el curso se puede aplicar en mi puesto de trabajo.", "field" => "ent_Satisfaccion1a"),
    array("num" => 15, "pregunta" => "Tus expextativas de aprendizaje se cumplieron.", "field" => "ent_Satisfaccion1b"),
    array("num" => 16, "pregunta" => "Te gustaría tomar otro curso similar.", "field" => "ent_Satisfaccion1c"),
);
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
                                <td><span class="badge badge-info">Nombre del tema de capacitación:</span></td>
                                <td colspan="5"><?= $curso ?></td>
                            </tr>
                            <tr>
                                <td><span class="badge badge-info">Tipo:</span></td>
                                <td><?= $capacitacionInfo['cap_Tipo']  ?></td>
                                <td><span class="badge badge-info" >Modalidad:</span></td>
                                <td><?= $capacitacionInfo['cur_Modalidad']  ?></td>
                                <td><span class="badge badge-info">Costo:</span></td>
                                <td>$<?=number_format($capacitacionInfo['cap_Costo'],2,'.',',')?></td>
                            </tr>
                            <tr>
                                <td><span class="badge badge-info">Fechas:</span></td>
                                <td><?= $txtFechas ?></td>
                                <td><span class="badge badge-info">Días:</span></td>
                                <td> <?= $capacitacionInfo['cap_NumeroDias'] ?></td>
                                <td><span class="badge badge-info">Lugar:</span></td>
                                <td> <?= $capacitacionInfo['cap_Lugar'] ?></td>
                            </tr>
                            
                            <tr>
                                <td><span class="badge badge-info"><?= $txtImparte?></span></td>
                                <td colspan="5"><?= $imparte ?></td>
                            <tr>
                                <td><span class="badge badge-info">Objetivo:</span></td>
                                <td colspan="5"><?= $capacitacionInfo['cur_Objetivo'] ?></td>
                            </tr>
                            <tr>
                                <td><span class="badge badge-info">Dirigido a:</span></td>
                                <td colspan="5"><?= $capacitacionInfo['cap_Dirigido'] ?></td>
                            </tr>
                            <tr>
                                <td><span class="badge badge-info">Observaciones:</span></td>
                                <td colspan="5"><?= $capacitacionInfo['cap_Observaciones'] ?></td>
                            </tr>
                        <?php  
                        if($capacitacionInfo['cap_Comprobante']==="SI"){
                        ?>
                            <tr >
                                <td><span class="badge badge-info">Comprobante otorgado</span></td>
                                <td colspan="5" style="height: 20px" class="text-center" ><img src="<?=base_url('assets/images/capacitacion/'.$comprobante)?>" class="img-thumbnail" alt="" style="height: 200px"  ></td>
                            </tr>
                            
                        <?php  
                        }
                        ?>
                             <tr >
                                <td><span class="badge badge-info">Califcación aprobatoria</span></td>
                                <td colspan="5" style="height: 20px" class="text-center"><?= $capacitacionInfo['cap_CalAprobatoria'] !== 0 ? $capacitacionInfo['cap_CalAprobatoria'] : 'No aplica.'  ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>


                <div class="col-md-12 mt-4">
                    <ul class="nav nav-pills navtab-bg nav-justified pull-in ">
                        <li class="nav-item">
                            <a href="#convocatoria" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                <i class="fas fa-image"></i><span class="d-none d-sm-inline-block ml-2">Convocatoria</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#participantes" data-toggle="tab" aria-expanded="false" class="nav-link ">
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
                        <li class="nav-item">
                            <a href="#encuesta" data-toggle="tab" aria-expanded="true" class="nav-link ">
                                <i class="fas fa-chart-bar"></i> <span class="d-none d-sm-inline-block ml-2">Encuesta de satisfacción</span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane show active" id="convocatoria">
                            <?php
                            $convocatoria=convocatoriaCapacitacion((int)$capacitacionInfo['cap_CapacitacionID']);

                            if(count($convocatoria )<= 0){
                            ?>
                            <div class="col-md-12">
                                <form id="formConvocatoria" method="post" enctype="multipart/form-data">
                                    <div class="form-group ">
                                        <div class="file-loading">
                                            <input id="fileConvocatoria" name="fileConvocatoria" type="file" class="file"   >
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-12">
                                <a href="#" id="btnSubirConvocatoria" class="btn btn-light">Guardar</a>
                            </div>
                            <?php }else{
                                $archivoNombreC = explode('/', $convocatoria[0]);
                                $count = count($archivoNombreC)-1;
                                $nombreC = explode('.', $archivoNombreC[$count]);
                                ?>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="file-man-box rounded mb-3">
                                        <a href="" id="borrarConvocatoria" data-id="<?=$capacitacionInfo['cap_CapacitacionID']?>" data-archivo="<?=$nombreC[0].'.'.$nombreC[1]?>" class="file-close"><i class="mdi mdi-close-circle"></i></a>
                                        <div class="row justify-content-center" >
                                            <img src="<?=$convocatoria[0]?>" class="img-fluid" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                        <div class="tab-pane show " id="participantes">
                            <input name="cap_CapacitacionID" id="cap_CapacitacionID" value="<?= (int)$capacitacionInfo['cap_CapacitacionID'] ?>" hidden>
                            <div class="row mb-3">
                                <div class="col-md-4 ">
                                    <?php if(revisarPermisos('Agregar',$this)){ ?>
                                        <button type="button" class="btn btn-secondary btnModalParticipantes"><span><i class="fa fa-plus"></i > Agregar participantes</span></button>
                                    <?php } ?>
                                </div>
                            </div>
                            <table id="tblParticipantes" class="table cls-table m-0 table-bordered dt-responsive" cellspacing="0" width="100%" >
                                <thead>
                                <tr>
                                    <th>Acciones</th>
                                    <th>Número de empleado</th>
                                    <th>Nombre</th>
                                    <th>Puesto</th>
                                    <th>Area</th>
                                    <th>Sucursal</th>
                                    <th>Calificación</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane show " id="material">
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
                            <!--Material-->
                            <div class="col-12">

                                <div class="row">
                                    <?php
                                    $materiales=materialesCapacitacion((int)$capacitacionInfo['cap_CapacitacionID']);
                                    if(!empty($materiales)) {
                                        $cantidadMateriales = count($materiales);
                                        $colmd = $cantidadMateriales / 12;
                                        $imagen="";
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
                        <div class="tab-pane show " id="asistencia">
                           
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
                                        <table id="tblListaAsistencia" class=" table cls-table m-0 table-bordered dt-responsive" cellspacing="0" width="100%" >
                                            <thead>
                                            <tr>
                                                <th>No. de empleado</th>
                                                <th>Nombre</th>
                                                <th>Asistencia</th>
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
                        <div class="tab-pane show " id="encuesta">
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="<?=base_url("PDF/imprimirResultadosEncuesta/".$capacitacionInfo['cap_CapacitacionID'])?>" class="btn btn-secondary show-pdf" style="color: white" data-title="Resultados"
                                    <b class="fa fa-print"></b> Imprimir Resultados</a>

                                    <h3 class="text-center">RESULTADOS</h3>
                                    <div class="dashboard-donut-chart" style="height: 300px !important; width: 100% !important;">
                                        <canvas id="resultadosG" style="width: 650px"></canvas>
                                    </div>
                                </div>
                            </div>

                            <h3>I. METODOLOGIA  UTILIZADA</h3>
                            <div class=" row text-center"  >

                                <?php
                                for($i=0;$i<=4;$i++){?>
                                    <div class="col-lg-4" style="width: 100%;" >
                                        <h5 class="mb-2">
                                            <span class="heading-number d-inline-block"><?= $arrayPreguntas[$i]['num'] ?>. </span> <?= $arrayPreguntas[$i]['pregunta'] ?>
                                        </h5>
                                        <div class="dashboard-donut-chart" style="height: 300px !important; width: 100% !important;">
                                            <?php
                                            $dataP = array();
                                            $resultP = db()->query("SELECT E." . $arrayPreguntas[$i]['field'] . " FROM encuestacapacitacion E WHERE E.ent_CapacitacionID=".$capacitacionInfo['cap_CapacitacionID'])->getResultArray();
                                            $valoresP = array_count_values(array_column($resultP, $arrayPreguntas[$i]['field']));

                                            (isset($valoresP["Totalmente en desacuerdo"])) ? array_push($dataP, $valoresP['Totalmente en desacuerdo']) : array_push($dataP, 0);
                                            (isset($valoresP["En desacuerdo"])) ? array_push($dataP, $valoresP['En desacuerdo']) : array_push($dataP, 0);
                                            (isset($valoresP["Indeciso"])) ? array_push($dataP, $valoresP['Indeciso']) : array_push($dataP, 0);
                                            (isset($valoresP["De acuerdo"])) ? array_push($dataP, $valoresP['De acuerdo']) : array_push($dataP, 0);
                                            (isset($valoresP["Totalmente de acuerdo"])) ? array_push($dataP, $valoresP['Totalmente de acuerdo']) : array_push($dataP, 0);
                                            $dataR[$arrayPreguntas[$i]['field']] = $dataP;

                                             ?>
                                            <canvas style="height: 270px !important;" id="<?= $arrayPreguntas[$i]['field'] ?>"></canvas>
                                        </div>

                                    </div>
                                <?php } ?>
                            </div>

                            <h3>II. INSTRUCTOR</h3>
                            <div class=" row text-center"  >

                                <?php
                                for($i=5;$i<=10;$i++){?>
                                    <div class="col-lg-4" style="width: 100%;" >
                                        <h5 class="mb-2">
                                            <span class="heading-number d-inline-block"><?= $arrayPreguntas[$i]['num'] ?>. </span> <?= $arrayPreguntas[$i]['pregunta'] ?>
                                        </h5>
                                        <div class="dashboard-donut-chart" style="height: 300px !important; width: 100% !important;">
                                            <?php
                                            $dataP = array();
                                            $resultP = db()->query("SELECT E." . $arrayPreguntas[$i]['field'] . " FROM encuestacapacitacion E WHERE E.ent_CapacitacionID=".$capacitacionInfo['cap_CapacitacionID'])->getResultArray();
                                            $valoresP = array_count_values(array_column($resultP, $arrayPreguntas[$i]['field']));

                                            (isset($valoresP["Totalmente en desacuerdo"])) ? array_push($dataP, $valoresP['Totalmente en desacuerdo']) : array_push($dataP, 0);
                                            (isset($valoresP["En desacuerdo"])) ? array_push($dataP, $valoresP['En desacuerdo']) : array_push($dataP, 0);
                                            (isset($valoresP["Indeciso"])) ? array_push($dataP, $valoresP['Indeciso']) : array_push($dataP, 0);
                                            (isset($valoresP["De acuerdo"])) ? array_push($dataP, $valoresP['De acuerdo']) : array_push($dataP, 0);
                                            (isset($valoresP["Totalmente de acuerdo"])) ? array_push($dataP, $valoresP['Totalmente de acuerdo']) : array_push($dataP, 0);
                                            $dataR[$arrayPreguntas[$i]['field']] = $dataP;

                                            ?>
                                            <canvas style="height: 270px !important;" id="<?= $arrayPreguntas[$i]['field'] ?>"></canvas>
                                        </div>

                                    </div>
                                <?php } ?>
                            </div>

                            <h3>III. ORGANIZACIÓN DEL EVENTO</h3>
                            <div class=" row text-center"  >

                                <?php
                                for($i=11;$i<=12;$i++){?>
                                    <div class="col-lg-4" style="width: 100%;" >
                                        <h5 class="mb-2">
                                            <span class="heading-number d-inline-block"><?= $arrayPreguntas[$i]['num'] ?>. </span> <?= $arrayPreguntas[$i]['pregunta'] ?>
                                        </h5>
                                        <div class="dashboard-donut-chart" style="height: 300px !important; width: 100% !important;">
                                            <?php
                                            $dataP = array();
                                            $resultP = db()->query("SELECT E." . $arrayPreguntas[$i]['field'] . " FROM encuestacapacitacion E WHERE E.ent_CapacitacionID=".$capacitacionInfo['cap_CapacitacionID'])->getResultArray();
                                            $valoresP = array_count_values(array_column($resultP, $arrayPreguntas[$i]['field']));

                                            (isset($valoresP["Totalmente en desacuerdo"])) ? array_push($dataP, $valoresP['Totalmente en desacuerdo']) : array_push($dataP, 0);
                                            (isset($valoresP["En desacuerdo"])) ? array_push($dataP, $valoresP['En desacuerdo']) : array_push($dataP, 0);
                                            (isset($valoresP["Indeciso"])) ? array_push($dataP, $valoresP['Indeciso']) : array_push($dataP, 0);
                                            (isset($valoresP["De acuerdo"])) ? array_push($dataP, $valoresP['De acuerdo']) : array_push($dataP, 0);
                                            (isset($valoresP["Totalmente de acuerdo"])) ? array_push($dataP, $valoresP['Totalmente de acuerdo']) : array_push($dataP, 0);
                                            $dataR[$arrayPreguntas[$i]['field']] = $dataP;

                                            ?>
                                            <canvas style="height: 270px !important;" id="<?= $arrayPreguntas[$i]['field'] ?>"></canvas>
                                        </div>

                                    </div>
                                <?php } ?>
                            </div>

                            <h3>IV. SATISFACCIÓN ACERCA DEL EVENTO</h3>
                            <div class=" row text-center"  >

                                <?php
                                for($i=13;$i<=15;$i++){?>
                                    <div class="col-lg-4" style="width: 100%;" >
                                        <h5 class="mb-2">
                                            <span class="heading-number d-inline-block"><?= $arrayPreguntas[$i]['num'] ?>. </span> <?= $arrayPreguntas[$i]['pregunta'] ?>
                                        </h5>
                                        <div class="dashboard-donut-chart" style="height: 300px !important; width: 100% !important;">
                                            <?php
                                            $dataP = array();
                                            $resultP = db()->query("SELECT E." . $arrayPreguntas[$i]['field'] . " FROM encuestacapacitacion E WHERE E.ent_CapacitacionID=".$capacitacionInfo['cap_CapacitacionID'])->getResultArray();
                                            $valoresP = array_count_values(array_column($resultP, $arrayPreguntas[$i]['field']));

                                            (isset($valoresP["Totalmente en desacuerdo"])) ? array_push($dataP, $valoresP['Totalmente en desacuerdo']) : array_push($dataP, 0);
                                            (isset($valoresP["En desacuerdo"])) ? array_push($dataP, $valoresP['En desacuerdo']) : array_push($dataP, 0);
                                            (isset($valoresP["Indeciso"])) ? array_push($dataP, $valoresP['Indeciso']) : array_push($dataP, 0);
                                            (isset($valoresP["De acuerdo"])) ? array_push($dataP, $valoresP['De acuerdo']) : array_push($dataP, 0);
                                            (isset($valoresP["Totalmente de acuerdo"])) ? array_push($dataP, $valoresP['Totalmente de acuerdo']) : array_push($dataP, 0);
                                            $dataR[$arrayPreguntas[$i]['field']] = $dataP;

                                            ?>
                                            <canvas style="height: 270px !important;" id="<?= $arrayPreguntas[$i]['field'] ?>"></canvas>
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


<!--------------- Modal Participantes ----------------->
<div id="modalParticipantes" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Agregar participantes</h4>
            </div>
            <form id="formAgregarEmpleados">
                <input name="cape_CapacitacionID" id="cape_CapacitacionID" value="<?= (int)$capacitacionInfo['cap_CapacitacionID'] ?>" hidden>
                <input name="cursoID" id="cursoID" value="<?= (int)$capacitacionInfo['cur_CursoID'] ?>" hidden>
                <div class="modal-body">
                    <div class="table-responsive text-center">
                        <table id="tblEmpleados" class="table table_fija cls-table table-hover m-0  nowrap"   width="95%" style="height: 100%;">
                            <thead style="position: sticky;top: 0; z-index: 10;background-color: #dbe2ea;" >
                            <tr class="tr_fija">
                                <th class="th_fija" width="5%"></th>
                                <th class="th_fija" >Nombre</th>
                                <th class="th_fija" >Puesto</th>
                                <th class="th_fija" >Área</th>
                                <th class="th_fija" >Sucursal</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnAgregarEmpleados" class="btn btn-primary">Guardar</button>
                    <button class="btn btn-light" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
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

    $('#fileConvocatoria').fileinput({
        theme: 'fas',
        language: 'es',
        uploadUrl: '#',
        allowedFileExtensions: ['png','jpg','jpeg'],
        dropZoneEnabled: false,
        showUpload:false,
    });


</script>
<script src="<?=base_url("assets/js/Chart.bundle.min.js")?>"></script>

<script>
    $(document).ready(function(){

        $(".show-pdf").hide();

        var centerTextPlugin = {
            afterDatasetsUpdate: function (chart) { },
            beforeDraw: function (chart) {
                var width = chart.chartArea.right;
                var height = chart.chartArea.bottom;
                var ctx = chart.chart.ctx;
                ctx.restore();

                var activeLabel = chart.data.labels[0];
                var activeValue = chart.data.datasets[0].data[0];
                var dataset = chart.data.datasets[0];
                var meta = dataset._meta[Object.keys(dataset._meta)[0]];
                var total = meta.total;

                var activePercentage = parseFloat(
                    ((activeValue / total) * 100).toFixed(1)
                );
                activePercentage = chart.legend.legendItems[0].hidden
                    ? 0
                    : activePercentage;

                if (chart.pointAvailable) {
                    activeLabel = chart.data.labels[chart.pointIndex];
                    activeValue =
                        chart.data.datasets[chart.pointDataIndex].data[chart.pointIndex];

                    dataset = chart.data.datasets[chart.pointDataIndex];
                    meta = dataset._meta[Object.keys(dataset._meta)[0]];
                    total = meta.total;
                    activePercentage = parseFloat(
                        ((activeValue / total) * 100).toFixed(1)
                    );
                    activePercentage = chart.legend.legendItems[chart.pointIndex].hidden
                        ? 0
                        : activePercentage;
                }

                ctx.font = "36px" + " Nunito, sans-serif";
                ctx.fillStyle = '#404040';
                ctx.textBaseline = "middle";

                var text = activePercentage + "%",
                    textX = Math.round((width - ctx.measureText(text).width) / 2),
                    textY = height / 2;
                ctx.fillText(text, textX, textY);

                ctx.font = "14px" + " Nunito, sans-serif";
                ctx.textBaseline = "middle";

                var text2 = activeLabel,
                    textX = Math.round((width - ctx.measureText(text2).width) / 2),
                    textY = height / 2 - 30;
                ctx.fillText(text2, textX, textY);

                ctx.save();
            },
            beforeEvent: function (chart, event, options) {
                var firstPoint = chart.getElementAtEvent(event)[0];

                if (firstPoint) {
                    chart.pointIndex = firstPoint._index;
                    chart.pointDataIndex = firstPoint._datasetIndex;
                    chart.pointAvailable = true;
                }
            }
        };

        Chart.defaults.DoughnutWithShadow = Chart.defaults.doughnut;
        Chart.controllers.DoughnutWithShadow = Chart.controllers.doughnut.extend({
            draw: function (ease) {
                Chart.controllers.doughnut.prototype.draw.call(this, ease);
                let ctx = this.chart.chart.ctx;
                ctx.save();
                ctx.shadowColor = "rgba(0,0,0,0.15)";
                ctx.shadowBlur = 10;
                ctx.shadowOffsetX = 0;
                ctx.shadowOffsetY = 10;
                ctx.responsive = true;
                Chart.controllers.doughnut.prototype.draw.apply(this, arguments);
                ctx.restore();
            }
        });

        var chartTooltip = {
            backgroundColor: "#f9f9f9",
            titleFontColor: '#212940',
            borderColor: '#ffb734',
            borderWidth: 0.5,
            bodyFontColor: '#060606',
            bodySpacing: 10,
            xPadding: 15,
            yPadding: 15,
            cornerRadius: 0.15,
            displayColors: true,

        };


        // Resultados Efectividad
        if (document.getElementById("resultadosG")) {
            var ctx  = document.getElementById("resultadosG");
            var efec = new Chart(ctx , {

                type: "bar",
                data: {
                    labels: ['Metodologia utilizada','Instructor','Organización del evento','Satisfacción del evento'],
                    datasets: [
                        {
                            label: "Promedio",
                            strokeColor: "#79D1CF",
                            borderColor: [
                                'rgb(229, 159, 113)',
                                'rgb(186, 90, 49)',
                                'rgb(48, 153, 116)',
                                'rgb(45, 55, 70)'
                            ],
                            backgroundColor: [
                                'rgb(229, 159, 113, 0.48)',
                                'rgb(186, 90, 49, 0.48)',
                                'rgb(48, 153, 116, 0.48)',
                                'rgb(45, 55, 70, 0.48)'
                            ],
                            borderWidth: 2,
                            data: [<?php
                                    echo $encuesta['metodologia'] . ",";
                                    echo $encuesta['instructor'] . ",";
                                    echo $encuesta['organizacion'] . ",";
                                    echo $encuesta['satisfaccion'] ;
                                ?>
                            ]
                        },
                    ],
                },

                options: {
                    plugins: {
                        datalabels: {
                            display: true
                        }
                    },

                    maintainAspectRatio: false,

                    scales: {
                        yAxes: [
                            {

                                ticks: {
                                    min: 0,
                                    max: 100,
                                    stepSize: 10,
                                }
                            }
                        ],
                    },
                    title: {
                        display: true
                    },
                    layout: {
                        padding: {
                            bottom: 20
                        }
                    },
                    legend: {
                        display: false
                    },

                    tooltips: false,
                    responsive: true,
                    animation: {
                        duration: 500,
                        easing: "easeOutQuart",
                        onComplete: function () {
                            var ctx = this.chart.ctx;
                            ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';

                            this.data.datasets.forEach(function (dataset) {
                                for (var i = 0; i < dataset.data.length; i++) {
                                    var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
                                        scale_max = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._yScale.maxHeight;
                                    ctx.fillStyle = '#444';
                                    var y_pos = model.y - 5;
                                    // Make sure data value does not get overflown and hidden
                                    // when the bar's value is too close to max value of scale
                                    // Note: The y value is reverse, it counts from top down
                                    if ((scale_max - model.y) / scale_max >= 0.93)
                                        y_pos = model.y + 20;
                                    ctx.fillText(dataset.data[i], model.x, y_pos);
                                }
                            });
                        }
                    }
                }
            });
        }




        //Preguntas
        var arrayPreguntas=JSON.stringify(<?php echo json_encode($dataR)?>);


       // arrayPreguntas = JSON.stringify(arrayPreguntas);
        var arrayP = JSON.parse(arrayPreguntas);

        for(var pregunta in arrayP){

            var varP = document.getElementById(pregunta).getContext('2d');
            var chartP = new Chart(varP, {
                type: 'doughnut',
                plugins: [centerTextPlugin],
                data: {
                    datasets: [{
                        data: arrayP[pregunta],
                        borderColor: [
                            'rgb(229, 159, 113)',
                            'rgb(186, 90, 49)',
                            'rgb(48, 153, 116)',
                            'rgb(126, 130, 135)',
                            'rgb(45, 55, 70)'
                        ],
                        backgroundColor: [
                            'rgb(229, 159, 113, 0.48)',
                            'rgb(186, 90, 49, 0.48)',
                            'rgb(48, 153, 116, 0.48)',
                            'rgb(126, 130, 135, 0.48)',
                            'rgb(45, 55, 70, 0.48)'
                        ]
                    }],
                    labels: ['Totalmente en desacuerdo', 'En desacuerdo', 'Indeciso', 'De acuerdo', 'Totalmente de acuerdo']
                },
                options: {
                    plugins: {
                        datalabels: {
                            display: true,
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    cutoutPercentage: 80,
                    title: {
                        display: false
                    },
                    layout: {
                        padding: {
                            bottom: 20
                        }
                    },
                    legend: {
                        position: "bottom",
                        labels: {
                            padding: 30,
                            usePointStyle: true,
                            fontSize: 12
                        }
                    },
                    tooltips: {
                        enabled: false
                    }
                }
            });
        }

        $('body').on('click', '#encuesta',function(evt){
            guardarImagenes();
        });


        setTimeout(function(){
            $(".show-pdf").show();
        }, 1000);

        //Guardar imagenes Graficas
        function guardarImagenes() {
            var canvasGrafica = document.getElementById('resultadosG');
            var dataGrafica = canvasGrafica.toDataURL('image/png',1.0);

            var imgs = dataGrafica;

            //Ajax guardar imagen
            $.ajax({
                url: BASE_URL+'Formacion/ajax_guardarEncuestaCapacitacion/',
                type: 'post',
                cache: false,
                async: false,
                data: {
                    img:imgs,
                    id:<?=$capacitacionInfo['cap_CapacitacionID'] ?>
                }
            }).done(function(data){
                console.log("La imagen se guardó correctamente");
            }).fail(function(data){
                //console.log("Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.");
                //console.log(data);
            }).always(function(e){
            });//Ajax guardar imagen

        }

    });
</script>

