<?
//** Consulta Cotizacion	
$sqlConsultaCotizacion = "
	Select * From
		`actividades`
	Where
		`recId` = '$recId'
		And 
		`inicio` = '0'
						 ";
$resConsultaCotizacion = DreQueryDB($sqlConsultaCotizacion);
$rowConsultaCotizacion = mysql_fetch_assoc($resConsultaCotizacion);

/* Iniciamos proceso de termino segun el Tipo de Emision */
switch($Resultado){

//** conEmisionManual
	case "conEmisionManual";
	/*Creamos la actividad Emision*/
		$recIdNew = mysql_result(DreQueryDB("Select `valor`+1 From `configdre` Where `parametro` = 'folioActividad'"),0);
		DreQueryDB("Update `configdre` Set `valor` = '$recIdNew' Where `parametro` = 'folioActividad'");
		$recId = $recIdNew = "w".$recIdNew;

		$sqlInsertActividadEmision = "
			Insert Into 
			`actividades` 
				(
					`recId`
					,`idRef`
					,`tipo`
					,`actividadInterno`
					,`ramoInterno`
					,`referencia`
					,`actividad`
					,`usuario`
					,`usuarioCreacion`
					,`usuarioBolita`
					,`fechaCreacion`
					,`fechaProgramada`
					,`cotizacionEmision`
					,`aseguradoraUno`
				) 
				VALUES
				(
					'$recIdNew'
					,'$rowConsultaCotizacion[idRef]'
					,'$rowConsultaCotizacion[tipo]'
					,'Emisi%F3n'
					,'$rowConsultaCotizacion[ramoInterno]'
					,'$comenResultado'
					,'Emisi&oacute;n - ".urldecode($rowConsultaCotizacion[ramoInterno])."'
					,'$rowConsultaCotizacion[usuario]'
					,'$rowConsultaCotizacion[usuarioCreacion]'
					,'$usuarioBolita'
					,'".date('Y-m-d H:i:s')."'
					,'".date('Y-m-d')."'
					,'$rowConsultaCotizacion[recId]'
					,'$rowConsultaCotizacionWs[aseguradora]'
				);
									 ";
		DreQueryDB($sqlInsertActividadEmision);
		$idInternoReturn = mysql_insert_id();

	/*Terminamos la Actividad Cotizacion*/
		$fechaTermino = date('Y-m-d H:i:s');
		$sqlFinalizarActividad = "
			Update 
				`actividades`
			Set
				`fin` = '1'
				,`Resultado` = '$Resultado'
				,`comenResultado` = '$comenResultado'
				,`fechaTermino` = '$fechaTermino'
				,`cotizacionEmision` = '$recIdNew'
				,`aseguradoraUno` = '$rowConsultaCotizacionWs[aseguradora]'
			Where 
				`idInterno` = '$rowConsultaCotizacion[idInterno]'
								 ";
		DreQueryDB($sqlFinalizarActividad);
		
	/*Creamos la actividad Emision Complemento */
		$sqlInsertActividadEmisionComplemento = "
			Insert Into
				`actividades_emision`
				(
					`idActividad`
					,`tipoEmisiones` 
					,`comentarios`
				)
				Values
				(
					'$recIdNew'
					,'$tipoEmisionEmision'
					,'$comenResultado'
				)
												";
		DreQueryDB($sqlInsertActividadEmisionComplemento);

		$return = "../actividadesDetalle.php?recId=".$recIdNew."&muestra=Documentos#DocumentosActividad";
	break;

//** recotizar
	case "recotizar";
	/*Creamos la actividad Recotizacion*/
		$sqlAgregarActividadRecotizacion = "
			Insert Into `actividades`
				(
					`recId`
					,`inicio`
					,`referencia`
					,`usuario`
					,`usuarioCreacion`
					,`usuarioBolita`
					,`actividadInterno`
					,`ramoInterno`
					,`idRef`
					,`tipo`
					,`actividad`
				)
				Values
				(
					'$recId'
					,'1'
					,'$comenResultado'
					,'$rowConsultaCotizacion[usuario]'
					,'$rowConsultaCotizacion[usuarioCreacion]'
					,''
					,'$rowConsultaCotizacion[actividadInterno]'
					,'$rowConsultaCotizacion[ramoInterno]'
					,'$rowConsultaCotizacion[idRef]'
					,'$rowConsultaCotizacion[tipo]'
					,'$rowConsultaCotizacion[actividad]'
				)
										  ";
		DreQueryDB($sqlAgregarActividadRecotizacion);
		$idActividad = mysql_insert_id();
	
		$sqlUpdateidInternoMd5 = 	"
			Update 
				`actividades`
			Set 
				`idInternoMd5` = '".md5($idActividad)."'
			Where 
				`idInterno` = '$idActividad'
									";
		DreQueryDB($sqlUpdateidInternoMd5);

	/*Actualizamos la actividad Cotizacion*/
		$sqlUpdateRespuesta = "
			Update
				`actividades`
			Set
				`respuesta` = '$respuesta'
				,`usuarioBolita` = '$usuarioBolita'
				,`prioridad` = '2'
				,`usuarioBloqueo` = ''
				,`fechaRecotizador` = '".date('Y-m-d H:i:s')."'
				,`usuarioRecotizador` = '".$_SESSION['WebDreTacticaWeb2']['Usuario']."'
--				,`fechaRecotizador2` = '".date('Y-m-d H:i:s')."'
--				,`usuarioRecotizador2` = '".$_SESSION['WebDreTacticaWeb2']['Usuario']."'
--				,`fechaRecotizador3` = '".date('Y-m-d H:i:s')."'
--				,`usuarioRecotizador3` = '".$_SESSION['WebDreTacticaWeb2']['Usuario']."'
			Where
				`idInterno` = '$idInternoRespuesta'
							  ";
		DreQueryDB($sqlUpdateRespuesta);

		$return = "../actividadesDetalle.php?recId=".$recId."&muestra=seguimiento#Seguimiento";
	break;
}
/*<-- Carga de Imagenes -->*/
	include("../includes/agregarActividades_AddImagenes.php");
