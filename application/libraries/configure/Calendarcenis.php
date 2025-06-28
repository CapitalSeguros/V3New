<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
* plugin calendar de google
* Desarrollador: Henry oy
* Correo: henry.oy@ticc.com.mx
* version: 1.0.0
* Fecha: 20/01/2016 
*/

include( __DIR__  . '/google/autoload.php');
include( __DIR__  . '/class/autoload.cenis.php');
define('CREDENTIALS_PATH', __DIR__ . '/configure/credentials/calendar-php.json');
//define("PATH_CONFIGURE" , __DIR__  . "/configure/client_secret_341662279938-2r7nb3v39sv4boa3daf5ifa8jvohtgo9.apps.googleusercontent.com.json");
//define("PATH_CONFIGURE" , __DIR__  . "/configure/client_secret_179521245354-jgqo8b01quoi4ledccqak6lajstnt024.apps.googleusercontent.com.json");
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

		$this->client->addScope(Google_Service_Drive::DRIVE);
		$this->client->addScope(Google_Service_Drive::DRIVE_FILE);
		$this->client->addScope(Google_Service_Drive::DRIVE_APPDATA);
		$this->client->addScope(Google_Service_Drive::DRIVE_APPS_READONLY);
		
		$this->client->addScope(Google_Service_Drive::DRIVE_METADATA);
		$this->client->addScope(Google_Service_Drive::DRIVE_METADATA_READONLY);
		$this->client->addScope(Google_Service_Drive::DRIVE_PHOTOS_READONLY);
		$this->client->addScope(Google_Service_Drive::DRIVE_READONLY);
		$this->client->addScope(Google_Service_Drive::DRIVE_SCRIPTS);

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
			//$authCode="4/2QGxwPdycU7rcTgRT7hUTR7iQk3A2YLN2Lx7D7Sr8xEnbR0dmIO5bUE";

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
		// $this->calendarId = "cenis.oy%40gmail.com";	
		$this->calendarId = "primary";	
		
		// $this->CI =& get_instance();
		
		// if ($CI->input->get('logout') != null) { // logout: destroy token
			// unset($CI->session->token);
			// die('Logged out.');
		// }
		
		// if ($CI->input->get('code') != null ) { // we received the positive auth callback, get the token and store it in session
			// $this->client->authenticate();
			// $CI->session->token = $this->client->getAccessToken();
		// }
		
		// if ($CI->session->token != null ) { // extract token from session and configure client
			// $token = $CI->session->token;
			// $this->client->setAccessToken($token);
		// }

		// if (!$this->client->getAccessToken()) { // auth call to google
			// $authUrl = $this->client->createAuthUrl();
			// header("Location: ".$authUrl);
			// die;
		// }
		
		
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
				$start =  array(
						'dateTime' => $Json_Event->FechaInicio . "T" . $Json_Event->starttime .":00-05:00",						
						'timeZone' => 'America/Mexico_City'
						
					 );
				$end = array(
							'dateTime' => $Json_Event->FechaFinal . "T" .  $Json_Event->endtime .":00-05:00",
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
					/*array_push($externalEmailDB,array(
						"correo_externo"=>$valor,
						"activo"=>1
					)); */
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
				//array_push($attendees,array('email' => $this->email,'organizer'=> true ));
				$status_organizer = "activo";
				array_push($attendees,array('email' =>  $this->email,'organizer'=> true,'responseStatus' => 'accepted' ));
				// array_push($attendees,array('email' =>  'jimmy.ramirez@ticc.com.mx','organizer'=> true,'responseStatus' => 'accepted' ));
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
					
			// var_dump($event->ReturnArray());

			// return false;
			
			$event_calendar = new Google_Service_Calendar_Event($event->ReturnArray());			
			
			//$event_optional = array("sendNotifications" => true , "supportsAttachments" => $supportAttach);
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
			//[Dennis 2020-07-27]
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
				'sub_categoria_capacitacion'=>$Json_Event->subCategoria_capa,
				'ramo_capacitacion'=>$Json_Event->ramo_capa,
				"tipo"=>1
				//"caso"=>1
			);
			//---------------------------------------------------------------------------------------------------
			
		//	$fp = fopen('C:\wamp\www\Capsys\www\V3\application\resultadoJason.txt', 'w');
		//	 fwrite($fp, print_r($event, TRUE));
			
          //         fwrite($fp, print_r($data_table, TRUE));
            //       fclose($fp); 
			
			
			$CI->load->model(array('calendar_model','emailmasivo_model'));
			$CI->calendar_model->Insert_Cal($data_table);

			//------------------------------------------------------------------------------------------------------------
			//inserccion de los correos a  la db
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

			$CI->emailmasivo_model->inserta_correos_externos($externalEmailDB);

			//--------------------------------------------------------------------------------------------------------------
			//[Dennis 2020-07-20]:metodo que permite crear un archivo ICS.
			$datosCorreo["ics"]=$this->creaIcsFile($datosCorreo);
			//--------------------------------------------------------------------------------------------------------------
			//[Dennis 2020-07-02]: inserccion de agentes internos al db.
			if(isset($invitadoInterno)){
				
				$this->registro_invitado($invitadoInterno, $this->oEventCreate->getId(),$datosCorreo);
			}
			//---------------------------------------------------------------------------------------------------------------
			//[Dennis 2020-06-17]
			$this->notificacion_del_evento($datosCorreo);

			//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($datosCorreo, TRUE));fclose($fp);
			//---------------------------------------------------------------------------------------------------------------
			/*if($Json_Event->clasificacion=="capacitacion"){
				foreach($attendees as $correos){
					if(isset($correos["email"])){
						$this->inserta_en_capa($datosCorreo);
					}
				}
			} */
			//---------------------------------------------------------------------------------------------------------------
			//$CI->DriveCenis->insertPermission($this->oEventCreate->getId(),)
			//move in calendario organizer 
			//$result_ = $this->service->events->move($this->calendarId, $this->oEventCreate["id"], 'cenis.oy%40gmail.com');
						
			//var_dump($result_);
			//var_dump($this->oEventCreate["id"]);
			
		}catch(Exception $e ){
			echo 'Excepci&oacute;n capturada: ',  $e->getMessage(), "\n";
		}
		
		//return json_encode($result_);		
		return json_encode($this->oEventCreate);		
	}
	/*
	* @method -> eliminar_evento
	* @param  -> object type json
	* @struct -> example : {
	*							"eventId": "vckgbt5uh8l54gkehp6s15oli8",
	*							"enviarNotificacion": true
	*						}
	* @return object 
	*/
	public function eliminar_evento($json_event){
		
		try{	
			
			$Json_Event = $this->json_validate(json_encode($json_event));
			
			
			if (strlen($Json_Event->eventId) == 0){
				throw new Exception('El eventId del evento no puede ser null o vacio.');
			}
			if($Json_Event->enviarNotificacion){
				$event_optional = array("sendNotifications" => true );
			}else{
				$event_optional = array();
			}
			
			if($Json_Event->eliminarInstancias){
				$this->oEventDelete = $this->service->events->delete($this->calendarId, $Json_Event->eventId, $event_optional);
			}else{
				
				$this->oEventDelete = $this->service->events->instances($this->calendarId, $Json_Event->eventId);

				while(true) {
				  // foreach ($events_instance->getItems() as $event) {
					// echo $event->getSummary();
				  // }
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
			
			//--------------------------------------------------------------------------------------------------------------
			//notificación de eliminación de evento.
			//[Dennis 2020-07-15]
			$envio=$this->notificacion_cancelacion($Json_Event->eventId);

			//---------------------------------------------------------------------------------------------------------------
			//$this->eliminaInfo($Json_Event->eventId);

			//---------------------------------------------------------------------------------------------------------------
			
		}catch(Exception $e ){
			
			echo 'Excepci&oacute;n capturada: ',  $e->getMessage(), "\n";
			
		}
		
		return json_encode($this->oEventDelete);
	}
	
	public function actualizar_evento($json_event)
	{		
		try{
						
			/*
			* @Id del creador del evento, este seria la pagina de Capsy
			*/
			$Json_Event = $this->json_validate(json_encode($json_event));
			
			$status_organizer = false;
			$supportAttach = false;
			$CI =& get_instance();
			$CI->load->library('DriveCenis');
			// var_dump($Json_Event);
					
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
						
			/*
			* @Id del creador del evento, este seria la pagina de Capsy
			*/
	
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
					  
			// $datetime_ini = $this->ConvertDateRFC3339($Json_Event->FechaInicio . " " . $Json_Event->starttime);
			
			// var_dump($datetime_ini);
			
			// $datetime_fin = $this->ConvertDateRFC3339($Json_Event->FechaFinal . " " . $Json_Event->endtime);
			
			// var_dump($datetime_fin);

			
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
				
				$start =  array(
						//'dateTime' => $Json_Event->FechaInicio . "T" . $Json_Event->starttime .":00Z",						
						'dateTime' => $Json_Event->FechaInicio . "T" . $Json_Event->starttime .":00-05:00",						
						//'dateTime' => $datetime_ini,						
						'timeZone' => 'America/Mexico_City'
						//'timeZone' => date_default_timezone_get()
					 );
						
				$end = array(
							'dateTime' => $Json_Event->FechaFinal . "T" .  $Json_Event->endtime .":00-05:00",
							'timeZone' => 'America/Mexico_City'
							//'timeZone' => date_default_timezone_get()
						 );
				
			}
			
			
			$attendees = array();
			$invitadoInterno=array();
			if(isset($Json_Event->Correo)){
				foreach ($Json_Event->Correo as $valor) {
					
					array_push($attendees,array('email' => $valor));
					array_push($invitadoInterno, array("email"=>$valor));
				}
			}

			//------------------------------------------------------------------------------------
			//[Dennis 2020-06-26]
			$externalAttendees=array();
			if(isset($Json_Event->correo_externo)){
				foreach($Json_Event->correo_externo as $valor){
					array_push($externalAttendees, array("external_email"=> $valor));
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

			//----------------------------------------------------------------------
			//[Dennis 2020-07-17]
			//Consulta del nombre actual del evento.

			//Alojar en array el nombre actual.
			$title=array();
			$this->oGetEvent=$this->service->events->get("primary",$Json_Event->eventId);

			$title["titulo_anterior"]=$this->oGetEvent->getSummary();
			$title["titulo_actual"]=$Json_Event->TituloEvento;
			$title["id_evento"]=$Json_Event->eventId;

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
			
			//$event_optional = array("sendNotifications" => true,"supportsAttachments" => true );
			$event_optional = array("sendNotifications" => false,"supportsAttachments" => true ); //[Dennis 2020-07-01]: comentado para envio de correo HTML
			//$this->oEventUpdate = $this->service->events->update($this->calendarId,$Json_Event->eventId, $event_calendar,$event_optional);
			$this->oEventUpdate = $this->service->events->update($this->calendarId,$Json_Event->eventId, $event_calendar);
			
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

			//-------------------------------------------------------------------------------------------------------------
			//[Dennis 2020-07-01]
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
				"idEvento"=> $this->oEventUpdate->getId(),
				"linkEvento"=>$this->oEventUpdate->htmlLink,
				"iCal"=>$this->oEventUpdate->getICalUID(),
				"linkMeet"=>$this->oEventUpdate->hangoutLink,
				"adjuntos"=>$attachments,
				'sub_categoria_capacitacion'=>$Json_Event->subCategoria_capa,
				'ramo_capacitacion'=>$Json_Event->ramo_capa,
				"tipo"=>2
				//"caso"=>2
			);
			//-------------------------------------------------------------------------------------------------------------
					
			$CI =& get_instance();
			$CI->load->model('calendar_model');
			$CI->calendar_model->update_Cal($data_table);

			//-------------------------------------------------------------------------------------------------------------
			//[Dennis 2020-07-01]
			
			if(isset($invitadoInterno) || isset($externalAttendees)){
				
				$this->actualizacion_invitado($invitadoInterno,$externalAttendees, $this->oEventUpdate->getId(),$datosCorreo);
			}
			//-------------------------------------------------------------------------------------------------------------
			$datosCorreo["ics"]=$this->creaIcsFile($datosCorreo);//$this->creaIcsFile($datosCorreo);
			//-------------------------------------------------------------------------------------------------------------
			//[Dennis 2020-07-13]
			$this->notificacion_de_actualizacion($datosCorreo, $title);

			//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($title, TRUE));fclose($fp);
			//-------------------------------------------------------------------------------------------------------------
			/*if($Json_Event->clasificacion=="capacitacion"){
				foreach($attendees as $correos){
					if(isset($correos["email"])){
						$this->inserta_en_capa($datosCorreo);
					}
				}
			} */
			//-------------------------------------------------------------------------------------------------------------

			
		}catch(Exception $e){
			echo 'Excepción capturada: ',  $e->getMessage(), "\n";
		}
		
		return json_encode($this->oEventUpdate);	
	}	
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
			$sEmail = $CI->tank_auth->get_usermail();
			 
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
			
			// echo json_encode(array(
				// 'error' => array(
					// 'msg' => $e->getMessage(),
					// 'code' => $e->getCode(),
				// ),
			// ));
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
			
			// $optParams = array(
			  // 'timeZone' => 'America/Merida',
			// );
			$optParams = array(
			  'timeZone' => 'America/Mexico_City',
			);
			
			$this->oGetEvent = $this->service->events->get($this->calendarId, $Json_Event->eventId,$optParams);
			//-------------------------------------------------------------------------------------------------
			//[Dennis 2020-06-11]
			$idEventoBD=explode("_", $this->oGetEvent->getId());
			$CI =& get_instance();
			$CI->load->model('calendar_model');
			$resultado=$CI->calendar_model->select_event($idEventoBD[0]);

			//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($this->oGetEvent, TRUE));fclose($fp);

			foreach($resultado as $elemento){
				$event_json["clasificacion"]=$elemento["clasificacion"];
			}
			//--------------------------------------------------------------------------------------------------
			// $this->oGetEvent = $this->service->events->get($this->calendarId, $Json_Event->eventId);
						
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

			//-------------------------------------------------------------------------------------
			//[Dennis 2020-07-15]: obtención de correos externos.
			//traemos a los invitados activos del evento.
			$CI=& get_instance();
			$CI->load->model("emailmasivo_model");
			$IExternos=$CI->emailmasivo_model->obtenerCorreosExternosActivos($this->oGetEvent->getID());

			$EAttendes=array();

			foreach($IExternos as $valor){
				
				$datos=array(
					"email"=>$valor->correo_externo,
					"id"=>$valor->idCorreoExt
				);
				array_push($EAttendes, $datos);
			}
			//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($IExternos, TRUE));fclose($fp);
			//--------------------------------------------------------------------------------------

			
			/* Solo recordatorio */
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
			$event_json["externalGuests"]=$EAttendes;
			$event_json["attachments"] = $attach;

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
	/*
	* Ejemplo de uso
	* foreach ($getCalendar as $key => $color) {
	* 		print "colorId : {$key}\n";
	*		print "  Background: {$color->getBackground()}\n";
	*		print "  Foreground: {$color->getForeground()}\n";
	*	}
	*/
	public function getColorcalendar(){
		try{
			
			$colors = $service->colors->get();
			$this->oGetCalendar = $colors->getCalendar();

		}catch(Exception $e){
			echo 'Excepción capturada: ',  $e->getMessage(), "\n";
		}
		
		return $this->oGetCalendar;
	}
	/*
	* Ejemplo de uso
	*	foreach ($getcolorsEvent as $key => $color) {
	*	  print "colorId : {$key}\n";
	*	  print "  Background: {$color->getBackground()}\n";
	*	  print "  Foreground: {$color->getForeground()}\n";
	*	}
	*/
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

	//----------------------------------------------------------------
	//[Dennis 2020-06-18] band0
	function notificacion_del_evento($datosCorreo){

		$config=array(
			"protocol"=>"smtp",
			"smtp_host"=>"mail.agentecapital.com",
			"smtp_port"=>587,
			"smtp_user"=>"auxiliardesarrollo@agentecapital.com",
			"smtp_pass"=>"AuxiliarDes2020#",
			"mailtype"=>"html",
			"wordwrap"=>TRUE

		); // Creamos la configuracion en caso de que se utilice una configuracion de email SMTP.

		$CI=& get_instance(); //Creamos la nueva instancia.
		$CI->load->library("email"); //Cargamos la libreria de email.
		$CI->load->model("calendar_model");
		$CI->email->initialize($config); //Inicializamos la configuración para la librería Email.
		
		$ruta="files/";
		$rutaIcal="files/icalendar_files";
		
		//En caso de algunos cambios en el evento (create,update, delete), cambiar el subject
		$subject="";
		
		switch($datosCorreo["tipo"]){
			case 1: $subject="Invitación a: ".$datosCorreo["titulo"];
			break;
			case 2: $subject=$datosCorreo["subject"]; //$subject="Actualización del siguiente evento a: ".$datosCorreo["titulo"];
			break;
		}

		//Proceso de envio masivo de invitación a correos internos.
		if(isset($datosCorreo["destinatarios"])){
			foreach($datosCorreo["destinatarios"] as $valor){
				if(isset($valor["email"])){
					$consulta=$CI->calendar_model->devuelve_invitado_unitario($valor["email"],$datosCorreo["idEvento"]);}

					if(isset($consulta)){
						foreach($consulta as $datos){

							$data["datos"]=$datosCorreo;
							$data["datos"]["TInvitado"]=$datos->tipo_invitado;
							$data["datos"]["invitado"]=$datos->id_invitado;
							$data["datos"]["estado"]=$datos->estado;
							//$data["datos"]["correoI"]=$datos->correo_lectronico;

							//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($data, TRUE));fclose($fp);

							$mensaje=$CI->load->view("accesoAEvento/vistaCorreo",$data ,true);

							//Proceso de envio de correos a cada iteracion
							//$CI->email->set_header("Content-type","text/calendar");
							$CI->email->from($datosCorreo["correo"],"AGENTE CAPITAL SEGUROS Y FIANZAS");
							$CI->email->to($datos->correo_lectronico);
							//$CI->email->to("auxiliardesarrollo@agentecapital.com");
							$CI->email->subject($subject);
							$CI->email->message($mensaje); //$this->oEventCreate->hangoutLink
							//Anexar archivo ics al mensaje.
							//$CI->email->attach("".FCPATH.$rutaIcal."/".$datosCorreo["idEvento"].".ics");
							$CI->email->attach($datosCorreo["ics"]);
							foreach($datosCorreo["adjuntos"] as $arrayAdjuntos){
								//$CI->email->attach("".FCPATH.$ruta.$arrayAdjuntos["title"]."");
								$CI->email->attach($_SERVER["DOCUMENT_ROOT"]."/V3/".$ruta.$arrayAdjuntos["title"]);
							}
					
							$CI->email->send();
							//$CI->email->print_debugger();
						}
					}
				}
			}
		
			//----------envio masivo a correos externos---------------------------------
			if(isset($datosCorreo["destinatario_externo"])){
				foreach($datosCorreo["destinatario_externo"] as $valor){

					$data["datos"]=$datosCorreo;
					$data["datos"]["TInvitado"]="externo";
					$data["datos"]["correoI"]=$valor["external_email"];
					$mensaje=$CI->load->view("accesoAEvento/vistaCorreo",$data ,true);

					$CI->email->from($datosCorreo["correo"],"AGENTE CAPITAL SEGUROS Y FIANZAS");
					$CI->email->to($valor["external_email"]);
					//$CI->email->subject("Invitación a: ".$datosCorreo["titulo"]);
					$CI->email->subject($subject);
					$CI->email->message($mensaje); //$this->oEventCreate->hangoutLink
					//Anexar archivo ics al mensaje.
					//$CI->email->attach("".FCPATH.$rutaIcal."/".$datosCorreo["idEvento"].".ics");
					$CI->email->attach($datosCorreo["ics"]);

					foreach($datosCorreo["adjuntos"] as $arrayAdjuntos){
						$CI->email->attach("".FCPATH.$ruta.$arrayAdjuntos["title"]."");
						//$CI->email->attach($_SERVER["DOCUMENT_ROOT"]."/V3/".$ruta.$arrayAdjuntos["title"]);
					}

					$CI->email->send();
				}
			}
	}
	

	//---------------------------------------------------------------
	//[Dennis 2020-07-02]: obtención de datos del correo e inserccion a db.
	function registro_invitado($correos, $evento, $datosCorreo){

		$datosInvitado=array();

		$CI=& get_instance();
		$CI->load->model("calendar_model");

		if(isset($correos)){
						
			foreach($correos as $valor){
				$consulta=$CI->calendar_model->obtener_invitado_interno($valor["email"]);
				//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($consulta, TRUE));fclose($fp);

				if(isset($consulta)){
					foreach($consulta as $datos){
						$datosInvitado["nombres"]=strtolower($datos->nombres);
						$datosInvitado["apellido_paterno"]=strtolower($datos->apellidoPaterno);
						$datosInvitado["apellido_materno"]=strtolower($datos->apellidoMaterno);
						$datosInvitado["correo_lectronico"]=$datos->email;
						$datosInvitado["telefono"]=$datos->celPersonal;
						$datosInvitado["ciudad"]=strtolower($datos->municipioDomicilio);
						$datosInvitado["organizacion"]="Agente Capital";
						$datosInvitado["puesto"]=strtolower($datos->nombre);
						$datosInvitado["tipo_invitado"]="interno";
						$datosInvitado["id_evento"]=$evento;
						$datosInvitado["estado"]="pendiente";
					
						$lastId=$CI->calendar_model->inserta_invitados($datosInvitado);
						//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($lastId, TRUE));fclose($fp);
						//Para capacitación inserta en tabla temporal los datos del agente y evento.
						/*if($datosCorreo["clasificacion"]=="capacitacion"){
							$this->eventoCapaTmp($lastId, $datosCorreo, $datos->idPersona);
						}*/
					}
				} 
			} 
		}
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

						/*if($datosCorreo["clasificacion"]=="capacitacion"){
							$this->eventoCapaTmp($lastId, $datosCorreo, $datos->idPersona);
						}*/
					}
				} 
			}
		} // fin del proceso interno.

		//$this->actualizaCapaTmp($tmpinvitados,$datosCorreo);

		//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($tmpinvitados, TRUE));fclose($fp);

		//Validación de correos externos registrados
		foreach($externos as $emails){
			//valida si el correo externo esta en registro.
			//true omite, false continua
			$consulta=$CI->calendar_model->consultaInvitados($emails["external_email"],$evento);

			if($consulta!=true){
				//valida si el correo externo esta en lista de contactos.
				//true omite, false continua
				$_checkExt=$CI->emailmasivo_model->devuelve_correoExt_unitario($emails["external_email"],$evento);

				if($_checkExt!=true){

					//insertar contacto externo en caso de que no este en la lista de contactos.
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
	//-----------------------------------------------------------------------------------------------------------------
	function notificacion_de_actualizacion($datosCorreo, $title){
		
		//configuración SMTP.
		$config=array(
			"protocol"=>"smtp",
			"smtp_host"=>"mail.agentecapital.com",
			"smtp_port"=>587,
			"smtp_user"=>"auxiliardesarrollo@agentecapital.com",
			"smtp_pass"=>"AuxiliarDes2020#",
			"mailtype"=>"html",
			"wordwrap"=>TRUE
		);

		//Cargamos la libreria email.
		$CI=& get_instance();
		$CI->load->library("email", $config);

		//Cargamos el modelo.
		$CI->load->model("calendar_model");

		$data=array();
		$UFaltantes=array();
		$noRegistrados=array();
		$subject="";
		$ruta="files/";
		$rutaIcal="files/icalendar_files";

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

		//Proceso de envio de actualización de manera interna.
		if(isset($datosCorreo["destinatarios"])){
			foreach($datosCorreo["destinatarios"] as $valor){
				if(isset($valor["email"])){

					$consulta=$CI->calendar_model->devuelve_invitado_unitario($valor["email"],$datosCorreo["idEvento"]);

					if(isset($consulta)){
						foreach($consulta as $datos){

							$data["datos"]=$datosCorreo;
							$data["datos"]["TInvitado"]=$datos->tipo_invitado;
							$data["datos"]["invitado"]=$datos->id_invitado;
							$data["datos"]["estado"]=$datos->estado;

							$mensaje=$CI->load->view("accesoAEvento/vistaCorreo",$data ,true);

							//Proceso de envio de correos a cada iteracion
							$CI->email->from($datosCorreo["correo"],"AGENTE CAPITAL SEGUROS Y FIANZAS");
							$CI->email->to($datos->correo_lectronico);
							//$CI->email->to("auxiliardesarrollo@agentecapital.com");
							$CI->email->subject($subject);
							//$CI->email->subject("Actualización del evento: ".$datosCorreo["titulo"]);
							$CI->email->message($mensaje); //$this->oEventCreate->hangoutLink
							//$CI->email->attach("".FCPATH.$rutaIcal."/".$datosCorreo["idEvento"].".ics");
							$CI->email->attach($datosCorreo["ics"]);
							//$CI->email->attach($_SERVER["DOCUMENT_ROOT"]."/V3/".$rutaIcal."/".$datosCorreo["idEvento"].".ics");

							foreach($datosCorreo["adjuntos"] as $arrayAdjuntos){
								$CI->email->attach("".FCPATH.$ruta.$arrayAdjuntos["title"]."");
								//$CI->email->attach($_SERVER["DOCUMENT_ROOT"]."/V3/".$ruta.$arrayAdjuntos["title"]);
							}

							$CI->email->send();
						}
					}
				}
			}
		}

		//Proceso de validación de correos externos ya habilitados como aceptados.
		//Proceso externo.
		if(isset($datosCorreo["destinatario_externo"])){
			foreach($datosCorreo["destinatario_externo"] as $valor){
				
				$consulta=$CI->calendar_model->devuelve_invitado_unitario($valor["external_email"],$datosCorreo["idEvento"]);
				//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($consulta, TRUE));fclose($fp);

				if(isset($consulta)){

					foreach($consulta as $datos){
						
						$data["datos"]=$datosCorreo;
						$data["datos"]["invitado"]=$datos->id_invitado;
						$data["datos"]["estado"]=$datos->estado;
						$data["datos"]["TInvitado"]="externo";
						
						//Anexamos el array con id_invitado y estado para validación en vista.
						$mensaje=$CI->load->view("accesoAEvento/vistaCorreo", $data, true);

						//Proceso de envio de correo exitoso.
						$CI->email->from($this->email,"AGENTE CAPITAL SEGUROS Y FIANZAS");
						$CI->email->to($datos->correo_lectronico);	
						//$CI->email->subject("Actualización del evento: ".$datosCorreo["titulo"]);
						$CI->email->subject($subject);
						$CI->email->message($mensaje);
						//$CI->email->attach("".FCPATH.$rutaIcal."/".$datosCorreo["idEvento"].".ics");
						$CI->email->attach($datosCorreo["ics"]);
						//$CI->email->attach($_SERVER["DOCUMENT_ROOT"]."/V3/".$rutaIcal."/".$datosCorreo["idEvento"].".ics");

						foreach($datosCorreo["adjuntos"] as $arrayAdjuntos){
							$CI->email->attach("".FCPATH.$ruta.$arrayAdjuntos["title"]."");
							//$CI->email->attach($_SERVER["DOCUMENT_ROOT"]."/V3/".$ruta.$arrayAdjuntos["title"]);
						}

						if(!$CI->email->send()){
							echo $CI->email->print_debugger();
							//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($CI->email->print_debugger(), TRUE));fclose($fp);
						} 
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

					//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($datosCorreo, TRUE));fclose($fp);
					//Reenvio de correo a invitados que aun no han llenado el formulario.
					$this->notificacion_del_evento($datosCorreo);
				
				}
			}
		} // fin de proceso externo
	} //fin del metodo
	//-----------------------------------------------------------------------------------------------------------------

	function notificacion_cancelacion($evento){

		$notificacion=false;

		//llamamos a la api para optener información del evento
		$this->oGetEvent= $this->service->events->get("primary", $evento);

		//cargar la instancia del modelo.
		$CI=& get_instance();
		$CI->load->model(array("calendar_model","emailmasivo_model"));

		//configuración de salida de correos a SMTP.
		$config=array(
			"protocol"=>"smtp",
			"smtp_host"=>"mail.agentecapital.com",
			"smtp_port"=>587,
			"smtp_user"=>"auxiliardesarrollo@agentecapital.com",
			"smtp_pass"=>"AuxiliarDes2020#",
			"mailtype"=>"html",
			"wordwrap"=>TRUE
		);

		//Carga de la libreria email
		$CI->load->library("email", $config);

		$_infoE=array();

		//intanciamos en el array los datos del evento.
		$_infoE["datos"]["titulo"]=$this->oGetEvent->getSummary();
		$_infoE["datos"]["descripcion"]=$this->oGetEvent->getDescription();
		$_infoE["datos"]["lugar"]=$this->oGetEvent->getLocation();

		//conversion de fechas
		$fechaI= new DateTime($this->oGetEvent->getStart()->getDateTime());
		$_infoE["datos"]["fecha_inicio"]=$fechaI->format("d-M-y H:i:s");

		$fechaF= new DateTime($this->oGetEvent->getEnd()->getDateTime());
		$_infoE["datos"]["fecha_final"]=$fechaF->format("d-M-y H:i:s");

		//Envio de correo masivo a todos los invitados internos.
		$invitado=$CI->calendar_model->devuelveInvitados($evento);

		//Obtencion de correos externos activos del evento.
		$correoE=$CI->emailmasivo_model->obtenerCorreosExternosActivos($evento);

		$nombreC="";

		$invitados=array();
		$oka=array();
		$oki=array();

		//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($invitado, TRUE));fclose($fp);

		//segmentación de invitados a interno y externo.
		if(isset($invitado)){
			foreach($invitado as $datos){

				//almacenaje de correos externos.
				if($datos->tipo_invitado=="externo"){
					array_push($oka,$datos->correo_lectronico);
				}

				$nombreC=ucwords($datos->nombres)." ".ucwords($datos->apellido_paterno)." ".ucwords($datos->apellido_materno);
				$_infoE["datos"]["nombre"]=$nombreC;

				$mensaje=$CI->load->view("accesoAEvento/correoCancelacion", $_infoE, true);

				$CI->email->from($CI->tank_auth->get_usermail(), "AGENTE CAPITAL SEGUROS Y FIANZAS");
				//$CI->email->to("auxiliardesarrollo@agentecapital.com");
				$CI->email->to($datos->correo_lectronico);
				$CI->email->subject("Cancelación del evento: ".$this->oGetEvent->getSummary());
				$CI->email->message($mensaje);

				if(!$CI->email->send()){
					echo $CI->email->print_debugger();
				}

				//no borrar
				/*if($datos->tipo_invitado=="interno"){
					array_push($oka, $datos);
					$invitados["interno"]=$oka;
				} elseif($datos->tipo_invitado=="externo"){
					array_push($oki, $datos);
					$invitados["externo"]=$oki;
				} */			
			}
		}

		
		// En caso de que exista un invitado como externo hace la comparación con catalog_correos_externos, si no esta en el array envia mensaje.
		
		if(isset($oka)){
			foreach($correoE as $valor){
				if(!in_array($valor->correo_externo, $oka)){

					//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($valor->correo_externo, TRUE));fclose($fp);

					$_infoE["datos"]["nombre"]="usuario del correo ".$valor->correo_externo."";

					$mensaje=$CI->load->view("accesoAEvento/correoCancelacion", $_infoE, true);

					$CI->email->from($CI->tank_auth->get_usermail(), "AGENTE CAPITAL SEGUROS Y FIANZAS");
					//$CI->email->to("auxiliardesarrollo@agentecapital.com");
					$CI->email->to($valor->correo_externo);
					$CI->email->subject("Cancelación del evento: ".$this->oGetEvent->getSummary());
					$CI->email->message($mensaje);

					if(!$CI->email->send()){
						echo $CI->email->print_debugger();
						//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($CI->email->print_debugger(), TRUE));fclose($fp);
					}
				}
			}
		}
		//En caso de no contar con ningun externo, toma los datos de la tabla catalog_correos_externos, ubica correos del evento y envia mensaje.
		if(empty($oka)){
			foreach($correoE as $info){

				$_infoE["datos"]["nombre"]="usuario del correo ".$info->correo_externo."";

				$mensaje=$CI->load->view("accesoAEvento/correoCancelacion", $_infoE, true);

				$CI->email->from($CI->tank_auth->get_usermail(), "AGENTE CAPITAL SEGUROS Y FIANZAS");
				//$CI->email->to("auxiliardesarrollo@agentecapital.com");
				$CI->email->to($info->correo_externo);
				$CI->email->subject("Cancelación del evento: ".$this->oGetEvent->getSummary());
				$CI->email->message($mensaje);

				if(!$CI->email->send()){
					echo $CI->email->print_debugger();
				}
			}
		}
		//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($invitados, TRUE));fclose($fp);
		//return $notificacion;
		//Envio masivo a los correos externos del evento.
	}

	//-----------------------------------------------------------------------------------------------------------------
	function creaIcsFile($datosCorreo){

		//PRODID: hacksw/handcal//NONSGML v1.0
		//PRODID:-//Google Inc//Google Calendar 70.9054//EN
		$direccion=FCPATH."files/icalendar_files";
		//$direccion=$_SERVER["DOCUMENT_ROOT"]."/Capsys/www/V3/files/icalendar_files";
		$_incal_content="BEGIN:VCALENDAR
		VERSION:2.0
		CALSCALE:GREGORIAN
		METHOD:REQUEST
		BEGIN:VEVENT
		ORGANIZER;CN=".$this->email.":mailto:".$this->email."
		UID:".$datosCorreo["iCal"]."
		CLASS:PUBLIC
		DTSTAMP:".gmdate('Ymd').'T'. gmdate('His')."Z
		DTSTART:".$datosCorreo["fecha_inicio"]."T".$datosCorreo["hora_inicio"]."Z
		DTEND:".$datosCorreo["fecha_final"]."T".$datosCorreo["hora_final"]."Z
		LOCATION:".$datosCorreo["lugar"]."
		STATUS:CONFIRMED
		SUMMARY:".$datosCorreo["titulo"]."
		ACTION:EMAIL
		DESCRIPTION:".$datosCorreo["descripcion"]."
		END:VEVENT
		END:VCALENDAR";

		if(!file_exists($direccion."/".$datosCorreo["idEvento"].".ics")){

			$ical=fopen($direccion."/".$datosCorreo["idEvento"].".ics", "w");
			file_put_contents($direccion."/".$datosCorreo["idEvento"].".ics", str_replace("\t","",$_incal_content));
			fclose($ical);
		} else{
			file_put_contents($direccion."/".$datosCorreo["idEvento"].".ics", str_replace("\t","",$_incal_content));
		}

		return $direccion."/".$datosCorreo["idEvento"].".ics";
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


		//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($agentes, TRUE));fclose($fp);
	}
	//-----------------------------------------------------------------------------------------------------------------
	function eliminaInfo($evento){

		$CI=& get_instance();
		$CI->load->model("calendar_model");

		$CI->calendar_model->eliminaInfoCapacitacion($evento);

	}
	//-----------------------------------------------------------------------------------------------------------------
}