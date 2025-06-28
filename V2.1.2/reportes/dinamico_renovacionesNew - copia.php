<?php
require_once("../config/config.php");
require_once('../config/funcionesDre.php');
require_once("../phpgrid_professional/conf.php");

$conex = DreConectarDB();

switch($Nivel){ // New Version
//---- Sin Filtro --------------------//				
	case '5': // NIVEL 5
		if(isset($_REQUEST['mes'])){
			$sqlFiltroNivel = "
				`MES` Like '%".$_REQUEST['mes']."%'
				And
				`SUCURSAL` Like '%$Sucursal%'		
							  ";
		} else {
			$sqlFiltroNivel = "
				`SUCURSAL` Like '%$Sucursal%'		
							  ";
		}
	break;
				
//---- Filtra Sucursal --------------------//
	case '4': // NIVEL 4
		if(isset($_REQUEST['mes'])){
			$sqlFiltroNivel = "
				`MES` Like '%".$_REQUEST['mes']."%'
				And
				`SUCURSAL` Like '%$Sucursal%'
							  ";
		} else {
			$sqlFiltroNivel = "
				`SUCURSAL` Like '%$Sucursal%'
							  ";
		}
	break;
				
//---- Filtra Vendedor y Promotor --------------------//
	case '3': // NIVEL 3
		if(isset($_REQUEST['mes'])){
		$sqlFiltroNivel = "
				`MES` Like '%".$_REQUEST['mes']."%'
				And
				(
				`VENDEDOR` Like '%$Vendedor%'
				Or
				`CONSULTOR` Like '%$Promotor%'
				)
						  ";
		} else {
		$sqlFiltroNivel = "
				`VENDEDOR` Like '%$Vendedor%'
				Or
				`CONSULTOR` Like '%$Promotor%'
						  ";
		}
	break;

//---- Filtra Vendedor --------------------//
	case '2': // NIVEL 2
		if(isset($_REQUEST['mes'])){
		$sqlFiltroNivel = "
				`MES` Like '%".$_REQUEST['mes']."%'
				And
				`VENDEDOR` Like '%$Vendedor%'
						  ";
		} else {
		$sqlFiltroNivel = "
				`VENDEDOR` Like '%$Vendedor%'
						  ";
		}
	break;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Reportes Dinamicos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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
}
</script>
</head>
<body topmargin="0" leftmargin="0" rightmargin="0"> 
<table cellpadding="2" cellspacing="2" align="center">
<form name="formMesMuestra" id="formMesMuestra" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
	<tr>
    	<td>
        	<select name="mes" id="mes" onchange="submit();">
            	<option value="">Todos Meses</option>
                <?
					$sqlMesesMuestra = "
						Select `MES` From 
							`renovaciones`
						Group By
							`mesOrden`
						Order By
							`mesOrden` Desc
									   ";
					$resMesesMuestra = DreQueryDB($sqlMesesMuestra);
					while($rowMesesMuestra = mysql_fetch_assoc($resMesesMuestra)){
				?>
            	<option value="<? echo $rowMesesMuestra['MES']; ?>" <? echo ($rowMesesMuestra['MES'] == $mes)? "selected" : ""; ?>>
					<? echo $rowMesesMuestra['MES']; ?>
                </option>
                <?
					}
				?>
            </select>
        </td>
    </tr>
</form>
	<tr>
    	<td>
<?php
$sqlConsulta = "
	Select	 
		`idRenovacion`		
		
		, Concat('Seleccione') As `addCambio`
				
		, Concat('Cambio') As `addCotizacion`
		, Concat('Diligencia') As `addDiligencia`
		, Concat('Enviar') As `addEnviar`
		
		, `POLIZA`
		, `POLIZA_RENOVACION`
		, `ASEGURADORA`
		, `ASEGURADORA_NOMBRE`
		, `CLIENTE`
		, `CLIENTE_NOMBRE`
		, `INICIO`
		, `FIN_VIGENCIA`
		, `PRIMA_ANTERIOR`
		, `PRIMA_RENOVACION`
		
		, `SUCURSAL_NOMBRE`
		, `SUCURSAL`
		, `VENDEDOR`
		, `VENDEDOR_NOMBRE`
		, `CONSULTOR`
		, `CONSULTOR_NOMBRE`
		, `SUBRAMO`
		, `SUBRAMO_NOMBRE`
		, `MES`
		
		, `COND_PAGO`
		, `COND_PAGO_NOMBRE`
		, `ESTATUS`
		, `ESTATUS_ENTREGA`
		, `DESCRIPCION`
		, `MODELO`
		, `NO_SERIE`
		, `ORIGEN`
		, `colorLinea`
	From 
		`renovaciones`
			   ";

