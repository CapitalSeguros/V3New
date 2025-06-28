						<table width="900" cellpadding="2" cellspacing="1" border="0">
                            <?
								$sqlConsulta_tarjetas = "
									Select
										*
										, SUBSTRING(`NUMERO_TARJETA` From 13) As `NUMERO_TARJETA`
										, DATE_FORMAT(`EXPIRA`,'%y%m') As `EXPIRA`
										,if(`TIPO` = 'C', 'Credito', 'Debito') As `TIPO`
									From
										`clientes_tarjeta`
									Where
										`CLAVE_CLIENTE` = '$idRefCliente'
														";
								$resConsulta_tarjetas = DreQueryDB($sqlConsulta_tarjetas);
								$contIntLi = "0";
								while($rowConsulta_tarjetas = mysql_fetch_assoc($resConsulta_tarjetas)){
							?>
                        	<tr style="font-size:10px; text-align:justify;"  bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>">
                            	<td><input type="radio" name="idClienteTarjeta" id="idClienteTarjeta"  <? echo ($rowConsulta_tarjetas['idClienteTarjeta'] == $idClienteTarjeta)? "checked" : "";?>/></td>
                            	<td><? echo $rowConsulta_tarjetas['NOMBRE_TITULAR']; ?></td>
                            	<td><? echo "************".$rowConsulta_tarjetas['NUMERO_TARJETA']; ?></td>
                            	<td><? echo $rowConsulta_tarjetas['EXPIRA']; ?></td>
                            	<td><? echo $rowConsulta_tarjetas['TIPO']; ?></td>
                            	<td><? echo $rowConsulta_tarjetas['BANCO']; ?></td>
                            	<td>****</td>
                            </tr>
                            <?
									$contIntLi++;
								}
							?>
<form name="formAgregarTarjeta" id="formAgregarTarjeta" method="post" action="includes/agregarTarjeta.php?tipoTarjeta=general">
                        	<tr>
                            	<td width="10"></td>
                            	<td width="440">Titular Tarjeta</td>
                            	<td width="150">Numero Tarjeta</td>
                            	<td width="50">Expira</td>
                            	<td width="50">Tipo</td>
                            	<td width="200">Banco</td>
                            	<td width="50">Dig. Verif.</td>
                            </tr>
                        	<tr>
                            	<td></td>
                            	<td>
                                	<input type="text" name="NOMBRE_TITULAR" id="NOMBRE_TITULAR" size="40" />
                                </td>
                            	<td>
                                	<input type="text" name="NUMERO_TARJETA" id="NUMERO_TARJETA" size="16" />
                                </td>
                            	<td>
                                	<input type="text" name="EXPIRA" id="EXPIRA" size="4"/>
                                </td>
                            	<td>
                                    <select name="TIPO" id="TIPO">
                                    	<option value="">--</option>
                                    	<option value="C">Credito</option>
                                    	<option value="D">Debito</option>
                                    </select>
                                </td>
                            	<td>
                                	<input type="text" name="BANCO" id="BANCO" size="30" />
                                </td>
                            	<td>
                                	<input type="text" name="CODIGO_SEGURIDAD" id="CODIGO_SEGURIDAD" size="4" />
                                </td>
                            </tr>
                        	<tr>
                            	<td colspan="7" align="right">
			<input type="hidden" name="idRefCliente" id="idRefCliente" value="<?php echo $idRefCliente ?>" />
		    <input type="hidden" name="usuarioCreacion" id="usuarioCreacion" value="<?php echo $usuarioCreacion; ?>"  />
			<input type="hidden" name="Actividad" id="Actividad" value="<?php echo $Actividad; ?>" />
			<input type="hidden" name="Ramo" id="Ramo" value="<?php echo $Ramo; ?>" />
			<input type="hidden" name="SubRamo" id="SubRamo" value="<?php echo $SubRamo; ?>" /><!-- -->
			<input type="hidden" name="tipoCliente" id="tipoCliente" value="<?php echo $tipoCliente; ?>" />
            
			<input type="hidden" name="condicionesPago" id="condicionesPago" value="<?php echo (!isset($condicionesPago))? "contado" : $condicionesPago; ?>" />
			<input type="hidden" name="conductoCobro" id="conductoCobro" value="<?php echo (!isset($conductoCobro))? "agente" : $conductoCobro; ?>" />

            
    
									<input type="button" value="Agregar Tarjeta" onclick="ValidarAgregarTarjeta()" class="buttonGeneral" />
									&nbsp;&nbsp;&nbsp;&nbsp;
                                </td>
                            </tr>
                        </table>
</form>