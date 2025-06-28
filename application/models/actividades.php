<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Actividades extends CI_Controller{

	var $user	= "GAP#aCap%2015";		
	var $pass	= "CAP15gap20Ag";	
	var $auth	= "vsDMquPhx68SZrY8wGcxEh2bk1XiPlR0EZkBVLmax3A4Mab7sDeeyodY3BjDuyB";
	
	var $key	= "%SOnlineBOGO2001-2015WS#";
	var $ivPass	= "GAP#aCap";	
	
	var 	$DeleteXml = array('<?xml version="1.0" encoding="utf-8"?>','<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">','<DATAINFO> ','<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema"><soap:Body>','<ProcesarWSResponse xmlns="http://tempuri.org/">','<ProcesarWSResult>','</ProcesarWSResult>','</ProcesarWSResponse>','</soap:Envelope>','</DATAINFO> ','</soap:Body>','</DATAINFO> ',);
	var $ClearXml = array('','','','','','','','','','','','',);
	
	private $quitarSicas	= array('<p>', '</p>', '<br />', ',');
	private $ponerSicas		= array('', '', '\n\r', '');
	
	function __construct(){
		parent::__construct();
			
			$params['id_sicas']		= $this->tank_auth->get_IDUserSICAS(); "get_IDUserSICAS";
			$params['user_sicas']	= $this->tank_auth->get_UserSICAS(); "get_UserSICAS";
			$params['pass_sicas']	= $this->tank_auth->get_PassSICAS(); "get_PassSICAS";
			$this->load->library('Ws_sicasdre',$params);
			$this->load->library('webservice_sicas_soap',$params);
			$this->load->library('Ws_sicas');
			$this->load->library('WhatsSMS');


			$this->load->helper('ckeditor');
			$this->load->helper('url');
			
			$this->load->model('capsysdre_actividades');
			$this->load->model('personamodelo');
			$this->load->model('catalogos_model');
			$this->load->model("clientemodelo");
			$this->load->model('email_model');
			$this->load->model('saldo_model');
			$this->load->model('procesamientoncmodel');
			$this->load->model('capsysdre_directorio');
	}
//----------------------------------------------------------------------------------------------------------------------------------		
	function index()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {

			//$IDUserSICAS	= $this->tank_auth->get_IDUserSICAS();
			$usermail		= $this->tank_auth->get_usermail();
/*
			$data['configModulos']					= $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());
			$data['ActividadesCerrar']				= $this->capsysdre_actividades->devuelveActCerrar($usermail);
			$data['ActividadesNubeAutos']			= $this->capsysdre_actividades->ActividadesNubeAutos();
			$data['ActividadesNubeLineasPersonales']= $this->capsysdre_actividades->ActividadesNubeLineasPersonales();
			$data['ActividadesNubeDanos']			= $this->capsysdre_actividades->ActividadesNubeDanos();
			$data['ActividadesPendientes']			= $this->capsysdre_actividades->ActividadesPendientes($usermail);
			$data['ActividadesTrabajandose']		= $this->capsysdre_actividades->ActividadesTrabajandose($usermail);
			$data['ActividadesPospuestas']			= $this->capsysdre_actividades->ActividadesPospuestas($usermail);
*/
			
			if($this->tank_auth->get_View()!= "App"){

			/*$data['configModulos']					= $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());
			$data['ActividadesCerrar']				= $this->capsysdre_actividades->devuelveActCerrar($usermail);
			$data['ActividadesNubeAutos']			= $this->capsysdre_actividades->ActividadesNubeAutos();
			$data['ActividadesNubeLineasPersonales']= $this->capsysdre_actividades->ActividadesNubeLineasPersonales();
			$data['ActividadesNubeDanos']			= $this->capsysdre_actividades->ActividadesNubeDanos();
			$data['ActividadesPendientes']			= $this->capsysdre_actividades->ActividadesPendientes($usermail);
			$data['ActividadesTrabajandose']		= $this->capsysdre_actividades->ActividadesTrabajandose($usermail);
			$data['ActividadesPospuestas']			= $this->capsysdre_actividades->ActividadesPospuestas($usermail);*/
             $this->verActividades();
				//$this->load->view('actividades/verActividades',$data);
			} else {			
			 /*
			 $data['configModulos']					= $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());
			 $data['ActividadesPendientes']			= $this->capsysdre_actividades->ActividadesPendientes($usermail);
			 $data['ActividadesTrabajandose']		= $this->capsysdre_actividades->ActividadesTrabajandose($usermail);
			 $data['ActividadesPospuestas']			= $this->capsysdre_actividades->ActividadesPospuestas($usermail);
			 */
			 //** $this->load->view('actividades/principalApp',$data);
			 $this->verActividades();
			}
		}
	}/*! index */

//----------------------------------------------------------------------------------------------------------------------------------
	function actualizarActividadesSubRamo()
	{
		$consulta	= "select IDSRamo,IDRamo,Nombre from catalog_subRamos;";
		$resultado	= $this->db->query($consulta)->result();
    	foreach ($resultado as  $value) {
    		$update	= '
				Update
					actividades 
				Set 
					IDSRamo	= '.$value->IDSRamo.',
					IDRamo	= '.$value->IDRamo.' 
				Where 
					subRamoActividad	= "'.$value->Nombre.'"
					  ';
	    	$this->db->query($update);
    	}
	}/*! actualizarActividadesSubRamo */
	
//----------------------------------------------------------------------------------------------------------------------------------
	function verActividades()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {

			$usermail							= $this->tank_auth->get_usermail();
			$data['ActividadesCerrar']			= $this->capsysdre_actividades->devuelveActCerrar($usermail);			
			$datos								= $this->capsysdre_actividades->ActividadesTrabajandoseOperativos($usermail);
			$data['actividadesNoTrabajandose']	= $this->capsysdre_actividades->actividadesNoTrabajandose(null);
			$data['ActividadesTrabajandose']	= $datos['actividades'];//$this->capsysdre_actividades->ActividadesTrabajandoseOperativos($usermail);
			$data['ramos']						= $datos['ramos'];
			$data['totalesPorRamo']				= $datos['totalesPorRamo'];
			$data['personaTrabajaActividad']	= $datos['personaTrabajaActividad'];
			$data['bandera']					= 1;
			$data['tipoUsuario']				= $this->tank_auth->get_idTipoUser();

			if($this->tank_auth->get_View()!= "App"){
				$this->load->view('actividades/verActividades',$data);
			} else {
				$this->load->view('actividades/verActividadesApp',$data);
			}
		}
	}/*! verActividades */

//----------------------------------------------------------------------------------------------------------------------------------
	function actividadesParaOperativos()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {

				$usermail								= $this->tank_auth->get_usermail();
			
			if($this->tank_auth->get_View()!= "App"){
				//$data['configModulos']					= $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());
				$data['ActividadesCerrar']				= $this->capsysdre_actividades->devuelveActCerrar($usermail);
				$data['ActividadesNubeAutos']			= $this->capsysdre_actividades->ActividadesNubeAutos();
				$data['ActividadesNubeLineasPersonales']= $this->capsysdre_actividades->ActividadesNubeLineasPersonales();
				$data['ActividadesNubeDanos']			= $this->capsysdre_actividades->ActividadesNubeDanos();
				//$data['ActividadesPendientes']			= $this->capsysdre_actividades->ActividadesPendientesOperativo($usermail);
				$data['ActividadesTrabajandose']		= $this->capsysdre_actividades->ActividadesTrabajandoseOperativos($usermail);
				$data['ActividadesPospuestas']			= $this->capsysdre_actividades->ActividadesPospuestas($usermail);
			
				$this->load->view('actividades/verActividadesOperativos',$data);
			
			} else {
			/*
				$data['configModulos']					= $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());
				$data['ActividadesPendientes']			= $this->capsysdre_actividades->ActividadesPendientes($usermail);
				$data['ActividadesTrabajandose']		= $this->capsysdre_actividades->ActividadesTrabajandose($usermail);
				$data['ActividadesPospuestas']			= $this->capsysdre_actividades->ActividadesPospuestas($usermail);
			
				$this->load->view('actividades/principalApp',$data);
			*/
			}
		}
	}/*! actividadesParaOperativos */

//------------------------------------------------------------------------------------------------------------------------------------
	function ConsultaActApp()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {

			//$IDUserSICAS	= $this->tank_auth->get_IDUserSICAS();
			$usermail								= $this->tank_auth->get_usermail();
			$data['configModulos']					= $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());			
			$data['ActividadesNubeAutos']			= $this->capsysdre_actividades->ActividadesNubeAutos();
			$data['ActividadesNubeLineasPersonales']= $this->capsysdre_actividades->ActividadesNubeLineasPersonales();
			$data['ActividadesNubeDanos']			= $this->capsysdre_actividades->ActividadesNubeDanos();			
			$data['ActividadesPendientes']			= $this->capsysdre_actividades->ActividadesPendientes($usermail);
			$data['ActividadesTrabajandose']		= $this->capsysdre_actividades->ActividadesTrabajandose($usermail);
			$data['ActividadesPospuestas']			= $this->capsysdre_actividades->ActividadesPospuestas($usermail);

			$this->load->view('actividades/principalApp',$data);
		}
	}/*! ConsultaActApp */

//------------------------------------------------------------------------------------------------------------------------------------
	function actividadestrae_urgentesPrevio()
	{
		$usermail					= $this->tank_auth->get_usermail();
		$sqlActividadesActualizar	= "Select `NumUrgentes` as valor From `users` Where `email`= '".$usermail."'";
		$query = $this->db->query($sqlActividadesActualizar);
			
		if($query->num_rows() > 0){
			return
				$query->result();
		} else {
			return 
				false;
		}
	}/*! actividadestrae_urgentesPrevio */

//------------------------------------------------------------------------------------------------------------------------------------
	function actividadestrae_urgentes()
	{
		if($this->tank_auth->get_userprofile() == "2" || $this->tank_auth->get_userprofile() == "3" || $this->tank_auth->get_userprofile() == "4"){
			$usermail		= $this->capsysdre->EmailVendedor($this->input->post('IDVend', TRUE)); //si es operativo agarra urgentes del agente seleecionado en la actividad
        } else {
			$usermail		= $this->tank_auth->get_usermail(); //si es vendedor agarra urgentes de su sesion
        }
		
		$sqlActividadesActualizar	= "
			Select 
				`NumUrgentes` as valor 
			From 
				`users` 
			Where
				`email`	= '".$usermail."'
			;
									  ";
		$query						= $this->db->query($sqlActividadesActualizar);
			
		if($query->num_rows() > 0){
			return 
				$query->result();
		} else {
			return 
				false;
		}
	}/*! actividadestrae_urgentes */

//------------------------------------------------------------------------------------------------------------------------------------
	function Decrementa_urgentes()
	{
		if($this->tank_auth->get_userprofile() == "2" || $this->tank_auth->get_userprofile() == "3" || $this->tank_auth->get_userprofile() == "4"){
			$usermail		= $this->capsysdre->EmailVendedor($this->input->post('IDVend', TRUE)); //si es operativo agarra urgentes del agente seleecionado en la actividad 
        } else {
            $usermail		= $this->tank_auth->get_usermail(); //si es vendedor agarra urgentes de su sesion 
		}
         
        if($this->input->post('tipoRamo', TRUE) == 'VEHICULOS'){	//decrementa urgente solo si es vehiculos de orta manera no decrementa
			$sqlActividadesActualizar	= "
				Update 
					`users`
				Set 
					`NumUrgentes`	= NumUrgentes-1 
				Where 
					`email`	= '".$usermail."'
				;
										  ";
			$query						= $this->db->query($sqlActividadesActualizar);
		}
	}/*! Decrementa_urgentes */

//------------------------------------------------------------------------------------------------------------------------------------
	function busqueda()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$folioBuscado			= strtoupper($this->input->post('folioBuscado', TRUE));
			$usuarioCreacion		= $this->input->post('usuarioCreacion', TRUE);
			$userProfile			= $this->tank_auth->get_userprofile();
			$data['busquedaResult']	= $this->capsysdre_actividades->BuscadorActividades($folioBuscado,$usuarioCreacion,$userProfile);
			$data['folioBuscado']	= $folioBuscado;
			
			//** $this->load->view('actividades/busqueda',$data);
			
			if($this->tank_auth->get_View()!= "App"){
				$this->load->view('actividades/busqueda',$data);
			} else {
				$this->load->view('actividades/busquedaApp',$data);
			}
		}
	}/*! busqueda */

//------------------------------------------------------------------------------------------------------------------------------------
	function agregar()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {	
			$arrayPermisos			= $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());	

     if($this->uri->segment(6)=="Nuevo")
     {
	  $data['estados']=$this->catalogos_model->catalog_estados(null);
				$data['giroCatalogo']	= $this->catalogos_model->catalogo_giros(null);	
     }      
	$actividadesPermisos= $this->capsysdre->cotizacionPermisos($this->tank_auth->get_usermail(),$this->tank_auth->get_userprofile());	
			$data['configModulos']		= array('modulo' => 'configuraciones');			
			$data['SelectActividad']	= $this->capsysdre_actividades->SelectActividad($arrayPermisos);			
			$data['SelectRamo']			= $this->capsysdre_actividades->SelectRamo($this->uri->segment(3),$actividadesPermisos);
			$data['SelectSubRamo']		= $this->capsysdre_actividades->SelectSubRamo($this->uri->segment(3),$this->uri->segment(4));
			if($this->uri->segment(3)=='Cotizacion' || $this->uri->segment(3)=="Emision"){
				if($this->uri->segment(5)!='')
 {
					$data['companias']		= $this->capsysdre_actividades->obtenerCompaniasSubRamo($this->uri->segment(5));
					$data['permisos']			= $this->personamodelo->permisosPersona('actividadesAgregar');
					$data['permitirRanking']	= $this->personamodelo->obtenerRankingAgente();		
					if($this->uri->segment(3)=="Emision"){
						$data['pagoFormas']		= $this->capsysdre_actividades->pagoFormas();
					 	$data['pagoConducto']	= $this->capsysdre_actividades->pagoConducto();
					 	$data['pagoFactura']	= $this->capsysdre_actividades->pagoFactura();
					}
				}
			}
			$data['SelectCliente']			= $this->capsysdre_actividades->SelectCliente($this->uri->segment(3),$this->uri->segment(4),$this->uri->segment(5));
			$data['SelectEntidad']			= $this->capsysdre_actividades->SelectEntidad($this->uri->segment(3),$this->uri->segment(4),$this->uri->segment(5),$this->uri->segment(6));
			$data['SelectVendedor']			= $this->capsysdre_actividades->SelectVendedor($this->tank_auth->get_IDVend(),$this->tank_auth->get_IDVendNS(),$this->tank_auth->get_userprofile());

			$data['TextoExpresFormulario']	= $this->capsysdre_actividades->TextoExpresFormulario($this->uri->segment(3),$this->uri->segment(4),$this->uri->segment(5));	
			$data['TextoExpresAsteriscos']	= $this->capsysdre_actividades->TextoExpresAsteriscos($this->uri->segment(3),$this->uri->segment(4),$this->uri->segment(5));
			$data['SelectTipoImg_1']		= $this->capsysdre_actividades->SelectTipoImg('1');
			$data['SelectTipoImg_2']		= $this->capsysdre_actividades->SelectTipoImg('2');
			$data['SelectTipoImg_3']		= $this->capsysdre_actividades->SelectTipoImg('3');
			$data['ckeditor']				= array(
													//ID of the textarea that will be replaced
														'id' 	=> 	'datosExpres',
														'path'	=>	'assets/js/ckeditor',
													//Optionnal values
														'config' => array(
															'width' 	=> 	"99%",		//Setting a custom width
															'height' 	=> 	'100px',	//Setting a custom height
															'toolbar' 	=> 	array(		//Setting a custom toolbar
																					'/'
																				)
															)
											  );

			$busquedaClienteProspecto		= urldecode($this->input->get('busquedaClienteProspecto',TRUE));	
			

			if($busquedaClienteProspecto!=''){
				$data['ListaClienteProspecto']		= $this->capsysdre_actividades->ListaClienteProspecto($busquedaClienteProspecto);
			}
			$idCliente						= $this->input->get('idCliente',TRUE);
			//$idCliente					= '25528-25190';
			$IDCli							= strstr($idCliente, '-', true);
			//$data['informacionCliente']	= $this->capsysdre_actividades->DetalleCliente($IDCli);
		    if($IDCli!=""){
				$data['informacionCliente']	= $this->ws_sicas->obtenerClientePorID($IDCli)->TableInfo;
			}
			if($this->input->get('idCliente', TRUE) == "false"){
				redirect('actividades/agregar/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/Existente?busquedaClienteProspecto=');
			}
			$data['numerodeurgentes']		= $this->actividadestrae_urgentes();

			/*==========================CODIGO LOCM 05/05/2017=====================================*/
			$consulta						= "
				Select
					Count(actividades.idInterno) As cont 
				From 
					actividades 
				Where 
					actividades.Status			= '1'
					And 
					actividades.inicio			= '0' 
					And 
					actividades.usuarioCreacion	= '".$this->tank_auth->get_usermail()."'
											  ";
			$resultado						= $this->db->query($consulta);

			foreach($resultado->result() as $row){
				$valor	= $row->cont;
			}

			$data['noCerrados']				= $valor;
			$cadena							= array();
			$cad							= explode("-",$idCliente);
			$cadena["idCli"]				= $cad[0];
			$cadena["forItemAgregar"]		= 200;

			if(isset($cadena['idCli']) && $cadena['idCli']>0 ){
				$this->load->library(array("webservice_sicas_soap","role"));
				$data['polzasClientes']		= $this->webservice_sicas_soap->GetClient_VerPolzasActividad($cadena);
			}
            $data['muestraVendedores']		= 0;
            if($this->uri->segment(7)=="verFol"){
				$data['permiteVerFol']	= true;
			}
			/*======================================================================================*/
			
			$data['numerodeurgentes']		= $this->actividadestrae_urgentesPrevio();
			if($this->tank_auth->get_View()!= "App"){
				$this->load->view('actividades/agregar', $data);
			} else {
				$this->load->view('actividades/agregarApp', $data);
			}
		}
	}/*! agregar */

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
	function agregarApp()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			
			$arrayPermisos					= $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());
			$actividadesPermisos			= $this->capsysdre->cotizacionPermisos($this->tank_auth->get_usermail(),$this->tank_auth->get_userprofile());
			$data['configModulos']			= array('modulo' => 'configuraciones');
			$data['SelectActividad']		= $this->capsysdre_actividades->SelectActividad($arrayPermisos);
			$data['SelectRamo']				= $this->capsysdre_actividades->SelectRamo($this->uri->segment(3), $actividadesPermisos);
			$data['SelectSubRamo']			= $this->capsysdre_actividades->SelectSubRamo($this->uri->segment(3), $this->uri->segment(4));
			$data['SelectCliente']			= $this->capsysdre_actividades->SelectCliente($this->uri->segment(3), $this->uri->segment(4), $this->uri->segment(5));
			$data['SelectEntidad']			= $this->capsysdre_actividades->SelectEntidad($this->uri->segment(3), $this->uri->segment(4), $this->uri->segment(5), $this->uri->segment(6));
			$data['SelectVendedor']			= $this->capsysdre_actividades->SelectVendedor($this->tank_auth->get_IDVend(), $this->tank_auth->get_IDVendNS(), $this->tank_auth->get_userprofile());
			$data['TextoExpresFormulario']	= $this->capsysdre_actividades->TextoExpresFormulario($this->uri->segment(3), $this->uri->segment(4), $this->uri->segment(5));
			$data['TextoExpresAsteriscos']	= $this->capsysdre_actividades->TextoExpresAsteriscos($this->uri->segment(3), $this->uri->segment(4), $this->uri->segment(5));
			$data['SelectTipoImg_1']		= $this->capsysdre_actividades->SelectTipoImg('1');
			$data['SelectTipoImg_2']		= $this->capsysdre_actividades->SelectTipoImg('2');
			$data['SelectTipoImg_3']		= $this->capsysdre_actividades->SelectTipoImg('3');
			$data['ckeditor']				= array(
													//ID of the textarea that will be replaced
														'id' 	=> 	'datosExpres',
														'path'	=>	'assets/js/ckeditor',
													//Optionnal values
														'config' => array(
															'width' 	=> 	"99%",		//Setting a custom width
															'height' 	=> 	'100px',	//Setting a custom height
															'toolbar' 	=> 	array(		//Setting a custom toolbar
																					'/'
																				)
															)
											  );
			$busquedaClienteProspecto		= urldecode($this->input->get('busquedaClienteProspecto',TRUE));
			$data['ListaClienteProspecto']	= $this->capsysdre_actividades->ListaClienteProspecto($busquedaClienteProspecto);
			$idCliente						= $this->input->get('idCliente',TRUE);
			$data['informacionCliente']		= $this->capsysdre_actividades->DetalleCliente($idCliente);
			
			if($this->input->get('idCliente', TRUE) == "false"){
				redirect('actividades/agregar/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$this->uri->segment(5).'/Existente?busquedaClienteProspecto=');
			}
			   
			$data['numerodeurgentes']		= $this->actividadestrae_urgentes();

			/*==========================CODIGO LOCM 05/05/2017=====================================*/
            $consulta						= "
				Select 
					count(actividades.idInterno) as cont 
				From 
					actividades 
				Where 
					actividades.Status	= 1 
					and 
					actividades.inicio	= 0 
					and
					actividades.usuarioCreacion	= '
											  ";
            $consulta						= $consulta.$this->tank_auth->get_usermail()."'";
            $resultado						= $this->db->query($consulta);
			foreach ($resultado->result() as $row){
				$valor=$row->cont;
			}

			$data['noCerrados']				= $valor;
			$cadena							= array();
			$cad							= explode("-",$idCliente);
			$cadena["idCli"]				= $cad[0];
			$cadena["forItemAgregar"]		= 200;
			$this->load->library(array("webservice_sicas_soap","role"));
			$data['polzasClientes']			= $this->webservice_sicas_soap->GetClient_VerPolzasActividad($cadena);
			$data['muestraVendedores']		= 0;	
			if($this->uri->segment(7)=="verFol"){
				$data['permiteVerFol']=true;
			}
			/*======================================================================================*/

			$data['numerodeurgentes']		= $this->actividadestrae_urgentesPrevio();
			$this->load->view('actividades/agregarApp', $data);
		}
	}/*! agregarApp */

