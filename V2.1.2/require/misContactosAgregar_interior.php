<table width="950" cellpadding="0" cellspacing="0" border="0">
	<tr class="TextoTitulosSeccion" align="left">
		<td style="font-size:20px;">
        	Agregar Contacto
		</td>
	</tr>
    <tr>
    	<td>&nbsp;</td>
    </tr>
    <tr>
    	<td>
<!-- -->
<form name="formAgregarMisContactos" id="formAgregarMisContactos" method="post" action="includes/agregar.php?tipoAgregar=miContacto" >
<table width="900" cellpadding="1" cellspacing="2" align="center" border="0" style="font-size:12px;" >
            	<tr>
            	  <td align="right">Mi Contacto</td>
            	  <td colspan="3" align="left"><input type="text" name="Nombre_misContactos" id="Nombre_misContactos" style="width:100%;" /></td>
           	  </tr>
            	<tr>
                	<td align="right">Referencia:</td>
                	<td align="left"><input type="text" name="Nombre_contacto" id="Nombre_contacto" style="width:100%;" /></td>
                    <td align="right">Puesto:</td>
                  <td><input type="text" name="puesto" id="puesto" style="width:100%;" /></td>
               	</tr>
            	<tr>
                	<td align="right">Tel&eacute;fono 1:</td>
                	<td><input type="text" name="telefono1" id="telefono1" style="width:55%" /> Ext:<input type="text" name="extension" id="extension" style="width:25%" /></td>
                	<td align="right">Tel&eacute;fono 2:</td>
                	<td><input type="text" name="telefono2" id="telefono2" style="width:55%" /></td>
               	</tr>
            	<tr>
                	<td align="right">Tel&eacute;fono 3:</td>
                	<td><input type="text" name="telefono3" id="telefono3" style="width:55%" /></td>
                	<td align="right">Tel&eacute;fono 4:</td>
                	<td><input type="text" name="telefono4" id="telefono4" style="width:55%" /></td>
               	</tr>
            	<tr>
                	<td width="75" align="right">Email:</td>
                	<td width="330"><input type="text" name="email" id="email" style="width:100%" /></td>
                	<td width="75" align="right">Celular:</td>
                	<td width="330"><input type="text" name="telefono_movil" id="telefono_movil" style="width:55%" /></td>
               	</tr>
				<tr>
                	<td align="right">Direcci&oacute;n:</td>
                	<td colspan="3" align="left">
                    	<textarea name="direccion" id=">direccion" style="width:100%"></textarea>
                    </td>
               	</tr>
            	<tr>
               	  <td align="right">Banco:</td>
               	  <td colspan="3"><input type="text" name="banco" id="banco" style="width:100%" /></td>
           	  </tr>
            	<tr>
                	<td width="75" align="right">Cuenta B.:</td>
                	<td width="330"><input type="text" name="cuenta" id="cuenta" style="width:100%" /></td>
                	<td width="75" align="right">Clabe B.:</td>
                	<td width="330"><input type="text" name="clabe" id="clabe" style="width:100%" /></td>
           	  </tr>
    <tr>
    	<td colspan="4" align="right">
        	<input type="hidden" name="userCreador" id="userCreador" value="<? echo $Usuario; ?>" />
        	<input type="button" value="Cancelar" class="buttonGeneral" onclick="java:window.open('<?php echo "directorio.php"; ?>','_self');" />
        	<input type="button" value="Guardar" class="buttonGeneral" onClick="validacionAgregarMisContactos();" />
        </td>
    </tr>
</table>
</form>
<!-- -->
        </td>
    </tr>
</table>