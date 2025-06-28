<?php	
//	$Usuario;
//	$Vendedor;

switch($Nivel){ // New Version
//---- Sin Filtro --------------------//				
	case '5': // NIVEL 5

	break;
				
//---- Filtra Sucursal --------------------//
	case '4': // NIVEL 4
	break;
				
//---- Filtra Vendedor y Promotor --------------------//
	case '3': // NIVEL 3
	break;

//---- Filtra Vendedor --------------------//
	case '2': // NIVEL 2
		$activaFiltro = "si"; 
		$sqlFiltraVendedor = $Usuario;					
	break;
}

?>
<table width="950" cellpadding="0" cellspacing="0" border="0">
    <tr>
    	<td colspan="2">
        	<div class="divClic">
			<table width="950" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td width="300" align="left">
            			&nbsp;&nbsp;&nbsp;
						<a href="#ActividadesPendientes" onclick="mostrarOcultarDiv('ActividadesPendientes')" class="TextoTitulosSecciondivClic" title="Click para ver detalle...">
                        R. Actividades Pendientes
                        </a>
                    </td>
                	<td width="650" align="left">
						<a href="#ActividadesPendientes" onclick="mostrarOcultarDiv('ActividadesPendientes')" class="LinkSecciondivClic" title="Click para ver detalle...">
                        	&nbsp;&nbsp;&nbsp;
							Click para ver detalle...
                        </a>
                    </td>
                </tr>
			</table>
            </div>
        </td>
    </tr>
    <tr>
    	<td colspan="2">
       	<div id="ActividadesPendientes" <?php echo ($muestra == "ActividadesPendientes")? 'style="display:block;"':'style="display:none;"'; ?>>
        <a name="ActividadesPendientes" id="ActividadesPendientes"></a>
        <!-- Reporte -->
		<form name="formSemaforoActividades" id="formSemaforoActividades" method="post" action="reportes/actividadesExcel.php" target="_blank">
			<table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
                <tr>
					<td width="300">
                    	Fecha Inicio:
						<input type="text" name="fechaInicioActi" id="fechaInicioActi" style="width:50%" readonly />
						<img src="img/cal.gif" id="fechaInicioActi_Btn"  title="Clic" />
					</td>
					<td width="300">
                    	Fecha Fin:
						<input type="text" name="fechaFinActi" id="fechaFinActi" style="width:50%" readonly />
						<img src="img/cal.gif" id="fechaFinActi_Btn"  title="Clic" />
					</td>
					<td width="300">
						<input type="hidden" name="activaFiltro" id="activaFiltro" value="<?php echo $activaFiltro; ?>" />
                        <input type="hidden" name="sqlFiltraVendedor" id="sqlFiltraVendedor" value="<?php echo $sqlFiltraVendedor; ?>" />
                        <input type="submit" value="Ver"/>
                    </td>
                </tr>
            </table>
		</form>  
        <!-- Reporte -->
        </div>
        </td>
    </tr>
	<tr>
    	<td colspan="2">&nbsp;</td>
    </tr>
