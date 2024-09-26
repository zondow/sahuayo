<?php

namespace App\Controllers;

defined('FCPATH') or exit('No direct script access allowed');

class Incidencias extends BaseController
{


    /*
     __      _______  _____ _______        _____
     \ \    / /_   _|/ ____|__   __|/\    / ____|
      \ \  / /  | | | (___    | |  /  \  | (___
       \ \/ /   | |  \___ \   | | / /\ \  \___ \
        \  /   _| |_ ____) |  | |/ ____ \ ____) |
         \/   |_____|_____/   |_/_/    \_\_____/
    */

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
        $data['idEmpleado'] = encryptDecrypt('encrypt', session('id'));
        $data['empleado'] = $empleado = $this->IncidenciasModel->getInfoEmpleado(session('id'));
        $data['diasLey'] = diasLey($empleado['emp_FechaIngreso']);
        $data['diasRestantes'] = diasPendientes(session('id'));
        $data['registros'] = $this->IncidenciasModel->getRegistrosByEmpleadoID();

        load_plugins(['daterangepicker', 'datatables_buttons', 'sweetalert2'], $data);

        //Custom
        $data['scripts'][] = base_url('assets/js/modalPdf.js');
        $data['scripts'][] = base_url('assets/js/incidencias/misVacaciones.js');

