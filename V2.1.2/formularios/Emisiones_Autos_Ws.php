<?php
	$sqlProspectoCliente = "
		Select * From 
			`empresas` Inner Join `contactos`
			On
			`empresas`.`CLAVE` = `contactos`.`CLAVE`
		Where
			`empresas`.`CLAVE` Like '%$rowActividad[idRef]%'
			And 
			`contactos`.`TIPO` = 'CONTACTO1'
						   ";
	$resProspectoCliente = DreQueryDB($sqlProspectoCliente);
	$rowProspectoCliente = mysql_fetch_assoc($resProspectoCliente);

//--> echo "vamos a crear actividad Emision y Emitir via Ws";

	/* busqueda del archivo xml de cotizacion */
	$pathAseguradora = strtolower($rowDatosActividad['aseguradoraUno']); // Calculamos el Directorio
	$directorio = opendir("xmlTodos/$pathAseguradora"); //ruta de la carpeta a analizar
	while($archivo = readdir($directorio)){  //obtenemos un archivo y luego otro sucesivamente
		if(!is_dir($archivo)){//verificamos que no sea un directorio
			if(strstr($archivo,$rowDatosActividad['cotizacionEmision'])){ $archivoXmlCotizacion = $archivo; }
		}
	}

// Funciones ABA
function BusquedaPersonaRFC($tipoPersona, $rfcPersona){
	require_once('nusoap-0.9.5-Aba-Personas/lib/nusoap.php');	
	if($tipoPersona=="F" || $tipoPersona=="0"){ $TP = "0"; /* Fisica */ } else if($tipoPersona=="M"||$tipoPersona=="1"){ $TP = "1"; /* Moral */ } 
	$RFC = substr($rfcPersona,0,10);
	$HCVE = substr($rfcPersona,10,4);
	
	$urlCliente = "http://www5.abaseguros.com/PersonaConnect/PCConsultas.svc?wsdl"; // url del WSDL
	$pass = "VIRTUAL1$";
	$user = "WSAGECAP";
	$client = new nusoap_client($urlCliente, true);

	$header = '
    	  <tem:strEntrada>
				&lt;XML&gt;
					&lt;DP&gt;
						&lt;TP&gt;'.$TP.'&lt;/TP&gt; <!-- 1:Moral; 0:Fisica; -->
						&lt;RFC&gt;'.$RFC.'&lt;/RFC&gt;
						&lt;HCVE&gt;'.$HCVE.'&lt;/HCVE&gt;
					&lt;/DP&gt;
				&lt;/XML&gt;
    	  </tem:strEntrada>
    	  <tem:Token>
        	 <abas:password>'.$pass.'</abas:password>
	         <abas:usuario>'.$user.'</abas:usuario>
	      </tem:Token>
			  ';
	$client->setHeaders($header);
	$client->soap_defencoding = 'UTF-8';
	$client->decode_utf8 = false;
	$xml = '';

	$client->call('ConsultaPersonas', '', 'http://tempuri.org/PCConsultas/', 'http://tempuri.org/PCConsultas/ConsultaPersonas', false, false, false, false);

//	'<h2>Request</h2><pre>'.htmlspecialchars($client->request, ENT_QUOTES).'</pre>';
//	'<h2>Response</h2><pre>'.htmlspecialchars($client->response, ENT_QUOTES).'</pre>';

	$respuestaXML = htmlspecialchars_decode($client->responseData, ENT_NOQUOTES);

	$cosasQuitaXml = array('<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/"><s:Body><Salida xmlns="http://tempuri.org/"><strSalida>','</strSalida></Salida></s:Body></s:Envelope>');
	$cosasPonerXml = array('','');
	$respuestaXmlDepurada = str_replace($cosasQuitaXml, $cosasPonerXml, $respuestaXML);
	//-->file_put_contents('prueba.xml',$respuestaXmlDepurada);
	$datosPersona = simplexml_load_string($respuestaXmlDepurada); 
	foreach($datosPersona as $persona){ /* */ }

	return
		$persona[0]->PID;	
//		'<h2>Request</h2><pre>'.htmlspecialchars($client->request, ENT_QUOTES).'</pre>';
//		'<h2>Response</h2><pre>'.htmlspecialchars($client->response, ENT_QUOTES).'</pre>';	
}

function BusquedaDireccionPersona($tipoPersona, $PID){
	require_once('nusoap-0.9.5-Aba-Personas/lib/nusoap.php');	
	if($tipoPersona=="F" || $tipoPersona=="0"){ $TP = "0"; /* Fisica */ } else if($tipoPersona=="M"||$tipoPersona=="1"){ $TP = "1"; /* Moral */ } 
	
	$urlCliente = "http://www5.abaseguros.com/PersonaConnect/PCConsultas.svc?wsdl"; // url del WSDL
	$pass = "VIRTUAL1$";
	$user = "WSAGECAP";
	$client = new nusoap_client($urlCliente, true);

	$header = '
    	  <tem:strEntrada>
			&lt;XML&gt;
			  &lt;DP&gt;
			    &lt;TP&gt;'.$TP.'&lt;/TP&gt;
			    &lt;PID&gt;'.$PID.'&lt;/PID&gt;
			  &lt;/DP&gt;
			&lt;/XML&gt;
    	  </tem:strEntrada>
    	  <tem:Token>
        	 <abas:password>'.$pass.'</abas:password>
	         <abas:usuario>'.$user.'</abas:usuario>
	      </tem:Token>
			  ';
	$client->setHeaders($header);
	$client->soap_defencoding = 'UTF-8';
	$client->decode_utf8 = false;
	$xml = '';

	$client->call('ConsultaDireccionesPersona', '', 'http://tempuri.org/PCConsultas/', 'http://tempuri.org/PCConsultas/ConsultaDireccionesPersona', false, false, false, false);

//	'<h2>Request</h2><pre>'.htmlspecialchars($client->request, ENT_QUOTES).'</pre>';
//	'<h2>Response</h2><pre>'.htmlspecialchars($client->response, ENT_QUOTES).'</pre>';

	$respuestaXML = htmlspecialchars_decode($client->responseData, ENT_NOQUOTES);

	$cosasQuitaXml = array('<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/"><s:Body><Salida xmlns="http://tempuri.org/"><strSalida>','</strSalida></Salida></s:Body></s:Envelope>');
	$cosasPonerXml = array('','');
	$respuestaXmlDepurada = str_replace($cosasQuitaXml, $cosasPonerXml, $respuestaXML);
	//file_put_contents('prueba.xml',$respuestaXmlDepurada);
	$datosPersona = simplexml_load_string($respuestaXmlDepurada); 
		$datosEmision = array('TRANID'=>$datosPersona->TRANSACCION->TRANID,'PID'=>$datosPersona->PERSONA->PID,'DIRID'=>$datosPersona->DIRECCIONES->DIR->DIRID);

	return
		$datosEmision;
		//$persona[0]->PID;
//		'<h2>Request</h2><pre>'.htmlspecialchars($client->request, ENT_QUOTES).'</pre>';
//		'<h2>Response</h2><pre>'.htmlspecialchars($client->response, ENT_QUOTES).'</pre>';	
}

