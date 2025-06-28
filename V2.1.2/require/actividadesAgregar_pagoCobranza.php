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

<form 
	name="formAgregarPagoCobranza" id="formAgregarPagoCobranza" 
    method="post" enctype="multipart/form-data" 
    action="includes/agregarActividades.php?tipoAgregar=Actividad"
>
	<input type="hidden" name="usuarioCreacion" id="usuarioCreacion" value="<?php echo $usuarioCreacion; ?>" />
    <tr>
		<td>
		<?php 
			if(isset($buscadorPolizaCliente) && $buscadorPolizaCliente != ""){
			$resBusquedaPoliza = DreQueryDB($sqlBusquedaPoliza); 
			$existePoliza = mysql_num_rows($resBusquedaPoliza);
				if($existePoliza > 0){ 
					//echo "si hay resultado";
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
								$urlReenvio = $_SERVER['PHP_SELF']."?Actividad=Pago+Cobranza";
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
									$urlReenvioOtra = $_SERVER['PHP_SELF']."?Actividad=Pago+Cobranza";
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
                                    <option value="<? echo urlencode($rowRamosAreas['nombre']); ?>" <? echo ($Ramo==urlencode($rowRamosAreas['nombre']))? "selected":""; ?>>
										<? echo $rowRamosAreas['nombre']; ?>
                                    </option>
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
								$urlReenvio_Result = $_SERVER['PHP_SELF']."?Actividad=Pago+Cobranza";
								$urlReenvio_Result.= "&buscadorPolizaCliente=".$buscadorPolizaCliente;
								$urlReenvio_Result.= "&usuarioCreacion=".$usuarioCreacion;
//								$urlReenvio_Result.= "&idCliente=";
//								$urlReenvio_Result.= "&tipoCliente=NEW";
								$urlReenvio_Result.= "&idPoliza=".$buscadorPolizaCliente;
								$urlReenvio_Result.= "&Ramo=";
								
					?>
			<table width="900" border="0">
                <tr>
                	<td width="200" align="right">&Aacute;rea:</td>
                    <td>
						<select 
                        	name="RamoSelect" id="RamoSelect" style="background-color:#FFFFFF;"
							onchange="selectCliente('<? echo $urlReenvio_Result; ?>'+ this.value);"
                        >
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
							<option value="<? echo urlencode($rowRamosAreas['nombre']); ?>" <? echo ($Ramo==urlencode($rowRamosAreas['nombre']))? "selected":""; ?>>
								<? echo $rowRamosAreas['nombre']; ?>
                            </option>
                            <?php
							}
							?>
						</select>
                    </td>
                </tr>
            	<tr>
                	<td width="200" align="right">No Poliza</td>
					<td>
                  		<input
                    		type="text" name="idPoliza" id="idPoliza"
							value="<? echo (isset($_REQUEST['buscadorPolizaCliente']))? $_REQUEST['buscadorPolizaCliente'] : "" ; ?>"
							style="width:50%"
    	                />
					</td>
				</tr>
                <tr>
                	<td>Nombre &oacute; Raz&oacute;n Social:</td>
                    <td>
                  		<input
                    		type="text" name="NOMBRES" id="NOMBRES"
							style="width:99%"
    	                />
                        <!--
                  		<input
                    		type="text" name="idCliente" id="idCliente"
							style="width:99%"
    	                />
                        -->
                    </td>
                </tr>
                <tr>
                	<td>Celular:</td>
                    <td>
                  		<input
                    		type="text" name="TELEFONO_MOVIL" id="TELEFONO_MOVIL"
							style="width:50%"
    	                />
                    </td>
                </tr>
                <tr>
                	<td>Email:</td>
                    <td>
                  		<input
                    		type="text" name="EMAIL" id="EMAIL"
							style="width:50%"
    	                />
                    </td>
                </tr>
			</table>
                    <?php
				} // fin del if Si hay o no hay resultados
		?>
        </td>
	</tr>
    <tr>
    	<td>
			<table width="900" border="0">
            	<tr>
                	<td width="200" align="right">Fecha de Pago</td>
					<td>
                    	<input 
                        	type="text" name="fechaPago" id="fechaPago"
                            style="width:90px" readonly  
                            value="<? echo date('Y-m-d'); ?>" 
                        />
						<img src="img/cal.gif" id="fechaPago_Btn"  title="Clic" />
                    </td>
                </tr>
            	<tr>
                	<td align="right">
