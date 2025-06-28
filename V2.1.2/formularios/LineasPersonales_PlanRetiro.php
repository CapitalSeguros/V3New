<?php
$sqlLineasPersonales_accidentesPersonales = "
	Select * From `actividades_formularios`
	Where 
		`idActividad` = '$rowDatosActividad[recId]'
		And 
		`ramoInterno`= '$rowDatosActividad[ramoInterno]'
											";
$resLineasPersonales_accidentesPersonales = DreQueryDB($sqlLineasPersonales_accidentesPersonales);
$rowLineasPersonales_accidentesPersonales = mysql_fetch_assoc($resLineasPersonales_accidentesPersonales);
?>
<br />
<table width="610" cellpadding="5" cellspacing="2" border="0" align="center">
	<tr>
    	<td colspan="2" class="TextoTitulosEdicionAgregar">
        	Plan de Retiro
        </td>
   	</tr>
<form name="formLineasPersonales" id="formLineasPersonales" method="post" action="includes/guardar.php?tipoGuardar=formularios">    
	<tr>
	  <td align="right">Nombre titular:</td>
	  <td><input name="nombre" type="text" id="nombre" value="<?php echo $rowLineasPersonales_accidentesPersonales['nombre'] ?>" size="50" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td width="150" align="right">Fecha  nac. titular:</td>
	  <td><input name="fecha_nacimiento" type="text" id="fecha_nacimiento" value="<?php echo $rowLineasPersonales_accidentesPersonales['fecha_nacimiento'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/>
      <img src="img/cal.gif" id="fecha_nacimiento_Btn"  title="Clic">
      </td>
  </tr>
	<tr>
	  <td align="right">Sexo titular:</td>
	  <td>
		<?php echo SelectSexo($rowLineasPersonales_accidentesPersonales['sexo'],$rowDatosFormulario['estatus'],'sexo'); ?>
	  </td>
    </tr>
	<tr>
	  <td align="right">&iquest;Fuma titular?:</td>
	  <td>
      <?php echo SelectSiNo($rowLineasPersonales_accidentesPersonales['fuma'],$rowDatosFormulario['estatus'],'fuma'); ?>
      </td>
    </tr>
	<tr>
	  <td align="right">Edad retiro:</td>
	  <td>
		<?php echo SelectEdadRetiro($rowLineasPersonales_accidentesPersonales['edad_retiro'],$rowDatosFormulario['estatus']); ?>
      </td>
    </tr>
	<tr>
	  <td align="right">&nbsp;</td>
	  <td>
      <font style="font-size:9px">
       **Se recomienda un plazo a 65 a&ntilde;os
      </font>
      </td>
    </tr>
	<tr>
	  <td align="right">Suma aseg. ahorro:</td>
	  <td><input name="suma_asegurada" type="text" id="suma_asegurada" value="<?php echo $rowLineasPersonales_accidentesPersonales['suma_asegurada'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">&iquest;Cobertura Invalidez?:</td>
	  <td>
		<?php echo SelectSiNo($rowLineasPersonales_accidentesPersonales['cobertura_invalidez'],$rowDatosFormulario['estatus'],'cobertura_invalidez'); ?>
      </td>
    </tr>
	<tr>
	  <td align="right">Moneda:</td>
	  <td>
      <?php echo SelectTipoMoneda($rowLineasPersonales_accidentesPersonales['moneda'],$rowDatosFormulario['estatus'],'moneda'); ?>
      </td>
    </tr>
	<tr>
	  <td align="right">Forma de Pago:</td>
	  <td><?php echo SelectFormaPago($rowLineasPersonales_accidentesPersonales['forma_pago'],$rowDatosFormulario['estatus']); ?></td>
    </tr>
	<tr>
	  <td colspan="2">Observaciones:</td>
  </tr>
	<tr>
	  <td colspan="2"><textarea name="observaciones" cols="80" id="observaciones" <?php echo campoBloqueado($rowDatosFormulario['estatus']);?>><?php echo $rowLineasPersonales_accidentesPersonales['observaciones'] ?></textarea>
      </td>
  </tr>
	<tr>
	  <td colspan="2" align="right">
      <input type="hidden" name="ramoInterno" id="ramoInterno" value="<?php echo $rowDatosActividad['ramoInterno']; ?>" />
      <input type="hidden" name="idActividad" id="idActividad" value="<?php echo $rowDatosActividad['recId']; ?>" />
      <input type="hidden" name="muestra" id="muestra" value="<?php echo $muestra; ?>" />
      <input type="hidden" name="tipoLineaPersonal" id="tipoLineaPersonal" value="<?php echo $tipoLineaPersonal; ?>" />
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
<script type="text/javascript">
	Calendar.setup({
		inputField : "fecha_nacimiento",
		trigger    : "fecha_nacimiento_Btn",
		onSelect   : function() { this.hide() },
		dateFormat : "%d-%m-%Y"
	});
</script>