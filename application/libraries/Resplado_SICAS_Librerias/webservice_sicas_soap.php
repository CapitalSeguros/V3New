<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//** require('KLogger/vendor/autoload.php');

class webservice_sicas_soap
{
	var $CI;
	var $uri_service	= "https://www.sicasonline.info/SOnlineWS/WS_SICASOnline.asmx?WSDL";
	var $key			= "%SOnlineBOGO2001-2015WS#";
	var $ivPass			= "GAP#aCap";
	var $soapC;
	var $oDataWS;
//	var $logger;			
				
	function __construct()
	{

		$this->CI		=& get_instance();	
//		$this->logger	= new Katzgrau\KLogger\Logger(__DIR__.'/logs'); //new Katzgrau\KLogger\Logger(__DIR__.'./../logs/xmlSw'); // new Katzgrau\KLogger\Logger(__DIR__.'/logs');

		try {
			$this->CI =& get_instance();
			$this->soapC = new SoapClient($this->uri_service, array('trace' => 1));	

			set_time_limit(900);
		} catch (Exception $e) {
			
		}

	}

	function init(){
		$this->oDataWS	= new \stdClass;
		$this->oDataWS->Credentials	= new \stdClass;
		$this->oDataWS->Credentials->UserName	= 'GAP#aCap%2015';
		$this->oDataWS->Credentials->Password	= 'CAP15gap20Ag';
		$this->oDataWS->Credentials->CodeAuth	= 'vsDMquPhx68SZrY8wGcxEh2bk1XiPlR0EZkBVLmax3A4Mab7sDeeyodY3BjDuyB';
		$this->oDataWS->CredentialsUserSICAS	= new \stdClass;
		
		if($this->CI->tank_auth->get_UserSICAS() == "" && $this->oDataWS->CredentialsUserSICAS->Password = $this->CI->tank_auth->get_PassSICAS() == ""){
			$this->oDataWS->CredentialsUserSICAS->UserName = "SISTEMAS@ASESORESCAPITAL.COM";
			$this->oDataWS->CredentialsUserSICAS->Password = "ECHAN2019";
		}else{
			$this->oDataWS->CredentialsUserSICAS->UserName = $this->CI->tank_auth->get_UserSICAS();
			$this->oDataWS->CredentialsUserSICAS->Password = $this->CI->tank_auth->get_PassSICAS();
		}
	
	}
	
	function datos($wsdata){
			try {
				//require('KLogger/vendor/autoload.php');
				$this->init();
				//Default Values
				$this->oDataWS->TipoEntidad = '0';
				$this->oDataWS->TypeDestinoCDigital = 'CONTACT'; 
				$this->oDataWS->IDValuePK = '0'; 
				$this->oDataWS->ActionCDigital = 'GETFiles';
				$this->oDataWS->TypeFormat = 'XML';
				$this->oDataWS->TProc = 'Read_Data'; 
				$this->oDataWS->KeyProcess = 'REPORT';
				$this->oDataWS->KeyCode = '';
				$this->oDataWS->Page ='1';
				$this->oDataWS->ItemForPage = '1000000';
				$this->oDataWS->InfoSort = 'DatDocumentos.IDDocto';
				$this->oDataWS->IDRelation = '0';
				$this->oDataWS->ConditionsAdd = '';

				if(isset($wsdata['TipoEntidad']))
					$this->oDataWS->TipoEntidad = $wsdata['TipoEntidad']; 
				
				if(isset($wsdata['IDRelation']))
					$this->oDataWS->IDRelation = $wsdata['IDRelation']; 

				if(isset($wsdata['TypeDestinoCDigital']))
					$this->oDataWS->TypeDestinoCDigital = $wsdata['TypeDestinoCDigital']; 

				if(isset($wsdata['IDValuePK']))
					$this->oDataWS->IDValuePK = $wsdata['IDValuePK']; 

				if(isset($wsdata['ActionCDigital']))
					$this->oDataWS->ActionCDigital = $wsdata['ActionCDigital']; 

				if(isset($wsdata['Page']))
					$this->oDataWS->Page = $wsdata['Page']; 

				if(isset($wsdata['TProc']))
					$this->oDataWS->TProc = $wsdata['TProc']; 

				if(isset($wsdata['KeyProcess']))
					$this->oDataWS->KeyProcess = $wsdata['KeyProcess']; 

				if(isset($wsdata['KeyCode']))
					$this->oDataWS->KeyCode = $wsdata['KeyCode']; 

				if(isset($wsdata['ItemForPage']))
					$this->oDataWS->ItemForPage = $wsdata['ItemForPage']; 

				if(isset($wsdata['InfoSort']))
					$this->oDataWS->InfoSort = $wsdata['InfoSort']; 

				if(isset($wsdata['ConditionsAdd']))
					$this->oDataWS->ConditionsAdd = $wsdata['ConditionsAdd']; 

				//Consumir el Servicio Web
				$parameters = array('oDataWS' => $this->oDataWS, );
				
				$resutl = $this->soapC->ProcesarWS($parameters);

				if (strpos($resutl->ProcesarWSResult, 'DENIED') !== false) {
				    return NULL;
				}
			$xml = new SimpleXMLElement($resutl->ProcesarWSResult);
			return $xml;
			}
			catch(Exception $e){

			 	
			}
						   }

	/*
	* Encriptacion Juan jose
	*/
	private function encripta($key,$ivPass,$TextPlain){

		if(strlen($key)!=24){
			throw new Exception('La longitud de la key ha de ser de 24 dígitos.<br>'); 
			return -1; 
		} if((strlen($ivPass) % 8 )!=0){ 
			throw new Exception('La longitud del vector iv Passsword ha de ser múltiple de 8 dígitos.<br>'); 
			return -2; 
		} 

		return @base64_encode(mcrypt_encrypt(MCRYPT_3DES, $key, $TextPlain, MCRYPT_MODE_CBC, $ivPass)); 
	} 
	/*
	* desencriptacion Juan jose
	*/
	private function desencripta($key,$ivPass,$TextEncrip){ 

			
		if (strlen($key)!=24){ 				
			throw new Exception('La longitud de la key ha de ser de 24 dígitos.');
			return -1; 
		} if ((strlen($ivPass) % 8 )!=0){ 
			throw new Exception('La longitud del vector iv Password ha de ser múltiple de 8 dígitos.');
			return -2; 
		} 
		
		$TextEncrip=@mcrypt_decrypt(MCRYPT_3DES, $key, base64_decode($TextEncrip), MCRYPT_MODE_CBC, $ivPass); 

		return $TextEncrip; 
	}

	function array_to_xml($array, &$xml_user_info) {
	    foreach($array as $key => $value) {
	        if(is_array($value)) {
	            if(!is_numeric($key)){
	                $subnode = $xml_user_info->addChild("$key");
	                $this->array_to_xml($value, $subnode);
	            }else{
	                $subnode = $xml_user_info->addChild("item$key");
	                $this->array_to_xml($value, $subnode);
	            }
	        }else {
	            $xml_user_info->addChild("$key",htmlspecialchars("$value"));
	        }
	    }
	}
	function array2XML($data, $rootNodeName = 'results', $xml=NULL){
    if ($xml == null){
        $xml = simplexml_load_string("<?xml version='1.0' encoding='utf-8'?><$rootNodeName />");
    }

    foreach($data as $key => $value){
        if (is_numeric($key)){
            $key = "nodeId_". (string) $key;
        }

        if (is_array($value)){
            $node = $xml->addChild($key);
            array2XML($value, $rootNodeName, $node);
        } else {
            $value = htmlentities($value);
            $xml->addChild($key, $value);
        }

    }
				         
    //return html_entity_decode($xml->asXML());
}
//-------------------------------------------------------------------
function getDatosSicas($wsdata){
		$xml='<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:tem="http://tempuri.org/"> <soap:Header/> <soap:Body> <ProcesarWS xmlns="http://tempuri.org/"> <oDataWS> <Credentials>';
$xml=$xml.'<UserName>GAP#aCap%2015</UserName>';
$xml=$xml.'<Password>CAP15gap20Ag</Password>';
$xml=$xml.'<CodeAuth>vsDMquPhx68SZrY8wGcxEh2bk1XiPlR0EZkBVLmax3A4Mab7sDeeyodY3BjDuyB</CodeAuth></Credentials>';
$xml=$xml.'<CredentialsUserSICAS><UserName>SISTEMAS@ASESORESCAPITAL.COM</UserName>';
$xml=$xml.'<Password>ACHAN2019</Password></CredentialsUserSICAS>';
foreach ($wsdata as $key => $value) {$xml=$xml.'<'.$key.'>'.$value.'</'.$key.'>';}
$xml=$xml.'</oDataWS> </ProcesarWS> </soap:Body> </soap:Envelope>';
$DeleteXml = array('<?xml version="1.0" encoding="utf-8"?>','<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">','<DATAINFO> ','<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"><soap:Body>','<ProcesarWSResponse xmlns="http://tempuri.org/">','<ProcesarWSResult>','</ProcesarWSResult>','</ProcesarWSResponse>','</soap:Envelope>','</DATAINFO> ','</soap:Body>','</DATAINFO> ',);
$ClearXml = array('','','','','','','','','','','','',);

           $headers = array("POST /SOnlineWSQua/WS_SICASOnline.asmx HTTPS/1.1","Content-Type: text/xml; charset=utf-8","Accept: text/xml","Host: www.sicasonline.info",
                        "Pragma: no-cache","SOAPAction: http://tempuri.org/ProcesarWS", "Content-length: ".strlen($xml),);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'https://www.sicasonline.info:448/SOnlineWS/WS_SICASOnline.asmx?WSDL');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml); // the SOAP request
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
            curl_setopt($ch, CURLOPT_TIMEOUT, 100);
            curl_setopt($ch, CURLOPT_POST, true);
            // converting
            
            $response = curl_exec($ch); 

            $resXmlConsumo = str_replace($DeleteXml, $ClearXml, $response);

            $xmlTexto_resXmlConsumo = htmlspecialchars_decode($resXmlConsumo);
           
            $xmlRespuesta=<<<XML
	$xmlTexto_resXmlConsumo
