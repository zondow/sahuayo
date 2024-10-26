<?php

namespace App\Models;

use CodeIgniter\Model;

class PersonalModel extends Model
{
    //Diego - traer expediente
    public function getDatosExpediente()
    {
        return $this->db->query("SELECT * FROM expediente WHERE exp_Estatus=1 ORDER BY exp_Categoria,exp_Numero ASC ")->getResultArray();
    } //end getDatosExpediente

    //Lia->documentos de la categoria 1 'Externos'
    public function getDocumentosC1()
    {
        return $this->db->query("SELECT * FROM expediente WHERE exp_Estatus=1
                           AND exp_Categoria='Externos' ORDER BY exp_Numero ASC")->getResultArray();
    }

    //Lia->documentos de la categoria 2 'Internos'
    public function getDocumentosC2()
    {
        return $this->db->query("SELECT * FROM expediente WHERE exp_Estatus=1
                           AND exp_Categoria='Internos' ORDER BY exp_Numero ASC")->getResultArray();
    }

    //Lia -> trae los colaboradores de la empresa
    public function getColaboradores()
    {
        $sql = "
        SELECT 
        E.emp_EmpleadoID,
        E.emp_Numero,
        E.emp_Nombre,
        JEFE.emp_Nombre as 'jefe',
        E.emp_Correo,
        P.pue_Nombre,
        D.dep_Nombre,
        S.suc_Sucursal,
        E.emp_Direccion,
        E.emp_Curp,
        E.emp_Rfc,
        E.emp_Nss,
        E.emp_EstadoCivil,
        E.emp_FechaIngreso,
        E.emp_FechaNacimiento,
        E.emp_Telefono,
        E.emp_Celular,
        E.emp_Sexo,
        E.emp_SalarioMensual,
        E.emp_SalarioMensualIntegrado,
        E.emp_CodigoPostal,
        E.emp_Municipio,
        E.emp_EntidadFederativa,
        E.emp_Pais,
        E.emp_EstatusContratacion,
        E.emp_TipoPrestaciones,
        IF(E.emp_Rol>0,R.rol_Nombre,'Colaborador') As emp_Rol,
        IF(E.emp_HorarioID>0,H.hor_Nombre,'Sin horario asignado') AS emp_Horario,
        E.emp_NumeroEmergencia,
        E.emp_NombreEmergencia,
        E.emp_Parentesco
        FROM empleado E
            LEFT JOIN puesto P ON P.pue_PuestoID =   E.emp_PuestoID
            LEFT JOIN departamento D ON D.dep_DepartamentoID = E.emp_DepartamentoID
            LEFT JOIN empleado JEFE ON JEFE.emp_Numero=E.emp_Jefe
            LEFT JOIN sucursal S ON S.suc_SucursalID=E.emp_SucursalID
            LEFT JOIN rol R ON R.rol_RolID=E.emp_Rol
            LEFT JOIN horario H ON H.hor_HorarioID=E.emp_HorarioID
        WHERE E.emp_Estatus = 1";
        $colaboradores = $this->db->query($sql)->getResultArray();
        $data = array();
        foreach ($colaboradores as $colaborador) {
            $colaborador['emp_Foto'] = fotoPerfil(encryptDecrypt('encrypt', $colaborador['emp_EmpleadoID']));
            $colaborador['emp_EmpleadoID'] = encryptDecrypt('encrypt', $colaborador['emp_EmpleadoID']);
            array_push($data, $colaborador);
        }
        return $data;
    } //end getColaboradoresByEmpresa

    //Lia->Trae la info de un colaborador
    public function getInfoColaboradorByID($colaboradorID)
    {
        $sql = 'select * from empleado  where emp_EmpleadoID = ? ';
        $data = $this->db->query($sql, array((int)encryptDecrypt('decrypt', $colaboradorID)))->getRowArray();
        $data['emp_AreaID'] = encryptDecrypt('encrypt', $data['emp_AreaID']);
        $data['emp_DepartamentoID'] = encryptDecrypt('encrypt', $data['emp_DepartamentoID']);
        $data['emp_PuestoID'] = encryptDecrypt('encrypt', $data['emp_PuestoID']);
        $data['emp_HorarioID'] = encryptDecrypt('encrypt', $data['emp_HorarioID']);
        $data['emp_Rol'] = encryptDecrypt('encrypt', $data['emp_Rol']);
        $data['emp_SucursalID'] = encryptDecrypt('encrypt', $data['emp_SucursalID']);

        return $data;
    }

    //Lia->Trae los horarios
    public function getHorarios()
    {
        return $this->db->query("select hor_HorarioID,hor_Nombre from horario where hor_Estatus = 1")->getResultArray();
    }

    //Lia->Trae los roles
    public function getRoles()
    {
        return $this->db->query('select * from rol where rol_Estatus = 1 ')->getResultArray();
    } //getRoles

    //Lia -> Obtiene los colaboradores de su empresa que fueron dados de baja
    public function getBajas()
    {
        $sql = "SELECT BE.*, E.*, P.pue_Nombre, D.dep_Nombre,S.suc_Sucursal
              FROM bajaempleado BE
                LEFT JOIN empleado E ON E.emp_EmpleadoID=BE.baj_EmpleadoID
                LEFT JOIN puesto P on P.pue_PuestoID =E.emp_PuestoID
                LEFT JOIN departamento D on D.dep_DepartamentoID = E.emp_DepartamentoID
                LEFT JOIN sucursal S ON E.emp_SucursalID=S.suc_SucursalID
              WHERE  E.emp_Estatus = 0 ORDER BY baj_BajaEmpleadoID ASC ";
        $colaboradores = $this->db->query($sql)->getResultArray();
        foreach ($colaboradores as &$colaborador) {
            $colaborador['entrevista_realizada'] = db()->query("SELECT * FROM entrevistasalida ES WHERE ES.ent_BajaID=? ORDER BY ent_BajaID ASC", array($colaborador['baj_BajaEmpleadoID']))->getRowArray() ?: null;
            $colaborador['baj_BajaEmpleadoID'] = encryptDecrypt('encrypt', $colaborador['baj_BajaEmpleadoID']);
            $colaborador['emp_EmpleadoID'] = encryptDecrypt('encrypt', $colaborador['emp_EmpleadoID']);
            $colaborador['baj_EmpleadoID'] = encryptDecrypt('encrypt', $colaborador['baj_EmpleadoID']);
        }
        return $colaboradores;
    } //end getColaboradoresByEmpresa

    //Diego -> traer estados
    function getEstados()
    {
        return $this->db->query("SELECT * FROM estado ORDER BY est_nombre ASC")->getResultArray();
    } //getEstados

    //Diego -> obtener sucursales activas
    public function getSucursales()
    {
        return $this->db->query("SELECT * FROM sucursal WHERE suc_Estatus=1 ORDER BY suc_Sucursal ASC")->getResultArray();
    } //getSucursales

    //Lia -> trae los empleados
    public function getEmpleadosQuinquenio()
    {
        return $this->db->query("SELECT emp_EmpleadoID, emp_Nombre, emp_Numero, emp_FechaIngreso, suc_Sucursal FROM empleado LEFT JOIN sucursal ON emp_SucursalID=suc_SucursalID WHERE emp_Estatus = 1")->getResultArray();
    } //end getEmpleados

    //Diego-> obtener el checlist por tipo
    public function getChecklist($tipo)
    {
        return $this->db->query("SELECT * FROM catalogochecklist WHERE cat_Estatus=1 AND cat_Tipo=?", [$tipo])->getResultArray();
    } //end getChecklist

    //Diego-> get total checklist tipo
    public function getTotalCheck($tipo, $empleadoID)
    {
        $requeridos = $this->db->query("SELECT cat_CatalogoID FROM catalogochecklist WHERE cat_Requerido=1 AND cat_Tipo='" . $tipo . "'")->getResultArray();
        $data = array();
        foreach ($requeridos as $id) {
            array_push($data, $id['cat_CatalogoID']);
        }
        $totalcheck = $this->db->query("SELECT che_CatalogoChecklistID FROM checklistempleado WHERE che_EmpleadoID=" . $empleadoID)->getRowArray()['che_CatalogoChecklistID'] ?? 0;

        $n = 0;

        if (!empty($totalcheck)) {
            $totalcheck = json_decode($totalcheck);

            foreach ($totalcheck as $tc) {
                if (in_array($tc, $data)) {
                    $n++;
                }
            }
        }
        return $n;
    } //end getTotalChecklist

    //Lia -> Obtiene informacion del empleado
    public function getColaboradorByID($empleadoID)
    {
        $sql = "SELECT *
                FROM empleado E
                LEFT JOIN puesto P ON P.pue_PuestoID=E.emp_PuestoID
                LEFT JOIN departamento D ON D.dep_DepartamentoID=E.emp_DepartamentoID
                WHERE E.emp_EmpleadoID=?";
        return $this->db->query($sql, array(encryptDecrypt('decrypt', $empleadoID)))->getRowArray();
    } //getColaboradorByID

    //Lia -> Datos generales de entrevista de salida
    public function getDatosBajaEntrevista($bajaID)
    {
        $sql = "SELECT
              BA.baj_BajaEmpleadoID AS bajaID,
              E.emp_Nombre AS nombre,
              D.dep_Nombre AS departamento,
              P.pue_Nombre AS puesto,
              E.emp_FechaIngreso AS fechaIngreso,
              J.emp_Nombre AS jefe,
              PJ.pue_Nombre AS puestoJefe,
              BA.baj_EmpleadoID AS empleadoID
            FROM bajaempleado BA
            LEFT JOIN empleado E ON E.emp_EmpleadoID = BA.baj_EmpleadoID
            LEFT JOIN departamento D ON D.dep_DepartamentoID = E.emp_DepartamentoID
            LEFT JOIN puesto P ON P.pue_PuestoID = E.emp_PuestoID
            LEFT JOIN empleado J ON J.emp_Numero = E.emp_Jefe
            LEFT JOIN puesto PJ ON PJ.pue_PuestoID = J.emp_PuestoID
            WHERE BA.baj_BajaEmpleadoID = ?";

        $data = $this->db->query($sql, [(int) encryptDecrypt('decrypt', $bajaID)])->getRowArray();

        return array_map(fn ($value) => encryptDecrypt('encrypt', $value), [
            'bajaID' => $data['bajaID'],
            'empleadoID' => $data['empleadoID']
        ]) + $data;
    } //getDatosBajaEncuesta

    //Diego -> total checklist salida
    public function getTotalCheckSalida_old($tipo, $empleadoID)
    {
        $requeridos = $this->db->query("SELECT cat_CatalogoID FROM catalogochecklist WHERE cat_Requerido=1 AND cat_Tipo='" . $tipo . "'")->getResultArray();
        $data = array();
        foreach ($requeridos as $id) {
            array_push($data, $id['cat_CatalogoID']);
        }
        $totalcheck = $this->db->query("SELECT che_CatalogoChecklistSalidaID FROM checklistempleado WHERE che_EmpleadoID=" . $empleadoID)->getRowArray()['che_CatalogoChecklistSalidaID'] ?? null;

        $n = 0;

        if (!empty($totalcheck)) {
            $totalcheck = json_decode($totalcheck);

            foreach ($totalcheck as $tc) {
                if (in_array($tc, $data)) {
                    $n++;
                }
            }
        }
        return $n;
    }

    public function getTotalCheckSalida($tipo, $empleadoID)
    {
        $requeridos = array_column(
            $this->db->query("SELECT cat_CatalogoID FROM catalogochecklist WHERE cat_Requerido=1 AND cat_Tipo=?", [$tipo])->getResultArray(),
            'cat_CatalogoID'
        );

        $totalcheck = json_decode(
            $this->db->query("SELECT che_CatalogoChecklistSalidaID FROM checklistempleado WHERE che_EmpleadoID=?", [$empleadoID])->getRowArray()['che_CatalogoChecklistSalidaID'] ?? '[]'
        );

        return count(array_intersect($totalcheck, $requeridos));
    } //end getTotalChecklistSalida


    public function getChecklistByEmpleado($empleadoID)
    {
        $responsable = json_encode([$empleadoID]);
        return $this->db->query("SELECT GROUP_CONCAT(cat_Nombre SEPARATOR ', ') AS nombres FROM catalogochecklist WHERE JSON_CONTAINS(cat_ResponsableID, ?) AND cat_Estatus = 1", [$responsable])->getRowArray()['nombres'];
    }

    public function getInfoEmpleadoByID($empleadoID)
    {
        return $empleado = $this->db->query("SELECT emp_EmpleadoID,emp_Nombre,pue_Nombre,dep_Nombre,emp_FechaIngreso,emp_Correo FROM empleado
                LEFT JOIN puesto ON pue_PuestoID=emp_PuestoID
                LEFT JOIN departamento ON dep_DepartamentoID=emp_DepartamentoID
            WHERE emp_EmpleadoID=?", array($empleadoID))->getRowArray();
    }

    public function empleadoExiste($empleadoID)
    {
        return $this->db->query("SELECT COUNT(*) AS 'contador' FROM empleado E WHERE E.emp_EmpleadoID=? ", array($empleadoID))->getRowArray();
    }

    public function existeRegistroChecklist($empleadoID){
        return $this->db->query("SELECT * FROM checklistempleado WHERE che_EmpleadoID=?",[$empleadoID])->getRowArray();
    }
}//end PersonalModel