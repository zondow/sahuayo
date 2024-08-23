<?php
defined('FCPATH') OR exit('No direct script access allowed');

//Germán -> Obtiene la configuracion de las vacaciones segun la empresa
function getConfiguracion(){
    $builder = db()->table("vacacionconfig");
    $response = $builder->getWhere(array("vco_Tipo"=>'Actual'))->getRowArray();
    $config = array();

    //Tabla de configuracion
    $diasVacaciones = json_decode($response['vco_DiasVacaciones'], true);

    for($i = 0; $i < count($diasVacaciones); $i++){
        $config['diasVacaciones'][$diasVacaciones[$i]['periodo']] = $diasVacaciones[$i]['dias'];

    }
    return $config;
}

//Lia -> Obtiene la configuracion de las vacaciones segun la empresa
function getConfiguracion2021(){
    $builder=db()->table("vacacionconfig");
    $response = $builder->getWhere(array("vco_Tipo"=>'2021'))->getRowArray();
    $config = array();

    //Tabla de configuracion
    $diasVacaciones = json_decode($response['vco_DiasVacaciones'], true);
    for($i = 0; $i < count($diasVacaciones); $i++){
        $config['diasVacaciones'][$diasVacaciones[$i]['periodo']] = $diasVacaciones[$i]['dias'];
    }
    return $config;
}

//Diego -> Regresa los dias inhabiles
function diasInhabiles($sucursalID){

    $all = '["0"]';

    $sql="SELECT dia_DiaInhabilID as 'id', dia_Fecha as 'dia_Fecha',dia_SucursalID as 'sucursal'
        FROM diainhabil WHERE dia_MedioDia=0
        UNION
        SELECT dial_DiaInhabilLeyID as 'id', dial_Fecha as 'dia_Fecha', '".$all."' as 'sucursal'
        FROM diainhabilley";
    $dias = db()->query($sql)->getResultArray();

    $inhabiles = array();
    foreach ($dias as $dia) {
        $sucursales=json_decode($dia['sucursal']);
        if($sucursales){
            foreach ($sucursales as $sucursal){
                if((int)$sucursal == (int)$sucursalID || (int)$sucursal== 0){
                    array_push($inhabiles, $dia['dia_Fecha']);
                }
            }
        }
    }
    return $inhabiles;
}//end antiguedad

//Germán -> Regresa los años de antiguedad
function antiguedad($emp_fechaIngreso){
    $fi = new DateTime($emp_fechaIngreso);
    $fn = new DateTime('today');
    return $fi->diff($fn)->y;
}//end antiguedad

//Germán -> Regresa la anticipacion
function validAnticipacion($fechaInicio){
    $fi = new DateTime("now");
    $fn = new DateTime($fechaInicio);
    $diff = $fi->diff($fn);

    $days = $diff->d;

    return $days;
}//end antiguedad

//Germán -> Regresa el número de días que tocan por ley
function diasLey($emp_fechaIngreso){
    $anios = antiguedad($emp_fechaIngreso);
    $rango = getSetting('rangos_vacaciones',db());
    $dias = 0;
    $config = getConfiguracion();
    if($anios<=$rango){
        if(array_key_exists($anios,$config['diasVacaciones'])){
            $dias = $config['diasVacaciones'][$anios];
        }
    }else{
        if(array_key_exists($rango,$config['diasVacaciones'])){
            $dias = $config['diasVacaciones'][$rango];
        }
    }
    return $dias;
}//end diasLey

//Diego -> Regresa el número de días pendientes por tomar
function diasPendientes($idEmpleado){
    $builder = db()->table("vacacionempleado");
    $restantes = $builder->getWhere(array("vace_EmpleadoID" => $idEmpleado))->getRowArray()['vace_Dias']??0;
    return $restantes;
}//end diasPendientes