        echo view("htdocs/header", $data);
        echo view("incidencias/formVacaciones");
        echo view('htdocs/modalPdf');
        echo view("htdocs/footer");
    } //end misVacaciones

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
        $data['listVacaciones'] = $this->IncidenciasModel->getVacacionesEmpleadosJefe(session('numero'));

        load_plugins(['datatables_buttons', 'moment', 'fullcalendar', 'sweetalert2'], $data);

        //Custom Styles
        $data['styles'][] = base_url('assets/css/tables-custom.css');
        //Custom Scripts
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
    public function listVacaciones()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        //Titulo
        $data['title'] = 'Aplicar vacaciones';
        //Breadcrumbs
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Aplicar vacaciones', "link" => base_url('Incidencias/listVacaciones'), "class" => "active"),
        );

        $data['listVacaciones'] = $this->IncidenciasModel->getListVacaciones(array("AUTORIZADO",  "AUTORIZADO_RH", "DECLINADO", "RECHAZADO"));

        load_plugins(['sweetalert2', 'datatables_buttons'], $data);
        $data['styles'][] = base_url('assets/css/tables-custom.css');

        //Custom
        $data['scripts'][] = base_url('assets/js/modalPdf.js');
        $data['scripts'][] = base_url('assets/js/incidencias/listVacaciones.js');

        echo view("htdocs/header", $data);
        echo view("incidencias/listVacaciones");
        echo view('htdocs/modalPdf');
        echo view("htdocs/footer");
    } //end listVacaciones

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
        $data['empleado'] = $empleado = $this->IncidenciasModel->getInfoEmpleado(session('id'));
        $data['diasLey'] = diasLey($empleado['emp_FechaIngreso']);
        $data['diasRestantes'] = diasPendientes(session('id'));
        $data['registros'] = $this->IncidenciasModel->getVacacionesHorasByEmpleadoID(session('id'));
        $data['horasExtra'] = $this->BaseModel->getHorasExtra(session('id'));

        load_plugins(['daterangepicker', 'datatables_buttons', 'sweetalert2'], $data);

        //Custom
        $data['scripts'][] = base_url('assets/js/modalPdf.js');
        $data['scripts'][] = base_url('assets/js/incidencias/misHorasVacaciones.js');

        echo view("htdocs/header", $data);
        echo view("incidencias/formVacacionesHoras");
        echo view('htdocs/modalPdf');
        echo view("htdocs/footer");
    } //end cambioVacacionesHoras

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

        $data['listVacaciones'] = $this->IncidenciasModel->getListVacacionesHoras();

        load_plugins(['sweetalert2', 'datatables_buttons'], $data);

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

        $data['empleado'] = $this->IncidenciasModel->getInfoEmpleado(session('id'));
        $data['catalogoPermisos'] = $this->IncidenciasModel->getCatalogoPermisos();
        $data['horasExtra'] = $this->BaseModel->getHorasExtra(session('id'));
        $data['horasAdministrativas'] = $this->BaseModel->getHorasAdministrativas(session('id'));

        load_plugins(['datatables_buttons', 'sweetalert2', 'select2', 'daterangepicker',], $data);

        $data['scripts'][] = base_url("assets/js/incidencias/permisos.js");
        $data['scripts'][] = base_url("assets/js/modalPdf.js");

        //Vistas
        echo view('htdocs/header', $data);
        echo view('incidencias/formPermiso', $data);
        echo view('htdocs/modalPdf', $data);
        echo view('htdocs/footer', $data);
    } //misPermisos


    //Diego-> Lista de solicitues de permisos de sus empleados
    public function permisosMisEmpleados()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Autorizar permisos';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "");
        $data['breadcrumb'][] = array("titulo" => 'Autorizar permisos', "link" => base_url('Permiso/permisosMisEmpleados'), "class" => "active");

        load_plugins(['chosen', 'daterangepicker', 'datatables_buttons', 'sweetalert2'], $data);

        //Custom Styles
        //Custom Scripts
        $data['scripts'][] = base_url("assets/js/modalPdf.js");

        $data['scripts'][] = base_url("assets/js/incidencias/autorizarPermisos.js");

        //Vistas
        echo view('htdocs/header', $data);
        echo view('incidencias/autorizarPermisos', $data);
        echo view('htdocs/modalPdf', $data);
        echo view('incidencias/modalesPermiso', $data);
        echo view('htdocs/footer', $data);
    } //end permisosMisEmpleados

    //Diego-> Generar Permisos
    public function aplicarPermisos()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Aplicar permisos';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "");
        $data['breadcrumb'][] = array("titulo" => 'Aplicar permisos', "link" => base_url('Permiso/aplicarPermisos'), "class" => "active");

        load_plugins(['chosen', 'datatables_buttons', 'sweetalert2'], $data);

        //Custom Styles
        //Custom Scripts
        $data['scripts'][] = base_url("assets/js/modalPdf.js");
        $data['scripts'][] = base_url("assets/js/aplicarPermisos.js");

        //Vistas
        echo view('htdocs/header', $data);
        echo view('incidencias/aplicarPermisos', $data);
        echo view('htdocs/modalPdf', $data);
        echo view('htdocs/footer', $data);
    } //aplicarPermisos

    //Lia->reporte de asistencias
    public function reporteAsistencia()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Reporte de asistencia';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "");
        $data['breadcrumb'][] = array("titulo" => 'Reporte de asistencia', "link" => base_url('Incidencias/reporteAsistencia'), "class" => "active");

        load_plugins(['daterangepicker', 'jstree'], $data);

        //Custom Scripts
        $data['scripts'][] = base_url("assets/js/incidencias/reporteAsistencia.js");

        //Vistas
        echo view('htdocs/header.php', $data);
        echo view('incidencias/formReporteAsistencia', $data);
        echo view('htdocs/footer.php', $data);
    }


    //Diego ->El empleado registra sus horas extra
    public function controlHorasExtra()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Control de horas extra';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "");
        $data['breadcrumb'][] = array("titulo" => 'Control de horas extra', "link" => base_url('Incidencias/controlHorasExtra'), "class" => "active");

        $data['empleado'] = $this->BaseModel->getEmpleadoByID(session('id'));

        load_plugins(['moment', 'moment_locales', 'chosen', 'daterangepicker', 'datatables_buttons', 'sweetalert2', 'bootstrapdatetimepicker'], $data);

        //Custom Styles
        //Custom Scripts
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

        load_plugins(['datatables_buttons', 'sweetalert2'], $data);

        //Custom Scripts
        //Custom Scripts
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

        load_plugins(['datatables_buttons', 'sweetalert2'], $data);

        //Custom Scripts
        //Custom Scripts
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

        $data['sucursales'] = $this->BaseModel->getSucursales();

        load_plugins(['moment', 'moment_locales', 'datatables_buttons', 'sweetalert2', 'datetimepicker', 'datepicker', 'select2'], $data);

        //Custom Scripts

        //Custom Scripts
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

        load_plugins(['datatables_buttons', 'sweetalert2', 'modalPdf'], $data);

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

        load_plugins(['datatables_buttons', 'sweetalert2', 'modalPdf'], $data);

        //Custom Scripts
        //Custom Scripts
        $data['scripts'][] = base_url("assets/js/incidencias/aplicarInformeSalidas.js");

        //Vistas
        echo view('htdocs/header', $data);
        echo view('incidencias/aplicarInformesSalidas', $data);
        echo view('htdocs/modalPdf');
        echo view('htdocs/footer', $data);
    } //end aplicarInformeSalidas

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
        $data['incapacidades'] = revisarPermisos('Autorizar', 'incapacidad') ? $this->IncidenciasModel->getIncapacidades() : $this->IncidenciasModel->getIncapacidadesByEmpleado(session('id'));

        load_plugins(['sweetalert2', 'select2', 'datatables_buttons', 'daterangepicker', 'lightbox', 'filestyle', 'modalPdf'], $data);

        //$data['scripts'][] = base_url("assets/js/modalRechazoJustificacion.js");
        $data['scripts'][] = base_url("assets/js/incidencias/incapacidades.js");

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('incidencias/incapacidades');
        echo view('htdocs/modalPdf');
        //echo view('htdocs/modalRechazoJustificacion');
        echo view('htdocs/footer');
    } //end incapacidad

    public function incapacidadesMisEmpleados()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Ver incapacidades de colaboradores';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "");
        $data['breadcrumb'][] = array("titulo" => 'Revisar sanciones', "link" => base_url('Incidencias/incapacidadesMisEmpleados'), "class" => "active");

        //Data
        $data['empleados'] = $this->BaseModel->getEmpleados();
        $data['incapacidades'] = $this->IncidenciasModel->getIncapacidadesMisColaboradores();

        load_plugins(['sweetalert2', 'datatables_buttons', 'lightbox', 'datepicker', 'select2', 'modalPdf'], $data);

        //Styles
        $data['styles'][] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/css/fileinput.css"; //Bootstrap 
        //Scripts

        $data['scripts'][] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/fileinput.js"; //Bootstrap 
        $data['scripts'][] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/locales/es.js"; //Bootstrap 
        $data['scripts'][] = base_url("assets/js/incidencias/incapacidadesMisEmpleados.js");

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('incidencias/incapacidadesMisEmpleados', $data);
        echo view('htdocs/modalPdf');
        echo view('htdocs/footer', $data);
    }

    //Lia->aplicar incapacidades
    public function incapacidad()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Revisar solicitudes de incapacidad';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "");
        $data['breadcrumb'][] = array("titulo" => 'Revisar solicitudes de incapacidad', "link" => base_url('Incidencias/revisarIncapacidades'), "class" => "active");

        load_plugins(['datatables_buttons', 'sweetalert2', 'modalPdf'], $data);

        //Custom Scripts
        //Custom Scripts
        $data['scripts'][] = base_url("assets/js/incidencias/revisarIncapacidades.js");

        //Vistas
        echo view('htdocs/header', $data);
        echo view('incidencias/revisarIncapacidades', $data);
        echo view('htdocs/modalPdf');
        echo view('htdocs/footer', $data);
    } //end incapacidades

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
        $data['empleados'] = $this->BaseModel->getEmpleados();
        $data['actas'] = $this->IncidenciasModel->getActasAdministrativasByColaborador(session('id'));

        load_plugins(['sweetalert2', 'datatables_buttons', 'lightbox', 'datepicker', 'select2', 'modalPdf'], $data);

        //sweetalert2
        $data['styles'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.css');
        $data['scripts'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.js');

        //Styles
        //Scripts
        $data['scripts'][] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/fileinput.js"; //Bootstrap FileInput
        $data['scripts'][] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/locales/es.js"; //Bootstrap FileInput Spanish
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
        $data['empleados'] = $this->BaseModel->getEmpleados();
        $data['actas'] = $this->IncidenciasModel->getActasAdministrativasMisColaboradores();
        load_plugins(['sweetalert2', 'datatables_buttons', 'lightbox', 'datepicker', 'select2', 'modalPdf'], $data);

        //Styles
        $data['styles'][] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/css/fileinput.css"; //Bootstrap FileInput
        //Scripts
        $data['scripts'][] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/fileinput.js"; //Bootstrap FileInput
        $data['scripts'][] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/locales/es.js"; //Bootstrap FileInput Spanish
        $data['scripts'][] = base_url("assets/js/incidencias/sancionesMisEmpleados.js");

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('incidencias/sancionesMisEmpleados', $data);
        echo view('htdocs/modalPdf');
        echo view('htdocs/footer', $data);
    }

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
        $data['empleados'] = $this->BaseModel->getEmpleados();
        $data['actas'] = $this->IncidenciasModel->getActasAdministrativas();

        load_plugins(['sweetalert2', 'datatables_buttons', 'lightbox', 'datepicker', 'select2', 'modalPdf'], $data);

        //Styles
        $data['styles'][] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/css/fileinput.css"; //Bootstrap FileInput
        //Scripts
        $data['scripts'][] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/fileinput.js"; //Bootstrap FileInput
        $data['scripts'][] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/locales/es.js"; //Bootstrap FileInput Spanish
        $data['scripts'][] = base_url("assets/js/incidencias/sanciones.js");

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('incidencias/actasAdministrativas');
        echo view('htdocs/modalPdf');
        echo view('htdocs/footer');
    } //end actasAdministrativas

    /*
      ______ _    _ _   _  _____ _____ ____  _   _ ______  _____
     |  ____| |  | | \ | |/ ____|_   _/ __ \| \ | |  ____|/ ____|
     | |__  | |  | |  \| | |      | || |  | |  \| | |__  | (___
     |  __| | |  | | . ` | |      | || |  | | . ` |  __|  \___ \
     | |    | |__| | |\  | |____ _| || |__| | |\  | |____ ____) |
     |_|     \____/|_| \_|\_____|_____\____/|_| \_|______|_____/
    */

    //Diego -> Registra las vacaciones
    public function crearVacaciones()
    {
        $post = $this->request->getPost();
        $post['dias'] = calculoDias(0, session('sucursal'), $post['vac_FechaInicio'], $post['vac_FechaFin'], session('id'));

        //if ($post['dias'] <= $post['diasRestantes']) {
        if (crearVacaciones($post)) {
            $builder = db()->table("empleado");
            $empleado = $builder->getWhere(array("emp_EmpleadoID" => session('id')))->getRowArray();
            $jefe = session('id') == 7 ? $this->BaseModel->getEmpleadoByID(19) : $this->BaseModel->getEmpleadoByNumero($empleado['emp_Jefe']);

            $datos = array();

            $datos['titulo'] = 'Solicitud de Vacaciones';
            $datos['nombre'] = $jefe['emp_Nombre'];
            $datos['cuerpo'] = 'Mediante el presente se le comunica que el colaborador a su cargo ' . $empleado['emp_Nombre'] . ', ha registrado una nueva solicitud de vacaciones en la plataforma PEOPLE.<br> Para mayor información, revise la solicitud de vacaciones en la plataforma.';

            //Enviar correo
            if (sendMail($jefe['emp_Correo'], 'Nueva solicitud de vacaciones', $datos)) {

                $notificacion = array(
                    "not_EmpleadoID" => $jefe['emp_EmpleadoID'],
                    "not_Titulo" => 'Nueva solicitud de vacaciones',
                    "not_Descripcion" => 'El colaborador ' . $empleado['emp_Nombre'] . ' ha solicitado vacaciones.',
                    "not_EmpleadoIDCreo" => (int)session("id"),
                    "not_FechaRegistro" => date('Y-m-d H:i:s'),
                    "not_URL" => 'Incidencias/vacacionesMisEmpleados',
                    "not_Icono" => 'zmdi zmdi-flight-takeoff',
                    "not_Color" => 'bg-amber',
                );
                insert('notificacion', $notificacion);
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

        $idVacaciones = insert('vacacionhoras', $data);

        $colaborador = $this->IncidenciasModel->getInfoEmpleado(session('id'));
        if ($idVacaciones > 0) {
            if (actualizarVacacion(session('id'), $post['diasRestantes'] - $post['diasVacaciones'])) {
                $builder = db()->table("empleado");
                $empleado = $this->BaseModel->getRH();
                foreach ($empleado as $emp) {
                    $notificacion = array(
                        "not_EmpleadoID" => $emp['emp_EmpleadoID'],
                        "not_Titulo" => 'Nueva solicitud de horas',
                        "not_Descripcion" => 'El colaborador ' . $colaborador['emp_Nombre'] . ' ha solicitado horas.',
                        "not_EmpleadoIDCreo" => (int)session("id"),
                        "not_FechaRegistro" => date('Y-m-d H:i:s'),
                        "not_URL" => 'Incidencias/aplicarCambioHorasVac',
                        'not_Icono' => 'zmdi zmdi-time-countdown',
                        "not_Color" => 'bg-blue',
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

    //Diego->Agregar una incapacidad
    public function addIncapacidad()
    {
        $post = $this->request->getPost();
        $fechaFin = date('Y-m-d', strtotime($post['fechaInicio'] . '+' . ($post['diasIncapacidad'] - 1) . ' days'));

        // Datos de la incapacidad
        $data_incapacidad = [
            "inc_FechaRegistro" => date("Y-m-d"),
            "inc_EmpleadoID" => session('id'),
            "inc_FechaInicio" => $post['fechaInicio'],
            "inc_FechaFin" => $fechaFin,
            "inc_Motivos" => $post['motivos'],
            "inc_Folio" => $post['folio'],
            "inc_Dias" => $post['diasIncapacidad'],
            "inc_Tipo" => $post['tipoEnfermedad'],
        ];

        // Manejo de archivo de incapacidad
        if (isset($_FILES['archivo'])) {
            $directorio = FCPATH . "/assets/uploads/incapacidades/" . session('id') . "/";
            if (!file_exists($directorio)) mkdir($directorio, 0777, true);

            $nombre_archivo = date("Ymd") . $_FILES['archivo']['name'];
            if (move_uploaded_file($_FILES['archivo']['tmp_name'], $directorio . $nombre_archivo)) {
                $data_incapacidad['inc_Archivo'] = $nombre_archivo;
            }
        }

        // Insertar incapacidad
        $result = insert('incapacidad', $data_incapacidad);
        if ($result) {
            insertLog($this, session('id'), 'Insertar', 'incapacidad', $result);
            $empleado = $this->BaseModel->getEmpleadoByID(session('id'));
            $rrhh = $this->BaseModel->getRH(session('id'));

            // Notificar a RRHH y enviar correos
            foreach ($rrhh as $rh) {
                $notificacion = [
                    "not_EmpleadoID" => $rh['emp_EmpleadoID'],
                    "not_Titulo" => 'Incapacidad registrada',
                    "not_Descripcion" => 'Revisar la solicitud de ' . session("nombre"),
                    "not_EmpleadoIDCreo" => session("id"),
                    "not_FechaRegistro" => date('Y-m-d H:i:s'),
                    "not_URL" => 'Incidencias/incapacidad',
                    "not_Icono" => 'zmdi zmdi-hospital-alt',
                    "not_Color" => 'bg-blue',
                ];
                insert('notificacion', $notificacion);
                sendMail($rh['emp_Correo'], 'Incapacidad registrada', [
                    'titulo' => 'Incapacidad registrada',
                    'cuerpo' => 'El colaborador ' . $empleado['emp_Nombre'] . ' ha registrado una incapacidad.',
                    'nombre' => $rh['emp_Nombre'],
                ], 'Incapacidad');
            }

            // Notificar al jefe
            $jefe = $this->BaseModel->getEmpleadoByNumero($empleado['emp_Jefe']);
            insert('notificacion', [
                "not_EmpleadoID" => $jefe['emp_EmpleadoID'],
                "not_Titulo" => 'Una incapacidad ha sido registrada',
                "not_Descripcion" => 'El colaborador ' . session("nombre") . ' registró una incapacidad',
                "not_EmpleadoIDCreo" => session("id"),
                "not_FechaRegistro" => date('Y-m-d H:i:s'),
                "not_URL" => 'Incidencias/incapacidadesMisEmpleados',
                "not_Icono" => 'zmdi zmdi-hospital-alt',
                "not_Color" => 'bg-blue',
            ]);

            $this->session->setFlashdata('response', 'success');
            $this->session->setFlashdata('txttoastr', '¡Incapacidad registrada correctamente!');
        } else {
            $this->session->setFlashdata('response', 'error');
            $this->session->setFlashdata('txttoastr', '¡Ocurrió un error al registrar la incapacidad!');
        }

        return redirect()->to($_SERVER['HTTP_REFERER']);
    }
    //end addIncapacidad
    // Lia->Crea un acta administrativa
    public function addActaAdministrativa()
    {
        $post = $this->request->getPost();
        $data_acta = [
            "act_FechaRegistro" => date('Y-m-d'),
            "act_FechaRealizo" => $post['fecha'],
            "act_EmpleadoID" => $post['empleado'],
            "act_RealizoID" => session('id'),
            "act_Tipo" => $post['tipo'],
            "act_Observaciones" => $post['observaciones'],
        ];

        // Manejo del archivo de acta
        if (isset($_FILES['archivo'])) {
            $directorio = FCPATH . "/assets/uploads/actasadmin/";
            if (!is_dir($directorio)) mkdir($directorio, 0777, true);

            $nombre_archivo = $_FILES['archivo']['name'];
            $ruta = $directorio . date("Ymd") . $nombre_archivo;
            if (move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta)) {
                $data_acta['act_Documento'] = date("Ymd") . $nombre_archivo;
            }
        }

        $this->db->transStart();

        $result = insert('actaadministrativa', $data_acta);

        // Mensaje de éxito o error
        $flashData = $result
            ? ['response' => 'success', 'txttoastr' => '¡Sanción registrada correctamente!']
            : ['response' => 'error', 'txttoastr' => '¡Ocurrió un error al registrar, por favor intente de nuevo!'];
        $this->session->setFlashdata($flashData);

        // Notificación
        if ($result) {
            $empleado = $this->IncidenciasModel->getEmpleadoByActaAdministrativaID($result);
            $notificacion = [
                "not_EmpleadoID" => $empleado['emp_EmpleadoID'],
                "not_Titulo" => 'Se le ha generado una sanción',
                "not_Descripcion" => 'Ha recibido una sanción: ' . $data_acta["act_Tipo"],
                "not_EmpleadoIDCreo" => (int)session("id"),
                "not_FechaRegistro" => date('Y-m-d H:i:s'),
                "not_URL" => 'Incidencias/misSanciones',
                'not_Color' => 'bg-red',
                'not_Icono' => 'zmdi zmdi-card-alert',
            ];
            insert('notificacion', $notificacion);

            $datos = [
                'titulo' => 'Ha recibido una sanción',
                'cuerpo' => 'Mediante el presente se le comunica que se le ha generado una sanción del tipo: <b>' . $data_acta["act_Tipo"] . '</b>.<br><br>Para mayor información, ingrese a la plataforma PEOPLE.',
                'nombre' => $empleado['emp_Nombre'],
            ];
            sendMail($empleado['emp_Correo'], 'Ha recibido ' . $data_acta["act_Tipo"], $datos, 'Sanción');
        }

        $this->db->transStatus() === false ? $this->db->transRollback() : $this->db->transCommit();

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

    //Lia -> Elimina una solicitud de vacaciones
    public function ajax_eliminarVacaciones()
    {
        $idVacacion = encryptDecrypt('decrypt', post('vacacionID'));
        $vacacion = $this->IncidenciasModel->getVacacion($idVacacion);
        $idEmpleado = $vacacion['vac_EmpleadoID'];
        rechazarVacaciones($idEmpleado, $idVacacion);
        $res = update('vacacion', array('vac_Estado' => 0), array("vac_VacacionesID" => $idVacacion));
        $data['code'] = 0;
        if ($res) $data['code'] = 1;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_eliminarVacaciones

    public function ajax_getVacacionesEmpleadosJefe()
    {
        $numJefe = session('numero');
        $vacaciones = $this->IncidenciasModel->getVacacionesEmpleadosJefe($numJefe);

        // Mapeo de estatus a clases CSS
        $estatusClases = [
            'PENDIENTE' => 'bg-info',
            'AUTORIZADO' => 'bg-warning',
            'RECHAZADO' => 'bg-danger',
            'AUTORIZADO_GO' => 'bg-warning',
            'RECHAZADO_GO' => 'bg-danger',
            'AUTORIZADO_RH' => 'bg-success',
            'RECHAZADO_RH' => 'bg-danger',
            'DECLINADO' => 'bg-danger'
        ];

        $data_vacaciones = array_map(function ($vacacion) use ($estatusClases) {
            return [
                "title" => $vacacion['emp_Nombre'],
                "start" => $vacacion['vac_FechaInicio'],
                "end" => $vacacion['vac_FechaFin'] . " 23:59:59",
                'periodo' => 'del ' . longDate($vacacion['vac_FechaInicio'], ' de ') . ' al ' . longDate($vacacion['vac_FechaFin'], ' de '),
                'className' => $estatusClases[$vacacion['vac_Estatus']] ?? ''
            ];
        }, $vacaciones);

        echo json_encode(["events" => $data_vacaciones]);
    }

    //Lia -> Autoriza o rechaza las vacaciones el jefe directo
    public function ajax_cambiarEstatusAutorizarVacaciones()
    {
        $idVacaciones = encryptDecrypt('decrypt', post('vacacionID'));
        $estatus = post('estatus');
        $observaciones = post('observaciones');
        $data['code'] = 0;
        if (autorizarVacaciones((int)$idVacaciones, $estatus, $observaciones)) {

            $empleado = $this->IncidenciasModel->getEmpleadoByVacacionID($idVacaciones);

            $notificacion = array(
                "not_EmpleadoID" => $empleado['emp_EmpleadoID'],
                "not_Titulo" => 'Solicitud de vacaciones ' . $estatus,
                "not_Descripcion" => 'La solicitud de vacaciones ha sido revisada.',
                "not_EmpleadoIDCreo" => (int)session("id"),
                "not_FechaRegistro" => date('Y-m-d H:i:s'),
                "not_URL" => 'Incidencias/misVacaciones',
                "not_Icono" => 'zmdi zmdi-flight-takeoff',
                "not_Color" => str_contains($estatus, 'AUTORIZADO') ? 'bg-success' : 'bg-danger',
            );
            insert('notificacion', $notificacion);
            if ($estatus == 'AUTORIZADO') {
                $ch = $this->BaseModel->getRH();
                foreach ($ch as $c) {
                    $notificacion = array(
                        "not_EmpleadoID" => $c['emp_EmpleadoID'],
                        "not_Titulo" => 'Solicitud de vacaciones por aplicar',
                        "not_Descripcion" => 'Revisar la solicitud de ' . $empleado['emp_Nombre'],
                        "not_EmpleadoIDCreo" => (int)session("id"),
                        "not_FechaRegistro" => date('Y-m-d H:i:s'),
                        "not_URL" => 'Incidencias/listVacaciones',
                        "not_Icono" => 'zmdi zmdi-flight-takeoff',
                        "not_Color" => 'bg-amber',
                    );
                    insert('notificacion', $notificacion);
                    $dataCorreo = array(
                        'titulo' => 'Vacacion Pendiente de Aplicar',
                        'cuerpo' => 'Mediante el presente se le comunica que el colaborador ' . $empleado['emp_Nombre'] . ', ha solicitado vacaciones en la plataforma PEOPLE.',
                        'nombre' => $c['emp_Nombre'],
                    );
                    sendMail($c['emp_Correo'], 'Solicitud de Vacación', $dataCorreo);
                }
            }

            $data['code'] = 1;
        }
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_cambiarEstatusAutorizarVacaciones

    //Lia -> Aplica o rechaza las vacaciones recursos humanos
    public function ajax_cambiarEstatusVacaciones()
    {
        $idVacaciones = encryptDecrypt('decrypt', post('vacacionID'));
        $estatus = post('estatus');
        $obs = post('observaciones');
        $data['code'] = 0;

        if (autorizarVacaciones((int)$idVacaciones, $estatus, $obs)) {

            $empleado = $this->IncidenciasModel->getEmpleadoByVacacionID($idVacaciones);

            $txt = ($estatus === 'AUTORIZADO_RH') ? 'aplicada' : 'rechazada por Recursos Humanos';

            $notificacion = array(
                "not_EmpleadoID" => $empleado['emp_EmpleadoID'],
                "not_Titulo" => 'Solicitud de vacaciones ' . $txt,
                "not_Descripcion" => 'La solicitud de vacaciones ha sido revisada.',
                "not_EmpleadoIDCreo" => (int)session("id"),
                "not_FechaRegistro" => date('Y-m-d H:i:s'),
                "not_Icono" => 'zmdi zmdi-flight-takeoff',
                "not_Color" => str_contains($estatus, 'AUTORIZADO') ? 'bg-success' : 'bg-danger',
            );
            insert('notificacion', $notificacion);
            $data['code'] = 1;
        }
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_cambiarEstatusVacaciones

    //Diego-> declinar vacaciones
    public function ajax_declinarVacaciones()
    {
        $data['code'] = 0;
        $idVacaciones = encryptDecrypt('decrypt', post('vacacionID'));
        $obs = post('obs');
        $vacacionB = $this->IncidenciasModel->getVacacion($idVacaciones);
        $idEmpleado = $vacacionB['vac_EmpleadoID'];
        $idVacacion = $vacacionB['vac_VacacionesID'];
        rechazarVacaciones($idEmpleado, $idVacacion);
        $res = update('vacacion', array("vac_Estatus" => 'DECLINADO', "vac_Justificacion" => $obs), array("vac_VacacionesID" => $idVacaciones));
        if ($res) $data['code'] = 1;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end declinar vacaciones

    //Diego -> Aplica o rechaza la solicitud de vacaciones horas recursos humanos
    public function ajax_cambiarEstatusHorasVacaciones()
    {
        $idVacaciones = encryptDecrypt('decrypt', post('vacacionID'));
        $estatus = post('estatus');
        $obs = post('observaciones');
        $data['code'] = 0;
        $empleado = $this->IncidenciasModel->getEmpleadoByVacacionHorasID($idVacaciones);

        if ($estatus == 'AUTORIZADO_RH') {
            $txt = "Aplicada";
            $res = update('vacacionhoras', ['vach_Estatus' => $estatus, 'vach_AutorizaID' => session('id')], ["vach_VacacionHorasID" => $idVacaciones]);

            if ($res) {
                $existe = $this->IncidenciasModel->getAcumuladosByEmpleado($empleado['emp_EmpleadoID']);
                $nuevasHoras = $existe ? $existe['acu_HorasExtra'] + $empleado['vach_Horas'] : $empleado['vach_Horas'];
                $acumuladosData = ['acu_EmpleadoID' => $empleado['emp_EmpleadoID'], 'acu_HorasExtra' => $nuevasHoras];
                $existe ? update('acumulados', ['acu_HorasExtra' => $nuevasHoras], ["acu_AcumuladosID" => $existe['acu_AcumuladosID']]) : insert('acumulados', $acumuladosData);
                $data['code'] = 1;
            }
        } else {
            $txt = "Rechazada";
            $res = update('vacacionhoras', ['vach_Estatus' => $estatus, 'vach_Observaciones' => $obs], ["vach_VacacionHorasID" => $idVacaciones]);

            if ($res) {
                $vacacionActual = $this->IncidenciasModel->getDiasVacacionByEmpleadoID($empleado['emp_EmpleadoID']);
                update('vacacionempleado', ['vace_Dias' => $vacacionActual + $empleado['vach_Dias'], 'vace_FechaActualizacion' => date('Y-m-d H:i:s')], ["vace_EmpleadoID" => $empleado['emp_EmpleadoID']]);
                $data['code'] = 1;
            }
        }

        $notificacion = [
            "not_EmpleadoID" => $empleado['emp_EmpleadoID'],
            "not_Titulo" => 'Solicitud de vacaciones-horas ' . $txt,
            "not_Descripcion" => 'La solicitud de horas ha sido revisada.',
            "not_EmpleadoIDCreo" => (int)session("id"),
            "not_FechaRegistro" => date('Y-m-d H:i:s'),
            'not_Icono' => 'zmdi zmdi-time-countdown',
            "not_Color" => $estatus == 'AUTORIZADO_RH' ? 'bg-green' : 'bg-red',
        ];
        insert('notificacion', $notificacion);

        sendMail($empleado['emp_Correo'], 'Solicitud de Horas Revisada', [
            'titulo' => 'Cambio de Vacaciones por Horas',
            'cuerpo' => 'Mediante el presente se le comunica que la solicitud de vacaciones a horas ha sido revisada.',
            'nombre' => $empleado['emp_Nombre']
        ], 'RevisadaVacacionesHoras');

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }
    //end ajax_cambiarEstatusVacaciones

    //Diego->Ver lista de permisos del empleado
    public function ajax_getPermisosByEmpleadoID()
    {
        $permisos = $this->IncidenciasModel->getPermisosByEmpleado((int)session("id"));

        $num = 1;
        foreach ($permisos as &$permiso) {
            $permiso['num'] = $num++;
            $permiso['per_PermisoID'] = encryptDecrypt('encrypt', $permiso['per_PermisoID']);
            $permiso['per_FechaInicio'] = shortDate($permiso['per_FechaInicio'], ' de ');
            $permiso['per_FechaFin'] = shortDate($permiso['per_FechaFin'], ' de ');
            $permiso['tipoPermiso'] = $permiso['tipoPermiso'];
            if ($permiso['per_Horas'] > 0 || $permiso['per_Horas'] != null) {
                $permiso['per_Motivos'] = '(De ' . shortTime($permiso['per_HoraInicio']) . ' a ' . shortTime($permiso['per_HoraFin']) . ') ' . $permiso['per_Motivos'];
            }
        }

        $data['data'] = $permisos;

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_getPermisosByEmpleadoID

    public function ajax_fechaColaborador($tipo, $fechaC)
    {
        //aniversario de boda
        $anioPermiso = explode('-', $fechaC);
        if ((int)$tipo === 1) {
            $fecha = $this->db->query("SELECT DATE_SUB(CONCAT_WS('-','" . $anioPermiso[0] . "' ,MONTH(emp_FechaMatrimonio),DAY(emp_FechaMatrimonio)), INTERVAL 15 DAY) as 'fechaInicio', DATE_ADD(CONCAT_WS('-','" . $anioPermiso[0] . "' ,MONTH(emp_FechaMatrimonio),DAY(emp_FechaMatrimonio)), INTERVAL 15 DAY) as 'fechaLimite',MONTH(emp_FechaMatrimonio) as 'mes' FROM empleado WHERE emp_EmpleadoID=" . session('id'))->getRowArray();
        } else {
            //cumpleaños
            $fecha = $this->db->query("SELECT DATE_SUB(CONCAT_WS('-','" . $anioPermiso[0] . "' ,MONTH(emp_FechaNacimiento),DAY(emp_FechaNacimiento)), INTERVAL 15 DAY) as 'fechaInicio',DATE_ADD(CONCAT_WS('-','" . $anioPermiso[0] . "' ,MONTH(emp_FechaNacimiento),DAY(emp_FechaNacimiento)), INTERVAL 15 DAY) as 'fechaLimite',MONTH(emp_FechaNacimiento) as 'mes' FROM empleado WHERE emp_EmpleadoID=" . session(('id')))->getRowArray();
        }
        if ($fecha['mes'] == 12 && $anioPermiso[1] == 1) {
            $fecha['fechaInicio'] = date('Y-m-d', strtotime($fecha['fechaInicio'] . ' -1 year'));
            $fecha['fechaLimite'] = date('Y-m-d', strtotime($fecha['fechaLimite'] . ' -1 year'));
        }
        if ($fecha) {
            if (($fechaC >= date('Y-m-d', strtotime($fecha['fechaInicio']))) && ($fechaC <= date('Y-m-d', strtotime($fecha['fechaLimite'])))) echo json_encode(array("code" => "1"));
            else echo json_encode(array("code" => "2"));
        } else echo json_encode(array("code" => "0"));
    }

    //Lia->Crear permiso
    public function ajax_crearPermiso()
    {
        $data['code'] = 0;
        $tipoID = (int)post('txtTipoPermiso');
        $tipoPermiso = $this->IncidenciasModel->getCatalogoPermisosById($tipoID);
        $diasPermitidos = (int)$tipoPermiso['cat_Dias'];
        $diasSolicitados = calcularDiasPermiso(post('txtFechaInicio'), post('txtFechaFin'));
        if ($diasPermitidos > 0) {
            $diasTomados = $this->IncidenciasModel->getDiasTomadosByTipoPermiso($tipoID);
            $diasRestantes = $diasTomados < $diasPermitidos ? $diasPermitidos - $diasTomados : 0;
            if ($tipoPermiso == 2) $diasRestantes = 3;
            if ($diasSolicitados > $diasPermitidos) {
                $data['code'] = 2;
                $data['msg'] = "Solo se permite solicitar $diasPermitidos días";
            } elseif ($diasSolicitados > $diasRestantes) {
                $data['code'] = 2;
                $data['msg'] = "Tienes $diasRestantes días restantes";
            }
        }
        if ($tipoID == 9) {
            $horasTomadas = $this->IncidenciasModel->getHorasTomadasByPermisoLactancia(post('txtFechaInicio'), post('txtFechaFin'));
            if ($horasTomadas >= 1) {
                $data['code'] = 2;
                $data['msg'] = "Solo se permite solicitar 1 hora en total al día durante el periodo de lactancia";
            }
        }
        $empleado = $this->BaseModel->getEmpleadoByID(session('id'));
        if ($data['code'] != 2) {
            $jefe = session('id') == 7 ? $this->BaseModel->getEmpleadoByID(19) : $this->BaseModel->getEmpleadoByNumero($empleado['emp_Jefe']);

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
            if (in_array($tipoID, [7, 8])) {
                $ts1 = strtotime(str_replace('/', '-', post('txtFechaInicio') . ' ' . post('txtHoraI')));
                $ts2 = strtotime(str_replace('/', '-', post('txtFechaFin') . ' ' . post('txtHoraF')));
                $diff = abs($ts1 - $ts2) / 3600;
                $permiso['per_Horas'] = $diff;
                $permiso['per_HoraInicio'] = post('txtHoraI');
                $permiso['per_HoraFin'] = post('txtHoraF');
            } elseif (in_array($tipoID, [9])) {
                $ts1 = strtotime(str_replace('/', '-', post('txtFechaInicio') . ' ' . post('txtHoraI')));
                $ts2 = strtotime(str_replace('/', '-', post('txtFechaFin') . ' ' . post('txtHoraI')));
                $diff = abs($ts1 - $ts2) / 3600;
                $permiso['per_Horas'] = $diff;
                $permiso['per_HoraInicio'] = post('txtHoraI');
                $permiso['per_HoraFin'] = post('txtHoraF');
            }
            //guarda el arreglo
            $response = insert('permiso', $permiso);

            if ($response) {
                $datos = array(
                    'titulo' => 'Solicitud de Permiso',
                    'nombre' =>  $jefe['emp_Nombre'],
                    'cuerpo' => 'Mediante el presente se le comunica que el colaborador a su cargo ' . $empleado['emp_Nombre'] . ', ha registrado una nueva solicitud de permiso en PEOPLE.<br>Para mayor información, revise la solicitud de permiso en la plataforma.',
                );
                //Enviar correo y notificacion
                sendMail($jefe['emp_Correo'], 'Nueva solicitud de permiso', $datos, 'PermisoS');
                $notificacion = array(
                    "not_EmpleadoID" => $jefe['emp_EmpleadoID'],
                    "not_Titulo" => 'Nueva solicitud de permiso',
                    "not_Descripcion" => 'El colaborador ' . $empleado['emp_Nombre'] . ' ha solicitado permiso.',
                    "not_EmpleadoIDCreo" => (int)session("id"),
                    "not_FechaRegistro" => date('Y-m-d H:i:s'),
                    "not_URL" => 'Incidencias/permisosMisEmpleados',
                    "not_Color" => 'bg-blue',
                    "not_Icono" => 'zmdi zmdi-calendar',
                );
                $response = insert('notificacion', $notificacion);
                $data['code'] = 1;
            }
        }

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_crearPermiso


    //Diego->ELiminar permiso
    public function ajax_deletePermiso()
    {
        $permisoID = (int)encryptDecrypt('decrypt', post("permisoID"));
        $response = update('permiso', array("per_Estatus" => 0), array("per_PermisoID" => $permisoID));
        $data['code'] = $response ? 1 : 0;

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_deletePermiso

    //Diego->Lista de permisos para autorizar por jefe inmediato
    public function ajax_getPermisosAutorizar()
    {
        $permisos = $this->IncidenciasModel->getPermisosPendientesMisSubordinados(session('numero'));
        $num = 1;
        foreach ($permisos as &$permiso) {
            $permiso['num'] = $num++;
            $permiso['per_PermisoID'] = encryptDecrypt('encrypt', $permiso['per_PermisoID']);
            if ($permiso['per_Horas'] > 0 || $permiso['per_Horas'] != null) {
                $permiso['per_Motivos'] = '(De ' . shortTime($permiso['per_HoraInicio']) . ' a ' . shortTime($permiso['per_HoraFin']) . ') ' . $permiso['per_Motivos'];
            }
            $permiso['per_FechaInicio'] = shortDate($permiso['per_FechaInicio'], ' de ');
            $permiso['per_FechaFin'] = shortDate($permiso['per_FechaFin'], ' de ');
            $permiso['autoriza'] = session('puesto');
            $permiso['numero'] = session('numero');
        }
        $data['data'] = $permisos;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_getPermisosAutorizar

    public function ajax_rechazarPermiso()
    {
        $permisoID = (int)encryptDecrypt('decrypt', post("permisoID"));
        $this->db->transStart();

        $permiso = $this->IncidenciasModel->getInfoByPermiso($permisoID);
        $data = ['per_Justificacion' => post('obs')];

        $estados = [
            'PENDIENTE' => ['per_JefeID' => session('id'), 'per_Estado' => 'RECHAZADO_JEFE'],
            'AUTORIZADO_JEFE' => ['per_ChID' => session('id'), 'per_Estado' => 'RECHAZADO_RH']
        ];

        $data = isset($estados[$permiso['per_Estado']])
            ? array_merge($data, $estados[$permiso['per_Estado']])
            : $data;

        update('permiso', $data, ['per_PermisoID' => $permisoID]);

        $datos = [
            'titulo' => 'Solicitud de Permiso',
            'nombre' => $permiso['emp_Nombre'],
            'cuerpo' => 'Mediante el presente se le comunica que su solicitud de permiso ha sido rechazada en la plataforma PEOPLE.<br>Para mayor información, revise la solicitud de permiso en la plataforma.'
        ];

        sendMail($permiso['emp_Correo'], 'Permiso Rechazado', $datos, 'PermisoRechazado');

        insert('notificacion', [
            "not_EmpleadoID" => $permiso['emp_EmpleadoID'],
            "not_Titulo" => 'Solicitud de permiso RECHAZADO',
            "not_Descripcion" => 'La solicitud de permiso ha sido revisada.',
            "not_EmpleadoIDCreo" => (int)session("id"),
            "not_FechaRegistro" => date('Y-m-d H:i:s'),
            "not_URL" => 'Incidencias/misPermisos',
            "not_Color" => 'bg-red',
            "not_Icono" => 'zmdi zmdi-calendar'
        ]);

        $data['code'] = $this->db->transStatus() === false ? 0 : 1;
        $this->db->transComplete();

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    //Diego->Jefe inmediato autoriza permiso
    public function ajax_autorizarPermiso()
    {
        $permisoID = (int)encryptDecrypt('decrypt', post("permisoID"));
        $permiso = $this->IncidenciasModel->getInfoByPermiso($permisoID);
        $data['code'] = 0;

        $data = [
            'per_TipoPermiso' => post('tipo') ?? '',
            'per_Justificacion' => post('obs') ?? ''
        ];

        if ($permiso['per_Estado'] == 'PENDIENTE') {
            $data['per_JefeID'] = session('id');
            $data['per_Estado'] = 'AUTORIZADO_JEFE';
        }

        $response = update('permiso', $data, ['per_PermisoID' => $permisoID]);

        if ($response && $permiso['per_Estado'] == 'PENDIENTE') {
            $notificado = $this->BaseModel->getRH();
            $datos_correo = [
                'titulo' => 'Solicitud de permiso por aplicar',
                'cuerpo' => 'El colaborador ' . $permiso['emp_Nombre'] . ' ha solicitado permiso.',
            ];

            foreach ($notificado as $not) {
                insert('notificacion', [
                    "not_EmpleadoID" => $not['emp_EmpleadoID'],
                    "not_Titulo" => 'Solicitud de permiso por APLICAR',
                    "not_Descripcion" => 'El colaborador ' . $permiso['emp_Nombre'] . ' ha solicitado permiso.',
                    "not_EmpleadoIDCreo" => (int)session("id"),
                    "not_FechaRegistro" => date('Y-m-d H:i:s'),
                    "not_URL" => 'Incidencias/aplicarPermisos',
                    "not_Color" => 'bg-amber',
                    "not_Icono" => 'zmdi zmdi-calendar'
                ]);

                $datos_correo['nombre'] = $not['emp_Nombre'];
                sendMail($not['emp_Correo'], 'Solicitud de permiso por aplicar', $datos_correo, 'PermisoRH');
            }
            $data['code'] = 1;
        }

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }
    //ajax_autorizarPermiso

    //Diego -> Aplicar permiso
    public function ajax_getPermisosAplicar()
    {
        $permisos = $this->IncidenciasModel->getPermisosAutorizados();
        $num = 1;
        foreach ($permisos as &$permiso) {
            $permiso['num'] = $num++;
            $permiso['per_FechaInicio'] = shortDate($permiso['per_FechaInicio'], ' de ');
            $permiso['per_FechaFin'] = shortDate($permiso['per_FechaFin'], ' de ');
            $permiso['per_Fecha'] = shortDate($permiso['per_Fecha'], ' de ');
            $permiso['per_PermisoID'] = encryptDecrypt('encrypt', $permiso['per_PermisoID']);
            if ($permiso['per_HoraCreado'] !== '00:00:00') {
                $permiso['per_Fecha'] = $permiso['per_Fecha'] . ' ' . shortTime($permiso['per_HoraCreado']);
            }
            if ($permiso['per_Horas'] > 0 || $permiso['per_Horas'] != null) {
                $permiso['per_TipoPermiso'] = '(De ' . shortTime($permiso['per_HoraInicio']) . ' a ' . shortTime($permiso['per_HoraFin']) . ')';
            }
        }
        $data['data'] = $permisos;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_getPermisosAplicar

    //Diego->Aplicar permisos
    public function ajax_aplicarPermiso()
    {
        $permisoID = (int)encryptDecrypt('decrypt', post('permisoID'));

        $this->db->transStart();

        $data = [
            'per_ChID' => session('id'),
            "per_Estado" => "AUTORIZADO_RH"
        ];
        update('permiso', $data, ["per_PermisoID" => $permisoID]);

        $datosEmpleado = $this->IncidenciasModel->getInfoByPermiso($permisoID);

        $datos = [
            'titulo' => 'Solicitud de Permiso',
            'nombre' => $datosEmpleado['emp_Nombre'],
            'cuerpo' => 'Mediante el presente se le comunica a usted que su solicitud de permiso ha sido APLICADO por el área de RECURSOS HUMANOS del día ' . longDate($datosEmpleado['per_FechaInicio'], " de ") . '  al ' . longDate($datosEmpleado['per_FechaFin'], " de ") . '.'
        ];
        if (sendMail($datosEmpleado['emp_Correo'], 'Permiso aplicado', $datos, 'Permiso')) {
            insert('notificacion', [
                "not_EmpleadoID" => $datosEmpleado['emp_EmpleadoID'],
                "not_Titulo" => 'Solicitud de permiso APLICADO',
                "not_Descripcion" => 'La solicitud de permiso ha sido revisada.',
                "not_EmpleadoIDCreo" => (int)session("id"),
                "not_FechaRegistro" => date('Y-m-d H:i:s'),
                "not_URL" => 'Incidencias/misPermisos',
                "not_Color" => 'bg-success',
                "not_Icono" => 'zmdi zmdi-calendar'
            ]);
        }

        $data['code'] = $this->db->transComplete() ? 1 : 0;

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }
    //ajax_aplicarPermiso

    //Declinar permiso
    public function ajax_declinarPermiso()
    {
        $permisoID = (int)encryptDecrypt('decrypt', post('permisoID'));

        $data = [
            'per_ChID' => session('id'),
            'per_Estado' => 'DECLINADO',
            'per_Justificacion' => post('obs')
        ];

        $data['code'] = update('permiso', $data, ['per_PermisoID' => $permisoID]) ? 1 : 0;

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_noAplicarPermiso

    public function ajax_GetReportesAsistencia()
    {
        $url = FCPATH . "/assets/uploads/reporteAsistencia/";
        if (!file_exists($url)) mkdir($url, 0777, true);

        $tree = array_map(function ($anio) use ($url) {
            $meses = preg_grep('/^([^.])/', scandir($url . $anio));

            $children = array_map(function ($mes) use ($anio) {
                return [
                    "id" => $anio . $mes,
                    "text" => numMeses($mes),
                    "icon" => "mdi mdi-zip-box ",
                    "state" => ["opened" => false, "disabled" => false],
                    "a_attr" => ["href" => base_url("/assets/uploads/reporteAsistencia/$anio/$mes/reporteAsistencia.xlsx")],
                    "li_attr" => ["tipo" => "periodo"],
                ];
            }, $meses);

            return [
                "text" => $anio,
                "state" => ["opened" => true, "disabled" => false, "selected" => false],
                "children" => $children,
                "li_attr" => ["tipo" => "year"]
            ];
        }, preg_grep('/^([^.])/', scandir($url)));

        echo json_encode($tree);
    }

    public function ajax_getMisHorasExtra()
    {
        $horas = $this->IncidenciasModel->getHorasExtraByEmpleado(session("id"));
        array_walk($horas, function (&$hora, $index) {
            $hora['rep_ReporteHoraExtraID'] = encryptDecrypt('encrypt', $hora['rep_ReporteHoraExtraID']);
            $hora['count'] = $index + 1;
            $hora['rep_Fecha'] = shortDate($hora['rep_Fecha'], ' de ');
        });
        echo json_encode(['data' => $horas], JSON_UNESCAPED_SLASHES);
    }

    public function ajaxAddReporteHorasExtras()
    {
        $post = $this->request->getPost();
        $empleadoID = (int)session('id');

        $reporte = [
            'rep_FechaRegistro' => date('Y-m-d'),
            'rep_EmpleadoID' => $empleadoID,
            'rep_Fecha' => $post['fecha'],
            'rep_HoraInicio' => $post['horaInicio'],
            'rep_HoraFin' => $post['horaFin'],
            'rep_Horas' => (int)calculoHorasExtra($post['horaInicio'], $post['horaFin']),
            'rep_Motivos' => $post['motivos'],
        ];

        echo json_encode(['code' => insert('reportehoraextra', $reporte) ? 1 : 0], JSON_UNESCAPED_SLASHES);
    }

    public function ajax_deleteReporteHorasExtra()
    {
        $reporteID = (int)encryptDecrypt('decrypt', post("reporteID"));
        $data['code'] = update('reportehoraextra', ['rep_Estatus' => 0], ['rep_ReporteHoraExtraID' => $reporteID]) ? 1 : 0;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    public function ajax_enviarReporteHorasExtra()
    {
        $reporteID = (int)encryptDecrypt('decrypt', post("reporteID"));
        $this->db->transStart();

        $empleado = $this->IncidenciasModel->getInfoEmpleadoByReporteHoraExtraID($reporteID);
        $jefe = (session('id') == 7) ? $this->BaseModel->getEmpleadoByID(19) : $this->BaseModel->getEmpleadoByNumero($empleado['emp_Jefe']);

        $datos = [
            'titulo' => 'Solicitud de horas extra',
            'nombre' => $jefe['emp_Nombre'],
            'cuerpo' => 'Mediante el presente se le comunica que el colaborador a su cargo ' . $empleado['emp_Nombre'] . ', ha registrado una solicitud de horas extra para su revisión.'
        ];

        update('reportehoraextra', ['rep_Estado' => 'PENDIENTE'], ['rep_ReporteHoraExtraID' => $reporteID]);
        sendMail($jefe['emp_Correo'], 'Nueva solicitud de horas extra', $datos, 'ReporteHorasExtra');

        $notificacion = [
            "not_EmpleadoID" => $jefe['emp_EmpleadoID'],
            "not_Titulo" => 'Nueva solicitud de horas extra',
            "not_Descripcion" => $empleado['emp_Nombre'] . ' envió una solicitud de horas extra.',
            "not_EmpleadoIDCreo" => (int)session("id"),
            "not_FechaRegistro" => date('Y-m-d H:i:s'),
            "not_URL" => 'Incidencias/horasExtraMisEmpleados',
            "not_Color" => 'bg-warning',
            "not_Icono" => 'zmdi zmdi-time-countdown'
        ];
        insert('notificacion', $notificacion);
        $data['code'] = ($this->db->transStatus() === false) ? $this->db->transRollback() && 0 : $this->db->transCommit() && 1;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    public function ajax_revisarReporteHorasJefe()
    {
        $post = $this->request->getPost();
        $reporteID = (int)encryptDecrypt('decrypt', $post["reporteID"]);
        $estatus = $post["accion"];
        $observaciones = $post["observaciones"] ?? '';

        $this->db->transStart();

        update('reportehoraextra', [
            'rep_Estado' => $estatus,
            'rep_ObservacionesJ' => $observaciones
        ], ['rep_ReporteHoraExtraID' => $reporteID]);

        $empleado = $this->IncidenciasModel->getInfoEmpleadoByReporteHoraExtraID($reporteID);
        $jefe = $this->BaseModel->getEmpleadoByNumero($empleado['emp_Jefe']);
        $rh = $this->BaseModel->getRH();

        $datos = [
            'titulo' => 'Solicitud de horas extra',
            'nombre' => $empleado['emp_Nombre'],
            'cuerpo' => 'Mediante el presente se le comunica que ' . $jefe['emp_Nombre'] . ' ha ' . $estatus . ' el reporte de horas extra enviado.'
        ];

        sendMail($empleado['emp_Correo'], 'Solicitud de horas extra revisada', $datos, 'ReporteHorasRevisionJefe');

        insert('notificacion', [
            "not_EmpleadoID" => $empleado['emp_EmpleadoID'],
            "not_Titulo" => 'Solicitud de horas extra ' . $estatus,
            "not_Descripcion" => 'La solicitud de horas extra ha sido revisada.',
            "not_EmpleadoIDCreo" => (int)session("id"),
            "not_FechaRegistro" => date('Y-m-d H:i:s'),
            "not_URL" => 'Incidencias/controlHorasExtra',
            "not_Color" => $estatus === 'AUTORIZADO' ? 'bg-info' : 'bg-red',
            "not_Icono" => 'zmdi zmdi-check'
        ]);

        if ($estatus === "AUTORIZADO") {
            foreach ($rh as $c) {
                sendMail($c['emp_Correo'], 'Nueva solicitud de horas extra', [
                    'titulo' => 'Solicitud de horas extra',
                    'nombre' => $c['emp_Nombre'],
                    'cuerpo' => 'Mediante el presente se le comunica que tiene una solicitud de horas extra de ' . $empleado['emp_Nombre'] . ' pendiente de revisar.'
                ], 'ReporteHorasExtraCH');

                insert('notificacion', [
                    "not_EmpleadoID" => $c['emp_EmpleadoID'],
                    "not_Titulo" => 'Solicitud de horas extra por aplicar',
                    "not_Descripcion" => 'Solicitud de ' . $empleado['emp_Nombre'] . ' pendiente de revisar.',
                    "not_EmpleadoIDCreo" => (int)session("id"),
                    "not_FechaRegistro" => date('Y-m-d H:i:s'),
                    "not_URL" => 'Incidencias/aplicarReporteHoras',
                    "not_Color" => 'bg-blue',
                    "not_Icono" => 'zmdi zmdi-check'
                ]);
            }
        }

        $data['code'] = $this->db->transStatus() === false ? $this->db->transRollback() && 0 : $this->db->transCommit() && 1;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    //Lia-> salidas de mis empleados
    public function ajax_getHorasMisEmpleados()
    {
        $empleadoID = session("numero");
        $horas = $this->IncidenciasModel->getHorasMisEmpleadosJefe($empleadoID);
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

    //Lia->CH aplica el reporte de horas
    public function ajax_getReportesHoras()
    {
        $horas = $this->IncidenciasModel->getReportesHorasExtras();
        array_walk($horas, function (&$hora, $index) {
            $hora['rep_ReporteHoraExtraID'] = encryptDecrypt('encrypt', $hora['rep_ReporteHoraExtraID']);
            $hora['count'] = $index + 1;
            $hora['observaciones'] = $hora['rep_ObservacionesJ'] . ' ' . $hora['rep_ObservacionesCH'];
            $hora['rep_Fecha'] = shortDate($hora['rep_Fecha'], ' de ');
        });

        echo json_encode(['data' => $horas], JSON_UNESCAPED_SLASHES);
    }

    public function ajax_revisarReporteHorasCH()
    {
        $reporteID = (int)encryptDecrypt('decrypt', post("reporteID"));
        $accion = post("accion");
        $estatus = ($accion === 'APLICAR') ? 'APLICADO' : 'RECHAZADO_RH';
        $observaciones = post("observaciones");

        $this->db->transStart();

        update('reportehoraextra', [
            'rep_Estado' => $estatus,
            'rep_ObservacionesCH' => $observaciones,
            'rep_AproboID' => session('id')
        ], ['rep_ReporteHoraExtraID' => $reporteID]);

        $empleado = $this->IncidenciasModel->getInfoEmpleadoByReporteHoraExtraID($reporteID);

        $datos = array(
            'nombre' => $empleado['emp_Nombre'],
            'titulo' => 'Solicitud de horas extra',
            'cuerpo' => 'Mediante el presente se le comunica que el reporte de horas extra, ha sido revisado por el departamento de Recursos Humanos.',
        );
        sendMail($empleado['emp_Correo'], 'Solicitud de horas extra', $datos, 'ReporteHorasRevisionCH');

        insert('notificacion', [
            "not_EmpleadoID" => $empleado['emp_EmpleadoID'],
            "not_Titulo" => 'Solicitud de horas extra ',
            "not_Descripcion" => 'El departamento de Recursos Humanos ha revisado tu solicitud de horas extra.',
            "not_EmpleadoIDCreo" => session("id"),
            "not_FechaRegistro" => date('Y-m-d H:i:s'),
            "not_URL" => 'Incidencias/controlHorasExtra',
            "not_Color" => 'bg-blue',
            "not_Icono" => 'zmdi zmdi-time-countdown'
        ]);

        $data['code'] = $this->db->transComplete() ? 1 : 0;

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    public function ajax_ReporteHorasExtraPagado()
    {
        $salidaID = (int)encryptDecrypt('decrypt', post("salidaID"));
        $accion = post("accion");
        $tipo = post("tipo");

        $this->db->transStart();

        update("reportehoraextra", [
            'rep_Estado' => $accion,
            'rep_TipoPago' => $tipo,
        ], ['rep_ReporteHoraExtraID' => $salidaID]);

        $empleado = $this->IncidenciasModel->getInfoEmpleadoByReporteHoraExtraID($salidaID);

        insert('notificacion', [
            "not_EmpleadoID" => $empleado['emp_EmpleadoID'],
            "not_Titulo" => 'Horas extra pagadas',
            "not_Descripcion" => 'Se pagaron tus horas extra como ' . $tipo,
            "not_EmpleadoIDCreo" => session("id"),
            "not_FechaRegistro" => date('Y-m-d H:i:s'),
            "not_URL" => 'Incidencias/controlHorasExtra',
            "not_Color" => 'bg-green',
            "not_Icono" => 'zmdi zmdi-time-countdown'
        ]);

        $data['code'] = $this->db->transComplete() ? 1 : 0;

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    public function ajax_declinarHorasExtra()
    {
        $reporteID = (int)encryptDecrypt('decrypt', post('reporteID'));
        $data = [
            'rep_AproboID' => session('id'),
            'rep_Estado' => 'DECLINADO',
            'rep_ObservacionesCH' => post('obs'),
            'rep_TipoPago' => null
        ];
        $data['code'] = update('reportehoraextra', $data, ['rep_ReporteHoraExtraID' => $reporteID]) ? 1 : 0;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    //Lia->Trae el informe de mis salidas
    public function ajax_getMisSalidas()
    {
        $empleadoID = (int)session("id");
        $salidas = $this->IncidenciasModel->getSalidassByEmpleado($empleadoID);
        $count = 1;
        foreach ($salidas as &$salida) {
            $salida['rep_ReporteSalidaID'] = encryptDecrypt('encrypt', $salida['rep_ReporteSalidaID']);
            $salida['count'] = $count++;

            $dias = json_decode($salida['rep_Dias'], true);
            $txtDias = "";
            for ($i = 0; $i < count($dias); $i++) {
                $txtDias .= '<span class="badge badge-success">' . shortDate($dias[$i]['fecha']) . '</span><br>';
            }
            $salida['rep_Dias'] = $txtDias;
            $semana = explode(' al ', $salida['rep_Semana']);
            $salida['rep_Semana'] = shortDate($semana[0], ' de ') . ' al ' . shortDate($semana[1], ' de ');
        }
        $data['data'] = $salidas;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_getMisSalidas

    public function ajaxAddReporteSalidas()
    {
        $post = $this->request->getPost();
        $dias = array_map(function ($fecha, $socap, $objetivo, $logros) {
            return compact('fecha', 'socap', 'objetivo', 'logros');
        }, $post['fecha'], $post['socap'], $post['objetivo'], $post['logros']);

        [$diaInicio, $diaFin] = explode(' al ', $post['txtFechas']);

        $reporte = [
            'rep_FechaRegistro' => date('Y-m-d'),
            'rep_EmpleadoID' => (int)session('id'),
            'rep_Semana' => $post['txtFechas'],
            'rep_DiaInicio' => $diaInicio,
            'rep_DiaFin' => $diaFin,
            'rep_Dias' => json_encode($dias),
        ];

        $data['code'] = insert("reportesalida", $reporte) ? 1 : 0;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    //Elimina un reporte de salida
    public function ajax_deleteReporteSalidas()
    {
        $salidaID = (int)encryptDecrypt('decrypt', post("salidaID"));
        $response = update('reportesalida', array('rep_Estatus' => 0), array('rep_ReporteSalidaID' => $salidaID));
        $data['code'] = $response ? 1 : 0;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_deleteReporteSalidas

    public function ajax_enviarReporteSalidas()
    {
        $salidaID = (int)encryptDecrypt('decrypt', post("salidaID"));
        $data = ['code' => 0];

        $this->db->transStart();

        $empleado = $this->IncidenciasModel->getInfoEmpleadoByReporteSalida($salidaID);
        $jefeID = session('id') == 7 ? 19 :  $this->BaseModel->getEmpleadoByNumero($empleado['emp_Jefe'])['emp_EmpleadoID'];
        $jefe = $this->BaseModel->getEmpleadoByID($jefeID);

        update('reportesalida', ['rep_Estado' => 'PENDIENTE'], ['rep_ReporteSalidaID' => $salidaID]);

        $mailData = [
            'nombre' => $jefe['emp_Nombre'],
            'titulo' => 'Informe de salidas',
            'cuerpo' => "Mediante el presente se le comunica que el colaborador a su cargo {$empleado['emp_Nombre']}, ha registrado un nuevo informe de salidas para su revisión. Para mayor información, revise la solicitud en la plataforma PEOPLE."
        ];
        sendMail($jefe['emp_Correo'], 'Nuevo informe de salidas', $mailData, 'InformeSalidas');

        $notificacion = [
            "not_EmpleadoID" => $jefe['emp_EmpleadoID'],
            "not_Titulo" => 'Nuevo informe de salidas',
            "not_Descripcion" => 'Revisar informe de salidas',
            "not_EmpleadoIDCreo" => (int)session("id"),
            "not_FechaRegistro" => date('Y-m-d H:i:s'),
            "not_URL" => 'Incidencias/informeSalidasMisEmpleados',
            "not_Color" => 'bg-blue',
            "not_Icono" => 'zmdi zmdi-car'
        ];
        insert('notificacion', $notificacion);

        $data['code'] = $this->db->transStatus() ? 1 : 0;
        $this->db->transComplete();

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    public function ajaxGetDiasSemana()
    {
        $inicio = post('inicio');
        $fin = post('fin');

        $fechaInicio = strtotime($inicio);
        $fechaFin = strtotime($fin);

        $fechas = [];
        for ($i = $fechaInicio; $i <= $fechaFin; $i += 86400) {
            $fecha = date("Y-m-d", $i);
            $fechas[] = [
                'fecha' => $fecha,
                'nombreFecha' => longDate($fecha, ' de ')
            ];
        }

        echo json_encode(['data' => $fechas], JSON_UNESCAPED_SLASHES);
    }

    //Lia-> trae las cooperativas para las salidas
    public function ajaxGetSocaps()
    {
        $sucursales = $this->BaseModel->getSucursales();
        foreach ($sucursales as &$s) {
            unset($s['suc_Estatus']);
            unset($s['suc_EmpleadoID']);
        }
        $data['data'] = $sucursales;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }


    //Lia-> salidas de mis empleados
    public function ajax_getSalidasMisEmpleados()
    {
        $salidas = $this->IncidenciasModel->getSalidasMisEmpleados((int)session("numero"));
        $count = 1;
        foreach ($salidas as &$salida) {
            $salida['rep_ReporteSalidaID'] = encryptDecrypt('encrypt', $salida['rep_ReporteSalidaID']);
            $salida['count'] = $count++;
            $dias = json_decode($salida['rep_Dias'], true);

            $txtDias = "";
            for ($i = 0; $i < count($dias); $i++) {
                $txtDias .= '<span class="badge badge-success">' . shortDate($dias[$i]['fecha']) . '</span><br>';
            }
            $salida['rep_Dias'] = $txtDias;
            $semana = explode(' al ', $salida['rep_Semana']);
            $salida['rep_Semana'] = shortDate($semana[0], ' de ') . ' al ' . shortDate($semana[1], ' de ');
            $salida['rep_FechaRegistro'] = shortDate($salida['rep_FechaRegistro'], ' de ');
        }
        $data['data'] = $salidas;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_getSalidasMisEmpleados

    // Lia->Jefe revisa el reporte de salidas
    public function ajax_revisarReporteSalidas()
    {
        $salidaID = (int)encryptDecrypt('decrypt', post("salidaID"));
        $accion = post("accion");
        $estatus = ($accion === 'AUTORIZAR') ? 'AUTORIZADO' : 'RECHAZADO';
        $observaciones = post("observaciones");

        $this->db->transStart();

        // Actualizar reporte de salida
        update('reportesalida', [
            'rep_Estado' => $estatus,
            'rep_AutorizoID' => session('id'),
            'rep_ObservacionesRJ' => $observaciones
        ], ['rep_ReporteSalidaID' => $salidaID]);

        $empleado = $this->IncidenciasModel->getInfoEmpleadoByReporteSalida($salidaID);
        $jefeID = ($empleado['emp_EmpleadoID'] == 7) ? 19 : $this->BaseModel->getEmpleadoByNumero($empleado['emp_Jefe'])['emp_EmpleadoID'];
        $jefe = $this->BaseModel->getEmpleadoByID($jefeID);

        $datos = [
            'titulo' => 'Informe de salidas',
            'nombre' => $empleado['emp_Nombre'],
            'cuerpo' => 'Su jefe directo ' . $jefe['emp_Nombre'] . ' ha ' . $estatus . ' el informe de salidas. Revise la solicitud en la plataforma PEOPLE.'
        ];

        // Enviar correo al empleado
        $asuntoCorreo = 'Informe de salidas ' . (($estatus === 'AUTORIZADO') ? 'Autorizado' : 'Rechazado');
        sendMail($empleado['emp_Correo'], $asuntoCorreo, $datos, 'InformeSalidasRevisionJefe');

        // Si está autorizado, notificar a recursos humanos
        if ($estatus === 'AUTORIZADO') {
            foreach ($this->BaseModel->getRH() as $c) {
                update('notificacion', [
                    "not_EmpleadoID" => $c['emp_EmpleadoID'],
                    "not_Titulo" => 'Reporte de salidas por aplicar',
                    "not_Descripcion" => 'Revisar el reporte de ' . $empleado['emp_Nombre'],
                    "not_EmpleadoIDCreo" => (int)session("id"),
                    "not_FechaRegistro" => date('Y-m-d H:i:s'),
                    "not_URL" => 'Incidencias/aplicarInformeSalidas',
                    "not_Icono" => 'zmdi zmdi-time-countdown',
                    "not_Color" => 'bg-green',
                ]);
            }
        }

        // Notificación para el empleado sobre el estado del reporte
        update('notificacion', [
            "not_EmpleadoID" => $empleado['emp_EmpleadoID'],
            "not_Titulo" => 'Informe de salidas ' . $estatus,
            "not_Descripcion" => 'El informe de salidas ha sido revisado.',
            "not_EmpleadoIDCreo" => (int)session("id"),
            "not_FechaRegistro" => date('Y-m-d H:i:s'),
            "not_URL" => 'Incidencias/reporteSalidas',
            "not_Icono" => 'zmdi zmdi-time-countdown',
            "not_Color" => ($estatus === 'AUTORIZADO') ? 'bg-green' : 'bg-red',
        ]);

        // Finalizar transacción
        $data['code'] = ($this->db->transStatus() === false) ? 0 : 1;
        $this->db->transComplete();

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end revisarreporte

    //Lista de salidas a aplicar
    public function ajax_getInformesSalidas()
    {
        $salidas = $this->IncidenciasModel->getInformesSalidas();
        $count = 1;
        foreach ($salidas as &$salida) {
            $salida['rep_ReporteSalidaID'] = encryptDecrypt('encrypt', $salida['rep_ReporteSalidaID']);
            $salida['count'] = $count++;
            $dias = json_decode($salida['rep_Dias'], true);

            $txtDias = "";
            for ($i = 0; $i < count($dias); $i++) {
                $txtDias .= '<span class="badge badge-success">' . shortDate($dias[$i]['fecha']) . '</span><br>';
            }
            $salida['totalDias'] =  $i;
            $salida['rep_Dias'] = $txtDias;
            $semana = explode(' al ', $salida['rep_Semana']);
            $salida['rep_Semana'] = shortDate($semana[0], ' de ') . ' al ' . shortDate($semana[1], ' de ');
            $salida['rep_FechaRegistro'] = shortDate($salida['rep_FechaRegistro'], ' de ');
        }
        $data['data'] = $salidas;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_getInformesSalidas

    //Diego->CH revisa salidas
    public function ajax_revisarReporteSalidasCH()
    {
        $salidaID = (int)encryptDecrypt('decrypt', post("salidaID"));
        $accion = post("accion");
        $estatus = ($accion === 'APLICAR') ? 'APLICADO' : 'RECHAZADO_RH';
        $observaciones = post("observaciones");

        $this->db->transStart();

        update("reportesalida", [
            'rep_Estado' => $estatus,
            'rep_ObservacionesRCH' => $observaciones,
            'rep_AproboID' => session('id')
        ], ['rep_ReporteSalidaID' => $salidaID]);

        $empleado = $this->IncidenciasModel->getInfoEmpleadoByReporteSalida($salidaID);
        $estatus === 'APLICADO' ? 'APLICADO' : 'RECHAZADO';
        $datos = [
            'titulo' => 'Informe de salidas',
            'cuerpo' => 'Mediante el presente se le comunica que el informe de salidas enviado , ha sido ' . $estatus . ' por el departamento de Capital Humano. Para mayor información, revise la solicitud en la plataforma PEOPLE.',
            'nombre' => $empleado['emp_Nombre'],
        ];
        sendMail($empleado['emp_Correo'], 'Informe de salidas ' . $estatus, $datos, 'InformeSalidasRevisionCH');

        update('notificacion', [
            "not_EmpleadoID" => $empleado['emp_EmpleadoID'],
            "not_Titulo" => 'Informe de salidas ' . $estatus,
            "not_Descripcion" => 'El informe de salidas ha sido revisado.',
            "not_EmpleadoIDCreo" => (int)session("id"),
            "not_FechaRegistro" => date('Y-m-d H:i:s'),
            "not_URL" => 'Incidencias/reporteSalidas',
            "not_Icono" => 'zmdi zmdi-time-countdown',
            "not_Color" => ($estatus === 'APLICADO') ? 'bg-green' : 'bg-red',
        ]);

        $data['code'] = $this->db->transStatus() === false ? 0 : 1;
        $this->db->transComplete();

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }
    //end ajax_revisarReporteSalidasCH

    //Diego->elimina un registro de incapacidad
    public function ajax_eliminarIncapacidad()
    {
        $data = ['code' => 0];
        $incapacidadID = encryptDecrypt('decrypt', post('incapacidadID'));
        $incapacidad = $this->IncidenciasModel->getIncapacidadesByID((int)$incapacidadID);

        $archivo = $incapacidad['inc_Archivo'];
        $url = FCPATH . "/assets/uploads/incapacidades/" . $incapacidad['inc_EmpleadoID'] . "/";

        if (file_exists($url . $archivo)) {
            unlink($url . $archivo);
        }

        if (delete('incapacidad', ["inc_IncapacidadID" => (int)$incapacidadID])) {
            insertLog($this, session('id'), 'Eliminar', 'incapacidad', $incapacidadID);
            $data['code'] = 1;
        }

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }
    //end eliminarIncapacidad

    public function ajax_getSolicitudIncapacidades()
    {
        $incapacidades = $this->IncidenciasModel->getSolicitudIncapacidades();
        $count = 1;
        foreach ($incapacidades as &$incapacidad) {
            $incapacidad['inc_IncapacidadID'] = encryptDecrypt('encrypt', $incapacidad['inc_IncapacidadID']);
            $incapacidad['count'] = $count++;
            $incapacidad['observaciones'] = $incapacidad['inc_Justificacion'];
            $incapacidad['inc_FechaRegistro'] = shortDate($incapacidad['inc_FechaRegistro'], ' de ');
            $incapacidad['inc_FechaInicio'] = shortDate($incapacidad['inc_FechaInicio'], ' de ');
            $incapacidad['inc_FechaFin'] = shortDate($incapacidad['inc_FechaFin'], 'de ');
        }
        $data['data'] = $incapacidades;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_getReportesHoras

    public function ajax_revisarIncapacidades()
    {
        $incapacidadID = (int)encryptDecrypt('decrypt', post("reporteID"));
        $estatus = post("accion") === 'Autorizar' ? 'Autorizada' : 'Rechazada';
        $observaciones = post("observaciones");

        $this->db->transStart();

        update('incapacidad', [
            'inc_Estatus' => $estatus,
            'inc_Justificacion' => $observaciones,
            'inc_AutorizaRechazaID' => session('id')
        ], ['inc_IncapacidadID' => $incapacidadID]);

        $data['code'] = $this->db->transStatus() ? 1 : 0;

        if ($data['code'] === 0) {
            $this->db->transRollback();
        } else {
            $this->db->transCommit();
        }

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }
    // Lia->Eliminar un acta administrativa
    public function ajax_eliminarActa()
    {
        $idActa = (int) encryptDecrypt('decrypt', post('sancionID'));
        $acta = $this->IncidenciasModel->getActaAdministrativa($idActa);
        $archivo = $acta['act_Documento'];

        if ($archivo) {
            $filePath = FCPATH . "/assets/uploads/actasadmin/" . $archivo;
            if (file_exists($filePath)) unlink($filePath);
        }

        $result = delete('actaadministrativa', ['act_ActaAdministrativaID' => $idActa]);
        $data = ['code' => $result ? 1 : 0];

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end eliminarActa

}//end controller
