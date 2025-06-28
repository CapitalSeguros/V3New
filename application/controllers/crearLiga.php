<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class CrearLiga extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model("crmproyecto_model");
		$this->load->model("calendar_model");
	}

	function crear_liga_asesores(){
		$datos['citas']=$this->crmproyecto_model->getCitasOnlinePendientes();
 		$this->load->view('crmproyecto/crear_liga_asesores',$datos);
 	} 

 	function crear_liga_asesores_enviados(){
 		$datos['citas']=$this->crmproyecto_model->getCitasOnlineEnviados();
 		$this->load->view('crmproyecto/crear_liga_asesores_enviados',$datos);
 	}

	function crear_liga_reunion_enviados(){
		$idPersona = $this->tank_auth->get_idPersona();
		$trainigEvents = $this->calendar_model->getEventsOfGuests();
		$onlyTrainings = array_filter($trainigEvents, function($arr) use($idPersona){
			return 0;
		});

	//$datos['eventos']=$this->crmproyecto_model->getAllConvocatoriaReunionEnviados();
		$datos["organizers"] = $this->calendar_model->getTrainingOrganizers();
		$datos["capacitaciones"] = $this->calendar_model->devuelveCapacitaciones(null, "capacitacion");
		$datos["estandar"] = $this->calendar_model->devuelveCapacitaciones($this->tank_auth->get_usermail(), "estandar");
	$this->load->view('crmproyecto/crear_liga_reunion_enviados',$datos);
	}

 	function guardar_liga_asesores(){
 		$data = array(
			'id' => $this->input->post('id',TRUE),
			'liga' => $this->input->post('liga',TRUE),
			'password' => $this->input->post('password',TRUE)	
		);
		$this->crmproyecto_model->guardar_liga_asesores($data);
    		$this->crear_liga_asesores();
 	}

 	function guardar_liga_asesores_capital(){
 		$data = array(
			'id' => $_REQUEST['id'],
			'liga' => $_REQUEST['liga'],
			'password' => $_REQUEST['password']
		);
		$this->crmproyecto_model->guardar_liga_asesores($data);
		$id_userInfo=$this->tank_auth->get_idPersona();
		$this->enviarCorreoLigaCapital($id_userInfo);
		$datos['id_userInfo']=$id_userInfo;
		$datos['ListaAgenda']=$this->crmproyecto_model->agenda_citas_asesores_capital($id_userInfo);
    		$this->load->view('calendario/administracion_citas_online',$datos);
 	}

 	function enviarCorreoLigaCapitalCancelacion(){
 		$id= $_REQUEST['id'];
		$citas=$this->crmproyecto_model->getCitaOnlinePendiente($id);
	 		foreach ($citas as $cita) {
	 			$nombre=$cita->cliente;
	            		$emailUser=$cita->emailUser;
	 			$email=$cita->correo;
	 			$detalle=$cita->detalle;
	 			$agente=$cita->nombre;
	 			$fechaCita=$cita->fecha;
	 			$horaCita=$cita->hora;
	 			$dia=$cita->dia;
	 			$liga_zoom=$cita->liga_zoom;
	 			$password_liga=$cita->password_liga;
	 		}
			$mensaje='<DOCTYPE html><html><body><table width="75%" align="center" style="border-width: 1px;padding: 5%; border-color: #b2b2b2;border-radius: 10px;border-style: solid;background-color: #fff;"><tr><td align="left" colspan="2"><img src="https://www.capsys.com.mx/V3/assets/img/logo/logocapital.png" width="30%" style="margin-top: -8%;"></td></tr><tr><td><b>Nombre y Apellido:</b></td><td>'.strtoupper($nombre).'</td></tr><tr><td width="50%"><b>E-mail:</b></td><td>'.$email.'</td></tr><tr><td><b>Detalles de su Cita:</b></td><td>'.$detalle.'</td></tr><tr><td colspan="2"><br></td></tr><tr align="left"><td colspan="2"><h4 style="color: blue;">AGENTE ASESOR CAPITAL</h4></td></tr><tr><td><b>Nombre:</b></td><td>'.strtoupper($agente).'</td></tr><tr><td colspan="2"><br><br></td></tr><tr align="left"><td colspan="2"><h4 style="color: blue;">AGENDA</h4></td></tr><tr><td><b>Dia:</b></td><td>'.strtoupper($dia).' , '.$fechaCita.'</td></tr><tr><td><b>Hora de reunion:</b></td><td>'.$horaCita.'</td></tr><tr><td colspan="2"><b><center>¡ESTA CITA HA SIDO CANCELADA!</center></b></td></tr></table></body></html>';	    
	        
		//Envio de correos
	        $asunto="Cancelacion Cita Online - Asesores Capital Seguros y Fianzas";
	        $desde="Avisos GAP<avisos@agentecapital.com>";
	        $fechaEnvio=date('Y-m-d h:m:s');
	        $para=trim($email);
	        $sql="INSERT INTO envio_correos(desde,para,asunto,fechaEnvio,mensaje,status,identificaModulo) values('$desde','$para','$asunto','$fechaEnvio','$mensaje',0,'Asesores Online')";
	        $rs=$this->db->query($sql);

    		$id_userInfo=$this->tank_auth->get_idPersona();
		$datos['id_userInfo']=$id_userInfo;
		$datos['ListaAgenda']=$this->crmproyecto_model->agenda_citas_asesores_capital($id_userInfo);
    		$this->load->view('calendario/administracion_citas_online',$datos);
 	}


	function enviarCorreoLigaCapital(){
		$id= $this->input->get('id',TRUE);
		$citas=$this->crmproyecto_model->getCitaOnlinePendiente($id);
	 		foreach ($citas as $cita) {
	 			$nombre=$cita->cliente;
	            		$emailUser=$cita->emailUser;
	 			$email=$cita->correo;
	 			$detalle=$cita->detalle;
	 			$agente=$cita->nombre;
	 			$fechaCita=$cita->fecha;
	 			$horaCita=$cita->hora;
	 			$dia=$cita->dia;
	 			$liga_zoom=$cita->liga_zoom;
	 			$password_liga=$cita->password_liga;
	 		}
			$mensaje='<DOCTYPE html><html><body><table width="75%" align="center" style="border-width: 1px;padding: 5%; border-color: #b2b2b2;border-radius: 10px;border-style: solid;background-color: #fff;"><tr><td align="left" colspan="2"><img src="https://www.capsys.com.mx/V3/assets/img/logo/logocapital.png" width="30%" style="margin-top: -8%;"></td></tr><tr><td><b>Nombre y Apellido:</b></td><td>'.strtoupper($nombre).'</td></tr><tr><td width="50%"><b>E-mail:</b></td><td>'.$email.'</td></tr><tr><td><b>Detalles de su Cita:</b></td><td>'.$detalle.'</td></tr><tr><td colspan="2"><br></td></tr><tr align="left"><td colspan="2"><h4 style="color: blue;">AGENTE ASESOR CAPITAL</h4></td></tr><tr><td><b>Nombre:</b></td><td>'.strtoupper($agente).'</td></tr><tr><td colspan="2"><br><br></td></tr><tr align="left"><td colspan="2"><h4 style="color: blue;">AGENDA</h4></td></tr><tr><td><b>Dia:</b></td><td>'.strtoupper($dia).' , '.$fechaCita.'</td></tr><tr><td><b>Hora de reunion:</b></td><td>'.$horaCita.'</td></tr><tr><td><b>Liga de Video Conferencia:</b></td><td>'.$liga_zoom.'</td></tr><tr><td><b>Codigo de Acceso:</b></td><td>'.$password_liga.'</td></tr></table></body></html>';	    
	        
		//Envio de correos
	        $asunto="Cita Online - Asesores Capital Seguros y Fianzas";
	        $desde="Avisos GAP<avisos@agentecapital.com>";
	        $fechaEnvio=date('Y-m-d h:m:s');
	        $para=trim($email);
	        $sql="INSERT INTO envio_correos(desde,para,asunto,fechaEnvio,mensaje,status,identificaModulo) values('$desde','$para','$asunto','$fechaEnvio','$mensaje',0,'Asesores Online')";
	        $rs=$this->db->query($sql);
	        //**********

		$this->crmproyecto_model->setCitaOnlinePendiente($id);
	        $this->enviarCorreoLigaAsesor($nombre,$emailUser,$email,$detalle,$agente,$fechaCita,$horaCita,$dia,$liga_zoom,$password_liga);
	}



