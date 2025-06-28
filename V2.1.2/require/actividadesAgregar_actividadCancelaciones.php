<form name="formBuscarPolCli" id="formBuscarPolCli" method="post" action="<? echo $_SERVER['PHP_SELF']; ?>">
	<input type="hidden" name="usuarioCreacion" id="usuarioCreacion" value="<?php echo $usuarioCreacion; ?>" />
    <tr>
    	<td colspan="2">
            Buscar Poliza/Cliente:
            <input type="text" name="buscadorPolizaCliente" id="buscadorPolizaCliente" style="width:73%" value="<? echo (isset($_REQUEST['buscadorPolizaCliente']))? $_REQUEST['buscadorPolizaCliente'] : "" ; ?>"/><!-- value="<? echo $buscaPolCli; ?>"  /> -->
            <input type="submit" name="button" id="button" value="Buscar" class="buttonGeneral"/> <!-- onClick="BuscarPolCli(document.formAgregarEndoso.buscadorPolizaCliente.value);"   -->
            <input type="hidden" name="Actividad" id="Actividad" value="<?php echo $Actividad?>" />
         </td>
    </tr>
</form>
<script>
	function calculosAdicionales(SubRamo, Ramo, ClienteId){
		var f = document.formAgregarCancelacion;
		//** var idPoliza = f.idPoliza.value;
		
//** idCliente
		f.CLIENTE.value = ClienteId; // Cambio de valor		
		f.SUBRAMO.value = SubRamo; // Cambio de valor
		f.RAMO.value = Ramo; // Cambio de valor
		
		//** alert('PasamosDatos');
	}
</script>
<form name="formAgregarCancelacion" id="formAgregarCancelacion" method="post" enctype="multipart/form-data" action="includes/agregarActividades.php?tipoAgregar=Actividad">
	<input type="hidden" name="usuarioCreacion" id="usuarioCreacion" value="<?php echo $usuarioCreacion; ?>" />
    <tr>
    	<td colspan="2">
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
				$RAMO = $rowBusquedaPoliza['RAMO'];
				$SUBRAMO = $rowBusquedaPoliza['SUBRAMO'];
//				echo "<pre>"; print_r($rowBusquedaPoliza); echo "</pre>";
			?>
        	<tr style="font-size:10px; " bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>">
            	<td width="9" align="center">
                <!-- <input type="radio" name="idPoliza" id="idPoliza" value="<? echo $rowBusquedaPoliza['POLIZA']; ?>" <? echo ($existePoliza == 1)? "checked":""; ?> /> -->
                <input type="radio" name="idCliente" id="idCliente" value="<? echo $rowBusquedaPoliza['CLAVE_CLIENTE']; ?>" <? echo ($existePoliza == 1)? "checked":""; ?> />
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
						?>
                    	<tr style="font-size:8px; ">
                        	<td width="9">
                            	<input 
                                	type="radio" name="idPoliza" id="idPoliza"
									<? echo ($rowPolizaClienteDetalle['POLIZA'] == $buscadorPolizaCliente)? "checked" : ""; ?>  
                                    value="<? echo $rowPolizaClienteDetalle['POLIZA']; ?>" 
                                    onClick="calculosAdicionales('<? echo $rowPolizaClienteDetalle['SUBRAMO'];  ?>', '<? echo $rowPolizaClienteDetalle['RAMO'];  ?>', '<? echo $rowBusquedaPoliza['CLAVE']; ?>');"
                                />
                            </td>
                        	<td width="100" style="font-size:8px;"><? echo $rowPolizaClienteDetalle['POLIZA']; ?></td>
                        	<td width="90"><? echo $rowPolizaClienteDetalle['FECHA_INI']."<br>".$rowPolizaClienteDetalle['FECHA_FIN']; ?></td>
                        	<td><? echo $rowPolizaClienteDetalle['SUBRAMO']; ?></td>
                        	<td><? echo $rowPolizaClienteDetalle['descripcion']; ?></td>
                        </tr>
                        <?
							}
						?>
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
        </td>
	</tr>
    <tr>
    	<td colspan="2">
			<br>
			Motivo Cancelaci&oacute;n:
            <select name="motivoCancelacion" id="motivoCancelacion">
            	<option value="">-- Seleccione --</option>
                <?
					$sqlMotivoCancelacion = "
						Select * From
							`tiposcancelacion`
											";
					$resMotivoCancelacion = DreQueryDB($sqlMotivoCancelacion);
					while($rowMotivoCancelacion = mysql_fetch_assoc($resMotivoCancelacion)){
				?>
                <option value="<? echo $rowMotivoCancelacion['DESCRIPCION']; ?>"><? echo $rowMotivoCancelacion['DESCRIPCION']; ?></option>
                <?
					}
				?>
            </select>            
		</td>
	</tr>
    <tr>
    	<td colspan="2">
		Comentario de Cancelaci&oacute;n:
        <?php
				$tipo_toolbar = "Dre";
				$oFCKeditor = new FCKeditor('Comentario') ;
				$oFCKeditor->BasePath = 'fckeditor/' ;
				$oFCKeditor->ToolbarSet = preg_replace("/[^a-z]/i", "", $tipo_toolbar);
				$oFCKeditor->Value = "";
				$oFCKeditor->Create();              
		?>
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
    	<td colspan="2" align="right">
			<input type="hidden" name="Actividad" id="Actividad" value="<?php echo $Actividad; ?>"/>
<!-- 			<input type="hidden" name="idRef" id="idRef" value="0000014025"/> -->
            <input type="hidden" name="IDUsuarioCreacion" id="IDUsuarioCreacion" value="<?php echo (isset($_POST['Usuario']) && $_POST['Usuario']!="")? $_POST['Usuario']:$Usuario; ?>"  />
			<input type="hidden" name="RAMO" id="RAMO" value="<? echo $RAMO; ?>" />
			<input type="hidden" name="SUBRAMO" id="SUBRAMO" value="<? echo $SUBRAMO; ?>" />
			<input type="hidden" name="CLIENTE" id="CLIENTE" value="" />
			
			<input type="button" value="Cancelar" onclick="java:window.open('actividades.php','_self');" class="buttonGeneral" />
        	<input type="button" value="Guardar Cancelaci&oacute;n" onclick="validacionAgregarCancelacion('<? echo $existePoliza; ?>');" class="buttonGeneral"/>
			&nbsp;&nbsp;&nbsp;&nbsp;
        </td>
    </tr>
        <?php
			} else { //--> echo "no hay resultados";
		?>
	<tr>
    	<td colspan="2" align="right">
        	<strong>
            	<center>
					La Poliza/Cliente No fue encontrada.
                    <br><br>
                </center>
            </strong>
			<input type="button" value="Cancelar" onclick="java:window.open('actividades.php','_self');" class="buttonGeneral" />
			&nbsp;&nbsp;&nbsp;&nbsp;
        </td>
	</tr>
        <?php
			} // fin del if Si hay o no hay resultados

			} // fin del if si hay o no datos a buscar
?>
</form>