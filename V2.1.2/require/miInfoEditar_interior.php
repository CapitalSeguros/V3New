<?php
$sqlDatosUsuario = "
		Select 
			*
			,`info_usuarios_vendedores`.`SUCURSAL` As `sucursalInfo`
			,`usuarios`.`VALOR` As `usuarioInfo`
			,`info_usuarios_vendedores`.`NOMBRE` As `nombreInfo`	
			,`info_usuarios_vendedores`.`EMAIL` As `emailInfo`	
		From 
			`info_usuarios_vendedores` Inner Join `usuarios` 
			On 
			`info_usuarios_vendedores`.`VALOR` = `usuarios`.`VALOR`
		Where 

			`usuarios`.`VALOR` = '$Usuario'
					   ";
	$resDatosUsuario = DreQueryDB($sqlDatosUsuario);
	$rowDatosUsuario = mysql_fetch_assoc($resDatosUsuario);	
	
switch($rowDatosUsuario['EDIRECTA']){
	case "1":
		$emisionDirecta = "Si";
	break;
	
	case "0":
		$emisionDirecta = "No";
	break;	
}

switch($rowDatosUsuario['integral']){
	case "1":
		$usuarioIntegral = "Si";
	break;
	
	case "0":
		$usuarioIntegral = "No";
	break;	
}

switch($rowDatosUsuario['VEHICULO_PROPIO']){
	case "1":
		$vehiculoPropio = "Si";
	break;
	
	case "0":
		$vehiculoPropio = "No";
	break;	
}

?>
<table width="950" cellpadding="0" cellspacing="0" border="0">
	<tr class="TextoTitulosSeccion" align="left">
		<td>
        	Mi Info
		</td>
	</tr>
