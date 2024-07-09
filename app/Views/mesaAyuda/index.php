<?php defined('FCPATH') or exit('No direct script access allowed'); ?>

<div class="row">
    <div class="col-md-12">
        <div class="row">
            <?php
            if(administradorID()){?>
            <div class="col-md-12 text-center mb-3">
                <a href="<?=base_url('MesaAyuda/usuarios')?>" class="card-link text-primary font-16">Alta de usuarios</a>
                <a href="<?=base_url('MesaAyuda/ticketsCoop')?>" class="card-link text-primary font-16">Tickets de mi cooperativa</a>
                <a href="<?=base_url('MesaAyuda/estadisticas')?>" class="card-link text-primary font-16">Dashboard</a>
            </div>
            <?php }?>

            <div class="col-md-12 text-center">
                <img style="width:50px;height:50px" src="<?=base_url('assets/images/alianzito/Alianzito_CallCenter.png')?>"></img>
                <h3 class="mb-2">¿Cómo podemos ayudarte hoy? </h3>
            </div>
            <div class="col-md-12 text-center  mb-2">
                <button data-toggle="tooltip" data-original-title="Crear ticket" type="button" class="btn btn-icon btn-rounded btn-sm btn-instagram waves-effect waves-light modalCrearTicket" >
                    <i class="fas fa-plus"></i> Crear ticket
                </button>
            </div>

            <div class="col-md-6">
                <div class="text-center my-2">
                    <div class="row">
                        <div class="col-sm-6 col-xl-6">
                            <a href=<?=base_url('MesaAyuda/misTickets')?> >
                            <div class="card widget-flat border-dark bg-dark text-white">
                                <div class="card-body">
                                    <i class="fe-tag"></i>
                                    <h3 class="text-white"><?=$totales['total']?></h3>
                                    <p class="text-uppercase font-13 mb-2 font-weight-bold">Tickets totales</p>
                                </div>
                            </div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-xl-6">
                            <a href=<?=base_url('MesaAyuda/misTickets')?> >
                            <div class="card widget-flat border-primary bg-primary text-white">
                                <div class="card-body">
                                    <i class="fe-edit"></i>
                                    <h3 class="text-white"><?=$totales['abiertos']?></h3>
                                    <p class="text-uppercase font-13 mb-2 font-weight-bold">Tickets Abiertos</p>
                                </div>
                            </div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-xl-6">
                            <a href=<?=base_url('MesaAyuda/misTickets')?> >
                            <div class="card widget-flat border-success bg-success text-white">
                                <div class="card-body">
                                    <i class="fe-check"></i>
                                    <h3 class="text-white"><?=$totales['resueltos']?></h3>
                                    <p class="text-uppercase font-13 mb-2 font-weight-bold">Tickets Resueltos</p>
                                </div>
                            </div>
                            </a>
                        </div>
                        <div class="col-sm-6 col-xl-6">
                            <a href=<?=base_url('MesaAyuda/misTickets')?> >
                            <div class="card bg-warning widget-flat border-warning text-white">
                                <div class="card-body">
                                    <i class="fe-clock"></i>
                                    <h3 class="text-white"><?=$totales['espera']?></h3>
                                    <p class="text-uppercase font-13 mb-2 font-weight-bold">Tickets en espera</p>
                                </div>
                            </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row my-2">
                    <div class="col-lg-6">
                        <div class="card-box">
                            <h4 class="header-title mb-3">Tickets pendientes de encuesta</h4>
                            <div class="comment-list slimscroll" style="max-height: 370px;">
                            <?php foreach($ticketsPendientesEncuesta as $ticket){
                                echo '<a href="'.base_url('MesaAyuda/ticket/'.encryptDecrypt('encrypt',$ticket['tic_TicketID'])).'">
                                            <div class="comment-box-item">
                                                <div class="badge badge-pill badge-success">Ticket - #'.$ticket['tic_TicketID'].'</div>
                                                <p class="commnet-item-date">'.shortDate($ticket['tic_FechaHoraTermino']).'</p>
                                                <h6 class="commnet-item-msg">'.$ticket['tic_Titulo'].'</h6>
                                            </div>
                                        </a>';
                            }   ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card-box">
                            <h4 class="header-title mb-3">Tickets Pendientes de respuesta</h4>
                            <div class="comment-list slimscroll" style="max-height: 370px;">
                            <?php foreach($ticketsEsperaRespuesta as $ticket){
                                $ticket['tic_FechaHoraTermino'] = mesa()->query("SELECT DATE(log_Fecha) as 'tic_FechaHoraTermino' FROM logticket WHERE log_TicketID=?",[$ticket['tic_TicketID']])->getRowArray()['tic_FechaHoraTermino'];
                                echo '<a href="'.base_url('MesaAyuda/ticket/'.encryptDecrypt('encrypt',$ticket['tic_TicketID'])).'">
                                            <div class="comment-box-item">
                                                <div class="badge badge-pill badge-success">Ticket - #'.$ticket['tic_TicketID'].'</div>
                                                <p class="commnet-item-date">'.shortDate($ticket['tic_FechaHoraTermino']).'</p>
                                                <h6 class="commnet-item-msg">'.$ticket['tic_Titulo'].'</h6>
                                            </div>
                                        </a>';
                                }   ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>