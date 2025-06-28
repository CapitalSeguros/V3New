<script>
	function ValidarAgregarCliente(tipoPer){		
	
		var f = document.formAgregarEmpresa;
		if(tipoPer == "F"){
			var NOMBRES = f.NOMBRES.value;
			var APELLIDO_PATERNO = f.APELLIDO_PATERNO.value;
			var APELLIDO_MATERNO = f.APELLIDO_MATERNO.value;
		} else if(tipoPer == "M") {
			var RAZON_SOCIAL = f.RAZON_SOCIAL.value;
		}
		
		var TELEFONO_MOVIL = f.TELEFONO_MOVIL.value;		
		var TELEFONO_PARTICULAR = f.TELEFONO_PARTICULAR.value;
		var TELEFONO_OFICINA = f.TELEFONO_OFICINA.value;
		
		var EMAIL = f.EMAIL.value;
		
		for(i=0;i<f.TIPO_PERSONA.length;i++){
			if(f.TIPO_PERSONA[i].checked) {
				marcado=i;
			}
		}

		var error = '';
		var patronTelefono = /^[0-9]{2,3}-? ?[0-9]{6,7}$/;
		var patronCorreo = /^[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}$/ 
		
		if(f.TIPO_PERSONA[marcado].value == 'F'){
			if(NOMBRES == ''){
				error+= '\n Escriba un Nombre del Prospecto!!!';
			}
			if(APELLIDO_PATERNO == ''){
				error+= '\n Escriba un Apellido Paterno del Prospecto!!!';
			}
			if(APELLIDO_MATERNO == ''){
				error+= '\n Escriba un Apellido Materno del Prospecto!!! \n --Extranjeros: Poner un punto para continuar !!!';
			}
		} else if(f.TIPO_PERSONA[marcado].value == 'M'){
			if(RAZON_SOCIAL == ''){
				error+= '\n Escriba la Raz\u00f3n Social del Prospecto!!!';
			}
		}
		
		if(TELEFONO_MOVIL == ""){
			error+= "\n Escriba el Telefono Celular a 10 Digitos !!!";
		} else if(TELEFONO_MOVIL.length < 10){
			error+= "\n Escriba el Telefono Celular a 10 Digitos !!!";
		} else if(
			TELEFONO_MOVIL == '1111111111'
			||
			TELEFONO_MOVIL == '2222222222'
			||
			TELEFONO_MOVIL == '3333333333'
			||
			TELEFONO_MOVIL == '4444444444'
			||
			TELEFONO_MOVIL == '5555555555'
			||
			TELEFONO_MOVIL == '6666666666'
			||
			TELEFONO_MOVIL == '7777777777'
			||
			TELEFONO_MOVIL == '8888888888'
			||
			TELEFONO_MOVIL == '9999999999'
			||
			TELEFONO_MOVIL == '0000000000'
			||
			TELEFONO_MOVIL == '0123456789'
			||
			TELEFONO_MOVIL == '1234567890'

		){  // !patronTelefono.test(TELEFONO_MOVIL)
			error+= "\n Escriba el Telefono Celular a 10 Digitos Valido !!!";
		}
		
		if(EMAIL != ""){  //  || EMAIL == "nombre@dominio.com"
			//error+= "\n Escriba un E-mail !!!";
			if(!patronCorreo.test(EMAIL)){
				error+= "\n Escriba un E-mail Valido !!!";
			}
		}
		
		if(TELEFONO_PARTICULAR != ""){
			if(TELEFONO_PARTICULAR.length < 10){
				if(
					TELEFONO_PARTICULAR == '1111111111'
					||
					TELEFONO_PARTICULAR == '2222222222'
					||
					TELEFONO_PARTICULAR == '3333333333'
					||
					TELEFONO_PARTICULAR == '4444444444'
					||
					TELEFONO_PARTICULAR == '5555555555'
					||
					TELEFONO_PARTICULAR == '6666666666'
					||
					TELEFONO_PARTICULAR == '7777777777'
					||
					TELEFONO_PARTICULAR == '8888888888'
					||
					TELEFONO_PARTICULAR == '9999999999'
					||
					TELEFONO_PARTICULAR == '0000000000'
					||
					TELEFONO_PARTICULAR == '0123456789'
					||
					TELEFONO_PARTICULAR == '1234567890'
				){
					error+= "\n Escriba el Telefono Casa a 10 Digitos Valido !!!";
				} else {
					error+= "\n Escriba el Telefono Casa a 10 Digitos !!!";
				}
			}
		}

		if(TELEFONO_OFICINA != ""){
			if(TELEFONO_OFICINA.length < 10){
				if(
					TELEFONO_OFICINA == '1111111111'
					||
					TELEFONO_OFICINA == '2222222222'
					||
					TELEFONO_OFICINA == '3333333333'
					||
					TELEFONO_OFICINA == '4444444444'
					||
					TELEFONO_OFICINA == '5555555555'
					||
					TELEFONO_OFICINA == '6666666666'
					||
					TELEFONO_OFICINA == '7777777777'
					||
					TELEFONO_OFICINA == '8888888888'
					||
					TELEFONO_OFICINA == '9999999999'
					||
					TELEFONO_OFICINA == '0000000000'
					||
					TELEFONO_OFICINA == '0123456789'
					||
					TELEFONO_OFICINA == '1234567890'
				){
					error+= "\n Escriba el Telefono Oficina a 10 Digitos Valido !!!";
				} else {
					error+= "\n Escriba el Telefono Oficina a 10 Digitos !!!";
				}
			}
		}
		
		if(error == ''){
			f.submit();
		} else {
			alert(error);
		}		
	}
