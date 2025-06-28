<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


include( __DIR__  . '/google/autoload.php');
include( __DIR__  . '/class/autoload.cenis.php');
define('CREDENTIALS_PATH', __DIR__ . '/configure/credentials/calendar-php.json');
define("PATH_CONFIGURE" , __DIR__  . "/configure/client_secret_4568272251-ts54cecsgth67t76utkksqf68tqfhpgf.apps.googleusercontent.com.json");


class calendarcenis {
	
	var $client;
	var $service;
	var $calendarId;
	var $email;
	var $displayName;
	var $AuthConfigFile;
	protected $oEventDelete;
	protected $oEventCreate;
	protected $oEventUpdate;
	protected $oCreateRule;
	protected $oMe;
	protected $oGetEvent;
	protected $ogetcolorsEvent;
	protected $oGetCalendar;
	protected $nombre_calendario;
	protected $lsNombre_calendario;
	protected $lsEvents;
	
	public function __construct(){
		
        $this->client = new Google_Client();
	  	$this->client->addScope(Google_Service_Calendar::CALENDAR);
		$this->client->addScope(Google_Service_Calendar::CALENDAR_READONLY);


		$this->AuthConfigFile = PATH_CONFIGURE;
		$this->client->setAuthConfigFile($this->AuthConfigFile);
	  	$this->client->setAccessType('offline');

		  // Load previously authorized credentials from a file.
	  	$credentialsPath = $this->expandHomeDirectory(CREDENTIALS_PATH);
	  	if (file_exists($credentialsPath)) {
    		$accessToken = file_get_contents($credentialsPath);
	  	} else {
		    // Request authorization from the user.
	    	$authUrl = $this->client->createAuthUrl();
		    printf("Open the following link in your browser:\n%s\n", $authUrl);
		    print 'Enter verification code: ';
			$authCode = trim(fgets(STDIN));
			//$authCode="4/3wFBpQIUUoUXpL3F1fTQuSTG4m5g4CSkFuwje3-ztWvBjITYBPgRW4Y";

		    // Exchange authorization code for an access token.
		    $accessToken = $this->client->authenticate($authCode);

		    // Store the credentials to disk.
		    if(!file_exists(dirname($credentialsPath))) {
		      mkdir(dirname($credentialsPath), 0700, true);
		    }
		    file_put_contents($credentialsPath, $accessToken);
		    printf("Credentials saved to %s\n", $credentialsPath);
	  	}
	  	$this->client->setAccessToken($accessToken);

		  // Refresh the token if it's expired.
	  	if ($this->client->isAccessTokenExpired()) {
		    $this->client->refreshToken($this->client->getRefreshToken());
		    file_put_contents($credentialsPath, $this->client->getAccessToken());
	  	}

		if (strlen($this->AuthConfigFile) == 0){
				throw new Exception('La ruta del archivo no puede ser null o vacio.');
		}
		
		$this->service = new Google_Service_Calendar($this->client);
		$this->calendarId = "primary";
        
        
		
	}

	function expandHomeDirectory($path) {
	  $homeDirectory = getenv('HOME');
	  if (empty($homeDirectory)) {
	    $homeDirectory = getenv("HOMEDRIVE") . getenv("HOMEPATH");
	  }
	  return str_replace('~', realpath($homeDirectory), $path);
	}
	
	public function agregar_evento($json_event){	
	
		try{
		
			$status_organizer = false;
			$supportAttach = false;
			$CI =& get_instance();
			$Json_Event = $this->json_validate(json_encode($json_event));
			$CI->load->library('DriveCenis');

			if (strlen($Json_Event->TituloEvento) == 0){
				throw new Exception('El titulo del evento no puede ser null o vacio.');
			}
			// if (strlen($Json_Event->Descripcion) == 0){
				// throw new Exception('La descripcion del evento no puede ser null o vacio.');
			// }
			if ($this->validateDate($Json_Event->FechaInicio)){
				throw new Exception('La fecha de inico del evento no tiene el formato correcto');
			}
			if ($this->validateDate($Json_Event->FechaFinal)){
				throw new Exception('La fecha de inico del evento no tiene el formato correcto');
			}
						
			$creatorSelf = true;
			$creator = array (
						 //'id' => $this->email,
						 'email' => "SISTEMAS@ASESORESCAPITAL.COM",//$this->email,
						 'displayName' => "prueba",//$this->displayName,
						 'self' => $creatorSelf
					  );
					  
			$organizer  = array (
						 //'id' => $this->email,
						 'email' =>"SISTEMAS@ASESORESCAPITAL.COM", //$this->email,
						 'displayName' => "prueba",//$this->displayName,
						 'self' => $creatorSelf
					  );

			if(isset($Json_Event->allDay) && $Json_Event->allDay == "on"){
				
				$start =  array(				
						'date' => $Json_Event->FechaInicio,							
						'timeZone' => 'America/Mexico_City'
					 );
				$end = array(
							'date' => $Json_Event->FechaFinal,
							'timeZone' => 'America/Mexico_City'
						 );				
			}else{

				$timezone = new DateTimeZone("America/Mexico_City");
				$dt1 = new DateTime($Json_Event->FechaInicio." ".$Json_Event->starttime, $timezone);
				$dt2 = new DateTime($Json_Event->FechaFinal." ".$Json_Event->endtime, $timezone);

				$start =  array(
						'dateTime' => $dt1->format("c"), //$Json_Event->FechaInicio . "T" . $Json_Event->starttime .":00-06:00",						
						'timeZone' => 'America/Mexico_City'
						
					 );
				$end = array(
							'dateTime' => $dt2->format("c"), //$Json_Event->FechaFinal . "T" .  $Json_Event->endtime .":00-06:00",
							'timeZone' => 'America/Mexico_City'
						 );
			}
			
			
			$attendees = array();
			$invitadoInterno=array();
			if(isset($Json_Event->Correo)){
				foreach ($Json_Event->Correo as $valor) {
					array_push($attendees,array('email' => $valor));
					array_push($invitadoInterno, array(
						"email"=>$valor
					));
				}
			}

			//------------------------------------------------------------------------------
			//[Dennis 2020-06-26]
			$externalAttendees=array();
			//$externalEmailDB=array();
			if(isset($Json_Event->correo_externo)){
				foreach($Json_Event->correo_externo as $valor){
					array_push($externalAttendees, array(
						"external_email"=> $valor
					));
					}
			}
			//------------------------------------------------------------------------------

			$attachments = array();

			if(isset($Json_Event->Attachment)){
				$supportAttach = true;
				
				foreach($Json_Event->Attachment as $valorAttch){				
					
					if(isset($Json_Event->Correo)){
						
						foreach ($Json_Event->Correo as $valor) {							
							$CI->drivecenis->insertPermissionEmail($valorAttch->id,$valor);
						}
					}
					
					array_push($attachments,array(
													'fileUrl' => $valorAttch->alternateLink,
													'fileId'  => $valorAttch->id,
													'mimeType' => $valorAttch->mimeType,
													'title'    => $valorAttch->title,
													'iconLink' => $valorAttch->iconLink
												)
							);
				}		
			}
			
			
			
			
			
			if (!in_array(array('email' => $this->email), $attendees,false)) {				
				$status_organizer = "activo";
				array_push($attendees,array('email' =>  $this->email,'organizer'=> true,'responseStatus' => 'accepted' ));
							}
			
			$event = new Event();
			
			if(isset($Json_Event->free_busy)){			
				$event->setTransparency($Json_Event->free_busy);
			}			
			$event->setSummary(html_entity_decode($Json_Event->TituloEvento));
			if(isset($Json_Event->Lugar))
				$event->setLocation(html_entity_decode($Json_Event->Lugar));
			
			if(isset($Json_Event->TipoEvento)){
				$event->setVisibility($Json_Event->TipoEvento);
			}
			$event->setDescription(html_entity_decode($Json_Event->Descripcion));
			$event->setCreator($creator);
			$event->setOrganizer($organizer);
			
			$event->setStart($start);
			$event->setEnd($end);
			
			
			$event->setAttendees($attendees); //$attendees
			$event->setAttachment($attachments);
			$event->setSupportsAttachments($supportAttach);			
			if(isset($Json_Event->Repetir)){
				$recurrence = array($Json_Event->Repetir);
				$event->setRecurrence($recurrence);
			}
			
			if(isset($Json_Event->ColorId)){
				$color = $Json_Event->ColorId;
				$event->setColorId($color);
			}		
			
			$event_calendar = new Google_Service_Calendar_Event($event->ReturnArray());						
			$event_optional = array("sendNotifications" => false , "supportsAttachments" => $supportAttach);
			$this->oEventCreate = $this->service->events->insert($this->calendarId, $event_calendar,$event_optional);

			$data_table = array(
					'cal_id' => $this->oEventCreate->getId(),
					'title' => html_entity_decode($Json_Event->TituloEvento),
					'color' => $Json_Event->ColorId,
					'correo' => $this->email,
					'estatusOrganizador' => $status_organizer,
					'created_by' => $this->email,
					'created_on' => $Json_Event->FechaInicio . "T" . $Json_Event->starttime .":00-05:00",
					'clasificacion'=>$Json_Event->clasificacion, //[Dennis 2020-06-11]
					'categoria_capacitacion'=>$Json_Event->categoria_capa,
					'sub_categoria_capacitacion'=>$Json_Event->subCategoria_capa,
					'ramo_capacitacion'=>$Json_Event->ramo_capa
			);
			//--------------------------------------------------------------------------------------------------
			
			$datosCorreo=array(
				"correo"=>$this->email,
				"titulo"=>$Json_Event->TituloEvento,
				"descripcion"=>$Json_Event->Descripcion,
				"fecha_inicio"=>$Json_Event->FechaInicio,
				"fecha_final"=>$Json_Event->FechaFinal,
				"hora_inicio"=>$Json_Event->starttime,
				"hora_final"=>$Json_Event->endtime,
				"lugar"=>$Json_Event->Lugar,
				"clasificacion" =>$Json_Event->clasificacion,
				"destinatarios"=>$attendees,
				"destinatario_externo"=>$externalAttendees,
				"idEvento"=> $this->oEventCreate->getId(),
				"linkEvento"=>$this->oEventCreate->htmlLink,
				"linkMeet"=>$this->oEventCreate->hangoutLink,
				"iCal"=>$this->oEventCreate->getICalUID(),
				"adjuntos"=>$attachments,
				"sub_categoria_capacitacion"=>$Json_Event->subCategoria_capa,
				"ramo_capacitacion"=>$Json_Event->ramo_capa,
				"liga"=>$Json_Event->urlZoom,
				"password"=>$Json_Event->pswZoom,
				"idLiga"=>$Json_Event->idZoom,
				"tipo"=>1
			);
						
			$CI->load->model(array('calendar_model','emailmasivo_model','zoom_model','crmproyecto_model'));
			
			//Miguel [05-03-2021]
			//Guardar en tabla cal_events_json
			$CI->crmproyecto_model->setCalEventsJson($datosCorreo); //Descomentar
			//________

			$CI->calendar_model->Insert_Cal($data_table); //Insertar en tabla de eventos //Descomentar
			$externalEmailDB=array();

			if(isset($Json_Event->correo_externo)){
				foreach($Json_Event->correo_externo as $valor){
					array_push($externalEmailDB, array(
						"correo_externo"=> $valor,
						"activo"=>1,
						"id_evento"=>$this->oEventCreate->getId()
					));
				}
			}

			if(!empty($externalEmailDB)){ //Nuevo
				$CI->calendar_model->insertaInvitadoExterno($externalEmailDB, "catalog_correos_externos");
			}
			if(!empty($invitadoInterno)){ //Nuevo
				$this->guestManage($invitadoInterno, $this->oEventCreate->getId());
			}

			//Miguel [05-03-2021]
			//Enviar los correo del evento
			$this->enviarCorreosEvento($this->oEventCreate->getId(),$this->email); //Descomentar
			//__________
			
		}catch(Exception $e ){
			echo 'Excepci&oacute;n capturada: ',  $e->getMessage(), "\n";
		}
		
		return json_encode($this->oEventCreate);
	}

