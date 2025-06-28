<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class siniestros extends CI_Controller{
	var $data;

	function __construct(){
		parent::__construct(); //Agregado [Suemy][2024-05-21]
		$this->load->library("libreriav3");
		//$this->load->library(array("webservice_sicas_soap","role"));
        $this->load->library("excel"); //Agregado [Suemy][2024-09-06]
		$this->load->helper('url');
		//$this->load->model("catalogos_model");
		//$this->load->model("capsysdre_directorio");
		$this->load->model('capsysdreLite');
		$this->load->model('siniestro_catalogo_model', 'siniestro_model'); //Agregado [Suemy][2024-05-21]
        $this->load->model('capitalhumano_model'); //Agregado [Suemy][2024-05-21]
    	$this->load->model('manejodocumento_modelo'); //Agregado [Suemy][2024-05-21]
        $this->load->model('email_model'); //Agregado [Suemy][2024-05-21]
        $this->load->model('superestrella_model'); //Agregado [Suemy][2024-09-06]
        $this->load->model('catalogos_model'); //Agregado [Suemy][2024-09-06]
        $this->load->model('gmm_model', 'gmm'); //Eliminar
	}

	function index()
	{	
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {	

                $data['rsiniestros']=$this->capsysdreLite->Get_Siniestros();
                //$data['siniestros']= $data_result;

		    	$this->load->view('siniestros/Lista',$data);	

        }
		
	}

	

	function lista(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {

			$data = $this->data;
			$data['tipoCrm']			= $tipoCrm			= $this->uri->segment(3);
			if(
				$tipoCrm!="" 
				&& 
				($tipoCrm=="prospecto" || $tipoCrm=="seguimiento" || $tipoCrm=="siniestro")
			){
				/*$data["seguimiento"]	= $this->capsysdre->get_Ckeditor('seguimiento',array('/'));
				$data["Description"]	= $this->capsysdre->get_Ckeditor('Description',array('/'));
				$data["tipoAdjunto"]	= $this->capsysdre->get_TipoDocumento();*/
				
				switch($tipoCrm){
					case "prospecto":
						$this->load->view('siniestros/lista_prospecto',$data);
					break;
					
					case "siniestro":
                       
						$this->load->view('siniestros/lista_siniestro',$data);
					break;
				}
			} else{
				redirect('/siniestros/');
			}
		}
	}/*! lista */

    
    function archivos() { //Creado [Suemy][2024-05-21]
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } else {
            $data['idPersona'] = $this->tank_auth->get_idPersona();
            $data['email']  = $this->tank_auth->get_usermail();
            //$data['employees'] = $this->capitalhumano_model->devolverPuestos(1);
            //Employee
            $typeUser = "Colaborador";
            $con = $this->siniestro_model->getPersonById($data['idPersona'])[0];
            if ($con->tipoPersona == 3) { $typeUser = "Agente"; }
            $agent = array("Agente" => array($con));
            $employee = ($con->tipoPersona == 1) ? $this->capitalhumano_model->devolverPuestos(1) : $agent;
            $data['typeUser'] = $typeUser;
            $data['nameUser'] = $con->apellidoPaterno." ".$con->apellidoMaterno." ".$con->nombres;
            $data['employees'] = $employee;
            //Ramos
            $optionR = '<option value="1">Ninguno</option>';
            $optionF = '<option value="1">Ninguno</option>';
            $ramo = $this->db->query('SELECT * FROM `catalog_ramos`')->result();
            foreach ($ramo as $val) {
            	$valueRamo = ($val->Nombre == "DAÑOS") ? "danios" : strtolower($val->Nombre);
            	if ($val->descripcion != "RamoFianzas") {
                	$optionR .= '<option value="'.$val->Nombre.'">'.$val->Nombre.'</option>';
                	$optionF .= '<option value="'.$valueRamo.'">'.$val->Nombre.'</option>';
                }
            }
            //Permissions
            $permission = $this->getPermission($this->tank_auth->get_idPersona(),1);
            $data['selectR'] = $optionR;
            $data['selectF'] = $optionF;
            $data['permission'] = $permission;
            $this->load->view('headers/header');
            $this->load->view('headers/menu');
            $this->load->view('siniestros/archivos',$data);
        }
    }

    function getPermission($idPersona,$type) { //Creado [Suemy][2024-05-21]
        $email = $this->tank_auth->get_usermail();
    	$employees = $this->getEmployeeById($idPersona,1);
    	$agents = $this->getEmployeeById($idPersona,2);
    	$permission = 0;
    	if ($email == "DIRECTORGENERAL@AGENTECAPITAL.COM" || $email == "ASISTENTEDIRECCION@AGENTECAPITAL.COM" || $email == "MARKETING@AGENTECAPITAL.COM") {
    		$permission = 1;
    	}
        
        if ($type == 1) {
        	if ($permission != 0 || !empty($employees) || !empty($agents)) { $data = 1; }
        	else { $data = $permission; }
        }
        else {
        	$sql = 'WHERE d.registrado_por = '.$idPersona;
        	if (!empty($employees) && $permission != 1 || !empty($agents) && $permission != 1) {
        		if (!empty($employees)) {
        			foreach ($employees as $val) { $sql .= ' OR d.registrado_por = '.$val->idPersona; }
        		}
        		if (!empty($agents)) {
        			foreach ($agents as $val) { $sql .= ' OR d.registrado_por = '.$val->idPersona; }
        		}
        	}
        	if ($permission != 0) { $sql = ""; }
        	$data = $sql;
        }
        return $data;
    }

    function getEmployeeById($idPersona,$type) { //Creado [Suemy][2024-05-21]
    	$email = $this->tank_auth->get_usermail();
    	$data = "";
    	$employees = "";
    	$agents = "";
        //Encontrar subordinados
        $typePerson = $this->db->query('SELECT tipoPersona FROM persona WHERE idPersona = '.$idPersona)->row()->tipoPersona;
        if ($typePerson == "1") {
        	$idPuesto = $this->db->query('SELECT idPuesto FROM personapuesto WHERE idPersona = '.$idPersona)->row()->idPuesto;
        	$employees = $this->db->query('SELECT idPuesto, idPersona, email FROM personapuesto WHERE statusPuesto = 1 AND padrePuesto = '.$idPuesto)->result();
        	$agents = $this->db->query('SELECT * FROM persona WHERE userEmailCreacion = "'.$email.'"')->result();
        }
        if ($type == 1) { $data = $employees; }
        else { $data = $agents; }
       return $data;
    }

    function sendMessage($idPersona,$file) { //Creado [Suemy][2024-05-21]
    	$con = $this->siniestro_model->getPersonById($idPersona)[0];
    	$name = $con->nombres." ".$con->apellidoPaterno." ".$con->apellidoMaterno;
    	$to = "";
    	if ($con->tipoPersona == 1) {
    		$responsible = $this->siniestro_model->getBoosById($idPersona,1)[0];
    		$to = $responsible->jefeEmail;
    	}
    	else if ($con->tipoPersona == 3) {
    		$responsible = $this->siniestro_model->getBoosById($idPersona,2)[0];
    		$to = $responsible->userEmailCreacion;
    	}
    	$info['title'] = "Archivo Nuevo de Siniestros";
        $info['message'] = 'Se ha guardado un nuevo documento de Siniestros con el nombre "'.$file.'" por parte de '.$name.'. Para más información inicie sesión en el V3Plus';
    	$message = $this->load->view('email/alert',$info,TRUE);

    	$send = array(
    		"addressee" => 'Avisos de GAP <avisosgap@aserorescapital.com>',
    		"mailer" => $to,
    		"subject" => 'Archivo de Siniestros',
    		"message" => $message
    	);
    	$data['status'] = !empty($to) ? $this->send_email($send) : "Error";
    	$data['send'] = $send;
    	//$data['message'] = $info;
    	return $data;
    }

    function send_email($data) { //Creado [Suemy][2024-05-21]
    	$insert = array(
       	    "desde" => $data['addressee'],
       	    "para" => $data['mailer'],
       	    "asunto" => $data['subject'],
       	    "mensaje" => $data['message'],
       	    "status" => 0,
       	    "identificaModulo" => "Siniestros",
       	    "fechaEnvio" => date("Y-m-d H:i:s")
       	);
       	return $this->email_model->SendEmail($insert);
    }

    function uploadSurvey() { //Modificado [Suemy][2024-09-06]
    	$name = $this->input->post('nameD');
    	$ramo = $this->input->post('ramoD');
    	$date = $this->input->post('dateD');
    	$folder = $this->input->post('typeD');
    	$subFolder = $this->input->post('folderD');
    	$description = $this->input->post('descD');
    	//Operation
    	$format = end(explode('.',$_FILES['fileD']['name']));
    	$document = str_replace(array(" ",".",",","-","~","^","`","+","}","{","@","¿","?","¡","!"),"_",$_FILES['fileD']['name']);
    	$file = str_replace(array(" ",".",",","-","~","^","`","+","}","{","@","¿","?","¡","!"),"_",$name).'.'.$format;
    	$url = ($folder != "1") ? '/'.$folder : "";
    	$url = ($subFolder != "1") ? $url.'/'.$subFolder : $url;
    	$subFolder = ($subFolder != "1") ? $subFolder : NULL;
    	$ramo = ($ramo != "1") ? $ramo : NULL;

    	//Upload Document
    	//--->Create repository
    	$repository = $this->manejodocumento_modelo->obtenerDirectorio("U");
    	$link = $repository.'archivosSiniestros'.$url;
    	if (!file_exists($link)) {mkdir($link, 0777, true);}
    	//--->Verify existence
    	$info = array("titulo" => $name, "archivo" => $file, "url" => $url);
    	$data['exists'] = $this->siniestro_model->verifyDocumentSiniestros($info)->total;
    	$data['status'] = "exists";
    	if ($data['exists'] < 1) {
    		//->Method 1
    		$config['upload_path'] = $link;
    		$config['file_name'] = $file;
    		$config['allowed_types'] = "*";
    		$config['max_size'] = "50000";
    		$config['max_width'] = "2000";
    		$config['max_height'] = "2000";
    		$config['overwrite'] = "TRUE";
    		$this->load->library('upload', $config);
    		if (!$this->upload->do_upload('fileD')) {
    	    	$upload['uploadError'] = $this->upload->display_errors();
    	  		$upload['message'] = "PROBLEMAS AL PROCESAR EL ARCHIVO";
    	    	$data['status'] = "error";
    		}
    		else {
    			$upload['uploadSuccess'] = $this->upload->data();
    		  	$upload['message'] = "GUARDADO";
    			//Insert Information
    			$insert = array(
    				"titulo" => $name,
    				"tipo_documento" => ($folder != "1") ? ucfirst($folder) : "Ninguno",
    				"ramo" => $ramo,
    				"fecha" => $date,
    				"descripcion" => $description,
    				"archivo" => $upload['uploadSuccess']['file_name'],
    				"url" => $url,
    				"registrado_por" => $this->tank_auth->get_idPersona(),
    				"registro" => date("Y-m-d H:i:s")
    			);
                //if ($this->input->post('siniestroD',TRUE)) {
                    $insert['siniestro'] = $this->input->post('siniestroD');
                    $insert['poliza'] = $this->input->post('polizaD');
                    //Register Survey
                    $data['register_survey'] = $this->checkExistenceSurvey($this->tank_auth->get_idPersona(),$this->input->post('polizaD'),$this->input->post('siniestroD'));
                //}
    			$data['insert'] = $insert;
    		  	$data['id_register'] = $this->siniestro_model->uploadDocumentSiniestros($insert);
    		  	$data['status'] = "success";
    		  	//Send Message
    		  	$data['send_message'] = $this->sendMessage($this->tank_auth->get_idPersona(),$name);
    		}
    		$data['register_upload'] = array("config" => $config, "upload" => $upload);

    		//->Method 2
    		//move_uploaded_file($_FILES['fileD']['tmp_name'], $link);
    	}
    	$data['file'] = $_FILES['fileD'];
    	$data['link'] = $link;
    	$data['data'] = array("format" => $format, "document" => $document, "file" => $file, "repository" => $repository);
    	echo json_encode($data);
    }

    function deleteSurvey() { //Creado [Suemy][2024-05-21]
    	$id = $this->input->post('id');
    	$repository = $this->manejodocumento_modelo->obtenerDirectorio("U");
    	$file = $this->siniestro_model->getDocumentSiniestrosById($id);
    	$url = $repository.'archivosSiniestros'.$file->url.'/'.$file->archivo;
    	$data['delete'] = unlink($url);
    	$data['status'] = false;
    	if ($data['delete'] !=  false) {
    		$data['status'] = $this->siniestro_model->deleteDocumentSiniestros($id);
    	}
    	$data['data'] = array("id" => $id, "url" => $url, "file" => $file);
    	echo json_encode($data);
    }

    function getDocumentsSiniestros() { //Modificado [Suemy][2024-09-06]
        $siniestro = $this->input->get('sn');
        $poliza = $this->input->get('pl');
    	//$sql = $this->getPermission($this->tank_auth->get_idPersona(),2);
        $sql = "WHERE siniestro = '".$siniestro."' AND poliza = '".$poliza."'";
    	$data['sql'] = $sql;
    	$data['documents'] = $this->siniestro_model->getDocumentSiniestros($sql);
    	echo json_encode($data);
    }