XML;
 
	$carga_xmlRespuesta = simplexml_load_string($xmlRespuesta);

            curl_close($ch);
 
	      return $carga_xmlRespuesta;
}
//------------------------------------------------------------------
	private function ObtenerDatos($wsdata){

		if(is_array($wsdata)){
			try {
				$this->init();
				//Default Values
				$this->oDataWS->TipoEntidad = '0';
				$this->oDataWS->TypeDestinoCDigital = 'CONTACT'; 
				$this->oDataWS->IDValuePK = '0'; 
				$this->oDataWS->ActionCDigital = 'GETFiles';

				$this->oDataWS->TypeFormat = 'XML';
				$this->oDataWS->TProc = 'Read_Data'; 
				$this->oDataWS->KeyProcess = 'REPORT';
				$this->oDataWS->KeyCode = '';
				$this->oDataWS->Page ='1';
				$this->oDataWS->ItemForPage = '25';
				$this->oDataWS->InfoSort = '';
				$this->oDataWS->IDRelation = '0';
				$this->oDataWS->ConditionsAdd = '';
				//Default Values
			

				if(isset($wsdata["XML"])){
					$xmlS = new SimpleXMLElement('<InfoData/>');
					$this->array_to_xml($wsdata['XML'], $xmlS);	
					$xmlData = $xmlS->asXML();

					$TextEncript = $this->encripta($this->key, $this->ivPass, $xmlData);
					$this->oDataWS->DataXML = $TextEncript;
				}

				if(isset($wsdata['TipoEntidad']))
					$this->oDataWS->TipoEntidad = $wsdata['TipoEntidad']; 
				
				if(isset($wsdata['IDRelation']))
					$this->oDataWS->IDRelation = $wsdata['IDRelation']; 

				if(isset($wsdata['TypeDestinoCDigital']))
					$this->oDataWS->TypeDestinoCDigital = $wsdata['TypeDestinoCDigital']; 

				if(isset($wsdata['IDValuePK']))
					$this->oDataWS->IDValuePK = $wsdata['IDValuePK']; 

				if(isset($wsdata['ActionCDigital']))
					$this->oDataWS->ActionCDigital = $wsdata['ActionCDigital']; 

				if(isset($wsdata['Page']))
					$this->oDataWS->Page = $wsdata['Page']; 

				if(isset($wsdata['TProc']))
					$this->oDataWS->TProc = $wsdata['TProc']; 

				if(isset($wsdata['KeyProcess']))
					$this->oDataWS->KeyProcess = $wsdata['KeyProcess']; 

				if(isset($wsdata['KeyCode']))
					$this->oDataWS->KeyCode = $wsdata['KeyCode']; 

				if(isset($wsdata['ItemForPage']))
					$this->oDataWS->ItemForPage = $wsdata['ItemForPage']; 

				if(isset($wsdata['InfoSort']))
					$this->oDataWS->InfoSort = $wsdata['InfoSort']; 

				if(isset($wsdata['ConditionsAdd']))
					$this->oDataWS->ConditionsAdd = $wsdata['ConditionsAdd']; 

				//Consumir el Servicio Web
				$parameters = array('oDataWS' => $this->oDataWS, );
          
				$resutl = $this->soapC->ProcesarWS($parameters);

				 // echo 'Request'. $this->soapC->__getLastRequest();

				if (strpos($resutl->ProcesarWSResult, 'DENIED') !== false) {
				    return NULL;
				}

				$xml = new SimpleXMLElement($resutl->ProcesarWSResult);

				return $xml;

			} catch (Exception $e) {
			
			}
		}
	}

	public function getConditionalVendedor($type = ''){

		//Recupero Array
		$aVendedores = $this->CI->role->getVendedores();
        
		if(count($aVendedores) > 0){
			$sConditional = implode('|', $aVendedores);
			if($type == 'cli'){
				
				return 'VendedorID;2;0;'.$sConditional.';'.$sConditional.';CatClientes.FieldInt1 ! ';
			}else{

				return 'VendedorID;2;0;'.$sConditional.';'.$sConditional.';CatVendedores.IdVend ! ';
			}
		}else{
			return '';
		}
	}

	public function GetClient($data){
		
		$page = 1; 
		$itemforPage = 25;
		$role = "";
		$VendedorID = 0;
		$customConditionsAdd = "";
		
		if(is_array($data)){
			$role = $data["role"];
			$VendedorID = $data["id"];
			if($role == "MASTER"){
				$customConditionsAdd = "Campo;0;0;0;0;0;-1;CatClientes.FieldInt1";
			}else{
				$customConditionsAdd = "Campo;0;0; 7; 7 ;0;-1;CatClientes.FieldInt1	";
				// $customConditionsAdd = "Campo;0;0; $VendedorID ; $VendedorID ;0;-1;CatClientes.FieldInt1	";
			}
		} 
		
		
		$data_body = array(
			"Page" => $page,
			"ItemForPage" => $itemforPage,
			"ConditionsAdd" => $customConditionsAdd,
			"InfoSort"=>"CatClientes.IDCli",
			"KeyCode"=>"HDS00002",
			"KeyProcess"=>"REPORT",
		);	

		$result = $this->ObtenerDatos($data_body);
		
		// var_dump($result);

		return $result;
	}

	public function GetClientp100($data){
		
		$page = 1; 
		$itemforPage = 300;
		$role = "";
		$VendedorID = 0;
		$customConditionsAdd = "";
		
		if(is_array($data)){
			$role = $data["role"];
			$VendedorID = $data["id"];

			if($role == "MASTER"){
				$customConditionsAdd = "FieldInt1;0;0;0;0;0;-1;CatClientes.FieldInt1";
			}else{
				$customConditionsAdd = "FieldInt1;0;0;".$VendedorID.";".$VendedorID.";0;-1;CatClientes.FieldInt1";
				// $customConditionsAdd = "Campo;0;0; $VendedorID ; $VendedorID ;0;-1;CatClientes.FieldInt1	";
			}
		} 
		
		
		$data_body = array(
			"Page" => $page,
			"ItemForPage" => $itemforPage,
			"ConditionsAdd" => $customConditionsAdd,
			"InfoSort"=>"CatClientes.IDCli",
			"KeyCode"=>"HDS00002",
			"KeyProcess"=>"REPORT",
		);	

		$result = $this->ObtenerDatos($data_body);
		
		// var_dump($result);

		return $result;
	}
	
	 public function GetClientsURL($data){
		
		$page = 1; 
		$itemforPage = 50;
		$role = "";
		$VendedorID = 0;
		$customConditionsAdd = "";
		$result = "";
		$busquedaCliente = "";
		
		if(is_array($data)){

			if(isset($data['page'])){
				$page = $data['page'];	
			}
			
			// var_dump($busquedaCliente);
			
			// $customConditionsAdd .= 'Regimen Fiscal;0;0;'. $Regimen .';'. $Regimen .';0;-1;CatClientes.TipoEnt';
			// $customConditionsAdd .= '!';
			$customConditionsAdd .= 'Nombre Completo;0;0;**;;0;-1;CatClientes.NombreCompleto ! URL;0;0;;;0;-1;CatClientes.URL ';
			
	
			$data_body = array(
				"Page" => $page,
				"ItemForPage" => $itemforPage,
				"ConditionsAdd" => $customConditionsAdd,
				"InfoSort"=>"CatClientes.IDCli",
				"KeyCode"=>"HDS00002",
				"KeyProcess"=>"REPORT",
			);	
			$result = $this->ObtenerDatos($data_body);
		}		
		 
		return $result;
		
	}
	

	public function UpdateClienteForSubRamo($maxPage)
	{
		$pages = $maxPage;
		$page = 1;
		try{

			do {
				$data = array('page'=> $page,);					
				$result_nameDirectory = $this->GetClientsURL($data);
				//var_dump($result_nameDirectory);
				if($result_nameDirectory->TableInfo != NULL){
					foreach ($result_nameDirectory->TableInfo as $item) {

						$pagePolicy = 1;
						$pagesPolicy = 0;
						$tmpBestSalesMan = array();
                        $tmpSRamo = array();

						do{

							$data_policy = array('idCli'=> $item->IDCli, 'page' => $pagePolicy);
							$this->logger->debug("Id de cliente a procesar y pagina: ", $data_policy);							

							$policy_result = $this->GetPolicy_forClient($data_policy);	
							
							if($policy_result->TableInfo != NULL)
							{
								foreach ($policy_result->TableInfo as $value) {
                                    
									if(!in_array(strval($value->IDSRamo), $tmpSRamo)){
										array_push($tmpSRamo,strval($value->IDSRamo));
									}
								}
								// var_dump($tmpBestSalesMan);
								$pagesPolicy = $policy_result->TableControl->Pages;
							}
							$pagePolicy++;
						}while($pagePolicy < $pagesPolicy);
						
						$this->logger->debug("array temporal de subRamos: ", $tmpSRamo );
                        
						if(count($tmpSRamo) > 0){
							$maxValue = implode('|',$tmpSRamo);
							$this->SetSRamoID($item->IDCont,$maxValue);	
						}else{
							$this->logger->debug("count < 0: ", array() );
							$this->SetSRamoID($item->IDCont,54);	
						}
						
						$this->logger->debug("Id contacto actualizado: ", array($item->IDCont) );
					}					
				}

				$page++;
				$this->logger->debug("page : ", array($page));
			} while ( $page < $pages);			
							
		}catch(Exception $ex){

		}
	}
  
	
	public function GetClient_forIdVend($data)
	{
		$page = 1; 
		$itemforPage = 1500;
		$role = "";
		$VendedorID = 0;
		$customConditionsAdd = "Email;1;0;;;CatClientes.Email1 ! ";
		if(is_array($data)){

			if(isset($data['page'])){
				$page = $data['page'];	
			}

			if (isset($data['IdVend'])) {
				$VendedorID = $data['IdVend'];
				$customConditionsAdd .="VendedorID;0;0;".$VendedorID.";".$VendedorID.";CatClientes.FieldInt1 ";
			    $datos['TipoEntidad']='0';
        $datos['TypeDestinoCDigital']='CONTACT';
    $datos['IDValuePK']='0';
    $datos['ActionCDigital']='GETFiles';
    $datos['TypeFormat']='XML';
    $datos['TProct']='Read_Data';
    $datos['KeyProcess']='REPORT';
    $datos['KeyCode']='HDS00002';
    $datos['Page']='1';
    $datos['ItemForPage']='2000';
    $datos['InfoSort']='CatClientes.NombreCompleto';
    $datos['IDRelation']='0';
    $datos['ConditionsAdd']=$customConditionsAdd;

                $result = $this->getDatosSicas($datos);
              

			}else{
				$customConditionsAdd .= $this->getConditionalVendedor();
				$customConditionsAdd = substr($customConditionsAdd, 0, -2);	
			    $data_body = array(
			"Page" => $page,
			"ItemForPage" => $itemforPage,
			"ConditionsAdd" => $customConditionsAdd,
			"InfoSort"=>"CatClientes.IDCli",
			"KeyCode"=>"HDS00002",
			"KeyProcess"=>"REPORT",
			);	
			     
			$result = $this->ObtenerDatos($data_body);	
			}

			


			$pagination = array();
				if(isset($result->TableControl)){
					$pagination = array('Pages'=>strval($result->TableControl->MaxRecords) ,'Page'=>$result->TableControl->Page);
				}	
				$result_c = array(
					'clientes' =>$result->TableInfo,
					'paginacion' =>  $pagination);
		}
 
		return $result_c;
	}
//-------------------------------------------------------------------------------


//-------------------------------------------------------------------------------
	public function GetInfoBit($data){

		$page = 1; 
		$itemforPage = 10;
		$role = "";
		$VendedorID = 0;
		$customConditionsAdd = "";
		if(is_array($data)){

			if(isset($data['page'])){
				$page = $data['page'];	
			}
		
			$customConditionsAdd = "Bitacora;0;0;".$data['claveBit'].";Tarea;DatBitacora.ClaveBit";
			
			$data_body = array(
				"Page" => $page,
				"ItemForPage" => $itemforPage,
				"ConditionsAdd" => $customConditionsAdd,
				"InfoSort"=>"DatBitacora.IDBit",
				"KeyCode"=>"HWS_BITACORA",
				"KeyProcess"=>"REPORT",
			);	

			$result = $this->ObtenerDatos($data_body);
		}

		return $result;
	}

	public function UpdateCliente($data)
	{
		if (is_array($data)) 
		{ 
			$data_body = array(
				"XML" => $data,
				"TProc"=>"Save_Data",
				"KeyCode"=>"H02000",
				"KeyProcess"=>"DATA");

			$result = $this->ObtenerDatos($data_body);

			return $result;
		}	
	}

//----------------------------------------------------------------------------------------------
	public function GetClientsOnly($data){
		
		/*$page = 1; 
		$itemforPage = 300; //ANTES DE PONER CHECAR EN  LA LISTA DE EXPORTACION DE CLIENTES CUANTOS SON
		$role = "";
		$VendedorID = 0;
		$customConditionsAdd = "";
		$result = "";
		$busquedaCliente = "";
		$this->logger->debug('Data: ', $data);
		if(is_array($data)){

			if(isset($data['page'])){
				$page = $data['page'];	
			}
			
			//bUSCA EL CLIENTES ES ESPECIFICO ATRAVEZ DEL IDCLIENTE
			$customConditionsAdd .= 'Nombre Completo;0;0;**;;0;-1;CatClientes.NombreCompleto ! FieldInt2;0;0;0;0;0;-1;CatClientes.FieldInt2 ! IDCli;0;0;11556;11556;0;-1;CatClientes.IDCli ';


			// bUSCA CLIENTES CON ID DE VENDEDEDOR EN EL CAMPO FILD INT1
			//$customConditionsAdd .= 'Nombre Completo;0;0;**;;0;-1;CatClientes.NombreCompleto ! FieldInt2;0;0;0;0;0;-1;CatClientes.FieldInt2 ! FieldInt1;0;0;0;68;68;-1;CatClientes.FieldInt1 ';
					//ARRIBA PONGO EL ID VENDEDOR QUE QUIERO TRAER SUS POLIZAS EN ESTE CASO EL 43 O 7 ULTIMO CASO gap
			        // parametro ! es or
			        // de los 8 parametros en el 4 y 5 es el valor

			$data_body = array(
				"Page" => $page,
				"ItemForPage" => $itemforPage,
				"ConditionsAdd" => $customConditionsAdd,
				"InfoSort"=>"CatClientes.IDCli",
				"KeyCode"=>"HDS00002",
				"KeyProcess"=>"REPORT",
			);	
						
			$result = $this->ObtenerDatos($data_body);

			
			// $this->logger->debug('result: ', array($result));
		}		*/
		$datos['TipoEntidad']='0';
       $datos['TypeDestinoCDigital']='CONTACT';
       $datos['IDValuePK']='0';
       $datos['ActionCDigital']='GETFiles';
       $datos['TypeFormat']='XML';
       $datos['TProct']='Read_Data';
       $datos['KeyProcess']='REPORT';
       $datos['KeyCode']='HDS00002';
       $datos['Page']='1';
       $datos['ItemForPage']='10000000';
       $datos['InfoSort']='CatClientes.IDCli';
       $datos['IDRelation']='0';
       $datos['ConditionsAdd']='Nombre Completo;0;0;**;;0;-1;CatClientes.NombreCompleto ! FieldInt2;0;0;0;0;0;-1;CatClientes.FieldInt2 ! IDCli;0;0;'.$data.';'.$data.';0;-1;CatClientes.IDCli';
      //$datos['ConditionsAdd']='Nombre Completo;0;0;**;;0;-1;CatClientes.NombreCompleto ! FieldInt2;0;0;1;1;0;-1;CatClientes.FieldInt2 !  IDCli;0;0;'.$data.';'.$data.';0;-1;CatClientes.IDCli';
      
      
        $this->CI->load->library('Ws_sicas'); 
        $result=$this->CI->ws_sicas->getDatosSICAS($datos);
       //	$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($result,TRUE));fclose($fp);
		return $result;
		
	}
