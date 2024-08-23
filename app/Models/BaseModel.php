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
        return $this->db->query("SELECT * FROM empleado WHERE emp_Estatus=1 AND emp_Estado='Activo' ORDER BY emp_Nombre ASC")->getResultArray();
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
        return $this->db->query("SELECT E.emp_EmpleadoID,E.emp_Nombre, E.emp_Correo FROM empleado E WHERE E.emp_Rol=1")->getResultArray();
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
    
}
