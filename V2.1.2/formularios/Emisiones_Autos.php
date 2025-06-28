<?php
$sqlEmisiones = "
	Select * From `actividades_emision`
	Where 
		`idActividad` = '$rowDatosActividad[recId]'
											";
$resEmisiones = DreQueryDB($sqlEmisiones);
$rowEmisiones = mysql_fetch_assoc($resEmisiones);
?>
<br />
<table width="610" cellpadding="5" cellspacing="2" border="0" align="center">
	<tr>
    	<td colspan="2" class="TextoTitulosEdicionAgregar">
        	Autom&oacute;viles
		</td>
   	</tr>
<form name="formEmisiones" id="formEmisiones" method="post" action="includes/guardar.php?tipoGuardar=emisiones">
	<tr>
	  <td align="right">Marca: </td>
	  <td><input name="marca" type="text" id="marca" value="<?php echo $rowEmisiones['marca'] ?>" size="70" <?php echo campoBloqueado($rowDatosEmisiones['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Modelo: </td>
	  <td><input name="modelo" type="text" id="modelo" value="<?php echo $rowEmisiones['modelo'] ?>" size="90" <?php echo campoBloqueado($rowDatosEmisiones['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">A&ntilde;o: </td>
	  <td><input name="year" type="text" id="year" value="<?php echo $rowEmisiones['year'] ?>" <?php echo campoBloqueado($rowDatosEmisiones['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td width="150" align="right">Tipo Vehiculo:</td>
	  <td><?php echo SelectTipoVehiculo($rowEmisiones['tipoVehiculo'],$rowDatosEmisiones['estatus']); ?></td>
  </tr>
	<tr>
	  <td align="right">Placas:</td>
	  <td><input name="placas" type="text" id="placas" value="<?php echo $rowEmisiones['placas'] ?>" <?php echo campoBloqueado($rowDatosEmisiones['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">No de Serie / NIV:</td>
	  <td><input name="numero_serie_niv" type="text" id="numero_serie_niv" value="<?php echo $rowEmisiones['numero_serie_niv'] ?>" <?php echo campoBloqueado($rowDatosEmisiones['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">No de Motor:</td>
	  <td><input name="numero_motor" type="text" id="numero_motor" value="<?php echo $rowEmisiones['numero_motor'] ?>" <?php echo campoBloqueado($rowDatosEmisiones['estatus']); ?>/></td>
    </tr>
	<tr>
	  <td align="right">Uso:</td>
	  <td><?php echo SelectTipoUso($rowEmisiones['tipo_uso'],$rowDatosEmisiones['estatus']); ?></td>
    </tr>
	<tr>
	  <td align="right">Estado Circulacion:</td>
	  <td><?php echo SelectEstado($rowEmisiones['estado'],$rowDatosEmisiones['estatus']); ?></td>
    </tr>
	<tr>
	  <td align="right">Remolque:</td>
	  <td><input name="remolque" type="checkbox" id="remolque" value="Si" <?php echo ($rowEmisiones['remolque']== "Si")? "checked": ""; ?> /></td>
    </tr>
	<tr>
	  <td align="right">Dolly:</td>
      <td><input name="dolly" type="checkbox" id="dolly" value="Si" <?php echo ($rowEmisiones['dolly']== "Si")? "checked": ""; ?> /></td>
    </tr>
	<tr>
	  <td align="right">2 Remolque:</td>
      <td><input name="segundo_remolque" type="checkbox" id="segundo_remolque" value="Si" <?php echo ($rowEmisiones['segundo_remolque']== "Si")? "checked": ""; ?> /></td>
    </tr>
	<tr>
	  <td colspan="2">Tipo y Descripcion:</td>
  </tr>
	<tr>
	  <td colspan="2"><textarea name="tipo_descripcion_mercancia" cols="80" id="tipo_descripcion_mercancia" <?php echo campoBloqueado($rowDatosEmisiones['estatus']);?>><?php echo $rowEmisiones['tipo_descripcion_mercancia'] ?></textarea>
      </td>
  </tr>
	<tr>
	  <td colspan="2">Comentarios:</td>
  </tr>
	<tr>
	  <td colspan="2"><textarea name="comentarios" cols="80" id="comentarios" <?php echo campoBloqueado($rowDatosEmisiones['estatus']);?>><?php echo $rowEmisiones['comentarios'] ?></textarea>
      </td>
  </tr>
	<tr>
	  <td colspan="2" align="right">
      <input type="hidden" name="idInterno" id="idInterno" value="<?php echo $rowDatosActividad['idInterno']; ?>" />
      <input type="hidden" name="idActividad" id="idActividad" value="<?php echo $rowDatosActividad['recId']; ?>" />
      <input type="hidden" name="recId" id="recId" value="<?php echo $rowDatosActividad['recId']; ?>" />
      <input type="hidden" name="tipoEmisiones" id="tipoEmisiones" value="<?php echo $tipoEmisiones; ?>" />
       <?php if($rowDatosEmisiones['estatus'] == 0){ ?>
      <input type="button" value="guardar" onclick="java:document.formEmisiones.submit()" />
      &nbsp;&nbsp;&nbsp;
      <?php }?>
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