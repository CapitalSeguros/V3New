<?php
switch($Nivel){ // New Version
//---- Sin Filtro --------------------//				
	case '5': // NIVEL 5
		$sqlFiltroSucursal = "
			Select * From 
				`catalogo_sucursales`
							 ";
		$sqlFiltroConsultor = "
			Select * From 
				`usuarios` 
			Where 
				`TIPO` Like '%300%'
							  ";
		$sqlFiltroVendedor = "
			Select * From 
				`usuarios` 
			Where 
				`TIPO` Like '400'
							  ";
		$sqlFiltroAseguradora = "
			Select * From 
				`catalogo_aseguradoras`
							  ";
		$sqlFiltroRamo = "
			Select * From 
				`catalogo_ramo`
							  ";
		$sqlFiltroSubRamo = "
			Select * From 
				`catalogo_ramo_subramo`
							  ";
		$sqlFiltroGrupo = "
			Select * From 
				`catalogo_grupo`
							  ";
		$sqlFiltroSubGrupo = "
			Select * From 
				`catalogo_grupo_subgrupo`
							  ";
		$sqlFiltroCliente = "
			Select * From 
				`empresas`
			Where
				`estatusCliente` = 'A'
							  ";
		$sqlFiltroPoliza = "
			Select * From 
				`cliramos`
							  ";
	break;
				
//---- Filtra Sucursal --------------------//
	case '4': // NIVEL 4
		$sqlFiltroSucursal = "
			Select * From 
				`catalogo_sucursales`
			Where 
				`clave` = '".str_pad($Sucursal,4,"0",STR_PAD_LEFT)."'
							 ";		
		$sqlFiltroConsultor = "
			Select * From 
				`usuarios` 
			Where 
				`TIPO` Like '%300%'
							  ";
		$sqlFiltroVendedor = "
			Select * From 
				`usuarios` 
			Where 
				`TIPO` Like '400'
							  ";
		$sqlFiltroAseguradora = "
			Select * From 
				`catalogo_aseguradoras`
							  ";
		$sqlFiltroRamo = "
			Select * From 
				`catalogo_ramo`
							  ";
		$sqlFiltroSubRamo = "
			Select * From 
				`catalogo_ramo_subramo`
							  ";
		$sqlFiltroGrupo = "
			Select * From 
				`catalogo_grupo`
							  ";
		$sqlFiltroSubGrupo = "
			Select * From 
				`catalogo_grupo_subgrupo`
							  ";
		$sqlFiltroCliente = "
			Select * From 
				`empresas`
			Where
				`estatusCliente` = 'A'
							  ";
		$sqlFiltroPoliza = "
			Select * From 
				`cliramos`
							  ";
	break;
				
//---- Filtra Vendedor y Promotor --------------------//
	case '3': // NIVEL 3
		$sqlFiltroSucursal = "
			Select * From 
				`catalogo_sucursales`
			Where 
				`clave` = '".str_pad($Sucursal,4,"0",STR_PAD_LEFT)."'
							 ";
		$sqlFiltroConsultor = "
			Select * From 
				`usuarios` 
			Where 
				`TIPO` Like '%300%'
				And
				`VALOR` = '$Usuario'
							  ";
		$sqlFiltroVendedor = "
			Select * From 
				`usuarios` 
			Where
				(
					`TIPO` Like '400'
					Or
					`VALOR` = '$Usuario'
				)
				And
					`PROMOTOR` = '$Usuario'
							  ";
		$sqlFiltroAseguradora = "
			Select * From 
				`catalogo_aseguradoras`
							  ";
		$sqlFiltroRamo = "
			Select * From 
				`catalogo_ramo`
							  ";
		$sqlFiltroSubRamo = "
			Select * From 
				`catalogo_ramo_subramo`
							  ";
		$sqlFiltroGrupo = "
			Select * From 
				`catalogo_grupo`
							  ";
		$sqlFiltroSubGrupo = "
			Select * From 
				`catalogo_grupo_subgrupo`
							  ";
		$sqlFiltroCliente = "
			Select * From 
				`empresas`
			Where
				`estatusCliente` = 'A'
				And
				(
					`VENDEDOR` = '$Usuario'
					Or
					`VENDEDOR1` = '$Usuario'
					Or
					`VENDEDOR2` = '$Usuario'
					Or
					`VENDEDOR3` = '$Usuario'
					Or
					`PROMOTOR` = '$Usuario'
				)
							  ";
		$sqlFiltroPoliza = "
			Select * From 
				`cliramos`
							  ";
	break;

//---- Filtra Vendedor --------------------//
	case '2': // NIVEL 2
		$sqlFiltroSucursal = "
			Select * From 
				`catalogo_sucursales`
			Where 
				`clave` = '".str_pad($Sucursal,4,"0",STR_PAD_LEFT)."'
							 ";
		$sqlFiltroConsultor = "
			Select * From 
				`vendedores` 
			Where 
				`CLAVE` = '$Promotor'
							  ";
		$sqlFiltroVendedor = "
			Select * From 
				`usuarios` 
			Where 
				`VALOR` = '$Usuario'
							  ";
		$sqlFiltroAseguradora = "
			Select * From 
				`catalogo_aseguradoras`
							  ";
		$sqlFiltroRamo = "
			Select * From 
				`catalogo_ramo`
							  ";
		$sqlFiltroSubRamo = "
			Select * From 
				`catalogo_ramo_subramo`
							  ";
		$sqlFiltroGrupo = "
			Select * From 
				`catalogo_grupo`
							  ";
		$sqlFiltroSubGrupo = "
			Select * From 
				`catalogo_grupo_subgrupo`
							  ";
		$sqlFiltroCliente = "
			Select * From 
				`empresas`
			Where
				`estatusCliente` = 'A'
				And
				(
					`VENDEDOR` = '$Usuario'
					Or
					`VENDEDOR1` = '$Usuario'
					Or
					`VENDEDOR2` = '$Usuario'
					Or
					`VENDEDOR3` = '$Usuario'
				)
							  ";
		$sqlFiltroPoliza = "
			Select * From 
				`cliramos`
							  ";
	break;
}