</script>
<?php
switch($tipoPer){
	case 'F':
		$tipoPersona = "F&iacute;sica";
	break; 
	
	case 'M':
		$tipoPersona = "Moral";
	break; 
}

$sqlEstado = "
	Select * From 
		`estados`
	Order By
		`nombre_estado` Asc
			 ";
$resEstado = DreQueryDB($sqlEstado);

$sqlEscolaridad = "
	Select * From 
		`configdre` 
	Where
		`parametro` = 'tipoEscolaridad'
				  ";
$resEscolaridad = DreQueryDB($sqlEscolaridad);

$sqlEstadoCivil = "
	Select * From 
		`configdre` 
	Where 
		`parametro` = 'tipoEstadoCivil'
				  ";
$resEstadoCivil = DreQueryDB($sqlEstadoCivil);

$sqlGenero = "
	Select * From 
		`configdre` 
	Where 
		`parametro` = 'tipoGenero'
			 ";
$resGenero = DreQueryDB($sqlGenero);

// Definicion de Vista Vendedores
switch($Nivel){ // New Version
	case 5: // (Administradores) Todos los Vendedores
	case 4: // (Ejecutivos) Todos los Vendedores
		$sqlListadoVendedores = "
				Select 
					*
					,`usuarios`.`NOMBRE` As `nombreVendedor`
					,`vendedores`.`CLAVE` As `User`
				From
					`vendedores` Inner Join `usuarios`
					On
					`vendedores`.`CLAVE` = `usuarios`.`VALOR`
				Where
					`vendedores`.`CLAVE` != '0000007979'
				Order BY
					`nombreVendedor` Asc
									";
	break;
	
	case 3: // (Promotores) Solo sus Vededores
		$sqlListadoVendedores = "
				Select 
					*
					,`usuarios`.`NOMBRE` As `nombreVendedor`
					,`vendedores`.`CLAVE` As `User`
				From
					`vendedores` Inner Join `usuarios`
					On
					`vendedores`.`CLAVE` = `usuarios`.`VALOR`
				Where
					(
					`vendedores`.`TIPO` = '".$_SESSION['WebDreTacticaWeb2']['Tipo']."'
					Or
					`usuarios`.`PROMOTOR` = '".$_SESSION['WebDreTacticaWeb2']['Usuario']."'
					)
					Or
					(
					`usuarios`.`VALOR` = '".$_SESSION['WebDreTacticaWeb2']['Vendedor']."'
					)
				Order BY
					`nombreVendedor` Asc
									";
	break;
		
	case 2: // solo el mismo como vendedor
		$sqlListadoVendedores = "
				Select 
					*
					,`usuarios`.`NOMBRE` As `nombreVendedor`
					,`vendedores`.`CLAVE` As `User`
				From
					`vendedores` Inner Join `usuarios`
					On
					`vendedores`.`CLAVE` = `usuarios`.`VALOR`
				Where
					`vendedores`.`CLAVE` = '".$_SESSION['WebDreTacticaWeb2']['Usuario']."'
					Or
					`usuarios`.`VALOR` = '".$_SESSION['WebDreTacticaWeb2']['Vendedor']."'
				Order BY
					`nombreVendedor` Asc
									";
	break;
	}

