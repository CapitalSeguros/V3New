<?php
$sqlFianzas = "
	Select * From `actividades_formularios`
	Where 
		`idActividad` = '$rowDatosActividad[recId]'
		And 
		`ramoInterno`= '$rowDatosActividad[ramoInterno]'
											";
$resFianzas = DreQueryDB($sqlFianzas);
$rowFianzas = mysql_fetch_assoc($resFianzas);
?>
<table width="610" cellpadding="5" cellspacing="2" border="0" align="center">
<form name="formLineasPersonales" id="formLineasPersonales" method="post" action="includes/guardar.php?tipoGuardar=formularios">    
	<tr>
	  <td align="right">Nombre beneficiario:</td>
	  <td><input name="nombre_beneficiario" type="text" id="nombre_beneficiario" value="<?php echo $rowFianzas['nombre_beneficiario'] ?>" size="50" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td width="150" align="right">Monto fianza:</td>
	  <td><input name="monto_fianza" type="text" id="monto_fianza" value="<?php echo $rowFianzas['monto_fianza'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
  </tr>
	<tr>
	  <td align="right">Tipo Fianza:</td>
	  <td>
		<?php echo SelectTipoFianza($rowFianzas['tipo_fianza'],$rowDatosFormulario['estatus']); ?>
	  </td>
    </tr>
	<tr>
	  <td colspan="2">Observaciones:</td>
  </tr>
	<tr>
	  <td colspan="2"><textarea name="observaciones" cols="80" id="observaciones" <?php echo campoBloqueado($rowDatosFormulario['estatus']);?>><?php echo $rowFianzas['observaciones'] ?></textarea>
      </td>
  </tr>
	<tr>
	  <td colspan="2" align="right">
      <input type="hidden" name="ramoInterno" id="ramoInterno" value="<?php echo $rowDatosActividad['ramoInterno']; ?>" />
      <input type="hidden" name="muestra" id="muestra" value="<?php echo $muestra; ?>" />
      <input type="hidden" name="idActividad" id="idActividad" value="<?php echo $rowDatosActividad['recId']; ?>" />
      <input type="hidden" name="tipoFianzas" id="tipoFianzas" value="<?php echo $tipoFianzas; ?>" />
	<?php
$sqlExisteFormularioActividad = "
			Select * From 
				`actividades_formularios` 
			Where 
				`idActividad` = '$rowDatosActividad[recId]' 
				And 
				`ramoInterno` = '$rowDatosActividad[ramoInterno]' 
						  "; 
	if(mysql_num_rows(DreQueryDB($sqlExisteFormularioActividad))==0){
	?>
		<input type="button" value="Guardar Formulario" class="buttonGeneral" title="Clic para Guardar" onclick="java:document.formLineasPersonales.submit()" />
		&nbsp;&nbsp;&nbsp;
<?php
	}
?>
      </td>
  </tr>
</form>

</table>