//-----------------------------------------------------------------------------------------------------
	function nuevoGiro()
	{
		$nombreGiro		= ucfirst($_POST['giro']); 
		$idGiro			= 0; 
		$respuesta		= $this->catalogos_model->comprobarExistenciaCatalogoGiros($nombreGiro);
		
		if(count($respuesta)==0){
			$insert['idGiro']	= -1;
			$insert['giro']		= $nombreGiro;
			$idGiro				= $this->catalogos_model->catalogo_giros($insert);    
		} else {
			$idGiro				= $respuesta[0]->idGiro;
		}
		$catalogoGiro=$this->catalogos_model->catalogo_giros(null);
		$total					= count($catalogoGiro);
		$datos['catalogo']		= $catalogoGiro;
		$datos['activo']		= $idGiro;
		
		echo json_encode($datos);

	}/*! nuevoGiro */
	
//-----------------------------------------------------------------------------------------------------
	function agregarGuardar1()
	{
		if($this->input->post('giroCliente', TRUE)!='' && $this->input->post('giroActividad', TRUE)!=''){
			$insert['idGiro']		= $this->input->post('giroCliente', TRUE);
			$insert['actividad']	= $this->input->post('giroActividad', TRUE);
			$this->catalogos_model->relGiroActividad($insert);
		}
	}/*! agregarGuardar1 */
	
