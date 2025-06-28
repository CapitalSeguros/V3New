<?php

	extract($_REQUEST);
	include_once('../config/funcionesDre.php');
	$conex = DreConectarDB();	
		
// action categorias_Agregar
if($_REQUEST['validacion'] == "agente"){
	
	$sqlConsultaAgente = "
			Select *, Count(*) As `numeroResultados` From 
				`usuarios`
			Where 
				`VALOR` Like '%$agente%'
				Or
				MATCH (`NOMBRE`) AGAINST ('$agente' IN BOOLEAN MODE);
										  ";
	$resConsultaAgente = DreQueryDB($sqlConsultaAgente);
	$rowConsultaAgente = mysql_fetch_assoc($resConsultaAgente);
	
	if($rowConsultaAgente['numeroResultados'] <= 1){
		
		if(isset($rowConsultaAgente['VALOR'])){
			$urlRegreso = "index.php?agente=true&value=".$rowConsultaAgente['VALOR'];
		} else {
			$urlRegreso = "index.php?agente=false";
		}

	} else if($rowConsultaAgente['numeroResultados'] > 1){
		$urlRegreso = "index.php?agente=true&busqueda=".urlencode($agente);
	}

	header('Location: '.$urlRegreso);
}
	DreDesconectarDB($conex);
?>