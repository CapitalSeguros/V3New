<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class webservice_sicas
{

	var $auth = "vsDMquPhx68SZrY8wGcxEh2bk1XiPlR0EZkBVLmax3A4Mab7sDeeyodY3BjDuyB";
	// var $user_sicas = "desarrollo@agentecapital.com";

	var $user = "GAP#aCap%2015";

	// var $pass_sicas = "hola00";	
	var $pass = "CAP15gap20Ag";
	var $Url = 'https://{host}/SOnlineWS/WS_SICASOnline.asmx?WSDL';
	var $host = 'www.sicasonline.info:448';
	var $ip_zone;
	var $DeleteXml = array('<?xml version="1.0" encoding="utf-8"?>', '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">', '<ProcesarWSResponse xmlns="http://tempuri.org/">', '<ProcesarWSResult>', '</ProcesarWSResult>', '</ProcesarWSResponse>', '</soap:Envelope>',);
	var $ClearXml = array('', '', '', '', '', '', '');
	var $key = "%SOnlineBOGO2001-2015WS#";
	var $ivPass = "GAP#aCap";
	public $user_sicas = "";
	public $pass_sicas = "";
	public $CI;
	// private $Credentials_UserName	= "GAP#aCap%2015";
	// private $Credentials_Password	= "CAP15gap20Ag";
	// private $Credentials_CodeAuth	= "vsDMquPhx68SZrY8wGcxEh2bk1XiPlR0EZkBVLmax3A4Mab7sDeeyodY3BjDuyB";	

	// private $CredentialsUserSICAS_UserName	= "desarrollo@agentecapital.com";
	// private $CredentialsUserSICAS_Password	= "hola00";

	public function
	__construct()
	{

		//if(count($data) > 0){
		$this->CI = &get_instance();
		$this->ip_zone = str_replace("{host}", $this->host, $this->Url);
		$this->initialize();
		//}		
	}


	/**
	 * Initialize preferences
	 *
	 * @param	array
	 * @return	void
	 */
	public function initialize($config = array())
	{
		$defaults = array(
			'user_sicas'			=> $this->CI->tank_auth->get_UserSICAS(),
			'pass_sicas'			=> $this->CI->tank_auth->get_PassSICAS()
		);


		foreach ($defaults as $key => $val) {
			if (isset($config[$key])) {
				$method = 'set_' . $key;
				if (method_exists($this, $method)) {
					$this->$method($config[$key]);
				} else {
					$this->$key = $config[$key];
				}
			} else {
				$this->$key = $val;
			}
		}
	}

	/*
	*	@username	string	Your username.
	*	@password	string	Your password.
	* 	@return Type: string {API KEY}   
	*/
	public function GetClient($data)
	{

		$page = 1;
		$itemforPage = 25;
		$role = "";
		$VendedorID = 0;
		$customConditionsAdd = "";

		if (is_array($data)) {
			$role = $data["role"];
			$VendedorID = $data["id"];
			if ($role == "MASTER") {
				$customConditionsAdd = "Campo;0;0;0;0;0;-1;CatClientes.FieldInt1";
			} else {
				$customConditionsAdd = "Campo;0;0;'. $VendedorID . ';'. $VendedorID . ';0;-1;CatClientes.FieldInt1	";
			}
		}

		$data_body = array(
			"page" => $page,
			"itemforPage" => $itemforPage,
			"customConditionsAdd" => $customConditionsAdd

		);

		$postDataXML = array("postDataXML" => $this->PostBody($data_body));

		$result = $this->ProcessCurl($postDataXML);

		return $result;
	}

	public function GetClient_forName($data)
	{

		$page = 1;
		$itemforPage = 25;
		$role = "";
		$VendedorID = 0;
		$customConditionsAdd = "";
		$result = "";
		$busquedaCliente = "";

		if (is_array($data)) {

			$role 				= $data["role"];
			$VendedorID 		= $data["id"];
			$Regimen 			= $data["regimen"];
			$busquedaCliente 	= $data["busquedaCliente"];

			// var_dump($busquedaCliente);

			$customConditionsAdd .= 'Regimen Fiscal;0;0;' . $Regimen . ';' . $Regimen . ';0;-1;CatClientes.TipoEnt';
			$customConditionsAdd .= '!';
			$customConditionsAdd .= 'Nombre Completo;0;0;' . $busquedaCliente . ';' . $busquedaCliente . ';0;-1;CatClientes.NombreCompleto';

			$data_body = array(
				"key_code" => 'HDS00002',
				"page" => $page,
				"itemforPage" => $itemforPage,
				"InfoSort" => 'CatClientes.IDCli',
				"customConditionsAdd" => $customConditionsAdd

			);

			$postDataXML = array("postDataXML" => $this->GetXML($data_body));

			$result = $this->ProcessCurl($postDataXML);

			// var_dump($result);
		}

		return $result;
	}

	public function GetContact_forID($IDCont)
	{
		$page = 1;
		$itemforPage = 25;
		$role = "";
		$VendedorID = 0;
		$customConditionsAdd = "";
		$result = "";
		$busquedaCliente = "";

		$customConditionsAdd .= 'Cliente ID;0;0;' . $IDCont . ';' . $IDCont . ';0;-1;CatClientes.IDCli ';

		$xml_array = array('CatContactos' => array('IdCont' => $IDCont));

		$data_body = array(
			'xml' => $xml_array,
			'config' => array(
				"type_format" => "JSON",
				"key_code" => "HDATACONTACT",
				"read_data" => "Read_Data"
			),
		);

		$postDataXML = array("postDataXML" => $this->GetReadXML($data_body));

		$result = $this->ProcessCurlRaw($postDataXML, true);
		return $result;
	}
	public function GetClient_forID($IDCli)
	{

		$page = 1;
		$itemforPage = 25;
		$role = "";
		$VendedorID = 0;
		$customConditionsAdd = "";
		$result = "";
		$busquedaCliente = "";

		$customConditionsAdd .= 'Cliente ID;0;0;' . $IDCli . ';' . $IDCli . ';0;-1;CatClientes.IDCli ';

		$data_body = array(
			"key_code" => 'HDS00002',
			"page" => $page,
			"itemforPage" => $itemforPage,
			"InfoSort" => 'CatClientes.IDCli',
			"customConditionsAdd" => $customConditionsAdd
		);

		$postDataXML = array("postDataXML" => $this->GetXML($data_body));

		$result = $this->ProcessCurl($postDataXML);

		$a_contacts = array();
		foreach ($result as $value) {

			$oContact = $this->GetContact_forID($value->IDCont)['Values'];

			$a_contact = new StdClass();

			$a_contact->IdCont = $oContact['CatContactos.IDCont'];
			$a_contact->Nombre = $oContact['CatContactos.Nombre'];
			$a_contact->ApellidoP = $oContact['CatContactos.ApellidoP'];
			$a_contact->ApellidoM = $oContact['CatContactos.ApellidoM'];
			$a_contact->Alias = $oContact['CatContactos.Titulo'];
			$a_contact->Puesto = $oContact['CatContactos.Puesto'];
			$a_contact->Departamento = $oContact['CatContactos.Departamento'];
			$a_contact->Email1 = $oContact['CatContactos.EMail1'];
			$a_contact->Telefono1 = $oContact['CatContactos.Telefono1'];
			$a_contact->Nacionalidad = $oContact["CatContactos.Nacionalidad"];

			array_push($a_contacts, $a_contact);
		}

		$a_result = array('cliente' => $result[0], 'contactos' => $a_contacts);
		return $a_result;
	}



	public function GetReport($data)
	{

		$page = 1;
		$itemforPage = 25;
		if (is_array($data)) {

			if (isset($data['page'])) {
				$page = $data['page'];
			}
			$sFilter = "";
			foreach ($data['filter'] as $key => $value) {

				//echo $value;

				switch ($key) {
					case 'name_client':

						if (!empty($value))
							$sFilter .= "Nombre Completo;0;0;*" . $value . "*;" . $value . ";CatContactos.NombreCompleto ! ";
						break;
						// case 'branch':
						// 	$sFilter .="Ramo;0;0;*".$value."*;".$value.";DatDocumentos.RamosAbreviacion ! ";
						// 	break;
						// case 'sub_branch':
						// 	$sFilter .="Sub Ramo;0;0;*".$value."*;".$value.";DatDocumentos.SRamoAbreviacion ! ";
						// 	break;
					case 'insurance':
						if (!empty($value))
							$sFilter .= "Aseguradora;0;0;*" . $value . "*;" . $value . ";CatAgentes.AgenteNombre ! ";
						break;
					case 'vigencia':
						if (!empty($value))
							$sFilter .= "Desde|Hasta;3;0;" . $value . ";" . $value . ";0;-1;DatDocumentos.FDesde ! ";
						break;
					case 'policy':
						if (!empty($value))
							$sFilter .= "Poliza;0;0;" . $value . ";" . $value . ";DatDocumentos.IDDocto ! ";
						break;
						// case 'status':
						// 	$sFilter .="Estatus;0;0;".$value.";".$value.";DatDocumentos.Status ! ";
						// break;
					case 'salesman':
						if (!empty($value))
							$sFilter .= "Vendedor;0;0;*" . $value . "*;" . $value . ";CatVendedores.VendNombre ! ";
						break;
					case 'group':
						if (!empty($value))
							$sFilter .= "Grupo;0;0;*" . $value . "*;" . $value . ";DatDocumentos.Grupo ! ";
						break;
					case 'sub_group':
						if (!empty($value))
							$sFilter .= "Sub Grupo;0;0;*" . $value . "*;" . $value . ";DatDocumentos.SubGrupo ! ";
						break;
				}
			}

			$sFilter = substr($sFilter, 0, -2);

			$data_body = array(
				"key_code" => 'H03400_006|H03400_007',
				"page" => $page,
				"itemforPage" => $itemforPage,
				"InfoSort" => 'DatDocumentos.IDDocto',
				"customConditionsAdd" => $sFilter
			);


			$postDataXML = array("postDataXML" => $this->GetXML($data_body));

			$result = $this->ProcessCurlRaw($postDataXML);

			//var_dump($result);

			return $result;
		}
	}

	public function GetClient_forNameLike($data)
	{

		$page = 1;
		$itemforPage = 25;
		$role = "";
		$VendedorID = 0;
		$customConditionsAdd = "";
		$result = "";
		$busquedaCliente = "";

		if (is_array($data)) {

			// $role 				= $data["role"];
			// $VendedorID 		= $data["id"];
			// $Regimen 			= $data["regimen"];
			$busquedaCliente 	= $data["busquedaCliente"];
			if (isset($data['page'])) {
				$page = $data['page'];
			}

			// var_dump($busquedaCliente);

			// $customConditionsAdd .= 'Regimen Fiscal;0;0;'. $Regimen .';'. $Regimen .';0;-1;CatClientes.TipoEnt';
			// $customConditionsAdd .= '!';
			$customConditionsAdd .= 'Nombre Completo;0;0;*' . $busquedaCliente . '*;*' . $busquedaCliente . '*;0;-1;CatClientes.NombreCompleto ';

			$data_body = array(
				"key_code" => 'HDS00002',
				"page" => $page,
				"itemforPage" => $itemforPage,
				"InfoSort" => 'CatClientes.NombreCompleto',
				"customConditionsAdd" => $customConditionsAdd

			);

			$postDataXML = array("postDataXML" => $this->GetXML($data_body));

			$result = $this->ProcessCurlRaw($postDataXML);
		}

		return $result;
	}
	public function GetClients($data)
	{

		$page = 1;
		$itemforPage = 5;
		$role = "";
		$VendedorID = 0;
		$customConditionsAdd = "";
		$result = "";
		$busquedaCliente = "";

		if (is_array($data)) {

			if (isset($data['page'])) {
				$page = $data['page'];
			}

			// var_dump($busquedaCliente);

			// $customConditionsAdd .= 'Regimen Fiscal;0;0;'. $Regimen .';'. $Regimen .';0;-1;CatClientes.TipoEnt';
			// $customConditionsAdd .= '!';
			$customConditionsAdd .= 'Nombre Completo;0;0;*HERRERA BUENO ALEJANDRO DEMO*;HERRERA BUENO ALEJANDRO DEMO;0;-1;CatClientes.NombreCompleto ! FieldInt2;0;0;0;0;0;-1;CatClientes.FieldInt2 ';

			$data_body = array(
				"key_code" => 'HDS00002',
				"page" => $page,
				"itemforPage" => $itemforPage,
				"InfoSort" => 'CatClientes.IDCli',
				"customConditionsAdd" => $customConditionsAdd

			);

			$postDataXML = array("postDataXML" => $this->GetXML($data_body));

			$result = $this->ProcessCurlRaw($postDataXML);
		}

		return $result;
	}


	public function UpdateClient_forPolicy()
	{
		$pages = 0;
		$page = 1;
		try {

			do {
				$data = array('page' => $page);
				$result_nameDirectory = $this->GetClients($data);
				if ($result_nameDirectory->Sucess) {
					foreach ($result_nameDirectory->Datos as $item) {
						$data_policy = array('idCli' => $item->IDCli);
						$policy_result = $this->GetClient_forPolicy($data_policy);
						if (count($policy_result) > 0) {
							$this->SetCliente($item->IDCli);
						}
					}
					if (isset($result_nameDirectory->Info->Pages)) {
						$pages = $result_nameDirectory->Info->Pages;
					}
				}

				$page++;
			} while ($page < $pages);
		} catch (Exception $ex) {
		}
		//return $result_c;
	}

	private function GetClient_forPolicy($data)
	{
		$page = 1;
		$itemforPage = 1;
		$role = "";
		$VendedorID = 0;
		$customConditionsAdd = "";
		$result = "";
		$busquedaCliente = "";

		if (is_array($data)) {

			$idCli 	= $data["idCli"];

			$sDate = "01/01/" . date("Y");

			$customConditionsAdd .= 'Cliente Id;0;0;' . $idCli . ';' . $idCli . ';0;-1;DatDocumentos.IDCli ! Tipo Documento;0;0;1;1;DatDocumentos.TipoDocto ';
			// ! Id Cliente;5;0;'.$sDate.';0;DatDocumentos.FHasta

			$data_body = array(
				"key_code" => 'H03400_006',
				"page" => $page,
				"itemforPage" => $itemforPage,
				"InfoSort" => 'CatClientes.IDCli',
				"customConditionsAdd" => $customConditionsAdd
			);

			$postDataXML = array("postDataXML" => $this->GetXML($data_body));

			$result = $this->ProcessCurl($postDataXML);
			return $result;
		}
	}

	public function GetClient_forPolicyActive($data, $filtro = '')
	{
		$page = 1;
		$itemforPage = 25;
		$role = "";
		$VendedorID = 0;
		$customConditionsAdd = "";
		$result = "";
		$busquedaCliente = "";

		if (is_array($data)) {

			$idCli 	= $data["idCli"];

			$sDate = date("d/m/Y");

			if (isset($data['page'])) {
				$page = $data['page'];
			}
			if ($filtro == 1) {
				$customConditionsAdd .= 'Cliente Id;0;0;' . $idCli . ';' . $idCli . ';0;-1;';
			} else {
				$customConditionsAdd .= 'Cliente Id;0;0;' . $idCli . ';' . $idCli . ';0;-1;DatDocumentos.IDCli ! Tipo Documento;0;0;1;1;DatDocumentos.TipoDocto ! Id Cliente;5;0;' . $sDate . ';0;DatDocumentos.FHasta ';
			}


			$data_body = array(
				"key_code" => 'H03400_006',
				"page" => $page,
				"itemforPage" => $itemforPage,
				"InfoSort" => 'CatClientes.IDCli',
				"customConditionsAdd" => $customConditionsAdd
			);

			$postDataXML = array("postDataXML" => $this->GetXML($data_body));

			$result = $this->ProcessCurlRaw($postDataXML);

			$pagination = array();

			if (isset($result->Info)) {
				$pagination = array('Pages' => $result->Info->Pages, 'Page' => $result->Info->Page);
			}

			$result_c = array(
				'documentos' => $result->Datos,
				'paginacion' => $pagination
			);

			return $result_c;
		}
	}
	public function GetPolicy_forID_Docto($IDDocto)
	{
		$page = 1;
		$itemforPage = 25;
		$role = "";
		$VendedorID = 0;
		$customConditionsAdd = "";
		$result = "";
		$busquedaCliente = "";

		$sDate = date("d/m/Y");

		if (isset($data['page'])) {
			$page = $data['page'];
		}

		$xml_array = array('DatDocumentos' => array('IDDocto' => $IDDocto));

		$data_body = array(
			'xml' => $xml_array,
			'config' => array(
				"type_format" => "JSON",
				"key_code" => "HWS_DOCTOS",
				"read_data" => "Read_Data"
			),
		);

		$postDataXML = array("postDataXML" => $this->GetReadXML($data_body));

		$result = $this->ProcessCurlRaw($postDataXML, true);
		$a_contacts = array();
		$a_contact = new StdClass();
		if ($result["Sucess"]) {
			$doc = $result["Values"];
			$a_contact = new StdClass();

			$a_contact->IDDocto = $doc['DatDocumentos.IDDocto'];
			$a_contact->IDSRamo = $doc['DatDocumentos.IDSRamo'];
			$a_contact->IDCli = $doc['DatDocumentos.IDCli'];
			// $a_contact->IDCli = $doc['DatDocumentos.IDCli'];					


		}

		return $a_contact;
	}
	public function GetPolicy_forID($IDDocto)
	{
		$page = 1;
		$itemforPage = 25;
		$role = "";
		$VendedorID = 0;
		$customConditionsAdd = "";
		$result = "";
		$busquedaCliente = "";

		$sDate = date("d/m/Y");

		if (isset($data['page'])) {
			$page = $data['page'];
		}

		$customConditionsAdd .= 'Cliente Id;0;0;' . $IDDocto . ';' . $IDDocto . ';0;-1;DatDocumentos.IDDocto ';

		//Tipo Documento;0;0;1;1;DatDocumentos.TipoDocto ! Id Cliente;5;0;'.$sDate.';0;DatDocumentos.FHasta 

		$data_body = array(
			"key_code" => 'H03400_006',
			"page" => $page,
			"itemforPage" => $itemforPage,
			"InfoSort" => 'DatDocumentos.IDDocto',
			"customConditionsAdd" => $customConditionsAdd
		);

		$postDataXML = array("postDataXML" => $this->GetXML($data_body));

		$result = $this->ProcessCurlRaw($postDataXML);

		$pagination = array();
		if (isset($result->Info)) {
			$pagination = array('Pages' => $result->Info->Pages, 'Page' => $result->Info->Page);
		}
		$result_c = array(
			'documentos' => $result->Datos,
			'paginacion' => $pagination
		);

		return $result_c;
	}

	public function GetDataClienteProspecto($data)
	{

		try {

			if (is_array($data)) {
				$result_nameDirectory = $this->GetClient_forNameLike($data);

				$a_cliente = array();
				$a_prospecto = array();
				foreach ($result_nameDirectory->Datos as $item) {

					if ($item->FieldInt2 == 1) { //$item->FieldInt2 = 1 : Cliente
						array_push($a_cliente, $item);
					} else { // $item->FieldInt2 = 0 : Prospecto
						array_push($a_prospecto, $item);
					}
				}

				$pagination = array();
				if (isset($result->Info)) {
					$pagination = array('Pages' => $result_nameDirectory->Info->Pages, 'Page' => $result_nameDirectory->Info->Page);
				}
				$result_c = array(
					'cliente' => $a_cliente,
					'prospecto' => $a_prospecto,
					'paginacion' =>  $pagination
				);

				return $result_c;
			}
		} catch (Exception $e) {
			echo $e;
		}
	}

	private function SearchDoctiType($data)
	{

		$is_poliza = false;

		try {
			if (is_array($data)) {
			}
		} catch (Exception $e) {
		}

		return $is_poliza;
	}

	private function ProcessCurl($data, $wsNodoExtrae = null)
	{ //$data["postDataXML"]

		//$urlSite = 'http://localhost/apiold/sicas/addData';
		$urlSite = URL_TICC_SICAS . 'sicas/addData';
		$Fiedls = array("data" => $data["postDataXML"]);
		$format = "XML";
		$test = json_encode($Fiedls);
		$httpHeader = array();
		$headers = array("Content-Type: application/json; charset=utf-8");
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $urlSite,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 120,
			CURLOPT_CONNECTTIMEOUT => 120,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => json_encode($Fiedls),
			CURLOPT_HTTPHEADER => $headers
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
			$obj["code"] = 400;
			$obj["error"] = $err;
			return json_encode($obj);
		} else {
			//echo $response;
			$decoded_response = json_decode($response);
			if ($format === "JSON") {
				if ($wsNodoExtrae != null) {
					return $decoded_response->TableInfo->$wsNodoExtrae;
				} else {
					return $decoded_response;
				}
			}
			$decoded_response2 = json_decode($response, true);
			$returnedResponse = $this->convertResponse($decoded_response2);
			return $returnedResponse;
		}
	}

	function convertResponse($respuesta)
	{
		$xml = "<DATAINFO>";
		$Type = gettype($respuesta["TableInfo"]);
		if (is_array($respuesta["TableInfo"])) {
			foreach ($respuesta["TableInfo"] as $key => $value) {
				$arraykeys = array_keys($value);
				$test = count($arraykeys);
				if ($arraykeys == 0 || isset($respuesta["TableInfo"]["DATAINFO"])) {
					$arraykeys = array_keys($value[0]);
					$value = $value[0];
				}
				$xml .= "<TableInfo>";
				foreach ($arraykeys as $k => $val) {
					$xml .= "<{$val}>" . $value[$val] . "</{$val}>";
				}
				$xml .= "</TableInfo>";
			}
			if (count($respuesta["TableInfo"]) == 0) {
				$xml .= "<TableInfo>";
				$xml .= "</TableInfo>";
			}
		} else {
			$arraykeys = array_keys($respuesta["TableInfo"]);
			$xml .= "<TableInfo>";
			foreach ($arraykeys as $k => $val) {
				$xml .= "<{$val}>" . $respuesta["TableInfo"][$val] . "</{$val}>";
			}
			$xml .= "</TableInfo>";
		}

		//Ponemos los datos del table control
		$arraykeys = array_keys($respuesta["TableControl"]);
		$xml .= "<TableControl>";
		foreach ($arraykeys as $k => $val) {
			$xml .= "<{$val}>" . $respuesta["TableControl"][$val] . "</{$val}>";
		}
		$xml .= "</TableControl>";
		//$xml .= "<Sucess>True</Sucess>";
		$xml .= "</DATAINFO>";
		$text = preg_replace('/&(?!#?[a-z0-9]+;)/', '', $xml);
		//$text=preg_replace('/&(?!#?[a-z0-9]+;)/', '', $text);
		//$text= preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $text);
		$text = str_replace(' & ', '', html_entity_decode((htmlspecialchars_decode($text))));
		//echo $text;
		//$resXmlConsumo = str_replace($this->DeleteXml, $this->ClearXml, $xml);
		$resXmlConsumo = str_replace($this->DeleteXml, $this->ClearXml, $text);
		$convert = htmlspecialchars_decode($resXmlConsumo);
		$Responde = simplexml_load_string($convert);

		return $Responde;
	}


	private function ProcessCurlRaw($data, $isxml = false)
	{
		//$data["postDataXML"]
		$urlSite = URL_TICC_SICAS . 'sicas/addData';
		$Fiedls = array("data" => $data["postDataXML"]);
		$format = "XML";
		$test = json_encode($Fiedls);
		$httpHeader = array();
		$headers = array("Content-Type: application/json; charset=utf-8");
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_URL => $urlSite,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 120,
			CURLOPT_CONNECTTIMEOUT => 120,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => json_encode($Fiedls),
			CURLOPT_HTTPHEADER => $headers
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);
		if ($err) {
			$obj["code"] = 400;
			$obj["error"] = $err;
			return json_encode($obj);
		} else {
			//echo $response;
			$decoded_response = json_decode($response);
			if ($isxml == false) {
				return $decoded_response;
			}
			$decoded_response2 = json_decode($response, true);
			$returnedResponse = $this->convertResponse($decoded_response2);
			return $returnedResponse;
		}
	}
	private function SetCliente($IDCli)
	{
		$xmlData = '<InfoData>
			          <CatClientes>
			            <IDCli>' . $IDCli . '</IDCli>
			            <FieldInt2>0</FieldInt2>
			          </CatClientes>
			        </InfoData>';
		$key_code = 'H02000';
		$postDataXML = array("postDataXML" => $this->GetSaveXML($xmlData, $key_code));
		$result = $this->ProcessCurl($postDataXML);
	}

	private function SetDataDocument($IDDocto)
	{
		$xmlData = '<InfoData>
			          <DatDocumentos>
			            <IDDocto>' . $IDDocto . '</IDDocto>
			          </DatDocumentos>
			        </InfoData>';
		$key_code = 'HWS_DOCTOS';
		$postDataXML = array("postDataXML" => $this->GetSaveXML($xmlData, $key_code));
		$result = $this->ProcessCurl($postDataXML);
	}

	private function GetXML($data)
	{
		$postDataXML = '<ProcesarWS xmlns="http://tempuri.org/">
						      <oDataWS>
						        <TypeFormat>JSON</TypeFormat>
						        <KeyProcess>REPORT</KeyProcess>
						        <KeyCode>' . $data["key_code"] . '</KeyCode>
						        <Page>' . $data["page"] . '</Page>
						        <ItemForPage>' . $data["itemforPage"] . '</ItemForPage>
						        <InfoSort>' . $data["InfoSort"] . '</InfoSort>
						        <ConditionsAdd>
						        	' . $data["customConditionsAdd"] . '
						        </ConditionsAdd>
						      </oDataWS>
						    </ProcesarWS>';
		return $postDataXML;
	}

	function array_to_xml($array, &$xml_user_info)
	{
		foreach ($array as $key => $value) {
			if (is_array($value)) {
				if (!is_numeric($key)) {
					$subnode = $xml_user_info->addChild("$key");
					$this->array_to_xml($value, $subnode);
				} else {
					$subnode = $xml_user_info->addChild("item$key");
					$this->array_to_xml($value, $subnode);
				}
			} else {
				$xml_user_info->addChild("$key", htmlspecialchars("$value"));
			}
		}
	}
	private function GetReadXML($data)
	{

		$xml = "";
		if (is_array($data)) {

			$xmlS = new SimpleXMLElement('<InfoData/>');
			$this->array_to_xml($data['xml'], $xmlS);

			$xmlData = $xmlS->asXML();

			//$TextEncript = $this->encripta($this->key, $this->ivPass, $xmlData);
			$TextEncript = $xmlData;

			$xml = '<ProcesarWS>
					      <oDataWS>
					        <TypeFormat>' . $data["config"]["type_format"] . '</TypeFormat>
					        <KeyProcess>DATA</KeyProcess>
					        <KeyCode>' . $data["config"]["key_code"] . '</KeyCode>
					        <TProc>' . $data["config"]["read_data"] . '</TProc>
					        <DataXML>' . $TextEncript . '</DataXML>
					      </oDataWS>
					    </ProcesarWS>';
		}

		return $xml;
	}

	private function GetSaveXML($xmlData, $key_code)
	{
		//$TextEncript = $this->encripta($this->key, $this->ivPass, $xmlData);

		$xml = '<ProcesarWS>
				      <oDataWS>
				        <TypeFormat>JSON</TypeFormat>
				        <KeyProcess>DATA</KeyProcess>
				        <KeyCode>' . $key_code . '</KeyCode>
				        <TProc>Save_Data</TProc>
				        <DataXML>' . $xmlData . '</DataXML>
				      </oDataWS>
				    </ProcesarWS>';

		return $xml;
	}
	private function PostBody($data)
	{
		$postBody = "";

		if (is_array($data)) {

			//$data["CatClientes.IDCli"]
			$postBody = '<ProcesarWS>
						<oDataWS>
							<TypeFormat>JSON</TypeFormat>
							<KeyProcess>REPORT</KeyProcess>
							<KeyCode>HDS00002</KeyCode>
							<Page>' . $data["page"] . '</Page>
							<ItemForPage>' . $data["itemforPage"] . '</ItemForPage>
							<InfoSort>CatClientes.IDCli</InfoSort>
							<ConditionsAdd>
								' . $data["customConditionsAdd"] . '
							</ConditionsAdd>
						</oDataWS>
					</ProcesarWS>';
		}

		return $postBody;
	}

	private function PostBodyGeneric($data)
	{
		$postBody = "";

		if (is_array($data)) {

			//$data["CatClientes.IDCli"]
			$postBody = '<ProcesarWS>
						<oDataWS>
							<TypeFormat>JSON</TypeFormat>
							<KeyProcess>REPORT</KeyProcess>
							<KeyCode>HDS00002</KeyCode>
							<Page>' . $data["page"] . '</Page>
							<ItemForPage>' . $data["itemforPage"] . '</ItemForPage>
							<InfoSort>CatClientes.IDCli</InfoSort>
							<ConditionsAdd>
								' . $data["customConditionsAdd"] . '
							</ConditionsAdd>
						</oDataWS>
					</ProcesarWS>';
		}

		return $postBody;
	}
	private function PostBodyEncript($data)
	{
		$postBody = "";

		if (is_array($data)) {

			//$data["CatClientes.IDCli"]

			$postBody = '<ProcesarWS xmlns="http://tempuri.org/">
						<oDataWS>
							<TypeFormat>JSON</TypeFormat>
							<KeyProcess>REPORT</KeyProcess>
							<KeyCode>HDS00002</KeyCode>
							<Page>' . $data["page"] . '</Page>
							<ItemForPage>' . $data["itemforPage"] . '</ItemForPage>
							<InfoSort>CatClientes.IDCli</InfoSort>
							<ConditionsAdd>
								' . $data["customConditionsAdd"] . '
							</ConditionsAdd>
						</oDataWS>
					</ProcesarWS>';
		}

		return $postBody;
	}
}
