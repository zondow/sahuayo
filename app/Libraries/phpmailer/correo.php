<?php
require('class.phpmailer.php');
      $mail = new PHPMailer(true); 
      $mail->CharSet = 'UTF-8';
      $mail->IsSMTP();
      $mail->Host = "smtp.live.com";
      $mail->SMTPAuth = true;
      $mail->Username = $email_r;
      $mail->Password = 'JE1617596';
      $mail->Port = 25;
      $mail->From = $email_r;
      $mail->FromName = "German Ledesma Zavala";
      $mail->AddAddress($email_d, "Programador");
      $mail->AddReplyTo($email_d, "me");
      $mail->WordWrap = 50;                                 
      $mail->IsHTML(true);                            
      $mail->Subject = "Partida Nueva.";
      $mail->Body    = "Se ha agregado una partida nueva a la cotización $num_cotizacion. Favor de capturarle el precio unitario con el fin de continuar con el proceso. Gracias. Atte. $user.";
      if(!$mail->Send()) {
            echo "Error al enviar el mensaje: " . $mail->ErrorInfo;
      } else {
            echo "location.href = './codesa/CODESAv2.0/ver_cotizacion_ctrl.php?id=$id&cotizacion=$num_cotizacion'";
      }
?>