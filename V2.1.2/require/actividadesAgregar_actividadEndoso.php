<script>
	function selectCliente(urlReenvio){	
		window.open(urlReenvio,'_self');
	}
</script>
<form name="formBuscarPolCli" id="formBuscarPolCli" method="post" action="<? echo $_SERVER['PHP_SELF']; ?>">
    <tr>
    	<td>
            Buscar Poliza/Cliente:
            <input type="text" name="buscadorPolizaCliente" id="buscadorPolizaCliente" style="width:73%" value="<? echo (isset($_REQUEST['buscadorPolizaCliente']))? $_REQUEST['buscadorPolizaCliente'] : "" ; ?>"/>
            <input type="submit" name="button" id="button" value="Buscar" class="buttonGeneral"/> 
            <input type="hidden" name="Actividad" id="Actividad" value="<?php echo $Actividad?>" />
			<input type="hidden" name="usuarioCreacion" id="usuarioCreacion" value="<?php echo $usuarioCreacion; ?>" />
         </td>
    </tr>
</form>

<form name="formAgregarEndoso" id="formAgregarEndoso" method="post" enctype="multipart/form-data" action="includes/agregarActividades.php?tipoAgregar=Actividad">
    <tr>
    	<td>
		<input type="hidden" name="usuarioCreacion" id="usuarioCreacion" value="<?php echo $usuarioCreacion; ?>" />
		<?php 
			if(isset($buscadorPolizaCliente) && $buscadorPolizaCliente != ""){
			$resBusquedaPoliza = DreQueryDB($sqlBusquedaPoliza); 
			$existePoliza = mysql_num_rows($resBusquedaPoliza);
			if($existePoliza > 0){ 
				//--> echo "si hay resultado";
		?>
        <table width="95%" align="center" cellpadding="2" cellspacing="2" border="0">
        	<tr style="background-image:url(img/fondoTablaDegradadoGris.png); color:#273B71; font-weight:bold;">
            	<td colspan="2">Cliente</td>
                <td>&nbsp;</td>
            </tr>
            <? 
				$contIntLi = 0;
				while($rowBusquedaPoliza = mysql_fetch_assoc($resBusquedaPoliza)){
					//** print_r($rowBusquedaPoliza);
			?>
        	<tr style="font-size:10px; " bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>">
            	<td width="9" align="center">
                	<input 
                    	type="radio" name="idCliente" id="idCliente"
                        value="<? echo $rowBusquedaPoliza['CLAVE_CLIENTE']; ?>"
						<? echo ($existePoliza == 1 || ($rowBusquedaPoliza['CLAVE_CLIENTE'] == $idCliente))? "checked":""; ?>
                    />
                </td>
            	<td width="150"><? echo DreNombreCliente($rowBusquedaPoliza['CLAVE_CLIENTE']); ?></td>
                <td>
                	<table width="100%" align="center" cellpadding="2" cellspacing="2" border="0">
                    	<tr style="font-size:10px; " bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>">
							<td colspan="2">Poliza</td>
							<td>Vigencia</td>
							<td>SubRamo</td>
							<td>Descripcion</td>
                        </tr>
                        <?
						$sqlVerificaPolClienteDetalle = "Select * From `cliramos` Where `POLIZA` Like '%$buscaPolCli%'";
						if(mysql_num_rows(DreQueryDB($sqlVerificaPolClienteDetalle)) != 0){	
							$sqlPolizaClienteDetalle = "
								Select * From 
									`cliramos`
								Where
								`POLIZA` Like '%$buscaPolCli%'
													   ";
						} else {
							$sqlPolizaClienteDetalle = "
								Select * From 
									`cliramos`
								Where
									`CLAVE_CLIENTE` = '$rowBusquedaPoliza[CLAVE]'
													   ";
						}
							$resPolizaClienteDetalle = DreQueryDB($sqlPolizaClienteDetalle);
							while($rowPolizaClienteDetalle = mysql_fetch_assoc($resPolizaClienteDetalle)){
								//print_r($rowPolizaClienteDetalle);
								$urlReenvio = $_SERVER['PHP_SELF']."?Actividad=Endoso";
								$urlReenvio.= "&buscadorPolizaCliente=".$buscadorPolizaCliente;
								$urlReenvio.= "&usuarioCreacion=".$usuarioCreacion;
								$urlReenvio.= "&idCliente=".$rowPolizaClienteDetalle['CLAVE_CLIENTE'];
								$urlReenvio.= "&idPoliza=".$rowPolizaClienteDetalle['POLIZA'];
						?>
                    	<tr style="font-size:8px; ">
                        	<td width="9">
                            	<input 
                                	type="radio" name="idPoliza" id="idPoliza" 
                                    value="<? echo $rowPolizaClienteDetalle['POLIZA']; ?>" 
									<? echo ($rowPolizaClienteDetalle['POLIZA'] == $buscadorPolizaCliente || ($rowPolizaClienteDetalle['POLIZA'] == $idPoliza))? "checked" : ""; ?>
                                    onClick="selectCliente('<? echo $urlReenvio; ?>');"
                                />
                            </td>
                        	<td width="100" style="font-size:8px;"><? echo $rowPolizaClienteDetalle['POLIZA']; ?></td>
                        	<td width="90"><? echo $rowPolizaClienteDetalle['FECHA_INI']."<br>".$rowPolizaClienteDetalle['FECHA_FIN']; ?></td>
                        	<td><? echo $rowPolizaClienteDetalle['SUBRAMO']; ?></td>
                        	<td><? echo $rowPolizaClienteDetalle['descripcion']; ?></td>
                        </tr>
                        <tr>
                        	<td colspan="5"><hr></td>
                        </tr>
                        <?
							}
						?>
                        <tr style="font-size:10px; ">
                        	<td>
                            	<?php
									$urlReenvioOtra = $_SERVER['PHP_SELF']."?Actividad=Endoso";
									$urlReenvioOtra.= "&buscadorPolizaCliente=".$buscadorPolizaCliente;
									$urlReenvioOtra.= "&usuarioCreacion=".$usuarioCreacion;
									$urlReenvioOtra.= "&idCliente=".$rowBusquedaPoliza['CLAVE_CLIENTE'];
									$urlReenvioOtra.= "&idPoliza=otra";
								?>
                            	<input
                                	type="radio" name="idPoliza" id="idPoliza"
                                    value="otra"
                                    <? echo ($idPoliza == "otra")? "checked" : ""; ?>
                                    onClick="selectCliente('<? echo $urlReenvioOtra; ?>');"
                                />
                            </td>
                        	<td colspan="4">
                            	<strong>Otra Poliza</strong>
                                <br>
								&Aacute;rea:
                                <select name="Ramo" id="Ramo" style="background-color:#FFFFFF;">
                                	<option value="">-- Seleccione --</option>
                                    <?
									$sqlRamosAreas = "
										Select * From 
											`ramosconfigdre` 
										Order By 
											`orden` Asc
													 ";
									$resRamosAreas = DreQueryDB($sqlRamosAreas);
									while($rowRamosAreas = mysql_fetch_assoc($resRamosAreas)){
									?>
                                    <option value="<? echo urlencode($rowRamosAreas['nombre']); ?>"><? echo $rowRamosAreas['nombre']; ?></option>
									<?php
									}
									?>
                                </select>
                                Poliza:
                                <input name="otraPoliza" id="otraPoliza" type="text" style="width:50%; background-color:#FFFFFF;"  />
                            </td>
                        </tr>
                        <tr>
                        	<td colspan="5"><hr></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <? 
				$contIntLi++;
				} 
			?>
        </table>
        <?php
			} else { 
			//--> echo "no hay resultados";
			echo "<center><strong>";
			echo "La Poliza/Cliente No fue encontrada, favor de ingresar una referencia.";
			echo "</strong></center>";
			echo "<br>"; 
		?>
        &Aacute;rea: 
        <select name="Ramo" id="Ramo">
        	<option value="">-- Seleccione --</option>
            <?
			$sqlRamosAreas = "
				Select * From 
					`ramosconfigdre` 
				Order By 
					`orden` Asc			
							 ";
			$resRamosAreas = DreQueryDB($sqlRamosAreas);
			while($rowRamosAreas = mysql_fetch_assoc($resRamosAreas)){
			?>
            <option value="<? echo urlencode($rowRamosAreas['nombre']); ?>"><? echo $rowRamosAreas['nombre']; ?></option>
            <?php
			}
			?>
        </select>
        <!-- New Cliente -->
        	<table cellpadding="1" cellspacing="2" align="center" border="0" >
				<tr>
	                <td align="left">Nombres / Raz&oacute;n Social:</td>
    	            <td colspan="4" align="left">
        	        	<input type="text" name="NOMBRES" id="NOMBRES" style="width:100%" />
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
				<tr>
                	<td align="right">RFC:</td>
                    <td colspan="2" align="left">
                    	<input type="text" name="RFC"  id="RFC" style="width:150px" />
					</td>
					<td align="right">CURP:</td>
					<td align="left">
                    	<input type="text" name="CURP" id="CURP" style="width:150px" />
                    </td>
				</tr>
                <tr>
                	<td colspan="5" align="left">
                    <!-- Tabla Elementos Varios -->
                    <table width="100%" cellpadding="2" cellspacing="2" border="0">
                    	<tr>
                        	<td rowspan="2" align="right">Tipo Persona:</td>
                            <td align="left">
                            	<input type="radio" name="TIPO_PERSONA" id="TIPO_PERSONA" value="F" checked="checked" />
                                Fisica
                            </td>
                            <td rowspan="2" align="right">Club Cap:</td>
                            <td align="left">
                            	<input name="Club_Cap" id="Club_Cap" type="radio" value="S" />
                                Si
							</td>
                            <td rowspan="2" align="right">Poliza Electronica:</td>
                            <td align="left">
                            	<input name="Poliza_Electronica" id="Poliza_Electronica" type="radio" value="S" />
                                Si
							</td>
						</tr>
						<tr>
							<td align="left">
								<input type="radio" name="TIPO_PERSONA" id="TIPO_PERSONA" value="M" />
	                            Moral
							</td>
							<td align="left">
    	                        <input name="Club_Cap" id="Club_Cap" type="radio" value="N" checked="checked" />
        	                    No
                            </td>
							<td align="left">
                            	<input name="Poliza_Electronica" id="Poliza_Electronica" type="radio" value="N" checked="checked" />
                                No
							</td>
	                    </tr>
                    </table>
                    <!-- Tabla Elementos Varios -->
                	</td>
				</tr>
				<tr>
					<td colspan="5" align="left"><hr /></td>
				</tr>    
				<tr>
					<td align="left">Calle:</td>
					<td colspan="4" align="left">
						<input type="text" name="CALLE" id="CALLE"  style="width:100%"/>
					</td>
				</tr>
				<tr>
					<td align="left">No. Ext:</td>
					<td colspan="2" align="left"><input type="text" name="NOEXTERIOR" id="NOEXTERIOR"  style="width:100%"/></td>
					<td align="right">No. Int:</td>
					<td align="left"><input type="text" name="NOINTERIOR" id="NOINTERIOR"  style="width:100%"/></td>
				</tr>
				<tr>
					<td align="left">Colonia:</td>
					<td colspan="2" align="left"><input type="text" name="COLONIA" id="COLONIA"  style="width:100%"/></td>
					<td align="right">CP:</td>
					<td align="left"><input type="text" name="CODIGO_POSTAL" id="CODIGO_POSTAL"  style="width:100%"/></td>
				</tr>
				<tr>
					<td align="left">Cruzamientos:</td>
					<td colspan="2" align="left"><input type="text" name="REFERENCIA" id="REFERENCIA"  style="width:44%"/> y <input  type="text" name="REFERENCIA2" id="REFERENCIA2"  style="width:44%"/></td>
					<td align="right">Tel Casa:</td>
					<td align="left"><input type="text" name="TELEFONO_PARTICULAR" id="TELEFONO_PARTICULAR"  style="width:100%"/></td>
				</tr>
				<tr>
					<td align="left">Localidad:</td>
					<td colspan="2" align="left"><input type="text" name="LOCALIDAD" id="LOCALIDAD" style="width:100%"/></td>
					<td align="right">Tel Trabajo:</td>
					<td align="left"><input type="text" name="TELEFONO_OFICINA" id="TELEFONO_OFICINA" style="width:100%"/></td>
				</tr>
				<tr>
					<td align="left">Municipio:</td>
					<td colspan="2" align="left"><input type="text" name="MUNICIPIO" id="MUNICIPIO" style="width:100%"/></td>
					<td align="right">Celular:</td>
					<td align="left"><input type="text" name="TELEFONO_MOVIL" id="TELEFONO_MOVIL" style="width:100%"/></td>
				</tr>
				<tr>
					<td align="left">Estado:</td>
					<td colspan="2" align="left">
						<select name="ESTADO" id="ESTADO" style="width:99%">
							<option>-- Seleccione --</option>
							<?php
								$sqlEstado = "
									Select * From 
										`estados`
									Order By
										`nombre_estado` Asc
											 ";
								$resEstado = DreQueryDB($sqlEstado);
								while($rowEstado = mysql_fetch_assoc($resEstado)){
							?>
	                    	<option value="<? echo $rowEstado['nombre_estado']; ?>" <? echo ($rowEstado['nombre_estado'] == "YUCATAN")? "selected":""; ?>><? echo $rowEstado['nombre_estado']; ?></option>
    		                <?
								}
							?>
						</select>
					</td>
					<td align="right">Email:</td>
					<td align="left"><input type="text" name="EMAIL" id="EMAIL" style="width:100s%"/></td>
				</tr>
				<tr>
					<td colspan="5"><hr /></td>
				</tr>
				<tr>
					<td align="left">Fecha Nacimiento:</td>
					<td align="left">
						<input type="text" name="FECHA_NACIMIENTO" id="FECHA_NACIMIENTO" readonly style="width:50%" />
						<img src="img/cal.gif" id="FECHA_NACIMIENTO_Btn"  title="Clic">
                        
					</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td align="left">Nacionalidad:</td>
					<td align="left"><input type="text" name="NACIONALIDAD" id="NACIONALIDAD" value="MEXICANA" style="width:50%" /></td>
					<td align="right">&nbsp;</td>
					<td align="right">&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td align="left">Nivel Estudios:</td>
					<td align="left">
                    	<select name="NIVEL_ESTUDIOS" id="NIVEL_ESTUDIOS" style=" width:99%">
							<option value="">-- Seleccione --</option>
							<?php
									$sqlEscolaridad = "Select * From `configdre` Where `parametro` = 'tipoEscolaridad'";
								$resEscolaridad = DreQueryDB($sqlEscolaridad);
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
						<select name="ESTADO_CIVIL" id="ESTADO_CIVIL" style=" width:99%">
							<option value="">-- Seleccione --</option>
							<?php
								$sqlEstadoCivil = "Select * From `configdre` Where `parametro` = 'tipoEstadoCivil'";
								$resEstadoCivil = DreQueryDB($sqlEstadoCivil);
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
					<td align="left"><input name="AUTOMOVIL" type="checkbox" id="AUTOMOVIL" value="Si" /></td>
					<td align="right">&nbsp;</td>
					<td align="right">Genero:</td>
					<td align="left">
						<select name="GENERO" id="GENERO" style=" width:99%">
							<option value="">-- Seleccione --</option>
							<?php
								$sqlGenero = "Select * From `configdre` Where `parametro` = 'tipoGenero'";
								$resGenero = DreQueryDB($sqlGenero);
								while($rowGenero = mysql_fetch_assoc($resGenero)){
							?>
							<option value="<?php echo $rowGenero['titulo']; ?>"><?php echo $rowGenero['titulo']; ?></option>
							<?php
								}
							?>
						</select>
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
									<select name="VENDEDOR" id="VENDEDOR" style="width:99%">
                                    	<option value="0000007979">G.A.P. AGENTE DE SEGUROS Y DE FIANZAS S.A. DE C.V.</option>
					<?
                                    	$resListadoVendedores = DreQueryDB($sqlListadoVendedores);
                                    	while($rowListadoVendedores = mysql_fetch_assoc($resListadoVendedores)){
					?>
                                    	<option value="<? echo $rowListadoVendedores['User']; ?>">
											<? echo $rowListadoVendedores['nombreVendedor']; ?>
                                    	</option>
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
								<select name="VENDEDOR" id="VENDEDOR" style="width:100%">
                                	
					<?
                                	$resListadoVendedores = DreQueryDB($sqlListadoVendedores);
									while($rowListadoVendedores = mysql_fetch_assoc($resListadoVendedores)){
					?>
										<option value="<? echo $rowListadoVendedores['User']; ?>" <? echo ($Usuario == $rowListadoVendedores['User'])? 'selected':''; ?>>
											<? echo $rowListadoVendedores['nombreVendedor']; ?>
										</option>
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
								<input type="text" value="<? echo $rowListadoVendedores['nombreVendedor']; ?>" size="<? echo $sizeText; ?>"/>
								<input type="hidden" name="VENDEDOR" id="VENDEDOR" value="<? echo $rowListadoVendedores['User']; ?>"/>
                    
					<?
							break;				
						}
					?>
	                </td>
				</tr>
				<tr>
	                <td colspan="5">
        				<hr />
						<input type="hidden" name="tipoCliente" id="tipoCliente" value="NEW" />
	                </td>
				</tr>
				<tr>
					<td colspan="5">
					Poliza: 
					<input type="text" name="Referencia" id="Referencia" style="width:90%;" />
					</td>
				</tr>
        	</table>
        <!-- New Cliente -->
        <?
			//-->
			} // fin del if Si hay o no hay resultados
		?>
        </td>
	</tr>
    <tr>
    	<td>
        <table width="95%" align="center" cellpadding="2" cellspacing="2" border="0">
       	  <tr><!-- style="background-image:url(img/fondoTablaDegradadoGris.png); color:#273B71; font-weight:bold;" -->
            	<td width="9"></td>
            <td>Campo a Cambiar</td>
            	<td>A Quedar en</td>
            </tr>
            <tr>
            	<td align="center">1</td>
           	  <td><input type="text" name="cambia1" id="cambia1" style="width:95%;" /></td>
            	<td><input type="text" name="queda1" id="queda1" style="width:95%;" /></td>
          </tr>
            <tr>
            	<td align="center">2</td>
           	  <td><input type="text" name="cambia2" id="cambia2" style="width:95%;" /></td>
            	<td><input type="text" name="queda2" id="queda2" style="width:95%;" /></td>
          </tr>
            <tr>
            	<td align="center">3</td>
           	  <td><input type="text" name="cambia3" id="cambia3" style="width:95%;" /></td>
            	<td><input type="text" name="queda3" id="queda3" style="width:95%;" /></td>
          </tr>
            <tr>
            	<td align="center">4</td>
           	  <td><input type="text" name="cambia4" id="cambia4" style="width:95%;" /></td>
            	<td><input type="text" name="queda4" id="queda4" style="width:95%;" /></td>
          </tr>
            <tr>
            	<td align="center">5</td>
           	  <td><input type="text" name="cambia5" id="cambia5" style="width:95%;" /></td>
            	<td><input type="text" name="queda5" id="queda5" style="width:95%;" /></td>            
		  </tr>    
		</table>
      </td>
    </tr>
<?
			} // fin del if si hay o no datos a buscar
?>
	<?
		if(isset($existePoliza)){
	?>
	<tr>
		<td colspan="2">
<!-- Multi Archivos -->
						<? require('expresImgRequisitos.php');?>
<!-- Multi Archivos -->
		</td>
	</tr>
    <tr>
		<td align="right">
			<input type="hidden" name="Actividad" id="Actividad" value="<?php echo $Actividad; ?>"/>
            <input type="hidden" name="IDUsuarioCreacion" id="IDUsuarioCreacion" value="<?php echo (isset($_POST['Usuario']) && $_POST['Usuario']!="")? $_POST['Usuario']:$Usuario; ?>"  />
			<input type="hidden" name="" id="" value="<? echo $Ramo; ?>" />
            
			<input type="button" value="Cancelar" onclick="java:window.open('actividades.php','_self');" class="buttonGeneral" />
        	<input type="button" value="Guardar Endoso" onclick="validacionAgregarEndoso('<? echo $existePoliza; ?>');" class="buttonGeneral"/>
        </td>
    </tr>
    <?
		}
    ?>
</form>