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
}
