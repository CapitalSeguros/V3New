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
		$xls->NewCell('Reporte De Comisiones Pendientes de Liquidar ',false,$xls_encabezado);
	$xls->CloseRow();
	
	$xls->OpenRow();	
	$xls->CloseRow();
	
	$xls->OpenRow();
		$xls->NewCell('FECHA INICIO:',true,$xls_fondoAzul);
		$xls->NewCell($fechaInicioComiPen,true,$xls_normal);
	$xls->CloseRow();
	
	$xls->OpenRow();
		$xls->NewCell('FECHA FINAL:',true,$xls_fondoAzul);
		$xls->NewCell($fechaFinComiPen,true,$xls_normal);
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
		$xls->NewCell('Cliente',true,$xls_fondoAzul);
		$xls->NewCell('Vendedor',true,$xls_fondoAzul);
		$xls->NewCell('Consultor',true,$xls_fondoAzul);
		$xls->NewCell('Ramo',true,$xls_fondoAzul);
		$xls->NewCell('Fecha Cobro',true,$xls_fondoAzul);
		$xls->NewCell('Comision Vendedor',true,$xls_fondoAzul);
		$xls->NewCell('Comision Consultor',true,$xls_fondoAzul);

	$xls->CloseRow();

$sqlConsultaCxC = "
	Select 
		*
	From
		`comisionespend`
	Where
		(`fecha_cobro` Between '$fechaInicioComiPen' And '$fechaFinComiPen')

				  ";	
/*
		And
		(`comisionespend`.`vendedor` Like '%$sqlFiltraVendedor%')
*/
$resConsultaCxC = DreQueryDB($sqlConsultaCxC);
while($rowConsultaCxC = mysql_fetch_assoc($resConsultaCxC)){

		$fechaCobroX = explode('-',$rowConsultaCxC['fecha_cobro']);
		$fechaCobroExcel = $fechaCobroX[2]."/".$fechaCobroX[1]."/".$fechaCobroX[0];
		
	extract($rowConsultaCxC);

	$xls->OpenRow();
		$xls->NewCell($poliza,true,$xls_normal);
		$xls->NewCell($cliente,true,$xls_normal);
		$xls->NewCell($vendedor,true,$xls_normal);
		$xls->NewCell($consultor,true,$xls_normal);
		$xls->NewCell($ramo,true,$xls_normal);
		$xls->NewCell($fechaCobroExcel,true,$xls_date);
		$xls->NewCell($Comision_Vendedor,true,$xls_int);
		$xls->NewCell($Comision_Consultor,true,$xls_int);
	$xls->CloseRow();
}
		
	$xls->GetXLS('comisionesPendientesLiq');
	DreDesconectarDB($conexion);
?>