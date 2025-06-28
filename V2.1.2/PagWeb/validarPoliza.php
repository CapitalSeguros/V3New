<?php
	extract($_REQUEST);
	include_once('../config/funcionesDre.php');
	$conex = DreConectarDB();	
		
// action categorias_Agregar
if($_REQUEST['validacion'] == "polizas"){
	
	$sqlConsultaPolizas = "
			Select * From 
				`cliramos`
			Where 
				`POLIZA` Like '%$poliza%'
						  ";
	$resConsultaPolizas = DreQueryDB($sqlConsultaPolizas);
	$rowConsultaPolizas = mysql_fetch_assoc($resConsultaPolizas);

	if(isset($rowConsultaPolizas['POLIZA'])){
		$urlRegreso = "index.php?poliza=true&value=".$rowConsultaPolizas['POLIZA'];
	} else {
		$urlRegreso = "index.php?poliza=false";
	}
	
	header('Location: '.$urlRegreso);
	
}
	DreDesconectarDB($conex);
?>