//----------------------------------------------------------------------------------------------------
	function agregarGuardar()
	{
		if(!$this->tank_auth->is_logged_in()){
			redirect('/auth/login/');
		} else {
/*===============SE TRAEN DATOS PARA UNA RECOTIZACION========*/
	if(isset($_POST['idInternoPadre']))
	{

	 $select['idInterno']=$_POST['idInternoPadre'];	 
     $respuesta=$this->capsysdre_actividades->actividades($select);
     $promotorias=$this->capsysdre_actividades->devolverPromotoriActividad($_POST['folioActividad']);     

     $_POST['IDVend']=$respuesta->IDVend;
     $_POST['tipoActividad']=$respuesta->tipoActividad;
     $_POST['subRamoActividad']=$respuesta->subRamoActividad;
     $_POST['tipoCliente']='Existente';
     $_POST['IDCli']=$respuesta->idCliente;
     $_POST['IDCont']=$respuesta->idContacto;
     $_POST['IDDir']='-1';
     $_POST['IDAgente']=$respuesta->IDVend;
     $_POST['IDGrupo']=1;
     $_POST['tipoActividadSicas']='ot';
     $_POST['TipoDocto']=0;
     $_POST['IDSRamo']=$respuesta->IDSRamo;
     $_POST['poliza']='';
     $_POST['usuarioCreacion']=$respuesta->usuarioCreacion;
     $_POST['usuarioResponsable']=$respuesta->usuarioResponsable;     
     $_POST['usuarioBolita']=$respuesta->usuarioBolita;
     $_POST['tipoRamo']=$respuesta->ramoActividad;
     $_POST['subRamoActividad']=$respuesta->subRamoActividad;
     if((count($promotorias))>0)
     {
     	$_POST['cbCompania']=array();
        foreach ($promotorias as $key => $value) 
        { 
          array_push($_POST['cbCompania'], $value->idPromotoria);
        }
     }
     switch ($respuesta->IDSRamo) {
     	case '17':
     		$_POST['IDEjecut']=2;
     		break;
     	case '19':
     		$_POST['IDEjecut']=2;
     		break;
     	case '21':
     		$_POST['IDEjecut']=2;
     		break;
     	case '20':
     		$_POST['IDEjecut']=1;
     		break;
     	case '16':
     		$_POST['IDEjecut']=3;
     		break;
     	case '52':
     		$_POST['IDEjecut']=1;
     		break;
         case '47':
     		$_POST['IDEjecut']=6;
     		break;
     	default:
     		$_POST['IDEjecut']=2;
     		break;

     	
     }
		 	
     

	}
     /*================CALCULA FOLIO DE ACTIVIDAD=======================*/
			$folioActividad		= $this->capsysdre_actividades->CalculaNewFolioActividad();

			/*===============ESTABLECE LA RELACION ENTRE LA ACTIVIDAD Y LA COMPANIA=============*/
			if($this->input->post('tipoActividad', TRUE)=='Cotizacion'){	
				if(isset($_POST['cbCompania'])){
					foreach ($_POST['cbCompania'] as  $value) {
						$insert['idPromotoria']				= $value;
	             		$insert['folioActividad']			= $folioActividad;
    	         		$insert['idSubRamo']				= $this->input->post('IDSRamo', TRUE);
        	     		$insert['idRelActividadPromotoria']	= -1;
            	 		$insert['tipoActividad']			= "Cotizacion";
             			$this->catalogos_model->relActividadPromotoria($insert);
					}
				}
			}
			if($this->input->post('tipoActividad', TRUE)=='Emision'){	
				if(isset($_POST['selectCompania'])){
					$insert['idPromotoria']				= $_POST['selectCompania'];
             		$insert['folioActividad']			= $folioActividad;
             		$insert['idSubRamo']				= $this->input->post('IDSRamo', TRUE);
             		$insert['idRelActividadPromotoria']	= -1;
             		$insert['tipoActividad']			= "Emision";
             		$this->catalogos_model->relActividadPromotoria($insert);             	
				}
			}

			if($this->input->post('tipoActividad', TRUE)=='Endoso'){
				if(isset($_POST['nombreCompania'])){
					$insert['idPromotoria']				= $this->input->post('idCompania', TRUE);//$compania[0]->idPromotoria;
					$insert['folioActividad']			= $folioActividad;
					$insert['idSubRamo']				= $this->input->post('IDSRamo', TRUE);
					$insert['idRelActividadPromotoria']	= -1;
					$insert['tipoActividad']			= "Endoso";
					$this->catalogos_model->relActividadPromotoria($insert);
				}
			}
			/*====================================================================================*/

			$tipoCliente		= $this->input->post('tipoCliente', TRUE);
			$TipoEnt			= $this->input->post('tipoEntidad',TRUE);
			
			if("Fisica" == $TipoEnt){
				$TipoEnt = "0";
			} else {
				$TipoEnt = "1";
			}

			if($tipoCliente == "Existente"){
				$idCliente				= $this->input->post('IDCli', TRUE);
				$idContacto				= $this->input->post('IDCont', TRUE);
				$cel					= $this->input->post('Telefono1', TRUE);
				$mail					= $this->input->post('EMail1', TRUE);
				$data2					= array('cel'=>$cel,'mail'=>$mail,);			
			/*	$this->webservice_sicas_soap->UpdateCliente($data2);//SE DESHABILITO EL GUARDADO  POR MIENTRAS SE VAN A GUARDAR LOS DATOS EN DIFERENTE*/

			} else if($tipoCliente == "Nuevo"){
				$clienteContactoSicas	= $this->capsysdre_actividades->CrearClienteContacto($TipoEnt);
				$idCliente				= $clienteContactoSicas[0]->NewIDValue;
				$idContacto				= $clienteContactoSicas[0]->NewSubIDValue;   
			}
/*=========CAMBIO 15052020=======*/			
			//$infoCliente				= $this->capsysdre_actividades->DetalleCliente($idCliente.'-'.$idContacto);

               $infoCliente=$this->ws_sicas->obtenerClienteInfo($idCliente)->TableInfo;			
		$nombreCliente	= $infoCliente->NombreCompleto;
			$tipoActividadSicas			= $this->input->post('tipoActividadSicas', TRUE);
			
			/*=============================================PARA GRABAR DATOS EN LA TABLA CLIENTES Y EL DE VERIFICACLIENTES===========================*/
			if($this->input->post('tipoActividad', TRUE)=='Emision' || $this->input->post('tipoActividad', TRUE)=='Cotizacion'  || $this->input->post('tipoActividad', TRUE)=='CambiodeConducto' || $this->input->post('tipoActividad', TRUE)=='CapturaEmision'){
				if($this->input->post('tipoCliente', TRUE) == "Nuevo"){
					if($this->input->post('tipoActividad',TRUE)=='Emision'){
						$insertar['preferenciaComunicacion']=$this->input->post('preferenciaComunicacion', TRUE) ;
						$insertar['horarioComunicacion']=$this->input->post('horarioComunicacion', TRUE) ;
						$insertar['diaComunicacion']=$this->input->post('diaComunicacion', TRUE) ;
					}
					if($this->input->post('tipoEntidad')=='Fisica'){
						$insertar['EMail1']= $this->input->post('EMail1', TRUE);
						$insertar['Sexo']= $this->input->post('Sexo', TRUE) ;
						$insertar['fecha_nacimiento']= $this->input->post('fecha_nacimiento', TRUE) ;
						$insertar['ApellidoP']= $this->input->post('ApellidoP', TRUE) ;
						$insertar['ApellidoM']= $this->input->post('ApellidoM', TRUE) ;
						$insertar['NombreCompleto']= $this->input->post('ApellidoP', TRUE) .' '.$this->input->post('ApellidoM', TRUE).' '.$this->input->post('Nombre', TRUE);
					} else {
						$insertar['fecha_nacimiento']= $this->input->post('fecha_constitucion', TRUE) ;
						$insertar['EMail1']= $this->input->post('Email1', TRUE);
						$insertar['NombreCompleto']=$this->input->post('Nombre', TRUE) ;
					}
					
					$insertar['Nombre']= $this->input->post('Nombre', TRUE) ;
					$insertar['idContacto']=$idContacto;
            $insertar['tipoEntidad']= $this->input->post('tipoEntidad', TRUE) ;
            $insertar['IDCli']=$idCliente;                  
            $insertar['Telefono1']= $this->input->post('Telefono1', TRUE) ;
            $insertar['claveEstado']=$this->input->post('claveEstado');
            $this->clientemodelo->insertarCliente($insertar);
          if($this->input->post('tipoActividad', TRUE)=='Emision' || $this->input->post('tipoActividad', TRUE)=='Cotizacion')
          {           	
          	$email=$this->input->post('EMail1', TRUE);
	       if($email==''){$email=$this->input->post('Email1', TRUE);}	
           if($this->input->post('IDSRamo', TRUE)==20 || $this->input->post('IDSRamo', TRUE)==7 || $this->input->post('IDSRamo', TRUE)==31 || $this->input->post('IDSRamo', TRUE)==52 || $this->input->post('IDSRamo', TRUE)==28 || $this->input->post('IDSRamo', TRUE)==34 || $this->input->post('IDSRamo', TRUE)==25 || $this->input->post('IDSRamo', TRUE)==30 || $this->input->post('IDSRamo', TRUE)==37)
           {
			    /*=====================CLIENTE PARA CAPITALRISK===================*/
	        $datos['subRamo']=$this->input->post('tipoSubRamo', TRUE);
	        $datos['usuarioCreacion']=$this->input->post('usuarioCreacion', TRUE);
	        $datos['nombreCliente']=$this->input->post('Nombre', TRUE).' '.$this->input->post('ApellidoP', TRUE).' '.$this->input->post('ApellidoM', TRUE);
	        $datos['Telefono1']=$this->input->post('Telefono1', TRUE);
	        $datos['EMail1']=$email;
	        $this->email_model->clienteParaCapitalRisk($datos);

           }
               
          if( $this->input->post('giroCliente', TRUE)!='' || $this->input->post('giroActividad', TRUE)!=''){
                if($this->input->post('tipoEntidad')=='Moral'){
                /*=====================CLIENTE PARA FIANZAS===================*/
           	      $buscaEstado['clave']=$this->input->post('claveEstado', TRUE);
           	       $buscaGiro['idGiro']=$this->input->post('giroCliente', TRUE);
	        $datos['ramo']=$this->input->post('tipoRamo', TRUE);
	        $datos['subRamo']=$this->input->post('tipoSubRamo', TRUE);
	        $datos['usuarioCreacion']=$this->input->post('usuarioCreacion', TRUE);
	        $datos['nombreCliente']=$this->input->post('Nombre', TRUE).' '.$this->input->post('ApellidoP', TRUE).' '.$this->input->post('ApellidoM', TRUE);
	        $datos['Telefono1']=$this->input->post('Telefono1', TRUE);
	        $datos['claveEstado']=$this->input->post('claveEstado', TRUE);
	        $datos['giroCliente']=$this->input->post('giroCliente', TRUE);
	        $datos['giroActividad']=$this->input->post('giroActividad', TRUE);	       
	        $datos['nombreEstado']=$this->catalogos_model->catalog_estados($buscaEstado)[0]->estado;
	        $datos['nombreGiro']=$this->catalogos_model->catalogo_giros($buscaGiro)[0]->giro;
	        $datos['EMail1']=$email;
	        
	        $this->email_model->clienteParaFianzas($datos);
                 }
             if($this->input->post('giroCliente', TRUE)!='' && $this->input->post('giroActividad', TRUE)!=''){
             	$insert="";
             	$insert['idGiro']=$this->input->post('giroCliente', TRUE);
             	$insert['actividad']=$this->input->post('giroActividad', TRUE);
             	$this->catalogos_model->relGiroActividad($insert);
             }
           }

          }
          /*=====================CLIENTE PARA PROYECTO 100===================*/

         if($this->input->post('IDPcien') <= 0)
			 {	
         if($this->input->post('tipoEntidad')=='Fisica'){$insertCRM['Nombre']=$this->input->post('Nombre', TRUE);}
         else{$insertCRM['RazonSocial']=$this->input->post('Nombre', TRUE);}         
          $insertCRM['IDCli']=-1;
          $apellidoPaterno=$this->input->post('ApellidoP', TRUE);
          $apellidoMaterno=$this->input->post('ApellidoM', TRUE);
          $insertCRM['ApellidoP']=($apellidoPaterno==0) ? '' : $apellidoPaterno;
          $insertCRM['ApellidoM']=($apellidoMaterno==0) ? '' : $apellidoMaterno;
          $insertCRM['actualiza']='clienteSikas';
          $insertCRM['Telefono1']=$this->input->post('Telefono1', TRUE);;
          $insertCRM['IDCliSikas']=$idCliente;
          $insertCRM['IDContacto']=$idContacto	;
          $insertCRM['Usuario']=$this->capsysdre->EmailVendedor($this->input->post('IDVend', TRUE));
          $insertCRM['EstadoActual']="DIMENSION";
          $insertCRM['folioActividad']=$folioActividad;
         // $insertCRM['idSicas']=$folioActividad;
          $this->clientemodelo->clientes_actualiza($insertCRM);    
          }      
         /*===================================================================*/

        }
        else
        {             		             		
           $existencia=$this->clientemodelo->verificaExistenciaCliente($idCliente);
           if(!$existencia)
           {                 
             $insertar['IDCli']=$idCliente;
             if(isset($_POST['preferenciaComunicacion'])){$insertar['preferenciaComunicacion']=$_POST['preferenciaComunicacion'] ;}
             if(isset($_POST['horarioComunicacion'])){$insertar['horarioComunicacion']=$_POST['horarioComunicacion'] ;}
             if(isset($_POST['diaComunicacion'])){$insertar['diaComunicacion']=$_POST['diaComunicacion'] ;}
             $insertar['NombreCompleto']=(string)$infoCliente->NombreCompleto;
             $insertar['idContacto']=$idContacto;
             $insertar['EMail1']=(string)$infoCliente->EMail1;
             $insertar['Telefono1']=(string)$infoCliente->Telefono1;                   
             $this->clientemodelo->insertarCliente($insertar);
           	}
           	else{
           		$update="";
           		$update['idContacto']=$idContacto;
           		$this->clientemodelo->actualizarCliente($idCliente,$update);
           	}
             $datosParaComprobar="";$insertar=null;
             /*if($this->input->post('tipoActividad')=='Emision')
             	{$nombreCliente=$this->input->post('nombreCliente');}else{$nombreCliente=$this->input->post('clienteEscogido');}*/
             if($this->input->post('tipoActividad')=='Emision')
              {if($this->input->post('nombreCliente')!=''){$nombreCliente=$this->input->post('nombreCliente');}}else{if($this->input->post('clienteEscogido')!=''){$nombreCliente=$this->input->post('clienteEscogido');}}
             if(isset($_POST['Telefono1'])){if($infoCliente->Telefono1!=$this->input->post('Telefono1')){$datosParaComprobar=$datosParaComprobar.'Telefono1:'.$this->input->post('Telefono1').';';}}
             if(isset($_POST['EMail1'])){if($infoCliente->EMail1!=$this->input->post('EMail1')){$datosParaComprobar=$datosParaComprobar.'EMail1:'.$this->input->post('EMail1').';';}}
            // if($infoCliente[0]->NombreCompleto!=$nombreCliente){$datosParaComprobar=$datosParaComprobar.'NombreCompleto:'.$nombreCliente.';';}
             if($datosParaComprobar!=''){$insertar['IDCli']=$idCliente;
             $insertar['emailUsuario']=$this->tank_auth->get_usermail();
             $insertar['idPersona']=$this->tank_auth->get_idPersona();
             $insertar['campos']=$datosParaComprobar;	$this->clientemodelo->guardarClienteVerifica($insertar);}    
          }     	
    }
 /*=======================================================================================================================================*/

			switch($tipoActividadSicas){ // Tipo Creacion Sicas
			
				case "tarea":
 
					$Descripcion	= $this->input->post('datosExpres', TRUE)." \r";
					if($this->input->post('actividadUrgente', TRUE) == 1){ $Comentario	.= "(*)Urgente !!! \r"; }
					$Descripcion	.= "(*) ".$this->tank_auth->get_usernamecomplete()." ";
					$Descripcion	.= "[".$this->tank_auth->get_usermail()."]";
					$Titulo		 = $this->input->post('tipoActividad', TRUE);
					$Titulo		.= "-".$this->input->post('tipoRamo', TRUE);
					$Titulo		.= "-".$this->input->post('tipoSubRamo', TRUE);					
					$IDUserR	= $this->input->post('IDUserR',TRUE);
					$IDTTarea	= $this->input->post('IDTTarea',TRUE);
					$CrearTarea = $this->capsysdre_actividades->CrearTarea($folioActividad,$idContacto,$Titulo,$Descripcion,$IDUserR,$IDTTarea);//++
					$poliza		= $this->input->post('poliza',TRUE);
					$idSicas		= $CrearTarea[0]->NewIDValue;
					$ClaveBit		= $CrearTarea[0]->ClaveBit;
					$NumSolicitud	=  $CrearTarea[0]->NewIDValue;
					$IDBit			= $CrearTarea[0]->NewIDValue;
                       //$NumSolicitud='22222';
                      //$idSicas='22222';
                     //$idSicas=null;

                    // agregue el try que cacha si no genera el idsicas 28 dic 2016
                    try{ 
                    	if(empty($idSicas) or is_null($idSicas)){throw new Exception('Varaible de SICAS no generada vuelva Intentar');}
                     }
                     catch (Exception $e){    
             	         echo $e->getMessage();
             	         redirect('/auth/login/');
        	         }// fin del try que cacha si no genera el idsicas 28 dic 2016


				break;
				
				case "ot":
					$actividadSicas = $this->capsysdre_actividades->CrearOt($folioActividad,$idCliente);//++
	
					$idSicas		= $actividadSicas[0]->NewIDValue;//++
					$ClaveBit		= $actividadSicas[0]->ClaveBit;//++
					$NumSolicitud	= $actividadSicas[0]->NumSolicitud;//++
					//$NumSolicitud='22222';//--
                     //$idSicas='22222';//--
					try{
				        if(empty($idSicas) or is_null($idSicas) or empty($NumSolicitud) )
				        {
				         	//$BANDERA=1;
                           throw new Exception('Varaible de SICAS no generada vuelva Intentar');
                        }
                     }
                     catch (Exception $e){    
             	         echo $e->getMessage();
             	         redirect('/auth/login/');
        	         }// fin del try que cacha si no genera el idsicas 28 dic 2016

					
					switch($this->input->post('tipoActividad',TRUE)){ // Update Para Actividades Especiales //
						case "CapturaEmision":
							$nodosUpdate[]	= "<Solicitud>".$this->input->post('polizaNew',TRUE)."</Solicitud>";
							$nodosUpdate[]	= "<Documento>".$this->input->post('polizaNew',TRUE)."</Documento>";
							$nodosUpdate[]	= "";
							$UpdateDocumento	= $this->capsysdre_actividades->UpdateDocumento($idSicas,$nodosUpdate);//++
							$NumSolicitud	= $this->input->post('polizaNew',TRUE);							
						break;
			
						case " CapturaRenovacion":
							$Documento	= "<Documento>".$this->input->post('polizaNew',TRUE)."</Documento>";
							$DAnterior	= "<DAnterior>".$this->input->post('polizaAnt',TRUE)."</DAnterior>";
	
							$UpdateDocumento	= $this->capsysdre_actividades->UpdateDocumento($idSicas,$nodosUpdate);//++
						break;
						
						default:
							$Documento	= "";
							$DAnterior	= "";
						break;
					}



					$Procedencia	= $this->input->post('tipoActividad',TRUE)." Capsys Web ".$folioActividad;
					$Comentario	   = $this->input->post('datosExpres', TRUE)." \r";
					if($this->input->post('actividadUrgente', TRUE) == 1){ $Comentario	.= "(*)Urgente !!! \r"; }
					$Comentario	   .= "(*) ".$this->tank_auth->get_usernamecomplete()." ";
					$Comentario	   .= "[".$this->tank_auth->get_usermail()."]";
					$bitacoraSicas	= $this->capsysdre_actividades->CrearBitacora($ClaveBit, $Procedencia, $Comentario);//++
					$IDBit			= $bitacoraSicas[0]->NewIDValue;
				break;
				
			}  
		
			//$this->capsysdre_actividades->CentroDigital($folioActividad,$idCliente);

           /*Resta numero de actividades urgentes al usuario Actividad Urgente*/
            $urge=0;

            $numerodeurgentes=$this->actividadestrae_urgentes();
            foreach($numerodeurgentes as $numurg)
            {$diti = $numurg->valor;}			
			if($this->input->post('actividadImportante', TRUE)!=0){$importante = 1;/* Mandamos Correos*/} 
			else {$importante = 0;}
			if($this->input->post('actividadUrgente', TRUE)!=0 )
			{
				 if ($diti>0)
				 {
				 	$urge=1;
				 	$this->Decrementa_urgentes();
				 }
				 else	
				 {
				 	$urge=0;
                 }	
			}	
/*===========================DIRECCIONA A FLOTILLA O BIENES==========================*/	


				/*	if($this->input->post('tipoSubRamo', TRUE)=="FLOTILLA DE VEHICULOS" || $this->input->post('tipoRamo', TRUE)=="DANOS")
				   	{$userResponsable="BIENES@AGENTECAPITAL.COM"; }
					else{$userResponsable=$this->input->post('usuarioResponsable', TRUE);}

					//encaso que venga de proyecto 100 corregimos el nuevo subramos seleccinado

					if($this->input->post('IDPcien') >0)
	                {	
	                	if($this->input->post('tipoRamo', TRUE)=="ACCIDENTES_Y_ENFERMEDADES" || $this->input->post('tipoRamo', TRUE)=="VIDA")
				   	    { 
				   	    	$IDEjecut	= "1";
                            $userResponsable="LINEASPERSONALES@ASESORESCAPITAL.COM";
						}

                    }
                
                    if($this->input->post('tipoRamo', TRUE)=="VEHICULOS" && $this->input->post('tipoActividad', TRUE)=="Endoso"){
                     $userResponsable="LINEASPERSONALES@ASESORESCAPITAL.COM";	
                    }
                    if($this->input->post('tipoRamo', TRUE)=="VEHICULOS" && $this->input->post('tipoActividad', TRUE)=="Cancelacion"){
                     $userResponsable="LINEASPERSONALES@ASESORESCAPITAL.COM";	
                    }

                    /*if($this->input->post('tipoRamo', TRUE)=="VEHICULOS" )
                    {
                    	if($this->input->post('tipoSubRamo', TRUE)!="FLOTILLA DE VEHICULOS"){
                    	 $userResponsable="AUTOS@ASESORESCAPITAL.COM";
                    	}
                    }
                    if($this->input->post('tipoActividad', TRUE)=='CapturaEmision'){
                    	$userResponsable="CAPTURA@ASESORESCAPITAL.COM";
                    }*/
/*===================================================================================*/
/*===========================================================ASIGNA A USUARIO RESPONSABLE=========================================================*/
if($this->input->post('tipoActividad', TRUE)!="CapturaEmision" && $this->input->post('tipoActividad', TRUE)!="AclaraciondeComisiones" ){
if($this->input->post('tipoRamo', TRUE)=='FIANZAS'){$userResponsable="FIANZAS@FIANZASCAPITAL.COM";}
else{
if($this->input->post('tipoRamo', TRUE)=="VEHICULOS" && $this->input->post('tipoActividad', TRUE)=="Cotizacion"){
	if($this->input->post('IDSRamo', TRUE)==20){$userResponsable="BIENES@ASESORESCAPITAL.COM";}
	else{$userResponsable="EJECUTIVOCOTIZACIONES@AGENTECAPITAL.COM";}
}
else{
	if($this->input->post('tipoRamo', TRUE)=="VEHICULOS" && $this->input->post('tipoActividad', TRUE)!="Cotizacion"){
		$userResponsable="AUTOS@ASESORESCAPITAL.COM";
	}
	else{
		if($this->input->post('tipoRamo', TRUE)=="ACCIDENTES_Y_ENFERMEDADES" || $this->input->post('tipoRamo', TRUE)=="VIDA"){
			$userResponsable="LINEASPERSONALES@ASESORESCAPITAL.COM";
		}
		else{
		  if($this->input->post('tipoRamo', TRUE)=="DANOS")	{
		  	$userResponsable="BIENES@ASESORESCAPITAL.COM";
		  }
		}
	}
}
}
}
else
{    
	if($this->input->post('tipoActividad', TRUE)=="AclaraciondeComisiones"){$userResponsable="AUDITORINTERNO@AGENTECAPITAL.COM";}
	else{$userResponsable="CAPTURA@ASESORESCAPITAL.COM";}
}
/*=================================================================================================================================================*/
                    $pagoFormas="";$pagoConducto="";$pagoFactura="";
                    if($this->input->post('pagoFormas', TRUE)>=1 || $this->input->post('pagoFormas', TRUE)<=4){$pagoFormas=$this->input->post('pagoFormas', TRUE);}
                    if($this->input->post('pagoConducto', TRUE)>=1 || $this->input->post('pagoConducto', TRUE)<=4){$pagoConducto=$this->input->post('pagoConducto', TRUE);}
                    if($this->input->post('pagoFactura', TRUE)>=1 || $this->input->post('pagoFactura', TRUE)<=3){$pagoFactura=$this->input->post('pagoFactura', TRUE);}
			$data = array(
				'folioActividad'	=>	$folioActividad,
				'fechaCreacion'		=>	(string)date('Y-m-d H:i:s'),
				'idSicas'			=>	$idSicas,
				'ClaveBit'			=>	$ClaveBit,
				'IDBit'				=>	$IDBit,
				'Status'			=>	"5",
				'NumSolicitud'		=>	"".$NumSolicitud."",
				'tipoActividadSicas'=>	$this->input->post('tipoActividadSicas', TRUE),
				'idCliente'			=>	$idCliente,
				'nombreCliente'		=>	"".$nombreCliente."",
				'idContacto'		=>	$idContacto,
				'tipoActividad'		=>	$this->input->post('tipoActividad', TRUE),
				'ramoActividad'		=>	$this->input->post('tipoRamo', TRUE),
				'subRamoActividad'	=>	$this->input->post('tipoSubRamo', TRUE),
				'actividadUrgente'	=>	$urge,
				'actividadImportante'	=> $importante,
				'usuarioCreacion'	=>	$this->input->post('usuarioCreacion', TRUE),
				'usuarioResponsable'=>	$userResponsable,
				'usuarioBolita'		=>	$userResponsable,
				'datosExpres'		=>	$this->input->post('datosExpres', TRUE),
				'poliza'			=>	$this->input->post('poliza', TRUE),
				'IDVend'			=>	$this->input->post('IDVend', TRUE),
				'usuarioVendedor'	=>	$this->capsysdre->EmailVendedor($this->input->post('IDVend', TRUE)),

				'nombreUsuarioVendedor'	=>	$this->capsysdre->NombreCompletoVendedor($this->input->post('IDVend', TRUE)),
				'notasDre'	=>	$this->capsysdre->NombreCompletoVendedor($this->input->post('IDVend', TRUE)),

				'nombreUsuarioCreacion'	=>  $this->capsysdre->NombreCompletoUsuarioCreacion($this->input->post('usuarioCreacion', TRUE)),
				'nombreUsuarioResponsable'	=> $this->capsysdre->NombreCompletoUsuarioResponsable($userResponsable),
				
				'tarjetaNumero'		=>	$this->input->post('numeroTarjeta', TRUE),
				'tarjetaMes'		=>	$this->input->post('mesTarjeta', TRUE),
				'tarjetaYear'		=>	$this->input->post('yearTarjeta', TRUE),
				'tarjetaCcv'		=>	$this->input->post('ccv', TRUE),
				'tarjetaTitular'	=>	$this->input->post('titularTarjeta', TRUE),
				'tarjetaTipo'		=>	$this->input->post('tipoTarjeta', TRUE),
				'tarjetaBanco'		=>	$this->input->post('bancoTarjeta', TRUE),
				'tarjetaTipoPago'	=>	$this->input->post('tipoPagoTarjeta', TRUE),
				'idPagoConducto'	=>	$pagoConducto,
				'idPagoFactura'	=>	$pagoFactura,
				'idPagoFormas'	=>	$pagoFormas,
				'direccionFactura'	=>	$this->input->post('direccionFactura', TRUE),
				'cpFactura'	=>	$this->input->post('cpFactura', TRUE),
				'rfcFactura'	=>	$this->input->post('rfcFactura', TRUE),
				'IDSRamo'=>$this->input->post('IDSRamo', TRUE),
				'polizaVerde'=>$this->input->post('tarjetaVerde', TRUE),
				'tarjetaNumeroEncriptado'		=>	$this->input->post('numeroTarjeta', TRUE),
				'tarjetaCodigoSeguridad'		=>	$this->input->post('ccv', TRUE),
			    'idInternoPadre'		=>	$this->input->post('idInternoPadre', TRUE),
			); 
    


			//CREAMOS CARPETA TARGET_ENDOSO CON DOCUMENTO EN BLANCO SOLAMENTE PARA ENDOSOS

			if($this->input->post('tipoActividad', TRUE)=='Endoso')
			 {	

				if ($_FILES['DocumentoFiles']["error"] > 0){
				echo "Error: " . $_FILES['DocumentoFiles']['error'] . "<br>";
				} else {
				

				$nameFileSicas="vacio.txt"; //paso nombre por default archivo txt en blanco
				$destination	= '/home/admin/domains/v3prod.capsys.site/public_html/V3/assets/img/tmp/'.$nameFileSicas;
				
				move_uploaded_file($_FILES['DocumentoFiles']['tmp_name'], $destination);
				$ListFilesURL	= base_url().'assets/img/tmp/'.$nameFileSicas;

				
				$TypeDestinoCDigital	= "CLIENT";
				$IDValuePK				= $idCliente;
				$FolderDestino			= "Target_Endoso";
				$polizita =$this->input->post('poliza', TRUE);
				if($polizita!=""){
						$FolderDestino			.= "\\".$polizita;
				}             
			    $this->capsysdre_actividades->CargarDocumento($TypeDestinoCDigital, $IDValuePK, $ListFilesURL, $FolderDestino);//++
                }
             }
                
			 $this->capsysdre_actividades->actividades_agregarGuardar($data);
/*=============== GUARDA TARJETA DE CREDITO(LOCM) ===========================*/
             if($this->input->post('numeroTarjeta',TRUE)!='' and $this->input->post('ccv',TRUE)!='')
             {
               $info['dato']=$_POST['numeroTarjeta'];
               $info['llave']=$idCliente;
               $encriptaNumeroTarjeta=$this->personamodelo->encriptarClave($info);
               $info['dato']=$_POST['ccv'];
               $info['llave']=$idCliente;
               $encriptaCodigoSeguridad=$this->personamodelo->encriptarClave($info);
               $guardarTarjeta['numeroTarjeta']=$encriptaNumeroTarjeta;
               $guardarTarjeta['codigoSeguridad']=$encriptaCodigoSeguridad;
               $guardarTarjeta['vencimiento']=$this->input->post('mesTarjeta', TRUE);
               $guardarTarjeta['anio']=$this->input->post('yearTarjeta', TRUE);              
               $guardarTarjeta['titularTarjeta']=$this->input->post('titularTarjeta', TRUE);
               $guardarTarjeta['banco']=$this->input->post('bancoTarjeta', TRUE);
               $guardarTarjeta['tipoPago']=$this->input->post('tipoPagoTarjeta', TRUE);
               $guardarTarjeta['IDCli']=$idCliente;
               $guardarTarjeta['tipoTarjeta']=$this->input->post('tipoTarjeta', TRUE);
               $guardarTarjeta['idPersonaTarjeta']=-1;
               $this->personamodelo->tarjetaPersona($guardarTarjeta);  
             }
/*=================================================================================================================*/			 
			



			// $this->capsysdre_actividades->ActualizaNewFolioActividad($folioActividad);

			 ////actuqlizacion para agregar al proyecto 100 la cotizacion moises//////

			 if($this->input->post('IDPcien') >0)
			 {	

					$fecharegistro=(string)date('Y-m-d H:i:s');
					$correoProcedente=$this->tank_auth->get_usermail();

           			$IDCli2 = $this->input->post('IDPcien');


                    if($this->input->post('tipoRamo')=='VEHICULOS')
                    {$puntogen=1;}
                    else
                    {$puntogen=1;}     
						$sqlInsert_Referencia = "Update `clientes_actualiza` set `EstadoActual` = 'COTIZADO', `folioActividad`='".$folioActividad."',`IDCliSikas`='".$idCliente."' where `IDCli`='".$IDCli2."'";                         
						$this->db->query($sqlInsert_Referencia);
						$referencia = $this->db->insert_id();
						$sqlInsert_grabapuntos = "Insert Ignore Into `puntaje` (`Usuario`, `IDCliente`,`FechaRegistro`,`EdoAnterior`,`EdoActual`,`PuntosGenerados`,`FolioActividad`,`idSicas`,`OT`,`IdClienteSikas`) Values(
									    '".$correoProcedente."',
									    '".$IDCli2."',
										'".$fecharegistro."', 
										'REGISTRADO',
										'COTIZADO',
										'".$puntogen."',
										'".$folioActividad."',
										'".$idSicas."',
										'".$NumSolicitud."',
										'".$idCliente."'
									);
											";                         
						$this->db->query($sqlInsert_grabapuntos);
						$referencia = $this->db->insert_id();

            }
			/* New Envio Correo Importante */
			if($importante==1){
			$config	= Array('protocol' => 'smtp','smtp_host' => 'mail.agentecapital.com','smtp_port' => 587,'smtp_user' => 'desarrollo@agentecapital.com', 'smtp_pass' => 'omarceja2018', 'mailtype' => 'html','charset' => 'iso-8859-1','wordwrap' => TRUE);
			$this->load->library('email', $config);
					  
			//** $folioActividad	= $this->input->get('folioActividad', TRUE); // 'SW22813'; //
			
			$sqlConsultaActividad = "
				Select `fechaCreacion`,`fechaActualizacion`,`nombreUsuarioResponsable`,`nombreUsuarioVendedor`,`nombreCliente`,`subRamoActividad`,`datosExpres` From `actividades` Where `folioActividad` = '".$folioActividad."'
									";
			$queryConsultaActividad	= $this->db->query($sqlConsultaActividad)->result();

			$fechaCreacion				= $queryConsultaActividad[0]->fechaCreacion;
			$fechaActualizacion			= $queryConsultaActividad[0]->fechaActualizacion;
			$nombreUsuarioResponsable	= $queryConsultaActividad[0]->nombreUsuarioResponsable;
			$nombreUsuarioVendedor		= $queryConsultaActividad[0]->nombreUsuarioVendedor;
			$nombreCliente				= $queryConsultaActividad[0]->nombreCliente;
			$subRamoActividad			= $queryConsultaActividad[0]->subRamoActividad;
			$datosExpres				= $queryConsultaActividad[0]->datosExpres;
			
			/* Send Mail */
			$message	= "<strong>Informacion de la Actividad</strong>
			<br>
			<strong>Actividad: </strong>  (".$folioActividad.")
			<br>
			<strong>Fecha Creaci&oacute;n Actividad: </strong> ".$fechaCreacion." <strong>Fecha Actualizaci&oacute;n Actividad: </strong> ".$fechaActualizacion."
			<br>
			<hr>
			<br />
			&nbsp;&nbsp;&nbsp;<strong>Responsable:</strong>&nbsp; ".$nombreUsuarioResponsable." 
			<br />
			&nbsp;&nbsp;&nbsp;<strong>Agente:</strong>&nbsp; ".$nombreUsuarioVendedor." 
			<br />
			&nbsp;&nbsp;&nbsp;<strong>Nombre Cliente:</strong>&nbsp; ".$nombreCliente." &nbsp;<strong>SubRamo:</strong>&nbsp; ".$subRamoActividad."
			<br />
			&nbsp;&nbsp;&nbsp;<strong>Datos:</strong>
			<br />
			&nbsp;&nbsp;&nbsp;".$datosExpres."
			<br /><br />
			<hr>
			<br />";
			
			$to			= "";
			$sqlCorreosImportante = "Select `correo`  From  `catalog_correosImportantes` Where 1";
			$queryCorreosImportante = $this->db->query($sqlCorreosImportante);
			foreach($queryCorreosImportante->result() as $rowCorreo){
				$to .= $rowCorreo->correo.", ";
			}
			
			$this->email->from('Capsys Web<do-not-reply@capsys.com.mx>');
			$this->email->to($to);
			$this->email->subject("Actividad Importante ".$folioActividad);
			$this->email->message($message);
			/* Send Mail */
			$this->email->send();
			}
			/* !New Envio Correo Importante */
			
			redirect('actividades/ver/'.$folioActividad);
		}
	}/*! agregarGuardar */
	