//-->if(isset($rePerAba)){
function regisPersonaAba($TP,$RFC,$HCVE,$PNOM,$SNOM,$APP,$APM,$SEXO,$EDOCIVIL,$CALLE,$NUMEXT,$NUMINT,$COL,$CP,$POB,$NUMERO_TELEFONO,$NUMERO_CELULAR,$CORREO){
	require_once('nusoap-0.9.5-Aba-Personas/lib/nusoap.php');
	$urlCliente = "http://www5.abaseguros.com/PersonaConnect/PCRegistro.svc?wsdl"; // url del WSDL
	$pass = "VIRTUAL1$";
	$user = "WSAGECAP";
	$client = new nusoap_client($urlCliente, true);

			  $ladaTelefono = substr($NUMERO_TELEFONO,0,2);
			  $numeroTelefono = substr($NUMERO_TELEFONO,2,8);
			  $ladaCelular = substr($NUMERO_CELULAR,0,2);
			  $numeroCelular = substr($NUMERO_CELULAR,2,8);
/*		  
	$header = '
    	  <tem:strEntrada>
			&lt;XML&gt;
				&lt;DP&gt;
					&lt;TP&gt;'.$TP.'&lt;/TP&gt; <!-- 1:Moral; 0:fisica; -->
					&lt;FISICA&gt;
						&lt;RFC&gt;'.$RFC.'&lt;/RFC&gt;
						&lt;HCVE&gt;'.$HCVE.'&lt;/HCVE&gt;
						&lt;PNOM&gt;'.$PNOM.'&lt;/PNOM&gt;
						&lt;SNOM&gt;'.$SNOM.'&lt;/SNOM&gt;
						&lt;APP&gt;'.$APP.'&lt;/APP&gt;
						&lt;APM&gt;'.$APM.'&lt;/APM&gt;
						&lt;SEXO&gt;'.$SEXO.'&lt;/SEXO&gt; <!-- 0:Femenino; 1:Masculino; -->
						&lt;EDOCIVIL&gt;'.$EDOCIVIL.'&lt;/EDOCIVIL&gt; <!-- 1:Casado; 2:Soltero; 3:Viudo; 4:Divorciado; -->
					&lt;/FISICA&gt;
					&lt;DOMICILIO&gt;
						&lt;TIPODIR&gt;1&lt;/TIPODIR&gt; <!-- 1:Particular; 2:Domicilio Extranjero; 3:Fiscal; -->
						&lt;CALLE&gt;'.$CALLE.'&lt;/CALLE&gt;
						&lt;NUMEXT&gt;'.$NUMEXT.'&lt;/NUMEXT&gt;
						&lt;NUMINT&gt;'.$NUMINT.'&lt;/NUMINT&gt;
						&lt;COL&gt;'.$COL.'&lt;/COL&gt;
						&lt;CP&gt;'.$CP.'&lt;/CP&gt;
						&lt;POB&gt;'.$POB.'&lt;/POB&gt;
					&lt;/DOMICILIO&gt;
					&lt;TELEFONO&gt;
						&lt;LADA&gt;'.$ladaTelefono.'&lt;/LADA&gt;
						&lt;NUMERO&gt;'.$numeroTelefono.'&lt;/NUMERO&gt;
					&lt;/TELEFONO&gt;
					&lt;CELULAR&gt;
						&lt;LADA&gt;'.$ladaCelular.'&lt;/LADA&gt;
						&lt;NUMERO&gt;'.$numeroCelular.'&lt;/NUMERO&gt;
					&lt;/CELULAR&gt;
					&lt;CORREO&gt;'.$CORREO.'&lt;/CORREO&gt;
				&lt;/DP&gt;
			&lt;/XML&gt;
    	  </tem:strEntrada>
    	  <tem:Token>
        	 <abas:password>'.$pass.'</abas:password>
	         <abas:usuario>'.$user.'</abas:usuario>
	      </tem:Token>
			  ';
*/
$header = "<tem:strEntrada>
			&lt;XML&gt;
				&lt;DP&gt;
					&lt;TP&gt;".$TP."&lt;/TP&gt;
					&lt;FISICA&gt;
						&lt;RFC&gt;".$RFC."&lt;/RFC&gt;
						&lt;HCVE&gt;".$HCVE."&lt;/HCVE&gt;
						&lt;PNOM&gt;".$PNOM."&lt;/PNOM&gt;
						&lt;SNOM&gt;".$SNOM."&lt;/SNOM&gt;
						&lt;APP&gt;".$APP."&lt;/APP&gt;
						&lt;APM&gt;".$APM."&lt;/APM&gt;
						&lt;SEXO&gt;".$SEXO."&lt;/SEXO&gt;
						&lt;EDOCIVIL&gt;".$EDOCIVIL."&lt;/EDOCIVIL&gt;
					&lt;/FISICA&gt;
					&lt;DOMICILIO&gt;
						&lt;TIPODIR&gt;1&lt;/TIPODIR&gt;
						&lt;CALLE&gt;".$CALLE."&lt;/CALLE&gt;
						&lt;NUMEXT&gt;".$NUMEXT."&lt;/NUMEXT&gt;
						&lt;NUMINT&gt;".$NUMINT."&lt;/NUMINT&gt;
						&lt;COL&gt;".$COL."&lt;/COL&gt;
						&lt;CP&gt;".$CP."&lt;/CP&gt;
						&lt;POB&gt;".$POB."&lt;/POB&gt;
					&lt;/DOMICILIO&gt;
					&lt;TELEFONO&gt;
						&lt;LADA&gt;".$ladaTelefono."&lt;/LADA&gt;
						&lt;NUMERO&gt;".$numeroTelefono."&lt;/NUMERO&gt;
					&lt;/TELEFONO&gt;
					&lt;CELULAR&gt;
						&lt;LADA&gt;".$ladaCelular."&lt;/LADA&gt;
						&lt;NUMERO&gt;".$numeroCelular."&lt;/NUMERO&gt;
					&lt;/CELULAR&gt;
					&lt;CORREO&gt;".$CORREO."&lt;/CORREO&gt;
				&lt;/DP&gt;
			&lt;/XML&gt;
    	  </tem:strEntrada>
    	  <tem:Token>
        	 <abas:password>".$pass."</abas:password>
	         <abas:usuario>".$user."</abas:usuario>
	      </tem:Token>";


	$client->setHeaders($header);
	$client->soap_defencoding = 'UTF-8';
	$client->decode_utf8 = false;
	$xml = '';

	$client->call('RegistraPersona', '', 'http://tempuri.org/PCRegistro/', 'http://tempuri.org/PCRegistro/RegistraPersona', false, false, false, false);

//--> echo	'<h2>Request</h2><pre>'.htmlspecialchars($client->request, ENT_QUOTES).'</pre>'; //-->
//--> echo 	'<h2>Response</h2><pre>'.htmlspecialchars($client->response, ENT_QUOTES).'</pre>'; //-->
	file_put_contents('prueba.xml',$respuestaXmlDepurada);
	
	if(!$client->fault){

	$respuestaXML = htmlspecialchars_decode($client->responseData, ENT_NOQUOTES);

	$cosasQuitaXml = array('<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/"><s:Body><Salida xmlns="http://tempuri.org/"><strSalida>','</strSalida></Salida></s:Body></s:Envelope>','<s:Envelope xmlns:s="http://schemas.xmlsoap.org/soap/envelope/"><s:Body><s:Fault>','</s:Fault></s:Body></s:Envelope>');
	$cosasPonerXml = array('','');
	$respuestaXmlDepurada = str_replace($cosasQuitaXml, $cosasPonerXml, $respuestaXML);
	file_put_contents('prueba.xml',$respuestaXmlDepurada);
	$datosPersona = simplexml_load_string($respuestaXmlDepurada); 
//	$datosPersona = simplexml_load_file('prueba.xml');
	//foreach($datosPersona as $persona){ /* */ }
		$return =  "registramos a la persona"; //stristr($client->faultstring,'base');
	} else {
		$idInternoAbaPersona = BusquedaPersonaRFC($TP,$RFC.$HCVE);
		$return = BusquedaDireccionPersona($TP,$idInternoAbaPersona);
	}

	return
		$return;
//-->		print($idInternoAbaPersona);
		//--> print($header);
		//-->print('<h2>Request</h2><pre>'.htmlspecialchars($client->request, ENT_QUOTES).'</pre>'.'<h2>Response</h2><pre>'.htmlspecialchars($client->response, ENT_QUOTES).'</pre>');
//-->		print('<h2>Response</h2><pre>'.htmlspecialchars($client->response, ENT_QUOTES).'</pre>');
		//print_r($persona);
		//-->print($client->fault);
		//-->print_r($client->faultcode);
		//-->print_r($client->faultstring);
		//$persona[0]->PID;
//		print('<h2>Request</h2><pre>'.htmlspecialchars($client->request, ENT_QUOTES).'</pre>');
} // fin funcion original
//-->}


	/* abrir archivo xml cotizacion y crear xml para emision */
	switch($pathAseguradora){
	
	/*1*/
		case "qualitas":
			//--> echo "entramos a crear emision de qualitas";
			$datosCotizacion  =  simplexml_load_file("xmlTodos/$pathAseguradora/".$archivoXmlCotizacion); 
			
			if($datosCotizacion){
				//--> echo "Si Cargamos el XML";
				foreach($datosCotizacion->Movimiento as $cotizacion){
					//--> echo $cotizacion->DatosAsegurado->Nombre;
					//--> echo "<pre>";
						//--> print_r($cotizacion);
					//--> echo "</pre>";
							
				/* proceso de creacion del XML EMISION */
				$NombreCompleto = $rowProspectoCliente['RAZON_SOCIAL']; /* $cotizacion->DatosAsegurado->Nombre; */
				$Direccion = $rowProspectoCliente['CALLE']." x ".$rowProspectoCliente['REFERENCIA']." y ".$rowProspectoCliente['REFERENCIA2']; /* $cotizacion->DatosAsegurado->Direccion; */
				$Colonia = $rowProspectoCliente['COLONIA']; /* $cotizacion->DatosAsegurado->Colonia; */
				$Poblacion = $rowProspectoCliente['LOCALIDAD']; /* $cotizacion->DatosAsegurado->Poblacion; */
				$Estado = $cotizacion->DatosAsegurado->Estado;
				$CodigoPostal = $cotizacion->DatosAsegurado->CodigoPostal;
				$NumeroExterior = $rowProspectoCliente['NOEXTERIOR']; /* $cotizacion->DatosAsegurado->ConsideracionesAdicionalesDA[0]->ValorRegla; */
				$Pais = $cotizacion->DatosAsegurado->ConsideracionesAdicionalesDA[2]->ValorRegla;
				$NombrePrimero = $rowProspectoCliente['NOMBRES']; /* $cotizacion->DatosAsegurado->ConsideracionesAdicionalesDA[3]->ValorRegla; */
				$ApellidoPaterno = $rowProspectoCliente['APELLIDO_PATERNO']; /* $cotizacion->DatosAsegurado->ConsideracionesAdicionalesDA[4]->ValorRegla; */
				$ApellidoMaterno = $rowProspectoCliente['APELLIDO_MATERNO']; /* $cotizacion->DatosAsegurado->ConsideracionesAdicionalesDA[5]->ValorRegla; */
// Tipo Persona Qualitas
if($rowProspectoCliente['TIPO_PERSONA'] == "F"){ $TipoPersona = "1"; } else  if($rowProspectoCliente['TIPO_PERSONA'] == "M"){ $TipoPersona = "2"; }
				//--> $TipoPersona = $rowProspectoCliente['TIPO_PERSONA'];
// Fecha Nacimiento Qualitas
$fechaNac = explode('-',$rowProspectoCliente['FECHA_NACIMIENTO']);
	$FechaNacimiento = $fechaNac[2]."/".$fechaNac[1]."/".$fechaNac[0];
				//--> $FechaNacimiento = $rowProspectoCliente['FECHA_NACIMIENTO'];
				$Rfc = $rowProspectoCliente['RFC'];
				$Telefono = $rowProspectoCliente['TELEFONO_MOVIL'];
				$ClaveAmis = $cotizacion->DatosVehiculo->ClaveAmis;
				$Modelo = $cotizacion->DatosVehiculo->Modelo;
				$DescripcionVehiculo = str_replace('"','&quot;',$cotizacion->DatosVehiculo->DescripcionVehiculo);
				$Uso = $cotizacion->DatosVehiculo->Uso;
				$Servicio = $cotizacion->DatosVehiculo->Servicio;
				$Paquete = $cotizacion->DatosVehiculo->Paquete;
				$Motor = $cotizacion->DatosVehiculo->Paquete;
				$Serie = $cotizacion->DatosVehiculo->Paquete;
				$valorFactura = $cotizacion->DatosVehiculo->Coberturas[0]->SumaAsegurada; //
				$SumaAsegurada = $cotizacion->DatosVehiculo->Coberturas[0]->TipoSuma; //
				$FechaEmision = $cotizacion->DatosGenerales->FechaEmision;
				$FechaInicio = $cotizacion->DatosGenerales->FechaInicio;
				$FechaTermino = $cotizacion->DatosGenerales->FechaTermino;
				$FormaPago = $cotizacion->DatosGenerales->FormaPago;
				$PorcentajeDescuento = $cotizacion->DatosGenerales->PorcentajeDescuento;
				$plazoPago = $cotizacion->DatosGenerales->ConsideracionesAdicionalesDG[2]->ValorRegla;
				}
			}
		break;
		
	/*2*/
		case "aba":
			//--> echo "entramos a crear emision de Aba";
			$datosCotizacion  =  simplexml_load_file("xmlTodos/$pathAseguradora/".$archivoXmlCotizacion); 
			
			if($datosCotizacion){				
				//-->echo "<pre>";
					//-->print_r($datosCotizacion);
				//-->echo "</pre>";
				//--> echo "Si Cargamos el XML";
				//*foreach($datosCotizacion as $cotizacion){
					//-->echo $cotizacion->DatosAsegurado->Nombre;
					//echo "<pre>";
					//	print_r($cotizacion);
					//echo "</pre>";
							
				/* proceso de creacion del XML EMISION */
				//*}
			}
		break;
		
	/*3*/
		case "hdi":
			//--> echo "entramos a crear emision de Hdi";
			$datosCotizacion  =  simplexml_load_file("xmlTodos/$pathAseguradora/".$archivoXmlCotizacion); 
			
			if($datosCotizacion){
				//--> echo "Si Cargamos el XML";
			//-->foreach($datosCotizacion->Movimiento as $cotizacion){
					//--> echo $cotizacion->DatosAsegurado->Nombre;
							
				/* proceso de creacion del XML EMISION */
			//-->}
			}
		break;
		
	/*4*/
		case "ana":
			//--> echo "entramos a crear emision de Ana";
			$datosCotizacion  =  simplexml_load_file("xmlTodos/$pathAseguradora/".$archivoXmlCotizacion); 
			
			if($datosCotizacion){
				//--> echo "Si Cargamos el XML";
			//-->foreach($datosCotizacion->Movimiento as $cotizacion){
					//--> echo $cotizacion->DatosAsegurado->Nombre;
							
				/* proceso de creacion del XML EMISION */
			//-->}
			}
		break;

	/*5*/
		case "rsa":
			//--> echo "entramos a crear emision de Royal Sun Alliace";
			$datosCotizacion  =  simplexml_load_file("xmlTodos/$pathAseguradora/".$archivoXmlCotizacion); 
			
			if($datosCotizacion){
				//--> echo "Si Cargamos el XML";
			//-->foreach($datosCotizacion->Movimiento as $cotizacion){
					//--> echo $cotizacion->DatosAsegurado->Nombre;
							
				/* proceso de creacion del XML EMISION */
			//-->}
			}
		break;

	} // fin del Switch
