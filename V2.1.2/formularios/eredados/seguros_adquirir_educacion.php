<script language="javascript" src="../js/validaciones.js"></script>
<form name="formSegEducacion" method="post" action="seguros_adquirir_educacion_query.php">
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
        <td colspan="2">
        <input name="noext" type="text" id="noext" size="30" />
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        No. Int.
        :</td>
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
        <td>
        <select id="estado" name="estado">
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
        <td>Fecha Nac. :</td>
        <td><input name="fechanacimiento" type="text" id="fechanacimiento" value="D&iacute;a / Mes / A&ntilde;o (4 Digitos )" size="50" /></td>
        <td>RFC :</td>
        <td><input name="rfc" type="text" id="codigo_postal2" size="22" /></td>
      </tr>
      <tr>
        <td>Edad :</td>
        <td><input name="edad_contratante" type="text" id="codigo_postal3" value="Padre o Contratante" size="20" />
        <input name="edad_menor" type="text" id="codigo_postal4" value="Del Menor" size="20" /></td>
        <td>Sexo :</td>
        <td>
        <select name="sexo" id="sexo">
          <option value="">-- Seleccione --</option>
          <option value="Masculino">Masculino</option>
          <option value="Femenino">Femenino</option>
        </select>
        </td>
      </tr>
      <tr>
        <td>Costo Uni. :</td>
        <td>
        <select name="costoUniversidad" id="costoUniversidad" >
          <option value="">-- Seleccione --</option>
          <option value="$ 40,000">$ 40,000</option>
          <option value="$ 50,000">$ 50,000</option>
          <option value="$ 60,000">$ 60,000</option>
          <option value="$ 70,000">$ 70,000</option>
          <option value="$ 80,000">$ 80,000</option>
          <option value="$ 90,000">$ 90,000</option>
          <option value="$ 100,000">$ 100,000</option>
          <option value="$ 110,000">$ 110,000</option>
          <option value="$ 120,000">$ 120,000</option>
          <option value="$ 130,000">$ 130,000</option>
          <option value="$ 140,000">$ 140,000</option>
          <option value="$ 150,000">$ 150,000</option>
          <option value="$ 160,000">$ 160,000</option>
          <option value="$ 170,000">$ 170,000</option>
          <option value="$ 180,000">$ 180,000</option>
          <option value="$ 190,000">$ 190,000</option>
          <option value="$ 200,000">$ 200,000</option>
        </select>
        &nbsp;&nbsp;
        Moneda
        <select name="moneda" id="moneda" >
            <option value="">-- Seleccione --</option>
            <option value="pesos">Pesos</option>
            <option value="dolares">Dolares</option>
        </select>
        </td>
        <td>Fuma :</td>
        <td><select name="fuma" id="fuma">
          <option value="">-- Seleccione --</option>
          <option value="No">No</option>
          <option value="Si">Si</option>
        </select></td>
      </tr>
      <tr>
        <td>Comentarios :</td>
        <td colspan="3"><textarea name="comentarios" cols="58" rows="5" id="comentarios"></textarea></td>
      </tr>
      <tr>
        <td colspan="4" align="right"><font style="font-size:12px;"><em>TODOS los campos son requeridos. &nbsp;</em></font>
          <input type="button" onclick="validarSegEducacion();" value="enviar" /></td>
      </tr>
      <tr>
        <td colspan="4"><font style="font-size:12px; text-align:justify;"><strong>NOTA: &ldquo;Si no le llega la confirmaci&oacute;n de recepci&oacute;n de su solicitud en 2 d&iacute;as por favor revise su bandeja de correo no deseado&rdquo;</strong></font></td>
      </tr>
    </tbody>
  </table>
</form>