/*
echo "<pre>";
	print_r($_SESSION['WebDreTacticaWeb2']);
	//echo "Suc:".$Sucursal;
	echo $sqlFiltroSucursal;
echo "</pre>";
*/

// Procesos Calculos
	//** Filtro Sucursales
		$resFiltroSucursal = DreQueryDB($sqlFiltroSucursal);
		while($rowFiltroSucursal = mysql_fetch_assoc($resFiltroSucursal)){
			$elementosSucursales[] = '"'.$rowFiltroSucursal['nombre'].'['.$rowFiltroSucursal['clave'].']'.'"';
		}
		if(count($elementosSucursales) > 0){
		$arregloSucursales = implode(", ", $elementosSucursales);//junta los valores del array en una sola cadena de texto
		} else {
		$arregloSucursales = "";
		}
	//** Filtro Consultor
		$resFiltroConsultor = DreQueryDB($sqlFiltroConsultor);
		while($rowFiltroConsultor = mysql_fetch_assoc($resFiltroConsultor)){
			$elementosConsultor[] = '"'.$rowFiltroConsultor['NOMBRE'].'['.$rowFiltroConsultor['CLAVE'].']'.'"';
		}
		if(count($elementosConsultor) > 0){
		$arregloConsultores = implode(", ", $elementosConsultor);//junta los valores del array en una sola cadena de texto
		} else {
		$arregloConsultores = "";
		}
	//** Filtro Vendedor
		$resFiltroVendedor = DreQueryDB($sqlFiltroVendedor);
		while($rowFiltroVendedor = mysql_fetch_assoc($resFiltroVendedor)){
			$elementosVendedor[] = '"'.$rowFiltroVendedor['NOMBRE'].'['.$rowFiltroVendedor['VALOR'].']'.'"';
		}
		$arregloVendedores = implode(", ", $elementosVendedor);//junta los valores del array en una sola cadena de texto
	//** Filtro Aseguradora
		$resFiltroAseguradora = DreQueryDB($sqlFiltroAseguradora);
		while($rowFiltroAseguradora = mysql_fetch_assoc($resFiltroAseguradora)){
			$elementosAseguradora[] = '"'.$rowFiltroAseguradora['nombre'].'['.$rowFiltroAseguradora['idAseguradora'].']'.'"';
		}
		$arregloAseguradoras = implode(", ", $elementosAseguradora);//junta los valores del array en una sola cadena de texto
	//** Filtro Ramo
		$resFiltroRamo = DreQueryDB($sqlFiltroRamo);
		while($rowFiltroRamo = mysql_fetch_assoc($resFiltroRamo)){
			$elementosRamo[] = '"'.$rowFiltroRamo['nombre'].'['.$rowFiltroRamo['clave'].']'.'"';
		}
		$arregloRamos = implode(", ", $elementosRamo);//junta los valores del array en una sola cadena de texto
	//** Filtro SubRamo
		$resFiltroSubRamo = DreQueryDB($sqlFiltroSubRamo);
		while($rowFiltroSubRamo = mysql_fetch_assoc($resFiltroSubRamo)){
			$elementosSubRamo[] = '"'.$rowFiltroSubRamo['subRamo'].'['.$rowFiltroSubRamo['clave'].']'.'"';
		}
		$arregloSubRamos = implode(", ", $elementosSubRamo);//junta los valores del array en una sola cadena de texto
	//** Filtro Grupo
		$resFiltroGrupo = DreQueryDB($sqlFiltroGrupo);
		while($rowFiltroGrupo = mysql_fetch_assoc($resFiltroGrupo)){
			$elementosGrupo[] = '"'.$rowFiltroGrupo['nombre'].'['.$rowFiltroGrupo['id'].']'.'"';
		}
		$arregloGrupos = implode(", ", $elementosGrupo);//junta los valores del array en una sola cadena de texto
	//** Filtro SubGrupo
		$resFiltroSubGrupo = DreQueryDB($sqlFiltroSubGrupo);
		while($rowFiltroSubGrupo = mysql_fetch_assoc($resFiltroSubGrupo)){
			$elementosSubGrupo[] = '"'.$rowFiltroSubGrupo['subGrupo'].'['.$rowFiltroSubGrupo['id'].']'.'"';
		}
		$arregloSubGrupos = implode(", ", $elementosSubGrupo);//junta los valores del array en una sola cadena de texto
	//** Filtro Cliente
		$resFiltroCliente = DreQueryDB($sqlFiltroCliente);
		while($rowFiltroCliente = mysql_fetch_assoc($resFiltroCliente)){
			$elementosCliente[] = '"'.$rowFiltroCliente['RAZON_SOCIAL'].'['.$rowFiltroCliente['CLAVE'].']'.'"';
		}
		$arregloClientes = implode(", ", $elementosCliente);//junta los valores del array en una sola cadena de texto
	//** Filtro Poliza
		$resFiltroPoliza = DreQueryDB($sqlFiltroPoliza);
		while($rowFiltroPoliza = mysql_fetch_assoc($resFiltroPoliza)){
			$elementosPoliza[] = '"'.$rowFiltroPoliza['POLIZA'].'"';
		}
		$arregloPolizas = implode(", ", $elementosPoliza);//junta los valores del array en una sola cadena de texto

