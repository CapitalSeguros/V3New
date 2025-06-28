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
        	Accidentes Personales Escolares 
        </td>
   	</tr>
<form name="formLineasPersonales" id="formLineasPersonales" method="post" action="includes/guardar.php?tipoGuardar=formularios">    
	<tr>
	  <td width="160" align="right">Nombre Escuela:</td>
	  <td><input name="nombre_escuela" type="text" id="nombre_escuela" value="<?php echo $rowLineasPersonales_accidentesPersonales['nombre_escuela'] ?>" size="50" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
  </tr>
	<tr>
	  <td align="right">No. Alum. &#247; 0-11 A&ntilde;os:</td>
	  <td><input name="alumnos_0_11" type="text" id="alumnos_0_11" value="<?php echo $rowLineasPersonales_accidentesPersonales['alumnos_0_11'] ?>" size="10" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">No. Alum. &#247; 12-60 A&ntilde;os:</td>
	  <td><input name="alumnos_12_60" type="text" id="alumnos_12_60" value="<?php echo $rowLineasPersonales_accidentesPersonales['alumnos_12_60'] ?>" size="10" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">No. Pers. &#247; 18-60 A&ntilde;os:</td>
	  <td><input name="docente_18_60" type="text" id="docente_18_60" value="<?php echo $rowLineasPersonales_accidentesPersonales['docente_18_60'] ?>" size="10" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td colspan="2">
      <font style="font-size:9px">
	    **De preferencia incluir listado de ni&ntilde;os por grado escolar, con Nombre / Fecha de Nacimiento y Sexo
      </font>
	  </td>
    </tr>
	<tr>
	  <td align="right">Tipo de Escuela:</td>
	  <td>
		<?php echo SelectTipoEscuela($rowLineasPersonales_accidentesPersonales['tipo_escuela'],$rowDatosFormulario['estatus']); ?>
      </td>
  </tr>
	<tr>
	  <td align="right">Deducible:</td>
	  <td><input name="deducible" type="text" id="deducible" value="<?php echo $rowLineasPersonales_accidentesPersonales['deducible'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">&nbsp;</td>
	  <td>
      <font style="font-size:9px">
       **Por Default se cotiza en el deducible m&aacute;s bajo por Aseguradora
      </font>
      </td>
    </tr>
	<tr>
	  <td colspan="2">Coberturas Adicionales</td>
    </tr>
	<tr>
	  <td colspan="2"><textarea name="coberturas_adicionales" cols="80" id="coberturas_adicionales" <?php echo campoBloqueado($rowDatosFormulario['estatus']);?>><?php echo $rowLineasPersonales_accidentesPersonales['coberturas_adicionales'] ?></textarea></td>
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