<?php

namespace App\Controllers;

defined('FCPATH') or exit('No direct script access allowed');

use App\Models\ConfiguracionModel;

class Configuracion extends BaseController
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

    //Fer->Adaptacion para Proyecto Modulo diasInhabiles
    //Diego->Calendario dias inhabiles
    public function diasInhabiles()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Días inhabiles';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index')),
            array("titulo" => 'Configuración de días inhabiles', "link" => base_url('Configuracion/diasInhabiles'))
        );

        //Styles
        $data['styles'][] = base_url('assets/libs/fullcalendar/fullcalendar.min.css');
        $data['styles'][] = base_url('assets/libs/select2/css/select2.min.css');


        //Scripts
        $data['scripts'][] = base_url('assets/libs/moment/moment.min.js');
        $data['scripts'][] = base_url('assets/libs/jquery-ui/jquery-ui.min.js');
        $data['scripts'][] = base_url('assets/libs/fullcalendar/fullcalendar.min.js');
        $data['scripts'][] = base_url('assets/libs/select2/js/select2.full.min.js');
        $data['scripts'][] = base_url('assets/js/configuracion/inhabiles.js');

        //Vistas
        echo view('htdocs/header', $data);
        echo view('configuracion/diasInhabiles');
        echo view('htdocs/footer');
    } //diasInhabiles
    //End Fer->Adaptacion para Proyecto Modulo diasInhabiles

    //Fer->Adaptacion para Proyecto Modulo horarios
    //HUGO->Horarios
    public function horarios()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Horarios';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'));
        $data['breadcrumb'][] = array("titulo" => 'Configuración de horarios', "link" => base_url('Configuracion/horarios'));

        //Styles
        $data['styles'][] = base_url('assets/libs/select2/css/select2.min.css');
        $data['styles'][] = base_url('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css');
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');

        //Scripts
        $data['scripts'][] = base_url('assets/libs/select2/js/select2.full.min.js');
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
        $data['scripts'][] = base_url('assets/js/configuracion/horario.js');

        //Vistas
        echo view('htdocs/header', $data);
        echo view('configuracion/horarios');
        echo view('configuracion/modalAddHorario');
        echo view('configuracion/modalEditHorario');
        echo view('htdocs/footer');
    } //horarios
    //End Fer->Adaptacion para Proyecto Modulo horarios


    //Lia -> Catalogo de roles donde puede asignar las funciones
    public function roles()
    {
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Roles de usuario';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'));
        $data['breadcrumb'][] = array("titulo" => 'Configuración de roles de usuario', "link" => base_url('Configuracion/roles'));

        //Styles
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.css');

        //Scripts
        $data['scripts'][] = base_url('assets/plugins/datatables/jquery.dataTables.min.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/js/dataTables.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.js');
        $data['scripts'][] = base_url('assets/js/configuracion/roles.js');

        //Vistas
        echo view('htdocs/header', $data);
        echo view('configuracion/roles');
        echo view('configuracion/modalPermisosRol');
        echo view('htdocs/footer');
    } //roles


    //HUGO->Configuracion de dias por tipo de permiso
    public function configuracionPermisos()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Permisos';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'));
        $data['breadcrumb'][] = array("titulo" => 'Configuración de permisos', "link" => base_url('Configuracion/configuracionPermisos'));

        //Styles
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');
        $data['styles'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.css');

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
        $data['scripts'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.js');
        $data['scripts'][] = base_url('assets/js/configuracion/configuracionPermisos.js');

        //Vistas
        echo view('htdocs/header', $data);
        echo view('configuracion/configPermisos');
        echo view('configuracion/modalEditConfigPermisos');
        echo view('htdocs/footer');
    } //configuracionPermisos

    //HUGO ->Checklists de ingreo y egreso de personal
    public function configChecklistIngresoEgreso()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Checklist ingreso/egreso';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => '#', "class" => "");
        $data['breadcrumb'][] = array("titulo" => 'Catálogo de checklist', "link" => base_url('Configuracion/configChecklistIngresoEgreso'), "class" => "active");


        //Custom Styles
        $data['styles'][] = base_url("assets/libs/select2/select2.min.css");
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');

        $data['styles'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.css");

        //Custom Scripts
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
        $data['scripts'][] = base_url("assets/js/configuracion/listaIngresoEgreso.js");

        //Get empleados
        $sql = "SELECT * FROM empleado where emp_Estatus=1 and emp_Estado='Activo' order by emp_Nombre ASC";
        $data['empleados'] = $this->db->query($sql)->getResultArray();

        //Vistas
        echo view('htdocs/header', $data);
        echo view('configuracion/listaIngresoEgreso', $data);
        echo view('htdocs/footer', $data);
    } //configChecklistIngresoEgreso

    //Lia->vista para la configuracion de las prestaciones
    public function prestaciones()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Prestaciones';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index')),
            array("titulo" => 'Configuración de prestaciones', "link" => base_url('Usuario/prestaciones'))
        );

        //Prestaciones actuales
        $model = new ConfiguracionModel();
        $configuracionA = $model->getConfiguracionPrestacionesActuales();
        $data['vacaciones'] = json_decode($configuracionA['vco_DiasVacaciones'], true);
        $data['prima'] = json_decode($configuracionA['vco_Prima'], true);
        $data['aguinaldo'] = json_decode($configuracionA['vco_Aguinaldo'], true);
        $data['rangos'] = getSetting('rangos_vacaciones', $this);
        $data['rangosPrima'] = getSetting('rangos_prima', $this);
        $data['rangosAguinaldo'] = getSetting('rangos_aguinaldo', $this);

        //Prestaciones adicionales
        $prestacionesAdicionales = $model->getPrestacionAdicional();
        $data['prestamo'] = json_decode($prestacionesAdicionales['pre_Prestamo'], true);

        //Styles
        $data['styles'][] = base_url('assets/libs/datatables/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/libs/datatables/responsive.bootstrap4.css');
        $data['styles'][] = base_url("assets/plugins/sweetalert/sweetalert.css");

        //Scripts
        $data['scripts'][] = base_url('assets/libs/datatables/jquery.dataTables.min.js');
        $data['scripts'][] = base_url('assets/libs/datatables/dataTables.bootstrap4.min.js');
        $data['scripts'][] = base_url('assets/libs/datatables/dataTables.responsive.min.js');
        $data['scripts'][] = base_url("assets/plugins/sweetalert/sweetalert.min.js");
        $data['scripts'][] = base_url("assets/plugins/sweetalert/jquery.sweet-alert.custom.js");

        //Vistas
        echo view('htdocs/header', $data);
        echo view('configuracion/prestaciones');
        echo view('htdocs/footer');
    } // end prestaciones

    //Diego -> Configuracion de Expediente
    public function configuracionExpediente()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Configuración del expediente';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "");
        $data['breadcrumb'][] = array("titulo" => 'Configuración del expediente', "link" => base_url('Configuracion/configuracionExpediente'), "class" => "active");

        $model = new ConfiguracionModel();
        $data['expedientes'] = $model->getExpedientes();

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
        $data['scripts'][] = 'https://cdn.datatables.net/fixedcolumns/3.2.6/js/dataTables.fixedColumns.min.js';
        $data['scripts'][] = base_url('assets/js/configuracion/expedientes.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('configuracion/expedientes', $data);
        echo view('htdocs/footer', $data);
    } //configuracionExpediente

    //Diego->guardias
    public function guardias()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Guardias';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'));
        $data['breadcrumb'][] = array("titulo" => 'Guardias', "link" => base_url('Configuracion/guardias'));

        $model = new ConfiguracionModel();
        $data['empleados'] = $model->getEmpleados();

        //XLSX
        $data['scripts'][] = "https://bossanova.uk/jexcel/v3/jexcel.js";
        $data['styles'][] =  "https://bossanova.uk/jexcel/v3/jexcel.css";
        $data['scripts'][] = "https://bossanova.uk/jsuites/v2/jsuites.js";
        $data['styles'][] =  "https://bossanova.uk/jsuites/v2/jsuites.css";
        $data['scripts'][] = "https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.13.5/jszip.js";
        $data['scripts'][] = "https://bossanova.uk/jexcel/v3/xlsx.js";

        //Sweetalert
        $data['styles'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.css");
        $data['scripts'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.min.js");

        //Styles
        $data['styles'][] = base_url('assets/plugins/dropzone/min/dropzone.min.css');
        $data['styles'][] = base_url('assets/libs/select2/css/select2.min.css');
        $data['styles'][] = base_url('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css');
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');
        $data['styles'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css');

        //Scripts
        $data['scripts'][] = base_url('assets/plugins/dropzone/min/dropzone.min.js');
        $data['scripts'][] = base_url('assets/libs/select2/js/select2.full.min.js');
        $data['scripts'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js');
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
        $data['scripts'][] = base_url('assets/js/configuracion/guardias.js');

        //Vistas
        echo view('htdocs/header', $data);
        echo view('configuracion/guardias');
        echo view('configuracion/modalGuardias');
        echo view('htdocs/footer');
    } //guardias
    /*
      ______ _    _ _   _  _____ _____ ____  _   _ ______  _____
     |  ____| |  | | \ | |/ ____|_   _/ __ \| \ | |  ____|/ ____|
     | |__  | |  | |  \| | |      | || |  | |  \| | |__  | (___
     |  __| | |  | | . ` | |      | || |  | | . ` |  __|  \___ \
     | |    | |__| | |\  | |____ _| || |__| | |\  | |____ ____) |
     |_|     \____/|_| \_|\_____|_____\____/|_| \_|______|_____/
    */
    //Lia -> Guarda los permisos de un rol
    public function savePermisosRol()
    {
        $post = $this->request->getPost();
        $rolID = (int)encryptDecrypt('decrypt', $post['rol_RolID']);
        unset($post['rol_RolID']);
        $permisos = json_encode($post);
        $builder = db()->table("rol");
        $builder->update(array('rol_Permisos' => $permisos), array('rol_RolID' => $rolID));
        if ($this->db->affectedRows() > 0) {
            insertLog($this, session('id'), 'Actualizar', 'rol', $rolID);
            $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Datos actualizados correctamente!'));
        } else {
            $this->session->setFlashdata(array('response' => 'danger', 'txttoastr' => 'Los datos no cambiarón. Intente nuevamente.'));
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    } //savePermisosRol

    //Lia -> Guarda los nuevos roles o las actualizaciones
    public function saveRol()
    {
        $post = $this->request->getPost();
        $rolID = (int)encryptDecrypt('decrypt', $post['rol_RolID']);
        unset($post['rol_RolID']);
        $builder = db()->table("rol");
        if ($rolID > 0) {
            $builder->update($post, array('rol_RolID' => $rolID));
            if ($this->db->affectedRows() > 0) {
                insertLog($this, session('id'), 'Actualizar', 'rol', $rolID);
                $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Datos actualizados correctamente!'));
            } else {
                $this->session->setFlashdata(array('response' => 'danger', 'txttoastr' => 'Los datos no cambiarón. Intente nuevamente.'));
            }
        } else {
            $builder->insert($post);
            if ($this->db->insertID() > 0) {
                insertLog($this, session('id'), 'Insertar', 'rol', $this->db->insertID());
                $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Registro creado correctamente!'));
            } else {
                $this->session->setFlashdata(array('response' => 'danger', 'txttoastr' => 'Ha ocurrido un error al intentar registrar los datos. Intente nuevamente.'));
            }
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    } //saveRol

    //Diego->estatus hoario
    function cambioEstatusHorario($idHorario, $estatus)
    {
        $idHorario = encryptDecrypt('decrypt', $idHorario);
        $builder = db()->table("horario");
        $result = $builder->update(array('hor_Estatus' => (int)$estatus), array('hor_HorarioID' => (int)$idHorario));
        if ($result) {
            insertLog($this, session('id'), 'Cambio Estatus', 'horario', $idHorario);
            $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Se actualizó el estatus del horario correctamente!'));
        } else {
            $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error intente mas tarde!'));
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    } //end cambioEstatusHorario

    //Lia -> Guarda la configuracion de las prestaciones actuales
    public function guardarPrestacionesActuales()
    {
        $post = $this->request->getPost();

        //Preparando el json de la configuracion de los dias de vacaciones
        $diasVacaciones = array();
        for ($i = 0; $i < count($post['dias']); $i++) {
            $row = array("periodo" => $post['periodo'][$i], "dias" => $post['dias'][$i]);
            array_push($diasVacaciones, $row);
        }
        //Preparando el json de la configuracion de la prima
        $primas = array();
        for ($i = 0; $i < count($post['prima']); $i++) {
            $row = array("periodoP" => $post['periodoP'][$i], "prima" => $post['prima'][$i]);
            array_push($primas, $row);
        }
        //Preparando el json de la configuracion del aguinaldo
        $aguinaldos = array();
        for ($i = 0; $i < count($post['aguinaldo']); $i++) {
            $row = array("periodoA" => $post['periodoA'][$i], "aguinaldo" => $post['aguinaldo'][$i]);
            array_push($aguinaldos, $row);
        }

        //Preparando el array de los datos de la tabla
        $data = array(
            "vco_DiasVacaciones" => json_encode($diasVacaciones),
            "vco_Prima" => json_encode($primas),
            "vco_Aguinaldo" => json_encode($aguinaldos),
            "vco_Tipo" => $post['tipo'],
        );

        $builder = db()->table("vacacionconfig");
        //Saber is ya se guardo alguna configuracion de la empresa
        $config = $builder->getWhere(array("vco_Tipo" => 'Actual'))->getRowArray();
        if ($config) {
            $res = $builder->update($data, array("vco_Tipo" => 'Actual'));
            insertLog($this, session('id'), 'Actualizar', 'vacacionconfig', 1);
        } else {
            $res = $builder->insert($data);
            insertLog($this, session('id'), 'Insertar', 'vacacionconfig', 1);
        }

        if ($res) {
            $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Datos guardados correctamente!'));
        } else {
            $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Intente nuevamente!'));
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    } //end guardarPrestacionesActuales

    //Lia -> Guarda la configuracion de las prestaciones adicionales
    public function guardarPrestacionesAadicionales()
    {
        $post = $this->request->getPost();
        //Preparando el json de la configuracion prestamos
        $prestamos = array();
        for ($i = 0; $i < count($post['diasPrestamo']); $i++) {
            $row = array("periodo" => $post['periodoPrestamos'][$i], "dias" => $post['diasPrestamo'][$i], "plazo" => $post['plazo'][$i]);
            array_push($prestamos, $row);
        }

        //Preparando el array de los datos de la tabla
        $data = array(
            "pre_Prestamo" => json_encode($prestamos),
        );

        $builder = db()->table("prestacion");
        //Saber is ya se guardo alguna configuracion de la empresa
        $config = $this->db->query("SELECT * FROM prestacion")->getRowArray();
        if ($config) {
            $res = $builder->update($data);
            insertLog($this, session('id'), 'Actualizar', 'prestacion', 1);
        } else {
            $res = $builder->insert($data);
            insertLog($this, session('id'), 'Insertar', 'prestacion', 1);
        }

        if ($res) {
            $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡La configuración de las prestaciones adicionales se ha guardado correctamente!'));
        } else {
            $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Intente nuevamente!'));
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    } //end guardarPrestacionesActuales

    //Diego->estatus expediente
    function addExpediente()
    {
        $post = $this->request->getPost();
        $builder = db()->table('expediente');
        if ($post['expedienteID'] <= 0) {
            $data = array(
                'exp_Nombre' =>  $post['nombre'],
                'exp_Categoria' =>  $post['categoria'],
                'exp_Numero' =>  $post['numero'],
                'exp_EmpleadoID' =>  session('id'),
            );
            $builder->insert($data);
            $result = $this->db->insertID();
            if ($result) {
                insertLog($this, session('id'), 'Insertar', 'expediente', $result);
                $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Se registro el expediente correctamente!'));
            } else {
                $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error al registro intente mas tarde!'));
            }
        } else {
            $result = $builder->update(array(
                'exp_Nombre' => $post['nombre'], 'exp_Categoria' => $post['categoria'],
                'exp_Numero' => $post['numero']
            ), array('exp_ExpedienteID' => (int)$post['expedienteID']));
            if ($result) {
                insertLog($this, session('id'), 'Actualizar', 'expediente', $post['expedienteID']);
                $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Se actualizó el expediente correctamente!'));
            } else {
                $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error al actualizar intente mas tarde!'));
            }
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    } //end addExpediente

    //Diego->estatus expediente
    function estatusExpediente($estatus, $idExpediente)
    {
        $idExpediente = encryptDecrypt('decrypt', $idExpediente);
        $builder = db()->table("expediente");
        $result = $builder->update(array('exp_Estatus' => (int)$estatus), array('exp_ExpedienteID' => (int)$idExpediente));
        if ($result) {
            insertLog($this, session('id'), 'Cambio Estatus', 'expediente', $idExpediente);
            $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Se actualizó el expediente correctamente!'));
        } else {
            $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error intente mas tarde!'));
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    } //end estatusExpediente

    //Diego-> guardar guardia
    public function addGuardia()
    {
        $post = $this->request->getPost();
        $fechas = explode('al', $post['txtFechas']);
        $guardiaHorario=4;
        if((int)encryptDecrypt('decrypt', $post['colaborador'])!==105){
            $guardiaHorario=2;
        }
        $data = array(
            "gua_EmpleadoID" => (int)encryptDecrypt('decrypt', $post['colaborador']),
            "gua_FechaInicio" => str_replace(' ', '', $fechas[0]),
            "gua_FechaFin" => str_replace(' ', '', $fechas[1]),
            "gua_EmpleadoIDCreo" => session('id')
        );
        $builder = db()->table('guardia');
        $response = $builder->insert($data);
        if ($response) {
            $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Se ha guardado la guardia correctamente!'));
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

    //Diego->Trae todos los dias inhabiles
    public function ajax_getDiasInhabiles()
    {
        $model = new ConfiguracionModel();
        $dias = $model->getDiasInhabiles();
        $data_events = array();

        foreach ($dias as $d) {
            $data_events[] = array(
                "ID" => encryptDecrypt('encrypt', $d['dia_DiaInhabilID']),
                "title" => $d['dia_Motivo'],
                "start" => $d['dia_Fecha'],
                'bd' => 'diainhabil',
                "end" => $d['dia_Fecha'],
                'eliminar' => 'si',
                "backgroundColor" => "#2a7c7d",
            );
        }
        echo json_encode(array("events" => $data_events));
    } //end ajax_getDiasInhabiles

    //Diego->Trae todos los dias inhabiles ley
    public function ajax_getDiasInhabilesLey()
    {
        $model = new ConfiguracionModel();
        $dias = $model->getDiasInhabilesLey();
        $data_events = array();

        foreach ($dias as $d) {
            $data_events[] = array(
                "ID" => encryptDecrypt('encrypt', $d['dial_DiaInhabilLeyID']),
                "title" => $d['dial_Motivo'],
                "start" => $d['dial_Fecha'],
                "end" => $d['dial_Fecha'],
                'bd' => 'diainhabilley',
                'eliminar' => 'no',
                "backgroundColor" => "#f1556c",
            );
        }
        echo json_encode(array("events" => $data_events));
    } //end ajax_getDiasInhabilesLey

    //Diego->Informacion del dia inhabil
    public function ajax_getDiaInhabil($idDiaInhabil, $bd)
    {
        $idDiaInhabil = encryptDecrypt('decrypt', $idDiaInhabil);
        if ($bd === 'diainhabil') {
            $dias = $this->db->query("SELECT DI.* FROM diainhabil DI WHERE DI.dia_DiaInhabilID=" . $idDiaInhabil)->getRowArray();

            $sucursales = json_decode($dias['dia_SucursalID']);
            $txt = "";
            foreach ($sucursales as $sucursal) {
                if ($sucursal == 0) {
                    $txt = "<span class='badge badge-purple'>Todos</span> ";
                } else {
                    $sql = "SELECT suc_Sucursal FROM sucursal WHERE suc_SucursalID= ?";
                    $nomSuc = $this->db->query($sql, array($sucursal))->getRowArray();
                    $txt .= "<span class='badge badge-purple'>" . $nomSuc['suc_Sucursal'] . "</span> ";
                }
            }

            $dia = array(
                'dia_Motivo' => $dias['dia_Motivo'],
                'dia_DiaInhabilID' => $dias['dia_DiaInhabilID'],
                'dia_Fecha' => $dias['dia_Fecha'],
                'sucursal' => $txt,
            );
        } else {
            $dias = $this->db->query("SELECT DI.*, DI.dial_Motivo as 'dia_Motivo' FROM diainhabilley DI WHERE DI.dial_DiaInhabilLeyID=" . $idDiaInhabil)->getRowArray();
            $dia = array(
                'dia_Motivo' => $dias['dia_Motivo'],
                'sucursal' => "<span class='badge badge-purple'>Todas</span>",
            );
        }
        echo json_encode(array("response" => "success", "dia" => $dia));
    } //end ajax_getDiaInhabil

    //Diego->Añadir dia inhabil
    public function ajax_addDiaInhabil()
    {
        $post = $this->request->getPost();
        $sucursal = json_encode($post['sucursales']);
        if ($post['dia_MedioDia'] == 1) {
            $post['dia_Motivo'] = $post['dia_Motivo'] . '(Media Jornada)';
        }
        $data = array(
            "dia_Fecha" => $post['dia_Fecha'],
            "dia_Motivo" => $post['dia_Motivo'],
            "dia_SucursalID" => $sucursal,
            "dia_EmpleadoID" => session('id'),
            "dia_MedioDia" => $post['dia_MedioDia'],
        );

        $builder = db()->table("diainhabil");
        $builder->insert($data);
        $result = $this->db->insertID();
        insertLog($this, session('id'), 'Insertar', 'diainhabil', $result);
        echo json_encode(array("response" => "success", "fecha" => $post['dia_Fecha']));
    } //end ajax_addDiaInhabil

    //Diego->Eliminar un dia inhabil
    public function ajax_eliminarDiaInhabil($idDiaInhabil)
    {
        $idDiaInhabil = encryptDecrypt('decrypt', $idDiaInhabil);
        $builder = db()->table("diainhabil");
        $builder->delete(array('dia_DiaInhabilID' => $idDiaInhabil));
        insertLog($this, session('id'), 'Eliminar', 'diainhabil', $idDiaInhabil);
        echo json_encode(array("response" => "success"));
    } //end ajax_eliminarDiaInhabil

    //Lia->trae los puestos
    public function ajax_getSucursales()
    {
        $result = $this->db->query("SELECT * FROM sucursal WHERE suc_Estatus=1")->getResultArray();
        echo json_encode(array("info" => $result));
    } //end ajax_getSucursales

    //HUGO->Get lista de horarios
    public function ajax_getHorarios()
    {
        $model = new ConfiguracionModel();
        $horarios = $model->getHorarios();
        $h = array();
        $arrHorarios = array();
        foreach ($horarios as $horario) {
            $h['hor_HorarioID'] = encryptDecrypt('encrypt', $horario['hor_HorarioID']);
            $h['hor_Nombre'] = $horario['hor_Nombre'];
            $h['hor_LunesDescanso'] = $horario['hor_LunesDescanso'];
            $h['hor_LunesEntrada'] = $horario['hor_LunesEntrada'];
            $h['hor_LunesSalida'] = $horario['hor_LunesSalida'];
            $h['hor_MartesDescanso'] = $horario['hor_MartesDescanso'];
            $h['hor_MartesEntrada'] = $horario['hor_MartesEntrada'];
            $h['hor_MartesSalida'] = $horario['hor_MartesSalida'];
            $h['hor_MiercolesDescanso'] = $horario['hor_MiercolesDescanso'];
            $h['hor_MiercolesEntrada'] = $horario['hor_MiercolesEntrada'];
            $h['hor_MiercolesSalida'] = $horario['hor_MiercolesSalida'];
            $h['hor_JuevesDescanso'] = $horario['hor_JuevesDescanso'];
            $h['hor_JuevesEntrada'] = $horario['hor_JuevesEntrada'];
            $h['hor_JuevesSalida'] = $horario['hor_JuevesSalida'];
            $h['hor_ViernesDescanso'] = $horario['hor_ViernesDescanso'];
            $h['hor_ViernesEntrada'] = $horario['hor_ViernesEntrada'];
            $h['hor_ViernesSalida'] = $horario['hor_ViernesSalida'];
            $h['hor_SabadoDescanso'] = $horario['hor_SabadoDescanso'];
            $h['hor_SabadoEntrada'] = $horario['hor_SabadoEntrada'];
            $h['hor_SabadoSalida'] = $horario['hor_SabadoSalida'];
            $h['hor_DomingoDescanso'] = $horario['hor_DomingoDescanso'];
            $h['hor_DomingoEntrada'] = $horario['hor_DomingoEntrada'];
            $h['hor_DomingoSalida'] = $horario['hor_DomingoSalida'];
            $h['hor_Estatus'] = $horario['hor_Estatus'];
            $h['hor_Tolerancia'] = $horario['hor_Tolerancia'];
            array_push($arrHorarios, $h);
        }
        $data['data'] = $arrHorarios;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_getHorarios

    //HUGO->Save schedule
    public function ajax_saveSchedule()
    {
        $horario['hor_Nombre'] = post('txtNombre');

        //Lunes
        $descLunes = post('ckLunes') == null ? 0 : 1;
        $horario['hor_LunesDescanso'] = $descLunes;
        $horario['hor_LunesEntrada'] = post('lunesE');
        $horario['hor_LunesSalida'] = post('lunesS');

        //Martes
        $descMartes = post('ckMartes') == null ? 0 : 1;
        $horario['hor_MartesDescanso'] = $descMartes;
        $horario['hor_MartesEntrada'] = post('martesE');
        $horario['hor_MartesSalida'] = post('martesS');

        $descMiercoles = post('ckMiercoles') == null ? 0 : 1;
        $horario['hor_MiercolesDescanso'] = $descMiercoles;
        $horario['hor_MiercolesEntrada'] = post('miercolesE');
        $horario['hor_MiercolesSalida'] = post('miercolesS');

        $descJueves = post('ckJueves') == null ? 0 : 1;
        $horario['hor_JuevesDescanso'] = $descJueves;
        $horario['hor_JuevesEntrada'] = post('juevesE');
        $horario['hor_JuevesSalida'] = post('juevesS');

        $descViernes = post('ckViernes') == null ? 0 : 1;
        $horario['hor_ViernesDescanso'] = $descViernes;
        $horario['hor_ViernesEntrada'] = post('viernesE');
        $horario['hor_ViernesSalida'] = post('viernesS');

        $descSabado = post('ckSabado') == null ? 0 : 1;
        $horario['hor_SabadoDescanso'] = $descSabado;
        $horario['hor_SabadoEntrada'] = post('sabadoE');
        $horario['hor_SabadoSalida'] = post('sabadoS');

        $descDomingo = post('ckDomingo') == null ? 0 : 1;
        $horario['hor_DomingoDescanso'] = $descDomingo;
        $horario['hor_DomingoEntrada'] = post('domingoE');
        $horario['hor_DomingoSalida'] = post('domingoS');

        $horario['hor_Tolerancia'] = (int)post("txtTolerancia");
        $builder = db()->table("horario");
        $response = $builder->insert($horario);
        $data['code'] = $response ? 1 : 0;

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_saveSchedule

    //HUGO->Update schedule
    public function ajax_updateSchedule()
    {
        $scheduleID = (int)encryptDecrypt('decrypt', post("txtHorarioID"));
        $horario['hor_Nombre'] = post('txtNombreEdit');

        //Lunes
        $descLunes = post('ckLunes') == null ? 0 : 1;
        $horario['hor_LunesDescanso'] = $descLunes;
        $horario['hor_LunesEntrada'] = post('lunesE');
        $horario['hor_LunesSalida'] = post('lunesS');

        //Martes
        $descMartes = post('ckMartes') == null ? 0 : 1;
        $horario['hor_MartesDescanso'] = $descMartes;
        $horario['hor_MartesEntrada'] = post('martesE');
        $horario['hor_MartesSalida'] = post('martesS');

        $descMiercoles = post('ckMiercoles') == null ? 0 : 1;
        $horario['hor_MiercolesDescanso'] = $descMiercoles;
        $horario['hor_MiercolesEntrada'] = post('miercolesE');
        $horario['hor_MiercolesSalida'] = post('miercolesS');

        $descJueves = post('ckJueves') == null ? 0 : 1;
        $horario['hor_JuevesDescanso'] = $descJueves;
        $horario['hor_JuevesEntrada'] = post('juevesE');
        $horario['hor_JuevesSalida'] = post('juevesS');

        $descViernes = post('ckViernes') == null ? 0 : 1;
        $horario['hor_ViernesDescanso'] = $descViernes;
        $horario['hor_ViernesEntrada'] = post('viernesE');
        $horario['hor_ViernesSalida'] = post('viernesS');

        $descSabado = post('ckSabado') == null ? 0 : 1;
        $horario['hor_SabadoDescanso'] = $descSabado;
        $horario['hor_SabadoEntrada'] = post('sabadoE');
        $horario['hor_SabadoSalida'] = post('sabadoS');

        $descDomingo = post('ckDomingo') == null ? 0 : 1;
        $horario['hor_DomingoDescanso'] = $descDomingo;
        $horario['hor_DomingoEntrada'] = post('domingoE');
        $horario['hor_DomingoSalida'] = post('domingoS');

        $horario['hor_Tolerancia'] = (int)post("txtToleranciaEdit");
        $builder = db()->table("horario");
        $response = $builder->update($horario, array('hor_HorarioID' => $scheduleID));
        $data['code'] = $response ? 1 : 0;

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_saveSchedule

    //HUGO->Get schedule
    public function ajax_getSchedule()
    {
        $model = new ConfiguracionModel();
        $scheduleID = (int)encryptDecrypt('decrypt', post("horarioID"));
        $horario = $model->getScheduleByID($scheduleID);
        $h = array();

        $h['hor_HorarioID'] = encryptDecrypt('encrypt', $horario['hor_HorarioID']);
        $h['hor_Nombre'] = $horario['hor_Nombre'];
        $h['hor_LunesDescanso'] = $horario['hor_LunesDescanso'];
        $h['hor_LunesEntrada'] = $horario['hor_LunesEntrada'];
        $h['hor_LunesSalida'] = $horario['hor_LunesSalida'];
        $h['hor_MartesDescanso'] = $horario['hor_MartesDescanso'];
        $h['hor_MartesEntrada'] = $horario['hor_MartesEntrada'];
        $h['hor_MartesSalida'] = $horario['hor_MartesSalida'];
        $h['hor_MiercolesDescanso'] = $horario['hor_MiercolesDescanso'];
        $h['hor_MiercolesEntrada'] = $horario['hor_MiercolesEntrada'];
        $h['hor_MiercolesSalida'] = $horario['hor_MiercolesSalida'];
        $h['hor_JuevesDescanso'] = $horario['hor_JuevesDescanso'];
        $h['hor_JuevesEntrada'] = $horario['hor_JuevesEntrada'];
        $h['hor_JuevesSalida'] = $horario['hor_JuevesSalida'];
        $h['hor_ViernesDescanso'] = $horario['hor_ViernesDescanso'];
        $h['hor_ViernesEntrada'] = $horario['hor_ViernesEntrada'];
        $h['hor_ViernesSalida'] = $horario['hor_ViernesSalida'];
        $h['hor_SabadoDescanso'] = $horario['hor_SabadoDescanso'];
        $h['hor_SabadoEntrada'] = $horario['hor_SabadoEntrada'];
        $h['hor_SabadoSalida'] = $horario['hor_SabadoSalida'];
        $h['hor_DomingoDescanso'] = $horario['hor_DomingoDescanso'];
        $h['hor_DomingoEntrada'] = $horario['hor_DomingoEntrada'];
        $h['hor_DomingoSalida'] = $horario['hor_DomingoSalida'];
        $h['hor_Estatus'] = $horario['hor_Estatus'];
        $h['hor_Tolerancia'] = $horario['hor_Tolerancia'];

        $data['schedule'] = $h;
        $data['code'] = 1;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_getSchedule

    //Lia->Tre los roles
    public function ajaxGetRoles()
    {
        $model = new ConfiguracionModel();
        $roles = $model->getRoles();
        $r = array();
        $arrRoles = array();

        $cont = 1;
        foreach ($roles as $rol) {
            $r['rol_RolID'] = encryptDecrypt('encrypt', $rol['rol_RolID']);
            $r['rol_Nombre'] = $rol['rol_Nombre'];
            $r['rol_Permisos'] = $rol['rol_Permisos'];
            $r['rol_Estatus'] = $rol['rol_Estatus'];
            $r['cont'] = $cont;

            $cont++;
            array_push($arrRoles, $r);
        }

        $data['data'] = $arrRoles;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajaxGetRoles

    //Lia -> Obtiene la informacion de un rol segun su id
    public function ajaxGetRolByID()
    {
        $model = new ConfiguracionModel();
        $rolID = post('rolID');
        $datos = $model->getRolByID($rolID);
        $code = is_null($datos) ? 0 : 1;
        echo json_encode(array('code' => $code, 'info' => $datos));
    } //ajaxGetRolByID

    //Lia -> Cambia el estatus del rol a 0
    public function ajaxDeleteRol()
    {
        $rolID = (int)encryptDecrypt('decrypt', post("rolID"));
        $builder = db()->table("rol");
        $builder->update(array('rol_Estatus' => 0), array('rol_RolID' => $rolID));
        if ($this->db->affectedRows() > 0) {
            insertLog($this, session('id'), 'Cambio Estatus', 'rol', $rolID);
            $data['code'] = 1;
        } else $data['code'] = 0;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //deleteRol

    //Lia -> Obtiene la informacion de los permisos de un rol segun su id
    public function ajaxGetPermisosByRol()
    {
        $model = new ConfiguracionModel();
        $rolID = post('rolID');
        $datos = $model->getPermisosByRol($rolID);
        $code = is_null($datos) ? 0 : 1;
        echo json_encode(array('code' => $code, 'funciones' => $datos['funciones'], 'permisos' => $datos['permisos']));
    } //ajaxGetPermisosByRol

    //HUGO->Get configuracion de permisos
    public function ajax_getConfiguracionPermisos()
    {
        $model = new ConfiguracionModel();
        $permisos = $model->getConfiguracionPermisos();

        $arrPermisos = array();
        foreach ($permisos as $permiso) {
            if ($permiso['cat_Dias'] == 0) $dias = 'Sin limite';
            else $dias = $permiso['cat_Dias'];
            $permiso['cat_CatalogoPermisoID'] = encryptDecrypt('encrypt', $permiso['cat_CatalogoPermisoID']);
            $permiso['cat_Dias'] = $dias;
            array_push($arrPermisos, $permiso);
        }

        $data['data'] = $arrPermisos;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_getConfiguracionPermisos

    //Diego-> cambiar estdo del permiso
    public function ajaxCambiarEstadoPermiso()
    {
        $permisoID = (int)encryptDecrypt('decrypt', post("permisoID"));
        $estado = post("estado");
        $builder = db()->table("catalogopermiso");
        $response = $builder->update(array('cat_Estatus' => $estado), array("cat_CatalogoPermisoID" => $permisoID));
        $data['code'] = $response ? 1 : 0;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajaxCambiarEstadoPermiso

    //HUGO->Get calatogo permisos by id
    public function ajax_getCatalogoPermisoById()
    {
        $catalogoID = post("catalogoID");
        $model = new ConfiguracionModel();
        $data['catalogo'] = $model->getConfiguracionPermisosById($catalogoID);
        $data['code'] = 1;

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_getCatalogoPermisoById

    //HUGO->Actualizar catalogo permisos
    public function  ajax_updateCatalogoPermisos()
    {
        $catalogo = array(
            "cat_Dias" => (int)post("dias"),
        );
        $builder = db()->table('catalogopermiso');
        $response = $builder->update($catalogo, array('cat_CatalogoPermisoID' => (int)encryptDecrypt('decrypt', post("id"))));
        $data['code'] = $response ? 1 : 0;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_updateCatalogoPermisos

    //Lia->Get lista de archivos para el checklist de empleados al ingreso o egreso de la empresa
    public function ajax_getChecklistIngresoEgreso()
    {
        $model = new ConfiguracionModel();
        $checklist = $model->getChecklistIngresoEgreso();
        $arrCheck = array();
        foreach ($checklist as $check) {
            $txt = "";

            $personas = json_decode($check['responsable']);
            foreach ($personas as $persona) {
                $sql = "SELECT emp_Nombre FROM empleado WHERE emp_EmpleadoID= ?";
                $nombre = $this->db->query($sql, array($persona))->getRowArray();
                $txt .= "<span class='badge badge-purple'>" . $nombre['emp_Nombre'] . "</span> ";
            }

            $check['responsable'] = $txt;

            array_push($arrCheck, $check);
        }

        $data['data'] = $arrCheck;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_getChecklistIngresoEgreso

    //Lia->Guardar checklist ingreso egreso
    public function ajax_guardarCheklist()
    {
        $post = $this->request->getPost();
        $responsable = json_encode($post['resposable']);
        $checklist = array(
            "cat_Nombre" => $post['nombre'],
            "cat_ResponsableID" => $responsable,
            "cat_Tipo" => $post['tipo'],
            "cat_Requerido" => $post['requerido'],
        );
        $builder = db()->table("catalogochecklist");
        $response = $builder->insert($checklist);
        $data['code'] = $response ? 1 : 0;

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_guardarCheklist

    //Lia->Update estatus checklist
    public function ajax_changeEstatusChecklist()
    {
        $checklistID = (int)post("id");
        $estatus = (int)post("status");

        $builder = db()->table("catalogochecklist");
        $response = $builder->update(array("cat_Estatus" => $estatus), array("cat_CatalogoID" => $checklistID));
        $data['code'] = $response ? 1 : 0;

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_changeEstatusChecklist

    //Lia->Get checklist by id
    public function ajax_getCheklist()
    {
        $id = (int)post('id');
        $model = new ConfiguracionModel();
        $data['checklist'] = $model->getChecklistByID($id);
        $data['code'] = 1;

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_getCheklist

    //Lia->Update checklist
    public function ajax_updateCheklist()
    {
        $post = $this->request->getPost();
        $catalogoID = (int)$post["id"];
        $responsable = json_encode($post['responsable']);
        $checklist = array(
            "cat_Nombre" => $post['nombre'],
            "cat_ResponsableID" => $responsable,
            "cat_Tipo" => $post['tipo'],
            "cat_Requerido" => $post['requerido'],
        );

        $builder = db()->table("catalogochecklist");

        $where = array("cat_CatalogoID" => $catalogoID);
        $response = $builder->update($checklist, $where);
        $data['code'] = $response ? 1 : 0;

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_updateCheklist

    //Diego-> traer guardias
    public function ajax_getGuardia()
    {
        $guardias = $this->db->query("SELECT G.*,E.emp_Nombre FROM guardia G JOIN empleado E ON E.emp_EmpleadoID=G.gua_EmpleadoID WHERE emp_Estatus=1")->getResultArray();
        $data = array();
        foreach ($guardias as $guardia) {
            $guardia['gua_GuardiaID'] = encryptDecrypt('encrypt', $guardia['gua_GuardiaID']);
            $guardia['gua_FechaInicio'] = longDate($guardia['gua_FechaInicio'], ' de ');
            $guardia['gua_FechaFin'] = longDate($guardia['gua_FechaFin'], ' de ');
            unset($guardia['gua_EmpleadoID']);
            unset($guardia['gua_EmpleadoIDCreo']);
            unset($guardia['gua_HorarioID']);
            array_push($data, $guardia);
        }
        $data['data'] = $data;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    //Guarda los registros de asistencia
    public function ajaxGuardarRegistroGuardias()
    {
        $post = $this->request->getPost();
        $datos = json_decode($post['datos']);
        $datos = (array) $datos;
        $now = date('Y-m-d H:i:s');
        $this->db->transStart();
        $count = 0;
        foreach ($datos as $key => $value) {
            if (empty((array) $value)) {
                unset($datos[$key]);
            }
        }
        foreach ($datos as $row) {
            $row = (array) $row;
            //Consulta el datos del empleado
            $empleado = db()->query("SELECT emp_EmpleadoID FROM empleado WHERE emp_Numero=? AND emp_Estatus=1",[(int)$row['colaborador']])->getRowArray();

            if (!empty($empleado['emp_EmpleadoID'])) {
                if(get_nombre_dia($row['fecha sabado'])=='Domingo'){
                    $fecha = $row['fecha sabado'];
                    $row['fecha sabado'] =date('Y-m-d', strtotime("{$fecha} -1 day"));
                }

                //Consulta si ya se subio la asistencia de esas fechas
                $sql = "SELECT * FROM guardia WHERE gua_EmpleadoID= ? AND ? BETWEEN gua_FechaInicio AND gua_FechaFin";
                $asistencia = db()->query($sql, array($empleado['emp_EmpleadoID'], $row['fecha sabado']))->getResultArray();

                if (count($asistencia) <= 0) {
                    //Guardar registro
                    $row['fecha inicio'] =date('Y-m-d', strtotime($row['fecha sabado']." -5 day"));
                    $row['fecha fin'] =$row['fecha sabado'];
                    $horarioGuardia=2;
                    if($empleado['emp_EmpleadoID']==105){$horarioGuardia=4;}
                    $dataA = array(
                        'gua_EmpleadoID' =>(int) $empleado['emp_EmpleadoID'],
                        'gua_FechaInicio' => $row['fecha inicio'],
                        'gua_FechaFin' => $row['fecha fin'],
                        'gua_EmpleadoIDCreo' => session('id'),
                        'gua_HorarioID' => $horarioGuardia,
                    );
                    $builder = db()->table("guardia");
                    $builder->insert($dataA);
                    $count =0;
                }  else {
                    $count += 1;
                }
            }
        }

        $data['registro'] = $now;
        if ($count > 0) {
            $data['code'] = 2;
        } else {
            if ($this->db->transStatus() === false) {
                $this->db->transRollback();
                $data['code'] = 0;
            } else {
                $this->db->transCommit();
                $data['code'] = 1;
            }
        }

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    //Diego -> eliminar guardia
    public function ajax_EliminarGuardia()
    {
        $post = $this->request->getPost();
        $response = $this->db->query("DELETE FROM guardia WHERE gua_GuardiaID=" . encryptDecrypt('decrypt', $post['guardiaID']));
        if ($response) {
            echo json_encode(array("code" => 1));
        } else {
            echo json_encode(array("code" => 0));
        }
    }

    //Sube y guarda la lista de asistencia
    public function previewPlantilla()
    {

        if (isset($_FILES['file'])) {
            $directorio = FCPATH . "/assets/uploads/guardias/";

            if (!file_exists($directorio)) {
                mkdir($directorio, 0777, true);
            }

            $path = $_FILES['file']['name'];
            $ext = pathinfo($path, PATHINFO_EXTENSION);

            $nombre_archivo = date("Y-m-d-H-i-s") . '.' . $ext;
            $ruta = $directorio . $nombre_archivo;

            if (move_uploaded_file($_FILES['file']['tmp_name'], $ruta)) {
                echo json_encode(array("response" => "success", 'nombre' => $nombre_archivo));
            }
        }
    }

    public function actualizarSabado(){
        $guardias = db()->query("SELECT * FROM guardia")->getResultArray();
        foreach($guardias as $g){
            $fechafin = $g['gua_FechaFin'];
            if(get_nombre_dia($fechafin)=='Domingo'){
                $fechaFinUp =date('Y-m-d', strtotime("{$fechafin} -1 day"));
            }
            $builder = db()->table('guardia');
            $builder->update(array('gua_FechaFin' => $fechaFinUp), array('gua_GuardiaID' => $g['gua_GuardiaID']));
        }
    }
}
