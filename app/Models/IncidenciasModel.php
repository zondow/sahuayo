<?php

namespace App\Models;

use CodeIgniter\Model;

class IncidenciasModel extends Model
{

    //Lia -> Obtiene la info del empleado
    public function getInfoEmpleado($idEmpleado)
    {
        return $this->db->query("SELECT EMP.*, PUE.pue_Nombre, DEP.dep_Nombre FROM empleado EMP
        LEFT JOIN puesto PUE ON EMP.emp_PuestoID = PUE.pue_PuestoID
        LEFT  JOIN departamento DEP ON EMP.emp_DepartamentoID = DEP.dep_DepartamentoID
        WHERE EMP.emp_EmpleadoID = ?", array($idEmpleado))->getRowArray();
    } //end getIngoEmpleado

    public function getRegistrosByEmpleadoID($empleadoID = null)
    {
        return $this->db->query("SELECT * FROM vacacion WHERE vac_EmpleadoID= ? AND vac_Estado=1", array($empleadoID ?? session('id')))->getResultArray();
    }

    public function getVacacion($idVacacion)
    {
        return $this->db->query("SELECT * FROM vacacion WHERE vac_VacacionID=?", array($idVacacion))->getRowArray();
    }

    //Lia -> Obtiene el listado de vacaciones para autorizar
    public function getVacacionesEmpleadosJefe($numJefe)
    {
        $extraCondition = (session('id') == 19) ? ' OR (EMP.emp_EmpleadoID=7 AND VAC.vac_Estado=1)' : '';

        $sql = "SELECT VAC.*, EMP.emp_Nombre, S.suc_Sucursal, EMP.emp_Jefe
                FROM vacacion VAC
                LEFT JOIN empleado EMP ON EMP.emp_EmpleadoID = VAC.vac_EmpleadoID
                LEFT JOIN sucursal S ON EMP.emp_SucursalID = S.suc_SucursalID
                WHERE (EMP.emp_Jefe = ? AND VAC.vac_Estado = 1) $extraCondition";

        return $this->db->query($sql, [$numJefe])->getResultArray();
    }

    public function getEmpleadoByVacacionID($idVacaciones)
    {
        return $this->db->query("SELECT E.emp_EmpleadoID, E.emp_Nombre 
        FROM empleado E 
        JOIN vacacion V ON V.vac_EmpleadoID=E.emp_EmpleadoID 
        WHERE  V.vac_VacacionesID=?", array($idVacaciones))->getRowArray();
    }

    //Lia -> Obtiene el listado de vacaciones para autorizar
    function getListVacaciones($estatus)
    {
        $estatus = join("','", $estatus);

        $query = "SELECT VAC.*, EMP.emp_Nombre,S.suc_Sucursal,EMP.emp_SucursalID FROM vacacion VAC
                    JOIN empleado EMP ON VAC.vac_EmpleadoID = EMP.emp_EmpleadoID
                    JOIN sucursal S ON S.suc_SucursalID =EMP.emp_SucursalID
                  WHERE vac_Estado=1 AND VAC.vac_Estatus IN ('$estatus') AND  VAC.vac_EmpleadoID IN
                    (SELECT EMP.emp_EmpleadoID FROM empleado EMP )
                    order by field(VAC.vac_Estatus,'AUTORIZADO', 'AUTORIZADO_RH', 'DECLINADO', 'RECHAZADO') asc
                  ";
        $consulta = $this->db->query($query);

        return ($consulta) ? $consulta->getResultArray() : null;
    } //end getListVacaciones

    function getVacacionesHorasByEmpleadoID($empleadoID)
    {
        return db()->table("vacacionhoras")->getWhere(array("vach_EmpleadoID" => session('id'), "vach_Estado" => 1))->getResultArray();
    }

    //Diego -> Obtiene el listado de solicitud de horas vacaciones para autorizar
    function getListVacacionesHoras()
    {
        $query = "SELECT VAC.*, EMP.emp_Nombre,S.suc_Sucursal,EMP.emp_SucursalID FROM vacacionhoras VAC
                    JOIN empleado EMP ON VAC.vach_EmpleadoID = EMP.emp_EmpleadoID
                    JOIN sucursal S ON S.suc_SucursalID =EMP.emp_SucursalID
                  WHERE vach_Estado=1 AND VAC.vach_EmpleadoID IN
                    (SELECT EMP.emp_EmpleadoID FROM empleado EMP )
                    order by field(VAC.vach_Estatus,'PENDIENTE','AUTORIZADO_RH','RECHAZADO_RH') asc
                  ";
        $consulta = $this->db->query($query);

        return ($consulta) ? $consulta->getResultArray() : null;
    } //end getListVacaciones

    function getEmpleadoByVacacionHorasID($idVacaciones)
    {
        return db()->query("SELECT * FROM empleado JOIN vacacionhoras ON vach_EmpleadoID=emp_EmpleadoID WHERE vach_VacacionHorasID=?", array($idVacaciones))->getRowArray();
    }

    function getAcumuladosByEmpleado($empleadoID)
    {
        return $this->db->query("SELECT * FROM acumulados WHERE acu_EmpleadoID=?", array($empleadoID))->getRowArray();
    }

    function getDiasVacacionByEmpleadoID($empleadoID)
    {
        return db()->query("SELECT vace_Dias FROM vacacionempleado WHERE vace_EmpleadoID=?", array($empleadoID))->getRowArray()['vace_Dias'] ?? 0;
    }

    public function getCatalogoPermisos()
    {
        return $this->db->query("SELECT * FROM catalogopermiso WHERE cat_Estatus = 1")->getResultArray();
    }

    public function getPermisosByEmpleado($empleadoID)
    {
        $sql = "SELECT P.*, CP.cat_Nombre as 'tipoPermiso'
                FROM permiso P
                LEFT JOIN catalogopermiso CP ON CP.cat_CatalogoPermisoID = P.per_TipoID
                WHERE P.per_EmpleadoID = ? AND P.per_Estatus = 1 ORDER BY P.per_PermisoID ASC";
        return $this->db->query($sql, $empleadoID)->getResultArray();
    } //getPermisosByEmpleado

    public function getCatalogoPermisosById($id)
    {
        return $this->db->query("SELECT * FROM catalogopermiso WHERE cat_CatalogoPermisoID = ?", array($id))->getRowArray();
    } //getCatalogoPermisosById

    public function getDiasTomadosByTipoPermiso($tipoID)
    {
        $sql = "SELECT sum(per_DiasSolicitados) as 'dias' FROM permiso
                WHERE per_TipoID = ? AND per_Estatus = 1 AND YEAR(per_Fecha) = ?
                AND per_Estado IN('PENDIENTE','AUTORIZADO','AUTORIZADO_RH') AND per_EmpleadoID = ?";
        return $this->db->query($sql, array((int)$tipoID, (int)date('Y'), session('id')))->getRowArray()['dias'];
    } //getDiasTomadosByTipoPermiso

    public function getHorasTomadasByPermisoLactancia($fechaInicio, $fechaFin)
    {
        $query = "SELECT sum(per_Horas) as horas FROM permiso 
        WHERE per_TipoID = 9 AND per_Estatus = 1 AND per_Estado IN('PENDIENTE','AUTORIZADO','AUTORIZADO_RH') AND per_EmpleadoID = ? AND 
        ((per_FechaInicio BETWEEN ? AND ?) OR (per_FechaFin BETWEEN ? AND ?) OR (? BETWEEN per_FechaInicio AND per_FechaFin) OR (? BETWEEN per_FechaInicio AND per_FechaFin))";
        return $this->db->query($query, array(session('id'), $fechaInicio, $fechaFin, $fechaInicio, $fechaFin, $fechaInicio, $fechaFin))->getRowArray()['horas'];
    }

    //Diego -> Obtiene todos los permisos pendientes de los subordinados
    public function getPermisosPendientesMisSubordinados($numero)
    {
        $where = '';
        if (session('id') == 19) {
            $where = " OR (E.emp_EmpleadoID=7 AND P.per_Estatus = 1 AND P.per_Estado IN ('PENDIENTE'))";
        }
        $sql = " SELECT P.*, CP.cat_Nombre AS 'tipoPermiso', E.emp_Nombre,S.suc_Sucursal,P.per_TipoID as 'tipoPID',E.emp_Jefe
        FROM permiso P
        LEFT JOIN catalogopermiso CP ON CP.cat_CatalogoPermisoID = P.per_TipoID
        LEFT JOIN empleado E ON E.emp_EmpleadoID = P.per_EmpleadoID
        LEFT JOIN sucursal S on E.emp_SucursalID = S.suc_SucursalID
        WHERE (E.emp_Jefe = '" . $numero . "' AND P.per_Estatus = 1 AND P.per_Estado IN ('PENDIENTE')) $where";
        return $this->db->query($sql)->getResultArray();
    } //getPermisosPendientesMisSubordinados

    public function getInfoByPermiso($permisoID)
    {
        return db()->query("SELECT P.*,E.emp_EmpleadoID,E.emp_Correo,E.emp_Nombre,E.emp_Jefe,E.emp_EmpleadoID FROM permiso P JOIN empleado E ON E.emp_EmpleadoID=P.per_EmpleadoID WHERE P.per_PermisoID=?", array($permisoID))->getRowArray();
    }

    //Diego -> Obtiene todos los permisos de los empleados de una empresa que fueron autorizados por el jefe
    public function getPermisosAutorizados()
    {
        $sql = "SELECT P.*, CP.cat_Nombre AS 'tipoPermiso', E.emp_Nombre,S.suc_Sucursal,P.per_TipoID as 'tipoPID'
                FROM permiso P
                LEFT JOIN catalogopermiso CP ON CP.cat_CatalogoPermisoID = P.per_TipoID
                LEFT JOIN empleado E ON E.emp_EmpleadoID = P.per_EmpleadoID
                LEFT JOIN sucursal S on E.emp_SucursalID = S.suc_SucursalID
                WHERE P.per_Estatus = 1 AND P.per_Estado IN ('AUTORIZADO_JEFE','AUTORIZADO_RH','RECHAZADO_RH','DECLINADO')
                order by field(P.per_Estado,'AUTORIZADO_JEFE','AUTORIZADO_RH','RECHAZADO_RH') asc";
        return $this->db->query($sql)->getResultArray();
    } //getPermisosAutorizados

    public function getHorasExtraByEmpleado($empleadoID)
    {
        return $this->db->query("SELECT * FROM reportehoraextra WHERE rep_Estatus=1 AND rep_EmpleadoID=?", [$empleadoID])->getResultArray();
    } //end getHorasExtraByEmpleado

    public function getHorasMisEmpleadosJefe($numJefe)
    {
        $estatusBase = ["AUTORIZADO", "RECHAZADO", "RECHAZADO_RH", "APLICADO", "PAGADO", "DECLINADO"];
        $estatusExtra = "PENDIENTE";
        $estatus = join("','", $numJefe !== '0' ? array_merge([$estatusExtra], $estatusBase) : $estatusBase);

        $where = $numJefe !== '0' ? " WHERE EMP.emp_Jefe = '$numJefe'" : '';
        $where2 = (session('id') == 19 && $numJefe !== '0') ? ' OR (REP.rep_EmpleadoID=7)' : '';

        $query = "SELECT REP.*, EMP.emp_Nombre FROM reportehoraextra REP
                    JOIN empleado EMP ON REP.rep_EmpleadoID = EMP.emp_EmpleadoID
                  WHERE  REP.rep_Estado IN ('$estatus') AND REP.rep_Estatus=1
                    " . ($numJefe !== '0' ? "AND REP.rep_EmpleadoID IN (SELECT EMP.emp_EmpleadoID FROM empleado EMP $where $where2)" : '') . "
                  ORDER BY FIELD(REP.rep_Estado, 'PENDIENTE', 'AUTORIZADO', 'RECHAZADO', 'RECHAZADO_RH', 'APLICADO', 'PAGADO', 'DECLINADO') ASC";

        $consulta = $this->db->query($query);

        return ($consulta) ? $consulta->getResultArray() : null;
    }

    public function getInfoEmpleadoByReporteHoraExtraID($reporteHoraExtraID)
    {
        return $this->db->query("SELECT Emp.emp_EmpleadoID,Emp.emp_Correo,Emp.emp_Nombre,E.emp_Jefe FROM reportehoraextra R JOIN empleado Emp ON Emp.emp_EmpleadoID=R.rep_EmpleadoID WHERE R.rep_ReporteHoraExtraID=" . $reporteHoraExtraID)->getRowArray();
    }

    //Lia->salidas del colaborador
    public function getSalidassByEmpleado($idEmpleado)
    {
        return $this->db->query("SELECT * FROM reportesalida WHERE rep_EmpleadoID=? AND rep_Estatus=1", [$idEmpleado])->getResultArray();
    } //end getSalidassByEmpleado

    public function getInfoEmpleadoByReporteSalida($salidaID)
    {
        return $this->db->query("SELECT E.emp_EmpleadoID,E.emp_Nombre,E.emp_Jefe,E.emp_Correo FROM reportesalida R JOIN empleado E ON E.emp_EmpleadoID=R.rep_EmpleadoID WHERE R.rep_ReporteSalidaID=" . $salidaID)->getRowArray();
    }

    // Diego -> obtener salidas de mis empleados
    public function getSalidasMisEmpleados($numJefe = null)
    {
        $estatus = array("PENDIENTE", "AUTORIZADO", "RECHAZADO", "RECHAZADO_RH", "APLICADO");

        // Usamos el constructor de consultas de CodeIgniter
        $builder = $this->db->table('reportesalida REP');
        $builder->select('REP.*, EMP.emp_Nombre')
            ->join('empleado EMP', 'REP.rep_EmpleadoID = EMP.emp_EmpleadoID')
            ->whereIn('REP.rep_Estado', $estatus)
            ->where('REP.rep_Estatus', 1);

        if (!is_null($numJefe)) {
            $builder->where('EMP.emp_Jefe', $numJefe);
        }

        $consulta = $builder->get();

        return ($consulta) ? $consulta->getResultArray() : null;
    }

    //Diego->obtener informe salidas rh
    public function getInformesSalidas()
    {
        $query = "SELECT REP.*, EMP.emp_Nombre FROM reportesalida REP
                    JOIN empleado EMP ON REP.rep_EmpleadoID = EMP.emp_EmpleadoID
                  WHERE  REP.rep_Estado IN ('AUTORIZADO', 'RECHAZADO_RH', 'APLICADO') AND REP.rep_Estatus=1";
        return $this->db->query($query)->getResultArray();
    } //end getInformesSalidas

    //Diego->Dias incapacidades por empleado
    public function getIncapacidadesByEmpleado($empleadoID)
    {
        return $this->db->query("SELECT * FROM incapacidad JOIN empleado ON emp_EmpleadoID=inc_EmpleadoID WHERE inc_EmpleadoID=?",[$empleadoID])->getResultArray();
    } // end getIncapacidadesByEmpleado

    //Diego->Dias incapacidades
    public function getIncapacidades()
    {
        return $this->db->query("SELECT * FROM incapacidad JOIN empleado ON inc_EmpleadoID=emp_EmpleadoID")->getResultArray();
    } // end getDiasInhabiles

    public function getIncapacidadesByID($IncapacidadID)
    {
        return $this->db->query("SELECT * FROM incapacidad  WHERE inc_IncapacidadID=?",[$IncapacidadID])->getRowArray();
    }

    public function getIncapacidadesMisColaboradores()
    {
        return $this->db->query("SELECT I.*, E.emp_Nombre,E.emp_Numero,E.emp_Jefe FROM incapacidad I JOIN empleado E ON E.emp_EmpleadoID=I.inc_EmpleadoID WHERE emp_Jefe=?" , [session('numero')])->getResultArray();
    } //end getActasIncapacidadesMisColaboradores

    //Diego->Dias incapacidades por empleado
    public function getSolicitudIncapacidades()
    {
        return $this->db->query("SELECT I.*, E.emp_Nombre,RIGHT(I.inc_Archivo, 3) AS archivo_ext FROM incapacidad I JOIN empleado E ON E.emp_EmpleadoID=I.inc_EmpleadoID")->getResultArray();
    } // end getIncapacidadesByEmpleado

    public function getEmpleadoByIncapacidadID($incapacidadID){
        return $this->db->query("SELECT Emp.emp_EmpleadoID,Emp.emp_Correo,Emp.emp_Nombre FROM incapacidad I JOIN empleado Emp ON Emp.emp_EmpleadoID=I.inc_EmpleadoID WHERE I.inc_IncapacidadID=?",[$incapacidadID] )->getRowArray();
    }

    //Lia->Trae las actas administrativas por empresa
    public function getActasAdministrativasByColaborador($empleadoID)
    {
        return $this->db->query("SELECT A.*, E.emp_Nombre,E.emp_Numero FROM actaadministrativa A JOIN empleado E ON E.emp_EmpleadoID=A.act_EmpleadoID WHERE act_EmpleadoID=? ORDER BY A.act_FechaRealizo ASC",[$empleadoID])->getResultArray();
    } //end getActasAdministrativasByColaborador

    public function getActasAdministrativasMisColaboradores()
    {
        return $this->db->query("SELECT A.*, E.emp_Nombre,E.emp_Numero,E.emp_Jefe FROM actaadministrativa A JOIN empleado E ON E.emp_EmpleadoID=A.act_EmpleadoID WHERE emp_Jefe=? ORDER BY A.act_FechaRealizo ASC",[session('numero')])->getResultArray();
    } //end getActasAdministrativasMisColaboradores

    //Lia->Trae las actas administrativas por empresa
    public function getActasAdministrativas()
    {
        return $this->db->query("SELECT A.*, E.emp_Nombre,E.emp_Numero, S.suc_Sucursal FROM actaadministrativa A JOIN empleado E ON E.emp_EmpleadoID=A.act_EmpleadoID JOIN sucursal S ON S.suc_SucursalID = E.emp_SucursalID ORDER BY A.act_FechaRealizo ASC")->getResultArray();
    } //end getActasAdministrativas

    public function getEmpleadoByActaAdministrativaID($actaAdmID){
        $sql = "SELECT E.emp_EmpleadoID, E.emp_Nombre, E.emp_Correo FROM empleado E
                JOIN actaadministrativa A ON A.act_EmpleadoID=E.emp_EmpleadoID
                WHERE  A.act_ActaAdministrativaID=?";
        return $this->db->query($sql, array($actaAdmID))->getRowArray();
    }

    public function getActaAdministrativa($actaID)
    {        
        return $this->db->query("SELECT * FROM actaadministrativa WHERE act_ActaAdministrativaID=?",[(int)$actaID])->getRowArray();
    }

    public function getReporteVacacionesEmpleado(){
        return db()->query("SELECT E.emp_Numero, E.emp_Nombre, GROUP_CONCAT(DISTINCT CONCAT_WS(' al ', V.vac_FechaInicio, V.vac_FechaFin) ORDER BY V.vac_FechaInicio SEPARATOR ', ') AS 'fechas', SUM(V.vac_Disfrutar) AS 'dias_totales', V.vac_Periodo
        FROM vacacion V
        JOIN empleado E ON E.emp_EmpleadoID = V.vac_EmpleadoID
        WHERE V.vac_Estatus NOT IN ('RECHAZADO', 'DECLINADO') AND V.vac_Estado = 1
        GROUP BY E.emp_Numero, E.emp_Nombre, V.vac_Periodo")->getResultArray();
    }


    //Guarda los reportes de reportes de horas extra
    public function ajaxAddReporteHorasExtras()
    {
        $post = $this->request->getPost();
        $dias = array();
        $horasXdia = array();

        $totalHoras = 0;

        $semana = explode(' al ', $post['txtFechas']);
        $diaInicio = $semana[0];
        $diaFin = $semana[1];

        for ($i = 0; $i < count($post['fecha']); $i++) {

            $diaSemana = get_nombre_dia($post['fecha'][$i]);
            $horasExtra = calculoHorasExtraxDia($post['fecha'][$i], $diaSemana, $post['horaSalida'][$i], $post['horaRegreso'][$i], (int)session('id'));
            $totalHoras += $horasExtra;

            $row = array(
                "fecha" => $post['fecha'][$i],
                "diaSemana" => $diaSemana,
                "socap" => $post['socap'][$i],
                "horaSalida" => $post['horaSalida'][$i],
                "horaRegreso" => $post['horaRegreso'][$i],
                "motivos" => $post['motivos'][$i],
                "totalHoras" => $horasExtra,
            );
            array_push($dias, $row);

            $row2 = array(
                "fecha" => $post['fecha'][$i],
                "horaInicio" => $post['horaSalida'][$i],
                "horaFin" => $post['horaRegreso'][$i],
            );
            array_push($horasXdia, $row2);
        }

        $reporte = array(
            'rep_FechaRegistro' => date('Y-m-d'),
            'rep_EmpleadoID' => (int)session('id'),
            'rep_Semana' => $post['txtFechas'],
            'rep_DiaInicio' => $diaInicio,
            'rep_DiaFin' => $diaFin,
            'rep_Dias' => json_encode($dias),
            'rep_Horas' => $totalHoras,
            'rep_HorasPorDia' => json_encode($horasXdia),
        );

        $builder = db()->table("reportehoraextra");
        $builder->insert($reporte);
        $data['code'] = $this->db->insertID() ? 1 : 0;

        echo json_encode($data, JSON_UNESCAPED_SLASHES);
    } //end ajaxAddReporteHorasExtras

    public function getReportesHorasExtras()
    {
        $estatus = array('AUTORIZADO', 'RECHAZADO_RH', 'APLICADO', 'PAGADO', 'DECLINADO');
        $estatus = join("','", $estatus);

        $query = "SELECT REP.*, EMP.emp_Nombre,SUC.suc_Sucursal FROM reportehoraextra REP
                    JOIN empleado EMP ON REP.rep_EmpleadoID = EMP.emp_EmpleadoID
                    JOIN sucursal SUC ON SUC.suc_SucursalID=EMP.emp_SucursalID
                  WHERE  REP.rep_Estado IN ('$estatus') AND REP.rep_Estatus=1";
        $consulta = $this->db->query($query);

        return ($consulta) ? $consulta->getResultArray() : null;
    } //end getReportesHorasExtras

}
