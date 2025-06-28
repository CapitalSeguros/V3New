<?php
session_start();
extract($_REQUEST);
if(	$seccion != "index"){
	if(!isset($_SESSION['WebDreTacticaWeb2'])){ header("Location: index.php"); }
	if(!isset($_SESSION['WebDreTacticaWeb2']['Usuario'])){ header("Location: index.php"); }
}
include('../config/funcionesDre.php');
	$conexion = DreConectarDB();

// ActividadCancelada
if($_REQUEST['tipoGuardar'] == 'ActividadCancelada'){
	$usuarioCreacion = mysql_result(DreQueryDB("Select `usuarioCreacion` From `actividades` Where `recId` = '$recId' And `inicio` = '0'"),0);
	$sqlMandarCancelacion = "
		Update
			`actividades`
		Set
			`prioridad` = '5'
			, `fechaCancela` = '".date('Y-m-d H:i:s')."'
			, `usuarioCancela` = '$usuarioCancela'
 			, `usuarioBolita` = '$usuarioCreacion'
		Where
			`recId` = '$recId'
			And
			`inicio` = '0';
						   ";
//--> Agregar Envio de Correo		
	DreQueryDB($sqlMandarCancelacion);

	$return = "../actividadesDetalle.php?recId=".$recId;  //."&muestra=DocumentosActividad#DocumentosActividad";

	header('Location: '.$return);
}


// ActividadCotizada
if($_REQUEST['tipoGuardar'] == 'ActividadCotizada'){
	$usuarioCreacion = mysql_result(DreQueryDB("Select `usuarioCreacion` From `actividades` Where `recId` = '$recId' And `inicio` = '0'"),0);
	$sqlMandarRenovacion = "
		Update
			`actividades`
		Set
			`prioridad` = '1'
			, `fechaCotizacion` = '".date('Y-m-d H:i:s')."'
			, `usuarioCotizador` = '$usuarioCotiza'
 			, `usuarioBolita` = '$usuarioCreacion'
		Where
			`recId` = '$recId'
			And
			`inicio` = '0';
						   ";
//--> Agregar Envio de Correo		
	DreQueryDB($sqlMandarRenovacion);

	$return = "../actividadesDetalle.php?recId=".$recId."&muestra=DocumentosActividad#DocumentosActividad";

	header('Location: '.$return);
}

// ActividadTomada
if($_REQUEST['tipoGuardar'] == 'ActividadTomada'){
	$sqlConsultamosActividad = "
		Select * From
			`actividades`
		Where
			`recId`  = '$recId'
			And
			`inicio` = '0'
							   ";
	$resConsultamosActividad = DreQueryDB($sqlConsultamosActividad);
	$rowConsultamosActividad = mysql_fetch_assoc($resConsultamosActividad);

	if($rowConsultamosActividad['usuarioBloqueo'] == ""){
		$sqlActividadTomada = "
			Update
				`actividades`
			Set
				`fechaTomada` = '".date('Y-m-d H:i:s')."'
				,`usuarioBloqueo` = '$usuarioCotiza'
				, `usuarioBolita` = '$usuarioCotiza'
			Where
				`recId` = '$recId'
				And
				`inicio` = '0';
							  ";
		DreQueryDB($sqlActividadTomada);
	
		$txtReturn = "Actividad Tomada !!!";
		$return = "../actividadesDetalle.php?recId=".$recId;
	} else {
		$txtReturn = "Lo Sentimos la Actividad ha Sido Tomada por Otro Usuario !!!";
		$return = "../actividades.php";
	}
	?>
    <script>
		alert('<? echo $txtReturn; ?>');
		window.open('<? echo $return; ?>','_self');
	</script>
    <?
}
	
// ActividadSoltada
if($_REQUEST['tipoGuardar'] == 'ActividadSoltada'){
	$usuarioResponsableRamo = mysql_result(DreQueryDB("Select `usuario` From `actividades` Where `recId` = '$recId' And `inicio` = '0'"),0);
	$sqlActividadTomada = "
		Update
			`actividades`
		Set
			`fechaTomada` = ''
			,`usuarioBloqueo` = ''
			, `usuarioBolita` = '$usuarioResponsableRamo'
		Where
			`recId` = '$recId'
			And
			`inicio` = '0';
						   ";

	DreQueryDB($sqlActividadTomada);

//	$return = "../actividadesDetalle.php?recId=".$recId."&muestra=Seguimiento#Seguimiento";
	$return = "../actividadesDetalle.php?recId=".$recId;
	header('Location: '.$return);
}

// ActividadLiberada
if($_REQUEST['tipoGuardar'] == 'ActividadLiberada'){
	$usuarioResponsableRamo = mysql_result(DreQueryDB("Select `usuario` From `actividades` Where `recId` = '$recId' And `inicio` = '0'"),0);
	$sqlActividadTomada = "
		Update
			`actividades`
		Set
			`fechaTomada` = ''
			,`usuarioBloqueo` = ''
			, `usuarioBolita` = '$usuarioResponsableRamo'
		Where
			`recId` = '$recId'
			And
			`inicio` = '0';
						   ";

	DreQueryDB($sqlActividadTomada);

//	$return = "../actividadesDetalle.php?recId=".$recId."&muestra=Seguimiento#Seguimiento";
	$return = "../actividadesDetalle.php?recId=".$recId;
	header('Location: '.$return);
}

// ViaOficina
if($_REQUEST['tipoGuardar'] == 'ViaOficina'){
	$usuarioResponsableRamo = mysql_result(DreQueryDB("Select `usuario` From `actividades` Where `recId` = '$recId' And `inicio` = '0'"),0);
	$sqlActividadViaOficina = "
		Update
			`actividades`
		Set
			 `fechaViaOficina` = '".date('Y-m-d H:i:s')."'
			, `usuarioViaOficina` = '$Usuario'
			, `usuarioBolita` = '$usuarioResponsableRamo'
			, `prioridad` = '3'
		Where
			`recId` = '$recId'
			And
			`inicio` = '0';
						   ";
	DreQueryDB($sqlActividadViaOficina);

//	$return = "../actividadesDetalle.php?recId=".$recId."&muestra=Formularios#Formularios";
	$return = "../actividadesDetalle.php?recId=".$recId;
	
	header('Location: '.$return);
}

// MandarRenovar
if($_REQUEST['tipoGuardar'] == 'MandarRenovar'){
	$sqlMandarRenovacion = "
		Update
			`actividades`
		Set
			`usuario` = '0000028974'
			,`usuarioBolita` = '0000028974' 
		Where
			`recId` = '$recId'
			And
			`inicio` = '0';
						   ";
	DreQueryDB($sqlMandarRenovacion);

	$return = "../actividadesDetalle.php?recId=".$recId."&muestra=Formularios#Formularios";
	
	header('Location: '.$return);
}

// Asignar
if($_REQUEST['tipoGuardar'] == 'Asignar'){
	$sqlMandarRenovacion = "
		Update
			`actividades`
		Set
			`usuario` = '0000522656'
			,`usuarioBolita` = '0000522656' 
		Where
			`recId` = '$recId'
			And
			`inicio` = '0';
						   ";
	DreQueryDB($sqlMandarRenovacion);

	$return = "../actividadesDetalle.php?recId=".$recId."&muestra=Formularios#Formularios";
	
	header('Location: '.$return);
}

// quitarActividad
if($_REQUEST['tipoGuardar'] == 'quitarActividad'){
	$fechaTermino = date('Y-m-d H:i:s');
	$sqlQuitarActividad = "
		Update 
			`actividades`
		Set
			`fin` = '1'
			,`Resultado` = 'Quitada'
			,`comenResultado` = 'Termino Expres'
			,`fechaTermino` = '$fechaTermino'
		Where 
			`inicio` = '0'
			And
			`recId` = '$recId'
						  ";
	DreQueryDB($sqlQuitarActividad);
	
	?>
    <script>
		alert('Actividad Terminada !!!');
		window.open('../actividades.php', '_self');
	</script>
    <?php
}

// ActividadEmitida
if($_REQUEST['tipoGuardar'] == 'ActividadEmitida'){
	$usuarioCreacion = mysql_result(DreQueryDB("Select `usuarioCreacion` From `actividades` Where `recId` = '$recId' And `inicio` = '0'"),0);
	$sqlMandarRenovacion = "
		Update
			`actividades`
		Set
			`prioridad` = '4'
			, `fechaEmite` = '".date('Y-m-d H:i:s')."'
			, `usuarioEmite` = '$usuarioEmite'
 			, `usuarioBolita` = '$usuarioCreacion'
			, `sincLocal` = '0'
		Where
			`recId` = '$recId'
			And
			`inicio` = '0';
						   ";
//--> Agregar Envio de Correo		
	DreQueryDB($sqlMandarRenovacion);

	$return = "../actividadesDetalle.php?recId=".$recId."&muestra=DocumentosActividad#DocumentosActividad";

	header('Location: '.$return);
}

// TipoGuardar finalizarActividad
if($_REQUEST['tipoGuardar'] == 'finalizarActividad'){
	include('guardar.finalizarActividad.php');
}


