<?php
	$sqlCalculamosIdSubRamo = "
		Select * From
			`catalogo_ramo_subramo`	
		Where
			`subRamo` = '".$SubRamo."'
							  ";
	$resCalculamosIdSubRamo = DreQueryDB($sqlCalculamosIdSubRamo);
	$rowCalculamosIdSubRamo = mysql_fetch_assoc($resCalculamosIdSubRamo);
	$idSubRamo = $rowCalculamosIdSubRamo['clave'];
?>
<script>
	function envioFormulario(SubRamo, otraPoliza, ClienteId){
		
		var f = document.formBuscaPolizaDiligencia;
		var idPoliza = f.idPoliza.value;
//		var ClienteId = f.ClienteId.value;

		var POLIZA = f.POLIZA.value;
		var CLIENTE = f.CLIENTE.value;
		var SUBRAMO = f.SUBRAMO.value;
		
		f.CLIENTE.value = ClienteId; // Cambio de valor
		if(otraPoliza == ""){
			f.POLIZA.value = idPoliza; // Cambio de valor
		} else {
			f.POLIZA.value = otraPoliza; // Cambio de valor
		}
		f.SUBRAMO.value = SubRamo; // Cambio de valor
		
		//** alert('Enviamos');
		f.submit();
	}
	
</script>
<form name="formBuscaPolizaDiligencia" id="formBuscaPolizaDiligencia" method="get" action="<? echo $_SERVER['PHP_SELF']; ?>">
        <table width="95%" align="center" cellpadding="2" cellspacing="2" border="0">
        	<tr style="background-image:url(img/fondoTablaDegradadoGris.png); color:#273B71; font-weight:bold;">
            	<td colspan="2">Cliente</td>
                <td>&nbsp;</td>
            </tr>
            <? 
				$contIntLi = 0;
				while($rowBusquedaPoliza = mysql_fetch_assoc($resBusquedaPolizaDiligencia)){ 
			?>
        	<tr style="font-size:10px; " bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>">
            	<td width="9" align="center">
                <input type="radio" name="idCliente" id="idCliente" value="<? echo $rowBusquedaPoliza['CLAVE_CLIENTE']; ?>" <? echo ($existePoliza == 1)? "checked":""; ?> />
                </td>
            	<td width="150"><? echo DreNombreCliente($rowBusquedaPoliza['CLAVE_CLIENTE']); ?></td>
                <td>
					<input
                    	type="hidden" name="ClienteId" id="ClienteId"
                        value="<? echo $rowBusquedaPoliza['CLAVE']; ?>"
					/>
                	<table width="100%" align="center" cellpadding="2" cellspacing="2" border="0">
                    	<tr style="font-size:10px; " bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>">
							<td colspan="2">Poliza</td>
							<td>Vigencia</td>
							<td>SubRamo</td>
							<td>Descripcion</td>
                        </tr>
                        <?
						$sqlVerificaPolClienteDetalle = "Select * From `cliramos` Where `POLIZA` Like '%$buscaPolCli%'";
						//** echo "<pre>".$sqlVerificaPolClienteDetalle."</pre>";
						if(mysql_num_rows(DreQueryDB($sqlVerificaPolClienteDetalle)) != 0){	
							$sqlPolizaClienteDetalle = "
								Select * From 
									`cliramos`
								Where
									`POLIZA` Like '%$buscaPolCli%'
									And
									(
										`RAMO` Like '%".strtoupper(urldecode($Ramo))."%'
										And
										`SUBRAMO` Like '%".strtoupper(urldecode($SubRamo))."%'
									)
									And
									(
										DATE_FORMAT(`FECHA_INI`, '%Y') = DATE_FORMAT(curdate(), '%Y')
										Or
										DATE_FORMAT(`FECHA_FIN`, '%Y') = DATE_FORMAT(curdate(), '%Y')
									)
													   ";
						} else {
							$sqlPolizaClienteDetalle = "
								Select * From 
									`cliramos`
								Where
									`CLAVE_CLIENTE` = '$rowBusquedaPoliza[CLAVE]'
									And
									(
										`RAMO` Like '%".strtoupper(urldecode($Ramo))."%'
										And
										`SUBRAMO` Like '%".strtoupper(urldecode($SubRamo))."%'
									)
									And
									(
										DATE_FORMAT(`FECHA_INI`, '%Y') = DATE_FORMAT(curdate(), '%Y')
										Or
										DATE_FORMAT(`FECHA_FIN`, '%Y') = DATE_FORMAT(curdate(), '%Y')
									)
													   ";
						}
							//**echo "<pre>".$sqlPolizaClienteDetalle."</pre>";
							$resPolizaClienteDetalle = DreQueryDB($sqlPolizaClienteDetalle);
							while($rowPolizaClienteDetalle = mysql_fetch_assoc($resPolizaClienteDetalle)){
						?>
                    	<tr style="font-size:8px; ">
                        	<td width="9">
                            	<input
	                                type="radio" name="idPoliza" id="idPoliza"
									<? echo ($rowPolizaClienteDetalle['POLIZA'] == $buscadorPolizaCliente)? "checked" : ""; ?>
                                    value="<? echo $rowPolizaClienteDetalle['POLIZA']; ?>"
                                    onClick="envioFormulario('<? echo $rowPolizaClienteDetalle['SUBRAMO_ID'];  ?>', '', '<? echo $rowBusquedaPoliza['CLAVE']; ?>');"
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
<!--
                        	<td>
                            	<input
                                	type="radio" name="idPoliza" id="idPoliza" 
                                    value="otra" 
                                    onClick="envioFormulario('<? echo $idSubRamo; ?>');"
                                />
                            </td>
-->
                        	<td colspan="5">
                            	<strong>Otra Poliza</strong>
                                <br>
                                Poliza:
                                <input 
                                	type="text" name="otraPoliza" id="otraPoliza" 
                                	style="width:50%; background-color:#FFFFFF;"
                                    onChange="envioFormulario('<? echo $idSubRamo; ?>', this.value, '<? echo $rowBusquedaPoliza['CLAVE']; ?>');"
                                />
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
        	<tr align="right">
            	<td colspan="3">
                	<input type="hidden" name="POLIZA" id="POLIZA" value="" />
					<!-- <input type="" name="POLIZA_RENOVACION" id="POLIZA_RENOVACION" value="" /> -->
                	<input type="hidden" name="CLIENTE" id="CLIENTE" value="" />
                	<input type="hidden" name="SUBRAMO" id="SUBRAMO" value="" />
                	<input type="hidden" name="Actividad" id="Actividad" value="Diligencias" />
                	<input type="hidden" name="usuarioCreacion" id="usuarioCreacion" value="<?php echo $usuarioCreacion; ?>" />
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                </td>
            </tr>
        </table>
</form>
<?php
	//echo "<pre>";
		//echo "Buscador Poliza !!!";
		//echo $sqlBusquedaPolizaDiligencia;
		//echo $sqlCalculamosIdSubRamo;
	//echo "</pre>";
?>