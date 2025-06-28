<?
//Adjuntar Imagen Cotizador Express
//** Archivo 1
	$archivoSeleccionado = $_FILES['archivo']['tmp_name'];
	if($archivoSeleccionado != ""){

		$idFile = mysql_result(DreQueryDB("Select Count(*) From `imagenes` Where `NO_ARCHIVO` Like '$recId%'"),0);
		$ArchivoWeb = $recId."_".$idFile;
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
					$idcon = ftp_connect($ftp_server)or die ("No Se Pudo Conectar al Servidor");
				//ftp_pasv($idcon, true);
					$login = ftp_login($idcon,$ftp_user,$ftp_pass) or die("No se Puede Iniciar Sesion");
					$put = ftp_put($idcon, $img_file, $archivoSeleccionado, FTP_BINARY) or die("Error al Subir el Archivo");
					//$put = true;

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
								,`TIPO`
								,`recId`
							)
						Values
							(
								'$ArchivoWeb'
								,'$extension'
								,''
								,'$DESCRIPCION'
								,'$POLIZA'
								,'$POLIZA'
								,'$TIPO_IMG_New'
								,'$idRef'
								,'$idRef'
								,'$SUCURSAL'
								,'$TIPO'
								,'$recId'
							)
										  ";
					DreQueryDB($sqlInsertImagenes);
					$textoAlertDocumento = "Documento Agregado con Exito !!!";
				} else {
					$textoAlertDocumento = "Error al Cargar Archivo !!!";
				}
	}

//** Archivo 2
	$archivoSeleccionado_2 = $_FILES['archivo_2']['tmp_name'];
	if(	$archivoSeleccionado_2 != ""){		
		$idFile_2 = mysql_result(DreQueryDB("Select Count(*) From `imagenes` Where `NO_ARCHIVO` Like '$recId%'"),0);
		$ArchivoWeb_2 = $recId."_".$idFile_2;
		$name_2 = $ArchivoWeb_2.$extension_2;

		$destino = "/" ;
		$img_file_2 = $destino.$name_2;
	
		$TIPO_IMG_2_Array = explode('*',$TIPO_IMG_2);
		$TIPO_IMG_2_New = $TIPO_IMG_2_Array[0];
		$TIPO2 = $TIPO_IMG_2_Array[1];

		if($TIPO2 == "P"){ $TIPO2 = "PO"; }else{ $TIPO2 = "CL"; }
		
			// Copiamos el Archivo nuevo
				// informacion del FTP Server
					$ftp_server = tipoFtp($_SERVER['REMOTE_ADDR']);
					$ftp_user = "userftp";
					$ftp_pass = "DreLearning2012";
				
				// Carga al FTP
					$idcon = ftp_connect($ftp_server)or die ("No Se Pudo Conectar al Servidor");
				//ftp_pasv($idcon, true);
					$login = ftp_login($idcon,$ftp_user,$ftp_pass) or die("No se Puede Iniciar Sesion");
					$put_2 = ftp_put($idcon, $img_file_2, $archivoSeleccionado_2, FTP_BINARY) or die("Error al Subir el Archivo");
					//$put_2 = true;

				if($put_2){
					$sqlInsertImagenes_2  = "
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
								,`TIPO`
								,`recId`
							)
						Values
							(
								'$ArchivoWeb_2'
								,'$extension_2'
								,''
								,'$DESCRIPCION_2'
								,'$POLIZA'
								,'$POLIZA'
								,'$TIPO_IMG_2_New'
								,'$idRef'
								,'$idRef'
								,'$SUCURSAL'
								,'$TIPO2'
								,'$recId'
							)
										  ";
					DreQueryDB($sqlInsertImagenes_2);
					$textoAlertDocumento = "Documento Agregado con Exito !!!";
				} else {
					$textoAlertDocumento = "Error al Cargar Archivo !!!";
				}
	}

//** Archivo 3
	$archivoSeleccionado_3 = $_FILES['archivo_3']['tmp_name'];
	if($archivoSeleccionado_3 != ""){
		
		$idFile_3 = mysql_result(DreQueryDB("Select Count(*) From `imagenes` Where `NO_ARCHIVO` Like '$recId%'"),0);
		$ArchivoWeb_3 = $recId."_".$idFile_3;
		$name_3 = $ArchivoWeb_3.$extension_3;

		$destino = "/" ;
		$img_file_3 = $destino.$name_3;
	
		$TIPO_IMG_3_Array = explode('*',$TIPO_IMG_3);
		$TIPO_IMG_3_New = $TIPO_IMG_3_Array[0];
		$TIPO3 = $TIPO_IMG_3_Array[1];

		if($TIPO3 == "P"){ $TIPO3 = "PO"; }else{ $TIPO3 = "CL"; }
		
			// Copiamos el Archivo nuevo
				// informacion del FTP Server
					$ftp_server = tipoFtp($_SERVER['REMOTE_ADDR']);
					$ftp_user = "userftp";
					$ftp_pass = "DreLearning2012";
				
				// Carga al FTP
					$idcon = ftp_connect($ftp_server)or die ("No Se Pudo Conectar al Servidor");
				//ftp_pasv($idcon, true);
					$login = ftp_login($idcon,$ftp_user,$ftp_pass) or die("No se Puede Iniciar Sesion");
					$put_3 = ftp_put($idcon, $img_file_3, $archivoSeleccionado_3, FTP_BINARY) or die("Error al Subir el Archivo");
					//$put_3 = true;

				if($put_3){
					$sqlInsertImagenes_3  = "
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
								,`TIPO`
								,`recId`
							)
						Values
							(
								'$ArchivoWeb_3'
								,'$extension_3'
								,''
								,'$DESCRIPCION_3'
								,'$POLIZA'
								,'$POLIZA'
								,'$TIPO_IMG_3_New'
								,'$idRef'
								,'$idRef'
								,'$SUCURSAL'
								,'$TIPO3'
								,'$recId'
							)
										  ";
					DreQueryDB($sqlInsertImagenes_3);
					$textoAlertDocumento = "Documento Agregado con Exito !!!";
				} else {
					$textoAlertDocumento = "Error al Cargar Archivo !!!";
				}
	}
?>