<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class directorio extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->library(array("webservice_sicas_soap","role","libreriav3","ws_sicas","FiltrosDeReportesSicas"));
		$this->load->helper('url');
		$this->load->model("catalogos_model");
		$this->load->model("capsysdre_directorio");
		$this->load->model("clientemodelo");
		$this->load->model('personamodelo');
		$this->load->model('preguntamodel');
		$this->load->model('notificacionmodel');
		$this->load->model('modeloproyecto', 'proyecto');
                $this->load->library('libreriav3');
		$this->emailUser=$this->tank_auth->get_usermail();
		$this->load->model('validar_clp_model');
	}

	function index()
	{	
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {			
				
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			// $this->catalogos_model->get_Vendedor(3,3);
			
			$busquedaDirectorio = "";
			if($this->input->post('page') != null){
				$page = $this->input->post('page');
			}else{
				$page = 0;
			}
			
			if($this->input->post('busquedaDirectorio')){
				$busquedaDirectorio = $this->input->post('busquedaDirectorio');
			}
			
			if(!empty($busquedaDirectorio)){
				
				$data_search = array(
					'busquedaCliente' => $busquedaDirectorio,
					'page'=> $page
				);
					$quitaTipoPersona=-1;
					switch ($this->input->post('tipoPersona') ) {
								case 0:
									$quitaTipoPersona=1;
									break;
									case 1:
									$quitaTipoPersona=0;
									break;
								default:
									$quitaTipoPersona=-1;
									break;
							}		
			
				if(isset($busquedaDirectorio) && $busquedaDirectorio != ""){
					
					$data_result = $this->webservice_sicas_soap->GetDataClienteProspecto($data_search);		
					//print_r($data_result);
					foreach($data_result['cliente'] as $key => $value){
						$test=$value->IDCli;
						$ranking	= $this->db->query('select (if(r.clienteRanking is null,"Bronce",r.clienteRanking)) as ranking from clientelealtadpuntos c left join clienteranking r on c.idClienteRanking=r.idClienteRanking where c.IDCli='.$value->IDCli)->result();
						
						if(count($ranking)==0){
							$data_result['cliente'][$key]->ranking='Bronce';
						} else {
							$data_result['cliente'][$key]->ranking=$ranking[0]->ranking;
						}
if($value->TipoEnt==$quitaTipoPersona){unset($data_result['cliente'][$key]);}
else{
	//-------------------- Inicio Cambios 30/09/2021 Miguel Avila | Tic Consultores
						//valor para los siiniestro activos
						$data_result['cliente'][$key]->SiniestrosActivos=$this->capsysdre_directorio->SiniestrosActivos($value->IDCli);

}
						 
						//-------------------- Fin Cambios 30/09/2021 Miguel Avila | Tic Consultores	
					}
					//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r( $data_result, TRUE));fclose($fp); 	
				}
				/*if($data['user_id']==5){
$fp = fopen('CLIENTESDEVUELTOS.txt', 'a');fwrite($fp, print_r( $data_result, TRUE));fclose($fp); 
}*/
				$data["busquedaDirectorio"] = $this->input->post('busquedaDirectorio');
				$data['data_result']= $data_result;
				$data['page']= $page;
			}
/***
* Proveedores JjHe
***/
			$busquedaProveedores = "";
			if($this->input->post('pageProveedores') != null){
				$pageProveedores = $this->input->post('pageProveedores');
			}else{
				$pageProveedores = 0;
			}

			if($this->input->post('busquedaDirectorio')){
				$busquedaDirectorio = $this->input->post('busquedaDirectorio');
			}
			if(!empty($busquedaDirectorio)){
				$data["busquedaDirectorio"] = $this->input->post('busquedaDirectorio');
				$data["data_result_Proveedores"] = $this->capsysdre_directorio->data_result_Proveedores($busquedaDirectorio, $page);
				$data['page']= $page;
				
			}
			$array['grupos']=1;
		 $data['personas']=$this->personamodelo->clasificacionUsuariosParaEnvios($array);
                 $data['proveedores']=$this->personamodelo->proveedores(null)->result();

				 //--------------------
			//$data["datos_nota"]=$this->capsysdre_directorio->consultaNotaPorAgenteAsignado();
			$data["resalta_nota"]=array_key_exists("cli",$_GET) ? $this->capsysdre_directorio->consultaNotaPorId($_GET["cli"]) : null;
			$nota_agente=array();
			$notas_en_registro=$this->capsysdre_directorio->consultaNotaPorAgenteAsignado();

			if(!empty($notas_en_registro)){
				foreach($notas_en_registro as $datos_notas){

					$nota_agente[$datos_notas->id_cliente]["nombre_cliente"]=$datos_notas->nombre_del_cliente;
					$nota_agente[$datos_notas->id_cliente]["comentarios"][]=array("idNota" => $datos_notas->id_nota_cliente, "contenido" => $datos_notas->comentario, "fecha_creacion" => $datos_notas->fecha_creacion, "fecha_actualizacion" => $datos_notas->fecha_actualizacion);
				}
			}
			$data["datos_nota"]=$nota_agente;
			//-------------------------------------------------------
			//Dennis Castillo [2021-08-03]
			$guiones = $this->preguntamodel->obtenerGuionTelefonico("directorio");
			$array_guion = array();

			if(!empty($guiones)){
				foreach($guiones as $d_g){

					$array_guion[$d_g->idNombre]["nombre"] = $d_g->nombre;
					$array_guion[$d_g->idNombre]["mensaje"][] = array("etiqueta" => $d_g->etiqueta, "texto" => $d_g->mensaje);
				}
			}
			//------------------------
			//$dates = array();
			$birthday = $this->personamodelo->getBirthdayOfMonth(date("n"));

			$data["birthdays"] = $this->getBirthdays(date("n")); //$dates;
			$data["birthDays"] = array_unique(array_map(function($arr){ return date("d", strtotime($arr->fechaNacimiento));}, $birthday));
			$data["area"] = (array) $this->personamodelo->colaboradorarea(1);
			$data["guionTelefonico"] = $array_guion;
			//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($data, TRUE));fclose($fp); 
			//----------------------- //Dennis Castillo [2022-05-19]
			$data["permisos"] = array_reduce($this->personamodelo->getMyPermissions($this->tank_auth->get_idPersona()), function($acc, $curr){

				$acc[$curr->tipoPermiso][] = $curr->value;
				return $acc;
			}, array());
			//-----------------------//Dennis [2022-05-19]
			$data["datos_clientes_nuevos"] = $this->obtenerClientesNuevos($data["permisos"]);
			$data["meses_"] = $this->libreriav3->devolverMeses();
			//------------------------------------
//** echo "<pre>";
//** print_r($data_result['cliente']);
$data['tipoDocumentoDPCAGenerales']='cliente';
#$this->load->view('directorio/principal', $data);
$this->load->view('directorio/principal02', $data);//FUNCIÃ“N INDEX DEL CONTROLADORÂ directotio.php
/*if($this->tank_auth->get_IDVend()==0){$this->load->view('directorio/principal', $data);}
else{redirect(site_url());}*/
   }
		
	}
	
	/*! index */
	
	function registroDetalle(){
		
		if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
		else 
		{
			
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			if(isset($_POST['IDCli'])){$_GET['IDCli']=$_POST['IDCli'];}
			
			$idCliente = $this->input->get('IDCli', TRUE);
			if(isset($idCliente) && $idCliente > 0){
				$ClienteContact 		= $this->webservice_sicas_soap->GetClient_forID($idCliente);
				$datosCliente=$this->clientemodelo->obtenerDatosCliente($idCliente);
				if(count($datosCliente)==0)
				{
					if(!is_object($datosCliente)){$datosCliente = new stdClass;}
					$datosCliente->preferenciaComunicacion="";$datosCliente->horarioComunicacion="";$datosCliente->diaComunicacion="";
				}
				else
				{
					$datosCliente=$datosCliente[0];
				}
				$data["ClienteContact"] = $ClienteContact;
				$data["Direcciones"] = $this->webservice_sicas_soap->GetAddressClient($idCliente);
				$data['Grupo'] 		    = $this->catalogos_model->get_Grupos();
				$data['SubGrupo'] 		= $this->catalogos_model->get_SubGrupos($ClienteContact["cliente"]->IDGrupo);
				$data['formasContacto']=$datosCliente;
			    $data['direccionesContacto']=array();
			  foreach ($data["Direcciones"] as $key => $contacto) 
			   {
					array_push($data['direccionesContacto'], $contacto);
				}	
			
			}else{ 
				redirect('/directorio');
			}
			
			$data["msj"] = '';
			//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r(count($data["Direcciones"]), TRUE));fclose($fp);
			if (array_key_exists("msj", $_GET)){$data["msj"] = $_GET["msj"];}  
             if(isset($_POST['peticionAJAX'])){echo json_encode($data);}
             else{$this->load->view('directorio/registroDetalle2', $data);}
		}
	}/*! registroDetalle */

	function GetPoliza(){
		
		if (!$this->tank_auth->is_logged_in()) {
			
			redirect('/auth/login/');
			
		} else {
					
			
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			
			$idCliente = $this->input->get('IDCli', TRUE);
			$page = $this->input->get('page',TRUE);
			
			if(isset($idCliente) && $idCliente > 0){
				
				$data_poliza = array(
					"page" =>  ( empty($page)? 0 : $page ),
					"idCli" => ( empty($idCliente)? 0 : $idCliente )
				);
				
				$PolizaClient = $this->webservice_sicas_soap->GetClient_forPolicyActive($data_poliza,-1);
				$data["PolizaClient"] = $PolizaClient;

				$documentos = array();
				$array_ramos_documentos = array();

				foreach($PolizaClient["documentos"] as $dd){ //Alojamos las pólizas en un array_contenedor.

					array_push($documentos, $dd);
				}

				foreach($documentos as $datos){

					$array_ramos_documentos[(String)$datos->RamosNombre][]=$datos;
				}

				$data["PolizasGeneradas"] = $array_ramos_documentos;
				//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($array_ramos_documentos, TRUE));fclose($fp);
			}	
			// }else{
				// redirect('/directorio/registroDetalle?idCli=' . $idCliente);
			// }
			//var_dump($data);
			$this->load->view('directorio/GetPoliza2', $data);
		}
	}/*! registroDetalle */

	function updateClient(){
		//echo json_encode($_REQUEST);
		$IdCli     = $_REQUEST["idcli"];
		$Nombre    = $_REQUEST["nombre"];
		$ApellidoP = $_REQUEST["apellidoP"];
		$ApellidoM = $_REQUEST["apellidoM"];
		$FechaNac  = $_REQUEST["fechaNac"];
		$Edad      = $_REQUEST["edad"];
		$Sexo	   = $_REQUEST["sexo"];
		$TipEnt = $_REQUEST["tipoEntidad"];
		$RazonSoc = $_REQUEST["razonSocial"];
		$FechaCons = $_REQUEST["fechaCons"];
		#$Alias     = $_REQUEST["alias"];
		$Ejecutivo = $_REQUEST["ejecutivoc"]; /* */
		$IDCont    = $_REQUEST["idcont"];
		$RFC 	   = $_REQUEST["rfc"];
		$SubGrupo  = $_REQUEST["subgrupo"]; /* */
		$Telefono1 = $_REQUEST["telefono1"];
		$Grupo     = $_REQUEST["grupo"]; /* */
		$Email1    = $_REQUEST["email1"];
		$Contactos = json_decode($_REQUEST["contactos"]);
		$Direcciones = json_decode($_REQUEST["direcciones"]);
		$Expediente = $_REQUEST["Expediente"]; /* JjHe */
		$ClaveTKM = $_REQUEST["ClaveTKM"]; /* JjHe */
		$ObsSalud = "Actualizacion:".date('d-m-Y')." [".$this->tank_auth->get_usermail()."]"; /* JjHe */

		$ctos = array();
		$res = '';

		foreach ($Contactos as $key => $value) 
		{  			
			$Teles =  explode(':', $value->Telefono1);

			$Tel = count($Teles) > 1? 'Telefono1|'.$Teles[1] : 'Telefono1|'.$Teles[0]; 
            
            if($value->IDCont == -1){
                $datos = array(
                    "CatContactos" => array(
                                    "IDCont"       => $value->IDCont,
                                    "Nombre"       => $value->Nombre,
                                    "ApellidoP"    => $value->ApellidoP,
                                    "ApellidoM"    => $value->ApellidoM,
                                    "Abreviacion"  => $value->Alias,
                                    #"Sexo"         => $value->Sexo,
                                    #"FechaNac"     => $value->FechaNac,
                                    #"Edad"	       => $value->Edad,
                                    "EMail1"       => $value->Email1,
                                    "Telefono1"    => $Tel,
                                    #"Nacionalidad" => ''
                                    ),
                    "CatRelCont"  => array(
                                    "IDRel" => $IdCli,
                                    "IDRelCont" => "-1"
                                    ),
                );
                $data = array(
                    'datos'=> $datos,
                    'KeyCode' => 'HCONTACT',
                    "TipoEntidad" => '16',  
                    'IDRelation' => $IdCli);
            }else{
                $datos = array(
                    "CatContactos" => array(
                                    "IDCont"       => $value->IDCont,
                                    "Nombre"       => $value->Nombre,
                                    "ApellidoP"    => $value->ApellidoP,
                                    "ApellidoM"    => $value->ApellidoM,
                                    "Abreviacion"  => $value->Alias,
                                    #"Sexo"         => $value->Sexo,
                                    #"FechaNac"     => $value->FechaNac,
                                    #"Edad"	       => $value->Edad,
                                    "EMail1"       => $value->Email1,
                                    "Telefono1"    => $Tel,
                                    "Calidad" => 'Cliente'
                                    ),
                    "CatClientes"  => array(
                                    "IDCli"     => $IdCli,
                                    ),
                );
                $data = array(
                    'datos'=> $datos,
                    'KeyCode' => 'HDATACONTACT',
                    'TipoEntidad' => '0',
                    'IDRelation' => '0');
            }
            
            // echo '<pre>';
            // print_r($data);
			$res = $this->webservice_sicas_soap->UpdateContacto($data);
		}

		foreach ($Direcciones as $key => $value) 
		{  			

			$Teles =  explode(':', $value->Telefono1);

			$Tel = count($Teles) > 1? 'Telefono1|'.$Teles[1] : 'Telefono1|'.$Teles[0]; 
			$Teles2 =  explode(':', $value->Telefono2);

			$Tel2 = count($Teles2) > 1? 'Telefono2|'.$Teles2[1] : 'Telefono2|'.$Teles2[0]; 

			if($value->IDDir == -1){
				 $datos = array(
                    "CatDirecciones" => array(
                                    "IDDir"       => '-1',
                                    "Calle"       => $value->Calle,
                                    "NOExt"    => $value->NOExt,
                                    "NOInt"    => $value->NOInt,
                                    "CPostal"  => $value->CPostal,
                                    "Colonia"         => $value->Colonia,
                                    "Poblacion"     => $value->Poblacion,
                                    "Ciudad"	       => $value->Ciudad,
                                    "Pais"       => $value->Pais,
                                    "Telefono1"    => $Tel,
                                    "Telefono2" => $Tel2,
                                    ),
                    "CatRelDir"  => array(
                                    "IDRel"     => $IdCli,

                                    ),
                );
				 
	             $data = array(
                    'datos'=> $datos,
                    'KeyCode' => 'HADDRESS',
                    "TipoEntidad" => '15',  
                    'IDRelation' => $IdCli);
			}else{
				 $datos = array(
                    "CatDirecciones" => array(
                                    "IDDir"       => $value->IDDir,
                                    "Calle"       => $value->Calle,
                                    "NOExt"    => $value->NOExt,
                                    "NOInt"    => $value->NOInt,
                                    "CPostal"  => $value->CPostal,
                                    "Colonia"         => $value->Colonia,
                                    "Poblacion"     => $value->Poblacion,
                                    "Ciudad"	       => $value->Ciudad,
                                    "Pais"       => $value->Pais,
                                    "Telefono1"    => $Tel,
                                    "Telefono2" => $Tel2,
                                    ),
                    "CatRelDir"  => array(
                                    "IDRel"     => $IdCli,
                                    ),
                );

	             $data = array(
	                'datos'=> $datos,
	                'KeyCode' => 'HADDRESS',
	                'TipoEntidad' => '0',
	                'IDRelation' => '0');
			}
			 // echo '<pre>';
    //         print_r($data);
			$res = $this->webservice_sicas_soap->UpdateContacto($data);
        }

        $Tels =  explode(':', $Telefono1);
		
		        if($TipEnt == "0"){
        	$RazonSoc = "";
        	$FechaCons = "";
        }

		$datos = array(
			"CatContactos" => array(
				"IDCont"    => $IDCont,
				"TipoEnt" => $TipEnt,
				"RazonSocial" => $RazonSoc,
				"FechaConst" => $FechaCons,
				"Nombre"    => $Nombre,
				"ApellidoP" => $ApellidoP,
				"ApellidoM" => $ApellidoM,
				"FechaNac"  => $FechaNac,
				"Edad" 	    => $Edad,
				"Sexo"      => $Sexo,
				"RFC"       => $RFC,
				"Telefono1" => count($Tels) > 1 ? 'Telefono1|'.$Tels[1] : 'Telefono1|'.$Tels[0],
				"Email1"    => $Email1,
				"Expediente"	=> $Expediente, /* JjHe */
				"ClaveTKM"		=> $ClaveTKM, /* JjHe */
				"ObsSalud"		=> $ObsSalud, /* JjHe */
				),
			"CatClientes"  => array(
				"IDCli"    => $IdCli,
				"IDGrupo"  => '1',
				"IDSGrupo" => '0'
			)
		);
		
         $data = array(
                    'datos'=> $datos,
                    'KeyCode' => 'HDATACONTACT',
                    'TipoEntidad' => '0',
                    'IDRelation' => '0');
		$res = $this->webservice_sicas_soap->UpdateContacto($data);
		$msj = '';
		if ($res->DATAINFO->Sucess[0] == "0"){
			$msj = htmlentities($res->DATAINFO->MsgError);
			redirect('directorio/registroDetalle?IDCli='.$IdCli.'&msj='.$msj);
		} else {
			redirect('directorio/registroDetalle?IDCli='.$IdCli);
		}

		// $client = array('CatClientes' => array({redirect('directorio/registroDetalle?IDCli='.$IdCli);

		// 		'IDCli'=>0

		// 	}),
		// );
	}

	function getValue($data){
		return ($data != null) ? $data : '';
	}

	function BuscarPoliza()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} 
		else
		 {
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
		
			$this->load->view('directorio/buscador', $data);
		}
	}
	function LoadCentroDigital(){
		try{
			
			$idDocto = $_REQUEST["IDDocto"];
			
			$data = array(
				"IDDocto" => $idDocto
			);
			$this->load->library("webservice_sicas_soap");
			
			$data_result = $this->webservice_sicas_soap->GetCDDigital($data);
			
			echo json_encode($data_result);
			
		}catch(Exception $e){
		
		}
	}	

	function getSubGrupos(){

		if($_REQUEST["IDGrupo"] != null){
			$ID = $_REQUEST["IDGrupo"];
			$data['SubGrupo'] = $this->catalogos_model->get_SubGrupos($ID);

			echo json_encode($data['SubGrupo']);
		}
	}
	
	function registroDetalleProveedor(){
		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {

			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			
			$organizacion_id = $this->input->get('IdOrganizacion', TRUE);

			if(isset($organizacion_id) && $organizacion_id > 0){
				
				//$ClienteContact 		= $this->webservice_sicas_soap->GetClient_forID($idCliente);
				//$data["ClienteContact"] = $ClienteContact;
				//$data["Direcciones"] = $this->webservice_sicas_soap->GetAddressClient($idCliente);
				//$data['Grupo'] 		    = $this->catalogos_model->get_Grupos();
				//$data['SubGrupo'] 		= $this->catalogos_model->get_SubGrupos($ClienteContact["cliente"]->IDGrupo);
				$data["detalleProveedor"] = $this->capsysdre_directorio->detalleProveedor($organizacion_id);
				
			} else { 
				redirect('/directorio');
			}

			$data["msj"] = '';
			if (array_key_exists("msj", $_GET))
			{
				$data["msj"] = $_GET["msj"];
			}

			$this->load->view('directorio/registroDetalleProveedor', $data);
		}

	}/*! registroDetalleProveedor */

	//-----------------------------------
	function devuelveInformacionDeContacto(){
		//echo json_encode($_GET["q"]);
		$array_=array();

		if(isset($_POST['IDCli'])){$_GET["q"]=$_POST['IDCli'];}
		//validamos que existe el cliente en la tabla <clientelealtadpuntos>
		$this->validar_clp_model->validarExistenciaEnTabla($_GET['q']);
		//consultar en la base de datos el contacto del cliente, devolver a la vista.
		$consulta=$this->capsysdre_directorio->devuelveFormasDeContactoCliente($_GET["q"]);
		if(!empty($consulta)){$array_["mensaje"]="";} 
		else{$array_["mensaje"]="No se encontró contacto alguno";}
		$array_["contactos"]=$consulta;
		
// Calculo de polizas por Ramo //

		$getUnifications = $this->clientemodelo->getAssociatedClients($_GET["q"]);
		$clientsCondition = array_reduce($getUnifications, function($acc, $curr){
			$acc .= $curr->clientID."|";
			return $acc;
		}, "");

			$sDate 						= date("d/m/Y");
			$IDCli						= !empty($getUnifications) ? trim($clientsCondition, "|") :  $_GET["q"]; //$_GET["q"];
			$wsdata['TypeFormat']		= 'XML';			
			$wsdata['KeyProcess']		= 'REPORT';
			$wsdata['KeyCode']			= 'HWS_DOCTOS';
			$wsdata['Page']				= '1';
			$wsdata['InfoSort']			= 'CatClientes.IDCli';
			$wsdata['ConditionsAdd']	= '
							Cliente Id;2;0;'. $IDCli .';'. $IDCli .';0;-1;DatDocumentos.IDCli 
							! 
							Tipo Documento;0;0;1;1;DatDocumentos.TipoDocto 
							! 
							Id Cliente;5;0;'.$sDate.';0;DatDocumentos.FHasta 
							! 
							Cliente Id;0;0;0;0;0;-1;DatDocumentos.Status
										  ';

			$ramosContact	= $this->webservice_sicas_soap->getDatosSicas($wsdata);
			
			if($ramosContact->TableControl->MaxRecords != 0){
				
				$contLp	= 0;
				$contVi	= 0;
				$contDa	= 0;
				$contFi	= 0;
				$contVe	= 0;
				
				foreach($ramosContact->TableInfo as $poliza){
					switch($poliza->RamosAbreviacion){
						case "Lineas Personales":
						case "Beneficios";$contLp++;break;						
						case "Vida":$contVi++;break;						
						case "Daños":$contDa++;break;						
						case "Fianzas":$contFi++;break;						
						case "Vehiculos":$contVe++;break;
					}
				}

			} else {
				$contLp	= 0;
				$contVi	= 0;
				$contDa	= 0;
				$contFi	= 0;
				$contVe	= 0;
			}
						
		$array_["polizas_ramo"]	= array("Lp"=>$contLp, "Vi"=>$contVi, "Da"=>$contDa, "Ve"=>$contVe, "Fi"=>$contFi);
		$array_["unifiedClients"] = $getUnifications;		
		
		echo json_encode($array_);
	}
	//-----------------------------------
	function llamarCotizacion()
	{
            $direccion=base_url().'actividades/agregar/Cotizacion/VEHICULOS/17/Existente?idCliente='.$_GET['IDCli'].'-0&idCotizaDirectorio=1';
            
			redirect($direccion);
	}
	//----------------------------------
