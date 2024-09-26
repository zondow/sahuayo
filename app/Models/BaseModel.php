<?php

namespace App\Models;

use CodeIgniter\Model;

class BaseModel extends Model
{
    public function getSucursales()
    {
        return $this->db->query("SELECT * FROM sucursal WHERE suc_Estatus=1")->getResultArray();
    }

    public function getDiasInhabiles()
    {
        return $this->db->query("SELECT * FROM diainhabil ")->getResultArray();
    }

    public function getDiasInhabilesLey()
    {
        return $this->db->query("SELECT * FROM diainhabilley ")->getResultArray();
    }

    public function getHorarios()
    {
        return $this->db->query('SELECT * FROM horario')->getResultArray();
    }

    public function getEmpleados()
    {
        return $this->db->query("SELECT *,suc_Sucursal FROM empleado JOIN sucursal ON emp_SucursalID=suc_SucursalID WHERE emp_Estatus=1 AND emp_Estado='Activo' ORDER BY emp_Nombre ASC")->getResultArray();
    }

    public function getNotificacionesPush()
    {
        return $this->db->query("SELECT * FROM notificacion WHERE not_Estatus=1 AND not_Push=1 AND not_EmpleadoID=" . (int)session("id"))->getResultArray();
    }

    public function getNotificaciones()
    {
        return $this->db->query("SELECT * FROM notificacion WHERE not_Estatus=1 AND not_EmpleadoID=" . (int)session("id"))->getResultArray();
    }

    public function getRH(){
        return $this->db->query("SELECT E.emp_EmpleadoID,E.emp_Nombre, E.emp_Correo FROM empleado E WHERE E.emp_Estatus=1 AND E.emp_Rol=1")->getResultArray();
    }
    
    public function getHorasExtra($empleadoID)
    {
        $queries = [
            "SELECT SUM(rep_Horas) as 'horas' FROM reportehoraextra WHERE rep_Estado='PAGADO' AND rep_TipoPago='Tiempo por tiempo' AND rep_EmpleadoID=?" => 0,
            "SELECT acu_HorasExtra as 'horas' FROM acumulados WHERE acu_EmpleadoID=?" => 0,
            "SELECT SUM(per_Horas) as 'horas' FROM permiso WHERE per_TipoID=7 AND per_Estatus=1 AND per_EmpleadoID=? AND per_Estado IN ('PENDIENTE','PRE-AUTORIZADO', 'AUTORIZADO', 'AUTORIZADO_RH')" => 0
        ];
    
        foreach ($queries as $query => $default) {
            $result = $this->db->query($query, [$empleadoID])->getRowArray()['horas'] ?? $default;
            $queries[$query] = (float) $result;
        }
    
        return ($queries[array_keys($queries)[0]] +  $queries[array_keys($queries)[1]]) - $queries[array_keys($queries)[2]];
    }

    public function getHorasAdministrativas($empleadoID){
        $horasAdm = $this->db->query("SELECT acu_DiasAdministrativos FROM acumulados WHERE acu_EmpleadoID=?",[$empleadoID])->getRowArray()['acu_DiasAdministrativos'] ?? 16;
        $horasAdmConsumidas = $this->db->query("SELECT SUM(per_Horas) as horas FROM permiso WHERE per_EmpleadoID = ? AND per_TipoID = 8 AND per_Estatus=1 AND per_Estado NOT IN('RECHAZADO_JEFE','RECHAZADO_RH','DECLINADO') AND ? BETWEEN YEAR(per_FechaInicio) AND YEAR(per_FechaFin)",[$empleadoID,date('Y')])->getRowArray()['horas'] ?? 0;
        return ($horasAdm - $horasAdmConsumidas);
    }

    public function getEmpleadoByID($empleadoID){
        $empleado = $this->db->query("SELECT * FROM empleado WHERE emp_EmpleadoID=?", [$empleadoID])->getRowArray();
    
        // Eliminar las claves emp_Password y pass si existen en el array
        if (isset($empleado['emp_Password'])) {
            unset($empleado['emp_Password']);
        }
        if (isset($empleado['pass'])) {
            unset($empleado['pass']);
        }
    
        return $empleado;
    }    

    public function getEmpleadoByNumero($empleadoNumero){
        $empleado = $this->db->query("SELECT * FROM empleado WHERE emp_Numero=?", [$empleadoNumero])->getRowArray();
    
        // Eliminar las claves emp_Password y pass si existen en el array
        if (isset($empleado['emp_Password'])) {
            unset($empleado['emp_Password']);
        }
        if (isset($empleado['pass'])) {
            unset($empleado['pass']);
        }
    
        return $empleado;
    }
 
    public function getSucursalByID($sucursalID){
        return db()->query("SELECT * FROM sucursal WHERE suc_SucursalID=?", array($sucursalID))->getRowArray();
    }
    
    public function getTotalEmpleadosBySucursal($sucursal){
        return $this->db->query("SELECT COUNT(emp_EmpleadoID) as 'empleados' FROM empleado WHERE emp_SucursalID=? AND emp_Estatus=1", array($sucursal))->getRowArray()['empleados'];
    }
}
