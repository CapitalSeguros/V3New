<?php
	$sqlConsultaFormularioCotizacion = "
		Select * From
			`actividades_formularios`
		Where
			`idActividad` = '$recId'
									   ";
	$resConsultaFormularioCotizacion = DreQueryDB($sqlConsultaFormularioCotizacion);
	$rowConsultaFormularioCotizacion = mysql_fetch_assoc($resConsultaFormularioCotizacion);

?>
 <script>
	$(function() {
		<?php

	// Destino Seleccionado
//	if(isset($wsModelo)){ $wsModelo = $wsModelo; } else { $wsModelo = ""; }
//	if(isset($nombreHotel)){ $nombreHotel = $nombreHotel; } else { $nombreHotel = ""; }

		$sqlTagsModelos = "
			Select * From 
				`ws_catalogo_autos_qualitas`
			Where
					`marca` Like '%$wsMarca%'
				And
					`year` Like '%$wsYear%'
			Group By 
				`modelo`
						  ";
		$resTagsModelos = mysql_query($sqlTagsModelos) or die(mysql_error());
		while($rowTagsModelos= mysql_fetch_assoc($resTagsModelos)){
			$elementosModelos[]= '"'.DreSinAcentos($rowTagsModelos['modelo']).'"';
		}
		$arregloModelos= implode(", ", $elementosModelos);//junta los valores del array en una sola cadena de texto
		?>
		
		var availableTagsModelos=new Array(<?php echo $arregloModelos; ?>);//imprime el arreglo dentro de un array de javascript

		$( "#buscar" ).autocomplete({
			source: availableTagsModelos
		});
	});
</script>
<table width="610" cellpadding="5" cellspacing="2" border="0" align="center">
<form name="formLineasPersonales" id="formLineasPersonales" method="post" action="includes/guardar.php?tipoGuardar=formularios">    
	<tr>
		<td width="100" align="right">Marca:</td>
        <td>
            <select name="categoria" id="categoria">
            	<option value="">-- Seleccione --</option>
                <?php
					$sqlMarcas = "
						Select `NombreMarcaLarga` From 
							`ws_catalogo_marcas_qualitas`
								 ";
					$resMarcas = DreQueryDB($sqlMarcas);
					while($rowMarcas = mysql_fetch_assoc($resMarcas)){
				?>
            	<option value="<?php echo $rowMarcas['NombreMarcaLarga']; ?>" <? echo ($rowMarcas['NombreMarcaLarga']==		$rowConsultaFormularioCotizacion['marca_auto'])?"selected":""; ?>><?php echo $rowMarcas['NombreMarcaLarga']; ?></option>
                <?php
					}
				?>
            </select>
		</td>
	</tr>
	<tr>
		<td width="100" align="right">A&ntilde;o:</td>
		<td>
            <select name="ano" id="ano">
            	<option value="">-- Seleccione --</option>
                <?php
					$sqlYearAutos = "
						Select `year` From
							`ws_catalogo_autos_qualitas`
						Where
							`year` != '' And length(`year`) >= '4'
						Group By 
							`year`
						Order By
							`year` Asc
									";
					$resYearAutos = DreQueryDB($sqlYearAutos);
					while($rowYearAutos = mysql_fetch_assoc($resYearAutos)){
			?>
            	<option value="<?php echo $rowYearAutos['year']; ?>" <? echo ($rowYearAutos['year'] == $rowConsultaFormularioCotizacion['year_auto'])? "selected":""; ?>><?php echo $rowYearAutos['year']; ?></option>
            <?php
					}
			?>
            </select>
		</td>
	</tr>
	<tr>
		<td width="100" align="right">Modelo:</td>
		<td>
			<input type="text" name="buscar" id="buscar" style="width:90%;"  value="<?php echo $rowConsultaFormularioCotizacion['modelo_auto']; ?>" />
		</td>
	</tr>
	<tr>
		<td align="right">
			Estado:
		</td>
		<td><?php echo SelectEstado($rowConsultaFormularioCotizacion['estado'],$rowConsultaFormularioCotizacion['estatus']); ?></td>
	</tr>
	<tr>
    	<td width="100" align="right">
    		Codigo Postal:
    	</td>
        <td><input name="codigo_postal" type="text" id="codigo_postal" value="<?php echo $rowConsultaFormularioCotizacion['codigo_postal'] ?>" maxlength="30" <?php echo campoBloqueado($rowConsultaFormularioCotizacion['estatus']); ?>/></td>
	</tr>
	<tr>
	  <td align="right">Tipo uso:</td>
	  <td><?php echo SelectTipoUso($rowConsultaFormularioCotizacion['tipo_uso'],$rowConsultaFormularioCotizacion['estatus']); ?></td>
  </tr>
    <tr>
        <td align="right">Cobertura:</td>
        <td><?php echo SelectCoberturaAuto($rowConsultaFormularioCotizacion['cobertura_auto'],$rowConsultaFormularioCotizacion['estatus']); ?></td>
      </tr>
      <tr>
        <td align="right">Valor factura:</td>
        <td><input name="valor_factura" type="text" id="valor_factura" value="<?php echo $rowConsultaFormularioCotizacion['valor_factura'] ?>" maxlength="30" <?php echo campoBloqueado($rowConsultaFormularioCotizacion['estatus']); ?>/></td>
      </tr>
      <tr>
        <td align="right">Forma pago:</td>
        <td><?php echo SelectFormaPago($rowConsultaFormularioCotizacion['forma_pago'],$rowConsultaFormularioCotizacion['estatus'], $Grupo); ?></td>
      </tr>
	<tr>
        <td colspan="2">Descripci&oacute;n:</td>
	</tr>
	<tr>
        <td colspan="2">
        <textarea name="observaciones" cols="80" id="observaciones" <?php echo campoBloqueado($rowConsultaFormularioCotizacion['estatus']);?>><?php echo $rowConsultaFormularioCotizacion['observaciones'] ?></textarea>
        </td>
	</tr>
	<tr>
        <td colspan="2">Adaptaci&oacute;n:</td>
	</tr>
	<tr>
        <td colspan="2">
        <textarea name="comentario" cols="80" id="comentario" <?php echo campoBloqueado($rowConsultaFormularioCotizacion['estatus']);?>><?php echo $rowConsultaFormularioCotizacion['comentario'] ?></textarea>
      </td>
	</tr>
	<tr>
	  <td colspan="2" align="right">
      <input type="hidden" name="ramoInterno" id="ramoInterno" value="<?php echo $rowDatosActividad['ramoInterno']; ?>" />
      <input type="hidden" name="idInterno" id="idInterno" value="<?php echo $rowDatosActividad['idInterno']; ?>" />
      <input type="hidden" name="idActividad" id="idActividad" value="<?php echo $rowDatosActividad['recId']; ?>" />
      <input type="hidden" name="recId" id="recId" value="<?php echo $rowDatosActividad['recId']; ?>" />
      <input type="hidden" name="tipoLineaPersonal" id="tipoLineaPersonal" value="<?php echo $tipoLineaPersonal; ?>" />
      <?php
	  	if($rowConsultaFormularioCotizacion['estatus'] != '1'){
	  ?>
      <input type="button" value="guardar" onclick="java:document.formLineasPersonales.submit()" />
      <?php
		}
	  ?>
      &nbsp;&nbsp;&nbsp;
      </td>
  </tr>
</form>
</table>