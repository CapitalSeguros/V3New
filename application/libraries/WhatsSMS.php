<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//require('KLogger/vendor/autoload.php');

class WhatsSMS 
{
	
	 var $globalAbrirMail	= 0;
	 var $precioWhats			=  "0.78";
	 var $precioSMS             = "0.64";
function __construct()
 {	

	$this->CI=& get_instance();
	$this->CI->load->model('bitly_model');

}
//--------------------------------------------------------------------------------------------
public  function obtenerLink($link){ 	
      $linkLargo	= $link;
	if($linkLargo != "" && $linkLargo!=false){$linkCorto	= $this->CI->bitly_model->linkCorto($linkLargo);} 
	else {$linkCorto	= NULL;}
		return $linkCorto;			
 }
 //------------------------------------------------------------------------------------------

 function enviarWhats($array)
 {
 	$respuesta=0;    
    $data_insert = array
    (
	 'envia'		=> $this->CI->tank_auth->get_usernamecomplete()." <".$this->CI->tank_auth->get_usermail().">",
	 'idUser'	=> $this->CI->tank_auth->get_user_id(),
	 'name'		=> '',
	 'numbers'	=> rtrim(ltrim($array['numbers'])),
	 'message'	=> $array['message'],
	);

    if($this->sendWhats($data_insert['numbers'],$data_insert['message']))
    { ;
	  if($this->Insert_Whats_masivo($data_insert))
	  {				
	   $this->descuentaSaldo($data_insert['idUser'],$this->precioWhats);
	  
	   $message				= "Se envio correctamente el SMS masivo";
	   $alert					= "Exitoso!";
	   $alert_class			= "alert-success";							
	   $data["paraTelefonos"]	= "";
	   $data["smsText"]		= "";								
	   $respuesta=1;
	  }
    }
	else
	{
	 $message		= "Ocurrio un error durante la transacción, intente de nuevo";
	 $alert			= "Advertencia!";
	 $alert_class	= "alert-warning";

	}
	return $respuesta;
 }
//------------------------------------------------------------------------------------------
function enviarSMS($array)
{
	$respuesta=0;    					
  $data_insert = array(
  'envia'		=> $this->CI->tank_auth->get_usernamecomplete()." <".$this->CI->tank_auth->get_usermail().">",
  'idUser'	=> $this->CI->tank_auth->get_user_id(),
  'name'		=> '',
  'numbers'	=> rtrim(ltrim($array['numbers'])),
  'message'	=> $array['message'],
  );
 
 if ($this->sendSMS($data_insert['numbers'],$data_insert['message']))
 {
   $this->Insert_SMS_masivo($data_insert);
   $this->descuentaSaldo($data_insert['idUser'],$this->precioSMS);
   $message				= "Se envio correctamente el SMS masivo";
   $alert					= "Exitoso!";
   $alert_class			= "alert-success";						
   $data["paraTelefonos"]	= "";
   $data["smsText"]		= "";
   $respuesta=1;    							
  }
  else
  {
	$message		= "Ocurrio un error durante la transacción, intente de nuevo";
	$alert			= "Advertencia!";
	$alert_class	= "alert-warning";
  }
  return $respuesta;    
}

//------------------------------------------------------------------------------------------
function Insert_Whats_masivo($data)
{		
	$exito = false;		
	try{$exito = $this->Insert_envio_whats($data);}
	catch(Exception $e){}
	return $exito;
}
//------------------------------------------------------------------------------------------
function Insert_envio_whats($data)
{		
		$insert_value = false;		
		try{
			
			$this->CI->db->trans_begin();						
			$hoy = new DateTime('now');
			$date = $hoy->format("Y-m-d H:i:s");			
			$old = new DateTime('1900-01-01 00:00:00');
			$datesend = $old->format("Y-m-d H:i:s");
			$data_table = array(
					'fechacreacion' => $date,
					'envia'			=> $data["envia"], 
					'idUser'		=> $data["idUser"],
					'message'		=> $data["message"],
					'country_code'	=> '52',
					'numbers'		=> $data["numbers"],
					'status'	=> '0',
					'fechaEnvio' => $datesend
			);
			
			$this->CI->db->insert('envio_whats', $data_table);
			
			if ($this->CI->db->trans_status() === FALSE){$this->db->trans_rollback();}
			else
			{
				$this->CI->db->trans_commit();
				$insert_value = true;
			}
		}
		catch(Exception $e){}
		
		return $insert_value;
}

//-----------------------------------------------------------------------------------------
function descuentaSaldo($idUser,$precio)
{
		//$precioSms = $this->precioSms;
		$sql = "Update `envio_saldo` Set`saldo` = `saldo` - ".$precio." Where `idUser` = '".$idUser."'";
		$this->CI->db->query($sql);
}
//-----------------------------------------------------------------------------------------
public function sendWhats($numberPhone=0000000000,$mesageBody=false)
{
		$sendWhats	= false;
		$search		= array('{', '}', '"');
		$replace	= array('', '', '');
		$claveInternacional = '521';//'052';
		$data	= [
					'phone' => $claveInternacional.$numberPhone, // Receivers phone
					'body'	=> $mesageBody, // Message
				  ];

		$json	= json_encode($data); // Encode data to JSON		
		// URL for request POST /message
		//$url	= 'https://eu72.chat-api.com/instance99658/message?token=2kfq4cl28506knus';
		$url	= 'https://eu39.chat-api.com/instance100400/message?token=vayx913n3fv4i711';
		
        $consulta='select * from instanciaswhats where idPersona='.$this->CI->tank_auth->get_idPersona();

        $dat=$this->CI->db->query($consulta)->result();

		// Make a POST request
		if(count($dat)>0)
	   {
         //$url='https://eu39.chat-api.com/instance'.$dat[0]->instanciaWhats.'/message?token='.$dat[0]->tokenWhats;
         //$url='https://eu140.chat-api.com/instance'.$dat[0]->instanciaWhats.'/sendMessage?token='.$dat[0]->tokenWhats;
	   	$url='https://api.1msg.io/181165/instance'.$dat[0]->instanciaWhats.'/sendMessage?token='.$dat[0]->tokenWhats;
         

         
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
		//	$sendMesage = true;
		if($result[1] == "true"){$sendWhats = true;}    
		 $sendWhats=true;
	    }
		return $sendWhats;
	}
	

//-----------------------------------------------------------------------------------------
function sendSMS($numbers=0000000000, $message=false)
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
		if($result[1] == "true"){$sendMesage = true;}

