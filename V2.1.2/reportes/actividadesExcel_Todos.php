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
		$xls->NewCell('Reporte Actividades',false,$xls_encabezado);
	$xls->CloseRow();
	
	$xls->OpenRow();	
	$xls->CloseRow();
	
	$xls->OpenRow();
		$xls->NewCell('FECHA INICIO:',true,$xls_fondoAzul);
		$xls->NewCell($fechaInicioActiTodos,true,$xls_normal);
	$xls->CloseRow();
	
	$xls->OpenRow();
		$xls->NewCell('FECHA FINAL:',true,$xls_fondoAzul);
		$xls->NewCell($fechaFinActiTodos,true,$xls_normal);
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
	
		$xls->NewCell('Actividad',true,$xls_fondoAzul);
		$xls->NewCell('Ramo',true,$xls_fondoAzul);
		$xls->NewCell('Cliente',true,$xls_fondoAzul);
		$xls->NewCell('Usuario',true,$xls_fondoAzul);
		$xls->NewCell('Fecha',true,$xls_fondoAzul);
		$xls->NewCell('Estado',true,$xls_fondoAzul);
//		$xls->NewCell('Semaforo',true,$xls_fondoAzul);
//		$xls->NewCell('Comentario',true,$xls_fondoAzul);

	$xls->CloseRow();

$sqlConsultaAct = "
	Select 
		`actividades`.`recId` As `actividad`
        ,`actividades`.`ramoInterno` As `ramo`
        ,`empresas`.`RAZON_SOCIAL` As `nombreCliente`
        ,`usuarios`.`NOMBRE` As `nombreUsuario`
        ,date_format(`actividades`.`fechaCreacion`, '%Y-%m-%d') As `fechaCreacion`
        ,`actividades`.`fin`
--        ,`semactividad`.`semaforo`
        ,`actividades`.`referencia`
	From 
		`usuarios` Inner Join `actividades` 
		On
		`usuarios`.`VALOR` = `actividades`.`usuarioCreacion` Inner Join `empresas`
		On
		`actividades`.`idRef` = `empresas`.`CLAVE` 
	Where
		(`actividades`.`fechaCreacion` Between '$fechaInicioActiTodos' And '$fechaFinActiTodos')
		And
		(`actividades`.`usuarioCreacion` Like '%$sqlFiltraVendedor%' Or `actividades`.`usuario` Like '%$sqlFiltraVendedor%')
				  ";	
//echo "<pre>";
	//echo $sqlConsultaAct;
//echo "</pre>";

$resConsultaAct = DreQueryDB($sqlConsultaAct);
while($rowConsultaAct = mysql_fetch_assoc($resConsultaAct)){

		$fechaCreacionX = explode('-',$rowConsultaAct['fechaCreacion']);
		$fechaCreacionExcel = $fechaCreacionX[2]."/".$fechaCreacionX[1]."/".$fechaCreacionX[0];
		
		if($rowConsultaAct['fin'] == "0"){ $status = "En Proceso"; } else { $status = "Terminada";}
		$ramoDecode = urldecode($rowConsultaAct['ramo']);
		
	extract($rowConsultaAct);

	$xls->OpenRow();
		$xls->NewCell($actividad,true,$xls_normal);
		$xls->NewCell($ramoDecode,true,$xls_normal);
		$xls->NewCell($nombreCliente,true,$xls_normal); // Cambiar
		$xls->NewCell($nombreUsuario,true,$xls_normal); // Cambiar
		$xls->NewCell($fechaCreacionExcel,true,$xls_date);
		$xls->NewCell($status,true,$xls_normal);
//		$xls->NewCell($semaforo,true,$xls_normal);
//		$xls->NewCell($referencia,true,$xls_normal);
	$xls->CloseRow();
}
		
	$xls->GetXLS('reporteActividadesTodas');
	DreDesconectarDB($conexion);
?>