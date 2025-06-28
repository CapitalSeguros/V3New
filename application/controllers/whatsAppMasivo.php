<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class whatsAppMasivo extends CI_Controller{
	
	 var $globalAbrirMail	= 0;
	 var $precioSms			=  "0.78";
	function __construct(){
		parent::__construct();
		$this->load->helper(array('form', 'url','ckeditor','email'));
		$this->load->model(array('emailmasivo_model','catalogos_model'));
		$this->load->library(array('form_validation','webservice_sicas','webservice_sicas_soap','role','localfileuploader'));	
	}
			
	function index(){		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
					
			$data['user_id']		= $this->tank_auth->get_user_id();
			$data['username']		= $this->tank_auth->get_username();
			$data["paraTelefonos"]	= $this->input->post('paraTelefonos'); 
			$data["smsText"]		= $this->input->post('smsText');
			$data["saldo"]			= $this->saldo_model->saldo($this->tank_auth->get_user_id());
			
			
			if($this->input->post('paraTelefonos') != "" && $this->input->post('paraTelefonos') != "Destinatario" ){
				$this->form_validation->set_rules('paraTelefonos', 'Destinatarios', 'trim');
			}				

			$config = array(
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
				}
				// ** //
				
				//** $this->load->view('sms/principal', $data);
				$this->load->view('whatsapp/principal', $data);
				
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
					if(!$this->input->post("guests")){
						$save = false;
					}else{
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

						if($this->Insert_Whats_masivo($data_insert) && $this->sendMesage($data_insert['numbers'],$data_insert['message'])){
							
							$this->descuentaSaldo($data_insert['idUser']);
							$message				= "Se envio correctamente el SMS masivo";
							$alert					= "Exitoso!";
							$alert_class			= "alert-success";
							
							$data["paraTelefonos"]	= "";
							$data["smsText"]		= "";
							
							//** redirect('/V3/whatsAppMasivo/');
							
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

				//** $this->load->view('sms/principal', $data);
				$this->load->view('whatsapp/principal', $data);
			}
		}
	}
	
	public function sendMesage($numberPhone=0000000000,$mesageBody=false)
	{
		$sendMesage	= false;
		$search		= array('{', '}', '"');
		$replace	= array('', '', '');

		$claveInternacional = '052';
		$data	= [
					'phone' => $claveInternacional.$numberPhone, // Receivers phone
					'body'	=> $mesageBody, // Message
				  ];

		$json	= json_encode($data); // Encode data to JSON
		
		// URL for request POST /message
		$url	= 'https://eu72.chat-api.com/instance99658/message?token=2kfq4cl28506knus';
		
		// Make a POST request
		$options	= stream_context_create(['http' => [
															'method'  => 'POST',
															'header'  => 'Content-type: application/json',
															'content' => $json
													   ]
											]);
		// Send a request
		$result = file_get_contents($url, false, $options);

		$result = explode(",", str_replace($search, $replace, $result));
		$result = explode(":", str_replace($search, $replace, $result[0]));

		// Validamos Respuesta
		if($result[1] == "true")
		{
			//echo "Guardamos en DBA";
			$sendMesage = true;
		}

		return
			$sendMesage;
	}
	
	function Insert_Whats_masivo($data){		
		$exito = false;
		
		try{
			$exito = $this->Insert_envio_whats($data);	
			//** var_dump($data);	
			
		}catch(Exception $e){
			
		}
		return $exito;
	}


	function Insert_envio_whats($data){
		
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
			
			$this->db->insert('envio_whats', $data_table);
			
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
}

/* End of file mailMasivo.php */
/* Location: ./application/controllers/mailMasivo.php */