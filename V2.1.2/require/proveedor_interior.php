<?php
if(isset($CLAVE) && $CLAVE != ""){
	$sqlDatosProveedor = "
		Select 
			*
		From 
			`organizaciones`
		Where 

			`organizaciones`.`id` = '$_REQUEST[CLAVE]'
					   ";
	$resDatosProveedor = DreQueryDB($sqlDatosProveedor);
	$rowDatosProveedor = mysql_fetch_assoc($resDatosProveedor);	
}


$sqlContactosProveedores = "
	Select * From
		`miinfo_proveedores`
	Where
		`organizacion_id` = '$rowDatosProveedor[id]'
						   ";

$resContactosProveedores = DreQueryDB($sqlContactosProveedores);

$sqlMaxContacto = "
	Select Count(`id_contacto`) As `maxContacto` From 
		`miinfo_proveedores` 
	Where 
		`organizacion_id` = '$rowDatosProveedor[id]'
				  ";
$resMaxContacto = DreQueryDB($sqlMaxContacto);
$numeroContacto = mysql_result($resMaxContacto,0) + 1;

if(isset($regreso) && $regreso != ""){
	switch($regreso){
		
		case "clienteDocumentos" :
			$return = "clienteDocumentos.php?CLAVE=".$rowDatosEmpresa['CLAVE'];
		break;
		
		case "actividadesDetalle" :
			$return = "actividadesDetalle.php?recId=".$recId;
		break;
	}
} else {
	$return = "cliente.php?CLAVE=".$rowDatosEmpresa['CLAVE'];
}


?>
<table width="950" cellpadding="0" cellspacing="0" border="0">
	<tr class="TextoTitulosSeccion" align="left">
		<td>
        	<?php echo $tipoRegistro = "Proveedor"; ?>
		</td>
	</tr>
<?php
	if(isset($editarNombre) && $editarNombre){
?>
<form name="formEditarProveedorNombre" id="formEditarProveedorNombre" method="post" action="includes/editar.php?tipoEdicion=ProveedorNombre">
	<tr>
		<td valign="top" align="right">
			<input type="button" class="systemGuardar" title="Guardar Contacto" onClick="ValidarEditarProveedorNombre();"/>
			<!-- JavaScript: document.formEditarContacto.submit(); -->
			<input type="button" class="systemCancelar" title="Cancelar" onClick="java:window.open('<?php echo "proveedor.php?CLAVE=".$CLAVE; ?>','_self');"/>
        </td>
	</tr>
	<tr>
		<td>
        	<!-- InfoEmpresa -->
			<table width="900" cellpadding="2" cellspacing="0" align="center" border="0" style="font-size:12px;">
            	<tr>
                	<td>
                    	<input type="text" id="Nombre" name="Nombre" value="<?php echo $rowDatosProveedor['Nombre']; ?>" style="font-weight:bold; font-size:18px; width:95%;"/>
                        <input type="hidden" id="id" name="id" value="<?php echo $editarNombre; ?>" />
                    </td>
                </tr>
			</table>
            <!-- InfoEmpresa -->
        </td>
	<tr>
</form>
<?php
	} else {
?>
	<tr>
		<td valign="top" align="right">
        	<a href="<?php echo "proveedor.php?CLAVE=".$CLAVE."&editarNombre=".$CLAVE; ?>" title="Editar Cliente" style="text-decoration:none"><img src="img/transparente.fw.png" class="system editar" alt="editar" border="0"/></a>
        </td>
	</tr>
	<tr>
		<td>
        	<!-- InfoEmpresa -->
			<table width="900" cellpadding="2" cellspacing="0" align="center" border="0" style="font-size:12px;">
            	<tr style="font-size:18px;">
                	<td><strong><?php echo $rowDatosProveedor['Nombre']; ?></strong></td>
                </tr>
			</table>
            <!-- InfoEmpresa -->
        </td>
	<tr>
<?php
	}
