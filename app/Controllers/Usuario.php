<?php

namespace App\Controllers;

defined('FCPATH') or exit('No direct script access allowed');

use App\Models\UsuarioModel;
use CodeIgniter\Session\Session;

class Usuario extends BaseController
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

    public function correo(){
        echo view('htdocs/correo');
    }

    public function index()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Inicio';
        $data['breadcrumb'] = array(
            array('titulo' => 'Inicio', 'link' => base_url('Usuario/index'), 'class' => 'active'),
        );
        $data['colaboradores'] = $this->UsuarioModel->getColaboradoresJefe();
        $data['retardos'] = $this->UsuarioModel->getRetardosColaborador();
        $data['misSanciones'] = $this->UsuarioModel->getMisSanciones();
        $data['welcome'] = $this->UsuarioModel->getWelcome();
        $data['galeria'] = $this->UsuarioModel->getUltimaGaleria();
        $data['anuncio'] = $this->UsuarioModel->getAnuncioActivo();

        $data['styles'][] = base_url('assets/plugins/fullcalendar/fullcalendar.min.css');
        $data['styles'][] = base_url('assets/plugins/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css');
        $data['styles'][] = base_url('assets/plugins/sweetalert/sweetalert.css');
        $data['styles'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.css');
        $data['styles'][] = 'https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css';

        $data['scripts'][] = base_url('assets/plugins/moment/min/moment.min.js');
        $data['scripts'][] = base_url('assets/plugins/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js');
        $data['scripts'][] = base_url('assets/plugins/fullcalendar/fullcalendar.min.js');
        $data['scripts'][] = base_url('assets/plugins/sweetalert/sweetalert.min.js');
        $data['scripts'][] = base_url('assets/plugins/sweetalert/jquery.sweet-alert.custom.js');
        $data['scripts'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.js');
        $data['scripts'][] = 'https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js';
        $data['scripts'][] = base_url('assets/js/dashboard.js');

        $data['scripts'][] = base_url('assets/js/incidencias/calendarioOperativo.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        //echo view('usuario/dashboard', $data);
        echo view('htdocs/modalPdf');
        echo view('htdocs/footer');
    } //INDEX

    //Lia->Mi perfil
    public function miPerfil()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = "Mi perfil";

        $data['informacion'] = $this->UsuarioModel->miInformacion();
        $data['colaboradores'] = $this->UsuarioModel->getColaboradores();
        $perfilPuesto = $this->UsuarioModel->getPerfilPuesto();
        $data['incidencias'] = $this->UsuarioModel->getIncidenciasByEmpleado(session("id"));

        if ($perfilPuesto != null) {
            $puestos = json_decode($perfilPuesto['puestosReporta']);
            $comite = '';

            foreach ($puestos as $key => $puesto) {
                if ($puesto == 999) {
                    unset($puestos[$key]);
                    $comite = 'COMITE';
                }
            }

            $perfilPuesto['puestosReporta'] = $perfilPuesto['puestosReporta'] != "null"
                ? $this->UsuarioModel->getPuestosCoordinaReporta(implode(",", $puestos))
                : [];

            if (!empty($comite)) {
                $perfilPuesto['puestosReporta'][]["puesto"] = $comite;
            }

            $perfilPuesto['puestosCoordina'] = $perfilPuesto['puestosCoordina'] != "null"
                ? $this->UsuarioModel->getPuestosCoordinaReporta(implode(",", json_decode($perfilPuesto['puestosCoordina'])))
                : [];
        }


        $data['perfilPuesto'] = $perfilPuesto;

        //Get competencias puesto
        $data['competenciasPuesto'] = $this->UsuarioModel->getCompetenciasPuesto((int)session("puesto"));


        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Mi perfil', "link" => base_url('Usuario/miPerfil'), "class" => "active"),
        );

        load_plugins(['jstree', 'tooltipster'], $data);

        $data['scripts'][] = base_url("assets/js/miPerfil.js");

        echo view('htdocs/header', $data);
        echo view('usuario/miPerfil', $data);
        echo view('htdocs/footer');
    } //miPerfil

    public function normativa()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Reglamentos y politicas';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Reglamentos y politicas', "link" => base_url('Usuario/normativa'), "class" => "active"),
        );


        //Styles
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.css');

        //Scripts
        $data['scripts'][] = base_url('assets/plugins/datatables/jquery.dataTables.min.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/js/dataTables.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.js');


        $data['scripts'][] = base_url('assets/js/misNotmativas.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('usuario/normativas');
        echo view('htdocs/footer');
    }

    public function anuncio()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Gestionar anuncios';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Anuncios', "link" => base_url('Usuario/anuncio'), "class" => "active"),
        );

        //Styles
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.css');
        $data['styles'][] = base_url('assets/libs/select2/css/select2.min.css');
        $data['styles'][] = base_url('assets/libs/summernote/summernote-bs4.css');


        //Scripts
        $data['scripts'][] = base_url('assets/plugins/datatables/jquery.dataTables.min.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/js/dataTables.bootstrap4.js');

        $data['scripts'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.js');
        $data['scripts'][] = base_url('assets/libs/select2/js/select2.full.min.js');
        $data['scripts'][] = base_url('assets/libs/summernote/summernote-bs4.min.js');
        $data['scripts'][] = base_url('assets/libs/summernote/lang/summernote-es-ES.js');

        $data['scripts'][] = base_url('assets/js/anuncio/subirAnuncio.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('usuario/subirAnuncio', $data);
        echo view('htdocs/footer', $data);
    }
    /*
      ______ _    _ _   _  _____ _____ ____  _   _ ______  _____
     |  ____| |  | | \ | |/ ____|_   _/ __ \| \ | |  ____|/ ____|
     | |__  | |  | |  \| | |      | || |  | |  \| | |__  | (___
     |  __| | |  | | . ` | |      | || |  | | . ` |  __|  \___ \
     | |    | |__| | |\  | |____ _| || |__| | |\  | |____ ____) |
     |_|     \____/|_| \_|\_____|_____\____/|_| \_|______|_____/
    */


    /* ---------- CRON JOBS -------------*/
    //Diego-> Cronjob dia inhabil ley
    public function diaInhabilLey()
    {
        $diaInhabilLey = $this->db->query("SELECT dial_Fecha,dial_Motivo,dial_NumeroImg FROM diainhabilley WHERE YEAR(dial_Fecha) = " . date('Y') . " AND MONTH(dial_Fecha) = " . date('m') . " ORDER BY dial_Fecha ASC")->getRowArray();
        if (get_nombre_dia($diaInhabilLey['dial_Fecha']) !== 'Domingo') {
            if (date('Y-m-d') === date('Y-m-d', strtotime('-3 day', strtotime($diaInhabilLey['dial_Fecha'])))) {
                $colaboradores = $this->db->query("SELECT emp_Correo,emp_Nombre FROM empleado WHERE emp_Correo!='' AND emp_Estatus=1")->getResultArray();
                foreach ($colaboradores as $colaborador) {
                    $data = array(
                        'fecha' => $diaInhabilLey['dial_Fecha'],
                        'motivo' => $diaInhabilLey['dial_Motivo'],
                        'imagen' => $diaInhabilLey['dial_NumeroImg'],
                        'empleado' => $colaborador['emp_Nombre'],
                    );
                    sendMail($colaborador['emp_Correo'], $diaInhabilLey['dial_Motivo'], $data, 'diainhabil');
                }
            }
        }
    }


    //Diego-> Cronjob dia inhabil
    public function diaInhabil()
    {
        $diaInhabil = $this->db->query("SELECT dia_Fecha,dia_Motivo,dia_SucursalID FROM diainhabil WHERE YEAR(dia_Fecha) = " . date('Y') . " AND MONTH(dia_Fecha) = " . date('m') . " ORDER BY dia_Fecha ASC")->getResultArray();
        foreach ($diaInhabil as $di) {
            if (date('Y-m-d') === date('Y-m-d', strtotime('-3 day', strtotime($di['dia_Fecha'])))) {
                $sucursales = json_decode($di['dia_SucursalID']);
                foreach ($sucursales as $sucursal) {
                    if ($sucursal == 0) {
                        $where = '';
                    } else {
                        $where = ' AND emp_SucursalID=' . $sucursal;
                    }
                    $colaboradores = $this->db->query("SELECT emp_Correo,emp_Nombre FROM empleado WHERE emp_Correo!='' AND emp_Estatus=1 " . $where)->getResultArray();
                    foreach ($colaboradores as $colaborador) {
                        $data = array(
                            'fecha' => $di['dia_Fecha'],
                            'motivo' => $di['dia_Motivo'],
                            'imagen' => null,
                            'empleado' => $colaborador['emp_Nombre'],
                        );
                        sendMail($colaborador['emp_Correo'], $di['dia_Motivo'], $data, 'diainhabil');
                    }
                }
            }
        }
    }

    public function addAnuncio()
    {
        $code = 0;
        $id = null;
        $msg = '';
        $post = $this->request->getPost();
        $nombreRepetido = $this->db->query("SELECT * FROM anuncio WHERE anu_Titulo=?", [$post['anu_Titulo']])->getResultArray();
        if ($nombreRepetido == null) {
            if ($post['anu_Estatus'] == 'Si') {
                $post['anu_Estatus'] = 1;
                $this->db->query("UPDATE anuncio SET anu_Estatus=0 WHERE anu_Estatus=1");
                $msg = ' y se ha publicado';
            } else {
                $post['anu_Estatus'] = 0;
            }
            $data = array(
                'anu_Titulo' => $post['anu_Titulo'],
                'anu_FechaRegistro' => date('Y-m-d'),
                'anu_Estatus' => $post['anu_Estatus']
            );
            $builder = db()->table('anuncio');
            $builder->insert($data);
            $id = $this->db->insertID();
            if ($id) {
                $directorio = dirname(WRITEPATH) . "/assets/uploads/anuncios/" . encryptDecrypt('encrypt', $id) . '/';
                if (!file_exists($directorio)) {
                    mkdir($directorio, 0777, true);
                }
                $tmpFilePath = $_FILES['files']['tmp_name'];
                if ($tmpFilePath != "") {
                    $newFilePath = $directorio . $_FILES['files']['name'];
                    move_uploaded_file($tmpFilePath, $newFilePath);
                }
                $code = 1;
            }
        } else {
            $code = 2;
        }

        switch ($code) {
            case 1:
                $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => 'Se ha guardado el anuncio ' . $msg));
                break;
            case 2:
                $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => 'Existe otro anuncio con el mismo nombre'));
                break;
            case 0:
                $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error intente mas tarde!'));
                break;
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }

    public function estatusAnuncio($estatus, $id)
    {
        $anuncioActivo = $this->db->query("SELECT * FROM anuncio WHERE anu_Estatus=1 AND anu_AnuncioID!=?", array(encryptDecrypt('decrypt', $id)))->getRowArray();
        if ($anuncioActivo) {
            $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => 'Existe otro anuncio habilitado, deshabilitalo para poder continuar'));
        } else {
            $builder = db()->table('anuncio');
            $result = $builder->update(array('anu_Estatus' => $estatus), array('anu_AnuncioID' => encryptDecrypt('decrypt', $id)));
            if ($result) {
                $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => 'Se ha actualizado el anuncio'));
            } else {
                $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => 'No se ha podido actualizar el anuncio'));
            }
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }

    public function borrarAnuncio($id)
    {
        $url = FCPATH . "/assets/uploads/anuncios/" . $id . "/";
        if (!file_exists($url)) mkdir($url, 0777, true);
        $files = preg_grep('/^([^.])/', scandir($url));
        $builder = db()->table('anuncio');
        if ($files) {
            sort($files);
            if (unlink($url . $files[0])) {
                $builder->delete(array("anu_AnuncioID" => encryptDecrypt('decrypt', $id)));
                $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => 'Se ha eliminado el anuncio'));
            } else {
                $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => 'No se ha podido eliminar el anuncio'));
            }
        } else {
            $builder->delete(array("anu_AnuncioID" => encryptDecrypt('decrypt', $id)));
            $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => 'Se ha eliminado el anuncio'));
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }
    /*
                   _         __   __
         /\       | |  /\    \ \ / /
        /  \      | | /  \    \ V /
       / /\ \ _   | |/ /\ \    > <
      / ____ \ |__| / ____ \  / . \
     /_/    \_\____/_/    \_\/_/ \_\
    */

    //Lia->trae los cumpleaños de los colaboradores
    public function ajax_getCumpleanios()
    {
        $model = new UsuarioModel();
        $cumpleanios = $model->getInformacionCumpleaños();
        $data_cumpleanios = array();

        foreach ($cumpleanios as $c) {
            if ($c['emp_FechaNacimiento'] != "0000-00-00") {
                for ($i = 1; $i <= 3; $i++) {
                    $fecha = $c['emp_FechaNacimiento'];
                    $fechaentero = strtotime($fecha);
                    $dia = date("d", $fechaentero);
                    $mes = date("m", $fechaentero);
                    $anoactual = date("Y");
                    switch ($i) {
                        case 1:
                            $anoactual = (int)$anoactual;
                            break;
                        case 2:
                            $anoactual = (int)$anoactual + 1;
                            break;
                        case 3:
                            $anoactual = (int)$anoactual + 2;
                            break;
                    }
                    $cumple = $anoactual . "-" . $mes . "-" . $dia;
                    $titulo = $c['emp_Nombre'];
                    $data_cumpleanios[] = array(
                        "title" => $titulo,
                        "start" => $cumple,
                        "end" => $cumple . " 23:59:00",
                        "allDay" => true,
                        'tipo' => "cumple",
                        'className' => "bg-purple",
                        'img' => fotoPerfil(encryptDecrypt('encrypt', $c['emp_EmpleadoID']))
                    );
                }
            }
        }
        echo json_encode(array("events" => $data_cumpleanios));
    }

    //Lia->trae los cumpleaños de los colaboradores
    public function ajax_getGuardia()
    {
        $model = new UsuarioModel();
        $guardias = $model->getInformacionGuardia();
        $data_guardias = array();
        foreach ($guardias as $i) {
            $titulo = 'Guardia';
            $inicio = $i['gua_FechaFin'];
            $fin = $i['gua_FechaFin'];
            $data_guardias[] = array(
                "title" => $titulo,
                "start" => $inicio,
                "end" => $fin . " 23:59:00",
                "allDay" => true,
                'tipo' => "guardia",
                'className' => "bg-info",
                'img' => ""
            );
        }
        echo json_encode(array("events" => $data_guardias));
    }

    //Lia->trae los dias inhabiles de ley para el calendario
    public function ajax_getInhabilesLey()
    {
        $model = new UsuarioModel();
        $inhabiles = $model->getDiasInhabilesLey();
        $data_inhabilesLey = array();
        foreach ($inhabiles as $i) {
            $titulo = $i['dial_Motivo'];
            $inicio = $i['dial_Fecha'];
            $fin = $i['dial_Fecha'];
            $data_inhabilesLey[] = array(
                "title" => $titulo,
                "start" => $inicio,
                "end" => $fin . " 23:59:00",
                "allDay" => true,
                'tipo' => "inhabilLey",
                'className' => "bg-danger",
                'img' => ""
            );
        }
        echo json_encode(array("events" => $data_inhabilesLey));
    }

    //Lia->trae los dias inhabiles de la empresa para el calendario
    public function ajax_getInhabiles()
    {
        $model = new UsuarioModel();
        $inhabilesempresa = $model->getDiasInhabiles();
        $data_inhabiles = array();

        foreach ($inhabilesempresa as $ie) {
            $titulo = $ie['dia_Motivo'];
            $inicio = $ie['dia_Fecha'];
            $fin = $ie['dia_Fecha'];
            $data_inhabiles[] = array(
                "title" => $titulo,
                "start" => $inicio,
                "end" => $fin . " 23:59:00",
                'tipo' => "inhabil",
                'className' => "bg-success",
                'img' => ""
            );
        }
        echo json_encode(array("events" => $data_inhabiles));
    }

    //Diego->trae los aniversarios por empleado
    public function ajax_getAniversario()
    {
        $model = new UsuarioModel();
        $aniversario = $model->getAniversarios();
        $data_aniversario = array();

        foreach ($aniversario as $aniv) {
            $fecha = $aniv['emp_FechaIngreso'];
            $fechaentero = strtotime($fecha);
            $dia = date("d", $fechaentero);
            $mes = date("m", $fechaentero);
            $anoactual = date("Y");

            $inicio = $anoactual . "-" . $mes . "-" . $dia;
            $fin = $anoactual . "-" . $mes . "-" . $dia;

            $anio = date('Y') - $aniv['year'];
            $titulo = '#' . $anio . ' ' . $aniv['emp_Nombre'];
            $data_aniversario[] = array(
                "title" => $titulo,
                "start" => $inicio,
                "allDay" => true,
                "end" => $fin . " 23:59:00",
                'tipo' => "aniversario",
                'className' => "bg-primary",
                'img' => fotoPerfil(encryptDecrypt('encrypt', $aniv['emp_EmpleadoID']))
            );
        }
        echo json_encode(array("events" => $data_aniversario));
    }

    //Lia->trae los periodos de evaluaciones para el calendario
    public function ajax_getEvaluaciones()
    {
        $model = new UsuarioModel();
        $evaluaciones = $model->getPeriodosEvaluaciones();
        $data_evaluaciones = array();
        foreach ($evaluaciones as $evaluacion) {
            $titulo = "";
            $inicio = $evaluacion['eva_FechaInicio'];
            $fin = $evaluacion['eva_FechaFin'];
            $className = "";
            if ($evaluacion['eva_Tipo'] == 'Desempeño') {
                $className = "bg-warning";
                $titulo = "Evaluación de desempeño";
            } else if ($evaluacion['eva_Tipo'] == 'Competencias') {
                $className = "bg-info";
                $titulo = "Evaluación de competencias";
            } else if ($evaluacion['eva_Tipo'] == 'Departamentos') {
                $className = "bg-pink";
                $titulo = "Evaluación de departamentos";
            } else if ($evaluacion['eva_Tipo'] == 'Clima Laboral') {
                $className = "bg-primary";
                $titulo = "Evaluación de clima laboral";
            } else if ($evaluacion['eva_Tipo'] == 'Sucursales') {
                $className = "bg-secondary";
                $titulo = "Evaluación de sucursales";
            } else if ($evaluacion['eva_Tipo'] == 'Nom035') {
                $className = "bg-secondary";
                $titulo = "Evaluación Nom 035";
            }

            $data_evaluaciones[] = array(
                "title" => $titulo,
                "start" => $inicio,
                "end" => $fin . ' 23:59:59',
                "allDay" => true,
                'tipo' => "evaluacion",
                'className' => $className,
                'img' => ""
            );
        }
        echo json_encode(array("events" => $data_evaluaciones));
    }

    //Diego->trae los aniversarios por empleado
    public function ajax_getCapacitaciones()
    {
        $model = new UsuarioModel();
        $idEmpleado = session('id');
        $cursos = $model->getCursosByEmpleado($idEmpleado);
        $data_capacitaciones = array();

        if (!empty($cursos)) {
            foreach ($cursos as $curso) {
                $convocatoria = convocatoriaCapacitacionJquery((int)$curso['cap_CapacitacionID']);
                $fechas = json_decode($curso['cap_Fechas'], true);

                $txtFechas = "";
                for ($i = 0; $i < count($fechas); $i++) {
                    $inicio = $fechas[$i]['fecha'] . " " . $fechas[$i]['inicio'];
                    $fin = $fechas[$i]['fecha'] . " " . $fechas[$i]['fin'];

                    $txtFechas = shortDate($fechas[$i]['fecha'], ' de ') . ' de ' . shortTime($fechas[$i]['inicio']) . ' a ' . shortTime($fechas[$i]['fin']) . '.';
                    $texto = 'Se le convoca a la capacitación ' . $curso['cur_Nombre'] . ' que se llevara a cabo en ' . $curso['cap_Lugar'] . ' el dia ' . $txtFechas;

                    $data_capacitaciones[] = array(
                        "title" => $curso['cur_Nombre'],
                        "start" => $inicio,
                        "end" => $fin,
                        'tipo' => "capacitacion",
                        'className' => "bg-dark",
                        'img' => $convocatoria[0] ?? null,
                        'texto' => $texto
                    );
                }
            }
        }
        echo json_encode(array("events" => $data_capacitaciones));
    }

    //Diego->trae vacaciones del empleado
    public function ajax_getVacaciones()
    {
        $model = new UsuarioModel();
        $vacaciones = $model->getVacaciones();
        $data_vacaciones = array();

        foreach ($vacaciones as $vac) {
            $data_vacaciones[] = array(
                "title" => 'Mis vacaciones',
                "start" => $vac['vac_FechaInicio'] . " 00:01:01",
                "end" => $vac['vac_FechaFin'] . " 23:59:00",
                'tipo' => "vacaciones",
                "allDay" => true,
                'className' => "#f7dd7d",
                'backgroundColor' => '#f7dd7d',
                'img' => ""
            );
        }
        echo json_encode(array("events" => $data_vacaciones));
    }

    //Diego -> trae informacion de incidencias empleado
    public function ajax_getInfoIncidenciasByEmpleado($empleadoID)
    {
        $empleadoID = encryptDecrypt('decrypt', $empleadoID);
        $builder = db()->table("empleado");
        $empleado = $builder->getWhere(array("emp_EmpleadoID" => $empleadoID))->getRowArray();

        $diasLey = diasLey($empleado['emp_FechaIngreso']);
        $antiguedad = antiguedad($empleado['emp_FechaIngreso']) < 1  ? antiguedad($empleado['emp_FechaIngreso']) . ' meses' : antiguedad($empleado['emp_FechaIngreso']) . ' años';
        $diasPendientes = diasPendientes($empleadoID);
        $diasRestantes = $diasPendientes;
        $model = new UsuarioModel();
        //$horas=$model->getHorasExtraByEmpleadoID($empleadoID);
        $estatus = array("PENDIENTE", 'AUTORIZADO', 'AUTORIZADO_RH');
        $estatus = join("','", $estatus);
        $url = fotoPerfil(encryptDecrypt('encrypt', $empleadoID));
        $puesto = $this->db->query("SELECT pue_Nombre FROM puesto WHERE pue_PuestoID=" . $empleado['emp_PuestoID'])->getRowArray();
        //$diasOcupados = $diasLey - $diasRestantes;
        $diasOcupados = diasOcupados($empleado['emp_EmpleadoID'], $empleado['emp_FechaIngreso']);
        $permisosTomados = $this->db->query("SELECT COUNT(per_PermisoID) as 'total' FROM permiso WHERE per_Estatus=1 AND per_EmpleadoID=" . $empleadoID . " AND per_Estado='AUTORIZADO_RH'")->getRowArray();


        $data = array(
            "diasley" => $diasLey,
            "diasRestantes" => $diasRestantes,
            "antiguedad" => $antiguedad,
            "fechaIngreso" => longDate($empleado['emp_FechaIngreso'], ' de '),
            "fotoPerfil" => $url,
            "nombre" => $empleado['emp_Nombre'],
            "puesto" => $puesto['pue_Nombre'],
            "ocupados" => $diasOcupados,
            "permisosTomados" => $permisosTomados['total'],
            //"horas"=>(int)$horas

        );
        echo json_encode(array("response" => "success", "result" => $data));
    }

    //Lia->Actualizar foto perfil
    public function ajax_fotoPerfil()
    {

        $empleadoID = (int)session('id');
        $data['code'] = 1;

        //Si selecciono imagen de pérfil actualiza
        $pathInfo = pathInfo($_FILES['fileProfilePhoto']['name']);
        $x = $_FILES['fileProfilePhoto']['tmp_name'];

        if ($x != "" && $x != null) { //If seleccionó imagen

            $url = FCPATH . "/assets/uploads/fotosPerfil/";

            if (!file_exists($url)) {
                mkdir($url, 0777, true);
            }
            //Subir nueva foto
            $extFile = $pathInfo['extension'];
            if ($extFile == 'jpg' || $extFile == 'png') {
                $fileName = $empleadoID . "-Empleado." . $extFile;

                if (file_exists($url . $empleadoID . "-Empleado.jpg")) unlink($url . $empleadoID . "-Empleado.jpg");
                if (file_exists($url . $empleadoID . "-Empleado.png")) unlink($url . $empleadoID . "-Empleado.png");
                move_uploaded_file($_FILES['fileProfilePhoto']['tmp_name'], $url . $fileName);
            } //if
        } //if
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_fotoPerfil

    //Lia->Actualizar password
    public function ajax_actualizarPassword()
    {
        $data['code'] = 0;
        $empleadoID = (int)session("id");
        $password = encryptKey(post("pw"));
        $response = update('empleado', ['emp_Password' => $password], ['emp_EmpleadoID' => $empleadoID]);
        if ($response) $data['code'] = 1;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_actualizarPassword


    //Diego->cambia el estatus a la notificacion
    public function ajax_notificacionVista()
    {
        update('notificacion',array('not_Estatus' => 0), array('not_NotificacionID' => post('id')));
        echo json_encode(array('response' => 'success', 'link' => post('link')));
    }

    public function ajaxGetMisPrestaciones()
    {
        $idEmpleado = session('id');
        $builder = db()->table("empleado");
        $empleado = $builder->getWhere(array("emp_EmpleadoID" => $idEmpleado))->getRowArray();

        $diasLey = diasLey($empleado['emp_FechaIngreso']);
        $prima = prima($empleado['emp_FechaIngreso']);
        $aguinaldo = aguinaldo($empleado['emp_FechaIngreso']);
        $antiguedad = antiguedad($empleado['emp_FechaIngreso']);
        $diasPendientes = diasPendientes($idEmpleado);
        $diasRestantes = $diasPendientes;
        $model = new UsuarioModel();
        $horasExtra = $model->getHorasExtra();

        $data = array(
            "diasley" => $diasLey,
            "vacaciones" => $diasRestantes,
            "prima" => $prima,
            "aguinaldo" => $aguinaldo,
            "antiguedad" => $antiguedad,
            "horasExtra" => $horasExtra
        );

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    public function getNotificacionesPush()
    {
        $notificaciones = $this->BaseModel->getNotificacionesPush();
        if (count($notificaciones) > 0) {
            foreach ($notificaciones as &$notificacion) {
                update('notificacion', ['not_Push' => 0], ['not_NotificacionID' => $notificacion['not_NotificacionID']]);
            }
        }
        $data['notificaciones'] = $notificaciones;
        echo json_encode($data, JSON_PRETTY_PRINT);
    }

    public function ajax_getComunicados()
    {
        $model = new UsuarioModel();
        $comunicados = $model->getComunicados();
        $data['data'] = $comunicados;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    public function ajax_getNormativas()
    {
        $idPuesto = session('puesto');
        $idEmpleado = session('id');



        $sql = "SELECT P.*, MAX(N.not_NotiPoliticaID) AS max_not_NotiPoliticaID, N.*
        FROM politica P
        JOIN notipolitica N ON P.pol_PoliticaID = N.not_PoliticaID
        WHERE N.not_EmpleadoID = " . $idEmpleado . " AND P.pol_Estatus = 1
        GROUP BY P.pol_PoliticaID";
        $result =  $this->db->query($sql)->getResultArray();

        $politicas = array();
        $pol = array();
        foreach ($result as $item) {
            $puestos = json_decode($item['pol_Puestos']);
            foreach ($puestos as $puesto) {
                if ((int)$puesto === (int)$idPuesto || (int)$puesto === 0) {

                    $documento = ultimoDocumentoPolitica((int)$item['pol_PoliticaID']);
                    $html = '';
                    if (!empty($documento)) {
                        $rest = strtolower(substr($documento, -3));
                        if ($rest == "pdf") {
                            $imagen = base_url('assets/images/file_icons/pdf.svg');
                        }


                        $archivoNombre = explode('/', $documento);
                        $count = count($archivoNombre) - 1;
                        $nombre = explode('.', $archivoNombre[$count]);

                        $html = '
                                <div class="file-img-box">
                                    <img src="' . $imagen . '" class="avatar-sm" alt="icon">
                                </div>
                                <a href="' . $documento . '" class="file-download show-pdf vistoPolitica" data-id="' . $item['not_NotiPoliticaID'] . '" data-title="' . $nombre[0] . ' " ><i
                                        class="fa fa-eye"></i> </a>
                                <div class="file-man-title">
                                    <p class="mb-0 text-overflow">' . $nombre[0] . ' </p>
                                </div>
                           ';
                    }
                    $pol['id'] = $item['pol_PoliticaID'];
                    $pol['no'] = $item['pol_No'];
                    $pol['nombre'] = $item['pol_Nombre'];
                    if (isMobile()) {
                        $pol['documento'] = 'El archivo solo se puede visualizar en tu computadora.';
                    } else {
                        $pol['documento'] = $html;
                    }
                    $pol['idNoti'] = $item['not_NotiPoliticaID'];
                    $pol['enterado'] = (int)$item['not_Enterado'];
                    array_push($politicas, $pol);
                }
            }
        }
        $data['data'] = $politicas;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    public function ajaxEnteradoPolitica()
    {
        $post = $this->request->getPost();
        $idPolitica = $post['politicaID'];
        $data['code'] = 0;
        $builder = $this->db->table('notipolitica');
        $builder->update(array('not_Enterado' => 1), array('not_NotiPoliticaID' => $idPolitica));
        if ($this->db->affectedRows() > 0) {
            $data['code'] = 1;
        }
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    //Fer ajaxVistoPolitica
    public function ajaxVistoPolitica()
    {
        $post = $this->request->getPost();
        $idPolitica = $post['politicaID'];
        $data['code'] = 0;
        $builder = $this->db->table('notipolitica');
        $builder->update(array('not_Visto' => 1), array('not_NotiPoliticaID' => $idPolitica));
        if ($this->db->affectedRows() > 0) {
            $data['code'] = 1;
        }
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajaxVistoPolitica


    function pass()
    {
        $Pas = encryptKey('1');

        echo $Pas;
    }

    public function equipoOperativo()
    {
        $empleado = session('numero');

        if (session('puesto') === '1') { //Gerente general ve las incidencias de todos
            $equipo = $this->getColaboradoresCGerenteG();
        } else { //GErente operativo ve las incidencias del personal op
            $equipo = $this->getSubordinadosEmpleado($empleado);
        }


        //Vacaciones
        foreach ($equipo as $equi) {
            $vacaciones = $this->db->query("SELECT emp_Nombre,vac_FechaInicio,DATE_ADD(vac_FechaFin, Interval 1 day) as 'vac_FechaFin' , vac_VacacionesID FROM vacacion JOIN empleado ON emp_EmpleadoID=vac_EmpleadoID WHERE vac_Estatus='AUTORIZADO_RH' AND emp_EmpleadoID=" . $equi['id'])->getResultArray();
            foreach ($vacaciones as $vac) {
                $data_vacaciones[] = array(
                    "title" => $vac['emp_Nombre'],
                    "start" => $vac['vac_FechaInicio'] . " 00:01:01",
                    "end" => $vac['vac_FechaFin'] . " 23:59:00",
                    'tipo' => "vacaciones",
                    "allDay" => true,
                    'className' => "bg-primary",
                    'id' => encryptDecrypt('encrypt', $vac['vac_VacacionesID']),
                    'sucursal' => $equi['sucursal']
                );
            }
        }

        //Permisos
        foreach ($equipo as $equi) {
            $permisos = $this->db->query("SELECT emp_Nombre,per_FechaInicio,DATE_ADD(per_FechaFin, Interval 1 day) as 'per_FechaFin', per_PermisoID FROM permiso JOIN empleado ON emp_EmpleadoID=per_EmpleadoID WHERE per_Estatus='AUTORIZADO_RH' AND emp_EmpleadoID=" . $equi['id'])->getResultArray();
            foreach ($permisos as $per) {
                $data_permisos[] = array(
                    "title" => $per['emp_Nombre'],
                    "start" => $per['per_FechaInicio'] . " 00:01:01",
                    "end" => $per['per_FechaFin'] . " 23:59:00",
                    'tipo' => "permisos",
                    "allDay" => true,
                    'className' => "bg-success",
                    'id' => encryptDecrypt('encrypt', $per['per_PermisoID']),
                    'sucursal' => $equi['sucursal']
                );
            }
        }

        //Incapacidades
        foreach ($equipo as $equi) {
            $incapacidades = $this->db->query("SELECT emp_Nombre,inc_FechaInicio,DATE_ADD(inc_FechaFin, Interval 1 day) as 'inc_FechaFin', inc_IncapacidadID FROM incapacidad JOIN empleado ON emp_EmpleadoID=inc_EmpleadoID WHERE inc_Estatus='Autorizada' AND emp_EmpleadoID=" . $equi['id'])->getResultArray();
            foreach ($incapacidades as $inc) {
                $data_incapacidades[] = array(
                    "title" => $inc['emp_Nombre'],
                    "start" => $inc['inc_FechaInicio'] . " 00:01:01",
                    "end" => $inc['inc_FechaFin'] . " 23:59:00",
                    'tipo' => "incapacidades",
                    "allDay" => true,
                    'className' => "bg-dark",
                    'id' => encryptDecrypt('encrypt', $inc['inc_IncapacidadID']),
                    'sucursal' => $equi['sucursal']
                );
            }
        }

        $eventos = $data_vacaciones;

        if (isset($data_permisos)) {
            $eventos = array_merge($data_vacaciones, $data_permisos);
        }
        if (isset($data_incapacidades)) {
            $eventos = array_merge($data_vacaciones, $data_permisos, $data_incapacidades);
        }

        echo json_encode(array("events" =>  $eventos));
    }


    function getSubordinadosEmpleado($empleado)
    {

        $empleados = array();

        $sql = "SELECT E.emp_EmpleadoID AS 'id', E.emp_Numero AS 'numero', E.emp_Nombre AS 'name' , P.pue_Nombre AS 'puesto',
                    S.suc_Sucursal AS 'sucursal'
            FROM empleado E
            LEFT JOIN puesto P ON P.pue_PuestoID=E.emp_PuestoID
            LEFT JOIN sucursal S ON S.suc_SucursalID=E.emp_SucursalID
            WHERE E.emp_Estatus = 1 AND E.emp_Jefe=?";
        $subordinados = $this->db->query($sql, array($empleado))->getResultArray();

        if (count($subordinados) > 0) {
            foreach ($subordinados as $subordinado) {
                array_push($empleados, $subordinado);
                $recEmpleados = $this->getSubordinadosEmpleado($subordinado['numero']);
                foreach ($recEmpleados as $empleado) {
                    array_push($empleados, $empleado);
                }
            }
        }
        return $empleados;
    }

    function getColaboradoresCGerenteG()
    {

        $sql = "SELECT E.emp_EmpleadoID AS 'id', E.emp_Numero AS 'numero', E.emp_Nombre AS 'name' , P.pue_Nombre AS 'puesto',
                    S.suc_Sucursal AS 'sucursal'
            FROM empleado E
            LEFT JOIN puesto P ON P.pue_PuestoID=E.emp_PuestoID
            LEFT JOIN sucursal S ON S.suc_SucursalID=E.emp_SucursalID
            WHERE E.emp_Estatus = 1 ";
        $empleados = $this->db->query($sql)->getResultArray();
        return $empleados;
    }

    public function ajax_felicitacion()
    {
        $idEmpleado = session('id');

        $model = new UsuarioModel();
        $sesion = $model->getUltimaSesionDia($idEmpleado);
        $empleado = $model->miInformacion();

        $fecha = $empleado['nacimiento'];
        $fechaentero = strtotime($fecha);
        $dia = date("d", $fechaentero);
        $mes = date("m", $fechaentero);
        $anoactual = date("Y");

        $cumple = $anoactual . "-" . $mes . "-" . $dia;

        if ($cumple === date('Y-m-d')) {
            if ($sesion['acc_Felicitacion'] == 1) {
                $data = array(
                    "titulo" => $empleado['nombre'],
                    "video" => '<iframe width="600" height="355" src="' . base_url('assets/videos/cumple.mp4') . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'
                );
                echo json_encode($data, JSON_UNESCAPED_SLASHES);

                $builder = $this->db->table('acceso');
                $builder->update(array('acc_Felicitacion' => 0), array('acc_AccesoID' => $sesion['acc_AccesoID']));
            }
        }
    }

    public function ajax_felicitacionAniv()
    {
        $idEmpleado = session('id');

        $model = new UsuarioModel();
        $sesion = $model->getUltimaSesionDia($idEmpleado);
        $empleado = $model->miInformacion();

        $fecha = $empleado['ingreso'];
        $fechaentero = strtotime($fecha);
        $dia = date("d", $fechaentero);
        $mes = date("m", $fechaentero);
        $anoactual = date("Y");

        $cumple = $anoactual . "-" . $mes . "-" . $dia;

        if ($cumple === date('Y-m-d')) {
            if ($sesion['acc_Aniversario'] == 1) {
                $data = array(
                    "titulo" => $empleado['nombre'],
                    "video" => '<iframe width="600" height="355" src="' . base_url('assets/videos/aniversario.mp4') . '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>'
                );
                echo json_encode($data, JSON_UNESCAPED_SLASHES);

                $builder = $this->db->table('acceso');
                $builder->update(array('acc_Aniversario' => 0), array('acc_AccesoID' => $sesion['acc_AccesoID']));
            }
        }
    }

    public function getNotificacionesList()
    {
        $notificaciones = $this->BaseModel->getNotificaciones();

        $html = '';
        $notify = false;
        if (count($notificaciones) > 0) { // si el numero de mensajes es mayor a 0
            foreach ($notificaciones as $not) {

                $url = isset($not['not_URL']) ? $not['not_URL'] : '#';
                $color = isset($not['not_Color']) ? $not['not_Color'] : 'bg-green';
                $icono = isset($not['not_Icono']) ? $not['not_Icono'] : 'zmdi zmdi-comment-alert';
                $descripcion = isset($not['not_Descripcion']) ? $not['not_Descripcion'] : '';
                $fechaRegistro = $not['not_FechaRegistro'];

                // Construye el HTML
                $html .= '<li> 
                        <a href="' . $url . '" class="checkNotificacion" data-id="' . $not['not_NotificacionID'] . '" data-link="' . $url . '">
                            <div class="icon-circle ' . $color . '">
                                <i class="' . $icono . '"></i>
                            </div>
                            <div class="menu-info">
                                <h4>' . $descripcion . '</h4>
                                <p><i class="zmdi zmdi-time"></i> ' . diferenciaTiempo($fechaRegistro, date('Y-m-d H:i:s')) . ' </p>
                            </div>
                        </a> 
                    </li>';
            }
            $notify = true;
        }

        $data['style'] = $notify;
        $data['notificaciones'] = $html;
        echo json_encode($data);
    }

    public function ajax_limpiarNotifaciones()
    {
        $builder = $this->db->table('notificacion');
        $result = $builder->update(array("not_Estatus" => 0), array("not_EmpleadoID" => session('id'), "not_Estatus" => 1));
        $data['response'] = $result ? 'success' : 'error';
        echo json_encode($data['response']);
    }

    public function ajax_limpiarNotifacionesTicket()
    {
        $builder = mesa()->table('notificacion');
        $result = $builder->update(array("not_Estatus" => 0), array("not_UsuarioID" => usuarioID(), "not_UsuarioTipo" => 'AGENTE', "not_Estatus" => 1));
        $data['response'] = $result ? 'success' : 'error';
        echo json_encode($data['response']);
    }

    public function ajax_GetRecibosNomina()
    {
        $empleado = db()->query("SELECT emp_Nombre, emp_Numero, emp_EmpleadoID, YEAR(emp_FechaIngreso) as 'emp_FechaIngreso' FROM empleado WHERE emp_EmpleadoID=" . session('id'))->getRowArray();
        $url = FCPATH . "/assets/uploads/recibosnomina/";

        if (!file_exists($url)) mkdir($url, 0777, true);

        $anios = preg_grep('/^([^.])/', scandir($url));
        $anioIngreso = $empleado['emp_FechaIngreso'];

        $anios = array_filter($anios, function ($anio) use ($anioIngreso) {
            return intval($anio) >= $anioIngreso;
        });

        $tree = array_map(function ($anio) use ($url, $empleado) {
            $children = [];
            $num = $empleado['emp_Numero'];
            $id = encryptDecrypt('encrypt', $empleado['emp_EmpleadoID']);
            $periodos = preg_grep('/^([^.])/', scandir($url . '/' . $anio . '/' . $id));

            foreach ($periodos as $periodo) {
                $urlD = base_url("/assets/uploads/recibosnomina/" . $anio . '/' . $id . '/' . $periodo);
                $children[] = [
                    "id" => $anio . $num . $periodo,
                    "text" => $anio . $num . $periodo,
                    "icon" => "mdi mdi-zip-box ",
                    "state" => ["opened" => false, "disabled" => false],
                    "a_attr" => ["href" => $urlD],
                    "li_attr" => ["tipo" => "periodo"]
                ];
            }

            return [
                "text" => $anio,
                "state" => ["opened" => true, "disabled" => false, "selected" => false],
                "children" => $children,
                "li_attr" => ["tipo" => "year"]
            ];
        }, $anios);

        echo json_encode($tree);
    }


    public function ajax_getAnuncio()
    {
        $anuncios = $this->db->query("SELECT * FROM anuncio ORDER BY anu_AnuncioID DESC")->getResultArray();
        $data = array();
        foreach ($anuncios as $anuncio) {
            $anuncio['anu_AnuncioID'] = encryptDecrypt('encrypt', $anuncio['anu_AnuncioID']);
            $anuncio['anu_FechaRegistro'] = longDate($anuncio['anu_FechaRegistro']);
            if (archivoAnuncio($anuncio['anu_AnuncioID'])) {
                $anuncio['archivo'] = archivoAnuncio($anuncio['anu_AnuncioID']);
            }
            array_push($data, $anuncio);
        }
        $data['data'] = $data;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }
}
