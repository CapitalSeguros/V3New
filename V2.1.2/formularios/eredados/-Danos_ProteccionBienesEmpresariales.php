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
        	Protecci&oacute;n Bienes Empresariales
    	</td>
   	</tr>
<form name="formLineasPersonales" id="formLineasPersonales" method="post" action="includes/guardar.php?tipoGuardar=formularios">
	<tr>
	  <td width="150" align="right">Fecha  nacimiento:</td>
	  <td><input name="fecha_nacimiento" type="text" id="fecha_nacimiento" value="<?php echo $rowLineasPersonales_accidentesPersonales['fecha_nacimiento'] ?>" maxlength="30" <?php echo campoBloqueado($rowDatosFormulario['estatus']); ?>/>
      <img src="img/cal.gif" id="fecha_nacimiento_Btn"  title="Clic">
      </td>
  </tr>
	<tr>
	  <td align="right">Sexo :</td>
	  <td>
		<?php echo SelectSexo($rowLineasPersonales_accidentesPersonales['sexo'],$rowDatosFormulario['estatus'],'sexo'); ?>
	  </td>
    </tr>
	<tr>
	  <td align="right">&iquest;Cobertura Internac.?:</td>
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
	  <td align="right">Estado residencia:</td>
	  <td>
      
<?php echo SelectEstado($rowLineasPersonales_accidentesPersonales['estado'],$rowDatosFormulario['estatus']); ?>
      </td>
    </tr>
	<tr>
	  <td align="right">Forma pago:</td>
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
      <input type="hidden" name="idInterno" id="idInterno" value="<?php echo $rowDatosActividad['idInterno']; ?>" />
      <input type="hidden" name="idActividad" id="idActividad" value="<?php echo $rowDatosActividad['recId']; ?>" />
      <input type="hidden" name="tipoDanos" id="tipoDanos" value="<?php echo $tipoDanos; ?>" />
       <?php if($rowDatosFormulario['estatus'] == 0){ ?>
      <input type="button" value="guardar" onclick="java:document.formLineasPersonales.submit()" />
      &nbsp;&nbsp;&nbsp;
      <?php }?>
      </td>
  </tr>
</form>
	<tr>
	  <td colspan="2">Incluir personas adiciones a contratar:</td>
  </tr>
	<tr>
	  <td colspan="2" align="center">
      <?php include('add_personaAdicional.php'); ?>
      </td>
  </tr>
<?php if($rowDatosFormulario['estatus'] == 0){ ?>
	<tr>
	  <td colspan="2" align="right">
      <?php if(mysql_num_rows(DreQueryDB("Select * From `actividades_formularios` Where `idActividad` = '$rowDatosActividad[recId]' And `ramoInterno`= '$rowDatosActividad[ramoInterno]'")) == 0){ ?>
      		<div style="float:left;">
			<input type="button" value="Cancelar" onclick="JavaScript:history.go(-1);" />
            </div>
      <?php } ?>
      	<form name="formLineasPersonalesTerminar" id="formLineasPersonalesTerminar" method="post" action="includes/guardar.php?tipoGuardar=formulariosTerminar">
			<input type="hidden" name="idActividad" id="idActividad" value="<?php echo $rowDatosActividad['recId']; ?>" />
      		<input type="hidden" name="ramoInterno" id="ramoInterno" value="<?php echo $rowDatosActividad['ramoInterno']; ?>" />
			<input type="hidden" name="tipoLineaPersonal" id="tipoLineaPersonal" value="<?php echo $tipoLineaPersonal; ?>" />
        	<input type="submit" value="Terminar Formulario" />
        </form>
      </td>
	</tr>
<?php } ?>
</table>
<script type="text/javascript">
	Calendar.setup({
		inputField : "fecha_nacimiento",
		trigger    : "fecha_nacimiento_Btn",
		onSelect   : function() { this.hide() },
		dateFormat : "%d-%m-%Y"
	});
</script>