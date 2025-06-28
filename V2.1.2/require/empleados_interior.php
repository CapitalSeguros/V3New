<?php
if(isset($CLAVE) && $CLAVE != ""){
	$sqlDatosEmpleado = "
		Select 
			*
		From 
			`miinfo_empleados`
		Where 
			`miinfo_empleados`.`idEmpleado` = '$_REQUEST[CLAVE]'
		Order By 
			`idEmpleado`
					   ";
	$resDatosEmpleado = DreQueryDB($sqlDatosEmpleado);
	$rowDatosEmpleado = mysql_fetch_assoc($resDatosEmpleado);
}
?>
<table width="950" cellpadding="0" cellspacing="0" border="0">
	<tr class="TextoTitulosSeccion" align="left">
		<td>
        	<?php echo $tipoRegistro = "Empleado"; ?>
		</td>
	</tr>
	<tr>
		<td valign="top" align="right">&nbsp;
        	
        </td>
	</tr>
	<tr>
		<td>
        	<!-- InfoEmpresa -->
<?php
	if(isset($editarEmpleado) && $editarEmpleado !=''){
		
?>
			<table width="900" cellpadding="2" cellspacing="0" align="center" border="0" style="font-size:12px;">
            <form name="formEmpleado" id="formEmpleado" method="post" action="includes/editar.php?tipoEdicion=Empleado">
            	<tr>
            	  <td width="100" align="left">Tipo Empleado:</td>
            	  <td width="350" align="left">
                  	<select name="TipoEmpleado" id="TipoEmpleado" style="width:50%">
                    	<option value="">-- Seleccione --</option>
                        <option <? echo ($rowDatosEmpleado['TipoEmpleado'] == "Colaboradores")? "selected":""; ?> value="Colaboradores">Colaboradores</option>
                        <option <? echo ($rowDatosEmpleado['TipoEmpleado'] == "Asociados")? "selected":""; ?> value="Asociados">Asociados</option>
                        <option <? echo ($rowDatosEmpleado['TipoEmpleado'] == "Consultor")? "selected":""; ?> value="Consultor">Consultor</option>
                    </select>
                  </td>
            	  <td width="100" align="right">&nbsp;</td>
            	  <td width="350" align="right">
					<input type="button" class="systemGuardar" title="Guardar Empleado" onClick="JavaScript: submit();"/>
					<input type="button" class="systemCancelar" title="Cancelar" onClick="java:window.open('<?php echo "empleados.php?CLAVE=".$CLAVE; ?>','_self');"/>
                  </td>
           	  </tr>
            	<tr>
            	  <td align="left">Sucursal:</td>
            	  <td align="left">
                  	<select name="Sucursal" id="Sucursal" style="width:50%">
                    	<option  value="">-- Seleccione --</option>
                        <option <? echo ($rowDatosEmpleado['Sucursal'] == "Merida")? "selected":""; ?> value="Merida">Merida</option>
                        <option <? echo ($rowDatosEmpleado['Sucursal'] == "Leasing")? "selected":""; ?> value="Leasing">Leasing</option>
                        <option <? echo ($rowDatosEmpleado['Sucursal'] == "Chetumal")? "selected":""; ?> value="Chetumal">Chetumal</option>
                        <option <? echo ($rowDatosEmpleado['Sucursal'] == "Cancun")? "selected":""; ?> value="Cancun">Cancun</option>
                        <option <? echo ($rowDatosEmpleado['Sucursal'] == "Finbe")? "selected":""; ?> value="Finbe">Finbe</option>
                    </select>
                  </td>
            	  <td align="right">&nbsp;</td>
            	  <td align="right"><input type="button" class="systemBorrar" title="Eliminar" onClick="java:window.open('<?php echo "includes/borrar.php?tipoEliminar=Empleado&CLAVE=".$CLAVE; ?>','_self');"/></td>
           	  </tr>
            	<tr>
            	  <td align="left">Ext:</td>
            	  <td align="left"><input type="text" name="Ext" id="Ext" value="<? echo $rowDatosEmpleado['Ext']; ?>" style="width:25%"/></td>
            	  <td align="right">&nbsp;</td>
            	  <td align="left">&nbsp;</td>
           	  </tr>
            	<tr>
            	  <td align="right">&nbsp;</td>
            	  <td colspan="3" align="left"><hr style=""></td>
           	  </tr>
            	<tr>
                	<td align="left">Nombre:</td>
                	<td align="left"><input type="text" name="Nombre" id="Nombre" value="<?php echo $rowDatosEmpleado['Nombre']; ?>" style="width:100%" /></td>
                	<td align="left">Puesto:</td>
               	  <td align="left"><input type="text" name="Puesto" id="Puesto" value="<?php echo $rowDatosEmpleado['Puesto']; ?>" style="width:100%" /></td>
               	</tr>
            	<tr>
                	<td align="left">Correo:</td>
                	<td><input type="text" name="Correo" id="Correo" value="<? echo $rowDatosEmpleado['Correo']; ?>" style="width:100%" /></td>
                	<td align="left">Jefe Inmediato:</td>
               	  <td><input type="text" name="JefeInmediato" id="JefeInmediato" value="<? echo $rowDatosEmpleado['JefeInmediato']; ?>" style="width:100%"/></td>
               	</tr>
            	<tr>
                	<td align="left">Celular:</td>
                	<td><input type="text" name="Celular" id="Celular" value="<? echo $rowDatosEmpleado['Celular']; ?>" style="width:100%" /></td>
                	<td align="left">Cumplea&ntilde;os:</td>
                	<td>
						<input type="text" name="Cumple" id="Cumple" value="<?php echo $rowDatosEmpleado['Cumple']; ?>" readonly style="width:90%" />
						<img src="img/cal.gif" width="16" height="16" id="Cumple_Btn" border="0" title="Clic" />
                    </td>
               	</tr>
                <input type="hidden" name="idEmpleado" id="idEmpleado" value="<?php echo $rowDatosEmpleado['idEmpleado']; ?>" />
			</form>
			</table>
<?php
	} else { 
?>
			<table width="900" cellpadding="2" cellspacing="0" align="center" border="0" style="font-size:12px;">
            	<tr>
            	  <td width="100" align="left">Tipo Empleado:</td>
            	  <td width="350" align="left"><strong><? echo $rowDatosEmpleado['TipoEmpleado']; ?></strong></td>
            	  <td width="100" align="right">&nbsp;</td>
            	  <td width="350" align="right">
<?php
	if($Usuario == "0000028950"){
?>
        	<a href="<?php echo "empleados.php?CLAVE=".$CLAVE."&editarEmpleado=".$CLAVE; ?>" title="Editar Cliente" style="text-decoration:none"><img src="img/transparente.fw.png" class="system editar" alt="editar" border="0"/></a>
<?php
	}
?>
                  </td>
           	  </tr>
            	<tr>
            	  <td align="left">Sucursal:</td>
            	  <td align="left"><strong><? echo $rowDatosEmpleado['Sucursal']; ?></strong></td>
            	  <td align="right">&nbsp;</td>
            	  <td align="left">&nbsp;</td>
           	  </tr>
            	<tr>
            	  <td align="left">Ext:</td>
            	  <td align="left"><strong><? echo $rowDatosEmpleado['Ext']; ?></strong></td>
            	  <td align="right">&nbsp;</td>
            	  <td align="left">&nbsp;</td>
           	  </tr>
            	<tr>
            	  <td align="left">&nbsp;</td>
            	  <td colspan="3" align="left"><hr style=""></td>
           	  </tr>
            	<tr>
                	<td align="left">Nombre:</td>
                	<td align="left"><strong><?php echo $rowDatosEmpleado['Nombre']; ?></strong></td>
                	<td align="left">Puesto:</td>
                	<td align="left"><strong><?php echo $rowDatosEmpleado['Puesto']; ?></strong></td>
               	</tr>
            	<tr>
                	<td align="left">Correo:</td>
                	<td><strong><? echo $rowDatosEmpleado['Correo']; ?></strong></td>
                	<td align="left">Jefe Inmediato:</td>
                	<td><strong><? echo $rowDatosEmpleado['JefeInmediato']; ?></strong></td>
               	</tr>
            	<tr>
                	<td align="left">Celular:</td>
                	<td><strong><? echo $rowDatosEmpleado['Celular']; ?></strong></td>
                	<td align="left">Cumplea&ntilde;os:</td>
                	<td><strong><? echo date_format(date_create($rowDatosEmpleado['Cumple']), 'd-M-Y'); ?></strong></td>
               	</tr>
			</table>
<?php
	}
?>

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