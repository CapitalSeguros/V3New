<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

header("Access-Control-Allow-Methods: GET, OPTIONS, PATCH, POST, DELETE");
header("Access-Control-Allow-Origin: * ");
header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding, x-requested-with");

class smsMasivo extends CI_Controller{
	
	 var $globalAbrirMail	= 0;
	 var $precioSms			=  "0.64";
	function __construct(){
		parent::__construct();
		$this->load->helper(array('form', 'url','ckeditor','email'));
		$this->load->model(array('emailmasivo_model','catalogos_model','saldo_model','personamodelo'));
		$this->load->library(array('form_validation','webservice_sicas','webservice_sicas_soap','role','localfileuploader', 'WhatsSMS'));	
	}

	function getReporte(){

		$data = $this->emailmasivo_model->getReporte($this->tank_auth->get_usermail());
		echo json_encode(array(
				 		'recordsTotal'=> count($data),
				 		'recordsFiltered'=> count($data),
				 		'data'=> $data,
				 		));			
	}

	function getReporteDetalle(){
		$asunto = $this->input->post('asunto');
		$data = $this->emailmasivo_model->getReporteDetalle($asunto);
		echo json_encode(array(
				 		'recordsTotal'=> count($data),
				 		'recordsFiltered'=> count($data),
				 		'data'=> $data,
				 		));			

	}

	function Autenticacion()
	{
$params = array("apikey" => '9e98e1d329a87695759e0e0fdafa2e454832a224');
curl_setopt_array($ch = curl_init(), array(
  CURLOPT_URL => "https://api.smsmasivos.com.mx/auth",
  CURLOPT_SSL_VERIFYPEER => 0,
  CURLOPT_POST => 1,
  CURLOPT_POSTFIELDS => http_build_query($params),
  CURLOPT_RETURNTRANSFER => 1
));
$response = curl_exec($ch);
curl_close($ch);

echo json_encode($response);
	}

	function sendMesage($numbers=0000000000, $message=false)
	{
		$sendMesage	= false;
		$search		= array('{', '}', '"');
		$replace	= array('', '', '');		
		$params = array("message" => $message,"numbers" => $numbers,"country_code" => '052');
		$headers = array(
			"token: SMS eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyX2FwaWtleSI6IjllOThlMWQzMjlhODc2OTU3NTllMGUwZmRhZmEyZTQ1NDgzMmEyMjQiLCJ1c2VyX2VtYWlsIjoibWVzYWRlY29udHJvbEBhZ2VudGVjYXBpdGFsLmNvbSIsInVzZXJfaWQiOjM1MDYsImlhdCI6MTU4MTkzNzcyNH0.mKWkVh_aGC09Fj8j2YiKbYdUJP4RWG1oOSZVtlNS_Zc"
		);
		
		curl_setopt_array($ch = curl_init(), array(
			CURLOPT_URL => "https://api.smsmasivos.com.mx/sms/send",
			CURLOPT_SSL_VERIFYPEER => 0,
			CURLOPT_HEADER => 0,
			CURLOPT_HTTPHEADER => $headers,
			CURLOPT_POST => 1,
			CURLOPT_POSTFIELDS => http_build_query($params),
			CURLOPT_RETURNTRANSFER => 1
		));
	
		$response = curl_exec($ch);
		curl_close($ch);
		
		$result = explode(",", str_replace($search, $replace, $response));
		$result = explode(":", str_replace($search, $replace, $result[0]));
		
		//echo json_encode($response);
		
		if($result[1] == "true")
		{
			//echo "Guardamos en DBA";
			$sendMesage = true;
		}

		return
			$sendMesage;
	}


