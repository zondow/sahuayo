<link href="<?= base_url("assets/plugins/fileinput/css/fileinput.css") ?>" media="all" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">
<link href="<?= base_url("assets/plugins/fileinput/themes/explorer-fas/theme.css") ?>" media="all" rel="stylesheet" type="text/css" />
<script src="<?= base_url("assets/plugins/fileinput/js/fileinput.js") ?>" type="text/javascript"></script>
<script src="<?= base_url("assets/plugins/fileinput/js/locales/es.js") ?>" type="text/javascript"></script>
<script src="<?= base_url("assets/plugins/fileinput/themes/fas/theme.js") ?>" type="text/javascript"></script>
<script src="<?= base_url("assets/plugins/fileinput/themes/explorer-fas/theme.js") ?>" type="text/javascript"></script>

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
$curso = "";
$imparte = "";
$txtImparte = "";

if (!empty($capacitacionInfo['cap_CursoID'])) $curso = $capacitacionInfo['cur_Nombre'];
else $curso = $capacitacionInfo['cap_CursoNombre'];

if ($capacitacionInfo['cap_Tipo'] === "INTERNO") {
    if (!empty($capacitacionInfo['cap_InstructorID'])) {
        $instructor = db()->query("SELECT I.*, E.emp_Nombre FROM instructor I 
                                        JOIN empleado E ON E.emp_EmpleadoID=I.ins_EmpleadoID
                                        WHERE ins_InstructorID=" . $capacitacionInfo['cap_InstructorID'])->getRowArray();
        $imparte = $instructor['emp_Nombre'];
        $txtImparte = "Nombre del instructor";
    }
} else {
    if (!empty($capacitacionInfo['cap_ProveedorCursoID'])) {
        $proveedor = db()->query("SELECT * FROM proveedor WHERE pro_ProveedorID=" . $capacitacionInfo['cap_ProveedorCursoID'])->getRowArray();
        $imparte = $proveedor['pro_Nombre'];
        $txtImparte = "Nombre del proveedor";
    }
}

$fechasJSON = json_decode($capacitacionInfo['cap_Fechas']);
$fechas = '';
$totalFJ = count($fechasJSON);
$i = 0;
$fechaFin = '';
foreach ($fechasJSON as $fj) {
    $fechas .= shortDate($fj->fecha) . ' de ' . shortTime($fj->inicio) . ' a ' . shortTime($fj->fin);
    $i++;
    if ($i < $totalFJ) $fechas .= '<br>';
    if ($i == $totalFJ) $fechaFin = $fj->fecha;
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
                                <td colspan="3"><?= $curso ?></td>
                            </tr>
                            <tr>
                                <td><span class="badge badge-info">Tipo:</span></td>
                                <td><?= $capacitacionInfo['cap_Tipo']  ?></td>
                                <td><span class="badge badge-info">Modalidad:</span></td>
                                <td><?= $capacitacionInfo['cur_Modalidad']  ?></td>
                            </tr>
                            <tr>
                                <td><span class="badge badge-info">Fechas:</span></td>
                                <td colspan="3"><?= $fechas ?></td>
                            </tr>
                            <tr>
                                <td><span class="badge badge-info"><?= $txtImparte ?></span></td>
                                <td colspan="3"><?= $imparte ?></td>
                            <tr>
                                <td><span class="badge badge-info">Objetivo:</span></td>
                                <td colspan="3"><?= $capacitacionInfo['cur_Objetivo'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>


                <div class="col-md-12 mt-4">
                    <ul class="nav nav-pills navtab-bg nav-justified pull-in ">
                        <li class="nav-item">
                            <a href="#material" data-toggle="tab" aria-expanded="true" class="nav-link active">
                                <i class="fas fa-wrench"></i> <span class="d-none d-sm-inline-block ml-2">Material</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#encuesta" data-toggle="tab" aria-expanded="false" class="nav-link ">
                                <i class="fas fa-chart-bar"></i><span class="d-none d-sm-inline-block ml-2">Encuesta</span>
                            </a>
                        </li>

                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane show active " id="material">

                            <div class="row">
                                <?php
                                $materiales = materialesCapacitacion((int)$capacitacionInfo['cap_CapacitacionID']);
                                if (!empty($materiales)) {
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
                                        $count = count($archivoNombre) - 1;
                                        $nombre = explode('.', $archivoNombre[$count]);
                                        ?>
                                        <div class="col-lg-3">
                                            <div class="file-man-box rounded mb-3">
                                                <div class="file-img-box">
                                                    <img src="<?= $imagen ?>" class="avatar-lg" alt="icon">
                                                </div>
                                                <a href="<?= $material ?>" class="file-download"><i class="mdi mdi-download"></i> </a>
                                                <div class="file-man-title">
                                                    <h5 class="mb-0 text-overflow"><?= substr($nombre[0], 0, 20) ?></h5>
                                                </div>
                                            </div>
                                        </div>
                                <?php

                                    }
                                } ?>
                            </div>
                        </div>
                        <div class="tab-pane show " id="encuesta">
                            <?php
                            if ($fechaFin === date('Y-m-d')) {
                                if ($encuesta <= 0) { ?>
                                    <form role="form" action="<?= base_url("Formacion/saveEncuestaSatisfaccion/" . (int)$capacitacionInfo['cap_CapacitacionID']) ?>" method="post" autocomplete="off" novalidate>
                                        <div class="form-row">
                                            <div class="form-group col-md-9"></div>
                                            <div class="form-group col-md-3">
                                                <label for="txtFechaEncuesta">Fecha</label>
                                                <input id="txtFechaEncuesta" name="txtFechaEncuesta" type="text" class="form-control datepicker" data-position="bottom" placeholder="Fecha de la entrevista" value="<?= date("Y-m-d") ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <p>El objetivo de este cuestionario es valorar la calidad de los procesos de enseñanza y
                                                aprendizaje desde el punto de vista de los participantes. Te pido tu opinión sobre el desempeño del ponente y las características del curso
                                                (las respuestas son anónimas y te pido de favor contestes reflexivamente y con sinceridad).</p>
                                        </div>
                                        <br>
                                        <label>
                                            Por favor marca con una &nbsp;&nbsp;<span class="font-16" style="color: #eb5b2d">&#10007</span> &nbsp; segun las siguientes opciones:
                                        </label>
                                        <!--INSTRUCCIONES-->
                                        <table class="data-table data-table-scrollable responsive nowrap">
                                            <thead style="display: none;">
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><span class="badge badge-light font-13"><b>TA</b>&nbsp;&nbsp;&nbsp;Totalmente de acuerdo</span></td>
                                                    <td><span class="badge badge-light font-13"><b>D </b>&nbsp;&nbsp;De acuerdo</span></td>
                                                    <td><span class="badge badge-light font-13"><b>I </b>&nbsp;&nbsp;&nbsp;Indeciso</span></td>
                                                    <td><span class="badge badge-light font-13"><b>ED</b>&nbsp;&nbsp;&nbsp;En desacuerdo</span></td>
                                                    <td><span class="badge badge-light font-13"><b>TD</b>&nbsp;&nbsp;&nbsp;Totalmente en desacuerdo</span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <label class="mt-5 mb-2">
                                            <b>I METODOLOGIA UTILIZADA</b>
                                        </label>
                                        <br>
                                        <div style="overflow:auto;">
                                            <table id="tbl_Metodologia" class="data-table responsive nowrap table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th width="65%"></th>
                                                        <th width="5%">TA</th>
                                                        <th width="5%">D</th>
                                                        <th width="5%">I </th>
                                                        <th width="5%">ED</th>
                                                        <th width="5%">TD</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1. Al empezar se plantearon los objetivos y el programa detallado del curso.</td>
                                                        <td id="TA_TblMetodologia1" class="tdClick" data-row="TblMetodologia1" data-valor="Totalmente de acuerdo"></td>
                                                        <td id="D_TblMetodologia1" class="tdClick" data-row="TblMetodologia1" data-valor="De acuerdo"></td>
                                                        <td id="I_TblMetodologia1" class="tdClick" data-row="TblMetodologia1" data-valor="Indeciso"></td>
                                                        <td id="ED_TblMetodologia1" class="tdClick" data-row="TblMetodologia1" data-valor="En desacuerdo"></td>
                                                        <td id="TD_TblMetodologia1" class="tdClick" data-row="TblMetodologia1" data-valor="Totalmente en desacuerdo"></td>
                                                        <input id="txtMetodologia1_A" name="txtMetodologia1_A" type="text" class="form-control txt-hidden" readonly>
                                                    </tr>
                                                    <tr>
                                                        <td>2. La forma en que se llevo a cabo este curso me ayudo a aprender.</td>
                                                        <td id="TA_TblMetodologia2" class="tdClick" data-row="TblMetodologia2" data-valor="Totalmente de acuerdo"></td>
                                                        <td id="D_TblMetodologia2" class="tdClick" data-row="TblMetodologia2" data-valor="De acuerdo"></td>
                                                        <td id="I_TblMetodologia2" class="tdClick" data-row="TblMetodologia2" data-valor="Indeciso"></td>
                                                        <td id="ED_TblMetodologia2" class="tdClick" data-row="TblMetodologia2" data-valor="En desacuerdo"></td>
                                                        <td id="TD_TblMetodologia2" class="tdClick" data-row="TblMetodologia2" data-valor="Totalmente en desacuerdo"></td>
                                                        <input id="txtMetodologia1_B" name="txtMetodologia1_B" type="text" class="form-control txt-hidden" readonly>
                                                    </tr>
                                                    <tr>
                                                        <td>3. Los materiales del curso han sido utiles para el aprendizaje.</td>
                                                        <td id="TA_TblMetodologia3" class="tdClick" data-row="TblMetodologia3" data-valor="Totalmente de acuerdo"></td>
                                                        <td id="D_TblMetodologia3" class="tdClick" data-row="TblMetodologia3" data-valor="De acuerdo"></td>
                                                        <td id="I_TblMetodologia3" class="tdClick" data-row="TblMetodologia3" data-valor="Indeciso"></td>
                                                        <td id="ED_TblMetodologia3" class="tdClick" data-row="TblMetodologia3" data-valor="En desacuerdo"></td>
                                                        <td id="TD_TblMetodologia3" class="tdClick" data-row="TblMetodologia3" data-valor="Totalmente en desacuerdo"></td>
                                                        <input id="txtMetodologia1_C" name="txtMetodologia1_C" type="text" class="form-control txt-hidden" readonly>
                                                    </tr>
                                                    <tr>
                                                        <td>4. La calidad del material entregado ha sido adecuado.</td>
                                                        <td id="TA_TblMetodologia4" class="tdClick" data-row="TblMetodologia4" data-valor="Totalmente de acuerdo"></td>
                                                        <td id="D_TblMetodologia4" class="tdClick" data-row="TblMetodologia4" data-valor="De acuerdo"></td>
                                                        <td id="I_TblMetodologia4" class="tdClick" data-row="TblMetodologia4" data-valor="Indeciso"></td>
                                                        <td id="ED_TblMetodologia4" class="tdClick" data-row="TblMetodologia4" data-valor="En desacuerdo"></td>
                                                        <td id="TD_TblMetodologia4" class="tdClick" data-row="TblMetodologia4" data-valor="Totalmente en desacuerdo"></td>
                                                        <input id="txtMetodologia1_D" name="txtMetodologia1_D" type="text" class="form-control txt-hidden" readonly>
                                                    </tr>
                                                    <tr>
                                                        <td>5. La evaluación se ha realizado de forma adecuada.</td>
                                                        <td id="TA_TblMetodologia5" class="tdClick" data-row="TblMetodologia5" data-valor="Totalmente de acuerdo"></td>
                                                        <td id="D_TblMetodologia5" class="tdClick" data-row="TblMetodologia5" data-valor="De acuerdo"></td>
                                                        <td id="I_TblMetodologia5" class="tdClick" data-row="TblMetodologia5" data-valor="Indeciso"></td>
                                                        <td id="ED_TblMetodologia5" class="tdClick" data-row="TblMetodologia5" data-valor="En desacuerdo"></td>
                                                        <td id="TD_TblMetodologia5" class="tdClick" data-row="TblMetodologia5" data-valor="Totalmente en desacuerdo"></td>
                                                        <input id="txtMetodologia1_E" name="txtMetodologia1_E" type="text" class="form-control txt-hidden" readonly>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <label class="mt-5 mb-2">
                                            <b>II. INSTRUCTOR</b>
                                        </label>
                                        <br>
                                        <div style="overflow:auto;">
                                            <table id="tbl_Instructor" class="data-table responsive nowrap table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th width="65%"></th>
                                                        <th width="5%">TA</th>
                                                        <th width="5%">D</th>
                                                        <th width="5%">I </th>
                                                        <th width="5%">ED</th>
                                                        <th width="5%">TD</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>6. El ponente cumplió con el programa planteado para el curso.</td>
                                                        <td id="TA_TblInstructor1" class="tdClick" data-row="TblInstructor1" data-valor="Totalmente de acuerdo"></td>
                                                        <td id="D_TblInstructor1" class="tdClick" data-row="TblInstructor1" data-valor="De acuerdo"></td>
                                                        <td id="I_TblInstructor1" class="tdClick" data-row="TblInstructor1" data-valor="Indeciso"></td>
                                                        <td id="ED_TblInstructor1" class="tdClick" data-row="TblInstructor1" data-valor="En desacuerdo"></td>
                                                        <td id="TD_TblInstructor1" class="tdClick" data-row="TblInstructor1" data-valor="Totalmente en desacuerdo"></td>
                                                        <input id="txtInstructor1_A" name="txtInstructor1_A" type="text" class="form-control txt-hidden" readonly>
                                                    </tr>
                                                    <tr>
                                                        <td>7. El ponente se expresa con claridad.</td>
                                                        <td id="TA_TblInstructor2" class="tdClick" data-row="TblInstructor2" data-valor="Totalmente de acuerdo"></td>
                                                        <td id="D_TblInstructor2" class="tdClick" data-row="TblInstructor2" data-valor="De acuerdo"></td>
                                                        <td id="I_TblInstructor2" class="tdClick" data-row="TblInstructor2" data-valor="Indeciso"></td>
                                                        <td id="ED_TblInstructor2" class="tdClick" data-row="TblInstructor2" data-valor="En desacuerdo"></td>
                                                        <td id="TD_TblInstructor2" class="tdClick" data-row="TblInstructor2" data-valor="Totalmente en desacuerdo"></td>
                                                        <input id="txtInstructor1_B" name="txtInstructor1_B" type="text" class="form-control txt-hidden" readonly>
                                                    </tr>
                                                    <tr>
                                                        <td>8. El ponente demuestra conocimiento actualizado de su materia.</td>
                                                        <td id="TA_TblInstructor3" class="tdClick" data-row="TblInstructor3" data-valor="Totalmente de acuerdo"></td>
                                                        <td id="D_TblInstructor3" class="tdClick" data-row="TblInstructor3" data-valor="De acuerdo"></td>
                                                        <td id="I_TblInstructor3" class="tdClick" data-row="TblInstructor3" data-valor="Indeciso"></td>
                                                        <td id="ED_TblInstructor3" class="tdClick" data-row="TblInstructor3" data-valor="En desacuerdo"></td>
                                                        <td id="TD_TblInstructor3" class="tdClick" data-row="TblInstructor3" data-valor="Totalmente en desacuerdo"></td>
                                                        <input id="txtInstructor1_C" name="txtInstructor1_C" type="text" class="form-control txt-hidden" readonly>
                                                    </tr>
                                                    <tr>
                                                        <td>9. El ponente promueve que los alumnos expresen sus ideas.</td>
                                                        <td id="TA_TblInstructor4" class="tdClick" data-row="TblInstructor4" data-valor="Totalmente de acuerdo"></td>
                                                        <td id="D_TblInstructor4" class="tdClick" data-row="TblInstructor4" data-valor="De acuerdo"></td>
                                                        <td id="I_TblInstructor4" class="tdClick" data-row="TblInstructor4" data-valor="Indeciso"></td>
                                                        <td id="ED_TblInstructor4" class="tdClick" data-row="TblInstructor4" data-valor="En desacuerdo"></td>
                                                        <td id="TD_TblInstructor4" class="tdClick" data-row="TblInstructor4" data-valor="Totalmente en desacuerdo"></td>
                                                        <input id="txtInstructor1_D" name="txtInstructor1_D" type="text" class="form-control txt-hidden" readonly>
                                                    </tr>
                                                    <tr>
                                                        <td>10. El ponente atiende adecuadamente las preguntas de los participantes.</td>
                                                        <td id="TA_TblInstructor5" class="tdClick" data-row="TblInstructor5" data-valor="Totalmente de acuerdo"></td>
                                                        <td id="D_TblInstructor5" class="tdClick" data-row="TblInstructor5" data-valor="De acuerdo"></td>
                                                        <td id="I_TblInstructor5" class="tdClick" data-row="TblInstructor5" data-valor="Indeciso"></td>
                                                        <td id="ED_TblInstructor5" class="tdClick" data-row="TblInstructor5" data-valor="En desacuerdo"></td>
                                                        <td id="TD_TblInstructor5" class="tdClick" data-row="TblInstructor5" data-valor="Totalmente en desacuerdo"></td>
                                                        <input id="txtInstructor1_E" name="txtInstructor1_E" type="text" class="form-control txt-hidden" readonly>
                                                    </tr>
                                                    <tr>
                                                        <td>11. El ponente se apego a los tiempos establecidos del curso.</td>
                                                        <td id="TA_TblInstructor6" class="tdClick" data-row="TblInstructor6" data-valor="Totalmente de acuerdo"></td>
                                                        <td id="D_TblInstructor6" class="tdClick" data-row="TblInstructor6" data-valor="De acuerdo"></td>
                                                        <td id="I_TblInstructor6" class="tdClick" data-row="TblInstructor6" data-valor="Indeciso"></td>
                                                        <td id="ED_TblInstructor6" class="tdClick" data-row="TblInstructor6" data-valor="En desacuerdo"></td>
                                                        <td id="TD_TblInstructor6" class="tdClick" data-row="TblInstructor6" data-valor="Totalmente en desacuerdo"></td>
                                                        <input id="txtInstructor1_F" name="txtInstructor1_F" type="text" class="form-control txt-hidden" readonly>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <label class="mt-5 mb-2">
                                            <b>III. ORGANIZACIÓN DEL EVENTO</b>
                                        </label>
                                        <br>
                                        <div style="overflow:auto;">
                                            <table id="tbl_Organizacion" class="data-table responsive nowrap table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th width="65%"></th>
                                                        <th width="5%">TA</th>
                                                        <th width="5%">D</th>
                                                        <th width="5%">I </th>
                                                        <th width="5%">ED</th>
                                                        <th width="5%">TD</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>11. Los medios técnicos utilizados fueron adecuados (cañon, bocina, etc.).</td>
                                                        <td id="TA_TblOrganizacion1" class="tdClick" data-row="TblOrganizacion1" data-valor="Totalmente de acuerdo"></td>
                                                        <td id="D_TblOrganizacion1" class="tdClick" data-row="TblOrganizacion1" data-valor="De acuerdo"></td>
                                                        <td id="I_TblOrganizacion1" class="tdClick" data-row="TblOrganizacion1" data-valor="Indeciso"></td>
                                                        <td id="ED_TblOrganizacion1" class="tdClick" data-row="TblOrganizacion1" data-valor="En desacuerdo"></td>
                                                        <td id="TD_TblOrganizacion1" class="tdClick" data-row="TblOrganizacion1" data-valor="Totalmente en desacuerdo"></td>
                                                        <input id="txtOrganizacion1_A" name="txtOrganizacion1_A" type="text" class="form-control txt-hidden" readonly>
                                                    </tr>
                                                    <tr>
                                                        <td>12. El aula o espacio utilizado fue adecuado(aire acondicionado, sillas,etc.).</td>
                                                        <td id="TA_TblOrganizacion2" class="tdClick" data-row="TblOrganizacion2" data-valor="Totalmente de acuerdo"></td>
                                                        <td id="D_TblOrganizacion2" class="tdClick" data-row="TblOrganizacion2" data-valor="De acuerdo"></td>
                                                        <td id="I_TblOrganizacion2" class="tdClick" data-row="TblOrganizacion2" data-valor="Indeciso"></td>
                                                        <td id="ED_TblOrganizacion2" class="tdClick" data-row="TblOrganizacion2" data-valor="En desacuerdo"></td>
                                                        <td id="TD_TblOrganizacion2" class="tdClick" data-row="TblOrganizacion2" data-valor="Totalmente en desacuerdo"></td>
                                                        <input id="txtOrganizacion1_B" name="txtOrganizacion1_B" type="text" class="form-control txt-hidden" readonly>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <label class="mt-5 mb-2">
                                            <b>IV. SATISFACCIION ACERCA DEL EVENTO</b>
                                        </label>
                                        <br>
                                        <div style="overflow:auto;">
                                            <table id="tbl_Satisfaccion" class="data-table responsive nowrap table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th width="65%"></th>
                                                        <th width="5%">TA</th>
                                                        <th width="5%">D</th>
                                                        <th width="5%">I </th>
                                                        <th width="5%">ED</th>
                                                        <th width="5%">TD</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>14. Lo aprendido en el curso se puede aplicar en mi puesto de trabajo.</td>
                                                        <td id="TA_TblSatisfaccion1" class="tdClick" data-row="TblSatisfaccion1" data-valor="Totalmente de acuerdo"></td>
                                                        <td id="D_TblSatisfaccion1" class="tdClick" data-row="TblSatisfaccion1" data-valor="De acuerdo"></td>
                                                        <td id="I_TblSatisfaccion1" class="tdClick" data-row="TblSatisfaccion1" data-valor="Indeciso"></td>
                                                        <td id="ED_TblSatisfaccion1" class="tdClick" data-row="TblSatisfaccion1" data-valor="En desacuerdo"></td>
                                                        <td id="TD_TblSatisfaccion1" class="tdClick" data-row="TblSatisfaccion1" data-valor="Totalmente en desacuerdo"></td>
                                                        <input id="txtSatisfaccion1_A" name="txtSatisfaccion1_A" type="text" class="form-control txt-hidden" readonly>
                                                    </tr>
                                                    <tr>
                                                        <td>15. Tus expectativas de aprendizaje se cumplieron.</td>
                                                        <td id="TA_TblSatisfaccion2" class="tdClick" data-row="TblSatisfaccion2" data-valor="Totalmente de acuerdo"></td>
                                                        <td id="D_TblSatisfaccion2" class="tdClick" data-row="TblSatisfaccion2" data-valor="De acuerdo"></td>
                                                        <td id="I_TblSatisfaccion2" class="tdClick" data-row="TblSatisfaccion2" data-valor="Indeciso"></td>
                                                        <td id="ED_TblSatisfaccion2" class="tdClick" data-row="TblSatisfaccion2" data-valor="En desacuerdo"></td>
                                                        <td id="TD_TblSatisfaccion2" class="tdClick" data-row="TblSatisfaccion2" data-valor="Totalmente en desacuerdo"></td>
                                                        <input id="txtSatisfaccion1_B" name="txtSatisfaccion1_B" type="text" class="form-control txt-hidden" readonly>
                                                    </tr>
                                                    <tr>
                                                        <td>16. Te gustaría tomar otro curso similar.</td>
                                                        <td id="TA_TblSatisfaccion3" class="tdClick" data-row="TblSatisfaccion3" data-valor="Totalmente de acuerdo"></td>
                                                        <td id="D_TblSatisfaccion3" class="tdClick" data-row="TblSatisfaccion3" data-valor="De acuerdo"></td>
                                                        <td id="I_TblSatisfaccion3" class="tdClick" data-row="TblSatisfaccion3" data-valor="Indeciso"></td>
                                                        <td id="ED_TblSatisfaccion3" class="tdClick" data-row="TblSatisfaccion3" data-valor="En desacuerdo"></td>
                                                        <td id="TD_TblSatisfaccion3" class="tdClick" data-row="TblSatisfaccion3" data-valor="Totalmente en desacuerdo"></td>
                                                        <input id="txtSatisfaccion1_C" name="txtSatisfaccion1_C" type="text" class="form-control txt-hidden" readonly>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="form-row mt-5">
                                            <div class="form-group col-md-12">
                                                <label><b>Por favor escribe aquí algun comentarios o sugerencia</b></label>
                                                <textarea id="txtComentarios" name="txtComentarios" type="text" class="form-control" placeholder="Comentarios o sugerencia" rows="5"></textarea>
                                            </div>
                                        </div>
                                        <label class="mt-3 mb-0" style="width: 100%; text-align: right; font-size: 20px; color: #f8b32a"><b>¡ ¡ Gracias por tu apoyo ! !</b></label>

                                        <div class="form-row mt-3 text-center">
                                            <div class="form-group col-md-12">
                                                <button id="btnGuardarEncuesta" type="submit" class="mb-2 btn btn-success">
                                                    <span class="label">&nbsp;Guardar</span>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                <?php } else { ?>
                                    <div class="col-md-12 ">
                                        <div class="file-man-box rounded mb-3">
                                            <div class="file-img-box">
                                                <iframe src="<?= base_url("PDF/imprimirEncuestaCapacitacion/" . $encuesta['ent_EncuestaID']) ?>" frameborder="no" width="100%" style="min-height: 500px;">
                                                </iframe>
                                            </div>
                                        </div>
                                    </div>
                                <?php }
                            } else { ?>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="alert alert-info text-center" role="alert">
                                            La encuesta de satisfacción estara diponible el día <?= longDate($fechaFin, ' de ') ?>.
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


<script>
    $('#fileMaterial').fileinput({
        theme: 'fas',
        language: 'es',
        uploadUrl: '#',
        allowedFileExtensions: ['zip', 'docx', 'xlsx', 'pptx', 'pdf', 'png', 'jpg', 'jpeg'],
        dropZoneEnabled: false,
        showUpload: false,
    });
</script>