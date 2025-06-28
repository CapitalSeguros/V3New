<?php

// Funcion de Correo DRE
function DreMail($desde,$para,$copia,$copiaOculta,$asunto,$mensaje,$fileAdjunto,$nameAdjunto){

if($fileAdjunto != ""){ /*Adjun*/
	// Codificamos el archivo
	$file = fopen($fileAdjunto, 'r'); 
	$contenido = fread($file, filesize($fileAdjunto)); 
	$encoded_attach = chunk_split(base64_encode($contenido)); 
	fclose($file);
	$fileName = "Archivo_Adjunto".$extension;
}

$headers = "From: ".$desde."\r\n"; 
$headers .= "Reply-To: ".$desde."\r\n";
$headers .= "Return-path: ".$desde."\r\n";  
$headers .= "Cc: ".$copia."\r\n"; 
$headers .= "Bcc: ".$copiaOculta.", juanjose@dre-learning.com \r\n";
$headers .= "MIME-version: 1.0\n"; 
$headers .= "Content-type: multipart/form-data; "; 
$headers .= "boundary=\"Message-Boundary\"\n"; 
$headers .= "Content-transfer-encoding: 7BIT\n"; 
if($fileAdjunto != ""){ $headers .= "X-attachments:".$fileAdjunto; /*Adjun*/ }

//Se configuran las propiedades del email_message del mensaje 
$body_top = "--Message-Boundary\n"; 
$body_top .= "Content-type: text/html; charset=iso-8859-1\r\n"; 
$body_top .= "Content-transfer-encoding: 7BIT\n"; 
$body_top .= "Content-description: Mail messagebody\n\n"; 

$email_message = $body_top.$mensaje; 

$email_message .= "\n\n--Message-Boundary\n"; 
if($fileAdjunto != ""){ $email_message .= "Content-type: Binary;name=\"$nameAdjunto\"\n"; /*Adjun*/ }
$email_message .= "Content-Transfer-Encoding: BASE64\n"; 
if($fileAdjunto != ""){ $email_message .= "Content-disposition: attachment;filename=\"$nameAdjunto\"\n\n"; /*Adjun*/}
$email_message .= "$encoded_attach\n"; 
$email_message .= "--Message-Boundary--\n"; 
		
	// Envio del Correo
	@mail($para, $asunto, $email_message, $headers);  
}

$desde = "do-not-reply@capsys.com.mx";
$para = "juanjose@dre-learning.com";
$copia = "sistemas@agentecapital.com";
$copiaOculta = "";
$asunto = "Validacion Envio New Server";
$mensaje = "Hola Mundo ";
$fileAdjunto = "";
$nameAdjunto = "";

DreMail($desde,$para,$copia,$copiaOculta,$asunto,$mensaje,$fileAdjunto,$nameAdjunto);

?>