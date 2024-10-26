<?php

namespace App\Models;

use CodeIgniter\Model;

class EvaluacionesModel extends Model
{

    //Lia->Trae los periodos de evaluacion
    public function getPeriodosEvaluacion()
    {
        return $this->db->query("SELECT E.* FROM evaluacion E ORDER BY eva_FechaInicio DESC")->getResultArray();
    }

    public function getEvaluacionExistente($tipo, $fechaInicio, $fechaFin)
    {
        $sql = "SELECT count(eva_EvaluacionID) as 'evaluacion'
                from evaluacion
                WHERE eva_Tipo = ? AND
                (( ? >= eva_FechaInicio AND ? < eva_FechaFin) OR
                (? > eva_FechaInicio AND ? <= eva_FechaFin) OR
                (? <= eva_FechaInicio AND ? >= eva_FechaFin)) AND eva_Estatus = 1";
        return $this->db->query($sql, array($tipo, $fechaInicio, $fechaInicio, $fechaFin, $fechaFin, $fechaInicio, $fechaFin))->getRowArray();
    }

    //Lia -> Trae la fecha de la evaluacinde clima laboral
    public function getFechaEvaluacionClimaLaboral()
    {
        $sql = "SELECT *
                FROM evaluacion
                WHERE eva_Tipo='Clima Laboral' AND eva_Estatus= 1 AND
                  CURDATE() BETWEEN eva_FechaInicio AND eva_FechaFin ORDER BY eva_EvaluacionID DESC LIMIT 1";
        $fechas = $this->db->query($sql)->getRowArray();
        return $fechas;
    }

