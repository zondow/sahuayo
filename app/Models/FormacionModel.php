<?php

namespace App\Models;

use CodeIgniter\Model;

class FormacionModel extends Model
{

    //Diego -> traer capacitaciones
    public function getCapacitaciones()
    {
        return $this->db->query("SELECT * FROM capacitacion  LEFT JOIN curso ON cap_CursoID=cur_CursoID")->getResultArray();
    } //getCapacitaciones

    //Diego -> traer proveedores
    public function getProveedores()
    {
        return $this->db->query("SELECT * FROM proveedor WHERE pro_Estatus=1")->getResultArray();
    } //getProveedores

    //Lia->trae las capacitaciones por empleado
    public function getCapacitacionesByEmpleadoID()
    {
        $sql = "SELECT C.* ,CA.*,CU.cur_Nombre
                    FROM capacitacionempleado C
                        LEFT JOIN empleado E ON E.emp_EmpleadoID=C.cape_EmpleadoID
                    JOIN capacitacion CA ON CA.cap_CapacitacionID=C.cape_CapacitacionID
                    LEFT JOIN  curso CU ON CU.cur_CursoID=CA.cap_CursoID
                    WHERE cape_EmpleadoID=? AND CA.cap_Estado != 'Registrada' ";
        return $this->db->query($sql, array(session('id')))->getResultArray();
    } //getCapacitacionesByEmpleadoID

    public function getCapacitacionByID($capacitacionID)
    {
        return $this->db->query("SELECT * FROM capacitacion WHERE cap_CapacitacionID=?", [$capacitacionID])->getRowArray();
    }

