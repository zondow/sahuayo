<?php

namespace App\Models;

use CodeIgniter\Model;

class ConfiguracionModel extends Model
{
    //Diego->Trae los roles
    public function getRoles()
    {
        return $this->db->query("SELECT * FROM rol WHERE rol_Estatus=1")->getResultArray();
    } //getRoles

}