?>
<br />
<table width="800" cellpadding="2" cellspacing="2" border="0" align="center" style="font-size:10px; font-weight:bold;">
<?php

	$sqlBuscamosImpresionPoliza = "
		Select Count(*) As `impresionPoliza` From
			`ws_impresion_poliza`
		Where 
			`idActividad` Like '%$recId%'
								  ";
	$resBuscamosImpresionPoliza = DreQueryDB($sqlBuscamosImpresionPoliza);
	$rowBuscamosImpresionPoliza = mysql_fetch_assoc($resBuscamosImpresionPoliza);
								  
	if((int)$rowBuscamosImpresionPoliza['impresionPoliza'] <= 0){ // si existe una impresion de poliza la mostramos
?>
	<tr>
    	<td colspan="2" class="TextoTitulosEdicionAgregar" style="font-size:16px;">
        	Autom&oacute;viles <? echo ($existeCotizacionWs == "1")? "Web Services":""; ?><br><br>
		</td>
   	</tr>
<form name="formEmisiones" id="formEmisiones" method="post" action="includes/guardar.php?tipoGuardar=emisiones">
<?php
	switch($pathAseguradora){ // switch formularios
	
	/*1*/
		case "qualitas":
?>
<!-- Formulario de Emision Qualitas -->
	<tr>
	  <td width="180" align="right">Nombre Completo: </td>
	  <td><input name="NombreCompleto" type="text" id="NombreCompleto" value="<?php echo $NombreCompleto; ?>" style="width:99%;" /></td>
    </tr>
	<tr>
	  <td align="right">Direcci&oacute;n: </td>
	  <td><input name="Direccion" type="text" id="Direccion" value="<?php echo $Direccion; ?>" style="width:99%;" /></td>
    </tr>
	<tr>
	  <td align="right">Colonia: </td>
	  <td><input name="Colonia" type="text" id="Colonia" value="<?php echo $Colonia; ?>" style="width:50%;" /></td>
    </tr>
	<tr>
	  <td align="right">Poblacion: </td>
	  <td><input name="Poblacion" type="text" id="Poblacion" value="<?php echo $Poblacion; ?>" style="width:50%;" /></td>
  </tr>
	<tr>
	  <td align="right">Estado: </td>
	  <td>
<!-- -->
<?
	$sqlEstadosQualitas = "
		Select 
			`id`
			,`nombre_estado`
		From 
			`estados`
						  ";
	$resEstadoQualitas = DreQueryDB($sqlEstadosQualitas);
?>
		<select name="Estado" id="Estado">
        	<option value="">-- Seleccione --</option>
            <?
			while($rowEstadosQualitas = mysql_fetch_assoc($resEstadoQualitas)){
			?>
        	<option value="<? echo $rowEstadosQualitas['id']; ?>" <? echo ($rowEstadosQualitas['id'] == $Estado)? "selected":""; ?>><? echo $rowEstadosQualitas['nombre_estado'];?></option>
            <?
			}
			?>
        </select>
      <!-- <input name="Estado" type="text" id="Estado" value="<?php //echo $Estado; ?>" /> -->
<!-- -->
      </td>
    </tr>
	<tr>
	  <td align="right">Codigo Postal: </td>
	  <td><input name="CodigoPostal" type="text" id="CodigoPostal" value="<?php echo $CodigoPostal; ?>" /></td>
    </tr>
	<tr>
	  <td align="right">Numero Exterior: </td>
	  <td><input name="NumeroExterior" type="text" id="NumeroExterior" value="<?php echo $NumeroExterior; ?>" /></td>
    </tr>
	<tr>
	  <td align="right">Pais: </td>
	  <td><input name="Pais" type="text" id="Pais" value="<?php echo $Pais; ?>" /></td>
    </tr>
	<tr>
	  <td align="right">Nombre: </td>
	  <td><input name="NombrePrimero" type="text" id="NombrePrimero" value="<?php echo $NombrePrimero; ?>" style="width:50%;" /></td>
    </tr>
	<tr>
	  <td align="right">Apellido Paterno: </td>
	  <td><input name="ApellidoPaterno" type="text" id="ApellidoPaterno" value="<?php echo $ApellidoPaterno; ?>" style="width:50%;" /></td>
    </tr>
	<tr>
	  <td align="right">Apellido Materno: </td>
	  <td><input name="ApellidoMaterno" type="text" id="ApellidoMaterno" value="<?php echo $ApellidoMaterno; ?>" style="width:50%;" /></td>
    </tr>
	<tr>
	  <td align="right">Tipo Persona: </td>
	  <td>
		<select name="TipoPersona" id="TipoPersona">
        	<option value="">-- Seleccione --</option>
            <option value="1" <? echo ($TipoPersona == "1")? "selected":""; ?>>Persona F&iacute;sica</option>
            <option value="2" <? echo ($TipoPersona == "2")? "selected":""; ?>>Persona Moral</option>
        </select>
<!--
      <input name="TipoPersona" type="text" id="TipoPersona" value="<?php //echo $TipoPersona; ?>" />
-->
      </td>
    </tr>
	<tr>
	  <td align="right">FechaNacimiento: </td>
	  <td>
      	<input name="FechaNacimiento" type="text" id="FechaNacimiento" value="<?php echo $FechaNacimiento; ?>" />
        <img src="img/cal.gif" width="16" height="16" id="FechaNacimiento_Btn" border="0" title="Clic" />
      </td>
    </tr>
	<tr>
	  <td align="right">Rfc: </td>
	  <td><input name="Rfc" type="text" id="Rfc" value="<?php echo $Rfc; ?>" /></td>
    </tr>
	<tr>
	  <td align="right">Telefono: </td>
	  <td><input name="Telefono" type="text" id="Telefono" value="<?php echo $Telefono; ?>" /></td>
    </tr>
	<tr>
	  <td align="right">ClaveAmis: </td>
	  <td><input name="ClaveAmis" type="text" id="ClaveAmis" value="<?php echo $ClaveAmis; ?>" readonly /></td>
    </tr>
	<tr>
	  <td align="right">Modelo: </td>
	  <td><input name="Modelo" type="text" id="Modelo" value="<?php echo $Modelo; ?>" readonly /></td>
    </tr>
	<tr>
	  <td align="right">Descripcion: </td>
	  <td><input name="DescripcionVehiculo" type="text" id="DescripcionVehiculo" value="<?php echo $DescripcionVehiculo; ?>" style="width:99%;" readonly /></td>
    </tr>
	<tr>
	  <td align="right">Uso: </td>
	  <td>
      <select name="Uso" id="Uso">
      	<option value="1">Normal</option>
      </select>
<!--      <input name="Uso" type="text" id="Uso" value="<?php //echo $Uso; ?>" /> -->
      </td>
    </tr>
	<tr>
	  <td align="right">Servicio: </td>
	  <td>
      <select name="Servicio" id="Servicio">
      	<option value="1">Particular</option>
      </select>
<!--      <input name="Servicio" type="text" id="Servicio" value="<?php //echo $Servicio; ?>" /> -->
      </td>
    </tr>
	<tr>
	  <td align="right">Paquete: </td>
	  <td>
      <select name="Paquete" id="Paquete">
      	<option value="1">Amplia</option>
      </select>
<!--      <input name="Paquete" type="text" id="Paquete" value="<?php //echo $Paquete; ?>" /> -->
      </td>
    </tr>
	<tr>
	  <td align="right">Motor: </td>
	  <td><input name="Motor" type="text" id="Motor" value="<?php echo $Motor; ?>" style="width:25%; background-color:#FF8385;" /></td>
    </tr>
	<tr>
	  <td align="right">Serie: </td>
	  <td><input name="Serie" type="text" id="Serie" value="<?php echo $Serie; ?>" style="width:50%; background-color:#FF8385;" /></td>
    </tr>
	<tr>
	  <td align="right">Suma Asegurada: </td>
	  <td>
      <select name="SumaAsegurada" id="SumaAsegurada">
      	<option value="0" <? echo ($SumaAsegurada == "0")? "selected":""; ?>>Valor Convenido</option>
      	<option value="01" <? echo ($SumaAsegurada == "01")? "selected":""; ?>>Valor Factura</option>
      	<option value="03" <? echo ($SumaAsegurada == "03")? "selected":""; ?>>Valor Comercial</option>
      </select>
<!--      <input name="SumaAsegurada" type="text" id="SumaAsegurada" value="<?php //echo $SumaAsegurada; ?>" /> -->
      </td>
    </tr>
<?php
	if($SumaAsegurada == "01"){
?>
	<tr>
	  <td align="right">Valor Factura: </td>
	  <td><input type="text" name="valorFactura" id="valorFactura" value="<? echo $valorFactura; ?>"  onKeyPress="return(currencyFormat(this,',','.',event))" /></td>
    </tr>
<?php
	}
?>
	<tr>
	  <td align="right">FechaEmision: </td>
	  <td><input name="FechaEmision" type="text" id="FechaEmision" value="<?php echo $FechaEmision; ?>" readonly /></td>
    </tr>
	<tr>
	  <td align="right">FechaInicio: </td>
	  <td><input name="FechaInicio" type="text" id="FechaInicio" value="<?php echo $FechaInicio; ?>" readonly /></td>
    </tr>
	<tr>
	  <td align="right">FechaTermino: </td>
	  <td><input name="FechaTermino" type="text" id="FechaTermino" value="<?php echo $FechaTermino; ?>" readonly /></td>
    </tr>
	<tr>
	  <td align="right">FormaPago: </td>
	  <td>
      <select name="FormaPago" id="FormaPago">
      	<option value="">-- Seleccione --</option>
      	<option value="C" <? echo ($FormaPago == "C")? "selected":""; ?>>Contado</option>
      	<option value="S" <? echo ($FormaPago == "S")? "selected":""; ?>>Semestral</option>
      	<option value="T" <? echo ($FormaPago == "T")? "selected":""; ?>>Trimestral</option>
      	<option value="M" <? echo ($FormaPago == "M")? "selected":""; ?>>Mensual</option>
      </select>
      <!-- <input name="FormaPago" type="text" id="FormaPago" value="<?php // echo $FormaPago; ?>" /> -->
      </td>
    </tr>
<!-- -->
<? if($_SESSION['WebDreTacticaWeb2']['Integral'] == "1"){?>
	<tr>
	  <td align="right">PorcentajeDescuento: </td>
	  <td>
	  <?php echo SelectDescuentoAseguradora('Qualitas', 20, 1, $PorcentajeDescuento); ?>
      <!-- <input name="PorcentajeDescuento" type="text" id="PorcentajeDescuento" value="<?php //echo $PorcentajeDescuento; ?>" /> -->
      </td>
    </tr>
<? } ?>
<!-- -->
	<tr>
	  <td colspan="2" align="right">
      <input type="hidden" name="SumaAsegurada" id="SumaAsegurada" value="<? echo $SumaAsegurada; ?>" />      
      <input type="hidden" name="Sucursal" id="Sucursal" value="<? echo $rowProspectoCliente['SUCURSAL']; ?>" />
      <input type="hidden" name="Usuario" id="Usuario" value="<? echo $_SESSION['WebDreTacticaWeb2']['Usuario']; ?>" />
      <input type="hidden" name="idCliente" id="idCliente" value="<? echo $rowProspectoCliente['CLAVE']; ?>" />
      <input type="hidden" name="plazoPago" id="plazoPago" value="<? echo $plazoPago; ?>" />
      <input type="hidden" name="idInterno" id="idInterno" value="<?php echo $rowDatosActividad['idInterno']; ?>" />
      <input type="hidden" name="recId" id="recId" value="<?php echo $rowDatosActividad['recId']; ?>" />
      <input type="hidden" name="aseguradora" id="aseguradora" value="<? echo $pathAseguradora; ?>" />
      <input type="button" value="Emision Poliza" onclick="java:document.formEmisiones.submit()" />
      &nbsp;&nbsp;&nbsp;

      </td>
  </tr>
<!-- -->
<?php
	break;
	
	/*2*/
		case "aba":	
?>
<!-- Formulario de Emision Aba -->
	<tr>
    	<td colspan="2">&nbsp;</td>
    </tr>
<?php
	if(!isset($rePerAba) || $rePerAba = ""){
?>
    <?php
		$urlTpAba = $_SERVER['PHP_SELF']."?recId=".$recId."&muestra=Formularios&TP=";
	?>
	<tr>
    	<td align="right">Tipo Persona:</td>
    	<td>
        	<select name="TP" id="TP" onChange="window.open('<?php echo $urlTpAba; ?>'+document.formEmisiones.TP.value+'#Formularios','_self');">
            	<option value="">-- Seleccione --</option>
            	<option value="0" <? echo ($rowProspectoCliente['TIPO_PERSONA'] == "F" || $TP=="0")? "selected":""; ?>>Fisica</option>
<!--                <option value="1" <? //echo ($rowProspectoCliente['TIPO_PERSONA'] == "M" || $TP=="1")? "selected":""; ?>>Moral</option> -->
            </select>
        </td>
    </tr>
    <?php
		// Validamos el Tipo de Persona
		if(!isset($TP)){
			if($rowProspectoCliente['TIPO_PERSONA']=="F"){
				$TP="0";
			} else if($rowProspectoCliente['TIPO_PERSONA']=="M"){
				$TP="1";
			}
		}
		
		if($TP=="0"){ //
	?>
	<tr>
    	<td align="right">Rfc:</td>
        <td><input type="text" name="RFC" id="RFC" value="<?php echo substr($rowProspectoCliente['RFC'],0,10);?>" /></td>
	</tr>
	<tr>
    	<td align="right">Homo Clave:</td>
        <td><input type="text" name="HCVE" id="HCVE" value="<?php echo substr($rowProspectoCliente['RFC'],10,4);?>" /></td>
	</tr>
	<tr>
    	<td align="right">Primer Nombre:</td>
        <td><input type="text" name="PNOM" id="PNOM" value="<?php echo substr($rowProspectoCliente['NOMBRES'],0,strpos($rowProspectoCliente['NOMBRES'],' '));?>" /></td>
	</tr>
	<tr>
    	<td align="right">Segundo Nombre:</td>
        <td><input type="text" name="SNOM" id="SNOM" value="<?php echo ltrim(substr($rowProspectoCliente['NOMBRES'],strpos($rowProspectoCliente['NOMBRES'],' '),strlen($rowProspectoCliente['NOMBRES'])));?>" /></td>
	</tr>
	<tr>
    	<td align="right">Apellido Paterno:</td>
        <td><input type="text" name="APP" id="APP" value="<?php echo $rowProspectoCliente['APELLIDO_PATERNO']; ?>" /></td>
	</tr>
	<tr>
    	<td align="right">Apellido Materno:</td>
        <td><input type="text" name="APM" id="APM" value="<?php echo $rowProspectoCliente['APELLIDO_MATERNO']; ?>" /></td></td>
	</tr>
	<tr>
    	<td align="right">Sexo:</td>
        <td>
        <select name="SEXO" id="SEXO">
        	<option value="">-- Seleccione --</option>
        	<option value="0" <? echo ($rowProspectoCliente['GENERO'] == "F")? "selected":""; ?>>Femanino</option>
        	<option value="1" <? echo ($rowProspectoCliente['GENERO'] == "M")? "selected":""; ?>>Masculino</option>
        </select>
      </td>
	</tr>
	<tr>
    	<td align="right">Estado Civil:</td>
        <td>
		<select name="EDOCIVIL" id="EDOCIVIL">
        	<option value="">-- Seleccione --</option>
            <option value="1" <? echo ($rowProspectoCliente['ESTADO_CIVIL'] == "Casado")? "selected":"Casado"; ?>>Casado</option>
            <option value="2" <? echo ($rowProspectoCliente['ESTADO_CIVIL'] == "Soltero")? "selected":"Soltero"; ?>>Soltero</option>
            <option value="3" <? echo ($rowProspectoCliente['ESTADO_CIVIL'] == "Viudo")? "selected":"Viudo"; ?>>Viudo</option>
            <option value="4" <? echo ($rowProspectoCliente['ESTADO_CIVIL'] == "Divorciado")? "selected":"Divorciado"; ?>>Divorciado</option>
        </select>
      </td>
	</tr>
    <?php
		} else { //
	?>
	<tr>
    	<td>Persona Moral</td>
        <td>Persona Moral</td>
    </tr>
    <?php
		}
	?>
    <tr>
   	  <td>Tipo Direccion:</td>
      <td>TIPODIR</td>
    </tr>
    <tr>
    	<td align="right">Calle:</td>
      <td><input type="text" name="CALLE" id="CALLE" value="<? echo $rowProspectoCliente['CALLE']; ?>" /></td>
    </tr>
    <tr>
    	<td align="right">Numero Exterior:</td>
      <td><input type="text" name="NUMEXT" id="NUMEXT" value="<? echo $rowProspectoCliente['NOEXTERIOR']; ?>" /></td>
    </tr>
    <tr>
    	<td align="right">Numero Interior:</td>
      <td><input type="text" name="NUMINT" id="NUMINT" value="<? echo $rowProspectoCliente['NOINTERIOR']; ?>" /></td>
    </tr>
    <tr>
    	<td align="right">Colonia:</td>
      <td><input type="text" name="COL" id="COL" value="<? echo $rowProspectoCliente['COLONIA']; ?>" /></td>
    </tr>
    <tr>
    	<td align="right">Codigo Postal:</td>
      <td><input type="text" name="CP" id="CP" value="<? echo $rowProspectoCliente['CODIGO_POSTAL']; ?>" /></td>
    </tr>
    <tr>
    	<td align="right">Poblacion:</td>
      <td><input type="text" name="POB" id="POB" value="<? echo $rowProspectoCliente['LOCALIDAD']; ?>" /></td>
    </tr>
    <tr>
    	<td align="right">Telefono:</td>
      <td><input type="text" name="NUMERO_TELEFONO" id="NUMERO_TELEFONO" value="<? echo $rowProspectoCliente['TELEFONO_PARTICULAR']; ?>" /></td>
    </tr>
    <tr>
    	<td align="right">Celular:</td>
      <td><input type="text" name="NUMERO_CELULAR" id="NUMERO_CELULAR" value="<? echo $rowProspectoCliente['TELEFONO_MOVIL']; ?>" /></td>
    </tr>
    <tr>
    	<td align="right">Correo Electronico:</td>
      <td><input type="text" name="CORREO" id="CORREO" value="<? echo $rowProspectoCliente['email']; ?>" /></td>
    </tr>
	<tr>
    	<td></td>
    	<td>
        	<input type="hidden" name="rePerAba" id="rePerAba" value="TRUE" />
        	<input type="button" value="Siguiente" onClick="registrarPersonaAba('<? echo $_SERVER['PHP_SELF']."?recId=".$recId."&muestra=Formularios"?>');" />
        </td>
    </tr>
<?php
	}else{
	$complementosPersonaAba = regisPersonaAba($TP,$RFC,$HCVE,$PNOM,$SNOM,$APP,$APM,$SEXO,$EDOCIVIL,$CALLE,$NUMEXT,$NUMINT,$COL,$CP,$POB,$NUMERO_TELEFONO,$NUMERO_CELULAR,$CORREO);
?>
    <tr>
    	<td>Serie:</td>
        <td><input type="text" name="SERIE" id="SERIE" /></td>
    </tr>
    <tr>
    	<td>Motor:</td>
        <td><input type="text" name="MOTOR" id="MOTOR" /></td>
    </tr>
    <tr>
    	<td>Placas:</td>
        <td><input type="text" name="PLACAS" id="PLACAS" /></td>
    </tr>
    <tr>
    	<td colspan="2">
        	<input type="hidden" name="COTID" id="COTID" value="<? echo $datosCotizacion->COTID; ?>" />
        	<input type="hidden" name="VERID" id="VERID" value="<? echo $datosCotizacion->VERID; ?>" />
        	<input type="hidden" name="COTINCID" id="COTINCID" value="<? echo $datosCotizacion->INCISOS->INCISO->COTINCID; ?>" />
        	<input type="hidden" name="VERINCID" id="VERINCID" value="<? echo $datosCotizacion->INCISOS->INCISO->VERINCID; ?>" />
        	<input type="hidden" name="ASEGID" id="ASEGID" value="<? echo $complementosPersonaAba['PID']; ?>" />
        	<input type="hidden" name="ASEGDIRID" id="ASEGDIRID" value="<? echo $complementosPersonaAba['DIRID']; ?>" />
        	<input type="hidden" name="ASEGTRANID" id="ASEGTRANID" value="<? echo $complementosPersonaAba['TRANID']; ?>" />
			<input type="hidden" name="aseguradora" id="aseguradora" value="<? echo $pathAseguradora; ?>" />
	 		<input type="hidden" name="recId" id="recId" value="<?php echo $rowDatosActividad['recId']; ?>" />
            <input type="button" value="Emision Poliza" onClick="java:document.formEmisiones.submit();" />
        </td>
    </tr>
<?php
	}
?>
    
<!-- -->
<?php
	break;
	
	/*3*/
		case "hdi":	
?>
<!-- Formulario de Emision Hdi -->
<!-- -->
<?php
	break;
	
	/*4*/
		case "ana":	
?>
<!-- Formulario de Emision Ana -->
<!-- -->
<?php
	break;
		
	/*5*/
		case "rsa":	
?>
<!-- Formulario de Emision Rsa -->
<!-- -->
<?php
	break;
	
	/*6*/
		case "zurich":	
?>
<!-- Formulario de Emision Zurich -->
<!-- -->
<?php
	break;
	
	} //fin del switch formularios
?>
</form> <!-- Fin del Formulario General -->
<?php
	} else { // fin si existe una impresion de poliza la mostramos

	switch($pathAseguradora){ // switch impresion embed
	
	/*1*/
		case "qualitas":
			$sqlImpresionPoliza_Qualitas = "
				Select * From
					`ws_impresion_poliza`
				Where 
					`idActividad` Like '%$recId%'
				Order By
					`ordenDocumentos` Asc
										   ";
			$resImpresionPoliza_Qualitas = DreQueryDB($sqlImpresionPoliza_Qualitas);
			while($rowImpresionPoliza_Qualitas = mysql_fetch_assoc($resImpresionPoliza_Qualitas)){
				$ulrImpresionPoliza = $rowImpresionPoliza_Qualitas['urlLink'];
				?>
                	<br><br><br>
					<embed src="<?php echo $ulrImpresionPoliza; ?>" width="100%" height="330">
                <?
			}
		break;
		
	/*2*/
		case "aba":
		break;
		
	/*3*/
		case "hdi":
		break;
		
	/*4*/
		case "ana":
		break;
		
	/*5*/
		case "rsa":
		break;	
		
	/*6*/
		case "zurich":
		break;	
	} // fin switch impresion embed

	} // fin si existe una impresion de poliza la mostramos
