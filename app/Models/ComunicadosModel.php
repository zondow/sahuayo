<?php
namespace App\Models;

use CodeIgniter\Model;

class ComunicadosModel extends Model{
    function getComunicadosEnviados(){
        $sql = "SELECT COUNT(*) as 'total' FROM comunicado WHERE com_Estatus=1 AND com_Estado='Enviado'";
        return $this->db->query($sql)->getRowArray();
    }

    //diego empleados
    function getColaboradores(){
        $sql = "SELECT emp_EmpleadoID,emp_Nombre FROM empleado WHERE emp_Estatus=1";
        return $this->db->query($sql)->getResultArray();
    }

    //lia comunicados
    function getComunicados(){
        $sql = "SELECT * FROM comunicado WHERE com_Estatus=1";
        return $this->db->query($sql)->getResultArray();
    }

    function getComunicadosInbox(){
        $idEmpleado=session('id');
        $sql = "SELECT COUNT(*) as 'total' FROM noticomunicado
                JOIN comunicado ON com_ComunicadoID=not_ComunicadoID
                WHERE com_Estatus=1 AND com_Estado='Enviado'
                  AND not_Enterado=0 AND not_Visto=0 AND not_EmpleadoID=?";
        return $this->db->query($sql,array($idEmpleado))->getRowArray();
    }

    //lia comunicados
    function getComunicadosByEmpleado(){
        $empleado = '["'.session('id').'"]';
        //$sql = "SELECT * FROM comunicado WHERE JSON_CONTAINS(com_Empleados,'".$empleado."') AND com_Estatus=1  AND com_Estado='Enviado'";
        $sql = "SELECT * FROM comunicado
                JOIN noticomunicado ON com_ComunicadoID=not_ComunicadoID
                WHERE com_Estatus=1 AND com_Estado='Enviado' AND not_EmpleadoID=".session('id')." AND JSON_CONTAINS(com_Empleados,'".$empleado."')";
        return $this->db->query($sql)->getResultArray();
    }

    //Lia->trae los puestos
    public function getPuestos(){
        $result = $this->db->query("select * from puesto where  pue_Estatus=1 order by pue_Nombre ASC")->getResultArray();

        return $result;
    }//

    function getPoliticas(){
        $sql = "SELECT P.* FROM politica P";
        return $this->db->query($sql)->getResultArray();
    }

    public function getAlbums(){
        return $this->db->query("SELECT * FROM galeria WHERE gal_Estatus=1 ORDER BY gal_Fecha DESC")->getResultArray();
    }

    public function getVideosCapsulas($capsulaID){
        return $this->db->query("SELECT * FROM contenidocapsula WHERE con_CapsulaID=".encryptDecrypt('decrypt',$capsulaID)." ORDER BY con_NumOrden ASC")->getResultArray();
    }

    public function getCapsulas(){
        $result = $this->db->query("SELECT * FROM capsula ")->getResultArray();
        $data=array();
        foreach ($result as $r){
            $r['cap_CapsulaID']=encryptDecrypt('encrypt',$r['cap_CapsulaID']);
            array_push($data,$r);
        }
        return $data;
    }

    public function getInfoCapsulaByID($idCapsula){
        $sql = "SELECT * FROM capsula WHERE cap_CapsulaID=?";
        return $this->db->query($sql,array(encryptDecrypt('decrypt',$idCapsula)))->getRowArray();
    }

    public function getVistasContenidoCapsula($idContenido){
        return $this->db->query("SELECT C.*, E.emp_EmpleadoID,E.emp_Nombre,CO.con_Titulo FROM capsulavista C JOIN empleado E ON E.emp_EmpleadoID=C.cap_EmpleadoID JOIN contenidocapsula CO ON CO.con_ContenidoCapsulaID=C.cap_ContenidoCapsulaID WHERE C.cap_ContenidoCapsulaID=".$idContenido)->getResultArray();
    }

    public function getInfoCapsula($capsulaID){
        return $this->db->query("SELECT * FROM capsula WHERE cap_CapsulaID=".encryptDecrypt('decrypt',$capsulaID))->getRowArray();
    }
}