//--------------------------------------------------------------------------	
	function agregarSeguimiento(){
		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$oldPosicion	= $this->input->get_post('oldPosicion', TRUE);
			$enviar			= $this->input->get_post('enviar', TRUE);
			$ClaveBit		= $this->input->get_post('ClaveBit', TRUE);
			$Procedencia	= $this->input->get_post('Procedencia', TRUE);
			$Comentario	    = $this->input->get_post('Comentario', TRUE)." \r";
			$Comentario	   .= "(*) ".$this->tank_auth->get_usernamecomplete()." ";
			$Comentario	   .= "[".$this->tank_auth->get_usermail()."]";

			$bitacoraSicas	= $this->capsysdre_actividades->CrearBitacora($ClaveBit, $Procedencia, $Comentario);

			/*switch($this->tank_auth->get_userprofile()){
				case 1:
				case 2:
					$posicion = "5";
				break;
				
				case 3:
				case 4:
					$posicion = $enviar; //$oldPosicion;
				break;
				
				case 5:
					$posicion = "1";
				break;
			}*/
			if($oldPosicion==1){
				$posicion	= 5;
				$IDDocto	= $this->input->get_post('IDDocto', TRUE);
				
				if($this->input->get_post('tipoActividadSicas', TRUE) == "ot"){
					$StatusUser			= $this->capsysdre_actividades->CambiaStatusUser($IDDocto,$posicion);
				} else {
					$StatusUserTarea	= $this->capsysdre_actividades->CambiaStatusUserTarea($IDDocto,$posicion);
				}
				
				$dataUpdateActividad['Status']				= $posicion;
				$dataUpdateActividad['comentarioTemporal']	= $this->input->get_post('Comentario', TRUE);
				$this->db->where('actividades.idSicas', $IDDocto);
				$this->db->update('actividades', $dataUpdateActividad);
			}
			
			redirect('actividades/ver/'.$this->input->get_post('folioActividad', TRUE));
		}
	}/*! agregarSeguimiento */
	
//--------------------------------------------------------------------------
	function agregarDocumentoPromotoria()
	{
		if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
		else {
			
			if ($_FILES['DocumentoFiles']["error"] > 0){
				echo "Error: " . $_FILES['DocumentoFiles']['error'] . "<br>";
			} else {
				$this->load->model("manejodocumento_modelo");
				$nombreArchivo=$this->manejodocumento_modelo->obtenerNombreArchivo($_FILES['DocumentoFiles']['name']);
				$extensionArchivo=$this->manejodocumento_modelo->devolverExtension($_FILES['DocumentoFiles']['name']);

				 $nombreArchivo = str_replace(' ','_',$nombreArchivo);
				 $nombreArchivo = str_replace('.','_',$nombreArchivo);
				 $nombreArchivo = str_replace(',','_',$nombreArchivo);	
				 $nombreArchivo = str_replace('-','_',$nombreArchivo);				 
				 $nombreArchivo = str_replace(':','_',$nombreArchivo);	
				 $nameFileSicas =  $nombreArchivo;
				 $nameFileSicas .="_".date('YmdHi');
				 $nameFileSicas .='.'.$extensionArchivo;

				/*$nameFileSicas = str_replace(' ','_','DOCUMENTO_');
				$nameFileSicas.= str_replace('.','_',$this->input->post('Promotoria', TRUE));
				$nameFileSicas.= str_replace(',','_',$this->input->post('Promotoria', TRUE));
				//$nameFileSicas.= "-".strtoupper($this->input->post('descripcionArchivo', TRUE));
				$nameFileSicas.= "-".date('YmdHi');
				$nameFileSicas.= ".".strrev(strstr(strrev($_FILES['DocumentoFiles']['name']), '.', true));*/
		
				$destination	= '/home/admin/domains/v3prod.capsys.site/public_html/V3/assets/img/tmp/'.$nameFileSicas;
				
				move_uploaded_file($_FILES['DocumentoFiles']['tmp_name'], $destination);
				$ListFilesURL	= base_url().'assets/img/tmp/'.$nameFileSicas;
				
				$TypeDestinoCDigital	= $this->input->post('TypeDestinoCDigital', TRUE);
				$IDValuePK				= $this->input->post('IDValuePK', TRUE);
				$FolderDestino			= $this->input->post('FolderDestino', TRUE);

        	
				$this->capsysdre_actividades->CargarDocumento($TypeDestinoCDigital, $IDValuePK, $ListFilesURL, $FolderDestino);
			}
             		//$array['idPromotoria']=12;
             		//$array['folioActividad']=;
             		//$array['idSubRamo']=$this->input->post('IDSRamo', TRUE);
             		$array['idRelActividadPromotoria']=$this->input->post('idRelActividadPromotoria', TRUE);
             		$array['operacion']=1;
             		//$array['tipoActividad']=-"Cotizacion";

			$respuesta=$this->catalogos_model->relActividadPromotoria($array);
   			redirect('actividades/ver/'.$_POST['folioActividad']);
		}


	}
	
//--------------------------------------------------------------------------
	function agregarDocumento()
	{
		if(!$this->tank_auth->is_logged_in()){
			redirect('/auth/login/');
		} else {
			if ($_FILES['DocumentoFiles']["error"] > 0){
				echo "Error: " . $_FILES['DocumentoFiles']['error'] . "<br>";
			} else {
				$this->load->model('manejodocumento_modelo');

				$idCliente		= $this->input->post('idCliente', TRUE);
                //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($_POST,TRUE));fclose($fp);
				$nameFileSicas	= str_replace(' ','_',$this->input->post('tipoImg_0', TRUE));
				$nameFileSicas	.= "-".strtoupper($this->input->post('descripcionArchivo', TRUE));
				$nameFileSicas	.= "-".date('YmdHi');
				$nameFileSicas	.= ".".strrev(strstr(strrev($_FILES['DocumentoFiles']['name']), '.', true));
				// $destination	= 'C:\wamp\www\V3Presentacion\assets\img\tmp\\'.$nameFileSicas;
				//$destination	= 'C:\wamp64\www\Capsys\www\V3\assets\img\tmp\\'.$nameFileSicas;
				//$destination	= 'C:\wamp64\www\web_capsys\www\V3\assets\img\tmp\\'.$nameFileSicas;
				                   //C:\wamp64\www\Capsys\www\V3\assets\img
				$destination	= '/home/admin/domains/v3prod.capsys.site/public_html/V3/assets/img/tmp/'.$nameFileSicas;
				
				move_uploaded_file($_FILES['DocumentoFiles']['tmp_name'], $destination);

				switch($this->input->post('tipoImg_0', TRUE)){
					
					case "IFE":							## 01 ##
					case "RFC":							## 02 ##
					case "COMPROBANTE DOMICILIARIO":	## 03 ##
					case "ACTA CONSTITUTIVA":			## 04 ##
					case "PODER REPRESENTANTE LEGAL":	## 05 ##
					case "ACTA DE PROTOCOLIZACION":		## 06 ##
						$ListFilesURL			= base_url().'assets/img/tmp/'.$nameFileSicas;
						$TypeDestinoCDigital	= "CLIENT";
						$IDValuePK				= $idCliente;
						$FolderDestino			= "";
					break;
					
					default:
						$ListFilesURL			= base_url().'assets/img/tmp/'.$nameFileSicas;
						$TypeDestinoCDigital	= $this->input->post('TypeDestinoCDigital', TRUE);
						$IDValuePK				= $this->input->post('IDValuePK', TRUE);
						$FolderDestino			= $this->input->post('FolderDestino', TRUE);
					break;
				}
				
				$this->capsysdre_actividades->CargarDocumento($TypeDestinoCDigital, $IDValuePK, $ListFilesURL, $FolderDestino);
			}

			$oldPosicion	= $this->input->post('oldPosicion', TRUE);
			$enviar			= $this->input->post('enviar', TRUE);						
			$folioActividad	= $this->input->post('folioActividad', TRUE);
			
			switch($this->tank_auth->get_userprofile()){
				case 1:
				case 2:
					$posicion = "5";
				break;
				
				case 3:
				case 4:
					$posicion = $enviar; //$oldPosicion;
				break;
				
				case 5:
					$posicion = "1";
				break;
			}

			$IDDocto = $this->input->post('IDDocto', TRUE);			
			if($this->input->post('tipoActividadSicas', TRUE) == "ot"){
				$StatusUser = $this->capsysdre_actividades->CambiaStatusUser($IDDocto,$posicion);//++
			} else {
				$StatusUserTarea = $this->capsysdre_actividades->CambiaStatusUserTarea($IDDocto,$posicion);//+
			}

			redirect('actividades/ver/'.$folioActividad);
		}
	}/*! agregarDocumento */
	
//--------------------------------------------------------------------------
	function posponer()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else if(!$this->uri->segment(3)){ 
			redirect('actividades');
		} else {
			$IDDocto = $this->uri->segment(3);
			$StatusUser = "7";
			$this->capsysdre_actividades->CambiaStatusUser($IDDocto,$StatusUser);
			redirect('actividades');
		}
	}/*! posponer */
	
//--------------------------------------------------------------------------
	function calificarActividad()
	{
		if(!$this->tank_auth->is_logged_in()){
			redirect('/auth/login/');
		} else {

			$usermail		= $this->tank_auth->get_usermail();
			$folioActividad	= $this->input->get('folioActividad', TRUE);
			$satisfaccion	= $this->input->get('satisfaccion', TRUE);
			$tipoActividad	= $this->input->get('tipoActividad', TRUE);
		    $this->capsysdre_actividades->GuardarSatisfaccion($folioActividad, $satisfaccion, $tipoActividad);
		    $consulta['idInterno']=$this->input->get('idInterno'); 
		    $datosActividad=$this->capsysdre_actividades->actividades($consulta); 
      	    $consultaIdResponsable=$this->personamodelo->devolverUsersPorEmail($datosActividad->usuarioResponsable);
            $insertNoConformidad['nombreTabla']='actividades';            
            $insertNoConformidad['idPersonaInconforme']=$this->tank_auth->get_idPersona();
            $insertNoConformidad['idRowTabla']=$this->input->get('idInterno');
            $insertNoConformidad['idPersonaResponsable']=$consultaIdResponsable->idPersona;
            
            if($satisfaccion=='malo'){$this->procesamientoncmodel->insertarNC($insertNoConformidad);}

           //sea gregad eo codigo de terminacino de actividad para una sol Accion MIEF

			$sqlActividadesActualizar = "Update `actividades` set `Status`= '6' Where `usuarioCreacion`= '".$usermail."' and `folioActividad`= '".$folioActividad."'";
			$query = $this->db->query($sqlActividadesActualizar);


			$IDDocto	= $this->input->get('IDDocto', TRUE);
			$posicion	= "6";
			
			$StatusUser	= $this->capsysdre_actividades->CambiaStatusUser($IDDocto,$posicion);

			$ClaveBit		= $this->input->get('ClaveBit', TRUE);
			$Procedencia	= "Terminada Desde Capsys Web V3";
			$Comentario	    = "(*) TERMINADA \r";
			$Comentario	   .= "(*) ".$this->tank_auth->get_usernamecomplete()." ";
			$Comentario	   .= "[".$this->tank_auth->get_usermail()."]";
			$bitacoraSicas	= $this->capsysdre_actividades->CrearBitacora($ClaveBit, $Procedencia, $Comentario);

			redirect('actividades/verActividades');

			//redirect('actividades/ver/'.$folioActividad);
		}
	}/*! calificarActividad */
	
//--------------------------------------------------------------------------
	function terminar()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else if(!$this->uri->segment(3)){ 
			redirect('actividades');
		} else {

            
            $usermail		= $this->tank_auth->get_usermail();
			$folioActividad	= $this->uri->segment(3);

			$sqlActividadesActualizar = "
            Update 
		         `actividades`
			set
			    	`Status`= '6'
			Where
				   `usuarioCreacion`= '".$usermail."'
			and 	   
			       `folioActividad`= '".$folioActividad."'
									";
			$query = $this->db->query($sqlActividadesActualizar);

			/*$dataUpdateActividad['Status']	= "6"; //$dataUpdateActividad['fin'] = "1";
			$this->db->where('actividades.folioActividad', $folioActividad);
			$this->db->update('actividades', $dataUpdateActividad);*/


			$IDDocto	= $this->input->get('IDDocto', TRUE);
			$posicion	= "6";
			$StatusUser	= $this->capsysdre_actividades->CambiaStatusUser($IDDocto,$posicion);
	
			
			$ClaveBit		= $this->input->get('ClaveBit', TRUE);
			$Procedencia	= "Terminada Desde Capsys Web V3";
			$Comentario	    = "(*) TERMINADA \r";
			$Comentario	   .= "(*) ".$this->tank_auth->get_usernamecomplete()." ";
			$Comentario	   .= "[".$this->tank_auth->get_usermail()."]";
			$bitacoraSicas	= $this->capsysdre_actividades->CrearBitacora($ClaveBit, $Procedencia, $Comentario);

			redirect('actividades');
		}
	}/*! terminar */
	
//--------------------------------------------------------------------------
	function emitir()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else if(!$this->uri->segment(3)){ 
			redirect('actividades');
		} else {
			if(!$this->capsysdre_actividades->validacionFolioActividad($this->uri->segment(3))){
				redirect('actividades');
			}

			$data['configModulos'] = array( 'modulo' => 'configuraciones');
			$data['SelectTipoImg'] = $this->capsysdre_actividades->SelectTipoImg(0);
			
			$data['infoFolioActividad']		= $this->capsysdre_actividades->infoFolioActividad($this->uri->segment(3));
			$data['companias']=$this->capsysdre_actividades->obtenerPromotoriaPorActividad($data['infoFolioActividad']->folioActividad,"Cotizacion");

			$idSicas						= $data['infoFolioActividad']->idSicas;			
			$data['infoDocumento']			= $this->capsysdre_actividades->DetalleDocumento($idSicas);
			
			$idCliente						= $data['infoFolioActividad']->idCliente;
			$idContacto						= $data['infoFolioActividad']->idContacto;
			$data['infoCliente']			= $this->ws_sicas->obtenerClienteInfo($idCliente);//$this->capsysdre_actividades->DetalleCliente($idCliente.'-'.$idContacto);
            $data['infoCliente']=$data['infoCliente']->TableInfo;
         
						
			$claveBit						= $data['infoFolioActividad']->ClaveBit;
			$data['verBitacoraActividad'] 	= $this->capsysdre_actividades->InfoBitacoras($claveBit);
			
			if($data['infoFolioActividad']->tipoActividadSicas == "ot"){
				$TypeDestinoCDigital	= "DOCUMENT";
				$IDValuePK				= $data['infoFolioActividad']->idSicas;
			} else {
				$TypeDestinoCDigital	= "CLIENT";
				$IDValuePK				= $data['infoFolioActividad']->idCliente;
			}
			$data['verDocumentosActividad'] 	= $this->capsysdre_actividades->InfoDocumento($TypeDestinoCDigital, $IDValuePK);
			
			$data['ckeditorEmision']				= array(
														'id'		=> 	'ComentarioEmision',
														'path'		=>	'assets/js/ckeditor',
														'config'	=> array(
																		'width' 	=> 	"99%",		//Setting a custom width
																		'height' 	=> 	'100px',	//Setting a custom height
																		'toolbar' 	=> 	array(		
																								//Setting a custom toolbar
																								'/'
																							  )
																	   )
											  );			
			
			$this->load->view('actividades/emitir', $data);
		}
	}/*! emitir */
	
//--------------------------------------------------------------------------
	function agregarEmitir()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			

/*===========================================================ASIGNA A USUARIO RESPONSABLE=========================================================*/
if($this->input->post('tipoActividad', TRUE)!="CapturaEmision"){
if($this->input->post('tipoRamo', TRUE)=="VEHICULOS" && $this->input->post('tipoActividad', TRUE)=="Cotizacion"){
  $userResponsable="EJECUTIVOCOTIZACIONES@AGENTECAPITAL.COM";
}
else{
	if($this->input->post('tipoRamo', TRUE)=="VEHICULOS" && $this->input->post('tipoActividad', TRUE)!="Cotizacion"){
		$userResponsable="AUTOS@ASESORESCAPITAL.COM";
	}
	else{
		if($this->input->post('tipoRamo', TRUE)=="ACCIDENTES_Y_ENFERMEDADES" || $this->input->post('tipoRamo', TRUE)=="VIDA"){
			$userResponsable="LINEASPERSONALES@ASESORESCAPITAL.COM";
		}
		else{
		  if($this->input->post('tipoRamo', TRUE)=="DANOS")	{
		  	$userResponsable="BIENES@ASESORESCAPITAL.COM";
		  }
		}
	}
}
}
else{
	$userResponsable="CAPTURA@ASESORESCAPITAL.COM";
}
/*=================================================================================================================================================*/

			$this->db->from("actividades");
			$this->db->where("actividades.idSicas", $this->input->post('IDDocto', TRUE));
			$query = $this->db->get();
			$infoActividad = $query->row();
			
			$ClaveBit		= $this->input->post('ClaveBit', TRUE);
			$Procedencia	= $this->input->post('Procedencia', TRUE);
			$Comentario	    = $this->input->post('ComentarioEmision', TRUE)." \r";
			$Comentario	   .= "(*) EMISION \r";
			$Comentario	   .= "(*) ".$this->tank_auth->get_usernamecomplete()." ";
			$Comentario	   .= "[".$this->tank_auth->get_usermail()."]";
			$bitacoraSicas	= $this->capsysdre_actividades->CrearBitacora($ClaveBit, $Procedencia, $Comentario);//++
			switch($this->tank_auth->get_userprofile()){
				case 1:
				case 2:
				case 3:
				case 4:
				case 5:
					//$posicion = "1";
					$posicion = "5";
				break;
			}
			$posicion = "5";
			$Concepto = "EMISION => ".strtoupper($Procedencia);
			$IDDocto = $this->input->post('IDDocto', TRUE);
			$StatusUser = $this->capsysdre_actividades->CambiaStatusEmision($IDDocto,$posicion,$Concepto);//++
			
           $usuarioResponsable=$this->catalogos_model->devolverRamoConIdSubramo($infoActividad->IDSRamo);