//Diego-> Regresa el numero de dias pendientes por tomar
function diasPendientes_nuevo($idEmpleado){
    if($idEmpleado!=70){
        //Validar los días que le corresponden
        $builder = db()->table("empleado");
        $empleado = $builder->getWhere(array("emp_EmpleadoID" => $idEmpleado))->getRowArray();
        $antiguedad = antiguedad($empleado['emp_FechaIngreso']);
        $diasLey = diasLey($empleado['emp_FechaIngreso']);
        $fechaLanzamiento = '2022-03-31';
        $fechaIngreso=explode('-',$empleado['emp_FechaIngreso']);

        //vacaciones registradas
        $query = "SELECT VAC.vac_Restantes AS 'restantes'
                FROM vacacion VAC
                WHERE VAC.vac_Periodo = ".$antiguedad." AND VAC.vac_Estatus IN ('PENDIENTE','AUTORIZADO','AUTORIZADO_RH')
                    AND VAC.vac_EmpleadoID = ".$idEmpleado."
                ORDER BY VAC.vac_VacacionesID DESC LIMIT 1";
        $result_v = db()->query($query)->getRowArray();

        //thigo acumulados
        $acumuladoVacaciones=db()->query("SELECT acu_Vacaciones,acu_VacacionesInicial FROM acumulados WHERE acu_EmpleadoID=".$idEmpleado)->getRowArray();
        if($acumuladoVacaciones){
            $acumuladoVacaciones['acu_Vacaciones']=$acumuladoVacaciones['acu_Vacaciones'];
        }else{
            $acumuladoVacaciones['acu_Vacaciones']=0;
        }
        $fechaAniversario='2022-'.$fechaIngreso[1].'-'.$fechaIngreso[2];
        $fechaAniversarioMasUnAnio=date("Y-m-d",strtotime($fechaAniversario."+ 1 year"));


        if($fechaAniversario<=$fechaLanzamiento){//Caso 1 antes de la fecha de lanzamiento
            $restantes=$acumuladoVacaciones['acu_Vacaciones'];
        }elseif($fechaAniversario>$fechaLanzamiento && date('Y-m-d')<$fechaAniversario){//Caso 2 despues del lanzamiento pero antes de cumplir un año
            $restantes=$acumuladoVacaciones['acu_Vacaciones'];
        }elseif(date('Y-m-d')>=$fechaAniversario && date('Y-m-d')<$fechaAniversarioMasUnAnio){//Caso 3 aniv despues del lanzamiento y hasta un año
            if(!is_null($result_v)) {
                $restantes = $result_v['restantes'];
            }else{
                $restantes = $diasLey+$acumuladoVacaciones['acu_Vacaciones'];
            }
        }else{//Caso 4 aniversario despues del lanzamiento y despues de 1 año
            if(!is_null($result_v)) {
                $restantes = $result_v['restantes'];
            }else{
                $restantes = $diasLey;
            }

        }
    }else{
        $restantes=0;
    }
    return $restantes;
}

//Germán -> Regresa el número de días que ha ocupado el empleado de vacaciones
function diasOcupados($idEmpleado, $emp_fechaIngreso){
    //Antiguedad
    $periodo = antiguedad($emp_fechaIngreso);

    //Datos Vacaciones
    $query_v = "SELECT SUM(VAC.vac_Disfrutar) as 'usados' FROM vacacion VAC
                WHERE VAC.vac_Estado=1 AND VAC.vac_Estatus IN ('PENDIENTE','AUTORIZADO','AUTORIZADO_RH')  AND VAC.vac_EmpleadoID = $idEmpleado
                    AND VAC.vac_Periodo = $periodo
                ORDER BY VAC.vac_VacacionesID DESC LIMIT 1";
    $result_v = db()->query($query_v)->getRowArray();

    if(!empty($result_v['usados'])){
        $dias = $result_v['usados'];
    }else{
        $dias = 0;
    }
    return $dias;
}// end diasOcupados

//Lia -> Regresa el número de días del periodo de vacaciones
function calculoDias($idVacaciones,$sucursalID, $vacInicio = null, $vacFin = null,$idEmpleado=null){
    $config = getConfiguracion();
    $inhabiles = diasInhabiles($sucursalID);

    if($idVacaciones > 0){
        $builder = db()->table("vacacion");
        $vacaciones = $builder->getWhere( array("vac_VacacionesID" => $idVacaciones))->getRowArray();
        $fechaInicio = new DateTime($vacaciones['vac_FechaInicio']);
        $fechaFin = new DateTime($vacaciones['vac_FechaFin']);
        $idEmpleado=$vacaciones['vac_EmpleadoID'];
    } else {
        $fechaInicio = new DateTime($vacInicio);
        $fechaFin = new DateTime($vacFin);
    }

    $fechaFin = $fechaFin->modify("+1 day");
    $interval = new DateInterval('P1D');
    $daterange = new DatePeriod($fechaInicio, $interval ,$fechaFin);

    $dias = 0;

    foreach($daterange as $date) {
        $descanza=DescansoColaborador($idEmpleado, date_format($date,'Y-m-d'));
        if(date('l', strtotime($date->format("Y-m-d"))) !== 'Sunday'){
            if(!in_array($date->format("Y-m-d"), $inhabiles)) {
                if((int)$descanza == 0) $dias++;
            }
        }
    }

    return $dias;
}//end calculoDias

//Germán -> Inserta en la BD el registro de vacaciones
function crearVacaciones($post){
    $idEmpleado = session('id');
    //Validar los días que le corresponden
    $builder = db()->table("empleado");
    $empleado = $builder->getWhere(array("emp_EmpleadoID" => $idEmpleado))->getRowArray();
    $antiguedad = antiguedad($empleado['emp_FechaIngreso']);
    $restantes = diasPendientes($idEmpleado);
    $pendientes = $restantes - $post['dias'];
    //Contruye el arreglo
    $data = array(
        "vac_EmpleadoID" => $idEmpleado,
        "vac_FechaInicio" => $post['vac_FechaInicio'],
        "vac_FechaFin" => $post['vac_FechaFin'],
        "vac_FechaRegistro" => date("Y-m-d H:i:s"),
        "vac_Observaciones" => $post['vac_Observaciones'],
        'vac_Periodo' => $antiguedad,
        'vac_Disfrutar' => $post['dias'],
        'vac_Restantes' => $pendientes,
    );
    $builder2=db()->table("vacacion");
    $builder2->insert( $data);
    $idVacaciones = db()->insertID();

    if($idVacaciones > 0){
        $builder2=db()->table('vacacionempleado');
        $builder2->update(array('vace_Dias'=>$pendientes,'vace_FechaActualizacion'=>date('Y-m-d H:i:s')),array('vace_EmpleadoID'=>$idEmpleado));
        return TRUE;
    }  else return FALSE;
}//end crearVacaciones