//----------------------------------------------------------------------------------------------
	public function GetPolicy_forClient($data){
		$page = 1; 
		$itemforPage = 25;
		$role = "";
		$VendedorID = 0;
		$customConditionsAdd = "";
		$result = "";
		$busquedaCliente = "";
		
		if(is_array($data)){
			
			$idCli 	= $data["idCli"];
			if(isset($data['page'])){
				$page = $data['page'];	
			}
			$infoSort = 'CatClientes.IDCli';

			if(isset($data['Sort'])){
				$infoSort = $data['Sort'];
			}


			if(isset($data['ItemForPage'])){
				$itemforPage = $data['ItemForPage'];
			}

			
			// $sDate = "01/01/".date("Y");

			$customConditionsAdd .= 'Cliente Id;0;0;'. $idCli .';'. $idCli .';0;-1;DatDocumentos.IDCli ! Tipo Documento;0;0;1;1;DatDocumentos.TipoDocto ! Cliente Id;0;0;0;0;0;-1;DatDocumentos.Status ! ';

			if(isset($data['ExtraFilter'])){
				$customConditionsAdd .= $data['ExtraFilter'];
			}
			
			$customConditionsAdd = substr($customConditionsAdd, 0, -2);		

			
			// ! Id Cliente;5;0;'.$sDate.';0;DatDocumentos.FHasta
			
			$data_body = array(
				"Page" => $page,
				"ItemForPage" => $itemforPage,
				"ConditionsAdd" => $customConditionsAdd,
				"InfoSort"=>$infoSort,
				"KeyCode"=>"HWS_DOCTOS",
				"KeyProcess"=>"REPORT",
			);	

        $this->CI->load->library('Ws_sicas'); 
        $result=$this->CI->ws_sicas->getDatosSICAS($data_body);
			
			//$result = $this->ObtenerDatos($data_body);
			return $result;
		}
	}
//----------------------------------------------------------------------------------------------
	public function SetVendedorID($IDCli,$IdVend)
	{

		$IDCli=(string)$IDCli;
		//$xml_array = array('CatClientes' => array('IDCli'=> $IDCli,'FieldText1'=>$IdVend));
		$xml_array = array('CatClientes' => array('IDCli'=> $IDCli,'FieldInt1'=>$IdVend));
		$data_body = array(
			"XML" => $xml_array,
			"TProc"=>"Save_Data",
			"KeyCode"=>"H02000",
			"KeyProcess"=>"DATA",
		);
		$array['IDCli']=$IDCli;
		$array['FieldInt1']=$IdVend;		
        $result=$this->CI->ws_sicas->modificarCliente($array);

	//	$result = $this->ObtenerDatos($data_body);
	}
//----------------------------------------------------------------------------------------------
	public function UpdateClienteForVendedor($maxPage,$IDVend,$IDCli)
	{
		$pages = $maxPage;
		$page = 1;
		try{			
			$logarray = array();
			do {				
				//$data = array('page'=> $page,);					
				$data=$IDCli;
				$result_nameDirectory = $this->GetClientsOnly($data); //TRAE CLIENTES CON ID ANTERIOR del ID 
				//DE VENDEDOR ESPECIFICADO EN LOS 8 PARAMETROS DE LA CONDICION WEBSERVICES
		//$fp =fopen('resultadoJason.txt', 'w');fwrite($fp, print_r("cdc", TRUE));fclose($fp);
				if($result_nameDirectory != NULL){
					if($result_nameDirectory->TableInfo != NULL){
					foreach ($result_nameDirectory->TableInfo as $item) {

						$logUser = array('IDCli' => strval($item->IDCli), );
						$pagePolicy = 1;
						$pagesPolicy = 0;
						$tmpBestSalesMan = array();												
						do{
							
							$data_policy = array('idCli'=> $item->IDCli, 'page' => $pagePolicy);	
							$this->logger->debug("Id de cliente a procesar y pagina: ", $data_policy);
							$policy_result = $this->GetPolicy_forClient($data_policy);	
 
							if($policy_result->TableInfo != NULL)
							{
								
								foreach ($policy_result->TableInfo as $value) {

									if(array_key_exists(strval($value->IDVend), $tmpBestSalesMan)){
									
										$tmpBestSalesMan[strval($value->IDVend)] = $tmpBestSalesMan[strval($value->IDVend)] + 1;										
									}else{
										$tmpBestSalesMan[strval($value->IDVend)] = 1;
									}
									
									
								}
								// var_dump($tmpBestSalesMan);
								$pagesPolicy = $policy_result->TableControl->Pages;

									
							}

							$pagePolicy++;

						}while($pagePolicy < $pagesPolicy);
						
						$this->logger->debug("array temporal del mejor vendedor: ", $tmpBestSalesMan );
						
						if(count($tmpBestSalesMan) > 0){
							
							$maxValue = max(array_values($tmpBestSalesMan));
							$key = array_search($maxValue, $tmpBestSalesMan);
							//$key=1;
							$this->SetVendedorID($item->IDCli,$IDVend);  //PONER EL VENDEDOR NUEVO SI TIEN POLIZA CAMBIA ACA
							
							$logUser['IdVend'] =$IDVend;

						}else{
							
							$this->SetVendedorID($item->IDCli,999990);	//CUANDO NO TIENE POLIZA PONER LE VALOR ASIGNADO						
							$logUser['IdVend'] ='999990';
							
						}					

						array_push($logarray, $logUser);	
					}
					// if(isset($result_nameDirectory->Info->Pages)){
					// 	$pages = $result_nameDirectory->Info->Pages;	
					// }								
					}
				}				

				$page++;
				$this->logger->debug("page : ", array($page));
				
			} while ( $page < $pages);			
							
		}catch(Exception $ex){

		}
		$this->logger->debug('Usuarios Procesados.', $logarray);
	}
