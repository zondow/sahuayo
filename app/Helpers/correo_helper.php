<?php

defined('WRITEPATH') or exit('No direct script access allowed');

//Sends an email using PHPMailer
function sendMail($targets, $subject, $datos, $tipo, $files = array())
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
        $mail->Username = "admin@thigo.mx";             //< - - - EDIT
        $mail->Password = "C,2tHiQ7DL9W";                   //< - - - EDIT
        $mail->From = "admin@thigo.mx";                 //< - - - EDIT
        $mail->FromName = "Administrador Thigo";                    //< - - - EDIT
        $mail->CharSet = 'UTF-8';
        $mail->Subject = $subject;

        switch ($tipo) {
            case 'comunicado':
                $content = write_messageComunicado($datos);
                break;
            case 'Evaluacion':
                $content = writeMessageEvaluacion($datos);
                break;
            case 'Colaborador':
                $content = writeMessageColaborador($datos);
                break;
            case 'VacacionesS':
                $content = writeMessageSolicitudVacaciones($datos);
                break;
            case 'VacacionAutorizada':
                $content = writeMessageVacacionesAutorizadas($datos);
                break;
            case 'VacacionAplicada':
                $content = writeMessageVacacionesAplicadas($datos);
                break;
            case 'VacacionRechazada':
                $content = writeMessageVacacionesRechazadas($datos);
                break;
            case 'Permiso':
                $content = write_messagePermiso($datos);
                break;
            case 'Incapacidad':
                $content = write_messageIncapacidad($datos);
                break;
            case 'Sancion':
                $content = write_messageSancion($datos);
                break;
            case 'ConvocatoriaInstructor':
                $content = write_messageConvocatoriaInstructor($datos);
                break;
            case 'ConvocatoriaParticipante':
                $content = write_messageConvocatoriaParticipante($datos);
                break;
            case 'NuevaSolicitudPersonal':
                $content = write_messageNuevaSolicitudPersonal($datos);
                break;
            case 'CanidatoRechazado':
                $content = write_messageRechazoSolicitud($datos);
                break;
            case 'Normativa':
                $content = write_messageActualizacionNormativa($datos);
                break;
            case 'PermisoS':
                $content = write_messagePermisoSolicitud($datos);
                break;
            case 'PermisoAutorizado':
                $content = write_messagePermisoAutorizado($datos);
                break;
            case 'PermisoRechazado':
                $content = writeMessagePermisoRechazadas($datos);
                break;
            case 'diaExtraordinario':
                $content = writeMessageDiaExtra($datos);
                break;
            case 'diaExtraordinarioEstatus':
                $content = writeMessageDiaExtraEmpleado($datos);
                break;
            case 'AccesosMasivos':
                $content = writeMessageAccesosMasivos($datos);
                break;
            case 'SolicitudPrestamoAutDir':
                $content = writeMessageDirAutPrestamo($datos);
                break;
            case 'SolicitudPrestamoRechDir':
                $content = writeMessageDirRechPrestamo($datos);
                break;
            case 'SolicitudPrestamoAplicar':
                $content = writeMessageAplicarPrestamo($datos);
                break;
            case 'SolicitudPrestamoNoAplicar':
                $content = writeMessageNoAplicarPrestamo($datos);
                break;
            case 'SolicitudAnticipoSueldoRevisar':
                $content = writeMessageSolicitudAnticipoRevisar($datos);
                break;
            case 'AnticipoSueldoAutorizarDir':
                $content = writeMessageSolicitudAnticipoRevisarDir($datos);
                break;
            case 'AnticipoSueldoRevisionCH':
                $content = writeMessageSolicitudAnticipoRevisarCH($datos);
                break;
            case 'ReporteHorasExtra':
                $content = writeMessageReporteHorasExtra($datos);
                break;
            case 'ReporteHorasRevisionJefe':
                $content = writeMessageReporteHorasExtraRevisionJefe($datos);
                break;
            case 'ReporteHorasExtraCH':
                $content = writeMessageReporteHorasExtraCH($datos);
                break;
            case 'ReporteHorasRevisionCH':
                $content = writeMessageReporteHorasExtraRevisionCH($datos);
                break;
            case 'ReporteHorasGerente':
                $content = writeMessageReporteHorasExtraGerente($datos);
                break;
            case 'reciboNomina':
                $content = writeMessageRecibosNomina($datos);
                break;
            case 'InformeSalidas':
                $content = writeMessageInformeSalidas($datos);
                break;
            case 'InformeSalidasRevisionJefe':
                $content = writeMessageInformeSalidasRevisionJEfe($datos);
                break;
            case 'InformeSalidasRevisionCH':
                $content = writeMessageInformeSalidasRevisionCH($datos);
                break;

            default:
                $content = writeMessageDefault($datos);
                break;
        }

        $mail->MsgHTML($content);

        //Clear addresses and attatchments
        $mail->clearAllRecipients();
        $mail->clearAttachments();

        //Set dest email
        if (is_array($targets)) {

            foreach ($targets as $email) {
                var_dump($email);
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
        //return false;
    } //try-catch

} //sendMail



