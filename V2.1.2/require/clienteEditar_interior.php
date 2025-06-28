<?php
if(isset($CLAVE) && $CLAVE != ""){
	$sqlDatosEmpresa = "
		Select 
			*
		From 
			`empresas`
		Where 

			`empresas`.`CLAVE` = '$_REQUEST[CLAVE]'
					   ";
	$resDatosEmpresa = DreQueryDB($sqlDatosEmpresa);
	$rowDatosEmpresa = mysql_fetch_assoc($resDatosEmpresa);	
}

switch($rowDatosEmpresa['TIPO_REGISTRO']){
	case 'PR':
		$tipoRegistro = "Prospecto"; // PROSPECTO
	break;
	
	case 'CL':
		$tipoRegistro = "Cliente"; // CLIENTE
	break;
}		

switch($rowDatosEmpresa['TIPO_PERSONA']){
	case 'F':
		$tipoPersona = "F&iacute;sica";
	break; 
	
	case 'M':
		$tipoPersona = "Moral";
	break; 
}

switch($rowDatosEmpresa['Club_Cap']){
	case 'S':
		$clubCap = "Si";
	break;

	case 'N':
		$clubCap = "No";
	break;

}

switch($rowDatosEmpresa['Poliza_Electronica']){
	case 'S':
		$polizaElectronica = "Si";
	break;

	case 'N':
		$polizaElectronica = "No";
	break;

}

switch($rowDatosEmpresa['GENERO']){
	case 'F':
		$genero = "Femenino";
	break;

	case 'M':
		$genero = "Masculino";
	break;

}

