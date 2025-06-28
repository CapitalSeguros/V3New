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
        	Accidentes Personales 
        </td>
   	</tr>
<form name="formLineasPersonales" id="formLineasPersonales" method="post" action="includes/guardar.php?tipoGuardar=formularios">    
	<tr>
	  <td width="150" align="right">Fecha de nacimiento:</td>
	  <td><input name="fecha_nacimiento" type="text" id="fecha_nacimiento" value="<?php echo $rowLineasPersonales_accidentesPersonales['fecha_nacimiento'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/>
                  <img src="img/cal.gif" id="fecha_nacimiento_Btn"  title="Clic">
      </td>
  </tr>
	<tr>
	  <td align="right">Sexo:</td>
	  <td>
		<?php echo SelectSexo($rowLineasPersonales_accidentesPersonales['sexo'],$rowDatosFormulario['estatus'],'sexo'); ?>
      </td>
  </tr>
	<tr>
	  <td align="right">Tiempo de cobertura:</td>
	  <td><input name="tiempo_cobertura" type="text" id="tiempo_cobertura" size="50" maxlength="299" value="<?php echo $rowLineasPersonales_accidentesPersonales['tiempo_cobertura'] ?>" <?php echo campoBloqueado($rowDatosFormulario['estatus']);?>/></td>
  </tr>
	<tr>
	  <td align="right">Actividad Laboral:</td>
	  <td><input name="actividad_laboral" type="text" id="actividad_laboral" size="50" maxlength="299" value="<?php echo $rowLineasPersonales_accidentesPersonales['actividad_laboral'] ?>" <?php echo campoBloqueado($rowDatosFormulario['estatus']);?>/></td>
  </tr>
	<tr>
	  <td align="right">Forma de Pago:</td>
	  <td>
		<?php echo SelectFormaPago($rowLineasPersonales_accidentesPersonales['forma_pago'],$rowDatosFormulario['estatus']); ?>
      </td>
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
      <input type="submit" value="Guardar Formulario" class="buttonGeneral" title="Clic para Guardar"/>
      &nbsp;&nbsp;&nbsp;
<?php
	}
?>

      </td>
	</tr>
</form>
<?php
	if(mysql_num_rows(DreQueryDB($sqlExisteFormularioActividad))>0){
?>
	<tr>
		<td colspan="2">Incluir personas adiciones a contratar:</td>
	</tr>
	<tr>
		<td colspan="2" align="center">
		<?php include('add_personaAdicional.php'); ?>
		</td>
	</tr>
<?php
	}
?>
</table>
<script type="text/javascript">
	Calendar.setup({
		inputField : "fecha_nacimiento",
		trigger    : "fecha_nacimiento_Btn",
		onSelect   : function() { this.hide() },
		dateFormat : "%d-%m-%Y"
	});
</script>