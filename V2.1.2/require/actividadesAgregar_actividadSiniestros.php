<form name="formBuscarPolSini" id="formBuscarPolSini" method="post" action="">
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
<form name="formAgregarSiniestro" id="formAgregarSiniestro" method="post" enctype="multipart/form-data" action="includes/agregarActividades.php?tipoAgregar=Actividad">
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
			?>
        	<tr style="font-size:10px; " bgcolor="<? echo($contIntLi%2==0)?"#B6C6D7":"#DFDFDF"; ?>">
            	<td width="9" align="center">
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
                        	<td width="9"><input type="radio" name="idPoliza" id="idPoliza" value="<? echo $rowPolizaClienteDetalle['POLIZA']; ?>" <? echo ($rowPolizaClienteDetalle['POLIZA'] == $buscadorPolizaCliente)? "checked" : ""; ?>  /></td>
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
                        	<td><input type="radio" name="idPoliza" id="idPoliza" value="otra"  /></td>
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
        &Aacute;rea Poliza: 
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
        <?php
			echo "<br>";
        	echo "Referencia Poliza:";
				$tipo_toolbar = "Dre";
				$oFCKeditor = new FCKeditor('ReferenciaPol') ;
				$oFCKeditor->BasePath = 'fckeditor/' ;
				$oFCKeditor->ToolbarSet = preg_replace("/[^a-z]/i", "", $tipo_toolbar);
				$oFCKeditor->Value = "";
				$oFCKeditor->Create();              
			} // fin del if Si hay o no hay resultados
		?>
        </td>
	</tr>
<?
			} // fin del if si hay o no datos a buscar
?>
    <tr>
		<td colspan="2">
		<?php
			echo "<br>";
        	echo "Referencia Siniestro:";
				$tipo_toolbar = "Dre";
				$oFCKeditor = new FCKeditor('Referencia') ;
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
			<input type="hidden" name="idRef" id="idRef" value=""/><!-- 0000014025 -->
            <input type="hidden" name="IDUsuarioCreacion" id="IDUsuarioCreacion" value="<?php echo (isset($_POST['Usuario']) && $_POST['Usuario']!="")? $_POST['Usuario']:$Usuario; ?>"  />
			<input type="hidden" name="" id="" value="<? echo $Ramo; ?>" />
			<input type="button" value="Cancelar" onclick="java:window.open('actividades.php','_self');" class="buttonGeneral" />
        	<input type="button" value="Guardar Siniestro" onclick="validacionAgregarSiniestro('<? echo $existePoliza; ?>');" class="buttonGeneral"/>
			&nbsp;&nbsp;&nbsp;&nbsp;
        </td>
    </tr>
</form>