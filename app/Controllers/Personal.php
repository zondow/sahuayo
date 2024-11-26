<?php

namespace App\Controllers;

defined('FCPATH') or exit('No direct script access allowed');

class Personal extends BaseController
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


    //Lia-> catalogo de colaboradores
    public function empleados()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Plantilla';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Plantilla', "link" => base_url('Personal/empleados'), "class" => "active"),
        );

        $data['colaboradores'] = $this->PersonalModel->getColaboradores();
        $data['puestos'] = $this->BaseModel->getPuestos();
        $data['areas'] = $this->BaseModel->getAreas();
        $data['departamentos'] = $this->BaseModel->getDepartamentos();
        $data['horarios'] = $this->PersonalModel->getHorarios();
        $data['roles'] = $this->PersonalModel->getRoles();
        $data['colaboradoresbaja'] = $this->PersonalModel->getBajas();
        $data['estados'] = $this->PersonalModel->getEstados();
        $data['sucursales'] = $this->PersonalModel->getSucursales();

        //Load plugins
        load_plugins(['datepicker', 'select2', 'datatables_buttons', 'sweetalert2', 'modalConfirmation', 'modalPdf'], $data);

        //Custom script
        $data['scripts'][] = base_url('assets/js/personal/empleadosActivos.js');
        $data['scripts'][] = base_url('assets/js/personal/modalColaborador.js');
        $data['scripts'][] = base_url('assets/js/personal/modalDatosAcceso.js');
        $data['scripts'][] = base_url('assets/js/personal/onboarding.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('personal/empleados', $data);
        echo view('personal/modalAgregarColaborador', $data);
        echo view('personal/modalDatosAcceso', $data);
        echo view('personal/modalOnboarding', $data);
        echo view('personal/modalFotoColaborador', $data);
        echo view('htdocs/modalPdf', $data);
        //echo view('htdocs/modalConfirmation', $data);
        echo view('htdocs/footer', $data);
    } //end empleados


    //Lia -> Lista de colaboradores dados de baja
    public function bajaEmpleados()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Baja de personal';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Baja de personal', "link" => base_url('Personal/bajaEmpleados'), "class" => "active"),
        );


        $data['colaboradores'] = $this->PersonalModel->getBajas();
        $data['colaboradoresbaja'] = $this->PersonalModel->getBajas();

        //load plugins
        load_plugins(['datepicker', 'select2', 'datatables_buttons', 'sweetalert2', 'modalConfirmation', 'modalPdf'], $data);

        //Custom script
        $data['scripts'][] = base_url('assets/js/personal/empleadosBaja.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('personal/empleadosBaja', $data);
        echo view('personal/modalFechaSalida', $data);
        echo view("htdocs/modalPdf", $data);
        echo view('htdocs/footer', $data);
    } //bajaEmpleados

    //Lia-> catalogo de colaboradores
    public function onboarding($empleadoID)
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Onboarding (entrada)';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Catálogo de empleados', "link" => base_url('Personal/empleados'), "class" => "active"),
            array("titulo" => 'Onboarding (Checklist entrada)', "link" => base_url('Personal/onboarding/' . $empleadoID), "class" => "active"),
        );

        $model = new PersonalModel();
        $data['colaborador'] = $model->getInfoColaboradorByID($empleadoID);
        $data['colaborador']['emp_EmpleadoID'] = encryptDecrypt('encrypt', $data['colaborador']['emp_EmpleadoID']);
        $data['colaborador']['pue_Nombre'] = $this->db->query("SELECT pue_Nombre FROM puesto WHERE pue_PuestoID=" . encryptDecrypt('decrypt', $data['colaborador']['emp_PuestoID']))->getRowArray()['pue_Nombre'];
        $data['checklist'] = $model->getChecklist('Ingreso');
        $data['empleadoID'] = $empleadoID;
        $data['total'] = $this->db->query("SELECT COUNT(cat_CatalogoID) as 'total' FROM catalogochecklist WHERE cat_Tipo='Ingreso' AND cat_Requerido=1")->getRowArray()['total'];
        $data['totalCheck'] = $model->getTotalCheck('Ingreso', encryptDecrypt('decrypt', $empleadoID));
        //$data['cartas']=$model->getCartasResguardoColaboradorByID(encryptDecrypt('decrypt',$empleadoID));

        //Styles
        $data['styles'][] = base_url('assets/libs/spinkit/spinkit.css');
        $data['styles'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css');
        $data['styles'][] = base_url('assets/libs/select2/css/select2.min.css');
        $data['styles'][] = base_url('assets/libs/custombox/custombox.min.css');
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');
        $data['styles'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.css');

        //Scripts
        $data['scripts'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js');
        $data['scripts'][] = base_url('assets/libs/select2/js/select2.full.min.js');
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
        $data['scripts'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.js');

        $data['scripts'][] = base_url('assets/js/personal/onboarding.js');


        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('personal/onboarding', $data);
        echo view('htdocs/footer', $data);
    }


    //Diego -> Vista Expediente
    public  function expediente($empleadoID, $usuario = NULL)
    {
        $empleadoID = encryptDecrypt('decrypt', $empleadoID);

        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        if (isset($usuario)) {
            $data['title'] = 'Expediente';
            $data['breadcrumb'] = array(
                array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
                array("titulo" => 'Catálogo de empleados', "link" => base_url('Personal/empleados'), "class" => ""),
                array("titulo" => 'Expediente', "link" => base_url('Personal/expediente/' . $empleadoID), "class" => ""),
            );
        } else {
            $data['title'] = 'Expediente';
            $data['breadcrumb'] = array(
                array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
                array("titulo" => 'Mi perfil', "link" => base_url('Usuario/miPerfil'), "class" => ""),
                array("titulo" => 'Expediente', "link" => base_url('Personal/expediente/' . $empleadoID), "class" => ""),
            );
        }

        //Styles
        $data['styles'][] = base_url('assets/libs/select2/css/select2.min.css');
        $data['styles'][] = base_url('assets/libs/custombox/custombox.min.css');
        $data['styles'][] = base_url('assets/libs/dropzone/dropzone.min.css');
        $data['styles'][] = base_url('assets/libs/lightbox/css/lightbox.css');

        //Scripts
        $data['scripts'][] = base_url('assets/libs/select2/js/select2.full.min.js');
        $data['scripts'][] = base_url('assets/libs/lightbox/js/lightbox.js');
        $data['scripts'][] = base_url('assets/libs/custombox/custombox.min.js');
        $data['scripts'][] = base_url('assets/libs/dropzone/dropzone.min.js');
        $data['scripts'][] = base_url('assets/js/modalPdf.js');
        $data['scripts'][] = base_url('assets/js/personal/expediente.js');

        //Expediente
        $model = new PersonalModel();
        $data['empleadoID'] = $empleadoID;
        $data['expedientes'] = $model->getDatosExpediente();
        $data['empleado'] = $this->db->query("SELECT emp_Nombre FROM empleado WHERE emp_EmpleadoID=" . $empleadoID)->getRowArray()['emp_Nombre'];
        $data['usuario'] = $usuario;
        $data['C1'] = $model->getDocumentosC1(); //'Externos'
        $data['C2'] = $model->getDocumentosC2(); //'Internos'

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('htdocs/modalPdf');
        echo view('personal/expediente', $data);
        echo view('htdocs/footer', $data);
    } //end expediente


    //Diego-> organigrama
    public function organigrama()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Organigrama';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Organigrama', "link" => base_url('Personal/organigrama'), "class" => "active"),
        );

        $data['scripts'][] = base_url('assets/plugins/html2pdf/html2pdf.bundle.min.js');
        $data['scripts'][] = base_url('assets/js/personal/organigrama.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('personal/organigrama');
        echo view('htdocs/footer');
    } //end organigrama

    //Diego->subir recibo de nomina
    public function recibosNomina()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Recibos de nómina';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "");
        $data['breadcrumb'][] = array("titulo" => 'Recibos de nómina ', "link" => base_url('Personal/recibosNomina'), "class" => "active");

        load_plugins(['jstree', 'sweetalert2', 'datepicker'], $data);

        $data['scripts'][] = base_url("assets/js/personal/recibosNomina.js");

        //Vistas
        echo view('htdocs/header', $data);
        echo view('personal/recibosNomina', $data);
        echo view('htdocs/footer', $data);
    } //end recibosNomina

    //Diego-> reporte quinquenio
    public function reporteQuinquenio()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Reporte de quinquenios';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "");
        $data['breadcrumb'][] = array("titulo" => 'Reporte de quinquenios', "link" => base_url('Personal/reporteQuinquenio'), "class" => "active");

        load_plugins(['datatables_buttons'], $data);

        //Styles
        //Scripts
        $data['scripts'][] = base_url('assets/js/personal/reportequinquenios.js');

        //Vistas
        echo view('htdocs/header', $data);
        echo view('personal/reportequinquenios', $data);
        echo view('htdocs/footer', $data);
    } //end reporteQuinquenio

    //Diego -> Formulario agregar baja empleado
    /*public function formBajaEmpleado($empleadoID = null)
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $empleadoID = (int)encryptDecrypt('decrypt', post('txtEmpleadoID'));
            $empleadoRegistra = (int) session('id');
            $baja = array(
                'baj_EmpleadoID' => $empleadoID,
                'baj_FechaRegistro' => date('Y-m-d'),
                'baj_FechaBaja' => date('Y-m-d'),
                'baj_MotivoBaja' => trim(post('txtMotivoBaja')),
                'baj_Correo' => trim(post('txtCorreo')),
                'baj_ContrasenaCorreo' => trim(post('txtContrasenaCorreo')),
                'baj_Telefono' => trim(post('txtTelefono')),
                'baj_ContrasenaTelefono' => trim(post('txtContrasenaTelefono')),
                'baj_Computadora' => trim(post('txtComputadora')),
                'baj_ContrasenaComputadora' => trim(post('txtContrasenaComputadora')), //so good
                'baj_UrlSitio1' => trim(post('txtUrlSitio1')),
                'baj_UrlSitio2' => (post('txtUrlSitio2') != null) ? trim(post('txtUrlSitio2')) : '',
                'baj_UrlSitio3' => (post('txtUrlSitio3') != null) ? trim(post('txtUrlSitio3')) : '',
                'baj_UserSitio1' => trim(post('txtUserSitio1')),
                'baj_UserSitio2' => (post('txtUserSitio2') != null) ? trim(post('txtUserSitio2')) : '',
                'baj_UserSitio3' => (post('txtUserSitio3') != null) ? trim(post('txtUserSitio3')) : '',
                'baj_ContrasenaSitio1' => trim(post('txtContrasenaSitio1')),
                'baj_ContrasenaSitio2' => (post('txtContrasenaSitio2') != null) ? trim(post('txtContrasenaSitio2')) : '',
                'baj_ContrasenaSitio3' => (post('txtContrasenaSitio3') != null) ? trim(post('txtContrasenaSitio3')) : '',
                'baj_EmpleadoDaBaja' => $empleadoRegistra,
                'baj_Comentarios' => trim(post('txtComentarios'))
            );
            $this->db->transBegin();
            $result = insert('bajaempleado', $baja);

            if ($result) {
                $result = update('empelado', array('emp_Estatus' => 0), array('emp_EmpleadoID' => $empleadoID));
                if ($result) {
                    $this->session->setFlashdata('success', '¡La baja se registró correctamente!');
                } else
                    $this->session->setFlashdata('error', '¡Intente nuevamente!');
            } else {
                $this->session->setFlashdata('error', '¡Intente nuevamente!');
            } //if result

            //TRANSACT
            if ($this->db->transStatus() === FALSE) {
                $this->db->transRollback();
            } else {
                $this->db->transCommit();
            }
            return redirect()->to(base_url("Personal/bajaEmpleados"));
        } else {
            $empleado = $this->PersonalModel->empleadoExiste(encryptDecrypt('decrypt', $empleadoID));


            if ($empleado['contador'] == 0) {
                redirect("Usuario/index");
            }

            $data['title'] = "Añadir baja";
            $data['breadcrumb'] = array(
                array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
                array("titulo" => 'Catálogo de empleados', "link" => base_url('Personal/empleados'), "class" => ""),
                array("titulo" => 'Añadir baja', "link" => base_url('Personal/formBajaEmpleado'), "class" => "active")
            );

            $data['empleado'] = $this->PersonalModel->getEmpleadoByID(encryptDecrypt('decrypt', $empleadoID));

            load_plugins(['datepicker', 'select2'], $data);

            //STYLES
            //SCRIPTS
            $data['scripts'][] = base_url('assets/js/formBajaEmpleado.js');

            //Cargar vistas
            echo view("htdocs/header", $data);
            echo view("personal/formBajaEmpleado", $data);
            echo view("htdocs/footer", $data);
        } //if POST

    }*/ //formBajaEmpleado
    //Diego -> Formulario agregar baja empleado
    public function formBajaEmpleado($empleadoID = null)
    {
        // Validar sesión
        validarSesion(self::LOGIN_TYPE);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $empleadoID = (int) encryptDecrypt('decrypt', post('txtEmpleadoID'));
            $empleadoRegistra = (int) session('id');
            $campos = [
                'MotivoBaja', 'Correo', 'ContrasenaCorreo', 'Telefono', 'ContrasenaTelefono', 'Computadora',
                'ContrasenaComputadora', 'UrlSitio1', 'UrlSitio2', 'UrlSitio3', 'UserSitio1', 'UserSitio2',
                'UserSitio3', 'ContrasenaSitio1', 'ContrasenaSitio2', 'ContrasenaSitio3', 'Comentarios'
            ];

            $baja = [
                'baj_EmpleadoID' => $empleadoID,
                'baj_FechaRegistro' => date('Y-m-d'),
                'baj_FechaBaja' => date('Y-m-d'),
                'baj_EmpleadoDaBajaon' => $empleadoRegistra,
            ];

            foreach ($campos as $campo) {
                $baja["baj_$campo"] = trim(post("txt$campo")) ?? '';
            }
            $this->db->transBegin();
            $result = insert('bajaempleado', $baja);

            if ($result && update('empleado', ['emp_Estatus' => 0], ['emp_EmpleadoID' => $empleadoID])) {
                $this->session->setFlashdata('success', '¡La baja se registró correctamente!');
            } else {
                $this->session->setFlashdata('error', '¡Intente nuevamente!');
            }

            $this->db->transStatus() === FALSE ? $this->db->transRollback() : $this->db->transCommit();
            return redirect()->to(base_url("Personal/bajaEmpleados"));
        }

        $empleado = $this->PersonalModel->empleadoExiste(encryptDecrypt('decrypt', $empleadoID));

        if ($empleado['contador'] == 0) {
            return redirect("Usuario/index");
        }

        $data['title'] = "Añadir baja";
        $data['breadcrumb'] = [
            ["titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""],
            ["titulo" => 'Catálogo de empleados', "link" => base_url('Personal/empleados'), "class" => ""],
            ["titulo" => 'Añadir baja', "link" => base_url('Personal/formBajaEmpleado'), "class" => "active"]
        ];

        $data['empleado'] = $this->BaseModel->getEmpleadoByID(encryptDecrypt('decrypt', $empleadoID));
        load_plugins(['datepicker', 'select2'], $data);
        $data['scripts'][] = base_url('assets/js/formBajaEmpleado.js');

        echo view("htdocs/header", $data);
        echo view("personal/formBajaEmpleado", $data);
        echo view("htdocs/footer", $data);
    }


    //Lia -> Entrevista de salida
    public function entrevistaSalida_old($bajaID)
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $empleadoRegistra = (int) session('id');
            $entrevista = array(
                "ent_BajaID" => (int)encryptDecrypt('decrypt', $bajaID),
                "ent_Fecha" => post("txtFechaEntrevista"),
                "ent_EmpleadoID" => (int)encryptDecrypt('decrypt', post("txtEmpleadoID")),
                "ent_EmpleadoAplicaID" => $empleadoRegistra,
                "ent_Pregunta1" => ($_POST["ent_Pregunta1"] == null) ? '' : json_encode($_POST["ent_Pregunta1"]),
                "ent_Pregunta2" => (post("ent_Pregunta2") == null) ? '' : post("ent_Pregunta2"),
                "ent_Pregunta3_1" => (post("ent_Pregunta3_1") == null) ? '' : post("ent_Pregunta3_1"),
                "ent_Pregunta3_2" => (post("ent_Pregunta3_2") == null) ? '' : post("ent_Pregunta3_2"),
                "ent_ComentariosP3" => post("ent_ComentariosP3"),
                "ent_Pregunta4" => (post("ent_Pregunta4") == null) ? '' : post("ent_Pregunta4"),
                "ent_Pregunta5" => (post("ent_Pregunta5") == null) ? '' : post("ent_Pregunta5"),
                "ent_Pregunta6" => (post("ent_Pregunta6") == null) ? '' : post("ent_Pregunta6"),
                "ent_Pregunta7" => (post("ent_Pregunta7") == null) ? '' : post("ent_Pregunta7"),
                "ent_Pregunta8" => (post("ent_Pregunta8") == null) ? '' : post("ent_Pregunta8"),
                "ent_Pregunta9" => (post("ent_Pregunta9") == null) ? '' : post("ent_Pregunta9"),
                "ent_Pregunta10" => post("ent_Pregunta10"),
            );
            $result = insert('entrevistasalida', $entrevista);

            if ($result) {
                update('empleado', array('emp_Estado' => 'Suspendido'), array('emp_EmpleadoID' => (int)post("txtEmpleadoID")));
                $this->session->setFlashdata('success', '¡La entrevista se guardó correctamente!');
            } else
                $this->session->setFlashdata('error', '¡Intente nuevamente!');

            return redirect()->to(base_url("Personal/bajaEmpleados"));
        } else {
            $data['title'] = "Entrevista de salida";
            $data['breadcrumb'] = array(
                array("titulo" => 'Inicio', "link" => '#', 'class' => ''),
                array("titulo" => 'Solicitudes baja', "link" => base_url('Personal/misSolicitudesBajas'), 'class' => ''),
                array("titulo" => 'Entrevista de salida', "link" => base_url('Personal/entrevistaSalida/' . $bajaID), 'class' => 'active')
            );

            load_plugins(['datepicker', 'select2', 'datatables', 'datables4'], $data);

            //STYLES
            $data['styles'][] = base_url('assets/css/formEntrevistaSalida.css');

            //SCRIPTS
            $data['scripts'][] = base_url('assets/js/formEntrevistaSalida.js');

            $data['datos'] = $this->PersonalModel->getDatosBajaEntrevista($bajaID);
            $data['empresa'] = array("emp_Nombre" => "Caja Popular Sahuayo");

            //GET PUESTOS
            $puestos = $this->BaseModel->getPuestos();
            $htmlPuestos = '<option value="0">Seleccionar puesto</option>';
            if (count($puestos) > 0) {
                foreach ($puestos as $puesto) {
                    $htmlPuestos .= "<option value='" . $puesto['pue_PuestoID'] . "'>" . $puesto['pue_Nombre'] . "</option>";
                }
            }

            $data['puestos'] = $htmlPuestos;

            //GET DEPARTAMENTOS
            $deptos = $this->BaseModel->getDepartamentos();
            $htmlDeptos = '<option value="0">Seleccionar departamento</option>';
            if (count($puestos) > 0) {
                foreach ($deptos as $depto) {
                    $htmlDeptos .= "<option value='" . $depto['dep_DepartamentoID'] . "'>" . $depto['dep_Nombre'] . "</option>";
                }
            }
            $data['deptos'] = $htmlDeptos;
            $data['bajaID'] = $bajaID;

            echo view("htdocs/header", $data);
            echo view("personal/formEntrevistaSalida", $data);
            echo view("htdocs/footer", $data);
        } //if POST
    } //entrevistaSalida

    // Lia -> Entrevista de salida
    public function entrevistaSalida($bajaID)
    {
        validarSesion(self::LOGIN_TYPE);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $empleadoRegistra = (int) session('id');
            $entrevista = [
                "ent_BajaID" => (int) encryptDecrypt('decrypt', $bajaID),
                "ent_Fecha" => post("txtFechaEntrevista"),
                "ent_EmpleadoID" => (int) encryptDecrypt('decrypt', post("txtEmpleadoID")),
                "ent_EmpleadoAplicaID" => $empleadoRegistra,
                "ent_Pregunta1" => $_POST["ent_Pregunta1"] ? json_encode($_POST["ent_Pregunta1"]) : '',
                "ent_Pregunta2" => post("ent_Pregunta2") ?? '',
                "ent_Pregunta3_1" => post("ent_Pregunta3_1") ?? '',
                "ent_Pregunta3_2" => post("ent_Pregunta3_2") ?? '',
                "ent_ComentariosP3" => post("ent_ComentariosP3"),
                "ent_Pregunta4" => post("ent_Pregunta4") ?? '',
                "ent_Pregunta5" => post("ent_Pregunta5") ?? '',
                "ent_Pregunta6" => post("ent_Pregunta6") ?? '',
                "ent_Pregunta7" => post("ent_Pregunta7") ?? '',
                "ent_Pregunta8" => post("ent_Pregunta8") ?? '',
                "ent_Pregunta9" => post("ent_Pregunta9") ?? '',
                "ent_Pregunta10" => post("ent_Pregunta10"),
            ];

            $result = insert('entrevistasalida', $entrevista);
            $this->session->setFlashdata($result ? 'success' : 'error', $result ? '¡La entrevista se guardó correctamente!' : '¡Intente nuevamente!');

            if ($result) {
                update('empleado', ['emp_Estado' => 'Suspendido'], ['emp_EmpleadoID' => (int) post("txtEmpleadoID")]);
            }

            return redirect()->to(base_url("Personal/bajaEmpleados"));
        }

        $data = [
            'title' => "Entrevista de salida",
            'breadcrumb' => [
                ["titulo" => 'Inicio', "link" => '#', 'class' => ''],
                ["titulo" => 'Solicitudes baja', "link" => base_url('Personal/misSolicitudesBajas'), 'class' => ''],
                ["titulo" => 'Entrevista de salida', "link" => base_url("Personal/entrevistaSalida/$bajaID"), 'class' => 'active']
            ],
            'styles' => [base_url('assets/css/formEntrevistaSalida.css')],
            'scripts' => [base_url('assets/js/formEntrevistaSalida.js')],
            'datos' => $this->PersonalModel->getDatosBajaEntrevista($bajaID),
            'puestos' => generateOptions($this->BaseModel->getPuestos(), 'pue_PuestoID', 'pue_Nombre'),
            'deptos' => generateOptions($this->BaseModel->getDepartamentos(), 'dep_DepartamentoID', 'dep_Nombre'),
            'bajaID' => $bajaID
        ];
        load_plugins(['datepicker', 'select2', 'datatables', 'datables4'], $data);

        echo view("htdocs/header", $data);
        echo view("personal/formEntrevistaSalida", $data);
        echo view("htdocs/footer", $data);
    }

    //Lia->checklist de bajas
    public function offboarding($empleadoID)
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $empleadoID = decrypt($empleadoID);

        $data['title'] = 'Offboarding (Checklist salida)';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Bajas', "link" => base_url('Personal/bajaEmpleados'), "class" => "active"),
            array("titulo" => 'Offboarding (Checklist salida)', "link" => base_url('Personal/offboarding/' . $empleadoID), "class" => "active"),
        );

        $data['colaborador'] = $this->BaseModel->getEmpleadoByID($empleadoID);
        $data['colaborador']['emp_EmpleadoID'] = encryptDecrypt('encrypt', $data['colaborador']['emp_EmpleadoID']);
        $data['colaborador']['pue_Nombre'] = consultar_dato('puesto', 'pue_Nombre', "pue_PuestoID = " . $data['colaborador']['emp_PuestoID'])['pue_Nombre'];
        $data['checklist'] = $this->PersonalModel->getChecklist('Egreso');
        $data['empleadoID'] = $empleadoID;
        $data['total'] = consultar_dato('catalogochecklist', "COUNT(cat_CatalogoID) as 'total'", "cat_Tipo='Egreso' AND cat_Requerido=1");
        $data['totalCheck'] = $this->PersonalModel->getTotalCheckSalida('Egreso', encryptDecrypt('decrypt', $empleadoID));

        load_plugins(['sweetalert2'], $data);
        //Styles
        //Scripts

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('personal/offboarding', $data);
        echo view('htdocs/footer', $data);
    } //end offboarding

    /*
      ______ _    _ _   _  _____ _____ ____  _   _ ______  _____
     |  ____| |  | | \ | |/ ____|_   _/ __ \| \ | |  ____|/ ____|
     | |__  | |  | |  \| | |      | || |  | |  \| | |__  | (___
     |  __| | |  | | . ` | |      | || |  | | . ` |  __|  \___ \
     | |    | |__| | |\  | |____ _| || |__| | |\  | |____ ____) |
     |_|     \____/|_| \_|\_____|_____\____/|_| \_|______|_____/
    */

    //Diego-> guardar onboarding
    public function saveOnboarding()
    {
        $post = $this->request->getPost();
        $empleadoID = encryptDecrypt('decrypt', $post['col']);
        unset($post['col']);
        if ($post) {
            $id = json_encode($post['check']);
        } else {
            $id = '';
        }
        $registro = $this->db->query("SELECT * FROM checklistempleado WHERE che_EmpleadoID=" . $empleadoID)->getRowArray();
        $builder = $this->db->table('checklistempleado');
        if ($registro !== NULL) {
            $builder->update(array('che_CatalogoChecklistID' => $id), array('che_ChecklistEmpleadoID' => $registro['che_ChecklistEmpleadoID']));
            $result = $registro['che_ChecklistEmpleadoID'];
            $tipo = 'Actualizar';
        } else {
            $data = array(
                "che_EmpleadoID" => $empleadoID,
                "che_CatalogoChecklistID" => $id
            );
            $builder->insert($data);
            $result = $this->db->insertID();
            $tipo = 'Insertar';
        }
        if ($result) {
            insertLog($this, session('id'), $tipo, 'onboarding', $result);
            $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Onboarding actualizado correctamente!'));
        } else {
            $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error intente mas tarde!'));
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    } //end saveOboarding

    //Diego-> save offboarding
    public function saveOffboarding()
    {
        $post = $this->request->getPost();
        $empleadoID = encryptDecrypt('decrypt', $post['col']);
        unset($post['col']);
        $id = json_encode($post['check']);

        $registro = $this->PersonalModel->existeRegistroChecklist($empleadoID);
        $data = ['che_CatalogoChecklistSalidaID' => $id];
        if ($registro) {
            update('checklistempleado', $data, ['che_ChecklistEmpleadoID' => $registro['che_ChecklistEmpleadoID']]);
            $result = $registro['che_ChecklistEmpleadoID'];
            $tipo = 'Actualizar';
        } else {
            $data['che_EmpleadoID'] = $empleadoID;
            $result = insert('checklistempleado', $data);
            $tipo = 'Insertar';
        }

        $message = $result
            ? ['response' => 'success', 'txttoastr' => '¡Offboarding actualizado correctamente!']
            : ['response' => 'error', 'txttoastr' => '¡Ocurrio un error, intente más tarde!'];

        $this->session->setFlashdata($message);
        insertLog($this, session('id'), $tipo, 'offboarding', $result);

        return redirect()->to($_SERVER['HTTP_REFERER']);
    } //end saveoffboarding


    /*
                   _         __   __
         /\       | |  /\    \ \ / /
        /  \      | | /  \    \ V /
       / /\ \ _   | |/ /\ \    > <
      / ____ \ |__| / ____ \  / . \
     /_/    \_\____/_/    \_\/_/ \_\
    */


    //Lia->llena la tabla de empleados
    public function ajax_getEmpleadosActivos()
    {
        $colaboradores = $this->PersonalModel->getColaboradores();
        $data['data'] = $colaboradores;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_getEmpleadosActivos

    //Lia trae los empleados dados de baja
    public function ajax_getEmpleadosBaja()
    {
        $colaboradores = array_map(function ($colaborador, $i) {
            $colaborador['numero'] = $i + 1;
            $colaborador['baj_FechaBaja'] = longDate($colaborador['baj_FechaBaja'], ' de ');
            return $colaborador;
        }, $this->PersonalModel->getBajas(), array_keys($this->PersonalModel->getBajas()));

        echo json_encode(['data' => $colaboradores], JSON_UNESCAPED_SLASHES);
    }
    //end ajax_getEmpleadosBaja

    //Lia- agrega o edita la info de un colaborador
    function ajax_saveColaborador()
    {
        $post = $this->request->getPost();

        if ($post['emp_EmpleadoID'] !== 0) {
            $empleadoID = (int)encryptDecrypt('decrypt', $post['emp_EmpleadoID']);
        } else {
            $empleadoID = 0;
        }
        unset($post['emp_EmpleadoID']);
        $post['emp_AreaID'] = encryptDecrypt('decrypt', $post['emp_AreaID']);
        $post['emp_DepartamentoID'] = encryptDecrypt('decrypt', $post['emp_DepartamentoID']);
        $post['emp_PuestoID'] = encryptDecrypt('decrypt', $post['emp_PuestoID']);
        $post['emp_HorarioID'] = encryptDecrypt('decrypt', $post['emp_HorarioID']);
        $post['emp_Rol'] = encryptDecrypt('decrypt', $post['emp_Rol']);
        $post['emp_SucursalID'] = encryptDecrypt('decrypt', $post['emp_SucursalID']);
        $numero = $post['emp_Numero'];

        if ($empleadoID > 0) {
            $builder = db()->table('empleado');
            $builder->update($post, array('emp_EmpleadoID' => $empleadoID));

            if ($this->db->affectedRows() > 0) {
                insertLog($this, session('id'), 'Actualizar', 'empleado', $empleadoID);
                $data['code'] = 2;
                $data['msg'] = '¡Los datos del colaborador se actualizaron correctamente!';
            } else {
                $data['code'] = 3;
                $data['msg'] = 'Los datos no cambiaron. Intente nuevamente.';
            }
        } else {
            $sql = "select COUNT(emp_Numero) as contador from empleado where emp_Numero='" . $numero . "'";
            $resultado = $this->db->query($sql)->getRowArray();
            $contador = $resultado['contador'];

            if ($contador == 0) {
                $builder = db()->table('empleado');
                $builder->insert($post);
                if ($this->db->insertID() > 0) {
                    insertLog($this, session('id'), 'Insertar', 'empleado', $this->db->insertID());
                    $data['code'] = 1;
                    $data['msg'] = '¡El colaborador se agrego correctamente!';
                } else {
                    $data['code'] = 0;
                    $data['msg'] = 'Ha ocurrido un error al tratar de guardar. Intente nuevamente.';
                }
            } else {
                $data['code'] = 4;
                $data['msg'] = 'Ese número de empleado ya existe. Por favor escriba uno valido.';
            }
        }

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //End ajax_saveColaborador

    //->Lia obtener informacion del colaborador
    function ajax_getInfoColaborador($colaboradorID)
    {
        $colaborador = $this->PersonalModel->getInfoColaboradorByID($colaboradorID);
        unset($colaborador['emp_EmpleadoID']);
        $colaborador['emp_EmpleadoID'] = $colaboradorID;
        if ($colaborador) {
            $data['response'] = 'success';
            $data['result'] = $colaborador;
        } else {
            $data['msg'] = 'Ocurrio un error. Intentelo nuevamente';
        }
        echo json_encode($data);
    }

    //Diego -> guardar archivo del expediente
    public function ajax_GuardarExpediente($nombreFile, $empleadoID)
    {
        $url = dirname(WRITEPATH) . "/assets/uploads/expediente/" . $empleadoID . "/" . $nombreFile . "/";
        if (!file_exists($url)) {
            mkdir($url, 0777, true);
        }

        $pathInfo = pathInfo($_FILES['file']['name']);
        $extFile = strtolower($pathInfo['extension']);
        $fecha = date('Y-m-d');
        $nombre_archivo = $fecha . "." . $extFile;
        $ruta = $url . $nombre_archivo;
        $dir = base_url('assets/uploads/expediente/' . $empleadoID . '/' . $nombreFile . '/' . $nombre_archivo);
        $base = base_url();
        //Subir doc
        if (move_uploaded_file($_FILES['file']['tmp_name'], $ruta)) {
            echo json_encode(array("response" => "success", "ext" => $extFile, "dir" => $dir, "base" => $base));
        }
    } //end ajax_GuardarExpediente

    //Diego-> ajax consultar empleados organigrama
    public function ajax_regresarEmpleados()
    {

        $sql = "select E.emp_Nombre,E.emp_EmpleadoID, E.emp_Numero,J.emp_Nombre as Jefe,p.pue_Nombre
            from empleado as E
                join empleado as J on E.emp_jefe=J.emp_Numero
                join puesto as p ON E.emp_PuestoID = p.pue_PuestoID
            Where  E.emp_Estatus=1 and J.emp_Estatus=1";
        $result = $this->db->query($sql)->getResultArray();

        $cont = 0;
        foreach ($result as $item) {
            $st = fotoPerfil(encryptDecrypt('encrypt', $item['emp_EmpleadoID']));
            $result[$cont]['fotoperfil'] = $st;
            $cont++;
        }

        $sql2 = "select a.emp_Nombre as nombre,a.emp_EmpleadoID as Ejf, p.pue_Nombre as puesto
        from empleado a
        join puesto p ON a.emp_PuestoID = p.pue_PuestoID
        where a.emp_jefe=0 and a.emp_Estatus=1 ";
        $res = $this->db->query($sql2);
        $resg = $res->getRowArray();

        $st = fotoPerfil(encryptDecrypt('encrypt', $resg['Ejf']));
        $resg['fotoperfil'] = $st;

        if ($result || $res->NumRows() > 0) {
            echo json_encode(array("response" => "success", "result" => $result, "general" => $resg));
        } else {
            echo json_encode(array("response" => "error"));
        }
    } //end ajax_regresarEmpleados

    // Diego->ajax subir recibo nomina
    public function ajaxSubirRecibosNomina()
    {
        $data = ['code' => 0];
        $guardado = $existe = 0;
        $year = post('year');
        $quincena = post('quincena');

        if (!isset($_FILES['fileZip'])) {
            echo json_encode($data, JSON_UNESCAPED_SLASHES);
            return;
        }

        foreach ($_FILES['fileZip']['name'] as $key => $nombre_archivo) {
            $ext = pathinfo($nombre_archivo, PATHINFO_EXTENSION);
            $nEmpleado = (int) explode('_', $nombre_archivo)[5];
            $empleadoID = consultar_dato('empleado', 'empleado', "emp_Numero = $nEmpleado AND emp_Estatus=1") ?? null;

            if (!$empleadoID) continue;

            $empleadoIDEnc = encryptDecrypt('encrypt', $empleadoID);
            $directorio = FCPATH . "/assets/uploads/recibosnomina/$year/$empleadoIDEnc/";

            if (!file_exists($directorio)) mkdir($directorio, 0777, true);

            $ruta = $directorio . "$quincena.zip";
            if (!file_exists($ruta)) {
                move_uploaded_file($_FILES['fileZip']['tmp_name'][$key], $ruta);
                $guardado++;

                $notificacion = [
                    "not_EmpleadoID" => encryptDecrypt('decrypt', $empleadoIDEnc),
                    "not_Titulo" => 'Nuevo recibo de nomina',
                    "not_Descripcion" => 'Se ha subido un nuevo recibo de nomina',
                    "not_EmpleadoIDCreo" => session('id'),
                    "not_FechaRegistro" => date('Y-m-d H:i:s'),
                    "not_URL" => 'Usuario/miPerfil',
                    'not_Icono' => 'zmdi zmdi-money-box',
                    'not_Color' => 'bg-blue',
                ];
                insert('notificacion', $notificacion);
            } else {
                $existe++;
            }
        }

        $data['code'] = $guardado > 0 ? 1 : ($existe > 0 ? 2 : 0);
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }


    //Diego->obtener recibos nomina
    public function ajax_GetRecibosNomina()
    {
        $url = FCPATH . "/assets/uploads/recibosnomina/";
        if (!file_exists($url)) mkdir($url, 0777, true);
        $anios = preg_grep('/^([^.])/', scandir($url));
        $tree = array();
        foreach ($anios as $anio) {
            $empleadosxanio = preg_grep('/^([^.])/', scandir($url . '/' . $anio));
            $children = array();
            foreach ($empleadosxanio as $emp) {
                $empleado = (int)encryptDecrypt('decrypt', $emp);
                $empleado = consultar_dato('empleado', 'emp_Nombre,emp_Numero', "emp_EmpleadoID = $empleado");
                $nombre = $empleado['emp_Nombre'];
                $num = $empleado['emp_Numero'];
                $children2 = array();
                $periodos = preg_grep('/^([^.])/', scandir($url . '/' . $anio . '/' . $emp));
                foreach ($periodos as $periodo) {
                    $urlD = base_url("/assets/uploads/recibosnomina/" . $anio . '/' . $emp . '/' . $periodo);
                    $itemp = array(
                        "id" => $anio . $num . $periodo,
                        "text" => $anio . $num . $periodo,
                        "icon" => "zmdi zmdi-file",
                        "state" => array(
                            "opened" => false,
                            "disabled" => false,
                        ),
                        "a_attr" => array("href" => $urlD),
                        "li_attr" => array("tipo" => "periodo"),
                    );
                    array_push($children2, $itemp);
                }

                $item = array(
                    "id" => $anio . ' ' . $emp,
                    "text" => $anio . ' ' . $nombre,
                    "state" => array(
                        "opened" => false,
                        "disabled" => false,
                    ),
                    "children" => $children2,
                    "li_attr" => array("tipo" => "empleado")
                );
                array_push($children, $item);
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
    } //end ajax_GetRecibosNomina

    //Diego-> obtener reporte quinquenio
    public function ajax_getReporteQuinquenio()
    {
        $empleados = $this->BaseModel->getEmpleados();
        $dataReporte = array();
        foreach ($empleados as $empleado) {
            $fecha = strtotime($empleado['emp_FechaIngreso']);
            $fechaIngreso = date("m-d", $fecha);
            $anio = date("Y", $fecha);
            $antiguedadAnos = date('Y') - $anio;
            $txtAntiguedad = $antiguedadAnos . ' años';

            if ($antiguedadAnos % 5 == 0 && $antiguedadAnos > 0) {
                $empleado['antiguedad'] = $txtAntiguedad;
                $empleado['fechaQuinquenio'] = date("Y") . '-' . $fechaIngreso;
                $empleado['prima'] = primaantiguedad($empleado['emp_FechaIngreso']) . ' dias de salario nóminal.';
                array_push($dataReporte, $empleado);
            }
        }
        $data['data'] = $dataReporte;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_getReporteQuinquenio



    public function ajaxCambiarEstadoEmpleado()
    {
        $empleadoID = (int)encryptDecrypt('decrypt', post("empleadoID"));
        $estado = post("estado");
        $builder = db()->table("empleado");
        $response = $builder->update(array('emp_Estado' => $estado), array("emp_EmpleadoID" => $empleadoID));

        insertLog($this, session('id'), 'Estado', 'empleado', $this->db->insertID());

        $data['code'] = $response ? 1 : 0;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //End ajaxCambiarEstadoEmpleado

    //Diego -> traer municipio por estado
    public function ajax_getCiudadByEstado()
    {
        $post = $this->request->getPost();
        $ciudad_seleccionada = (int)$post['ciudad'];
        $result = $this->db->query("SELECT * FROM ciudad WHERE ciu_idEstado = " . (int)$post['estado'] . " ORDER BY ciu_nombre ASC")->getResultArray();
        $data = array();
        foreach ($result as $r) {
            $r['selected'] = ($r['id_ciudad'] == $ciudad_seleccionada) ? true : false;
            array_push($data, $r);
        }
        if ($data) {
            echo json_encode(array("response" => "success", "result" => $data));
        } else {
            echo json_encode(array("response" => "error", "msg" => 'Ocurrio un error. Intentelo nuevamente'));
        }
    } //End ajax_getCiudadByEstado

    //Fer - modficar fecha de baja de un colaborador
    function ajax_saveFechaBaja()
    {
        $post = $this->request->getPost();
        $empleadoID = (int)encryptDecrypt('decrypt', $post['colaboradorID']);
        unset($post['colaboradorID']);

        $this->db->transStart();
        $builder = db()->table('bajaempleado');
        $builder->update($post, array('baj_EmpleadoID' => $empleadoID));

        if ($this->db->transStatus() === FALSE) {
            $this->db->transRollback();
            $data['code'] = 0;
            $data['msg'] = 'Ha ocurrido un error al tratar de guardar. Intente nuevamente.';
        } else {
            $this->db->transCommit();
            $data['code'] = 1;
            $data['msg'] = 'La fecha se actualizo correctamente!';
        }

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //End ajax_saveFechaBaja





    //Lia->guarda y envia los datos de acceso
    public function ajax_generarDatosAcceso()
    {
        $post = $this->request->getPost();
        $pass = $this->db->query("SELECT emp_Password,emp_Nombre,emp_Username FROM empleado WHERE emp_EmpleadoID=" . encryptDecrypt('decrypt', $post['idColabA']))->getRowArray();

        if ($pass['emp_Password'] === $post['emp_Passworde']) {
            $password = $pass['emp_Password'];
        } else {
            $password = encryptKey($post['emp_Passworde']);
        }

        if (!empty($pass['emp_Username'])) {
            $user = $pass['emp_Username'];
        } else {
            $user = crearUsernameByEmail($post['emp_Correo'], $this);
        }


        $colaboradorData = array(
            'emp_Correo' => $post['emp_Correo'],
            'emp_Password' => $password,
            'emp_Username' => $user,
        );
        $builder = db()->table("empleado");
        $result = $builder->update($colaboradorData, array('emp_EmpleadoID' => encryptDecrypt('decrypt', $post['idColabA'])));
        if ($result) {
            $data = array(
                'password' => $post['emp_Passworde'],
                'username' => $user,
                'nombre' => $pass['emp_Nombre'],
            );
            sendMail($post['emp_Correo'], 'Bienvenido (a) a Thigo ' . getSetting('nombre_empresa', $this), $data, "Colaborador");
            $array = array("response" => "success");
        } else {
            $array = array("response" => "error");
        }

        echo json_encode($array);
    }

    //Lis->Guarda la foto del empleado
    public function ajaxSubirFotoEmpleado($empleadoID)
    {
        $empleadoID = encryptDecrypt('decrypt', $empleadoID);
        $data['code'] = 1;

        //Si selecciono imagen de pérfil actualiza
        $pathInfo = pathInfo($_FILES['fileFotoEmpleado']['name']);
        $x = $_FILES['fileFotoEmpleado']['tmp_name'];

        if ($x != "" && $x != null) { //If seleccionó imagen

            $url = FCPATH . "/assets/uploads/fotosPerfil/";

            if (!file_exists($url)) {
                mkdir($url, 0777, true);
            }
            //Subir nueva foto
            $extFile = $pathInfo['extension'];
            if ($extFile == 'jpg' || $extFile == 'png' || $extFile == 'JPG' || $extFile == 'jpeg') {
                $fileName = $empleadoID . "-Empleado." . strtolower($extFile);

                if (file_exists($url . $empleadoID . "-Empleado.jpg")) unlink($url . $empleadoID . "-Empleado.jpg");
                if (file_exists($url . $empleadoID . "-Empleado.png")) unlink($url . $empleadoID . "-Empleado.png");
                move_uploaded_file($_FILES['fileFotoEmpleado']['tmp_name'], $url . $fileName);
            } //if
        } //if
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    //Lia->obtiene informacion del onboarding del colaborador
    public function ajax_getInfoOnboardingColaboradorByID($colaboradorID)
    {
        $data['colaborador'] = $this->PersonalModel->getColaboradorByID($colaboradorID);
        $data['foto'] = fotoPerfil($colaboradorID);
        $data['total'] = $this->db->query("SELECT COUNT(cat_CatalogoID) as 'total' FROM catalogochecklist WHERE cat_Tipo='Ingreso' AND cat_Requerido=1")->getRowArray()['total'];
        $data['totalCheck'] = $this->PersonalModel->getTotalCheck('Ingreso', encryptDecrypt('decrypt', $colaboradorID));
        $data['response'] = 'success';
        echo json_encode($data,);
    }

    //Lia->obtiene el checklist de ingreso
    public function ajax_getChecklist($colaboradorID)
    {
        $checklist = $this->PersonalModel->getChecklist('Ingreso');
        $emp_EmpleadoID = encryptDecrypt('decrypt', $colaboradorID);
        $response = [];
        foreach ($checklist as $ck) {
            $catalogoID = '["' . $ck['cat_CatalogoID'] . '"]';

            $sql = "
                SELECT COUNT(che_ChecklistEmpleadoID) as 'existe'
                FROM checklistempleado
                WHERE JSON_CONTAINS(che_CatalogoChecklistID, ?)
                AND che_EmpleadoID = ?
            ";

            $query = db()->query($sql, [$catalogoID, $emp_EmpleadoID]);
            $check = $query->getRowArray();


            $checked = ($check['existe'] == 1) ? true : false;

            $response[] = [
                'id' => $ck['cat_CatalogoID'],
                'nombre' => $ck['cat_Nombre'],
                'requerido' => $ck['cat_Requerido'],
                'checked' => $checked
            ];
        }
        echo json_encode($response);
    } //and ajax_getChecklist

    //Diego-> guardar onboarding
    public function ajax_saveOnboarding()
    {
        $post = $this->request->getPost();
        $empleadoID = encryptDecrypt('decrypt', $post['col']);
        unset($post['col']);
        if ($post) {
            $id = json_encode($post['check']);
        } else {
            $id = '';
        }
        $registro = $this->db->query("SELECT * FROM checklistempleado WHERE che_EmpleadoID=" . $empleadoID)->getRowArray();
        $builder = $this->db->table('checklistempleado');
        if ($registro !== NULL) {
            $builder->update(array('che_CatalogoChecklistID' => $id), array('che_ChecklistEmpleadoID' => $registro['che_ChecklistEmpleadoID']));
            $result = $registro['che_ChecklistEmpleadoID'];
            $tipo = 'Actualizar';
        } else {
            $data = array(
                "che_EmpleadoID" => $empleadoID,
                "che_CatalogoChecklistID" => $id
            );
            $builder->insert($data);
            $result = $this->db->insertID();
            $tipo = 'Insertar';
        }
        if ($result) {
            insertLog($this, session('id'), $tipo, 'onboarding', $result);
            $response['code'] = 1;
        } else {
            $response['code'] = 0;
        }
        echo json_encode($response, JSON_UNESCAPED_SLASHES);
    } //end saveOboarding

    //Lia ->Envia correos para le onboarding 
    public function ajaxEnviarNotiNuevoIngreso()
    {
        $post = $this->request->getPost();
        $idEmpleado = encryptDecrypt('decrypt', $post['empleadoID']);
        $empleado = $this->PersonalModel->getInfoEmpleadoByID($idEmpleado);
        $checklist = $this->PersonalModel->getChecklist('Ingreso');

        // Extraer IDs de responsables únicos
        $responsablesArr = array_unique(array_merge(...array_map(function ($ch) {
            return json_decode($ch['cat_ResponsableID'], true);
        }, $checklist)));

        $enviado = 0;
        foreach ($responsablesArr as $responsable) {
            $empResp = $this->PersonalModel->getInfoEmpleadoByID($responsable);
            $nombreCatCheck = $this->PersonalModel->getChecklistByEmpleado($responsable);

            // Preparar datos de correo
            $data_correo = [
                'nombre' => $empResp['emp_Nombre'],
                'titulo' => '¡Nuevo ingreso de personal!',
                'cuerpo' => 'Mediante el presente se le comunica que el día <b>' . longDate($empleado['emp_FechaIngreso'], ' de ') . '</b>
                            se incorporará a ' . getSetting('nombre_empresa', $this) . ' un nuevo integrante llamad@ <b>' . $empleado['emp_Nombre'] . '</b> 
                            el cual, se une al equipo de <b>' . $empleado['dep_Nombre'] . '</b> con el puesto de <b>' . $empleado['pue_Nombre'] . '</b>.<br>
                            El departamento de Recursos Humanos te pide tu apoyo con los indicadores:<br>  <b>' . $nombreCatCheck . '</b> del checklist de ingreso.',
            ];

            // Enviar correo y agregar notificación
            if (!empty($empResp['emp_Correo'])) {
                sendMail($empResp['emp_Correo'], 'Nuevo Ingreso', $data_correo, 'NuevoIngreso');
            }

            $notificacion = [
                "not_EmpleadoID" => $empResp['emp_EmpleadoID'],
                "not_Titulo" => 'Nuevo ingreso',
                "not_Descripcion" => $empleado['emp_Nombre'] . ' se incorpora al equipo.',
                "not_EmpleadoIDCreo" => (int)session("id"),
                "not_FechaRegistro" => date('Y-m-d H:i:s'),
                "not_URL" => '#',
                "not_Icono" => "zmdi zmdi-folder-person",
                "not_Color" => "bg-purple"
            ];
            insert('notificacion', $notificacion);
            $enviado++;
        }

        echo json_encode(["response" => $enviado > 0 ? 1 : 0]);
    }
    //end ajaxEnviarNotiNuevoIngreso

}
