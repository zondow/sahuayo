<?php

namespace App\Controllers;

defined('FCPATH') or exit('No direct script access allowed');

use App\Models\UsuarioModel;
use CodeIgniter\Session\Session;

class Pruebas extends BaseController
{

    public function correo(){
        echo view('htdocs/correo');
    }

    public function phpinfo(){
        phpinfo();
    }
}
