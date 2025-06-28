<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class serviciowebsicas
{
var $soapC; var $oDataWS;
var $ivPass = "GAP#aCap";	var $key = "%SOnlineBOGO2001-2015WS#";
var $CI                 ;   var $logger;
var $uri_service = "http://localhost/V3API/sicas/addData";//"https://www.sicasonline.info:448/SOnlineWS/WS_SICASOnline.asmx?WSDL";
function __construct()
{
// $this->CI=& get_instance();
 try 
 {
  $this->CI =& get_instance();

/*$options = array(
		'uri'=>'http://schemas.xmlsoap.org/soap/envelope/',
		'style'=>SOAP_RPC,
		'use'=>SOAP_ENCODED,
		'soap_version'=>SOAP_1_1,
		'cache_wsdl'=>WSDL_CACHE_NONE,
		'connection_timeout'=>15,
		'trace'=>true,
		'encoding'=>'UTF-8',
		'exceptions'=>true,
	);	*/
$options = array(			
		'trace'=>true,
		
	);	

$wsdl ="https://www.sicasonline.info:448/SOnlineWS/WS_SICASOnline.asmx?WSDL"; //"http://localhost/V3API/sicas/addData";//'https://www.sicasonline.info:448/SOnlineWS/WS_SICASOnline.asmx?WSDL';

	//$soap = new SoapClient($wsdl, $options);

     //$arreglo['oDataWS'][0]='Credentials';

     $arreglo['oDataWS']['Credentials']['UserName']="GAP#aCap%2015";
     $arreglo['oDataWS']['Credentials']['Password']="CAP15gap20Ag";
     $arreglo['oDataWS']['Credentials']['CodeAuth']="vsDMquPhx68SZrY8wGcxEh2bk1XiPlR0EZkBVLmax3A4Mab7sDeeyodY3BjDuyB"; 
         // $arreglo['oDataWS'][1]='CredentialsUserSICAS';    
     $arreglo['oDataWS']['CredentialsUserSICAS']['UserName']="SISTEMAS@ASESORESCAPITAL.COM";
     $arreglo['oDataWS']['CredentialsUserSICAS']['Password']="MESCAMILLA";
     $arreglo['oDataWS']['TipoEntidad']  =0;   
     $arreglo['oDataWS']['TypeDestinoCDigital']  ='CONTACT';  
     $arreglo['oDataWS']['IDValuePK']  =0;  
     $arreglo['oDataWS']['ActionCDigital']  ='GETFiles';  
     $arreglo['oDataWS']['TypeFormat']  ='JSON';  
     //$arreglo['oDataWS']['TProc']  ='Read_Data';  
     $arreglo['oDataWS']['TProc']  ='Save_Data';
     //$arreglo['oDataWS']['KeyProcess']  ='REPORT';  
     $arreglo['oDataWS']['KeyProcess']  ='DATA';  
     $arreglo['oDataWS']['KeyCode']  ='HWS_VEND';  
     $arreglo['oDataWS']['Page']  =1;  
     $arreglo['oDataWS']['ItemForPage']  =500;  
    // $arreglo['oDataWS']['InfoSort']  ='CatVendedores.IDVend';  
     $arreglo['oDataWS']['IDRelation']  =0;  
     //$arreglo['oDataWS']['ConditionsAdd']  ='Devueltos;0;0;14;14;IDVend';  



     	/*$wsdata=array("IDVend"=>14,"Status"=>1 );
	$xmlS = new SimpleXMLElement('<InfoData/>');
	  $this->array_to_xml($wsdata, $xmlS);	
	  $xmlData = $xmlS->asXML();	*/

	       	//$wsdata=array("IDVend"=>14,"Status"=>1 );
	 
	       	$wsdata["CatVendedores"]["IDVend"]="14";
	       	$wsdata["CatVendedores"]["Status"]="0";
	$xmlS = new SimpleXMLElement('<InfoData/>');
	  $this->array_to_xml($wsdata, $xmlS);	
	  $xmlData = $xmlS->asXML();

     $newphrase = str_replace('<?xml version="1.0"?>',"",$xmlData);
/*
  			  		$fp = fopen('resultadoJason.txt', 'w');	
	      fwrite($fp, print_r( $newphrase, TRUE));        
	      fclose($fp);*/

	  $TextEncript = $this->encripta($this->key, $this->ivPass, $newphrase);
	  


//$encriptado="<InfoData><CatVendedores><IDVend>14</IDVend><Status>0</Status></CatVendedores></InfoData>";
         
//$TextEncript = $this->encripta($this->key, $this->ivPass, $encriptado);
$arreglo['oDataWS']['DataXML']  =$TextEncript;

     //$arreglo['oDataWS']['ConditionsAdd']  ='Devueltos;5;1;355;355;IDVend';  
     //$arreglo['oDataWS']['TipoEntidad']  =0;  
  //	$soap->__getFunctions();

/*$a='<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:tem="http://tempuri.org/"> <soap:Header/> <soap:Body>
Grupo BOGO Asesores y Servicios TI, SCDR SICAS, SICAS Online<ProcesarWS> <oDataWS> <Credentials> <CodeAuth>vsDMquPhx68SZrY8wGcxEh2bk1XiPlR0EZkBVLmax3A4Mab7sDeeyodY3BjDuyB</CodeAuth><UserName>GAP#aCap%2015</UserName><Password>CAP15gap20Ag</Password> </Credentials> <CredentialsUserSICAS> <UserName>SISTEMAS@ASESORESCAPITAL.COM</UserName> <Password>MESCAMILLA</Password> </CredentialsUserSICAS> <TypeFormat>XML</TypeFormat> <KeyProcess>REPORT</KeyProcess> <KeyCode>HWS_VEND</KeyCode><ConditionsAdd>Devueltos;0;0;14;1;IDVend</ConditionsAdd> <TProc>Read_Data</TProc> </oDataWS> </ProcesarWS> </soap:Body> </soap:Envelope>';*/
	
	  		/*$fp = fopen('resultadoJason.txt', 'a');	
	      fwrite($fp, print_r($arreglo, TRUE));        
	      fclose($fp);*/

//	$data = $soap->ProcesarWS($arreglo);
	
	  /*		$fp = fopen('resultadoJason.txt', 'a');	
	      fwrite($fp, print_r($data, TRUE));        
	      fclose($fp);*/

  //$this->soapC = new SoapClient($this->uri_service, array('trace' => 1));	
  //$data = $this->soap->method($params);



 /* set_time_limit(900);
  $this->oDataWS = new \stdClass;
  $this->oDataWS->Credentials = new \stdClass;
  $this->oDataWS->Credentials->UserName = 'GAP#aCap%2015';
  $this->oDataWS->Credentials->Password = 'CAP15gap20Ag';
  $this->oDataWS->Credentials->CodeAuth = 'vsDMquPhx68SZrY8wGcxEh2bk1XiPlR0EZkBVLmax3A4Mab7sDeeyodY3BjDuyB';
  $this->oDataWS->CredentialsUserSICAS = new \stdClass;
  $this->oDataWS->CredentialsUserSICAS->UserName = $this->CI->tank_auth->get_UserSICAS();
  $this->oDataWS->CredentialsUserSICAS->Password = $this->CI->tank_auth->get_PassSICAS();*/
 } catch (Exception $e) {  }
}

function pruebas()
{

$options = array(			
		'trace'=>true,
		
	);	

$wsdl = "https://www.sicasonline.info/SOnlineWS/WS_SICASOnline.asmx?WSDL";//'https://www.sicasonline.info:448/SOnlineWS/WS_SICASOnline.asmx?WSDL';

	//$soap = new SoapClient($wsdl, $options);

     //$arreglo['oDataWS'][0]='Credentials';

     $arreglo['oDataWS']['Credentials']['UserName']="GAP#aCap%2015";
     $arreglo['oDataWS']['Credentials']['Password']="CAP15gap20Ag";
     $arreglo['oDataWS']['Credentials']['CodeAuth']="vsDMquPhx68SZrY8wGcxEh2bk1XiPlR0EZkBVLmax3A4Mab7sDeeyodY3BjDuyB"; 
         // $arreglo['oDataWS'][1]='CredentialsUserSICAS';    
     $arreglo['oDataWS']['CredentialsUserSICAS']['UserName']="SISTEMAS@ASESORESCAPITAL.COM";
     $arreglo['oDataWS']['CredentialsUserSICAS']['Password']="MESCAMILLA";
     $arreglo['oDataWS']['TipoEntidad']  =0;   
     $arreglo['oDataWS']['TypeDestinoCDigital']  ='CONTACT';  
     $arreglo['oDataWS']['IDValuePK']  =0;  
     $arreglo['oDataWS']['ActionCDigital']  ='GETFiles';  
     $arreglo['oDataWS']['TypeFormat']  ='XML';  
     //$arreglo['oDataWS']['TProc']  ='Read_Data';  
     $arreglo['oDataWS']['TProc']  ='Read_Data';
     $arreglo['oDataWS']['KeyProcess']  ='REPORT';  
     //$arreglo['oDataWS']['KeyProcess']  ='DATA';  
     $arreglo['oDataWS']['KeyCode']  ='H02000';  
     $arreglo['oDataWS']['Page']  =1;  
     $arreglo['oDataWS']['ItemForPage']  =500;  
    // $arreglo['oDataWS']['InfoSort']  ='CatVendedores.IDVend';  
    //$arreglo['oDataWS']['InfoSort']  ='CatClientes.IDCli';
        $arreglo['oDataWS']['InfoSort']  ='CatClientes.IDCli';
     $arreglo['oDataWS']['IDRelation']  =0;  
     //$arreglo['oDataWS']['ConditionsAdd']  ='Devueltos;0;0;14;14;IDVend';Tipo de Entidad;0;0;0;Fisicas;CatContactos.TipoEnt  
//$arreglo['oDataWS']['ConditionsAdd']  ='Tipo de Entidad;0;0;1;0;CatContactos.TipoEnt ';


     	/*$wsdata=array("IDVend"=>14,"Status"=>1 );
	$xmlS = new SimpleXMLElement('<InfoData/>');
	  $this->array_to_xml($wsdata, $xmlS);	
	  $xmlData = $xmlS->asXML();	*/

	       	//$wsdata=array("IDVend"=>14,"Status"=>1 );
	 
	       	$wsdata["CatVendedores"]["IDVend"]="14";
	       	$wsdata["CatVendedores"]["Status"]="0";
	$xmlS = new SimpleXMLElement('<InfoData/>');
	  $this->array_to_xml($wsdata, $xmlS);	
	  $xmlData = $xmlS->asXML();

     $newphrase = str_replace('<?xml version="1.0"?>',"",$xmlData);

  			  		$fp = fopen('resultadoJason.txt', 'w');	
	      fwrite($fp, print_r( $newphrase, TRUE));        
	      fclose($fp);

	  $TextEncript = $this->encripta($this->key, $this->ivPass, $newphrase);
	  

//$arreglo['oDataWS']['DataXML']  =$TextEncript;

	
	


}

function bajaAgente()
{

}
function bajaAgente2()
{
 $this->soapC = new SoapClient($this->uri_service, array('trace' => 1));	
try 
	{
	 		
	 $this->oDataWS->TipoEntidad = '0'    ; $this->oDataWS->TypeDestinoCDigital = 'CONTACT'; 
	 //$this->oDataWS->IDValuePK = '0'      ;// $this->oDataWS->ActionCDigital = 'GETFiles';
	 $this->oDataWS->TypeFormat = 'XML'   ; $this->oDataWS->TProc = 'Read_Data'; 
	 $this->oDataWS->KeyProcess = 'DATA'  ; $this->oDataWS->KeyCode = 'HWS_VEND';
	 $this->oDataWS->Page ='1'            ; $this->oDataWS->ItemForPage = '25';
	 $this->oDataWS->InfoSort = ''        ; $this->oDataWS->IDRelation = '0';
	 $this->oDataWS->ConditionsAdd ="Devueltos;5;1;0;0;IDVend"    ; 
	//Default Values
	
	//$wsdata["XML"]="<CatVendedores><IDVend>'14'</IDVend><Status>0</Status></CatVendedores>";
	/*$wsdata=array("IDVend"=>"14","Status"=>"1");
	//if(isset($wsdata["XML"]))
	//{ 
	$xmlS = new SimpleXMLElement('<InfoData/>');
	  $this->array_to_xml($wsdata, $xmlS);	
	  $xmlData = $xmlS->asXML();													 				
	  $TextEncript = $this->encripta($this->key, $this->ivPass, $xmlData);
	  $this->oDataWS->DataXML = $TextEncript;*/


	//}
	if(isset($wsdata['TipoEntidad'])){$this->oDataWS->TipoEntidad = $wsdata['TipoEntidad']; }
	if(isset($wsdata['IDRelation'])){$this->oDataWS->IDRelation = $wsdata['IDRelation'];} 
	if(isset($wsdata['TypeDestinoCDigital'])){$this->oDataWS->TypeDestinoCDigital = $wsdata['TypeDestinoCDigital'];} 
	if(isset($wsdata['IDValuePK'])){$this->oDataWS->IDValuePK = $wsdata['IDValuePK']; }
	if(isset($wsdata['ActionCDigital'])){$this->oDataWS->ActionCDigital = $wsdata['ActionCDigital']; }
	if(isset($wsdata['Page'])){$this->oDataWS->Page = $wsdata['Page']; }
	if(isset($wsdata['TProc'])){$this->oDataWS->TProc = $wsdata['TProc']; }
	if(isset($wsdata['KeyProcess'])){$this->oDataWS->KeyProcess = $wsdata['KeyProcess']; }
	if(isset($wsdata['KeyCode'])){$this->oDataWS->KeyCode = $wsdata['KeyCode']; }
	if(isset($wsdata['ItemForPage'])){$this->oDataWS->ItemForPage = $wsdata['ItemForPage']; }
	if(isset($wsdata['InfoSort'])){$this->oDataWS->InfoSort = $wsdata['InfoSort']; }
	if(isset($wsdata['ConditionsAdd'])){$this->oDataWS->ConditionsAdd = $wsdata['ConditionsAdd']; }
	//Consumir el Servicio Web
	$parameters = array('oDataWS' => $this->oDataWS);


	
$resutl = $this->soapC->ProcesarWS($parameters);
          


	//return $xml;
	} catch (Exception $e) { }

}

private function encripta($key,$ivPass,$TextPlain)
{
 if(strlen($key)!=24){throw new Exception('La longitud de la key ha de ser de 24 dígitos.<br>'); return -1; }
 if((strlen($ivPass) % 8 )!=0){ throw new Exception('La longitud del vector iv Passsword ha de ser múltiple de 8 dígitos.<br>'); return -2;}
 return @base64_encode(mcrypt_encrypt(MCRYPT_3DES, $key, $TextPlain, MCRYPT_MODE_CBC, $ivPass)); 
       @base64_encode(mcrypt_encrypt(MCRYPT_3DES, $key, $TextPlain, MCRYPT_MODE_CBC, $ivPass));
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
	}

}