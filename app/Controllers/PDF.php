<?php

namespace App\Controllers;

defined('FCPATH') or exit('No direct script access allowed');

use App\Models\PdfModel;
use App\Models\FormacionModel;
use App\Models\EvaluacionesModel;

require(APPPATH . 'Libraries/fpdf/fpdf.php');
require(APPPATH . 'Libraries/fpdi/autoload.php');

use Spipu\Html2Pdf\Html2Pdf;
use \Mpdf\Mpdf;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;

class PDF extends BaseController
{

    //Diego - PDF del perfil de puesto
    public function perfilPuestoPdf($idpuesto)
    {
        $idpuesto = encryptDecrypt('decrypt', $idpuesto);
        //datos
        $model = $this->PdfModel;
        $perfilPuesto = $model->getPerfilPuestoid($idpuesto);
        if ($perfilPuesto['puestosReporta'] !== null) {
            $puestos = json_decode($perfilPuesto['puestosReporta']);
            $count = count($puestos) - 1;
            $comite = '';
            for ($i = 0; $i <= $count; $i++) {
                if ($puestos[$i] == 999) {
                    unset($puestos[$i]);
                    $comite = 'COMITE';
                }
            }
            $perfilPuesto['puestosReporta'] = $model->getPuestosCoordinaReporta(implode(",", $puestos));
            $count = count($perfilPuesto['puestosReporta']);
            if (!empty($comite)) {
                $perfilPuesto['puestosReporta'][$count]["puesto"] = $comite;
            }
        }

        if ($perfilPuesto['puestosCoordina'] !== "null") {
            $perfilPuesto['puestosCoordina'] = $model->getPuestosCoordinaReporta(implode(",", json_decode($perfilPuesto['puestosCoordina'])));
        }
        $perfilPuesto['competenciasPuesto'] = $model->getCompetenciasPuesto($idpuesto);
        $data['perfilPuesto'] = $perfilPuesto;

        require(APPPATH . "ThirdParty/random_compat/random.php");
        require(APPPATH . '../vendor/autoload.php');

        $mpdf =  new \Mpdf\Mpdf(['mode' => 'utf-8']);
        try {
            //condifuracion para tabla responsiva
            $mpdf->SetCompression(false);
            $mpdf->setFooter('Pagina: {PAGENO} / {nb}');
            $css = file_get_contents(base_url('assets/css/puestostyle.css'));
            $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
            $mpdf->WriteHTML($this->plantillaPuesto($data['perfilPuesto']));
            $mpdf->Output('Perfilpuesto.pdf', 'D');
        } catch (\Mpdf\MpdfException $e) { // Note: safer fully qualified exception
            //       name used for catch
            // Process the exception, log, print etc.
            echo $e->getMessage();
        }
        exit();
    } //perfilPuestoPdf


    //Lia -> PDF de evaluacion por competencias empleado
    public function resultadosEvaluacionCompetencias($empleadoID)
    {

        //datos
        $model = new PdfModel();
        $empleadoID = encryptDecrypt('decrypt', $empleadoID);
        $empleado = $model->getEmpleadoInfo($empleadoID);
        $data['lastEC'] = $model->getLastEvaluacionCompetenciasByEmpleado($empleadoID);
        $data['empleado'] = $empleado;
        if (is_null($data['lastEC']['evac_JefeID'])) {
            $jefeEmpleado = db()->query("SELECT emp_EmpleadoID FROM empleado WHERE emp_Numero=?", array($empleado['emp_Jefe']))->getRowArray()['emp_EmpleadoID'];
        } else {
            $jefeEmpleado = $data['lastEC']['evac_JefeID'];
        }
        $data['jefe'] = $this->db->query("SELECT * FROM empleado JOIN puesto ON pue_PuestoID=emp_PuestoID WHERE emp_EmpleadoID=?", array($jefeEmpleado))->getRowArray();

        //Librerias
        require(APPPATH . "ThirdParty/random_compat/random.php");
        require(APPPATH . '../vendor/autoload.php');

        $mpdf =  new \Mpdf\Mpdf(['mode' => 'utf-8']);

        try {
            //condifuracion para tabla responsiva
            $mpdf->SetCompression(false);
            $mpdf->setFooter('Pagina: {PAGENO} / {nb}');
            $css = file_get_contents(base_url('assets/css/reporteEvaluacionCompetencias.css'));

            $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
            $mpdf->WriteHTML($this->plantillaEvaluacionCompetencias($data));
            $mpdf->Output($empleado['emp_Nombre'] . ' Resultados Evaluacion por Competencias.pdf', 'D');
        } catch (\Mpdf\MpdfException $e) { // Note: safer fully qualified exception
            //       name used for catch
            // Process the exception, log, print etc.
            echo $e->getMessage();
        }
    } //perfilPuestoPdf


    //Lia - plantilla para generar el pdf
    public function plantillaEvaluacionCompetencias($data)
    {

        //echo '====================================<pre>';
        //var_dump($data);
        //echo '</pre>';
        //exit();
        $logo = base_url('assets/images/') . getSetting('logo', $this);

        $lastEC = $data['lastEC'];
        $empleado = $data['empleado'];
        $jefe = $data['jefe'];


        $imagen = base_url("assets/uploads/resultados/evaluacionCompetencias/evaluacionCompetenciasByColaborador0.png");
        $imagen1 = base_url("assets/uploads/resultados/evaluacionCompetencias/evaluacionCompetenciasByColaborador1.png");

        $html = '
            <header class="clearfix">
                  <div id="logo" class="center">
                    <img style="width: 200px;" src="' . $logo . '">
                  </div>
                  <h1>' . getSetting('nombre_empresa', $this) . '</h1>
            </header>
        ';

        $fecha = (!is_null($lastEC)) ? $lastEC['evac_Fecha'] : 'No disponible';
        $fechaJefe = (!is_null($lastEC)) ? $lastEC['evac_FechaJefe'] : 'No disponible';

        $html .= '
            <main>
            <div class="contenedor">
                <h2 style="text-align: center">Resultados de la evaluacion de competencias</h2>
                <table>
                    <tr>
                    <td >
                        <img class="rounded-circle avatar-xl img-thumbnail" src="' . fotoPerfil($empleado['emp_EmpleadoID']) . '">
                    </td>
                    <td class="text-right">
                        <h4>' . $empleado['emp_Nombre'] . '</h4>
                        <p style="margin-bottom: 5px;">' . $empleado['pue_Nombre'] . '</p>
                        <div class="row" style="margin-left: 0px;">
                            <p class="mb-1 ml-1">' . $fecha . '</p>
                        </div>
                    </td>
                    <td >
                        <img class="rounded-circle avatar-xl img-thumbnail" src="' . fotoPerfil($jefe['emp_EmpleadoID']) . '">
                    </td>
                    <td class="text-right">
                        <h4>' . $jefe['emp_Nombre'] . '</h4>
                        <p style="margin-bottom: 5px;">' . $jefe['pue_Nombre'] . '</p>
                        <div class="row" style="margin-left: 0px;">
                            <p class="mb-1 ml-1">' . $fechaJefe . '</p>
                        </div>
                    </td>
                    </tr>
                </table>';

        $html .= '<div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0 table-bordered ">
                            <thead class="thead-dark" align="center" >
                            <tr>
                                <th class="col-sm-6" style="vertical-align:middle" >Competencia</th>
                                <th class="col-sm-2" style="vertical-align:middle">Nivel</th>
                                <th class="col-sm-2" style="vertical-align:middle">Calificación evaluado</th>
                                <th class="col-sm-2" style="vertical-align:middle">Total evaluado</th>
                                <th class="col-sm-2" style="vertical-align:middle">Calificación jefe</th>
                                <th class="col-sm-2" style="vertical-align:middle">Total jefe</th>
                                <th class="col-sm-2" style="vertical-align:middle">Calificación  </th>
                                <th class="col-sm-2" style="vertical-align:middle">Porcentaje  </th>
                            </tr>
                            </thead>
                            <tbody>';

        $suma = 0;
        $promedio = 0;
        $porcentajePromedio = 0;
        foreach ($lastEC['calificaciones'] as $calificacio) {
            $suma += $calificacio['Nivel'];
            $promedio += ($calificacio['Valor'] + $calificacio['calJefe']) / 2;
            $porcentajePromedio += ($calificacio['porcentaje'] + $calificacio['porJefe']) / 2;
            $html .= '
                <tr>
                    <td style="text-align: left">' . $calificacio['comNombre'] . '</td>
                    <td align="center" style="vertical-align:middle">' . $calificacio['Nivel'] . '</td>
                    <td align="center" style="vertical-align:middle">' . number_format($calificacio['Valor'], 2, '.', ',') . '</td>
                    <td align="center" style="vertical-align:middle">' . number_format($calificacio['porcentaje'], 2, '.', ',') . ' %' . '</td>
                    <td align="center" style="vertical-align:middle">' . number_format($calificacio['calJefe'], 2, '.', ',') . '</td>
                    <td align="center" style="vertical-align:middle">' . number_format($calificacio['porJefe'], 2, '.', ',') . ' %' . '</td>
                    <td align="center" style="vertical-align:middle">' . number_format($promedio, 2, '.', ',') . '</td>
                    <td align="center" style="vertical-align:middle">' . number_format($porcentajePromedio, 2, '.', ',') . ' %' . '</td>
                </tr>';
        }

        $html .= '
                <tr class="table-success" >
                    <td style="text-align: center;vertical-align:middle">Total nivel</td>
                    <td align="center" style="vertical-align:middle">' . $suma . '</td>
                    <td align="center" style="vertical-align:middle"></td>
                    <td align="center" style="vertical-align:middle"></td>
                    <td align="center" style="vertical-align:middle"></td>
                    <td align="center" style="vertical-align:middle">Total</td>
                    <td align="center" style="vertical-align:middle">' . $promedio . '</td>
                    <td align="center" style="vertical-align:middle">' .  number_format($porcentajePromedio, 2, '.', ',') . ' %' . '</td>
                </tr>
                </tbody>
                </table>
            </div>
        </div>';

        $html .= '
        <div style="text-align: center;">
            <h4 style="text-align: center">Calificación: ' . number_format($porcentajePromedio, 2, '.', ',') . ' %' . '</h4>
        </div>
        <div class="col-md-12">
            <h4 class="mb-4 text-center">Competencias cardinales</h4>
            <div class="dashboard-donut-chart">
                <img src="' . $imagen . '">
            </div>
        </div>
        <div class="col-md-12">
            <h4 class="mb-4 text-center">Competencias especificas</h4>
            <div class="dashboard-donut-chart">
                <img src="' . $imagen1 . '">
            </div>
        </div>';

        $html .= '
            </div>
           </main>
        ';

        return  $html;
    } //plantillaPuesto


    public function plantillaPuesto($data)
    {
        $fecha = $data['fechaCreacion'];
        $logo = base_url('assets/images/moneda.jpg');

        $reporta = $data['puestosReporta'] !== "null" ? implode(' ', array_map(fn ($item) => '<span class="rounded">&nbsp;' . $item['puesto'] . '&nbsp;</span>&nbsp;', $data['puestosReporta'])) : "No hay información disponible";
        $coordina = $data['puestosCoordina'] !== "null" ? implode(' ', array_map(fn ($item) => '<span class="rounded">&nbsp;' . $item['puesto'] . '&nbsp;</span>&nbsp;', $data['puestosCoordina'])) : "No hay información disponible";

        $funciones = json_decode($data['funciones'], true);
        $fun = !empty($funciones) ? implode('<br>', array_map(fn ($i) => '<li>' . trim($funciones['F' . $i]) . '</li>', range(1, count($funciones)))) : "No hay información disponible";

        $comp = !empty($data['competenciasPuesto']) ? implode('', array_map(function ($i, $compue) {
            $claves = $this->db->query("SELECT * FROM clavecompetencia WHERE cla_CompetenciaID=" . $compue['com_CompetenciaID'])->getResultArray();
            $clavesHtml = implode('', array_map(fn ($clave) => '<li style="border-bottom: none; padding-left: 30px">' . trim($clave['cla_ClaveAccion']) . '</li>', $claves));
            return '<li style="border-bottom: none;">' . $i . '.-  ' . trim($compue['com_Nombre']) . '</li>' . $clavesHtml;
        }, range(1, count($data['competenciasPuesto'])), $data['competenciasPuesto'])) : "No hay información disponible";

        $html = '
        
        
            <header class="clearfix">
                <div id="logo" class="center">
                    <img style="width: 150px;" src="' . $logo . '">
                </div>
                <div class="head">
                    <h5>' . $fecha . '</h5>
                </div>
                <h3>' . strtoupper(getSetting('nombre_empresa', $this)) . '</h3>
                <div class="contenedor2"><h3><span class="bold2">' . $data['puesto'] . '</span></h3></div>
                <div class="contenedor3"><h4>Descripcion y perfil de puesto</h4></div>
            </header>
            <main>
                <table>
                    <tr>
                        <th colspan="2">PERFIL DEL PUESTO</th>
                    </tr>
                    <tr>
                        <td class="bold">Puesto de trabajo</td>
                        <td>' . $data['puesto'] . '</td>
                    </tr>
                    <tr>
                        <td class="bold">Reporta</td>
                        <td>' . $reporta . '</td>
                    </tr>
                    <tr>
                        <td class="bold">Coordina</td>
                        <td>' . $coordina . '</td>
                    </tr>
                    <tr>
                        <td class="bold">Horario</td>
                        <td>' . $data['puesto'] . '</td>
                    </tr>
                    <tr>
                        <td class="bold">Tipo de contrato</td>
                        <td>' . $data['tipoContrato'] . '</td>
                    </tr>
                    <tr>
                        <td class="bold">Genero</td>
                        <td>' . $data['genero'] . '</td>
                    </tr>
                    <tr>
                        <td class="bold">Edad</td>
                        <td>' . $data['edad'] . '</td>
                    </tr>
                    <tr>
                        <td class="bold">Esatado Civil</td>
                        <td>' . $data['estadoCivil'] . '</td>
                    </tr>
                    <tr>
                        <td class="bold">Idioma</td>
                        <td>' . $data['idioma'] . '</td>
                    </tr>
                    <tr>
                        <td class="bold">Nivel de Idioma</td>
                        <td>' . $data['idiomaNivel'] . '</td>
                    </tr>
                    <tr>
                        <td class="bold">Escolaridad</td>
                        <td>' . $data['escolaridad'] . '</td>
                    </tr>
                    <tr>
                        <td class="bold">Años de experiencia</td>
                        <td>' . $data['aniosExperiencia'] . '</td>
                    </tr>
                    <tr>
                        <td class="bold">Departamento</td>
                        <td>' . $data['departamento'] . '</td>
                    </tr>
                    <tr>
                        <td class="bold">Funciones y responsabilidades del puesto</td>
                        <td><ul>' . $fun . '</ul></td>
                    </tr>
                    <tr>
                        <td class="bold">Aptitudes necesarias</td>
                        <td><ul>' . $comp . '</ul></td>
                    </tr>
                     <tr>
                        <td class="bold">Objetivo</td>
                        <td><ul>' . $data['objetivo'] . '</ul></td>
                    </tr>
                </table>
            </main>
        ';

        return $html;
    }

