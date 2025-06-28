<?php 
// New Version Librari SysJjHe
if(!defined('BASEPATH')) exit('No direct script access allowed');

class webservice_sicasdre{
	
	var $uri_service = "https://www.sicasonline.info/SOnlineWS/WS_SICASOnline.asmx?WSDL";//"https://www.sicasonline.info:448/SOnlineWS/WS_SICASOnline.asmx?WSDL";
	var $soapC;
	var $oDataWS;
	var $key = "%SOnlineBOGO2001-2015WS#";
	var $ivPass = "GAP#aCap";
	var $CI;
	var $logger;			
				
	function __construct(){
		$this->CI=& get_instance();
		try {
			$this->CI =& get_instance();
			$this->soapC = new SoapClient($this->uri_service, array('trace' => 1));	
			set_time_limit(900);
		} catch (Exception $e) {
			//**
		}
	}
		
	function init(){
		$this->oDataWS = new \stdClass;
		$this->oDataWS->Credentials = new \stdClass;
		$this->oDataWS->Credentials->UserName = 'GAP#aCap%2015';
		$this->oDataWS->Credentials->Password = 'CAP15gap20Ag';
		$this->oDataWS->Credentials->CodeAuth = 'vsDMquPhx68SZrY8wGcxEh2bk1XiPlR0EZkBVLmax3A4Mab7sDeeyodY3BjDuyB';

		$this->oDataWS->CredentialsUserSICAS = new \stdClass;
		if(
			$this->CI->tank_auth->get_UserSICAS() == "" 
			&& 
			$this->oDataWS->CredentialsUserSICAS->Password = $this->CI->tank_auth->get_PassSICAS() == ""
		){
			$this->oDataWS->CredentialsUserSICAS->UserName = "desarrollo@agentecapital.com";
			$this->oDataWS->CredentialsUserSICAS->Password = "hola00";
		}else{
			$this->oDataWS->CredentialsUserSICAS->UserName = $this->CI->tank_auth->get_UserSICAS();
			$this->oDataWS->CredentialsUserSICAS->Password = $this->CI->tank_auth->get_PassSICAS();
		}
	}

	function array_to_xml($array, &$xml_user_info){
		foreach($array as $key => $value){
			if(is_array($value)){
				if(!is_numeric($key)){
					$subnode = $xml_user_info->addChild("$key");
	                $this->array_to_xml($value, $subnode);
	            }else{
	                $subnode = $xml_user_info->addChild("item$key");
	                $this->array_to_xml($value, $subnode);
	            }
	        }else{
				$xml_user_info->addChild("$key",htmlspecialchars("$value"));
	        }
		}
	}/*! array_to_xml */
	
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
	
	function ObtenerDatos($wsdata){
	## private
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
					
					// echo $xmlData;
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
	}/*! ObtenerDatos */
/*
	private function SetCliente($IDCli){
		
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
	
	private function SetVendedorID($IDCli,$IdVend){
		
		$xml_array = array('CatClientes' => array('IDCli'=> $IDCli,'FieldText1'=>$IdVend));

		$data_body = array(
			"XML" => $xml_array,
			"TProc"=>"Save_Data",
			"KeyCode"=>"H02000",
			"KeyProcess"=>"DATA",
		);
		$result = $this->ObtenerDatos($data_body);
	}

	private function SetSRamoID($IDCont,$SRamo){
		
		$xml_array = array('CatContactos' => array('IDCont'=> $IDCont,'URL'=>$SRamo));

		$data_body = array(
			"XML" => $xml_array,
			"TProc"=>"Save_Data",
			"KeyCode"=>"HDATACONTACT",
			"KeyProcess"=>"DATA",
		);
		$result = $this->ObtenerDatos($data_body);
	}

	private function UpdateDocumento($IDDocto){
		
		$xml_array = array('DatDocumentos' => array('IDDocto'=> $IDDocto,'Referencia4'=>'0'));

		$data_body = array(
			"XML" => $xml_array,
			"TProc"=>"Save_Data",
			"KeyCode"=>"HWCAPTURE",
			"KeyProcess"=>"DATA",
		);
		$result = $this->ObtenerDatos($data_body);
	}
*/
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
		
###################################################################################

}
?>