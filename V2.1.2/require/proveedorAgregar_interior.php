<script>
	function ValidarAgregarProveedor(){		
	
		var f = document.formAgregarProveedor;

		var Nombre_organizacion = f.Nombre_organizacion.value;
		var categoria = f.categoria.value;
		var Nombre_contacto = f.Nombre_contacto.value;

		
		var telefono_movil = f.telefono_movil.value;		
		
		var email = f.email.value;
		
		var error = '';
		var patronTelefono = /^[0-9]{2,3}-? ?[0-9]{6,7}$/;
		var patronCorreo = /^[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}$/ 
		
		
		if(Nombre_organizacion == ''){
			error+= '\n Escriba un Nombre de la Organizacion!!!';
		}
		if(categoria == ''){
			error+= '\n Escriba una Categoria!!!';
		}
		if(Nombre_contacto == ''){
			error+= '\n Escriba Nombre del Contacto !!!';
		}
				
		
		if(telefono_movil == ""){
			error+= "\n Escriba el Telefono Celular a 10 Digitos !!!";
		} else if(telefono_movil.length < 10){
			error+= "\n Escriba el Telefono Celular a 10 Digitos !!!";
		} else if(
			telefono_movil == '1111111111'
			||
			telefono_movil == '2222222222'
			||
			telefono_movil == '3333333333'
			||
			telefono_movil == '4444444444'
			||
			telefono_movil == '5555555555'
			||
			telefono_movil == '6666666666'
			||
			telefono_movil == '7777777777'
			||
			telefono_movil == '8888888888'
			||
			telefono_movil == '9999999999'
			||
			telefono_movil == '0000000000'
			||
			telefono_movil == '0123456789'
			||
			telefono_movil == '1234567890'

		){  // !patronTelefono.test(TELEFONO_MOVIL)
			error+= "\n Escriba el Telefono Celular a 10 Digitos Valido !!!";
		}
		
		if(email != ""){  //  || EMAIL == "nombre@dominio.com"
			//error+= "\n Escriba un E-mail !!!";
			if(!patronCorreo.test(email)){
				error+= "\n Escriba un E-mail Valido !!!";
			}
		}
		
		if(error == ''){
			f.submit();
		} else {
			alert(error);
		}		
	}
</script>
<table width="950" cellpadding="0" cellspacing="0" border="0">
	<tr class="TextoTitulosSeccion" align="left">
		<td style="font-size:20px;">
        	Agregar Proveedor
		</td>
	</tr>
    <tr>
    	<td>&nbsp;</td>
    </tr>
    <tr>
    	<td>
<!-- -->
<form name="formAgregarProveedor" id="formAgregarProveedor" method="post" action="includes/agregar.php?tipoAgregar=Proveedor" >
<table width="900" cellpadding="1" cellspacing="2" align="center" border="0" style="font-size:12px;" >
            	<tr>
            	  <td align="right">Organizaci&oacute;n:</td>
            	  <td colspan="3" align="left"><input type="text" name="Nombre_organizacion" id="Nombre_organizacion" style="width:100%;" /></td>
           	  </tr>
            	<tr>
            	  <td align="right">Categor&iacute;a:</td>
            	  <td colspan="3" align="left"><input type="text" name="categoria" id="categoria" style="width:100%;" /></td>
           	  </tr>
            	<tr>
                	<td align="right">Contacto:</td>
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
        	<input type="button" value="Cancelar" class="buttonGeneral" onclick="java:window.open('<?php echo "directorio.php"; ?>','_self');" />
        	<!-- <input type="submit" value="Guardar" /> -->
        	<input type="button" value="Guardar" class="buttonGeneral" onClick="ValidarAgregarProveedor()" />
        </td>
    </tr>
</table>
</form>
<!-- -->
        </td>
    </tr>
</table>