//------------------------------------------------------------------------------------------
	public function UpdateContacto($data)
	{
		if (is_array($data)) 
		{             
			$data_body = array(
				"XML" => $data['datos'],
				"TProc"=>"Save_Data",
				"KeyCode"=>$data['KeyCode'],
                "IDRelation" => $data['IDRelation'],
                "TipoEntidad" => $data['TipoEntidad'],
				"KeyProcess"=>"DATA");
			$result = $this->ObtenerDatos($data_body);
			
		//**	return $result;
		}	
	}



	public function GetClients($data){
		
		$page = 1; 
		$itemforPage = 5;
		$role = "";
		$VendedorID = 0;
		$customConditionsAdd = "";
		$result = "";
		$busquedaCliente = "";
		
		if(is_array($data)){

			if(isset($data['page'])){
				$page = $data['page'];	
			}
			
			// var_dump($busquedaCliente);
			
			// $customConditionsAdd .= 'Regimen Fiscal;0;0;'. $Regimen .';'. $Regimen .';0;-1;CatClientes.TipoEnt';
			// $customConditionsAdd .= '!';
			$customConditionsAdd .= 'Nombre Completo;0;0;**;;0;-1;CatClientes.NombreCompleto ! FieldInt2;0;0;1;1;0;-1;CatClientes.FieldInt2 ';
			
	
			$data_body = array(
				"Page" => $page,
				"ItemForPage" => $itemforPage,
				"ConditionsAdd" => $customConditionsAdd,
				"InfoSort"=>"CatClientes.IDCli",
				"KeyCode"=>"HDS00002",
				"KeyProcess"=>"REPORT",
			);	
			$result = $this->ObtenerDatos($data_body);
		}		
		 
		return $result;
		
	}

	public function GetPoliciesOnly($data){
		
		$page = 1; 
		$itemforPage = 5;
		$role = "";
		$VendedorID = 0;
		$customConditionsAdd = "";
		$result = "";
		$busquedaCliente = "";
		
		if(is_array($data)){

			if(isset($data['page'])){
				$page = $data['page'];	
			}
			
			// var_dump($busquedaCliente);
			
			// $customConditionsAdd .= 'Regimen Fiscal;0;0;'. $Regimen .';'. $Regimen .';0;-1;CatClientes.TipoEnt';
			// $customConditionsAdd .= '!';
			$customConditionsAdd .= 'Nombre Completo;0;0;0;0;0;-1;DatDocumentos.Referencia4 ! Tipo Documento;0;0;7;7;DatDocumentos.TipoDocto';
			//Nombre Completo;7;0;;;0;-1;DatDocumentos.Referencia4
			$data_body = array(
				"Page" => $page,
				"ItemForPage" => $itemforPage,
				"ConditionsAdd" => $customConditionsAdd,
				"InfoSort"=>"DatDocumentos.IDDocto",
				"KeyCode"=>"HWS_DOCTOS",
				"KeyProcess"=>"REPORT",
			);	
			$result = $this->ObtenerDatos($data_body);
		}		
		 
		return $result;
		
	}

	public function GetClient_forPolicy($data){
		$page = 1; 
		$itemforPage = 1;
		$role = "";
		$VendedorID = 0;
		$customConditionsAdd = "";
		$result = "";
		$busquedaCliente = "";
		
		if(is_array($data)){
			
			$idCli 	= $data["idCli"];
			
			$sDate = "01/01/".date("Y");

			$customConditionsAdd .= 'Cliente Id;0;0;'. $idCli .';'. $idCli .';0;-1;DatDocumentos.IDCli ! Tipo Documento;0;0;1;1;DatDocumentos.TipoDocto ';
			// ! Id Cliente;5;0;'.$sDate.';0;DatDocumentos.FHasta
			
			$data_body = array(
				"Page" => $page,
				"ItemForPage" => $itemforPage,
				"ConditionsAdd" => $customConditionsAdd,
				"InfoSort"=>"CatClientes.IDCli",
				"KeyCode"=>"H03400_006",
				"KeyProcess"=>"REPORT",
			);	
			
			$result = $this->ObtenerDatos($data_body);
			return $result->TableInfo;
		}
	}



	private function SetCliente($IDCli)
	{
		
		$key_code = 'H02000';

		$xml_array = array('CatClientes' => array('IDCli'=> $IDCli,'FieldInt2'=>0));

		$data_body = array(
			"XML" => $xml_array,
			"TProc"=>"Save_Data",
			"KeyCode"=>"H02000",
			"KeyProcess"=>"DATA",
		);
		$result = $this->ObtenerDatos($data_body);
	}

	private function SetSRamoID($IDCont,$SRamo)
	{
		
		$xml_array = array('CatContactos' => array('IDCont'=> $IDCont,'URL'=>$SRamo));

		$data_body = array(
			"XML" => $xml_array,
			"TProc"=>"Save_Data",
			"KeyCode"=>"HDATACONTACT",
			"KeyProcess"=>"DATA",
		);
		$result = $this->ObtenerDatos($data_body);
	}

	private function UpdateDocumento($IDDocto)
	{
		
		$xml_array = array('DatDocumentos' => array('IDDocto'=> $IDDocto,'Referencia4'=>'0'));

		$data_body = array(
			"XML" => $xml_array,
			"TProc"=>"Save_Data",
			"KeyCode"=>"HWCAPTURE",
			"KeyProcess"=>"DATA",
		);
		$result = $this->ObtenerDatos($data_body);
	}

	

	public function UpdateClient_forPolicy(){
		$pages = 0;
		$page = 1;
		try{

			do {
				$data = array('page'=> $page);					
				$result_nameDirectory = $this->GetClients($data);
				if(isset($result_nameDirectory->TableInfo)){
					foreach ($result_nameDirectory->TableInfo as $item) {
						$data_policy = array('idCli'=> $item->IDCli);	
						$policy_result = $this->GetClient_forPolicy($data_policy);	
						if(count($policy_result) > 0)
						{
							$this->SetCliente($item->IDCli);
						}
					}
					if(isset($result_nameDirectory->Info->Pages)){
						$pages = $result_nameDirectory->Info->Pages;	
					}
					
				}

				$page++;
			} while ( $page < $pages);			
							
		}catch(Exception $ex){

		}
		//return $result_c;
	}

	public function GetClient_forName($data){
		
		$page = 1; 
		$itemforPage = 25;
		$role = "";
		$VendedorID = 0;
		$customConditionsAdd = "";
		$result = "";
		$isValid = false;
		$busquedaCliente = "";
		
		if(is_array($data)){
			
			$role 				= $data["role"];
			$VendedorID 		= $data["id"];
			$Regimen 			= $data["regimen"];
			$busquedaCliente 	= $data["busquedaCliente"];
			$namePoliza     	= $data["documento"];
			
			// var_dump($busquedaCliente);
			$customConditionsAdd .= $this->getConditionalVendedor();
			$customConditionsAdd .= 'Regimen Fiscal;0;0;'. $Regimen .';'. $Regimen .';0;-1;CatClientes.TipoEnt';
			$customConditionsAdd .= ' ! ';
			$customConditionsAdd .= 'Nombre Completo;0;0;'. $busquedaCliente .';'. $busquedaCliente .';0;-1;CatClientes.NombreCompleto';
			

			$data_body = array(
				"Page" => $page,
				"ItemForPage" => $itemforPage,
				"ConditionsAdd" => $customConditionsAdd,
				"InfoSort"=>"CatClientes.IDCli",
				"KeyCode"=>"HDS00002",
				"KeyProcess"=>"REPORT",
			);	
			
			$result = $this->ObtenerDatos($data_body)->TableInfo;
			if($result != ""){
				$page = 1;
				$pages = 0;
				$isValid = false;
				do{
					$pages = $result->TableControl->Pages;
					$data_poliza = array(
						"page" =>  ( empty($page)? 0 : $page ),
						"idCli" => $result->IDCli,
					);
					$page++;
					$rPolicy =  $this->GetClient_forPolicyValid($data_poliza);
					
					if($rPolicy != ""){
						foreach ($rPolicy['documentos'] as $value) {
							if($value->Documento == $namePoliza){
								$isValid = true;
								break;
							}
						}
					}

				}while($page < $pages && !$isValid );
			}

			//GetClient_forPolicy


			// $postDataXML = array ("postDataXML" => $this->GetXML($data_body)); $result = $this->ProcessCurl($postDataXML);
			// var_dump($result);
		}	

		 if($isValid)
			return $result;	
		else 	
			return NULL;
		
	}


	//---------------------------------------------------------------------------------------------------------------------
	public function GetClient_forNameClient($data){
		
		$page = 1; 
		$itemforPage = 25;
		$role = "";
		$VendedorID = 0;
		$customConditionsAdd = "";
		$result = "";
		$isValid = false;
		$busquedaCliente = "";
		
		if(is_array($data)){
			
			$role 				= $data["role"];
			$VendedorID 		= $data["id"];
			$Regimen 			= $data["regimen"];
			$busquedaCliente 	= $data["busquedaCliente"];
			$namePoliza     	= $data["documento"];
			
			// var_dump($busquedaCliente);
			$customConditionsAdd .= 'Regimen Fiscal;0;0;'. $Regimen .';'. $Regimen .';0;-1;CatClientes.TipoEnt';
			$customConditionsAdd .= ' ! ';
			$customConditionsAdd .= 'Nombre Completo;0;0;'. $busquedaCliente .';'. $busquedaCliente .';0;-1;CatClientes.NombreCompleto';
			

			$data_body = array(
				"Page" => $page,
				"ItemForPage" => $itemforPage,
				"ConditionsAdd" => $customConditionsAdd,
				"InfoSort"=>"CatClientes.IDCli",
				"KeyCode"=>"HDS00002",
				"KeyProcess"=>"REPORT",
			);	
			
			$result = $this->ObtenerDatos($data_body)->TableInfo;
			if($result != ""){
				$page = 1;
				$pages = 0;
				$isValid = false;
				do{
					$pages = $result->TableControl->Pages;
					$data_poliza = array(
						"page" =>  ( empty($page)? 0 : $page ),
						"idCli" => $result->IDCli,
					);
					$page++;
					$rPolicy =  $this->GetClient_forPolicyValid($data_poliza);
					
					if($rPolicy != ""){
						foreach ($rPolicy['documentos'] as $value) {
							if($value->Documento == $namePoliza){
								$isValid = true;
								break;
							}
						}
					}

				}while($page < $pages && !$isValid );
			}
		}	

		 if($isValid)
			return $result;	
		else 	
			return NULL;
		
	}

	public function GetContact_forIDCli($data){
		
		$page = 1; 
		$itemforPage = 25;
		$role = "";
		$VendedorID = 0;
		$customConditionsAdd = "";
		$result = "";
		$IDCli = "";
		
		if(is_array($data)){
			
			$IDCli 	= $data["IDCli"];
			if(isset($data['page'])){
				$page = $data['page'];	
			}
			
			$customConditionsAdd .= 'IDCli;0;0;'. $IDCli .';'. $IDCli .';0;-1;CatClientes.IDCli ';
			
			$data_body = array(
				"Page" => $page,
				"ItemForPage" => $itemforPage,
				"ConditionsAdd" => $customConditionsAdd,
				"InfoSort"=>"CatClientes.IDCli",
				"KeyCode"=>"HWS_CONTCLI",
				"KeyProcess"=>"REPORT",
			);	
			         
$this->CI->load->library('Ws_sicas');
		$result =$this->CI->ws_sicas->getDatosSICAS($data_body);	
			
			//$result = $this->ObtenerDatos($data_body);
			
			

			$pagination = array();
			if(isset($result->TableControl)){
				$pagination = array('Pages'=> $result->TableControl->Pages,'Page'=>$result->TableControl->Page);
			}

			$result_c = array(
					'contactos' =>$result->TableInfo,
					'paginacion' => $pagination );
		}		
		 
		return $result_c;	
	}


	public function GetClient_forID($IDCli){
		
		$page = 1; 
		$itemforPage = 25;
		$role = "";
		$VendedorID = 0;
		$customConditionsAdd = "";
		$result = "";
		$busquedaCliente = "";
		
		$customConditionsAdd .= 'Cliente ID;0;0;'.$IDCli.';'.$IDCli.';0;-1;CatClientes.IDCli ';
		
		$data_body = array(
			"Page" => $page,
			"ItemForPage" => $itemforPage,
			"ConditionsAdd" => $customConditionsAdd,
			"InfoSort"=>"CatClientes.IDCli",
			"KeyCode"=>"HDS00002",
			"KeyProcess"=>"REPORT",
		);	
				
		         
 $this->CI->load->library('Ws_sicas');
		$result =$this->CI->ws_sicas->getDatosSICAS($data_body);	
	//	$result = $this->ObtenerDatos($data_body);	

		$a_contacts = array();
		foreach ($result->TableInfo as $value) {


			$tm_data = array('IDCli' => $value->IDCli,);
			$oContact = $this->GetContact_forIDCli($tm_data);
			// $a_contact = new StdClass();

			// 	$a_contact->IdCont = $oContact['CatContactos.IDCont'];
			// 	$a_contact->Nombre=$oContact['CatContactos.Nombre'];
			// 	$a_contact->ApellidoP= $oContact['CatContactos.ApellidoP'];
			// 	$a_contact->ApellidoM= $oContact['CatContactos.ApellidoM'];
			// 	$a_contact->Alias=$oContact['CatContactos.Titulo'];
			// 	$a_contact->Puesto=$oContact['CatContactos.Puesto'];
			// 	$a_contact->Departamento=$oContact['CatContactos.Departamento'];
			// 	$a_contact->Email1= $oContact['CatContactos.EMail1'];
			// 	$a_contact->Telefono1 = $oContact['CatContactos.Telefono1'];
			// 	$a_contact->Nacionalidad = $oContact["CatContactos.Nacionalidad"];

			// array_push($a_contacts, $a_contact);
		}
		if(isset($oContact['contactos']) && isset($result->TableInfo)){
			$a_result = array('cliente' => $result->TableInfo,'contactos'=> $oContact['contactos']);
		}else{
			$a_result = array('cliente' => $result->TableInfo,'contactos'=> array());
		}

		// $a_result = array('cliente' => $result->TableInfo,'contactos'=> $oContact['contactos']);
		return $a_result;
	}
//-------------------------------------------------------------------------------------------------


		public function GetDataClienteProspecto($data){
		
		try{
			
			if(is_array($data)){

				$result_nameDirectory = $this->GetClient_forNameLike($data);

				$a_cliente = array();
				$a_prospecto = array();
				
				foreach($result_nameDirectory->TableInfo as $item){	

					/*if($item->FieldInt2 == 1){//$item->FieldInt2 = 1 : Cliente
						array_push($a_cliente, $item);
					}else{// $item->FieldInt2 = 0 : Prospecto
						array_push($a_prospecto, $item);
					}*/ //SE DIVIDE CLIENTES Y PROSPECTOS EN DOS ARREGLOS

					if($item->FieldInt2 == 1){//$item->FieldInt2 = 1 : Cliente
						array_push($a_cliente, $item);
					}else{// $item->FieldInt2 = 0 : Prospecto
						array_push($a_cliente, $item);
					}  //SE DIVIDE CLIENTES Y PROSPECTOS EN EL MISMO ARREGLO
					
				}
				$pagination = array();
				if(isset($result_nameDirectory->TableControl)){
					$pagination = array('Pages'=> $result_nameDirectory->TableControl->Pages,'Page'=>$result_nameDirectory->TableControl->Page);
				}	
				$result_c = array(
					'cliente' =>$a_cliente,
					'prospecto' =>$a_prospecto,
					'paginacion' =>  $pagination);
				
				return $result_c;
			}
			
		}catch(Exception $e){
			echo $e;
		}
	}
	//---------------------------------------------------------------------------------------------------------------------
	public function GetClient_forNameLike($data){
		
		$page = 1; 
		$itemforPage = 2500;
		$role = "";
		$VendedorID = 0;
		$customConditionsAdd = "";
		$result = "";
		$busquedaCliente = "";
		
		if(is_array($data)){
			
			// $role 				= $data["role"];
			// $VendedorID 		= $data["id"];
			// $Regimen 			= $data["regimen"];
			$busquedaCliente = $data["busquedaCliente"];
			if(isset($data['page'])){
				$page = $data['page'];	
			}
			
			// var_dump($busquedaCliente);
			
			// $customConditionsAdd .= 'Regimen Fiscal;0;0;'. $Regimen .';'. $Regimen .';0;-1;CatClientes.TipoEnt';
			// $customConditionsAdd .= '!';
			#$customConditionsAdd .= $this->getConditionalVendedor('cli');
			$customConditionsAdd .= 'Nombre Completo;0;0;*'. $busquedaCliente .'*;*'. $busquedaCliente .'*;CatClientes.NombreCompleto ';
			//$customConditionsAdd="Nombre completo;0;0;9267;9267;0;1;CatClientes.IDCli";
			
			$data_body = array(
				"Page" => $page,
				"ItemForPage" => $itemforPage,
				"ConditionsAdd" => $customConditionsAdd,
				"InfoSort"=>"CatClientes.NombreCompleto",
				"KeyCode"=>"HDS00002",
				"KeyProcess"=>"REPORT",
			);	
				
			// $postDataXML = array ("postDataXML" => $this->GetXML($data_body));
			// $result = $this->ProcessCurlRaw($postDataXML);
			// var_dump($data_body);
		$this->CI->load->library('Ws_sicas');
		$result =$this->CI->ws_sicas->getDatosSICAS($data_body);

			//$result = $this->ObtenerDatos($data_body);
		}		

		return $result;
	}