?>
    <tr>
    	<td>&nbsp;</td>
    </tr>
	<tr class="TextoTitulosSecciondivClic" align="left" style="font-size:15px;">
		<td>
        	<div class="divClic">
			<table width="950" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td width="300" align="left">
            			&nbsp;&nbsp;&nbsp;
						<a href="#Contactos" onclick="mostrarOcultarDiv('Contactos')" class="TextoTitulosSecciondivClic" title="Click para ver detalle...">
                        Contactos del <? echo $tipoRegistro; ?>
                        </a>
                    </td>
                	<td width="650" align="left">
						<a href="#Contactos" onclick="mostrarOcultarDiv('Contactos')" class="LinkSecciondivClic" title="Click para ver detalle...">
                        	&nbsp;&nbsp;&nbsp;
							Click para ver detalle...
                        </a>
                    </td>
                </tr>
			</table>
            </div>
        </td>
    </tr>
    <tr>
    	<td>
        	<div id="Contactos" <?php echo ($muestra == "Contactos")? 'style="display:block;"':'style="display:none;"'; ?>>
        	<table width="900" cellpadding="2" cellspacing="2" border="0" align="center" style="font-size:12px;">
            	<tr>
                	<td colspan="5" align="right">
                    	<?php
							$urlAgregarContacto = $_SERVER['PHP_SELF']."?CLAVE=".$CLAVE."&agregar=CONTACTO".$numeroContacto."&muestra=Contactos#agregar";
						?>
                    	<a href="<? echo $urlAgregarContacto ?>" title="Agregar Contactos"><img src="img/transparente.fw.png" class="system agregar" alt="agregar" border="0"/></a>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </td>
                </tr>
            	<tr>
                	<td colspan="5">&nbsp;</td>
				</tr>
<?php
	if(isset($agregar) && $agregar != ""){
?>
                    	<a id="agregar" name="agregar"></a>
		<form name="formAgregarContacto" id="formAgregarContacto" method="post" action="includes/agregar.php?tipoAgregar=ContactoProveedor">
            	<tr>
                	<td align="right">Contacto:</td>
                	<td align="left"><input type="text" name="Nombre_contacto" id="Nombre_contacto" style="width:100%;" /></td>
                    <td align="right">Puesto:</td>
                  <td><input type="text" name="puesto" id="puesto" style="width:100%;" /></td>
                	<td align="right">
                        <input type="button" class="systemGuardar" title="Guardar Contacto" onClick="ValidarAgregarContactoProveedor('<? echo $rowContactosProveedores['id_contacto'];?>');"/>
                        <!-- JavaScript: document.formEditarContacto.submit(); -->
                        <input type="button" class="systemCancelar" title="Cancelar" onClick="java:window.open('<?php echo "proveedor.php?CLAVE=".$rowDatosProveedor['id']."&muestra=Contactos"; ?>','_self');"/>
                    </td>
                </tr>
            	<tr>
                	<td align="right">Tel&eacute;fono 1:</td>
                	<td><input type="text" name="telefono1" id="telefono1" style="width:55%" /> Ext:<input type="text" name="extension" id="extension" style="width:25%" /></td>
                	<td align="right">Tel&eacute;fono 2:</td>
                	<td><input type="text" name="telefono2" id="telefono2" style="width:55%" /></td>
                	<td>&nbsp;</td>
                </tr>
            	<tr>
                	<td align="right">Tel&eacute;fono 3:</td>
                	<td><input type="text" name="telefono3" id="telefono3" style="width:55%" /></td>
                	<td align="right">Tel&eacute;fono 4:</td>
                	<td><input type="text" name="telefono4" id="telefono4" style="width:55%" /></td>
                	<td>&nbsp;</td>
                </tr>
            	<tr>
                	<td width="75" align="right">Email:</td>
                	<td width="330"><input type="text" name="email" id="email" style="width:100%" /></td>
                	<td width="75" align="right">Celular:</td>
                	<td width="330"><input type="text" name="telefono_movil" id="telefono_movil" style="width:55%" /></td>
                	<td width="90">&nbsp;</td>
                </tr>
				<tr>
                	<td align="right">Direcci&oacute;n:</td>
                	<td colspan="3" align="left">
                    	<textarea name="direccion" id=">direccion" style="width:100%"></textarea>
                    </td>
                	<td>&nbsp;</td>
                </tr>
            	<tr>
               	  <td align="right">Banco:</td>
               	  <td colspan="3"><input type="text" name="banco" id="banco" style="width:100%" /></td>
               	  <td>&nbsp;</td>
              </tr>
            	<tr>
                	<td width="70" align="right">Cuenta B.:</td>
                	<td width="330"><input type="text" name="cuenta" id="cuenta" style="width:100%" /></td>
                	<td width="70" align="right">Clabe B.:</td>
                	<td width="330"><input type="text" name="clabe" id="clabe" style="width:100%" /></td>
                	<td width="100">&nbsp;</td>
              </tr>
                <input type="hidden" name="CLAVE" id="CLAVE" value="<?php echo $CLAVE; ?>" />
                <input type="hidden" name="id_contacto" id="id_contacto" value="<?php echo $rowContactosProveedores['id_contacto']; ?>" />
                <input type="hidden" name="organizacion_id" id="organizacion_id" value="<?php echo $rowContactosProveedores['organizacion_id']; ?>" />
                <input type="hidden" name="id_contacto" id="id_contacto" value="<?php echo $numeroContacto; ?>" />
                <input type="hidden" name="TIPO" id="TIPO" value="<?php echo $rowContactosProveedores['id_contacto']; ?>" />                
		</form>
            	<tr>
                	<td colspan="5"><hr></td>
				</tr>
            	<tr>
                	<td colspan="5">&nbsp;</td>
				</tr>
<?php
	}
