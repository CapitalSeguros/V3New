<!-- Multi Archivos -->
<table width="850" align="center" cellpadding="1" cellspacing="2" border="0">
<?php
	if(
		$rowActividad['actividadInterno'] == "Emisi%F3n" 
		&& 
		$_SESSION['WebDreTacticaWeb']['NIVEL'] != 2
	){
?>
	<tr>
		<td colspan="2">
			Poliza
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<input type="text" name="POLIZA" id="POLIZA" size="25"/>
			<input type="hidden" name="validacionPoliza" id="validacionPoliza" value="S" />
		</td>
	</tr>
<?php
	} else {
?>
	<tr>
		<td colspan="2">
			<input type="hidden" name="POLIZA" id="POLIZA" size="25"/>
			<input type="hidden" name="validacionPoliza" id="validacionPoliza" value="N" />
		</td>
	</tr>
<?php	
	}
?>
	<tr>
		<td colspan="2">
			Descripcion Archivo 1
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<input type="text" name="DESCRIPCION" id="DESCRIPCION" value="<?php echo $descripcionVehiculo; ?>" style="width:100%"/>
		</td>
	</tr>
	<tr>
		<td>Tipo Img</td>
		<td>Archivo 1</td>
	</tr>
	<tr>
		<td>
			<select name="TIPO_IMG" id="TIPO_IMG">
				<option value="">-- Seleccione  --</option>
				<?php
					$sqlTipoImg = "Select * From `tiposdoctos`";
					$resTipoImg = DreQueryDB($sqlTipoImg);
					while($rowTipoImg = mysql_fetch_assoc($resTipoImg)){
				?>
				<option value="<?php echo $rowTipoImg['DESCRIPCION']."*".$rowTipoImg['APLICA']; ?>">
					<?php echo $rowTipoImg['DESCRIPCION']; ?>
				</option>
				<?php
					}
				?>
			</select>
		</td>
		<td>
			<input type="hidden" name="extension" id="extension" />
			<input type="file" name="archivo" id="archivo" size="40" onChange="calcularExtensionArchivo(this.form);" />
		</td>
	</tr>
	<tr>
		<td colspan="2">
			Descripcion Archivo 2
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<input type="text" name="DESCRIPCION_2" id="DESCRIPCION_2" style="width:100%"/>
		</td>
	</tr>
	<tr>
		<td>Tipo Img</td>
		<td>Archivo 2</td>
	</tr>
	<tr>
		<td>
			<select name="TIPO_IMG_2" id="TIPO_IMG_2">
				<option value="">-- Seleccione  --</option>
				<?php
					$sqlTipoImg = "Select * From `tiposdoctos`";
					$resTipoImg = DreQueryDB($sqlTipoImg);
					while($rowTipoImg = mysql_fetch_assoc($resTipoImg)){
				?>
				<option value="<?php echo $rowTipoImg['DESCRIPCION']."*".$rowTipoImg['APLICA']; ?>">
					<?php echo $rowTipoImg['DESCRIPCION']; ?>
				</option>
				<?php
					}
				?>
			</select>
		</td>
		<td>
			<input type="hidden" name="extension_2" id="extension_2" />
			<input type="file" name="archivo_2" id="archivo_2" size="40" onChange="calcularExtensionArchivo(this.form);" />
		</td>
	</tr>
	<tr>
		<td colspan="2">
			Descripcion Archivo 3
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<input type="text" name="DESCRIPCION_3" id="DESCRIPCION_3" style="width:100%"/>
		</td>
	</tr>
	<tr>
		<td>Tipo Img</td>
		<td>Archivo 3</td>
	</tr>
	<tr>
		<td>
			<select name="TIPO_IMG_3" id="TIPO_IMG_3">
				<option value="">-- Seleccione  --</option>
				<?php
					$sqlTipoImg = "Select * From `tiposdoctos`";
					$resTipoImg = DreQueryDB($sqlTipoImg);
					while($rowTipoImg = mysql_fetch_assoc($resTipoImg)){
				?>
				<option value="<?php echo $rowTipoImg['DESCRIPCION']."*".$rowTipoImg['APLICA']; ?>">
					<?php echo $rowTipoImg['DESCRIPCION']; ?>
				</option>
				<?php
					}
				?>
			</select>
		</td>
		<td>
        	<input type="hidden" name="extension_3" id="extension_3" />
			<input type="file" name="archivo_3" id="archivo_3" size="40" onChange="calcularExtensionArchivo(this.form); " />
		</td>
	</tr>
</table>
<!-- Multi Archivos -->