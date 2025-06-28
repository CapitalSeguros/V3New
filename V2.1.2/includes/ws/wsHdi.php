<script language='javascript' src='../js/jquery-1.5.1.min.js'></script>
<script language='javascript' src='../js/jquery-ui-1.8.13.custom.min.js'></script>
<link rel='stylesheet' type='text/css' href='../css/jquery-ui-1.8.13.custom.css'/>

<?php
/*Formas Pago Qualitas*/
$formaPagoArray['Contado'] = "326"; 	//ANUAL
$formaPagoArray['Semestral'] = "327"; 	//SEMESTRAL
$formaPagoArray['Trimestral'] = "325"; 	//TRIMESTRAL
$formaPagoArray['Mensual'] = "324"; 	//MENSUAL
/*---------------*/

// Calculamos Clave Estado
$sqlCalculamosEstado = "
	Select * From 
		`ws_catalogo_estados_hdi`
	Where
		`Descripcion` Like '%$estado%'		
					   ";
$resCalculamosEstado = DreQueryDB($sqlCalculamosEstado);
$rowCalculamosEstado = mysql_fetch_assoc($resCalculamosEstado);
	$claveEstado = $rowCalculamosEstado['Clave'];
	
// Calculamos Clave MarcaVehiculo
$sqlCalculamosMarca = "
	Select * From
		`ws_catalogo_marcas_hdi` 
	Where
		`Descripcion` Like '%$wsMarca%'
					  ";
$resCalculamosMarca = DreQueryDB($sqlCalculamosMarca);
$rowCalculamosMarca = mysql_fetch_assoc($resCalculamosMarca);
	$claveMarca = $rowCalculamosMarca['Clave'];

// Descomponemos Para Calculo el MODELO
$tipoArray = explode(' ', $wsModelo);

/* TipoVehiculoCalculo */
//--> echo $idTipo;
if($idTipo == "" || !isset($idTipo)){ $idTipo = $tipoArray[0]; } else { $idTipo = $idTipo; }

function calculoVersion($IdMarca, $IdModelo, $IdTipo, $idVersion){

$xml='
    <getversions xmlns="http://hdi.com.mx/asmx/">
      <request>
        <IdNegocio></IdNegocio>
        <IdTipoVehiculo>4579</IdTipoVehiculo>
        <IdMarca>'.$IdMarca.'</IdMarca>
        <IdModelo>'.$IdModelo.'</IdModelo>
        <IdTipo>'.$IdTipo.'</IdTipo>
        <usuario></usuario>
      </request>
    </getversions>
	 ';
	 
$siteID = "ws055647"; //ws055647  // ws055647
$sitePwd = "GAPHDI1*";  // SEGEY11*  // GAP*agente1  //GAPHDI1*

$header= '
    <AuthenticateHeader xmlns="http://hdi.com.mx/asmx/">
      <siteID>'.$siteID.'</siteID>
      <sitePwd>'.$sitePwd.'</sitePwd>
    </AuthenticateHeader>
		 ';
		 
$urlConeccion = "https://serviceb2b.hdi.com.mx/Autos/PublicServicesAutos.asmx";
//$urlConeccion = "https://serviceb2b.hdi.com.mx/Autos/PublicServicesAutos.asmx"; //--> Produccion
//$urlConeccion = "https://unoautos.hdi.com.mx:8082/Terceros/PublicServicesAutos.asmx"; //--> Operacion
//$urlConeccion = "http://servicesimplementationb2b.hdi.com.mx/PublicServicesAutos.asmx"; //--> Pruebas


$client = new nusoap_client($urlConeccion, false);
$client->soap_defencoding = 'UTF-8';
$client->decode_utf8 = false;

$err = $client->getError();
if ($err) { echo '<h2>Constructor error</h2><pre>' . $err . '</pre>'; }

$result = $client->call('getversions', $xml,'http://hdi.com.mx/asmx/', 'http://hdi.com.mx/asmx/getversions',$header, false, false, false);

$respuestaXML = htmlspecialchars_decode($client->responseData, ENT_NOQUOTES);
$cosasQuitaXml = array('<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"><soap:Body><getversionsResponse xmlns="http://hdi.com.mx/asmx/"><getversionsResult>','</getversionsResult></getversionsResponse></soap:Body></soap:Envelope>');
$cosasPonerXml = array('', '');
$respuestaXmlDepurada = str_replace($cosasQuitaXml, $cosasPonerXml, $respuestaXML);

//--> $fileXML = "validacionHDI.xml";
//--> file_put_contents($fileXML, $respuestaXmlDepurada);

if(count($result['ListaVersiones']['Version']) > 1 ){
	
	$datosCotizacion  =  simplexml_load_string($respuestaXmlDepurada);

	$return="<select name='idVersion' id='idVersion' onChange='JavaScrip: document.formIdVersion.submit(); '>";
		$return.="<option value=''>-- Seleccione --</option>";
	foreach($datosCotizacion as $version){
		if($version->Clave == $idVersion){ $selected = "selected"; } else { $selected = ""; }	
		$return.="<option value='".(string)$version->Clave."' ".$selected.">".(string)$IdTipo." - ".(string)$version->Clave."</option>";
	}
	$return.="</select>";

} else {

	$return = false;

}
return
	$return;

}

