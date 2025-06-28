<?php
	$sqlDocumentosEmpresas = "Select * From `imagenes` Where `CLIENTE_MPRO` = '$_REQUEST[CLAVE]' Or `CLIENTE_TMP` = '$_REQUEST[CLAVE]'";
	$resDocumentosEmpresas = DreQueryDB($sqlDocumentosEmpresas);
	
	$documento = "";
	while($rowDocumentosEmpresas = mysql_fetch_assoc($resDocumentosEmpresas)){
		if($rowDocumentosEmpresas['TIPO_IMG'] == "COMPROBANTE DOMICILIARIO"){ $documento.= "-Comprobante Domiciliario"; }
		if($rowDocumentosEmpresas['TIPO_IMG'] == "IFE"){ $documento.= "-Ife"; }
		if($rowDocumentosEmpresas['TIPO_IMG'] == "ACTA CONSTITUTIVA"){ $documento.= "-Acta Constitutiva"; }
		if($rowDocumentosEmpresas['TIPO_IMG'] == "RFC"){ $documento.= "-Rfc"; }
	}
	
	if($rowDatosEmpresa['TIPO_PERSONA'] == "F"){
		if(strstr($documento,"Comprobante Domiciliario") || strstr($documento, "Ife")){
			$numeroDocumentos = explode('-',$documento);
			$numeroDocumentos = count($numeroDocumentos)-1;
		}
		switch($numeroDocumentos){
			case 0:
				$colorSemaforo = "rojo";
			break;
			case 1:
				$colorSemaforo = "amarillo";
			break;
			case 2:
				$colorSemaforo = "verde";
			break;
			default:
				$colorSemaforo = "rojo";
			break;
			}
	}
	
	if($rowDatosEmpresa['TIPO_PERSONA'] == "M"){
		if(strstr($documento,"Comprobante Domiciliario") || strstr($documento, "Ife") || strstr($documento, "Acta Constitutiva") || strstr($documento, "Rfc")){
			$numeroDocumentos = explode('-',$documento);
			$numeroDocumentos = count($numeroDocumentos)-1;
		}

		switch($numeroDocumentos){
			case 0:
				$colorSemaforo = "rojo";
			break;
			case 1:
				$colorSemaforo = "rojo";
			break;
			case 2:
				$colorSemaforo = "amarillo";
			break;
			case 3:
				$colorSemaforo = "amarillo";
			break;
			case 4:
				$colorSemaforo = "verde";
			break;
			default:
				$colorSemaforo = "rojo";
			break;
			}
	}
	// Desglose de Documentos
	$desgloseDocumentos = explode('-',$documento);
	$documentosCliente = "";
	
	foreach($desgloseDocumentos as $documento){
		if($documento != ""){
			if(!strstr($documentosCliente, $documento)){
				$documentosCliente .= "&bull;".$documento;
				$documentosCliente .= "\n";
			}
		}
	}
	if($documentosCliente == ""){
		$documentosCliente.= "Sin Documentos";
	}
	
?>
<!-- <img src="<?php //echo "img/semaforo_".$colorSemaforo.".png"; ?>" width="22" height="51" title="Semaforo de Documentos" /> -->
<img src="img/transparente.fw.png" class="<? echo "semaforo ".$colorSemaforo; ?>" alt="semaforo" border="0" title="<? echo $documentosCliente; ?>"/>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
