<?php

namespace App\Models;

use CodeIgniter\Model;

class FormacionModel extends Model
{
    
    

    //diego -> traer empleados
    public function getEmpleados()
    {
        return $this->db->query("SELECT * FROM empleado WHERE emp_Estatus=1 ORDER BY emp_Nombre ASC")->getResultArray();
    }//getEmpleados

   

    //Lia->trae las capacitaciones por empleado
    public function getCapacitacionesByEmpleadoID()
    {
        $idEmpleado = session('id');

        $sql = "SELECT C.* ,CA.*,CU.cur_Nombre
                FROM capacitacionempleado C
                         LEFT JOIN empleado E ON E.emp_EmpleadoID=C.cape_EmpleadoID
                        JOIN capacitacion CA ON CA.cap_CapacitacionID=C.cape_CapacitacionID
                        LEFT JOIN  curso CU ON CU.cur_CursoID=CA.cap_CursoID
                WHERE cape_EmpleadoID=? AND CA.cap_Estado != 'Registrada' ";
        return $this->db->query($sql, array($idEmpleado))->getResultArray();
    }//getCapacitacionesByEmpleadoID

    public function getCapacitacionesInstructor()
    {
        return $this->db->query("SELECT * FROM capacitacion 
                                LEFT JOIN curso ON cap_CursoID=cur_CursoID 
                                LEFT JOIN instructor ON ins_InstructorID=cap_InstructorID
                                WHERE ins_EmpleadoID=" . (int)session('id'))->getResultArray();
    }//getCapacitacionesInstructor

    //Diego -> traer capacitaciones
    public function getCapacitaciones(){
        return $this->db->query("SELECT * FROM capacitacion 
                                LEFT JOIN curso ON cap_CursoID=cur_CursoID")->getResultArray();
    }//getCapacitaciones

    //Diego -> traer proveedores
    public function getProveedores(){
        return $this->db->query("SELECT * FROM proveedor WHERE pro_Estatus=1")->getResultArray();
    }//getProveedores

    //Lia -> obtiene la informacion de una capacitacion
    public function getCapacitacionInfo($capacitacionID){
        $sql = "SELECT CAP.*, CUR.*
                FROM capacitacion CAP 
                LEFT JOIN curso CUR ON CUR.cur_CursoID=CAP.cap_CursoID
                WHERE CAP.cap_CapacitacionID=?";
        return $this->db->query($sql,array((int)$capacitacionID))->getRowArray();
    }//getCapacitacionInfo

    //Lia -> trae los registros de asistencia
    public function getAsistenciaCapacitacion($idCapacitacion){
        $fechas= $this->db->query("SELECT DISTINCT(asi_Fecha) FROM asistenciacapacitacion WHERE asi_CapacitacionID=".$idCapacitacion." ORDER BY asi_Fecha DESC")->getResultArray();
        return $fechas;
     }//getAsistenciaCapacitacion
     
     //Lia -> trae los resultados de encuesta de satisfaccion
     public function getResultadosEncuestaSatisfaccion($idCapacitacion){
        $sql = "SELECT *
                FROM encuestacapacitacion
                WHERE ent_CapacitacionID=?";
        $resultados =$this->db->query($sql, array($idCapacitacion))->getResultArray();
        $metodologia = 0;
        $totalMetodologia=0;

        $instructor = 0;
        $totalInstructor=0;

        $organizacion = 0;
        $totalOrganizacion =0;

        $satisfaccion = 0;
        $totalSatisfaccion=0;
        foreach ($resultados as $resultado){
            //Metodologia
            $metodologia += $this->switchValorEncuesta($resultado['ent_Metodologia1a']);
            $metodologia += $this->switchValorEncuesta($resultado['ent_Metodologia1b']);
            $metodologia += $this->switchValorEncuesta($resultado['ent_Metodologia1c']);
            $metodologia += $this->switchValorEncuesta($resultado['ent_Metodologia1d']);
            $metodologia += $this->switchValorEncuesta($resultado['ent_Metodologia1e']);
            $totalMetodologia += $metodologia / 5;

            //Instructor

            $instructor += $this->switchValorEncuesta($resultado['ent_Instructor1a']);
            $instructor += $this->switchValorEncuesta($resultado['ent_Instructor1b']);
            $instructor += $this->switchValorEncuesta($resultado['ent_Instructor1c']);
            $instructor += $this->switchValorEncuesta($resultado['ent_Instructor1d']);
            $instructor += $this->switchValorEncuesta($resultado['ent_Instructor1e']);
            $instructor += $this->switchValorEncuesta($resultado['ent_Instructor1f']);
            $totalInstructor += $instructor / 6;

            //Organizacion

            $organizacion += $this->switchValorEncuesta($resultado['ent_Organizacion1a']);
            $organizacion += $this->switchValorEncuesta($resultado['ent_Organizacion1b']);
            $totalOrganizacion += $organizacion / 2;

            //Satisfaccion

            $satisfaccion += $this->switchValorEncuesta($resultado['ent_Satisfaccion1a']);
            $satisfaccion += $this->switchValorEncuesta($resultado['ent_Satisfaccion1b']);
            $satisfaccion += $this->switchValorEncuesta($resultado['ent_Satisfaccion1c']);
            $totalSatisfaccion += $satisfaccion / 3;

        }

        if(count($resultados) !== 0){
            $porcentajeMet=(($totalMetodologia/count($resultados))*100)/5;
            $porcentajeIns=(($totalInstructor/count($resultados))*100)/5;
            $porcentajeOrg=(($totalOrganizacion/count($resultados))*100)/5;
            $porcentajeSat=(($totalSatisfaccion/count($resultados))*100)/5;
        }else{
            $porcentajeMet=0;
            $porcentajeIns=0;
            $porcentajeOrg=0;
            $porcentajeSat=0;
        }


        $data_total=array(
            'metodologia'=>number_format($porcentajeMet,0,'.',','),
            'instructor'=>number_format($porcentajeIns,0,'.',','),
            'organizacion'=>number_format($porcentajeOrg,0,'.',','),
            'satisfaccion'=>number_format($porcentajeSat,0,'.',','),
        );

        return $data_total;
    }//getResultadosEncuestaSatisfaccion

    //Lia -> Valor de la opcion seleccionada
    private function switchValorEncuesta($estatus){

        $value = 0;
        switch($estatus){
            case "Totalmente de acuerdo": $value = 5; break;
            case "De acuerdo": $value = 4; break;
            case "Indeciso": $value = 3; break;
            case "En desacuerdo": $value = 2; break;
            case "Totalmente en desacuerdo": $value = 1; break;
        }//switch
        return $value;
    }//switchValorEn

    //Lia->Obtiene la encuesta de capacitacion por empleado
    public function getEncuestaCapacitacion($idCapacitacion){
        $idEmpleado=session('id');
        $sql = "SELECT *
                FROM encuestacapacitacion
                WHERE ent_CapacitacionID=? AND ent_EmpleadoID= ?";
        return $this->db->query($sql, array($idCapacitacion,$idEmpleado))->getRowArray();
    }//getEncuestaCapacitacion

    //Lia->Trae los participantes de una capacitacion
    public function getParticipantesCapacitacion($capacitacionID,$fecha)
    {
        $sql = "SELECT E.emp_EmpleadoID, E.emp_Nombre, E.emp_Numero,E.emp_Correo, P.pue_Nombre,
                    C.cape_CapacitacionID,C.cape_CapacitacionEmpleadoID,S.suc_Sucursal
                FROM capacitacionempleado C 
                LEFT JOIN empleado E ON E.emp_EmpleadoID=C.cape_EmpleadoID 
                LEFT JOIN puesto P ON P.pue_PuestoID=E.emp_PuestoID
                LEFT JOIN sucursal S ON S.suc_SucursalID=E.emp_SucursalID
                WHERE E.emp_Estatus = 1 AND C.cape_CapacitacionID=?
                ORDER BY E.emp_Nombre  ASC ";
        $participantes= $this->db->query($sql, array($capacitacionID))->getResultArray();

        $count = 1;
        $builder = db()->table('asistenciacapacitacion');
        $dataAsistencia=array();
        $a=array();

        foreach ($participantes as $item) {

            if (!empty($item['emp_EmpleadoID'])) {

                $asistencia = $builder->getWhere(
                    array(
                        'asi_Fecha' => (string)$fecha,
                        "asi_CapacitacionID" => $capacitacionID,
                        "asi_EmpleadoID" => $item['emp_EmpleadoID']
                    )
                )->getRowArray();

                if ($asistencia) {

                    $a['no']=$count;
                    $a['nombre']=utf8_decode($item['emp_Nombre']);
                    $a['puesto']=utf8_decode($item['pue_Nombre']);
                    $a['correo']=utf8_decode($item['emp_Correo']);
                    $a['cooperativa']=utf8_decode($item['suc_Sucursal']);
                    $a['firma']='';
                    
                    $count++;

                    array_push($dataAsistencia,$a);
                }
            }
        }

        return $dataAsistencia;

    }

   
}//end FormacionModel
