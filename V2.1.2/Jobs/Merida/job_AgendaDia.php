<?php
include('../../config/funcionesDre.php');
$conexion = DreConectarDB();
extract($_REQUEST);

$diaSemanaEsp[0] = "Domingo";
$diaSemanaEsp[1] = "Lunes";
$diaSemanaEsp[2] = "Martes";
$diaSemanaEsp[3] = "Mi&eacute;rcoles";
$diaSemanaEsp[4] = "Jueves";
$diaSemanaEsp[5] = "Viernes";
$diaSemanaEsp[6] = "S&aacute;bado";

$sqlConsultaDiaUsuarios = "
	Select 
		*
		,`agenda_invitados`.`usuario` As `usuarioActividad`
	From 
		`agenda` Inner Join `agenda_invitados`
		On
		`agenda`.`idAgenda` = `agenda_invitados`.`idAgenda`
	Where 
		date_format(`fechaStart`, '%Y-%m-%d') = Curdate()
		And 
		`agenda_invitados`.`usuario` Like '0%'
	Group By
		`agenda_invitados`.`usuario`
				  ";
	//echo "<pre>";
		//echo $sqlConsultaDiaUsuarios;
	//echo "</pre>";
$resConsultaDiaUsuarios = DreQueryDB($sqlConsultaDiaUsuarios);

while($rowConsultaDiaUsuarios = mysql_fetch_assoc($resConsultaDiaUsuarios)){
	$usuariosConActividades[] = $rowConsultaDiaUsuarios['usuarioActividad'];
}

// Limpieza de Variables
	$para = ""; 
	$mensaje = "";
	$citasDia = "";
	$usuario = "";	
foreach($usuariosConActividades as $usuario){
//	echo $usuario."<br />"; //
	$sqlConsultaUsuarioDia = "
		Select 
			*
			,`agenda_invitados`.`usuario` As `usuarioActividad`
			,date_format(`agenda`.`fechaStart`,'%Y-%m-%d') As `dia`
			,date_format(`agenda`.`fechaStart`,'%w') As `diaSemana`
			,date_format(`agenda`.`fechaStart`,'%a-%m-%Y') As `diaLetras`
			,date_format(`agenda`.`fechaStart`,'%Y-%m-%d') As `fechaCita`
			,date_format(`agenda`.`fechaStart`,'%H:%i %p') As `horaCita`
		From
			`agenda` Inner Join `agenda_invitados`
			On
			`agenda`.`idAgenda` = `agenda_invitados`.`idAgenda`
		Where
			(
				`confirmado` = '1'
			)
			And
			(
				date_format(`fechaStart`, '%Y-%m-%d') = Curdate()
				And 
				`agenda_invitados`.`usuario` = '".$usuario."'
			)
							  ";
	//echo "<pre>";
		//echo "&bull;)=>";
		//echo $sqlConsultaUsuarioDia;
	//echo "</pre>";
	$resConsultaUsuarioDia = DreQueryDB($sqlConsultaUsuarioDia);

//	$mensaje = "";		
	$citasDia = "";
	$confirmado = 0;
	while($rowConsultaUsuarioDia = mysql_fetch_assoc($resConsultaUsuarioDia)){
		
		$confirmado = $rowConsultaUsuarioDia['confirmado'];
		
		$diaSemana = $rowConsultaUsuarioDia['diaSemana'];
		$dia = DreFechaEsp($rowConsultaUsuarioDia['dia']);
		$diaLetras = $rowConsultaUsuarioDia['diaLetras'];
			$citasDia.= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-".urldecode($rowConsultaUsuarioDia['cita'])."&nbsp;";
			$citasDia.= date('d-m-Y',strtotime($rowConsultaUsuarioDia['fechaCita']))." ".$rowConsultaUsuarioDia['horaCita']."<br />";
			$citasDia.= "<hr>";	
		$mensaje = "";	
		$mensaje .= "<font style=\'font-size:20px;\'>";
		$mensaje .= "<strong>Agenda ".$diaSemanaEsp[$diaSemana]." ".$dia."</strong><br />";
		$mensaje .= "</font>";
		$mensaje .= "<font style=\'font-style:italic\'>"; //
		$mensaje .= "&nbsp;&nbsp;&nbsp;<br>".nombreUsuario($usuario)."<br />"; //
		$mensaje .= "</font>"; //
		$mensaje .= "<font style=\'font-size:14px;\'>";
		$mensaje .= $citasDia;
		$mensaje .= "</font>";	

	}
if((isset($mensaje) && $mensaje!= "") && $confirmado == 1){		

	$correoUsuarioAgenda = DreCorreoUsuario($usuario);	
	$desde = "CAPSYS Web <do-not-reply@capsys.com.mx>"; //--> CAPSYS Web <capsysweb@agentecapital.com>
	$para = $correoUsuarioAgenda = DreCorreoUsuario($usuario);
//	$copia = "";
//	$copiaOculta = "";
	$asunto = "Agenda del Dia CAPSYS Web";
	$fileAdjunto = "";
	$nameAdjunto = "";

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
	//echo "<pre>";
	//	echo "<br>correo enviado";
	//	echo $para;
	//	echo "<br>";
	//	echo $mensaje;
	//	echo "<br>";
	//	echo "<-------------------------------------->";
	//	echo "<br>";
	//	echo $sqlInsertEnvioCorreo;
	//echo "</pre>";
			DreQueryDB($sqlInsertEnvioCorreo);

}

} //Fin Foreach

include('CerrarVentana.php');

?>