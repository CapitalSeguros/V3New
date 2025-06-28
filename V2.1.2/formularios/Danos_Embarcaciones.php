<?php
$sqlDanos = "
	Select * From `actividades_formularios`
	Where 
		`idActividad` = '$rowDatosActividad[recId]'
		And 
		`ramoInterno`= '$rowDatosActividad[ramoInterno]'
											";
$resDanos = DreQueryDB($sqlDanos);
$rowDanos = mysql_fetch_assoc($resDanos);
?>
<br />
<table width="610" cellpadding="5" cellspacing="2" border="0" align="center">
	<tr>
    	<td colspan="2" class="TextoTitulosEdicionAgregar">
        	Embarcaciones
		</td>
   	</tr>
<form name="formLineasPersonales" id="formLineasPersonales" method="post" action="includes/guardar.php?tipoGuardar=formularios">
	<tr>
	  <td width="150" align="right">Nombre Embarcaci&oacute;n:</td>
	  <td><input name="nombre_embarcacion" type="text" id="nombre_embarcacion" value="<?php echo $rowDanos['nombre_embarcacion'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
  </tr>
	<tr>
	  <td align="right">Marca :</td>
	  <td><input name="marca_embarcacion" type="text" id="marca_embarcacion" value="<?php echo $rowDanos['marca_embarcacion'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Modelo:</td>
	  <td><input name="modelo_embarcacion" type="text" id="modelo_embarcacion" value="<?php echo $rowDanos['modelo_embarcacion'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Tipo / Descripcion:</td>
	  <td><input name="comentario" type="text" id="comentario" value="<?php echo $rowDanos['comentario'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">N&uacute;mero Serie:</td>
	  <td><input name="numero_serie" type="text" id="numero_serie" value="<?php echo $rowDanos['numero_serie'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Matricula:</td>
	  <td><input name="matricula" type="text" id="matricula" value="<?php echo $rowDanos['matricula'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Uso:</td>
	  <td><input name="uso_embarcacion" type="text" id="uso_embarcacion" value="<?php echo $rowDanos['uso_embarcacion'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">A&ntilde;o de Construcci&oacute;n:</td>
	  <td><input name="year_embarcacion" type="text" id="year_embarcacion" value="<?php echo $rowDanos['year_embarcacion'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Mat. Construcci&oacute;n:</td>
	  <td><textarea name="materiales_embarcacion" id="materiales_embarcacion" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>><?php echo $rowDanos['materiales_embarcacion'] ?></textarea></td>
    </tr>
	<tr>
	  <td align="right">Medida Eslora:</td>
	  <td><input name="medida_eslora" type="text" id="medida_eslora" value="<?php echo $rowDanos['medida_eslora'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Medida Manga:</td>
	  <td><input name="medida_manga" type="text" id="medida_manga" value="<?php echo $rowDanos['medida_manga'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Medida Puntal:</td>
	  <td><input name="medida_puntal" type="text" id="medida_puntal" value="<?php echo $rowDanos['medida_puntal'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Bandera:</td>
	  <td><input name="bandera" type="text" id="bandera" value="<?php echo $rowDanos['bandera'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Puerto Base:</td>
	  <td><input name="puerto_base" type="text" id="puerto_base" value="<?php echo $rowDanos['puerto_base'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Aguas que Navega:</td>
	  <td><input name="aguas_navega" type="text" id="aguas_navega" value="<?php echo $rowDanos['aguas_navega'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Capacidad:</td>
	  <td><input name="capacidad_embarcacion" type="text" id="capacidad_embarcacion" value="<?php echo $rowDanos['capacidad_embarcacion'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Motor Marca:</td>
	  <td><input name="marca_motor" type="text" id="marca_motor" value="<?php echo $rowDanos['marca_motor'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Motor Modelo:</td>
	  <td><input name="modelo_motor" type="text" id="modelo_motor" value="<?php echo $rowDanos['modelo_motor'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Motor Cantidad:</td>
	  <td><input name="cantidad_motor" type="text" id="cantidad_motor" value="<?php echo $rowDanos['cantidad_motor'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Motor No. Serie:</td>
	  <td><input name="numero_serie_motor" type="text" id="numero_serie_motor" value="<?php echo $rowDanos['numero_serie_motor'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Motor Potencia:</td>
	  <td><input name="potencia_motor" type="text" id="potencia_motor" value="<?php echo $rowDanos['potencia_motor'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Peso Bruto:</td>
	  <td><input name="peso_bruto" type="text" id="peso_bruto" value="<?php echo $rowDanos['peso_bruto'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Peso Neto:</td>
	  <td><input name="peso_neto" type="text" id="peso_neto" value="<?php echo $rowDanos['peso_neto'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Moneda:</td>
	  <td><?php echo SelectTipoMoneda($rowDanos['moneda'],$rowDatosFormulario['estatus'],'moneda'); ?></td>
    </tr>
	<tr>
	  <td align="right">Suma Aseg. (V. Casco):</td>
	  <td><input name="suma_asegurada" type="text" id="suma_asegurada" value="<?php echo $rowDanos['suma_asegurada'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Monto Siniestros Ant.</td>
	  <td><input name="monto_siniestro" type="text" id="monto_siniestro" value="<?php echo $rowDanos['monto_siniestro'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Forma pago:</td>
	  <td>
      	<?php echo SelectFormaPago($rowDanos['forma_pago'],$rowDatosFormulario['estatus']); ?>
      </td>
    </tr>
	<tr>
	  <td colspan="2">Observaciones:</td>
  </tr>
	<tr>
	  <td colspan="2"><textarea name="observaciones" cols="80" id="observaciones" <?php echo campoBloqueado($rowDatosFormulario['estatus']);?>><?php echo $rowDanos['observaciones'] ?></textarea>
      </td>
  </tr>
	<tr>
	  <td colspan="2" align="right">
      <input type="hidden" name="ramoInterno" id="ramoInterno" value="<?php echo $rowDatosActividad['ramoInterno']; ?>" />
      <input type="hidden" name="muestra" id="muestra" value="<?php echo $muestra; ?>" />
      <input type="hidden" name="idActividad" id="idActividad" value="<?php echo $rowDatosActividad['recId']; ?>" />
      <input type="hidden" name="tipoDanos" id="tipoDanos" value="<?php echo $tipoDanos; ?>" />
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