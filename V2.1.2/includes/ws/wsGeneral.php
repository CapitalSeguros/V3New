<?php
if($wsAseguradoraParticular == "ABA"){
	require_once('nusoap-0.9.5-Aba/lib/nusoap.php');
} else {
	require_once('nusoap-0.9.5/lib/nusoap.php');
}



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

//echo "<pre>";
	//print_r($_REQUEST);
//echo "</pre>";

$sqlConsultaDatosCliente = "
	Select * From 
		`empresas`
	Where 
		`CLAVE` = '$idEmpresa'
						   ";
$resConsultaDatosCliente = DreQueryDB($sqlConsultaDatosCliente);
$rowConsultaDatosCliente = mysql_fetch_assoc($resConsultaDatosCliente);

switch($wsAseguradoraParticular){
	
	case "QUALITAS":
		//echo "<br>Qualitas<br>";
		require('includes/ws/wsQualitas.php'); // Ws Qualitas 		
	break;
	
	case "ABA":
		//echo "<br>Aba<br>";
		require('wsAba.php'); // Ws Aba
	break;
	
	case "HDI":
		//echo "<br>Hdi<br>";  	
		require('wsHdi.php'); // Ws Hdi
	break;
	
	case "ANA":
	  	//echo "<br>Ana<br>";  	
		require('wsAna.php'); // Ws Ana
	break;
	
	case "ZURICH":
	  	echo "<br>Zurich<br>";  	
		require('wsZurich.php'); // Ws Zurich
	break;
	
	case "AXA":
		echo "<br>Axa<br>";  	
		require('wsAxa.php'); // Ws Axa
	break;
	
	case "FIN":
		//echo "Fin";
		// header('Location: actividadVer.php?recId='.$recId.'&ver=5&idInterno='.$idInterno);
		// 'actividadVer.php?recId='.$recId.'&ver=5&idInterno='.$idInterno;
		$urlFin = "actividadesDetalle.php?recId=".$recId."&muestra=Formularios#Formularios";
		?>
        <script>
			window.open('<?php echo $urlFin; ?>', '_self');
		</script>		
        <?php
	break;	
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