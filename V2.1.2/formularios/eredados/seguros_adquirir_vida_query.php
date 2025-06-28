<?php
include('../config/config.php');
extract($_POST);
// Calculo del IMC
	$estaturaCuadrada = ($estatura * 1) * $estatura;
	$imc = $peso / $estaturaCuadrada;
	$imc = substr($imc, 4, 2);
	
	switch ($imc) {

    case 34 :
		$imcTexto = "Persona asegurable con un pago de 20% mas,  su IMC es de $imc";
		break;
    case 35 :
		$imcTexto = "Persona asegurable con un pago de 20% mas,  su IMC es de $imc";
		break;
    case 36 :
		$imcTexto = "Persona asegurable con un pago de 20% mas,  su IMC es de $imc";
		break;
    case 37 :
		$imcTexto = "Persona asegurable con un pago de 40% mas,  su IMC es de $imc";
		break;
    case 38 :
		$imcTexto = "Persona asegurable con un pago de 40% mas,  su IMC es de $imc";
		break;
    case 39 :
		$imcTexto = "Persona NO asegurable, excede el Limite de IMC 38, su IMC es de $imc";
		break;
    case 40 :
		$imcTexto = "Persona NO asegurable, excede el Limite de IMC 38, su IMC es de $imc";
		break;
    case 41 :
		$imcTexto = "Persona NO asegurable, excede el Limite de IMC 38, su IMC es de $imc";
		break;
    case 42 :
		$imcTexto = "Persona NO asegurable, excede el Limite de IMC 38, su IMC es de $imc";
		break;
    case 43 :
		$imcTexto = "Persona NO asegurable, excede el Limite de IMC 38, su IMC es de $imc";
		break;
    case 44 :
		$imcTexto = "Persona NO asegurable, excede el Limite de IMC 38, su IMC es de $imc";
		break;
    case 45 :
		$imcTexto = "Persona NO asegurable, excede el Limite de IMC 38, su IMC es de $imc";
		break;
    case 46 :
		$imcTexto = "Persona NO asegurable, excede el Limite de IMC 38, su IMC es de $imc";
		break;
    case 47 :
		$imcTexto = "Persona NO asegurable, excede el Limite de IMC 38, su IMC es de $imc";
		break;
    case 48 :
		$imcTexto = "Persona NO asegurable, excede el Limite de IMC 38, su IMC es de $imc";
		break;
    case 49 :
		$imcTexto = "Persona NO asegurable, excede el Limite de IMC 38, su IMC es de $imc";
		break;
    case 50 :
		$imcTexto = "Persona NO asegurable, excede el Limite de IMC 38, su IMC es de $imc";
		break;
    default :
		$imcTexto = $imc;
		break;

    }
	
// Agregamos Prospeccion a la BD
$tipo = "Seguro de Vida";
$queryAddProspeccion = "
		INSERT INTO `prospecciones` 
			(`tipo`, `nombre`, `apellidos`, `telefono`, `email`, `edad_contratante`, `sexo`, `ahorro`, `moneda`, `estatura`, `peso`, `fuma`, `formaPago`, `imc`, `comentarios`)
			VALUES ('$tipo', '$nombre', '$apellidos', '$telefono', '$email', '$edad_contratante', '$sexo', '$ahorro', '$moneda', '$estatura', '$peso', '$fuma', '$formaPago', '$imc', '$comentarios')";
mysql_query($queryAddProspeccion) or die (mysql_error());
$idProspeccion = mysql_insert_id();


// Enviamos Correo de la Prospeccion
$fechaCreacion = mysql_result(mysql_query("Select `fecha` From `prospecciones` Where `id` = '$idProspeccion'"),0);
$seccion = "vida";
$email_subject = "Formulario de Seguro de Vida desde Web GapSeguros";
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
		
        $message = $message . "<strong>Formulario de Seguro de Vida</strong><br>";
		$message = $message . "<strong>Fecha:</strong> $fechaCreacion<br>";
        $message = $message . "<hr>";
		$message = $message . "<strong>IMC:</strong> ".$imcTexto."<br>";		
		$message = $message . "<strong>Nombre:</strong> ".$nombre."<br>";
		$message = $message . "<strong>Apellidos:</strong> ".$apellidos."<br>";
		$message = $message . "<strong>Telefono:</strong> ".$telefono." <strong>Email:</strong> ".$email."<br>";
		$message = $message . "<strong>Edad del Contratante:</strong> ".$edad_contratante." <strong>Sexo:</strong> ".$sexo."<br>";
		$message = $message . "<strong>Se Requiere Incluir Ahorro:</strong> ".$ahorro." <strong>Moneda:</strong> ".$moneda."<br>";		
		$message = $message . "<strong>Estatura:</strong> ".$estatura."cm <strong>Peso:</strong> ".$peso."kg<br>";
		$message = $message . "<strong>Fuma:</strong> ".$fuma." <strong>Forma de Pago:</strong> ".$formaPago."<br>";
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
	window.open('seguros_vida.php','_self');
</script>
<?php
} else {
//SINO, SE MANDA A UNA DE ERROR
//header("Location: error_img.php");
echo "Error al mandar correo";
}

?>