	function ChecaCredito()
	{
		$headers = array(
			"token: SMS eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyX2FwaWtleSI6IjllOThlMWQzMjlhODc2OTU3NTllMGUwZmRhZmEyZTQ1NDgzMmEyMjQiLCJ1c2VyX2VtYWlsIjoibWVzYWRlY29udHJvbEBhZ2VudGVjYXBpdGFsLmNvbSIsInVzZXJfaWQiOjM1MDYsImlhdCI6MTU4MTkzNzcyNH0.mKWkVh_aGC09Fj8j2YiKbYdUJP4RWG1oOSZVtlNS_Zc"
						);
		curl_setopt_array($ch = curl_init(), array(
			CURLOPT_URL => "https://api.smsmasivos.com.mx/credits/consult",
			CURLOPT_SSL_VERIFYPEER => 0,
			CURLOPT_HEADER => 0,
			CURLOPT_HTTPHEADER => $headers,
			CURLOPT_POST => 1,
			CURLOPT_POSTFIELDS => http_build_query(array()),
			CURLOPT_RETURNTRANSFER => 1
		));
		$response = curl_exec($ch);
		curl_close($ch);

		echo json_encode($response);
    }
	
	function descuentaSaldo($idUser)
	{
		$precioSms = $this->precioSms;
		$sql = "
				Update
					`envio_saldo`
				Set
					`saldo` = `saldo` - ".$precioSms."
				Where
					`idUser` = '".$idUser."'
			   ";
		$this->db->query($sql);
	}
	
function envio(){
	$filename = getcwd()."/../xml/config.xml";
      $response = "";
      $params = array("apikey" => "9e98e1d329a87695759e0e0fdafa2e454832a224");
      curl_setopt_array($ch = curl_init(), array(
        CURLOPT_URL => "https://api.smsmasivos.com.mx/auth",
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => http_build_query($params),
        CURLOPT_RETURNTRANSFER => 1
      ));
      $response = curl_exec($ch);
      curl_close($ch);
      $response_obj = json_decode($response, true);
      $text = "PRUEBA DE CARLOS CERVERA";
      $number = "9991463862"; 
      $country = "52";
      $name = "CARLOS CERVERA";
      $sandbox = "0";

      if($name == ""){$name = "Escribe un nombre para tu campaña ".date("Y-m-d H:i:s");}
      $params = array("message" => $text,"numbers" => $number,"country_code" => $country,"name" => $name,"sandbox" => $sandbox);
     $headers = array("token: ".$response_obj['token']);

      curl_setopt_array($ch = curl_init(), array(
        CURLOPT_URL => "https://api.smsmasivos.com.mx/sms/send",
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_HEADER => 0,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => http_build_query($params),
        CURLOPT_RETURNTRANSFER => 1
      ));
      $response = curl_exec($ch);
      curl_close($ch);
    // $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($response, TRUE));fclose($fp);


	




}
	function EnviaSMS()
	{	
                $cadenanumeros=$this->input->post('areaTelefonos');
                $mensaje=$this->input->post('smsText');
                //$numeros=str_replace("#"," ",$cadenanumeros);
           
      $numeroind=explode("#", $cadenanumeros);              
         if($mensaje!=""){
	$filename = getcwd()."/../xml/config.xml";
      $response = "";
      $params = array("apikey" => "9e98e1d329a87695759e0e0fdafa2e454832a224");
        curl_setopt_array($ch = curl_init(), array(
        CURLOPT_URL => "https://api.smsmasivos.com.mx/auth",
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => http_build_query($params),
        CURLOPT_RETURNTRANSFER => 1
      ));
      $response = curl_exec($ch);
      curl_close($ch);
      $response_obj = json_decode($response, true);
      //$text = "PRUEBA DE CARLOS CERVERA";
      //$number = "9991463862"; 
      $country = "52";
      $name = "CAPITAL SEGUROS Y FIANZAS";
      $sandbox = "0";
      foreach ($numeroind as  $value) {
      	  if(!empty($value)){
      
      if($name == ""){$name = "Escribe un nombre para tu campaña ".date("Y-m-d H:i:s");}
      $params = array("message" => $mensaje,"numbers" => $value,"country_code" => $country,"name" => $name,"sandbox" => $sandbox);
     $headers = array("token: ".$response_obj['token']);

      curl_setopt_array($ch = curl_init(), array(
        CURLOPT_URL => "https://api.smsmasivos.com.mx/sms/send",
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_HEADER => 0,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_POST => 1,
        CURLOPT_POSTFIELDS => http_build_query($params),
        CURLOPT_RETURNTRANSFER => 1
      ));
      $response = curl_exec($ch);
      curl_close($ch);
     // $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($response, TRUE));fclose($fp);
      }
    }
      	
            
         }

/*                foreach ($numeroind as $key => $value) {

                	  if(!empty($value))
                	  {	
                        	curl_setopt_array($ch = curl_init(), array(
                            CURLOPT_URL => "https://www.smsmasivos.com.mx/sms/api.envio.new.php",
                            CURLOPT_POST => TRUE,
                            CURLOPT_RETURNTRANSFER => TRUE,
                            CURLOPT_POSTFIELDS => array("apikey" => "9e98e1d329a87695759e0e0fdafa2e454832a224","mensaje" => $mensaje,"numcelular" => $value,"numregion" => "52"))
                        	);
                        	$respuesta=curl_exec($ch);
                        	curl_close($ch);
                       	 	$respuesta=json_decode($respuesta);
                       
                        
                			echo "Mensaje: " .$mensaje. " enviado a: ".$value.""; 
                	}		
                }*/


	}


function mandaBasura(){
		$basura='update clientes_actualiza set basuraSMSEmail=1 where IDCli='.$_GET['id'];
		$basura=$basura.' and EstadoActual="ELIMINADO"';
       $this->db->query($basura);
 $this->globalAbrirMail=1;
		$this->index();
	}