<form name="formMiInfoEditar" id="formMiInfoEditar" method="post" enctype="multipart/form-data" action="includes/editar.php?tipoEdicion=MiInfo">
	<tr>
		<td>
        	<!-- InfoEmpresa -->
			<table width="900" cellpadding="2" cellspacing="0" align="center" border="0" style="font-size:12px;">
            	<tr>
                	<td align="left">Sucursal:</td>
                    <td colspan="3" align="left"><strong><?php echo $rowDatosUsuario['sucursalInfo']; ?></strong></td>
                    <td width="350" rowspan="7" align="center">
                    	<img src="<? echo "img/usuarios/".$rowDatosUsuario['IMAGEN']; ?>" width="100" height="120" style="border:#000000 solid 1px;" />
                    </td>
				</tr>
                <tr>
                	<td align="left">Usuario:</td>
                    <td colspan="3" align="left"><strong><?php echo $rowDatosUsuario['usuarioInfo']; ?></strong></td>
                </tr>
				<tr>
                	<td align="left">Nombre:</td>
                    <td align="left" colspan="3">
						<input type="text" name="NOMBRE" id="NOMBRE" value="<?php echo $rowDatosUsuario['nombreInfo']; ?>" style="width:100%" />
                    </td>
                </tr>
				<tr>
                	<td align="left">Apellido:</td>
                    <td align="left" colspan="3">
						<input type="text" name="APELLIDOS" id="APELLIDOS" value="<?php echo $rowDatosUsuario['APELLIDOS']; ?>" style="width:100%" />
                    </td>
                </tr>
                <tr>
                	<td align="left">Promotor:</td>
                    <td align="left" colspan="3"><strong><?php echo $rowDatosUsuario['CONSULTOR'];?></strong></td>
                </tr>
                
                <tr>
                	<td align="left" width="150"></td>
                    <td align="left" width="200"></td>
                    <td align="left" width="100"></td>
                    <td align="left" width="100"></td>
                </tr>
				<tr>
                	<td colspan="4">
					<!-- -->
                    <table width="550" cellpadding="2" cellspacing="0" border="0" style="font-size:12px;" align="left">
                    	<tr>
                        	<td width="275" align="right">Emisi&oacute;n Directa:</td>
                            <td align="left"><strong><?php echo $emisionDirecta; ?></strong></td>
                            <td width="275" align="right">Usuario Integral:</td>
							<td align="left"><strong><?php echo $usuarioIntegral; ?></strong></td>
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
                    <td colspan="2" align="left">
						<input type="text" name="CALLE" id="CALLE" value="<?php echo $rowDatosUsuario['CALLE']; ?>" style="width:100%" />
                    </td>
                    <td colspan="2" align="right">
                    <!--
                    	<input type="hidden" name="sourceImagen" id="sourceImagen" value="<?php echo $rowDatosUsuario['VALOR'].".png"; ?>" />
                    	<input type="file" name="IMAGEN" id="IMAGEN" />
					-->
                    </td>
				</tr>
                <tr>
                	<td align="left">No. Ext:</td>
                    <td colspan="2" align="left">
						<input type="text" name="NO_EXT" id="NO_EXT" value="<?php echo $rowDatosUsuario['NO_EXT']; ?>" style="width:100%" />
                    </td>
                    <td align="left">RFC:</td>
                    <td align="left">
						<input type="text" name="RFC" id="RFC" value="<?php echo $rowDatosUsuario['RFC']; ?>" style="width:50%" />
                    </td>
				</tr>
                <tr>
                	<td align="left">Colonia:</td>
                    <td colspan="2" align="left">
						<input type="text" name="COLONIA" id="COLONIA" value="<?php echo $rowDatosUsuario['COLONIA']; ?>" style="width:100%" />
                    </td>
                    <td align="left">CP:</td>
                    <td align="left">
						<input type="text" name="CP" id="CP" value="<?php echo $rowDatosUsuario['CP']; ?>" style="width:50%" />
                    </td>
				</tr>
                <tr>
                	<td align="left">Referencia:</td>
                    <td colspan="2" align="left">
						<input type="text" name="CRUZAMIENTO" id="CRUZAMIENTO" value="<?php echo $rowDatosUsuario['CRUZAMIENTO']; ?>" style="width:100%" />
                    </td>
                    <td align="left">Tel Casa:</td>
                    <td align="left">
						<input type="text" name="TELEFONO_CASA" id="TELEFONO_CASA" value="<?php echo $rowDatosUsuario['TELEFONO_CASA']; ?>" style="width:50%" />
                    </td>
				</tr>
                <tr>
	                <td align="left">Ciudad:</td>
                    <td colspan="2" align="left">
						<input type="text" name="CIUDAD_ID" id="CIUDAD_ID" value="<?php echo $rowDatosUsuario['CIUDAD_ID']; ?>" style="width:100%" />
                    </td>
                    <td align="left">Tel Trabajo:</td>
                    <td align="left">
						<input type="text" name="TELEFONO_TRABAJO" id="TELEFONO_TRABAJO" value="<?php echo $rowDatosUsuario['TELEFONO_TRABAJO']; ?>" style="width:50%" />
                    </td>
				</tr>
                <tr>
                	<td align="left">Estado Civil:</td>
                    <td colspan="2" align="left">
						
                        <?php SelectEstadoCivil($rowDatosUsuario['ESTADO_CIVIL']); ?>
                    </td>
                    <td align="left">Celular:</td>
                    <td align="left">
						<input type="text" name="TELEFONO_CELULAR" id="TELEFONO_CELULAR" value="<?php echo $rowDatosUsuario['TELEFONO_CELULAR']; ?>" style="width:50%" />
                    </td>
				</tr>
                <tr>
                	<td align="left">Escolaridad:</td>
                    <td colspan="2" align="left">
                        <?php SelectEscolaridad($rowDatosUsuario['ESCOLARIDAD']); ?>
                    </td>
                    <td align="left">Comp. Cel.:</td>
                    <td align="left">
                        <?php SelectCiaCel($rowDatosUsuario['CIA_CEL']);?>
                    </td>
				</tr>