// TipoGuardar Actividad
if($_REQUEST['tipoGuardar'] == 'Actividad'){

	$fechaTermino = date('Y-m-d H:i:s');
	$sqlTerminarActividad = "
		Update `actividades`
			Set
				`fin` = '1'
				,`Resultado` = '$Resultado'
				,`comenResultado` = '$comenResultado'
				,`fechaTermino` = '$fechaTermino'
			Where `idInterno` = '$idInterno'
							";
	DreQueryDB($sqlTerminarActividad);
	

if($Resultado != "cancelar"){
	$sqlActividadTerminada = "Select *, DATE_ADD(Now(),INTERVAL 0 DAY) As `fechaProgramadaNew`, DATE_ADD(Now(),INTERVAL 0 DAY) As `fechaProgramadaNew2` From `actividades` Where `idInterno` = '$idInterno'";
	$resActividadTerminada = DreQueryDB($sqlActividadTerminada);
	$rowActividadTerminada = mysql_fetch_assoc($resActividadTerminada);
	
	$sqlIdInternoMd5 = "Select Min(`idInterno`) As `idInternoMin` From `actividades` Where `recId` = '$rowActividadTerminada[recId]'";
	$idInternoMd5 =	md5(mysql_result(DreQueryDB($sqlIdInternoMd5),0));
	
	// Creamos la Actividad del Ejecutivo
	$sqlUsuariosEjecutivosRamo = 	"
		Select * From
			`configdre` 
		Where
				`parametro` =  'tipoRamo'
			And
				`titulo` = '".urldecode($rowActividadTerminada['ramoInterno'])."'
									";
	$resUsuariosEjecutivosRamo = DreQueryDB($sqlUsuariosEjecutivosRamo);
	$rowUsuariosEjecutivosRamo = mysql_fetch_assoc($resUsuariosEjecutivosRamo);
	
	$sqlCountRecId = "Select Count(*) As `NumeroActividades` From `actividades` Where `recId` = '$rowActividadTerminada[recId]'";
	$resCountRecId = DreQueryDB($sqlCountRecId);
	$rowCountRecId = mysql_fetch_assoc($resCountRecId);
	
	$NumeroActividades = $rowCountRecId['NumeroActividades'];
	
	// verificamos que es

// --------------  0-3
	if(
		(
			$rowActividadTerminada['actividadInterno'] == "Cotizaci%F3n"
			||
			$rowActividadTerminada['actividadInterno'] == "Emisi%F3n"
			||
			$rowActividadTerminada['actividadInterno'] == "Programaci%F3n+de+pago"
			||
			$rowActividadTerminada['actividadInterno'] == "Endoso"
			||
			$rowActividadTerminada['actividadInterno'] == "Cancelacion"
		) 
		&& 
		$rowActividadTerminada['inicio'] == "0" && $NumeroActividades < 3
	   )
	   {
		$usuarioEjecutivo = $rowUsuariosEjecutivosRamo['idUsuario'];
		
		$sqlInsertActividadHijoCotizacion = "		
			Insert Into `actividades`
			(
				`recId`
				,`idRef`
				,`tipo`
				,`inicio`
				,`fin`
				,`referencia`
				,`actividad`
				,`ubicacion`
				,`prioridad`
				,`usuario`
				,`usuarioCreacion`
				,`fechaCreacion`
				,`fechaProgramada`
				,`actividadInterno`
				,`ramoInterno`
			)
			Values
			(
				'$rowActividadTerminada[recId]'
				,'$rowActividadTerminada[idRef]'
				,'$rowActividadTerminada[tipo]'
				,'1'
				,'0'
				,'$rowActividadTerminada[referencia]'
				,'$rowActividadTerminada[actividad]'
				,'$rowActividadTerminada[ubicacion]'
				,'$rowActividadTerminada[prioridad]'
				,'$usuarioEjecutivo'
				,'$rowActividadTerminada[usuarioCreacion]'
				,'".date('Y-m-d H:i:s')."'
				,'$rowActividadTerminada[fechaProgramadaNew]'
				,'$rowActividadTerminada[actividadInterno]'
				,'$rowActividadTerminada[ramoInterno]'
			)
											";
		DreQueryDB($sqlInsertActividadHijoCotizacion);
		$idInterno = mysql_insert_id();
		$sqlUpdateIdInternoMd5 = 	"
			Update 
				`actividades`
			Set
				`idInternoMd5` = '".md5($idInterno)."'
			Where 
				`idInterno` = '$idInterno'
									";
		DreQueryDB($sqlUpdateIdInternoMd5);
		}

// --------------  1-3
	if(
		(
			$rowActividadTerminada['actividadInterno'] == "Cotizaci%F3n" 
			|| 
			$rowActividadTerminada['actividadInterno'] == "Emisi%F3n"
			||
			$rowActividadTerminada['actividadInterno'] == "Programaci%F3n+de+pago"
			||
			$rowActividadTerminada['actividadInterno'] == "Endoso"
			||
			$rowActividadTerminada['actividadInterno'] == "Cancelacion"
		) 
		&& 
		$rowActividadTerminada['inicio'] == "1" && $NumeroActividades < 3
	  )
		{
		$usuarioEjecutivo = $rowUsuariosEjecutivosRamo['idUsuario'];
		
		$sqlInsertActividadHijoCotizacion = "		
			Insert Into `actividades`
			(
				`recId`
				,`idRef`
				,`tipo`
				,`inicio`
				,`fin`
				,`referencia`
				,`actividad`
				,`ubicacion`
				,`prioridad`
				,`usuario`
				,`usuarioCreacion`
				,`fechaCreacion`
				,`fechaProgramada`
				,`actividadInterno`
				,`ramoInterno`
			)
			Values
			(
				'$rowActividadTerminada[recId]'
				,'$rowActividadTerminada[idRef]'
				,'$rowActividadTerminada[tipo]'
				,'0'
				,'0'
				,'<strong>Enviar Cotizacional Cliente --> </strong>".$rowActividadTerminada[referencia]."'
				,'$rowActividadTerminada[actividad]'
				,'$rowActividadTerminada[ubicacion]'
				,'$rowActividadTerminada[prioridad]'
				,'$rowActividadTerminada[usuarioCreacion]'
				,'$rowActividadTerminada[usuarioCreacion]'
				,'".date('Y-m-d H:i:s')."'
				,'$rowActividadTerminada[fechaProgramadaNew2]'
				,'$rowActividadTerminada[actividadInterno]'
				,'$rowActividadTerminada[ramoInterno]'
			)
											";
		DreQueryDB($sqlInsertActividadHijoCotizacion);
		$idInterno = mysql_insert_id();
		$sqlUpdateIdInternoMd5 = 	"
			Update 
				`actividades`
			Set
				`idInternoMd5` = '".md5($idInterno)."'
			Where 
				`idInterno` = '$idInterno'
									";
		DreQueryDB($sqlUpdateIdInternoMd5);
		}

// -------------- Cuando son retrabajos
	if(
		$rowActividadTerminada['cantidadVecesTrasladada'] == '1'
	)
		{
		$sqlInsertActividadHijoCotizacion = "		
			Insert Into `actividades`
			(
				`recId`
				,`idRef`
				,`tipo`
				,`inicio`
				,`fin`
				,`referencia`
				,`actividad`
				,`ubicacion`
				,`prioridad`
				,`usuario`
				,`usuarioCreacion`
				,`fechaCreacion`
				,`fechaProgramada`
				,`actividadInterno`
				,`ramoInterno`
			)
			Values
			(
				'$rowActividadTerminada[recId]'
				,'$rowActividadTerminada[idRef]'
				,'$rowActividadTerminada[tipo]'
				,'1'
				,'0'
				,'$rowActividadTerminada[referencia]'
				,'$rowActividadTerminada[actividad]'
				,'$rowActividadTerminada[ubicacion]'
				,'$rowActividadTerminada[prioridad]'
				,'$rowActividadTerminada[usuarioCreacion]'
				,'$rowActividadTerminada[usuarioCreacion]'
				,'".date('Y-m-d H:i:s')."'
				,'$rowActividadTerminada[fechaProgramadaNew2]'
				,'$rowActividadTerminada[actividadInterno]'
				,'$rowActividadTerminada[ramoInterno]'
			)
											";
		DreQueryDB($sqlInsertActividadHijoCotizacion);
		$idInterno = mysql_insert_id();
		$sqlUpdateIdInternoMd5 = 	"
			Update 
				`actividades`
			Set
				`idInternoMd5` = '".md5($idInterno)."'
			Where 
				`idInterno` = '$idInterno'
									";
		DreQueryDB($sqlUpdateIdInternoMd5);
		}
// --------------
}

	// - > Envio  Correo Notificacion Todos los involucrados	
		$resDatosResponsableCorreo = DreQueryDB("Select * From `usuarios` Where `VALOR` = '$rowActividadTerminada[usuario]'");
		$rowDatosResponsableCorreo = mysql_fetch_assoc($resDatosResponsableCorreo);
			$sqlResponsableCorreo = "Select * From `usuarios` Where `VALOR` = '$rowDatosResponsableCorreo[VALOR]'";
			$resResponsableCorreo = DreQueryDB($sqlResponsableCorreo);
			$rowResponsableCorreo = mysql_fetch_assoc($resResponsableCorreo);
		
		$resDatosRamoCorreo = DreQueryDB("Select * From `configdre` Where `titulo` = '$rowActividadTerminada[ramoInterno]'");
		$rowDatosRamoCorreo = mysql_fetch_assoc($resDatosRamoCorreo);
		
// --Envio  de Correo-- //

//email a donde enviamos el correo
$email_to = $rowResponsableCorreo['Email'];; // Correo al que mandamos
$cc_mail = $rowDatosRamoCorreo['email']; // Correo al que se copia en envio COBRANZA
$bcc_mail = "juanjose@dre-learning.com";  // Correo al que se copia oculto el envio 

//envio de correo con los datos del nuevo cliente
$email_subject = "Termino Actividad Tactica Web Agente Capital";
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
		$message = $message . "<strong>Actividad: </strong>".$rowActividadTerminada['actividad']."<br>"; 
		$message = $message . "<strong>Fecha Termino Actividad: </strong>".date('d-m-Y')."<br>"; 

        $message = $message . "<hr>";
		
	// Resultados de la encuesta
        $message = $message . "<br />";
        $message = $message . "<strong>Datos Empresa:</strong><br />"; // Datos Empresa
		$resDatosEmpresaCorreo = DreQueryDB("Select * From `empresas` Where `CLAVE` = '$rowActividadTerminada[idRef]'");
		$rowDatosEmpresaCorreo = mysql_fetch_assoc($resDatosEmpresaCorreo);
		$message = $message . "&nbsp;&nbsp;&nbsp;<strong>Clave:</strong>&nbsp;".$rowDatosEmpresaCorreo['CLAVE']."<br />";
		$message = $message . "&nbsp;&nbsp;&nbsp;<strong>Nombre:</strong>&nbsp;".$rowDatosEmpresaCorreo['RAZON_SOCIAL']."<br />";
		
        $message = $message . "<strong>Datos Contacto:</strong><br />"; // Datos Contacto
		$resDatosContactoCorreo = DreQueryDB("Select * From `contactos` Where `CLAVE` = '$rowActividadTerminada[idRef]' And `TIPO` = '$rowActividadTerminada[tipo]'");
		$rowDatosContactoCorreo = mysql_fetch_assoc($resDatosContactoCorreo);
		$message = $message . "&nbsp;&nbsp;&nbsp;<strong>Nombre:</strong>&nbsp;".$rowDatosContactoCorreo['NOMBRE']."<br />";
		$message = $message . "&nbsp;&nbsp;&nbsp;<strong>E-Mail:</strong>&nbsp;".$rowDatosContactoCorreo['EMAIL']."<br />";
		
        $message = $message . "<strong>Responsable:</strong><br />"; // Datos Responsable
		$message = $message . "&nbsp;&nbsp;&nbsp;<strong>Nombre:</strong>&nbsp;".$rowDatosResponsableCorreo['NOMBRE']."&nbsp;(".$rowDatosResponsableCorreo['TIPO'].")<br />";
        $message = $message . "<strong>Ubicacion:</strong><br />"; // Ubicacion
		$message = $message . "&nbsp;&nbsp;&nbsp;".$rowActividadTerminada['ubicacion']."<br />";
		$message = $message . "<strong>Referencia:</strong><br />"; // Referencia
		$message = $message . "&nbsp;&nbsp;&nbsp;".$rowActividadTerminada['referencia']."<br />";
		$message = $message . "<strong>Resultado:</strong><br />"; // Resultado
		$message = $message . "&nbsp;&nbsp;&nbsp;".$rowActividadTerminada['Resultado']."<br />";
		$message = $message . "<strong>Comentario Resultado:</strong><br />"; // Comentario Resultado
		$message = $message . "&nbsp;&nbsp;&nbsp;".$rowActividadTerminada['comenResultado']."<br /><br />";
		$message = $message . "<hr><br />";
		$message = $message . "<strong>Formulario Actividad:</strong><br /><br />"; // Formulario de Actividad
		$message = $message . "<a href='http://agentecapital.com/Capsys/formularioActividadWeb.php?idInterno=$idInternoMd5' style='text-decoration:none; color:#000000;' title='Clic Formulario'>";
		$message = $message . "<img src='http://agentecapital.com/Capsys/img/edit.png' width='16' height='16' border='0' />";
		$message = $message . "&nbsp;<strong>Formulario</strong>";
		$message = $message . "</a>";
		$message = $message . "<hr><br />";
		$message = $message . "<strong>Documentos Actividad:</strong><br /><br />"; // Documentos Actividad
		$message = $message . "<a href='http://agentecapital.com/Capsys/documentosActividadWeb.php?idInterno=$idInternoMd5' style='text-decoration:none; color:#000000;' title='Clic Documentos'>";
		$message = $message . "<img src='http://agentecapital.com/Capsys/img/application.png' width='16' height='16' border='0' />";
		$message = $message . "&nbsp;<strong>Documentos</strong>";
		$message = $message . "</a>";


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
	
		$return = "../contactos.php?idContacto=$idContacto";
		header("Location: $return");
	
	}

// Guardar formularios

//*****NUEVAS FUNCIONES
// Guardar formularios de incendios edificios contenidos
if($_REQUEST['tipoGuardar'] == 'formulariosIncendios'){
//$recId = mysql_result(DreQueryDB("Select `recId` From `actividades` Where `idInterno` = '$idInterno'"),0);
		if(mysql_num_rows(DreQueryDB("Select * From `actividades_formularios` Where `idActividad` = '$idActividad' And `ramoInterno` = '$ramoInterno'"))){
		$sqlUpdateFormularioLineasPersonales = 	"
			Update `actividades_formularios`
				Set
					`formIncendio` = '1'
					, `dinero_edificio_incendio` = '$dinero_edificio_incendio'
					,`dinero_contenido_incendio` = '$dinero_contenido_incendio'
					,`mobiliario_equipo_incendio` = '$mobiliario_equipo_incendio'
					,`maquinaria_equipo_operacion` = '$maquinaria_equipo_operacion'
					,`existencia` = '$existencia'
					,`explosion` = '$explosion'
					,`naves_aereas_incendios` = '$naves_aereas_incendios'
					,`huelgas_alborotos` = '$huelgas_alborotos'
					,`cobertura_extension` = '$cobertura_extension'
					,`dinero_escombro_incendio` = '$dinero_escombro_incendio'
					,`edificion_terremoto_volcan_incendio` = '$edificion_terremoto_volcan_incendio'
					,`bienes_bajo_convenio` = '$bienes_bajo_convenio'
					,`derrame_pci` = '$derrame_pci'
					,`valor_reposicion` = '$valor_reposicion'
					,`incisos_conocidos` = '$incisos_conocidos'
					,`incisos_noConocidos_nuevos` = '$incisos_noConocidos_nuevos'
					,`deducible_incendio` = '$deducible_incendio'
					,`coaseguro_incendio` = '$coaseguro_incendio'
					,`ajuste_incendio` = '$ajuste_incendio'
				Where
					`idActividad` = '$idActividad' And `ramoInterno` = '$ramoInterno'
								";	
		DreQueryDB($sqlUpdateFormularioLineasPersonales);
		} else {
		$sqlInsertFormularioLineasPersonales = 	"
			Insert Into `actividades_formularios`
				(
					`formIncendio`
 					,`dinero_edificio_incendio`
					,`dinero_contenido_incendio`
					,`mobiliario_equipo_incendio`
					,`maquinaria_equipo_operacion`
					,`existencia`
					,`explosion`
					,`naves_aereas_incendios`
					,`huelgas_alborotos`
					,`cobertura_extension`
					,`dinero_escombro_incendio`
					,`edificion_terremoto_volcan_incendio`
					,`bienes_bajo_convenio`
					,`derrame_pci`
					,`valor_reposicion`
					,`incisos_conocidos`
					,`incisos_noConocidos_nuevos`
					,`deducible_incendio`
					,`coaseguro_incendio`	
					,`ajuste_incendio`
				)
			Values
				(
					'1'
 					,'$dinero_edificio_incendio'
					,'$dinero_contenido_incendio'
					,'$mobiliario_equipo_incendio'
					,'$maquinaria_equipo_operacion'
					,'$existencia'
					,'$explosion'
					,'$naves_aereas_incendios'
					,'$huelgas_alborotos'
					,'$cobertura_extension'
					,'$dinero_escombro_incendio'
					,'$edificion_terremoto_volcan_incendio'
					,'$bienes_bajo_convenio'
					,'$derrame_pci'
					,'$valor_reposicion'
					,'$incisos_conocidos'
					,'$incisos_noConocidos_nuevos'
					,'$deducible_incendio'
					,'$coaseguro_incendio'
					,'$ajuste_incendio'
				)
								";
		DreQueryDB($sqlInsertFormularioLineasPersonales);
		}
	?>
    <script>
		alert('Formulario de Incendio, Edificio y Contenido \n Guardado con Exito !!!');
		window.close();
		window.opener.document.location.reload();
	</script>
    <?php
}