function calculoTipoVehiculo($IdMarca, $IdModelo, $idTipo){

$xml='
    <gettypes xmlns="http://hdi.com.mx/asmx/">
      <request>
        <IdNegocio></IdNegocio>
        <IdTipoVehiculo>4579</IdTipoVehiculo>
        <IdMarca>'.$IdMarca.'</IdMarca>
        <IdModelo>'.$IdModelo.'</IdModelo>
      </request>
    </gettypes>	
	 ';
	 
$siteID = "ws055647";
$sitePwd = "GAPHDI1*";  // SEGEY11*  // GAP*agente1

$header= '
    <AuthenticateHeader xmlns="http://hdi.com.mx/asmx/">
      <siteID>'.$siteID.'</siteID>
      <sitePwd>'.$sitePwd.'</sitePwd>
    </AuthenticateHeader>
		 ';

$urlConeccion = "https://serviceb2b.hdi.com.mx/Autos/PublicServicesAutos.asmx ";
//$urlConeccion = "https://serviceb2b.hdi.com.mx/Autos/PublicServicesAutos.asmx"; //--> Produccion
//$urlConeccion = "https://unoautos.hdi.com.mx:8082/Terceros/PublicServicesAutos.asmx"; //--> Operacion
//$urlConeccion = "http://servicesimplementationb2b.hdi.com.mx/PublicServicesAutos.asmx"; //--> Pruebas

$client = new nusoap_client($urlConeccion, false);
$client->soap_defencoding = 'UTF-8';
$client->decode_utf8 = false;

$err = $client->getError();
if ($err) { echo '<h2>Constructor error</h2><pre>' . $err . '</pre>'; }

$result = $client->call('gettypes', $xml,'http://hdi.com.mx/asmx/', 'http://hdi.com.mx/asmx/gettypes',$header, false, false, false);

	$return="<select name='idTipo' id='idTipo' onChange='JavaScrip: document.formIdVersion.submit(); '>";
		$return.="<option value=''>-- Seleccione --</option>";
	foreach($result['ListaTipos']['Tipo'] as $Tipo){
		if($Tipo['Clave'] == $idTipo){ $selected = "selected"; } else { $selected = ""; }	
		$return.="<option value='".$Tipo['Clave']."' ".$selected.">$idTipo - ".$Tipo['Clave']."</option>";
	}
	$return.="</select>";

return
	print($return);
//	print($xml);
}

function calculoTransmision($IdMarca, $IdTipo, $IdVersion, $IdModelo){
$xml='
    <gettransmission xmlns="http://hdi.com.mx/asmx/">
      <request>
        <IdTipoVehiculo>4579</IdTipoVehiculo>
        <IdMarca>'.$IdMarca.'</IdMarca>
        <IdTipo>'.$IdTipo.'</IdTipo>
        <IdVersion>'.$IdVersion.'</IdVersion>
        <IdModelo>'.$IdModelo.'</IdModelo>
      </request>
    </gettransmission>
	 ';

//ws055647  --> Operacion
//GAP*agente1  --> Operacion

//ws055647 --> Prueba
//W5ossp4L+* --> Prueba

$siteID = "ws055647"; 
$sitePwd = "GAPHDI1*";  // SEGEY11*  // GAP*agente1
$header= '
    <AuthenticateHeader xmlns="http://hdi.com.mx/asmx/">
      <siteID>'.$siteID.'</siteID>
      <sitePwd>'.$sitePwd.'</sitePwd>
    </AuthenticateHeader>
		 ';
$urlConeccion = "https://serviceb2b.hdi.com.mx/Autos/PublicServicesAutos.asmx";
//$urlConeccion = "https://serviceb2b.hdi.com.mx/Autos/PublicServicesAutos.asmx"; //--> Produccion
//$urlConeccion = "https://unoautos.hdi.com.mx:8082/Terceros/PublicServicesAutos.asmx"; //--> Operacion
//$urlConeccion = "http://servicesimplementationb2b.hdi.com.mx/PublicServicesAutos.asmx"; //--> Prueba

$client = new nusoap_client($urlConeccion, false);
$client->soap_defencoding = 'UTF-8';
$client->decode_utf8 = false;

$err = $client->getError();
if ($err) { echo '<h2>Constructor error</h2><pre>' . $err . '</pre>'; }

$result = $client->call('gettransmission', $xml,'http://hdi.com.mx/asmx/', 'http://hdi.com.mx/asmx/gettransmission',$header, false, false, false);

	$return="<select name='idTransmision' id='idTransmision'>";
		$return.="<option value=''>-- Seleccione --</option>";
	foreach($result['ListaTransmisiones'] as $version){
		$return.="<option value='".$version['Clave']."'>".$version['Descripcion']."</option>";
	}
	$return.="</select>";

return

//	print($return);	
	print($xml);
}

