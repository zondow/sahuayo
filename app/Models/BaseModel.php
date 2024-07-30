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
        return $this->db->query("SELECT * FROM empleado WHERE emp_Estatus=1 ORDER BY emp_Nombre ASC")->getResultArray();
    }
}
