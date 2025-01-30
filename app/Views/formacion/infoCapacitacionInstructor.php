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

    .card .header h2 {
        font-size: 15px !important;
    }
</style>
<?php
$curso = !empty($capacitacionInfo['cap_CursoID']) ? $capacitacionInfo['cur_Nombre'] : $capacitacionInfo['cap_CursoNombre'];

$imparte = $txtImparte = '';
if ($capacitacionInfo['cap_Tipo'] === "INTERNO" && !empty($capacitacionInfo['cap_InstructorID'])) {
    $instructor = db()->query("SELECT E.emp_Nombre FROM instructor I JOIN empleado E ON E.emp_EmpleadoID=I.ins_EmpleadoID WHERE ins_InstructorID=" . $capacitacionInfo['cap_InstructorID'])->getRowArray();
    $imparte = $instructor['emp_Nombre'];
    $txtImparte = "Nombre del instructor";
} elseif (!empty($capacitacionInfo['cap_ProveedorCursoID'])) {
    $proveedor = db()->query("SELECT pro_Nombre FROM proveedor WHERE pro_ProveedorID=" . $capacitacionInfo['cap_ProveedorCursoID'])->getRowArray();
    $imparte = $proveedor['pro_Nombre'];
    $txtImparte = "Nombre del proveedor";
}

$fechasJSON = json_decode($capacitacionInfo['cap_Fechas']);
$fechas = '';
$arrFechas = [];
foreach ($fechasJSON as $i => $fj) {
    $fechas .= shortDate($fj->fecha) . ' de ' . shortTime($fj->inicio) . ' a ' . shortTime($fj->fin) . ($i < count($fechasJSON) - 1 ? '<br>' : '');
    $arrFechas[] = $fj->fecha;
}
$fechas = json_decode($capacitacionInfo['cap_Fechas'], true);
$txtFechas = implode('<br>', array_map(fn ($fecha) => shortDate($fecha['fecha'], '-') . ' de ' . shortTime($fecha['inicio']) . ' a ' . shortTime($fecha['fin']), $fechas));


$arrAsi = array_column($asistencia, 'asi_Fecha');
$fechasDisponibles = array_diff($arrFechas, $arrAsi);
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
                            <li class="nav-item" style="width: 33.33%; text-align:center;"><a href="#participantes" class="nav-link active" data-toggle="tab"><i class="zmdi zmdi-assignment-account"></i> Participantes</a></li>
                            <li class="nav-item" style="width: 33.33%; text-align:center;"><a href="#material" class="nav-link" data-toggle="tab"><i class="zmdi zmdi-satellite"></i> Material</a></li>
                            <li class="nav-item" style="width: 33.33%; text-align:center;"><a href="#asistencia" class="nav-link" data-toggle="tab"><i class="zmdi zmdi-view-list-alt"></i> Asistencia</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane show active" id="participantes">
                                <input name="cap_CapacitacionID" id="cap_CapacitacionID" value="<?= (int)$capacitacionInfo['cap_CapacitacionID'] ?>" hidden>
                                <table id="tblParticipantes" class="table cls-table m-0 table-bordered dt-responsive" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>No. de socio</th>
                                            <th>Nombre</th>
                                            <th>Puesto</th>
                                            <th>Departamento</th>
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
                                <!--Material-->
                                <div class="col-12">
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
                                    <div class="header">
                                        <h2><strong>Material</strong></h2>
                                    </div>
                                    <div class="row">
                                        <?php
                                        $materiales = materialesCapacitacion((int)$capacitacionInfo['cap_CapacitacionID']);
                                        $icons = [
                                            'jpg' => 'file_icons/jpg.svg',
                                            'peg' => 'file_icons/jpg.svg',
                                            'png' => 'file_icons/png.svg',
                                            'pdf' => 'file_icons/pdf.svg',
                                            'ocx' => 'file_icons/doc.svg',
                                            'doc' => 'file_icons/doc.svg',
                                            'xls' => 'file_icons/xls.svg',
                                            'slx' => 'file_icons/xls.svg',
                                            'lsx' => 'file_icons/xls.svg',
                                            'zip' => 'file_icons/zip.svg',
                                            'ptx' => 'file_icons/ppt.svg'
                                        ];

                                        if (!empty($materiales)) {
                                            $cantidadMateriales = count($materiales);
                                            $colmd = ceil($cantidadMateriales / 12);  // Use ceil to handle non-divisible counts

                                            foreach ($materiales as $material) {
                                                $ext = strtolower(pathinfo($material, PATHINFO_EXTENSION));
                                                $imagen = isset($icons[$ext]) ? base_url('assets/images/' . $icons[$ext]) : '';

                                                $nombre = pathinfo($material, PATHINFO_FILENAME);
                                        ?>
                                                <div class="col-lg-3">
                                                    <div class="file-man-box rounded mb-3">
                                                        <a href="" id="borrarMaterial" data-id="<?= $capacitacionInfo['cap_CapacitacionID'] ?>" data-archivo="<?= $nombre ?>" class="file-close">
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
                                        <?php
                                            }
                                        }
                                        ?>
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
                                                        <th>No. de socio</th>
                                                        <th>Nombre</th>
                                                        <th>Asistencia</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                            <div class="row ">
                                                <div class="form-group col-md-12  text-right mb-1">
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
                    <button class="btn btn-light btn-round" data-dismiss="modal">Cancelar</button>
                    <button type="button" id="btnAsiganrCalificacion" class="btn btn-success btn-round">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: 'Seleccione una opción',
            allowClear: true,
            width: 'resolve'
        });
    });
    $('#fileMaterial').fileinput({
        theme: 'fas',
        language: 'es',
        uploadUrl: '#',
        allowedFileExtensions: ['zip', 'docx', 'xlsx', 'pptx', 'pdf', 'png', 'jpg', 'jpeg'],
        dropZoneEnabled: false,
        showUpload: false,
    });
</script>