?>
<table width="950" cellpadding="0" cellspacing="0" border="0">
	<tr class="TextoTitulosSeccion" align="left">
		<td style="font-size:20px;">
        	Agregar Cliente Persona <? echo $tipoPersona; ?>
		</td>
	</tr>
    <tr>
    	<td>&nbsp;</td>
    </tr>
    <tr>
    	<td>
<!-- -->
<form name="formAgregarEmpresa" id="formAgregarEmpresa" method="post" action="includes/agregar.php?tipoAgregar=Empresa" >
<table width="900" cellpadding="1" cellspacing="2" align="center" border="0" >
<?php
if($tipoPer=="M"){
?>
	<tr>
		<td align="left">Raz&oacute;n Social:</td>
		<td colspan="4" align="left">
			<input type="text" id="RAZON_SOCIAL" name="RAZON_SOCIAL" style="width:100%" />
		</td>
	</tr>
<?php
}
if($tipoPer=="F"){
?>
	<tr>
		<td align="left">Nombres:</td>
		<td colspan="4" align="left">
			<input type="text" name="NOMBRES" id="NOMBRES" style="width:50%" />
		</td>
	</tr>
	<tr>
		<td align="left">Apellido Paterno:</td>
		<td colspan="4" align="left">
			<input type="text" name="APELLIDO_PATERNO" id="APELLIDO_PATERNO" style="width:50%" />
		</td>
	</tr>
	<tr>
		<td align="left">Apellido Materno:</td>
		<td colspan="4" align="left">
			<input type="text" name="APELLIDO_MATERNO" id="APELLIDO_MATERNO" style="width:50%" />
		</td>
	</tr>
<?php
}
?>
	<tr>
		<td align="left">RFC:</td>
		<td align="left"><input type="text" id="RFC" name="RFC" style="width:100%" /></td>
        <td>&nbsp;</td>
		<td align="right">CURP:</td>
		<td align="left"><input type="text" id="CURP" name="CURP" style="width:160px" /></td>
	</tr>
	<tr>
		<td colspan="5" align="left">
            <!-- -->
        	<table width="900" cellpadding="1" cellspacing="2" border="0" align="center">
            	<tr>
                	<td width="160" rowspan="2" align="left">Tipo Persona:</td>
                    <td width="160" align="left">
                    	<input type="radio" name="TIPO_PERSONA" id="TIPO_PERSONA" value="F" <? echo ($tipoPer=="F")? "checked":""; ?>/>
                        Fisica                        
					</td>
					<td width="100" rowspan="2" align="right">Club Cap:</td>
				  <td width="100" align="left"><input name="Club_Cap" id="Club_Cap" type="radio" value="S" />Si</td>
					<td width="160" rowspan="2" align="right">Poliza Electronica:</td>
				  <td width="220" align="left"><input name="Poliza_Electronica" id="Poliza_Electronica" type="radio" value="S" />Si</td>
				</tr>
				<tr>
                	<td width="160" align="left">
                    	<input type="radio" name="TIPO_PERSONA" id="TIPO_PERSONA" value="M" <? echo ($tipoPer=="M")? "checked":""; ?>/>
                        Moral
					</td>
				  <td width="100" align="left"><input name="Club_Cap" id="Club_Cap" type="radio" value="N" />No</td>
          <td width="220" align="left"><input name="Poliza_Electronica" id="Poliza_Electronica" type="radio" value="N" />No</td>
                </tr>
            </table>
            <!-- -->
        </td>
	</tr>
	<tr>
	  <td colspan="5" align="left"><hr /></td>
	  </tr>    
	<tr>
		<td align="left">Calle:</td>
		<td colspan="4" align="left">
        	<input type="text" name="CALLE" id="CALLE" style="width:100%"/>
        </td>
		</tr>
	<tr>
	  <td align="left">No. Ext:</td>
	  <td colspan="2" align="left">
      	<input type="text" name="NOEXTERIOR" id="NOEXTERIOR" style="width:160px"/>
	  </td>
	  <td align="right">No. Int:</td>
	  <td align="left">
      	<input type="text" name="NOINTERIOR" id="NOINTERIOR" style="width:160px"/>
      </td>
	  </tr>
	<tr>
	  <td align="left">Colonia:</td>
	  <td colspan="2" align="left">
      	<input type="text" name="COLONIA" id="COLONIA" style="width:100%"/>
      </td>
	  <td align="right">CP:</td>
	  <td align="left">
      	<input type="text" name="CODIGO_POSTAL" id="CODIGO_POSTAL" style="width:160px"/>
      </td>
	  </tr>
	<tr>
	  <td align="left">Referencia:</td>
	  <td colspan="2" align="left">
      	<input type="text" name="REFERENCIA" id="REFERENCIA" style="width:120px"/> y <input type="text" name="REFERENCIA2" id="REFERENCIA2"  style="width:115px"/>
        </td>
	  <td align="right">Tel Casa:</td>
	  <td align="left">
      	<input type="text" name="TELEFONO_PARTICULAR" id="TELEFONO_PARTICULAR" style="width:160px"/>
	  </td>
	</tr>
	<tr>
	  <td align="left">Localidad:</td>
	  <td colspan="2" align="left">
      	<input type="text" name="LOCALIDAD" id="LOCALIDAD" style="width:100%"/>
      </td>
	  <td align="right">Tel Trabajo:</td>
	  <td align="left">
      	<input type="text" name="TELEFONO_OFICINA" id="TELEFONO_OFICINA" style="width:160px"/>
      </td>
	  </tr>
	<tr>
	  <td align="left">Municipio:</td>
	  <td colspan="2" align="left">
      	<input type="text" name="MUNICIPO" id="MUNICIPO" style="width:100%"/>
      </td>
	  <td align="right">Celular:</td>
	  <td align="left"><input type="text" name="TELEFONO_MOVIL" id="TELEFONO_MOVIL" style="width:160px"/></td>
	  </tr>
	<tr>
		<td align="left">Estado:</td>
		<td colspan="2" align="left">
        	<select name="ESTADO" id="ESTADO" style="width:99%;">
            	<option>-- Seleccione --</option>
                <?php
					while($rowEstado = mysql_fetch_assoc($resEstado)){
				?>
                <option value="<? echo $rowEstado['nombre_estado']; ?>" <? echo ($rowEstado['nombre_estado'] == "YUCATAN")? "selected":""; ?>><? echo $rowEstado['nombre_estado']; ?></option>
                <?
					}
				?>
            </select>
        </td>
		<td align="right">Email:</td>
	  <td align="left"><input type="text" name="EMAIL" id="EMAIL" style="width:160px"/></td>
	</tr>
    <tr>
    	<td colspan="5"><hr /></td>
    </tr>
	<tr>
		<td align="left">Fecha Nacimiento:</td>
		<td align="left">
			<input type="text" name="FECHA_NACIMIENTO" id="FECHA_NACIMIENTO" readonly style="width:124px" />
            <img src="img/cal.gif" width="16" height="16" id="FECHA_NACIMIENTO_Btn" border="0" title="Clic" />
		</td>
      <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
	</tr>
	<tr>
	  <td align="left">Nacionalidad:</td>
	  <td align="right">
      	<input type="text" name="NACIONALIDAD" id="NACIONALIDAD" style="width:100%;" value="MEXICANA" />
      </td>
	  <td align="right">&nbsp;</td>
	  <td align="right">Edad:</td>
	  <td>
      	<input type="text" name="EDAD" id="EDAD" style="width:80px;"/>
      </td>
	  </tr>
	<tr>
	  <td align="left">Nivel Estudios:</td>
	  <td align="right">
      <select name="NIVEL_ESTUDIOS" id="NIVEL_ESTUDIOS" style="width:99%;">
	    <option value="">-- Seleccione --</option>
	    <?php
			while($rowEscolaridad = mysql_fetch_assoc($resEscolaridad)){
		?>
        <option value="<?php echo $rowEscolaridad['titulo']?>"><?php echo $rowEscolaridad['titulo']?></option>
        <?php
			}
		?>
      </select>
      </td>
	  <td align="right">&nbsp;</td>
	  <td align="right">Edo Civil:</td>
	  <td>
      <select name="ESTADO_CIVIL" id="ESTADO_CIVIL" style=" width:158px">
      	<option value="">-- Seleccione --</option>
	    <?php
			while($rowEstadoCivil = mysql_fetch_assoc($resEstadoCivil)){
		?>
	    <option value="<?php echo $rowEstadoCivil['titulo']; ?>"><?php echo $rowEstadoCivil['titulo']; ?></option>
        <?php
			}
		?>
      </select>
      </td>
	</tr>
	<tr>
	  <td align="left">Automovil:</td>
	  <td align="left">
    	<input name="AUTOMOVIL" type="checkbox" id="AUTOMOVIL" value="S" />
      </td>
	  <td align="right">&nbsp;</td>
	  <td align="right">Genero:</td>
      <td align="left">
	    <select name="GENERO" id="GENERO" style=" width:158px">
	      <option value="">-- Seleccione --</option>
	      <?php
			while($rowGenero = mysql_fetch_assoc($resGenero)){
	      ?>
	      <option value="<?php echo $rowGenero['valor']; ?>"><?php echo $rowGenero['titulo']; ?></option>
	      <?php
			}
	      ?>
	  	</select>
	  </td>
	</tr>
	<tr>
    	<td colspan="5">
        	<hr />
        </td>
    </tr>
	<tr>
		<td align="left">Vendedor:</td>
		<td colspan="4" align="left">
        <?php

			switch($Nivel){
				case 5:
				case 4:
					if($Grupo != "2"){
		?>
					<select name="VENDEDOR" id="VENDEDOR" style="width:99%;">
                    	<option value="0000007979">G.A.P. AGENTE DE SEGUROS Y DE FIANZAS S.A. DE C.V.</option>
                        <?
							$resListadoVendedores = DreQueryDB($sqlListadoVendedores);
							while($rowListadoVendedores = mysql_fetch_assoc($resListadoVendedores)){
						?>
                        <option value="<? echo $rowListadoVendedores['User']; ?>"><? echo $rowListadoVendedores['nombreVendedor']; ?></option>
                        <?
							}
						?>
					</select>
		<?
					} else if($Grupo == "2"){
		?>
					<select name="VENDEDOR" id="VENDEDOR" style="width:99%;">
                    	<option value="0000040756">FINANCIERA BEPENSA</option>
					</select>
		<?php			
					}
				break;
				
				case 3:
		?>
        			<select name="VENDEDOR" id="VENDEDOR" style="width:99%;">
                    <?
						$resListadoVendedores = DreQueryDB($sqlListadoVendedores);
						while($rowListadoVendedores = mysql_fetch_assoc($resListadoVendedores)){
					?>
                    <option value="<? echo $rowListadoVendedores['User']; ?>" <? echo ($_SESSION['WebDreTacticaWeb2']['User'] == $rowListadoVendedores['User'])? 'selected':''; ?>><? echo $rowListadoVendedores['nombreVendedor']; ?></option>
                    <?
						}
					?>
                    </select>
		<?
				break;
				
				case 2:
					$resListadoVendedores = DreQueryDB($sqlListadoVendedores);
					$rowListadoVendedores = mysql_fetch_assoc($resListadoVendedores);
					$sizeText = 5+strlen($rowListadoVendedores['nombreVendedor']);
				?>
	    			<input type="text" name="" id="" value="<? echo $rowListadoVendedores['nombreVendedor']; ?>" size="<?php echo $sizeText; ?>"/>
					<input type="hidden" name="VENDEDOR" id="VENDEDOR" value="<? echo $rowListadoVendedores['User']; ?>"/>
                    
                <?
				break;				
			}
		?>
        </td>
    </tr>
    <tr>
    	<td colspan="5" align="right">
        	<input type="hidden" name="SUCURSAL" id="SUCURSAL" value="<?php echo $Sucursal; ?>" />
        	<input type="button" value="Cancelar" class="buttonGeneral" onclick="java:window.open('<?php echo "directorio.php"; ?>','_self');" />
        	<input type="button" value="Guardar" class="buttonGeneral" onClick="ValidarAgregarCliente('<? echo $tipoPer; ?>')" /> 
            <!-- type="submit"  -->
        </td>
    </tr>
</table>
</form>
<!-- -->
        </td>
    </tr>
</table>
<script>
	Calendar.setup(
		{
		inputField : "FECHA_NACIMIENTO",
		trigger    : "FECHA_NACIMIENTO_Btn",
		onSelect   : function() { this.hide()},
		dateFormat : "%Y-%m-%d"
		}
		);
</script>