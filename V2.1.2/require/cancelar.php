<?php
session_start();
extract($_REQUEST);
if(	$seccion != "index"){
	if(!isset($_SESSION['WebDreTacticaWeb2'])){ header("Location: index.php"); }
	if(!isset($_SESSION['WebDreTacticaWeb2']['Usuario'])){ header("Location: index.php"); }
}
include('../config/funcionesDre.php');
	$conexion = DreConectarDB();

// tipoCancelar citaCalendario
if($_REQUEST['tipoCancelar'] == 'citaCalendarioSerializada'){
	$sqlConsultaDatosCitaPadre = "
		Select * From
			`agenda`
		Where 
			`idAgendaMd5` = '$idAgenda'
								 ";
	$resConsultaDatosCitaPadre = DreQueryDB($sqlConsultaDatosCitaPadre);
	$rowConsultaDatosCitaPadre = mysql_fetch_assoc($resConsultaDatosCitaPadre);
	$cita = $rowConsultaDatosCitaPadre['cita'];
	$fechaStart = substr($rowConsultaDatosCitaPadre['fechaStart'], strpos($rowConsultaDatosCitaPadre['fechaStart'],' '));
	$usuario = $rowConsultaDatosCitaPadre['usuario'];

	$sqlRecorridoSerie = "
	Select * From 
		`agenda` 
	Where 
		(
			`cita` = '$cita' 
			And 
			`fechaStart` Like '%$fechaStart%'
		) 
		And 
		`usuario` = '$usuario'
					 ";
$resRecorridoSerie = DreQueryDB($sqlRecorridoSerie);
while($rowRecorridoSerie = mysql_fetch_assoc($resRecorridoSerie)){ // inicio del While Seriealizado
	$idAgendaMd5 = $rowRecorridoSerie['idAgendaMd5'];
	$sqlInfoCita = "
		Select * From 
			`agenda`
		Where
			`idAgendaMd5` = '$idAgendaMd5'
				   ";
	$resInfoCita = DreQueryDB($sqlInfoCita);
	$rowInfoCita = mysql_fetch_assoc($resInfoCita);
	
	$sqlInfoCitaInvitados = "
		Select * From 
			`agenda_invitados`
		Where 
			`idAgenda` = '".$rowInfoCita['idAgenda']."'
							";
	$resInfoCitaInvitados = DreQueryDB($sqlInfoCitaInvitados);
	while($rowInfoCitaInvitados = mysql_fetch_assoc($resInfoCitaInvitados)){
		
		$desde = "CAPSYS Web <do-not-reply@capsys.com.mx>";
		$para = DreCorreoUsuario($rowInfoCitaInvitados['usuario']);
		$copia = "";
		$copiaOculta = "";
		$asunto = "Cancelacion de Cita para el ".DreFechaEsp($rowInfoCita['fechaStart']).substr($rowInfoCita['fechaStart'],10,10)."Hrs    ".DreFechaEsp($rowInfoCita['fechaEnd']).substr($rowInfoCita['fechaEnd'],10,10)."Hrs";

		$mensaje = "";
		$mensaje.="<strong>Organizador:</strong> ".nombreVendedor($usuario)."<br />";
		$mensaje.="<strong>Asunto:</strong> ".$cita."<br /><br />";
		$mensaje.="<strong>Lugar:</strong> ".$lugar."<br /><br />";
		$mensaje.="<strong>Inicio:</strong> ".DreFechaEsp($fechaStart).substr($fechaStart,10,10)."Hrs   <strong>Finalizaci&oacute;n:</strong> ".DreFechaEsp($fechaEnd).substr($fechaEnd,10,10)."Hrs<br /><br /><br />";
		
		$fileAdjunto = "";
		$nameAdjunto = "";
		
//-->		DreMail($desde,$para,$copia,$copiaOculta,$asunto,$mensaje,$fileAdjunto,$nameAdjunto);

			$sqlInsertEnvioCorreo = "
				Insert Into
					`tmp_envio_correos`
					(
						`desde`
						,`para`
						,`copia`
						,`copiaOculta`
						,`asunto`
						,`mensaje`
						,`fileAdjunto`
						,`nameAdjunto`
					)
				Values
					(
						'$desde'
						,'$para'
						,'$copia'
						,'$copiaOculta'
						,'$asunto'
						,'$mensaje'
						,'$fileAdjunto'
						,'$nameAdjunto'
					)
									";
			DreQueryDB($sqlInsertEnvioCorreo);
	}
	
	$sqlUpdateCancelarCita = "
		Update 
			`agenda`
		Set
			`status` = '2'
		Where
			`idAgenda` = '".$rowInfoCita['idAgenda']."'
							 ";
	DreQueryDB($sqlUpdateCancelarCita);
	
	$sqlUpdateCancelarCitaInvitado = "
		Update
			`agenda_invitados`
		Set
			`confirmado` = '2'
		Where 
			`idAgenda` = '".$rowInfoCita['idAgenda']."'
									 ";
	DreQueryDB($sqlUpdateCancelarCitaInvitado);
	
} // fin del While Seriealizado
	$return = "../calendario.php";
	?>
    <script>
		alert('Cita Cancelada !!!');
		window.open('<?php echo $return; ?>','_self');
	</script>
    <?php

}

