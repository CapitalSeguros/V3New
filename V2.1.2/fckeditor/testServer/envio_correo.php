<?php

			require("clases/class.phpmailer.php");
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->SMTPAuth = true;
			$mail->Host = "smtp.gmail.com"; // SMTP a utilizar. 
			$mail->Username = "minesota.t@gmail.com"; // Correo completo a utilizar
			$mail->Password = "atosenim"; // Contraseña
			$mail->Port = 465 ; //  Puerto a utilizar
			$mail->From = "info@gapseguros.mx"; // Desde donde enviamos (Para mostrar)
			$mail->FromName = "gapseguros.mx";//"innrent.com";
			$mail->AddAddress("juanjose@dre-learning.com"); // Esta es la dirección a donde enviamos
//			$mail->AddCC("robertocg07@hotmail.com"); // Copia
//			$mail->AddBCC(trim($ObjContacto->cco)); // Copia oculta
			$mail->IsHTML(true); // El correo se envía como HTML
			$mail->Subject = "Cotización enviada desde el Sitio www.ptb.mx"; // Este es el titulo del email.
			$body = "Datos del Email:<br>";
			$body.= "Teléfono: ".$telefono."<br>";
			$body.= "Cantidad: ".$cantidad."<br>";
			$body.= "Medida: ".$medida."<br>";
			$body.= "Comentario: ".$comentario."<br>";
			$mail->Body = $body; // Mensaje a enviar
			$mail->AltBody = "www.ptb.mx"; // Texto sin html
			$mail->AddAttachment("imagenes/imagen.jpg", "imagen.jpg");
			$exito = $mail->Send(); // Envía el correo.
			



?>