//
				$dataUpdateActividad['Status'] = $posicion;
				$dataUpdateActividad['fechaEmite'] = date('Y-m-d H:i:s');
				
				$this->db->where('actividades.idSicas', $IDDocto);
				$this->db->update('actividades', $dataUpdateActividad);
				
				$data['folioActividad']		= $infoActividad->folioActividad;
				$data['idSicas']			= $infoActividad->idSicas;
				$data['NumSolicitud']		= $infoActividad->NumSolicitud;
				$data['ClaveBit']			= $infoActividad->ClaveBit;
				$data['IDBit']				= $infoActividad->IDBit;
				$data['Status']				= $posicion;
				$data['tipoActividadSicas']	= $infoActividad->tipoActividadSicas;
				$data['inicio']				= "1";
				$data['fin']				= "0";
				$data['idCliente']			= $infoActividad->idCliente;
				$data['nombreCliente']		= $infoActividad->nombreCliente;
				$data['idContacto']			= $infoActividad->idContacto;
				$data['tipoActividad']		= "Emision";
				$data['ramoActividad']		= $infoActividad->ramoActividad;
				$data['subRamoActividad']	= $infoActividad->subRamoActividad;
				$data['actividadUrgente']	= $infoActividad->actividadUrgente;
				$data['viaOficina']			= $infoActividad->viaOficina;
				$data['datosExpres']		= $this->input->post('ComentarioEmision', TRUE);
				$data['usuarioCreacion']	= $infoActividad->usuarioCreacion;
				$data['usuarioVendedor']	= $infoActividad->usuarioVendedor;
				$data['IDVend']	= $infoActividad->IDVend;
				//$data['usuarioResponsable']	= $infoActividad->usuarioResponsable;
				$data['usuarioResponsable']	=$usuarioResponsable[0]->emailResponsable;

				$data['nombreUsuarioCreacion']	= $infoActividad->nombreUsuarioCreacion;

				//$data['nombreUsuarioResponsable']	= $infoActividad->nombreUsuarioResponsable;
                $data['nombreUsuarioResponsable']	= $usuarioResponsable[0]->nombres.' '.$usuarioResponsable[0]->apellidoPaterno.' '.$usuarioResponsable[0]->apellidoMaterno;
                $data['polizaVerde']	= $infoActividad->polizaVerde;
                $data['IDSRamo']	= $infoActividad->IDSRamo;
				$data['fechaCreacion']		= date('Y-m-d H:i:s');
				$this->db->insert('actividades', $data);

             	if(isset($_POST['selectCompania'])){
             		$insert['idPromotoria']=$_POST['selectCompania'];
             		$insert['folioActividad']=$infoActividad->folioActividad;
             		$insert['idSubRamo']=$infoActividad->IDSRamo;
             		$insert['idRelActividadPromotoria']=-1;
             		$insert['tipoActividad']="Emision";
             		$this->catalogos_model->relActividadPromotoria($insert);
             	
               }
         


			redirect('actividades/ver/'.$this->input->post('folioActividad', TRUE));
		}
	}/*! agregarEmitir */

//------------------------------------------------------------------------------------
	function eliminarImportante()
	{
		$update['actividadImportante']	= 2;
		$this->capsysdre_actividades->actualizarActividad($_POST['folioActividad'],$update);
		$direccion						= 'Location:'.base_url()."actividades/ver/".$_POST['folioActividad'];
		header($direccion);
	}/*! eliminarImportante */
	
//------------------------------------------------------------------------------------
	function encripta()
	{
		$dato				= $this->db->query("select AES_ENCRYPT('','SW4567') as encripta ")->result();
		$insert['id']		= 7;
    	$insert['prueba']	= $dato[0]->encripta;
		$this->db->insert('abaco',$insert);
	}/*! encripta */
	
//--------------------------------------------------------------------------
	function guardarCalificacion()
	{
	 
      $calificaciones=explode(';',$_POST['calificaciones']);
      $idPersona=$this->tank_auth->get_idPersona();
      $calificacionMala=1;
      foreach ($calificaciones as  $value) {
      	if($value!=""){
      		$calificar=explode('-',$value);
      		$insert['idCalificacionAgente']=$calificar[0];
      		$insert['calificacionActividad']=$calificar[1];
      		$insert['folioActividad']=$_POST['folioActividad'];
      		$insert['idPersona']=$idPersona;
      		$insert['IDVend']=$_POST['IDVend'];
      		$insert['tipoActividad']=$_POST['tipoActividad'];      		      		
      		$insert['idInternoActividad']=(integer)$_POST['idInterno'];
      		$this->catalogos_model->guardarCalificacionActividad($insert);
      		if($calificar[1]==0){$calificacionMala=0;}
      	}
      	}
		if($calificacionMala==0){
			$consulta['idInterno']=$_POST['idInterno'];        	 
			$datosActividad=$this->capsysdre_actividades->actividades($consulta);      	      	      	
			$consultaIdResponsable=$this->personamodelo->devolverUsersPorEmail($datosActividad->usuarioCreacion);
			$insertNoConformidad['nombreTabla']='calificacionactividad';            
			$insertNoConformidad['idPersonaInconforme']=$this->tank_auth->get_idPersona();
			$insertNoConformidad['idRowTabla']=$_POST['idInterno'];
			$insertNoConformidad['idPersonaResponsable']=$consultaIdResponsable->idPersona;
			$this->procesamientoncmodel->insertarNC($insertNoConformidad);
		}

		$direccion	= 'Location:'.base_url()."actividades/ver/".$_POST['folioActividad'];
    	header($direccion);
	}/*! guardarCalificacion */

//------------------------------------------------------------------------------------
	function modificarActividad()
	{
if(isset($_POST['Concepto'])){
	$update['Concepto']=$_POST['Concepto'];
}

if(isset($_POST['FEmision'])){$update['FEmision']=$_POST['FEmision'];}
if(isset($_POST['cambioPropietario'])){$update['IDUSERR']=20;$actualizar['captura']=1;}

 if($_POST['tipoActividadSicas']=='tarea')
 {
 	 $update['IDTarea']=$_POST['IDDocto'];
	 $update['Status']=$_POST['Status'];
	 //$update['IDUSERR']=20;
  $respuesta=$this->ws_sicas->actualizaTarea($update);
 }else{
	 $update['IDDocto']=$_POST['IDDocto']; 
	 $update['StatusUser']=$_POST['Status'];
	  //$update['FEmision']='1/1/2019';
	 //$update['IDPRIORIDAD']=0;
	 $respuesta=$this->ws_sicas->actualizaOT($update);
	}
	
	if($_POST['Status']==1  && $_POST['motivoCambio']!='')
	{
		$consulta='select p.celPersonal from actividades a left join persona p on  p.IDVend=a.IDVend where a.folioActividad="'.$_POST['folioActividad'].'"';
		$motivoConsulta='select motivoCambio from catalog_motivocambioactividades where idMotivaCambio='.$_POST['motivoCambio'];		
        $motivo=$this->db->query($motivoConsulta)->result()[0]->motivoCambio;
		$resp=$this->db->query($consulta)->result();
		if($_POST['motivoCambio']==1)
		{   $cons='select a.tipoActividad,a.idInterno from actividades a where a.folioActividad="'.$_POST['folioActividad'].'"';
			$tipoActividad=$this->db->query($cons)->result()[0];
			if($tipoActividad->tipoActividad=='CapturaEmision')
			{
				$_POST['Status']=6;
				$actualizar['depuracionAutomatica']=1;
			}
		
		}

		if((count($resp))>0)
		{
			
		 $telefono=$this->whatssms->comprobarNumero($resp[0]->celPersonal);
		 
		 if($telefono!=0)
		 {
           $sms['message']='La actividad '.$_POST['folioActividad'].' a sido devuelta,'.$motivo.','.base_url().'actividades/ver/'.$_POST['folioActividad'];
          //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($sms['message'],TRUE));fclose($fp); 
           $sms['numbers']=$telefono; 
           $res=$this->whatssms->enviarSMS($sms);

		 }

       }
	}	
	 if(isset($respuesta['Sucess'])){
	 	if($respuesta['Sucess']){
	 		 
	 		//$oldPosicion	= $this->input->post('oldPosicion', TRUE);
			//$enviar			= $this->input->post('enviar', TRUE);
			//$ClaveBit		= $this->input->post('ClaveBit', TRUE);
			$Procedencia	= $this->input->post('Procedencia', TRUE);
			//$Comentario	    = $this->input->post('Comentario', TRUE)." \r";
			if($_POST['textoComentario']!=''){$Comentario.=$_POST['textoComentario'];} 
			$Comentario	   .= "(*) ".$this->tank_auth->get_usernamecomplete()." ";
			$Comentario	   .= "[".$this->tank_auth->get_usermail()."]";

			$comentario['ClaveBit']=$_POST['ClaveBit'];
			$comentario['Procedencia']="";//$Comentario;
			$comentario['Comentario']=$Comentario;
			$comentario['IDBit']=-1;
			$comentario['Prioridad']=1;
			$bitacoraSicas	= $this->ws_sicas->bitacora($comentario);
if(isset($_POST['motivoCambio'])){$actualizar['motivoCambio']=$_POST['motivoCambio'];}
else{$actualizar['motivoCambio']=0;}
	 		$actualizar['Status']=$_POST['Status'];	 	
	 	    $actualizar['idPersonaTrabaja']=0;
            $actualizar['trabajandoseActividad']=0;	 
            $actualizar['comentarioTemporal']=$_POST['textoComentario'];

	 		$this->capsysdre_actividades->actualizarActividad($_POST['folioActividad'],$actualizar);

	 	}
	 }	        
    $direccion='Location:'.base_url()."actividades/ver/".$_POST['folioActividad'];
    header($direccion);
	}/*! modificarActividad */

//------------------------------------------------------------------------------------
	function agregarCompaniaAdicional()
	{
		$existeFolio=$this->capsysdre_actividades->comprobarExistenciaActividad($_POST['folioActividad']);
		$existePromotoria=$this->catalogos_model->comprobarExistenciaPromotoria($_POST['idPromotoria']);
		if($existeFolio && $existePromotoria){
			if(!$this->capsysdre_actividades->comprobarExistenciaRAP($_POST['folioActividad'],$_POST['idPromotoria'])){
				$insert['idPromotoria']=$_POST['idPromotoria'];
				$insert['folioActividad']=$_POST['folioActividad'];
				$insert['idSubRamo']=$_POST['IDSRamo'];
      $insert['tipoActividad']=$_POST['tipoActividad'];
      $insert['idPersona']=$this->tank_auth->get_idPersona();
      $insert['idRelActividadPromotoria']=-1;
      $this->catalogos_model->relActividadPromotoria($insert);

    }

}

	$direccion='Location:'.base_url()."actividades/ver/".$_POST['folioActividad'];
    header($direccion);


	}/*! agregarCompaniaAdicional */
	
//------------------------------------------------------------------------------------
	function ver()
	{
		$this->load->library(array("webservice_sicas_soap","role"));
		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else if(!$this->uri->segment(3)){ 
			redirect('actividades');
		} else {			
		/*============ VERIFICA QUE EL FOLIO EXISTA=========================*/
			if(!$this->capsysdre_actividades->validacionFolioActividad($this->uri->segment(3))){redirect('actividades');}

			$data['saldo']					= $this->saldo_model->saldo($this->tank_auth->get_user_id());
			$data['statusActividades']		= $this->capsysdre_actividades->statusActividades();		
			$data['configModulos']			= array( 'modulo' => 'configuraciones');
			$data['SelectTipoImg']			= $this->capsysdre_actividades->SelectTipoImg(0);			
			$data['infoFolioActividad']		= $this->capsysdre_actividades->infoFolioActividad($this->uri->segment(3));
			$data['infoFolioActividadEmi']	= $this->capsysdre_actividades->infoFolioActividadEmi($this->uri->segment(3));
			$data['calificaciones']			= $this->capsysdre_actividades->obtenerCalificaciones();

			if($data['infoFolioActividadEmi'] == ""){
				$data['datosTarjeta']						= $this->capsysdre_actividades->descriptaDatosActividad($data['infoFolioActividad']->folioActividad);
				$data['infoFolioActividad']->tarjetaNumero	= $data['datosTarjeta'][0]->numero;
				$data['infoFolioActividad']->tarjetaCcv		= $data['datosTarjeta'][0]->codigo;
				
				if($data['infoFolioActividad']->tipoActividad == "Cotizacion"){
				$data['promotorias']=$this->capsysdre_actividades->obtenerPromotoriaPorActividad($data['infoFolioActividad']->folioActividad,'Cotizacion');

				} else {
					if($data['infoFolioActividad']->tipoActividad=="Emision"){
						$data['promotorias']	= $this->capsysdre_actividades->obtenerPromotoriaPorActividad($data['infoFolioActividad']->folioActividad,'Emision');	
					} else {
						$data['promotorias']	= $this->capsysdre_actividades->obtenerPromotoriaPorActividad($data['infoFolioActividad']->folioActividad,'Endoso');
					}
				}
				
			} else {

				$data['promotorias']							= $this->capsysdre_actividades->obtenerPromotoriaPorActividad($data['infoFolioActividad']->folioActividad,'Emision');
				$data['infoFolioActividad']->usuarioResponsable	= $data['infoFolioActividadEmi']->usuarioResponsable;
			}
			
			if($data['infoFolioActividad']->usuarioResponsable==$this->tank_auth->get_usermail()){
				$data['permisos']['modificarActividad']		= "";
				$data['permisos']['calificarActividad']		= "";
				$data['permisos']['tarjetaBancoActividad']	= "";
			} else { 
				$data['permisos']							= $this->personamodelo->permisosPersona('actividades');
			}

			$idSicas						= $data['infoFolioActividad']->idSicas;
			
			if($data['infoFolioActividad']->tipoActividadSicas == "ot"){
				$data['infoDocumento']		= $this->capsysdre_actividades->DetalleDocumento($idSicas);
			} else {
				$data['infoDocumento']		= false; /*$this->capsysdre_actividades->DetalleDocumento($idSicas);*/
			}

            $data['actividadCalificada']	= $this->capsysdre_actividades->obtenerActividadCalificada($data['infoFolioActividad']->folioActividad,$data['infoFolioActividad']->tipoActividad)[0]->total;
            //	
			$idCliente						= $data['infoFolioActividad']->idCliente;
			$idContacto						= $data['infoFolioActividad']->idContacto;
            
			//$data['infoCliente']			= $this->capsysdre_actividades->DetalleCliente($idCliente.'-'.$idContacto);
			$data['infoCliente']			= $this->ws_sicas->obtenerClientePorID($idCliente)->TableInfo;//$this->capsysdre_actividades->DetalleCliente($idCliente.'-'.$idContacto);
			$data['cliente']				= $this->clientemodelo->obtenerDatosCliente($idCliente);
						
			$claveBit						= $data['infoFolioActividad']->ClaveBit;
			$data['verBitacoraActividad'] 	= $this->capsysdre_actividades->InfoBitacoras($claveBit);

			//$TypeDestinoCDigital = "DOCUMENT";
			//$IDValuePK = $data['infoFolioActividad']->idSicas;
			
			//** New Info Cliente **//	
			$ClienteContact 		= $this->webservice_sicas_soap->GetClient_forID($idCliente);
			$datosCliente			= $this->clientemodelo->obtenerDatosCliente($idCliente);
			if(count($datosCliente)==0){
				if(!is_object($datosCliente)){ $datosCliente = new stdClass; }
				$datosCliente->preferenciaComunicacion	= "";
				$datosCliente->horarioComunicacion		= "";
				$datosCliente->diaComunicacion			= "";
			} else {
				$datosCliente=$datosCliente[0];
			}
				$data["ClienteContact"]		= $ClienteContact;
				$data["Direcciones"]		= $this->webservice_sicas_soap->GetAddressClient($idCliente);
				$data['Grupo']				= $this->catalogos_model->get_Grupos();
				$data['SubGrupo']			= $this->catalogos_model->get_SubGrupos($ClienteContact["cliente"]->IDGrupo);
				$data['formasContacto']		= $datosCliente;
				//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($datos['formasContacto'], TRUE));fclose($fp);
			
			$data["msj"] = '';
			if (array_key_exists("msj", $_GET))
			{
				$data["msj"] = $_GET["msj"];
			}
			
			// ** !New Info Cliente **//
			
			
			if($data['infoFolioActividad']->tipoActividadSicas == "ot"){
				$TypeDestinoCDigital		= "DOCUMENT";
				$IDValuePK					= $data['infoFolioActividad']->idSicas;
			} else {
				$TypeDestinoCDigital		= "CLIENT";
				$IDValuePK					= $data['infoFolioActividad']->idCliente;
			}
			$data['verDocumentosActividad']	= $this->capsysdre_actividades->InfoDocumento($TypeDestinoCDigital, $IDValuePK);


			$data['ckeditor']				= array(
														'id'		=> 	'Comentario',
														'path'		=>	'assets/js/ckeditor',
														'config'	=> array(
																		'width' 	=> 	"99%",		//Setting a custom width
																		'height' 	=> 	'100px',	//Setting a custom height
																		'toolbar' 	=> 	array(		
																								//Setting a custom toolbar
																								'/'
																							  )
																	   )
											  );

			if($data['infoFolioActividad']->tipoActividad=="Cotizacion" || $data['infoFolioActividad']->tipoActividad=="Emision"){
				$data['agregarCompania']	=$this->catalogos_model->devolverCompanias();
			} 
			$data['configModulos'] = $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());

			//** $this->load->view('actividades/ver', $data);
			
			if($this->tank_auth->get_View()!= "App"){
				$this->load->view('actividades/ver',$data);
			} else {
				$this->load->view('actividades/verApp',$data);
			}
		}
	}/*! ver */
	