// tipoCancelar citaCalendario
if($_REQUEST['tipoCancelar'] == 'citaCalendario'){
	
	$sqlInfoCita = "
		Select * From 
			`agenda`
		Where
			`idAgendaMd5` = '$idAgenda'
				   ";
	$resInfoCita = DreQueryDB($sqlInfoCita);
	$rowInfoCita = mysql_fetch_assoc($resInfoCita);
	
	$sqlInfoCitaInvitados = "
		Select * From 
			`agenda_invitados`
		Where 
			`idAgenda` = '".$rowInfoCita['idAgenda']."'
							";
	$resInfoCitaInvitados = DreQueryDB($sqlInfoCitaInvitados);
	while($rowInfoCitaInvitados = mysql_fetch_assoc($resInfoCitaInvitados)){
		$desde = "Calendario CAPSYS Web <do-not-reply@capsys.com.mx>";
		$para = DreCorreoUsuario($rowInfoCitaInvitados['usuario']);
		$copia = "";
		$copiaOculta = "";
		$asunto = "Cancelacion de Cita para el ".DreFechaEsp($rowInfoCita['fechaStart']).substr($rowInfoCita['fechaStart'],10,10)."Hrs    ".DreFechaEsp($rowInfoCita['fechaEnd']).substr($rowInfoCita['fechaEnd'],10,10)."Hrs";

		$mensaje = "";
		$mensaje.="<strong>Organizador:</strong> ".nombreVendedor($rowInfoCita['usuario'])."<br />";
		$mensaje.="<strong>Asunto:</strong> ".urldecode($rowInfoCita['cita'])."<br /><br />";
		$mensaje.="<strong>Lugar:</strong> ".$rowInfoCita['lugar']."<br /><br />";
		$mensaje.="<strong>Inicio:</strong> ".DreFechaEsp($rowInfoCita['fechaStart']).substr($rowInfoCita['fechaStart'],10,10)."Hrs   <strong>Finalizaci&oacute;n:</strong> ".DreFechaEsp($rowInfoCita['fechaEnd']).substr($rowInfoCita['fechaEnd'],10,10)."Hrs<br /><br /><br />";

		$fileAdjunto = "";
		$nameAdjunto = "";
		DreMail($desde,$para,$copia,$copiaOculta,$asunto,$mensaje,$fileAdjunto,$nameAdjunto);
	}
	
	$sqlUpdateCancelarCita = "
		Update 
			`agenda`
		Set
			`status` = '1'
		Where
			`idAgenda` = '".$rowInfoCita['idAgenda']."'
							 ";
	DreQueryDB($sqlUpdateCancelarCita);

	$sqlUpdateCancelarCitaInvitado = "
		Update
			`agenda_invitados`
		Set
			`confirmado` = '2'
		Where 
			`idAgenda` = '".$rowInfoCita['idAgenda']."'
									 ";
	DreQueryDB($sqlUpdateCancelarCitaInvitado);
	
	
	$return = "../calendario.php";
	?>
    <script>
		alert('Cita Cancelada !!!');
		window.open('<?php echo $return; ?>','_self');
	</script>
    <?php
}
// tipoCancelar citaCalendario
if($_REQUEST['tipoCancelar'] == 'citaCalendarioElementoSerializada'){
	
	$sqlInfoCita = "
		Select * From 
			`agenda`
		Where
			`idAgendaMd5` = '$idAgenda'
				   ";
	$resInfoCita = DreQueryDB($sqlInfoCita);
	$rowInfoCita = mysql_fetch_assoc($resInfoCita);
	
	if($rowInfoCita['padre'] != 0){
		$idAgendaPadreMd5 = md5($rowInfoCita['padre']);
	} else if($rowInfoCita['idAgenda'] != 0) {
		$idAgendaPadreMd5 = md5($rowInfoCita['idAgenda']);
	}
	
	$sqlInfoCitaInvitados = "
		Select * From 
			`agenda_invitados`
		Where 
			`idAgenda` = '".$rowInfoCita['idAgenda']."'
							";
	$resInfoCitaInvitados = DreQueryDB($sqlInfoCitaInvitados);
	while($rowInfoCitaInvitados = mysql_fetch_assoc($resInfoCitaInvitados)){
		$desde = "Calendario CAPSYS Web <do-not-reply@capsys.com.mx>";
		$para = DreCorreoUsuario($rowInfoCitaInvitados['usuario']);
		$copia = "";
		$copiaOculta = "";
		$asunto = "Cancelacion de Cita para el ".DreFechaEsp($rowInfoCita['fechaStart']).substr($rowInfoCita['fechaStart'],10,10)."Hrs    ".DreFechaEsp($rowInfoCita['fechaEnd']).substr($rowInfoCita['fechaEnd'],10,10)."Hrs";

		$mensaje = "";
		$mensaje.="<strong>Organizador:</strong> ".nombreVendedor($rowInfoCita['usuario'])."<br />";
		$mensaje.="<strong>Asunto:</strong> ".urldecode($rowInfoCita['cita'])."<br /><br />";
		$mensaje.="<strong>Lugar:</strong> ".$rowInfoCita['lugar']."<br /><br />";
		$mensaje.="<strong>Inicio:</strong> ".DreFechaEsp($rowInfoCita['fechaStart']).substr($rowInfoCita['fechaStart'],10,10)."Hrs   <strong>Finalizaci&oacute;n:</strong> ".DreFechaEsp($rowInfoCita['fechaEnd']).substr($rowInfoCita['fechaEnd'],10,10)."Hrs<br /><br /><br />";

		$fileAdjunto = "";
		$nameAdjunto = "";
		DreMail($desde,$para,$copia,$copiaOculta,$asunto,$mensaje,$fileAdjunto,$nameAdjunto);
	}
	
	$sqlUpdateCancelarCita = "
		Update 
			`agenda`
		Set
			`status` = '1'
		Where
			`idAgenda` = '".$rowInfoCita['idAgenda']."'
							 ";
	DreQueryDB($sqlUpdateCancelarCita);

	$sqlUpdateCancelarCitaInvitado = "
		Update
			`agenda_invitados`
		Set
			`confirmado` = '2'
		Where 
			`idAgenda` = '".$rowInfoCita['idAgenda']."'
									 ";
	DreQueryDB($sqlUpdateCancelarCitaInvitado);

	$return = "../calendarioDetalle.php?idAgenda=".$idAgendaPadreMd5;
	?>
    <script>
		alert('Cita Cancelada Elemento de Serie!!!');
		window.open('<?php echo $return; ?>','_self');
	</script>
    <?php
}

DreDesconectarDB($conexion);
?>