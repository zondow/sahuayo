<?php

namespace App\Controllers;

defined('FCPATH') or exit('No direct script access allowed');

use App\Models\AccessModel;

class Access extends BaseController
{

    //Gets index page based on user login type
    public function getIndexPage()
    {
        $page = base_url('Access/logOut');

        if ($this->session->loginType === true) { //Usuario
            $page = base_url('Usuario/index');
        }
        return $page;
    } //getIndexPage

    public function index()
    {
        $page = $this->getIndexPage();
        if ($page !== NULL) {
            return redirect()->to($page);
        } else {
            return redirect()->to(base_url("Access/logIn"));
        }
    } //INDEX

    //log In
    public function logIn_old()
    {
        //Init Variables and load Model
        $data['username'] = '';
        $data['error'] = '';
        //A valid session already exists...
        $id = $this->session->id;
        if (!empty($id)) {
            return redirect()->to(base_url(('Access/index')));
        } //if

        //Process Received Post Data
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            //Get cleaned post data
            $username = $_POST['username'];
            $password = $_POST['password'];
            $data['username'] = $username;

            //Modelo
            $AccessModel = new AccessModel();

            //Verify required data
            if (!empty($username) && !empty($password)) {

                //empleado
                if (empty($account)) {
                    $account = $AccessModel->getUsuarioByUsername($username);
                    $loginType = $account['type'];
                    $permisos = $account['permisos'];
                }


                //We got an existing account
                if (!empty($account)) {
                    if ($account['status'] === '1') {
                        //Validate Login Attempts
                        $loginAttempts = $AccessModel->getLoginAttempts($account['id'], $account['type']);
                        //Intentos de sesion
                        if ($loginAttempts < MAX_LOGIN_ATTEMPTS) {
                            //Validate Password
                            if (password_verify($password, $account['password'])) {
                                //Save new login attempt
                                $AccessModel->saveLoginAttempt($account['id'], $account['type'], 1);
                                //Set SESSION DATA
                                unset($account['password']);
                                $account['loginType'] = TRUE;
                                $this->session->set($account);
                                $this->session->set($permisos);
                                return redirect()->to(base_url("Access/index"));
                            } else {
                                //Save new login attempt 0
                                $AccessModel->saveLoginAttempt($account['id'], $account['type'], 0);
                                $data['error'] = 'Su nombre de usuario y contraseña no coinciden.';
                            } //if-else
                        } else {
                            $data['error'] = 'Su cuenta ha sido bloqueada. Podrá iniciar sesión nuevamente dentro de ' . BLOCKED_MINUTES . ' minutos';
                        } //if-else
                        /*}else{
                            $data['error'] = 'Su cuenta ha sido suspendida.';
                        }*/
                    } else {
                        $data['error'] = 'Lo sentimos. Su cuenta ha sido dada de baja.';
                    } //if-else status

                } else {
                    $data['error'] = 'No se encontró la cuenta especificada.';
                } //if-else account

            } //END IF EMPTY ACCOUNT
            else {
                $data['error'] = 'Por favor ingrese su usuario y contraseña.';
            } //if-else
        } //POST

        echo view("access/login", $data);
    } //logIn

    public function logIn()
    {
        // Init Variables and load Model
        $data['username'] = '';
        $data['error'] = '';

        // A valid session already exists...
        $id = $this->session->id;
        if (!empty($id)) {
            return redirect()->to(base_url('Access/index'));
        }

        // Process Received Post Data
        if ($this->request->getMethod() === 'post') {
            // Get cleaned post data
            $username = $this->request->getPost('username');
            $password = $this->request->getPost('password');
            $data['username'] = $username;

            // Model
            $accessModel = new AccessModel();

            // Verify required data
            if (!empty($username) && !empty($password)) {
                // Fetch user account
                $account = $accessModel->getUsuarioByUsername($username);

                if (!empty($account)) {
                    if ($account['status'] === '1') {
                        // Validate Login Attempts
                        $loginAttempts = $accessModel->getLoginAttempts($account['id'], $account['type']);
                        // Intentos de sesion
                        if ($loginAttempts < MAX_LOGIN_ATTEMPTS) {
                            // Validate Password
                            if (password_verify($password, $account['password'])) {
                                // Save new login attempt
                                $accessModel->saveLoginAttempt($account['id'], $account['type'], 1);

                                // Set SESSION DATA
                                unset($account['password']);
                                $account['loginType'] = TRUE;
                                $this->session->set($account);
                                $this->session->set($account['permisos']);

                                return redirect()->to(base_url('Access/index'));
                            } else {
                                // Save new login attempt
                                $accessModel->saveLoginAttempt($account['id'], $account['type'], 0);
                                $data['error'] = 'Su nombre de usuario y contraseña no coinciden.';
                            }
                        } else {
                            $data['error'] = 'Su cuenta ha sido bloqueada. Podrá iniciar sesión nuevamente dentro de ' . BLOCKED_MINUTES . ' minutos.';
                        }
                    } else {
                        $data['error'] = 'Lo sentimos. Su cuenta ha sido dada de baja.';
                    }
                } else {
                    $data['error'] = 'No se encontró la cuenta especificada.';
                }
            } else {
                $data['error'] = 'Por favor ingrese su usuario y contraseña.';
            }
        }
        echo view('access/login', $data);
    }


    //log Out
    public function logOut()
    {
        setcookie(session_name(), '', time() - 3600);
        $_SESSION = array();
        session_destroy();
        return redirect()->to(base_url("Access/logIn"));
    } //logOut


    public function enviarAccesosMasivos(){

        $subject = 'Bienvenido a THIGO';

        $enviado=0; //Cambia a 0 cuando se envien correos
        $sql = "SELECT emp_Correo,emp_Nombre,emp_Username,pass FROM empleado WHERE emp_Estatus=1 AND emp_Estado='Activo'";
        $empleados = $this->db->query($sql)->getResultArray();

        foreach ($empleados as $empleado){

            if($empleado['emp_Correo'] !== ''){
                $data = array(
                    "nombre" => $empleado['emp_Nombre'],
                    "usuario" => $empleado['emp_Username'],
                    "pass" => $empleado['pass'],
                );
                if(sendMail($empleado['emp_Correo'], $subject, $data, "AccesosMasivos")){
                    $enviado++;
                }

            }
        }
        if($enviado>0){
           echo 'Enviado '.$enviado;
        }
    }

    function pass(){
        echo encryptKey(1);
    }


}
