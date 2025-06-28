<?php
require_once("../phpGrid_Professional/conf.php");      

$sqlFiltroNivel = "";
		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reportes Dinamicos</title>
<style>
.tstyle
{
display:block;background-image:none;margin-right:-2px;margin-left:-2px;height:14px;padding:5px;background-color:green;color:navy;font-weight:bold
}
.fstyle
{ 
display:block;background-image:none;margin-right:-2px;margin-left:-2px;height:14px;padding:5px;background-color:yellow;color:navy
}
</style>
<script>
function price_validation1(value, colname) {

	if(value < 99878){
       return [false,colname + " must be zero a positive integer."];
    }
    return [true, ""];
/*
	if(value == '100147'){ 
		return [true,"no"];
	}else{
		return [falses, "ok"];
	}
*/	
}
</script>
</head>
<body topmargin="0" leftmargin="0" rightmargin="0"> 
<table cellpadding="2" cellspacing="2" align="center">
	<tr>
    	<td>
<?php

$sqlConsulta = "
	Select 
		`idRenovacion`
		, `SUCURSAL`
		, `EMISION`
		, `POLIZA`
		, `ENDOSO`
		, `RAMO`
		, `SUBRAMO`
		, `DESCRIPCION`
		, `MODELO`
		, `NoSERIE`
		, `VENDEDOR_NOMBRE`
		, `CONSULTOR_NOMBRE`
		, `ASEGURADORA`
		, `GRUPO`
		, `SUBGRUPO`
		, `CLIENTE_NOMBRE`
		, `PERSONA_F_M`
		, `COND_PAGO`
		, `CONDUCTO_COBRO`
		, `INICIO`
		, `FIN`
		, `PRIMA_NETA`
		, `RECARGO`
		, `GASTOS`
		, `IVA`
		, `PRIMA_TOTAL`
		, `PRIMA_NETA_COMISION`
		, `RECARGO_COMISION`
		, `GASTOS_COMISION`
		, `TOTAL_COMISION`
		, `COMENTARIOS`
	From 
		`renovaciones`
			   ";

$dg = new C_DataGrid($sqlConsulta, "idRenovacion", "Reporte_Renovaciones");
$dg -> set_query_filter("CLIENTE_NOMBRE!=''");

$dg ->enable_search(true);
//$dg->enable_advanced_search(true);
$dg->enable_export('EXCEL'); //PDF
//$dg -> set_locale("sp");

// enable resize by dragging mouse
$dg -> enable_resize(true); 

// set height and weight of datagrid
$dg -> set_dimension(950, 480, false); 

// use vertical scroll to load data
//$dg -> set_scroll(true);

//
//$dg -> enable_autowidth(true);

// hide a column
$dg -> set_col_hidden("idRenovacion");

// change column titles
$dg->set_col_title("SUCURSAL", "Sucursal");

