<?php

namespace App\Controllers;

defined('FCPATH') or exit('No direct script access allowed');

class Biometrico extends BaseController
{

    public function index()
    {
        //Cargar vistas
        echo view('biometrico/example');
    } //INDEX

    public function phpinfo(){
        phpinfo();
    }

    public function pruebabiometrico(){
        //phpinfo();
        $empelados=biometrico()->query("SELECT * FROM iclock_transaction ")->getResultArray();
        //$empelados=biometrico()->query("SELECT * FROM iclock_transaction WHERE  CONVERT(varchar(10), punch_time, 23) = ? ",[date('Y-m-d')])->getResultArray();
        $data=array();
        foreach($empelados as $emp){
            $nombre = db()->query("SELECT emp_Nombre FROM empleado where emp_Numero=?",[(int)$emp['emp_code']])->getRowArray()['emp_Nombre'];
            $dataPre['nombre']=$nombre;
            $dataPre['hora']=$emp['punch_time'];
            array_push($data,$dataPre);
        }
        return json_encode($data);
    }

    public function pruebabiometrico3(){
        $empleados = db()->query("SELECT emp_EmpleadoID,emp_Numero FROM empleado WHERE emp_Estatus=1")->getResultArray();
        $fechaActual = '2024-01-31';
        $data=array();
        foreach ($empleados as $empleado){
            $checadas = biometrico()->query("SELECT CONVERT(varchar(8), punch_time, 108) AS punch_time FROM iclock_transaction WHERE emp_Code = ? AND CONVERT(varchar(10), punch_time, 23) = ? ",array((int)$empleado['emp_Numero'],$fechaActual))->getResultArray();
            $data_checadas=array();
            if($checadas){
                foreach($checadas as $check){
                    $data_checadas[]=$check['punch_time'];
                }
                $data_checadas = array_unique($data_checadas);
                $data_insert=array(
                    'asi_EmpleadoID' => $empleado['emp_EmpleadoID'],
                    "asi_FechaHora"=> date('Y-m-d H:i:s'),
                    "asi_Fecha"=>$fechaActual,
                    "asi_Hora"=>json_encode($data_checadas)
                );
                array_push($data,$data_insert);
            }
        }
    }

    public function pruebabiometrico2(){
        $empleados = db()->query("SELECT emp_EmpleadoID,emp_Numero FROM empleado WHERE emp_Estatus=1")->getResultArray();

        // Fecha inicial
        $fechaActual = '2023-11-15';
        // Fecha actual
        $fechaHoy = date('Y-m-d');
        for ($fecha = $fechaActual; $fecha <= $fechaHoy; $fecha = date('Y-m-d', strtotime($fecha . ' +1 day'))) {
            foreach ($empleados as $empleado){
                $checadas = biometrico()->query("SELECT CONVERT(varchar(8), punch_time, 108) AS punch_time FROM iclock_transaction WHERE emp_Code = ? AND CONVERT(varchar(10), punch_time, 23) = ? ",array((int)$empleado['emp_Numero'],$fecha))->getResultArray();
                $data_checadas=array();
                if($checadas){
                    foreach($checadas as $check){
                        $data_checadas[]=$check['punch_time'];
                    }
                    $data_checadas = array_unique($data_checadas);
                    $data_insert=array(
                        'asi_EmpleadoID' => $empleado['emp_EmpleadoID'],
                        "asi_FechaHora"=>date('Y-m-d H:i:s'),
                        "asi_Fecha"=>$fecha,
                        "asi_Hora"=>json_encode($data_checadas)
                    );
                    $builder = db()->table('asistencia');
                    $result=$builder->insert($data_insert);
                }
            }
        }
        /*$fechaAyer = date('Y-m-d', strtotime("{$fechaActual} -1 day"));
        foreach ($empleados as $empleado){
            $checadas = biometrico()->query("SELECT CONVERT(varchar(8), punch_time, 108) AS punch_time FROM iclock_transaction WHERE emp_Code = ? AND CONVERT(varchar(10), punch_time, 23) = ? ",array($empleado['emp_Numero'],$fechaActual))->getResultArray();
            $data_checadas=array();
            if($checadas){
                foreach($checadas as $check){
                    $data_checadas[]=$check['punch_time'];
                }
                $data_checadas = array_unique($data_checadas);
                $data_insert=array(
                    'asi_EmpleadoID' => $empleado['emp_EmpleadoID'],
                    "asi_FechaHora"=>date('Y-m-d H:i:s'),
                    "asi_Fecha"=>$fechaActual,
                    "asi_Hora"=>json_encode($data_checadas)
                );
                $builder = db()->table('asistencia');
                $result=$builder->insert($data_insert);
            }
        }*/
    }

