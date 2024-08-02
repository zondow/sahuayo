<?php

namespace App\Models;

use CodeIgniter\Model;

class ConfiguracionModel extends Model
{
    //Diego->Trae los roles
    public function getRoles()
    {
        return $this->db->query("SELECT rol_RolID,rol_Nombre,rol_Permisos,rol_Estatus FROM rol WHERE rol_Estatus=1")->getResultArray();
    } //getRoles

    //Lia -> Obtiene la informacion de un rol por su id
    public function getRolByID($rolID)
    {
        return $this->db->query("SELECT R.* FROM rol R WHERE R.rol_RolID=?", array(encryptDecrypt('decrypt', $rolID)))->getRowArray();
    } //getRolByID

    //Lia -> Obtiene las funciones del sistema y las acciones que se pueden hacer para esa funcion
    public function getPermisosByRol($rolID)
    {
        $sql = "SELECT *
        FROM funcion F
        WHERE F.fun_Estatus=1 order by fun_Modulo asc ";
        $funciones = $this->db->query($sql)->getResultArray();
        $sql = "SELECT R.rol_Permisos
        FROM rol R
        WHERE R.rol_RolID=?";
        $permisos = $this->db->query($sql, array(encryptDecrypt('decrypt', $rolID)))->getRowArray();
        $permisos = json_decode($permisos['rol_Permisos']);
        $data = array(
            'funciones' => $funciones,
            'permisos'  => $permisos,
        );
        return $data;
    } //getPermisosByRol

    //HUGO->Get configuracion de permisos
    public function getConfiguracionPermisos()
    {
        return $this->db->query("select * from catalogopermiso")->getResultArray();
    } //getConfiguracionPermisos

    //HUGO->Get configuracion permisos por id
    public function getConfiguracionPermisosById($id)
    {
        return $this->db->query("select * from catalogopermiso where cat_CatalogoPermisoID = ?", array((int)encryptDecrypt('decrypt', $id)))->getRowArray();
    } //getConfiguracionPermisosById

    //HUGO->Get schedule
    public function getScheduleByID($scheduleID)
    {
        return $this->db->query('select * from horario where hor_HorarioID = ?', array((int)$scheduleID))->getRowArray();
    } //getScheduleByID

    //Diego-> get checklist ingreso y egreso
    public function getChecklistIngresoEgreso()
    {
        $sql = "select CC.cat_CatalogoID as 'id', CC.cat_Nombre as 'name', CC.cat_Estatus as 'status', CC.cat_Tipo as 'tipo', CC.cat_ResponsableID as 'responsable' from catalogochecklist CC";
        return $this->db->query($sql)->getResultArray();
    } //getChecklistIngresoEgreso

    //Diego->get checlist by id
    public function getChecklistByID($id)
    {
        $sql = 'select * from catalogochecklist where cat_CatalogoID = ?';
        return $this->db->query($sql, array($id))->getRowArray();
    } //getChecklistByID

    //Lia->Trae la configuracion de las vacaciones, aguinaldo, porcentaje de prima actual
    public function getConfiguracionPrestacionesActuales()
    {
        $builder = db()->table("vacacionconfig");
        $response = $builder->getWhere(array("vco_Tipo" => 'Actual'));
        return ($response) ? $response->getRowArray() : null;
    } //end getConfiguracionPrestacionesActuales

    //Lia->Trae las prestaciones de puntualidad
    public function getPrestacionAdicional()
    {
        $response = $this->db->query("SELECT * FROM prestacion");
        return ($response) ? $response->getRowArray() : null;
    } //end getPrestacionAdicional

    //Diego - traer los expedientes
    public function getExpedientes()
    {
        return $this->db->query("SELECT * FROM expediente order by exp_Categoria,exp_Numero ASC")->getResultArray();
    } //end getExpedientes

}
