<?php
session_start();
extract($_REQUEST);
if(	$seccion != "index"){
	if(!isset($_SESSION['WebDreTacticaWeb2'])){ header("Location: index.php"); }
	if(!isset($_SESSION['WebDreTacticaWeb2']['Usuario'])){ header("Location: index.php"); }
}
include('../config/funcionesDre.php');
	$conexion = DreConectarDB();

// tipoAgregar Empleado
if($_REQUEST['tipoAgregar'] == "Empleado"){
	$sqlInsertEmpleado = "
		Insert Into 
			`miinfo_empleados` 
		(
			`Nombre`
			, `Puesto`
			, `Ext`
			, `Correo`
			, `Cumple`
			, `Sucursal`
			, `JefeInmediato`
			, `Celular`
			, `TipoEmpleado`
		)
		Values
		(
			'".strtoupper($Nombre)."'
			, '".strtoupper($Puesto)."'
			, '$Ext'
			, '$Correo'
			, '$Cumple'
			, '$Sucursal'
			, '".strtoupper($JefeInmediato)."'
			, '$Celular'
			, '$TipoEmpleado'
		);
						 ";
	DreQueryDB($sqlInsertEmpleado);
	
	$return = "../empleadosAgregar.php";
	?>
    <script>
		alert('Empleado Agregado\nCon Exito !!!');
		window.open('<?php echo $return; ?>','_self');
	</script>
    <?php
	
	echo "<pre>";
		print_r($_REQUEST);
		echo $sqlInsertEmpleado;
	echo "</pre>";
}

// tipoAgregar Empresa
if($_REQUEST['tipoAgregar'] == "Empresa"){
	$CLAVEWEB = "W".mysql_result(mysql_query("Select `valor` From `configdre` Where `parametro`  = 'ClaveEmpresas'"),0);
	mysql_query("Update `configdre` Set `valor` = (`valor`+1) Where `parametro` = 'ClaveEmpresas'") or die(mysql_error());
	$CLAVE = str_pad($CLAVEWEB, 10, '0',0);
	if(!isset($RAZON_SOCIAL)){
		$RAZON_SOCIAL = rtrim(ltrim($NOMBRES,' '),' ');
		$RAZON_SOCIAL.= " ".rtrim(ltrim($APELLIDO_PATERNO,' '),'')." ";
		$RAZON_SOCIAL.= " ".rtrim(ltrim($APELLIDO_MATERNO,' '),' ')." ";
	}
//	if(isset($SUCURSAL)){ $SUCURSAL = "0001"; }
	$EDAD = calculaedad($FECHA_NACIMIENTO);	
	$sqlConsultaInfoVendedor = "
		Select * From
			`usuarios`
		Where
			`VALOR` = '$VENDEDOR'
							   ";
	$resConsultaInfoVendedor = DreQueryDB($sqlConsultaInfoVendedor);
	$rowConsultaInfoVendedor = mysql_fetch_assoc($resConsultaInfoVendedor);
		
	$SUCURSAL = $rowConsultaInfoVendedor['SUCURSAL'];
	$PROMOTOR = $rowConsultaInfoVendedor['PROMOTOR'];
	
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

	
	//Insertamos en la Tabla de Empresas
	$sqlInsertEmpresa = "
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
					, `SITIO_WEB`
					, `TWITTER`
					, `FACEBOOK`
					, `CLAVEWEB`
					, `SUCURSAL`
					, `PROMOTOR`
					, `TIPO_REGISTRO`
					, `actualizado`
					, `observaciones`
					, `Club_Cap`
					, `Poliza_Electronica`
					, `Tipo_Cliente`
					, `Grupo`
					, `estatusCliente`
					, `email`
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
					,'$MUNICIPO'
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
					,'$SITIO_WEB'
					,'$TWITTER'
					,'$FACEBOOK'
					,'$CLAVEWEB'
					,'$SUCURSAL'
					,'$PROMOTOR'
					,'PR'
					,'1'
					,'$observaciones'
					,'$Club_Cap'
					,'$Poliza_Electronica'
					,'$Tipo_Cliente'
					,'$Grupo'
					,'A'
					,'$email'
				);
						";
	DreQueryDB($sqlInsertEmpresa);
	
	//Insertamos en la Tabla de Contactos
	$sqlInsertContactoEmpresa = "
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
				,`correoMasivo`
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
				,'1'
			)
								";
	DreQueryDB($sqlInsertContactoEmpresa);

	$return = "../cliente.php?CLAVE=".$CLAVE;
	?>
    <script>
		alert('Cliente Agregado\nCon Exito !!!');
		window.open('<?php echo $return; ?>','_self');
	</script>
    <?php	
}
		
