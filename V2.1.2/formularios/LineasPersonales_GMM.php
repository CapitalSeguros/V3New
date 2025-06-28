<?php
$sqlLineasPersonales_accidentesPersonales = "
	Select * From `actividades_formularios`
	Where 
		`idActividad` = '$rowDatosActividad[recId]'
		And 
		`ramoInterno`= '$rowDatosActividad[ramoInterno]'
											";
$resLineasPersonales_accidentesPersonales = DreQueryDB($sqlLineasPersonales_accidentesPersonales);
(int) $existeFormuario = mysql_num_rows($resLineasPersonales_accidentesPersonales);
$rowLineasPersonales_accidentesPersonales = mysql_fetch_assoc($resLineasPersonales_accidentesPersonales);
?>
<br />
<table width="610" cellpadding="5" cellspacing="2" border="0" align="center">
	<tr>
    	<td colspan="2" class="TextoTitulosEdicionAgregar">
        	Gastos Medicos Mayores
    	</td>
   	</tr>
<form name="formLineasPersonales" id="formLineasPersonales" method="post" action="includes/guardar.php?tipoGuardar=formularios">
<!--
	<tr>
	  <td width="150" align="right">Fecha  nacimiento:</td>
	  <td><input name="fecha_nacimiento" type="text" id="fecha_nacimiento" value="<?php //echo $rowLineasPersonales_accidentesPersonales['fecha_nacimiento'] ?>" maxlength="30" <?php //echo campoBloqueado($rowDatosFormulario['estatus']); ?>/>
      <img src="img/cal.gif" id="fecha_nacimiento_Btn"  title="Clic">
      </td>
  </tr>
	<tr>
	  <td align="right">Sexo :</td>
	  <td>
		<?php //echo SelectSexo($rowLineasPersonales_accidentesPersonales['sexo'],$rowDatosFormulario['estatus'],'sexo'); ?>
	  </td>
    </tr>
-->

	<tr>
	  <td width="150" align="right" valign="top">Aseguradoras a cotizar:</td>
	  <td style="font-size:12px;">
      	<?php
		if($existeFormuario == 0){
			$sqlAseguradoraSubRamo = "
				Select
					`catalogo_aseguradoras`.`idAseguradora`
					,`catalogo_aseguradoras`.`nombre`
					,`catalogo_aseguradoras`.`email`
					,`catalogo_aseguradoras_subramo`.`default`
				From 
					`catalogo_aseguradoras` Inner Join `catalogo_aseguradoras_subramo` 
					On 
					`catalogo_aseguradoras`.`idAseguradora` = `catalogo_aseguradoras_subramo`.`idAseguradora`
				Where
					`catalogo_aseguradoras_subramo`.`subRamo` = 'GASTOS MEDICOS'
									 ";
			$resAseguradoraSubRamo = DreQueryDB($sqlAseguradoraSubRamo);
			while($rowAseguradoraSubRamo = mysql_fetch_assoc($resAseguradoraSubRamo)){
        ?>
        	<input type="checkbox" name="addAseguradora[]" id="addAseguradora[]" value="<? echo $rowAseguradoraSubRamo['idAseguradora']; ?>" <? echo ($rowAseguradoraSubRamo['default'] == "1")? "checked":"";?> /><label><?php echo $rowAseguradoraSubRamo['nombre']; ?></label>
            <br>
      	<?php
			}
		} else {
			$sqlAseguradorasSeleccionadas = "
				Select
					`catalogo_aseguradoras`.`nombre`
				From 
					`actividades_formularios_aseguradora` Inner Join `catalogo_aseguradoras`
					On
					`actividades_formularios_aseguradora`.`aseguradora` = `catalogo_aseguradoras`.`idAseguradora`
				Where
					`actividades_formularios_aseguradora`.`idFormulario` = '$rowLineasPersonales_accidentesPersonales[idInterno]'
											";
			$resAseguradorasSeleccionadas = DreQueryDB($sqlAseguradorasSeleccionadas);
			while($rowAseguradorasSeleccionadas = mysql_fetch_assoc($resAseguradorasSeleccionadas)){
				echo "<strong>&bull;".$rowAseguradorasSeleccionadas['nombre']."</strong>";
				echo "<br>";
			}
		}
        ?>
      </td>
	</tr>
	<tr>
	  <td align="right">&iquest;Cobertura internacional?:</td>
	  <td><?php echo SelectSiNo($rowLineasPersonales_accidentesPersonales['cobertura_internacional'],$rowDatosFormulario['estatus'],'cobertura_internacional'); ?></td>
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
	  <td align="right">Coaseguro:</td>
	  <td><input name="coaseguro" type="text" id="coaseguro" value="<?php echo $rowLineasPersonales_accidentesPersonales['coaseguro'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">&nbsp;</td>
	  <td>
      <font style="font-size:9px">
       ** Por Default se cotiza un 10&#37
      </font>
      </td>
    </tr>
	<tr>
	  <td align="right">Nivel hospitalario:</td>
	  <td>
		<?php echo SelectNivelHospitalario($rowLineasPersonales_accidentesPersonales['nivel_hospitalario'],$rowDatosFormulario['estatus']); ?>
      </td>
    </tr>
	<tr>
	  <td align="right"><font color="red">*</font>Estado residencia:</td>
	  <td>
      
<?php echo SelectEstado($rowLineasPersonales_accidentesPersonales['estado'],$rowDatosFormulario['estatus']); ?>
      </td>
    </tr>
	<tr>
	  <td align="right"><font color="red">*</font>Forma pago:</td>
	  <td>
      	<?php echo SelectFormaPago($rowLineasPersonales_accidentesPersonales['forma_pago'],$rowDatosFormulario['estatus'], ''); ?>
      </td>
    </tr>
	<tr>
	  <td align="right"><font color="red">*</font>Reconocimiento de antig&uuml;edad:</td>
	  <td>
      	<select name="reconocimientoAntiguedad" id="reconocimientoAntiguedad">
        	<option value="">-Seleccione-</option>        
        	<option value="Si" <?php echo ($rowLineasPersonales_accidentesPersonales['reconocimientoAntiguedad'] == "Si")? "selected":""; ?>>Si</option>
        	<option value="No" <?php echo ($rowLineasPersonales_accidentesPersonales['reconocimientoAntiguedad'] == "No")? "selected":""; ?>>No</option>
        </select>
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
		<input type="button" value="A&ntilde;adir Asegurados" class="buttonGeneral" title="Clic para Guardar" onclick="validarFormularioGmm();" />
        <!-- java:document.formLineasPersonales.submit() -->
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
	  <td colspan="2">A&ntilde;adir asegurados:</td>
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