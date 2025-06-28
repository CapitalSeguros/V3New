<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ws_sicasdre2
{
	var $UserName	= "GAP#aCap%2015";
	var $Password	= "CAP15gap20Ag";
	var $CodeAuth	= "vsDMquPhx68SZrY8wGcxEh2bk1XiPlR0EZkBVLmax3A4Mab7sDeeyodY3BjDuyB";
	var $key		= "%SOnlineBOGO2001-2015WS#";
	var $ivPass		= "GAP#aCap";
	//var $urlProceso = 'https://www.sicasonline.info/SOnlineWS/WS_SICASOnline.asmx?WSDL';
	var $urlProceso='';
	
	var $DeleteXml = array(
				'<?xml version="1.0" encoding="utf-8"?>',
				'<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">',
				'<ProcesarWSResponse xmlns="http://tempuri.org/">',
				'<ProcesarWSResult>',
				'</ProcesarWSResult>',
				'</ProcesarWSResponse>',
				'</soap:Envelope>',
						  );
	var $ClearXml = array(
				'',
				'',
				'',
				'',
				'',
				'',
				'',
						 );
	
	public function __construct($params){
		date_default_timezone_set('America/Merida');
		$this->id_sicas		= $params['id_sicas'];
		//$this->user_sicas	= $params['user_sicas'];
		//$this->pass_sicas	= $params['pass_sicas'];
		$this->user_sicas	= 'SISTEMAS@ASESORESCAPITAL.COM';
		$this->pass_sicas	= 'ACHAN2019';

	}

	/*
	* Encriptacion JjHeDre
	*/
	private function encripta($key,$ivPass,$TextPlain){

		if(strlen($key)!=24){
			throw new Exception('La longitud de la key ha de ser de 24 dígitos.<br>'); 
			return -1;	
		} 
		if((strlen($ivPass) % 8 )!=0){
		throw new Exception('La longitud del vector iv Passsword ha de ser múltiple de 8 dígitos.<br>'); 
			return -2;
		}
		return @base64_encode(mcrypt_encrypt(MCRYPT_3DES, $key, $TextPlain, MCRYPT_MODE_CBC, $ivPass));

//		return
	//		null;
	}/*! encripta */
	
	/*
	* DesEncriptacion JjHeDre
	*/
	private function desencripta($key,$ivPass,$TextEncrip){
		if (strlen($key)!=24){
			throw new Exception('La longitud de la key ha de ser de 24 d�gitos.');
			return -1;
		} if ((strlen($ivPass) % 8 )!=0){
			throw new Exception('La longitud del vector iv Password ha de ser m�ltiple de 8 d�gitos.');
			return -2;
		}
		return @mcrypt_decrypt(MCRYPT_3DES, $key, base64_decode($TextEncrip), MCRYPT_MODE_CBC, $ivPass);
	}/*! desencripta */

	/*
	* ConsumoWsSicas JjHeDre
	*/
	private function consumowssicas($xmlData){



//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($xmlData, TRUE));fclose($fp);



           $headers = array(
                        "POST /SOnlineWSQua/WS_SICASOnline.asmx HTTPS/1.1",
                        "Content-Type: text/xml; charset=utf-8",
                        "Accept: text/xml",                        
                        "Host: www.sicasonline.info",
                        "Pragma: no-cache",
                        "SOAPAction: http://tempuri.org/ProcesarWS", 
                        "Content-length: ".strlen($xmlData),
                    );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->urlProceso);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlData); // the SOAP request
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_TIMEOUT, 100);
            curl_setopt($ch, CURLOPT_POST, true);
         



            
            $response = curl_exec($ch);
            curl_close($ch);

            // converting
            $response1 = str_replace("<soap:Body>","",$response);            
            $response1 = str_replace("</soap:Body>","",$response1);
            

			
            return $response1;
	}/*! consumowssicas */

	/*
	* WsData JjHeDre
	*
	* @param	string KeyCode Static SICAS
	* @param	string TProc Static SICAS [Read_Data:0, Save_Data:1, Del_Data:2]
	* @param	string XML
	* @param	string Nodo A Extraer Info [Solo Un Registro]
	* @return	array
	*
	*/

	private function consumowssicasPruebas($xmlData){
//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r('xml de envio---'.$xmlData, TRUE));fclose($fp);	
           $headers = array(
                        "POST /SOnlineWSQua/WS_SICASOnline.asmx HTTPS/1.1",
                        "Content-Type: text/xml; charset=utf-8",
                        "Accept: text/xml",                        
                        "Host: www.sicasonline.info",
                        "Pragma: no-cache",
                        "SOAPAction: http://tempuri.org/ProcesarWS", 
                        "Content-length: ".strlen($xmlData),
                    );

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->urlProceso);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlData); // the SOAP request
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_TIMEOUT, 100);
            curl_setopt($ch, CURLOPT_POST, true);
         



            // converting
            $response = curl_exec($ch);
	
            curl_close($ch);

            // converting
            $response1 = str_replace("<soap:Body>","",$response);            
            $response1 = str_replace("</soap:Body>","",$response1);

            

			
            return $response1;
	}/*! consumowssicas */

	public function wsdataPruebas($wsKeycode, $wsTipo, $wsTextoPlano, $wsNodoExtrae){

		//require('KLogger/vendor/autoload.php');
		//$logger = new Katzgrau\KLogger\Logger(__DIR__.'/logs');//Katzgrau\KLogger\Logger(__DIR__.'./../logs/xmlSw');
			
			$oLog = array('TextoPlano'=>$wsTextoPlano);

	
		$textoEncriptado = $this->encripta($this->key,$this->ivPass,$wsTextoPlano);
		$xmlSend	='<?xml version="1.0" encoding="utf-8"?>
			<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
			<soap:Body>
				<ProcesarWS xmlns="http://tempuri.org/">
					<oDataWS>
						<Credentials>
							<UserName>'.$this->UserName.'</UserName>
							<Password>'.$this->Password.'</Password>
							<CodeAuth>'.$this->CodeAuth.'</CodeAuth>
						</Credentials>
						<CredentialsUserSICAS>
							<UserName>'.$this->user_sicas.'</UserName>
							<Password>'.$this->pass_sicas.'</Password>
						</CredentialsUserSICAS>
						<TypeFormat>XML</TypeFormat>
						<KeyProcess>DATA</KeyProcess>
						<KeyCode>'.$wsKeycode.'</KeyCode>
						<TProc>'.$wsTipo.'</TProc>
						<DataXML>'.$textoEncriptado.'</DataXML>
					</oDataWS>
				</ProcesarWS>
			</soap:Body>
		</soap:Envelope>';		
	
		$oLog['XMLFinal'] = $xmlSend;
//		$logger->debug('XML Procesado.', $oLog);

    
   
		$resXmlConsumo = str_replace($this->DeleteXml, $this->ClearXml, $this->consumowssicasPruebas($xmlSend));
  	    	

					
		$xmlTexto_resXmlConsumo = htmlspecialchars_decode($resXmlConsumo);

$xmlRespuesta=<<<XML
	$xmlTexto_resXmlConsumo
XML;
		
			$return = array();

		if(simplexml_load_string($xmlRespuesta)){
			$nodoAs = (string)$wsNodoExtrae;
			$carga_xmlRespuesta = simplexml_load_string($xmlRespuesta);
			foreach ($carga_xmlRespuesta->$nodoAs as $DatoCliente){
				$return[] = $DatoCliente;
			}
		} else {
			$return = false;
		}
		//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r("datos".$return, TRUE));fclose($fp);		
		return
			$return;
	}/*! wsdata */

