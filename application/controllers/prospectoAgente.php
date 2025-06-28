<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH.'third_party/fpdf/fpdf.php';

class prospectoAgente extends CI_Controller{
	var $citaRegistrada	= 0;
	var $idCliente		= 0;
	var $data			= array(); //"";

	function __construct(){
		
		parent::__construct();
		header('Access-Control-Allow-Origin: *');
	     	$params['id_sicas']		= $this->tank_auth->get_IDUserSICAS(); "get_IDUserSICAS";
			$params['user_sicas'] 	= $this->tank_auth->get_UserSICAS(); "get_UserSICAS";
			$params['pass_sicas'] 	= $this->tank_auth->get_PassSICAS(); "get_PassSICAS";
			$this->load->library('Ws_sicasdre',$params);
			$this->load->library('webservice_sicas_soap');
			$this->load->library('localfileuploader');
			$this->load->library('Ws_sicas');
			$this->load->helper('ckeditor');
			$this->load->model('capsysdre_actividades');
			$this->load->model('fullcalendar_model');
			$this->load->model('PersonaModelo');
			$this->load->model('crmProyecto_Model');
			$this->load->model('email_model');
			$this->load->model('saldo_model');
			$this->load->model("preguntamodel");
			$this->load->library('libreriaV3');
			$this->load->library('excel');			
			$this->load->library(array("webservice_sicas_soap","role"));	
			$this->load->model("catalogos_model");
        	$this->load->model('capitalhumano_model'); //Agregado [Suemy][2024-06-26]
        	$this->load->model('superestrella_model'); //Agregado [Suemy][2024-06-26]
	}

//-------------------------------------------------------------------------------------------------------------------------------

	function index(){
		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			 $sql="SELECT * FROM prospectos_agentes order by fecha desc";
			$data['ListaProspectosAgentes']		= $this->db->query($sql)->result();
			$data["accountsToAssignLeads"] = array_map(function($arr){ return $arr->account; }, $this->crmProyecto_Model->getAssigned());
			if($this->tank_auth->get_View()!= "App"){
				$this->load->view('crmproyecto/prospectosDimension_agentes',$data);
				//$this->load->view('crmproyecto/agregarProspecto',$data);
			} 
			else {$this->load->view('crmproyecto/principalApp',$data);}


		}
	}
