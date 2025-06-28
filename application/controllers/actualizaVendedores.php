<?php 
if(!defined('BASEPATH')) exit ('No direct script access allowed');

class actualizaVendedores extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->library('webservice_sicasdre');
		$this->load->library('tank_auth');
		$this->load->library('serviciowebsicas');
	}
	
	function index(){		
		$this->load->view('actualizaVendedores/principal');
	}/*! index */
	


function bajaVendedor2(){



}


function bajaVendedor(){

	//$this->serviciowebsicas->bajaAgente();
	//$this->serviciowebsicas->pruebas();
    /* $key = "%SOnlineBOGO2001-2015WS#";   $ivPass = "GAP#aCap";
     $auth = "vsDMquPhx68SZrY8wGcxEh2bk1XiPlR0EZkBVLmax3A4Mab7sDeeyodY3BjDuyB";	
	 $user = "GAP#aCap%2015";$pass = "CAP15gap20Ag";
	 $Url = 'https://{host}/SOnlineWS/WS_SICASOnline.asmx?WSDL';
	 $host = 'www.sicasonline.info:448';
	 $ip_zone;
     $ip_zone = str_replace("{host}",$host,$Url);
$IDVend =14;
$xmlData = '<InfoData>
			          <CatVendedores>
			            <IDVend>' . $IDVend . '</IDVend>
			            <Status>0</Status>
			          </CatVendedores>
			        </InfoData>';
		$key_code = 'HWS_VEND';


//$TextEncript = $this->encripta($this->key, $this->ivPass, $xmlData);
//
		if(strlen($key)!=24){
			throw new Exception('La longitud de la key ha de ser de 24 dígitos.<br>'); 
			return -1; 
		} if((strlen($ivPass) % 8 )!=0){ 
			throw new Exception('La longitud del vector iv Passsword ha de ser múltiple de 8 dígitos.<br>'); 
			return -2; 
		} 


		 $TextEncript=@base64_encode(mcrypt_encrypt(MCRYPT_3DES, $key, $xmlData, MCRYPT_MODE_CBC, $ivPass));
		 $user_sicas=$this->tank_auth->get_UserSICAS();
         $pass_sicas=$this->tank_auth->get_PassSICAS();
		$xml = '<?xml version="1.0" encoding="utf-8"?>
				<soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
				  <soap:Body>
				    <ProcesarWS xmlns="http://tempuri.org/">
				      <oDataWS>
				        <Credentials>
				          <UserName>'.$user.'</UserName>
							<Password>'.$pass.'</Password>
  							<CodeAuth>'.$auth.'</CodeAuth><UserName>'.$user.'</UserName>
							<Password>'.$pass.'</Password>
  							<CodeAuth>'.$auth.'</CodeAuth>
				        </Credentials>
				        <CredentialsUserSICAS>
				          	<UserName>'.$user_sicas.'</UserName>
							<Password>'.$pass_sicas.'</Password>
				        </CredentialsUserSICAS>
				        <TypeFormat>JSON</TypeFormat>
				        <KeyProcess>DATA</KeyProcess>
				        <KeyCode>'.$key_code.'</KeyCode>
				        <TProc>Save_Data</TProc>
				        <DataXML>'.$TextEncript.'</DataXML>
				      </oDataWS>
				    </ProcesarWS>
				  </soap:Body>
				</soap:Envelope>';





$postDataXML = array("postDataXML" => $xml);


		//$postDataXML = array("postDataXML" => $this->GetSaveXML($xmlData,$key_code));
		//
	//	$result = $this->ProcessCurl($postDataXML);
	
			$headers = array(
                        "POST /SOnlineWSQua/WS_SICASOnline.asmx HTTPS/1.1",
                        "Content-Type: text/xml; charset=utf-8",
                        "Accept: text/xml",                        
                        "Host: www.sicasonline.info",
                        "Pragma: no-cache",
                        "SOAPAction: http://tempuri.org/ProcesarWS", 
                        "Content-length: ".$postDataXML,
                    );
	

		$curl = curl_init($ip_zone);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $postDataXML);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $postDataXML);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
		
		if(curl_errno($curl))
		{
			print curl_error($curl);
		}
		else
		{
			$data_curl = curl_exec($curl);
			$fp = fopen('resultadoJason.txt', 'w');
	             fwrite($fp, print_r($data_curl, TRUE));        
	             fclose($fp);
			//var_dump($data_curl);

			//$objectXML = (string)$this->ConverToJson($data_curl);

			$result = json_decode($objectXML);

			
			if(isset($result->Sucess)){
				if ($result->Sucess !== true) {
					if($result->MsgError == "")
						$result->Datos = array();
					else
						throw new Exception('Bad status returned. Something went wrong.');
				}
			}
		}
		 
		curl_close($curl);



	/*	$xmlData = '<InfoData>
			          <DatDocumentos>
			            <IDDocto>' . $IDDocto . '</IDDocto>
			          </DatDocumentos>
			        </InfoData>';
		$key_code = 'HWS_DOCTOS';
		$postDataXML = array("postDataXML" => $this->GetSaveXML($xmlData,$key_code));
		$result = $this->ProcessCurl($postDataXML);




   $data_body = array("Page"			=> "1",
			          "ItemForPage"	    => "500",
			          "KeyCode"  		=> "HWS_VEND",
			          "InfoSort"		=> "CatVendedores.IDVend",			
			          "KeyProcess"   	=> "REPORT",
			          "XML"             => "<InfoData><CatVendedores><IDVend>1</IDVend><Status>0</Status></CatVendedores>",
		              );	
   $datos = $this->webservice_sicasdre->activaAgentes($data_body);	*/

}




	function descargarSicasVendedoresDos(){

		
						/*		$fp = fopen('resultadoJason.txt', 'w');
	             fwrite($fp, print_r($_GET["ultimoInsertado"], TRUE));        
	             fclose($fp);*/

		$data_body = array(
			"Page"			=> "1",
			"ItemForPage"	=> "500",
			"KeyCode"		=> "HWS_VEND",
			"InfoSort"		=> "CatVendedores.IDVend",
			"ConditionsAdd"	=> "Devueltos;5;1;".$_GET["ultimoInsertado"].";".$_GET["ultimoInsertado"].";IDVend",
			//"ConditionsAdd"	=> "Devueltos;0;0;1;1;IDVend",
			"KeyProcess"	=> "REPORT",
		);			
		$datos = $this->webservice_sicasdre->ObtenerDatos($data_body);	
		/*$fp = fopen('resultadoJason.txt', 'w');
	             fwrite($fp, print_r($datos, TRUE));        
	             fclose($fp);*/

$prueba=0;
if($prueba==0){
		foreach($datos->TableInfo as $registro){
	
//		if($registro->EMail1 != ""){
			print($registro->IDVend);
			$IDCont = $registro->IDCont;
			$data	= array('CatContactos'=> array('IDCont'=>$IDCont));
			$data_detalle	= array(
				"KeyProcess"	=> "DATA",
				"KeyCode"		=> "HDATACONTACT",
				"TProc"			=> "Read_Data",
				"XML"			=> $data,
			);

		
	

			$registro_detalles = $this->webservice_sicasdre->ObtenerDatos($data_detalle);		
			switch($registro->Status){
				case 0:
					$Status_TXT = "ACTIVO";
				break;
				case 1:
					$Status_TXT = "INACTIVO";
				break;
				case 2:
					$Status_TXT = "SUSPENDIDO";
				break;
				
				default:
					$Status_TXT = "Sin Status";
				break;
			}
			if(isset($registro_detalles->CatContactos->FechaIniEmpl)){
				$FechaCap = "'".substr(str_replace('T',' ',$registro_detalles->CatContactos->FechaIniEmpl),0,19)."'"; /*quito la palabra celular*/
			} else {
				$FechaCap = "NULL";
			}
			if(isset($registro_detalles->CatContactos->Telefono1)){
				$AddTelefono1_Campo = ", `Telefono1`";
				$AddTelefono1_Regis = ", '".substr($registro_detalles->CatContactos->Telefono1,8)."'";
			} else {
				$AddTelefono1_Campo	= "";
				$AddTelefono1_Regis	= "";
			}
			if(isset($registro_detalles->CatContactos->Telefono2)){
				$AddTelefono2_Campo = ", `Telefono2`";
				$AddTelefono2_Regis = ", '".$registro_detalles->CatContactos->Telefono2."'";
			} else {
				$AddTelefono2_Campo	= "";
				$AddTelefono2_Regis	= "";
			}
			if(isset($registro_detalles->CatContactos->Telefono3)){
				$AddTelefono3_Campo = ", `Telefono3`";
				$AddTelefono3_Regis = ", '".$registro_detalles->CatContactos->Telefono3."'";
			} else {
				$AddTelefono3_Campo	= "";
				$AddTelefono3_Regis	= "";
			}
			if(isset($registro_detalles->CatContactos->Telefono4)){
				$AddTelefono4_Campo = ", `Telefono4`";
				$AddTelefono4_Regis = ", '".$registro_detalles->CatContactos->Telefono4."'";
			} else {
				$AddTelefono4_Campo	= "";
				$AddTelefono4_Regis	= "";
			}
						
			$sql_ActualizaVendedor	= "
				Replace Into
					`catalog_vendedores` 
				(
					`IDVend`,
					`Status`,
					`Status_TXT`,
					`NombreCompleto`,
					`IDDespacho`,
					
					`IDGerencia`,
					`DespNombre`,
					`IDVendNS`,
					`TipoVend`,
					`TipoVend_TXT`,
					
					`GenComision`,
					`RCascade`,
					`IDCatCom`,
					`IDCont`,
					`TipoEnt`,

					`TipoEnt_TXT`,
					`ApellidoP`,
					`ApellidoM`,
					`Nombre`,
					`Edad`,
					
					`Sexo`,
					`Sexo_TXT`,
					`Idioma_TXT`,
					`Clasifica`,
					`Clasifica_TXT`,
					
					`EMail1`,
					`Giro`,
					`Expediente`,
					`FechaNac`,
					`FechaCap`,
					`ClaveBit`
					".$AddTelefono1_Campo."
					".$AddTelefono2_Campo."
					".$AddTelefono3_Campo."
					".$AddTelefono4_Campo."
				)
				VALUES
				(
					'".$registro->IDVend."',
					'".$registro->Status."',
					'".$Status_TXT."',
					'".$registro->NombreCompleto."',
					'".$registro->IDDespacho."',
					
					'".$registro->IDGerencia."',
					'".$registro->DespNombre."',
					'".$registro->IDVendNS."',
					'".$registro->TipoVend."',
					'".$registro->TipoVend_TXT."',
					
					'".$registro->GenComision."',
					'".$registro->RCascade."',
					'".$registro->IDCatCom."',
					'".$registro->IDCont."',
					'".$registro->TipoEnt."',
					
					'".$registro->TipoEnt_TXT."',
					'".$registro->ApellidoP."',
					'".$registro->ApellidoM."',
					'".$registro->Nombre."',
					'".$registro->Edad."',
					
					'".$registro->Sexo."',
					'".$registro->Sexo_TXT."',
					'".$registro->Idioma_TXT."',
					'".$registro_detalles->CatContactos->Clasifica."',
					'".$registro->Clasifica_TXT."',
					
					'".strtoupper($registro->EMail1)."',
					'".$registro_detalles->CatContactos->Giro."',
					'".$registro_detalles->CatContactos->Expediente."',
					'".substr(str_replace('T',' ',$registro_detalles->CatContactos->FechaNac),0,19)."',
					".$FechaCap.",
					'".$registro_detalles->CatContactos->ClaveBit."'
					".$AddTelefono1_Regis."
					".$AddTelefono2_Regis."
					".$AddTelefono3_Regis."
					".$AddTelefono4_Regis."
				);
				########################################################################################
									 ";
			$quer_ActualizaVendedor = $this->db->query($sql_ActualizaVendedor);
			$this->db->query("update catalog_vendedores set catalog_vendedores.IDVendNS=6 where catalog_vendedores.IDVend=".$registro->IDVend);
			$this->db->query("update catalog_vendedores set catalog_vendedores.IDVendNS=7 where catalog_vendedores.IDVend=".$registro->IDVend);
		}
        }
			$data['ListaVendedores']		= $this->capsysdre->ListaVendedores($this->input->get('busquedaUsuario', TRUE));
			$quer_ActualizaVendedor = $this->db->query("select (max(users.IDVend)) as maximo from users ");
			$data['ultimoInsertado']		=$quer_ActualizaVendedor->result()[0]->maximo;
			$this->load->view('configuraciones/listVend', $data);


	}
	function descargarSicasVendedores(){
		
		$data_body = array(
			"Page"			=> "1",
			"ItemForPage"	=> "400",
			"KeyCode"		=> "HWS_VEND",
			"InfoSort"		=> "CatVendedores.IDVend",
			"ConditionsAdd"	=> "",
			"KeyProcess"	=> "REPORT",
		);

	
		$datos = $this->webservice_sicasdre->ObtenerDatos($data_body);

		foreach($datos->TableInfo as $registro){
	
//		if($registro->EMail1 != ""){
			print($registro->IDVend);
			$IDCont = $registro->IDCont;
			$data	= array('CatContactos'=> array('IDCont'=>$IDCont));
			$data_detalle	= array(
				"KeyProcess"	=> "DATA",
				"KeyCode"		=> "HDATACONTACT",
				"TProc"			=> "Read_Data",
				"XML"			=> $data,
			);
			$registro_detalles = $this->webservice_sicasdre->ObtenerDatos($data_detalle);		
			switch($registro->Status){
				case 0:
					$Status_TXT = "ACTIVO";
				break;
				case 1:
					$Status_TXT = "INACTIVO";
				break;
				case 2:
					$Status_TXT = "SUSPENDIDO";
				break;
				
				default:
					$Status_TXT = "Sin Status";
				break;
			}
			if(isset($registro_detalles->CatContactos->FechaIniEmpl)){
				$FechaCap = "'".substr(str_replace('T',' ',$registro_detalles->CatContactos->FechaIniEmpl),0,19)."'"; /*quito la palabra celular*/
			} else {
				$FechaCap = "NULL";
			}
			if(isset($registro_detalles->CatContactos->Telefono1)){
				$AddTelefono1_Campo = ", `Telefono1`";
				$AddTelefono1_Regis = ", '".substr($registro_detalles->CatContactos->Telefono1,8)."'";
			} else {
				$AddTelefono1_Campo	= "";
				$AddTelefono1_Regis	= "";
			}
			if(isset($registro_detalles->CatContactos->Telefono2)){
				$AddTelefono2_Campo = ", `Telefono2`";
				$AddTelefono2_Regis = ", '".$registro_detalles->CatContactos->Telefono2."'";
			} else {
				$AddTelefono2_Campo	= "";
				$AddTelefono2_Regis	= "";
			}
			if(isset($registro_detalles->CatContactos->Telefono3)){
				$AddTelefono3_Campo = ", `Telefono3`";
				$AddTelefono3_Regis = ", '".$registro_detalles->CatContactos->Telefono3."'";
			} else {
				$AddTelefono3_Campo	= "";
				$AddTelefono3_Regis	= "";
			}
			if(isset($registro_detalles->CatContactos->Telefono4)){
				$AddTelefono4_Campo = ", `Telefono4`";
				$AddTelefono4_Regis = ", '".$registro_detalles->CatContactos->Telefono4."'";
			} else {
				$AddTelefono4_Campo	= "";
				$AddTelefono4_Regis	= "";
			}
						
			$sql_ActualizaVendedor	= "
				Replace Into
					`catalog_vendedores` 
				(
					`IDVend`,
					`Status`,
					`Status_TXT`,
					`NombreCompleto`,
					`IDDespacho`,
					
					`IDGerencia`,
					`DespNombre`,
					`IDVendNS`,
					`TipoVend`,
					`TipoVend_TXT`,
					
					`GenComision`,
					`RCascade`,
					`IDCatCom`,
					`IDCont`,
					`TipoEnt`,

					`TipoEnt_TXT`,
					`ApellidoP`,
					`ApellidoM`,
					`Nombre`,
					`Edad`,
					
					`Sexo`,
					`Sexo_TXT`,
					`Idioma_TXT`,
					`Clasifica`,
					`Clasifica_TXT`,
					
					`EMail1`,
					`Giro`,
					`Expediente`,
					`FechaNac`,
					`FechaCap`,
					`ClaveBit`
					".$AddTelefono1_Campo."
					".$AddTelefono2_Campo."
					".$AddTelefono3_Campo."
					".$AddTelefono4_Campo."
				)
				VALUES
				(
					'".$registro->IDVend."',
					'".$registro->Status."',
					'".$Status_TXT."',
					'".$registro->NombreCompleto."',
					'".$registro->IDDespacho."',
					
					'".$registro->IDGerencia."',
					'".$registro->DespNombre."',
					'".$registro->IDVendNS."',
					'".$registro->TipoVend."',
					'".$registro->TipoVend_TXT."',
					
					'".$registro->GenComision."',
					'".$registro->RCascade."',
					'".$registro->IDCatCom."',
					'".$registro->IDCont."',
					'".$registro->TipoEnt."',
					
					'".$registro->TipoEnt_TXT."',
					'".$registro->ApellidoP."',
					'".$registro->ApellidoM."',
					'".$registro->Nombre."',
					'".$registro->Edad."',
					
					'".$registro->Sexo."',
					'".$registro->Sexo_TXT."',
					'".$registro->Idioma_TXT."',
					'".$registro_detalles->CatContactos->Clasifica."',
					'".$registro->Clasifica_TXT."',
					
					'".strtoupper($registro->EMail1)."',
					'".$registro_detalles->CatContactos->Giro."',
					'".$registro_detalles->CatContactos->Expediente."',
					'".substr(str_replace('T',' ',$registro_detalles->CatContactos->FechaNac),0,19)."',
					".$FechaCap.",
					'".$registro_detalles->CatContactos->ClaveBit."'
					".$AddTelefono1_Regis."
					".$AddTelefono2_Regis."
					".$AddTelefono3_Regis."
					".$AddTelefono4_Regis."
				);
				########################################################################################
									 ";
			$quer_ActualizaVendedor = $this->db->query($sql_ActualizaVendedor);
			echo "<pre>";				
				if($quer_ActualizaVendedor){
					echo	"Registro Actualizado <br />".
							" {".$registro->IDVend."}"." [".$registro->EMail1."] (".$registro->NombreCompleto.")".
							" #".$registro_detalles->CatContactos->Expediente."#".
							" -".$registro_detalles->CatContactos->Giro."-";
				}
			echo "</pre>";
//		}
		}
	}/*! descargarSicasVendedores */



}
/* End of file actualizaActividades.php */
/* Location: ./application/controllers/actualizaActividades.php */