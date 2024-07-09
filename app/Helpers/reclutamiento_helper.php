<?php
defined('FCPATH') OR exit('No direct script access allowed');
//Germán -> Actualiza el estatus de la solicitud de personal
function cambiarEstatusSolicitudPersonal($idSolicitud, $estatus, $obj){
    $obj->db->update("solicitudpersonal", array("sol_Estatus" => $estatus), array("sol_SolicitudPersonalID" => $idSolicitud));
    if($obj->db->affected_rows() > 0) {
        /*$sql = "SELECT E.emp_Correo FROM empleado E
                JOIN vacacion V ON V.vac_EmpleadoID=E.emp_EmpleadoID
                WHERE  V.vac_VacacionesID=".$idVacaciones;
        $correos[] = $obj->db->query($sql)->row_array()['emp_Correo'];
        
        $sql = "SELECT E.emp_Correo,E.emp_Nombre AS 'NombreJefe', P.pue_Nombre 'NombrePuesto' FROM empleado E, puesto P
                WHERE  E.emp_PuestoID=P.pue_PuestoID AND E.emp_EmpleadoID=".$obj->session->userdata("id");
        $jefe = $obj->db->query($sql)->row_array();
        $correos[] = $jefe['emp_Correo'];

        $sql = "SELECT EMP.emp_Correo as 'Correo',EMP.emp_Nombre as 'NombreEmp', VAC.* FROM vacacion VAC
                JOIN empleado EMP ON VAC.vac_EmpleadoID = EMP.emp_EmpleadoID
                WHERE VAC.vac_VacacionesID =" .$idVacaciones;
        $datos = $obj->db->query($sql)->row_array();

        $datos['NombreJefe'] = $jefe['NombreJefe'];
        $datos['NombrePuesto'] = $jefe['NombrePuesto'];
        //Enviar correo
        sendMail($correos,'VACACIONES APROBADAS POR JEFE INMEDIATO.', $datos,'VacacionJefe');*/

        return TRUE;
    }else return FALSE;
}//end cambiarEstatusSolicitudPersonal

//Obtiene si el empleado es quien debe autorizar la solicitud de personal
function isQuienAutorizaSolicitudPersonal($idSolicitud, $obj){
    $idEmpleado = $obj->session->userdata("id");

    $autoriza = $obj->db->get_where("solicitudpersonal", array("sol_SolicitudPersonalID" => (int)$idSolicitud))->row_array()['sol_Autoriza'];
    return ($idEmpleado == $autoriza) ? TRUE : FALSE ;
}