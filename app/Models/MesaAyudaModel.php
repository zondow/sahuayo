<?php

namespace App\Models;

use CodeIgniter\Model;

class MesaAyudaModel extends Model
{

    public function getUsuariosMesa(){
        $usuarios= mesa()->query("SELECT * FROM usuario WHERE usu_Tipo='Thigo' AND usu_CooperativaID=?",array(cooperativaID()))->getResultArray();

        $data=array();
        foreach ($usuarios as $u){
            $empleado=$this->db->query("SELECT E.emp_Nombre, D.dep_Nombre, P.pue_Nombre,E.emp_Estatus FROM empleado E
                                         LEFT JOIN departamento D ON D.dep_DepartamentoID=E.emp_DepartamentoID
                                         JOIN puesto P ON P.pue_PuestoID=E.emp_PuestoID
                                        WHERE E.emp_EmpleadoID=? ",array($u['usu_Identificador']))->getRowArray();
            $u['emp_Nombre']=$empleado['emp_Nombre'];
            $u['dep_Nombre']=$empleado['dep_Nombre'];
            $u['pue_Nombre']=$empleado['pue_Nombre'];
            $u['usu_UsuarioID']=encryptDecrypt('encrypt',$u['usu_UsuarioID']);
            array_push($data,$u);
        }
        return $data;
    }

    public function getAreas(){
        return mesa()->query("SELECT * FROM area WHERE are_Estatus=1 ORDER BY are_Nombre")->getResultArray();
    }

    public function getMisTickets(){
        return mesa()->query("SELECT tic_Estatus,tic_FechaTerminoPropuesta,tic_AgenteResponsableID,tic_FechaTerminoPropuesta,
                                    tic_TicketID,are_Nombre,ser_Servicio,tic_Titulo
                                    FROM ticket
                                    JOIN area ON tic_AreaID=are_AreaID
                                    JOIN servicio ON tic_ServicioID=ser_ServicioID
                                    WHERE tic_UsuarioID=? AND tic_CooperativaID=? ORDER BY tic_TicketID DESC",array(usuarioID(),cooperativaID()))->getResultArray();
    }

    public function getTotalesMisTickets(){
        $total = mesa()->query("SELECT COUNT(tic_TicketID) as 'total' FROM ticket WHERE tic_UsuarioID=? AND tic_CooperativaID=?",array(usuarioID(),cooperativaID()))->getRowArray()['total'];
        $abiertos = mesa()->query("SELECT COUNT(tic_TicketID) as 'total' FROM ticket WHERE tic_Estatus IN('ABIERTO','ESPERA_SOLICITANTE','ESPERA_PROVEEDOR') AND tic_UsuarioID=? AND tic_CooperativaID=?",array(usuarioID(),cooperativaID()))->getRowArray()['total'];
        $resueltos = mesa()->query("SELECT COUNT(tic_TicketID) as 'total' FROM ticket WHERE tic_Estatus IN('RESUELTO','CERRADO') AND tic_UsuarioID=? AND tic_CooperativaID=?",array(usuarioID(),cooperativaID()))->getRowArray()['total'];
        $espera = mesa()->query("SELECT COUNT(tic_TicketID) as 'total' FROM ticket WHERE tic_Estatus IN('ESPERA_SOLICITANTE','ESPERA_PROVEEDOR') AND tic_UsuarioID=? AND tic_CooperativaID=?",array(usuarioID(),cooperativaID()))->getRowArray()['total'];

        $data=array(
            'total'=>$total,
            'abiertos'=> $abiertos,
            'resueltos'=> $resueltos,
            'espera'=> $espera
        );

        return $data;
    }

    public function getInfoTicket($ticketID){
        $ticketID=encryptDecrypt('decrypt',$ticketID);
        return mesa()->query("SELECT * FROM ticket
        JOIN area ON tic_AreaID=are_AreaID
        JOIN servicio ON tic_ServicioID=ser_ServicioID
        JOIN usuario ON usu_UsuarioID=tic_UsuarioID
        WHERE tic_TicketID=?",array($ticketID))->getRowArray();
    }

    public function getcomentariosTicketByID($ticketID){
        return mesa()->query("SELECT * FROM comentarioticket WHERE comt_TicketID=? ORDER BY comt_FechaHora ASC",array($ticketID))->getResultArray();
    }

    public function getTicketsPendienteEncuesta(){
        return mesa()->query("SELECT tic_TicketID,tic_Titulo,DATE(tic_FechaHoraTermino) as 'tic_FechaHoraTermino' FROM ticket LEFT JOIN encuesta ON tic_TicketID=enc_TicketID WHERE tic_UsuarioID=? AND tic_CooperativaID=? AND tic_Estatus='RESUELTO' AND enc_EncuestaID IS NULL",array(usuarioID(),cooperativaID()))->getResultArray();
    }

    public function getTicketsEsperaRespuesta(){
        return mesa()->query("SELECT tic_TicketID,tic_Titulo FROM ticket WHERE tic_Estatus='ESPERA_SOLICITANTE' AND tic_UsuarioID=? AND tic_CooperativaID=?",array(usuarioID(),cooperativaID()))->getResultArray();
    }

    public function getTicketsCooperativa(){
        return mesa()->query("SELECT tic_TicketID,usu_Nombre,are_Nombre,ser_Servicio,tic_AgenteResponsableID,tic_Titulo,tic_FechaTerminoPropuesta,tic_Estatus
        FROM ticket
        JOIN usuario ON tic_UsuarioID=usu_UsuarioID
        JOIN servicio ON ser_ServicioID=tic_ServicioID
        JOIN area ON tic_AreaID=are_AreaID WHERE tic_CooperativaID=? ORDER BY tic_TicketID DESC",[cooperativaID()])->getResultArray();
    }

    public function getTotalesTicketsEstadistica(){
       //tickets total
        $tickets=mesa()->query("SELECT * FROM ticket WHERE YEAR(tic_FechaHoraRegistro)=?  AND tic_CooperativaID=?",[date('Y'),cooperativaID()])->getResultArray();
        $ticketsG=mesa()->query("SELECT * FROM ticketgenerico WHERE YEAR(ticg_FechaHoraRegistro)=? AND ticg_Estatus=1  AND ticg_CooperativaID=?",[date('Y'),cooperativaID()])->getResultArray();
        $data=array(
            'normales'=>count($tickets),
            'genericos'=>count($ticketsG),
            'total'=>count($tickets)+count($ticketsG)
        );
        return $data;
    }

    public function getVencidosByAgente(){
        $agentes = mesa()->query("SELECT DISTINCT(age_EmpleadoID) as 'empleado' FROM ticket JOIN agente ON tic_AgenteResponsableID=age_AgenteID WHERE tic_Estatus IN ('ABIERTO','ESPERA_SOLICITANTE','ESPERA_PROVEEDOR') AND tic_FechaTerminoPropuesta < ? AND tic_CooperativaID=?",[date('Y-m-d H:i:s'),cooperativaID()])->getResultArray();
        if($agentes){
            foreach($agentes as $agente){
                $nombre = federacion()->query(" SELECT emp_Nombre FROM empleado WHERE emp_EmpleadoID = ? ", [$agente['empleado']])->getRowArray()['emp_Nombre'];
                $tickets = mesa()->query(" SELECT COUNT(*) as total FROM ticket WHERE tic_AgenteResponsableID = ? AND tic_Estatus IN ('ABIERTO', 'ESPERA_SOLICITANTE', 'ESPERA_PROVEEDOR') AND tic_FechaTerminoPropuesta < ? AND tic_CooperativaID=?", [agenteIDByEmpleadoID($agente['empleado']), date('Y-m-d H:i:s'),cooperativaID()])->getRowArray()['total'];
                $ticketsG = mesa()->query(" SELECT COUNT(*) as total FROM ticketgenerico WHERE ticg_AgenteID = ? AND ticg_Estado='ABIERTO' AND ticg_FechaTerminoPropuesta < ?  AND ticg_Estatus=1 AND ticg_CooperativaID=?", [agenteIDByEmpleadoID($agente['empleado']), date('Y-m-d H:i:s'),cooperativaID()])->getRowArray()['total'];
                $datos[] = array(
                    'foto' => fotoPerfilFederacion($agente['empleado']),
                    'nombre' => $nombre,
                    'tickets' => $tickets+$ticketsG,
                    'empleado'=>encryptDecrypt('encrypt', $agente['empleado'])
                );
                usort($datos, function ($a, $b) {
                    return $b['tickets'] - $a['tickets'];
                });
            }
            return $datos;
        }else return null;
    }

    public function getCalifExperiencia(){
        $result  = mesa()->query("SELECT enc_Satisfaccion, COUNT(*) AS 'tickets' FROM encuesta WHERE YEAR(enc_FechaHora)=? AND MONTH(enc_FechaHora)=? AND enc_CooperativaID= ? GROUP BY enc_Satisfaccion",array(date('Y'),date('m'),cooperativaID()))->getResultArray();
        $total = array_sum(array_column($result, 'tickets'));
        $data = array('positivo' => 0,'neutro' => 0,'negativo' => 0);
        foreach ($result as $row) {
            switch ($row['enc_Satisfaccion']) {
                case 'Positivo': $data['positivo'] = round(($row['tickets'] * 100) / $total, 2); break;
                case 'Neutro': $data['neutro'] = round(($row['tickets'] * 100) / $total, 2); break;
                case 'Negativo': $data['negativo'] = round(($row['tickets'] * 100) / $total, 2); break;
            }
        }
        return $data;
    }


    public function getEmpleados(){
        $empleados = $this->db->query("select * from empleado WHERE emp_Estatus=1 ORDER BY emp_Nombre ASC")->getResultArray();
        $data=array();
        foreach ($empleados as $empleado){
            $empleado['emp_EmpleadoID']=encryptDecrypt('encrypt',$empleado['emp_EmpleadoID']);
            $empleado['emp_Nombre']=$empleado['emp_Nombre'];
            array_push($data,$empleado);
        }
        return $data;
    }//getEmpleados
}