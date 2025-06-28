<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class polizas extends CI_Controller{

	function __construct(){
		parent::__construct();
		$params['id_sicas']		= $this->tank_auth->get_IDUserSICAS(); "get_IDUserSICAS";
		$params['user_sicas']	= $this->tank_auth->get_UserSICAS(); "get_UserSICAS";
		$params['pass_sicas']	= $this->tank_auth->get_PassSICAS(); "get_PassSICAS";
		$this->load->library('Ws_sicasdre',$params);
		$this->load->library(array("webservice_sicas_soap","role","libreriav3","ws_sicas","FiltrosDeReportesSicas"));
		$this->load->helper('url');
		$this->load->model("catalogos_model");
		$this->load->model('email_model');
		$this->load->model('personamodelo');
		$this->load->model('capsysdre_actividades');
		$this->emailUser=$this->tank_auth->get_usermail();
	}
//-----------------------------------------------------------
	function busquedas() {	
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} 
		else {
			//Nombres y Correos Empleados
			$array['grupos'] = 1;
			$data['empleados'] = $this->personamodelo->devolverColaboradoresActivos($array);
			//Tipo de Documento
			$CI =& get_instance();
            if(isset($tipoDocumentoDPCAGenerales)){
                $tipoImg['tipoDocumento'] = $tipoDocumentoDPCAGenerales;
            }
            else{
                $tipoImg['tipoDocumento'] = '';
            }
            $data['tipoImagenes'] = $CI->catalogos_model->catalog_tipoimg($tipoImg);
            $data['IDVend']=$this->tank_auth->get_IDVend();
			$this->load->view('headers/header');
			$this->load->view('headers/menu');
			$this->load->view('polizas/busquedas',$data);
		}
	}
//-----------------------------------------------------------
	function Renovacion() {	
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} 
		else {
			$this->load->view('polizas/plantillaPrueba');
		}
	}

//-----------------------------------------------------------
//-> Ventana de consultas ----------------------------------
	function BusquedaPolizas() {
		
		if(isset($_POST['search']) && isset($_POST['type']))
		{
			$search = $_POST['search'];
			$type = $_POST['type'];
	
		}
		else
		{
		$search = $this->input->get('search');
		$type = $this->input->get('type');
		}
		
		$Poliza = "";
		
		if ($type == 1 || $type == 2) {$Poliza = $this->webservice_sicas_soap->SearchDoc($search,$type); }
		else if ($type == 3 || $type == 4) 
		{
			$Poliza = $this->webservice_sicas_soap->SearchName($search,$type);
		}
		else if ($type == 5 || $type == 6) {$Poliza = $this->webservice_sicas_soap->SearchSerieAndPlaca($search,$type);}
		else if ($type == 7) {$Poliza = $this->webservice_sicas_soap->GetEndosos($search,2);}
		else if ($type==11)
		{
			$data_poliza["page"]=1;
			$data_poliza ["idCli"]=$search;			
			$respuesta = $this->ws_sicas->polizasPorCliente($search,'0');			
			if(isset($respuesta->TableInfo))
			{	$Poliza['documentos']=[];		
				foreach ($respuesta->TableInfo as  $value) 
				{					
				 $conver=(array)$value;					
				 array_push($Poliza['documentos'],$conver)	;
		}
				
		}
	

		}
		
		$documentos = array();		
		if ($type == 7) 
		{
			foreach ($Poliza['endosos'] as $rc) {
				//if ($rc->Endoso != 0) { //Endosos disponibles
					array_push($documentos, $rc);
				//}
			}
		}
		else 
		{
			foreach($Poliza["documentos"] as $doc){array_push($documentos, $doc);}
		}
		

		if($type == 3)
		{
          if(isset($_POST['preferenciaComunicacion']))
	      {

		}
		}
		echo json_encode($documentos);
	}