// tipoAgregar Contacto
if($_REQUEST['tipoAgregar'] == "Contacto"){
	$sqlInsertContacto = "
		Insert Into `contactos`
			(
				`CLAVE`
				,`TIPO`
				,`NOMBRE`
				,`EMAIL`
				,`TELEFONO`
				,`DIRECCION`
				,`VENDEDOR`
				,`SUCURSAL`
				,`promotor`
				,`actualizado`
				,`correoMasivo`
			)
		Values
			(
				'$CLAVE'
				,'$TIPO'
				,'".strtoupper($NOMBRE)."'
				,'".strtoupper($EMAIL)."'
				,'$TELEFONO'
				,'".strtoupper($DIRECCION)."'
				,'$VENDEDOR'
				,'$SUCURSAL'
				,'$promotor'				
				,'1'
				,'$correoMasivo'
			)
						 ";
	DreQueryDB($sqlInsertContacto);

	$return = "../cliente.php?CLAVE=".$CLAVE."&muestra=Contactos#".$TIPO;
	?>
    <script>
		alert('Contacto Agregado\nCon Exito !!!');
		window.open('<?php echo $return; ?>','_self');
	</script>
    <?php
}

// tipoAgregar Proveedor
if($_REQUEST['tipoAgregar'] == "Proveedor"){
	$sqlCalculoIdProveedor="Select Count(*) From `miinfo_proveedores` Where `organizacion_id` Like '%w%'";
	$organizacion_id = mysql_result(DreQueryDB($sqlCalculoIdProveedor),0)+1;
	
	$sqlCalculoIdContactoProveedor="Select Max(`id_contacto`) From `miinfo_proveedores` Where `organizacion_id` = 'W".$organizacion_id."'";
	$id_contacto = mysql_result(DreQueryDB($sqlCalculoIdContactoProveedor),0)+1;

	$sqlInsertOrganizacionesProveedor = "
		Insert Into
			`organizaciones`
				(
					`id`
					,`Nombre`
				)
				Values
				(
					'"."W".$organizacion_id."'
					, '$Nombre_organizacion'
				);
										";
	DreQueryDB($sqlInsertOrganizacionesProveedor);
		
	$sqlInsertProveedor = "
		Insert Into 
			`miinfo_proveedores`
				(
					`organizacion_id`
					, `Nombre_organizacion`
					, `id_contacto`
					, `Nombre_contacto`
					, `puesto`
					, `telefono1`
					, `telefono2`
					, `telefono3`
					, `telefono4`
					, `extension`
					, `telefono_movil`
					, `email`
					, `direccion`
					, `banco`
					, `cuenta`
					, `clabe`
					, `categoria`
				) 
				Values 
				(
					'"."W".$organizacion_id."'
					, '$Nombre_organizacion'
					, '$id_contacto'
					, '$Nombre_contacto'
					, '$puesto'
					, '$telefono1'
					, '$telefono2'
					, '$telefono3'
					, '$telefono4'
					, '$extension'
					, '$telefono_movil'
					, '$email'
					, '$direccion'
					, '$banco'
					, '$cuenta'
					, '$clabe'
					, '$categoria'
				);
						  ";
	DreQueryDB($sqlInsertProveedor);
	$return = "../proveedor.php?CLAVE=W".$organizacion_id;
	?>
    <script>
		alert('Proveedor Agregado\nCon Exito !!!');
		window.open('<?php echo $return; ?>','_self');
	</script>
    <?php
}

// tipoAgregar ContactoProveedor
if($_REQUEST['tipoAgregar'] == "ContactoProveedor"){
	$sqlInsertContactoProveedor = "
		Insert Into 
			`miinfo_proveedores` 
				(
					`organizacion_id`
					, `Nombre_organizacion`
					, `id_contacto`
					, `Nombre_contacto`
					, `puesto`
					, `telefono1`
					, `telefono2`
					, `telefono3`
					, `telefono4`
					, `extension`
					, `telefono_movil`
					, `email`
					, `direccion`
					, `banco`
					, `cuenta`
					, `clabe`
					, `categoria`
				)
				Values
				(
					'$CLAVE'
					,'".strtoupper($Nombre_organizacion)."'
					,'$id_contacto'
					,'".strtoupper($Nombre_contacto)."'
					,'".strtoupper($puesto)."'
					,'$telefono1'
					,'$telefono2'
					,'$telefono3'
					,'$telefono4'
					,'$extension'
					,'$telefono_movil'
					,'$email'
					,'$direccion'
					,'$banco'
					,'$cuenta'
					,'$clabe'
					,'$categoria'
				)
						 ";


	DreQueryDB($sqlInsertContactoProveedor);
	$TIPO = mysql_insert_id();
	$return = "../proveedor.php?CLAVE=".$CLAVE."&muestra=Contactos#".$TIPO;
	?>
    <script>
		alert('Contacto Agregado\nCon Exito !!!');
		window.open('<?php echo $return; ?>','_self');
	</script>
    <?php
}