/*
// change column whidth
$dg -> set_col_width('SUCURSAL',60);
$dg -> set_col_width('POLIZA',100);
$dg -> set_col_width('ENDOSO',100);
$dg -> set_col_width('CLIENTE_NOMBRE',350);
$dg -> set_col_width('RAMO',120);
$dg -> set_col_width('SUBRAMO',130);
$dg -> set_col_width('VENDEDOR_NOMBRE',200);
$dg -> set_col_width('CONSULTOR_NOMBRE',200);
$dg -> set_col_width('ASEGURADORA',250);
$dg -> set_col_width('GRUPO',100);
$dg -> set_col_width('SUBGRUPO',100);
$dg -> set_col_width('COND_PAGO',100);
$dg -> set_col_width('CONDUCTO_COBRO',100);
$dg -> set_col_width('COMENTARIO',100);
$dg -> set_col_width('RECIBO',100);
$dg -> set_col_width('INICIO',100);
$dg -> set_col_width('FIN',100);
$dg -> set_col_width('FORMA_PAGO',100);
$dg -> set_col_width('FECHA_PAGO',100);
$dg -> set_col_width('FECHA_APLIC',100);
$dg -> set_col_width('IMPORTE_PAGO',100);
$dg -> set_col_width('MONEDA',100);
$dg -> set_col_width('TC',100);
$dg -> set_col_width('PRIMA_NETA',100);
$dg -> set_col_width('RECARGO',100);
$dg -> set_col_width('GASTOS',60);
$dg -> set_col_width('IVA',60);
$dg -> set_col_width('PRIMA_TOTAL',60);
$dg -> set_col_width('PRIMA_NETA_COMISION',60);
$dg -> set_col_width('RECARGO_COMISION',60);
$dg -> set_col_width('GASTOS_COMISION',60);
$dg -> set_col_width('TOTAL_COMISION',60);
$dg -> set_col_width('PCTJE_DISPERSION_VEND',60);
$dg -> set_col_width('IMPORTE_VEND',60);
$dg -> set_col_width('LIQUIDADO_VEND',60);
$dg -> set_col_width('FECHA_LIQ_VEND',60);
$dg -> set_col_width('PENDIENTE_VEND',60);
$dg -> set_col_width('PCTJE_DISPERSION_CONS',60);
$dg -> set_col_width('IMPORTE_CONS',60);
$dg -> set_col_width('LIQUIDADO_CONS',60);
$dg -> set_col_width('FECHA_CONS',60);
$dg -> set_col_width('PENDIENTE_CONS',60);
$dg -> set_col_width('PCJTE_DISPERSION_COM',60);
$dg -> set_col_width('IMPORTE_COM',60);
$dg -> set_col_width('LIQUIDADO_COM',60);
$dg -> set_col_width('FECHA_COM',60);
$dg -> set_col_width('PENDIENTE_COM',60);
*/

// change column format
$dg -> set_col_currency("IMPORTE_PAGO", "$", "", "", 0, "0.00");
$dg -> set_col_currency("TC", "$", "", "", 0, "0.00");
$dg -> set_col_currency("PRIMA_NETA", "$", "", "", 0, "0.00");
$dg -> set_col_currency("RECARGO", "$", "", "", 0, "0.00");
$dg -> set_col_currency("GASTOS", "$", "", "", 0, "0.00");
$dg -> set_col_currency("IVA", "$", "", "", 0, "0.00");
$dg -> set_col_currency("PRIMA_TOTAL", "$", "", "", 0, "0.00");
$dg -> set_col_currency("PRIMA_NETA_COMISION", "$", "", "", 0, "0.00");
$dg -> set_col_currency("RECARGO_COMISION", "$", "", "", 0, "0.00");
$dg -> set_col_currency("GASTOS_COMISION", "$", "", "", 0, "0.00");
$dg -> set_col_currency("TOTAL_COMISION", "$", "", "", 0, "0.00");
$dg -> set_col_currency("IMPORTE_VEND", "$", "", "", 0, "0.00");
$dg -> set_col_currency("LIQUIDADO_VEND", "$", "", "", 0, "0.00");
$dg -> set_col_currency("PENDIENTE_VEND", "$", "", "", 0, "0.00");
$dg -> set_col_currency("IMPORTE_CONS", "$", "", "", 0, "0.00");
$dg -> set_col_currency("LIQUIDADO_CONS", "$", "", "", 0, "0.00");
$dg -> set_col_currency("PENDIENTE_CONS", "$", "", "", 0, "0.00");
$dg -> set_col_currency("IMPORTE_COM", "$", "", "", 0, "0.00");
$dg -> set_col_currency("LIQUIDADO_COM", "$", "", "", 0, "0.00");
$dg -> set_col_currency("PENDIENTE_COM", "$", "", "", 0, "0.00");

//$dg->set_conditional_value("CLIENTE", "=='100147'", array("TCellStyle"=>"tstyle", "FCellStyle"=>"fstyle"));
//$dg->set_col_customrule('CLIENTE', 'price_validation1');

$dg -> display();  
?>
        </td>
    </tr>
</table>
</body>
</html>