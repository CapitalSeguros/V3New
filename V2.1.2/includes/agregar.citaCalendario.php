<?php
// tipoAgregar citaCalendario
if($_REQUEST['tipoAgregar'] == 'citaCalendario'){

switch($periodicidad){
	case "year":
		$tituloPeriodicidad = "[Anual]";
	break;
	
	case "diario":
		$tituloPeriodicidad = "[Diario]";
	break;
	
	case "semana":
		$tituloPeriodicidad = "[Semanal]";
	break;
	
	case "semanaDos":
		$tituloPeriodicidad = "[Cada 2 Semanas]";
	break;
	
	case "mesDia":
		$tituloPeriodicidad = "[Mensual Dia]";
	break;

	case "mesFecha":
		$tituloPeriodicidad = "[Mensual Fecha]";
	break;

	case "";
		$tituloPeriodicidad = "";
	break;
}

//**--> reenvio AddInvitados
	if(isset($addInvitados)){ //reenvio_AddInvitados
		$url_AddInvitados = "../calendarioAgregar.php?cita=".$cita;
		$url_AddInvitados.= "&lugar=".$lugar;
		$url_AddInvitados.= "&categoria=".$categoria;
		$url_AddInvitados.= "&privado=".$privado;
		$url_AddInvitados.= "&fechaStart=".$fechaStart;
		$url_AddInvitados.= "&horaStart=".$horaStart;
		$url_AddInvitados.= "&todoDia=".$todoDia;
		$url_AddInvitados.= "&fechaEnd=".$fechaEnd;
		$url_AddInvitados.= "&horaEnd=".$horaEnd;
		$url_AddInvitados.= "&periodicidad=".$periodicidad;
		$url_AddInvitados.= "&usuario=".$usuario;
		$url_AddInvitados.= "&addInvitados=".$addInvitados;
		$url_AddInvitados.= "&texto=".urlencode(htmlspecialchars($texto, ENT_NOQUOTES));

		header("Location: $url_AddInvitados");

	} else { 

//**--> Creacion de Cita Calendario
		//** Ajuste Formato Fechas
		$fechaStart_x = explode('-',$_REQUEST['fechaStart']);
		$fechaStart_Format = $fechaStart_x[2]."-".$fechaStart_x[1]."-".$fechaStart_x[0]." ".$horaStart.":00";
	
		$fechaEnd_x = explode('-',$_REQUEST['fechaEnd']);
		$fechaEnd_Format = $fechaEnd_x[2]."-".$fechaEnd_x[1]."-".$fechaEnd_x[0]." ".$horaEnd.":00";
	
		$sqlDisponibilidadMiMismo = "
			Select 
			Count(*) As `MiMismo` 
		From
			`agenda`
		Where
			(
				`fechaStart` Between '$fechaStart_Format' And '$fechaEnd_Format'
				And
				`status`= '0'
			)
			And
			`usuario` = '$usuario'
									";
		$resDisponibilidadMiMismo = DreQueryDB($sqlDisponibilidadMiMismo);
		$MiMismo = mysql_result($resDisponibilidadMiMismo, 0);

//**--> Validacion Ya Tienes Cita
		if($MiMismo != "0"){ //Validacion MiMismo [Ya Tienes una Cita en la Misma Fecha  y Hora]
			$url_DisponibilidadMiMismo = "../calendarioAgregar.php?cita=".$cita;
			$url_DisponibilidadMiMismo.= "&lugar=".$lugar;
			$url_DisponibilidadMiMismo.= "&categoria=".$categoria;
			$url_DisponibilidadMiMismo.= "&privado=".$privado;
			$url_DisponibilidadMiMismo.= "&fechaStart=".$fechaStart;
			$url_DisponibilidadMiMismo.= "&horaStart=".$horaStart;
			$url_DisponibilidadMiMismo.= "&todoDia=".$todoDia;
			$url_DisponibilidadMiMismo.= "&fechaEnd=".$fechaEnd;
			$url_DisponibilidadMiMismo.= "&horaEnd=".$horaEnd;
			$url_DisponibilidadMiMismo.= "&periodicidad=".$periodicidad;
			$url_DisponibilidadMiMismo.= "&usuario=".$usuario;
			$url_DisponibilidadMiMismo.= "&addInvitados=".$addInvitados;
			$url_DisponibilidadMiMismo.= "&texto=".urlencode(htmlspecialchars($texto, ENT_NOQUOTES));
			$url_DisponibilidadMiMismo.= "&invitadosLibres=".$invitadosLibres;
			foreach($paInvitado as $paInvitadoYaAgregado){
				$paInvitadoAgregado.= "*".$paInvitadoYaAgregado;
			}
			$url_DisponibilidadMiMismo.= "&paInvitado=".$paInvitadoAgregado;
		?>
    	<script>
			var textoAlerta = "\n Ya tienes una Cita en la Misma Fecha y Hora !!!";
			alert(textoAlerta);
			window.open('<? echo $url_DisponibilidadMiMismo; ?>','_self');
		</script>
		<?
		} //Validacion MiMismo [Ya Tienes una Cita en la Misma Fecha  y Hora]

//**--> Creacion AgendaCalendarioCita
		// Iniciamos la Creacion de la Agenda-Calendario-Cita
		if($fechaStart == ""){ $fechaStart = date('d-m-Y'); } 
		if($horaStart == ""){ $horaStart = "08:00"; }
	
		if($fechaEnd == ""){ $fechaEnd = date('d-m-Y'); }
		if($horaEnd == ""){ $horaEnd = "08:30"; }
	
		$fechaStart = explode('-', $fechaStart);
		$fechaStart = $fechaStart[2]."-".$fechaStart[1]."-".$fechaStart[0]." ".$horaStart;

		$fechaEnd = explode('-', $fechaEnd);
		$fechaEnd = $fechaEnd[2]."-".$fechaEnd[1]."-".$fechaEnd[0]." ".$horaEnd;
		
		$semanasTranscurridasYear = date('W');
		$mesesTranscurridosYear = date('n');
		$diaPalabra = date('l',  strtotime($fechaEnd)); 

//**--> periodicidad AgendaCalendarioCita
		switch ($periodicidad){

			case "mesDia":
				$periodicidadRepite = 13 - $mesesTranscurridosYear ; 
				$periodicidadTipo = "";
			break;

 			case "semanaDos":
				$periodicidadRepite = 28 -($semanasTranscurridasYear/2) ; 
				$periodicidadTipo = "";
			break;
			
			case "diario":
				$periodicidadRepite = 366; // - $semanasTranscurridasYear ; 
				$periodicidadTipo = "";
			break;
			
 			case "semana":
				$periodicidadRepite = 55 - $semanasTranscurridasYear ; 
				$periodicidadTipo = "";
			break;
			
			case "mesFecha":
				$periodicidadRepite = 13 - $mesesTranscurridosYear ; 
				$periodicidadTipo = "";
			break;
			
			case "year":
				$periodicidadRepite = 5;
				$periodicidadTipo = "";
			break;
			
			default:
				$periodicidadRepite = 1;
				$periodicidadTipo = "";
			break;
		}

//** Textos Correo **))
		$asuntoInicial= "Agendar Cita ".$tituloPeriodicidad." - Inicia el:".DreFechaEsp($fechaStart).substr($fechaStart,10,10)."Hrs ";
		$mensaje = "";
		$mensaje.="<strong>Organizador:</strong> ".nombreVendedor($usuario)."<br />";
		$mensaje.="<strong>Asunto:</strong> ".$cita."<br />";
		$mensaje.="<strong>Lugar:</strong> ".$lugar."<br />";
		$mensaje.= $texto;		
		
		$mensaje.= "<strong>&bull;Periodicidad Citas:</strong><br>";
		$mensaje.= "<blockquote>";		
//** Textos Correo **))
		
		$contperiodicidad = 0;
		while($contperiodicidad < intval($periodicidadRepite) ){ // Inicio de Periodicidad
			$contperiodicidad++;
			$sqlInsertCita = "
				Insert Into
				`agenda`
			(
				`usuario`
				,`fechaStart`
				,`fechaEnd`
				,`cita`
				,`categoria`
				,`privado`
				,`todoDia`
				,`periodicidad`
				,`texto`
				,`lugar`
				,`padre`
			)
			Values
			(
				'$usuario'
				,'$fechaStart'
				,'$fechaEnd'
				,'".urlencode($cita)."'
				,'$categoria'
				,'$privado'
				,'$todoDia'
				,'$periodicidad'
				,'".urlencode(htmlspecialchars($texto, ENT_NOQUOTES))."'
				,'$lugar'
				,'$padre'
			);
							 ";
			DreQueryDB($sqlInsertCita);
			//$padre= mysql_insert_id();
			$idAgendaLink.= mysql_insert_id()."*";
		$idAgendaLinkMd5 = $padre = substr($idAgendaLink,0,strpos($idAgendaLink, '*'));
//** Textos Correo **))
			$mensaje.= "<strong>Inicio:</strong> ".DreFechaEsp($fechaStart)." ".substr($fechaStart,10,10)."Hrs ";
			$mensaje.= "<strong>Finalizaci&oacute;n:</strong> ".DreFechaEsp($fechaEnd)." ".substr($fechaEnd,10,10)."Hrs";
			$mensaje.= "<br />";
//** Textos Correo **))
			
//**--> periodicidad AgendaCalendarioCita Calculamos Fechas
		switch($periodicidad){
		
			case "mesDia":
				$fechaStart = date ( 'Y-m-j H:i' , strtotime ( '+3 week next '.$diaPalabra , strtotime ( $fechaStart ) ) )  ;
				$fechaEnd = date ( 'Y-m-j H:i' , strtotime ( '+3 week next '.$diaPalabra , strtotime ( $fechaEnd ) ) )  ;
			break;
		
			case "semanaDos":
				$fechaStart = date ( 'Y-m-j H:i' , strtotime ( '+2 week' , strtotime ( $fechaStart ) ) )  ;
				$fechaEnd = date ( 'Y-m-j H:i' , strtotime ( '+2 week' , strtotime ( $fechaEnd ) ) )  ;
			break;

			case "diario":
				$fechaStart = date ( 'Y-m-j H:i' , strtotime ( '+1 day' , strtotime ( $fechaStart ) ) )  ;
				$fechaEnd = date ( 'Y-m-j H:i' , strtotime ( '+1 day' , strtotime ( $fechaEnd ) ) )  ;
			break;
			
			case "semana":
				$fechaStart = date ( 'Y-m-j H:i' , strtotime ( '+1 week' , strtotime ( $fechaStart ) ) )  ;
				$fechaEnd = date ( 'Y-m-j H:i' , strtotime ( '+1 week' , strtotime ( $fechaEnd ) ) )  ;
			break;
		
			case "mesFecha":
				$fechaStart = date ( 'Y-m-j H:i' , strtotime ( '+1 month' , strtotime ( $fechaStart ) ) )  ;
				$fechaEnd = date ( 'Y-m-j H:i' , strtotime ( '+1 month' , strtotime ( $fechaEnd ) ) )  ;
			break;
		
			case "year":
				$fechaStart = date ( 'Y-m-j H:i' , strtotime ( '+1 year' , strtotime ( $fechaStart ) ) )  ;
				$fechaEnd = date ( 'Y-m-j H:i' , strtotime ( '+1 year' , strtotime ( $fechaEnd ) ) )  ;
			break;
		}
	
		$arregloIdAgenda[] = $idAgenda = mysql_insert_id();
 
		$sqlUpdateidAgendaMd5 = "
			Update 
			`agenda`
		Set 
			`idAgendaMd5` = '".md5($idAgenda)."'
		Where
			 `idAgenda` = '$idAgenda'
								";
		DreQueryDB($sqlUpdateidAgendaMd5);

//**--> Invitados AgendaCalendarioCita
		$sqlInsertYoInvitadosAgenda = "
			Insert Into
				`agenda_invitados`
			(
				`idAgenda`
				,`usuario`
				,`confirmado`
			)
			Values
			(
				'$idAgenda'
				,'$usuario'
				,'1'
			);
								  ";
		DreQueryDB($sqlInsertYoInvitadosAgenda);

//**--> Invitados AgendaCalendarioCita
		if(isset($paInvitado)){ // empty($paInvitado) && 
			foreach($paInvitado as $tipoEnvio){
				switch ($tipoEnvio){
					case "todos":
						$sqlTodosEmail = "
							Select * From 
								`usuarios` 
							Where
								`Email` != ''
										 ";
						$resTodosEmail = DreQueryDB($sqlTodosEmail);
						while($rowTodosEmail = mysql_fetch_assoc($resTodosEmail)){
							$paInvitado[] = $rowTodosEmail['VALOR'];
						}
					break;
				// ---->
					case "todosGerentes":
						$sqlGerentesEmail = "
							Select * From 
								`usuarios` 
							Where 
								`Email` != '' 
								And
								`TIPO` Like '2%'
											";
						$resGerentesEmail = DreQueryDB($sqlGerentesEmail);
						while($rowGerentesEmail = mysql_fetch_assoc($resGerentesEmail)){
							$paInvitado[] = $rowGerentesEmail['VALOR'];
						}
					break;
				// ---->
					case "todosEjecutivos":
						$sqlEjecutivosEmail = "
							Select * From 
								`usuarios` 
							Where 
								`Email` != ''
								And 
								(
									`TIPO` Like '31%' 
									Or
									`TIPO` Like '32%'
									Or
									`TIPO` Like '33%'
								)
											  ";
						$resEjecutivosEmail = DreQueryDB($sqlEjecutivosEmail);
						while($rowEjecutivosEmail = mysql_fetch_assoc($resEjecutivosEmail)){
							$paInvitado[] = $rowEjecutivosEmail['VALOR'];
						}
					break;
				// ---->
					case "todosPromotores":
						$sqlPromotoresEmail = "
							Select * From 
								`usuarios` 
							Where 
								`Email` != '' 
								And 
								(
									`TIPO` Like '30%'
								)
								 ";
						$resPromotoresEmail = DreQueryDB($sqlPromotoresEmail);
						while($rowPromotoresEmail = mysql_fetch_assoc($resPromotoresEmail)){
							$paInvitado[] = $rowPromotoresEmail['VALOR'];
						}
					break;
				// ---->
					case "todosVendedores":
						$sqlVendedoresEmail = "
							Select * From 
								`usuarios` 
							Where 
								`Email` != '' 
								And 
								(
									`TIPO` Like '30%'
								)
										  ";
						$resVendedoresEmail = DreQueryDB($sqlVendedoresEmail);
						while($rowVendedoresEmail = mysql_fetch_assoc($resVendedoresEmail)){
							$paInvitado[] = $rowVendedoresEmail['VALOR'];
						}
					break;
				// ---->
				}
			}
		$paInvitado = array_unique($paInvitado);
		}

//**--> Invitados AgendaCalendarioCita
		if(isset($paInvitado)){
			foreach($paInvitado as $invitado){
				$sqlInvitadosCita = "
					Insert Into
						`agenda_invitados`
					(
						`idAgenda`
						,`usuario`
					)
					Values
					(
						'$idAgenda'
						,'$invitado'
					)
									";
				DreQueryDB($sqlInvitadosCita);
			}// fin de Foreach $paInvitado
		}// fin del If $paInvitado
	
// --->
		$invitadosLibresArray = multiexplode(array(';', ','), $invitadosLibres);
		if(isset($invitadosLibresArray)){
			foreach($invitadosLibresArray as $invitadoLibre){
				if($invitadoLibre != ""){
					$sqlInvitadosCitaLibres = "
						Insert Into
							`agenda_invitados`
						(
							`idAgenda`
							,`usuario`
						)
						Values
						(
							'$idAgenda'
							,'".str_replace(' ','',$invitadoLibre)."'
						)
										  ";
					DreQueryDB($sqlInvitadosCitaLibres);
				}
			} // Fin del Foreach
		} // FIn del If
		
		}// Fin de periodicidad
		
//**--> Barrido de la Agenda 
		foreach($arregloIdAgenda as $idAgendaSendMail){
			//**--> Calculamos Correos de Invitados Sistema
			$sqlInvitadosIdAgenda = "
				Select 
					*
					,`agenda_invitados`.`usuario` As `usuarioCorreo`
				From 
					`agenda_invitados` Inner Join `agenda`
					On
					`agenda_invitados`.`idAgenda` = `agenda`.`idAgenda`
				Where
				 	`agenda`.`idAgenda` = '$idAgendaSendMail'
				 	And
				 	(
				 		`agenda_invitados`.`usuario` Not Like '%@%'
				 		And
				 		`agenda_invitados`.`usuario` != ''
					)
								   ";
			$resInvitadosIdAgenda = DreQueryDB($sqlInvitadosIdAgenda);
			while($rowInvitadosIdAgenda = mysql_fetch_assoc($resInvitadosIdAgenda)){
				if(!in_array(DreCorreoUsuario($rowInvitadosIdAgenda['usuarioCorreo']), $paCorreo)){
					$paCorreo[] = DreCorreoUsuario($rowInvitadosIdAgenda['usuarioCorreo']);
					$paUsurio[] = $rowInvitadosIdAgenda['usuarioCorreo'];
				}
			}
			
			//**--> Calculamos Correos de Invitados Libres
			$sqlInvitadosIdAgendaLibres = "
				Select
					*
					,`agenda_invitados`.`usuario` As `usuarioCorreo`
				From 
					`agenda_invitados` Inner Join `agenda`
					On
					`agenda_invitados`.`idAgenda` = `agenda`.`idAgenda`
				Where
				 	`agenda`.`idAgenda` = '$idAgendaSendMail'
				 	And
				 	(
				 		`agenda_invitados`.`usuario` Like '%@%'
				 		And
				 		`agenda_invitados`.`usuario` != ''
					)
								   ";
			$resInvitadosIdAgendaLibres = DreQueryDB($sqlInvitadosIdAgendaLibres);
			while($rowInvitadosIdAgendaLibres = mysql_fetch_assoc($resInvitadosIdAgendaLibres)){
				if(!in_array($rowInvitadosIdAgendaLibres['usuarioCorreo'], $paCorreo)){
					$paCorreo[] = $rowInvitadosIdAgendaLibres['usuarioCorreo'];
					$paUsurio[] = $rowInvitadosIdAgendaLibres['usuarioCorreo'];
				}
			}
		}  //Foreach 

//**-->> Recorrido Envio Correo
		foreach($paCorreo as $indice => $correoEnvio){
			
		//**--> Envio de Correo
			// Enviar Correo de Notificacion
			$desde = "Calendario CAPSYS Web <do-not-reply@capsys.com.mx>";
			$para = $correoEnvio;
			$copia = "";
			$copiaOculta = "juanjose@dre-learning.com";		
			$asuntoFinal = "Terminando el: ".DreFechaEsp($fechaEnd).substr($fechaEnd,10,10)."Hrs";
			$asunto = $asuntoInicial.$asuntoFinal;
			$mensaje.= "</blockquote>";
			$mensaje = str_replace ('"/img/userfiles/', '"http://capsys.com.mx/img/userfiles/' , $mensaje);
						
//		$idAgendaLinkMd5 = substr($idAgendaLink,0,strpos($idAgendaLink, '*'));
		$linkConfirmar = "http://capsys.com.mx/calendarioAgendaConfirmacion.php?idAgenda=".md5($idAgendaLinkMd5)."&usuario=".str_replace(' ','',$paUsurio[$indice]);
		$linkCancelar  = "http://capsys.com.mx/calendarioAgendaCancelacion.php?idAgenda=".md5($idAgendaLinkMd5)."&usuario=".str_replace(' ','',$paUsurio[$indice]);

			$mensajeFinal = $mensaje;
			$mensajeFinal.= "<br>";
			$mensajeFinal.= "Confirmar Invitaci&oacute;n ";
			$mensajeFinal.= "<a href=\'".$linkConfirmar."\'>Click Aqu&iacute;</a>";
			$mensajeFinal.= "<br /><br />";
			$mensajeFinal.= "Cancelar Invitaci&oacute;n ";
			$mensajeFinal.= "<a href=\'".$linkCancelar."\'>Click Aqu&iacute;</a>";
			$mensajeFinal.= "<br><br>";

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
						,'$mensajeFinal'
						,'$fileAdjunto'
						,'$nameAdjunto'
					)
									";
		DreQueryDB($sqlInsertEnvioCorreo);

		}
	header('Location: ../calendario.php');
	} //reenvio_AddInvitados
}

?>