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
<title>Reportes Renovaciones</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<style>
	.tstyle{
		display:block;background-image:none;
		margin-right:-2px;
		margin-left:-2px;
		height:14px;padding:5px;
		background-color:green;
		color:navy;
		font-weight:bold;
	}
	.fstyle{ 
		display:block;
		background-image:none;
		margin-right:-2px;
		margin-left:-2px;
		height:14px;
		padding:5px;
		background-color:yellow;
		color:navy;
	}
</style>
</head>
<body topmargin="0" leftmargin="0" rightmargin="0"> 
<table cellpadding="2" cellspacing="2" align="center">
	<tr>
    	<td>
<?php
	$sqlConsulta = "
		Select
			`idRenovacion`
			, `SUCURSAL_NOMBRE`
			, `SUCURSAL`
			, `POLIZA`
			, `VENDEDOR`
			, `VENDEDOR_NOMBRE`
			, `CONSULTOR`
			, `CONSULTOR_NOMBRE`
			, `ASEGURADORA`
			, `ASEGURADORA_NOMBRE`
			, `CLIENTE`
			, `CLIENTE_NOMBRE`
			, `COND_PAGO`
			, `COND_PAGO_NOMBRE`
			, `INICIO`
			, `FIN_VIGENCIA`
			, `PRIMA_ANTERIOR`
			, `PRIMA_RENOVACION`
			, `POLIZA_RENOVACION`
			, `ESTATUS`
			, `ESTATUS_ENTREGA`
			, `SUBRAMO`
			, `DESCRIPCION`
			, `MODELO`
			, `NO_SERIE`
			, `ORIGEN`
			, `MES`
			, `colorLinea`
		From 
			`renovaciones`
				   ";
//<--	$dg = new C_DataGrid($sqlConsulta, "idRenovacion", "renovacion");

//suppliers master-detail
$sg = new C_DataGrid("Select `MES` From `renovaciones` Group By `MES`",  "MES", "MES");
//** $sg = new C_DataGrid("SELECT * FROM suppliers","supplierCode","suppliers");
$sg->set_sql_key("MES");
 
//supplier detail 1: product lines
//** $sg_d1 = new C_DataGrid("SELECT * FROM supplierproductlines","supplierCode","supplierproductlines");
$sg_d1 = new C_DataGrid("Select * From `renovaciones`","MES","MES");
 
$sg->set_masterdetail($sg_d1, 'MES');
 
$sg->display();

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