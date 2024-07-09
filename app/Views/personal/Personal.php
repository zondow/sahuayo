<?php

namespace App\Controllers;

defined('FCPATH') or exit('No direct script access allowed');

use App\Models\PersonalModel;

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

    //Diego -> Vista Expediente
    public  function expediente($empleadoID, $usuario = NULL)
    {
        $empleadoID=encryptDecrypt( 'decrypt',$empleadoID);

        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        if (isset($usuario)) {
            $data['title'] = 'Expediente';
            $data['breadcrumb'] = array(
                array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
                array("titulo" => 'Catálogo de empleados', "link" => base_url('Personal/empleados'), "class" => ""),
                array("titulo" => 'Expediente', "link" => base_url('Personal/expediente/' . $empleadoID), "class" => ""),
            );
            $data['borrar']='si';
        } else {
            $data['title'] = 'Expediente';
            $data['breadcrumb'] = array(
                array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
                array("titulo" => 'Mi perfil', "link" => base_url('Usuario/miPerfil'), "class" => ""),
                array("titulo" => 'Expediente', "link" => base_url('Personal/expediente/' . $empleadoID), "class" => ""),
            );
            $data['borrar']='no';
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
        $res = $this->db->query("SELECT emp_Nombre FROM empleado WHERE emp_EmpleadoID=" . $empleadoID)->getRowArray();
        $data['empleado'] = $res['emp_Nombre'];
        $data['usuario'] = $usuario;
        $data['C1'] = $model->getDocumentosC1();
        $data['C2'] = $model->getDocumentosC2();
        $data['C3'] = $model->getDocumentosC3();
        $data['C4'] = $model->getDocumentosC4();
        $data['C5'] = $model->getDocumentosC5();
        $data['C6'] = $model->getDocumentosC6();

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('htdocs/modalPdf.php');
        echo view('personal/expediente', $data);
        echo view('htdocs/footer', $data);
    } //end expediente

    //Lia-> catalogo de colaboradores
    public function empleados()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Empleados';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Catálogo de empleados', "link" => base_url('Personal/empleados'), "class" => "active"),
        );

        $model = new PersonalModel();
        $data['colaboradores'] = $model->getColaboradores();
        $data['puestos'] = $model->getPuestos();
        $data['departamentos'] = $model->getDepartamentos();
        $data['horarios'] = $model->getHorarios();
        $data['roles'] = $model->getRoles();
        $data['colaboradoresbaja'] = $model->getBajas();
        $data['estados'] = $model->getEstados();
        $data['sucursales'] = $model->getSucursales();

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
        $data['scripts'][] = base_url('assets/js/modalConfirmation.js');
        $data['scripts'][] = base_url('assets/js/modalPdf.js');
        $data['scripts'][] = base_url('assets/js/personal/modalColaborador.js');
        $data['scripts'][] = base_url('assets/js/personal/modalDatosAcceso.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('personal/empleados', $data);
        echo view('personal/modalAgregarColaborador', $data);
        echo view('personal/modalDatosAcceso.php', $data);
        echo view('personal/modalFotoColaborador.php', $data);
        echo view('htdocs/modalPdf.php', $data);
        echo view('htdocs/modalConfirmation', $data);
        echo view('htdocs/footer', $data);
    }

    //Diego -> contratos
    public function contrato($empleadoID)
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $model = new PersonalModel();
        $empleado = $model->getDatosEmpleado($empleadoID);
        unset($empleado['emp_EmpleadoID']);
        $empleado['emp_EmpleadoID'] = $empleadoID;
        $data['empleado'] = $empleado;
        $data['title'] = 'Contratos de ' . $empleado['emp_Nombre'];
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "");
        $data['breadcrumb'][] = array("titulo" => 'Personal', "link" => base_url('Personal/empleados'), "class" => "active");
        $data['breadcrumb'][] = array("titulo" => 'Contratos del colaborador', "link" => base_url('Personal/contrato'), "class" => "active");

        $data['contratos'] = $model->getDatosContratos($empleadoID);
        //$data['empleados'] = $model->getEmpleados();
        //$data['sucursales']=$model->getSucursales();
        //$data['departamentos'] = $model->getDepartamentos();

        //Styles
        $data['styles'][] = base_url('assets/libs/datatables/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/libs/datatables/responsive.bootstrap4.css');
        $data['styles'][] = base_url('assets/libs/bootstrap-select/bootstrap-select.min.css');
        $data['styles'][] = base_url('assets/libs/select2/css/select2.min.css');
        $data['styles'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css');
        $data['styles'][] = base_url('assets/libs/bootstrap-daterangepicker/daterangepicker.css');
        $data['styles'][] = base_url('assets/libs/lightbox/css/lightbox.css');
        $data['styles'][] = base_url('assets/libs/custombox/custombox.min.css');

        //Scripts
        $data['scripts'][] = base_url('assets/libs/datatables/jquery.dataTables.min.js');
        $data['scripts'][] = base_url('assets/libs/datatables/dataTables.bootstrap4.min.js');
        $data['scripts'][] = base_url('assets/libs/datatables/dataTables.responsive.min.js');
        $data['scripts'][] = base_url('assets/libs/select2/js/select2.full.min.js');
        $data['scripts'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js');
        $data['scripts'][] = base_url('assets/libs/bootstrap-daterangepicker/daterangepicker.js');
        $data['scripts'][] = base_url("assets/js/pages/bootstrap-filestyle.min.js");
        $data['scripts'][] = base_url('assets/libs/lightbox/js/lightbox.js');
        $data['scripts'][] = base_url('assets/libs/custombox/custombox.min.js');
        $data['scripts'][] = base_url('assets/js/personal/contratos.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('personal/contratos', $data);
        echo view('htdocs/footer', $data);
    } //contrato

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

        $model = new PersonalModel();
        $data['colaboradores'] = $model->getBajas();
        $data['colaboradoresbaja'] = $model->getBajas();

        //Styles
        $data['styles'][] = base_url('assets/libs/select2/css/select2.min.css');
        $data['styles'][] = base_url('assets/libs/custombox/custombox.min.css');
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');

        //Scripts
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
        $data['scripts'][] = base_url('assets/js/modalPdf.js');
        $data['scripts'][] = base_url('assets/js/personal/empleadosBaja.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('personal/empleadosBaja', $data);
        echo view("htdocs/modalPdf.php", $data);
        echo view('htdocs/footer', $data);
    } //bajaEmpleados

    //Lia -> Entrevista de salida
    public function entrevistaSalida($bajaID)
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

            $builder = db()->table('entrevistasalida');
            $result = $builder->insert($entrevista);

            if ($result) {
                $builder = db()->table('empleado');
                $builder->update(array('emp_Estado' => 'Suspendido'), array('emp_EmpleadoID' => (int)post("txtEmpleadoID")));
                $this->session->setFlashdata('success', '¡La entrevista se guardó correctamente!');
            } else
                $this->session->setFlashdata('error', '¡Intente nuevamente!');

            return redirect()->to(base_url("Personal/bajaEmpleados"));
        } else {
            $data['title'] = "Entrevista de salida";
            $data['breadcrumb'] = array(
                array("titulo" => 'Inicio', "link" => '#'),
                array("titulo" => 'Solicitudes baja', "link" => base_url('Personal/misSolicitudesBajas')),
                array("titulo" => 'Entrevista de salida', "link" => base_url('Personal/entrevistaSalida/' . $bajaID))
            );

            //STYLES
            $data['styles'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css');
            $data['styles'][] = base_url('assets/libs/select2/css/select2.min.css');
            $data['styles'][] = base_url('assets/libs/datatables/dataTables.bootstrap4.css');
            $data['styles'][] = base_url('assets/libs/datatables/responsive.bootstrap4.css');
            $data['styles'][] = base_url('assets/css/formEntrevistaSalida.css');

            //SCRIPTS
            $data['scripts'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js');
            $data['scripts'][] = base_url('assets/libs/select2/js/select2.full.min.js');
            $data['scripts'][] = base_url('assets/libs/datatables/jquery.dataTables.min.js');
            $data['scripts'][] = base_url('assets/libs/datatables/dataTables.bootstrap4.min.js');
            $data['scripts'][] = base_url('assets/libs/datatables/dataTables.responsive.min.js');
            $data['scripts'][] = base_url('assets/js/formEntrevistaSalida.js');

            $model = new PersonalModel();
            $data['datos'] = $model->getDatosBajaEntrevista($bajaID);
            $data['empresa'] = array("emp_Nombre" => "Caja Popular Cerano");

            //GET PUESTOS
            $puestos = $model->getPuestos();
            $htmlPuestos = '<option value="0">Seleccionar puesto</option>';
            if (count($puestos) > 0) {
                foreach ($puestos as $puesto) {
                    $htmlPuestos .= "<option value='" . $puesto['pue_PuestoID'] . "'>" . $puesto['pue_Nombre'] . "</option>";
                }
            }

            $data['puestos'] = $htmlPuestos;

            //GET DEPARTAMENTOS
            $deptos = $model->getDepartamentos();
            $htmlDeptos = '<option value="0">Seleccionar departamento</option>';
            if (count($puestos) > 0) {
                foreach ($deptos as $depto) {
                    $htmlDeptos .= "<option value='" . $depto['dep_DepartamentoID'] . "'>" . $depto['dep_Nombre'] . "</option>";
                }
            }
            $data['deptos'] = $htmlDeptos;
            $data['bajaID'] = $bajaID;

            echo view("htdocs/header.php", $data);
            echo view("personal/formEntrevistaSalida.php", $data);
            echo view("htdocs/footer.php", $data);
        } //if POST
    } //entrevistaSalida

    public function organigrama()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Baja de personal';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Organigrama', "link" => base_url('Personal/organigrama'), "class" => "active"),
        );

        $data['scripts'][] = base_url('assets/libs/spinkit/spinkit.css');
        $data['scripts'][] = base_url('assets/js/personal/organigrama.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('personal/organigrama');
        echo view('htdocs/footer');
    } //INDEX

    //Nat -> Formulario agregar baja empleado
    public function formBajaEmpleado($empleadoID = null)
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
            $builder = db()->table('bajaempleado');
            $result = $builder->insert($baja);

            if ($result) {
                $builder = db()->table('empleado');
                $result = $builder->update(array('emp_Estatus' => 0), array('emp_EmpleadoID' => $empleadoID));
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
            $sql = "SELECT COUNT(*) AS 'contador'
                FROM empleado E
                WHERE E.emp_EmpleadoID=? ";
            $empleado = $this->db->query($sql, array(encryptDecrypt('decrypt', $empleadoID)))->getRowArray();

            if ($empleado['contador'] == 0) {
                redirect("Usuario/index");
            }

            $data['title'] = "Añadir baja";
            $data['breadcrumb'] = array(
                array("titulo" => 'Inicio', "link" => base_url('Usuario/index')),
                array("titulo" => 'Catálogo de empleados', "link" => base_url('Personal/empleados')),
                array("titulo" => 'Añadir baja', "link" => base_url('Personal/formBajaEmpleado'))
            );

            $model = new PersonalModel();
            $data['empleado'] = $model->getColaboradorByID($empleadoID);

            //STYLES
            $data['styles'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css');
            $data['styles'][] = base_url('assets/libs/select2/css/select2.min.css');

            //SCRIPTS
            $data['scripts'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js');
            $data['scripts'][] = base_url('assets/libs/select2/js/select2.full.min.js');
            $data['scripts'][] = base_url('assets/js/formBajaEmpleado.js');

            //Cargar vistas
            echo view("htdocs/header.php", $data);
            echo view("personal/formBajaEmpleado.php", $data);
            echo view("htdocs/footer.php", $data);
        } //if POST

    } //formBajaEmpleado


    public function reporteQuinquenio(){
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Reporte de quinquenios';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "");
        $data['breadcrumb'][] = array("titulo" => 'Reporte de quinquenios', "link" => base_url('Personal/reporteQuinquenio'), "class" => "active");


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

        $data['scripts'][] = base_url('assets/js/personal/reportequinquenios.js');

        //Vistas
        echo view('htdocs/header.php', $data);
        echo view('personal/reportequinquenios', $data);
        echo view('htdocs/footer.php', $data);
    }
    //Lia-> catalogo de colaboradores
    public function onboarding($empleadoID)
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Onboarding (entrada)';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Catálogo de empleados', "link" => base_url('Personal/empleados'), "class" => "active"),
            array("titulo" => 'Onboarding (Checklist entrada)', "link" => base_url('Personal/onboarding/'.$empleadoID), "class" => "active"),
        );

        $model = new PersonalModel();
        $data['colaborador'] = $model->getInfoColaboradorByID($empleadoID);
        $data['colaborador']['emp_EmpleadoID']=encryptDecrypt('encrypt',$data['colaborador']['emp_EmpleadoID']);
        $data['colaborador']['pue_Nombre']=$this->db->query("SELECT pue_Nombre FROM puesto WHERE pue_PuestoID=".encryptDecrypt('decrypt',$data['colaborador']['emp_PuestoID']))->getRowArray()['pue_Nombre'];
        $data['checklist']=$model->getChecklist('Ingreso');
        $data['empleadoID']=$empleadoID;
        $data['total']=$this->db->query("SELECT COUNT(cat_CatalogoID) as 'total' FROM catalogochecklist WHERE cat_Tipo='Ingreso' AND cat_Requerido=1")->getRowArray()['total'];
        $data['totalCheck']=$model->getTotalCheck('Ingreso',encryptDecrypt('decrypt',$empleadoID));

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

    //Lia->checklist de bajas
    public function offboarding($empleadoID)
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Offboarding (Checklist salida)';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Bajas', "link" => base_url('Personal/bajaEmpleados'), "class" => "active"),
            array("titulo" => 'Offboarding (Checklist salida)', "link" => base_url('Personal/offboarding/'.$empleadoID), "class" => "active"),
        );

        $model = new PersonalModel();
        $data['colaborador'] = $model->getInfoColaboradorByID($empleadoID);
        $data['colaborador']['emp_EmpleadoID']=encryptDecrypt('encrypt',$data['colaborador']['emp_EmpleadoID']);
        $data['colaborador']['pue_Nombre']=$this->db->query("SELECT pue_Nombre FROM puesto WHERE pue_PuestoID=".encryptDecrypt('decrypt',$data['colaborador']['emp_PuestoID']))->getRowArray()['pue_Nombre'];
        $data['checklist']=$model->getChecklist('Egreso');
        $data['empleadoID']=$empleadoID;
        $data['total']=$this->db->query("SELECT COUNT(cat_CatalogoID) as 'total' FROM catalogochecklist WHERE cat_Tipo='Egreso' AND cat_Requerido=1")->getRowArray()['total'];
        $data['totalCheck']=$model->getTotalCheckSalida('Egreso',encryptDecrypt('decrypt',$empleadoID));

        //Styles
        $data['styles'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.css');

        //Scripts
        $data['scripts'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('personal/offboarding', $data);
        echo view('htdocs/footer', $data);
    }

    public function recibosNomina(){
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Recibos de nómina';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "");
        $data['breadcrumb'][] = array("titulo" => 'Recibos de nómina ', "link" => base_url('Personal/recibosNomina'), "class" => "active");


        $data['styles'][] = base_url("assets/plugins/jstree/css/style.min.css");
        $data['styles'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.css");
        $data['styles'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css');

        $data['scripts'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js');
        $data['scripts'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.min.js");
        $data['scripts'][] = base_url("assets/plugins/jstree/jstree.min.js");
        $data['scripts'][] = base_url("assets/js/personal/recibosNomina.js");

        //Vistas
        echo view('htdocs/header.php', $data);
        echo view('personal/recibosNomina', $data);
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

    //Diego -> funcion añadir contrato
    public function addContrato()
    {
        $post = $this->request->getPost();
        unset($post['con_FechaInicio']);
        unset($post['con_FechaFin']);
        $post['con_EmpleadoID'] = encryptDecrypt('decrypt', $post['con_EmpleadoID']);
        $post['con_Fecha'] = date('Y-m-d');
        $post['con_EmpleadoCID'] = session('id');

        $builder = db()->table('contrato');
        $builder->insert($post);
        $result = $this->db->insertID();
        if ($result) {
            $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Contrato generado correctamente!'));
        } else {
            $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error al registrar los datos para el contrato!'));
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    } //end addContrato

    //HUGO -> Calcular total de la entrevista de salida
    private function obtenerValorEntrevistaSalida($data)
    {

        $promedioTotal = 0.0;

        //Ambiente laboral
        $ambientelaboral = 0;
        $ambientelaboral += $this->switchValorEntrevista($data['ent_AmbienteLaboral2a']);
        $ambientelaboral += $this->switchValorEntrevista($data['ent_AmbienteLaboral2b']);
        $ambientelaboral += $this->switchValorEntrevista($data['ent_AmbienteLaboral2c']);
        $ambientelaboral += $this->switchValorEntrevista($data['ent_AmbienteLaboral2d']);
        $ambientelaboral += $this->switchValorEntrevista($data['ent_AmbienteLaboral2e']);
        $ambientelaboral += $this->switchValorEntrevista($data['ent_AmbienteLaboral2f']);
        $ambientelaboral += $this->switchValorEntrevista($data['ent_AmbienteLaboral2g']);
        $ambientelaboral += $this->switchValorEntrevista($data['ent_AmbienteLaboral2h']);
        $ambientelaboral += $this->switchValorEntrevista($data['ent_AmbienteLaboral2i']);
        $ambientelaboral += $this->switchValorEntrevista($data['ent_AmbienteLaboral2j']);

        $totalAmbiente = $ambientelaboral / 10;

        //Evaluación del jefe
        $evalJefe = 0;
        $evalJefe += $this->switchValorEntrevista($data['ent_AmbienteLaboral3a']);
        $evalJefe += $this->switchValorEntrevista($data['ent_AmbienteLaboral3b']);
        $evalJefe += $this->switchValorEntrevista($data['ent_AmbienteLaboral3c']);
        $evalJefe += $this->switchValorEntrevista($data['ent_AmbienteLaboral3d']);
        $evalJefe += $this->switchValorEntrevista($data['ent_AmbienteLaboral3e']);
        $evalJefe += $this->switchValorEntrevista($data['ent_AmbienteLaboral3f']);
        $evalJefe += $this->switchValorEntrevista($data['ent_AmbienteLaboral3g']);

        $totalJefe = $evalJefe / 7;

        //Desarrollo
        $desarrollo = 0;
        $desarrollo += $this->switchValorEntrevista($data['ent_Desarrollo1a']);
        $desarrollo += $this->switchValorEntrevista($data['ent_Desarrollo1b']);
        $desarrollo += $this->switchValorEntrevista($data['ent_Desarrollo1c']);
        $desarrollo += $this->switchValorEntrevista($data['ent_Desarrollo1d']);
        $desarrollo += $this->switchValorEntrevista($data['ent_Desarrollo1e']);
        $desarrollo += $this->switchValorEntrevista($data['ent_Desarrollo1f']);

        $totalDesarrollo = $desarrollo / 6;

        //Aspectos generales
        $aspectos = 0;
        $aspectos += $this->switchValorEntrevista($data['ent_Aspectos1a']);
        $aspectos += $this->switchValorEntrevista($data['ent_Aspectos1b']);
        $aspectos += $this->switchValorEntrevista($data['ent_Aspectos1c']);

        $totalAspectos = $aspectos / 3;

        //ServicioCH
        $servicioCH = 0;
        $servicioCH += $this->switchValorEntrevista($data['ent_ServiciosRH1a']);
        $servicioCH += $this->switchValorEntrevista($data['ent_ServiciosRH1b']);
        $servicioCH += $this->switchValorEntrevista($data['ent_ServiciosRH1c']);
        $servicioCH += $this->switchValorEntrevista($data['ent_ServiciosRH1d']);
        $servicioCH += $this->switchValorEntrevista($data['ent_ServiciosRH1e']);

        $totalServiciosCH = $servicioCH / 5;

        $promedioTotal = (float)$totalAmbiente + (float)$totalJefe + (float)$totalDesarrollo + (float)$totalAspectos + (float)$totalServiciosCH;
        $promedioTotal = $promedioTotal / 5;

        return $promedioTotal;
    } //obtenerValorEntrevistaSalida
    //HUGO -> Valor de la opcion seleccionada
    private function switchValorEntrevista($estatus)
    {
        /** LOS  SIGUIENTES:E= 7  MUY BIEN= 6  BIEN=5 REGULAR=4   MAL= 3 MUY MAL=2  PESIMO=1 **/

        $value = 0;
        switch ($estatus) {
            case "Excelente":
                $value = 7;
                break;
            case "Muy bien":
                $value = 6;
                break;
            case "Bien":
                $value = 5;
                break;
            case "Regular":
                $value = 4;
                break;
            case "Mal":
                $value = 3;
                break;
            case "Muy mal":
                $value = 2;
                break;
            case "Pésimo":
                $value = 1;
                break;
        } //switch
        return $value;
    } //switchValorEntrevista

    public function saveOnboarding(){
        $post = $this->request->getPost();
        $empleadoID=encryptDecrypt('decrypt',$post['col']);
        unset($post['col']);
        if($post){
            $id = json_encode($post['check']);
        }else{
            $id = '';
        }        $registro = $this->db->query("SELECT * FROM checklistempleado WHERE che_EmpleadoID=".$empleadoID)->getRowArray();
        $builder = $this->db->table('checklistempleado');
        if($registro!==NULL){
            $builder->update(array('che_CatalogoChecklistID' => $id), array('che_ChecklistEmpleadoID' =>$registro['che_ChecklistEmpleadoID']));
            $result = $registro['che_ChecklistEmpleadoID'];
            $tipo='Actualizar';
        }else{
            $data = array(
                "che_EmpleadoID"=>$empleadoID,
                "che_CatalogoChecklistID"=>$id
            );
            $builder->insert($data);
            $result = $this->db->insertID();
            $tipo='Insertar';
        }
        if ($result) {
            insertLog($this, session('id'), $tipo, 'onboarding', $result);
            $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Onboarding actualizado correctamente!'));
        } else {
            $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error intente mas tarde!'));
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }

    public function saveOffboarding(){
        $post = $this->request->getPost();
        $empleadoID=encryptDecrypt('decrypt',$post['col']);
        unset($post['col']);
        $id = json_encode($post['check']);
        $registro = $this->db->query("SELECT * FROM checklistempleado WHERE che_EmpleadoID=".$empleadoID)->getRowArray();
        $builder = $this->db->table('checklistempleado');
        if($registro!==NULL){
            $builder->update(array('che_CatalogoChecklistSalidaID' => $id), array('che_ChecklistEmpleadoID' =>$registro['che_ChecklistEmpleadoID']));
            $result = $registro['che_ChecklistEmpleadoID'];
            $tipo='Actualizar';
        }else{
            $data = array(
                "che_EmpleadoID"=>$empleadoID,
                "che_CatalogoChecklistSalidaID"=>$id
            );
            $builder->insert($data);
            $result = $this->db->insertID();
            $tipo='Insertar';
        }
        if ($result) {
            insertLog($this, session('id'), $tipo, 'offboarding', $result);
            $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Offboarding actualizado correctamente!'));
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
        $post['emp_DepartamentoID'] = encryptDecrypt('decrypt', $post['emp_DepartamentoID']);
        $post['emp_PuestoID'] = encryptDecrypt('decrypt', $post['emp_PuestoID']);
        $post['emp_HorarioID'] = encryptDecrypt('decrypt', $post['emp_HorarioID']);
        $post['emp_Rol'] = encryptDecrypt('decrypt', $post['emp_Rol']);
        $post['emp_SucursalID'] = encryptDecrypt('decrypt',$post['emp_SucursalID']);
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
    }

    //->Lia obtener informacion del colaborador
    function ajax_getInfoColaborador($colaboradorID)
    {
        $model = new PersonalModel();
        $colaborador = $model->getInfoColaboradorByID($colaboradorID);
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

    //Lia->Calcular salario diario integrado
    public function ajax_calcularSDI()
    {
        $nomina = new \CalculoNomina();
        $data['sdi'] = $nomina->calcularSueldoDiarioIntegrado(post("fechaIngreso"), (float)post("salarioDiario"));
        $data['code'] = 1;

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //ajax_calcularSDI

    //Lia->llena la tabla de empleados
    public function ajax_getEmpleadosActivos()
    {
        $model = new PersonalModel();
        $colaboradores = $model->getColaboradores();
        $data['data'] = $colaboradores;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    public function ajaxCambiarEstadoEmpleado()
    {
        $empleadoID = (int)encryptDecrypt('decrypt', post("empleadoID"));
        $estado = post("estado");

        $builder = db()->table("empleado");
        $response = $builder->update(array('emp_Estado' => $estado), array("emp_EmpleadoID" => $empleadoID));
        insertLog($this, session('id'), 'Estado', 'empleado', $this->db->insertID());

        $data['code'] = $response ? 1 : 0;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
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

    //Lia->guarda y envia los datos de acceso
    public function ajax_generarDatosAcceso()
    {
        $post = $this->request->getPost();
        $pass = $this->db->query("SELECT emp_Password,emp_Nombre,emp_Username FROM empleado WHERE emp_EmpleadoID=" . encryptDecrypt('decrypt',$post['idColabA']))->getRowArray();
        if ($pass['emp_Password'] === $post['emp_Passworde']) $password = $pass['emp_Password'];
        else $password = encryptKey($post['emp_Passworde']);

        if(!empty($pass['emp_Username'])){
            $user=$pass['emp_Username'];
        }else{
            $user = crearUsernameByEmail($post['emp_Correo'], $this);
        }


        $colaboradorData = array(
            'emp_Correo' => $post['emp_Correo'],
            'emp_Password' => $password,
            'emp_Username' => $user,
        );
        $builder = db()->table("empleado");
        $result = $builder->update($colaboradorData, array('emp_EmpleadoID' => encryptDecrypt('decrypt',$post['idColabA'])));
        if ($result) {
            $data = array(
                'password' => $post['emp_Passworde'],
                'username' => $user,
                'nombre' => $pass['emp_Nombre'],
            );
            sendMail($post['emp_Correo'], 'Bienvenido (a) a Thigo ' . getSetting('nombre_empresa', $this), $data, "Colaborador");
            echo json_encode(array("response" => "success"));
        } else {
            echo json_encode(array("response" => "error"));
        }
    }

    //Diego -> traer municipio por estado
    public function ajax_getCiudadByEstado()
    {
        $post = $this->request->getPost();
        $estadoID = $this->db->query("SELECT * FROM estado WHERE est_nombre = '" . $post['estado'] . "'")->getRowArray();
        $result = $this->db->query("SELECT * FROM ciudad WHERE ciu_idEstado = " . (int)$estadoID['id_estado'] . " ORDER BY ciu_nombre ASC")->getResultArray();
        $data = array();
        foreach($result as $r){
            $r['ciu_NombreValue']=strtoupper(eliminar_acentos($r['ciu_nombre']));
            array_push($data,$r);
        }
        if ($data) {
            echo json_encode(array("response" => "success", "result" => $data));
        } else {
            echo json_encode(array("response" => "error", "msg" => 'Ocurrio un error. Intentelo nuevamente'));
        }
    }

    //Lia trae los empleados dados de baja
    public function ajax_getEmpleadosBaja()
    {
        $model = new PersonalModel();
        $colaboradores = $model->getBajas();
        $data['data'] = $colaboradores;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }


    public function ajaxEmpleadosOrganigrama()
    {
        //validateSession(self::LOGIN_TYPE, TRUE);
        $model = new PersonalModel();
        $colaboradores = $model->getColaboradores();
        $arremp = array();
        foreach ($colaboradores as $colaborador) {
            if ($colaborador['pue_Nombre'] === 'Oficial de Partes') $tag = ['assistant'];
            else $tag = '';
            $emp = array(
                'id' => (int)$colaborador['emp_Numero'],
                'pid' => (int)$colaborador['emp_Jefe'],
                'Nombre' => $colaborador['emp_Nombre'],
                'Puesto' => $colaborador['pue_Nombre'],
                'tags' => $tag,
                'img' => "http://federacion.thigo.mx/assets/uploads/fotosPerfil/" . $colaborador['emp_Foto'] . "-Empleado.jpg"
            );
            array_push($arremp, $emp);
        }

        echo json_encode(array('empleados' => $arremp));
    }

    public function ajax_regresarEmpleados(){

        $sql = "select E.emp_Nombre,E.emp_EmpleadoID, E.emp_Numero,J.emp_Nombre as Jefe,p.pue_Nombre
            from empleado as E
                join empleado as J on E.emp_jefe=J.emp_Numero
                join puesto as p ON E.emp_PuestoID = p.pue_PuestoID
            Where  E.emp_Estatus=1 and J.emp_Estatus=1";

        $result=$this->db->query($sql)->getResultArray();

        $cont=0;
        foreach ($result as $item){
            $st=fotoPerfil(encryptDecrypt('encrypt',$item['emp_EmpleadoID']));
            $result[$cont]['fotoperfil']=$st;
            $cont++;
        }


        $sql2="select a.emp_Nombre as nombre,a.emp_EmpleadoID as Ejf, p.pue_Nombre as puesto
        from empleado a
        join puesto p ON a.emp_PuestoID = p.pue_PuestoID
        where a.emp_jefe=0 and a.emp_Estatus=1 ";
        $res=$this->db->query($sql2);
        $resg=$res->getRowArray();

        $st=fotoPerfil(encryptDecrypt('encrypt',$resg['Ejf']));
        $resg['fotoperfil']=$st;


        if($result || $res->NumRows()>0){
            echo json_encode(array("response" => "success", "result" => $result,"general"=>$resg));
        }else{
            echo json_encode(array("response" => "error"));
        }

    }

    public function ajax_getInfoEmpleado($empleadoID){
        $result= $this->db->query("SELECT * FROM empleado
                LEFT JOIN puesto ON pue_PuestoID=emp_PuestoID
                LEFT JOIN departamento ON emp_DepartamentoID=dep_DepartamentoID
                WHERE emp_EmpleadoID = ".(int)$empleadoID)->getRowArray();

        $url = fotoPerfil(encryptDecrypt('encrypt',$result['emp_EmpleadoID']));


        if($result){
            echo json_encode(array("response"=>"success","result"=>$result,"url"=>$url));
        }else{
            echo json_encode(array("response"=>"error","msg"=>'Ocurrio un error. Intentelo nuevamente'));
        }
    }

    public function ajax_getReporteQuinquenio(){
        $model = new PersonalModel();
        $empleados = $model->getEmpleadosQuinquenio();

        $dataReporte=array();
        foreach($empleados as $empleado){

            $fecha=strtotime($empleado['emp_FechaIngreso']);
            $fechaIngreso=date("m-d", $fecha);
            $anio = date("Y", $fecha);

            $antiguedadAnos = date('Y')-$anio;

            $txtAntiguedad= $antiguedadAnos . ' años';

            if($antiguedadAnos == 5 || $antiguedadAnos == 10 || $antiguedadAnos == 15 || $antiguedadAnos == 20 ||
                     $antiguedadAnos == 25 || $antiguedadAnos >= 30){

                $empleado['antiguedad']=$txtAntiguedad;

                $empleado['fechaQuinquenio']=date("Y").'-'.$fechaIngreso;

                $empleado['prima']=primaantiguedad($empleado['emp_FechaIngreso']).' días de salario nóminal.';

                array_push($dataReporte,$empleado);
            }
        }
        $data['data'] = $dataReporte;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    public function ajaxEnviarNotiNuevoIngreso(){
        $post = $this->request->getPost();
        $idEmpleado= encryptDecrypt('decrypt',$post['empleadoID']);

        $data['code'] = 0;

        $this->db->transStart();

        $sql="SELECT emp_Nombre,pue_Nombre,dep_Nombre,emp_FechaIngreso FROM empleado
                JOIN puesto ON pue_PuestoID=emp_PuestoID
                JOIN departamento ON dep_DepartamentoID=emp_DepartamentoID
            WHERE emp_EmpleadoID=?";
        $empleado=$this->db->query($sql,array($idEmpleado))->getRowArray();

        $check=$this->db->query("SELECT * FROM catalogochecklist WHERE cat_Estatus=1")->getResultArray();
        $arrayResponsables=array();
        foreach($check as $ch){
            $responsables=json_decode($ch['cat_ResponsableID']);
            foreach($responsables as $responsable){
                array_push($arrayResponsables,$responsable);
            }
        }

        array_unique($arrayResponsables);

        foreach($arrayResponsables as $responsable){
            $empResp=$this->db->query("SELECT emp_EmpleadoID,emp_Nombre,emp_Correo FROM empleado WHERE emp_Estatus=1 AND emp_Estado='Activo' AND emp_EmpleadoID=".$responsable)->getRowArray();

            $data_correo=array(
                'colaborador'=>$empleado['emp_Nombre'],
                'fechaIngreso'=>$empleado['emp_FechaIngreso'],
                'puesto'=>$empleado['pue_Nombre'],
                'departamento'=>$empleado['dep_Nombre'],
                'responsable'=>$empResp['emp_Nombre'],
            );

            sendMail($empResp['emp_Correo'], 'Nuevo Ingreso', $data_correo, 'NuevoIngreso');

            $notificacion = array(
                "not_EmpleadoID" => $empResp['emp_EmpleadoID'],
                "not_Titulo" => 'Nuevo ingreso',
                "not_Descripcion" => $empleado['emp_Nombre'].' se incorpora al equipo.',
                "not_EmpleadoIDCreo" => (int)session("id"),
                "not_FechaRegistro" => date('Y-m-d H:i:s'),
                "not_URL" => '#',
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

    }

    public function ajaxSubirRecibosNomina(){
        $data['code']=0;
        $guardado = 0;
        $existe=0;
        $year=post('year');
        $quincena=post('quincena');

        if (isset($_FILES['fileZip'])) {
            $total_files = count($_FILES['fileZip']['name']);
            for ($key = 0; $key < $total_files; $key++) {
                $nombre_archivo = $_FILES['fileZip']['name'][$key];
                $ext = pathinfo($nombre_archivo, PATHINFO_EXTENSION);
                $nEmpleado = explode('_',$nombre_archivo);
                $nEmpleado = (int)$nEmpleado[5];

                $sql="SELECT emp_EmpleadoID FROM empleado WHERE emp_NumeroNomina=? AND emp_Estatus=1";
                $empleadoID=$this->db->query($sql,array($nEmpleado))->getRowArray()['emp_EmpleadoID']??null;
                if($empleadoID){
                    $empleadoID=encryptDecrypt('encrypt',$empleadoID);

                    //lugar donde se guarda el zip
                    $directorio = FCPATH . "/assets/uploads/recibosnomina/" .$year. "/".$empleadoID."/";

                    if (!file_exists($directorio)) mkdir($directorio, 0777, true);
                    $files = preg_grep('/^([^.])/', scandir($directorio));

                    if(!in_array($quincena.".zip",$files)){ //Si no existe
                        $ruta = $directorio .$quincena.'.'.$ext;
                        move_uploaded_file($_FILES['fileZip']['tmp_name'][$key], $ruta);
                        $guardado++;
                        $notificacion=array(
                            "not_EmpleadoID"=>encryptDecrypt('decrypt',$empleadoID),
                            "not_Titulo"=>'Nuevo recibo de nomina',
                            "not_Descripcion"=>'Se ha subido un nuevo recibo de nomina',
                            "not_EmpleadoIDCreo"=>session('id'),
                            "not_FechaRegistro"=>date('Y-m-d H:i:s'),
                            "not_URL"=>'Usuario/miPerfil'
                        );
                        $builder = db()->table('notificacion');
                        $builder->insert($notificacion);
                        $correo = $this->db->query("SELECT emp_Correo,emp_Nombre FROM empleado WHERE emp_EmpleadoID=?",array(encryptDecrypt('decrypt',$empleadoID)))->getRowArray();
                        if($correo['emp_Correo']){
                            sendMail($correo['emp_Correo'],'Nuevo Recibo de Nómina',$correo,'reciboNomina');
                        }
                    }else{
                        $existe ++;
                    }
                }
            }
        }
        if ($guardado > 0) $data['code']=1;
        else if($existe > 0) $data['code']=2;

        echo json_encode($data,JSON_UNESCAPED_SLASHES);
    }

    public function ajax_GetRecibosNomina(){
        $url = FCPATH . "/assets/uploads/recibosnomina/";
        if (!file_exists($url)) mkdir($url, 0777, true);
        $anios = preg_grep('/^([^.])/', scandir($url));
        $tree = array();
        foreach($anios as $anio){
            $empleadosxanio = preg_grep('/^([^.])/', scandir($url.'/'.$anio));
            $children = array();
            foreach ($empleadosxanio as $emp) {
                $empleado = db()->query("SELECT emp_Nombre,emp_NumeroNomina as 'emp_Numero' FROM empleado WHERE emp_EmpleadoID=".(int)encryptDecrypt('decrypt',$emp))->getRowArray();
                $nombre = $empleado['emp_Nombre'];
                $num = $empleado['emp_Numero'];
                $children2 = array();
                $periodos = preg_grep('/^([^.])/', scandir($url.'/'.$anio.'/'.$emp));
                foreach($periodos as $periodo){
                    $urlD = base_url("/assets/uploads/recibosnomina/".$anio.'/'.$emp.'/'.$periodo);
                    $itemp = array(
                        "id"=>$anio.$num.$periodo,
                        "text"=> $anio.$num.$periodo,
                        "icon" => "mdi mdi-zip-box ",
                        "state"=>array(
                            "opened"=>false,
                            "disabled"=>false,
                        ),
                        "a_attr"=>array("href"=>$urlD),
                        "li_attr"=>array("tipo"=>"periodo"),
                    );
                    array_push($children2,$itemp);
                }

                $item = array(
                    "id"=>$anio.' '.$emp,
                    "text"=> $anio.' '.$nombre,
                    "state"=>array(
                        "opened"=>false,
                        "disabled"=>false,
                    ),
                    "children"=>$children2,
                    "li_attr"=>array("tipo"=>"empleado")
                );
                array_push($children,$item);
            }

            $node = array(
                "text"=>$anio,
                "state"=>array(
                    "opened"=>true,
                    "disabled"=>false,
                    "selected"=>false,
                ),
                "children"=>$children,
                "li_attr"=>array("tipo"=>"year")
            );
            array_push($tree,$node);
        }
        echo json_encode($tree);
    }
}
