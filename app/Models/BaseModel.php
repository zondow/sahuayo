<?php

namespace App\Models;

use CodeIgniter\Model;

class BaseModel extends Model
{
    public function getSucursales()
    {
        return $this->db->query("SELECT * FROM sucursal WHERE suc_Estatus=1")->getResultArray();
    }

    public function getDepartamentos()
    {
        return $this->db->query("SELECT * FROM departamento WHERE dep_Estatus=1")->getResultArray();
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
        return $this->db->query("SELECT *,suc_Sucursal FROM empleado JOIN sucursal ON emp_SucursalID=suc_SucursalID WHERE emp_Estatus=1 AND emp_Estado='Activo' ORDER BY emp_Nombre ASC")->getResultArray();
    }

    public function getNotificacionesPush()
    {
        return $this->db->query("SELECT * FROM notificacion WHERE not_Estatus=1 AND not_Push=1 AND not_EmpleadoID=" . (int)session("id"))->getResultArray();
    }

    public function getNotificaciones()
    {
        return $this->db->query("SELECT * FROM notificacion WHERE not_Estatus=1 AND not_EmpleadoID=" . (int)session("id"))->getResultArray();
    }

    public function getRH()
    {
        return $this->db->query("SELECT E.emp_EmpleadoID,E.emp_Nombre, E.emp_Correo FROM empleado E WHERE E.emp_Estatus=1 AND E.emp_Rol=1")->getResultArray();
    }

    public function getHorasExtra($empleadoID)
    {
        $queries = [
            "SELECT SUM(rep_Horas) as 'horas' FROM reportehoraextra WHERE rep_Estado='PAGADO' AND rep_TipoPago='Tiempo por tiempo' AND rep_EmpleadoID=?" => 0,
            "SELECT acu_HorasExtra as 'horas' FROM acumulados WHERE acu_EmpleadoID=?" => 0,
            "SELECT SUM(per_Horas) as 'horas' FROM permiso WHERE per_TipoID=7 AND per_Estatus=1 AND per_EmpleadoID=? AND per_Estado IN ('PENDIENTE','PRE-AUTORIZADO', 'AUTORIZADO', 'AUTORIZADO_RH')" => 0
        ];

        foreach ($queries as $query => $default) {
            $result = $this->db->query($query, [$empleadoID])->getRowArray()['horas'] ?? $default;
            $queries[$query] = (float) $result;
        }

        return ($queries[array_keys($queries)[0]] +  $queries[array_keys($queries)[1]]) - $queries[array_keys($queries)[2]];
    }

    public function getHorasAdministrativas($empleadoID)
    {
        $horasAdm = $this->db->query("SELECT acu_DiasAdministrativos FROM acumulados WHERE acu_EmpleadoID=?", [$empleadoID])->getRowArray()['acu_DiasAdministrativos'] ?? 16;
        $horasAdmConsumidas = $this->db->query("SELECT SUM(per_Horas) as horas FROM permiso WHERE per_EmpleadoID = ? AND per_TipoID = 8 AND per_Estatus=1 AND per_Estado NOT IN('RECHAZADO_JEFE','RECHAZADO_RH','DECLINADO') AND ? BETWEEN YEAR(per_FechaInicio) AND YEAR(per_FechaFin)", [$empleadoID, date('Y')])->getRowArray()['horas'] ?? 0;
        return ($horasAdm - $horasAdmConsumidas);
    }

    public function getEmpleadoByID($empleadoID)
    {
        $empleado = $this->db->query("SELECT * FROM empleado WHERE emp_EmpleadoID=?", [$empleadoID])->getRowArray();

        // Eliminar las claves emp_Password y pass si existen en el array
        if (isset($empleado['emp_Password'])) {
            unset($empleado['emp_Password']);
        }
        if (isset($empleado['pass'])) {
            unset($empleado['pass']);
        }

        return $empleado;
    }

    public function getEmpleadoByNumero($empleadoNumero)
    {
        $empleado = $this->db->query("SELECT * FROM empleado WHERE emp_Numero=?", [$empleadoNumero])->getRowArray();

        // Eliminar las claves emp_Password y pass si existen en el array
        if (isset($empleado['emp_Password'])) {
            unset($empleado['emp_Password']);
        }
        if (isset($empleado['pass'])) {
            unset($empleado['pass']);
        }

        return $empleado;
    }

    public function getSucursalByID($sucursalID)
    {
        return db()->query("SELECT * FROM sucursal WHERE suc_SucursalID=?", array($sucursalID))->getRowArray();
    }