<!-- -->
    <tr>
    	<td colspan="2">
        	<div class="divClic">
			<table width="950" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td width="300" align="left">
            			&nbsp;&nbsp;&nbsp;
						<a href="#ActividadesTodos" onclick="mostrarOcultarDiv('ActividadesTodos')" class="TextoTitulosSecciondivClic" title="Click para ver detalle...">
                        R. Actividades Todos
                        </a>
                    </td>
                	<td width="650" align="left">
						<a href="#ActividadesTodos" onclick="mostrarOcultarDiv('ActividadesTodos')" class="LinkSecciondivClic" title="Click para ver detalle...">
                        	&nbsp;&nbsp;&nbsp;
							Click para ver detalle...
                        </a>
                    </td>
                </tr>
			</table>
            </div>
        </td>
    </tr>
    <tr>
    	<td colspan="2">
       	<div id="ActividadesTodos" <?php echo ($muestra == "ActividadesTodos")? 'style="display:block;"':'style="display:none;"'; ?>>
        <a name="ActividadesTodos" id="ActividadesTodos"></a>
        <!-- Reporte -->
	<form name="formSemaforoActividadesTodos" id="formSemaforoActividadesTodos" method="post" action="reportes/actividadesExcel_Todos.php" target="_blank">
			<table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
                <tr>
					<td width="300">
                    	Fecha Inicio:
        	<input type="text" name="fechaInicioActiTodos" id="fechaInicioActiTodos" style="width:50%" readonly />
            <img src="img/cal.gif" id="fechaInicioActiTodos_Btn"  title="Clic" />
					</td>
					<td width="300">
                    	Fecha Fin:
        	<input type="text" name="fechaFinActiTodos" id="fechaFinActiTodos" style="width:50%" readonly />
            <img src="img/cal.gif" id="fechaFinActiTodos_Btn"  title="Clic" />
					</td>
					<td width="300">
        <input type="hidden" name="activaFiltro" id="activaFiltro" value="<?php echo $activaFiltro; ?>" />
        <input type="hidden" name="sqlFiltraVendedor" id="sqlFiltraVendedor" value="<?php echo $sqlFiltraVendedor; ?>" />
      	<input type="submit" value="Ver"/>
					</td>
                </tr>
            </table>
		</form>  
        <!-- Reporte -->
        </div>
        </td>
    </tr>
	<tr>
    	<td colspan="2">&nbsp;</td>
    </tr>
 <!-- -->
    <tr>
    	<td colspan="2">
        	<div class="divClic">
			<table width="950" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td width="300" align="left">
            			&nbsp;&nbsp;&nbsp;
						<a href="#CobranzaPendiente" onclick="mostrarOcultarDiv('CobranzaPendiente')" class="TextoTitulosSecciondivClic" title="Click para ver detalle...">
                        R. De Cobranza Pendiente
                        </a>
                    </td>
                	<td width="650" align="left">
						<a href="#CobranzaPendiente" onclick="mostrarOcultarDiv('CobranzaPendiente')" class="LinkSecciondivClic" title="Click para ver detalle...">
                        	&nbsp;&nbsp;&nbsp;
							Click para ver detalle...
                        </a>
                    </td>
                </tr>
			</table>
            </div>
        </td>
    </tr>
    <tr>
    	<td colspan="2">
       	<div id="CobranzaPendiente" <?php echo ($muestra == "CobranzaPendiente")? 'style="display:block;"':'style="display:none;"'; ?>>
        <a name="CobranzaPendiente" id="CobranzaPendiente"></a>
        <!-- Reporte -->
	<form name="formSemaforoActividades" id="formSemaforoActividades" method="post" action="reportes/cobranzaExcel.php" target="_blank">
			<table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
                <tr>
					<td width="300">
                    	Fecha Inicio:
        	<input type="text" name="fechaInicio" id="fechaInicio" style="width:50%" readonly />
            <img src="img/cal.gif" id="fechaInicio_Btn"  title="Clic" />
					</td>
					<td width="300">
                    	Fecha Fin:
        	<input type="text" name="fechaFin" id="fechaFin" style="width:50%" readonly />
            <img src="img/cal.gif" id="fechaFin_Btn"  title="Clic" />
					</td>
					<td width="300">
        <input type="hidden" name="activaFiltro" id="activaFiltro" value="<?php echo $activaFiltro; ?>" />
        <input type="hidden" name="sqlFiltraVendedor" id="sqlFiltraVendedor" value="<?php echo $sqlFiltraVendedor; ?>" />
      	<input type="submit" value="Ver"/>
					</td>
                </tr>
            </table>
		</form>  
        <!-- Reporte -->
        </div>
        </td>
    </tr>
	<tr>
    	<td colspan="2">&nbsp;</td>
    </tr>
 <!-- -->
    <tr>
    	<td colspan="2">
        	<div class="divClic">
			<table width="950" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td width="300" align="left">
            			&nbsp;&nbsp;&nbsp;
						<a href="#PolizasCanceladas" onclick="mostrarOcultarDiv('PolizasCanceladas')" class="TextoTitulosSecciondivClic" title="Click para ver detalle...">
                        R. De Polizas Canceladas
                        </a>
                    </td>
                	<td width="650" align="left">
						<a href="#PolizasCanceladas" onclick="mostrarOcultarDiv('PolizasCanceladas')" class="LinkSecciondivClic" title="Click para ver detalle...">
                        	&nbsp;&nbsp;&nbsp;
							Click para ver detalle...
                        </a>
                    </td>
                </tr>
			</table>
            </div>
        </td>
    </tr>
    <tr>
    	<td colspan="2">
       	<div id="PolizasCanceladas" <?php echo ($muestra == "PolizasCanceladas")? 'style="display:block;"':'style="display:none;"'; ?>>
        <a name="PolizasCanceladas" id="PolizasCanceladas"></a>
        <!-- Reporte -->
	<form name="formSemaforoActividades" id="formSemaforoActividades" method="post" action="reportes/polCanceladasExcel.php" target="_blank">
			<table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
                <tr>
					<td width="300">
                    	Fecha Inicio:
        	<input type="text" name="fechaInicioPolCan" id="fechaInicioPolCan" style="width:50%" readonly />
            <img src="img/cal.gif" id="fechaInicioPolCan_Btn"  title="Clic" />
					</td>
					<td width="300">
                    	Fecha Fin:
        	<input type="text" name="fechaFinPolCan" id="fechaFinPolCan" style="width:50%" readonly />
            <img src="img/cal.gif" id="fechaFinPolCan_Btn"  title="Clic" />
					</td>
					<td width="300">
        <input type="hidden" name="activaFiltro" id="activaFiltro" value="<?php echo $activaFiltro; ?>" />
        <input type="hidden" name="sqlFiltraVendedor" id="sqlFiltraVendedor" value="<?php echo $sqlFiltraVendedor; ?>" />
      	<input type="submit" value="Ver"/>
					</td>
                </tr>
            </table>
		</form>  
        <!-- Reporte -->
        </div>
        </td>
    </tr>
	<tr>
    	<td colspan="2">&nbsp;</td>
    </tr>
 <!-- -->
    <tr>
    	<td colspan="2">
        	<div class="divClic">
			<table width="950" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td width="300" align="left">
            			&nbsp;&nbsp;&nbsp;
						<a href="#CotizacionesEmisiones" onclick="mostrarOcultarDiv('CotizacionesEmisiones')" class="TextoTitulosSecciondivClic" title="Click para ver detalle...">
                        R. De Cotizaciones Y Emisiones
                        </a>
                    </td>
                	<td width="650" align="left">
						<a href="#CotizacionesEmisiones" onclick="mostrarOcultarDiv('CotizacionesEmisiones')" class="LinkSecciondivClic" title="Click para ver detalle...">
                        	&nbsp;&nbsp;&nbsp;
							Click para ver detalle...
                        </a>
                    </td>
                </tr>
			</table>
            </div>
        </td>
    </tr>
    <tr>
    	<td colspan="2">
       	<div id="CotizacionesEmisiones" <?php echo ($muestra == "CotizacionesEmisiones")? 'style="display:block;"':'style="display:none;"'; ?>>
        <a name="CotizacionesEmisiones" id="CotizacionesEmisiones"></a>
        <!-- Reporte -->
	<form name="formSemaforoActividades" id="formSemaforoActividades" method="post" action="reportes/cotyEmisionesExcel.php" target="_blank">
			<table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
                <tr>
					<td width="300">
                    	Fecha Inicio:
        	<input type="text" name="fechaInicioCotEmi" id="fechaInicioCotEmi" style="width:50%" readonly />
            <img src="img/cal.gif" id="fechaInicioCotEmi_Btn"  title="Clic" />
					</td>
					<td width="300">
                    	Fecha Fin:
        	<input type="text" name="fechaFinCotEmi" id="fechaFinCotEmi" style="width:50%" readonly />
            <img src="img/cal.gif" id="fechaFinCotEmi_Btn"  title="Clic" />
					</td>
					<td width="300">
        <input type="hidden" name="activaFiltro" id="activaFiltro" value="<?php echo $activaFiltro; ?>" />
        <input type="hidden" name="sqlFiltraVendedor" id="sqlFiltraVendedor" value="<?php echo $sqlFiltraVendedor; ?>" />
      	<input type="submit" value="Ver"/>
					</td>
                </tr>
            </table>
		</form>  
        <!-- Reporte -->
        </div>
        </td>
    </tr>
	<tr>
    	<td colspan="2">&nbsp;</td>
    </tr>
 <!-- -->
    <tr>
    	<td colspan="2">
        	<div class="divClic">
			<table width="950" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td width="300" align="left">
            			&nbsp;&nbsp;&nbsp;
						<a href="#ComisionesPendientesLiquidar" onclick="mostrarOcultarDiv('ComisionesPendientesLiquidar')" class="TextoTitulosSecciondivClic" title="Click para ver detalle...">
                        R. De Comisiones P de Liquidar
                        </a>
                    </td>
                	<td width="650" align="left">
						<a href="#ComisionesPendientesLiquidar" onclick="mostrarOcultarDiv('ComisionesPendientesLiquidar')" class="LinkSecciondivClic" title="Click para ver detalle...">
                        	&nbsp;&nbsp;&nbsp;
							Click para ver detalle...
                        </a>
                    </td>
                </tr>
			</table>
            </div>
        </td>
    </tr>
    <tr>
    	<td colspan="2">
       	<div id="ComisionesPendientesLiquidar" <?php echo ($muestra == "ComisionesPendientesLiquidar")? 'style="display:block;"':'style="display:none;"'; ?>>
        <a name="ComisionesPendientesLiquidar" id="ComisionesPendientesLiquidar"></a>
        <!-- Reporte -->
	<form name="formSemaforoActividades" id="formSemaforoActividades" method="post" action="reportes/comisionespendExcel.php" target="_blank">
			<table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
                <tr>
					<td width="300">
                    	Fecha Inicio:
        	<input type="text" name="fechaInicioComiPen" id="fechaInicioComiPen" style="width:50%" readonly />
            <img src="img/cal.gif" id="fechaInicioComiPen_Btn"  title="Clic" />
					</td>
					<td width="300">
                    	Fecha Fin:
        	<input type="text" name="fechaFinComiPen" id="fechaFinComiPen" style="width:50%" readonly />
            <img src="img/cal.gif" id="fechaFinComiPen_Btn"  title="Clic" />
					</td>
					<td width="300">
        <input type="hidden" name="activaFiltro" id="activaFiltro" value="<?php echo $activaFiltro; ?>" />
        <input type="hidden" name="sqlFiltraVendedor" id="sqlFiltraVendedor" value="<?php echo $sqlFiltraVendedor; ?>" />
      	<input type="submit" value="Ver"/>
					</td>
                </tr>
            </table>
		</form>  
        <!-- Reporte -->
        </div>
        </td>
    </tr>
	<tr>
    	<td colspan="2">&nbsp;</td>
    </tr>
 <!-- -->
    <tr>
    	<td colspan="2">
        	<div class="divClic">
			<table width="950" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td width="300" align="left">
            			&nbsp;&nbsp;&nbsp;
						<a href="#LlamadasCitas" onclick="mostrarOcultarDiv('LlamadasCitas')" class="TextoTitulosSecciondivClic" title="Click para ver detalle...">
                        R. De Llamadas-Citas
                        </a>
                    </td>
                	<td width="650" align="left">
						<a href="#LlamadasCitas" onclick="mostrarOcultarDiv('LlamadasCitas')" class="LinkSecciondivClic" title="Click para ver detalle...">
                        	&nbsp;&nbsp;&nbsp;
							Click para ver detalle...
                        </a>
                    </td>
                </tr>
			</table>
            </div>
        </td>
    </tr>
    <tr>
    	<td colspan="2">
       	<div id="LlamadasCitas" <?php echo ($muestra == "LlamadasCitas")? 'style="display:block;"':'style="display:none;"'; ?>>
        <a name="LlamadasCitas" id="LlamadasCitas"></a>
        <!-- Reporte -->
	<form name="formLlamadasCitas" id="formLlamadasCitas" method="post" action="reportes/dinamico_llamadasCitas.php" target="_blank">
			<table width="900" cellpadding="1" cellspacing="1" border="0" align="center" style="font-size:12px;">
                <tr>
					<td width="300">
                    	Fecha Inicio:
        	<input type="text" name="fechaInicioLlamadasCitas" id="fechaInicioLlamadasCitas" style="width:50%" readonly />
            <img src="img/cal.gif" id="fechaInicioLlamadasCitas_Btn"  title="Clic" />
					</td>
					<td width="300">
                    	Fecha Fin:
        	<input type="text" name="fechaFinLlamadasCitas" id="fechaFinLlamadasCitas" style="width:50%" readonly />
            <img src="img/cal.gif" id="fechaFinLlamadasCitas_Btn"  title="Clic" />
					</td>
					<td width="300">
        <input type="hidden" name="activaFiltro" id="activaFiltro" value="<?php echo $activaFiltro; ?>" />
        <input type="hidden" name="sqlFiltraVendedor" id="sqlFiltraVendedor" value="<?php echo $sqlFiltraVendedor; ?>" />
      	<input type="submit" value="Ver"/>
					</td>
                </tr>
            </table>
		</form>  
        <!-- Reporte -->
        </div>
        </td>
    </tr>
	<tr>
    	<td colspan="2">&nbsp;</td>
    </tr>
    <tr class="TextoTitulosSeccion">
    	<td>Reportes Dinamicos</td>
    </tr>
    <tr>
    	<td>
        	<table width="100%" cellpadding="0" cellspacing="0" border="0">
            	<tr>
                	<td>
						<div class="divClic" style="width:99%;">
                        &nbsp;&nbsp;&nbsp;
                    	<a href="reportes/dinamico_comisionespl.php" target="_blank" class="TextoTitulosSecciondivClic">
                        	&bull; Reporte Comisiones Pendientes Liquidar
                        </a>
                        </div>
                       <br>
                    </td>
                </tr>
            	<tr>
                	<td>
						<div class="divClic" style="width:99%;">
                        &nbsp;&nbsp;&nbsp;
                    	<a href="reportes/dinamico_comisionesli.php" target="_blank" class="TextoTitulosSecciondivClic">
                        	&bull; Reporte Comisiones Liquidadas
                        </a>
                        </div>
                       <br>
                    </td>
                </tr>
            	<tr>
                	<td>
						<div class="divClic" style="width:99%;">
                        &nbsp;&nbsp;&nbsp;
                    	<a href="reportes/dinamico_renovaciones.php" target="_blank" class="TextoTitulosSecciondivClic">
                        	&bull; Reporte Renovaciones
                        </a>
                        </div>
                       <br>
                    </td>
                </tr>
            	<tr>
                	<td>
						<div class="divClic" style="width:99%;">
                        &nbsp;&nbsp;&nbsp;
                    	<a href="reportes/dinamico_cancelaciones.php" target="_blank" class="TextoTitulosSecciondivClic">
                        	&bull; Reporte Cancelaciones
                        </a>
                        </div>
                       <br>
                    </td>
                </tr>
            	<tr>
                	<td>
						<div class="divClic" style="width:99%;">
                        &nbsp;&nbsp;&nbsp;
                    	<a href="reportes/dinamico_cobranzapendiente.php" target="_blank" class="TextoTitulosSecciondivClic">
                        	&bull; Reporte Cobranza Pendiente
                        </a>
                        </div>
                       <br>
                    </td>
                </tr>
            	<tr>
                	<td>
						<div class="divClic" style="width:99%;">
                        &nbsp;&nbsp;&nbsp;
                    	<a href="reportes/dinamico_comisiones_liquidadas_acumuladas.php" target="_blank" class="TextoTitulosSecciondivClic">
                        	&bull; Reporte Comisiones Liquidadas Acumuladas
                        </a>
                        </div>
                       <br>
                    </td>
                </tr>
            	<tr>
                	<td>
						<div class="divClic" style="width:99%;">
                        &nbsp;&nbsp;&nbsp;
                    	<a href="reportes/dinamico_produccion.php" target="_blank" class="TextoTitulosSecciondivClic">
                        	&bull; Reporte Produccion
                        </a>
                        </div>
                       <br>
                    </td>
                </tr>
            </table>
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
	Calendar.setup({
		inputField : "fechaInicioPolCan",
		trigger    : "fechaInicioPolCan_Btn",
		onSelect   : function() { this.hide() },
		dateFormat : "%Y-%m-%d"
	});
	Calendar.setup({
		inputField : "fechaFinPolCan",
		trigger    : "fechaFinPolCan_Btn",
		onSelect   : function() { this.hide() },
		dateFormat : "%Y-%m-%d"
	});
	Calendar.setup({
		inputField : "fechaInicioCotEmi",
		trigger    : "fechaInicioCotEmi_Btn",
		onSelect   : function() { this.hide() },
		dateFormat : "%Y-%m-%d"
	});
	Calendar.setup({
		inputField : "fechaFinCotEmi",
		trigger    : "fechaFinCotEmi_Btn",
		onSelect   : function() { this.hide() },
		dateFormat : "%Y-%m-%d"
	});
	Calendar.setup({
		inputField : "fechaInicioComiPen",
		trigger    : "fechaInicioComiPen_Btn",
		onSelect   : function() { this.hide() },
		dateFormat : "%Y-%m-%d"
	});
	Calendar.setup({
		inputField : "fechaFinComiPen",
		trigger    : "fechaFinComiPen_Btn",
		onSelect   : function() { this.hide() },
		dateFormat : "%Y-%m-%d"
	});
	
	Calendar.setup({
		inputField : "fechaInicioActi",
		trigger    : "fechaInicioActi_Btn",
		onSelect   : function() { this.hide() },
		dateFormat : "%Y-%m-%d"
	});
	Calendar.setup({
		inputField : "fechaFinActi",
		trigger    : "fechaFinActi_Btn",
		onSelect   : function() { this.hide() },
		dateFormat : "%Y-%m-%d"
	});
	
	Calendar.setup({
		inputField : "fechaInicioActiTodos",
		trigger    : "fechaInicioActiTodos_Btn",
		onSelect   : function() { this.hide() },
		dateFormat : "%Y-%m-%d"
	});
	Calendar.setup({
		inputField : "fechaFinActiTodos",
		trigger    : "fechaFinActiTodos_Btn",
		onSelect   : function() { this.hide() },
		dateFormat : "%Y-%m-%d"
	});

	Calendar.setup({
		inputField : "fechaInicioLlamadasCitas",
		trigger    : "fechaInicioLlamadasCitas_Btn",
		onSelect   : function() { this.hide() },
		dateFormat : "%Y-%m-%d"
	});
	Calendar.setup({
		inputField : "fechaFinLlamadasCitas",
		trigger    : "fechaFinLlamadasCitas_Btn",
		onSelect   : function() { this.hide() },
		dateFormat : "%Y-%m-%d"
	});

</script>