//guardar formularios de calderas
if($_REQUEST['tipoGuardar'] == 'formulariosCaldera'){
//$recId = mysql_result(DreQueryDB("Select `recId` From `actividades` Where `idInterno` = '$idInterno'"),0);
		if(mysql_num_rows(DreQueryDB("Select * From `actividades_formularios` Where `idActividad` = '$idActividad' And `ramoInterno` = '$ramoInterno'"))){
		$sqlUpdateFormularioLineasPersonales = 	"
			Update `actividades_formularios`
				Set
					`formCaldera` = '1'
					, `cotizacion_efectuar` = '$cotizacionEfectuar'
					,`edad_promedioMaquinaria` = '$edad_promedioMaquinaria'
					,`suma_aseguradaEquipo` = '$suma_aseguradaEquipo'
					,`cobertura_adicional` = '$cobertura_adicional'
					,`derrame_contenido` = '$derrame_contenido'
					,`gastos_extras` = '$gastos_extras'
					,`gastos_fleteAereo` = '$gastos_fleteAereo'
					,`periodo_inactividad` = '$periodo_inactividad'
					,`ajuste_inflacionario` = '$ajuste_inflacionario'
				Where
					`idActividad` = '$idActividad' And `ramoInterno` = '$ramoInterno'
								";	
		DreQueryDB($sqlUpdateFormularioLineasPersonales);
		} else {
		$sqlInsertFormularioLineasPersonales = 	"
			Insert Into `actividades_formularios`
				(
					`formCaldera`
					, `cotizacion_efectuar`
					,`edad_promedioMaquinaria`
					,`suma_aseguradaEquipo`
					,`cobertura_adicional`
					,`derrame_contenido`
					,`gastos_extras`
					,`gastos_fleteAereo`
					,`periodo_inactividad`
					,`ajuste_inflacionario`
				)
			Values
				(
					'1'
					,'$cotizacionEfectuar'
					,'$edad_promedioMaquinaria'
					,'$suma_aseguradaEquipo'
					,'$cobertura_adicional'
					,'$derrame_contenido'
					,'$gastos_extras'
					,'$gastos_fleteAereo'
					,'$periodo_inactividad'
					,'$ajuste_inflacionario'
				)
								";
		DreQueryDB($sqlInsertFormularioLineasPersonales);
		}
	?>
    <script>
		alert('Formulario de Calderas y Recipientes \n Guardado con Exito !!!');
		window.close();
		window.opener.document.location.reload();
	</script>
    <?php
}
//guardar formularios de Responsabilidad
if($_REQUEST['tipoGuardar'] == 'formulariosResponsabilidad'){
//$recId = mysql_result(DreQueryDB("Select `recId` From `actividades` Where `idInterno` = '$idInterno'"),0);
		if(mysql_num_rows(DreQueryDB("Select * From `actividades_formularios` Where `idActividad` = '$idActividad' And `ramoInterno` = '$ramoInterno'"))){
		$sqlUpdateFormularioLineasPersonales = 	"
			Update `actividades_formularios`
				Set
					`formResponsabilidad` = '1'
					, `coberturas_solicitadas` = '$coberturas_solicitadas'
					,`coberturas_adicionales_responsabilidad` = '$coberturas_adicionales_responsabilidad'
					,`procutos_trabajosTerminados` = '$procutos_trabajosTerminados'
					,`carga_descarga` = '$carga_descarga'
					,`asumida` = '$asumida'
					,`contratista_independiente` = '$contratista_independiente'
					,`explosivos` = '$explosivos'
					,`accesorios` = '$accesorios'
					,`limite_respCivil` = '$limite_respCivil'
					,`arrendatario` = '$arrendatario'
					,`cobertura_arrendatario` = '$cobertura_arrendatario'
					,`estacionamiento_garaje` = '$estacionamiento_garaje'
					,`acomodadores` = '$acomodadores'
					,`sin_acomodadores` = '$sin_acomodadores'
					,`no_cajones` = '$no_cajones'
					,`sublimiteCoberturaGaraje` = '$sublimiteCoberturaGaraje'
					,`sublimiteUnidad` = '$sublimiteUnidad'
				Where
					`idActividad` = '$idActividad' And `ramoInterno` = '$ramoInterno'
								";	
		DreQueryDB($sqlUpdateFormularioLineasPersonales);
		} else {
		$sqlInsertFormularioLineasPersonales = 	"
			Insert Into `actividades_formularios`
				(
					`formResponsabilidad`
					, `coberturas_solicitadas`
					,`coberturas_adicionales_responsabilidad`
					,`procutos_trabajosTerminados`
					,`carga_descarga`
					,`asumida`
					,`contratista_independiente`
					,`explosivos`
					,`accesorios`
					,`limite_respCivil`
					,`arrendatario`
					,`cobertura_arrendatario`
					,`estacionamiento_garaje`
					,`acomodadores`
					,`sin_acomodadores`
					,`no_cajones`
					,`sublimiteCoberturaGaraje`
					,`sublimiteUnidad`
				)
			Values
				(
					'1'
					,'$coberturas_solicitadas'
					,'$coberturas_adicionales_responsabilidad'
					,'$procutos_trabajosTerminados'
					,'$carga_descarga'
					,'$asumida'
					,'$contratista_independiente'
					,'$explosivos'
					,'$accesorios'
					,'$limite_respCivil'
					,'$arrendatario'
					,'$cobertura_arrendatario'
					,'$estacionamiento_garaje'
					,'$acomodadores'
					,'$sin_acomodadores'
					,'$no_cajones'
					,'$sublimiteCoberturaGaraje'
					,'$sublimiteUnidad'
				)
								";
		DreQueryDB($sqlInsertFormularioLineasPersonales);
		}
	?>
    <script>
		alert('Formulario de Responsabilidad Civil \n Guardado con Exito !!!');
		window.close();
		window.opener.document.location.reload();
	</script>
    <?php
}
//guardar formularios de perdidas secuenciales
if($_REQUEST['tipoGuardar'] == 'formulariosPerdida'){
//$recId = mysql_result(DreQueryDB("Select `recId` From `actividades` Where `idInterno` = '$idInterno'"),0);
		if(mysql_num_rows(DreQueryDB("Select * From `actividades_formularios` Where `idActividad` = '$idActividad' And `ramoInterno` = '$ramoInterno'"))){
		$sqlUpdateFormularioLineasPersonales = 	"
			Update `actividades_formularios`
				Set
					`formPerdida` = '1'
					, `cotizacion` = '$cotizacion'
					,`perdidas_rentas` = '$perdidas_rentas'
					,`gastos_extraordinarios_perdida` = '$gastos_extraordinarios_perdida'
			,`reduccion_ingresos_interrupcion` = '$reduccion_ingresos_interrupcion'
					,`perdida_utilidades` = '$perdida_utilidades'
				,`ganancias_brutas_noRealizadas` = '$ganancias_brutas_noRealizadas'
			,`comerciales_plantasIndustriales` = '$comerciales_plantasIndustriales'
					,`seguro_contingente` = '$seguro_contingente'
					,`ajuste_inflacionario_perdida` = '$ajuste_inflacionario_perdida'
				Where
					`idActividad` = '$idActividad' And `ramoInterno` = '$ramoInterno'
								";	
		DreQueryDB($sqlUpdateFormularioLineasPersonales);
		} else {
		$sqlInsertFormularioLineasPersonales = 	"
			Insert Into `actividades_formularios`
				(
					`formPerdida`
					, `cotizacion`
					,`perdidas_rentas`
					,`gastos_extraordinarios_perdida`
					,`reduccion_ingresos_interrupcion`
					,`perdida_utilidades`
					,`ganancias_brutas_noRealizadas`
					,`comerciales_plantasIndustriales`
					,`seguro_contingente`
					,`ajuste_inflacionario_perdida`
				)
			Values
				(
					'1'
					,'$cotizacion'
					,'$perdidas_rentas'
					,'$gastos_extraordinarios_perdida'
					,'$reduccion_ingresos_interrupcion'
					,'$perdida_utilidades'
					,'$ganancias_brutas_noRealizadas'
					,'$comerciales_plantasIndustriales'
					,'$seguro_contingente'
					,'$ajuste_inflacionario_perdida'
				)
								";
		DreQueryDB($sqlInsertFormularioLineasPersonales);
		}
	?>
    <script>
		alert('Formulario de Perdida Secuencial \n Guardado con Exito !!!');
		window.close();
		window.opener.document.location.reload();
	</script>
    <?php
}
//guardar formularios de edificios
if($_REQUEST['tipoGuardar'] == 'formulariosEdificios'){
//$recId = mysql_result(DreQueryDB("Select `recId` From `actividades` Where `idInterno` = '$idInterno'"),0);
		if(mysql_num_rows(DreQueryDB("Select * From `actividades_formularios` Where `idActividad` = '$idActividad' And `ramoInterno` = '$ramoInterno'"))){
		$sqlUpdateFormularioLineasPersonales = 	"
			Update `actividades_formularios`
				Set
					`formEdificio` = '1'
					, `combustion_espontanea` = '$combustion_espontanea'
					,`tipo_producto` = '$tipo_producto'
					,`mercancias_productos` = '$mercancias_productos'
					,`precio_neto_venta` = '$precio_neto_venta'
					,`existencia_decalracion` = '$existencia_decalracion'
					,`naves_aereas` = '$naves_aereas'
					,`huelgas_alborotos_edificio` = '$huelgas_alborotos_edificio'
					,`planta_motriz_emergencias` = '$planta_motriz_emergencias'
				Where
					`idActividad` = '$idActividad' And `ramoInterno` = '$ramoInterno'
								";	
		DreQueryDB($sqlUpdateFormularioLineasPersonales);
		} else {
		$sqlInsertFormularioLineasPersonales = 	"
			Insert Into `actividades_formularios`
				(
					`formEdificio`
					, `combustion_espontanea`
					,`tipo_producto`
					,`mercancias_productos`
					,`precio_neto_venta`
					,`existencia_decalracion`
					,`naves_aereas`
					,`huelgas_alborotos_edificio`
					,`planta_motriz_emergencias`
				)
			Values
				(
					'1'
					,'$combustion_espontanea'
					,'$tipo_producto'
					,'$mercancias_productos'
					,'$precio_neto_venta'
					,'$existencia_decalracion'
					,'$naves_aereas'
					,'$huelgas_alborotos_edificio'
					,'$planta_motriz_emergencias'
				)
								";
		DreQueryDB($sqlInsertFormularioLineasPersonales);
		}
	?>
    <script>
		alert('Formulario de Edificios \n Guardado con Exito !!!');
		window.close();
		window.opener.document.location.reload();
	</script>
    <?php
}
//guardar formularios de cristales
if($_REQUEST['tipoGuardar'] == 'formulariosCristales'){
//$recId = mysql_result(DreQueryDB("Select `recId` From `actividades` Where `idInterno` = '$idInterno'"),0);
		if(mysql_num_rows(DreQueryDB("Select * From `actividades_formularios` Where `idActividad` = '$idActividad' And `ramoInterno` = '$ramoInterno'"))){
		$sqlUpdateFormularioLineasPersonales = 	"
			Update `actividades_formularios`
				Set
					`formCirstales` = '1'
					, `espesor_cristal` = '$espesor_cristal'
					,`rotura_cristal` = '$rotura_cristal'
					,`evaluo_cristal` = '$evaluo_cristal'
					,`decorado` = '$decorado'
					,`remocion` = '$remocion'
					,`cobertura_adicional_cristal` = '$cobertura_adicional_cristal'
					,`ajuste_inflacionario_cristal` = '$ajuste_inflacionario_cristal'
				Where
					`idActividad` = '$idActividad' And `ramoInterno` = '$ramoInterno'
								";	
		DreQueryDB($sqlUpdateFormularioLineasPersonales);
		} else {
		$sqlInsertFormularioLineasPersonales = 	"
			Insert Into `actividades_formularios`
				(
					`formCirstales`
					, `espesor_cristal`
					,`rotura_cristal`
					,`evaluo_cristal`
					,`decorado`
					,`remocion`
					,`cobertura_adicional_cristal`
					,`ajuste_inflacionario_cristal`
				)
			Values
				(
					'1'
					,'$espesor_cristal'
					,'$rotura_cristal'
					,'$evaluo_cristal'
					,'$decorado'
					,'$remocion'
					,'$cobertura_adicional_cristal'
					,'$ajuste_inflacionario_cristal'
				)
								";
		DreQueryDB($sqlInsertFormularioLineasPersonales);
		}
	?>
    <script>
		alert('Formulario de Robo de Cristales \n Guardado con Exito !!!');
		window.close();
		window.opener.document.location.reload();
	</script>
    <?php
}
//guardar formularios de anuncios
if($_REQUEST['tipoGuardar'] == 'formulariosAnuncios'){
//$recId = mysql_result(DreQueryDB("Select `recId` From `actividades` Where `idInterno` = '$idInterno'"),0);
		if(mysql_num_rows(DreQueryDB("Select * From `actividades_formularios` Where `idActividad` = '$idActividad' And `ramoInterno` = '$ramoInterno'"))){
		$sqlUpdateFormularioLineasPersonales = 	"
			Update `actividades_formularios`
				Set
					`formAnuncios` = '1'
					, `medidas` = '$medidas'
					,`material_construccion` = '$material_construccion'
					,`leyenda` = '$leyenda'
					,`suma_asegurada_anuncios` = '$suma_asegurada_anuncios'
					,`ajuste_inflacionario_anuncios` = '$ajuste_inflacionario_anuncios'
					,`tipo_alarma_anunios` = '$tipo_alarma_anunios'
					,`cuantos1` = '$cuantos1'
					, `circuito_cerrado` = '$circuito_cerrado'
					,`recoleccion_dinero` = '$recoleccion_dinero'
					,`puertas_protecccion` = '$puertas_protecccion'
					,`ventanas_protecion` = '$ventanas_protecion'
					,`tragaluces_proteccion` = '$tragaluces_proteccion'
					,`caja_seguridad` = '$caja_seguridad'
					,`policia_armado` = '$policia_armado'
					,`deposito_bancario` = '$deposito_bancario'
					,`velador` = '$velador'
					,`cuantos2` = '$cuantos2'
				Where
					`idActividad` = '$idActividad' And `ramoInterno` = '$ramoInterno'
								";	
		DreQueryDB($sqlUpdateFormularioLineasPersonales);
		} else {
		$sqlInsertFormularioLineasPersonales = 	"
			Insert Into `actividades_formularios`
				(
					`formAnuncios`
					, `medidas`
					,`material_construccion`
					,`leyenda`
					,`suma_asegurada_anuncios`
					,`ajuste_inflacionario_anuncios`
					,`tipo_alarma_anunios`
					,`cuantos1`
					, `circuito_cerrado`
					,`recoleccion_dinero`
					,`puertas_protecccion`
					,`ventanas_protecion`
					,`tragaluces_proteccion`
					,`caja_seguridad`
					,`policia_armado`
					,`deposito_bancario`
					,`velador`
					,`cuantos2`
				)
			Values
				(
					'1'
					,'$medidas'
					,'$material_construccion'
					,'$leyenda'
					,'$suma_asegurada_anuncios'
					,'$ajuste_inflacionario_anuncios'
					,'$tipo_alarma_anunios'
					,'$cuantos1'
					,'$circuito_cerrado'
					,'$recoleccion_dinero'
					,'$puertas_protecccion'
					,'$ventanas_protecion'
					,'$tragaluces_proteccion'
					,'$caja_seguridad'
					,'$policia_armado'
					,'$deposito_bancario'
					,'$velador'
					,'$cuantos2'
				)
								";
		DreQueryDB($sqlInsertFormularioLineasPersonales);
		}
	?>
    <script>
		alert('Formulario de Anuncios Luminosos \n Guardado con Exito !!!');
		window.close();
		window.opener.document.location.reload();
	</script>
    <?php
}
//guardar formularios de seccion 1
if($_REQUEST['tipoGuardar'] == 'formulariosSeccion1'){
//$recId = mysql_result(DreQueryDB("Select `recId` From `actividades` Where `idInterno` = '$idInterno'"),0);
		if(mysql_num_rows(DreQueryDB("Select * From `actividades_formularios` Where `idActividad` = '$idActividad' And `ramoInterno` = '$ramoInterno'"))){
		$sqlUpdateFormularioLineasPersonales = 	"
			Update `actividades_formularios`
				Set
					`formSeccion1` = '1'
					,`edificios_terminados` = '$edificios_terminados'
					,`maquinaria_fija` = '$maquinaria_fija'
					,`bienes_fijos` = '$bienes_fijos'
					,`bienes_muebles` = '$bienes_muebles'
				Where
					`idActividad` = '$idActividad' And `ramoInterno` = '$ramoInterno'
								";	
		DreQueryDB($sqlUpdateFormularioLineasPersonales);
		} else {
		$sqlInsertFormularioLineasPersonales = 	"
			Insert Into `actividades_formularios`
				(
					`formSeccion1`
					, `edificios_terminados`
					,`maquinaria_fija`
					,`bienes_fijos`
					,`bienes_muebles`
				)
			Values
				(
					'1'
					,'$edificios_terminados'
					,'$maquinaria_fija'
					,'$bienes_fijos'
					,'$bienes_muebles'
				)
								";
		DreQueryDB($sqlInsertFormularioLineasPersonales);
		}
	?>
    <script>
		alert('Formulario de Seccion 1 \n Guardado con Exito !!!');
		window.close();
		window.opener.document.location.reload();
	</script>
    <?php
}
//guardar formularios de robo y asalto
if($_REQUEST['tipoGuardar'] == 'formulariosRoboV'){
//$recId = mysql_result(DreQueryDB("Select `recId` From `actividades` Where `idInterno` = '$idInterno'"),0);
		if(mysql_num_rows(DreQueryDB("Select * From `actividades_formularios` Where `idActividad` = '$idActividad' And `ramoInterno` = '$ramoInterno'"))){
		$sqlUpdateFormularioLineasPersonales = 	"
			Update `actividades_formularios`
				Set
					`formRobov` = '1'
					,`mercancias_materiaPrima` = '$mercancias_materiaPrima'
					,`negocio_asegurado` = '$negocio_asegurado'
					,`deducible_roboV` = '$TipoDeducibleR'
				Where
					`idActividad` = '$idActividad' And `ramoInterno` = '$ramoInterno'
								";	
		DreQueryDB($sqlUpdateFormularioLineasPersonales);
		} else {
		$sqlInsertFormularioLineasPersonales = 	"
			Insert Into `actividades_formularios`
				(
					`formRobov`
					, `mercancias_materiaPrima`
					,`negocio_asegurado`
					,`deducible_roboV`
				)
			Values
				(
					'1'
					,'$mercancias_materiaPrima'
					,'$negocio_asegurado'
					,'$TipoDeducibleR'
				)
								";
		DreQueryDB($sqlInsertFormularioLineasPersonales);
		}
	?>
    <script>
		alert('Formulario de Robo con Asalto y Violencia \n Guardado con Exito !!!');
		window.close();
		window.opener.document.location.reload();
	</script>
    <?php
}
//guardar formularios de dinero
if($_REQUEST['tipoGuardar'] == 'formulariosDineroV'){
//$recId = mysql_result(DreQueryDB("Select `recId` From `actividades` Where `idInterno` = '$idInterno'"),0);
		if(mysql_num_rows(DreQueryDB("Select * From `actividades_formularios` Where `idActividad` = '$idActividad' And `ramoInterno` = '$ramoInterno'"))){
		$sqlUpdateFormularioLineasPersonales = 	"
			Update `actividades_formularios`
				Set
					`formDineroV` = '1'
					,`local_valores` = '$local_valores'
					,`FueraLocal_valores` = '$FueraLocal_valores'
					,`limite_unico` = '$limite_unico'
					,`deducible_DineroV` = '$TipoDeducibleR2'
					,`vehiculos_repartidores` = '$vehiculos_repartidores'
					,`sublimite_unidadDV` = '$sublimite_unidadDV'
					,`numero_unidadesDV` = '$numero_unidadesDV'
					,`deducible_vehiculosRDV` = '$TipoDeducibleR'
				Where
					`idActividad` = '$idActividad' And `ramoInterno` = '$ramoInterno'
								";	
		DreQueryDB($sqlUpdateFormularioLineasPersonales);
		} else {
		$sqlInsertFormularioLineasPersonales = 	"
			Insert Into `actividades_formularios`
				(
					`formDineroV`
					,`local_valores`
					,`FueraLocal_valores`
					,`limite_unico`
					,`deducible_DineroV`
					,`vehiculos_repartidores`
					,`sublimite_unidadDV`
					,`numero_unidadesDV`
					,`deducible_vehiculosRDV`
				)
			Values
				(
					'1'
					,'$local_valores'
					,'$FueraLocal_valores'
					,'$limite_unico'
					,'$TipoDeducibleR2'
					,'$vehiculos_repartidores'
					,'$sublimite_unidadDV'
					,'$numero_unidadesDV'
					,'$TipoDeducibleR'
				)
								";
		DreQueryDB($sqlInsertFormularioLineasPersonales);
		}
	?>
    <script>
		alert('Formulario de Dinero y Valores \n Guardado con Exito !!!');
		window.close();
		window.opener.document.location.reload();
	</script>
    <?php
}
//guardar formularios de equipo electronico
if($_REQUEST['tipoGuardar'] == 'formulariosEquipoE'){
//$recId = mysql_result(DreQueryDB("Select `recId` From `actividades` Where `idInterno` = '$idInterno'"),0);
		if(mysql_num_rows(DreQueryDB("Select * From `actividades_formularios` Where `idActividad` = '$idActividad' And `ramoInterno` = '$ramoInterno'"))){
		$sqlUpdateFormularioLineasPersonales = 	"
			Update `actividades_formularios`
				Set
					`formEquipoE` = '1'
					,`cobertura_basica` = '$cobertura_basica'
					,`equipo_movil` = '$equipo_movil'
					,`equipo_portatil` = '$equipo_portatil'
					,`marca_equipoE` = '$marca_equipoE'
					,`modelo_equipoE` = '$modelo_equipoE'
					,`numero_serieE` = '$numero_serieE'
					,`cobertura_adicionalEquipoE` = '$cobertura_adicionalEquipoE'
					,`terremoto_equipoE` = '$terremoto_equipoE'
					,`huelgasVandalismo` = '$huelgasVandalismo'
					,`robo_sinViolencia` = '$robo_sinViolencia'
					,`portadoresExternos` = '$portadoresExternos'
					,`ajuste_inflacionarioEquipoE` = '$ajuste_inflacionarioEquipoE'
					,`fenomenos_equipoE` = '$fenomenos_equipoE'
					,`gastos_tiempoExtra` = '$gastos_tiempoExtra'
					,`costo_operacion` = '$costo_operacion'
					,`mesesIndemnizacion` = '$mesesIndemnizacion'
					,`deducible_diasE` = '$deducible_diasE'
				Where
					`idActividad` = '$idActividad' And `ramoInterno` = '$ramoInterno'
								";	
		DreQueryDB($sqlUpdateFormularioLineasPersonales);
		} else {
		$sqlInsertFormularioLineasPersonales = 	"
			Insert Into `actividades_formularios`
				(
					`formEquipoE`
					,`cobertura_basica`
					,`equipo_movil`
					,`equipo_portatil`
					,`marca_equipoE`
					,`modelo_equipoE`
					,`numero_serieE`
					,`cobertura_adicionalEquipoE`
					,`terremoto_equipoE`
					,`huelgasVandalismo`
					,`robo_sinViolencia`
					,`portadoresExternos`
					,`ajuste_inflacionarioEquipoE`
					,`fenomenos_equipoE`
					,`gastos_tiempoExtra`
					,`costo_operacion`
					,`mesesIndemnizacion`
					,`deducible_diasE`
				)
			Values
				(
					'1'
					,'$cobertura_basica'
					,'$equipo_movil'
					,'$equipo_portatil'
					,'$marca_equipoE'
					,'$modelo_equipoE'
					,'$numero_serieE'
					,'$cobertura_adicionalEquipoE'
					,'$terremoto_equipoE'
					,'$huelgasVandalismo'
					,'$robo_sinViolencia'
					,'$portadoresExternos'
					,'$ajuste_inflacionarioEquipoE'
					,'$fenomenos_equipoE'
					,'$gastos_tiempoExtra'
					,'$costo_operacion'
					,'$mesesIndemnizacion'
					,'$deducible_diasE'
				)
								";
		DreQueryDB($sqlInsertFormularioLineasPersonales);
		}
	?>
    <script>
		alert('Formulario de Equipo Electronico \n Guardado con Exito !!!');
		window.close();
		window.opener.document.location.reload();
	</script>
    <?php
}
//*****TERMINAN NUEVAS FUNCIONES

