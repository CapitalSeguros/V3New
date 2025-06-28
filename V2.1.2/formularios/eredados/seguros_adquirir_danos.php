<script language="javascript" src="../js/validaciones.js"></script>
<form name="formSegDanos" method="post" action="seguros_adquirir_danos_query.php">
  <table border="0" cellspacing="2" cellpadding="5" width="95%" align="center">
    <tbody>
      <tr>
        <td colspan="4"><strong><a name="formulario" id="formulario"></a>Formulario de cotizaci&oacute;n</strong></td>
      </tr>
      <tr>
        <td>Nombre :</td>
        <td colspan="3"><input name="nombre" type="text" id="nombre" size="79" /></td>
      </tr>
      <tr>
        <td>Apellidos :</td>
        <td colspan="3"><input name="apellidos" type="text" id="apellidos" size="79" /></td>
      </tr>
      <tr>
        <td>Calle :</td>
        <td colspan="3"><input name="calle" type="text" id="calle" size="79" /></td>
      </tr>
      <tr>
        <td>No. Ext. :</td>
        <td colspan="2"><input name="noext" type="text" id="noext" size="30" />
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          No. Int. :</td>
        <td><input name="noint" type="text" id="noint" size="22" /></td>
      </tr>
      <tr>
        <td>Cruzamientos :</td>
        <td colspan="3"><input name="cruzamientos" type="text" id="cruzamientos" size="79" /></td>
      </tr>
      <tr>
        <td>Colonia :</td>
        <td><input name="colonia" type="text" id="colonia" size="30" /></td>
        <td>Ciudad :</td>
        <td><input name="ciudad" type="text" id="ciudad" size="22" /></td>
      </tr>
      <tr>
        <td>Estado :</td>
        <td><select id="estado" name="estado">
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
        <td>C.P. :</td>
        <td><input name="codigopostal" type="text" id="codigo_postal" size="22" /></td>
      </tr>
      <tr>
        <td>Telefono :</td>
        <td colspan="3"><input name="telefono" type="text" id="telefono" size="79" /></td>
      </tr>
      <tr>
        <td>Email :</td>
        <td colspan="3"><input name="email" type="text" id="email" size="79" /></td>
      </tr>
      <tr>
        <td>Valor :</td>
        <td colspan="3"><input name="valorVivienda" type="text" id="valorVivienda" value="Vivienda" size="30" />
        <input name="valorContenidos" type="text" id="valorContenidos" value="Contenidos" size="30" /></td>
      </tr>
      <tr>
        <td colspan="4">Cobertura Fen&oacute;menos Hidrometeorol&oacute;gicos :
          <select name="hidrometeorologicos" id="hidrometeorologicos">
            <option value="">-- Seleccione --</option>
            <option value="No">No</option>
            <option value="Si">Si</option>
        </select></td>
      </tr>
      <tr>
        <td>Construcci&oacute;n :</td>
        <td colspan="3"><input name="construccion" type="text" id="construccion" size="79" /></td>
      </tr>
      <tr>
        <td>Techos :</td>
        <td colspan="3"><input name="techos" type="text" id="techos" size="79" /></td>
      </tr>
      <tr>
        <td>Comentarios :</td>
        <td colspan="3"><textarea name="comentarios" cols="58" rows="5" id="comentarios"></textarea></td>
      </tr>
      <tr>
        <td colspan="4" align="right"><font style="font-size:12px;"><em>TODOS los campos son requeridos. &nbsp;</em></font>
          <input type="button" onclick="validarSegDanos();" value="enviar" /></td>
      </tr>
      <tr>
        <td colspan="4"><font style="font-size:12px; text-align:justify;"><strong>NOTA: &ldquo;Si no le llega la confirmaci&oacute;n de recepci&oacute;n de su solicitud en 2 d&iacute;as por favor revise su bandeja de correo no deseado&rdquo;</strong></font></td>
      </tr>
    </tbody>
  </table>
</form>