//----------------------------------------------------------------------------------------------------------------------------------------
	public function wsdata($wsKeycode, $wsTipo, $wsTextoPlano, $wsNodoExtrae){

			//require('KLogger/vendor/autoload.php');
			//$logger = new Katzgrau\KLogger\Logger(__DIR__.'/logs');//Katzgrau\KLogger\Logger(__DIR__.'./../logs/xmlSw');
			
			//$oLog = array('TextoPlano'=>$wsTextoPlano);


		$textoEncriptado = $this->encripta($this->key,$this->ivPass,$wsTextoPlano);
		
		$xmlSend	='<?xml version="1.0" encoding="utf-8"?>
			<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
			<soap:Body>
				<ProcesarWS xmlns="http://tempuri.org/">
					<oDataWS>
						<Credentials>
							<UserName>'.$this->UserName.'</UserName>
							<Password>'.$this->Password.'</Password>
							<CodeAuth>'.$this->CodeAuth.'</CodeAuth>
						</Credentials>
						<CredentialsUserSICAS>
							<UserName>'.$this->user_sicas.'</UserName>
							<Password>'.$this->pass_sicas.'</Password>
						</CredentialsUserSICAS>
						<TypeFormat>XML</TypeFormat>
						<KeyProcess>DATA</KeyProcess>
						<KeyCode>'.$wsKeycode.'</KeyCode>
						<TProc>'.$wsTipo.'</TProc>
						<DataXML>'.$textoEncriptado.'</DataXML>
					</oDataWS>
				</ProcesarWS>
			</soap:Body>
		</soap:Envelope>';		
		

		//$oLog['XMLFinal'] = $xmlSend;
		//$logger->debug('XML Procesado.', $oLog);

    
      	//  $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r("cortar apartir de aca 2", TRUE));fclose($fp);	
		$resXmlConsumo = str_replace($this->DeleteXml, $this->ClearXml, $this->consumowssicas($xmlSend));
  	 
      //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($resXmlConsumo, TRUE));fclose($fp);	
					
		$xmlTexto_resXmlConsumo = htmlspecialchars_decode($resXmlConsumo);

 	
$xmlRespuesta=<<<XML
	$xmlTexto_resXmlConsumo
XML;

			$return = array();

		if(simplexml_load_string($xmlRespuesta)){
			
			$nodoAs = (string)$wsNodoExtrae; /*  DATAINFO  */
			$carga_xmlRespuesta	= simplexml_load_string($xmlRespuesta);			

			foreach ($carga_xmlRespuesta->$nodoAs as $DatoCliente){ // ->$nodoAs
				$return[] = $DatoCliente;
			}

		} else {
			$return = false;
		}

		
		//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r("datos".$return, TRUE));fclose($fp);
		
		return
			$return;

		//echo "<pre>";
		//print_r($return);
		//print($xmlRespuesta);
			
	}/*! wsdata */
