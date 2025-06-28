<?php
include('../config/config.php');
extract($_POST);

// Agregamos Prospeccion a la BD
$tipo = "Seguro Autos y Camiones";
$queryAddProspeccion = "
		INSERT INTO `prospecciones` 
			(`tipo`, `nombre`, `apellidos`, `estado`, `telefono`, `email`, `marca`, `anio`, `modelo`, `clima`, `transmision`, `uso`, `quemaCocos`, `cobertura`, `precio`, `formaPago`, `comentarios`, `descripcion`, `adaptacion`)
			VALUES ('$tipo', '$nombre', '$apellidos', '$estado', '$telefono', '$email', '$marca', '$anio', '$modelo', '$clima', '$transmision', '$uso', '$quemaCocos', '$cobertura', '$precio', '$formaPago', '$comentarios', '$descripcion', '$adaptacion')";
mysql_query($queryAddProspeccion) or die (mysql_error());
$idProspeccion = mysql_insert_id();


// Enviamos Correo de la Prospeccion
$fechaCreacion = mysql_result(mysql_query("Select `fecha` From `prospecciones` Where `id` = '$idProspeccion'"),0);
$seccion = "autos_camiones";
$email_subject = "Formulario de Seguro Autos y Camiones desde Web GapSeguros";
$email_message = "";
//email a donde enviamos el correo
$email_to = mysql_result(mysql_query("Select `email` From `texto_seguros` Where `seccion` = '$seccion' And `idioma` = 'sp'"),0);

$headers = "From: info@gapseguros.com";
$semi_rand = md5(time());  
$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";  
//ENCABEZADOS MIME
$headers .= "\nMIME-Version: 1.0\n" .  
            "Content-Type: multipart/mixed;\n" .  
            " boundary=\"{$mime_boundary}\""; 

//CONSTRUCCION DEL MENSAJE
$message = "";
		
        $message = $message . "<strong>Formulario de Seguro Autos y Camiones</strong><br>";
		$message = $message . "<strong>Fecha:</strong> $fechaCreacion<br>";
        $message = $message . "<hr>";
		$message = $message . "<strong>Nombre:</strong> ".$nombre."<br>";
		$message = $message . "<strong>Apellidos:</strong> ".$apellidos."<br>";
		$message = $message . "<strong>Estado:</strong> ".$estado."<br>";
		$message = $message . "<strong>Telefono:</strong> ".$telefono." <strong>Email:</strong> ".$email."<br>";
		$message = $message . "<strong>Marca:</strong> ".$marca." <strong>Modelo:</strong> ".$modelo." <strong>Año:</strong> ".$anio."<br>";
		$message = $message . "<strong>Transmision:</strong> ".$transmision." <strong>Aire Acondicionado:</strong> ".$clima."<br>";
		$message = $message . "<strong>Quemacocos:</strong> ".$quemaCocos." <strong>Tipo de Uso:</strong> ".$uso."<br>";
		$message = $message . "<strong>Coberturo:</strong> ".$cobertura." <strong>Forma de Pago:</strong> ".$formaPago."<br>";
		$message = $message . "<strong>Precio (Valor Factura):</strong> ".$precio."<br />";
		$message = $message . "<strong>Descripcion:</strong> ".$descripcion."<br />";
		$message = $message . "<strong>Adaptacion:</strong> ".$adaptacion."<br />";
		$message = $message . "<strong>Comentarios:</strong> ".$comentarios."<br />";
		
		
$email_message.=$message;

//CONTINUA CONSTRUCCION MULTI-PART
$email_message .= "\n\n" .  
                "--{$mime_boundary}\n" .  
                "Content-Type:text/html; charset=\"iso-8859-1\"\n" .  
               "Content-Transfer-Encoding: 7bit\n\n" .  
$email_message . "\n\n";  

// Linea de envio del correo
$correo = @mail($email_to, $email_subject, $email_message, $headers);  

//SI EL CORREO SE MANDA EXITOSAMENTE...
if($correo) {  
//SE ENVIA A UNA PAGINA DE EXITO
?>
<script language="javascript" type="text/javascript">
	// Mostramos Mensaje de Envio Exitoso  y luego mandamos a la url
	alert('Envio de Correo Exitoso !!!');
	window.open('seguros_autos_camiones.php','_self');
</script>
<?php
} else {
//SINO, SE MANDA A UNA DE ERROR
//header("Location: error_img.php");
echo "Error al mandar correo";
}

?>