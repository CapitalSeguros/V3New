<?php
session_start();
extract($_REQUEST);
if(	$seccion != "index"){
	if(!isset($_SESSION['WebDreTacticaWeb2'])){ header("Location: index.php"); }
	if(!isset($_SESSION['WebDreTacticaWeb2']['Usuario'])){ header("Location: index.php"); }
}

include('../config/funcionesDre.php');
	$conexion = DreConectarDB();

// tipoAgregar Actividad
if($_REQUEST['tipoAgregar'] == 'Actividad'){

//** Consulta Info Vendedor
	$sqlConsultaInfoVendedor = "
		Select * From
			`usuarios`
		Where
			`VALOR` = '$VENDEDOR'
			Or
			`VALOR` = '$IDUsuarioCreacion'
							   ";
	$resConsultaInfoVendedor = DreQueryDB($sqlConsultaInfoVendedor);
	$rowConsultaInfoVendedor = mysql_fetch_assoc($resConsultaInfoVendedor);

	if($_SESSION['WebDreTacticaWeb2']['Sucursal'] != $rowConsultaInfoVendedor['SUCURSAL']){
		//echo "New=>".
		$SUCURSAL = $_SESSION['WebDreTacticaWeb2']['Sucursal'];
	} else {
		//echo "Old=>".
		$SUCURSAL = $rowConsultaInfoVendedor['SUCURSAL'];
	}

//** Agregar a un prospectoNuevo	
	if($tipoCliente == "NEW"){
		// Generacion de la Clave Cliente Nuevo	
		$CLAVEWEB = "W".mysql_result(mysql_query("Select `valor` From `configdre` Where `parametro`  = 'ClaveEmpresas'"),0);
		mysql_query("Update `configdre` Set `valor` = (`valor`+1) Where `parametro` = 'ClaveEmpresas'") or die(mysql_error());
		$CLAVE = str_pad($CLAVEWEB, 10, '0',0);

		// Limpieza, Calculo y Creacion de Valores Campos
		$RAZON_SOCIAL = rtrim(ltrim($NOMBRES,' '),'')." ".rtrim(ltrim($APELLIDO_PATERNO,' '),' ')." ".rtrim(ltrim($APELLIDO_MATERNO,' '),' ');
		$EDAD = calculaedad($FECHA_NACIMIENTO);
		
		$PROMOTOR = $rowConsultaInfoVendedor['PROMOTOR'];
		//*Original* $SUCURSAL = $rowConsultaInfoVendedor['SUCURSAL'];

		$DIRECCION = (isset($CALLE) && $CALLE != "")? 'Calle: '.$CALLE:'';
		$DIRECCION.= " ";
		$DIRECCION.= (isset($REFERENCIA) && $REFERENCIA != "")? 'X '.$REFERENCIA:'';
		$DIRECCION.= " ";
		$DIRECCION.= (isset($REFERENCIA2) && $REFERENCIA2 != "")? 'y '.$REFERENCIA2:'';
		$DIRECCION.= " ";
		$DIRECCION.= (isset($NOEXTERIOR) && $NOEXTERIOR != "")? 'No. Ext: '.$NOEXTERIOR:'';
		$DIRECCION.= " ";
		$DIRECCION.= (isset($NOINTERIOR) && $NOINTERIOR != "")? 'No. Int: '.$NOEXTERIOR:'';
		$DIRECCION.= " ";
		$DIRECCION.= (isset($COLONIA) && $COLONIA != "")? 'Col. : '.$COLONIA:'';
		$DIRECCION.= " ";
		$DIRECCION.= (isset($CODIGO_POSTAL) && $CODIGO_POSTAL != "")? 'C.P. : '.$CODIGO_POSTAL:'';
		
		$sqlInsertNewProspecto = "
			Insert Into 
				`empresas` 
					(
						`CLAVE`
						, `APELLIDO_PATERNO`
						, `APELLIDO_MATERNO`
						, `NOMBRES`
						, `RAZON_SOCIAL`
						, `TIPO_PERSONA`
						, `RFC`
						, `CURP`
						, `CALLE`
						, `NOEXTERIOR`
						, `NOINTERIOR`
						, `REFERENCIA`
						, `REFERENCIA2`
						, `COLONIA`
						, `CODIGO_POSTAL`
						, `LOCALIDAD`
						, `MUNICIPO`
						, `ESTADO`
						, `PAIS`
						, `FECHA_NACIMIENTO`
						, `NACIONALIDAD`
						, `NIVEL_ESTUDIOS`
						, `AUTOMOVIL`
						, `EDAD`
						, `ESTADO_CIVIL`
						, `GENERO`
						, `VENDEDOR`
						, `LIMITE_FIANZA`
						, `TELEFONO_PARTICULAR`
						, `TELEFONO_OFICINA`
						, `TELEFONO_MOVIL`
						, `CLAVEWEB`
						, `SUCURSAL`
						, `PROMOTOR`
						, `TIPO_REGISTRO`
						, `fechaCreacion`
						, `actualizado`
						, `observaciones`
						, `Club_Cap`
						, `Poliza_Electronica`
						, `estatusCliente`
					) 
					VALUES
					(
						'$CLAVE'
						,'".strtoupper($APELLIDO_PATERNO)."'
						,'".strtoupper($APELLIDO_MATERNO)."'
						,'".strtoupper($NOMBRES)."'
						,'".strtoupper($RAZON_SOCIAL)."'
						,'$TIPO_PERSONA'
						,'".strtoupper($RFC)."'
						,'".strtoupper($CURP)."'
						,'$CALLE'
						,'$NOEXTERIOR'
						,'$NOINTERIOR'
						,'$REFERENCIA'
						,'$REFERENCIA2'
						,'$COLONIA'
						,'$CODIGO_POSTAL'
						,'$LOCALIDAD'
						,'$MUNICIPIO'
						,'$ESTADO'
						,'$PAIS'
						,'$FECHA_NACIMIENTO'
						,'$NACIONALIDAD'
						,'$NIVEL_ESTUDIOS'
						,'$AUTOMOVIL'
						,'$EDAD'
						,'$ESTADO_CIVIL'
						,'$GENERO'
						,'$VENDEDOR'
						,'$LIMITE_FIANZA'
						,'$TELEFONO_PARTICULAR'
						,'$TELEFONO_OFICINA'
						,'$TELEFONO_MOVIL'
						,'$CLAVEWEB'
						,'$SUCURSAL'
						,'$PROMOTOR'
						,'PR'
						, CURRENT_TIMESTAMP
						,'1'
						,'$observaciones'
						,'$Club_Cap'
						,'$Poliza_Electronica'
						,'A'
					);
								 ";
		DreQueryDB($sqlInsertNewProspecto);

		$sqlInsertNewProspectoContacto = "
			Insert Into
				`contactos`
				(
					`CLAVE`
					,`TIPO`
					,`NOMBRE`
					,`EMAIL`
					,`TELEFONO`
					,`DIRECCION`
					,`actualizado`
				)
				Values
				(
					'$CLAVE'
					,'CONTACTO1'
					,'".strtoupper($RAZON_SOCIAL)."'
					,'$EMAIL'
					,'$TELEFONO_MOVIL'
					,'$DIRECCION'
					,'1'
				);
										 ";
		DreQueryDB($sqlInsertNewProspectoContacto);
		$idRef = $CLAVE;
	}

//** Agregar a un contactoNuevo
	if($tipoContacto == "NewContacto"){
		// Generacion del Tipo Contacto Nuevo
		$sqlInsertNewContacto = "
			Insert Into
				`contactos`
				(
					`CLAVE`
					,`TIPO`
					,`NOMBRE`
					,`EMAIL`
					,`TELEFONO`
					,`DIRECCION`
					,`VENDEDOR`
					,`promotor`
					,`SUCURSAL`
					,`fechaCreacion`
				)
				Value
				(
					'$idRef'
					,'$tipoContactoNew'
					,'$NombreContactoNew'
					,'$EmailContactoNew'
					,'$TelefonoContactoNew'
					,'$DireccionContactoNew'
					,'$IDUsuarioCreacion'
					,'".$rowConsultaInfoVendedor['PROMOTOR']."'
					,'$SUCURSAL'
					,'".date('Y-m-d G:i:s')."'					
				)
								";
		DreQueryDB($sqlInsertNewContacto);
		$TIPO = $tipoContactoNew;
	}

//**  Validamos si tiene Grupo el Usuario
	$sqlUsuarioGrupo = "
		Select * From 
			`usuario_grupo`
		Where 
			`Usuario` = '$IDUsuarioCreacion'
					   ";
if(!isset($Ramo)){ $Ramo = urlencode($RAMO); } // Validacion Ramo
	if(mysql_num_rows(DreQueryDB($sqlUsuarioGrupo)) <= 0){

		switch($Actividad){			
			/* 1 */
			case "Cotizaci%F3n": // Cotizacion
			/* 2 */
			case "Emisi%F3n": // Emision	
			/* 4 */
			case "Cambio+de+Conducto":
			/* 5 */				
			//**  case "Endoso": // Endoso
			/* 6 */
			case "Cancelacion":  // Cancelacion
			/* 8 */
			case "Otras+Actividades": // Otras Actividades
				$sqlTipoRamo = "
					Select
						`ramosconfigdre`.`nombre` As `ramoTitulo`
						, `usuarios`.`Email` As `ramoEmail`
						, `usuarios`.`VALOR` As `usuario`
					From	 
						`ramosconfigdre` Inner Join `usuario_ramo`
						On
						`ramosconfigdre`.`ramo_id` = `usuario_ramo`.`ramo` Inner Join `usuarios`
						On 	
						`usuario_ramo`.`Usuario` = `usuarios`.`VALOR`
					Where
						`ramosconfigdre`.`nombre` = '".urldecode($Ramo)."'
							   ";
				$resTipoRamo = DreQueryDB($sqlTipoRamo);
				$rowTipoRamo = mysql_fetch_assoc($resTipoRamo);
		
					$ramoTitulo =  $rowTipoRamo['ramoTitulo']; // Variable Calculada
					$ramoEmail = $rowTipoRamo['ramoEmail']; // Variable Calculada
					$usuario = $rowTipoRamo['usuario']; // Variable Calculada
					
					if(!isset($_REQUEST['Responsable']) || $_REQUEST['Responsable']==""){
						$Responsable = $rowTipoRamo['usuario'];
						$usuarioBolita = $Responsable;
					} else {
						$Responsable = $_REQUEST['Responsable'];
						$usuarioBolita = $Responsable;
					}				
			break;
			
			/* 3 */
			case "Diligencias": // Diligencias
				$usuario = "0000522661"; // Variable Calculada // 0000522600
				$ramoTitulo =  urldecode($Ramo); //$rowTipoRamo['ramoTitulo']; // Variable Calculada
				$ramoEmail = DreCorreoUsuario($usuario); //$rowTipoRamo['ramoEmail']; // Variable Calculada
				$Responsable = $usuario;
				$usuarioBolita = $Responsable;
				//echo "Lore 0000522600";
			break;

			/* 7 */	
			case "Siniestros": // Siniestros
				$usuario = "0000522626"; // "0000028947"; // Variable Calculada
				$ramoTitulo =  urldecode($Ramo); //$rowTipoRamo['ramoTitulo']; // Variable Calculada
				$ramoEmail = DreCorreoUsuario($usuario); //$rowTipoRamo['ramoEmail']; // Variable Calculada
				$Responsable = $usuario;
				$usuarioBolita = $Responsable;
				//echo "Erick 0000028947";
			break;

			/* 9 */
			case "Aclaraci%F3n+de+Comisiones": // Aclaracion de Comisiones		
				$usuario = "0000028949"; // Variable Calculada
				$ramoTitulo =  urldecode($Ramo); //$rowTipoRamo['ramoTitulo']; // Variable Calculada
				$ramoEmail = DreCorreoUsuario($usuario); //$rowTipoRamo['ramoEmail']; // Variable Calculada
				$Responsable = $usuario;
				$usuarioBolita = $Responsable;
				//echo "Sandra 0000028949";
			break;

			/* 10 */
			case "Solicitud+de+tarjetas+Club+Cap": // Solicitud de Tarjetas Club Cap
				$usuario = "0000028950"; // Variable Calculada
				$ramoTitulo =  urldecode($Ramo); //$rowTipoRamo['ramoTitulo']; // Variable Calculada
				$ramoEmail = DreCorreoUsuario($usuario); //$rowTipoRamo['ramoEmail']; // Variable Calculada
				$Responsable = $usuario;
				$usuarioBolita = $Responsable;
				//echo "Silvia 0000028950";
			break;
			
			/* 11 */
			case "Pago+Cobranza": // Solicitud de Tarjetas Club Cap
				$usuario = "0000039568"; // Variable Calculada
				$ramoTitulo =  urldecode($Ramo); //$rowTipoRamo['ramoTitulo']; // Variable Calculada
				$ramoEmail = DreCorreoUsuario($usuario); //$rowTipoRamo['ramoEmail']; // Variable Calculada
				$Responsable = $usuario;
				$usuarioBolita = $Responsable;
				//echo "Anilu 0000039568";
			break;
		}

		$actividadInterno = $Actividad;
		$ramoInterno = urlencode($ramoTitulo);	
	} else {
		$sqlDatosGrupo = "
			Select * From
				`usuario_grupo`
			Where
				`Usuario` = '$IDUsuarioCreacion'
						 ";
		$resDatosGrupo = DreQueryDB($sqlDatosGrupo);
		$rowDatosGrupo = mysql_fetch_assoc($resDatosGrupo);
		
		$Responsable = $rowDatosGrupo['Ejecutivo'];
		$usuarioBolita = $IDUsuarioCreacion;
		
		$sqlTipoRamo = "
			Select 
				`ramosconfigdre`.`nombre` As `ramoTitulo`
				, `usuarios`.`Email` As `ramoEmail`
				, `usuarios`.`VALOR` As `usuario`
			From	 
				`ramosconfigdre` Inner Join `usuario_ramo`
				On
				`ramosconfigdre`.`ramo_id` = `usuario_ramo`.`ramo` Inner Join `usuarios`
				On 	
				`usuario_ramo`.`Usuario` = `usuarios`.`VALOR`
			Where
				`ramosconfigdre`.`nombre` = '".urldecode($Ramo)."'
					   ";
		$resTipoRamo = DreQueryDB($sqlTipoRamo);
		$rowTipoRamo = mysql_fetch_assoc($resTipoRamo);
			$ramoTitulo =  $rowTipoRamo['ramoTitulo']; // Variable Calculada
			$ramoEmail = ""; //$rowTipoRamo['ramoEmail']; // Variable Calculada
			$usuario = $rowTipoRamo['usuario']; // Variable Calculada
		
		$actividadInterno = $Actividad;
		$ramoInterno = urlencode($ramoTitulo);
	}

//** Calculamos Info Usuario Creacion
	$sqlInfoUsuarioCreacion = "
		Select 
			`CLAVE`
			,`NOMBRE`
			,`VALOR`
			,`TIPO`
			,`estado`
			,`PROMOTOR`
			,`SUCURSAL`
			,`Email` As `creadorEmail`
			,`EDIRECTA`
			,`Telefono_Fijo`
			,`Telefono_Celular`
		From
			`usuarios`
		Where 
			`VALOR` = '$IDUsuarioCreacion'
			And 
			`Email` != ''
							  ";
	$resInfoUsuarioCreacion = DreQueryDB($sqlInfoUsuarioCreacion);
	$rowInfoUsuarioCreacion = mysql_fetch_assoc($resInfoUsuarioCreacion);
		$creadorEmail =  $rowInfoUsuarioCreacion['creadorEmail']; // Variable Calculada

//** Calculamos Info Usuario Responsable
	$sqlInfoUsuarioResponsable = "
		Select 
			`CLAVE`
			,`NOMBRE`
			,`VALOR`
			,`TIPO`
			,`estado`
			,`PROMOTOR`
			,`SUCURSAL`
			,`Email` As `responsableEmail`
			,`EDIRECTA`
			,`Telefono_Fijo`
			,`Telefono_Celular`
		From
			`usuarios`
		Where 
			`VALOR` = '$Responsable'
			And 
			`Email` != ''
								 ";
	$resInfoUsuarioResponsable = DreQueryDB($sqlInfoUsuarioResponsable);
	$rowInfoUsuarioResponsable = mysql_fetch_assoc($resInfoUsuarioResponsable);
		$responsableEmail =  $rowInfoUsuarioResponsable['responsableEmail']; // Variable Calculada

//** Calculamos RecId de la Actividad
	$recId = mysql_result(DreQueryDB("Select `valor`+1 From `configdre` Where `parametro` = 'folioActividad'"),0);
	DreQueryDB("Update `configdre` Set `valor` = '$recId' Where `parametro` = 'folioActividad'");
	$recId = "w".$recId;
	
	$formatFecha = date('Y-m-d');
	$formatEspFecha = date('d-m-Y');

//** Reenviamos Calculo por TipoActividad
	switch($actividadInterno){
		/* 1 */
		case "Cotizaci%F3n": // Cotizacion
			include("../includes/agregarActividades_Cotizacion.php");
		break;
		
		/* 2 */
		case "Emisi%F3n": // Emision
			include("../includes/agregarActividades_Emision.php");
		break;
		
		/* 3 */
		case "Diligencias": // Diligencias
			include("../includes/agregarActividades_Diligencias.php");
		break;

		/* 4 */
		case "Cambio+de+Conducto":
			include("../includes/agregarActividades_CambioConducto.php");
		break;

		/* 5 */				
		case "Endoso": // Endoso
			include("../includes/agregarActividades_Endoso.php");
		break;		

		/* 6 */
		case "Cancelacion":  // Cancelacion
			include("../includes/agregarActividades_Cancelacion.php");
		break;

		/* 7 */	
		case "Siniestros": // Siniestros
			include("../includes/agregarActividades_Siniestros.php");
		break;		

		/* 8 */
		case "Otras+Actividades": // Otras Actividades
			include("../includes/agregarActividades_OtrasActividades.php");
		break;

		/* 9 */
		case "Aclaraci%F3n+de+Comisiones": // Aclaracion de Comisiones
			include("../includes/agregarActividades_AclaracionComisiones.php");
		break;
		
		/* 10 */
		case "Solicitud+de+tarjetas+Club+Cap": // Solicitud de Tarjetas Club Cap
			include("../includes/agregarActividades_SolicitudTarjetasClubCap.php");
		break;
		
		/* 11 */
		case "Pago+Cobranza": // Pago Cobranza
			include("../includes/agregarActividades_PagoCobranza.php");
		break;
		
		/* 11 */
		case "comentarioCobranza": // Pago Cobranza
			include("../includes/agregarActividades_ComentarioCobranza.php");
		break;
	}

	DreQueryDB($sqlAgregarActividad);
	$idActividad = mysql_insert_id();
	
	$sqlUpdateidInternoMd5 = 	"
		Update `actividades`
		Set 
			`idInternoMd5` = '".md5($idActividad)."'
		Where 
			`idInterno` = '$idActividad'
								";
	DreQueryDB($sqlUpdateidInternoMd5);

//**
	include("../includes/agregarActividades_AddImagenes.php");


//** - > Envio  Correo Notificacion Todos los involucrados	

//CONSTRUCCION DEL MENSAJE
$message = "";
	// Encabezado del correo
        $message = $message . "<strong>Informacion de la Actividad</strong><br>";
		$message = $message . "<strong>Actividad: </strong>".urldecode($Actividad)." - ".$ramoTitulo." (".$recId.")<br>"; 
		$message = $message . "<strong>Fecha Programada Actividad: </strong>".$formatEspFecha."<br>"; 

        $message = $message . "<hr>";
		
	// Cuerpo del Correo
        $message = $message . "<br />";
        $message = $message . "<strong>Datos Empresa:</strong><br />"; // Datos Empresa
		$resDatosEmpresaCorreo = DreQueryDB("Select * From `empresas` Where `CLAVE` = '$idRef'");
		$rowDatosEmpresaCorreo = mysql_fetch_assoc($resDatosEmpresaCorreo);
		$message = $message . "&nbsp;&nbsp;&nbsp;<strong>Clave:</strong>&nbsp;".$rowDatosEmpresaCorreo['CLAVE']."<br />";
		$message = $message . "&nbsp;&nbsp;&nbsp;<strong>Nombre:</strong>&nbsp;".$rowDatosEmpresaCorreo['RAZON_SOCIAL']."<br />";
		
        $message = $message . "<strong>Datos Contacto:</strong><br />"; // Datos Contacto
		$resDatosContactoCorreo = DreQueryDB("Select * From `contactos` Where `TIPO` = 'CONTACTO1' And `CLAVE` = '$idRef'");
		$rowDatosContactoCorreo = mysql_fetch_assoc($resDatosContactoCorreo);
		$message = $message . "&nbsp;&nbsp;&nbsp;<strong>Nombre:</strong>&nbsp;".$rowDatosContactoCorreo['NOMBRE']."<br />";
		$message = $message . "&nbsp;&nbsp;&nbsp;<strong>E-Mail:</strong>&nbsp;".$rowDatosContactoCorreo['EMAIL']."<br />";
		
        $message = $message . "<strong>Responsable:</strong><br />"; // Datos Responsable
		$resDatosResponsableCorreo = DreQueryDB("Select * From `usuarios` Where `CLAVE` = '$Responsable'");
		$rowDatosResponsableCorreo = mysql_fetch_assoc($resDatosResponsableCorreo);
		$message = $message . "&nbsp;&nbsp;&nbsp;<strong>Nombre:</strong>&nbsp;".$rowDatosResponsableCorreo['NOMBRE']."&nbsp;(".$rowDatosResponsableCorreo['TIPO'].")<br />";
	if(false){
		$message = $message . "<strong>Ubicacion:</strong><br />"; // Ubicacion
		$message = $message . "&nbsp;&nbsp;&nbsp;".$Ubicacion."<br />";
	}
	if($actividadInterno == "Otras+Actividades"){
		$message = $message . "<strong>Referencia:</strong><br />"; // Referencia
		$message = $message . "&nbsp;&nbsp;&nbsp;".$Referencia."<br />";
	}

$desde = "CAPSYS Web <do-not-reply@capsys.com.mx>";
if($ramoEmail != ""){ $para = $responsableEmail.", ".$ramoEmail; } else { $para = $responsableEmail; } // Correo al que mandamos
$copia = $creadorEmail.$involucradoEmail; // Correo al que se copia en envio
$copiaOculta = "juanjose@dre-learning.com, mesadecontrol@agentecapital.com";  // Correo al que se copia oculto el envio 
$asunto = "Registro Actividad CAPSYS Web Folio: ".$recId;
$mensaje = $message;
$fileAdjunto = "";
$nameAdjunto = "";

// Linea de envio del correo
DreMail($desde,$para,$copia,$copiaOculta,$asunto,$mensaje,$fileAdjunto,$nameAdjunto);
// --Envio  de Correo-- //

		$return = "../actividadesDetalle.php?recId=".$recId."&muestra=Seguimiento#Seguimiento";

$textoAlertDocumento; //<-- Cosas Que Poner

// echo "<pre>";
	//echo $sqlTipoRamo;
	//echo "<br>";
	//echo $sqlInfoUsuarioCreacion;
	//echo "<br>";
	//echo $sqlInfoUsuarioResponsable;
	//echo "<br>";

	//print_r($_SESSION);
	//echo "<br>";
	//print_r($_REQUEST);
	//echo "<br>";
	//echo $sqlAgregarActividad;
	//echo "<br>";
// echo "</pre>";

if($Actividad == "comentarioCobranza"){
	?>
    <script>
	alert('Su Comentario ha sido guardado con \u00e9xito');
	window.close();
	</script>
	<?
} // close
?>
<script>
	alert('Su actividad ha sido creada con \u00e9xito \n\r Folio: <? echo $recId; ?>');
	window.open('<? echo $return; ?>','_self');
</script>
<?
}
// ## Erick Siniestros : SINIESTROS : 0000028947 : EMARTINEZ @ 0000522626 : ALAN JOSIMAR ROMAHN OLIVARES (SINIESTROS) : AROMAHN
// ## Dulce Cobranza : EJECUTIVO COBRANZA  : 0000039567 : DUICAB @ 0000039568 : ANILU BORGES : ABORGES
DreDesconectarDB($conexion);
?>