function enviarCorreoLiga(){
	$id= $this->input->get('id',TRUE);
	$citas=$this->crmproyecto_model->getCitaOnlinePendiente($id);
 		foreach ($citas as $cita) {
 			$nombre=$cita->cliente;
            		$emailUser=$cita->emailUser;
 			$email=$cita->correo;
 			$detalle=$cita->detalle;
 			$agente=$cita->nombre;
 			$fechaCita=$cita->fecha;
 			$horaCita=$cita->hora;
 			$dia=$cita->dia;
 			$liga_zoom=$cita->liga_zoom;
 			$password_liga=$cita->password_liga;
 		}
$mensaje='<DOCTYPE html><html><body>
<table width="75%" align="center" style="border-width: 1px;padding: 5%; border-color: #b2b2b2;border-radius: 10px;border-style: solid;background-color: #fff;"><tr><td align="left" colspan="2"><img src="https://www.capsys.com.mx/V3/assets/img/logo/logocapital.png" width="30%" style="margin-top: -8%;"></td></tr><tr><td><b>Nombre y Apellido:</b></td><td>'.strtoupper($nombre).'</td></tr><tr><td width="50%"><b>E-mail:</b></td><td>'.$email.'</td></tr><tr><td><b>Detalles de su Cita:</b></td><td>'.$detalle.'</td></tr><tr><td colspan="2"><br></td></tr><tr align="left"><td colspan="2"><h4 style="color: blue;">AGENTE ASESOR CAPITAL</h4></td></tr><tr><td><b>Nombre:</b></td><td>'.strtoupper($agente).'</td></tr><tr><td colspan="2"><br><br></td></tr><tr align="left"><td colspan="2"><h4 style="color: blue;">AGENDA</h4></td></tr><tr><td><b>Dia:</b></td><td>'.strtoupper($dia).' , '.$fechaCita.'</td></tr><tr><td><b>Hora de reunion:</b></td><td>'.$horaCita.'</td></tr><tr><td><b>Liga de Video Conferencia:</b></td><td>'.$liga_zoom.'</td></tr><tr><td><b>Codigo de Acceso:</b></td><td>'.$password_liga.'</td></tr></table></body></html>';	    
        
//Envio de correos
        $asunto="Confirmacion Cita Online - Asesores Capital Seguros y Fianzas";
        $desde="Avisos GAP<avisos@agentecapital.com>";
        $fechaEnvio=date('Y-m-d h:m:s');
        $para=trim($email);
        $sql="INSERT INTO envio_correos(desde,para,asunto,fechaEnvio,mensaje,status,identificaModulo) values('$desde','$para','$asunto','$fechaEnvio','$mensaje',0,'Asesores Online')";
        $rs=$this->db->query($sql);
        //**********

	$this->crmproyecto_model->setCitaOnlinePendiente($id);
        $this->enviarCorreoLigaAsesor($nombre,$emailUser,$email,$detalle,$agente,$fechaCita,$horaCita,$dia,$liga_zoom,$password_liga);
	$this->crear_liga_asesores();
}

 function enviarCorreoLigaAsesor($nombre,$emailUser,$email,$detalle,$agente,$fechaCita,$horaCita,$dia,$liga_zoom,$password_liga){
	$mensaje='<DOCTYPE html><html><head><title></title><style>body{font-family:arial;font-size: 12px;}</style></head><body><table width="75%" align="center" style="border-width: 1px;padding: 5%; border-color: #b2b2b2;border-radius: 10px;border-style: solid;background-color: #fff;"."><tr><td align="left" colspan="2"><img src="https://www.capsys.com.mx/V3/assets/img/logo/logocapital.png" width="30%" style="margin-top: -8%;"></td></tr><tr><td colspan="2">Saludos Cordiales, Asesor Agente Capital <b>'.strtoupper($agente).'</b> , un cliente ha agendado una cita con usted. </td></tr><tr><td colspan="2"><br></td></tr><tr align="left"><td colspan="2"><h4 style="color: blue;">DATOS DEL CLIENTE</h4></td></tr><tr><td><b>Nombre y Apellido:</b></td><td>'.strtoupper($nombre).'</td></tr><tr><td width="50%"><b>E-mail:</b></td><td>'.$email.'</td></tr><tr><td><b>Detalles de su Cita:</b></td><td>'.$detalle.'</td></tr><tr><td colspan="2"><br></td></tr><tr><td colspan="2"><br><br></td></tr><tr align="left"><td colspan="2"><h4 style="color: blue;">AGENDA</h4></td></tr><tr><td><b>Dia:</b></td><td>'.strtoupper($dia).' , '.$fechaCita.'</td></tr><tr><td><b>Hora de reunion:</b></td><td>'.$horaCita.'</td></tr><tr><td><b>Liga de Video Conferencia:</b></td><td>'.$liga_zoom.'</td></tr><tr><td><b>Codigo de Acceso:</b></td><td>'.$password_liga.'</td></tr>
	</table></body></html>';

    
    //Envio de correos
    $asunto="Confirmacion Cita Online - Asesores Capital Seguros y Fianzas";
    $desde="Avisos GAP<avisos@agentecapital.com>";
    $fechaEnvio=date('Y-m-d h:m:s');
    $para=trim($emailUser);
    $sql="INSERT INTO envio_correos(desde,para,asunto,fechaEnvio,mensaje,status,identificaModulo) values('$desde','$para','$asunto','$fechaEnvio','$mensaje',0,'Asesores Online')";
    $rs=$this->db->query($sql);
    //**********
 }   
