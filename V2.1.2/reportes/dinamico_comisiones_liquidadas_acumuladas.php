<?php
require_once("../config/config.php");
require_once("../phpGrid_Professional/conf.php");      

switch($Nivel){ // New Version
//---- Sin Filtro --------------------//				
	case '5': // NIVEL 5
		$sqlFiltroNivel = "
						  ";
	break;
				
//---- Filtra Sucursal --------------------//
	case '4': // NIVEL 4
		$sqlFiltroNivel = "
			`sucursal` Like '%$Sucursal%'
						  ";
	break;
				
//---- Filtra Vendedor y Promotor --------------------//
	case '3': // NIVEL 3
		$sqlFiltroNivel = "
				`clave_vendedor` Like '%$Vendedor%'
				Or
				`clave_vendedor` Like '%$Promotor%'
						  ";
	break;

//---- Filtra Vendedor --------------------//
	case '2': // NIVEL 2
		$sqlFiltroNivel = "
				`clave_vendedor` Like '%$Vendedor%'
						  ";				
	break;
}

$sqlConsulta = "
	Select 
		`clave_vendedor`
		, `vendedor_nombre`
		, `mes`
		, `anio`
		, `importe`
		, `meta`
		, `sucursal`
		, `sucursal_nombre`
	From 
		`comisionesacum`
			   ";

$dg = new C_DataGrid($sqlConsulta, "clave_vendedor", "Reporte_Comisiones_Liquidadas_Acumuladas");
//$dg -> set_query_filter($sqlFiltroNivel);
		
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
/*
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
/
}
*/
</script>
</head>
<body topmargin="0" leftmargin="0" rightmargin="0"> 
<table cellpadding="2" cellspacing="2" align="center">
	<tr>
    	<td>
<?php
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
//-->$dg -> set_col_hidden("idProduccion");
//-->$dg -> set_col_hidden("clave_vendedor");
//-->$dg -> set_col_hidden("sucursal");


// change column titles
$dg->set_col_title("sucursal_nombre", "Sucursal");
$dg->set_col_title("vendedor_nombre", "Vendedor");
/*
// change column whidth
$dg -> set_col_width('SUCURSAL',60);
*/

// change column format
$dg -> set_col_currency("importe", "$", "", "", 0, "0.00");

//$dg->set_conditional_value("CLIENTE", "=='100147'", array("TCellStyle"=>"tstyle", "FCellStyle"=>"fstyle"));
//$dg->set_col_customrule('CLIENTE', 'price_validation1');

$dg -> display();  
?>
        </td>
    </tr>
</table>
</body>
</html>