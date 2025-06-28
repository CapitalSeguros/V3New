<?php
$sqlDatosUsuario = "
		Select 
			*
			,`info_usuarios_vendedores`.`SUCURSAL` As `sucursalInfo`
			,`usuarios`.`VALOR` As `usuarioInfo`
			,`info_usuarios_vendedores`.`NOMBRE` As `nombreInfo`	
			,`info_usuarios_vendedores`.`EMAIL` As `emailInfo`	
		From 
			`info_usuarios_vendedores` Inner Join `usuarios` 
			On 
			`info_usuarios_vendedores`.`VALOR` = `usuarios`.`VALOR`
		Where 

			`usuarios`.`VALOR` = '$Usuario'
					   ";
$resDatosUsuario = DreQueryDB($sqlDatosUsuario);
$rowDatosUsuario = mysql_fetch_assoc($resDatosUsuario);	

//** Guardamos Foto	
	$filePhotoUser = $_FILES['imageUser']['tmp_name'];
if($filePhotoUser != ""){
		$PhotoUser = $VALOR;
		$namePhoto = $PhotoUser.$extension;

		$destino = "/" ;
		$img_file = $destino.$namePhoto;

	if (file_exists("img/usuarios/".$namePhoto)) { unlink("img/usuarios/".$namePhoto); } // Borramos el archivo si existe
	if(copy($_FILES['imageUser']['tmp_name'], "img/usuarios/".$namePhoto)) { // Copiamos el archivo si existe
	
			// Copiamos el Archivo nuevo
				// informacion del FTP Server
					$ftp_server = tipoFtp($_SERVER['REMOTE_ADDR']);
					$ftp_user = "userftp";
					$ftp_pass = "DreLearning2012";
				
				// Carga al FTP
					$idcon = ftp_connect($ftp_server)or die ("No Se Pudo Conectar al Servidor");
				//ftp_pasv($idcon, true);
					$login = ftp_login($idcon,$ftp_user,$ftp_pass) or die("No se Puede Iniciar Sesion");
					//** $put = ftp_put($idcon, $img_file, $archivoSeleccionado, FTP_BINARY) or die("Error al Subir el Archivo");
	}

//**	header("Location: miInfoEditarPhoto.php?VALOR=".$VALOR);
	?>
    <script>
		alert('Foto de Perfil Actualizada !!!');
		window.open('<? echo "miInfoEditarPhoto.php?VALOR=".$VALOR; ?>', '_self');
	</script>
    <?
}

?>
<table width="950" cellpadding="0" cellspacing="0" border="0">
	<tr class="TextoTitulosSeccion" align="left">
		<td>
        	Mi Info
		</td>
	</tr>
<!-- <form name="formMiInfoEditar" id="formMiInfoEditar" method="post" enctype="multipart/form-data" action="includes/editar.php?tipoEdicion=MiInfo"> -->
	<tr>
		<td>
        	<!-- InfoEmpresa -->
			<table width="900" cellpadding="2" cellspacing="0" align="center" border="0" style="font-size:12px;">
            	<tr>
                	<td width="80" align="left">Sucursal:</td>
                    <td colspan="2" align="left"><strong><?php echo $rowDatosUsuario['sucursalInfo']; ?></strong></td>
                    <td colspan="2" rowspan="5" align="right" valign="top">
<?
if(file_exists("img/usuarios/".$VALOR.".jpg")){
?>
						<img src="<? echo "img/usuarios/".$VALOR.".jpg"; ?>" width="200;" />
<?
} else {
?>
						<img src="img/usuarios/noPhoto.png" width="102" height="122" />
<?
}
?>
                    </td>
                </tr>
                <tr>
                	<td align="left">Usuario:</td>
                    <td colspan="2" align="left"><strong><?php echo $rowDatosUsuario['usuarioInfo']; ?></strong></td>
                </tr>
				<tr>
                	<td align="left">Nombre:</td>
                    <td colspan="2" align="left"><strong><?php echo $rowDatosUsuario['nombreInfo']; ?></strong></td>
                </tr>
				<tr>
                	<td align="left">Apellido:</td>
                    <td colspan="2" align="left"><strong><?php echo $rowDatosUsuario['APELLIDOS']; ?></strong></td>
                </tr>
                <tr>
                	<td align="left">Promotor:</td>
                    <td colspan="2" align="left"><strong><?php echo $rowDatosUsuario['CONSULTOR'];?></strong></td>
                </tr>
                <tr>
                	<td colspan="5" align="left"><hr /></td>
				</tr>
                <tr>
                	<td width="80" align="center"></td>
                	<td width="320" align="center"></td>
                	<td width="100" align="center"></td>
                	<td width="320" align="center"></td>
                	<td width="80" align="left"></td>
                </tr>                
                <tr>
                	<td colspan="5">&nbsp;</td>
                </tr>
                <tr>
                	<td colspan="5">
	<h2>Suba su Foto</h2>
	<form id="photo" name="photo" action="<?php echo $_SERVER["PHP_SELF"];?>" method="post" enctype="multipart/form-data">
		<input type="hidden" name="extension" id="extension" />
		<input type="file" name="imageUser" id="imageUser" size="30" onChange="calcularExtensionPhotoUser(this.form);" /> 
        <input type="submit" name="upload" value="Subir" />
        <input type="hidden" id="VALOR" name="VALOR" value="<? echo $VALOR; ?>" />
	</form>
                    </td>
                </tr>
			</table>
  <tr>
    	<td>&nbsp;</td>
    </tr>
</table>