//------------------------------------------------------------------------------------	
	function todas()
	{

		foreach ($_POST['ch'] as  $value) {
		$datos=explode("|",$value);
	   
         $usermail		= $this->tank_auth->get_usermail();
			$folioActividad	= $datos[2];//$this->input->get('folioActividad', TRUE);
			$satisfaccion	= 'bueno';//$this->input->get('satisfaccion', TRUE);
			$tipoActividad	= "Actividad";//$this->input->get('tipoActividad', TRUE);
			$this->capsysdre_actividades->GuardarSatisfaccion($folioActividad, $satisfaccion, $tipoActividad);
           
           //sea gregad eo codigo de terminacino de actividad para una sol Accion MIEF

			$sqlActividadesActualizar = "Update `actividades` set `Status`= '6' Where `usuarioCreacion`= '".$usermail."' and `folioActividad`= '".$folioActividad."'";
			$query = $this->db->query($sqlActividadesActualizar);


			$IDDocto	= $datos[0];//$this->input->get('IDDocto', TRUE);
			$posicion	= "6";
			
			$StatusUser	= $this->capsysdre_actividades->CambiaStatusUser($IDDocto,$posicion);

			
			$ClaveBit		= $datos[1];//$this->input->get('ClaveBit', TRUE);
			$Procedencia	= "Terminada Desde Capsys Web V3";
			$Comentario	    = "(*) TERMINADA \r";
			$Comentario	   .= "(*) ".$this->tank_auth->get_usernamecomplete()." ";
			$Comentario	   .= "[".$this->tank_auth->get_usermail()."]";
			$bitacoraSicas	= $this->capsysdre_actividades->CrearBitacora($ClaveBit, $Procedencia, $Comentario);

              


		}
	
        redirect('actividades/verActividades');
	/*CODIGO QUE CERRABA ANTIGUAMENTE EN FORMA GRUPAL*/
		/*if(!$this->tank_auth->is_logged_in()){
			redirect('/auth/login/');
		} else {
			if(!$this->input->post('ch', TRUE)){
				redirect('/actividades');
			} else {
				
				switch($this->input->post('tipo', TRUE)){
					case "posponerTodas": ## 7
						$Status = "7";
					break;
					
					case "terminarTodas": ## 6
						$Status = "6";
					break;
				}
				
				foreach($this->input->post('ch', TRUE) as $checkbox){
					$IDDocto	= strstr($checkbox, '|', true);
					$ClaveBit	= substr(strstr($checkbox, '|'), 1);
					
					$dataUpdateActividad['Status']	= $Status;
					$this->db->where('actividades.idSicas', $IDDocto);
					$this->db->update('actividades', $dataUpdateActividad);

					$StatusUser	= $this->capsysdre_actividades->CambiaStatusUser($IDDocto,$Status);
					
					if($Status == '6'){
						$Procedencia	= "Terminada Desde Capsys Web V3";
						$Comentario	    = "(*) TERMINADA \r";
						$Comentario	   .= "(*) ".$this->tank_auth->get_usernamecomplete()." ";
						$Comentario	   .= "[".$this->tank_auth->get_usermail()."]";
						$bitacoraSicas	= $this->capsysdre_actividades->CrearBitacora($ClaveBit, $Procedencia, $Comentario);
					}
				}
				redirect('/actividades');
			}
		}*/
	}/*! todas */
	
//------------------------------------------------------------------------------------	
	function tomaractividad()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			
			$folio = $this->uri->segment(3); //$this->input->get('IDDocto', TRUE);
			$folioActividad	= strstr($folio, '-', true);
			$IDDocto	= substr(strstr($folio, "-"), 1);
			$ClaveBit	= substr(strstr($IDDocto, "-"), 1);
			$posicion = "3";
			
			//$ClaveBit		= $this->input->post('ClaveBit', TRUE);
			$Procedencia	= "Nube Capsys Web ".$folioActividad;//$this->input->post('Procedencia', TRUE);
			$Comentario	    = "Actividad Tomada \r";
			$Comentario	   .= "(*) ".$this->tank_auth->get_usernamecomplete()." ";
			$Comentario	   .= "[".$this->tank_auth->get_usermail()."]";
			$bitacoraSicas	= $this->capsysdre_actividades->CrearBitacora($ClaveBit, $Procedencia, $Comentario);
	
			$StatusUser = $this->capsysdre_actividades->CambiaStatusUser($IDDocto,$posicion);
			
				$dataUpdateActividad['Status'] = $posicion;
				$this->db->where('actividades.idSicas', $IDDocto);
				$dataUpdateActividad['usuarioBloqueo'] = $this->tank_auth->get_usermail();
				$this->db->update('actividades', $dataUpdateActividad);
			redirect('actividades/ver/'.$folioActividad);
		}
	}/*! tomaractividad */
	
//------------------------------------------------------------------------------------	
	function soltaractividad()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {

			$folio = $this->uri->segment(3); //$this->input->get('IDDocto', TRUE);
			$folioActividad	= strstr($folio, '-', true);
			$IDDocto	= substr(strstr($folio, "-"), 1);
			$ClaveBit	= substr(strstr($IDDocto, "-"), 1);
			$posicion = "5";
			
			//$ClaveBit		= $this->input->post('ClaveBit', TRUE);
			$Procedencia	= "Nube Capsys Web ".$folioActividad;//$this->input->post('Procedencia', TRUE);
			$Comentario	    = "Actividad Soltada \r";
			$Comentario	   .= "(*) ".$this->tank_auth->get_usernamecomplete()." ";
			$Comentario	   .= "[".$this->tank_auth->get_usermail()."]";
			$bitacoraSicas	= $this->capsysdre_actividades->CrearBitacora($ClaveBit, $Procedencia, $Comentario);

			$StatusUser = $this->capsysdre_actividades->CambiaStatusUser($IDDocto,$posicion);
			
				$dataUpdateActividad['Status'] = $posicion;
				$dataUpdateActividad['usuarioBloqueo'] = "";
				$this->db->where('actividades.idSicas', $IDDocto);
				$this->db->update('actividades', $dataUpdateActividad);
			redirect('actividades/ver/'.$folioActividad);
		}
	}/*! soltaractividad */
	
//------------------------------------------------------------------------------------	
	function viaoficina()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			
			$folio = $this->uri->segment(3); //$this->input->get('IDDocto', TRUE);
			$folioActividad	= strstr($folio, '-', true);
			$IDDocto	= substr(strstr($folio, "-"), 1);
			$ClaveBit	= substr(strstr($IDDocto, "-"), 1);
			$posicion = "2";
			
			//$ClaveBit		= $this->input->post('ClaveBit', TRUE);
			$Procedencia	= "Nube Capsys Web ".$folioActividad;//$this->input->post('Procedencia', TRUE);
			$Comentario	    = "Actividad Via Oficina \r";
			$Comentario	   .= "(*) ".$this->tank_auth->get_usernamecomplete()." ";
			$Comentario	   .= "[".$this->tank_auth->get_usermail()."]";
			$bitacoraSicas	= $this->capsysdre_actividades->CrearBitacora($ClaveBit, $Procedencia, $Comentario);
		
			$StatusUser = $this->capsysdre_actividades->CambiaStatusUser($IDDocto,$posicion);
			
				$dataUpdateActividad['Status'] = $posicion;
				$dataUpdateActividad['usuarioViaOficina'] =  $this->tank_auth->get_usermail();
				$this->db->where('actividades.idSicas', $IDDocto);
				$this->db->update('actividades', $dataUpdateActividad);
			redirect('actividades/ver/'.$folioActividad);
		}
	}/*! viaoficina */
	
//------------------------------------------------------------------------------------	
	function cotizada()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$folio = $this->uri->segment(3); //$this->input->get('IDDocto', TRUE);
			$folioActividad	= strstr($folio, '-', true);
			$IDDocto	= substr(strstr($folio, "-"), 1);
			$ClaveBit	= substr(strstr($IDDocto, "-"), 1);
			$posicion = "1";
						
			//$ClaveBit		= $this->input->post('ClaveBit', TRUE);
			$Procedencia	= "Nube Capsys Web ".$folioActividad;//$this->input->post('Procedencia', TRUE);
			$Comentario	    = "Actividad Cotizada \r";
			$Comentario	   .= "(*) ".$this->tank_auth->get_usernamecomplete()." ";
			$Comentario	   .= "[".$this->tank_auth->get_usermail()."]";
			$bitacoraSicas	= $this->capsysdre_actividades->CrearBitacora($ClaveBit, $Procedencia, $Comentario);
		
			$StatusUser = $this->capsysdre_actividades->CambiaStatusUser($IDDocto,$posicion);
			
				$dataUpdateActividad['Status'] = $posicion;
				$dataUpdateActividad['usuarioCotizador'] = $this->tank_auth->get_usermail();
				$this->db->where('actividades.idSicas', $IDDocto);
				$this->db->update('actividades', $dataUpdateActividad);
			redirect('actividades/ver/'.$folioActividad);
		}
	}/*! cotizada */
	
//--------------------------------------------------------------------------	
	function testws()
	{
		echo "<pre>";
		print_r($this->capsysdre_actividades->DetalleDocumento('75507'));
		echo "</pre>";
		//$infoDocumento	= $this->capsysdre_actividades->DetalleDocumento('75507');
	}/*! testws */
	
//--------------------------------------------------------------------------	
	function agregarDocumento_test()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			
			if ($_FILES['DocumentoFiles']["error"] > 0){
				echo "<pre>";
				print_r($_FILES);
				echo "<br />";
				echo "Error: " . $_FILES['DocumentoFiles']['error'] . "<br>";
				echo "</pre>";
			} else {
				echo "<pre>";
				print_r($_FILES);
				echo "<br />";
				$nameFileSicas = str_replace(' ','_',$this->input->post('tipoImg_0', TRUE));
				$nameFileSicas.= "-".strtoupper($this->input->post('descripcionArchivo', TRUE));
				$nameFileSicas.= "-".date('YmdHi');
				$nameFileSicas.= ".".strrev(strstr(strrev($_FILES['DocumentoFiles']['name']), '.', true));
				echo "<br />";
				echo $nameFileSicas;
				//** $destination	= 'C:\wamp\www\V3Presentacion\assets\img\tmp\\'.$nameFileSicas;
				echo "<br />";
				echo $destination	= '/home/admin/domains/v3prod.capsys.site/public_html/V3/assets/img/tmp/'.$nameFileSicas;
				
				move_uploaded_file($_FILES['DocumentoFiles']['tmp_name'], $destination);
				$ListFilesURL	= base_url().'assets/img/tmp/'.$nameFileSicas;
				
				$TypeDestinoCDigital	= $this->input->post('TypeDestinoCDigital', TRUE);
				$IDValuePK				= $this->input->post('IDValuePK', TRUE);
				$FolderDestino			= $this->input->post('FolderDestino', TRUE);
				$this->capsysdre_actividades->CargarDocumento($TypeDestinoCDigital, $IDValuePK, $ListFilesURL, $FolderDestino);
				echo "</pre>";
			}

			$oldPosicion	= $this->input->post('oldPosicion', TRUE);
			$enviar			= $this->input->post('enviar', TRUE);						
			$folioActividad	= $this->input->post('folioActividad', TRUE);
			
			switch($this->tank_auth->get_userprofile()){
				case 1:
				case 2:
					$posicion = "5";
				break;
				
				case 3:
				case 4:
					$posicion = $enviar; //$oldPosicion;
				break;
				
				case 5:
					$posicion = "1";
				break;
			}

			$IDDocto = $this->input->post('IDDocto', TRUE);			
			if($this->input->post('tipoActividadSicas', TRUE) == "ot"){
				$StatusUser = $this->capsysdre_actividades->CambiaStatusUser($IDDocto,$posicion);
			} else {
				$StatusUserTarea = $this->capsysdre_actividades->CambiaStatusUserTarea($IDDocto,$posicion);
			}

			//** redirect('actividades/ver/'.$folioActividad);
		}
	}/*! agregarDocumento_test */

//--------------------------------------------------------------------------	
	function ver_test()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else if(!$this->uri->segment(3)){ 
			redirect('actividades');
		} else {
			if(!$this->capsysdre_actividades->validacionFolioActividad($this->uri->segment(3))){
				redirect('actividades');
			}
						
			$data['configModulos'] = array( 'modulo' => 'configuraciones');
			$data['SelectTipoImg'] = $this->capsysdre_actividades->SelectTipoImg(0);
			
			$data['infoFolioActividad']		= $this->capsysdre_actividades->infoFolioActividad($this->uri->segment(3));
			$data['infoFolioActividadEmi']	= $this->capsysdre_actividades->infoFolioActividadEmi($this->uri->segment(3));

			$idSicas						= $data['infoFolioActividad']->idSicas;
			if($data['infoFolioActividad']->tipoActividadSicas == "ot"){
				$data['infoDocumento']			= $this->capsysdre_actividades->DetalleDocumento($idSicas);
			} else {
				$data['infoDocumento']			= false;//$this->capsysdre_actividades->DetalleDocumento($idSicas);
			}

			$idCliente						= $data['infoFolioActividad']->idCliente;
			$idContacto						= $data['infoFolioActividad']->idContacto;
			$data['infoCliente']			= $this->capsysdre_actividades->DetalleCliente($idCliente.'-'.$idContacto);
						
			$claveBit						= $data['infoFolioActividad']->ClaveBit;
			$data['verBitacoraActividad'] 	= $this->capsysdre_actividades->InfoBitacoras($claveBit);
			
			//$TypeDestinoCDigital = "DOCUMENT";
			//$IDValuePK = $data['infoFolioActividad']->idSicas;
			if($data['infoFolioActividad']->tipoActividadSicas == "ot"){
				$TypeDestinoCDigital	= "DOCUMENT";
				$IDValuePK				= $data['infoFolioActividad']->idSicas;
			} else {
				$TypeDestinoCDigital	= "CLIENT";
				$IDValuePK				= $data['infoFolioActividad']->idCliente;
			}
			$data['verDocumentosActividad'] 	= $this->capsysdre_actividades->InfoDocumento($TypeDestinoCDigital, $IDValuePK);

			$data['ckeditor']				= array(
														'id'		=> 	'Comentario',
														'path'		=>	'assets/js/ckeditor',
														'config'	=> array(
																		'width' 	=> 	"99%",		//Setting a custom width
																		'height' 	=> 	'100px',	//Setting a custom height
																		'toolbar' 	=> 	array(		
																								//Setting a custom toolbar
																								'/'
																							  )
																	   )
											  );			
			$data['configModulos'] = $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());
			
			$this->load->view('actividades/verTest', $data);
		}
	}/*! ver_test */
	
//--------------------------------------------------------------------------
	function traeCompaniaPorSubRamo()
	{
		$data['companias']=$this->capsysdre_actividades->obtenerCompaniasSubRamo($_GET['idSubRamo']);	
		echo json_encode($data);
	}/*! traeCompaniaPorSubRamo */
	
//--------------------------------------------------------------------------
	function traeSubRamo()
	{	       
		$subRamos=$this->capsysdre_actividades->subRamos($_REQUEST["actividad"],$_REQUEST["ramo"]);
		$data['subRamos']	= $subRamos->result();

		echo json_encode($data);
	}/*! traeSubRamo */

//--------------------------------------------------------------------------
	function ExportaHistorial()
	{

	//$mysqli = new mysqli('localhost','root','','capsysv3');

	$mysqli = new mysqli('www.capsys.com.mx','root','viki52','capsysV3');

	$correoProcedente=$this->tank_auth->get_usermail();

   	$fecha = date("d-m-Y");
   	$consulta= "select * from `actividades` act
	left join users us on act.usuarioVendedor =us.email
	where act.usuarioVendedor='".$correoProcedente."'
	or
	act.usuarioCreacion='".$correoProcedente."'
   	";

   	$resultado= $mysqli->query($consulta);

  

	//Inicio de la instancia para la exportaciÃ³n en Excel
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition: attachment; filename=Listado_$fecha.xls");
	header("Pragma: no-cache");
	header("Expires: 0");

	echo "<table border=1> ";
	echo "<tr> ";
	echo     "<th>IdInterno</th> ";
	echo 	"<th>folioActividad</th> ";
	echo 	"<th>idSicas</th> ";
	echo 	"<th>NumSolicitud</th> ";
	echo 	"<th>Documento</th> ";
	echo 	"<th>idSicas</th> ";
	echo 	"<th>Status</th> ";
	echo 	"<th>Status_Txt</th> ";
	echo 	"<th>tipoActividadSicas</th> ";
	echo 	"<th>idCliente</th> ";
	echo 	"<th>nombreCliente</th> ";

	echo 	"<th>tipoActividad</th> ";
	echo 	"<th>ramoActividad</th> ";
	echo 	"<th>subRamoActividad</th> ";
	echo 	"<th>actividadUrgente_Txt</th> ";
	echo 	"<th>usuarioCreacion</th> ";
	echo 	"<th>usuarioVendedor</th> ";
	echo 	"<th>usuarioResponsable</th> ";
	echo 	"<th>usuarioBolita</th> ";
	echo 	"<th>usuarioBloqueo</th> ";
	echo 	"<th>usuarioCotizador</th> ";

	echo 	"<th>nombreUsuarioCreacion</th> ";
	echo 	"<th>nombreUsuarioVendedor</th> ";
	echo 	"<th>nombreUsuarioResponsable</th> ";
	echo 	"<th>nombreUsuarioCotizador</th> ";

	echo 	"<th>fechaCreacion</th> ";
	echo 	"<th>Satisfaccion Cotizacion</th> ";
	echo 	"<th>Satisfaccion Emision</th> ";
	echo 	"<th>name_complete</th> ";


	echo "</tr> ";

	while($row = mysqli_fetch_array($resultado)){	
	$idInterno = $row['idInterno'];
	$folioActividad = $row['folioActividad'];
	$idSicas = $row['idSicas'];
	$NumSolicitud = $row['NumSolicitud'];
	$Documento = $row['Documento'];
    $idSicas = $row['idSicas'];
	$Status = $row['Status'];
	$Status_Txt = $row['Status_Txt'];
	$tipoActividadSicas = $row['tipoActividadSicas'];
	$idCliente = $row['idCliente'];
	$nombreCliente = $row['nombreCliente'];
	$tipoActividad = $row['tipoActividad'];
	$ramoActividad = $row['ramoActividad'];
	$subRamoActividad = $row['subRamoActividad'];
	$actividadUrgente_Txt = $row['actividadUrgente_Txt'];
	$usuarioCreacion = $row['usuarioCreacion'];
	$usuarioVendedor = $row['usuarioVendedor'];
	$usuarioResponsable = $row['usuarioResponsable'];
	$usuarioBolita = $row['usuarioBolita'];
	$usuarioBloqueo = $row['usuarioBloqueo'];
	$usuarioCotizador = $row['usuarioCotizador'];
	$nombreUsuarioCreacion = $row['nombreUsuarioCreacion'];
	$nombreUsuarioVendedor = $row['nombreUsuarioVendedor'];
	$nombreUsuarioResponsable = $row['nombreUsuarioResponsable'];
	$nombreUsuarioCotizador = $row['nombreUsuarioCotizador'];

	$fechaCreacion = $row['fechaCreacion'];
	$satisfaccion = $row['satisfaccion'];
	$satisfaccionEmision = $row['satisfaccionEmision'];
	$name_complete = $row['name_complete'];



	echo    "<tr> ";
	echo 	"<td HEIGHT=20>".$idInterno."</td> "; 
	echo 	"<td HEIGHT=20>".$folioActividad."</td> "; 
	echo 	"<td HEIGHT=20>".$idSicas."</td> "; 
	echo 	"<td HEIGHT=20>".$NumSolicitud."</td> "; 
	echo 	"<td HEIGHT=20>".$Documento."</td> "; 
	echo 	"<td HEIGHT=20>".$idSicas."</td> "; 
	echo 	"<td HEIGHT=20>".$Status."</td> "; 
	echo 	"<td HEIGHT=20>".$Status_Txt."</td> "; 
	echo 	"<td HEIGHT=20>".$tipoActividadSicas."</td> ";  
	echo 	"<td HEIGHT=20>".$idCliente."</td> "; 
	echo 	"<td HEIGHT=20>".$nombreCliente."</td> "; 

	echo 	"<td HEIGHT=20>".$tipoActividad."</td> "; 
	echo 	"<td HEIGHT=20>".$ramoActividad."</td> "; 
	echo 	"<td HEIGHT=20>".$subRamoActividad."</td> "; 
	echo 	"<td HEIGHT=20>".$actividadUrgente_Txt."</td> "; 
	echo 	"<td HEIGHT=20>".$usuarioCreacion."</td> "; 
	echo 	"<td HEIGHT=20>".$usuarioVendedor."</td> "; 
	echo 	"<td HEIGHT=20>".$usuarioResponsable."</td> "; 
	echo 	"<td HEIGHT=20>".$usuarioBolita."</td> "; 
	echo 	"<td HEIGHT=20>".$usuarioBloqueo."</td> "; 
	echo 	"<td HEIGHT=20>".$usuarioCotizador."</td> "; 

	echo 	"<td HEIGHT=20>".$nombreUsuarioCreacion."</td> "; 
	echo 	"<td HEIGHT=20>".$nombreUsuarioVendedor."</td> "; 
	echo 	"<td HEIGHT=20>".$nombreUsuarioResponsable."</td> "; 
	echo 	"<td HEIGHT=20>".$nombreUsuarioCotizador."</td> "; 

	echo 	"<td HEIGHT=20>".$fechaCreacion."</td> "; 
	echo 	"<td HEIGHT=20>".$satisfaccion."</td> ";
	echo 	"<td HEIGHT=20>".$satisfaccionEmision."</td> ";
	echo 	"<td HEIGHT=20>".$name_complete."</td> "; 


	echo    "</tr> ";

	}
	echo "</table> ";
	}/*! */
	