//-----------------------------------------------------------
	function ResultadoPolizas() {
		$data = $this->input->get('id');
		$docto = $this->input->get('cb');
		$type = $this->input->get('tp');
		$file = $this->input->get('dc');
		$tpdoc = $this->input->get('td');
		$Inf = "";
		$Serie = "";
		$Endoso = "";
		$end = array();
		if ($type == 1) {
			if ($tpdoc == 1) {
			$Inf = $this->webservice_sicas_soap->GetIDDocto($data,1);
				$Serie = $this->webservice_sicas_soap->SearchSerieAndPlaca($data,14);
				$Endoso = $this->webservice_sicas_soap->GetEndosos($file,2);
			}
			else if ($tpdoc == 2) {
				$Inf = $this->webservice_sicas_soap->SearchDoc($data,10);
				$Serie = $this->webservice_sicas_soap->SearchSerieAndPlaca($data,14);
				$Endoso = $this->webservice_sicas_soap->GetEndosos($file,2);
			}
		}
		else if ($type == 3) {
			$Inf = $this->webservice_sicas_soap->SearchName($data,10);
			$Serie = $this->webservice_sicas_soap->SearchSerieAndPlaca($file,5);
		}
		else if ($type == 5) {
			$Inf = $this->webservice_sicas_soap->SearchDoc($docto,1);
		$Serie = $this->webservice_sicas_soap->SearchSerieAndPlaca($file,5);
		}

		if (!empty($Endoso)){
			foreach ($Endoso['endosos'] as $rc) {
				//if ($rc->Endoso != 0) { //Endosos disponibles
					array_push($end, $rc);
				//}
			}
		}

		$datos['documentos'] = $Inf['documentos'];
		$datos['serie'] = $Serie['documentos'];
		$datos['endosos'] = $end;
		echo json_encode($datos);
	}
//-----------------------------------------------------------
	function TableRecibos() {
		$data = $this->input->get('id');
		$rec = $this->webservice_sicas_soap->GetRecibo($data);
		//$hon = $this->webservice_sicas_soap->GetHonorario($data);
		$recibos = array();
		foreach ($rec['recibos'] as $rc) {
			if ($rc->IDEnd == "-1") { //Recibos activos por medio de H03430_003
				array_push($recibos, $rc);
			}
		}
		echo json_encode($recibos);
	}
//-----------------------------------------------------------
	function InformacionBitacoras() {
		$clave = $this->input->get('cl');
		$Bit = $this->ws_sicas->informacionDeBitacora($clave);
		$result = array(
			'bitacoras' => $Bit->TableInfo
		);
		$bitacoras = array();
		foreach ($result['bitacoras'] as $bt) {
			array_push($bitacoras, $bt);
		}
		echo json_encode($bitacoras);
	}
//-----------------------------------------------------------
	function InformacionRecibo() {
		$id = $this->input->get('id');
		$Rec = $this->webservice_sicas_soap->GetInfoRecibo($id,1);
		$Hon = $this->webservice_sicas_soap->GetHonorario($id);
		$recibo = array();
		$honorario = array();
		foreach ($Rec['recibo'] as $info) {
			array_push($recibo, $info);
		}
		foreach ($Hon['honorario'] as $info) {
			array_push($honorario, $info);
		}
		$data['recibos'] = $recibo;
		$data['honorarios'] = $honorario;
		echo json_encode($data);
	}
//-----------------------------------------------------------
	function InformacionPolizas() {
		$id = $this->input->get('cl');
		$Pl = $this->webservice_sicas_soap->GetIDDocto($id,2);
		$polizas = array();
		foreach ($Pl['documentos'] as $info) {
			array_push($polizas, $info);
		}
		$data['polizas'] = $polizas;
		echo json_encode($data);
	}
