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
		`idCobranzaPendiente`
		, `poliza`
		, `endoso`
		, `CLIENTE_NOMBRE`
		, `VENDEDOR_NOMBRE`
		, `aseguradora`
		, `condicion_pago`
		, `Numero_Recibo`
		, `inicio_vigencia`
		, `fin_vigencia`
		, `vencimiento`
		, `importe`
		, `subgrupo`
		, `subramo`
		, `conducto_cobro`
		, `color_linea`
	From 
		`cobranzapendiente`
			   ";

$dg = new C_DataGrid($sqlConsulta, "idCobranzaPendiente", "cobranzapendiente");
$dg -> set_query_filter("CLIENTE_NOMBRE!=''");
$dg -> set_sortname('vencimiento', 'ASC');

// 2nd grid as detail grid
$sdg = new C_DataGrid("SELECT * FROM `cobranzapendiente_comentarios`", array("poliza"), "Reporte_Cobranza_Pendiente_Comentario");
$sdg -> enable_edit("INLINE", "C"); // CRUD || ->C=Create ->R=Review ->U=Update ->D=Delete
$sdg -> set_col_required("poliza");
//--> $sdg->set_col_wysiwyg('comentario');
//-->$sdg -> set_col_date("fechaComentario", "Y-m-d", "n/j/Y", "yy-mm-dd");
//-->$sdg->set_col_edittype('comentario', 'textarea')->set_col_wysiwyg('comentario');
//--->$sdg->set_conditional_value("poliza", "==1", array("TCellValue"=>"ok","FCellValue"=>"no"));

/*
$col_poliza = <<<COLPOLIZA
function(rowObject){
    var n1 = parseInt(rowObject[0],10);
    return n1;
}
COLPOLIZA;
*/


// orderId exists in both master table(Orders) and detail table(OrderDetails)
//-->$dg -> set_masterdetail($sdg, 'poliza');
//-->$dg -> setCallBack('rowObject[0]');



//$sdg -> set_col_edittype("poliza", "select", "1:San Francisco;2:Boston;3:NYC", false);
//$sdg -> set_col_edittype("poliza", "checkbox", "1:0");
$polizaComentario = "8191977"; //$col_poliza; //array("poliza"); // $_grid_cobranzapendiente['poliza']; // //parsestring
//$dg -> setCallBack('8191977');

/*
<script>rowObject[0]</script>
$col_formatter = <<<COLFORMATTER
function(cellvalue, options, rowObject){
    var n1 = parseInt(rowObject[0],10);
    return n1;
}
COLFORMATTER;
*/

/*
$sdg -> add_column(
        'polizaNew', 
        array('name'=>'polizaNew', 
            'index'=>'polizaNew', 
            'width'=>'360', 
            'align'=>'right', 
            'sortable'=>false,
            'formatter'=>$col_formatter),
        'Poliza (Virtual)');
*/
/*
$sdg -> add_column('polizaNew', 
					array('name'=>'polizaNew', 
        		    'index'=>'polizaNew', 
		            'width'=>'360', 
		            'align'=>'right', 
		            'sortable'=>false,
		            'formatter'=>$col_poliza), 
				'Poliza (Virtual)');
*/
//--> $sdg -> set_col_edittype("poliza", "select", "Select `poliza`, `poliza` from `cobranzapendiente_comentarios` Where `poliza` = '".$polizaComentario."' Group By `poliza` ",false);
$sdg -> set_col_edittype("poliza", "text", $polizaComentario, false);
$sdg -> set_col_readonly("fechaComentario");
//$sdg -> set_col_readonly("poliza");
//$sdg -> set_col_hidden("poliza");

$dg->set_subgrid($sdg, 'poliza');

// hide a column
$dg -> set_col_hidden("idCobranzaPendiente");
$dg -> set_col_hidden("color_linea");

$dg ->enable_search(true);
//$dg->enable_advanced_search(true);
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
$dg->set_col_title("SUCURSAL", "Sucursal");

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