<?php
extract($_REQUEST);
include_once('../config/config.php');
include_once('../config/funcionesDre.php');

	$conexion = DreConectarDB();
		
// Enviar Correo
if($_REQUEST['tipoEnvio'] == 'CorreoCliente'){
	//-->echo "<pre>";
		//-->print_r($_REQUEST);
	//-->echo "</pre>";

	$paraCorreo = "";
	foreach ($paCorreo as $Pcorreo){	
		 $paraCorreo .= $Pcorreo.", ";
	}

	$desdeCorreo = $_SESSION['WebDreTacticaWeb2']['Nombre']."<do-not-reply@capsys.com.mx>"; //crm@agentecapital.com
//	$paraCorreo;
	$asuntoCorreo = "www.capsys.com.mx Envio de Informacion Importante Solicitada";
	$mensajeCorreo = "Estimado cliente: <br />";	
// ---
if(isset($AddCorreo)){
	$contadorDocumentos = 0;
	$totalDocumentos = count($AddCorreo);
	foreach ($AddCorreo as $Acorreo){
		
		$contadorDocumentos++;
		
		$sqlInformacionAdjunto = "Select * From `imagenes` Where `NO_ARCHIVO` = '$Acorreo'";
		$resInformacionAdjunto = DreQueryDB($sqlInformacionAdjunto);
		$rowInformacionAdjunto = mysql_fetch_assoc($resInformacionAdjunto);
		
		if(strstr($rowInformacionAdjunto['EXTENSION'],'.')){
			$EXTENSION = $rowInformacionAdjunto['EXTENSION'];
		} else {
				$EXTENSION = ".".$rowInformacionAdjunto['EXTENSION'];
		}
		
		$archivoAdjunto = "http://agentecapital.ddns.net:5280/".$Acorreo.$EXTENSION;
		$mensajeCorreo.= '
			<br />
			En la siguiente liga
			<a href="'.$archivoAdjunto.'" title="Clic Aqu&iacute;" target="_blank"><strong>Click Aqu&iacute; '.$contadorDocumentos.' de '.$totalDocumentos.'</strong></a>
			podr&aacute; encontrar la respuesta a su solicitud
			<br />
					 ';
	} // foreach
}
// ---
if(isset($urlComparativoENvia)){
			$mensajeCorreo.= '
			<br />
			En la siguiente liga
			<a href="'.$urlComparativoENvia.'" title="Clic Aqu&iacute;" target="_blank"><strong>Click Aqu&iacute;</strong></a>
			podr&aacute; encontrar la respuesta a su solicitud
			<br />
					 ';
}

	$mensajeCorreo.= "<br />".$textoCorreo."<br /><br />";
	
	$mensajeCorreo.= "Gracias por su confianza, le garantizamos que somos su mejor elecci&oacute;n.<br /><br />";
	$mensajeCorreo.= "Para cualquier duda o aclaraci&oacute;n, favor de comunicarse con su Agente;<br />";
	$mensajeCorreo.= "Nombre Agente: ".$_SESSION['WebDreTacticaWeb2']['Nombre']."<br />";
	$mensajeCorreo.= "Tel&eacute;fono Agente: ".$_SESSION['WebDreTacticaWeb2']['Telefono']."<br />";
	$mensajeCorreo.= "Correo Agente: ".$_SESSION['WebDreTacticaWeb2']['Email']." <br /><br />";

	$mensajeCorreo.= "<font style='text-align:center'>";
	$mensajeCorreo.= "<img src='http://capsys.com.mx/img/logo_header.png' width='226' height='108' alt='logo_agente_capital' /><br /><br />";
	$mensajeCorreo.= "Esta es una empresa de:<br />";
	$mensajeCorreo.= "<strong>GAP Agente de Seguros y de Fianzas SA de CV</strong><br />";
	$mensajeCorreo.= "Calle 27 No. 164-C por 36 y 38 Col. Buenavista<br />";
	$mensajeCorreo.= "M&eacute;rida, Yucat&aacute;n<br />";
	$mensajeCorreo.= "Tel&eacute;fonos: 926 00 63<br />";
	$mensajeCorreo.= "Lada sin costo: 01800 987 22 01<br />";
	$mensajeCorreo.= "<a href='http://www.agentecapital.com'>www.agentecapital.com</a><br />";
	$mensajeCorreo.= "<img src='http://capsys.com.mx/img/redes_sociales/facebook.png' width='20' height='20' alt='logo_agente_capital' />";
	$mensajeCorreo.= "<img src='http://capsys.com.mx/img/redes_sociales/twitter.png' width='20' height='20' alt='logo_agente_capital' />";
	$mensajeCorreo.= "@agentecapital<br />";
	$mensajeCorreo.= "</font>";
	DreMail($desdeCorreo,$paraCorreo,$_SESSION['WebDreTacticaWeb2']['Email'],'',$asuntoCorreo,$mensajeCorreo,'','');
//-->mailDre($desdeCorreo,$paraCorreo,$_SESSION['WebDreTacticaWeb2']['Email'],'',$asuntoCorreo,$mensajeCorreo,'','');	
//-->DreMail($desde,$para,$copia,$copiaOculta,$asunto,$mensaje,$fileAdjunto,$nameAdjunto);
	"clienteEnviarCorreo.php?CLAVE=000000W610#CorreosCliente";
	"clienteEnviarCorreo.php?CLAVE=000000W610&adjuntoCorreo=W000000293&regreso=clienteDocumentos#DocumentosAdjuntos";
	//-->$return = "../empresasEnviarCorreo.php?idEmpresa=".$idEmpresa;
	$return = "../clienteEnviarCorreo.php?CLAVE=".$CLAVE;
	if(isset($adjuntoCorreo)){ $return.= "&adjuntoCorreo=".$adjuntoCorreo; }
	if(isset($regreso)){ $return.= "&regreso=clienteDocumentos";}
	"#CorreosCliente";

	if($popup == "true"){
	?>
    <script>
	alert('Correo Enviado Con Exito !!!');
	window.close();
	</script>
    <?php
	} else {
	?>
    <script>
	alert('Correo Enviado Con Exito !!!');
	window.open('<?php echo $return; ?>','_self');
	</script>
    <?php
	}
/**/
}