function actualizaInformacionContactoCLP()
{
    $respuesta['success']=1;
    $respuesta['mensaje']='ACTUALIZACION CORRECTA';
    $consulta='select (count(clp.IDCli)) as total from clientelealtadpuntos clp where clp.IDCli='.$_POST['IDCli'];
       $info=$this->db->query($consulta)->result();        
       $fecha='null';
    if($info[0]->total==0)
    {  
     		$ClienteContact 		= $this->webservice_sicas_soap->GetClient_forID($_POST['IDCli']);
      $insert=array();

      if(isset($ClienteContact['cliente']->FechaNac))
      {
        $fecha=Strstr($ClienteContact['cliente']->FechaNac,"T",true);
        $insert['fecha_nacimiento']=$fecha;
      }
             
       $insert['NombreCompleto']=(string)$ClienteContact['cliente']->NombreCompleto;
       $insert['nombreCliente']=(string)$ClienteContact['cliente']->NombreCompleto;
       $insert['Telefono1']=(string)$ClienteContact['cliente']->Telefono1;
       $insert['idContacto']=(int)$ClienteContact['cliente']->IDCont;
       $insert['EMail1']=(string)$ClienteContact['cliente']->EMail1;
       $insert['ApellidoP']=(string)$ClienteContact['cliente']->ApellidoP;
       $insert['ApellidoM']=(string)$ClienteContact['cliente']->ApellidoM;
       $insert['Nombre']=(string)$ClienteContact['cliente']->Nombre;
       $insert['RFC']=(string)$ClienteContact['cliente']->RFC;
       $insert['Sexo']=(int)$ClienteContact['cliente']->Sexo;
       $insert['tipoEntidad']=(string)$ClienteContact['cliente']->TipoEnt_TXT;
       $insert['IDVend']=(int)$ClienteContact['cliente']->FieldInt1;
       $insert['IDCli']=(int)$ClienteContact['cliente']->IDCli;
       $this->clientemodelo->insertarCliente($insert);
      //$fp =fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($fecha, TRUE));fclose($fp);


    }
       $update['preferenciaComunicacion']=$_POST['preferenciaComunicacion'];
       $update['horarioComunicacion']=$_POST['horarioComunicacion'];
       $update['diaComunicacion']=$_POST['diaComunicacion'];
       $this->clientemodelo->actualizarCliente($_POST['IDCli'],$update);


echo json_encode($respuesta);

}	

	//----------------------------------
	function actualizaInformacionDeContacto(){


		$cliente_object=json_decode($_REQUEST["data"]);
		$obj_contacto=$cliente_object->infomacion_contacto;
		//echo json_encode($cliente_object->cliente);
		$array_respuesta=array();

		$array_actualiza=array();
		$array_actualiza["Telefono1"]=$obj_contacto->telefono;
		$array_actualiza["EMail1"]=$obj_contacto->email;
		$array_actualiza["preferenciaComunicacion"]=$obj_contacto->preferencia;
		$array_actualiza["horarioComunicacion"]=$obj_contacto->horario_preferente;
		$array_actualiza["diaComunicacion"]=$obj_contacto->horario_calendar;
		$array_actualiza["RFC"]=$obj_contacto->rfc;

		$resultado=$this->capsysdre_directorio->actualizaInformacionContacto($cliente_object->cliente,$array_actualiza);
		
		if($resultado){
			$array_respuesta["mensaje"]="Registro actualizado. Se recargará la pagina";
			
		} else{
			$array_respuesta["mensaje"]="No se logró actualiza el contacto";
		}

		$array_respuesta["bool"]=$resultado;
		echo json_encode($array_respuesta);
	}
	//------------------------------------
	function generaNotaDelCliente(){

		$json_post=json_decode($_REQUEST["asyn_data"]);

		//Agregar comentario al cliente.
		$nota=array();
		$nota["comentario"]=$json_post->comentario;
		$nota["id_cliente"]=$json_post->cliente;
		$nota["nombre_del_cliente"]=$json_post->nombre_cliente;
		$nota["fecha_creacion"]=date("Y-m-d H:i:s");

		$agregaNota=$this->capsysdre_directorio->generaNotaCliente($nota);
		
		//Proceso de insertar comentario
		if(!empty($json_post->agentes_asignados)){
			foreach($json_post->agentes_asignados as $aa){

				$emailAgente=$this->personamodelo->obtenerEmail($aa);

				$agente_asignado=array();
				$agente_asignado["Id_nota_comentario"]=$agregaNota;
				$agente_asignado["id_agente_asignado"]=$aa;
				$insert=$this->capsysdre_directorio->asignaNotaAAgente($agente_asignado); //Inserta notas asignados a agentes.

				$array_proyecto['nombre']=$json_post->comentario." - ".$json_post->nombre_cliente;//'Nota para '.$json_post->nombre_cliente;
				$array_proyecto["tituloProyecto"]="Notas de directorio"; //'Nota para '.$json_post->nombre_cliente;
        		$array_proyecto['tabla']='notas_asignadas_en_clientes'; //'notas_para_agente_de_clientes';//
        		$array_proyecto['idTabla']=$agregaNota;//$insert;
        		$array_proyecto['identificaProyectoAutomatico']='accionesNota';
				//$array_proyecto["idNota"]=$agregaNota;
        		$array_proyecto['usuario']=$aa; //$this->tank_auth->get_idPersona();
				$insertInProyectos=$this->proyecto->crearProyectoAutomatico($array_proyecto);

				$array=array();
				//Agregar a notificaciones.
				$array_notificacion= new stdClass; //array();
				$array_notificacion->idPersona=$aa;
				$array_notificacion->email=$emailAgente->email;
				$array[0]=$array_notificacion;
				//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($array_notificacion, TRUE));fclose($fp);

				$this->notificacionmodel->add($array, "email", "ENVIADO", "NUEVA_NOTA", "NOTAS", array("evaluacion_id" => $agregaNota));
			}
		}
		
		echo json_encode($agregaNota);
	}
	//------------------------------------
	function consultarNotaDelCliente(){

		$notas=$this->capsysdre_directorio->consultaNotasCliente($_GET["q"]);

		$array['grupos']=1;
		$personas=$this->personamodelo->clasificacionUsuariosParaEnvios($array);

		$resultado=array();
		$agentes=array();

		
		if(!empty($notas)){
			
			$resultado["mensaje"]="";

			foreach($notas as $aa){

				$resultado["datos"][$aa->id_nota_cliente]["idNota"]=$aa->id_nota_cliente;
				$resultado["datos"][$aa->id_nota_cliente]["comentario"]=$aa->comentario;
				$resultado["datos"][$aa->id_nota_cliente]["cliente"]=$aa->id_cliente;
				$resultado["datos"][$aa->id_nota_cliente]["agentes"][$aa->idPersona]=$aa->nombres." (".$aa->email.")";
				//array_push($resultado["datos"][$aa->id_nota_cliente]["agentes"], $aa->id_agente_asignado);
			}

		} else{
			$resultado["mensaje"]="Sin resultados";
		}

		$resultado["personas"]=$personas;
		$resultado["img_agentes"] = base_url()."assets/img/directorio/agentes.png";
		$resultado["img_colaborador"] = base_url()."assets/img/directorio/empleados.png";


		echo json_encode($resultado);
	}
	//------------------------------------
	function removerNotaDelCliente(){

		$delete=$this->capsysdre_directorio->eliminarRegistroDeNota($_GET["q"]);

		echo json_encode($delete);

	}
	//------------------------------------
	function modificaNotaDelCliente(){

		$json_post=json_decode($_REQUEST["asyn_data"]);
		date_default_timezone_set('America/Mexico_City');

		//Actualiza comentario al cliente.
		$nota=array();
		$nota["comentario"]=$json_post->comentario;
		$nota["fecha_actualizacion"]=date("Y-m-d H:i:s");

		$modificaNota=$this->capsysdre_directorio->actualizaNotaCliente($nota, $json_post->cliente);
		//$this->notificacionmodel->replaceDataNotification("NUEVA_NOTA", "NOTAS", $json_post->cliente, array("tipo" => "ACTUALIZACION_NOTA", "check" => 0));

		//Proceso de actualizar comentario
		if(!empty($json_post->agentes_asignados)){
			foreach($json_post->agentes_asignados as $aa){
				
				$validador_agente=$this->capsysdre_directorio->devuelveAgenteEnNota($aa);

				if(empty($validador_agente)){

					$agente_asignado=array();
					$agente_asignado["Id_nota_comentario"]=$json_post->cliente;
					$agente_asignado["id_agente_asignado"]=$aa;

					$insert=$this->capsysdre_directorio->asignaNotaAAgente($agente_asignado);
					$emailAgente=$this->personamodelo->obtenerEmail($aa);

					$array_proyecto['nombre']=$json_post->comentario." - ".$json_post->nombre_cliente;//'Nota para '.$json_post->nombre_cliente;
					$array_proyecto["tituloProyecto"]="Notas de directorio"; //'Nota para '.$json_post->nombre_cliente;
					$array_proyecto['tabla']='notas_asignadas_en_clientes'; //'notas_para_agente_de_clientes';//
					$array_proyecto['idTabla']=$json_post->cliente;//$insert;
					$array_proyecto['identificaProyectoAutomatico']='accionesNota';
					//$array_proyecto["idNota"]=$agregaNota;
					$array_proyecto['usuario']=$aa; //$this->tank_auth->get_idPersona();
					$insertInProyectos=$this->proyecto->crearProyectoAutomatico($array_proyecto);

					$array=array();
					//Agregar a notificaciones.
					$array_notificacion= new stdClass; //array();
					$array_notificacion->idPersona=$aa;
					$array_notificacion->email=$emailAgente->email;
					$array[0]=$array_notificacion;
					
					$this->notificacionmodel->add($array, "email", "ENVIADO", "NUEVA_NOTA", "NOTAS", array("evaluacion_id" => $json_post->cliente));
				} else{

					$this->notificacionmodel->replaceDataNotification("NUEVA_NOTA", "NOTAS", $json_post->cliente, array("tipo" => "ACTUALIZACION_NOTA", "check" => 0));

					$array_proyecto_actualiza["nombre"] = $json_post->comentario." - ".$json_post->nombre_cliente." (Actualizado: ".date("Y-m-d H:i:s").")";

					$this->proyecto->actualizaTareaDeSeguimientoViaNota($array_proyecto_actualiza, $json_post->cliente);//actualizaTareaDeSeguimientoViaNota
				}
			}
		}
		
		echo json_encode($modificaNota);
	}
	//------------------------------------
	function removerAgenteDeLaNota(){

		$delete=$this->capsysdre_directorio->removerAgenteDeNota($_GET["q"],$_GET["r"]);

		echo json_encode($delete);

	}
	//------------------------------------
	function obtenerClientesNuevos($permissions){
		$array_response = ["institucional" => array(), "fianzas" => array(), "merida" => array(), "cancun" => array()];
		$clientesNuevos = $this->clientemodelo->devuelveClientesNuevos(array("esNuevoCliente" => 1, "MONTH(fechaCAptura)" => date("n"), "YEAR(fechaCaptura)" => date("Y")));

		if(!empty($clientesNuevos)){

			foreach($clientesNuevos as $idx => $data){
				
				if(isset($permissions["clienteN"]) && in_array($data->canal, $permissions["clienteN"])){
					$array_response[$data->canal][] = $data;
				}
			}
		}

		return $array_response;
	}
	//------------------------------------
	function obtenerClientesAnteriores(){ //Funcion obsoleta. Dennis Castillo [2022-05-19]

		//llamada a Sicas para obtener los clientes solicitados del canal
		$array_fechas = array(); $clientes = array(); $response = array(); //"bool" => false, "clientesAnteriores" => array(), "mensaje" => "";
		$array_fechas["fechaInicial"] = date("d-m-Y", mktime(0, 0, 0, $_GET["mes_consulta"], 1, date("Y")));
		$array_fechas["fechaFinal"] = date("d-m-Y", mktime(0, 0, 0, $_GET["mes_consulta"] + 1, 0, date("Y")));

		$array_filtro = $this->filtrosdereportessicas->obtenerFiltro("fianzas", 1, 3);
		$filtro = array_merge($array_fechas, $array_filtro);
		$sicas_response = $_GET["canal_"] !== "FIANZAS" ? $this->ws_sicas->polizas_emitidas_asesores($array_fechas) : $this->ws_sicas->produccionFianzas($filtro);
		//$sicas_response = $this->ws_sicas->recibosClientes($filtro);

		if(!is_bool($sicas_response) && property_exists($sicas_response, "TableInfo")){

			$response["bool"] = true;
			$response["mensaje"] = "Consulta realizado con éxito";

			foreach($sicas_response->TableInfo as $c_d){

				//if((Int)$c_d->Renovacion == 0){

					if($_GET["canal_"] !== "FIANZAS" && (String)$c_d->GerenciaNombre == $_GET["canal_"]){
						$clientes[(Int)$c_d->IDCli] = array("NombreCompleto" => (String)$c_d->NombreCompleto);
					}
	
					if($_GET["canal_"] == "FIANZAS"){
						$clientes[(Int)$c_d->IDCli] = array("NombreCompleto" => (String)$c_d->NombreCompleto);
					}
				//}
			}
		} else{
			$response["bool"] = false;
			$response["mensaje"] = "Ocurrio un error al cargar la información. Favor de contactar al departamento de sistemas.";
		}

		/*if(array_key_exists("TableInfo", $sicas_response) || $sicas_response != false){ //obtenerDatosCliente para el modelo
			
			$response["bool"] = true;
			$response["mensaje"] = "Consulta realizado con éxito";

			foreach($sicas_response->TableInfo as $c_d){

				if((Int)$c_d->Periodo == 1 && (Int)$c_d->RenovacionDocto == 0){
					$clientes[(Int)$c_d->IDCli] = array("NombreCompleto" => (String)$c_d->NombreCompleto);
				}
			}

		} else{
			$response["bool"] = false;
			$response["mensaje"] = "Ocurrio un error al cargar la información. Favor de contactar al departamento de sistemas.";
		}*/

		$response["clientesAnteriores"] = $clientes;
	
		echo json_encode($response);
	}
	//------------------------------------
	///metodo para obtener los siniestros para la tabla | Miguel Avila | Tic Consultores
	function getSiniestros(){
		$idCliente=$this->input->get('id');
		$data=$this->capsysdre_directorio->InfoSiniestrosActivos($idCliente);
		echo json_encode($data);
		/* header('Content-Type: application/json');
        echo json_encode(array('code' => 200, 'message' => "Éxito", 'data' => $data), JSON_NUMERIC_CHECK);
        die; */
	}
	function GetFianza(){
		
		if (!$this->tank_auth->is_logged_in()) {
			
			redirect('/auth/login/');
			
		} else {
					
			
			$data['user_id']	= $this->tank_auth->get_user_id();
			$data['username']	= $this->tank_auth->get_username();
			
			$idCliente = $this->input->get('IDCli', TRUE);
			$page = $this->input->get('page',TRUE);
			
			if(isset($idCliente) && $idCliente > 0){
				
				$data_poliza = array(
					"page" =>  ( empty($page)? 0 : $page ),
					"idCli" => ( empty($idCliente)? 0 : $idCliente )
				);
				
			//**	$PolizaClient = $this->webservice_sicas_soap->GetClient_forFianceActive($data_poliza);
				//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($PolizaClient, TRUE));fclose($fp);
				$data["PolizaClient"] = $PolizaClient;

				$documentos = array();
				$array_ramos_documentos = array();

				foreach($PolizaClient["documentos"] as $dd){ //Alojamos las pólizas en un array_contenedor.

					array_push($documentos, $dd);
				}

				foreach($documentos as $datos){

					$array_ramos_documentos[(String)$datos->RamosNombre][]=$datos;
				}

				$data["PolizasGeneradas"] = $array_ramos_documentos;
				//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($array_ramos_documentos, TRUE));fclose($fp);
			}	
			// }else{
				// redirect('/directorio/registroDetalle?idCli=' . $idCliente);
			// }
			//var_dump($data);
			$this->load->view('directorio/GetFianzas', $data);
		}
	}/*! GetFianza */
	
	function llamarFianzas()
	{
            $direccion=base_url().'fianzas/agregar/?idCliente='.$_GET['IDCli'];
            //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($this->uri->segment, TRUE));fclose($fp);
			redirect($direccion);
	}/*! llamarFianzas */
	//--------------------------
	function getBirthdays($month){
		$dates = array();
		$birthday = $this->personamodelo->getBirthdayOfMonth($month);

		foreach($birthday as $d_b){

			$colaboradorArea = $d_b->idColaboradorArea;

			if($d_b->tipoPersona == 1){
				$d_b->employment = array_reduce($this->personamodelo->puestoDePersona($d_b->idPersona), function($acc, $curr){ $acc = $curr->personaPuesto; return $acc; }, "");

				$area_ = array_filter($this->personamodelo->colaboradorarea(1), function($arr) use($colaboradorArea){ 
					return $arr->idColaboradorArea == $colaboradorArea;
				});

				$d_b->area = array_reduce($area_, function($acc, $curr){ return $acc = $curr->colaboradorArea; }, "");
			} else{
				$d_b->employment = $d_b->idpersonarankingagente;
				$d_b->area = "Comercial";
			}

			if(date("W", strtotime($d_b->fechaNacimiento)) < date("W")){
				$dates[0]["typeOfWeek"] = "pasada";
				$dates[0]["persons"][] = $d_b;
			} elseif(date("W", strtotime($d_b->fechaNacimiento)) > date("W")){
				$dates[2]["typeOfWeek"] = "siguiente";
				$dates[2]["persons"][] = $d_b;
			} else {
				$dates[1]["typeOfWeek"] = "actual";
				$dates[1]["persons"][] = $d_b;
			}
		}

		return $dates;
	}
	//------------------------------------
	function getFilterBirthdays(){
		
		$data = $birthday = $this->personamodelo->getBirthdayOfMonth($_GET["a"]); //$this->getBirthdays();
		$days = array_map(function($arr){ return date("d", strtotime($arr->fechaNacimiento)); }, $data);
		sort($days);

		//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r(array_values(array_unique($days)), TRUE));fclose($fp);
		echo json_encode(array("persons" => $data, "days" => array_unique($days)));
	}
	//------------------------------------
	function getMyPersonalData(){

		$person = $_GET["a"];
		$personalData = $this->personamodelo->buscaPersona($person, "SISTEMAS@ASESORESCAPITAL.COM", 1);
		$userData = $this->personamodelo->obtenerDatosUsuarios($person,'email, name_complete');
		$dataEmployment = $this->personamodelo->puestoDePersona($person);
		$dataPhoto = $this->personamodelo->getPersonalPicture($person);
		$colaboradorArea = $personalData->idColaboradorArea;
		$areaPerson = array_filter($this->personamodelo->colaboradorarea(1), function($arr) use($colaboradorArea){ 
			return $arr->idColaboradorArea == $colaboradorArea;
		});

		//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($areaPerson, TRUE));fclose($fp);
		$dataResponse = array();
		$dataResponse["name"] = $personalData->nombres." ".$personalData->apellidoPaterno." ".$personalData->apellidoMaterno;
		$dataResponse["email"] = $userData->email;
		$dataResponse["phone"] = $personalData->celPersonal;
		$dataResponse["personalEmail"] = $personalData->emailPersonal;
		$dataResponse["birthday"] = $personalData->fechaNacimiento;
		$dataResponse["photo"] = $dataPhoto->fotoUser;
		$dataResponse["typePerson"] = $personalData->tipoPersona;

		if($personalData->tipoPersona == 1){
			$dataResponse["employment"] = $dataEmployment[0]->personaPuesto;
			$dataResponse["area"] = array_reduce($areaPerson, function($acc, $curr){ return $acc = $curr->colaboradorArea; }, "");
		} else{
			$dataResponse["employment"] = $personalData->idpersonarankingagente;
			$dataResponse["area"] = "Comercial";
		}

		echo json_encode($dataResponse);
	}
	//----------------------------------- //Dennis Castillo [2022-05-19]
	function getNewClients(){
		
		try{

			$dateI = new DateTime($_GET["fechaInicial"]);
			$dateF = new DateTime($_GET["fechaFinal"]);
			$dateF = $dateF->modify(" + 1 day");
			$arrDateI = explode("-", $_GET["fechaInicial"]);
			$arrDateF = explode("-", $_GET["fechaFinal"]);

			if(strtotime($_GET["fechaFinal"]) < strtotime($_GET["fechaInicial"])){
				throw new Exception('La fecha final no puede ser menor al inicial');
			}

			$filters = $this->filtrosdereportessicas->obtenerFiltro(strtolower($_GET["canal_"]), 1, 3);
			$filters["fechaInicial"] = $dateI->format("d/m/Y");
			$filters["fechaFinal"] = $dateF->format("d/m/Y");
			$filters["filtroStatus"] = [];
			$sicasQuery = $_GET["canal_"] == "FIANZAS" ? $this->ws_sicas->polizasEmitidasDeClientesFianzas($filters) : $this->ws_sicas->polizasEmitidasDeClientes($filters);
      		$newArray = array();

			if(!is_bool($sicasQuery) && property_exists($sicasQuery, "TableInfo")){

				foreach($sicasQuery as $data){

					if($_GET["canal_"] == "FIANZAS"){
          
						$clientData = $this->ws_sicas->obtenerClientePorID((Int)$data->IDCli);
						$data->FechaCap = !is_bool($clientData) && property_exists($clientData, "TableInfo") ? (String)$clientData->TableInfo->FechaCap : "Sin fecha de captura";
					}

					$newArray[(Int)$data->IDCli]["nombreCliente"] = (String)$data->NombreCompleto;
					$newArray[(Int)$data->IDCli]["IDCli"] = (String)$data->IDCli;
					$newArray[(Int)$data->IDCli]["despacho"] = (String)$data->DespNombre;
					$newArray[(Int)$data->IDCli]["gerencia"] = (String)$data->GerenciaNombre;
					$newArray[(Int)$data->IDCli]["canal"] = strtolower($_GET["canal_"]);
					$newArray[(Int)$data->IDCli]["subGroup"] = (String)$data->SubGrupo;
					$newArray[(Int)$data->IDCli]["fechaCaptura"] = date("d-m-Y", strtotime((String)$data->FechaCap));
					$newArray[(Int)$data->IDCli]["papers"][] = array(
						"IDDocto" => (Int)$data->IDDocto, 
						"emissionDate" => date("Y-m-d", strtotime((String)$data->FEmision)), 
						"catchDate" => date("Y-m-d", strtotime((String)$data->FCaptura)),
						"status" => (Int)$data->Status,
					  );
				}
			}

			$viewFilter = array_filter(array_values($newArray), function($arr){
	
				$trueDate = array();
				if($arr["subGroup"] == "DXN CHIAPAS"){
	
					$clientCatchDate = explode("-", $arr["fechaCaptura"]);
					$catchDate = explode("-", $arr["papers"][0]["catchDate"]);
					$trueDate[] = $catchDate[0] >= $clientCatchDate[0] && $catchDate[1] >= $clientCatchDate[1]; //strtotime($arr["papers"][0]["emissionDate"]) >= strtotime($arr["clientCatchDate"]); //true;
				}
	
				return !in_array(false, $trueDate);
			});

			echo json_encode(array("status" => "success", "code" => 200, "data" => $viewFilter));

		} catch(Exception $e){
			echo "Excepción capturada: ", $e->getMessage();
		}
	}
	//----------------------------------- //Dennis Castillo [2022-05-19]
	function newClientsSicas(){
	
		$institucional = $this->filtrosdereportessicas->obtenerFiltro("institucional", 1, 3);
		$institucional["filtroStatus"] = [];
		//$clients = $this->ws_sicas->obtenerClientesPorFecha(array("fechaInicial" => "01/02/2022", "fechaFinal" => "28/02/2022"));
		$sicasQuery = $this->ws_sicas->polizasEmitidasDeClientes(array_merge($institucional, array("fechaInicial" => "01/05/2022", "fechaFinal" => "31/05/2022")));
		$sicasQueryFiances = $this->ws_sicas->polizasEmitidasDeClientesFianzas(array_merge($institucional, array("fechaInicial" => "01/05/2022", "fechaFinal" => "31/05/2022")));
		$newArray = array();
		$newFiancesArray = array();
		$papers = array();

		/*foreach($sicasQueryFiances->TableInfo as $data){

			$newFiancesArray[(Int)$data->IDCli]["name"] = (String)$data->NombreCompleto;
			$newFiancesArray[(Int)$data->IDCli]["IDCli"] = (String)$data->IDCli;
		}*/

		if(!empty($sicasQuery)){

			foreach($sicasQuery->TableInfo as $data){
			
				$newArray[(Int)$data->IDCli]["name"] = (String)$data->NombreCompleto;
				$newArray[(Int)$data->IDCli]["IDCli"] = (String)$data->IDCli;
				$newArray[(Int)$data->IDCli]["clientCatchDate"] = date("Y-m-d", strtotime((String)$data->FechaCap));
				$newArray[(Int)$data->IDCli]["subGroup"] = (String)$data->SubGrupo;
				$newArray[(Int)$data->IDCli]["papers"][] = array(
					"IDDocto" => (Int)$data->IDDocto, 
					"emissionDate" => date("Y-m-d", strtotime((String)$data->FEmision)), 
					"catchDate" => date("Y-m-d", strtotime((String)$data->FCaptura)),
					"status" => (Int)$data->Status,
				);
			}
		}

		$viewFilter = array_filter(array_values($newArray), function($arr){
	
			$trueDate = array();
			if($arr["subGroup"] == "DXN CHIAPAS"){

				$clientCatchDate = explode("-", $arr["clientCatchDate"]);
				$catchDate = explode("-", $arr["papers"][0]["catchDate"]);
				$trueDate[] = $catchDate[0] >= $clientCatchDate[0] && $catchDate[1] >= $clientCatchDate[1]; //strtotime($arr["papers"][0]["emissionDate"]) >= strtotime($arr["clientCatchDate"]); //true;
			}

			return !in_array(false, $trueDate);
		});
		
	
		var_dump("merida");
		var_dump($viewFilter);
	}
	//-----------------------------------
	
