<script language="javascript" src="../js/validaciones.js"></script>
<form name="formSegGastosMedicos" method="post" action="seguros_adquirir_gastos_medicos_query.php">
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
        <td>Cobertura Internacional:</td>
        <td>
        <select  name="coverturaInternacional" id="coverturaInternacional" >
          <option value="">-- Seleccione --</option>
          <option value="Si">Si</option>
          <option value="No">No</option>
        </select></td>
        <td>Deducible :</td>
        <td>
        <select  name="deducible">
          <option value="">-- Seleccione --</option>
          <option value="$ 5,000">$ 5,000</option>
          <option value="$ 10,000">$ 10,000</option>
          <option value="$ 15,000" >$ 15,000</option>
          <option value="$ 20,000">$ 20,000</option>
        </select></td>
      </tr>
      <tr>
        <td>Nivel Hosp.</td>
        <td><select  name="nivelHospitalario" id="nivelHospitalario" >
          <option value="">-- Seleccione --</option>
          <option value="B&aacute;sico">B&aacute;sico</option>
          <option value="Medio">Medio</option>
          <option value="Exclusivo" >Exclusivo</option>
          <option value="Internacional">Internacional</option>
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
        <td>Estado de Residencia :</td>
        <td><input name="residencia" type="text" id="residencia" size="50" /></td>
        <td>Coaseguro :</td>
        <td><select  name="coaseguro" id="coaseguro" >
          <option value="">-- Seleccione --</option>
          <option value="Si">Si</option>
          <option value="No">No</option>
        </select></td>
      </tr>
      <tr>
        <td colspan="4"><strong>Familiar 1</strong></td>
      </tr>
      <tr>
        <td>Nombre :</td>
        <td><input name="nombreFam1" type="text" id="nombreFam1" size="50" /></td>
        <td>Sexo :</td>
        <td><select name="sexoFam1" id="sexoFam1">
          <option value="">-- Seleccione --</option>
          <option value="Masculino">Masculino</option>
          <option value="Femenino">Femenino</option>
        </select></td>
      </tr>
      <tr>
        <td>Parentesco :</td>
        <td><input name="parentescoFam1" type="text" id="parentescoFam1" size="50" /></td>
        <td>Edad :</td>
        <td><input name="edadFam1" type="text" id="codigo_postal9" size="22" /></td>
      </tr>
      <tr>
        <td colspan="4"><strong>Familiar 2</strong></td>
      </tr>
      <tr>
        <td>Nombre :</td>
        <td><input name="nombreFam2" type="text" id="nombreFam2" size="50" /></td>
        <td>Sexo :</td>
        <td><select name="sexoFam2" id="sexoFam2">
          <option value="">-- Seleccione --</option>
          <option value="Masculino">Masculino</option>
          <option value="Femenino">Femenino</option>
        </select></td>
      </tr>
      <tr>
        <td>Parentesco :</td>
        <td><input name="parentescoFam2" type="text" id="parentescoFam2" size="50" /></td>
        <td>Edad :</td>
        <td><input name="edadFam2" type="text" id="codigo_postal8" size="22" /></td>
      </tr>
      <tr>
        <td colspan="4"><strong>Familiar 3</strong></td>
      </tr>
      <tr>
        <td>Nombre :</td>
        <td><input name="nombreFam3" type="text" id="nombreFam3" size="50" /></td>
        <td>Sexo :</td>
        <td><select name="sexoFam3" id="sexoFam3">
          <option value="">-- Seleccione --</option>
          <option value="Masculino">Masculino</option>
          <option value="Femenino">Femenino</option>
        </select></td>
      </tr>
      <tr>
        <td>Parentesco :</td>
        <td><input name="parentescoFam3" type="text" id="parentescoFam3" size="50" /></td>
        <td>Edad :</td>
        <td><input name="edadFam3" type="text" id="codigo_postal4" size="22" /></td>
      </tr>
      <tr>
        <td>Comentarios :</td>
        <td colspan="3"><textarea name="comentarios" cols="58" rows="5" id="comentarios"></textarea></td>
      </tr>
      <tr>
        <td colspan="4" align="right"><font style="font-size:12px;"><em>TODOS los campos son requeridos. &nbsp;</em></font>
          <input type="button" onclick="validarSegGastosMedicos();" value="enviar" /></td>
      </tr>
      <tr>
        <td colspan="4"><font style="font-size:12px; text-align:justify;"><strong>NOTA: &ldquo;Si no le llega la confirmaci&oacute;n de recepci&oacute;n de su solicitud en 2 d&iacute;as por favor revise su bandeja de correo no deseado&rdquo;</strong></font></td>
      </tr>
    </tbody>
  </table>
</form>