	function index(){		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			//var_dump($_REQUEST);
 			//$this->bitly(json_encode('https://www.sicasonline.info/SICASData/SICAS1325/Storage/CONT000000774/Cliente/DOC000115707/OTROS_DOCUMENTOS-INFORMACION%20-201903291804.xlsx'));
					
			$data['user_id']		= $this->tank_auth->get_user_id();
			$data['username']		= $this->tank_auth->get_username();
			$data["paraTelefonos"]	= $this->input->post('paraTelefonos'); 
			$data["smsText"]		= $this->input->post('smsText');
			$data["saldo"]			= $this->saldo_model->saldo($this->tank_auth->get_user_id());
			
			
			if($this->input->post('paraTelefonos') != "" && $this->input->post('paraTelefonos') != "Destinatario" ){
				$this->form_validation->set_rules('paraTelefonos', 'Destinatarios', 'trim');
			}				

			$config = array(
               
			   /*
               array(
                     'field'   => 'paraTelefonos', //'asunto', 
                     'label'   => 'Destinatario', 
                     'rules'   => 'required'
                  ),
				*/
               array(
                     'field'   => 'smsText', //'mensaje', 
                     'label'   => 'Mensaje', 
                     'rules'   => 'required'
                  )
            );
			
			if($this->input->post('paraTelefonos') == "Destinatario") 	$this->post_get_clean('paraTelefonos',"");
			if($this->input->post('smsText') == "Mensaje")	$this->post_get_clean('smsText',"");
						
			$this->form_validation->set_rules($config);		
			$this->form_validation->set_message('required', 'El valor %s es requerido');
			$this->form_validation->set_message('valid_emails', 'El valor de %s no puede ser vacio &oacute; el formato es incorrecto');			
			
			$data_role_ = array(
				"IdTipoUser" => $this->tank_auth->get_user_id(),
				"Profile" =>  $this->tank_auth->get_userprofile()
			);
			
			$name_tab = $this->emailmasivo_model->get_dataEmail($data_role_);
            $name_tab=$this->personamodelo->clasificacionUsuariosParaEnvios();
			$array_cliente = array();
			
			$data['Cliente'] = array();
			$data['Catalogo_Perfiles'] = $name_tab;
			$data['userProfile']=$this->tank_auth->get_userprofile();
			
			$data_val = array(
								"id" => $this->tank_auth->get_user_id(),
								"role" => $this->tank_auth->get_userprofile());
								
			$data ["EmailScriptJS"] = $this->is_role($this->tank_auth->get_userprofile(), $data_val);

			if($this->globalAbrirMail==1){$data["abrirEmail"] = 1;}
			 			
			if (!$this->form_validation->run())
			{			
				$data['user_id']	= $this->tank_auth->get_user_id();
				$data['username']	= $this->tank_auth->get_username();				
				
				// ** //
				foreach($data["Catalogo_Perfiles"] as $registro)
				{	
					//echo $registro["email"];
				}
				// ** //
				
				//$this->load->view('mailMasivo/principal', $data);
				$this->load->view('sms/principal', $data);
			}
			else 
			{
				$guests = "";
			
				$save = false;
				
				if($this->input->post("paraTelefonos") != ""){
					
					// var_dump($this->input->post("guests"));
					if(!$this->input->post("guests")){
						$save = true;
					}else{
						$guests = $this->email_guest($this->input->post("guests"),1);
						$save = true;
					}
					
				}else{
					
					// var_dump($this->input->post("guests"));
					if(!$this->input->post("guests")){$save = false;}
					else
					{
						$guests = $this->email_guest($this->input->post("guests"),0);
						$save = true;
					}					
				}
				
				if($save){
					/* -JjHe- */
					$paras = explode(',', $this->input->post('paraTelefonos').rtrim($guests, ','));					
					foreach($paras as $para){
						
						$data_insert = array(
							'envia'		=> $this->tank_auth->get_usernamecomplete()." <".$this->tank_auth->get_usermail().">",
							'idUser'	=> $this->tank_auth->get_user_id(),
							'name'		=> '',
							'numbers'	=> rtrim(ltrim($para)),
							'message'	=> $this->input->post('smsText'),
						);

						if($this->Insert_SMS_masivo($data_insert) && $this->sendMesage($data_insert['numbers'],$data_insert['message'])){
							
							$this->descuentaSaldo($data_insert['idUser']);
							$message				= "Se envio correctamente el SMS masivo";
							$alert					= "Exitoso!";
							$alert_class			= "alert-success";
							
							$data["paraTelefonos"]	= "";
							$data["smsText"]		= "";
							
							//** redirect('/V3/smsMasivo/');
							
						}else{
							$message		= "Ocurrio un error durante la transacción, intente de nuevo";
							$alert			= "Advertencia!";
							$alert_class	= "alert-warning";
						}
					}
				}else{
					$message		= "El Destinatario es requerido.";
					$alert			= "Advertencia!";
					$alert_class	= "alert-danger";
				}

				$data["message"]		= $message;
				$data["alert"]			= $alert;
				$data["alert_class"]	= $alert_class;	

				$this->load->view('sms/principal', $data);
			}
		}
	}
	
	function post_get_clean($key,$value){
		if($key !== NULL AND ! empty($_POST)){
			$_POST[$key] = $value;
		}
	}