//-----------------------------------------------------------
	//Función del envío por correo
	function DatosCorreo(){ //Prueba pendiente en servidor
		$IDDocto = $this->input->post('dc');
		$IDCli = $this->input->post('cl');
		$para = $this->input->post('e1');
		if(preg_match('/\<(.*)\>/', $this->input->post('e2'), $match)){
			$from=$this->input->post('e2');
		}else{
			$from=$this->input->post('e2').' <'.$this->input->post('e2').'>';
		}
		$de = $from;
		$asunto = $this->input->post('sj');
		$mensaje = $this->input->post('bd');
		$send = "";
		$file_name = array();

		//Estructura del correo
		$for = $para;
    	$subject = $asunto;
    	$mime_boundary="==Multipart_Boundary_x".md5(mt_Rand())."x";
    	$headers = "From: $de\r\n" .
        	"MIME-Version: 1.0\r\n" .
           	"Content-Type: multipart/mixed;\r\n" .
           	" boundary=\"{$mime_boundary}\"";
    	$message = "Este es un mensaje de varias partes en formato MIME .\n\n" .
           	"--{$mime_boundary}\n" .
           	"Content-Type: text/html; charset=\"utf-8\"\n" .
           	"Content-Transfer-Encoding: 7bit\n\n" .
        $mensaje . "\n\n";

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
        	   		$data = fread($file,filesize($tmp_name));
        	   		fclose($file);
        	   		$data = chunk_split(base64_encode($data));
		}
        	   	$message .= "--{$mime_boundary}\n" .
                  	"Content-Type: {$type};\n" .
                  	" name=\"{$name}\"\n" .
                  	"Content-Disposition: attachment;\n" .
                  	" filename=\"{$name}\"\n" .
                  	"Content-Transfer-Encoding: base64\n\n" .
               $data . "\n\n";
		}
		}
        $message.="--{$mime_boundary}--\n";

        //Extraer nombre de los archivos
        $archivos = implode(', ',$file_name);
        //echo json_encode($archivos);

        //Información del correo a registrar
       	$datos = array(
       	    "desde" => $de,
       	    "para" => $para,
       	    "asunto" => $asunto,
       	    "mensaje" => $mensaje,
       	    "fileAdjunto" => $archivos,
			"nameAdjunto" => $archivos,
       	    "status" => 0,
       	    "fechaEnvio" => date("Y-m-d H:i:s")
       	);
		//echo json_encode($datos);

        //echo json_encode($for);
        //echo json_encode($subject);
        //echo json_encode($message);
        //echo json_encode($headers);

        //Enviar correo y registrar actividad
        if ($para != null || $de != null || $mensaje != null) {
        //if (mail($for, $subject, $message, $headers)){
			$send = $this->email_model->SendEmail($datos); //Registro general de correo
			$insert['IDDocto'] = $IDDocto;
			$insert['IDCli'] = $IDCli;
			$insert['email'] = $this->tank_auth->get_usermail();
			$insert['enviado'] = 1;
			$insert['comentario'] = "ENVIADO";
        }
   		else{
      		$send = "Error";
      		$insert['IDDocto'] = $IDDocto;
			$insert['IDCli'] = $IDCli;
			$insert['email'] = $this->tank_auth->get_usermail();
        	$insert['enviado'] = 0;
			$insert['comentario'] = "ERROR AL ENVIAR";
        }
   		$this->db->insert('enviopolizashistorial',$insert); //Historial sólo de este apartado
        echo json_encode($send);
    }
