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

    //Diego -> Catalogo de roles donde puede asignar las funciones
    public function roles()
    {
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Roles de usuario';
        $data['breadcrumb'][] = array("titulo" => 'Inicio', "link" => base_url('Usuario/index'), 'class' => '');
        $data['breadcrumb'][] = array("titulo" => 'Configuración de roles de usuario', "link" => base_url('Configuracion/roles'), 'class' => 'active');

        //plugins
        load_datables($data);
        load_sweetalert($data);

        //Custom Styles
        //Custom Scripts
        $data['scripts'][] = base_url('assets/js/configuracion/roles.js');

        //Vistas
        echo view('htdocs/header', $data);
        echo view('configuracion/roles');
        echo view('configuracion/modalPermisosRol');
        echo view('htdocs/footer');
    } //roles

    public function diasInhabiles()
    {
        //Validar sessión
        validarSesion(self::LOGIN_TYPE);

        $data['title'] = 'Días inhabiles';
        $data['breadcrumb'] = array(
            array("titulo" => 'Inicio', "link" => base_url('Usuario/index'),'class' => ''),
            array("titulo" => 'Configuración de días inhabiles', "link" => base_url('Configuracion/diasInhabiles'),'class' => 'active')
        );

        load_moment($data);
        load_jquery_ui($data);
        load_fullcalendar($data);
        load_select($data);
        load_select2($data);

        //Custom Styles
        //Custom Scripts
        $data['scripts'][] = base_url('assets/js/configuracion/inhabiles.js');

        //Vistas
        echo view('htdocs/header', $data);
        echo view('configuracion/diasInhabiles');
        echo view('htdocs/footer');
    } //diasInhabiles

    /*
      ______ _    _ _   _  _____ _____ ____  _   _ ______  _____
     |  ____| |  | | \ | |/ ____|_   _/ __ \| \ | |  ____|/ ____|
     | |__  | |  | |  \| | |      | || |  | |  \| | |__  | (___
     |  __| | |  | | . ` | |      | || |  | | . ` |  __|  \___ \
     | |    | |__| | |\  | |____ _| || |__| | |\  | |____ ____) |
     |_|     \____/|_| \_|\_____|_____\____/|_| \_|______|_____/
    */

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

    /*
                   _         __   __
         /\       | |  /\    \ \ / /
        /  \      | | /  \    \ V /
       / /\ \ _   | |/ /\ \    > <
      / ____ \ |__| / ____ \  / . \
     /_/    \_\____/_/    \_\/_/ \_\
    */

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
}