?>
                    	<a id="Contactos" name="Contactos"></a>
<?php
	while($rowContactosProveedores = mysql_fetch_assoc($resContactosProveedores)){
?>
				<tr>
                	<td colspan="5">
                    	<a id="<?php echo $rowContactosProveedores['id_contacto']; ?>" name="<?php echo $rowContactosProveedores['id_contacto']; ?>"></a>
                    </td>
                </tr>
<?php
		if($rowContactosProveedores['id_contacto'] != $editar){
?>
            	<tr>
                	<td align="right">Contacto:</td>
                	<td align="left"><strong><?php echo $rowContactosProveedores['Nombre_contacto']; ?></strong></td>
                    <td align="right">Puesto:</td>
                  <td><strong><?php echo $rowContactosProveedores['puesto']; ?></strong></td>
                	<td align="right">
                    	<?php
                    		$urlEditarContacto = $_SERVER['PHP_SELF']."?CLAVE=".$CLAVE."&editar=".$rowContactosProveedores['id_contacto']."&muestra=Contactos#".$rowContactosProveedores['id_contacto'];
						?>
						<a href="<? echo $urlEditarContacto; ?>" title="Editar Contacto"><img src="img/transparente.fw.png" class="system editar" alt="editar" border="0"/></a>
                    </td>
                </tr>
            	<tr>
                	<td align="right">Tel&eacute;fono 1:</td>
                	<td><strong><? echo $rowContactosProveedores['telefono1']; echo ($rowContactosProveedores['extension'] != "")? "&nbsp;&bull;".$rowContactosProveedores['extension']:""; ?></strong></td>
                	<td align="right">Tel&eacute;fono 2:</td>
                	<td><strong><? echo $rowContactosProveedores['telefono2']; ?></strong></td>
                	<td>&nbsp;</td>
                </tr>
            	<tr>
                	<td align="right">Tel&eacute;fono 3:</td>
                	<td><strong><? echo $rowContactosProveedores['telefono3']; ?></strong></td>
                	<td align="right">Tel&eacute;fono 4:</td>
                	<td><strong><? echo $rowContactosProveedores['telefono4']; ?></strong></td>
                	<td>&nbsp;</td>
                </tr>
            	<tr>
                	<td width="75" align="right">Email:</td>
                	<td width="330"><strong><? echo $rowContactosProveedores['email']; ?></strong></td>
                	<td width="75" align="right">Celular:</td>
                	<td width="330"><strong><? echo $rowContactosProveedores['telefono_movil']; ?></strong></td>
                	<td width="90">&nbsp;</td>
                </tr>
				<tr>
                	<td align="right">Direcci&oacute;n:</td>
                	<td colspan="3" align="left"><strong><?php echo $rowContactosProveedores['direccion']; ?></strong></td>
                	<td>&nbsp;</td>
                </tr>
            	<tr>
               	  <td align="right">Banco:</td>
               	  <td colspan="3"><strong><? echo $rowContactosProveedores['banco']; ?></strong></td>
               	  <td>&nbsp;</td>
              </tr>
            	<tr>
                	<td width="70" align="right">Cuenta B.:</td>
                	<td width="330"><strong><? echo $rowContactosProveedores['cuenta']; ?></strong></td>
                	<td width="70" align="right">Clabe B.:</td>
                	<td width="330"><strong><? echo $rowContactosProveedores['clabe']; ?></strong></td>
                	<td width="100">&nbsp;</td>
              </tr>                
<?php
		} else if($rowContactosProveedores['id_contacto'] == $editar){
?>
		<form name="formEditarContacto" id="formEditarContactos" method="post" action="includes/editar.php?tipoEdicion=ContactoProveedor">
            	<tr>
                	<td align="right">Contacto:</td>
                	<td align="left"><input type="text" name="Nombre_contacto" id="Nombre_contacto" value="<?php echo $rowContactosProveedores['Nombre_contacto']; ?>" style="width:100%;" /></td>
                    <td align="right">Puesto:</td>
                  <td><input type="text" name="puesto" id="puesto" value="<?php echo $rowContactosProveedores['puesto']; ?>" style="width:100%;" /></td>
                	<td align="right">
                        <input type="button" class="systemGuardar" title="Guardar Contacto" onClick="ValidarEditarContactoProveedor('<? echo $rowContactosProveedores['id_contacto'];?>');"/>
                        <!-- JavaScript: document.formEditarContacto.submit(); -->
                        <input type="button" class="systemCancelar" title="Cancelar" onClick="java:window.open('<?php echo "proveedor.php?CLAVE=".$rowDatosProveedor['id']."&muestra=Contactos#".$rowContactosProveedores['id_contacto']; ?>','_self');"/>
                    </td>
                </tr>
            	<tr>
                	<td align="right">Tel&eacute;fono 1:</td>
                	<td><input type="text" name="telefono1" id="telefono1" value="<? echo $rowContactosProveedores['telefono1']; ?>" style="width:55%" /> Ext:<input type="text" name="extension" id="extension" value="<? echo $rowContactosProveedores['extension']; ?>" style="width:25%" /></td>
                	<td align="right">Tel&eacute;fono 2:</td>
                	<td><input type="text" name="telefono2" id="telefono2" value="<? echo $rowContactosProveedores['telefono2']; ?>" style="width:55%" /></td>
                	<td>&nbsp;</td>
                </tr>
            	<tr>
                	<td align="right">Tel&eacute;fono 3:</td>
                	<td><input type="text" name="telefono3" id="telefono3" value="<? echo $rowContactosProveedores['telefono3']; ?>" style="width:55%" /></td>
                	<td align="right">Tel&eacute;fono 4:</td>
                	<td><input type="text" name="telefono4" id="telefono4" value="<? echo $rowContactosProveedores['telefono4']; ?>" style="width:55%" /></td>
                	<td>&nbsp;</td>
                </tr>
            	<tr>
                	<td width="75" align="right">Email:</td>
                	<td width="330"><input type="text" name="email" id="email" value="<? echo $rowContactosProveedores['email']; ?>" style="width:100%" /></td>
                	<td width="75" align="right">Celular:</td>
                	<td width="330"><input type="text" name="telefono_movil" id="telefono_movil" value="<? echo $rowContactosProveedores['telefono_movil']; ?>" style="width:55%" /></td>
                	<td width="90">&nbsp;</td>
                </tr>
				<tr>
                	<td align="right">Direcci&oacute;n:</td>
                	<td colspan="3" align="left">
                    	<textarea name="direccion" id=">direccion" style="width:100%">
							<?php echo $rowContactosProveedores['direccion']; ?>
                        </textarea>
                    </td>
                	<td>&nbsp;</td>
                </tr>
            	<tr>
               	  <td align="right">Banco:</td>
               	  <td colspan="3"><input type="text" name="banco" id="banco" value="<? echo $rowContactosProveedores['banco']; ?>" style="width:100%" /></td>
               	  <td>&nbsp;</td>
              </tr>
            	<tr>
                	<td width="70" align="right">Cuenta B.:</td>
                	<td width="330"><input type="text" name="cuenta" id="cuenta" value="<? echo $rowContactosProveedores['cuenta']; ?>" style="width:100%" /></td>
                	<td width="70" align="right">Clabe B.:</td>
                	<td width="330"><input type="text" name="clabe" id="clabe" value="<? echo $rowContactosProveedores['clabe']; ?>" style="width:100%" /></td>
                	<td width="100">&nbsp;</td>
              </tr>
                <input type="hidden" name="CLAVE" id="CLAVE" value="<?php echo $CLAVE; ?>" />
                <input type="hidden" name="id_contacto" id="id_contacto" value="<?php echo $rowContactosProveedores['id_contacto']; ?>" />
                <input type="hidden" name="organizacion_id" id="organizacion_id" value="<?php echo $rowContactosProveedores['organizacion_id']; ?>" />
                <input type="hidden" name="TIPO" id="TIPO" value="<?php echo $rowContactosProveedores['id_contacto']; ?>" />                
		</form>
<?php			
		}
?>
                <tr>
                	<td colspan="5"><hr></td>
                </tr>
<?php
	}
?>
            </table>
            </div>
        </td>
    </tr>
    <tr>
    	<td>&nbsp;</td>
    </tr>
</table>