<?php
include('../config/config.php');
extract($_POST);

// Agregamos Prospeccion a la BD
$tipo = "Seguro Dental";
$queryAddProspeccion = "
		INSERT INTO `prospecciones` 
			(`tipo`, `nombre`, `apellidos`, `telefono`, `email`, `edad_contratante`, `sexo`, `gmm`, `nombreFam1`, `sexoFam1`, `parentescoFam1`, `edadFam1`, `nombreFam2`, `sexoFam2`, `parentescoFam2`, `edadFam2`, `nombreFam3`, `sexoFam3`, `parentescoFam3`, `edadFam3`, `comentarios`)
			VALUES ('$tipo', '$nombre', '$apellidos', '$telefono', '$email', '$edad_contratante', '$sexo', '$gmm', '$nombreFam1', '$sexoFam1', '$parentescoFam1', '$edadFam1', '$nombreFam2', '$sexoFam2', '$parentescoFam2', '$edadFam2', '$nombreFam3', '$sexoFam3', '$parentescoFam3', '$edadFam3', '$comentarios')";
mysql_query($queryAddProspeccion) or die (mysql_error());
$idProspeccion = mysql_insert_id();


// Enviamos Correo de la Prospeccion
$fechaCreacion = mysql_result(mysql_query("Select `fecha` From `prospecciones` Where `id` = '$idProspeccion'"),0);
$seccion = "dental";
$email_subject = "Formulario de Seguro Dental desde Web GapSeguros";
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
		
        $message = $message . "<strong>Formulario de Seguro Dental</strong><br>";
		$message = $message . "<strong>Fecha:</strong> $fechaCreacion<br>";
        $message = $message . "<hr>";
		$message = $message . "<strong>Nombre:</strong> ".$nombre."<br>";
		$message = $message . "<strong>Apellidos:</strong> ".$apellidos."<br>";
		$message = $message . "<strong>Telefono:</strong> ".$telefono." <strong>Email:</strong> ".$email."<br>";

		$message = $message . "<strong>Edad del Contratante:</strong> ".$edad_contratante." <strong>Sexo:</strong> ".$sexo."<br>";
		$message = $message . "<strong>Cuenta con Cuenta con Gastos M&eacute;dicos Mayores:</strong> ".$gmm."<br>";
		
        $message = $message . "<strong>Familiar 1</strong><br>";
		$message = $message . "<strong>Nombre:</strong> ".$nombreFam1." <strong>Sexo:</strong> ".$sexoFam1."<br>";
		$message = $message . "<strong>Parentesco:</strong> ".$parentescoFam1." <strong>Edad:</strong> ".$edadFam1."<br>";
        $message = $message . "<strong>Familiar 2</strong><br>";
		$message = $message . "<strong>Nombre:</strong> ".$nombreFam2." <strong>Sexo:</strong> ".$sexoFam2."<br>";
		$message = $message . "<strong>Parentesco:</strong> ".$parentescoFam2." <strong>Edad:</strong> ".$edadFam2."<br>";
        $message = $message . "<strong>Familiar 3</strong><br>";
		$message = $message . "<strong>Nombre:</strong> ".$nombreFam3." <strong>Sexo:</strong> ".$sexoFam3."<br>";
		$message = $message . "<strong>Parentesco:</strong> ".$parentescoFam3." <strong>Edad:</strong> ".$edadFam3."<br>";

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
	window.open('seguros.php','_self');
</script>
<?php
} else {
//SINO, SE MANDA A UNA DE ERROR
//header("Location: error_img.php");
echo "Error al mandar correo";
}

?>