switch($rowDatosEmpresa['AUTOMOVIL']){
	case 'S':
		$automovil = "Si";
	break;

	case 'N':
		$automovil = "No";
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
					`vendedores`.`TIPO` = '".$_SESSION['WebDreTacticaWeb2']['Vendedor']."'
					Or
					`usuarios`.`PROMOTOR` = '".$_SESSION['WebDreTacticaWeb2']['Vendedor']."'
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
					`vendedores`.`CLAVE` = '".$_SESSION['WebDreTacticaWeb2']['Vendedor']."'
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
        	Edici&oacute;n de <? echo $tipoRegistro; ?> Persona <? echo $tipoPersona; ?>
		</td>
	</tr>
    <tr>
    	<td>&nbsp;</td>
    </tr>
    <tr>
    	<td>
<!-- -->
<form name="formEditarEmpresa" id="formEditarEmpresa" method="post" action="includes/editar.php?tipoEdicion=Empresa" >
<table width="900" cellpadding="1" cellspacing="2" align="center" border="0" >
	<tr>
		<td width="160" align="left">Sucursal:</td>
		<td width="160" align="left">
        <?php
switch($Nivel){ // New Version
	case 5: // (Administradores) Todos los Vendedores
		?>
        <select name="SUCURSAL" id="SUCURSAL" style="width:100%">
        	<?
				$sqlSucursales = "
					Select * From
						`catalogo_sucursales`
								 ";
				$resSucursales = DreQueryDB($sqlSucursales);
				while($rowSucursales = mysql_fetch_assoc($resSucursales)){
			?>
        	<option value="<? echo $rowSucursales['clave']; ?>" <? echo ($rowSucursales['clave'] == $rowDatosEmpresa['SUCURSAL'])? "selected" : ""; ?>><? echo $rowSucursales['nombre']; ?></option>
            <?php
				}
			?>
        </select>
        <?php
	break;

	case 4: // (Ejecutivos) Todos los Vendedores
	case 3: // (Promotores) Solo sus Vededores
	case 2: // solo el mismo como vendedor
		?>
		<input type="text" id="SUCURSAL" name="SUCURSAL" value="<? echo $rowDatosEmpresa['SUCURSAL']; ?>"  readonly="readonly" style="width:100%" />
		<?php
	break;
			}
		?>
		</td>
		<td align="right" width="100">&nbsp;</td>
		<td align="right" width="110">&nbsp;</td>
		<td width="370" align="right">&nbsp;</td>
	</tr>
	<tr>
	  <td align="left">Clave:</td>
	  <td align="left"><input type="text" id="CLAVE" name="CLAVE" disabled="disabled" value="<? echo $rowDatosEmpresa['CLAVE']; ?>"  readonly="readonly" style="width:100%"/></td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  <td align="right">&nbsp;</td>
	  </tr>
	<tr>
		<td align="left">Raz&oacute;n Social:</td>
		<td colspan="4" align="left">
			<input type="text" id="RAZON_SOCIAL" name="RAZON_SOCIAL" value="<? echo $rowDatosEmpresa['RAZON_SOCIAL'];?>" style="width:100%" />
		</td>
	</tr>
	<tr>
		<td align="left">Nombres:</td>
		<td colspan="4" align="left">
			<input type="text" name="NOMBRES" id="NOMBRES"  value="<?php echo $rowDatosEmpresa['NOMBRES'];?>" style="width:50%" />
		</td>
	</tr>
	<tr>
		<td align="left">Apellido Paterno:</td>
		<td colspan="4" align="left">
			<input type="text" name="APELLIDO_PATERNO" id="APELLIDO_PATERNO" value="<? echo $rowDatosEmpresa['APELLIDO_PATERNO'];?>" style="width:50%" />
		</td>
	</tr>
	<tr>
		<td align="left">Apellido Materno:</td>
		<td colspan="4" align="left">
			<input type="text" name="APELLIDO_MATERNO" id="APELLIDO_MATERNO" value="<? echo $rowDatosEmpresa['APELLIDO_MATERNO'];?>" style="width:50%" />
		</td>
	</tr>
	<tr>
		<td align="left">RFC:</td>
		<td align="left"><input type="text" id="RFC" name="RFC" value="<? echo $rowDatosEmpresa['RFC'];?>" style="width:100%" /></td>
        <td>&nbsp;</td>
		<td align="right">CURP:</td>
		<td align="left"><input type="text" id="CURP" name="CURP" value="<? echo $rowDatosEmpresa['CURP'];?>" style="width:160px" /></td>
	</tr>
	<tr>
		<td colspan="5" align="left">
            <!-- -->
        	<table width="900" cellpadding="1" cellspacing="2" border="0" align="center">
            	<tr>
                	<td width="160" rowspan="2" align="left">Tipo Persona:</td>
                    <td width="160" align="left">
                    	<input type="radio" name="TIPO_PERSONA" id="TIPO_PERSONA" value="F" <?php echo ($rowDatosEmpresa['TIPO_PERSONA'] == "F")? "checked" : ""; ?>/>
                        Fisica                        
					</td>
					<td width="100" rowspan="2" align="right">Club Cap:</td>
				  <td width="100" align="left"><input name="Club_Cap" id="Club_Cap" type="radio" value="S" <?php echo ($rowDatosEmpresa['Club_Cap'] == "S")? "checked" : ""; ?> />Si</td>
					<td width="160" rowspan="2" align="right">Poliza Electronica:</td>
				  <td width="220" align="left"><input name="Poliza_Electronica" id="Poliza_Electronica" type="radio" value="S" <?php echo ($rowDatosEmpresa['Poliza_Electronica'] == "S")? "checked" : ""; ?> />Si</td>
				</tr>
				<tr>
                	<td width="160" align="left">
                    	<input type="radio" name="TIPO_PERSONA" id="TIPO_PERSONA" value="M" <?php echo ($rowDatosEmpresa['TIPO_PERSONA'] == "M")? "checked" : ""; ?>/>
                        Moral
					</td>
				  <td width="100" align="left"><input name="Club_Cap" id="Club_Cap" type="radio" value="N" <?php echo ($rowDatosEmpresa['Club_Cap'] == "N")? "checked" : ""; ?> />No</td>
          <td width="220" align="left"><input name="Poliza_Electronica" id="Poliza_Electronica" type="radio" value="N" <?php echo ($rowDatosEmpresa['Poliza_Electronica'] == "N")? "checked" : ""; ?> />No</td>
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
        	<input type="text" name="CALLE" id="CALLE"  value="<? echo $rowDatosEmpresa['CALLE'];?>" style="width:100%"/>
        </td>
		</tr>
	<tr>
	  <td align="left">No. Ext:</td>
	  <td colspan="2" align="left">
      	<input type="text" name="NOEXTERIOR" id="NOEXTERIOR" value="<? echo $rowDatosEmpresa['NOEXTERIOR'];?>" style="width:160px"/>
	  </td>
	  <td align="right">No. Int:</td>
	  <td align="left">
      	<input type="text" name="NOINTERIOR" id="NOINTERIOR"  value="<? echo $rowDatosEmpresa['NOINTERIOR'];?>" style="width:160px"/>
      </td>
	  </tr>
	<tr>
	  <td align="left">Colonia:</td>
	  <td colspan="2" align="left">
      	<input type="text" name="COLONIA" id="COLONIA"  value="<? echo $rowDatosEmpresa['COLONIA'];?>" style="width:100%"/>
      </td>
	  <td align="right">CP:</td>
	  <td align="left">
      	<input type="text" name="CODIGO_POSTAL" id="CODIGO_POSTAL" value="<? echo $rowDatosEmpresa['CODIGO_POSTAL'];?>" style="width:160px"/>
      </td>
	  </tr>
	<tr>
	  <td align="left">Referencia:</td>
	  <td colspan="2" align="left">
      	<input type="text" name="REFERENCIA" id="REFERENCIA" value="<? echo $rowDatosEmpresa['REFERENCIA'];?>" style="width:120px"/> y <input type="text" name="REFERENCIA2" id="REFERENCIA2"  value="<? echo $rowDatosEmpresa['REFERENCIA2'];?>" style="width:115px"/>
        </td>
	  <td align="right">Tel Casa:</td>
	  <td align="left">
      	<input type="text" name="TELEFONO_PARTICULAR" id="TELEFONO_PARTICULAR"  value="<? echo $rowDatosEmpresa['TELEFONO_PARTICULAR'];?>" style="width:160px"/>
	  </td>
	</tr>
	<tr>
	  <td align="left">Localidad:</td>
	  <td colspan="2" align="left">
      	<input type="text" name="LOCALIDAD" id="LOCALIDAD"  value="<? echo $rowDatosEmpresa['LOCALIDAD'];?>" style="width:100%"/>
      </td>
	  <td align="right">Tel Trabajo:</td>
	  <td align="left">
      	<input type="text" name="TELEFONO_OFICINA" id="TELEFONO_OFICINA"  value="<? echo $rowDatosEmpresa['TELEFONO_OFICINA'];?>" style="width:160px"/>
      </td>
	  </tr>
	<tr>
	  <td align="left">Municipio:</td>
	  <td colspan="2" align="left">
      	<input type="text" name="MUNICIPO" id="MUNICIPO"  value="<? echo $rowDatosEmpresa['MUNICIPO'];?>" style="width:100%"/>
      </td>
	  <td align="right">Celular:</td>
	  <td align="left"><input type="text" name="TELEFONO_MOVIL" id="TELEFONO_MOVIL" value="<?php echo $rowDatosEmpresa['TELEFONO_MOVIL'];?>" style="width:160px"/></td>
	  </tr>
	<tr>
		<td align="left">Estado:</td>
		<td colspan="2" align="left">
        	<select name="ESTADO" id="ESTADO" style="width:99%;">
            	<option value="">-- Seleccione --</option>
                <?php
					while($rowEstado = mysql_fetch_assoc($resEstado)){
				?>
                <option value="<? echo $rowEstado['nombre_estado']; ?>" <? echo ($rowEstado['nombre_estado'] == $rowDatosEmpresa['ESTADO'])? "selected":""; ?>><? echo $rowEstado['nombre_estado']; ?></option>
                <?
					}
				?>
            </select>
        </td>
		<td align="right">&nbsp;</td>
		<td align="left">&nbsp;</td>
	</tr>
    <tr>
    	<td colspan="5"><hr /></td>
    </tr>
	<tr>
		<td align="left">Fecha Nacimiento:</td>
		<td align="left">
			<input type="text" name="FECHA_NACIMIENTO" id="FECHA_NACIMIENTO" value="<? echo $rowDatosEmpresa['FECHA_NACIMIENTO']; ?>" readonly style="width:124px" />
            <img src="img/cal.gif" width="16" height="16" id="FECHA_NACIMIENTO_Btn" border="0" title="Clic" />
		</td>
      <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
	</tr>
	<tr>
	  <td align="left">Nacionalidad:</td>
	  <td align="right">
      	<input type="text" name="NACIONALIDAD" id="NACIONALIDAD" value="<? echo $rowDatosEmpresa['NACIONALIDAD']; ?>" style="width:100%;"  />
      </td>
	  <td align="right">&nbsp;</td>
	  <td align="right">Edad:</td>
	  <td>
      	<input name="EDAD" type="text" id="EDAD" style="width:80px;" value="<?php echo calculaedad($rowDatosEmpresa['FECHA_NACIMIENTO']); ?>" readonly/>
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
        <option value="<?php echo $rowEscolaridad['titulo']?>" <?php echo ($rowEscolaridad['titulo'] == $rowDatosEmpresa['NIVEL_ESTUDIOS'])? "selected" : "" ;?>><?php echo $rowEscolaridad['titulo']?></option>
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
	    <option value="<?php echo $rowEstadoCivil['titulo']; ?>" <?php echo ($rowEstadoCivil['titulo'] == $rowDatosEmpresa['ESTADO_CIVIL'])? "selected" : "" ;?>><?php echo $rowEstadoCivil['titulo']; ?></option>
        <?php
			}
		?>
      </select>
      </td>
	</tr>
	<tr>
	  <td align="left">Automovil:</td>
	  <td align="left">
    	<input name="AUTOMOVIL" type="checkbox" id="AUTOMOVIL" value="S" <?php echo ($rowDatosEmpresa['AUTOMOVIL'] == "S")? "checked" : ""; ?>/>
      </td>
	  <td align="right">&nbsp;</td>
	  <td align="right">Genero:</td>
      <td align="left">
	    <select name="GENERO" id="GENERO" style=" width:158px">
	      <option value="">-- Seleccione --</option>
	      <?php
			while($rowGenero = mysql_fetch_assoc($resGenero)){
	      ?>
	      <option value="<?php echo $rowGenero['valor']; ?>" <?php echo ($rowGenero['valor'] == $rowDatosEmpresa['GENERO'])? "selected" : "" ; ?>><?php echo $rowGenero['titulo']; ?></option>
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
		?>
					<select name="VENDEDOR" id="VENDEDOR" style="width:99%;">
                    	<option value="0000007979">G.A.P. AGENTE DE SEGUROS Y DE FIANZAS S.A. DE C.V.</option>
                        <?
							$resListadoVendedores = DreQueryDB($sqlListadoVendedores);
							while($rowListadoVendedores = mysql_fetch_assoc($resListadoVendedores)){
						?>
                        <option value="<? echo $rowListadoVendedores['User']; ?>" <? echo ($rowListadoVendedores['User']==$rowDatosEmpresa['VENDEDOR'])? "selected" : ""; ?>><? echo $rowListadoVendedores['nombreVendedor']; ?></option>
                        <?
							}
						?>
					</select>
		<?
				break;
				
				case 3:
		?>
        			<select name="VENDEDOR" id="VENDEDOR" style="width:99%;">
                    <?
						$resListadoVendedores = DreQueryDB($sqlListadoVendedores);
						while($rowListadoVendedores = mysql_fetch_assoc($resListadoVendedores)){
					?>
                    <option value="<? echo $rowListadoVendedores['User']; ?>" <? echo ($_SESSION['WebDreTacticaWeb']['User'] == $rowListadoVendedores['User'])? 'selected':''; ?>><? echo $rowListadoVendedores['nombreVendedor']; ?></option>
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
	        <input type="hidden" name="CLAVE" id="CLAVE" value="<?php echo $rowDatosEmpresa['CLAVE']; ?>" />
        	<input type="button" value="Cancelar" class="buttonGeneral" onclick="java:window.open('<?php echo "cliente.php?CLAVE=".$rowDatosEmpresa['CLAVE']; ?>','_self');" />
        	<input type="submit" value="Guardar" />
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