function autorizarVacaciones($idVacaciones, $estatus, $obs)
{
    $empleado = db()->query("SELECT E.emp_Correo, E.emp_Nombre, E.emp_Jefe, E.emp_EmpleadoID 
                    FROM empleado E 
                    JOIN vacacion V ON V.vac_EmpleadoID = E.emp_EmpleadoID 
                    WHERE V.vac_VacacionesID = ?", [$idVacaciones])->getRowArray();

    $data_update = ["vac_Estatus" => $estatus];
    $datos['nombre'] = $empleado['emp_Nombre'];
    $jefe = null;
    $titulo = '';

    switch ($estatus) {
        case "AUTORIZADO":
            $data_update["vac_AutorizaID"] = session('id');
            $jefe = (session('id') == 19) 
                    ? db()->query("SELECT emp_Nombre FROM empleado WHERE emp_EmpleadoID = 19")->getRowArray() 
                    : db()->query("SELECT emp_Nombre FROM empleado WHERE emp_Numero = ?", [$empleado['emp_Jefe']])->getRowArray();
            $titulo = 'Vacaciones Autorizadas';
            $datos['titulo'] = 'Solicitud de Vacaciones';
            $datos['cuerpo'] = 'Mediante el presente se le comunica que el colaborador  ' . $jefe['emp_Nombre'] . ', ha autorizado su solicitud de vacaciones en la plataforma PEOPLE.<br> Para mayor información, revise la solicitud de vacaciones en la plataforma.';
            break;

        case "AUTORIZADO_RH":
            $data_update["vac_AplicaID"] = session('id');
            $aplico = db()->query("SELECT emp_Nombre FROM empleado WHERE emp_EmpleadoID = ?", [session('id')])->getRowArray();
            $titulo = 'Vacaciones Aplicadas';
            $datos['titulo'] = 'Solicitud de Vacaciones';
            $datos['cuerpo'] = 'Mediante el presente se le comunica que el colaborador  ' . $aplico['emp_Nombre'] . ', ha aplicado su solicitud de vacaciones en la plataforma PEOPLE.<br> Para mayor información, revise la solicitud de vacaciones en la plataforma.';
            break;

        case "RECHAZADO":
        case "RECHAZADO_RH":
            $data_update["vac_Justificacion"] = $obs;
            if ($estatus === "RECHAZADO") {
                $data_update["vac_AutorizaID"] = session('id');
                $jefe = db()->query("SELECT emp_Nombre FROM empleado WHERE emp_Numero = ?", [$empleado['emp_Jefe']])->getRowArray();
            } else {
                $data_update["vac_AplicaID"] = session('id');
                $aplico = db()->query("SELECT emp_Nombre FROM empleado WHERE emp_EmpleadoID = ?", [session('id')])->getRowArray();
            }
            rechazarVacaciones($empleado['emp_EmpleadoID'], $idVacaciones);
            $titulo = 'Vacaciones Rechazadas';
            $datos['titulo'] = 'Solicitud de Vacaciones';
            $datos['cuerpo'] = 'Mediante el presente se le comunica que su solicitud de vacaciones ha sido rechazada en la plataforma PEOPLE.<br> Para mayor información, revise la solicitud de vacaciones en la plataforma.';
            break;
    }

    $res = update('vacacion', $data_update, ["vac_VacacionesID" => $idVacaciones]);
    if ($res) {
        sendMail($empleado['emp_Correo'], $titulo, $datos);
        return true;
    }

    return false;
}


//Germán -> Actualiza el estatus de las vacaciones al revisar jefe inmediato
function autorizarVacaciones_old($idVacaciones, $estatus,$obs, $obj){
    if($estatus === "AUTORIZADO"){
        $builder = db()->table("vacacion");
        $builder->update( array("vac_Estatus" => $estatus ), array("vac_VacacionesID" => $idVacaciones));
        if($obj->db->affectedRows() > 0) {
            $sql = "SELECT E.emp_Correo,E.emp_Nombre,E.emp_Jefe FROM empleado E
                JOIN vacacion V ON V.vac_EmpleadoID=E.emp_EmpleadoID
                WHERE  V.vac_VacacionesID=".$idVacaciones;
            $empleado = $obj->db->query($sql)->getRowArray();
            $sql_jefe = "SELECT * FROM empleado WHERE emp_Numero=?";
            $jefe = $obj->db->query($sql_jefe,array($empleado['emp_Jefe']))->getRowArray();
            $datos = array();

            $datos['NombreSolicitante'] = $empleado['emp_Nombre'];
            $datos['NombreJefe'] = $jefe['emp_Nombre'];

            //Enviar correo
            sendMail($empleado['emp_Correo'],'Vacaciones Aprobadas', $datos,'VacacionAutorizada');

            return TRUE;
        }else return FALSE;
    }else if($estatus === "AUTORIZADO_RH"){
        $builder=db()->table("vacacion");
        $builder->update( array("vac_Estatus" => $estatus,'vac_AplicaID'=>session('id')), array("vac_VacacionesID" => $idVacaciones));
        if($obj->db->affectedRows() > 0) {
            $sql = "SELECT E.emp_Correo,E.emp_Nombre FROM empleado E
                JOIN vacacion V ON V.vac_EmpleadoID=E.emp_EmpleadoID
                WHERE  V.vac_VacacionesID=".$idVacaciones;
            $empleado = $obj->db->query($sql)->getRowArray();

            $sql_aplico = "SELECT * FROM empleado WHERE emp_EmpleadoID=?";
            $aplico = $obj->db->query($sql_aplico,array(session('id')))->getRowArray();
            $datos = array();

            $datos['NombreSolicitante'] = $empleado['emp_Nombre'];
            $datos['NombreAplico'] = $aplico['emp_Nombre'];
            //Enviar correo
            sendMail($empleado['emp_Correo'],'Vacaciones Aplicadas', $datos,'VacacionAplicada');
            return TRUE;
        }else return FALSE;
    }else if ($estatus === "RECHAZADO") {
        $builder=db()->table("vacacion");
        $builder->update( array("vac_Estatus" => $estatus,
                                "vac_Justificacion"=>$obs), array("vac_VacacionesID" => $idVacaciones));
        if($obj->db->affectedRows() > 0) {

            $sql = "SELECT E.emp_EmpleadoID, E.emp_Correo,E.emp_Nombre FROM empleado E
                JOIN vacacion V ON V.vac_EmpleadoID=E.emp_EmpleadoID
                WHERE  V.vac_VacacionesID=" . $idVacaciones;
            $empleado = $obj->db->query($sql)->getRowArray();

            $sql_aplico = "SELECT * FROM empleado WHERE emp_EmpleadoID=?";
            $aplico = $obj->db->query($sql_aplico, array(session('id')))->getRowArray();
            $datos = array();

            $datos['NombreSolicitante'] = $empleado['emp_Nombre'];
            $datos['NombreAplico'] = $aplico['emp_Nombre'];
            //Enviar correo
            sendMail($empleado['emp_Correo'], 'Vacaciones Rechazadas', $datos, 'VacacionRechazada');
            rechazarVacaciones($empleado['emp_EmpleadoID'],$idVacaciones,$obj);
            return TRUE;
        }else return FALSE;
    }
}//end autorizarVacaciones

//Diego -> Actualiza los dias restantes de las vacaciones si una solicitud es RECHAZADA
function rechazarVacaciones($idEmpleado, $idVacacion){
    //Generales de la vacacion a borrar
    $vacacionB = db()->table("vacacion")->getWhere( array("vac_VacacionesID" => $idVacacion))->getRowArray();
    //Vacaciones de empleado actuales
    $vacacionEmpleado = db()->table('vacacionempleado')->getWhere(array("vace_EmpleadoID"=>$idEmpleado))->getRowArray();
    //Se regresan los dias de vacaciones al empleado
    update('vacacionempleado',array('vace_Dias'=>($vacacionEmpleado['vace_Dias']+$vacacionB['vac_Disfrutar']),'vace_FechaActualizacion'=>date('Y-m-d H:i:s')), array('vace_EmpleadoID' => $idEmpleado));

}//end rechazarVacaciones

//Germán -> Resta los dias correspondientes
function diasCorrespondientes($idEmpleado, $idVacacion, $emp_fechaIngreso, $obj){
    //Antiguedad
    $periodo = antiguedad($emp_fechaIngreso);

    //Si no hay solicitudes
    $query = "SELECT * FROM vacacion VAC
                  WHERE VAC.vac_EmpleadoID = $idEmpleado AND VAC.vac_Estatus != 'RECHAZADO' AND VAC.vac_VacacionesID < $idVacacion AND VAC.vac_Periodo = $periodo
                  ORDER BY VAC.vac_VacacionesID DESC LIMIT 1";
    $result = $obj->db->query($query)->getRowArray();
    if(count($result) > 0) $correspondientes = $result['vac_Restantes'];
    else {
        $builder=db()->table("vacacion");
        $vacacion = $builder->getWhere( array("vac_VacacionesID" => $idVacacion))->getRowArray();
        $correspondientes = $vacacion['vac_Restantes'] + $vacacion['vac_Disfrutar'];
    }

    return $correspondientes;
}//end diasCorrespondientes



//Lia -> Obtiene la configuracion de la prima
function getConfiguracionPrima(){
    $builder = db()->table("vacacionconfig");
    $response = $builder->getWhere(array("vco_Tipo"=>'Actual'))->getRowArray();
    $config = array();

    //Tabla de configuracion
    $porcentajePrima = json_decode($response['vco_Prima'], true);

    for($i = 0; $i < count($porcentajePrima); $i++){
        $config['porcentajePrima'][$porcentajePrima[$i]['periodoP']] = $porcentajePrima[$i]['prima'];

    }
    return $config;
}

//Lia -> Obtiene la configuracion de la prima  2021
function getConfiguracionPrima2021(){
    $builder=db()->table("vacacionconfig");
    $response = $builder->getWhere(array("vco_Tipo"=>'2021'))->getRowArray();
    $config = array();

    //Tabla de configuracion
    $porcentajePrima = json_decode($response['vco_Prima'], true);
    for($i = 0; $i < count($porcentajePrima); $i++){
        $config['porcentajePrima'][$porcentajePrima[$i]['periodoP']] = $porcentajePrima[$i]['prima'];
    }
    return $config;
}

//Lia-> obtiene el porcentaje de prima segun la antiguedad
function prima($emp_fechaIngreso){
    $fecha=strtotime($emp_fechaIngreso);
    $fechaIngresoC = date("Y-m-d", $fecha);
    $fecha2=strtotime('2020-12-31');
    $fechaComparativa = date("Y-m-d", $fecha2);

    $anios = antiguedad($emp_fechaIngreso);
    $config = getConfiguracionPrima();

    if ($anios >= 4) {
        $prima = $config['porcentajePrima']['4'];
    } else {
        $prima = isset($config['porcentajePrima'][$anios]) ? $config['porcentajePrima'][$anios] : 0;
    }
    
    /*if($fechaIngresoC > $fechaComparativa  ){
        $config = getConfiguracionPrima();

        if($anios >= 1 && $anios <= 10) $prima = $config['porcentajePrima']['1-10'];
        else if($anios >= 11 && $anios <= 20) $prima = $config['porcentajePrima']['11-20'];
        else if($anios >= 21 ) $prima = $config['porcentajePrima']['21-30'];
        else $prima = 0;
    }else{
        $config = getConfiguracionPrima2021( );
        if($anios >= 1 && $anios <= 4) $prima = $config['porcentajePrima']['1-4'];
        else if($anios >= 5 && $anios <= 15) $prima = $config['porcentajePrima']['5-15'];
        else if($anios >= 16 ) $prima = $config['porcentajePrima']['16-30'];
        else $prima = 0;
    }*/

    return $prima;
}


//Lia -> Obtiene la configuracion del aguinaldo
function getConfiguracionAguinaldo(){
    $builder = db()->table("vacacionconfig");
    $response = $builder->getWhere(array("vco_Tipo"=>'Actual'))->getRowArray();
    $config = array();

    //Tabla de configuracion
    $porcentajePrima = json_decode($response['vco_Aguinaldo'], true);

    for($i = 0; $i < count($porcentajePrima); $i++){
        $config['diasAguinaldo'][$porcentajePrima[$i]['periodoA']] = $porcentajePrima[$i]['aguinaldo'];
    }
    return $config;
}

//Lia -> Obtiene la configuracion del aguinaldo 2021
function getConfiguracionAguinaldo2021(){
    $builder=db()->table("vacacionconfig");
    $response = $builder->getWhere(array("vco_Tipo"=>'Actual'))->getRowArray();
    $config = array();

    //Tabla de configuracion
    $porcentajePrima = json_decode($response['vco_Aguinaldo'], true);
    for($i = 0; $i < count($porcentajePrima); $i++){
        $config['diasAguinaldo'][$porcentajePrima[$i]['periodoA']] = $porcentajePrima[$i]['aguinaldo'];
    }
    return $config;
}

//Lia-> obtiene los dias de aguinaldo segun la antiguedad
function aguinaldo($emp_fechaIngreso){
    $fecha=strtotime($emp_fechaIngreso);
    $fechaIngresoC = date("Y-m-d", $fecha);
    $fecha2=strtotime('2020-12-31');
    $fechaComparativa = date("Y-m-d", $fecha2);

    $anios = antiguedad($emp_fechaIngreso);
    $config = getConfiguracionAguinaldo();

    if ($anios >= 10) {
        $aguinaldo = $config['diasAguinaldo']['10'];
    } else {
        $aguinaldo = isset($config['diasAguinaldo'][$anios]) ? $config['diasAguinaldo'][$anios] : 0;
    }

    /*if($fechaIngresoC > $fechaComparativa  ){
        $config = getConfiguracionAguinaldo();

        if($anios >= 1 && $anios <= 5) $aguinaldo = $config['diasAguinaldo']['1-5'];
        else if($anios >= 6 && $anios <= 10) $aguinaldo = $config['diasAguinaldo']['6-10'];
        else if($anios >= 11 && $anios <= 15) $aguinaldo = $config['diasAguinaldo']['11-15'];
        else if($anios >= 16 && $anios <= 20) $aguinaldo = $config['diasAguinaldo']['16-20'];
        else if($anios >= 21 && $anios <= 25) $aguinaldo = $config['diasAguinaldo']['21-25'];
        else if($anios >= 26) $aguinaldo = $config['diasAguinaldo']['26-30'];
        else $aguinaldo = 0;
    }else{
        $config = getConfiguracionAguinaldo2021( );
        if($anios === 1) $aguinaldo = $config['diasAguinaldo']['1'];
        else if($anios === 2) $aguinaldo = $config['diasAguinaldo']['2'];
        else if($anios === 3) $aguinaldo = $config['diasAguinaldo']['3'];
        else if($anios === 4) $aguinaldo = $config['diasAguinaldo']['4'];
        else if($anios === 5)  $aguinaldo = $config['diasAguinaldo']['5'];
        else if($anios >= 6 && $anios <= 9)  $aguinaldo = $config['diasAguinaldo']['6-9'];
        else if($anios >= 10 && $anios <= 14) $aguinaldo = $config['diasAguinaldo']['10-14'];
        else if($anios >= 15 && $anios <= 19) $aguinaldo = $config['diasAguinaldo']['15-19'];
        else if($anios >= 20 && $anios <= 24) $aguinaldo = $config['diasAguinaldo']['20-24'];
        else if($anios >= 25 && $anios <= 29) $aguinaldo = $config['diasAguinaldo']['25-29'];
        else if($anios >= 30) $aguinaldo = $config['diasAguinaldo']['30'];
        else $aguinaldo = 0;
    }*/

    return $aguinaldo;
}



//Lia -> Obtiene la configuracion del estimulo por salidas
function getConfiguracionEstimuloSalidas(){
    $builder=db()->table("prestacion");
    $response = $builder->getWhere(array("pre_PrestacionID"=>1))->getRowArray();
    $config = array();

    //Tabla de configuracion
    $estimulo = json_decode($response['pre_Estimulo'], true);
    for($i = 0; $i < count($estimulo); $i++){
        $config['estimuloSalidas'][$estimulo[$i]['periodo']] = $estimulo[$i]['porcentaje'];
    }
    return $config;
}

function estimuloSalidas($dias){

    $config = getConfiguracionEstimuloSalidas();

    if($dias === 1) $estimulo = $config['estimuloSalidas']['1'];
    else if($dias === 2) $estimulo = $config['estimuloSalidas']['2'];
    else if($dias === 3) $estimulo = $config['estimuloSalidas']['3'];
    else if($dias === 4) $estimulo = $config['estimuloSalidas']['4'];
    else if($dias === 5)  $estimulo = $config['estimuloSalidas']['5'];
    else if($dias === 6)  $estimulo = $config['estimuloSalidas']['6'];
    else $estimulo = 0;


    return $estimulo;
}

//Germán -> Regresa los dias inhabiles
function diasInhabilesPermiso(){
    $sucursalEmpleado = db()->query("SELECT emp_SucursalID FROM empleado WHERE emp_EmpleadoID=".session('id'))->getRowArray();
    $sucursal = '["'.$sucursalEmpleado['emp_SucursalID'].'"]';
    $todos = '["0"]';
    $sql="SELECT dia_Fecha
        FROM diainhabil WHERE JSON_CONTAINS(dia_SucursalID,'".$sucursal."') OR JSON_CONTAINS(dia_SucursalID,'".$todos."') AND dia_MedioDia=0
        UNION
        SELECT dial_Fecha as 'dia_Fecha'
        FROM diainhabilley";
    $dias = db()->query($sql)->getResultArray();
    $data =array();
    foreach ($dias as $dia){
        array_push($data,$dia['dia_Fecha']);
    }
    return $data;
}//end antiguedad


//Lia -> Obtiene la configuracion de la prima por antiguedad
function getConfiguracionPrimaAntiguedad(){
    $builder=db()->table("prestacion");
    $response = $builder->getWhere(array("pre_PrestacionID"=>1))->getRowArray();
    $config = array();

    //Tabla de configuracion
    $estimulo = json_decode($response['pre_Permanencia'], true);
    for($i = 0; $i < count($estimulo); $i++){
        $config['prima'][$estimulo[$i]['periodo']] = $estimulo[$i]['dias'];
    }
    return $config;
}

//Lia -> Obtiene la configuracion de la prima de antiguedad  2021
function getConfiguracionPrimaAntiguedad2021(){
    $builder=db()->table("prestacion");
    $response = $builder->getWhere(array("pre_PrestacionID"=>1))->getRowArray();
    $config = array();

    //Tabla de configuracion
    $estimulo = json_decode($response['pre_Permanencia2021'], true);
    for($i = 0; $i < count($estimulo); $i++){
        $config['prima'][$estimulo[$i]['periodo']] = $estimulo[$i]['dias'];
    }
    return $config;
}

//Lia-> obtiene el porcentaje de prima segun la antiguedad
function primaAntiguedad($emp_fechaIngreso){
    $fecha=strtotime($emp_fechaIngreso);
    $fechaIngresoC = date("Y-m-d", $fecha);
    //$fecha2=strtotime('2020-12-31');
    //$fechaComparativa = date("Y-m-d", $fecha2);


    $fecha=strtotime($emp_fechaIngreso);
    $fechaIngreso = date("Y", $fecha);
    $anios = date('Y')-$fechaIngreso;
    //$anios = antiguedad($emp_fechaIngreso);
    //if($fechaIngresoC > $fechaComparativa  ){
        $config = getConfiguracionPrimaAntiguedad();

        if($anios == 5) $prima = $config['prima']['5'];
        else if($anios == 10) $prima = $config['prima']['10'];
        else if($anios == 15 ) $prima = $config['prima']['15'];
        else if($anios == 20 ) $prima = $config['prima']['20'];
        else if($anios == 25 ) $prima = $config['prima']['25'];
        else if($anios >= 30 ) $prima = $config['prima']['30'];

        else $prima = 0;
    //}else{
    //    $config = getConfiguracionPrimaAntiguedad2021( );
    //    if($anios == 5) $prima = $config['prima']['5'];
    //    else if($anios == 10) $prima = $config['prima']['10'];
    //    else if($anios == 15 ) $prima = $config['prima']['15'];
    //    else if($anios == 20 ) $prima = $config['prima']['20'];
    //    else if($anios == 25 ) $prima = $config['prima']['25'];
    //    else if($anios >= 30 ) $prima = $config['prima']['30'];
    //    else $prima = 0;
    //}

    return $prima;
}






//Lia -> Obtiene la configuracion del prestamo
function getConfiguracionPrestamo(){
    $builder=db()->table("prestacion");
    $response = $builder->getWhere(array("pre_PrestacionID"=>1))->getRowArray();
    return $response['pre_Prestamo'];
}

//Lia -> Obtiene la configuracion del prestamo  2021
function getConfiguracionPrestamo2021(){
    $builder=db()->table("prestacion");
    $response = $builder->getWhere(array("pre_PrestacionID"=>1))->getRowArray();

    return $response['pre_Prestamo2021'];
}

//Lia-> obtiene el porcentaje de prima segun la antiguedad
function configPrestamo($emp_fechaIngreso,$salarioDiario){
    $fecha=strtotime($emp_fechaIngreso);
    $fechaIngresoC = date("Y-m-d", $fecha);
    $fecha2=strtotime('2020-12-31');
    $fechaComparativa = date("Y-m-d", $fecha2);

    //$fecha=strtotime($emp_fechaIngreso);
    //$fechaIngreso = date("Y", $fecha);
    $anios = cumpleanos($emp_fechaIngreso);

    //$anios = antiguedad($emp_fechaIngreso);
    /*if($fechaIngresoC > $fechaComparativa  ){
        $config = json_decode(getConfiguracionPrestamo(),true);
        if($anios >= 1 && $anios <= 5){
            $corresponde=array(
                'monto' => $config[0]['dias']*$salarioDiario,
                'plazo' =>$config[0]['plazo'],
                'tipo' =>'Actual',
            );
        }else if($anios >= 6 && $anios <= 10){
            $corresponde=array(
                'monto' => $config[1]['dias']*$salarioDiario,
                'plazo' =>$config[1]['plazo'],
                'tipo' =>'Actual',
            );
        }else if($anios >= 11 && $anios <= 15){
            $corresponde=array(
                'monto' => $config[2]['dias']*$salarioDiario,
                'plazo' =>$config[2]['plazo'],
                'tipo' =>'Actual',
            );
        }else if($anios >= 16 && $anios <= 20){
            $corresponde=array(
                'monto' => $config[3]['dias']*$salarioDiario,
                'plazo' =>$config[3]['plazo'],
                'tipo' =>'Actual',
            );
        }else if($anios >= 21 && $anios <= 25){
            $corresponde=array(
                'monto' => $config[4]['dias']*$salarioDiario,
                'plazo' =>$config[4]['plazo'],
                'tipo' =>'Actual',
            );
        }else if($anios >= 26){
            $corresponde=array(
                'monto' => $config[5]['dias']*$salarioDiario,
                'plazo' =>$config[5]['plazo'],
                'tipo' =>'Actual',
            );
        }else{
            $corresponde=array(
                'monto' => 0.00,
                'plazo' =>0,
                'tipo' =>'Actual',
            );
        }

    }else{*/
        $config = json_decode(getConfiguracionPrestamo2021(),true);
        if($anios >= 1 && $anios <= 2){
            $corresponde=array(
                'monto' => $config[0]['dias']*$salarioDiario,
                'plazo' =>$config[0]['plazo'],
                'tipo' =>'Anteriores',
            );
        }else if($anios >= 3 && $anios <= 4){
            $corresponde=array(
                'monto' => $config[1]['dias']*$salarioDiario,
                'plazo' =>$config[1]['plazo'],
                'tipo' =>'Anteriores',
            );
        }else if($anios >= 5 && $anios <= 7){
            $corresponde=array(
                'monto' => $config[2]['dias']*$salarioDiario,
                'plazo' =>$config[2]['plazo'],
                'tipo' =>'Anteriores',
            );
        }else if($anios >= 8 && $anios <= 9){
            $corresponde=array(
                'monto' => $config[3]['dias']*$salarioDiario,
                'plazo' =>$config[3]['plazo'],
                'tipo' =>'Anteriores',
            );
        }else if($anios >= 10 && $anios <= 15){
            $corresponde=array(
                'monto' => $config[4]['dias']*$salarioDiario,
                'plazo' =>$config[4]['plazo'],
                'tipo' =>'Anteriores',
            );
        }else if($anios >= 16 && $anios <= 20){
            $corresponde=array(
                'monto' => $config[5]['dias']*$salarioDiario,
                'plazo' =>$config[5]['plazo'],
                'tipo' =>'Anteriores',
            );
        }else if($anios >= 21 && $anios <= 25){
            $corresponde=array(
                'monto' => $config[6]['dias']*$salarioDiario,
                'plazo' =>$config[6]['plazo'],
                'tipo' =>'Anteriores',
            );
        }else if($anios >= 26){
            $corresponde=array(
                'monto' => $config[7]['dias']*$salarioDiario,
                'plazo' =>$config[7]['plazo'],
                'tipo' =>'Anteriores',
            );
        }else{
            $corresponde=array(
                'monto' => 0.00,
                'plazo' =>0,
                'tipo' =>'Anteriores',
            );
        }
    //}


    return $corresponde;
}

//Lia-> obtiene el porcentaje de prima segun la antiguedad
function configPrestamo_old($emp_fechaIngreso,$salarioDiario){
    $fecha=strtotime($emp_fechaIngreso);
    $fechaIngresoC = date("Y-m-d", $fecha);
    $fecha2=strtotime('2020-12-31');
    $fechaComparativa = date("Y-m-d", $fecha2);

    //$fecha=strtotime($emp_fechaIngreso);
    //$fechaIngreso = date("Y", $fecha);
    $anios = cumpleanos($emp_fechaIngreso);

    //$anios = antiguedad($emp_fechaIngreso);
    if($fechaIngresoC > $fechaComparativa  ){
        $config = json_decode(getConfiguracionPrestamo(),true);
        if($anios >= 1 && $anios <= 5){
            $corresponde=array(
                'monto' => $config[0]['dias']*$salarioDiario,
                'plazo' =>$config[0]['plazo'],
                'tipo' =>'Actual',
            );
        }else if($anios >= 6 && $anios <= 10){
            $corresponde=array(
                'monto' => $config[1]['dias']*$salarioDiario,
                'plazo' =>$config[1]['plazo'],
                'tipo' =>'Actual',
            );
        }else if($anios >= 11 && $anios <= 15){
            $corresponde=array(
                'monto' => $config[2]['dias']*$salarioDiario,
                'plazo' =>$config[2]['plazo'],
                'tipo' =>'Actual',
            );
        }else if($anios >= 16 && $anios <= 20){
            $corresponde=array(
                'monto' => $config[3]['dias']*$salarioDiario,
                'plazo' =>$config[3]['plazo'],
                'tipo' =>'Actual',
            );
        }else if($anios >= 21 && $anios <= 25){
            $corresponde=array(
                'monto' => $config[4]['dias']*$salarioDiario,
                'plazo' =>$config[4]['plazo'],
                'tipo' =>'Actual',
            );
        }else if($anios >= 26){
            $corresponde=array(
                'monto' => $config[5]['dias']*$salarioDiario,
                'plazo' =>$config[5]['plazo'],
                'tipo' =>'Actual',
            );
        }else{
            $corresponde=array(
                'monto' => 0.00,
                'plazo' =>0,
                'tipo' =>'Actual',
            );
        }

    }else{
        $config = json_decode(getConfiguracionPrestamo2021(),true);
        if($anios >= 1 && $anios <= 2){
            $corresponde=array(
                'monto' => $config[0]['dias']*$salarioDiario,
                'plazo' =>$config[0]['plazo'],
                'tipo' =>'Anteriores',
            );
        }else if($anios >= 3 && $anios <= 4){
            $corresponde=array(
                'monto' => $config[1]['dias']*$salarioDiario,
                'plazo' =>$config[1]['plazo'],
                'tipo' =>'Anteriores',
            );
        }else if($anios >= 5 && $anios <= 7){
            $corresponde=array(
                'monto' => $config[2]['dias']*$salarioDiario,
                'plazo' =>$config[2]['plazo'],
                'tipo' =>'Anteriores',
            );
        }else if($anios >= 8 && $anios <= 9){
            $corresponde=array(
                'monto' => $config[3]['dias']*$salarioDiario,
                'plazo' =>$config[3]['plazo'],
                'tipo' =>'Anteriores',
            );
        }else if($anios >= 10 && $anios <= 15){
            $corresponde=array(
                'monto' => $config[4]['dias']*$salarioDiario,
                'plazo' =>$config[4]['plazo'],
                'tipo' =>'Anteriores',
            );
        }else if($anios >= 16 && $anios <= 20){
            $corresponde=array(
                'monto' => $config[5]['dias']*$salarioDiario,
                'plazo' =>$config[5]['plazo'],
                'tipo' =>'Anteriores',
            );
        }else if($anios >= 21 && $anios <= 25){
            $corresponde=array(
                'monto' => $config[6]['dias']*$salarioDiario,
                'plazo' =>$config[6]['plazo'],
                'tipo' =>'Anteriores',
            );
        }else if($anios >= 26){
            $corresponde=array(
                'monto' => $config[7]['dias']*$salarioDiario,
                'plazo' =>$config[7]['plazo'],
                'tipo' =>'Anteriores',
            );
        }else{
            $corresponde=array(
                'monto' => 0.00,
                'plazo' =>0,
                'tipo' =>'Anteriores',
            );
        }
    }


    return $corresponde;
}







