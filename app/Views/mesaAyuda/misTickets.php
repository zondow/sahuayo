<?php defined('FCPATH') or exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-md-12">
        <div class="row">
           
            <div class="col-12">
                <div class="card-box">
                    <div class="col-md-12  mb-2">
                        <button data-toggle="tooltip" data-original-title="Crear ticket" type="button" class="btn btn-icon btn-rounded btn-sm btn-instagram waves-effect waves-light modalCrearTicket" >
                            <i class="fas fa-plus"></i> Crear ticket
                        </button>
                    </div>
                    <div>
                    <table class="table table-hover m-0 table-centered tickets-list table-actions-bar dt-responsive" cellspacing="0" id="tableTickets">
                        <thead>
                        <tr>
                            <th>Acciones</th>
                            <th>ID</th>
                            <th>Servicio</th>
                            <th>Agente</th>
                            <th>Titulo</th>
                            <th>Fecha de Entrega</th>
                            <th>Estatus</th>
                        </tr>
                        </thead>
                            <tbody>
                            <?php
                            if($tickets){
                                foreach($tickets as $ticket){
                                    //Estatus
                                    switch($ticket['tic_Estatus']){
                                        case 'ABIERTO': $badge = 'badge-info'; $estatus = 'ABIERTO'; break;
                                        case 'ESPERA_SOLICITANTE': $badge = 'badge-warning'; $estatus = 'SE REQUIERE INFORMACIÓN'; break;
                                        case 'ESPERA_PROVEEDOR': $badge = 'badge-warning'; $estatus = 'EN ESPERA DEL PROVEEDOR'; break;
                                        case 'RESUELTO': $badge = 'badge-success'; $estatus = 'RESUELTO'; break;
                                        case 'CERRADO': $badge = 'badge-danger'; $estatus = 'CERRADO'; break;
                                    }
                                    //Vencido
                                    $retrasado='';
                                    if($ticket['tic_FechaTerminoPropuesta']){
                                        if(date('Y-m-d H:i:s')>$ticket['tic_FechaTerminoPropuesta'].' 23:59:59' && empty($ticket['tic_FechaHoraTermino'])){
                                            $retrasado = '<br><span class="badge badge-danger p-1">VENCIDO</span>';
                                        }
                                    }
                                    //Agente
                                    $agente ='<td>Sin agente asignado</td>';
                                    if($ticket['tic_AgenteResponsableID']){
                                        $empleadoID= mesa()->query("SELECT age_EmpleadoID FROM agente WHERE age_AgenteID=?",array($ticket['tic_AgenteResponsableID']))->getRowArray()['age_EmpleadoID'];
                                        $nombre = federacion()->query("SELECT emp_Nombre FROM empleado WHERE emp_EmpleadoID=?",array($empleadoID))->getRowArray()['emp_Nombre'];
                                        $foto = fotoPerfilFederacion($empleadoID);
                                        //$foto = base_url("assets/images/monedaAlianza.png");
                                        $agente='<td><a class="text-body"><img class="rounded-circle avatar-sm" src="'.$foto.'" alt="'.$nombre.'" title="'.$nombre.'"><span class="ml-2">'.$nombre.'</span></a></td>';
                                    }
                                    //Fecha de entrega
                                    $fechaTermino='<td><span class="badge badge-dark p-1">Sin fecha propuesta</span></td>';
                                    if($ticket['tic_FechaTerminoPropuesta']){
                                        $fechaTermino='<td><span class="badge badge-dark p-1">'.strtoupper(shortDateTime($ticket['tic_FechaTerminoPropuesta'],' ')).'</span></td>';
                                    }
                                    //Acciones
                                    $acciones="";
                                    $acciones .= '<a href="'.base_url('MesaAyuda/ticket/'.encryptDecrypt('encrypt',$ticket['tic_TicketID'])).'" class="btn btn-icon btn-info btn-sm waves-light waves-effect" title="Ver ticket"><i class="fas fa-eye"></i></a>';
                                    $encuesta= mesa()->query("SELECT COUNT(*) as 'total' FROM encuesta WHERE enc_TicketID=?",array($ticket['tic_TicketID']))->getRowArray()['total'];
                                    if($estatus === "RESUELTO" && $encuesta >0){
                                        $acciones.='<a href="#" class="btn btn-icon  waves-effect waves-light btn-success btnEncuesta" data-id="'.encryptDecrypt('encrypt',$ticket['tic_TicketID']).'"> <i class="mdi mdi-clipboard-check-outline"></i> </a>';
                                    }
                                    echo '<tr>';
                                    echo '<td>'.$acciones.'</td>';
                                    echo '<td>'.$ticket['tic_TicketID'].'</td>';
                                    echo '<td>'.$ticket['are_Nombre'].' - '.$ticket['ser_Servicio'].'</td>';
                                    echo $agente;
                                    echo '<td>'.$ticket['tic_Titulo'].'</td>';
                                    echo $fechaTermino;
                                    echo '<td><span class="badge '.$badge.' p-1">'.$estatus.'</span>'.$retrasado.'</td>';
                                    echo '</tr>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>