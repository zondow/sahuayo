<?php

namespace App\Controllers;

defined('FCPATH') or exit('No direct script access allowed');

use App\Models\IncidenciasModel;
use App\Models\UsuarioModel;
use Anticipos;
use DateTime;

class Incidencias extends BaseController
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
    //Diego->Incapacidades de los empleados
    public function misIncapacidades()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Incapacidades';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Incapacidades', "link" => base_url('Incidencias/incapacidad'), "class" => "active"),
        );
        //Data
        $model = new IncidenciasModel();
        $data['incapacidades'] = revisarPermisos('Autorizar', 'incapacidad') ? $model->getIncapacidades() : $model->getIncapacidadesByEmpleado();

        //sweetalert2
        $data['styles'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.css');
        $data['scripts'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.js');

        //Styles
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');
        $data['styles'][] = base_url('assets/libs/bootstrap-select/bootstrap-select.min.css');
        $data['styles'][] = base_url('assets/libs/select2/css/select2.min.css');
        $data['styles'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css');
        $data['styles'][] = base_url('assets/libs/bootstrap-daterangepicker/daterangepicker.css');
        $data['styles'][] = base_url('assets/libs/lightbox/css/lightbox.css');
        $data['styles'][] = base_url('assets/libs/custombox/custombox.min.css');

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
        $data['scripts'][] = base_url('assets/libs/bootstrap-select/bootstrap-select.min.js');
        $data['scripts'][] = base_url('assets/libs/select2/js/select2.full.min.js');
        $data['scripts'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js');
        $data['scripts'][] = base_url('assets/libs/bootstrap-daterangepicker/daterangepicker.js');
        $data['scripts'][] = base_url("assets/js/pages/bootstrap-filestyle.min.js");
        $data['scripts'][] = base_url('assets/libs/lightbox/js/lightbox.js');
        $data['scripts'][] = base_url('assets/libs/custombox/custombox.min.js');
        $data['scripts'][] = base_url("assets/js/modalPdf.js");
        $data['scripts'][] = base_url("assets/js/modalRechazoJustificacion.js");
        $data['scripts'][] = base_url("assets/js/incidencias/incapacidades.js");

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('incidencias/incapacidades');
        echo view('htdocs/modalPdf');
        echo view('htdocs/modalRechazoJustificacion');
        echo view('htdocs/footer');
    } //end incapacidad

    //Lia->informe de horas extra a aplicar
    public function incapacidad()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Revisar solicitudes de incapacidad';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "");
        $data['breadcrumb'][] = array("titulo" => 'Revisar solicitudes de incapacidad', "link" => base_url('Incidencias/revisarIncapacidades'), "class" => "active");

        //Custom Scripts
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');
        $data['styles'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.css");

        //Custom Scripts
        $data['scripts'][] = base_url('assets/plugins/datatables/jquery.dataTables.min.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/js/dataTables.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/dataTables.buttons.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/JSZip-2.5.0/jszip.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/pdfmake.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/vfs_fonts.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.html5.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.colVis.js');
        $data['scripts'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.min.js");
        $data['scripts'][] = base_url("assets/js/modalPdf.js");

        $data['scripts'][] = base_url("assets/js/incidencias/revisarIncapacidades.js");

        //Vistas
        echo view('htdocs/header', $data);
        echo view('incidencias/revisarIncapacidades', $data);
        echo view('htdocs/modalPdf');
        echo view('htdocs/footer', $data);
    } //end aplicarReporteHoras

    //Lia->Actas administrativas
    public function sanciones()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Sanciones';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Sanciones', "link" => base_url('Incidencias/sanciones'), "class" => "active"),
        );

        //Data
        $model = new IncidenciasModel();
        $data['empleados'] = $model->getEmpleados();
        $data['actas'] = $model->getActasAdministrativas();

        //sweetalert2
        $data['styles'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.css');
        $data['scripts'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.js');

        //Styles
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');
        $data['styles'][] = base_url('assets/libs/bootstrap-select/bootstrap-select.min.css');
        $data['styles'][] = base_url('assets/libs/select2/css/select2.min.css');
        $data['styles'][] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/css/fileinput.css"; //Bootstrap FileInput
        $data['styles'][] = base_url('assets/libs/custombox/custombox.min.css');
        $data['styles'][] = base_url('assets/libs/lightbox/css/lightbox.css');
        $data['styles'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css');

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
        $data['scripts'][] = base_url('assets/libs/bootstrap-select/bootstrap-select.min.js');
        $data['scripts'][] = base_url('assets/libs/select2/js/select2.full.min.js');
        $data['scripts'][] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/fileinput.js"; //Bootstrap FileInput
        $data['scripts'][] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/locales/es.js"; //Bootstrap FileInput Spanish
        $data['scripts'][] = base_url('assets/libs/custombox/custombox.min.js');
        $data['scripts'][] = base_url('assets/libs/lightbox/js/lightbox.js');
        $data['scripts'][] = base_url("assets/js/modalPdf.js");
        $data['scripts'][] = base_url("assets/js/incidencias/sanciones.js");

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('incidencias/actasAdministrativas');
        echo view('htdocs/modalPdf');
        echo view('htdocs/footer');
    } //end actasAdministrativas

    //Lia->Actas administrativas
    public function misSanciones()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Mis Sanciones';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Sanciones', "link" => base_url('Incidencias/misSanciones'), "class" => "active"),
        );

        //Data
        $model = new IncidenciasModel();
        $data['empleados'] = $model->getEmpleados();
        $data['actas'] = $model->getActasAdministrativasByColaborador();

        //sweetalert2
        $data['styles'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.css');
        $data['scripts'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.js');

        //Styles
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');
        $data['styles'][] = base_url('assets/libs/bootstrap-select/bootstrap-select.min.css');
        $data['styles'][] = base_url('assets/libs/select2/css/select2.min.css');
        $data['styles'][] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/css/fileinput.css"; //Bootstrap FileInput
        $data['styles'][] = base_url('assets/libs/custombox/custombox.min.css');
        $data['styles'][] = base_url('assets/libs/lightbox/css/lightbox.css');
        $data['styles'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css');

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
        $data['scripts'][] = base_url('assets/libs/bootstrap-select/bootstrap-select.min.js');
        $data['scripts'][] = base_url('assets/libs/select2/js/select2.full.min.js');
        $data['scripts'][] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/fileinput.js"; //Bootstrap FileInput
        $data['scripts'][] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/locales/es.js"; //Bootstrap FileInput Spanish
        $data['scripts'][] = base_url('assets/libs/custombox/custombox.min.js');
        $data['scripts'][] = base_url('assets/libs/lightbox/js/lightbox.js');
        $data['scripts'][] = base_url("assets/js/modalPdf.js");
        $data['scripts'][] = base_url("assets/js/incidencias/sanciones.js");

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('incidencias/misSanciones');
        echo view('htdocs/modalPdf');
        echo view('htdocs/footer');
    } //end actasAdministrativas

    //Lia->sanciones mis colaboradores
    public function sancionesMisEmpleados()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Revisar sanciones';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "");
        $data['breadcrumb'][] = array("titulo" => 'Revisar sanciones', "link" => base_url('Incidencias/sancionesMisEmpleados'), "class" => "active");

        //Data
        $model = new IncidenciasModel();
        $data['empleados'] = $model->getEmpleados();
        $data['actas'] = $model->getActasAdministrativasMisColaboradores();

        //sweetalert2
        $data['styles'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.css');
        $data['scripts'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.js');

        //Styles
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');
        $data['styles'][] = base_url('assets/libs/bootstrap-select/bootstrap-select.min.css');
        $data['styles'][] = base_url('assets/libs/select2/css/select2.min.css');
        $data['styles'][] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/css/fileinput.css"; //Bootstrap FileInput
        $data['styles'][] = base_url('assets/libs/custombox/custombox.min.css');
        $data['styles'][] = base_url('assets/libs/lightbox/css/lightbox.css');
        $data['styles'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css');

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
        $data['scripts'][] = base_url('assets/libs/bootstrap-select/bootstrap-select.min.js');
        $data['scripts'][] = base_url('assets/libs/select2/js/select2.full.min.js');
        $data['scripts'][] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/fileinput.js"; //Bootstrap FileInput
        $data['scripts'][] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/locales/es.js"; //Bootstrap FileInput Spanish
        $data['scripts'][] = base_url('assets/libs/custombox/custombox.min.js');
        $data['scripts'][] = base_url('assets/libs/lightbox/js/lightbox.js');
        $data['scripts'][] = base_url("assets/js/modalPdf.js");
        $data['scripts'][] = base_url("assets/js/incidencias/sancionesMisEmpleados.js");

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('incidencias/sancionesMisEmpleados', $data);
        echo view('htdocs/modalPdf');
        echo view('htdocs/footer', $data);
    }

    public function incapacidadesMisEmpleados()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Ver incapacidades de colaboradores';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "");
        $data['breadcrumb'][] = array("titulo" => 'Revisar sanciones', "link" => base_url('Incidencias/incapacidadesMisEmpleados'), "class" => "active");

        //Data
        $model = new IncidenciasModel();
        $data['empleados'] = $model->getEmpleados();
        $data['incapacidades'] = $model->getIncapacidadesMisColaboradores();

        //sweetalert2
        $data['styles'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.css');
        $data['scripts'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.js');

        //Styles
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');
        $data['styles'][] = base_url('assets/libs/bootstrap-select/bootstrap-select.min.css');
        $data['styles'][] = base_url('assets/libs/select2/css/select2.min.css');
        $data['styles'][] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/css/fileinput.css"; //Bootstrap FileInput
        $data['styles'][] = base_url('assets/libs/custombox/custombox.min.css');
        $data['styles'][] = base_url('assets/libs/lightbox/css/lightbox.css');
        $data['styles'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css');

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
        $data['scripts'][] = base_url('assets/libs/bootstrap-select/bootstrap-select.min.js');
        $data['scripts'][] = base_url('assets/libs/select2/js/select2.full.min.js');
        $data['scripts'][] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/fileinput.js"; //Bootstrap FileInput
        $data['scripts'][] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/locales/es.js"; //Bootstrap FileInput Spanish
        $data['scripts'][] = base_url('assets/libs/custombox/custombox.min.js');
        $data['scripts'][] = base_url('assets/libs/lightbox/js/lightbox.js');
        $data['scripts'][] = base_url("assets/js/modalPdf.js");
        $data['scripts'][] = base_url("assets/js/incidencias/incapacidadesMisEmpleados.js");

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('incidencias/incapacidadesMisEmpleados', $data);
        echo view('htdocs/modalPdf');
        echo view('htdocs/footer', $data);
    }

    //Lia->vista de mis vacaciones
    public function misVacaciones()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Mis vacaciones';
        //Breadcrumbs
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Mis vacaciones', "link" => base_url('Incidencias/misVacaciones'), "class" => "active"),
        );

        //Data
        $idEmpleado = encryptDecrypt('encrypt', session('id'));
        $data['idEmpleado'] = $idEmpleado;
        $model = new IncidenciasModel();
        $empleado = $model->getInfoEmpleado($idEmpleado);

        $data['empleado'] = $empleado;
        $data['diasLey'] = diasLey($empleado['emp_FechaIngreso'], $this);
        $data['diasPendientes'] = diasPendientes(session('id'));

        $builder = db()->table("vacacion");
        $data['registros'] = $builder->getWhere(array("vac_EmpleadoID" => session('id'), "vac_Estado" => 1))->getResultArray();

        //Datepicker
        $data['styles'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css');
        $data['styles'][] = base_url('assets/libs/bootstrap-daterangepicker/daterangepicker.css');
        $data['scripts'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js');
        $data['scripts'][] = base_url('assets/libs/bootstrap-daterangepicker/daterangepicker.js');
        $data['styles'][] = base_url('assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.css');

        //Data Tables
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');
        $data['scripts'][] = base_url('assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/jquery.dataTables.min.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/js/dataTables.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/dataTables.buttons.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/JSZip-2.5.0/jszip.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/pdfmake.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/vfs_fonts.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.html5.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.colVis.js');

        //Sweet alert
        $data['styles'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.css");
        $data['scripts'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.min.js");

        //Custom
        $data['scripts'][] = base_url('assets/js/modalPdf.js');
        $data['scripts'][] = base_url('assets/js/incidencias/misVacaciones.js');

        echo view("htdocs/header", $data);
        echo view("incidencias/formVacaciones");
        echo view('htdocs/modalPdf');
        echo view("htdocs/footer");
    } //end misVacaciones

    //Diego->vista cambiar dias de vacacion por horas
    public function cambioVacacionesHoras()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Cambio de Vacaciones por Horas';
        //Breadcrumbs
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Cambio de Vacaciones por Horas', "link" => base_url('Incidencias/cambioVacacionesHoras'), "class" => "active"),
        );

        //Data
        $idEmpleado = encryptDecrypt('encrypt', session('id'));
        $data['idEmpleado'] = $idEmpleado;
        $model = new IncidenciasModel();
        $empleado = $model->getInfoEmpleado($idEmpleado);
        $data['empleado'] = $empleado;
        $data['diasLey'] = diasLey($empleado['emp_FechaIngreso'], $this);
        $data['diasPendientes'] = diasPendientes(session('id'));
        $data['registros'] = db()->table("vacacionhoras")->getWhere(array("vach_EmpleadoID" => session('id'), "vach_Estado" => 1))->getResultArray();
        $data['horasExtra'] = $model->getHorasExtra();

        //Datepicker
        $data['styles'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css');
        $data['styles'][] = base_url('assets/libs/bootstrap-daterangepicker/daterangepicker.css');
        $data['scripts'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js');
        $data['scripts'][] = base_url('assets/libs/bootstrap-daterangepicker/daterangepicker.js');
        $data['styles'][] = base_url('assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.css');

        //Data Tables
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');
        $data['scripts'][] = base_url('assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/jquery.dataTables.min.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/js/dataTables.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/dataTables.buttons.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/JSZip-2.5.0/jszip.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/pdfmake.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/vfs_fonts.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.html5.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.colVis.js');

        //Sweet alert
        $data['styles'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.css");
        $data['scripts'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.min.js");

        //Custom
        $data['scripts'][] = base_url('assets/js/modalPdf.js');
        $data['scripts'][] = base_url('assets/js/incidencias/misHorasVacaciones.js');

        echo view("htdocs/header", $data);
        echo view("incidencias/formVacacionesHoras");
        echo view('htdocs/modalPdf');
        echo view("htdocs/footer");
    } //end cambioVacacionesHoras

    //Lia -> Lista de solicitues de vacaciones de sus empleados
    public function vacacionesMisEmpleados()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Autorizar vacaciones';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Autorizar vacaciones', "link" => base_url('Incidencias/vacacionesMisEmpleados'), "class" => "active"),
        );
        $model = new IncidenciasModel();
        $data['listVacaciones'] = $model->getVacacionesEmpleadosJefe(session('numero'));

        //Custom Styles
        $data['styles'][] = base_url('assets/plugins/fullcalendar/fullcalendar.min.css');
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');
        $data['styles'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.css");

        //Custom Scripts
        $data['scripts'][] = base_url('assets/plugins/datatables/jquery.dataTables.min.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/js/dataTables.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/dataTables.buttons.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/JSZip-2.5.0/jszip.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/pdfmake.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/vfs_fonts.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.html5.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.colVis.js');
        $data['scripts'][] = base_url('assets/plugins/moment/min/moment.min.js');
        $data['scripts'][] = base_url('assets/plugins/fullcalendar/fullcalendar.min.js');
        $data['scripts'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.min.js");

        //Funciones
        $data['scripts'][] = base_url("assets/js/modalPdf.js");
        $data['scripts'][] = base_url('assets/js/incidencias/misEmpleadosVacaciones.js');
        $data['scripts'][] = base_url('assets/js/calendarioVacacionesJefe.js');

        //Vistas
        echo view('htdocs/header', $data);
        echo view("incidencias/misEmpleadosVacaciones");
        echo view('htdocs/modalPdf', $data);
        echo view('htdocs/footer', $data);
    } //end vacacionesMisEmpleados

    //Lia -> Obtiene el listado de las vacaciones para aplicar o autorizar
    public function listVacaciones($type)
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        //Titulo
        $data['title'] = 'Aplicar vacaciones';
        //Breadcrumbs
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Aplicar vacaciones', "link" => base_url('Incidencias/listVacaciones/aplicar'), "class" => "active"),
        );

        $estatus = array("AUTORIZADO",  "AUTORIZADO_RH", "DECLINADO", "RECHAZADO");
        $model = new IncidenciasModel();
        $data['listVacaciones'] = $model->getListVacaciones($estatus);
        $data['type'] = $type;

        //sweetalert2
        $data['styles'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.css");
        $data['scripts'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.min.js");

        //Data Tables
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

        //Custom
        $data['scripts'][] = base_url('assets/js/modalPdf.js');
        $data['scripts'][] = base_url('assets/js/incidencias/listVacaciones.js');

        echo view("htdocs/header", $data);
        echo view("incidencias/listVacaciones");
        echo view('htdocs/modalPdf');
        echo view("htdocs/footer");
    } //end listVacaciones

    //Diego -> Obtiene el listado de las solicitude de horas vacaciones para aplicar o autorizar
    public function aplicarCambioHorasVac()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        //Titulo
        $data['title'] = 'Aplicar solicitud horas-vacaciones';
        //Breadcrumbs
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Aplicar solicitud', "link" => base_url('Incidencias/aplicarCambioHorasVac'), "class" => "active"),
        );

        $model = new IncidenciasModel();
        $data['listVacaciones'] = $model->getListVacacionesHoras();

        //sweetalert2
        $data['styles'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.css");
        $data['scripts'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.min.js");

        //Data Tables
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

        //Custom
        $data['scripts'][] = base_url('assets/js/modalPdf.js');
        $data['scripts'][] = base_url('assets/js/incidencias/listVacacionesHoras.js');

        echo view("htdocs/header", $data);
        echo view("incidencias/listVacacionesHoras");
        echo view('htdocs/modalPdf');
        echo view("htdocs/footer");
    } //end listVacaciones

    //Lia ->El empleado solicita sus permisos
    public function misPermisos()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Mis permisos';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "");
        $data['breadcrumb'][] = array("titulo" => 'Mis permisos', "link" => base_url('Permiso/misPermisos'), "class" => "active");

        $empleadoID = encryptDecrypt('encrypt', session('id'));
        $model = new IncidenciasModel();
        $data['empleado'] = $model->getInfoEmpleado($empleadoID);
        $data['catalogoPermisos'] = $model->getCatalogoPermisos();
        $data['horasExtra'] = getHorasExtraByEmpleado(session('id'));

        //Custom Styles
        $data['styles'][] = base_url('assets/libs/custombox/custombox.min.css');
        $data['styles'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css');
        $data['styles'][] = base_url("assets/libs/select2/select2.min.css");
        $data['styles'][] = base_url('assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.css');
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');
        $data['styles'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.css");

        //Custom Scripts
        $data['scripts'][] = base_url('assets/libs/custombox/custombox.min.js');
        $data['scripts'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js');
        $data['scripts'][] = base_url("assets/libs/select2/select2.min.js");
        $data['scripts'][] = base_url('assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/jquery.dataTables.min.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/js/dataTables.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/dataTables.buttons.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/JSZip-2.5.0/jszip.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/pdfmake.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/vfs_fonts.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.html5.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.colVis.js');
        $data['scripts'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.min.js");

        $data['scripts'][] = base_url("assets/js/incidencias/permisos.js");
        $data['scripts'][] = base_url("assets/js/modalPdf.js");

        //Vistas
        echo view('htdocs/header', $data);
        echo view('incidencias/formPermiso', $data);
        echo view('htdocs/modalPdf', $data);
        echo view('htdocs/footer', $data);
    } //misPermisos

    //HUGO-> Lista de solicitues de permisos de sus empleados
    public function permisosMisEmpleados()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Autorizar permisos';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "");
        $data['breadcrumb'][] = array("titulo" => 'Autorizar permisos', "link" => base_url('Permiso/permisosMisEmpleados'), "class" => "active");

        //Custom Styles
        $data['styles'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css');
        $data['styles'][] = base_url("assets/libs/select2/select2.min.css");
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');
        $data['styles'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.css");

        //Custom Scripts
        $data['scripts'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js');
        $data['scripts'][] = base_url("assets/libs/select2/select2.min.js");
        $data['scripts'][] = base_url('assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/jquery.dataTables.min.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/js/dataTables.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/dataTables.buttons.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/JSZip-2.5.0/jszip.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/pdfmake.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/vfs_fonts.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.html5.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.colVis.js');
        $data['scripts'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.min.js");
        $data['scripts'][] = base_url("assets/js/modalPdf.js");

        $data['scripts'][] = base_url("assets/js/incidencias/autorizarPermisos.js");

        //Vistas
        echo view('htdocs/header', $data);
        echo view('incidencias/autorizarPermisos', $data);
        echo view('htdocs/modalPdf', $data);
        echo view('incidencias/modalesPermiso', $data);
        echo view('htdocs/footer', $data);
    } //end permisosMisEmpleados

    //HUGO-> Generar Permisos
    public function aplicarPermisos()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Aplicar permisos';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "");
        $data['breadcrumb'][] = array("titulo" => 'Aplicar permisos', "link" => base_url('Permiso/aplicarPermisos'), "class" => "active");

        //Custom Styles
        $data['styles'][] = base_url('assets/libs/custombox/custombox.min.css');
        $data['styles'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css');
        $data['styles'][] = base_url("assets/libs/select2/select2.min.css");
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');
        $data['styles'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.css");

        //Custom Scripts
        $data['scripts'][] = base_url('assets/plugins/datatables/jquery.dataTables.min.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/js/dataTables.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/dataTables.buttons.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/JSZip-2.5.0/jszip.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/pdfmake.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/vfs_fonts.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.html5.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.colVis.js');
        $data['scripts'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.min.js");
        $data['scripts'][] = base_url("assets/js/modalPdf.js");
        $data['scripts'][] = base_url("assets/js/aplicarPermisos.js");

        //Vistas
        echo view('htdocs/header', $data);
        echo view('incidencias/aplicarPermisos', $data);
        echo view('htdocs/modalPdf', $data);
        echo view('htdocs/modalConfirmation', $data);
        echo view('htdocs/footer', $data);
    } //aplicarPermisos

    //Diego ->El empleado registra sus horas extra
    public function controlHorasExtra()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Control de horas extra';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "");
        $data['breadcrumb'][] = array("titulo" => 'Control de horas extra', "link" => base_url('Incidencias/controlHorasExtra'), "class" => "active");

        $model = new IncidenciasModel();
        $data['empleado'] = $model->getInfoEmpleado(encryptDecrypt('encrypt', session('id')));

        //Custom Styles

        $data['styles'][] = base_url("assets/libs/select2/select2.min.css");
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');
        $data['styles'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.css");
        $data['styles'][] = base_url('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css');
        $data['styles'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css');

        //Custom Scripts
        $data['scripts'][] = base_url('assets/plugins/moment/min/moment.min.js');
        $data['scripts'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js');
        $data['scripts'][] = base_url("assets/libs/select2/select2.min.js");
        $data['scripts'][] = base_url('assets/plugins/datatables/jquery.dataTables.min.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/js/dataTables.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/dataTables.buttons.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/JSZip-2.5.0/jszip.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/pdfmake.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/vfs_fonts.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.html5.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.colVis.js');
        $data['scripts'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.min.js");
        $data['scripts'][] = base_url('assets/plugins/momentjs/moment-with-locales.js');
        $data['scripts'][] = base_url('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js');


        $data['scripts'][] = base_url("assets/js/incidencias/controlHorasExtra.js");
        $data['scripts'][] = base_url("assets/js/modalPdf.js");

        //Vistas
        echo view('htdocs/header', $data);
        echo view('incidencias/formCHorasExtra', $data);
        echo view('htdocs/modalPdf', $data);
        echo view('htdocs/footer', $data);
    } //end controlHorasExtra

    //Lia->informe de horas extra de los empleados a cargo
    public function horasExtraMisEmpleados()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Revisar reporte de horas extra';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "");
        $data['breadcrumb'][] = array("titulo" => 'Revisar reporte de horas extra', "link" => base_url('Incidencias/horasExtraMisEmpleados'), "class" => "active");

        //Custom Scripts
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');
        $data['styles'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.css");

        //Custom Scripts
        $data['scripts'][] = base_url('assets/plugins/datatables/jquery.dataTables.min.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/js/dataTables.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/dataTables.buttons.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/JSZip-2.5.0/jszip.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/pdfmake.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/vfs_fonts.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.html5.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.colVis.js');
        $data['scripts'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.min.js");
        $data['scripts'][] = base_url("assets/js/modalPdf.js");

        $data['scripts'][] = base_url("assets/js/incidencias/reporteHorasMisEmpleados.js");

        //Vistas
        echo view('htdocs/header', $data);
        echo view('incidencias/reporteHorasMisEmpleados', $data);
        echo view('htdocs/modalPdf');
        echo view('htdocs/footer', $data);
    } //end horasExtraMisEmpleados

    //Lia->informe de horas extra a aplicar
    public function aplicarReporteHoras()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Aplicar reporte de horas extra';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "");
        $data['breadcrumb'][] = array("titulo" => 'Aplicar reporte de horas extra', "link" => base_url('Incidencias/aplicarReporteHoras'), "class" => "active");

        //Custom Scripts
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');
        $data['styles'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.css");

        //Custom Scripts
        $data['scripts'][] = base_url('assets/plugins/datatables/jquery.dataTables.min.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/js/dataTables.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/dataTables.buttons.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/JSZip-2.5.0/jszip.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/pdfmake.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/vfs_fonts.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.html5.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.colVis.js');
        $data['scripts'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.min.js");
        $data['scripts'][] = base_url("assets/js/modalPdf.js");

        $data['scripts'][] = base_url("assets/js/incidencias/aplicarReporteHoras.js");

        //Vistas
        echo view('htdocs/header', $data);
        echo view('incidencias/aplicarReporteHoras', $data);
        echo view('htdocs/modalPdf');
        echo view('htdocs/footer', $data);
    } //end aplicarReporteHoras

    //Lia->mi informe de salidas
    public function reporteSalidas()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Mis salidas';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "");
        $data['breadcrumb'][] = array("titulo" => 'Mis salidas', "link" => base_url('Incidencias/reporteSalidas'), "class" => "active");

        $model = new IncidenciasModel();
        $data['sucursales'] = $model->getSucursal();

        //Custom Scripts
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');
        $data['styles'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css');
        $data['styles'][] = base_url("assets/libs/select2/select2.min.css");
        $data['styles'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.css");
        $data['styles'][] = base_url('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css');

        //Custom Scripts
        $data['scripts'][] = base_url('assets/plugins/moment/min/moment.min.js');
        $data['scripts'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js');
        $data['scripts'][] = base_url("assets/libs/select2/select2.min.js");
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
        $data['scripts'][] = base_url('assets/plugins/momentjs/moment-with-locales.js');
        $data['scripts'][] = base_url('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js');
        $data['scripts'][] = base_url("assets/js/modalPdf.js");
        $data['scripts'][] = base_url("assets/js/incidencias/informeMisSalidas.js");

        //Vistas
        echo view('htdocs/header', $data);
        echo view('incidencias/miInformeSalidas', $data);
        echo view('htdocs/modalPdf');
        echo view('htdocs/footer', $data);
    } //end reporteSalidas

    //Lia->informe de salidas de los empleados
    public function informeSalidasMisEmpleados()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Revisar informes de salida';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "");
        $data['breadcrumb'][] = array("titulo" => 'Revisar informes de salida', "link" => base_url('Incidencias/informeSalidasMisEmpleados'), "class" => "active");

        //Custom Scripts
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');
        $data['styles'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.css");

        //Custom Scripts
        $data['scripts'][] = base_url('assets/plugins/datatables/jquery.dataTables.min.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/js/dataTables.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/dataTables.buttons.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/JSZip-2.5.0/jszip.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/pdfmake.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/vfs_fonts.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.html5.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.colVis.js');
        $data['scripts'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.min.js");
        $data['scripts'][] = base_url("assets/js/modalPdf.js");

        $data['scripts'][] = base_url("assets/js/incidencias/informeSalidasMisEmpleados.js");

        //Vistas
        echo view('htdocs/header', $data);
        echo view('incidencias/informeSalidasMisEmpleados', $data);
        echo view('htdocs/modalPdf');
        echo view('htdocs/footer', $data);
    } //end informeSalidasMisEmpleados

    //Lia->aplicar informe de salidas
    public function aplicarInformeSalidas()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Aplicar informes de salida';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "");
        $data['breadcrumb'][] = array("titulo" => 'Aplicar informes de salida', "link" => base_url('Incidencias/aplicarInformeSalidas'), "class" => "active");

        //Custom Scripts
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');
        $data['styles'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.css");

        //Custom Scripts
        $data['scripts'][] = base_url('assets/plugins/datatables/jquery.dataTables.min.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/js/dataTables.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/dataTables.buttons.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/JSZip-2.5.0/jszip.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/pdfmake.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/vfs_fonts.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.html5.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.colVis.js');
        $data['scripts'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.min.js");
        $data['scripts'][] = base_url("assets/js/modalPdf.js");

        $data['scripts'][] = base_url("assets/js/incidencias/aplicarInformeSalidas.js");

        //Vistas
        echo view('htdocs/header', $data);
        echo view('incidencias/aplicarInformesSalidas', $data);
        echo view('htdocs/modalPdf');
        echo view('htdocs/footer', $data);
    } //end aplicarInformeSalidas

    //Lia->Reporte de conteo de horas y dias de vacaciones
    public function reporteHorasVacacionesEmpleados()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Vacaciones y Horas extra';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "");
        $data['breadcrumb'][] = array("titulo" => 'Reporte de vacaciones y horas extra', "link" => base_url('Incidencias/reporteHorasVacacionesEmpleados'), "class" => "active");

        //sweetalert2
        $data['styles'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.css");
        $data['scripts'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.min.js");

        //Styles
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');
        $data['styles'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css');

        //Scripts
        $data['scripts'][] = base_url('assets/plugins/datatables/jquery.dataTables.min.js');
        $data['scripts'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/js/dataTables.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/dataTables.buttons.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/JSZip-2.5.0/jszip.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/pdfmake.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/pdfmake-0.1.36/vfs_fonts.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.html5.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/js/buttons.colVis.js');

        $data['scripts'][] = base_url('assets/js/incidencias/reporteVacacionesHoras.js');

        //Vistas
        echo view('htdocs/header', $data);
        echo view('incidencias/reportevacacioneshoras', $data);
        echo view('htdocs/footer', $data);
    } //end reporteHorasVacacionesEmpleados


    //Lia->reporte de asistencias
    public function reporteAsistencia()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Reporte de asistencia';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "");
        $data['breadcrumb'][] = array("titulo" => 'Reporte de asistencia', "link" => base_url('Incidencias/reporteAsistencia'), "class" => "active");

        //Custom Scripts
        $data['styles'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css');
        $data['styles'][] = base_url('assets/libs/bootstrap-daterangepicker/daterangepicker.css');
        $data['scripts'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js');
        $data['scripts'][] = base_url('assets/libs/bootstrap-daterangepicker/daterangepicker.js');

        $data['styles'][] = base_url("assets/plugins/jstree/css/style.min.css");
        $data['scripts'][] = base_url("assets/plugins/jstree/jstree.min.js");

        $data['scripts'][] = base_url("assets/js/incidencias/reporteAsistencia.js");

        //Vistas
        echo view('htdocs/header.php', $data);
        echo view('incidencias/formReporteAsistencia', $data);
        echo view('htdocs/footer.php', $data);
    }

    public function reportePeriodo()
    {
         //Validar sessión
         validarSesion(self::LOGIN_TYPE);
         $data['title'] = 'Reporte de vacaciones por periodo';
         $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "");
         $data['breadcrumb'][] = array("titulo" => 'Vacaciones por periodo', "link" => base_url('Incidencias/reportePeriodo'), "class" => "active");

         //sweetalert2
         $data['styles'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.css");
         $data['scripts'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.min.js");

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

         $data['scripts'][] = base_url('assets/js/incidencias/reporteVacacionesPeriodo.js');

         //Vistas
         echo view('htdocs/header.php', $data);
         echo view('incidencias/reporteVacacionesPeriodo', $data);
         echo view('htdocs/footer.php', $data);
    }
    /*
      ______ _    _ _   _  _____ _____ ____  _   _ ______  _____
     |  ____| |  | | \ | |/ ____|_   _/ __ \| \ | |  ____|/ ____|
     | |__  | |  | |  \| | |      | || |  | |  \| | |__  | (___
     |  __| | |  | | . ` | |      | || |  | | . ` |  __|  \___ \
     | |    | |__| | |\  | |____ _| || |__| | |\  | |____ ____) |
     |_|     \____/|_| \_|\_____|_____\____/|_| \_|______|_____/
    */
    //Diego->Agregar una incapacidad
    public function addIncapacidad()
    {
        $post = $this->request->getPost();
        //$fechaFin = date('Y-m-d', strtotime($post['fechaInicio'] . '+' . $post['diasIncapacidad'] . ' days'));
        $fechaFin = date('Y-m-d', strtotime($post['fechaInicio'] . '+' . ($post['diasIncapacidad'] - 1) . ' days'));

        $data_incapacidad = array(
            "inc_FechaRegistro" => date("Y-m-d"),
            "inc_EmpleadoID" => session('id'),
            "inc_FechaInicio" => $post['fechaInicio'],
            "inc_FechaFin" => $fechaFin,
            "inc_Motivos" => $post['motivos'],
            "inc_Folio" => $post['folio'],
            "inc_Dias" => $post['diasIncapacidad'],
            "inc_Tipo" => $post['tipoEnfermedad'],
        );

        //archvio de incapacidad
        if (isset($_FILES['archivo'])) {
            $directorio = FCPATH . "/assets/uploads/incapacidades/" . session('id') . "/";

            if (!file_exists($directorio)) {
                mkdir($directorio, 0777, true);
            }

            $nombre_archivo = $_FILES['archivo']['name'];
            $random = date("Ymd");
            $ruta = $directorio . $random . $nombre_archivo;

            if (move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta)) {
                $data_incapacidad['inc_Archivo'] = $random . $nombre_archivo;
            }
        } //end archvio de incapacidad

        $builder = db()->table('incapacidad');
        $builder->insert($data_incapacidad);

        $result = $this->db->insertID();
        if ($result) {
            insertLog($this, session('id'), 'Insertar', 'incapacidad', $result);
            $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Incapacidad registrada correctamente!'));
        } else  $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error al registar la incapacidad, por favor intente de nuevo!'));

        //realizar notificacion
        $data_incapacidad['code'] = $this->db->insertID() ? 1 : 0;
        if ($data_incapacidad['code'] == 1) {
            //$idEmpleado = session('id');
            //$empleado = $this->db->query("SELECT emp_Nombre,emp_EmpleadoID,emp_Correo FROM empleado WHERE emp_EmpleadoID=" . $idEmpleado)->getRowArray();
            $builder = db()->table("empleado");
            $empleado = $builder->getWhere(array("emp_EmpleadoID" => session('id')))->getRowArray();
            $sql_rh = "SELECT emp_Nombre,emp_EmpleadoID,emp_Correo FROM empleado WHERE emp_Rol=?";
            $result_rh = $this->db->query($sql_rh, 1)->getResultArray();


            foreach ($result_rh as $rh) {
                $notificacion = array(
                    "not_EmpleadoID" => $rh['emp_EmpleadoID'],
                    "not_Titulo" => 'Incapacidad registrada',
                    "not_Descripcion" => 'Revisar la solicitud de ' . session("nombre"),
                    "not_EmpleadoIDCreo" => (int)session("id"),
                    "not_FechaRegistro" => date('Y-m-d H:i:s'),
                    "not_URL" => 'Incidencias/incapacidad',
                );
                $builder = db()->table("notificacion");
                $builder->insert($notificacion);

                $datos = array();
                $datos['NombreColaborador'] = $empleado['emp_Nombre'];
                $datos['NombreRH'] = $rh['emp_Nombre'];
                sendMail($rh['emp_Correo'], 'Incapacidad registrada', $datos, 'Incapacidad');
            }
            $jefe = $this->db->query("SELECT * FROM empleado WHERE emp_Numero=?", array($empleado['emp_Jefe']))->getRowArray();

            //notificar a jefe
            $notificacion = array(
                "not_EmpleadoID" => $jefe['emp_EmpleadoID'],
                "not_Titulo" => 'Una incapacidad ha sido registrada',
                "not_Descripcion" => 'El colaborador ' . session("nombre") . ' registro una incapacidad',
                "not_EmpleadoIDCreo" => (int)session("id"),
                "not_FechaRegistro" => date('Y-m-d H:i:s'),
                "not_URL" => 'Incidencias/incapacidadesMisEmpleados',
            );
            $builder = db()->table("notificacion");
            $builder->insert($notificacion);
        }

        return redirect()->to($_SERVER['HTTP_REFERER']);
    } //end addIncapacidad


    //Lia->Crea un acta administrativa
    public function addActaAdministrativa()
    {
        $post = $this->request->getPost();
        $data_acta = array(
            "act_FechaRegistro" => date('Y-m-d'),
            "act_FechaRealizo" => $post['fecha'],
            "act_EmpleadoID" => $post['empleado'],
            "act_RealizoID" => session('id'),
            "act_Tipo" => $post['tipo'],
            "act_Observaciones" => $post['observaciones'],
        );

        //archvio de acta
        if (isset($_FILES['archivo'])) {
            $directorio = FCPATH . "/assets/uploads/actasadmin/";

            if (!file_exists($directorio)) {
                mkdir($directorio, 0777, true);
            }

            $nombre_archivo = $_FILES['archivo']['name'];
            $random = date("Ymd");
            $ruta = $directorio . $random . $nombre_archivo;

            if (move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta)) {
                $data_acta['act_Documento'] = $random . $nombre_archivo;
            }
        }

        $this->db->transStart();

        $builder = db()->table("actaadministrativa");
        $builder->insert($data_acta);
        $result = $this->db->insertID();

        if ($result) {
            $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Sanción registrada correctamente!'));
        } else  $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error al registar, por favor intente de nuevo!'));

        //realizar notificacion
        $data_acta['code'] = $this->db->insertID() ? 1 : 0;
        if ($data_acta['code'] == 1) {
            $sql = "SELECT E.emp_EmpleadoID, E.emp_Nombre, E.emp_Correo FROM empleado E
                JOIN actaadministrativa A ON A.act_EmpleadoID=E.emp_EmpleadoID
                WHERE  A.act_ActaAdministrativaID=?";
            $empleado = $this->db->query($sql, array($result))->getRowArray();
            $notificacion = array(
                "not_EmpleadoID" => $empleado['emp_EmpleadoID'],
                "not_Titulo" => 'Se le ha generado una sancion',
                "not_Descripcion" => 'Ha recibido una sancion:' . $data_acta["act_Tipo"],
                "not_EmpleadoIDCreo" => (int)session("id"),
                "not_FechaRegistro" => date('Y-m-d H:i:s'),
                "not_URL" => 'Incidencias/misSanciones',
            );
            $builder = db()->table("notificacion");
            $builder->insert($notificacion);

            $datos = array();
            $datos['NombreColaborador'] = $empleado['emp_Nombre'];
            $datos['TipoSancion'] = $data_acta["act_Tipo"];
            sendMail($empleado['emp_Correo'], 'Ha recibido ' . $data_acta["act_Tipo"], $datos, 'Sancion');
        }

        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            $data['code'] = 0;
        } else {
            $this->db->transCommit();
            $data['code'] = 1;
        }

        return redirect()->to($_SERVER['HTTP_REFERER']);
    }

    //Diego -> Registra las vacaciones
    public function crearVacaciones()
    {
        $post = $this->request->getPost();
        $post['dias'] = calculoDias(0, $this, session('sucursal'), $post['vac_FechaInicio'], $post['vac_FechaFin'], session('id'));

        //if ($post['dias'] <= $post['diasRestantes']) {
        if (crearVacaciones($post)) {
            $builder = db()->table("empleado");
            $empleado = $builder->getWhere(array("emp_EmpleadoID" => session('id')))->getRowArray();
            if (session('id') == 7) {
                $jefe = $this->db->query("SELECT * FROM empleado WHERE emp_EmpleadoID=19")->getRowArray();
            } else {
                $jefe = $this->db->query("SELECT * FROM empleado WHERE emp_Numero=?", array($empleado['emp_Jefe']))->getRowArray();
            }
            $datos = array();

            $datos['NombreSolicitante'] = $empleado['emp_Nombre'];
            $datos['NombreJefe'] = $jefe['emp_Nombre'];

            //Enviar correo
            if (sendMail($jefe['emp_Correo'], 'Nueva solicitud de vacaciones', $datos, 'VacacionesS')) {

                $notificacion = array(
                    "not_EmpleadoID" => $jefe['emp_EmpleadoID'],
                    "not_Titulo" => 'Nueva solicitud de vacaciones',
                    "not_Descripcion" => 'El colaborador ' . $empleado['emp_Nombre'] . ' ha solicitado vacaciones.',
                    "not_EmpleadoIDCreo" => (int)session("id"),
                    "not_FechaRegistro" => date('Y-m-d H:i:s'),
                    "not_URL" => 'Incidencias/vacacionesMisEmpleados'
                );
                $builder = db()->table("notificacion");
                $builder->insert($notificacion);

                $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Se ha registrado la solicitud de vacaciones correctamente!'));
            } else {
                $this->session->setFlashdata(array('response' => 'warning', 'txttoastr' => '¡Se ha registrado la solicitud pero no se ha enviado el correo!'));
            }
        }
        /*} else {
            $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Has excedido los días permitidos!'));
        }*/
        return redirect()->to($_SERVER['HTTP_REFERER']);
    } //end crearVacaciones

    //Diego -> Registra cambio de horas
    public function crearCambioHorasVac()
    {
        $post = $this->request->getPost();

        $data = array(
            'vach_EmpleadoID' => session('id'),
            'vach_Fecha' => date('Y-m-d H:i:s'),
            'vach_Dias' => $post['diasVacaciones'],
            'vach_Horas' => $post['horasVacaciones'],
            'vach_Observaciones' => $post['vach_Observaciones']
        );
        db()->table("vacacionhoras")->insert($data);
        $idVacaciones = db()->insertID();
        $colaborador = db()->table("empleado")->getWhere(array("emp_EmpleadoID" => session('id')))->getRowArray();
        if ($idVacaciones > 0) {
            if (actualizarVacacion(session('id'), $post['diasRestantes'] - $post['diasVacaciones'])) {
                $builder = db()->table("empleado");
                $empleado = $builder->getWhere(array("emp_Rol" => 1))->getResultArray();
                foreach ($empleado as $emp) {
                    $notificacion = array(
                        "not_EmpleadoID" => $emp['emp_EmpleadoID'],
                        "not_Titulo" => 'Nueva solicitud de horas',
                        "not_Descripcion" => 'El colaborador ' . $colaborador['emp_Nombre'] . ' ha solicitado horas.',
                        "not_EmpleadoIDCreo" => (int)session("id"),
                        "not_FechaRegistro" => date('Y-m-d H:i:s'),
                        "not_URL" => 'Incidencias/aplicarCambioHorasVac'
                    );
                    $builder = db()->table("notificacion");
                    $builder->insert($notificacion);
                    $datos = array(
                        'titulo' => 'Cambio de Vacaciones por Horas',
                        'cuerpo' => 'Mediante el presente se le comunica que el colaborador ' . $colaborador['emp_Nombre'] . ' ha solicitado un cambio de vacaciones a horas.',
                        'nombre' => $emp['emp_Nombre'],
                    );
                    sendMail($emp['emp_Correo'], 'Nueva solicitud de horas', $datos, 'VacacionesHoras');
                }
                $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Se ha registrado la solicitud de  cambio de vacaciones por horas correctamente!'));
            } else {
                $this->session->setFlashdata(array('response' => 'warning', 'txttoastr' => '¡Ha ocurrido un error intente mas tarde!'));
            }
        } else {
            $this->session->setFlashdata(array('response' => 'warning', 'txttoastr' => '¡Ha ocurrido un error intente mas tarde!'));
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    } //end crearVacaciones

    /*
                   _         __   __
         /\       | |  /\    \ \ / /
        /  \      | | /  \    \ V /
       / /\ \ _   | |/ /\ \    > <
      / ____ \ |__| / ____ \  / . \
     /_/    \_\____/_/    \_\/_/ \_\
    */
    //Diego->elimina un registro de incapacidad
    public function ajax_eliminarIncapacidad()
    {
        $incapacidadID = encryptDecrypt('decrypt', post('incapacidadID'));
        $archivo = $this->db->query("SELECT inc_Archivo,inc_EmpleadoID FROM incapacidad WHERE inc_IncapacidadID=" . (int)$incapacidadID)->getRowArray();
        $url = FCPATH . "/assets/uploads/incapacidades/" . $archivo['inc_EmpleadoID'] . "/";
        if (file_exists($url . $archivo['inc_Archivo'])) unlink($url . $archivo['inc_Archivo']);

        $builder = db()->table("incapacidad");
        $result = $builder->delete(array("inc_IncapacidadID" => (int)$incapacidadID));
        if ($result) {
            insertLog($this, session('id'), 'Eliminar', 'incapacidad', $incapacidadID);
            $data['code'] = 1;
        } else {
            $data['code'] = 0;
        }
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end eliminarIncapacidad

    public function ajax_getSolicitudIncapacidades()
    {
        $model = new IncidenciasModel();
        $horas = $model->getSolicitudIncapacidades();

        $arrHoras = array();

        $count = 1;
        foreach ($horas as $hora) {

            $hora['inc_IncapacidadID'] = encryptDecrypt('encrypt', $hora['inc_IncapacidadID']);
            $hora['count'] = $count++;
            $hora['observaciones'] = $hora['inc_Justificacion'];


            array_push($arrHoras, $hora);
        }

        $data['data'] = $arrHoras;
        //var_dump($data['data']);exit();

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_getReportesHoras

    //Lia -> CH revisa el reporte de horas
    public function ajax_revisarIncapacidades()
    {
        $reporteID = (int)encryptDecrypt('decrypt', post("reporteID"));
        $accion = post("accion");

        if ($accion === 'Autorizar') $estatus = 'Autorizada';
        else $estatus = 'Rechazada';

        $observaciones = post("observaciones");

        $this->db->transStart();

        $builder = db()->table("incapacidad");
        $builder->update(array(
            'inc_Estatus' => $estatus,
            'inc_Justificacion' => $observaciones,
            'inc_AutorizaRechazaID' => session('id')
        ), array('inc_IncapacidadID' => $reporteID));

        $empleado = $this->db->query("SELECT Emp.emp_EmpleadoID,Emp.emp_Correo,Emp.emp_Nombre FROM incapacidad I JOIN empleado Emp ON Emp.emp_EmpleadoID=I.inc_EmpleadoID WHERE I.inc_IncapacidadID=" . $reporteID)->getRowArray();

        $datos = array(
            'NombreSolicitante' => $empleado['emp_Nombre'],
        );

        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            $data['code'] = 0;
        } else {
            $this->db->transCommit();
            $data['code'] = 1;
        }

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_revisarReporteHorasCH

    //Lia->Eliminar un acta administrativa
    public function ajax_eliminarActa()
    {
        $idActa = encryptDecrypt('decrypt', post('sancionID'));
        $archivo = $this->db->query("SELECT act_Documento FROM actaadministrativa WHERE act_ActaAdministrativaID=" . (int)$idActa)->getRowArray()['act_Documento'];
        if ($archivo) {
            $url = FCPATH . "/assets/uploads/actasadmin/";
            if (file_exists($url . $archivo)) unlink($url . $archivo);
        }

        $builder = db()->table('actaadministrativa');
        $result = $builder->delete(array("act_ActaAdministrativaID" => (int)$idActa));
        if ($result) {
            $data['code'] = 1;
        } else {
            $data['code'] = 0;
        }
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end eliminarActa

    //Luis->traer sanciones
    public function ajax_getSancionesMisEmpleados()
    {
        $model = new IncidenciasModel();
        $sanciones = $model->getActasAdministrativasMisColaboradores(session('id'));

        $dataSanciones = array();

        foreach ($sanciones as $sancion) {

            $dir = base_url() . "/assets/uploads/actasadmin/" . $sancion['act_Documento'];

            if ($sancion['act_Tipo'] === 'Suspension') {
                $archivo = '<a href="' . base_url('PDF/imprimirFormatoSuspencion/' . encryptDecrypt('encrypt', $sancion['act_ActaAdministrativaID'])) . '" class="btn btn-info waves-light btn-block waves-effect show-pdf" data-title="Imprimir formato de suspensión" style="color: white" title="Imprimir documento" ><i class="zmdi zmdi-local-printshop"></i></a>';
            } else if (substr($sancion['act_Documento'], -3) === "pdf") {
                $archivo = '<a href="' . $dir . '" class="btn btn-info waves-light btn-block waves-effect show-pdf" data-title="Imprimir acta administrativa" style="color: white" title="Imprimir documento" ><i class="zmdi zmdi-local-printshop"></i></a>';
            } else if (substr($sancion['act_Documento'], -3) === "jpg") {
                $archivo = '<a href="' . $dir . '"  data-lightbox="roadtrip" data-title="Ver acta administrativa" class="btn btn-info btn-block waves-light  waves-effect " style="color: white" title="Imprimir documento" ><i class="zmdi zmdi-local-printshop"></i></a>';
            } else if (substr($sancion['act_Documento'], -3) === "png") {
                $archivo = '<a href="' . $dir . '"  data-lightbox="roadtrip" data-title="Ver acta administrativa" class="btn btn-info btn-block waves-light  waves-effect " style="color: white" title="Imprimir documento" ><i class="zmdi zmdi-local-printshop"></i></a>';
            } else if (substr($sancion['act_Documento'], -4) === "jpeg") {
                $archivo = '<a href="' . $dir . '"  data-lightbox="roadtrip" data-title="Ver acta administrativa" class="btn btn-info btn-block waves-light  waves-effect " style="color: white" title="Imprimir documento" ><i class="zmdi zmdi-local-printshop"></i></a>';
            } else $archivo = '';


            $tipo = '';
            switch ($sancion['act_Tipo']) {
                case 'Llamada de atención verbal':
                    $tipo = '<span class="badge badge-dark">Llamada de atención verbal</span>';
                    break;
                case 'Amonestación':
                    $tipo = '<span class="badge badge-info">Amonestación <br> (Carta Extrañamiento)</span>';
                    break;
                case 'Compromiso por escrito':
                    $tipo = '<span class="badge badge-warning">Compromiso por escrito</span>';
                    break;
                case 'Acta administrativa':
                    $tipo = '<span class="badge badge-danger">Acta administrativa</span>';
                    break;
                case 'Suspension':
                    $tipo = '<span class="badge badge-purple">Suspensión</span>';
                    break;
            }

            $sancion['documento'] = $archivo;
            $sancion['tipo'] = $tipo;

            array_push($dataSanciones, $sancion);
        }

        $data['data'] = $dataSanciones;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_getSancionesMisEmpleados

    //Lia -> Elimina una solicitud de vacaciones
    public function ajax_eliminarVacaciones()
    {
        $idVacacion = encryptDecrypt('decrypt', post('vacacionID'));
        $builder = db()->table("vacacion");
        $vacacion = $builder->getWhere(array("vac_VacacionesID" => $idVacacion))->getRowArray();
        $idEmpleado = $vacacion['vac_EmpleadoID'];
        rechazarVacaciones($idEmpleado, $idVacacion, $this);
        $res = $builder->update(array('vac_Estado' => 0), array("vac_VacacionesID" => $idVacacion));
        $data['code'] = 0;
        if ($res) $data['code'] = 1;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_eliminarVacaciones

    //Lia->vacaciones de los claboradores a cargo
    public function ajax_getVacacionesEmpleadosJefe()
    {
        $numJefe = session('numero');
        $model = new IncidenciasModel();
        $vacaciones = $model->getVacacionesEmpleadosJefe($numJefe);
        $data_vacaciones = array();
        foreach ($vacaciones as $vacacion) {
            $inicio = $vacacion['vac_FechaInicio'];
            $fin = $vacacion['vac_FechaFin'];
            $titulo = $vacacion['emp_Nombre'];
            $className = "";

            //Switch
            switch ($vacacion['vac_Estatus']) {
                case 'PENDIENTE':
                    $className = "bg-info";
                    break;
                case 'AUTORIZADO':
                    $className = "bg-warning";
                    break;
                case 'RECHAZADO':
                    $className = "bg-danger";
                    break;
                case 'AUTORIZADO_GO':
                    $className = "bg-warning";
                    break;
                case 'RECHAZADO_GO':
                    $className = "bg-danger";
                    break;
                case 'AUTORIZADO_RH':
                    $className = "bg-success";
                    break;
                case 'RECHAZADO_RH':
                    $className = "bg-danger";
                    break;
                case 'DECLINADO':
                    $className = "bg-light";
                    break;
            }

            $data_vacaciones[] = array(
                "title" => $titulo,
                "start" => $inicio,
                "end" => $fin . " 23:59:59",
                'periodo' => 'del ' . shortDate($inicio, '-') . ' al ' . longDate($fin, '-'),
                'className' => $className,
            );
        }
        echo json_encode(array("events" => $data_vacaciones));
    } //end ajax_getVacacionesEmpleadosJefe

    //Lia -> Autoriza o rechaza las vacaciones el jefe directo
    public function ajax_cambiarEstatusAutorizarVacaciones()
    {
        $idVacaciones = encryptDecrypt('decrypt', post('vacacionID'));
        $estatus = post('estatus');
        $observaciones = post('observaciones');

        if (autorizarVacaciones((int)$idVacaciones, $estatus, $observaciones, $this)) {

            $empleado = $this->db->query("SELECT E.emp_EmpleadoID, E.emp_Nombre FROM empleado E JOIN vacacion V ON V.vac_EmpleadoID=E.emp_EmpleadoID WHERE  V.vac_VacacionesID=?", array($idVacaciones))->getRowArray();

            $notificacion = array(
                "not_EmpleadoID" => $empleado['emp_EmpleadoID'],
                "not_Titulo" => 'Solicitud de vacaciones ' . $estatus,
                "not_Descripcion" => 'La solicitud de vacaciones ha sido revisada.',
                "not_EmpleadoIDCreo" => (int)session("id"),
                "not_FechaRegistro" => date('Y-m-d H:i:s'),
                "not_URL" => 'Incidencias/misVacaciones'
            );
            $builder = db()->table("notificacion");
            $builder->insert($notificacion);
            if ($estatus == 'AUTORIZADO') {
                $ch = $this->db->query("SELECT E.emp_EmpleadoID,E.emp_Nombre, E.emp_Correo FROM empleado E WHERE E.emp_Rol=1")->getResultArray();
                foreach ($ch as $c) {
                    $notificacion = array(
                        "not_EmpleadoID" => $c['emp_EmpleadoID'],
                        "not_Titulo" => 'Solicitud de vacaciones por aplicar',
                        "not_Descripcion" => 'Revisar la solicitud de ' . $empleado['emp_Nombre'],
                        "not_EmpleadoIDCreo" => (int)session("id"),
                        "not_FechaRegistro" => date('Y-m-d H:i:s'),
                        "not_URL" => 'Incidencias/listVacaciones/aplicar',
                    );
                    $builder = db()->table("notificacion");
                    $builder->insert($notificacion);
                    $dataCorreo = array(
                        'titulo' => 'Vacacion Pendiente de Aplicar',
                        'cuerpo' => 'Mediante el presente se le comunica que el colaborador ' . $empleado['emp_Nombre'] . ', ha solicitado vacaciones en la plataforma THIGO.',
                        'nombre' => $c['emp_Nombre'],
                    );
                    sendMail($c['emp_Correo'], 'Solicitud de Vacación', $dataCorreo, 'correoVacacionesRH');
                }
            }

            $data['code'] = 1;
        } else {
            $data['code'] = 0;
        }
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_cambiarEstatusAutorizarVacaciones

    //Lia -> Aplica o rechaza las vacaciones recursos humanos
    public function ajax_cambiarEstatusVacaciones()
    {
        $idVacaciones = encryptDecrypt('decrypt', post('vacacionID'));
        $estatus = post('estatus');
        $obs = post('observaciones');

        if (autorizarVacaciones((int)$idVacaciones, $estatus, $obs, $this)) {

            $sql = "SELECT E.emp_EmpleadoID FROM empleado E
                JOIN vacacion V ON V.vac_EmpleadoID=E.emp_EmpleadoID
                WHERE  V.vac_VacacionesID=?";
            $empleado = $this->db->query($sql, array($idVacaciones))->getRowArray();

            if ($estatus === 'AUTORIZADO_RH') $txt = 'aplicada';
            else $txt = 'rechazada por Recursos Humanos';

            $notificacion = array(
                "not_EmpleadoID" => $empleado['emp_EmpleadoID'],
                "not_Titulo" => 'Solicitud de vacaciones ' . $txt,
                "not_Descripcion" => 'La solicitud de vacaciones ha sido revisada.',
                "not_EmpleadoIDCreo" => (int)session("id"),
                "not_FechaRegistro" => date('Y-m-d H:i:s'),
            );
            $builder = db()->table("notificacion");
            $builder->insert($notificacion);
            $data['code'] = 1;
        } else {
            $data['code'] = 0;
        }
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_cambiarEstatusVacaciones

    //Diego -> Aplica o rechaza la solicitud de vacaciones horas recursos humanos
    public function ajax_cambiarEstatusHorasVacaciones()
    {
        $idVacaciones = encryptDecrypt('decrypt', post('vacacionID'));
        $estatus = post('estatus');
        $obs = post('observaciones');
        $data['code'] = 0;

        $empleado = db()->query("SELECT * FROM empleado JOIN vacacionhoras ON vach_EmpleadoID=emp_EmpleadoID WHERE vach_VacacionHorasID=?", array($idVacaciones))->getRowArray();

        if ($estatus == 'AUTORIZADO_RH') {
            $txt = "Aplicada";
            $builder_vach = db()->table("vacacionhoras");
            $res = $builder_vach->update(array('vach_Estatus' => $estatus, 'vach_AutorizaID' => session('id')), array("vach_VacacionHorasID" => $idVacaciones));
            if ($res) {
                $builder_acumulados = db()->table('acumulados');
                $existe = $this->db->query("SELECT * FROM acumulados WHERE acu_EmpleadoID=?", array($empleado['emp_EmpleadoID']))->getRowArray();
                if ($existe) {
                    $nuevasHoras = $existe['acu_HorasExtra'] + $empleado['vach_Horas'];
                    $builder_acumulados->update(array('acu_HorasExtra' => $nuevasHoras), array("acu_AcumuladosID" => $existe['acu_AcumuladosID']));
                    $data['code'] = 1;
                } else {
                    $data_acumulado = array('acu_EmpleadoID' => $empleado['emp_EmpleadoID'], 'acu_HorasExtra' => $empleado['vach_Horas']);
                    $builder_acumulados->insert($data_acumulado);
                    $data['code'] = 1;
                }
            }
        } else {
            $txt = "Rechazada";
            $builder_vach = db()->table("vacacionhoras");
            $res = $builder_vach->update(array('vach_Estatus' => $estatus, 'vach_Observaciones' => $obs), array("vach_VacacionHorasID" => $idVacaciones));
            $vacacionActual = db()->query("SELECT vace_Dias FROM vacacionempleado WHERE vace_EmpleadoID=?", array($empleado['emp_EmpleadoID']))->getRowArray()['vace_Dias'] ?? 0;
            $builder_vacaciones = db()->table('vacacionempleado');
            $builder_vacaciones->update(array('vace_Dias' => $vacacionActual + $empleado['vach_Dias'], 'vace_FechaActualizacion' => date('Y-m-d H:i:s')), array("vace_EmpleadoID" => $empleado['emp_EmpleadoID']));
            $data['code'] = 1;
        }
        $notificacion = array(
            "not_EmpleadoID" => $empleado['emp_EmpleadoID'],
            "not_Titulo" => 'Solicitud de vacaciones-horas ' . $txt,
            "not_Descripcion" => 'La solicitud de horas ha sido revisada.',
            "not_EmpleadoIDCreo" => (int)session("id"),
            "not_FechaRegistro" => date('Y-m-d H:i:s'),
        );
        $builder = db()->table("notificacion");
        $builder->insert($notificacion);
        $datos = array(
            'titulo' => 'Cambio de Vacaciones por Horas',
            'cuerpo' => 'Mediante el presente se le comunica que la solicitud de vacaciones a horas ha sido revisada.',
            'nombre' => $empleado['emp_Nombre'],
        );
        sendMail($empleado['emp_Correo'], 'Solicitud de Horas Revisada', $datos, 'RevisadaVacacionesHoras');

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_cambiarEstatusVacaciones

    //Diego-> declinar vacaciones
    public function ajax_declinarVacaciones()
    {
        $data['code'] = 0;
        $idVacaciones = encryptDecrypt('decrypt', post('vacacionID'));
        $obs = post('obs');
        $builder = db()->table("vacacion");
        $vacacionB = $builder->getWhere(array("vac_VacacionesID" => $idVacaciones))->getRowArray();
        $idEmpleado = $vacacionB['vac_EmpleadoID'];
        $idVacacion = $vacacionB['vac_VacacionesID'];
        rechazarVacaciones($idEmpleado, $idVacacion, $this);

        $builder = db()->table("vacacion");
        $builder->update(array("vac_Estatus" => 'DECLINADO', "vac_Justificacion" => $obs), array("vac_VacacionesID" => $idVacaciones));
        if (db()->affectedRows() > 0) $data['code'] = 1;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end declinar vacaciones

    //HUGO->Ver lista de permisos del empleado
    public function ajax_getPermisosByEmpleadoID()
    {
        $empleadoID = (int)session("id");
        $model = new IncidenciasModel();
        $permisos = $model->getPermisosByEmpleado($empleadoID);
        $arrPermisos = array();

        foreach ($permisos as $permiso) {
            $permiso['per_PermisoID'] = encryptDecrypt('encrypt', $permiso['per_PermisoID']);
            $permiso['tipoPermiso'] = $permiso['tipoPermiso'];
            if ($permiso['per_Horas'] > 0 || $permiso['per_Horas'] != null) {
                $permiso['per_Motivos'] = '(De ' . shortTime($permiso['per_HoraInicio']) . ' a ' . shortTime($permiso['per_HoraFin']) . ') ' . $permiso['per_Motivos'];
            }
            array_push($arrPermisos, $permiso);
        }

        $data['data'] = $arrPermisos;

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_getPermisosByEmpleadoID

    public function ajax_fechaColaborador($tipo, $fechaC)
    {
        //aniversario de boda
        $anioPermiso = explode('-', $fechaC);
        if ((int)$tipo === 1){
            $fecha = $this->db->query("SELECT DATE_SUB(CONCAT_WS('-','" . $anioPermiso[0] . "' ,MONTH(emp_FechaMatrimonio),DAY(emp_FechaMatrimonio)), INTERVAL 15 DAY) as 'fechaInicio', DATE_ADD(CONCAT_WS('-','" . $anioPermiso[0] . "' ,MONTH(emp_FechaMatrimonio),DAY(emp_FechaMatrimonio)), INTERVAL 15 DAY) as 'fechaLimite',MONTH(emp_FechaMatrimonio) as 'mes' FROM empleado WHERE emp_EmpleadoID=" . session('id'))->getRowArray();
        }else{
        //cumpleaños
            $fecha = $this->db->query("SELECT DATE_SUB(CONCAT_WS('-','" . $anioPermiso[0] . "' ,MONTH(emp_FechaNacimiento),DAY(emp_FechaNacimiento)), INTERVAL 15 DAY) as 'fechaInicio',DATE_ADD(CONCAT_WS('-','" . $anioPermiso[0] . "' ,MONTH(emp_FechaNacimiento),DAY(emp_FechaNacimiento)), INTERVAL 15 DAY) as 'fechaLimite',MONTH(emp_FechaNacimiento) as 'mes' FROM empleado WHERE emp_EmpleadoID=" . session(('id')))->getRowArray();
        }
        if($fecha['mes'] == 12 && $anioPermiso[1]==1){
            $fecha['fechaInicio']=date('Y-m-d', strtotime($fecha['fechaInicio'] . ' -1 year'));
            $fecha['fechaLimite']=date('Y-m-d', strtotime($fecha['fechaLimite'] . ' -1 year'));
        }
        if ($fecha) {
            if (($fechaC >= date('Y-m-d', strtotime($fecha['fechaInicio']))) && ($fechaC <= date('Y-m-d', strtotime($fecha['fechaLimite'])))) echo json_encode(array("code" => "1"));
            else echo json_encode(array("code" => "2"));
        } else echo json_encode(array("code" => "0"));
    }


    //Lia->Crear permiso
    public function ajax_crearPermiso()
    {
        $data['code'] = 1;
        $tipoID = (int)post('txtTipoPermiso');
        $model = new IncidenciasModel();
        $tipoPermiso = $model->getCatalogoPermisosById($tipoID);
        $diasPermitidos = (int)$tipoPermiso['cat_Dias'];
        $diasSolicitados = calcularDiasPermiso(post('txtFechaInicio'), post('txtFechaFin'));
        if ($diasPermitidos > 0) {
            $diasTomados = $model->getDiasTomadosByTipoPermiso($tipoID);
            $diasRestantes = $diasTomados < $diasPermitidos ? $diasPermitidos - $diasTomados : 0;
            if ($diasSolicitados > $diasPermitidos) {
                $data['code'] = 2;
                $data['msg'] = "Solo se permite solicitar $diasPermitidos días";
            } elseif ($diasSolicitados > $diasRestantes) {
                $data['code'] = 2;
                $data['msg'] = "Tienes $diasRestantes días restantes";
            }
        }
        $builder = db()->table("empleado");
        $empleado = $builder->getWhere(array("emp_EmpleadoID" => (int)session('id')))->getRowArray();
        if ($data['code'] != 2) {
            if (session('id') == 7) {
                $jefe = $this->db->query("SELECT * FROM empleado WHERE emp_EmpleadoID=19")->getRowArray();
            } else {
                $sql_jefe = "SELECT * FROM empleado WHERE emp_Numero=?";
                $jefe = $this->db->query($sql_jefe, array($empleado['emp_Jefe']))->getRowArray();
            }

            //Arreglo de permiso
            $permiso = array(
                'per_Fecha' => date('Y-m-d'),
                'per_FechaInicio' => post('txtFechaInicio'),
                'per_FechaFin' => post('txtFechaFin'),
                'per_HoraCreado' => date('H:i:s'),
                'per_Motivos' => post('txtMotivos'),
                'per_EmpleadoID' => (int)session('id'),
                'per_Estado' => 'PENDIENTE',
                'per_TipoID' => $tipoID,
                'per_DiasSolicitados' => $diasSolicitados,
            );
            //Si es tiempo x tiempo agrega las horas al arreglo
            if ($tipoID === 7) {
                $ts1 = strtotime(str_replace('/', '-', post('txtFechaInicio') . ' ' . post('txtHoraI')));
                $ts2 = strtotime(str_replace('/', '-', post('txtFechaFin') . ' ' . post('txtHoraF')));
                $diff = abs($ts1 - $ts2) / 3600;
                $permiso['per_Horas'] = $diff;
                $permiso['per_HoraInicio'] = post('txtHoraI');
                $permiso['per_HoraFin'] = post('txtHoraF');
            }
            //guarda el arreglo
            $builder2 = db()->table('permiso');
            $response = $builder2->insert($permiso);

            if ($response) {
                $datos = array();
                $datos['NombreSolicitante'] = $empleado['emp_Nombre'];
                $datos['NombreJefe'] = $jefe['emp_Nombre'];
                //Enviar correo y notificacion
                sendMail($jefe['emp_Correo'], 'Nueva solicitud de permiso', $datos, 'PermisoS');
                $notificacion = array(
                    "not_EmpleadoID" => $jefe['emp_EmpleadoID'],
                    "not_Titulo" => 'Nueva solicitud de permiso',
                    "not_Descripcion" => 'El colaborador ' . $empleado['emp_Nombre'] . ' ha solicitado permiso.',
                    "not_EmpleadoIDCreo" => (int)session("id"),
                    "not_FechaRegistro" => date('Y-m-d H:i:s'),
                    "not_URL" => 'Incidencias/permisosMisEmpleados'
                );
                $builder = db()->table("notificacion");
                $response = $builder->insert($notificacion);
            } else {
                $data['code'] = 0;
            }
        }

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_crearPermiso

    //HUGO->Lista de permisos para autorizar por jefe inmediato
    public function ajax_getPermisosAutorizar()
    {
        $model = new IncidenciasModel();
        $permisos = $model->getPermisosPendientesMisSubordinados(session('numero'));
        $arrPermisos = array();

        foreach ($permisos as $permiso) {
            $permiso['per_PermisoID'] = encryptDecrypt('encrypt', $permiso['per_PermisoID']);
            if ($permiso['per_Horas'] > 0 || $permiso['per_Horas'] != null) {
                $permiso['per_Motivos'] = '(De ' . shortTime($permiso['per_HoraInicio']) . ' a ' . shortTime($permiso['per_HoraFin']) . ') ' . $permiso['per_Motivos'];
            }
            $permiso['tipoPermiso'] = $permiso['tipoPermiso'];
            $permiso['autoriza'] = session('puesto');
            $permiso['tipoPID'] = (int)$permiso['tipoPID'];
            $permiso['numero'] = session('numero');
            array_push($arrPermisos, $permiso);
        }
        $data['data'] = $arrPermisos;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_getPermisosAutorizar

    //HUGO->Jefe inmediato autoriza permiso
    public function ajax_autorizarPermiso()
    {
        $permisoID = (int)encryptDecrypt('decrypt', post("permisoID"));
        $permiso = db()->query("SELECT P.*,E.emp_EmpleadoID,E.emp_Nombre,E.emp_Correo FROM permiso P JOIN empleado E ON E.emp_EmpleadoID=P.per_EmpleadoID WHERE P.per_PermisoID=?", array($permisoID))->getRowArray();
        $data = array();
        if ($permiso['per_Estado'] == 'PENDIENTE') {
            //Jefe aprueba
            $data['per_JefeID'] = session('id');
            $data['per_Estado'] = 'AUTORIZADO_JEFE';
            $builder = db()->table("empleado");
        }
        $data['per_TipoPermiso'] = post('tipo') ?? '';
        $data['per_Justificacion'] = post('obs') ?? '';
        //Actualiza permiso
        $builder = db()->table('permiso');
        $response = $builder->update($data, array('per_PermisoID' => $permisoID));
        if ($response) {
            $datos['NombreSolicitante'] = $permiso['emp_Nombre'];

            if ($permiso['per_Estado'] == 'PENDIENTE') {
                $builder = db()->table('empleado');
                $notificado = $builder->getWhere(array("emp_Rol" => 1))->getResultArray();
                foreach ($notificado as $not) {
                    $notificacion = array(
                        "not_EmpleadoID" => $not['emp_EmpleadoID'],
                        "not_Titulo" => 'Solicitud de permiso por APLICAR',
                        "not_Descripcion" => 'El colaborador ' . $permiso['emp_Nombre'] . ' ha solicitado permiso.',
                        "not_EmpleadoIDCreo" => (int)session("id"),
                        "not_FechaRegistro" => date('Y-m-d H:i:s'),
                        "not_URL" => 'Incidencias/aplicarPermisos'
                    );
                    $builder = db()->table("notificacion");
                    $builder->insert($notificacion);
                    $datos_correo = array(
                        'titulo' => 'Solicitud de permiso por aplicar',
                        'cuerpo' => 'El colaborador ' . $permiso['emp_Nombre'] . ' ha solicitado permiso.',
                        'nombre' => $not['emp_Nombre'],
                    );
                    sendMail($not['emp_Correo'], 'Solicitud de permiso por aplicar', $datos_correo, 'PermisoRH');
                }
                $data['code'] = 1;
            }
        } else {
            $data['code'] = 0;
        }
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_autorizarPermiso

    //HUGO->Jefe inmediato autoriza permiso
    public function ajax_rechazarPermiso()
    {
        $permisoID = (int)encryptDecrypt('decrypt', post("permisoID"));

        $this->db->transStart();
        $permiso = db()->query("SELECT P.*,E.emp_EmpleadoID,E.emp_Nombre,E.emp_Correo FROM permiso P JOIN empleado E ON E.emp_EmpleadoID=P.per_EmpleadoID WHERE P.per_PermisoID=?", array($permisoID))->getRowArray();
        $data = array(
            'per_Justificacion' => post('obs')
        );
        if ($permiso['per_Estado'] == 'PENDIENTE') {
            $data['per_JefeID'] = session('id');
            $data['per_Estado'] = 'RECHAZADO_JEFE';
        } elseif ($permiso['per_Estado'] == 'AUTORIZADO_JEFE') {
            $data['per_ChID'] = session('id');
            $data['per_Estado'] = 'RECHAZADO_RH';
        }

        $builder = db()->table('permiso');
        $builder->update($data, array('per_PermisoID' => $permisoID));

        $sql = "SELECT E.emp_Correo,E.emp_Nombre,E.emp_Jefe,E.emp_EmpleadoID FROM empleado E
            JOIN permiso P ON P.per_EmpleadoID=E.emp_EmpleadoID
            WHERE P.per_PermisoID=" . $permisoID;
        $empleado = $this->db->query($sql)->getRowArray();

        $datos['NombreSolicitante'] = $empleado['emp_Nombre'];

        //Enviar correo
        sendMail($empleado['emp_Correo'], 'Permiso Rechazado', $datos, 'PermisoRechazado');
        $notificacion = array(
            "not_EmpleadoID" => $empleado['emp_EmpleadoID'],
            "not_Titulo" => 'Solicitud de permiso RECHAZADO',
            "not_Descripcion" => 'La solicitud de permiso ha sido revisada.',
            "not_EmpleadoIDCreo" => (int)session("id"),
            "not_FechaRegistro" => date('Y-m-d H:i:s'),
            "not_URL" => 'Incidencias/misPermisos',
        );
        $builder = db()->table("notificacion");
        $builder->insert($notificacion);

        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            $data['code'] = 0;
        } else {
            $this->db->transCommit();
            $data['code'] = 1;
        }

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_rechazarPermiso

    //Diego -> Aplicar permiso
    public function ajax_getPermisosAplicar()
    {
        $model = new IncidenciasModel();
        $permisos = $model->getPermisosAutorizados();
        $arrPermisos = array();
        foreach ($permisos as $permiso) {
            $permiso['per_PermisoID'] = encryptDecrypt('encrypt', $permiso['per_PermisoID']);
            $permiso['tipoPermiso'] = $permiso['tipoPermiso'];
            $permiso['tipoPID'] = (int)$permiso['tipoPID'];
            if ($permiso['per_HoraCreado'] !== '00:00:00') {
                $permiso['per_Fecha'] = $permiso['per_Fecha'] . ' ' . shortTime($permiso['per_HoraCreado']);
            }
            if ($permiso['per_Horas'] > 0 || $permiso['per_Horas'] != null) {
                $permiso['per_TipoPermiso'] = '(De ' . shortTime($permiso['per_HoraInicio']) . ' a ' . shortTime($permiso['per_HoraFin']) . ') Tiempo por tiempo';
            }
            array_push($arrPermisos, $permiso);
        }
        $data['data'] = $arrPermisos;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_getPermisosAplicar

    //HUGO->Aplicar permisos
    public function ajax_aplicarPermiso()
    {
        $permisoID = (int)encryptDecrypt('decrypt', post('permisoID'));

        $this->db->transStart();

        $data = array(
            'per_ChID' => session('id'),
            "per_Estado" => "AUTORIZADO_RH"
        );

        $builder = db()->table("permiso");
        $builder->update($data, array("per_PermisoID" => $permisoID));

        $qr = "SELECT EMP.emp_EmpleadoID, EMP.emp_Correo as 'Correo',EMP.emp_Nombre as 'NombreEmp', PER.*
               FROM permiso PER
               JOIN empleado EMP ON PER.per_EmpleadoID = EMP.emp_EmpleadoID
               WHERE PER.per_PermisoID =?";
        $datosEmpleado = $this->db->query($qr, array((int)$permisoID))->getRowArray();

        if (sendMail($datosEmpleado['Correo'], 'Permiso aplicado', $datosEmpleado, 'Permiso')) {
            $notificacion = array(
                "not_EmpleadoID" => $datosEmpleado['emp_EmpleadoID'],
                "not_Titulo" => 'Solicitud de permiso APLICADO',
                "not_Descripcion" => 'La solicitud de permiso ha sido revisada.',
                "not_EmpleadoIDCreo" => (int)session("id"),
                "not_FechaRegistro" => date('Y-m-d H:i:s'),
                "not_URL" => 'Incidencias/misPermisos',
            );
            $builder = db()->table("notificacion");
            $builder->insert($notificacion);
        }

        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            $data['code'] = 0;
        } else {
            $this->db->transCommit();
            $data['code'] = 1;
        }

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_aplicarPermiso

    //Declinar permiso
    public function ajax_declinarPermiso()
    {
        $permisoID = (int)encryptDecrypt('decrypt', post('permisoID'));
        $data = array(
            'per_ChID' => session('id'),
            'per_Estado' => 'DECLINADO',
            'per_Justificacion' => post('obs')
        );
        $builder = db()->table('permiso');
        $response = $builder->update($data, array('per_PermisoID' => $permisoID));
        if ($response) {
            $data['code'] = 1;
        } else $data['code'] = 0;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_noAplicarPermiso

    //Horas extra del colaborado
    public function ajax_getMisHorasExtra()
    {
        $empleadoID = (int)session("id");
        $model = new IncidenciasModel();
        $horas = $model->getHorasExtraByEmpleado($empleadoID);
        $arrHoras = array();
        $count = 1;
        foreach ($horas as $hora) {
            $hora['rep_ReporteHoraExtraID'] = encryptDecrypt('encrypt', $hora['rep_ReporteHoraExtraID']);
            $hora['count'] = $count++;
            array_push($arrHoras, $hora);
        }
        $data['data'] = $arrHoras;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_getMisHorasExtra

    //Guarda los reportes de reportes de horas extra
    public function ajaxAddReporteHorasExtras()
    {
        $post = $this->request->getPost();

        $reporte = array(
            'rep_FechaRegistro' => date('Y-m-d'),
            'rep_EmpleadoID' => (int)session('id'),
            'rep_Fecha' => $post['fecha'],
            'rep_HoraInicio' => $post['horaInicio'],
            'rep_HoraFin' => $post['horaFin'],
            'rep_Horas' => (int)calculoHorasExtra($post['horaInicio'], $post['horaFin']),
            'rep_Motivos' => $post['motivos'],
        );

        $builder = db()->table("reportehoraextra");
        $builder->insert($reporte);
        $data['code'] = $this->db->insertID() ? 1 : 0;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajaxAddReporteHorasExtras

    //Elimina el reporte de horas extra
    public function ajax_deleteReporteHorasExtra()
    {
        $reporteID = (int)encryptDecrypt('decrypt', post("reporteID"));
        $builder = db()->table("reportehoraextra");
        $response = $builder->update(array('rep_Estatus' => 0), array('rep_ReporteHoraExtraID' => $reporteID));
        $data['code'] = $response ? 1 : 0;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_deleteReporteHorasExtra

    //Envia el reporte de Horas extra
    public function ajax_enviarReporteHorasExtra()
    {
        $reporteID = (int)encryptDecrypt('decrypt', post("reporteID"));
        $data['code'] = 0;

        $this->db->transStart();

        $empleado = $this->db->query("SELECT E.emp_EmpleadoID,E.emp_Nombre,E.emp_Jefe FROM reportehoraextra R JOIN empleado E ON E.emp_EmpleadoID=R.rep_EmpleadoID WHERE R.rep_ReporteHoraExtraID=" . $reporteID)->getRowArray();
        if (session('id') == 7) {
            $jefe = $this->db->query("SELECT E.emp_EmpleadoID,E.emp_Nombre, E.emp_Correo FROM empleado E WHERE E.emp_EmpleadoID=19")->getRowArray();
        } else {
            $jefe = $this->db->query("SELECT E.emp_EmpleadoID,E.emp_Nombre, E.emp_Correo FROM empleado E WHERE E.emp_Numero='" . $empleado['emp_Jefe'] . "'")->getRowArray();
        }

        $datos = array(
            'NombreSolicitante' => $empleado['emp_Nombre'],
            'NombreJefe' => $jefe['emp_Nombre'],
        );

        $builder = db()->table("reportehoraextra");
        $builder->update(array('rep_Estado' => 'PENDIENTE'), array('rep_ReporteHoraExtraID' => $reporteID));

        sendMail($jefe['emp_Correo'], 'Nueva solicitud de horas extra', $datos, 'ReporteHorasExtra');

        $notificacion = array(
            "not_EmpleadoID" => $jefe['emp_EmpleadoID'],
            "not_Titulo" => 'Nueva solicitud de horas extra',
            "not_Descripcion" => $empleado['emp_Nombre'] . ' envio una solicitud de horas extra.',
            "not_EmpleadoIDCreo" => (int)session("id"),
            "not_FechaRegistro" => date('Y-m-d H:i:s'),
            "not_URL" => 'Incidencias/horasExtraMisEmpleados',
        );
        $builder = db()->table("notificacion");
        $builder->insert($notificacion);

        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            $data['code'] = 0;
        } else {
            $this->db->transCommit();
            $data['code'] = 1;
        }

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_enviarReporteHorasExtra

    //Lia-> salidas de mis empleados
    public function ajax_getHorasMisEmpleados()
    {
        $empleadoID = session("numero");
        $model = new IncidenciasModel();
        $horas = $model->getHorasMisEmpleadosJefe($empleadoID);
        $arrHoras = array();
        $count = 1;
        foreach ($horas as $hora) {
            $hora['rep_ReporteHoraExtraID'] = encryptDecrypt('encrypt', $hora['rep_ReporteHoraExtraID']);
            $hora['count'] = $count++;
            array_push($arrHoras, $hora);
        }
        $data['data'] = $arrHoras;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_getHorasMisEmpleados

    public function ajax_revisarReporteHorasJefe()
    {
        $post = $this->request->getPost();
        $reporteID = (int)encryptDecrypt('decrypt', $post["reporteID"]);
        $estatus = $post["accion"];
        $observaciones = !empty($post["observaciones"]) ? $post["observaciones"] : '';

        $this->db->transStart();

        $builder = db()->table("reportehoraextra");
        $builder->update(array('rep_Estado' => $estatus, 'rep_ObservacionesJ' => $observaciones), array('rep_ReporteHoraExtraID' => $reporteID));
        $empleado = $this->db->query("SELECT E.emp_EmpleadoID,E.emp_Nombre,E.emp_Jefe,E.emp_Correo FROM reportehoraextra R JOIN empleado E ON E.emp_EmpleadoID=R.rep_EmpleadoID WHERE R.rep_ReporteHoraExtraID=" . $reporteID)->getRowArray();
        $jefe = $this->db->query("SELECT E.emp_EmpleadoID,E.emp_Nombre, E.emp_Correo FROM empleado E WHERE E.emp_Numero='" . $empleado['emp_Jefe'] . "'")->getRowArray();
        $rh = $this->db->query("SELECT E.emp_EmpleadoID,E.emp_Nombre,E.emp_Correo FROM empleado E WHERE E.emp_Rol=1")->getResultArray();

        $datos = array(
            'NombreSolicitante' => $empleado['emp_Nombre'],
            'NombreJefe' => $jefe['emp_Nombre'],
            'accion' => $estatus,
        );
        sendMail($empleado['emp_Correo'], 'Solicitud de horas extra revisada', $datos, 'ReporteHorasRevisionJefe');
        $notificacion = array(
            "not_EmpleadoID" => $empleado['emp_EmpleadoID'],
            "not_Titulo" => 'Solicitud de horas extra ' . $estatus,
            "not_Descripcion" => 'La solicitud de horas extra ha sido revisada.',
            "not_EmpleadoIDCreo" => (int)session("id"),
            "not_FechaRegistro" => date('Y-m-d H:i:s'),
            "not_URL" => 'Incidencias/controlHorasExtra',
        );
        $builder = db()->table("notificacion");
        $builder->insert($notificacion);

        if ($estatus == "AUTORIZADO") {
            foreach ($rh as $c) {
                $datos = array(
                    'NombreSolicitante' => $empleado['emp_Nombre'],
                    'NombreRH' => $c['emp_Nombre'],
                );
                sendMail($c['emp_Correo'], 'Nueva solicitud de horas extra', $datos, 'ReporteHorasExtraCH');
                $notificacion = array(
                    "not_EmpleadoID" => $c['emp_EmpleadoID'],
                    "not_Titulo" => 'Solicitud de horas extra por aplicar',
                    "not_Descripcion" => 'Solicitud de ' . $empleado['emp_Nombre'] . ' pendiente de revisar.',
                    "not_EmpleadoIDCreo" => (int)session("id"),
                    "not_FechaRegistro" => date('Y-m-d H:i:s'),
                    "not_URL" => 'Incidencias/aplicarReporteHoras',
                );
                $builder = db()->table("notificacion");
                $builder->insert($notificacion);
            }
        }

        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            $data['code'] = 0;
        } else {
            $this->db->transCommit();
            $data['code'] = 1;
        }

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_revisarReporteHorasJefe

    //Lia->CH aplica el reporte de horas
    public function ajax_getReportesHoras()
    {
        $model = new IncidenciasModel();
        $horas = $model->getReportesHorasExtras();
        $arrHoras = array();
        $count = 1;
        foreach ($horas as $hora) {
            $hora['rep_ReporteHoraExtraID'] = encryptDecrypt('encrypt', $hora['rep_ReporteHoraExtraID']);
            $hora['count'] = $count++;
            $hora['observaciones'] = $hora['rep_ObservacionesJ'] . ' ' . $hora['rep_ObservacionesCH'];
            array_push($arrHoras, $hora);
        }
        $data['data'] = $arrHoras;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_getReportesHoras

    //Lia -> CH revisa el reporte de horas
    public function ajax_revisarReporteHorasCH()
    {
        $reporteID = (int)encryptDecrypt('decrypt', post("reporteID"));
        $accion = post("accion");

        if ($accion === 'APLICAR') $estatus = 'APLICADO';
        else $estatus = 'RECHAZADO_RH';

        $observaciones = post("observaciones");

        $this->db->transStart();

        $builder = db()->table("reportehoraextra");
        $builder->update(array(
            'rep_Estado' => $estatus,
            'rep_ObservacionesCH' => $observaciones,
            'rep_AproboID' => session('id')
        ), array('rep_ReporteHoraExtraID' => $reporteID));

        $empleado = $this->db->query("SELECT Emp.emp_EmpleadoID,Emp.emp_Correo,Emp.emp_Nombre FROM reportehoraextra R JOIN empleado Emp ON Emp.emp_EmpleadoID=R.rep_EmpleadoID WHERE R.rep_ReporteHoraExtraID=" . $reporteID)->getRowArray();

        $datos = array(
            'NombreSolicitante' => $empleado['emp_Nombre'],
        );

        sendMail($empleado['emp_Correo'], 'Solicitud de horas extra', $datos, 'ReporteHorasRevisionCH');
        $notificacion = array(
            "not_EmpleadoID" => $empleado['emp_EmpleadoID'],
            "not_Titulo" => 'Solicitud de horas extra ' . $estatus,
            "not_Descripcion" => 'El departamento de Recursos Humanos a revisado tu solicitud de horas extra.',
            "not_EmpleadoIDCreo" => (int)session("id"),
            "not_FechaRegistro" => date('Y-m-d H:i:s'),
            "not_URL" => 'Incidencias/controlHorasExtra',
        );
        $builder = db()->table("notificacion");
        $builder->insert($notificacion);

        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            $data['code'] = 0;
        } else {
            $this->db->transCommit();
            $data['code'] = 1;
        }

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_revisarReporteHorasCH

    public function ajax_ReporteHorasExtraPagado()
    {
        $salidaID = (int)encryptDecrypt('decrypt', post("salidaID"));
        $accion = post("accion");
        $tipo = post("tipo");

        $this->db->transStart();

        $builder = db()->table("reportehoraextra");
        $builder->update(array(
            'rep_Estado' => $accion,
            'rep_TipoPago' => $tipo,
        ), array('rep_ReporteHoraExtraID' => $salidaID));

        $empleado = $this->db->query("SELECT E.emp_EmpleadoID,E.emp_Nombre,E.emp_Correo FROM reportehoraextra R JOIN empleado E ON E.emp_EmpleadoID=R.rep_EmpleadoID WHERE R.rep_ReporteHoraExtraID=" . $salidaID)->getRowArray();

        $notificacion = array(
            "not_EmpleadoID" => $empleado['emp_EmpleadoID'],
            "not_Titulo" => 'Horas extra pagadas',
            "not_Descripcion" => 'Se pagaron tus horas extra como ' . $tipo,
            "not_EmpleadoIDCreo" => (int)session("id"),
            "not_FechaRegistro" => date('Y-m-d H:i:s'),
            "not_URL" => 'Incidencias/controlHorasExtra',
        );
        $builder = db()->table("notificacion");
        $builder->insert($notificacion);


        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            $data['code'] = 0;
        } else {
            $this->db->transCommit();
            $data['code'] = 1;
        }

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_ReporteHorasExtraPagado

    public function ajax_declinarHorasExtra()
    {
        $reporteID = (int)encryptDecrypt('decrypt', post('reporteID'));

        $data = array(
            'rep_AproboID' => session('id'),
            'rep_Estado' => 'DECLINADO',
            'rep_ObservacionesCH' => post('obs'),
            'rep_TipoPago' => null
        );

        $builder = db()->table('reportehoraextra');
        $response = $builder->update($data, array('rep_ReporteHoraExtraID' => $reporteID));
        if ($response) {
            $data['code'] = 1;
        } else $data['code'] = 0;

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_declinarHorasExtra

    //Lia trae las fechas entre un perido de fechas
    public function ajaxGetDiasSemana()
    {
        $inicio = post('inicio');
        $fin = post('fin');

        $fechaInicio = strtotime($inicio);
        $fechaFin = strtotime($fin);

        $fechas = array();
        $f = array();
        for ($i = $fechaInicio; $i <= $fechaFin; $i += 86400) {
            $f['fecha'] = date("Y-m-d", $i);
            $f['nombreFecha'] = longDate(date("Y-m-d", $i), ' de ');
            array_push($fechas, $f);
        }

        $data['data'] = $fechas;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajaxGetDiasSemana

    //Elimina un reporte de salida
    public function ajax_deleteReporteSalidas()
    {
        $salidaID = (int)encryptDecrypt('decrypt', post("salidaID"));

        $builder = db()->table("reportesalida");
        $response = $builder->update(array('rep_Estatus' => 0), array('rep_ReporteSalidaID' => $salidaID));
        $data['code'] = $response ? 1 : 0;

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_deleteReporteSalidas

    //Lia->envia el reporte de salidas
    public function ajax_enviarReporteSalidas()
    {
        $salidaID = (int)encryptDecrypt('decrypt', post("salidaID"));
        $data['code'] = 0;

        $this->db->transStart();

        $empleado = $this->db->query("SELECT E.emp_EmpleadoID,E.emp_Nombre,E.emp_Jefe FROM reportesalida R JOIN empleado E ON E.emp_EmpleadoID=R.rep_EmpleadoID WHERE R.rep_ReporteSalidaID=" . $salidaID)->getRowArray();
        if (session('id') == 7) {
            $jefe = $this->db->query("SELECT E.emp_EmpleadoID,E.emp_Nombre, E.emp_Correo FROM empleado E WHERE E.emp_EmpleadoID=19")->getRowArray();
        } else {
            $jefe = $this->db->query("SELECT E.emp_EmpleadoID,E.emp_Nombre, E.emp_Correo FROM empleado E WHERE E.emp_Numero=" . $empleado['emp_Jefe'])->getRowArray();
        }

        $datos = array(
            'NombreSolicitante' => $empleado['emp_Nombre'],
            'NombreJefe' => $jefe['emp_Nombre'],
        );

        $builder = db()->table("reportesalida");
        $builder->update(array('rep_Estado' => 'PENDIENTE'), array('rep_ReporteSalidaID' => $salidaID));

        sendMail($jefe['emp_Correo'], 'Nuevo informe de salidas', $datos, 'InformeSalidas');

        $notificacion = array(
            "not_EmpleadoID" => $jefe['emp_EmpleadoID'],
            "not_Titulo" => 'Nuevo informe de salidas',
            "not_Descripcion" => 'Revisar informe de salidas',
            "not_EmpleadoIDCreo" => (int)session("id"),
            "not_FechaRegistro" => date('Y-m-d H:i:s'),
            "not_URL" => 'Incidencias/informeSalidasMisEmpleados'
        );
        $builder = db()->table("notificacion");
        $builder->insert($notificacion);

        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            $data['code'] = 0;
        } else {
            $this->db->transCommit();
            $data['code'] = 1;
        }

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_enviarReporteSalidas

    //Lia->Trae el informe de mis salidas
    public function ajax_getMisSalidas()
    {
        $empleadoID = (int)session("id");
        $model = new IncidenciasModel();
        $salidas = $model->getSalidassByEmpleado($empleadoID);
        $arrSalidas = array();
        $count = 1;
        foreach ($salidas as $salida) {
            $salida['rep_ReporteSalidaID'] = encryptDecrypt('encrypt', $salida['rep_ReporteSalidaID']);
            $salida['count'] = $count++;

            $dias = json_decode($salida['rep_Dias'], true);
            $txtDias = "";
            for ($i = 0; $i < count($dias); $i++) {
                $txtDias .= '<span class="badge badge-success">' . shortDate($dias[$i]['fecha']) . '</span><br>';
            }
            $salida['rep_Dias'] = $txtDias;

            array_push($arrSalidas, $salida);
        }
        $data['data'] = $arrSalidas;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_getMisSalidas


    //Lia->guarda el reporte de salidas
    public function ajaxAddReporteSalidas()
    {
        $post = $this->request->getPost();
        $dias = array();
        for ($i = 0; $i < count($post['fecha']); $i++) {
            $row = array(
                "fecha" => $post['fecha'][$i],
                "socap" => $post['socap'][$i],
                "objetivo" => $post['objetivo'][$i],
                "logros" => $post['logros'][$i]
            );
            array_push($dias, $row);
        }

        $semana = explode(' al ', $post['txtFechas']);
        $diaInicio = $semana[0];
        $diaFin = $semana[1];

        $reporte = array(
            'rep_FechaRegistro' => date('Y-m-d'),
            'rep_EmpleadoID' => (int)session('id'),
            'rep_Semana' => $post['txtFechas'],
            'rep_DiaInicio' => $diaInicio,
            'rep_DiaFin' => $diaFin,
            'rep_Dias' => json_encode($dias),
        );

        $builder = db()->table("reportesalida");
        $builder->insert($reporte);
        $data['code'] = $this->db->insertID() ? 1 : 0;

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajaxAddReporteSalidas

    //Lia-> salidas de mis empleados
    public function ajax_getSalidasMisEmpleados()
    {
        $empleadoID = (int)session("numero");
        $model = new IncidenciasModel();
        $salidas = $model->getSalidasMisEmpleados($empleadoID);
        $arrSalidas = array();
        $count = 1;
        foreach ($salidas as $salida) {
            $salida['rep_ReporteSalidaID'] = encryptDecrypt('encrypt', $salida['rep_ReporteSalidaID']);
            $salida['count'] = $count++;
            $dias = json_decode($salida['rep_Dias'], true);

            $txtDias = "";
            for ($i = 0; $i < count($dias); $i++) {
                $txtDias .= '<span class="badge badge-success">' . shortDate($dias[$i]['fecha']) . '</span><br>';
            }
            $salida['rep_Dias'] = $txtDias;

            array_push($arrSalidas, $salida);
        }
        $data['data'] = $arrSalidas;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_getSalidasMisEmpleados

    //Lia->Jefe revisa el reporte de salidas
    public function ajax_revisarReporteSalidas()
    {
        $salidaID = (int)encryptDecrypt('decrypt', post("salidaID"));
        $accion = post("accion");

        if ($accion === 'AUTORIZAR') $estatus = 'AUTORIZADO';
        else $estatus = 'RECHAZADO';

        $observaciones = post("observaciones");

        $this->db->transStart();

        $builder = db()->table("reportesalida");
        $builder->update(array('rep_Estado' => $estatus, 'rep_AutorizoID' => session('id'), 'rep_ObservacionesRJ' => $observaciones), array('rep_ReporteSalidaID' => $salidaID));

        $empleado = $this->db->query("SELECT E.emp_EmpleadoID,E.emp_Nombre,E.emp_Jefe FROM reportesalida R
        JOIN empleado E ON E.emp_EmpleadoID=R.rep_EmpleadoID
        WHERE R.rep_ReporteSalidaID=" . $salidaID)->getRowArray();

        $jefe = $this->db->query("SELECT E.emp_EmpleadoID,E.emp_Nombre, emp_Correo FROM empleado E
            WHERE E.emp_Numero=" . $empleado['emp_Jefe'])->getRowArray();

        $datos = array(
            'NombreSolicitante' => $empleado['emp_Nombre'],
            'NombreJefe' => $jefe['emp_Nombre'],
            'accion' => $estatus,
        );

        if ($estatus === 'AUTORIZADO') {
            sendMail($empleado['emp_Correo'], 'Informe de salidas Autorizado', $datos, 'InformeSalidasRevisionJefe');
            $ch = $this->db->query("SELECT emp_Nombre,emp_Correo,emp_EmpleadoID FROM empleado WHERE emp_Rol=1")->getResultArray();
            foreach($ch as $c){
                $notificacion = array(
                    "not_EmpleadoID" => $c['emp_EmpleadoID'],
                    "not_Titulo" => 'Reporte de salidas por aplicar',
                    "not_Descripcion" => 'Revisar el reporte de '.$empleado['emp_Nombre'],
                    "not_EmpleadoIDCreo" => (int)session("id"),
                    "not_FechaRegistro" => date('Y-m-d H:i:s'),
                    "not_URL" => 'Incidencias/aplicarInformeSalidas',
                );
                $builder = db()->table("notificacion");
                $builder->insert($notificacion);
            }
        } else {
            sendMail($empleado['emp_Correo'], 'Informe de salidas Rechazado', $datos, 'InformeSalidasRevisionJefe');
        }

        $notificacion = array(
            "not_EmpleadoID" => $empleado['emp_EmpleadoID'],
            "not_Titulo" => 'Informe de salidas ' . $estatus,
            "not_Descripcion" => 'El informe de salidas ha sido revisado.',
            "not_EmpleadoIDCreo" => (int)session("id"),
            "not_FechaRegistro" => date('Y-m-d H:i:s'),
            "not_URL" => 'Incidencias/reporteSalidas',
        );
        $builder = db()->table("notificacion");
        $builder->insert($notificacion);

        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            $data['code'] = 0;
        } else {
            $this->db->transCommit();
            $data['code'] = 1;
        }

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end revisarreporte

    //Lista de salidas a aplicar
    public function ajax_getInformesSalidas()
    {
        $model = new IncidenciasModel();
        $salidas = $model->getInformesSalidas();
        $arrSalidas = array();
        $count = 1;
        foreach ($salidas as $salida) {
            $salida['rep_ReporteSalidaID'] = encryptDecrypt('encrypt', $salida['rep_ReporteSalidaID']);
            $salida['count'] = $count++;
            $dias = json_decode($salida['rep_Dias'], true);

            $txtDias = "";
            for ($i = 0; $i < count($dias); $i++) {
                $txtDias .= '<span class="badge badge-success">' . shortDate($dias[$i]['fecha']) . '</span><br>';
            }
            $salida['totalDias'] =  $i;
            $salida['rep_Dias'] = $txtDias;

            //Si correponde el bono
            //$salida['estimulo'] = estimuloSalidas($i) . '%';

            array_push($arrSalidas, $salida);
        }
        $data['data'] = $arrSalidas;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_getInformesSalidas

    //Diego->CH revisa salidas
    public function ajax_revisarReporteSalidasCH()
    {
        $salidaID = (int)encryptDecrypt('decrypt', post("salidaID"));
        $accion = post("accion");

        if ($accion === 'APLICAR') $estatus = 'APLICADO';
        else $estatus = 'RECHAZADO_RH';

        $observaciones = post("observaciones");

        $this->db->transStart();

        $builder = db()->table("reportesalida");
        $builder->update(array(
            'rep_Estado' => $estatus,
            'rep_ObservacionesRCH' => $observaciones,
            'rep_AproboID' => session('id')
        ), array('rep_ReporteSalidaID' => $salidaID));

        $empleado = $this->db->query("SELECT E.emp_EmpleadoID,E.emp_Nombre,E.emp_Correo FROM reportesalida R
        JOIN empleado E ON E.emp_EmpleadoID=R.rep_EmpleadoID
        WHERE R.rep_ReporteSalidaID=" . $salidaID)->getRowArray();

        if ($estatus === 'APLICADO') {
            $datos = array(
                'NombreSolicitante' => $empleado['emp_Nombre'],
                'accion' => 'APLICADO',
            );
            sendMail($empleado['emp_Correo'], 'Informe de salidas Aplicado', $datos, 'InformeSalidasRevisionCH');
        } else {
            $datos = array(
                'NombreSolicitante' => $empleado['emp_Nombre'],
                'accion' => 'RECHAZADO',
            );
            sendMail($empleado['emp_Correo'], 'Informe de salidas Rechazado', $datos, 'InformeSalidasRevisionCH');
        }

        $notificacion = array(
            "not_EmpleadoID" => $empleado['emp_EmpleadoID'],
            "not_Titulo" => 'Informe de salidas ' . $estatus,
            "not_Descripcion" => 'El informe de salidas ha sido revisado.',
            "not_EmpleadoIDCreo" => (int)session("id"),
            "not_FechaRegistro" => date('Y-m-d H:i:s'),
        );
        $builder = db()->table("notificacion");
        $builder->insert($notificacion);

        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            $data['code'] = 0;
        } else {
            $this->db->transCommit();
            $data['code'] = 1;
        }

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_revisarReporteSalidasCH

    //Diego-> obtener vacaciones y horas extra empleados
    public function ajax_getReporteVacacionesHorasEmpleados()
    {
        $model = new IncidenciasModel();
        $empleados = $model->getEmpleados();
        $model2 = new UsuarioModel();
        $dataReporte = array();
        foreach ($empleados as $empleado) {
            $horasExtra = $model2->getHorasExtraByEmpleadoID($empleado['emp_EmpleadoID']);

            $empleado['vacaciones'] = diasPendientes($empleado['emp_EmpleadoID']);
            $empleado['ingreso'] = $empleado['emp_FechaIngreso'];
            $empleado['sucursal'] = $empleado['suc_Sucursal'];
            $empleado['horas'] = $horasExtra;
            array_push($dataReporte, $empleado);
        }
        $data['data'] = $dataReporte;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_getReporteVacacionesHorasEmpleados

    //Lia-> trae las cooperativas para las salidas
    public function ajaxGetSocaps()
    {
        $model = new IncidenciasModel();
        $sucursales = $model->getSucursal();
        $data = array();
        foreach ($sucursales as $s) {
            unset($s['suc_Estatus']);
            unset($s['suc_EmpleadoID']);
            array_push($data, $s);
        }
        $data['data'] = $data;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    //HUGO->ELiminar permiso
    public function ajax_deletePermiso()
    {
        $permisoID = (int)encryptDecrypt('decrypt', post("permisoID"));
        $builder = db()->table("permiso");
        $response = $builder->update(array("per_Estatus" => 0), array("per_PermisoID" => $permisoID));
        $data['code'] = $response ? 1 : 0;

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_deletePermiso

    public function ajax_GetReportesAsistencia()
    {
        $url = FCPATH . "/assets/uploads/reporteAsistencia/";
        if (!file_exists($url)) mkdir($url, 0777, true);
        $anios = preg_grep('/^([^.])/', scandir($url));
        $tree = array();
        foreach ($anios as $anio) {
            $meses = preg_grep('/^([^.])/', scandir($url . "/" . $anio));

            $children = array();

            foreach ($meses as $mes) {
                $urlD = base_url("/assets/uploads/reporteAsistencia/" . $anio . '/' . $mes . "/reporteAsistencia.xlsx");
                $itemp = array(
                    "id" => $anio . $mes,
                    "text" => numMeses($mes),
                    "icon" => "mdi mdi-zip-box ",
                    "state" => array(
                        "opened" => false,
                        "disabled" => false,
                    ),
                    "a_attr" => array("href" => $urlD),
                    "li_attr" => array("tipo" => "periodo"),
                );
                array_push($children, $itemp);
            }

            $node = array(
                "text" => $anio,
                "state" => array(
                    "opened" => true,
                    "disabled" => false,
                    "selected" => false,
                ),
                "children" => $children,
                "li_attr" => array("tipo" => "year")
            );
            array_push($tree, $node);
        }
        echo json_encode($tree);
    }

    public function ajax_getReporteVacacionesPeriodo(){
        $vacacionesEmp = db()->query("SELECT E.emp_Numero, E.emp_Nombre, GROUP_CONCAT(DISTINCT CONCAT_WS(' al ', V.vac_FechaInicio, V.vac_FechaFin) ORDER BY V.vac_FechaInicio SEPARATOR ', ') AS 'fechas', SUM(V.vac_Disfrutar) AS 'dias_totales', V.vac_Periodo
        FROM vacacion V
        JOIN empleado E ON E.emp_EmpleadoID = V.vac_EmpleadoID
        WHERE V.vac_Estatus NOT IN ('RECHAZADO', 'DECLINADO') AND V.vac_Estado = 1
        GROUP BY E.emp_Numero, E.emp_Nombre, V.vac_Periodo")->getResultArray();
        $dataReporte=array();
        foreach($vacacionesEmp as $ve){
            array_push($dataReporte,$ve);
        }
        $data['data'] = $dataReporte;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    /* CRON JOB*/
    public function actualizarDiasVacaciones()
    {
        $acumula = getSetting('acumula_vacaciones', $this);
        $builder = db()->table("vacacionempleado");

        $empleados = $this->db->query("SELECT emp_EmpleadoID,DATE_FORMAT(emp_FechaIngreso,'%m-%d') as 'fechaingreso',emp_FechaIngreso  FROM empleado WHERE MONTH(emp_FechaIngreso)=? AND emp_Estatus=1",array(date('m')))->getResultArray();
        foreach ($empleados as $e) {
            $vacaciones = $this->db->query("SELECT * FROM vacacionempleado WHERE vace_EmpleadoID=" . $e['emp_EmpleadoID'])->getRowArray();
            if (!empty($vacaciones)) {
                if ($e['fechaingreso'] === date('m-d')) {
                    $data = array();
                    switch ($acumula) {
                        case '1':
                            $data["vace_Dias"] = $vacaciones['vace_Dias'] + diasLey($e['emp_FechaIngreso']);
                            break;
                        case '0':
                            $data["vace_Dias"] = diasLey($e['emp_FechaIngreso']);
                            break;
                    }
                    $data["vace_FechaActualizacion"] = date('Y-m-d H:i:s');
                    $builder->update($data, array('vace_EmpleadoID' => $e['emp_EmpleadoID']));
                }
            } else {
                $data = array(
                    "vace_EmpleadoID" => $e['emp_EmpleadoID'],
                    "vace_Dias" => 0,
                    "vace_FechaActualizacion" => date('Y-m-d H:i:s'),
                );
                $builder->insert($data);
            }
        }
    }

    public function actualizarDiasVacacionesEspecifico()
    {
        $acumula = getSetting('acumula_vacaciones', $this);
        $builder = db()->table("vacacionempleado");

        $empleados = $this->db->query("SELECT * FROM empleado WHERE emp_EmpleadoID IN (65,83,93,101)")->getResultArray();
        foreach ($empleados as $e) {
            $vacaciones = $this->db->query("SELECT * FROM vacacionempleado WHERE vace_EmpleadoID=" . $e['emp_EmpleadoID'])->getRowArray();
            if (!empty($vacaciones)) {
                //if ($e['fechaingreso'] === date('m-d')) {
                    $data = array();
                    switch ($acumula) {
                        case '1':
                            $data["vace_Dias"] = $vacaciones['vace_Dias'] + diasLey($e['emp_FechaIngreso']);
                            break;
                        case '0':
                            $data["vace_Dias"] = diasLey($e['emp_FechaIngreso']);
                            break;
                    }
                    $data["vace_FechaActualizacion"] = date('Y-m-d H:i:s');
                    $builder->update($data, array('vace_EmpleadoID' => $e['emp_EmpleadoID']));
                //}
            } else {
                $data = array(
                    "vace_EmpleadoID" => $e['emp_EmpleadoID'],
                    "vace_Dias" => 0,
                    "vace_FechaActualizacion" => date('Y-m-d H:i:s'),
                );
                $builder->insert($data);
            }
        }
    }
    /* NO TOCAR CRON JOB */
}//end controller