$dg = new C_DataGrid($sqlConsulta, "idRenovacion", "renovaciones");
$dg -> enable_edit("INLINE", "RU"); // CRUD || ->C=Create ->R=Review ->U=Update ->D=Delete

// Filtro de sql
$dg -> set_query_filter($sqlFiltroNivel);

// Orden de sql
$dg -> set_sortname('MES', 'ASC');

// Titulo del Grid
$dg -> set_caption("Control de Renovaciones");

// 
$dg -> set_col_readonly("POLIZA
							,POLIZA_RENOVACION
							,ASEGURADORA_NOMBRE
							,CLIENTE_NOMBRE
							,INICIO
							,FIN_VIGENCIA
							,PRIMA_ANTERIOR
							,PRIMA_RENOVACION
							,VENDEDOR_NOMBRE
							,CONSULTOR_NOMBRE
							,SUBRAMO_NOMBRE
							,MES
							,addCotizacion
							,addDiligencia
							,addEnviar");

//**--
$dg -> set_col_edittype("addCambio", "select", "C:Cotizacion; E:Emision; EN:Endoso; CA:Cancelacion; S:Siniestros", false);

// Columnas Ocultas
$dg -> set_col_hidden("idRenovacion");
$dg -> set_col_hidden("SUCURSAL");
$dg -> set_col_hidden("VENDEDOR");
$dg -> set_col_hidden("CONSULTOR");
$dg -> set_col_hidden("CLIENTE");
$dg -> set_col_hidden("ASEGURADORA");
$dg -> set_col_hidden("COND_PAGO");

$dg -> set_col_hidden("COND_PAGO_NOMBRE");
$dg -> set_col_hidden("ESTATUS");
$dg -> set_col_hidden("ESTATUS_ENTREGA");
$dg -> set_col_hidden("DESCRIPCION");
$dg -> set_col_hidden("MODELO");
$dg -> set_col_hidden("NO_SERIE");
$dg -> set_col_hidden("ORIGEN");
$dg -> set_col_hidden("SUBRAMO");

$dg -> set_col_hidden("SUCURSAL_NOMBRE");
$dg -> set_col_hidden("colorLinea");

// Cambiar Nombre de la Columna
$dg -> set_col_title("POLIZA", "P&oacute;liza");
$dg -> set_col_title("POLIZA_RENOVACION", "P&oacute;liza Renovaci&oacute;n");
$dg -> set_col_title("ASEGURADORA_NOMBRE", "Aseguradora");
$dg -> set_col_title("CLIENTE_NOMBRE", "Cliente");
$dg -> set_col_title("INICIO", "Inicio");
$dg -> set_col_title("FIN_VIGENCIA", "Fin");
$dg -> set_col_title("PRIMA_ANTERIOR", "Prima");
$dg -> set_col_title("PRIMA_RENOVACION", "Prima Renovaci&oacute;n");
$dg -> set_col_title("VENDEDOR_NOMBRE", "Vendedor");
$dg -> set_col_title("CONSULTOR_NOMBRE", "Consultor");
$dg -> set_col_title("SUBRAMO_NOMBRE", "SubRamo");
$dg -> set_col_title("MES", "Mes");

$dg -> set_col_title("addCambio", "Cambio"); // Campo Solicitado Carlos
$dg -> set_col_title("addCotizacion", "Cambio");
$dg -> set_col_title("addDiligencia", "Diligencia");
$dg -> set_col_title("addEnviar", "Enviar");

// change column format
$dg -> set_col_currency("PRIMA_ANTERIOR", "$", "", ",", 2, "0.00");
$dg -> set_col_currency("PRIMA_RENOVACION", "$", "", ",", 2, "0.00");

// change column whidth
$dg -> set_col_width('addCambio',90);
$dg -> set_col_width('addCotizacion',40);
$dg -> set_col_width('addDiligencia',50);
$dg -> set_col_width('addEnviar',40);

$dg -> set_col_width('POLIZA',95);
$dg -> set_col_width('POLIZA_RENOVACION',95);

// Campos Con LinkDinamico
$dg -> set_col_dynalink("POLIZA", "verPoliza.php", "POLIZA", '&tipoImg=CARATULA', "_new");
$dg -> set_col_dynalink("POLIZA_RENOVACION", "verPoliza.php", "POLIZA_RENOVACION", '&tipoImg=CARATULA', "_new");

//** 
	//$urlAddEnviar= "";
		//$dg -> set_col_dynalink("addCambio", "../actividadesAgregar.php", array("POLIZA", "POLIZA_RENOVACION","CLIENTE","SUBRAMO"), $urlAddEnviar, "_new");

//**
	$urlAddCotizacion = "&Actividad=Cotizaci%F3n";
	$urlAddCotizacion.= "&usuarioCreacion=";
	$urlAddCotizacion.= "&tipoCliente=SEARCH";

		$dg -> set_col_dynalink("addCotizacion", "../actividadesAgregar.php", array("POLIZA", "POLIZA_RENOVACION", "CLIENTE","SUBRAMO"), $urlAddCotizacion, "_new");
		
//**
	$urlAddDiligencia = "&Actividad=Diligencias";
	$urlAddDiligencia.= "&usuarioCreacion=";

		$dg -> set_col_dynalink("addDiligencia", "../actividadesAgregar.php", array("POLIZA", "POLIZA_RENOVACION", "CLIENTE","SUBRAMO"), $urlAddDiligencia, "_new");

//** 
	$urlAddEnviar= "";
		$dg -> set_col_dynalink("addEnviar", "../clienteEnviarCorreo.php", array("POLIZA", "POLIZA_RENOVACION","CLIENTE","SUBRAMO"), $urlAddEnviar, "_new");
		
// Complementos Dinamicos
$dg -> enable_search(true);
$dg -> enable_export('EXCEL'); //PDF
//** $dg -> set_locale('sp');
//** $dg -> set_locale('es');

// enable resize by dragging mouse
$dg -> enable_resize(true); 

// set height and weight of datagrid
$dg -> set_dimension(950, 480, false); 

// use vertical scroll to load data
//$dg -> set_scroll(true);

// Use this method to set datagrid width as the same as the current window width
//$dg -> enable_autowidth(true);

// Format a row based on the specified condition

$dg->set_conditional_format("colorLinea","ROW",array("condition"=>"cn","value"=>"BLANCO","css"=> 
																					array(
																						"color"=>"black",
																						"background-color"=>"#FFFFFF"
																					)));
$dg->set_conditional_format("colorLinea","ROW",array("condition"=>"cn","value"=>"AZUL","css"=> 
																					array(
																						"color"=>"#FFFFFF",
																						"background-color"=>"#0000FF"
																					)));
$dg->set_conditional_format("colorLinea","ROW",array("condition"=>"cn","value"=>"ROJO","css"=> 
																					array(
																						"color"=>"black",
																						"background-color"=>"#FF0000"
																					)));
$dg->set_conditional_format("colorLinea","ROW",array("condition"=>"cn","value"=>"VERDE","css"=> 
																					array(
																						"color"=>"black",
																						"background-color"=>"#00FF00"
																					)));
$dg->set_conditional_format("colorLinea","ROW",array("condition"=>"cn","value"=>"AMARILLO","css"=> 
																					array(
																						"color"=>"black",
																						"background-color"=>"#FFFF00"
																					)));
$dg->set_conditional_format("colorLinea","ROW",array("condition"=>"cn","value"=>"NARANJA","css"=> 
																					array(
																						"color"=>"black",
																						"background-color"=>"#FF9900"
																					)));

$dg->set_multiselect(true);

$dg->display();  
?>
        </td>
    </tr>
    <tr>
    	<td>
<!-- 
## RE : Renovada : Azul
## CA : Cancelada : Rojo
## PE : Pendiente : Blanco
## EN : Enviado Oficina : Verde
## TR : Traspaso Cartera : Amarrillo
## PA : Pendiente Autorizacion : Cafe
-->
        	<table cellpadding="2" cellspacing="2" style="color:#000;">
            	<tr>
                	<td bgcolor="#FFFFFF" style="border:#CCC solid 1px;">
                    	Pendientes
                    </td>
                	<td bgcolor="#0000FF" style="border:#CCC solid 1px; color:#CCC;">
                    	Renovadas
                    </td>
                	<td bgcolor="#FF0000" style="border:#CCC solid 1px;">
                    	Canceladas
                    </td>
                	<td bgcolor="#00FF00" style="border:#CCC solid 1px;">
                    	Enviadas Aseguradora
                    </td>
                	<td bgcolor="#FFFF00" style="border:#CCC solid 1px;">
                    	Traspaso Cartera
                    </td>
                	<td bgcolor="#FF9900" style="border:#CCC solid 1px;">
                    	Pendiente Autorizacion Cliente
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<?php
DreDesconectarDB($conex);
?>
</body>
</html>