<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Capsysdre_actualizaCliente extends CI_Model {


	private $Credentials_UserName	= "GAP#aCap%2015";
	private $Credentials_Password	= "CAP15gap20Ag";
	private $Credentials_CodeAuth	= "vsDMquPhx68SZrY8wGcxEh2bk1XiPlR0EZkBVLmax3A4Mab7sDeeyodY3BjDuyB";	
	
	private $CredentialsUserSICAS_UserName	= "desarrollo@agentecapital.com";
	private $CredentialsUserSICAS_Password	= "hola00";
	 
	function __construct(){
		parent::__construct();

	}

		function _encriptaSICAS($key,$ivPass,$TextPlain){
			if(strlen($key)!=24){
			echo "La longitud de la key ha de ser de 24 dígitos.<br>"; return -1; 
		} if((strlen($ivPass) % 8 )!=0){ 
			echo "La longitud del vector iv Passsword ha de ser múltiple de 8 dígitos.<br>"; return -2; 
		}
		return 
			@base64_encode(mcrypt_encrypt(MCRYPT_3DES, $key, $TextPlain, MCRYPT_MODE_CBC, $ivPass));
		}/*! _encriptaSICAS */
		
		function _consumoWsSICAS($XMLData){            
			$headers = array(
    	    				"POST /SOnlineWSQua/WS_SICASOnline.asmx HTTPS/1.1",
        	                "Content-Type: text/xml; charset=utf-8",
            	            "Accept: text/xml",                        
                	        "Host: www.sicasonline.info",
                    	    "Pragma: no-cache",
                        	"SOAPAction: http://tempuri.org/ProcesarWS", 
	                        "Content-length: ".strlen($XMLData),
    	                );
        	    // PHP cURL  for https connection with auth
            	$urlProceso = "https://www.sicasonline.info:448/SOnlineWS/WS_SICASOnline.asmx?WSDL";
	            $ch = curl_init();
    	        curl_setopt($ch, CURLOPT_URL, $urlProceso);
        	    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	            //curl_setopt($ch, CURLOPT_USERPWD, $soapUser.":".$soapPassword); // username and password - declared at the top of the doc
    	        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);            
				curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
    	        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        	    curl_setopt($ch, CURLOPT_POST, true);
	            curl_setopt($ch, CURLOPT_POSTFIELDS, $XMLData); // the SOAP request

    	        // converting
	            $response = curl_exec($ch); 
    	        curl_close($ch);        

        	    // converting
	            $response1 = str_replace("<soap:Body>","",$response);            
    	        $response1 = str_replace("</soap:Body>","",$response1);
        	    return  (string)$response1;
		}/*! _consumoWsSICAS */
	
	function ListaClientes($busquedaCliente){
		$xmlReporteCliente = '<?xml version="1.0" encoding="utf-8"?>
			<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
				<soap:Body>
					<ProcesarWS xmlns="http://tempuri.org/">
						<oDataWS>
							<Credentials>
								<UserName>'.$this->Credentials_UserName.'</UserName>
								<Password>'.$this->Credentials_Password.'</Password>
          						<CodeAuth>'.$this->Credentials_CodeAuth.'</CodeAuth>
							</Credentials>
							<CredentialsUserSICAS>
								<UserName>'.$this->CredentialsUserSICAS_UserName.'</UserName>
								<Password>'.$this->CredentialsUserSICAS_Password.'</Password>
							</CredentialsUserSICAS>
							<TypeFormat>XML</TypeFormat>
							<KeyProcess>REPORT</KeyProcess>
							<KeyCode>HDS00002</KeyCode>
							<Page>1</Page>
							<ItemForPage>25</ItemForPage>
							<InfoSort>CatClientes.IDCli</InfoSort>
							<ConditionsAdd>
								Nombre Completo;0;0;*'.$busquedaCliente.'*;'.$busquedaCliente.';CatClientes.NombreCompleto
							</ConditionsAdd>
						</oDataWS>
					</ProcesarWS>
				</soap:Body>
			</soap:Envelope>';

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

		$respuestaDepuradaXmlReporteCliente = str_replace($cosasQuitaXml, $cosasPonerXml, _consumoWsSICAS($xmlReporteCliente));

		$xmlTextoCliente = htmlspecialchars_decode($respuestaDepuradaXmlReporteCliente);

$xmlCliente=<<<XML
	$xmlTextoCliente
XML;


if(simplexml_load_string($xmlCliente)){
	$carga_xmlCliente = simplexml_load_string($xmlCliente);
	$return = array();
	foreach ($carga_xmlCliente->TableInfo as $registroCliente){
		$return[] = $registroCliente;
	}

}
		return
			$return;
	} /*! ListaClientes */


	function DetalleCliente($IDCli){
		$texto = "
				<InfoData>
					<CatClientes_2>
						<IDCli>".$IDCli."</IDCli>
					</CatClientes_2>
				</InfoData>
		 		 ";
		
		$TextEncript= _encriptaSICAS("%SOnlineBOGO2001-2015WS#","GAP#aCap",$texto);		

		$xmlCliente = '<?xml version="1.0" encoding="utf-8"?>
<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
  <soap:Body>
    <ProcesarWS xmlns="http://tempuri.org/">     
     <oDataWS>
        <Credentials>
			<UserName>'.$this->Credentials_UserName.'</UserName>
			<Password>'.$this->Credentials_Password.'</Password>
	        <CodeAuth>'.$this->Credentials_CodeAuth.'</CodeAuth>
        </Credentials>
        <CredentialsUserSICAS>
			<UserName>'.$this->CredentialsUserSICAS_UserName.'</UserName>
			<Password>'.$this->CredentialsUserSICAS_Password.'</Password>
        </CredentialsUserSICAS>
        <TypeFormat>XML</TypeFormat>
        <KeyProcess>DATA</KeyProcess>
        <KeyCode>H02000</KeyCode>
        <TProc>Read_Data</TProc>
        <DataXML>'.$TextEncript.'</DataXML>
      </oDataWS>
    </ProcesarWS>
  </soap:Body>
</soap:Envelope>';

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

		$respuestaDepuradaXmlCliente = str_replace($cosasQuitaXml, $cosasPonerXml, _consumoWsSICAS($xmlCliente));

		$xmlTextoCliente = htmlspecialchars_decode($respuestaDepuradaXmlCliente);

$xmlCliente=<<<XML
	$xmlTextoCliente
XML;


if(simplexml_load_string($xmlCliente)){
	$carga_xmlCliente = simplexml_load_string($xmlCliente);
	$return = array();
	foreach ($carga_xmlCliente->CatClientes as $DatoCliente){
		$return[] = $DatoCliente;
	}

}

		return
			$return;
	} /*! DetalleCliente */
	
	function ActualizaCliente($data){
		
		$this->db->insert('clientes_actualiza', $data);
		
	} /*! ActualizaCliente */
	
}