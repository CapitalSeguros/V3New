<?

//$fileXML = "../../xmlTodos/aba/04072014_135058.xml";
$fileXML = "../../xmlTodos/aba/04072014_183323.xml";


/* Proceso Para Cuadro Comparativo */
 if(file_exists($fileXML)){ // el archivo es necesario que se depuere hasta dejarlo lo mas limpio en Formato XML
	//echo "<br>Si Existe el Archivo<br>";
	
	 $datosCotizacion  =  simplexml_load_file($fileXML); 
	if($datosCotizacion){
		//echo "Si Cargamos el XML";

		foreach($datosCotizacion->INCISOS as $cotizacion){
			echo "<pre>";
				print_r($cotizacion->INCISO->RECIBOS);
			echo "</pre>";
		}
echo		$primerRecibo = $cotizacion->INCISO->RECIBOS->RECIBO[0]->PTOTAL; // PTOTAL
echo "<br>";
echo		$primerRecibo = $cotizacion->INCISO->RECIBOS->RECIBO[1]->PTOTAL; // PTOTAL
	}
 }

?>