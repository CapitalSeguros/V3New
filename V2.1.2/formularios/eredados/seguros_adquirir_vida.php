<script language="javascript" src="../js/validaciones.js"></script>
<form name="formSegVida" method="post" action="seguros_adquirir_vida_query.php">
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
        <td>Telefono :</td>
        <td colspan="3"><input name="telefono" type="text" id="telefono" size="79" /></td>
      </tr>
      <tr>
        <td>Email :</td>
        <td colspan="3"><input name="email" type="text" id="email" size="79" /></td>
      </tr>
      <tr>
        <td>Edad :</td>
        <td><input name="edad_contratante" type="text" id="codigo_postal3" size="20" /></td>
        <td>Sexo :</td>
        <td><select name="sexo" id="sexo">
          <option value="">-- Seleccione --</option>
          <option value="Masculino">Masculino</option>
          <option value="Femenino">Femenino</option>
        </select></td>
      </tr>
      <tr>
        <td>Ahorro :</td>
        <td><select  name="ahorro" id="ahorro" >
          <option value="">-- Seleccione --</option>
          <option value="Si">Si</option>
          <option value="No">No</option>
        </select></td>
        <td>Moneda :</td>
        <td><select name="moneda" id="moneda" >
          <option value="">-- Seleccione --</option>
          <option value="pesos">Pesos</option>
          <option value="dolares">Dolares</option>
        </select></td>
      </tr>
      <tr>
        <td>Estatura Cm :</td>
        <td><input name="estatura" type="text" id="codigo_postal4" size="20" /></td>
        <td>Peso Kg :</td>
        <td><input name="peso" type="text" id="codigo_postal5" size="20" /></td>
      </tr>
      <tr>
        <td>Fumador :</td>
        <td><select name="fuma" id="fuma">
          <option value="">-- Seleccione --</option>
          <option value="No">No</option>
          <option value="Si">Si</option>
        </select></td>
        <td>F. Pago :</td>
        <td><select  name="formaPago" id="formaPago">
          <option value="">-- Seleccione --</option>
          <option value="Anual">Anual</option>
          <option value="Semestral">Semestral</option>
          <option value="Mensual" >Mensual</option>
        </select></td>
      </tr>
      <tr>
        <td>Comentarios :</td>
        <td colspan="3"><textarea name="comentarios" cols="58" rows="5" id="comentarios"></textarea></td>
      </tr>
      <tr>
        <td colspan="4" align="right"><font style="font-size:12px;"><em>TODOS los campos son requeridos. &nbsp;</em></font>
          <input type="button" onclick="validarSegVida();" value="enviar" /></td>
      </tr>
      <tr>
        <td colspan="4"><font style="font-size:12px; text-align:justify;"><strong>NOTA: &ldquo;Si no le llega la confirmaci&oacute;n de recepci&oacute;n de su solicitud en 2 d&iacute;as por favor revise su bandeja de correo no deseado&rdquo;</strong></font></td>
      </tr>
    </tbody>
  </table>
</form>