/*=================================LOCM===================================================*/
public function GetClient_VerPolzasActividad($data){

		$page = 1; 
		$itemforPage = 200;
		$role = "";
		$VendedorID = 0;
		$customConditionsAdd = "";
		$result = "";
		$busquedaCliente = "";
		
		if(is_array($data)){
			
			$idCli 	= $data["idCli"];
			
			$sDate = date("d/m/Y");

			if(isset($data['page'])){
				$page = $data['page'];	
			}
			if(isset($data['forItemAgregar'])){
				$itemforPage=$data['forItemAgregar'];
			}

			$customConditionsAdd .= 'Cliente Id;0;0;'. $idCli .';'. $idCli .';0;-1;DatDocumentos.IDCli ! Tipo Documento;0;0;1;1;DatDocumentos.TipoDocto ! Id Cliente;5;0;'.$sDate.';0;DatDocumentos.FHasta ! Cliente Id;0;0;0;0;0;-1;DatDocumentos.Status ';
			// 

			$data_body = array(
				"Page" => $page,
				"ItemForPage" => $itemforPage,
				"ConditionsAdd" => $customConditionsAdd,
				"InfoSort"=>"CatClientes.IDCli",
				"KeyCode"=>"HWS_DOCTOS",
				"KeyProcess"=>"REPORT",
			);	
      

			//$result = $this->ObtenerDatos($data_body);
			$this->CI->load->library('Ws_sicas');
		$result =$this->CI->ws_sicas->obtenerPolzasActividades($idCli,$sDate);
    		
			return $result;
		}

}
/*==============================================================================================*/

	public function GetClient_forPolicyActive($data,$filtro=0){
		$page = 1; 
		$itemforPage = 25;
		$role = "";
		$VendedorID = 0;
		$customConditionsAdd = "";
		$result = "";
		$busquedaCliente = "";
		
		if(is_array($data)){
			
			$idCli 	= $data["idCli"];
			
			$sDate = date("d/m/Y");

			if(isset($data['page'])){
				$page = $data['page'];	
			}
	
              /*
                   FILTROS 
                     IDCli=ES EL IDCLIENTE
                     TipoDocto= SI ES POLIZA O FIANZA
                     FHasta= FECHA HASTA DE LA POLIZA
                     Status= SI ESTA CANCELADA, RENOVADA
               */
              if($filtro==0){
			$customConditionsAdd .= 'Cliente Id;0;0;'. $idCli .';'. $idCli .';0;-1;DatDocumentos.IDCli ! Tipo Documento;0;0;1;1;DatDocumentos.TipoDocto ! Id Cliente;5;0;'.$sDate.';0;DatDocumentos.FHasta ! Cliente Id;0;0;0;0;0;-1;DatDocumentos.Status ';
		   }else{
           /*MANDAR -1 PARA NO TRAER CANCELADAS */
		     if($filtro!=-1)
			 {
			$customConditionsAdd .= 'Cliente Id;0;0;'. $idCli .';'. $idCli .';0;-1;DatDocumentos.IDCli';
			 }
			 else
			 {
				$customConditionsAdd .= 'Cliente Id;0;0;'. $idCli .';'. $idCli .';0;-1;DatDocumentos.IDCli ! Cliente Id;2;0;0|2|3|4|5|6|7|8|9;0;-1;DatDocumentos.Status ' ;

			 }
			
			


			// 
            }
			$data_body = array(
				"Page" => $page,
				"ItemForPage" => $itemforPage,
				"ConditionsAdd" => $customConditionsAdd,
				"InfoSort"=>"CatClientes.IDCli",
				"KeyCode"=>"HWS_DOCTOS",
				"KeyProcess"=>"REPORT",
			);	
         
$this->CI->load->library('Ws_sicas');
		$result =$this->CI->ws_sicas->getDatosSICAS($data_body);

			//$result = $this->ObtenerDatos($data_body);


			$pagination = array();
			if(isset($result->TableControl)){
				$pagination = array('Pages'=> $result->TableControl->Pages,'Page'=>$result->TableControl->Page);
			}
			
	


			
			$result_c = array(
					'documentos' =>$result->TableInfo,
					'paginacion' => $pagination );
		     

			return $result_c;
		}
	}

	public function GetClient_forPolicyValid($data){
		$page = 1; 
		$itemforPage = 25;
		$role = "";
		$VendedorID = 0;
		$customConditionsAdd = "";
		$result = "";
		$busquedaCliente = "";
		
		if(is_array($data)){
			
			$idCli 	= $data["idCli"];
			
			$sDate = date("d/m/Y");

			if(isset($data['page'])){
				$page = $data['page'];	
			}

			$customConditionsAdd .= 'Cliente Id;0;0;'. $idCli .';'. $idCli .';0;-1;DatDocumentos.IDCli ! Tipo Documento;0;0;1;1;DatDocumentos.TipoDocto ';
			// 

			$data_body = array(
				"Page" => $page,
				"ItemForPage" => $itemforPage,
				"ConditionsAdd" => $customConditionsAdd,
				"InfoSort"=>"CatClientes.IDCli",
				"KeyCode"=>"H03400_006",
				"KeyProcess"=>"REPORT",
			);	

			$result = $this->ObtenerDatos($data_body);

			$pagination = array();
			if(isset($result->TableControl)){
				$pagination = array('Pages'=> $result->TableControl->Pages,'Page'=>$result->TableControl->Page);
			}

			$result_c = array(
					'documentos' =>$result->TableInfo,
					'paginacion' => $pagination );

			return $result_c;
		}
	}