	//Funcion para enviar correo de convocatoria de reunion
	function enviarCorreosEvento($id, $emailOrganizador){ //Nuevo

		$i=0;
		$CI =& get_instance();
		$CI->load->model("calendar_model");
		$arrayInternos = array();
		$arrayExternos = array();

		$correosExt=$CI->crmproyecto_model->getAllEmailConvocatoriaExternos($id);
		foreach ($correosExt as $correoExt) {

			array_push($arrayExternos, array(
				"correo" => $correoExt->correo_externo,
				"idInvitado" => $correoExt->idCorreoExt,
				"tipo" => "externo"
			));
			//$correos[$i]=$correoExt->correo_externo;
			//$i++;
		}
		$correosInt=$CI->crmproyecto_model->getAllEmailConvocatoriaInternos($id);
		foreach ($correosInt as $correoInt) {

			array_push($arrayInternos, array(
				"correo" => $correoInt->correo_lectronico,
				"idInvitado" => $correoInt->id_invitado,
				"tipo" => "interno"
			));

		//$correos[$i]=$correoInt->correo_lectronico;
		//$i++;
		}
		
		$allEmails = array_merge($arrayInternos, $arrayExternos);
		$convocatoria=$CI->crmproyecto_model->getConvocatoriaReunionJson($id);
		$asunto="Convocatoria de Reunion - Capital Seguros y Fianzas";
		$desde="Avisos GAP<avisos@agentecapital.com>";

		$infoEvent = array();
		$infoEvent["titulo"] = $convocatoria->titulo;
		$infoEvent["fHInicio"] = $convocatoria->fecha_inicio." - ".$convocatoria->hora_inicio." hrs";
		$infoEvent["fHFinal"] = $convocatoria->fecha_final." - ".$convocatoria->hora_final." hrs";
		$infoEvent["clasificacion"] = $convocatoria->clasificacion;
		$infoEvent["capacitacion"] = $convocatoria->sub_categoria_capacitacion;
		$infoEvent["estadoEvento"] = "nuevo"; 
		$infoEvent["subTitulo"] = "Usted ha sido convocado a la siguiente reunión"; //Usted ha convocado la siguiente Reunion
		$infoEvent["evento"] = $convocatoria->id_cal;

		//allEmails
		//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($allEmails, TRUE));fclose($fp);
		foreach($allEmails as $allEmails_){
			
			$infoEvent["invitado"] = $allEmails_["idInvitado"];
			$infoEvent["tipo"] = $allEmails_["tipo"];
			$mensaje_ = $CI->load->view("accesoAEvento/vistaCorreo", $infoEvent, true);

			//$data['to']=$allEmails_["correo"];
			//$data['titulo']=$asunto;
			//$data['mensaje']=$mensaje_;
			//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($data, TRUE));fclose($fp);

			$insert = $CI->calendar_model->insertaRegistro(array(
				"from" => $desde,
				"to" => $allEmails_["correo"],
				"subject" => $asunto,
				"message" => $mensaje_,
				"status" => 0,
				"dateCreation" => date("Y-m-d H:i:s"),
				"type" => "new",
			), "calendar_event_notification", 1);
			//$this->get_envio_mailjet($data);
			//$sql="INSERT INTO envio_correos(desde,para,asunto,mensaje,status,fechaEnvio,identificaModulo) values('$desde','".$allEmails["correo"]."','$asunto','$mensaje_',0,now(),'Convocatoria de Reunion')";
			//$rs=$CI->db->query($sql);

		}
	}
	
	public function eliminar_evento($json_event){
		
		try{	
			
			$Json_Event = $this->json_validate(json_encode($json_event));
			
			if (strlen($Json_Event->eventId) == 0){
				throw new Exception('El eventId del evento no puede ser null o vacio.');
			}
			if($Json_Event->enviarNotificacion){
				$event_optional = array("sendNotifications" => false );
			}else{
				$event_optional = array();
			}

			$envio = $this->notificacion_cancelacion($Json_Event->eventId);
			$delete = $envio ? $this->eliminaInfo($Json_Event->eventId) : false;

			if($Json_Event->eliminarInstancias && $delete){
				$this->oEventDelete = $this->service->events->delete($this->calendarId, $Json_Event->eventId, $event_optional);
			}else{
				
				$this->oEventDelete = $this->service->events->instances($this->calendarId, $Json_Event->eventId);

				while(true) {
				 
				  $pageToken = $this->oEventDelete->getNextPageToken();
				  if ($pageToken) {
					$optParams = array('pageToken' => $pageToken);
					$this->oEventDelete = $this->service->events->instances($this->calendarId, $Json_Event->eventId,
						$optParams);
				  } else {
					break;
				  }
				}
			}
		
		}catch(Exception $e ){
			echo 'Excepci&oacute;n capturada: ',  $e->getMessage(), "\n";
		}
		
		return json_encode($this->oEventDelete);
	}
	
