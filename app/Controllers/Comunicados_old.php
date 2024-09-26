<?php

namespace App\Controllers;

defined('FCPATH') or exit('No direct script access allowed');

use App\Models\ComunicadosModel;

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

        $model = new ComunicadosModel();
        $data['totalEnviados'] = $model->getComunicadosEnviados();
        $data['empleados'] = $model->getColaboradores();

        //Styles
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.css');
        $data['styles'][] = base_url('assets/libs/select2/css/select2.min.css');
        $data['styles'][] = base_url('assets/libs/summernote/summernote-bs4.css');


        //Scripts
        $data['scripts'][] = base_url('assets/plugins/datatables/jquery.dataTables.min.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/js/dataTables.bootstrap4.js');

        $data['scripts'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.js');
        $data['scripts'][] = base_url('assets/libs/select2/js/select2.full.min.js');
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

        $model = new ComunicadosModel();
        $data['inbox'] = $model->getComunicadosInbox();

        //Styles
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.css');
        $data['styles'][] = base_url('assets/libs/select2/css/select2.min.css');
        $data['styles'][] = base_url('assets/libs/summernote/summernote-bs4.css');


        //Scripts
        $data['scripts'][] = base_url('assets/plugins/datatables/jquery.dataTables.min.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/js/dataTables.bootstrap4.js');

        $data['scripts'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.js');
        $data['scripts'][] = base_url('assets/libs/select2/js/select2.full.min.js');
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

        $model = new ComunicadosModel();
        $data['puestos'] = $model->getPuestos();

        //Styles
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.css');
        $data['styles'][] = base_url('assets/libs/select2/css/select2.min.css');
        $data['styles'][] = base_url('assets/libs/summernote/summernote-bs4.css');

        //Scripts
        $data['scripts'][] = base_url('assets/plugins/datatables/jquery.dataTables.min.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/js/dataTables.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.js');
        $data['scripts'][] = base_url('assets/libs/select2/js/select2.full.min.js');
        $data['scripts'][] = base_url('assets/libs/summernote/summernote-bs4.min.js');
        $data['scripts'][] = base_url('assets/libs/summernote/lang/summernote-es-ES.js');

        $data['scripts'][] = base_url('assets/js/normativaInterna.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('comunicados/normativaInterna');
        echo view('htdocs/footer');
    } //end Gestion de normativas

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

        //Styles
        $data['styles'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/css/dataTables.bootstrap4.css');
        $data['styles'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.css');
        $data['styles'][] = base_url('assets/libs/select2/css/select2.min.css');
        $data['styles'][] = base_url('assets/libs/summernote/summernote-bs4.css');
        $data['styles'][] = base_url('assets/css/tables-custom.css');

        //Scripts
        $data['scripts'][] = base_url('assets/plugins/datatables/jquery.dataTables.min.js');
        $data['scripts'][] = base_url('assets/plugins/datatables/DataTables-1.10.21/js/dataTables.bootstrap4.js');
        $data['scripts'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.js');
        $data['scripts'][] = base_url('assets/libs/select2/js/select2.full.min.js');
        $data['scripts'][] = base_url('assets/libs/summernote/summernote-bs4.min.js');
        $data['scripts'][] = base_url('assets/libs/summernote/lang/summernote-es-ES.js');

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

        $model = new ComunicadosModel();
        $data['albums'] = $model->getAlbums();

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
            array("titulo" => 'Ver galería', "link" => base_url('Comunicados/verGaleria/' . $album), "class" => "active"),
        );

        $data['album'] = $album;
        $data['styles'][] = base_url('assets/libs/lightbox/css/lightbox.css');
        $data['scripts'][] = base_url('assets/libs/lightbox/js/lightbox.js');

        //Scripts
        //$data['scripts'][] = base_url('assets/libs/magnific-popup/jquery.magnific-popup.min.js');
        $data['scripts'][] = base_url('assets/js/pages/gallery.init.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('comunicados/verGaleria');
        echo view('htdocs/footer');
    }

    public function administrarCapsulas()
    {
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Administrar cápsulas educativas';

        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Administrar cápsulas educativas', "link" => base_url('Comunicados/administrarCapsulas'), "class" => "active"),
        );

        //scripts
        $data['styles'][] = base_url("assets/libs/select2/select2.min.css");
        $data['styles'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.css');
        $data['styles'][] = base_url('assets/libs/summernote/summernote-bs4.css');

        //styles
        $data['scripts'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.js');
        $data['scripts'][] = base_url("assets/libs/select2/select2.min.js");
        $data['scripts'][] = base_url('assets/js/comunicados/administrarCapsulas.js');
        $data['scripts'][] = base_url('assets/libs/summernote/summernote-bs4.min.js');
        $data['scripts'][] = base_url('assets/libs/summernote/lang/summernote-es-ES.js');
        $data['scripts'][] = base_url('assets/js/comunicados/administrarCapsulas.js');


        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('comunicados/administrarCapsulas', $data);
        echo view('htdocs/footer');
    }

    public function contenidoCapsulas($capsulaID)
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Contenido de la cápsula';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Administrar cápsulas', "link" => base_url('Comunicados/administrarCapsulas'), "class" => ""),
            array("titulo" => 'Contenido de la cápsula', "link" => base_url('Comunicados/contenidoCapsulas/' . $capsulaID), "class" => ""),
        );

        $data['capsulaID'] = $capsulaID;
        $model = new ComunicadosModel();
        $data['videos'] = $model->getVideosCapsulas($capsulaID);

        //Styles
        $data['styles'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.css');
        $data['styles'][] = base_url('assets/libs/dropzone/dropzone.min.css');

        //Scripts
        $data['scripts'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.js');
        $data['scripts'][] = base_url('assets/libs/dropzone/dropzone.min.js');
        $data['scripts'][] = base_url('assets/js/comunicados/contenidoCapsulas.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('htdocs/modalPdf.php');
        echo view('comunicados/contenidoCapsulas', $data);
        echo view('htdocs/footer', $data);
    }

    public function misContenidos()
    {
        validarSesion(self::LOGIN_TYPE);
        $data['title'] = 'Mis cápsulas educativas';

        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Mis cápsulas educativas', "link" => base_url('Comunicados/misContenidos'), "class" => "active"),
        );

        //scripts
        $data['styles'][] = base_url("assets/libs/select2/select2.min.css");
        $data['styles'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.css');
        $data['styles'][] = base_url('assets/libs/summernote/summernote-bs4.css');

        //styles
        $data['scripts'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.js');
        $data['scripts'][] = base_url("assets/libs/select2/select2.min.js");
        $data['scripts'][] = base_url('assets/js/comunicados/misContenidoCapsulas.js');
        $data['scripts'][] = base_url('assets/libs/summernote/summernote-bs4.min.js');
        $data['scripts'][] = base_url('assets/libs/summernote/lang/summernote-es-ES.js');


        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('comunicados/capsulas', $data);
        echo view('htdocs/footer');
    }

    public function misContenidoCapsulas($capsulaID)
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Contenido de la cápsula';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), "class" => ""),
            array("titulo" => 'Mis cápsulas educativas', "link" => base_url('Comunicados/misContenidos'), "class" => ""),
            array("titulo" => 'Contenido de la cápsula', "link" => base_url('Comunicados/contenidoCapsulas/' . $capsulaID), "class" => ""),
        );

        $data['capsulaID'] = $capsulaID;
        $model = new ComunicadosModel();
        $data['infoCapsula'] = $model->getInfoCapsula($capsulaID);
        $data['videos'] = $model->getVideosCapsulas($capsulaID);

        //Styles
        $data['styles'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.css');
        $data['styles'][] = base_url('assets/libs/dropzone/dropzone.min.css');

        //Scripts
        $data['scripts'][] = base_url('assets/plugins/sweet-alert2/sweetalert2.min.js');
        $data['scripts'][] = base_url('assets/libs/dropzone/dropzone.min.js');
        $data['scripts'][] = base_url('assets/js/comunicados/contenidoCapsulas.js');

        //Cargar vistas
        echo view('htdocs/header', $data);
        echo view('comunicados/miscontenidoCapsulas');
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

    //saveHistorialCambios
    public function saveHistorialCambios()
    {
        $post = $this->request->getPost();
        $builder = db()->table('politica');
        $result = $builder->update(array('pol_Cambios' => $post['pol_Cambios']), array('pol_PoliticaID' => (int)$post['politicaID']));
        if ($result) {
            $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => 'Historial de cambios actualizado.'));
        } else {
            $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error intente mas tarde!'));
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    } //end saveHistorialCambios

    public function estatusGaleria($estatus, $galeria)
    {
        $builder = db()->table('galeria');
        $result = $builder->update(array("gal_Estatus" => $estatus), array("gal_Nombre" => $galeria));
        switch ((int)$estatus) {
            case 0:
                $estatus = ' deshabilitada ';
                break;
            case 1:
                $estatus = ' habilitada ';
                break;
        }
        if ($result) {
            $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => 'Galería' . $estatus . 'para los colaboradores'));
        } else {
            $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error intente mas tarde!'));
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }

    public function addFotos()
    {
        $post = $this->request->getPost();
        $builder = db()->table('galeria');
        $post['gal_Fecha'] = date('Y-m-d');
        $result = $builder->insert($post);

        $guardado = 0;
        $directorio = FCPATH . "/assets/uploads/galeria/" . $post['gal_Nombre'] . "/";
        if (!file_exists($directorio)) {
            mkdir($directorio, 0777, true);
        }
        $total_count = count($_FILES['fileFotos']['name']);
        for ($i = 0; $i < $total_count; $i++) {
            $tmpFilePath = $_FILES['fileFotos']['tmp_name'][$i];
            if ($tmpFilePath != "") {
                $newFilePath = $directorio . $_FILES['fileFotos']['name'][$i];
                if (move_uploaded_file($tmpFilePath, $newFilePath)) {
                    comprimirImagen($newFilePath, $newFilePath, 50);
                    $guardado++;
                }
            }
        }
        if ($result > 0 && $guardado > 0) {
            $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => 'Se ha guardado la nueva galería'));
        } else {
            $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error intente mas tarde!'));
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }

    public function editGaleria()
    {
        $post = $this->request->getPost();
        $builder = db()->table('galeria');
        $result = $builder->update(array("gal_Nombre" => $post['gal_NombreE']), array("gal_Galeria" => $post['gal_Galeria']));
        if ($result) {
            $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => 'Se ha cambiado el nombre de la galería'));
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

    //Lia->trae los comunicados
    public function ajax_getComunicados()
    {
        $model = new ComunicadosModel();
        $comunicados = $model->getComunicados();
        $data['data'] = $comunicados;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    //Lia->Guarda un comunicado
    public function ajax_saveComunicado()
    {
        $post = $this->request->getPost();
        $data['code'] = 0;

        $empleados = array();
        if ($post['filtro'] === 'empleados') {
            $emp = $this->db->query("SELECT emp_EmpleadoID FROM empleado WHERE emp_Estatus=1")->getResultArray();
            foreach ($emp as $e) {
                array_push($empleados, $e['emp_EmpleadoID']);
            }
        } else {
            foreach ($post['com_Empleados'] as $emp) {
                array_push($empleados, encryptDecrypt('decrypt', $emp));
            }
        }

        $data_com = array(
            'com_Asunto' =>  $post['com_Asunto'],
            'com_Descripcion' =>  $post['com_Descripcion'],
            'com_Fecha' =>   date('Y-m-d'),
            'com_Empleados' => json_encode($empleados),
            'com_EmpleadoID' =>  session('id'),
        );
        $builder = db()->table('comunicado');
        $builder->insert($data_com);
        $insert_id = $this->db->insertID();

        if ($insert_id > 0) {
            insertLog($this, session('id'), 'Insertar', 'comunicado', $this->db->insertID());
            $data['code'] = 1;
        }
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    //Lia->Ver los remitentes del comunicado
    public function ajax_getRemitentesComunicados($idComunicado)
    {
        $sql = "SELECT com_Empleados FROM comunicado
            WHERE com_ComunicadoID=?";
        $empComunicado = $this->db->query($sql, array($idComunicado))->getRowArray();

        $empleados = json_decode($empComunicado['com_Empleados']);

        $rem = array();
        $remitentes = array();
        $count = 1;
        foreach ($empleados as $empleado) {
            $sql = "SELECT emp_EmpleadoID,emp_Nombre FROM empleado
            WHERE emp_EmpleadoID=?";
            $info = $this->db->query($sql, array($empleado))->getRowArray();

            $sql = "SELECT * FROM noticomunicado
            WHERE not_EmpleadoID=? AND not_ComunicadoID=?";
            $notificacion = $this->db->query($sql, array($empleado, $idComunicado))->getRowArray();

            if ($notificacion != null) {
                $enterado = '';
                if ($notificacion['not_Enterado'] == 1) $enterado = '<span class="font-16" style="color: #33eb2d">&#10003</span> ';

                $visto = '';
                if ($notificacion['not_Visto'] == 1) $visto = '<span class="font-16" style="color: #33eb2d">&#10003</span> ';
                $rem['numero'] = $count;
                $rem['emp_Nombre'] = $info['emp_Nombre'];
                $rem['visto'] = $visto;
                $rem['enterado'] = $enterado;
            } else {
                $rem['numero'] = $count;
                $rem['emp_Nombre'] = $info['emp_Nombre'];
                $rem['visto'] = '<span class="font-16"  style="color: #ff8040"> </span> ';
                $rem['enterado'] = '<span class="font-16" style="color: #ff8040"> </span> ';
            }

            $count++;

            array_push($remitentes, $rem);
        }
        $data['data'] = $remitentes;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    //Lia->Envia un comunicado
    public function ajaxEnviarComunicado()
    {
        $post = $this->request->getPost();
        $idComunicado = $post['idComunicado'];

        $sql = "SELECT * FROM comunicado WHERE com_ComunicadoID=?";
        $comunicado = $this->db->query($sql, array($idComunicado))->getRowArray();

        $subject = 'Nuevo comunicado';

        $enviado = 0; //Cambia a 0 cuando se envien correos
        $remitentes = json_decode($comunicado['com_Empleados']);
        foreach ($remitentes as $remitente) {
            $sql = "SELECT emp_Correo,emp_Nombre,emp_EmpleadoID FROM empleado WHERE  emp_EmpleadoID= ?";
            $empleado = $this->db->query($sql, array($remitente))->getRowArray();
            if ($empleado['emp_Correo'] !== '') {
                $data = array(
                    "nombre" => $empleado['emp_Nombre'],
                );
                sendMail($empleado['emp_Correo'], $subject, $data, "comunicado");

                $notificacion = array(
                    "not_EmpleadoID" => $empleado['emp_EmpleadoID'],
                    "not_Titulo" => $subject,
                    "not_Descripcion" => $comunicado['com_Asunto'],
                    "not_EmpleadoIDCreo" => (int)session("id"),
                    "not_FechaRegistro" => date('Y-m-d H:i:s'),
                    "not_URL" => 'Comunicados/misComunicados'
                );
                $builder = db()->table('notificacion');
                $builder->insert($notificacion);

                $notiComunicado = array(
                    "not_ComunicadoID" => $idComunicado,
                    "not_EmpleadoID" => $empleado['emp_EmpleadoID'],
                );
                $builder2 = db()->table('noticomunicado');
                $builder2->insert($notiComunicado);

                $enviado++;
            }
        }
        if ($enviado > 0) {
            $builder = db()->table('comunicado');
            $builder->update(array('com_Estado' => 'Enviado'), array('com_ComunicadoID' => $idComunicado));
            echo json_encode(array("response" => 1));
        } else echo json_encode(array("response" => 0));
    }

    public function ajax_verComunicado()
    {
        $post = $this->request->getPost();
        if (!empty($post['notificacionID'])) {
            $visto = $this->db->query("SELECT count(not_NotiComunicadoID) as 'visto' FROM noticomunicado WHERE not_Visto=1 AND not_NotiComunicadoID=" . $post['comunicadoID'])->getRowArray();
            if ($visto > 0) {
                $builder = db()->table('noticomunicado');
                $builder->update(array('not_Visto' => 1), array('not_NotiComunicadoID' => $post['notificacionID']));
            }
        }

        $sql = "SELECT * FROM comunicado WHERE com_ComunicadoID=" . $post['comunicadoID'];
        $com = $this->db->query($sql)->getRowArray();
        echo json_encode(array("response" => "success", "com" => $com));
    }

    //Lia->Elimina un comunicado
    public function ajaxEliminarComunicado()
    {
        $post = $this->request->getPost();
        $idComunicado = $post['comunicadoID'];
        $data['code'] = 0;
        $builder = db()->table('comunicado');
        $builder->update(array('com_Estatus' => 0), array('com_ComunicadoID' => $idComunicado));
        if ($this->db->affectedRows() > 0) {
            insertLog($this, session('id'), 'Eliminar', 'comunicado', $idComunicado);
            $data['code'] = 1;
        }
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    //Lia->trae los comunicados
    public function ajax_getComunicadosByEmpleado()
    {
        $model = new ComunicadosModel();
        $comunicados = $model->getComunicadosByEmpleado();
        $data['data'] = $comunicados;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    public function ajaxEnteradoComunicado()
    {
        $post = $this->request->getPost();
        $idComunicado = $post['comunicadoID'];
        $data['code'] = 0;
        $builder = db()->table('noticomunicado');
        $response = $builder->update(array('not_Enterado' => 1), array('not_NotiComunicadoID' => $idComunicado));
        if ($response > 0) {
            $data['code'] = 1;
        }
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    //Lia ajax_getPoliticas
    public function ajax_getPoliticas()
    {
        $model = new ComunicadosModel();
        $result = $model->getPoliticas();

        $politicas = array();
        $pol = array();
        $no = 1;
        foreach ($result as $item) {

            $txt = "";

            $puestos = json_decode($item['pol_Puestos']);
            foreach ($puestos as $puesto) {
                if ($puesto == 0) {
                    $txt = "<span class='badge badge-purple'>Todos</span> ";
                } else {
                    $sql = "SELECT pue_Nombre FROM puesto WHERE pue_PuestoID= ?";
                    $nomPuesto = $this->db->query($sql, array($puesto))->getRowArray();
                    $txt .= "<span class='badge badge-purple'>" . $nomPuesto['pue_Nombre'] . "</span> ";
                }
            }

            $documento = ultimoDocumentoPolitica((int)$item['pol_PoliticaID']);
            $html = '';
            if (!empty($documento)) {
                $rest = strtolower(substr($documento, -3));
                if ($rest == "pdf") {
                    $imagen = base_url('assets/images/file_icons/pdf.svg');
                }


                $archivoNombre = explode('/', $documento);
                $count = count($archivoNombre) - 1;
                $nombre = explode('.', $archivoNombre[$count]);

                $html = '
                            <div class="file-img-box">
                                <img src="' . $imagen . '" class="avatar-sm" alt="icon">
                            </div>
                            <a href="' . $documento . '" class="file-download" target="_blank"><i
                                    class="mdi mdi-download"></i> </a>

                            <div class="file-man-title">
                                <p class="mb-0 text-overflow">' . $nombre[0] . ' </p>
                            </div>
                       ';
            }

            $pol['id'] = $item['pol_PoliticaID'];
            $pol['no'] = $no;
            $pol['nombre'] = $item['pol_Nombre'];
            $pol['puestos'] = $txt;
            $pol['estatus'] = (int)$item['pol_Estatus'];
            $pol['documento'] = $html;

            $no++;

            array_push($politicas, $pol);
        }
        $data['data'] = $politicas;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_getPoliticas

    //Lia ajax_savePolitica
    public function ajax_savePolitica()
    {
        $post = $this->request->getPost();
        if (empty($post["pol_Nombre"]) || !isset($post["pol_Puestos"])) {
            $data['code'] = 0;
        } else {
            $politicaID = (int)$post['pol_PoliticaID'];
            unset($post['pol_PoliticaID']);

            $data['code'] = 0;

            $puestos = json_encode($post['pol_Puestos']);

            $politica = array(
                'pol_Nombre' => $post['pol_Nombre'],
                'pol_Puestos' => $puestos,
            );

            $builder = db()->table('politica');

            if ($politicaID > 0) {
                if (isset($_FILES['filePolitica'])) {
                    //lugar donde se guarda
                    $directorio = FCPATH . "/assets/uploads/politicas/" . $politicaID . "/";
                    if (!file_exists($directorio)) {
                        mkdir($directorio, 0777, true);
                    }
                    $directory = $directorio;
                    $files = scandir($directory);
                    $num_files = count($files) - 1;

                    $fecha = date('Y-m-d');
                    $nombre_archivo = $num_files . '-' . $fecha . '-' . $_FILES['filePolitica']['name'];
                    $ruta = $directorio . eliminar_acentos(strtr($nombre_archivo, " ", "-"));
                    move_uploaded_file($_FILES['filePolitica']['tmp_name'], $ruta);
                }

                $builder->update($politica, array('pol_PoliticaID' => $politicaID));
                if ($this->db->affectedRows() > 0) {
                    insertLog($this, session('id'), 'Actualizar', 'politica', $politicaID);
                }
                $data['code'] = 2;
            } else {
                $builder->insert($politica);
                if ($this->db->insertID() > 0) {

                    if (isset($_FILES['filePolitica'])) {

                        //lugar donde se guarda
                        $directorio = FCPATH . "/assets/uploads/politicas/" . $this->db->insertID() . "/";
                        if (!file_exists($directorio)) {
                            mkdir($directorio, 0777, true);
                        }
                        $num_files = 1;
                        $fecha = date('Y-m-d');
                        $nombre_archivo = $num_files . '-' . $fecha . '-' . $_FILES['filePolitica']['name'];
                        $ruta = $directorio . eliminar_acentos(strtr($nombre_archivo, " ", "-"));
                        move_uploaded_file($_FILES['filePolitica']['tmp_name'], $ruta);
                    }

                    insertLog($this, session('id'), 'Insertar', 'politica', $this->db->insertID());
                    $data['code'] = 1;
                }
            }
        }
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_savePolitica

    //Lia ajax_getInfoPolitica
    public function ajax_getInfoPolitica()
    {
        $post = $this->request->getPost();
        $politicaID = (int)$post['idPolitica'];
        $data['result'] = db()->query("SELECT * FROM politica WHERE pol_PoliticaID=" . $politicaID)->getRowArray();
        $data['code'] = $data['result'] ? 1 : 0;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_getInfoPolitica

    //Lia ajaxCambiarEstadoPolitica
    public function ajaxCambiarEstadoPolitica()
    {
        $politicaID = (int)post("politicaID");
        $estado = post("estado");
        $builder = db()->table('politica');
        $response = $builder->update(array('pol_Estatus' => $estado), array("pol_PoliticaID" => $politicaID));
        insertLog($this, session('id'), 'Estatus', 'politica', $politicaID);
        $data['code'] = $response ? 1 : 0;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } // end ajaxCambiarEstadoPolitica

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
                            <div class="file-img-box">
                                <img src="' . $imagen . '" class="avatar-lg" alt="icon">
                            </div>
                            <a href="' . $documento . '" class="file-download" " target="_blank"><i
                                    class="mdi mdi-download"></i> </a>
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

    //Lia ajax_borrarDocumentoPolitica
    public function ajax_borrarDocumentoPolitica()
    {
        $post = $this->request->getPost();
        $politicaID = $post['$politicaID'];
        $archivo = $post['$archivo'];
        $url = FCPATH . "/assets/uploads/politicas/" . $politicaID . "/";

        if (file_exists($url . $archivo)) unlink($url . $archivo); //Si existe elimina
        echo json_encode(array("response" => "success"));
    } //end ajax_borrarDocumentoPolitica

    //Lia ajax_getPoliticasSel
    public function ajax_getPoliticasSel()
    {
        $model = new ComunicadosModel();
        $result = $model->getPoliticas();
        echo json_encode(array("info" => $result));
    } //end ajax_borrarDocumentoPolitica

    //Lia ajaxEnviarNotiCambioPoliticas
    public function ajaxEnviarNotiCambioPoliticas()
    {
        $post = $this->request->getPost();
        $politicas = explode(',', $post['politicas']);

        $e = array();
        $empleados = array();
        $arrpol = array();
        foreach ($politicas as $politica) {

            $infoPol = $this->db->query("SELECT * FROM politica WHERE pol_PoliticaID=" . $politica)->getRowArray();
            $puestos = json_decode($infoPol['pol_Puestos']);

            if (in_array("0", $puestos)) {
                $sql = "SELECT emp_EmpleadoID,emp_Nombre,emp_Correo FROM empleado
            WHERE emp_Estatus=1 AND emp_Estado='Activo'";
                $emp = $this->db->query($sql)->getResultArray();
            } else {
                $sql = "SELECT emp_EmpleadoID,emp_Nombre,emp_Correo FROM empleado
            WHERE emp_Estatus=1 AND emp_Estado='Activo' AND emp_PuestoID IN (" . implode(',', $puestos) . ")";
                $emp = $this->db->query($sql)->getResultArray();
            }

            foreach ($emp as $item) {
                $e['id'] = $item['emp_EmpleadoID'];
                $e['nombre'] = $item['emp_Nombre'];
                $e['correo'] = $item['emp_Correo'];
                array_push($empleados, $e);
            }

            array_push($arrpol, $infoPol['pol_Nombre']);
        }

        $polactualizadas = implode(', ', $arrpol);

        $subject = 'Actualización de normativas';
        $asunto = $polactualizadas;
        $enviado = 0;
        foreach ($empleados as $empleado) {
            if ($empleado['correo'] !== '') {
                $data = array(
                    "nombre" => $empleado['nombre'],
                    "asunto" => $asunto,
                );

                sendMail($empleado['correo'], $subject, $data, "Normativa");

                $notificacion = array(
                    "not_EmpleadoID" => $empleado['id'],
                    "not_Titulo" => $subject,
                    "not_Descripcion" => $asunto,
                    "not_EmpleadoIDCreo" => (int)session("id"),
                    "not_FechaRegistro" => date('Y-m-d H:i:s'),
                    "not_URL" => 'Usuario/normativa',
                );
                $builder = db()->table('notificacion');
                $builder->insert($notificacion);

                foreach ($politicas as $politica) {
                    $notiPolitica = array(
                        "not_PoliticaID" => $politica,
                        "not_EmpleadoID" => $empleado['id'],
                    );
                    $builder = db()->table('notipolitica');
                    $builder->insert($notiPolitica);

                    //regresa a 0 el valor de enterado y visto
                    $actualizar = db()->table('notipolitica');
                    $reset = array(
                        'not_Enterado' => 0,
                        'not_Visto' => 0,
                    );
                    //var_dump($empleado);exit();
                    $actualizar->update($reset, array('not_PoliticaID' => $politica, 'not_EmpleadoID' => $empleado['id']));
                }
                $enviado++;
            }
        }
        if ($enviado > 0) {
            echo json_encode(array("response" => 1));
        } else echo json_encode(array("response" => 0));
    } //end ajaxEnviarNotiCambioPoliticas

    //Lia ajax_getColaboradoresPolitica
    public function ajax_getColaboradoresPolitica($politicaID)
    {
        $infoPol = $this->db->query("SELECT * FROM politica WHERE pol_PoliticaID=" . $politicaID)->getRowArray();
        $puestos = json_decode($infoPol['pol_Puestos']);
        $where = "SELECT emp_EmpleadoID,emp_Nombre, emp_PuestoID FROM empleado WHERE emp_Estatus=1 AND emp_Estado='Activo'";

        if (in_array("0", $puestos)) {
            $empleados = $this->db->query($where)->getResultArray();
        } else {
            $sql = $where . " AND emp_PuestoID IN (" . implode(',', $puestos) . ")";
            $empleados = $this->db->query($sql)->getResultArray();
        }

        $rem = array();
        $remitentes = array();
        $count = 1;

        foreach ($empleados as $empleado) {
            $sql = "SELECT * FROM notipolitica WHERE not_PoliticaID = " . $politicaID . " AND not_EmpleadoID = " . $empleado['emp_EmpleadoID'];
            $existeNoti = $this->db->query($sql)->getRowArray();
            if (!is_null($existeNoti)) {
                if ($existeNoti['not_Enterado'] == 1) $enterado = '<span class="font-16" style="color: #33eb2d">&#10003</span> ';
                else $enterado = '<span class="font-16" style="color: #808080"> </span> ';

                if ($existeNoti['not_Visto'] == 1) $visto = '<span class="font-16" style="color: #33eb2d">&#10003</span> ';
                else $visto = '<span class="font-16" style="color: #808080"> </span> ';
            } else {
                $enterado = '<span class="font-16" style="color: #808080"> </span> ';
                $visto = '<span class="font-16" style="color: #808080"> </span> ';
            }

            $rem['numero'] = $count;
            $rem['emp_Nombre'] = $empleado['emp_Nombre'];
            $rem['visto'] = $visto;
            $rem['enterado'] = $enterado;

            $count++;

            array_push($remitentes, $rem);
        }
        $data['data'] = $remitentes;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajax_getColaboradoresPolitica

    //Lia ajax_getCombiosPolitica
    public function ajax_getCombiosPolitica()
    {
        $post = $this->request->getPost();
        $idPolitica = $post['politicaID'];

        $sql = "SELECT pol_PoliticaID,pol_Cambios FROM politica WHERE pol_PoliticaID=?";
        $info = $this->db->query($sql, array($idPolitica))->getRowArray();
        echo json_encode(array("response" => "success", "info" => $info));
    } //end ajax_getCombiosPolitica

    public function ajax_getAlbums()
    {
        $albums = $this->db->query("SELECT *, gal_Nombre as 'nombre', gal_Fecha as 'fecha',gal_Estatus as 'estatus' FROM galeria ORDER BY gal_Fecha DESC")->getResultArray();
        $data['data'] = $albums;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    public function ajaxGetCapsulas()
    {
        $model = new ComunicadosModel();
        $capsulas = $model->getCapsulas();
        $capsulasArray = array();

        if (!empty($capsulas)) {
            foreach ($capsulas as $capsula) {
                $style = '';
                $estatus = '';

                if ((int)$capsula['cap_Estatus'] === 0) {
                    $estatus = '<a class="dropdown-item activarInactivar" data-id="' . $capsula["cap_CapsulaID"] . '" data-estado="' . $capsula["cap_Estatus"] . '" href="#" >Activar</a>';
                    $style = 'style="background-color: #e6e6e6"';
                } else {
                    $estatus = '<a class="dropdown-item activarInactivar" data-id="' . $capsula["cap_CapsulaID"] . '" data-estado="' . $capsula["cap_Estatus"] . '" href="#" >Inactivar</a>';
                }

                $html = '
                <div class="col-md-6 " >
                    <div class="dropdown float-right">
                        <a href="#" class="dropdown-toggle card-drop arrow-none" data-toggle="dropdown" aria-expanded="false">
                            <h3 class="m-0 text-muted"><i class="mdi mdi-dots-horizontal"></i></h3>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="btnGroupDrop1">
                            <a class="dropdown-item editarCapsula" data-id="' . $capsula["cap_CapsulaID"] . '" href="#">Editar</a>
                            ' . $estatus . '
                        </div>
                    </div>
                    <div class="card-box tilebox-one" ' . $style . ' >
                        <br>
                        <i class=" fas fa-chalkboard float-right text-muted"></i>
                        <a class="nombre header-title" href="' . base_url("Comunicados/contenidoCapsulas/" . $capsula["cap_CapsulaID"]) . '" >' . $capsula["cap_Titulo"] . '</a>
                        <p class="text-muted text-justify ">
                        ' . $capsula["cap_Descripcion"] . '
                        </p>
                    </div>
                </div>';

                array_push($capsulasArray, $html);
            }
        }

        echo json_encode(array("capsulas" => $capsulasArray), JSON_UNESCAPED_SLASHES);
    }

    public function ajaxSaveCapsula()
    {
        $post = $this->request->getPost();
        $post['cap_CapsulaID'] = encryptDecrypt('decrypt', $post['cap_CapsulaID']);
        $data['code'] = 0;
        $builder = db()->table("capsula");
        if ((int)$post['cap_CapsulaID'] <= 0) {
            unset($post['cap_CapsulaID']);
            $builder->insert($post);
            $result = $this->db->insertID();
            if ($result) $data['code'] = 1;
        } else {
            $result = $builder->update($post, array('cap_CapsulaID' => (int)$post['cap_CapsulaID']));
            if ($result) $data['code'] = 2;
        }
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    public function ajaxGetInfoCapsula()
    {
        $capsulaID = post("capsulaID");
        $model = new ComunicadosModel();
        $data['result'] = $model->getInfoCapsulaByID($capsulaID);
        $data['code'] = 1;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    public function ajaxCambiarEstadoCapsula()
    {
        $capsulaID = (int) encryptDecrypt('decrypt', post("capsulaID"));
        $estado = post("estado");
        $builder = db()->table("capsula");
        $response = $builder->update(array('cap_Estatus' => (int)$estado), array("cap_CapsulaID" => $capsulaID));
        $data['code'] = $response ? 1 : 0;
        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    public function ajaxSubirContenidoCapsula()
    {

        $capsulaID = encryptDecrypt('decrypt', post("id"));
        $numero = post("numero");
        $titulo = post("titulo");
        $guardado = 0;
        if (isset($_FILES['fileMaterial'])) {

            //lugar donde se guarda
            $directorio = FCPATH . "/assets/uploads/capsulas/" . $capsulaID . "/";
            if (!file_exists($directorio)) {
                mkdir($directorio, 0777, true);
            }
            $extension = explode('.', $_FILES['fileMaterial']['name']);

            if (substr_count($_FILES['fileMaterial']['name'], '.') >= 2) {
                $extension = explode('.', $_FILES['fileMaterial']['name']);
                $nombre = str_replace('.', '', $_FILES['fileMaterial']['name']);
                $nombre = substr($nombre, 0, -3);
                $nombre_archivo = preg_replace('/[^A-Za-z0-9\-]/', '', $nombre);
            } else {
                $nombre_archivo = preg_replace('/[^A-Za-z0-9\-]/', '', $_FILES['fileMaterial']['name']);
            }
            $nombre_archivo = $nombre_archivo . '.' . $extension[count($extension) - 1];

            $ruta = $directorio . eliminar_acentos($nombre_archivo);
            move_uploaded_file($_FILES['fileMaterial']['tmp_name'], $ruta);
            $guardado = 1;
        }
        if ($guardado > 0) {

            $data_contenido = array(
                'con_CapsulaID' => $capsulaID,
                'con_NumOrden' => $numero,
                'con_Titulo' => $titulo,
                'con_Archivo' => eliminar_acentos($nombre_archivo),
            );
            $builder = db()->table("contenidocapsula");
            $builder->insert($data_contenido);
            $result = $this->db->insertID();

            $data['code'] = $result ? 1 : 0;
        }

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    public function ajaxGetVistasContenido()
    {
        $post = $this->request->getPost();
        $contenidoCapsulaID = $post['contenidoID'];
        $model = new ComunicadosModel();
        $vistas = $model->getVistasContenidoCapsula($contenidoCapsulaID);
        $capsulasArray = array();

        foreach ($vistas as $vista) {
            $html = '
            <div class="col-md-4 mb-2 media ">
                <img class="d-flex mr-3 rounded-circle avatar-sm" src="' . fotoPerfil(encryptDecrypt('encrypt', $vista['emp_EmpleadoID'])) . '" alt="' . $vista['emp_Nombre'] . '">
                <div class="media-body">
                    <h6 class="m-0">' . $vista['emp_Nombre'] . '</h6>
                    <small class="text-muted">' . shortDateTime($vista['cap_Fecha']) . '</small>
                </div>
            </div>';

            array_push($capsulasArray, $html);
        }

        echo json_encode(array("capsulas" => $capsulasArray), JSON_UNESCAPED_SLASHES);
    }

    public function ajax_borrarContenidoByID()
    {
        $post = $this->request->getPost();
        $archivo = $post['$archivo'];
        $capsulaID = encryptDecrypt('decrypt', $post['$capsulaID']);
        $idContenido = $post['$id'];

        $url = FCPATH . "assets/uploads/capsulas/" . $capsulaID . "/";

        if (file_exists($url . $archivo)) {

            unlink($url . $archivo); //Si existe elimina
            $builder = db()->table("contenidocapsula");
            $response =  $builder->delete(array('con_ContenidoCapsulaID' => $idContenido));
        }

        $data['response'] = $response ? 1 : 0;

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    public function ajax_GuardarVista($id)
    {
        $vista = $this->db->query("SELECT * FROM capsulavista WHERE cap_ContenidoCapsulaID=" . encryptDecrypt('decrypt', $id) . " AND cap_EmpleadoID=" . session('id'))->getRowArray();
        if (empty($vista)) {
            $data = array(
                "cap_ContenidoCapsulaID" => encryptDecrypt('decrypt', $id),
                "cap_EmpleadoID" => session('id'),
                "cap_Fecha" => date('Y-m-d H:i:s')
            );
            $builder = $this->db->table('capsulavista');
            $builder->insert($data);
        }
    }

    public function ajaxGetMisCapsulas()
    {
        $model = new ComunicadosModel();
        $capsulas = $model->getCapsulas();
        $capsulasArray = array();

        if (!empty($capsulas)) {
            foreach ($capsulas as $capsula) {
                $style = '';
                $estatus = '';

                if ((int)$capsula['cap_Estatus'] === 0) {
                    $estatus = '<a class="dropdown-item activarInactivar" data-id="' . $capsula["cap_CapsulaID"] . '" data-estado="' . $capsula["cap_Estatus"] . '" href="#" >Activar</a>';
                    $style = 'style="background-color: #e6e6e6"';
                } else {
                    $estatus = '<a class="dropdown-item activarInactivar" data-id="' . $capsula["cap_CapsulaID"] . '" data-estado="' . $capsula["cap_Estatus"] . '" href="#" >Inactivar</a>';
                }

                $html = '
                <div class="col-md-6 " >
                    <div class="card-box tilebox-one" ' . $style . ' >
                        <br>
                        <i class=" fas fa-chalkboard float-right text-muted"></i>
                        <a class="nombre header-title" href="' . base_url("Comunicados/misContenidoCapsulas/" . $capsula["cap_CapsulaID"]) . '" >' . $capsula["cap_Titulo"] . '</a>
                        <p class="text-muted text-justify ">
                        ' . $capsula["cap_Descripcion"] . '
                        </p>
                    </div>
                </div>';

                array_push($capsulasArray, $html);
            }
        }

        echo json_encode(array("capsulas" => $capsulasArray), JSON_UNESCAPED_SLASHES);
    }
}
