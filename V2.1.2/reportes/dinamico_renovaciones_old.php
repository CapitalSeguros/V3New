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
			`SUCURSAL` Like '%$Sucursal%'
						  ";
	break;
				
//---- Filtra Vendedor y Promotor --------------------//
	case '3': // NIVEL 3
		$sqlFiltroNivel = "
				`VENDEDOR` Like '%$Vendedor%'
				Or
				`CONSULTOR` Like '%$Promotor%'
						  ";
	break;

//---- Filtra Vendedor --------------------//
	case '2': // NIVEL 2
		$sqlFiltroNivel = "
				`VENDEDOR` Like '%$Vendedor%'
						  ";				
	break;
}

$sqlConsulta = "
	Select	 
		`idRenovacion`
		,`SUCURSAL`
		,`EMISION`
		,`POLIZA`
		,`ENDOSO`
		,`RAMO`
		,`SUBRAMO`
		,`DESCRIPCION`
		,`MODELO`
		,`NoSERIE`
		,`VENDEDOR`
		,`CONSULTOR`
		,`ASEGURADORA`
		,`GRUPO`
		,`SUBGRUPO`
		,`CLIENTE`
		,`PERSONA_F_M`
		,`COND_PAGO`
		,`CONDUCTO_COBRO`
		,`INICIO`
		,`FIN`
		,`PRIMA_NETA`
		,`RECARGO`
		,`GASTOS`
		,`IVA`
		,`PRIMA_TOTAL`
		,`PRIMA_NETA_COMISION`
		,`RECARGO_COMISION`
		,`GASTOS_COMISION`
		,`TOTAL_COMISION`
		,`COMENTARIOS`
		,`CLIENTE_NOMBRE`
		,`VENDEDOR_NOMBRE`
		,`CONSULTOR_NOMBRE`
	From 
		`renovaciones`
			   ";

$dg = new C_DataGrid($sqlConsulta, "idRenovacion", "renovacion");
$dg -> set_query_filter($sqlFiltroNivel);
$dg -> set_sortname('FIN', 'ASC');
$dg -> set_col_hidden("SUCURSAL");
$dg -> set_col_title("SUCURSAL_NOMBRE", "Sucursal");

/*
echo "<pre>";
	echo $sqlConsulta;
	echo "<br />";
	echo $sqlFiltroNivel;
echo "</pre>";
*/

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
// 2nd grid as detail grid
$sdg = new C_DataGrid("Select * From `cobranzapendiente_comentarios`", array("poliza"), "Reporte_Cobranza_Pendiente_Comentario");

$sdg -> enable_edit("INLINE", "C"); // CRUD || ->C=Create ->R=Review ->U=Update ->D=Delete
$sdg -> set_col_required("poliza");
$sdg -> set_col_readonly("idComentario, fecha, status");
$sdg -> set_col_hidden("status");
$sdg -> set_col_hidden("idComentario");


$polizaComentario = ""; //--> "8191977"
$sdg -> set_col_edittype("poliza", "text", $polizaComentario, false);
$sdg -> set_col_edittype("origen", "select", "R:Renovacion; G:Cobranza", false);
$sdg -> set_col_edittype("operador", "text", $_SESSION['WebDreTacticaWeb2']['Usuario'], false);

$sdg -> set_col_title("poliza", "Poliza");
$sdg -> set_col_title("origen", "Ubicacion");
$sdg -> set_col_title("operador", "Usuario");
$sdg -> set_col_title("comentario", "Comentario");
$sdg -> set_col_title("fecha", "Fecha");


// The method displays inline and read-only detail grid rather than in separate datagrid table
$dg->set_subgrid($sdg, 'poliza');

// hide a column
$dg -> set_col_hidden("idRenovacion");
$dg -> set_col_hidden("color_linea");

$dg ->enable_search(true);
$dg->enable_export('EXCEL'); //PDF
$dg -> set_locale("sp");

// enable resize by dragging mouse
$dg -> enable_resize(true); 

// set height and weight of datagrid
$dg -> set_dimension(950, 480, false); 

// use vertical scroll to load data
//$dg -> set_scroll(true);

// Use this method to set datagrid width as the same as the current window width
//$dg -> enable_autowidth(true);

// change column titles
//-->$dg->set_col_title("SUCURSAL", "Sucursal");

// change column whidth
//--> $dg -> set_col_width('SUCURSAL',60);

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

// Format a row based on the specified condition
$dg->set_conditional_format("color_linea","ROW",array("condition"=>"cn","value"=>"AZUL","css"=> 
																					array(
																						"color"=>"#FFFFFF",
																						"background-color"=>"#0000FF"
																					)));
$dg->set_conditional_format("color_linea","ROW",array("condition"=>"cn","value"=>"ROJO","css"=> 
																					array(
																						"color"=>"black",
																						"background-color"=>"#FF0000"
																					)));
$dg->set_conditional_format("color_linea","ROW",array("condition"=>"cn","value"=>"AMARILLO","css"=> 
																					array(
																						"color"=>"black",
																						"background-color"=>"#FFFF00"
																					)));
$dg->set_conditional_format("color_linea","ROW",array("condition"=>"cn","value"=>"VERDE","css"=> 
																					array(
																						"color"=>"black",
																						"background-color"=>"#00FF00"
																					)));
                      
$dg->set_multiselect(true);

$dg->display();  
?>
        </td>
    </tr>
    <tr>
    	<td>
        	<table cellpadding="2" cellspacing="2" border="0">
            	<tr>
                	<td bgcolor="#0000FF">&nbsp;</td>
                    <td>Canceladas</td>
                	<td bgcolor="#FF0000">&nbsp;</td>
                    <td>Apunto de Cancelar</td>
                	<td bgcolor="#FFFF00">&nbsp;</td>
                    <td>A 20 d&iacute;as de Cancelar</td>
                	<td bgcolor="#00FF00">&nbsp;</td>
                    <td>A 30 d&iacute;as de Cancelar</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>