// tipoEnvio 
if($_REQUEST['tipoEnvio'] == 'correoMasivo'){
	switch($para){
		case "masivos":
			if(isset($paCorreo)){ // Validamos que no llegue vacio el arreglo de usuarios
				foreach($paCorreo as $tipoEnvio){  // Recorremos el Arregloa de usuarios ubicando los envios globales
					$sqlMasivoGrupo = "
						Select * From 
							`correos_email`
						Where 
							(`tipoCorreo` = '$tipoEnvio' And `correo` != '')							
										  ";
					$resMasivoGrupo = DreQueryDB($sqlMasivoGrupo);
					$rowMasivoGrupo = mysql_fetch_assoc($resMasivoGrupo);
						$paCorreo[] = $rowMasivoGrupo['idCorreo'];
				} // fin - foreach --> Recorremos el Arregloa de usuarios ubicando los envios globales
				$paCorreo = array_unique($paCorreo);
			} // fin - if --> Validamos que no llegue vacio el arreglo de usuarios
		break;

		case "clientes":
			if(isset($paCorreo)){ // Validamos que no llegue vacio el arreglo de usuarios
				foreach($paCorreo as $tipoEnvio){  // Recorremos el Arregloa de usuarios ubicando los envios globales
					$sqlClientesSubRamo = "
						Select * From 
							`cliramos` Inner Join `empresas` 
							On 
							`cliramos`.`CLAVE_CLIENTE` = `empresas`.`CLAVE` Inner Join `contactos` 
							On 
							`empresas`.`CLAVE` = `contactos`.`CLAVE` 
						Where 
							(`SUBRAMO` = '$tipoEnvio' And `contactos`.`EMAIL` != '')
							Or
							(`RAZON_SOCIAL` = '$tipoEnvio' And `empresas`.`email` != '')							
										  ";
					$resClientesSubRamo = DreQueryDB($sqlClientesSubRamo);
					$rowClientesSubRamo = mysql_fetch_assoc($resClientesSubRamo);
						$paCorreo[] = $rowClientesSubRamo['idContacto'];
				} // fin - foreach --> Recorremos el Arregloa de usuarios ubicando los envios globales
				$paCorreo = array_unique($paCorreo);
			} // fin - if --> Validamos que no llegue vacio el arreglo de usuarios
		break;
		
		case "usuarios":
			if(isset($paCorreo)){ // Validamos que no llegue vacio el arreglo de usuarios
				foreach($paCorreo as $tipoEnvio){  // Recorremos el Arregloa de usuarios ubicando los envios globales

					$tipoEnvioArray = explode('-',$tipoEnvio);
					
					switch ($tipoEnvioArray[0]){ // Tipo de envio global
					//todosVendedoresPro-0000040707
					
				case "todos":
					$sqlTodosEmail = "
						Select * From 
							`usuarios` 
						Where
							`Email` != ''
									 ";
					$resTodosEmail = DreQueryDB($sqlTodosEmail);
					while($rowTodosEmail = mysql_fetch_assoc($resTodosEmail)){
						$paCorreo[] = $rowTodosEmail['VALOR'];
					}
				break;
		// ----
				case "todosUsuarios":
					$sqlTodosUsuarios = "
	Select 
		*
		, `usuarios`.`NOMBRE` As `nombreCorto`
		, `catalogo_perfiles`.`NOMBRE` As `nombreTipo`
		, `usuarios`.`EMAIL` As `correoInvitado`
	From 
		`usuarios` Inner Join `catalogo_perfiles`
		On 
		`usuarios`.`TIPO` = `catalogo_perfiles`.`TIPO` 
	Where
		(
			`usuarios`.`EMAIL` != ''
		)
		And
		(
			`catalogo_perfiles`.`TIPO` Not Like '2%'
			And
			`catalogo_perfiles`.`TIPO` Not Like '30%'
			And
			`catalogo_perfiles`.`TIPO` Not Like '31%'
			And
			`catalogo_perfiles`.`TIPO` Not Like '32%'
			And
			`catalogo_perfiles`.`TIPO` Not Like '33%'
			And
			`catalogo_perfiles`.`TIPO` Not Like '40%'
		)
	Order By
		`usuarios`.`NOMBRE` Asc
									 ";
					$resTodosUsuarios = DreQueryDB($sqlTodosUsuarios);
					while($rowTodosUsuarios = mysql_fetch_assoc($resTodosUsuarios)){
						$paCorreo[] = $rowTodosUsuarios['VALOR'];
					}
				break;
		// ----
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
						$paCorreo[] = $rowGerentesEmail['VALOR'];
					}
				break;
		// ----
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
						$paCorreo[] = $rowEjecutivosEmail['VALOR'];
					}
				break;
		// ----
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
				$paCorreo[] = $rowPromotoresEmail['VALOR'];
			}
				break;
		// ----
				case "todosVendedoresLibres":
					$sqlTodosVendedoresLibres = "
	Select 
		*
		, `usuarios`.`NOMBRE` As `nombreCorto`
		, `catalogo_perfiles`.`NOMBRE` As `nombreTipo`
		, `usuarios`.`EMAIL` As `correoInvitado`
	From 
		`usuarios` Inner Join `catalogo_perfiles`
		On 
		`usuarios`.`TIPO` = `catalogo_perfiles`.`TIPO` 
	Where
		(
			`usuarios`.`EMAIL` != ''
		)
		And
		(
			`catalogo_perfiles`.`TIPO` Like '40%'
			And
			(
			`usuarios`.`PROMOTOR` = '0000000000' Or `usuarios`.`PROMOTOR` = '0000007851'
			)
		)
	Order By
		`usuarios`.`NOMBRE` Asc
												";
					$resTodosVendedoresLibres = DreQueryDB($sqlTodosVendedoresLibres);
					while($rowTodosVendedoresLibres = mysql_fetch_assoc($resTodosVendedoresLibres)){
						$paCorreo[] = $rowTodosVendedoresLibres['VALOR'];
					}
				break;
		// ----
				case "todosVendedoresPro":
					$sqlTodosVendedoresPro = "
	Select 
		*
		, `usuarios`.`NOMBRE` As `nombreCorto`
		, `catalogo_perfiles`.`NOMBRE` As `nombreTipo`
		, `usuarios`.`EMAIL` As `correoInvitado`
	From 
		`usuarios` Inner Join `catalogo_perfiles`
		On 
		`usuarios`.`TIPO` = `catalogo_perfiles`.`TIPO` 
	Where
		(
			`usuarios`.`EMAIL` != ''
		)
		And
		(
			`catalogo_perfiles`.`TIPO` Like '40%'
			And
			`usuarios`.`PROMOTOR` = '$tipoEnvioArray[1]'
		)
	Order By
		`usuarios`.`NOMBRE` Asc
												";
					$resTodosVendedoresPro = DreQueryDB($sqlTodosVendedoresPro);
					while($rowTodosVendedoresPro = mysql_fetch_assoc($resTodosVendedoresPro)){
						$paCorreo[] = $rowTodosVendedoresPro['VALOR'];
					}
				break;
		// ----
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
						$paCorreo[] = $rowVendedoresEmail['VALOR'];
					}
				break;
					} //  fin - swtich --> Tipo de envio global
				} // fin - foreach --> Recorremos el Arregloa de usuarios ubicando los envios globales
				$paCorreo = array_unique($paCorreo);
			} //fin - if -->  Validamos que no llegue vacio el arreglo de usuarios
		break;
	}
	
