<?php

namespace App\Models;

use CodeIgniter\Model;

class CatalogosModel extends Model
{

    //Diego ->Get departamentos catalogo
    public function getCatalogoDepartamentos()
    {
        return $this->db->query("SELECT * FROM departamento")->getResultArray();
    } //end getCatalogoDepartamentos


    //Diego -> obtener areas
    public function getAreas()
    {
        $result = $this->db->query("SELECT * FROM area")->getResultArray();
        foreach ($result as &$r) {
            $r['are_AreaID'] = encryptDecrypt('encrypt', $r['are_AreaID']);
        }
        return $result;
    } //end getAreas

    //traer informacion de un area por id
    public function getInfoAreaByID($idArea)
    {
        return $this->db->query("SELECT * FROM area WHERE are_AreaID= ?", array($idArea))->getRowArray();
    } //end getInfoAreaByID


    //Lia->trae los puestos
    public function getPuestos()
    {
        $result = $this->db->query("select * from puesto where  pue_Estatus=1 order by pue_Nombre ASC")->getResultArray();
        $array = array();
        $data = array();
        foreach ($result as $r) {
            $array['pue_PuestoID'] = encryptDecrypt('encrypt', $r['pue_PuestoID']);
            $array['pue_Nombre'] = $r['pue_Nombre'];
            $array['pue_Estatus'] = $r['pue_Estatus'];
            array_push($data, $array);
        }
        return $data;
    } //

    //Lia->trae los puestos
    public function getPuestosDifByID($puestoID)
    {
        $puestoID = encryptDecrypt('decrypt', $puestoID);
        return $this->db->query("select * from puesto where  pue_Estatus=1 AND pue_PuestoID !=" . $puestoID . " order by pue_Nombre ASC")->getResultArray();
    } //

    //Lia->Get competencias puesto
    function getCompetenciasPuesto($puestoID)
    {
        $sql = 'select CP.*, C.com_Nombre, C.com_Tipo,C.com_CompetenciaID
                from competenciapuesto CP
                left join competencia C on C.com_CompetenciaID = CP.cmp_CompetenciaID
                where CP.cmp_PuestoID = ? ORDER BY CP.cmp_CompetenciaPuestoID DESC ';
        return $this->db->query($sql, array((int)encryptDecrypt('decrypt', $puestoID)))->getResultArray();
    } //getCompetenciasPuesto

    
    //Diego -> traer competencias
    function getCompetencias($catalogo=null) {
        $where='';
        if(empty($catalogo)){
            $where = 'WHERE com_Estatus=1';
        }
        return $this->db->query("SELECT * FROM competencia ".$where." ORDER BY com_Nombre ASC")->getResultArray();
    }//getCompetencias

    //Lia->Esta asignada la competencia
    function competenciaAsignada($puesto, $competencia)
    {
        $sql = "select count(*) as 'total' from competenciapuesto where cmp_PuestoID = ? and cmp_CompetenciaID = ?";
        $total = $this->db->query($sql, array((int)encryptDecrypt('decrypt', $puesto), (int)$competencia))->getRowArray();
        return (int)$total['total'];
    } //competenciaAsignada

    //Lia->Asignar competencia a puesto
    function asignarCompetenciaPuesto($puestoID, $competenciaID, $nivel)
    {
        $cmp = array(
            "cmp_PuestoID" => (int)encryptDecrypt('decrypt', $puestoID),
            "cmp_CompetenciaID" => (int)$competenciaID,
            "cmp_Nivel" => (int)$nivel
        );
        $builder = db()->table("competenciapuesto");
        return $builder->insert($cmp);
    } //asignarCompetenciaPuesto

    //Lia->Eliminar competencia del puesto
    function eliminarCompetenciasPuesto($id)
    {
        $where = array("cmp_CompetenciaPuestoID" => (int)$id);
        $builder = db()->table("competenciapuesto");
        return $builder->delete($where);
    } //eliminarCompetenciasPuesto

    //Lia-> Perfil de puesto por ID
    function getPerfilPuestoId($idpuesto)
    {
        $perfilID = (int)$idpuesto;
        $sql = "select
                  P.per_PerfilPuestoID as 'id',
                  PU.pue_Nombre as 'puesto',
                  P.per_PuestoCoordina as 'puestosCoordina',
                  P.per_Horario as 'horario',
                  P.per_PuestoRepota as 'puestosReporta',
                  P.per_Objetivo as 'objetivo',
                  P.per_Genero as 'genero',
                  P.per_Edad as 'edad',
                  P.per_EstadoCivil as 'estadoCivil',
                  P.per_Idioma as 'idioma',
                  P.per_IdiomaNivel as 'idiomaNivel',
                  P.per_AnosExperiencia as 'aniosExperiencia',
                  P.per_Escolaridad as 'escolaridad',
                  D.dep_Nombre as 'departamento',
                  P.per_Funcion as 'funciones',
                  P.per_TipoContrato as 'tipoContrato',
                  P.per_FechaCreacion as 'fechaCreacion'
                from perfilpuesto P
                  left join puesto PU on PU.pue_PuestoID =  P.per_PuestoID
                  left join departamento D on D.dep_DepartamentoID =  P.per_DepartamentoID
                where P.per_Estatus = 1 and  P.per_PuestoID = ?";
        return $this->db->query($sql, array($perfilID))->getRowArray();
    } //getPerfilPuestoid

    //Lia->Get puestos a coordinar y/o reportar (perfil de puesto)
    function getPuestosCoordinaReporta($puestos)
    {
        $sql = "select P.pue_Nombre as 'puesto' from puesto P where P.pue_Estatus = 1 and P.pue_PuestoID in (" . $puestos . ")";
        return $this->db->query($sql)->getResultArray();
    } //getPuestosCoordina

    //Diego ->Get departamentos catalogo
    public function getDepartamentos()
    {
        return $this->db->query("select * from departamento where dep_Estatus=1")->getResultArray();
    } //end getDepartamentos

    //Diego->get sucursales
    public function getSucursales()
    {
        return $this->db->query("SELECT * FROM sucursal ")->getResultArray();
    } //getSucursales

    public function getInfoPuestoByID($pue_PuestoID)
    {
       return $this->db->query("Select * from puesto where pue_Estatus=1 and pue_PuestoID=?", array(encryptDecrypt('decrypt', $pue_PuestoID)))->getRowArray();
    }

    public function getPerfilPuestoByPuestoId($pue_PuestoID)
    { 
        return $this->db->query("select * from perfilpuesto where per_PuestoID=" . (int)encryptDecrypt('decrypt', $pue_PuestoID))->getRowArray();
    }

    //Diego -> traer estados
    function getDatosProveedores()
    {
        return $this->db->query("SELECT * FROM proveedor ORDER BY pro_Nombre ASC")->getResultArray();
    } //getEstados

    //Diego -> traer proveedores
    public function getProveedores(){
        return $this->db->query("SELECT * FROM proveedor WHERE pro_Estatus=1")->getResultArray();
    }//getProveedores

    //Diego -> traer instructores
    function getInstructores()
    {
        return $this->db->query("SELECT *, emp_Nombre as 'ins_Nombre' FROM instructor JOIN empleado ON ins_EmpleadoID=emp_EmpleadoID ")->getResultArray();
    } //getInstructores

    //Diego -> traer cursos
    function getCursos()
    {
        return $this->db->query("SELECT * FROM curso ORDER BY cur_Nombre ASC")->getResultArray();
    } //getCursos


}//end CatalogosModel
