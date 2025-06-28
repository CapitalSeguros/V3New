<?php
if(
	(
		$Ramo == "L%EDneas+Personales"
		&&
		(
			isset($SubRamo)
			&&
			$SubRamo != ""
		)
		&& 
		(
			!isset($buscadorPolizaCliente)
		)
	)
	||
	(
		$Ramo == "Da%F1os"
		&&
		(
			isset($SubRamo)
			&&
			$SubRamo != ""
		)
		&& 
		(
			!isset($buscadorPolizaCliente)
		)
	)
	||
	(
		$Ramo == "Autos+Individuales"
		||	
		$Ramo == "Fianzas"
		||
		$Ramo == "Flotillas"
	)
	&&
	(
		!isset($POLIZA_RENOVACION)
	)
	&& 
	(
		!isset($buscadorPolizaCliente)
	)
	&&
	(
		!isset($CLIENTE)
	)
){
?>
<form name="formBuscarPolDili" id="formBuscarPolDili" method="post" action="">
	<input type="hidden" name="usuarioCreacion" id="usuarioCreacion" value="<?php echo $usuarioCreacion; ?>" />
    <tr align="left">
    	<td colspan="2">
            Buscar Poliza/Cliente:
			<input type="text" name="buscadorPolizaCliente" id="buscadorPolizaCliente" style="width:72%" value="<? echo (isset($_REQUEST['buscadorPolizaCliente']))? $_REQUEST['buscadorPolizaCliente'] : "" ; ?>"/><!-- value="<? echo $buscaPolCli; ?>"  /> -->
			<input type="hidden" name="usuarioCreacion" id="usuarioCreacion" value="<?php echo $usuarioCreacion; ?>" />
			<input type="hidden" name="Actividad" id="Actividad" value="<?php echo $Actividad; ?>" />
			<input type="hidden" name="Ramo" id="Ramo" value="<?php echo $Ramo; ?>" />
			<input type="hidden" name="SubRamo" id="SubRamo" value="<?php echo $SubRamo; ?>" />
			<?
				if($tipoCliente != ""){
			?>
			<input type="hidden" name="tipoCliente" id="tipoCliente" value="<?php echo $tipoCliente; ?>" />
			<?
				}
			?>    
            <input type="submit" name="button" id="button" value="Buscar" class="buttonGeneral"/>
         </td>
    </tr>
</form>
<?
}
?>

<?php
	if(isset($buscadorPolizaCliente) && $buscadorPolizaCliente != ""){
		$resBusquedaPolizaDiligencia = DreQueryDB($sqlBusquedaPolizaDiligencia); 
		$existePoliza = mysql_num_rows($resBusquedaPolizaDiligencia);
		if($existePoliza > 0){
?>
	<tr>
         <td colspan="2">
         	<?
				require('actividadesAgregar_actividadDiligencias_buscadorPolizas.php'); 
			?>
         </td>
    </tr>
<?php
		} else {
?>
	<tr>
         <td colspan="2" align="center">
         	<font style="font-size:14px; color:#F00; font-weight:bold; text-align:center;">
				P&oacute;liza  o Cliente No Encontrada !!!
			</font>
         </td>
    </tr>
<?php
		}
?>
<?php
	}
?>

