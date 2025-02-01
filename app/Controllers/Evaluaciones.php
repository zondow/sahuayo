<?php

namespace App\Controllers;

defined('FCPATH') or exit('No direct script access allowed');


class Evaluaciones extends BaseController
{

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
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Período de evaluación', "link" => base_url('Evaluaciones/periodoEvaluacion'), "class" => "active")
        );

        load_plugins(['select2', 'datatables_buttons', 'daterangepicker', 'sweetalert2'], $data);

        //Styles
        //Scripts
        $data['scripts'][] = base_url('assets/js/evaluaciones/periodoEvaluacion.js');

        //Vistas
        echo view('htdocs/header', $data);
        echo view('evaluaciones/formPeriodoEvaluacion');
        echo view('htdocs/footer');
    } //end periodoEvaluacion


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
            $data['fechaEstatus'] = $this->EvaluacionesModel->getFechaEvaluacionClimaLaboral();

            $realizada = $this->EvaluacionesModel->evaluacionClimaLaboralRealizada(session('id'));
            $data['permitir'] = (is_null($realizada)) ? true : false;
            $data['empleadoID'] = session('id');
        }

        load_barrating($data);
        //Styles

        //Scripts
        $data['scripts'][] = 'https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.9.6/lottie.min.js';


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

        $data['sucursales'] = $this->BaseModel->getSucursales();

        //Calcular resultados
        if (!empty($_POST)) {
            $data['f1'] = post("fechaInicio");
            $data['f2'] = post("fechaFin");
            $data['sucursal'] = post("sucursal");
            $data['sucursalNombre'] = $this->BaseModel->getSucursalByID(post('sucursal') == 0 ? post('sucursal') : encryptDecrypt('decrypt', post("sucursal")))['suc_Sucursal'] ?? null;
            $data['result'] =  $this->EvaluacionesModel->getAllCalificacionForClimaLaboral($data['f1'], $data['f2'], $data['sucursal']);
        }

        load_plugins(['daterangepicker', 'select2', 'modalPdf'], $data);
        //Scripts

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('evaluaciones/resultadosClimaLaboral');
        echo view('htdocs/modalPdf');
        echo view('htdocs/footer');
    } //end resultadosClimaLaboral

    //Lia -> Vista donde se realiza la evaluacion nom035
    public function nom035()
    {
        validarSesion(self::LOGIN_TYPE);
        $realizoEvaluacion = $this->EvaluacionesModel->evaluacionNom035Realizada(session('id'));
        if ($realizoEvaluacion == false) {
            //Titulo
            $data['title'] = 'Evaluación Nom 035';
            $data['breadcrumb'] = array(
                array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "active"),
                array("titulo" => 'Evaluación Nom 035', "link" => base_url('Evaluaciones/nom035'), "class" => "active"),
            );

            $data['periodo'] = $this->EvaluacionesModel->getFechaEvaluacionByTipo('Nom035');
            $data['permitir'] = TRUE;
            $data['evaluadoID'] = encryptDecrypt('encrypt', session('id'));

            load_plugins(['select2', 'datepicker'], $data);
            //Styles
            //Scripts
            $data['scripts'][] = 'https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.9.6/lottie.min.js';
            $data['scripts'][] = base_url('assets/js/evaluaciones/formGuia1.js');

            //Cargar vistas
            echo view('htdocs/header', $data);
            echo view('evaluaciones/formGuia1');
            echo view('htdocs/footer');
        } else {
            $totalEmpleados = $this->BaseModel->getTotalEmpleadosBySucursal(session('sucursal'));
            $guia = $totalEmpleados <= 50 ? "guia2" : "guia3";
            return redirect()->to(base_url("Evaluaciones/{$guia}/" . encryptDecrypt('encrypt', session('id'))));
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
        $fecha = $this->EvaluacionesModel->getFechaEvaluacionByTipo('Nom035');
        $data['evaluacion'] = $this->EvaluacionesModel->getEvaluacionRealizadaGuia2($evaluado, $fecha['eva_FechaInicio'], $fecha['eva_FechaFin']);

        load_plugins(['select2', 'datepicker'], $data);

        //Styles
        $data['scripts'][] = 'https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.9.6/lottie.min.js';
        $data['styles'][] = base_url('assets/css/formGuia2.css');
        //Scripts

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
        $fecha = $this->EvaluacionesModel->getFechaEvaluacionByTipo('Nom035');
        $data['evaluacion'] = $this->EvaluacionesModel->getEvaluacionRealizadaGuia3($evaluado, $fecha['eva_FechaInicio'], $fecha['eva_FechaFin']);

        //Styles
        $data['scripts'][] = 'https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.9.6/lottie.min.js';
        load_plugins(['select2'], $data);
        $data['styles'][] = base_url('assets/css/formGuia2.css');
        //Scripts

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
        $data['sucursales'] = $this->BaseModel->getSucursales();
        if ($fInicio !== null && $fFin !== null && $sucursal !== null) {
            $data['url'] = base_url() . "/PDF/evaluacionesGuiaI/$fInicio/$fFin/$sucursal";
        } else {
            $data['style'] = 'style="display:none !important"';
        }

        $data['FechaInicio'] = $fInicio;
        $data['FechaFin'] = $fFin;
        $data['SucursalID'] = $sucursal;

        load_plugins(['select2', 'datatables_buttons', 'daterangepicker', 'moment', 'moment_locales'], $data);

        //Styles
        //Scripts
        $data['scripts'][] = base_url('assets/js/evaluaciones/guia1.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('evaluaciones/resultadosGuiaI');
        echo view('htdocs/footer');
    } //end resultadosGuiaI

    public function resultadosGuiaII($fInicio = null, $fFin = null, $sucursal = null)
    {
        validarSesion(self::LOGIN_TYPE);

        $data = [
            'title' => 'Resultados guia II',
            'breadcrumb' => [
                ["titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""],
                ["titulo" => 'Resultados guia II', "link" => base_url('Evaluaciones/resultadosGuiaII'), "class" => "active"]
            ],
            'url' => '',
            'style' => 'style="display:none !important"',
            'sucursales' => $this->BaseModel->getSucursales(),
            'calificacionFinal' => 0,
            'dominio' => array_fill_keys(
                ["ambienteTrabajo", "cargaTrabajo", "faltaControl", "jornadaTrabajo", "interferencia", "liderazgo", "relacionTrabajo", "violencia"],
                0
            ),
            'FechaInicio' => $fInicio,
            'FechaFin' => $fFin,
            'SucursalID' => $sucursal,
            'styles' => [base_url('assets/css/formGuia2.css')],
            'scripts' => [base_url('assets/js/evaluaciones/guia2.js')]
        ];

        if ($fInicio && $fFin && $sucursal) {
            $data['url'] = base_url() . "/PDF/evaluacionesGuiaII/$fInicio/$fFin/$sucursal";
            $data['calificacionFinal'] = $this->EvaluacionesModel->getCF($fInicio, $fFin, $sucursal);
            $data['dominio'] = $this->EvaluacionesModel->getDominios($fInicio, $fFin, $sucursal);
            $data['style'] = '';
        }

        load_plugins(['daterangepicker', 'select2', 'datatables_buttons', 'moment', 'moment_locales', 'jquery_knob', 'chart_js'], $data);

        echo view('htdocs/header', $data);
        echo view('evaluaciones/resultadosGuia2');
        echo view('htdocs/footer');
    }

    //Diego -> resultados guia 2
    public function resultadoEvaluadoGuia2($evaluadoID, $fInicio, $fFin)
    {
        //Data
        $evaluado = encryptDecrypt('decrypt', $evaluadoID);
        $infoEvaluado = $this->BaseModel->getEmpleadoByID($evaluado);
        $data['dominio'] = $this->EvaluacionesModel->getDominiosByEvaluado($evaluado, $fInicio, $fFin);

        $data['title'] = 'Resultado de ' . $infoEvaluado['emp_Nombre'];
        $data['breadcrumb'] = array(
            array('titulo' => 'Inicio', 'link' => base_url('Usuario/index'), 'class' => ''),
            array('titulo' => 'Resultados guia II', 'link' => base_url('Evaluaciones/resultadosGuiaII/' . $fInicio . "/" . $fFin), 'class' => ''),
            array('titulo' => strtoupper($infoEvaluado['emp_Nombre']), 'link' => base_url('Evaluaciones/resultadoEvaluadoGuia2/' . $evaluadoID . "/" . $fInicio . "/" . $fFin), 'class' => 'active'),
        );

        load_plugins(['select2','datetange','datatables_buttons','lightbox'],$data);

        //Styles
        $data['styles'][] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/css/fileinput.css"; //Bootstrap FileInput
        $data['styles'][] = base_url('assets/css/formGuia2.css');

        //Scripts
        $data['scripts'][] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/fileinput.js"; //Bootstrap FileInput
        $data['scripts'][] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/locales/es.js"; //Bootstrap FileInput Spanish

        echo view("htdocs/header", $data);
        echo view("evaluaciones/resultadoEvaluadoGuia2");
        echo view("htdocs/footer");
    } //

    // Lia-> listado de plantillas de evaluacion de desempeño
    public function plantillasDesempeño(){
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Plantillas evaluación de desempeño';
        $data['plantillas'] = $this->EvaluacionesModel->getPlantillas('desempeño');

        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Plantillas', "link" => base_url('Evaluaciones/plantillasDesempeño'), "class" => "active"),
        );

        //pluggins
        load_plugins(['datatables_buttons','sweetalert2'],$data);

        //custom scripts
        $data['scripts'][] = base_url("assets/js/evaluaciones/plantillas.js");

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('evaluaciones/plantillas', $data);
        echo view('htdocs/footer');
    }//end 

    //Lia->crear evaluacion de desempeño
    public function addEvaluacionDesempeno($plantillaID){
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Crear evaluación';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "active"),
            array("titulo" => 'Plantilla ', "link" => base_url('Evaluaciones/plantillasDesempeno'), "class" => "active"),
            array("titulo" => 'Crear evaluación ', "link" => base_url('Evaluaciones/addEvaluacionDesempeno/' . $plantillaID), "class" => "active"),
        );
 
        //Obtener los datos 
        $data['plantilla']=$this->EvaluacionesModel->getInfoPlantillaByID(encryptDecrypt('decrypt',$plantillaID));
        $data['plantillaID']=$plantillaID;
        $data['sucursales']=$this->BaseModel->getSucursales();
        $data['departamentos']=$this->BaseModel->getDepartamentos();
        $data['puestos']=$this->BaseModel->getPuestos();
        $data['empleados']=$this->BaseModel->getEmpleados();


        //pluggins
        load_plugins(['select2','datatables_buttons','sweetalert2'],$data);

        //custom scripts
        //$data['scripts'][] = base_url('assets/js/evaluaciones/addEvaluacionDesempeno.js');
     


        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('evaluaciones/addEvaluacionDesempeno',$data);
        echo view('htdocs/footer');

    }

    /*
      ______ _    _ _   _  _____ _____ ____  _   _ ______  _____
     |  ____| |  | | \ | |/ ____|_   _/ __ \| \ | |  ____|/ ____|
     | |__  | |  | |  \| | |      | || |  | |  \| | |__  | (___
     |  __| | |  | | . ` | |      | || |  | | . ` |  __|  \___ \
     | |    | |__| | |\  | |____ _| || |__| | |\  | |____ ____) |
     |_|     \____/|_| \_|\_____|_____\____/|_| \_|______|_____/
    */
    // Lia-> guarda la evaluacion de clima laboral
    public function saveEvaluacionClimaLaboral()
    {
        $post = $this->request->getPost();
        $empleadoID = $post['empleadoID'];
        $campos = [
            'eva_AmFi' => 'AF',
            'eva_FoCa' => 'FC',
            'eva_Lid' => 'LI',
            'eva_ReTra' => 'RT',
            'eva_SenPer' => 'PE',
            'eva_SatLab' => 'SL',
            'eva_Com' => 'COM'
        ];

        $data = [
            'eva_EmpleadoID' => $empleadoID,
            'eva_FechaEvaluacionClimaLaboral' => date('Y-m-d'),
            'eva_Comentarios' => $post['comentario']
        ];

        foreach ($campos as $campoDB => $campoPost) {
            for ($i = 1; isset($post[$campoPost . $i]); $i++) {
                $data[$campoDB . $i] = $post[$campoPost . $i];
            }
        }

        $result = insert('evaluacionclimalaboral', $data);

        $msg = $result
            ? ['response' => 'success', 'txttoastr' => '¡Su evaluación fue enviada correctamente!']
            : ['response' => 'error', 'txttoastr' => '¡Ocurrió un error, intente más tarde!'];

        $this->session->setFlashdata($msg);

        return redirect()->to($_SERVER['HTTP_REFERER']);
    }

    //Diego -> guardar guia 1
    public function addGuia1()
    {
        $post = $this->request->getPost();
        $evaluado = encryptDecrypt('decrypt', $post['evaluado']);

        $data = [
            "eva_Fecha" => $post['fechaActual'],
            "eva_EvaluadoID" => $evaluado,
            "eva_ATS" => $post['rdoATS_ATS']
        ];

        if ($post['rdoATS_ATS'] === 'SI') {
            $data = array_merge($data, [
                "eva_Recuerdos1" => $post['rdoATS_REC1'],
                "eva_Recuerdos2" => $post['rdoATS_REC2'],
                "eva_Esfuerzo1"  => $post['rdoATS_ESF1'],
                "eva_Esfuerzo2"  => $post['rdoATS_ESF2'],
                "eva_Esfuerzo3"  => $post['rdoATS_ESF3'],
                "eva_Esfuerzo4"  => $post['rdoATS_ESF4'],
                "eva_Esfuerzo5"  => $post['rdoATS_ESF5'],
                "eva_Esfuerzo6"  => $post['rdoATS_ESF6'],
                "eva_Esfuerzo7"  => $post['rdoATS_ESF7'],
                "eva_Afectacion1" => $post['rdoATS_AFE1'],
                "eva_Afectacion2" => $post['rdoATS_AFE2'],
                "eva_Afectacion3" => $post['rdoATS_AFE3'],
                "eva_Afectacion4" => $post['rdoATS_AFE4'],
                "eva_Afectacion5" => $post['rdoATS_AFE5']
            ]);
        }

        $result = insert('evaluaciong1', $data) ?? false;

        $response = $result ? ['response' => 'success', 'txttoastr' => '¡Se registró tu evaluación con éxito!'] :
            ['response' => 'error', 'txttoastr' => '¡Ocurrió un error al registrar tu evaluación!'];
        $this->session->setFlashdata($response);

        if ($result) {
            $totalEmpleados = $this->BaseModel->getTotalEmpleadosBySucursal(session('sucursal'));
            $guia = $totalEmpleados <= 50 ? 'guia2' : 'guia3';
            return redirect()->to(base_url("Evaluaciones/$guia/" . $post['evaluado']));
        }

        return redirect()->to($_SERVER['HTTP_REFERER']);
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
        $result = insert('evaluaciong2', $data);
        $response = $result ? ['response' => 'success', 'txttoastr' => '¡Se registró tu evaluación con éxito!'] :
            ['response' => 'error', 'txttoastr' => '¡Ocurrió un error al registrar tu evaluación!'];
        $this->session->setFlashdata($response);
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
        $result = insert('evaluaciong3', $data);
        $response = $result ? ['response' => 'success', 'txttoastr' => '¡Se registró tu evaluación con éxito!'] :
            ['response' => 'error', 'txttoastr' => '¡Ocurrió un error al registrar tu evaluación!'];
        $this->session->setFlashdata($response);
        return redirect()->to($_SERVER['HTTP_REFERER']);
    } //end addguia3

    function valoracionG1($evaluacion)
    {
        $checkmark = '<span class="font-16" style="color: #d90e0e">&#10003</span>';

        // Sección 1
        if ($evaluacion['eva_ATS'] === "SI") return $checkmark;

        // Sección 2
        if (in_array("SI", [$evaluacion['eva_Recuerdos1'], $evaluacion['eva_Recuerdos2']])) return $checkmark;

        // Sección 3
        if (count(array_filter([
            $evaluacion['eva_Esfuerzo1'], $evaluacion['eva_Esfuerzo2'], $evaluacion['eva_Esfuerzo3'],
            $evaluacion['eva_Esfuerzo4'], $evaluacion['eva_Esfuerzo5'], $evaluacion['eva_Esfuerzo6'],
            $evaluacion['eva_Esfuerzo7']
        ], fn ($item) => $item === "SI")) >= 3) return $checkmark;

        // Sección 4
        if (count(array_filter([
            $evaluacion['eva_Afectacion1'], $evaluacion['eva_Afectacion2'], $evaluacion['eva_Afectacion3'],
            $evaluacion['eva_Afectacion4'], $evaluacion['eva_Afectacion5']
        ], fn ($item) => $item === "SI")) >= 2) return $checkmark;

        return "";
    }


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
        $periodos = $this->EvaluacionesModel->getPeriodosEvaluacion();

        foreach ($periodos as &$periodo) {
            $periodo['eva_EvaluacionID'] = $periodo['eva_EvaluacionID'];
            $periodo['eva_Tipo'] = $periodo['eva_Tipo'];
            $periodo['eva_FechaInicio'] = longDate($periodo['eva_FechaInicio'], ' de ');
            $periodo['eva_FechaFin'] = longDate($periodo['eva_FechaFin'], ' de ');
            $periodo['eva_Estatus'] = (int)$periodo['eva_Estatus'];
            $periodo['estado'] = (int)$periodo['eva_Estatus'] === 1 ? '<span class="badge badge-success">Activo</span>' : '<span class="badge badge-danger">Baja</span>';
        }

        echo json_encode(array("data" => $periodos));
    }
    // Lia -> Guarda un periodo de evaluación
    public function ajax_savePeriodoEvaluacion()
    {
        $post = $this->request->getPost();
        $this->db->transStart();

        $evaluacion_existente = $this->EvaluacionesModel->getEvaluacionExistente($post['eva_Tipo'], $post['fInicio'], $post['fFin']);
        if ($evaluacion_existente['evaluacion'] > 0) {
            $data = [
                'msg' => 'Hay una evaluación de ' . $post['eva_Tipo'] . ' registrada en esas fechas, por favor seleccione otro periodo',
                'code' => 2
            ];
        } else {
            $data_bd = [
                'eva_Tipo' => $post['eva_Tipo'],
                'eva_FechaInicio' => $post['fInicio'],
                'eva_FechaFin' => $post['fFin'],
                'eva_FechaRegistro' => date('Y-m-d'),
                'eva_RegistroID' => session('id')
            ];

            if ($result = insert('evaluacion', $data_bd)) {
                $empleados = $this->BaseModel->getEmpleados();
                $links = [
                    'Clima Laboral' => "Evaluaciones/evaluacionClimaLaboral",
                    'Nom035' => "Evaluaciones/nom035",
                    'Desempeño' => "#",
                    'Competencias' => "#"
                ];

                foreach ($empleados as $empleado) {
                    if ($empleado['emp_Correo'] !== "") {
                        $notificacion = [
                            "not_EmpleadoID" => $empleado['emp_EmpleadoID'],
                            "not_Titulo" => 'Nuevo periodo de evaluación',
                            "not_Descripcion" => 'Evaluación de ' . $post['eva_Tipo'],
                            "not_EmpleadoIDCreo" => session("id"),
                            "not_FechaRegistro" => date('Y-m-d H:i:s'),
                            "not_URL" => $links[$post['eva_Tipo']] ?? "#",
                            'not_Icono' => 'zmdi zmdi-check-square',
                            'not_Color' => 'bg-green'
                        ];
                        insert('notificacion', $notificacion);
                    }
                }

                insertLog($this, session('id'), 'Agregar', 'evaluacion', $result);

                $data = [
                    'msg' => '¡Periodo de evaluación agregado!',
                    'code' => 1
                ];
            } else {
                $data = [
                    'msg' => '¡Ocurrió un error, intente más tarde!',
                    'code' => 0
                ];
            }
        }

        $this->db->transComplete();
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    //Lia->dar de baja el periodo de evaluacion
    public function ajax_bajaPeriodoEvaluacion()
    {
        $post = $this->request->getPost();
        $data['code'] = update('evaluacion', ['eva_Estatus' => 0], ['eva_EvaluacionID' => $post['id']]) ? 1 : 0;

        if ($data['code'] === 1) {
            insertLog($this, session('id'), 'Baja', 'evaluacion', $post['id']);
        }

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    //Diego-> obtener evaluados g1
    public function ajaxGetEvaluadosG1($fInicio, $fFin, $sucursal)
    {
        $sucursal = encryptDecrypt('decrypt', $sucursal);
        $evaluaciones = $this->EvaluacionesModel->getEvaluacionesGuia1($fInicio, $fFin, $sucursal);
        $count = 1;
        foreach ($evaluaciones as &$evaluacion) {
            $valoracion = $this->valoracionG1($evaluacion);
            $evaluacion['num'] = $count++;
            $evaluacion['col_Nombre'] = $evaluacion['emp_Nombre'];
            $evaluacion['valoracion'] = $valoracion;
        }
        $data['data'] = $evaluaciones;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajaxGetEvaluadosG1
    
    //Diego->Get direcciones
    public function ajax_getEvaluados($fInicio, $fFin, $sucursal)
    {
        $sucursal = encryptDecrypt('decrypt', $sucursal);
        $data['data'] = $this->EvaluacionesModel->getEvaluados($fInicio, $fFin, $sucursal);
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_getDirecciones
    
    //Diego -> get dominio bajo riesgo
    public function ajax_getDominios($fInicio, $fFin, $sucursal)
    {
        $sucursal = encryptDecrypt('decrypt', $sucursal);
        $data = $this->EvaluacionesModel->getDominiosBajoRiesgo($fInicio, $fFin, $sucursal);
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }
    
    public function ajaxGuardarInterpG2()
    {
        $fechaI = $_POST['fechaI'];
        $fechaF = $_POST['fechaF'];
        $dir = FCPATH . "/assets/uploads/resultados/Nom035/";
        $file = $dir . "GraficaIntG2CT.png";
    
        if (!is_dir($dir)) mkdir($dir, 0777, true);
        if (file_exists($file)) unlink($file);
    
        $img = str_replace(['data:image/png;base64,', ' '], ['', '+'], $_POST['img']);
        $data = base64_decode($img);
    
        file_put_contents($file, $data);
    
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    //Lia -> guarda una plantilla de evaluacion
    public function ajaxSaveplantilla(){
        $post = $this->request->getPost();
        $post['pla_PlantillaID'] = encryptDecrypt('decrypt',$post['pla_PlantillaID']);
        $data['code'] = 0;
        $builder = db()->table("plantillacuestionario");
        if ((int)$post['pla_PlantillaID'] == 0) {
            unset($post['pla_PlantillaID']);
            $builder->insert($post);
            $result = $this->db->insertID();
            if ($result) $data['code'] = 1;
        } else {
            $result = $builder->update($post, array('pla_PlantillaID' => (int)$post['pla_PlantillaID']));
            if ($result) $data['code'] = 2;
        }
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }// end ajaxSavePlantilla

    //Lia- trae la info de la plantilla
    public function ajaxGetInfoPlantilla()
    {
        $plantillaID = encryptDecrypt('decrypt', post("plantillaID"));
        $data['result'] = $this->EvaluacionesModel->getInfoPlantillaByID($plantillaID);
        $data['code'] = 1;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }//end ajaxGetInfoPlantilla

    //Lia->cambia el estatus de la plantilla
    public function ajaxCambiarEstadoPlantilla(){
        $plantillaID = encryptDecrypt('decrypt', post("plantillaID"));
        $estado = post("estado");
        $data['code'] = update('plantillacuestionario', ['pla_Estatus' => $estado], ['pla_PlantillaID' => (int)$plantillaID]);
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }//end ajaxCambiarEstadoPlantilla


    //Lia->llena la tabla de empleados
    public function ajax_getEmpleadosActivos()
    {
        // Captura de filtros desde la solicitud POST y los descifra
        $sucursalID = isset($_POST['sucursalID']) ? encryptDecrypt('decrypt', $_POST['sucursalID']) : null;
        $departamentoID = isset($_POST['departamentoID']) ? encryptDecrypt('decrypt', $_POST['departamentoID']) : null;
        $puestoID = isset($_POST['puestoID']) ? encryptDecrypt('decrypt', $_POST['puestoID']) : null;
        $personaID = isset($_POST['personaID']) ? encryptDecrypt('decrypt', $_POST['personaID']) : null;
        
        // Llama al modelo con los filtros descifrados
        $colaboradores = $this->BaseModel->getColaboradoresConFoto($sucursalID, $departamentoID, $puestoID, $personaID);

        // Prepara la respuesta en formato JSON
        $data['response'] = $colaboradores;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    public function guardarCuestionarioCompleto() {
        $post = $this->request->getPost();
        $evaluationJson = $post['evaluation'];
        $CuestionarioID = $post['cuestionarioID'];
        $evaluationData = json_decode($evaluationJson, true);

        $deletedQuestions = isset($post['deletedQuestions']) ? json_decode($post['deletedQuestions'], true) : [];
        
        // Variables de respuesta inicializadas
        $data['code'] = 0;
        $data['message'] = 'Error al guardar la evaluación';
    
        // Inicializa los builders para cada tabla
        $grupoBuilder = db()->table("grupocuestionario");
        $preguntaBuilder = db()->table("preguntacuestionario");
        $respuestaBuilder = db()->table("respuestacuestionario");
    
        // Validar que `evaluationData` es un arreglo antes de proceder
        if (isset($evaluationData) && is_array($evaluationData)) {
            foreach ($evaluationData as $grupo) {

                foreach ($deletedQuestions as $deletedQuestionId) {
                    $preguntaBuilder->where('pre_PreguntaID', $deletedQuestionId)->delete();
                    // También elimina las respuestas asociadas
                    $respuestaBuilder->where('res_PreguntaID', $deletedQuestionId)->delete();
                }


                // Verificar si el grupo ya existe por nombre
                $grupoExiste = $grupoBuilder->where('gru_Titulo', $grupo['nombre'])->get()->getRow();
                
                if ($grupoExiste) {
                    // Si el grupo ya existe, usamos su ID
                    $grupoId = $grupoExiste->gru_GrupoID;
                } else {
                    // Si no existe, creamos el grupo
                    $grupoData = [
                        'gru_Titulo' => $grupo['nombre'],
                        'gru_UsuarioID' => session('id'),
                    ];
                    $grupoBuilder->insert($grupoData);
                    $grupoId = $this->db->insertID(); // ID del grupo insertado
                }
    
                // Obtener las preguntas existentes en este grupo
                $preguntasExistentes = $preguntaBuilder->where('pre_GrupoID', $grupoId)->get()->getResult();
    
                // Eliminar las preguntas que ya no están en la evaluación
                foreach ($preguntasExistentes as $preguntaExistente) {
                    $encontrada = false;
                    foreach ($grupo['preguntas'] as $pregunta) {
                        if ($preguntaExistente->pre_PreguntaID == $pregunta['id']) {
                            $encontrada = true;
                            break;  // Salir del bucle si la pregunta fue encontrada
                        }
                    }
    
                    // Si la pregunta ya no está en la evaluación, la eliminamos
                    if (!$encontrada) {
                        // Eliminar las respuestas asociadas a la pregunta
                        $respuestaBuilder->where('res_PreguntaID', $preguntaExistente->pre_PreguntaID)->delete();
                        
                        // Eliminar la pregunta
                        $preguntaBuilder->where('pre_PreguntaID', $preguntaExistente->pre_PreguntaID)->delete();
                    }
                }
    
                // Recorre y guarda cada pregunta del grupo
                foreach ($grupo['preguntas'] as $pregunta) {
                    // Verificar si la pregunta ya existe en el grupo por texto
                    $preguntaExiste = $preguntaBuilder->where('pre_Texto', $pregunta['texto'])
                                                      ->where('pre_GrupoID', $grupoId)
                                                      ->get()->getRow();
                    if ($preguntaExiste) {
                        // Si la pregunta ya existe, usamos su ID
                        $preguntaId = $preguntaExiste->pre_PreguntaID;
                    } else {
                        // Si no existe, creamos la pregunta
                        $preguntaData = [
                            'pre_CuestionarioID' => $CuestionarioID,
                            'pre_GrupoID' => $grupoId,
                            'pre_Texto' => $pregunta['texto'],
                            'pre_TipoRespuesta' => $pregunta['tipo'],
                            'pre_Obligatoria' => $pregunta['obligatoria'],
                            'pre_Ponderacion' => $pregunta['ponderacion'],
                            'pre_UsuarioID' => session('id'),
                        ];
                        $preguntaBuilder->insert($preguntaData);
                        $preguntaId = $this->db->insertID(); // ID de la pregunta insertada
                    }
                    
                    // Recorre y guarda cada respuesta de la pregunta
                    foreach ($pregunta['respuestas'] as $respuesta) {
                        // Verificar si la respuesta ya existe para la pregunta
                        $respuestaExiste = $respuestaBuilder->where('res_Texto', $respuesta)
                                                            ->where('res_PreguntaID', $preguntaId)
                                                            ->get()->getRow();
                        if (!$respuestaExiste) {
                            // Si la respuesta no existe, la insertamos
                            $respuestaData = [
                                'res_CuestionarioID' => $CuestionarioID,
                                'res_PreguntaID' => $preguntaId,
                                'res_Texto' => $respuesta,
                                'res_UsuarioID' => session('id')
                            ];
                            $respuestaBuilder->insert($respuestaData);
                        }
                    }
                }
            }
    
            // Si se insertaron los datos correctamente
            $data['code'] = 1;
            $data['message'] = 'Evaluación guardada exitosamente';
        }
    
        // Devuelve la respuesta en formato JSON
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    
    public function ajax_getEvaluacion(){
        $grupoBuilder = db()->table("grupocuestionario");
        $preguntaBuilder = db()->table("preguntacuestionario");
        $respuestaBuilder = db()->table("respuestacuestionario");
    
        // Obtener los grupos
        $grupos = $grupoBuilder->get()->getResultArray();
    
        // Obtener las preguntas y respuestas asociadas
        foreach ($grupos as &$grupo) {
            $grupo['nombre'] = $grupo['gru_Titulo']; // Se asigna el nombre del grupo
            $grupo['preguntas'] = []; // Inicializar el array de preguntas
    
            // Obtener las preguntas para este grupo
            $preguntas = $preguntaBuilder->where('pre_GrupoID', $grupo['gru_GrupoID'])->get()->getResultArray();
            foreach ($preguntas as &$pregunta) {
                $pregunta['respuestas'] = []; // Inicializar el array de respuestas
    
                // Obtener las respuestas asociadas a esta pregunta
                $respuestas = $respuestaBuilder->where('res_PreguntaID', $pregunta['pre_PreguntaID'])->get()->getResultArray();
                foreach ($respuestas as &$respuesta) {
                    $pregunta['respuestas'][] = $respuesta['res_Texto']; // Añadir las respuestas
                }
    
                // Añadir la pregunta al grupo
                $grupo['preguntas'][] = [
                    'id' => $pregunta['pre_PreguntaID'], //id
                    'texto' => $pregunta['pre_Texto'], // Pregunta
                    'tipo' => $pregunta['pre_TipoRespuesta'],      // Tipo de la pregunta
                    'ponderacion' => $pregunta['pre_Ponderacion'], // Ponderación
                    'obligatoria' => $pregunta['pre_Obligatoria'] == 1, // Obligatoria (convertir a booleano)
                    'respuestas' => $pregunta['respuestas'] // Respuestas de la pregunta
                ];
            }
        }
    
        // Retornar los datos en formato JSON
        header('Content-Type: application/json');
        echo json_encode($grupos, JSON_UNESCAPED_UNICODE);
    }
    
    public function guardarEvaluadosSeleccionados() {
        // Recibe los datos enviados desde el cliente (IDs de los evaluados)
        $post = $this->request->getPost();
        $evaluados = $post['ids'];  
        $cuestionarioID = $post['cuestionarioID'];  

        // Llamar a la función del modelo para guardar los evaluados
        $resultado = $this->EvaluacionesModel->guardarCuestionarioEvaluados($evaluados, $cuestionarioID);
        // Devolver la respuesta como JSON
        echo json_encode($resultado,JSON_UNESCAPED_SLASHES);
    }

    public function ajax_getEvaluadosCuestionario(){
        $post = $this->request->getPost();
        $cuestionarioID = $post['cuestionarioID'];  
        $plantillaID = decrypt($post['plantillaID']);  
        $evaluados = $this->EvaluacionesModel->getEvaluadosByCuestionarioID($cuestionarioID,$plantillaID);

        return $this->response->setJSON(['data' => $evaluados]);
    }

    public function eliminarEvaluadoCuestionario()
    {
        $post = $this->request->getPost(); // Obtener los datos enviados por POST
        $evaluadoID = isset($post['idEvaluado']) ? $post['idEvaluado'] : null;
    
        // Intentar eliminar al evaluado
        try {
            $resultado = $this->EvaluacionesModel->eliminarEvaluadoCuestionario($evaluadoID);
            
            // Comprobar si la eliminación fue exitosa
            if ($resultado === true) {
                return $this->response->setJSON([
                    'success' => true
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false
                ]);
            }
        } catch (\Exception $e) {
            // Manejo de errores en caso de excepciones
            return $this->response->setJSON([
                'success' => false
            ]);
        }
    }

    public function ajax_getAsigNivelEvaluadoEvaluador(){
        $post = $this->request->getPost();
        $existe = consultar_dato('evaluadorcuestionario', '*', 'eva_EmpleadoID ='. $post['evaluadoID']. ' AND eva_PlantillaID = '. decrypt($post['plantillaID']));
        $existe['eva_Evaluadores'] = !empty($existe['eva_Evaluadores']) ? json_decode($existe['eva_Evaluadores']) : null;
        return $this->response->setJSON(['data' => $existe]);
    }

    public function ajax_guardarNivelEvaluacionEvaluadoEvaluador() {
        $post = $this->request->getPost();
    
        $plantillaID = decrypt($post['plantillaID']);
        $existe = consultar_dato('evaluadorcuestionario', 'eva_EvaluadorCuestionarioID','eva_NivelEvaluacion = "'.$post['nivelEvaluacion'].'" AND eva_CuestionarioID = '.$post['cuestionarioID']. ' AND eva_EmpleadoID ='. $post['evaluadoID']. ' AND eva_PlantillaID = '. $plantillaID);
        $data = [
            'eva_PlantillaID' => $plantillaID,
            'eva_EmpleadoID' => $post['evaluadoID'],
            'eva_CuestionarioID' => $post['cuestionarioID'],
            'eva_Evaluadores' => json_encode(!empty($post['empleadoID']) && is_array($post['empleadoID']) ? array_map('decrypt', $post['empleadoID']) : []),
            'eva_NivelEvaluacion' => $post['nivelEvaluacion'],
            'eva_UsuarioID' => session('id'),
            'eva_Fecha' => date('Y-m-d')
        ];
    
        $r = $existe ? update('evaluadorcuestionario', $data, ['eva_EvaluadorCuestionarioID' => $existe]) : insert('evaluadorcuestionario', $data);
        return $this->response->setJSON(['success' => (bool) $r]);
    }

    public function ajax_getInfoEvaluadores(){
        $post = $this->request->getPost();
        return $this->response->setJSON(['data' => $this->EvaluacionesModel->getEvaluadores($post['cuestionarioID'],$post['evaluadoID'],decrypt($post['plantillaID']))]);
    }
    
    public function ajax_getEvaluadosEvaluadoresCuestionario(){
        $post = $this->request->getPost();
        $cuestionarioID = $post['cuestionarioID'];  
        $plantillaID = decrypt($post['plantillaID']);  
        $evaluados = $this->EvaluacionesModel->getEvaluadosEvaluadoresByCuestionarioID($cuestionarioID,$plantillaID);

        return $this->response->setJSON(['data' => $evaluados]);
    }

    public function ajax_eliminarEvaluador(){
        $post = $this->request->getPost();
        $evaluadorGrupo = $this->EvaluacionesModel->eliminarEvaluadorGrupo($post);
        return $this->response->setJSON(['success' => $evaluadorGrupo]);
    }

    
}