<?
						if(!isset($idPoliza)){
							$importePoliza = $buscadorPolizaCliente;
						} else {
							$importePoliza = $idPoliza;
						}
						function importePago($idPoliza){
							$sqlConsulta_importePago = "
								Select * From
									`cobranzapendiente`
								Where
									`poliza` = '$idPoliza'
								Order By
									`inicio_vigencia` Asc
								Limit
									0,1
													   ";
							$resConsulta_importePago = DreQueryDB($sqlConsulta_importePago);
							$rowConsulta_importePago = mysql_fetch_assoc($resConsulta_importePago);
							
							if($rowConsulta_importePago['importe'] == ""){
								$importePago = "0.00";
							} else {
								$importePago = $rowConsulta_importePago['importe'];
							}
							return
								print($importePago);
						}
						
						function vigenciaPago($idPoliza){
							$sqlConsulta_importePago = "
								Select * From
									`cobranzapendiente`
								Where
									`poliza` = '$idPoliza'
								Order By
									`inicio_vigencia` Asc
								Limit
									0,1
													   ";
							$resConsulta_importePago = DreQueryDB($sqlConsulta_importePago);
							$rowConsulta_importePago = mysql_fetch_assoc($resConsulta_importePago);
							
							if($rowConsulta_importePago['importe'] == ""){
								$vigenciaPago = "";
							} else {
								$vigenciaPago = "Recibo ";
								$vigenciaPago.= "<strong>".$rowConsulta_importePago['Numero_Recibo']."</strong>";
								$vigenciaPago.= " Vigencia ";
								$vigenciaPago.= "<strong>".$rowConsulta_importePago['inicio_vigencia'];
								$vigenciaPago.= " al ";
								$vigenciaPago.= $rowConsulta_importePago['fin_vigencia']."</strong>";
							}
							return
								print($vigenciaPago);
						}
?>

                    </td>
                	<td style="font-style:italic;">
						<? vigenciaPago($importePoliza); ?>
                    </td>
            	<tr>
            	<tr>
                	<td align="right">Importe del Pago</td>
               	  <td>
                    <input
                    	type="text" name="importePago" id="importePago"
						style="width:25%" onKeyPress="return(currencyFormat(this,',','.',event))"
                        value="<? importePago($importePoliza); ?>"
                    />
                  </td>
                </tr>
            	<tr>
                	<td align="right">Moneda</td>
                	<td>
                    	<select
	                        name="moneda" id="moneda"
                        >
                        	<option value="MXN">MXN</option>
                        	<option value="USD">USD</option>
                        </select>
                    </td>
            	<tr>
                	<td align="right">Tipo de cambio</td>
               	  <td>
                  	<input 
                    	type="text" name="tipoCambio" id="tipoCambio"
                        value="1.00"
                  	/>
                  </td>
                </tr>
            </table>
        </td>
	</tr> 
	<tr>
    	<td colspan="2">
        	Comentario:
			<blockquote>
            <?php
				$tipo_toolbar = "Dre";
				$oFCKeditor = new FCKeditor('Referencia') ;
				$oFCKeditor->BasePath = 'fckeditor/' ;
				$oFCKeditor->ToolbarSet = preg_replace("/[^a-z]/i", "", $tipo_toolbar);
				//$oFCKeditor->Value = "";
				$oFCKeditor->Value = $txtFormulario;
				$oFCKeditor->Create();              
			?>
			</blockquote>
        </td>
    </tr>       
        <?php
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
		<td colspan="2" align="right">
			<input type="hidden" name="Actividad" id="Actividad" value="<?php echo $Actividad; ?>"/>
			<input type="hidden" name="Ramo" id="Ramo" value="<?php echo $Ramo; ?>" />
			<input type="hidden" name="SubRamo" id="SubRamo" value="<?php echo $SubRamo; ?>" /><!-- -->
			<input type="hidden" name="tipoCliente" id="tipoCliente" value="<? echo ($existePoliza=="0")? "NEW":""; ?>"/>
			<input type="hidden" name="TIPO" id="TIPO" value="CONTACTO1"/>
			<input type="hidden" name="idRef" id="idRef" value="0000014025"/>
            <input type="hidden" name="IDUsuarioCreacion" id="IDUsuarioCreacion" value="<?php echo (isset($_POST['Usuario']) && $_POST['Usuario']!="")? $_POST['Usuario']:$Usuario; ?>"  />
            
			<input type="button" value="Cancelar" onclick="java:window.open('actividades.php','_self');" class="buttonGeneral" />
        	<input type="button" value="Guardar Pago Cobranza" onclick="validacionAgregarPagoCobranza('<? echo $existePoliza; ?>');" class="buttonGeneral"/>
            <!-- JavaScript: document.formAgregarPagoCobranza.submit(); -->
			&nbsp;&nbsp;&nbsp;&nbsp;
        </td>
    </tr>
    <?
		}
    ?>
</form>
<script type="text/javascript">
	Calendar.setup({
		inputField : "fechaPago",
		trigger    : "fechaPago_Btn",
		onSelect   : function() { this.hide() },
		dateFormat : "%Y-%m-%d"
	});
</script>