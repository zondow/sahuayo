<?php

namespace App\Controllers;

defined('FCPATH') or exit('No direct script access allowed');

class Comunicados extends BaseController
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
    //Lia ->Gestion de comunicados
    public function comunicados()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Comunicados';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Comunicados', "link" => base_url('Comunicados/comunicado'), "class" => "active"),
        );

        $data['totalEnviados'] = $this->ComunicadosModel->getComunicadosEnviados();
        $data['empleados'] = $this->BaseModel->getEmpleados();

        load_plugins(['datatables_buttons', 'select2', 'sweetalert2'], $data);

        //Styles
        $data['styles'][] = base_url('assets/libs/summernote/summernote-bs4.css');

        //Scripts
        $data['scripts'][] = base_url('assets/libs/summernote/summernote-bs4.min.js');
        $data['scripts'][] = base_url('assets/libs/summernote/lang/summernote-es-ES.js');
        $data['scripts'][] = base_url('assets/js/comunicados.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('comunicados/crearComunicados', $data);
        echo view('htdocs/footer', $data);
    }

    public function misComunicados()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Comunicados';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Comunicados', "link" => base_url('Usuario/misComunicados'), "class" => "active"),
        );

        $data['inbox'] = $this->ComunicadosModel->getComunicadosInbox();
        $data['sinLeer'] = $this->ComunicadosModel->getComunicadosInboxSinLeer();

        load_plugins(['datatables', 'sweetalert2', 'select2'], $data);

        //Styles
        $data['styles'][] = base_url('assets/libs/summernote/summernote-bs4.css');

        //Scripts
        $data['scripts'][] = base_url('assets/libs/summernote/summernote-bs4.min.js');
        $data['scripts'][] = base_url('assets/libs/summernote/lang/summernote-es-ES.js');

        $data['scripts'][] = base_url('assets/js/misComunicados.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('comunicados/comunicados', $data);
        echo view('htdocs/footer', $data);
    }

    /*
      ______ _    _ _   _  _____ _____ ____  _   _ ______  _____
     |  ____| |  | | \ | |/ ____|_   _/ __ \| \ | |  ____|/ ____|
     | |__  | |  | |  \| | |      | || |  | |  \| | |__  | (___
     |  __| | |  | | . ` | |      | || |  | | . ` |  __|  \___ \
     | |    | |__| | |\  | |____ _| || |__| | |\  | |____ ____) |
     |_|     \____/|_| \_|\_____|_____\____/|_| \_|______|_____/
    */

    /*
                   _         __   __
         /\       | |  /\    \ \ / /
        /  \      | | /  \    \ V /
       / /\ \ _   | |/ /\ \    > <
      / ____ \ |__| / ____ \  / . \
     /_/    \_\____/_/    \_\/_/ \_\
    */

    //Lia->trae los comunicados
    public function ajax_getComunicados()
    {
        $comunicados = $this->ComunicadosModel->getComunicados();
        foreach ($comunicados as &$c) {
            $c['com_Fecha'] = longDate($c['com_Fecha'], ' de ');
        }
        $data['data'] = $comunicados;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    public function ajax_verComunicado()
    {
        $post = $this->request->getPost();
        $com = $this->ComunicadosModel->getComunicadoByID($post['comunicadoID']);
        echo json_encode(array("response" => "success", "com" => $com));
    }

    // Lia->Ver los remitentes del comunicado
    public function ajax_getRemitentesComunicados($idComunicado)
    {
        $empComunicado = $this->ComunicadosModel->getEmpleadosByComunicadoID($idComunicado);
        $empleados = json_decode($empComunicado['com_Empleados']);

        $remitentes = array();
        $count = 1;

        foreach ($empleados as $empleado) {
            $info = consultar_dato('empleado', 'emp_EmpleadoID,emp_Nombre', "emp_EmpleadoID=$empleado");
            $notificacion = $this->ComunicadosModel->getRegistroVistaNotificacion($empleado, $idComunicado);

            $visto = (isset($notificacion['not_Visto']) && $notificacion['not_Visto'] > 0)
                ? '<span class="font-16" style="color: #33eb2d">&#10003</span>'
                : '<span class="font-16" style="color: #ff8040"></span>';

            $enterado = (isset($notificacion['not_Enterado']) && $notificacion['not_Enterado'] > 0)
                ? '<span class="font-16" style="color: #33eb2d">&#10003</span>'
                : '<span class="font-16" style="color: #ff8040"></span>';

            $remitentes[] = [
                'numero' => $count++,
                'emp_Nombre' => $info['emp_Nombre'],
                'visto' => $visto,
                'enterado' => $enterado
            ];
        }

        echo json_encode(['data' => $remitentes], JSON_UNESCAPED_SLASHES);
    }

    //Lia->Guarda un comunicado
    public function ajax_saveComunicado()
    {
        $post = $this->request->getPost();
        $data['code'] = 0;

        $empleados = ($post['filtro'] === 'empleados')
            ? array_column($this->BaseModel->getEmpleados(), 'emp_EmpleadoID')
            : array_map(fn ($emp) => encryptDecrypt('decrypt', $emp), $post['com_Empleados']);

        $data_com = [
            'com_Asunto' => $post['com_Asunto'],
            'com_Descripcion' => $post['com_Descripcion'],
            'com_Fecha' => date('Y-m-d'),
            'com_Empleados' => json_encode($empleados),
            'com_EmpleadoID' => session('id')
        ];

        if ($insert_id = insert('comunicado', $data_com)) {
            insertLog($this, session('id'), 'Insertar', 'comunicado', $insert_id);
            $data['code'] = 1;
        }

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }


    //Lia->Envia un comunicado
    public function ajaxEnviarComunicado()
    {
        $post = $this->request->getPost();
        $idComunicado = $post['idComunicado'];
        $comunicado = $this->ComunicadosModel->getComunicadoInfo($idComunicado, true);
        $subject = 'Nuevo comunicado';

        $remitentes = json_decode($comunicado['com_Empleados']);
        $enviado = 0;

        foreach ($remitentes as $remitente) {
            $empleado = consultar_dato('empleado', 'emp_EmpleadoID,emp_Nombre,emp_Correo', "emp_EmpleadoID=$remitente");

            if (!empty($empleado['emp_Correo'])) {
                $datos = [
                    'titulo' => 'Nuevo comunicado',
                    'nombre' => $empleado['emp_Nombre'],
                    'cuerpo' => "Acaba de recibir un nuevo comunicado a través de la plataforma PEOPLE, inicie sesión para verlo."
                ];

                sendMail($empleado['emp_Correo'], $subject, $datos, "comunicado");

                $notificacion = [
                    "not_EmpleadoID" => $empleado['emp_EmpleadoID'],
                    "not_Titulo" => $subject,
                    "not_Descripcion" => $comunicado['com_Asunto'],
                    "not_EmpleadoIDCreo" => (int)session("id"),
                    "not_FechaRegistro" => date('Y-m-d H:i:s'),
                    "not_URL" => 'Comunicados/misComunicados',
                    "not_Color" => 'bg-blue',
                    "not_Icono" => 'zmdi zmdi-email',
                ];
                insert('notificacion', $notificacion);
                $enviado++;
            }
        }

        if ($enviado > 0) {
            update('comunicado', ['com_Estado' => 'Enviado'], ['com_ComunicadoID' => $idComunicado]);
        }

        echo json_encode(['response' => $enviado > 0 ? 1 : 0]);
    }

    //Lia->Elimina un comunicado
    public function ajaxEliminarComunicado()
    {
        $idComunicado = $this->request->getPost('comunicadoID');
        $data['code'] = update('comunicado', ['com_Estatus' => 0], ['com_ComunicadoID' => $idComunicado]) ? 1 : 0;

        if ($data['code'] === 1) {
            insertLog($this, session('id'), 'Eliminar', 'comunicado', $idComunicado);
        }

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    //Lia->trae los comunicados
    public function ajax_getComunicadosByEmpleado()
    {
        $empleadoID = session('id');
        $comunicados = $this->ComunicadosModel->getComunicadosByEmpleado();
    
        foreach ($comunicados as &$c) {
            $c['com_Fecha'] = longDate($c['com_Fecha'], ' de ');
    
            // Obtener directamente el valor de 'not_Enterado' o asignar 0 por defecto
            $c['not_Enterado'] = consultar_dato(
                'noticomunicado', 
                'not_Enterado', 
                "not_ComunicadoID = {$c['com_ComunicadoID']} AND not_EmpleadoID = $empleadoID"
            )['not_Enterado'] ?? 0;
        }
    
        echo json_encode(['data' => $comunicados], JSON_UNESCAPED_SLASHES);
    }
    

    public function ajax_verComunicadoColaborador()
    {
        $post = $this->request->getPost();
        $idComunicado = $post['comunicadoID'];
        $empleadoID = session('id');
        $existe = consultar_dato('noticomunicado', 'not_NotiComunicadoID', "not_ComunicadoID = $idComunicado AND not_EmpleadoID = $empleadoID");
        if ($existe) {
            update('noticomunicado', array('not_Visto' => 1), array('not_ComunicadoID' => $idComunicado, 'not_EmpleadoID' => $empleadoID));
        } else {
            insert('noticomunicado', array('not_Visto' => 1, 'not_ComunicadoID' => $idComunicado, 'not_EmpleadoID' => $empleadoID));
        }
        $com = consultar_dato('comunicado', '*', "com_ComunicadoID = $idComunicado");
        echo json_encode(array("response" => "success", "com" => $com));
    }

    public function ajaxEnteradoComunicado()
    {
        $post = $this->request->getPost();
        $idComunicado = $post['comunicadoID'];
        $empleadoID = session('id');
        $data['code'] = 0;
        $existe = consultar_dato('noticomunicado', 'not_NotiComunicadoID', "not_ComunicadoID = $idComunicado AND not_EmpleadoID = $empleadoID");
        if ($existe) {
            $response = update('noticomunicado', array('not_Enterado' => 1), array('not_ComunicadoID' => $idComunicado, 'not_EmpleadoID' => $empleadoID));
        } else {
            $response = insert('noticomunicado', array('not_Enterado' => 1, 'not_ComunicadoID' => $idComunicado, 'not_EmpleadoID' => $empleadoID));
        }
        if ($response > 0) {
            $data['code'] = 1;
        }
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }
}