<?php
if(
	$Actividad == "Diligencias"
	&&
	(
	$idRefCliente != ""
	||
	$idRefProspecto != ""
	)
){
?>
<form name="formAgregarDiligencias" id="formAgregarDiligencias" method="post" enctype="multipart/form-data" action="includes/agregarActividades.php?tipoAgregar=Actividad">
	<input type="hidden" name="usuarioCreacion" id="usuarioCreacion" value="<?php echo $usuarioCreacion; ?>" />
    <tr>
		<td>
		<!-- -->
		<table width="950" align="center" cellpadding="2" cellspacing="2" border="0">
			<tr>
				<td colspan="2">&nbsp;
                		
                </td>
            </tr>
			<tr valign="top">
				<td align="right">
					A Quien se le Entrega:
				</td>
                <td align="right">
					<?php
$sqlMaxContacto = "
	Select Count(`TIPO`) As `maxContacto` From 
		`contactos` 
	Where 
		`CLAVE` = '".$_REQUEST['CLIENTE']."'
				  ";
$resMaxContacto = DreQueryDB($sqlMaxContacto);
$numeroContacto = mysql_result($resMaxContacto,0) + 1;

						$urlAgregarContacto = $_SERVER['PHP_SELF']; //"actividadesAgregar.php"; //$_SERVER['PHP_SELF'];
						$urlAgregarContacto.= "?POLIZA=".$POLIZA;
						$urlAgregarContacto.= "&POLIZA_RENOVACION=".$POLIZA_RENOVACION;
						$urlAgregarContacto.= "&CLIENTE=".$CLIENTE;
						$urlAgregarContacto.= "&SUBRAMO=".$SUBRAMO;
						$urlAgregarContacto.= "&Actividad=".$Actividad;
						$urlAgregarContacto.= "&usuarioCreacion=".$usuarioCreacion;
						$urlAgregarContacto.= "&agregar=CONTACTO".$numeroContacto;
						$urlAgregarContacto.= "&muestra=Contactos";
						$urlAgregarContacto.= "#agregar";
						
						$urlCancelarContacto = $_SERVER['PHP_SELF']; //"actividadesAgregar.php"; //$_SERVER['PHP_SELF'];
						$urlCancelarContacto.= "?POLIZA=".$POLIZA;
						$urlCancelarContacto.= "&POLIZA_RENOVACION=".$POLIZA_RENOVACION;
						$urlCancelarContacto.= "&CLIENTE=".$CLIENTE;
						$urlCancelarContacto.= "&SUBRAMO=".$SUBRAMO;
						$urlCancelarContacto.= "&Actividad=".$Actividad;
						$urlCancelarContacto.= "&usuarioCreacion=".$usuarioCreacion;

					?>                
					<a href="<? echo $urlAgregarContacto; ?>" title="Agregar Contacto"><img src="img/transparente.fw.png" class="system agregar" alt="agregar" border="0"/></a>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </td>
			</tr>
			<tr valign="top">
				<td colspan="2">

					<table width="950" cellpadding="2" cellspacing="0" border="0">
                    	<tr>
                        	<td width="95"></td>
                        	<td width="100"></td>
                        	<td width="750"></td>
                        </tr>
<?php
if(isset($agregar) && $agregar != ""){
	$newContacto = "CONTACTO".$numeroContacto;
?>
						<tr>
							<td rowspan="4" align="right" valign="middle">
                            	<input 
                                	type="radio" name="tipoContacto" id="tipoContacto"
                                    <? echo ($newContacto == $agregar)? "checked" : "";?>
                                    value="NewContacto"
                                />
                                <input
                                	type="hidden"
                                    name="tipoContactoNew" id="tipoContactoNew"
                                    value="<? echo $agregar; ?>"
                                />
                            </td>
							<td align="right">
								Nombre:
							</td>
							<td align="left">
                           	  <input
								type="text" style="width:95%"
                                name="NombreContactoNew" id="NombreContactoNew"
                           	  />
                              <input 
								type="button" class="systemCancelar" title="Cancelar"
                                onClick="java:window.open('<?php echo $urlCancelarContacto; ?>','_self');"
                              />
                            </td>
						</tr>
						<tr>
							<td align="right">
								Direccion:
							</td>
							<td align="left">
                           	  <input
                                type="text" style="width:95%"
								name="DireccionContactoNew" id="DireccionContactoNew"
                           	  />
                            </td>
						</tr>
						<tr>
							<td align="right">Telefono:</td>
							<td align="left">
								<input
                                	type="text" style="width:95%"
									name="TelefonoContactoNew" id="TelefonoContactoNew"
								/>
							</td>
						</tr>
						<tr>
							<td align="right">Email:</td>
							<td align="left">
								<input
                                	type="text" style="width:95%"
									name="EmailContactoNew" id="EmailContactoNew"
								/>
                            </td>
						</tr>
                    	<tr>
                      		<td colspan="3">
                        		<hr>
							</td>
						</tr>
<?php
}
?>
<?php
	$sqlContactosClienteDiligencia = "
		Select * From 
			`contactos`
		Where
			`CLAVE` = '".$_REQUEST['CLIENTE']."'
									 ";
	$resContactosClienteDiligencia = DreQueryDB($sqlContactosClienteDiligencia);
	$contIntLi = 0;
	while($rowContactosClienteDiligencia = mysql_fetch_assoc($resContactosClienteDiligencia)){
		//echo $rowContactosClienteDiligencia['CLAVE'];
?>
						<tr>
							<td rowspan="4" align="right" valign="middle" >
                            	<input 
                                	type="radio" name="tipoContacto" id="tipoContacto"
                                    <? echo (($rowContactosClienteDiligencia['TIPO'] == "CONTACTO1") && (!isset($agregar) && $agregar == ""))? "checked" : "";?>
									value="<? echo $rowContactosClienteDiligencia['TIPO']; ?>"
                                />                            
							</td>
							<td align="right">
                            	Nombre:
							</td>
							<td>
								<input 
                                	type="text" style="width:95%"
									value="<? echo DreNombreClienteContacto($rowContactosClienteDiligencia['CLAVE'],$rowContactosClienteDiligencia['TIPO']); ?>"
    	                       	  	name="NombreContacto" id="NombreContacto"
								/>
							</td>
						</tr>
                    	<tr>
							<td width="80" align="right">
                            	Direccion:
                            </td>
                        	<td width="600">
								<input 
                                	type="text" style="width:95%"
									value="<? echo DreDireccionClienteContacto($rowContactosClienteDiligencia['CLAVE'],$rowContactosClienteDiligencia['TIPO']); ?>"
	                           	  	name="DireccionContacto" id="DireccionContacto"
                                />
							</td>
                    	</tr>
                    	<tr>
							<td align="right">Telefono:</td>
							<td>
                            	<input 
                                	type="text" style="width:95%"
									value="<? echo DreTelefonoClienteContacto($rowContactosClienteDiligencia['CLAVE'],$rowContactosClienteDiligencia['TIPO']); ?>"
	                           	  	name="TelefonoContacto" id="TelefonoContacto"
                                />
							</td>
						</tr>
                    	<tr>
                    		<td align="right">Email:</td>
							<td>
                            	<input 
                                	type="text" style="width:95%"
									value="<? echo DreEmailClienteContacto($rowContactosClienteDiligencia['CLAVE'],$rowContactosClienteDiligencia['TIPO']); ?>"
	                           	  	name="EmailContacto" id="EmailContacto"
                                />
							</td>
						</tr>
                    	<tr>
                      		<td colspan="3">
                        		<hr>
							</td>
						</tr>
<?php
		$contIntLi++;
	}
?>
                    </table>
              </td>
           	</tr>
        	<tr valign="top">
				<td width="200" align="right">
					Motivo:
                </td>
            	<td width="750">
<?php
	if(isset($_GET['POLIZA'])){
		$VALOR = $_GET['POLIZA'];
	} else if(isset($_GET['POLIZA_RENOVACION'])){
		$VALOR = $_GET['POLIZA_RENOVACION'];
}
?>

					<input
                    	name="motivo" id="motivo"
                    	type="text" style="width:99%;"
                        value="<? echo "Poliza ".$VALOR; ?>"
                    />
                </td>
			</tr>
        	<tr valign="top">
                <td align="right">
					Observaciones:
                </td>
            	<td>
							<?php
								$tipo_toolbar = "Dre";
								$oFCKeditor = new FCKeditor('Referencia') ;
								$oFCKeditor->BasePath = 'fckeditor/' ;
								$oFCKeditor->ToolbarSet = preg_replace("/[^a-z]/i", "", $tipo_toolbar);
								// $oFCKeditor->Value = "";
								$oFCKeditor->Value = $txtFormulario;
								$oFCKeditor->Create();
							?>
                </td>
			</tr>
        </table>
		<!-- -->
        </td>
	</tr>
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
			<input type="hidden" name="Ramo" id="Ramo" value="<?php echo $Ramo; ?>" />
			<input type="hidden" name="SubRamo" id="SubRamo" value="<?php echo $SubRamo; ?>" /><!-- -->
			<!-- <input type="hidden" name="tipoCliente" id="tipoCliente" value="<?php //echo $tipoCliente; ?>"/> -->
			<!-- <input type="hidden" name="TIPO" id="TIPO" value="CONTACTO1"/> -->
			<input type="hidden" name="SubRamo" id="SubRamo" value="<? echo $SubRamoLocal; ?>"/>
			<input type="hidden" name="idRef" id="idRef" value="<? echo $CLIENTE; ?>"/>
            <input type="hidden" name="IDUsuarioCreacion" id="IDUsuarioCreacion" value="<?php echo (isset($_POST['Usuario']) && $_POST['Usuario']!="")? $_POST['Usuario']:$Usuario; ?>"  />
            
			<input type="button" value="Cancelar" onclick="java:window.open('actividades.php','_self');" class="buttonGeneral" />
        	<input type="button" value="Guardar Diligencia" onclick="JavaScript: document.formAgregarDiligencias.submit();" class="buttonGeneral"/>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </td>
    </tr>
</form>
<?php
}
?>