//tipoGuardar formularios
if($_REQUEST['tipoGuardar'] == 'formularios'){
	$recId = $idActividad;
	$sqlIf = "Select * From `actividades_formularios` Where `idActividad` = '$idActividad' And `ramoInterno` = '$ramoInterno'";
		if(mysql_num_rows(DreQueryDB($sqlIf))){

		$sqlUpdateFormularioLineasPersonales = 	"
			Update `actividades_formularios`
				Set
					`estatus` = '1'
					, `actividad_laboral` = '$actividad_laboral'
					, `alumnos_0_11` = '$alumnos_0_11'
					, `alumnos_12_60` = '$alumnos_12_60'
					, `coaseguro` = '$coaseguro'
					, `cobertura_internacional` = '$cobertura_internacional'
					, `cobertura_invalidez` = '$cobertura_invalidez'
					, `cobertura_vitalicia` = '$cobertura_vitalicia'
					, `coberturas_adicionales` = '$coberturas_adicionales'
					, `comentario` = '$comentario'
					, `deducible` = '$deducible'
					, `docente_18_60` = '$docente_18_60'
					, `edad_retiro` = '$edad_retiro'
					, `estado` = '$estado'
					, `fecha_nacimiento` = '$fecha_nacimiento'
					, `fecha_nacimiento_conyuge` = '$fecha_nacimiento_conyuge'
					, `fecha_nacimiento_menor` = '$fecha_nacimiento_menor'
					, `forma_pago` = '$forma_pago'
					, `fuma` = '$fuma'
					, `fuma_conyuge` = '$fuma_conyuge'
					, `moneda` = '$moneda'
					, `nivel_hospitalario` = '$nivel_hospitalario'
					, `nombre` = '$nombre'
					, `nombre_conyuge` = '$nombre_conyuge'
					, `nombre_escuela` = '$nombre_escuela'
					, `nombre_menor` = '$nombre_menor'
					, `observaciones` = '$observaciones'
					, `plazo_ahorro` = '$plazo_ahorro'
					, `poliza_gmm` = '$poliza_gmm'
					, `sexo` = '$sexo'
					, `sexo_conyuge` = '$sexo_conyuge'
					, `suma_asegurada` = '$suma_asegurada'
					, `tiempo_cobertura` = '$tiempo_cobertura'
					, `tipo_escuela` = '$tipo_escuela'
					, `monto_fianza` = '$monto_fianza'
					, `tipo_fianza` = '$tipo_fianza'
					, `nombre_beneficiario` = '$nombre_beneficiario'
					, `marca_auto` = '$categoria'
					, `modelo_auto` = '$buscar'
					, `year_auto` = '$ano'
					, `codigo_postal` = '$codigo_postal'
					, `tipo_uso` = '$tipo_uso'
					, `cobertura_auto` = '$cobertura_auto'
					, `valor_factura` = '$valor_factura'
					, `nombre_embarcacion` = '$nombre_embarcacion'
					, `marca_embarcacion` = '$marca_embarcacion'
					, `modelo_embarcacion` = '$modelo_embarcacion'
					, `numero_serie` = '$numero_serie'
					, `matricula` = '$matricula'
					, `uso_embarcacion` = '$uso_embarcacion'
					, `year_embarcacion` = '$year_embarcacion'
					, `materiales_embarcacion` = '$materiales_embarcacion'
					, `medida_eslora` = '$medida_eslora'
					, `medida_manga` = '$medida_manga'
					, `medida_puntal` = '$medida_puntal'
					, `bandera` = '$bandera'
					, `puerto_base` = '$puerto_base'
					, `aguas_navega` = '$aguas_navega'
					, `capacidad_embarcacion` = '$capacidad_embarcacion'
					, `marca_motor` = '$marca_motor'
					, `modelo_motor` = '$modelo_motor'
					, `cantidad_motor` = '$cantidad_motor'
					, `numero_serie_motor` = '$numero_serie_motor'
					, `potencia_motor` = '$potencia_motor'
					, `peso_bruto` = '$peso_bruto'
					, `peso_neto` = '$peso_neto'
					, `monto_siniestro` = '$monto_siniestro'
					,`poblacion`='$poblacion'
					,`colonia`='$colonia'
					,`recibe_rentas`='$recibe_rentas'
					,`tipo_alarma`='$tipo_alarma'
					,`inicio_vigencia`='$inicio_vigencia'
					,`numero_sotanos`='$numero_sotanos'
					,`numero_pisos`='$numero_pisos'
					,`metros_construccion`='$metros_construccion'
					,`dinero_edificio`='$dinero_edificio'
					,`dinero_contenido`='$dinero_contenido'
					,`dinero_escombro`='$dinero_escombro'
					,`cristales`='$cristales'
					,`responsabilidad_civil`='$responsabilidad_civil'
					,`perdida_ingresos`='$perdida_ingresos'
					,`robo_contenidos`='$robo_contenidos'
					,`robo_fuera`='$robo_fuera'
					,`dinero_valores`='$dinero_valores'
					,`ajuste`='$ajuste'
					,`muro`='$muro'
					,`techo`='$techo'
					,`tipo_vivienda`='$tipo_vivienda'
					,`gastos_extraordinarios`='$gastos_extraordinarios'
					,`uso_hogar`='$uso_hogar'
					,`regimen_hogar`='$regimen_hogar'
					,`edificion_terremoto_volcan`='$edificion_terremoto_volcan'
					,`edificio_hidrometeorologico`='$edificio_hidrometeorologico'
					,`contenidos_terremoto_volcan`='$contenidos_terremoto_volcan'
					,`contenidos_hidrometeorologico`='$contenidos_hidrometeorologico'
					,`no_empleados`='$no_empleados'
					,`sector`='$sector'
					,`giro_tarifa`='$giro_tarifa'
					,`giro_negocio`='$giro_negocio'
					,`persona_tipo`='$Tipo_persona'
					,`apellido_paterno`='$apellido_paterno'
					,`apellido_materno`='$apellido_materno'
					,`rfc`='$rfc'
					,`curp`='$curp'
					,`calle`='$calle'
					,`num_interior`='$noint'
					,`num_exterior`='$noext'
					,`ciudad`='$ciudad'
					,`tel`='$telefono'
					,`email`='$email'
					,`mobiliario_equipo`='$mobiliario_equipo'
				Where
					`idActividad` = '$idActividad' 
					And 
					`ramoInterno` = '$ramoInterno'
												";	
		DreQueryDB($sqlUpdateFormularioLineasPersonales);

		} else {

		$sqlInsertFormularioLineasPersonales = 	"
			Insert Into `actividades_formularios`
				(
					 `idActividad`
					,`estatus`
					,`ramoInterno`
					,`SubRamo`
					,`tipoDanos`
					,`actividad_laboral`
					,`alumnos_0_11`
					,`alumnos_12_60`
					,`coaseguro`
					,`cobertura_internacional`
					,`cobertura_invalidez`
					,`cobertura_vitalicia`
					,`coberturas_adicionales`
					,`comentario`
					,`deducible`
					,`docente_18_60`
					,`edad_retiro`
					,`estado`
					,`fecha_nacimiento`
					,`fecha_nacimiento_conyuge`
					,`fecha_nacimiento_menor`
					,`forma_pago`
					,`fuma`
					,`fuma_conyuge`
					,`moneda`
					,`nivel_hospitalario`
					,`nombre`
					,`nombre_conyuge`
					,`nombre_escuela`
					,`nombre_menor`
					,`observaciones`
					,`plazo_ahorro`
					,`poliza_gmm`
					,`sexo`
					,`sexo_conyuge`
					,`suma_asegurada`
					,`tiempo_cobertura`
					,`tipo_escuela`
					,`monto_fianza`
					,`tipo_fianza`
					,`nombre_beneficiario`
					,`marca_auto`
					,`modelo_auto`
					,`year_auto`
					,`codigo_postal`
					,`tipo_uso`
					,`cobertura_auto`
					,`valor_factura`
					,`nombre_embarcacion`
					,`marca_embarcacion`
					,`modelo_embarcacion`
					,`numero_serie`
					,`matricula`
					,`uso_embarcacion`
					,`year_embarcacion`
					,`materiales_embarcacion`
					,`medida_eslora`
					,`medida_manga`
					,`medida_puntal`
					,`bandera`
					,`puerto_base`
					,`aguas_navega`
					,`capacidad_embarcacion`
					,`marca_motor`
					,`modelo_motor`
					,`cantidad_motor`
					,`numero_serie_motor`
					,`potencia_motor`
					,`peso_bruto`
					,`peso_neto`
					,`monto_siniestro`
					,`poblacion`
					,`colonia`
					,`recibe_rentas`
					,`tipo_alarma`
					,`inicio_vigencia`
					,`numero_sotanos`
					,`numero_pisos`
					,`metros_construccion`
					,`dinero_edificio`
					,`dinero_contenido`
					,`dinero_escombro`
					,`cristales`
					,`responsabilidad_civil`
					,`perdida_ingresos`
					,`robo_contenidos`
					,`robo_fuera`
					,`dinero_valores`
					,`ajuste`
					,`muro`
					,`techo`
					,`tipo_vivienda`
					,`gastos_extraordinarios`
					,`uso_hogar`
					,`regimen_hogar`
					,`edificion_terremoto_volcan`
					,`edificio_hidrometeorologico`
					,`contenidos_terremoto_volcan`
					,`contenidos_hidrometeorologico`
					,`no_empleados`
					,`sector`
					,`giro_tarifa`
					,`giro_negocio`
					,`persona_tipo`
					,`apellido_paterno`
					,`apellido_materno`
					,`rfc`
					,`curp`
					,`calle`
					,`num_interior`
					,`num_exterior`
					,`ciudad`
					,`tel`
					,`email`
					,`mobiliario_equipo`
					,`reconocimientoAntiguedad`
				)
			Values
				(
					 '$idActividad'
					 ,'1'
					,'$ramoInterno'
					,'$SubRamo'
					,'$tipoDanos'
					,'$actividad_laboral'
					,'$alumnos_0_11'
					,'$alumnos_12_60'
					,'$coaseguro'
					,'$cobertura_internacional'
					,'$cobertura_invalidez'
					,'$cobertura_vitalicia'
					,'$coberturas_adicionales'
					,'$comentario'
					,'$deducible'
					,'$docente_18_60'
					,'$edad_retiro'
					,'$estado'
					,'$fecha_nacimiento'
					,'$fecha_nacimiento_conyuge'
					,'$fecha_nacimiento_menor'
					,'$forma_pago'
					,'$fuma'
					,'$fuma_conyuge'
					,'$moneda'
					,'$nivel_hospitalario'
					,'$nombre'
					,'$nombre_conyuge'
					,'$nombre_escuela'
					,'$nombre_menor'
					,'$observaciones'
					,'$plazo_ahorro'
					,'$poliza_gmm'
					,'$sexo'
					,'$sexo_conyuge'
					,'$suma_asegurada'
					,'$tiempo_cobertura'
					,'$tipo_escuela'
					,'$monto_fianza'
					,'$tipo_fianza'
					,'$nombre_beneficiario'
					,'$categoria'
					,'$buscar'
					,'$ano'
					,'$codigo_postal'
					,'$tipo_uso'
					,'$cobertura_auto'
					,'$valor_factura'
					,'$nombre_embarcacion'
					,'$marca_embarcacion'
					,'$modelo_embarcacion'
					,'$numero_serie'
					,'$matricula'
					,'$uso_embarcacion'
					,'$year_embarcacion'
					,'$materiales_embarcacion'
					,'$medida_eslora'
					,'$medida_manga'
					,'$medida_puntal'
					,'$bandera'
					,'$puerto_base'
					,'$aguas_navega'
					,'$capacidad_embarcacion'
					,'$marca_motor'
					,'$modelo_motor'
					,'$cantidad_motor'
					,'$numero_serie_motor'
					,'$potencia_motor'
					,'$peso_bruto'
					,'$peso_neto'
					,'$monto_siniestro'
					,'$poblacion'
					,'$colonia'
					,'$recibe_rentas'
					,'$tipo_alarma'
					,'$inicio_vigencia'
					,'$numero_sotanos'
					,'$numero_pisos'
					,'$metros_construccion'
					,'$dinero_edificio'
					,'$dinero_contenido'
					,'$dinero_escombro'
					,'$cristales'
					,'$responsabilidad_civil'
					,'$perdida_ingresos'
					,'$robo_contenidos'
					,'$robo_fuera'
					,'$dinero_valores'
					,'$ajuste'
					,'$muro'
					,'$techo'
					,'$tipo_vivienda'
					,'$gastos_extraordinarios'
					,'$uso_hogar'
					,'$regimen_hogar'
					,'$edificion_terremoto_volcan'
					,'$edificio_hidrometeorologico'
					,'$contenidos_terremoto_volcan'
					,'$contenidos_hidrometeorologico'
					,'$no_empleados'
					,'$sector'
					,'$giro_tarifa'
					,'$giro_negocio'
					,'$Tipo_persona'
					,'$apellido_paterno'
					,'$apellido_materno'
					,'$rfc'
					,'$curp'
					,'$calle'
					,'$noint'
					,'$noext'
					,'$ciudad'
					,'$telefono'
					,'$email'
					,'$mobiliario_equipo'
					,'$reconocimientoAntiguedad'
				);
								 				";
		DreQueryDB($sqlInsertFormularioLineasPersonales);
		
		$idFormulario = mysql_insert_id();

	if(isset($addAseguradora)){		
		foreach($addAseguradora as $aseguradora){
			$sqlInsertNombreAseguradoras = "
				Insert Into
					`actividades_formularios_aseguradora`
				(
					`idFormulario`
					,`aseguradora`
				)
				Values
				(
					'$idFormulario'
					,'$aseguradora'
				)
										   ";
		DreQueryDB($sqlInsertNombreAseguradoras);
		}// fin del foreach
	}// Validacion AddAseguradora

		}
//-->	$return = "../actividadesDetalle.php?SubRamo=$SubRamo&recId=$idActividad&muestra=$muestra#$muestra";
	$return = "../actividadesDetalle.php?recId=$idActividad&muestra=Formularios&form=2#Formularios";
	?>
    <script>
		alert('Guardado \n Exitoso !!!'); // y Terminado
		window.open('<?php echo $return; ?>','_self');
	</script>
    <?php
}

