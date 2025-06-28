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
        <KeyCode>HWS_VEND</KeyCode>
        <Page>1</Page>
        <ItemForPage>500</ItemForPage>
        <InfoSort>CatVendedores.NombreCompleto</InfoSort>
        <ConditionsAdd>'
			.
			'Nombre Completo;0;0;*'.$NombreCompleto.'*;;CatVendedores.NombreCompleto'
        	.
		'</ConditionsAdd>
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
		$query_TruncateTable = "
			TRUNCATE `catalog_vendedores`;
							   ";
		DreQueryDB($query_TruncateTable);
	
	foreach ($carga_xml->TableInfo as $vendedor){
						
		echo "<br /><br />";
		echo "IdVendedor: [".$vendedor->IDVend."] <br />";
		echo "NombreCompleto: ->".$vendedor->NombreCompleto."<br />";
		echo "<br />";

		$query_InserVendedor = "
			Insert Into
				`catalog_vendedores`
			(
				`IDVend`
				,`Status`
				,`NombreCompleto`
				,`IDDespacho`
				,`IDGerencia`
				,`DespNombre`
				,`IDVendNS`
				,`TipoVend`
				,`TipoVend_TXT`
				,`GenComision`
				,`RCascade`
				,`IDCatCom`
				,`IDCont`
				,`TipoEnt`
				,`TipoEnt_TXT`
				,`ApellidoP`
				,`ApellidoM`
				,`Nombre`
				,`Edad`
				,`Sexo`
				,`Sexo_TXT`
				,`Idioma_TXT`
				,`Clasifica_TXT`
				,`EMail1`
			)
			Values
			(
				'".$vendedor->IDVend."'
				,'".$vendedor->Status."'
				,'".utf8_decode($vendedor->NombreCompleto)."'
				,'".$vendedor->IDDespacho."'
				,'".$vendedor->IDGerencia."'
				,'".utf8_decode($vendedor->DespNombre)."'
				,'".$vendedor->IDVendNS."'
				,'".$vendedor->TipoVend."'
				,'".utf8_decode($vendedor->TipoVend_TXT)."'
				,'".$vendedor->GenComision."'
				,'".$vendedor->RCascade."'
				,'".$vendedor->IDCatCom."'
				,'".$vendedor->IDCont."'
				,'".$vendedor->TipoEnt."'
				,'".utf8_decode($vendedor->TipoEnt_TXT)."'
				,'".utf8_decode($vendedor->ApellidoP)."'
				,'".utf8_decode($vendedor->ApellidoM)."'
				,'".utf8_decode($vendedor->Nombre)."'
				,'".$vendedor->Edad."'
				,'".$vendedor->Sexo."'
				,'".utf8_decode($vendedor->Sexo_TXT)."'
				,'".utf8_decode($vendedor->Idioma_TXT)."'
				,'".utf8_decode($vendedor->Clasifica_TXT)."'
				,'".$vendedor->EMail1."'
			)
							   ";
		DreQueryDB($query_InserVendedor);
	}
	
	/* Terminamos BD*/
		DreDesconectarDB($conex);
	
} else {
	echo "<br />Carga Fallida<br />";

}

echo "<pre>";
echo "</pre>";
?>