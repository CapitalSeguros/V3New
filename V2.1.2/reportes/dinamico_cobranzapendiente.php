<?php
require_once("../config/config.php");
require_once("../phpgrid_professional/conf.php");

switch($Nivel){ // New Version
//---- Sin Filtro --------------------//				
	case '5': // NIVEL 5
		$sqlFiltroNivel = "
			`SUCURSAL` Like '%%'		
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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<body topmargin="0" leftmargin="0" rightmargin="0"> 
<table cellpadding="2" cellspacing="2" align="center">
	<tr>
    	<td>
<?php
$sqlConsulta_dg = "
	Select	 
		`idCobranzaPendiente`
		, Concat('Agregar Comentario') As `agregarComentario`
		, Concat('Agregar Pago') As `agregarPago`
		, `poliza`
		, `poliza` As `buscadorPolizaCliente`
		, `poliza` As `POLIZA`
		, `endoso`
		, `SUCURSAL_NOMBRE`
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

$dg = new C_DataGrid($sqlConsulta_dg, array("idCobranzaPendiente", "poliza"), "cobranzapendiente");

$dg -> set_query_filter($sqlFiltroNivel);
$dg -> set_sortname('vencimiento', 'ASC');

// hide a column
$dg -> set_col_hidden("idCobranzaPendiente");
$dg -> set_col_hidden("color_linea");

$dg -> set_col_title("agregarComentario", " ");
$dg -> set_col_title("agregarPago", " ");
$dg -> set_col_title("poliza", "Poliza");
$dg -> set_col_title("endoso", "Endoso");
$dg -> set_col_title("SUCURSAL_NOMBRE", "Sucursal");
$dg -> set_col_title("CLIENTE_NOMBRE", "Cliente");
$dg -> set_col_title("VENDEDOR_NOMBRE", "Vendedor");
$dg -> set_col_title("aseguradora", "Aseguradora");
$dg -> set_col_title("condicion_pago", "Condicion Pago");
$dg -> set_col_title("Numero_Recibo", "No. Recibo");
$dg -> set_col_title("inicio_vigencia", "Inicio Vigencia");
$dg -> set_col_title("fin_vigencia", "Fin Vigencia");
$dg -> set_col_title("vencimiento", "Vencimiento");
$dg -> set_col_title("importe", "Importe");
$dg -> set_col_title("subgrupo", "SubGrupo");
$dg -> set_col_title("subramo", "SubRamo");
$dg -> set_col_title("conducto_cobro", "Conducto Cobro");

$dg->set_multiselect(true);
$dg ->enable_search(true);
$dg->enable_export('EXCEL'); //PDF
//** $dg -> set_locale("sp");

$sqlConsulta_dg = "
	SELECT 
		`poliza`
		,`tipoComentario`
		,`fecha`
		,`fechaProgramada`
		,`comentarioMuestra`
		-- ,`origen`		
		,`operador`
		,`operadorNombre`
	FROM 
		`cobranzapendiente_comentarios`
				  ";
$sdg = new C_DataGrid($sqlConsulta_dg, array("poliza"), "cobranzapendiente_comentarios");

//**-- $sdg -> set_query_filter($sqlFiltroNivel);
$sdg -> set_sortname('fecha', 'DESC');

// hide a column
$sdg -> set_col_hidden("poliza");

$sdg -> set_col_title("tipoComentario", "Tipo");
$sdg -> set_col_title("fecha", "Fecha Creaci&oacute;n");
$sdg -> set_col_title("fechaProgramada", "Fecha Programada");
$sdg -> set_col_title("comentarioMuestra", "Comentario");
$sdg -> set_col_title("operador", "Usuario");

//** $sdg -> set_col_width("comentarioMuestra", 1200);
//** $sdg -> set_col_edit_dimension("comentarioMuestra", 800);
//** $sdg -> set_col_edit_dimension("comentarioMuestra", 800, 10);
//** $sdg ->set_form_dimension('800px');

//**-- $sdg->enable_edit("FORM", "R");

//** $dg->set_masterdetail($sdg, 'poliza');
$dg->set_subgrid($sdg, 'poliza');

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

//**  verPoliza
		$dg -> set_col_dynalink("poliza", "verPoliza.php", "POLIZA", '&tipoImg=CARATULA', "_blank");
		
//**  addCotizacion
	$urlAddComentario = "&Actividad=comentarioCobranza";
	$urlAddComentario.= "&usuarioCreacion=";
		$dg -> set_col_dynalink("agregarComentario", "../actividadesAgregar.php", array("poliza"), $urlAddComentario, "_blank");

//**  addCotizacion
	$urlAddPago = "&Actividad=Pago+Cobranza";
	$urlAddPago.= "&usuarioCreacion=";
		
		$dg -> set_col_dynalink("agregarPago", "../actividadesAgregar.php", array("poliza", "buscadorPolizaCliente"), $urlAddPago, "_blank");
// enable resize by dragging mouse
$dg -> enable_resize(true); 

// set height and weight of datagrid
$dg -> set_dimension(950, 480, false);

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