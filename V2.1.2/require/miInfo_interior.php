<?php
	$sqlDatosUsuario = "
		Select 
			*
			,`usuarios`.`VALOR` As `usuarioInfo`
			,`info_usuarios_vendedores`.`SUCURSAL` As `sucursalInfo`
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
	<tr>
		<td valign="top" align="right">
        	<a href="<?php echo "miInfoEditar.php?VALOR=".$Usuario; ?>" title="Editar Usuario" style="text-decoration:none"><img src="img/transparente.fw.png" class="system editar" alt="editar" border="0"/></a>
        </td>
	</tr>
  <tr>
		<td>
        	<!-- InfoEmpresa -->
			<table width="900" cellpadding="2" cellspacing="0" align="center" border="0" style="font-size:12px;">
            	<tr>
                	<td align="left">Sucursal:</td>
                    <td colspan="3" align="left"><strong><?php echo $rowDatosUsuario['sucursalInfo']; ?></strong></td>
                    <td width="350" rowspan="7" align="center">
<?
if(file_exists("img/usuarios/".$rowDatosUsuario['VALOR'].".jpg")){
?>
						<a href="<?php echo "miInfoEditarPhoto.php?VALOR=".$Usuario; ?>" title="Editar Foto Usuario" style="text-decoration:none">
                        	<img src="<? echo "img/usuarios/".$rowDatosUsuario['IMAGEN']; ?>" width="100" height="120" style="border:#000000 solid 1px;" />
						</a>
<?
} else {
?>
						<a href="<?php echo "miInfoEditarPhoto.php?VALOR=".$Usuario; ?>" title="Editar Foto Usuario" style="text-decoration:none">
                            <img src="img/usuarios/noPhoto.png" width="102" height="122" style="border:#000000 solid 1px;" />
						</a>
<?
}
?>
                    </td>
				</tr>
                <tr>
                	<td align="left">Usuario:</td>
                    <td colspan="3" align="left"><strong><?php echo $rowDatosUsuario['usuarioInfo']; ?></strong></td>
                </tr>
				<tr>
                	<td align="left">Nombre:</td>
                    <td align="left" colspan="3"><strong><?php echo $rowDatosUsuario['nombreInfo'];?></strong></td>
                </tr>
				<tr>
                	<td align="left">Apellido:</td>
                    <td align="left" colspan="3"><strong><?php echo $rowDatosUsuario['APELLIDOS'];?></strong></td>
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
                    <td colspan="2" align="left"><strong><?php echo $rowDatosUsuario['CALLE']; ?></strong></td>
                    <td align="left">RFC:</td>
                    <td align="left"><strong><?php echo $rowDatosUsuario['RFC']; ?></strong></td>
				</tr>
                <tr>
                	<td align="left">No. Ext:</td>
                    <td colspan="2" align="left"><strong><?php echo $rowDatosUsuario['NO_EXT']; ?></strong></td>
                    <td align="left">&nbsp;</td>
                    <td align="left">&nbsp;</td>
				</tr>
                <tr>
                	<td align="left">Colonia:</td>
                    <td colspan="2" align="left"><strong><?php echo $rowDatosUsuario['COLONIA']; ?></strong></td>
                    <td align="left">CP:</td>
                    <td align="left"><strong><?php echo $rowDatosUsuario['CP']; ?></strong></td>
				</tr>
                <tr>
                	<td align="left">Referencia:</td>
                    <td colspan="2" align="left"><strong><?php echo $rowDatosUsuario['CRUZAMIENTO']; ?></strong></td>
                    <td align="left">Tel Casa:</td>
                    <td align="left"><strong><?php echo $rowDatosUsuario['TELEFONO_CASA']; ?></strong></td>
				</tr>
                <tr>
	                <td align="left">Ciudad:</td>
                    <td colspan="2" align="left"><strong><?php echo $rowDatosUsuario['CIUDAD_ID']; ?></strong></td>
                    <td align="left">Tel Trabajo:</td>
                    <td align="left"><strong><?php echo $rowDatosUsuario['TELEFONO_TRABAJO']; ?></strong></td>
				</tr>
                <tr>
                	<td align="left">Estado Civil:</td>
                    <td colspan="2" align="left"><strong><?php echo $rowDatosUsuario['ESTADO_CIVIL']; ?></strong></td>
                    <td align="left">Celular:</td>
                    <td align="left"><strong><?php echo $rowDatosUsuario['TELEFONO_CELULAR']; ?></strong></td>
				</tr>
                <tr>
                	<td align="left">Escolaridad:</td>
                    <td colspan="2" align="left"><strong><?php echo strtoupper($rowDatosUsuario['ESCOLARIDAD']); ?></strong></td>
                    <td align="left">Comp. Cel.:</td>
                    <td align="left"><strong><?php echo strtoupper($rowDatosUsuario['CIA_CEL']); ?></strong></td>
				</tr>