// tipoAgregar MiContacto
if($_REQUEST['tipoAgregar'] == "miContacto"){
	$sqlCalculaIdMiContacto = "
		Select Max(`misContactos_id`) From
			`miinfo_miscontactos`
							  ";
	$misContactos_id = mysql_result(DreQueryDB($sqlCalculaIdMiContacto),0)+1;

	$sqlCalculaIdMiContactoContacto = "
		Select Max(`id_contacto`) From
			`miinfo_miscontactos`
		Where
			`misContactos_id` = '$misContactos_id'
									  ";
	$id_contacto = mysql_result(DreQueryDB($sqlCalculaIdMiContactoContacto),0)+1;
	
	$sqlInsertMiContacto = "
		Insert Into
			`miinfo_miscontactos` 
				(
					`misContactos_id`
					, `Nombre_misContactos`
					, `id_contacto`
					, `Nombre_contacto`
					, `puesto`
					, `telefono1`
					, `telefono2`
					, `telefono3`
					, `telefono4`
					, `extension`
					, `telefono_movil`
					, `email`
					, `direccion`
					, `banco`
					, `cuenta`
					, `clabe`
					, `userCreador`
				)
				Values
				(
					'$misContactos_id'
					, '".strtoupper($Nombre_misContactos)."'
					, '$id_contacto'
					, '".strtoupper($Nombre_contacto)."'
					, '".strtoupper($puesto)."'
					, '$telefono1'
					, '$telefono2'
					, '$telefono3'
					, '$telefono4'
					, '$extension'
					, '$telefono_movil'
					, '$email'
					, '$direccion'
					, '$banco'
					, '$cuenta'
					, '$clabe'
					, '$userCreador'
				);
						   ";
	DreQueryDB($sqlInsertMiContacto);
	
	$sqlMantenimiento = "
		Update
			`miinfo_miscontactos`
		Set
			`Nombre_contacto` = `Nombre_misContactos`
		Where
			`Nombre_misContactos` != '' And `Nombre_contacto` = ''
						";
	DreQueryDB($sqlMantenimiento);
	
	$return = "../misContactos.php?CLAVE=".$misContactos_id;
	?>
    <script>
		alert('Mi Contacto Agregado\nCon Exito !!!');
		window.open('<?php echo $return; ?>','_self');
	</script>
    <?php
}

// tipoAgregar ContactoMiContacto
if($_REQUEST['tipoAgregar'] == "ContactoMiContacto"){
	$sqlInsertContactoProveedor = "
		Insert Into 
			`miinfo_miscontactos` 
				(
					`misContactos_id`
					, `Nombre_misContactos`
					, `id_contacto`
					, `Nombre_contacto`
					, `puesto`
					, `telefono1`
					, `telefono2`
					, `telefono3`
					, `telefono4`
					, `extension`
					, `telefono_movil`
					, `email`
					, `direccion`
					, `banco`
					, `cuenta`
					, `clabe`
					, `userCreador`
				)
				Values
				(
					'$CLAVE'
					,'".strtoupper($Nombre_misContactos)."'
					,'$id_contacto'
					,'".strtoupper($Nombre_contacto)."'
					,'".strtoupper($puesto)."'
					,'$telefono1'
					,'$telefono2'
					,'$telefono3'
					,'$telefono4'
					,'$extension'
					,'$telefono_movil'
					,'$email'
					,'$direccion'
					,'$banco'
					,'$cuenta'
					,'$clabe'
					,'$Usuario'
				)
						 ";


	DreQueryDB($sqlInsertContactoProveedor);
	$TIPO = mysql_insert_id();
	$return = "../misContactos.php?CLAVE=".$CLAVE."&muestra=Contactos#".$TIPO;
	?>
    <script>
		alert('Contacto Agregado\nCon Exito !!!');
		window.open('<?php echo $return; ?>','_self');
	</script>
    <?php
}

