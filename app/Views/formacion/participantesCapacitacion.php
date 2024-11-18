<link href="<?= base_url("assets/plugins/fileinput/css/fileinput.css") ?>" media="all" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">
<link href="<?= base_url("assets/plugins/fileinput/themes/explorer-fas/theme.css") ?>" media="all" rel="stylesheet" type="text/css" />
<script src="<?= base_url("assets/plugins/fileinput/js/fileinput.js") ?>" type="text/javascript"></script>
<script src="<?= base_url("assets/plugins/fileinput/js/locales/es.js") ?>" type="text/javascript"></script>
<script src="<?= base_url("assets/plugins/fileinput/themes/fas/theme.js") ?>" type="text/javascript"></script>
<script src="<?= base_url("assets/plugins/fileinput/themes/explorer-fas/theme.js") ?>" type="text/javascript"></script>

<style>
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield;
    }

    .select2-container {
        width: 100% !important;
    }

    /* scrolltable rules */
    .table_fija {
        display: inline-block;
        overflow: auto;
    }

    .th_fija div {
        position: absolute;
    }

    /* design */
    .table_fija {
        border-collapse: collapse;
    }

    .tr_fja:nth-child(even) {
        background: #EEE;
    }

    .card .header h2 {
        font-size: 15px !important;
    }
</style>
<?php
$curso = $capacitacionInfo['cap_CursoID'] ? $capacitacionInfo['cur_Nombre'] : "";

if ($capacitacionInfo['cap_Tipo'] === "INTERNO" && !empty($capacitacionInfo['cap_InstructorID'])) {
    $instructor = db()->query("SELECT I.*, E.emp_Nombre FROM instructor I JOIN empleado E ON E.emp_EmpleadoID=I.ins_EmpleadoID WHERE ins_InstructorID = ?", [$capacitacionInfo['cap_InstructorID']])->getRowArray();
    $imparte = $instructor['emp_Nombre'];
    $txtImparte = "Nombre del instructor:";
} elseif ($capacitacionInfo['cap_Tipo'] === "EXTERNO" && !empty($capacitacionInfo['cap_ProveedorCursoID'])) {
    $proveedor = db()->query("SELECT * FROM proveedor WHERE pro_ProveedorID = ?", [$capacitacionInfo['cap_ProveedorCursoID']])->getRowArray();
    $imparte = $proveedor['pro_Nombre'];
    $txtImparte = "Nombre del proveedor:";
}

$fechas = json_decode($capacitacionInfo['cap_Fechas'], true);
$txtFechas = implode('<br>', array_map(fn ($fecha) => shortDate($fecha['fecha'], '-') . ' de ' . shortTime($fecha['inicio']) . ' a ' . shortTime($fecha['fin']), $fechas));
$arrFechas = array_column($fechas, 'fecha');

$arrAsi = array_column($asistencia, 'asi_Fecha');
$fechasDisponibles = array_diff($arrFechas, $arrAsi);

