<?php

defined('WRITEPATH') or exit('No direct script access allowed');

function mesa()
{
    return $mesa=\Config\Database::connect('mesa',true);
}

function federacion()
{
    return $federacion=\Config\Database::connect('federacion',true);
}

function cooperativaID(){
    return (int)getSetting('id_coop_mesa',null);
}

//Sends an email using PHPMailer
function sendMailMA($targets, $subject, $datos, $tipo, $files = array())
{
    require_once APPPATH . 'Libraries/phpmailer/class.phpmailer.php';
    require_once APPPATH . 'Libraries/phpmailer/class.smtp.php';

    try {
        $mail = new PHPMailer(true);
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "ssl";
        $mail->Host = "admin.thigo.mx";                   //< - - - EDIT
        $mail->Port = 465;
        $mail->Username = "mesadeayuda@thigo.mx";             //< - - - EDIT
        $mail->Password = "C,2tHiQ7DL9W";                   //< - - - EDIT
        $mail->From = "mesadeayuda@thigo.mx";                 //< - - - EDIT
        $mail->FromName = "Mesa de Ayuda"; //< - - - EDIT
        $mail->CharSet = 'UTF-8';
        $mail->Subject = $subject;
        //$mail->setFrom('dvera@cpalianza.com.mx', 'Dvera');

        $content=write_message($datos);

        $mail->MsgHTML($content);

        //Clear addresses and attatchments
        $mail->clearAllRecipients();
        $mail->clearAttachments();

        //Set dest email
        if (is_array($targets)) {

            foreach ($targets as $email) {
                //var_dump($email);
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $mail->AddAddress(trim($email));
                } //if
            } //foreach
        } else {
            $mail->AddAddress(trim($targets));
        } //if-else


        //Attatch files
        if (!empty($files)) {
            foreach ($files as $f) {
                $mail->addAttachment($f['src'], $f['name']);
            } //foreach
        } //files

        //Return success code
        return $mail->Send();
    } catch (Exception $e) {
        var_dump($e->getMessage());
        return false;
    } //try-catch

} //sendMail



function write_message($datos){
        return '<body style="margin:0;padding:0;">
	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
		<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
                    <tr>
                        <td align="center" style="padding:40px 0 30px 0;background:#f0f0f0;">
                            <img src="https://mesadeayuda.thigo.mx/assets/images/mesa/31.png" alt="" width="125" style="height:auto;display:block;" />
                        </td>
                    </tr>
					<tr>
						<td style="padding:36px 30px 42px 30px;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
                                <tr>
									<td style="padding:0 0 36px 0;color:#153643; text-align:justify">
                                        <h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">'.$datos['titulo'].'<hr style="color:#f3a333;border-color:#f3a333"></h1>
                                        <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        '.$datos['cuerpo'].'
                                        </p>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:30px;background:#333333;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
								<tr>
									<td style="padding:0;width:50%;" align="left">
										<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        Atentamente <br> Federación de Cajas Populares <b>ALIANZA</b>.<br>
                                        &reg; THIGO '.date('Y').'
										</p>
									</td>
									<td style="padding:0;width:50%;" align="right">
										<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
											<tr>
                                                <td style="padding:0 0 0 10px;width:38px;">
                                                    <a style="color:#ffffff;"><img src="https://mesadeayuda.thigo.mx/assets/images/thigo/3.png" alt="Twitter" width="30" style="height:auto;display:block;border:0;" /></a>
                                                </td>
                                                <td style="padding:0 0 0 10px;width:38px;">
                                                    <a style="color:#ffffff;"><img src="https://mesadeayuda.thigo.mx/assets/images/moneda_blanca.png" width="30" style="height:auto;display:block;border:0;" /></a>
                                                </td>
                                                <td style="padding:0 0 0 10px;width:38px;">
                                                    <a style="color:#ffffff;"><img src="https://mesadeayuda.thigo.mx/assets/images/mesa/21.png" width="30" style="height:auto;display:block;border:0;" /></a>
                                                </td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="background:#333333;text-align: center;font-size:.75rem;line-height:16px;font-family:Arial,sans-serif;color:white;"><b><em>Favor no responder este mensaje que ha sido emitido automáticamente</em></b></td>
					</tr>
                    <tr>
                        <td style="padding:3px;background:#000;">
                        </td>
                    </tr>
				</table>
			</td>
		</tr>
	</table>
</body>';
}



function insertLogMesa($obj, $empleado, $accion, $tabla, $id)
{
    $array = array(
        'log_UsuarioID' => $empleado,
        'log_Accion' => $accion,
        'log_Tabla' => $tabla,
        'log_FechaHora' => date('Y-m-d H:i:s'),
        'log_ID' => $id,
    );
    $builder = mesa()->table("log");
    $builder->insert($array);
}