// Guardar formulariosTerminar
if($_REQUEST['tipoGuardar'] == 'formulariosTerminar'){
	$sqlTerminarFormularioLineaPersonales = "
		Update 
			`actividades_formularios`
		Set 
			`estatus`='1'
		Where 
			`idActividad` = '$idActividad'
			And 
			`ramoInterno` = '$ramoInterno'
			And 
			`SubRamo` = '$SubRamo'
											";
	DreQueryDB($sqlTerminarFormularioLineaPersonales);
	
	$return = "../actividadVer.php?recId=".$idActividad;
?>
<script language="javascript">
	alert('Formulario Terminado !!!');
//	opener.location.reload();
	window.open('<?php echo $return; ?>','_self');
//	window.close();

</script> 
<?php
}

// Guardar asignarCotizacionEmision
if($_REQUEST['tipoGuardar'] == 'asignarCotizacionEmision'){

	$ramoInternoCotizacion = mysql_result(DreQueryDB("Select `ramoInterno` From `actividades` Where `idInterno` = '$idInternoCotizacion'"),0);
//AUTOS+INDIVIDUALES+RENOVACION
	$recIdCotizacion = mysql_result(DreQueryDB("Select `recId` From `actividades` Where `idInterno` = '$idInternoCotizacion'"),0);
//w636
	$recIdEmision = mysql_result(DreQueryDB("Select `recId` From `actividades` Where `idInterno` = '$idInternoEmision'"),0); 
//w637

	if(strcmp($ramoInternoCotizacion,"AUTOS+INDIVIDUALES+NUEVOS") ==0 ){

		$sqlInformacionFormularioParaEmision = 	"
			Select
				* 
			From 
				`actividades_formularios` 
			Where 
					`idActividad` = '$recIdCotizacion' 
				And 
					`ramoInterno` = '$ramoInternoCotizacion'
												";
			$resInformacionFormularioParaEmision = DreQueryDB($sqlInformacionFormularioParaEmision);
			$rowInformacionFormularioParaEmision = mysql_fetch_assoc($resInformacionFormularioParaEmision);

//print_r($rowInformacionFormularioParaEmision);
			
			$sqlValidacionCompletarFormularioEmisiones = "Select * From `actividades_emision` Where `idActividad` = '$recIdEmision' And `tipoEmisiones` = 'autos'";
			if(!mysql_num_rows(DreQueryDB($sqlValidacionCompletarFormularioEmisiones))){
				//No hay un formulario  y lo completamos con los datos de la cotizacion
				$sqlInsertFormularioEmisiones = 	"
					Insert Into `actividades_emision`
						(
							`idActividad`
							,`tipoEmisiones`
							,`marca`
							,`modelo`
							,`year`
							,`tipo_uso`
							,`estado`
						) 
					VALUES 
						(
							'$recIdEmision'
							,'autos'
							,'$rowInformacionFormularioParaEmision[marca_auto]'
							,'$rowInformacionFormularioParaEmision[modelo_auto]'
							,'$rowInformacionFormularioParaEmision[year_auto]'
							,'$rowInformacionFormularioParaEmision[tipo_uso]'
							,'$rowInformacionFormularioParaEmision[estado]'
						)
												";
				DreQueryDB($sqlInsertFormularioEmisiones);
			} // fin del IF validacion que no exista formulario
			else{
			$sqlInsertPrueba = 	"
			Update 
				`actividades_emision` 
			Set 
				`idActividad`='$recIdEmision',
				`tipoEmisiones`='autos',
				`marca`='$rowInformacionFormularioParaEmision[marca_auto]',
				`modelo`='$rowInformacionFormularioParaEmision[modelo_auto]',
				`year`='$rowInformacionFormularioParaEmision[year_auto]',
				`tipo_uso`='$rowInformacionFormularioParaEmision[tipo_uso]',
				`estado`='$rowInformacionFormularioParaEmision[estado]'
			Where 
				`idActividad` = '$recIdEmision' And `tipoEmisiones` = 'autos'
									";
	DreQueryDB($sqlInsertPrueba);
			
			}
	} // fin del IF validacion tipo actividad interna AUTOS+INDIVIDUALES+NUEVOS

	if(strcmp($ramoInternoCotizacion,"AUTOS+INDIVIDUALES+RENOVACION") ==0 ){
		$sqlInformacionFormularioParaEmision = 	"
			Select
				* 
			From 
				`actividades_formularios` 
			Where 
					`idActividad` = '$recIdCotizacion' 
				And 
					`ramoInterno` = '$ramoInternoCotizacion'
												";
			$resInformacionFormularioParaEmision = DreQueryDB($sqlInformacionFormularioParaEmision);
			$rowInformacionFormularioParaEmision = mysql_fetch_assoc($resInformacionFormularioParaEmision);
			
			$sqlValidacionCompletarFormularioEmisiones = "Select * From `actividades_emision` Where `idActividad` = '$recIdEmision' And `tipoEmisiones` = 'autos'";
			if(!mysql_num_rows(DreQueryDB($sqlValidacionCompletarFormularioEmisiones))){
				//No hay un formulario  y lo completamos con los datos de la cotizacion
				$sqlInsertFormularioEmisiones = 	"
					Insert Into `actividades_emision`
						(
							`idActividad`
							,`tipoEmisiones`
							,`marca`
							,`modelo`
							,`year`
							,`tipo_uso`
							,`estado`
						) 
					VALUES 
						(
							'$recIdEmision'
							,'autos'
							,'$rowInformacionFormularioParaEmision[marca_auto]'
							,'$rowInformacionFormularioParaEmision[modelo_auto]'
							,'$rowInformacionFormularioParaEmision[year_auto]'
							,'$rowInformacionFormularioParaEmision[tipo_uso]'
							,'$rowInformacionFormularioParaEmision[estado]'
						)
												";
				DreQueryDB($sqlInsertFormularioEmisiones);
			} // fin del IF validacion que no exista formulario
			else{
			$sqlInsertPrueba = 	"
			Update 
				`actividades_emision` 
			Set 
				`idActividad`='$recIdEmision',
				`tipoEmisiones`='autos',
				`marca`='$rowInformacionFormularioParaEmision[marca_auto]',
				`modelo`='$rowInformacionFormularioParaEmision[modelo_auto]',
				`year`='$rowInformacionFormularioParaEmision[year_auto]',
				`tipo_uso`='$rowInformacionFormularioParaEmision[tipo_uso]',
				`estado`='$rowInformacionFormularioParaEmision[estado]'
			Where 
				`idActividad` = '$recIdEmision' And `tipoEmisiones` = 'autos'
									";
	DreQueryDB($sqlInsertPrueba);
			
			}
	} // fin del IF validacion tipo actividad interna AUTOS+INDIVIDUALES+RENOVACION

	$sqlAsignarCotizacionEmision = 	"
			Update 
				`actividades` 
			Set 
				`cotizacionEmision` = '$idInternoCotizacion' 
			Where 
				`idInterno` = '$idInternoEmision'
									";
	DreQueryDB($sqlAsignarCotizacionEmision);
	
	$sqlMarcarCotizacion = 	"
			Update 
				`actividades` 
			Set 
				`cotizacionEmision` = '0' 
			Where 
				`idInterno` = '$idInternoCotizacion'
							";
	DreQueryDB($sqlMarcarCotizacion);

	$return = "../actividadVer.php?ver=2&recId=".$recIdEmision;

?>
<script language="javascript">
//	opener.location.reload();
//	window.close();
window.open('<?php echo $return; ?>','_self');
</script> 
<?php
}