//-----------------------------------------------------------
function InsertaDimension_agente(){ 
        
	if (!$this->tank_auth->is_logged_in()) {
		redirect('/auth/login/');
	} else {
		
		 $ApellidoP = $this->Limpia($this->input->post('apellidop_agente'));+
		 $ApellidoM = $this->Limpia($this->input->post('apellidom_agente'));
		 $Nombre = $this->Limpia ($this->input->post('nombre_agente'));
		 $cedula=$this->input->post('cedula_agente');

		 $emailPersonal = strtoupper ($this->input->post('email_agente'));
		 $celPersonal = $this->input->post('celular_agente');
		 $telCasaProspecto = $this->input->post("telefono-casa-agente");

		 $status =$this->input->post('status');
		 $asignado = $this->input->post('asignado');
         $referido = ($this->input->post('referido') != false) ? "Si" : "No";
         $medio = (isset($_POST['medio'])) ? $this->input->post('medio') : "SISTEMA";

         $experiencia = $this->input->post("experiencia"); //"6 meses", "1 año" (cadena)
         $valorCartera= $this->input->post("cartera"); //"menos de 200,000", "entre 200,000 - 500,000" (cadena)

		 //----------
			//Ubicación
			$calle = $this->input->post("calle");
			$cruce = $this->input->post("cruzamiento");
			$numero = $this->input->post("numero");
			$colonia = $this->input->post("colonia");
			$municipio = $this->input->post("municipio");
			$estado = $this->input->post("estado");
			$pais = $this->input->post("pais");
			$postal = $this->input->post("postal");

			$ubicacion_agente = $calle." ".$cruce." ".$numero." ".$colonia." ".$municipio." ".$estado." ".$pais." ".$postal;
		 //----------
		 $coordinacion="";
		 if($asignado=="COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX"){
			  $coordinacion="CBE";
		 }else{
			 $coordinacion="MID";
		 }

		 $observacion=$this->input->post('observacion_agente');
		 $dia=date('d');
		 $mes=date('m');
		 $mes=$this->determinarMes($mes);
		 $anio=date('Y');
		
		 //$sqlInsert_Referencia="INSERT INTO prospectos_agentes(medio,tiene_cedula,prospecto, apellido_paterno, apellido_materno,correo,numero_telefono,ubicacion,dia,mes,anio,coordinacion,asignado,comentarios,status)values('SISTEMA','$cedula','$Nombre','$ApellidoP','$ApellidoM','$emailPersonal','$celPersonal','$ubicacion_agente','$dia','$mes','$anio','$coordinacion','$asignado','$observacion','$status')";
		 $sqlInsert_Referencia="INSERT INTO prospectos_agentes(medio,tiene_cedula,prospecto, apellido_paterno, apellido_materno,correo,numero_telefono,ubicacion,dia,mes,anio,coordinacion,asignado,comentarios,status, estadoRegistro, referido, experiencia, cartera)values('$medio','$cedula','$Nombre','$ApellidoP','$ApellidoM','$emailPersonal','$celPersonal','$ubicacion_agente','$dia','$mes','$anio','$coordinacion','$asignado','$observacion','NO CONTACTADO','activo','$referido', '$experiencia','$valorCartera')";
				  
			$this->db->query($sqlInsert_Referencia);
			$referencia = $this->db->insert_id();

			$insertAddress = $this->crmProyecto_Model->insertaRegistros(array(
				"calle" => $calle, 
				"cruzamiento" => $cruce, 
				"colonia" => $colonia, 
				"numero" => $numero, 
				"municipio" => $municipio, 
				"estado" => $estado, 
				"pais" => $pais, 
				"codigo_postal" => $postal, 
				"idProspecto" => $referencia
			 ), "direccion_prospecto_agente");

			 $insertProgress = $this->crmProyecto_Model->insertaRegistros(array(
				"idProspecto" => $referencia,
			 ), "prospective_to_user");
				
				redirect('/prospectoAgente');
				
			

	}
	
}
//-----------------------------------------------------------
function Limpia($cadena)
	{
       $lista= str_replace("Ñ", "N", $cadena);
       $lista1= str_replace("ñ", "n", $lista);
       $lista2= str_replace("á", "a", $lista1);
       $lista3= str_replace("é", "e", $lista2);
       $lista4= str_replace("í", "i", $lista3);
       $lista5= str_replace("ó", "o", $lista4);
       $lista6= str_replace("ú", "u", $lista5);
       $lista7= str_replace("Á", "A", $lista6);
       $lista8= str_replace("É", "E", $lista7);
       $lista9= str_replace("Í", "I", $lista8);
       $lista0= str_replace("Ó", "O", $lista9);
       $listafin= str_replace("Ú", "U", $lista0);
       $listafin2= strtoupper($listafin);

       return $listafin2;
    }
//-----------------------------------------------------------
function determinarMes($m){
    $mes='';
    switch ($m){
        case 1:$mes='ENE';break;
        case 2:$mes='FEB';break;
        case 3:$mes='MAR';break;
        case 4:$mes='ABR';break;
        case 5:$mes='MAY';break;
        case 6:$mes='JUN';break;
        case 7:$mes='JUL';break;
        case 8:$mes='AGO';break;
        case 9:$mes='SEP';break;
        case 10:$mes='OCT';break;
        case 11:$mes='NOV';break;
        case 12:$mes='DIC';break;
    }
    return $mes;
}

//-----------------------------------------------------------

	function importProspectivesList(){

		try{
			$forInsert = array();
			$response =   array();
			$file = $_FILES["lista"]["tmp_name"];
			$objExcel = PHPExcel_IOFactory::load($file);
			$sheet = $objExcel->getSheet(0);

			for($i = 2; $i <= $sheet->getHighestRow(); $i++){
				$asignado=$sheet->getCell("K".$i)->getValue();
			$coordinacion="";
					 if($asignado=="COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX"){
						  $coordinacion="CBE";
					 }else{
						 $coordinacion="MID";
					 }
			 $dia=date('d');
			 $mes=date('m');
			 $mes=$this->determinarMes($mes);
			 $anio=date('Y');
				array_push($forInsert, array(
					"medio" => $sheet->getCell("A".$i)->getValue(),
					"apellido_paterno" => $sheet->getCell("B".$i)->getValue(),
					"apellido_materno" => $sheet->getCell("C".$i)->getValue(),
					"prospecto" => $sheet->getCell("D".$i)->getValue(),
					"numero_telefono" => $sheet->getCell("E".$i)->getValue(),
					"correo" => $sheet->getCell("F".$i)->getValue(),
					"ubicacion" => $sheet->getCell("G".$i)->getValue(),
					"cartera" => $sheet->getCell("H".$i)->getValue(),
					"experiencia" => $sheet->getCell("I".$i)->getValue(),
					"comentarios" => $sheet->getCell("J".$i)->getValue(),
					"asignado" => $sheet->getCell("K".$i)->getValue(),
					"referido" => $sheet->getCell("L".$i)->getValue(),
					"tiene_cedula" => $sheet->getCell("M".$i)->getValue(),
					"dia" => $dia,
					"mes" => $mes,
					"anio" => $anio,
					"coordinacion" => $coordinacion,
					"status" => "NO CONTACTADO",
					"estadoRegistro" => "activo",
				));
			}
			
			$this->db->trans_begin();
			$this->db->insert_batch("prospectos_agentes", $forInsert);

			if($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				$response = array("code" => 501, "status" => "failed", "message" => "Ocurrió un error en la carga de registros. Favor de contactar al depto de sistemas");
			} else{
				$this->db->trans_commit();
				$response = array("code" => 200, "status" => "success", "message" => "Importación de registros realizado con éxito", "data" => array("count" => count($forInsert)));
			}

			echo json_encode($response);
		} catch(Exception $e){
			echo "Excepción capturada: ".$e->getMessage(); 
		}
	}
