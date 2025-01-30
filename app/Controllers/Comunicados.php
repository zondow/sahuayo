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

    //Lia ->Gestion de normativas
    public function normativaInterna()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Politicas y reglamentos';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Politicas y reglamentos', "link" => base_url('Comunicados/normativaInterna'), "class" => "active"),
        );

        $data['puestos'] = $this->BaseModel->getPuestos();
        load_plugins(['select2', 'sweetalert2', 'datables4'], $data);

        //Styles
        //Scripts

        $data['scripts'][] = base_url('assets/js/normativaInterna.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('comunicados/normativaInterna');
        echo view('htdocs/footer');
    } //end Gestion de normativas

    public function anuncios()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Gestionar anuncios';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Anuncios', "link" => base_url('Usuario/anuncio'), "class" => "active"),
        );

        load_plugins(['select2', 'datables4', 'sweetalert2'], $data);

        //Styles
        //Scripts
        $data['scripts'][] = base_url('assets/js/anuncio/subirAnuncio.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('usuario/subirAnuncio', $data);
        echo view('htdocs/footer', $data);
    }

    //Diego -> gestion de galeria de fotos
    public function subirFotos()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Gestión de galería';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Gestión de galería', "link" => base_url('Comunicados/subirFotos'), "class" => "active"),
        );

        load_plugins(['select2', 'datables4', 'sweetalert2'], $data);

        //Styles
        //Scripts
        $data['scripts'][] = base_url('assets/js/comunicados/subirFotos.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('comunicados/subirFotos');
        echo view('htdocs/footer');
    }

    //Diego -> galeria de fotos
    public function galeriaFotos()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Galería de fotos';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Galería de fotos', "link" => base_url('Comunicados/galeriaFotos'), "class" => "active"),
        );

        $data['albums'] = $this->ComunicadosModel->getAlbums();

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('comunicados/galeria');
        echo view('htdocs/footer');
    }

    //Diego -> galeria de fotos
    public function verGaleria($album)
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Galería de fotos';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Galería de fotos', "link" => base_url('Comunicados/galeriaFotos'), "class" => "active"),
            array("titulo" => 'Ver galería', "link" => base_url('Comunicados/verGaleria/'), "class" => "active"),
        );

        $data['album'] = $album;
        load_plugins(['lightbox'], $data);

        //Scripts
        //$data['scripts'][] = base_url('assets/libs/magnific-popup/jquery.magnific-popup.min.js');
        $data['scripts'][] = base_url('assets/js/pages/gallery.init.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('comunicados/verGaleria');
        echo view('htdocs/footer');
    }
    /*
      ______ _    _ _   _  _____ _____ ____  _   _ ______  _____
     |  ____| |  | | \ | |/ ____|_   _/ __ \| \ | |  ____|/ ____|
     | |__  | |  | |  \| | |      | || |  | |  \| | |__  | (___
     |  __| | |  | | . ` | |      | || |  | | . ` |  __|  \___ \
     | |    | |__| | |\  | |____ _| || |__| | |\  | |____ ____) |
     |_|     \____/|_| \_|\_____|_____\____/|_| \_|______|_____/
    */
    public function addAnuncio()
    {
        $post = $this->request->getPost();
        $msg = '';
        $code = 0;
        if (count($this->ComunicadosModel->nombreAnuncioRepetido($post['anu_Titulo'])) == 0) {
            $post['anu_Estatus'] = ($post['anu_Estatus'] === 'Si') ? 1 : 0;

            if ($post['anu_Estatus'] === 1) {
                update('anuncio', ['anu_Estatus' => 0], ['anu_Estatus' => 1]);
                $msg = ' y se ha publicado';
            }

            $data = [
                'anu_Titulo' => $post['anu_Titulo'],
                'anu_FechaRegistro' => date('Y-m-d'),
                'anu_Estatus' => $post['anu_Estatus']
            ];

            $id = insert('anuncio', $data);
            if ($id) {
                $directorio = dirname(WRITEPATH) . "/assets/uploads/anuncios/" . encryptDecrypt('encrypt', $id) . '/';
                if (!file_exists($directorio)) {
                    mkdir($directorio, 0777, true);
                }

                if (!empty($_FILES['files']['tmp_name'])) {
                    $newFilePath = $directorio . $_FILES['files']['name'];
                    move_uploaded_file($_FILES['files']['tmp_name'], $newFilePath);
                }

                $code = 1;
            }
        } else {
            $code = 2;
        }

        $messages = [
            1 => ['success', 'Se ha guardado el anuncio' . $msg],
            2 => ['error', 'Existe otro anuncio con el mismo nombre'],
            0 => ['error', '¡Ocurrio un error intente mas tarde!']
        ];

        $this->session->setFlashdata([
            'response' => $messages[$code][0],
            'txttoastr' => $messages[$code][1]
        ]);

        return redirect()->to($_SERVER['HTTP_REFERER']);
    }

    public function borrarAnuncio($id)
    {
        $url = FCPATH . "/assets/uploads/anuncios/" . $id . "/";
        $anuncioId = decrypt($id);

        if (!file_exists($url)) mkdir($url, 0777, true);

        $files = array_values(preg_grep('/^([^.])/', scandir($url)));
        $deleted = empty($files) || unlink($url . $files[0]);

        if ($deleted) {
            delete('anuncio', ["anu_AnuncioID" => $anuncioId]);
            $this->session->setFlashdata(['response' => 'success', 'txttoastr' => 'Se ha eliminado el anuncio']);
        } else {
            $this->session->setFlashdata(['response' => 'error', 'txttoastr' => 'No se ha podido eliminar el anuncio']);
        }

        return redirect()->to($_SERVER['HTTP_REFERER']);
    }

    public function estatusAnuncio($estatus, $id)
    {
        $id = decrypt($id);

        if ($this->ComunicadosModel->getAnuncioActivo($id)) {
            $this->session->setFlashdata(['response' => 'error', 'txttoastr' => 'Existe otro anuncio habilitado, deshabilítalo para poder continuar']);
        } else {
            $message = update('anuncio', ['anu_Estatus' => $estatus], ['anu_AnuncioID' => $id])
                ? ['response' => 'success', 'txttoastr' => 'Se ha actualizado el anuncio']
                : ['response' => 'error', 'txttoastr' => 'No se ha podido actualizar el anuncio'];
            $this->session->setFlashdata($message);
        }

        return redirect()->to($_SERVER['HTTP_REFERER']);
    }

    public function addFotos()
    {
        $post = $this->request->getPost();
        $post['gal_Nombre'] = str_replace('.','',eliminar_acentos($post['gal_Nombre']));
        $post['gal_Fecha'] = date('Y-m-d');
        $result = insert('galeria', $post);

        $directorio = FCPATH . "/assets/uploads/galeria/" . $post['gal_Nombre'] . "/";
        if (!file_exists($directorio)) mkdir($directorio, 0777, true);

        $guardado = 0;
        $total_count = count($_FILES['fileFotos']['name']);
        for ($i = 0; $i < $total_count; $i++) {
            $tmpFilePath = $_FILES['fileFotos']['tmp_name'][$i];
            if ($tmpFilePath) {
                $newFilePath = $directorio . $_FILES['fileFotos']['name'][$i];
                if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                    comprimirImagen($newFilePath, $newFilePath, 50);
                    $guardado++;
                }
            }
        }

        $this->session->setFlashdata([
            'response' => ($result > 0 && $guardado > 0) ? 'success' : 'error',
            'txttoastr' => ($result > 0 && $guardado > 0) ? 'Se ha guardado la nueva galería' : '¡Ocurrio un error intente más tarde!'
        ]);

        return redirect()->to($_SERVER['HTTP_REFERER']);
    }

    public function estatusGaleria($estatus, $galeria)
    {
        $result = update('galeria', ['gal_Estatus' => $estatus], ["gal_Galeria" => $galeria]);
        $estatusTexto = $estatus == 1 ? ' habilitada ' : ' deshabilitada ';
        
        $this->session->setFlashdata([
            'response' => $result ? 'success' : 'error',
            'txttoastr' => $result ? 'Galería' . $estatusTexto . 'para los colaboradores' : '¡Ocurrio un error intente más tarde!'
        ]);
    
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

    public function ajax_getPoliticas()
    {
        $result = $this->ComunicadosModel->getPoliticas();
        $politicas = [];
        $no = 1;

        foreach ($result as $item) {
            $puestosTexto = $this->obtenerTextoPuestos(json_decode($item['pol_Puestos']));
            $documentoHtml = $this->generarHtmlDocumento($item['pol_PoliticaID']);

            $politicas[] = [
                'id' => $item['pol_PoliticaID'],
                'no' => $no++,
                'nombre' => $item['pol_Nombre'],
                'puestos' => $puestosTexto,
                'estatus' => (int)$item['pol_Estatus'],
                'documento' => $documentoHtml,
            ];
        }

        echo json_encode(['data' => $politicas], JSON_UNESCAPED_SLASHES);
    }

    private function obtenerTextoPuestos($puestos)
    {
        $txt = "";
        foreach ($puestos as $puesto) {
            if ($puesto == 0) {
                $txt = "<span class='badge badge-purple'>Todos</span> ";
            } else {
                $nomPuesto = consultar_dato('pue_Nombre', 'puesto', "pue_PuestoID = $puesto");
                $txt .= "<span class='badge badge-purple'>" . $nomPuesto['pue_Nombre'] . "</span> ";
            }
        }
        return $txt;
    }

    private function generarHtmlDocumento($politicaID)
    {
        $documento = ultimoDocumentoPolitica((int)$politicaID);
        if (empty($documento)) {
            return '';
        }

        $extension = strtolower(substr($documento, -3));
        $imagen = ($extension == "pdf") ? base_url('assets/images/file_icons/pdf.svg') : '';

        return '
            <a href="' . $documento . '" class="file-download" target="_blank">
                <div class="file-img-box" style="width:40%">
                    <img src="' . $imagen . '" class="avatar-sm" alt="icon">
                </div>
            </a>';
    }

    //Lia ajax_savePolitica
    public function ajax_savePolitica()
    {
        $post = $this->request->getPost();
        $data['code'] = 0;

        if (!empty($post["pol_Nombre"]) && isset($post["pol_Puestos"])) {
            $politicaID = (int)$post['pol_PoliticaID'];
            $puestos = json_encode($post['pol_Puestos']);
            $politica = [
                'pol_Nombre' => $post['pol_Nombre'],
                'pol_Puestos' => $puestos
            ];

            // Función para guardar archivo
            $guardarArchivo = function ($id) {
                if (isset($_FILES['filePolitica'])) {
                    $directorio = FCPATH . "/assets/uploads/politicas/" . $id . "/";
                    if (!file_exists($directorio)) {
                        mkdir($directorio, 0777, true);
                    }

                    $num_files = count(scandir($directorio)) - 2;
                    $fecha = date('Y-m-d');
                    $nombre_archivo = $num_files . '-' . $fecha . '-' . $_FILES['filePolitica']['name'];
                    $ruta = $directorio . eliminar_acentos(strtr($nombre_archivo, " ", "-"));

                    return move_uploaded_file($_FILES['filePolitica']['tmp_name'], $ruta);
                }
                return true;
            };

            // Verificar si es actualización o inserción
            if ($politicaID > 0) {
                // Actualización
                if ($guardarArchivo($politicaID)) {
                    update('politica', $politica, ['pol_PoliticaID' => $politicaID]);
                    if ($this->db->affectedRows() > 0) {
                        insertLog($this, session('id'), 'Actualizar', 'politica', $politicaID);
                        $data['code'] = 2;
                    }
                }
            } else {
                // Inserción
                insert('politica', $politica);
                $insertedID = $this->db->insertID();

                if ($insertedID > 0 && $guardarArchivo($insertedID)) {
                    insertLog($this, session('id'), 'Insertar', 'politica', $insertedID);
                    $data['code'] = 1;
                }
            }
        }

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    //Lia ajax_getInfoPolitica
    public function ajax_getInfoPolitica()
    {
        $post = $this->request->getPost();
        $politicaID = (int)$post['idPolitica'];
        $data['result'] = consultar_dato('politica', '*', "pol_PoliticaID = $politicaID");
        $data['code'] = $data['result'] ? 1 : 0;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_getInfoPolitica

    //Lia ajax_getHistorialPolitica
    public function ajax_getHistorialPolitica()
    {
        $post = $this->request->getPost();
        $idPolitica = $post['politicaID'];

        $historial = array();
        $documentos = documentosPolitica((int)$idPolitica);

        if (!empty($documentos)) {
            foreach ($documentos as $documento) {

                $rest = strtolower(substr($documento, -3));
                if ($rest == "pdf") {
                    $imagen = base_url('assets/images/file_icons/pdf.svg');
                }

                $archivoNombre = explode('/', $documento);
                $count = count($archivoNombre) - 1;
                $nombre = explode('.', $archivoNombre[$count]);

                $html = '<div class="col-lg-4">
                        <div class="file-man-box rounded mb-3">
                            <a href=""  data-id="' . $idPolitica . '" data-archivo="' . $nombre[0] . '.' . $nombre[1] . '" target="_blank" class="file-close borrarDocto"><i class="mdi mdi-close-circle"></i></a>
                            <div class="file-img-box" style="width:35%;">
                                <img src="' . $imagen . '" class="avatar-lg" alt="icon">
                            </div>
                            <a href="' . $documento . '" class="file-download" " target="_blank"><i
                                    class="zmdi zmdi-cloud-download"></i> </a>
                            <div class="file-man-title">
                                <p class="mb-0 text-overflow">' . $nombre[0] . ' </p>
                            </div>
                        </div>
                    </div>';

                array_push($historial, $html);
            }
        }
        echo json_encode(array("historial" => $historial));
    } // end ajax_getHistorialPolitica

    //Lia ajax_getCombiosPolitica
    public function ajax_getCombiosPolitica()
    {
        $post = $this->request->getPost();
        $idPolitica = $post['politicaID'];
        $info = consultar_dato('politica', 'pol_PoliticaID,pol_Cambios', "pol_PoliticaID=$idPolitica");
        echo json_encode(array("response" => "success", "info" => $info));
    } //end ajax_getCombiosPolitica

    //Lia ajax_getColaboradoresPolitica
    public function ajax_getColaboradoresPolitica($politicaID)
    {
        $infoPol = consultar_dato('politica', '*', "pol_PoliticaID = $politicaID");
        $puestos = json_decode($infoPol['pol_Puestos']);
        $where = "SELECT emp_EmpleadoID, emp_Nombre, emp_PuestoID FROM empleado WHERE emp_Estatus = 1 AND emp_Estado = 'Activo'";

        $sql = in_array("0", $puestos)
            ? $where
            : $where . " AND emp_PuestoID IN (" . implode(',', $puestos) . ")";

        $empleados = $this->db->query($sql)->getResultArray();
        $remitentes = [];
        $count = 1;

        foreach ($empleados as $empleado) {
            $notificacion = $this->db->query(
                "SELECT * FROM notipolitica WHERE not_PoliticaID = $politicaID AND not_EmpleadoID = " . $empleado['emp_EmpleadoID']
            )->getRowArray();

            $enterado = '<span class="font-16" style="color: ' . (!empty($notificacion) && $notificacion['not_Enterado'] == 1 ? '#33eb2d' : '#808080') . ';">&#10003;</span>';
            $visto = '<span class="font-16" style="color: ' . (!empty($notificacion) && $notificacion['not_Visto'] == 1 ? '#33eb2d' : '#808080') . ';">&#10003;</span>';


            $remitentes[] = [
                'numero' => $count++,
                'emp_Nombre' => $empleado['emp_Nombre'],
                'visto' => $visto,
                'enterado' => $enterado
            ];
        }

        echo json_encode(['data' => $remitentes], JSON_UNESCAPED_SLASHES);
    }
    //end ajax_getColaboradoresPolitica

    //Lia ajax_getPoliticasSel
    public function ajax_getPoliticasSel()
    {
        $result = $this->ComunicadosModel->getPoliticas();
        echo json_encode(array("info" => $result));
    } //end ajax_borrarDocumentoPolitica

    //Lia ajaxEnviarNotiCambioPoliticas
    public function ajaxEnviarNotiCambioPoliticas()
    {
        $politicas = explode(',', $this->request->getPost('politicas'));
        $empleados = [];
        $arrpol = [];

        foreach ($politicas as $politica) {
            $infoPol = consultar_dato('politica', '*', "pol_PoliticaID = $politica");
            $puestos = json_decode($infoPol['pol_Puestos']);
            $arrpol[] = $infoPol['pol_Nombre'];

            $where = (in_array("0", $puestos)) ?
                "emp_Estatus=1 AND emp_Estado='Activo'" :
                "emp_Estatus=1 AND emp_Estado='Activo' AND emp_PuestoID IN (" . implode(',', $puestos) . ")";

            $empList = $this->db->query("SELECT emp_EmpleadoID AS id, emp_Nombre AS nombre, emp_Correo AS correo FROM empleado WHERE $where")->getResultArray();
            $empleados = array_merge($empleados, $empList);
        }

        $polactualizadas = implode(', ', $arrpol);
        $subject = 'Actualización de normativas';
        $enviado = 0;

        foreach ($empleados as $empleado) {
            if ($empleado['correo']) {
                //$data = ["nombre" => $empleado['nombre'], "asunto" => $polactualizadas];
                //sendMail($empleado['correo'], $subject, $data, "Normativa");

                $notificacion = [
                    "not_EmpleadoID" => $empleado['id'],
                    "not_Titulo" => $subject,
                    "not_Descripcion" => $polactualizadas,
                    "not_EmpleadoIDCreo" => (int)session("id"),
                    "not_FechaRegistro" => date('Y-m-d H:i:s'),
                    "not_URL" => 'Usuario/normativa',
                ];
                insert('notificacion', $notificacion);

                foreach ($politicas as $politica) {
                    $notiPolitica = ["not_PoliticaID" => $politica, "not_EmpleadoID" => $empleado['id']];
                    insert('notipolitica', $notiPolitica);
                    update('notipolitica', ['not_Enterado' => 0, 'not_Visto' => 0], $notiPolitica);
                }
                $enviado++;
            }
        }

        echo json_encode(["response" => $enviado > 0 ? 1 : 0]);
    } // end ajaxEnviarNotiCambioPoliticas


    //Lia ajaxCambiarEstadoPolitica
    public function ajaxCambiarEstadoPolitica()
    {
        $politicaID = (int)post("politicaID");
        $estado = post("estado");
        $response = update('politica', array('pol_Estatus' => $estado), array("pol_PoliticaID" => $politicaID));
        insertLog($this, session('id'), 'Estatus', 'politica', $politicaID);
        $data['code'] = $response ? 1 : 0;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } // end ajaxCambiarEstadoPolitica

    public function ajax_getAnuncio()
    {
        $anuncios = $this->ComunicadosModel->getAnuncios();
        foreach ($anuncios as &$anuncio) {
            $anuncio['anu_AnuncioID'] = encryptDecrypt('encrypt', $anuncio['anu_AnuncioID']);
            $anuncio['anu_FechaRegistro'] = longDate($anuncio['anu_FechaRegistro'], ' de ');
            // Asigna el archivo si existe
            $archivo = archivoAnuncio($anuncio['anu_AnuncioID']);
            $anuncio['archivo'] = $archivo ? $archivo : null;
        }

        echo json_encode(['data' => $anuncios], JSON_UNESCAPED_SLASHES);
    }

    public function ajax_getAlbums()
    {
        $albums = $this->ComunicadosModel->getAlbums();
        foreach($albums as &$album){
            $album['fecha'] = longDate($album['fecha'],' de ');
        }
        $data['data'] = $albums;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }
}
