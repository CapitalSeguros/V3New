<table width="950" cellpadding="0" cellspacing="0" border="0">
	<tr class="TextoTitulosSeccion" align="left">
		<td>
        	<?php echo $tipoRegistro = "Agregar&nbsp;Empleado"; ?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">&nbsp;
        	
        </td>
	</tr>
	<tr>
		<td>
        	<!-- InfoEmpresa -->
<!-- 
	Colaboradores=> Empledos
    Asociados => Vendedores
    Consultor => Promotores
      
	Merida
	Leasing
	Chetumal
	Cancun
	Finbe
-->
			<table width="900" cellpadding="2" cellspacing="0" align="center" border="0" style="font-size:12px;">
<form name="formAgregarEmpleado" id="formAgregarEmpleado" method="post" action="includes/agregar.php?tipoAgregar=Empleado" >
            	<tr>
            	  <td width="100" align="right">Tipo Empleado:</td>
            	  <td width="350" align="left">
                  	<select name="TipoEmpleado" id="TipoEmpleado" style="width:50%">
                    	<option value="">-- Seleccione --</option>
                        <option value="Colaboradores">Colaboradores</option>
                        <option value="Asociados">Asociados</option>
                        <option value="Consultor">Consultor</option>
                    </select>
                  </td>
            	  <td width="100" align="right">&nbsp;</td>
            	  <td width="350" align="left">&nbsp;</td>
           	  </tr>
            	<tr>
            	  <td align="right">Sucursal:</td>
            	  <td align="left">
                  	<select name="Sucursal" id="Sucursal" style="width:50%">
                    	<option value="">-- Seleccione --</option>
                        <?
							$sqlSucursales = "
								Select * From
									`catalogo_sucursales`
								
											 ";
							$resSucursales = DreQueryDB($sqlSucursales);
							while($rowSucursales = mysql_fetch_assoc($resSucursales)){
						?>
                        <option value="<? echo $rowSucursales['nombre']; ?>"><? echo $rowSucursales['nombre']; ?></option>
                        <?
							}
						?>
                    </select>
                  </td>
            	  <td align="right">&nbsp;</td>
            	  <td align="left">&nbsp;</td>
           	  </tr>
            	<tr>
            	  <td align="right">Ext:</td>
            	  <td align="left"><input type="text" name="Ext" id="Ext" style="width:25%" /></td>
            	  <td align="right">&nbsp;</td>
            	  <td align="left">&nbsp;</td>
           	  </tr>
            	<tr>
            	  <td align="right">&nbsp;</td>
            	  <td colspan="3" align="left"><hr style=""></td>
           	  </tr>
            	<tr>
                	<td align="right">Nombre:</td>
                	<td align="left"><input type="text" name="Nombre" id="Nombre" style="width:100%" /></td>
                	<td align="right">Puesto:</td>
                	<td align="left"><input type="text" name="Puesto" id="Puesto" style="width:100%" /></td>
               	</tr>
            	<tr>
                	<td align="right">Correo:</td>
                	<td><input type="text" name="Correo" id="Correo" style="width:100%" /></td>
                	<td align="right">Jefe Inmediato:</td>
                	<td><input type="text" name="JefeInmediato" id="JefeInmediato" style="width:100%" /></td>
               	</tr>
            	<tr>
                	<td align="right">Celular:</td>
                	<td><input type="text" name="Celular" id="Celular" style="width:50%" /></td>
                	<td align="right">Cumplea&ntilde;os:</td>
                	<td>
						<input type="text" name="Cumple" id="Cumple" readonly style="width:90%" />
						<img src="img/cal.gif" width="16" height="16" id="Cumple_Btn" border="0" title="Clic" />
                    </td>
               	</tr>
                <tr>
                	<td colspan="4" align="right">
        	<input type="button" value="Cancelar" class="buttonGeneral" onclick="java:window.open('<?php echo "directorio.php"; ?>','_self');" />
        	<input type="submit" value="Guardar" />
                    </td>
                </tr>
</form>
			</table>
            <!-- InfoEmpresa -->
        </td>
	<tr>
</table>
<script>
	Calendar.setup(
		{
		inputField : "Cumple",
		trigger    : "Cumple_Btn",
		onSelect   : function() { this.hide()},
		dateFormat : "%Y-%m-%d"
		}
		);
</script>