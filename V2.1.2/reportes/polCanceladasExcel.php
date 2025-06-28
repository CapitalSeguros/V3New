<?
	include('../config/funcionesDre.php');
	include('../includes/class.excel.writer.php');
		
	extract($_REQUEST);
	$conexion = DreConectarDB();

	$xls = new ExcelWriter();
	
	$xls_int = array('type'=>'int','border'=>'000000');
	$xls_date = array('type'=>'date','border'=>'000000');
	$xls_normal = array('border'=>'000000');
	$xls_encabezado = array('border'=>'','color'=>'000000','bold'=>'true'); //,'background'=>'FFFFFF'
	$xls_fondoAzul = array('border'=>'000000','background'=>'538DD5','color'=>'FFFFFF');
	
	$xls->OpenRow();
		$xls->NewCell('Reporte De Polizas Canceladas',false,$xls_encabezado);
	$xls->CloseRow();
	
	$xls->OpenRow();	
	$xls->CloseRow();
	
	$xls->OpenRow();
		$xls->NewCell('FECHA INICIO:',true,$xls_fondoAzul);
		$xls->NewCell($fechaInicioPolCan,true,$xls_normal);
	$xls->CloseRow();
	
	$xls->OpenRow();
		$xls->NewCell('FECHA FINAL:',true,$xls_fondoAzul);
		$xls->NewCell($fechaFinPolCan,true,$xls_normal);
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
		$xls->NewCell('Poliza',true,$xls_fondoAzul);
		$xls->NewCell('Ramo',true,$xls_fondoAzul);
		$xls->NewCell('Cliente',true,$xls_fondoAzul);
		$xls->NewCell('Fecha',true,$xls_fondoAzul);
		$xls->NewCell('Motivo',true,$xls_fondoAzul);
		$xls->NewCell('Vendedor',true,$xls_fondoAzul);
	$xls->CloseRow();

$sqlConsultaPolCance = "
	Select 
		*
		,`empresas`.`RAZON_SOCIAL` As `nombreCliente`
		,`usuarios`.`NOMBRE` As `nombreUsuario`
		,`usuarios`.`NOMBRE` As `nombreVendedor`
	From
		`empresas` Inner Join `polcanceladas` 
		On 
		`empresas`.`CLAVE` = `polcanceladas`.`clave_cliente` Inner Join `usuarios` 
		On 
		`polcanceladas`.`vendedor` = `usuarios`.`VALOR`
	Where
		(`polcanceladas`.`fecha` Between '$fechaInicioPolCan' And '$fechaFinPolCan')
		And
		(`polcanceladas`.`vendedor` Like '%$sqlFiltraVendedor%')
		
		
		
	Order By 
		`polcanceladas`.`fecha` Desc
				  ";
$resConsultaPolCance = DreQueryDB($sqlConsultaPolCance);
while($rowConsultaPolCance = mysql_fetch_assoc($resConsultaPolCance)){
	extract($rowConsultaPolCance);
	
		$fechaX = explode('-',$rowConsultaPolCance['fecha']);
		$fechaExcel = $fechaX[2]."/".$fechaX[1]."/".$fechaX[0];

	$xls->OpenRow();
		$xls->NewCell($poliza,true,$xls_normal);
		$xls->NewCell($ramo,true,$xls_normal);
		$xls->NewCell($nombreCliente,true,$xls_normal);
		$xls->NewCell($fechaExcel,true,$xls_date);
		$xls->NewCell($descripcion,true,$xls_normal);
		$xls->NewCell($nombreVendedor,true,$xls_normal);
	$xls->CloseRow();
}
		
	$xls->GetXLS('reportePolCanceladas');
	DreDesconectarDB($conexion);
?>