<!-- -->
                <tr>
                	<td>Lugar Nac.:</td>
                	<td colspan="2" align="left">
						<input type="text" name="LUGAR_NACIMIENTO" id="LUGAR_NACIMIENTO" value="<?php echo $rowDatosUsuario['LUGAR_NACIMIENTO']; ?>" style="width:100%" />
                    </td>
                	<td>Fecha Nac.:</td>
                	<td align="left">
						<input type="text" name="FECHA_NACIMIENTO" id="FECHA_NACIMIENTO" value="<?php echo $rowDatosUsuario['FECHA_NACIMIENTO']; ?>" readonly style="width:50%" />
			            <img src="img/cal.gif" width="16" height="16" id="FECHA_NACIMIENTO_Btn" border="0" title="Clic" />
                    </td>
				</tr>    
                <tr>
                	<td align="left">Correo Electr&oacute;nico:</td>
                    <td colspan="4" align="left">
						<input type="text" name="EMAIL" id="EMAIL" value="<?php echo $rowDatosUsuario['emailInfo']; ?>" style="width:100%" />
                    </td>
				</tr>
                <tr>
                	<td colspan="5"><hr></td>
               	</tr>    
                <tr>
                	<td align="left">Vehiculo Propio:</td>
                    <td colspan="2" align="left">
                        <?php SelectVehiculoPropio($rowDatosUsuario['VEHICULO_PROPIO']); ?>
                    </td>
                    <td align="left">&nbsp;</td>
                    <td align="left">&nbsp;</td>
				</tr>
                <tr>
                	<td align="left">Modelo Vehiculo:</td>
                    <td colspan="4" align="left">
						<input type="text" name="MODELO_VEHICULO" id="MODELO_VEHICULO" value="<?php echo $rowDatosUsuario['MODELO_VEHICULO']; ?>" style="width:100%" />
                    </td>
				</tr>
                <tr>
                	<td colspan="5"><hr></td>
               	</tr>    
                <tr>
                	<td align="left">Banco:</td>
                    <td colspan="2" align="left">
						<input type="text" name="BANCO" id="BANCO" value="<?php echo $rowDatosUsuario['BANCO']; ?>" style="width:100%" />
                    </td>
                    <td align="left">Tipo Cuenta:</td>
                    <td align="left">
						<input type="text" name="TIPO_CUENTA" id="TIPO_CUENTA" value="<?php echo $rowDatosUsuario['TIPO_CUENTA']; ?>" style="width:100%" />
                    </td>
				</tr>
                <tr>
                	<td align="left">Cuenta B.:</td>
                    <td colspan="2" align="left">
						<input type="text" name="CUENTA_BANCARIA" id="CUENTA_BANCARIA" value="<?php echo $rowDatosUsuario['CUENTA_BANCARIA']; ?>" style="width:100%" />
                    </td>
                    <td align="left">Clabe:</td>
                    <td align="left"><strong>                    
						<input type="text" name="CLABE" id="CLABE" value="<?php echo $rowDatosUsuario['CLABE']; ?>" style="width:100%" />
                    </td>
				</tr>
                <tr>
                	<td colspan="5"><hr></td>
               	</tr>    
                <tr>
                	<td align="left">Cedula CNSF:</td>
                    <td colspan="2" align="left">
						<input type="text" name="CEDULA_CNSF" id="CEDULA_CNSF" value="<?php echo $rowDatosUsuario['CEDULA_CNSF']; ?>" style="width:100%" />
                    </td>
                    <td align="left">Tipo Aut:</td>
                    <td align="left">
						<input type="text" name="TIPO_AUT" id="TIPO_AUT" value="<?php echo $rowDatosUsuario['TIPO_AUT']; ?>" style="width:100%" />
                    </td>
                </tr>
                <tr>
                	<td align="left">Vigencia Cedula:</td>
                    <td colspan="4" align="left">
						<input type="text" name="VIGENCIA" id="VIGENCIA" value="<?php echo $rowDatosUsuario['VIGENCIA']; ?>" style="width:30%" />
                        <img src="img/cal.gif" width="16" height="16" id="VIGENCIA_Btn" border="0" title="Clic" />
                    </td>
                </tr>
                <tr>
                	<td colspan="5"><hr></td>
               	</tr>    
                <tr>
                	<td align="left">Licencia de Conducir:</td>
                    <td colspan="2" align="left">
						<input type="text" name="LICENCIA_MANEJAR" id="LICENCIA_MANEJAR" value="<?php echo $rowDatosUsuario['LICENCIA_MANEJAR']; ?>" style="width:100%" />
                    </td>
                    <td align="left">&nbsp;</td>
                    <td align="left">&nbsp;</td>
                </tr>
                <tr>
                	<td align="left">Vigencia Licencia:</td>
                    <td colspan="4" align="left">
						<input type="text" name="VIGENCIA_LICENCIA_MANEJAR" id="VIGENCIA_LICENCIA_MANEJAR" value="<?php echo $rowDatosUsuario['VIGENCIA_LICENCIA_MANEJAR']; ?>" style="width:30%" />
                        <img src="img/cal.gif" width="16" height="16" id="VIGENCIA_LICENCIA_MANEJAR_Btn" border="0" title="Clic" />
                    </td>
                </tr>
                <tr>
                	<td colspan="5"><hr></td>
               	</tr>    
                <tr>
                	<td align="left">Pasaporte:</td>
                    <td colspan="2" align="left">
						<input type="text" name="PASAPORTE" id="PASAPORTE" value="<?php echo $rowDatosUsuario['PASAPORTE']; ?>" style="width:100%" />
                    </td>
                    <td align="left">&nbsp;</td>
                    <td align="left">&nbsp;</td>
                </tr>
                <tr>
                	<td align="left">Vigencia Pasaporte:</td>
                    <td colspan="4" align="left">
						<input type="text" name="VIGENCIA_PASAPORTE" id="VIGENCIA_PASAPORTE" value="<?php echo $rowDatosUsuario['VIGENCIA_PASAPORTE']; ?>" style="width:30%" />
						<img src="img/cal.gif" width="16" height="16" id="VIGENCIA_PASAPORTE_Btn" border="0" title="Clic" />
                    </td>
                </tr>
                <tr>
                	<td colspan="5"><hr></td>
               	</tr>    

                <tr>
                	<td align="left">Accidente avisar a:</td>
                    <td colspan="2" align="left">
						<input type="text" name="ACCIDENTE_AVISAR" id="ACCIDENTE_AVISAR" value="<?php echo $rowDatosUsuario['ACCIDENTE_AVISAR']; ?>" style="width:100%" />
                    </td>
                    <td align="left">Tel Accidente:</td>
                    <td align="left">
						<input type="text" name="TELEFONO_ACCIDENTE" id="TELEFONO_ACCIDENTE" value="<?php echo $rowDatosUsuario['TELEFONO_ACCIDENTE']; ?>" style="width:100%" />
                    </td>
                </tr>
                <tr>
                	<td align="left">Recomendado por:</td>
                    <td colspan="4" align="left">
						<input type="text" name="RECOMENDADO_POR" id="RECOMENDADO_POR" value="<?php echo $rowDatosUsuario['RECOMENDADO_POR']; ?>" style="width:100%" />
                    </td>
                </tr>
                <tr>
                	<td align="left">Referencias:</td>
                    <td colspan="4" align="left">
						<input type="text" name="REFERENCIAS" id="REFERENCIAS" value="<?php echo $rowDatosUsuario['REFERENCIAS']; ?>" style="width:100%" />
                    </td>
                </tr>
                <tr>
                	<td align="left">IMSS:</td>
                    <td colspan="2" align="left">
						<input type="text" name="IMSS" id="IMSS" value="<?php echo $rowDatosUsuario['IMSS']; ?>" style="width:100%" />
                    </td>
                    <td align="left">Tiene Hijos:</td>
                    <td align="left">
                        <?php SelectTieneHijos($rowDatosUsuario['TIENE_HIJOS']); ?>
                    </td>
                </tr>
                <tr>
                	<td colspan="5"><hr></td>
               	</tr>
                <tr>
                	<td align="left">Gasto Mensual:</td>
                    <td colspan="2" align="left">
						<input type="text" name="GASTO_PROMEDIO_MENSUAL" id="GASTO_PROMEDIO_MENSUAL" value="<?php echo $rowDatosUsuario['GASTO_PROMEDIO_MENSUAL']; ?>" style="width:100%" />
                    </td>
                    <td align="left">C. T. G. Ganar:</td>
                    <td align="left">
						<input type="text" name="CUANTO_TE_GUSTARIA_GANAR" id="CUANTO_TE_GUSTARIA_GANAR" value="<?php echo $rowDatosUsuario['CUANTO_TE_GUSTARIA_GANAR']; ?>" style="width:100%" />
                    </td>
                </tr>
                <tr>
                	<td align="left">Comida Favorita:</td>
                    <td colspan="2" align="left">
						<input type="text" name="COMIDA_FAVORITA" id="COMIDA_FAVORITA" value="<?php echo $rowDatosUsuario['COMIDA_FAVORITA']; ?>" style="width:100%" />
                    </td>
                    <td align="left">Color Favorito:</td>
                    <td align="left">
						<input type="text" name="COLOR_FAVORITO" id="COLOR_FAVORITO" value="<?php echo $rowDatosUsuario['COLOR_FAVORITO']; ?>" style="width:100%" />
                    </td>
                </tr>
                <tr>
                	<td align="left">A. Bodas:</td>
                    <td colspan="2" align="left">
						<input type="text" name="ANIVERSARIO_BODAS" id="ANIVERSARIO_BODAS" value="<?php echo $rowDatosUsuario['ANIVERSARIO_BODAS']; ?>" readonly style="width:90%" />
			            <img src="img/cal.gif" width="16" height="16" id="ANIVERSARIO_BODAS_Btn" border="0" title="Clic" />
                    </td>
                    <td align="left">&nbsp;</td>
                    <td align="left">&nbsp;
                    	
                    </td>
                </tr>
                <tr>
                	<td align="left">Pasatiempo Favorito:</td>
                    <td colspan="4" align="left">
						<input type="text" name="PASATIEMPO_FAVORITO" id="PASATIEMPO_FAVORITO" value="<?php echo $rowDatosUsuario['PASATIEMPO_FAVORITO']; ?>" style="width:100%" />
                    </td>
                </tr>
                <tr>
                	<td align="left">Club Social:</td>
                    <td colspan="4" align="left">
						<input type="text" name="CLUB_SOCIAL" id="CLUB_SOCIAL" value="<?php echo $rowDatosUsuario['CLUB_SOCIAL']; ?>" style="width:100%" />
                    </td>
                </tr>
                <tr>
                  <td align="left">&nbsp;</td>
                  <td colspan="4" align="right">
					<input type="hidden" name="VALOR" id="VALOR" value="<?php echo $Usuario; ?>" />
                    <input type="hidden" name="source" id="source" value="<?php echo $Usuario.".png"; ?>" />
					<input type="button" value="Cancelar" class="buttonGeneral" onclick="java:window.open('miInfo.php','_self');" />
					<input type="submit" value="Guardar" />
                    </td>
                  </td>
                </tr>
			</table>
	  </td>
  </tr>
</form>
    <tr>
    	<td>&nbsp;</td>
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
	Calendar.setup(
		{
		inputField : "ANIVERSARIO_BODAS",
		trigger    : "ANIVERSARIO_BODAS_Btn",
		onSelect   : function() { this.hide()},
		dateFormat : "%Y-%m-%d"
		}
		);
	Calendar.setup(
		{
		inputField : "VIGENCIA",
		trigger    : "VIGENCIA_Btn",
		onSelect   : function() { this.hide()},
		dateFormat : "%Y-%m-%d"
		}
		);
	Calendar.setup(
		{
		inputField : "VIGENCIA_LICENCIA_MANEJAR",
		trigger    : "VIGENCIA_LICENCIA_MANEJAR_Btn",
		onSelect   : function() { this.hide()},
		dateFormat : "%Y-%m-%d"
		}
		);
	Calendar.setup(
		{
		inputField : "VIGENCIA_PASAPORTE",
		trigger    : "VIGENCIA_PASAPORTE_Btn",
		onSelect   : function() { this.hide()},
		dateFormat : "%Y-%m-%d"
		}
		);
</script>