function actualizaInformacionClienteSicas()
{
	$respuesta['success']=true;
	
    #$datos['IDCont']=$_POST['IDCont'];
     (isset($_POST['nombreDCGATC']))? $datos['Nombre']=$_POST['nombreDCGATC'] : '';
     (isset($_POST['apellidoPaternoDCGATC']))? $datos['ApellidoP']=$_POST['apellidoPaternoDCGATC'] : '';
     (isset($_POST['apellidoMaternoDCGATC']))? $datos['ApellidoM']=$_POST['apellidoMaternoDCGATC'] : '';
     (isset($_POST['rfcDCGATC']))? $datos['RFC']=$_POST['rfcDCGATC'] : '';
     (isset($_POST['correoDCGATC']))? $datos['Email1']=$_POST['correoDCGATC'] : '';
     (isset($_POST['razonsocialDCGATC']))? $datos['RazonSocial']=$_POST['razonsocialDCGATC'] : '';
     (isset($_POST['sexoDCGATC']))? $datos['Sexo']=$_POST['sexoDCGATC'] : '';
     
    if(isset($_POST['celularDCGATC']))
    {
      $Tels	= explode(':', $_POST['celularDCGATC']);
      $datos['Telefono1']=count($Tels) > 1 ? 'Telefono1|'.$Tels[1] : 'Telefono1|'.$Tels[0];
    }
   if(isset($_POST['fechaNacimientoDCGATC']))
   {
     $datos['FechaConst']=$_POST['fechaNacimientoDCGATC'];
     $datos['fechaNacimiento']=$_POST['fechaNacimientoDCGATC'];
   }     
     
     (isset($_POST['entidadDCGATC']))? $datos['TipoEnt']=$_POST['entidadDCGATC'] : '';
     (isset($_POST['IDCont']))? $datos['IDCont']=$_POST['IDCont'] : '';
   $oldValue=json_decode($_POST['oldValue']); //trim($_POST['oldValue'],',');
   $oldValueInsert=array();
   
    foreach ($oldValue as $key => $value) 
    {
    	switch ($key) 
    	{
    		case 'nombreDCGATC': $oldValueInsert['Nombre']=$value;break;
    		case 'apellidoPaternoDCGATC': $oldValueInsert['ApellidoP']=$value;break;
    		case 'apellidoMaternoDCGATC': $oldValueInsert['ApellidoM']=$value;break;
    		case 'celularDCGATC': $oldValueInsert['Telefono1']=$value;break;
    		case 'rfcDCGATC': $oldValueInsert['RFC']=$value;break;
            case 'correoDCGATC': $oldValueInsert['Email1']=$value;break;  
            case 'razonsocialDCGATC': $oldValueInsert['RazonSocial']=$value;break;
    	}
    }
    
   unset($_POST['oldValue']);   
   $respuesta['objetos']=$_POST;
   unset($respuesta['objetos']['IDCli']);
   unset($respuesta['objetos']['IDCont']);

     
   /*$newValue=json_encode($respuesta['objetos']);   
   $insert['IDCli']=$_POST['IDCli'];
   $insert['IDCont']=$_POST['IDCont'];
   $insert['emailUser']=$this->tank_auth->get_usermail();
   $insert['oldValue']=$oldValue;
   $insert['newValue']=$newValue;
   $this->db->insert('bitacoraclientesactualizacion',$insert);*/
   $this->clientemodelo->bitacoraclientesactualizacionInsertar($_POST['IDCli'],$_POST['IDCont'],$datos,$oldValueInsert);
$this->ws_sicas->actualizarContactoSicas($datos);


  
	echo json_encode($respuesta);
}
//----------------------------------
function permisosAltaTelefonosCorreos()
{
 $respuesta['success']=true;
 $permisoGuardar=false;
 if($this->tank_auth->get_IDVend()==0){$permisoGuardar=true;}
  $respuesta['permisoGuardar']=$permisoGuardar;
 echo json_encode($respuesta);
	
}