function calcularVehiculo($IdMarca, $IdTipo, $IdVersion, $idModelo, $idTransmision){
$xml='
    <getinfovehicle xmlns="http://hdi.com.mx/asmx/">
      <request>
        <IdTipoVehiculo>4579</IdTipoVehiculo>
        <IdMarca>'.$IdMarca.'</IdMarca>
        <IdTipo>'.$IdTipo.'</IdTipo>
        <IdVersion>'.$IdVersion.'</IdVersion>
        <idModelo>'.$idModelo.'</idModelo>
        <idTransmision>'.$idTransmision.'</idTransmision>
      </request>
    </getinfovehicle>
	 ';
	 
$siteID = "ws055647"; 
$sitePwd = "GAPHDI1*";  // SEGEY11*  // GAP*agente1
$header= '
    <AuthenticateHeader xmlns="http://hdi.com.mx/asmx/">
      <siteID>'.$siteID.'</siteID>
      <sitePwd>'.$sitePwd.'</sitePwd>
    </AuthenticateHeader>
		 ';

$urlConeccion = "https://serviceb2b.hdi.com.mx/Autos/PublicServicesAutos.asmx";
//$urlConeccion = "https://serviceb2b.hdi.com.mx/Autos/PublicServicesAutos.asmx"; //--> Produccion
//$urlConeccion = "https://unoautos.hdi.com.mx:8082/Terceros/PublicServicesAutos.asmx"; //--> Operacion
//$urlConeccion = "http://servicesimplementationb2b.hdi.com.mx/PublicServicesAutos.asmx"; //--> Prueba

$client = new nusoap_client($urlConeccion, false);
$client->soap_defencoding = 'UTF-8';
$client->decode_utf8 = false;

$err = $client->getError();
if ($err) { echo '<h2>Constructor error</h2><pre>' . $err . '</pre>'; }

$result = $client->call('getinfovehicle', $xml,'http://hdi.com.mx/asmx/', 'http://hdi.com.mx/asmx/getinfovehicle',$header, false, false, false);

	$return=$result['DatosVehiculo']['idVehiculo'];

return

	$return;	
}

function calculoCiudad($claveEstado,$ciudad){	
	$sql_calculamos_ciudad = "
		Select * From 
			`ws_catalogo_ciudades_hdi` 
		Where 
			`ClaveEstado` = '$claveEstado'
						  ";
	$reuslt_calculamos_ciudad = DreQueryDB($sql_calculamos_ciudad);
	$return = '<select name="ciudad" id="ciudad" >';
	$return.="<option value=''>-- Seleccione --</option>";
while($row_calculamos_ciudad = mysql_fetch_assoc($reuslt_calculamos_ciudad)){
	if($row_calculamos_ciudad['Clave'] == $ciudad){ $selected = "selected"; } else { $selected = ""; }	
	$return.= '<option value="'.$row_calculamos_ciudad['Clave'].'" '.$selected.'>'.$row_calculamos_ciudad['Descripcion'].'</option>';
}
	$return.= '';
	$return.= '</select>';
	
	return
		print $return;
	//$MUN = $row_calculamos_mun['MUNID']; //"13";
}

	//	echo "bandera:".$wsAplicarComplemento;

