<?php

namespace App\Controllers;

use App\Models\PersonalModel;
use App\Models\MesaAyudaModel;

defined('FCPATH') or exit('No direct script access allowed');

class MesaAyuda extends BaseController
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

    public function index(){
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Mesa de ayuda';
        $data['breadcrumb'] = array(
            array('titulo' => 'Panel', 'link' => base_url('MesaAyuda/index'), 'class' => 'active'),
        );

        $model = new MesaAyudaModel();
        $data['areas']=$model->getAreas();
        $data['totales']=$model->getTotalesMisTickets();
        $data['ticketsPendientesEncuesta']=$model->getTicketsPendienteEncuesta();
        $data['ticketsEsperaRespuesta']=$model->getTicketsEsperaRespuesta();


        $data['styles'][] = base_url('assets/libs/select2/css/select2.min.css');
        $data['styles'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.css');
        $data['styles'][] = base_url('assets/libs/summernote/summernote-bs4.css');
        $data['styles'][] = base_url('assets/plugins/fileinput/css/fileinput.css');
        $data['styles'][] = "https://use.fontawesome.com/releases/v5.5.0/css/all.css";
        $data['styles'][] = base_url('assets/plugins/fileinput/themes/explorer-fas/theme.css');


        $data['scripts'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.js');
        $data['scripts'][] = base_url('assets/libs/select2/js/select2.full.min.js');
        $data['scripts'][] = base_url('assets/libs/summernote/summernote-bs4.min.js');
        $data['scripts'][] = base_url('assets/libs/summernote/lang/summernote-es-ES.js');
        $data['scripts'][] = base_url('assets/plugins/fileinput/js/fileinput.js');
        $data['scripts'][] = base_url('assets/plugins/fileinput/js/locales/es.js');
        $data['scripts'][] = base_url('assets/plugins/fileinput/themes/fas/theme.js');
        $data['scripts'][] = base_url('assets/plugins/fileinput/themes/explorer-fas/theme.js');

        //custom
        $data['scripts'][] = base_url("assets/js/mesadeayuda/index.js");

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('mesaAyuda/index', $data);
        echo view('mesaAyuda/modalTicket', $data);
        echo view('htdocs/footer');
    } //INDEX

    public function misTickets(){
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Mis tickets';
        $data['breadcrumb'] = array(
            array('titulo' => 'Panel', 'link' => base_url('MesaAyuda/index'), 'class' => ''),
            array('titulo' => 'Mis tickets', 'link' => base_url('MesaAyuda/misTickets'), 'class' => 'active'),
        );

        $model = new MesaAyudaModel();
        $data['areas']=$model->getAreas();
        $data['tickets']=$model->getMisTickets();

        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] = base_url('assets/libs/select2/css/select2.min.css');
        $data['styles'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.css');
        $data['styles'][] = base_url('assets/libs/summernote/summernote-bs4.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');
        $data['styles'][]="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/css/fileinput.css"; //Bootstrap FileInput


        $data['scripts'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.js');
        $data['scripts'][] = base_url('assets/libs/select2/js/select2.full.min.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/jquery.dataTables.min.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/js/dataTables.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/dataTables.buttons.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/JSZip-2.5.0/jszip.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/pdfmake.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/vfs_fonts.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.html5.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.colVis.js');
        $data['scripts'][] = base_url('assets/libs/summernote/summernote-bs4.min.js');
        $data['scripts'][] = base_url('assets/libs/summernote/lang/summernote-es-ES.js');
        $data['scripts'][] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/fileinput.js"; //Bootstrap FileInput
        $data['scripts'][] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/locales/es.js"; //Bootstrap FileInput Spanish

        //custom
        $data['scripts'][] = base_url("assets/js/mesadeayuda/misTickets.js");

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('mesaAyuda/misTickets', $data);
        echo view('mesaAyuda/modalTicket', $data);
        echo view('mesaAyuda/modalEncuesta', $data);
        echo view('htdocs/footer');
    } //INDEX

    public function usuarios(){
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Usuarios';
        $data['breadcrumb'] = array(
            array('titulo' => 'Panel', 'link' => base_url('MesaAyuda/index'), 'class' => ''),
            array('titulo' => 'Usuarios', 'link' => base_url('MesaAyuda/usuarios'), 'class' => 'active'),
        );

        $model = new MesaAyudaModel();
        $data['colaboradores'] = $model->getEmpleados();

        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] = base_url('assets/libs/select2/css/select2.min.css');
        $data['styles'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');

        $data['scripts'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.js');
        $data['scripts'][] = base_url('assets/libs/select2/js/select2.full.min.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/jquery.dataTables.min.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/js/dataTables.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/dataTables.buttons.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/JSZip-2.5.0/jszip.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/pdfmake.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/vfs_fonts.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.html5.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.colVis.js');

        //custom
        $data['scripts'][] = base_url("assets/js/mesadeayuda/usuarios.js");

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('mesaAyuda/usuarios', $data);
        echo view('htdocs/footer');
    } //INDEX

    public function ticket($ticketID)
    {
        //validarSesion(self::LOGIN_TYPE);
        $model = new MesaAyudaModel();
        $data['ticket']=$model->getInfoTicket($ticketID);

        $data['title'] = 'Ticket';
        if($data['ticket']['tic_UsuarioID']!==usuarioID()){
            $data['breadcrumb'] = array(
                array("titulo" => 'Tickets cooperativa', "link" => base_url('MesaAyuda/ticketsCoop'), "class" => ""),
                array("titulo" => 'Ticket', "link" => base_url('MesaAyuda/ticket/' . $ticketID), "class" => "active"),
            );
        }else{
            $data['breadcrumb'] = array(
                array("titulo" => 'Mis tickets', "link" => base_url('MesaAyuda/misTickets'), "class" => ""),
                array("titulo" => 'Ticket', "link" => base_url('MesaAyuda/ticket/' . $ticketID), "class" => "active"),
            );
        }

        //styles
        $data['styles'][] = base_url('assets/libs/spinkit/spinkit.css');
        $data['styles'][] = base_url("assets/libs/select2/select2.min.css");
        $data['styles'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.css");
        $data['styles'][] = base_url('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css');
        $data['styles'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css');
        $data['styles'][] = base_url('assets/libs/summernote/summernote-bs4.css');

        //scripts
        $data['scripts'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.min.js");
        $data['scripts'][] = base_url("assets/libs/select2/select2.min.js");
        $data['scripts'][] = base_url('assets/plugins/moment/min/moment.min.js');
        $data['scripts'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js');
        $data['scripts'][] = base_url('assets/libs/summernote/summernote-bs4.min.js');
        $data['scripts'][] = base_url('assets/libs/summernote/lang/summernote-es-ES.js');
        $data['scripts'][] = base_url('assets/js/mesadeayuda/infoTicket.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('mesaAyuda/ticket', $data);
        echo view('mesaAyuda/modalEncuesta', $data);
        echo view('htdocs/footer');
    }

    public function ticketsCoop(){
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Tickets cooperativa';
        $data['breadcrumb'] = array(
            array('titulo' => 'Panel', 'link' => base_url('MesaAyuda/index'), 'class' => 'active'),
            array('titulo' => 'Tickets cooperativa', 'link' => base_url('MesaAyuda/ticketsCoop'), 'class' => 'active'),
        );

        $model = new MesaAyudaModel();
        $data['tickets']=$model->getTicketsCooperativa();

        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] = base_url('assets/libs/select2/css/select2.min.css');
        $data['styles'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.css');
        $data['styles'][] = base_url('assets/libs/summernote/summernote-bs4.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');
        $data['styles'][]="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/css/fileinput.css"; //Bootstrap FileInput


        $data['scripts'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.js');
        $data['scripts'][] = base_url('assets/libs/select2/js/select2.full.min.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/jquery.dataTables.min.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/js/dataTables.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/dataTables.buttons.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/JSZip-2.5.0/jszip.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/pdfmake.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/vfs_fonts.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.html5.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.colVis.js');
        $data['scripts'][] = base_url('assets/libs/summernote/summernote-bs4.min.js');
        $data['scripts'][] = base_url('assets/libs/summernote/lang/summernote-es-ES.js');
        $data['scripts'][] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/fileinput.js"; //Bootstrap FileInput
        $data['scripts'][] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/locales/es.js"; //Bootstrap FileInput Spanish

        //custom
        $data['scripts'][] = base_url("assets/js/mesadeayuda/ticketsCoop.js");

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('mesaAyuda/ticketsCoop', $data);
        echo view('htdocs/footer');
    } //INDEX

    public function estadisticas(){
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Dashboard | Mesa de Ayuda | Federación ALIANZA';
        $data['breadcrumb'] = array(
            array('titulo' => 'Panel', 'link' => base_url('MesaAyuda/index'), 'class' => 'active'),
            array('titulo' => 'Dashboard', 'link' => base_url('MesaAyuda/estadisticas'), 'class' => 'active'),
        );

        $model = new MesaAyudaModel();
        $data['totales']=$model->getTotalesTicketsEstadistica();
        $data['vencidosAgente']=$model->getVencidosByAgente();
        $data['califExperiencia']=$model->getCalifExperiencia();

        //chartJS
        $data['scripts'][] = base_url('assets/libs/chart-js/Chart.bundle.min.js');

        //custom
        $data['scripts'][] = base_url("assets/js/mesadeayuda/estadisticas.js");

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('mesaAyuda/estadisticas', $data);
        echo view('htdocs/footer');
    }



    public function infoEstadistica($numero,$fechaI=null,$fechaF=null){
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $info=getTipoEstadistica($numero);
        $data['title'] = $info;
        $data['breadcrumb'] = array(
            array('titulo' => 'Panel', 'link' => base_url('Usuario/index'), 'class' => ''),
            array('titulo' => 'Dashboard', 'link' => base_url('MesaAyuda/estadisticas'), 'class' => ''),
            array('titulo' => $info, 'link' => base_url('MesaAyuda/infoEstadistica/'.$numero), 'class' => 'active')
        );

        $data['fechaI']=$fechaI;
        $data['fechaF']=$fechaF;

        //Styles
        $data['styles'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css');
        $data['styles'][] = base_url('assets/libs/bootstrap-daterangepicker/daterangepicker.css');
        $data['scripts'][] = base_url('assets/libs/bootstrap-daterangepicker/daterangepicker.js');
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');

        //Scripts
        $data['scripts'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/jquery.dataTables.min.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/js/dataTables.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/dataTables.buttons.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/JSZip-2.5.0/jszip.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/pdfmake.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/vfs_fonts.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.html5.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.colVis.js');

        //chartJS
        $data['scripts'][] = base_url('assets/libs/chart-js/Chart.bundle.min.js');

        //custom
        $data['scripts'][] = base_url('assets/js/mesadeayuda/estadisticas/infoEstadistica'.$numero.'.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('mesaAyuda/estadisticas/infoEstadistica'.$numero, $data);
        echo view('mesaAyuda/modalEncuesta');

        echo view('htdocs/footer');
    }


    public function ticketsVencidosAgente($empleadoID){
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Tickets vencidos por agente';
        $data['breadcrumb'] = array(
            array('titulo' => 'Panel', 'link' => base_url('MesaAyuda/index'), 'class' => ''),
            array('titulo' => 'Dashboard', 'link' => base_url('MesaAyuda/estadisticas'), 'class' => ''),
            array('titulo' => 'Tickets vencidos por agente', 'link' => base_url('MesaAyuda/ticketsVencidosAgente/'.$empleadoID), 'class' => 'active')
        );

        $nombre = federacion()->query(" SELECT emp_Nombre FROM empleado WHERE emp_EmpleadoID = ? ", [ encryptDecrypt('decrypt',$empleadoID)])->getRowArray()['emp_Nombre'];
        $data['nombre']=$nombre;
        $data['empleadoID']=$empleadoID;

        //Styles
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');

        //Scripts
        $data['scripts'][] = base_url('assets/plugins/datatables/jquery.dataTables.min.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/js/dataTables.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/dataTables.buttons.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/JSZip-2.5.0/jszip.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/pdfmake.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/vfs_fonts.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.html5.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.colVis.js');

        //custom
        $data['scripts'][] = base_url('assets/js/mesadeayuda/estadisticas/ticketsVencidosAgente.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('mesaAyuda/estadisticas/ticketsVencidosAgente', $data);
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

    public function saveEncuesta(){
        $post = $this->request->getPost();
        $calificacion=getCalificacionEncuesta($post['P1'],$post['P2'],$post['P3']);
        $indicadorSatisfaccion=getIndicadorSatisfaccionEncuesta($calificacion);
        $data = array(
            'enc_TicketID' =>  encryptDecrypt('decrypt',$post['ticketID']),
            'enc_UsuarioID' =>  usuarioID(),
            'enc_CooperativaID' =>  cooperativaID(),
            'enc_FechaHora' => date('Y-m-d H:i:s'),
            'enc_Pregunta1' =>  $post['P1'],
            'enc_ComPregunta1' =>  $post['P1Comentario'],
            'enc_Pregunta2' =>  $post['P2'],
            'enc_ComPregunta2' =>  $post['P2Comentario'],
            'enc_Pregunta3' =>  $post['P3'],
            'enc_ComPregunta3' =>  $post['P3Comentario'],
            'enc_Calificacion' =>  $calificacion,
            'enc_Satisfaccion' =>  $indicadorSatisfaccion,
            'enc_Comentario' =>  $post['comentario'],
        );
        $db=mesa();
        $builder = $db->table('encuesta');
        $builder->insert($data);
        $result =$db->insertID();
        if ($result) {
            $agente = $db->query("SELECT tic_AgenteResponsableID,tic_Titulo,tic_Estatus FROM ticket WHERE tic_TicketID=?",array(encryptDecrypt('decrypt', $post['ticketID'])))->getRowArray();

            $data_notificacion=array(
                'not_UsuarioID'=>$agente['tic_AgenteResponsableID'],
                'not_UsuarioTipo'=>'AGENTE',
                'not_Titulo'=>'Encuesta de satisfacción',
                'not_Descripcion'=>'El solicitante ha respondido la encuesta del ticket "'.$agente['tic_Titulo'].'"',
                'not_UsuarioIDCreo'=>usuarioID(),
                'not_UsuarioTipoCreo'=>'SOLICITANTE',
                'not_FechaRegistro'=>date('Y-m-d H:i:s'),
                'not_URL'=>'MesaAyuda/tickets',
            );
            $builder =$db->table('notificacion');
            $builder->insert($data_notificacion);
            $empleadoID=$db->query("SELECT age_EmpleadoID FROM agente WHERE age_AgenteID=?",array($agente['tic_AgenteResponsableID']))->getRowArray()['age_EmpleadoID'];
            $correo = federacion()->query("SELECT emp_Correo,emp_Nombre FROM empleado WHERE emp_EmpleadoID=?",array($empleadoID))->getRowArray();
            $cuerpoextra='';
            if($indicadorSatisfaccion!=="Positivo"){
                $cuerpoextra = ', por lo que te invitamos a revisar la encuesta a fin de identificar las áreas de oportunidad, en caso de que la encuesta no contenga información, realizar un acercamiento de manera formal (correo electrónico) con el colaborador de la cooperativa para identificar las mejoras a realizar en nuestros servicios como Federación.';
            }
            $dataCorreo=array(
                'titulo'=>'Encuesta de satisfacción',
                'cuerpo'=>'Estimad@ '.$correo['emp_Nombre'].',<br>
                            Mediante el presente se le comunica que el solicitante a respondido la encuesta de satisfacción del servicio "<b>'.$indicadorSatisfaccion.'</b>", para el ticket <b>"'.$agente['tic_Titulo'].'"</b>'.$cuerpoextra.'. </br>
                            Para mas información da click en el siguiente enlace: <br>
                            <a href="https://federacion.thigo.mx/MesaAyuda/ticket/'.$post['ticketID'].'" target="_blank">'. acortarurl('https://federacion.thigo.mx/MesaAyuda/ticket/'.$post['ticketID']).'</a>',
            );
            //Enviar Correo a solicitante
            sendMailMA($correo['emp_Correo'],'Encuesta de satisfacción del ticket #'.encryptDecrypt('decrypt', $post['ticketID']).' - '.$agente['tic_Titulo'],$dataCorreo,'SeguimientoTicket');

            if($indicadorSatisfaccion !== "Positivo"){
                $administrador=federacion()->query("SELECT emp_Nombre,emp_Correo FROM empleado WHERE emp_Rol=?",array(11))->getRowArray();
                $areaResponsable=mesa()->query("SELECT are_ResponsableID FROM area JOIN agente ON are_AreaID=age_AreaID WHERE age_AgenteID=?",array($agente['tic_AgenteResponsableID']))->getRowArray()['are_ResponsableID'];
                $gerenteArea= federacion()->query("SELECT emp_Nombre,emp_Correo FROM empleado WHERE emp_EmpleadoID=?",array($areaResponsable))->getRowArray();
                $dataCorreo=array(
                    'titulo'=>'Encuesta no satisfactoria',
                    'cuerpo'=>'Estimad@ '.$administrador['emp_Nombre'].',<br>
                                Mediante el presente se le comunica que el solicitante a respondido la encuesta de satiscaccion del servicio "<b>'.$indicadorSatisfaccion.'</b>", para el ticket <b>"'.$agente['tic_Titulo'].'"</b> . </br>
                                Los resultados de esta no fueron satisfactorios en algunos aspectos.
                                Para mas información da click en el siguiente enlace: <br>
                                <a href="https://federacion.thigo/MesaAyuda/ticket/'.$post['ticketID'].'" target="_blank">'. acortarurl('https://federacion.thigo/MesaAyuda/ticket/'.$post['ticketID']).'</a>',
                );
                $dataCorreo2=array(
                    'titulo'=>'Encuesta no satisfactoria',
                    'cuerpo'=>'Estimad@ '.$gerenteArea['emp_Nombre'].',<br>
                                Mediante el presente se le comunica que el solicitante a respondido la encuesta de satiscaccion del servicio "<b>'.$indicadorSatisfaccion.'</b>", para el ticket <b>"'.$agente['tic_Titulo'].'"</b> . </br>
                                Los resultados de esta no fueron satisfactorios en algunos aspectos.
                                Para mas información da click en el siguiente enlace: <br>
                                <a href="https://federacion.thigo/MesaAyuda/ticket/'.$post['ticketID'].'" target="_blank">'. acortarurl('https://federacion.thigo/MesaAyuda/ticket/'.$post['ticketID']).'</a>',
                );
                //Enviar Correo a solicitante
                sendMailMA($administrador['emp_Correo'],'Nueva respuesta al ticket #'.encryptDecrypt('decrypt', $post['ticketID']).' - '.$agente['tic_Titulo'],$dataCorreo,'');
                sendMailMA($gerenteArea['emp_Correo'],'Nueva respuesta al ticket #'.encryptDecrypt('decrypt', $post['ticketID']).' - '.$agente['tic_Titulo'],$dataCorreo2,'');
            }

            $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Las respuestas de la encuesta se guardaron correctamente!'));
        } else {
            $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error intente mas tarde!'));
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

    public function ajax_getUsuariosMesa(){
        $model = new MesaAyudaModel();
        $data['data'] = $model->getUsuariosMesa();
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    public function ajaxSaveUsuarioMesa(){
        $post = $this->request->getPost();
        $empleadoID =encryptDecrypt('decrypt',$post["emp_EmpleadoID"]);

        //Si existe en la mesa
        $usuario=mesa()->query("SELECT * FROM usuario WHERE usu_CooperativaID=? AND usu_Identificador=?",[cooperativaID(),$empleadoID])->getRowArray();
        if(empty($usuario)){
            $empleado=db()->query("SELECT emp_Nombre, emp_Username,emp_Password,emp_Telefono,emp_Correo,pue_Nombre FROM empleado E
                                    JOIN puesto P ON P.pue_PuestoID=E.emp_PuestoID
                                    WHERE E.emp_EmpleadoID=".$empleadoID)->getRowArray();
            $datos = array(
                "usu_Identificador" => $empleadoID ,
                "usu_CooperativaID" => cooperativaID(),
                "usu_Nombre" => $empleado['emp_Nombre'],
                "usu_Cargo" => $empleado['pue_Nombre'],
                "usu_Username" => $empleado['emp_Username'],
                "usu_Password" => $empleado['emp_Password'],
                "usu_Telefono" => $empleado['emp_Telefono'],
                "usu_Correo" => $empleado['emp_Correo'],
                "usu_RolID" => 1,
                "usu_Tipo" => 'Thigo',
            );
            $builder = mesa()->table("usuario");
            $builder->insert($datos);

            $dataCorreo=array(
                'titulo'=>'Bienvenido a la Mesa de Ayuda',
                'cuerpo'=>'Estimad@ '.$empleado['emp_Nombre'].',<br>
                            Mediante el presente se le comunica que ya cuenta con acceso a la Mesa de Ayuda de Federación Alianza.<br>
                            Esta sección la podras encontar en tu plataforma Thigo en menu de la izquierda en la parte inferor.<br><br>
                            Cualquier comentario en lo referente favor de contactar a <b>María Guadalupe Velázquez Rivera</b>
                            en la cuenta de correo <b>mvelazquez@cpalianza.com.mx</b> o al número <b>477 343 05 00 Ext. 215</b>.'
            );
            sendMailMA($empleado['emp_Correo'],'Bienvenido a la Mesa de Ayuda de Federación Alianza',$dataCorreo,'AccesoUsuario');
            $administrador=federacion()->query("SELECT emp_Nombre,emp_Correo FROM empleado WHERE emp_Rol=?",array(11))->getRowArray();
            $dataCorreo=array(
                'titulo'=>'Usuario registrado',
                'cuerpo'=>'Estimad@ '.$administrador['emp_Nombre'].',<br>
                            Mediante el presente se le comunica que se ha registrado un nuevo usuario de la cooperativa '.getSetting('nombre_empresa',$this).' , en la Mesa de Ayuda de Federación Alianza.
                            Los datos del nuevo usuario son:<br><br>
                            <b>Nombre:</b>'.$empleado['emp_Nombre'].'<br>
                            <b>Cargo:</b>'.$empleado['pue_Nombre'].'<br><br>
                            Para mas información ingresa a tu plataforma Thigo en la seccion de Mesa de Ayuda.<br>'
            );
            sendMailMA($administrador['emp_Correo'],'Nuevo usuario de Mesa de Ayuda de Federación Alianza',$dataCorreo,'');

            $data['code']=1;
        }else $data['code']=2;

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    public function ajaxEstatusUsuarioMesa(){
        $usuarioID =encryptDecrypt('decrypt', post("usuarioID"));
        $estatus= post("estatus");
        $builder = mesa()->table('usuario');
        $result = $builder->update(array('usu_Estatus' =>(int)$estatus), array('usu_UsuarioID' =>(int)$usuarioID));
        $data['code'] = $result ? 1 : 0;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    public function ajax_addTicket(){
        $post = $this->request->getPost();
        $data['code'] = 0;
        $responsables = mesa()->query("SELECT ser_Responsable FROM servicio WHERE ser_ServicioID=?",array(encryptDecrypt('decrypt',$post['servicioTicket'])))->getRowArray()['ser_Responsable'];
        $responsables = json_decode($responsables);
        $data_ticket = array(
            'tic_FechaHoraRegistro'=>date('Y-m-d H:i:s'),
            'tic_UsuarioID'=>usuarioID(),
            'tic_CooperativaID'=>cooperativaID(),
            'tic_AreaID'=>encryptDecrypt('decrypt',$post['areaTicket']),
            'tic_ServicioID'=>encryptDecrypt('decrypt',$post['servicioTicket']),
            'tic_Titulo'=>$post['tituloTicket'],
            'tic_Prioridad'=>'BAJA',
            'tic_FechaTerminoPropuesta'=>date('Y-m-d H:i:s', strtotime('+7 days')),
            'tic_Fecha1REstimada'=>date('Y-m-d H:i:s', strtotime('+2 hours')),
            'tic_Descripcion'=>$post['descripcionTicket']
        );
        //configuracion dias inhabiles 1er respuesta y termino propuesta
        $data_ticket['tic_Fecha1REstimada'] = proximaFechaHabil($data_ticket['tic_Fecha1REstimada']);
        $data_ticket['tic_FechaTerminoPropuesta'] = date('Y-m-d H:i:s', strtotime($data_ticket['tic_Fecha1REstimada'] . ' +7 days'));
        $data_ticket['tic_FechaTerminoPropuesta'] = proximaFechaHabil($data_ticket['tic_FechaTerminoPropuesta']);
        //

        //configuracion dia domingo, sabado y horas laborales
        $diaNombre = get_nombre_dia(date('Y-m-d'));
        $hora = date('H:i');
        if($diaNombre=='Domingo'){
            $data_ticket['tic_Fecha1REstimada']=date('Y-m-d', strtotime('+1 days')).' 11:00:00';
            $data_ticket['tic_FechaTerminoPropuesta']=date('Y-m-d', strtotime('+8 days')).' 11:00:00';
        }else{
            if($hora >= '18:00' && $hora <= '23:59'){
                $diasSuma1Respuesta = strtotime('+1 days');
                $diasSumaVencimiento = strtotime('+7 days');
                if($diaNombre=='Sabado') {
                    $diasSuma1Respuesta = strtotime('+2 days');
                    $diasSumaVencimiento = strtotime('+9 days');
                }
                $data_ticket['tic_Fecha1REstimada']=date('Y-m-d', $diasSuma1Respuesta).' 11:00:00';
                $data_ticket['tic_FechaTerminoPropuesta']=date('Y-m-d', $diasSumaVencimiento).' 11:00:00';
            }elseif($hora >= '00:01' && $hora < '09:00'){
                $data_ticket['tic_Fecha1REstimada']=date('Y-m-d').' 11:00:00';
                $diasSumaVencimiento = strtotime('+7 days');
                if($diaNombre=='Sabado') {
                    $diasSumaVencimiento = strtotime('+8 days');
                }
                $data_ticket['tic_FechaTerminoPropuesta']=date('Y-m-d', $diasSumaVencimiento).' 11:00:00';
            }
        }
        /*$diaInhabil1Respuesta = federacion()->query("SELECT SUM(existe) AS total_existe FROM ( SELECT COUNT(*) AS existe FROM diainhabil WHERE dia_Fecha = '".date('Y-m-d',strtotime($data_ticket['tic_Fecha1REstimada']))."' UNION SELECT COUNT(*) AS existe FROM diainhabilley WHERE dial_Fecha = '".date('Y-m-d',strtotime($data_ticket['tic_Fecha1REstimada']))."' ) AS subquery")->getRowArray()['total_existe'];
        $diaInhabilVencimiento = federacion()->query("SELECT SUM(existe) AS total_existe FROM ( SELECT COUNT(*) AS existe FROM diainhabil WHERE dia_Fecha = '".date('Y-m-d',strtotime($data_ticket['tic_FechaTerminoPropuesta']))."' UNION SELECT COUNT(*) AS existe FROM diainhabilley WHERE dial_Fecha = '".date('Y-m-d',strtotime($data_ticket['tic_FechaTerminoPropuesta']))."' ) AS subquery")->getRowArray()['total_existe'];
        if($diaInhabil1Respuesta>0) $data_ticket['tic_Fecha1REstimada']=date('Y-m-d H:i:s', strtotime($data_ticket['tic_Fecha1REstimada'].'+1 days'));
        if($diaInhabilVencimiento>0) $data_ticket['tic_FechaTerminoPropuesta']=date('Y-m-d H:i:s', strtotime($data_ticket['tic_FechaTerminoPropuesta'].'+1 days'));*/

        if(get_nombre_dia($data_ticket['tic_Fecha1REstimada'])=='Domingo')$data_ticket['tic_Fecha1REstimada']=date('Y-m-d H:i:s', strtotime($data_ticket['tic_Fecha1REstimada'].'+1 days'));
        if(get_nombre_dia($data_ticket['tic_FechaTerminoPropuesta'])=='Domingo')$data_ticket['tic_FechaTerminoPropuesta']=date('Y-m-d H:i:s', strtotime($data_ticket['tic_FechaTerminoPropuesta'].'+1 days'));
        //

        //modificacion configuracion horas laborales
        //$hora = substr($data_ticket['tic_Fecha1REstimada'], 11, 8);
        //var_dump($hora);exit();
        //var_dump(date('Y-m-d', $data_ticket['tic_Fecha1REstimada']));exit();
        //
        
        if(count($responsables)==1) $data_ticket['tic_AgenteResponsableID']=$responsables[0];
        $builder = mesa()->table('ticket');
        $builder->insert($data_ticket);
        $ticketID = mesa()->insertID();
        $ticketID = encryptDecrypt('encrypt',$ticketID);
        $files=array();
        if($ticketID){
            if (isset($_FILES['archivoTicket'])) {
                //$directorio = FCPATH . "/assets/uploads/tickets/" . $ticketID . "/";
                //$directorio = $_SERVER['DOCUMENT_ROOT'] . '/mesadeayuda/assets/uploads/tickets/' . $ticketID . "/";
                $directorio = str_replace('purepero','mesadeayuda', FCPATH . "assets/uploads/tickets/" . $ticketID . "/" );
                if (!file_exists($directorio)) mkdir($directorio, 0777, true);
                $total_files = count($_FILES['archivoTicket']['name']);
                for ($key = 0; $key < $total_files; $key++) {
                    $nombre_archivo = eliminar_acentos(str_replace(" ", "", $_FILES['archivoTicket']['name'][$key]));
                    if (file_exists($directorio . $nombre_archivo)) {
                        $nombre_archivo='1_'.$nombre_archivo;
                    }
                    array_push($files,$nombre_archivo);
                    $ruta = $directorio . $nombre_archivo;
                    move_uploaded_file($_FILES['archivoTicket']['tmp_name'][$key], $ruta);
                }
            }
            $files = json_encode($files);
            if($files=='[""]' || $files=='["1_"]') $files = null;
            $builder->update(array("tic_File"=>$files),array('tic_TicketID'=>encryptDecrypt('decrypt',$ticketID)));
            //Info Ticket previo a log
            $data_ticket =mesa()->query("SELECT * FROM ticket WHERE tic_TicketID=?",array(encryptDecrypt('decrypt',$ticketID)))->getRowArray();
            $data_ticket=json_encode($data_ticket);
            //Log Ticket
            logTicket(encryptDecrypt('decrypt',$ticketID),'ABIERTO','SOLICITANTE',usuarioID(),$data_ticket);
            if(count($responsables)==1) logTicket(encryptDecrypt('decrypt',$ticketID),'RESPONSABLE','SOLICITANTE',usuarioID(),$data_ticket);

            //Informacion
            $servicio = mesa()->query("SELECT ser_Servicio FROM servicio WHERE ser_ServicioID=?",array(encryptDecrypt('decrypt',$post['servicioTicket'])))->getRowArray();
            $solicitante = mesa()->query("SELECT * FROM usuario WHERE usu_UsuarioID=?",array(usuarioID()))->getRowArray();
            $dataCorreo=array(
                'titulo'=>'Se ha recibido tu ticket',
                'cuerpo'=>'Estimad@ '.$solicitante['usu_Nombre'].',<br>
                            Mediante el presente se le comunica que hemos recibido tu ticket en la Mesa de Ayuda de Federación Alianza, para el servicio/producto <b>"'.$servicio['ser_Servicio'].'"</b>. Pronto uno de nuestros agentes se pondrá en contacto contigo.
                            Para más información ingresa a el siguiente enlace:<br>
                            <a href="'.urlTicket(cooperativaID(), $ticketID).'" target="_blank">'.acortarurl(urlTicket(cooperativaID(), $ticketID)).'</a>',
            );

            //Enviar Correo a solicitante
            sendMailMA($solicitante['usu_Correo'],'Se recibio tu ticket',$dataCorreo,'respuestaRapida');
            //Correo a gerente
            $director = mesa()->query("SELECT coo_Gerente,coo_Correo FROM cooperativa WHERE coo_CooperativaID=?",[cooperativaID()])->getRowArray();
            $dataCorreoGerente=array(
                'titulo'=>'Se ha generado un ticket',
                'cuerpo'=>'Estimad@ '.$director['coo_Gerente'].',<br>
                Le confirmamos que en su cooperativa se ha creado un ticket.<br>
                Numero: '.encryptDecrypt('decrypt',$ticketID).'<br>
                Titulo: '.$post['tituloTicket'].'<br>
                Para el servicio/producto <b>"'.$servicio['ser_Servicio'].'"</b>.<br>
                Para más información ingresa al siguiente enlace:<br>
                <a href="'.urlTicketCoop(cooperativaID()).'" target="_blank">'.acortarurl(urlTicketCoop(cooperativaID())).'</a>',
            );
            sendMailMA($director['coo_Correo'],'Se creo un Ticket',$dataCorreoGerente,'correoGerente');

            foreach($responsables as $r){
                //Enviar notificacion a agente(s)
                $dataNot=array(
                    'not_UsuarioID'=>$r,
                    'not_UsuarioTipo'=>'AGENTE',
                    'not_Titulo'=>'Nuevo ticket',
                    'not_Descripcion'=>'Se ha registrado un nuevo ticket',
                    'not_UsuarioIDCreo'=>usuarioID(),
                    'not_UsuarioTipoCreo'=>'SOLICITANTE',
                    'not_FechaRegistro'=>date('Y-m-d H:i:s'),
                    'not_URL'=>'MesaAyuda/ticket/'.$ticketID,
                );
                $builder = mesa()->table('notificacion');
                $builder->insert($dataNot);
                $empleadoID= mesa()->query("SELECT age_EmpleadoID FROM agente WHERE age_AgenteID=?",array($r))->getRowArray()['age_EmpleadoID'];
                $agente= federacion()->query("SELECT * FROM empleado WHERE emp_EmpleadoID=?",array($empleadoID))->getRowArray();
                $dataCorreo=array(
                    'titulo'=>'Nuevo ticket',
                    'cuerpo'=>'Estimad@ '.$agente['emp_Nombre'].',<br>
                            Mediante el presente se le comunica que se ha recibido un ticket en la Mesa de Ayuda para el servicio/producto <b>"'.$servicio['ser_Servicio'].'"</b>
                            <br>puedes darle seguimiento en la sección de Tickets en tu plataforma Thigo.<br>
                            Para más información da click en el siguiente enlace:<br>
                            <a href="https://federacion.thigo.mx/MesaAyuda/ticket/'.$ticketID.'" target="_blank">'.acortarurl('https://federacion.thigo.mx/MesaAyuda/ticket/'. $ticketID).'</a>',///Cambiar liga
                );
                //Enviar Correo a agente al crear ticket
                sendMailMA($agente['emp_Correo'],'Nuevo ticket #'.encryptDecrypt('decrypt',$ticketID).' - '.$post['tituloTicket'],$dataCorreo,'avisoAgente');
            }

            $empleadoRespID= mesa()->query("SELECT are_ResponsableID FROM area WHERE are_AreaID=?",array(encryptDecrypt('decrypt',$post['areaTicket'])))->getRowArray()['are_ResponsableID'];
            $gerente= federacion()->query("SELECT emp_EmpleadoID,emp_Nombre,emp_Correo FROM empleado WHERE emp_EmpleadoID=?",array($empleadoRespID))->getRowArray();
            $dataCorreo=array(
                'titulo'=>'Nuevo ticket',
                'cuerpo'=>'Estimad@ '.$gerente['emp_Nombre'].',<br>
                Mediante el presente se te comunica que se ha recibido un ticket en la Mesa de Ayuda para el servicio/producto <b>"'.$servicio['ser_Servicio'].'"</b> asignado a tu área.
                <br>Puedes darle seguimiento en la sección de Tickets del área en tu plataforma Thigo.
                Para mas información da click en el siguiente enlace:<br>
                <a href="https://federacion.thigo.mx/MesaAyuda/ticket/'.$ticketID.'" target="_blank">'.acortarurl('https://federacion.thigo.mx/MesaAyuda/ticket/'.$ticketID).'</a>',
            );
            //Enviar Correo a agente al crear ticket
            sendMailMA($gerente['emp_Correo'],'Nuevo Ticket #'.encryptDecrypt('decrypt',$ticketID).' - '.$post['tituloTicket'],$dataCorreo,'');

            $data['code'] =1;
        }
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    public function ajax_getServicioByArea(){
        $post = $this->request->getPost();
        $servicio = mesa()->query("SELECT ser_ServicioID,ser_Servicio FROM servicio WHERE ser_AreaID = ? AND ser_Estatus=1",array(encryptDecrypt('decrypt',$post['area'])))->getResultArray();
        if ($servicio) {
            $result=array();
            foreach($servicio as $s){
                $s['ser_ServicioID']=encryptDecrypt('encrypt',$s['ser_ServicioID']);
                array_push($result,$s);
            }
            echo json_encode(array("response" => "success", "result" => $result));
        } else echo json_encode(array("response" => "error", "msg" => 'Ocurrio un error. Intentelo nuevamente'));
    }

    public function subirArchivo($idticket){
        $directorio = str_replace(basename(FCPATH),'mesadeayuda', FCPATH . "assets/uploads/tickets/" . $idticket . "/temp/" );
        if (!file_exists($directorio)) mkdir($directorio, 0777, true);
        $total_files = count($_FILES['archivosTicket']['name']);
        for ($key = 0; $key < $total_files; $key++) {
            $nombre_archivo = eliminar_acentos(str_replace(" ", "", $_FILES['archivosTicket']['name'][$key]));
            $ruta = $directorio . $nombre_archivo;
            move_uploaded_file($_FILES['archivosTicket']['tmp_name'][$key], $ruta);
        }
        echo json_encode(array("nombre" => $nombre_archivo), JSON_UNESCAPED_SLASHES);
    }

    public function ajax_SaveComentarioTicket()
    {
        $post = $this->request->getPost();
        $ticketID = $post["comt_TicketID"];
        $comentario = $post['comentarioTicket'];
        $guardado = 0;

        $db=mesa();
        $db->transBegin();

        /*$files=array();
        if (isset($_FILES['archivosTicket']) && $_FILES['archivosTicket']['name'][0]!==null) {
            //lugar donde se guarda
            //$directorio = $_SERVER['DOCUMENT_ROOT'] . '/mesadeayuda/assets/uploads/tickets/' . $ticketID . "/";
            $directorio = str_replace('purepero','mesadeayuda', FCPATH . "assets/uploads/tickets/" . $ticketID . "/" );
            if (!file_exists($directorio)) mkdir($directorio, 0777, true);
            $total_files = count($_FILES['archivosTicket']['name']);
            for ($key = 0; $key < $total_files; $key++) {
                $nombre_archivo = eliminar_acentos(str_replace(" ", "", $_FILES['archivosTicket']['name'][$key]));
                if (file_exists($directorio . $nombre_archivo)) {
                    $nombre_archivo='1_'.$nombre_archivo;
                }
                array_push($files,$nombre_archivo);
                $ruta = $directorio . $nombre_archivo;
                move_uploaded_file($_FILES['archivosTicket']['tmp_name'][$key], $ruta);
                $guardado++;
            }
        }else $guardado=1;*/
        $files=null;
        if($post['nombreArchivo']!==''){
            $files=explode(',',$post['nombreArchivo']);
            foreach($files as $file){
                $rutaTemp =  str_replace(basename(FCPATH),'mesadeayuda', FCPATH . "assets/uploads/tickets/" . $post["comt_TicketID"] . "/temp/" );
                if (!file_exists($rutaTemp)){ mkdir($rutaTemp, 0777, true);}
                $ruta = str_replace(basename(FCPATH),'mesadeayuda', FCPATH . "assets/uploads/tickets/" . $post["comt_TicketID"] . "/" );
                if (!file_exists($ruta)){ mkdir($ruta, 0777, true);}
                if(file_exists($ruta.$file)){
                    $nombre_archivo=rand(1, 999).'_'.$file;
                }else{
                    $nombre_archivo=$file;
                }
                rename($rutaTemp . $file, $ruta . $nombre_archivo);
                $guardado++;
            }
        }else{
            $guardado=1;
        }
        if($guardado>0){
            if($files!=null){
                $files = json_encode($files);
                if($files=='[""]' || $files=='["1_"]') $files = null;
            }
            $data_Comentario = array(
                "comt_TicketID"=>encryptDecrypt('decrypt', $ticketID),
                "comt_FechaHora"=>date('Y-m-d H:i:s'),
                "comt_Tipo"=>'USUARIO',
                "comt_UsuarioID"=>usuarioID(),
                "comt_CooperativaID"=>cooperativaID(),
                "comt_Comentario"=>$comentario,
                "comt_Files"=>$files
            );
            $builder=$db->table('comentarioticket');
            $builder->insert($data_Comentario);

            //si ya tiene agente
            $agente = $db->query("SELECT tic_AgenteResponsableID,tic_Titulo,tic_Estatus FROM ticket WHERE tic_TicketID=?",array(encryptDecrypt('decrypt', $ticketID)))->getRowArray();
            if($agente['tic_AgenteResponsableID']){
                $data_notificacion=array(
                    'not_UsuarioID'=>$agente['tic_AgenteResponsableID'],
                    'not_UsuarioTipo'=>'AGENTE',
                    'not_Titulo'=>'Nuevo comentario en ticket',
                    'not_Descripcion'=>'Se ha comentado el ticket "'.$agente['tic_Titulo'].'"',
                    'not_UsuarioIDCreo'=>usuarioID(),
                    'not_UsuarioTipoCreo'=>'SOLICITANTE',
                    'not_FechaRegistro'=>date('Y-m-d H:i:s'),
                    'not_URL'=>'MesaAyuda/ticket/'.$ticketID,
                );
                $builder =$db->table('notificacion');
                $builder->insert($data_notificacion);
                $empleadoID=$db->query("SELECT age_EmpleadoID FROM agente WHERE age_AgenteID=?",array($agente['tic_AgenteResponsableID']))->getRowArray()['age_EmpleadoID'];
                $correo = federacion()->query("SELECT emp_Correo,emp_Nombre FROM empleado WHERE emp_EmpleadoID=?",array($empleadoID))->getRowArray();
                $dataCorreo=array(
                    'titulo'=>'Nueva Respuesta',
                    'cuerpo'=>'Estimad@ '.$correo['emp_Nombre'].',<br>
                                Mediante el presente se le comunica que el solicitante a respondido al ticket <b>"'.$agente['tic_Titulo'].'"</b> . </br>
                                Para más información da click en el siguiente enlace: <br>
                                <a href="https://federacion.thigo.mx/MesaAyuda/ticket/'.$ticketID.'" target="_blank">'. acortarurl('https://federacion.thigo.mx/MesaAyuda/ticket/'.$ticketID).'</a>',
                );
                //Enviar Correo a solicitante
                sendMailMA($correo['emp_Correo'],'Nueva respuesta al ticket #'.encryptDecrypt('decrypt', $ticketID).' - '.$agente['tic_Titulo'],$dataCorreo,'SeguimientoTicket');
                if($agente['tic_Estatus']=='ESPERA_SOLICITANTE'){
                    $builder=$db->table('ticket');
                    $builder->update(array("tic_Estatus"=>'ABIERTO'),array("tic_TicketID"=>encryptDecrypt('decrypt', $ticketID)));
                    $data_ticket = $builder->getWhere(['tic_TicketID'=>encryptDecrypt('decrypt', $ticketID)])->getRowArray();
                    $data_ticket=json_encode($data_ticket);
                    logTicket(encryptDecrypt('decrypt', $ticketID),'ABIERTO','SOLICITANTE',usuarioID(),$data_ticket);
                }
            }
        }

        if ($db->transStatus() === FALSE) {
            $data['code'] =  0;
            $db->transRollback();
        } else {
            $db->transCommit();
            $data['code'] =  1;
        }

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    public function ajax_GetComentariosTicket($ticketID)
    {
        $ticketID = encryptDecrypt('decrypt', $ticketID);
        $model = new MesaAyudaModel();
        $comentarios = $model->getcomentariosTicketByID($ticketID);
        $comentariosArray = array();
        $html = "";
        if (!empty($comentarios)) {
            foreach ($comentarios as $comentario) {
                $archivos='';
                switch($comentario['comt_Tipo']){
                    case 'USUARIO': $usuarioID=mesa()->query("SELECT usu_Identificador FROM usuario WHERE usu_UsuarioID=?",[$comentario['comt_UsuarioID']])->getRowArray()['usu_Identificador'];$foto = fotoPerfil(encryptDecrypt('encrypt',$usuarioID)); $nombre = mesa()->query("SELECT usu_Nombre FROM usuario WHERE usu_UsuarioID=?",array($comentario['comt_UsuarioID']))->getRowArray()['usu_Nombre']; break;
                    case 'AGENTE': $empleadoID=mesa()->query("SELECT age_EmpleadoID FROM agente WHERE age_AgenteID=".$comentario['comt_AgenteID'])->getRowArray()['age_EmpleadoID']; $foto = fotoPerfilFederacion($empleadoID); $nombre = federacion()->query("SELECT emp_Nombre FROM empleado WHERE emp_EmpleadoID=?",array($empleadoID))->getRowArray()['emp_Nombre']; break;
                    case 'ADMIN': $empleadoID=mesa()->query("SELECT age_EmpleadoID FROM agente WHERE age_AgenteID=".$comentario['comt_AgenteID'])->getRowArray()['age_EmpleadoID'];  $foto = fotoPerfilFederacion($empleadoID);$nombre = federacion()->query("SELECT emp_Nombre FROM empleado WHERE emp_EmpleadoID=?",array($empleadoID))->getRowArray()['emp_Nombre']; break;
                }
                if($comentario['comt_Files']) {
                    $files = filesComentarioTicket($comentario['comt_ComentarioTicketID']);
                    $archivos.='<label style="font-size:13px !important ;">Archivos adjuntos</label><div class="files-list">';
                    foreach($files as $file){
                        $icon = iconExtension($file['extension']);
                        $archivos.='<div class="file-box">
                                        <a href="'.$file['url'].'" target="_blank" ><img src="'.$icon.'" class="img-responsive img-thumbnail" alt="attached-img" ></a>
                                        <p class="font-13 mb-1 text-muted"><small>'.substr($file['nombre'],0,10).'</small></p>
                                    </div>';
                    }
                    $archivos.='</div>';
                }
                $comentario['comt_Comentario'] = str_replace('<img ','<img style="width: 50%;" ',$comentario['comt_Comentario']);
                $html .= '<div class="media card-box " >
                            <div class="d-flex mr-3">
                                <a> <img class="media-object rounded-circle avatar-sm" alt="64x64" src="' . $foto . '"> </a>
                            </div>
                            <div class="media-body">
                                <span class="float-right badge badge-secondary ">' . strtoupper(shortDateTime($comentario['comt_FechaHora'], ' ')) . '</span>
                                <h5 class="mt-0">' . $nombre . '</h5>
                                '.$comentario['comt_Comentario'].'
                                '.$archivos.'
                            </div>
                        </div>';
            }
        }
        array_push($comentariosArray, $html);
        echo json_encode(array("comentarios" => $comentariosArray, "total" => count($comentarios)), JSON_UNESCAPED_SLASHES);
    }

    public function getEncuesta(){
        $ticketID=encryptDecrypt('decrypt',post('tiketID'));
        $encuesta= mesa()->query("SELECT * FROM encuesta WHERE enc_TicketID=?",array($ticketID))->getRowArray();
        $ticketResuelto= mesa()->query("SELECT tic_Estatus FROM ticket WHERE tic_TicketID=?",array($ticketID))->getRowArray()['tic_Estatus'];
        $data['mostrar'] = (is_null($encuesta) && $ticketResuelto == 'RESUELTO') ? 1 : 0;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    public function getEncuestaResultados(){
        $post = $this->request->getPost();
        $ticketID=encryptDecrypt('decrypt',$post['idTicket']);
        $encuesta= mesa()->query("SELECT * FROM encuesta WHERE enc_TicketID=?",array($ticketID))->getRowArray();
        $data['encuesta']=$encuesta;
        $data['code'] = $encuesta ? 1 : 0;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    public function ajax_CreadosVResueltoByMes(){
        for($i=1;$i<=12;$i++){
            $ticketsCreados=mesa()->query("SELECT COUNT(*) AS 'total' FROM ticket WHERE YEAR(tic_FechaHoraRegistro)=? AND MONTH(tic_FechaHoraRegistro)=? AND tic_CooperativaID=?",array(date('Y'),$i,cooperativaID()))->getRowArray();
            $ticketsResueltos=mesa()->query("SELECT COUNT(*) AS 'total' FROM ticket WHERE YEAR(tic_FechaHoraRegistro)=?  AND MONTH(tic_FechaHoraRegistro)=?  AND tic_Estatus IN ('RESUELTO','CERRADO') AND tic_CooperativaID=?",array(date('Y'),$i,cooperativaID()))->getRowArray();
            $ticketsCreadosG=mesa()->query("SELECT COUNT(*) AS 'total' FROM ticketgenerico WHERE YEAR(ticg_FechaHoraRegistro)=? AND MONTH(ticg_FechaHoraRegistro)=? AND ticg_Estatus= 1 AND ticg_CooperativaID=?",array(date('Y'),$i,cooperativaID()))->getRowArray();
            $ticketsResueltosG=mesa()->query("SELECT COUNT(*) AS 'total' FROM ticketgenerico WHERE YEAR(ticg_FechaHoraRegistro)=? AND MONTH(ticg_FechaHoraRegistro)=? AND ticg_Estado IN ('RESUELTO','CERRADO') AND ticg_Estatus= 1 AND ticg_CooperativaID=?",array(date('Y'),$i,cooperativaID()))->getRowArray();
            $ticketsCreadosTotal[]=$ticketsCreados['total']+$ticketsCreadosG['total'];
           $ticketsResueltosTotal[]=$ticketsResueltos['total']+$ticketsResueltosG['total'];
        }
        $data = array(
            'ticketsCreados' => $ticketsCreadosTotal,
            'ticketsResueltos' => $ticketsResueltosTotal,
        );
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    public function ajax_PrioridadTickets(){
        $prioridad = array('BAJA','MEDIA','ALTA','URGENTE');
        $data['totalTickets']=0;
        foreach($prioridad as $p){
            $ticketTotal = mesa()->query("SELECT COUNT(*) AS 'total' FROM ticket WHERE YEAR(tic_FechaHoraRegistro)=? AND tic_Prioridad=? AND tic_CooperativaID=?",array(date('Y'),$p,cooperativaID()))->getRowArray()['total'];
            if($p=='BAJA'){
                $ticketTotalG = mesa()->query("SELECT COUNT(*) AS 'total' FROM ticketgenerico WHERE YEAR(ticg_FechaHoraRegistro)=? AND ticg_Estatus= 1 AND ticg_CooperativaID=?",array(date('Y'),cooperativaID()))->getRowArray()['total'];
                $ticketTotal+=$ticketTotalG;
            }
            $data['ticket'][]=$ticketTotal;
            $data['totalTickets']+=$ticketTotal;
        }
        $data['prioridad'] = $prioridad;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    public function ajax_TicketsEstatus(){
        $estatus = array('ABIERTO','ESPERA_SOLICITANTE','RESUELTO','CERRADO');
        foreach($estatus as $e){
            $ticketTotal = mesa()->query("SELECT COUNT(*) AS 'total' FROM ticket WHERE YEAR(tic_FechaHoraRegistro)=? AND tic_Estatus=? AND tic_CooperativaID=?",array(date('Y'),$e,cooperativaID()))->getRowArray()['total'];
            $ticketTotalG = mesa()->query("SELECT COUNT(*) AS 'total' FROM ticketgenerico WHERE YEAR(ticg_FechaHoraRegistro)=? AND ticg_Estado=? AND ticg_Estatus= 1 AND ticg_CooperativaID=?",array(date('Y'),$e,cooperativaID()))->getRowArray()['total'];
            $data['ticket'][]=$ticketTotal+$ticketTotalG;
            switch($e){
                case 'ESPERA_SOLICITANTE':$data['estatus'][]='ESP SOLICITANTE';break;
                case 'ESPERA_PROVEEDOR':$data['estatus'][]='ESP PROVEEDOR';break;
                default: $data['estatus'][]=$e;break;
            }
        }
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }


    public function ajax_TicketsGCoop(){
        for($i=1;$i<=12;$i++){
            $tickets = mesa()->query("SELECT COUNT(*) as total FROM ticketgenerico WHERE YEAR(ticg_FechaHoraRegistro)=? AND MONTH(ticg_FechaHoraRegistro)=? AND ticg_Estatus=1 AND ticg_CooperativaID=?",array(date('Y'),$i,cooperativaID()))->getRowArray()['total'];
            $data['tickets'][]= $tickets;
        }
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }


    public function ajax_InfoCreadosVResueltoByMesPeriodo($inicio=null,$fin=null){

        if(!is_null($inicio) || !is_null($fin)){
            $inicio = date('Y-m',strtotime($inicio));
            $fin = date('Y-m',strtotime($fin));

            $mesesList = array(
                '01' => 'Enero',
                '02' => 'Febrero',
                '03' => 'Marzo',
                '04' => 'Abril',
                '05' => 'Mayo',
                '06' => 'Junio',
                '07' => 'Julio',
                '08' => 'Agosto',
                '09' => 'Septiembre',
                '10' => 'Octubre',
                '11' => 'Noviembre',
                '12' => 'Diciembre',
            );
            $meses = array();

            while (strtotime($inicio) <= strtotime($fin)){

                $anio = substr($inicio,0,4);
                $mes = substr($inicio,5,2);
                $ticketsCreados=mesa()->query("SELECT COUNT(*) AS 'total' FROM ticket WHERE YEAR(tic_FechaHoraRegistro)=? AND MONTH(tic_FechaHoraRegistro)=? AND tic_CooperativaID=?",array($anio,$mes,cooperativaID()))->getRowArray();
                $ticketsResueltos=mesa()->query("SELECT COUNT(*) AS 'total' FROM ticket WHERE YEAR(tic_FechaHoraRegistro)=?  AND MONTH(tic_FechaHoraRegistro)=?  AND tic_Estatus IN ('RESUELTO','CERRADO') AND tic_CooperativaID=?",array($anio,$mes,cooperativaID()))->getRowArray();
                $ticketsCreadosG=mesa()->query("SELECT COUNT(*) AS 'total' FROM ticketgenerico WHERE YEAR(ticg_FechaHoraRegistro)=? AND MONTH(ticg_FechaHoraRegistro)=? AND ticg_Estatus= 1 AND ticg_CooperativaID=?",array($anio,$mes,cooperativaID()))->getRowArray();
                $ticketsResueltosG=mesa()->query("SELECT COUNT(*) AS 'total' FROM ticketgenerico WHERE YEAR(ticg_FechaHoraRegistro)=? AND MONTH(ticg_FechaHoraRegistro)=? AND ticg_Estado IN ('RESUELTO','CERRADO') AND ticg_Estatus= 1 AND ticg_CooperativaID=?",array($anio,$mes,cooperativaID()))->getRowArray();
                $ticketsCreadosTotal[]=$ticketsCreados['total']+$ticketsCreadosG['total'];
                $ticketsResueltosTotal[]=$ticketsResueltos['total']+$ticketsResueltosG['total'];
                array_push($meses,$mesesList[$mes]);
                $inicio = date("Y-m",strtotime($inicio."+ 1 month"));
            }
            $data = array(
                'ticketsCreados' => $ticketsCreadosTotal,
                'ticketsResueltos' => $ticketsResueltosTotal,
                'meses'=>$meses
            );
        }else{

            for($i=1;$i<=12;$i++){
                $ticketsCreados=mesa()->query("SELECT COUNT(*) AS 'total' FROM ticket WHERE YEAR(tic_FechaHoraRegistro)=? AND MONTH(tic_FechaHoraRegistro)=? AND tic_CooperativaID=?",array(date('Y'),$i,cooperativaID()))->getRowArray();
                $ticketsResueltos=mesa()->query("SELECT COUNT(*) AS 'total' FROM ticket WHERE YEAR(tic_FechaHoraRegistro)=?  AND MONTH(tic_FechaHoraRegistro)=?  AND tic_Estatus IN ('RESUELTO','CERRADO') AND tic_CooperativaID=?",array(date('Y'),$i,cooperativaID()))->getRowArray();
                $ticketsCreadosG=mesa()->query("SELECT COUNT(*) AS 'total' FROM ticketgenerico WHERE YEAR(ticg_FechaHoraRegistro)=? AND MONTH(ticg_FechaHoraRegistro)=? AND ticg_Estatus= 1 AND ticg_CooperativaID=?",array(date('Y'),$i,cooperativaID()))->getRowArray();
                $ticketsResueltosG=mesa()->query("SELECT COUNT(*) AS 'total' FROM ticketgenerico WHERE YEAR(ticg_FechaHoraRegistro)=? AND MONTH(ticg_FechaHoraRegistro)=? AND ticg_Estado IN ('RESUELTO','CERRADO') AND ticg_Estatus= 1 AND ticg_CooperativaID=?",array(date('Y'),$i,cooperativaID()))->getRowArray();
                $ticketsCreadosTotal[]=$ticketsCreados['total']+$ticketsCreadosG['total'];
                $ticketsResueltosTotal[]=$ticketsResueltos['total']+$ticketsResueltosG['total'];
            }
            $data = array(
                'ticketsCreados' => $ticketsCreadosTotal,
                'ticketsResueltos' => $ticketsResueltosTotal,
                'meses'=>array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic")
            );
        }
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    public function ajax_InfoCreadosVResueltoByMesPeriodoTabla($inicio=null,$fin=null){
        if(!is_null($inicio) || !is_null($fin)){
            $inicio = date('Y-m',strtotime($inicio));
            $fin = date('Y-m',strtotime($fin));
            $anio = substr($inicio,0,4);
            $mes = substr($inicio,5,2);
            $tickets = mesa()->query("SELECT T.tic_TicketID as 'id',T.tic_AgenteResponsableID as 'responsable',T.tic_Estatus as 'estatus',T.tic_Prioridad as 'prioridad',T.tic_FechaHoraRegistro as 'fecha','normal' as 'tipo' FROM ticket T WHERE YEAR(T.tic_FechaHoraRegistro)=? AND MONTH(T.tic_FechaHoraRegistro)=? AND T.tic_CooperativaID=?
                                        UNION
                                     SELECT TG.ticg_TicketID as 'id',TG.ticg_AgenteID as 'responsable',TG.ticg_Estado as 'estatus','BAJA' as 'prioridad',TG.ticg_FechaHoraRegistro as 'fecha','generico' as 'tipo' FROM ticketgenerico TG WHERE YEAR(TG.ticg_FechaHoraRegistro)=? AND MONTH(TG.ticg_FechaHoraRegistro)=? AND TG.ticg_Estatus=1 AND TG.ticg_CooperativaID=?",array($anio,$mes,cooperativaID(),$anio,$mes,cooperativaID()))->getResultArray();
        }else{
            $tickets = mesa()->query("SELECT  T.tic_TicketID as 'id',T.tic_AgenteResponsableID as 'responsable',T.tic_Estatus as 'estatus',T.tic_Prioridad as 'prioridad',T.tic_FechaHoraRegistro as 'fecha','normal' as 'tipo' FROM ticket T WHERE YEAR(T.tic_FechaHoraRegistro)=? AND T.tic_CooperativaID=?
                                        UNION
                                      SELECT TG.ticg_TicketID as 'id',TG.ticg_AgenteID as 'responsable',TG.ticg_Estado as 'estatus','BAJA' as 'prioridad',TG.ticg_FechaHoraRegistro as 'fecha','generico' as 'tipo' FROM ticketgenerico TG WHERE YEAR(TG.ticg_FechaHoraRegistro)=? AND TG.ticg_Estatus=1 AND TG.ticg_CooperativaID=?",array(date('Y'),cooperativaID(),date('Y'),cooperativaID()))->getResultArray();
        }
        $data=array();
        foreach ($tickets as $t){
            $t['numero']=$t['id'];
            $t['tic_TicketID']=encryptDecrypt('encrypt',$t['id']);
            if($t['responsable']!=null){
                $agente= mesa()->query("SELECT age_EmpleadoID,age_AgenteID FROM agente WHERE age_AgenteID=?",array($t['responsable']))->getRowArray();
                $empleado = federacion()->query("SELECT emp_Nombre FROM empleado WHERE emp_EmpleadoID=?", array($agente['age_EmpleadoID']))->getRowArray();
                $t['agente']=$empleado['emp_Nombre'];
            }else{
                $t['agente']='<span class="badge badge-info">Sin agente</span>';
            }
            $t['tic_FechaHoraRegistro']=shortDateTime($t['fecha'],'-');
            array_push($data,$t);
        }
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    public function ajax_PrioridadTicketsPeriodo($inicio=null,$fin=null){
        if(!is_null($inicio) || !is_null($fin)){
            $inicio = date('Y-m-d',strtotime($inicio));
            $fin = date('Y-m-d',strtotime($fin));
            $prioridad = array('BAJA','MEDIA','ALTA','URGENTE');
            $data['totalTickets']=0;
            foreach($prioridad as $p){
                $ticketTotal = mesa()->query("SELECT COUNT(*) AS 'total' FROM ticket WHERE tic_FechaHoraRegistro BETWEEN ? AND ? AND tic_Prioridad=? AND tic_CooperativaID=?",array($inicio,$fin,$p,cooperativaID()))->getRowArray()['total'];
                if($p=='BAJA'){
                    $ticketTotalG = mesa()->query("SELECT COUNT(*) AS 'total' FROM ticketgenerico WHERE ticg_FechaHoraRegistro BETWEEN ? AND ? AND ticg_Estatus= 1 AND ticg_CooperativaID=? ",array($inicio,$fin,cooperativaID()))->getRowArray()['total'];
                    $ticketTotal+=$ticketTotalG;
                }
                $data['ticket'][]=$ticketTotal;
                $data['totalTickets']+=$ticketTotal;
            }
            $data['prioridad'] = $prioridad;
        }else{
            $prioridad = array('BAJA','MEDIA','ALTA','URGENTE');
            $data['totalTickets']=0;
            foreach($prioridad as $p){
                $ticketTotal = mesa()->query("SELECT COUNT(*) AS 'total' FROM ticket WHERE YEAR(tic_FechaHoraRegistro)=? AND tic_Prioridad=? AND tic_CooperativaID=?",array(date('Y'),$p,cooperativaID()))->getRowArray()['total'];
                if($p=='BAJA'){
                    $ticketTotalG = mesa()->query("SELECT COUNT(*) AS 'total' FROM ticketgenerico WHERE YEAR(ticg_FechaHoraRegistro)=? AND ticg_Estatus= 1 AND ticg_CooperativaID=?",array(date('Y'),cooperativaID()))->getRowArray()['total'];
                    $ticketTotal+=$ticketTotalG;
                }
                $data['ticket'][]=$ticketTotal;
                $data['totalTickets']+=$ticketTotal;
            }
            $data['prioridad'] = $prioridad;
        }
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    public function ajax_PrioridadTicketsPeriodoTabla($inicio=null,$fin=null){
        if(!is_null($inicio) || !is_null($fin)){
            $inicio = date('Y-m-d',strtotime($inicio));
            $fin = date('Y-m-d',strtotime($fin));
            $tickets = mesa()->query("SELECT T.tic_TicketID as 'id',T.tic_AgenteResponsableID as 'responsable',T.tic_Estatus as 'estatus',T.tic_Prioridad as 'prioridad',T.tic_FechaHoraRegistro as 'fecha','normal' as 'tipo' FROM ticket T WHERE T.tic_FechaHoraRegistro BETWEEN ? AND ? AND T.tic_CooperativaID=?
                                        UNION
                                     SELECT TG.ticg_TicketID as 'id',TG.ticg_AgenteID as 'responsable',TG.ticg_Estado as 'estatus','BAJA'  as 'prioridad',TG.ticg_FechaHoraRegistro as 'fecha','generico' as 'tipo'  FROM ticketgenerico TG WHERE TG.ticg_FechaHoraRegistro BETWEEN ? AND ? AND TG.ticg_Estatus=1 AND TG.ticg_CooperativaID=?",array($inicio,$fin,cooperativaID(),$inicio,$fin,cooperativaID()))->getResultArray();
        }else{
            $tickets = mesa()->query("SELECT T.tic_TicketID as 'id',T.tic_AgenteResponsableID as 'responsable',T.tic_Estatus as 'estatus',T.tic_Prioridad as 'prioridad',T.tic_FechaHoraRegistro as 'fecha','normal' as 'tipo' FROM ticket T WHERE YEAR(T.tic_FechaHoraRegistro)=? AND T.tic_CooperativaID=?
                                        UNION
                                      SELECT TG.ticg_TicketID as 'id',TG.ticg_AgenteID as 'responsable',TG.ticg_Estado as 'estatus','BAJA'  as 'prioridad',TG.ticg_FechaHoraRegistro as 'fecha','generico' as 'tipo'  FROM ticketgenerico TG WHERE YEAR(TG.ticg_FechaHoraRegistro)=? AND TG.ticg_Estatus=1 AND TG.ticg_CooperativaID=?",array(date('Y'),cooperativaID(),date('Y'),cooperativaID()))->getResultArray();
        }
        $data=array();
        foreach ($tickets as $t){
            $t['numero']=$t['id'];
            $t['tic_TicketID']=encryptDecrypt('encrypt',$t['id']);
            if($t['responsable']!=null){
                $agente= mesa()->query("SELECT age_EmpleadoID,age_AgenteID FROM agente WHERE age_AgenteID=?",array($t['responsable']))->getRowArray();
                $empleado = federacion()->query("SELECT emp_Nombre FROM empleado WHERE emp_EmpleadoID=?", array($agente['age_EmpleadoID']))->getRowArray();
                $t['agente']=$empleado['emp_Nombre'];
            }else{
                $t['agente']='<span class="badge badge-info">Sin agente</span>';
            }
            $t['tic_FechaHoraRegistro']=shortDateTime($t['fecha'],'-');
            array_push($data,$t);
        }
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    public function ajax_TicketsEstatusPeriodoTabla($inicio=null,$fin=null){
        if(!is_null($inicio) || !is_null($fin)){
            $inicio = date('Y-m-d',strtotime($inicio));
            $fin = date('Y-m-d',strtotime($fin));
            $tickets = mesa()->query("SELECT T.tic_TicketID as 'id',T.tic_AgenteResponsableID as 'responsable',T.tic_Estatus as 'estatus',T.tic_Prioridad as 'prioridad',T.tic_FechaHoraRegistro as 'fecha','normal' as 'tipo' FROM ticket T WHERE T.tic_FechaHoraRegistro BETWEEN ? AND ? AND T.tic_CooperativaID=?
                                        UNION
                                     SELECT TG.ticg_TicketID as 'id',TG.ticg_AgenteID as 'responsable',TG.ticg_Estado as 'estatus','BAJA'  as 'prioridad',TG.ticg_FechaHoraRegistro as 'fecha','generico' as 'tipo'  FROM ticketgenerico TG WHERE TG.ticg_FechaHoraRegistro BETWEEN ? AND ? AND TG.ticg_Estatus=1 AND TG.ticg_CooperativaID=?",array($inicio,$fin,cooperativaID(),$inicio,$fin,cooperativaID()))->getResultArray();
        }else{
            $tickets = mesa()->query("SELECT T.tic_TicketID as 'id',T.tic_AgenteResponsableID as 'responsable',T.tic_Estatus as 'estatus',T.tic_Prioridad as 'prioridad',T.tic_FechaHoraRegistro as 'fecha','normal' as 'tipo' FROM ticket T WHERE YEAR(T.tic_FechaHoraRegistro)=? AND T.tic_CooperativaID=?
                                        UNION
                                      SELECT TG.ticg_TicketID as 'id',TG.ticg_AgenteID as 'responsable',TG.ticg_Estado as 'estatus','BAJA'  as 'prioridad',TG.ticg_FechaHoraRegistro as 'fecha','generico' as 'tipo'  FROM ticketgenerico TG WHERE YEAR(TG.ticg_FechaHoraRegistro)=? AND TG.ticg_Estatus=1 AND TG.ticg_CooperativaID=?",array(date('Y'),cooperativaID(),date('Y'),cooperativaID()))->getResultArray();
        }
        $data=array();
        foreach ($tickets as $t){
            $t['numero']=$t['id'];
            $t['tic_TicketID']=encryptDecrypt('encrypt',$t['id']);
            if($t['responsable']!=null){
                $agente= mesa()->query("SELECT age_EmpleadoID,age_AgenteID FROM agente WHERE age_AgenteID=?",array($t['responsable']))->getRowArray();
                $empleado = federacion()->query("SELECT emp_Nombre FROM empleado WHERE emp_EmpleadoID=?", array($agente['age_EmpleadoID']))->getRowArray();
                $t['agente']=$empleado['emp_Nombre'];
            }else{
                $t['agente']='<span class="badge badge-info">Sin agente</span>';
            }
            $t['tic_FechaHoraRegistro']=shortDateTime($t['fecha'],'-');
            array_push($data,$t);
        }
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    public function ajax_TicketsEstatusPeriodo($inicio=null,$fin=null){
        if(!is_null($inicio) || !is_null($fin)){
            $inicio = date('Y-m-d',strtotime($inicio));
            $fin = date('Y-m-d',strtotime($fin));
            $estatus = array('ABIERTO','ESPERA_SOLICITANTE','RESUELTO','CERRADO');
            foreach($estatus as $e){
                $ticketTotal = mesa()->query("SELECT COUNT(*) AS 'total' FROM ticket WHERE tic_FechaHoraRegistro BETWEEN ? AND ? AND tic_Estatus=? AND tic_CooperativaID=?",array($inicio,$fin,$e,cooperativaID()))->getRowArray()['total'];
                $ticketTotalG = mesa()->query("SELECT COUNT(*) AS 'total' FROM ticketgenerico WHERE ticg_FechaHoraRegistro BETWEEN ? AND ? AND ticg_Estado=? AND ticg_Estatus= 1 AND ticg_CooperativaID=?",array($inicio,$fin,$e,cooperativaID()))->getRowArray()['total'];
                $data['ticket'][]=$ticketTotal+$ticketTotalG;
                switch($e){
                    case 'ESPERA_SOLICITANTE':$data['estatus'][]='ESP SOLICITANTE';break;
                    case 'ESPERA_PROVEEDOR':$data['estatus'][]='ESP PROVEEDOR';break;
                    default: $data['estatus'][]=$e;break;
                }
            }
        }else{
            $estatus = array('ABIERTO','ESPERA_SOLICITANTE','RESUELTO','CERRADO');
            foreach($estatus as $e){
                $ticketTotal = mesa()->query("SELECT COUNT(*) AS 'total' FROM ticket WHERE YEAR(tic_FechaHoraRegistro)=? AND tic_Estatus=? AND tic_CooperativaID=?",array(date('Y'),$e,cooperativaID()))->getRowArray()['total'];
                $ticketTotalG = mesa()->query("SELECT COUNT(*) AS 'total' FROM ticketgenerico WHERE YEAR(ticg_FechaHoraRegistro)=? AND ticg_Estado=? AND ticg_CooperativaID=?",array(date('Y'),$e,cooperativaID()))->getRowArray()['total'];
                $data['ticket'][]=$ticketTotal+$ticketTotalG;
                switch($e){
                    case 'ESPERA_SOLICITANTE':$data['estatus'][]='ESP SOLICITANTE';break;
                    case 'ESPERA_PROVEEDOR':$data['estatus'][]='ESP PROVEEDOR';break;
                    default: $data['estatus'][]=$e;break;
                }
            }
        }
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    public function ajax_TicketsGCoopPeriodoTabla($inicio=null,$fin=null){
        if(!is_null($inicio) || !is_null($fin)){
            $inicio = date('Y-m-d',strtotime($inicio));
            $fin = date('Y-m-d',strtotime($fin));
            $tickets = mesa()->query("SELECT TG.ticg_TicketID as 'id',TG.ticg_AgenteID as 'responsable',TG.ticg_Estado as 'estatus','BAJA'  as 'prioridad',TG.ticg_FechaHoraRegistro as 'fecha' ,TG.ticg_CooperativaID as 'cooperativa','generico' as 'tipo',TG.ticg_Solicitante as 'solicitante',TG.ticg_Tema as 'tema' FROM ticketgenerico TG WHERE TG.ticg_FechaHoraRegistro BETWEEN ? AND ? AND TG.ticg_Estatus=1 AND TG.ticg_CooperativaID=?",array($inicio,$fin,cooperativaID()))->getResultArray();
        }else{
            $tickets = mesa()->query("SELECT TG.ticg_TicketID as 'id',TG.ticg_AgenteID as 'responsable',TG.ticg_Estado as 'estatus','BAJA'  as 'prioridad',TG.ticg_FechaHoraRegistro as 'fecha' ,TG.ticg_CooperativaID as 'cooperativa','generico' as 'tipo',TG.ticg_Solicitante as 'solicitante',TG.ticg_Tema as 'tema'  FROM ticketgenerico TG WHERE TG.ticg_Estatus=1 AND TG.ticg_CooperativaID=?",array(cooperativaID()))->getResultArray();
        }
        $data=array();
        foreach ($tickets as $t){
            $t['numero']=$t['id'];
            $t['tic_TicketID']=encryptDecrypt('encrypt',$t['id']);
            if($t['responsable']!=null){
                $agente= mesa()->query("SELECT age_EmpleadoID,age_AgenteID FROM agente WHERE age_AgenteID=?",array($t['responsable']))->getRowArray();
                $empleado = federacion()->query("SELECT emp_Nombre FROM empleado WHERE emp_EmpleadoID=?", array($agente['age_EmpleadoID']))->getRowArray();
                $t['agente']=$empleado['emp_Nombre'];
            }else{
                $t['agente']='<span class="badge badge-info">Sin agente</span>';
            }
            $t['tic_FechaHoraRegistro']=shortDateTime($t['fecha'],'-');
            $t['solicitante']=$t['solicitante'];
            $t['tema']=$t['tema'];
            array_push($data,$t);
        }
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    public function ajax_TicketsGCoopPeriodo($inicio=null,$fin=null){
        if(!is_null($inicio) || !is_null($fin)){
            $inicio = date('Y-m-d',strtotime($inicio));
            $fin = date('Y-m-d',strtotime($fin));

            $mesesList = array(
                '01' => 'Enero',
                '02' => 'Febrero',
                '03' => 'Marzo',
                '04' => 'Abril',
                '05' => 'Mayo',
                '06' => 'Junio',
                '07' => 'Julio',
                '08' => 'Agosto',
                '09' => 'Septiembre',
                '10' => 'Octubre',
                '11' => 'Noviembre',
                '12' => 'Diciembre',
            );
            $meses = array();

            while (strtotime($inicio) <= strtotime($fin)){
                $anio = substr($inicio,0,4);
                $mes = substr($inicio,5,2);
                $tickets = mesa()->query("SELECT COUNT(*) as total FROM ticketgenerico WHERE YEAR(ticg_FechaHoraRegistro)=? AND MONTH(ticg_FechaHoraRegistro)=? AND ticg_Estatus=1 AND ticg_CooperativaID=?",array($anio,$mes,cooperativaID()))->getRowArray()['total'];
                $data['tickets'][]= $tickets;
                $data['meses']=$meses;

                array_push($meses,$mesesList[$mes]);
                $inicio = date("Y-m",strtotime($inicio."+ 1 month"));
            }
        }else{
            for($i=1;$i<=12;$i++){
                $tickets = mesa()->query("SELECT COUNT(*) as total FROM ticketgenerico WHERE YEAR(ticg_FechaHoraRegistro)=? AND MONTH(ticg_FechaHoraRegistro)=? AND ticg_Estatus=1 AND ticg_CooperativaID=?",array(date('Y'),$i,cooperativaID()))->getRowArray()['total'];
                $data['tickets'][]= $tickets;
                $data['meses']=array("Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic");
            }
        }
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    public function ajax_TicketsVencidosAgenteTabla($empleadoID){
        $empleadoID=encryptDecrypt('decrypt',$empleadoID);
        $agente= mesa()->query("SELECT age_AgenteID as 'id' FROM agente WHERE age_EmpleadoID=?",array($empleadoID))->getRowArray();
        $tickets = mesa()->query("SELECT T.tic_TicketID as 'id',T.tic_AgenteResponsableID as 'responsable',T.tic_Estatus as 'estatus',T.tic_Prioridad as 'prioridad',T.tic_FechaHoraRegistro as 'fecha','normal' as 'tipo',T.tic_FechaTerminoPropuesta as 'fechaPropuesta',T.tic_CooperativaID as 'cooperativa' FROM ticket T WHERE T.tic_Estatus IN ('ABIERTO', 'ESPERA_SOLICITANTE') AND T.tic_FechaTerminoPropuesta < ? AND T.tic_AgenteResponsableID =? AND T.tic_CooperativaID=?
                                    UNION
                                    SELECT TG.ticg_TicketID as 'id',TG.ticg_AgenteID as 'responsable',TG.ticg_Estado as 'estatus','BAJA'  as 'prioridad',TG.ticg_FechaHoraRegistro as 'fecha','generico' as 'tipo',TG.ticg_FechaTerminoPropuesta as 'fechaPropuesta',TG.ticg_CooperativaID as 'cooperativa'  FROM ticketgenerico TG WHERE TG.ticg_Estado='ABIERTO' AND ticg_FechaTerminoPropuesta < ? AND TG.ticg_Estatus=1 AND TG.ticg_AgenteID =? AND TG.ticg_CooperativaID=?",array(date('Y-m-d H:i:s'),$agente['id'],cooperativaID(),date('Y-m-d H:i:s'),$agente['id'],cooperativaID()))->getResultArray();
        $data=array();
        foreach ($tickets as $t){
            $t['numero']=$t['id'];
            $t['tic_TicketID']=encryptDecrypt('encrypt',$t['id']);
            $t['tic_FechaHoraRegistro']=shortDateTime($t['fecha'],'-');
            $cooperativa = mesa()->query("SELECT coo_Nombre,coo_CooperativaID FROM cooperativa WHERE coo_CooperativaID=?",array($t['cooperativa']))->getRowArray();
            $t['cooperativa']=$cooperativa['coo_Nombre'];
            $t['fechaTerminoP']=$t['fechaPropuesta'];
            array_push($data,$t);
        }
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

}