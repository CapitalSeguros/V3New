<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
	require('../config/funcionesDre.php');

	$UserName = "GAP#aCap%2015";
	$Password = "CAP15gap20Ag";
	$CodeAuth = "vsDMquPhx68SZrY8wGcxEh2bk1XiPlR0EZkBVLmax3A4Mab7sDeeyodY3BjDuyB";
	$UserSicas_Username = "desarrollo@agentecapital.com";
	$UserSicas_Password	= "hola00";
	$NombreCompleto = $_GET['busquedaNombreCompleto'];

	$keyEncriptado = "%SOnlineBOGO2001-2015WS#";
	$ivPassEncriptado = "GAP#aCap";

//
$xmlReporteVendedores = '<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <ProcesarWS xmlns="http://tempuri.org/">
      <oDataWS>
        <Credentials>
          <UserName>'.$UserName.'</UserName>
          <Password>'.$Password.'</Password>
          <CodeAuth>'.$CodeAuth.'</CodeAuth>
        </Credentials>
        <CredentialsUserSICAS>
          <UserName>'.$UserSicas_Username.'</UserName>
          <Password>'.$UserSicas_Password.'</Password>
        </CredentialsUserSICAS>
        <TypeFormat>XML</TypeFormat>
        <KeyProcess>REPORT</KeyProcess>
        <KeyCode>HWS_USERS</KeyCode>
        <Page>1</Page>
        <ItemForPage>500</ItemForPage>
        <InfoSort>CatUsuarios.IDUser</InfoSort>
      </oDataWS>
    </ProcesarWS>
  </soap:Body>
</soap:Envelope>';

// Limpieza XML Uno
$cosasQuitaXml = array(
						'<?xml version="1.0" encoding="utf-8"?>',
						'<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">',
						'<ProcesarWSResponse xmlns="http://tempuri.org/">',
						'<ProcesarWSResult>',
						'</ProcesarWSResult>',
						'</ProcesarWSResponse>',
						'</soap:Envelope>'
					  );
$cosasPonerXml = array(
						'',
						'',
						'',
						'',
						'',
						'',
						'',
					  );

$respuestaXmlDepurada = str_replace($cosasQuitaXml, $cosasPonerXml, ConsumoWsSICAS($xmlReporteVendedores));

$xmlTexto = htmlspecialchars_decode($respuestaXmlDepurada);

$xml=<<<XML
	$xmlTexto
XML;

if(simplexml_load_string($xml)){
	$carga_xml = simplexml_load_string($xml);
	
	/* Iniciamos BD*/
		$conex = DreConectarDB();
	
	foreach ($carga_xml->TableInfo as $vendedor){
		if($vendedor->Status == 0){ // Validamos que esten activos	
		$query_InserVendedor = "
			Insert Into 
				`users` 
				(
					`IDUser`, 
					`profile`, 
					`username`, 
					`password`, 
					`email`, 
					`name_complete`, 
					`activated`,
					`created`
				) 
				VALUES 
				(
					'".$vendedor->IDUser."',
					'3', 
					'".utf8_decode(strtoupper($vendedor->Alias))."',
					'$2a$08$3P5bPZN4oaC3urJIYnBjeO4Do9eozE6bu89LHghW1kKf.lYLbgfFC', 
					'".utf8_decode(strtoupper($vendedor->EMail))."',
					'".utf8_decode(strtoupper($vendedor->Nombre))."',
					'1',
					'".date('Y-m-d H:i:s')."'
				);
							   ";
		DreQueryDB($query_InserVendedor);
		
		$query_InserMiinfo = "
			Insert Into 
				`user_miInfo` 
				(
					`emailUser`
				) 
				VALUES 
				(
					'".utf8_decode(strtoupper($vendedor->EMail))."'
				);
							 ";
		DreQueryDB($query_InserMiinfo);
			echo "<pre>";
			echo $vendedor->EMail;
			echo "</pre>";
		}
	}
	/* Terminamos BD*/
		DreDesconectarDB($conex);
	
} else {
	echo "<br />Carga Fallida<br />";

}

echo "<pre>";
echo "</pre>";
?>