//-------------------------------------------------------------------------------------------------
	public function WsDataSave(){
	}

	public function WsDataUpdate(){
	}
	
	/*
	* WsReport JjHeDre
	*
	* @param	string KeyCode Static SICAS
	* @param	array [Page, ItemForPage, InfoSort]
	* @param	string Condiciones Adicionales para Filtrar o buscasr informacion
	* @param	string Nodo en el cual esxtraemos la info de la respuesta
	* @return	array
	*/
	public function wsreport($wsKeycode, $wsBody, $wsConditionsAdd, $wsNodoExtrae){
		$xmlSend	='<?xml version="1.0" encoding="utf-8"?>
			<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
			<soap:Body>
				<ProcesarWS xmlns="http://tempuri.org/">
					<oDataWS>
						<Credentials>
							<UserName>'.$this->UserName.'</UserName>
							<Password>'.$this->Password.'</Password>
							<CodeAuth>'.$this->CodeAuth.'</CodeAuth>
						</Credentials>
						<CredentialsUserSICAS>
							<UserName>'.$this->user_sicas.'</UserName>
							<Password>'.$this->pass_sicas.'</Password>
						</CredentialsUserSICAS>
						<TypeFormat>XML</TypeFormat>
						<KeyProcess>REPORT</KeyProcess>
						<KeyCode>'.$wsKeycode.'</KeyCode>
						<Page>'.$wsBody['Page'].'</Page>
						<ItemForPage>'.$wsBody['ItemForPage'].'</ItemForPage>
						<InfoSort>'.$wsBody['InfoSort'].'</InfoSort>
						<ConditionsAdd>'.$wsConditionsAdd.'</ConditionsAdd>
					</oDataWS>
				</ProcesarWS>
			</soap:Body>
		</soap:Envelope>';

		$resXmlConsumo = str_replace($this->DeleteXml, $this->ClearXml, $this->consumowssicas($xmlSend));
		$xmlTexto_resXmlConsumo = htmlspecialchars_decode($resXmlConsumo);


$xmlRespuesta=<<<XML
	$xmlTexto_resXmlConsumo
XML;

		if(simplexml_load_string($xmlRespuesta)){
			$nodoAs = (string)$wsNodoExtrae;
			$carga_xmlRespuesta = simplexml_load_string($xmlRespuesta);
			$return = array();
			foreach ($carga_xmlRespuesta->$nodoAs as $DatoRegistro){
				$return[] = $DatoRegistro;
			}
		}




		return
			$return;
	}/*! wsreport */
	
	/*
	* WsCdigital JjHeDre
	*
	* @param	array [TypeDestinoCDigital, IDValuePK, ListFilesURL]
	* @param	string ActionCDigital
	*/
	public function wscdigital($wsBody, $wsAction, $wsNodoExtrae){
	/*ENVIO DE ARCHIVOS A SICAS*/
		$xmlSend	='<?xml version="1.0" encoding="utf-8"?>
			<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
			<soap:Body>
				<ProcesarWS xmlns="http://tempuri.org/">
					<oDataWS>
						<Credentials>
							<UserName>'.$this->UserName.'</UserName>
							<Password>'.$this->Password.'</Password>
							<CodeAuth>'.$this->CodeAuth.'</CodeAuth>
						</Credentials>
						<CredentialsUserSICAS>
							<UserName>'.$this->user_sicas.'</UserName>
							<Password>'.$this->pass_sicas.'</Password>
						</CredentialsUserSICAS>
						<TypeFormat>XML</TypeFormat>
						<KeyProcess>CDIGITAL</KeyProcess>
						<TypeDestinoCDigital>'.$wsBody['TypeDestinoCDigital'].'</TypeDestinoCDigital>
						<IDValuePK>'.$wsBody['IDValuePK'].'</IDValuePK>
						<ActionCDigital>'.$wsAction.'</ActionCDigital>
						<ListFilesURL>'.$wsBody['ListFilesURL'].'</ListFilesURL>
						<FolderDestino>'.$wsBody['FolderDestino'].'</FolderDestino>
					</oDataWS>
				</ProcesarWS>
			</soap:Body>
		</soap:Envelope>';
	


		$resXmlConsumo = str_replace($this->DeleteXml, $this->ClearXml, $this->consumowssicas($xmlSend));
		$xmlTexto_resXmlConsumo = htmlspecialchars_decode($resXmlConsumo);

$xmlRespuesta=<<<XML
	$xmlTexto_resXmlConsumo
XML;

	
		if(simplexml_load_string($xmlRespuesta)){
			$nodoAs = (string)$wsNodoExtrae;
			$carga_xmlRespuesta = simplexml_load_string($xmlRespuesta);
			$return = array();
			foreach ($carga_xmlRespuesta->$nodoAs as $DatoRegistro){
				$return[] = $DatoRegistro;
			}
			return 
				$return;
		}
		
		return 
			false;

	}/*! wscdigital */
	
}
?>
