<?php

namespace App\Controllers;

defined('FCPATH') or exit('No direct script access allowed');

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

		//Data
		if (revisarPermisos('Autorizar', __FUNCTION__)) {
			$data['title'] = 'Requisiciones de personal';
			$data['solicitudes'] = $this->ReclutamientoModel->getListSolicitudesPersonalTodos();
			$data['breadcrumb'] = array(
				array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => "active"),
				array("titulo" => 'Solicitudes de personal', "link" => base_url('Reclutamiento/requisicionPersonal'), "class" => "active"),
			);
		} else {
			$data['solicitudes'] = $this->ReclutamientoModel->getListSolicitudesPersonal();
		}
		$solicitudPersonalID = 'req';
		$data['solicitudPersonalID'] = $solicitudPersonalID;

		load_plugins(['select2', 'sweetalert2', 'datables4', 'modalPdf'], $data);

		//Custom
		$data['scripts'][]  = base_url('assets/js/modalConfirmation.js');
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
		$data['empleado'] = $this->ReclutamientoModel->getEmpleadoInfoRequisicionPersonalID();
		$data['puestos'] = $this->BaseModel->getPuestos();
		$data['departamentos'] = $this->BaseModel->getDepartamentos();
		$data['areas'] = $this->BaseModel->getAreas();

		load_plugins(['moment', 'datepicker', 'select2'], $data);

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

		$data['solicitudes'] = $this->ReclutamientoModel->getListSolicitudesPersonalAutorizada();

		load_plugins(['select2', 'datables4'], $data);

		//Custom
		echo view("htdocs/header", $data);
		echo view("reclutamiento/segRequisicionPersonal");
		echo view("htdocs/footer");
	} //end seguimientoReqPer

	//Diego -> seguimiento de requisicion de personal
	public function infoReqPer($solicitudPersonalID, $tab = 'candidato')
	{
		// Validar sesión
		validarSesion(self::LOGIN_TYPE);

		$data = [
			'title' => 'Seguimiento de requisición',
			'breadcrumb' => [
				["titulo" => 'Inicio', "link" => base_url('Usuario/index')],
				["titulo" => 'Requisiciones de personal', "link" => base_url('Reclutamiento/seguimientoReqPer')],
				["titulo" => 'Seguimiento de requisición', "link" => base_url('Reclutamiento/infoReqPer')]
			],
			'tabcandidato' => '', 'tabentrevista' => '', 'tabpsico' => '', 'tabfinal' => '',
			'solicitud' => $this->ReclutamientoModel->getSolicitudByID($solicitudPersonalID),
			'solicitudPersonalID' => $solicitudPersonalID,
			'candidatos' => $this->ReclutamientoModel->getCandidatosBySolicitudID($solicitudPersonalID),
			'solicitudP' => $this->ReclutamientoModel->getSolicitudPersonalByID(decrypt($solicitudPersonalID)),
			'encryptedID' => $solicitudPersonalID,
		];

		// Establecer la clase activa según el tab seleccionado
		$tabs = ['candidato', 'entrevista', 'psico', 'final'];
		foreach ($tabs as $t) {
			if ($tab === $t) {
				$data['tab' . $t] = 'active';
			}
		}

		load_plugins(['moment', 'select2', 'datables4', 'filestyle', 'sweetalert2', 'modalPdf', 'daterangepicker', 'datetimepicker'], $data);

		// Cargar los scripts
		$data['scripts'][] = base_url('assets/js/reclutamiento/infoReqPer.js');
		$data['scripts'][] = base_url('assets/js/modalRechazoJustificacion.js');

		// Renderizar las vistas
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
		$data['candidatos'] = $this->ReclutamientoModel->getCandidatosCartera();
		$data['solicitudes'] = $this->ReclutamientoModel->getListSolicitudesPersonalActivas();

		load_plugins(['moment', 'select2', 'datatables_buttons', 'modalPdf'], $data);

		//Styles
		//Scripts
		$data['scripts'][] = base_url('assets/js/reclutamiento/carteraCandidato.js');

		//Vistas
		echo view('htdocs/header.php', $data);
		echo view('reclutamiento/carteraCandidatos');
		echo view('htdocs/modalPdf', $data);
		echo view('htdocs/footer.php');
	} //horarios

	/*
      ______ _    _ _   _  _____ _____ ____  _   _ ______  _____
     |  ____| |  | | \ | |/ ____|_   _/ __ \| \ | |  ____|/ ____|
     | |__  | |  | |  \| | |      | || |  | |  \| | |__  | (___
     |  __| | |  | | . ` | |      | || |  | | . ` |  __|  \___ \
     | |    | |__| | |\  | |____ _| || |__| | |\  | |____ ____) |
     |_|     \____/|_| \_|\_____|_____\____/|_| \_|______|_____/
    */

	public function cambiarEstatusReqPersonal($estatus, $id)
	{
		$id = encryptDecrypt('decrypt', $id);
		$post = $this->request->getPost();

		// Datos comunes para la actualización
		$data = [
			"sol_DirGeneralAutorizada" => $estatus,
			"sol_AutorizaRechaza" => session("id")
		];

		if ($estatus === 'AUTORIZADA') {
			$data["sol_DirGeneralFecha"] = date('Y-m-d');
		} else {
			$data["sol_JustificacionRechazada"] = $post['justificacion'];
			$data["sol_Estatus"] = 0;
		}

		// Actualizar la solicitud
		$result = update('solicitudpersonal', $data, ['sol_SolicitudPersonalID' => (int)$id]);

		// Obtener la solicitud actualizada
		$autorizadas = $this->ReclutamientoModel->getSolicitudPersonalByID($id);
		$empleadoID = $autorizadas['sol_EmpleadoID'];
		$fecha = date('Y-m-d');
		$creadorID = session('id');
		$url = 'Reclutamiento/requisicionPersonal';

		// Crear la notificación base
		$baseNotificacion = [
			"not_EmpleadoID" => $empleadoID,
			"not_EmpleadoIDCreo" => $creadorID,
			"not_FechaRegistro" => $fecha,
			"not_URL" => $url,
			'not_Icono' => 'zmdi zmdi-assignment-o',
		];

		// Notificación si está autorizada
		if ($autorizadas['sol_DirGeneralAutorizada'] === 'AUTORIZADA') {
			$notificacion = array_merge($baseNotificacion, [
				"not_Titulo" => "Solicitud de personal autorizada",
				"not_Descripcion" => "Se ha autorizado la solicitud de personal",
				'not_Color' => 'bg-blue',
			]);
			insert('notificacion', $notificacion);

			// Notificar a RH
			$aplican = $this->BaseModel->getRH();
			foreach ($aplican as $aplica) {
				$notificacion['not_EmpleadoID'] = $aplica['emp_EmpleadoID'];
				$notificacion['not_Titulo'] = "Nueva solicitud de personal por revisar";
				$notificacion['not_Descripcion'] = "Se ha autorizado la solicitud de personal";
				insert('notificacion', $notificacion);
			}
		}

		// Notificación si está rechazada
		if ($autorizadas['sol_DirGeneralAutorizada'] === 'RECHAZADA') {
			$notificacion = array_merge($baseNotificacion, [
				"not_Titulo" => "Solicitud de personal rechazada",
				"not_Descripcion" => "Se ha rechazado la solicitud de personal",
				'not_Color' => 'bg-red',
			]);
			insert('notificacion', $notificacion);
		}

		// Flash y redirección
		$this->session->setFlashdata([
			'response' => $result ? 'success' : 'error',
			'txttoastr' => $result ? '¡Se actualizó el estatus correctamente!' : '¡Ocurrió un error, intente más tarde!'
		]);

		return redirect()->to($_SERVER['HTTP_REFERER']);
	}

	//Diego -> guardar requisicion/solicitud de personal
	public function addSolicitudPersonal()
	{
		$post = $this->request->getPost();
		if (!empty($post['puestosCoordina'])) $post['puestosCoordina'] = json_encode($post['puestosCoordina']);

		$departamento = consultar_dato('departamento', 'dep_DepartamentoID', "dep_Nombre = {$post['departamento']}");
		$sucursal = consultar_dato('sucursal', 'suc_SucursalID', "suc_Sucursal = {$post['sucursal']}");

		if ($post['personalCargo'] === "No") $post['puestosCoordina'] = '';

		$data = [
			"sol_SucursalSolicita" => $sucursal['suc_SucursalID'],
			"sol_DepartamentoCreaID" => $departamento['dep_DepartamentoID'],
			"sol_Fecha" => $post['fechaSolicitud'],
			"sol_EmpleadoID" => encryptDecrypt('decrypt', $post['Jefe']),
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
		];

		$result = insert('solicitudpersonal', $data);

		if ($result) {
			$autorizaGerente = consultar_dato('empleado', '*', "emp_PuestoID = 19 AND emp_Estatus = 1");
			$datosCorreo = [
				'titulo' => 'Nueva solicitud de personal',
				'nombre' => $autorizaGerente['emp_Nombre'],
				'cuerpo' => 'Mediante el presente se comunica que ' . $post['nombreJefe'] . ' ha registrado una nueva solicitud de personal, más información en la plataforma Thigo.',
			];

			$url = 'Reclutamiento/requisicionPersonal';
			$notificacion = [
				"not_EmpleadoID" => $autorizaGerente['emp_EmpleadoID'],
				"not_Titulo" => "Nueva solicitud de personal",
				"not_Descripcion" => "Se ha registrado una nueva solicitud de personal",
				"not_EmpleadoIDCreo" => session('id'),
				"not_FechaRegistro" => date('Y-m-d'),
				"not_URL" => $url,
				'not_Icono' => 'zmdi zmdi-assignment-o',
				'not_Color' => 'bg-blue',
			];

			insert('notificacion', $notificacion);
			sendMail($autorizaGerente['emp_Correo'], "Nueva solicitud de personal", $datosCorreo, "NuevaSolicitudPersonal");

			$this->session->setFlashdata(['response' => 'success', 'txttoastr' => '¡La solicitud se registró correctamente!']);
			return redirect()->to(base_url("reclutamiento/requisicionPersonal"));
		} else {
			$this->session->setFlashdata(['response' => 'error', 'txttoastr' => '¡Intente nuevamente!']);
			return redirect()->to($_SERVER['HTTP_REFERER']);
		}
	}

	// Diego -> agregar candidato
	public function addCandidato()
	{
		$post = $this->request->getPost();
		$solicitudPersonalID = encryptDecrypt('decrypt', $post['modalAdd_SolPer']);
		$data = [
			"can_Fecha" => date('Y-m-d'),
			"can_Nombre" => $post['modalAdd_Nombre'],
			"can_Telefono" => $post['modalAdd_Celular'],
			"can_Correo" => $post['modalAdd_Correo'],
			"can_SolicitudPersonalID" => $solicitudPersonalID,
		];

		$candidatoId = insert('candidato', $data);
		$directorio = FCPATH . "/assets/uploads/solicitudPersonal/{$solicitudPersonalID}/candidato/{$candidatoId}/";
		if (!file_exists($directorio)) mkdir($directorio, 0777, true);

		$guardado = 0;
		if (isset($_FILES['fileCV'])) {
			$extension = pathinfo($_FILES['fileCV']['name'], PATHINFO_EXTENSION);
			$nombre_archivo = 'CurriculumVitae.' . $extension;
			$ruta = $directorio . $nombre_archivo;
			if (move_uploaded_file($_FILES['fileCV']['tmp_name'], $ruta)) {
				$guardado = 1;
			}
		}

		$response = $guardado > 0
			? ['response' => 'success', 'txttoastr' => '¡Se ha guardado el candidato correctamente!']
			: ['response' => 'error', 'txttoastr' => '¡Ocurrió un error, intente más tarde!'];

		$this->session->setFlashdata($response);
		return redirect()->to(base_url("Reclutamiento/infoReqPer/{$post['modalAdd_SolPer']}/candidato"));
	}

	// Diego -> guardar comentarios
	public function saveObservaciones($solicitudPersonalID)
	{
		$post = $this->request->getPost();
		$candidatoId = encryptDecrypt('decrypt', $post['candidatoID']);
		$result = update('candidato', ['can_Observacion' => $post['can_Observacion']], ['can_CandidatoID' => (int)$candidatoId]);

		// Set flash message
		$this->session->setFlashdata([
			'response' => $result ? 'success' : 'error',
			'txttoastr' => $result ? 'Observacion guardada' : '¡Ocurrio un error, intente más tarde!'
		]);

		// Determine the status and redirect location
		$idEstatus = consultar_dato('candidato', 'can_Estatus', "can_CandidatoID=$candidatoId")['can_Estatus'];
		$ubicacion = match ($idEstatus) {
			'REVISION' => 'candidato',
			'AUT_ENTREVISTA' => 'entrevista',
			'AUT_PSICOMETRIA' => 'psico',
			'AUT_FINAL', 'CARTERA', 'SELECCIONADO' => 'final',
			default => '',
		};

		$redirect = ($solicitudPersonalID === 'req') ? $_SERVER['HTTP_REFERER'] : base_url("Reclutamiento/infoReqPer/{$solicitudPersonalID}/{$ubicacion}");
		return redirect()->to($redirect);
	}

	//Diego->Agregar candidato a nueva solicitud
	public function updateCandidato()
	{
		$post = $this->request->getPost();
		$candidatoId = encryptDecrypt('decrypt', $post['candidatoID']);
		$solicitudPersonalID = (int)$post['sol_SolicitudPersonalID'];

		// Verificar si el candidato ya está en la solicitud
		$comprobacion = $this->db->query("SELECT can_HitorialRechazo FROM candidato WHERE can_CandidatoID = ? AND can_SolicitudPersonalID = ?", array($candidatoId, $solicitudPersonalID))->getRowArray();
		if ($comprobacion) {
			return $this->session->setFlashdata(['response' => 'warning', 'txttoastr' => 'El candidato ya se encuentra registrado en la solicitud!']);
		}

		// Obtener información del candidato
		$candidatoInfo = $this->db->query("SELECT * FROM candidato WHERE can_CandidatoID = ?", array($candidatoId))->getRowArray();

		// Preparar datos para la actualización
		$data = [
			'can_SolicitudPersonalID' => $solicitudPersonalID,
			'can_Rechazo' => null,
			'can_Estatus' => 'REVISION',
			'can_HitorialRechazo' => '0',
		];

		// Definir rutas de archivo
		$rutaAntigua = FCPATH . "/assets/uploads/solicitudPersonal/{$candidatoInfo['can_SolicitudPersonalID']}/candidato/{$candidatoId}/";
		$rutaNueva = FCPATH . "/assets/uploads/solicitudPersonal/{$solicitudPersonalID}/candidato/{$candidatoId}/";

		// Iniciar transacción
		$this->db->transStart();
		$updateResult = update('candidato', $data, ['can_CandidatoID' => $candidatoId]);

		// Verificar si la actualización fue exitosa
		if ($this->db->transStatus() === false || !$updateResult) {
			$this->db->transRollback();
			return $this->session->setFlashdata(['response' => 'error', 'txttoastr' => '¡Ocurrio un error, intente más tarde!']);
		}

		// Commit de la transacción
		$this->db->transCommit();

		// Mover archivos de la solicitud anterior a la nueva
		$flashMessage = rename($rutaAntigua, $rutaNueva)
			? ['response' => 'success', 'txttoastr' => '¡Candidato agregado correctamente!']
			: ['response' => 'error', 'txttoastr' => '¡Ocurrio un error, intente más tarde!'];

		$this->session->setFlashdata($flashMessage);
		return redirect()->to($_SERVER['HTTP_REFERER']);
	} //end addDepartamento


	/*
                   _         __   __
         /\       | |  /\    \ \ / /
        /  \      | | /  \    \ V /
       / /\ \ _   | |/ /\ \    > <
      / ____ \ |__| / ____ \  / . \
     /_/    \_\____/_/    \_\/_/ \_\
    */

	public function ajax_CambiarEstatusCandidato()
	{
		$post = $this->request->getPost();
		if ($post['estatus'] === 'SEL_SOLICITANTE') {
			$solicitudPersonalID = decrypt($post['candidatoID']);
			$solicitudP = $this->ReclutamientoModel->getSolicitudPersonalByID($solicitudPersonalID);
			$notificacion = array(
				"not_EmpleadoID" => $solicitudP['sol_EmpleadoID'],
				"not_Titulo" => "Selecciona candidatos Finalistas",
				"not_Descripcion" => "Se han seleccionado candidatos para tu solicitud de personal",
				"not_EmpleadoIDCreo" => session('id'),
				"not_FechaRegistro" => date('Y-m-d'),
				"not_URL" => "Reclutamiento/requisicionPersonal",
				'not_Color' => 'bg-amber',
				'not_Icono' => 'zmdi zmdi-accounts-list',
			);
			insert('notificacion', $notificacion);
			$mensaje = 'Se ha notificado al solicitante';

			$candidatos = consultar_datos('candidato', 'can_CandidatoID', "can_Estatus='AUT_FINAL' AND can_SolicitudPersonalID = $solicitudPersonalID");
			foreach ($candidatos as $candidato) {
				$data = array(
					"can_Estatus" => $post['estatus'],
				);
				$response = update('candidato', $data, array("can_CandidatoID" => $candidato['can_CandidatoID']));
			}
			$id = $post['candidatoID'];
			$redirect = '';
		} else {
			$data = array(
				"can_Estatus" => $post['estatus'],
				"can_Rechazo" => $post['Observacion'] ?? null,
			);
			$response = update('candidato', $data, array("can_CandidatoID" => (int)decrypt($post['candidatoID'])));
			$candidato = $this->db->query("SELECT can_SolicitudPersonalID FROM candidato 
			JOIN solicitudpersonal ON can_SolicitudPersonalID=sol_SolicitudPersonalID 
			WHERE can_CandidatoID=" . (int)decrypt($post['candidatoID']))->getRowArray();
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
					$redirect = "candidato";
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
			$id = encrypt($candidato['can_SolicitudPersonalID']);
		}
		if ($response) echo json_encode(array("code" => 1, "mensaje" => $mensaje, "url" => base_url("Reclutamiento/infoReqPer/" . $id . "/" . $redirect)));
		else echo json_encode(array("code" => 0));
	}

	public function ajax_getRegistroObservaciones()
	{
		$post = $this->request->getPost();
		$idCandidato = encryptDecrypt('decrypt', $post['candidatoID']);
		$info = consultar_dato('candidato', 'can_CandidatoID,can_Observacion', "can_CandidatoID=$idCandidato");
		echo json_encode(array("response" => "success", "info" => $info));
	}

	public function ajax_CarteraCandidato()
	{
		$post = $this->request->getPost();
		$post["historial"] = ($post["estatus"] != "NO_SELECCIONADO") ? '1' : '0';
		$post["estatus"] = "CARTERA";
		$response = update('candidato', array("can_Estatus" => $post['estatus'], "can_HitorialRechazo" => $post['historial']), array("can_CandidatoID" => (int)decrypt($post['candidatoID'])));
		$id =  consultar_dato('candidato', 'can_SolicitudPersonalID', 'can_CandidatoID=' . decrypt($post['candidatoID']))['can_SolicitudPersonalID'];
		if ($response) echo json_encode(array("code" => 1, "mensaje" => 'Se ha guardado el candidato en cartera', "url" => base_url("Reclutamiento/infoReqPer/" . encrypt($id) . "/final")));
		else echo json_encode(array("code" => 0));
	}

	public function ajax_getCandidatosSolicitud($idSolicitud)
	{
		$idSolicitud = decrypt($idSolicitud);
		$candidatos = consultar_datos('candidato', '*', "can_SolicitudPersonalID = $idSolicitud AND can_Estatus='SEL_SOLICITANTE'");
		$check = "";

		$count = 1;
		foreach ($candidatos as &$candidato) {

			/*$check = '<div class="checkbox checkbox-primary checkbox-single">
								  <input type="checkbox"
										 value="' . $candidato['can_CandidatoID'] . '"
										   id="candidatos' . $count . '" >
								 <label></label>
						 </div>';*/
			$check = '<div class="checkbox">
						 <input id="candidatos' . ($count + 1) . '" class="chk-candidato" type="checkbox" value="' . $candidato['can_CandidatoID'] . '" />
						 <label for="candidatos' . ($count + 1) . '"></label>
					 </div>';

			$urlcv = CVCandidato($candidato['can_SolicitudPersonalID'], $candidato['can_CandidatoID'])[0];
			$info = '<div class="text-center" style="width: 50%; margin: 0 auto;"> 
					<button href="' . $urlcv . '" class="btn btn-warning show-pdf btn-icon btn-icon-mini btn-round hidden-sm-down" data-title="CV de ' . strtoupper($candidato['can_Nombre']) . '" style="color:#FFFFFF;" title="Ver CV"><i class="zmdi zmdi-local-printshop"></i></button>
					<button class="btn btn-info observacionesBtn btn-icon btn-icon-mini btn-round hidden-sm-down" data-id="' . encryptDecrypt('encrypt', $candidato['can_CandidatoID']) . '" style="color:#FFFFFF;" title="Ver Observaciones"><i class=" zmdi zmdi-comment-alt-text"></i></button>
				</div>';

			$candidato['acciones'] = $info;
			$candidato['can_Nombre'] = $candidato['can_Nombre'];
			$candidato['check'] = $check;
			$count++;
		}

		$data['data'] = $candidatos;
		echo json_encode($data, JSON_UNESCAPED_SLASHES);
	}

	public function ajaxSeleccionarCandidatos()
	{
		$post = $this->request->getPost();
		$candidatos = $post['candidatos'];
		$solicitudID = decrypt($post['solicitudID']);
		$this->db->transStart();
		foreach ($candidatos as $checkbox) {
			if ($checkbox !== null) {
				$success = update('candidato', array('can_Estatus' => 'SELECCIONADO'), array('can_CandidatoID' => (int)$checkbox));
			}
		}
		if ($success) {
			$candidatosNoSel = $this->db->query("SELECT * FROM candidato WHERE can_Estatus='SEL_SOLICITANTE' AND can_SolicitudPersonalID=" . $solicitudID)->getResultArray();
			foreach ($candidatosNoSel as $no) {
				update('candidato', array('can_Estatus' => 'NO_SELECCIONADO'), array('can_CandidatoID' => $no['can_CandidatoID'], 'can_SolicitudPersonalID' => $solicitudID));
			}
			$gerenteCH = $this->db->query("SELECT emp_EmpleadoID,emp_Nombre,pue_Nombre 
			FROM puesto 
			JOIN empleado 
			WHERE emp_PuestoID=pue_PuestoID AND pue_Nombre='Jefe de Recursos Humanos'")->getRowArray();
			$notificacion = array(
				"not_EmpleadoID" => $gerenteCH['emp_EmpleadoID'],
				"not_Titulo" => 'El solicitante ha elegido candidatos',
				"not_Descripcion" => 'El solicitante ha seleccionado candidatos para continuar en el proceso',
				"not_EmpleadoIDCreo" => session('id'),
				"not_FechaRegistro" => date('Y-m-d H:i:s'),
				"not_URL" => 'Reclutamiento/infoReqPer/' . $post["solicitudID"]  . '/final',
				'not_Icono' => 'bg-amber',
				'not_Color' => 'zmdi zmdi-accounts-list'
			);
			insert('notificacion', $notificacion);
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


	public function ajax_SeleccionandoCandidato()
	{
		$post = $this->request->getPost();
		$response = false;
		$candidatoID = decrypt($post['candidatoID']);
		$candidato = $this->db->query("SELECT * 
		FROM candidato 
		JOIN solicitudpersonal ON can_SolicitudPersonalID=sol_SolicitudPersonalID 
		WHERE can_CandidatoID=" . (int)encryptDecrypt('decrypt', $post['candidatoID']))->getRowArray();

		$response = update('candidato', array("can_Estatus" => $post['estatus']), array("can_CandidatoID" => $candidatoID));
		//Seleccion de candidato por Solicitante
		if ($post["estatus"] === "SELECCIONADO") {
			//notifica rh
			if ($response) {
				$rh = $this->BaseModel->getRH();
				foreach ($rh as $rh) {
					$notificacion = array(
						"not_EmpleadoID" => $rh['emp_EmpleadoID'],
						"not_Titulo" => "Candidato seleccionado",
						"not_Descripcion" => "Se ha elegido a el candidato a contratar",
						"not_EmpleadoIDCreo" => session('id'),
						"not_FechaRegistro" => date('Y-m-d'),
						"not_URL" => 'Reclutamiento/infoReqPer/' . encrypt($candidato['can_SolicitudPersonalID'])  . '/final'
					);
					insert('notificacion', $notificacion);
				}
			}
		}

		//Seleccion de candidato por RH (Final)
		if ($post["estatus"] === "SELECCIONADO_RH") {
			if ($response) {
				if ($candidato['sol_DepartamentoVacanteID'] > 0) {
					$departamentoID = $candidato['sol_DepartamentoVacanteID'];
				} else {
					$dataDep = array(
						"dep_Nombre" => $candidato['sol_NuevoDepartamento'],
						"dep_EmpleadoID" => session('id')
					);
					$departamentoID = insert('departamento', $dataDep);
				}
				if ($candidato['sol_AreaVacanteID'] > 0) {
					$areaID = $candidato['sol_AreaVacanteID'];
				} else {
					$dataArea = array(
						"are_Nombre" => $candidato['sol_NuevaArea']
					);
					$areaID = insert('area', $dataArea);
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
				$response = insert('empleado', $data);
			}

			//Envio de correo a candidatos rechazados
			/*$candidatos = $this->db->query("SELECT * FROM candidato JOIN solicitudpersonal ON can_SolicitudPersonalID=sol_SolicitudPersonalID LEFT JOIN puesto ON pue_PuestoID=sol_PuestoID WHERE can_Estatus!='SELECCIONADO_RH' AND can_SolicitudPersonalID=" . (int)$candidato['can_SolicitudPersonalID'] . " AND can_CandidatoID!=" . (int)encryptDecrypt('decrypt', $post['candidatoID']))->getResultArray();
			foreach ($candidatos as $c) {
				if ($c['sol_PuestoID'] <= 0) $c['puesto'] = $c['sol_Puesto'];
				else $c['puesto'] = $c['pue_Nombre'];

				if (filter_var($c['can_Correo'], FILTER_VALIDATE_EMAIL)) {
					sendMail($c['can_Correo'], 'Gracias por tu participación', $c, 'CanidatoRechazado');
				} else {
					error_log('No fue posible enviar correo de candidato rechazado a ' . $c["can_Nombre"] . ' debido a correo invalido');
				}

				$builder = db()->table('candidato');
				if ($c['can_Estatus'] == 'SELECCIONADO') $builder->update(array("can_Estatus" => 'NO_SELECCIONADO'), array("can_CandidatoID" => (int)$c['can_CandidatoID']));
			}*/
		}
		if ($response) echo json_encode(array("code" => 1, "mensaje" => 'Se ha seleccionado el candidato'));
		else echo json_encode(array("code" => 0));
	}

	public function ajax_CerrarSolicitud()
	{
		$post = $this->request->getPost();
		$response = update('solicitudpersonal',array("sol_Estatus" => 0), array("sol_SolicitudPersonalID" => (int)encryptDecrypt('decrypt', $post['solicitudID'])));
		$solicitudP = $this->db->query("SELECT * FROM solicitudpersonal WHERE sol_SolicitudPersonalID=" . (int)encryptDecrypt('decrypt', $post['solicitudID']))->getRowArray();
		if ($response) {
			$data = array(
				"not_EmpleadoID" => $solicitudP['sol_EmpleadoID'],
				"not_Titulo" => 'Se ha contratado el candidato seleccionado',
				"not_Descripcion" => 'Se ha contratado el candidato y se ha cerrado la solicitud',
				"not_EmpleadoIDCreo" => session('id'),
				"not_FechaRegistro" => date('Y-m-d'),
				"not_URL" => 'Reclutamiento/requisicionPersonal',
				'not_Icono' => 'zmdi zmdi-assignment-o',
				'not_Color' => 'bg-green'
			);
			insert('notificacion',$data);
			echo json_encode(array("code" => 1, "mensaje" => 'Se ha cerrado la solicitud', "url" => base_url("Reclutamiento/infoReqPer/" . $post['solicitudID'] . "/final")));
		} else echo json_encode(array("code" => 0));
	}
}