// Guardar emisiones
if($_REQUEST['tipoGuardar'] == 'emisiones'){
// Variables Generales para Emision

//--> echo "<pre>".print_r($_REQUEST)."</pre>";

switch($aseguradora){ // Switch Aseguradora

	//* 1
	case "qualitas":
		require_once('../nusoap-0.9.5/lib/nusoap.php');
		$xml = '<?xml version="1.0" encoding="utf-8"?>
<Movimientos>
	<Movimiento TipoMovimiento="3" NoPoliza="" NoCotizacion="" NoEndoso="" TipoEndoso="" NoOTra="" NoNegocio="01970">
		<DatosAsegurado NoAsegurado="">
			<Nombre>'.$NombreCompleto.'</Nombre>
			<Direccion>'.$Direccion.'</Direccion>
			<Colonia>'.$Colonia.'</Colonia>
			<Poblacion>'.$Poblacion.'</Poblacion>
			<Estado>'.$Estado.'</Estado>
			<CodigoPostal>'.$CodigoPostal.'</CodigoPostal>
			<NoEmpleado/>
			<Agrupador/>
			<ConsideracionesAdicionalesDA NoConsideracion="40">
				<TipoRegla>1</TipoRegla>
				<ValorRegla>'.$NumeroExterior.'</ValorRegla><!-- Numero Exterior -->
			</ConsideracionesAdicionalesDA>
			<ConsideracionesAdicionalesDA NoConsideracion="40">
				<TipoRegla>3</TipoRegla>
				<ValorRegla>'.$Pais.'</ValorRegla><!-- Pais -->
			</ConsideracionesAdicionalesDA>
			<ConsideracionesAdicionalesDA NoConsideracion="40">
				<TipoRegla>4</TipoRegla>
				<ValorRegla>'.$NombrePrimero.'</ValorRegla><!-- Nombre_1 Nombre_2 -->
			</ConsideracionesAdicionalesDA>
			<ConsideracionesAdicionalesDA NoConsideracion="40">
				<TipoRegla>5</TipoRegla>
				<ValorRegla>'.$ApellidoPaterno.'</ValorRegla><!-- Apellido Paterno -->
			</ConsideracionesAdicionalesDA>
			<ConsideracionesAdicionalesDA NoConsideracion="40">
				<TipoRegla>6</TipoRegla>
				<ValorRegla>'.$ApellidoMaterno.'</ValorRegla><!-- Apellido Materno -->
			</ConsideracionesAdicionalesDA>
			<ConsideracionesAdicionalesDA NoConsideracion="40">
				<TipoRegla>19</TipoRegla>
				<ValorRegla>'.$TipoPersona.'</ValorRegla><!-- Tipo de Persona (Persona Física:1, Persona Moral:2;) -->
			</ConsideracionesAdicionalesDA>
			<ConsideracionesAdicionalesDA NoConsideracion="40">
				<TipoRegla>20</TipoRegla>
				<ValorRegla>'.$FechaNacimiento.'</ValorRegla> <!-- Fecha de Nacimiento Formato (dd/mm/aaaa) -->
			</ConsideracionesAdicionalesDA>
			<ConsideracionesAdicionalesDA NoConsideracion="40">
				<TipoRegla>21</TipoRegla>
				<ValorRegla>1</ValorRegla> <!-- Nacionalidad (Ver Catálogo) -->
			</ConsideracionesAdicionalesDA>
			<ConsideracionesAdicionalesDA NoConsideracion="40">
				<TipoRegla>23</TipoRegla>
				<ValorRegla>5</ValorRegla><!-- Ocupación (Ver Catálogo) -->
			</ConsideracionesAdicionalesDA>
			<ConsideracionesAdicionalesDA NoConsideracion="40">
				<TipoRegla>24</TipoRegla>
				<ValorRegla>30</ValorRegla><!-- Sector o Giro Comercial (Ver Catálogo) -->
			</ConsideracionesAdicionalesDA>
			<ConsideracionesAdicionalesDA NoConsideracion="40">
				<TipoRegla>28</TipoRegla>
				<ValorRegla>'.$Rfc.'</ValorRegla> <!-- RFC -->
			</ConsideracionesAdicionalesDA>
			<ConsideracionesAdicionalesDA NoConsideracion="40">
				<TipoRegla>70</TipoRegla>
				<ValorRegla>'.$Telefono.'</ValorRegla> <!-- Teléfono -->
			</ConsideracionesAdicionalesDA>
		</DatosAsegurado>
		<DatosVehiculo NoInciso="1">
			<ClaveAmis>'.$ClaveAmis.'</ClaveAmis>
			<Modelo>'.$Modelo.'</Modelo>
			<DescripcionVehiculo>'.$DescripcionVehiculo.'</DescripcionVehiculo>
			<Uso>'.$Uso.'</Uso>
			<Servicio>'.$Servicio.'</Servicio>
			<Paquete>'.$Paquete.'</Paquete>
			<Motor>'.$Motor.'</Motor>
			<Serie>'.$Serie.'</Serie>

			<Coberturas NoCobertura="01">
				<SumaAsegurada>'.$valorFactura.'</SumaAsegurada> 
				<TipoSuma>'.$SumaAsegurada.'</TipoSuma> <!-- 0 Valor convenido , 01 Valor factura, 03 Valor comercial -->
				<Deducible>5</Deducible>
				<Prima>0</Prima>
			</Coberturas>
			<Coberturas NoCobertura="03">
				<SumaAsegurada>'.$valorFactura.'</SumaAsegurada>
				<TipoSuma>'.$SumaAsegurada.'</TipoSuma> <!-- 0 Valor convenido , 01 Valor factura, 03 Valor comercial -->
				<Deducible>10</Deducible>
				<Prima>0</Prima>
			</Coberturas>
			<Coberturas NoCobertura="04">
				<SumaAsegurada>3000000</SumaAsegurada>
				<TipoSuma>0</TipoSuma>
				<Deducible>0</Deducible>
				<Prima>0</Prima>
			</Coberturas>
			<Coberturas NoCobertura="05">
				<SumaAsegurada>300000</SumaAsegurada>
				<TipoSuma>0</TipoSuma>
				<Deducible>0</Deducible>
				<Prima>0</Prima>
			</Coberturas>
			<Coberturas NoCobertura="07">
				<SumaAsegurada/>
				<TipoSuma>0</TipoSuma>
				<Deducible>0</Deducible>
				<Prima>0</Prima>
			</Coberturas>
			<Coberturas NoCobertura="14">
				<SumaAsegurada>0</SumaAsegurada>
				<TipoSuma> 0</TipoSuma>
				<Deducible>0</Deducible>
				<Prima>0</Prima>
			</Coberturas>
		</DatosVehiculo>
		<DatosGenerales>
			<FechaEmision>'.$FechaEmision.'</FechaEmision>
			<FechaInicio>'.$FechaInicio.'</FechaInicio>
			<FechaTermino>'.$FechaTermino.'</FechaTermino>
			<Moneda>0</Moneda>
			<Agente>16413</Agente>
			<FormaPago>'.$FormaPago.'</FormaPago>
			<TarifaValores>linea</TarifaValores>
			<TarifaCuotas>linea</TarifaCuotas>
			<TarifaDerechos>linea</TarifaDerechos>
			<Plazo/>
			<Agencia/>
			<Contrato/>
			<PorcentajeDescuento>'.$descuentoQualitas.'</PorcentajeDescuento>
			<ConsideracionesAdicionalesDG NoConsideracion="1">
				<TipoRegla>1</TipoRegla>
				<ValorRegla>'.DigitoVerificadorQualitas($ClaveAmis).'</ValorRegla>
			</ConsideracionesAdicionalesDG>
			<ConsideracionesAdicionalesDG NoConsideracion="4">
				<TipoRegla>1</TipoRegla>
				<ValorRegla>0</ValorRegla> <!-- 0:Produccion; 1:Pruebas; -->
			</ConsideracionesAdicionalesDG>
			<ConsideracionesAdicionalesDG NoConsideracion="5">
				<TipoRegla>1</TipoRegla>
				<ValorRegla>'.$plazoPago.'</ValorRegla>
			</ConsideracionesAdicionalesDG>
		</DatosGenerales>
		<Primas>
			<PrimaNeta/>
			<Derecho>535</Derecho>
			<Recargo/>
			<Impuesto/>
			<PrimaTotal/>
			<Comision/>
		</Primas>
		<CodigoError/>
	</Movimiento>
</Movimientos>';

$client = new nusoap_client('http://sio.qualitas.com.mx/WsEmision/WsEmision.asmx?WSDL', 'wsdl'); //URL del WSDL

// Definicion arreglo de xml con parametros
$arr=array('xmlEmision'=>$xml);

//resultado al consumir WS
$result = $client->call('obtenerNuevaEmision', $arr);

//echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
//echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';

// Proceso para almacenamiento del XML obtenido
$respuestaXML = htmlspecialchars_decode($client->responseData, ENT_NOQUOTES);

$cosasQuitaXml = array('<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"><soap:Body><obtenerNuevaEmisionResponse xmlns="http://qualitas.com.mx/"><obtenerNuevaEmisionResult>','</obtenerNuevaEmisionResult></obtenerNuevaEmisionResponse></soap:Body></soap:Envelope>');
$cosasPonerXml = array('','');

$respuestaXmlDepurada = str_replace($cosasQuitaXml, $cosasPonerXml, $respuestaXML);
$fileXML = "../xmlTodos/qualitas/".$recId."_Emision_".date('dmY_Gis').'.xml';
file_put_contents($fileXML, $respuestaXmlDepurada);

// Validamos que si se generara bien la poliza
	$stringXml = simplexml_load_string($respuestaXmlDepurada); //String del XMl de Respuesta con la poliza
	//--@> $stringXml = simplexml_load_file('../xmlTodos/qualitas/'.'w4011_Emision_03072014_205409.xml');
		foreach($stringXml->Movimiento as $cotizacion){ /* echo "<pre>"; print_r($cotizacion); echo "</pre>"; */ }
		//--> echo "Error=>".$cotizacion->CodigoError;

	// Impresion de Poliza
		if($cotizacion->CodigoError == ""){ //Iniciamos el proceso de impresion por que no hay error en la poliza
			$nPoliza = substr($cotizacion['NoPoliza'],2,10); // --> 
		
		// ** Insertamos el Xml en la Tabla de Imagenes para descargar a linea de captura
			/* aun no hay proceso */
				$idFile = mysql_result(DreQueryDB("Select Count(*) From `imagenes` Where `NO_ARCHIVO` Like '$recId%'"),0);
				$ArchivoWeb = $recId."_".$idFile;
			$NO_ARCHIVO = $ArchivoWeb;
			$EXTENSION = "XML";
			$DESCRIPCION = strtoupper($aseguradora);
			$TIPO = "XML";
			$POLIZA = $nPoliza;
			$VALOR = $nPoliza;
			$TIPO_IMG = "XML CARATULA";
			$CLIENTE_MPRO = $idCliente;
			$CLIENTE_TMP = $idCliente;
			$SUCURSAL = $Sucursal;
			$recId = $recId;
			$idUsuario = $Usuario;
			$subRamo = "Autos+Individuales";
							
			//** Descargamos el XML al Servidor Local por FTP
			$archivoSeleccionadoXml = $fileXML;
			$nameFileXml = $ArchivoWeb.".".$EXTENSION;
			$destino = "/" ;
			$fileXml = $destino.$nameFileXml;
			
			// Copiamos el Archivo nuevo
				// informacion del FTP Server
					$ftp_server =  tipoFtp($_SERVER['REMOTE_ADDR']);
					$ftp_user = "userftp";
					$ftp_pass = "DreLearning2012";
				
				// Carga al FTP
					$idcon = ftp_connect($ftp_server)or die ("no se pudo conectar al servidor");
					//ftp_pasv($idcon, true);
					$login = ftp_login($idcon,$ftp_user,$ftp_pass);
					$put = ftp_put($idcon,$fileXml,$archivoSeleccionadoXml,FTP_BINARY);

					if($put){
						$sqlInsertXmlEmision = "
							Insert Into 
					`imagenes`
						(
							`NO_ARCHIVO`
							,`EXTENSION`
							,`DESCRIPCION`
							,`TIPO`
							,`POLIZA`
							,`VALOR`
							,`TIPO_IMG`
							,`CLIENTE_MPRO`
							,`CLIENTE_TMP`
							,`SUCURSAL`
							,`recId`
							,`idUsuario`
							,`subRamo`
						)
						 VALUES 
						(
							 '$NO_ARCHIVO'
							,'$EXTENSION'
							,'$DESCRIPCION'
							,'$TIPO'
							,'$POLIZA'
							,'$VALOR'
							,'$TIPO_IMG'
							,'$CLIENTE_MPRO'
							,'$CLIENTE_TMP'
							,'$SUCURSAL'
							,'$recId'
							,'$idUsuario'
							,'$subRamo'							
						);
											   ";
						DreQueryDB($sqlInsertXmlEmision);
					//** **//
			//** Ejecutamos el Servicio Web para Imprimir la Poliza
			$client = new nusoap_client('http://qbcenter.qualitas.com.mx/QBCImpresion/Service.asmx?WSDL', true);
			$param = array(
							'nPoliza'=> $nPoliza
							,'URLPoliza'=>''
							,'URLRecibo'=>''
							,'URLTextos'=>''
							,'Inciso'=>'0001'
							,'ImpPol'=>'0'
							,'ImpRec'=>'0'
							,'ImpAnexo'=>'0'
							,'Ramo'=>'04'
							,'formaPol'=>'polizaf1_logoQ_pdf'
							,'formaRec'=>'recibo_logoQ_pdf'
							,'formaAnexo'=>'polizaf2_logoQ_pdf'
							,'Endoso'=>'000000'
							,'NoNegocio'=>'1970'
							,'Agente'=>'16413'
							,'Usuario'=>'Capital'
							,'Password'=>'Cotiza10'
							);

			$result = $client->call('RecuperaImpresionM15', array('parameters' => $param), '', '', false, true);

			//-->echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
			//echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
			
			// Proceso para almacenamiento del XML obtenido
				$respuestaXML_Impresion = htmlspecialchars_decode($client->responseData, ENT_NOQUOTES);
				$cosasQuitaXml_Impresion = array('<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"><soap:Body>','</soap:Body></soap:Envelope>', ' xmlns="http://tempuri.org/"');
				$cosasPonerXml_Impresion = array('','', '');
				$respuestaXmlDepurada_Impresion = str_replace($cosasQuitaXml_Impresion, $cosasPonerXml_Impresion, $respuestaXML_Impresion);
				$stringXml_Impresion = simplexml_load_string($respuestaXmlDepurada_Impresion);

				foreach($stringXml_Impresion->RecuperaImpresionM15Result as $impresionUrls){
					
					$impresionArray = explode('|', $impresionUrls);
					foreach($impresionArray as $impresion){
						$tipoDocumento = substr($impresion,-15,1); 
						$urlLink = $impresion;
						$sqlInsertImpresion = "
							Insert Into
								`ws_impresion_poliza`
									(
										`idActividad`
										,`idCliente`
										,`idUsuario`
										,`companiaSeguros`
										,`poliza`
										,`tipoDocumento`
										,`urlLink`
									)
									VALUES
									(
										'$recId'
										,'$idCliente'
										,'$Usuario'
										,'$aseguradora'
										,'$nPoliza'
										,'$tipoDocumento'
										,'$urlLink'
									);
											  ";
						DreQueryDB($sqlInsertImpresion);
						
						$idFile = mysql_result(DreQueryDB("Select Count(*) From `imagenes` Where `NO_ARCHIVO` Like '$recId%'"),0);
						$ArchivoWeb = $recId."_".$idFile;						
						
						$sqlInsertLnk = "
							Insert Into
								`imagenes`
									(
										`NO_ARCHIVO`
										,`EXTENSION`
										,`DESCRIPCION`
										,`TIPO`
										,`POLIZA`
										,`VALOR`
										,`TIPO_IMG`
										,`CLIENTE_MPRO`
										,`CLIENTE_TMP`
										,`SUCURSAL`
										,`recId`
										,`idUsuario`
										,`subRamo`
									)
										VALUES
									(
										'$ArchivoWeb'
										,'HTTP'
										,'$urlLink'
										,'LNK'
										,'$nPoliza'
										,'$nPoliza'
										,'CARATULA'
										,'$idCliente'
										,'$idCliente'
										,'$SUCURSAL'
										,'$recId'
										,'$Usuario'
										,'Autos+Individuales'
									);
										";
						DreQueryDB($sqlInsertLnk);
								
					} // Recorrido por los tipos de impresion
					
				} // Recorrido por la Poliza a imprimir

					} // if put True

		
		} //Finalizamos el proceso de impresion por que no hay error en la poliza
	break;	
	
	//* 2
	case "aba":
		require_once('../nusoap-0.9.5-Aba/lib/nusoap.php');
		$urlCliente = "http://www5.abaseguros.com/AutoConnect/ACEmision.svc?wsdl"; // url del WSDL
		$pass = "VIRTUAL1$";
		$user = "WSAGECAP";

		$client = new nusoap_client($urlCliente, true); //URL del WSDL
		
		$header = '
		      <tem:Token>
    		     <abas:password>'.$pass.'</abas:password>
	        	 <abas:usuario>'.$user.'</abas:usuario>
		      </tem:Token>
				  ';
		$client->setHeaders($header);
		$client->soap_defencoding = 'UTF-8';
		$client->decode_utf8 = false;

		$xml = '<tem:Entrada>
					<tem:strEntrada>
						&lt;EMI&gt;
							&lt;COTID&gt;'.$COTID.'&lt;/COTID&gt;
							&lt;VERID&gt;'.$VERID.'&lt;/VERID&gt;
							&lt;INCISOS&gt;
								&lt;INCISO&gt;
									&lt;COTINCID&gt;'.$COTINCID.'&lt;/COTINCID&gt;
									&lt;VERINCID&gt;'.$VERINCID.'&lt;/VERINCID&gt;
									&lt;DE&gt;
										&lt;ASEGID&gt;'.$ASEGID.'&lt;/ASEGID&gt;
										&lt;ASEGDIRID&gt;'.$ASEGDIRID.'&lt;/ASEGDIRID&gt;
										&lt;ASEGTRANID&gt;'.$ASEGTRANID.'&lt;/ASEGTRANID&gt;
									&lt;/DE&gt;
									&lt;SERIE&gt;'.$SERIE.'&lt;/SERIE&gt;
									&lt;REF&gt;&lt;/REF&gt;
									&lt;MOTOR&gt;'.$MOTOR.'&lt;/MOTOR&gt;
									&lt;PLACAS&gt;'.$PLACAS.'&lt;/PLACAS&gt;
								&lt;/INCISO&gt;
							&lt;/INCISOS&gt;
						&lt;/EMI&gt;
					</tem:strEntrada>
				</tem:Entrada>';

//resultado al consumir WS
$client->call('EmitePoliza', $xml, 'http://tempuri.org/ACEmision/', 'http://tempuri.org/ACEmision/EmitePoliza',false, false, false, false);


echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';

// Proceso para almacenamiento del XML obtenido
$respuestaXML = htmlspecialchars_decode($client->responseData, ENT_NOQUOTES);

$cosasQuitaXml = array('<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/"><s:Body><Salida xmlns="http://tempuri.org/"><strSalida>','</strSalida></Salida></s:Body></s:Envelope>',' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"');
$cosasPonerXml = array('','','');

$respuestaXmlDepurada = str_replace($cosasQuitaXml, $cosasPonerXml, $respuestaXML);
$fileXML = "../xmlTodos/aba/".$recId."_Emision_".date('dmY_Gis').'.xml';
file_put_contents($fileXML, $respuestaXmlDepurada);

// Validamos que si se generara bien la poliza
	$stringXml = simplexml_load_string($respuestaXmlDepurada); //String del XMl de Respuesta con la poliza
	//--@> $stringXml = simplexml_load_file('../xmlTodos/qualitas/'.'w4011_Emision_03072014_205409.xml');
		//foreach($stringXml->Movimiento as $cotizacion){ /* echo "<pre>"; print_r($cotizacion); echo "</pre>"; */ }
		//--> echo "Error=>".$cotizacion->CodigoError;

	// Impresion de Poliza
		if(count($stringXml) > 0){ //Iniciamos el proceso de impresion por que no hay error en la poliza
			$nPoliza = $stringXml->POL->POL; // --> 
		
		// ** Insertamos el Xml en la Tabla de Imagenes para descargar a linea de captura
			/* aun no hay proceso */
				$idFile = mysql_result(DreQueryDB("Select Count(*) From `imagenes` Where `NO_ARCHIVO` Like '$recId%'"),0);
				$ArchivoWeb = $recId."_".$idFile;
			$NO_ARCHIVO = $ArchivoWeb;
			$EXTENSION = "XML";
			$DESCRIPCION = strtoupper($aseguradora);
			$TIPO = "XML";
			$POLIZA = $nPoliza;
			$VALOR = $nPoliza;
			$TIPO_IMG = "XML CARATULA";
			$CLIENTE_MPRO = $idCliente;
			$CLIENTE_TMP = $idCliente;
			$SUCURSAL = $Sucursal;
			$recId = $recId;
			$idUsuario = $Usuario;
			$subRamo = "Autos+Individuales";
							
			//** Descargamos el XML al Servidor Local por FTP
			$archivoSeleccionadoXml = $fileXML;
			$nameFileXml = $ArchivoWeb.".".$EXTENSION;
			$destino = "/" ;
			$fileXml = $destino.$nameFileXml;
			
			// Copiamos el Archivo nuevo
				// informacion del FTP Server
					$ftp_server =  tipoFtp($_SERVER['REMOTE_ADDR']);
					$ftp_user = "userftp";
					$ftp_pass = "DreLearning2012";
				
				// Carga al FTP
					$idcon = ftp_connect($ftp_server)or die ("no se pudo conectar al servidor");
					//ftp_pasv($idcon, true);
					$login = ftp_login($idcon,$ftp_user,$ftp_pass);
					$put = ftp_put($idcon,$fileXml,$archivoSeleccionadoXml,FTP_BINARY);

					if($put){
						$sqlInsertXmlEmision = "
							Insert Into 
					`imagenes`
						(
							`NO_ARCHIVO`
							,`EXTENSION`
							,`DESCRIPCION`
							,`TIPO`
							,`POLIZA`
							,`VALOR`
							,`TIPO_IMG`
							,`CLIENTE_MPRO`
							,`CLIENTE_TMP`
							,`SUCURSAL`
							,`recId`
							,`idUsuario`
							,`subRamo`
						)
						 VALUES 
						(
							 '$NO_ARCHIVO'
							,'$EXTENSION'
							,'$DESCRIPCION'
							,'$TIPO'
							,'$POLIZA'
							,'$VALOR'
							,'$TIPO_IMG'
							,'$CLIENTE_MPRO'
							,'$CLIENTE_TMP'
							,'$SUCURSAL'
							,'$recId'
							,'$idUsuario'
							,'$subRamo'							
						);
											   ";
						DreQueryDB($sqlInsertXmlEmision);
					//** **//
			//** Ejecutamos el Servicio Web para Imprimir la Poliza
	require_once('../nusoap-0.9.5-Aba/lib/nusoap.php');	
	
	$urlCliente = "http://www5.abaseguros.com/AutoConnect/ACImpresion.svc?wsdl"; // url del WSDL
	$pass = "VIRTUAL1$";
	$user = "WSAGECAP";
	$client = new nusoap_client($urlCliente, true);

	$header = '
    	  <tem:Token>
        	 <abas:password>'.$pass.'</abas:password>
	         <abas:usuario>'.$user.'</abas:usuario>
	      </tem:Token>
			  ';
	$client->setHeaders($header);
	$client->soap_defencoding = 'UTF-8';
	$client->decode_utf8 = false;
	$xml = '<tem:Entrada>
				<tem:strEntrada>
         &lt;IM&gt;
  			&lt;CLAVE&gt;N1&lt;/CLAVE&gt; <!-- Clave de la póliza -->
  			&lt;POL&gt;'.$nPoliza.'&lt;/POL&gt; <!-- Numero de póliza -->
  			&lt;INCISO&gt;1&lt;/INCISO&gt; <!-- Incido que se desea imprimir -->
  			&lt;MOD&gt;AUTOSAGENTES&lt;/MOD&gt; <!-- Modulo al que pertenece la póliza -->
  			&lt;TPOAPP&gt;14&lt;/TPOAPP&gt; <!-- Identificador de la aplicación con la que se pretende imprimir -->
		&lt;/IM&gt;
				</tem:strEntrada>
			<tem:Entrada>';

	$client->call('ImpresionSegmentacion', $xml, 'http://tempuri.org/ACImpresion/', 'http://tempuri.org/ACImpresion/ImpresionSegmentacion', false, false, false, false);


			//-->echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
			//echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
			
			// Proceso para almacenamiento del XML obtenido
				$respuestaXML_Impresion = htmlspecialchars_decode($client->responseData, ENT_NOQUOTES);
				$cosasQuitaXml_Impresion = array('<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/"><s:Body><Salida xmlns="http://tempuri.org/"><strSalida>','</strSalida></Salida></s:Body></s:Envelope>',' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"');
				$cosasPonerXml_Impresion = array('','','');

				$respuestaXmlDepurada_Impresion = str_replace($cosasQuitaXml_Impresion, $cosasPonerXml_Impresion, $respuestaXML_Impresion);
				file_put_contents('pruebaImpresionAba.xml', $respuestaXmlDepurada_Impresion);
				$stringXml_Impresion = simplexml_load_string($respuestaXmlDepurada_Impresion);
				
/*
				foreach($stringXml_Impresion->RecuperaImpresionM15Result as $impresionUrls){
					
					$impresionArray = explode('|', $impresionUrls);
					foreach($impresionArray as $impresion){
						$tipoDocumento = substr($impresion,-15,1); 
						$urlLink = $impresion;
						$sqlInsertImpresion = "
							Insert Into
								`ws_impresion_poliza`
									(
										`idActividad`
										,`idCliente`
										,`idUsuario`
										,`companiaSeguros`
										,`poliza`
										,`tipoDocumento`
										,`urlLink`
									)
									VALUES
									(
										'$recId'
										,'$idCliente'
										,'$Usuario'
										,'$aseguradora'
										,'$nPoliza'
										,'$tipoDocumento'
										,'$urlLink'
									);
											  ";
						DreQueryDB($sqlInsertImpresion);
					} // Recorrido por los tipos de impresion
				} // Recorrido por la Poliza a imprimir
*/

					} // if put True

		
		} //Finalizamos el proceso de impresion por que no hay error en la poliza
	break;
	
	//* 3
	default:
		if(mysql_num_rows(DreQueryDB("Select * From `actividades_emision` Where `idActividad` = '$idActividad' And `tipoEmisiones` = '$tipoEmisiones'"))){
		$sqlUpdateFormularioEmisiones = 	"
			Update `actividades_emision`
				Set
					`estatus` = '$estatus'
					, `tipoVehiculo` = '$tipoVehiculo'
					, `marca` = '$marca'
					, `modelo` = '$modelo'
					, `year` = '$year'
					, `placas` = '$placas'
					, `numero_serie_niv` = '$numero_serie_niv'
					, `numero_motor` = '$numero_motor'
					, `tipo_uso` = '$tipo_uso'
					, `estado` = '$estado'
					, `remolque` = '$remolque'
					, `dolly` = '$dolly'
					, `segundo_remolque` = '$segundo_remolque'
					, `tipo_descripcion_mercancia` = '$tipo_descripcion_mercancia'
					, `comentarios` = '$comentarios'
				Where
					`idActividad` = '$idActividad' And `tipoEmisiones` = '$tipoEmisiones'
								";	
		DreQueryDB($sqlUpdateFormularioEmisiones);
		} else {
		$sqlInsertFormularioEmisiones = 	"
			Insert Into `actividades_emision` 
				(
					`idActividad`
					,`tipoEmisiones`
					,`estatus`
					,`tipoVehiculo`
					,`marca`
					,`modelo`
					,`year`
					,`placas`
					,`numero_serie_niv`
					,`numero_motor`
					,`tipo_uso`
					,`estado`
					,`remolque`
					,`dolly`
					,`segundo_remolque`
					,`tipo_descripcion_mercancia`
					,`comentarios`
				) 
				VALUES 
				(
					'$idActividad'
					,'$tipoEmisiones'
					,'$estatus'
					,'$tipoVehiculo'
					,'$marca'
					,'$modelo'
					,'$year'
					,'$placas'
					,'$numero_serie_niv'
					,'$numero_motor'
					,'$tipo_uso'
					,'$estado'
					,'$remolque'
					,'$dolly'
					,'$segundo_remolque'
					,'$tipo_descripcion_mercancia'
					,'$comentarios'
				)
								";
		DreQueryDB($sqlInsertFormularioEmisiones);
		}

	break;
	
} // Switch Aseguradora

	$return = "../actividadesDetalle.php?recId=".$recId."&muestra=Formularios#Formularios";
	
	header("Location: $return");
}