//Obtiene si el empleado es agente
function isAgente()
{
    $empleado = session("id");
    $agente = mesa()->query("SELECT * FROM agente WHERE age_Estatus=1 AND age_EmpleadoID=" . (int)$empleado)->getRowArray();
    return $agente ? TRUE : FALSE;
}

function agenteID(){
    return mesa()->query("SELECT age_AgenteID FROM agente WHERE age_Estatus=1 AND age_EmpleadoID=" . (int)session('id'))->getRowArray()['age_AgenteID'];
}

//Diego->Foto perfil mesaayuda
function fotoPerfilMesaAyuda($usuarioID)
{
    $url[1] =  "https://mesadeayuda.thigo.mx/assets/uploads/fotosPerfil/" . $usuarioID . "-Empleado.png";
    $url[2] = "https://mesadeayuda.thigo.mx/assets/uploads/fotosPerfil/" . $usuarioID . "-Empleado.jpg";
    $url[3] = "https://mesadeayuda.thigo.mx/assets/uploads/fotosPerfil/" . $usuarioID . "-Empleado.JPG";
    $avatar=base_url("assets/images/avatar.jpg");
    $imagen='';
    for($i=1;$i<=3;$i++){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url[$i]);
        // don't download content
        curl_setopt($ch, CURLOPT_NOBODY, 1);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if (curl_exec($ch) !== FALSE) {
            $imagen=$url[$i];
        }
    }
    if(empty($imagen)) $imagen=$avatar;
    return $imagen;
} //fotoPerfil

function logTicket($ticketID,$accion,$tipo=null,$usuario=null,$datos=null){
    /*
    Acciones Solicitante            Acciones Agente
    -Creo Ticket                    -Vio ticket
    -Respondio encuesta             -Cerro ticket
                                    -Cambio de estatus/prioridad (estatus) Estatus y fecha cambios anterior y nueva
                                    -Asignacion de fecha (fecha)
                -Respondio/atendio(1er comentario) ticket
    */
    $data = array(
        'log_TicketID'=>$ticketID,
        'log_Fecha'=>date('Y-m-d H:i:s'),
        'log_Accion'=>$accion,
        'log_Tipo'=>$tipo,
        'log_UsuarioID'=>$usuario,
        'log_Datos'=>$datos
    );
    $builder = mesa()->table('logticket');
    $builder->insert($data);
}

function fechaPrioridadTicket($prioridad,$fechaInicio){
    $fecha=date("Y-m-d H:i:s", strtotime($fechaInicio));
    $fechaResolucion=date('Y-m-d');
    switch($prioridad){
        case "URGENTE" :
            return $fechaResolucion=date("Y-m-d H:i:s",strtotime($fecha."+1 days"));
            break;
        case "ALTA":
            return $fechaResolucion=date("Y-m-d H:i:s",strtotime($fecha."+3 days"));
            break;
        case "MEDIA" :
            return $fechaResolucion=date("Y-m-d H:i:s",strtotime($fecha."+5 days"));
            break;
        case "BAJA" :
            return $fechaResolucion=date("Y-m-d H:i:s",strtotime($fecha."+7 days"));
            break;
    }

    $inhabiles = diasInhabiles(null);
    $fechaInicio = new DateTime($fecha);
    $fechaFin = new DateTime($fechaResolucion);
    $interval = new DateInterval('P1D');
    $daterange = new DatePeriod($fechaInicio, $interval ,$fechaFin);

    $dias = 0;
    foreach($daterange as $date) {
        $descanza=DescansoColaborador(session('id'), date_format($date,'Y-m-d'));
        if(date('l', strtotime($date->format("Y-m-d"))) !== 'Sunday'){
            if(!in_array($date->format("Y-m-d"), $inhabiles)) {
                if((int)$descanza == 0) $dias++;
            }
        }
    }

    $fechaResolucion=date("Y-m-d H:i:s",strtotime($fechaInicio."+ ".(int)$dias." days"));
    return $fechaResolucion;
}


function acortarurl($url){
    $longitud = strlen($url);
    if($longitud > 45){
        $longitud = $longitud - 30;
        $parte_inicial = substr($url, 0, -$longitud);
        $parte_final = substr($url, -15);
        $nueva_url = $parte_inicial."[ ... ]".$parte_final;
        return $nueva_url;
    }else{
        return $url;
    }
}

