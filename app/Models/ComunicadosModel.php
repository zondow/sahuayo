<?php
namespace App\Models;

use CodeIgniter\Model;

class ComunicadosModel extends Model{

    function getComunicadosEnviados(){
        $sql = "SELECT COUNT(*) as 'total' FROM comunicado WHERE com_Estatus=1 AND com_Estado='Enviado'";
        return $this->db->query($sql)->getRowArray();
    }

    function getComunicadoByID($comunicadoID){
        return $this->db->query("SELECT * FROM comunicado WHERE com_ComunicadoID=?",$comunicadoID)->getRowArray();
    }

    function getEmpleadosByComunicadoID($comunicadoID){
        return $this->db->query("SELECT com_Empleados FROM comunicado WHERE com_ComunicadoID=?", array($comunicadoID))->getRowArray();
    }

    function getRegistroVistaNotificacion($empleadoID, $comunicadoID) {
        return $this->db->query("SELECT * FROM noticomunicado WHERE not_EmpleadoID=? AND not_ComunicadoID=?", array($empleadoID, $comunicadoID))->getRowArray();
    }

    function getComunicadoInfo($comunicadoID, $sin_mensaje = false){
        $comunicado = $this->db->query("SELECT * FROM comunicado WHERE com_ComunicadoID=?", array($comunicadoID))->getRowArray();
        if($sin_mensaje==true){
            unset($comunicado['com_Descripcion']);
        }
        return $comunicado;
    }

    function getComunicadosInbox()
    {
        $empleado = json_encode([session('id')]);
        $sql = "SELECT COUNT(*) as 'totalComunicados' 
                FROM comunicado 
                WHERE com_Estatus = 1 
                AND com_Estado = 'Enviado' 
                AND JSON_CONTAINS(com_Empleados, ?)";
        return $this->db->query($sql, [$empleado])->getRowArray()['totalComunicados'];
    }

    function getComunicadosInboxSinLeer()
    {
        $empleado = json_encode([session('id')]);
        $sql = "SELECT com_ComunicadoID FROM comunicado  WHERE com_Estatus = 1  AND com_Estado = 'Enviado'  AND JSON_CONTAINS(com_Empleados, ?)";
        $comunicados = $this->db->query($sql, [$empleado])->getResultArray();
        foreach($comunicados as $com){
            $sql = "SELECT COUNT(1) as 'totalSinLeer' FROM noticomunicado WHERE not_ComunicadoID =? AND not_EmpleadoID=? AND not_Visto = 0 AND not_Enterado = 0";
            $comunicadosSinLeer[] = $this->db->query($sql, [$com['com_ComunicadoID'],session('id')])->getRowArray()['totalSinLeer'];
        }
        //var_dump($comunicadosSinLeer);exit();
        return count($comunicadosSinLeer);
    }
    
    //lia comunicados
    function getComunicadosByEmpleado(){
        $empleado = json_encode([session('id')]);
        $comunicados = $this->db->query("SELECT * FROM comunicado WHERE com_Estatus=1 AND com_Estado='Enviado' AND JSON_CONTAINS(com_Empleados,?)",[$empleado])->getResultArray();
        foreach($comunicados as &$com){
            unset($com['com_Descripcion']);
            $visto = $this->db->query("SELECT * FROM noticomunicado WHERE not_EmpleadoID = ? AND not_ComunicadoID =?",[session('id'),$com['com_ComunicadoID']])->getRowArray();
            $com['not_Enterado'] = isset($visto) ? 1 : 0;
        }
        return $comunicados;
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