// tipoAgregar Documentos
if($_REQUEST['tipoAgregar'] == 'Documentos'){
	$archivoSeleccionado = $_FILES['archivo']['tmp_name'];
	
	$folioArchivosWeb = mysql_result(DreQueryDB("Select `valor` From `configdre` Where `parametro`  = 'folioArchivosWeb'"),0);
	DreQueryDB("Update `configdre` Set `valor` = (`valor`+1) Where `parametro` = 'folioArchivosWeb'");
	$ArchivoWeb = "W".str_pad($folioArchivosWeb,9,'0',0);

	$name = $ArchivoWeb.$extension;
	$destino = "/" ;
	$img_file = $destino.$name;
	
	$TIPO_IMG_Array = explode('*',$TIPO_IMG);
	$TIPO_IMG_New = $TIPO_IMG_Array[0];
	$TIPO = $TIPO_IMG_Array[1];
	if($TIPO == "P"){ $TIPO = "PO"; }else{ $TIPO = "CL"; }

			// Copiamos el Archivo nuevo
				// informacion del FTP Server
				$ftp_server = tipoFtp($_SERVER['REMOTE_ADDR']);
				$ftp_user = "userftp";
				$ftp_pass = "DreLearning2012";
				
				// Carga al FTP
				$idcon = ftp_connect($ftp_server)or die ("no se pudo conectar al servidor");
				//ftp_pasv($idcon, true);
				$login = ftp_login($idcon,$ftp_user,$ftp_pass);
				$put = ftp_put($idcon,$img_file,$archivoSeleccionado,FTP_BINARY);

				if($put){
					$sqlInsertImagenes  = "
						Insert Into `imagenes`
							(	
								`NO_ARCHIVO`
								,`EXTENSION`
								,`RUTA`
								,`DESCRIPCION`
								,`POLIZA`
								,`TIPO_IMG`
								,`CLIENTE_MPRO`
								,`CLIENTE_TMP`
								,`SUCURSAL`
								,`TIPO`
							)
						Values
							(
								'$ArchivoWeb'
								,'$extension'
								,''
								,'$DESCRIPCION'
								,'$POLIZA'
								,'$TIPO_IMG_New'
								,'$CLIENTE_MPRO'
								,'$CLIENTE_TMP'
								,'$SUCURSAL'
								,'$TIPO'
							)
							";
					DreQueryDB($sqlInsertImagenes);
					// pagina que cargamos cuando termina la acccion
					$return = "../clienteDocumentos.php?CLAVE=".$CLIENTE_MPRO;
					?>
                    <script language="javascript" type="text/javascript">
						alert('Documento Agregado con Exito !!!');
						window.open('<?php echo $return; ?>','_self');
					</script>
                    <?php
				} else {
					// Error a mostrar si no se carga el archivo
					?>
                    <script language="javascript" type="text/javascript">
						alert('Error al Cargar Archivo !!!');
					</script>
                    <?php
				}
}

// tipoAgregar citaCalendario
include('agregar.citaCalendario.php');

