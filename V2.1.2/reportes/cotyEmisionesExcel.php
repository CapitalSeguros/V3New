<?
	include('../config/funcionesDre.php');
	include('../includes/class.excel.writer.php');
	
	extract($_REQUEST);
	$conexion = DreConectarDB();

function DreValidacionWs($idPoliza){
	$sqlConsultaPolizaWs = "
		Select Count(*) As `ExistePoliza` From 
			`ws_impresion_poliza`
		Where
			`poliza` = ''
			And 
			`poliza` != ''
						   ";
	$resConsultaPolizaWs = DreQueryDB($sqlConsultaPolizaWs);				   
	$rowConsultaPolizaWs = mysql_fetch_assoc($resConsultaPolizaWs);
		if($rowConsultaPolizaWs['ExistePoliza'] > 0 ){
			$return = TRUE;
		}else{
			$return = FALSE;
		}
	return
		$return;
		
}

	$xls = new ExcelWriter();
	
	$xls_int = array('type'=>'int','border'=>'000000');
	$xls_date = array('type'=>'date','border'=>'000000');
	$xls_normal = array('border'=>'000000');
	$xls_encabezado = array('border'=>'','color'=>'000000','bold'=>'true'); //,'background'=>'FFFFFF'
	$xls_fondoAzul = array('border'=>'000000','background'=>'538DD5','color'=>'FFFFFF');
	
	$xls->OpenRow();
		$xls->NewCell('Reporte De Cotizaciones Y Emisiones',false,$xls_encabezado);
	$xls->CloseRow();
	
	$xls->OpenRow();	
	$xls->CloseRow();

	$xls->OpenRow();
		$xls->NewCell('FECHA INICIO:',true,$xls_fondoAzul);
		$xls->NewCell($fechaInicioCotEmi,true,$xls_normal);
	$xls->CloseRow();
	
	$xls->OpenRow();
		$xls->NewCell('FECHA FINAL:',true,$xls_fondoAzul);
		$xls->NewCell($fechaFinCotEmi,true,$xls_normal);
	$xls->CloseRow();
/*	
	$xls->OpenRow();
		$xls->NewCell('FILTROS:',true,$xls_fondoAzul);
		$xls->NewCell($filtro,true,$xls_normal);
	$xls->CloseRow();
*/
	$xls->OpenRow();	
	$xls->CloseRow();
	
	$xls->OpenRow();
		$xls->NewCell('Tipo',true,$xls_fondoAzul);
		$xls->NewCell('Poliza',true,$xls_fondoAzul);
		$xls->NewCell('Ramo',true,$xls_fondoAzul);
		$xls->NewCell('Cliente',true,$xls_fondoAzul);
		$xls->NewCell('Fecha',true,$xls_fondoAzul);
		$xls->NewCell('Comentario',true,$xls_fondoAzul);
		$xls->NewCell('Vendedor',true,$xls_fondoAzul);
		$xls->NewCell('Conducto', true, $xls_fondoAzul);
	$xls->CloseRow();

$sqlCotyEmisiones = "
	Select 
		*
		,`empresas`.`RAZON_SOCIAL` As `nombreCliente`
		,`usuarios`.`NOMBRE` As `nombreVendedor`
	From
		`empresas` Inner Join `cotyemision` 
		On 
		`empresas`.`CLAVE` = `cotyemision`.`clave_cliente` Inner Join `usuarios` 
		On 
		`usuarios`.`VALOR` = `cotyemision`.`vendedor`
	Where
		(`fecha` Between '$fechaInicioCotEmi' And '$fechaFinCotEmi')
		And
		(`usuarios`.`VALOR` Like '%$sqlFiltraVendedor%')
				  ";
$resCotyEmisiones = DreQueryDB($sqlCotyEmisiones);
while($rowCotyEmisiones = mysql_fetch_assoc($resCotyEmisiones)){
	extract($rowCotyEmisiones);

		$fechaX = explode('-',$rowCotyEmisiones['fecha']);
		$fechaExcel = $fechaX[2]."/".$fechaX[1]."/".$fechaX[0];
		
		if($rowCotyEmisiones['poliza'] == ""){
			$tipoDocto = "Cotizacion";
		} else {
			$tipoDocto = "Emision";
		}

		if(DreValidacionWs($rowCotyEmisiones['poliza'])){
			$tipoEmision = "Ws";	
		} else {
			$tipoEmision = "Manual";
		}


	$xls->OpenRow();
		$xls->NewCell($tipoDocto,true,$xls_normal);
		$xls->NewCell($poliza,true,$xls_normal);
		$xls->NewCell($ramo,true,$xls_normal);
		$xls->NewCell($nombreCliente,true,$xls_normal);
		$xls->NewCell($fechaExcel,true,$xls_date);
		$xls->NewCell($descripcion,true,$xls_normal);
		$xls->NewCell($nombreVendedor,true,$xls_normal);
		$xls->NewCell($tipoEmision,true,$xls_normal);
	$xls->CloseRow();
}
		
	$xls->GetXLS('reporteCotEmy');
	DreDesconectarDB($conexion);
?>