		return $sendMesage;
}
//-----------------------------------------------------------------------------------------
	function Insert_SMS_masivo($data){		
		$exito = false;		
		try{$exito = $this->Insert_envio_sms($data);}
		catch(Exception $e){}
		return $exito;
	}

//-----------------------------------------------------------------------------------------
	function Insert_envio_sms($data){		
		$insert_value = false;
		
		try{
			
			$this->CI->db->trans_begin();
			
			
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
			
			$this->CI->db->insert('envio_sms', $data_table);
			
			if ($this->CI->db->trans_status() === FALSE)
			{
				$this->CI->db->trans_rollback();
			}
			else
			{
				$this->CI->db->trans_commit();
				$insert_value = true;
			}

		}catch(Exception $e){
			
		}
		
		return $insert_value;
	}
//------------------------------------------------------------------------------------
function obtenerSaldo()
{
	$saldo=0;
	$consulta='select saldo from envio_saldo where idUser='.$this->CI->tank_auth->get_user_id();
	$datos=$this->CI->db->query($consulta)->result();
	if((count($datos))>0){$saldo=$datos[0]->saldo;}
	return $saldo;
}
//------------------------------------------------------------------------------------------
function enviarAutomaticamenteSMS($array)
{
	$respuesta=0;    					
  $data_insert = array(
  'envia'		=> 'Envio Automatico',
  'idUser'	=> '-1',
  'name'		=> '',
  'numbers'	=> rtrim(ltrim($array['numbers'])),
  'message'	=> $array['message'],
  );
 if ($this->sendSMS($data_insert['numbers'],$data_insert['message']))
 {
   $this->Insert_SMS_masivo($data_insert);
   $this->descuentaSaldo('-1',$this->precioSMS);
   $message				= "Se envio correctamente el SMS masivo";
   $alert					= "Exitoso!";
   $alert_class			= "alert-success";						
   $data["paraTelefonos"]	= "";
   $data["smsText"]		= "";
   $respuesta=1;    							
  }
  else
  {
	$message		= "Ocurrio un error durante la transacción, intente de nuevo";
	$alert			= "Advertencia!";
	$alert_class	= "alert-warning";
  }
  return $respuesta;    
}
//---------------------------------------------------------------
function comprobarNumero($telefono)
{
	//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($telefono,TRUE));fclose($fp);
 if($telefono!='')
 {
 	if($telefono!=null){
  $numero=explode('|',$telefono);  
  if((count($numero))>1)
      {
        if(ctype_digit($numero[1])){return $numero[1];}
        else{return  0; }
      }
    else
      { 
      	$numero=explode(':',$telefono);  
      	  if((count($numero))>1)
      {
        if(ctype_digit($numero[1])){return $numero[1];}
        else{return  0; }
      }else
        {
         if(ctype_digit($numero[0])){return $numero[0];}
         else{return 0;}
        }
      }
    }
    else
    {
      return 0; 	
    }
  }
  else{return 0;}
}
//--------------------------------------------------------------- // SMS MASIVO v2.0
public function sendSMSV2($requestParams){

	$headers = array(
		"apikey: 0bf959dfc9127cef8131396dd312548c6f93354c"
	);
	curl_setopt_array($ch = curl_init(), array(
		CURLOPT_URL => "https://api.smsmasivos.com.mx/sms/send",
		CURLOPT_SSL_VERIFYPEER => 0,
		CURLOPT_HEADER => 0,
		CURLOPT_HTTPHEADER => $headers,
		CURLOPT_POST => 1,
		CURLOPT_POSTFIELDS => http_build_query($requestParams),
		CURLOPT_RETURNTRANSFER => 1
	));
	$response = curl_exec($ch);
	curl_close($ch);

	return json_decode($response, true);
}
//---------------------------------------------------------------
}