?>
<script>
	//** Filtro Sucursales
	$(function() {
//** Sucursal
		var availableTagsSucursales = new Array(<?php echo $arregloSucursales; ?>);//imprime el arreglo dentro de un array de javascript
		$( "#filtroSucursal" ).autocomplete({
			source: availableTagsSucursales
		});
//** Consultor
		var availableTagsConsultores = new Array(<?php echo $arregloConsultores; ?>);//imprime el arreglo dentro de un array de javascript
		$( "#filtroConsultor" ).autocomplete({
			source: availableTagsConsultores
		});
//** Vendedor
		var availableTagsVendedores = new Array(<?php echo $arregloVendedores; ?>);//imprime el arreglo dentro de un array de javascript
		$( "#filtroVendedor" ).autocomplete({
			source: availableTagsVendedores
		});
//** Aseguradora
		var availableTagsAseguradoras = new Array(<?php echo $arregloAseguradoras; ?>);//imprime el arreglo dentro de un array de javascript
		$( "#filtroAseguradora" ).autocomplete({
			source: availableTagsAseguradoras
		});
//** Grupo
		var availableTagsGrupos = new Array(<?php echo $arregloGrupos; ?>);//imprime el arreglo dentro de un array de javascript
		$( "#filtroGrupo" ).autocomplete({
			source: availableTagsGrupos
		});
//** SubGrupo
		var availableTagsSubGrupos = new Array(<?php echo $arregloSubGrupos; ?>);//imprime el arreglo dentro de un array de javascript
		$( "#filtroSubGrupo" ).autocomplete({
			source: availableTagsSubGrupos
		});
//** Ramo
		var availableTagsRamos = new Array(<?php echo $arregloRamos; ?>);//imprime el arreglo dentro de un array de javascript
		$( "#filtroRamo" ).autocomplete({
			source: availableTagsRamos
		});
//** SubRamo
		var availableTagsSubRamos = new Array(<?php echo $arregloSubRamos; ?>);//imprime el arreglo dentro de un array de javascript
		$( "#filtroSubRamo" ).autocomplete({
			source: availableTagsSubRamos
		});
//** Cliente
		var availableTagsClientes = new Array(<?php echo $arregloClientes; ?>);//imprime el arreglo dentro de un array de javascript
		$( "#filtroCliente" ).autocomplete({
			source: availableTagsClientes
		});
//** Poliza
		var availableTagsPoliza = new Array(<?php echo $arregloPolizas; ?>);//imprime el arreglo dentro de un array de javascript
		$( "#filtroPoliza" ).autocomplete({
			source: availableTagsPoliza
		});
	});