//-> Ventana de consultas ----------------------------------
	function BusquedaPolizas() {
		$search = $this->input->get('search');
		$type = $this->input->get('type');
		$Poliza = "";
		if ($type == 1 || $type == 2 || $type == 7 || $type == 8 || $type == 9) {
			$Poliza = $this->webservice_sicas_soap->GetDocument_forPolicyAndName($search,$type); //,1
		}
		else if ($type == 4) {
			$Poliza = $this->webservice_sicas_soap->BuscarNombre($search,$type); //,1
		}
		else if ($type == 3) {
			$Poliza = $this->webservice_sicas_soap->GetContacto_forContacto($search);
		}
		else if ($type == 5) { //Toda la información del cliente
			$Poliza = $this->webservice_sicas_soap->GetCliente_forGrupo($search);
		}
		else if ($type == 12 || $type == 13) {
			$Poliza = $this->webservice_sicas_soap->GetRecibo_forPlaca($search,$type);
		}

		$result = array(
			'documentos' => $Poliza->TableInfo
		);

		$documentos = array();
		//$ramos_documentos = array();
		foreach($result["documentos"] as $doc){
			array_push($documentos, $doc);
		}
		//Clasificar por Ramo
		/*foreach($documentos as $datos){
			$ramos_documentos[(String)$datos->RamosNombre][]=$datos;
		}
		$dato['PolizasGeneradas'] = $ramos_documentos;*/
		echo json_encode($documentos);
	}