    public function cronJobBiometrico(){
        $empleados = db()->query("SELECT emp_EmpleadoID,emp_Numero FROM empleado WHERE emp_Estatus=1")->getResultArray();
        $fechaActual = date('Y-m-d');
        //$fechaAyer = date('Y-m-d', strtotime("{$fechaActual} -1 day"));
        foreach ($empleados as $empleado){
            $checadas = biometrico()->query("SELECT CONVERT(varchar(8), punch_time, 108) AS punch_time FROM iclock_transaction WHERE emp_Code = ? AND CONVERT(varchar(10), punch_time, 23) = ? ",array((int)$empleado['emp_Numero'],$fechaActual))->getResultArray();
            $data_checadas=array();
            if($checadas){
                foreach($checadas as $check){
                    $data_checadas[]=$check['punch_time'];
                }
                $data_checadas = array_unique($data_checadas);
                $data_insert=array(
                    'asi_EmpleadoID' => $empleado['emp_EmpleadoID'],
                    "asi_FechaHora"=> date('Y-m-d H:i:s'),
                    "asi_Fecha"=>$fechaActual,
                    "asi_Hora"=>json_encode($data_checadas)
                );
                $builder = db()->table('asistencia');
                $result=$builder->insert($data_insert);
            }
        }
    }

    public function cronJobBiometricoFallaP($date){
        $this->db->transStart();

        $empleados = db()->query("SELECT emp_EmpleadoID,emp_Numero FROM empleado WHERE emp_Estatus=1")->getResultArray();
        foreach ($empleados as $empleado){
            $checadas = biometrico()->query("SELECT CONVERT(varchar(8), punch_time, 108) AS punch_time FROM iclock_transaction WHERE emp_Code = ? AND CONVERT(varchar(10), punch_time, 23) = ? ",array((int)$empleado['emp_Numero'],$date))->getResultArray();
            $data_checadas=array();
            var_dump($checadas);exit();
            if($checadas){
                foreach($checadas as $check){
                    $data_checadas[]=$check['punch_time'];
                }
                $data_checadas = array_unique($data_checadas);
                $data_insert=array(
                    'asi_EmpleadoID' => $empleado['emp_EmpleadoID'],
                    "asi_FechaHora"=>date('Y-m-d H:i:s'),
                    "asi_Fecha"=>$date,
                    "asi_Hora"=>json_encode($data_checadas)
                );
                $builder = db()->table('asistencia');
                $result=$builder->insert($data_insert);
            }
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

    public function cronJobBiometricoFalla($date){
        $this->db->transStart();

        $empleados = db()->query("SELECT emp_EmpleadoID,emp_Numero FROM empleado WHERE emp_Estatus=1")->getResultArray();
        foreach ($empleados as $empleado){
            $checadas = biometrico()->query("SELECT CONVERT(varchar(8), punch_time, 108) AS punch_time FROM iclock_transaction WHERE emp_Code = ? AND CONVERT(varchar(10), punch_time, 23) = ? ",array((int)$empleado['emp_Numero'],$date))->getResultArray();
            $data_checadas=array();
            if($checadas){
                foreach($checadas as $check){
                    $data_checadas[]=$check['punch_time'];
                }
                $data_checadas = array_unique($data_checadas);
                $data_insert=array(
                    'asi_EmpleadoID' => $empleado['emp_EmpleadoID'],
                    "asi_FechaHora"=>date('Y-m-d H:i:s'),
                    "asi_Fecha"=>$date,
                    "asi_Hora"=>json_encode($data_checadas)
                );
                $builder = db()->table('asistencia');
                $result=$builder->insert($data_insert);
            }
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

    public function cronJobBiometricoFallaVista(){
        $post = $this->request->getPost();
        $date= $post['fechaRecuperacion'];
        $this->db->transStart();

        $empleados = db()->query("SELECT emp_EmpleadoID,emp_Numero FROM empleado WHERE emp_Estatus=1")->getResultArray();
        foreach ($empleados as $empleado){
            $existe = db()->query("SELECT * FROM asistencia WHERE asi_Fecha=? AND asi_EmpleadoID=?",array($date,$empleado['emp_EmpleadoID']))->getRowArray() ?? null;
            if(empty($existe)){
                $checadas = biometrico()->query("SELECT CONVERT(varchar(8), punch_time, 108) AS punch_time FROM iclock_transaction WHERE emp_Code = ? AND CONVERT(varchar(10), punch_time, 23) = ? ",array((int)$empleado['emp_Numero'],$date))->getResultArray();
                $data_checadas=array();
                if($checadas){
                    foreach($checadas as $check){
                        $data_checadas[]=$check['punch_time'];
                    }
                    $data_checadas = array_unique($data_checadas);
                    $data_insert=array(
                        'asi_EmpleadoID' => $empleado['emp_EmpleadoID'],
                        "asi_FechaHora"=>date('Y-m-d H:i:s'),
                        "asi_Fecha"=>$date,
                        "asi_Hora"=>json_encode($data_checadas)
                    );
                    $builder = db()->table('asistencia');
                    $result=$builder->insert($data_insert);
                }
            }
        }
        if ($this->db->transStatus() === false) {
            $this->db->transRollback();
            $this->session->setFlashdata(array('response' => 'error', 'txttoastr' => '¡Ocurrio un error intente mas tarde!'));
        } else {
            $this->db->transCommit();
            $this->session->setFlashdata(array('response' => 'success', 'txttoastr' => '¡Registros recuperados!'));
        }
        return redirect()->to($_SERVER['HTTP_REFERER']);
    }

}