// Iniciamos el Complemento para la Aseguradora
if(!isset($wsAplicarComplemento) && $wsAplicarComplemento != "01"){
	//	echo "estas en la primera Parte.";
?>
<table width="610" cellpadding="5" cellspacing="2" border="0" align="center">
	<tr>
    	<td>
			<?
				echo "El cat&aacute;logo de la aseguradora ".$wsAseguradoraParticular." SEGUROS no coincide con la descripci&oacute;n proporcionada, ay&uacute;denos a rectificar eligiendo nuevamente los datos:";
			?>
        </td>
    </tr>
<!-- <form name="formCompleWsHdi" id="formCompleWsHdi" method="post" action="<?php //echo $_SERVER['PHP_SELF']; ?>" target="_self"> -->
<form name="formIdVersion" id="formIdVersion" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" target="_self">
    <tr>
    	<td>
		<input type="hidden" name="wsModelo" id="wsModelo" value="<?php echo $wsModelo; ?>" />
		<input type="hidden" name="estado" id="estado" value="<?php echo $estado; ?>" />
		<input type="hidden" name="codigo_postal" id="codigo_postal" value="<?php echo $codigo_postal; ?>" />
		<input type="hidden" name="tipo_uso" id="tipo_uso" value="<?php echo $tipo_uso; ?>" />
		<input type="hidden" name="cobertura_auto" id="cobertura_auto" value="<?php echo $cobertura_auto; ?>" />
		<input type="hidden" name="valor_factura" id="valor_factura" value="<?php echo $valor_factura; ?>" />
		<input type="hidden" name="forma_pago" id="forma_pago" value="<?php echo $forma_pago; ?>" />
		<input type="hidden" name="idEmpresa" id="idEmpresa" value="<?php echo $idEmpresa; ?>" />
		<input type="hidden" name="idUsuario" id="idUsuario" value="<?php echo $idUsuario; ?>" />
		<input type="hidden" name="ramoInterno" id="ramoInterno" value="<?php echo $ramoInterno; ?>" />
		<input type="hidden" name="idInterno" id="idInterno" value="<?php echo $idInterno; ?>" />
		<input type="hidden" name="idActividad" id="idActividad" value="<?php echo $idActividad; ?>" />
		<!-- --><input type="hidden" name="tipoLineaPersonal" id="tipoLineaPersonal" value="<?php echo $tipoLineaPersonal; ?>" />
		<!-- --><input type="hidden" name="recId" id="recId" value="<?php echo $recId; ?>" />
		<input type="hidden" name="ver" id="ver" value="<?php echo $ver; ?>" />
		<input type="hidden" name="tipoForm" id="tipoForm" value="<?php echo $tipoForm; ?>" />
		<input type="hidden" name="wsMarca" id="wsMarca" value="<?php echo $wsMarca; ?>" />
		<input type="hidden" name="wsYear" id="wsYear" value="<?php echo $wsYear; ?>" />
		<!-- <input type="text" name="wsModelo_Aba" id="wsModelo_Aba" /> -->
		<input type="hidden" name="wsAseguradoraParticular" id="wsAseguradoraParticular" value="HDI" />
<!--		<input type="hidden" name="wsAplicarComplemento" id="wsAplicarComplemento" value="00" /> -->
		<input type="hidden" name="muestra" id="muestra" value="Formularios" />
        
		<input type="hidden" name="idTipo" id="idTipo" value="<?php echo $_REQUEST['idTipo']; ?>" />
        
    	</td>
    </tr>
    <tr>
    	<td>
        	<strong>Modelo:</strong>
            <font style="font-size:14px;">
        	<?php echo "&nbsp;&nbsp;&nbsp;".$wsModelo."&nbsp;&nbsp;&nbsp;"; ?>
            </font>
        </td>
    </tr>
    <tr>
    	<td>
        	<strong>Seleccione Ciudad:</strong>
			<?php calculoCiudad($claveEstado,$ciudad); ?>
        </td>
    </tr>
<?php
	if(calculoVersion($claveMarca,$wsYear,$idTipo,$idVersion)){ 
?>
    <tr>
    	<td>
        	<strong>Seleccione Version Vehiculo:</strong>
			<?php print(calculoVersion($claveMarca,$wsYear, $idTipo, $idVersion)); ?>
        </td>
    </tr>
<?php
	} else {
?>
    <tr>
    	<td>
        	<strong>Seleccione Tipo Vehiculo:</strong>
            <?php calculoTipoVehiculo($claveMarca, $wsYear, $idTipo); ?>
        </td>
	</tr>
<?php
	}
?>
</form>
<?php
if(isset($idVersion) && isset($ciudad)){
?>
<form name="formCompleWsHdi" id="formCompleWsHdi" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" target="_self">
        <input type="hidden" name="idVersion" id="idVersion" value="<?php echo $idVersion; ?>" />
        <input type="hidden" name="ciudad" id="ciudad" value="<?php echo $ciudad; ?>" />
		<input type="hidden" name="wsModelo" id="wsModelo" value="<?php echo $wsModelo; ?>" />
		<input type="hidden" name="estado" id="estado" value="<?php echo $estado; ?>" />
		<input type="hidden" name="codigo_postal" id="codigo_postal" value="<?php echo $codigo_postal; ?>" />
		<input type="hidden" name="tipo_uso" id="tipo_uso" value="<?php echo $tipo_uso; ?>" />
		<input type="hidden" name="cobertura_auto" id="cobertura_auto" value="<?php echo $cobertura_auto; ?>" />
		<input type="hidden" name="valor_factura" id="valor_factura" value="<?php echo $valor_factura; ?>" />
		<input type="hidden" name="forma_pago" id="forma_pago" value="<?php echo $forma_pago; ?>" />
		<input type="hidden" name="idEmpresa" id="idEmpresa" value="<?php echo $idEmpresa; ?>" />
		<input type="hidden" name="idUsuario" id="idUsuario" value="<?php echo $idUsuario; ?>" />
		<input type="hidden" name="ramoInterno" id="ramoInterno" value="<?php echo $ramoInterno; ?>" />
		<input type="hidden" name="idInterno" id="idInterno" value="<?php echo $idInterno; ?>" />
		<input type="hidden" name="idActividad" id="idActividad" value="<?php echo $idActividad; ?>" />
		<!-- --><input type="hidden" name="tipoLineaPersonal" id="tipoLineaPersonal" value="<?php echo $tipoLineaPersonal; ?>" />
		<!-- --><input type="hidden" name="recId" id="recId" value="<?php echo $recId; ?>" />
		<input type="hidden" name="ver" id="ver" value="<?php echo $ver; ?>" />
		<input type="hidden" name="tipoForm" id="tipoForm" value="<?php echo $tipoForm; ?>" />
		<input type="hidden" name="wsMarca" id="wsMarca" value="<?php echo $wsMarca; ?>" />
		<input type="hidden" name="wsYear" id="wsYear" value="<?php echo $wsYear; ?>" />
		<!-- <input type="text" name="wsModelo_Aba" id="wsModelo_Aba" /> -->
		<input type="hidden" name="wsAseguradoraParticular" id="wsAseguradoraParticular" value="HDI" />
		<input type="hidden" name="wsAplicarComplemento" id="wsAplicarComplemento" value="01" />
<!-- --><input type="hidden" name="muestra" id="muestra" value="Formularios" />

		<input type="hidden" name="idTipo" id="idTipo" value="<?php echo $_REQUEST['idTipo']; ?>" />
        
    <tr>
    	<td>
        	<strong>Seleccione Transmision Vehiculo:</strong>
			<?php calculoTransmision($claveMarca,$idTipo,$idVersion,$wsYear); ?>
        </td>
    </tr>
    <tr>
    	<td align="right">
			<input type="submit" value="Continuar" />
        </td>
    </tr>
</form>
<?php 
}
?>
</table>
<?php
}// Fin Complemento para la Aseguradora