function writeMessageDiaExtra($datos)
{
    return '<body style="margin:0;padding:0;">
	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
		<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
					<tr>
						<td align="center" style="padding:40px 0 30px 0;background:#bdcde3;">
							<img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" alt="" width="100" style="height:auto;display:block;" />
						</td>
					</tr>
					<tr>
						<td style="padding:36px 30px 42px 30px;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
								<tr>
									<td style="padding:0 0 36px 0;color:#153643; text-align:justify">
										<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Informe de salidas<hr></h1>
										<p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        Estimad@ ' . $datos['jefeNombre'] . ',<br>
                                        Mediante el presente se le comunica que el colaborador a su cargo ' . $datos['empleado'] . ', ha registrado un día extraordinario para su revisión en la plataforma THIGO.<br>
                                        Para mayor información, revise el informe en la plataforma.
                                        </p>
                                        <div class="col-md-12 text-center" style="text-align: center;"><br>
										<a href="' . base_url("Access/index") . '" class="btn btn-primary"
                                           style="border-radius:25px !important; font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #343a40; margin: 0; border-color: #343a40; border-style: solid; border-width: 8px 16px;">
                                           Inicie Sesión ahora</a>
                                        </div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:30px;background:#5a6771;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
								<tr>
									<td style="padding:0;width:50%;" align="left">
										<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        Atentamente <br> El equipo de <b>THIGO</b>.<br>
                                        &reg; THIGO ' . date('Y') . '
										</p>
									</td>
									<td style="padding:0;width:50%;" align="right">
										<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
											<tr>
												<td style="padding:0 0 0 10px;width:38px;">
													<a style="color:#ffffff;"><img src="https://thigo.mx/assets/images/thigo/3.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
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

function writeMessageDiaExtraEmpleado($datos)
{
    return '<body style="margin:0;padding:0;">
	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
		<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
					<tr>
						<td align="center" style="padding:40px 0 30px 0;background:#bdcde3;">
							<img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" alt="" width="100" style="height:auto;display:block;" />
						</td>
					</tr>
					<tr>
						<td style="padding:36px 30px 42px 30px;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
								<tr>
									<td style="padding:0 0 36px 0;color:#153643; text-align:justify">
										<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Informe de salidas<hr></h1>
										<p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        Estimad@ ' . utf8_decode($datos['emp_Nombre']) . ',<br>
                                        Mediante el presente se le comunica que el día extraordinario ha sido ' . $datos['tipo'] . ', para su revisión en la plataforma THIGO.
                                        Para mayor información, revise el informe en la plataforma.
                                        </p>
                                        <div class="col-md-12 text-center" style="text-align: center;"><br>
										<a href="' . base_url("Access/index") . '" class="btn btn-primary"
                                           style="border-radius:25px !important; font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #343a40; margin: 0; border-color: #343a40; border-style: solid; border-width: 8px 16px;">
                                           Inicie Sesión ahora</a>
                                        </div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:30px;background:#5a6771;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
								<tr>
									<td style="padding:0;width:50%;" align="left">
										<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        Atentamente <br> El equipo de <b>THIGO</b>.<br>
                                        &reg; THIGO ' . date('Y') . '
										</p>
									</td>
									<td style="padding:0;width:50%;" align="right">
										<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
											<tr>
												<td style="padding:0 0 0 10px;width:38px;">
													<a style="color:#ffffff;"><img src="https://thigo.mx/assets/images/thigo/3.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
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

//Lia-> plantilla Comunicado general
function write_messageComunicado($data)
{
    $text = '
    <body style="margin:0;padding:0;">
	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
		<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
					<tr>
						<td align="center" style="padding:40px 0 30px 0;background:#bdcde3;">
							<img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" alt="" width="100" style="height:auto;display:block;" />
						</td>
					</tr>
					<tr>
						<td style="padding:36px 30px 42px 30px;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
								<tr>
									<td style="padding:0 0 36px 0;color:#153643; text-align:justify">
										<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Nuevo comunicado<hr></h1>
										<p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">Estimad@ ' . $data['nombre'] . ':<br>
                                            Acaba de recibir un nuevo comunicado a través de la plataforma THIGO , inicie sesión para verlo.
                                        </p>
                                        <div class="col-md-12 text-center" style="text-align: center;"><br>
										<a href="' . base_url("Access/index") . '" class="btn btn-primary"
                                           style="border-radius:25px !important; font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #343a40; margin: 0; border-color: #343a40; border-style: solid; border-width: 8px 16px;">
                                           Inicie Sesión ahora</a>
                                        </div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:30px;background:#5a6771;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
								<tr>
									<td style="padding:0;width:50%;" align="left">
										<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        Atentamente <br> El equipo de <b>THIGO</b>.<br>
                                        &reg; THIGO ' . date('Y') . '
										</p>
									</td>
									<td style="padding:0;width:50%;" align="right">
										<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
											<tr>
												<td style="padding:0 0 0 10px;width:38px;">
													<a style="color:#ffffff;"><img src="https://thigo.mx/assets/images/thigo/3.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
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
    return $text;
} //end write_messageComunicadoGeneral

//Nat -> Construye el mensaje del correo para Permiso
function write_messagePermiso($datos)
{
    $date = date('Y-m-d');
    $Nombre = $datos['NombreEmp'];
    $FechaI = $datos['per_FechaInicio'];
    $FechaF = $datos['per_FechaFin'];
    $motivo = $datos['per_Motivos'];

    $text = '<body style="margin:0;padding:0;">
	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
		<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
					<tr>
						<td align="center" style="padding:40px 0 30px 0;background:#bdcde3;">
							<img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" alt="" width="100" style="height:auto;display:block;" />
						</td>
					</tr>
					<tr>
						<td style="padding:36px 30px 42px 30px;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
								<tr>
									<td style="padding:0 0 36px 0;color:#153643; text-align:justify">
										<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Solicitud de Permiso<hr></h1>
										<p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">Estimad@ ' . $Nombre . ':<br>
                                        Mediante el presente se le comunica a usted que su solicitud de permiso ha sido APLICADO por el area de RECURSOS HUMANOS del día ' . longDate($FechaI, " de ") . '  al ' . longDate($FechaF, " de ") . '.
                                        </p>
                                        <div class="col-md-12 text-center" style="text-align: center;"><br>
										<a href="' . base_url("Access/index") . '" class="btn btn-primary"
                                           style="border-radius:25px !important; font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #343a40; margin: 0; border-color: #343a40; border-style: solid; border-width: 8px 16px;">
                                           Inicie Sesión ahora</a>
                                        </div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:30px;background:#5a6771;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
								<tr>
									<td style="padding:0;width:50%;" align="left">
										<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        Atentamente <br> El equipo de <b>THIGO</b>.<br>
                                        &reg; THIGO ' . date('Y') . '
										</p>
									</td>
									<td style="padding:0;width:50%;" align="right">
										<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
											<tr>
												<td style="padding:0 0 0 10px;width:38px;">
													<a style="color:#ffffff;"><img src="https://thigo.mx/assets/images/thigo/3.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
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
    return $text;
} // end write_messagePermiso

//Fer -> Construye el mensaje del correo para Incapacidad
function write_messageIncapacidad($datos)
{

    $text = '<body style="margin:0;padding:0;">
	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
		<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
					<tr>
						<td align="center" style="padding:40px 0 30px 0;background:#bdcde3;">
							<img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" alt="" width="100" style="height:auto;display:block;" />
						</td>
					</tr>
					<tr>
						<td style="padding:36px 30px 42px 30px;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
								<tr>
									<td style="padding:0 0 36px 0;color:#153643; text-align:justify">
										<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Registro de Incapacidad<hr></h1>
										<p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">Estimad@ ' . $datos['NombreRH'] . ':<br>
                                        Mediante el presente se le comunica que el colaborador ' . $datos['NombreColaborador'] . ', ha registrado una incapacidad.<br>
                                        </p>
                                        <div class="col-md-12 text-center" style="text-align: center;"><br>
										<a href="' . base_url("Access/index") . '" class="btn btn-primary"
                                           style="border-radius:25px !important; font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #343a40; margin: 0; border-color: #343a40; border-style: solid; border-width: 8px 16px;">
                                           Inicie Sesión ahora</a>
                                        </div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:30px;background:#5a6771;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
								<tr>
									<td style="padding:0;width:50%;" align="left">
										<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        Atentamente <br> El equipo de <b>THIGO</b>.<br>
                                        &reg; THIGO ' . date('Y') . '
										</p>
									</td>
									<td style="padding:0;width:50%;" align="right">
										<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
											<tr>
												<td style="padding:0 0 0 10px;width:38px;">
													<a style="color:#ffffff;"><img src="https://thigo.mx/assets/images/thigo/3.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
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
    return $text;
} // end write_messageIncapacidad

//Fer -> Construye el mensaje del correo para Incapacidad
function write_messageSancion($datos)
{

    $text = '<body style="margin:0;padding:0;">
	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
		<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
					<tr>
						<td align="center" style="padding:40px 0 30px 0;background:#bdcde3;">
							<img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" alt="" width="100" style="height:auto;display:block;" />
						</td>
					</tr>
					<tr>
						<td style="padding:36px 30px 42px 30px;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
								<tr>
									<td style="padding:0 0 36px 0;color:#153643; text-align:justify">
										<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">' . $datos['TipoSancion'] . '<hr></h1>
										<p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">Estimad@ ' . $datos['NombreColaborador'] . ':<br>
                                        Mediante el presente se le comunica que se le ha generado una sancion del tipo: <b>' . $datos['TipoSancion'] . '</b>.<br><br>
                                        Para mayor información, ingrese a la plataforma THIGO.<br>
                                        </p>
                                        <div class="col-md-12 text-center" style="text-align: center;"><br>
										<a href="' . base_url("Access/index") . '" class="btn btn-primary"
                                           style="border-radius:25px !important; font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #343a40; margin: 0; border-color: #343a40; border-style: solid; border-width: 8px 16px;">
                                           Inicie Sesión ahora</a>
                                        </div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:30px;background:#5a6771;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
								<tr>
									<td style="padding:0;width:50%;" align="left">
										<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        Atentamente <br> El equipo de <b>THIGO</b>.<br>
                                        &reg; THIGO ' . date('Y') . '
										</p>
									</td>
									<td style="padding:0;width:50%;" align="right">
										<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
											<tr>
												<td style="padding:0 0 0 10px;width:38px;">
													<a style="color:#ffffff;"><img src="https://thigo.mx/assets/images/thigo/3.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
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
    return $text;
} // end write_messageIncapacidad

//Nat -> Construye el mensaje del correo para Permiso
function writeMessageCandidato($datos)
{
    $text = '<table class="body-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
        <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
        <td class="container" width="600"
            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"
            valign="top">
            <div class="content"
                 style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                <table class="main" width="100%" cellpadding="0" cellspacing="0"
                       style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; display: inline-block; margin: 0; border: 1px solid #e9e9e9;"
                       bgcolor="#fff">
                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class=""
                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #e3eaef; margin: 0; padding: 20px;"
                            align="center" bgcolor="#71b6f9" valign="top">
                            <a href="#"> <img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" height="70" alt="logo"/></a> <br/>
                            <span style="margin-top: 10px;display: block; color:#313a46;">ESTIMADO CANDIDATO A VACANTE </span>
                        </td>
                    </tr>
                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class="content-wrap"
                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;"
                            valign="top">
                            <table width="100%" cellpadding="0" cellspacing="0"
                                   style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Estimado ' . $datos['nombre'] . '.
                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Agradecemos tu interés en integrarte a ' . $datos['empresa'] . '; para conocerte mejor y programar una entrevista, necesitamos que por favor llenes el formulario que se encuentra en el siguiente enlace:
                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        <a href="' . $datos['link'] . '" class="btn btn-primary"
                                           style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #001689; margin: 0; border-color: #001689; border-style: solid; border-width: 8px 16px;">
                                           LLENAR FORMULARIO</a>
                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        <br/>
                                        El formulario se divide en dos partes: el PRE-SCREENING y el CURRÍCULUM VITAE. Por favor llénelo
                                        completamente y cuando termine haga “clic” sobre el botón de enviar. Cada parte tiene su botón de enviar.
                                        <br/>
                                        <br/>
                                        Recuerde que solo podrá realizar este formulario una vez. Enviada la información ya no se podrán hacer cambios.
                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Atentamente <br> El equipo de <b>THIGO</b>.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <div class=""
                     style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;">
                    <table width="100%"
                           style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                            <td class="aligncenter content-block"
                                style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0 0 20px;"
                                align="center" valign="top"> Derechos Reservados &#169; <a href="#"
                                                               style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; color: #999; text-decoration: underline; margin: 0;">THIGO</a> ' . date("Y") . '
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </td>
        <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
            valign="top"></td>
    </tr>
</table>';
    return $text;
} // end write_messagePermiso


//Diego -> Construye el mensaje del correo para el periodo de evaluación
function writeMessageEvaluacion($datos)
{
    return '<body style="margin:0;padding:0;">
	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
		<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
					<tr>
						<td align="center" style="padding:40px 0 30px 0;background:#bdcde3;">
							<img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" alt="" width="100" style="height:auto;display:block;" />
						</td>
					</tr>
					<tr>
						<td style="padding:36px 30px 42px 30px;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
								<tr>
									<td style="padding:0 0 36px 0;color:#153643; text-align:justify">
										<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Período de evaluación<hr></h1>
										<p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">Estimad@ ' . $datos['nombre'] . ':<br>
                                            Se ha abierto un nuevo período de evaluación de ' . $datos['tipo'] . '.<br>
                                            La fecha de inicio de la evaluación de ' . $datos['tipo'] . ' sera el: <br><b>' . longDate($datos['FechaInicio'], " de ") . '</b> y terminara el: <b>' . longDate($datos['FechaFin'], " de ") . '</b>.
                                            <br>
                                            Te invitamos a que ingreses a la plataforma <strong>THIGO</strong> para realizar tu evaluación.
                                        </p>
                                        <div class="col-md-12 text-center" style="text-align: center;"><br>
										<a href="' . base_url("Access/index") . '" class="btn btn-primary"
                                           style="border-radius:25px !important; font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #343a40; margin: 0; border-color: #343a40; border-style: solid; border-width: 8px 16px;">
                                           Inicie Sesión ahora</a>
                                        </div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:30px;background:#5a6771;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
								<tr>
									<td style="padding:0;width:50%;" align="left">
										<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        Atentamente <br> El equipo de <b>THIGO</b>.<br>
                                        &reg; THIGO ' . date('Y') . '
										</p>
									</td>
									<td style="padding:0;width:50%;" align="right">
										<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
											<tr>
												<td style="padding:0 0 0 10px;width:38px;">
													<a style="color:#ffffff;"><img src="https://thigo.mx/assets/images/thigo/3.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
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
} // end writeMessageContacto

//Alain -> Construye el mensaje del correo para la recuperacion
function writeMessageRecuperar($datos)
{
    return '<table class="body-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
        <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
        <td class="container" width="600"
            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"
            valign="top">
            <div class="content"
                 style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                <table class="main" width="100%" cellpadding="0" cellspacing="0"
                       style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; display: inline-block; margin: 0; border: 1px solid #e9e9e9;"
                       bgcolor="#fff">
                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class=""
                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #e3eaef; margin: 0; padding: 20px;"
                            align="center" bgcolor="#71b6f9" valign="top">
                            <a href="#"> <img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" height="70" alt="logo"/></a> <br/>
                            <span style="margin-top: 10px;display: block; color:#313a46;">Recuperación de Contraseña</span>
                        </td>
                    </tr>
                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class="content-wrap"
                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;"
                            valign="top">
                            <table width="100%" cellpadding="0" cellspacing="0"
                                   style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">

                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                       Has solicitado la recuperación de contraseña. Por favor ingresa al siguiente enlace para continuar con el proceso:
                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                       <a href=' . $datos["enlace"] . ' class="">Enlace</a>

                                    </td>
                                </tr>

                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        ¡Buen dia! <br> El equipo de <b>THIGO</b>.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <div class=""
                     style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;">
                    <table width="100%"
                           style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                            <td class="aligncenter content-block"
                                style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0 0 20px;"
                                align="center" valign="top"> Derechos Reservados &#169; <a href="#"
                                                               style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; color: #999; text-decoration: underline; margin: 0;">THIGO</a> ' . date("Y") . '
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </td>
        <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
            valign="top"></td>
    </tr>
</table>';
} // end writeMessageRecuperar

//Lia -> Construye el mensaje del correo para los colaboradores
function writeMessageColaborador($datos)
{
    return '<body style="margin:0;padding:0;">
	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
		<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
					<tr>
						<td align="center" style="padding:40px 0 30px 0;background:#bdcde3;">
							<img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" alt="" width="100" style="height:auto;display:block;" />
						</td>
					</tr>
					<tr>
						<td style="padding:36px 30px 42px 30px;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
								<tr>
									<td style="padding:0 0 36px 0;color:#153643; text-align:justify">
										<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Datos de acceso<hr></h1>
										<p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">Estimad@ ' . $datos['nombre'] . ':<br>
                                        Es un gusto para el área de Recursos Humano contar con una herramienta que nos permite estar mas cerca de ti, con el objetivo de facilitar nuestros procesos.<br>
                                        <br>
                                        Recursos Humano de Caja Popular Alianza Sahuayo ha creado una cuenta para ti en THIGO.<br>
                                        ¡Enhorabuena! <br><br>
                                        Tus datos de acceso son: <br>
                                        Link: <a href="http://sahuayo.thigo.mx">http://sahuayo.thigo.mx</a><br>
                                        Usuario: <strong>' . $datos['username'] . '</strong><br>
                                        Contraseña: <strong> ' . $datos['password'] . ' </strong>
                                        </p>
                                        <div class="col-md-12 text-center" style="text-align: center;"><br>
										<a href="' . base_url("Access/index") . '" class="btn btn-primary"
                                           style="border-radius:25px !important; font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #343a40; margin: 0; border-color: #343a40; border-style: solid; border-width: 8px 16px;">
                                           Inicie Sesión ahora</a>
                                        </div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:30px;background:#5a6771;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
								<tr>
									<td style="padding:0;width:50%;" align="left">
										<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        Atentamente <br> El equipo de <b>THIGO</b>.<br>
                                        &reg; THIGO ' . date('Y') . '
										</p>
									</td>
									<td style="padding:0;width:50%;" align="right">
										<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
											<tr>
												<td style="padding:0 0 0 10px;width:38px;">
													<a style="color:#ffffff;"><img src="https://thigo.mx/assets/images/thigo/3.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
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

//Lia->Aviso de actividad de contacto
function writeMessageAvisoContacto($datos)
{
    return '<table class="body-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
        <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
        <td class="container" width="600"
            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"
            valign="top">
            <div class="content"
                 style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                <table class="main" width="100%" cellpadding="0" cellspacing="0"
                       style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; display: inline-block; margin: 0; border: 1px solid #e9e9e9;"
                       bgcolor="#fff">
                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class=""
                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #e3eaef; margin: 0; padding: 20px;"
                            align="center" bgcolor="#71b6f9" valign="top">
                            <a href="#"> <img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" height="70" alt="logo"/></a> <br/>
                            <span style="margin-top: 10px;display: block; color:#313a46;">Sistema de Administración de Recursos Humanos</span>
                        </td>
                    </tr>
                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class="content-wrap"
                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;"
                            valign="top">
                            <table width="100%" cellpadding="0" cellspacing="0"
                                   style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Estimado ' . $datos['nombre'] . ':
                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Hemos notado que no has dado de alta tu empresa  en THIGO, el Sistema de Administración de Recursos Humanos de CCSistemas.
                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                       Para seguir con el proceso, por favor inicia sesión en la plataforma, con el correo ' . $datos['correo'] . ' y con la contraseña que te generamos al momento de tu registro.
                                       <br>
                                       <br>
                                       Si tienes alguna duda o pregunta escribenos al correo <strong>info@ccsistemas.com</strong> y con gusto te atenderemos.<br>

                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        <a href="' . base_url("Access/index") . '" class="btn-primary"
                                           style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #02c0ce; margin: 0; border-color: #02c0ce; border-style: solid; border-width: 8px 16px;">
                                           Iniciar Sesión ahora</a>
                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                         ¡Buen dia!<br>El equipo de <b>THIGO</b>.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <div class=""
                     style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;">
                    <table width="100%"
                           style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                            <td class="aligncenter content-block"
                                style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0 0 20px;"
                                align="center" valign="top"> Derechos Reservados &#169; <a href="#"
                                                               style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; color: #999; text-decoration: underline; margin: 0;">THIGO</a> ' . date("Y") . '
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </td>
        <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
            valign="top"></td>
    </tr>
</table>';
}

//Lia -> Construye el mensaje del correo para la solicitud de vacaciones
function writeMessageSolicitudVacaciones($datos)
{
    return '<body style="margin:0;padding:0;">
	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
		<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
					<tr>
						<td align="center" style="padding:40px 0 30px 0;background:#bdcde3;">
							<img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" alt="" width="100" style="height:auto;display:block;" />
						</td>
					</tr>
					<tr>
						<td style="padding:36px 30px 42px 30px;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
								<tr>
									<td style="padding:0 0 36px 0;color:#153643; text-align:justify">
										<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Solicitud de Vacaciones<hr></h1>
										<p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">Estimad@ ' . $datos['NombreJefe'] . ':<br>
                                        Mediante el presente se le comunica que el colaborador a su cargo ' . $datos['NombreSolicitante'] . ', ha registrado una nueva solicitud de vacaciones en la plataforma THIGO.<br>
                                        Para mayor información, revise la solicitud de vacaciones en la plataforma.
                                        </p>
                                        <div class="col-md-12 text-center" style="text-align: center;"><br>
										<a href="' . base_url("Access/index") . '" class="btn btn-primary"
                                           style="border-radius:25px !important; font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #343a40; margin: 0; border-color: #343a40; border-style: solid; border-width: 8px 16px;">
                                           Inicie Sesión ahora</a>
                                        </div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:30px;background:#5a6771;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
								<tr>
									<td style="padding:0;width:50%;" align="left">
										<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        Atentamente <br> El equipo de <b>THIGO</b>.<br>
                                        &reg; THIGO ' . date('Y') . '
										</p>
									</td>
									<td style="padding:0;width:50%;" align="right">
										<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
											<tr>
												<td style="padding:0 0 0 10px;width:38px;">
													<a style="color:#ffffff;"><img src="https://thigo.mx/assets/images/thigo/3.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
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
} // end writeMessageSolicitudVacaciones

//Lia->Construye el mensaje de autorizacion de solicitud de vacaciones
function writeMessageVacacionesAutorizadas($datos)
{
    return '<body style="margin:0;padding:0;">
	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
		<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
					<tr>
						<td align="center" style="padding:40px 0 30px 0;background:#bdcde3;">
							<img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" alt="" width="100" style="height:auto;display:block;" />
						</td>
					</tr>
					<tr>
						<td style="padding:36px 30px 42px 30px;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
								<tr>
									<td style="padding:0 0 36px 0;color:#153643; text-align:justify">
										<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Solicitud de Vacaciones<hr></h1>
										<p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">Estimad@ ' . $datos['NombreSolicitante'] . ':<br>
                                        Mediante el presente se le comunica que el colaborador  ' . $datos['NombreJefe'] . ', ha autorizado su solicitud de vacaciones en la plataforma THIGO.<br>
                                        Para mayor información, revise la solicitud de vacaciones en la plataforma.
                                        </p>
                                        <div class="col-md-12 text-center" style="text-align: center;"><br>
										<a href="' . base_url("Access/index") . '" class="btn btn-primary"
                                           style="border-radius:25px !important; font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #343a40; margin: 0; border-color: #343a40; border-style: solid; border-width: 8px 16px;">
                                           Inicie Sesión ahora</a>
                                        </div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:30px;background:#5a6771;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
								<tr>
									<td style="padding:0;width:50%;" align="left">
										<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        Atentamente <br> El equipo de <b>THIGO</b>.<br>
                                        &reg; THIGO ' . date('Y') . '
										</p>
									</td>
									<td style="padding:0;width:50%;" align="right">
										<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
											<tr>
												<td style="padding:0 0 0 10px;width:38px;">
													<a style="color:#ffffff;"><img src="https://thigo.mx/assets/images/thigo/3.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
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

//Lia->constriye el mensaje de aplicacion de vacaciones
function writeMessageVacacionesAplicadas($datos)
{
    return '<body style="margin:0;padding:0;">
	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
		<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
					<tr>
						<td align="center" style="padding:40px 0 30px 0;background:#bdcde3;">
							<img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" alt="" width="100" style="height:auto;display:block;" />
						</td>
					</tr>
					<tr>
						<td style="padding:36px 30px 42px 30px;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
								<tr>
									<td style="padding:0 0 36px 0;color:#153643; text-align:justify">
										<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Solicitud de Vacaciones<hr></h1>
										<p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">Estimad@ ' . $datos['NombreSolicitante'] . ':<br>
                                        Mediante el presente se le comunica que el colaborador  ' . $datos['NombreAplico'] . ', ha aplicado su solicitud de vacaciones en la plataforma THIGO.
                                        <br> Para mayor información, revise la solicitud de vacaciones en la plataforma.
                                        </p>
                                        <div class="col-md-12 text-center" style="text-align: center;"><br>
										<a href="' . base_url("Access/index") . '" class="btn btn-primary"
                                           style="border-radius:25px !important; font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #343a40; margin: 0; border-color: #343a40; border-style: solid; border-width: 8px 16px;">
                                           Inicie Sesión ahora</a>
                                        </div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:30px;background:#5a6771;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
								<tr>
									<td style="padding:0;width:50%;" align="left">
										<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        Atentamente <br> El equipo de <b>THIGO</b>.<br>
                                        &reg; THIGO ' . date('Y') . '
										</p>
									</td>
									<td style="padding:0;width:50%;" align="right">
										<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
											<tr>
												<td style="padding:0 0 0 10px;width:38px;">
													<a style="color:#ffffff;"><img src="https://thigo.mx/assets/images/thigo/3.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
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

//Lia->construye el mensaje de vacaciones rechazadas
function writeMessageVacacionesRechazadas($datos)
{
    return '<body style="margin:0;padding:0;">
	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
		<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
					<tr>
						<td align="center" style="padding:40px 0 30px 0;background:#bdcde3;">
							<img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" alt="" width="100" style="height:auto;display:block;" />
						</td>
					</tr>
					<tr>
						<td style="padding:36px 30px 42px 30px;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
								<tr>
									<td style="padding:0 0 36px 0;color:#153643; text-align:justify">
										<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Solicitud de Vacaciones<hr></h1>
										<p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">Estimad@ ' . $datos['NombreSolicitante'] . ':<br>
                                        Mediante el presente se le comunica que su solicitud de vacaciones ha sido rechazada en la plataforma THIGO.
                                        <br> Para mayor información, revise la solicitud de vacaciones en la plataforma.
                                        </p>
                                        <div class="col-md-12 text-center" style="text-align: center;"><br>
										<a href="' . base_url("Access/index") . '" class="btn btn-primary"
                                           style="border-radius:25px !important; font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #343a40; margin: 0; border-color: #343a40; border-style: solid; border-width: 8px 16px;">
                                           Inicie Sesión ahora</a>
                                        </div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:30px;background:#5a6771;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
								<tr>
									<td style="padding:0;width:50%;" align="left">
										<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        Atentamente <br> El equipo de <b>THIGO</b>.<br>
                                        &reg; THIGO ' . date('Y') . '
										</p>
									</td>
									<td style="padding:0;width:50%;" align="right">
										<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
											<tr>
												<td style="padding:0 0 0 10px;width:38px;">
													<a style="color:#ffffff;"><img src="https://thigo.mx/assets/images/thigo/3.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
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

//Lia->Construye el mensaje del correo de solicitud de personal
function write_messagesSolicitudPersonal($datos)
{
    $text = '<table class="body-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
        <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
        <td class="container" width="600"
            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"
            valign="top">
            <div class="content"
                 style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                <table class="main" width="100%" cellpadding="0" cellspacing="0"
                       style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; display: inline-block; margin: 0; border: 1px solid #e9e9e9;"
                       bgcolor="#fff">
                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class=""
                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #e3eaef; margin: 0; padding: 20px;"
                            align="center" bgcolor="#71b6f9" valign="top">
                            <a href="#"> <img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" height="70" alt="logo"/></a> <br/>
                            <span style="margin-top: 10px;display: block; color:#313a46;">Solicitud de personal</span>
                        </td>
                    </tr>
                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class="content-wrap"
                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;"
                            valign="top">
                            <table width="100%" cellpadding="0" cellspacing="0"
                                   style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Estimado ' . $datos['nombreCh'] . '.
                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Mediante el presente se le comunica que el colaborador(a) ' . $datos['solicita'] . ' ha registrado una solicitud de personal para el departamento ' . $datos['departamento'] . ' , por favor inicie sesión en plataforma para mas información de la solictud.
                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Atentamente <br> El equipo de <b>THIGO</b>.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <div class=""
                     style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;">
                    <table width="100%"
                           style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                            <td class="aligncenter content-block"
                                style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0 0 20px;"
                                align="center" valign="top"> Derechos Reservados &#169; <a href="#"
                                                               style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; color: #999; text-decoration: underline; margin: 0;">THIGO</a> ' . date("Y") . '
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </td>
        <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
            valign="top"></td>
    </tr>
</table>';
    return $text;
}

//Lia->Contenido del mensaje de autorizacion de la solicitud de personal
function write_messagesAutorizarSolicitudPersonal($datos)
{
    $text = '<table class="body-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
        <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
        <td class="container" width="600"
            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"
            valign="top">
            <div class="content"
                 style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                <table class="main" width="100%" cellpadding="0" cellspacing="0"
                       style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; display: inline-block; margin: 0; border: 1px solid #e9e9e9;"
                       bgcolor="#fff">
                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class=""
                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #e3eaef; margin: 0; padding: 20px;"
                            align="center" bgcolor="#71b6f9" valign="top">
                            <a href="#"> <img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" height="70" alt="logo"/></a> <br/>
                            <span style="margin-top: 10px;display: block; color:#313a46;">Solicitud de personal</span>
                        </td>
                    </tr>
                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class="content-wrap"
                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;"
                            valign="top">
                            <table width="100%" cellpadding="0" cellspacing="0"
                                   style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Estimado ' . $datos['autoriza'] . '.
                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Mediante el presente se le comunica que el colaborador(a) de Recursos Humanos ' . $datos['nombreCh'] . ' le ha enviado una solicitud de personal para el departamento ' . $datos['departamento'] . ' , por favor inicie sesión en plataforma para su revisión y autorización o rechazo.
                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Atentamente <br> El equipo de <b>THIGO</b>.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <div class=""
                     style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;">
                    <table width="100%"
                           style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                            <td class="aligncenter content-block"
                                style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0 0 20px;"
                                align="center" valign="top"> Derechos Reservados &#169; <a href="#"
                                                               style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; color: #999; text-decoration: underline; margin: 0;">THIGO</a> ' . date("Y") . '
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </td>
        <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
            valign="top"></td>
    </tr>
</table>';
    return $text;
}

//Lia->Mensaje al jefe de departamento del proceso de la solicitud
function write_messagesProcesoSolicitudPersonal($datos)
{
    if ($datos['estatus'] === "AUTORIZADA") $msg = "El departamento de Recursos Humanos, ya podrá comenzar con el proceso de reclutamiento.";
    else $msg = "Comuníquece con el departamento de Recursos Humanos para cualquier duda o aclaración acerca de la solicitud.";
    $text = '<table class="body-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
        <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
        <td class="container" width="600"
            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"
            valign="top">
            <div class="content"
                 style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                <table class="main" width="100%" cellpadding="0" cellspacing="0"
                       style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; display: inline-block; margin: 0; border: 1px solid #e9e9e9;"
                       bgcolor="#fff">
                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class=""
                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #e3eaef; margin: 0; padding: 20px;"
                            align="center" bgcolor="#71b6f9" valign="top">
                            <a href="#"> <img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" height="70" alt="logo"/></a> <br/>
                            <span style="margin-top: 10px;display: block; color:#313a46;">Solicitud de personal</span>
                        </td>
                    </tr>
                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class="content-wrap"
                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;"
                            valign="top">
                            <table width="100%" cellpadding="0" cellspacing="0"
                                   style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Estimado ' . $datos['solicito'] . '.
                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Mediante el presente se le comunica que la solicitud de personal para el departamento de ' . $datos['departamento'] . ', que registro el día ' . longDate($datos['fecha'], ' de ') . ', con el folio ' . $datos['folio'] . '  , ha sido ' . $datos['estatus'] . '.<br>
                                        ' . $msg . '

                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Atentamente <br> El equipo de <b>THIGO</b>.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <div class=""
                     style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;">
                    <table width="100%"
                           style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                            <td class="aligncenter content-block"
                                style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0 0 20px;"
                                align="center" valign="top"> Derechos Reservados &#169; <a href="#"
                                                               style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; color: #999; text-decoration: underline; margin: 0;">THIGO</a> ' . date("Y") . '
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </td>
        <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
            valign="top"></td>
    </tr>
</table>';
    return $text;
}

//Lia->Mensaje de correo a CH cuando la solicitud ha sido aprobada
function write_messagesSolicitudPersonalAprobada($datos)
{
    $text = '<table class="body-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
        <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
        <td class="container" width="600"
            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"
            valign="top">
            <div class="content"
                 style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                <table class="main" width="100%" cellpadding="0" cellspacing="0"
                       style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; display: inline-block; margin: 0; border: 1px solid #e9e9e9;"
                       bgcolor="#fff">
                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class=""
                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #e3eaef; margin: 0; padding: 20px;"
                            align="center" bgcolor="#71b6f9" valign="top">
                            <a href="#"> <img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" height="70" alt="logo"/></a> <br/>
                            <span style="margin-top: 10px;display: block; color:#313a46;">Solicitud de personal</span>
                        </td>
                    </tr>
                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class="content-wrap"
                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;"
                            valign="top">
                            <table width="100%" cellpadding="0" cellspacing="0"
                                   style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Estimado ' . $datos['nombreCh'] . '.
                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Mediante el presente se le comunica que la solicitud de personal para el departamento de ' . $datos['departamento'] . ', que registro el colaborador (a) ' . $datos['solicito'] . ' el día ' . longDate($datos['fecha'], ' de ') . ', con el folio ' . $datos['folio'] . '  , ha sido AUTORIZADA .<br>
                                        Dando continuación al proceso de reclutamiento, ya puede registrar candidatos a esa solicitud en la plataforma.

                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Atentamente <br> El equipo de <b>THIGO</b>.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <div class=""
                     style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;">
                    <table width="100%"
                           style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                            <td class="aligncenter content-block"
                                style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0 0 20px;"
                                align="center" valign="top"> Derechos Reservados &#169; <a href="#"
                                                               style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; color: #999; text-decoration: underline; margin: 0;">THIGO</a> ' . date("Y") . '
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </td>
        <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
            valign="top"></td>
    </tr>
</table>';
    return $text;
}


function write_messageConvocatoriaInstructor($datos)
{
    $convocatoria = convocatoriaCapacitacion((int)$datos['id']);

    return '<body style="margin:0;padding:0;">
	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
		<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
					<tr>
						<td align="center" style="padding:40px 0 30px 0;background:#bdcde3;">
							<img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" alt="" width="100" style="height:auto;display:block;" />
						</td>
					</tr>
					<tr>
						<td style="padding:36px 30px 42px 30px;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
								<tr>
									<td style="padding:0 0 36px 0;color:#153643; text-align:justify">
										<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Convocatoria de capacitación<hr></h1>
										<p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">Estimad@ ' . $datos['nombre'] . ':<br>
                                        Mediante el presente se le invita a participar en la siguiente convocatoria:
                                        <div class="row text-center" >
                                             <img src="' . $convocatoria[0] . '" width="300" class="img-fluid" >
                                        </div>
                                        </p>
                                        <div class="col-md-12 text-center" style="text-align: center;"><br>
										<a href="' . base_url("Access/index") . '" class="btn btn-primary"
                                           style="border-radius:25px !important; font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #343a40; margin: 0; border-color: #343a40; border-style: solid; border-width: 8px 16px;">
                                           Inicie Sesión ahora</a>
                                        </div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:30px;background:#5a6771;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
								<tr>
									<td style="padding:0;width:50%;" align="left">
										<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        Atentamente <br> El equipo de <b>THIGO</b>.<br>
                                        &reg; THIGO ' . date('Y') . '
										</p>
									</td>
									<td style="padding:0;width:50%;" align="right">
										<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
											<tr>
												<td style="padding:0 0 0 10px;width:38px;">
													<a style="color:#ffffff;"><img src="https://thigo.mx/assets/images/thigo/3.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
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

function write_messageConvocatoriaParticipante($datos)
{
    $convocatoria = convocatoriaCapacitacion($datos['id']);
    return '<body style="margin:0;padding:0;">
	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
		<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
					<tr>
						<td align="center" style="padding:40px 0 30px 0;background:#bdcde3;">
							<img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" alt="" width="100" style="height:auto;display:block;" />
						</td>
					</tr>
					<tr>
						<td style="padding:36px 30px 42px 30px;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
								<tr>
									<td style="padding:0 0 36px 0;color:#153643; text-align:justify">
										<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Convocatoria de capacitación<hr></h1>
										<p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">Estimad@ ' . $datos['nombre'] . ':<br>
                                        Mediante el presente se le invita a participar en la siguiente convocatoria:
                                        <div class="row justify-content-center" >
                                        <img src="' . $convocatoria[0] . '" width="300" class="img-fluid" >
                                        </div>
                                        </p>
                                        <div class="col-md-12 text-center" style="text-align: center;"><br>
										<a href="' . base_url("Access/index") . '" class="btn btn-primary"
                                           style="border-radius:25px !important; font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #343a40; margin: 0; border-color: #343a40; border-style: solid; border-width: 8px 16px;">
                                           Inicie Sesión ahora</a>
                                        </div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:30px;background:#5a6771;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
								<tr>
									<td style="padding:0;width:50%;" align="left">
										<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        Atentamente <br> El equipo de <b>THIGO</b>.<br>
                                        &reg; THIGO ' . date('Y') . '
										</p>
									</td>
									<td style="padding:0;width:50%;" align="right">
										<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
											<tr>
												<td style="padding:0 0 0 10px;width:38px;">
													<a style="color:#ffffff;"><img src="https://thigo.mx/assets/images/thigo/3.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
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

function write_messageNuevaSolicitudPersonal($datos)
{
    /*if (!empty($datos['sol_PuestoID'])) {
        $puesto = $datos['pue_Nombre'];
    } else {
        $puesto = $datos['sol_NuevoPuesto'];
    }*/
    return '<body style="margin:0;padding:0;">
	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
		<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
					<tr>
						<td align="center" style="padding:40px 0 30px 0;background:#bdcde3;">
							<img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" alt="" width="100" style="height:auto;display:block;" />
						</td>
					</tr>
					<tr>
						<td style="padding:36px 30px 42px 30px;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
								<tr>
									<td style="padding:0 0 36px 0;color:#153643; text-align:justify">
										<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Nueva solicitud de personal<hr></h1>
										<p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        Estimad@ ' . $datos['nombre'] . '<br>
                                        Mediante el presente se comunica que ' . $datos['solicitante'] . ' ha registrado una nueva solicitud de personal, más información el a paltaforma Thigo.
                                        </p>
                                        <div class="col-md-12 text-center" style="text-align: center;"><br>
										<a href="' . base_url("Access/index") . '" class="btn btn-primary"
                                           style="border-radius:25px !important; font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #343a40; margin: 0; border-color: #343a40; border-style: solid; border-width: 8px 16px;">
                                           Inicie Sesión ahora</a>
                                        </div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:30px;background:#5a6771;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
								<tr>
									<td style="padding:0;width:50%;" align="left">
										<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        Atentamente <br> El equipo de <b>THIGO</b>.<br>
                                        &reg; THIGO ' . date('Y') . '
										</p>
									</td>
									<td style="padding:0;width:50%;" align="right">
										<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
											<tr>
												<td style="padding:0 0 0 10px;width:38px;">
													<a style="color:#ffffff;"><img src="https://thigo.mx/assets/images/thigo/3.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
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

function write_messageRechazoSolicitud($datos)
{
    return '<body style="margin:0;padding:0;">
	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
		<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
					<tr>
						<td align="center" style="padding:40px 0 30px 0;background:#bdcde3;">
							<img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" alt="" width="100" style="height:auto;display:block;" />
						</td>
					</tr>
					<tr>
						<td style="padding:36px 30px 42px 30px;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
								<tr>
									<td style="padding:0 0 36px 0;color:#153643; text-align:justify">
										<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">' . strtoupper($datos['can_Nombre']) . '<hr></h1>
										<p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        Estimad@ ' . utf8_decode($datos['can_Nombre']) . ',<br>
                                        Se concluyó el proceso de selección del candidato para el puesto de ' . $datos['puesto'] . ' en <b>Cajas Populares Alianza Sahuayo</b>.<br>
                                        Se analizaron los perfiles de los candidatos finalistas incluyéndolo, se valoraron distintos aspectos, como lo son:<br></p>
                                        <li>CV</li>
                                        <li>Entrevistas</li>
                                        <li>Prueba Psicometrica</li>
                                        <li>y la experiencia laboral.</li>
                                        <br>
                                        <p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">Lamentablemente hemos elegido otro candidato, sin embargo le agradecemos su interés, el tiempo invertido en el proceso y el querer pertener a la red <b>ALIANZA</b>.<br>
                                        Seguiremos considerándolo para futuras vacantes, que se adapten a su perfil profesional.<br>
                                        Le deseamos todo lo mejor en su búsqueda de trabajo y en sus próximos pasos profesionales.<br>
                                        </p>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:30px;background:#5a6771;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
								<tr>
									<td style="padding:0;width:50%;" align="left">
										<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        Atentamente <br> El equipo de <b>THIGO</b>.<br>
                                        &reg; THIGO ' . date('Y') . '
										</p>
									</td>
									<td style="padding:0;width:50%;" align="right">
										<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
											<tr>
												<td style="padding:0 0 0 10px;width:38px;">
													<a style="color:#ffffff;"><img src="https://thigo.mx/assets/images/thigo/3.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
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

function write_messageEntrevista1($datos)
{
    return '<table class="body-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
        <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
        <td class="container" width="600"
            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"
            valign="top">
            <div class="content"
                 style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                <table class="main" width="100%" cellpadding="0" cellspacing="0"
                       style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; display: inline-block; margin: 0; border: 1px solid #e9e9e9;"
                       bgcolor="#fff">
                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class=""
                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #e3eaef; margin: 0; padding: 20px;"
                            align="center" bgcolor="#71b6f9" valign="top">
                            <a href="#"> <img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" height="70" alt="logo"/></a> <br/>
                            <span style="margin-top: 10px;display: block; color:#313a46;"></span>
                        </td>
                    </tr>
                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class="content-wrap"
                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;"
                            valign="top">
                            <table width="100%" cellpadding="0" cellspacing="0"
                                   style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block text-justify"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        <b>Estimado ' . strtoupper($datos['can_Nombre']) . '</b>, agradecemos tu interés en formar parte de esta Institución. <br>
                                        ¡Hemos comenzado a gestionar los curriculums, y has sido elegido para continuar en el proceso de selección!, me gustaría conocerte y ampliar más la información de tu solicitud, es por ello quiero agendar una entrevista contigo,  para el próximo<br> <b>' . longDateTime($datos['can_FechaEntrevista1'], ' de ') . '.</b><br> Te pido presentarte en nuestra sucursal ubicada en ' . strtoupper($datos['can_DireccionSucursalE1']) . '.
                                        Favor de confirmar asistencia, cualquier duda o comentario no dudes en contactarme.
                                        Saludos cordiales.


                                    </td>
                                </tr>

                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Atentamente <br> El equipo de <b>THIGO</b>.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <div class=""
                     style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;">
                    <table width="100%"
                           style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                            <td class="aligncenter content-block"
                                style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0 0 20px;"
                                align="center" valign="top"> Derechos Reservados &#169; <a href="#"
                                                               style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; color: #999; text-decoration: underline; margin: 0;">THIGO</a> ' . date("Y") . '
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </td>
        <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
            valign="top"></td>
    </tr>
</table>';
}

function write_messageEntrevista2($datos)
{
    return '<table class="body-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
        <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
        <td class="container" width="600"
            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"
            valign="top">
            <div class="content"
                 style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                <table class="main" width="100%" cellpadding="0" cellspacing="0"
                       style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; display: inline-block; margin: 0; border: 1px solid #e9e9e9;"
                       bgcolor="#fff">
                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class=""
                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #e3eaef; margin: 0; padding: 20px;"
                            align="center" bgcolor="#71b6f9" valign="top">
                            <a href="#"> <img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" height="70" alt="logo"/></a> <br/>
                            <span style="margin-top: 10px;display: block; color:#313a46;"></span>
                        </td>
                    </tr>
                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class="content-wrap"
                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;"
                            valign="top">
                            <table width="100%" cellpadding="0" cellspacing="0"
                                   style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block text-justify"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        <b>Estimado ' . strtoupper($datos['can_Nombre']) . '</b><br>
                                        Estamos casi en la recta final del proceso de selección, agradezco tu paciencia y participación. <br>
                                        Es momento de tener una entrevista con el jefe directo de la vacante y dar continuidad al proceso, por lo que te pido presentarte en la sucursal el día <br>
                                        ' . longDateTime($datos['can_FechaEntrevista2'], ' de ') . '.<br>
                                        Te pido por favor, llevar una copia de tu acta de nacimiento y reporte de buró de crédito, este último, puedes solicitarlo directamente en nuestra sucursal o tramitarlo vía internet.<br>
                                        Para agilizar el proceso, también puedes enviar los documentos por correo antes de tener tu entrevista.
                                        Cualquier duda o comentario quedo a la orden.<br>
                                        Saludos cordiales.



                                    </td>
                                </tr>

                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Atentamente <br> El equipo de <b>THIGO</b>.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <div class=""
                     style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;">
                    <table width="100%"
                           style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                            <td class="aligncenter content-block"
                                style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0 0 20px;"
                                align="center" valign="top"> Derechos Reservados &#169; <a href="#"
                                                               style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; color: #999; text-decoration: underline; margin: 0;">THIGO</a> ' . date("Y") . '
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </td>
        <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
            valign="top"></td>
    </tr>
</table>';
}

function write_messageEvaluacionCandidato($datos)
{
    return '<table class="body-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
        <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
        <td class="container" width="600"
            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"
            valign="top">
            <div class="content"
                 style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                <table class="main" width="100%" cellpadding="0" cellspacing="0"
                       style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; display: inline-block; margin: 0; border: 1px solid #e9e9e9;"
                       bgcolor="#fff">
                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class=""
                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #e3eaef; margin: 0; padding: 20px;"
                            align="center" bgcolor="#71b6f9" valign="top">
                            <a href="#"> <img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" height="70" alt="logo"/></a> <br/>
                            <span style="margin-top: 10px;display: block; color:#313a46;">' . strtoupper($datos['can_Nombre']) . '</span>
                        </td>
                    </tr>
                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class="content-wrap"
                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;"
                            valign="top">
                            <table width="100%" cellpadding="0" cellspacing="0"
                                   style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block text-justify"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        <b>Hola, ' . strtoupper($datos['can_Nombre']) . '</b><br>

                                        Gracias por tu asistencia a la entrevista. Has sido seleccionado para continuar en el proceso de evaluaciones, a continuación encontrarás un link y contraseña para que puedas contestarlas.<br>
                                        Tendrás un lapso de 48 hrs para realizarlas a partir de la recepción de este correo. <br>
                                        Seguiré en contacto contigo al momento de recibir tus resultados.<br>
                                        Contraseña:<br>
                                        <b>' . $datos['can_Password'] . '</b><br>
                                        Link:<br>
                                        ' . $datos['can_Link'] . '<br><br>

                                        Así como tambien enviar una copia de tu acta de nacimiento y reporte de buró de crédito, este último, puedes solicitarlo directamente en nuestra sucursal o tramitarlo vía internet.<br>
                                        Puedes enviar tus documentos al siguiente correo:<br>
                                        <b>' . $datos['can_CorreoDocumentos'] . '</b><br>
                                        Cualquier duda o comentario quedo a la orden.<br>

                                        Saludos cordiales.<br>

                                    </td>
                                </tr>

                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Atentamente <br> El equipo de <b>THIGO</b>.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <div class=""
                     style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;">
                    <table width="100%"
                           style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                            <td class="aligncenter content-block"
                                style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0 0 20px;"
                                align="center" valign="top"> Derechos Reservados &#169; <a href="#"
                                                               style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; color: #999; text-decoration: underline; margin: 0;">THIGO</a> ' . date("Y") . '
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </td>
        <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
            valign="top"></td>
    </tr>
</table>';
}

function write_messageActualizacionNormativa($datos)
{
    return '<body style="margin:0;padding:0;">
	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
		<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
					<tr>
						<td align="center" style="padding:40px 0 30px 0;background:#bdcde3;">
							<img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" alt="" width="100" style="height:auto;display:block;" />
						</td>
					</tr>
					<tr>
						<td style="padding:36px 30px 42px 30px;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
								<tr>
									<td style="padding:0 0 36px 0;color:#153643; text-align:justify">
										<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Actualización de reglamento / politicas<hr></h1>
										<p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        Estimad@ ' . utf8_decode($datos['nombre']) . ',<br>
                                        Mediante el presente se le informa que se han actualizado las siguientes politicas o reglamentos:<br>
                                         ' . $datos['asunto'] . '. <br>
                                        Para mas información ,puedes revisar los cambios en la plataforma.
                                        </p>
                                        <div class="col-md-12 text-center" style="text-align: center;"><br>
										<a href="' . base_url("Access/index") . '" class="btn btn-primary"
                                           style="border-radius:25px !important; font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #343a40; margin: 0; border-color: #343a40; border-style: solid; border-width: 8px 16px;">
                                           Inicie Sesión ahora</a>
                                        </div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:30px;background:#5a6771;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
								<tr>
									<td style="padding:0;width:50%;" align="left">
										<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        Atentamente <br> El equipo de <b>THIGO</b>.<br>
                                        &reg; THIGO ' . date('Y') . '
										</p>
									</td>
									<td style="padding:0;width:50%;" align="right">
										<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
											<tr>
												<td style="padding:0 0 0 10px;width:38px;">
													<a style="color:#ffffff;"><img src="https://thigo.mx/assets/images/thigo/3.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
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


function write_messageCorreoNoSeleccionado($datos)
{
    return '<table class="body-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
        <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
        <td class="container" width="600"
            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"
            valign="top">
            <div class="content"
                 style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                <table class="main" width="100%" cellpadding="0" cellspacing="0"
                       style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; display: inline-block; margin: 0; border: 1px solid #e9e9e9;"
                       bgcolor="#fff">
                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class=""
                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #e3eaef; margin: 0; padding: 20px;"
                            align="center" bgcolor="#71b6f9" valign="top">
                            <a href="#"> <img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" height="70" alt="logo"/></a> <br/>
                            <span style="margin-top: 10px;display: block; color:#313a46;">' . strtoupper($datos['can_Nombre']) . '</span>
                        </td>
                    </tr>
                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class="content-wrap"
                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;"
                            valign="top">
                            <table width="100%" cellpadding="0" cellspacing="0"
                                   style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block text-justify"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        <b>Hola, ' . strtoupper($datos['can_Nombre']) . '</b><br>

                                        Gracias por su participación en el proceso de selección de la institución. <br>
                                        Aunque tu experiencia se calificó muy cerca del perfil solicitado, se eligió a otro candidato para el puesto.<br>
                                        Estamos interesados en mantener su Curriculum Vitae en la base de datos para que podamos contactarlo nuevamente tan pronto como surja otra oportunidad que se ajuste a su perfil.
                                        <br>

                                        Saludos cordiales.<br>

                                    </td>
                                </tr>

                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Atentamente <br> El equipo de <b>THIGO</b>.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <div class=""
                     style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;">
                    <table width="100%"
                           style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                            <td class="aligncenter content-block"
                                style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0 0 20px;"
                                align="center" valign="top"> Derechos Reservados &#169; <a href="#"
                                                               style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; color: #999; text-decoration: underline; margin: 0;">THIGO</a> ' . date("Y") . '
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </td>
        <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
            valign="top"></td>
    </tr>
</table>';
}

function write_messageCandidatoSeleccionado($datos)
{
    return '<table class="body-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
        <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
        <td class="container" width="600"
            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"
            valign="top">
            <div class="content"
                 style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                <table class="main" width="100%" cellpadding="0" cellspacing="0"
                       style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; display: inline-block; margin: 0; border: 1px solid #e9e9e9;"
                       bgcolor="#fff">
                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class=""
                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #e3eaef; margin: 0; padding: 20px;"
                            align="center" bgcolor="#71b6f9" valign="top">
                            <a href="#"> <img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" height="70" alt="logo"/></a> <br/>
                            <span style="margin-top: 10px;display: block; color:#313a46;">' . strtoupper($datos['can_Nombre']) . '</span>
                        </td>
                    </tr>
                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class="content-wrap"
                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;"
                            valign="top">
                            <table width="100%" cellpadding="0" cellspacing="0"
                                   style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block text-justify"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        <b>Hola, ' . strtoupper($datos['can_Nombre']) . '</b><br>

                                        Gracias por su participación en el proceso de selección de la institución. <br>
                                        Haz sido seleccionado para trabajar con nosotros, gracias por tu paciencia.<br>
                                       <br>
                                       A continuación te enviamos una carta de bienvenida y un link para agilizar tu proceso de entrada:<br>
                                       <b>' . $datos['url'] . '</b>

                                        Saludos cordiales.<br>

                                    </td>
                                </tr>

                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Atentamente <br> El equipo de <b>THIGO</b>.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <div class=""
                     style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;">
                    <table width="100%"
                           style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                            <td class="aligncenter content-block"
                                style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0 0 20px;"
                                align="center" valign="top"> Derechos Reservados &#169; <a href="#"
                                                               style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; color: #999; text-decoration: underline; margin: 0;">THIGO</a> ' . date("Y") . '
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </td>
        <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
            valign="top"></td>
    </tr>
</table>';
}

function write_messageCartasRecomendacion($datos)
{
    return '<table class="body-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
        <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
        <td class="container" width="600"
            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"
            valign="top">
            <div class="content"
                 style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                <table class="main" width="100%" cellpadding="0" cellspacing="0"
                       style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; display: inline-block; margin: 0; border: 1px solid #e9e9e9;"
                       bgcolor="#fff">
                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class=""
                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #e3eaef; margin: 0; padding: 20px;"
                            align="center" bgcolor="#71b6f9" valign="top">
                            <a href="#"> <img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" height="70" alt="logo"/></a> <br/>
                            <span style="margin-top: 10px;display: block; color:#313a46;">' . strtoupper($datos['can_Nombre']) . '</span>
                        </td>
                    </tr>
                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class="content-wrap"
                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;"
                            valign="top">
                            <table width="100%" cellpadding="0" cellspacing="0"
                                   style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block text-justify"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        <b>Hola, ' . strtoupper($datos['can_Nombre']) . '</b><br>

                                        Gracias por su participación en el proceso de selección de la institución. <br>
                                        Requerimos que nos envies dos cartas de recomendación para continuar en el proceso de selección.<br>
                                       <br>
                                       Puedes enviar tus cartas de recomendación al siguiente correo:<br>
                                       <b>' . $datos['can_CorreoDocumentos'] . '</b>

                                        Saludos cordiales.<br>

                                    </td>
                                </tr>

                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Atentamente <br> El equipo de <b>THIGO</b>.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <div class=""
                     style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;">
                    <table width="100%"
                           style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                            <td class="aligncenter content-block"
                                style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0 0 20px;"
                                align="center" valign="top"> Derechos Reservados &#169; <a href="#"
                                                               style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; color: #999; text-decoration: underline; margin: 0;">THIGO</a> ' . date("Y") . '
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </td>
        <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
            valign="top"></td>
    </tr>
</table>';
}

function write_messagePermisoSolicitud($datos)
{
    return '<body style="margin:0;padding:0;">
	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
		<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
					<tr>
						<td align="center" style="padding:40px 0 30px 0;background:#bdcde3;">
							<img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" alt="" width="100" style="height:auto;display:block;" />
						</td>
					</tr>
					<tr>
						<td style="padding:36px 30px 42px 30px;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
								<tr>
									<td style="padding:0 0 36px 0;color:#153643; text-align:justify">
										<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Solicitud de Permiso<hr></h1>
										<p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        Estimad@ ' . $datos['NombreJefe'] . ',<br>
                                        Mediante el presente se le comunica que el colaborador a su cargo ' . $datos['NombreSolicitante'] . ', ha registrado una nueva solicitud de permiso en THIGO.<br>
                                        Para mayor información, revise la solicitud de permiso en la plataforma.
                                        </p>
                                        <div class="col-md-12 text-center" style="text-align: center;"><br>
										<a href="' . base_url("Access/index") . '" class="btn btn-primary"
                                           style="border-radius:25px !important; font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #343a40; margin: 0; border-color: #343a40; border-style: solid; border-width: 8px 16px;">
                                           Inicie Sesión ahora</a>
                                        </div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:30px;background:#5a6771;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
								<tr>
									<td style="padding:0;width:50%;" align="left">
										<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        Atentamente <br> El equipo de <b>THIGO</b>.<br>
                                        &reg; THIGO ' . date('Y') . '
										</p>
									</td>
									<td style="padding:0;width:50%;" align="right">
										<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
											<tr>
												<td style="padding:0 0 0 10px;width:38px;">
													<a style="color:#ffffff;"><img src="https://thigo.mx/assets/images/thigo/3.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
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

function write_messagePermisoAutorizado($datos)
{
    return '<body style="margin:0;padding:0;">
	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
		<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
					<tr>
						<td align="center" style="padding:40px 0 30px 0;background:#bdcde3;">
							<img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" alt="" width="100" style="height:auto;display:block;" />
						</td>
					</tr>
					<tr>
						<td style="padding:36px 30px 42px 30px;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
								<tr>
									<td style="padding:0 0 36px 0;color:#153643; text-align:justify">
										<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Solicitud de Permiso<hr></h1>
										<p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        Estimad@ ' . $datos['NombreSolicitante'] . ',<br>
                                        Mediante el presente se le comunica que el colaborador  ' . $datos['NombreJefe'] . ', ha autorizado su solicitud de permiso en la plataforma THIGO.
                                        Para mayor información, revise la solicitud de permiso en la plataforma.
                                        </p>
                                        <div class="col-md-12 text-center" style="text-align: center;"><br>
										<a href="' . base_url("Access/index") . '" class="btn btn-primary"
                                           style="border-radius:25px !important; font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #343a40; margin: 0; border-color: #343a40; border-style: solid; border-width: 8px 16px;">
                                           Inicie Sesión ahora</a>
                                        </div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:30px;background:#5a6771;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
								<tr>
									<td style="padding:0;width:50%;" align="left">
										<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        Atentamente <br> El equipo de <b>THIGO</b>.<br>
                                        &reg; THIGO ' . date('Y') . '
										</p>
									</td>
									<td style="padding:0;width:50%;" align="right">
										<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
											<tr>
												<td style="padding:0 0 0 10px;width:38px;">
													<a style="color:#ffffff;"><img src="https://thigo.mx/assets/images/thigo/3.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
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

//Lia->construye el mensaje de vacaciones rechazadas
function writeMessagePermisoRechazadas($datos)
{
    return '<body style="margin:0;padding:0;">
	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
		<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
					<tr>
						<td align="center" style="padding:40px 0 30px 0;background:#bdcde3;">
							<img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" alt="" width="100" style="height:auto;display:block;" />
						</td>
					</tr>
					<tr>
						<td style="padding:36px 30px 42px 30px;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
								<tr>
									<td style="padding:0 0 36px 0;color:#153643; text-align:justify">
										<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Actualización de reglamento / politicas<hr></h1>
										<p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        Estimad@ ' . $datos['NombreSolicitante'] . ',<br>
                                        Mediante el presente se le comunica que su solicitud de permiso ha sido rechazada en la plataforma THIGO.
                                        Para mayor información, revise la solicitud de permiso en la plataforma.
                                        </p>
                                        <div class="col-md-12 text-center" style="text-align: center;"><br>
										<a href="' . base_url("Access/index") . '" class="btn btn-primary"
                                           style="border-radius:25px !important; font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #343a40; margin: 0; border-color: #343a40; border-style: solid; border-width: 8px 16px;">
                                           Inicie Sesión ahora</a>
                                        </div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:30px;background:#5a6771;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
								<tr>
									<td style="padding:0;width:50%;" align="left">
										<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        Atentamente <br> El equipo de <b>THIGO</b>.<br>
                                        &reg; THIGO ' . date('Y') . '
										</p>
									</td>
									<td style="padding:0;width:50%;" align="right">
										<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
											<tr>
												<td style="padding:0 0 0 10px;width:38px;">
													<a style="color:#ffffff;"><img src="https://thigo.mx/assets/images/thigo/3.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
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

function writeMessageInformeSalidas($datos)
{
    return '<body style="margin:0;padding:0;">
	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
		<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
					<tr>
						<td align="center" style="padding:40px 0 30px 0;background:#bdcde3;">
							<img src="https://thigo.mx/assets/images/thigo/CAPITAL HUMANO - NEGRO.png" alt="" width="100" style="height:auto;display:block;" />
						</td>
					</tr>
					<tr>
						<td style="padding:36px 30px 42px 30px;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
								<tr>
									<td style="padding:0 0 36px 0;color:#153643; text-align:justify">
										<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Informe de salidas<hr></h1>
										<p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        Estimad@ '.$datos['NombreJefe'].',<br>
                                        Mediante el presente se le comunica que el colaborador a su cargo ' . $datos['NombreSolicitante'] . ', ha registrado un nuevo informe de salidas para su revisión.
                                        Para mayor información, revise la solicitud en la plataforma THIGO.
                                        </p>
                                        <div class="col-md-12 text-center" style="text-align: center;"><br>
										<a href="' . base_url("Access/index") . '" class="btn btn-primary"
                                           style="border-radius:25px !important; font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #343a40; margin: 0; border-color: #343a40; border-style: solid; border-width: 8px 16px;">
                                           Inicie Sesión ahora</a>
                                        </div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:30px;background:#5a6771;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
								<tr>
									<td style="padding:0;width:50%;" align="left">
										<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        Atentamente <br> El equipo de <b>THIGO</b>.<br>
                                        &reg; THIGO '.date('Y').'
										</p>
									</td>
									<td style="padding:0;width:50%;" align="right">
										<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
											<tr>
												<td style="padding:0 0 0 10px;width:38px;">
													<a style="color:#ffffff;"><img src="https://thigo.mx/assets/images/thigo/3.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
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

function writeMessageInformeSalidasRevisionJEfe($datos)
{
    return '<body style="margin:0;padding:0;">
	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
		<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
					<tr>
						<td align="center" style="padding:40px 0 30px 0;background:#bdcde3;">
							<img src="https://thigo.mx/assets/images/thigo/CAPITAL HUMANO - NEGRO.png" alt="" width="100" style="height:auto;display:block;" />
						</td>
					</tr>
					<tr>
						<td style="padding:36px 30px 42px 30px;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
								<tr>
									<td style="padding:0 0 36px 0;color:#153643; text-align:justify">
										<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Informe de salidas<hr></h1>
										<p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        Estimad@ '.$datos['NombreSolicitante'].',<br>
                                        Mediante el presente se le comunica que su jefe directo ' . $datos['NombreJefe'] . ', ha ' . $datos['accion'] . ' el informe de salidas enviado .
                                        Para mayor información, revise la solicitud en la plataforma THIGO.
                                        </p>
                                        <div class="col-md-12 text-center" style="text-align: center;"><br>
										<a href="' . base_url("Access/index") . '" class="btn btn-primary"
                                           style="border-radius:25px !important; font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #343a40; margin: 0; border-color: #343a40; border-style: solid; border-width: 8px 16px;">
                                           Inicie Sesión ahora</a>
                                        </div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:30px;background:#5a6771;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
								<tr>
									<td style="padding:0;width:50%;" align="left">
										<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        Atentamente <br> El equipo de <b>THIGO</b>.<br>
                                        &reg; THIGO '.date('Y').'
										</p>
									</td>
									<td style="padding:0;width:50%;" align="right">
										<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
											<tr>
												<td style="padding:0 0 0 10px;width:38px;">
													<a style="color:#ffffff;"><img src="https://thigo.mx/assets/images/thigo/3.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
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

function writeMessageInformeSalidasRevisionCH($datos)
{
    return '<body style="margin:0;padding:0;">
	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
		<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
					<tr>
						<td align="center" style="padding:40px 0 30px 0;background:#bdcde3;">
							<img src="https://thigo.mx/assets/images/thigo/CAPITAL HUMANO - NEGRO.png" alt="" width="100" style="height:auto;display:block;" />
						</td>
					</tr>
					<tr>
						<td style="padding:36px 30px 42px 30px;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
								<tr>
									<td style="padding:0 0 36px 0;color:#153643; text-align:justify">
										<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Informe de salidas<hr></h1>
										<p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        Estimad@ '.$datos['NombreSolicitante'].',<br>
                                        Mediante el presente se le comunica que el informe de salidas enviado , ha sido ' . $datos['accion'] . ' por el departamento de Capital Humano.
                                        Para mayor información, revise la solicitud en la plataforma THIGO.
                                        </p>
                                        <div class="col-md-12 text-center" style="text-align: center;"><br>
										<a href="' . base_url("Access/index") . '" class="btn btn-primary"
                                           style="border-radius:25px !important; font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #343a40; margin: 0; border-color: #343a40; border-style: solid; border-width: 8px 16px;">
                                           Inicie Sesión ahora</a>
                                        </div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:30px;background:#5a6771;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
								<tr>
									<td style="padding:0;width:50%;" align="left">
										<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        Atentamente <br> El equipo de <b>THIGO</b>.<br>
                                        &reg; THIGO '.date('Y').'
										</p>
									</td>
									<td style="padding:0;width:50%;" align="right">
										<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
											<tr>
												<td style="padding:0 0 0 10px;width:38px;">
													<a style="color:#ffffff;"><img src="https://thigo.mx/assets/images/thigo/3.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
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

function writeMessageReporteHorasExtra($datos)
{

    return '<body style="margin:0;padding:0;">
	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
		<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
					<tr>
						<td align="center" style="padding:40px 0 30px 0;background:#bdcde3;">
							<img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" alt="" width="100" style="height:auto;display:block;" />
						</td>
					</tr>
					<tr>
						<td style="padding:36px 30px 42px 30px;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
								<tr>
									<td style="padding:0 0 36px 0;color:#153643; text-align:justify">
										<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Solicitud de horas extra<hr></h1>
										<p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        Estimad@ ' . $datos['NombreJefe'] . ',<br>
                                        Mediante el presente se le comunica que el colaborador a su cargo ' . $datos['NombreSolicitante'] . ', ha registrado una solicitud de horas extra para su revisión.
                                        </p>
                                        <div class="col-md-12 text-center" style="text-align: center;"><br>
										<a href="' . base_url("Access/index") . '" class="btn btn-primary"
                                           style="border-radius:25px !important; font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #343a40; margin: 0; border-color: #343a40; border-style: solid; border-width: 8px 16px;">
                                           Inicie Sesión ahora</a>
                                        </div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:30px;background:#5a6771;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
								<tr>
									<td style="padding:0;width:50%;" align="left">
										<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        Atentamente <br> El equipo de <b>THIGO</b>.<br>
                                        &reg; THIGO ' . date('Y') . '
										</p>
									</td>
									<td style="padding:0;width:50%;" align="right">
										<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
											<tr>
												<td style="padding:0 0 0 10px;width:38px;">
													<a style="color:#ffffff;"><img src="https://thigo.mx/assets/images/thigo/3.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
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

function writeMessageReporteHorasExtraRevisionJefe($datos)
{
    return '<body style="margin:0;padding:0;">
	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
		<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
					<tr>
						<td align="center" style="padding:40px 0 30px 0;background:#bdcde3;">
							<img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" alt="" width="100" style="height:auto;display:block;" />
						</td>
					</tr>
					<tr>
						<td style="padding:36px 30px 42px 30px;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
								<tr>
									<td style="padding:0 0 36px 0;color:#153643; text-align:justify">
										<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Solicitud de horas extra<hr></h1>
										<p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        Estimad@ ' . $datos['NombreSolicitante'] . ',<br>
                                        Mediante el presente se le comunica que ' . $datos['NombreJefe'] . ', ha ' . $datos['accion'] . ' el reporte de horas extra enviado.                                        </p>
                                        <div class="col-md-12 text-center" style="text-align: center;"><br>
										<a href="' . base_url("Access/index") . '" class="btn btn-primary"
                                           style="border-radius:25px !important; font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #343a40; margin: 0; border-color: #343a40; border-style: solid; border-width: 8px 16px;">
                                           Inicie Sesión ahora</a>
                                        </div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:30px;background:#5a6771;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
								<tr>
									<td style="padding:0;width:50%;" align="left">
										<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        Atentamente <br> El equipo de <b>THIGO</b>.<br>
                                        &reg; THIGO ' . date('Y') . '
										</p>
									</td>
									<td style="padding:0;width:50%;" align="right">
										<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
											<tr>
												<td style="padding:0 0 0 10px;width:38px;">
													<a style="color:#ffffff;"><img src="https://thigo.mx/assets/images/thigo/3.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
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

function writeMessageReporteHorasExtraCH($datos)
{
    return '<body style="margin:0;padding:0;">
	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
		<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
					<tr>
						<td align="center" style="padding:40px 0 30px 0;background:#bdcde3;">
							<img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" alt="" width="100" style="height:auto;display:block;" />
						</td>
					</tr>
					<tr>
						<td style="padding:36px 30px 42px 30px;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
								<tr>
									<td style="padding:0 0 36px 0;color:#153643; text-align:justify">
										<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Solicitud de horas extra<hr></h1>
										<p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        Estimad@ ' . $datos['NombreRH'] . ',<br>
                                        Mediante el presente se le comunica tiene una solicitud de horas extra de ' . $datos['NombreSolicitante'] . ' pendiente de revisar.                                        </p>
                                        <div class="col-md-12 text-center" style="text-align: center;"><br>
										<a href="' . base_url("Access/index") . '" class="btn btn-primary"
                                           style="border-radius:25px !important; font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #343a40; margin: 0; border-color: #343a40; border-style: solid; border-width: 8px 16px;">
                                           Inicie Sesión ahora</a>
                                        </div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:30px;background:#5a6771;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
								<tr>
									<td style="padding:0;width:50%;" align="left">
										<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        Atentamente <br> El equipo de <b>THIGO</b>.<br>
                                        &reg; THIGO ' . date('Y') . '
										</p>
									</td>
									<td style="padding:0;width:50%;" align="right">
										<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
											<tr>
												<td style="padding:0 0 0 10px;width:38px;">
													<a style="color:#ffffff;"><img src="https://thigo.mx/assets/images/thigo/3.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
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

function writeMessageReporteHorasExtraRevisionCH($datos)
{
    return '<body style="margin:0;padding:0;">
	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
		<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
					<tr>
						<td align="center" style="padding:40px 0 30px 0;background:#bdcde3;">
							<img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" alt="" width="100" style="height:auto;display:block;" />
						</td>
					</tr>
					<tr>
						<td style="padding:36px 30px 42px 30px;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
								<tr>
									<td style="padding:0 0 36px 0;color:#153643; text-align:justify">
										<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Solicitud de horas extra<hr></h1>
										<p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        Estimad@ ' . $datos['NombreSolicitante'] . ',<br>
                                        Mediante el presente se le comunica que el reporte de horas extra enviado , ha sido revisado por el departamento de Recursos Humanos.
                                        <div class="col-md-12 text-center" style="text-align: center;"><br>
										<a href="' . base_url("Access/index") . '" class="btn btn-primary"
                                           style="border-radius:25px !important; font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #343a40; margin: 0; border-color: #343a40; border-style: solid; border-width: 8px 16px;">
                                           Inicie Sesión ahora</a>
                                        </div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:30px;background:#5a6771;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
								<tr>
									<td style="padding:0;width:50%;" align="left">
										<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        Atentamente <br> El equipo de <b>THIGO</b>.<br>
                                        &reg; THIGO ' . date('Y') . '
										</p>
									</td>
									<td style="padding:0;width:50%;" align="right">
										<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
											<tr>
												<td style="padding:0 0 0 10px;width:38px;">
													<a style="color:#ffffff;"><img src="https://thigo.mx/assets/images/thigo/3.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
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


function writeMessageSolicitudFondoAhorroRevisar($datos)
{
    return '<table class="body-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
        <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
        <td class="container" width="600"
            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"
            valign="top">
            <div class="content"
                style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                <table class="main" width="100%" cellpadding="0" cellspacing="0"
                    style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; display: inline-block; margin: 0; border: 1px solid #e9e9e9;"
                    bgcolor="#fff">
                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class=""
                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #e3eaef; margin: 0; padding: 20px;"
                            align="center" bgcolor="#71b6f9" valign="top">
                            <a href="#"> <img src="https://sahuayo.thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" height="70" alt="logo"/></a> <br/>
                            <span style="margin-top: 10px;display: block; color:#313a46;">Solicitud de adelanto </span>
                        </td>
                    </tr>
                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class="content-wrap"
                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;"
                            valign="top">
                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Estimado ' . $datos['NombreCH'] . ':
                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Mediante el presente se le comunica el colaborador ' . $datos['NombreSolicitante'] . ' ha solicitado un adelanto de fondo de ahorro.
                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Para mayor información, revise la solicitud en la plataforma.
                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        <a href="' . base_url("Access/index") . '" class="btn btn-primary"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #001689; margin: 0; border-color: #001689; border-style: solid; border-width: 8px 16px;">
                                        Inicie sesión ahora</a>
                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Atentamente <br> El equipo de <b>THIGO</b>.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <div class=""
                    style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;">
                    <table width="100%"
                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                            <td class="aligncenter content-block"
                                style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0 0 20px;"
                                align="center" valign="top"> Derechos Reservados &#169; <a href="#"
                                                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; color: #999; text-decoration: underline; margin: 0;">THIGO</a> ' . date("Y") . '
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </td>
        <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
            valign="top"></td>
    </tr>
</table>';
}

//Correo al reprecentante legal
function writeMessageSolicitudFondoAhorroRevisarRep($datos)
{
    return '<table class="body-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
        <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
        <td class="container" width="600"
            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"
            valign="top">
            <div class="content"
                style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                <table class="main" width="100%" cellpadding="0" cellspacing="0"
                    style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; display: inline-block; margin: 0; border: 1px solid #e9e9e9;"
                    bgcolor="#fff">
                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class=""
                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #e3eaef; margin: 0; padding: 20px;"
                            align="center" bgcolor="#71b6f9" valign="top">
                            <a href="#"> <img src="https://sahuayo.thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" height="70" alt="logo"/></a> <br/>
                            <span style="margin-top: 10px;display: block; color:#313a46;">Solicitud de adelanto </span>
                        </td>
                    </tr>
                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class="content-wrap"
                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;"
                            valign="top">
                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Estimado ' . $datos['NombreReprecentante'] . ':
                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Mediante el presente se le notifica que Recursos Humanos ya ha revisado la solicitud de adelanto de fondo de ahorro que registro del colaborador ' . $datos['NombreSolicitante'] . '.
                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Para mayor información, revise la solicitud en la plataforma.
                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        <a href="' . base_url("Access/index") . '" class="btn btn-primary"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #001689; margin: 0; border-color: #001689; border-style: solid; border-width: 8px 16px;">
                                        Inicie sesión ahora</a>
                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Atentamente <br> El equipo de <b>THIGO</b>.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <div class=""
                    style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;">
                    <table width="100%"
                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                            <td class="aligncenter content-block"
                                style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0 0 20px;"
                                align="center" valign="top"> Derechos Reservados &#169; <a href="#"
                                                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; color: #999; text-decoration: underline; margin: 0;">THIGO</a> ' . date("Y") . '
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </td>
        <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
            valign="top"></td>
    </tr>
</table>';
}

function writeMessageSolicitudFondoAhorroRevisionCH($datos)
{
    return '<table class="body-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
        <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
        <td class="container" width="600"
            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"
            valign="top">
            <div class="content"
                style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                <table class="main" width="100%" cellpadding="0" cellspacing="0"
                    style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; display: inline-block; margin: 0; border: 1px solid #e9e9e9;"
                    bgcolor="#fff">
                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class=""
                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #e3eaef; margin: 0; padding: 20px;"
                            align="center" bgcolor="#71b6f9" valign="top">
                            <a href="#"> <img src="https://sahuayo.thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" height="70" alt="logo"/></a> <br/>
                            <span style="margin-top: 10px;display: block; color:#313a46;">Solicitud de adelanto </span>
                        </td>
                    </tr>
                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class="content-wrap"
                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;"
                            valign="top">
                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Estimado ' . $datos['NombreSolicitante'] . ':
                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Mediante el presente se le notifica que Recursos Humanos ya ha revisado su solicitud de adelanto de fondo de ahorro y esta fue ' . $datos['accion'] . '.
                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Para mayor información, revise la solicitud en la plataforma.
                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        <a href="' . base_url("Access/index") . '" class="btn btn-primary"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #001689; margin: 0; border-color: #001689; border-style: solid; border-width: 8px 16px;">
                                        Inicie sesión ahora</a>
                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Atentamente <br> El equipo de <b>THIGO</b>.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <div class=""
                    style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;">
                    <table width="100%"
                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                            <td class="aligncenter content-block"
                                style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0 0 20px;"
                                align="center" valign="top"> Derechos Reservados &#169; <a href="#"
                                                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; color: #999; text-decoration: underline; margin: 0;">THIGO</a> ' . date("Y") . '
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </td>
        <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
            valign="top"></td>
    </tr>
</table>';
}

function writeMessageFondoAhorroRevisionREP($datos)
{
    return '<table class="body-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
        <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
        <td class="container" width="600"
            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"
            valign="top">
            <div class="content"
                style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                <table class="main" width="100%" cellpadding="0" cellspacing="0"
                    style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; display: inline-block; margin: 0; border: 1px solid #e9e9e9;"
                    bgcolor="#fff">
                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class=""
                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #e3eaef; margin: 0; padding: 20px;"
                            align="center" bgcolor="#71b6f9" valign="top">
                            <a href="#"> <img src="https://sahuayo.thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" height="70" alt="logo"/></a> <br/>
                            <span style="margin-top: 10px;display: block; color:#313a46;">Solicitud de adelanto </span>
                        </td>
                    </tr>
                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class="content-wrap"
                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;"
                            valign="top">
                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Estimado ' . $datos['NombreCH'] . ':
                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Mediante el presente se le notifica que el reprecentante legal ya ha revisado la solicitud de adelanto de fondo de ahorro registrada por el colaborador ' . $datos['NombreSolicitante'] . '   y esta fue ' . $datos['accion'] . '.
                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Para mayor información, revise la solicitud en la plataforma.
                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        <a href="' . base_url("Access/index") . '" class="btn btn-primary"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #001689; margin: 0; border-color: #001689; border-style: solid; border-width: 8px 16px;">
                                        Inicie sesión ahora</a>
                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Atentamente <br> El equipo de <b>THIGO</b>.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <div class=""
                    style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;">
                    <table width="100%"
                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                            <td class="aligncenter content-block"
                                style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0 0 20px;"
                                align="center" valign="top"> Derechos Reservados &#169; <a href="#"
                                                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; color: #999; text-decoration: underline; margin: 0;">THIGO</a> ' . date("Y") . '
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </td>
        <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
            valign="top"></td>
    </tr>
</table>';
}

function writeMessagePrestamoAhorroRevisionREP($datos)
{
    return '<table class="body-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
        <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
        <td class="container" width="600"
            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"
            valign="top">
            <div class="content"
                style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                <table class="main" width="100%" cellpadding="0" cellspacing="0"
                    style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; display: inline-block; margin: 0; border: 1px solid #e9e9e9;"
                    bgcolor="#fff">
                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class=""
                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #e3eaef; margin: 0; padding: 20px;"
                            align="center" bgcolor="#71b6f9" valign="top">
                            <a href="#"> <img src="https://sahuayo.thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" height="70" alt="logo"/></a> <br/>
                            <span style="margin-top: 10px;display: block; color:#313a46;">Solicitud de adelanto </span>
                        </td>
                    </tr>
                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class="content-wrap"
                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;"
                            valign="top">
                            <table width="100%" cellpadding="0" cellspacing="0"
                                style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Estimado ' . $datos['NombreSolicitante'] . ':
                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Mediante el presente se le notifica que el reprecentante legal ya ha revisado su solicitud de adelanto de fondo de ahorro registrada y esta fue ' . $datos['accion'] . '.
                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Para mayor información, revise la solicitud en la plataforma.
                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        <a href="' . base_url("Access/index") . '" class="btn btn-primary"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #001689; margin: 0; border-color: #001689; border-style: solid; border-width: 8px 16px;">
                                        Inicie sesión ahora</a>
                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Atentamente <br> El equipo de <b>THIGO</b>.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <div class=""
                    style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;">
                    <table width="100%"
                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                            <td class="aligncenter content-block"
                                style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0 0 20px;"
                                align="center" valign="top"> Derechos Reservados &#169; <a href="#"
                                                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; color: #999; text-decoration: underline; margin: 0;">THIGO</a> ' . date("Y") . '
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </td>
        <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
            valign="top"></td>
    </tr>
</table>';
}


function writeMessageAccesosMasivos($datos)
{

    return '<body style="margin:0;padding:0;">
	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
		<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
					<tr>
						<td align="center" style="padding:40px 0 30px 0;background:#bdcde3;">
							<img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" alt="" width="100" style="height:auto;display:block;" />
						</td>
					</tr>
					<tr>
						<td style="padding:36px 30px 42px 30px;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
								<tr>
									<td style="padding:0 0 36px 0;color:#153643; text-align:justify">
										<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Datos de acceso<hr></h1>
										<p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        Estimad@ ' . $datos['nombre'] . ',<br>
                                        Es un gusto para el área de Recursos Humanos contar con una herramienta que nos permite estar mas cerca de ti, con el objetivo de facilitar nuestros procesos.<br>
                                        Recursos Humanos de Alianza Caja Popular Sahuayo ha creado una cuenta para ti en THIGO.<br>
                                        ¡Enhorabuena! <br><br>
                                        Tus datos de acceso son: <br>
                                        Link: <a href="http://sahuayo.thigo.mx">http://sahuayo.thigo.mx</a><br>
                                        Usuario: <strong>' . $datos['usuario'] . '</strong><br>
                                        Contraseña: <strong> ' . $datos['pass'] . ' </strong>
                                        </p>
                                        <div class="col-md-12 text-center" style="text-align: center;"><br>
										<a href="' . base_url("Access/index") . '" class="btn btn-primary"
                                           style="border-radius:25px !important; font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #343a40; margin: 0; border-color: #343a40; border-style: solid; border-width: 8px 16px;">
                                           Inicie Sesión ahora</a>
                                        </div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:30px;background:#5a6771;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
								<tr>
									<td style="padding:0;width:50%;" align="left">
										<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        Atentamente <br> El equipo de <b>THIGO</b>.<br>
                                        &reg; THIGO ' . date('Y') . '
										</p>
									</td>
									<td style="padding:0;width:50%;" align="right">
										<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
											<tr>
												<td style="padding:0 0 0 10px;width:38px;">
													<a style="color:#ffffff;"><img src="https://thigo.mx/assets/images/thigo/3.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
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

function writeMessageDirAutPrestamo($datos)
{
    return '<body style="margin:0;padding:0;">
	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
		<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
					<tr>
						<td align="center" style="padding:40px 0 30px 0;background:#bdcde3;">
							<img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" alt="" width="100" style="height:auto;display:block;" />
						</td>
					</tr>
					<tr>
						<td style="padding:36px 30px 42px 30px;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
								<tr>
									<td style="padding:0 0 36px 0;color:#153643; text-align:justify">
										<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Solicitud de prestamo<hr></h1>
										<p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        Estimad@ ' . $datos['NombreSolicitante'] . ',<br>
                                        Mediante el presente se le comunica que Dirección General ha autorizado tu prestamo.
                                        Para mayor información, revise la solicitud en la plataforma THIGO.
                                        </p>
                                        <div class="col-md-12 text-center" style="text-align: center;"><br>
										<a href="' . base_url("Access/index") . '" class="btn btn-primary"
                                           style="border-radius:25px !important; font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #343a40; margin: 0; border-color: #343a40; border-style: solid; border-width: 8px 16px;">
                                           Inicie Sesión ahora</a>
                                        </div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:30px;background:#5a6771;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
								<tr>
									<td style="padding:0;width:50%;" align="left">
										<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        Atentamente <br> El equipo de <b>THIGO</b>.<br>
                                        &reg; THIGO ' . date('Y') . '
										</p>
									</td>
									<td style="padding:0;width:50%;" align="right">
										<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
											<tr>
												<td style="padding:0 0 0 10px;width:38px;">
													<a style="color:#ffffff;"><img src="https://thigo.mx/assets/images/thigo/3.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
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

function writeMessageAplicarPrestamo($datos)
{
    return '<body style="margin:0;padding:0;">
	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
		<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
					<tr>
						<td align="center" style="padding:40px 0 30px 0;background:#bdcde3;">
							<img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" alt="" width="100" style="height:auto;display:block;" />
						</td>
					</tr>
					<tr>
						<td style="padding:36px 30px 42px 30px;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
								<tr>
									<td style="padding:0 0 36px 0;color:#153643; text-align:justify">
										<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Solicitud de prestamo<hr></h1>
										<p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        Estimad@ ' . $datos['NombreSolicitante'] . ',<br>
                                        Mediante el presente se le comunica que Recursos Humanos ha aplicado tu prestamo.
                                        Para mayor información, revise la solicitud en la plataforma THIGO.
                                        </p>
                                        <div class="col-md-12 text-center" style="text-align: center;"><br>
										<a href="' . base_url("Access/index") . '" class="btn btn-primary"
                                           style="border-radius:25px !important; font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #343a40; margin: 0; border-color: #343a40; border-style: solid; border-width: 8px 16px;">
                                           Inicie Sesión ahora</a>
                                        </div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:30px;background:#5a6771;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
								<tr>
									<td style="padding:0;width:50%;" align="left">
										<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        Atentamente <br> El equipo de <b>THIGO</b>.<br>
                                        &reg; THIGO ' . date('Y') . '
										</p>
									</td>
									<td style="padding:0;width:50%;" align="right">
										<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
											<tr>
												<td style="padding:0 0 0 10px;width:38px;">
													<a style="color:#ffffff;"><img src="https://thigo.mx/assets/images/thigo/3.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
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

function writeMessageDirRechPrestamo($datos)
{
    return '<body style="margin:0;padding:0;">
	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
		<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
					<tr>
						<td align="center" style="padding:40px 0 30px 0;background:#bdcde3;">
							<img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" alt="" width="100" style="height:auto;display:block;" />
						</td>
					</tr>
					<tr>
						<td style="padding:36px 30px 42px 30px;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
								<tr>
									<td style="padding:0 0 36px 0;color:#153643; text-align:justify">
										<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Solicitud de prestamo<hr></h1>
										<p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        Estimad@ ' . $datos['NombreSolicitante'] . ',<br>
                                        Mediante el presente se le comunica que Dirección General ha rechazado tu prestamo.
                                        Para mayor información, revise la solicitud en la plataforma THIGO.
                                        </p>
                                        <div class="col-md-12 text-center" style="text-align: center;"><br>
										<a href="' . base_url("Access/index") . '" class="btn btn-primary"
                                           style="border-radius:25px !important; font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #343a40; margin: 0; border-color: #343a40; border-style: solid; border-width: 8px 16px;">
                                           Inicie Sesión ahora</a>
                                        </div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:30px;background:#5a6771;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
								<tr>
									<td style="padding:0;width:50%;" align="left">
										<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        Atentamente <br> El equipo de <b>THIGO</b>.<br>
                                        &reg; THIGO ' . date('Y') . '
										</p>
									</td>
									<td style="padding:0;width:50%;" align="right">
										<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
											<tr>
												<td style="padding:0 0 0 10px;width:38px;">
													<a style="color:#ffffff;"><img src="https://thigo.mx/assets/images/thigo/3.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
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

function writeMessageNoAplicarPrestamo($datos)
{
    return '<body style="margin:0;padding:0;">
	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
		<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
					<tr>
						<td align="center" style="padding:40px 0 30px 0;background:#bdcde3;">
							<img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" alt="" width="100" style="height:auto;display:block;" />
						</td>
					</tr>
					<tr>
						<td style="padding:36px 30px 42px 30px;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
								<tr>
									<td style="padding:0 0 36px 0;color:#153643; text-align:justify">
										<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Solicitud de prestamo<hr></h1>
										<p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        Estimad@ ' . $datos['NombreSolicitante'] . ',<br>
                                        Mediante el presente se le comunica que Recursos Humanos ha rechazado tu prestamo.
                                        Para mayor información, revise la solicitud en la plataforma THIGO.
                                        </p>
                                        <div class="col-md-12 text-center" style="text-align: center;"><br>
										<a href="' . base_url("Access/index") . '" class="btn btn-primary"
                                           style="border-radius:25px !important; font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #343a40; margin: 0; border-color: #343a40; border-style: solid; border-width: 8px 16px;">
                                           Inicie Sesión ahora</a>
                                        </div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:30px;background:#5a6771;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
								<tr>
									<td style="padding:0;width:50%;" align="left">
										<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        Atentamente <br> El equipo de <b>THIGO</b>.<br>
                                        &reg; THIGO ' . date('Y') . '
										</p>
									</td>
									<td style="padding:0;width:50%;" align="right">
										<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
											<tr>
												<td style="padding:0 0 0 10px;width:38px;">
													<a style="color:#ffffff;"><img src="https://thigo.mx/assets/images/thigo/3.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
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


function writeMessageSolicitudAnticipoRevisar($datos)
{
    return '<body style="margin:0;padding:0;">
	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
		<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
					<tr>
						<td align="center" style="padding:40px 0 30px 0;background:#bdcde3;">
							<img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" alt="" width="100" style="height:auto;display:block;" />
						</td>
					</tr>
					<tr>
						<td style="padding:36px 30px 42px 30px;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
								<tr>
									<td style="padding:0 0 36px 0;color:#153643; text-align:justify">
										<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Solicitud de prestamo<hr></h1>
										<p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        Estimad@ ' . $datos['NombreRH'] . ',<br>
                                        Mediante el presente se le comunica que el colaborador ' . $datos['NombreSolicitante'] . ' ha solicitado un préstamo de empleado.
                                        Para mayor información, revise la solicitud en la plataforma THIGO.
                                        </p>
                                        <div class="col-md-12 text-center" style="text-align: center;"><br>
										<a href="' . base_url("Access/index") . '" class="btn btn-primary"
                                           style="border-radius:25px !important; font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #343a40; margin: 0; border-color: #343a40; border-style: solid; border-width: 8px 16px;">
                                           Inicie Sesión ahora</a>
                                        </div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:30px;background:#5a6771;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
								<tr>
									<td style="padding:0;width:50%;" align="left">
										<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        Atentamente <br> El equipo de <b>THIGO</b>.<br>
                                        &reg; THIGO ' . date('Y') . '
										</p>
									</td>
									<td style="padding:0;width:50%;" align="right">
										<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
											<tr>
												<td style="padding:0 0 0 10px;width:38px;">
													<a style="color:#ffffff;"><img src="https://thigo.mx/assets/images/thigo/3.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
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


function writeMessageSolicitudAnticipoRevisarDir($datos)
{
    return '<body style="margin:0;padding:0;">
	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
		<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
					<tr>
						<td align="center" style="padding:40px 0 30px 0;background:#bdcde3;">
							<img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" alt="" width="100" style="height:auto;display:block;" />
						</td>
					</tr>
					<tr>
						<td style="padding:36px 30px 42px 30px;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
								<tr>
									<td style="padding:0 0 36px 0;color:#153643; text-align:justify">
										<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Solicitud de prestamo<hr></h1>
										<p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        Estimad@ ' . $datos['NombreDirector'] . ',<br>
                                        Mediante el presente se le comunica que el colaborador ' . $datos['NombreSolicitante'] . ' ha solicitado un prestmo de empleado.
                                        Para mayor información, revise la solicitud en la plataforma THIGO.
                                        </p>
                                        <div class="col-md-12 text-center" style="text-align: center;"><br>
										<a href="' . base_url("Access/index") . '" class="btn btn-primary"
                                           style="border-radius:25px !important; font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #343a40; margin: 0; border-color: #343a40; border-style: solid; border-width: 8px 16px;">
                                           Inicie Sesión ahora</a>
                                        </div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:30px;background:#5a6771;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
								<tr>
									<td style="padding:0;width:50%;" align="left">
										<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        Atentamente <br> El equipo de <b>THIGO</b>.<br>
                                        &reg; THIGO ' . date('Y') . '
										</p>
									</td>
									<td style="padding:0;width:50%;" align="right">
										<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
											<tr>
												<td style="padding:0 0 0 10px;width:38px;">
													<a style="color:#ffffff;"><img src="https://thigo.mx/assets/images/thigo/3.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
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

function writeMessageSolicitudAnticipoRevisarCH($datos)
{
    return '<body style="margin:0;padding:0;">
	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
		<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
					<tr>
						<td align="center" style="padding:40px 0 30px 0;background:#bdcde3;">
							<img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" alt="" width="100" style="height:auto;display:block;" />
						</td>
					</tr>
					<tr>
						<td style="padding:36px 30px 42px 30px;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
								<tr>
									<td style="padding:0 0 36px 0;color:#153643; text-align:justify">
										<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Solicitud de prestamo<hr></h1>
										<p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        Estimad@ ' . $datos['NombreSolicitante'] . ',<br>
                                        Mediante el presente se le comunica que su solicitud de prestamo ha sido ' . utf8_decode($datos['accion']) . ' por el departamento de Recursos Humanos.
                                        Para mayor información, revise la solicitud en la plataforma THIGO.
                                        </p>
                                        <div class="col-md-12 text-center" style="text-align: center;"><br>
										<a href="' . base_url("Access/index") . '" class="btn btn-primary"
                                           style="border-radius:25px !important; font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #343a40; margin: 0; border-color: #343a40; border-style: solid; border-width: 8px 16px;">
                                           Inicie Sesión ahora</a>
                                        </div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:30px;background:#5a6771;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
								<tr>
									<td style="padding:0;width:50%;" align="left">
										<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        Atentamente <br> El equipo de <b>THIGO</b>.<br>
                                        &reg; THIGO ' . date('Y') . '
										</p>
									</td>
									<td style="padding:0;width:50%;" align="right">
										<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
											<tr>
												<td style="padding:0 0 0 10px;width:38px;">
													<a style="color:#ffffff;"><img src="https://thigo.mx/assets/images/thigo/3.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
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

function writeMessageReporteHorasExtraGerente($datos)
{
    return '<body style="margin:0;padding:0;">
	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
		<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
					<tr>
						<td align="center" style="padding:40px 0 30px 0;background:#bdcde3;">
							<img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" alt="" width="100" style="height:auto;display:block;" />
						</td>
					</tr>
					<tr>
						<td style="padding:36px 30px 42px 30px;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
								<tr>
									<td style="padding:0 0 36px 0;color:#153643; text-align:justify">
										<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Solicitud de horas extra<hr></h1>
										<p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        Estimad@ ' . $datos['NombreGerente'] . ',<br>
                                        Mediante el presente se le comunica que tiene una solicitud de horas extra de ' . $datos['NombreSolicitante'] . ' pendiente de revisar.
                                        Para mayor información, revise la solicitud en la plataforma THIGO. 
                                        </p>
                                        <div class="col-md-12 text-center" style="text-align: center;"><br>
										<a href="' . base_url("Access/index") . '" class="btn btn-primary"
                                           style="border-radius:25px !important; font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #343a40; margin: 0; border-color: #343a40; border-style: solid; border-width: 8px 16px;">
                                           Inicie Sesión ahora</a>
                                        </div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:30px;background:#5a6771;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
								<tr>
									<td style="padding:0;width:50%;" align="left">
										<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        Atentamente <br> El equipo de <b>THIGO</b>.<br>
                                        &reg; THIGO ' . date('Y') . '
										</p>
									</td>
									<td style="padding:0;width:50%;" align="right">
										<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
											<tr>
												<td style="padding:0 0 0 10px;width:38px;">
													<a style="color:#ffffff;"><img src="https://thigo.mx/assets/images/thigo/3.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
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

function writeMessageRecibosNomina($datos)
{
    return '<body style="margin:0;padding:0;">
	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
		<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
					<tr>
						<td align="center" style="padding:40px 0 30px 0;background:#bdcde3;">
							<img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" alt="" width="100" style="height:auto;display:block;" />
						</td>
					</tr>
					<tr>
						<td style="padding:36px 30px 42px 30px;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
								<tr>
									<td style="padding:0 0 36px 0;color:#153643; text-align:justify">
										<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">Nuevo recibo de nómina<hr></h1>
										<p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">
                                        Estimad@ ' . $datos['emp_Nombre'] . ',<br>
                                        Mediante el presente se le comunica que se ha subido un nuevo recibo de nómina.<br>
                                        Para mayor información, revise la solicitud en la plataforma THIGO.
                                        </p>
                                        <div class="col-md-12 text-center" style="text-align: center;"><br>
										<a href="' . base_url("Access/index") . '" class="btn btn-primary"
                                           style="border-radius:25px !important; font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #343a40; margin: 0; border-color: #343a40; border-style: solid; border-width: 8px 16px;">
                                           Inicie Sesión ahora</a>
                                        </div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:30px;background:#5a6771;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
								<tr>
									<td style="padding:0;width:50%;" align="left">
										<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        Atentamente <br> El equipo de <b>THIGO</b>.<br>
                                        &reg; THIGO ' . date('Y') . '
										</p>
									</td>
									<td style="padding:0;width:50%;" align="right">
										<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
											<tr>
												<td style="padding:0 0 0 10px;width:38px;">
													<a style="color:#ffffff;"><img src="https://thigo.mx/assets/images/thigo/3.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
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


function write_messageAnticipo($datos)
{
    $date = longDate(date('Y-m-d'), " de ");
    $nombre = $datos['name'];
    $estatus = $datos['estatus'];
    $montoSolicitado = "$ " . number_format($datos['montoSolicitado'], 2);
    $montoAutorizado = "$ " . number_format($datos['montoAutorizado'], 2);


    $text = '<table class="body-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
        <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
        <td class="container" width="600"
            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;"
            valign="top">
            <div class="content"
                 style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
                <table class="main" width="100%" cellpadding="0" cellspacing="0"
                       style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; display: inline-block; margin: 0; border: 1px solid #e9e9e9;"
                       bgcolor="#fff">
                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class=""
                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #e3eaef; margin: 0; padding: 20px;"
                            align="center" bgcolor="#71b6f9" valign="top">
                            <a href="#"> <img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" height="70" alt="logo"/></a> <br/>
                            <span style="margin-top: 10px;display: block; color:#313a46;">Solicitud de Anticipo</span>
                        </td>
                    </tr>
                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <td class="content-wrap"
                            style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;"
                            valign="top">
                            <table width="100%" cellpadding="0" cellspacing="0"
                                   style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">

                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0; text-align: right">
                                    <td colspan="2" class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        ' . $date . '
                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td colspan="2" class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Estimado ' . $nombre . '.
                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td colspan="2" class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Mediante el presente se le comunica a usted que su solicitud de anticipo ha sido ' . $estatus . '
                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td width="80%" class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px; text-align: right"
                                        valign="top">
                                        Monto solicitado:
                                    </td>
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px; text-align: right"
                                        valign="top">
                                        ' . $montoSolicitado . '
                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td width="80%" class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px; text-align: right"
                                        valign="top">
                                        Monto autorizado:
                                    </td>
                                    <td class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px; text-align: right"
                                        valign="top">
                                        ' . $montoAutorizado . '
                                    </td>
                                </tr>
                                <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                                    <td colspan="2" class="content-block"
                                        style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;"
                                        valign="top">
                                        Atentamente <br> El equipo de <b>THIGO</b>.
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <div class=""
                     style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; clear: both; color: #999; margin: 0; padding: 20px;">
                    <table width="100%"
                           style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                        <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                            <td class="aligncenter content-block"
                                style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0 0 20px;"
                                align="center" valign="top"> Derechos Reservados &#169; <a href="#"
                                                                                           style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; color: #999; text-decoration: underline; margin: 0;">THIGO</a> ' . date("Y") . '
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </td>
        <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;"
            valign="top"></td>
    </tr>
</table>';
    return $text;
} // end write_messagePermiso

function writeMessageDefault($datos)
{
    //titulo
    //cuerpo
    //nombre
    return '<body style="margin:0;padding:0;">
	<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;background:#ffffff;">
		<tr>
			<td align="center" style="padding:0;">
				<table role="presentation" style="width:602px;border-collapse:collapse;border:1px solid #cccccc;border-spacing:0;text-align:left;">
					<tr>
						<td align="center" style="padding:40px 0 30px 0;background:#bdcde3;">
							<img src="https://thigo.mx/assets/images/thigo/RECURSOS HUMANOS - NEGRO.png" alt="" width="100" style="height:auto;display:block;" />
						</td>
					</tr>
					<tr>
						<td style="padding:36px 30px 42px 30px;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;">
								<tr>
									<td style="padding:0 0 36px 0;color:#153643; text-align:justify">
										<h1 style="font-size:24px;margin:0 0 20px 0;font-family:Arial,sans-serif;">' . $datos['titulo'] . '<hr></h1>
										<p style="margin:0 0 12px 0;font-size:16px;line-height:24px;font-family:Arial,sans-serif;">Estimad@ ' . $datos['nombre'] . ':<br>
                                        '.$datos['cuerpo'].'<br>
                                        Para mayor información, revise la solicitud en la plataforma.
                                        </p>
                                        <div class="col-md-12 text-center" style="text-align: center;"><br>
										<a href="' . base_url("Access/index") . '" class="btn btn-primary"
                                           style="border-radius:25px !important; font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #343a40; margin: 0; border-color: #343a40; border-style: solid; border-width: 8px 16px;">
                                           Inicie Sesión ahora</a>
                                        </div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td style="padding:30px;background:#5a6771;">
							<table role="presentation" style="width:100%;border-collapse:collapse;border:0;border-spacing:0;font-size:9px;font-family:Arial,sans-serif;">
								<tr>
									<td style="padding:0;width:50%;" align="left">
										<p style="margin:0;font-size:14px;line-height:16px;font-family:Arial,sans-serif;color:#ffffff;">
                                        Atentamente <br> El equipo de <b>THIGO</b>.<br>
                                        &reg; THIGO ' . date('Y') . '
										</p>
									</td>
									<td style="padding:0;width:50%;" align="right">
										<table role="presentation" style="border-collapse:collapse;border:0;border-spacing:0;">
											<tr>
												<td style="padding:0 0 0 10px;width:38px;">
													<a style="color:#ffffff;"><img src="https://thigo.mx/assets/images/thigo/3.png" alt="Twitter" width="38" style="height:auto;display:block;border:0;" /></a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
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
} // end write_messagePermiso
