<?php
defined('FCPATH') OR exit('No direct script access allowed');
//Germán -> vacaciones: obtener los días ocupados
function diasDisfrutar($fechaInicio, $fechaFin){
   $fechaInicio = date_create($fechaInicio);
   $fechaFin = date_create($fechaFin);

   $days = date_diff($fechaInicio, $fechaFin);

    return $days->days + 1;
}