// tipoAgregar documentosActividad
if($_REQUEST['tipoAgregar'] == 'documentosActividad'){
	$archivoSeleccionado = $_FILES['archivo']['tmp_name'];
// recId
	$idFile = mysql_result(DreQueryDB("Select Count(*) From `imagenes` Where `NO_ARCHIVO` Like '$recId%'"),0);
	$ArchivoWeb = $recId."_".$idFile;
	$name = $ArchivoWeb.$extension;
//	$destino = "/actividades/" ;
	$destino = "/" ;
	$fileActividad = $destino.$name;
	$TIPO_IMG_Array = explode('*',$TIPO_IMG);
	$TIPO_IMG_New = $TIPO_IMG_Array[0];
	$TIPO = $TIPO_IMG_Array[1];
	if($TIPO == "P"){ $TIPO = "PO"; }else{ $TIPO = "CL"; }
	
		// Copiamos el Archivo nuevo
			// informacion del FTP Server
				$ftp_server =  tipoFtp($_SERVER['REMOTE_ADDR']);
				$ftp_user = "userftp";
				$ftp_pass = "DreLearning2012";
				
				// Carga al FTP
				$idcon = ftp_connect($ftp_server)or die ("no se pudo conectar al servidor");
				//ftp_pasv($idcon, true);
				$login = ftp_login($idcon,$ftp_user,$ftp_pass);
				$put = ftp_put($idcon,$fileActividad,$archivoSeleccionado,FTP_BINARY);

				if($put){
					$sqlInsertImagenes  = "
						Insert Into `imagenes`
							(	
								`NO_ARCHIVO`
								,`EXTENSION`
								,`RUTA`
								,`DESCRIPCION`
								,`POLIZA`
								,`VALOR`
								,`TIPO_IMG`
								,`CLIENTE_MPRO`
								,`CLIENTE_TMP`
								,`SUCURSAL`
								,`recId`
								,`TIPO`
							)
						Values
							(
								'$ArchivoWeb'
								,'$extension'
								,''
								,'$DESCRIPCION'
								,'$POLIZA'
								,'$VALOR'
								,'$TIPO_IMG_New'
								,'$idEmpresa'
								,''
								,'$SUCURSAL'
								,'$recId'
								,'$TIPO'
							)
										  ";
					DreQueryDB($sqlInsertImagenes);
					
					$sqlInsertActividadHijo = "
						Insert Into 
							`actividades`
						(
							`recId`
							,`inicio`
							,`referencia`
							,`usuario`
							,`usuarioCreacion`
							,`actividadInterno`
							,`ramoInterno`
							,`idRef`
							,`tipo`
							,`actividad`
							,`POLIZA`
						)
						Values
						(
							'$recId'
							,'1'
							,'&nbsp;&nbsp;&nbsp;<strong>Tipo Documento Adjunto:</strong><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$TIPO_IMG_New."<br>&nbsp;&nbsp;&nbsp;<strong>Descipcion Documento:</strong><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$DESCRIPCION."'
							,'$usuario'
							,'$usuarioCreacion'
							,'$actividadInterno'
							,'$ramoInterno'
							,''
							,''
							,'$actividad'
							,'$VALOR'
						)
											  ";
					DreQueryDB($sqlInsertActividadHijo);

					$sqlIdInternoRespuesta = "
						Select `idInterno` FROM 
							`actividades`
						Where 
							`recId` =  '$recId'
						And
							`inicio` = '0'
							Order By 
							`idInterno` Asc
						Limit 
							0,1
											 ";
			
					$resIdInternoRespuesta = DreQueryDB($sqlIdInternoRespuesta);
					$idInternoRespuesta = mysql_result($resIdInternoRespuesta,0);
					
					$sqlUpdateRespuesta = "
						Update
							`actividades`
						Set
							`respuesta` = '$respuesta'
							,`usuarioBolita` = '$usuarioBolita'
						Where
							`idInterno` = '$idInternoRespuesta'
										  ";
					DreQueryDB($sqlUpdateRespuesta);					

// --Envio  de Correo-- //
$sqlResponsables = "Select * From `actividades` Where `recId` = '$recId'";
	$resResponsas = DreQueryDB($sqlResponsables);
		$rowResposables = mysql_fetch_assoc($resResponsas);	
			$usuarioResponsableCreacion = $rowResposables['usuarioCreacion'];

$sqlResponsableUsuarioEmail = "Select * From `usuarios` Where `VALOR` = '$usuarioResponsableCreacion'";
	$resResponsableUsuarioEmail = DreQueryDB($sqlResponsableUsuarioEmail);
		$rowResposableUsuarioEmail = mysql_fetch_assoc($resResponsableUsuarioEmail);	
			$responsableEmailCreacion =  $rowResposableUsuarioEmail['Email'];

$desde = "CAPSYS Web <do-not-reply@capsys.com.mx>";
$para = $responsableEmail; // Correo al que mandamos
$copia = $responsableEmailCreacion; // Correo al que se copia en envio 
$copiaOculta = "juanjose@dre-learning.com";  // Correo al que se copia oculto el envio 
$asunto = "Documento Actividad CAPSYS Web Folio: ".$recId;
$mensaje = "";
$fileAdjunto = "";
$nameAdjunto = "";

//CONSTRUCCION DEL MENSAJE
	// Encabezado del correo
        $mensaje.= "<strong>Informacion de la Actividad</strong><br>";
		$resDatosEmpresaCorreo = DreQueryDB("Select * From `actividades` Where `recId` = '$recId'");
		$rowDatosEmpresaCorreo = mysql_fetch_assoc($resDatosEmpresaCorreo);
		$mensaje.= "<strong>Actividad: </strong>".$rowDatosEmpresaCorreo['actividad']."<br>"; 
		$mensaje.= "<strong>Fecha: </strong>".$rowDatosEmpresaCorreo['fechaCreacion']."<br>"; 

        $mensaje.= "<hr>";
		
	// Cuerpo del Correo
        $mensaje.= "<br />";
        $mensaje.= "<strong>Datos Empresa:</strong><br />"; // Datos Empresa
		$resDatosEmpresaCorreo = DreQueryDB("Select * From `empresas` Where `CLAVE` = '$idEmpresa'");
		$rowDatosEmpresaCorreo = mysql_fetch_assoc($resDatosEmpresaCorreo);
		$mensaje.= "&nbsp;&nbsp;&nbsp;<strong>Clave:</strong>&nbsp;".$rowDatosEmpresaCorreo['CLAVE']."<br />";
		$mensaje.= "&nbsp;&nbsp;&nbsp;<strong>Nombre:</strong>&nbsp;".$rowDatosEmpresaCorreo['RAZON_SOCIAL']."<br />";
		
        $mensaje.= "<strong>Datos Contacto:</strong><br />"; // Datos Contacto
		$resDatosContactoCorreo = DreQueryDB("Select * From `contactos` Where `CLAVE` = '$idEmpresa'");
		$rowDatosContactoCorreo = mysql_fetch_assoc($resDatosContactoCorreo);
		$mensaje.= "&nbsp;&nbsp;&nbsp;<strong>Nombre:</strong>&nbsp;".$rowDatosContactoCorreo['NOMBRE']."<br />";
		$mensaje.= "&nbsp;&nbsp;&nbsp;<strong>E-Mail:</strong>&nbsp;".$rowDatosContactoCorreo['EMAIL']."<br />";
		
        $mensaje.= "<strong>Responsable:</strong><br />"; // Datos Responsable
		$resDatosResponsableCorreo = DreQueryDB("Select * From `usuarios` Where `CLAVE` = '$usuarioCreacion'");
		$rowDatosResponsableCorreo = mysql_fetch_assoc($resDatosResponsableCorreo);
		$mensaje.= "&nbsp;&nbsp;&nbsp;<strong>Nombre:</strong>&nbsp;".$rowDatosResponsableCorreo['NOMBRE']."&nbsp;(".$rowDatosResponsableCorreo['TIPO'].")<br />";
        $mensaje.= "&nbsp;&nbsp;&nbsp;<strong>Email:</strong>"; // Ubicacion
		$mensaje.= "&nbsp;&nbsp;&nbsp;".$rowDatosResponsableCorreo['Email']."<br />";
		$mensaje.= "<strong>Documentos:</strong><br />";
		$mensaje.= "&nbsp;&nbsp;&nbsp;<strong>Descripcion:</strong>";
		$mensaje.= "&nbsp;&nbsp;&nbsp;".$DESCRIPCION."<br />";
		$message.= "&nbsp;&nbsp;&nbsp;<strong>Tipo de Imegen:</strong>";
		$message.= "&nbsp;&nbsp;&nbsp;".$TIPO_IMG."<br />";
		$message.= "&nbsp;&nbsp;&nbsp;<strong>Nombre del Archivo:</strong>";
		$message.= "&nbsp;&nbsp;&nbsp;".$ArchivoWeb.$extension."<br />";
		

DreMail($desde,$para,$copia,$copiaOculta,$asunto,$mensaje,$fileAdjunto,$nameAdjunto);
// --Envio  de Correo-- //	

					// pagina que cargamos cuando termina la acccion

					$return = "../actividadesDetalle.php?recId=".$recId."&muestra=Documentos#Documentos";  //."&ver=4&idInterno=".$idInterno;
                    ?>
                    <script language="javascript" type="text/javascript">
						alert('Archivo Agregado !!!');
						window.open('<?php echo $return; ?>', '_self');
					</script>
                    <?php
				} else {
					// Error a mostrar si no se carga el archivo
					?>
                    <script language="javascript" type="text/javascript">
						alert('Error al Cargar Archivo !!!');
					</script>
                    <?php
				}
}