    //Lia -> obtiene la informacion de una capacitacion
    public function getCapacitacionInfo($capacitacionID)
    {
        return $this->db->query("SELECT CAP.*, CUR.*
                FROM capacitacion CAP 
                LEFT JOIN curso CUR ON CUR.cur_CursoID=CAP.cap_CursoID
                WHERE CAP.cap_CapacitacionID=?", array((int)$capacitacionID))->getRowArray();
    } //getCapacitacionInfo

    //Lia -> trae los registros de asistencia
    public function getAsistenciaCapacitacion($idCapacitacion)
    {
        return $this->db->query("SELECT DISTINCT(asi_Fecha) FROM asistenciacapacitacion WHERE asi_CapacitacionID=$idCapacitacion ORDER BY asi_Fecha DESC")->getResultArray();
    } //getAsistenciaCapacitacion

    //Lia -> trae los resultados de encuesta de satisfaccion
    public function getResultadosEncuestaSatisfaccion($idCapacitacion)
    {
        $sql = "SELECT * FROM encuestacapacitacion WHERE ent_CapacitacionID = ?";
        $resultados = $this->db->query($sql, array($idCapacitacion))->getResultArray();

        $categorias = [
            'metodologia' => ['ent_Metodologia1a', 'ent_Metodologia1b', 'ent_Metodologia1c', 'ent_Metodologia1d', 'ent_Metodologia1e'],
            'instructor' => ['ent_Instructor1a', 'ent_Instructor1b', 'ent_Instructor1c', 'ent_Instructor1d', 'ent_Instructor1e', 'ent_Instructor1f'],
            'organizacion' => ['ent_Organizacion1a', 'ent_Organizacion1b'],
            'satisfaccion' => ['ent_Satisfaccion1a', 'ent_Satisfaccion1b', 'ent_Satisfaccion1c']
        ];

        $totales = array_fill_keys(array_keys($categorias), 0);

        foreach ($resultados as $resultado) {
            foreach ($categorias as $categoria => $preguntas) {
                $totalCategoria = 0;
                foreach ($preguntas as $pregunta) {
                    $totalCategoria += $this->switchValorEncuesta($resultado[$pregunta]);
                }
                $totales[$categoria] += $totalCategoria / count($preguntas);
            }
        }

        $numResultados = count($resultados);
        $data_total = [];

        foreach ($totales as $categoria => $total) {
            $promedio = $numResultados ? (($total / $numResultados) * 100) / 5 : 0;
            $data_total[$categoria] = number_format($promedio, 0, '.', ',');
        }

        return $data_total;
    }

    //Lia -> Valor de la opcion seleccionada
    private function switchValorEncuesta($estatus)
    {
        $valores = [
            "Totalmente de acuerdo" => 5,
            "De acuerdo" => 4,
            "Indeciso" => 3,
            "En desacuerdo" => 2,
            "Totalmente en desacuerdo" => 1
        ];
        return $valores[$estatus] ?? 0;
    }

    public function getParticipanteCapacitacionEmpleado($participanteID){
        $sql = "SELECT C.* FROM capacitacionempleado C  WHERE C.cape_CapacitacionEmpleadoID=? ";
        return $this->db->query($sql, array($participanteID))->getRowArray();
    }

    public function getAsistenciaCapacitacionByFecha($capacitacionID,$fecha){
        $builder2 = db()->table("asistenciacapacitacion");
        return $builder2->getWhere(array('asi_Fecha' => $fecha, "asi_CapacitacionID" => $capacitacionID))->getResultArray();
    }

    public function getParticipantesByCapacitacionID($idCapacitacion){
        return $this->db->query("SELECT * FROM capacitacionempleado WHERE cape_CapacitacionID=" . (int)$idCapacitacion)->getResultArray();
    }

    public function getCapacitacionesInstructor()
    {
        return $this->db->query("SELECT * FROM capacitacion 
                                LEFT JOIN curso ON cap_CursoID=cur_CursoID 
                                LEFT JOIN instructor ON ins_InstructorID=cap_InstructorID
                                WHERE ins_EmpleadoID=" . (int)session('id'))->getResultArray();
    } //getCapacitacionesInstructor







































































































    //diego -> traer empleados
    public function getEmpleados()
    {
        return $this->db->query("SELECT * FROM empleado WHERE emp_Estatus=1 ORDER BY emp_Nombre ASC")->getResultArray();
    } //getEmpleados












    //Lia->Obtiene la encuesta de capacitacion por empleado
    public function getEncuestaCapacitacion($idCapacitacion)
    {
        $idEmpleado = session('id');
        $sql = "SELECT *
                FROM encuestacapacitacion
                WHERE ent_CapacitacionID=? AND ent_EmpleadoID= ?";
        return $this->db->query($sql, array($idCapacitacion, $idEmpleado))->getRowArray();
    } //getEncuestaCapacitacion

    //Lia->Trae los participantes de una capacitacion
    public function getParticipantesCapacitacion($capacitacionID, $fecha)
    {
        $sql = "SELECT E.emp_EmpleadoID, E.emp_Nombre, E.emp_Numero,E.emp_Correo, P.pue_Nombre,
                    C.cape_CapacitacionID,C.cape_CapacitacionEmpleadoID,S.suc_Sucursal
                FROM capacitacionempleado C 
                LEFT JOIN empleado E ON E.emp_EmpleadoID=C.cape_EmpleadoID 
                LEFT JOIN puesto P ON P.pue_PuestoID=E.emp_PuestoID
                LEFT JOIN sucursal S ON S.suc_SucursalID=E.emp_SucursalID
                WHERE E.emp_Estatus = 1 AND C.cape_CapacitacionID=?
                ORDER BY E.emp_Nombre  ASC ";
        $participantes = $this->db->query($sql, array($capacitacionID))->getResultArray();

        $count = 1;
        $builder = db()->table('asistenciacapacitacion');
        $dataAsistencia = array();
        $a = array();

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

                    $a['no'] = $count;
                    $a['nombre'] = utf8_decode($item['emp_Nombre']);
                    $a['puesto'] = utf8_decode($item['pue_Nombre']);
                    $a['correo'] = utf8_decode($item['emp_Correo']);
                    $a['cooperativa'] = utf8_decode($item['suc_Sucursal']);
                    $a['firma'] = '';

                    $count++;

                    array_push($dataAsistencia, $a);
                }
            }
        }

        return $dataAsistencia;
    }
}//end FormacionModel