// Guardar emisionesTerminar
if($_REQUEST['tipoGuardar'] == 'emisionesTerminar'){
	$sqlTerminarFormularioEmisiones = "
		Update 
			`actividades_emision`
		Set 
			`estatus`='1'
		Where 
			`idActividad` = '$idActividad'
			And 
			`tipoEmisiones` = '$tipoEmisiones'
											";
	DreQueryDB($sqlTerminarFormularioEmisiones);
?>
<script language="javascript">
//	opener.location.reload();
	window.close();
</script> 
<?php
}

///----->

// TipoGuardar finalizarActividad
if($_REQUEST['tipoGuardar'] == 'finalizarActividadEmisionManual'){

	$fechaTermino = date('Y-m-d H:i:s');
	$sqlFinalizarActividad = "
		Update `actividades`
			Set
				`fin` = '1'
				,`Resultado` = '$Resultado'
				,`comenResultado` = '$comenResultado'
				,`fechaTermino` = '$fechaTermino'
			Where `idInterno` = '$idInterno'
							";
	DreQueryDB($sqlFinalizarActividad);

// - > Envio  Correo Notificacion Todos los involucrados	
			$sqlResponsableCorreo = "Select * From `usuarios` Where `VALOR` = '$usuarioCreacion'";
			$resResponsableCorreo = DreQueryDB($sqlResponsableCorreo);
			$rowResponsableCorreo = mysql_fetch_assoc($resResponsableCorreo);
			
			$sqlTitulo = "Select * From `actividades` Where `recId` = '$recId'";
			$resTitulo = DreQueryDB($sqlTitulo);
			$rowTitulo = mysql_fetch_assoc($resTitulo);

// --Envio  de Correo-- //
$sqlResponsables = "Select * From `actividades` Where `recId` = '$recId'";
	$resResponsas = DreQueryDB($sqlResponsables);
		$rowResposables = mysql_fetch_assoc($resResponsas);	
			$usuarioResponsableCreacion = $rowResposables['usuarioCreacion'];

$sqlResponsableUsuarioEmail = "Select * From `usuarios` Where `VALOR` = '$usuarioResponsableCreacion'";
	$resResponsableUsuarioEmail = DreQueryDB($sqlResponsableUsuarioEmail);
		$rowResposableUsuarioEmail = mysql_fetch_assoc($resResponsableUsuarioEmail);	
			$responsableEmailCreacion =  $rowResposableUsuarioEmail['Email'];


// Creacion de la Nueva Actividad del TipoEmision
	$recId = mysql_result(DreQueryDB("Select `valor`+1 From `configdre` Where `parametro` = 'folioActividad'"),0);
	DreQueryDB("Update `configdre` Set `valor` = '$recId' Where `parametro` = 'folioActividad'");
	$recId = "w".$recId;
	
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
			) 
			VALUES
			(
				'$recId'
				,'$rowResposables[idRef]'
				,'$rowResposables[tipo]'
				,'Emisi%F3n'
				,'AUTOS+INDIVIDUALES+NUEVOS'
				,'<p>Emision Directa Cotizacion</p>'
				,'Emisi&oacute;n - AUTOS INDIVIDUALES NUEVOS'
				,'$rowResposables[usuario]'
				,'$rowResposables[usuarioCreacion]'
				,'$rowResposables[usuario]'
				,'".date('Y-m-d H:i:s')."'
				,'".date('Y-m-d')."'
				,'$rowResposables[idInterno]'
			);
							 ";
	DreQueryDB($sqlInsertActividadEmision);
	$idInternoReturn = mysql_insert_id();

