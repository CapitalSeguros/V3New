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
        <KeyCode>HWS_VENDEDORES</KeyCode>
        <Page>1</Page>
        <ItemForPage>500</ItemForPage>
        <InfoSort>CatVendedores.IDVend</InfoSort>

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
		if(
			$vendedor->EMail1 != ""
			||
			$vendedor->EMail1 != "aleksandromtz@hotmail.com"
			||
			$vendedor->EMail1 != "asistentegeneral@agentecapital.com"
			||
			$vendedor->EMail1 != "cpeet@agentecapital.com"
			||
			$vendedor->EMail1 != "gerenteadministrativo@agentecapital.com"
			||
			$vendedor->EMail1 != "mesadecontrol@agentecapital.com"
			||
			$vendedor->EMail1 != "segufian@gmail.com"
			||
			$vendedor->EMail1 != "tyudicoromo@yahoo.com.mx"
		){
		$query_InserVendedor = "
			Insert Into 
				`capsysv3`.`users` 
				(
					`idTipoUser`,
					`IDVend`,
					`IDVendNS`, 
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
					
					'6',
					'".$vendedor->IDVend."',
					'".$vendedor->IDVendNS."',
					'1', 
					'".utf8_decode(strtoupper($vendedor->Abreviacion))."',
					'$2a$08$3P5bPZN4oaC3urJIYnBjeO4Do9eozE6bu89LHghW1kKf.lYLbgfFC', 
					'".utf8_decode(strtoupper($vendedor->EMail1))."',
					'".utf8_decode(strtoupper($vendedor->NombreCompleto))."',
					'1',
					'".date('Y-m-d H:i:s')."'
				);
							   ";

		echo "<pre>";
			print_r($vendedor);
			echo $query_InserVendedor;
		echo "</pre>";
		DreQueryDB($query_InserVendedor);
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