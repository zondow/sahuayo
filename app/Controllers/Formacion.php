<?php

namespace App\Controllers;

defined('FCPATH') or exit('No direct script access allowed');

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

    //Diego-> programa de capacitacion
    public function programaCapacitacion()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);


        $data['title'] = 'Programa de capacitación';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Programa de capacitación', "link" => base_url('Formacion/programaCapacitacion'), "class" => ""),
        );

        $data['capacitaciones'] = $this->FormacionModel->getCapacitaciones();
        $data['proveedores'] = $this->FormacionModel->getProveedores();
        $data['instructores'] = $this->CatalogosModel->getInstructores();
        $data['cursos'] = $this->CatalogosModel->getCursos();

        load_plugins(['moment', 'select2', 'datatables_buttons', 'sweetalert2', 'daterangepicker', 'datetimepicker'], $data);

        //Styles
        //Scripts
        $data['scripts'][] = base_url('assets/js/formacion/programaCapacitacion.js');

        //Cargar vistas

        echo view('htdocs/header', $data);
        echo view('formacion/programacionCapacitacion');
        //echo view('htdocs/modalConfirmation');
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
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Programas de capacitación', "link" => base_url('Formacion/programaCapacitacion'), "class" => ""),
            array("titulo" => 'Informacion de la capacitación', "link" => base_url('Formacion/participantesCapacitacion/' . $capacitacionID), "class" => ""),
        );

        $data['capacitacionInfo'] = $this->FormacionModel->getCapacitacionInfo($capacitacionID);
        $data['asistencia'] = $this->FormacionModel->getAsistenciaCapacitacion($capacitacionID);
        $data['encuesta'] = $this->FormacionModel->getResultadosEncuestaSatisfaccion($capacitacionID);

        load_plugins(['datatables_buttons', 'datepicker', 'sweetalert2', 'select2', 'dropzone', 'modalPdf'], $data);

        //Styles
        //Scripts
        //$data['scripts'][] = base_url("assets/js/modalPdf.js");
        $data['scripts'][] = base_url("assets/js/formacion/participantesCapacitacion.js");

        //Cargar vistas
        echo View('htdocs/header', $data);
        echo View('formacion/participantesCapacitacion');
        echo View('htdocs/modalPdf');
        echo View('htdocs/footer');
    } //end participantesCapacitacion

    //Lia->vista de las capacitaciones para los instructores
    public function capacitacionesInstructor()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Capacitaciones';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Capacitaciones', "link" => base_url('Formacion/capacitacionesInstructor'), "class" => ""),
        );

        $data['capacitaciones'] = $this->FormacionModel->getCapacitacionesInstructor();

        load_plugins(['moment', 'select2', 'datatables_buttons'], $data);

        //Styles
        //Scripts
        $data['scripts'][] = base_url('assets/js/formacion/capacitacionesInstructor.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('formacion/capacitacionesInstructor');
        //echo view('htdocs/modalConfirmation');
        echo view('htdocs/footer');
    }

    //Lia->Vista de informacion de la capacitacion para el instructor
    public function informacionCapacitacionInstructor($capacitacionID)
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $capacitacionID = encryptDecrypt('decrypt', $capacitacionID);
        $data['title'] = 'Informacion de la capacitación';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Capacitaciones', "link" => base_url('Formacion/capacitacionesInstructor'), "class" => ""),
            array("titulo" => 'Informacion de la capacitación', "link" => base_url('Formacion/informacionCapacitacionInstructor/' . $capacitacionID), "class" => ""),
        );

        $data['capacitacionInfo'] = $this->FormacionModel->getCapacitacionInfo($capacitacionID);
        $data['asistencia'] = $this->FormacionModel->getAsistenciaCapacitacion($capacitacionID);


        load_plugins(['sweetalert2', 'datatables_buttons', 'select2'], $data);

        //Styles
        //Scripts
        $data['scripts'][] = base_url("assets/js/formacion/infoCapacitacionInstructor.js");

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('formacion/infoCapacitacionInstructor');
        echo view('htdocs/footer');
    } //end programaCapacitacion

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

        $data['capacitaciones'] =  $this->FormacionModel->getCapacitacionesByEmpleadoID();

        load_plugins(['sweetalert2', 'select2', 'datatables_buttons', 'modalPdf'], $data);

        //Styles
        //Scripts
        $data['scripts'][] = base_url("assets/js/formacion/misCapacitaciones.js");

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('formacion/misCapacitaciones');
        echo view('htdocs/modalPdf');
        echo view('htdocs/footer');
    }

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

        $data['capacitacionInfo'] = $this->FormacionModel->getCapacitacionInfo($idCapacitacion);
        $data['encuesta'] = $this->FormacionModel->getEncuestaCapacitacion($idCapacitacion);

        load_plugins(['datables4'], $data);

        //STYLES
        $data['styles'][] = base_url('assets/css/encuestaCapacitacion.css');

        //SCRIPTS
        $data['scripts'][] = base_url("assets/js/formacion/infoCapacitacionParticipante.js");

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('formacion/infoCapacitacionParticipante');
        echo view('htdocs/footer');
    } //end infoCapacitacionParticipante

    /*
      ______ _    _ _   _  _____ _____ ____  _   _ ______  _____
     |  ____| |  | | \ | |/ ____|_   _/ __ \| \ | |  ____|/ ____|
     | |__  | |  | |  \| | |      | || |  | |  \| | |__  | (___
     |  __| | |  | | . ` | |      | || |  | | . ` |  __|  \___ \
     | |    | |__| | |\  | |____ _| || |__| | |\  | |____ ____) |
     |_|     \____/|_| \_|\_____|_____\____/|_| \_|______|_____/
    */

    //Diego -> agregar/actualizar capacitacion
    public function addCapacitacion()
    {
        $post = $this->request->getPost();

        // Construir el arreglo de días
        $dias = array_filter(array_map(function ($fecha, $inicio, $fin) {
            return $fecha ? ['fecha' => $fecha, 'inicio' => $inicio, 'fin' => $fin] : null;
        }, $post['fecha'], $post['inicio'], $post['fin']));

        $isNew = empty($post['cap_CapacitacionID']);
        $data = [
            'cap_CursoID' => $post['cap_CursoID'],
            'cap_Fechas' => json_encode($dias),
            'cap_NumeroDias' => count($dias),
            'cap_Costo' => $post['cap_Costo'],
            'cap_Tipo' => $post['cap_Tipo'],
            'cap_Observaciones' => $post['cap_Observaciones'],
            'cap_EmpleadoID' => session('id'),
            'cap_Comprobante' => $post['cap_Comprobante'],
            'cap_TipoComprobante' => $post['cap_TipoComprobante'],
            'cap_CalAprobatoria' => $post['cap_CalAprobatoria'],
            'cap_Lugar' => $post['cap_Lugar'],
            'cap_Dirigido' => $post['cap_Dirigido'],
        ];

        // Agregar campos condicionales
        if (isset($post['cap_ProveedorCursoID'])) {
            $data['cap_ProveedorCursoID'] = $post['cap_ProveedorCursoID'];
        }
        if (isset($post['cap_InstructorID'])) {
            $data['cap_InstructorID'] = $post['cap_InstructorID'];
        }
        if ($isNew) {
            $data['cap_FechaRegistro'] = date('Y-m-d');
            $result = insert('capacitacion', $data);
            $message = $result ? '¡Se registró la capacitación correctamente!' : '¡Ocurrió un error al registrar. Intente más tarde!';
        } else {
            $result = update('capacitacion', $data, ['cap_CapacitacionID' => (int)$post['cap_CapacitacionID']]);
            $message = $result ? '¡Se actualizó la capacitación correctamente!' : '¡Ocurrió un error al actualizar. Intente más tarde!';
        }

        // Insertar log y establecer mensaje de sesión
        if ($result) {
            insertLog($this, session('id'), $isNew ? 'Insertar' : 'Actualizar', 'capacitacion', $isNew ? $result : $post['cap_CapacitacionID']);
        }
        $this->session->setFlashdata(['response' => $result ? 'success' : 'error', 'txttoastr' => $message]);

        return redirect()->to($_SERVER['HTTP_REFERER']);
    }

    //Lia guarda los comentarios de capacitacion del instructor
    public function saveComentariosInstructor()
    {
        $post = $this->request->getPost();
        $result = update('capacitacion', ['cap_ComentariosInstructor' => $post['cap_ComentariosInstructor']], ['cap_CapacitacionID' => (int)$post['cap_CapacitacionID']]);

        $this->session->setFlashdata([
            'response' => $result ? 'success' : 'error',
            'txttoastr' => $result ? 'Comentarios enviados.' : '¡Ocurrio un error intente más tarde!'
        ]);

        return redirect()->to($_SERVER['HTTP_REFERER']);
    }


    //Lia -> Encuesta de satisfaccion
    public function saveEncuestaSatisfaccion($capacitacionID)
    {
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
            $result = insert('encuestacapacitacion',$entrevista);
            if ($result)
                $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡La encuesta de satisfacción se guardó correctamente!'));
            else
                $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => 'Ocurrio un problema al guardar la encuesta, por favor intente mas tarde.'));

            return redirect()->to($_SERVER['HTTP_REFERER']);
        }
    }
    //end saveEncuestaSatisfaccion

    //Lia -> Calcular total de la encuesta
    private function obtenerValorEncuesta($data)
    {
        $categorias = [
            'Metodologia' => ['1a', '1b', '1c', '1d', '1e'],
            'Instructor' => ['1a', '1b', '1c', '1d', '1e', '1f'],
            'Organizacion' => ['1a', '1b'],
            'Satisfaccion' => ['1a', '1b', '1c']
        ];

        $total = 0;
        $peso = count($categorias);

        foreach ($categorias as $key => $indices) {
            $subtotal = 0;
            foreach ($indices as $indice) {
                $campo = "ent_{$key}{$indice}";
                $subtotal += $this->switchValorEncuesta($data[$campo] ?? 0);
            }
            $total += $subtotal / count($indices);
        }

        return $total / $peso;
    }
    //obtenerValorEncuesta

    //Lia -> Valor de la opcion seleccionada
    private function switchValorEncuesta($estatus)
    {
        $valores = [
            "Totalmente de acuerdo" => 5,
            "De acuerdo" => 4,
            "Indeciso" => 3,
            "En desacuerdo" => 2,
            "Totalmente en desacuerdo" => 1
        ];

        return $valores[$estatus] ?? 0; // Retorna 0 si el estatus no está definido.
    }
    //switchValorEn
    /*
                   _         __   __
         /\       | |  /\    \ \ / /
        /  \      | | /  \    \ V /
       / /\ \ _   | |/ /\ \    > <
      / ____ \ |__| / ____ \  / . \
     /_/    \_\____/_/    \_\/_/ \_\
    */


    //Diego -> Obtiene la informacion de la capacitacion
    public function ajaxGetCapacitacionInfo()
    {
        $capacitacionID = (int)post('capacitacionID');
        $capacitacionInfo = $this->FormacionModel->getCapacitacionByID($capacitacionID);

        $response = array(
            'code' => (is_null($capacitacionID)) ? 0 : 1,
            'tipo' => (($capacitacionInfo['cap_Tipo'])),
            'capacitacionInfo' => $capacitacionInfo,
            'fechas' => json_decode($capacitacionInfo['cap_Fechas'], true),
        );
        echo json_encode($response);
    }

    // Lia->trae los participantes de la capacitacion
    public function ajax_getParticipantes($capacitacionID)
    {
        $sql = "SELECT E.emp_EmpleadoID, E.emp_Nombre, E.emp_Numero, P.pue_Nombre, A.are_Nombre,
            P.pue_PuestoID, C.cape_Calificacion, C.cape_CapacitacionID, C.cape_CapacitacionEmpleadoID,
            S.suc_Sucursal
            FROM capacitacionempleado C
            LEFT JOIN empleado E ON E.emp_EmpleadoID = C.cape_EmpleadoID
            LEFT JOIN puesto P ON P.pue_PuestoID = E.emp_PuestoID
            LEFT JOIN area A ON A.are_AreaID = E.emp_AreaID
            LEFT JOIN sucursal S ON S.suc_SucursalID = E.emp_SucursalID
            WHERE E.emp_Estatus = 1 AND C.cape_CapacitacionID = ?
            ORDER BY E.emp_Nombre ASC";
        $empleados = $this->db->query($sql, [$capacitacionID])->getResultArray();

        foreach ($empleados as &$empleado) {
            $encuesta = $this->db->query(
                "SELECT ent_EncuestaID FROM encuestacapacitacion 
                                      WHERE ent_EmpleadoID = ? 
                                      AND ent_CapacitacionID = ?",
                [$empleado['emp_EmpleadoID'], $capacitacionID]
            )->getRowArray();
            $empleado['encuestaID'] = $encuesta['ent_EncuestaID'] ?? 0;
            $empleado['participante'] = encryptDecrypt('encrypt', $empleado['cape_CapacitacionEmpleadoID']);
        }

        echo json_encode(['data' => $empleados], JSON_UNESCAPED_SLASHES);
    }
    // Lia->Trae los participantes para lista de asistencia
    public function ajax_getParticipantesLista($capacitacionID)
    {
        $sql = "SELECT E.emp_EmpleadoID, E.emp_Nombre, E.emp_Numero
            FROM capacitacionempleado C 
            LEFT JOIN empleado E ON E.emp_EmpleadoID = C.cape_EmpleadoID 
            WHERE E.emp_Estatus = 1 AND C.cape_CapacitacionID = ?
            ORDER BY E.emp_Nombre ASC";
        $empleados = $this->db->query($sql, [$capacitacionID])->getResultArray();

        $arrEmpleados = array_map(function ($empleado, $count) {
            return [
                'asi_EmpleadoID' => $empleado['emp_EmpleadoID'],
                'asi_Asistencia' => 'asis_' . ($count + 1),
                'emp_Numero' => $empleado['emp_Numero'],
                'emp_Nombre' => $empleado['emp_Nombre'],
                'check' => '<div class="checkbox checkbox-primary checkbox-single" style="margin-bottom:12%;">
                           <input style="display:none;" type="checkbox" value="' . $empleado['emp_EmpleadoID'] . '" id="empleados' . ($count + 1) . '" checked>
                           <label></label>
                        </div>',
            ];
        }, $empleados, array_keys($empleados));

        echo json_encode(['data' => $arrEmpleados], JSON_UNESCAPED_SLASHES);
    }

    //lia->Trae la informacion de un participante de la capacitacion
    public function ajaxInfoParticipante()
    {
        $participanteID = (int)post("participanteID");
        $info = $this->FormacionModel->getParticipanteCapacitacionEmpleado($participanteID);
        $data['info'] = $info;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    //Lia asigna la calificacion al participante
    public function ajaxAsignarCalificacionPartic()
    {
        $post = $this->request->getPost();
        echo json_encode(['code' => update(
            'capacitacionempleado',
            ['cape_Calificacion' => $post['cape_Calificacion']],
            ['cape_CapacitacionEmpleadoID' => (int)$post['cape_CapacitacionEmpleadoID']]
        ) ? 1 : 0], JSON_UNESCAPED_SLASHES);
    }

    //Lia->Elimina un participante de la capacitacion
    public function ajaxRemoveParticipanteCapacitacion()
    {
        echo json_encode(['code' => delete(
            'capacitacionempleado',
            ['cape_CapacitacionEmpleadoID' => (int)post('participanteID')]
        ) ? 1 : 0], JSON_UNESCAPED_SLASHES);
    }

    //Lia->Guarda la imagen de la convocatoria
    public function ajaxSubirConvocatoriaCapacitacion($capacitacionID)
    {
        if (!isset($_FILES['fileConvocatoria'])) {
            echo json_encode(["response" => 0]);
            return;
        }

        $directorio = FCPATH . "/assets/uploads/capacitacion/$capacitacionID/convocatoria/";
        if (!file_exists($directorio)) {
            mkdir($directorio, 0777, true);
        }

        $nombre_archivo = eliminar_acentos(RemoveSpecialChar($_FILES['fileConvocatoria']['name']));
        $ruta = $directorio . $nombre_archivo;
        move_uploaded_file($_FILES['fileConvocatoria']['tmp_name'], $ruta);

        echo json_encode(["response" => 1]);
    }

    public function ajaxSubirMaterialCapacitacion($capacitacionID)
    {
        if (!isset($_FILES['fileMaterial'])) {
            echo json_encode(["response" => 0]);
            return;
        }

        $directorio = FCPATH . "/assets/uploads/capacitacion/$capacitacionID/material/";
        if (!file_exists($directorio)) {
            mkdir($directorio, 0777, true);
        }

        foreach ($_FILES['fileMaterial']['name'] as $key => $nombre_archivo) {
            $rand = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5);
            $ruta = $directorio . $rand . eliminar_acentos(RemoveSpecialChar($nombre_archivo));
            move_uploaded_file($_FILES['fileMaterial']['tmp_name'][$key], $ruta);
        }

        echo json_encode(["response" => 1]);
    }

    //Diego - borrar archivo
    public function ajax_borrarMaterial()
    {
        $post = $this->request->getPost();
        $url = FCPATH . "/assets/uploads/capacitacion/{$post['$capacitacionID']}/material/{$post['$archivo']}";
        if (file_exists($url)) unlink($url); // Elimina si existe
        echo json_encode(["response" => "success"]);
    }

    //Lia->Guarda la Asistencia por modulo
    public function ajax_addAsistenciaCapacitacion()
    {
        $post = $this->request->getPost();
        $empleados = json_decode($post['empleados']);
        $capacitacionID = $post['capacitacionID'];

        // Actualiza el estado de la capacitación
        update('capacitacion', ['cap_Estado' => 'En curso'], ['cap_CapacitacionID' => $capacitacionID]);

        // Verifica si ya existe asistencia para esa fecha
        $asistencia = $this->FormacionModel->getAsistenciaCapacitacionByFecha($capacitacionID, $post['fecha']);

        if (count($asistencia) > 0) {
            echo json_encode(['code' => 2]);
            return;
        }

        // Inserta la asistencia para los empleados
        foreach ($empleados as $checkbox) {
            insert('asistenciacapacitacion', [
                'asi_CapacitacionID' => $capacitacionID,
                'asi_EmpleadoID' => (int)$checkbox,
                'asi_Fecha' => $post['fecha']
            ]);
        }

        echo json_encode(['code' => 1]);
    }

    public function ajax_guardarEncuestaCapacitacion()
    {
        $id = $_POST['id'];
        $url = FCPATH . "/assets/uploads/resultados/encuesta/";
        // Asegura que el directorio exista
        if (!is_dir($url)) mkdir($url, 0777, true);
        $file = $url . "resultados" . $id . ".png";
        // Elimina el archivo existente si ya existe
        if (file_exists($file)) unlink($file);
        // Decodifica y guarda la imagen
        $data = base64_decode(str_replace(['data:image/png;base64,', ' '], ['', '+'], $_POST['img']));
        file_put_contents($file, $data);
        // Devuelve la imagen decodificada como respuesta
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    //Lia trae los comentarios del instructor
    public function ajax_getComentariosCap()
    {

        $post = $this->request->getPost();
        $idCapacitacion = $post['capacitacionID'];
        $capacitacion = $this->FormacionModel->getCapacitacionInfo($idCapacitacion);
        echo json_encode(array("response" => "success", "capacitacion" => $capacitacion));
    }

    //Lia->envia la convocatoria de la capacitacion
    // Función para enviar correos y notificaciones
    private function enviarConvocatoria($idCapacitacion, $subject, $texto, $destinatario, $template)
    {
        $data = [
            'titulo' => $subject,
            'nombre' => $destinatario['emp_Nombre'],
            'cuerpo' => 'Mediante el presente se le invita a participar en la siguiente convocatoria:
                        <div class="row text-center" >
                             <img src="' . convocatoriaCapacitacion($idCapacitacion)[0] . '" width="300" class="img-fluid" >
                        </div>',
        ];
        sendMail($destinatario['emp_Correo'], $subject, $data, $template);

        $notificacion = [
            "not_EmpleadoID" => $destinatario['emp_EmpleadoID'],
            "not_Titulo" => $subject,
            "not_Descripcion" => $texto,
            "not_EmpleadoIDCreo" => (int)session("id"),
            "not_FechaRegistro" => date('Y-m-d H:i:s'),
            "not_URL" => 'Formacion/misCapacitaciones',
            'not_Color' => 'bg-blue',
            'not_Icono' => 'zmdi zmdi-airplay',
        ];
        insert('notificacion', $notificacion);
    }

    public function ajaxEnviarConvocatoriaCapacitacion()
    {
        $post = $this->request->getPost();
        $idCapacitacion = $post['idCapacitacion'];
        $capacitacion = $this->FormacionModel->getCapacitacionInfo($idCapacitacion);

        // Crear texto de fechas
        $txtFechas = implode(', ', array_map(function ($fecha) {
            return shortDate($fecha['fecha'], '-') . ' de ' . shortTime($fecha['inicio']) . ' a ' . shortTime($fecha['fin']);
        }, json_decode($capacitacion['cap_Fechas'], true)));

        $subject = 'Convocatoria de capacitación';
        $texto = $capacitacion['cur_Nombre'] . ' que se llevará a cabo en ' . $capacitacion['cap_Lugar'] . ' los días ' . $txtFechas . '.';

        // Enviar convocatoria al instructor
        if ($capacitacion['cap_Tipo'] === "INTERNO") {
            $instructor = $this->db->query("SELECT ins_EmpleadoID, emp_Correo, emp_Nombre FROM instructor JOIN empleado ON ins_EmpleadoID=emp_EmpleadoID WHERE ins_InstructorID=" . $capacitacion['cap_InstructorID'])->getRowArray();
            $this->enviarConvocatoria($idCapacitacion, $subject, $texto, $instructor, "ConvocatoriaInstructor");
        }

        // Enviar convocatorias a los participantes
        $enviado = 0;
        $participantes = $this->FormacionModel->getParticipantesByCapacitacionID($idCapacitacion);
        foreach ($participantes as $participante) {
            $empleado = consultar_dato('empleado', 'emp_Correo, emp_Nombre, emp_EmpleadoID', "emp_EmpleadoID = " . $participante['cape_EmpleadoID']);
            if ($empleado['emp_Correo']) {
                $this->enviarConvocatoria($idCapacitacion, $subject, $texto, $empleado, "ConvocatoriaParticipante");
                $enviado++;
            }
        }

        // Actualizar estado y devolver respuesta
        if ($enviado > 0) {
            update('capacitacion', ['cap_Estado' => 'Enviada'], ['cap_CapacitacionID' => $idCapacitacion]);
            echo json_encode(["response" => 1]);
        } else {
            echo json_encode(["response" => 0]);
        }
    }

    public function ajaxTerminarCapacitacion()
    {
        $post = $this->request->getPost();
        $result = update('capacitacion', array('cap_Estado' => 'Terminada'), array('cap_CapacitacionID' => $post['idCapacitacion']));
        $data['code'] = $result ? 1 : 0;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    //Lia->trae todos los empleados y los empleados con los datos previos a la capacitacion
    public function ajax_getEmpleados($cursoID)
    {
        $empleados = $this->db->query("SELECT E.emp_EmpleadoID, E.emp_Nombre, E.emp_Numero, P.pue_Nombre, A.are_Nombre, P.pue_PuestoID, S.suc_Sucursal
            FROM empleado E
            LEFT JOIN puesto P ON P.pue_PuestoID = E.emp_PuestoID
            LEFT JOIN area A ON A.are_AreaID = E.emp_AreaID
            LEFT JOIN sucursal S ON S.suc_SucursalID = E.emp_SucursalID
            WHERE E.emp_Estatus = 1
            ORDER BY E.emp_Nombre ASC")
            ->getResultArray();

        foreach ($empleados as $count => &$empleado) {
            $empleado['check'] = '<div class="checkbox' . ($count + 1) . '">
                                <input id="checkbox' . ($count + 1) . '" type="checkbox" value="' . $empleado['emp_EmpleadoID'] . '" />
                                <label for="checkbox' . ($count + 1) . '"></label>
                              </div>';
        }

        echo json_encode(['data' => $empleados], JSON_UNESCAPED_SLASHES);
    }


    //Lia->agrega participantes a la capacitacion
    public function ajaxAgregarParticipantesCap()
    {
        $post = $this->request->getPost();
        $empleados = json_decode($post['empleados']);
        $capacitacionID = $post['capacitacionID'];

        $builder = db()->table("capacitacionempleado");

        foreach ($empleados as $checkbox) {
            if ($builder->getWhere(['cape_EmpleadoID' => $checkbox, 'cape_CapacitacionID' => $capacitacionID])->getNumRows() == 0) {
                $builder->insert([
                    "cape_EmpleadoID" => $checkbox,
                    "cape_CapacitacionID" => $capacitacionID
                ]);
            }
        }

        echo json_encode(['code' => 1]);
    }
}