////////
	function Insert_SMS_masivo($data){		
		$exito = false;
		
		try{
			$exito = $this->Insert_envio_sms($data);	
			//** var_dump($data);	
			
		}catch(Exception $e){
			
		}
		return $exito;
	}


	function Insert_envio_sms($data){
		
		$insert_value = false;
		
		try{
			
			$this->db->trans_begin();
			
			
			$hoy = new DateTime('now');
			$date = $hoy->format("Y-m-d H:i:s");
			
			$old = new DateTime('1900-01-01 00:00:00');
			$datesend = $old->format("Y-m-d H:i:s");

			$data_table = array(
					'fechacreacion' => $date,
					// 'desde' => 'CAPSYS Web <do-not-reply@capsys.com.mx>',
					'envia'			=> $data["envia"], 
					'idUser'		=> $data["idUser"],
					'message'		=> $data["message"],
					'country_code'	=> '52',
					'numbers'		=> $data["numbers"],
					'status'	=> '0',
					'fechaEnvio' => $datesend
			);
			
			$this->db->insert('envio_sms', $data_table);
			
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
			}
			else
			{
				$this->db->trans_commit();
				$insert_value = true;
			}

		}catch(Exception $e){
			
		}
		
		return $insert_value;
	}
///////	
	

	function get_EmailFor(){
		$result = array();
		
		try{
			
			$this->load->model('emailmasivo_model');
			$result = $this->emailmasivo_model->get_CabInvitados();		
			
		}catch(Exception $e){
			
		}
		
		return $result;
	}
	
	public function get_Agerente(){
		
		try{
				
			$this->load->model('emailmasivo_model');
			$data = array("alias"=>"gerente");
			$result = $this->emailmasivo_model->get_alias($data);			
			
		}catch(Exception $e){
			
		}
		
		return $result;
		
	}
	
	public function get_Aejecutivo(){
		
		try{
				
			$this->load->model('emailmasivo_model');
			$data = array("alias"=>"ejecutivo");
			$result = @$this->emailmasivo_model->get_alias($data);			
			
		}catch(Exception $e){
			
		}
		
		return $result;
		
	}
	
	public function get_Apromotor(){
		
		try{
				
			$this->load->model('emailmasivo_model');
			$data = array("alias"=>"promotor");
			$result = @$this->emailmasivo_model->get_alias($data);			
			
		}catch(Exception $e){
			
		}
		
		return $result;
		
	}
	
	public function get_Avendedor(){
		
		try{
				
			$this->load->model('emailmasivo_model');
			$data = array("alias"=>"vendedor");
			$result = @$this->emailmasivo_model->get_alias($data);			
			
		}catch(Exception $e){
			
		}
		
		return $result;
		
	}
	
	public function get_AvendedorPromotor($data){
		
		try{		
			
			$this->load->model('emailmasivo_model');
			
			if(is_array($data)){
				$result = $this->emailmasivo_model->get_Promotor_get_Vendedores($data);
			}
			
		}catch(Exception $e){
			
		}
		return $result;
	}
	
	public function getClientes()
	{
		try
		{
			$IdVend = $_REQUEST["IDVend"];
			//var_dump($IdVend);
			//return;
			$clientes = $this->webservice_sicas_soap->GetClient_forIdVend(array( "IdVend" => $IdVend));

			$result_ = array();

			if($clientes["clientes"] != NULL)
			{	
				foreach ($clientes["clientes"] as $data) 
				{
					if (isset($data->EMail1) && strlen($data->EMail1) > 5)
					{

						if(!empty($data->URL)){

							$IDSRamos = explode('|', $data->URL);

							foreach ($IDSRamos as $value) {
								if(!array_key_exists($value, $result_)){
									$SRamo = $this->catalogos_model->get_NameSubRamo($value);

									$result_[$value] = array(
														'id' => $value,
														'sramo' => $SRamo[0]['nombre'],
														'data' => array(
																	$data));
								}else{
									array_push($result_[$value]['data'], $data);
								}
							}

					  	}else{
					  		if(!array_key_exists('54', $result_)){
					  			$result_['54'] = array('id'=>'54', 'sramo'=>'SIN RAMO','data' =>array($data));		
					  		}else{
					  			array_push($result_['54']['data'] , $data);
					  		}
					  		
					  	}
					}
				}
			}

			echo json_encode($result_);
			// return;
		}
		catch(Exception $e)
		{
			
		}

	}
	
	function Create_array_table($data){
		
		$result = $this->webservice_sicas_soap->GetClient($data);
		$result_ = array();
		
		

		if($result != NULL){
			
			foreach ($result as $data) {
			  $Grupo = $data->Grupo . ' ' . $data->SubGrupo;
			  if (isset($result_[$Grupo])) {
				 $result_[$Grupo][] = $data;
			  } else {
				 $result_[$Grupo] = array($data);
			  }
			}
		}
		
	
		// var_dump($result_);
		// foreach ($result as $data) {
		  // $id = $data->['id'];
		  // if (isset($result[$id])) {
			 // $result[$id][] = $data;
		  // } else {
			 // $result[$id] = array($data);
		  // }
		// }
		
		return $result_;
	}
	function callback_email_available($email){
		if(isset($_POST[$email]))
			return true;		
	}
	function email_guest($val,$ban = 0){
		$guests = "";
		if($ban == 1){
			$guests .= ",";
		}
		foreach($val as $guest){
			$guests .= $guest . ",";
		}
		
		return $guests;
	}
	
	public function is_role($role, $data_val){
		
		$data = array();
		
		try{
			$this->load->model('emailmasivo_model');
			$data = $this->emailmasivo_model->get_CabInvitados($data_val);
			
		}catch(Exception $e){
			
		}
		
		return $data;
		
	}
	
	public function is_role_show_tab($sRole){
		$role = array();
		switch(strtoupper($sRole)){
			case "MASTER":
			
			$role = array(
				"all" => true,				
				"gerente" => true,
				"ejecutivo" => true,
				"promotor" => true,
				"vendedor" => true, 
				"clientes" => true,
				"vendedorpromotor" => true
				);
				
			break;
			case "PROMOTOR":
			$role = array(
					"all" => false,
					"gerente" => false,
					"ejecutivo" => false,
					"promotor" => false,
					"vendedor" => true, 
					"clientes" => true,
					"vendedorpromotor" => true);
			break;
			case "VENDEDOR":
				$role = array(
					"all" => false,
					"gerente" => false,
					"ejecutivo" => false,
					"promotor" => false,
					"vendedor" => false, 
					"clientes" => true,
					"vendedorpromotor" => false);
			break;
			default:
				$role = array(
					"all" => false,
					"gerente" => false,
					"ejecutivo" => false,
					"promotor" => false,
					"vendedor" => false, 
					"clientes" => false,
					"vendedorpromotor" => false);
			break;
		}
		
		return $role;
	}
	//-------------------------------- //New sms api service for url request
	public function sendVerificationNumber(){

		if(!in_array($_SERVER["REQUEST_METHOD"], ["POST", "OPTIONS"])){ //$_SERVER["REQUEST_METHOD"] !== "POST"

			//echo json_encode(array("error" => "No es posible realizar la solicitud de mensajería con una petición: ".$_SERVER["REQUEST_METHOD"]));
			$this->output
			->set_content_type("application/json")
			->set_status_header(401)
			->set_output(
				json_encode(array("error" => "No es posible realizar la solicitud de mensajería con una petición: ".$_SERVER["REQUEST_METHOD"]), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
			)
			->_display();
		exit;
		}

		if($_SERVER["REQUEST_METHOD"] == "OPTIONS"){
			die;
		}

		$postParams = json_decode(file_get_contents("php://input"), true);
		$verificationCode = rand(100000, 999999);
		$message = "<AGENTE CAPITAL SEGUROS Y FIANZAS> Tu código de verificación es: ".$verificationCode.". El código expirará en 5 minutos. Por favor no lo compartas.";
		$postParams["message"] = $message;
		$smsResponse = $this->whatssms->sendSMSV2($postParams);

		//if($smsResponse["success"] == "true")
		//echo json_encode($smsResponse);
		//die;
		$this->output
			->set_content_type("application/json")
			->set_status_header($smsResponse["success"] ? 200 : 400)
			->set_output(
				json_encode(($smsResponse["success"] ? 
					array("code" => base64_encode($verificationCode)) :
					array("error" => "Ocurrió un detalle en el proceso de envío de verificación. Por favor, intentelo más tarde.")
				), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
			)
			->_display();
		exit;
		//echo $smsResponse["success"] ? json_encode(array("code" => base64_encode($verificationCode))) : json_encode(array("error" => "Ocurrió un detalle en el proceso de envío de verificación. Por favor, intentelo más tarde."));
	}
	//--------------------------------
}

/* End of file mailMasivo.php */
/* Location: ./application/controllers/mailMasivo.php */