//------------------------------------------------------
	function ResultadoPolizas() {
		$data = $this->input->get('id');
		$clave = $this->input->get('cl');
		$type = $this->input->get('tp');
		$Inf = "";
		if ($type == 1) {
			$Inf = $this->webservice_sicas_soap->GetDocument_forIDDocto($data);
			//$Exp = $this->webservice_sicas_soap->GetExpediente($user);
		}
		else if ($type == 4) {
			$Inf = $this->webservice_sicas_soap->BuscarNombre($data,3);
		}
		$Bit = $this->ws_sicas->informacionDeBitacora($clave);

		$result = array(
			'documentos' => $Inf->TableInfo,
			'bitacora' => $Bit->TableInfo,
			//'expediente' => $Exp->TableInfo
		);
		//$documentos = array();
		$bitacoras = array();
		//foreach ($result['documentos'] as $var) {
		//	array_push($documentos, $var);
		//}
		foreach ($result['bitacora'] as $bt) {
			array_push($bitacoras, $bt);
		}
		$datos['documentos'] = $result['documentos'];
		$datos['bitacoras'] = $bitacoras;
		echo json_encode($datos);
	}
//----------------------------------------------------------
	function TableRecibos() {
		$data = $this->input->get('id');
		$rec = $this->webservice_sicas_soap->GetRecibo($data);
		$recibos = array();
		foreach ($rec['documentos'] as $rc) {
			if ($rc->IDEnd == "-1") { //Recibos activos
				array_push($recibos, $rc);
			}
		}
		echo json_encode($recibos);
	}
