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
		<td>
			<?php require('reportes/dinamico_comisionespl.php'); ?>
        </td>
    </tr>
	<tr>
    	<td>&nbsp;</td>
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
</script>