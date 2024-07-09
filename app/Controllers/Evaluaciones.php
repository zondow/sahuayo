<?php

namespace App\Controllers;

defined('FCPATH') or exit('No direct script access allowed');

use App\Models\EvaluacionesModel;

class Evaluaciones extends BaseController
{

    const LOGIN_TYPE = 'usuario';

    /*
     __      _______  _____ _______        _____
     \ \    / /_   _|/ ____|__   __|/\    / ____|
      \ \  / /  | | | (___    | |  /  \  | (___
       \ \/ /   | |  \___ \   | | / /\ \  \___ \
        \  /   _| |_ ____) |  | |/ ____ \ ____) |
         \/   |_____|_____/   |_/_/    \_\_____/
    */

    //Lia->Vista para habilitar fechas de periodo de evaluacion
    public function periodoEvaluacion()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Período de evaluación';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index')),
            array("titulo" => 'Período de evaluación', "link" => base_url('Evaluaciones/periodoEvaluacion'))
        );

        //Styles
        $data['styles'][] = base_url('assets/libs/select2/select2.min.css');

        $data['styles'][] =  base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css');
        $data['styles'][] =  base_url('assets/libs/bootstrap-select/bootstrap-select.min.css');        //Styles
        $data['styles'][] =  base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] =  base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] =  base_url('assets/css/tables-custom.css');
        $data['styles'][] =  base_url('assets/libs/bootstrap-daterangepicker/daterangepicker.css');
        $data['styles'][] =  base_url("assets/plugins/sweetalert2/dist/sweetalert2.css");

        //Scripts
        $data['scripts'][] =  base_url('assets/libs/select2/select2.min.js');
        $data['scripts'][] =  base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js');
        $data['scripts'][] =  base_url('assets/libs/bootstrap-select/bootstrap-select.min.js');
        $data['scripts'][] =  base_url('assets/plugins/datatables/jquery.dataTables.min.js');
        $data['scripts'][] =  base_url('assets/plugins/datatables/DataTables-1.10.21/js/dataTables.bootstrap4.js');
        $data['scripts'][] =  base_url('assets/plugins/datatables/Buttons-1.6.2/js/dataTables.buttons.js');
        $data['scripts'][] =  base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.bootstrap4.js');
        $data['scripts'][] =  base_url('assets/plugins/datatables/JSZip-2.5.0/jszip.js');
        $data['scripts'][] =  base_url('assets/plugins/datatables/pdfmake-0.1.36/pdfmake.js');
        $data['scripts'][] =  base_url('assets/plugins/datatables/pdfmake-0.1.36/vfs_fonts.js');
        $data['scripts'][] =  base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.html5.js');
        $data['scripts'][] =  base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.colVis.js');
        $data['scripts'][] =  base_url('assets/libs/bootstrap-daterangepicker/daterangepicker.js');
        $data['scripts'][] =  base_url("assets/plugins/sweetalert2/dist/sweetalert2.min.js");

        $data['scripts'][] = base_url('assets/js/evaluaciones/periodoEvaluacion.js');
        //Vistas
        echo view('htdocs/header', $data);
        echo view('evaluaciones/formPeriodoEvaluacion');
        echo view('htdocs/footer');
    } //end periodoEvaluacion

    //Lia -> Vista donde se realiza la evaluacion nom035
    public function nom035()
    {
        validarSesion(self::LOGIN_TYPE);

        $empleadoID = session('id');

        $model = new EvaluacionesModel();
        $realizoEvaluacion = $model->evaluacionNom035Realizada($empleadoID);
        if ($realizoEvaluacion == false) {
            //Titulo
            $data['title'] = 'Evaluación Nom 035';
            $data['breadcrumb'] = array(
                array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "active"),
                array("titulo" => 'Evaluación Nom 035', "link" => base_url('Evaluaciones/nom035'), "class" => "active"),
            );

            $model = new EvaluacionesModel();
            $data['periodo'] = $model->getFechaEvaluacionNom035();
            $data['permitir'] = TRUE;
            $data['evaluadoID'] = encryptDecrypt('encrypt', $empleadoID);

            //Styles
            $data['styles'][] = base_url('assets/libs/select2/select2.min.css');

            //Scripts
            $data['scripts'][] = base_url('assets/libs/select2/select2.min.js');
            $data['scripts'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js');
            $data['scripts'][] = base_url('assets/js/evaluaciones/formGuia1.js');

            //Cargar vistas
            echo view('htdocs/header', $data);
            echo view('evaluaciones/formGuia1');
            echo view('htdocs/footer');
        } else {
            $totalEmpleados = $this->db->query("SELECT COUNT(emp_EmpleadoID) as 'empleados' FROM empleado WHERE emp_SucursalID=? AND emp_Estatus=1", array(session('sucursal')))->getRowArray()['empleados'];
            if ($totalEmpleados <= 50) {
                return redirect()->to(base_url("Evaluaciones/guia2/" . encryptDecrypt('encrypt', $empleadoID)));
            } else {
                return redirect()->to(base_url("Evaluaciones/guia3/" . encryptDecrypt('encrypt', $empleadoID)));
            }
        }
    } //end nom035

    //Diego -> Evaluacion Guia 2
    public function guia2($evaluadoID)
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        //Titulo
        $data['title'] = 'Guía 2';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "active"),
            array("titulo" => 'Evaluación Nom 035 (Guía 2)', "link" => base_url('Evaluaciones/guia3'), "class" => "active"),
        );

        $data['evaluadoID'] = $evaluadoID;
        $evaluado = encryptDecrypt('decrypt', $evaluadoID);
        $fecha = $this->db->query("SELECT * FROM evaluacion  WHERE eva_Tipo='Nom035' AND eva_Estatus=1 AND CURDATE() BETWEEN eva_FechaInicio AND eva_FechaFin ORDER BY eva_FechaRegistro DESC")->getRowArray();
        $data['evaluacion'] = $this->db->query("SELECT * FROM evaluaciong2  WHERE eva_EvaluadoID=? AND (eva_Fecha BETWEEN ? AND ? ) ORDER BY eva_EvaluacionG2 DESC", array($evaluado, $fecha['eva_FechaInicio'], $fecha['eva_FechaFin']))->getRowArray();

        //Styles
        $data['styles'][] = base_url('assets/libs/select2/select2.min.css');
        $data['styles'][] = base_url('assets/css/formGuia2.css');

        //Scripts
        $data['scripts'][] = base_url('assets/libs/select2/select2.min.js');
        $data['scripts'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('evaluaciones/formGuia2');
        echo view('htdocs/footer');
    } //end guia2

    //Diego -> Evaluacion Guia 3
    public function guia3($evaluadoID)
    {
        //Validar sessión
        //Titulo
        $data['title'] = 'Guía 3';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "active"),
            array("titulo" => 'Evaluación Nom 035 (Guía 3)', "link" => base_url('Evaluaciones/guia3/' . $evaluadoID), "class" => "active"),
        );

        $data['evaluadoID'] = $evaluadoID;
        $evaluado = encryptDecrypt('decrypt', $evaluadoID);

        $fecha = $this->db->query("SELECT * FROM evaluacion  WHERE eva_Tipo='Nom035' AND eva_Estatus=1 AND CURDATE() BETWEEN eva_FechaInicio AND eva_FechaFin ORDER BY eva_FechaRegistro DESC")->getRowArray();
        $data['evaluacion'] = $this->db->query("SELECT * FROM evaluaciong3  WHERE eva_EvaluadoID=? AND (eva_Fecha BETWEEN ? AND ? ) ORDER BY eva_EvaluacionG3 DESC", array($evaluado, $fecha['eva_FechaInicio'], $fecha['eva_FechaFin']))->getRowArray();

        //Styles
        $data['styles'][] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/css/fileinput.css"; //Bootstrap FileInput
        $data['styles'][] = base_url('assets/libs/select2/select2.min.css');
        $data['styles'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css');
        $data['styles'][] = base_url('assets/libs/lightbox/css/lightbox.css');
        $data['styles'][] = base_url('assets/libs/custombox/custombox.min.css');
        $data['styles'][] = base_url('assets/libs/datatables/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/libs/datatables/responsive.bootstrap4.css');
        $data['styles'][] = base_url('assets/css/formGuia2.css');

        //Scripts
        $data['scripts'][] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/fileinput.js"; //Bootstrap FileInput
        $data['scripts'][] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/locales/es.js"; //Bootstrap FileInput Spanish
        $data['scripts'][] = base_url('assets/libs/select2/select2.min.js');
        $data['scripts'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js');
        $data['scripts'][] = base_url("assets/js/pages/bootstrap-filestyle.min.js");
        $data['scripts'][] = base_url('assets/libs/lightbox/js/lightbox.js');
        $data['scripts'][] = base_url('assets/libs/custombox/custombox.min.js');
        $data['scripts'][] = base_url('assets/libs/datatables/jquery.dataTables.min.js');
        $data['scripts'][] = base_url('assets/libs/datatables/dataTables.bootstrap4.min.js');
        $data['scripts'][] = base_url('assets/libs/datatables/dataTables.responsive.min.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('evaluaciones/formGuia3');
        echo view('htdocs/footer');
    } //end guia3

    //Diego->resultados guia I
    public function resultadosGuiaI($fInicio = null, $fFin = null, $sucursal = null)
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        //Titulo
        $data['title'] = 'Resultados guia I';
        //Breadcrumbs
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Resultados guia I', "link" => base_url('Evaluaciones/resultadosGuiaI'), "class" => "active"),
        );
        $data['url'] = '';
        $data['style'] = '';
        $model = new EvaluacionesModel();
        $data['sucursales'] = $model->getSucursales();
        if ($fInicio !== null && $fFin !== null && $sucursal !== null) {
            $data['url'] = base_url() . "/PDF/evaluacionesGuiaI/$fInicio/$fFin/$sucursal";
        } else {
            $data['style'] = 'style="display:none !important"';
        }

        $data['FechaInicio'] = $fInicio;
        $data['FechaFin'] = $fFin;
        $data['SucursalID'] = $sucursal;

        //Styles
        $data['styles'][] = base_url('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css');
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');
        $data['styles'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css');
        $data['styles'][] = base_url('assets/libs/bootstrap-daterangepicker/daterangepicker.css');

        //Scripts
        $data['scripts'][] = base_url('assets/plugins/momentjs/moment-with-locales.js');
        $data['scripts'][] = base_url('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/jquery.dataTables.min.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/js/dataTables.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/dataTables.buttons.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/JSZip-2.5.0/jszip.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/pdfmake.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/vfs_fonts.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.html5.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.colVis.js');
        $data['scripts'][] = 'https://cdn.datatables.net/fixedcolumns/3.2.6/js/dataTables.fixedColumns.min.js';
        $data['scripts'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js');
        $data['scripts'][] = base_url('assets/libs/bootstrap-daterangepicker/daterangepicker.js');
        $data['scripts'][] = base_url('assets/js/evaluaciones/guia1.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('evaluaciones/resultadosGuiaI');
        echo view('htdocs/footer');
    } //end resultadosGuiaI

    //Diego->resultados guia I
    public function resultadosGuiaII($fInicio = null, $fFin = null, $sucursal = null)
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        //Titulo
        $data['title'] = 'Resultados guia II';
        //Breadcrumbs
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Resultados guia II', "link" => base_url('Evaluaciones/resultadosGuiaII'), "class" => "active"),
        );
        $data['url'] = '';
        $data['style'] = '';
        $model = new EvaluacionesModel();
        $data['sucursales'] = $model->getSucursales();
        if ($fInicio !== null && $fFin !== null && $sucursal !== null) {
            $data['url'] = base_url() . "/PDF/evaluacionesGuiaII/" . $fInicio . "/" . $fFin . "/" . $sucursal;
            $model = new EvaluacionesModel();
            $data['calificacionFinal'] = $model->getCF($fInicio, $fFin, $sucursal);
            $data['dominio'] = $model->getDominios($fInicio, $fFin, $sucursal);
        } else {
            $data['style'] = 'style="display:none !important"';
            $data['calificacionFinal'] = 0;
            $data['dominio'] = ["ambienteTrabajo" => 0, "cargaTrabajo" => 0, "faltaControl" => 0, "jornadaTrabajo" => 0, "interferencia" => 0, "liderazgo" => 0, "relacionTrabajo" => 0, "violencia" => 0];
        }
        $data['FechaInicio'] = $fInicio;
        $data['FechaFin'] = $fFin;
        $data['SucursalID'] = $sucursal;

        //Styles
        $data['styles'][] = base_url('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css');
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');
        $data['styles'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css');
        $data['styles'][] = base_url('assets/libs/bootstrap-daterangepicker/daterangepicker.css');
        $data['styles'][] = base_url('assets/css/formGuia2.css');

        //Scripts
        $data['scripts'][] = base_url('assets/plugins/momentjs/moment-with-locales.js');
        $data['scripts'][] = base_url('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/jquery.dataTables.min.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/js/dataTables.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/dataTables.buttons.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/JSZip-2.5.0/jszip.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/pdfmake.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/vfs_fonts.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.html5.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.colVis.js');
        $data['scripts'][] = 'https://cdn.datatables.net/fixedcolumns/3.2.6/js/dataTables.fixedColumns.min.js';
        $data['scripts'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js');
        $data['scripts'][] = base_url('assets/libs/bootstrap-daterangepicker/daterangepicker.js');
        $data['scripts'][] = base_url('assets/libs/jquery-knob/jquery.knob.min.js');
        //chartjs
        $data['scripts'][] = base_url('assets/libs/chart-js/Chart.bundle.min.js');
        $data['scripts'][] = base_url('assets/js/evaluaciones/guia2.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('evaluaciones/resultadosGuia2');
        echo view('htdocs/footer');
    } //end resultadosGuia2

    //Diego -> resultados guia 2
    public function resultadoEvaluadoGuia2($evaluadoID, $fInicio, $fFin)
    {
        //Data
        $evaluado = encryptDecrypt('decrypt', $evaluadoID);
        $model = new EvaluacionesModel();
        $infoEvaluado = $model->getInfoEvaluado($evaluado);
        $data['dominio'] = $model->getDominiosByEvaluado($evaluado, $fInicio, $fFin);

        $data['title'] = 'Resultado de ' . $infoEvaluado['emp_Nombre'];
        $data['breadcrumb'] = array(
            array('titulo' => 'Inicio', 'link' => base_url('Usuario/index'), 'class' => ''),
            array('titulo' => 'Resultados guia II', 'link' => base_url('Evaluaciones/resultadosGuiaII/' . $fInicio . "/" . $fFin), 'class' => ''),
            array('titulo' => strtoupper($infoEvaluado['emp_Nombre']), 'link' => base_url('Evaluaciones/resultadoEvaluadoGuia2/' . $evaluadoID . "/" . $fInicio . "/" . $fFin), 'class' => 'active'),
        );

        //Styles
        $data['styles'][] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/css/fileinput.css"; //Bootstrap FileInput
        $data['styles'][] = base_url('assets/libs/select2/select2.min.css');
        $data['styles'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css');
        $data['styles'][] = base_url('assets/libs/lightbox/css/lightbox.css');
        $data['styles'][] = base_url('assets/libs/custombox/custombox.min.css');
        $data['styles'][] = base_url('assets/libs/datatables/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/libs/datatables/responsive.bootstrap4.css');
        $data['styles'][] = base_url('assets/css/formGuia2.css');

        //Scripts
        $data['scripts'][] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/fileinput.js"; //Bootstrap FileInput
        $data['scripts'][] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/locales/es.js"; //Bootstrap FileInput Spanish
        $data['scripts'][] = base_url('assets/libs/select2/select2.min.js');
        $data['scripts'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js');
        $data['scripts'][] = base_url("assets/js/pages/bootstrap-filestyle.min.js");
        $data['scripts'][] = base_url('assets/libs/lightbox/js/lightbox.js');
        $data['scripts'][] = base_url('assets/libs/custombox/custombox.min.js');
        $data['scripts'][] = base_url('assets/libs/datatables/jquery.dataTables.min.js');
        $data['scripts'][] = base_url('assets/libs/datatables/dataTables.bootstrap4.min.js');
        $data['scripts'][] = base_url('assets/libs/datatables/dataTables.responsive.min.js');

        echo view("htdocs/header", $data);
        echo view("evaluaciones/resultadoEvaluadoGuia2");
        echo view("htdocs/footer");
    } //

    //Diego->resultados guia III
    public function resultadosGuiaIII($fInicio = null, $fFin = null, $sucursal = null)
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        //Titulo
        $data['title'] = 'Resultados guia III';
        //Breadcrumbs
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Resultados guia III', "link" => base_url('Evaluaciones/resultadosGuiaIII'), "class" => "active"),
        );

        $model = new EvaluacionesModel();
        $data['sucursales'] = $model->getSucursales();
        $data['url'] = '';
        $data['style'] = '';
        if ($fInicio !== null && $fFin !== null) {
            $data['url'] = base_url() . "/PDF/evaluacionesGuiaIII/" . $fInicio . "/" . $fFin . "/" . $sucursal;
            $model = new EvaluacionesModel();
            $data['calificacionFinal'] = $model->getCFG3($fInicio, $fFin, $sucursal);
            $data['dominio'] = $model->getDominiosG3($fInicio, $fFin, $sucursal);
        } else {
            $data['style'] = 'style="display:none !important"';
            $data['calificacionFinal'] = 0;
            $data['dominio'] = array("ambienteTrabajo" => 0, "cargaTrabajo" => 0, "faltaControl" => 0, "jornadaTrabajo" => 0, "interferencia" => 0, "liderazgo" => 0, "relacionTrabajo" => 0, "violencia" => 0, "reconocimiento" => 0, "insuficiente" => 0);
        }
        $data['FechaInicio'] = $fInicio;
        $data['FechaFin'] = $fFin;
        $data['SucursalID'] = $sucursal;

        //Styles
        $data['styles'][] = base_url('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css');
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');
        $data['styles'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css');
        $data['styles'][] = base_url('assets/libs/bootstrap-daterangepicker/daterangepicker.css');
        $data['styles'][] = base_url('assets/css/formGuia2.css');

        //Scripts
        $data['scripts'][] = base_url('assets/plugins/momentjs/moment-with-locales.js');
        $data['scripts'][] = base_url('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/jquery.dataTables.min.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/js/dataTables.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/dataTables.buttons.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/JSZip-2.5.0/jszip.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/pdfmake.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/vfs_fonts.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.html5.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.colVis.js');
        $data['scripts'][] = 'https://cdn.datatables.net/fixedcolumns/3.2.6/js/dataTables.fixedColumns.min.js';
        $data['scripts'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js');
        $data['scripts'][] = base_url('assets/libs/bootstrap-daterangepicker/daterangepicker.js');
        $data['scripts'][] = base_url('assets/libs/jquery-knob/jquery.knob.min.js');
        //chartjs
        $data['scripts'][] = base_url('assets/libs/chart-js/Chart.bundle.min.js');

        $data['scripts'][] = base_url('assets/js/evaluaciones/guia3.js');
        //$data['scripts'][] = base_url('assets/js/evaluaciones/grafica.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('evaluaciones/resultadosGuia3');
        echo view('htdocs/footer');
    }

    //Diego -> resultados guia 3
    public function resultadoEvaluadoGuia3($evaluadoID, $fInicio, $fFin)
    {
        //Data
        $evaluado = encryptDecrypt('decrypt', $evaluadoID);
        $model = new EvaluacionesModel();
        $infoEvaluado = $model->getInfoEvaluado($evaluado);
        $data['dominio'] = $model->getDominiosG3ByEvaluado($evaluado, $fInicio, $fFin);

        $data['title'] = 'Resultado de ' . $infoEvaluado['emp_Nombre'];
        $data['breadcrumb'] = array(
            array('titulo' => 'Inicio', 'link' => base_url('Usuario/index'), 'class' => ''),
            array('titulo' => 'Resultados guia II', 'link' => base_url('Evaluaciones/resultadosGuiaII/' . $fInicio . "/" . $fFin), 'class' => ''),
            array('titulo' => strtoupper($infoEvaluado['emp_Nombre']), 'link' => base_url('Evaluaciones/resultadoEvaluadoGuia2/' . $evaluadoID . "/" . $fInicio . "/" . $fFin), 'class' => 'active'),
        );

        //Styles
        $data['styles'][] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/css/fileinput.css"; //Bootstrap FileInput
        $data['styles'][] = base_url('assets/libs/select2/select2.min.css');
        $data['styles'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css');
        $data['styles'][] = base_url('assets/libs/lightbox/css/lightbox.css');
        $data['styles'][] = base_url('assets/libs/custombox/custombox.min.css');
        $data['styles'][] = base_url('assets/libs/datatables/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/libs/datatables/responsive.bootstrap4.css');
        $data['styles'][] = base_url('assets/css/formGuia2.css');

        //Scripts
        $data['scripts'][] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/fileinput.js"; //Bootstrap FileInput
        $data['scripts'][] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/locales/es.js"; //Bootstrap FileInput Spanish
        $data['scripts'][] = base_url('assets/libs/select2/select2.min.js');
        $data['scripts'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js');
        $data['scripts'][] = base_url("assets/js/pages/bootstrap-filestyle.min.js");
        $data['scripts'][] = base_url('assets/libs/lightbox/js/lightbox.js');
        $data['scripts'][] = base_url('assets/libs/custombox/custombox.min.js');
        $data['scripts'][] = base_url('assets/libs/datatables/jquery.dataTables.min.js');
        $data['scripts'][] = base_url('assets/libs/datatables/dataTables.bootstrap4.min.js');
        $data['scripts'][] = base_url('assets/libs/datatables/dataTables.responsive.min.js');

        echo view("htdocs/header", $data);
        echo view("evaluaciones/resultadoEvaluadoGuia3");
        echo view("htdocs/footer");
    } //

    //Lia -> vista para la evaluacion de clima laboral
    public function evaluacionClimaLaboral($empleadoID = null)
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        //Titulo
        $data['title'] = 'Evaluación de clima laboral';
        //Breadcrumbs
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "active"),
            array("titulo" => 'Evaluación de clima laboral', "link" => base_url('Evaluaciones/evaluacionClimaLaboral/' . session('id')), "class" => "active"),
        );

        if (is_null($empleadoID)) {
            $model = new EvaluacionesModel();
            $data['fechaEstatus'] = $model->getFechaEvaluacionClimaLaboral();

            $realizada = $model->evaluacionClimaLaboralRealizada(session('id'));
            $data['permitir'] = (is_null($realizada)) ? true : false;
            $data['empleadoID'] = session('id');
        }

        //Styles
        $data['styles'][] = base_url('assets/libs/barrating/cropper.min.css');
        $data['styles'][] = base_url('assets/libs/barrating/bars-movie.css');
        //Scripts
        $data['scripts'][] = base_url('assets/libs/barrating/jquery.barrating.min.js');
        $data['scripts'][] = base_url('assets/libs/barrating/cropper.min.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('evaluaciones/climaLaboral');
        echo view('htdocs/footer');
    }

    //Lia-> Resultados del clima laboral
    public function resultadosClimaLaboral()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        //Titulo
        $data['title'] = 'Resultados de la evaluación';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Resultados', "link" => base_url('Evaluaciones/resultadosClimaLaboral'), "class" => "active"),
        );

        $model = new EvaluacionesModel();
        $data['sucursales'] = $model->getSucursales();

        //Calcular resultados
        if (!empty($_POST)) {
            $data['f1'] = post("fechaInicio");
            $data['f2'] = post("fechaFin");
            $data['sucursal'] = post("sucursal");
            $data['sucursalNombre'] = db()->query("SELECT suc_Sucursal FROM sucursal WHERE suc_SucursalID=?", array(encryptDecrypt('decrypt', post("sucursal"))))->getRowArray()['suc_Sucursal'] ?? null;
            $data['result'] =  $model->getAllCalificacionForClimaLaboral($data['f1'], $data['f2'], $data['sucursal']);
        }

        //Scripts
        $data['scripts'][] = base_url('assets/js/modalPdf.js');
        //Datepicker
        $data['styles'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css');
        $data['styles'][] = base_url('assets/libs/bootstrap-daterangepicker/daterangepicker.css');
        $data['scripts'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js');
        $data['scripts'][] = base_url('assets/libs/bootstrap-daterangepicker/daterangepicker.js');


        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('evaluaciones/resultadosClimaLaboral');
        echo view('htdocs/modalPdf');
        echo view('htdocs/footer');
    } //end resultadosClimaLaboral

    //Diego -> desempeño 270
    public function empleadosDesempeno270()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Evaluación de desempeño';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Evaluación de desempeño', "link" => base_url('Evaluaciones/empleadosDesempeno270'), "class" => "active"),
        );

        //Obtener datos jefe, compañeros y bubordinados
        $data['empleadoID'] = (int)session('id');
        $model = new EvaluacionesModel();
        $data['empleados'] = $model->getEmpleadosByEmpleadoEvaluacion270($data['empleadoID']);

        //Styles
        $data['styles'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css');
        $data['styles'][] = base_url('assets/libs/select2/css/select2.min.css');
        $data['styles'][] = base_url('assets/libs/custombox/custombox.min.css');

        //Scripts
        $data['scripts'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js');
        $data['scripts'][] = base_url('assets/libs/select2/js/select2.full.min.js');
        $data['scripts'][] = base_url('assets/libs/custombox/custombox.min.js');
        $data['scripts'][] = base_url('assets/js/modalConfirmation.js');


        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('evaluaciones/empleadosEvaluacion270', $data);
        echo view('htdocs/modalConfirmation', $data);
        echo view('htdocs/footer', $data);
    }

    //Diego -> Vista donde se realiza la evaluacion de 270
    public function desempeno270($empleadoID)
    {

        validarSesion(self::LOGIN_TYPE);
        $empleadoID = encryptDecrypt('decrypt', $empleadoID);

        $model = new EvaluacionesModel();
        $data['empleadoInfo'] = $model->getEmpleadoInfo($empleadoID);

        //Titulo
        $data['title'] = 'Evaluación de desempeño';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "active"),
            array("titulo" => 'Evaluación de desempeño', "link" => base_url('Evaluaciones/empleadosDesempeno270'), "class" => "active"),
            array("titulo" => $data['empleadoInfo']['emp_Nombre'], "link" => base_url('Evaluaciones/desempeno270/' . encryptDecrypt('encrypt', $empleadoID)), "class" => "active"),
        );

        $data['periodo'] = $model->getFechaEvaluacionDesempenoV2();

        $evaluadorID = session('id');

        //if(!is_null($data['periodo'])){
        $realizada = $model->evaluacionDesempeno270Realizada($evaluadorID, $empleadoID);
        $data['permitir'] = (is_null($realizada)) ? true : false;
        $data['puestoInfo'] = $model->getPuestoInfoByEmpleado($empleadoID);
        $data['funciones'] = $model->getFunciones($data['puestoInfo']['pue_PuestoID']);
        $data['empleadoID'] = $empleadoID;
        $data['evaluadorID'] = $evaluadorID;
        //}

        //Styles
        $data['styles'][] = base_url('assets/libs/ion-rangeslider/ion.rangeSlider.css');
        //Scripts
        $data['scripts'][] = base_url('assets/libs/ion-rangeslider/ion.rangeSlider.min.js');
        //$data['scripts'][] = base_url('assets/js/pages/range-sliders.init.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('evaluaciones/desempeno270', $data);
        echo view('htdocs/footer');
    }

    //Lia -> resultados evaluacion de desempeño 270 periodos
    public function resultadosDesempeno270($empleadoID = null)
    {
        validarSesion(self::LOGIN_TYPE);
        if (!is_null($empleadoID)) {
            $sql = "SELECT COUNT(*) AS 'contador'
                FROM empleado
                WHERE emp_EmpleadoID=? ";
            $emp = $this->db->query($sql, array('emp_EmpleadoID' => $empleadoID))->getRowArray();
            if ($emp['contador'] == 0) {

                return  redirect()->to($_SERVER['HTTP_REFERER']);
            }
        }

        //Titulo
        $data['title'] = 'Resultados de desempeño';
        //Breadcrumbs
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Resultados de desempeño', "link" => base_url('Evaluaciones/resultadosDesempeno270'), "class" => "active"),
        );

        $data['empleadoID'] = $empleadoID;
        $model = new EvaluacionesModel();
        $data['empleados'] = $model->getEmpleados();

        //Styles
        $data['styles'][] = base_url('assets/libs/select2/select2.min.css');
        $data['styles'][] = base_url('assets/libs/datatables/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/libs/datatables/responsive.bootstrap4.css');
        //Scripts
        $data['scripts'][] = base_url('assets/libs/select2/select2.min.js');
        $data['scripts'][] = base_url('assets/libs/datatables/jquery.dataTables.min.js');
        $data['scripts'][] = base_url('assets/libs/datatables/dataTables.bootstrap4.min.js');
        $data['scripts'][] = base_url('assets/libs/datatables/dataTables.responsive.min.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('evaluaciones/resultadosDesempeno270');
        echo view('htdocs/footer');
    } //end resultadosDesempeno270

    //Diego -> resultado evaluacion de desempeño 270 por empleado en un periodo
    public function resultadoDesempeno270($periodoID, $empleadoID, $vista = null)
    {
        validarSesion(self::LOGIN_TYPE);

        $model = new EvaluacionesModel();
        $empleado = $model->getEmpleadoInfo($empleadoID);
        $periodoInfo = $model->getPeriodoInfo($periodoID);
        $resultados = $model->getDesempeno270ByEmpleadoPeriodo($periodoID, $empleadoID);

        //Titulo
        $data['title'] = 'Resultados de la evaluación de desempeño 270';

        if (is_null($vista)) {
            //Breadcrumbs
            $data['breadcrumb'] = array(
                array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
                array("titulo" => 'Resultados por puesto', "link" => base_url('Evaluaciones/resultadosEvaluacionDesCom'), "class" => ""),
                array("titulo" => $empleado['emp_Nombre'] . ' ', "link" => base_url('Evaluaciones/resultadoDesempeno270/' . $periodoID . '/' . $empleadoID), "class" => "active"),
            );
        } else {
            //Breadcrumbs
            $data['breadcrumb'] = array(
                array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
                array("titulo" => 'Resultados desempeño', "link" => base_url('Evaluaciones/resultadosDesempeno270'), "class" => ""),
                array("titulo" => $empleado['emp_Nombre'] . ' ', "link" => base_url('Evaluaciones/resultadoDesempeno270/' . $periodoID . '/' . $empleadoID), "class" => "active"),
            );
        }

        $data['empleado'] = $empleado;
        $data['periodoInfo'] = $periodoInfo;
        $data['resultados'] = $resultados;
        $data['periodoID'] = $periodoID;

        //Styles
        $data['styles'][] = base_url('assets/libs/select2/select2.min.css');
        $data['styles'][] = base_url('assets/libs/datatables/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/libs/datatables/responsive.bootstrap4.css');
        //Scripts
        $data['scripts'][] = base_url('assets/libs/select2/select2.min.js');
        $data['scripts'][] = base_url('assets/libs/datatables/jquery.dataTables.min.js');
        $data['scripts'][] = base_url('assets/libs/datatables/dataTables.bootstrap4.min.js');
        $data['scripts'][] = base_url('assets/libs/datatables/dataTables.responsive.min.js');
        $data['scripts'][] = base_url('assets/libs/chart-js/Chart.bundle.min.js');
        $data['scripts'][] = base_url('assets/js/evaluaciones/modalResultadoDesempeno.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('evaluaciones/resultadoDesempeno270Empleado');
        echo view('htdocs/footer');
    } //end resultadosDesempeno270

    //Lia -> vista de colaboradores para la evaluacion de competencias
    public function empleadosCompetencia()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Evaluar competencias';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Evaluar competencias', "link" => base_url('Evaluaciones/empleadosCompetencia'), "class" => "active"),
        );

        //Obtener datos jefe, compañeros y bubordinados
        $empleadoID = (int)session('id');
        $model = new EvaluacionesModel();
        $data['empleados'] = $model->getEmpleadosByEmpleadoEvaluacionComp($empleadoID);
        $data['empleadoID'] = encryptDecrypt('encrypt', $empleadoID);

        //Styles
        $data['styles'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css');
        $data['styles'][] = base_url('assets/libs/select2/css/select2.min.css');
        $data['styles'][] = base_url('assets/libs/custombox/custombox.min.css');

        //Scripts
        $data['scripts'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js');
        //$data['scripts'][] = base_url('assets/js/modalColaborador.js');
        $data['scripts'][] = base_url('assets/libs/select2/js/select2.full.min.js');
        $data['scripts'][] = base_url('assets/libs/custombox/custombox.min.js');
        $data['scripts'][] = base_url('assets/js/modalConfirmation.js');


        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('evaluaciones/empleadosEvaluacionComp');
        echo view('htdocs/footer');
    }

    //-> Lia-> vista para la evaluacion de competencias
    public function competencias($empleadoID)
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        //Titulo
        $data['title'] = 'Evaluación de competencias';
        //Breadcrumbs
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Evaluar competencias', "link" => base_url('Evaluaciones/empleadosCompetencia'), "class" => ""),
            array("titulo" => 'Evaluación de competencias', "link" => base_url('Evaluaciones/competencias/' . $empleadoID), "class" => "active"),
        );
        $empleadoID = encryptDecrypt('decrypt', $empleadoID);
        $model = new EvaluacionesModel();
        if ($empleadoID) {
            $fecha = $model->getFechaEvaluacionCompetencia();
            $data['fechaEstatus'] = (int)$fecha['eva_EvaluacionID'];

            if ((int)$fecha['eva_EvaluacionID'] > 0) {

                $realizada = $model->evaluacionCompetenciaRealizada(encryptDecrypt('encrypt', session('id')));
                $data['permitir'] = (is_null($realizada)) ? true : false;

                $sql = "SELECT * FROM puesto WHERE pue_PuestoID=?";
                $data['puestoInfo'] = $this->db->query($sql, array(session('puesto')))->getRowArray();
                $data['competencias'] = $model->getCompetencias(session('puesto'));
                $data['empleadoID'] = encryptDecrypt('encrypt', session('id'));
            }
        }

        //Styles
        $data['styles'][] = base_url('assets/libs/ion-rangeslider/ion.rangeSlider.css');
        //Scripts
        $data['scripts'][] = base_url('assets/libs/ion-rangeslider/ion.rangeSlider.min.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('evaluaciones/competencias', $data);
        echo view('htdocs/footer');
    }

    //-> Lia-> vista para la evaluacion de competencias del jefe
    public function competenciasJefe($empleadoID, $evaluacionID)
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        //Titulo
        $data['title'] = 'Evaluación de competencias';
        //Breadcrumbs
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Empleados evaluacion', "link" => base_url('Evaluaciones/empleadosCompetencia'), "class" => ""),
            array("titulo" => 'Evaluación de competencias', "link" => base_url('Evaluaciones/competenciasJefe/' . $empleadoID . "/" . $evaluacionID), "class" => "active"),
        );

        //$empleadoID=encryptDecrypt('decrypt',$empleadoID);
        //$evaluacionID=encryptDecrypt('decrypt',$evaluacionID);
        $model = new EvaluacionesModel();
        if ($empleadoID) {
            $fecha = $model->getFechaEvaluacionCompetencia();
            $data['fechaEstatus'] = (int)$fecha['eva_EvaluacionID'];

            if ((int)$fecha['eva_EvaluacionID'] > 0) {

                $realizada = $model->evaluacionCompetenciaRealizadaJefe($empleadoID);
                $data['permitir'] = (is_null($realizada)) ? true : false;

                $empleado = $this->db->query("SELECT emp_PuestoID FROM empleado WHERE emp_EmpleadoID=" . encryptDecrypt('decrypt', $empleadoID))->getRowArray();
                $sql = "SELECT * FROM puesto WHERE pue_PuestoID=?";
                $data['puestoInfo'] = $this->db->query($sql, array($empleado['emp_PuestoID']))->getRowArray();
                $data['competencias'] = $model->getCompetencias($empleado['emp_PuestoID']);
                $data['empleadoID'] = $empleadoID;
                $data['jefeID'] = session('id');
                $data['evaluacionID'] = $evaluacionID;
            }
        }

        //Styles
        $data['styles'][] = base_url('assets/libs/ion-rangeslider/ion.rangeSlider.css');
        //Scripts
        $data['scripts'][] = base_url('assets/libs/ion-rangeslider/ion.rangeSlider.min.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('evaluaciones/competenciasJefe', $data);
        echo view('htdocs/footer');
    }

    //Lia -> resultados evaluacion de comeptencias
    public function resultadosCompetencias($empleadoID = null)
    {
        validarSesion(self::LOGIN_TYPE);
        if (!is_null($empleadoID)) {
            $emp = $this->db->query("SELECT COUNT(*) AS 'contador' FROM empleado WHERE emp_EmpleadoID=? ", array('emp_EmpleadoID' => $empleadoID))->getRowArray();
            if ($emp['contador'] == 0) {
                redirect(base_url('Evaluaciones/resultadosCompetencias'));
            }
        }

        //Titulo
        $data['title'] = 'Resultados de competencias';
        //Breadcrumbs
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Resultados de competencias', "link" => base_url('Evaluaciones/resultadosCompetencias'), "class" => "active"),
        );

        $data['empleadoID'] = $empleadoID;
        $model = new EvaluacionesModel();
        $data['empleados'] = $model->getEmpleados();

        //Styles
        $data['styles'][] = base_url('assets/libs/select2/select2.min.css');
        $data['styles'][] = base_url('assets/libs/datatables/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/libs/datatables/responsive.bootstrap4.css');
        //Scripts
        $data['scripts'][] = base_url('assets/libs/select2/select2.min.js');
        $data['scripts'][] = base_url('assets/libs/datatables/jquery.dataTables.min.js');
        $data['scripts'][] = base_url('assets/libs/datatables/dataTables.bootstrap4.min.js');
        $data['scripts'][] = base_url('assets/libs/datatables/dataTables.responsive.min.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('evaluaciones/resultadosCompetencias');
        echo view('htdocs/footer');
    } //end resultadosCompetencias

    //Lia -> resultados evaluacion por competencias del colaborador
    public function resultadosCompetenciaEmpleadoCH($evaluacionCompetenciasID = null, $vista = null)
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $model = new EvaluacionesModel();
        $evaluacion = $model->getInfoEvComp(encryptDecrypt('decrypt', $evaluacionCompetenciasID));
        $empleadoID = $evaluacion['evac_EmpleadoID'];
        $fecha = $evaluacion['evac_Fecha'];
        $empleado = $model->getEmpleadoInfo($empleadoID);
        //Titulo
        $data['title'] = 'Resultados de competencia';
        if ($vista === null) {
            //Breadcrumbs
            $data['breadcrumb'] = array(
                array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "active"),
                array("titulo" => 'Resultados por puesto', "link" => base_url('Evaluaciones/resultadosEvaluacionDesCom'), "class" => ""),
                array("titulo" => $empleado['emp_Nombre'], "link" => base_url('Evaluaciones/resultadosCompetenciaEmpleadoCH/' . $evaluacionCompetenciasID), "class" => "active"),
            );
        } else {
            //Breadcrumbs
            $data['breadcrumb'] = array(
                array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "active"),
                array("titulo" => 'Resultados competencia', "link" => base_url('Evaluaciones/resultadosCompetencias'), "class" => ""),
                array("titulo" => $empleado['emp_Nombre'], "link" => base_url('Evaluaciones/resultadosCompetenciaEmpleadoCH/' . $evaluacionCompetenciasID), "class" => "active"),
            );
        }

        //Scripts
        $data['scripts'][] = base_url('assets/libs/chart-js/Chart.bundle.min.js');

        $data['lastEC'] = $model->getLastEvaluacionCompetenciasByEmpleadoFecha($empleadoID, $fecha);
        $data['empleado'] = $empleado;
        if (!empty($data['lastEC']['evac_JefeID'])) {
            $data['jefe'] = $this->db->query("SELECT * FROM empleado JOIN puesto ON pue_PuestoID=emp_PuestoID WHERE emp_EmpleadoID=" . $data['lastEC']['evac_JefeID'])->getRowArray();
        }
        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('evaluaciones/resultadosCompetenciaEmpleado');
        echo view('htdocs/footer');
    } // end resultados_competencia

    /*
      ______ _    _ _   _  _____ _____ ____  _   _ ______  _____
     |  ____| |  | | \ | |/ ____|_   _/ __ \| \ | |  ____|/ ____|
     | |__  | |  | |  \| | |      | || |  | |  \| | |__  | (___
     |  __| | |  | | . ` | |      | || |  | | . ` |  __|  \___ \
     | |    | |__| | |\  | |____ _| || |__| | |\  | |____ ____) |
     |_|     \____/|_| \_|\_____|_____\____/|_| \_|______|_____/
    */


    //Diego -> guardar guia 1
    public function addGuia1()
    {
        $post = $this->request->getPost();

        $evaluado = encryptDecrypt('decrypt', $post['evaluado']);
        $data = array(
            "eva_Fecha" => $post['fechaActual'],
            "eva_EvaluadoID" => $evaluado,
            "eva_ATS" => $post['rdoATS_ATS'],
        );
        if ($post['rdoATS_ATS'] === 'SI') {
            $data += array(
                "eva_Recuerdos1" => $post['rdoATS_REC1'],
                "eva_Recuerdos2" => $post['rdoATS_REC2'],
                "eva_Esfuerzo1" => $post['rdoATS_ESF1'],
                "eva_Esfuerzo2" => $post['rdoATS_ESF2'],
                "eva_Esfuerzo3" => $post['rdoATS_ESF3'],
                "eva_Esfuerzo4" => $post['rdoATS_ESF4'],
                "eva_Esfuerzo5" => $post['rdoATS_ESF5'],
                "eva_Esfuerzo6" => $post['rdoATS_ESF6'],
                "eva_Esfuerzo7" => $post['rdoATS_ESF7'],
                "eva_Afectacion1" => $post['rdoATS_AFE1'],
                "eva_Afectacion2" => $post['rdoATS_AFE2'],
                "eva_Afectacion3" => $post['rdoATS_AFE3'],
                "eva_Afectacion4" => $post['rdoATS_AFE4'],
                "eva_Afectacion5" => $post['rdoATS_AFE5'],
            );
        }
        $builder = db()->table('evaluaciong1');
        $builder->insert($data);
        $result = $this->db->insertID();
        if ($result) {
            $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Se registro tu evaluación con exito!'));
            $totalEmpleados = $this->db->query("SELECT COUNT(emp_EmpleadoID) as 'empleados' FROM empleado WHERE  emp_SucursalID=? AND emp_Estatus=1", array(session('sucursal')))->getRowArray()['empleados'];
            if ($totalEmpleados <= 50) {
                return redirect()->to(base_url("Evaluaciones/guia2/" . $post['evaluado']));
            } else {
                return redirect()->to(base_url("Evaluaciones/guia3/" . $post['evaluado']));
            }
        } else {
            $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error al registrar tu evaluación!'));
            return redirect()->to($_SERVER['HTTP_REFERER']);
        }
    } //end addguia1

    //Diego -> guardar guia 2
    public function addGuia2()
    {
        $post = $this->request->getPost();
        $evaluado = encryptDecrypt('decrypt', $post['evaluado']);
        $data = array(
            "eva_Fecha" => $post['fechaActual'],
            "eva_EvaluadoID" => $evaluado,
        );
        for ($i = 1; $i <= 40; $i++) {
            $data['eva_P' . $i] = $post['txtP' . $i];
        }
        if ($post['rdoClientes'] === 'SI') {
            $data['eva_Clientes'] = $post['rdoClientes'];
            for ($i = 41; $i <= 43; $i++) {
                $data['eva_P' . $i] = $post['txtP' . $i];
            }
        }
        if ($post['rdoJefe'] === 'SI') {
            $data['eva_Jefe'] = $post['rdoJefe'];
            for ($i = 44; $i <= 46; $i++) {
                $data['eva_P' . $i] = $post['txtP' . $i];
            }
        }
        $data['eva_Clientes'] = $post['rdoClientes'];
        $data['eva_Jefe'] = $post['rdoJefe'];
        $builder = db()->table('evaluaciong2');
        $builder->insert($data);
        $result = $this->db->insertID();
        if ($result) {
            $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Se registro tu evaluación con exito!'));
        } else {
            $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error al registrar tu evaluación!'));
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    } //end addguia2

    //Diego -> guardar guia 3
    public function addGuia3()
    {
        $post = $this->request->getPost();
        $evaluado = encryptDecrypt('decrypt', $post['evaluado']);
        $data = array(
            "eva_Fecha" => $post['fechaActual'],
            "eva_EvaluadoID" => $evaluado,
        );
        for ($i = 1; $i <= 64; $i++) {
            $data['eva_P' . $i] = $post['txtP' . $i];
        }
        if ($post['rdoClientes'] === 'SI') {
            $data['eva_Clientes'] = $post['rdoClientes'];
            for ($i = 65; $i <= 68; $i++) {
                $data['eva_P' . $i] = $post['txtP' . $i];
            }
        }
        if ($post['rdoJefe'] === 'SI') {
            $data['eva_Jefe'] = $post['rdoJefe'];
            for ($i = 69; $i <= 72; $i++) {
                $data['eva_P' . $i] = $post['txtP' . $i];
            }
        }
        $data['eva_Clientes'] = $post['rdoClientes'];
        $data['eva_Jefe'] = $post['rdoJefe'];
        $builder = db()->table('evaluaciong3');
        $builder->insert($data);
        $result = $this->db->insertID();
        if ($result) {
            $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Se registro tu evaluación con exito!'));
        } else {
            $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error al registrar tu evaluación!'));
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    } //end addguia3

    function valoracionG1($evaluacion)
    {
        $valoracion = "";

        //Seccion 1
        if ($evaluacion['eva_ATS'] === "SI") $valoracion = '<span class="font-16" style="color: #d90e0e">&#10003</span>';

        //Seccion2
        $respRecuerdos = array($evaluacion['eva_Recuerdos1'], $evaluacion['eva_Recuerdos2']);
        if (in_array("SI", $respRecuerdos)) $valoracion = '<span class="font-16" style="color: #d90e0e">&#10003</span>';

        //Seccion 3
        $respEsfuerzo = array(
            $evaluacion['eva_Esfuerzo1'],
            $evaluacion['eva_Esfuerzo2'],
            $evaluacion['eva_Esfuerzo3'],
            $evaluacion['eva_Esfuerzo4'],
            $evaluacion['eva_Esfuerzo5'],
            $evaluacion['eva_Esfuerzo6'],
            $evaluacion['eva_Esfuerzo7'],
        );
        $countEsfuerzo = 0;
        foreach ($respEsfuerzo as $item) {
            if ($item === "SI") {
                $countEsfuerzo += 1;
            }
        }
        if ($countEsfuerzo >= 3) $valoracion = '<span class="font-16" style="color: #d90e0e">&#10003</span>';

        //Seccion 4
        $respAfectacion = array(
            $evaluacion['eva_Afectacion1'],
            $evaluacion['eva_Afectacion2'],
            $evaluacion['eva_Afectacion3'],
            $evaluacion['eva_Afectacion4'],
            $evaluacion['eva_Afectacion5'],
        );
        $countAfectacion = 0;
        foreach ($respAfectacion as $item) {
            if ($item === "SI") {
                $countAfectacion += 1;
            }
        }
        if ($countAfectacion >= 2) $valoracion = '<span class="font-16" style="color: #d90e0e">&#10003</span>';
        return $valoracion;
    }

    //Lia-> guarda la evaluacion de clima laboral
    public function saveEvaluacionClimaLaboral()
    {
        $post = $this->request->getPost();
        $empleadoID = $post['empleadoID'];
        $data = array(
            'eva_EmpleadoID' => $empleadoID,
            'eva_FechaEvaluacionClimaLaboral' => date('Y-m-d'),
            'eva_AmFi1' => $post['AF1'],
            'eva_AmFi2' => $post['AF2'],
            'eva_AmFi3' => $post['AF3'],
            'eva_AmFi4' => $post['AF4'],
            'eva_FoCa1' => $post['FC1'],
            'eva_FoCa2' => $post['FC2'],
            'eva_FoCa3' => $post['FC3'],
            'eva_FoCa4' => $post['FC4'],
            'eva_FoCa5' => $post['FC5'],
            'eva_FoCa6' => $post['FC6'],
            'eva_FoCa7' => $post['FC7'],
            'eva_Lid1' => $post['LI1'],
            'eva_Lid2' => $post['LI2'],
            'eva_Lid3' => $post['LI3'],
            'eva_Lid4' => $post['LI4'],
            'eva_Lid5' => $post['LI5'],
            'eva_Lid6' => $post['LI6'],
            'eva_Lid7' => $post['LI7'],
            'eva_Lid8' => $post['LI8'],
            'eva_Lid9' => $post['LI9'],
            'eva_Lid10' => $post['LI10'],
            'eva_Lid11' => $post['LI11'],
            'eva_ReTra1' => $post['RT1'],
            'eva_ReTra2' => $post['RT2'],
            'eva_ReTra3' => $post['RT3'],
            'eva_ReTra4' => $post['RT4'],
            'eva_ReTra5' => $post['RT5'],
            'eva_ReTra6' => $post['RT6'],
            'eva_ReTra7' => $post['RT7'],
            'eva_ReTra8' => $post['RT8'],
            'eva_ReTra9' => $post['RT9'],
            'eva_ReTra10' => $post['RT10'],
            'eva_SenPer1' => $post['PE1'],
            'eva_SenPer2' => $post['PE2'],
            'eva_SenPer3' => $post['PE3'],
            'eva_SenPer4' => $post['PE4'],
            'eva_SenPer5' => $post['PE5'],
            'eva_SenPer6' => $post['PE6'],
            'eva_SenPer7' => $post['PE7'],
            'eva_SatLab1' => $post['SL1'],
            'eva_SatLab2' => $post['SL2'],
            'eva_SatLab3' => $post['SL3'],
            'eva_SatLab4' => $post['SL4'],
            'eva_SatLab5' => $post['SL5'],
            'eva_SatLab6' => $post['SL6'],
            'eva_SatLab7' => $post['SL7'],
            'eva_SatLab8' => $post['SL8'],
            'eva_SatLab9' => $post['SL9'],
            'eva_Com1' => $post['COM1'],
            'eva_Com2' => $post['COM2'],
            'eva_Com3' => $post['COM3'],
            'eva_Com4' => $post['COM4'],
            'eva_Com5' => $post['COM5'],
            'eva_Com6' => $post['COM6'],
            'eva_Com7' => $post['COM7'],
            'eva_Com8' => $post['COM8'],
            'eva_Comentarios' => $post['comentario']
        );
        $builder = db()->table("evaluacionclimalaboral");
        $builder->insert($data);
        $result = $this->db->insertID();

        if ($result) {
            $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Su evaluación fue enviada correctamente!'));
        } else {
            $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error intente mas tarde!'));
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }

    //Diego -> Guarda las respuestas que un empleado realiza sobre otro de la evaluacion de 270
    public function saveRespuestasDesempeno270()
    {
        $post = $this->request->getPost();

        $empleadoID = $post['empleadoID'];
        unset($post['empleadoID']);
        $evaluadorID = $post['evaluadorID'];
        unset($post['evaluadorID']);
        $periodoID = $post['periodoID'];
        unset($post['periodoID']);
        $QFcount = $post['QFcount'];
        unset($post['QFcount']);
        $observaciones = $post['observaciones'];
        unset($post['observaciones']);

        $respuestasDes270 = array();
        $cal = 0;
        for ($i = 1; $i <= $QFcount; $i++) {
            $respuestasDes270['F' . $i] = array(
                'Funcion' => $post['QF' . $i],
                'Calificacion' => $post['F' . $i],
            );
            $cal += $post['F' . $i];
        }
        $cal = $cal / ($QFcount);

        //Evaluacion
        $data = array(
            'evad_EmpleadoID'   => $empleadoID,
            'evad_EvaluadorID'  => $evaluadorID,
            'evad_Respuestas'   => json_encode($respuestasDes270),
            'evad_Fecha'        => date('Y-m-d'),
            'evad_PeriodoID'    => $periodoID,
            'evad_Calificacion' => $cal,
            'evad_Observaciones' => $observaciones,
        );

        $builder = db()->table('evaluaciondesempeno270');
        $result = $builder->insert($data);

        if ($result) {
            $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Su evaluación se guardo correctamente!'));
        } else {
            $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error intente mas tarde!'));
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }

    //Lia-> guarda la evaluacion de la competencia
    public function saveEvaluacionCompetenciaEmpleado()
    { //sacar la de desempeño 90
        $post = $this->request->getPost();
        $contComp = $post['countComp'];
        $empleadoID = encryptDecrypt('decrypt', $post['empleadoID']);
        $periodoID = encryptDecrypt('decrypt', $post['idPeriodo']);
        $respuestas = array();
        $porcentaje = array();
        $total = 0;
        $sum = 0;

        for ($i = 1; $i <= $contComp; $i++) {
            $respuestas['C' . $i] = array(
                'IdComp' => $post['idcomp' . $i],
                'Nivel' => $post['nivel' . $i],
                'Valor' => array_sum($post['valor' . $i]) / count($post['valor' . $i])
            );
            $sum += $post['nivel' . $i];
        }


        for ($i = 1; $i <= $contComp; $i++) {
            $total += number_format((($post['nivel' . $i] / $sum) * array_sum($post['valor' . $i])) / count($post['valor' . $i]), 2);
            $porcentaje['C' . $i] = array(
                'Porcentaje' => number_format((($post['nivel' . $i] / $sum) * array_sum($post['valor' . $i])) / count($post['valor' . $i]), 2)
            );
        }

        $data = array(
            'evac_EmpleadoID' => $empleadoID,
            'evac_Calificacion' => json_encode($respuestas),
            'evac_Fecha' => date('Y-m-d'),
            'evac_Porcentaje' => json_encode($porcentaje),
            'evac_CalificacionTotal' => $total,
            'evac_PeriodoID' => $periodoID,
        );

        $builder = db()->table('evaluacioncompetencia');
        $builder->insert($data);
        $result = $this->db->insertID();
        if ($result) {
            $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Su evaluación fue enviada correctamente!'));
        } else {
            $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error intente mas tarde!'));
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    } //END saveEvaluacionCompetenciaEmpleado

    //Lia-> guarda la evaluacion de la competencia del jefe
    public function saveEvaluacionCompetenciaJefe()
    {
        $post = $this->request->getPost();
        $contComp = $post['countComp'];
        $jefeID = encryptDecrypt('decrypt', $post['jefeID']);
        $evaluacionID = encryptDecrypt('decrypt', $post['evaluacionID']);
        $respuestas = array();
        $porcentaje = array();
        $total = 0;
        $sum = 0;

        for ($i = 1; $i <= $contComp; $i++) {
            $respuestas['C' . $i] = array(
                'IdComp' => $post['idcomp' . $i],
                'Nivel' => $post['nivel' . $i],
                'Valor' => array_sum($post['valor' . $i]) / count($post['valor' . $i])
            );
            $sum += $post['nivel' . $i];
        }

        for ($i = 1; $i <= $contComp; $i++) {
            $total += number_format((($post['nivel' . $i] / $sum) * array_sum($post['valor' . $i])) / count($post['valor' . $i]), 2);
            $porcentaje['C' . $i] = array(
                'Porcentaje' => number_format((($post['nivel' . $i] / $sum) * array_sum($post['valor' . $i])) / count($post['valor' . $i]), 2)
            );
        }

        $data = array(
            'evac_JefeID' => $jefeID,
            'evac_CalificacionJefe' => json_encode($respuestas),
            'evac_FechaJefe' => date('Y-m-d'),
            'evac_PorcentajeJefe' => json_encode($porcentaje),
            'evac_CalificacionTotalJefe' => $total,
        );
        $builder = db()->table('evaluacioncompetencia');
        $builder->update($data, array('evac_EvaluacionCompetenciaID' => $evaluacionID));
        if ($this->db->affectedRows() > 0) {
            $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Su evaluación fue enviada correctamente!'));
        } else {
            $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error intente mas tarde!'));
        }

        return redirect()->to(base_url('Evaluaciones/empleadosCompetencia'));
    } //END saveEvaluacionCompetenciaEmpleado

    /*
                   _         __   __
         /\       | |  /\    \ \ / /
        /  \      | | /  \    \ V /
       / /\ \ _   | |/ /\ \    > <
      / ____ \ |__| / ____ \  / . \
     /_/    \_\____/_/    \_\/_/ \_\
    */

    //Lia->Trae los periodos de evaluacion
    public function ajax_getPeriodos()
    {
        $model = new EvaluacionesModel();
        $periodos = $model->getPeriodosEvaluacion();

        $per = array();
        $data = array();

        foreach ($periodos as $periodo) {

            if ((int)$periodo['eva_Estatus'] === 1) {
                $estatus = '<span class="badge badge-success">Activo</span>';
            } else {
                $estatus = '<span class="badge badge-danger">Baja</span>';
            }

            $data['eva_EvaluacionID'] = $periodo['eva_EvaluacionID'];
            $data['eva_Tipo'] = $periodo['eva_Tipo'];
            $data['eva_FechaInicio'] = shortDate($periodo['eva_FechaInicio']);
            $data['eva_FechaFin'] = shortDate($periodo['eva_FechaFin']);
            $data['eva_Estatus'] = (int)$periodo['eva_Estatus'];
            $data['estado'] = $estatus;

            array_push($per, $data);
        }

        echo json_encode(array("data" => $per));
    }

    //Lia->Guarda un periodo de evaluacion
    public function ajax_savePeriodoEvaluacion()
    {
        $post = $this->request->getPost();

        $this->db->transStart();

        $sql = "SELECT count(eva_EvaluacionID) as 'evaluacion'
                from evaluacion
                WHERE eva_Tipo = ? AND
                (( ? >= eva_FechaInicio AND ? < eva_FechaFin) OR
                (? > eva_FechaInicio AND ? <= eva_FechaFin) OR
                (? <= eva_FechaInicio AND ? >= eva_FechaFin)) AND eva_Estatus = 1";
        $evaluacion_existente = $this->db->query($sql, array($post['eva_Tipo'], $post['fInicio'], $post['fInicio'], $post['fFin'], $post['fFin'], $post['fInicio'], $post['fFin']))->getRowArray();

        if ($evaluacion_existente['evaluacion'] > 0) {
            $tipoEv = $post['eva_Tipo'];
            $data['msg'] = 'Hay una evaluación de ' . $tipoEv . ' registrada en esas fechas, por favor seleccione otro periodo';
            $data['code'] = 2;
        } elseif ($evaluacion_existente['evaluacion'] <= 0) {

            $data_bd = array(
                'eva_Tipo' => $post['eva_Tipo'],
                'eva_FechaInicio' => $post['fInicio'],
                'eva_FechaFin' => $post['fFin'],
                'eva_FechaRegistro' => date('Y-m-d'),
                'eva_RegistroID' => session('id'),
            );

            $builder = db()->table("evaluacion");
            $result = $builder->insert($data_bd);

            if ($result > 0) {

                $subject = 'Nuevo periodo de evaluación';

                $sql = "SELECT * FROM empleado WHERE  emp_Estatus=1";
                $empleados = $this->db->query($sql)->getResultArray();
                foreach ($empleados as $empleado) {
                    $info_correo = array(
                        "nombre" => $empleado['emp_Nombre'],
                        'tipo' => $post['eva_Tipo'],
                        'FechaInicio' => $post['fInicio'],
                        'FechaFin' => $post['fFin'],
                    );

                    $link = "";
                    switch ($post['eva_Tipo']) {
                        case 'Clima Laboral':
                            $link = "Evaluaciones/evaluacionClimaLaboral";
                            break;
                        case 'Nom035':
                            $link = "Evaluaciones/nom035";
                            break;
                        case 'Desempeño':
                            $link = "#";
                            break;
                        case 'Competencias':
                            $link = "#";
                            break;
                    }

                    if ($empleado['emp_Correo'] !== "") {
                        $data_correo = array(
                            "correo" => $empleado['emp_Correo']
                        );

                        //if (sendMail($data_correo['correo'], $subject, $info_correo, 'Evaluacion')) {
                        $notificacion = array(
                            "not_EmpleadoID" => $empleado['emp_EmpleadoID'],
                            "not_Titulo" => 'Nuevo periodo de evaluación',
                            "not_Descripcion" => 'Evaluación de ' . $post['eva_Tipo'],
                            "not_EmpleadoIDCreo" => session("id"),
                            "not_FechaRegistro" => date('Y-m-d H:i:s'),
                            "not_URL" => $link
                        );
                        $builder = db()->table("notificacion");
                        $builder->insert($notificacion);
                        //}
                    }
                }

                insertLog($this, session('id'), 'Agregar', 'evaluacion', $result);
                $data['msg'] = '¡Periodo de evaluación agregado!';
                $data['code'] = 1;
            } else {
                $data['msg'] = '¡Ocurrio un error intente mas tarde!';
                $data['code'] = 0;
            }
        }

        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
        } else {
            $this->db->transCommit();
        }

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    //Lia->dar de baja el periodo de evaluacion
    public function ajax_bajaPeriodoEvaluacion()
    {
        $post = $this->request->getPost();
        $builder = db()->table('evaluacion');
        $result = $builder->update(array("eva_Estatus" => 0), array("eva_EvaluacionID" =>  $post['id']));
        if ($result) {
            insertLog($this, session('id'), 'Baja', 'evaluacion', $post['id']);
            $data['code'] = 1;
        } else {
            $data['code'] = 0;
        }
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    //Diego-> obtener evaluados g1
    public function ajaxGetEvaluadosG1($fInicio, $fFin, $sucursal)
    {
        $sucursal = encryptDecrypt('decrypt', $sucursal);
        $model = new EvaluacionesModel();
        $evaluaciones = $model->getEvaluacionesGuia1($fInicio, $fFin, $sucursal);
        $arrColaborador = array();
        $col = array();
        $count = 1;
        foreach ($evaluaciones as $evaluacion) {
            $valoracion = $this->valoracionG1($evaluacion);

            $col['num'] = $count;
            $col['col_Nombre'] = $evaluacion['emp_Nombre'];
            $col['valoracion'] = $valoracion;
            array_push($arrColaborador, $col);
            $count++;
        }
        $data['data'] = $arrColaborador;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajaxGetEvaluadosG1

    //Diego->Get direcciones
    public function ajax_getEvaluados($fInicio, $fFin, $sucursal)
    {
        $sucursal = encryptDecrypt('decrypt', $sucursal);
        $model = new EvaluacionesModel();
        $data['data'] = $model->getEvaluados($fInicio, $fFin, $sucursal);
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_getDirecciones

    //Diego -> get dominio bajo riesgo
    public function ajax_getDominios($fInicio, $fFin, $sucursal)
    {
        $sucursal = encryptDecrypt('decrypt', $sucursal);
        $model = new EvaluacionesModel();
        $data = $model->getDominiosBajoRiesgo($fInicio, $fFin, $sucursal);
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    public function ajaxGuardarInterpG2()
    {
        $fechaI = $_POST['fechaI'];
        $fechaF = $_POST['fechaF'];
        $url = FCPATH . "/assets/uploads/resultados/Nom035/";
        if (!file_exists($url)) {
            mkdir($url, 0777, true);
        }
        if (file_exists($url . "GraficaIntG2CT.png")) unlink($url . "GraficaIntG2CT.png");

        $img = $_POST['img'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);

        $file = $url . "GraficaIntG2CT.png";
        $success = file_put_contents($file, $data);
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    //Diego->Get direcciones
    public function ajax_getEvaluadosG3($fInicio, $fFin, $sucursal)
    {
        $model = new EvaluacionesModel();
        $sucursal = encryptDecrypt('decrypt', $sucursal);
        $data['data'] = $model->getEvaluadosG3($fInicio, $fFin, $sucursal);
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_getDirecciones

    //Diego -> get dominio bajo riesgo
    public function ajax_getDominiosG3($fInicio, $fFin, $sucursal)
    {
        $model = new EvaluacionesModel();
        $sucursal = encryptDecrypt('decrypt', $sucursal);
        $data = $model->getDominiosBajoRiesgoG3($fInicio, $fFin, $sucursal);
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    public function ajaxGuardarInterpG3()
    {
        $fechaI = $_POST['fechaI'];
        $fechaF = $_POST['fechaF'];
        $url = FCPATH . "/assets/uploads/resultados/Nom035/";
        if (!file_exists($url)) {
            mkdir($url, 0777, true);
        }
        if (file_exists($url . "GraficaIntG3.png")) unlink($url . "GraficaIntG3.png");

        $img = $_POST['img'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);

        $file = $url . "GraficaIntG3.png";
        $success = file_put_contents($file, $data);
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    //Diego -> Obtiene la lista de los periodos de evaluacion donde se evaluo a un empleado
    public function ajaxGetEvaluaciones()
    {
        $post = $this->request->getPost();
        $sql = "SELECT DISTINCT (ED.evad_PeriodoID), E.*, ED.evad_EmpleadoID
                FROM evaluaciondesempeno270 ED
                LEFT JOIN evaluacion E ON E.eva_EvaluacionID=ED.evad_PeriodoID
                WHERE ED.evad_EmpleadoID=?
                ORDER BY E.eva_EvaluacionID DESC";
        $periodos = $this->db->query($sql, array((int)$post['empleadoID']))->getResultArray();

        echo json_encode(array("response" => "success", "periodos" => $periodos));
    }

    //Lia->Guarda las Grafica de clima laboral
    public function ajax_guardarGraficaClimaLaboral()
    {

        $url = FCPATH . "/assets/uploads/resultados/ClimaLaboral/";
        if (!file_exists($url)) {
            mkdir($url, 0777, true);
        }
        if (file_exists($url . "ClimaLaboral.png")) unlink($url . "ClimaLaboral.png");


        $img = $_POST['img'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);

        $file = $url . 'ClimaLaboral.png';
        $success = file_put_contents($file, $data);

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    //Lia -> Obtiene la lista de los periodos de evaluacion donde se evaluo a un empleado
    public function ajaxGetEvaluacionesCompetencias()
    {
        $post = $this->request->getPost();
        $sql = "SELECT EC.*, E.*
                FROM evaluacioncompetencia EC
                JOIN evaluacion E ON EC.evac_PeriodoID=E.eva_EvaluacionID
                WHERE EC.evac_EmpleadoID=?
                ORDER BY EC.evac_Fecha DESC";
        $periodos = $this->db->query($sql, array((int)encryptDecrypt('decrypt', $post['empleadoID'])))->getResultArray();
        $data = array();
        foreach ($periodos as $periodo) {
            $periodo['evac_EvaluacionCompetenciaID'] = encryptDecrypt('encrypt', $periodo['evac_EvaluacionCompetenciaID']);
            array_push($data, $periodo);
        }
        echo json_encode(array("response" => "success", "periodos" => $data));
    }

    //Lia -> Guarda una imagen de la grafica de evaluacion por competencias para mostrar en el pdf
    public function ajax_guardarImagenECompetencias($num)
    {
        $data['code'] = 1;
        // requires php5

        $url = FCPATH . "/assets/uploads/resultados/evaluacionCompetencias/";
        if (!file_exists($url)) {
            mkdir($url, 0777, true);
        }
        $img = $_POST['img'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $file = $url . 'evaluacionCompetenciasByColaborador' . $num . '.png';
        $success = file_put_contents($file, $data);
        //print $success ? $file : 'Unable to save the file.';

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajaxGuardarImagen

    //Diego -> Guarda una imagen de la grafica de evaluacion por desempeño para mostrar en el pdf
    public function ajax_guardarImagenEDesemp()
    {
        $data['code'] = 1;
        // requires php5
        $url = FCPATH . "/assets/uploads/resultados/evaluacionDesempeno/";
        if (!file_exists($url)) {
            mkdir($url, 0777, true);
        }

        $img = $_POST['img'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $file = $url . 'evaluacionDesempByColaborador.png';
        $success = file_put_contents($file, $data);

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajaxGuardarImagen
}
