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
	$conex = DreConectarDB();

$sqlUsuariosCapsys = "
					Select * From
						`users`
					 ";
$query = DreQueryDB($sqlUsuariosCapsys);

while($row = mysql_fetch_assoc($query)){
	$EmailUsersSistema[] = $row['email']; //strtolower(); 
}

$sql = "
	Select * From
		`catalog_vendedores`
	Where
		`Status` = '0'
		And
		`EMail1` != ''
	   ";
$query = DreQueryDB($sql);

$contUser = 0;
while($row = mysql_fetch_assoc($query)){
	extract($row);
	if(in_array(strtoupper($EMail1), $EmailUsersSistema)){
		echo "No Crear Usuario ".$EMail1;
	} else {
		echo "<pre>";
		echo $contUser++." Crear Usuario ".$EMail1;
		echo "</pre>";
		
		if($TipoVend == 0){
			$profile = "1";
		} else {
			$profile = "2";
		}
		
		$query_InserUsuario = "
			Insert Into
				`capsysV3`.`users` 
				(
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
					'".$IDVend."',
					'".$IDVendNS."',
					'".$profile."', 
					'".utf8_decode(strtoupper("VEND".$IDVend))."',
					'$2a$08$3P5bPZN4oaC3urJIYnBjeO4Do9eozE6bu89LHghW1kKf.lYLbgfFC', 
					'".utf8_decode(strtoupper($EMail1))."',
					'".utf8_decode(strtoupper($NombreCompleto))."',
					'1',
					'".date('Y-m-d H:i:s')."'
				);
							  ";
		DreQueryDB($query_InserUsuario);
		
		$query_InserMiinfo = "
			Insert Into 
				`capsysV3`.`user_miInfo` 
				(
					`emailUser`,
					`IDVend`,
					`IDVendNS`,
					`IDCont`
					
				) 
				VALUES 
				(
					'".utf8_decode(strtoupper($EMail1))."',
					'".$IDVend."',
					'".$IDVendNS."',
					'".$IDCont."'
				);
							 ";
		DreQueryDB($query_InserMiinfo);
		
		$textoUrl = "
				<InfoData>
					<CatContactos>
						<IDCont>".$IDCont."</IDCont>
						<URL>capsysweb</URL>
					</CatContactos>
				</InfoData>
					";
		$TextEncriptUrl= encripta("%SOnlineBOGO2001-2015WS#","GAP#aCap",$textoUrl); 

		$xmlSendUrl = '<?xml version="1.0" encoding="utf-8"?>
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
								<KeyProcess>DATA</KeyProcess>
								<KeyCode>HDATACONTACT</KeyCode>
								<TProc>Save_Data</TProc>
								<DataXML>'.$TextEncriptUrl.'</DataXML>
							</oDataWS>
						</ProcesarWS>
						</soap:Body>
						</soap:Envelope>';
	//echo "[WS Sicas]".ConsumoWS($xmlSendUrl)."[WS Sicas]";
	//echo sleep(5);
	
	}
}
	DreDesconectarDB($conex);
?>