$comprobante = match ($capacitacionInfo['cap_Comprobante'] === "SI" ? $capacitacionInfo['cap_TipoComprobante'] : null) {
    "1" => "comprobante.png",
    "2" => "comprobante2.png",
    default => ""
};
$secciones = [
    ['titulo' => 'I. METODOLOGIA UTILIZADA', 'rango' => [0, 4]],
    ['titulo' => 'II. INSTRUCTOR', 'rango' => [5, 10]],
    ['titulo' => 'III. ORGANIZACIÓN DEL EVENTO', 'rango' => [11, 12]],
    ['titulo' => 'IV. SATISFACCIÓN ACERCA DEL EVENTO', 'rango' => [13, 15]]
];
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
        <div class="card">
            <div class="card-body">
                <div class="col-md-12">
                    <table class="table table-bordered table-striped ">
                        <thead>
                            <tr>
                                <th colspan="6" class="text-center">
                                    <div class="card-box" style="border-radius: 15px">
                                        <h4 class="text-uppercase font-weight-bold" style="color: #00acc1 !important;">Información de la capacitación</h4>
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center" style="vertical-align: middle;">
                                    <div class="header">
                                        <h2><strong>Nombre del tema de capacitación:</strong></h2>
                                    </div>
                                </td>
                                <td class="text-center" style="vertical-align: middle;" colspan="5" class="text-center" style="vertical-align: middle;"><?= $curso ?></td>
                            </tr>
                            <tr>
                                <td class="text-center" style="vertical-align: middle;">
                                    <div class="header">
                                        <h2><strong>Tipo:</strong></h2>
                                    </div>
                                </td>
                                <td class="text-center" style="vertical-align: middle;" class="text-center" style="vertical-align: middle;"><?= $capacitacionInfo['cap_Tipo']  ?></td>
                                <td class="text-center" style="vertical-align: middle;">
                                    <div class="header">
                                        <h2><strong>Modalidad:</strong></h2>
                                    </div>
                                </td>
                                <td class="text-center" style="vertical-align: middle;" class="text-center" style="vertical-align: middle;"><?= $capacitacionInfo['cur_Modalidad']  ?></td>
                                <td class="text-center" style="vertical-align: middle;">
                                    <div class="header">
                                        <h2><strong>Costo:</strong></h2>
                                    </div>
                                </td>
                                <td class="text-center" style="vertical-align: middle;" class="text-center" style="vertical-align: middle;">$<?= number_format($capacitacionInfo['cap_Costo'], 2, '.', ',') ?></td>
                            </tr>
                            <tr>
                                <td class="text-center" style="vertical-align: middle;">
                                    <div class="header">
                                        <h2><strong>Fechas:</strong></h2>
                                    </div>
                                </td>
                                <td class="text-center" style="vertical-align: middle;" class="text-center" style="vertical-align: middle;"><?= $txtFechas ?></td>
                                <td class="text-center" style="vertical-align: middle;">
                                    <div class="header">
                                        <h2><strong>Días:</strong></h2>
                                    </div>
                                </td>
                                <td class="text-center" style="vertical-align: middle;" class="text-center" style="vertical-align: middle;"> <?= $capacitacionInfo['cap_NumeroDias'] ?></td>
                                <td class="text-center" style="vertical-align: middle;">
                                    <div class="header">
                                        <h2><strong>Lugar:</strong></h2>
                                    </div>
                                </td>
                                <td class="text-center" style="vertical-align: middle;" class="text-center" style="vertical-align: middle;"> <?= $capacitacionInfo['cap_Lugar'] ?></td>
                            </tr>

                            <tr>
                                <td class="text-center" style="vertical-align: middle;">
                                    <div class="header">
                                        <h2><strong><?= $txtImparte ?>:</strong></h2>
                                    </div>
                                </td>
                                <td class="text-center" style="vertical-align: middle;" class="text-center" style="vertical-align: middle;" colspan="5"><?= $imparte ?></td>
                            <tr>
                                <td class="text-center" style="vertical-align: middle;">
                                    <div class="header">
                                        <h2><strong>Objetivo:</strong></h2>
                                    </div>
                                </td>
                                <td class="text-center" style="vertical-align: middle;" class="text-center" style="vertical-align: middle;" colspan="5"><?= $capacitacionInfo['cur_Objetivo'] ?></td>
                            </tr>
                            <tr>
                                <td class="text-center" style="vertical-align: middle;">
                                    <div class="header">
                                        <h2><strong>Dirigido a:</strong></h2>
                                    </div>
                                </td>
                                <td class="text-center" style="vertical-align: middle;" class="text-center" style="vertical-align: middle;" colspan="5"><?= $capacitacionInfo['cap_Dirigido'] ?></td>
                            </tr>
                            <tr>
                                <td class="text-center" style="vertical-align: middle;">
                                    <div class="header">
                                        <h2><strong>Observaciones:</strong></h2>
                                    </div>
                                </td>
                                <td class="text-center" style="vertical-align: middle;" class="text-center" style="vertical-align: middle;" colspan="5"><?= $capacitacionInfo['cap_Observaciones'] ?></td>
                            </tr>
                            <?php
                            if ($capacitacionInfo['cap_Comprobante'] === "SI") {
                            ?>
                                <tr>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <div class="header">
                                            <h2><strong>Comprobante a otorgar:</strong></h2>
                                        </div>
                                    </td>
                                    <td class="text-center" style="vertical-align: middle;" class="text-center" style="vertical-align: middle;" colspan="5" style="height: 20px" class="text-center"><img src="<?= base_url('assets/images/capacitacion/' . $comprobante) ?>" class="img-thumbnail" alt="" style="height: 200px"></td>
                                </tr>

                            <?php
                            }
                            ?>
                            <tr>
                                <td class="text-center" style="vertical-align: middle;">
                                    <div class="header">
                                        <h2><strong>Calificación aprobatoria:</strong></h2>
                                    </div>
                                </td>
                                <td class="text-center" style="vertical-align: middle;" class="text-center" style="vertical-align: middle;" colspan="5" style="height: 20px" class="text-center"><?= $capacitacionInfo['cap_CalAprobatoria'] !== 0 ? $capacitacionInfo['cap_CalAprobatoria'] : 'No aplica.'  ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>


                <div class="col-md-12 mt-4">
                    <ul class="nav nav-tabs">
                        <li class="nav-item" style="width: 20%; text-align:center;"><a href="#convocatoria" class="nav-link active" data-toggle="tab"><i class="zmdi zmdi-collection-image"></i> Convocatoria</a></li>
                        <li class="nav-item" style="width: 20%; text-align:center;"><a href="#participantes" class="nav-link" data-toggle="tab"><i class="zmdi zmdi-assignment-account"></i> Participantes</a></li>
                        <li class="nav-item" style="width: 20%; text-align:center;"><a href="#material" class="nav-link" data-toggle="tab"><i class="zmdi zmdi-satellite"></i> Material</a></li>
                        <li class="nav-item" style="width: 20%; text-align:center;"><a href="#asistencia" class="nav-link" data-toggle="tab"><i class="zmdi zmdi-view-list-alt"></i> Asistencia</a></li>
                        <li class="nav-item" style="width: 20%; text-align:center;"><a href="#encuesta" class="nav-link" data-toggle="tab"><i class="zmdi zmdi-accounts-list"></i> Encuesta</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane show active" id="convocatoria">
                            <?php
                            $convocatoria = convocatoriaCapacitacion((int)$capacitacionInfo['cap_CapacitacionID']);

                            if (count($convocatoria) <= 0) {
                            ?>
                                <div class="col-md-12">
                                    <form id="formConvocatoria" method="post" enctype="multipart/form-data">
                                        <div class="form-group ">
                                            <div class="file-loading">
                                                <input id="fileConvocatoria" name="fileConvocatoria" type="file" class="file">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-md-12 text-right">
                                    <a href="#" id="btnSubirConvocatoria" class="btn btn-success btn-round">Guardar</a>
                                </div>
                            <?php } else {
                                $archivoNombreC = explode('/', $convocatoria[0]);
                                $count = count($archivoNombreC) - 1;
                                $nombreC = explode('.', $archivoNombreC[$count]);
                            ?>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="file-man-box rounded mb-3">
                                            <a href="" id="borrarConvocatoria" data-id="<?= $capacitacionInfo['cap_CapacitacionID'] ?>" data-archivo="<?= $nombreC[0] . '.' . $nombreC[1] ?>" class="file-close"><i class="mdi mdi-close-circle"></i></a>
                                            <div class="row justify-content-center">
                                                <img src="<?= $convocatoria[0] ?>" class="img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="tab-pane show " id="participantes">
                            <input name="cap_CapacitacionID" id="cap_CapacitacionID" value="<?= (int)$capacitacionInfo['cap_CapacitacionID'] ?>" hidden>
                            <div class="row mb-3">
                                <div class="col-md-12 text-right">
                                    <?php if (revisarPermisos('Agregar', 'participantesCapacitacion')) { ?>
                                        <button type="button" class="btn btn-success btn-round btnModalParticipantes"><span><i class="fa fa-plus"></i> Agregar participantes</span></button>
                                    <?php } ?>
                                </div>
                            </div>
                            <table id="tblParticipantes" class="table cls-table m-0 table-bordered dt-responsive" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Número de empleado</th>
                                        <th>Nombre</th>
                                        <th>Puesto</th>
                                        <th>Area</th>
                                        <th>Sucursal</th>
                                        <th>Calificación</th>
                                        <th>Acciones</th>
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
                                            <input id="fileMaterial" name="fileMaterial[]" type="file" class="file" multiple>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-12 text-right">
                                <a href="#" id="btnSubirMaterial" class="btn btn-success btn-round">Guardar</a>
                            </div>
                            <br>
                            <!--Material-->
                            <div class="col-12">
                                <div class="row">
                                    <?php
                                    $materiales = materialesCapacitacion((int)$capacitacionInfo['cap_CapacitacionID']);
                                    if (!empty($materiales)) {
                                        $iconos = [
                                            'jpg' => 'jpg.svg', 'peg' => 'jpg.svg', 'png' => 'png.svg',
                                            'pdf' => 'pdf.svg', 'doc' => 'doc.svg', 'ocx' => 'doc.svg',
                                            'xsl' => 'xls.svg', 'slx' => 'xls.svg', 'lsx' => 'xls.svg',
                                            'zip' => 'zip.svg', 'ptx' => 'ppt.svg'
                                        ];

                                        foreach ($materiales as $material) {
                                            $ext = strtolower(pathinfo($material, PATHINFO_EXTENSION));
                                            $imagen = base_url('assets/images/file_icons/' . ($iconos[$ext] ?? 'default.svg'));
                                            $archivoNombre = basename($material);
                                            $nombre = pathinfo($archivoNombre, PATHINFO_FILENAME);
                                    ?>

                                            <div class="col-lg-3">
                                                <div class="file-man-box rounded mb-3">
                                                    <a href="" id="borrarMaterial" data-id="<?= $capacitacionInfo['cap_CapacitacionID'] ?>" data-archivo="<?= $archivoNombre ?>" class="file-close">
                                                        <i class="zmdi zmdi-close-circle-o"></i>
                                                    </a>
                                                    <a href="<?= $material ?>" target="_blank" class="file-download" style="text-decoration: none;">
                                                        <div class="file-img-box" style="width: 50%;">
                                                            <img src="<?= $imagen ?>" class="avatar-md" alt="icon">
                                                        </div>
                                                        <i class="mdi mdi-download"></i>
                                                    </a>
                                                    <div class="file-man-title">
                                                        <h5 class="mb-0 text-overflow"><?= substr($nombre, 0, 20) ?></h5>
                                                    </div>
                                                </div>
                                            </div>

                                    <?php }
                                    } ?>
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
                                <div class="tab-pane active" id="pase">
                                    <form id="formAsistencia">
                                        <div class="row">
                                            <div class="form-group col-md-6" style="padding-bottom: 1%">
                                                <label>* Fecha</label>
                                                <select id="asi_Fecha" name="asi_Fecha" class="select2">
                                                    <option value="" hidden>Seleccione</option>
                                                    <?php
                                                    if (!empty($fechasDisponibles)) {
                                                        foreach ($fechasDisponibles as $item) { ?>
                                                            <option value="<?= $item ?>"><?= longDate($item, ' de ') ?></option>
                                                    <?php }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <input name="asi_CapacitacionID" id="asi_CapacitacionID" value="<?= (int)$capacitacionInfo['cap_CapacitacionID'] ?>" hidden>
                                        <table id="tblListaAsistencia" class=" table cls-table m-0 table-bordered dt-responsive" cellspacing="0" width="100%">
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
                                            <div class="form-group col-md-12 text-right">
                                                <br>
                                                <button type="button" id="btnSaveAsistencia" class="mb-2 btn btn-success btn-round ">
                                                    Guardar
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="tab-pane" id="listas">
                                    <div class="row">
                                        <?php
                                        foreach ($arrAsi as $item) {
                                        ?>
                                            <div class="col-md-4">
                                                <div class="file-man-box rounded mb-3">
                                                    <div class="file-img-box" style="width: 50%;">
                                                        <a href="<?= base_url('PDF/imprimrlistaAsistencia/' . $capacitacionInfo['cap_CapacitacionID'] . "/" . $item) ?>" target="_blank">
                                                            <img src="<?= base_url('assets/images/file_icons/pdf.svg') ?>" class="avatar-lg" alt="icon">
                                                        </a>
                                                    </div>
                                                    <div class="file-man-title">
                                                        <h5 class="mb-0 text-overflow"><?= $item ?>.pdf</h5>
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
                                    <a href="<?= base_url("PDF/imprimirResultadosEncuesta/" . $capacitacionInfo['cap_CapacitacionID']) ?>" class="btn btn-info btn-round show-pdf" style="color: white" data-title="Resultados"><i class="fa fa-print"></i> Imprimir Resultados</a>
                                    <h3 class="text-center">RESULTADOS</h3>
                                    <div class="dashboard-donut-chart" style="height: 300px !important; width: 100% !important;">
                                        <canvas id="resultadosG" style="width: 650px"></canvas>
                                    </div>
                                </div>
                            </div>
                            <?php foreach ($secciones as $seccion) { ?>
                                <div style="margin-top: 20px;"></div> <!-- Salto de línea -->
                            <div class="header">
                                <h2><strong><?= $seccion['titulo'] ?></strong></h2>
                            </div>
                            <div class="row text-center">
                                <?php
                                for ($i = $seccion['rango'][0]; $i <= $seccion['rango'][1]; $i++) {
                                    $dataP = array();
                                    $resultP = db()->query("SELECT E." . $arrayPreguntas[$i]['field'] . " FROM encuestacapacitacion E WHERE E.ent_CapacitacionID=" . $capacitacionInfo['cap_CapacitacionID'])->getResultArray();
                                    $valoresP = array_count_values(array_column($resultP, $arrayPreguntas[$i]['field']));

                                    // Asignación de valores por defecto si no existen en el conteo
                                    $opciones = ["Totalmente en desacuerdo", "En desacuerdo", "Indeciso", "De acuerdo", "Totalmente de acuerdo"];
                                    foreach ($opciones as $opcion) {
                                        $dataP[] = isset($valoresP[$opcion]) ? $valoresP[$opcion] : 0;
                                    }

                                    $dataR[$arrayPreguntas[$i]['field']] = $dataP;
                                ?>
                                    <div class="col-lg-4" style="width: 100%;">
                                        <div class="header">
                                            <h2><strong><?= $arrayPreguntas[$i]['num'] ?>. <?= $arrayPreguntas[$i]['pregunta'] ?></strong></h2>
                                        </div>
                                        <div class="dashboard-donut-chart" style="height: 300px !important; width: 100% !important;">
                                            <canvas style="height: 270px !important;" id="<?= $arrayPreguntas[$i]['field'] ?>"></canvas>
                                        </div>
                                    </div>
                                <?php }
                                echo '</div>';
                                } ?>
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
                        <table id="tblEmpleados" class="table table_fija cls-table table-hover m-0  nowrap" width="95%" style="height: 100%;">
                            <thead style="position: sticky;top: 0; z-index: 10;background-color: #dbe2ea;">
                                <tr class="tr_fija">
                                    <th class="th_fija" width="5%"></th>
                                    <th class="th_fija">Nombre</th>
                                    <th class="th_fija">Puesto</th>
                                    <th class="th_fija">Área</th>
                                    <th class="th_fija">Sucursal</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div class="modal-footer text-right">
                    <button class="btn btn-light btn-round" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btnAgregarEmpleados" class="btn btn-success btn-round">Guardar</button>
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
                    <button class="btn btn-light btn-round" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btnAsiganrCalificacion" class="btn btn-success btn-round">Guardar</button>
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
        allowedFileExtensions: ['zip', 'docx', 'xlsx', 'pptx', 'pdf', 'png', 'jpg', 'jpeg'],
        dropZoneEnabled: false,
        showUpload: false,
    });

    $('#fileConvocatoria').fileinput({
        theme: 'fas',
        language: 'es',
        uploadUrl: '#',
        allowedFileExtensions: ['png', 'jpg', 'jpeg'],
        dropZoneEnabled: false,
        showUpload: false,
    });
</script>
<script src="<?= base_url("assets/js/Chart.bundle.min.js") ?>"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: 'Seleccione una opción',
            allowClear: true,
            width: 'resolve'
        });

        $(".show-pdf").hide();

        var centerTextPlugin = {
            afterDatasetsUpdate: function(chart) {},
            beforeDraw: function(chart) {
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
                activePercentage = chart.legend.legendItems[0].hidden ?
                    0 :
                    activePercentage;

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
                    activePercentage = chart.legend.legendItems[chart.pointIndex].hidden ?
                        0 :
                        activePercentage;
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
            beforeEvent: function(chart, event, options) {
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
            draw: function(ease) {
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
            var ctx = document.getElementById("resultadosG");
            var efec = new Chart(ctx, {

                type: "bar",
                data: {
                    labels: ['Metodologia utilizada', 'Instructor', 'Organización del evento', 'Satisfacción del evento'],
                    datasets: [{
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
                                echo $encuesta['satisfaccion'];
                                ?>]
                    }, ],
                },

                options: {
                    plugins: {
                        datalabels: {
                            display: true
                        }
                    },

                    maintainAspectRatio: false,

                    scales: {
                        yAxes: [{

                            ticks: {
                                min: 0,
                                max: 100,
                                stepSize: 10,
                            }
                        }],
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
                        onComplete: function() {
                            var ctx = this.chart.ctx;
                            ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontFamily, 'normal', Chart.defaults.global.defaultFontFamily);
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';

                            this.data.datasets.forEach(function(dataset) {
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
        var arrayPreguntas = JSON.stringify(<?php echo json_encode($dataR) ?>);


        // arrayPreguntas = JSON.stringify(arrayPreguntas);
        var arrayP = JSON.parse(arrayPreguntas);

        for (var pregunta in arrayP) {

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

        $('body').on('click', '#encuesta', function(evt) {
            guardarImagenes();
        });


        setTimeout(function() {
            $(".show-pdf").show();
        }, 1000);

        //Guardar imagenes Graficas
        function guardarImagenes() {
            var canvasGrafica = document.getElementById('resultadosG');
            var dataGrafica = canvasGrafica.toDataURL('image/png', 1.0);

            var imgs = dataGrafica;

            //Ajax guardar imagen
            $.ajax({
                url: BASE_URL + 'Formacion/ajax_guardarEncuestaCapacitacion/',
                type: 'post',
                cache: false,
                async: false,
                data: {
                    img: imgs,
                    id: <?= $capacitacionInfo['cap_CapacitacionID'] ?>
                }
            }).done(function(data) {
                console.log("La imagen se guardó correctamente");
            }).fail(function(data) {
                //console.log("Ocurrió un error de conexión. Por favor recargue la página e intente de nuevo.");
                //console.log(data);
            }).always(function(e) {}); //Ajax guardar imagen

        }

    });
</script>