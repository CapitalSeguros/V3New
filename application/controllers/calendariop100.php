<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class calendariop100 extends CI_Controller{

	function __construct(){
		parent::__construct();

		$this->load->library(array("Calendarcenis","DriveCenis",'webservice_sicas','webservice_sicas_soap','role'));
		$this->load->model(array("calendar_model",'emailmasivo_model','catalogos_model'));
		$this->load->helper(array("file","url"));

		
		if (!$this->tank_auth->is_logged_in()) {
			if(array_key_exists('HTTP_X_REQUESTED_WITH', $_SERVER)){
				http_response_code(400);
				echo json_encode(array('error'=>'El tiempo de sesion expiro 
					se redireccionará en 5 segundos','code'=>'440'));
				die();
			}else{
				redirect('/auth/login/');
			}
		}
	}

	function index(){		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			
			$data['Listar_evento'] = $this->calendarcenis->listar_evento();
			// return

			$data ["EmailScriptJS"] = $this->get_EmailFor();
			
			$data["gerente"] = $this->get_Agerente();
			$data["ejecutivo"] = $this->get_Aejecutivo();
			$data["promotor"] = $this->get_Apromotor();
			$data["vendedor"] = $this->get_Avendedor();	
			$data["vendedorpromotor"] = $this->get_AvendedorPromotor($data["promotor"]);
			
			$email = $this->calendar_model->select_event_email($this->tank_auth->get_usermail());
			
			$data["json_ical"] = json_encode($email);
			$data["email_organizer"] = $this->tank_auth->get_usermail();
			
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();

			$data_role_ = array(
				"IdTipoUser" => $this->tank_auth->get_user_id(),
				"Profile" =>  $this->tank_auth->get_userprofile()
			);
			
			$name_tab = $this->emailmasivo_model->get_dataEmail($data_role_);
			
			
			$data['Cliente'] = array();
			$data['Catalogo_Perfiles'] = $name_tab;
				
			$this->load->view('calendario/principaldos', $data);

		}
	}

	
	public function oauth2callback(){
		
		if ($this->input->get('logout') != null) {
			unset($this->session->token);
			die('Logged out.');
		}
				
		if ($this->input->get('code') != null ) { 
		
			$this->calendarcenis->client->authenticate($this->input->get('code'));
			
			$this->session->set_userdata("token", $this->calendarcenis->client->getAccessToken());
			//$this->session->token = $this->calendarcenis->client->getAccessToken();
		}
		
		if ($this->session->token != null ) { 
			$token = $this->session->token;
			$this->calendarcenis->client->setAccessToken($token);
		}

		if (!$this->calendarcenis->client->getAccessToken()) { 
			
			$authUrl = $this->calendarcenis->client->createAuthUrl();			
			header("Location: ".$authUrl);
			die;
		}
	}
	
	public function do_upload(){
		
		try{
			//$this->load->library(array("UploadHandler"));	
			//$this->UploadHandler->initialize();
			//return json_encode("{Success:}");
			//var_dump($testing);
			$output_dir = "files/";
			
			if(isset($_FILES["myfile"]))
			{
				$ret = array();
				
			//	This is for custom errors;	
			/*	$custom_error= array();
				$custom_error['jquery-upload-file-error']="File already exists";
				echo json_encode($custom_error);
				die();
			*/
				$error =$_FILES["myfile"]["error"];
				//You need to handle  both cases
				//If Any browser does not support serializing of multiple files using FormData() 
				if(!is_array($_FILES["myfile"]["name"])) //single file
				{
					$fileName = $_FILES["myfile"]["name"];
					
					error_reporting(E_ALL); // or E_STRICT
					ini_set("display_errors",1);
					ini_set("memory_limit","1024M");
					if(move_uploaded_file($_FILES["myfile"]["tmp_name"],$output_dir.$fileName)){
						
						$file_full_path = FCPATH . $output_dir . $fileName;
					
						$data = array(
							'pathfile' => $file_full_path,
							'mimeType' =>$_FILES["myfile"]["type"],
							'title' => $_FILES["myfile"]["name"]
						);
						
						$result = $this->drivecenis->UploadFile($data);
						
					}else{
						switch($_FILES['myfile']['error']){
							case 1:
								$result  =  "file to large";
								break;
							case 2:
								$result  =  "file larger than set in form (MAX_FILE_SIZE)";
								break;
							case 3:
								$result  =  "partial upload";
								break;
							case 4:
							default:
								$result  = "file " . $fileName . " not uploaded (unknown) -> Error " . $_FILES['myfile']['error'];
						}
						
					}
					
				
					
					$ret[]= $fileName;
				}
				else  //Multiple files, file[]
				{
				  $fileCount = count($_FILES["myfile"]["name"]);
				  for($i=0; $i < $fileCount; $i++)
				  {
					$fileName = $_FILES["myfile"]["name"][$i];
					move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$output_dir.$fileName);
					
					$file_full_path = FCPATH . $output_dir . $fileName;
					
					$data = array(
						'pathfile' => $file_full_path,
						'mimeType' =>$_FILES["myfile"]["type"][$i],
						'title' => $_FILES["myfile"]["name"][$i]
					);
					
					$result = $this->drivecenis->UploadFile($data);
					
					$ret[]= $fileName;
				  }
				
				}
				
				echo json_encode($result);
			 }
			
		}catch(Exception $e){
			echo "Ocurrio un error ";
		}
	}
	
	public function do_delete(){
		$output_dir = "files/";
		//Se agrego un campo mas por que requiere el ID del archivo  del drive
		if(isset($_POST["op"]) && $_POST["op"] == "delete" && isset($_POST['name']) && isset($_POST['id']))
		{
			$idFile = $_POST['id'];
			$fileName =$_POST['name'];
			$fileName=str_replace("..",".",$fileName); //required. if somebody is trying parent folder files	
			$filePath = $output_dir. $fileName;
			if (file_exists($filePath)) 
			{
				unlink($filePath);
				//Llamo a tu libraria para eliminar el archivo
				$result = $this->drivecenis->DeleteFile($idFile);
			}
			echo "Deleted File ".$fileName."<br>".$result."<br>";
		}
	}
	public function do_load(){
		
		$dir= "files";
		$ret= array();
		$this->load->library("calendarcenis");
		$event_type = strtoupper($_REQUEST["TypeEvent"]);
		$json_event = $_REQUEST["Event"];
		$oDecodeJsonCalendar 	= $this->calendarcenis->json_validate(json_encode($json_event));
		$objCalendar = json_decode( $this->calendarcenis->getCalendarEvent($oDecodeJsonCalendar));
		
		
		foreach($objCalendar->attachments as $attach){
			
			
			$filePath = $dir."/". $attach->title;
			$details = array();
			$details['name']			= @$attach->title;
			$details['path']			= @$this->config->base_url() . $filePath;
			$details['size']			= @filesize($filePath);
			$details['title']			= @$attach->title; 
			$details['mimeType']		= @$attach->mimeType;
			$details['iconLink']		= @$attach->iconLink;
			$details['id']				= @$attach->fileId;
			$details['alternateLink']	= @$attach->fileUrl;
			$details['downloadUrl']		= "";
				
			$ret[] = $details;
		}
		echo json_encode($ret);
	}
	
	public function create_update_event(){
		
		$event_type = strtoupper($_REQUEST["TypeEvent"]);
		$json_event = $_REQUEST["Event"];
		
		$oDecodeJsonCalendar 	= $this->calendarcenis->json_validate(json_encode($json_event));

		if(isset($oDecodeJsonCalendar->Organizador)){
			if (strlen($oDecodeJsonCalendar->Organizador->email) == 0){
			/*
			* si no tiene organizador ingresar el correo de la app
			* por default
			*/
			$this->calendarcenis->email 		= "mesadecontrol@agentecapital.com";
			$this->calendarcenis->displayName 	= "Nombre de organizador";
		
			}else{
				
				$this->calendarcenis->email 		= $oDecodeJsonCalendar->Organizador->email;
				$this->calendarcenis->displayName 	= $oDecodeJsonCalendar->Organizador->nombre;
			}
		}else{
			$this->calendarcenis->email 		= $this->tank_auth->get_usermail();
			$this->calendarcenis->displayName 	= "Name usuario";
		}	
		
		if(isset($oDecodeJsonCalendar->eventId) && $oDecodeJsonCalendar->eventId != ""){
			$objCalendar = $this->calendarcenis->actualizar_evento($oDecodeJsonCalendar);
		}else{
			$objCalendar = $this->calendarcenis->agregar_evento($oDecodeJsonCalendar);
		}	
		echo $objCalendar;	
	}
	public function eliminar_evento(){
		$event_type = strtoupper($_REQUEST["TypeEvent"]);
		$json_event = $_REQUEST["Event"];
		$oDecodeJsonCalendar 	= $this->calendarcenis->json_validate(json_encode($json_event));
		$objCalendar = $this->calendarcenis->eliminar_evento($oDecodeJsonCalendar);	
		echo $objCalendar;
	}
	public function load_event_id(){
		$event_type = strtoupper($_REQUEST["TypeEvent"]);
		$json_event = $_REQUEST["Event"];
		$oDecodeJsonCalendar 	= $this->calendarcenis->json_validate(json_encode($json_event));
		$objCalendar = $this->calendarcenis->getCalendarEvent($oDecodeJsonCalendar);
		echo $objCalendar;
	}
	function get_EmailFor(){
		
		$result = array();
		
		try{
			
			//$this->load->model('emailmasivo_model');
			//$result = $this->emailmasivo_model->get_CabInvitados();		
			
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
	public function wdo_upload() {
		
        $upload_path_url = base_url() . 'uploads/';

        $config['upload_path'] = FCPATH . 'uploads/';
        $config['allowed_types'] = 'jpg|jpeg|png|gif';
        $config['max_size'] = '30000';

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {
            //$error = array('error' => $this->upload->display_errors());
            //$this->load->view('upload', $error);

            //Load the list of existing files in the upload directory
            $existingFiles = get_dir_file_info($config['upload_path']);
            $foundFiles = array();
            $f=0;
            foreach ($existingFiles as $fileName => $info) {
              if($fileName!='thumbs'){//Skip over thumbs directory
                //set the data for the json array   
                $foundFiles[$f]['name'] = $fileName;
                $foundFiles[$f]['size'] = $info['size'];
                $foundFiles[$f]['url'] = $upload_path_url . $fileName;
                $foundFiles[$f]['thumbnailUrl'] = $upload_path_url . 'thumbs/' . $fileName;
                $foundFiles[$f]['deleteUrl'] = base_url() . 'upload/deleteImage/' . $fileName;
                $foundFiles[$f]['deleteType'] = 'DELETE';
                $foundFiles[$f]['error'] = null;

                $f++;
              }
            }
            $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array('files' => $foundFiles)));
        } else {
            $data = $this->upload->data();
            /*
             * Array
              (
              [file_name] => png1.jpg
              [file_type] => image/jpeg
              [file_path] => /home/ipresupu/public_html/uploads/
              [full_path] => /home/ipresupu/public_html/uploads/png1.jpg
              [raw_name] => png1
              [orig_name] => png.jpg
              [client_name] => png.jpg
              [file_ext] => .jpg
              [file_size] => 456.93
              [is_image] => 1
              [image_width] => 1198
              [image_height] => 1166
              [image_type] => jpeg
              [image_size_str] => width="1198" height="1166"
              )
             */
            // to re-size for thumbnail images un-comment and set path here and in json array
            $config = array();
            $config['image_library'] = 'gd2';
            $config['source_image'] = $data['full_path'];
            $config['create_thumb'] = TRUE;
            $config['new_image'] = $data['file_path'] . 'thumbs/';
            $config['maintain_ratio'] = TRUE;
            $config['thumb_marker'] = '';
            $config['width'] = 75;
            $config['height'] = 50;
            $this->load->library('image_lib', $config);
            $this->image_lib->resize();


            //set the data for the json array
            $info = new StdClass;
            $info->name = $data['file_name'];
            $info->size = $data['file_size'] * 1024;
            $info->type = $data['file_type'];
            $info->url = $upload_path_url . $data['file_name'];
            // I set this to original file since I did not create thumbs.  change to thumbnail directory if you do = $upload_path_url .'/thumbs' .$data['file_name']
            $info->thumbnailUrl = $upload_path_url . 'thumbs/' . $data['file_name'];
            $info->deleteUrl = base_url() . 'upload/deleteImage/' . $data['file_name'];
            $info->deleteType = 'DELETE';
            $info->error = null;

            $files[] = $info;
            //this is why we put this in the constants to pass only json data
            if (IS_AJAX) {
                echo json_encode(array("files" => $files));
                //this has to be the only data returned or you will get an error.
                //if you don't give this a json array it will give you a Empty file upload result error
                //it you set this without the if(IS_AJAX)...else... you get ERROR:TRUE (my experience anyway)
                // so that this will still work if javascript is not enabled
            } else {
                $file_data['upload_data'] = $this->upload->data();
                $this->load->view('upload/upload_success', $file_data);
            }
        }
    }

    public function deleteImage($file) {//gets the job done but you might want to add error checking and security
        $success = unlink(FCPATH . 'uploads/' . $file);
        $success = unlink(FCPATH . 'uploads/thumbs/' . $file);
        //info to see if it is doing what it is supposed to
		$info = new StdClass;
        $info->sucess = $success;
        $info->path = base_url() . 'uploads/' . $file;
        $info->file = is_file(FCPATH . 'uploads/' . $file);

        if (IS_AJAX) {
            //I don't think it matters if this is set but good for error checking in the console/firebug
            echo json_encode(array($info));
        } else {
            //here you will need to decide what you want to show for a successful delete        
            $file_data['delete_data'] = $file;
            $this->load->view('admin/delete_success', $file_data);
        }
    }
}

/* End of file inicio.php */
/* Location: ./application/controllers/inicio.php */