?>
</table>
<script type="text/javascript">
	function registrarPersonaAba(path){
		var f = document.formEmisiones;
		
		var TP = f.TP.value;
		var RFC = f.RFC.value;
		var HCVE = f.HCVE.value;
		var PNOM = f.PNOM.value;
		var SNOM = f.SNOM.value;
		var APP = f.APP.value;
		var APM = f.APM.value;
		var SEXO = f.SEXO.value;
		var EDOCIVIL = f.EDOCIVIL.value;
		var CALLE = f.CALLE.value;
		var NUMEXT = f.NUMEXT.value;
		var NUMINT = f.NUMINT.value;
		var COL = f.COL.value;
		var CP = f.CP.value;
		var POB = f.POB.value;
		var NUMERO_TELEFONO = f.NUMERO_TELEFONO.value;
		var NUMERO_CELULAR = f.NUMERO_CELULAR.value;
		var CORREO = f.CORREO.value;
		var rePerAba = f.rePerAba.value;
		
		var urlCompleta = path
							+'&TP='+TP
							+'&RFC='+RFC
							+'&HCVE='+HCVE
							+'&PNOM='+PNOM
							+'&SNOM='+SNOM
							+'&APP='+APP
							+'&APM='+APM
							+'&SEXO='+SEXO
							+'&EDOCIVIL='+EDOCIVIL
							+'&CALLE='+CALLE
							+'&NUMEXT='+NUMEXT
							+'&NUMINT='+NUMINT
							+'&COL='+COL
							+'&CP='+CP
							+'&POB='+POB
							+'&NUMERO_TELEFONO='+NUMERO_TELEFONO
							+'&NUMERO_CELULAR='+NUMERO_CELULAR
							+'&CORREO='+CORREO
							+'&rePerAba='+rePerAba;
				
		window.open(urlCompleta,'_self');
	}


	Calendar.setup({
		inputField : "FechaNacimiento",
		trigger    : "FechaNacimiento_Btn",
		onSelect   : function() { this.hide() },
		dateFormat : "%d/%m/%Y"
	});
	
   function currencyFormat(fld, milSep, decSep, e) { 
    var sep = 0; 
    var key = ''; 
    var i = j = 0; 
    var len = len2 = 0; 
    var strCheck = '0123456789'; 
    var aux = aux2 = ''; 
    var whichCode = (window.Event) ? e.which : e.keyCode; 
    if (whichCode == 13) return true;
    key = String.fromCharCode(whichCode);
    if (strCheck.indexOf(key) == -1) return false;
    len = fld.value.length; 
    for(i = 0; i < len; i++) 
     if ((fld.value.charAt(i) != '0') && (fld.value.charAt(i) != decSep)) break; 
    aux = ''; 
    for(; i < len; i++) 
     if (strCheck.indexOf(fld.value.charAt(i))!=-1) aux += fld.value.charAt(i); 
    aux += key; 
    len = aux.length; 
    if (len == 0) fld.value = ''; 
    if (len == 1) fld.value = '0'+ decSep + '0' + aux; 
    if (len == 2) fld.value = '0'+ decSep + aux; 
    if (len > 2) { 
     aux2 = ''; 
     for (j = 0, i = len - 3; i >= 0; i--) { 
      if (j == 3) { 
       aux2 += milSep; 
       j = 0; 
      } 
      aux2 += aux.charAt(i); 
      j++; 
     } 
     fld.value = ''; 
     len2 = aux2.length; 
     for (i = len2 - 1; i >= 0; i--) 
      fld.value += aux2.charAt(i); 
     fld.value += decSep + aux.substr(len - 2, len); 
    } 
    return false; 
   }    

</script>