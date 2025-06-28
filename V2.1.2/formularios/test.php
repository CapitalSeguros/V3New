<?php
$fileXml = "../xmlTodos/qualitas/test/listaTarifas09052014_154313.xml";

if(is_file($fileXml)){ echo "si hay archivo"; }
echo $datosSubMarca = simplexml_load_file($fileXml);
//$datosSubMarca = simplexml_load_string($respuestaXmlDepurada);

	foreach($datosSubMarca->listaTarifasResult->salida->datos->Elemento as $vehiculo){
		$vehiculo->cTipo." ".$vehiculo->cVersion;
		$vehiculo->CAMIS;
//echo	 	$elementosModelos[]= '"'.$vehiculo->cTipo." ".$vehiculo->cVersion.'"'; //--> DreSinAcentos()
	}

//		$arregloModelos= implode(", ", $elementosModelos);//junta los valores del array en una sola cadena de texto
/*
echo "<pre>";
	print_r($datosSubMarca);
echo "</pre>";
*/
?>