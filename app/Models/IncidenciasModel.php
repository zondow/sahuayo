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














    //Diego->Dias incapacidades por empleado
    public function getIncapacidadesByEmpleado()
    {
        return $this->db->query("SELECT * FROM incapacidad JOIN empleado ON emp_EmpleadoID=inc_EmpleadoID WHERE inc_EmpleadoID=" . session('id'))->getResultArray();
    } // end getIncapacidadesByEmpleado

    //Diego->Dias incapacidades por empleado
    public function getSolicitudIncapacidades()
    {
        return $this->db->query("SELECT I.*, E.emp_Nombre FROM incapacidad I JOIN empleado E ON E.emp_EmpleadoID=I.inc_EmpleadoID")->getResultArray();
        //return $this->db->query("SELECT * FROM incapacidad JOIN empleado ON  inc_EmpleadoID=emp_EmpleadoID")->getResultArray();
    } // end getIncapacidadesByEmpleado

    //Diego->Dias incapacidades
    public function getIncapacidades()
    {
        return $this->db->query("SELECT * FROM incapacidad JOIN empleado ON  inc_EmpleadoID=emp_EmpleadoID")->getResultArray();
    } // end getDiasInhabiles

    //Lia -> trae los empleados de su empresa
    public function getEmpleados()
    {
        return $this->db->query("SELECT emp_EmpleadoID, emp_Nombre, emp_FechaIngreso, emp_Numero, suc_Sucursal FROM empleado JOIN sucursal ON emp_SucursalID=suc_SucursalID WHERE emp_Estatus = 1 ORDER BY emp_Nombre ASC ")->getResultArray();
    } //end getEmpleados

    //Lia->Trae las actas administrativas por empresa
    public function getActasAdministrativas()
    {
        $sql = "SELECT A.*, E.emp_Nombre,E.emp_Numero, S.suc_Sucursal FROM actaadministrativa A JOIN empleado E ON E.emp_EmpleadoID=A.act_EmpleadoID JOIN sucursal S ON S.suc_SucursalID = E.emp_SucursalID ORDER BY A.act_FechaRealizo ASC";
        return $this->db->query($sql)->getResultArray();
    } //end getActasAdministrativas

    //Lia->Trae las actas administrativas por empresa
    public function getActasAdministrativasByColaborador()
    {
        $sql = "SELECT A.*, E.emp_Nombre,E.emp_Numero FROM actaadministrativa A JOIN empleado E ON E.emp_EmpleadoID=A.act_EmpleadoID WHERE act_EmpleadoID=" . session('id') . " ORDER BY A.act_FechaRealizo ASC";
        return $this->db->query($sql)->getResultArray();
    } //end getActasAdministrativasByColaborador

    public function getActasAdministrativasMisColaboradores()
    {

        $sql = "SELECT A.*, E.emp_Nombre,E.emp_Numero,E.emp_Jefe FROM actaadministrativa A JOIN empleado E ON E.emp_EmpleadoID=A.act_EmpleadoID WHERE emp_Jefe=" . session('numero') . " ORDER BY A.act_FechaRealizo ASC";
        return $this->db->query($sql)->getResultArray();
    } //end getActasAdministrativasMisColaboradores

    public function getIncapacidadesMisColaboradores()
    {
        $sql = "SELECT I.*, E.emp_Nombre,E.emp_Numero,E.emp_Jefe FROM incapacidad I JOIN empleado E ON E.emp_EmpleadoID=I.inc_EmpleadoID WHERE emp_Jefe=" . session('numero');
        return $this->db->query($sql)->getResultArray();
    } //end getActasIncapacidadesMisColaboradores







    //HUGO -> Obtiene todos los permisos de un empleado
    public function getPermisosByEmpleado($empleadoID)
    {
        $sql = "select P.*, CP.cat_Nombre as 'tipoPermiso'
                from permiso P
                left join catalogopermiso CP on CP.cat_CatalogoPermisoID = P.per_TipoID
                where P.per_EmpleadoID = ? and P.per_Estatus = 1 order by P.per_PermisoID desc";
        return $this->db->query($sql, $empleadoID)->getResultArray();
    } //getPermisosByEmpleado

    //HUGO->Get tipo de permiso por id
    public function getCatalogoPermisosById($id)
    {
        return $this->db->query("select * from catalogopermiso where cat_CatalogoPermisoID = ?", array($id))->getRowArray();
    } //getCatalogoPermisosById

    //HUGO->Get dias tomados por tipo de permiso
    public function getDiasTomadosByTipoPermiso($tipoID)
    {
        $sql = "select sum(per_DiasSolicitados) as 'dias' from permiso
                where per_TipoID = ? and per_Estatus = 1 and YEAR(per_Fecha) = ?
                and per_Estado in('PENDIENTE','AUTORIZADO','AUTORIZADO_RH') AND per_EmpleadoID = ?";
        $dias = $this->db->query($sql, array((int)$tipoID, (int)date('Y'), session('id')))->getRowArray();
        return $dias['dias'];
    } //getDiasTomadosByTipoPermiso

    //HUGO -> Obtiene todos los permisos pendientes de los subordinados
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

    //HUGO -> Obtiene todos los permisos de los empleados de una empresa que fueron autorizados por el jefe
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

    public function getHorasExtraByEmpleado()
    {
        $sql = "SELECT * FROM reportehoraextra WHERE rep_EmpleadoID AND rep_Estatus=1 AND rep_EmpleadoID=" . session('id');
        return $this->db->query($sql)->getResultArray();
    } //end getHorasExtraByEmpleado

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

    public function getHorasMisEmpleadosJefe($numJefe)
    {
        if ($numJefe !== '0') {
            $estatus = array("PENDIENTE", 'AUTORIZADO', 'RECHAZADO', 'RECHAZADO_RH', 'APLICADO', 'PAGADO', 'DECLINADO');
            $estatus = join("','", $estatus);
            $where = "";
            $where2 = "";
            if (!is_null($numJefe)) {
                $where = " WHERE EMP.emp_Jefe = '$numJefe'";
            }
            if (session('id') == 19) {
                $where2 = ' OR (REP.rep_EmpleadoID=7)';
            }

            $query = "SELECT REP.*, EMP.emp_Nombre FROM reportehoraextra REP
                        JOIN empleado EMP ON REP.rep_EmpleadoID = EMP.emp_EmpleadoID
                      WHERE  REP.rep_Estado IN ('$estatus') AND REP.rep_Estatus=1 AND REP.rep_EmpleadoID IN
                        (SELECT EMP.emp_EmpleadoID FROM empleado EMP $where $where2) ORDER BY FIELD(REP.rep_Estado, 'PENDIENTE', 'AUTORIZADO', 'RECHAZADO', 'RECHAZADO_RH', 'APLICADO','PAGADO','DECLINADO') ASC
                      ";
            $consulta = $this->db->query($query);
        } else {
            $estatus = array('AUTORIZADO', 'RECHAZADO', 'RECHAZADO_RH', 'APLICADO', 'PAGADO', 'DECLINADO');
            $estatus = join("','", $estatus);
            $query = "SELECT REP.*, EMP.emp_Nombre FROM reportehoraextra REP
                        JOIN empleado EMP ON REP.rep_EmpleadoID = EMP.emp_EmpleadoID
                    WHERE  REP.rep_Estado IN ('$estatus') AND REP.rep_Estatus=1";
            $consulta = $this->db->query($query);
        }

        return ($consulta) ? $consulta->getResultArray() : null;
    } //end getHorasMisEmpleadosJefe

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

    //Lia->salidas del colaborador
    public function getSalidassByEmpleado($idEmpleado)
    {
        return $this->db->query("SELECT * FROM reportesalida WHERE rep_EmpleadoID=? AND rep_Estatus=1", [$idEmpleado])->getResultArray();
    } //end getSalidassByEmpleado

    //Lia-> trae las cooperativas
    public function getSucursal()
    {
        return $this->db->query("SELECT * FROM sucursal WHERE suc_Estatus=1")->getResultArray();
    } //end getSucursal

    //Diego -> obtener salidas de mis empleados
    public function getSalidasMisEmpleados($numJefe)
    {
        $estatus = array("PENDIENTE", 'AUTORIZADO', 'RECHAZADO', 'RECHAZADO_RH', 'APLICADO');
        $estatus = join("','", $estatus);
        if (!is_null($numJefe)) {
            $where = " WHERE EMP.emp_Jefe = $numJefe";
        } else $where = "";

        $query = "SELECT REP.*, EMP.emp_Nombre FROM reportesalida REP
                    JOIN empleado EMP ON REP.rep_EmpleadoID = EMP.emp_EmpleadoID
                  WHERE  REP.rep_Estado IN ('$estatus') AND REP.rep_Estatus=1 AND REP.rep_EmpleadoID IN
                    (SELECT EMP.emp_EmpleadoID FROM empleado EMP $where)
                  ";
        $consulta = $this->db->query($query);

        return ($consulta) ? $consulta->getResultArray() : null;
    } //end getSalidasMisEmpleados

    //Diego->obtener informe salidas rh
    public function getInformesSalidas()
    {
        $query = "SELECT REP.*, EMP.emp_Nombre FROM reportesalida REP
                    JOIN empleado EMP ON REP.rep_EmpleadoID = EMP.emp_EmpleadoID
                  WHERE  REP.rep_Estado IN ('AUTORIZADO', 'RECHAZADO_RH', 'APLICADO') AND REP.rep_Estatus=1";
        $consulta = $this->db->query($query)->getResultArray();
        return $consulta;
    } //end getInformesSalidas
}
