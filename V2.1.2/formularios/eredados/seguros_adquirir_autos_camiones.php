<script language="javascript" src="../js/validaciones.js"></script>
<form name="formSegAutosCamiones" method="post" action="seguros_adquirir_autos_camiones_query.php">
  <table border="0" cellspacing="2" cellpadding="5" width="100%" align="center">
    <tbody>
      <tr>
        <td colspan="4"><strong><a name="formulario" id="formulario"></a>Formulario de cotizaci&oacute;n</strong></td>
      </tr>
      <tr>
        <td> Estado :</td>
        <td colspan="3"><select id="estado" name="estado">
          <option value="" selected="selected">-- Seleccione --</option>
          <option>AGUASCALIENTES</option>
          <option>BAJA CALIFORNIA</option>
          <option>BAJA CALIFORNIA SUR</option>
          <option>CAMPECHE</option>
          <option>COAHUILA</option>
          <option>COLIMA</option>
          <option>CHIHUAHUA</option>
          <option>CHIAPAS</option>
          <option>DISTRITO FEDERAL</option>
          <option>DURANGO</option>
          <option>ESTADO DE MEXICO</option>
          <option>GUANAJUATO</option>
          <option>GUERRERO</option>
          <option>HIDALGO</option>
          <option>JALISCO</option>
          <option>MICHOACAN</option>
          <option>MORELOS</option>
          <option>NAYARIT</option>
          <option>NUEVO LE&Oacute;N</option>
          <option>OAXACA</option>
          <option>PUEBLA</option>
          <option>QUINTANA ROO</option>
          <option>QUER&Eacute;TARO</option>
          <option>SINALOA</option>
          <option>SAN LUIS POTOSI</option>
          <option>SONORA</option>
          <option>TABASCO</option>
          <option>TAMAULIPAS</option>
          <option>TLAXCALA</option>
          <option>VERACRUZ</option>
          <option>YUCATAN</option>
          <option>ZACATECAS</option>
        </select></td>
      </tr>
      <tr>
        <td>Marca :</td>
        <td><input name="marca" type="text" id="marca" size="50" /></td>
        <td>A&ntilde;o :</td>
        <td><input name="anio" type="text" id="codigo_postal3" size="22" /></td>
      </tr>
      <tr>
        <td>Modelo :</td>
        <td><input name="modelo" type="text" id="modelo" size="50" /></td>
        <td>AC :</td>
        <td><select name="clima" id="clima">
          <option value="">-- Seleccione --</option>
          <option value="No">No</option>
          <option value="Si">Si</option>
        </select></td>
      </tr>
      <tr>
        <td>Transmision :</td>
        <td><select name="transmision" id="transmision">
          <option value="">-- Seleccione --</option>
          <option value="Manual">Manual</option>
          <option value="Automatica">Automatica</option>
        </select></td>
        <td>T. Uso :</td>
        <td><select name="uso" id="uso">
          <option value="">-- Seleccione --</option>
          <option value="Personal">Personal</option>
          <option value="Comercial">Comercial</option>
          <option value="Otro">Otro</option>
        </select></td>
      </tr>
      <tr>
        <td>Quemacocos :</td>
        <td><select name="quemaCocos" id="quemaCocos">
          <option value="">-- Seleccione --</option>
          <option value="No">No</option>
          <option value="Si">Si</option>
        </select></td>
        <td>Cobertura :</td>
        <td><select name="cobertura" id="cobertura">
          <option value="">-- Seleccione --</option>
          <option value="Cobertura Amplia">Cobertura Amplia</option>
          <option value="Cobertura Limitada">Cobertura Limitada</option>
          <option value="RC">RC</option>
        </select></td>
      </tr>
      <tr>
        <td>Precio :</td>
        <td><input name="precio" type="text" id="precio" size="22" /></td>
        <td>F. Pago :</td>
        <td><select  name="formaPago" id="formaPago">
          <option value="">-- Seleccione --</option>
          <option value="Anual">Anual</option>
          <option value="Semestral">Semestral</option>
          <option value="Mensual" >Mensual</option>
        </select></td>
      </tr>
      <tr>
        <td>Descripci&oacute;n :</td>
        <td colspan="3"><textarea name="descripcion" cols="58" rows="5" id="descripcion"></textarea></td>
      </tr>
      <tr>
        <td>Adaptaci&oacute;n :</td>
        <td colspan="3"><textarea name="adaptacion" cols="58" rows="5" id="adaptacion"></textarea></td>
      </tr>
      <tr>
        <td>Comentarios :</td>
        <td colspan="3"><textarea name="comentarios" cols="58" rows="5" id="comentarios"></textarea></td>
      </tr>
      <tr>
        <td colspan="4" align="right"><font style="font-size:12px;"><em>TODOS los campos son requeridos. &nbsp;</em></font>
          <input type="button" onclick="validarSegAutosCamiones();" value="enviar" /></td>
      </tr>
    </tbody>
  </table>
</form>