//-----------------------------------------------------------
	function agenteContactado(){
		$IDAgent=$this->input->post('idAgentStatus');
		$tipoContacto=$this->input->post('tipoContacto');
		if($this->input->post('selectRespuesta')=="SI"){
    	$sql="Update `prospectos_agentes` set `status` = 'CONTACTADO', `comentarioStatus`= 'Hubo exito de contacto en ".$tipoContacto."' where `id`='".$IDAgent."'";
    	$this->db->query($sql);
    	redirect('/prospectoAgente');
		}else{
    	$sql="Update `prospectos_agentes` set `status` = 'NO CONTACTADO', `comentarioStatus`= 'Sin exito de contacto en ".$tipoContacto."' where `id`='".$IDAgent."'";
    	$this->db->query($sql);
    	redirect('/prospectoAgente');
		}
	
}

//------------
	function asignaStatus(){

		
		$id			= $this->input->get_post('id', TRUE);
		$status	= $this->input->get_post('status', TRUE);
				
		$sqlUpdate = "
			Update
				`prospectos_agentes`
			Set
				`status`	= '".$status."'
			Where
				`id` = '".$id."'
					 ";
		$this->db->query($sqlUpdate);
		$data['id'] = $id;
		$data['status'] = $status;
		echo json_encode($data);
	}
	
//-----------------------------------------------------------
	function agendarCita(){
	$IDAgent=$this->input->post("idAgent");
	$fecha=$this->input->post("fechaCita");
	$horario="De: ".$this->input->post("selectFechaDeCC");
	$horario= $horario." A: ".$this->input->post("selectFechaACC");
    $sql="Update `prospectos_agentes` set `status` = 'PROGRAMADO PARA CITA',`fechaCita` = '".$fecha."' , `horarioCita` = '".$horario."', `comentarioStatus`= 'Cita programada el ".$fecha." ".$horario."'  where `id`='".$IDAgent."'";
    $this->db->query($sql);
    redirect('/prospectoAgente');
}

//-----------------------------------------------------------
	function eliminarLead(){
	$IDAgent=$this->input->post("idAgent");
    $sql="delete from `prospectos_agentes` where `id`='".$IDAgent."'";
    $this->db->query($sql);
    redirect('/prospectoAgente');
}