function pruebaBusqueda()
{

		
				
				$data_search = array(
					'busquedaCliente' => 'CERVERA CALERO',
					'page'=> 0
				);
				$data_result = $this->webservice_sicas_soap->GetDataClienteProspecto($data_search);	
}



function bettaDirectorio()
{	
	if (!$this->tank_auth->is_logged_in()) {
		redirect('/auth/login/');
	} else {			
			
		$data['user_id']	= $this->tank_auth->get_user_id();
		$data['username']	= $this->tank_auth->get_username();
		// $this->catalogos_model->get_Vendedor(3,3);
		
		$busquedaDirectorio = "";
		if($this->input->post('page') != null){
			$page = $this->input->post('page');
		}else{
			$page = 0;
		}
		
		if($this->input->post('busquedaDirectorio')){
			$busquedaDirectorio = $this->input->post('busquedaDirectorio');
		}
		
		if(!empty($busquedaDirectorio)){
			
			$data_search = array(
				'busquedaCliente' => $busquedaDirectorio,
				'page'=> $page
			);
				$quitaTipoPersona=-1;
				switch ($this->input->post('tipoPersona') ) {
							case 0:
								$quitaTipoPersona=1;
								break;
								case 1:
								$quitaTipoPersona=0;
								break;
							default:
								$quitaTipoPersona=-1;
								break;
						}		
		
			if(isset($busquedaDirectorio) && $busquedaDirectorio != ""){
				
				$data_result = $this->webservice_sicas_soap->GetDataClienteProspecto($data_search);	//DEVUELVE EL RESULTADO DE LA BUSQUEDA	
				// print_r($data_result);

				foreach($data_result['cliente'] as $key => $value){
					$ranking	= $this->db->query('select (if(r.clienteRanking is null,"Bronce",r.clienteRanking)) as ranking from clientelealtadpuntos c left join clienteranking r on c.idClienteRanking=r.idClienteRanking where c.IDCli='.$value->IDCli)->result();
					
					if(count($ranking)==0){
						$data_result['cliente'][$key]->ranking='Bronce';
					} else {
						$data_result['cliente'][$key]->ranking=$ranking[0]->ranking;
					}
					if($value->TipoEnt==$quitaTipoPersona){unset($data_result['cliente'][$key]);}
					else{
			//-------------------- Inicio Cambios 30/09/2021 Miguel Avila | Tic Consultores
					//valor para los siiniestro activos
					$data_result['cliente'][$key]->SiniestrosActivos=$this->capsysdre_directorio->SiniestrosActivos($value->IDCli);

					}
					 
					//-------------------- Fin Cambios 30/09/2021 Miguel Avila | Tic Consultores	
				}
				//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r( $data_result, TRUE));fclose($fp); 	
				
			}
						/*if($data['user_id']==5){
		$fp = fopen('CLIENTESDEVUELTOS.txt', 'a');fwrite($fp, print_r( $data_result, TRUE));fclose($fp); 
		}*/
			$data["busquedaDirectorio"] = $this->input->post('busquedaDirectorio');
			$data['data_result']= $data_result; ///AHI SE OB
			$data['page']= $page;
		}
		/***
		* Proveedores JjHe
		***/
		$busquedaProveedores = "";
		if($this->input->post('pageProveedores') != null){
			$pageProveedores = $this->input->post('pageProveedores');
		}else{
			$pageProveedores = 0;
		}

		if($this->input->post('busquedaDirectorio')){
			$busquedaDirectorio = $this->input->post('busquedaDirectorio');
		}
		if(!empty($busquedaDirectorio)){
			$data["busquedaDirectorio"] = $this->input->post('busquedaDirectorio');
			$data["data_result_Proveedores"] = $this->capsysdre_directorio->data_result_Proveedores($busquedaDirectorio, $page);
			$data['page']= $page;
			
		}
		$array['grupos']=1;
	 $data['personas']=$this->personamodelo->clasificacionUsuariosParaEnvios($array);
			 $data['proveedores']=$this->personamodelo->proveedores(null)->result();

			 //--------------------
		//$data["datos_nota"]=$this->capsysdre_directorio->consultaNotaPorAgenteAsignado();
		$data["resalta_nota"]=array_key_exists("cli",$_GET) ? $this->capsysdre_directorio->consultaNotaPorId($_GET["cli"]) : null;
		$nota_agente=array();
		$notas_en_registro=$this->capsysdre_directorio->consultaNotaPorAgenteAsignado();

		if(!empty($notas_en_registro)){
			foreach($notas_en_registro as $datos_notas){

				$nota_agente[$datos_notas->id_cliente]["nombre_cliente"]=$datos_notas->nombre_del_cliente;
				$nota_agente[$datos_notas->id_cliente]["comentarios"][]=array("idNota" => $datos_notas->id_nota_cliente, "contenido" => $datos_notas->comentario, "fecha_creacion" => $datos_notas->fecha_creacion, "fecha_actualizacion" => $datos_notas->fecha_actualizacion);
			}
		}
		$data["datos_nota"]=$nota_agente;
		//-------------------------------------------------------
		//Dennis Castillo [2021-08-03]
		$guiones = $this->preguntamodel->obtenerGuionTelefonico("directorio");
		$array_guion = array();

		if(!empty($guiones)){
			foreach($guiones as $d_g){

				$array_guion[$d_g->idNombre]["nombre"] = $d_g->nombre;
				$array_guion[$d_g->idNombre]["mensaje"][] = array("etiqueta" => $d_g->etiqueta, "texto" => $d_g->mensaje);
			}
		}
		//------------------------
		//$dates = array();
		$birthday = $this->personamodelo->getBirthdayOfMonth(date("n"));

		$data["birthdays"] = $this->getBirthdays(date("n")); //$dates;
		$data["birthDays"] = array_unique(array_map(function($arr){ return date("d", strtotime($arr->fechaNacimiento));}, $birthday));
		$data["area"] = (array) $this->personamodelo->colaboradorarea(1);
		$data["guionTelefonico"] = $array_guion;
		//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($data, TRUE));fclose($fp); 
		//----------------------- //Dennis Castillo [2022-05-19]
		$data["permisos"] = array_reduce($this->personamodelo->getMyPermissions($this->tank_auth->get_idPersona()), function($acc, $curr){

			$acc[$curr->tipoPermiso][] = $curr->value;
			return $acc;
		}, array());
		//-----------------------//Dennis [2022-05-19]
		$data["datos_clientes_nuevos"] = $this->obtenerClientesNuevos($data["permisos"]);
		$data["meses_"] = $this->libreriav3->devolverMeses();
		//------------------------------------
		//** echo "<pre>";
		//** print_r($data_result['cliente']);
		$data['tipoDocumentoDPCAGenerales']='cliente';
					$this->load->view('directorio/principal02', $data);
				}
	 
}
function GetPolizaBeta(){
		
	if (!$this->tank_auth->is_logged_in()) {
		
		redirect('/auth/login/');
		
	} else {
				
		
		$data['user_id']	= $this->tank_auth->get_user_id();
		$data['username']	= $this->tank_auth->get_username();
		
		$idCliente = $this->input->get('IDCli', TRUE);
		$page = $this->input->get('page',TRUE);
		
		if(isset($idCliente) && $idCliente > 0){
			
			$data_poliza = array(
				"page" =>  ( empty($page)? 0 : $page ),
				"idCli" => ( empty($idCliente)? 0 : $idCliente )
			);
			
			$PolizaClient = $this->webservice_sicas_soap->GetClient_forPolicyActive($data_poliza,1);
			$data["PolizaClient"] = $PolizaClient;

			$documentos = array();
			$array_ramos_documentos = array();

			foreach($PolizaClient["documentos"] as $dd){ //Alojamos las pÃ³lizas en un array_contenedor.

				array_push($documentos, $dd);
			}

			foreach($documentos as $datos){

				$array_ramos_documentos[(String)$datos->RamosNombre][]=$datos;
			}

			$data["PolizasGeneradas"] = $array_ramos_documentos;
			//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($array_ramos_documentos, TRUE));fclose($fp);
		}	
		// }else{
			// redirect('/directorio/registroDetalle?idCli=' . $idCliente);
		// }
		//var_dump($data);
		$this->load->view('directorio/GetPoliza2Beta', $data);
	}
}

