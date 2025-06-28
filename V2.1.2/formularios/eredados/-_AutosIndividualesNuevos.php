<table width="650" border="0" align="center" cellpadding="2" cellspacing="2">
	<tr>
    	<td>
        	Forma de Pago:
        </td>
    	<td><input name="formaPago" type="text" id="formaPago" value="<?php echo $rowDatosFormulario['formaPago']; ?>" /></td>
    </tr>
	<tr>
	  <td>Cobertura:</td>
	  <td>
      	<select name="cobertura" id="cobertura">
        	<option value="Amplia" <?php echo ($rowDatosFormulario['cobertura'] == "Amplia")? "selected" : ""; ?>>Amplia</option>
        	<option value="Limitada"  <?php echo ($rowDatosFormulario['cobertura'] == "Limitada")? "selected" : ""; ?>>Limitada</option>
        	<option value="RC"  <?php echo ($rowDatosFormulario['cobertura'] == "RC")? "selected" : ""; ?>>RC</option>
        </select>
      </td>
  </tr>
	<tr>
	  <td>Modelo: </td>
	  <td><input name="modelo" type="text" id="modelo" value="<?php echo $rowDatosFormulario['modelo']; ?>" /></td>
  </tr>
	<tr>
	  <td>Precio (Valor Factura &uacute;nicamente)</td>
	  <td><input name="precioFactura" type="text" id="precioFactura" value="<?php echo $rowDatosFormulario['precioFactura']; ?>" /></td>
  </tr>
	<tr>
	  <td>Marca:</td>
	  <td><input name="Marca" type="text" id="Marca" value="<?php echo $rowDatosFormulario['Marca']; ?>" /></td>
  </tr>
	<tr>
	  <td>C&oacute;digo postal:</td>
	  <td><input name="codigoPostal" type="text" id="codigoPostal" value="<?php echo $rowDatosFormulario['codigoPostal']; ?>" /></td>
  </tr>
	<tr>
	  <td>Descripci&oacute;n detallada:</td>
	  <td><textarea name="descripcion" id="descripcion"><?php echo $rowDatosFormulario['descripcion']; ?></textarea></td>
  </tr>
	<tr>
	  <td>Transmisi&oacute;n:</td>
	  <td><input name="transmision" type="text" id="transmision" value="<?php echo $rowDatosFormulario['transmision']; ?>" /></td>
  </tr>
	<tr>
	  <td>AC: </td>
	  <td><input name="aC" type="text" id="aC" value="<?php echo $rowDatosFormulario['aC']; ?>" /></td>
  </tr>
	<tr>
	  <td>Quemacocos: </td>
	  <td><input name="quemacocos" type="text" id="quemacocos" value="<?php echo $rowDatosFormulario['quemacocos']; ?>" /></td>
  </tr>
	<tr>
	  <td>Uso diferente al personal? </td>
	  <td><input name="usoDiferentePersonal" type="text" id="usoDiferentePersonal" value="<?php echo $rowDatosFormulario['usoDiferentePersonal']; ?>" /></td>
  </tr>
	<tr>
	  <td>Estado de Circulaci&oacute;n:</td>
	  <td><input name="estadoCirculacion" type="text" id="estadoCirculacion" value="<?php echo $rowDatosFormulario['estadoCirculacion']; ?>" /></td>
  </tr>
	<tr>
	  <td>Adaptaci&oacute;n y/o conversi&oacute;n: </td>
	  <td><input name="adaptacionConversion" type="text" id="adaptacionConversion" value="<?php echo $rowDatosFormulario['adaptacionConversion']; ?>" /></td>
  </tr>
	<tr>
	  <td>Observaciones:</td>
	  <td><textarea name="observaciones" id="observaciones"><?php echo $rowDatosFormulario['observaciones']; ?></textarea></td>
  </tr>
</table>
