<?php
include('../config/config.php');
extract($_POST);

// Agregamos Prospeccion a la BD
$tipo = "Seguro Daños";
$queryAddProspeccion = "
		INSERT INTO `prospecciones` 
			(`tipo`, `nombre`, `apellidos`, `calle`, `noint`, `noext`, `cruzamientos`, `colonia`, `ciudad`, `estado`, `codigopostal`, `telefono`, `email`, `valorVivienda`, `valorContenidos`, `hidrometeorologicos`, `construccion`, `techos`, `comentarios`)
			VALUES ('$tipo', '$nombre', '$apellidos', '$calle', '$noint', '$noext', '$cruzamientos', '$colonia', '$ciudad', '$estado', '$codigopostal', '$telefono', '$email', '$valorVivienda', '$valorContenidos', '$hidrometeorologicos', '$construccion', '$techos', '$comentarios')";
mysql_query($queryAddProspeccion) or die (mysql_error());
$idProspeccion = mysql_insert_id();


// Enviamos Correo de la Prospeccion
$fechaCreacion = mysql_result(mysql_query("Select `fecha` From `prospecciones` Where `id` = '$idProspeccion'"),0);
$seccion = "danos";
$email_subject = "Formulario de Seguro Daños desde Web GapSeguros";
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
		
        $message = $message . "<strong>Formulario de Seguro Da&ntilde;os</strong><br>";
		$message = $message . "<strong>Fecha:</strong> $fechaCreacion<br>";
        $message = $message . "<hr>";
		$message = $message . "<strong>Nombre:</strong> ".$nombre."<br>";
		$message = $message . "<strong>Apellidos:</strong> ".$apellidos."<br>";
		$message = $message . "<strong>Calle:</strong> ".$calle." <strong>No. Ext.:</strong> ".$noext." <strong>No. Int.:</strong> ".$noint."<br>";
		$message = $message . "<strong>Cruzamientos:</strong> ".$cruzamientos."<br>";
		$message = $message . "<strong>Colonia:</strong> ".$colonia." <strong>Codigo Postal:</strong> ".$codigopostal."<br>";
		$message = $message . "<strong>Ciudad:</strong> ".$ciudad." <strong>Estado:</strong> ".$estado."<br>";
		$message = $message . "<strong>Telefono:</strong> ".$telefono." <strong>Email:</strong> ".$email."<br>";
		$message = $message . "<strong>Valor de Vivienda:</strong> ".$valorVivienda." <strong>Valor del Contenido:</strong> ".$valorContenidos."<br>";
		$message = $message . "<strong>Cobertura Fenómenos Hidrometeorológicos:</strong> ".$hidrometeorologicos."<br>";
		$message = $message . "<strong>Tipo de Construccion:</strong> ".$construccion."<br>";
		$message = $message . "<strong>Tipo de Techo:</strong> ".$techos."<br>";
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
	window.open('seguros_danos.php','_self');
</script>
<?php
} else {
//SINO, SE MANDA A UNA DE ERROR
//header("Location: error_img.php");
echo "Error al mandar correo";
}

?>