//--------------------------------------------------------------------------
	function importante()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {

			//$IDUserSICAS	= $this->tank_auth->get_IDUserSICAS();
			$usermail						= $this->tank_auth->get_usermail();
			$data['configModulos'] 			= $this->capsysdre->ConfiguracionUsuarios($usermail);
			$data['ActividadesImportantes']	= $this->capsysdre_actividades->ActividadesImportantes($usermail);



			//$data['ActividadesCerrar']			= $this->capsysdre_actividades->devuelveActCerrar($usermail);			
			$datos								= $this->capsysdre_actividades->ActividadesTrabajandoseOperativos($usermail);
			$data['actividadesNoTrabajandose']	= $this->capsysdre_actividades->actividadesNoTrabajandose(null);
			$data['ActividadesTrabajandose']	= $datos['actividades'];//$this->capsysdre_actividades->ActividadesTrabajandoseOperativos($usermail);
			$data['ramos']						= $datos['ramos'];
			$data['bandera']					= 1;



			if($this->tank_auth->get_View()!= "App"){
				$this->load->view('actividades/importante',$data);
			} else {
				$this->load->view('actividades/importanteApp',$data);
			}
		}
	}/*! importante */
	
//--------------------------------------------------------------------------	
	function marcarImportante()
	{
		if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} else {
			
					  
			$folioActividad	= $this->input->get('folioActividad', TRUE); // 'SW22813'; //
			
			$sqlConsultaActividad = "Select `fechaCreacion`,`fechaActualizacion`,`nombreUsuarioResponsable`,`nombreUsuarioVendedor`,`nombreCliente`,`subRamoActividad`,`datosExpres` From `actividades` Where `folioActividad` = '".$folioActividad."'
									";
			$queryConsultaActividad	= $this->db->query($sqlConsultaActividad)->result();

			$fechaCreacion				= $queryConsultaActividad[0]->fechaCreacion;
			$fechaActualizacion			= $queryConsultaActividad[0]->fechaActualizacion;
			$nombreUsuarioResponsable	= $queryConsultaActividad[0]->nombreUsuarioResponsable;
			$nombreUsuarioVendedor		= $queryConsultaActividad[0]->nombreUsuarioVendedor;
			$nombreCliente				= $queryConsultaActividad[0]->nombreCliente;
			$subRamoActividad			= $queryConsultaActividad[0]->subRamoActividad;
			$datosExpres				= $queryConsultaActividad[0]->datosExpres;
			
			/* Send Mail */
			$message	= "<strong>Informacion de la Actividad</strong>
			<br>
			<strong>Actividad: </strong>  (".$folioActividad.")
			<br>
			<strong>Fecha Creaci&oacute;n Actividad: </strong> ".$fechaCreacion." <strong>Fecha Actualizaci&oacute;n Actividad: </strong> ".$fechaActualizacion."
			<br>
			<hr>
			<br />
			&nbsp;&nbsp;&nbsp;<strong>Responsable:</strong>&nbsp; ".$nombreUsuarioResponsable." 
			<br />
			&nbsp;&nbsp;&nbsp;<strong>Agente:</strong>&nbsp; ".$nombreUsuarioVendedor." 
			<br />
			&nbsp;&nbsp;&nbsp;<strong>Nombre Cliente:</strong>&nbsp; ".$nombreCliente." &nbsp;<strong>SubRamo:</strong>&nbsp; ".$subRamoActividad."
			<br />
			&nbsp;&nbsp;&nbsp;<strong>Datos:</strong>
			<br />
			&nbsp;&nbsp;&nbsp;".$datosExpres."
			<br /><br />
			<hr>
			<br />";
					  $correos=$this->db->query('select u.email from personapermisorelacion ppr left join users u on u.idPersona=ppr.idPersona where ppr.idPersonaPermiso=7')->result();
			  foreach($correos as $value){
			  	$insertCorreo="insert into envio_correos(fechacreacion,desde,para,copia,copiaoculta,asunto,mensaje,status,fechaenvio,identificaModulo)";
			$insertCorreo=$insertCorreo.'values(now(), "Buzon de quejas<avisosgap@aserorescpital.com>","'.$value->email.'",0,0,"Actividad Importante","la actividad ['.$folioActividad.'] Escalo a Importante: '.$message.'",0,now(),"Actividad Importante");';
			
			 $this->db->query($insertCorreo);
			  	 
			  }	

			

			
				// Actualizamos la Actividad
				$sqlMarImport = "Update `actividades` Set `actividadImportante` = '1' Where `folioActividad` = '".$folioActividad."'";
				$this->db->query($sqlMarImport);
			
			
			redirect('/actividades/');
		}
	}/* marcarImportante */

//--------------------------------------------------------------------------	
	function marcarImportante2()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$config	= Array(
						'protocol' => 'smtp',
						'smtp_host' => 'mail.agentecapital.com',
						'smtp_port' => 587,
						'smtp_user' => 'desarrollo@agentecapital.com', 
						'smtp_pass' => 'omarceja2018', 
						'mailtype' => 'html',
						'charset' => 'iso-8859-1',
						'wordwrap' => TRUE
					  );
			$this->load->library('email', $config);
					  
			$folioActividad	= $this->input->get('folioActividad', TRUE); // 'SW22813'; //
			
			$sqlConsultaActividad = "Select `fechaCreacion`,`fechaActualizacion`,`nombreUsuarioResponsable`,`nombreUsuarioVendedor`,`nombreCliente`,`subRamoActividad`,`datosExpres` From `actividades` Where `folioActividad` = '".$folioActividad."'
									";
			$queryConsultaActividad	= $this->db->query($sqlConsultaActividad)->result();

			$fechaCreacion				= $queryConsultaActividad[0]->fechaCreacion;
			$fechaActualizacion			= $queryConsultaActividad[0]->fechaActualizacion;
			$nombreUsuarioResponsable	= $queryConsultaActividad[0]->nombreUsuarioResponsable;
			$nombreUsuarioVendedor		= $queryConsultaActividad[0]->nombreUsuarioVendedor;
			$nombreCliente				= $queryConsultaActividad[0]->nombreCliente;
			$subRamoActividad			= $queryConsultaActividad[0]->subRamoActividad;
			$datosExpres				= $queryConsultaActividad[0]->datosExpres;
			
			/* Send Mail */
			$message	= "<strong>Informacion de la Actividad</strong>
			<br>
			<strong>Actividad: </strong>  (".$folioActividad.")
			<br>
			<strong>Fecha Creaci&oacute;n Actividad: </strong> ".$fechaCreacion." <strong>Fecha Actualizaci&oacute;n Actividad: </strong> ".$fechaActualizacion."
			<br>
			<hr>
			<br />
			&nbsp;&nbsp;&nbsp;<strong>Responsable:</strong>&nbsp; ".$nombreUsuarioResponsable." 
			<br />
			&nbsp;&nbsp;&nbsp;<strong>Agente:</strong>&nbsp; ".$nombreUsuarioVendedor." 
			<br />
			&nbsp;&nbsp;&nbsp;<strong>Nombre Cliente:</strong>&nbsp; ".$nombreCliente." &nbsp;<strong>SubRamo:</strong>&nbsp; ".$subRamoActividad."
			<br />
			&nbsp;&nbsp;&nbsp;<strong>Datos:</strong>
			<br />
			&nbsp;&nbsp;&nbsp;".$datosExpres."
			<br /><br />
			<hr>
			<br />";
			
			$to			= "";
			$sqlCorreosImportante = "
				Select
					`correo` 
				From 
					`catalog_correosImportantes`
				Where
					1
									";
			$queryCorreosImportante = $this->db->query($sqlCorreosImportante);
			foreach($queryCorreosImportante->result() as $rowCorreo){
				$to .= $rowCorreo->correo.", ";
			}
			
			$this->email->from('Capsys Web<do-not-reply@capsys.com.mx>');
			$this->email->to($to);
			$this->email->subject("Actividad Importante ".$folioActividad);
			$this->email->message($message);
			//  $this->email->attach('C:\Users\xyz\Desktop\images\abc.png');
			//--> $this->email->send();

			/* Send Mail */

			if($this->email->send()){
				// Actualizamos la Actividad
				$sqlMarImport = "
					Update
						`actividades`
					Set
						`actividadImportante` = '1'
					Where
						`folioActividad` = '".$folioActividad."'
								";
				$this->db->query($sqlMarImport);
			}
			
			redirect('/actividades/');
		}
	}/* marcarImportante2 */
	
//--------------------------------------------------------------------------	
	function desmarcarImportante()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$config	= Array(
						'protocol' => 'smtp',
						'smtp_host' => 'mail.agentecapital.com',
						'smtp_port' => 587,
						'smtp_user' => 'desarrollo@agentecapital.com', 
						'smtp_pass' => 'omarceja2018', 
						'mailtype' => 'html',
						'charset' => 'iso-8859-1',
						'wordwrap' => TRUE
					  );
			$this->load->library('email', $config);
					  
			$folioActividad	= $this->input->get('folioActividad', TRUE); // 'SW22813'; //
			
			$sqlConsultaActividad = "
				Select
					`fechaCreacion`,
					`fechaActualizacion`,
					`nombreUsuarioResponsable`,
					`nombreUsuarioVendedor`,				
					`nombreCliente`,
					`subRamoActividad`,
					`datosExpres`
				From
					`actividades`
				Where
					`folioActividad` = '".$folioActividad."'
									";
			$queryConsultaActividad	= $this->db->query($sqlConsultaActividad)->result();

			$fechaCreacion				= $queryConsultaActividad[0]->fechaCreacion;
			$fechaActualizacion			= $queryConsultaActividad[0]->fechaActualizacion;
			$nombreUsuarioResponsable	= $queryConsultaActividad[0]->nombreUsuarioResponsable;
			$nombreUsuarioVendedor		= $queryConsultaActividad[0]->nombreUsuarioVendedor;
			$nombreCliente				= $queryConsultaActividad[0]->nombreCliente;
			$subRamoActividad			= $queryConsultaActividad[0]->subRamoActividad;
			$datosExpres				= $queryConsultaActividad[0]->datosExpres;
			
			/* Send Mail */
			$message	= "<strong>Informacion de la Actividad</strong>
			<br>
			<strong>Actividad: </strong>  (".$folioActividad.")
			<br>
			<strong>Fecha Creaci&oacute;n Actividad: </strong> ".$fechaCreacion." <strong>Fecha Actualizaci&oacute;n Actividad: </strong> ".$fechaActualizacion."
			<br>
			<hr>
			<br />
			&nbsp;&nbsp;&nbsp;<strong>Responsable:</strong>&nbsp; ".$nombreUsuarioResponsable." 
			<br />
			&nbsp;&nbsp;&nbsp;<strong>Agente:</strong>&nbsp; ".$nombreUsuarioVendedor." 
			<br />
			&nbsp;&nbsp;&nbsp;<strong>Nombre Cliente:</strong>&nbsp; ".$nombreCliente." &nbsp;<strong>SubRamo:</strong>&nbsp; ".$subRamoActividad."
			<br />
			&nbsp;&nbsp;&nbsp;<strong>Datos:</strong>
			<br />
			&nbsp;&nbsp;&nbsp;".$datosExpres."
			<br /><br />
			<hr>
			<br />";
			
			$to			= "";
			$sqlCorreosImportante = "
				Select
					`correo` 
				From 
					`catalog_correosImportantes`
				Where
					1
									";
			$queryCorreosImportante = $this->db->query($sqlCorreosImportante);
			foreach($queryCorreosImportante->result() as $rowCorreo){
				$to .= $rowCorreo->correo.", ";
			}
			
			$this->email->from('Capsys Web<do-not-reply@capsys.com.mx>');
			$this->email->to($to);
			$this->email->subject("Actividad Des-Importante ".$folioActividad);
			$this->email->message($message);
			//  $this->email->attach('C:\Users\xyz\Desktop\images\abc.png');
			//--> $this->email->send();

			/* Send Mail */

			if($this->email->send()){
				// Actualizamos la Actividad
				$sqlMarImport = "
					Update
						`actividades`
					Set
						`actividadImportante` = '0'
					Where
						`folioActividad` = '".$folioActividad."'
								";
				$this->db->query($sqlMarImport);
			}
			
			redirect('/actividades/importante/');

		}
	}/* desmarcarImportante */
	
//--------------------------------------------------------------------------	
	function correosImportantes()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['listaCorreos'] = $this->db->query("Select * From `catalog_correosImportantes` Order By `nombre` Asc")->result();
			$this->load->view('actividades/correosImportantes', $data);
		}
	}/*! correosImportantes */
	
//--------------------------------------------------------------------------	
	function editarCorreoImportante()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$correo_id = $this->uri->segment(3, 0);
			
			if ($this->uri->segment(3) === FALSE){
				//$banner_id = 0;
				redirect('/actividades/correosImportantes/');
			} else {
				$data['correo_id'] = $correo_id = $this->uri->segment(3);
				$sqlCorreo = "
					Select * From 
						`catalog_correosImportantes`
					Where
						`idCorreo` = ".$correo_id."
							 ";
				$queryCorreo = $this->db->query($sqlCorreo);
				$data['correo_info'] = $queryCorreo->result();
				
				$this->load->view('actividades/editarCorreoImportante', $data);
			}
		}
	}/*! editarCorreoImportante */
	
//--------------------------------------------------------------------------
	function GuardarCorreoImportante()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$idCorreo	= $this->input->post('idCorreo', TRUE);
			$nombre		= $this->input->post('nombre', TRUE);
			$correo		= $this->input->post('correo', TRUE);
			
			if(!isset($idCorreo)){
				redirect('/actividades/correosImportantes/');
			} else {
									
				$sqlUpdate = "
					Update
						`catalog_correosImportantes`
					Set
						`nombre` = '".$nombre."',
						`correo` = '".$correo."'
					Where
						`idCorreo` = ".$idCorreo."
							 ";
				$this->db->query($sqlUpdate);

				redirect('/actividades/correosImportantes/');
			}
		}
	}/*! GuardarCorreoImportante */

//--------------------------------------------------------------------------	
	function NewCorreoImportante()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$sqlNewCorreo = "
				Insert Into
					`catalog_correosImportantes`
					(`nombre`)
					Values
					('');
							";
			$this->db->query($sqlNewCorreo);
			$idCorreo = $this->db->insert_id();
			
			redirect('/actividades/editarCorreoImportante/'.$idCorreo);

		}
	}/*! NewCorreoImportante */
	
//--------------------------------------------------------------------------	
	function eliminarCorreoImportante()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$correo_id = $this->uri->segment(3, 0);
			
			if ($this->uri->segment(3) === FALSE){
				redirect('/actividades/correosImportantes/');
			} else {
				$sqlDeleteCorreo = "
					Delete From 
						`catalog_correosImportantes`
					Where
						`idCorreo` = '".$correo_id."'
								   ";
				$this->db->query($sqlDeleteCorreo);
				redirect('/actividades/correosImportantes/');
			}
		}
	}/*! eliminarCorreoImportante */
	
//--------------------------------------------------------------------------
	function guardaMontosPromotoria()
	{

$identificador=explode(';',$_POST['identificadorValor']);

foreach ($identificador as  $value) {
	if($value!=''){
		$valores=explode('-',$value);
		$array['idRelActividadPromotoria']=$valores[0];
		if(is_numeric($valores[1])){
        $array['montoRAP']=$valores[1];}
        else{$array['montoRAP']=0;}
        $array['update']='';
		$respuesta=$this->capsysdre_actividades->relactividadpromotoria($array);
		
	}
}
    $direccion='Location:'.base_url()."actividades/ver/".$_POST['folio'];
    header($direccion);

	}/*! guardaMontosPromotoria */ 

//--------------------------------------------------------------------------
	function trabajarActividad()
	{
	$consulta['idInterno']=$_POST['idInterno'];
	$actividades=$this->capsysdre_actividades->actividades($consulta);
	$idPersona=$this->tank_auth->get_idPersona(); 
	$respuesta['mensaje']="";
	if($_POST['status']=='false'){
      if($idPersona==$actividades[0]->idPersonaTrabaja)
      {
	  $consulta['idPersonaTrabaja']=0;
      $consulta['trabajandoseActividad']=0;
      $consulta['update']=1;
      $respuesta['status']=false;
      $respuesta['mensaje']='Dejaste de trabajar la actividad';
      $actividadCambio=$this->capsysdre_actividades->actividades($consulta);
       $actividadPartida['folioActividad']=$actividadCambio[0]->folioActividad;
      $actividadPartida['status']=$actividadCambio[0]->Status;
      $actividadPartida['usuarioBolita']=$actividadCambio[0]->usuarioBolita;
      $actividadPartida['idInterno']=$actividadCambio[0]->idInterno;
      $actividadPartida['idPersonaTrabaja']=$actividades[0]->idPersonaTrabaja;
      $actividadPartida['idPartida']=-1;
      $fecha=getdate();     
      $actividadPartida['fechaGrabado']=$fecha['year'].'-'.$fecha['mon'].'-'.$fecha['mday'].' '.$fecha['hours'].':'.$fecha['minutes'].':'.$fecha['seconds'];//'2019-12-04 16:07:43';

      $this->capsysdre_actividades->actividadespartidas($actividadPartida);

      }
      else{
      $respuesta['status']=true;
      $respuesta['mensaje']='No puedes dejar una actividad tomada por otro';
      }
	}
	else{     
	if($actividades[0]->idPersonaTrabaja==0){
     $tieneTrabajandose=$this->capsysdre_actividades->cantidadActividadesTrabajandose($idPersona);
	 
	 if($tieneTrabajandose[0]->cantidad==0){
      $consulta['idPersonaTrabaja']=$idPersona;
      $consulta['trabajandoseActividad']=1;
      $consulta['update']=1;
      $respuesta['status']=true;
      $respuesta['mensaje']='Empezaste a trabajar la actividad';
      $actividades=$this->capsysdre_actividades->actividades($consulta);
      $actividadPartida['folioActividad']=$actividades[0]->folioActividad;
      $actividadPartida['status']=8;
      $actividadPartida['usuarioBolita']=$actividades[0]->usuarioBolita;
      $actividadPartida['idInterno']=$actividades[0]->idInterno;
      $actividadPartida['idPersonaTrabaja']=$idPersona;
      $actividadPartida['idPartida']=-1;
      $fecha=getdate();
     
      $actividadPartida['fechaGrabado']=$fecha['year'].'-'.$fecha['mon'].'-'.$fecha['mday'].' '.$fecha['hours'].':'.$fecha['minutes'].':'.$fecha['seconds'];//'2019-12-04 16:07:43';
      $this->capsysdre_actividades->actividadespartidas($actividadPartida);
      $respuesta['usuarioResponsable']=$actividades[0]->usuarioResponsable;
      $respuesta['usuarioTrabaja']=$this->tank_auth->get_usermail();
      $respuesta['folioActividad']=$actividades[0]->folioActividad;

     }else{
     	 $respuesta['status']=false;
     	 $respuesta['mensaje']="No puedes tener dos actividades trabajandose al mismo tiempo";

     }
   }
   else{
	if($idPersona==$actividades[0]->idPersonaTrabaja){
	
    }
 }
 }
	$respuesta['idInterno']=$_POST['idInterno'];
	echo json_encode($respuesta);
	}/*! trabajarActividad */