    public function getTotalEmpleadosBySucursal($sucursal)
    {
        return $this->db->query("SELECT COUNT(emp_EmpleadoID) as 'empleados' FROM empleado WHERE emp_SucursalID=? AND emp_Estatus=1", array($sucursal))->getRowArray()['empleados'];
    }

    public function getColaboradoresConFoto($sucursalID = null, $departamentoID = null, $puestoID = null, $personaID = null)
    {
        $builder = $this->db->table('empleado E');
        $builder->select('E.emp_EmpleadoID, E.emp_Numero, E.emp_Nombre, JEFE.emp_Nombre as jefe, E.emp_Correo, P.pue_Nombre, D.dep_Nombre, S.suc_Sucursal')
                ->join('puesto P', 'P.pue_PuestoID = E.emp_PuestoID', 'left')
                ->join('departamento D', 'D.dep_DepartamentoID = E.emp_DepartamentoID', 'left')
                ->join('empleado JEFE', 'JEFE.emp_Numero = E.emp_Jefe', 'left')
                ->join('sucursal S', 'S.suc_SucursalID = E.emp_SucursalID', 'left')
                ->where('E.emp_Estatus', 1)
                ->where('E.emp_Estado', 'Activo');

        // Aplicar filtros solo si tienen valores
        if ($sucursalID) {
            $builder->where('S.suc_SucursalID', $sucursalID);
        }
        if ($departamentoID) {
            $builder->where('D.dep_DepartamentoID', $departamentoID);
        }
        if ($puestoID) {
            $builder->where('E.emp_PuestoID', $puestoID);
        }
        if ($personaID) {
            $builder->where('E.emp_EmpleadoID', $personaID);
        }

        $builder->orderBy('E.emp_Nombre', 'ASC');
        $colaboradores = $builder->get()->getResultArray();

        // Agregar la foto y el ID cifrado
        $data = [];
        foreach ($colaboradores as $colaborador) {
            $colaborador['emp_Foto'] = fotoPerfil(encryptDecrypt('encrypt', $colaborador['emp_EmpleadoID']));
            $colaborador['emp_EmpleadoID'] = encryptDecrypt('encrypt', $colaborador['emp_EmpleadoID']);
            $data[] = $colaborador;
        }

        return $data;
    }

    //Lia->Get puestos
    function getPuestos()
    {
        return $this->db->query("SELECT * FROM puesto WHERE pue_Estatus=1 ORDER BY pue_Nombre ASC")->getResultArray();
    } //getPuestos

    //Fer->trae las areas
    function getAreas()
    {
        return $this->db->query("SELECT * FROM area WHERE are_Estatus = 1")->getResultArray();
    } //getArea

    function getVacacionesPermisosPendientes($empleadoID)
    {
        $vacper = $this->db->query("
            SELECT 'Vacaciones' as tipo, vac_FechaInicio as FechaInicio,vac_FechaFin as FechaFin
            FROM vacacion WHERE vac_EmpleadoID = $empleadoID AND vac_Estado = 1 AND vac_Estatus NOT IN ('DECLINADO','AUTORIZADO_RH','RECHAZADO_RH','RECHAZADO')
            UNION
            SELECT 'Permisos' as tipo, per_FechaInicio as FechaInicio, per_FechaFin as FechaFin
            FROM permiso WHERE per_EmpleadoID = $empleadoID AND per_Estatus = 1 AND per_Estado NOT IN ('DECLINADO','AUTORIZADO_RH','RECHAZADO_RH','RECHAZADO_JEFE')")->getResultArray();
            foreach($vacper as &$vp){
                $vp['fechas'] = shortDate($vp['FechaInicio']) . ' a '.shortDate($vp['FechaFin']);
            }
            return $vacper;
    }

    function getMisEmpleados(){
        $empleados = $this->db->query('SELECT emp_EmpleadoID,emp_Numero,emp_Nombre,emp_Correo,pue_Nombre,emp_FechaIngreso 
        FROM empleado 
        LEFT JOIN puesto on emp_PuestoID = pue_PuestoID
        WHERE emp_Jefe = ?',[session('numero')])->getResultArray();
        foreach($empleados as &$emp){
            if (isset($emp['emp_Password'])) {
                unset($emp['emp_Password']);
            }
            if (isset($emp['pass'])) {
                unset($emp['pass']);
            }
        }
        return $empleados;
    }
}