<!-- -->
                <tr>
                	<td>Lugar Nac.:</td>
                	<td colspan="2" align="left"><strong><?php echo $rowDatosUsuario['LUGAR_NACIMIENTO']; ?></strong></td>
                	<td>Fecha Nac.:</td>
                	<td align="left"><strong><?php echo $rowDatosUsuario['FECHA_NACIMIENTO']; ?></strong></td>
				</tr>    
                <tr>
                	<td align="left">Correo Electr&oacute;nico:</td>
                    <td colspan="4" align="left"><strong><?php echo $rowDatosUsuario['emailInfo']; ?></strong></td>
				</tr>
                <tr>
                	<td colspan="5"><hr></td>
               	</tr>    
                <tr>
                	<td align="left">Vehiculo Propio:</td>
                    <td colspan="2" align="left"><strong><?php echo $vehiculoPropio; ?></strong></td>
                    <td align="left">&nbsp;</td>
                    <td align="left">&nbsp;</td>
				</tr>
                <tr>
                	<td align="left">Modelo Vehiculo:</td>
                    <td colspan="4" align="left"><strong><?php echo $rowDatosUsuario['MODELO_VEHICULO']; ?></strong></td>
				</tr>
                <tr>
                	<td colspan="5"><hr></td>
               	</tr>    
                <tr>
                	<td align="left">Banco:</td>
                    <td colspan="2" align="left"><strong><?php echo $rowDatosUsuario['BANCO']; ?></strong></td>
                    <td align="left">Tipo Cuenta:</td>
                    <td align="left"><strong><?php echo $rowDatosUsuario['TIPO_CUENTA']; ?></strong></td>
				</tr>
                <tr>
                	<td align="left">Cuenta B.:</td>
                    <td colspan="2" align="left"><strong><?php echo $rowDatosUsuario['CUENTA_BANCARIA']; ?></strong></td>
                    <td align="left">Clabe:</td>
                    <td align="left"><strong><?php echo $rowDatosUsuario['CLABE']; ?></strong></td>
				</tr>
                <tr>
                	<td colspan="5"><hr></td>
               	</tr>    
                <tr>
                	<td align="left">Cedula CNSF:</td>
                    <td colspan="2" align="left"><strong><?php echo $rowDatosUsuario['CEDULA_CNSF']; ?></strong></td>
                    <td align="left">Tipo Aut:</td>
                    <td align="left"><strong><?php echo $rowDatosUsuario['TIPO_AUTO']; ?></strong></td>
                </tr>
                <tr>
                	<td align="left">Vigencia Cedula:</td>
                    <td colspan="4" align="left"><strong><?php echo $rowDatosUsuario['VIGENCIA']; ?></strong></td>
                </tr>
                <tr>
                	<td colspan="5"><hr></td>
               	</tr>    
                <tr>
                	<td align="left">Licencia de Conducir:</td>
                    <td colspan="2" align="left"><strong><?php echo $rowDatosUsuario['LICENCIA_MANEJAR']; ?></strong></td>
                    <td align="left">&nbsp;</td>
                    <td align="left">&nbsp;</td>
                </tr>
                <tr>
                	<td align="left">Vigencia Licencia:</td>
                    <td colspan="4" align="left"><strong><?php echo $rowDatosUsuario['VIGENCIA_LICENCIA_MANEJAR']; ?></strong></td>
                </tr>
                <tr>
                	<td colspan="5"><hr></td>
               	</tr>    
                <tr>
                	<td align="left">Pasaporte:</td>
                    <td colspan="2" align="left"><strong><?php echo $rowDatosUsuario['PASAPORTE']; ?></strong></td>
                    <td align="left">&nbsp;</td>
                    <td align="left">&nbsp;</td>
                </tr>
                <tr>
                	<td align="left">Vigencia Pasaporte:</td>
                    <td colspan="4" align="left"><strong><?php echo $rowDatosUsuario['VIGENCIA_PASAPORTE']; ?></strong></td>
                </tr>
                <tr>
                	<td colspan="5"><hr></td>
               	</tr>    
                <tr>
                	<td align="left">Accidente avisar a:</td>
                    <td colspan="2" align="left"><strong><?php echo $rowDatosUsuario['ACCIDENTE_AVISAR']; ?></strong></td>
                    <td align="left">Tel Accidente:</td>
                    <td align="left"><strong><?php echo $rowDatosUsuario['TELEFONO_ACCIDENTE']; ?></strong></td>
                </tr>
                <tr>
                	<td align="left">Recomendado por:</td>
                    <td colspan="4" align="left"><strong><?php echo $rowDatosUsuario['RECOMENDADO_POR']; ?></strong></td>
                </tr>
                <tr>
                	<td align="left">Referencias:</td>
                    <td colspan="4" align="left"><strong><?php echo $rowDatosUsuario['REFERENCIAS']; ?></strong></td>
                </tr>
                <tr>
                	<td align="left">IMSS:</td>
                    <td colspan="2" align="left"><strong><?php echo $rowDatosUsuario['IMSS']; ?></strong></td>
                    <td align="left">Tiene Hijos:</td>
                    <td align="left"><strong><?php echo ($rowDatosUsuario['TIENE_HIJOS'] == 1)? "Si" : "No"; ?></strong></td>
                </tr>
                <tr>
                	<td colspan="5"><hr></td>
               	</tr>
                <tr>
                	<td align="left">Gasto Mensual:</td>
                    <td colspan="2" align="left"><strong><?php echo $rowDatosUsuario['GASTO_PROMEDIO_MENSUAL']; ?></strong></td>
                    <td align="left">C. T. G. Ganar:</td>
                    <td align="left"><strong><?php echo $rowDatosUsuario['CUANTO_TE_GUSTARIA_GANAR']; ?></strong></td>
                </tr>
                <tr>
                	<td align="left">Comida Favorita:</td>
                    <td colspan="2" align="left"><strong><?php echo $rowDatosUsuario['COMIDA_FAVORITA']; ?></strong></td>
                    <td align="left">Color Favorito:</td>
                    <td align="left"><strong><?php echo $rowDatosUsuario['COLOR_FAVORITO']; ?></strong></td>
                </tr>
                <tr>
                	<td align="left">A. Bodas:</td>
                    <td colspan="2" align="left"><strong><?php echo $rowDatosUsuario['ANIVERSARIO_BODAS']; ?></strong></td>
                    <td align="left">&nbsp;</td>
                    <td align="left">&nbsp;</td>
                </tr>
                <tr>
                	<td align="left">Pasatiempo Favorito:</td>
                    <td colspan="4" align="left"><strong><?php echo $rowDatosUsuario['PASATIEMPO_FAVORITO']; ?></strong></td>
                </tr>
                <tr>
                	<td align="left">Club Social:</td>
                    <td colspan="4" align="left"><strong><?php echo $rowDatosUsuario['CLUB_SOCIAL']; ?></strong></td>
                </tr>
			</table>
	  </td>
  </tr>
    <tr>
    	<td>&nbsp;</td>
    </tr>
</table>