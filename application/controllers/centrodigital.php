<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class centrodigital extends CI_Controller
{

	var $user = "GAP#aCap%2015";
	var $pass = "CAP15gap20Ag";
	var $auth = "vsDMquPhx68SZrY8wGcxEh2bk1XiPlR0EZkBVLmax3A4Mab7sDeeyodY3BjDuyB";

	var 	$DeleteXml = array('<?xml version="1.0" encoding="utf-8"?>', '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">', '<DATAINFO> ', '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"><soap:Body>', '<ProcesarWSResponse xmlns="http://tempuri.org/">', '<ProcesarWSResult>', '</ProcesarWSResult>', '</ProcesarWSResponse>', '</soap:Envelope>', '</DATAINFO> ', '</soap:Body>', '</DATAINFO> ',);
	var $ClearXml = array('', '', '', '', '', '', '', '', '', '', '', '',);

	function __construct()
	{
		parent::__construct();
		$this->load->library(array("webservice_sicas_soap", "role"));
		$this->load->helper('url');
		$this->load->model("catalogos_model");
		$this->load->model("capsysdre_directorio");
		$this->load->model("clientemodelo");
		$this->load->library('Ws_sicas');
	}

	public function index()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			echo "CentroDigital";
		}
	}/*! index */

	public function getValue($data)
	{
		return ($data != null) ? $data : '';
	}/*! getValue */

	public function LoadCentroDigital()
	{
		try {
			$TypeDestinoCDigital	= $this->input->get_post("TypeDestinoCDigital", false);
			$IDValuePK				= $this->input->get_post("IDValuePK", false);
			$ActionCDigital			= $this->input->get_post("ActionCDigital", false);
			$ListFilesURL			= $this->input->get_post("ListFilesURL", false);
			$FolderDestino			= $this->input->get_post("FolderDestino", false);

			$data	= array(
				"TypeDestinoCDigital"	=> $TypeDestinoCDigital,
				"IDValuePK"				=> $IDValuePK,
				"ActionCDigital"		=> $ActionCDigital,
				"ListFilesURL"			=> $ListFilesURL,
				"FolderDestino"			=> $FolderDestino,
				"ReadRecursive"			=> 1,
				"KeyProcess"			=> "CDIGITAL"
			);
			//** $this->load->library("webservice_sicas_soap");
			//** $data_result = $this->webservice_sicas_soap->GetCDDigital($data);
			$data_result	= $this->GetCDDigital($data);

			echo json_encode($data_result);
		} catch (Exception $e) {
		}
	}/*! LoadCentroDigital*/

	####
	//----------------------------------------------------------------------
	function GetCDDigital($data)
	{

		$page					= 1;
		$itemforPage			= 25;
		$role					= "";
		$VendedorID				= 0;
		$customConditionsAdd	= "";
		$result					= "";
		$busquedaCliente		= "";

		if (is_array($data)) {
			$TypeDestinoCDigital	= $data["TypeDestinoCDigital"];
			$IDValuePK				= $data["IDValuePK"];
			$ActionCDigital			= $data["ActionCDigital"];
			$ListFilesURL 			= $data["ListFilesURL"];
			$FolderDestino 			= $data["FolderDestino"];

			/*
			$data_body	= array(

							"Page"					=> 1,
							"ItemForPage"			=> "",
							"ConditionsAdd"			=> "",
							"InfoSort"				=> "",
							"KeyCode"				=> "",
							"KeyProcess"			=> "CDIGITAL",
							"TypeDestinoCDigital"	=> "DOCUMENT",
							"IDValuePK"				=> $IDValuePK,
							"ActionCDigital"		=> "GETFiles"
						  );
			*/
			//** $this->CI->load->library('Ws_sicas');
			//** $result	= $this->CI->ws_sicas->GetCDDigital($data);
			//	var_dump($data);
			//$result	= $this->getDatos($data);
			//$result	= $this->ws_sicas->getDatosSICAS($data);
			$result    =$this->ws_sicas->getDatosSICASDoc($data);
			/* return 
			$result; */
			if ($result->Datos && count($result->Datos) > 0) {
				$Level = 0;
				$result_c=array();
				foreach ($result->Datos as $value) {
					array_push($result_c, $value);
				}
				//$test = $this->CrearArbol($result_c, 0);
				$test = $this->CrearArbol($result_c);
				return $test;
				//$test["all"]=$result_c;

			} else {
				return array('text' => 'No cuenta con documentos');
			}
			/* if (isset($result['Datos']) && count($result['Datos']) > 0) {
				$result_c = array();
				if ($result['Datos']) {
					$Level = 0;
					foreach ($result['Datos'] as $value) {
						array_push($result_c, $value);
					}
					$test = $this->CrearArbol($result_c, 0);
				}
				return $test;
			} else {
				return array('text' => 'No cuenta con documentos');
			}
		}
	}

	private function CrearArbol($Arbol, $Nodo = 0)
	{

		$isFolder 	= false;
		$text		= "";
		$level		= "";
		$href		= "";
		$hreftarget	= "";
		$level_int 		= 0;
		foreach ($Arbol as $key => $value) {
			$value = (object)$value;
			if ((string)$value->Level == 0) {

				unset($Arbol[$key]);

				if ($value->Tipo == 0) {

					$isFolder = true;
					$text = (string)$value->NameShow;
					$level = (string)$value->Level;
				} else {

					$isFolder = false;
					$text = (string)$value->NameShow;
					$href = (string)$value->PathWWW;
					$hrefTarget = "_blank";
					$level = (string)$value->Level;
				}

				$recursive = $this->Hijos($Arbol);

				$return["isFolder"] = $isFolder;
				$return["text"] = $text;
				if (!empty($href))
					$return["href"] = $href;
				if (!empty($hrefTarget))
					$return["hrefTarget"] = $hrefTarget;
				if (!empty($level))
					$return["level"] = $level;

				if ($recursive != NULL)
					$return["children"] = $recursive;
			}
		}

		return empty($return) ? null : $return;
	}

	private function Hijos($Arbol)
	{
		$isFolder 	= false;
		$text		= "";
		$level		= "";
		$href		= "";
		$hreftarget	= "";
		$level = 0;

		$hijos = array();

		foreach ($Arbol as $key => $value) {

			unset($Arbol[$key]);
			$value = (object)$value;
			if ($value->Tipo == 0) {

				// $isFolder = true;
				// $text = (string)$value->NameShow;
				// $level = (string)$value->Level;
				$return  =
					array(
						"isFolder" => true,
						"text" => (string)$value->NameShow,
						"level" => (string)$value->Level
					);
			} else {

				$return  =
					array(
						"isFolder" => false,
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

			array_push($hijos, $return);
		}

		return empty($hijos) ? null : $hijos;
	}
	####

	##--##--##
	public function getDatos($data)
	{
		if (is_array($data)) {

			//			$IDDocto 	= $data["IDDocto"];
			/*					
			$data_body = array(
				//"Page" => 1,
				//"ItemForPage" => "",
				"ConditionsAdd" => "",
				"InfoSort"=>"",
				"KeyCode"=>"",
				"KeyProcess"=> "CDIGITAL",
				"TypeDestinoCDigital"=> "DOCUMENT",
				//"IDValuePK"=> $IDDocto,
				"ActionCDigital"=> "GETFiles"
			);
*/

			/*	###
			$TypeDestinoCDigital	= $data["TypeDestinoCDigital"];
			$IDValuePK				= $data["IDValuePK"];
			$ActionCDigital			= $data["ActionCDigital"];
			$ListFilesURL 			= $data["ListFilesURL"];
			$FolderDestino 			= $data["FolderDestino"];
*/
			$datos['KeyProcess']			= 'CDIGITAL';
			//	$datos['TipoEntidad']			= '0';
			$datos['TypeDestinoCDigital']	= $data["TypeDestinoCDigital"];
			$datos['IDValuePK']				= $data["IDValuePK"];
			$datos['ActionCDigital']		= $data["ActionCDigital"];
			if ($data["ActionCDigital"] != 'GETFiles') {
				$datos['ListFilesURL']			= $data["ListFilesURL"];
				$datos['FolderDestino']			= $data["FolderDestino"];
			} else {
				$datos['ReadRecursive']			= 0;
			}
			//$datos['TypeFormat']			= 'XML';
			//$datos['TipoEntidad']='0';
			//$datos['TProct']='Read_Data';
			//$datos['KeyCode']='';
			//$datos['ItemForPage']='10000';
			//$datos['InfoSort']='';
			//$datos['IDRelation']='0';
			//$datos['Page']='1';

			//	$datos['TypeFormat']			= 'XML';
			//	$datos['TProct']				= 'Read_Data';

			//	$datos['Page']					= '1';
			//	$datos['ItemForPage']			= '10000000';

			$result	= $this->getDatosSICAS($datos);

			if (isset($result[0]->Datos)) {
				$result_c = array();

				if ($result->Datos != "") {
					$Level = 0;

					foreach ($result->Datos as $value) {
						array_push($result_c, $value);
					}
					$newArbol	= $this->CrearArbol($result_c, 0);
				}

				return
					$newArbol;
			} else {
				return
					array(
						'text'	=> 'No cuenta con documentos',
					);
			}
		}
	}
	##--##--##

	/////////////
	public function getDatosSICAS($wsdata)
	{

		$xml	= '<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:tem="http://tempuri.org/"> <soap:Header/> <soap:Body> <ProcesarWS xmlns="http://tempuri.org/"> <oDataWS> <Credentials>';

		$xml	= $xml . '<UserName>' . $this->user . '</UserName>';
		$xml	= $xml . '<Password>' . $this->pass . '</Password>';
		$xml	= $xml . '<CodeAuth>' . $this->auth . '</CodeAuth></Credentials>';
		$xml	= $xml . '<CredentialsUserSICAS><UserName>SISTEMAS@ASESORESCAPITAL.COM</UserName>';
		$xml	= $xml . '<Password>ACHAN2019</Password></CredentialsUserSICAS>';

		foreach ($wsdata as $key => $value) {
			$xml	= $xml . '<' . $key . '>' . $value . '</' . $key . '>';
		}

		$xml	= $xml . '</oDataWS> </ProcesarWS> </soap:Body> </soap:Envelope>';


		$headers	= array(
			"POST /SOnlineWSQua/WS_SICASOnline.asmx HTTPS/1.1",
			"Content-Type: text/xml; charset=utf-8",
			"Accept: text/xml",
			"Host: www.sicasonline.info",
			"Pragma: no-cache",
			"SOAPAction: http://tempuri.org/ProcesarWS",
			"Content-length: " . strlen($xml),
		);

		$ch			= curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://www.sicasonline.info/SOnlineWS/WS_SICASOnline.asmx?WSDL');
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml); // the SOAP request
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_TIMEOUT, 100);
		curl_setopt($ch, CURLOPT_POST, true);
		// converting    

		$response				= curl_exec($ch);
		$resXmlConsumo			= str_replace($this->DeleteXml, $this->ClearXml, $response);
		$xmlTexto_resXmlConsumo	= htmlspecialchars_decode($resXmlConsumo);

		$xmlRespuesta = <<<XML
	$xmlTexto_resXmlConsumo
XML;

		$return	= array();
		$carga_xmlRespuesta	= simplexml_load_string($xmlRespuesta);

		curl_close($ch);

		return
			$carga_xmlRespuesta;
	}
}
