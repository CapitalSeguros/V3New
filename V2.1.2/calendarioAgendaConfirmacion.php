<?php
include('config/funcionesDre.php');
$conexion = DreConectarDB();
extract($_REQUEST);


	$sqlInfoConfirmarCita = "
		Select * From 
			`agenda`
		Where 
			`idAgendaMd5` = '$idAgenda'
						";
	$resInfoConfirmarCita = DreQueryDB($sqlInfoConfirmarCita);
	$rowInfoConfirmarCita = mysql_fetch_assoc($resInfoConfirmarCita);
	$idAgenda = $rowInfoConfirmarCita['idAgenda']; 
	
	$sqlConfirmarCita = "
		Update
			`agenda_invitados`
		Set
			`confirmado` = '1'
		Where
			`idAgenda` = '$idAgenda'
			And 
			`usuario` = '$usuario'
						";
	DreQueryDB($sqlConfirmarCita);
	
// Envio de Correo--->

	$desde = "CAPSYS Web <do-not-reply@capsys.com.mx>";
	$para = DreCorreoUsuario($rowInfoConfirmarCita['usuario']);
	$copia = "";
	$copiaOculta = "juanjose@dre-learning.com";
	$asunto = "Confirmacion de Cita para el: ".DreFechaEsp($rowInfoConfirmarCita['fechaStart']).substr($rowInfoConfirmarCita['fechaStart'],7,10)."Hrs   Terminando el: ".DreFechaEsp($rowInfoConfirmarCita['fechaEnd']).substr($rowInfoConfirmarCita['fechaEnd'],7,10)."Hrs";
	$mensaje = "Asunto: ".urldecode($rowInfoConfirmarCita['cita']);
	$mensaje.= "<br>";
	$mensaje.= "Invitado: ".DreNombreUsuario($usuario);
	$fileAdjunto = "";
	$nameAdjunto = "";
	
	DreMail($desde,$para,$copia,$copiaOculta,$asunto,$mensaje,$fileAdjunto,$nameAdjunto);
	
//	echo "<pre>";
	//	echo $mensaje;
//	echo "</pre>";
	
// --->	
	
//header('Location: calendarioAgenda.php');	
?>
<html>
<head>
<script language="javascript">
	function Cerrar_Ventana()
		{
			window.open('','_self','');
			window.close();
		}
</script> 
</head>
<body onLoad="cuenta_atras=setTimeout('Cerrar_Ventana();',3000)">
<table width="1000" align="center" class="TablePrincipal" cellpadding="0" cellspacing="0">
	<tr>
    	<td>
        	<strong>Cita Confirmada Correctamente !!!</strong>
        </td>
    </tr>
</table>
</body>
</html>