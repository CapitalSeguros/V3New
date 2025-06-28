<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class mailMasivo extends CI_Controller{
 var $globalAbrirMail=0;
	function __construct(){
		parent::__construct();
		$this->load->helper(array('form', 'url','ckeditor','email'));
		$this->load->model(array('emailmasivo_model','catalogos_model','personamodelo'));
		$this->load->library(array('form_validation','webservice_sicas','webservice_sicas_soap','role','localfileuploader'));
	}

//----------------------------------------------------------------------
	function getReporte(){
	
		$data = $this->emailmasivo_model->getReporte($this->tank_auth->get_usermail());

		echo json_encode(array(
				 		'recordsTotal'=> count($data),
				 		'recordsFiltered'=> count($data),
				 		'data'=> $data,
				 		));			
	}
//----------------------------------------------------------------------
	function getReporteDetalle(){ //Modificado [Suemy][2024-08-16]
		$asunto = $this->input->post('asunto');
		$desde = $this->input->post('desde');
		$data = $this->emailmasivo_model->getReporteDetalle($asunto,$desde);
		echo json_encode(array(
				 		'recordsTotal'=> count($data),
				 		'recordsFiltered'=> count($data),
				 		'data'=> $data,
				 		));			
	}
//----------------------------------------------------------------------
	function mandaBasura(){
		$basura='update clientes_actualiza set basuraSMSEmail=1 where IDCli='.$_GET['id'];
		$basura=$basura.' and EstadoActual="ELIMINADO"';
       $this->db->query($basura);
$this->globalAbrirMail=1;
		$this->index();
	}
//----------------------------------------------------------------------

function index()
{		
	if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
	else 
	{				
      $usuariosPermitidos=array('DIRECTORGENERAL@AGENTECAPITAL.COM','GERENTEFINANCIERO@CAPITALSEGUROS.COM.MX','DIRECTORCOMERCIAL@AGENTECAPITAL.COM','MARKETING@AGENTECAPITAL.COM','ASISTENTEDIRECCION@AGENTECAPITAL.COM','GERENTECOMERCIAL@AGENTECAPITAL.COM');
	 if(in_array($this->tank_auth->get_usermail(),$usuariosPermitidos))
     {
	 $data['user_id']	= $this->tank_auth->get_user_id();
	 $data['username']	= $this->tank_auth->get_username();
	  $data['ckeditor'] = array('id'=>'content','path'=>'assets/js/ckeditor',);						
	 if($this->input->post('para') != "" && $this->input->post('para') != "Para" ){$this->form_validation->set_rules('para', 'correo ("Para")', 'trim|valid_emails');}
	 if($this->input->post('cc') != "" && $this->input->post('cc') != "Cc"){$this->form_validation->set_rules('cc', 'correo ("Cc")', 'trim|valid_emails');}
	 if($this->input->post('bcc') != "" && $this->input->post('bcc') != "Bcc"){$this->form_validation->set_rules('bcc', 'correo ("Bcc")', 'trim|valid_emails');}
	  $config = array(               
               array('field'   => 'asunto', 'label'   => 'Asunto', 'rules'   => 'required'),
               array('field'   => 'mensaje', 'label'   => 'Mensaje', 'rules'   => 'required')
            );
			
			if($this->input->post('asunto') == "Asunto") 	$this->post_get_clean('asunto',"");
			if($this->input->post('mensaje') == "Mensaje")	$this->post_get_clean('mensaje',"");
						
			$this->form_validation->set_rules($config);		
			$this->form_validation->set_message('required', 'El valor %s es requerido');
			$this->form_validation->set_message('valid_emails', 'El valor de %s no puede ser vacio &oacute; el formato de email es incorrecto');			

			
			$data_role_ = array("IdTipoUser" => $this->tank_auth->get_user_id(),"Profile" =>  $this->tank_auth->get_userprofile());			
			$name_tab = $this->emailmasivo_model->get_dataEmail($data_role_);
			$name_tab=$this->personamodelo->clasificacionUsuariosParaEnvios();
           $array_cliente = array();
			
			$data['Cliente'] = array();
			$data['Catalogo_Perfiles'] = array_filter($name_tab, function($arr){ return $arr["Name"] != "Marketing proyecto 100";}); //$name_tab;
			$data['userProfile']=$this->tank_auth->get_userprofile();			
			
			$data_val = array("id" => $this->tank_auth->get_user_id(),"role" => $this->tank_auth->get_userprofile());
								
			$data ["EmailScriptJS"] = $this->is_role($this->tank_auth->get_userprofile(), $data_val);

			if($this->globalAbrirMail==1){$data["abrirEmail"] = 1;}	
			 			
			if (!$this->form_validation->run())
			{			
				$data['user_id']	= $this->tank_auth->get_user_id();
				$data['username']	= $this->tank_auth->get_username();		
                						
				$this->load->view('mailMasivo/principal', $data);
			}
			else 
			{
				$guests = "";
			
				$save = false;
				
				if($this->input->post("para") != "")
				{
					if(!$this->input->post("guests")){$save = true;}
					else
					{
						$guests = $this->email_guest($this->input->post("guests"),1);
						$save = true;
					}
					
				}
				else
				{
                 if(!$this->input->post("guests")){$save = false;}
                 else{
						$guests = $this->email_guest($this->input->post("guests"),0);
						$save = true;
					}					
				}				
				if($save)
				{					
					$paras = explode(',', $this->input->post('para').rtrim($guests, ','));
					foreach($paras as $para){
						$data_insert = array(
							'desde' => $this->tank_auth->get_usernamecomplete()." <".$this->tank_auth->get_usermail().">",
							'para' => rtrim(ltrim($para)), //$this->input->post('para').$guests,
							'cc' => $this->input->post('cc'),
							'bcc' => $this->input->post('bcc'),
							'asunto' => $this->input->post('asunto'),
							'mensaje' => $this->input->post('mensaje'),
							'archivoAdjunto' => "",
							'nameArchivo' => "",
						);

						if($this->Insert_email_masivo($data_insert))
						{
							$message = "Se guardo correctamente el email masivo";
							$alert = "Exitoso!";
							$alert_class = "alert-success";
						}
						else
						{
							$message = "Ocurrio un error durante la transacciÃ³n, intente de nuevo";
							$alert = "Advertencia!";
							$alert_class = "alert-warning";
						}
					}
				}
				else
				{
					$message = "El correo es requerido.";
					$alert = "Advertencia!";
					$alert_class = "alert-danger";
				}

				$data["message"] = $message;
				$data["alert"] = $alert;
				$data["alert_class"] = $alert_class;	
				$this->load->view('mailMasivo/principal', $data);
			}
		 }
		 else
		 {
			redirect(base_url());
		 }
			
		}
	}
//----------------------------------------------------------------------	
	function post_get_clean($key,$value){
		if($key !== NULL AND ! empty($_POST)){
			$_POST[$key] = $value;
		}
	}
//----------------------------------------------------------------------
	function Insert_email_masivo($data){
		
		$exito = false;
		
		try{
			
			$this->load->model('emailmasivo_model');
			$exito = $this->emailmasivo_model->Insert_envio_correos($data);		
			
		}catch(Exception $e){
			
		}
		return $exito;
	}
//----------------------------------------------------------------------
	public function upload()
    {
        $callback = 'null';
        $url = '';
        $get = array();
 
        // for form action, pull CKEditorFuncNum from GET string. e.g., 4 from
        // /ckeditor-form/upload?CKEditor=content&CKEditorFuncNum=4&langCode=en
        // Convert GET parameters to PHP variables
        $qry = $_SERVER['REQUEST_URI'];
        parse_str(substr($qry, strpos($qry, '?') + 1), $get);
 
        if (!isset($_POST) || !isset($get['CKEditorFuncNum'])) {
            $msg = 'CKEditor instance not defined. Cannot upload image.';
        } else {
            $callback = $get['CKEditorFuncNum'];
 
            try {
                $fileUploader = new localfileuploader();
                $url = $fileUploader->moveFile($_FILES['upload']);
                $url2 = $url;

                $url = str_replace('\\', '/', $url);
                $url = substr($url, 1);
				
                $msg = "File uploaded successfully to: {$url}";
				$url = utf8_decode($url);
            } catch (Exception $e) {
                $url = '';
                $msg = $e->getMessage();
            }
        }
 
        // Callback function that inserts image into correct CKEditor instance
        $output = '<html><body><script type="text/javascript">' .
            'window.parent.CKEDITOR.tools.callFunction(' .
            $callback .
            ', "' .
            str_replace('%2F','/',$url) .
            '", "' .
            $msg .
            '");
			</script></body></html>';
 
        echo $output;
    }
//----------------------------------------------------------------------	
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
//----------------------------------------------------------------------	
	public function get_Aejecutivo(){
		
		try{
				
			$this->load->model('emailmasivo_model');
			$data = array("alias"=>"ejecutivo");
			$result = @$this->emailmasivo_model->get_alias($data);			
			
		}catch(Exception $e){
			
		}
		
		return $result;
		
	}
//----------------------------------------------------------------------	
	public function get_Apromotor(){
		
		try{
				
			$this->load->model('emailmasivo_model');
			$data = array("alias"=>"promotor");
			$result = @$this->emailmasivo_model->get_alias($data);			
			
		}catch(Exception $e){
			
		}
		
		return $result;
		
	}
//----------------------------------------------------------------------	
	public function get_Avendedor(){
		
		try{
				
			$this->load->model('emailmasivo_model');
			$data = array("alias"=>"vendedor");
			$result = @$this->emailmasivo_model->get_alias($data);			
			
		}catch(Exception $e){
			
		}
		
		return $result;
		
	}
//----------------------------------------------------------------------	
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
//----------------------------------------------------------------------	
	public function getClientes() //Modificado [Suemy][2024-08-16]
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

						if(!empty($data->URL) && stripos($data->URL,'|')){

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
//----------------------------------------------------------------------	
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
//----------------------------------------------------------------------
	function callback_email_available($email){
		if(isset($_POST[$email]))
			return true;		
	}
//----------------------------------------------------------------------	
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
//----------------------------------------------------------------------	
	public function is_role($role, $data_val){
		
		$data = array();
		
		try{
			$this->load->model('emailmasivo_model');
			$data = $this->emailmasivo_model->get_CabInvitados($data_val);
			
		}catch(Exception $e){
			
		}
		
		return $data;
		
	}
//----------------------------------------------------------------------	
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
//----------------------------------------------------------------------	
		function grabaEmailCapsysContacto(){
		$guardar['desde']='Avisos de CAPSYS MARKETING<avisosgap@aserorescpital.com>';
		$guardar['para']='MARKETING@AGENTECAPITAL.COM';
		$guardar['copia']='0';
		$guardar['copiaOculta']='0';
		$guardar['asunto']=$_POST['defaults']['0']['value'].'-Nombre:'.$_POST['defaults']['1']['value'].'-Telefono:'.$_POST['defaults']['1']['value'];
		$guardar['mensaje']=$_POST['defaults']['3']['value'];
		$guardar['status']='0';
		$this->db->insert('envio_correos',$guardar);
		

	}
}

/* End of file mailMasivo.php */
/* Location: ./application/controllers/mailMasivo.php */