// tipoAgregar ActividadInformacion
if($_REQUEST['tipoAgregar'] == 'ActividadInformacion'){

	$sql_ultimoTiempo = "
		Select 
			`fechaCreacion`
			, Max(`idInterno`)
		From
			`actividades`
		Where
			`recId` = '$recId'
						";
	$ultimoTiempo = mysql_result(DreQueryDB($sql_ultimoTiempo), 0);
	
	$sqlAgregarActividadInformacion = "
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
		,`tiempoAtencion`
		)
	Values
		(
		'$recId'
		,'1'
		,'$referencia'
		,'$usuario'
		,'$usuarioCreacion'
		,''
		,'$actividadInterno'
		,'$ramoInterno'
		,''
		,''
		,'$actividad'
		,'$tiempoAtencion'
		)
									  ";	
	DreQueryDB($sqlAgregarActividadInformacion);
	$idActividad = mysql_insert_id();
	
	$sqlUpdateidInternoMd5 = 	"
		Update 
			`actividades`
		Set 
			`idInternoMd5` = '".md5($idActividad)."'
			, `tiempoAtencion` = TIMESTAMPDIFF(Minute,'$ultimoTiempo', `fechaActualizacion`)
		Where 
			`idInterno` = '$idActividad'
								";
	DreQueryDB($sqlUpdateidInternoMd5);

	$sqlIdInternoRespuesta = "
		Select `idInterno` FROM 
			`actividades`
		Where 
			`recId` =  '$recId'
			And
			`inicio` = '0'
		Order By 
			`idInterno` Asc
		Limit 
			0,1
							 ";
	$resIdInternoRespuesta = DreQueryDB($sqlIdInternoRespuesta);	
	$idInternoRespuesta = mysql_result($resIdInternoRespuesta,0);
	
	$sqlTiempoAtencion = "
		Select `tiempoAtencion` FROM 
			`actividades`
		Where 
			`recId` =  '$recId'
			And
			`inicio` = '1'
		Order By 
			`idInterno` Desc
		Limit 
			0,1
							 ";
	$tiempoAtencion = mysql_result(DreQueryDB($sqlTiempoAtencion),0);

	//$tiempoAtencion = 10;
// >> $usuarioBolita
	$sqlUpdateRespuesta = "
		Update
			`actividades`
		Set
			`respuesta` = '$respuesta'
			, `usuarioBolita` = '$usuarioBolita'
			, `tiempoAtencion` = '$tiempoAtencion'
		Where
			`idInterno` = '$idInternoRespuesta'
						  ";
	DreQueryDB($sqlUpdateRespuesta);
	// - > Envio  Correo Notificacion Todos los involucrados	

// --Envio  de Correo-- //
$sqlResponsables = "Select * From `actividades` Where `recId` = '$recId'";
	$resResponsas = DreQueryDB($sqlResponsables);
		$rowResposables = mysql_fetch_assoc($resResponsas);	
			$usuarioResponsableCreacion = $rowResposables['usuarioCreacion'];

$sqlResponsableUsuarioEmail = "Select * From `usuarios` Where `VALOR` = '$usuarioResponsableCreacion'";
	$resResponsableUsuarioEmail = DreQueryDB($sqlResponsableUsuarioEmail);
		$rowResposableUsuarioEmail = mysql_fetch_assoc($resResponsableUsuarioEmail);	
			$responsableEmailCreacion =  $rowResposableUsuarioEmail['Email'];