//----------------------------------------------------------------------
	public function GetCDDigital($data){

		$page = 1; 
		$itemforPage = 25;
		$role = "";
		$VendedorID = 0;
		$customConditionsAdd = "";
		$result = "";
		$busquedaCliente = "";		
		if(is_array($data)){
			
			$IDDocto 	= $data["IDDocto"];
			
			$data_body = array(
				"Page" => 1,
				"ItemForPage" => "",
				"ConditionsAdd" => "",
				"InfoSort"=>"",
				"KeyCode"=>"",
				"KeyProcess"=> "CDIGITAL",
				"TypeDestinoCDigital"=> "DOCUMENT",
				"IDValuePK"=> $IDDocto,
				"ActionCDigital"=> "GETFiles"
			);
			//$result = $this->ObtenerDatos($data_body);
			$this->CI->load->library('Ws_sicas');
		$result =$this->CI->ws_sicas->GetCDDigital($data);
			
		return $result;

			if(isset($result)){
				$result_c = array();
				if($result->Datos != ""){

					$Level = 0;
					// foreach ($result->Datos as $value) {
						// if($value->Tipo == 0)
						// {
							// $result_c[$value->Level] = array(
						        // "isFolder"=> true,
						        // "text"=> $value->NameShow,
								// );
						// }else{
							
						// }
						// $Level = $value->Leve;
					// }
					foreach ($result->Datos as $value) {										
						array_push($result_c,$value);
					}
					$test = $this->CrearArbol($result_c,0);
				}
				// return $result_c;			
					return $test;
			}else{
				return array('text'=> 'No cuenta con documentos');
			}
		}
	}
	//----------------------------------------------------------------------
	private function CrearArbol($Arbol, $Nodo = 0){
				
		$isFolder 	= false;
		$text		= "";
		$level		= "";
		$href		= "";
		$hreftarget	= "";
		$level_int 		= 0;		
		foreach ($Arbol as $key => $value) {
						
			if((string)$value->Level == 0){
				
				unset($Arbol[$key]);
				
				if($value->Tipo == 0){
					
					$isFolder = true;
					$text = (string)$value->NameShow;
					$level = (string)$value->Level;
												
				}else{
					
					$isFolder = false;
					$text = (string)$value->NameShow;
					$href = (string)$value->PathWWW;
					$hrefTarget = "_blank";
					$level = (string)$value->Level;
									
				}
			
					$recursive = $this->Hijos($Arbol);
						
					$return["isFolder"] = $isFolder;
					$return["text"] = $text;
					if(!empty($href))
						$return["href"] = $href;
					if(!empty($hrefTarget))
						$return["hrefTarget"] = $hrefTarget;
					if(!empty($level))
						$return["level"] = $level;

					if($recursive != NULL)
						$return["children"] = $recursive;
					
			}
		}
						
		return empty($return) ? null : $return;   
	}
	
	private function Hijos($Arbol){
		$isFolder 	= false;
		$text		= "";
		$level		= "";
		$href		= "";
		$hreftarget	= "";
		$level = 0;	

		$hijos = array();
		
		foreach ($Arbol as $key => $value) {
			
			unset($Arbol[$key]);
				
			if($value->Tipo == 0){
				
				// $isFolder = true;
				// $text = (string)$value->NameShow;
				// $level = (string)$value->Level;
				$return  = 
				array("isFolder" => true,
					  "text" => (string)$value->NameShow,
					  "level" => (string)$value->Level	
				);
											
			}else{
				
				$return  = 
				array("isFolder" => false,
					  "text" => (string)$value->NameShow,
					  "href" => (string)$value->PathWWW,
					  "hrefTarget" => "_blank",
					  "level" => (string)$value->Level	
				);
				
				// $isFolder = false;
				// $text = (string)$value->NameShow;
				// $href = (string)$value->PathWWW;
				// $hrefTarget = "_blank";
				// $level = (string)$value->Level;
								
			}
			
			// $hijos[] = array(
				// "isFolder" => $isFolder,
				// "text" => $text
			// );
			// $return["isFolder"] = $isFolder;
			// $return["text"] = $text;
			// if(!empty($href))
				// $return["href"] = $href;
			// if(!empty($hrefTarget))
				// $return["hrefTarget"] = $hrefTarget;
			// if(!empty($level))
				// $return["level"] = $level;			
			
			array_push($hijos,$return);
		}
		
		return empty($hijos) ? null : $hijos; 
	}
	
	public function GetReport($data){

		
		$page = 1; 
		$itemforPage = 25;
		if(is_array($data)){

			if(isset($data['page'])){
				$page = $data['page'];	
			}

			if(isset($data['ItemforPage']))
			{
				$itemforPage = $data['ItemforPage'];
			}
			$sFilter = "";
			$ifSalesMan = false;
			$ifPromoter = false;
			

			
			foreach ($data['filter'] as $key => $value) {
				switch ($key) {
					case 'name_client':
						if($data['FilterEnable'] == false){
							if(!empty($value))
								//$sFilter .="Nombre Completo;0;0;*".$value."*;".$value.";CatContactos.NombreCompleto ! ";
								/* SysJjHe*/
								switch($data['TypeReporte']){
									case "pro":
										$sFilter .= "";
									break;
									
									default:
										$sFilter .="Nombre Completo;0;0;*".$value."*;".$value.";CatContactos.NombreCompleto ! ";
									break;
								}
						}
						break;
					case 'branch':
						if($data['FilterEnable'] == false){
							if(!empty($value))
								//$sFilter .="Ramo;0;0;".$value.";".$value.";0;0;VCatSRamos.IDRamo ! ";
								/* SysJjHe */
								switch($data['TypeReporte']){
									case "pro":
										$sFilter .= "";
									break;
									
									default:
										$sFilter .="Ramo;0;0;".$value.";".$value.";0;0;VCatSRamos.IDRamo ! ";
									break;
								}
						}
						break;
					case 'sub_branch':
						if($data['FilterEnable'] == false){
							if(!empty($value))
								//$sFilter .="Sub Ramo;0;0;*".$value."*;".$value."; VDatDocumentos.IDSRamo ! ";
								/* SysJjHe */
								switch($data['TypeReporte']){
									case "pro":
										$sFilter .= "";
									break;
									
									default:
										$sFilter .="Sub Ramo;0;0;*".$value."*;".$value."; VDatDocumentos.IDSRamo ! ";
									break;
								}
						}
						break;
					case 'insurance':
						if($data['FilterEnable'] == false){
							if(!empty($value))
								//$sFilter .="Aseguradora;0;0;*".$value."*;".$value.";CatAgentes.AgenteNombre ! ";
								/* SysJjHe */
								switch($data['TypeReporte']){
									case "pro":
										$sFilter .= "";
									break;
									
									default:
										$sFilter .="Aseguradora;0;0;*".$value."*;".$value.";CatAgentes.AgenteNombre ! ";
									break;
								}
						}
					break;
					case 'vigencia':
						if($data['FilterEnable'] == false){
							if(!empty($value)){
								/*
								if($data['TypeReporte'] == 'pro'){
									$sFilter .="Desde|Hasta;3;0;".$value.";".$value.";0;-1;DatDocumentos.FHasta ! ";
								}else if($data['TypeReporte'] == 'cobp' || $data['TypeReporte'] == 'cobc'){
									$sFilter .="Desde|Hasta;3;0;".$value.";".$value.";0;-1;VDatRecibos.FLimPago ! ";
									
								}if($data['TypeReporte'] == 'cobe'){
									$sFilter .="Desde|Hasta;3;0;".$value.";".$value.";0;-1;VDatRecibos.FStatus ! ";
								}
								*/
								/* SysJjHe */
								switch($data['TypeReporte']){
									case "pro":
										$sFilter .="Desde|Hasta;3;0;".$value.";".$value.";0;-1;DatDocumentos.FDesde ! ";
									break;
									
									case "cobp":
									case "cobc":
									case "cobe": //->
										$sFilter .="Desde|Hasta;3;0;".$value.";".$value.";0;-1;VDatRecibos.FLimPago ! ";
									//->	$sFilter .="Desde|Hasta;3;0;".$value.";".$value.";0;-1;VDatRecibos.FStatus ! ";
									break;
									
									default:
										$sFilter .="";
									break;
								}
							}
						}
					break;
					case 'policy':
						if($data['FilterEnable'] == false){
							if(!empty($value))
								//$sFilter .="Poliza;0;0;".$value.";".$value.";DatDocumentos.Documento ! ";
								/* SysJjHe */
								switch($data['TypeReporte']){
									/*
									case "pro":
										//$sFilter .= "";
										$sFilter .="Poliza;0;0;".$value.";".$value.";DatDocumentos.Documento ! ";
									break;
									*/
									
									default:
										$sFilter .="Poliza;0;0;".$value.";".$value.";DatDocumentos.Documento ! ";
									break;
								}
						}
					break;
					case 'status':
						if($data['FilterEnable'] == false){
							if(!empty($value)){
								
								if($value == "2"){
									$sDate = date("d/m/Y");
									$date1 = str_replace('-', '/', $sDate);
									$tomorrow = date('d/m/Y',strtotime($date1 . "-1 days"));
									$sFilter .=" Vigencia;4;0;".$tomorrow.";".$tomorrow.";DatDocumentos.FHasta ! ";
								}
								else{
									
									$sDate = date("d/m/Y");
									$sFilter .=" Vigencia;5;0;".$sDate.";".$sDate.";DatDocumentos.FHasta ! ";
								}
							}
						}
					break;
					case 'salesman':
						if(!empty($value)){

							if($data['TypeReporte'] == 'cli'){
								$sFilter.="VendedorID;0;0;".$value.";".$value.";CatClientes.FieldInt1 ! ";
							}else{
								$sFilter .="Vendedor;0;0;".$value.";".$value.";CatVendedores.IdVend ! ";
							}
							$ifSalesMan = true;
						}
					break;
					case 'group':
						if($data['FilterEnable'] == false){
							if(!empty($value))
								//$sFilter .="Grupo;0;0;*".$value."*;".$value.";VDatDocumentos.IDGrupo ! ";
								/* SysJjHe */
								switch($data['TypeReporte']){
									case "pro":
										$sFilter .= "";
									break;
									
									default:
										$sFilter .="Grupo;0;0;*".$value."*;".$value.";VDatDocumentos.IDGrupo ! ";
									break;
								}
						}
					break;
					case 'sub_group':
						if($data['FilterEnable'] == false){
							if(!empty($value))
								//$sFilter .="Sub Grupo;0;0;*".$value."*;".$value.";VDatDocumentos.IDSGrupo ! ";
								/* SysJjHe */
								switch($data['TypeReporte']){
									case "pro":
										$sFilter .= "";
									break;
									
									default:
										$sFilter .="Sub Grupo;0;0;*".$value."*;".$value.";VDatDocumentos.IDSGrupo ! ";
									break;
								}
						}
					break;
					case 'promoter':
						if(!empty($value)){
							if(!$ifSalesMan){
								$aVendedores = $this->CI->role->getVendedores($value,$value);
								$value = implode('|',$aVendedores);
								// if($data['TypeReporte'] == 'cli'){
								// 	$sFilter.="VendedorID;2;0;".$value.";".$value.";CatClientes.FieldInt1 ! ";
								// }else{
									$sFilter .="Vendedor;2;0;".$value.";".$value.";VCatVendedores.IdVendNS ! ";
								// }
								$ifPromoter = true;
							}
						}
					break;
				}
				
			}

			$sKey_Code ="";
			$sInfoSort = "";
			switch ($data['TypeReporte']) {
				case'ren':
					$sDate = "";
					if(!empty($data['Month'])){

						$datos = explode('_',$data['Month']);
						if($datos[0] == "11")
							{
								$datos[0] = "-1";
								$datos[1] = ((int)$datos[1])+1;
							}
						$sDate = '01-'.sprintf("%02d",((int)$datos[0])+1).'-20'.$datos[1];
						$fecha = new DateTime($sDate);
						$fecha->modify('first day of this month');
						$fechaInicio = $fecha->format('d/m/Y');
						$fecha->modify('last day of this month');
						$fechaFin = $fecha->format('d/m/Y');	
						$sFilter .="Desde|Hasta;3;0;".$fechaInicio."|".$fechaFin.";".$fechaInicio."|".$fechaFin.";0;-1;DatDocumentos.FHasta ! ";
					}else{
						$fecha = new DateTime();
						$fecha->modify('first day of this month');
						$fechaInicio = $fecha->format('d/m/Y');
						$fecha->modify('last day of this month next year');
						$fechaFin = $fecha->format('d/m/Y');	
						$sFilter .="Desde|Hasta;3;0;".$fechaInicio."|".$fechaFin.";".$fechaInicio."|".$fechaFin.";0;-1;DatDocumentos.FHasta ! ";
						//$sFilter .="Desde|Hasta;3;0;".$fechaInicio .";".$fechaInicio .";0;-1;DatDocumentos.FHasta ! ";	
						//$sFilter .="Desde|Hasta;3;0;".$value.";".$value.";0;-1;VDatRecibos.FLimPago ! ";
					}


					$sFilter .= "Documento;0;0;1;1;DatDocumentos.TipoDocto ! ";
					$sKey_Code = 'HWS_DOCTOS';
					$sInfoSort = $data['Sort'];
					
				break;
				case 'pro':
					$sFilter .= "Documento;0;0;1;1;DatDocumentos.TipoDocto ! ";
					$sKey_Code = 'HWS_DOCTOS';
					$sInfoSort = $data['Sort'];
					
					break;
				case 'cobp':
					$sFilter .= "Documento;0;0;1;1;DatDocumentos.TipoDocto ! Status;0;0;0;0;VDatRecibos.Status ! ";
					$sKey_Code = 'H03430_003';
					$sInfoSort = $data['Sort'];
					
					break;
				case 'cobe':
					$sFilter .= "Documento;0;0;1;1;DatDocumentos.TipoDocto !  Status;0;0;3;3;VDatRecibos.Status ! ";
					$sKey_Code = 'H03430_003';
					$sInfoSort = $data['Sort'];
					
					break;
				case 'cobc':
					$sFilter .= "Documento;0;0;1;1;DatDocumentos.TipoDocto ! Status;0;0;1;1;VDatRecibos.Status ! ";
					$sKey_Code = 'H03430_003';
					$sInfoSort = $data['Sort'];
					
					break;
				case 'cli':
					$sKey_Code = 'HDS00002';
					$sInfoSort = $data['Sort'];
					
					break;
			}
			if(!$ifSalesMan && !$ifPromoter){
				$sFilter.= $this->getConditionalVendedor($data['TypeReporte']);
			}

			$sFilter .= $data['ExtraFilter'];
			$sFilter = substr($sFilter, 0, -2);		
			$data_body = array(
				"Page" => $page,
				"ItemForPage" => $itemforPage,
				"ConditionsAdd" => $sFilter,
				"InfoSort"=>$sInfoSort,
				"KeyCode"=>$sKey_Code,
				"KeyProcess"=>"REPORT",
			);	

			// var_dump($data_body);
			
			$result = $this->ObtenerDatos($data_body);
			// var_dump($result);

			$pagination = array();
			if(isset($result->TableControl)){
				$pagination = array(
					'Pages'=> ($result != NULL) ? $result->TableControl->Pages : '0',
					'Page'=>($result != NULL) ? $result->TableControl->Page:'0',
					'MaxRecords'=>($result != NULL) ? $result->TableControl->MaxRecords:'0');
			}

			$result_c = array(
					'reporte' =>($result != NULL) ? $result->TableInfo: NULL,
					'paginacion' => $pagination );
			
			//var_dump($result);

			return $result_c;
		}
	}

	public function GetReportJob($data){

		
		$page = 1; 
		$itemforPage = 25;
		if(is_array($data)){

			if(isset($data['page'])){
				$page = $data['page'];	
			}

			if(isset($data['ItemforPage']))
			{
				$itemforPage = $data['ItemforPage'];
			}
			$sFilter = "";
			$ifSalesMan = false;
			$ifPromoter = false;
			

			
			foreach ($data['filter'] as $key => $value) {
				switch ($key) {
					case 'name_client':
						if($data['FilterEnable'] == false){
							if(!empty($value))
								$sFilter .="Nombre Completo;0;0;*".$value."*;".$value.";CatContactos.NombreCompleto ! ";
						}
						break;
					case 'branch':
						if($data['FilterEnable'] == false){
							if(!empty($value))
								$sFilter .="Ramo;0;0;".$value.";".$value.";0;0;VCatSRamos.IDRamo ! ";
						}
						break;
					case 'sub_branch':
						if($data['FilterEnable'] == false){
							if(!empty($value))
								$sFilter .="Sub Ramo;0;0;*".$value."*;".$value."; VDatDocumentos.IDSRamo ! ";
						}
						break;
					case 'insurance':
						if($data['FilterEnable'] == false){
							if(!empty($value))
								$sFilter .="Aseguradora;0;0;*".$value."*;".$value.";CatAgentes.AgenteNombre ! ";
						}
					break;
					case 'vigencia':
						if($data['FilterEnable'] == false){
							if(!empty($value)){
								if($data['TypeReporte'] == 'pro'){
									$sFilter .="Desde|Hasta;3;0;".$value.";".$value.";0;-1;DatDocumentos.FHasta ! ";
								}else if($data['TypeReporte'] == 'cobp' || $data['TypeReporte'] == 'cobc'){
									$sFilter .="Desde|Hasta;3;0;".$value.";".$value.";0;-1;VDatRecibos.FLimPago ! ";
									
								}if($data['TypeReporte'] == 'cobe'){
									$sFilter .="Desde|Hasta;3;0;".$value.";".$value.";0;-1;VDatRecibos.FStatus ! ";
								}
							}
						}
					break;
					case 'policy':
						if($data['FilterEnable'] == false){
							if(!empty($value))
								$sFilter .="Poliza;0;0;".$value.";".$value.";DatDocumentos.Documento ! ";
						}
					break;
					case 'status':
						if($data['FilterEnable'] == false){
							if(!empty($value)){
								
								if($value == "2"){
									$sDate = date("d/m/Y");
									$date1 = str_replace('-', '/', $sDate);
									$tomorrow = date('d/m/Y',strtotime($date1 . "-1 days"));
									$sFilter .=" Vigencia;4;0;".$tomorrow.";".$tomorrow.";DatDocumentos.FHasta ! ";
								}
								else{
									
									$sDate = date("d/m/Y");
									$sFilter .=" Vigencia;5;0;".$sDate.";".$sDate.";DatDocumentos.FHasta ! ";
								}
							}
						}
					break;
					case 'salesman':
						if(!empty($value)){

							if($data['TypeReporte'] == 'cli'){
								$sFilter.="VendedorID;0;0;".$value.";".$value.";CatClientes.FieldInt1 ! ";
							}else{
								$sFilter .="Vendedor;0;0;".$value.";".$value.";CatVendedores.IdVend ! ";
							}
							$ifSalesMan = true;
						}
					break;
					case 'group':
						if($data['FilterEnable'] == false){
							if(!empty($value))
								$sFilter .="Grupo;0;0;*".$value."*;".$value.";DatDocumentos.Grupo ! ";
						}
					break;
					case 'sub_group':
						if($data['FilterEnable'] == false){
							if(!empty($value))
								$sFilter .="Sub Grupo;0;0;*".$value."*;".$value.";DatDocumentos.SubGrupo ! ";
						}
					break;
					case 'promoter':
						if(!empty($value)){
							if(!$ifSalesMan){
								$aVendedores = $this->CI->role->getVendedores($value,$value);
								$value = implode('|',$aVendedores);
								if($data['TypeReporte'] == 'cli'){
									$sFilter.="VendedorID;2;0;".$value.";".$value.";CatClientes.FieldInt1 ! ";
								}else{
									$sFilter .="Vendedor;2;0;".$value.";".$value.";CatVendedores.IdVend ! ";
								}
								$ifPromoter = true;
							}
						}
					break;
				}
				
			}

			$sKey_Code ="";
			$sInfoSort = "";
			switch ($data['TypeReporte']) {
				case'ren':
					$sDate = "";
					if(!empty($data['Month'])){

						$datos = explode('_',$data['Month']);
						if($datos[0] == "11")
							{
								$datos[0] = "-1";
								$datos[1] = ((int)$datos[1])+1;
							}
						$sDate = '01-'.sprintf("%02d",((int)$datos[0])+1).'-20'.$datos[1];
						$fecha = new DateTime($sDate);
						$fecha->modify('first day of this month');
						$fechaInicio = $fecha->format('d/m/Y');
						$fecha->modify('last day of this month');
						$fechaFin = $fecha->format('d/m/Y');	
						$sFilter .="Desde|Hasta;3;0;".$fechaInicio."|".$fechaFin.";".$fechaInicio."|".$fechaFin.";0;-1;DatDocumentos.FHasta ! ";
					}else{
						$fecha = new DateTime();
						$fecha->modify('first day of this month');
						$fechaInicio = $fecha->format('d/m/Y');
						$fecha->modify('last day of this month next year');
						$fechaFin = $fecha->format('d/m/Y');	
						$sFilter .="Desde|Hasta;3;0;".$fechaInicio."|".$fechaFin.";".$fechaInicio."|".$fechaFin.";0;-1;DatDocumentos.FHasta ! ";	
					}


					$sFilter .= "Documento;0;0;1;1;DatDocumentos.TipoDocto ! ";
					$sKey_Code = 'HWS_DOCTOS';
					$sInfoSort = $data['Sort'];
					
				break;
				case 'pro':
					$sFilter .= "Documento;0;0;1;1;DatDocumentos.TipoDocto ! ";
					$sKey_Code = 'HWS_DOCTOS';
					$sInfoSort = $data['Sort'];
					
					break;
				case 'cobp':
					$sFilter .= "Documento;0;0;1;1;DatDocumentos.TipoDocto ! Status;0;0;0;0;VDatRecibos.Status ! ";
					$sKey_Code = 'H03430_003';
					$sInfoSort = $data['Sort'];
					
					break;
				case 'cobe':
					$sFilter .= "Documento;0;0;1;1;DatDocumentos.TipoDocto !  Status;0;0;3;3;VDatRecibos.Status ! ";
					$sKey_Code = 'H03430_003';
					$sInfoSort = $data['Sort'];
					
					break;
				case 'cobc':
					$sFilter .= "Documento;0;0;1;1;DatDocumentos.TipoDocto ! Status;0;0;1;1;VDatRecibos.Status ! ";
					$sKey_Code = 'H03430_003';
					$sInfoSort = $data['Sort'];
					
					break;
				case 'cli':
					$sKey_Code = 'HDS00002';
					$sInfoSort = $data['Sort'];
					
					break;
			}
			if(!$ifSalesMan && !$ifPromoter){
				$sFilter.= $data['salesmanIds'];
			}

			$sFilter .= $data['ExtraFilter'];
			$sFilter = substr($sFilter, 0, -2);		
			$data_body = array(
				"Page" => $page,
				"ItemForPage" => $itemforPage,
				"ConditionsAdd" => $sFilter,
				"InfoSort"=>$sInfoSort,
				"KeyCode"=>$sKey_Code,
				"KeyProcess"=>"REPORT",
			);	

			// var_dump($data_body);
			
			$result = $this->ObtenerDatos($data_body);
			// var_dump($result);

			$pagination = array();
			if(isset($result->TableControl)){
				$pagination = array(
					'Pages'=> ($result != NULL) ? $result->TableControl->Pages : '0',
					'Page'=>($result != NULL) ? $result->TableControl->Page:'0',
					'MaxRecords'=>($result != NULL) ? $result->TableControl->MaxRecords:'0');
			}

			$result_c = array(
					'reporte' =>($result != NULL) ? $result->TableInfo: NULL,
					'paginacion' => $pagination );
			
			//var_dump($result);

			return $result_c;
		}
	}

	public function GetPolicy_forID($IDDocto){
		$page = 1; 
		$itemforPage = 25;
		$role = "";
		$VendedorID = 0;
		$customConditionsAdd = "";
		$result = "";
		$busquedaCliente = "";
		
			$sDate = date("d/m/Y");

			if(isset($data['page'])){
				$page = $data['page'];	
			}

			$customConditionsAdd .= 'Documento;0;0;'. $IDDocto .';'. $IDDocto .';0;-1;DatDocumentos.IDDocto ';
			
			$data_body = array(
				"Page" => $page,
				"ItemForPage" => $itemforPage,
				"ConditionsAdd" => $customConditionsAdd,
				"InfoSort"=>"DatDocumentos.IDDocto",
				"KeyCode"=>"H03400_006",
				"KeyProcess"=>"REPORT",
			);
							
			$result = $this->ObtenerDatos($data_body);

			$pagination = array();
				if(isset($result->TableControl)){
					$pagination = array('Pages'=> $result->TableControl->Pages,'Page'=>$result->TableControl->Page);
				}	
			$result_c = array(
					'documentos' =>$result->TableInfo,
					'paginacion' => $pagination );

			return $result_c;
	}

	public function GetPolicy_forID_Docto($IDDocto){
		$page = 1; 
		$itemforPage = 25;
		$role = "";
		$VendedorID = 0;
		$customConditionsAdd = "";
		$result = "";
		$busquedaCliente = "";
		
			$sDate = date("d/m/Y");

			if(isset($data['page'])){
				$page = $data['page'];	
			}

			$xml_array = array('DatDocumentos' => array('IDDocto'=> $IDDocto));

			$data_body = array(
				"XML"=>$xml_array,
				"Page" => $page,
				"KeyCode"=>"HWS_DOCTOS",
				"KeyProcess"=>"DATA",
			);
			
			$result = $this->ObtenerDatos($data_body);


			// $a_contacts = array(); // $a_contact = new StdClass(); // if($result["Sucess"]){// 	$doc = $result["Values"]; // 	$a_contact = new StdClass(); // 	$a_contact->IDDocto = $doc['DatDocumentos.IDDocto']; // 	$a_contact->IDSRamo = $doc['DatDocumentos.IDSRamo']; // 	$a_contact->IDCli = $doc['DatDocumentos.IDCli']; // 	// $a_contact->IDCli = $doc['DatDocumentos.IDCli']; // }

			return $result->VDatDocumentos;			
	}

	public function GetPolicy_forDocto($Docto){
		$page = 1; 
		$itemforPage = 25;
 		$customConditionsAdd = "";
		$result = "";
		
		$customConditionsAdd .= 'Cliente Id;0;0;'. $Docto .';'. $Docto .';0;-1;DatDocumentos.Documento ';

		$data_body = array(
			"Page" => $page,
			"ItemForPage" => $itemforPage,
			"ConditionsAdd" => $customConditionsAdd,
			"InfoSort"=>"DatDocumentos.IDDocto",
			"KeyCode"=>"HWS_DOCTOS",
			"KeyProcess"=>"REPORT",
		);
			
		$result = $this->ObtenerDatos($data_body);

		return $result->TableInfo;			
	}

	public function GetClient_forCLUBCAP($Code){
		$page = 1; 
		$itemforPage = 25;
 		$customConditionsAdd = "";
		$result = "";
		
		$customConditionsAdd .= 'Cliente CLUBCAP;0;0;*'. $Code .'*;'. $Code .';0;0;CatClientes.Expediente ';

		$data_body = array(
			"Page" => $page,
			"ItemForPage" => $itemforPage,
			"ConditionsAdd" => $customConditionsAdd,
			"InfoSort"=>"CatClientes.IDCli",
			"KeyCode"=>"HWS_CLI",
			"KeyProcess"=>"REPORT",
		);
		$result = $this->ObtenerDatos($data_body);


		return $result->TableInfo;			
    }
    
    public function GetAddressClient($IDCli){
		$page = 1; 
		$itemforPage = 25;
 		$customConditionsAdd = "";
		$result = "";
		
		$customConditionsAdd .= 'Cliente Direccion;0;0;'. $IDCli .';'. $IDCli .';-1;-1;CatClientes.IDCli ';

		$data_body = array(
			"Page" => $page,
			"ItemForPage" => $itemforPage,
			"ConditionsAdd" => $customConditionsAdd,
			"InfoSort"=>"CatClientes.IDCli",
			"KeyCode"=>"HWS_DIRECCION",
			"KeyProcess"=>"REPORT",
		);

$this->CI->load->library('Ws_sicas');
		$result =$this->CI->ws_sicas->getDatosSICAS($data_body);
		//$result = $this->ObtenerDatos($data_body);
		return $result->TableInfo;	
    }
   



   function datosComisiones($wsdata){
			try {
				$this->init();
				//Default Values
				$this->oDataWS->TipoEntidad = '0';
				$this->oDataWS->TypeDestinoCDigital = 'CONTACT'; 
				$this->oDataWS->IDValuePK = '0'; 
				$this->oDataWS->ActionCDigital = 'GETFiles';
				$this->oDataWS->TypeFormat = 'XML';
				$this->oDataWS->TProc = 'Read_Data'; 
				$this->oDataWS->KeyProcess = 'REPORT';
				$this->oDataWS->KeyCode = '';
				$this->oDataWS->Page ='1';
				$this->oDataWS->ItemForPage = '1000000';
				$this->oDataWS->InfoSort = '';
				$this->oDataWS->IDRelation = '0';
				$this->oDataWS->ConditionsAdd = '';

				if(isset($wsdata['TipoEntidad']))
					$this->oDataWS->TipoEntidad = $wsdata['TipoEntidad']; 
				
				if(isset($wsdata['IDRelation']))
					$this->oDataWS->IDRelation = $wsdata['IDRelation']; 

				if(isset($wsdata['TypeDestinoCDigital']))
					$this->oDataWS->TypeDestinoCDigital = $wsdata['TypeDestinoCDigital']; 

				if(isset($wsdata['IDValuePK']))
					$this->oDataWS->IDValuePK = $wsdata['IDValuePK']; 

				if(isset($wsdata['ActionCDigital']))
					$this->oDataWS->ActionCDigital = $wsdata['ActionCDigital']; 

				if(isset($wsdata['Page']))
					$this->oDataWS->Page = $wsdata['Page']; 

				if(isset($wsdata['TProc']))
					$this->oDataWS->TProc = $wsdata['TProc']; 

				if(isset($wsdata['KeyProcess']))
					$this->oDataWS->KeyProcess = $wsdata['KeyProcess']; 

				if(isset($wsdata['KeyCode']))
					$this->oDataWS->KeyCode = $wsdata['KeyCode']; 

				if(isset($wsdata['ItemForPage']))
					$this->oDataWS->ItemForPage = $wsdata['ItemForPage']; 

				if(isset($wsdata['InfoSort']))
					$this->oDataWS->InfoSort = $wsdata['InfoSort']; 

				if(isset($wsdata['ConditionsAdd']))
					$this->oDataWS->ConditionsAdd = $wsdata['ConditionsAdd']; 

				$parameters = array('oDataWS' => $this->oDataWS, );

						  
						  $resutl = $this->soapC->ProcesarWS($parameters);
						     



				if (strpos($resutl->ProcesarWSResult, 'DENIED') !== false) {
				    return NULL;
				}
				$xml = new SimpleXMLElement($resutl->ProcesarWSResult);
				return $xml;
			}
			catch(Exception $e){
				
			}
    }


  //----------------------------------------------------------------------------
  	//Búsqueda por Documento
    public function SearchDoc($search,$type){ //filtro=0
		//$page = 1; 
		$itemforPage = 2500;
		$customConditionsAdd = "";
		$result = "";
		$data = $search;
		$sDate = date("d/m/Y");

		if ($type == 1) {
			$customConditionsAdd = 'Documento;0;0;*'. $data .'*;*'. $data .'*;DatDocumentos.Documento';
		}
		else if ($type == 2) {
			$customConditionsAdd = 'Grupo;0;0;*'. $data .'*;*'. $data .'*;DatDocumentos.Grupo';
		}
		else if ($type == 7) {
			$customConditionsAdd = 'Referencia1;0;0;*'. $data .'*;*'. $data .'*;DatDocumentos.Referencia1';
		}
		else if ($type == 8) {
			$customConditionsAdd = 'Referencia2;0;0;*'. $data .'*;*'. $data .'*;DatDocumentos.Referencia2';
		}
		else if ($type == 9) {
			$customConditionsAdd = 'Cliente Id;0;0;'. $data .';'. $data .';0;-1;DatDocumentos.IDCli';
		}
		else if ($type == 10) {
			$customConditionsAdd = 'IDDocto;0;0;'. $data .';'. $data .';0;-1;DatDocumentos.IDDocto';
		}
$vendedor=$this->CI->tank_auth->get_IDVend();
 if($vendedor>0){$customConditionsAdd.=' ! VendedorID;2;0;'.$vendedor.';'.$vendedor.';DatDocumentos.IDVend';}
		$data_body = array(
			//"Page" => $page,
			"ItemForPage" => $itemforPage,
			"ConditionsAdd" => $customConditionsAdd,
			"InfoSort"=>"CatClientes.IDCli",
			"KeyCode"=>"HWS_DOCTOS",
			"KeyProcess"=>"REPORT",
		);
         
		$this->CI->load->library('Ws_sicas');
		$result = $this->CI->ws_sicas->getDatosSICAS($data_body);

		// $pagination = array();
		// if(isset($result->TableControl)){
		// 	$pagination = array('Pages'=> $result->TableControl->Pages,'Page'=>$result->TableControl->Page);
		// }

		$result_d = array(
			'documentos' => $result->TableInfo
		);
		return $result_d;
	}

	//Búsqueda por Nombre
    public function SearchName($data,$type){
		//$page = 1; 
		$itemforPage = 2500;
		$customConditionsAdd = "";
		$result = "";
		$sDate = date("d/m/Y");

		if ($type == 3) {
			$customConditionsAdd = 'Nombre Completo;0;0;*'. $data .'*;*'. $data .'*;CatClientes.NombreCompleto';
		}
		else if ($type == 4) {
			$customConditionsAdd = 'Nombre Completo;0;0;'. $data .';'. $data .';0;-1;CatClientes.Grupo';
		}
		else if ($type == 10) {
			$customConditionsAdd = 'IDCli;0;0;'. $data .';'. $data .';0;-1;CatClientes.IDCli';
		}

$vendedor=$this->CI->tank_auth->get_IDVend();
 if($vendedor>0){$customConditionsAdd.=' ! VendedorID;2;0;'.$vendedor.';'.$vendedor.';CatClientes.IDVend';}

		$data_body = array(
			//"Page" => $page,
			"ItemForPage" => $itemforPage,
			"ConditionsAdd" => $customConditionsAdd,
			"InfoSort"=>"CatClientes.IDCli",
			"KeyCode"=>"HDS00002", //HWS_CLI | HWS_DIRECCION
			"KeyProcess"=>"REPORT",
		);
         
		$this->CI->load->library('Ws_sicas');
		$result = $this->CI->ws_sicas->getDatosSICAS($data_body);

		$result_d = array(
			'documentos' => $result->TableInfo
		);
		return $result_d;
	}

	//Búsqueda por Serie y Placa
	public function SearchSerieAndPlaca($data,$type){
		
		$itemforPage = 2500;
		$result = "";
		
		if ($type == 5) {
			$customConditionsAdd = 'Documento;0;0;*'.$data.'*;*'.$data.'*;VDatDoctoDetail.Serie';
		}
		else if ($type == 6) {
			$customConditionsAdd = 'Documento;0;0;*'.$data.'*;*'.$data.'*;VDatDoctoDetail.Placas';
		}
		else if ($type == 14) { //Desactivado
			$customConditionsAdd = 'IDDocto;0;0;'.$data.';'.$data.';0;-1;VDatDoctoDetail.IDDocto';
		}

$vendedor=$this->CI->tank_auth->get_IDVend();
 if($vendedor>0){$customConditionsAdd.=' ! VendedorID;2;0;'.$vendedor.';'.$vendedor.';DatDocumentos.IDVend';}

		$data_body = array(
			"ItemForPage" => $itemforPage,
			"ConditionsAdd" => $customConditionsAdd,
			"InfoSort"=>"VDatDocumentos.IDDocto",
			"KeyCode"=>"HWS_DDETAIL",
			"KeyProcess"=>"REPORT",
		);	
			         
		$this->CI->load->library('Ws_sicas');
		$result = $this->CI->ws_sicas->getDatosSICAS($data_body);	
		
		$result_c = array(
			'documentos' => $result->TableInfo
		);
		return $result_c;	
	}

	//Documento por IDDocto
	public function GetIDDocto($data,$type){
		
		$itemforPage = 2500;
		$result = "";
		
		if ($type == 1) {
		$customConditionsAdd = 'IDDocto;0;0;'. $data .';'. $data .';0;-1;DatDocumentos.IDDocto';
		}
		else if ($type == 2) {
			$customConditionsAdd = 'IDDocto;0;0;'. $data .';'. $data .';0;-1;DatDocumentos.IDCli';
		}
		
		$data_body = array(
			"ItemForPage" => $itemforPage,
			"ConditionsAdd" => $customConditionsAdd,
			"InfoSort"=>"DatDocumentos.IDDocto",
			"KeyCode"=>"H03400_006", //H03400 | H03400_005
			"KeyProcess"=>"REPORT",
		);	
			         
		$this->CI->load->library('Ws_sicas');
		$result = $this->CI->ws_sicas->getDatosSICAS($data_body);	

		$result_c = array(
			'documentos' => $result->TableInfo
		); 
		return $result_c;
	}

	//Documento en Fianzas
	public function GetFianzas($data){
		
		$itemforPage = 2500;
		$result = "";
		
		$customConditionsAdd = 'IDDocto;0;0;'. $data .';'. $data .'1;1;VDatDocumentos.IDDocto';

		$data_body = array(
			"ItemForPage" => $itemforPage,
			"ConditionsAdd" => $customConditionsAdd,
			"InfoSort"=>"VDatDocumentos.IDDocto",
			"KeyCode"=>"H03605_002", //H03605_003
			"KeyProcess"=>"REPORT",
		);	
			         
		$this->CI->load->library('Ws_sicas');
		$result = $this->CI->ws_sicas->getDatosSICAS($data_body);	

		$result_c = array(
			'doumentos' => $result->TableInfo
		);
		return $result_c;	
	}

	//Recibos
	public function GetRecibo($data){
		
		$itemforPage = 2500;
		$result = "";

		$customConditionsAdd = 'IDDocto;0;0;'. $data .';'. $data .';1;1;VDatDocumentos.IDDocto';

		$data_body = array(
			"ItemForPage" => $itemforPage,
			"ConditionsAdd" => $customConditionsAdd,
			"InfoSort"=>"VDatDocumentos.IDDocto",
			"KeyCode"=>"H03430_003", //H03430_001 Te da el IDPagoRec | H03430_003 Tiene datos menos que el H03430_001
			"KeyProcess"=>"REPORT",
		);	
			         
		$this->CI->load->library('Ws_sicas');
		$result = $this->CI->ws_sicas->getDatosSICAS($data_body);	

		$result_r = array(
			'recibos' => $result->TableInfo
		);
		return $result_r;
	}

	//Información de Recibos más completos
	public function GetInfoRecibo($data,$type){
		
		$itemforPage = 25;
		$result = "";
		
		if ($type == 1) {
		$customConditionsAdd = 'IDRecibo;0;0;'. $data .';'. $data .';1;1;VDatRecibos.IDRecibo';
		}
		else if ($type == 2) {
			$customConditionsAdd = 'IDRecibo;0;0;'. $data .';'. $data .';DatDocumentos.Documento';
		}
		else if ($type == 3) {
			$customConditionsAdd = 'IDRecibo;0;0;'. $data .';'. $data .';DatDocumentos.Endoso';
		}
		else if ($type == 4) {//Por fechas
			$fechaI = $data['fechaInicio'];
			$fechaF = $data['fechaFin'];
			$customConditionsAdd = 'Desde|Hasta;3;0;'.$fechaI.'|'.$fechaF.';0;-1;DatDocumentos.FDesde';
			//Desde|Hasta;3;0;01-02-2019|13-02-2019;0;-1;DatDocumentos.FDesde
		}
		else if ($type == 5) {
			$customConditionsAdd = 'IDDocto;0;0;'. $data .';'. $data .';VDatRecibos.IDDocto';
		}

$vendedor=$this->CI->tank_auth->get_IDVend();
 if($vendedor>0){$customConditionsAdd.=' ! VendedorID;2;0;'.$vendedor.';'.$vendedor.';DatDocumentos.IDVend';}

		$data_body = array(
			"ItemForPage" => $itemforPage,
			"ConditionsAdd" => $customConditionsAdd,
			"InfoSort"=>"VDatDocumentos.IDDocto",
			"KeyCode"=>"H03430_001",
			"KeyProcess"=>"REPORT",
		);	
			         
		$this->CI->load->library('Ws_sicas');
		$result = $this->CI->ws_sicas->getDatosSICAS($data_body);	

		$result_r = array(
			'recibo' => $result->TableInfo
		); 
		return $result_r;	
	}

	//Honorario de agentes
	public function GetHonorario($data){
		
		$itemforPage = 25;
		$result = "";
		
		$customConditionsAdd = 'IDDocto;0;0;'.$data.';'.$data.';0;VDatRecibos.IDRecibo';
		//$customConditionsAdd = 'IDDocto;0;0;'.$data.';'.$data.';0;VDatRecibos.IDRecibo'; 
		//Serie: 154727, IDDocto: 124089, IDPagoRec: 232352, IDRecibo: 294991, IDVE: 7 | FOLIO 12 19/03/2020
		//Poliza: 149080 IDDocto: 149080, IDRecibo: 366593, IDVend: 313, IDCli: 37778, IDFPago: 2, IDPagoRec: 276935

		$data_body = array(
			"ItemForPage" => $itemforPage,
			"ConditionsAdd" => $customConditionsAdd,
			"InfoSort"=>"DatHonRecibos.IDVE", //DatHonRecibos.Status_TXT | VDatDocumentos.IDDocto
			"KeyCode"=>"H02930_003", //H02930_003
			"KeyProcess"=>"REPORT",
		);	
			         
		$this->CI->load->library('Ws_sicas');
		$result = $this->CI->ws_sicas->getDatosSICAS($data_body);	

		$result_h = array(
			'honorario' => $result->TableInfo
		);
		return $result_h;
	}

	//Endosos
	public function GetEndosos($data,$type){
		
		$itemforPage = 2500;
		$result = "";
		if ($type == 1){
			$customConditionsAdd = 'IDDocto;0;0;'. $data .';'. $data .'1;1;VDatDocumentos.IDDocto';
		}
		else if ($type == 2) {
			$customConditionsAdd = 'Documento;0;0;'. $data .';'. $data .'1;1;DatDocumentos.Documento';
		}
		else if ($type == 3){
			$customConditionsAdd = 'Endoso;0;0;'. $data .';'. $data .'1;1;VDatDocumentos.Endoso';
		}

		$data_body = array(
			"ItemForPage" => $itemforPage,
			"ConditionsAdd" => $customConditionsAdd,
			"InfoSort"=>"VDatDocumentos.IDDocto",
			"KeyCode"=>"H03605_003", //H03605_003 (Endoso)
			"KeyProcess"=>"REPORT",
		);	
			         
		$this->CI->load->library('Ws_sicas');
		$result = $this->CI->ws_sicas->getDatosSICAS($data_body);	

		$result_c = array(
			'endosos' => $result->TableInfo
		);
		return $result_c;	
	}

	//Las demás búsquedas (desactivado) -------------------------------------
	
	public function GetContacto_forContacto($data){
		
		$itemforPage = 25;
		$result = "";
		
		$customConditionsAdd = 'IDCli;0;0;'.$data.';'.$data.';0;-1;CatClientes.IDCli';

		$data_body = array(
			"ItemForPage" => $itemforPage,
			"ConditionsAdd" => $customConditionsAdd,
			"InfoSort"=>"CatClientes.IDCli",
			"KeyCode"=>"HWS_CLI", //HWS_DIRECCION HWS_CONTCLI | HWS_CONTCLI | HWS_CLI proporciona menos info que HDS00002
			"KeyProcess"=>"REPORT",
		);
			         
		$this->CI->load->library('Ws_sicas');
		$result = $this->CI->ws_sicas->getDatosSICAS($data_body);	

		// $result_c = array(
		// 	'documentos' => $result->TableInfo
		// );	 
		return $result;	
	}

	public function GetAgente($data){ //Agente por IDVend
		
		$itemforPage = 25;
		$result = "";
		
		$customConditionsAdd = 'IDVend;0;0;*'. $data .'*;*'. $data .'*;IDvend';

		$data_body = array(
			"ItemForPage" => $itemforPage,
			"ConditionsAdd" => $customConditionsAdd,
			"InfoSort"=>"CatVendedores.IDVend",
			"KeyCode"=>"HWS_VEND",
			"KeyProcess"=>"REPORT",
		);	
			         
		$this->CI->load->library('Ws_sicas');
		$result = $this->CI->ws_sicas->getDatosSICAS($data_body);	

		/*$result_c = array(
			'fianzas' => $result->TableInfo
		); */
		return $result;	
	}

}
?>