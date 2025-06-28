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
		$xls->NewCell('Reporte De Cobranza Pendiente',false,$xls_encabezado);
	$xls->CloseRow();
	
	$xls->OpenRow();	
	$xls->CloseRow();
	
	$xls->OpenRow();
		$xls->NewCell('FECHA INICIO:',true,$xls_fondoAzul);
		$xls->NewCell($fechaInicio,true,$xls_normal);
	$xls->CloseRow();
	
	$xls->OpenRow();
		$xls->NewCell('FECHA FINAL:',true,$xls_fondoAzul);
		$xls->NewCell($fechaFin,true,$xls_normal);
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
		$xls->NewCell('No Recibo',true,$xls_fondoAzul);
		$xls->NewCell('Cliente',true,$xls_fondoAzul);
		$xls->NewCell('Vendedor',true,$xls_fondoAzul);
		$xls->NewCell('Aseguradora',true,$xls_fondoAzul);
		$xls->NewCell('Condicion',true,$xls_fondoAzul);
		$xls->NewCell('Fecha Inicio',true,$xls_fondoAzul);
		$xls->NewCell('Fecha Fin',true,$xls_fondoAzul);
		$xls->NewCell('Fecha Vence',true,$xls_fondoAzul);
		$xls->NewCell('Total',true,$xls_fondoAzul);
		$xls->NewCell('Comentario',true,$xls_fondoAzul);

	$xls->CloseRow();

$sqlConsultaCxC = "
	Select 
		*
		,`empresas`.`RAZON_SOCIAL` As `cliente`
		,`usuarios`.`NOMBRE`  As `nombreVendedor`
	From
		`empresas` Inner Join `doctoscc` 
		On 
		`empresas`.`CLAVE` = `doctoscc`.`clave_cliente` Inner Join `usuarios` 
		On 
		`usuarios`.`VALOR` = `doctoscc`.`vendedor`
	Where
		(`doctoscc`.`vence` Between '$fechaInicio' And '$fechaFin')
		And
		(`usuarios`.`VALOR` Like '%$sqlFiltraVendedor%')
				  ";	
$resConsultaCxC = DreQueryDB($sqlConsultaCxC);
while($rowConsultaCxC = mysql_fetch_assoc($resConsultaCxC)){

		$inicioX = explode('-',$rowConsultaCxC['inicio']);
		$inicioExcel = $inicioX[2]."/".$inicioX[1]."/".$inicioX[0];
		
		$finX = explode('-',$rowConsultaCxC['fin']);
		$finExcel = $finX[2]."/".$finX[1]."/".$finX[0];
		
		$venceX = explode('-',$rowConsultaCxC['vence']);
		$venceExcel = $venceX[2]."/".$venceX[1]."/".$venceX[0];

	extract($rowConsultaCxC);

	$xls->OpenRow();
		$xls->NewCell($poliza,true,$xls_normal);
		$xls->NewCell($ramo,true,$xls_normal);
		$xls->NewCell($no_recibo,true,$xls_normal);
		$xls->NewCell($cliente,true,$xls_normal); // Cambiar
		$xls->NewCell($nombreVendedor,true,$xls_normal); // Cambiar
		$xls->NewCell($aseguradora,true,$xls_normal);
		$xls->NewCell($condicion,true,$xls_normal);
		$xls->NewCell($inicioExcel,true,$xls_date);
		$xls->NewCell($finExcel,true,$xls_date);
		$xls->NewCell($venceExcel,true,$xls_date);
		$xls->NewCell($total,true,$xls_int);
		$xls->NewCell($comentario,true,$xls_normal);
	$xls->CloseRow();
}
		
	$xls->GetXLS('reporteCxC');
	DreDesconectarDB($conexion);
?>