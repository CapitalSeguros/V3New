  <table border="0" cellspacing="2" cellpadding="5" width="100%" align="center">
    <tbody>
      <tr>
        <td> Estado :</td>
        <td colspan="3">
        <select id="estado" name="estado">
          <option value="">-- Seleccione --</option>
          <?php
		  	$sqlEstados = "Select * From `estados`";
			$resEstados = DreQueryDB($sqlEstados);
			while($rowEstados = mysql_fetch_assoc($resEstados)){
		  ?>
          <option value="<?php echo $rowEstados['nombre_estado']; ?>" <?php echo ($rowEstados['nombre_estado'] == $rowDatosFormulario['estado'])? "selected" : ""; ?>><?php echo $rowEstados['nombre_estado']; ?></option>
          <?php
			}
		  ?>
        </select>
        </td>
      </tr>
      <tr>
        <td>Marca :</td>
        <td><input name="marca" type="text" id="marca" size="50" value="<?php echo $rowDatosFormulario['marca']; ?>" /></td>
        <td>A&ntilde;o :</td>
        <td><input name="anio" type="text" id="codigo_postal3" size="22" value="<?php echo $rowDatosFormulario['anio']; ?>" /></td>
      </tr>
      <tr>
        <td>Modelo :</td>
        <td><input name="modelo" type="text" id="modelo" size="50" value="<?php echo $rowDatosFormulario['modelo']; ?>" /></td>
        <td>AC :</td>
        <td><select name="clima" id="clima">
          <option value="">-- Seleccione --</option>
          <option value="No" <?php echo ($rowDatosFormulario['clima'] == "No")? "selected" : "";?>>No</option>
          <option value="Si" <?php echo ($rowDatosFormulario['clima'] == "Si")? "selected" : "";?>>Si</option>
        </select></td>
      </tr>
      <tr>
        <td>Transmision :</td>
        <td><select name="transmision" id="transmision">
          <option value="">-- Seleccione --</option>
          <option value="Manual" <?php echo ($rowDatosFormulario['transmision'] == "Manual")? "selected" : "";?>>Manual</option>
          <option value="Automatica" <?php echo ($rowDatosFormulario['transmision'] == "Automatica")? "selected" : "";?>>Automatica</option>
        </select></td>
        <td>T. Uso :</td>
        <td><select name="uso" id="uso">
          <option value="">-- Seleccione --</option>
          <option value="Personal" <?php echo ($rowDatosFormulario['uso'] == "Personal")? "selected" : "";?>>Personal</option>
          <option value="Comercial" <?php echo ($rowDatosFormulario['uso'] == "Comercial")? "selected" : "";?>>Comercial</option>
          <option value="Otro" <?php echo ($rowDatosFormulario['uso'] == "Otro")? "selected" : "";?>>Otro</option>
        </select></td>
      </tr>
      <tr>
        <td>Quemacocos :</td>
        <td><select name="quemaCocos" id="quemaCocos">
          <option value="">-- Seleccione --</option>
          <option value="No" <?php echo ($rowDatosFormulario['quemaCocos'] == "No")? "selected" : "";?>>No</option>
          <option value="Si" <?php echo ($rowDatosFormulario['quemaCocos'] == "Si")? "selected" : "";?>>Si</option>
        </select></td>
        <td>Cobertura :</td>
        <td><select name="cobertura" id="cobertura">
          <option value="">-- Seleccione --</option>
          <option value="Cobertura Amplia" <?php echo ($rowDatosFormulario['cobertura'] == "Cobertura Amplia")? "selected" : "";?>>Cobertura Amplia</option>
          <option value="Cobertura Limitada" <?php echo ($rowDatosFormulario['cobertura'] == "Cobertura Limitada")? "selected" : "";?>>Cobertura Limitada</option>
          <option value="RC" <?php echo ($rowDatosFormulario['cobertura'] == "RC")? "selected" : "";?>>RC</option>
        </select></td>
      </tr>
      <tr>
        <td>Precio :</td>
        <td><input name="precio" type="text" id="precio" size="22"  value="<?php echo $rowDatosFormulario['precio']; ?>" /></td>
        <td>F. Pago :</td>
        <td><select  name="formaPago" id="formaPago">
          <option value="">-- Seleccione --</option>
          <option value="Anual" <?php echo ($rowDatosFormulario['formaPago'] == "Anual")? "selected" : "";?>>Anual</option>
          <option value="Semestral" <?php echo ($rowDatosFormulario['formaPago'] == "Semestral")? "selected" : "";?>>Semestral</option>
          <option value="Mensual" <?php echo ($rowDatosFormulario['formaPago'] == "Mensual")? "selected" : "";?>>Mensual</option>
        </select></td>
      </tr>
      <tr>
        <td>Descripci&oacute;n :</td>
        <td colspan="3"><textarea name="descripcion" cols="58" rows="5" id="descripcion"><?php echo $rowDatosFormulario['descripcion']; ?></textarea></td>
      </tr>
      <tr>
        <td>Adaptaci&oacute;n :</td>
        <td colspan="3"><textarea name="adaptacion" cols="58" rows="5" id="adaptacion"><?php echo $rowDatosFormulario['adaptacion']; ?></textarea></td>
      </tr>
      <tr>
        <td>Comentarios :</td>
        <td colspan="3"><textarea name="comentarios" cols="58" rows="5" id="comentarios"><?php echo $rowDatosFormulario['comentarios']; ?></textarea></td>
      </tr>
      <tr>
        <td colspan="4" align="right"><font style="font-size:12px;"><em>TODOS los campos son requeridos. &nbsp;</em></font>
      </tr>
    </tbody>
  </table>