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
        	Vida Proteccion
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
	  <td align="right">Nombre conyuge:</td>
	  <td><input name="nombre_conyuge" type="text" id="nombre_conyuge" value="<?php echo $rowLineasPersonales_accidentesPersonales['nombre_conyuge'] ?>" size="50" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Fecha nac. conyuge:</td>
	  <td><input name="fecha_nacimiento_conyuge" type="text" id="fecha_nacimiento_conyuge" value="<?php echo $rowLineasPersonales_accidentesPersonales['fecha_nacimiento_conyuge'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/>
      <img src="img/cal.gif" id="fecha_nacimiento_conyuge_Btn"  title="Clic">
      </td>
    </tr>
	<tr>
	  <td align="right">Sexo conyuge:</td>
	  <td>
		<?php echo SelectSexo($rowLineasPersonales_accidentesPersonales['sexo_conyuge'],$rowDatosFormulario['estatus'],'sexo_conyuge'); ?>
      </td>
    </tr>
	<tr>
	  <td align="right">&iquest;Fuma conyuge?:</td>
	  <td>
		<?php echo SelectSiNo($rowLineasPersonales_accidentesPersonales['fuma_conyuge'],$rowDatosFormulario['estatus'],'fuma_conyuge'); ?>
      </td>
    </tr>
	<tr>
	  <td align="right">Suma asegurada:</td>
	  <td><input name="suma_asegurada" type="text" id="suma_asegurada" value="<?php echo $rowLineasPersonales_accidentesPersonales['suma_asegurada'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Moneda:</td>
	  <td>
      <?php echo SelectTipoMoneda($rowLineasPersonales_accidentesPersonales['moneda'],$rowDatosFormulario['estatus'],'moneda'); ?>
      </td>
    </tr>
	<tr>
	  <td align="right">Forma de Pago:</td>
	  <td>
		<?php echo SelectFormaPago($rowLineasPersonales_accidentesPersonales['forma_pago'],$rowDatosFormulario['estatus']); ?>
      </td>
    </tr>
	<tr>
	  <td align="right">&iquest;Cobertura invalidez?:</td>
	  <td><?php echo SelectSiNo($rowLineasPersonales_accidentesPersonales['cobertura_invalidez'],$rowDatosFormulario['estatus'],'cobertura_invalidez'); ?></td>
    </tr>
	<tr>
	  <td align="right">&iquest;Cobertura vitalicia?:</td>
	  <td>
		<?php echo SelectSiNo($rowLineasPersonales_accidentesPersonales['cobertura_vitalicia'],$rowDatosFormulario['estatus'],'cobertura_vitalicia'); ?>
      </td>
    </tr>
	<tr>
	  <td colspan="2">En caso de contestar que Si a la pregunta anterior: Indicar el plazo de pagos limitados en a&ntilde;os:<br />
	    En caso de contestar que No a la pregunta anterior: Indicar el plazo de la cobertura en a&ntilde;os:</td>
    </tr>
	<tr>
	  <td align="right">Plazo en a&ntilde;os:</td>
	  <td><input name="comentario" type="text" id="comentario" value="<?php echo $rowLineasPersonales_accidentesPersonales['comentario'] ?>" <?php echo campobloqueado($rowdatosformulario['estatus']);?>/>
      </td>
    </tr>
	<tr>
	  <td>&nbsp;</td>
	  <td>
      <font style="font-size:9px">
       **La cobertura ser&aacute; para toda la vida, pero el seguro se liquidar&aacute; en el n&uacute;mero de a&ntilde;os que se indique como plazo de Pago Limitado
      </font>
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
	Calendar.setup({
		inputField : "fecha_nacimiento_conyuge",
		trigger    : "fecha_nacimiento_conyuge_Btn",
		onSelect   : function() { this.hide() },
		dateFormat : "%d-%m-%Y"
	});
	Calendar.setup({
		inputField : "fecha_nacimiento_menor",
		trigger    : "fecha_nacimiento_menor_Btn",
		onSelect   : function() { this.hide() },
		dateFormat : "%d-%m-%Y"
	});
	
</script>