//-----------------------------------------------------------
    //Subir Archivos al Cliente y a la Póliza
    function SubirArchivos() {
    	$IDCli = $this->input->post('cl');
    	$IDDocto = $this->input->post('dc');
    	$Doc = $this->input->post('doc');
    	$TypeDoc = $this->input->post('tp');
    	$nameFileSicas = "";
    	$TypeDestinoCDigital = "";
    	$IDValuePK = "";
    	$FolderDestino = "";
    	$desc = "";
    	$type = "";
    	$destiny = "";
    	$reg = "";
    	$resp = "Error";
    	$info = array();
    	$address = array();
    	$result = array();

    	foreach ($_FILES as $key => $value){
        	//Desglosando datos de los archivos
        	$type = $_POST[$key.'select'];
        	$desc = $_POST[$key.'input'];
        	//Asignación del nombre
        	if ($type == 23) {
        		$nameFileSicas	= str_replace(' ','_',strtoupper($desc));
        	}
        	else {
        		$ArchivoDescripcion=$this->db->query('SELECT nombre FROM catalog_tipoImg WHERE idTipoImg='.$type)->result()[0]->nombre;
        		$nameFileSicas	= str_replace(' ','_',$ArchivoDescripcion);
				$nameFileSicas	.= "-".strtoupper($desc);
        	}
			$nameFileSicas	.= "-".date('YmdHi');
			$nameFileSicas	.= ".".strrev(strstr(strrev($value['name']), '.', true));
			$destination	= RUTA_ASSETS.'assets/img/tmp/'.$nameFileSicas;
			//assets/img/tmp/
			//C:/wamp64/www/Capsys/www/V3/assets/img/tmp
			move_uploaded_file($value['tmp_name'], $destination);
    		$ListFilesURL = base_url().'assets/img/tmp/'.$nameFileSicas;
    		//Archivo de prueba enviado el 14/06/2023 tomado de HERRERA2 BUENO2 ALEJANDRO DEMO2
    		//$ListFilesURL = 'https://capsys.com.mx/V3/assets/img/tmp/CARATULA-PRUEBA1-202306140951.PDF';
    		//Información para agregar archivos
        	if($type == 5 || $type == 7 || $type == 11 || $type == 12 || $type == 21 || $type == 22){
				$TypeDestinoCDigital = "CLIENT";
			    $IDValuePK			 = $IDCli;
				$FolderDestino		 = ""; //Carpetas o subcarpetas
        	}
        	else if ($type == 23) {
        		if ($TypeDoc == 1) {
        			$TypeDestinoCDigital = "DOCUMENT";
					$IDValuePK			 = $IDDocto;
					$FolderDestino		 = "";
        		}
        		else if ($TypeDoc == 3) {
        			$TypeDestinoCDigital = "CLIENT";
			    	$IDValuePK			 = $IDCli;
					$FolderDestino		 = "";
        		}
        	}
        	else{
				$TypeDestinoCDigital = "DOCUMENT";
				$IDValuePK			 = $IDDocto;
				$FolderDestino		 = ""; //Carpetas o subcarpetas
        	}
        	//Subir archivos
        	$reg = $this->capsysdre_actividades->CargarDocumento($TypeDestinoCDigital,$IDValuePK,$ListFilesURL,$FolderDestino);
        	//Estatus
        	$resp = "Enviado";
        	
        	//Información de los archivos
    		$arch['IDCli'] = $IDCli;
    		$arch['IDDocto'] = $IDDocto;
    		$arch['documento'] = $Doc;
    		$arch['tipo'] = $type;
    		$arch['descripcion'] = $desc;
    		$arch['comentario'] ='Archivo agregado: '.$nameFileSicas;
    		array_push($info, $arch);
    		//Información enviada
    		$dir['id'] = $IDValuePK;
    		$dir['para'] = $TypeDestinoCDigital;
    		$dir['carpeta'] = $FolderDestino;
    		$dir['link'] = $ListFilesURL;
    		array_push($address, $dir);
    		//Registro de actividad
        	// $insert['IDDocto'] = $IDDocto;
        	// $insert['IDCli'] = $IDCli;
        	// $insert['tipoDocumento'] = $TypeDestinoCDigital;
        	// $insert['archivo'] = $value['name'];
        	// $insert['archivoFinal'] = $nameFileSicas;
        	// $insert['estado'] = $resp;
        	// $insert['desde'] = $this->tank_auth->get_usermail();
        	// $this->db->insert('registro_archivos_subidos_polizas',$insert);
        }
        //Estatus de envío
        $situation['estado'] = $resp;
        //Información enviada
        $data['direccion'] = $address;
        //Documentos a registrar
        $data['documentos'] = $info;
        //Registro de archivos
        $data['registro'] = $reg;
        //Resultado de envío
        $data['resultado'] = $situation;
    	echo json_encode($data);
    }
}