$desde = "CAPSYS Web <do-not-reply@capsys.com.mx>";
$para = $responsableEmail; // Correo al que mandamos
$copia = $responsableEmailCreacion; // Correo al que se copia en envio 
$copiaOculta = "juanjose@dre-learning.com";  // Correo al que se copia oculto el envio 
$asunto = "Seguimiento Actividad CAPSYS Web Folio: ".$recId;
$mensaje = "";
$fileAdjunto = "";
$nameAdjunto = "";

//CONSTRUCCION DEL MENSAJE

	// Encabezado del correo
        $mensaje.= "<strong>Informacion de la Actividad</strong><br>";
		$mensaje.= "<strong>Actividad: </strong>".$actividad."<br>"; 
        $mensaje.= "<hr>";
		
	// Cuerpo del correo
        $mensaje.= "<br />";
        $mensaje.= "<strong>Datos Empresa:</strong><br />"; // Datos Empresa
		$resDatosEmpresaCorreo = DreQueryDB("Select * From `empresas` Where `CLAVE` = '$idRef'");
		$rowDatosEmpresaCorreo = mysql_fetch_assoc($resDatosEmpresaCorreo);
		$mensaje.= "&nbsp;&nbsp;&nbsp;<strong>Clave:</strong>&nbsp;".$rowDatosEmpresaCorreo['CLAVE']."<br />";
		$message.= "&nbsp;&nbsp;&nbsp;<strong>Nombre:</strong>&nbsp;".$rowDatosEmpresaCorreo['RAZON_SOCIAL']."<br />";		
		
        $message.= "<strong>Datos Contacto:</strong><br />"; // Datos Contacto
		$resDatosContactoCorreo = DreQueryDB("Select * From `contactos` Where `CLAVE` = '$idRef' ");
		$rowDatosContactoCorreo = mysql_fetch_assoc($resDatosContactoCorreo);
		$mensaje.= "&nbsp;&nbsp;&nbsp;<strong>Nombre:</strong>&nbsp;".$rowDatosContactoCorreo['NOMBRE']."<br />";
		$mensaje.= "&nbsp;&nbsp;&nbsp;<strong>E-Mail:</strong>&nbsp;".$rowDatosContactoCorreo['EMAIL']."<br />";
		
        $mensaje.= "<strong>Responsable:</strong><br />"; // Datos Responsable
		$resDatosResponsableCorreo = DreQueryDB("Select * From `usuarios` Where `CLAVE` = '$usuarioResponsableCreacion'");
		$rowDatosResponsableCorreo = mysql_fetch_assoc($resDatosResponsableCorreo);
		$mensaje.= "&nbsp;&nbsp;&nbsp;<strong>Nombre:</strong>&nbsp;".$rowDatosResponsableCorreo['NOMBRE']."&nbsp;(".$rowDatosResponsableCorreo['TIPO'].")<br />";
		$mensaje.= "&nbsp;&nbsp;&nbsp;<strong>Email:</strong>&nbsp;".$rowDatosResponsableCorreo['Email']."<br />";
        $mensaje.= "<strong>Referencia:</strong><br />";
		$mensaje.= "&nbsp;&nbsp;&nbsp;".$referencia."<br />";

// Linea de envio del correo
DreMail($desde,$para,$copia,$copiaOculta,$asunto,$mensaje,$fileAdjunto,$nameAdjunto);

// --Envio  de Correo-- //

					// pagina que cargamos cuando termina la acccion
					$return = "../actividadesDetalle.php?recId=".$recId."&muestra=Seguimiento#Seguimiento";
                    ?>
                    <script language="javascript" type="text/javascript">
						alert('Comentario Guardado !!!');
						window.open('<?php echo $return; ?>', '_self');
					</script>
                    <?php
}

// TipoAgregar AddPersonaAdicional
if($_REQUEST['tipoAgregar'] == 'AddPersonaAdicional'){
	$sqlInsertAddPersonaAdicional = "
		Insert Into `actividades_formularios_add` 
		(
			`idFormulario`
			,`nombre_add`
			,`sexo_add`
			,`fecha_nacimiento_add`
			,`edad_add`
			,`parentesco_add`
		) 
		Values
		(
			'$idFormulario'
			,'$nombre_add'
			,'$sexo_add'
			,'$fecha_nacimiento_add'
			,'$edad_add'
			,'$parentesco_add'
		)
	";
	DreQueryDB($sqlInsertAddPersonaAdicional);
	
	//$return = "../formularioActividad.php?idInterno=$idActividad";
	$return = "../actividadesDetalle.php?SubRamo=".$SubRamo."&recId=".$recId."&muestra=Formularios#Formularios";

	

	header("Location: $return");
}

