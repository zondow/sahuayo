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
$fechas = json_decode($capacitacionInfo['cap_Fechas'], true);
$txtFechas = implode('<br>', array_map(fn ($fecha) => shortDate($fecha['fecha'], '-') . ' de ' . shortTime($fecha['inicio']) . ' a ' . shortTime($fecha['fin']), $fechas));

?>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
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
                                    <td class="text-center" style="vertical-align: middle;" colspan="3" class="text-center" style="vertical-align: middle;"><?= $curso ?></td>

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
                                </tr>
                                <tr>
                                    <td class="text-center" style="vertical-align: middle;">
                                        <div class="header">
                                            <h2><strong>Fechas:</strong></h2>
                                        </div>
                                    </td>
                                    <td class="text-center" colspan="3" style="vertical-align: middle;" class="text-center" style="vertical-align: middle;"><?= $txtFechas ?></td>
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
                            </tbody>
                        </table>
                    </div>


                    <div class="col-md-12 mt-4">
                        <ul class="nav nav-tabs">
                            <li class="nav-item" style="width: 50%; text-align:center;"><a href="#material" class="nav-link active" data-toggle="tab"><i class="zmdi zmdi-satellite"></i> Material</a></li>
                            <li class="nav-item" style="width: 50%; text-align:center;"><a href="#encuesta" class="nav-link" data-toggle="tab"><i class="zmdi zmdi-accounts-list"></i> Encuesta</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane show active " id="material">

                                <div class="row">
                                    <?php
                                    $materiales = materialesCapacitacion((int)$capacitacionInfo['cap_CapacitacionID']);
                                    if (!empty($materiales)) {
                                        $iconos = [
                                            'jpg' => 'jpg', 'peg' => 'peg', 'png' => 'png',
                                            'pdf' => 'pdf', 'ocx' => 'doc', 'doc' => 'doc',
                                            'xsl' => 'xls', 'slx' => 'xls', 'lsx' => 'xls',
                                            'zip' => 'zip', 'ptx' => 'ppt'
                                        ];

                                        foreach ($materiales as $material) {
                                            $ext = strtolower(substr($material, -3));
                                            $imagen = base_url('assets/images/file_icons/' . ($iconos[$ext] ?? 'default') . '.svg');
                                            $archivoNombre = explode('/', $material);
                                            $nombre = explode('.', end($archivoNombre));
                                    ?>
                                            <div class="col-lg-3">
                                                <div class="file-man-box rounded mb-3">
                                                    <a href="<?= $material ?>" target="_blank" class="file-download" style="text-decoration: none;">
                                                        <div class="file-img-box" style="width: 50%;">
                                                            <img src="<?= $imagen ?>" class="avatar-md" alt="icon">
                                                        </div>
                                                    </a>
                                                    <div class="file-man-title">
                                                        <h5 class="mb-0 text-overflow"><?= substr($nombre[0], 0, 20) ?></h5>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="tab-pane show " id="encuesta">
                                <?php
                                $fechaFin = date('Y-m-d');
                                if ($fechaFin === date('Y-m-d')) {
                                    if ($encuesta <= 0) { ?>
                                        <form role="form" action="<?= base_url("Formacion/saveEncuestaSatisfaccion/" . (int)$capacitacionInfo['cap_CapacitacionID']) ?>" method="post" autocomplete="off" novalidate>
                                            <div class="form-row">
                                                <div class="form-group col-md-9"></div>
                                                <div class="form-group col-md-3">
                                                    <input style="display: none;" id="txtFechaEncuesta" name="txtFechaEncuesta" type="text" class="form-control datepicker" data-position="bottom" placeholder="Fecha de la entrevista" value="<?= date("Y-m-d") ?>" readonly>
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
                                            <label class="mt-3 mb-0" style="width: 100%; text-align: right; font-size: 20px; color: #f8b32a"><b>Gracias por responder</b></label>

                                            <div class="form-row mt-3 text-center">
                                                <div class="form-group col-md-12">
                                                    <button id="btnGuardarEncuesta" type="submit" class="mb-2 btn btn-success btn-round">
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
                                            <div class="alert alert-info text-center" style="border-radius: 50px;" role="alert">
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