	public function actualizar_evento($json_event){		
		try{
			
			$Json_Event = $this->json_validate(json_encode($json_event));
			
			$status_organizer = false;
			$supportAttach = false;
			$CI =& get_instance();
			$CI->load->library('DriveCenis');
			if (strlen($Json_Event->TituloEvento) == 0){
				throw new Exception('El titulo del evento no puede ser null o vacio.');
			}
			
			if ($this->validateDate($Json_Event->FechaInicio)){
				throw new Exception('La fecha de inico del evento no tiene el formato correcto');
			}
			if ($this->validateDate($Json_Event->FechaFinal)){
				throw new Exception('La fecha de inico del evento no tiene el formato correcto');
			}
						
			$creatorSelf = true;
			
			
			$creator = array (
						 //'id' => $this->email,
						 'email' => $this->email,
						 'displayName' => $this->displayName,
						 'self' => $creatorSelf
					  );
					  
			$organizer  = array (
						 //'id' => $this->email,
						 'email' => $this->email,
						 'displayName' => $this->displayName,
						 'self' => $creatorSelf
					  );
					  
			
			
			if(isset($Json_Event->allDay) && $Json_Event->allDay == "on"){
				
				$start =  array(				
						'date' => $Json_Event->FechaInicio,							
						'timeZone' => 'America/Mexico_City'
					 );
						
				$end = array(
							'date' => $Json_Event->FechaFinal,
							'timeZone' => 'America/Mexico_City'
						 );
				
			}else{
								$timezone = new DateTimeZone("America/Mexico_City");
				$dt1 = new DateTime($Json_Event->FechaInicio." ".$Json_Event->starttime, $timezone);
				$dt2 = new DateTime($Json_Event->FechaFinal." ".$Json_Event->endtime, $timezone);

				$start =  array(
					//'dateTime' => $Json_Event->FechaInicio . "T" . $Json_Event->starttime .":00Z",						
					'dateTime' => $dt1->format("c"), //$Json_Event->FechaInicio . "T" . $Json_Event->starttime .":00-06:00",						
					//'dateTime' => $datetime_ini,						
					'timeZone' => 'America/Mexico_City'
					//'timeZone' => date_default_timezone_get()
				);
					
				$end = array(
						'dateTime' => $dt2->format("c"), //$Json_Event->FechaFinal . "T" .  $Json_Event->endtime .":00-06:00",
						'timeZone' => 'America/Mexico_City'
						//'timeZone' => date_default_timezone_get()
				);
				
			}
			
			
			$attendees = array();
			$invitadoInterno=array();
			if(isset($Json_Event->Correo)){
				foreach ($Json_Event->Correo as $valor) {
					
					array_push($attendees,array('email' => $valor));
					array_push($invitadoInterno, array("email"=>$valor, "tipo" => "interno"));
				}
			}

			//------------------------------------------------------------------------------------
			//[Dennis 2020-06-26]
			$externalAttendees=array();
			if(isset($Json_Event->correo_externo)){
				foreach($Json_Event->correo_externo as $valor){
					array_push($externalAttendees, array("email"=> $valor, "tipo" => "externo"));
				}
			}
			//-------------------------------------------------------------------------------------
			
			$attachments = array();
			
			if(isset($Json_Event->Attachment)){
				$supportAttach = true;
				
				foreach($Json_Event->Attachment as $valorAttch){	
					
					
					if(isset($Json_Event->Correo)){						
						foreach ($Json_Event->Correo as $valor) {							
							$CI->drivecenis->insertPermissionEmail($valorAttch->id,$valor);
						}
					}
					
					array_push($attachments,array(
													'fileUrl' => $valorAttch->alternateLink,
													'fileId'  => $valorAttch->id,
													'mimeType' => $valorAttch->mimeType,
													'title'    => $valorAttch->title,
													'iconLink' => $valorAttch->iconLink
												)
							);
				}		
			}

			
			$title=array();
			$this->oGetEvent=$this->service->events->get("primary",$Json_Event->eventId);

			//$title["titulo_anterior"]=$this->oGetEvent->getSummary();
			//$title["titulo_actual"]=$Json_Event->TituloEvento;
			//$title["id_evento"]=$Json_Event->eventId;

			//----------------------------------------------------------------------
			
			if (!in_array(array('email' => $this->email), $attendees,false)) {				
				//array_push($attendees,array('email' => $this->email,'organizer'=> true ));
				if(isset($Json_Event->OrganizerCancel) && !empty($Json_Event->OrganizerCancel)){
					$status_organizer = "cancelado";
					//array_push($attendees,array('email' => $this->email,'organizer'=> true, 'responseStatus' => 'declined' ));
					array_push($attendees,array('email' =>  $this->email,'organizer'=> true, 'responseStatus' => 'declined' ));
				}else{
					$status_organizer = "activo";
					array_push($attendees,array('email' =>  $this->email,'organizer'=> true, 'responseStatus' => 'accepted' ));
				}				
			}
			
			$event = new Event();
			
			if(isset($Json_Event->free_busy)){			
				$event->setTransparency($Json_Event->free_busy);
			}			
			$event->setSummary(html_entity_decode($Json_Event->TituloEvento));
			if(isset($Json_Event->Lugar))
				$event->setLocation(html_entity_decode($Json_Event->Lugar));
			
			if(isset($Json_Event->TipoEvento)){
				$event->setVisibility($Json_Event->TipoEvento);
			}
			$event->setDescription(html_entity_decode($Json_Event->Descripcion));
			$event->setCreator($creator);
			//if()
			$event->setOrganizer($organizer);
			
			$event->setStart($start);
			$event->setEnd($end);
			
			
			$event->setAttendees($attendees);	
			$event->setAttachment($attachments);
			$event->setSupportsAttachments($supportAttach);			
			if(isset($Json_Event->Repetir)){
				$recurrence = array($Json_Event->Repetir);
				$event->setRecurrence($recurrence);
			}
			
			if(isset($Json_Event->ColorId)){
				$color = $Json_Event->ColorId;
				$event->setColorId($color);
			}		
			
			
			$event_calendar = new Google_Service_Calendar_Event($event->ReturnArray());			
			
			$event_optional = array("sendNotifications" => false,"supportsAttachments" => true );
			
			$this->oEventUpdate = $this->service->events->update($this->calendarId,$Json_Event->eventId, $event_calendar);
			
			/*$data_table = array(
					'cal_id' => $this->oEventUpdate->getId(),
					'title' => $Json_Event->TituloEvento,
					'color' => $Json_Event->ColorId,
					'correo' => $this->email,
					'estatusOrganizador' => $status_organizer,
					'modified_by' => $this->email,
					'updated_on' => $Json_Event->FechaInicio . "T" . $Json_Event->starttime .":00-05:00",
					'clasificacion'=>$Json_Event->clasificacion, //[Dennis 2020-06-11]
					'categoria_capacitacion'=>$Json_Event->categoria_capa,
					'sub_categoria_capacitacion'=>$Json_Event->subCategoria_capa,
					'ramo_capacitacion'=>$Json_Event->ramo_capa
			);*/

			//-------------------------------------------------------------------------------------------------------------
			//[Dennis 2020-07-01]
			/*$datosCorreo=array(
				"correo"=>$this->email,
				"titulo"=>$Json_Event->TituloEvento,
				"descripcion"=>$Json_Event->Descripcion,
				"fecha_inicio"=>$Json_Event->FechaInicio,
				"fecha_final"=>$Json_Event->FechaFinal,
				"hora_inicio"=>$Json_Event->starttime,
				"hora_final"=>$Json_Event->endtime,
				"lugar"=>$Json_Event->Lugar,
				"clasificacion" =>$Json_Event->clasificacion,
				"destinatarios"=>$attendees,
				"destinatario_externo"=>$externalAttendees,
				"idEvento"=> $this->oEventUpdate->getId(),
				"linkEvento"=>$this->oEventUpdate->htmlLink,
				"iCal"=>$this->oEventUpdate->getICalUID(),
				"linkMeet"=>$this->oEventUpdate->hangoutLink,
				"adjuntos"=>$attachments,
				'sub_categoria_capacitacion'=>$Json_Event->subCategoria_capa,
				'ramo_capacitacion'=>$Json_Event->ramo_capa,
				'liga'=>$Json_Event->urlZoom,
				'password'=>$Json_Event->pswZoom,
				"tipo"=>2
			);*/
			//-------------------------------------------------------------------------------------------------------------
					
			$CI =& get_instance();
			$CI->load->model(array('calendar_model', 'crmproyecto_model'));
			//$CI->calendar_model->update_Cal($data_table);

			$lastEventData = $CI->crmproyecto_model->getConvocatoriaReunionJson($this->oEventUpdate->getId());
			$validateData = $this->validateUpdateData(
				array(
					"titulo" => $Json_Event->TituloEvento,
					"descripcion" => $Json_Event->Descripcion,
					"fecha_inicio" => $Json_Event->FechaInicio,
					"fecha_final" => $Json_Event->FechaFinal,
					"hora_inicio" => $Json_Event->starttime,
					"hora_final" => $Json_Event->endtime,
					"lugar" => $Json_Event->Lugar,
					"clasificacion" => $Json_Event->clasificacion,
					"sub_categoria_capacitacion" => $Json_Event->subCategoria_capa,
					"ramo_capacitacion" => $Json_Event->ramo_capa,
					"liga" => $Json_Event->urlZoom,
					"password" => $Json_Event->pswZoom,
					"idLiga" => $Json_Event->idZoom,
				),
				array(
					"titulo" => $lastEventData->titulo,
					"descripcion" => $lastEventData->descripcion,
					"fecha_inicio" => $lastEventData->fecha_inicio,
					"fecha_final" => $lastEventData->fecha_final,
					"hora_inicio" => $lastEventData->hora_inicio,
					"hora_final" => $lastEventData->hora_final,
					"lugar" => $lastEventData->lugar,
					"clasificacion" => $lastEventData->clasificacion,
					"sub_categoria_capacitacion" => $lastEventData->sub_categoria_capacitacion,
					"ramo_capacitacion" => $lastEventData->ramo_capacitacion,
					"liga" => $lastEventData->liga,
					"password" => $lastEventData->password,
					"idLiga" => $lastEventData->idLiga,
				)
			);

			//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($validateData, TRUE));fclose($fp);

			if($validateData){

				//$this->oEventUpdate = $this->service->events->update($this->calendarId,$Json_Event->eventId, $event_calendar);

				$data_table = array(
					'cal_id' => $this->oEventUpdate->getId(),
					'title' => $Json_Event->TituloEvento,
					'color' => $Json_Event->ColorId,
					'correo' => $this->email,
					'estatusOrganizador' => $status_organizer,
					'modified_by' => $this->email,
					'updated_on' => $Json_Event->FechaInicio . "T" . $Json_Event->starttime .":00-05:00",
					'clasificacion'=>$Json_Event->clasificacion, //[Dennis 2020-06-11]
					'categoria_capacitacion'=>$Json_Event->categoria_capa,
					'sub_categoria_capacitacion'=>$Json_Event->subCategoria_capa,
					'ramo_capacitacion'=>$Json_Event->ramo_capa
				);

				$CI->calendar_model->update_Cal($data_table);
				$updateEvent = $CI->calendar_model->updateCalendarEvent(array(  //Nuevo
					"id_cal"=> $this->oEventUpdate->getId(),
					"correo" => $this->email,
					"titulo" => $Json_Event->TituloEvento,
					"descripcion" => $Json_Event->Descripcion,
					"fecha_inicio" => $Json_Event->FechaInicio,
					"fecha_final" => $Json_Event->FechaFinal,
					"hora_inicio" => $Json_Event->starttime,
					"hora_final" => $Json_Event->endtime,
					"lugar" => $Json_Event->Lugar,
					"clasificacion" => $Json_Event->clasificacion,
					"sub_categoria_capacitacion" => $Json_Event->subCategoria_capa,
					"ramo_capacitacion" => $Json_Event->ramo_capa,
					"tipo" => 2,
					"liga" => $Json_Event->urlZoom,
					"password" => $Json_Event->pswZoom,
					"idLiga" => $Json_Event->idZoom,
					"enviado" => 0
				));
			}
			
			$allGuest = array_merge($invitadoInterno, $externalAttendees);

			if(!empty($allGuest)){
				$this->manageEventAndGuests($allGuest, $this->oEventUpdate->getId(), $validateData);
			}
			
		}catch(Exception $e){
			echo 'Excepción capturada: ',  $e->getMessage(), "\n";
		}
		
		return json_encode($this->oEventUpdate);	
	}
	//---------------------------------
	function validateUpdateData($array1, $array2){

		$validateBool = array();
		array_push($validateBool, strcmp($array1["titulo"], $array2["titulo"]));
		array_push($validateBool, strcmp($array1["descripcion"], $array2["descripcion"]));
		array_push($validateBool, strcmp($array1["fecha_inicio"], $array2["fecha_inicio"]));
		array_push($validateBool, strcmp($array1["fecha_final"], $array2["fecha_final"]));
		array_push($validateBool, strcmp($array1["hora_inicio"], $array2["hora_inicio"]));
		array_push($validateBool, strcmp($array1["hora_final"], $array2["hora_final"]));
		array_push($validateBool, strcmp($array1["lugar"], $array2["lugar"]));

		if($array2["clasificacion"] == "capacitacion"){
			if(array_key_exists("sub_categoria_capacitacion", $array1) && array_key_exists("ramo_capacitacion", $array1)){

				array_push($validateBool, strcmp($array1["sub_categoria_capacitacion"], $array2["sub_categoria_capacitacion"]));
				array_push($validateBool, strcmp($array1["ramo_capacitacion"], $array2["ramo_capacitacion"]));
			}
		}
		
		array_push($validateBool, strcmp($array1["clasificacion"], $array2["clasificacion"]));
		array_push($validateBool, strcmp($array1["liga"], $array2["liga"]));
		array_push($validateBool, strcmp($array1["password"], $array2["password"]));
		array_push($validateBool, strcmp($array1["idLiga"], $array2["idLiga"]));
		$returnBool = false;

		foreach($validateBool as $d_v){

			if($d_v !== 0){
				$returnBool = true;
			}
		}

		$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($validateBool, TRUE));fclose($fp);
		return $returnBool;
		//if(strcmp($array1["titulo"], $array2["titulo"]) > 0)

	}
	//----------------------------------
	function manageEventAndGuests($contactGuest, $event, $validate){ //Nuevo

		$CI =& get_instance();
		$CI->load->model(array("calendar_model","crmproyecto_model"));

		$event_ = $CI->crmproyecto_model->getConvocatoriaReunionJson($event);
		$allEmailsAvalible = array_map(function($obj){ return  strtolower($obj->correo_lectronico); }, $CI->crmproyecto_model->getEmailNoDeclined($event));
		$allExternalEmails = array_map(function($obj){ return strtolower($obj->correo_externo); }, $CI->crmproyecto_model->getAllEmailConvocatoriaExternos($event));
		$emailMixed = array_merge($allEmailsAvalible, $allExternalEmails);
		$dataNotification = array();
		//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($emailMixed, TRUE));fclose($fp);
		//$asunto="Modificación de Reunion - Capital Seguros y Fianzas";
		$desde="Avisos GAP<avisos@agentecapital.com>";
		$dataNotification["titulo"] = $event_->titulo;
		$dataNotification["fHInicio"] = $event_->fecha_inicio." - ".$event_->hora_inicio." hrs";
		$dataNotification["fHFinal"] = $event_->fecha_final." - ".$event_->hora_final." hrs";
		$dataNotification["clasificacion"] = $event_->clasificacion;
		$dataNotification["capacitacion"] = $event_->sub_categoria_capacitacion;
		$dataNotification["estadoEvento"] = "nuevo"; 
		$dataNotification["evento"] = $event_->id_cal;
		//$dataNotification["subTitulo"] = "Se ha actualizado el evento";

		foreach($contactGuest as $d_g){

			if(!in_array(strtolower($d_g["email"]), $emailMixed)){

					if($d_g["tipo"] == "interno"){

						$iGuest = $this->registroInvitado($d_g["email"], $event);
						$dataNotification["invitado"] = $iGuest;
						$dataNotification["tipo"] = "interno";
					} else{
						$eGuest = $CI->calendar_model->insertaRegistro(array(
							"correo_externo" => $d_g["email"],
							"activo" => 1,
							"id_evento" => $event
						), "catalog_correos_externos", 2);

						$dataNotification["invitado"] = $eGuest;
						$dataNotification["tipo"] = "externo";
					}

					$asunto="Convocatoria de Reunion - Capital Seguros y Fianzas";
					$dataNotification["subTitulo"] = "Usted ha sido convocado a la siguiente reunión";
					$mensaje_ = $CI->load->view("accesoAEvento/vistaCorreo", $dataNotification, true);
					
					$insert = $CI->calendar_model->insertaRegistro(array(
						"from" => $desde,
						"to" => $d_g["email"],
						"subject" => $asunto,
						"message" => $mensaje_,
						"status" => 0,
						"dateCreation" => date("Y-m-d H:i:s"),
						"type" => "new",
					), "calendar_event_notification", 1);
					//$insert = $CI->calendar_model->insertaRegistro(array("desde" => $desde, "para" => $d_g["email"], "asunto" => $asunto, "mensaje" => $mensaje_,"status" => 0, "fechaEnvio" => date("Y-m-d H:i:s"), "identificaModulo" => "Convocatoria de Reunion"), "envio_correos", 1);

			} else{

				if($validate){
					
					$asunto="Modificación de Reunion - Capital Seguros y Fianzas";
					$dataNotification["subTitulo"] = "Se ha actualizado el evento";
					$dataGuest = $CI->calendar_model->getDataGuestByEmail($d_g["email"], "interno", $event_->id_cal);
					
					if(!empty($dataGuest)){
						
						$dataNotification["invitado"] = $dataGuest->id_invitado;
						$dataNotification["tipo"] = "interno";

					} else{

						$dataGuest = $CI->calendar_model->getDataGuestByEmail($d_g["email"], "externo", $event_->id_cal);
						$dataNotification["invitado"] = $dataGuest->idCorreoExt;
						$dataNotification["tipo"] = "externo";
					}
					
					$mensaje_ = $CI->load->view("accesoAEvento/vistaCorreo", $dataNotification, true);
					$insert = $CI->calendar_model->insertaRegistro(array(
						"from" => $desde,
						"to" => $d_g["email"],
						"subject" => $asunto,
						"message" => $mensaje_,
						"status" => 0,
						"dateCreation" => date("Y-m-d H:i:s"),
						"type" => "modify",
					), "calendar_event_notification", 1);
					//$insert = $CI->calendar_model->insertaRegistro(array("desde" => $desde, "para" => $d_g["email"], "asunto" => $asunto, "mensaje" => $mensaje_,"status" => 0, "fechaEnvio" => date("Y-m-d H:i:s"), "identificaModulo" => "Convocatoria de Reunion"), "envio_correos", 1);
				}
			}
		}
	}
	//---------------------------------
	public function listar_evento(){
		
		$datas = array();
		
		try{
			
			
			$optParams = array(
			  //'maxResults' => 10,
			  'maxAttendees' => 5000,
			  'orderBy' => 'startTime',
			  'singleEvents' => TRUE,
			  'timeMin' => date('c'),
			);

			$events = $this->service->events->listEvents($this->calendarId,$optParams);
			// echo '<pre>';
			// print_r($events);
			$CI =& get_instance();
			$CI->load->model("crmproyecto_model");
			$sEmail = $CI->tank_auth->get_usermail();
			$diaryEvents = $CI->crmproyecto_model->get_all_diaries($CI->tank_auth->get_idPersona());
			$datas = array_map(function($data){

				$stringSDate = implode("-", array_reverse(explode("/", $data->fecha), true));
				$sdate = new DateTime($stringSDate, new DateTimeZone("-06:00"));
				$newFormat = array();
				$newFormat["kind"]			= null;
				$newFormat["id"]			= $data->id;
				$newFormat["iCalUID"]		= null;
				$newFormat["title"] 		= $data->asesor_online == 1 ? "Cita desde asesores online" : "Cita desde tarjeta digital";
				$newFormat["description"] 	= $data->detalle;
				$newFormat["location"] 		= null;
				$newFormat["v3Api"]         = true;
				$newFormat["status"]        = "pending";
				$newFormat["hangoutLink"]   = null;
				$newFormat["htmlLink"]    	= null;
				$newFormat["start"]    		= $sdate->setTime(substr($data->hora, 0, -3), 0)->format("Y-m-d\TH:i:sP");
				$newFormat["end"]    		= $sdate->setTime(substr($data->hora, 0, -3), 30)->format("Y-m-d\TH:i:sP");
				$newFormat["attachments"]	= array();
				$newFormat["allDay"]		= false;

				return $newFormat;
			}, $diaryEvents);
			 
			while(true) {
				$cnt = 0;
			  foreach ($events->getItems() as $event) {
				 
				$attach = array();	

				$exist_email = false;

				foreach ($event->attendees as $value) {
					if(strtoupper($value->email) == strtoupper($sEmail))
					{

						$exist_email = true;
						break ;
					}	
				}

				if(!$exist_email)
					continue;
				
				foreach($event->getAttachments() as $atachment){
					
					$file_drive = array(
						"fileId" => $atachment->getfileId(),
						"fileUrl" => $atachment->getfileUrl(),
						"iconLink" => $atachment->geticonLink(),
						"mimeType" => $atachment->getmimeType(),
						"title" => $atachment->gettitle()
					);
					
					array_push($attach, $file_drive);
				}
				
				$data = array();
				
				$data["kind"]			= $event["kind"];
				$data["id"]				= $event->getId();
				$data["iCalUID"]		= $event["iCalUID"];
				$data["title"] 			= $event->getSummary();				
				$data["description"] 	= $event->getDescription();
				$data["location"] 		= $event->getLocation();
				$data["attachments"]    = $attach;
				/*Sacar fechas*/
				$start = $event->getStart();
				$end   = $event->getEnd();
				
				if(isset($start['date'])){
					$data["allDay"] = true;
					$data["start"] 			= $start["date"];
					$data["end"] 			= $end["date"];
					
				}else{
					$data["allDay"] = false;
					$data["start"] 			= str_replace ("Z","",$start["dateTime"]);
					$data["end"] 			= str_replace ("Z","",$end["dateTime"]);
				}
				
				
				$data["status"]         = $event["status"];
				$data["hangoutLink"]    = $event["hangoutLink"];
				$data["htmlLink"]    	= $event->getHtmlLink();
				array_push($datas,$data);
				
				
				
			  }
			  
			  $pageToken = $events->getNextPageToken();
			  
			  if ($pageToken) {
				$optParams = array('pageToken' => $pageToken);
				$events = $this->service->events->listEvents('primary', $optParams);
			  } else {
				break;
			  }
			}
		
			
		}catch(Exception $e){
			
		
		}
		return json_encode($datas);
	}
		/*
	* getCalendarEvent : solicita un evento
	*/
	public function move_event($eventId,$destinationCalendar){
		$result = array();
		
		try{
			
			$result = $this->service->events->move($this->calendarId, $eventId, 'cenis.oy%40gmail.com');	
			
		}catch(Exception $e){
			
		}
		
		return $result;

	}
	
	public function UpdateCalendar(){
		
		$calendar = $this->service->calendars->get('primary');

		$calendar->setSummary('Calendario Primario');
		$calendar->setLocation('Merida');
		$calendar->setTimeZone('America/Mexico_City');

		$updatedCalendar = $service->calendars->update('primary', $calendar);
	}
	
	public function getCalendarEvent($json_event)
	{
		$event_json = array();
		try{			
			
			$Json_Event = $this->json_validate(json_encode($json_event));		
			
			if (strlen($Json_Event->eventId) == 0){
				throw new Exception('El eventId del evento no puede ser null o vacio.');
			}
			
			$optParams = array(
			  'timeZone' => 'America/Mexico_City',
			);
			
			$this->oGetEvent = $this->service->events->get($this->calendarId, $Json_Event->eventId,$optParams);
			
			$idEventoBD=explode("_", $this->oGetEvent->getId());
			$CI =& get_instance();
			$CI->load->model(array("calendar_model", "crmproyecto_model", "capacita_modelo")); //'calendar_model'
			$resultado=$CI->calendar_model->select_event($idEventoBD[0]);


			foreach($resultado as $elemento){
				$event_json["clasificacion"]=$elemento["clasificacion"];
			}
			
			$ICalUID = $this->oGetEvent->getICalUID();
			$Id = $this->oGetEvent->getId();
			$dateStart = $this->oGetEvent->getStart();
			$dateEnd   = $this->oGetEvent->getEnd();
			$description = $this->oGetEvent->getDescription();
			$creator = $this->oGetEvent->getCreator();
			$Organizer = $this->oGetEvent->getOrganizer();
			$GuestsCanInviteOthers = $this->oGetEvent->getGuestsCanInviteOthers();
			$LinkHangout = $this->oGetEvent->getHangoutLink();
			$Location = $this->oGetEvent->getLocation();
			$Recurrence = $this->oGetEvent->getRecurrence();
			$Reminders = $this->oGetEvent->getReminders();
			$Sequence = $this->oGetEvent->getSequence();
			$Source = $this->oGetEvent->getSource();
			$Status = $this->oGetEvent->getStatus();
			$Summary = $this->oGetEvent->getSummary();
			$transparency = $this->oGetEvent->getTransparency();
			$Updated = $this->oGetEvent->getUpdated();
			$Visibility = $this->oGetEvent->getVisibility();
			$HtmlLink = $this->oGetEvent->getHtmlLink();
			$Attendees = $this->oGetEvent->getAttendees();
			$AttendeesOmitted = $this->oGetEvent->getAttendeesOmitted();
			$ColorId = $this->oGetEvent->getColorId();
			$Created = $this->oGetEvent->getCreated();
			$EndTimeUnspecified = $this->oGetEvent->getEndTimeUnspecified();
			$Etag = $this->oGetEvent->getEtag();
			$ExtendedProperties = $this->oGetEvent->getExtendedProperties();
			$Gadget = $this->oGetEvent->getGadget();
			$PrivateCopy = $this->oGetEvent->getPrivateCopy();
			$RecurringEventId = $this->oGetEvent->getRecurringEventId();
			
			
			//var_dump($this->oGetEvent->getAttendees());
			
			$attach = array();	
				
			foreach($this->oGetEvent->getAttachments() as $atachment){
				
				$file_drive = array(
					"fileId" => $atachment->getfileId(),
					"fileUrl" => $atachment->getfileUrl(),
					"iconLink" => $atachment->geticonLink(),
					"mimeType" => $atachment->getmimeType(),
					"title" => $atachment->gettitle()
				);
				
				array_push($attach, $file_drive);
			}
			
			$emails = array();
			$reminderData = array();
			/* Solo emails */
			foreach($Attendees as $att){
				
				$data = array(
								"email" => $att->email,
								"id" => $att->id,
								"responseStatus" => $att->responseStatus,
								"organizer" => $att->organizer
						);
				array_push($emails,$data);
			}
			//---------------------
			$IExternos=$CI->crmproyecto_model->getAllEmailConvocatoriaExternos($this->oGetEvent->getID());
			$IInternos = $CI->crmproyecto_model->getAllEmailConvocatoriaInternos($this->oGetEvent->getID());
			$dataEvent = $CI->crmproyecto_model->getConvocatoriaReunionJson($this->oGetEvent->getID());
			$subCategory = $dataEvent->clasificacion == "capacitacion" ?  $CI->capacita_modelo->getTrainingSubCategoryByName($dataEvent->sub_categoria_capacitacion) : "Ninguno";
        	$category = $dataEvent->clasificacion == "capacitacion" ? $CI->capacita_modelo->getTrainingCategoryById($subCategory->id_capacitacion) : "Ninguno";
        	$ramo = $dataEvent->clasificacion == "capacitacion" ? $CI->capacita_modelo->devuelveRamo(($dataEvent->ramo_capacitacion != "GMM" ? strtolower($dataEvent->ramo_capacitacion) : $dataEvent->ramo_capacitacion)): "Ninguno";
			$EAttendes=array();
			$IAttendes = array();
			//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($dataEvent, TRUE));fclose($fp);

			$totalGuest = array_reduce($IInternos, function($acc, $curr){

				$acc++;
				return $acc;
			}, 0);

			foreach($IInternos as $valor){
				
				$datos=array(
					"email"=>$valor->correo_lectronico,
					"id"=>$valor->id_invitado
				);
				array_push($IAttendes, $datos);
			}

			foreach($IExternos as $valor){
				
				$datos=array(
					"email"=>$valor->correo_externo,
					"id"=>$valor->idCorreoExt
				);
				array_push($EAttendes, $datos);
			}
			//----------------------
			foreach($Reminders as $rem){
				$data = $this->ConvertMinutes($rem);
				array_push($reminderData,$data);
			}	
			
			// var_dump($this->oGetEvent->getEnd()->getDate());
			
			if (($this->oGetEvent->getStart()->getDate())!= NULL) {
				
				$timeStar = $this->oGetEvent->getStart()->getDate();
				$timeEnd = $this->oGetEvent->getEnd()->getDate();
				$_timeStar = "00:00";
				
				$allday = true;
				
				if($timeStar  != $timeEnd){				
					$_timeEnd = "00:00";
					$_date_time = $timeEnd . " " . $_timeEnd;
					
				}else{
					
					 $timeEnd = null;
					 $_timeEnd = null;
					 $_date_time = null;
					 
				}			
				
			}else{
				
				$allday 	= false;
				$__timeStar 	= preg_split('/[T]+/',$dateStart["dateTime"]);
				$timeStar 	= $__timeStar[0];
				$__timeEnd 	= preg_split('/[T]+/',$dateEnd["dateTime"]);
				$timeEnd = $__timeEnd[0];
				$_timeStar 	= str_replace("Z","",$__timeStar[1]);
				$_timeEnd 	= str_replace("Z","",$__timeEnd[1]);
				$_date_time = $dateEnd["dateTime"];
			}
			
			
			$event_json["start_date"] = $timeStar;
			$event_json["start_time"] = $_timeStar;
			$event_json["end_date"] = $timeEnd;
			$event_json["end_time"] = $_timeEnd;
			$event_json["end"] = $_date_time;
			$event_json["allDay"] = $allday;
			$event_json["repeat_type"] = false;
			$event_json["repeat_by"] = "";
			$event_json["repeat_on_sun"] = "";
			$event_json["repeat_on_mon"] = "";
			$event_json["repeat_on_tue"] = "";
			$event_json["repeat_on_wed"] = "";
			$event_json["repeat_on_thu"] = "";
			$event_json["repeat_on_fri"] = "";
			$event_json["repeat_on_sat"] = "";
			$event_json["repeat_start_date"] = "";
			$event_json["repeat_end_on"] = "";
			$event_json["repeat_end_after"] = "";
			$event_json["repeat_never"] = "";
			$event_json["cal_id"] = $Id;
			$event_json["organizer"] = $Organizer["email"];
			$event_json["resource"] = "";
			$event_json["venue"] = "";
			$event_json["description"] = $description;
			$event_json["backgroundColor"] = $ColorId;
			$event_json["reminder_type"] = "";
			$event_json["reminder_time"] = "";
			$event_json["reminder_time_unit"] = "";
			$event_json["free_busy"] = ($transparency == "transparent" ? "free" : "busy");
			$event_json["privacy"] = $Visibility;
			$event_json["location"] = $Location;
			$event_json["url"] = $HtmlLink;
			$event_json["reminderData"] = $reminderData;
			$event_json["reminderGuests"] = $emails;
			$event_json["internalGuest"] = $IAttendes;
			$event_json["externalGuests"]=$EAttendes;
			$event_json["attachments"] = $attach;
			$event_json["urlZoom"] = $dataEvent->liga;
			$event_json["idZoom"] = $dataEvent->idLiga;
			$event_json["pswZoom"] = $dataEvent->password;
			$event_json["totalGuest"] = $totalGuest;

			if($dataEvent->clasificacion == "capacitacion") {
				
				$event_json["training"] = $category->id_capacitacion;
				$event_json["subTraining"] = array("value" => $subCategory->id_certificado, "name" => $subCategory->nombreCertificado);
				$event_json["department"] = !empty($ramo) ? $ramo->idR : "Ninguno"; //$ramo->idR;
			}
			//var_dump($event_json);$data["attachments"]    = $attach;
			
		
		}catch(Exception $e){
			echo 'Excepción capturada: ',  $e->getMessage(), "\n";
		}
		
		return json_encode($event_json);
	}
	
	public function agregar_permiso_calendar()
	{
		
		try{
			
			$rule = new Google_Service_Calendar_AclRule();
			$scope = new Google_Service_Calendar_AclRuleScope();

			$scope->setType("user");
			$scope->setValue($this->email);
			$rule->setScope($scope);
			$rule->setRole("owner");

			$this->oCreateRule = $this->service->acl->insert($this->calendarId, $rule);
			
		}catch(Exception $e){
			echo 'Excepción capturada: ',  $e->getMessage(), "\n";
		}
		
		return $this->oCreateRule;
	}
	
	/*
	* @Metodo : nombre_calendario_primary
	* @Descripcion : Retorna el nombre del calendario primario
	*/
	public function nombre_calendario_primary()
	{		
		try{
			$calendar = $service->calendars->get('primary');
			$this->nombre_calendario = $calendar->getSummary();
			
		}catch(Exception $e ){
			echo 'Excepción capturada: ',  $e->getMessage(), "\n";
		}		
		return $this->nombre_calendario;
	}
	
	public function lista_calendario()
	{
		try{
			$calendar = $service->calendars->get('primary');
			$this->lsNombre_calendario = $calendar->getSummary();
			
		}catch(Exception $e ){
			echo 'Excepción capturada: ',  $e->getMessage(), "\n";
		}		
		return $this->lsNombre_calendario;
	}
	
	public function Id_creator()
	{
		
		try{
			
			$client = new Google_Client();
			
			if (strlen($this->AuthConfigFile) == 0){
				throw new Exception('La ruta del archivo no puede ser null o vacio.');
			}
			$client->setAuthConfigFile($this->AuthConfigFile);
			$client->addScope(Google_Service_Plus::PLUS_LOGIN);
			$client->addScope(Google_Service_Plus::PLUS_ME);
			$client->addScope(Google_Service_Plus::USERINFO_EMAIL);
			$client->addScope(Google_Service_Plus::USERINFO_PROFILE);
			$service = new Google_Service_Plus($client);
			$this->oMe = $service->people->get('me');
			
		}catch(Exception $e){
			echo 'Excepción capturada: ',  $e->getMessage(), "\n";
		}
		
		return $this->oMe;
	}
	
	public function getColorcalendar(){
		try{
			
			$colors = $service->colors->get();
			$this->oGetCalendar = $colors->getCalendar();

		}catch(Exception $e){
			echo 'Excepción capturada: ',  $e->getMessage(), "\n";
		}
		
		return $this->oGetCalendar;
	}
	
	public function getColorCalendarEvent()
	{
		
		try{
			$colors = $service->colors->get();
			$this->ogetcolorsEvent = $colors->getEvent();

		}catch(Exception $e){
			echo 'Excepción capturada: ',  $e->getMessage(), "\n";
		}
		return $this->ogetcolorsEvent;
	}
		
	public function json_validate($string)
	{	
		$result = json_decode($string);
		
		switch (json_last_error()) {
			case JSON_ERROR_NONE:
				$error = ''; 
				break;
			case JSON_ERROR_DEPTH:
				$error = 'The maximum stack depth has been exceeded.';
				break;
			case JSON_ERROR_STATE_MISMATCH:
				$error = 'Invalid or malformed JSON.';
				break;
			case JSON_ERROR_CTRL_CHAR:
				$error = 'Control character error, possibly incorrectly encoded.';
				break;
			case JSON_ERROR_SYNTAX:
				$error = 'Syntax error, malformed JSON.';
				break;
			// PHP >= 5.3.3
			case JSON_ERROR_UTF8:
				$error = 'Malformed UTF-8 characters, possibly incorrectly encoded.';
				break;
			// PHP >= 5.5.0
			case JSON_ERROR_RECURSION:
				$error = 'One or more recursive references in the value to be encoded.';
				break;
			// PHP >= 5.5.0
			case JSON_ERROR_INF_OR_NAN:
				$error = 'One or more NAN or INF values in the value to be encoded.';
				break;
			case JSON_ERROR_UNSUPPORTED_TYPE:
				$error = 'A value of a type that cannot be encoded was given.';
				break;
			default:
				$error = 'Unknown JSON error occured.';
				break;
		}

		if ($error !== '') {
			throw new Exception('El objeto recibido en el m&eacute;todo no esta en formato JSON');				
		}

		// everything is OK
		return $result;
	}
	
	function validateDate($date, $format = 'Y-m-d H:i:s')
	{
		$d = DateTime::createFromFormat($format, $date);
		return $d && $d->format($format) == $date;
	}
	
	function ConvertDateRFC3339($date){
		
		try{			
			//$myDateTime = DateTime::createFromFormat('Y-m-d\TH:i:sP', $date);
			$date = DateTime::createFromFormat('Y-m-d\TH:i:s.uP', $date);
			//$formattedweddingdate = $myDateTime->format(DateTime::RFC3339);
			
		}catch(Execption $e){
			echo 'Excepción capturada: ',  $e->getMessage(), "\n";
		}
		
		return $date;
	}
	private function ConvertMinutes($rem){
		
		
		$time = "";
		$time_init =  "";
				
		try{
			
			$minute = $rem["minutes"];
			
			if($minute <= 60){
				$time = $minute;
				$time_init = "minute";
				
				$data = array(
								"type" => $rem["method"],
								"time" => $time,
								"time_unit" => $time_init
				);
				
			}else if($minute < 1440){
				
				$time = ($minute / 60);
				$time_init = "hour";
				
				$data = array(
								"type" => $rem["method"],
								"time" => $time,
								"time_unit" => $time_init
				);
				
			}else if($minute < 10080){			
				$time = (($minute / 60) / 24);
				$time_init = "day";
				
				$data = array(
								"type" => $rem["method"],
								"time" => $time,
								"time_unit" => $time_init
				);
				
			}else if($minute <= 40320 ){
				
				$time = ((($minute / 60) / 24) / 7);
				$time_init = "week";
				
				$data = array(
								"type" => $rem["method"],
								"time" => $time,
								"time_unit" => $time_init
				);
				
			}
		}catch(Exception $e){
			
		}
		
		return $data;
	}
	//--------------------------------------------
	function guestManage($invitado, $evento){ //Nuevo
		
		//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($invitado, TRUE));fclose($fp);
		if(!empty($invitado)){
			foreach($invitado as $email){

				if(filter_var($email["email"], FILTER_VALIDATE_EMAIL)){
					$invitado_ = $this->registroInvitado($email["email"], $evento);
				} 
				
			}
		}
	}
	//--------------------------------------------
	function registroInvitado($correo, $evento){ //Nuevo

		$datosInvitado = array();
		$CI =& get_instance();
		$CI->load->model("calendar_model");
		$consulta = $CI->calendar_model->obtener_invitado_interno($correo);
		//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($evento, TRUE));fclose($fp);
		if(!empty($consulta)){
			foreach($consulta as $datos){
				$datosInvitado["nombres"] = strtolower($datos->nombres);
				$datosInvitado["apellido_paterno"] = strtolower($datos->apellidoPaterno);
				$datosInvitado["apellido_materno"] = strtolower($datos->apellidoMaterno);
				$datosInvitado["correo_lectronico"] = $datos->email;
				$datosInvitado["telefono"] = $datos->celPersonal;
				$datosInvitado["ciudad"] = strtolower($datos->municipioDomicilio);
				$datosInvitado["organizacion"] = "Agente Capital";
				$datosInvitado["puesto"] = strtolower($datos->nombre);
				$datosInvitado["tipo_invitado"] = "interno";
				$datosInvitado["id_evento"] = $evento;
				$datosInvitado["estado"] = "pendiente";
			}

			$lastId = $CI->calendar_model->inserta_invitados($datosInvitado);
			return $lastId;
		}
		//die;
	}
	//-----------------------------------------------------------------------------------------------------------------
	//funcion que evita inserccion de registros duplicados y anexa los que son nuevos.
	function actualizacion_invitado($correos, $externos, $evento,$datosCorreo){

		//validar si los correos estan en lista
		$CI=& get_instance();
		$CI->load->model(array("calendar_model","emailmasivo_model"));

		$updateAttendes=array();
		$inserta=array();

		$tmpinvitados=array();

		foreach($correos as $valor){
			//En cada iteración valida si el correo esta dado de alta en el evento.
			//TRUE omite, FALSE inserta a la tabla.
			//Proceso interno.
			$consulta=$CI->calendar_model->consultaInvitados($valor["email"],$evento);

			if($consulta!=true){
				
				$datosAgente=$CI->calendar_model->obtener_invitado_interno($valor["email"]);
					//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($consulta, TRUE));fclose($fp);
	
				if(isset($datosAgente)){
					foreach($datosAgente as $datos){
						$updateAttendes["nombres"]=strtolower($datos->nombres);
						$updateAttendes["apellido_paterno"]=strtolower($datos->apellidoPaterno);
						$updateAttendes["apellido_materno"]=strtolower($datos->apellidoMaterno);
						$updateAttendes["correo_lectronico"]=$datos->email;
						$updateAttendes["telefono"]=$datos->celPersonal;
						$updateAttendes["ciudad"]=strtolower($datos->municipioDomicilio);
						$updateAttendes["organizacion"]="Agentes Capital";
						$updateAttendes["puesto"]=strtolower($datos->nombre);
						$updateAttendes["tipo_invitado"]="interno";
						$updateAttendes["id_evento"]=$evento;
						$updateAttendes["estado"]="pendiente";
						
						$lastId=$CI->calendar_model->inserta_invitados($updateAttendes);

						/*array_push($tmpinvitados, array(
							$lastId=>$datos->idPersona
						)); */

						array_push($tmpinvitados, $lastId);

						if($datosCorreo["clasificacion"]=="capacitacion"){
							$this->eventoCapaTmp($lastId, $datosCorreo, $datos->idPersona);
						}
					}
				} 
			}
		} // fin del proceso interno.

		$this->actualizaCapaTmp($tmpinvitados,$datosCorreo);


		foreach($externos as $emails){
			$consulta=$CI->calendar_model->consultaInvitados($emails["external_email"],$evento);

			if($consulta!=true){
					$_checkExt=$CI->emailmasivo_model->devuelve_correoExt_unitario($emails["external_email"],$evento);

				if($_checkExt!=true){
					$email=$emails["external_email"];

					array_push($inserta,array(
						"correo_externo"=>$email,
						"activo"=>1,
						"id_evento"=>$evento
					));

					$CI->emailmasivo_model->inserta_correos_externos($inserta);

				}
			}
		}
	}
	//--------------------------------
	function actualizacionInvitado($interalGuest, $externalGuest, $event){

		if(!empty($interalGuest)){
			foreach($interalGuest as $email){

			}
		}
	}
	//--------------------------------
	function notificacion_de_actualizacion($datosCorreo, $title){
		
		$CI=& get_instance();

		//Cargamos el modelo.
		$CI->load->model("calendar_model");

		$data=array();
		$UFaltantes=array();
		$noRegistrados=array();
		$subject="";

		$rutaTemporal="files/";
		$rutaNueva=FCPATH."assets";
		$rutanueva_definitivo=$rutaNueva."/documentos/adjuntos_calendario/".$datosCorreo["idEvento"];

		//Comparar titulos del evento.
		if(strcmp($title["titulo_anterior"],$title["titulo_actual"])!=0){

			$subject="Actualización del evento ".$title["titulo_anterior"]." a ".$title["titulo_actual"];
			$datosCorreo["titulo"]=$title["titulo_actual"];
			$datosCorreo["subject"]="Actualización del evento ".$title["titulo_anterior"]." a ".$title["titulo_actual"];

		} else{
			$subject="Actualización del evento ".$title["titulo_anterior"];
			$datosCorreo["titulo"]=$title["titulo_actual"];
			$datosCorreo["subject"]="Actualización del evento ".$title["titulo_actual"];			
		}

		$archivos_adjuntos=array();
		
		//--------------------------------------------------------------------
		//Agregar a la pila las rutas de los archivos adjuntos.
		foreach($datosCorreo["adjuntos"] as $infoFile){
			//Proceso de copiado.
			$copiar=copy($rutaTemporal."/".$infoFile["title"], $rutanueva_definitivo."/".$infoFile["title"]);

			array_push($archivos_adjuntos, array(
				"a_add"=>$rutaTemporal."/".$infoFile["title"]//$rutanueva_definitivo."/".$infoFile["title"],
				//"a_del"=>$rutaTemporal."/".$infoFile["title"]
			));
		}
		//--------------------------------------------------------------------
		//Proceso de envio de actualización de manera interna.
		if(isset($datosCorreo["destinatarios"])){
			foreach($datosCorreo["destinatarios"] as $valor){
				if(isset($valor["email"])){

					$consulta=$CI->calendar_model->devuelve_invitado_unitario($valor["email"],$datosCorreo["idEvento"]);

					if(isset($consulta)){
						foreach($consulta as $datos){

							$cuerpo_correo=array();

							$data["datos"]=$datosCorreo;
							$data["datos"]["TInvitado"]=$datos->tipo_invitado;
							$data["datos"]["invitado"]=$datos->id_invitado;
							$data["datos"]["estado"]=$datos->estado;

							//$icsfile=$this->creaIcsFile($datosCorreo,$datos->id_invitado,"interno",$datos->estado);

							$mensaje=$CI->load->view("accesoAEvento/vistaCorreo",$data ,true);

							$cuerpo_correo["subject"]=$subject;
							$cuerpo_correo["mensaje"]=$mensaje;
							//$cuerpo_correo["ics"]=$icsfile;
							$cuerpo_correo["para"]=$datos->correo_lectronico; //"auxiliardesarrollo@agentecapital.com";
							$cuerpo_correo["archivos_adjuntos"]=$archivos_adjuntos;

							$this->ejecutar_envio_masivo($cuerpo_correo);
						}
					}
				}
			}
		}
		if(isset($datosCorreo["destinatario_externo"])){
			foreach($datosCorreo["destinatario_externo"] as $valor){
				
				$consulta=$CI->calendar_model->devuelve_invitado_unitario($valor["external_email"],$datosCorreo["idEvento"]);

				if(isset($consulta)){

					foreach($consulta as $datos){

						$data["datos"]=$datosCorreo;
						$data["datos"]["invitado"]=$datos->id_invitado;
						$data["datos"]["estado"]=$datos->estado;
						$data["datos"]["TInvitado"]="externo";

						//$icsfile=$this->creaIcsFile($datosCorreo,$datos->id_invitado,"externo",$datos->estado);

						//Anexamos el array con id_invitado y estado para validación en vista.
						$mensaje=$CI->load->view("accesoAEvento/vistaCorreo", $data, true);

						$cuerpo_correo["subject"]=$subject;
						$cuerpo_correo["mensaje"]=$mensaje;
						//$cuerpo_correo["ics"]=$icsfile;
						$cuerpo_correo["para"]=$datos->correo_lectronico;
						$cuerpo_correo["archivos_adjuntos"]=$archivos_adjuntos;

						$this->ejecutar_envio_masivo($cuerpo_correo);
					}
				}

				if(empty($consulta)){

					//eliminamos el array que viene con todos los correos externos.
					unset($datosCorreo["destinatario_externo"]);

					//eliminamos los correos internos ya que importan los externos.
					unset($datosCorreo["destinatarios"]);

					//anexamos en el array el correo de la interación que no esta en registro.
					array_push($UFaltantes, array("external_email"=> $valor["external_email"]));

					//Insertar en el array el array anterior dejando la estructura de correos externos anterior.
					$datosCorreo["destinatario_externo"]=$UFaltantes;
					$datosCorreo["tipo"]=1;

					//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($datosCorreo, TRUE));fclose($fp);
					//Reenvio de correo a invitados que aun no han llenado el formulario.
					$this->notificacion_del_evento($datosCorreo);
				}
			}
		} // fin de proceso externo
	} //fin del metodo
	//-----------------------------------------------------------------------------------------------------------------
	function notificacion_cancelacion($evento){

		$CI=& get_instance();
		$CI->load->model(array("calendar_model","crmproyecto_model"));
		$evento_ =  $CI->crmproyecto_model->getConvocatoriaReunionJson($evento);
		$externosPendientes =  array_map(function($ob){ return $ob->correo_externo; }, $CI->crmproyecto_model->getAllEmailConvocatoriaExternos($evento));
		$internosPendientes = array_map(function($obj){ return $obj->correo_lectronico; }, $CI->crmproyecto_model->getEmailNoDeclined($evento));
		$todosMails = array_merge($externosPendientes, $internosPendientes);
		$valida = array();
		$infoEvent_ = array();
		//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($todosMails, TRUE));fclose($fp);
			
		$infoEvent = array();
		$infoEvent["titulo"] = $evento_->titulo;
		$infoEvent["fHInicio"] = $evento_->fecha_inicio." - ".$evento_->hora_inicio." hrs";
		$infoEvent["fHFinal"] = $evento_->fecha_final." - ".$evento_->hora_final." hrs";
		$infoEvent["clasificacion"] = $evento_->clasificacion;
		$infoEvent["capacitacion"] = $evento_->sub_categoria_capacitacion;
		$infoEvent["estadoEvento"] = "cancelado"; 
		$infoEvent["subTitulo"] = "Ha ocurrido un cambio de planes..."; //Usted ha convocado la siguiente Reunion
		$infoEvent["evento"] = $evento_->id_cal;
		$asunto="Cancelación de Reunión - Capital Seguros y Fianzas";
		$desde="Avisos GAP<avisos@agentecapital.com>";
		$mensaje_ = $CI->load->view("accesoAEvento/vistaCorreo", $infoEvent, true);

		foreach($todosMails as $email){

			$insert = $CI->calendar_model->insertaRegistro(array(
				"from" => $desde,
				"to" => $email,
				"subject" => $asunto,
				"message" => $mensaje_,
				"status" => 0,
				"dateCreation" => date("Y-m-d H:i:s"),
				"type" => "cancelled",
			), "calendar_event_notification", 1);

			/*$insert = $CI->calendar_model->insertaRegistro(array(
				"desde" => $desde,
				"para" => $email,
				"asunto" => $asunto,
				"mensaje" => $mensaje_,
				"status" => 0,
				"fechaEnvio" => date("Y-m-d H:i:s"),
				"identificaModulo" => "Convocatoria de Reunion"
			), "envio_correos", 1);*/
			array_push($valida, $insert);
		}

		return in_array(false, $valida) ? false : true;
	}
	//-----------------------------------------------------------------------------------------------------------------
	function creaIcsFile($datosCorreo,$id_invitado,$tipoEmail,$estado){

		$CI=&get_instance();
		$CI->load->model("manejodocumento_modelo");

		date_default_timezone_set("America/Merida"); 

		$direccion=$CI->manejodocumento_modelo->obtenerDirectorio("U");
		$direccion=$direccion."assets/documentos/adjuntos_calendario";
		$DTSTART=$datosCorreo["fecha_inicio"]." ".$datosCorreo["hora_inicio"];
		$DTSEND=$datosCorreo["fecha_final"]." ".$datosCorreo["hora_final"];

		$_incal_content="BEGIN:VCALENDAR
		VERSION:2.0
		CALSCALE:GREGORIAN
		METHOD:REQUEST
		BEGIN:VEVENT
		ORGANIZER;CN=".$this->email.":mailto:".$this->email."
		UID:".$datosCorreo["iCal"]."
		CLASS:PUBLIC
		DTSTART:".str_replace("-","",str_replace(":","",date("c", strtotime($DTSTART))))."Z
		DTEND:".str_replace("-","",str_replace(":","",date("c", strtotime($DTSEND))))."Z
		LOCATION:".$datosCorreo["lugar"]."
		STATUS:CONFIRMED
		SUMMARY:".$datosCorreo["titulo"]."
		ACTION:EMAIL \n";

		if($tipoEmail=="interno"){
			$_incal_content.="DESCRIPTION:".$datosCorreo["descripcion"]."  ->  Acceso al evento: ".base_url()."accesoAEvento/habilitaEvento?q=".$datosCorreo["idEvento"]."&r=".$id_invitado."&p=interno \n";	

		} elseif($tipoEmail=="externo"){

			if($estado=="aceptado"){
				$_incal_content.="DESCRIPTION:".$datosCorreo["descripcion"]."  ->  Acceso al evento: ".base_url()."accesoAEvento/habilitaEvento?q=".$datosCorreo["idEvento"]."&r=".$id_invitado." \n";
			} else{
				$_incal_content.="DESCRIPTION:".$datosCorreo["descripcion"]."  ->  Acceso al evento: ".base_url()."accesoAEvento/datosDelEvento?q=".$datosCorreo["idEvento"]."&r=".$estado." \n";
			}
		}

		$_incal_content.="END:VEVENT
		END:VCALENDAR";

		//-----------------------------------------------------------
		//Crear directorio contenedor de adjuntos por evento.
		$ruta_absoluta=$direccion."/".$datosCorreo["idEvento"]."/";
		$subruta_absoluta=$ruta_absoluta."icalendar_files";
		$CI->manejodocumento_modelo->gestiona_directorio_para_adjuntos_de_eventos($ruta_absoluta,"crear");
		$CI->manejodocumento_modelo->gestiona_directorio_para_adjuntos_de_eventos($subruta_absoluta,"crear");
		//-----------------------------------------------------------
		//Crear archivo ICS en la ruta creada del evento.
		if(!file_exists($subruta_absoluta."/".$datosCorreo["idEvento"]."_".$id_invitado.".ics")){

			//$ical=fopen($subruta_absoluta."/".$datosCorreo["idEvento"]."_".$id_invitado.".ics", "w");
			file_put_contents($subruta_absoluta."/".$datosCorreo["idEvento"]."_".$id_invitado.".ics", str_replace("\t","",$_incal_content));
			fclose($ical);
		} else{
			file_put_contents($subruta_absoluta."/".$datosCorreo["idEvento"]."_".$id_invitado.".ics", str_replace("\t","",$_incal_content));
		}
		//---------------------------------------------------------

		return $subruta_absoluta."/".$datosCorreo["idEvento"]."_".$id_invitado.".ics";
	}
	//-----------------------------------------------------------------------------------------------------------------
	function eventoCapaTmp($idI, $datosCorreo, $idPersona){

		$invitadoTemporal=array();
		$CI=& get_instance();
		$CI->load->model(array("personamodelo", "calendar_model"));

		$existenciaInvitadoTmp=$CI->calendar_model->devuelveInfoTmp($idI);

		//Conversión de cadena de tiempo a DateTime.
		$strTimeStart_to_dateHour=new DateTime($datosCorreo["fecha_inicio"]." ".$datosCorreo["hora_inicio"].":00");
		$strTimeEnd_to_dateHour=new DateTime($datosCorreo["fecha_final"]." ".$datosCorreo["hora_final"].":00");

		$diff=$strTimeEnd_to_dateHour->diff($strTimeStart_to_dateHour);

		$hrStart=$diff->format("%h");
		$mintart=$diff->format("%i");

		$mediaHora=0.0;
		$hrsFloat=0.0;
		$columnInsert="";

		if($mintart>0){
			$mediaHora=0.5;
			$hrsFloat=$hrStart+$mediaHora;
		} else{
			$hrsFloat=$hrStart;
		}

		//Identificar columna para insercción en base de datos.
		switch($datosCorreo["ramo_capacitacion"]){
			case "PROFESIONAL": $columnInsert="certificacion";
			break;
			case "DAÑOS": $columnInsert="certificacionDano";
			break;
			case "VIDA": $columnInsert="certificacionVida";
			break;
			case "AUTOS": $columnInsert="certificacionAutos";
			break;
			case "GMM": $columnInsert="certificacionGmm";
			break;
			case "FIANZAS": $columnInsert="certificacionFianzas";
			break;
		}

		$subCat=$CI->personamodelo->devuelveDatosSubCategoria($datosCorreo["sub_categoria_capacitacion"]);

		$invitadoTemporal= array(
			"idCertificado"=>$subCat->id_certificado,
			"id_invitado"=>$idI,
			"id_persona"=>$idPersona,
			"id_evento"=>$datosCorreo["idEvento"],
			"columnaRamo"=>$columnInsert,
			"horaRamo"=>$hrsFloat,
			"fechaAsignada"=>$datosCorreo["fecha_inicio"],
			"organizador"=>$datosCorreo["correo"],
			"descripcion"=>$datosCorreo["descripcion"],
			"estado"=>"pendiente"
		);

		$CI->calendar_model->insertaEnTemporal($invitadoTemporal);
	}
	//-----------------------------------------------------------------------------------------------------------------
	function actualizaCapaTmp($arrayI,$arrayDatos){

		$CI=& get_instance();
		$CI->load->model(array("calendar_model","personamodelo"));

		$fechaSeg=explode("-",$arrayDatos["fecha_inicio"]);

		$strTimeStart_to_dateHour=new DateTime($arrayDatos["fecha_inicio"]." ".$arrayDatos["hora_inicio"].":00");
		$strTimeEnd_to_dateHour=new DateTime($arrayDatos["fecha_final"]." ".$arrayDatos["hora_final"].":00");

		$diff=$strTimeEnd_to_dateHour->diff($strTimeStart_to_dateHour);

		$hrStart=$diff->format("%h");
		$mintart=$diff->format("%i");

		$mediaHora=0.0;
		$hrsFloat=0.0;
		$columnInsert="";

		if($mintart>0){
			$mediaHora=0.5;
			$hrsFloat=$hrStart+$mediaHora;
		} else{
			$hrsFloat=$hrStart;
		}

		//Identificar columna para insercción en base de datos.
		switch($arrayDatos["ramo_capacitacion"]){
			case "PROFESIONAL": $columnInsert="certificacion";
			break;
			case "DAÑOS": $columnInsert="certificacionDano";
			break;
			case "VIDA": $columnInsert="certificacionVida";
			break;
			case "AUTOS": $columnInsert="certificacionAutos";
			break;
			case "GMM": $columnInsert="certificacionGmm";
			break;
			case "FIANZAS": $columnInsert="certificacionFianzas";
			break;
		}

		$subCat=$CI->personamodelo->devuelveDatosSubCategoria($arrayDatos["sub_categoria_capacitacion"]);

		//Devolver los registros de los agentes.
		$agentes=$CI->calendar_model->devuelveInvitadosTmp($arrayDatos["idEvento"]);
		//$agentesRep=$CI->personamodelo->devuelveInvitadoRep($arrayDatos["idEvento"]);

		if(isset($agentes)){
			foreach($agentes as $datos){
				if(!in_array($datos->id_invitado,$arrayI)){

					$invitadoTemporal= array(
						"idCertificado"=>$subCat->id_certificado,
						"columnaRamo"=>$columnInsert,
						"horaRamo"=>$hrsFloat,
						"fechaAsignada"=>$arrayDatos["fecha_inicio"],
						"organizador"=>$arrayDatos["correo"],
						"descripcion"=>$arrayDatos["descripcion"]
					);

					$CI->calendar_model->actualizaEnTemporal($invitadoTemporal,$datos->id_invitado);

					$CI->personamodelo->actualizaEnReporte($arrayDatos["idEvento"],$datos->id_persona);
					
				}
			}
		}

	}
	//-----------------------------------------------------------------------------------------------------------------
	function eliminaInfo($evento){

		$CI=& get_instance();
		$CI->load->model("calendar_model");
		$resultado = array();

		$delete1 = $CI->calendar_model->eliminaInfoCapacitacion("id_cal", $evento, "cal_events_json");
		$delete2 = $CI->calendar_model->eliminaInfoCapacitacion("id_evento", $evento, "invitados_eventos");

		array_push($resultado, $delete1, $delete2);
		//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($resultado, TRUE));fclose($fp);

		return in_array(0, $resultado) ? false : true;
	}

	//------------------------------------------------------------------------------------------------------------------
	function ejecutar_envio_masivo($correo){

		$mensaje=$correo["mensaje"];
		$email=$correo["para"];
		$asunto='CAPITAL SEGUROS Y FIANZAS';
		$headers= 'Content-type: text/html; charset=iso-utf-8' . "\r\n";
		$headers .= 'From: Convocatoria a Reunion <avisos@agentecapital.com>' . "\r\n";
		mail($email, $asunto, $mensaje, $headers);

	}
	//------------------------------------------------------------------------------------------------------------------

	function mover_archivos_precargados(){ //$adjuntos, $id_evento
 
		$ruta_nueva="assets/";
		$ruta_anterior="files/";
		$rspuesta="";

		if(file_exists(FCPATH.$ruta_anterior."Captura.PNG")){
			$respuesta="El archivo exitee";
			//if(!file_exists(FCPATH.$ruta_nueva."0519PM"."Captura.PNG")){
				//mkdir(FCPATH.$ruta_nueva."0519PM", 0777, true);
				//$resultado=move_uploaded_file(FCPATH.$ruta_anterior."Captura.PNG",FCPATH.$ruta_nueva."0519PM");
				$resultado=copy(FCPATH.$ruta_anterior."Captura.PNG",FCPATH.$ruta_nueva."0519PM/Captura.PNG");
			//} else{
				//$resultado=move_uploaded_file(FCPATH.$ruta_anterior."Captura.PNG",FCPATH.$ruta_nueva."0519PM");
				//$resultado=copy(FCPATH.$ruta_anterior."Captura.PNG",FCPATH.$ruta_nueva."0519PM/Captura.PNG");
			//}
			/*if(!$resultado){
				$respuesta="No se realizó el cambio";
			} else{
				$respuesta="Si se realizó el cambio";
			}*/

		} else{
			$respuesta="No existe el archivo";
		}

		echo $respuesta;

	}

	//-----------------------------------------------------------------------------------------------------------------
}
