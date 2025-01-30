<?php
namespace App\Models;

use CodeIgniter\Model;

class AccessModel extends Model{

    public function getUsuarioByUsername($username){
        $sql = "
        SELECT
                EMP.emp_EmpleadoID AS `id`,
                EMP.emp_Nombre AS `nombre`,
                EMP.emp_Numero AS `numero`,
                EMP.emp_Password AS `password`,
                EMP.emp_Nombre AS `name`,
                EMP.emp_Username AS `username`,
                EMP.emp_PuestoID AS `puesto`,
                EMP.emp_Estatus AS `status`,
                EMP.emp_Estado AS `estado`,
                EMP.emp_SucursalID AS `sucursal`,
                EMP.emp_FechaIngreso as `fechaIngreso`,
                'usuario' AS `type`,
                EMP.emp_Estatus AS `status`,
                PUE.pue_Nombre AS `nombrePuesto`,
                EMP.emp_DepartamentoID AS `departamento`,
                D.dep_Nombre as `departamentoNombre`,
                'En línea' AS `disponibilidad`,
                R.rol_Nombre AS `rol`,
                R.rol_Permisos AS `permisos`
               FROM empleado EMP
            LEFT JOIN puesto PUE ON PUE.pue_PuestoID = EMP.emp_PuestoID
            LEFT JOIN rol R ON R.rol_RolID=EMP.emp_Rol
            LEFT JOIN departamento D ON D.dep_DepartamentoID = EMP.emp_DepartamentoID
            WHERE EMP.emp_Username = ?";
        return $this->db->query($sql, array($username))->getRowArray();
    }//getUsuarioByUsername


    //getLoginAttempts
    public function getLoginAttempts($id, $type){
        $seconds = (BLOCKED_MINUTES * 60 );
        $now = date('Y-m-d H:i:s');
        //Verify attempts
        $sql = "SELECT COUNT(*) AS 'total'
                FROM acceso
                WHERE acc_Estatus = 0 AND
                      acc_UsuarioID = ? AND
                      acc_Tipo = ? AND
                      TIME_TO_SEC(TIMEDIFF(?, acc_Fecha)) < ?";
        $attemps = $this->db->query($sql, array($id, $type, $now, $seconds))->getRowArray();
        return $attemps['total'];
    }//getLoginAttempts

    //saveLoginAttempt
    public function saveLoginAttempt($id, $type, $success){
        $params = array(
            $id,
            $type,
            $_SERVER['REMOTE_ADDR'],
            date('Y-m-d H:i:s'),
            $success
        );
        $sql = "INSERT INTO acceso(acc_UsuarioID, acc_Tipo, acc_IP, acc_Fecha, acc_Estatus) VALUES (?, ?, ?, ?, ?)";
        $this->db->query($sql, $params);
    }//saveLoginAttempt

}