function urlTicket($coop,$ticketID){
    switch($coop){
        case 3 :return  'https://cerano.thigo.mx/MesaAyuda/ticket/'.$ticketID;break;
        case 12 :return 'https://purepero.thigo.mx/MesaAyuda/ticket/'.$ticketID;break;
        case 16 :return 'https://santuariog.thigo.mx/MesaAyuda/ticket/'.$ticketID;break;
        case 17 :return 'https://tanhuato.thigo.mx/MesaAyuda/ticket/'.$ticketID;break;
        case 18 :return 'https://tatavasco.thigo.mx/MesaAyuda/ticket/'.$ticketID;break;
        case 21 :return 'https://smg.thigo.mx/MesaAyuda/ticket/'.$ticketID;break;
        default : return 'https://mesadeayuda.thigo.mx/Usuario/ticket/'.$ticketID;break;
    }
}

function urlTicketCoop($coop){
    switch($coop){
        case 3 :return  'https://cerano.thigo.mx/MesaAyuda/ticketsCoop/';break;
        case 12 :return 'https://purepero.thigo.mx/MesaAyuda/ticketsCoop/';break;
        case 16 :return 'https://santuariog.thigo.mx/MesaAyuda/ticketsCoop/';break;
        case 17 :return 'https://tanhuato.thigo.mx/MesaAyuda/ticketsCoop/';break;
        case 18 :return 'https://tatavasco.thigo.mx/MesaAyuda/ticketsCoop/';break;
        case 21 :return 'https://smg.thigo.mx/MesaAyuda/ticketsCoop/';break;
        default : return 'https://mesadeayuda.thigo.mx/Usuario/ticketsCoop/';break;
    }
}

//traer archivos del ticket
function filesTicket($ticketID){
    $ticketID=encryptDecrypt('decrypt',$ticketID);
    $archivos = mesa()->query("SELECT tic_File FROM ticket WHERE tic_TicketID=?",array($ticketID))->getRowArray()['tic_File'];
    $data = array();
    $ticketID=encryptDecrypt('encrypt',$ticketID);
    $archivos = json_decode($archivos);
    $archive=array();
    foreach($archivos as $archivo){
        $archive['url']=("https://mesadeayuda.thigo.mx/assets/uploads/tickets/".$ticketID.'/'.$archivo);//Cambiar en produccion
        //$archive['url']=("http://localhost/mesadeayuda/assets/uploads/tickets/".$ticketID.'/'.$archivo);
        $archive['nombre']=(explode('.',$archivo))[0];
        $archive['extension']=substr($archivo,-3);
        array_push($data,$archive);
    }
    return $data;
}

//traer archivos del comentario ticket
function filesComentarioTicket($ComentarioTicketID){
    $archivos = mesa()->query("SELECT comt_TicketID,comt_Files FROM comentarioticket WHERE comt_ComentarioTicketID=?",array($ComentarioTicketID))->getRowArray();
    $ticketID=encryptDecrypt('encrypt',$archivos['comt_TicketID']);
    $archivos = json_decode($archivos['comt_Files']);
    $data = array();
    $archive=array();
    foreach($archivos as $archivo){
        $archive['url']=("https://mesadeayuda.thigo.mx/assets/uploads/tickets/".$ticketID.'/'.$archivo);//Cambiar en produccion
        //$archive['url']=("http://localhost/mesadeayuda/assets/uploads/tickets/".$ticketID.'/'.$archivo);
        $archive['nombre']=(explode('.',$archivo))[0];
        $archive['extension']=substr($archivo,-3);
        array_push($data,$archive);
    }
    return $data;
}


function iconExtension($extension){
    switch($extension){
        case 'xls':
        case 'lsm':
        case 'lsx': $icon=base_url('assets/images/fileicons/excel.svg');
        break;
        case 'JPG':
        case 'jpg':
        case 'jpeg':
        case 'png': $icon=base_url('assets/images/fileicons/image.svg');
        break;
        case 'pdf': $icon=base_url('assets/images/fileicons/pdf.svg');break;
        case 'ptx':
        case 'ppt': $icon=base_url('assets/images/fileicons/pp.svg');break;
        case 'txt': $icon=base_url('assets/images/fileicons/txt.svg');break;
        case 'ocx':
        case 'doc': $icon=base_url('assets/images/fileicons/word.svg');break;
        case 'xml': $icon=base_url('assets/images/fileicons/xml.svg');break;
        case 'zip': $icon=base_url('assets/images/fileicons/zip.svg');break;
        case 'avi':
        case 'wma':
        case 'wmv':
        case 'mov':
        case 'flv':
        case 'mp4':
        case 'mkv': $icon=base_url('assets/images/fileicons/video.svg');break;
        default : $icon=base_url('assets/images/fileicons/file.svg');break;
    }
    return $icon;
}


function ticketVencido1Respuesta($ticketID,$fechaEstimada){
    $fechaLog = mesa()->query("SELECT log_Fecha FROM logticket WHERE log_TicketID =".$ticketID." AND log_Accion='1RESPUESTA'")->getRowArray()['log_Fecha'];
    $fechaEstimada = strtotime($fechaEstimada);
    $fechaReal = strtotime($fechaLog);

    //Fecha real es mayor a la estimada
    if($fechaReal > $fechaEstimada )return 1;
    else return 0;
}