    //Lia->Trae la evaluacion de clima realizada
    public function evaluacionClimaLaboralRealizada($empleadoID)
    {
        $fecha = $this->db->query("
            SELECT *
            FROM evaluacion
            WHERE eva_Tipo='Clima Laboral' 
            AND eva_Estatus = 1 
            AND CURDATE() BETWEEN eva_FechaInicio AND eva_FechaFin
            ORDER BY eva_FechaRegistro DESC
        ")->getRowArray();
        if ($fecha ==  null) {
            return false;
        } else {
            return $this->db->query("
            SELECT *
            FROM evaluacionclimalaboral
            WHERE eva_EmpleadoID = ? 
            AND eva_FechaEvaluacionClimaLaboral BETWEEN ? AND ?
            ORDER BY eva_EvaluacionClimaLaboralID DESC
        ", [$empleadoID, $fecha['eva_FechaInicio'], $fecha['eva_FechaFin']])->getRowArray();
        }
    }

    //Lia-> Obtiene la suma de los rubros para el Clima Laboral
    public function getAllCalificacionForClimaLaboral($fechaI, $fechaF, $sucursal)
    {
        $sucursalID = ($sucursal != '0') ? ' AND E.emp_SucursalID=' . encryptDecrypt('decrypt', $sucursal) : '';

        $join = ($sucursal != '0') ? ' JOIN empleado E ON E.emp_EmpleadoID=eva_EmpleadoID ' : '';

        $query = "SELECT
            SUM(eva_AmFi1 + eva_AmFi2 + eva_AmFi3 + eva_AmFi4) AS 'ambiente',
            SUM(eva_FoCa1 + eva_FoCa2 + eva_FoCa3 + eva_FoCa4 + eva_FoCa5 + eva_FoCa6 + eva_FoCa7) AS 'formacion',
            SUM(eva_Lid1 + eva_Lid2 + eva_Lid3 + eva_Lid4 + eva_Lid5 + eva_Lid6 + eva_Lid7 + eva_Lid8 + eva_Lid9 + eva_Lid10 + eva_Lid11) AS 'liderazgo',
            SUM(eva_ReTra1 + eva_ReTra2 + eva_ReTra3 + eva_ReTra4 + eva_ReTra5 + eva_ReTra6 + eva_ReTra7 + eva_ReTra8 + eva_ReTra9 + eva_ReTra10) AS 'relaciones',
            SUM(eva_SenPer1 + eva_SenPer2 + eva_SenPer3 + eva_SenPer4 + eva_SenPer5 + eva_SenPer6 + eva_SenPer7) AS 'pertenencia',
            SUM(eva_SatLab1 + eva_SatLab2 + eva_SatLab3 + eva_SatLab4 + eva_SatLab5 + eva_SatLab6 + eva_SatLab7 + eva_SatLab8 + eva_SatLab9) AS 'laboral',
            SUM(eva_Com1 + eva_Com2 + eva_Com3 + eva_Com4 + eva_Com5 + eva_Com6 + eva_Com7 + eva_Com8) AS 'comunicacion'
        FROM evaluacionclimalaboral CLI $join 
        WHERE eva_FechaEvaluacionClimaLaboral BETWEEN '$fechaI' AND '$fechaF' $sucursalID";

        $resultprevio = $this->db->query($query)->getRowArray();

        $empleadosRealizaron = $this->db->query("SELECT COUNT(eva_EmpleadoID) as 'empleados' FROM evaluacionclimalaboral CLI $join WHERE eva_FechaEvaluacionClimaLaboral BETWEEN '$fechaI' AND '$fechaF' $sucursalID")->getRowArray()['empleados'];

        $calificaciones = [
            'ambiente' => 4 * 5,
            'formacion' => 7 * 5,
            'liderazgo' => 11 * 5,
            'relaciones' => 10 * 5,
            'pertenencia' => 7 * 5,
            'laboral' => 8 * 5,
            'comunicacion' => 8 * 5
        ];

        $data = [];
        foreach ($calificaciones as $key => $total) {
            $data[$key] = ($empleadosRealizaron > 0) ? number_format(($resultprevio[$key] * 100) / ($empleadosRealizaron * $total), 2, '.', ',') : 0;
        }

        return $data;
    }

    //Diego -> Busca si la evaluacion nom 035
    public function evaluacionNom035Realizada($empleadoID)
    {
        $fecha = $this->db->query("SELECT * FROM evaluacion WHERE eva_Tipo='Nom035' AND eva_Estatus=1 AND CURDATE() BETWEEN eva_FechaInicio AND eva_FechaFin ORDER BY eva_FechaRegistro DESC")->getRowArray();
        if ($fecha) {
            return $this->db->query("SELECT * FROM evaluaciong1 WHERE eva_EvaluadoID=? AND (eva_Fecha BETWEEN ? AND ? ) ORDER BY eva_AcontecimientosTSID DESC", array($empleadoID, $fecha['eva_FechaInicio'], $fecha['eva_FechaFin']))->getRowArray() ? TRUE : FALSE;
        }
        return false;
    } //end evaluacionNom035Realizada

    public function getFechaEvaluacionByTipo($tipo)
    {
        return $this->db->query("SELECT * FROM evaluacion WHERE eva_Tipo=? AND eva_Estatus=1 AND CURDATE() BETWEEN eva_FechaInicio AND eva_FechaFin ORDER BY eva_FechaRegistro DESC", [$tipo])->getRowArray();
    }

    public function getEvaluacionRealizadaGuia2($evaluado, $fechaInicio, $fechaFin)
    {
        return $this->db->query("SELECT * FROM evaluaciong2  WHERE eva_EvaluadoID=? AND (eva_Fecha BETWEEN ? AND ? ) ORDER BY eva_EvaluacionG2 DESC", array($evaluado, $fechaInicio, $fechaFin))->getRowArray();
    }

    public function getEvaluacionRealizadaGuia3($evaluado, $fechaInicio, $fechaFin)
    {
        return $this->db->query("SELECT * FROM evaluaciong3  WHERE eva_EvaluadoID=? AND (eva_Fecha BETWEEN ? AND ? ) ORDER BY eva_EvaluacionG3 DESC", array($evaluado, $fechaInicio, $fechaFin))->getRowArray();
    }

    function getEvaluacionesGuia1($fInicio, $fFin, $sucursal)
    {
        $where = $sucursal > 0 ? "E.emp_SucursalID = $sucursal AND " : '';
        $sql = "SELECT * FROM evaluaciong1 EG1
            LEFT JOIN empleado E ON E.emp_EmpleadoID = EG1.eva_EvaluadoID
            WHERE $where EG1.eva_Fecha BETWEEN ? AND ?";

        return $this->db->query($sql, [$fInicio, $fFin])->getResultArray();
    }

    /*public function getCF($fInicio, $fFin, $sucursal)
    {
        $sucursal = encryptDecrypt('decrypt', $sucursal);
        $where = '';
        if ($sucursal > 0) {
            $where = "emp_SucursalID=" . $sucursal . " AND ";
        }
        $evaluados = $this->db->query("SELECT * FROM empleado WHERE $where emp_Estatus=1")->getResultArray();
        $suma = 0;
        $totalEvaluados = 0;
        foreach ($evaluados as $evaluado) {
            $calificacionEvaluado = $this->db->query("SELECT SUM(eva_P1+eva_P2+eva_P3+eva_P4+eva_P5+eva_P6+eva_P7+eva_P8+eva_P9+eva_P10+eva_P11+eva_P12+eva_P13+eva_P14+eva_P15+eva_P16+eva_P17+eva_P18+eva_P19+eva_P20+eva_P21+eva_P22+eva_P23+eva_P24+eva_P25+eva_P26+eva_P27+eva_P28+eva_P29+eva_P30+eva_P31+eva_P32+eva_P33+eva_P34+eva_P35+eva_P36+eva_P37+eva_P38+eva_P39+eva_P40+eva_P41+eva_P42+eva_P43+eva_P44+eva_P45+eva_P46) as 'calificacionT' FROM evaluaciong2 WHERE eva_Fecha BETWEEN '" . $fInicio . "' AND '" . $fFin . "' AND eva_EvaluadoID=" . $evaluado['emp_EmpleadoID'])->getRowArray();
            if ($calificacionEvaluado['calificacionT'] !== null) {
                $totalEvaluados += 1;
                $suma += $calificacionEvaluado['calificacionT'];
            }
        }
        if ((int)$suma > 0 && $totalEvaluados > 0) return (int)$suma / $totalEvaluados;
        else return 0;
    }*/
    public function getCF($fInicio, $fFin, $sucursal)
    {
        $sucursal = encryptDecrypt('decrypt', $sucursal);
        $where = $sucursal > 0 ? "emp_SucursalID=$sucursal AND " : '';

        $evaluados = $this->db->query("SELECT emp_EmpleadoID FROM empleado WHERE $where emp_Estatus=1")->getResultArray();

        $suma = $totalEvaluados = 0;

        foreach ($evaluados as $evaluado) {
            $calificacionEvaluado = $this->db->query(
                "
                SELECT SUM(
                    eva_P1+eva_P2+eva_P3+eva_P4+eva_P5+eva_P6+eva_P7+eva_P8+eva_P9+eva_P10+
                    eva_P11+eva_P12+eva_P13+eva_P14+eva_P15+eva_P16+eva_P17+eva_P18+eva_P19+eva_P20+
                    eva_P21+eva_P22+eva_P23+eva_P24+eva_P25+eva_P26+eva_P27+eva_P28+eva_P29+eva_P30+
                    eva_P31+eva_P32+eva_P33+eva_P34+eva_P35+eva_P36+eva_P37+eva_P38+eva_P39+eva_P40+
                    eva_P41+eva_P42+eva_P43+eva_P44+eva_P45+eva_P46
                ) AS calificacionT 
                FROM evaluaciong2 
                WHERE eva_Fecha BETWEEN ? AND ? AND eva_EvaluadoID = ?",
                [$fInicio, $fFin, $evaluado['emp_EmpleadoID']]
            )->getRowArray();

            if (!empty($calificacionEvaluado['calificacionT'])) {
                $suma += $calificacionEvaluado['calificacionT'];
                $totalEvaluados++;
            }
        }

        return $totalEvaluados > 0 ? (int)$suma / $totalEvaluados : 0;
    }

    /*public function getDominios($fInicio, $fFin, $sucursal)
    {
        $sucursal = encryptDecrypt('decrypt', $sucursal);
        $where = '';
        if ($sucursal > 0) {
            $where = "emp_SucursalID=" . $sucursal . " AND ";
        }
        $sql = "SELECT
                AVG(eva_P2+eva_P1+eva_P3) AS 'ambienteTrabajo',
                AVG(eva_P4+eva_P9+eva_P5+eva_P6+eva_P7+eva_P8+eva_P41+eva_P42+eva_P43+eva_P10+eva_P11+eva_P12+eva_P13) AS 'cargaTrabajo',
                AVG(eva_P20+eva_P21+eva_P22+eva_P18+eva_P19+eva_P26+eva_P27) AS 'faltaControl',
                AVG(eva_P14+eva_P15) AS 'jornadaTrabajo',
                AVG(eva_P16+eva_P17) AS 'interferencia',
                AVG(eva_P23+eva_P24+eva_P25+eva_P28+eva_P29) AS 'liderazgo',
                AVG(eva_P44+eva_P45+eva_P46+eva_P30+eva_P31+eva_P32) AS 'relacionTrabajo',
                AVG(eva_P33+eva_P34+eva_P35+eva_P36+eva_P37+eva_P38+eva_P39+eva_P40) AS 'violencia'
            FROM evaluaciong2
            JOIN empleado ON emp_EmpleadoID = eva_EvaluadoID
            WHERE $where eva_Fecha BETWEEN ? AND ?";

        $query = $this->db->query($sql, [$fInicio, $fFin])->getRowArray();
        if ($query) {
            $data = array_map('intval', $query);
        } else {
            $data = [
                "ambienteTrabajo" => 0,
                "cargaTrabajo" => 0,
                "faltaControl" => 0,
                "jornadaTrabajo" => 0,
                "interferencia" => 0,
                "liderazgo" => 0,
                "relacionTrabajo" => 0,
                "violencia" => 0,
            ];
        }

        return $data;
    }*/

    public function getDominios($fInicio, $fFin, $sucursal)
    {
        $sucursal = encryptDecrypt('decrypt', $sucursal);
        $where = $sucursal > 0 ? "emp_SucursalID = $sucursal AND " : '';

        $sql = "SELECT
                    AVG(eva_P2+eva_P1+eva_P3) AS 'ambienteTrabajo',
                    AVG(eva_P4+eva_P9+eva_P5+eva_P6+eva_P7+eva_P8+eva_P41+eva_P42+eva_P43+eva_P10+eva_P11+eva_P12+eva_P13) AS 'cargaTrabajo',
                    AVG(eva_P20+eva_P21+eva_P22+eva_P18+eva_P19+eva_P26+eva_P27) AS 'faltaControl',
                    AVG(eva_P14+eva_P15) AS 'jornadaTrabajo',
                    AVG(eva_P16+eva_P17) AS 'interferencia',
                    AVG(eva_P23+eva_P24+eva_P25+eva_P28+eva_P29) AS 'liderazgo',
                    AVG(eva_P44+eva_P45+eva_P46+eva_P30+eva_P31+eva_P32) AS 'relacionTrabajo',
                    AVG(eva_P33+eva_P34+eva_P35+eva_P36+eva_P37+eva_P38+eva_P39+eva_P40) AS 'violencia'
                FROM evaluaciong2
                JOIN empleado ON emp_EmpleadoID = eva_EvaluadoID
                WHERE $where eva_Fecha BETWEEN ? AND ?";

        $query = $this->db->query($sql, [$fInicio, $fFin])->getRowArray();

        return $query ? array_map('intval', $query) : array_fill_keys(
            ["ambienteTrabajo", "cargaTrabajo", "faltaControl", "jornadaTrabajo", "interferencia", "liderazgo", "relacionTrabajo", "violencia"],
            0
        );
    }

    public function getEvaluados($fInicio, $fFin, $sucursal)
    {
        $where = $sucursal > 0 ? "emp_SucursalID=$sucursal AND " : '';
        $data = $this->db->query("
            SELECT emp_Nombre, emp_EmpleadoID 
            FROM evaluaciong2 
            LEFT JOIN empleado ON emp_EmpleadoID = eva_EvaluadoID 
            WHERE $where eva_Fecha BETWEEN '$fInicio' AND '$fFin' AND emp_Estatus = 1
        ")->getResultArray();

        return array_map(function ($d) {
            $d['id'] = encryptDecrypt('encrypt', $d['emp_EmpleadoID']);
            return $d;
        }, $data);
    }

    /*public function getDominiosBajoRiesgo($fInicio, $fFin, $sucursal)
    {
        $where = '';
        if ($sucursal > 0) $where = " emp_SucursalID=" . $sucursal . " AND ";
        $sql = "SELECT
                    SUM(eva_P2+eva_P1+eva_P3) as 'ambienteTrabajo',
                    SUM(eva_P4+eva_P9+eva_P5+eva_P6+eva_P7+eva_P8+eva_P41+eva_P42+eva_P43+eva_P10+eva_P11+eva_P12+eva_P13) as 'cargaTrabajo',
                    SUM(eva_P20+eva_P21+eva_P22+eva_P18+eva_P19+eva_P26+eva_P27) as 'faltaControl',
                    SUM(eva_P14+eva_P15) as 'jornadaTrabajo',
                    SUM(eva_P16+eva_P17) as 'interferencia',
                    SUM(eva_P23+eva_P24+eva_P25+eva_P28+eva_P29) as 'liderazgo',
                    SUM(eva_P44+eva_P45+eva_P46+eva_P30+eva_P31+eva_P32) as 'relacionTrabajo',
                    SUM(eva_P33+eva_P34+eva_P35+eva_P36+eva_P37+eva_P38+eva_P39+eva_P40) as 'violencia',
                    eva_EvaluadoID
                FROM evaluaciong2
                JOIN empleado ON emp_EmpleadoID=eva_EvaluadoID
                WHERE $where eva_Fecha BETWEEN ? AND ?
                GROUP BY eva_EvaluadoID";

        $query = $this->db->query($sql, [$fInicio, $fFin])->getResultArray();

        $data = [
            'bajo' => array_fill(0, 8, 0),
            'medio' => array_fill(0, 8, 0),
            'alto' => array_fill(0, 8, 0),
        ];

        foreach ($query as $calificacionEvaluado) {
            $dominios = [
                'ambienteTrabajo', 'cargaTrabajo', 'faltaControl', 'jornadaTrabajo',
                'interferencia', 'liderazgo', 'relacionTrabajo', 'violencia'
            ];

            foreach ($dominios as $index => $dominio) {
                $valor = (int)$calificacionEvaluado[$dominio];
                if ($valor !== null) {
                    if ($valor < 5) $data['bajo'][$index]++;
                    elseif ($valor < 7) $data['medio'][$index]++;
                    else $data['alto'][$index]++;
                }
            }
        }

        return $data;
    }*/
    public function getDominiosBajoRiesgo($fInicio, $fFin, $sucursal)
    {
        $where = $sucursal > 0 ? "emp_SucursalID=$sucursal AND " : '';
        $sql = "
        SELECT
            SUM(eva_P2+eva_P1+eva_P3) as ambienteTrabajo,
            SUM(eva_P4+eva_P9+eva_P5+eva_P6+eva_P7+eva_P8+eva_P41+eva_P42+eva_P43+eva_P10+eva_P11+eva_P12+eva_P13) as cargaTrabajo,
            SUM(eva_P20+eva_P21+eva_P22+eva_P18+eva_P19+eva_P26+eva_P27) as faltaControl,
            SUM(eva_P14+eva_P15) as jornadaTrabajo,
            SUM(eva_P16+eva_P17) as interferencia,
            SUM(eva_P23+eva_P24+eva_P25+eva_P28+eva_P29) as liderazgo,
            SUM(eva_P44+eva_P45+eva_P46+eva_P30+eva_P31+eva_P32) as relacionTrabajo,
            SUM(eva_P33+eva_P34+eva_P35+eva_P36+eva_P37+eva_P38+eva_P39+eva_P40) as violencia,
            eva_EvaluadoID
        FROM evaluaciong2
        JOIN empleado ON emp_EmpleadoID = eva_EvaluadoID
        WHERE $where eva_Fecha BETWEEN ? AND ?
        GROUP BY eva_EvaluadoID
    ";

        $query = $this->db->query($sql, [$fInicio, $fFin])->getResultArray();

        $dominios = ['ambienteTrabajo', 'cargaTrabajo', 'faltaControl', 'jornadaTrabajo', 'interferencia', 'liderazgo', 'relacionTrabajo', 'violencia'];
        $data = array_fill_keys(['bajo', 'medio', 'alto'], array_fill(0, count($dominios), 0));

        foreach ($query as $row) {
            foreach ($dominios as $index => $dominio) {
                $valor = (int)$row[$dominio];
                if ($valor !== null) {
                    $data[$valor < 5 ? 'bajo' : ($valor < 7 ? 'medio' : 'alto')][$index]++;
                }
            }
        }

        return $data;
    }

    public function getDominiosByEvaluado($evaluadoID, $fInicio, $fFin)
    {
        $sql = "SELECT
                    SUM(eva_P2+eva_P1+eva_P3) as 'ambienteTrabajo',
                    SUM(eva_P4+eva_P9+eva_P5+eva_P6+eva_P7+eva_P8+eva_P41+eva_P42+eva_P43+eva_P10+eva_P11+eva_P12+eva_P13) as 'cargaTrabajo',
                    SUM(eva_P20+eva_P21+eva_P22+eva_P18+eva_P19+eva_P26+eva_P27) as 'faltaControl',
                    SUM(eva_P14+eva_P15) as 'jornadaTrabajo',
                    SUM(eva_P16+eva_P17) as 'interferencia',
                    SUM(eva_P23+eva_P24+eva_P25+eva_P28+eva_P29) as 'liderazgo',
                    SUM(eva_P44+eva_P45+eva_P46+eva_P30+eva_P31+eva_P32) as 'relacionTrabajo',
                    SUM(eva_P33+eva_P34+eva_P35+eva_P36+eva_P37+eva_P38+eva_P39+eva_P40) as 'violencia'
                FROM evaluaciong2
                WHERE eva_Fecha BETWEEN ? AND ? AND eva_EvaluadoID = ?";

        return $this->db->query($sql, [$fInicio, $fFin, $evaluadoID])->getRowArray();
    }


    public function getPlantillas($tipo){
        $sql = "SELECT * FROM plantillacuestionario WHERE pla_Tipo =?";
        $data = $this->db->query($sql, [$tipo])->getResultArray();

        return array_map(function ($d) {
            $d['pla_PlantillaID'] = encryptDecrypt('encrypt', $d['pla_PlantillaID']);
            return $d;
        }, $data);
    }

    public function getInfoPlantillaByID($plantillaID){
        return $this->db->query("SELECT * FROM plantillacuestionario WHERE pla_PlantillaID= ?", array($plantillaID))->getRowArray();
    }























































































































































    public function getCFG3($fInicio, $fFin, $sucursal)
    {
        $sucursal = encryptDecrypt('decrypt', $sucursal);
        $where = '';
        if ($sucursal > 0) $where = "WHERE emp_SucursalID=" . $sucursal;
        $evaluados = $this->db->query("SELECT * FROM empleado $where")->getResultArray();
        $suma = 0;
        $totalEvaluados = 0;
        foreach ($evaluados as $evaluado) {
            $calificacionEvaluado = $this->db->query("SELECT SUM(eva_P1+eva_P2+eva_P3+eva_P4+eva_P5+eva_P6+eva_P7+eva_P8+eva_P9+eva_P10+eva_P11+eva_P12+eva_P13+eva_P14+eva_P15+eva_P16+eva_P17+eva_P18+eva_P19+eva_P20+eva_P21+eva_P22+eva_P23+eva_P24+eva_P25+eva_P26+eva_P27+eva_P28+eva_P29+eva_P30+eva_P31+eva_P32+eva_P33+eva_P34+eva_P35+eva_P36+eva_P37+eva_P38+eva_P39+eva_P40+eva_P41+eva_P42+eva_P43+eva_P44+eva_P45+eva_P46+eva_P47+eva_P48+eva_P49+eva_P50+eva_P51+eva_P52+eva_P53+eva_P54+eva_P55+eva_P56+eva_P57+eva_P58+eva_P59+eva_P60+eva_P61+eva_P62+eva_P63+eva_P64+eva_P65+eva_P66+eva_P67+eva_P68+eva_P69+eva_P70+eva_P71+eva_P72) as 'calificacionT' FROM evaluaciong3 WHERE eva_Fecha BETWEEN '" . $fInicio . "' AND '" . $fFin . "' AND eva_EvaluadoID=" . $evaluado['emp_EmpleadoID'])->getRowArray();
            if ($calificacionEvaluado['calificacionT'] !== null) {
                $totalEvaluados += 1;
                $suma += $calificacionEvaluado['calificacionT'];
            }
        }
        return ($suma > 0 && $totalEvaluados > 0) ? $suma / $totalEvaluados : 0;
    }

    public function getDominiosG3($fInicio, $fFin, $sucursal)
    {
        $sucursal = encryptDecrypt('decrypt', $sucursal);
        $where = '';
        if ($sucursal > 0) $where = "WHERE emp_SucursalID=" . $sucursal;
        $evaluados = $this->db->query("SELECT emp_EmpleadoID FROM empleado $where")->getResultArray();
        $i = 0;
        $ambienteT = 0;
        $cargaT = 0;
        $faltaC = 0;
        $jornadaT = 0;
        $interferencia = 0;
        $liderazgo = 0;
        $relacionT = 0;
        $violencia = 0;
        $reconocimiento = 0;
        $insuficiente = 0;
        foreach ($evaluados as $evaluado) {
            $dominio = $this->db->query("SELECT
            SUM(eva_P1+eva_P3+eva_P2+eva_P4+eva_P5) as 'ambienteTrabajo',
            SUM(eva_P6+eva_P12+eva_P7+eva_P8+eva_P9+eva_P10+eva_P11+eva_P65+eva_P66+eva_P67+eva_P68+eva_P13+eva_P14+eva_P15+eva_P16) as 'cargaT',
            SUM(eva_P25+eva_P26+eva_P27+eva_P28+eva_P29+eva_P30+eva_P23+eva_P24+eva_P35+eva_P36) as 'faltaC',
            SUM(eva_P17+eva_P18) as 'jornadaT',
            SUM(eva_P19+eva_P20+eva_P21+eva_P22) as 'interferencia',
            SUM(eva_P31+eva_P32+eva_P33+eva_P34+eva_P37+eva_P38+eva_P39+eva_P40+eva_P41) as 'liderazgo',
            SUM(eva_P42+eva_P43+eva_P44+eva_P45+eva_P46+eva_P69+eva_P70+eva_P71+eva_P72) as 'relacionT',
            SUM(eva_P57+eva_P58+eva_P59+eva_P60+eva_P61+eva_P62+eva_P63+eva_P64) as 'violencia',
            SUM(eva_P47+eva_P48+eva_P49+eva_P50+eva_P51+eva_P52) as 'reconocimiento',
            SUM(eva_P55+eva_P56+eva_P53+eva_P54) as 'insuficiente'
            FROM evaluaciong3 WHERE eva_Fecha BETWEEN '" . $fInicio . "' AND '" . $fFin . "' AND eva_EvaluadoID=" . $evaluado['emp_EmpleadoID'])->getRowArray();
            if ($dominio['ambienteTrabajo'] !== null && $dominio['cargaT'] !== null && $dominio['faltaC'] !== null && $dominio['jornadaT'] !== null && $dominio['interferencia'] !== null && $dominio['liderazgo'] !== null && $dominio['relacionT'] !== null && $dominio['violencia'] !== null && $dominio['reconocimiento'] !== null && $dominio['insuficiente'] !== null) {
                $ambienteT += (int)$dominio['ambienteTrabajo'];
                $cargaT += (int)$dominio['cargaT'];
                $faltaC += (int)$dominio['faltaC'];
                $jornadaT += (int)$dominio['jornadaT'];
                $interferencia += (int)$dominio['interferencia'];
                $liderazgo += (int)$dominio['liderazgo'];
                $relacionT += (int)$dominio['relacionT'];
                $violencia += (int)$dominio['violencia'];
                $reconocimiento += (int)$dominio['reconocimiento'];
                $insuficiente += (int)$dominio['insuficiente'];
                $i++;
            }
        }
        if ($i > 0) {
            $data = array(
                "ambienteTrabajo" => $ambienteT / $i,
                "cargaTrabajo" => $cargaT / $i,
                "faltaControl" => $faltaC / $i,
                "jornadaTrabajo" => $jornadaT / $i,
                "interferencia" => $interferencia / $i,
                "liderazgo" => $liderazgo / $i,
                "relacionTrabajo" => $relacionT / $i,
                "violencia" => $violencia / $i,
                "reconocimiento" => $reconocimiento / $i,
                "insuficiente" => $insuficiente / $i,
            );
        } else {
            $data = array(
                "ambienteTrabajo" => 0,
                "cargaTrabajo" => 0,
                "faltaControl" => 0,
                "jornadaTrabajo" => 0,
                "interferencia" => 0,
                "liderazgo" => 0,
                "relacionTrabajo" => 0,
                "violencia" => 0,
                "reconocimiento" => 0,
                "insuficiente" => 0,
            );
        }
        return $data;
    }

    public function getEvaluadosG3($fInicio, $fFin, $sucursal)
    {
        $array = array();
        $where = '';
        if ($sucursal > 0) $where = " emp_SucursalID=" . $sucursal . " AND ";
        $data = $this->db->query("SELECT emp_Nombre,emp_EmpleadoID FROM evaluaciong3 LEFT JOIN empleado ON emp_EmpleadoID=eva_EvaluadoID WHERE $where eva_Fecha BETWEEN '" . $fInicio . "' AND '" . $fFin . "' ")->getResultArray();
        foreach ($data as $d) {
            $d['id'] = encryptDecrypt('encrypt', $d['emp_EmpleadoID']);
            $CF = $this->db->query("SELECT SUM(eva_P1+eva_P2+eva_P3+eva_P4+eva_P5+eva_P6+eva_P7+eva_P8+eva_P9+eva_P10+eva_P11+eva_P12+eva_P13+eva_P14+eva_P15+eva_P16+eva_P17+eva_P18+eva_P19+eva_P20+eva_P21+eva_P22+eva_P23+eva_P24+eva_P25+eva_P26+eva_P27+eva_P28+eva_P29+eva_P30+eva_P31+eva_P32+eva_P33+eva_P34+eva_P35+eva_P36+eva_P37+eva_P38+eva_P39+eva_P40+eva_P41+eva_P42+eva_P43+eva_P44+eva_P45+eva_P46+eva_P47+eva_P48+eva_P49+eva_P50+eva_P51+eva_P52+eva_P53+eva_P54+eva_P55+eva_P56+eva_P57+eva_P58+eva_P59+eva_P60+eva_P61+eva_P62+eva_P63+eva_P64+eva_P65+eva_P66+eva_P67+eva_P68+eva_P69+eva_P70+eva_P71+eva_P72) as 'calificacionT' FROM evaluaciong3 LEFT JOIN empleado ON emp_EmpleadoID=eva_EvaluadoID WHERE eva_Fecha BETWEEN '" . $fInicio . "' AND '" . $fFin . "' AND eva_EvaluadoID=" . $d['emp_EmpleadoID'])->getRowArray()['calificacionT'];
            if ($CF < 50) {
                $color = '#00c0f3';
                $nivel = 'Nulo';
            } elseif ($CF >= 50 && $CF < 75) {
                $color = '#16a53f';
                $nivel = 'Bajo';
            } elseif ($CF >= 75 && $CF < 99) {
                $color = '#ffff00';
                $nivel = 'Medio';
            } elseif ($CF >= 99 && $CF < 140) {
                $color = '#ff8000';
                $nivel = 'Alto';
            } elseif ($CF >= 140) {
                $color = '#ff3600';
                $nivel = 'Muy Alto';
            }
            $d['calificacion'] = "<span class='badge' style='background-color:" . $color . "'>" . $nivel . "</span>";
            array_push($array, $d);
        }
        return $array;
    }

    public function getDominiosBajoRiesgoG3($fInicio, $fFin, $sucursal)
    {
        $where = '';
        if ($sucursal > 0) $where = "WHERE emp_SucursalID=" . $sucursal;
        $evaluados = $this->db->query("SELECT * FROM empleado $where")->getResultArray();
        $ambienteTBR = 0;
        $ambienteTRM = 0;
        $ambienteTAR = 0;
        $cargaTBR = 0;
        $cargaTRM = 0;
        $cargaTAR = 0;
        $faltaCBR = 0;
        $faltaCRM = 0;
        $faltaCAR = 0;
        $jornadaTBR = 0;
        $jornadaTRM = 0;
        $jornadaTAR = 0;
        $interferenciaBR = 0;
        $interferenciaRM = 0;
        $interferenciaAR = 0;
        $liderazgoBR = 0;
        $liderazgoRM = 0;
        $liderazgoAR = 0;
        $relacionTBR = 0;
        $relacionTRM = 0;
        $relacionTAR = 0;
        $violenciaBR = 0;
        $violenciaRM = 0;
        $violenciaAR = 0;
        $reconocimientoBR = 0;
        $reconocimientoRM = 0;
        $reconocimientoAR = 0;
        $insuficienteBR = 0;
        $insuficienteRM = 0;
        $insuficienteAR = 0;
        foreach ($evaluados as $evaluado) {
            $calificacionEvaluado = $this->db->query("SELECT
            SUM(eva_P1+eva_P3+eva_P2+eva_P4+eva_P5) as 'ambienteTrabajo',
            SUM(eva_P6+eva_P12+eva_P7+eva_P8+eva_P8+eva_P19+eva_P11+eva_P65+eva_P66+eva_P67+eva_P68+eva_P13+eva_P14+eva_P15+eva_P16) as 'cargaTrabajo',
            SUM(eva_P25+eva_P26+eva_P27+eva_P28+eva_P29+eva_P30+eva_P23+eva_P24+eva_P35+eva_P36) as 'faltaControl',
            SUM(eva_P17+eva_P18) as 'jornadaTrabajo',
            SUM(eva_P19+eva_P20+eva_P21+eva_P22) as 'interferencia',
            SUM(eva_P31+eva_P32+eva_P33+eva_P34+eva_P37+eva_P38+eva_P39+eva_P40+eva_P41) as 'liderazgo',
            SUM(eva_P42+eva_P43+eva_P44+eva_P45+eva_P46+eva_P69+eva_P70+eva_P71+eva_P72) as 'relacionTrabajo',
            SUM(eva_P57+eva_P58+eva_P59+eva_P60+eva_P61+eva_P62+eva_P63+eva_P64) as 'violencia',
            SUM(eva_P47+eva_P48+eva_P49+eva_P50+eva_P51+eva_P52) as 'reconocimiento',
            SUM(eva_P53+eva_P54) as 'insuficiente'
            FROM evaluaciong3 WHERE eva_Fecha BETWEEN '" . $fInicio . "' AND '" . $fFin . "' AND eva_EvaluadoID=" . $evaluado['emp_EmpleadoID'])->getRowArray();
            if (
                $calificacionEvaluado['ambienteTrabajo'] !== null && $calificacionEvaluado['cargaTrabajo'] !== null &&
                $calificacionEvaluado['faltaControl'] !== null && $calificacionEvaluado['jornadaTrabajo'] !== null &&
                $calificacionEvaluado['interferencia'] !== null && $calificacionEvaluado['liderazgo'] !== null &&
                $calificacionEvaluado['relacionTrabajo'] !== null && $calificacionEvaluado['violencia'] !== null &&
                $calificacionEvaluado['reconocimiento'] !== null && $calificacionEvaluado['insuficiente'] !== null
            ) {
                //ambiente de trabajo
                if ($calificacionEvaluado['ambienteTrabajo'] < 9) {
                    $ambienteTBR += 1;
                } elseif ($calificacionEvaluado['ambienteTrabajo'] >= 9 && $calificacionEvaluado['ambienteTrabajo'] < 11) {
                    $ambienteTRM += 1;
                } elseif ($calificacionEvaluado['ambienteTrabajo'] >= 11) {
                    $ambienteTAR += 1;
                }
                //carga de trabajo
                if ($calificacionEvaluado['cargaTrabajo'] < 21) {
                    $cargaTBR += 1;
                } elseif ($calificacionEvaluado['cargaTrabajo'] >= 21 && $calificacionEvaluado['cargaTrabajo'] < 27) {
                    $cargaTRM += 1;
                } elseif ($calificacionEvaluado['cargaTrabajo'] >= 27) {
                    $cargaTAR += 1;
                }
                //falta de control
                if ($calificacionEvaluado['faltaControl'] < 16) {
                    $faltaCBR += 1;
                } elseif ($calificacionEvaluado['faltaControl'] >= 16 && $calificacionEvaluado['faltaControl'] < 21) {
                    $faltaCRM += 1;
                } elseif ($calificacionEvaluado['faltaControl'] >= 21) {
                    $faltaCAR += 1;
                }
                //jornada de trabajo
                if ($calificacionEvaluado['jornadaTrabajo'] < 2) {
                    $jornadaTBR += 1;
                } elseif ($calificacionEvaluado['jornadaTrabajo'] >= 2 && $calificacionEvaluado['jornadaTrabajo'] < 4) {
                    $jornadaTRM += 1;
                } elseif ($calificacionEvaluado['jornadaTrabajo'] >= 4) {
                    $jornadaTAR += 1;
                }
                //interferencia
                if ($calificacionEvaluado['interferencia'] < 6) {
                    $interferenciaBR += 1;
                } elseif ($calificacionEvaluado['interferencia'] >= 6 && $calificacionEvaluado['interferencia'] < 8) {
                    $interferenciaRM += 1;
                } elseif ($calificacionEvaluado['interferencia'] >= 8) {
                    $interferenciaAR += 1;
                }
                //liderazgo
                if ($calificacionEvaluado['liderazgo'] < 12) {
                    $liderazgoBR += 1;
                } elseif ($calificacionEvaluado['liderazgo'] >= 12 && $calificacionEvaluado['liderazgo'] < 16) {
                    $liderazgoRM += 1;
                } elseif ($calificacionEvaluado['liderazgo'] >= 16) {
                    $liderazgoAR += 1;
                }
                //relacion de trabajo
                if ($calificacionEvaluado['relacionTrabajo'] < 13) {
                    $relacionTBR += 1;
                } elseif ($calificacionEvaluado['relacionTrabajo'] >= 13 && $calificacionEvaluado['relacionTrabajo'] < 17) {
                    $relacionTRM += 1;
                } elseif ($calificacionEvaluado['relacionTrabajo'] >= 17) {
                    $relacionTAR += 1;
                }
                //violencia
                if ($calificacionEvaluado['violencia'] < 10) {
                    $violenciaBR += 1;
                } elseif ($calificacionEvaluado['violencia'] >= 10 && $calificacionEvaluado['violencia'] < 13) {
                    $violenciaRM += 1;
                } elseif ($calificacionEvaluado['violencia'] >= 13) {
                    $violenciaAR += 1;
                }
                //reconocimento del desempeño
                if ($calificacionEvaluado['reconocimiento'] < 10) {
                    $reconocimientoBR += 1;
                } elseif ($calificacionEvaluado['reconocimiento'] >= 10 && $calificacionEvaluado['reconocimiento'] < 14) {
                    $reconocimientoRM += 1;
                } elseif ($calificacionEvaluado['reconocimiento'] >= 14) {
                    $reconocimientoAR += 1;
                }
                //insuficiente
                if ($calificacionEvaluado['insuficiente'] < 6) {
                    $insuficienteBR += 1;
                } elseif ($calificacionEvaluado['insuficiente'] >= 6 && $calificacionEvaluado['insuficiente'] < 8) {
                    $insuficienteRM += 1;
                } elseif ($calificacionEvaluado['insuficiente'] >= 8) {
                    $insuficienteAR += 1;
                }
            }
        }

        $data['bajo'] = array($ambienteTBR, $cargaTBR, $faltaCBR, $jornadaTBR, $interferenciaBR, $liderazgoBR, $relacionTBR, $violenciaBR, $reconocimientoBR, $insuficienteBR);
        $data['medio'] = array($ambienteTRM, $cargaTRM, $faltaCRM, $jornadaTRM, $interferenciaRM, $liderazgoRM, $relacionTRM, $violenciaRM, $reconocimientoRM, $insuficienteRM);
        $data['alto'] = array($ambienteTAR, $cargaTAR, $faltaCAR, $jornadaTAR, $interferenciaAR, $liderazgoAR, $relacionTAR, $violenciaAR, $reconocimientoAR, $insuficienteAR);
        return $data;
    }

    public function getDominiosG3ByEvaluado($evaluado, $fInicio, $fFin)
    {
        $i = 0;
        $ambienteT = 0;
        $cargaT = 0;
        $faltaC = 0;
        $jornadaT = 0;
        $interferencia = 0;
        $liderazgo = 0;
        $relacionT = 0;
        $violencia = 0;
        $reconocimiento = 0;
        $insuficiente = 0;

        $dominio = $this->db->query("SELECT
        SUM(eva_P1+eva_P3+eva_P2+eva_P4+eva_P5) as 'ambienteTrabajo',
        SUM(eva_P6+eva_P12+eva_P7+eva_P8+eva_P9+eva_P10+eva_P11+eva_P65+eva_P66+eva_P67+eva_P68+eva_P13+eva_P14+eva_P15+eva_P16) as 'cargaT',
        SUM(eva_P25+eva_P26+eva_P27+eva_P28+eva_P29+eva_P30+eva_P23+eva_P24+eva_P35+eva_P36) as 'faltaC',
        SUM(eva_P17+eva_P18) as 'jornadaT',
        SUM(eva_P19+eva_P20+eva_P21+eva_P22) as 'interferencia',
        SUM(eva_P31+eva_P32+eva_P33+eva_P34+eva_P37+eva_P38+eva_P39+eva_P40+eva_P41) as 'liderazgo',
        SUM(eva_P42+eva_P43+eva_P44+eva_P45+eva_P46+eva_P69+eva_P70+eva_P71+eva_P72) as 'relacionT',
        SUM(eva_P57+eva_P58+eva_P59+eva_P60+eva_P61+eva_P62+eva_P63+eva_P64) as 'violencia',
        SUM(eva_P47+eva_P48+eva_P49+eva_P50+eva_P51+eva_P52) as 'reconocimiento',
        SUM(eva_P55+eva_P56+eva_P53+eva_P54) as 'insuficiente'
        FROM evaluaciong3 WHERE eva_Fecha BETWEEN '" . $fInicio . "' AND '" . $fFin . "' AND eva_EvaluadoID=" . $evaluado)->getRowArray();
        if ($dominio['ambienteTrabajo'] !== null && $dominio['cargaT'] !== null && $dominio['faltaC'] !== null && $dominio['jornadaT'] !== null && $dominio['interferencia'] !== null && $dominio['liderazgo'] !== null && $dominio['relacionT'] !== null && $dominio['violencia'] !== null && $dominio['reconocimiento'] !== null && $dominio['insuficiente'] !== null) {
            $ambienteT += (int)$dominio['ambienteTrabajo'];
            $cargaT += (int)$dominio['cargaT'];
            $faltaC += (int)$dominio['faltaC'];
            $jornadaT += (int)$dominio['jornadaT'];
            $interferencia += (int)$dominio['interferencia'];
            $liderazgo += (int)$dominio['liderazgo'];
            $relacionT += (int)$dominio['relacionT'];
            $violencia += (int)$dominio['violencia'];
            $reconocimiento += (int)$dominio['reconocimiento'];
            $insuficiente += (int)$dominio['insuficiente'];
            $i++;
        }

        if ($i > 0) {
            $data = array(
                "ambienteTrabajo" => $ambienteT / $i,
                "cargaT" => $cargaT / $i,
                "faltaC" => $faltaC / $i,
                "jornadaT" => $jornadaT / $i,
                "interferencia" => $interferencia / $i,
                "liderazgo" => $liderazgo / $i,
                "relacionT" => $relacionT / $i,
                "violencia" => $violencia / $i,
                "reconocimiento" => $reconocimiento / $i,
                "insuficiente" => $insuficiente / $i,
            );
        } else {
            $data = array(
                "ambienteTrabajo" => 0,
                "cargaT" => 0,
                "faltaC" => 0,
                "jornadaT" => 0,
                "interferencia" => 0,
                "liderazgo" => 0,
                "relacionT" => 0,
                "violencia" => 0,
                "reconocimiento" => 0,
                "insuficiente" => 0,
            );
        }
        return $data;
    }





    //Diego -> Obtiene los empleados necesarios para realizar la evaluacion de 270 (Jefe, colegas, subordinados y el mismo)
    public function getEmpleadosByEmpleadoEvaluacion270($empleadoID)
    {
        $sql = "SELECT *,A.are_Nombre,P.pue_Nombre
                FROM empleado E
                  LEFT JOIN area A ON A.are_AreaID=E.emp_AreaID
                  LEFT JOIN puesto P ON P.pue_PuestoID=E.emp_PuestoID
                WHERE E.emp_EmpleadoID=?";
        $empleado = $this->db->query($sql, array($empleadoID))->getRowArray();
        $sql = "SELECT *
                FROM empleado E
                  LEFT JOIN area A ON A.are_AreaID=E.emp_AreaID
                  LEFT JOIN puesto P ON P.pue_PuestoID=E.emp_PuestoID
                WHERE E.emp_Numero=? ";
        $jefe = $this->db->query($sql, array($empleado['emp_Jefe']))->getRowArray();

        $sql = "SELECT *
                FROM empleado E
                LEFT JOIN area A ON A.are_AreaID=E.emp_AreaID
                  LEFT JOIN puesto P ON P.pue_PuestoID=E.emp_PuestoID
                WHERE E.emp_Jefe=? AND emp_Estatus=1";
        $subordinados = $this->db->query($sql, array($empleado['emp_Numero']))->getResultArray();

        $sql = "SELECT *
                FROM empleado E
                LEFT JOIN area A ON A.are_AreaID=E.emp_AreaID
                  LEFT JOIN puesto P ON P.pue_PuestoID=E.emp_PuestoID
                WHERE E.emp_Jefe=? AND E.emp_EmpleadoID!=? AND emp_Estatus=1";
        $colegas = $this->db->query($sql, array($empleado['emp_Jefe'], $empleadoID))->getResultArray();


        $colaboradores = array(
            'empleado'     => $empleado,
            'jefe'         => $jefe,
            'subordinados' => $subordinados,
            'colegas'      => $colegas
        );
        return $colaboradores;
    }

    //Diego -> Busca si la evaluacion de desempeño de 270 ya fue realizada
    public function evaluacionDesempeno270Realizada($evaluadorID, $empleadoID)
    {
        $sql = "SELECT *
                 FROM evaluacion
                 WHERE eva_Tipo='Desempeño' AND eva_Estatus=1 AND
                   CURDATE() BETWEEN eva_FechaInicio AND eva_FechaFin
                 ORDER BY eva_FechaRegistro DESC";
        $fecha = $this->db->query($sql)->getRowArray();
        if ($fecha) {
            $sql = "SELECT * FROM evaluaciondesempeno270 WHERE evad_EmpleadoID=? AND evad_EvaluadorID=? AND (evad_Fecha BETWEEN ? AND ? ) ORDER BY evad_DesempenoID DESC";
            $realizada = $this->db->query($sql, array($empleadoID, $evaluadorID, $fecha['eva_FechaInicio'], $fecha['eva_FechaFin'],))->getRowArray();
            return $realizada;
        }
        return null;
    }
    //Diego -> obtiene la informacion del puesto de un empleado por el empleado de este ultimo
    public function getPuestoInfoByEmpleado($empleadoID)
    {
        $sql = "SELECT emp_PuestoID
                    FROM empleado
                    WHERE emp_EmpleadoID=?";
        $puestoID = $this->db->query($sql, array((int)$empleadoID))->getRowArray()['emp_PuestoID'];

        $sql = "SELECT *
                    FROM puesto
                    WHERE pue_PuestoID=?";
        return $this->db->query($sql, array((int)$puestoID))->getRowArray();
    }

    public function getFunciones($puestoID)
    {
        $sql = "SELECT PP.per_Funcion AS 'funciones'
                    FROM perfilpuesto PP
                    WHERE PP.per_PuestoID=?";
        $funciones = $this->db->query($sql, array((int)$puestoID))->getRowArray()['funciones'] ?? null;
        if ($funciones) {
            $funciones = json_decode($funciones, true);
            return $funciones;
        }
        return null;
    }

    //Diego -> Informacion del empleado
    public function getEmpleadoInfo($empleadoID)
    {
        return $this->db->query("SELECT E.emp_EmpleadoID, E.emp_Nombre, P.pue_Nombre, E.emp_Jefe, E.emp_Numero, E.emp_PuestoID FROM empleado E JOIN puesto P ON P.pue_PuestoID=E.emp_PuestoID WHERE E.emp_EmpleadoID=" . (int)$empleadoID)->getRowArray();
    }

    //Diego -> mejora de la funcion donde regresa el periodo de evaluacion y no la cantidad de periodos encontrados
    public function getFechaEvaluacionDesempenoV2()
    {
        return $this->db->query("SELECT * FROM evaluacion WHERE eva_Tipo='Desempeño' AND eva_Estatus=1 AND CURDATE() BETWEEN eva_FechaInicio AND eva_FechaFin ORDER BY eva_EvaluacionID DESC")->getRowArray();
    }

    //Diego -> Obtiene los empleados
    public function getEmpleados()
    {
        return $this->db->query("SELECT emp_EmpleadoID AS 'id', emp_Nombre AS 'nombre' FROM empleado WHERE emp_Estatus=1 ORDER BY emp_Nombre ASC")->getResultArray();
    }

    //Diego -> Obtiene informacion del periodo
    public function getPeriodoInfo($periodoID)
    {
        $sql = "SELECT *
                FROM evaluacion
                WHERE eva_Estatus=1 AND eva_EvaluacionID=?";
        return $this->db->query($sql, array($periodoID))->getRowArray();
    }

    //Diego -> Obtiene los resultados de la evaluacion de desempeño de un periodo de un empleado
    public function getDesempeno270ByEmpleadoPeriodo($periodoID, $empleadoID)
    {
        $empleadoInfo = $this->getEmpleadoInfo($empleadoID);
        $funcionesPP = $this->db->query("SELECT per_Funcion FROM perfilpuesto WHERE per_PuestoID=?", array($empleadoInfo['emp_PuestoID']))->getRowArray()['per_Funcion'] ?? null;
        $funciones = array();

        //Evaluacion propia
        $sql = "SELECT ED.*
                FROM evaluaciondesempeno270 ED
                WHERE ED.evad_EmpleadoID=? AND ED.evad_PeriodoID=? AND ED.evad_EvaluadorID=?";
        $evaAuto = $this->db->query($sql, array($empleadoID, $periodoID, $empleadoID))->getRowArray();

        $resultadosAuto = array();
        if (!is_null($evaAuto)) {
            $resultadosAuto = json_decode($evaAuto['evad_Respuestas'], 1);
            foreach ($resultadosAuto as $key => $resultado) {
                if (!array_key_exists($key, $funciones)) {
                    $funciones[$key] = $resultado['Funcion'];
                }
            }
        } else {
            $resultadosAuto = null;
        }

        //Evaluacion jefe
        $sql = "SELECT ED.*
                FROM evaluaciondesempeno270 ED
                JOIN empleado E ON E.emp_EmpleadoID=ED.evad_EvaluadorID
                WHERE ED.evad_EmpleadoID=? AND ED.evad_PeriodoID=? AND E.emp_Numero=?";
        $evaJefe = $this->db->query($sql, array($empleadoID, $periodoID, $empleadoInfo['emp_Jefe']))->getRowArray();

        $resultadosJefe = array();
        if (!is_null($evaJefe)) {
            $resultadosJefe = json_decode($evaJefe['evad_Respuestas'], 1);
            foreach ($resultadosJefe as $key => $resultado) {
                if (!array_key_exists($key, $funciones)) {
                    $funciones[$key] = $resultado['Funcion'];
                }
            }
        } else {
            $resultadosJefe = null;
        }

        //Evaluacion pares
        $sql = "SELECT ED.*
                FROM evaluaciondesempeno270 ED
                JOIN empleado E ON E.emp_EmpleadoID=ED.evad_EvaluadorID
                WHERE ED.evad_EmpleadoID=? AND ED.evad_PeriodoID=? AND E.emp_Jefe=? AND ED.evad_EvaluadorID!=? AND E.emp_Estatus=1";
        $evaPares = $this->db->query($sql, array($empleadoID, $periodoID, $empleadoInfo['emp_Jefe'], $empleadoID))->getResultArray();

        $resultadosPares = array();
        $evaParesC = count($evaPares);
        $evaParesPromedio = null;
        if ($evaParesC > 0) {
            $evaParesSuma = 0;
            foreach ($evaPares as $item) {
                $evaParesSuma += $item['evad_Calificacion'];
                $resultados = json_decode($item['evad_Respuestas'], 1);

                foreach ($resultados as $key => $resultado) {

                    if (!array_key_exists($key, $funciones)) {
                        $funciones[$key] = $resultado['Funcion'];
                    }

                    if (array_key_exists($key, $resultadosPares)) {
                        $resultadosPares[$key]['Promedio'] += $resultado['Calificacion'];
                    } else {
                        $resultadosPares[$key]['Funcion'] = $resultado['Funcion'];
                        $resultadosPares[$key]['Promedio'] = $resultado['Calificacion'];
                    }
                }
            }
            $evaParesPromedio = $evaParesSuma / $evaParesC;
            foreach ($resultadosPares as $key => $item) {
                $resultadosPares[$key]['Promedio'] = $item['Promedio'] / $evaParesC;
            }
        } else {
            $resultadosPares = null;
        }

        //Evaluacion subordinados
        $sql = "SELECT ED.*
                FROM evaluaciondesempeno270 ED
                JOIN empleado E ON E.emp_EmpleadoID=ED.evad_EvaluadorID
                WHERE ED.evad_EmpleadoID=? AND ED.evad_PeriodoID=? AND E.emp_Jefe=? AND E.emp_Estatus=1";
        $evaSub = $this->db->query($sql, array($empleadoID, $periodoID, $empleadoInfo['emp_Numero']))->getResultArray();

        $resultadosSub = array();
        $evaSubC = count($evaSub);
        $evaSubPromedio = null;
        if ($evaSubC > 0) {
            $evaSubSuma = 0;
            foreach ($evaSub as $item) {
                $evaSubSuma += $item['evad_Calificacion'];
                $resultados = json_decode($item['evad_Respuestas'], 1);

                foreach ($resultados as $key => $resultado) {

                    if (!array_key_exists($key, $funciones)) {
                        $funciones[$key] = $resultado['Funcion'];
                    }

                    if (array_key_exists($key, $resultadosSub)) {
                        $resultadosSub[$key]['Promedio'] += $resultado['Calificacion'];
                    } else {
                        $resultadosSub[$key]['Funcion'] = $resultado['Funcion'];
                        $resultadosSub[$key]['Promedio'] = $resultado['Calificacion'];
                    }
                }
            }
            $evaSubPromedio = $evaSubSuma / $evaSubC;
            foreach ($resultadosSub as $key => $item) {
                $resultadosSub[$key]['Promedio'] = $item['Promedio'] / $evaSubC;
            }
        } else {
            $resultadosSub = null;
        }

        $resultados = array(
            'evaAuto'  => array('resultados' => $resultadosAuto, 'promedio' => $evaAuto['evad_Calificacion'] ?? null),
            'evaJefe'  => array('resultados' => $resultadosJefe, 'promedio' => $evaJefe['evad_Calificacion'] ?? null),
            'evaPares' => array('resultados' => $resultadosPares, 'promedio' => $evaParesPromedio),
            'evaSub'   => array('resultados' => $resultadosSub, 'promedio' => $evaSubPromedio),
            'funciones' => $funciones,
        );
        //var_dump($resultados);exit();
        return $resultados;
    }

    //Lia ->Trae las sucursales
    public function getSucursales()
    {
        return $this->db->query("SELECT * FROM sucursal WHERE suc_Estatus=1 order by suc_Sucursal ASC")->getResultArray();
    }

    //Lia -> Obtiene los empleados necesarios para realizar la evaluacion de competencias(Subordinados y el mismo)
    public function getEmpleadosByEmpleadoEvaluacionComp($empleadoID)
    {
        $sql = "SELECT *,A.are_Nombre,P.pue_Nombre
                    FROM empleado E
                      LEFT JOIN area A ON A.are_AreaID=E.emp_AreaID
                      LEFT JOIN puesto P ON P.pue_PuestoID=E.emp_PuestoID
                    WHERE E.emp_EmpleadoID=?";
        $empleado = $this->db->query($sql, array($empleadoID))->getRowArray();

        $sql = "SELECT *
                    FROM empleado E
                    LEFT JOIN area A ON A.are_AreaID=E.emp_AreaID
                      LEFT JOIN puesto P ON P.pue_PuestoID=E.emp_PuestoID
                    WHERE E.emp_Jefe=? AND E.emp_Estatus=1 ";
        $subordinados = $this->db->query($sql, array($empleado['emp_Numero']))->getResultArray();

        $colaboradores = array(
            'empleado'     => $empleado,
            'subordinados' => $subordinados,
        );
        return $colaboradores;
    }

    //Lia->trae el estatus de la evaluacion realizada
    public function evaluacionCompetenciaRealizada($empleadoID)
    {
        $sql = "SELECT *
                FROM evaluacion
                WHERE  eva_Tipo='Competencias' AND eva_Estatus=1 AND
                    CURDATE() BETWEEN eva_FechaInicio AND eva_FechaFin ORDER BY eva_FechaRegistro DESC";
        $fecha = $this->db->query($sql)->getRowArray();

        $sql = "SELECT *
                FROM evaluacioncompetencia
                WHERE evac_EmpleadoID=? AND ((evac_Fecha BETWEEN ? AND ? )) ORDER BY evac_EvaluacionCompetenciaID DESC";
        $realizada = $this->db->query($sql, array(encryptDecrypt('decrypt', $empleadoID), $fecha['eva_FechaInicio'], $fecha['eva_FechaFin'],))->getRowArray();
        return $realizada;
    }

    public function evaluacionCompetenciaRealizadaJefe($empleadoID)
    {
        $empleadoID = encryptDecrypt('decrypt', $empleadoID);
        $sql = "SELECT *
                FROM evaluacion
                WHERE  eva_Tipo='Competencias' AND eva_Estatus=1 AND
                  CURDATE() BETWEEN eva_FechaInicio AND eva_FechaFin
                ORDER BY eva_FechaRegistro DESC";
        $fecha = $this->db->query($sql)->getRowArray();

        $sql = "SELECT *
                FROM evaluacioncompetencia
                WHERE evac_JefeID=? AND
                  (
                  (evac_Fecha BETWEEN ? AND ? )
                  )
                ORDER BY evac_EvaluacionCompetenciaID DESC";
        $realizada = $this->db->query($sql, array(session('id'), $fecha['eva_FechaInicio'], $fecha['eva_FechaFin'],))->getRowArray();

        return $realizada;
    }

    //Lia ->trae la fecha de la evaluacion de competencias
    public function getFechaEvaluacionCompetencia()
    {
        $sql = "SELECT  eva_EvaluacionID
                FROM evaluacion
                WHERE eva_Tipo='Competencias' AND eva_Estatus = 1 AND
                  CURDATE() BETWEEN eva_FechaInicio AND eva_FechaFin";
        return $this->db->query($sql)->getRowArray();
    }

    //Lia-> regresa las competencias por puesto
    public function getCompetencias($puestoID)
    {
        $sql = "SELECT C.* , CP.cmp_CompetenciaID,  CP.cmp_PuestoID, CP.cmp_Nivel
                FROM competencia C join competenciapuesto CP on C.com_CompetenciaID = CP.cmp_CompetenciaID
                WHERE CP.cmp_PuestoID=?";
        return $this->db->query($sql, array((int)$puestoID))->getResultArray();
    }

    //Lia->trae la info de la evaluacion de competencias
    public function getInfoEvComp($evCompID)
    {
        $sql = "SELECT * FROM evaluacioncompetencia WHERE evac_EvaluacionCompetenciaID=?";
        return $this->db->query($sql, array($evCompID))->getRowArray();
    }

    //Lia -> Obtiene la ultima evaluacion por competencias de un empleado
    public function getLastEvaluacionCompetenciasByEmpleadoFecha($empleadoID, $fecha)
    {
        $sql = "SELECT *
                FROM evaluacioncompetencia EC
                WHERE EC.evac_EmpleadoID=? AND EC.evac_Fecha=?
                ORDER BY EC.evac_Fecha DESC";
        $lastEC = $this->db->query($sql, array((int)$empleadoID, $fecha))->getRowArray();

        if (is_null($lastEC)) {
            return null;
        }

        $calificaciones = json_decode($lastEC['evac_Calificacion'], 1);
        $porcentajes = json_decode($lastEC['evac_Porcentaje'], 1);

        $calificacionesJefe = json_decode($lastEC['evac_CalificacionJefe'], 1);
        $porcentajesJefe = json_decode($lastEC['evac_PorcentajeJefe'], 1);

        foreach ($porcentajes as $key => $val) {
            $comID = $calificaciones[$key]['IdComp'];
            $sql = 'SELECT com_Nombre,com_Tipo from competencia where com_CompetenciaID=?';
            $comNombre = $this->db->query($sql, $comID)->getRowArray();

            $calificaciones[$key]['porcentaje'] = $val['Porcentaje'];
            $calificaciones[$key]['comNombre'] = $comNombre['com_Nombre'];
            $calificaciones[$key]['com_Tipo'] = $comNombre['com_Tipo'];
            $calificaciones[$key]['calJefe'] = $calificacionesJefe[$key]['Valor'] ?? null;
            $calificaciones[$key]['porJefe'] = $porcentajesJefe[$key]['Porcentaje'] ?? null;
        }

        $lastEC['calificaciones'] = $calificaciones;
        return $lastEC;
    }
}//end EvaluacionesModel
