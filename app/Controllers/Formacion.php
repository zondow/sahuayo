<?php

namespace App\Controllers;

defined('FCPATH') or exit('No direct script access allowed');

use App\Models\FormacionModel;

class Formacion extends BaseController
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
    //DiegoV->Vista para agregar editar y dar de baja proveedores
    public function proveedores()
    {
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Proveedores';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index')),
            array("titulo" => 'Catálogo de proveedores', "link" => base_url('Formacion/proveedores'))
        );

        //Datos solicitud
        $model = new FormacionModel();
        $data['proveedores'] = $model->getDatosProveedores();

        //Styles
        $data['styles'][] = base_url("assets/libs/select2/select2.min.css");

        //Scripts
        $data['scripts'][] = base_url("assets/libs/select2/select2.min.js");

        //datatables
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');
        $data['scripts'][] = base_url('assets/plugins/datatables/jquery.dataTables.min.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/js/dataTables.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/dataTables.buttons.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/JSZip-2.5.0/jszip.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/pdfmake.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/vfs_fonts.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.html5.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.colVis.js');

        //Vistas
        echo view('htdocs/header', $data);
        echo view('formacion/proveedores');
        echo view('htdocs/footer');
    } //end proveedores

    //Diego->Vista para agregar editar y dar de baja cursos
    public function cursos()
    {
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Cursos';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index')),
            array("titulo" => 'Catálogo de cursos', "link" => base_url('Formacion/cursos'))
        );

        //Datos solicitud
        $model = new FormacionModel();
        $data['cursos'] = $model->getCursos();

        //datatables
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');
        $data['scripts'][] = base_url('assets/plugins/datatables/jquery.dataTables.min.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/js/dataTables.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/dataTables.buttons.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/JSZip-2.5.0/jszip.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/pdfmake.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/vfs_fonts.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.html5.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.colVis.js');

        //Styles
        $data['styles'][] = base_url('assets/libs/bootstrap-select/bootstrap-select.min.css');
        $data['styles'][] = base_url('assets/libs/select2/css/select2.min.css');
        $data['styles'][] = base_url('assets/libs/lightbox/css/lightbox.css');
        $data['styles'][] = base_url('assets/libs/custombox/custombox.min.css');
        $data['styles'][] = base_url('assets/libs/summernote/summernote-bs4.css');

        //Scripts
        $data['scripts'][] = base_url('assets/libs/bootstrap-select/bootstrap-select.min.js');
        $data['scripts'][] = base_url('assets/libs/select2/js/select2.full.min.js');
        $data['scripts'][] = base_url("assets/js/pages/bootstrap-filestyle.min.js");
        $data['scripts'][] = base_url('assets/libs/lightbox/js/lightbox.js');
        $data['scripts'][] = base_url('assets/libs/custombox/custombox.min.js');
        $data['scripts'][] = base_url('assets/libs/summernote/summernote-bs4.min.js');
        $data['scripts'][] = base_url('assets/libs/summernote/lang/summernote-es-ES.js');
        $data['scripts'][] = base_url("assets/js/modalPdf.js");
        $data['scripts'][] = base_url("assets/js/formacion/cursos.js");


        //Vistas
        echo view('htdocs/header', $data);
        echo view('formacion/cursos');
        echo view('htdocs/modalPdf');
        echo view('htdocs/footer');
    } //end cursos

    //DiegoV->Vista para agregar editar y dar de baja instructores
    public function instructores()
    {
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Instructores';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index')),
            array("titulo" => 'Catálogo de Instructores', "link" => base_url('Formacion/instructores'))
        );

        //Datos solicitud
        $model = new FormacionModel();
        $data['empleados'] = $model->getEmpleados();
        $data['instructores'] = $model->getInstructores();


        //Styles
        $data['styles'][] = base_url('assets/libs/select2/css/select2.min.css');
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');

        //Scripts
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

        $data['scripts'][] = base_url("assets/js/formacion/instructores.js");


        //Vistas
        echo view('htdocs/header', $data);
        echo view('formacion/instructores');
        echo view('htdocs/modalPdf');
        echo view('htdocs/footer');
    } //end instructores

    //Lia->Capacitaciones del empleado
    public function misCapacitaciones()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Mis capacitaciones';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index')),
            array("titulo" => 'Mis capacitaciones', "link" => base_url('Formacion/capacitacionesInstructor')),
        );

        $model = new FormacionModel();
        $data['capacitaciones'] =  $model->getCapacitacionesByEmpleadoID();

        //Styles
        $data['styles'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.css");
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');
        $data['styles'][] = base_url('assets/libs/select2/select2.min.css');


        //Scripts
        $data['scripts'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.min.js");
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
        $data['scripts'][] = 'https://cdn.datatables.net/buttons/1.2.1/js/buttons.print.min.js';
        $data['scripts'][] = base_url("assets/js/modalPdf.js");

        $data['scripts'][] = base_url("assets/js/formacion/misCapacitaciones.js");

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('formacion/misCapacitaciones');
        echo view('htdocs/modalPdf');
        echo view('htdocs/footer');
    }

    //Lia->vista de las capacitaciones para los instructores
    public function capacitacionesInstructor()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Capacitaciones';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index')),
            array("titulo" => 'Capacitaciones', "link" => base_url('Formacion/capacitacionesInstructor')),
        );

        $model = new FormacionModel();
        $data['capacitaciones'] = $model->getCapacitacionesInstructor();

        //Styles
        $data['styles'][] = base_url('assets/libs/select2/select2.min.css');
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');
        $data['styles'][] = base_url('assets/libs/summernote/summernote-bs4.css');

        //Scripts
        $data['scripts'][] = base_url('assets/plugins/momentjs/moment-with-locales.js');
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
        $data['scripts'][] = base_url('assets/libs/summernote/summernote-bs4.min.js');
        $data['scripts'][] = base_url('assets/libs/summernote/lang/summernote-es-ES.js');


        $data['scripts'][] = base_url('assets/js/formacion/capacitacionesInstructor.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('formacion/capacitacionesInstructor');
        echo view('htdocs/modalConfirmation');
        echo view('htdocs/footer');
    }

    //Diego-> programa de capacitacion
    public function programaCapacitacion()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);


        $data['title'] = 'Programa de capacitación';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index')),
            array("titulo" => 'Programa de capacitación', "link" => base_url('Formacion/programaCapacitacion')),
        );

        $model = new FormacionModel();
        $data['capacitaciones'] = $model->getCapacitaciones();
        $data['proveedores'] = $model->getProveedores();
        $data['instructores'] = $model->getInstructores();
        $data['cursos'] = $model->getCursos();

        //Styles
        $data['styles'][] = base_url('assets/libs/select2/select2.min.css');
        $data['styles'][] = base_url('assets/libs/custombox/custombox.min.css');
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');

        //Scripts
        $data['scripts'][] = base_url('assets/plugins/momentjs/moment-with-locales.js');
        $data['scripts'][] = base_url('assets/libs/select2/select2.min.js');
        $data['scripts'][] = base_url('assets/libs/custombox/custombox.min.js');
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

        $data['styles'][] = base_url('assets/libs/summernote/summernote-bs4.css');
        $data['scripts'][] = base_url('assets/libs/summernote/summernote-bs4.min.js');
        $data['scripts'][] = base_url('assets/libs/summernote/lang/summernote-es-ES.js');

        //Sweet alert
        $data['styles'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.css");
        $data['scripts'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.min.js");

        //clockpicker
        $data['styles'][] = base_url('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css');
        $data['scripts'][] = base_url('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js');

        //Datepicker
        $data['styles'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css');
        $data['styles'][] = base_url('assets/libs/bootstrap-daterangepicker/daterangepicker.css');
        $data['scripts'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js');
        $data['scripts'][] = base_url('assets/libs/bootstrap-daterangepicker/daterangepicker.js');

        $data['scripts'][] = base_url('assets/js/formacion/programaCapacitacion.js');

        //Cargar vistas

        echo view('htdocs/header', $data);
        echo view('formacion/programacionCapacitacion');
        echo view('htdocs/modalConfirmation');
        echo view('htdocs/footer');
    } //end programaCapacitacion

    //Lia->Vista para agregar empleados a la capacitacion
    public function participantesCapacitacion($capacitacionID)
    {

        $capacitacionID = encryptDecrypt('decrypt', $capacitacionID);

        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Informacion de la capacitación';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index')),
            array("titulo" => 'Programas de capacitación', "link" => base_url('Formacion/programaCapacitacion')),
            array("titulo" => 'Informacion de la capacitación', "link" => base_url('Formacion/participantesCapacitacion/' . $capacitacionID)),
        );

        $model = new FormacionModel();
        $data['capacitacionInfo'] = $model->getCapacitacionInfo($capacitacionID);
        $data['asistencia'] = $model->getAsistenciaCapacitacion($capacitacionID);
        $data['encuesta'] = $model->getResultadosEncuestaSatisfaccion($capacitacionID);


        //Styles
        $data['styles'][] = base_url('assets/libs/custombox/custombox.min.css');
        $data['styles'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css');
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        //Sweet alert
        $data['styles'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.css");
        $data['scripts'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.min.js");
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
        $data['scripts'][] = 'https://cdn.datatables.net/fixedcolumns/3.2.6/js/dataTables.fixedColumns.min.js';
        $data['scripts'][] = 'https://cdn.datatables.net/buttons/1.2.1/js/buttons.print.min.js';

        //Styles
        $data['styles'][] = base_url('assets/libs/select2/css/select2.min.css');
        $data['styles'][] = base_url('assets/libs/custombox/custombox.min.css');
        $data['styles'][] = base_url('assets/libs/dropzone/dropzone.min.css');
        $data['styles'][] = base_url('assets/libs/lightbox/css/lightbox.css');

        $data['styles'][] = base_url('assets/plugins/lightbox/css/lightbox.css');
        $data['scripts'][] = base_url('assets/plugins/lightbox/js/lightbox.js');

        //dropzone
        $data['scripts'][] = base_url('assets/libs/custombox/custombox.min.js');
        $data['scripts'][] = base_url('assets/libs/dropzone/dropzone.min.js');

        $data['scripts'][] = base_url("assets/js/modalPdf.js");
        $data['scripts'][] = base_url("assets/js/formacion/participantesCapacitacion.js");

        //Cargar vistas
        echo View('htdocs/header', $data);
        echo View('formacion/participantesCapacitacion');
        echo View('htdocs/modalPdf');
        echo View('htdocs/footer');
    } //end participantesCapacitacion

    //Lia->vista de la info de la capacitacion al participante
    public function infoCapacitacionParticipante($idCapacitacion)
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $idCapacitacion = encryptDecrypt('decrypt', $idCapacitacion);

        $data['title'] = 'Informacion de la capacitación';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index')),
            array("titulo" => 'Mis capacitaciones', "link" => base_url('Formacion/misCapacitaciones')),
            array("titulo" => 'Informacion de la capacitación', "link" => base_url('Formacion/infoCapacitacionParticipante/' . encryptDecrypt('encrypt', $idCapacitacion))),
        );

        $model = new FormacionModel();
        $data['capacitacionInfo'] = $model->getCapacitacionInfo($idCapacitacion);
        $data['encuesta'] = $model->getEncuestaCapacitacion($idCapacitacion);

        //STYLES
        $data['styles'][] = base_url('assets/libs/datatables/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/libs/datatables/responsive.bootstrap4.css');

        $data['styles'][] = base_url('assets/css/encuestaCapacitacion.css');

        //SCRIPTS
        $data['scripts'][] = base_url('assets/libs/datatables/jquery.dataTables.min.js');
        $data['scripts'][] = base_url('assets/libs/datatables/dataTables.bootstrap4.min.js');
        $data['scripts'][] = base_url('assets/libs/datatables/dataTables.responsive.min.js');


        $data['scripts'][] = base_url("assets/js/formacion/infoCapacitacionParticipante.js");

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('formacion/infoCapacitacionParticipante');
        echo view('htdocs/footer');
    } //end infoCapacitacionParticipante

    //Lia -> Encuesta de satisfaccion
    public function saveEncuestaSatisfaccion($capacitacionID)
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {


            $empleado = (int)session('id');
            $entrevista = array(
                "ent_CapacitacionID" => (int)$capacitacionID,
                "ent_Fecha" => post("txtFechaEncuesta"),
                "ent_EmpleadoID" => (int)$empleado,
                "ent_Metodologia1a" => (post("txtMetodologia1_A") == null) ? '' : post("txtMetodologia1_A"),
                "ent_Metodologia1b" => (post("txtMetodologia1_B") == null) ? '' : post("txtMetodologia1_B"),
                "ent_Metodologia1c" => (post("txtMetodologia1_C") == null) ? '' : post("txtMetodologia1_C"),
                "ent_Metodologia1d" => (post("txtMetodologia1_D") == null) ? '' : post("txtMetodologia1_D"),
                "ent_Metodologia1e" => (post("txtMetodologia1_E") == null) ? '' : post("txtMetodologia1_E"),
                "ent_Instructor1a" => (post("txtInstructor1_A") == null) ? '' : post("txtInstructor1_A"),
                "ent_Instructor1b" => (post("txtInstructor1_B") == null) ? '' : post("txtInstructor1_B"),
                "ent_Instructor1c" => (post("txtInstructor1_C") == null) ? '' : post("txtInstructor1_C"),
                "ent_Instructor1d" => (post("txtInstructor1_D") == null) ? '' : post("txtInstructor1_D"),
                "ent_Instructor1e" => (post("txtInstructor1_E") == null) ? '' : post("txtInstructor1_E"),
                "ent_Instructor1f" => (post("txtInstructor1_F") == null) ? '' : post("txtInstructor1_F"),
                "ent_Organizacion1a" => (post("txtOrganizacion1_A") == null) ? '' : post("txtOrganizacion1_A"),
                "ent_Organizacion1b" => (post("txtOrganizacion1_B") == null) ? '' : post("txtOrganizacion1_B"),
                "ent_Satisfaccion1a" => (post("txtSatisfaccion1_A") == null) ? '' : post("txtSatisfaccion1_A"),
                "ent_Satisfaccion1b" => (post("txtSatisfaccion1_B") == null) ? '' : post("txtSatisfaccion1_B"),
                "ent_Satisfaccion1c" => (post("txtSatisfaccion1_C") == null) ? '' : post("txtSatisfaccion1_C"),
                "ent_Comentarios" => post("txtComentarios"),
            );
            $promedio = $this->obtenerValorEncuesta($entrevista);
            $entrevista['ent_Promedio'] = $promedio;
            $builder = db()->table("encuestacapacitacion");
            $result = $builder->insert($entrevista);

            if ($result)
                $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡La encuesta de satisfacción se guardó correctamente!'));
            else
                $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => 'Ocurrio un problema al guardar la encuesta, por favor intente mas tarde.'));

            return redirect()->to($_SERVER['HTTP_REFERER']);
        }
    } //end saveEncuestaSatisfaccion

    //Lia->Vista de informacion de la capacitacion para el instructor
    public function informacionCapacitacionInstructor($capacitacionID)
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $capacitacionID = encryptDecrypt('decrypt', $capacitacionID);
        $data['title'] = 'Informacion de la capacitación';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index')),
            array("titulo" => 'Capacitaciones', "link" => base_url('Formacion/capacitacionesInstructor')),
            array("titulo" => 'Informacion de la capacitación', "link" => base_url('Formacion/informacionCapacitacionInstructor/' . $capacitacionID)),
        );

        $model = new FormacionModel();
        $data['capacitacionInfo'] = $model->getCapacitacionInfo($capacitacionID);
        $data['asistencia'] = $model->getAsistenciaCapacitacion($capacitacionID);

        //Styles
        $data['styles'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.css");
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] = base_url('assets/libs/select2/select2.min.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');
        $data['styles'][] = base_url('assets/libs/bootstrap-select/bootstrap-select.min.css');


        //Scripts
        $data['scripts'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.min.js");
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
        $data['scripts'][] = 'https://cdn.datatables.net/buttons/1.2.1/js/buttons.print.min.js';
        $data['scripts'][] = base_url('assets/libs/select2/select2.min.js');
        $data['scripts'][] = base_url('assets/libs/bootstrap-select/bootstrap-select.min.js');

        $data['scripts'][] = base_url("assets/js/formacion/infoCapacitacionInstructor.js");

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('formacion/infoCapacitacionInstructor');
        echo view('htdocs/footer');
    } //end programaCapacitacion

    //HUGO -> Catalogo de competencias
    function competencias()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Competencias';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Catálogo de competencias', "link" => base_url('Formacion/competencias'), "class" => "active"),
        );
        $model = new FormacionModel();
        $data['competenciasLocales'] = $model->getCompetencias(1);

        //datatables
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');
        $data['scripts'][] = base_url('assets/plugins/datatables/jquery.dataTables.min.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/js/dataTables.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/dataTables.buttons.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/JSZip-2.5.0/jszip.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/pdfmake.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/vfs_fonts.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.html5.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.colVis.js');

        //Styles
        $data['styles'][] = base_url('assets/libs/custombox/custombox.min.css');
        $data['styles'][] = base_url('assets/libs/custombox/custombox.min.css');

        //Scripts
        $data['scripts'][] = base_url('assets/libs/custombox/custombox.min.js');
        $data['scripts'][] = base_url('assets/js/formacion/modalCompetencias.js');
        $data['scripts'][] = base_url('assets/libs/custombox/custombox.min.js');


        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('formacion/competencias', $data);
        echo view('formacion/modalCompetencias', $data);
        echo view('formacion/modalVerPreguntas', $data);
        echo view('formacion/modalClave', $data);
        echo view('htdocs/footer', $data);
    } //end competencias

	/*
      ______ _    _ _   _  _____ _____ ____  _   _ ______  _____
     |  ____| |  | | \ | |/ ____|_   _/ __ \| \ | |  ____|/ ____|
     | |__  | |  | |  \| | |      | || |  | |  \| | |__  | (___
     |  __| | |  | | . ` | |      | || |  | | . ` |  __|  \___ \
     | |    | |__| | |\  | |____ _| || |__| | |\  | |____ ____) |
     |_|     \____/|_| \_|\_____|_____\____/|_| \_|______|_____/
    */

    //Diego -> agregar/actualizar curso
    public function addCurso()
    {
        $post = $this->request->getPost();
        if ($post['cur_CursoID'] <= 0) {
            $data = array(
                "cur_Nombre" => $post['cur_Nombre'],
                "cur_Objetivo" => $post['cur_Objetivo'],
                "cur_Modalidad" => $post['cur_Modalidad'],
                "cur_Horas" => $post['cur_Horas'],
                "cur_Temario" => $post['cur_Temario'],
                "cur_EmpleadoID" => session('id'),
            );
            $builder = $this->db->table('curso');
            $builder->insert($data);
            $result = $this->db->insertID();

            if ($result) {
                insertLog($this, session('id'), 'Insertar', 'curso', $result);
                $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Se registro el curso correctamente!'));
            } else {
                $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error al registro intente mas tarde!'));
            }
        } else {
            $builder = $this->db->table('curso');
            $result = $builder->update($post, array('cur_CursoID' => (int)$post['cur_CursoID']));
            if ($result) {
                insertLog($this, session('id'), 'Actualizar', 'curso', $post['cur_CursoID']);
                $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Se actualizó el curso correctamente!'));
            } else {
                $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error al actualizar intente mas tarde!'));
            }
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    } //end addCurso

    //Diego -> agregar/actualizar proveedores
    public function addProveedor()
    {
        $post = $this->request->getPost();
        if ($post['pro_ProveedorID'] <= 0) {
            unset($post['pro_ProveedorID']);
            $post['pro_EmpleadoID'] = session('id');
            $builder = $this->db->table('proveedor');
            $builder->insert($post);
            $result = $this->db->insertID();
            if ($result) {
                insertLog($this, session('id'), 'Insertar', 'proveedor', $result);
                $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Se registro el proveedor correctamente!'));
            } else {
                $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error al registro intente mas tarde!'));
            }
        } else {
            $builder = $this->db->table('proveedor');
            $result = $builder->update($post, array('pro_ProveedorID' => (int)$post['pro_ProveedorID']));
            if ($result) {
                insertLog($this, session('id'), 'Actualizar', 'proveedor', $post['pro_ProveedorID']);
                $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Se actualizó el proveedor correctamente!'));
            } else {
                $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error al actualizar intente mas tarde!'));
            }
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }

    //Diego->estatus curso
    function estatusCurso($estatus, $idCurso)
    {
        $idCurso = encryptDecrypt('decrypt', $idCurso);
        $builder = $this->db->table('curso');
        $result = $builder->update(array('cur_Estatus' => (int)$estatus), array('cur_CursoID' => (int)$idCurso));
        if ($result) {
            insertLog($this, session('id'), 'Cambiar Estatus', 'curso', (int)$idCurso);
            $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Se actualizó el estatus del curso correctamente!'));
        } else {
            $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error intente mas tarde!'));
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    } //end estatusCurso

    //Diego->estatus proveedor
    function estatusProveedor($estatus, $idProveedor)
    {
        $idProveedor = encryptDecrypt('decrypt', $idProveedor);
        $builder = $this->db->table('proveedor');
        $result = $builder->update(array('pro_Estatus' => (int)$estatus), array('pro_ProveedorID' => (int)$idProveedor));
        if ($result) {
            insertLog($this, session('id'), 'Cambiar Estatus', 'proveedor', (int)$idProveedor);
            $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Se actualizó el estatus del proveedor correctamente!'));
        } else {
            $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error intente mas tarde!'));
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    } //end estatusProveedor

    //Diego -> agregar/actualizar instructor
    public function addInstructor()
    {
        $post = $this->request->getPost();
        if ($post['ins_InstructorID'] <= 0) {
            unset($post['ins_InstructorID']);
            $post['ins_EmpleadoIDReg'] = session('id');
            $builder = $this->db->table('instructor');
            $builder->insert($post);
            $result = $this->db->insertID();
            if ($result) {
                insertLog($this, session('id'), 'Insertar', 'instructor', $result);
                $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Se registro el instructor correctamente!'));
            } else {
                $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error al registro intente mas tarde!'));
            }
        } else {
            $builder = $this->db->table('instructor');
            $result = $builder->update($post, array('ins_InstructorID' => (int)$post['ins_InstructorID']));
            if ($result) {
                insertLog($this, session('id'), 'Actualizar', 'instructor', $post['ins_InstructorID']);
                $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Se actualizó el instructor correctamente!'));
            } else {
                $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error al actualizar intente mas tarde!'));
            }
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }

    //Diego->estatus instructor
    function estatusInstructor($estatus, $idInstructor)
    {
        $idInstructor = encryptDecrypt('decrypt', $idInstructor);
        $builder = $this->db->table('instructor');
        $result = $builder->update(array('ins_Estatus' => (int)$estatus), array('ins_InstructorID' => (int)$idInstructor));
        if ($result) {
            insertLog($this, session('id'), 'Cambiar Estatus', 'instructor', (int)$idInstructor);
            $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Se actualizó el estatus del instructor correctamente!'));
        } else {
            $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error intente mas tarde!'));
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    } //end estatusCurso

    //Diego -> agregar/actualizar capacitacion
    public function addCapacitacion()
    {

        $post = $this->request->getPost();

        $dias = array();
        for ($i = 0; $i < count($post['fecha']); $i++) {
            if ($post['fecha'][$i] !== "") {
                $row = array(
                    "fecha" => $post['fecha'][$i],
                    "inicio" => $post['inicio'][$i],
                    "fin" => $post['fin'][$i],
                );
                array_push($dias, $row);
            }
        }

        $builder = db()->table('capacitacion');
        if ($post['cap_CapacitacionID'] <= 0) {
            unset($post['cap_CapacitacionID']);

            $dataInsert = array(
                'cap_CursoID' => $post['cap_CursoID'],
                'cap_FechaRegistro' => date('Y-m-d'),
                'cap_Fechas' => json_encode($dias),
                'cap_NumeroDias' => count($post['fecha']),
                'cap_ProveedorCursoID' => $post['cap_ProveedorCursoID'],
                'cap_InstructorID' => $post['cap_InstructorID'],
                'cap_Costo' => $post['cap_Costo'],
                'cap_Tipo' => $post['cap_Tipo'],
                'cap_Observaciones' => $post['cap_Observaciones'],
                'cap_EmpleadoID' => session('id'),
                'cap_Comprobante' => $post['cap_Comprobante'],
                'cap_TipoComprobante' => $post['cap_TipoComprobante'],
                'cap_CalAprobatoria' => $post['cap_CalAprobatoria'],
                'cap_Lugar' => $post['cap_Lugar'],
                'cap_Dirigido' => $post['cap_Dirigido'],

            );

            $builder->insert($dataInsert);
            $result = $this->db->insertID();
            if ($result) {
                insertLog($this, session('id'), 'Insertar', 'capacitacion', $result);
                $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Se registro la capacitación correctamente!'));
            } else {
                $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error al registro intente mas tarde!'));
            }
        } else {
            $dataUpdate = array(
                'cap_CursoID' => $post['cap_CursoID'],
                'cap_Fechas' => json_encode($dias),
                'cap_NumeroDias' => count($post['fecha']),
                'cap_Costo' => $post['cap_Costo'],
                'cap_Tipo' => $post['cap_Tipo'],
                'cap_Observaciones' => $post['cap_Observaciones'],
                'cap_EmpleadoID' => session('id'),
                'cap_Comprobante' => $post['cap_Comprobante'],
                'cap_TipoComprobante' => $post['cap_TipoComprobante'],
                'cap_CalAprobatoria' => $post['cap_CalAprobatoria'],
                'cap_Lugar' => $post['cap_Lugar'],
                'cap_Dirigido' => $post['cap_Dirigido'],
            );

            if (array_key_exists('cap_ProveedorCursoID', $post)) {
                $dataUpdate['cap_ProveedorCursoID'] = $post['cap_ProveedorCursoID'];
            }

            if (array_key_exists('cap_InstructorID', $post)) {
                $dataUpdate['cap_InstructorID'] = $post['cap_InstructorID'];
            }


            $result = $builder->update($dataUpdate, array('cap_CapacitacionID' => (int)$post['cap_CapacitacionID']));

            if ($result) {
                insertLog($this, session('id'), 'Actualizar', 'capacitacion', $post['cap_CapacitacionID']);
                $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Se actualizó la capacitación correctamente!'));
            } else {
                $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error al actualizar intente mas tarde!'));
            }
        }

        return redirect()->to($_SERVER['HTTP_REFERER']);
    }

    //Lia -> Calcular total de la encuesta
    private function obtenerValorEncuesta($data)
    {

        $promedioTotal = 0.0;

        //Metodologia
        $metodologia = 0;
        $metodologia += $this->switchValorEncuesta($data['ent_Metodologia1a']);
        $metodologia += $this->switchValorEncuesta($data['ent_Metodologia1b']);
        $metodologia += $this->switchValorEncuesta($data['ent_Metodologia1c']);
        $metodologia += $this->switchValorEncuesta($data['ent_Metodologia1d']);
        $metodologia += $this->switchValorEncuesta($data['ent_Metodologia1e']);
        $totalMetodologia = $metodologia / 5;

        //Instructor
        $instructor = 0;
        $instructor += $this->switchValorEncuesta($data['ent_Instructor1a']);
        $instructor += $this->switchValorEncuesta($data['ent_Instructor1b']);
        $instructor += $this->switchValorEncuesta($data['ent_Instructor1c']);
        $instructor += $this->switchValorEncuesta($data['ent_Instructor1d']);
        $instructor += $this->switchValorEncuesta($data['ent_Instructor1e']);
        $instructor += $this->switchValorEncuesta($data['ent_Instructor1f']);
        $totalInstructor = $instructor / 6;

        //Organizacion
        $organizacion = 0;
        $organizacion += $this->switchValorEncuesta($data['ent_Organizacion1a']);
        $organizacion += $this->switchValorEncuesta($data['ent_Organizacion1b']);
        $totalOrganizacion = $organizacion / 2;

        //Satisfaccion
        $satisfaccion = 0;
        $satisfaccion += $this->switchValorEncuesta($data['ent_Satisfaccion1a']);
        $satisfaccion += $this->switchValorEncuesta($data['ent_Satisfaccion1b']);
        $satisfaccion += $this->switchValorEncuesta($data['ent_Satisfaccion1c']);
        $totalSatisfaccion = $satisfaccion / 3;


        $promedioTotal = (float)$totalMetodologia + (float)$totalInstructor + (float)$totalOrganizacion + (float)$totalSatisfaccion;
        $promedioTotal = $promedioTotal / 4;

        return $promedioTotal;
    } //obtenerValorEncuesta

    //Lia -> Valor de la opcion seleccionada
    private function switchValorEncuesta($estatus)
    {

        $value = 0;
        switch ($estatus) {
            case "Totalmente de acuerdo":
                $value = 5;
                break;
            case "De acuerdo":
                $value = 4;
                break;
            case "Indeciso":
                $value = 3;
                break;
            case "En desacuerdo":
                $value = 2;
                break;
            case "Totalmente en desacuerdo":
                $value = 1;
                break;
        } //switch
        return $value;
    } //switchValorEn

    //Lia guarda los comentarios de capacitacion del instructor
    public function saveComentariosInstructor()
    {

        $post = $this->request->getPost();
        $builder = db()->table('capacitacion');
        $result = $builder->update(array('cap_ComentariosInstructor' => $post['cap_ComentariosInstructor']), array('cap_CapacitacionID' => (int)$post['cap_CapacitacionID']));
        if ($result) {
            $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => 'Comentarios enviados.'));
        } else {
            $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error intente mas tarde!'));
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }

    //HUGO->Update estatus competencia
    function updateCompetenciaEstatus($competenciaID, $estatus)
    {
        $competenciaID = encryptDecrypt('decrypt', $competenciaID);
        $estatus = encryptDecrypt('decrypt', $estatus);
        $builder = db()->table('competencia');
        $result = $builder->update(array('com_Estatus' => $estatus), array('com_CompetenciaID' => (int)$competenciaID));
        if ($result) {
            $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Se actualizó el estatus correctamente!'));
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

    //Diego -> traer info curso
    public function ajax_getInfoCurso($cursoID)
    {
        $cursoID = encryptDecrypt('decrypt', $cursoID);
        $result = $this->db->query("SELECT * FROM curso WHERE cur_CursoID = " . (int)$cursoID)->getRowArray();
        if ($result) {
            echo json_encode(array("response" => "success", "result" => $result));
        } else {
            echo json_encode(array("response" => "error", "msg" => 'Ocurrio un error. Intentelo nuevamente'));
        }
    } //end ajax_getInfoCurso

    //Diego -> traer info proveedor
    public function ajax_getInfoProveedor($proveedorID)
    {
        $result = $this->db->query("SELECT * FROM proveedor WHERE pro_ProveedorID = " . (int)$proveedorID)->getRowArray();
        if ($result) {
            echo json_encode(array("response" => "success", "result" => $result));
        } else {
            echo json_encode(array("response" => "error", "msg" => 'Ocurrio un error. Intentelo nuevamente'));
        }
    }

    //Diego -> traer info instructor
    public function ajax_getInfoInstructor($instructorID)
    {
        $result = $this->db->query("SELECT * FROM instructor WHERE ins_InstructorID = " . (int)$instructorID)->getRowArray();
        if ($result) {
            echo json_encode(array("response" => "success", "result" => $result));
        } else {
            echo json_encode(array("response" => "error", "msg" => 'Ocurrio un error. Intentelo nuevamente'));
        }
    }

    //Lia trae los comentarios del instructor
    public function ajax_getComentariosCap()
    {

        $post = $this->request->getPost();
        $idCapacitacion = $post['capacitacionID'];
        $sql = "SELECT cap_CapacitacionID,cap_ComentariosInstructor FROM capacitacion WHERE cap_CapacitacionID=?";
        $capacitacion = $this->db->query($sql, array($idCapacitacion))->getRowArray();

        echo json_encode(array("response" => "success", "capacitacion" => $capacitacion));
    }

    //Diego -> Obtiene la informacion de la capacitacion
    public function ajaxGetCapacitacionInfo()
    {
        $capacitacionID = (int)post('capacitacionID');
        $sql = "SELECT * FROM capacitacion WHERE cap_CapacitacionID=?";
        $capacitacionInfo = $this->db->query($sql, [$capacitacionID])->getRowArray();

        $response = array(
            'code' => (is_null($capacitacionID)) ? 0 : 1,
            'tipo' => (($capacitacionInfo['cap_Tipo'])),
            'capacitacionInfo' => $capacitacionInfo,
            'fechas' => json_decode($capacitacionInfo['cap_Fechas'], true),
        );
        echo json_encode($response);
    }

    public function ajaxTerminarCapacitacion()
    {
        $post = $this->request->getPost();
        $builder = db()->table('capacitacion');
        $result =$builder->update(array('cap_Estado' => 'Terminada'), array('cap_CapacitacionID' => $post['idCapacitacion']));
        $data['code'] = $result ? 1 : 0;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    //Lia->envia la convocatoria de la capacitacion
    public function ajaxEnviarConvocatoriaCapacitacion()
    {

        $post = $this->request->getPost();
        $idCapacitacion = $post['idCapacitacion'];

        $sql = "SELECT * FROM capacitacion LEFT JOIN curso ON cur_CursoID=cap_CursoID WHERE cap_CapacitacionID=?";
        $capacitacion = $this->db->query($sql, array($idCapacitacion))->getRowArray();

        $txtFechas = "";
        $fechas = json_decode($capacitacion['cap_Fechas'], true);
        for ($i = 0; $i < count($fechas); $i++) {
            $txtFechas .= shortDate($fechas[$i]['fecha'], '-') . ' de ' . shortTime($fechas[$i]['inicio']) . ' a ' . shortTime($fechas[$i]['fin']) . ', ';
        }

        $subject = 'Convocatoria de capacitación';
        $texto = $capacitacion['cur_Nombre'] . ' que se llevara a cabo en ' . $capacitacion['cap_Lugar'] . ' los dias ' . $txtFechas . '.';
        if ($capacitacion['cap_Tipo'] === "INTERNO") {
            $instructor = $this->db->query("SELECT ins_EmpleadoID, emp_Correo,emp_Nombre as 'ins_Nombre' FROM instructor JOIN empleado ON ins_EmpleadoID=emp_EmpleadoID WHERE ins_InstructorID=" . $capacitacion['cap_InstructorID'])->getRowArray();

            $data = array(
                "nombre" => $instructor['ins_Nombre'],
                "id" => $idCapacitacion,
                "texto" => $texto,
                "nombreCurso" => $capacitacion['cur_Nombre']
            );
            sendMail($instructor['emp_Correo'], $subject, $data, "ConvocatoriaInstructor");

            $notificacion = array(
                "not_EmpleadoID" => $instructor['ins_EmpleadoID'],
                "not_Titulo" => $subject,
                "not_Descripcion" => $texto,
                "not_EmpleadoIDCreo" => (int)session("id"),
                "not_FechaRegistro" => date('Y-m-d H:i:s'),
                "not_URL" => 'Formacion/capacitacionesInstructor'
            );
            $builder = db()->table("notificacion");
            $builder->insert($notificacion);
        }

        $enviado = 0; //Cambia a 1 cuando se envien correos de prueba
        $participantes = $this->db->query("SELECT * FROM capacitacionempleado WHERE cape_CapacitacionID=" . (int)$idCapacitacion)->getResultArray();
        foreach ($participantes as $participante) {
            $sql = "SELECT emp_Correo,emp_Nombre,emp_EmpleadoID FROM empleado WHERE  emp_EmpleadoID= ?";
            $empleado = $this->db->query($sql, array($participante['cape_EmpleadoID']))->getRowArray();
            if ($empleado['emp_Correo'] !== '') {

                $data = array(
                    "nombre" => $empleado['emp_Nombre'],
                    "id" => $idCapacitacion,
                    "texto" => $texto,
                    "nombreCurso" => $capacitacion['cur_Nombre']
                );

                sendMail($empleado['emp_Correo'], $subject, $data, "ConvocatoriaParticipante");

                $notificacion = array(
                    "not_EmpleadoID" => $empleado['emp_EmpleadoID'],
                    "not_Titulo" => $subject,
                    "not_Descripcion" => $texto,
                    "not_EmpleadoIDCreo" => (int)session("id"),
                    "not_FechaRegistro" => date('Y-m-d H:i:s'),
                    "not_URL" => 'Formacion/misCapacitaciones'
                );
                $builder = db()->table("notificacion");
                $builder->insert($notificacion);

                $enviado++;
            }
        }
        if ($enviado > 0) {
            $builder = db()->table("capacitacion");
            $builder->update(array('cap_Estado' => 'Enviada'), array('cap_CapacitacionID' => $idCapacitacion));

            echo json_encode(array("response" => 1));
        } else echo json_encode(array("response" => 0));
    }

    //Lia->trae todos los empleados y los empleados con los datos previos a la capacitacion
    public function ajax_getEmpleados($cursoID)
    {
        $sql = "SELECT E.emp_EmpleadoID, E.emp_Nombre, E.emp_Numero, P.pue_Nombre, A.are_Nombre,
                P.pue_PuestoID,S.suc_Sucursal
                FROM empleado E 
                LEFT JOIN puesto P ON P.pue_PuestoID = E.emp_PuestoID  
                LEFT JOIN area A ON A.are_AreaID = E.emp_AreaID
                LEFT JOIN sucursal S ON S.suc_SucursalID= E.emp_SucursalID
                WHERE E.emp_Estatus = 1 
                ORDER BY E.emp_Nombre  ASC ";
        $empleados = $this->db->query($sql)->getResultArray();


        $arrEmpleados = array();
        $emp = array();
        $check = "";
        $count = 1;
        foreach ($empleados as $empleado) {

            $check = '<div class="checkbox checkbox-primary checkbox-single">
                                <input type="checkbox"
                                       value="' . $empleado['emp_EmpleadoID'] . '"
                                         id="empleados' . $count . '" >
                               <label></label>
                            </div>';

            $emp['emp_EmpleadoID'] = $empleado['emp_EmpleadoID'];
            $emp['emp_Nombre'] = $empleado['emp_Nombre'];
            $emp['emp_Numero'] = $empleado['emp_Numero'];
            $emp['pue_Nombre'] = $empleado['pue_Nombre'];
            $emp['are_Nombre'] = $empleado['are_Nombre'];
            $emp['suc_Sucursal'] = $empleado['suc_Sucursal'];
            $emp['check'] = $check;
            $count++;
            array_push($arrEmpleados, $emp);
        }


        $data['data'] = $arrEmpleados;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    //Lia->agrega participantes a la capacitacion
    public function ajaxAgregarParticipantesCap()
    {

        $post = $this->request->getPost();
        $empleados = json_decode($post['empleados']);
        $capacitacionID = $post['capacitacionID'];

        $builder = db()->table("capacitacionempleado");

        foreach ($empleados as $checkbox) {
            $agregado = $builder->getWhere(array('cape_EmpleadoID' =>
            $checkbox, 'cape_CapacitacionID' => $capacitacionID))->getRowArray();

            if ($agregado <= 0) {
                $data = array(
                    "cape_EmpleadoID" => $checkbox,
                    "cape_CapacitacionID" => $capacitacionID,
                );

                $builder->insert($data);
            }
        }

        echo json_encode(array('code' => 1));
    }

    //Lia->trae los participantes de la capacitacion
    public function ajax_getParticipantes($capacitacionID)
    {
        $sql = "SELECT E.emp_EmpleadoID, E.emp_Nombre, E.emp_Numero, P.pue_Nombre, A.are_Nombre,
                P.pue_PuestoID,C.cape_Calificacion,C.cape_CapacitacionID,C.cape_CapacitacionEmpleadoID,
                S.suc_Sucursal
                FROM capacitacionempleado C 
                LEFT JOIN empleado E ON E.emp_EmpleadoID=C.cape_EmpleadoID 
                LEFT JOIN puesto P ON P.pue_PuestoID =E.emp_PuestoID  
                LEFT JOIN area A ON A.are_AreaID = E.emp_AreaID
                LEFT JOIN sucursal S ON S.suc_SucursalID = E.emp_SucursalID
                WHERE E.emp_Estatus = 1 AND C.cape_CapacitacionID=?
                ORDER BY E.emp_Nombre  ASC ";
        $empleados = $this->db->query($sql, array($capacitacionID))->getResultArray();

        $data = array();
        foreach ($empleados as $empleado) {
            $encuesta = $this->db->query("SELECT * FROM encuestacapacitacion 
                                        WHERE ent_EmpleadoID=" . (int)$empleado['emp_EmpleadoID'] . " 
                                        AND ent_CapacitacionID=" . (int)$capacitacionID)->getRowArray();
            if ($encuesta) {
                $empleado['encuestaID'] = $encuesta['ent_EncuestaID'];
            } else {
                $empleado['encuestaID'] = 0;
            }
            $empleado['participante'] = encryptDecrypt('encrypt', $empleado['cape_CapacitacionEmpleadoID']);
            array_push($data, $empleado);
        }

        $data['data'] = $data;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    //Lia->Elimina un participante de la capacitacion
    public function ajaxRemoveParticipanteCapacitacion()
    {
        $participanteID = (int)post("participanteID");
        $builder = db()->table("capacitacionempleado");
        $response =  $builder->delete(array('cape_CapacitacionEmpleadoID' => $participanteID));

        $data['code'] = $response ? 1 : 0;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    //lia->Trae la informacion de un participante de la capacitacion
    public function ajaxInfoParticipante()
    {
        $participanteID = (int)post("participanteID");
        $sql = "SELECT C.* FROM capacitacionempleado C  WHERE C.cape_CapacitacionEmpleadoID=? ";
        $info = $this->db->query($sql, array($participanteID))->getRowArray();

        $data['info'] = $info;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    //Lia asigna la calificacion al participante
    public function ajaxAsignarCalificacionPartic()
    {

        $post = $this->request->getPost();
        $builder = db()->table("capacitacionempleado");
        $result = $builder->update(array('cape_Calificacion' => $post['cape_Calificacion']), array('cape_CapacitacionEmpleadoID' => (int)$post['cape_CapacitacionEmpleadoID']));

        $data['code'] = $result ? 1 : 0;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    public function ajaxSubirMaterialCapacitacion($capacitacionID)
    {
        $guardado = 0;
        if (isset($_FILES['fileMaterial'])) {

            //lugar donde se guarda el zip
            $directorio = FCPATH . "/assets/uploads/capacitacion/" . $capacitacionID . "/material/";

            if (!file_exists($directorio)) {
                mkdir($directorio, 0777, true);
            }
            $total_files = count($_FILES['fileMaterial']['name']);


            for ($key = 0; $key < $total_files; $key++) {
                $nombre_archivo = $_FILES['fileMaterial']['name'][$key];
                $rand = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5);
                $ruta = $directorio . $rand . eliminar_acentos(RemoveSpecialChar($nombre_archivo));
                move_uploaded_file($_FILES['fileMaterial']['tmp_name'][$key], $ruta);
                $guardado++;
            }
        }
        if ($guardado > 0) {
            echo json_encode(array("response" => 1));
        } else echo json_encode(array("response" => 0));
    }

    //Diego - borrar archivo
    public function ajax_borrarMaterial()
    {

        $post = $this->request->getPost();
        $capacitacionID = $post['$capacitacionID'];
        $archivo = $post['$archivo'];
        $url = FCPATH . "/assets/uploads/capacitacion/" . $capacitacionID . "/material/";

        if (file_exists($url . $archivo)) unlink($url . $archivo); //Si existe elimina

        echo json_encode(array("response" => "success"));
    } //end ajax_borrarMaterial

    //Lia->Trae los participantes para lista de asistencia
    public function ajax_getParticipantesLista($capacitacionID)
    {
        $sql = "SELECT E.emp_EmpleadoID, E.emp_Nombre, E.emp_Numero, 
                    C.cape_CapacitacionID,C.cape_CapacitacionEmpleadoID
                FROM capacitacionempleado C 
                LEFT JOIN empleado E ON E.emp_EmpleadoID=C.cape_EmpleadoID 
                WHERE E.emp_Estatus = 1 AND C.cape_CapacitacionID=?
                ORDER BY E.emp_Nombre  ASC ";
        $empleados = $this->db->query($sql, array($capacitacionID))->getResultArray();


        $arrEmpleados = array();
        $emp = array();

        $count = 1;
        foreach ($empleados as $empleado) {
            $check = '<div class="checkbox checkbox-primary checkbox-single">
                                <input type="checkbox"
                                       value="' . $empleado['emp_EmpleadoID'] . '"
                                         id="empleados' . $count . '" checked>
                               <label></label>
                            </div>';
            $emp['asi_EmpleadoID'] = $empleado['emp_EmpleadoID'];
            $emp['asi_Asistencia'] = 'asis_' . $count;
            $emp['emp_Numero'] = $empleado['emp_Numero'];
            $emp['emp_Nombre'] = $empleado['emp_Nombre'];
            $emp['check'] = $check;
            $count++;
            array_push($arrEmpleados, $emp);
        }


        $data['data'] = $arrEmpleados;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    //Lia->Guarda la Asistencia por modulo
    public function ajax_addAsistenciaCapacitacion()
    {
        $post = $this->request->getPost();

        $empleados = json_decode($post['empleados']);
        $capacitacionID = $post['capacitacionID'];
        $data['code'] = 0;

        $builder = db()->table("capacitacion");
        $builder->update(array('cap_Estado' => 'En curso'), array('cap_CapacitacionID' => $capacitacionID));

        $builder2 = db()->table("asistenciacapacitacion");
        $asistencia = $builder2->getWhere(array('asi_Fecha' => $post['fecha'], "asi_CapacitacionID" => $capacitacionID))->getResultArray();

        if (count($asistencia) <= 0) {
            foreach ($empleados as $checkbox) {
                $data = array(
                    'asi_CapacitacionID' => $capacitacionID,
                    'asi_EmpleadoID' => (int)$checkbox,
                    'asi_Fecha' => $post['fecha'],
                );
                $builder2->insert($data);
            }
            $data['code'] = 1;
        } else {
            $data['code'] = 2;
        }

        echo json_encode($data);
    }

    //Lis->Guarda la imagen de la convocatoria
    public function ajaxSubirConvocatoriaCapacitacion($capacitacionID)
    {
        $guardado = 0;
        if (isset($_FILES['fileConvocatoria'])) {

            //lugar donde se guarda
            $directorio = FCPATH . "/assets/uploads/capacitacion/" . $capacitacionID . "/convocatoria/";
            if (!file_exists($directorio)) {
                mkdir($directorio, 0777, true);
            }

            $nombre_archivo = $_FILES['fileConvocatoria']['name'];
            $ruta = $directorio . eliminar_acentos(RemoveSpecialChar($nombre_archivo));
            move_uploaded_file($_FILES['fileConvocatoria']['tmp_name'], $ruta);
            $guardado = 1;
        }
        if ($guardado > 0) {
            echo json_encode(array("response" => 1));
        } else echo json_encode(array("response" => 0));
    }

    //Lia->elimina el erchivo de la convocatoria
    public function ajax_borrarConvocatoria()
    {
        $post = $this->request->getPost();
        $capacitacionID = $post['$capacitacionID'];
        $archivo = $post['$archivo'];
        $url = FCPATH . "/assets/uploads/capacitacion/" . $capacitacionID . "/convocatoria/";
        if (file_exists($url . $archivo)) unlink($url . $archivo); //Si existe elimina

        echo json_encode(array("response" => "success"));
    }

    public function ajax_guardarEncuestaCapacitacion()
    {
        $id = $_POST['id'];
        // requires php5
        $url = FCPATH . "/assets/uploads/resultados/encuesta/";

        if (!file_exists($url)) {
            mkdir($url, 0777, true);
        }
        if (file_exists($url . "resultados" . $id . ".png")) unlink($url . "resultados" . $id . ".png");

        $img = $_POST['img'];
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $file = $url . "resultados" . $id . ".png";
        $success = file_put_contents($file, $data);
        //}
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    //HUGO -> inserta o actualiza una competencia
    function ajax_operacionesCompetencias()
    {
        $post = $this->request->getPost();

        $data = array('response' => 'error');

        $competenciaData = array(
            'com_Nombre' => $post['com_Nombre'],
            'com_Descripcion' => $post['com_Descripcion'],
            'com_Tipo' => $post['com_Tipo'],
        );
        $builder = $this->db->table('competencia');
        if (empty($post['competenciaID'])) {
            //Inserta
            $builder->insert($competenciaData);
            $result = $this->db->insertID();
        } else {
            //Actualiza
            $result = $builder->update($competenciaData, array('com_CompetenciaID' => (int)$post['competenciaID']));
        }

        if ($result) {
            $data['response'] = 'success';
            $data['msg'] = 'Datos guardados correctamente';
        } else {
            $data['msg'] = 'Ocurrio un error. Intentelo nuevamente';
        }

        echo json_encode($data);
    } //end ajax_operacionesCompetencias

    //HUGO -> Obtiene la informacion de una competencia
    function ajax_getCompetenciaInfo()
    {
        $competenciaID = (int)post('competenciaID');
        $data = array('response' => 'error');
        $sql = "SELECT * FROM competencia WHERE com_CompetenciaID=?";
        $competenciaInfo = $this->db->query($sql, array($competenciaID))->getRowArray();
        if (!is_null($competenciaInfo)) {
            $data['response'] = 'success';
            $data['info'] = $competenciaInfo;
        }
        echo json_encode($data);
    } //end ajax_getCompetenciaInfo

    //Diego->Agregar accion clave a competencia
    public function ajax_addAClaveCompetencia()
    {
        $post = $this->request->getPost();

        $data = array(
            "cla_CompetenciaID" => $post['competenciaID'],
            "cla_ClaveAccion" => $post['clave'],
            "cla_NoOrden" => $post['orden'],
            "cla_EmpleadoID" => session('id'),
        );

        $builder = $this->db->table('clavecompetencia');
        $builder->insert($data);
        $id = $this->db->insertID();
        insertLog($this, session('id'), 'Insertar', 'clavecompetencia', $id);
        echo json_encode(array("response" => "success", "id" => $id));
    } //end ajax_addAClaveCompetencia

    //Diego->Regresar acciones clave Competencia
    public function ajax_regresarAccionesClaveCompetencia()
    {
        $post = $this->request->getPost();
        $sql = "SELECT * FROM clavecompetencia WHERE cla_CompetenciaID= ? ORDER BY cla_NoOrden";
        $com = $this->db->query($sql, array((int)$post['competenciaID']))->getResultArray();
        echo json_encode(array("response" => "success", "acciones" => $com));
    } //end ajax_regresarAccionesClaveCompetencia

    //Diego->borrar accion clave de competencia
    public function ajax_borrarAccionClaveCompetencia()
    {
        $post = $this->request->getPost();
        $builder = $this->db->table('clavecompetencia');
        $builder->delete(array("cla_ClaveCompetenciaID" => $post['claveID']));
        insertLog($this, session('id'), 'Eliminar', 'clavecompetencia', $post['claveID']);
        echo json_encode(array("response" => "success"));
    } //end ajax_borrarAccionClaveCompetencia
}