</script>
<!-- <br><br> -->
<table width="950" cellpadding="2" cellspacing="0" border="0" align="center">
    <tr>
    	<td colspan="3" align="center">
        	<table width="100%" align="center" cellpadding="2" cellspacing="2" border="0">
            	<tr>
                	<td width="50%" align="center">
						<input
							type="button" name="cobranzaPendiente" id="cobranzaPendiente" 
							class="buttonGeneral" value="Reporte Dinamico Cobranza Pendiente" 
							onClick="window.open('reportes/dinamico_cobranzapendiente.php','_blank');"
						/>
                    </td>
                	<td width="50%" align="center">
						<input
							type="button" name="cobranzaPendiente" id="cobranzaPendiente" 
							class="buttonGeneral" value="Reporte Dinamico Renovaciones" 
							onClick="window.open('reportes/dinamico_renovaciones.php','_blank');"
						/>
                    </td>
                </tr>
            </table>
        </td>
	</tr>
    <form name="formFiltroReportes" id="formFiltroReportes" method="post" action="reportes/excel_reporte.php" >
    <tr style="background-image:url(img/fondoTablaDegradadoGris.png); color:#273B71; font-weight:bold;">
    	<td width="330">
        	FILTRAR POR:
        </td>
    	<td width="310">&nbsp;
        
        </td>
    	<td width="310">
        	
        </td>
    </tr>
	<tr>
		<td>
			Fecha Inicio:
			<input
            	type="text" name="fechaInicio" id="fechaInicio"
                style="width:50%" readonly
                value="<? echo date('Y-m-d'); ?>"
            />
			<img src="img/cal.gif" id="fechaInicio_Btn"  title="Clic" />
		</td>
		<td>
			Fecha Fin:
			<input 
            	type="text" name="fechaFin" id="fechaFin" 
            	style="width:50%" readonly
                value="<? echo date('Y-m-d'); ?>"
            />
			<img src="img/cal.gif" id="fechaFin_Btn"  title="Clic" />
        </td>
		<td valign="top">
			Columnas Adicionales:
        </td>
    </tr>
    <tr>
    	<td colspan="2">
			<table width="640" align="left" cellpadding="2" cellspacing="2" border="0">
            	<tr>
                	<td width="100" bgcolor="#B6C6D7">Sucursal</td>
               	  <td width="800" bgcolor="#DFDFDF"><input type="text" name="filtroSucursal" id="filtroSucursal" style="width:100%; background-color:#FFFFFF;" /></td>
                </tr>
            	<tr>
                	<td bgcolor="#B6C6D7">Consultor</td>
               	  <td bgcolor="#DFDFDF"><input type="text" name="filtroConsultor" id="filtroConsultor" style="width:100%; background-color:#FFFFFF;" /></td>
                </tr>
            	<tr>
                	<td bgcolor="#B6C6D7">Vendedor</td>
               	  <td bgcolor="#DFDFDF"><input type="text" name="filtroVendedor" id="filtroVendedor" style="width:100%; background-color:#FFFFFF" /></td>
                </tr>
