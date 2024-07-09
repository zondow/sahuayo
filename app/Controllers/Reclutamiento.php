<?php

namespace App\Controllers;

defined('FCPATH') or exit('No direct script access allowed');

use App\Models\ReclutamientoModel;
use PHP_CodeSniffer\Standards\PSR2\Sniffs\ControlStructures\ElseIfDeclarationSniff;

class Reclutamiento extends BaseController
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
  //Diego -> Envia a la vista para agregar una nueva solicitud de personal
  public function requisicionPersonal()
  {
    //Validar sessión
    validarSesion(self::LOGIN_TYPE);
    $data['title'] = 'Mi requisición de personal';
    $data['breadcrumb'] = array(
      array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "active"),
      array("titulo" => 'Mis solicitudes de personal', "link" => base_url('Reclutamiento/requisicionPersonal'), "class" => "active"),
    );

    $model = new ReclutamientoModel();
    //Data
    if (revisarPermisos('Autorizar', $this)) {
      $data['title'] = 'Requisiciones de personal';
      $data['solicitudes'] = $model->getListSolicitudesPersonalTodos();
      $data['breadcrumb'] = array(
      array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "active"),
      array("titulo" => 'Solicitudes de personal', "link" => base_url('Reclutamiento/requisicionPersonal'), "class" => "active"),
      );
    } else {
      $data['solicitudes'] = $model->getListSolicitudesPersonal();
    }
    $solicitudPersonalID = 'req';
    $data['solicitudPersonalID'] = $solicitudPersonalID;

    //Select 2
    $data['styles'][] = base_url('assets/libs/bootstrap-select/bootstrap-select.min.css');
    $data['styles'][] = base_url('assets/libs/select2/css/select2.min.css');
    $data['scripts'][] = base_url('assets/libs/bootstrap-select/bootstrap-select.min.js');
    $data['scripts'][] = base_url('assets/libs/select2/js/select2.full.min.js');

    //Sweetalert
    $data['styles'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.css");
    $data['scripts'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.min.js");

    //Data Tables
    $data['scripts'][] = base_url("assets/libs/datatables/jquery.dataTables.min.js");
    $data['scripts'][] = base_url("assets/libs/datatables/dataTables.bootstrap4.min.js");
    $data['styles'][] = base_url("assets/libs/datatables/dataTables.bootstrap4.css");

    //Custombox
    $data['styles'][] = base_url('assets/libs/custombox/custombox.min.css');
    $data['scripts'][] = base_url('assets/libs/custombox/custombox.min.js');

    //sumernote
    $data['styles'][] = base_url('assets/libs/summernote/summernote-bs4.css');
    $data['scripts'][] = base_url('assets/libs/summernote/summernote-bs4.min.js');
    $data['scripts'][] = base_url('assets/libs/summernote/lang/summernote-es-ES.js');

    //Custom
    $data['scripts'][]  = base_url('assets/js/modalConfirmation.js');
    $data['scripts'][] = base_url('assets/js/modalPdf.js');
    $data['scripts'][]  = base_url('assets/js/modalRechazoJustificacion.js');
    $data['scripts'][] = base_url("assets/js/reclutamiento/requisicionPersonal.js");

    echo view("htdocs/header", $data);
    echo view("reclutamiento/requisicionPersonal");
    echo view('htdocs/modalConfirmation');
    echo view("htdocs/modalRechazoJustificacion");
    echo view('htdocs/modalPdf');
    echo view("htdocs/footer");
  } //end requisicionPersonal

  //Diego -> Envia a la vista para agregar una nueva solicitud de personal
  public function nuevaSolicitudPersonal()
  {
    //Validar sessión
    validarSesion(self::LOGIN_TYPE);
    $data['title'] = 'Nueva solicitud de personal';
    $data['breadcrumb'] = array(
      array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "active"),
      array("titulo" => 'Mi requisición de personal', "link" => base_url('Reclutamiento/requisicionPersonal'), "class" => "active"),
      array("titulo" => 'Nueva solicitud de personal', "link" => base_url('Reclutamiento/nuevaSolicitudPersonal'), "class" => "active"),
    );

    //Data
    $model = new ReclutamientoModel();
    $data['empleado'] = $model->getEmpleadoInfoID();
    $data['puestos'] = $model->getPuestos();
    $data['departamentos'] = $model->getDepartamentos();
    $data['areas'] = $model->getAreas();

    //datetimepicker
    $data['styles'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css');
    $data['scripts'][] = base_url('assets/plugins/momentjs/moment-with-locales.js');
    $data['scripts'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js');

    //Select 2
    $data['styles'][] = base_url('assets/libs/bootstrap-select/bootstrap-select.min.css');
    $data['styles'][] = base_url('assets/libs/select2/css/select2.min.css');
    $data['scripts'][] = base_url('assets/libs/bootstrap-select/bootstrap-select.min.js');
    $data['scripts'][] = base_url('assets/libs/select2/js/select2.full.min.js');

    //Custom
    $data['scripts'][]  = base_url('assets/js/modalConfirmation.js');
    $data['scripts'][]  = base_url('assets/js/modalRechazoJustificacion.js');
    $data['scripts'][] = base_url('assets/js/modalPdf.js');
    $data['scripts'][] = base_url("assets/js/reclutamiento/solicitudPersonal.js");

    echo view("htdocs/header", $data);
    echo view("reclutamiento/formSolicitudPersonal");
    echo view("htdocs/modalConfirmation");
    echo view("htdocs/modalRechazoJustificacion");
    echo view("htdocs/footer");
  } //end nuevaSolicitudPersonal

  //Diego -> seguimiento de requisicion de personal
  public function seguimientoReqPer($sucursalID = null)
  {
    //Validar sessión
    validarSesion(self::LOGIN_TYPE);
    $data['title'] = 'Requisiciones de personal';
    $data['breadcrumb'] = array(
      array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "active"),
      array("titulo" => 'Requisiciones de personal', "link" => base_url('Reclutamiento/seguimientoReqPer'), "class" => "active"),
    );

    $model = new ReclutamientoModel();
    $data['solicitudes'] = $model->getListSolicitudesPersonalAutorizada();

    //Select2
    $data['styles'][]  = base_url('assets/libs/bootstrap-select/bootstrap-select.min.css');
    $data['styles'][]  = base_url('assets/libs/select2/css/select2.min.css');
    $data['scripts'][] = base_url('assets/libs/bootstrap-select/bootstrap-select.min.js');
    $data['scripts'][] = base_url('assets/libs/select2/js/select2.full.min.js');

    //Data Tables
    $data['scripts'][] = base_url("assets/libs/datatables/jquery.dataTables.min.js");
    $data['scripts'][] = base_url("assets/libs/datatables/dataTables.bootstrap4.min.js");
    $data['styles'][]  = base_url("assets/libs/datatables/dataTables.bootstrap4.css");

    //Custombox
    $data['styles'][] = base_url('assets/libs/custombox/custombox.min.css');
    $data['scripts'][] = base_url('assets/libs/custombox/custombox.min.js');

    //Custom
    echo view("htdocs/header", $data);
    echo view("reclutamiento/segRequisicionPersonal");
    echo view("htdocs/footer");
  } //end seguimientoReqPer

  //Diego -> seguimiento de requisicion de personal
  public function infoReqPer($solicitudPersonalID, $tab = null)
  {
    //Validar sessión
    validarSesion(self::LOGIN_TYPE);
    $data['title'] = 'Seguimiento de requisición';
    $data['breadcrumb'] = array(
      array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "active"),
      array("titulo" => 'Requisiciones de personal', "link" => base_url('Reclutamiento/seguimientoReqPer'), "class" => "active"),
      array("titulo" => 'Seguimiento de requisición', "link" => base_url('Reclutamiento/infoReqPer'), "class" => "active"),
    );

    $data['tabcandidato'] = '';
    $data['tabentrevista'] = '';
    $data['tabpsico'] = '';
    $data['tabfinal'] = '';
    switch ($tab) {
      case 'candidato':
        $data['tabcandidato'] = 'active';
        break;
      case 'entrevista':
        $data['tabentrevista'] = 'active';
        break;
      case 'psico':
        $data['tabpsico'] = 'active';
        break;
      case 'final':
        $data['tabfinal'] = 'active';
        break;
      default:
        $data['tabcandidato'] = 'active';
        break;
    }
    $model = new ReclutamientoModel();
    $data['solicitud'] = $model->getSolicitudByID($solicitudPersonalID);
    $data['solicitudPersonalID'] = $solicitudPersonalID;
    $data['candidatos'] = $model->getCandidatosBySolicitudID($solicitudPersonalID);
    $data['solicitudP'] = $this->db->query("SELECT * FROM solicitudpersonal WHERE sol_SolicitudPersonalID=" . encryptDecrypt('decrypt', $solicitudPersonalID))->getRowArray();
    $data['encryptedID'] = $solicitudPersonalID;

    //Select2
    $data['styles'][] = base_url('assets/libs/bootstrap-select/bootstrap-select.min.css');
    $data['styles'][] = base_url('assets/libs/select2/css/select2.min.css');
    $data['scripts'][] = base_url('assets/libs/bootstrap-select/bootstrap-select.min.js');
    $data['scripts'][] = base_url('assets/libs/select2/js/select2.full.min.js');

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

    //Custombox
    $data['styles'][] = base_url('assets/libs/custombox/custombox.min.css');
    $data['scripts'][] = base_url('assets/libs/custombox/custombox.min.js');

    //fileinpu
    $data['scripts'][] = base_url("assets/js/pages/bootstrap-filestyle.min.js");

    //Sweetalert
    $data['styles'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.css");
    $data['scripts'][] = base_url("assets/plugins/sweetalert2/dist/sweetalert2.min.js");

    //modalpdf
    $data['scripts'][] = base_url('assets/js/modalPdf.js');

    //datetimepicker bootstrapmaterial
    $data['styles'][] = base_url('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css');
    $data['scripts'][] = base_url('assets/plugins/momentjs/moment-with-locales.js');
    $data['scripts'][] = base_url('assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js');

    //datetimepicker
    $data['styles'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css');
    $data['scripts'][] = base_url('assets/plugins/momentjs/moment-with-locales.js');
    $data['scripts'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js');

    //sumernote
    $data['styles'][] = base_url('assets/libs/summernote/summernote-bs4.css');
    $data['scripts'][] = base_url('assets/libs/summernote/summernote-bs4.min.js');
    $data['scripts'][] = base_url('assets/libs/summernote/lang/summernote-es-ES.js');

    //custom
    $data['scripts'][] = base_url('assets/js/reclutamiento/infoReqPer.js');
    $data['scripts'][] = base_url('assets/js/modalRechazoJustificacion.js');

    echo view("htdocs/header", $data);
    echo view("reclutamiento/seguimientoRP");
    echo view("htdocs/modalRechazoJustificacion");
    echo view('htdocs/modalPdf.php', $data);
    echo view("htdocs/footer");
  } //end seguimientoReqPer

  //Diego->ver cartera de candidatos
  public function carteraCandidatos()
  {
    //Validar sessión
    validarSesion(self::LOGIN_TYPE);

    $data['title'] = 'Cartera de candidatos';
    $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'));
    $data['breadcrumb'][] = array("titulo" => 'Cartera de candidatos', "link" => base_url('Reclutamiento/carteraCandidatos'));

    //data
    $model = new ReclutamientoModel();
    $data['candidatos'] = $model->getCandidatosCartera();
    $data['solicitudes'] = $model->getListSolicitudesPersonalActivas();


    //Styles
    $data['styles'][] = base_url('assets/libs/select2/css/select2.min.css');
    $data['styles'][] = base_url('assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css');
    $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
    $data['styles'][] = base_url('assets/plugins/datatables/Buttons-1.6.2/css/buttons.bootstrap4.css');
    $data['styles'][] = base_url('assets/css/tables-custom.css');

    //sumernote
    $data['styles'][] = base_url('assets/libs/summernote/summernote-bs4.css');
    $data['scripts'][] = base_url('assets/libs/summernote/summernote-bs4.min.js');
    $data['scripts'][] = base_url('assets/libs/summernote/lang/summernote-es-ES.js');

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
    $data['scripts'][] = base_url('assets/js/reclutamiento/carteraCandidato.js');

    //modalpdf
    $data['scripts'][] = base_url('assets/js/modalPdf.js');

    //Vistas
    echo view('htdocs/header.php', $data);
    echo view('reclutamiento/carteraCandidatos');
    echo view('htdocs/modalPdf.php', $data);
    echo view('htdocs/footer.php');
  } //horarios

  //Nat -> Encuesta que llenaran los candidatos
  public function prescreening($solicitudPersonalID)
  {
    //Validar sessión
    //validateSession(self::LOGIN_TYPE,TRUE);
    //Titulo
    $data['title'] = 'Candidato a Puesto';

    $data['solicitudPersonalID'] = $solicitudPersonalID;
    $data['solicitudP'] = $this->db->query("SELECT * FROM solicitudpersonal WHERE sol_SolicitudPersonalID=" . encryptDecrypt('decrypt', $solicitudPersonalID))->getRowArray();

    //Styles
    $data['styles'][] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/css/fileinput.css"; //Bootstrap FileInput
    $data['styles'][] = base_url('assets/libs/select2/select2.min.css');
    $data['styles'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css');
    $data['styles'][] = base_url('assets/libs/lightbox/css/lightbox.css');
    $data['styles'][] = base_url('assets/libs/custombox/custombox.min.css');

    //Scripts
    $data['scripts'][] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/fileinput.js"; //Bootstrap FileInput
    $data['scripts'][] = "https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/4.4.8/js/locales/es.js"; //Bootstrap FileInput Spanish
    $data['scripts'][] = base_url('assets/libs/select2/select2.min.js');
    $data['scripts'][] = base_url('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js');
    $data['scripts'][] = base_url("assets/js/pages/bootstrap-filestyle.min.js");
    $data['scripts'][] = base_url('assets/libs/lightbox/js/lightbox.js');
    $data['scripts'][] = base_url('assets/libs/custombox/custombox.min.js');

    //Cargar vistas
    $data['solicitudP']['sol_Estatus'] == 1 ? $ubicacion = "reclutamiento/formPrescreening.php" : $ubicacion = "reclutamiento/solTerminadaPresc.php";
    echo view($ubicacion, $data);
    //echo view("reclutamiento/formPrescreening.php", $data);
  }

  /*
      ______ _    _ _   _  _____ _____ ____  _   _ ______  _____
     |  ____| |  | | \ | |/ ____|_   _/ __ \| \ | |  ____|/ ____|
     | |__  | |  | |  \| | |      | || |  | |  \| | |__  | (___
     |  __| | |  | | . ` | |      | || |  | | . ` |  __|  \___ \
     | |    | |__| | |\  | |____ _| || |__| | |\  | |____ ____) |
     |_|     \____/|_| \_|\_____|_____\____/|_| \_|______|_____/
    */

  //Diego -> guardar requisicion/solicitud de personal
  public function addSolicitudPersonal()
  {
    $post = $this->request->getPost();
    if (!empty($post['puestosCoordina'])) $post['puestosCoordina'] = json_encode($post['puestosCoordina']);

    $departamento = $this->db->query("SELECT * FROM departamento WHERE dep_Nombre='" . $post['departamento'] . "'")->getRowArray();
    $sucursal = $this->db->query("SELECT * FROM sucursal WHERE suc_Sucursal='" . $post['sucursal'] . "'")->getRowArray();
    if ($post['personalCargo'] ===  "No") $post['puestosCoordina'] = '';
    $data = array(
      "sol_SucursalSolicita" => $sucursal['suc_SucursalID'],
      "sol_DepartamentoCreaID" => $departamento['dep_DepartamentoID'],
      "sol_Fecha " => $post['fechaSolicitud'],
      "sol_EmpleadoID " => encryptDecrypt('decrypt', $post['Jefe']),
      "sol_PuestoID" => encryptDecrypt('decrypt', $post['nombrePuesto']),
      "sol_Puesto" => $post['puesto'],
      "sol_SustituyeA" => $post['sustituyeEmpleado'],
      "sol_MotivoSalida" => $post['motivoSalida'],
      "sol_FechaSalida" => $post['fechaSalida'],
      "sol_NuevoPuesto" => $post['nombreNPuesto'],
      "sol_DepartamentoVacanteID" => encryptDecrypt('decrypt', $post['departamentoVac']),
      "sol_NuevoDepartamento" => $post['nombreNDepartamento'],
      "sol_AreaVacanteID" => encryptDecrypt('decrypt', $post['areaVac']),
      "sol_NuevaArea" => $post['nombreNArea'],
      "sol_PersonalCargo" => $post['personalCargo'],
      "sol_PuestosACargo" => $post['puestosCoordina'],
      "sol_Escolaridad" => $post['escolaridad'],
      "sol_EspecificarCarreraTC" => $post['especificar'],
      "sol_EspecificarCarreraProf" => $post['carrera'],
      "sol_Postgrado" => $post['postGrado'],
      "sol_Otro" => $post['otroEspecificar'],
      "sol_Experiencia" => $post['experiencia'],
      "sol_AnosExp" => $post['yearsExp'],
      "sol_AreaExp" => $post['areaExp'],
      "sol_EspPerfilPuesto" => $post['perfilP'],
      "sol_EdadPP" => $post['edad'],
      "sol_SexoPP" => $post['sexo'],
      "sol_EstadoCPP" => $post['ecivil'],
      "sol_Contrato" => $post['contratoTiempo'],
      "sol_TiempoContrato" => $post['tiempoDeterminado'],
      "sol_FechaIngreso" => $post['fIngreso'],
      "sol_SueldoContratacion" => $post['sueldoContratacion'],
      "sol_SueldoPlanta" => $post['sueldoPlanta'],
    );
    $builder = db()->table('solicitudpersonal');
    $result = $builder->insert($data);

    if ($result) {
      $autorizaGerente = $this->db->query("SELECT * FROM empleado GG WHERE GG.emp_PuestoID = 19 AND GG.emp_Estatus = 1")->getRowArray();
      //foreach ($autorizaGerentes as $autorizaGerente) {
        $datosCorreo = array(
          "nombre" => $autorizaGerente['emp_Nombre'],
          "solicitante" => $post['nombreJefe'],
        );
        $url = 'Reclutamiento/requisicionPersonal';
        $notificacion = array(
          "not_EmpleadoID" => $autorizaGerente['emp_EmpleadoID'],
          "not_Titulo" => "Nueva solicitud de personal",
          "not_Descripcion" => "Se ha registrado una nueva solicitud de personal",
          "not_EmpleadoIDCreo" => session('id'),
          "not_FechaRegistro" => date('Y-m-d'),
          "not_URL" => $url,
        );
        $builder2 = db()->table('notificacion');
        $result = $builder2->insert($notificacion);
        sendMail($autorizaGerente['emp_Correo'], "Nueva solicitud de personal", $datosCorreo, "NuevaSolicitudPersonal");
      //}
      $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡La solicitud se registró correctamente!'));
      return redirect()->to(base_url("reclutamiento/requisicionPersonal"));
    } else {
      $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Intente nuevamente!'));
      return redirect()->to($_SERVER['HTTP_REFERER']);
    }
  }

  //Diego-> cambiar esatus de req personal
  public function cambiarEstatusReqPersonal($estatus, $id)
  {
    $id = encryptDecrypt('decrypt', $id);
    if ($estatus == 'AUTORIZADA') {
      $data = array("sol_DirGeneralAutorizada" => $estatus, "sol_DirGeneralFecha" => date('Y-m-d'), "sol_AutorizaRechaza" => session("id"));
    } else {
      $post = $this->request->getPost();
      $data = array("sol_DirGeneralAutorizada" => $estatus, "sol_AutorizaRechaza" => session("id"), "sol_JustificacionRechazada" => $post['justificacion'], "sol_Estatus" => 0);
    }
    $builder = db()->table("solicitudpersonal");
    $result = $builder->update($data, array('sol_SolicitudPersonalID' => (int)$id));

    $autorizadas = $this->db->query("SELECT * FROM solicitudpersonal WHERE sol_SolicitudPersonalID=" . $id)->getRowArray();
    //if ($autorizadas['sol_DirGeneralAutorizada'] === 'AUTORIZADA' || $autorizadas['sol_CHAutorizada'] === 'AUTORIZADA') {
    if ($autorizadas['sol_DirGeneralAutorizada'] === 'AUTORIZADA') {
      //notifica solicitante
      $id = $autorizadas['sol_EmpleadoID'];
      $url = 'Reclutamiento/requisicionPersonal';
      $notificacion = array(
        "not_EmpleadoID" => $id,
        "not_Titulo" => "Solicitud de personal autorizada",
        "not_Descripcion" => "Se ha autorizado la solicitud de personal",
        "not_EmpleadoIDCreo" => session('id'),
        "not_FechaRegistro" => date('Y-m-d'),
        "not_URL" => $url,
      );
      $builder = db()->table('notificacion');
      $builder->insert($notificacion);

      //notifica rh
      $aplican = $this->db->query("SELECT * FROM empleado WHERE emp_Rol=1")->getResultArray();
      foreach ($aplican as $aplica) {
        $id = $aplica['emp_EmpleadoID'];
        $url = 'Reclutamiento/seguimientoReqPer';
        $notificacion = array(
          "not_EmpleadoID" => $id,
          "not_Titulo" => "Nueva solicitud de personal por revisar",
          "not_Descripcion" => "Se ha autorizado la solicitud de personal",
          "not_EmpleadoIDCreo" => session('id'),
          "not_FechaRegistro" => date('Y-m-d'),
          "not_URL" => $url,
        );
        $builder = db()->table('notificacion');
        $builder->insert($notificacion);
      }
    }

    if ($autorizadas['sol_DirGeneralAutorizada'] === 'RECHAZADA') {
      $id = $autorizadas['sol_EmpleadoID'];
      $url = 'Reclutamiento/requisicionPersonal';
      $notificacion = array(
        "not_EmpleadoID" => $id,
        "not_Titulo" => "Solicitud de personal rechazada",
        "not_Descripcion" => "Se ha generado una nueva solicitud de personal",
        "not_EmpleadoIDCreo" => session('id'),
        "not_FechaRegistro" => date('Y-m-d'),
        "not_URL" => $url,
      );
      $builder = db()->table('notificacion');
      $builder->insert($notificacion);
    }
    if ($result) $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Se actualizó el estatus correctamente!'));
    else $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error intente mas tarde!'));
    return redirect()->to($_SERVER['HTTP_REFERER']);
  }

  //Diego -> agrgar candidato
  public function addCandidato()
  {
    $post = $this->request->getPost();
    $data = array(
      "can_Fecha" => date('Y-m-d'),
      "can_Nombre" => $post['modalAdd_Nombre'],
      "can_Telefono" => $post['modalAdd_Celular'],
      "can_Correo" => $post['modalAdd_Correo'],
      "can_SolicitudPersonalID" => encryptDecrypt('decrypt', $post['modalAdd_SolPer']),
    );
    $builder = db()->table('candidato');
    $builder->insert($data);
    $result = $this->db->insertID();
    $guardado = 0;
    //lugar donde se guarda el zip
    $directorio = FCPATH . "/assets/uploads/solicitudPersonal/" . encryptDecrypt('decrypt', $post['modalAdd_SolPer']) . "/candidato/" . $result . "/";

    if (!file_exists($directorio)) mkdir($directorio, 0777, true);

    if (isset($_FILES['fileCV'])) {
      $extension = substr($_FILES['fileCV']['name'], -3);
      $nombre_archivo = 'CurriculumVitae.' . $extension;
      $ruta = $directorio . $nombre_archivo;

      if (move_uploaded_file($_FILES['fileCV']['tmp_name'], $ruta)) $guardado += 1;
    }
    if ($guardado > 0) $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Se ha guardado el candidato correctamente!'));
    else $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error intente mas tarde!'));
    //return redirect()->to($_SERVER['HTTP_REFERER']);
    $redirect = base_url("Reclutamiento/infoReqPer/" . $post['modalAdd_SolPer'] . "/candidatos");
    return redirect()->to($redirect);
  }

  //Fer -> guardar comentarios
  public function saveObservaciones($solicitudPersonalID)
  {
    $post = $this->request->getPost();
    $candidatoId = encryptDecrypt('decrypt', $post['candidatoID']);
    $builder = db()->table('candidato');
    $result = $builder->update(array('can_Observacion' => $post['can_Observacion']), array('can_CandidatoID' => (int)$candidatoId));
    $ubicacion = '';
    if ($result) {
      $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => 'Observacion guardada'));
      //
    } else {
      $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error intente mas tarde!'));
    }
    $idEstatus = $this->db->query("SELECT can_CandidatoID, can_Estatus FROM candidato WHERE can_CandidatoID=" . $candidatoId)->getRowArray();
    switch ($idEstatus['can_Estatus']) {
      case 'REVISION':
        $ubicacion = "revision";
        break;
      case 'AUT_ENTREVISTA':
        $ubicacion = "entrevista";
        break;
      case 'AUT_PSICOMETRIA':
        $ubicacion = "psico";
        break;
      case 'AUT_FINAL'||'CARTERA'||'SELECCIONADO':
        $ubicacion = "final";
        break;
    }
    $redirect = ($solicitudPersonalID === 'req') ? $_SERVER['HTTP_REFERER'] : base_url("Reclutamiento/infoReqPer/" . $solicitudPersonalID . "/" . $ubicacion);
    return redirect()->to($redirect);
  } //end saveObservaciones

  //Diego->guardar prescreenig
  public function addPreScreening()
  {
    $post = $this->request->getPost();
    $post['solicitudPersonalID'] = encryptDecrypt('decrypt', $post['solicitudPersonalID']);
    $data = array(
      "can_Fecha" => $post['fechaActual'],
      "can_Nombre" => $post['nombreCandidato'],
      "can_Correo" => $post['correoElectronico'],
      "can_Telefono" => $post['numeroTelefono'],
      "can_SolicitudPersonalID" => $post['solicitudPersonalID'],

    );
    $builder = $this->db->table('candidato');
    $builder->insert($data);
    $result = $this->db->insertID();
    $archivoGuardado = 0;
    //archvio de incapacidad
    if (isset($_FILES['archivo'])) {
      $directorio = FCPATH . "/assets/uploads/solicitudPersonal/".$post['solicitudPersonalID']."/candidato/".$result."/";

      if (!file_exists($directorio)) mkdir($directorio, 0777, true);

      if (isset($_FILES['archivo'])) {
      $extension = substr($_FILES['archivo']['name'], -3);
      $nombre_archivo = 'CurriculumVitae.' . $extension;
      $ruta = $directorio . $nombre_archivo;

      if (move_uploaded_file($_FILES['archivo']['tmp_name'], $ruta)) $archivoGuardado += 1;
    }
    }
    if ($result > 0 && $archivoGuardado > 0) {
      $rh = $this->db->query("SELECT * from empleado where emp_Rol=1")->getResultArray();
      $puesto = $this->db->query("SELECT * FROM solicitudpersonal JOIN puesto ON pue_PuestoID=sol_PuestoID JOIN sucursal ON suc_SucursalID=sol_SucursalSolicita where sol_SolicitudPersonalID=" . $post['solicitudPersonalID'])->getRowArray();
      foreach ($rh as $r) {
        $notificacion = array(
          "not_EmpleadoID" => $r['emp_EmpleadoID'],
          "not_Titulo" => 'Candidato registrado',
          "not_Descripcion" => 'Se ha registrado un nuevo candidato para el puesto ' . $puesto['pue_Nombre'] . ' de la sucursal ' . $puesto['suc_Sucursal'] . '.',
          "not_EmpleadoIDCreo" => 0,
          "not_FechaRegistro" => date('Y-m-d'),
          "not_URL" => 'Reclutamiento/infoReqPer/' . encryptDecrypt('encrypt', $post['solicitudPersonalID'])  . '/candidatos'
        );
        $builder = db()->table('notificacion');
        $builder->insert($notificacion);
      }

      $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Tu solicitud ha sido registrada correctamente.!'));
    } else {
      $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error al registar tu solicitud, por favor intente de nuevo!'));
    }
    return redirect()->to(base_url("Reclutamiento/finPreScreening"));
  }

  function finPreScreening()
  {
    echo view("reclutamiento/finPrescreening");
  }

  //Fer->Agregar candidato a nueva solicitud
  function updateCandidato()
  {
      $post = $this->request->getPost();
      $candidatoId = encryptDecrypt('decrypt', $post['candidatoID']);

      $comprobacion = $this->db->query("SELECT * FROM candidato WHERE can_CandidatoID = ? AND can_SolicitudPersonalID = ?",array($candidatoId,(int)$post['sol_SolicitudPersonalID']))->getResultArray()['can_HitorialRechazo'] ?? null;
      if($comprobacion){
        $return = $this->session->setFlashdata(array('response' => 'warning', 'txttoastr' => 'El candidato ya se encuentra registrado en la solicitud!'));
      }else{
      $candidatoInfo = $this->db->query("SELECT * FROM candidato WHERE can_CandidatoID = ?",array($candidatoId))->getRowArray();

        $data = array(
            'can_SolicitudPersonalID' =>  $post['sol_SolicitudPersonalID'],
            'can_Rechazo' =>  null,
            'can_Estatus' =>  'REVISION',
            'can_HitorialRechazo' => '0',
        );

        $rutaAntigua = FCPATH . "/assets/uploads/solicitudPersonal/" . $candidatoInfo['can_SolicitudPersonalID'] . "/candidato/" . $candidatoId . "/";
        $rutaNueva = FCPATH . "/assets/uploads/solicitudPersonal/" . $post['sol_SolicitudPersonalID'] . "/candidato/" . $candidatoId . "/";
        
        $this->db->transStart();

        $builder = db()->table('candidato');
        $builder->update($data, array('can_CandidatoID' => $candidatoId));
        
        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            $return = $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error intente mas tarde!'));
        } else {
            $this->db->transCommit();
            if (rename($rutaAntigua, $rutaNueva)) {
              $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Candidato agregado correctamente!'));
            } else {
              $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error intente mas tarde!'));
            }
            $return = redirect()->to($_SERVER['HTTP_REFERER']);
        }
      }
      return $return;
  } //end addDepartamento

  /*
                   _         __   __
         /\       | |  /\    \ \ / /
        /  \      | | /  \    \ V /
       / /\ \ _   | |/ /\ \    > <
      / ____ \ |__| / ____ \  / . \
     /_/    \_\____/_/    \_\/_/ \_\
    */

  public function ajax_getCandidatosSolicitud($idSolicitud)
  {
    $idSolicitud = encryptDecrypt('decrypt', $idSolicitud);
    //$sql = "SELECT C.* FROM candidato C WHERE C.can_SolicitudPersonalID =? AND can_Estatus='AUT_GERENTE'";
    $sql = "SELECT C.* FROM candidato C WHERE C.can_SolicitudPersonalID =? AND can_Estatus='SEL_SOLICITANTE'";
    $candidatos = $this->db->query($sql, array($idSolicitud))->getResultArray();

    $arrCandidatos = array();
    $can = array();
    $check = "";

    $count = 1;
    foreach ($candidatos as $candidato) {

      $check = '<div class="checkbox checkbox-primary checkbox-single">
                                <input type="checkbox"
                                       value="' . $candidato['can_CandidatoID'] . '"
                                         id="candidatos' . $count . '" >
                               <label></label>
                       </div>';

      $urlcv = CVCandidato($candidato['can_SolicitudPersonalID'], $candidato['can_CandidatoID']);
      $info = '<div class="text-center" style="width: 50%; margin: 0 auto;"> 
                <a type="button" href="' . $urlcv[0] . '" class="btn btn-info waves-effect waves-light show-pdf btn-md " data-title="CV de ' . strtoupper($candidato['can_Nombre']) . '" style="color:#FFFFFF;" title="Ver CV"><i class="dripicons-print" style="font-size: 12px"></i></a>
                <a type="button" class="btn btn-dark waves-effect waves-light observacionesBtn btn-md" data-id="' . encryptDecrypt('encrypt', $candidato['can_CandidatoID']) . '" style="color:#FFFFFF;" title="Ver Observaciones"><i class=" dripicons-blog" style="font-size: 12px"></i></a>
              </div>';

      $can['acciones'] = $info;
      $can['can_Nombre'] = $candidato['can_Nombre'];
      $can['check'] = $check;
      $count++;
      array_push($arrCandidatos, $can);
    }

    $data['data'] = $arrCandidatos;
    echo json_encode($data, JSON_UNESCAPED_SLASHES);
  }

  /*public function ajax_getCandidatosFinalistas($idSolicitud)
  {
    var_dump('here');exit();
    $idSolicitud = encryptDecrypt('decrypt', $idSolicitud);
    $sql = "SELECT C.* FROM candidato C WHERE C.can_SolicitudPersonalID =? AND can_Estatus='SEL_SOLICITANTE'";
    $candidatos = $this->db->query($sql, array($idSolicitud))->getResultArray();

    $arrCandidatos = array();
    $can = array();
    $seleccion = "";

    $count = 1;
    foreach ($candidatos as $candidato) {
      $seleccion = '<div class="text-center" style="width: 40%; margin: 0 auto;"><a type="button" data-candidato="' . $candidato['can_Nombre'] . '" data-id="' . encryptDecrypt('encrypt', $candidato['can_CandidatoID']) . '" class="btn btn-success waves-effect waves-light btn-block seleccionadoBtn" style="color:#FFFFFF;" title="Seleccionar"><i class="fas fa-user-check"></i></a></div>';


      $urlcv = CVCandidato($candidato['can_SolicitudPersonalID'], $candidato['can_CandidatoID']);
      $info = '<div class="text-center" style="width: 50%; margin: 0 auto;"> 
                <a type="button" href="' . $urlcv[0] . '" class="btn btn-info waves-effect waves-light show-pdf btn-block mb-1" data-title="CV de ' . strtoupper($candidato['can_Nombre']) . '" style="color:#FFFFFF;" title="Ver CV"><i class="dripicons-print" style="font-size: 12px"></i></a>
                <a type="button" class="btn btn-dark waves-effect waves-light observacionesBtn btn-block" data-id="' . encryptDecrypt('encrypt', $candidato['can_CandidatoID']) . '" style="color:#FFFFFF;" title="Ver Observaciones"><i class=" dripicons-blog" style="font-size: 12px"></i></a>
              </div>';

      $can['acciones'] = $info;
      $can['can_Nombre'] = $candidato['can_Nombre'];
      $can['seleccion'] = $seleccion;
      $count++;
      array_push($arrCandidatos, $can);
    }

    $data['data'] = $arrCandidatos;
    echo json_encode($data, JSON_UNESCAPED_SLASHES);
  }*/

  public function ajaxSeleccionarCandidatos()
  {
    $post = $this->request->getPost();
    $candidatos = $post['candidatos'];

    $solicitudID = encryptDecrypt('decrypt', $post['solicitudID']);

    $this->db->transStart();

    $builder = db()->table('candidato');
    foreach ($candidatos as $checkbox) {
      if($checkbox !== null){
        $success = $builder->update(array('can_Estatus' => 'SELECCIONADO'), array('can_CandidatoID' => (int)$checkbox));
      }
    }
    if($success){
      $candidatosNoSel = $this->db->query("SELECT * FROM candidato WHERE can_Estatus='SEL_SOLICITANTE' AND can_SolicitudPersonalID=" . $solicitudID)->getResultArray();
      foreach ($candidatosNoSel as $no) {
        $builder->update(array('can_Estatus' => 'NO_SELECCIONADO'), array('can_CandidatoID' => $no['can_CandidatoID'], 'can_SolicitudPersonalID' => $solicitudID));
      }
      $gerenteCH = $this->db->query("SELECT emp_EmpleadoID,emp_Nombre,pue_Nombre FROM puesto JOIN empleado WHERE emp_PuestoID=pue_PuestoID AND pue_Nombre='Jefe de Recursos Humanos'")->getRowArray();
      $notificacion = array(
        "not_EmpleadoID" => $gerenteCH['emp_EmpleadoID'],
        "not_Titulo" => 'El solicitante ha elegido candidatos',
        "not_Descripcion" => 'El solicitante ha seleccionado candidatos para continuar en el proceso',
        "not_EmpleadoIDCreo" => session('id'),
        "not_FechaRegistro" => date('Y-m-d H:i:s'),
        //"not_URL" => 'Reclutamiento/infoReqPer/' . encryptDecrypt('encrypt', $solicitudID)  . '/entrevista'
        "not_URL" => 'Reclutamiento/infoReqPer/' . $post ["solicitudID"]  . '/final'
        //"not_URL" => 'Reclutamiento/infoReqPer/' . encryptDecrypt('encrypt', $post['solicitudPersonalID'])  . '/candidatos'
      );
      $builder = $this->db->table('notificacion');
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

  public function ajaxInfoPuesto($puestoID)
  {
    //Get info perfil puesto
    $puestoID = encryptDecrypt('decrypt', $puestoID);
    $result = $this->db->query("SELECT * FROM perfilpuesto WHERE per_PuestoID=" . $puestoID)->getRowArray();
    if ($result) $response = array("code" => 1, "result" => $result);
    elseif ($result === null) $response = array("code" => 2);
    else $response = array("code" => 0);
    echo json_encode($response);
  }

  public function ajax_CambiarEstatusCandidato()
  {
    $post = $this->request->getPost();
    /*if ($post['estatus'] === 'AUT_GERENTE') {
      $solicitudP = $this->db->query("SELECT * FROM solicitudpersonal WHERE sol_SolicitudPersonalID=" . encryptDecrypt('decrypt', $post['candidatoID']))->getRowArray();
      $notificacion = array("not_EmpleadoID" => $solicitudP['sol_EmpleadoID'], "not_Titulo" => "Se han seleccionado candidatos", "not_Descripcion" => "Se han seleccionado candidatos para tu solicitud de personal", "not_EmpleadoIDCreo" => session('id'), "not_FechaRegistro" => date('Y-m-d'), "not_URL" => "Reclutamiento/requisicionPersonal");
      $notificacionBuilder = db()->table('notificacion');
      $notificacionBuilder->insert($notificacion);
      $mensaje = 'Se ha notificado al solicitante';
      $candidatos = $this->db->query("SELECT * FROM  candidato WHERE can_Estatus='REVISION' AND can_SolicitudPersonalID=" . encryptDecrypt('decrypt', $post['candidatoID']))->getResultArray();
      foreach ($candidatos as $candidato) {
        $data = array(
          "can_Estatus" => $post['estatus'],
        );
        $builder = db()->table('candidato');
        $response = $builder->update($data, array("can_CandidatoID" => $candidato['can_CandidatoID']));
      }
      $id = $post['candidatoID'];
      $redirect = '';
    } else*/if ($post['estatus'] === 'SEL_SOLICITANTE') {
      $solicitudP = $this->db->query("SELECT * FROM solicitudpersonal WHERE sol_SolicitudPersonalID=" . encryptDecrypt('decrypt', $post['candidatoID']))->getRowArray();
      $notificacion = array("not_EmpleadoID" => $solicitudP['sol_EmpleadoID'], "not_Titulo" => "Selecciona candidatos Finalistas", "not_Descripcion" => "Se han seleccionado candidatos para tu solicitud de personal", "not_EmpleadoIDCreo" => session('id'), "not_FechaRegistro" => date('Y-m-d'), "not_URL" => "Reclutamiento/requisicionPersonal");
      $notificacionBuilder = db()->table('notificacion');
      $notificacionBuilder->insert($notificacion);
      $mensaje = 'Se ha notificado al solicitante';
      $candidatos = $this->db->query("SELECT * FROM  candidato WHERE can_Estatus='AUT_FINAL' AND can_SolicitudPersonalID=" . encryptDecrypt('decrypt', $post['candidatoID']))->getResultArray();
      foreach ($candidatos as $candidato) {
        $data = array(
          "can_Estatus" => $post['estatus'],
        );
        $builder = db()->table('candidato');
        $response = $builder->update($data, array("can_CandidatoID" => $candidato['can_CandidatoID']));
      }
      $id = $post['candidatoID'];
      $redirect = '';
    } else {
      $data = array(
        "can_Estatus" => $post['estatus'],
        "can_Rechazo" => $post['Observacion']
      );
      $builder = db()->table('candidato');
      $response = $builder->update($data, array("can_CandidatoID" => (int)encryptDecrypt('decrypt', $post['candidatoID'])));
      $candidato = $this->db->query("SELECT * FROM candidato JOIN solicitudpersonal ON can_SolicitudPersonalID=sol_SolicitudPersonalID LEFT JOIN puesto ON pue_PuestoID=sol_PuestoID WHERE can_CandidatoID=" . (int)encryptDecrypt('decrypt', $post['candidatoID']))->getRowArray();
      switch ($post['estatus']) {
        case 'RECHAZADO_REVISION':
          $redirect = "candidato";
          $mensaje = 'Se ha rechazado el candidato';
          break;
        case 'RECHAZADO_ENTREVISTA':
          $redirect = "entrevista";
          $mensaje = 'Se ha rechazado el candidato';
          break;
        case 'AUT_ENTREVISTA':
          $redirect = "candidatos";
          $mensaje = 'El candidato ha pasado a Entrevista';
          break;
        case 'AUT_PSICOMETRIA':
          $redirect = "entrevista";
          $mensaje = 'El candidato ha pasado a Psicometria';
          break;
        case 'RECHAZADO_PSICOMETRIA':
          $redirect = "psico";
          $mensaje = 'Se ha rechazado el candidato';
          break;
        case 'AUT_FINAL':
          $redirect = "psico";
          $mensaje = 'El candidato ha pasado a la fase final';
          break;
      }
      $id = encryptDecrypt('encrypt', $candidato['can_SolicitudPersonalID']);
    }
    if ($response) echo json_encode(array("code" => 1, "mensaje" => $mensaje, "url" => base_url("Reclutamiento/infoReqPer/" . $id . "/" . $redirect)));
    else echo json_encode(array("code" => 0));
  }

  public function ajax_SeleccionandoCandidato()
  {
    $post = $this->request->getPost();
    $response = false;
    $candidato = $this->db->query("SELECT * FROM candidato JOIN solicitudpersonal ON can_SolicitudPersonalID=sol_SolicitudPersonalID WHERE can_CandidatoID=" . (int)encryptDecrypt('decrypt', $post['candidatoID']))->getRowArray();

    $builder = db()->table('candidato');
    $response = $builder->update(array("can_Estatus" => $post['estatus']), array("can_CandidatoID" => (int)encryptDecrypt('decrypt', $post['candidatoID'])));

    //Seleccion de candidato por Solicitante
    if ($post ["estatus"]==="SELECCIONADO"){

      //notifica rh
      if($response){
        $rh = $this->db->query("SELECT * FROM empleado WHERE emp_Rol=1")->getResultArray();
        foreach ($rh as $rh) {
          //$id = $rh['emp_EmpleadoID'];
          $url = 'Reclutamiento/seguimientoReqPer';
          $notificacion = array(
            "not_EmpleadoID" => $rh['emp_EmpleadoID'],
            "not_Titulo" => "Candidato seleccionado",
            "not_Descripcion" => "Se ha elegido a el candidato a contratar",
            "not_EmpleadoIDCreo" => session('id'),
            "not_FechaRegistro" => date('Y-m-d'),
            "not_URL" => $url,
            "not_URL" => 'Reclutamiento/infoReqPer/' . encryptDecrypt('encrypt', $candidato['can_SolicitudPersonalID'])  . '/final'
          );
          $builder = db()->table('notificacion');
          $builder->insert($notificacion);
        }
      }
    }

    //Seleccion de candidato por RH (Final)
    if($post ["estatus"]==="SELECCIONADO_RH"){
      if($response){

        if ($candidato['sol_DepartamentoVacanteID'] > 0) {
          $departamentoID = $candidato['sol_DepartamentoVacanteID'];
        } else {
          $builderDep = db()->table('departamento');
          $dataDep = array(
            "dep_Nombre" => $candidato['sol_NuevoDepartamento'],
            "dep_EmpleadoID" => session('id')
          );
          $builderDep->insert($dataDep);
          $departamentoID = $this->db->insertID();
        }
        if ($candidato['sol_AreaVacanteID'] > 0) {
          $areaID = $candidato['sol_AreaVacanteID'];
        } else {
          $builderArea = db()->table('area');
          $dataArea = array(
            "are_Nombre" => $candidato['sol_NuevaArea']
          );
          $builderArea->insert($dataArea);
          $areaID = $this->db->insertID();
        }

        $data = array(
          "emp_Nombre" => $candidato['can_Nombre'],
          "emp_Celular" => $candidato['can_Telefono'],
          "emp_Correo" => $candidato['can_Correo'],
          "emp_DepartamentoID" => $departamentoID,
          "emp_AreaID" => $areaID,
          "emp_FechaIngreso" => $post['fechaIngreso'],
          "emp_PuestoID" => $candidato['sol_PuestoID'],
          "emp_HorarioID" => 1,
          "emp_Rol" => 0
        );
        $builder2 = db()->table("empleado");
      }
      $response = $builder2->insert($data);
      
      //Envio de correo a candidatos rechazados
      $candidatos = $this->db->query("SELECT * FROM candidato JOIN solicitudpersonal ON can_SolicitudPersonalID=sol_SolicitudPersonalID LEFT JOIN puesto ON pue_PuestoID=sol_PuestoID WHERE can_Estatus!='SELECCIONADO_RH' AND can_SolicitudPersonalID=" . (int)$candidato['can_SolicitudPersonalID'] . " AND can_CandidatoID!=" . (int)encryptDecrypt('decrypt', $post['candidatoID']))->getResultArray();
      foreach ($candidatos as $c) {
        if ($c['sol_PuestoID'] <= 0) $c['puesto'] = $c['sol_Puesto'];
        else $c['puesto'] = $c['pue_Nombre'];

        if (filter_var($c['can_Correo'], FILTER_VALIDATE_EMAIL)) {
          sendMail($c['can_Correo'], 'Gracias por tu participación', $c, 'CanidatoRechazado');
        }else{ error_log('No fue posible enviar correo de candidato rechazado a '.$c ["can_Nombre"].' debido a correo invalido');}

        $builder = db()->table('candidato');
        if ($c['can_Estatus'] == 'SELECCIONADO') $builder->update(array("can_Estatus" => 'NO_SELECCIONADO'), array("can_CandidatoID" => (int)$c['can_CandidatoID']));
      }
      
    }
    if ($response) echo json_encode(array("code" => 1, "mensaje" => 'Se ha seleccionado el candidato'));
    else echo json_encode(array("code" => 0));
  }

  public function ajax_CarteraCandidato()
  {
    $post = $this->request->getPost();
    $post["historial"] = ($post["estatus"] != "NO_SELECCIONADO") ? '1' : '0';
    $post["estatus"] = "CARTERA";
    $builder = db()->table('candidato');
    $response = $builder->update(array("can_Estatus" => $post['estatus'], "can_HitorialRechazo" => $post['historial']), array("can_CandidatoID" => (int)encryptDecrypt('decrypt', $post['candidatoID'])));
    $candidato = $this->db->query("SELECT * FROM candidato WHERE can_CandidatoID=" . (int)encryptDecrypt('decrypt', $post['candidatoID']))->getRowArray();
    $id = encryptDecrypt('encrypt', $candidato['can_SolicitudPersonalID']);
    if ($response) echo json_encode(array("code" => 1, "mensaje" => 'Se ha guardado el candidato en cartera', "url" => base_url("Reclutamiento/infoReqPer/" . $id . "/final")));
    else echo json_encode(array("code" => 0));
  }

  public function ajax_CerrarSolicitud()
  {
    $post = $this->request->getPost();
    $builder = db()->table('solicitudpersonal');
    $response = $builder->update(array("sol_Estatus" => 0), array("sol_SolicitudPersonalID" => (int)encryptDecrypt('decrypt', $post['solicitudID'])));
    $solicitudP = $this->db->query("SELECT * FROM solicitudpersonal WHERE sol_SolicitudPersonalID=" . (int)encryptDecrypt('decrypt', $post['solicitudID']))->getRowArray();
    if ($response) {
      $builder2 = db()->table('notificacion');
      $data = array(
        "not_EmpleadoID" => $solicitudP['sol_EmpleadoID'],
        "not_Titulo" => 'Se ha contratado el candidato seleccionado',
        "not_Descripcion" => 'Se ha contratado el candidato y se ha cerrado la solicitud',
        "not_EmpleadoIDCreo" => session('id'),
        "not_FechaRegistro" => date('Y-m-d'),
        "not_URL" => 'Reclutamiento/requisicionPersonal',
      );
      $builder2->insert($data);
      echo json_encode(array("code" => 1, "mensaje" => 'Se ha cerrado la solicitud', "url" => base_url("Reclutamiento/infoReqPer/" . $post['solicitudID'] . "/final")));
    } else echo json_encode(array("code" => 0));
  }

  public function ajax_getCandidatos()
  {
    $model = new ReclutamientoModel();
    $horarios = $model->getCandidatosCartera();
    $data['data'] = $horarios;
    echo json_encode($data, JSON_UNESCAPED_SLASHES);
  }

  public function ajax_getRegistroObservaciones()
  {
    $post = $this->request->getPost();
    $idCandidato = encryptDecrypt('decrypt', $post['candidatoID']);
    $sql = "SELECT can_CandidatoID,can_Observacion FROM candidato WHERE can_CandidatoID=?";
    $info = $this->db->query($sql, array($idCandidato))->getRowArray();
    echo json_encode(array("response" => "success", "info" => $info));
  }
}