    //Lia -> Imprimir solicitud de vacaciones
    public function imprimirSolicitudVacaciones($idVacacion)
    {
        $idVacacion = (int)encryptDecrypt('decrypt', $idVacacion);

        if (empty($idVacacion)) {
            exit();
        } //if

        $model = new PdfModel();
        $vacacion = $model->getInfoByVacacion($idVacacion);

        $fechaComoEntero = strtotime($vacacion['emp_FechaIngreso']);
        $anio = date("Y", $fechaComoEntero);

        //if ((int)$anio > 2021) {
        $config = getConfiguracion($this);
        /*} else {
            $config = getConfiguracion2021($this);
        }*/

        //Create Document
        $pdf = new Fpdi();
        $pdf->AddPage("P", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/vacaciones.pdf");
        $template = $pdf->importPage(1);
        $pdf->useTemplate($template, -1, 0, 220, 280);

        //Periodo
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetXY(110, 26);
        $pdf->SetTextColor(255, 0, 0);
        $pdf->Cell(20, 4, $vacacion['vac_Periodo'], 0, 0, 'C');
        $pdf->SetTextColor(0, 0, 0);

        //no periodo
        $pdf->SetXY(90, 25);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->Cell(50, 5, '', 0, 0, 'C', 1);

        //Oficina
        $pdf->SetXY(150, 30);
        $pdf->Cell(59, 4, ucfirst(strtolower(utf8_decode($vacacion['suc_Sucursal']))), 0, 0, 'C');

        //Departamento
        $pdf->SetXY(150, 35.5);
        $pdf->Cell(59, 4, ucfirst(strtolower(utf8_decode($vacacion['dep_Nombre']))), 0, 0, 'C');

        //No Colaborador
        $pdf->SetXY(40, 41);
        $pdf->Cell(40, 3, $vacacion['emp_Numero'], 0, 0, 'C');

        //Colaborador
        $pdf->SetXY(133, 41);
        $pdf->Cell(75, 3, utf8_decode($vacacion['emp_Nombre']), 0, 0, 'C');

        //fecha ingreso
        $pdf->SetXY(40, 46);
        $pdf->Cell(60, 3, longDate($vacacion['emp_FechaIngreso'], ' de '), 0, 0, 'C');

        //años de servicio
        $aniosDif = diferenciaAnios($vacacion['emp_FechaIngreso'], $vacacion['vac_FechaInicio']);
        $pdf->SetXY(176, 46);
        $pdf->Cell(18, 3, utf8_decode($aniosDif), 0, 0, 'C');

        //dias
        $diasLey = diasLey($vacacion['emp_FechaIngreso'], $this);
        $pdf->SetXY(70, 51.5);
        $pdf->Cell(30, 3, utf8_decode($diasLey), 0, 0, 'C');

        //dias disfrutar
        $pdf->SetXY(130, 51.5);
        $pdf->Cell(18, 3, utf8_decode($vacacion['vac_Disfrutar']), 0, 0, 'C');

        //dias pendientes
        $pdf->SetXY(176, 51.5);
        $pdf->Cell(30, 3, utf8_decode($vacacion['vac_Restantes']), 0, 0, 'C');

        //periodo
        $pdf->SetXY(6, 56);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->Cell(190, 5, '', 0, 0, 'C', 1);

        // inicio vacaciones
        $pdf->SetXY(70, 66);
        $pdf->Cell(30, 3, explode('-', $vacacion['vac_FechaInicio'])[2], 0, 0, 'C');
        $pdf->SetX(110);
        $pdf->Cell(30, 3, numMeses(explode('-', $vacacion['vac_FechaInicio'])[1]), 0, 0, 'C');
        $pdf->SetX(150);
        $pdf->Cell(40, 3, explode('-', $vacacion['vac_FechaInicio'])[0], 0, 0, 'C');

        // fin vacaciones
        $pdf->SetXY(70, 71);
        $pdf->Cell(30, 3, explode('-', $vacacion['vac_FechaFin'])[2], 0, 0, 'C');
        $pdf->SetX(110);
        $pdf->Cell(30, 3, numMeses(explode('-', $vacacion['vac_FechaFin'])[1]), 0, 0, 'C');
        $pdf->SetX(150);
        $pdf->Cell(40, 3, explode('-', $vacacion['vac_FechaFin'])[0], 0, 0, 'C');

        //fecha presentarse
        $pdf->SetXY(101, 77);
        $pdf->Cell(80, 3, longDate(fechaPresentarse($vacacion['vac_FechaFin'], $vacacion['vac_EmpleadoID']), ' de '), 0, 0, 'C');

        //observaciones
        $pdf->SetXY(40, 82);
        $pdf->MultiCell(160, 3, utf8_decode($vacacion['vac_Observaciones']), 0, 'C');

        //Fecha de Registro
        $pdf->SetXY(111, 105);
        $pdf->Cell(18, 3, explode('-', $vacacion['registro'])[2], 0, 0, 'C');
        $pdf->SetX(133);
        $pdf->Cell(40, 3, numMeses(explode('-', $vacacion['registro'])[1]), 0, 0, 'C');
        $pdf->SetX(195);
        $pdf->Cell(10, 3, explode('-', $vacacion['registro'])[0], 0, 0, 'C');

        //Firma Solicitante
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->SetXY(8, 115);
        $pdf->Cell(45, 5, utf8_decode($vacacion['emp_Nombre']), 0, 0, 'C');
        if ($vacacion['vac_Estatus'] === 'DECLINADO') {
            //Put the watermark
            $pdf->SetFont('Arial', 'B', 30);
            $pdf->SetTextColor(255, 192, 203);
            $pdf->SetXY(40, 62);
            $pdf->Cell(35, 50, 'DECLINADO', 45);
        } else {
            //Firma Jefe
            if ($vacacion['vac_Estatus'] === "AUTORIZADO" || $vacacion['vac_Estatus'] === "AUTORIZADO_RH") {
                $builder = db()->table("empleado");
                $jefe = $builder->getWhere(array("emp_EmpleadoID" => $vacacion['vac_AutorizaID']))->getRowArray()['emp_Nombre'];
                $pdf->SetXY(70, 115);
                $pdf->MultiCell(70, 5, utf8_decode($jefe), 0, 'C');
            }
            //Firma CH
            if ($vacacion['vac_Estatus'] === "AUTORIZADO_RH") {
                $builder = db()->table("empleado");
                $ch = $builder->getWhere(array("emp_EmpleadoID" => $vacacion['vac_AplicaID']))->getRowArray()['emp_Nombre'];
                $pdf->SetXY(145, 115);
                $pdf->MultiCell(70, 5, utf8_decode($ch), 0, 'C');
            }
        }

        //Output
        $pdf->output('I', 'solicitudVacaciones-' . $idVacacion . '.pdf');
        exit();
    } //imprimirSolicitudVacaciones

    //Lia -> Imprimir solicitud de vacaciones
    public function imprimirSolicitudVacacionesHoras($idVacacionHoras)
    {
        $idVacacion = (int)encryptDecrypt('decrypt', $idVacacionHoras);

        if (empty($idVacacion)) {
            exit();
        } //if

        $model = new PdfModel();
        $vacacion = $model->getInfoByVacacionHoras($idVacacion);


        //Create Document
        $pdf = new Fpdi();
        $pdf->AddPage("P", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/vacacioneshoras.pdf");
        $template = $pdf->importPage(1);
        $pdf->useTemplate($template, -1, 0, 220, 280);

        //logo
        $logo = FCPATH . "/assets/images/LOGO_AMA.png";
        $pdf->Image($logo, 28, 28, 35, 30);

        //Nombre Empresa
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetXY(108, 47);
        $pdf->Cell(80, 5, strtoupper(utf8_decode(getSetting('nombre_empresa', $this))), 0, 0, 'L');

        //Folio
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetXY(144, 54);
        $pdf->Cell(46, 5, str_pad($vacacion['vach_VacacionHorasID'], 3, 0, STR_PAD_LEFT), 0, 0, 'R');

        //Fecha de Registro
        $pdf->SetXY(144, 59);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(46, 5, strtoupper(shortDateTime($vacacion['vach_Fecha'], " de ")), 0, 0, 'R');
        $pdf->SetFont('Arial', '', 10);

        //Fecha de Ingreso
        $pdf->SetXY(144, 64);
        $pdf->Cell(46, 5, longDate($vacacion['emp_FechaIngreso'], " de "), 0, 0, 'R');

        //# Empleado
        $pdf->SetXY(51, 75);
        $pdf->Cell(23, 5, $vacacion['emp_Numero'], 0, 0, 'L');

        //Nombre Empleado
        $pdf->SetXY(111, 75);
        $pdf->Cell(80, 5, utf8_decode($vacacion['emp_Nombre']), 0, 0, 'L');

        //Puesto
        $pdf->SetXY(51, 81);
        $pdf->Cell(23, 5, utf8_decode($vacacion['pue_Nombre']), 0, 0, 'L');

        //Departamento
        $pdf->SetXY(51, 87);
        $pdf->Cell(23, 5, utf8_decode($vacacion['dep_Nombre']), 0, 0, 'L');

        //Periodo Inicio
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetXY(31, 116);
        $pdf->MultiCell(75, 4, utf8_decode($vacacion['vach_Dias'] . ' Día(s) a cambiar'), 0, 'C');

        //Periodo Fin
        $pdf->SetXY(118, 116);
        $pdf->MultiCell(65, 4, utf8_decode($vacacion['vach_Horas'] . ' Horas solicitadas'), 0, 'C');
        $pdf->SetFont('Arial', '', 10);

        //Observaciones
        if ($vacacion['vach_Observaciones'] !== "") {
            $pdf->SetXY(28, 130);
            $pdf->MultiCell(165, 5, "OBSERVACIONES: " . utf8_decode($vacacion['vach_Observaciones']), 0, 'J');
        }

        //Nota
        $pdf->SetXY(28, 150);
        $pdf->MultiCell(165, 5, utf8_decode("POR EL PRESENTE SOLICITO EL GOCE DE MIS VACACIONES A TRAVÉS DE UN CAMBIO A HORAS, ACEPTANDO QUE 1 DÍA DE VACACIONES EQUIVALE A 8 HORAS CONSIDERANDO LOS DATOS REGISTRADOS EN LA PRESENTE. "), 0, 'J');

        $pdf->SetFont('Arial', '', 9);

        //Firma Solicitante
        $pdf->SetXY(28, 175);
        $pdf->MultiCell(58, 5, utf8_decode($vacacion['emp_Nombre']), 0, 'C');
        //Firma CH
        if ($vacacion['vach_Estatus'] === "AUTORIZADO_RH") {
            $builder = db()->table("empleado");
            $ch = $builder->getWhere(array("emp_EmpleadoID" => $vacacion['vach_AutorizaID']))->getRowArray()['emp_Nombre'];
            $pdf->SetXY(138, 175);
            $pdf->MultiCell(58, 5, utf8_decode($ch), 0, 'C');
        }

        //Output
        $pdf->output('I', 'solicitudHorasVacaciones-' . $idVacacion . '.pdf');
        exit();
    } //imprimirSolicitudVacaciones

    //Nat -> Imprimir la responsiva del equipo informatico de un empleado
    public function imprimirPermiso($permisoID)
    {
        $permisoID = (int)encryptDecrypt('decrypt', $permisoID);

        if (empty($permisoID)) {
            exit();
        } //if


        //Create Document
        $pdf = new Fpdi();
        $pdf->AddPage("L", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/permiso.pdf");
        $template = $pdf->importPage(1);
        $pdf->useTemplate($template, -1, 0);

        $logoName = 'LOGO_AMA.png';
        $logo = FCPATH . "/assets/images/" . $logoName;
        $pdf->Image($logo, 17, 16, 40, 30);


        $model = new PdfModel();
        $permisoInfo = $model->getPermisoInfo($permisoID);

        $pdf->SetFont('Arial', '', 11);


        //Fecha
        $pdf->SetXY(190, 37);
        if ($permisoInfo['per_HoraCreado'] !== '00:00:00') {
            $fechaRegistro = utf8_decode(longDateTime($permisoInfo['per_Fecha'] . ' ' . $permisoInfo['per_HoraCreado'], ' de '));
        } else {
            $fechaRegistro = utf8_decode(longDate($permisoInfo['per_Fecha'], ' de '));
        }
        $pdf->Cell(60, 4, $fechaRegistro, 0, 0, 'L');

        //Numero de empleado
        $pdf->SetXY(220, 52);
        $pdf->Cell(38, 4, utf8_decode($permisoInfo['emp_Numero']), 0, 0, 'C');

        //Nombre de empleado
        $pdf->SetXY(60, 52);
        $pdf->Cell(115, 4, utf8_decode($permisoInfo['emp_Nombre']), 0, 0, 'L');

        $pdf->SetFont('Arial', '', 9);
        //Puesto
        $pdf->SetXY(179, 58.5);
        $pdf->MultiCell(80, 5.5, utf8_decode($permisoInfo['pue_Nombre']), 0,  'L');

        $pdf->SetFont('Arial', '', 11);
        //Departamento
        $pdf->SetXY(60, 59.5);
        $pdf->Cell(68, 4, utf8_decode($permisoInfo['dep_Nombre']), 0, 0, 'L');

        //Dias
        $pdf->SetXY(60, 67);
        $pdf->Cell(68, 4, utf8_decode($permisoInfo['per_DiasSolicitados']), 0, 0, 'C');

        //Dias
        $pdf->SetXY(180, 67);
        $pdf->Cell(74, 4, utf8_decode($permisoInfo['tipoPermiso']), 0, 0, 'C');


        $dias = "Del día ";
        $dias .= longDate($permisoInfo['per_FechaInicio'], " de ");
        $dias .= " al ";
        $dias .= longDate($permisoInfo['per_FechaFin'], " de ");

        //Dias solicitados
        $pdf->SetXY(82, 86);
        $pdf->Cell(177, 5, utf8_decode($dias), 0, 0, 'C');

        //Motivos
        $pdf->SetXY(17, 112);
        if ($permisoInfo['per_Horas'] > 0 || $permisoInfo['per_Horas'] != null) {
            $permisoInfo['per_Motivos'] = '(De ' . shortTime($permisoInfo['per_HoraInicio']) . ' a ' . shortTime($permisoInfo['per_HoraFin']) . ') ' . $permisoInfo['per_Motivos'];
        }
        $pdf->MultiCell(242, 5, utf8_decode($permisoInfo['per_Motivos']), 0, 'J');

        //Justificacion
        $pdf->SetXY(17, 144.7);
        $pdf->MultiCell(190, 5, utf8_decode($permisoInfo['per_Justificacion']), 0, 'J');

        //Tipo de permiso
        $pdf->SetXY(180, 148.7);
        if (!empty($permisoInfo['per_TipoPermiso'])) {
            $tipoPermiso = $permisoInfo['per_TipoPermiso'];
        } else {
            $tipoPermiso = '';
        }
        $pdf->MultiCell(50, 5, utf8_decode($tipoPermiso), 0, 'J');


        if ($permisoInfo['per_Estado'] === 'DECLINADO') {
            //Put the watermark
            $pdf->SetFont('Arial', 'B', 30);
            $pdf->SetTextColor(255, 192, 203);
            $pdf->SetXY(105, 145);
            $pdf->Cell(35, 50, 'DECLINADO', 45);
        } else {
            //Firma colaborador
            $pdf->SetXY(18, 171);
            $pdf->MultiCell(65, 5, utf8_decode($permisoInfo['emp_Nombre']), 0, 'C');
            //Firma Jefe
            if (in_array($permisoInfo['per_Estado'], ['AUTORIZADO_RH', 'AUTORIZADO_JEFE'])) {
                $pdf->SetXY(100, 171);
                $pdf->MultiCell(70, 5, utf8_decode($permisoInfo['jefe']), 0, 'C');
            }
            //Firma CH
            if (in_array($permisoInfo['per_Estado'], ['AUTORIZADO_RH'])) {
                $pdf->SetXY(187, 171);
                $pdf->MultiCell(70, 5, utf8_decode($permisoInfo['ch']), 0, 'C');
            }
        }

        //Output
        $pdf->output('I', 'Permiso_' . utf8_decode($permisoInfo['emp_Nombre']) . '.pdf');
        exit();
    } //imprimirPErmiso

    //Nat -> Imprimir la responsiva del equipo informatico de un empleado
    public function imprimirPermisoOperativo($permisoID)
    {
        $permisoID = (int)encryptDecrypt('decrypt', $permisoID);

        if (empty($permisoID)) {
            exit();
        } //if


        //Create Document
        $pdf = new Fpdi();
        $pdf->AddPage("L", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/permiso.pdf");
        $template = $pdf->importPage(1);
        $pdf->useTemplate($template, -1, 0);

        $logoName = 'LOGO_AMA.png';
        $logo = FCPATH . "/assets/images/" . $logoName;
        $pdf->Image($logo, 17, 16, 40, 30);


        $model = new PdfModel();
        $permisoInfo = $model->getPermisoInfo($permisoID);

        $pdf->SetFont('Arial', '', 11);


        //Fecha
        $pdf->SetXY(190, 37);
        if ($permisoInfo['per_HoraCreado'] !== '00:00:00') {
            $fechaRegistro = utf8_decode(longDateTime($permisoInfo['per_Fecha'] . ' ' . $permisoInfo['per_HoraCreado'], ' de '));
        } else {
            $fechaRegistro = utf8_decode(longDate($permisoInfo['per_Fecha'], ' de '));
        }
        $pdf->Cell(60, 4, $fechaRegistro, 0, 0, 'L');

        //Numero de empleado
        $pdf->SetXY(220, 52);
        $pdf->Cell(38, 4, utf8_decode($permisoInfo['emp_Numero']), 0, 0, 'C');

        //Nombre de empleado
        $pdf->SetXY(60, 52);
        $pdf->Cell(115, 4, utf8_decode($permisoInfo['emp_Nombre']), 0, 0, 'L');

        $pdf->SetFont('Arial', '', 9);
        //Puesto
        $pdf->SetXY(179, 58.5);
        $pdf->MultiCell(80, 5.5, utf8_decode($permisoInfo['pue_Nombre']), 0,  'L');

        $pdf->SetFont('Arial', '', 11);
        //Departamento
        $pdf->SetXY(60, 59.5);
        $pdf->Cell(68, 4, utf8_decode($permisoInfo['dep_Nombre']), 0, 0, 'L');

        //Dias
        $pdf->SetXY(60, 67);
        $pdf->Cell(68, 4, utf8_decode($permisoInfo['per_DiasSolicitados']), 0, 0, 'C');

        //Dias
        $pdf->SetXY(180, 67);
        $pdf->Cell(74, 4, utf8_decode($permisoInfo['tipoPermiso']), 0, 0, 'C');


        $dias = "Del día ";
        $dias .= longDate($permisoInfo['per_FechaInicio'], " de ");
        $dias .= " al ";
        $dias .= longDate($permisoInfo['per_FechaFin'], " de ");

        //Dias solicitados
        $pdf->SetXY(82, 86);
        $pdf->Cell(177, 5, utf8_decode($dias), 0, 0, 'C');

        //Motivos
        $pdf->SetXY(17, 112);
        if ($permisoInfo['per_Horas'] > 0 || $permisoInfo['per_Horas'] != null) {
            $permisoInfo['per_Motivos'] = '(De ' . shortTime($permisoInfo['per_HoraInicio']) . ' a ' . shortTime($permisoInfo['per_HoraFin']) . ') ' . $permisoInfo['per_Motivos'];
        }
        $pdf->MultiCell(242, 5, utf8_decode($permisoInfo['per_Motivos']), 0, 'J');

        //Justificacion
        $pdf->SetXY(17, 144.7);
        $pdf->MultiCell(190, 5, utf8_decode($permisoInfo['per_Justificacion']), 0, 'J');

        //Tipo de permiso
        $pdf->SetXY(180, 148.7);
        if (!empty($permisoInfo['per_TipoPermiso'])) {
            $tipoPermiso = $permisoInfo['per_TipoPermiso'];
        } else {
            $tipoPermiso = '';
        }
        $pdf->MultiCell(50, 5, utf8_decode($tipoPermiso), 0, 'J');


        //Firma colaborador
        $pdf->SetXY(17, 176);
        $pdf->Cell(70, 5, utf8_decode($permisoInfo['emp_Nombre']), 0, 0, 'C');

        //Firma jefe
        $pdf->SetXY(100, 176);
        if ($permisoInfo['per_Estado'] === 'AUTORIZADO' || $permisoInfo['per_Estado'] === 'AUTORIZADO_RH') {
            $pdf->Cell(70, 5, utf8_decode($permisoInfo['jefe']), 0, 0, 'C');
        }

        //Firma ch
        $pdf->SetXY(185, 176);
        $pdf->Cell(70, 5, utf8_decode($permisoInfo['ch']), 0, 0, 'C');

        if ($permisoInfo['per_Estado'] === 'DECLINADO') {
            //Put the watermark
            $pdf->SetFont('Arial', 'B', 30);
            $pdf->SetTextColor(255, 192, 203);
            $pdf->SetXY(185, 145);
            $pdf->Cell(35, 50, 'DECLINADO', 45);
        }

        //Output
        $pdf->output('I', 'Permiso_' . utf8_decode($permisoInfo['emp_Nombre']) . '.pdf');
        exit();
    } //imprimirPErmiso

    //HUGO->Imprimir solicitud de anticipo
    public function imprimirSolicitudAnticipo($anticipoID)
    {
        $anticipoID = (int)encryptDecrypt('decrypt', $anticipoID);

        if (empty($anticipoID)) {
            exit();
        } //if

        $pdf = new Fpdi();
        $pdf->AddPage("P", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/anticipo.pdf");
        $template = $pdf->importPage(1);
        $pdf->useTemplate($template, -1, 0, 220, 280);

        //GET DATOS
        $sql = "select
                A.*,
                SOL.emp_Nombre as 'solicita',
                PUE.pue_Nombre as 'puesto',
                DEP.dep_Nombre as 'departamento',
                JEF.emp_Nombre as 'jefeInmediato',
                DTH.emp_Nombre as 'rh',
                DIR.emp_Nombre as 'direccion'
                from anticipo A
                left join empleado SOL on SOL.emp_EmpleadoID = A.ant_SolicitaID

                left join puesto PUE on PUE.pue_PuestoID = SOL.emp_PuestoID
                left join departamento DEP on DEP.dep_DepartamentoID = SOL.emp_DepartamentoID
                left join empleado JEF on JEF.emp_EmpleadoID = A.ant_JefeID
                left join empleado DTH on DTH.emp_EmpleadoID = A.ant_DthID
                left join empleado DIR on DIR.emp_EmpleadoID = A.ant_DireccionID
                where A.ant_AnticipoID = ?";
        $anticipo = $this->db->query($sql, array($anticipoID))->getRowArray();


        //Contenido
        $pdf->SetFont('Arial', '', 10);

        //LUGAR Y FECHA
        $lugar = $anticipo['ant_Lugar'];
        $fecha = longDate($anticipo['ant_FechaSolicitud'], " de ");
        $lugarFecha = $lugar . ", A " . $fecha;
        $pdf->SetXY(45, 34.3);
        $pdf->Cell(90, 4, utf8_decode($lugarFecha), 0, 0, 'L');


        //NO. SOCIO
        $pdf->SetXY(45, 39);
        $pdf->Cell(20, 4, utf8_decode($anticipo['ant_NumeroSocio']), 0, 0, 'L');

        //SOLICITA
        $pdf->SetXY(101, 39);
        $pdf->Cell(107, 4, utf8_decode($anticipo['solicita']), 0, 0, 'L');

        //SOLICITA
        $pdf->SetXY(10, 48.7);
        $pdf->Cell(198, 4, utf8_decode($anticipo['ant_Domicilio']), 0, 0, 'L');

        //ARRAIGO DOMICILIARIO
        $pdf->SetXY(9.5, 58);
        $pdf->Cell(36, 4, utf8_decode($anticipo['ant_ArraigoDomiciliario']), 0, 0, 'L');

        //CODIGO POSTAL
        $pdf->SetXY(45.5, 58);
        $pdf->Cell(37, 4, utf8_decode($anticipo['ant_CodigoPostal']), 0, 0, 'C');

        //TELEFONO
        $pdf->SetXY(83, 58);
        $pdf->Cell(33, 4, utf8_decode($anticipo['ant_Telefono']), 0, 0, 'C');

        //ESTADO CIVIL
        $pdf->SetXY(116, 58);
        $pdf->Cell(41, 4, utf8_decode($anticipo['ant_EstadoCivil']), 0, 0, 'C');

        //SEXO
        $pdf->SetXY(157, 58);
        $pdf->Cell(51, 4, utf8_decode($anticipo['ant_Sexo']), 0, 0, 'C');

        //ANTIGUEDAD
        $pdf->SetXY(9.5, 67.5);
        $pdf->Cell(56, 4, utf8_decode($anticipo['ant_Antiguedad']), 0, 0, 'C');

        //PUESTO
        $pdf->SetFont('Arial', '', 7);

        $puesto = $anticipo['puesto'];
        $puesto = strlen($puesto) > 45 ? substr($puesto, 0, 45) : $puesto;
        $pdf->SetXY(66, 67.5);
        $pdf->Cell(69, 4, utf8_decode($puesto), 0, 0, 'C');


        //DEPARTAMENTO
        $departamento = $anticipo['departamento'];
        $departamento = strlen($departamento) > 45 ? substr($departamento, 0, 45) : $departamento;
        $pdf->SetXY(135, 67.5);
        $pdf->Cell(73, 4, utf8_decode($departamento), 0, 0, 'C');

        $pdf->SetFont('Arial', '', 10);

        //GASTOS ORDINARIOS
        $gastosOrdinarios = "$    " . number_format($anticipo['ant_GastosOrdinarios'], 2, '.', ',');
        $pdf->SetXY(157, 77.2);
        $pdf->Cell(51, 4, $gastosOrdinarios, 0, 0, 'R');

        //GASTOS EXTRAORDINARIOS
        $gastosExtraordinarios = "$    " . number_format($anticipo['ant_GastosExtraordinarios'], 2, '.', ',');
        $pdf->SetXY(157, 82.2);
        $pdf->Cell(51, 4, $gastosExtraordinarios, 0, 0, 'R');

        //GASTOS MENSUALES
        $gastosMensuales = "$    " . number_format($anticipo['ant_GastosMensuales'], 2, '.', ',');
        $pdf->SetXY(157, 87.2);
        $pdf->Cell(51, 4, $gastosMensuales, 0, 0, 'R');

        //P1
        $pdf->SetXY(178, 106);
        $pdf->Cell(30, 4, $anticipo['ant_HistorialAceptable'], 0, 0, 'C');

        //P2
        $pdf->SetXY(178, 110);
        $pdf->Cell(30, 4, $anticipo['ant_CuentaSinRetiros'], 0, 0, 'C');

        //P4
        $pdf->SetXY(178, 114);
        $pdf->Cell(30, 4, $anticipo['ant_CompromisoAhorro'], 0, 0, 'C');

        //P5
        $pdf->SetXY(178, 118);
        $pdf->Cell(30, 4, $anticipo['ant_LibreActas'], 0, 0, 'C');


        //COMPROBANTE DE DOMICILIO
        $comprobanteDomicilio = $this->fileExist("comprobante_domicilio", $anticipoID) ? "x" : "";
        $pdf->SetXY(178, 131.5);
        $pdf->Cell(30, 4, $comprobanteDomicilio, 0, 0, 'C');

        //INE
        $ine = $this->fileExist("ine", $anticipoID) ? "x" : "";
        $pdf->SetXY(178, 135.5);
        $pdf->Cell(30, 4, $ine, 0, 0, 'C');

        //BURO CREDITO
        $buro = $this->fileExist("buro_credito", $anticipoID) ? "x" : "";
        $pdf->SetXY(178, 139.5);
        $pdf->Cell(30, 4, $buro, 0, 0, 'C');

        //RECIBO NOMINA
        $nomina = $this->fileExist("recibo_nomina", $anticipoID) ? "x" : "";
        $pdf->SetXY(178, 143.5);
        $pdf->Cell(30, 4, $nomina, 0, 0, 'C');

        //SOLICITUD ANTICIPO
        $anticipoSol = $this->fileExist("solicitud_anticipo", $anticipoID) ? "x" : "";
        $pdf->SetXY(178, 147.5);
        $pdf->Cell(30, 4, $anticipoSol, 0, 0, 'C');

        //PAGARE
        $pagare = $this->fileExist("pagare", $anticipoID) ? "x" : "";
        $pdf->SetXY(178, 151.5);
        $pdf->Cell(30, 4, $pagare, 0, 0, 'C');

        //MESES DEREHCO
        $pdf->SetXY(65, 187);
        $pdf->Cell(36, 4, "$ " . number_format($anticipo['ant_MesesDerecho'], 2), 0, 0, 'C');

        //MONTO SOLICITADO
        $pdf->SetXY(135, 187);
        $pdf->Cell(22, 4, "$ " . number_format($anticipo['ant_MontoSolicitado'], 2), 0, 0, 'C');

        //MONTO AUTRIZADO
        $pdf->SetXY(135, 192);
        $pdf->Cell(22, 4, "$ " . number_format($anticipo['ant_MontoAutorizado'], 2), 0, 0, 'C');

        //FINALIDAD
        $pdf->SetXY(65, 197.5);
        $pdf->Cell(143, 4, utf8_decode($anticipo['ant_Finalidad']), 0, 0, 'L');

        //NO PAGOS
        $pdf->SetXY(45, 202.8);
        $pdf->Cell(20, 4, $anticipo['ant_NumeroPagos'], 0, 0, 'C');

        //MONTO PAGOS
        $pdf->SetXY(116, 202.8);
        $pdf->Cell(19, 4, "$ " . number_format($anticipo['ant_MontoPago'], 2), 0, 0, 'C');

        //ULTIMO PAGO DE
        $pdf->SetXY(178, 202.8);
        $pdf->Cell(30, 4, "$ " . number_format($anticipo['ant_UltimoPago'], 2), 0, 0, 'C');

        //SALARIO DIARIO
        $pdf->SetXY(45.5, 212.5);
        $pdf->Cell(37, 4, "$ " . number_format($anticipo['ant_SalarioDiario'], 2), 0, 0, 'C');

        //SALARIO MENSUAL
        $pdf->SetXY(45.5, 221.5);
        $pdf->Cell(37, 4, "$ " . number_format($anticipo['ant_SalarioMensual'], 2), 0, 0, 'C');

        //FONDO DE AHORRO
        $pdf->SetXY(45.5, 226);
        $pdf->Cell(37, 4, "$ " . number_format($anticipo['ant_FondoAhorro'], 2), 0, 0, 'C');

        //DESPENSA
        $pdf->SetXY(45.5, 231.5);
        $pdf->Cell(37, 4, "$ " . number_format($anticipo['ant_Despensa'], 2), 0, 0, 'C');

        //SALARIO MENSUAL INTEGRADO
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetXY(32, 236);
        $pdf->Cell(10, 4, " Int", 0, 0, 'L');


        $pdf->SetFont('Arial', '', 10);
        $pdf->SetXY(45.5, 236);
        $pdf->Cell(37, 4, "$ " . number_format($anticipo['ant_SalarioMensualIntegrado'], 2), 0, 0, 'C');

        //OBSERVACIONES
        $pdf->SetXY(101, 216);
        $pdf->MultiCell(107, 4, utf8_decode($anticipo['ant_Observaciones']), 0, 'J');

        //FIRMA EMPLEADO
        $pdf->SetXY(10, 251);
        $pdf->MultiCell(44, 3, utf8_decode($anticipo['solicita']), 0, 'C');

        $estatusAnticipo = $anticipo['ant_Estado'];
        //FIRMA JEFE DIRECTO
        $arrayEstatus = array("AUTORIZADO_JEFE", "AUTORIZADO_RH", "RECHAZADO_RH", "AUTORIZADO_DIRECCION", "RECHAZADO_DIRECCION");
        if (in_array($estatusAnticipo, $arrayEstatus)) {
            $pdf->SetXY(59, 251);
            $pdf->MultiCell(44, 3, utf8_decode($anticipo['jefeInmediato']), 0, 'C');
        }

        //FIRMA DTH
        if (in_array($estatusAnticipo, array("AUTORIZADO_RH", "AUTORIZADO_DIRECCION", "RECHAZADO_DIRECCION"))) {
            $pdf->SetXY(109, 251);
            $pdf->MultiCell(44, 3, utf8_decode($anticipo['rh']), 0, 'C');
        } //if

        //FIRMA DIRECCION
        if ($estatusAnticipo == "AUTORIZADO_DIRECCION") {
            $pdf->SetXY(159, 251);
            $pdf->MultiCell(44, 3, utf8_decode($anticipo['direccion']), 0, 'C');
        } //if


        $pdf->output('I', 'Solicitud-de-anticipo.pdf');
        exit();
    } //imprimirSolicitudAnticipo

    //HUGO->Imprimir pagare anticipo
    public function imprimirPagareAnticipo($anticipoID)
    {
        $anticipoID = (int)encryptDecrypt('decrypt', $anticipoID);

        if (empty($anticipoID)) {
            exit();
        } //if

        $pdf = new Fpdi();
        $pdf->AddPage("P", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/pagareAnticipo.pdf");
        $template = $pdf->importPage(1);
        $pdf->useTemplate($template, -1, 0, 220, 280);

        //GET DATOS
        $sql = "select
                  PA.*,
                  SOL.emp_Nombre as 'solicita',
                  SOL.emp_Direccion as 'domicilio',
                  SOL.emp_Municipio as 'mpio',
                  SOL.emp_EntidadFederativa as 'edo'
                from pagareanticipo PA
                left join empleado SOL on SOL.emp_EmpleadoID = PA.pag_EmpleadoID
                where PA.pag_AnticipoID = ?";
        $pagare = $this->db->query($sql, array($anticipoID))->getRowArray();


        //Contenido
        $pdf->SetFont('Arial', '', 10);

        //NO. REFERENCIA
        $no = str_pad($pagare['pag_PagareID'], 11, "0", STR_PAD_LEFT);
        $pdf->SetXY(150, 25);
        $pdf->Cell(60, 4, utf8_decode("Número de referencia: " . $no), 0, 0, 'R');


        //FECHA
        $fecha = $pagare['pag_Fecha'];
        $fecha = $fecha != null && $fecha != '0000-00-00' ? longDate($fecha, " de ") : '';
        $pdf->SetXY(108, 49);
        $pdf->Cell(45, 4, utf8_decode($fecha), 0, 0, 'L');

        //MONTO AUTRIZADO
        $montoAutorizado = (float)$pagare['pag_Cantidad'];
        $montoAutorizado = "$ " . number_format($montoAutorizado, 2);
        $pdf->SetXY(25, 65.7);
        $pdf->Cell(45, 4, utf8_decode($montoAutorizado), 0, 0, 'L');


        //FECHA VENCIMIENTO
        $vencimiento = $pagare['pag_FechaVencimiento'];
        $vencimiento = $vencimiento != "" && $vencimiento != '0000-00-00' ? longDate($vencimiento, " de ") : '';
        $pdf->SetXY(19, 78.4);
        $pdf->Cell(45, 4, utf8_decode($vencimiento), 0, 0, 'L');

        $pdf->SetXY(82, 112);
        $pdf->Cell(45, 4, utf8_decode($vencimiento), 0, 0, 'L');

        //IMPORTE LETRA
        $pdf->SetFont('Arial', '', 8);
        $importeLetra = num_letras($pagare['pag_Cantidad'], "MNX");
        $pdf->SetXY(8, 107.5);
        $pdf->Cell(190, 4, utf8_decode($importeLetra), 0, 0, 'L');

        $pdf->SetFont('Arial', '', 10);
        //ABONOS
        $pdf->SetXY(115, 133);
        $pdf->Cell(6, 4, utf8_decode($pagare['pag_NoPagos']), 0, 0, 'C');

        $pdf->SetFont('Arial', '', 8);
        //SOLICITANTE
        $solicitante = "C. " . $pagare['solicita'];
        $pdf->SetXY(8, 83);
        $pdf->Cell(100, 4, utf8_decode($solicitante), 0, 0, 'L');

        //DIRECCION
        $direccion = $pagare['domicilio'];
        $pdf->SetXY(8, 87);
        $pdf->Cell(100, 4, utf8_decode($direccion), 0, 0, 'L');

        //MUNICIPIO
        $localidad = $pagare['mpio'];
        $pdf->SetXY(8, 91);
        $pdf->Cell(100, 4, utf8_decode($localidad), 0, 0, 'L');

        //LOCALIDAD, EDO
        $estado = $pagare['edo'];
        $pdf->SetXY(8, 95);
        $pdf->Cell(100, 4, utf8_decode($estado), 0, 0, 'L');


        //SOLICITANTE
        $solicitante = "C. " . $pagare['solicita'];
        $pdf->SetXY(23, 188);
        $pdf->Cell(68, 4, utf8_decode($solicitante), 0, 0, 'C');

        //DIRECCION
        $direccion = $pagare['domicilio'];
        $pdf->SetXY(23, 192);
        $pdf->Cell(68, 4, utf8_decode($direccion), 0, 0, 'C');

        //MUNICIPIO
        $localidad = $pagare['mpio'];
        $pdf->SetXY(23, 196);
        $pdf->Cell(68, 4, utf8_decode($localidad), 0, 0, 'C');

        // EDO
        $estado = $pagare['edo'];
        $pdf->SetXY(23, 200);
        $pdf->Cell(68, 4, utf8_decode($estado), 0, 0, 'C');


        $pdf->SetFont('Arial', '', 10);

        $pdf->output('I', 'Solicitud-de-anticipo.pdf');
        exit();
    } //imprimirPagareAnticipo

    //HUGO->Verificar si existe archivo de anticipo
    private function fileExist($archivo, $anticipoID)
    {

        $url = FCPATH . "/assets/uploads/archivosAnticipo/" . $anticipoID . "/";

        if (
            file_exists($url . $archivo . ".docx") || file_exists($url . $archivo . ".pdf") ||
            file_exists($url . $archivo . ".png") || file_exists($url . $archivo . ".jpg") ||
            file_exists($url . $archivo . ".jpeg")
        )
            return true;
        return false;
    } //fileExist

    //Lia -> Imprimir formato de entrevista se salida
    public function imprimirEntrevistaSalida($entrevistaID)
    {
        $entrevistaID = (int)$entrevistaID;
        if (empty($entrevistaID)) {
            exit();
        }

        $entrevista = $this->PdfModel->getEntrevistaSalida($entrevistaID);
        $pdf = new Fpdi();
        $pdf->SetFont('Arial', '', 12);

        // Generar primera página
        $this->configurarPaginaEntrevista($pdf, 1, [
            ['x' => 50, 'y' => 47, 'texto' => $entrevista['empleado']],
            ['x' => 50, 'y' => 54, 'texto' => $entrevista['ultimoPuesto'], 'multi' => true],
            ['x' => 50, 'y' => 62, 'texto' => $entrevista['departamento']],
            ['x' => 60, 'y' => 69, 'texto' => ($entrevista['fechaIngreso'] != '0000-00-00') ? longDate($entrevista['fechaIngreso'], ' de ') : ''],
            ['x' => 140, 'y' => 69, 'texto' => longDate($entrevista['fecha'], ' de ')],
            ['x' => 36, 'y' => 103, 'texto' => $entrevista['ent_Pregunta1'] ? implode(',', json_decode($entrevista['ent_Pregunta1'])) : '', 'multi' => true],
            ['x' => 36, 'y' => 130, 'texto' => $entrevista['ent_Pregunta2'], 'multi' => true],
            ['x' => 35, 'y' => 160, 'texto' => $entrevista['ent_Pregunta3_1'], 'multi' => true],
            ['x' => 35, 'y' => 175, 'texto' => $entrevista['ent_Pregunta3_2'], 'multi' => true],
            ['x' => 34, 'y' => 192, 'texto' => $entrevista['ent_ComentariosP3'], 'multi' => true],
            ['x' => 40, 'y' => 222, 'texto' => $entrevista['ent_Pregunta4'], 'multi' => true],
            ['x' => 40, 'y' => 242, 'texto' => $entrevista['ent_Pregunta5'], 'multi' => true],
        ]);

        // Generar segunda página
        $this->configurarPaginaEntrevista($pdf, 2, [
            ['x' => 40, 'y' => 55, 'texto' => $entrevista['ent_Pregunta6'], 'multi' => true],
            ['x' => 40, 'y' => 80, 'texto' => $entrevista['ent_Pregunta7'], 'multi' => true],
            ['x' => 40, 'y' => 100, 'texto' => $entrevista['ent_Pregunta8'], 'multi' => true],
            ['x' => 40, 'y' => 125, 'texto' => $entrevista['ent_Pregunta9'], 'multi' => true],
            ['x' => 40, 'y' => 143, 'texto' => $entrevista['ent_Pregunta10'], 'multi' => true],
        ]);

        $pdf->output('I', 'EntrevistaSalida-' . $entrevistaID . '.pdf');
        exit();
    }

    private function configurarPaginaEntrevista($pdf, $pagina, $campos)
    {
        $pdf->AddPage("P", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/entrevistaSalida.pdf");
        $template = $pdf->importPage($pagina);
        $pdf->useTemplate($template, -1, 0, 220, 280);

        foreach ($campos as $campo) {
            $pdf->SetXY($campo['x'], $campo['y']);
            if (!empty($campo['multi'])) {
                $pdf->MultiCell(160, 4, utf8_decode($campo['texto']), 0, 'L');
            } else {
                $pdf->Cell(130, 4, utf8_decode($campo['texto']), 0, 0, 'L');
            }
        }
    }

    //Nat -> Excribir x en la table y opcion correspondiente
    function setEntrevistaSalidaTableOption($estatus, $pdf, $y)
    {
        $posiciones = array("Excelente" => 170.5, "Muy bien" => 176.5, "Bien" => 182.7, "Regular" => 188.65, "Mal" => 194.7, "Muy mal" => 201, "Pésimo" => 207.1);
        if ($estatus != '') {
            $x = $posiciones[$estatus];
            $pdf->SetXY($x, $y);
            $pdf->Cell(5, 4, 'x', 0, 0, 'C');
        } //if estatus
    } //setEntrevistaSalidaTableOption

    //Germán -> Imprimir solicitud de personal
    public function imprimirSolicitudPersonal($idSolicitud, $output = null, $candidatoID = null)
    {
        $idSolicitud = (int)encryptDecrypt('decrypt', $idSolicitud);

        if (empty($idSolicitud)) {
            exit();
        } //if

        $query = "SELECT * FROM solicitudpersonal SPE
                    JOIN empleado EMP ON SPE.sol_EmpleadoID = EMP.emp_EmpleadoID
                    LEFT JOIN puesto PUE ON SPE.sol_PuestoID = PUE.pue_PuestoID
                    LEFT JOIN sucursal SUC ON SPE.sol_SucursalSolicita = SUC.suc_SucursalID
                    JOIN departamento DEP ON SPE.sol_DepartamentoVacanteID = DEP.dep_DepartamentoID
                  WHERE SPE.sol_SolicitudPersonalID = ?";
        $solicitud = $this->db->query($query, array((int)$idSolicitud))->getRowArray();

        //incremento de personal
        if ($solicitud === null) {
            $query = "SELECT * FROM solicitudpersonal SPE
                        JOIN empleado EMP ON SPE.sol_EmpleadoID = EMP.emp_EmpleadoID
                        LEFT JOIN puesto PUE ON SPE.sol_PuestoID = PUE.pue_PuestoID
                        LEFT JOIN sucursal SUC ON SPE.sol_SucursalSolicita = SUC.suc_SucursalID
                        WHERE SPE.sol_SolicitudPersonalID = ?";
            $solicitud = $this->db->query($query, array((int)$idSolicitud))->getRowArray();

            if (!array_key_exists('dep_Nombre', $solicitud)) $solicitud['dep_Nombre'] = $solicitud['sol_NuevoDepartamento'];
            //if (!array_key_exists('pue_Nombre', $solicitud)) $solicitud['pue_Nombre'] = $solicitud['sol_NuevoDepartamento'];
        }

        //Create Document
        $pdf = new Fpdi();
        $pdf->AddPage("P", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/requisicionPersonal.pdf");
        $template = $pdf->importPage(1);
        $pdf->useTemplate($template, -1, 0, 220, 280);
        $pdf->SetFont('Arial', '', 10);

        //Puesto
        $pdf->SetXY(43.5, 48);
        $departamentoCreo = $this->db->query("SELECT * FROM departamento WHERE dep_DepartamentoID=" . $solicitud['sol_DepartamentoCreaID'])->getRowArray();
        $pdf->Cell(50, 5, utf8_decode($departamentoCreo['dep_Nombre']), 0, 0, 'L');


        //fecha
        $pdf->SetXY(172, 48);
        $pdf->Cell(50, 5, strtoupper(shortDate($solicitud['sol_Fecha'])), 0, 0, 'L');

        //datos del solicitante
        $pdf->SetXY(39, 61);
        $pdf->Cell(50, 5, utf8_decode($solicitud['emp_Nombre']), 0, 0, 'L');
        $pdf->SetXY(39, 65.5);
        $puestoS = $this->db->query("SELECT * FROM puesto JOIN empleado ON emp_PuestoID=pue_PuestoID WHERE emp_EmpleadoID=" . $solicitud['sol_EmpleadoID'])->getRowArray();
        $pdf->Cell(50, 5, utf8_decode($puestoS['pue_Nombre']), 0, 0, 'L');

        //puesto
        switch ($solicitud['sol_Puesto']) {
            case 'Nuevo':
                $pdf->SetXY(42.5, 81.5);
                $pdf->Cell(35, 5, 'Puesto nuevo', 1, 0, 'L');

                //Cubre la seccion Sustituye a 
                $pdf->SetFillColor(255, 255, 255);
                $pdf->Rect(102, 78, 90, 15, 'F');
                break;
            case 'Sustitucion':
                $pdf->SetXY(40, 83);
                $pdf->Cell(40, 5, 'Sustitucion de personal', 1, 0, 'L');

                //sustituye a
                $pdf->SetFont('Arial', '', 8.5);
                $pdf->SetXY(123, 79.5);
                $pdf->Cell(50, 5, utf8_decode($solicitud['sol_SustituyeA']), 0, 0, 'L');
                //motivo salida
                $pdf->SetXY(123, 82.5);
                $pdf->Cell(50, 5, utf8_decode($solicitud['sol_MotivoSalida']), 0, 0, 'L');
                //Fecha de salida
                $pdf->SetXY(123, 86);
                if ($solicitud['sol_FechaSalida'] !== '0000-00-00') {
                    $pdf->Cell(50, 5, strtoupper(shortDate($solicitud['sol_FechaSalida'])), 0, 0, 'L');
                }
                break;
            case 'Incremento':
                $pdf->SetXY(40, 83);
                $pdf->Cell(40, 5, 'Incremento de pantilla', 1, 0, 'L');

                //Cubre la seccion Sustituye a 
                $pdf->SetFillColor(255, 255, 255);
                $pdf->Rect(102, 78, 90, 15, 'F');
                break;
        }


        //Puesto
        $pdf->SetXY(49, 99.5);
        if ($solicitud['sol_PuestoID'] > 0 && empty($solicitud['sol_NuevoPuesto'])) {
            $puesto = $solicitud['pue_Nombre'];
        } else {
            $puesto = $solicitud['sol_NuevoPuesto'];
        }
        $pdf->Cell(50, 5, utf8_decode($puesto), 0, 0, 'L');

        //Departamento
        $pdf->SetXY(49, 104);
        $pdf->Cell(50, 5, utf8_decode($solicitud['dep_Nombre']), 0, 0, 'L');

        //Sucursal
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->SetXY(125, 104.5);
        $pdf->Cell(18, 5, utf8_decode('SUCURSAL:'), 0, 0, 'L', true);

        //Sucursal
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetXY(145, 104);
        $pdf->Cell(50, 5, utf8_decode($solicitud['suc_Sucursal']), 0, 0, 'L');

        //personal a su cargo
        switch ($solicitud['sol_PersonalCargo']) {
            case 'Si':
                $pdf->SetXY(59, 110);
                break;
            case 'No':
                $pdf->SetXY(69, 110);
                break;
        }
        $pdf->Cell(5, 5, 'X', 0, 0, 'L');

        if ($solicitud['sol_PuestosACargo']) {
            $puestos = json_decode($solicitud['sol_PuestosACargo']);
            $puestosacargo = '';
            foreach ($puestos as $p) {
                $pue = $this->db->query("SELECT * FROM puesto WHERE pue_PuestoID=" . $p)->getRowArray();
                $puestosacargo .= utf8_decode($pue['pue_Nombre']) . ',';
            }
            $pdf->SetXY(57, 115);
            $pdf->Multicell(115, 5, $puestosacargo, 0, 'L');
        }
        //escolaridad
        switch ($solicitud['sol_Escolaridad']) {
            case 'Secundaria':
                $pdf->SetXY(41, 133.5);
                break;
            case 'Preparatoria':
                $pdf->SetXY(72, 133.5);
                break;
            case 'Secretariado':
                $pdf->SetXY(41, 137);
                break;
            case 'Secretariado EspIng':
                $pdf->SetXY(72, 136);
                break;
            case 'Carrera Tecnica':
                $pdf->SetXY(41, 141);
                break;
            case 'Carrera Comercial':
                $pdf->SetXY(72, 140.5);
                break;
            case 'Profesional':
                $pdf->SetXY(41, 145);
                break;
        }
        $pdf->Cell(5, 5, 'X', 0, 0, 'L');

        //especificar carrera tecnica
        $pdf->SetXY(126, 140.5);
        $pdf->Cell(50, 5, utf8_decode($solicitud['sol_EspecificarCarreraTC']), 0, 0, 'L');
        //carrera
        $pdf->SetXY(80, 144.5);
        $pdf->Cell(50, 5, utf8_decode($solicitud['sol_EspecificarCarreraProf']), 0, 0, 'L');
        //postgrado
        if (!empty($solicitud['sol_Postgrado'])) {
            $pdf->SetXY(118, 144.5);
            $pdf->Cell(5, 5, 'X', 0, 0, 'L');
        }
        $pdf->SetXY(140, 144.5);
        $pdf->Cell(50, 5, utf8_decode($solicitud['sol_Postgrado']), 0, 0, 'L');

        //otro
        $pdf->SetXY(60, 151);
        $pdf->Cell(90, 5, utf8_decode($solicitud['sol_Otro']), 0, 0, 'L');

        //experiencia
        switch ($solicitud['sol_Experiencia']) {
            case 'Sin Experiencia':
                $pdf->SetXY(41, 156.5);
                break;
            case 'Con Experiencia':
                $pdf->SetXY(41, 161);
                break;
        }
        $pdf->Cell(5, 5, 'X', 0, 0, 'L');
        //años
        $pdf->SetXY(91, 157);
        $pdf->Cell(10, 5, utf8_decode($solicitud['sol_AnosExp']), 0, 0, 'L');
        //area
        $pdf->SetXY(111, 156);
        $pdf->Cell(10, 5, utf8_decode($solicitud['sol_AreaExp']), 0, 0, 'L');
        //Especificación de Perfil/Puest
        $pdf->SetXY(47, 166);
        $pdf->Cell(150, 4, utf8_decode(substr($solicitud['sol_EspPerfilPuesto'], 0, 80)) . '...', 0, 'L');
        //edad
        $pdf->SetXY(38, 178);
        $pdf->Cell(10, 4, $solicitud['sol_EdadPP'], 0, 0, 'L');
        //sexo
        switch ($solicitud['sol_SexoPP']) {
            case 'Hombre':
                $pdf->SetXY(78, 177.5);
                break;
            case 'Mujer':
                $pdf->SetXY(93, 177.5);
                break;
            case 'Indistinto':
                $pdf->SetXY(106, 177.5);
                break;
        }
        $pdf->Cell(5, 5, 'X', 0, 0, 'L');
        //estadocivil
        switch ($solicitud['sol_EstadoCPP']) {
            case 'Soltero':
                $pdf->SetXY(142, 178);
                break;
            case 'Casado':
                $pdf->SetXY(159, 178);
                break;
            case 'Indistinto':
                $pdf->SetXY(175, 178);
                break;
        }
        $pdf->Cell(5, 5, 'X', 0, 0, 'L');
        //contrato
        switch ($solicitud['sol_Contrato']) {
            case 'Determinado':
                $pdf->SetXY(77, 191);
                break;
            case 'Indeterminado':
                $pdf->SetXY(137, 190.5);
                break;
        }
        $pdf->Cell(5, 5, 'X', 0, 0, 'L');
        //tiempo contrato
        $pdf->SetXY(97, 192);
        $pdf->Cell(10, 4, utf8_decode($solicitud['sol_TiempoContrato']), 0, 0, 'L');
        //fecha de ingreso
        $pdf->SetXY(55, 199.5);
        $pdf->Cell(10, 4, strtoupper(shortDate($solicitud['sol_FechaIngreso'])), 0, 0, 'L');
        //sueldo contratacion
        $pdf->SetXY(55, 203);
        $pdf->Cell(10, 4, '$ ' . number_format($solicitud['sol_SueldoContratacion'], 2, '.', ','), 0, 0, 'L');
        //sueldo planta
        $pdf->SetXY(135, 203);
        $pdf->Cell(10, 4, '$ ' . number_format($solicitud['sol_SueldoPlanta'], 2, '.', ','), 0, 0, 'L');

        //datos del solicitante
        $pdf->SetFont('Arial', '', 6);
        $pdf->SetXY(74.9, 215.7);
        $pdf->MultiCell(43.6, 2.1, utf8_decode($solicitud['emp_Nombre']), 0, 0, 'C');
        //firma
        $pdf->SetXY(119.3, 215.7);
        $pdf->MultiCell(46, 2.1, utf8_decode($solicitud['emp_Nombre']), 0, 0, 'C');
        //Fecha
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetXY(165.8, 215);
        $pdf->Cell(31.6, 5, strtoupper(shortDate($solicitud['sol_Fecha'])), 0, 0, 'C');

        //Autoriza
        if ($solicitud['sol_DirGeneralAutorizada'] === 'AUTORIZADA') {
            $gerente = $this->db->query("SELECT emp_EmpleadoID,emp_Nombre FROM empleado E JOIN solicitudpersonal S ON E.emp_EmpleadoID = S.sol_AutorizaRechaza WHERE S.sol_SolicitudPersonalID = " . $solicitud['sol_SolicitudPersonalID'])->getRowArray();
            //Nombre
            $pdf->SetFont('Arial', '', 6);
            $pdf->SetXY(74.9, 220.7);
            $pdf->MultiCell(43.6, 2.1, utf8_decode($gerente['emp_Nombre']), 0, 0, 'C');
            //firma
            $pdf->SetXY(119.3, 220.7);
            $pdf->MultiCell(46, 2.1, utf8_decode($gerente['emp_Nombre']), 0, 0, 'C');
            //Fecha
            $pdf->SetFont('Arial', '', 9);
            $pdf->SetXY(165.8, 220);
            $pdf->Cell(31.6, 5, strtoupper(shortDate($solicitud['sol_DirGeneralFecha'])), 0, 0, 'C');
        }

        if ($output === 'F') {
            $pdf->output('F', './assets/uploads/solicitudPersonal/' . $idSolicitud . '/candidato/' . $candidatoID . '/Requisici.pdf');
        } else {
            //Output
            $pdf->output('I', 'solicitudPersonal-' . $idSolicitud . '.pdf');
        }
        exit();
    } //imprimirSolicitudPersonal

    //Diego -> PDF reporte confidencialidad colaboradores
    public function confidencialidadColaboradores($contratoID, $empleadoID)
    {
        $model = new PdfModel();
        $contrato = $model->getDatosContratos(encryptDecrypt('decrypt', $contratoID));

        //Create Document
        /*Pagina 1*/
        $pdf = new Fpdi();
        $pdf->AddPage("P", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/contratos/confidencialidad.pdf");
        $template = $pdf->importPage(1);
        $pdf->useTemplate($template, -1, 0, 220, 280);
        $pdf->SetFont('Arial', 'B', 11);

        //Empleado
        $pdf->SetXY(45, 29.5);
        $pdf->Cell(150, 6, 'C. ' . utf8_decode(strtoupper(eliminar_acentos($contrato['emp_Nombre']))), 0, 0, 'L');

        /*Pagina 2*/
        $pdf->AddPage("P", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/contratos/confidencialidad.pdf");
        $template = $pdf->importPage(2);
        $pdf->useTemplate($template, -1, 0, 220, 280);
        $pdf->SetFont('Arial', '', 11);

        /*Pagina 3*/
        $pdf->AddPage("P", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/contratos/confidencialidad.pdf");
        $template = $pdf->importPage(3);
        $pdf->useTemplate($template, -1, 0, 220, 280);
        $pdf->SetFont('Arial', '', 11);

        //Direccion
        $pdf->SetXY(50, 205.5);
        $direccion = ucwords(strtolower(eliminar_acentos($contrato['emp_Direccion']))) . ', C.P. ' . $contrato['emp_CodigoPostal'] . ', en ' . ucwords(strtolower(eliminar_acentos($contrato['emp_Municipio'] . ', ' . $contrato['emp_EntidadFederativa']))) . '.';
        $pdf->Cell(160, 3, $direccion, 0, 0, 'L');

        /*Pagina 4*/
        $pdf->AddPage("P", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/contratos/confidencialidad.pdf");
        $template = $pdf->importPage(4);
        $pdf->useTemplate($template, -1, 0, 220, 280);
        $pdf->SetFont('Arial', 'B', 11);
        //Fecha de ingreso
        $pdf->SetXY(87, 151.7);
        $pdf->Cell(60, 3, longDate($contrato['emp_FechaIngreso'], ' de ') . '.', 0, 0, 'L');
        //Empleado
        $pdf->SetXY(122, 183);
        $pdf->Cell(60, 6, 'C. ' . utf8_decode(strtoupper(eliminar_acentos($contrato['emp_Nombre']))) . '', 0, 0, 'C');
        /*Pagina 5*/
        $pdf->AddPage("P", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/contratos/confidencialidad.pdf");
        $template = $pdf->importPage(5);
        $pdf->useTemplate($template, -1, 0, 220, 280);
        $pdf->SetFont('Arial', 'B', 11);
        //Empleado
        $pdf->SetXY(123, 245);
        $pdf->Cell(70, 6, 'C. ' . utf8_decode(strtoupper(eliminar_acentos($contrato['emp_Nombre']))) . '', 0, 0, 'C');
        /*Pagina 6*/
        $pdf->AddPage("P", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/contratos/confidencialidad.pdf");
        $template = $pdf->importPage(6);
        $pdf->useTemplate($template, -1, 0, 220, 280);
        $pdf->SetFont('Arial', 'B', 11);
        //Empleado
        $pdf->SetXY(122, 187.5);
        $pdf->Cell(80, 6, 'C. ' . utf8_decode(strtoupper(eliminar_acentos($contrato['emp_Nombre']))) . '', 0, 0, 'C');

        //Output
        $pdf->output('I', eliminar_acentos(strtoupper($contrato['emp_Nombre'])) . '_confidencialidadColaboradores.pdf');
        exit();
    } // end confidencialidadColaboradores

    //Diego -> PDF reporte trabajo determinado
    public function contratoTrabajo($contratoID, $empleadoID)
    {
        $model = new PdfModel();
        $contrato = $model->getDatosContratos(encryptDecrypt('decrypt', $contratoID));
        //Create Document
        $pdf = new Fpdi();
        /*Pagina 1*/
        $pdf->AddPage("P", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/contratos/contrato.pdf");
        $template = $pdf->importPage(1);
        $pdf->useTemplate($template, -1, 0, 220, 280);
        $pdf->SetFont('Times', 'B', 10);

        //Empleado
        $pdf->SetXY(28.5, 39);
        $pdf->Cell(160, 6, 'C. ' . utf8_decode(strtoupper(eliminar_acentos($contrato['emp_Nombre']))) . ',', 0, 0, 'L');
        //sexo
        $pdf->SetXY(120, 112.5);
        $pdf->Cell(160, 6, utf8_decode(strtoupper(eliminar_acentos($contrato['emp_Sexo']))) . ';', 0, 0, 'L');
        //edad
        $pdf->SetXY(149, 112.5);
        $pdf->Cell(10, 6, cumpleanos($contrato['emp_FechaNacimiento']), 0, 0, 'L');
        //estado civil
        $pdf->SetXY(46, 118);
        $pdf->Cell(25, 3, utf8_decode(strtoupper(eliminar_acentos($contrato['emp_EstadoCivil']))), 0, 0, 'C');
        //Nacionalidad
        $pdf->SetXY(105, 118);
        $pdf->Cell(25, 3, utf8_decode(strtoupper(eliminar_acentos('Mexicana'))), 0, 0, 'C');
        //Direccion
        $pdf->SetXY(38, 122);
        $pdf->Cell(160, 3, utf8_decode(strtoupper(eliminar_acentos($contrato['emp_Direccion'] . ', ' . $contrato['emp_Municipio'] . ', ' . $contrato['emp_EntidadFederativa'] . '., C.P. ' . $contrato['emp_CodigoPostal'] . ','))), 0, 0, 'L');
        //RFC
        $pdf->SetXY(111, 126);
        $pdf->Cell(25, 3, utf8_decode(strtoupper($contrato['emp_Rfc'])), 0, 0, 'C');
        //Curp
        $pdf->SetXY(57, 130);
        $pdf->Cell(55, 3, utf8_decode(strtoupper($contrato['emp_Curp'])) . '.', 0, 0, 'L');
        //Fecha de ingreso
        $pdf->SetXY(30, 187);
        $pdf->Cell(160, 3, utf8_decode(strtoupper(longDate($contrato['emp_FechaIngreso'], ' de '))), 0, 0, 'C');
        //puesto
        $puesto = $this->db->query("SELECT pue_Nombre FROM puesto WHERE pue_PuestoID=" . $contrato['emp_PuestoID'])->getRowArray()['pue_Nombre'];
        $pdf->SetXY(28.5, 207.5);
        $pdf->Cell(160, 3, utf8_decode(strtoupper($puesto)), 0, 0, 'L');


        /*Pagina 2*/
        $pdf->AddPage("P", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/contratos/contrato.pdf");
        $template = $pdf->importPage(2);
        $pdf->useTemplate($template, -1, 0, 220, 280);
        $pdf->SetFont('Times', 'B', 10);

        /*Pagina 3*/
        $pdf->AddPage("P", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/contratos/contrato.pdf");
        $template = $pdf->importPage(3);
        $pdf->useTemplate($template, -1, 0, 220, 280);
        $pdf->SetFont('Times', '', 10);

        //Fecha de ingreso
        $pdf->SetXY(28, 140);
        $pdf->Cell(160, 3, utf8_decode(strtoupper(longDate($contrato['emp_FechaIngreso'], ' de '))) . ', quedando un ejemplar en poder de cada una de las PARTES.', 0, 0, 'L');

        $pdf->SetFont('Times', 'B', 9);
        //Empleado
        $pdf->SetXY(124, 175);
        $pdf->Cell(60, 6, 'C. ' . utf8_decode(strtoupper(eliminar_acentos($contrato['emp_Nombre']))) . '', 0, 0, 'C');

        //Output
        $pdf->output('I', eliminar_acentos(strtoupper($contrato['emp_Nombre'])) . '_Contrato de Trabajo.pdf');
        exit();
    } // end trabajoTDeterminado

    //Diego -> PDF reporte trabajo indeterminado
    public function trabajoTIndeterminado($contratoID, $empleadoID)
    {
        $model = new PdfModel();
        $contrato = $model->getDatosContratos(encryptDecrypt('decrypt', $contratoID));
        $empleado = $model->getDatosEmpleado(encryptDecrypt('decrypt', $empleadoID));

        //Create Document
        $pdf = new Fpdi();
        /*Pagina 1*/
        $pdf->AddPage("P", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/contratos/ContratoTrabajoTiempoIndeterminado.pdf");
        $template = $pdf->importPage(1);
        $pdf->useTemplate($template, -1, 0, 220, 280);
        $pdf->SetFont('Arial', 'B', 11);

        //Empleado
        $pdf->SetXY(113, 64);
        $pdf->Cell(160, 6, utf8_decode(strtoupper($empleado['emp_Nombre'])), 0, 0, 'L');

        /*Pagina 2*/
        $pdf->AddPage("P", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/contratos/ContratoTrabajoTiempoIndeterminado.pdf");
        $template = $pdf->importPage(2);
        $pdf->useTemplate($template, -1, 0, 220, 280);
        $pdf->SetFont('Arial', 'B', 11);

        //Nacionalidad
        $pdf->SetXY(150, 57);
        $pdf->Cell(30, 6, 'MEXICANA', 0, 0, 'L');
        //Sexo
        $pdf->SetXY(38, 62.5);
        $pdf->Cell(30, 6, utf8_decode(strtoupper($empleado['emp_Sexo'])), 0, 0, 'L');
        //Estado Civil
        $pdf->SetXY(105, 62.5);
        $pdf->SetFillColor(255, 255, 255);
        $pdf->Cell(40, 6, utf8_decode(strtoupper($empleado['emp_EstadoCivil'])) . ',', 0, 0, 'C', true);
        //Fecha de Nacimiento
        $pdf->SetXY(22, 67.5);
        $pdf->Cell(60, 6, utf8_decode(strtoupper(longDate($empleado['emp_FechaNacimiento'], ' de '))), 0, 0, 'C');
        //Edad
        $pdf->SetXY(103, 67.5);
        $edad = date('Y') - $empleado['edad'];
        if ($empleado['emp_FechaNacimiento'] < date('Y-m-d')) {
            $edad = $edad - 1;
        }
        $pdf->Cell(20, 6, $edad, 0, 0, 'L');

        //CURP
        $pdf->SetXY(22, 87.5);
        $pdf->Cell(60, 6, utf8_decode(strtoupper($empleado['emp_Curp'])), 0, 0, 'C');
        //RFC
        $pdf->SetXY(22, 93);
        $pdf->Cell(180, 6, utf8_decode(strtoupper($empleado['emp_Rfc'])) . '.', 0, 0, 'C');

        //Direccion de trabajador
        $pdf->SetXY(22, 112);
        $pdf->MultiCell(160, 6, utf8_decode(strtoupper($empleado['emp_Direccion'] . ' ' . $empleado['emp_CodigoPostal'] . ' ' . $empleado['emp_Municipio'])), 0, 'L');

        //Puesto
        $pdf->SetXY(22, 130);
        $pdf->MultiCell(160, 6, utf8_decode(strtoupper($empleado['pue_Nombre'])) . '.', 0, 'L');


        /*Pagina 3*/
        $pdf->AddPage("P", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/contratos/ContratoTrabajoTiempoIndeterminado.pdf");
        $template = $pdf->importPage(3);
        $pdf->useTemplate($template, -1, 0, 220, 280);
        $pdf->SetFont('Arial', '', 11);

        //Puesto
        $pdf->SetXY(95, 34.5);
        $pdf->MultiCell(160, 6, utf8_decode(strtoupper($empleado['pue_Nombre'])) . '.', 0, 'L');
        //Fecha Ingreso
        $pdf->SetXY(30, 54);
        $pdf->MultiCell(160, 6, utf8_decode(strtoupper(longDate($empleado['emp_FechaIngreso'], ' de '))) . '.', 0, 'L');

        /*Pagina 4*/
        $pdf->AddPage("P", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/contratos/ContratoTrabajoTiempoIndeterminado.pdf");
        $template = $pdf->importPage(4);
        $pdf->useTemplate($template, -1, 0, 220, 280);
        $pdf->SetFont('Arial', 'B', 11);

        //Salario
        $pdf->SetXY(25, 166.5);
        $pdf->MultiCell(160, 6, number_format($empleado['emp_SalarioDiario'], 2, '.', ',') . ' ' . num_letras($empleado['emp_SalarioDiario'], 'MN'), 0, 'L');

        /*Pagina 5*/
        $pdf->AddPage("P", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/contratos/ContratoTrabajoTiempoIndeterminado.pdf");
        $template = $pdf->importPage(5);
        $pdf->useTemplate($template, -1, 0, 220, 280);
        $pdf->SetFont('Arial', '', 11);
        /*Pagina 6*/
        $pdf->AddPage("P", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/contratos/ContratoTrabajoTiempoIndeterminado.pdf");
        $template = $pdf->importPage(6);
        $pdf->useTemplate($template, -1, 0, 220, 280);
        $pdf->SetFont('Arial', '', 11);
        /*Pagina 7*/
        $pdf->AddPage("P", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/contratos/ContratoTrabajoTiempoIndeterminado.pdf");
        $template = $pdf->importPage(7);
        $pdf->useTemplate($template, -1, 0, 220, 280);
        $pdf->SetFont('Arial', 'B', 11);

        //Fecha de Ingres
        $pdf->SetXY(22, 103);
        $pdf->Cell(160, 6, utf8_decode(strtoupper(longDate($empleado['emp_FechaIngreso'], ' de '))) . '.', 0, 0, 'L');

        //Empleado
        $pdf->SetXY(127, 170);
        $pdf->MultiCell(60, 6, 'C.' . utf8_decode(strtoupper($empleado['emp_Nombre'])), 0, 'C');

        //Output
        $pdf->output('I', 'confidencialidadColaboradores.pdf');
        exit();
    } // end trabajoTIndeterminado

    public function imprimirInformeSalidas($idInforme)
    {
        $idInforme = (int)encryptDecrypt('decrypt', $idInforme);

        if (empty($idInforme)) {
            exit();
        } //if

        $model = new PdfModel();
        $informe = $model->getInformeById($idInforme);

        $pdf = new Fpdi();
        $pdf->AddPage("P", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/informeSalidas.pdf");
        $template = $pdf->importPage(1);
        $pdf->useTemplate($template, -1, 0, 220, 280);

        $pdf->SetFont('Arial', '', 10);

        //Fecha
        $pdf->SetXY(166, 60.5);
        $pdf->Cell(25, 4, $informe['rep_FechaRegistro'], 0, 0, 'J');

        //Colaborador
        $pdf->SetXY(35, 65);
        $pdf->Cell(65, 4, utf8_decode($informe['emp_Nombre']), 0, 0, 'J');

        //Semana
        $pdf->SetXY(60, 92);
        $pdf->Cell(65, 4, utf8_decode($informe['rep_Semana']), 0, 0, 'J');

        $y = 110;
        $dias = json_decode($informe['rep_Dias'], true);
        $count = 0;
        for ($i = 0; $i < count($dias); $i++) {

            switch ($dias[$i]['socap']) {
                case 0:
                    $socap = 'FEDERACION';
                    break;
                case 10001:
                    $socap = 'OTRO';
                    break;
                default:
                    $socap = $this->db->query("SELECT suc_Sucursal FROM sucursal WHERE suc_SucursalID=" . (int)$dias[$i]['socap'])->getRowArray()['suc_Sucursal'];
                    break;
            }

            $pdf->SetXY(23, $y);
            $pdf->MultiCell(35, 10, utf8_decode($socap), 0, 'C');
            $pdf->SetXY(58, $y);
            $pdf->Cell(27, 10, shortDate($dias[$i]['fecha']), 0, 0, 'C');
            $pdf->SetXY(85, $y);
            $pdf->MultiCell(59, 5, utf8_decode($dias[$i]['objetivo']), 0, 'C');
            $pdf->SetXY(145, $y);
            $pdf->MultiCell(58, 5, utf8_decode($dias[$i]['logros']), 0, 'J');
            $y += 20;

            $count++;
        }

        $pdf->SetXY(110, 238);
        $pdf->Cell(10, 3, $count, 0, 0, 'J');

        $pdf->AddPage("P", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/informeSalidas.pdf");
        $template = $pdf->importPage(2);
        $pdf->useTemplate($template, -1, 0, 220, 280);

        $pdf->SetFont('Arial', '', 10);

        //Firma colaborador
        $pdf->SetXY(75, 85);
        $pdf->Cell(70, 5, utf8_decode($informe['emp_Nombre']), 0, 0, 'C');

        //Firma Jefe
        if ($informe['rep_Estado'] === "AUTORIZADO" || $informe['rep_Estado'] === "APLICADO") {
            $builder = db()->table("empleado");
            $jefe = $builder->getWhere(array("emp_Numero" => $informe['emp_Jefe']))->getRowArray()['emp_Nombre'];
            $pdf->SetXY(37, 135);
            $pdf->MultiCell(58, 5, utf8_decode($jefe), 0, 'C');
        }

        //Firma CH
        if ($informe['rep_Estado'] === "APLICADO") {
            $builder = db()->table("empleado");
            $ch = $builder->getWhere(array("emp_EmpleadoID" => $informe['rep_AproboID']))->getRowArray()['emp_Nombre'];
            $pdf->SetXY(120, 135);
            $pdf->MultiCell(60, 5, utf8_decode($ch), 0, 'C');
        }

        //Observaciones
        if ($informe['rep_ObservacionesRJ'] !== "" || $informe['rep_ObservacionesRCH'] !== "") {
            $pdf->SetXY(28, 180);
            $pdf->MultiCell(165, 5, "OBSERVACIONES: " . utf8_decode($informe['rep_ObservacionesRJ']), 0, 'J');
            $pdf->SetXY(28, 180);
            $pdf->MultiCell(165, 5, "OBSERVACIONES: " . utf8_decode($informe['rep_ObservacionesRCH']), 0, 'J');
        }

        //Output
        $pdf->output('I', 'Informe_Salidas_' . utf8_decode($informe['emp_Nombre']) . '_' . $informe['rep_Semana'] . '.pdf');
        exit();
    }

    public function imprimirReporteHorasExtra($idReporte)
    {
        $idReporte = (int)encryptDecrypt('decrypt', $idReporte);

        if (empty($idReporte)) {
            exit();
        } //if

        $model = new PdfModel();
        $informe = $model->getReporteHorasById($idReporte);

        $pdf = new Fpdi();
        $pdf->AddPage("L", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/horasextras.pdf");
        $template = $pdf->importPage(1);
        $pdf->useTemplate($template, -1, 0, 280, 250);

        $pdf->SetFont('Arial', '', 15);

        //Fecha
        $pdf->SetXY(205, 51.5);
        $pdf->Cell(50, 8, strtoupper(shortDate($informe['rep_FechaRegistro'])), 0, 0, 'C');

        //Colaborador
        $pdf->SetXY(85, 48);
        $pdf->Multicell(93, 8, utf8_decode($informe['emp_Nombre']), 0, 'C');

        //puesto
        $pdf->SetXY(83, 65);
        $pdf->MultiCell(60, 8, utf8_decode($informe['pue_Nombre']), 0, 'C');

        //Departamento
        $pdf->SetXY(187, 65);
        $pdf->MultiCell(76, 16, utf8_decode($informe['dep_Nombre']), 0, 'C');

        //de las
        $pdf->SetXY(82, 87);
        $pdf->MultiCell(60, 5.5, shortTime($informe['rep_HoraInicio']), 0, 'C');
        //de las
        $pdf->SetXY(190, 87);
        $pdf->MultiCell(60, 5.5, shortTime($informe['rep_HoraFin']), 0, 'C');

        //total horas
        $pdf->SetXY(82, 104);
        $pdf->Cell(38, 5, $informe['rep_Horas'], 0, 0, 'C');

        //feha del tiempo trabajado
        $pdf->SetXY(205, 107);
        $pdf->Cell(42, 3, strtoupper(shortDate($informe['rep_Fecha'])), 0, 0, 'C');

        //comentario
        $pdf->SetXY(15, 135);
        $pdf->MultiCell(245, 5, utf8_decode($informe['rep_Motivos']), 0,  'L');

        $pdf->SetFont('Arial', '', 12);
        //Firma colaborador
        $pdf->SetXY(41, 175);
        $pdf->MultiCell(55, 5, utf8_decode($informe['emp_Nombre']), 0, 'C');

        //Firma Jefe
        if ($informe['rep_Estado'] === "AUTORIZADO" || $informe['rep_Estado'] === "APLICADO" || $informe['rep_Estado'] === 'PAGADO') {
            $builder = db()->table("empleado");
            $jefe = $builder->getWhere(array("emp_Numero" => $informe['emp_Jefe']))->getRowArray()['emp_Nombre'];
            //var_dump($jefe);exit();
            $pdf->SetXY(99, 175);
            $pdf->MultiCell(65, 5, utf8_decode($jefe), 0, 'C');
        }

        //Firma CH
        if ($informe['rep_Estado'] === "APLICADO" || $informe['rep_Estado'] === 'PAGADO') {
            $builder = db()->table("empleado");
            $ch = $builder->getWhere(array("emp_EmpleadoID" => $informe['rep_AproboID']))->getRowArray()['emp_Nombre'];
            $pdf->SetXY(160, 175);
            $pdf->MultiCell(75, 5, utf8_decode($ch), 0, 'C');
        }

        //Observaciones
        if ($informe['rep_ObservacionesJ'] !== "") {
            $pdf->SetXY(15, 150);
            $pdf->MultiCell(165, 5, "Observaciones Jefe: " . utf8_decode($informe['rep_ObservacionesJ']), 0, 'J');
        }

        if ($informe['rep_ObservacionesCH'] !== "") {
            $pdf->SetXY(15, 150);
            $pdf->MultiCell(165, 5, "Observaciones Capital Humano: " . utf8_decode($informe['rep_ObservacionesCH']), 0, 'J');
        }

        //Output
        $pdf->output('I', 'SolicitudHorasExtra_' . utf8_decode($informe['emp_Nombre']) . '_' . $informe['rep_Fecha'] . '.pdf');
        exit();
    }


    function marcaDiaHorasExtra($dia, $pdf, $y)
    {
        $posiciones = array("Lunes" => 53.5, "Martes" => 60.5, "Miercoles" => 67.7, "Jueves" => 74.65, "Viernes" => 81.7, "Sabado" => 88.5);
        if ($dia != '') {
            $x = $posiciones[$dia];
            $pdf->SetXY($x, $y);
            $pdf->SetFillColor(105, 105, 105);
            $pdf->Cell(7.2, 7.1, '', 0, 0, 'C', true);
        } //if estatus
    }


    //Diego -> PDF reporte incidencias
    public function reporteIncidencias($empleadoID)
    {
        $empleadoID = (int)encryptDecrypt('decrypt', $empleadoID);

        //Datos del Empleado
        $model = new PdfModel();
        $empleado = $model->getEmpleadoInfo($empleadoID);

        //Create Document
        $pdf = new Fpdi();
        $pdf->AddPage("P", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/kardex.pdf");
        $template = $pdf->importPage(1);
        $pdf->useTemplate($template, -1, 0, 220, 280);
        $pdf->SetFont('Arial', '', 11);

        //logo
        $logo = FCPATH . "/assets/images/thigo/1.png";
        $pdf->Image($logo, 50, 17, 15, 15);

        //DATOS DEL EMPLEADO
        //Fecha Actual
        $year = date('Y');
        $pdf->SetXY(125, 23);
        $pdf->Cell(28, 6, utf8_decode($year), 0, 0, 'C');

        //Fecha de ingreso
        $fechaIngreso =  longDate($empleado['emp_FechaIngreso'], " de ");
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetXY(153.5, 23.5);
        $pdf->MultiCell(28, 4, utf8_decode($fechaIngreso), 0, 'C');

        //Nombre Empleado
        $pdf->SetXY(79.5, 39);
        $pdf->MultiCell(57, 4, utf8_decode($empleado['emp_Nombre']), 0, 'L');

        //Fecha Nacimiento
        $fechaNacimiento =  longDate($empleado['emp_FechaNacimiento'], " de ");
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetXY(136.5, 39);
        $pdf->MultiCell(45, 4, utf8_decode($fechaNacimiento), 0, 'C');
        $pdf->SetFont('Arial', '', 10);

        //#empleado
        $pdf->SetXY(79.5, 54);
        $pdf->Cell(28.5, 4, utf8_decode($empleado['emp_Numero']), 0, 0, 'C');

        //Edad
        $edad = cumpleanos($empleado['emp_FechaNacimiento']);
        $pdf->SetXY(108, 54);
        $pdf->Cell(22.5, 4, utf8_decode($edad), 0, 0, 'C');

        //Telefono
        $pdf->SetXY(130.5, 54);
        $pdf->Cell(51, 4, utf8_decode($empleado['emp_Telefono']), 0, 0, 'C');

        //Correo
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetXY(79.5, 67);
        $pdf->MultiCell(45.5, 4, utf8_decode($empleado['emp_Correo']), 0, 'C');

        //Departamento
        $pdf->SetXY(125, 65);
        $pdf->MultiCell(28.5, 3.5, utf8_decode($empleado['dep_Nombre']), 0, 'C');

        //Puesto
        $pdf->SetXY(153.5, 65);
        $pdf->MultiCell(28.5, 3.5, utf8_decode($empleado['pue_Nombre']), 0, 'C');

        //Foto
        $fotoPerfil = fotoPerfil(encryptDecrypt('encrypt', $empleadoID));
        $pdf->Image($fotoPerfil, 36, 32.9, 42, 42.3);
        $pdf->SetFont('Arial', '', 8);

        $primerRegistro = '';
        if ($empleado['ano'] == date('Y')) {
            $primerRegistro = $this->db->query("SELECT MONTH(asi_Fecha) as 'mes' FROM asistencia WHERE asi_EmpleadoID=" . $empleadoID . " AND YEAR(asi_Fecha)=" . date('Y') . " ORDER BY asi_AsistenciaID ASC LIMIT 1")->getRowArray()['mes'];
        }
        /*if(date('Y')=='2023'){
            $primerRegistro=11;
        }*/

        //Calendario
        $x = 23.02;
        $y = 85.8;
        $nMes = 1;
        if (!empty($primerRegistro)) {
            $nMes = $primerRegistro;
        }
        $ultimoMesRegistro = db()->query("SELECT MONTH(asi_Fecha) as 'asi_Fecha' FROM asistencia WHERE asi_EmpleadoID=? AND YEAR(asi_Fecha)=? ORDER BY asi_Fecha DESC LIMIT 1", array($empleadoID, date('Y')))->getRowArray()['asi_Fecha'] ?? 1;
        for ($nMes; $nMes <= (int)$ultimoMesRegistro; $nMes++) {
            $meses = [1 => 31, 2 => date("L") ? 29 : 28, 3 => 31, 4 => 30, 5 => 31, 6 => 30, 7 => 31, 8 => 31, 9 => 30, 10 => 31, 11 => 30, 12 => 31,];
            $nDia = $meses[$nMes];
            for ($i = 1; $i <= $nDia; $i++) {
                $fecha = date('Y-m-d', strtotime(date('Y-' . $nMes . '-' . $i)));
                if ($fecha >= $empleado['emp_FechaIngreso'] && $fecha < date('Y-m-d')) {
                    $diaNombre = get_nombre_dia($fecha);
                    //Horario
                    $horario = $this->db->query("SELECT H.* FROM horario H JOIN empleado E on E.emp_HorarioID=H.hor_HorarioID WHERE E.emp_EmpleadoID=?", [$empleadoID])->getRowArray();
                    $tolerancia = "+" . $horario['hor_Tolerancia'] . " minutes";
                    $guardia = $this->db->query("SELECT * FROM guardia WHERE gua_EmpleadoID=? AND ? BETWEEN gua_FechaInicio AND gua_FechaFin", [$empleadoID, $fecha])->getRowArray() ?? null;
                    if ($guardia) {
                        $horario = $this->db->query("SELECT * FROM horario WHERE hor_HorarioID=?", [$guardia['gua_HorarioID']])->getRowArray();
                    }
                    $checador = $this->db->query("SELECT asi_Hora FROM asistencia WHERE asi_EmpleadoID=? AND asi_Fecha=?", [$empleadoID, $fecha])->getRowArray();
                    $fechaseparada = explode('-', $fecha);
                    $asistencia = array(
                        "dia" => $fechaseparada[2],
                        "mes" => $fechaseparada[1],
                        "ano" => $fechaseparada[0],
                        "fecha" => $fecha,
                        "horaEntrada" => '00:00',
                        "justificacion" => ''
                    );
                    if ($checador !== null) {
                        $asistencia['horaEntrada'] = json_decode($checador['asi_Hora'])[0];
                        //$asistencia['justificacion']=$checador['asi_Justificacion'];
                    }
                    //Permisos
                    $permisos = $this->db->query("SELECT per_TipoID FROM permiso P WHERE ? BETWEEN per_FechaInicio AND per_FechaFin AND P.per_EmpleadoID=? AND P.per_Estado = 'AUTORIZADO_RH' AND per_Estatus=1", [$fecha, $empleadoID])->getRowArray()['per_TipoID'] ?? null;
                    //Salidas
                    $salidas = $this->db->query("SELECT rep_Dias FROM reportesalida WHERE rep_EmpleadoID=? AND rep_Estado IN('APLICADO','PAGADO') AND rep_Estatus=1 AND ? BETWEEN rep_DiaInicio AND rep_DiaFin ", array($empleadoID, $fecha))->getResultArray();
                    $reportesalidas = 0;
                    foreach ($salidas as $salida) {
                        $presalidas = json_decode($salida['rep_Dias'], true);
                        foreach ($presalidas as $presalida) {
                            if ($presalida['fecha'] === $fecha) {
                                $reportesalidas = 1;
                            }
                        }
                    }
                    $pdf->SetXY($x + (5.675 * $asistencia['dia']), $y + (4.82 * $asistencia['mes']));
                    if ($horario['hor_' . $diaNombre . 'Descanso'] == 0) {
                        $horaEntrada = date('h:i', strtotime($tolerancia, strtotime($horario['hor_' . $diaNombre . 'Entrada'])));
                    }
                    //Si tiene asistencia
                    if ($asistencia['horaEntrada'] !== '00:00') {
                        //si tiene justificacion
                        if ($asistencia['justificacion'] === '1') {
                            $pdf->SetFillColor(29, 154, 221);
                            $pdf->Cell(5.4, 4.4, '*', 0, 0, 'C', true);
                        } elseif ($permisos) {
                            switch ($permisos) {
                                case 6:
                                    $color = [156, 231, 122];
                                    break;
                                default:
                                    $color = [142, 124, 195];
                                    break;
                            }
                            $pdf->SetFillColor($color[0], $color[1], $color[2]);
                            $pdf->Cell(5.4, 4.4, 'P', 0, 0, 'C', true);
                        } elseif ($reportesalidas) {
                            $pdf->SetFillColor(89, 195, 195);
                            $pdf->Cell(5.4, 4.4, 'S', 0, 0, 'C', true);
                        } else { //Si llego bien o tiene retardo
                            $color = $horaEntrada >= $asistencia['horaEntrada'] ? [29, 154, 221] : [255, 111, 97];
                            $pdf->SetFillColor(...$color);
                            $pdf->Cell(5.4, 4.4, $horaEntrada >= $asistencia['horaEntrada'] ? '*' : 'R', 0, 0, 'C', true);
                        }
                    } else { // Si no asistio o no tiene registro
                        //Dia inhabil
                        $inhabiles = $this->db->query("SELECT D.dia_Fecha FROM diainhabil D WHERE D.dia_Fecha=? UNION SELECT DI.dial_Fecha as 'dia_Fecha' FROM diainhabilley DI WHERE DI.dial_Fecha=?", [$fecha, $fecha])->getRowArray()['dia_Fecha'] ?? null;
                        //vacaciones
                        $vacaciones = $this->db->query("SELECT vac_VacacionesID FROM vacacion WHERE vac_EmpleadoID=? AND vac_Estatus='AUTORIZADO_RH' AND vac_Estado=1 AND ? BETWEEN vac_FechaInicio AND vac_FechaFin", array($empleadoID, $fecha))->getRowArray()['vac_VacacionesID'] ?? null;
                        //Incapacidad
                        $incapacidades = $this->db->query("SELECT inc_IncapacidadID FROM incapacidad  WHERE inc_Estatus='Autorizada' AND inc_EmpleadoID=? AND ? BETWEEN inc_FechaInicio AND inc_FechaFin", array($empleadoID, $fecha))->getRowArray()['inc_Incapacidad'] ?? null;
                        //Salidas
                        $salidas = $this->db->query("SELECT rep_Dias FROM reportesalida WHERE rep_EmpleadoID=? AND rep_Estado IN('APLICADO','PAGADO') AND rep_Estatus=1 AND ? BETWEEN rep_DiaInicio AND rep_DiaFin ", array($empleadoID, $fecha))->getResultArray();
                        $reportesalidas = 0;
                        foreach ($salidas as $salida) {
                            $presalidas = json_decode($salida['rep_Dias'], true);
                            foreach ($presalidas as $presalida) {
                                if ($presalida['fecha'] === $fecha) {
                                    $reportesalidas = 1;
                                }
                            }
                        }
                        //Suspensiones
                        //$suspensiones = $this->db->query("SELECT act_FechaRealizo FROM actaadministrativa  WHERE act_EmpleadoID=? AND act_Estatus='APLICADA' AND act_Tipo='Suspension' AND act_FechaRealizo=?", array($empleadoID,$fecha))->getRowArray();

                        if ($horario['hor_' . $diaNombre . 'Descanso'] == 1) {
                            $color = ($diaNombre == 'Domingo') ? [128, 128, 128] : [29, 154, 221];
                            $pdf->SetFillColor(...$color);
                            $pdf->Cell(5.4, 4.4, ($diaNombre == 'Domingo') ? 'D' : '', 0, 0, 'C', true);
                        } else {
                            //tipo de cuadro
                            $pdf->SetXY($x + (5.675 * $i), $y + (4.82 * $nMes));
                            if ($inhabiles) {
                                $pdf->SetFillColor(233, 113, 23);
                                $pdf->Cell(5.4, 4.4, 'DI', 0, 0, 'C', true);
                            } elseif ($vacaciones) {
                                $pdf->SetFillColor(255, 217, 102);
                                $pdf->Cell(5.4, 4.4, 'V', 0, 0, 'C', true);
                            } elseif ($incapacidades) {
                                $pdf->SetFillColor(213, 166, 189);
                                $pdf->Cell(5.4, 4.4, 'IN', 0, 0, 'C', true);
                            } elseif ($permisos) {
                                switch ($permisos) {
                                    case 6:
                                        $color = [156, 231, 122];
                                        break;
                                    default:
                                        $color = [142, 124, 195];
                                        break;
                                }
                                $pdf->SetFillColor($color[0], $color[1], $color[2]);
                                $pdf->Cell(5.4, 4.4, 'P', 0, 0, 'C', true);
                            } elseif ($reportesalidas) {
                                $pdf->SetFillColor(89, 195, 195);
                                $pdf->Cell(5.4, 4.4, 'S', 0, 0, 'C', true);
                            }/*elseif($suspensiones){
                                $pdf->SetFillColor(234, 21, 21);
                                $pdf->Cell(5.4, 4.4, 'SL', 0, 0, 'C', true);
                            }*/ else {
                                $pdf->SetFillColor(234, 21, 21);
                                $pdf->Cell(5.4, 4.4, '/', 0, 0, 'C', true);
                            }
                        }
                    }
                }
            }
        }


        //Notacion
        $pdf->SetFillColor(36, 64, 97);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetDrawColor(16, 121, 196);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetXY(40, 155);
        $pdf->Cell(136, 5, utf8_decode('Notación'), 1, 0, 'C', true);

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetXY(40, 160);
        $pdf->SetFillColor(29, 154, 221);
        $pdf->Cell(13, 5, utf8_decode('*'), 1, 0, 'C', true);
        $pdf->SetFillColor(255);
        $pdf->Cell(55, 5, utf8_decode('Asistencia'), 1, 0, 'C', true);
        $pdf->SetFillColor(142, 124, 195);
        $pdf->Cell(13, 5, utf8_decode('P'), 1, 0, 'C', true);
        $pdf->SetFillColor(255);
        $pdf->Cell(55, 5, utf8_decode('Permisos'), 1, 0, 'C', true);

        $pdf->SetXY(40, 165);
        $pdf->SetFillColor(234, 21, 21);
        $pdf->Cell(13, 5, utf8_decode('/'), 1, 0, 'C', true);
        $pdf->SetFillColor(255);
        $pdf->Cell(55, 5, utf8_decode('Falta'), 1, 0, 'C', true);
        $pdf->SetFillColor(156, 231, 122);
        $pdf->Cell(13, 5, utf8_decode('P'), 1, 0, 'C', true);
        $pdf->SetFillColor(255);
        $pdf->Cell(55, 5, utf8_decode('Permisos (por horas)'), 1, 0, 'C', true);

        $pdf->SetXY(40, 170);
        $pdf->SetFillColor(255, 111, 97);
        $pdf->Cell(13, 5, utf8_decode('R'), 1, 0, 'C', true);
        $pdf->SetFillColor(255);
        $pdf->Cell(55, 5, utf8_decode('Retardo'), 1, 0, 'C', true);
        $pdf->SetFillColor(233, 113, 23);
        $pdf->Cell(13, 5, utf8_decode('DI'), 1, 0, 'C', true);
        $pdf->SetFillColor(255);
        $pdf->Cell(55, 5, utf8_decode('Día inhábil'), 1, 0, 'C', true);

        $pdf->SetXY(40, 175);
        $pdf->SetFillColor(255, 217, 102);
        $pdf->Cell(13, 5, utf8_decode('V'), 1, 0, 'C', true);
        $pdf->SetFillColor(255);
        $pdf->Cell(55, 5, utf8_decode('Vacaciones'), 1, 0, 'C', true);
        $pdf->SetFillColor(213, 166, 189);
        $pdf->Cell(13, 5, utf8_decode('IN'), 1, 0, 'C', true);
        $pdf->SetFillColor(255);
        $pdf->Cell(55, 5, utf8_decode('Incapacidad'), 1, 0, 'C', true);

        $pdf->SetXY(40, 180);
        $pdf->SetFillColor(89, 195, 195);
        $pdf->Cell(13, 5, utf8_decode('S'), 1, 0, 'C', true);
        $pdf->SetFillColor(255);
        $pdf->Cell(55, 5, utf8_decode('Salida'), 1, 0, 'C', true);
        $pdf->SetFillColor(128, 128, 128);
        $pdf->Cell(13, 5, utf8_decode('D'), 1, 0, 'C', true);
        $pdf->SetFillColor(255);
        $pdf->Cell(55, 5, utf8_decode('Domingo'), 1, 0, 'C', true);


        $diasLey = diasLey($empleado['emp_FechaIngreso']);
        $diasRestantes = diasPendientes($empleadoID);
        $empleadoFI = db()->query("SELECT emp_FechaIngreso FROM empleado WHERE emp_EmpleadoID=" . $empleadoID)->getRowArray();
        $diasOcupados = diasOcupados($empleadoID, $empleadoFI['emp_FechaIngreso']);

        //Info vacaciones
        $pdf->SetFillColor(36, 64, 97);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetDrawColor(16, 121, 196);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetXY(40, 195);
        $pdf->Cell(136, 5, utf8_decode('Vacaciones'), 1, 0, 'C', true);

        $pdf->SetFillColor(255);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetXY(40, 200);
        $pdf->Cell(45.3, 5, $diasLey . utf8_decode(' días correspondientes'), 1, 0, 'C', true);
        $pdf->Cell(45.3, 5, $diasRestantes . utf8_decode(' días restantes'), 1, 0, 'C', true);
        $pdf->Cell(45.3, 5, $diasOcupados . utf8_decode(' días tomados'), 1, 0, 'C', true);

        //Output
        $pdf->output('I', 'Kardex#' . $empleado['emp_EmpleadoID'] . '.pdf');
        exit();
    } // end reporteIncidencias

    //Nat -> PDF reporte incidencias
    public function reporteIncidencias_old($empleadoID)
    {
        $empleadoID = (int)encryptDecrypt('decrypt', $empleadoID);

        //Datos del Empleado
        $model = new PdfModel();
        $empleado = $model->getEmpleadoInfo($empleadoID);

        //Create Document
        $pdf = new Fpdi();
        $pdf->AddPage("P", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/kardex.pdf");
        $template = $pdf->importPage(1);
        $pdf->useTemplate($template, -1, 0, 220, 280);
        $pdf->SetFont('Arial', '', 11);

        //logo
        $logo = FCPATH . "/assets/images/thigo/1.png";
        $pdf->Image($logo, 50, 17, 15, 15);


        //DATOS DEL EMPLEADO
        //Fecha Actual
        $year = date('Y');
        $pdf->SetXY(125, 23);
        $pdf->Cell(28, 6, utf8_decode($year), 0, 0, 'C');

        //Fecha de ingreso
        $fechaIngreso =  longDate($empleado['emp_FechaIngreso'], " de ");
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetXY(153.5, 23.5);
        $pdf->MultiCell(28, 4, utf8_decode($fechaIngreso), 0, 'C');

        //Nombre Empleado
        $pdf->SetXY(79.5, 39);
        $pdf->MultiCell(57, 4, utf8_decode($empleado['emp_Nombre']), 0, 'L');

        //Fecha Nacimiento
        $fechaNacimiento =  longDate($empleado['emp_FechaNacimiento'], " de ");
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetXY(136.5, 39);
        $pdf->MultiCell(45, 4, utf8_decode($fechaNacimiento), 0, 'C');
        $pdf->SetFont('Arial', '', 10);

        //#empleado
        $pdf->SetXY(79.5, 54);
        $pdf->Cell(28.5, 4, utf8_decode($empleado['emp_Numero']), 0, 0, 'C');

        //Edad
        $edad = $year - $empleado['nacimiento'];
        $pdf->SetXY(108, 54);
        $pdf->Cell(22.5, 4, utf8_decode($edad), 0, 0, 'C');

        //Telefono
        $pdf->SetXY(130.5, 54);
        $pdf->Cell(51, 4, utf8_decode($empleado['emp_Telefono']), 0, 0, 'C');

        //Correo
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetXY(79.5, 67);
        $pdf->MultiCell(45.5, 4, utf8_decode($empleado['emp_Correo']), 0, 'C');

        //Departamento
        $pdf->SetXY(125, 65);
        $pdf->MultiCell(28.5, 3.5, utf8_decode($empleado['dep_Nombre']), 0, 'J');

        //Puesto
        $pdf->SetXY(153.5, 67);
        $pdf->MultiCell(28.5, 4, utf8_decode($empleado['pue_Nombre']), 0, 'C');

        //Foto

        $fotoPerfil = fotoPerfil(encryptDecrypt('encrypt', $empleadoID));
        $pdf->Image($fotoPerfil, 36, 32.9, 42, 42.8);
        $pdf->SetFont('Arial', '', 8);


        //Horario
        $queryHorario = "SELECT H.* FROM horario H JOIN empleado E on E.emp_HorarioID=H.hor_HorarioID WHERE E.emp_EmpleadoID=" . $empleadoID;
        $horario = $this->db->query($queryHorario)->getRowArray();

        //Checador
        $query = "SELECT YEAR(asi_Fecha) AS 'anio', MONTH(asi_Fecha) AS 'mes', DAY(asi_Fecha) AS 'dia', asi_Fecha, asi_Hora FROM asistencia WHERE YEAR(asi_Fecha)=" . date('Y') . " AND asi_EmpleadoID=" . $empleadoID;
        $checador = $this->db->query($query)->getResultArray();
        $asistencias = array();
        sort($checador);
        foreach ($checador as $ch) {
            $horas = json_decode($ch['asi_Hora']);
            if (!empty($horas)) {
                $horas = array_unique($horas);
                $data = array(
                    "dia" => $ch['asi_Fecha'],
                    "horaEntrada" => $horas[0],
                    "dia" => $ch['dia'],
                    "mes" => $ch['mes'],
                    "ano" => $ch['anio'],
                );
                array_push($asistencias, $data);
            } else {
                $data = array(
                    "dia" => $ch['asi_Fecha'],
                    "horaEntrada" => '00:00',
                    "dia" => $ch['dia'],
                    "mes" => $ch['mes'],
                    "ano" => $ch['anio'],
                );
                array_push($asistencias, $data);
            }
        }

        //Permisos
        $queryPermisos = "SELECT P.per_FechaInicio AS 'FechaIni', P.per_FechaFin AS 'FechaFin', per_TipoID
            FROM permiso P
            WHERE YEAR(P.per_FechaInicio)=" . DATE('Y') . " AND P.per_EmpleadoID=" . $empleadoID . " AND P.per_Estado = 'AUTORIZADO_RH'";
        $permisos = $this->db->query($queryPermisos)->getResultArray();

        //Dia inhabil
        $sql = "SELECT D.dia_Fecha AS 'fecha'
            FROM diainhabil D
            WHERE YEAR(D.dia_Fecha)=" . DATE('Y') . "
            UNION
            SELECT DI.dial_Fecha as 'fecha'
            FROM diainhabilley DI
            WHERE YEAR(DI.dial_Fecha)=" . DATE('Y');
        $inhabiles = $this->db->query($sql)->getResultArray();

        //Vacaciones inicio
        $sql = "SELECT V.vac_FechaInicio AS 'FechaIni', V.vac_FechaFin AS 'FechaFin'
            FROM vacacion V
            WHERE V.vac_EmpleadoID=? AND V.vac_Estatus='AUTORIZADO_RH' AND YEAR(V.vac_FechaInicio)=" . DATE('Y');
        $vacaciones = $this->db->query($sql, array($empleadoID))->getResultArray();

        //Incapacidad
        $sql = "SELECT I.inc_FechaInicio AS 'FechaIni', I.inc_FechaFin AS 'FechaFin'
            FROM incapacidad I
            WHERE I.inc_Estatus='Autorizada' AND I.inc_EmpleadoID=? AND YEAR(I.inc_FechaInicio)=" . DATE('Y');
        $incapacidades = $this->db->query($sql, array($empleadoID))->getResultArray();

        //Salidas
        $sql = "SELECT rep_Dias
        FROM reportesalida WHERE rep_EmpleadoID=? AND rep_Estado='APLICADO' AND YEAR(rep_DiaInicio)=" . DATE('Y');
        $salidas = $this->db->query($sql, array($empleadoID))->getResultArray();

        $reportesalidas = array();
        $i = 1;
        foreach ($salidas as $salida) {
            $presalidas = json_decode($salida['rep_Dias']);
            foreach ($presalidas as $presalida) {
                $reportesalidas[$i] = $presalida->fecha;
                $i++;
            }
        }


        $x = 23.02;
        $y = 85.8;

        for ($nMes = 1; $nMes < 13; $nMes++) {
            $nDia = 0;
            switch ($nMes) {
                case 2:
                    if (date("L")) $nDia = 29;
                    else $nDia = 28;
                    break;
                case 1:
                case 3:
                case 5:
                case 7:
                case 8:
                case 10:
                case 12:
                    $nDia = 31;
                    break;
                case 4:
                case 6:
                case 9:
                case 11:
                    $nDia = 30;
                    break;
            }

            for ($i = 1; $i <= $nDia; $i++) {
                $fecha = date('Y');
                if ($nMes < 10) $fecha .= '-0' . $nMes;
                else $fecha .= '-' . $nMes;
                if ($i < 10) $fecha .= '-0' . $i;
                else $fecha .= '-' . $i;

                $fechaEntera = strtotime($fecha);
                $nameDia = date("l", $fechaEntera);

                $count = count($asistencias) - 1;
                $n = 0;
                foreach ($asistencias as $asistencia) {
                    $diaNombre = get_nombre_dia($asistencia['ano'] . '-' . $asistencia['mes'] . '-' . $asistencia['dia']);
                    $tolerancia = "+" . $horario['hor_Tolerancia'] . " minutes";
                    switch ($diaNombre) {
                        case 'Lunes':
                            $horaTolerancia = strtotime($tolerancia, strtotime($horario['hor_LunesEntrada']));
                            $horaEntrada = date('h:i', $horaTolerancia);
                            break;
                        case 'Martes':
                            $horaTolerancia = strtotime($tolerancia, strtotime($horario['hor_MartesEntrada']));
                            $horaEntrada = date('h:i', $horaTolerancia);
                            break;
                        case 'Miercoles':
                            $horaTolerancia = strtotime($tolerancia, strtotime($horario['hor_MiercolesEntrada']));
                            $horaEntrada = date('h:i', $horaTolerancia);
                            break;
                        case 'Jueves':
                            $horaTolerancia = strtotime($tolerancia, strtotime($horario['hor_JuevesEntrada']));
                            $horaEntrada = date('h:i', $horaTolerancia);
                            break;
                        case 'Viernes':
                            $horaTolerancia = strtotime($tolerancia, strtotime($horario['hor_ViernesEntrada']));
                            $horaEntrada = date('h:i', $horaTolerancia);
                            break;
                        case 'Sabado':
                            $horaTolerancia = strtotime($tolerancia, strtotime($horario['hor_SabadoEntrada']));
                            $horaEntrada = date('h:i', $horaTolerancia);
                            break;
                        case 'Domingo':
                            $horaEntrada = 'Domingo';
                            break;
                    }
                    $pdf->SetXY($x + (5.675 * $asistencia['dia']), $y + (4.82 * $asistencia['mes']));
                    if ($asistencia['horaEntrada'] !== '00:00') {
                        if ($horaEntrada >= $asistencia['horaEntrada']) {
                            $pdf->SetFillColor(29, 154, 221);
                            $pdf->Cell(5.4, 4.4, '*', 0, 0, 'C', true);
                        } else {
                            $pdf->SetFillColor(255, 111, 97);
                            $pdf->Cell(5.4, 4.4, 'R', 0, 0, 'C', true);
                        }
                    } else {
                        $pdf->SetFillColor(234, 21, 21);
                        $pdf->Cell(5.4, 4.4, '/', 0, 0, 'C', true);
                    }
                    if ($n <= $count) {
                        unset($asistencias[$n]);
                        $n++;
                    }
                }

                //DIA INHABIL
                foreach ($inhabiles as $inhabil) {
                    if (in_array($fecha, $inhabil)) {
                        $pdf->SetFillColor(233, 113, 23);
                        $pdf->SetXY($x + (5.675 * $i), $y + (4.82 * $nMes));
                        $pdf->Cell(5.4, 4.4, 'DI', 0, 0, 'C', true);
                    }
                }

                //VACACIONES
                foreach ($vacaciones as $vacacion) {
                    if (in_array($fecha, $vacacion)) {
                        $pdf->SetFillColor(255, 217, 102);
                        $pdf->SetXY($x + (5.675 * $i), $y + (4.82 * $nMes));
                        $pdf->Cell(5.4, 4.4, 'V', 0, 0, 'C', true);
                        if ($vacacion['FechaIni'] != $vacacion['FechaFin']) {
                            $Arr = array(
                                'FechaIni' => date("Y-m-d", strtotime($vacacion['FechaIni'] . "+ 1 day")),
                                'FechaFin' => $vacacion['FechaFin']
                            );
                            array_push($vacaciones, $Arr);
                        }
                    }
                }

                //PERMISO
                foreach ($permisos as $permiso) {
                    if (in_array($fecha, $permiso)) {
                        if ($permiso['per_TipoID'] == 6) {
                            $pdf->SetFillColor(156, 231, 122);
                        } else {
                            $pdf->SetFillColor(142, 124, 195);
                        }
                        $pdf->SetXY($x + (5.675 * $i), $y + (4.82 * $nMes));
                        $pdf->Cell(5.4, 4.4, 'P', 0, 0, 'C', true);

                        if ($permiso['FechaIni'] != $permiso['FechaFin']) {
                            $Arr = array(
                                'FechaIni' => date("Y-m-d", strtotime($permiso['FechaIni'] . "+ 1 day")),
                                'FechaFin' => $permiso['FechaFin'],
                                'per_TipoID' => $permiso['per_TipoID']
                            );
                            array_push($permisos, $Arr);
                        }
                    }
                }

                //INCAPACIDAD
                foreach ($incapacidades as $incapacidad) {
                    if (in_array($fecha, $incapacidad)) {
                        $pdf->SetFillColor(213, 166, 189);
                        $pdf->SetXY($x + (5.675 * $i), $y + (4.82 * $nMes));
                        $pdf->Cell(5.4, 4.4, 'IN', 0, 0, 'C', true);
                        if ($incapacidad['FechaIni'] != $incapacidad['FechaFin']) {
                            $Arr = array(
                                'FechaIni' => date("Y-m-d", strtotime($incapacidad['FechaIni'] . "+ 1 day")),
                                'FechaFin' => $incapacidad['FechaFin']
                            );
                            array_push($incapacidades, $Arr);
                        }
                    }
                }

                //SALIDAS
                foreach ($reportesalidas as $reportesalida) {
                    if ($fecha === $reportesalida) {
                        $pdf->SetFillColor(89, 195, 195);
                        $pdf->SetXY($x + (5.675 * $i), $y + (4.82 * $nMes));
                        $pdf->Cell(5.4, 4.4, 'S', 0, 0, 'C', true);
                    }
                }

                //FINES DE SEMANA
                $pdf->SetFillColor(128, 128, 128);
                if ($nameDia == 'Sunday') {
                    $pdf->SetXY($x + (5.675 * $i), $y + (4.82 * $nMes));
                    $pdf->Cell(5.4, 4.4, 'D', 0, 0, 'C', true);
                }
            }
        }

        //Notacion
        $pdf->SetFillColor(36, 64, 97);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetDrawColor(16, 121, 196);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetXY(40, 155);
        $pdf->Cell(136, 5, utf8_decode('Notación'), 1, 0, 'C', true);

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetXY(40, 160);
        $pdf->SetFillColor(29, 154, 221);
        $pdf->Cell(13, 5, utf8_decode('*'), 1, 0, 'C', true);
        $pdf->SetFillColor(255);
        $pdf->Cell(55, 5, utf8_decode('Asistencia'), 1, 0, 'C', true);
        $pdf->SetFillColor(142, 124, 195);
        $pdf->Cell(13, 5, utf8_decode('P'), 1, 0, 'C', true);
        $pdf->SetFillColor(255);
        $pdf->Cell(55, 5, utf8_decode('Permisos'), 1, 0, 'C', true);

        $pdf->SetXY(40, 165);
        $pdf->SetFillColor(234, 21, 21);
        $pdf->Cell(13, 5, utf8_decode('/'), 1, 0, 'C', true);
        $pdf->SetFillColor(255);
        $pdf->Cell(55, 5, utf8_decode('Falta'), 1, 0, 'C', true);
        /*$pdf->SetFillColor(156, 231, 122);
        $pdf->Cell(13, 5, utf8_decode('P'), 1, 0, 'C', true);
        $pdf->SetFillColor(255);
        $pdf->Cell(55, 5, utf8_decode('Permisos (por horas)'), 1, 0, 'C', true);*/
        $pdf->SetFillColor(128, 128, 128);
        $pdf->Cell(13, 5, utf8_decode('D'), 1, 0, 'C', true);
        $pdf->SetFillColor(255);
        $pdf->Cell(55, 5, utf8_decode('Domingo'), 1, 0, 'C', true);

        $pdf->SetXY(40, 170);
        $pdf->SetFillColor(255, 111, 97);
        $pdf->Cell(13, 5, utf8_decode('R'), 1, 0, 'C', true);
        $pdf->SetFillColor(255);
        $pdf->Cell(55, 5, utf8_decode('Retardo'), 1, 0, 'C', true);
        $pdf->SetFillColor(233, 113, 23);
        $pdf->Cell(13, 5, utf8_decode('DI'), 1, 0, 'C', true);
        $pdf->SetFillColor(255);
        $pdf->Cell(55, 5, utf8_decode('Día inhábil'), 1, 0, 'C', true);

        $pdf->SetXY(40, 175);
        $pdf->SetFillColor(255, 217, 102);
        $pdf->Cell(13, 5, utf8_decode('V'), 1, 0, 'C', true);
        $pdf->SetFillColor(255);
        $pdf->Cell(55, 5, utf8_decode('Vacaciones'), 1, 0, 'C', true);
        $pdf->SetFillColor(213, 166, 189);
        $pdf->Cell(13, 5, utf8_decode('IN'), 1, 0, 'C', true);
        $pdf->SetFillColor(255);
        $pdf->Cell(55, 5, utf8_decode('Incapacidad'), 1, 0, 'C', true);

        $pdf->SetXY(40, 180);
        $pdf->SetFillColor(89, 195, 195);
        //$pdf->Cell(13, 5, utf8_decode('S'), 1, 0, 'C', true);
        $pdf->SetFillColor(255);
        //$pdf->Cell(55, 5, utf8_decode('Salida'), 1, 0, 'C', true);



        $diasLey = diasLey($empleado['emp_FechaIngreso']);
        $diasRestantes = diasPendientes($empleadoID);
        //$diasOcupados = $diasLey - $diasRestantes;
        $empleadoFI = db()->query("SELECT emp_FechaIngreso FROM empleado WHERE emp_EmpleadoID=" . session('id'))->getRowArray();
        $diasOcupados = diasOcupados(session('id'), $empleadoFI['emp_FechaIngreso']);

        //Info vacaciones
        $pdf->SetFillColor(36, 64, 97);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetDrawColor(16, 121, 196);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetXY(40, 195);
        $pdf->Cell(136, 5, utf8_decode('Vacaciones'), 1, 0, 'C', true);

        $pdf->SetFillColor(255);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetXY(40, 200);
        $pdf->Cell(45.3, 5, $diasLey . utf8_decode(' días correspondientes'), 1, 0, 'C', true);
        $pdf->Cell(45.3, 5, $diasRestantes . utf8_decode(' días restantes'), 1, 0, 'C', true);
        $pdf->Cell(45.3, 5, $diasOcupados . utf8_decode(' días tomados'), 1, 0, 'C', true);

        //Output
        $pdf->output('I', 'Kardex#' . $empleado['emp_EmpleadoID'] . '.pdf');
        exit();
    } // end reporteIncidencias


    private function setEncuestaGITableOption($estatus, $pdf, $y)
    {
        $posiciones = array("SI" => 173, "NO" => 188);

        if ($estatus != '') {
            $x = $posiciones[$estatus];
            $pdf->SetXY($x, $y);
            $pdf->Cell(5, 4, 'x', 0, 0, 'C');
        } //if estatus

    }

    //Lia->evaluaciones guia 1
    public function evaluacionesGuiaI($fI, $fF, $sucursal)
    {
        //Evaluaciones
        $model = new PdfModel();
        $evaluaciones = $model->getEvaluacionesGuia1($fI, $fF, $sucursal);

        $pdf = new Fpdi();
        foreach ($evaluaciones as $evaluacion) {

            /*Pagina 1*/
            $pdf->AddPage("P", "Letter");
            $pdf->setSourceFile(FCPATH . "/assets/formatos/cuestionarioGuia1.pdf");
            $template = $pdf->importPage(1);
            $pdf->useTemplate($template, -1, 0, 220, 280);
            $pdf->SetFont('Arial', 'B', 12);

            // Acontecimiento traumático severo
            $this->setEncuestaGITableOption($evaluacion['eva_ATS'], $pdf, 120.2);

            // Recuerdos persistentes sobre el acontecimiento
            $this->setEncuestaGITableOption($evaluacion['eva_Recuerdos1'], $pdf, 180.2);
            $this->setEncuestaGITableOption($evaluacion['eva_Recuerdos2'], $pdf, 190.2);

            //Esfuerzo por evitar circunstancias parecidas o asociadas al acontecimiento
            $this->setEncuestaGITableOption($evaluacion['eva_Esfuerzo1'], $pdf, 226.2);
            $this->setEncuestaGITableOption($evaluacion['eva_Esfuerzo2'], $pdf, 236.2);


            /*Pagina 2*/
            $pdf->AddPage("P", "Letter");
            $pdf->setSourceFile(FCPATH . "/assets/formatos/cuestionarioGuia1.pdf");
            $template = $pdf->importPage(2);
            $pdf->useTemplate($template, -1, 0, 220, 280);
            $pdf->SetFont('Arial', 'B', 12);

            //Esfuerzo por evitar circunstancias parecidas o asociadas al acontecimiento
            $this->setEncuestaGITableOption($evaluacion['eva_Esfuerzo3'], $pdf, 35.2);
            $this->setEncuestaGITableOption($evaluacion['eva_Esfuerzo4'], $pdf, 45.2);
            $this->setEncuestaGITableOption($evaluacion['eva_Esfuerzo5'], $pdf, 55.2);
            $this->setEncuestaGITableOption($evaluacion['eva_Esfuerzo6'], $pdf, 65.2);
            $this->setEncuestaGITableOption($evaluacion['eva_Esfuerzo7'], $pdf, 75.2);

            //Afectación
            $this->setEncuestaGITableOption($evaluacion['eva_Afectacion1'], $pdf, 117.2);
            $this->setEncuestaGITableOption($evaluacion['eva_Afectacion2'], $pdf, 127.2);
            $this->setEncuestaGITableOption($evaluacion['eva_Afectacion3'], $pdf, 137.2);
            $this->setEncuestaGITableOption($evaluacion['eva_Afectacion4'], $pdf, 147.2);
            $this->setEncuestaGITableOption($evaluacion['eva_Afectacion5'], $pdf, 157.2);

            //Evaluado
            $pdf->SetXY(85, 191.5);
            $pdf->Cell(110, 4, utf8_decode($evaluacion['emp_Nombre']), 0, 0, 'C');
        }
        //Output
        $pdf->output('I', 'EvaluacionesGuia1.pdf');
        exit();
    }


    //Lia->evaluaciones guia 2
    public function evaluacionesGuiaII($fI, $fF, $sucursal = null)
    {

        //Evaluaciones
        $model = new PdfModel();
        $sucursal = encryptDecrypt('decrypt', $sucursal);
        $evaluaciones = $model->getEvaluacionesGuia2($fI, $fF, $sucursal);

        $pdf = new Fpdi();
        foreach ($evaluaciones as $evaluacion) {

            /*Pagina 1*/
            $pdf->AddPage("P", "Letter");
            $pdf->setSourceFile(FCPATH . "/assets/formatos/cuestionarioGuia2.pdf");
            $template = $pdf->importPage(1);
            $pdf->useTemplate($template, -1, 0, 220, 280);
            $pdf->SetFont('Arial', 'B', 12);

            //A)
            $this->setEncuestaG2F2TableOption($evaluacion['eva_P1'], $pdf, 107.2);
            $this->setEncuestaG2F2TableOption($evaluacion['eva_P2'], $pdf, 116.2);
            $this->setEncuestaG2F2TableOption($evaluacion['eva_P3'], $pdf, 125.2);
            $this->setEncuestaG2F2TableOption($evaluacion['eva_P4'], $pdf, 135.2);
            $this->setEncuestaG2F2TableOption($evaluacion['eva_P5'], $pdf, 144.2);
            $this->setEncuestaG2F2TableOption($evaluacion['eva_P6'], $pdf, 153.2);
            $this->setEncuestaG2F2TableOption($evaluacion['eva_P7'], $pdf, 161.2);
            $this->setEncuestaG2F2TableOption($evaluacion['eva_P8'], $pdf, 168.2);
            $this->setEncuestaG2F2TableOption($evaluacion['eva_P9'], $pdf, 178.2);

            //B)
            $this->setEncuestaG2F2TableOption($evaluacion['eva_P10'], $pdf, 210.2);
            $this->setEncuestaG2F2TableOption($evaluacion['eva_P11'], $pdf, 220.2);
            $this->setEncuestaG2F2TableOption($evaluacion['eva_P12'], $pdf, 227.2);
            $this->setEncuestaG2F2TableOption($evaluacion['eva_P13'], $pdf, 235.2);

            /*Pagina 2*/
            $pdf->AddPage("P", "Letter");
            $pdf->setSourceFile(FCPATH . "/assets/formatos/cuestionarioGuia2.pdf");
            $template = $pdf->importPage(2);
            $pdf->useTemplate($template, -1, 0, 220, 280);
            $pdf->SetFont('Arial', 'B', 12);

            //C)
            $this->setEncuestaG2F2TableOption($evaluacion['eva_P14'], $pdf, 52.2);
            $this->setEncuestaG2F2TableOption($evaluacion['eva_P15'], $pdf, 62.2);
            $this->setEncuestaG2F2TableOption($evaluacion['eva_P16'], $pdf, 72.2);
            $this->setEncuestaG2F2TableOption($evaluacion['eva_P17'], $pdf, 82.2);

            // D)
            $this->setEncuestaG2F1TableOption($evaluacion['eva_P18'], $pdf, 122.2);
            $this->setEncuestaG2F1TableOption($evaluacion['eva_P19'], $pdf, 129.2);
            $this->setEncuestaG2F1TableOption($evaluacion['eva_P20'], $pdf, 137.2);
            $this->setEncuestaG2F1TableOption($evaluacion['eva_P21'], $pdf, 147.2);
            $this->setEncuestaG2F1TableOption($evaluacion['eva_P22'], $pdf, 157.2);

            // E)
            $this->setEncuestaG2F1TableOption($evaluacion['eva_P23'], $pdf, 195.2);
            $this->setEncuestaG2F1TableOption($evaluacion['eva_P24'], $pdf, 203.2);
            $this->setEncuestaG2F1TableOption($evaluacion['eva_P25'], $pdf, 213.2);
            $this->setEncuestaG2F1TableOption($evaluacion['eva_P26'], $pdf, 223.2);
            $this->setEncuestaG2F1TableOption($evaluacion['eva_P27'], $pdf, 230.2);


            /*Pagina 3*/
            $pdf->AddPage("P", "Letter");
            $pdf->setSourceFile(FCPATH . "/assets/formatos/cuestionarioGuia2.pdf");
            $template = $pdf->importPage(3);
            $pdf->useTemplate($template, -1, 0, 220, 280);
            $pdf->SetFont('Arial', 'B', 12);

            // F)
            $this->setEncuestaG2F1TableOption($evaluacion['eva_P28'], $pdf, 52.2);
            $this->setEncuestaG2F1TableOption($evaluacion['eva_P29'], $pdf, 62.2);
            $this->setEncuestaG2F1TableOption($evaluacion['eva_P30'], $pdf, 70.2);
            $this->setEncuestaG2F1TableOption($evaluacion['eva_P31'], $pdf, 78.2);
            $this->setEncuestaG2F1TableOption($evaluacion['eva_P32'], $pdf, 87.2);
            $this->setEncuestaG2F1TableOption($evaluacion['eva_P33'], $pdf, 97.2);

            $this->setEncuestaG2F2TableOption($evaluacion['eva_P34'], $pdf, 106.2);
            $this->setEncuestaG2F2TableOption($evaluacion['eva_P35'], $pdf, 116.2);
            $this->setEncuestaG2F2TableOption($evaluacion['eva_P36'], $pdf, 125.2);
            $this->setEncuestaG2F2TableOption($evaluacion['eva_P37'], $pdf, 134.2);
            $this->setEncuestaG2F2TableOption($evaluacion['eva_P38'], $pdf, 143.2);
            $this->setEncuestaG2F2TableOption($evaluacion['eva_P39'], $pdf, 155.2);
            $this->setEncuestaG2F2TableOption($evaluacion['eva_P40'], $pdf, 166.2);

            //Clientes
            if ($evaluacion['eva_Clientes'] === 'SI') {
                $pdf->SetXY(165, 184);
                $pdf->Cell(3, 4, 'x', 0, 0, 'C');
            } else if ($evaluacion['eva_Clientes'] === 'NO') {
                $pdf->SetXY(165, 189);
                $pdf->Cell(3, 4, 'x', 0, 0, 'C');
            }

            // G)
            $this->setEncuestaG2F2TableOption($evaluacion['eva_P41'], $pdf, 218.2);
            $this->setEncuestaG2F2TableOption($evaluacion['eva_P42'], $pdf, 226.2);
            $this->setEncuestaG2F2TableOption($evaluacion['eva_P43'], $pdf, 236.2);

            /*Pagina 4*/
            $pdf->AddPage("P", "Letter");
            $pdf->setSourceFile(FCPATH . "/assets/formatos/cuestionarioGuia2.pdf");
            $template = $pdf->importPage(4);
            $pdf->useTemplate($template, -1, 0, 220, 280);
            $pdf->SetFont('Arial', 'B', 12);

            //Jefe
            if ($evaluacion['eva_Jefe'] === 'SI') {
                $pdf->SetXY(165, 36);
                $pdf->Cell(3, 4, 'x', 0, 0, 'C');
            } else if ($evaluacion['eva_Jefe'] === 'NO') {
                $pdf->SetXY(165, 42);
                $pdf->Cell(3, 4, 'x', 0, 0, 'C');
            }

            // H)
            $this->setEncuestaG2F2TableOption($evaluacion['eva_P41'], $pdf, 90.2);
            $this->setEncuestaG2F2TableOption($evaluacion['eva_P42'], $pdf, 96.2);
            $this->setEncuestaG2F2TableOption($evaluacion['eva_P43'], $pdf, 101.2);

            $pdf->SetFont('Arial', '', 10);

            //Fecha
            $pdf->SetXY(85, 127.5);
            $pdf->Cell(110, 4, utf8_decode($evaluacion['eva_Fecha']), 0, 0, 'C');

            //Centro de trabajo
            $pdf->SetXY(73, 138.5);
            $pdf->Cell(110, 4, utf8_decode(getSetting('nombre_empresa', $this)), 0, 0, 'C');

            $empleado = $this->db->query("SELECT emp_Sexo,emp_FechaNacimiento,YEAR(emp_FechaNacimiento) as 'edad' FROM empleado WHERE emp_EmpleadoID=" . $evaluacion['eva_EvaluadoID'])->getRowArray();
            if ($empleado['emp_Sexo'] === 'Femenino') {
                $pdf->SetXY(99, 149);
                $pdf->Cell(3, 4, 'X', 0, 0, 'C');
            } else if ($empleado['emp_Sexo'] === 'Masculino') {
                $pdf->SetXY(68, 149);
                $pdf->Cell(3, 4, 'X', 0, 0, 'C');
            }
            $edad = date('Y') - $empleado['edad'];
            if ($empleado['emp_FechaNacimiento'] < date('Y-m-d')) {
                $edad = $edad - 1;
            }
            if ($edad > 2000)
                $edad = '';

            //Edad
            $pdf->SetXY(130, 149);
            $pdf->Cell(20, 4, utf8_decode($edad), 0, 0, 'C');
        }

        //Output
        $pdf->output('I', 'EvaluacionesGuia2.pdf');
        exit();
    }


    private function setEncuestaG2F2TableOption($estatus, $pdf, $y)
    {
        $posiciones = array(
            0 => 179.7,
            1 => 166.65,
            2 => 152.7,
            3 => 136.5,
            4 => 120.7,
        );

        if ($estatus != '') {
            $x = $posiciones[$estatus];
            $pdf->SetXY($x, $y);
            $pdf->Cell(5, 4, 'x', 0, 0, 'C');
        } //if estatus
    }

    private function setEncuestaG2F1TableOption($estatus, $pdf, $y)
    {
        $posiciones = array(
            0 => 120.7,
            1 => 136.5,
            2 => 152.7,
            3 => 166.65,
            4 => 179.7,
        );

        if ($estatus != '') {
            $x = $posiciones[$estatus];
            $pdf->SetXY($x, $y);
            $pdf->Cell(5, 4, 'x', 0, 0, 'C');
        } //if estatus
    }

    //Lia->imprime los resultados globales de la eva de dep
    public function resultadosDepGlobales($inicio, $fin)
    {

        $model = new PdfModel();
        $departamentos = $model->traerDepartamentos();
        //$departamentosExcluidos= array(37,38,39,41,42,44,45,46,47,48,49,50,51,53,54,55,56);
        $totalPromedio = 0;
        $count = 1;
        foreach ($departamentos as $departamento) {
            //if (in_array($departamento['dep_DepartamentoID'], $departamentosExcluidos)) {
            $calificacion = $this->db->query("SELECT SUM(eva_Efectividad) AS 'efectividad', SUM(eva_Disponibilidad) AS 'disponibilidad',SUM(eva_Comunicacion) AS 'comunicacion',
                                               SUM(eva_Actitud) AS 'actitud', eva_DepartamentoID
                                          FROM evaluaciondepartamento WHERE eva_DepartamentoID=" . $departamento['dep_DepartamentoID'] . " AND eva_Fecha BETWEEN '" . $inicio . "' AND '" . $fin . "'")->getRowArray();

            if (!is_null($calificacion)) {
                $suma = $calificacion['efectividad'] + $calificacion['disponibilidad'] +
                    $calificacion['comunicacion'] + $calificacion['actitud'];
                $total = ($suma * 20) / 100;

                $totalPromedio += $total / $count;
                $count++;
            }
            //}
        }

        $pdf = new Fpdi();
        $pdf->AddPage("P", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/globalDep.pdf");
        $template = $pdf->importPage(1);
        $pdf->useTemplate($template, -1, 0, 220, 280);

        $pdf->SetFont('Arial', '', 10);

        $logo = FCPATH . "/assets/images/LOGO_AMA.png";
        $pdf->Image($logo, 16, 16, 45, 45);


        //Fecha
        $pdf->SetXY(151, 55.5);
        $pdf->Cell(25, 4, date('Y-m-d'), 0, 0, 'J');

        //Numero de pagina
        $pdf->SetXY(151, 61);
        $pdf->Cell(5, 3.5, $pdf->PageNo() . ' de {nb}', 0, 0, 'J');
        $pdf->AliasNbPages();

        $pdf->SetFont('Arial', 'B', 12);
        //Nombre de la empresa
        $empresaNombre = getSetting('nombre_empresa', $this);
        $pdf->SetXY(85, 50);
        $pdf->Cell(65, 4, utf8_decode($empresaNombre), 0, 0, 'J');

        $url1 = FCPATH . "/assets/uploads/resultados/GlobalDepartamentos.png";

        //Promedio
        $pdf->SetXY(90, 70);
        $pdf->Cell(25, 4, 'Promedio ' . number_format($totalPromedio, 2, '.', ','), 0, 0, 'J');

        $pdf->SetXY(10, 80);
        if (file_exists($url1)) $pdf->Cell(90, 80, $pdf->Image($url1, $pdf->GetX(), $pdf->GetY(), 190, 100), 0, 0, 'C', false);

        //Output
        $pdf->output('I', 'resultadosDepGlobal.pdf');
        exit();
    }


    //Lia->Imprime los resultados de la evaluacion de departamentos
    public function reporteClimaLaboral($inicio, $fin, $sucursal = null)
    {
        //Comentarios de la evaluacion
        $model = new PdfModel();
        //$comentarios = $model->comentariosEvaluacionClimaLaboral($inicio, $fin,$sucursal);
        $comentarios = $model->comentariosEvaluacionClimaLaboral($inicio, $fin, $sucursal);
        $sucursalNombre = null;
        if ($sucursal != '0') {
            $sucursalNombre = db()->query("SELECT suc_Sucursal FROM sucursal WHERE suc_SucursalID=?", array(encryptDecrypt('decrypt', $sucursal)))->getRowArray()['suc_Sucursal'];
        }

        $pdf = new Fpdi();
        $pdf->AddPage("P", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/clima.pdf");
        $template = $pdf->importPage(1);
        $pdf->useTemplate($template, -1, 0, 220, 280);

        $pdf->SetFont('Arial', '', 10);

        $logo = FCPATH . "/assets/images/LOGO_AMA.png";

        $pdf->Image($logo, 16, 30, 40, 20.8);


        //Fecha
        $pdf->SetXY(151, 58.5);
        $pdf->Cell(25, 4, date('Y-m-d'), 0, 0, 'J');

        //Numero de pagina
        $pdf->SetXY(151, 64.5);
        $pdf->Cell(5, 3.5, $pdf->PageNo() . ' de {nb}', 0, 0, 'J');
        $pdf->AliasNbPages();

        $pdf->SetFont('Arial', 'B', 12);
        //Nombre de la empresa
        $empresaNombre = 'Alianza Cajas Populares Sahuayo';
        if ($sucursalNombre) {
            $empresaNombre .= '(Sucursal ' . $sucursalNombre . ')';
        }
        $pdf->SetXY(80, 50);
        $pdf->Cell(65, 4, utf8_decode($empresaNombre), 0, 0, 'J');

        $url1 = FCPATH . "/assets/uploads/resultados/ClimaLaboral/ClimaLaboral.png";

        //Clima Laboral
        $pdf->SetXY(14, 130);
        if (file_exists($url1)) $pdf->Cell(60, 50, $pdf->Image($url1, $pdf->GetX(), $pdf->GetY(), 180, 90), 0, 0, 'C', false);

        $pdf->AddPage("P", "Letter");

        $pdf->SetFont('Arial', '', 10);

        $pdf->Image($logo, 16, 16, 40, 20.8);

        //Fecha
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetXY(138, 23);
        $pdf->Cell(25, 4, 'Fecha:', 0, 0, 'J');
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetXY(151, 23);
        $pdf->Cell(25, 4, date('Y-m-d'), 0, 0, 'J');

        //Numero de pagina
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetXY(138, 28);
        $pdf->Cell(5, 3.5, utf8_decode('Página:'), 0, 0, 'J');
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetXY(151, 28);
        $pdf->Cell(5, 3.5, $pdf->PageNo() . ' de {nb}', 0, 0, 'J');
        $pdf->AliasNbPages();

        $pdf->SetFont('Arial', 'B', 12);

        //Titulo
        $pdf->SetXY(70, 38);
        $pdf->Cell(65, 4, utf8_decode('COMENTARIOS Y SUGERENCIAS'), 0, 0, 'C');
        $pdf->SetXY(10, 50);
        $this->BasicTableComentariosClima($comentarios, $pdf);

        //Output
        $pdf->output('I', 'resultadosClimaLaboral.pdf');
        exit();
    }

    function BasicTableComentariosClima($data, $pdf)
    {
        // Data
        $pdf->SetFont('Arial', '', 10);
        foreach ($data as $row) {
            foreach ($row as $col)
                $pdf->MultiCell(190, 5,  utf8_decode($col), 0, 'J');
            $pdf->Ln();
        }
    }



    public function imprimirSolicitudPrestamoFondoAhorro($prestamoID)
    {

        $model = new PdfModel();
        $solicitud = $model->getSolicitudPrestamoFondoByID($prestamoID);
        $planPago = $model->getPlanPagoPrestamoFondo($solicitud['pre_Monto'], $solicitud['pre_Abonos'], $solicitud['pre_Amortizacion']);
        $totales = $model->getTotalesPrestamoFondo($solicitud['pre_Monto'], $solicitud['pre_Abonos'], $solicitud['pre_Amortizacion']);


        $pdf = new Fpdi();
        $pdf->AddPage("P", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/solicitud-fondo-ahorro.pdf");
        $template = $pdf->importPage(1);
        $pdf->useTemplate($template, -1, 0, 220, 280);

        $pdf->SetFont('Arial', 'B', 12);

        //Folio
        $pdf->SetXY(169, 37.5);
        $pdf->Cell(25, 4, $solicitud['pre_Folio'], 0, 0, 'J');

        //Deudor
        $pdf->SetXY(48, 55.8);
        $pdf->Cell(120, 4, $solicitud['emp_Nombre'], 0, 0, 'J');

        //Colaborador
        $pdf->SetXY(30, 95);
        $pdf->Cell(160, 4, utf8_decode($solicitud['emp_Nombre']), 0, 0, 'C');


        $pdf->SetXY(30, 119.5);
        $pdf->Cell(160, 4, utf8_decode(strtoupper('$' . number_format($solicitud['pre_Monto'], 2, '.', ',') . ' ' . num_letras($solicitud['pre_Monto'], 'MNX'))), 0, 0, 'C');

        //Plan de pago

        $pdf->AddPage("P", "Letter");
        $pdf->SetFont('Arial', 'B', 10);

        $pdf->SetXY(10, 15);
        $pdf->MultiCell(195, 5, 'PLAN DE PAGOS', 0, 'C');

        $pdf->SetXY(10, 30);
        $pdf->MultiCell(100, 5, 'Saldo Inicial   ' . '$' . number_format($solicitud['pre_Monto'], 2, '.', ','), 1, 'J');
        $pdf->SetXY(10, 35);
        $pdf->MultiCell(100, 5, 'Fecha Inicial   ' . $solicitud['pre_Fecha'], 1, 'J');
        $pdf->SetXY(10, 40);
        $pdf->MultiCell(100, 5, 'Tasa Anual     6.00%', 1, 'J');
        $pdf->SetXY(10, 45);
        $pdf->MultiCell(195, 5, 'Pagos quincenales  ' . '$' . number_format($solicitud['pre_Amortizacion'], 2, '.', ','), 1, 'C');

        $header = array('Abonos', 'Fecha', 'Amortización', 'Interes', 'Saldo', 'Abono');
        $footer = array('', 'Préstamo cubierto ', $totales['totalPrestamo'], $totales['totalInteres'], '', $totales['totalAbono']);
        $pdf->SetFont('Arial', '', 10);
        $this->BasicTablePlanPagoFondo($header, $planPago, $pdf, $footer);

        // Hoja 3
        $pdf->AddPage("P", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/solicitud-fondo-ahorro.pdf");
        $template = $pdf->importPage(2);
        $pdf->useTemplate($template, -1, 0, 220, 280);

        $pdf->SetFont('Arial', 'B', 11.5);

        //Fecha de solicitud
        $pdf->SetXY(92, 139.5);
        $pdf->MultiCell(50, 5, longDate($solicitud['pre_Fecha'], ' de '), 0, 'C');

        $pdf->SetFont('Arial', 'B', 12);
        //Firma empleado
        $pdf->SetXY(30, 210);
        $pdf->MultiCell(60, 5, utf8_decode($solicitud['emp_Nombre']), 0, 'C');

        //Output
        $pdf->output('I', 'Solicitud-Fondo-Ahorro.pdf');
        exit();
    }

    function BasicTablePlanPagoFondo($header, $data, $pdf, $footer)
    {
        // Header
        $pdf->SetFont('Arial', 'B', 10);
        foreach ($header as $col)
            $pdf->Cell(32.5, 5, utf8_decode($col), 1);
        $pdf->Ln();
        // Data
        $pdf->SetFont('Arial', '', 10);
        foreach ($data as $row) {
            foreach ($row as $col)
                $pdf->Cell(32.5, 5, $col, 1);
            $pdf->Ln();
        }
        //footer
        $pdf->SetFont('Arial', 'B', 10);
        foreach ($footer as $col)
            $pdf->Cell(32.5, 10, utf8_decode($col), 1);
        $pdf->Ln();
    }


    public function imprimirPagarePrestamoFondo($prestamoID)
    {

        $model = new PdfModel();
        $solicitud = $model->getSolicitudPrestamoFondoByID($prestamoID);
        $planPago = $model->getPlanPagoPrestamoFondo($solicitud['pre_Monto'], $solicitud['pre_Abonos'], $solicitud['pre_Amortizacion']);
        $totales = $model->getTotalesPrestamoFondo($solicitud['pre_Monto'], $solicitud['pre_Abonos'], $solicitud['pre_Amortizacion']);



        $pdf = new Fpdi();
        $pdf->AddPage("P", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/pagareFondo.pdf");
        $template = $pdf->importPage(1);
        $pdf->useTemplate($template, -1, 0, 220, 280);

        $pdf->SetFont('Arial', '', 9.5);

        //Fecha
        $pdf->SetXY(164, 22.3);
        $pdf->Cell(25, 4, utf8_decode(longDate($solicitud['pre_Fecha'], ' de ')), 0, 0, 'J');

        //Cantidad
        $pdf->SetXY(32, 39.5);
        $pdf->Cell(120, 4, utf8_decode(strtoupper('$' . number_format($solicitud['pre_Monto'], 2, '.', ','))), 0, 0, 'J');

        //Vence
        $pdf->SetXY(24, 56.5);
        $pdf->Cell(20, 4, utf8_decode(longDate($totales['quincena'], ' de ')), 0, 0, 'J');

        //Firma empleado
        $pdf->SetXY(13, 60.8);
        $pdf->MultiCell(60, 5, utf8_decode($solicitud['emp_Nombre']), 0, 'J');

        //Datos colaborador
        $pdf->SetXY(13, 66);
        $pdf->MultiCell(70, 5, utf8_decode($solicitud['emp_Direccion'] . ' ' . $solicitud['emp_Municipio'] . ', ' . $solicitud['emp_EntidadFederativa']), 0, 'J');

        //Cantidad
        $pdf->SetXY(13, 90);
        $pdf->Cell(193, 4, utf8_decode(strtoupper('$' . number_format($solicitud['pre_Monto'], 2, '.', ',') . ' ' . num_letras($solicitud['pre_Monto'], 'MNX'))), 0, 0, 'J');


        //Fecha
        $pdf->SetXY(36, 100.7);
        $pdf->Cell(25, 4, utf8_decode(longDate($totales['quincena'], ' de ')), 0, 0, 'J');

        //Abonos
        $pdf->SetXY(147.5, 122);
        $pdf->Cell(5, 4, $totales['abonos'], 0, 0, 'C');

        //Firma empleado
        $pdf->SetXY(35, 150);
        $pdf->MultiCell(60, 5, utf8_decode($solicitud['emp_Nombre']), 0, 'C');

        //Datos colaborador
        $pdf->SetXY(30, 165);
        $pdf->MultiCell(70, 5, utf8_decode($solicitud['emp_Direccion'] . ' ' . $solicitud['emp_Municipio'] . ', ' . $solicitud['emp_EntidadFederativa']), 0, 'J');

        //Output
        $pdf->output('I', 'Solicitud-Fondo-Ahorro.pdf');
        exit();
    }


    //Lia->Imprimir la lista de asistencia de una capacitacion por fecha
    public function imprimrlistaAsistencia($idCapacitacion, $fecha)
    {
        $idCapacitacion = (int)$idCapacitacion;

        if (empty($idCapacitacion)) {
            exit();
        } //if

        //Capacitacion
        $model = new FormacionModel();
        $capacitacion = $model->getCapacitacionInfo($idCapacitacion);
        //var_dump($capacitacion);exit();

        $instructor = $this->db->query("SELECT I.*, E.emp_Nombre FROM instructor I
                                        JOIN empleado E ON E.emp_EmpleadoID=I.ins_EmpleadoID
                                        WHERE ins_InstructorID=" . $capacitacion['cap_InstructorID'])->getRowArray();

        if ($capacitacion["cap_Tipo"] == 'INTERNO') {
            $imparte = $instructor['emp_Nombre'];
        } else {
            $proveedor = $this->db->query("SELECT * FROM proveedor WHERE pro_ProveedorID=" . $capacitacion['cap_ProveedorCursoID'])->getRowArray();
            $imparte = $proveedor['pro_Nombre'];
        }

        $horario = "";
        $fechas = json_decode($capacitacion['cap_Fechas'], true);
        for ($i = 0; $i < count($fechas); $i++) {
            if ($fecha == $fechas[$i]['fecha']) {
                $horario .= ' De ' . shortTime($fechas[$i]['inicio']) . ' a ' . shortTime($fechas[$i]['fin']);
            }
        }

        //Particioantes
        $participantes = $model->getParticipantesCapacitacion($idCapacitacion, $fecha);

        $pdf = new Fpdi();
        $pdf->AddPage("L", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/asistenciaCapacitacion.pdf");
        $template = $pdf->importPage(1);
        $pdf->useTemplate($template, -1, 0, 280, 280);

        $pdf->SetFont('Arial', '', 9);

        //Nombre curso
        $pdf->SetXY(49, 35);
        $pdf->MultiCell(88, 8, utf8_decode($capacitacion['cur_Nombre']), 0, 'J');

        //Fecha
        $pdf->SetXY(165, 37);
        $pdf->Cell(25, 4, $fecha, 0, 0, 'J');

        //Instructor
        $pdf->SetXY(49, 48);
        $pdf->MultiCell(88, 8, utf8_decode($imparte), 0, 'J');


        //Horario
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetXY(165, 49);
        $pdf->Cell(45, 4, $horario, 0, 0, 'C');


        $y = 115;
        $count = 1;

        foreach ($participantes as $item) {

            $pdf->SetXY(7, $y);
            $pdf->MultiCell(8, 4, $item['no'], 0,  'C');
            $pdf->SetXY(17, $y);
            $pdf->MultiCell(76, 4, $item['nombre'], 0,  'J');
            $pdf->SetXY(95, $y);
            $pdf->MultiCell(41, 4, $item['puesto'], 0, 'C');
            $pdf->SetXY(139, $y);
            $pdf->MultiCell(60, 4, $item['correo'], 0, 'C');
            $pdf->SetXY(202, $y);
            $pdf->MultiCell(32, 4, $item['cooperativa'], 0, 'C');

            //CALCULAR OFFSET Y
            $lineas_c = ceil(strlen($item['puesto']) / 30);
            $y += ($lineas_c * 4) + 5;
            //LÍNEA INFERIOR CELDA
            $pdf->Line(6, $y, 271.5, $y);

            $y += 4;

            if ($y > 190) {
                //Adpage 2
                $pdf->AddPage("L", "Letter");
                $pdf->SetFont('Arial', '', 10);

                $y = 20;
            }
            $count++;
        }


        //Output
        $pdf->output('I', $capacitacion['cur_Nombre'] . '_' . $fecha . '.pdf');
        exit();
    }

    //Lia -> Diploma de cursos internos
    public function imprimirComprobanteCapacitacion($capacitacionEmpleadoID)
    {
        $capacitacionEmpleadoID = encryptDecrypt('decrypt', $capacitacionEmpleadoID);
        $capacitacionEmpleadoID = (int)$capacitacionEmpleadoID;

        if (empty($capacitacionEmpleadoID)) {
            exit();
        } //if

        //Get Data Curso y Empleado
        $sql = "SELECT CE.*,E.emp_Nombre,CAP.*,CUR.cur_Nombre,CUR.cur_Horas
                FROM capacitacionempleado CE
                LEFT JOIN empleado E ON E.emp_EmpleadoID=CE.cape_EmpleadoID
                LEFT JOIN capacitacion CAP ON CAP.cap_CapacitacionID=CE.cape_CapacitacionID
                LEFT JOIN curso CUR ON CUR.cur_CursoID=CAP.cap_CursoID
                WHERE CE.cape_CapacitacionEmpleadoID=?";
        $cursoEmpleado = db()->query($sql, array($capacitacionEmpleadoID))->getRowArray();

        //obtener fecha de json
        $fechas = json_decode($cursoEmpleado['cap_Fechas'], true);
        if (!empty($fechas)) {
            $primerElemento = $fechas[0];
            $fechaCompleta = $primerElemento["fecha"];
        }

        $fechaEntera = (longDate($fechaCompleta));
        $fecha = explode("-", $fechaEntera);

        $pdf = new Fpdi();
        $pdf->AddPage("L", "Letter");

        if ($cursoEmpleado['cap_TipoComprobante'] === '1') {
            $pdf->setSourceFile(FCPATH . "/assets/formatos/constancia.pdf");
            $template = $pdf->importPage(1);
            $pdf->useTemplate($template, 0, 0, null, null, true);

            $pdf->SetFont('Arial', 'B', 24);
            $pdf->SetXY(74, 98);
            $pdf->MultiCell(150, 10, utf8_decode($cursoEmpleado['emp_Nombre']), 0, 'C');

            $pdf->SetFont('Arial', 'B', 18);
            $pdf->SetXY(147, 135);
            $pdf->MultiCell(82, 10, utf8_decode($fecha[0] . ' de ' . $fecha[1] . ' del ' . $fecha[2]), 0, 'C');
        } elseif ($cursoEmpleado['cap_TipoComprobante'] === '2') {
            $pdf->setSourceFile(FCPATH . "/assets/formatos/constancia2.pdf");
            $template = $pdf->importPage(1);
            $pdf->useTemplate($template, 0, 0, null, null, true);

            $pdf->SetFont('Arial', 'B', 26);
            $pdf->SetXY(44, 102);
            $pdf->MultiCell(150, 10, utf8_decode($cursoEmpleado['emp_Nombre']), 0, 'C');

            //fecha
            $pdf->SetFont('Arial', 'B', 18);
            $pdf->SetXY(11, 157);
            $pdf->MultiCell(68, 10, utf8_decode($fecha[0] . " de " . $fecha[1] . " del"), 0, 'C');

            $pdf->SetFont('Arial', 'B', 18);
            $pdf->SetXY(35, 165);
            $pdf->MultiCell(20, 10, utf8_decode($fecha[2]), 0, 'C');
        }

        $pdf->output('I', 'DiplomaCursoInterno.pdf');
        exit();
    } //imprimirComprobanteCapacitacion

    //Lia->Imprime la encuesta de satisfaccion de capacitacion
    public function imprimirEncuestaCapacitacion($idEncuesta)
    {
        $idEncuesta = (int)$idEncuesta;
        if (empty($idEncuesta)) {
            exit();
        } //if

        //Encuesta
        $sql = "SELECT *
                FROM encuestacapacitacion
                WHERE ent_EncuestaID=?";
        $encuesta = $this->db->query($sql, array($idEncuesta))->getRowArray();

        $capacitacion = $this->db->query("SELECT * FROM capacitacion
                                            JOIN curso ON cur_CursoID=cap_CursoID
                                            WHERE cap_CapacitacionID=" . $encuesta['ent_CapacitacionID'])->getRowArray();

        $pdf = new Fpdi();
        $pdf->AddPage("P", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/encuestacapacitacion.pdf");
        $template = $pdf->importPage(1);
        $pdf->useTemplate($template, -1, 0, 220, 280);

        $pdf->SetFont('Arial', '', 10);

        //Fecha
        $pdf->SetXY(160, 25);
        $pdf->Cell(25, 4, 'Fecha: ' . $encuesta['ent_Fecha'], 0, 0, 'J');


        //Nombre curso
        $pdf->SetXY(85, 36.5);
        $pdf->Cell(65, 4, utf8_decode($capacitacion['cur_Nombre']), 0, 0, 'J');

        $pdf->SetFont('Arial', '', 10);

        //Metodologia
        $this->setEncuestaTableOption($encuesta['ent_Metodologia1a'], $pdf, 100.2); //a
        $this->setEncuestaTableOption($encuesta['ent_Metodologia1b'], $pdf, 105.2); //b
        $this->setEncuestaTableOption($encuesta['ent_Metodologia1c'], $pdf, 110.25); //c
        $this->setEncuestaTableOption($encuesta['ent_Metodologia1d'], $pdf, 115.4); //d
        $this->setEncuestaTableOption($encuesta['ent_Metodologia1e'], $pdf, 120.5); //e

        //Instructor
        $this->setEncuestaTableOption($encuesta['ent_Instructor1a'], $pdf, 130.2); //a
        $this->setEncuestaTableOption($encuesta['ent_Instructor1b'], $pdf, 135.2); //b
        $this->setEncuestaTableOption($encuesta['ent_Instructor1c'], $pdf, 140.25); //c
        $this->setEncuestaTableOption($encuesta['ent_Instructor1d'], $pdf, 145.4); //d
        $this->setEncuestaTableOption($encuesta['ent_Instructor1e'], $pdf, 150.5); //e
        $this->setEncuestaTableOption($encuesta['ent_Instructor1f'], $pdf, 155.5); //e

        //Organizacion
        $this->setEncuestaTableOption($encuesta['ent_Organizacion1a'], $pdf, 166.5); //a
        $this->setEncuestaTableOption($encuesta['ent_Organizacion1b'], $pdf, 171.5); //b

        //Satisfaccion
        $this->setEncuestaTableOption($encuesta['ent_Satisfaccion1a'], $pdf, 181.5); //a
        $this->setEncuestaTableOption($encuesta['ent_Satisfaccion1b'], $pdf, 186.5); //b
        $this->setEncuestaTableOption($encuesta['ent_Satisfaccion1c'], $pdf, 191.5); //b

        //COMETARIOS
        $pdf->SetXY(25, 210);
        $pdf->MultiCell(160, 4, utf8_decode($encuesta['ent_Comentarios']), 0, 'L');

        //Output
        $pdf->output('I', 'Encuesta_Satisfaccion_' . $capacitacion['cur_Nombre'] . '.pdf');
        exit();
    }

    //Lia -> Excribir x en la table y opcion correspondiente
    private function setEncuestaTableOption($estatus, $pdf, $y)
    {
        $posiciones = array(
            "Totalmente de acuerdo" => 165.7, "De acuerdo" => 171.5, "Indeciso" => 176.7, "En desacuerdo" => 181.65,
            "Totalmente en desacuerdo" => 189.7
        );

        if ($estatus != '') {
            $x = $posiciones[$estatus];
            $pdf->SetXY($x, $y);
            $pdf->Cell(5, 4, 'x', 0, 0, 'C');
        } //if estatus

    } //setEntrevistaSalidaTableOption

    //Lia->Imprime los resultados de la encuesta
    public function imprimirResultadosEncuesta($idCapacitacion)
    {
        //Capacitacion
        $model = new FormacionModel();
        $capacitacion = $model->getCapacitacionInfo($idCapacitacion);

        $instructor = $this->db->query("SELECT I.*, E.emp_Nombre FROM instructor I
                                        JOIN empleado E ON E.emp_EmpleadoID=I.ins_EmpleadoID
                                        WHERE ins_InstructorID=" . $capacitacion['cap_InstructorID'])->getRowArray();
        if ($capacitacion["cap_Tipo"] == 'INTERNO') {
            $imparte = $instructor['emp_Nombre'];
        } else {
            $proveedor = $this->db->query("SELECT * FROM proveedor WHERE pro_ProveedorID=" . $capacitacion['cap_ProveedorCursoID'])->getRowArray();
            $imparte = $proveedor['pro_Nombre'];
        }

        $pdf = new Fpdi();
        $pdf->AddPage("P", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/resEncuesta.pdf");
        $template = $pdf->importPage(1);
        $pdf->useTemplate($template, -1, 0, 220, 280);

        $pdf->SetFont('Arial', '', 10);

        $logo = FCPATH . "/assets/images/LOGO_AMA.png";
        $pdf->Image($logo, 16, 16, 25, 25.8);


        //Fecha
        $pdf->SetXY(151, 55);
        $pdf->Cell(25, 4, date('Y-m-d'), 0, 0, 'J');

        //Numero de pagina
        $pdf->SetXY(151, 60.5);
        $pdf->Cell(5, 3.5, $pdf->PageNo() . ' de {nb}', 0, 0, 'J');
        $pdf->AliasNbPages();

        $pdf->SetFont('Arial', 'B', 12);
        //Nombre de la empresa
        $empresaNombre = getSetting('nombre_empresa', $this);
        $pdf->SetXY(85, 66);
        $pdf->Cell(65, 4, utf8_decode($empresaNombre), 0, 0, 'J');

        $url1 = FCPATH . "/assets/uploads/resultados/encuesta/resultados" . $idCapacitacion . ".png";

        $pdf->SetFont('Arial', '', 10);
        //Nombre curso
        $pdf->SetXY(55, 72);
        $pdf->Cell(65, 4, utf8_decode($capacitacion['cur_Nombre']), 0, 0, 'J');

        //Instructor
        $pdf->SetXY(55, 79);
        $pdf->Cell(65, 4, utf8_decode($imparte), 0, 0, 'J');

        $pdf->SetXY(10, 80);
        if (file_exists($url1)) $pdf->Cell(90, 60, $pdf->Image($url1, $pdf->GetX(), $pdf->GetY(), 190, 70), 0, 0, 'C', false);

        $pdf->output('I', 'resultadosEncuesta.pdf');
        exit();
    }

    //Christian-> PDF de evaluacion por desempeño empleado
    public function resultadosEvaluacionDesemp($empleadoID, $periodoID)
    {

        //datos
        $model = new EvaluacionesModel();

        $empleado = $model->getEmpleadoInfo($empleadoID);
        $periodoInfo = $model->getPeriodoInfo($periodoID);
        $resultados = $model->getDesempeno270ByEmpleadoPeriodo($periodoID, $empleadoID);

        $data['empleado'] = $empleado;
        $data['periodoInfo'] = $periodoInfo;
        $data['resultados'] = $resultados;

        //Librerias
        require(APPPATH . "ThirdParty/random_compat/random.php");
        require(APPPATH . '../vendor/autoload.php');

        $mpdf =  new \Mpdf\Mpdf(['mode' => 'utf-8']);

        try {
            $mpdf->SetCompression(false);
            $mpdf->setFooter('Pagina: {PAGENO} / {nb}');
            $css = file_get_contents(base_url('assets/css/reporteEvaluacionDesmpe.css'));
            $mpdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);
            $mpdf->WriteHTML($this->plantillaEvaluacionDesempe($data));
            //$mpdf->Output();
            $mpdf->Output($empleado['emp_Nombre'] . ' Resultados Evaluacion de Desempeño.pdf', 'd');
        } catch (\Mpdf\MpdfException $e) { // Note: safer fully qualified exception
            //       name used for catch
            // Process the exception, log, print etc.
            echo $e->getMessage();
        }
        exit();
    } //resultadosEvaluacionDesemp

    //Christian - plantilla para generar el pdf desempeño
    public function plantillaEvaluacionDesempe($data)
    {

        $empleado = $data['empleado'];
        $periodoInfo = $data['periodoInfo'];
        $resultados = $data['resultados'];

        $logo = base_url('assets/images/LOGO_AMA.png');

        $imagen = base_url("assets/uploads/resultados/evaluacionDesempeno/evaluacionDesempByColaborador.png");

        $html = '
            <header class="clearfix">
                  <div id="logo" class="center">
                    <img style="width: 80px;" src="' . $logo . '">
                  </div>
                  <h1>' . $empleado['emp_Nombre'] . '</h1>
            </header>
        ';

        $html .= '
            <main>
            <div class="contenedor">
              <h2 style="text-align: center">Resultados de la evaluacion de desempeño 270</h2>
               <div class="container task-detail" id="reporteDesempeno">
                 <table>
                    <tr>
                        <td style="width: 10%">
                            <img class="rounded-circle avatar-xl img-thumbnail" src="' . fotoPerfil(encryptDecrypt('encrypt', $empleado['emp_EmpleadoID'])) . '">
                        </td>
                        <td style="width: 90%">
                            <h4>' . $empleado['emp_Nombre'] . '</h4>
                            <p style="margin-bottom: 5px;">' . $empleado['pue_Nombre'] . '</p>
                            <div class="row" style="margin-left: 0px;">
                                <p class="mb-1 ml-1">' . $periodoInfo['eva_FechaInicio'] . ' a ' . $periodoInfo['eva_FechaFin'] . '</p>
                            </div>
                        </td>
                    </tr>
                 </table>


                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped mb-0 table-bordered ">
                                    <thead class="thead-dark" align="center">
                                    <tr>
                                        <th style="width: 10%">ID</th>
                                        <th style="width: 40%">Función</th>
                                        <th style="width: 10%">Calificación empleado</th>
                                        <th style="width: 10%">Calificación jefe</th>
                                        <th style="width: 10%">Calificación pares</th>
                                        <th style="width: 10%">Calificación subordinados</th>
                                        <th style="width: 10%">Promedio función</th>
                                    </tr>
                                    </thead>
                                    <tbody>';

        $promedioFT = 0;
        $countFT = 0;
        foreach ($resultados['funciones'] as $key => $val) {

            $promedioF = 0;
            $count = 0;

            $auto = 'No disponible';
            if ((!is_null($resultados['evaAuto']['resultados']))) {
                $auto = round($resultados['evaAuto']['resultados'][$key]['Calificacion'], 2);
                $promedioF += $auto;
                $count++;
            }

            $jefe = 'No disponible';
            if ((!is_null($resultados['evaJefe']['resultados']))) {
                $jefe = round($resultados['evaJefe']['resultados'][$key]['Calificacion'], 2);
                $promedioF += $jefe;
                $count++;
            }

            $pares = 'No disponible';
            if ((!is_null($resultados['evaPares']['resultados']))) {
                $pares = round($resultados['evaPares']['resultados'][$key]['Promedio'], 2);
                $promedioF += $pares;
                $count++;
            }

            $sub = 'No disponible';
            if ((!is_null($resultados['evaSub']['resultados']))) {
                $sub = round($resultados['evaSub']['resultados'][$key]['Promedio'], 2);
                $promedioF += $sub;
                $count++;
            }


            if ($count > 0) {
                $promedioF = round($promedioF / $count, 2);
                $promedioFT += $promedioF;
                $countFT++;
            } else {
                $promedioF = 'No disponible';
            }

            $html .= '<tr>
                                            <td>' . $key . '</td>
                                            <td>' . $val . '</td>
                                            <td>' . $auto . '</td>
                                            <td>' . $jefe . '</td>
                                            <td>' . $pares . '</td>
                                            <td>' . $sub . '</td>
                                            <td class="table-success">' . $promedioF . '</td>
                                        </tr>';
        }
        $auto = (!is_null($resultados['evaAuto']['promedio'])) ? round($resultados['evaAuto']['promedio'], 2) : 'No disponible';
        $jefe = (!is_null($resultados['evaJefe']['promedio'])) ? round($resultados['evaJefe']['promedio'], 2) : 'No disponible';
        $pares = (!is_null($resultados['evaPares']['promedio'])) ? round($resultados['evaPares']['promedio'], 2) : 'No disponible';
        $sub = (!is_null($resultados['evaSub']['promedio'])) ? round($resultados['evaSub']['promedio'], 2) : 'No disponible';
        $promedioFT = ($countFT > 0) ? round($promedioFT / $countFT, 2) : 'No disponible';

        $html .= '<tr class="table-success" >
                                            <td colspan="2" >Promedio Evaluador</td>
                                            <td>' . $auto . '</td>
                                            <td>' . $jefe . '</td>
                                            <td>' . $pares . '></td>
                                            <td>' . $sub . '</td>
                                            <td></td>
                                        </tr>
                                        <tr class="table-warning" >
                                            <td colspan="2" style="text-align: center;vertical-align:middle">Total</td>
                                            <td colspan="5">' . $promedioFT . '</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
               ';

        $html .= '
        <div class="col-md-12">
            <h6 class="mb-4"></h6>
            <div class="dashboard-donut-chart">
                <img src="' . $imagen . '">
            </div>
        </div>';

        $html .= '
            </div>
           </main>
        ';
        return  $html;
    } //plantillaPuesto

    //Diego-> dia extraordinario solicitudid
    public function solicitudDiaExtraordinario($diaextraordianarioID)
    {
        $diaextraordianarioID = encryptDecrypt('decrypt', $diaextraordianarioID);

        //Get Data Curso y Empleado
        $sql = "SELECT DE.*,C.coo_Sucursal,E.emp_Nombre as 'empleado',J.emp_Nombre as 'jefe',P.pue_Nombre
                FROM diaextraordinario DE
                JOIN cooperativa C ON C.coo_CooperativaID=DE.dia_CooperativaID
                JOIN empleado E ON E.emp_EmpleadoID=DE.dia_EmpleadoID
                JOIN empleado J ON J.emp_EmpleadoID=DE.dia_JefeID
                JOIN puesto P ON J.emp_PuestoID=P.pue_PuestoID
                WHERE dia_DiaExtraordinarioID=?";
        $diaextra = db()->query($sql, array($diaextraordianarioID))->getRowArray();

        $pdf = new Fpdi();
        $pdf->AddPage("P", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/formatoDiaExtraordinario.pdf");
        $template = $pdf->importPage(1);
        $pdf->useTemplate($template, -1, 0, 220, 280);

        $pdf->SetFont('Arial', 'B', 12);
        $recursoshumanos = $this->db->query("SELECT * FROM puesto JOIN empleado ON emp_PuestoID=pue_PuestoID WHERE pue_Nombre='Encargado de Recursos Humanos'")->getRowArray();
        $pdf->SetXY(28.5, 50.5);
        $pdf->Cell(160, 5, utf8_decode($recursoshumanos['pue_Nombre']), 0, 0, 'J');

        $pdf->SetXY(28.5, 56);
        $pdf->Cell(160, 5, utf8_decode(ucwords(strtolower($recursoshumanos['emp_Nombre']))), 0, 0, 'J');

        $pdf->SetXY(48, 78.5);
        $pdf->Cell(160, 5, utf8_decode(ucwords(strtolower($recursoshumanos['emp_Nombre'])) . ','), 0, 0, 'J');

        $pdf->SetXY(29, 112.5);
        $pdf->Cell(50, 5, utf8_decode($diaextra['empleado'] . ', a laborar el día ' . longDate($diaextra['dia_Dia'], ' de ')) . '.', 0, 0, 'J');
        $pdf->SetXY(62, 118.5);
        //$pdf->Cell(50,5,longDate($diaextra['dia_Dia'],' de ').'.',0,0,'J');
        $pdf->SetXY(85, 230);
        $pdf->Cell(50, 5, utf8_decode($diaextra['jefe']), 0, 0, 'C');
        $pdf->SetXY(85, 236);
        $pdf->Cell(50, 5, utf8_decode($diaextra['pue_Nombre']), 0, 0, 'C');

        if ($diaextra['dia_Estatus'] !== 'PENDIENTE' && $diaextra['dia_Estatus'] !== 'RECHAZADO') {
            $pdf->SetXY(90, 240);
            $pdf->Cell(50, 5, utf8_decode($diaextra['jefe']), 0, 0, 'C');
        }

        $pdf->output('I', 'SolicitudDiaExtraordinario.pdf');
        exit();
    } //imprimirComprobanteCapacitacion


    //Lia -> Imprimir hoja liberacion de la baja del empleado
    public function imprimirHojaLiberacion($bajaEmpleadoID)
    {
        $bajaEmpleadoID = encryptDecrypt('decrypt', $bajaEmpleadoID);

        if (empty($bajaEmpleadoID)) {
            exit();
        } //if

        $baja = $this->PdfModel->getBajaEmpleado($bajaEmpleadoID);

        //Create Document
        $pdf = new Fpdi();
        $pdf->AddPage("P", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/hojaLiberacion.pdf");
        $template = $pdf->importPage(1);
        $pdf->useTemplate($template, -1, 0, 220, 280);

        $pdf->SetFont('Arial', 'B', 11);
        $pdf->SetXY(74.4, 53);
        $pdf->Cell(122, 5, utf8_decode(getSetting('nombre_empresa', $this)), 0, 0, 'C');


        $pdf->SetFont('Arial', '', 10);

        /**HOJA DE LIBERACIÓN**/


        //Fecha de registro
        $fechaRegistro = ($baja['baj_FechaRegistro'] != '0000-00-00' && !is_null($baja['baj_FechaRegistro'])) ? longDate($baja['baj_FechaRegistro'], ' de ') : '';
        $pdf->SetXY(161, 42);
        $pdf->Cell(45, 4, utf8_decode($fechaRegistro), 0, 0, 'R');
        //Fecha baja
        $fechaBaja = ($baja['baj_FechaBaja'] != '0000-00-00') ? longDate($baja['baj_FechaBaja'], ' de ') : '';
        $pdf->SetXY(161, 47.5);
        $pdf->Cell(45, 4, utf8_decode($fechaBaja), 0, 0, 'R');

        //Numero de empleado
        $pdf->SetXY(37, 59);
        $pdf->Cell(32, 4, utf8_decode($baja['numero']), 0, 0, 'L');

        //Empleado
        $pdf->SetXY(100, 59);
        $pdf->Cell(110, 4, utf8_decode($baja['empleado']), 0, 0, 'L');

        //Puesto
        $pdf->SetXY(25, 64);
        $pdf->Cell(170, 4, utf8_decode($baja['puesto']), 0, 0, 'L');

        //Departamento
        $pdf->SetXY(35, 70);
        $pdf->Cell(110, 4, utf8_decode($baja['departamento']), 0, 0, 'L');

        //Jefe inmediato
        $pdf->SetXY(55, 75);
        $pdf->Cell(170, 4, utf8_decode($baja['jefe']), 0, 0, 'L');

        //Motivo baja
        $pdf->SetXY(6.8, 90);
        $pdf->MultiCell(204, 5, utf8_decode($baja['baj_MotivoBaja']), 0, 'L');


        //Listado de contraseñas
        $correo = ($baja['baj_Correo'] != '') ? "Correo\n   Usuario: " . $baja['baj_Correo'] . "\n   Contraseña: " . $baja['baj_ContrasenaCorreo'] . "\n" : "";
        $telefono = ($baja['baj_Telefono'] != '') ? "Teléfono\n   Número: " . $baja['baj_Telefono'] . "\n   Contraseña: " . $baja['baj_ContrasenaTelefono'] . "\n" : "";
        $computadora = ($baja['baj_Computadora'] != '') ? "Computadora\n   Usuario: " . $baja['baj_Computadora'] . "\n   Contraseña: " . $baja['baj_ContrasenaComputadora'] . "\n" : "";

        $pdf->SetXY(60, 115);
        $pdf->MultiCell(75.5, 3.2, utf8_decode($correo . $telefono . $computadora), 0, 'L');

        $url1 = ($baja['baj_UrlSitio1'] != '') ? "URL: " . $baja['baj_UrlSitio1'] . "\n   Usuario: " . $baja['baj_UserSitio1'] . "\n   Contraseña: " . $baja['baj_ContrasenaSitio1'] . "\n" : "";
        $url2 = ($baja['baj_UrlSitio2'] != '') ? "URL: " . $baja['baj_UrlSitio2'] . "\n   Usuario: " . $baja['baj_UserSitio2'] . "\n   Contraseña: " . $baja['baj_ContrasenaSitio2'] . "\n" : "";
        $url3 = ($baja['baj_UrlSitio3'] != '') ? "URL: " . $baja['baj_UrlSitio3'] . "\n   Usuario: " . $baja['baj_UserSitio3'] . "\n   Contraseña: " . $baja['baj_ContrasenaSitio3'] . "\n" : "";
        $pdf->SetXY(60, 150);
        $pdf->MultiCell(75.5, 3.2, utf8_decode($url1 . $url2 . $url3), 0, 'L');

        $pdf->SetFont('Arial', '', 10);
        //COMENTARIOS
        $pdf->SetXY(60, 190.8);
        $pdf->Multicell(151, 4, utf8_decode($baja['baj_Comentarios']), 0,  'L');

        //FIRMA COLABORADOR
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetXY(13, 238);
        $pdf->Multicell(40, 4, utf8_decode($baja['empleado']), 0,  'C');

        //FIRMA DE CAPITAL HUMANO
        $pdf->SetXY(165, 238);
        $pdf->Multicell(40, 4, utf8_decode($baja['capitalHumano']), 0,  'C');

        //Output
        $pdf->output('I', 'Hoja de Liberacion-' . $bajaEmpleadoID . '.pdf');
        exit();
    } //imprimirHojaLiberacion


    public function interpretacionG2CentroTrabajo($fechaI, $fechaF, $sucursalID = null)
    {


        $model = new EvaluacionesModel();
        $sucursalID = encryptDecrypt('decrypt', $sucursalID);
        $data = $model->getDominiosBajoRiesgo($fechaI, $fechaF, $sucursalID = null);

        $pdf = new Fpdi();
        $pdf->AddPage("P", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/resultadosg2centro.pdf");
        $template = $pdf->importPage(1);
        $pdf->useTemplate($template, -1, 0, 220, 280);
        $pdf->SetFont('Arial', 'B', 12);


        //Centro de trabajo
        $pdf->SetXY(20, 75);
        $pdf->Cell(180, 4, utf8_decode(getSetting('nombre_empresa', $this)), 0, 0, 'C');

        //Grafica
        $pdf->SetXY(10, 118);
        $url1 = FCPATH . "/assets/uploads/resultados/Nom035/GraficaIntG2CT.png";
        if (file_exists($url1)) $pdf->Cell(90, 80, $pdf->Image($url1, $pdf->GetX(), $pdf->GetY(), 190, 100), 0, 0, 'C', false);


        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetXY(20, 220);
        $pdf->MultiCell(20, 15, 'Riesgo', 1, 'C');
        $pdf->SetXY(40, 220);
        $pdf->MultiCell(20, 5, 'Condiciones del ambiente de trabajo', 1, 'C');
        $pdf->SetXY(60, 220);
        $pdf->MultiCell(20, 7.5, 'Carga de trabajo', 1, 'C');
        $pdf->SetXY(80, 220);
        $pdf->MultiCell(20, 5, 'Falta de control en el trabajo', 1, 'C');
        $pdf->SetXY(100, 220);
        $pdf->MultiCell(20, 7.5, 'Jornada de trabajo', 1, 'C');
        $pdf->SetXY(120, 220);
        $pdf->MultiCell(20, 5, 'Interf. en la relacion trab-fam', 1, 'C');
        $pdf->SetXY(140, 220);
        $pdf->MultiCell(20, 15, 'Liderazgo', 1, 'C');
        $pdf->SetXY(160, 220);
        $pdf->MultiCell(20, 7.5, 'Relaciones en el trabajo', 1, 'C');
        $pdf->SetXY(180, 220);
        $pdf->MultiCell(20, 15, 'Violencia', 1, 'C');
        $pdf->SetFont('Arial', '', 8);

        $this->BasicTable($data, $pdf);

        //Output
        $pdf->output('I', 'ResultadosAplicacionG2Centro.pdf');
        exit();
    }

    function BasicTable($data, $pdf)
    {
        $i = 1;
        // Data
        foreach ($data as $row) {
            $pdf->SetX(20);
            switch ($i) {
                case 1:
                    $titulo = 'Bajo ';
                    $pdf->SetFillColor(229, 229, 0);
                    $pdf->SetTextColor(255, 255, 255);
                    break;
                case 2:
                    $titulo = 'Medio';
                    $pdf->SetFillColor(45, 174, 82);
                    $pdf->SetTextColor(255, 255, 255);
                    break;
                case 3:
                    $titulo = 'Alto ';
                    $pdf->SetFillColor(255, 49, 49);
                    $pdf->SetTextColor(255, 255, 255);
                    break;
            }
            $pdf->Cell(20, 5, $titulo, 1, 0, 'C', 1);
            $pdf->SetTextColor(0, 0, 0);
            foreach ($row as $col)
                $pdf->Cell(20, 5, $col, 1);
            $pdf->Ln();
            $i++;
        }
    }

    public function interpretacionG2Empresa($idEmpresa)
    {
        $empresa = $this->db->query("SELECT * FROM empresa WHERE emp_EmpresaID=" . encryptDecrypt('decrypt', $idEmpresa))->getRowArray();

        $model = new EvaluacionesModel();
        $data = $model->getDominiosByEmpresa($idEmpresa);

        $pdf = new Fpdi();
        $pdf->AddPage("P", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/resultadosg2centro.pdf");
        $template = $pdf->importPage(1);
        $pdf->useTemplate($template, -1, 0, 220, 280);
        $pdf->SetFont('Arial', 'B', 12);

        //Empresa
        $pdf->SetXY(20, 67);
        $pdf->Cell(180, 4, utf8_decode(getSetting('nombre_empresa', $this)), 0, 0, 'C');

        //Grafica
        $pdf->SetXY(10, 118);
        $idEmpresa = encryptDecrypt('decrypt', $idEmpresa);
        $url1 = FCPATH . "/assets/uploads/resultados/GraficaIntG2E-" . $idEmpresa . ".png";
        if (file_exists($url1)) $pdf->Cell(90, 80, $pdf->Image($url1, $pdf->GetX(), $pdf->GetY(), 190, 100), 0, 0, 'C', false);


        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetXY(20, 220);
        $pdf->MultiCell(20, 15, 'Riesgo', 1, 'C');
        $pdf->SetXY(40, 220);
        $pdf->MultiCell(20, 5, 'Condiciones del ambiente de trabajo', 1, 'C');
        $pdf->SetXY(60, 220);
        $pdf->MultiCell(20, 7.5, 'Carga de trabajo', 1, 'C');
        $pdf->SetXY(80, 220);
        $pdf->MultiCell(20, 5, 'Falta de control en el trabajo', 1, 'C');
        $pdf->SetXY(100, 220);
        $pdf->MultiCell(20, 7.5, 'Jornada de trabajo', 1, 'C');
        $pdf->SetXY(120, 220);
        $pdf->MultiCell(20, 5, 'Interf. en la relacion trab-fam', 1, 'C');
        $pdf->SetXY(140, 220);
        $pdf->MultiCell(20, 15, 'Liderazgo', 1, 'C');
        $pdf->SetXY(160, 220);
        $pdf->MultiCell(20, 7.5, 'Relaciones en el trabajo', 1, 'C');
        $pdf->SetXY(180, 220);
        $pdf->MultiCell(20, 15, 'Violencia', 1, 'C');
        $pdf->SetFont('Arial', '', 8);

        $this->BasicTable($data, $pdf);

        //Output
        $pdf->output('I', 'ResultadosAplicacionG2Empresa.pdf');
        exit();
    }


    public function imprimirSolicitudAnticipoSueldo($anticipoID)
    {
        $model = new PdfModel();
        $solicitud = $model->getSolicitudAnticipoSueldoByID($anticipoID);
        $planPago = $model->getPlanPagoAnticipoSueldo($anticipoID);

        $pdf = new Fpdi();
        $pdf->AddPage("P", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/anticipoSueldo.pdf");
        $template = $pdf->importPage(1);
        $pdf->useTemplate($template, -1, 0, 220, 280);



        $pdf->SetFont('Arial', 'B', 6);


        $pdf->setFillColor(255, 255, 255);
        $pdf->SetXY(140, 20);
        $pdf->Cell(0, 50, '', 0, 1, 'L', 1); //your cell



        $pdf->SetTextColor(32, 55, 100);
        //Numero de socio
        $pdf->SetXY(31, 42);
        $pdf->Cell(35, 3, $solicitud['emp_NumSocio'], 0, 0, 'J');

        //Nombre
        $pdf->SetXY(31, 45);
        $pdf->Cell(35, 3, utf8_decode($solicitud['emp_Nombre']), 0, 0, 'J');

        //Estado civil
        $pdf->SetXY(31, 48);
        $pdf->Cell(35, 3, utf8_decode($solicitud['emp_EstadoCivil']), 0, 0, 'J');

        $pdf->SetFont('Arial', 'B', 5);

        //Calle y numero
        $pdf->SetXY(31, 51);
        $pdf->Cell(35, 3, utf8_decode($solicitud['emp_Direccion']), 0, 0, 'J');

        //Colonia
        $pdf->SetXY(31, 54);
        $pdf->Cell(35, 3, utf8_decode($solicitud['emp_Colonia']), 0, 0, 'J');

        //Ciudad
        $pdf->SetXY(31, 56.5);
        $pdf->Cell(35, 3, utf8_decode($solicitud['emp_Municipio'] . ', ' . $solicitud['emp_EntidadFederativa']), 0, 0, 'J');

        $pdf->SetFont('Arial', 'B', 6);

        //Codigo postal
        $pdf->SetXY(31, 59.5);
        $pdf->Cell(35, 3, utf8_decode($solicitud['emp_CodigoPostal']), 0, 0, 'J');

        $pdf->SetFont('Arial', 'B', 4);
        //Puesto
        $pdf->SetXY(91, 42);
        $pdf->Cell(35, 3, utf8_decode($solicitud['pue_Nombre']), 0, 0, 'J');

        $pdf->SetFont('Arial', 'B', 6);
        //Sueldo mensual
        $pdf->SetXY(91, 45);
        $pdf->Cell(35, 3, '$' . number_format($solicitud['ant_SueldoMensual'], 2), 0, 0, 'J');

        //Fecha de ingreso
        $pdf->SetXY(91, 48);
        $pdf->Cell(35, 3, utf8_decode(longDate($solicitud['emp_FechaIngreso'], ' de ')), 0, 0, 'J');

        //Antiguedad
        $pdf->SetXY(91, 50.5);
        $pdf->Cell(35, 3, utf8_decode(antiguedadMesesAnios($solicitud['emp_FechaIngreso'])), 0, 0, 'J');

        //Cantidad Solicitada
        $pdf->SetXY(91, 56);
        $pdf->Cell(35, 3, '$' . number_format($solicitud['ant_Monto'], 2), 0, 0, 'J');

        $pdf->SetFont('Arial', 'B', 5);
        //Finalidad
        $pdf->SetXY(91, 59);
        $pdf->Cell(35, 3, utf8_decode($solicitud['ant_Finalidad']), 0, 0, 'J');

        $pdf->SetFont('Arial', 'B', 6);
        //Plazo
        $pdf->SetXY(42, 68.5);
        $pdf->Cell(35, 3, utf8_decode($solicitud['ant_Plazo']), 0, 0, 'J');

        //Importe
        $pdf->SetXY(90, 68.5);
        $pdf->MultiCell(35, 3, '$' . number_format($solicitud['ant_ImporteAbono'], 2), 0,  'C');

        $y = 78;
        $prestamos = json_decode($solicitud['ant_PrestamosSocios'], true);
        $count = 0;
        if (!empty($prestamos)) {
            for ($i = 0; $i < count($prestamos); $i++) {
                $x = 33;
                $pdf->SetXY($x, $y);
                $pdf->Cell(35, 3, '$' . number_format($prestamos[$i]['monto'], 2), 0, 0, 'J');
                $pdf->SetX($x + 50);
                $pdf->Cell(35, 3, '$' . number_format($prestamos[$i]['saldo'], 2), 0, 0, 'J');
                $pdf->Ln();
                $pdf->SetX($x);
                $pdf->Cell(35, 3, shortDate($prestamos[$i]['inicio'], ' de '), 0, 0, 'J');
                $pdf->SetX($x + 50);
                $pdf->Cell(35, 3, $prestamos[$i]['plazo'], 0, 0, 'J');
                $pdf->Ln();
                $pdf->SetX($x);
                $pdf->Cell(35, 3, shortDate($prestamos[$i]['fin'], ' de '), 0, 0, 'J');
                $pdf->SetX($x + 50);
                $pdf->Cell(35, 3, '$' . number_format($prestamos[$i]['abonos'], 2), 0, 0, 'J');
                $y += 9.25;
                $count++;
            }
        }

        //Fecha
        $pdf->SetXY(60, 128.7);
        $pdf->MultiCell(35, 3, longDate($solicitud['ant_Fecha'], ' de '), 0,  'J');

        //Firma Solicitante
        $pdf->SetXY(17, 146);
        $pdf->MultiCell(50, 3, utf8_decode($solicitud['emp_Nombre']), 0,  'C');


        //Plan de pago

        $pdf->AddPage("P", "Letter");
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFillColor(170, 181, 216);
        $pdf->SetXY(10, 15);
        $pdf->MultiCell(195, 5, 'PLAN DE PAGOS DEL PRESTAMO SOLICITADO', 1, 'C', 1);
        $pdf->MultiCell(32.5, 5, 'Plazo', 1, 'C');
        $pdf->SetXY(42.5, 20);
        $pdf->SetTextColor(32, 55, 100);
        $pdf->MultiCell(32.5, 5, $solicitud['ant_Plazo'], 1, 'C');
        $pdf->SetXY(75, 20);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell(32.5, 5, 'Modalidad', 1, 'C');
        $pdf->SetXY(107.5, 20);
        $pdf->SetTextColor(32, 55, 100);
        $pdf->MultiCell(32.5, 5, 'QUINCENAL', 1, 'C');
        $pdf->SetXY(140, 20);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->MultiCell(32.5, 5, 'Importe Pagos', 1, 'C');
        $pdf->SetXY(172.5, 20);
        $pdf->SetTextColor(32, 55, 100);
        $pdf->MultiCell(32.5, 5, '$' . number_format($solicitud['ant_ImporteAbono'], 2), 1, 'C');

        $header = array('Plazo', 'Fecha de abono', 'Saldo Actual', 'Importe Abono');

        $pdf->SetFont('Arial', '', 6);
        $pdf->SetTextColor(0, 0, 0);
        $this->BasicTablePlanPagoAnticipoSueldo($header, $planPago, $pdf);

        //Output
        $pdf->output('I', 'SolicitudPrestamo' . utf8_decode($solicitud['emp_Nombre']) . '.pdf');
        exit();
    }


    function BasicTablePlanPagoAnticipoSueldo($header, $data, $pdf)
    {
        $pdf->SetXY(30, 30);
        // Header
        $pdf->SetFont('Arial', 'B', 7);
        foreach ($header as $col)
            $pdf->Cell(39, 5, utf8_decode($col), 1, 0, 'C');
        $pdf->Ln();
        // Data

        $pdf->SetFont('Arial', '', 6);
        foreach ($data as $row) {
            $pdf->SetX(30);
            foreach ($row as $col)
                $pdf->Cell(39, 5, utf8_decode($col), 1, 0, 'C');
            $pdf->Ln();
        }
    }

    public function pagare($anticipoID)
    {
        $model = new PdfModel();
        $solicitud = $model->getSolicitudAnticipoSueldoByID($anticipoID);
        $planPago = $model->getPlanPagoAnticipoSueldo($anticipoID);

        $pdf = new Fpdi();
        $pdf->AddPage("P", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/pagare.pdf");
        $template = $pdf->importPage(1);
        $pdf->useTemplate($template, -1, 0, 220, 280);
        $pdf->SetFont('Courier', 'B', 9);

        //Numero de socio
        $no = str_pad($solicitud['emp_NumSocio'], 11, "0", STR_PAD_LEFT);
        $pdf->SetXY(183, 57);
        $pdf->Cell(35, 3, $no, 0, 0, 'J');

        //fecha
        $pdf->SetXY(65, 67);
        $pdf->Cell(32.5, 5, longDate($solicitud['ant_Fecha'], ' de ') . '.', 0, 1, 'C');

        //Bueno por
        $pdf->SetFont('Courier', '', 9);
        $pdf->SetX(11);
        $pdf->Cell($pdf->GetStringWidth('Bueno por '), 5, 'Bueno por ', 0, 0, 'L');
        $pdf->SetFont('Courier', 'B', 9);
        $pdf->Cell(32.5, 5, '$ ' . number_format($solicitud['ant_Monto'], 2, '.', ','), 0, 1, 'L');

        //Vence
        $pdf->SetFont('Courier', '', 9);
        $pdf->SetX(11);
        $pdf->Cell($pdf->GetStringWidth('Vence el '), 5, 'Vence el ', 0, 0, 'L');
        $pdf->SetFont('Courier', 'B', 9);
        $count = count($planPago);
        $mesanio = substr($planPago[$count - 1]['pla_Fecha'], 0, -2);
        $dia = substr($solicitud['ant_Fecha'], 8);
        $fechaVencimiento = $mesanio . $dia;
        $pdf->Cell(32.5, 5, longDate($fechaVencimiento, ' de ') . '.', 0, 1, 'L');
        $pdf->Ln();

        //datos del colaborador
        $pdf->SetFont('Courier', '', 9);
        $pdf->SetX(11);
        $pdf->Cell($pdf->GetStringWidth('C. '), 5, 'C. ', 0, 0, 'L');
        $pdf->SetFont('Courier', 'B', 9);
        $empleado = utf8_decode($solicitud['emp_Nombre'] . ', ');
        $pdf->Cell($pdf->GetStringWidth($empleado), 5, $empleado, 0, 0, 'L');
        $pdf->SetFont('Courier', '', 9);
        $pdf->Cell($pdf->GetStringWidth('y con domicilio en '), 5, 'y con domicilio en ', 0, 0, 'L');
        $pdf->SetFont('Courier', 'B', 9);
        $direccion = $solicitud['emp_Direccion'] . ' ' . $solicitud['emp_Colonia'] . ', ';
        $pdf->Cell($pdf->GetStringWidth($direccion), 5, $direccion, 0, 1, 'L');
        $pdf->SetX(11);
        $direccion = 'en ' . $solicitud['emp_Municipio'] . ', ' . $solicitud['emp_EntidadFederativa'];
        $pdf->Cell($pdf->GetStringWidth($direccion), 5, $direccion, 0, 0, 'L');
        $pdf->SetFont('Courier', '', 9);
        $debo = utf8_decode(' debo y pagaré incondicionalmente a la orden de');
        $pdf->Cell($pdf->GetStringWidth($debo), 5, $debo, 0, 1, 'L');

        //cantidad
        $pdf->SetY(110);
        $pdf->SetX(11);
        $pdf->SetFont('Courier', 'B', 9);
        $cantidad = '(***' . num_letras($solicitud['ant_Monto'], 'MN') . '. ***)';
        $pdf->Cell(190, 5, $cantidad, 0, 0, 'C');

        //vencimiento
        $pdf->SetXY(73.5, 115.5);
        $pdf->Cell(32.5, 5, longDate($fechaVencimiento, ' de ') . '.', 0, 1, 'L');

        //plazos
        $pdf->SetXY(89, 142.5);
        $pdf->SetFont('Courier', 'BU', 9);
        $pdf->Cell(8, 5, $solicitud['ant_Plazo'], 0, 1, 'C');

        //datos del empleado
        $pdf->SetXY(11, 218);
        $pdf->SetFont('Courier', 'B', 9);
        $pdf->Cell(8, 5, utf8_decode(strtoupper($solicitud['emp_Nombre'])), 0, 1, 'L');
        $pdf->SetX(11);
        $pdf->Cell(8, 5, utf8_decode(strtoupper($solicitud['emp_Direccion'])), 0, 1, 'L');

        $pdf->SetX(11);
        $pdf->Cell(8, 5, utf8_decode(strtoupper($solicitud['emp_Colonia'])), 0, 1, 'L');
        $pdf->SetX(11);
        $pdf->Cell(8, 5, utf8_decode(strtoupper($solicitud['emp_Municipio'] . ', ' . $solicitud['emp_EntidadFederativa'] . '.')), 0, 1, 'L');


        //Output
        $pdf->output('I', 'Pagare' . utf8_decode($solicitud['emp_Nombre']) . '.pdf');
        exit();
    }
    //Lia->evaluaciones guia 3
    public function evaluacionesGuiaIII($f1, $f2, $sucursal)
    {

        //Evaluaciones
        $model = new PdfModel();
        $sucursal = encryptDecrypt('decrypt', $sucursal);
        $evaluaciones = $model->getEvaluacionesGuia3($f1, $f2, $sucursal);
        for ($i = 1; $i <= 72; $i++) {
            switch ($i) {
                case 1:
                case 4:
                case 23:
                case 24:
                case 25:
                case 26:
                case 27:
                case 28:
                case 30:
                case 31:
                case 32:
                case 33:
                case 33:
                case 34:
                case 35:
                case 36:
                case 37:
                case 38:
                case 39:
                case 40:
                case 41:
                case 42:
                case 43:
                case 44:
                case 45:
                case 46:
                case 47:
                case 48:
                case 49:
                case 50:
                case 51:
                case 52:
                case 53:
                case 55:
                case 56:
                case 57:
                    $pregunta[$i]['respuesta'] = 1;
                    break;
                default:
                    $pregunta[$i]['respuesta'] = 0;
                    break;
            }
        }

        $pdf = new Fpdi();
        foreach ($evaluaciones as $evaluacion) {

            /*Pagina 1*/
            $pdf->AddPage("P", "Letter");
            $pdf->setSourceFile(FCPATH . "/assets/formatos/cuestionarioGuia3.pdf");
            $template = $pdf->importPage(1);
            $pdf->useTemplate($template, -1, 0, 220, 280);
            $pdf->SetFont('Arial', 'B', 12);

            //A)
            $this->setEncuestaG3TableOption($evaluacion['eva_P1'], $pdf, 65, $pregunta[1]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P2'], $pdf, 74, $pregunta[2]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P3'], $pdf, 81, $pregunta[3]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P4'], $pdf, 90, $pregunta[4]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P5'], $pdf, 101, $pregunta[5]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P6'], $pdf, 141, $pregunta[6]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P7'], $pdf, 153, $pregunta[7]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P8'], $pdf, 165, $pregunta[8]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P9'], $pdf, 196, $pregunta[9]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P10'], $pdf, 203, $pregunta[10]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P11'], $pdf, 212, $pregunta[11]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P12'], $pdf, 223, $pregunta[12]['respuesta']);

            /*Pagina 2*/
            $pdf->AddPage("P", "Letter");
            $pdf->setSourceFile(FCPATH . "/assets/formatos/cuestionarioGuia3.pdf");
            $template = $pdf->importPage(2);
            $pdf->useTemplate($template, -1, 0, 220, 280);
            $pdf->SetFont('Arial', 'B', 12);

            //B)
            $this->setEncuestaG3TableOption($evaluacion['eva_P13'], $pdf, 47, $pregunta[13]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P14'], $pdf, 57, $pregunta[14]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P15'], $pdf, 65, $pregunta[15]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P16'], $pdf, 73, $pregunta[16]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P17'], $pdf, 101, $pregunta[17]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P18'], $pdf, 110, $pregunta[18]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P19'], $pdf, 119, $pregunta[19]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P20'], $pdf, 128, $pregunta[20]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P21'], $pdf, 138, $pregunta[21]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P22'], $pdf, 148, $pregunta[22]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P23'], $pdf, 177.5, $pregunta[23]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P24'], $pdf, 183, $pregunta[24]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P25'], $pdf, 191, $pregunta[25]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P26'], $pdf, 201, $pregunta[26]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P27'], $pdf, 212, $pregunta[27]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P28'], $pdf, 223, $pregunta[28]['respuesta']);

            /*Pagina 3*/
            $pdf->AddPage("P", "Letter");
            $pdf->setSourceFile(FCPATH . "/assets/formatos/cuestionarioGuia3.pdf");
            $template = $pdf->importPage(3);
            $pdf->useTemplate($template, -1, 0, 220, 280);
            $pdf->SetFont('Arial', 'B', 12);

            //D
            $this->setEncuestaG3TableOption($evaluacion['eva_P29'], $pdf, 47, $pregunta[29]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P30'], $pdf, 55, $pregunta[30]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P31'], $pdf, 93, $pregunta[31]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P32'], $pdf, 102, $pregunta[32]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P33'], $pdf, 112, $pregunta[33]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P34'], $pdf, 121, $pregunta[34]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P35'], $pdf, 133, $pregunta[35]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P36'], $pdf, 144, $pregunta[36]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P37'], $pdf, 175, $pregunta[37]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P38'], $pdf, 185, $pregunta[38]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P39'], $pdf, 196, $pregunta[39]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P40'], $pdf, 209, $pregunta[40]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P41'], $pdf, 223, $pregunta[41]['respuesta']);

            /*Pagina 4*/
            $pdf->AddPage("P", "Letter");
            $pdf->setSourceFile(FCPATH . "/assets/formatos/cuestionarioGuia3.pdf");
            $template = $pdf->importPage(4);
            $pdf->useTemplate($template, -1, 0, 220, 280);
            $pdf->SetFont('Arial', 'B', 12);

            //C
            $this->setEncuestaG3TableOption($evaluacion['eva_P42'], $pdf, 45, $pregunta[42]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P43'], $pdf, 55, $pregunta[43]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P44'], $pdf, 64, $pregunta[44]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P45'], $pdf, 74, $pregunta[45]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P46'], $pdf, 85, $pregunta[46]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P47'], $pdf, 121, $pregunta[47]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P48'], $pdf, 130, $pregunta[48]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P49'], $pdf, 138, $pregunta[49]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P50'], $pdf, 146, $pregunta[50]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P51'], $pdf, 156, $pregunta[51]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P52'], $pdf, 167, $pregunta[52]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P53'], $pdf, 176, $pregunta[53]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P54'], $pdf, 183, $pregunta[54]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P55'], $pdf, 190, $pregunta[55]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P56'], $pdf, 197, $pregunta[56]['respuesta']);

            /*Pagina 5*/
            $pdf->AddPage("P", "Letter");
            $pdf->setSourceFile(FCPATH . "/assets/formatos/cuestionarioGuia3.pdf");
            $template = $pdf->importPage(5);
            $pdf->useTemplate($template, -1, 0, 220, 280);
            $pdf->SetFont('Arial', 'B', 12);

            //C
            $this->setEncuestaG3TableOption($evaluacion['eva_P57'], $pdf, 48, $pregunta[57]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P58'], $pdf, 57, $pregunta[58]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P59'], $pdf, 65, $pregunta[59]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P60'], $pdf, 76, $pregunta[60]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P61'], $pdf, 86, $pregunta[61]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P62'], $pdf, 96, $pregunta[62]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P63'], $pdf, 107, $pregunta[63]['respuesta']);
            $this->setEncuestaG3TableOption($evaluacion['eva_P64'], $pdf, 117, $pregunta[64]['respuesta']);

            //servicio a clientes
            if ($evaluacion['eva_Clientes'] == 'SI') {
                $yClientes = 138;
            } else {
                $yClientes = 144;
            }
            $pdf->SetXY(147, $yClientes);
            $pdf->Cell(3, 4, 'X', 0, 0, 'C');

            if ($evaluacion['eva_Clientes'] == 'SI') {
                $this->setEncuestaG3TableOption($evaluacion['eva_P65'], $pdf, 181, $pregunta[65]['respuesta']);
                $this->setEncuestaG3TableOption($evaluacion['eva_P66'], $pdf, 189, $pregunta[66]['respuesta']);
                $this->setEncuestaG3TableOption($evaluacion['eva_P67'], $pdf, 199, $pregunta[67]['respuesta']);
                $this->setEncuestaG3TableOption($evaluacion['eva_P68'], $pdf, 207, $pregunta[68]['respuesta']);
            }

            //jefe de otros
            if ($evaluacion['eva_Jefe'] == 'SI') {
                $yJefe = 219;
            } else {
                $yJefe = 225;
            }
            $pdf->SetXY(112, $yJefe);
            $pdf->Cell(3, 4, 'X', 0, 0, 'C');

            /*Pagina 6*/
            $pdf->AddPage("P", "Letter");
            $pdf->setSourceFile(FCPATH . "/assets/formatos/cuestionarioGuia3.pdf");
            $template = $pdf->importPage(6);
            $pdf->useTemplate($template, -1, 0, 220, 280);
            $pdf->SetFont('Arial', 'B', 12);

            if ($evaluacion['eva_Jefe'] == 'SI') {
                $this->setEncuestaG3TableOption($evaluacion['eva_P69'], $pdf, 37, $pregunta[69]['respuesta']);
                $this->setEncuestaG3TableOption($evaluacion['eva_P70'], $pdf, 43, $pregunta[70]['respuesta']);
                $this->setEncuestaG3TableOption($evaluacion['eva_P71'], $pdf, 49, $pregunta[71]['respuesta']);
                $this->setEncuestaG3TableOption($evaluacion['eva_P72'], $pdf, 55, $pregunta[72]['respuesta']);
            }
        }

        //Output
        $pdf->output('I', 'EvaluacionesGuia2.pdf');
        exit();
    }

    private function setEncuestaG3TableOption($estatus, $pdf, $y, $ordenRespuestas)
    {
        if ($ordenRespuestas < 1) {
            $posiciones = array(
                0 => 177.7,
                1 => 165,
                2 => 150,
                3 => 134,
                4 => 117,
            );
        } else {
            $posiciones = array(
                0 => 117,
                1 => 134,
                2 => 150,
                3 => 165,
                4 => 177.7,
            );
        }

        if ($estatus != '') {
            $x = $posiciones[$estatus];
            $pdf->SetXY($x, $y);
            $pdf->Cell(5, 4, 'x', 0, 0, 'C');
        } //if estatus
    }

    public function interpretacionG3CentroTrabajo($fInicio, $fFin, $sucursal)
    {
        $model = new PdfModel();
        $sucursal = encryptDecrypt('decrypt', $sucursal);
        $sucursalNombre = '';
        if ($sucursal > 0) {
            $sucursalNombre = ' (' . $this->db->query("SELECT suc_Sucursal FROM sucursal WHERE suc_SucursalID=?", array($sucursal))->getRowArray()['suc_Sucursal'] . ')';
        }
        $data = $model->getDominiosGuia3($fInicio, $fFin, $sucursal);

        $pdf = new Fpdi();
        $pdf->AddPage("P", "Letter");
        $pdf->setSourceFile(FCPATH . "/assets/formatos/resultadosg3centro.pdf");
        $template = $pdf->importPage(1);
        $pdf->useTemplate($template, -1, 0, 220, 280);
        $pdf->SetFont('Arial', 'B', 12);

        //Empresa
        $pdf->SetXY(20, 67);
        $empresa = $this->db->query("SELECT * FROM settings WHERE set_Key='nombre_empresa'")->getRowArray();
        $pdf->Cell(180, 4, utf8_decode($empresa['set_Value'] . $sucursalNombre), 0, 0, 'C');

        //Centro de trabajo
        $pdf->SetXY(20, 75);
        //$pdf->Cell(180, 4,utf8_decode($centro['cen_Nombre']), 0, 0, 'C');

        //Grafica
        $pdf->SetXY(10, 118);
        $url1 = FCPATH . "/assets/uploads/resultados/Nom035/GraficaIntG3.png";
        if (file_exists($url1)) $pdf->Cell(90, 80, $pdf->Image($url1, $pdf->GetX(), $pdf->GetY(), 190, 100), 0, 0, 'C', false);


        $pdf->SetFont('Arial', 'B', 7);
        $pdf->SetXY(10, 220);
        $pdf->MultiCell(18, 15, 'Riesgo', 1, 'C');

        $pdf->SetXY(28, 220);
        $pdf->MultiCell(18, 5, 'Condiciones del ambiente de trabajo', 1, 'C');

        $pdf->SetXY(46, 220);
        $pdf->MultiCell(18, 7.5, 'Carga de trabajo', 1, 'C');

        $pdf->SetXY(64, 220);
        $pdf->MultiCell(18, 5, 'Falta de control en el trabajo', 1, 'C');

        $pdf->SetXY(82, 220);
        $pdf->MultiCell(18, 7.5, 'Jornada de trabajo', 1, 'C');

        $pdf->SetXY(100, 220);
        $pdf->MultiCell(18, 5, 'Interf. en la relacion trab-fam', 1, 'C');

        $pdf->SetXY(118, 220);
        $pdf->MultiCell(18, 15, 'Liderazgo', 1, 'C');

        $pdf->SetXY(136, 220);
        $pdf->MultiCell(18, 7.5, 'Relaciones en el trabajo', 1, 'C');

        $pdf->SetXY(154, 220);
        $pdf->MultiCell(18, 15, 'Violencia', 1, 'C');

        $pdf->SetXY(172, 220);
        $pdf->MultiCell(18, 5, utf8_decode('Reconocimiento del desempeño'), 1, 'C');

        $pdf->SetXY(190, 220);
        $pdf->MultiCell(18, 5, 'Insuficiente sentido de pertenencia', 1, 'C');

        $pdf->SetFont('Arial', '', 8);

        $this->BasicTableG3($data, $pdf);

        //Output
        $pdf->output('I', 'ResultadosAplicacionG3.pdf');
        exit();
    }

    function BasicTableG3($data, $pdf)
    {

        $i = 1;
        // Data
        foreach ($data as $row) {
            $pdf->SetX(10);
            switch ($i) {
                case 1:
                    $titulo = 'Bajo ';
                    $pdf->SetFillColor(229, 229, 0);
                    $pdf->SetTextColor(255, 255, 255);
                    break;
                case 2:
                    $titulo = 'Medio';
                    $pdf->SetFillColor(45, 174, 82);
                    $pdf->SetTextColor(255, 255, 255);
                    break;
                case 3:
                    $titulo = 'Alto ';
                    $pdf->SetFillColor(255, 49, 49);
                    $pdf->SetTextColor(255, 255, 255);
                    break;
            }
            $pdf->Cell(18, 5, $titulo, 1, 0, 'C', 1);
            $pdf->SetTextColor(0, 0, 0);
            foreach ($row as $col)
                $pdf->Cell(18, 5, $col, 1);
            $pdf->Ln();
            $i++;
        }
    }
}