// --->
	if(isset($paCorreo)){		
			switch($para){

				case "masivos":
		foreach($paCorreo as $invitado){
			$sqlParaForeach = "
				Select `correo` As `Email` From 
					`correos_email` 
				Where 
					`idCorreo` = '$invitado'
							 ";
			$resParaForeach=DreQueryDB($sqlParaForeach);
			$rowParaForeach=mysql_fetch_assoc($resParaForeach);
									
			// Enviar Correo de Notificacion
			if(isset($desdeSelect) || $desdeSelect != ""){ $desde = $desdeSelect; } else { $desde = "CAPSYS Web <do-not-reply@capsys.com.mx>"; }
			$para = $rowParaForeach['Email'];
			$copia = "";
			$copiaOculta = "juanjose@dre-learning.com";
			$asunto = $asunto;
			$mensaje = str_replace ('"/img/userfiles/', '"http://capsys.com.mx/img/userfiles/' , $mensajeEmail);
			
			//DreMail($desde,$para,$copia,$copiaOculta,$asunto,$mensaje,'','');

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
		}// fin foreach --> Recorremos el Arregloa de usuarios ubicando los envios globales
				break;
				
				case "clientes":
				case "usuarios":
		foreach($paCorreo as $invitado){
			$sqlParaForeach = "
				Select `Email` From 
					`usuarios` 
				Where 
					`VALOR` = '$invitado'
				Union
				Select `EMAIL` As `Email` From
					`contactos`
				Where
					`idContacto` = '$invitado';
							 ";
			$resParaForeach=DreQueryDB($sqlParaForeach);
			$rowParaForeach=mysql_fetch_assoc($resParaForeach);
									
			// Enviar Correo de Notificacion
			if(isset($desdeSelect) || $desdeSelect != ""){ $desde = $desdeSelect; } else { $desde = "CAPSYS Web <do-not-reply@capsys.com.mx>"; }
			$para = $rowParaForeach['Email'];
			$copia = "";
			$copiaOculta = "juanjose@dre-learning.com";
			$asunto = $asunto;
			$mensaje = str_replace ('"/img/userfiles/', '"http://capsys.com.mx/img/userfiles/' , $mensajeEmail);
			
			//DreMail($desde,$para,$copia,$copiaOculta,$asunto,$mensaje,'','');

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
		}// fin foreach --> Recorremos el Arregloa de usuarios ubicando los envios globales
				break;
			}

	}// fin if --> Validamos que no llegue vacio el arreglo de usuarios
	
	$return = "../mailMasivo.php";
?>
	<script>
		alert('Envio Masivo Programado !!!');
		window.open('<?php echo $return; ?>','_self');
	</script>
<?php

}
DreDesconectarDB($conexion);
?>