// TipoAgregar SurtidoPartida
if($_REQUEST['tipoAgregar'] == 'SurtidoPartida'){
	$sqlConsultaCantidadPartida = "
		Select * From
			`tienda_pedidos_productos`
		Where 
			`idPartida` = '$idPartida'
			And
			`idPedido` = '$idPedido'
								  ";
	$sqlConsultaCantidadPartida = DreQueryDB($sqlConsultaCantidadPartida);
	$rowConsultaCantidadPartida = mysql_fetch_assoc($sqlConsultaCantidadPartida);
		$yaSurtido = $rowConsultaCantidadPartida['surtidos'];
	if($rowConsultaCantidadPartida['cantidad'] >= $cantidadSurtida){
		$sqlInsertSurtidoPartida = "
		Insert Into 
			`tienda_pedidos_surtido` 
				(
					`idPartida`
					,`idPedido`
					,`cantidadSurtida`
				)
				Values 
				(
					'$idPartida'
					,'$idPedido'
					,'$cantidadSurtida'
				);
								   ";
		DreQueryDB($sqlInsertSurtidoPartida);
		$NewSurtido = $cantidadSurtida + $yaSurtido; 
		$sqlUpdateSurtidoPartida = "
			Update
				`tienda_pedidos_productos`
			Set
				`surtidos` = '$NewSurtido'
			Where 
				`idPartida` = '$idPartida';
								   ";
		DreQueryDB($sqlUpdateSurtidoPartida);

		$mensajeReturn = "Partida Surtida Correctamente !!!";
		$urlReturn = "../tiendaPedidosSurtirDetalle.php?idPedido=".$idPedido;
	} else {
		$mensajeReturn = "Partida NO Surtida !!!";
		$urlReturn = "../tiendaPedidosSurtirDetalle.php?idPedido=".$idPedido;
	}
?>
	<script language="javascript" type="text/javascript">
		alert('<?php echo $mensajeReturn; ?>');
		window.open('<?php echo $urlReturn; ?>', '_self');
	</script>
<?php
}


// TipoAgregar PagoPedido
if($_REQUEST['tipoAgregar'] == 'PagoPedido'){

	$sqlConsultaImportePedido = "
		Select * From
			`tienda_pedidos`
		Where 
			`idPedido` = '$idPedido'
								  ";
	$resConsultaImportePedido = DreQueryDB($sqlConsultaImportePedido);
	$rowConsultaImportePedido = mysql_fetch_assoc($resConsultaImportePedido);
		$yaPagado = $rowConsultaImportePedido['pagado'];
		$descripcion = "Pedido Tienda Web: ".$rowConsultaImportePedido['idPedido'];
	if($rowConsultaImportePedido['totalPedido'] >= $importePagado){
		$sqlInsertPagoPedido = "
			Insert Into `tienda_pedidos_pagar` 
				(
					`idPedido`
					,`importe`
					,`usuario`
					,`descripcion`
				)
				Values
				(
					'$idPedido'
					,'$importePagado'
					,'$usuarioPedido'
					,'$descripcion'
				);
								"; 
		DreQueryDB($sqlInsertPagoPedido);
		
		$NewPagado = $importePagado + $yaPagado; 
		$sqlUpdatePagadoPedido = "
			Update
				`tienda_pedidos`
			Set
				`pagado` = '$NewPagado'
			Where 
				`idPedido` = '$idPedido';
								   ";
		DreQueryDB($sqlUpdatePagadoPedido);
		
		$mensajeReturn = "Pedido Pagado Correctamente !!!";
		$urlReturn = "../tiendaPedidosPagarDetalle.php?idPedido=".$idPedido;
	} else {
		$mensajeReturn = "Pedido NO Pagado !!!";
		$urlReturn = "../tiendaPedidosPagarDetalle.php?idPedido=".$idPedido;
	}
?>
	<script language="javascript" type="text/javascript">
		alert('<?php echo $mensajeReturn; ?>');
		window.open('<?php echo $urlReturn; ?>', '_self');
	</script>
<?php
}

// TipoAgregar LlamadaCita
if($_REQUEST['tipoAgregar'] == 'LlamadaCita'){
	
	$recId = mysql_result(DreQueryDB("Select `valor`+1 From `configdre` Where `parametro` = 'folioLlamadaCita'"),0);
	DreQueryDB("Update `configdre` Set `valor` = '$recId' Where `parametro` = 'folioLlamadaCita'");
	$recId = "c".$recId;
		
	$sqlInsertIntoLlamadaCita = "
		Insert Into
			`actividades` 
			(
				`recId`
				, `idRef`
				, `tipo`
				, `referencia`
				, `usuario`
				, `usuarioCreacion`
				, `usuarioBolita`
			) 
			Values
			(
				'$recId'
				, '$CLAVE'
				, '$tipo'
				, '$comentario'
				, '$usuario'
				, '$usuario'
				, '$usuario'
			);
								";
	DreQueryDB($sqlInsertIntoLlamadaCita);									
		$mensajeReturn = strtoupper ($tipo)." Registrado con Exito !!!";
		$urlReturn = "../cliente.php?CLAVE=".$CLAVE;
?>
	<script language="javascript" type="text/javascript">
		alert('<?php echo $mensajeReturn; ?>');
		window.open('<?php echo $urlReturn; ?>', '_self');
	</script>
<?php
}

DreDesconectarDB($conexion);
?>