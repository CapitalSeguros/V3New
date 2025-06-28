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
        	Hogar
		</td>
   	</tr>
<form name="formLineasPersonales" id="formLineasPersonales" method="post" action="includes/guardar.php?tipoGuardar=formularios">
	<tr>
	  <td width="150" align="right">Estado:</td>
	  <td><?php echo SelectEstado($rowDanos['estado'],$rowDatosFormulario['estatus']); ?></td>
  </tr>
	<tr>
	  <td align="right">Poblacion :</td>
	  <td><input name="poblacion" type="text" id="poblacion" value="<?php echo $rowDanos['poblacion'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Codigo Postal:</td>
	  <td><input name="codigo_postal" type="text" id="codigo_postal" value="<?php echo $rowDanos['codigo_postal'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Colonia:</td>
	  <td><input name="colonia" type="text" id="colonia" value="<?php echo $rowDanos['colonia'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Contratante:</td>
	  <td><input name="numero_serie" type="text" id="numero_serie" value="<?php echo $rowDanos['numero_serie'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Recibe Rentas:</td>
	  <td><input name="recibe_rentas" type="text" id="recibe_rentas" value="<?php echo $rowDanos['recibe_rentas'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Tipo de Alarma:</td>
	  <td><input name="tipo_alarma" type="text" id="tipo_alarma" value="<?php echo $rowDanos['tipo_alarma'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Inicio Vigencia:</td>
	  <td><input name="inicio_vigencia" type="text" id="inicio_vigencia" value="<?php echo $rowDanos['inicio_vigencia'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Muro:</td>
	  <td>
      <?php echo SelectMuro($rowDanos['muro'],$rowDatosFormulario['estatus']);?></td>
    </tr>
	<tr>
	  <td align="right">Techos:</td>
	  <td><?php echo SelectTecho($rowDanos['techo'],$rowDatosFormulario['estatus']);?></td>
    </tr>
	<tr>
	  <td align="right">Tipo  Vivienda:</td>
	  <td><?php echo SelectTipoVivienda($rowDanos['tipo_vivienda'],$rowDatosFormulario['estatus']);?></td>
    </tr>
	<tr>
	  <td align="right">No. Sotanos:</td>
	  <td><input name="numero_sotanos" type="text" id="numero_sotanos" value="<?php echo $rowDanos['numero_sotanos'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">No. Pisos:</td>
	  <td><input name="numero_pisos" type="text" id="numero_pisos" value="<?php echo $rowDanos['numero_pisos'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">M2 Construccion:</td>
	  <td><input name="metros_construccion" type="text" id="metros_construccion" value="<?php echo $rowDanos['metros_construccion'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Edificio $:</td>
	  <td><input name="dinero_edificio" type="text" id="dinero_edificio" value="<?php echo $rowDanos['dinero_edificio'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Contenidos $:</td>
	  <td><input name="dinero_contenido" type="text" id="dinero_contenido" value="<?php echo $rowDanos['dinero_contenido'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Remocion Escombro $:</td>
	  <td><input name="dinero_escombro" type="text" id="dinero_escombro" value="<?php echo $rowDanos['dinero_escombro'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Gastos Extraordinarios:</td>
	  <td><?php echo SelectGastosExtraordinarios($rowDanos['gastos_extraordinarios'],$rowDatosFormulario['estatus']);?></td>
    </tr>
	<tr>
	  <td align="right">Cristales:</td>
	  <td><input name="cristales" type="text" id="cristales" value="<?php echo $rowDanos['cristales'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Responsabilidad Civil:</td>
	  <td><input name="responsabilidad_civil" type="text" id="responsabilidad_civil" value="<?php echo $rowDanos['responsabilidad_civil'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Perdida  Ingresos:</td>
	  <td><input name="perdida_ingresos" type="text" id="perdida_ingresos" value="<?php echo $rowDanos['perdida_ingresos'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Robo Contenidos:</td>
	  <td><input name="robo_contenidos" type="text" id="robo_contenidos" value="<?php echo $rowDanos['robo_contenidos'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Robo Fuera:</td>
	  <td><input name="robo_fuera" type="text" id="robo_fuera" value="<?php echo $rowDanos['robo_fuera'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Dinero y Valores:</td>
	  <td><input name="dinero_valores" type="text" id="dinero_valores" value="<?php echo $rowDanos['dinero_valores'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Ajuste Aut. %:</td>
	  <td><input name="ajuste" type="text" id="ajuste" value="<?php echo $rowDanos['ajuste'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Terremoto, Erupcion Volcanica Edificio:</td>
	  <td><input name="edificion_terremoto_volcan" type="text" id="edificion_terremoto_volcan" value="<?php echo $rowDanos['edificion_terremoto_volcan'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Fenomenos Hidrometeorologicos Edificio:</td>
	  <td><input name="edificio_hidrometeorologico" type="text" id="edificio_hidrometeorologico" value="<?php echo $rowDanos['edificio_hidrometeorologico'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Terremoto, Erupcion Volcanica Contenidos:</td>
	  <td><input name="contenidos_terremoto_volcan" type="text" id="contenidos_terremoto_volcan" value="<?php echo $rowDanos['contenidos_terremoto_volcan'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Fenomenos Hidrometeorologicos Contenidos:</td>
	  <td><input name="contenidos_hidrometeorologico" type="text" id="contenidos_hidrometeorologico" value="<?php echo $rowDanos['contenidos_hidrometeorologico'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Uso:</td>
	  <td><?php echo SelectUsoHogar($rowDanos['uso_hogar'],$rowDatosFormulario['estatus']);?></td>
    </tr>
	<tr>
	  <td align="right">Regimen:</td>
	  <td><?php echo SelectRegimenHogar($rowDanos['regimen_hogar'],$rowDatosFormulario['estatus']);?></td>
    </tr>
	<tr>
	  <td align="right">Beneficiario Pref.:</td>
	  <td><input name="nombre_beneficiario" type="text" id="nombre_beneficiario" value="<?php echo $rowDanos['nombre_beneficiario'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Moneda:</td>
	  <td><?php echo SelectTipoMoneda($rowDanos['moneda'],$rowDatosFormulario['estatus'],'moneda'); ?></td>
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