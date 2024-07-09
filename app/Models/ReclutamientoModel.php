<?php
namespace App\Models;

use CodeIgniter\Model;

class ReclutamientoModel extends Model{

    //Fer -> Obtiene el listado de solicitudes de personal para autorizar
    function getListSolicitudesPersonalTodos(){
            return $this->db->query("SELECT SP.*, EMP.emp_Nombre, PUE.pue_Nombre 
            FROM solicitudpersonal SP 
            JOIN empleado EMP ON SP.sol_EmpleadoID = EMP.emp_EmpleadoID 
            LEFT JOIN puesto PUE ON SP.sol_PuestoID = PUE.pue_PuestoID 
            WHERE 
                (sol_DirGeneralAutorizada != 'RECHAZADA' AND sol_DirGeneralAutorizada != 'AUTORIZADA')
                /*OR
                (SP.sol_EmpleadoID = ". session('id') .")*/
                ORDER BY 
                    SP.sol_Estatus DESC,
                    CASE SP.sol_DirGeneralAutorizada 
                        WHEN 'autorizada' THEN 1
                        WHEN 'pendiente' THEN 2
                        WHEN 'rechazada' THEN 3
                        ELSE 4
                    END,
                    SP.sol_Fecha DESC")->getResultArray();
    }//end getListSolicitudesPersonalTodos

    //Diego -> Obtiene todo el listado de solicitudes de personal para autorizar
    function getListSolicitudesPersonal(){
        return $this->db->query("SELECT SP.*, EMP.emp_Nombre, PUE.pue_Nombre 
        FROM solicitudpersonal SP 
        JOIN empleado EMP ON SP.sol_EmpleadoID = EMP.emp_EmpleadoID 
        LEFT JOIN puesto PUE ON SP.sol_PuestoID = PUE.pue_PuestoID 
        WHERE SP.sol_EmpleadoID = ". session("id") ."
        ORDER BY 
            SP.sol_Estatus DESC,
            CASE SP.sol_DirGeneralAutorizada 
                WHEN 'autorizada' THEN 1
                WHEN 'pendiente' THEN 2
                WHEN 'rechazada' THEN 3
                ELSE 4
            END,
            SP.sol_Fecha DESC")->getResultArray();
    }//end getListSolicitudesPersonal

    //Diego -> obtener info empleado
    function getEmpleadoInfoID(){
        return $this->db->query("SELECT * FROM empleado JOIN puesto ON pue_PuestoID=emp_PuestoID JOIN departamento ON dep_DepartamentoID=emp_DepartamentoID JOIN sucursal ON suc_SucursalID = emp_SucursalID WHERE emp_EmpleadoID=".session('id'))->getRowArray();
    }//end getEmpleadoInfoID

    //Diego -> obtener puestos
    function getPuestos(){
        return $this->db->query("SELECT * FROM puesto WHERE pue_Estatus=1 ORDER BY pue_Nombre ASC")->getResultArray();
    }//end getPuestos

    //Diego -> obtener direcciones
    function getDepartamentos(){
        return $this->db->query("SELECT * FROM departamento WHERE dep_Estatus=1 ORDER BY dep_Nombre ASC")->getResultArray();
    }//end getDirecciones

    //Diego-> obtener areas
    function getAreas(){
        return $this->db->query("SELECT * FROM area WHERE are_Estatus=1 ORDER BY are_Nombre ASC")->getResultArray();
    }//end getAreas

    //Diego -> obtener solicitudes eprsonal autorizadas
    function getListSolicitudesPersonalAutorizada(){
        return $this->db->query("SELECT * FROM solicitudpersonal JOIN empleado ON emp_EmpleadoID=sol_EmpleadoID LEFT JOIN puesto ON pue_PuestoID=sol_PuestoID WHERE sol_DirGeneralAutorizada='AUTORIZADA' ORDER BY sol_Estatus DESC, sol_Fecha DESC")->getResultArray();
    }

    //Diego-> obtener solicitud por id
    function getSolicitudByID($solicitudID){
        return $this->db->query("SELECT * 
        FROM solicitudpersonal 
        JOIN empleado ON emp_EmpleadoID=sol_EmpleadoID 
        LEFT JOIN puesto ON pue_PuestoID=sol_PuestoID 
        LEFT JOIN area ON are_AreaID=sol_AreaVacanteID 
        LEFT JOIN departamento ON dep_DepartamentoID=sol_DepartamentoVacanteID
        WHERE sol_SolicitudPersonalID=".encryptDecrypt('decrypt',$solicitudID)." 
        ORDER BY sol_SolicitudPersonalID DESC")->getRowArray();
    }

    //Diego -> obtener candidatos por solicitud
    public function getCandidatosBySolicitudID($solicitudID){
        return $this->db->query("SELECT * FROM candidato WHERE can_SolicitudPersonalID=".encryptDecrypt('decrypt',$solicitudID))->getResultArray();
    }

    public function getCandidatosCartera(){
        return $this->db->query("SELECT *, '' as 'can_Num' FROM candidato JOIN solicitudpersonal ON sol_SolicitudPersonalID=can_SolicitudPersonalID JOIN puesto ON pue_PuestoID=sol_PuestoID WHERE can_Estatus='CARTERA'")->getResultArray();
    }

    //Fer -> obtener solicitudes eprsonal autorizadas y en proceso
    function getListSolicitudesPersonalActivas(){
        return $this->db->query("SELECT * FROM solicitudpersonal JOIN empleado ON emp_EmpleadoID=sol_EmpleadoID LEFT JOIN puesto ON pue_PuestoID=sol_PuestoID WHERE sol_DirGeneralAutorizada='AUTORIZADA' AND sol_Estatus = 1 ORDER BY sol_Fecha DESC")->getResultArray();
    }
    
}