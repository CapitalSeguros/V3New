<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class calendario extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r("LLEGA", TRUE));fclose($fp);	
		//$this->load->library(array("Calendarcenis","DriveCenis",'webservice_sicas','webservice_sicas_soap','role'));
		$this->load->library(array("Calendarcenis", "DriveCenis", 'webservice_sicas', 'webservice_sicas_soap', 'role', 'Meetingcenis'));
		$this->load->model(array("calendar_model", 'emailmasivo_model', 'catalogos_model', 'personamodelo', 'crmProyecto_Model', 'notificacionModel'));
		$this->load->helper(array("file", "url"));


		if (!$this->tank_auth->is_logged_in()) {
			if (array_key_exists('HTTP_X_REQUESTED_WITH', $_SERVER)) {
				http_response_code(400);
				echo json_encode(array('error' => 'El tiempo de sesion expiro 
					se redireccionará en 5 segundos', 'code' => '440'));
				die();
			} else {
				redirect('/auth/login/');
			}
		}
	}

	function index()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {

			$data['Listar_evento'] = $this->calendarcenis->listar_evento();
			// return

			$data["EmailScriptJS"] = $this->get_EmailFor();

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

			$perfilesCoor = $this->personamodelo->devuelveCorreosSuperiores();

			$coordinador = array();
			foreach ($perfilesCoor as $datos) {
				array_push($coordinador, $datos->emailHijo);
			}

			$data_role_ = array(
				"IdTipoUser" => $this->tank_auth->get_user_id(),
				"Profile" =>  $this->tank_auth->get_userprofile(),
				"usuario" => $this->tank_auth->get_usermail(),
			);

			//$name_tab = $this->emailmasivo_model->get_dataEmail($data_role_);
			$name_tab = $this->personamodelo->clasificacionUsuariosParaEnvios();

			//-----------------------------------------------------------------------------------
			//[Dennis 2020-06-22]
			//$tablaAgentes=$this->emailmasivo_model->obtenerEmailAgentesXCoor($data_role_);

			//foreach($perfilesCoor as $valor){
			/*if(in_array($this->tank_auth->get_usermail(),$coordinador)){
					
					//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($tablaAgentes,TRUE));fclose($fp);
					$data['Catalogo_Perfiles']=$name_tab;
					
				} else{
					$data['Catalogo_Perfiles']=$name_tab;
					//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r("no entro",TRUE));fclose($fp);
				}*/
			//}
			//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($name_tab, TRUE));fclose($fp);
			$data["top_email"] = $coordinador;
			$data['Cliente'] = array();
			if (isset($_POST['proyecto'])) {
				$data['Catalogo_Perfiles'] = array();
				$consultaP = 'select p.*,(p.nombre) as Name,(p.nombre) as tipoPersona,""  as Data,"0" as IDVend,"0" as IdUser,"0" as idTipoUser from proyectos p where p.usuario=' . $this->tank_auth->get_idPersona();
				if ((int)$_POST['id_proyecto'] > 0) {
					$consultaP .= ' and idproyecto=' . $_POST['id_proyecto'];
				}
				$proyectos = $this->db->query($consultaP)->result_array();

				foreach ($proyectos as $key => $value) {
					$queryData = 'select (p.nombre) as idpersonarankingagente,(u.idPersona) as idPersona,"1" as personaTipoAgente,"" as apellidoPaterno,"" as apellidoMaterno,"0" as IDVend,pt.*,pt.correo as email,u.idPersona as id,"4" as idTipoUserSMSmail,"4" as idTipoUser, "0" as tipoPersona,(pp.nombres) as username,p.nombre as tipoPersona,(p.nombre) as tipoPersona,(pt.nombre) as nombres,(pt.correo) as EMail1,(p.nombre) as TIPO from proyectos p left join tareas t on t.idproyecto=p.idproyecto left join ptareas pt on pt.idtarea=t.idtarea left join users u on u.email=pt.correo left join persona pp on pp.idPersona=u.idPersona where p.idproyecto=' . $value['idproyecto'] . ' and pt.idtarea is not null  group by EMail1';
					$value['Data'] = $this->db->query($queryData)->result_array();
					// $value->Data=$consultaUsers;
					$notIn = '';
					foreach ($value['Data'] as  $val) {
						if ($val === end($value['Data'])) {
							$notIn .= '"' . $val['EMail1'] . '"';
						} else {
							$notIn .= '"' . $val['EMail1'] . '",';
						}
					}
					$queryNoIn = 'select (p.nombre) as idpersonarankingagente,(u.idPersona) as idPersona,"1" as personaTipoAgente,"" as apellidoPaterno,"" as apellidoMaterno,"0" as IDVend,pps.*,pps.correo as email,u.idPersona as id,"4" as idTipoUserSMSmail,"4" as idTipoUser, "0" as tipoPersona,(pp.nombres) as username,p.nombre as tipoPersona,(p.nombre) as tipoPersona,(pps.nombre) as nombres,(pps.correo) as EMail1,(p.nombre) as TIPO from proyectos p left join pproyectos pps on pps.idproyecto=p.idproyecto left join users u on u.email=pps.correo left join persona pp on pp.idPersona=u.idPersona  where p.idproyecto=' . $value['idproyecto'] . ' and pps.correo!="" ';
					if ($notIn != '') {
						$queryNoIn .= ' and pps.correo not in (' . $notIn . ') group by EMail1';
					}
					$datosNotIn = $this->db->query($queryNoIn)->result_array();
					foreach ($datosNotIn as $valDNI) {
						array_push($value['Data'], $valDNI);
					}

					array_push($data['Catalogo_Perfiles'], $value);
				}
			} else {
				$data['Catalogo_Perfiles'] = array_filter($name_tab, function ($arr) {
					return $arr["Name"] != "Marketing proyecto 100";
				}); //[Dennis 2020-06-22]: comentado para asignar agentes por coordinador
			}


			$data['userProfile'] = $this->tank_auth->get_userprofile();

			$data["capacitaciones"] = $this->obtenerTipoCapa();
			$data["ramosC"] = $this->obtenerRamo();
			//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($data['Catalogo_Perfiles'], TRUE));fclose($fp);
			$id_userInfo = $this->tank_auth->get_idPersona();
			$data['id_userInfo'] = $id_userInfo;
			$data['ListaAgenda'] = $this->crmProyecto_Model->agenda_citas_asesores_capital($id_userInfo);
			$data['configuracion'] = $this->crmProyecto_Model->configuracion_agenda_capital($id_userInfo);

			$this->load->view('calendario/principal', $data);
		}
	}
	function calendarioAlterno()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {

			$data['Listar_evento'] = $this->calendarcenis->listar_evento();
			// return

			$data["EmailScriptJS"] = $this->get_EmailFor();

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

			$this->load->view('calendario/calendarioAlterno', $data);
		}
	}

	public function oauth2callback()
	{

		if ($this->input->get('logout') != null) {
			unset($this->session->token);
			die('Logged out.');
		}

		if ($this->input->get('code') != null) {

			$this->calendarcenis->client->authenticate($this->input->get('code'));

			$this->session->set_userdata("token", $this->calendarcenis->client->getAccessToken());
			//$this->session->token = $this->calendarcenis->client->getAccessToken();
		}

		if ($this->session->token != null) {
			$token = $this->session->token;
			$this->calendarcenis->client->setAccessToken($token);
		}

		if (!$this->calendarcenis->client->getAccessToken()) {

			$authUrl = $this->calendarcenis->client->createAuthUrl();
			header("Location: " . $authUrl);
			die;
		}
	}

	public function do_upload()
	{

		try {
			//$this->load->library(array("UploadHandler"));	
			//$this->UploadHandler->initialize();
			//return json_encode("{Success:}");
			//var_dump($testing);
			$output_dir = "files/";

			if (isset($_FILES["myfile"])) {
				$ret = array();

				//	This is for custom errors;	
				/*	$custom_error= array();
				$custom_error['jquery-upload-file-error']="File already exists";
				echo json_encode($custom_error);
				die();
			*/
				//$fp = fopen('resultadoJason.txt', 'a+');fwrite($fp, print_r($_FILES["myfile"],TRUE));fclose($fp);	
				$error = $_FILES["myfile"]["error"];
				//You need to handle  both cases
				//If Any browser does not support serializing of multiple files using FormData() 
				if (!is_array($_FILES["myfile"]["name"])) //single file
				{
					$fileName = $_FILES["myfile"]["name"];

					error_reporting(E_ALL); // or E_STRICT
					ini_set("display_errors", 1);
					ini_set("memory_limit", "1024M");
					if (move_uploaded_file($_FILES["myfile"]["tmp_name"], $output_dir . $fileName)) {

						$file_full_path = FCPATH . $output_dir . $fileName;

						$data = array(
							'pathfile' => $file_full_path,
							'mimeType' => $_FILES["myfile"]["type"],
							'title' => $_FILES["myfile"]["name"]
						);

						$result = $this->drivecenis->UploadFile($data);
					} else {
						switch ($_FILES['myfile']['error']) {
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



					$ret[] = $fileName;
				} else  //Multiple files, file[]
				{
					$fileCount = count($_FILES["myfile"]["name"]);
					for ($i = 0; $i < $fileCount; $i++) {
						$fileName = $_FILES["myfile"]["name"][$i];
						move_uploaded_file($_FILES["myfile"]["tmp_name"][$i], $output_dir . $fileName);

						$file_full_path = FCPATH . $output_dir . $fileName;

						$data = array(
							'pathfile' => $file_full_path,
							'mimeType' => $_FILES["myfile"]["type"][$i],
							'title' => $_FILES["myfile"]["name"][$i]
						);

						$result = $this->drivecenis->UploadFile($data);

						$ret[] = $fileName;
					}
				}

				echo json_encode($result);
			}
		} catch (Exception $e) {
			echo "Ocurrio un error ";
		}
	}

	public function do_delete()
	{
		$output_dir = "files/";
		//Se agrego un campo mas por que requiere el ID del archivo  del drive
		if (isset($_POST["op"]) && $_POST["op"] == "delete" && isset($_POST['name']) && isset($_POST['id'])) {
			$idFile = $_POST['id'];
			$fileName = $_POST['name'];
			$fileName = str_replace("..", ".", $fileName); //required. if somebody is trying parent folder files	
			$filePath = $output_dir . $fileName;
			if (file_exists($filePath)) {
				unlink($filePath);
				//Llamo a tu libraria para eliminar el archivo
				$result = $this->drivecenis->DeleteFile($idFile);
			}
			echo "Deleted File " . $fileName . "<br>" . $result . "<br>";
		}
	}
	public function do_load()
	{
		$oDecodeJsonCalendar = '';

		$dir = "files";
		$ret = array();
		$this->load->library("calendarcenis");
		$event_type = strtoupper($_REQUEST["TypeEvent"]);
		$json_event = $_REQUEST["Event"];
		$oDecodeJsonCalendar 	= $this->calendarcenis->json_validate(json_encode($json_event));
		$objCalendar = json_decode($this->calendarcenis->getCalendarEvent($oDecodeJsonCalendar));


		foreach ($objCalendar->attachments as $attach) {


			$filePath = $dir . "/" . $attach->title;
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
	public function create_update_event()
	{

		$event_type = strtoupper($_REQUEST["TypeEvent"]);
		$json_event = $_REQUEST["Event"];
		$json_event2 = $_REQUEST["Event"];
		//$create_meeting_zoom=$this->create_zoom_meeting($json_event);

		//$array_resultado=array_merge($json_event,$create_meeting_zoom);

		$oDecodeJsonCalendar 	= $this->calendarcenis->json_validate(json_encode($json_event));
		//$oDecodeJsonCalendar 	= $this->calendarcenis->json_validate(json_encode($array_resultado));
		$oDecodeJsonCalendar2 	= $this->calendarcenis->json_validate(json_encode($json_event2));


		//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($oDecodeJsonCalendar, TRUE));fclose($fp);
		//var_dump($array_resultado);

		if (isset($oDecodeJsonCalendar->Organizador)) {
			if (strlen($oDecodeJsonCalendar->Organizador->email) == 0) {
				/*
			* si no tiene organizador ingresar el correo de la app
			* por default
			*/
				$this->calendarcenis->email 		= "mesadecontrol@agentecapital.com";
				$this->calendarcenis->displayName 	= "Nombre de organizador";
			} else {

				$this->calendarcenis->email 		= $oDecodeJsonCalendar->Organizador->email;
				$this->calendarcenis->displayName 	= $oDecodeJsonCalendar->Organizador->nombre;
			}
		} else {
			$this->calendarcenis->email 		= $this->tank_auth->get_usermail();
			$this->calendarcenis->displayName 	= "Name usuario";
		}

		if (isset($oDecodeJsonCalendar->eventId) && $oDecodeJsonCalendar->eventId != "") {

			$objCalendar = $this->calendarcenis->actualizar_evento($oDecodeJsonCalendar);


			/*$correoAlter=$this->calendar_model->correoAlternativo($this->calendarcenis->email);					
			
			if($correoAlter!="N"){
			  $oDecodeJsonCalendar2->organizer=$correoAlter;
			  $this->calendarcenis->email =$correoAlter;			  
			  $this->calendarcenis->actualizar_evento($oDecodeJsonCalendar2);
			} */
		} else {
			$objCalendar = $this->calendarcenis->agregar_evento($oDecodeJsonCalendar);
			//fragmento comentado por Dennis castillo[2020-07-08]: inserta un correo alterno provocando una creacion de un nuevo evento
			//en consecuencia genera un duplicado de evento con dos id's diferentes;
			/*$correoAlter=$this->calendar_model->correoAlternativo($this->calendarcenis->email);					
			
			if($correoAlter!="N"){
			  $oDecodeJsonCalendar2->organizer=$correoAlter;
			  $this->calendarcenis->email =$correoAlter;
			  
			  $this->calendarcenis->agregar_evento($oDecodeJsonCalendar2);
			} */
		}
		echo $objCalendar;
	}
	public function eliminar_evento()
	{
		$event_type = strtoupper($_REQUEST["TypeEvent"]);
		$json_event = $_REQUEST["Event"];
		$oDecodeJsonCalendar 	= $this->calendarcenis->json_validate(json_encode($json_event));
		$objCalendar = $this->calendarcenis->eliminar_evento($oDecodeJsonCalendar);
		echo $objCalendar;
	}
	public function load_event_id()
	{
		$event_type = strtoupper($_REQUEST["TypeEvent"]);
		$json_event = $_REQUEST["Event"];
		$oDecodeJsonCalendar 	= $this->calendarcenis->json_validate(json_encode($json_event));
		$objCalendar = $this->calendarcenis->getCalendarEvent($oDecodeJsonCalendar);
		echo $objCalendar;
	}
	function get_EmailFor()
	{

		$result = array();

		try {

			//$this->load->model('emailmasivo_model');
			//$result = $this->emailmasivo_model->get_CabInvitados();		

		} catch (Exception $e) {
		}

		return $result;
	}
	public function get_Agerente()
	{

		try {

			$this->load->model('emailmasivo_model');
			$data = array("alias" => "gerente");
			$result = $this->emailmasivo_model->get_alias($data);
		} catch (Exception $e) {
		}

		return $result;
	}

	public function get_Aejecutivo()
	{

		try {

			$this->load->model('emailmasivo_model');
			$data = array("alias" => "ejecutivo");
			$result = @$this->emailmasivo_model->get_alias($data);
		} catch (Exception $e) {
		}

		return $result;
	}
	public function get_Apromotor()
	{

		try {

			$this->load->model('emailmasivo_model');
			$data = array("alias" => "promotor");
			$result = @$this->emailmasivo_model->get_alias($data);
		} catch (Exception $e) {
		}

		return $result;
	}
	public function get_Avendedor()
	{

		try {

			$this->load->model('emailmasivo_model');
			$data = array("alias" => "vendedor");
			$result = @$this->emailmasivo_model->get_alias($data);
		} catch (Exception $e) {
		}

		return $result;
	}
	public function get_AvendedorPromotor($data)
	{

		try {

			$this->load->model('emailmasivo_model');

			if (is_array($data)) {
				$result = $this->emailmasivo_model->get_Promotor_get_Vendedores($data);
			}
		} catch (Exception $e) {
		}
		return $result;
	}
	public function wdo_upload()
	{

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
			$f = 0;
			foreach ($existingFiles as $fileName => $info) {
				if ($fileName != 'thumbs') { //Skip over thumbs directory
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

	public function deleteImage($file)
	{ //gets the job done but you might want to add error checking and security
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

	function obtenerTipoCapa()
	{
		$valorRetorno = $this->personamodelo->devuelveTipoCapacitacion();

		return $valorRetorno;
	}

	function subCategorias()
	{
		//echo $_POST["prueba"];
		$capacitacion = $_POST["capacitacion"];
		$resultado = $this->personamodelo->devuelveTipoCertificado($capacitacion);

		echo json_encode($resultado);
	}

	function obtenerRamo()
	{
		$resultado = $this->personamodelo->devuelveRamo();

		if (isset($resultado)) {
			return $resultado;
		} else {
			echo "No hay ramos";
		}
	}


	function imprimeVista()
	{

		/*$data["datos"]=array(
			"titulo"=>"de nuevo",
			"lugar"=>"merida",
			"descripcion"=>"Hola mundo",
			"fecha_inicio"=>0,
			"fecha_final"=>0,
			"hora_inicio"=>0,
			"hora_final"=>0,
			"idEvento"=>0,
			"tipo"=>1,
			"clasificacion"=>"capacitacion",
			"nombre"=>"x");
		$data["datos"]["TInvitado"]="interno";
		$data["datos"]["invitado"]="hola";
		$data["datos"]["estado"]="aceptado";
		$data["nombre"]="x";
		$data["descripcion"]="x";
		$data["fechaI"]="x";
		$data["horaI"]="x";
		$data["fechaF"]="x";
		$data["horaF"]="x";
		$data["titulo"]="x";
		$data["lugar"]="x";
		$data["invitado"]="95";*/

		//$this->load->view("accesoAEvento/vistaPostRegistro", $data);
		$this->load->view("accesoAEvento/vistaAcceso");
	}

	function verificar_archivo()
	{
		$resultado = $this->calendarcenis->mover_archivos_precargados();

		echo $resultado;
	}

	function crea_ics_tmp()
	{

		$direccion = FCPATH . "assets/documentos/adjuntos_calendario";
		//$direccion=$_SERVER["DOCUMENT_ROOT"]."/Capsys/www/V3/files/icalendar_files"; 

		//UID:".$datosCorreo["iCal"]." CALSCALE:GREGORIAN DTSTAMP:TZID=America/Merida:20201110T16:00:00 DTSTART:20201110T210000Z DTEND:20201110T023000Z
		//date('ymd\THisP');

		date_default_timezone_set("America/Mexico_City");

		$_incal_content = "BEGIN:VCALENDAR
		VERSION:2.0
		METHOD:REQUEST
		BEGIN:VEVENT
		ORGANIZER;CN=Dennis Castillo:mailto:denniscastle24@gmail.com
		CLASS:PUBLIC
		UID:" . md5("Prueba") . "@example.com
		DTSTART:" . str_replace("-", "", str_replace(":", "", date("c", strtotime("2020-11-11 11:00:00")))) . "Z
		DTEND:" . str_replace("-", "", str_replace(":", "", date('c', strtotime("2020-11-11 12:30:00")))) . "Z
		LOCATION:Merida
		STATUS:CONFIRMED
		SUMMARY:Prueba 123
		ACTION:EMAIL
		DESCRIPTION:Hola mundo
		BEGIN:VALARM
		TRIGGER:-PT10M
		DESCRIPTION:Reminder
		ACTION:DISPLAY
		END:VALARM
		END:VEVENT
		END:VCALENDAR";

		$CI = &get_instance();
		$CI->load->model("manejodocumento_modelo");

		$respuesta = $CI->manejodocumento_modelo->gestiona_directorio_para_adjuntos_de_eventos($direccion . "/prueba_creacion/icals", "crear");


		/*if(!file_exists($direccion."/prueba_creacion/archivo.ics") && $respuesta){

			$ical=fopen($direccion."/prueba_creacion/archivo.ics", "w");
			file_put_contents($direccion."/prueba_creacion/archivo.ics", str_replace("\t","",$_incal_content));
			fclose($ical);

		}*/

		echo $respuesta; //date("Y-m-d H:i:s");

		/*if(!file_exists($direccion."/".$datosCorreo["idEvento"].".ics")){

			$CI->manejodocumento_modelo->crearDirectorio();

			$ical=fopen($direccion."/".$datosCorreo["idEvento"].".ics", "w");
			file_put_contents($direccion."/".$datosCorreo["idEvento"].".ics", str_replace("\t","",$_incal_content));
			fclose($ical);
		} else{
			file_put_contents($direccion."/".$datosCorreo["idEvento"].".ics", str_replace("\t","",$_incal_content));
		}*/
	}

	function pruebaZoom()
	{

		$conexion = $this->meetingcenis->conexion();

		echo $conexion;
	}

	function create_zoom_meeting($array_datos)
	{ //$array_datos

		/*$array_datos["FechaInicio"]="2020-11-14";
		$array_datos["starttime"]="09:00:00";
        //$contrasenia.=rand(0,9);
        $array_datos["TituloEvento"]="Prueba";*/

		$uri = $this->meetingcenis->create_meeting_event($array_datos);

		return $uri;
		//echo var_dump($uri);
	}

	//------------------------------ //Dennis Castillo 2024-01-14 "Actualización de citas de asesores online y tarjeta digital en convocar reunión"
	function get_diary_event()
	{

		$localEventId = $_GET["id"];
		$event = $this->crmProyecto_Model->getCitaOnlinePendiente($localEventId);
		$event[0]->fecha = implode("-", array_reverse(explode("/", $event[0]->fecha)));
		echo json_encode($event);
	}

	function update_diary()
	{

		$request = array();
		$postRequest = json_decode(file_get_contents("php://input"));
		$request["liga_zoom"] = isset($postRequest->link) ? $postRequest->link : null;
		$request["password_liga"] = isset($postRequest->password) || !empty($postRequest->password) ? $postRequest->password : null;
		$request["estatus"] = $postRequest->status;
		$request["enviado"] = $postRequest->status == "confirmado" ? 1 : 0;

		$event = $this->crmProyecto_Model->updateDiary($postRequest->id, $request);

		if ($event && in_array($postRequest->status, ["confirmado", "rechazado"])) {

			$event_ = $this->crmProyecto_Model->getCitaOnlinePendiente($postRequest->id);
			$mensaje = $postRequest->status == "confirmado" ?
				'<DOCTYPE html><html><body><table width="75%" align="center" style="border-width: 1px;padding: 5%; border-color: #b2b2b2;border-radius: 10px;border-style: solid;background-color: #fff;"><tr><td align="left" colspan="2"><img src="https://www.capsys.com.mx/V3/assets/img/logo/logocapital.png" width="30%" style="margin-top: -8%;"></td></tr><tr><td><b>Nombre y Apellido:</b></td><td>' . strtoupper($event_[0]->cliente) . '</td></tr><tr><td width="50%"><b>E-mail:</b></td><td>' . $event_[0]->correo . '</td></tr><tr><td><b>Detalles de su Cita:</b></td><td>' . $event_[0]->detalle . '</td></tr><tr><td colspan="2"><br></td></tr><tr align="left"><td colspan="2"><h4 style="color: blue;">AGENTE ASESOR CAPITAL</h4></td></tr><tr><td><b>Nombre:</b></td><td>' . strtoupper($event_[0]->nombre) . '</td></tr><tr><td colspan="2"><br><br></td></tr><tr align="left"><td colspan="2"><h4 style="color: blue;">AGENDA</h4></td></tr><tr><td><b>Dia:</b></td><td>' . strtoupper($event_[0]->dia) . ' , ' . $event_[0]->fecha . '</td></tr><tr><td><b>Hora de reunion:</b></td><td>' . $event_[0]->hora . '</td></tr><tr><td><b>Liga de Video Conferencia:</b></td><td>' . $event_[0]->liga_zoom . '</td></tr><tr><td><b>Codigo de Acceso:</b></td><td>' . $event_[0]->password_liga . '</td></tr></table></body></html>' :
				'<DOCTYPE html><html><body><table width="75%" align="center" style="border-width: 1px;padding: 5%; border-color: #b2b2b2;border-radius: 10px;border-style: solid;background-color: #fff;"><tr><td align="left" colspan="2"><img src="https://www.capsys.com.mx/V3/assets/img/logo/logocapital.png" width="30%" style="margin-top: -8%;"></td></tr><tr><td><b>Nombre y Apellido:</b></td><td>' . strtoupper($event_[0]->cliente) . '</td></tr><tr><td width="50%"><b>E-mail:</b></td><td>' . $event_[0]->correo . '</td></tr><tr><td><b>Detalles de su Cita:</b></td><td>' . $event_[0]->detalle . '</td></tr><tr><td colspan="2"><br></td></tr><tr align="left"><td colspan="2"><h4 style="color: blue;">AGENTE ASESOR CAPITAL</h4></td></tr><tr><td><b>Nombre:</b></td><td>' . strtoupper($event_[0]->nombre) . '</td></tr><tr><td colspan="2"><br><br></td></tr><tr align="left"><td colspan="2"><h4 style="color: blue;">AGENDA</h4></td></tr><tr><td><b>Dia:</b></td><td>' . strtoupper($event_[0]->dia) . ' , ' . $event_[0]->fecha . '</td></tr><tr><td><b>Hora de reunion:</b></td><td>' . $event_[0]->hora . '</td></tr><tr><td colspan="2"><b><center>¡ESTA CITA HA SIDO CANCELADA!</center></b></td></tr></table></body></html>';

			$emailRequest = array(
				"fechaCreacion" => date("Y-m-d H:i:s"),
				"desde" => "<Avisos de GAP<avisosgap@aserorescapital.com>",
				"para" => trim($event_[0]->correo), //"denniscastle24@gmail.com", //$emailAttendes->email,
				"copia" => 0,
				"copiaOculta" => 0,
				"asunto" => $postRequest->status == "confirmado" ? "Cita Online - Asesores Capital Seguros y Fianzas" : "Cancelacion Cita Online - Asesores Capital Seguros y Fianzas",
				"mensaje" => $mensaje,
				"status" => 0,
				"fechaEnvio" => date("Y-m-d H:i:s")

			);

			$sendEmail = $this->notificacionModel->insertCorreo($emailRequest);
		}

		echo json_encode(array("success" => $event));
	}
	//------------------------------
	/*function eliminaInvitado(){
		$idPersona=$_POST["id"];

		$info=$this->emailMasivo_model->devuelve_correoExt_unitario_x_id($idPersona);

		if(isset($info)){

		}

		echo $idPersona;
	} */
	function timeZoneTest()
	{

		$timezone = new DateTimeZone("America/Mexico_City");
		$dt = new DateTime("now", $timezone);

		var_dump($dt->format("c"));
	}

	function diary()
	{
		$this->load->view("diary/calendar.php");
	}
}

/* End of file inicio.php */
/* Location: ./application/controllers/inicio.php */