<!--
            	<tr>
                	<td bgcolor="#B6C6D7">Aseguradora</td>
               	  <td bgcolor="#DFDFDF"><input type="text" name="filtroAseguradora" id="filtroAseguradora" style="width:100%; background-color:#FFFFFF;" /></td>
                </tr>
-->
            	<tr>
                	<td bgcolor="#B6C6D7">Ramo</td>
               	  <td bgcolor="#DFDFDF"><input type="text" name="filtroRamo" id="filtroRamo" style="width:100%; background-color:#FFFFFF;" /></td>
                </tr>
            	<tr>
                	<td bgcolor="#B6C6D7">SubRamo</td>
               	  <td bgcolor="#DFDFDF"><input type="text" name="filtroSubRamo" id="filtroSubRamo" style="width:100%; background-color:#FFFFFF;" /></td>
                </tr>
            	<tr>
                	<td bgcolor="#B6C6D7">Cliente</td>
                	<td bgcolor="#DFDFDF"><input type="text" name="filtroCliente" id="filtroCliente" style="width:100%; background-color:#FFFFFF;" /></td>
                </tr>
            	<tr>
                	<td bgcolor="#B6C6D7">Grupo</td>
               	  <td bgcolor="#DFDFDF"><input type="text" name="filtroGrupo" id="filtroGrupo" style="width:100%; background-color:#FFFFFF;" /></td>
                </tr>
            	<tr>
                	<td bgcolor="#B6C6D7">SubGrupo</td>
               	  <td bgcolor="#DFDFDF"><input type="text" name="filtroSubGrupo" id="filtroSubGrupo" style="width:100%; background-color:#FFFFFF;" /></td>
                </tr>
<!--
            	<tr>
                	<td>Poliza</td>
                	<td><input type="text" name="filtroPoliza" id="filtroPoliza" style="width:100%;" /></td>
                </tr>