// Iniciamos Aplicacion de Complemento Aseguradora
if($wsAplicarComplemento == "01"){
	//	echo "estas en la segunda Parte.";
//- Inicio Calculamos la Cotizacion Por El Ws

$idFormaPago = $formaPagoArray[$forma_pago];
$ciudad = $ciudad;
$estado = $rowCalculamosEstado['Clave'];

$idVehiculo = calcularVehiculo($claveMarca,$idTipo,$idVersion,$wsYear,$idTransmision); //"12178";
$idModelo = $wsYear;
$idMarca = $claveMarca;
//$idTipo = $tipoArray[0];
//$idVersion = "GL 1.4 L STD";
//$idTransmision = "4534";

$xml='
    <getpackages xmlns="http://hdi.com.mx/asmx/">
      <request>
        <usuario>ws055647</usuario>
        <idFormaPago>'.$idFormaPago.'</idFormaPago>
        <ciudad>'.$ciudad.'</ciudad>
        <estado>'.$estado.'</estado>
        <listaPaquetesACalcular>
          <StringArray>
            <string>19</string>
          </StringArray>
		</listaPaquetesACalcular>
        <obtenerTodosPaquetes>false</obtenerTodosPaquetes>
        <paquetesConCambios>
          <PaqueteCoberturas>
            <Clave>19</Clave>			
            <Descripcion></Descripcion>
            <CoberturasObligatorias>
                        <Cobertura>
                           <Regla>655</Regla>
                           <Clave>253</Clave>
                           <Descripcion>Responsabilidad civil (LUC)</Descripcion>
                           <SumaAsegurada>1500000</SumaAsegurada>
                           <Calculada>true</Calculada>
                        </Cobertura>
            </CoberturasObligatorias>
            <CoberturasObligatoriasOpcionales>
                        <Cobertura>
                           <Regla>292</Regla>
                           <Clave>239</Clave>
                           <Descripcion>Gastos médicos ocupantes (LUC)</Descripcion>
                           <SumaAsegurada>60000</SumaAsegurada>
                           <Calculada>true</Calculada>
                        </Cobertura>
                        <Cobertura>
                           <Regla>322</Regla>
                           <Clave>269</Clave>
                           <Descripcion>Asistencia médica</Descripcion>
                           <SumaAsegurada>0</SumaAsegurada>
                           <Calculada>false</Calculada>
                        </Cobertura>
                        <Cobertura>
                           <Regla>398</Regla>
                           <Clave>267</Clave>
                           <Descripcion>Responsabilidad civil familiar</Descripcion>
                           <SumaAsegurada>0</SumaAsegurada>
                           <Calculada>false</Calculada>
                        </Cobertura>
            </CoberturasObligatoriasOpcionales>
            <CoberturasOpcionales>
                        <Cobertura>
                           <Regla>361</Regla>
                           <Clave>235</Clave>
                           <Descripcion>Accidentes automovilíticos al conductor</Descripcion>
                           <SumaAsegurada>100000</SumaAsegurada>
                           <Calculada>true</Calculada>
                        </Cobertura>
			</CoberturasOpcionales>
            <Totales></Totales>
            <Recibos></Recibos>
            <Ajuste></Ajuste>
          </PaqueteCoberturas>
		</paquetesConCambios>
		
        <datosVehiculo>		
          <idVehiculo>'.$idVehiculo.'</idVehiculo>
          <idModelo>'.$idModelo.'</idModelo>
          <idMarca>'.$idMarca.'</idMarca>
          <idTipo>'.$idTipo.'</idTipo>
          <idVersion>'.$idVersion.'</idVersion>
          <idTransmision>'.$idTransmision.'</idTransmision>
        </datosVehiculo>
		
      </request>
    </getpackages>
	 ';
	 
$siteID = "ws055647"; 
$sitePwd = "GAPHDI1*";  // SEGEY11*  // GAP*agente1

$urlConeccion = "https://serviceb2b.hdi.com.mx/Autos/PublicServicesAutos.asmx";
//$urlConeccion = "https://serviceb2b.hdi.com.mx/Autos/PublicServicesAutos.asmx"; //--> Produccion
//$urlConeccion = "https://unoautos.hdi.com.mx:8082/Terceros/PublicServicesAutos.asmx"; //--> Operacion
//$urlConeccion = "http://servicesimplementationb2b.hdi.com.mx/PublicServicesAutos.asmx"; //--> Pruebas

$client = new nusoap_client($urlConeccion, false);

$err = $client->getError();
if ($err) { echo '<h2>Constructor error</h2><pre>' . $err . '</pre>'; }

$header= '
    <AuthenticateHeader xmlns="http://hdi.com.mx/asmx/">
      <siteID>'.$siteID.'</siteID>
      <sitePwd>'.$sitePwd.'</sitePwd>
    </AuthenticateHeader>
		 ';
$client->soap_defencoding = 'UTF-8';
$client->decode_utf8 = false;
$result = $client->call('getpackages', $xml,'http://hdi.com.mx/asmx/', 'http://hdi.com.mx/asmx/getpackages',$header, false, false, false);
//- Fin Calculamos la Cotizacion Por El Ws	

// Proceso para almacenamiento del XML obtenido
$respuestaXML = htmlspecialchars_decode($client->responseData, ENT_NOQUOTES);

$cosasQuitaXml = array('<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"><soap:Body>','</soap:Body></soap:Envelope>');
$cosasPonerXml = array('','');

$respuestaXmlDepurada = str_replace($cosasQuitaXml, $cosasPonerXml, $respuestaXML);
$fileXML = "xmlTodos/hdi/".$recId."_".date('dmY_Gis').'.xml';
file_put_contents($fileXML, $respuestaXmlDepurada);
/*
// Check for a fault
if ($client->fault) {
	echo '<h2>Fault</h2><pre>';
	print_r($result);
	echo '</pre>';
} else {
	// Check for errors
	$err = $client->getError();
	if ($err) {
		// Display the error
		echo '<h2>Error</h2><pre>' . $err . '</pre>';
	} else {
		// Display the result
		echo '<h2>Result</h2><pre>';
		print_r($result);
		echo '</pre>';
	}
}
*/
//echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
//echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';

 /* Proceso Para Cuadro Comparativo */
 if(file_exists($fileXML)){ // el archivo es necesario que se depuere hasta dejarlo lo mas limpio en Formato XML
	//echo "<br>Si Existe el Archivo<br>";
	
	 $datosCotizacion  =  simplexml_load_file($fileXML); 
	if($datosCotizacion){
		//echo "Si Cargamos el XML";

		foreach($datosCotizacion->getpackagesResult as $cotizacion){
//--> Guardamos Info en la Tabla Comparativa

$idActividad = $idActividad;
$idCliente = $idEmpresa;
$idUsuario = $idUsuario;
$descripcion = "[".$idVehiculo."]"."*".$wsMarca."*".$idTipo." ".$idVersion;
$modelo = $wsYear;
$uso = $tipo_uso;
$aseguradora = "HDI";

$prima_danosMateriales = "VCMS";//$cotizacion->InformacionPaquetes->ListaPaquetes->PaqueteCoberturas->CoberturasObligatorias->Cobertura[0]->Deducible; // "VCMS";
$prima_roboTotal = "VCMS";//$cotizacion->InformacionPaquetes->ListaPaquetes->PaqueteCoberturas->CoberturasObligatorias->Cobertura[1]->Deducible;//"VCMS";
$prima_rc = "$".number_format($cotizacion->InformacionPaquetes->ListaPaquetes->PaqueteCoberturas->CoberturasObligatorias->Cobertura[2]->SumaAsegurada,2,'.',',');//"3000000";
//--> $prima_rc.= "$".number_format($prima_rc,2,'.',',');

$prima_gastosMedicos = "$".number_format($cotizacion->InformacionPaquetes->ListaPaquetes->PaqueteCoberturas->CoberturasObligatoriasOpcionales->Cobertura[0]->SumaAsegurada,2,'.',',')." x OCUPANTE"; //"200000";
//--> $prima_gastosMedicos.= "$".number_format($prima_gastosMedicos,2,'.',',')."x OCUPANTE";

$prima_asesoriaJuridica = ($cotizacion->InformacionPaquetes->ListaPaquetes->PaqueteCoberturas->CoberturasObligatorias->Cobertura[3]->SumaAsegurada == 0)? "AMPARADA" : $cotizacion->InformacionPaquetes->ListaPaquetes->PaqueteCoberturas->CoberturasObligatorias->Cobertura[3]->SumaAsegurada; // si es cero es amparada "AMPARADA";
$prima_asistenciaVial = "AMPARADA"; //"AMPARADA";
$prima_extensionRc = ($cotizacion->InformacionPaquetes->ListaPaquetes->PaqueteCoberturas->CoberturasObligatoriasOpcionales->Cobertura[1]->SumaAsegurada == 0)? "AMPARADA" : $cotizacion->InformacionPaquetes->ListaPaquetes->PaqueteCoberturas->CoberturasObligatoriasOpcionales->Cobertura[1]->SumaAsegurada; 

$prima_muertaAccConducto = "$".number_format($cotizacion->InformacionPaquetes->ListaPaquetes->PaqueteCoberturas->CoberturasOpcionales->Cobertura[6]->SumaAsegurada,2,'.',','); //"100000";
//--> $prima_muertaAccConducto.= "$".number_format($prima_muertaAccConducto,2,'.',',');

$prima_rcMuerteTerceros = $cotizacion->InformacionPaquetes->ListaPaquetes->PaqueteCoberturas->CoberturasObligatoriasOpcionales->Cobertura[2]->SumaAsegurada; //"AMPARADO EN  RC";

$formaPago = $forma_pago;
$total = $primaTotal = $cotizacion->InformacionPaquetes->ListaPaquetes->PaqueteCoberturas->Totales->PrimaTotal;
$primerRecibo = $cotizacion->InformacionPaquetes->ListaPaquetes->PaqueteCoberturas->Recibos->PrimeraExhibicion;
$subSecuenteRecibo = $cotizacion->InformacionPaquetes->ListaPaquetes->PaqueteCoberturas->Recibos->Importe;

$sqlComparativaInsert = "
	Insert Into 
		`ws_comparativo`
			(
				`idActividad`
				,`idCliente`
				,`idUsuario`
				,`marca`
				,`descripcion`
				,`modelo`
				,`estadoCirculacion`
				,`codigoPostal`
				,`uso`
				,`cobertura`
				,`aseguradora`
				,`prima_danosMateriales`
				,`prima_roboTotal`
				,`prima_rc`
				,`prima_gastosMedicos`
				,`prima_asesoriaJuridica`
				,`prima_asistenciaVial`
				,`prima_extensionRc`
				,`prima_muertaAccConducto`
				,`prima_rcMuerteTerceros`
				,`formaPago`
				,`total`
				,`primerRecibo`
				,`subSecuenteRecibo`
			)
			Values
			(
				'$idActividad'
				,'$idCliente'
				,'$idUsuario'
				,'$wsMarca'
				,'$descripcion'
				,'$modelo'
				,'$estado'
				,'$codigo_postal'
				,'$uso'
				,'$cobertura_auto'
				,'$aseguradora'
				,'$prima_danosMateriales'
				,'$prima_roboTotal'
				,'$prima_rc'
				,'$prima_gastosMedicos'
				,'$prima_asesoriaJuridica'
				,'$prima_asistenciaVial'
				,'$prima_extensionRc'
				,'$prima_muertaAccConducto'
				,'$prima_rcMuerteTerceros'
				,'$formaPago'
				,'$total'
				,'$primerRecibo'
				,'$subSecuenteRecibo'
			)
						";

DreQueryDB($sqlComparativaInsert);

		}// foreach $marcas
	}// if $vehiculos
}// if file_exists

// Aqui reenviamos a la sig. aseguradora.
$wsModelo = $_REQUEST['wsModelo'];
$estado = $_REQUEST['estado'];
$codigo_postal = $_REQUEST['codigo_postal'];
$tipo_uso = $_REQUEST['tipo_uso'];
$cobertura_auto = $_REQUEST['cobertura_auto'];
$valor_factura = $_REQUEST['valor_factura'];
$forma_pago = $_REQUEST['forma_pago'];
$idEmpresa = $_REQUEST['idEmpresa'];
$idUsuario = $_REQUEST['idUsuario'];
$ramoInterno = $_REQUEST['ramoInterno'];
$idInterno = $_REQUEST['idInterno'];
$idActividad = $_REQUEST['idActividad'];
$tipoLineaPersonal = $_REQUEST[''];
$recId = $_REQUEST['recId'];
$ver = $_REQUEST['ver'];
$tipoForm = $_REQUEST['tipoForm'];
$wsMarca = $_REQUEST['wsMarca'];
$wsYear = $_REQUEST['wsYear'];
$wsAseguradoraParticular = "ANA";  //ANA  FIN

$urlReturnActividad = $_SERVER['PHP_SELF'];
$urlReturnActividad .= "?wsModelo=".$wsModelo;
$urlReturnActividad .= "&estado=".$estado;
$urlReturnActividad .= "&codigo_postal=".$codigo_postal;
$urlReturnActividad .= "&tipo_uso=".$tipo_uso;
$urlReturnActividad .= "&cobertura_auto=".$cobertura_auto;
$urlReturnActividad .= "&valor_factura=".$valor_factura;
$urlReturnActividad .= "&forma_pago=".$forma_pago;
$urlReturnActividad .= "&idEmpresa=".$idEmpresa;
$urlReturnActividad .= "&idUsuario=".$idUsuario;
$urlReturnActividad .= "&ramoInterno=".$ramoInterno;
$urlReturnActividad .= "&idInterno=".$idInterno;
$urlReturnActividad .= "&idActividad=".$idActividad;
$urlReturnActividad .= "&tipoLineaPersonal=".$tipoLineaPersonal;
$urlReturnActividad .= "&recId=".$recId;
$urlReturnActividad .= "&ver=".$ver;
$urlReturnActividad .= "&tipoForm=".$tipoForm;
$urlReturnActividad .= "&wsMarca=".$wsMarca;
$urlReturnActividad .= "&wsYear=".$wsYear;
$urlReturnActividad .= "&wsAseguradoraParticular=".$wsAseguradoraParticular;
$urlReturnActividad .= "&muestra=Formularios";

//header("Location: $urlReturnActividad");
?>
<script>
	window.open('<?php echo $urlReturnActividad; ?>', '_self');
</script>
<?php
}// Fin Aplicacion de Complemento Aseguradora
?>