//--------------------------------------------------------------------------
	function pruebaO()
	{
		//$this->ws_sicas->obtenerDatosAgente(1);
		$select['IDCli']='-1';
		$select['update']="";
		$select['ApellidoP']="cejas";
		$select['ApellidoM']="mendoza";
		$datos=$this->clientemodelo->cientes_actualiza($select);
		//
	}/*! pruebaO */

//--------------------------------------------------------------------------
	function buscaDocumento()
	{
 	/*BUSCA DOCUMENTO*/

    
    /*ACTUALIZA  LA OT*/
    /*$array['IDDocto']='121291';
    $array['DPosterior']='Va';
    $info=$this->ws_sicas->actualizaOT($array);*/
    // $info=$this->ws_sicas->obtenerCobranzaEfectuadaPorFolio('0880265493',0);
     //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($info,TRUE));fclose($fp);
/*OT-0000040608  121316 ; OT-0000040615 121324*/

     //$info1=$this->ws_sicas->obtenerDocumentoPorId('121291');
       $array['IDDoctoSoure']='121291';
       $array['OpcionesCobranza']=0;
       $info=$this->ws_sicas->renovacionPoliza($array);
     
     

  // $array['IDDocto']=-1;
   /* $array['IDDocto']=121324;
    $array['TipoDocto']=0;
    $array['IDCli']=(string)$info1->TableInfo->IDCli;
    $array['IDDir']=-1;
    $array['IDGrupo']=1;
    $array['IDAgente']=1;
    $array['IDFPago']=1;
    $array['IDMon']=1;
    $array['IDSRamo']=17;
    $array['IDEjecut']=2;
    $array['IDVend']=(string)$info1->TableInfo->IDVend;
    $array['FDesde']='05/11/2019';
    $array['FHasta']='05/11/2020';
    $array['Status']=0;
    $array['Referencia3']='';
    $array['StatusUser']=5;
    $array['PrimaNeta']=0;
    $array['STotal']=0;
    $array['PrimaTotal']=0;
    $array['Concepto']='Cotizacion prueba de sistemas';
    $array['APDP']=0;
    $array['CCP']=0;
    $array['CCE']=0;
    $array['DAnterior']='0880265493';*/
   //$otNueva=$this->ws_sicas->actualizaOT($array);

 
    /* $arrayDocumento['IDDocto']='121291';
     $arrayDocumento['DPosterior']=$otNueva['NumSolicitud'];*/
   // $info=$this->ws_sicas->actualizaOT($arrayDocumento);

/*$array['IDDocto']='121236';
    $array['DPosterior']='Va';
    $info=$this->ws_sicas->actualizaOT($array);*/

    /*$actividadSicas = $this->capsysdre_actividades->CrearOt('SW275190000','20810');//++	
    $idSicas		= $actividadSicas[0]->NewIDValue;//IDDocto
	$ClaveBit		= $actividadSicas[0]->ClaveBit;//++
	$NumSolicitud	= $actividadSicas[0]->NumSolicitud;//ES LA OT*/
   
           
	}/*! buscaDocumento */
	
//--------------------------------------------------------------------------
	function updateClient()
	{
		
		//echo json_encode($_REQUEST);
		$IdCli			= $_REQUEST["idcli"];
		$Nombre			= $_REQUEST["nombre"];
		$ApellidoP		= $_REQUEST["apellidoP"];
		$ApellidoM		= $_REQUEST["apellidoM"];
		$FechaNac		= $_REQUEST["fechaNac"];
		$Edad			= $_REQUEST["edad"];
		$Sexo			= $_REQUEST["sexo"];
		$TipEnt			= $_REQUEST["tipoEntidad"];
		$RazonSoc		= $_REQUEST["razonSocial"];
		$FechaCons		= $_REQUEST["fechaCons"];
		$IDCont			= $_REQUEST["idcont"];
		$RFC			= $_REQUEST["rfc"];
		$Telefono1		= $_REQUEST["telefono1"];		
		$Email1			= $_REQUEST["email1"];
		$Contactos		= json_decode($_REQUEST["contactos"]);
		$Direcciones	= json_decode($_REQUEST["direcciones"]);
		#$Alias 		= $_REQUEST["alias"];
		#$Ejecutivo		= $_REQUEST["ejecutivoc"]; /* */
		#$SubGrupo		= $_REQUEST["subgrupo"]; /* */
		#$Grupo			= $_REQUEST["grupo"]; /* */
		$Expediente		= $_REQUEST["Expediente"]; /* JjHe */
		$ClaveTKM		= $_REQUEST["ClaveTKM"]; /* JjHe */
		$ObsSalud		= "Actualizacion:".date('d-m-Y')." [".$this->tank_auth->get_usermail()."]"; /* JjHe */
		$ctos			= array();
		$res			= '';
		$folioActividad	= $_REQUEST["folioActividad"];
		
	//var_dump($_REQUEST);
	
		foreach ($Contactos as $key => $value){
			
			$Teles	= explode(':', $value->Telefono1);
			$Tel	= count($Teles) > 1? 'Telefono1|'.$Teles[1] : 'Telefono1|'.$Teles[0]; 
            
			if($value->IDCont == -1){
				$datos	= array(
							"CatContactos"	=> array(
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
							"CatRelCont"	=> array(
												"IDRel"		=> $IdCli,
												"IDRelCont"	=> "-1"
											   ),
                		  );
				$data	= array(
							"datos"			=> $datos,
							"KeyCode"		=> 'HCONTACT',
							"TipoEntidad"	=> '16',  
							"IDRelation"	=> $IdCli,
							"Param3"		=> '0',
						  );
			} else {
				$datos	= array(
							"CatContactos" => array(
												"IDCont"		=> $value->IDCont,
												"Nombre"		=> $value->Nombre,
												"ApellidoP"		=> $value->ApellidoP,
												"ApellidoM"		=> $value->ApellidoM,
												"Abreviacion"	=> $value->Alias,
												#"Sexo"         => $value->Sexo,
												#"FechaNac"     => $value->FechaNac,
                                    			#"Edad"			=> $value->Edad,
												"EMail1"		=> $value->Email1,
												"Telefono1"    	=> $Tel,
												"Calidad"		=> 'Cliente'
											   ),
							"CatClientes"  => array(
                                    "IDCli"     => $IdCli,
											   ),
                		  );
				$data	= array(
							"datos"			=> $datos,
							"KeyCode"		=> 'HDATACONTACT',
							"TipoEntidad"	=> '0',
							"IDRelation"	=> '0',
							"Param3"		=> '0',
						  );
			}
            
		//	echo '<pre>';
		//	print_r($data);
			
			$res = $this->webservice_sicas_soap->UpdateContacto($data);
		}

		foreach ($Direcciones as $key => $value){
			$Teles =  explode(':', $value->Telefono1);

			$Tel = count($Teles) > 1? 'Telefono1|'.$Teles[1] : 'Telefono1|'.$Teles[0]; 
			$Teles2 =  explode(':', $value->Telefono2);

			$Tel2 = count($Teles2) > 1? 'Telefono2|'.$Teles2[1] : 'Telefono2|'.$Teles2[0]; 

			if($value->IDDir == -1){
				$datos	= array(
					"CatDirecciones"	=> array(
											"IDDir"     => '-1',
											"Calle"     => $value->Calle,
											"NOExt"		=> $value->NOExt,
											"NOInt"		=> $value->NOInt,
											"CPostal"	=> $value->CPostal,
											"Colonia"	=> $value->Colonia,
											"Poblacion"	=> $value->Poblacion,
											"Ciudad"	=> $value->Ciudad,
											"Pais"      => $value->Pais,
											"Telefono1"	=> $Tel,
											"Telefono2" => $Tel2,
											"TipoDir"	=> "FISCAL",
										   ),
					"CatRelDir"			=> array(
											"IDRelation"=> '-1',
											"IDRel"		=> $IdCli,
										   ),
						 );

				$data	= array(
					"datos"			=> $datos,
					"KeyCode"		=> 'HADDRESS',
					"TipoEntidad"	=> '15',  
					"IDRelation"	=> $IdCli,
					"Param3"		=> $IdCli,
						 );
			} else {
				$datos = array(
					"CatDirecciones"	=> array(
											"IDDir"		=> $value->IDDir,
											"Calle"		=> $value->Calle,
											"NOExt"		=> $value->NOExt,
											"NOInt"		=> $value->NOInt,
											"CPostal"	=> $value->CPostal,
											"Colonia"	=> $value->Colonia,
											"Poblacion"	=> $value->Poblacion,
											"Ciudad"	=> $value->Ciudad,
											"Pais"		=> $value->Pais,
											"Telefono1"	=> $Tel,
											"Telefono2"	=> $Tel2,
										   ),
					"CatRelDir"			=> array(
											"IDRel"     => $IdCli,
										   ),
						 );

				$data	= array(
					"datos"			=> $datos,
					"KeyCode"		=> 'HADDRESS',
					"TipoEntidad"	=> '0',
					"IDRelation"	=> '0',
					"Param3"		=> '0',
						 );
			}
			
		//	echo '<pre>';
		//	print_r($data);
			
//			$res = $this->webservice_sicas_soap->UpdateContacto($data);
			$res = $this->UpdateContacto($data);
        }

		$Tels	= explode(':', $Telefono1);
		
		if($TipEnt == "0"){
        	$RazonSoc	= "";
        	$FechaCons	= "";
        }

		$datos	= array(
					"CatContactos"	=> array(
										"IDCont"		=> $IDCont,
										"TipoEnt"		=> $TipEnt,
										"RazonSocial"	=> $RazonSoc,
										"FechaConst"	=> $FechaCons,
										"Nombre"		=> $Nombre,
										"ApellidoP"		=> $ApellidoP,
										"ApellidoM"		=> $ApellidoM,
										"FechaNac"		=> $FechaNac,
										"Edad"			=> $Edad,
										"Sexo"      	=> $Sexo,
										"RFC"       	=> $RFC,
										"Telefono1" 	=> count($Tels) > 1 ? 'Telefono1|'.$Tels[1] : 'Telefono1|'.$Tels[0],
										"Email1"    	=> $Email1,
										"Expediente"	=> $Expediente, /* JjHe */
										"ClaveTKM"		=> $ClaveTKM, /* JjHe */
										"ObsSalud"		=> $ObsSalud, /* JjHe */
									   ),

					"CatClientes"	=> array(
										"IDCli"		=> $IdCli,
										"IDGrupo"	=> '1',
										"IDSGrupo"	=> '0'
									   ),
				  );

		$data	= array(
					"datos"			=> $datos,
					"KeyCode"		=> 'HDATACONTACT',
					"TipoEntidad"	=> '0',
					"IDRelation"	=> '0'
				  );
			
		//echo '<pre>';
		//print_r($data);
			
		$res	= $this->UpdateContacto($data);
		$msj	= '';
		
	//	var_dump($res);	
		
		if ($res->DATAINFO->Sucess[0] == "0"){
			$msj = htmlentities($res->DATAINFO->MsgError);
			//** redirect('directorio/registroDetalle?IDCli='.$IdCli.'&msj='.$msj);
			redirect('actividades/ver/'.$folioActividad.'?msj=').$msj;
		} else {
			//** redirect('directorio/registroDetalle?IDCli='.$IdCli);
			redirect('actividades/ver/'.$folioActividad);
		}
	}/*! updateClient */
	
//--------------------------------------------------------------------------
function consultaActividades()
 {  
 	if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');}
    $datos['personas']=$this->personamodelo->obtenerPersonas($this->tank_auth->get_usermail(),null);  
    $personaVendedor=array();
    $condicion='';
    foreach ($datos['personas'] as $value) 
    {
    	if($value->idVend>0)
    	{
    	 $condicion.=$value->idVend.' || ';
    	 array_push($personaVendedor,$value);
    	}

     }
    
   $condicion = substr($condicion, 0, -4);
   $consulta['where']=' and('.$condicion.')';        
    $datos['actividades']=$this->capsysdre_actividades->devolverActividades($consulta);
    $cantActividades=count($datos['actividades']);
    $personaVendedorCant=count($personaVendedor);
    for($i=0;$i<$cantActividades;$i++)
    {
     
      for($j=0;$j<$personaVendedorCant;$j++)
      {
      	if($datos['actividades'][$i]->IDVend==$personaVendedor[$j]->idVend)
      	{
      	 $datos['actividades'][$i]->idPersona=$personaVendedor[$j]->idPersona;
      	 $datos['actividades'][$i]->nombreVendedor=$personaVendedor[$j]->nombres.' '.$personaVendedor[$j]->apellidoPaterno.' '.$personaVendedor[$j]->apellidoMaterno;
      	}

      }	
    }

   
 	$this->load->view('actividades/consultaActividades',$datos);
 }
 //-------------------------------------------------------------------
function devolverActividades()
 {
 	$select['IDVend']=$_POST['idVend'];
 	$respuesta['actividades']=$this->capsysdre_actividades->devolverActividades($select);
 	
 	echo json_encode($respuesta);
 }
//----------------------------------------------------------------
function devolverActividadesPartidas()
{
  $datos=array();
  $respuesta='';
  $fFinal=$this->libreriav3->convierteFecha($_POST['fFinal']);
  $fInicial=$this->libreriav3->convierteFecha($_POST['fInicial']);
  
   $respuesta=$this->capsysdre_actividades->actividadesPartidasPorFecha($fInicial,$fFinal); 
 	

  echo json_encode($respuesta);
}
//---------------------------------------------------------------
function verComentarios()
{
  $select['idInterno']=$_POST['idInterno'];
    
  $claveBit=$this->capsysdre_actividades->devolverActividades($select)[0]->ClaveBit; 
  $respuesta['comentarios']=$this->capsysdre_actividades->InfoBitacoras($claveBit);  
  $respuesta['estadoActividades']=$this->capsysdre_actividades->devolverPartidasActividades($_POST);
  //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($respuesta,TRUE));fclose($fp);  
  echo json_encode($respuesta);

}
//---------------------------------------------------------------

	public function UpdateContacto($data)
	{
		if (is_array($data)){
			$data_body	= array(
							"XML"			=> $data['datos'],
							"TProc"			=> "Save_Data",
							"KeyCode"		=> $data['KeyCode'],
							"IDRelation"	=> $data['IDRelation'],
							"TipoEntidad"	=> $data['TipoEntidad'],
							"Param3"		=> $data['Param3'],
							"KeyProcess"	=> "DATA"
						  );

			$result		= $this->getDatosSICAS($data_body);

			return 
				$result;
		}	
	}/*! UpdateContacto */
	
//--------------------------------------------------------------------------
	function array_to_xml($array, &$xml_user_info) 
	{
	    foreach($array as $key => $value) {
	        if(is_array($value)) {
	            if(!is_numeric($key)){
	                $subnode = $xml_user_info->addChild("$key");
	                $this->array_to_xml($value, $subnode);
	            }else{
	                $subnode = $xml_user_info->addChild("item$key");
	                $this->array_to_xml($value, $subnode);
	            }
	        }else {
	            $xml_user_info->addChild("$key",htmlspecialchars("$value"));
	        }
	    }
	}/*! */
	
//--------------------------------------------------------------------------
	private function encriptaWs($key,$ivPass,$TextPlain)
	{
		if(strlen($key)!=24){
			throw new Exception('La longitud de la key ha de ser de 24 dígitos.<br>'); 
			return -1; 
		} if((strlen($ivPass) % 8 )!=0){ 
			throw new Exception('La longitud del vector iv Passsword ha de ser múltiple de 8 dígitos.<br>'); 
			return -2; 
		} 

		return @base64_encode(mcrypt_encrypt(MCRYPT_3DES, $key, $TextPlain, MCRYPT_MODE_CBC, $ivPass)); 
	}/*! encripta */
	
//--------------------------------------------------------------------------
	public function getDatosSICAS($wsdata)
	{

		$xml	= '<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:tem="http://tempuri.org/"> <soap:Header/> <soap:Body> <ProcesarWS xmlns="http://tempuri.org/"> <oDataWS> <Credentials>';
		
		$xml	= $xml.'<UserName>'.$this->user.'</UserName>';
		$xml	= $xml.'<Password>'.$this->pass.'</Password>';
		$xml	= $xml.'<CodeAuth>'.$this->auth.'</CodeAuth></Credentials>';
		$xml	= $xml.'<CredentialsUserSICAS><UserName>SISTEMAS@ASESORESCAPITAL.COM</UserName>';
		$xml	= $xml.'<Password>ACHAN2019</Password></CredentialsUserSICAS>';
		
		foreach($wsdata as $key => $value){
			$xml	= $xml.'<'.$key.'>'.$value.'</'.$key.'>';
		}
		
		if(isset($wsdata["XML"])){
			$xmlS			= new SimpleXMLElement('<InfoData/>');
			$this->array_to_xml($wsdata['XML'], $xmlS);	
			$xmlData		= $xmlS->asXML();
			$TextEncript	= $this->encriptaWs($this->key, $this->ivPass, $xmlData);

		//print_r($xmlData);
		//print($TextEncript);

			$xml	= $xml.'<DataXML>'.$TextEncript.'</DataXML>';
		}
			
		$xml	= $xml.'</oDataWS> </ProcesarWS> </soap:Body> </soap:Envelope>';

		$headers	= array(
						"POST /SOnlineWSQua/WS_SICASOnline.asmx HTTPS/1.1",
						"Content-Type: text/xml; charset=utf-8",
						"Accept: text/xml","Host: www.sicasonline.info",
                        "Pragma: no-cache",
						"SOAPAction: http://tempuri.org/ProcesarWS",
						"Content-length: ".strlen($xml),
					  );

		$ch			= curl_init();
					curl_setopt($ch, CURLOPT_URL, 'https://www.sicasonline.info:448/SOnlineWS/WS_SICASOnline.asmx?WSDL');
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $xml); // the SOAP request
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
					curl_setopt($ch, CURLOPT_TIMEOUT, 100);
					curl_setopt($ch, CURLOPT_POST, true);
	// converting    

		$response				= curl_exec($ch); 
		$resXmlConsumo			= str_replace($this->DeleteXml, $this->ClearXml, $response);
		$xmlTexto_resXmlConsumo	= htmlspecialchars_decode($resXmlConsumo);
		
            $xmlRespuesta=<<<XML
	$xmlTexto_resXmlConsumo
XML;

		$return	= array();
		$carga_xmlRespuesta	= simplexml_load_string($xmlRespuesta);
     
		curl_close($ch);

		return
			$carga_xmlRespuesta;
	}/*! */

}
/* End of file actividades.php */
/* Location: ./application/controllers/actividades.php *//