//---------------------------------------------------------------------------------------
    //Encuestas Siniestros | Creado [Suemy][2024-09-06]
    function encuestas() {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } 
        else {
            //Usuario
            $data['username'] = $this->tank_auth->get_username();
            $data['email']  = $this->tank_auth->get_usermail();
            $data['idPersona'] = $this->tank_auth->get_idPersona();
            //Encontrar meses
            $months = '';
            $m = $this->libreriav3->devolverMeses();
            foreach ($m as $key => $val) {
                $selected = "";
                if ($key == date('m')) { $selected = "selected"; }
                $months .= "<option value=".$key." ".$selected.">".$val."</option>";
            }
            $data['months'] = $months;
            //Encontrar años
            $years = '';
            $count = date('Y') - 2024;
            $yearI = date('Y');
            for ($i=0;$i<=$count;$i++) {
                $selected = "";
                if ($yearI == date('Y')) { $selected = "selected"; }
                $years .= '<option value="'.$yearI.'" '.$selected.'>'.$yearI.'</option>';
                $yearI--;
            }
            $data['years'] = $years;
            //Encontrar ramos
            $data['ramos'] = $this->catalogos_model->getRamosForActivities();
            //Encontrar encuestas
            $data['survey'] = $this->db->query('SELECT idEncuesta, titulo FROM encuesta_siniestro WHERE activa = 0')->result();
            $this->load->view('headers/header');
            $this->load->view('headers/menu');
            $this->load->view('siniestros/encuestas',$data);
            //$this->load->view('footers/footer');
        }
    }

    function encuesta_vista_ejemplo() {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } 
        else {
            $id = $this->input->get('id');
            $sql = 'WHERE idEncuesta = '.$id;
            $data['class'] = "";
            $data['survey'] = $this->siniestro_model->getSurvey($sql)[0];
            $data['id'] = "0";
            $data['mode'] = "example";
            $data['client'] = "";
            $data['employee'] = $this->db->query('SELECT name_complete FROM users WHERE idPersona = '.$this->tank_auth->get_idPersona())->row()->name_complete;
            $data['poliza'] = "00001";
            $data['questions'] = $this->createQuestionForSurvey($data['survey']->preguntas);
            $this->load->view('siniestros/encuesta_vista',$data);
        }
    }

    function encuesta_siniestro() { //Modificado [Suemy][2024-09-27]
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } 
        else {
            $idPersona = $this->input->get('pr');
            $poliza = $this->input->get('pz');
            $siniestro = $this->input->get('st');
            $employee = $idPersona;
            $data['client'] = "";
            $register = $this->checkExistenceSurvey($idPersona,$poliza,$siniestro);
            $client = $this->db->query("SELECT asegurado_nombre FROM siniestro_reportes WHERE siniestro_id = '".$siniestro."' AND poliza = '".$poliza."'")->row();
            $data['client'] = count($client) > 1 ? strtoupper($client[0]->asegurado_nombre) : strtoupper($client->asegurado_nombre);
            if (!empty($register['register']) || $register['status'] > 0) {
                $data['survey'] = $register['survey'];
                $data['class'] = $register['class'];
                $data['id'] = !empty($register['register']) ? $register['register'][0]->id : $register['status'];
                $data['mode'] = "client";
                $data['employee'] = $this->db->query('SELECT name_complete FROM users WHERE idPersona = '.$employee)->row()->name_complete;
                $data['poliza'] = $poliza;
                $data['questions'] = $this->createQuestionForSurvey($register['survey']->preguntas);
                //$data['data'] = $register[0];
                $this->load->view('siniestros/encuesta_vista',$data);
            }
            else { redirect('/GMM'); }
        }
    }

    function checkExistenceSurvey($idPersona,$poliza,$siniestro) {
        $sql = 'WHERE es.idRamo = 3 AND es.activa = 0 ORDER BY es.modificado DESC LIMIT 1';
        $data['class'] = "";
        $data['survey'] = $this->siniestro_model->getSurvey($sql)[0];
        $insert = array(
            "idEncuesta" => $data['survey']->idEncuesta,
            //"responsable" => $idPersona,
            "poliza" => $poliza,
            "siniestro" => $siniestro
        );
        $data['register'] = $this->siniestro_model->getSurveyExist($insert);
        if (!empty($data['register'])) {
            $data['action'] = "update";
            $data['class'] = $data['register'][0]->contestado != 0 ? "container-no-active-survey" : "";
            //$answers = $this->siniestro_model->getAnswerQuestionSurvey($register[0]->id);
            $employee = $data['register'][0]->responsable;
        }
        else {
            $data['action'] = "insert";
            $insert['responsable'] = $idPersona;
            $insert['contestado'] = "0";
            $insert['fechaCreacion'] = date("Y-m-d H:i:s");
            $data['status'] = $this->siniestro_model->insertSurveyResponse($insert);
        }
        return $data;
    }

    function createQuestionForSurvey($data) {
        $questions = "";
        if (!empty($data)) {
            foreach ($data as $key => $val) {
                $num = $key + 1;
                $options = $this->classifyQuestionsByType($val->idPregunta,$num,$val->respuesta,$val->tipo);
                $instructions = $val->tipo == 2 ? '(Siendo <b>1</b> la calificación más baja y <b>10</b> la calificación más alta)' : "";
                $questions .= '
                    <div class="container-question" id="q-'.$num.'">
                        <p class="textForm"><span id="q'.$num.'-text">'.$num.'.- '.$val->pregunta.' '.$instructions.'</span></p>
                        <div class="column-flex-space-evenly items-quiz">'.$options.'</div>
                    </div>
                ';
            }
        }
        else {
            $questions .= '<center>Aún no se agregan preguntas a esta encuesta.</center>';
        }
        return $questions;
    }

    function classifyQuestionsByType($id,$num,$answer,$type) {
        $options = '';
        switch ($type) {
            case '1':
                $option_type = $this->siniestro_model->getQuestionOptions($id);
                foreach ($option_type as $key => $val) {
                    $options .= '<div class="form-check column-flex-center-center pd-items-table"><input type="radio" class="form-check-input answer-quiz" data-num="'.$num.'" data-type="'.$type.'" data-resp="'.$answer.'" name="'.$id.'" value="'.$val->idOpcion.'"><label class="form-check-label">'.$val->titulo.'</label></div>';
                }
                break;
            case '2':
                for ($i=0;$i<10;$i++) {
                    $options .= '
                        <div class="form-check column-flex-center-center pd-items-table">
                            <input type="radio" class="form-check-input answer-quiz" data-num="'.$num.'" data-type="'.$type.'" data-resp="'.$answer.'" name="'.$id.'" value="'.($i + 1).'">
                            <label class="form-check-label">'.($i + 1).'</label>
                        </div>
                    ';
                }
                break;
            case '3':
                $options .= '
                    <div class="form-check column-flex-center-center pd-items-table">
                        <input type="radio" class="form-check-input answer-quiz" data-num="'.$num.'" data-type="'.$type.'" data-resp="'.$answer.'" name="'.$id.'" value="V">
                        <label class="form-check-label">Verdadero</label>
                    </div>
                    <div class="form-check column-flex-center-center pd-items-table">
                        <input type="radio" class="form-check-input answer-quiz" data-num="'.$num.'" data-type="'.$type.'" data-resp="'.$answer.'" name="'.$id.'" value="F">
                        <label class="form-check-label">Falso</label>
                    </div>
                ';
                break;
            case '4':
                $options .= '
                    <div class="form-check column-flex-center-center pd-items-table">
                        <input type="radio" class="form-check-input answer-quiz" data-num="'.$num.'" data-type="'.$type.'" data-resp="'.$answer.'" name="'.$id.'" value="Y">
                        <label class="form-check-label">Sí</label>
                    </div>
                    <div class="form-check column-flex-center-center pd-items-table">
                        <input type="radio" class="form-check-input answer-quiz" data-num="'.$num.'" data-type="'.$type.'" data-resp="'.$answer.'" name="'.$id.'" value="N">
                        <label class="form-check-label">No</label>
                    </div>
                ';
                break;
            case '5':
                $option_type = $this->siniestro_model->getQuestionOptions($question);
                foreach ($option_type as $key => $val) {
                    $options .= '<input type="checkbox" class="form-check-input answer-quiz" data-num="'.$num.'" data-type="'.$type.'" data-resp="'.$answer.'" name="'.$id.'" value="'.$val->idOpcion.'"><label class="form-check-label">'.$val->titulo.'</label>';
                }
                break;
            case '6':
                $options .= '
                    <div class="form-check column-flex-center-center pd-items-table">
                        <input type="text" class="form-check-input answer-quiz" data-num="'.$num.'" data-type="'.$type.'" data-resp="" name="'.$id.'">
                    </div>
                ';
                break;
        }
        return $options;
    }

    function updateDataSurvey() {
        $upd = $this->input->post('up');
        $ans = $this->input->post('in');
        $consult = $this->siniestro_model->getCompleteResponse($upd[3]);
        $update = array(
            "folio" => $upd[2],
            "hora_ingreso" => $upd[0],
            "fecha_ingreso" => $upd[1],
            "contestado" => "1",
            "fechaRespuesta" => date("Y-m-d H:i:s")
        );
        $data['status_update'] = $this->siniestro_model->updateResponseSurvey($upd[3],$update);
        if ($data['status_update']) {
            foreach ($ans as $key => $val) {
                $insert = array(
                    "idResuelta" => $upd[3],
                    "idEncuesta" => $upd[4],
                    "idPregunta" => $val['question'],
                    "respuesta" => $val['value'],
                    "fecha" => date("Y-m-d H:i:s")
                );
                if (!empty($consult)) {
                    foreach ($consult as $row) {
                        if ($row->idResuelta == $upd[3] && $row->idEncuesta == $upd[4] && $row->idPregunta == $val['question']) {
                            $id = $row->idRespuesta;
                            $data['status_insert'] = $this->siniestro_model->updateAnswerQuestionSurvey($id,$insert);
                        }
                    }
                }
                else {
                    $data['status_insert'] = $this->siniestro_model->insertAnswerQuestionSurvey($insert);
                }
            }
            //Enviar correo
            $result = $this->siniestro_model->getCompleteResponse($upd[3])[0];
            $info['title'] = "Encuesta de Siniestros Completada";
            $info['message'] = 'Se ha contestado una Encuesta con el Número de Siniestro <strong>'.$result->siniestro.'</strong> correspondiente a la póliza <strong>'.$result->poliza.'</strong>, que fue realizado por '.$result->name_complete.'. El folio de esta Encuesta es <strong>'.$result->folio.'</strong>';
            $message = $this->load->view('email/alert',$info,TRUE);
            //-->Vendedor
            $data_send = array(
                "addressee" => 'Avisos de GAP <avisosgap@aserorescapital.com>',
                "mailer" => $result->email,
                "subject" => 'Encuesta Siniestros',
                "message" => $message,
            );
            $send['send_vend'] = $data_send;
            $send['status_send_vend'] = !empty($result->email) ? $this->send_email($data_send) : "Error";
            //-->Coordinador | Jefe
            $con = $this->siniestro_model->getPersonById($result->responsable)[0];
            $to = "";
            if ($con->tipoPersona == 1) {
                $responsible = $this->siniestro_model->getBoosById($result->responsable,1)[0];
                $to = $responsible->jefeEmail;
            }
            else if ($con->tipoPersona == 3) {
                $responsible = $this->siniestro_model->getBoosById($result->responsable,2)[0];
                $to = $responsible->userEmailCreacion;
            }
            $data_send = array(
                "addressee" => 'Avisos de GAP <avisosgap@aserorescapital.com>',
                "mailer" => $to,
                "subject" => 'Encuesta Siniestros',
                "message" => $message,
            );
            $send['send_coord'] = $data_send;
            $send['status_send_coord'] = !empty($to) ? $this->send_email($data_send) : "Error";
        }
        //$data['consult'] = $consult;
        $data['actions'] = array("update" => $update, "insert" => $insert);
        $data['send'] = $send;
        $data['data'] = array("update" => $upd, "insert" => $ans);
        echo json_encode($data);
    }

    function searchInformationResponseSurvey() {
        //$survey = $this->input->get('sr');
        $month = $this->input->get('mt');
        $year = $this->input->get('yr');
        $type = $this->input->get('tp');
        $sql = 'WHERE esr.contestado = 1 AND YEAR(esr.fechaRespuesta) = '.$year;
        if ($month != "todos") { $sql .= ' AND MONTH(esr.fechaRespuesta) = '.$month; }
        //if ($survey != "todos") { $sql .= ' AND esr.idEncuesta = '.$survey; }
        $sql .= ' ORDER BY esr.fechaRespuesta DESC';
        $data = $this->siniestro_model->getInformationResponseSurvey($sql);
        if ($type == 1) {
            echo json_encode($data);
        }
        else {
            $title = "Resultados ".date("Y-m-d H:i:s");
            $header = array("0" => "#", "1" => "Folio", "2" => "Encuesta", "3" => "Siniestro", "4" => "Poliza", "5" => "Asegurado", "6" => "Agente", "7" => "Atendido por", "8" => "Hora Ingreso", "9" => "Fecha Ingreso", "10" => "Fecha");
            $body = array();
            foreach ($data as $key => $val) {
                $add[0] = $key + 1;
                $add[1] = $val->id;
                $add[2] = $val->encuesta;
                $add[3] = $val->siniestro;
                $add[4] = $val->poliza;
                $add[5] = $val->agente;
                $add[6] = $val->asegurado_nombre;
                $add[7] = $val->responsable_nombre;
                $add[8] = $val->hora_ingreso;
                $add[9] = date('d/m/Y',strtotime($val->fecha_ingreso));
                $add[10] = date('d/m/Y',strtotime($val->fechaRespuesta));
                array_push($body, $add);
            }
            $this->exportQueryData("Resultados",$title,$header,$body);
        }
    }

    function getCompleteInformationSurvey() {
        $survey = $this->input->get('sv');
        $month = $this->input->get('mt');
        $year = $this->input->get('yr');
        $type = $this->input->get('tp');
        $sql['sql_e'] = $survey != "todos" ? 'AND idEncuesta = '.$survey : "";
        $sql['sql_a'] = 'AND YEAR(esr.fechaRespuesta) = '.$year;
        $sql['sql_r'] = 'AND YEAR(esr.fechaCreacion) = '.$year;
        //Aprender introducción de IF en SQL
        $sql['sql_d'] = 'WHERE ramo = "gmm" AND tipo_documento = "Encuesta" AND YEAR(registro) = '.$year;
        if ($month != "todos") {
            $sql['sql_a'] .= ' AND MONTH(esr.fechaRespuesta) = '.$month;
            $sql['sql_r'] .= ' AND MONTH(esr.fechaCreacion) = '.$month;
            $sql['sql_d'] .= ' AND MONTH(registro) = '.$month;
        }
        $sql['sql_a'] .= ' ORDER BY esr.fechaRespuesta DESC';
        $sql['sql_r'] .= ' ORDER BY esr.fechaRespuesta DESC';
        $data['result'] = $this->siniestro_model->getInformationCompleteSurvey($sql);
        $data['sql'] = $sql;
        if ($type == 1) {
            echo json_encode($data);
        }
        else {
            $title = "Respuestas ".date("Y-m-d H:i:s");
            $header = array("0" => "N°", "1" => "Folio", "2" => "Siniestro", "3" => "Poliza", "4" => "Agente", "5" => "Asegurado", "6" => "Hora Ingreso", "7" => "Fecha Ingreso", "8" => "Estado", "9" => "Fecha Creacion", "10" => "Fecha Respuesta");
            $body = array();
            $generate = $data['result'][0]->generadas;
            $question = $data['result'][0]->preguntas;
            $response = $data['result'][0]->resueltas;
            foreach ($question as $val) {
                array_push($header,$val->pregunta);
            }
            foreach ($generate as $key => $val) {
                $num = $key + 1;
                $field = 11;
                $answers = $val->respuestas;
                $add[0] = $num;
                $add[1] = $val->id;
                $add[2] = $val->siniestro;
                $add[3] = $val->poliza;
                $add[4] = $val->agente;
                $add[5] = strtoupper($val->asegurado_nombre);
                $add[6] = $val->hora_ingreso;
                $add[7] = !empty($val->fecha_ingreso) ? date('d/m/Y',strtotime($val->fecha_ingreso)) : "";
                $add[8] = $val->contestado != 0 ? "Resuelto" : "Pendiente";
                $add[9] = date('d/m/Y',strtotime($val->fechaCreacion));
                $add[10] = !empty($val->fechaRespuesta) ? date('d/m/Y',strtotime($val->fechaRespuesta)) : "";
                if (!empty($answers)) {
                    foreach ($answers as $row) {
                        $anw = $row->respuesta;
                        switch ($row->tipo) {
                            case '1': $anw = $row->opcion; break;
                            case '3': $anw = $row->respuesta == "V" ? "Verdadero" : "Falso"; break;
                            case '4': $anw = $row->respuesta == "Y" ? "Sí" : "No"; break;
                        }
                        $add[$field] = $anw;
                        $field++;
                    }
                }
                else {
                    $qt = count($question);
                    $anw = "";
                    for ($i=0;$i<$qt;$i++) {
                        $add[$field] = $anw;
                        $field++;
                    }
                }
                array_push($body, $add);
            }
            /*$data['title'] = $title;
            $data['header'] = $header;
            $data['body'] = $body;
            echo json_encode($data);*/
            $this->exportQueryData("Respuestas",$title,$header,$body);
        }
    }

    function getAnswersBySurvey() {
        $survey = $this->input->get('id');
        $sql['sql_e'] = 'AND idEncuesta = '.$survey;
        $data = $this->siniestro_model->getInformationCompleteSurvey($sql);
        echo json_encode($data);
    }

    function getCreatedSurveys() {
        $data = $this->siniestro_model->getSurvey();
        echo json_encode($data);
    }

    function getCreatedQuestionsOfSurvey() {
        $data = $this->siniestro_model->getQuestionSurvey($this->input->get('id'));
        echo json_encode($data);
    }

    function getOptionsByQuestion() {
        $data = $this->siniestro_model->getQuestionOptions($this->input->get('id'));
        echo json_encode($data);
    }

    function getAnswersQuestionByClient() {
        $id = $this->input->get('id');
        $data = $this->siniestro_model->getAnswerQuestionSurvey($id);
        echo json_encode($data);
    }

    function insertDataForCreateSurvey() {
        $action = $this->input->post('ac');
        $dd = $this->input->post('in');
        $insert = array(
            "titulo" => $dd[0],
            "descripcion" => (isset($dd[3]) ? (strlen($dd[3]) > 1 ? $dd[3] : "")  : ""),
            "idRamo" => $dd[1],
            "tipo" => $dd[2]
        );
        if ($action == 1) {
            $insert['activa'] = "0";
            $insert['creado_por'] = $this->tank_auth->get_idPersona();
            $insert['fechaCreacion'] = date("Y-m-d H:i:s");
            //$data['status'] = $this->siniestro_model->insertSurvey($insert);
        }
        else {
            $id = isset($dd[4]) ? $dd[4] : $dd[3];
            $data['status'] = $this->siniestro_model->updateSurvey($id,$insert);
        }
        $data['insert'] = $insert;
        echo json_encode($data);
    }

    function insertDataForCreateQuestion() {
        $action = $this->input->post('ac');
        $dd = $this->input->post('in');
        $insert = array(
            "idEncuesta" => $dd[0],
            "pregunta" => $dd[1],
            "respuesta" => (isset($dd[3]) ? $dd[3] : ""),
            "tipo" => $dd[2]
        );
        if ($action == 1) {
            $insert['creado_por'] = $this->tank_auth->get_idPersona();
            $insert['registro'] = date("Y-m-d H:i:s");
            //$data['status'] = $this->siniestro_model->insertQuestionSurvey($insert);
        }
        else {
            $id = isset($dd[4]) ? $dd[4] : $dd[3];
            $data['status'] = $this->siniestro_model->updateQuestionSurvey($id,$insert);
        }
        //$data['title'] = $this->db->query('SELECT titulo FROM encuesta_siniestro WHERE idEncuesta = '.$dd[0])->row()->titulo;
        $data['insert'] = $insert;
        echo json_encode($data);
    }

    function insertOptionsByQuestion() {
        $insert = array(
            "idPregunta" => $this->input->post('id'),
            "titulo" => $this->input->post('tx'),
            "registro" => date("Y-m-d H:i:s")
        );
        $data['status'] = $this->siniestro_model->insertQuestionOptions($insert);
        $data['insert'] = $insert;
        echo json_encode($data);
    }

    function deleteQuestion() {
        $id = $this->input->post('id');
        $data['status'] = $this->siniestro_model->deleteQuestionSurvey($id);
        $data['data'] = $id;
        echo json_encode($data);
    }

    function exportQueryData($sheet,$title,$header,$body) {
        $cells = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","AA","AB","AC","AD","AE","AF","AG","AH","AI","AJ","AK","AL","AM","AN","AO","AP","AQ","AR","AS","AT","AU","AV","AW","AX","AY","AZ");
        //Styles
        $header_s = [
            'font' => [
                'bold'  =>  true,
                'color' => array('rgb' => 'FFFFFF'),
            ],
            'alignment' => [
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            ],
            'fill' =>[
              'type'=>PHPExcel_Style_Fill::FILL_SOLID,
              'color' => ['rgb' => '1e4c82']
            ],
            'borders' => [
                'top' => [
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => ['rgb' => '7C7C7C']
                ]
            ],
        ];
        $body_s = [
            'font' => [
                'bold'  =>  false,
                'color' => array('rgb' => '000000'),
            ],
            'borders' => [
                'outline' => [
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => ['rgb' => '7C7C7C']
                ]
            ],
        ];
        $cellI = 1;
        $row = 2;
        $this->excel->setActiveSheetIndex(0);
        $this->excel->getActiveSheet()->setTitle($sheet);
        foreach ($header as $key => $val) {
            $letter = strval($cells[$key]);
            $cell = strval($cells[$key].'1');
            $name = strval($val);
            $this->excel->getActiveSheet()->getColumnDimension($letter)->setWidth(25);
            $this->excel->getActiveSheet()->setCellValue($cell,$name)->getStyle($cell)->applyFromArray($header_s);  
        }
        foreach ($body as $key => $value) {
            $length = count($body);
            $length = $length != 0 ? $length - 1 : 0;
            $value_c = count($value);
            $value_c = $value_c != 0 ? $value_c - 1 : 0;
            foreach ($value as $k => $val) {
                $cell = strval($cells[$k].$row);
                $text = strval($val);
                $this->excel->getActiveSheet()->setCellValue($cell,$text)->getStyle($cell)->applyFromArray($body_s);
            }
            $row++;
        }
        $row = $row + 3;

        header("Content-Type: aplication/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=\"$title.xls\"");
        header("Cache-Control: max-age=0");

        $writer = PHPExcel_IOFactory::CreateWriter($this->excel,"Excel5");
        file_put_contents('depuracion.txt', ob_get_contents());
        ob_end_clean();
        $writer->save("php://output");
    }

    function archivos_encuesta() {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        } else {
            $idPersona = $this->input->get('pr');
            $data['poliza'] = $this->input->get('pz');
            $data['siniestro'] = $this->input->get('st');
            $ramo = $this->input->get('rm');

            $data['idPersona'] = $idPersona;
            $data['email']  = $this->db->query('SELECT email FROM users WHERE idPersona = '.$idPersona)->row()->email;
            //Employee
            $typeUser = "Colaborador";
            $con = $this->siniestro_model->getPersonById($data['idPersona'])[0];
            if ($con->tipoPersona == 3) { $typeUser = "Agente"; }
            $agent = array("Agente" => array($con));
            $employee = ($con->tipoPersona == 1) ? $this->capitalhumano_model->devolverPuestos(1) : $agent;
            $data['typeUser'] = $typeUser;
            $data['nameUser'] = $con->apellidoPaterno." ".$con->apellidoMaterno." ".$con->nombres;
            //Ramos
            $optionR = '';
            $optionF = '';
            $ramos = $this->db->query('SELECT * FROM `catalog_ramos`')->result();
            foreach ($ramos as $val) {
                $valueRamo = "";
                switch ($val->IDRamo) {
                    case 1: $valueRamo = "danios"; break;
                    case 2: $valueRamo = "autos"; break;
                    case 3: $valueRamo = "gmm"; break;
                    default: $valueRamo = strtolower($val->Nombre); break;
                }
                switch ($ramo) {
                    case 'GMM':
                        if ($val->IDRamo == 3) {
                            $optionR .= '<option value="'.$val->Nombre.'">'.$val->Nombre.'</option>';
                            $optionF .= '<option value="'.$valueRamo.'">'.$val->Nombre.'</option>';
                        }
                    break;
                    case 'AUTO':
                        if ($val->IDRamo == 2) {
                            $optionR .= '<option value="'.$val->Nombre.'">'.$val->Nombre.'</option>';
                            $optionF .= '<option value="'.$valueRamo.'">'.$val->Nombre.'</option>';
                        }
                    break;
                }                
            }
            $data['selectR'] = $optionR;
            $data['selectF'] = $optionF;
            $data['permission'] = 0;
            $this->load->view('headers/header');
            $this->load->view('headers/menu');
            $this->load->view('siniestros/archivos_encuesta',$data);
        }
    }
}	
