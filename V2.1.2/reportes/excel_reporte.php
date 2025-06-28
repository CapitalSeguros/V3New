<?
session_start();
	include('../config/funcionesDre.php');
	include('../includes/class.excel.writer.php');
	
	extract($_REQUEST);
	$conexion = DreConectarDB();
	
$filtroSucursal;
$filtroConsultor;
$filtroVendedor;
$filtroAseguradora;
$filtroRamo;
$filtroSubRamo;
$filtroCliente;
$filtroGrupo;
$filtroSubGrupo;
$filtroPoliza;

switch((int)$_SESSION['WebDreTacticaWeb2']['Nivel']){ // New Version
//---- Sin Filtro --------------------//				
	case '5': // NIVEL 5
	break;
	
//---- Filtra Sucursal --------------------//
	case '4': // NIVEL 4
		if($filtroSucursal == ""){ $filtroSucursal = $Sucursal; }
	break;

//---- Filtra Vendedor y Promotor --------------------//
	case '3': // NIVEL 3
		if($filtroSucursal == ""){ $filtroSucursal = "[".$_SESSION['WebDreTacticaWeb2']['Sucursal']."]"; }
		if($filtroConsultor == ""){ $filtroConsultor = "[".$_SESSION['WebDreTacticaWeb2']['Usuario']."]"; }
//		if($filtroVendedor == ""){ $filtroVendedor = "[".$_SESSION['WebDreTacticaWeb2']['Vendedor']."]"; }
	break;

//---- Filtra Vendedor --------------------//
	case '2': // NIVEL 2
		if($filtroSucursal == ""){ $filtroSucursal = "[".$_SESSION['WebDreTacticaWeb2']['Sucursal']."]"; }
		if($filtroVendedor == ""){ $filtroVendedor = "[".$_SESSION['WebDreTacticaWeb2']['Vendedor']."]"; }
	break;

}

	$quitarCosas = array('[',']');
	$ponerCosas = array('','');

	$xls = new ExcelWriter();
	
	$xls_int = array('type'=>'int','border'=>'000000');
	$xls_int_negrita = array('type'=>'int','border'=>'000000','bold'=>'true');
	$xls_date = array('type'=>'date','border'=>'000000');
	$xls_normal = array('border'=>'000000');
	$xls_normal_negrita = array('border'=>'000000','bold'=>'true');
	$xls_encabezado = array('border'=>'','color'=>'000000','bold'=>'true'); //,'background'=>'FFFFFF'
	$xls_fondoAzul = array('border'=>'000000','background'=>'538DD5','color'=>'FFFFFF');
	$xls_fondoAzulConcatenado = array('border'=>'2C48AB','background'=>'2C48AB','color'=>'FFFFFF', 'width' => '5', 'cols' => '5');
	$xls_fondoAzulConcatenado_2 = array('border'=>'1F4192','background'=>'1F4192','color'=>'FFFFFF', 'width' => '5', 'cols' => '5');
	$xls_moneda = array('type'=>'moneda','border'=>'000000', );

	$xls_semaforoRojo = array('border'=>'000000','background'=>'FF0111','color'=>'FFFFFF'); #FF0111 => Rojo
	$xls_semaforoAmarillo = array('border'=>'000000','background'=>'FED51B','color'=>'FFFFFF'); #FED51B => Amarillo
	$xls_semaforoVerde = array('border'=>'000000','background'=>'7AFF02','color'=>'FFFFFF'); #7AFF02 => Verde
	$xls_semaforoBlanco = array('border'=>'000000','background'=>'ECECFB','color'=>'#696566'); #ECECFB => Blanco
		
switch($botonImprimir){
		case "Actividades Pendientes":
			//echo "*Actividades Pendientes*";
			include('excel_reporte.ActividadesPendientes.php');			
		break;
				
		case "Actividades Todas":
			//echo "**Actividades Todas";
			include('excel_reporte.ActividadesTodas.php');
		break;	

		case "Cotizaciones Emisiones":
			//echo
			echo "**Cotizaciones Emisiones";
		break;	
		
		case "Llamadas Citas":
			//echo
			echo "**Llamadas Citas";
		break;	

		case "Comisiones Pendientes Liquidar":
			//echo "**Comisiones Pendientes Liquidar";
			include('excel_reporte.ComisionesPendientesLiquidar.php');
		break;
		
		case "Comisiones Liquidadas":
			//echo "**Comisiones Liquidadas";
			include('excel_reporte.ComisionesLiquidadas.php');
		break;
		
		case "Cancelaciones":
			//echo "**Cancelaciones";
			include('excel_reporte.Cancelaciones.php');
		break;

		case "Produccion":
			//echo "**Produccion";
			include('excel_reporte.Produccion.php');
		break;		

		case "Prima Neta Pagada":
			//echo "**Prima Neta Pagada";
			include('excel_reporte.PrimaNetaPagada.php');
		break;		
}	
	DreDesconectarDB($conexion);
?>