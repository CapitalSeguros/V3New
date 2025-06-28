<?php
extract($_REQUEST);
include('../config/funcionesDre.php');
	$conexion = DreConectarDB();
		
// tipoAgregar Contacto
if($_REQUEST['tipoSending'] == "agendaHora"){
	$fechaActualHora = date('Y-m-d H:i', strtotime(date('Y-m-d H:i')) + 3600);
//	$fechaActualHora = "2014-11-20 15:30";
	
	$sqlAgendaCadaHora = "
		Select * From 
			`agenda` Inner Join `usuarios`
			On
			`agenda`.`usuario` = `usuarios`.`CLAVE`
		Where 
			`fechaStart` Like '%".$fechaActualHora."%'
						 ";
						 
						 //".$fechaActualHora."
	echo "<pre>";
		echo $sqlAgendaCadaHora;
	echo "</pre>";
	$resAgendaCadaHora = DreQueryDB($sqlAgendaCadaHora);
	while($rowAgendaCadaHora = mysql_fetch_assoc($resAgendaCadaHora)){
		extract($rowAgendaCadaHora);
	
			// Enviar Correo de Notificacion
			$desde = "CAPSYS Web <do-not-reply@capsys.com.mx>";
			$para = $Email;
			$copia = "";
			$copiaOculta = "juanjose@dre-learning.com";
			$asunto = "Recordatorio de Cita Proxima Iniciando el: ".DreFechaEsp($fechaStart).substr($fechaStart,10,10)."Hrs   Terminando el: ".DreFechaEsp($fechaEnd).substr($fechaEnd,10,10)."Hrs";
			$mensaje = "";
			$mensaje.="<strong>Organizador:</strong> ".nombreVendedor($usuario)."<br />";
			$mensaje.="<strong>Asunto:</strong> ".$cita."<br /><br />";
			$mensaje.="<strong>Lugar:</strong> ".$lugar."<br /><br />";
			$mensaje.="<strong>Inicio:</strong> ".DreFechaEsp($fechaStart).substr($fechaStart,10,10)."Hrs   <strong>Finalizaci&oacute;n:</strong> ".DreFechaEsp($fechaEnd).substr($fechaEnd,10,10)."Hrs<br /><br /><br />";
			$mensaje.= $texto;
			$mensaje = str_replace ('"/img/userfiles/', '"http://capsys.com.mx/img/userfiles/' , $mensaje);
			DreMail($desde,$para,$copia,$copiaOculta,$asunto,$mensaje,'','');
			
			
	}

	include('CerrarVentana.php');	
}

if($_REQUEST['tipoSending'] == "agendaDia"){

	$sqlAgendaCadaHora = "
		Select * From 
			`agenda` Inner Join `usuarios`
			On
			`agenda`.`usuario` = `usuarios`.`CLAVE`
		Where 
			`fechaStart` Like '%".date('Y-m-d h:i')."%'
						 ";
						 
						 //".$fechaActualHora."

	$resAgendaCadaHora = DreQueryDB($sqlAgendaCadaHora);
	while($rowAgendaCadaHora = mysql_fetch_assoc($resAgendaCadaHora)){
		extract($rowAgendaCadaHora);
	
			// Enviar Correo de Notificacion
			$desde = "CAPSYS Web <do-not-reply@capsys.com.mx>";
			$para = $rowParaForeach['Email'];
			$copia = "";
			$copiaOculta = "juanjose@dre-learning.com";
			$asunto = "Agendar Cita para el: ".DreFechaEsp($fechaStart).substr($fechaStart,10,10)."Hrs   Terminando el: ".DreFechaEsp($fechaEnd).substr($fechaEnd,10,10)."Hrs";
			$mensaje = "";
			$mensaje.="<strong>Organizador:</strong> ".nombreVendedor($usuario)."<br />";
			$mensaje.="<strong>Asunto:</strong> ".$cita."<br /><br />";
			$mensaje.="<strong>Lugar:</strong> ".$lugar."<br /><br />";
			$mensaje.="<strong>Inicio:</strong> ".DreFechaEsp($fechaStart).substr($fechaStart,10,10)."Hrs   <strong>Finalizaci&oacute;n:</strong> ".DreFechaEsp($fechaEnd).substr($fechaEnd,10,10)."Hrs<br /><br /><br />";
			$mensaje.= $texto;
			$mensaje = str_replace ('"/img/userfiles/', '"http://capsys.com.mx/img/userfiles/' , $mensaje);
			
			DreMail($desde,$para,$copia,$copiaOculta,$asunto,$mensaje,'','');
			
	}

	include('CerrarVentana.php');	
}

DreDesconectarDB($conexion);
?>