-->
            </table>
		</td>
    	<td valign="top">
            <table width="150" align="left" cellpadding="2" cellspacing="2" border="0">
            	<tr>
                	<td width="100" bgcolor="#B6C6D7">Sucursal</td>
               	  <td width="30" align="left" bgcolor="#DFDFDF"><input type="checkbox" name="verSucursal" id="verSucursal" style="width:100%;" /></td>
                </tr>
            	<tr>
                	<td bgcolor="#B6C6D7">Consultor</td>
               	  <td bgcolor="#DFDFDF"><input type="checkbox" name="verConsultor" id="verConsultor" style="width:100%;" /></td>
                </tr>
            	<tr>
                	<td bgcolor="#B6C6D7">Vendedor</td>
               	  <td bgcolor="#DFDFDF"><input type="checkbox" name="verVendedor" id="verVendedor" style="width:100%;" /></td>
                </tr>
            	<tr>
                	<td bgcolor="#B6C6D7">Grupo</td>
               	  <td bgcolor="#DFDFDF"><input type="checkbox" name="verGrupo" id="verGrupo" style="width:100%;" /></td>
                </tr>
            	<tr>
                	<td bgcolor="#B6C6D7">SubGrupo</td>
               	  <td bgcolor="#DFDFDF"><input type="checkbox" name="verSubGrupo" id="verSubGrupo" style="width:100%;" /></td>
                </tr>
            	<tr>
                	<td bgcolor="#B6C6D7">Descripci&oacute;n</td>
               	  <td bgcolor="#DFDFDF"><input type="checkbox" name="verDescripcion" id="verDescripcion" style="width:100%;" /></td>
                </tr>
            </table>
        </td>
   	  </tr>
<!--
    <tr>
    	<td colspan="3">Filtrar por: <input type="text" style="width:90%"></td>
	</tr>
-->
    <tr>
    	<td>
<!--
        	<table width="150" align="left" cellpadding="1" cellspacing="2" border="1">
            	<tr>
                	<td width="100">Sucursal</td>
                	<td width="30" align="left"><input type="radio" name="filtroSucursal" id="filtroSucursal" style="width:100%;" /></td>
                </tr>
            	<tr>
                	<td>Consultor</td>
                	<td><input type="radio" name="filtroConsultor" id="filtroConsultor" style="width:100%;" /></td>
                </tr>
            	<tr>
                	<td>Vendedor</td>
                	<td><input type="radio" name="filtroVendedor" id="filtroVendedor" style="width:100%;" /></td>
                </tr>
            	<tr>
                	<td>Aseguradora</td>
                	<td><input type="radio" name="filtroAseguradora" id="filtroAseguradora" style="width:100%;" /></td>
                </tr>
            	<tr>
                	<td>Ramo</td>
                	<td><input type="radio" name="filtroSucursal" id="filtroSucursal" style="width:100%;" /></td>
                </tr>
            	<tr>
                	<td>SubRamo</td>
                	<td><input type="radio" name="filtroSucursal" id="filtroSucursal" style="width:100%;" /></td>
                </tr>
            	<tr>
                	<td>Cliente</td>
                	<td><input type="radio" name="filtroSucursal" id="filtroSucursal" style="width:100%;" /></td>
                </tr>
            	<tr>
                	<td>Grupo</td>
                	<td><input type="radio" name="filtroSucursal" id="filtroSucursal" style="width:100%;" /></td>
                </tr>
            	<tr>
                	<td>SubGrupo</td>
                	<td><input type="radio" name="filtroSucursal" id="filtroSucursal" style="width:100%;" /></td>
                </tr>
            </table>
-->
        </td>
        <td>
<!--
        	<table width="150" align="left" cellpadding="1" cellspacing="2" border="1">
            	<tr>
                	<td width="100">Sucursal</td>
                	<td width="30" align="left"><input type="radio" name="filtroSucursal" id="filtroSucursal" style="width:100%;" /></td>
                </tr>
            	<tr>
                	<td>Consultor</td>
                	<td><input type="radio" name="filtroConsultor" id="filtroConsultor" style="width:100%;" /></td>
                </tr>
            	<tr>
                	<td>Vendedor</td>
                	<td><input type="radio" name="filtroVendedor" id="filtroVendedor" style="width:100%;" /></td>
                </tr>
            	<tr>
                	<td>Aseguradora</td>
                	<td><input type="radio" name="filtroAseguradora" id="filtroAseguradora" style="width:100%;" /></td>
                </tr>
            	<tr>
                	<td>Ramo</td>
                	<td><input type="radio" name="filtroSucursal" id="filtroSucursal" style="width:100%;" /></td>
                </tr>
            	<tr>
                	<td>SubRamo</td>
                	<td><input type="radio" name="filtroSucursal" id="filtroSucursal" style="width:100%;" /></td>
                </tr>
            	<tr>
                	<td>Cliente</td>
                	<td><input type="radio" name="filtroSucursal" id="filtroSucursal" style="width:100%;" /></td>
                </tr>
            	<tr>
                	<td>Grupo</td>
                	<td><input type="radio" name="filtroSucursal" id="filtroSucursal" style="width:100%;" /></td>
                </tr>
            	<tr>
                	<td>SubGrupo</td>
                	<td><input type="radio" name="filtroSucursal" id="filtroSucursal" style="width:100%;" /></td>
                </tr>
            </table>
