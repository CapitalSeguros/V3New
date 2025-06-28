<?php
//echo "<pre>";
//	print_r($_REQUEST);
//echo "</pre>";

require_once('../includes/funcionesDre.php');
require_once('../nusoap-0.9.5/lib/nusoap.php');
extract($_REQUEST);

$conex = DreConectarDB();

function idEstadoDre($nombreEstado){
	$sqlConsultaId = "
		Select * From 
			`estados`
		Where 
			`nombre_estado` = '$nombreEstado'
					 ";
	$resConsultaId = DreQueryDB($sqlConsultaId);
	$rowConsultaId = mysql_fetch_assoc($resConsultaId);

	return
	
		$rowConsultaId['id'];
}

$sqlConsultaDatosCliente = "
	Select * From 
		`empresas`
	Where 
		`CLAVE` = '$idEmpresa'
						   ";
$resConsultaDatosCliente = DreQueryDB($sqlConsultaDatosCliente);
$rowConsultaDatosCliente = mysql_fetch_assoc($resConsultaDatosCliente);

if(
	!isset($wsAseguradoraParticular) 
	&& 
	$wsAseguradoraParticular != "ABA"
  ){ 
  	//echo "<br>Qualitas<br>";
	require('wsQualitas.php'); // Ws Qualitas 
	}

if(
	$wsAseguradoraParticular != "AXA"
  ){ 
  	//echo "<br>Aba<br>";  	
	require('wsAba.php'); // Ws Aba
	}
if(
	$wsAseguradoraParticular == "AXA"
  ){ 
  	echo "<br>Axa<br>";  	
	//require('wsAxa.php'); // Ws Aba
	}

$urlReporteComparativo = "../reportes/cuadroComparativo.php?idActividad=".$idActividad."&idCliente=".$idCliente;
$urlReturnActividad = "../actividadVer.php?recId=".$recId."&ver=1";
?>
	<script>
//		window.open('<?php echo $urlReporteComparativo; ?>','_blank');
//		window.open('<?php echo $urlReturnActividad; ?>','_self');
	</script>
<?php
DreDesconectarDB($conex);
?>