function registroDetalleBeta(){
		
	if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
	else 
	{
		
		$data['user_id']	= $this->tank_auth->get_user_id();
		$data['username']	= $this->tank_auth->get_username();
		if(isset($_POST['IDCli'])){$_GET['IDCli']=$_POST['IDCli'];}
		
		$idCliente = $this->input->get('IDCli', TRUE);
		if(isset($idCliente) && $idCliente > 0){
			$ClienteContact 		= $this->webservice_sicas_soap->GetClient_forID($idCliente);
			//var_dump($ClienteContact);
			$datosCliente=$this->clientemodelo->obtenerDatosCliente($idCliente);
			if(count($datosCliente)==0)
			{
				if(!is_object($datosCliente)){$datosCliente = new stdClass;}
				$datosCliente->preferenciaComunicacion="";$datosCliente->horarioComunicacion="";$datosCliente->diaComunicacion="";
			}
			else
			{
				$datosCliente=$datosCliente[0];
			}
			$data["ClienteContact"] = $ClienteContact;
			$data["Direcciones"] = $this->webservice_sicas_soap->GetAddressClient($idCliente);
			$data['Grupo'] 		    = $this->catalogos_model->get_Grupos();
			$data['SubGrupo'] 		= $this->catalogos_model->get_SubGrupos($ClienteContact["cliente"]->IDGrupo);
			$data['formasContacto']=$datosCliente;
			$data['direccionesContacto']=array();
		  foreach ($data["Direcciones"] as $key => $contacto) 
		   {
				array_push($data['direccionesContacto'], $contacto);
			}	
		
		}else{ 
			redirect('/directorio');
		}
		
		$data["msj"] = '';
		//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r(count($data["Direcciones"]), TRUE));fclose($fp);
		if (array_key_exists("msj", $_GET)){$data["msj"] = $_GET["msj"];}  
		 if(isset($_POST['peticionAJAX'])){echo json_encode($data);}
		 else{$this->load->view('directorio/registroDetalle2Beta', $data);}
	}
}
function GetFianzaBeta(){
		
	if (!$this->tank_auth->is_logged_in()) {
		
		redirect('/auth/login/');
		
	} else {
				
		
		$data['user_id']	= $this->tank_auth->get_user_id();
		$data['username']	= $this->tank_auth->get_username();
		
		$idCliente = $this->input->get('IDCli', TRUE);
		$page = $this->input->get('page',TRUE);
		
		if(isset($idCliente) && $idCliente > 0){
			
			$data_poliza = array(
				"page" =>  ( empty($page)? 0 : $page ),
				"idCli" => ( empty($idCliente)? 0 : $idCliente )
			);
			
		//**	$PolizaClient = $this->webservice_sicas_soap->GetClient_forFianceActive($data_poliza);
			//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($PolizaClient, TRUE));fclose($fp);
			$data["PolizaClient"] = $PolizaClient;

			$documentos = array();
			$array_ramos_documentos = array();

			foreach($PolizaClient["documentos"] as $dd){ //Alojamos las pÃ³lizas en un array_contenedor.

				array_push($documentos, $dd);
			}

			foreach($documentos as $datos){

				$array_ramos_documentos[(String)$datos->RamosNombre][]=$datos;
			}

			$data["PolizasGeneradas"] = $array_ramos_documentos;
			//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($array_ramos_documentos, TRUE));fclose($fp);
		}	
		// }else{
			// redirect('/directorio/registroDetalle?idCli=' . $idCliente);
		// }
		//var_dump($data);
		$this->load->view('directorio/GetFianzasBeta', $data);
	}
}
}

/* End of file inicio.php */
/* Location: ./application/controllers/inicio.php */
