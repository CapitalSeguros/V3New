<?php
require_once("../config/config.php");
require_once('../config/funcionesDre.php');
$conex = DreConectarDB();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Visor Polizas</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<body topmargin="0" leftmargin="0" rightmargin="0"> 
<?php
if(isset($_GET['POLIZA'])){
	$VALOR = $_GET['POLIZA'];
}
if(isset($_GET['POLIZA_RENOVACION'])){
	$VALOR = $_GET['POLIZA_RENOVACION'];
}
	$sqlCalculamosArchivo = "
		Select
			`NO_ARCHIVO`
			, `EXTENSION`
			, `RUTA`
-- 			, Count(*) As `existePoliza` 
		From 
			`imagenes`
		Where
			`VALOR` = '$VALOR'
			And
			`TIPO_IMG` = '$tipoImg'
		Order By
			`FECHA_ALTA` Desc
		Limit
			0,1
							";
	$resCalculamosArchivo = DreQueryDB($sqlCalculamosArchivo);
	$rowCalculamosArchivo = mysql_fetch_assoc($resCalculamosArchivo);
	$existePoliza = mysql_num_rows(DreQueryDB($sqlCalculamosArchivo));
	//echo "<pre>";
		//echo $existePoliza;
		//echo $sqlCalculamosArchivo;
		//print_r($rowCalculamosArchivo);
		//echo $rowCalculamosArchivo['existePoliza'];
	//echo "</pre>";


	if((int)$existePoliza >= 1){
		extract($rowCalculamosArchivo);
			// tipoUrl($_SERVER['REMOTE_ADDR']).$rutaDocumento.$rowDocumentosCliente['NO_ARCHIVO'].$extensionDocumento;
		$urlPoliza = tipoUrl($_SERVER['REMOTE_ADDR']).$RUTA.$NO_ARCHIVO.".".$EXTENSION;
		header("Location: $urlPoliza");
	} else {
?>
		<table cellpadding="2" cellspacing="2" align="center">
			<tr>
    			<td>
				<?php
					switch($tipoImg){
			
						case "CARATULA":
							echo "<br />";
							echo "Caratula NO ENCONTRADA !!!";
						break;
						
					}
				?>
				</td>
			</tr>
		</table>
<?php
	}
DreDesconectarDB($conex);
?>
</body>
</html>