//---------------------------------
 function consultaDatosEvento(){ //Dennis [2021-08-23]
	
	$idCal = $_GET["q"];
	$getDataEvent = $this->calendar_model->getDataEvent($idCal);
	$arrayResponse = array();
	$arrayEventManage = array();
	$permission = array("DIRECTORGENERAL@AGENTECAPITAL.COM", "DIRECTORCOMERCIAL@AGENTECAPITAL.COM", "CAPITALHUMANO@AGENTECAPITAL.COM", "ASISTENTEDIRECCION@AGENTECAPITAL.COM", "SERVICIOSESPECIALES@AGENTECAPITAL.COM");

	if(!empty($getDataEvent)){
		foreach($getDataEvent as $d_e){
			
			$arrayEventManage["titulo"] = $d_e->titulo;
			$arrayEventManage["clasificacion"] = $d_e->clasificacion;
			$arrayEventManage["hFInicio"] = $d_e->fecha_inicio." - ".$d_e->hora_inicio;
			$arrayEventManage["liga"] = $d_e->liga;
			$arrayEventManage["contrasena"] = $d_e->password;
			$arrayEventManage["permission"] = in_array($this->tank_auth->get_usermail(), $permission) ? true : false;
			$arrayEventManage["IGuest"][$d_e->tipo_invitado][] = array(
				"id_invitado" => $d_e->id_invitado,
				"correo" => $d_e->correo_lectronico,
				"estado" => $d_e->estado,
				"nombre" => $d_e->nombres." ".$d_e->apellido_paterno." ".$d_e->apellido_materno
			);
		}

		$arrayResponse["mensaje"] = "Datos obtenidos";
		$arrayResponse["datos"] = $arrayEventManage;
	} else{
		$arrayResponse["mensaje"] = "No obtenidos";
		$arrayResponse["datos"] = $arrayEventManage;
	}

	echo json_encode($arrayResponse);
	//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($arrayEventManage, TRUE));fclose($fp);
	//var_dump($arrayEventManage);
 }
 //---------------------------
 function actualizaEstado(){ //Dennis [2021-08-23]
	
	//$jsonObject = json_decode($_REQUEST['send']);
	//echo json_encode($jsonObject);

	$invitado = $_GET["q"];
	$estado = $_GET["r"];
	$envioCorreo = $_GET["p"];

	$arrayOperation = array();

	$updateStatus = $this->calendar_model->actualizaEstadoInterno($invitado, array("estado" => $estado));
	array_push($arrayOperation, $updateStatus);

	if($envioCorreo == 1 && $updateStatus){

		$envio = $this->sendMailResponse($invitado);
		array_push($arrayOperation, $envio);
	}

	$arrayJsonResponse = array(
		"mensaje" => $updateStatus ? "Estado actualizado" : "Ocurrio un error. Favor de contactar a sistemas", 
		"bool" => $updateStatus
	);

	if(in_array(false, $arrayOperation)){
		$arrayJsonResponse["mensaje"] = "Hubo un error en la actualización de estado. Favor de contactar a sistemas";
	}

	echo json_encode($arrayJsonResponse);
	//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($estado, TRUE));fclose($fp);
 }
 //--------------------------
 function sendMailResponse($invitado){ //Dennis [2021-08-23]

	$getInfoGuest = $this->calendar_model->obtenerInvitado($invitado, "interno");

	if(!empty($getInfoGuest)){
		
		$dataEvent = $this->crmproyecto_model->getConvocatoriaReunionJson($getInfoGuest->id_evento);

		$asunto="Respuesta del organizador de la reunion - Capital Seguros y Fianzas";
		$desde="Avisos GAP<avisos@agentecapital.com>";

		$infoEvent = array();
		$infoEvent["titulo"] = $dataEvent->titulo;
		$infoEvent["fHInicio"] = $dataEvent->fecha_inicio;
		$infoEvent["fHFinal"] = $dataEvent->fecha_final;
		$infoEvent["clasificacion"] = $dataEvent->clasificacion;
		$infoEvent["capacitacion"] = $dataEvent->sub_categoria_capacitacion;
		$infoEvent["evento"] = $dataEvent->id_cal;

		if($getInfoGuest->estado == "pendiente"){

			$infoEvent["subTitulo"] = "Respuesta del organizador: ACEPTADA";
			$infoEvent["estadoEvento"] = "nuevo";
			$infoEvent["invitado"] = $getInfoGuest->id_invitado;
			$infoEvent["tipo"] = "interno";
		
		} else if($getInfoGuest->estado == "rechazado"){

			$infoEvent["estadoEvento"] = "rechazado";
			$infoEvent["subTitulo"] = "Lo sentimos. Su solicitud fue rechazada";
		}

		$mensaje = $this->load->view("accesoAEvento/vistaCorreo", $infoEvent, true);

		$insert = $this->calendar_model->insertaRegistro(array(
			"desde" => $desde,
			"para" => $getInfoGuest->correo_lectronico,
			"asunto" => $asunto,
			"mensaje" => $mensaje,
			"status" => 0,
			"fechaEnvio" => date("Y-m-d H:i:s"),
			"identificaModulo" => "Convocatoria de Reunion"
		), "envio_correos", 1);

		return $insert;
	}
 }
 //--------------------------
}