/*<-- Carga de Imagenes -->*/

/*
// --Envio  de Correo-- //
$sqlResponsables = "Select * From `actividades` Where `recId` = '$recId'";
	$resResponsas = DreQueryDB($sqlResponsables);
		$rowResposables = mysql_fetch_assoc($resResponsas);	
			$usuarioResponsableCreacion = $rowResposables['usuarioCreacion'];

$sqlResponsableUsuarioEmail = "Select * From `usuarios` Where `VALOR` = '$usuarioResponsableCreacion'";
	$resResponsableUsuarioEmail = DreQueryDB($sqlResponsableUsuarioEmail);
		$rowResposableUsuarioEmail = mysql_fetch_assoc($resResponsableUsuarioEmail);	
			$responsableEmailCreacion =  $rowResposableUsuarioEmail['Email'];
//email a donde enviamos el correo
$email_to = $responsableEmail; // Correo al que mandamos
$cc_mail = $responsableEmailCreacion; // Correo al que se copia en envio COBRANZA
$bcc_mail = "juanjose@dre-learning.com";  // Correo al que se copia oculto el envio 

//envio de correo con los datos del nuevo cliente
$email_subject = "Termino Actividad CAPSYS Agente Capital";
$email_message = "";

$headers = "From: Sistema CRM Web <sistemas@agentecapital.com> \r\n";
$headers .= "CC:".$cc_mail." \r\n";
$headers .= "BCC:".$bcc_mail; 
$semi_rand = md5(time());  
$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";  
//ENCABEZADOS MIME
$headers .= "\nMIME-Version: 1.0\n" .  
            "Content-Type: multipart/mixed;\n" .  
            " boundary=\"{$mime_boundary}\""; 

//CONSTRUCCION DEL MENSAJE
$message = "";
	// Encabezado del correo
        $message = $message . "<strong>Informacion de la Actividad TERMINADA</strong><br>";
		$message = $message . "<strong>Actividad: </strong>".$rowTitulo['actividad']."  ($recId)"."<br>"; 
		$message = $message . "<strong>Fecha Termino Actividad: </strong>".$fechaTermino."<br>"; 

        $message = $message . "<hr>";
		
	// Resultados de la encuesta
        $message = $message . "<br />";
        $message = $message . "<strong>Responsable:</strong><br />"; // Datos Responsable
		$message = $message . "&nbsp;&nbsp;&nbsp;<strong>Nombre:</strong>&nbsp;".$rowResponsableCorreo['NOMBRE']."<br />";
		$message = $message . "<strong>Resultado:</strong><br />"; // Resultado
		$message = $message . "&nbsp;&nbsp;&nbsp;".$Resultado."<br />";
		$message = $message . "<strong>Comentario Resultado:</strong><br />"; // Comentario Resultado
		$message = $message . "&nbsp;&nbsp;&nbsp;".$comenResultado."<br /><br />";
		$message = $message . "<hr><br />";

$email_message.=$message;

//CONTINUA CONSTRUCCION MULTI-PART
$email_message .= "\n\n" .  
                "--{$mime_boundary}\n" .  
                "Content-Type:text/html; charset=\"iso-8859-1\"\n" .  
               "Content-Transfer-Encoding: 7bit\n\n" .  
$email_message .= "\n\n";  



// Linea de envio del correo
$correo = @mail($email_to, $email_subject, $email_message, $headers);  
// --Envio  de Correo-- //	
*/

	header("Location: $return");
	
//echo "<pre>";
	//print_r($_REQUEST);
	//echo "<br>";
	//echo $sqlInsertActividadEmision;
//	echo $sqlConsultaCotizacion;
//	echo $sqlAgregarActividadInformacion;
//** echo $sqlAgregarActividadRecotizacion;
//echo $sqlUpdateRespuesta;
	//print_r($_SESSION);
//echo "</pre>";
?>