-->
        </td>
        <td valign="top">

        </td>
    </tr>
    <tr>
    	<td colspan="3" align="center">
        	
        	<input type="submit" value="Actividades Pendientes" name="botonImprimir" id="botonImprimir" class="buttonGeneral" style="width:25%;" />
        	<input type="submit" value="Actividades Todas" name="botonImprimir" id="botonImprimir" class="buttonGeneral" style="width:25%;" />
        	<!-- <input type="submit" value="Cotizaciones Emisiones" name="botonImprimir" id="botonImprimir" class="buttonGeneral" style="width:30%;" /> -->
        	<!-- <input type="submit" value="Llamadas Citas" name="botonImprimir" id="botonImprimir" class="buttonGeneral" style="width:30%;" /> -->

        	<input type="submit" value="Comisiones Pendientes Liquidar" name="botonImprimir" id="botonImprimir" class="buttonGeneral" style="width:25%;" />
<br>
        	<input type="submit" value="Comisiones Liquidadas" name="botonImprimir" id="botonImprimir" class="buttonGeneral" style="width:25%;" />
            <!-- @@
        	<input type="submit" value="Comisiones Liquidadas Acumuladas" name="botonImprimir" id="botonImprimir" class="buttonGeneral" style="width:30%;" />
            @@ -->
            <!-- @@
        	<input type="submit" value="Cancelaciones" name="botonImprimir" id="botonImprimir" class="buttonGeneral" style="width:30%;" />
            @@ -->
        	<input type="submit" value="Produccion" name="botonImprimir" id="botonImprimir" class="buttonGeneral" style="width:25%;" /> 
        	<input type="submit" value="Prima Neta Pagada" name="botonImprimir" id="botonImprimir" class="buttonGeneral" style="width:25%;" /> 
        </td>
    </tr>
    </form>
    <tr>
    	<td colspan="3" align="center">
        	<table width="954" cellpadding="1" cellspacing="1" align="center" >
				<tr style="background-image:url(img/fondoTablaDegradadoGris.png); color:#273B71; font-weight:bold;">
                	<td colspan="11">
						PNI
                        <font style="font-size:9px;">(P&oacute;lizas NO Identificadas)</font>
                        :
                    </td>
				</tr>
			    <tr>
    			<td colspan="11" align="justify">
                	<font style="font-size:9px; font-weight:bold; font-style:italic;">
                    	**Una PNI  es un registro temporal de pago aplicado sin carátula registrada en el sistema CAPSYS (LOCAL). Las PNI no generan comisión hasta no ser reclasificadas en el momento que se capture la póliza correspondiente.
                	</font>
        		</td>
    		</tr>
			</table>
            <iframe width="950" height="140" src="reportes/iframe_Prepolizas.php" >
            </iframe>
        </td>
    </tr>
    <tr>
    	<td colspan="3" align="center">&nbsp;
			
        </td>
	</tr>
</table>
<script type="text/javascript">
	Calendar.setup({
		inputField : "fechaInicio",
		trigger    : "fechaInicio_Btn",
		onSelect   : function() { this.hide() },
		dateFormat : "%Y-%m-%d"
	});
	Calendar.setup({
		inputField : "fechaFin",
		trigger    : "fechaFin_Btn",
		onSelect   : function() { this.hide() },
		dateFormat : "%Y-%m-%d"
	});
</script>