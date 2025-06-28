<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class polizas {

	function __construct(){
	}

	//Funciones del envío por correo
	function DatosCorreo(){ //EnviarCorreo
		$IDDocto = $this->input->post('dc');
		$IDCli = $this->input->post('cl');
		$para = $this->input->post('e1');
		$de = $this->input->post('e2');
		$asunto = $this->input->post('sj');
		$mensaje = $this->input->post('bd');
		$cuerpo = '
		<!DOCTYPE html>
		<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
			<head>
				<title></title>
				<meta http-equiv="X-UA-Compatible" content="IE=edge">
				<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
				<meta name="viewport" content="width=device-width, initial-scale=1.0">
				<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
			</head>
			<body>'.$mensaje.'</body></html>';
		$send = "";
		$file_name = array();

		//Estructura del correo
		$for = $para;
    	$subject = $asunto;
    	$mime_boundary="==Multipart_Boundary_x".md5(mt_Rand())."x";
    	$headers = 'From: '.$de. "\r\n"."MIME-Version: 1.0\r\n"."Content-Type: multipart/mixed;\r\n"."boundary=\"{$mime_boundary}\"";
    	$message = "Este es un mensaje de varias partes en formato MIME .\n\n" ."--{$mime_boundary}\n" ."Content-Type: text/html;charset=utf-8\"\n"."Content-Transfer-Encoding: 7bit\n\n" .$cuerpo. "\n\n";

    	//Componentes de los archivos
        foreach($_FILES['adjunto']['tmp_name'] as $key => $tmp_name) { 
    		$tmp_name   = $_FILES['adjunto']['tmp_name'][$key];
    		$type       = $_FILES['adjunto']['type'][$key];
    		$name       = $_FILES['adjunto']['name'][$key];
    		$size       = $_FILES['adjunto']['size'][$key];

        	array_push($file_name,$name);

    		//Información de los archivos a registrar
        	//$extension = explode(".",$name);
    		//$largo = count($extension);
   			//$format = strtoupper($extension[$largo-1]);
    		//$archive['name'] = $name;
   			//$archive['type'] = $type;
   			//$archive['size'] = $size;
   			//$archive['tmp'] = $tmp_name;
   			//$archive['file'] = $format;
   			//$this->db->insert('envioarchivosprueba',$archive);
    		//$info = "Name: ".$name.", Size: ".$size.", Type: ".$type.", Tmp: ".$tmp_name;
    		//echo json_encode($info);

   			if (file_exists($tmp_name)){
        	 	if(is_uploaded_file($tmp_name)){
        	   		$file = fopen($tmp_name,'rb'); 
        	   		$data = fread($file,filesize($tmp_name)); //leer el contenido del archivo en una variable 
        	   		fclose($file);
        	   		//Ahora la codificamos y la dividimos en líneas de longitud aceptables
        	   		$data = chunk_split(base64_encode($data));
        	   	}
        	   	$message .= "--{$mime_boundary}\n" ."Content-Type: {$type};\n" ." name=\"{$name}\"\n" ."Content-Disposition: attachment;\n" ." filename=\"{$name}\"\n" ."Content-Transfer-Encoding: base64\n\n" .$data. "\n\n";
        	}
    	}
        $message.="--{$mime_boundary}--\n";

        //Extraer nombre de los archivos
        $archivos = implode(', ',$file_name);
        echo json_encode($archivos);
        echo json_encode($IDDocto);
        echo json_encode($IDCli);

        //Información del correo a registrar
       	$datos = array(
       	    "desde" => $de,
       	    "para" => $para,
       	    "asunto" => $asunto,
       	    "mensaje" => $cuerpo,
       	    "fileAdjunto" => $archivos,
			"nameAdjunto" => $archivos,
       	    "status" => 0,
       	    "fechaEnvio" => date("Y-m-d H:i:s")
       	);
		echo json_encode($datos);

        //echo json_encode($for);
        //echo json_encode($subject);
        //echo json_encode($message);
        //echo json_encode($headers);

        //Enviar correo y registrar actividad
        mail($for, $subject, $message, $headers)){
      	//	$send = $this->email_model->SendEmail($datos);
      	//	$insert['IDDocto'] = $IDDocto;
		//	$insert['IDCli'] = $IDCli;
		//	$insert['email'] = $this->tank_auth->get_usermail();
		//	$insert['enviado'] = 1;
		//	$insert['comentario'] = "ENVIADO";
        	$send = "Enviado";
   		}
   		else{
      		$send = "Error";
      	//	$insert['IDDocto'] = $IDDocto;
		//	$insert['IDCli'] = $IDCli;
		//	$insert['email'] = $this->tank_auth->get_usermail();
		//	$insert['enviado'] = 0;
		//	$insert['comentario'] = "ERROR AL ENVIAR";
   		}
   		//$this->db->insert('enviopolizashistorial',$insert);
   		echo json_encode($send);
    }
}