function ticketVencidoResolucion($ticketID,$fechaEstimada){
    $fechaLog = mesa()->query("SELECT log_Fecha FROM logticket WHERE log_TicketID =".$ticketID." AND log_Accion='RESUELTO'")->getRowArray()['log_Fecha'];
    $fechaEstimada = strtotime($fechaEstimada);
    $fechaReal = strtotime($fechaLog);

    //Fecha real es mayor a la estimada
    if($fechaReal > $fechaEstimada )return 1;
    else return 0;
}

function administradorID(){
    $permisos = json_decode(session('permisos'), 1);
    $funcion= array('gestionMesaAyuda');
    $mostrar = false;
    if (is_array($funcion)) {
        foreach ($funcion as $f) {
            if (isset($permisos[$f])) {
                $mostrar = true;
            }
        }
    } else {
        if (isset($permisos[$funcion])) {
            $mostrar = true;
        }
    }
    return $mostrar;
}

function isSolicitanteMesa(){
    $mostrar = false;
    $usuario=mesa()->query("SELECT * FROM usuario WHERE usu_Tipo='Thigo' AND usu_Estatus=1 AND usu_Identificador=".session('id')." AND usu_CooperativaID=".cooperativaID())->getRowArray();
    if(!empty($usuario)) $mostrar = true;
    return $mostrar;
}

function usuarioID(){
    $usuario=mesa()->query("SELECT usu_UsuarioID FROM usuario WHERE usu_Tipo='Thigo' AND usu_Estatus=1 AND usu_Identificador=".session('id')." AND usu_CooperativaID=".cooperativaID())->getRowArray()['usu_UsuarioID'];
    return $usuario;
}

function fotoPerfilFederacion($empleadoID)
{
    $avatar = base_url("assets/images/avatar.jpg");
    $file_extensions = array("png", "jpg", "JPG");
    //$path = dirname(WRITEPATH) . "/assets/uploads/fotosPerfil/";
    $path = str_replace(basename(FCPATH),'federacion', FCPATH . "assets/uploads/fotosPerfil/" );
    foreach ($file_extensions as $ext) {
        $file = $path . $empleadoID . "-Empleado." . $ext;
        if (file_exists($file)) return "https://federacion.thigo.mx/assets/uploads/fotosPerfil/{$empleadoID}-Empleado.".$ext;
    }
    return $avatar;
}

function agenteIDByEmpleadoID($empleadoID){
    return mesa()->query("SELECT age_AgenteID FROM agente WHERE age_Estatus=1 AND age_EmpleadoID=" . (int)$empleadoID)->getRowArray()['age_AgenteID'];
}

function getCalificacionEncuesta($pregunta1,$pregunta2,$pregunta3){

    switch ($pregunta1){
        case "necesitaMejorar": $totalP1=2; break;
        case "regular": $totalP1=4;break;
        case "bueno": $totalP1=6;break;
        case "muybueno": $totalP1=8;break;
        case "excelente":  $totalP1=10;break;
    }

    switch ($pregunta2){
        case "necesitaMejorar": $totalP2=2; break;
        case "regular": $totalP2=4;break;
        case "bueno": $totalP2=6;break;
        case "muybueno": $totalP2=8;break;
        case "excelente":  $totalP2=10;break;
    }

    switch ($pregunta3){
        case "necesitaMejorar": $totalP3=2; break;
        case "regular": $totalP3=4;break;
        case "bueno": $totalP3=6;break;
        case "muybueno": $totalP3=8;break;
        case "excelente":  $totalP3=10;break;
    }

    $total = ($totalP1+$totalP2+$totalP3) / 3;
    return number_format($total,2);
}

function getIndicadorSatisfaccionEncuesta($calificacion){
    if($calificacion > 0 && $calificacion <=3.33) return 'Negativo';
    if($calificacion >= 3.34 && $calificacion <=6.66) return 'Neutro';
    if($calificacion >= 6.67 && $calificacion <=10) return 'Positivo';
}

function getTipoEstadistica($numero){
    switch($numero){
        case 1 :return 'Tendencia tickets creados VS Resueltos en tiempo';break;
        case 2 :return 'Tickets por cooperativa';break;
        case 3 :return 'Tickets por área';break;
        case 4 :return 'Tickets por prioridad';break;
        case 5 :return 'Tickets por estatus';break;
        case 6 :return 'Tickets genéricos';break;
        case 7 :return 'Tickets vencidos por cooperativa';break;
        case 8 :return 'Calificación de encuesta por cooperativa';break;
        case 9 :return 'Tendencia tickets anual';break;
    }
}