$sqlConsultaFormularioActividad = "
	Select * From 
		`actividades_formularios` 
	Where 
		`idActividad` = '$rowResposables[recId]'
								  ";
$resConsultaFormularioActividad = DreQueryDB($sqlConsultaFormularioActividad);
$rowConsultaFormularioActividad = mysql_fetch_assoc($resConsultaFormularioActividad);
	// Valorizacion de Variables
		$marcaEmision = $rowConsultaFormularioActividad['marca_auto'];
		$modeloEmision = $rowConsultaFormularioActividad['modelo_auto'];
		$yearEmision = $rowConsultaFormularioActividad['year_auto'];
		$tipoUsoEmision = $rowConsultaFormularioActividad['tipo_uso'];
		$estadoEmision = $rowConsultaFormularioActividad['estado'];
		
$sqlInsertActividaEmision = "
	Insert Into
		`actividades_emision` 
			(
				`idActividad`
				, `tipoEmisiones`
				, `estatus`
				, `marca`
				, `modelo`
				, `year`
				, `tipoVehiculo`
				, `placas`
				, `numero_serie_niv`
				, `numero_motor`
				, `tipo_uso`
				, `estado`
				, `remolque`
				, `dolly`
				, `segundo_remolque`
				, `tipo_descripcion_mercancia`
				, `comentarios`
			)
			VALUES 
			(
				'$recId'
				, 'autos'
				, '0'
				, '$marcaEmision'
				, '$modeloEmision'
				, '$yearEmision'
				, ''
				, ''
				, ''
				, ''
				, '$tipoUsoEmision'
				, '$estadoEmision'
				, ''
				, ''
				, ''
				, ''
				, ''
			);
							";
	DreQueryDB($sqlInsertActividaEmision);

//Variables del envio de correo
$para = $responsableEmail; // Correo al que mandamos
$copia = $responsableEmailCreacion; // Correo al que se copia en envio COBRANZA
$copiaOculta = "juanjose@dre-learning.com";  // Correo al que se copia oculto el envio 
$asunto = "Termino Actividad CAPSYS Agente Capital";
$desde = "Sistema CRM Web <sistemas@agentecapital.com>";

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

// Linea de envio del correo
	//$correo = @mail($email_to, $email_subject, $email_message, $headers);  
	DreMail($desde,$para,$copia,$copiaOculta,$asunto,$message,$fileAdjunto,$nameAdjunto);
// --Envio  de Correo-- //	
	
		//actividadVer.php?recId=w1478&ver=7&idInterno=4332
		//-->actividadVer.php?recId=w1478&ver=5&idInterno=4332
		$return = "../actividadVer.php?recId=".$recId."&ver=5&idInterno=".$idInternoReturn;
		header("Location: $return");
}


//finalizarActividadEmisionWs
if($_REQUEST['tipoGuardar'] == 'finalizarActividadEmisionWs'){
	$fechaTermino = date('Y-m-d H:i:s');
	$sqlFinalizarActividad = "
		Update `actividades`
			Set
				`fin` = '1'
				,`Resultado` = '$Resultado'
				,`comenResultado` = '$comenResultado'
				,`fechaTermino` = '$fechaTermino'
			Where `idInterno` = '$idInterno'
							";
	DreQueryDB($sqlFinalizarActividad);

// - > Envio  Correo Notificacion Todos los involucrados	
			$sqlResponsableCorreo = "Select * From `usuarios` Where `VALOR` = '$usuarioCreacion'";
			$resResponsableCorreo = DreQueryDB($sqlResponsableCorreo);
			$rowResponsableCorreo = mysql_fetch_assoc($resResponsableCorreo);
			
			$sqlTitulo = "Select * From `actividades` Where `recId` = '$recId'";
			$resTitulo = DreQueryDB($sqlTitulo);
			$rowTitulo = mysql_fetch_assoc($resTitulo);

// --Envio  de Correo-- //
$sqlResponsables = "Select * From `actividades` Where `recId` = '$recId'";
	$resResponsas = DreQueryDB($sqlResponsables);
		$rowResposables = mysql_fetch_assoc($resResponsas);	
			$usuarioResponsableCreacion = $rowResposables['usuarioCreacion'];

$sqlResponsableUsuarioEmail = "Select * From `usuarios` Where `VALOR` = '$usuarioResponsableCreacion'";
	$resResponsableUsuarioEmail = DreQueryDB($sqlResponsableUsuarioEmail);
		$rowResposableUsuarioEmail = mysql_fetch_assoc($resResponsableUsuarioEmail);	
			$responsableEmailCreacion =  $rowResposableUsuarioEmail['Email'];


// Creacion de la Nueva Actividad del TipoEmision
	$recId = mysql_result(DreQueryDB("Select `valor`+1 From `configdre` Where `parametro` = 'folioActividad'"),0);
	DreQueryDB("Update `configdre` Set `valor` = '$recId' Where `parametro` = 'folioActividad'");
	$recId = "w".$recId;
	
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
			) 
			VALUES
			(
				'$recId'
				,'$rowResposables[idRef]'
				,'$rowResposables[tipo]'
				,'Emisi%F3n'
				,'AUTOS+INDIVIDUALES+NUEVOS'
				,'<p>Emision Directa Cotizacion</p>'
				,'Emisi&oacute;n - AUTOS INDIVIDUALES NUEVOS'
				,'$rowResposables[usuario]'
				,'$rowResposables[usuarioCreacion]'
				,'$rowResposables[usuarioCreacion]'
				,'".date('Y-m-d H:i:s')."'
				,'".date('Y-m-d')."'
				,'$rowResposables[idInterno]'
			);
							 ";
	DreQueryDB($sqlInsertActividadEmision);
	$idInternoReturn = mysql_insert_id();

// Creacion de la emision por WS

//

//Variables del envio de correo
$para = $responsableEmail; // Correo al que mandamos
$copia = $responsableEmailCreacion; // Correo al que se copia en envio COBRANZA
$copiaOculta = "juanjose@dre-learning.com";  // Correo al que se copia oculto el envio 
$asunto = "Termino Actividad CAPSYS Agente Capital";
$desde = "Sistema CRM Web <sistemas@agentecapital.com>";

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

// Linea de envio del correo
	//$correo = @mail($email_to, $email_subject, $email_message, $headers);  
	DreMail($desde,$para,$copia,$copiaOculta,$asunto,$message,$fileAdjunto,$nameAdjunto);
// --Envio  de Correo-- //	
	
		// actividadVer.php?recId=w1375&ver=4&idInterno=3824&doc=2
		$return = "../actividadVer.php?recId=".$recId."&ver=4&idInterno=".$idInternoReturn."&doc=2";
		header("Location: $return");
}

DreDesconectarDB($conexion);
?>