//-----------------------------------------------------------
function insertarLead()
{
	
	$respuesta['success']=false;
	$respuesta['camposErrores']=array();
	$numeroVehiculos=0;
	
    if(isset($_POST['edad'])){if(!filter_var($_POST["edad"], FILTER_VALIDATE_INT)){array_push($respuesta['camposErrores'],'edad');}}
	if(isset($_POST['numeroVehiculos']))
	{if(!filter_var($_POST["numeroVehiculos"], FILTER_VALIDATE_INT)){array_push($respuesta['numeroVehiculos'],'numeroVehiculos');}else{$numeroVehiculos=$_POST["numeroVehiculos"];}}
	
	if(!filter_var($_POST["correo"], FILTER_VALIDATE_EMAIL)){array_push($respuesta['camposErrores'],'correo');}

	if(isset($_POST['telefono'])){if(!ctype_digit(trim($_POST['telefono']))){array_push($respuesta['camposErrores'],'telefono');}}
	
	if($this->input->post('mensaje')==''){array_push($respuesta['camposErrores'],'mensaje');}
	if($this->input->post('nombre')==''){array_push($respuesta['camposErrores'],'nombre');}
	
	if(count($respuesta['camposErrores'])==0)
	{
		$nombre=$this->input->post('nombre');
		$telefono=$this->input->post('telefono');
		$correo=$this->input->post('correo');
		$tipo=$this->input->post('tipo');
		$mensaje=$this->input->post('mensaje');
		$fecha=date('Y-m-d h:m:i');
		$cp=$this->input->post('cp');
		$edad=$this->input->post('edad');
		$leads=$this->input->post('leads');
		
		

		$sql="INSERT INTO clientes_actualiza(actualiza,Nombre,EMail1,Telefono1,Usuario,EstadoActual,FuenteProspecto, callcenter,CP,edad,fechaCreacionCA,observacion,tipo_documento,tipo_prospecto,leads,numeroVehiculos) VALUES ('clienteWeb', '$nombre', '$correo', '$telefono','marketing@agentecapital.com','SIN VENTA', 'ZAPIER',NULL,'$cp','$edad','$fecha','$mensaje','$tipo',3,'$leads','$numeroVehiculos')";
		$query=$this->db->query($sql);
		/*if($query->num_rows() > 0){$row = $query->row();} 
		else {$row = "";}*/
		$respuesta['success']=true;	
     
	}
	
	echo json_encode($respuesta);

}
//-----------------------------------------------------------

function insertarAgentesLeads()
{
	$respuesta['success']=false;
	$respuesta['camposErrores']=array();
	$numeroVehiculos=0;		
    $Nombre = $this->Limpia ($this->input->post('nombre_agente'));
	$emailPersonal = strtoupper ($this->input->post('email_agente'));
	$celPersonal = $this->input->post('celular_agente');
	$observacion=$this->input->post('observacion_agente');

	if($Nombre==''){array_push($respuesta['camposErrores'],'nombre_agente');}
	if(!filter_var($emailPersonal, FILTER_VALIDATE_EMAIL)){array_push($respuesta['camposErrores'],'email_agente');}
	if(!ctype_digit(trim($celPersonal))){array_push($respuesta['camposErrores'],'celular_agente');}
	if($observacion==''){array_push($respuesta['camposErrores'],'observacion_agente');}

	if(count($respuesta['camposErrores'])==0)
	{
		$ApellidoP = $this->Limpia($this->input->post('apellidop_agente'));
		$ApellidoM = $this->Limpia($this->input->post('apellidom_agente'));
		
		$cedula=$this->input->post('cedula_agente');
		$telCasaProspecto = $this->input->post("telefono-casa-agente");

		$status =$this->input->post('status');
		$asignado = $this->input->post('asignado');
		$referido = ($this->input->post('referido') != false) ? "Si" : "No";
		$medio = (isset($_POST['medio'])) ? $this->input->post('medio') : "SISTEMA";

		$experiencia = $this->input->post("experiencia"); //"6 meses", "1 año" (cadena)
		$valorCartera= $this->input->post("cartera"); //"menos de 200,000", "entre 200,000 - 500,000" (cadena)

		   $calle = $this->input->post("calle");
		   $cruce = $this->input->post("cruzamiento");
		   $numero = $this->input->post("numero");
		   $colonia = $this->input->post("colonia");
		   $municipio = $this->input->post("municipio");
		   $estado = $this->input->post("estado");
		   $pais = $this->input->post("pais");
		   $postal = $this->input->post("postal");

		   $ubicacion_agente = $calle." ".$cruce." ".$numero." ".$colonia." ".$municipio." ".$estado." ".$pais." ".$postal;

		$coordinacion="";
		if($asignado=="COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX"){$coordinacion="CBE";}
		else{$coordinacion="MID";}


		$dia=date('d');
		$mes=date('m');
		$mes=$this->determinarMes($mes);
		$anio=date('Y');

		$sqlInsert_Referencia="INSERT INTO prospectos_agentes(medio,tiene_cedula,prospecto, apellido_paterno, apellido_materno,correo,numero_telefono,ubicacion,dia,mes,anio,coordinacion,asignado,comentarios,status, estadoRegistro, referido, experiencia, cartera)values('$medio','$cedula','$Nombre','$ApellidoP','$ApellidoM','$emailPersonal','$celPersonal','$ubicacion_agente','$dia','$mes','$anio','$coordinacion','$asignado','$observacion','NO CONTACTADO','activo','$referido', '$experiencia','$valorCartera')";
				 
		   $this->db->query($sqlInsert_Referencia);
		   $respuesta['success']=true;	
	}	
    echo json_encode($respuesta);

}

//-----------------------------------------------------------
}