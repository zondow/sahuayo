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
        $sql = "SELECT E.emp_EmpleadoID, E.emp_Nombre, E.emp_Numero, P.pue_Nombre, D.dep_Nombre, A.are_Nombre,
                  E.emp_Correo, E.emp_Rfc, E.emp_Curp, E.emp_FechaIngreso, E.emp_Celular,E.emp_Estado,E.emp_Jefe,S.suc_Sucursal
                FROM empleado E
                LEFT JOIN puesto P ON P.pue_PuestoID =   E.emp_PuestoID
                LEFT JOIN departamento D ON D.dep_DepartamentoID = E.emp_DepartamentoID
                LEFT JOIN area A ON A.are_AreaID = E.emp_AreaID
                LEFT JOIN sucursal S ON  S.suc_SucursalID = E.emp_SucursalID
                WHERE E.emp_Estatus = 1
                ORDER BY length(E.emp_Numero),E.emp_Numero  ASC ";
        $colaboradores = $this->db->query($sql)->getResultArray();
        $data = array();
        foreach ($colaboradores as $colaborador) {
            $colaborador['emp_Foto'] = $colaborador['emp_EmpleadoID'];
            $colaborador['emp_EmpleadoID'] = encryptDecrypt('encrypt', $colaborador['emp_EmpleadoID']);
            array_push($data, $colaborador);
        }
        return $data;
    } //end getColaboradoresByEmpresa

    //Lia->Trae la info de un colaborador
    public function getInfoColaboradorByID($colaboradorID){
        $sql = 'select * from empleado  where emp_EmpleadoID = ? ';
        $data = $this->db->query($sql,array((int)encryptDecrypt('decrypt',$colaboradorID)))->getRowArray();
        $data['emp_AreaID']=encryptDecrypt('encrypt',$data['emp_AreaID']);
        $data['emp_DepartamentoID']=encryptDecrypt('encrypt',$data['emp_DepartamentoID']);
        $data['emp_PuestoID']=encryptDecrypt('encrypt',$data['emp_PuestoID']);
        $data['emp_HorarioID']=encryptDecrypt('encrypt',$data['emp_HorarioID']);
        $data['emp_Rol']=encryptDecrypt('encrypt',$data['emp_Rol']);
        $data['emp_SucursalID']=encryptDecrypt('encrypt',$data['emp_SucursalID']);
        $data['emp_Municipio']=strtoupper(eliminar_acentos($data['emp_Municipio']));
        return $data;
    }

    //Lia->Get puestos
    function getPuestos()
    {
        return $this->db->query("select * from puesto where pue_Estatus=1 order by pue_Nombre ASC")->getResultArray();
    } //getPuestos

    //Fer->trae las areas
    function getAreas()
    {
        return $this->db->query("select * from area where are_Estatus = 1")->getResultArray();
    } //getArea

    //Lia->trae los departamentos
    function getDepartamentos()
    {
        return $this->db->query("select * from departamento where dep_Estatus = 1")->getResultArray();
    } //getDepartamentos

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
              WHERE  E.emp_Estatus = 0 ORDER BY length(E.emp_Numero),E.emp_Numero  ASC ";
        $colaboradores = $this->db->query($sql)->getResultArray();
        $data = array();
        foreach ($colaboradores as $colaborador) {
            $colaborador['baj_BajaEmpleadoID'] = encryptDecrypt('encrypt', $colaborador['baj_BajaEmpleadoID']);
            $colaborador['emp_EmpleadoID'] = encryptDecrypt('encrypt', $colaborador['emp_EmpleadoID']);
            $colaborador['baj_EmpleadoID'] = encryptDecrypt('encrypt', $colaborador['baj_EmpleadoID']);
            array_push($data, $colaborador);
        }
        return $data;
    } //end getColaboradoresByEmpresa

    //Diego -> traer estados
    function getEstados() {
        return $this->db->query("SELECT * FROM estado ORDER BY est_nombre ASC")->getResultArray();
    }//getEstados

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
    public function getChecklist($tipo){
        return $this->db->query("SELECT * FROM catalogochecklist WHERE cat_Estatus=1 AND cat_Tipo='".$tipo."'")->getResultArray();
    }//end getChecklist

    //Diego-> get total checklist tipo
    public function getTotalCheck($tipo,$empleadoID){
        $requeridos = $this->db->query("SELECT cat_CatalogoID FROM catalogochecklist WHERE cat_Requerido=1 AND cat_Tipo='".$tipo."'")->getResultArray();
        $data=array();
        foreach($requeridos as $id){
            array_push($data,$id['cat_CatalogoID']);
        }
        $totalcheck = $this->db->query("SELECT che_CatalogoChecklistID FROM checklistempleado WHERE che_EmpleadoID=".$empleadoID)->getRowArray()['che_CatalogoChecklistID'] ?? 0;

        $n=0;

        if(!empty($totalcheck )){
        $totalcheck = json_decode($totalcheck);

            foreach($totalcheck as $tc){
                if(in_array($tc,$data)){
                    $n++;
                }
            }
        }
        return $n;
    }//end getTotalChecklist

    //HUGO -> Obtiene informacion del empleado
    public function getColaboradorByID($empleadoID){
        $sql = "SELECT *
                FROM empleado E
                LEFT JOIN puesto P ON P.pue_PuestoID=E.emp_PuestoID
                LEFT JOIN departamento D ON D.dep_DepartamentoID=E.emp_DepartamentoID
                WHERE E.emp_EmpleadoID=?";
        return $this->db->query($sql,array(encryptDecrypt('decrypt',$empleadoID)))->getRowArray();
    }//getColaboradorByID

    //HUGO -> Datos generales de entrevista de salida
    public function getDatosBajaEntrevista($bajaID){
        $sql = "SELECT
                  BA.baj_BajaEmpleadoID AS 'bajaID',
                  E.emp_Nombre AS 'nombre',
                  D.dep_Nombre AS 'departamento',
                  P.pue_Nombre AS 'puesto',
                  E.emp_FechaIngreso AS 'fechaIngreso',
                  J.emp_Nombre AS 'jefe',
                  PJ.pue_Nombre AS 'puestoJefe',
                  BA.baj_EmpleadoID AS 'empleadoID'
                FROM bajaempleado BA
                LEFT JOIN empleado E ON E.emp_EmpleadoID = BA.baj_EmpleadoID
                LEFT JOIN departamento D ON D.dep_DepartamentoID = 	E.emp_DepartamentoID
                LEFT JOIN puesto P ON P.pue_PuestoID = E.emp_PuestoID
                LEFT JOIN empleado J ON J.emp_Numero = E.emp_Jefe
                LEFT JOIN puesto PJ ON PJ.pue_PuestoID = J.emp_PuestoID
                where BA.baj_BajaEmpleadoID = ?";
        $data = $this->db->query($sql,array((int)encryptDecrypt('decrypt',$bajaID)))->getRowArray();
        $data['bajaID']=encryptDecrypt('encrypt',$data['bajaID']);
        $data['empleadoID']=encryptDecrypt('encrypt',$data['empleadoID']);
        return $data;
    }//getDatosBajaEncuesta

    //Diego -> total checklist salida
    public function getTotalCheckSalida($tipo,$empleadoID){
        $requeridos = $this->db->query("SELECT cat_CatalogoID FROM catalogochecklist WHERE cat_Requerido=1 AND cat_Tipo='".$tipo."'")->getResultArray();
        $data=array();
        foreach($requeridos as $id){
            array_push($data,$id['cat_CatalogoID']);
        }
        $totalcheck = $this->db->query("SELECT che_CatalogoChecklistSalidaID FROM checklistempleado WHERE che_EmpleadoID=".$empleadoID)->getRowArray()['che_CatalogoChecklistSalidaID'] ?? null;

        $n=0;

        if(!empty($totalcheck )){
        $totalcheck = json_decode($totalcheck);

            foreach($totalcheck as $tc){
                if(in_array($tc,$data)){
                    $n++;
                }
            }
        }
        return $n;
    }//end getTotalChecklistSalida

}//end PersonalModel