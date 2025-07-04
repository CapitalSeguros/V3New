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
			$this->load->library('Webservice_sicas_soap',$params);
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
			  $this->load->model('manejodocumento_modelo');
			  $this->load->model('notificacionmodel');
			  	  $this->load->model('actividades_model');

	}
//----------------------------------------------------------------------------------------------------------------------------------		
	function index()
	{
		if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
		else {
			  $usermail		= $this->tank_auth->get_usermail();						
			  $this->verActividades();			
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
	
//-----------------------------------------------------------
function verActividadesBeta()
{
	if (!$this->tank_auth->is_logged_in()) {
		redirect('/auth/login/');
	} else 
	{

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
		$data['ejecutivos']=$this->db->query('select p.idPersona,u.email from persona p left join users u on u.idPersona=p.idPersona where p.idColaboradorArea=2 and u.activated=1 and u.banned=0')->result();


	  $tipoFiltro="";
	  $valorFiltro="";
	  $arrayVal=array();
	  $stringArray="";
	  foreach ($data['ActividadesTrabajandose'] as $key => $value) 
	  {

		 foreach ($value as $valActividad) 
		 {
			 $val['idInterno']=$valActividad->idInterno;
			  $val['folioActividad']=$valActividad->folioActividad;
			  array_push($arrayVal, $val);
		 }



		  
	  }
		if(isset($_GET['selectTipoFiltro'])){$data['selectTipoFiltro']=$_GET['selectTipoFiltro'];$tipoFiltro=$_GET['selectTipoFiltro'];}
		if(isset($_GET['selectValorFiltro'])){$data['selectValorFiltro']=$_GET['selectValorFiltro'];$valorFiltro=$_GET['selectValorFiltro'];}

	  $insert['emailUser']=$this->tank_auth->get_usermail();
	  $insert['idPersona']=$this->tank_auth->get_idPersona();;
	  $insert['origen']='actividades';
	  $insert['filtro']=$tipoFiltro;
	  $insert['valorFiltro']=$valorFiltro; 
	  $insert['info']=json_encode($arrayVal);
	  $this->db->insert('bitacorarefrescado',$insert);

	  $this->load->view('actividades/verActividadesBeta',$data);
	}
}/*! verActividades */



//-----------------------------------------------------------
function verActividades()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else 
		{

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
			$data['ejecutivos']=$this->db->query('select p.idPersona,u.email from persona p left join users u on u.idPersona=p.idPersona where p.idColaboradorArea=2 and u.activated=1 and u.banned=0')->result();


          $tipoFiltro="";
          $valorFiltro="";
          $arrayVal=array();
          $stringArray="";
          foreach ($data['ActividadesTrabajandose'] as $key => $value) 
          {

             foreach ($value as $valActividad) 
             {
             	$val['idInterno']=$valActividad->idInterno;
          	    $val['folioActividad']=$valActividad->folioActividad;
          	    array_push($arrayVal, $val);
             }



          	
          }
            if(isset($_GET['selectTipoFiltro'])){$data['selectTipoFiltro']=$_GET['selectTipoFiltro'];$tipoFiltro=$_GET['selectTipoFiltro'];}
            if(isset($_GET['selectValorFiltro'])){$data['selectValorFiltro']=$_GET['selectValorFiltro'];$valorFiltro=$_GET['selectValorFiltro'];}

          $insert['emailUser']=$this->tank_auth->get_usermail();
          $insert['idPersona']=$this->tank_auth->get_idPersona();;
          $insert['origen']='actividades';
          $insert['filtro']=$tipoFiltro;
          $insert['valorFiltro']=$valorFiltro; 
          $insert['info']=json_encode($arrayVal);
          $this->db->insert('bitacorarefrescado',$insert);

			if($this->tank_auth->get_View()!= "App"){$this->load->view('actividades/verActividades',$data);} 	     
			else {$this->load->view('actividades/verActividadesApp',$data);}
		}
	}/*! verActividades */

//------------------------------------------------------------------
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

	
//----------------------------------------------------
function devolverSubRamos()
{
	$datos['subRamos']=array();	
	$consulta='select sr.IDSRamo,sr.Nombre from catalog_ramos cr left join catalog_subRamos sr on sr.IDRamo=cr.IDRamo where sr.activo=0 and cr.Abreviacion="'.$_POST['ramo'].'"';
	$datos['subRamos']=$this->db->query($consulta)->result();
	echo json_encode($datos);
}
//----------------------------------------------------
	function agregar()
	{
		if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
		else {	
			$arrayPermisos			= $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());	

     if($this->uri->segment(6)=="Nuevo")
     {
	  $data['estados']=$this->catalogos_model->catalog_estados(null);
				$data['giroCatalogo']	= $this->catalogos_model->catalogo_giros(null);	
     }      
	$actividadesPermisos= $this->capsysdre->cotizacionPermisos($this->tank_auth->get_usermail(),$this->tank_auth->get_userprofile());	
			$data['configModulos']		= array('modulo' => 'configuraciones');			
			if($this->tank_auth->get_idPersona()==1102){
				$data['SelectActividad']	= $this->capsysdre_actividades->SelectActividad($arrayPermisos,"CLIENTECORPORATIVO");
				$data['SelectRamo']			= $this->capsysdre_actividades->SelectRamo($this->uri->segment(3),$actividadesPermisos,"CLIENTECORPORATIVO");
			}else{
				$data['SelectActividad']	= $this->capsysdre_actividades->SelectActividad($arrayPermisos);
				$data['SelectRamo']			= $this->capsysdre_actividades->SelectRamo($this->uri->segment(3),$actividadesPermisos);	
			}			
	
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

//-----------------------------------------------------------------------------------------------------------------------------------
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
	
//---------------------------------------------------------
function copiarArchivosActividades($ruta='')
{
 $destination	= '/home/admin/domains/v3prod.capsys.site/public_html/V3/assets/img/archivosClientesNuevos/'.$_POST['fol'];
    $ruta='carpeta1/';
   $destino='carpeta2/';
   $archivos= glob($ruta.'*.*');
  
    foreach ($archivos as $archivo)
    	{
    		$archivo_copiar= str_replace($ruta, $destino, $archivo);copy($archivo, $archivo_copiar);
         }
}
//---------------------------------------------------------
	function agregarGuardarPrueba()
	{
		
              
                      if($this->input->post('tipoActividad', TRUE)=='Emision' || $this->input->post('tipoActividad', TRUE)=='CambiodeConducto' || $this->input->post('tipoActividad', TRUE)=='CapturaEmision')
               {
               	 if($this->input->post('oldValueRFC', TRUE)!=$this->input->post('rfcCliente', TRUE))
               	 {
                    
                   $datos['RFC']=$this->input->post('rfcCliente', TRUE);
                   $datos['IDCont']=$this->input->post('IDCont', TRUE);
                   $datos['IdCli']=$this->input->post('IDCli', TRUE);

                   $this->ws_sicas->actualizarContactoSicas($datos);
                   $oldValue['RFC']=$this->input->post('oldValueRFC', TRUE);
                   $newValue['RFC']=$this->input->post('rfcCliente', TRUE);
                    $insert['IDCli']=$this->input->post('IDCli', TRUE);
                    $insert['IDCont']=$this->input->post('IDCont', TRUE);
                    $insert['emailUser']=$this->tank_auth->get_usermail();
                    $insert['oldValue']=json_encode($oldValue);
                    $insert['newValue']=json_encode($newValue);
                    $this->clientemodelo->bitacoraclientesactualizacionInsertar($this->input->post('IDCli', TRUE),$this->input->post('IDCont', TRUE),$newValue,$oldValue);         	 	
               	 }

               }

	}/*! agregarGuardar1 */
	
//-------------------------------------------------------------------
	
//
function agregarGuardar(){
		if(!$this->tank_auth->is_logged_in()){
			redirect('/auth/login/');
		} else {
	/*===============SE TRAEN DATOS PARA UNA RECOTIZACION========*/
	$bandRecotizacion=false;
	$idInternoPadre=0;
	$folioPadre='';
		if(isset($_POST['idInternoPadre']))
		{
         $idContacto="";
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
         $idInternoPadre=$respuesta->idInterno;
	     $folioPadre=$respuesta->folioActividad;
         if((count($promotorias))>0)
          {
     	    $_POST['cbCompania']=array();
            foreach ($promotorias as $key => $value) { array_push($_POST['cbCompania'], $value->idPromotoria);}
          }     
          $bandRecotizacion=true;
	    }
	
if(!isset($_POST['IDEjecut'])){
   switch ($respuesta->IDSRamo) {
     	case '17':$_POST['IDEjecut']=2;break;
     	case '19':$_POST['IDEjecut']=2;break;
     	case '21':$_POST['IDEjecut']=2;break;
     	case '20':$_POST['IDEjecut']=1;break;
     	case '16':$_POST['IDEjecut']=3;break;
     	case '52':$_POST['IDEjecut']=1;break;
         case '47':$_POST['IDEjecut']=6;break;
     	default:$_POST['IDEjecut']=2;break;     	
     }
		 	
  }


	/*================CALCULA FOLIO DE ACTIVIDAD=======================*/
		$folioActividad		= $this->capsysdre_actividades->CalculaNewFolioActividad();
  
  /*===============================FIN DE COMENTARIO===============================*/

	/*===============ESTABLECE LA RELACION ENTRE LA ACTIVIDAD Y LA COMPANIA=============*/
			if($this->input->post('tipoActividad', TRUE)=='Cotizacion')
			{
			
			if(isset($_POST['cbCompania'])){
				foreach ($_POST['cbCompania'] as  $value) 
				{
					//Modificado [Suemy][2024-07-23]
					$this->verificaExistenciaSemaforo($value,$this->input->post('IDSRamo', TRUE),"agregarGuardar");
					$insert['idPromotoria']				= $value;
	             	$insert['folioActividad']			= $folioActividad;
    	         	$insert['idSubRamo']				= $this->input->post('IDSRamo', TRUE);
        	     	$insert['idRelActividadPromotoria']	= -1;
            	 	$insert['tipoActividad']			= "Cotizacion";
             		$this->catalogos_model->relActividadPromotoria($insert);
				}
			}
		}

      /*===============================FIN DE COMENTARIO===============================*/		
	/*===============DEPENDIENDO SI ES UNA ACTIVIDAD DE EMISION O ENDOSO =============*/
		if($this->input->post('tipoActividad', TRUE)=='Emision'){	
				if(isset($_POST['selectCompania']))
				{  $idPromotoria=0;
					if($this->input->post('selectCompania', TRUE)!=''){$idPromotoria=$this->input->post('selectCompania', TRUE);}
					$insert['idPromotoria']				=$idPromotoria; //$_POST['selectCompania'];
             	$insert['folioActividad']			= $folioActividad;
             	$insert['idSubRamo']				= $this->input->post('IDSRamo', TRUE);
             	$insert['idRelActividadPromotoria']	= -1;
             	$insert['tipoActividad']			= "Emision";
             	$this->catalogos_model->relActividadPromotoria($insert);             	
			}
		}
		
		if($this->input->post('tipoActividad', TRUE)=='Endoso' || $this->input->post('tipoActividad', TRUE)=='Cancelacion')
		{
			if(isset($_POST['nombreCompania']))
			{
			  $idPromotoria=0;
			  if($this->input->post('selectCompania', TRUE)!=''){$idPromotoria=$this->input->post('selectCompania', TRUE);}
			  $insert['idPromotoria']				= $idPromotoria;
			  $insert['folioActividad']			= $folioActividad;
			  $insert['idSubRamo']				= $this->input->post('IDSRamo', TRUE);
			  $insert['idRelActividadPromotoria']	= -1;
			  $insert['tipoActividad']			= "Endoso";
			  $this->catalogos_model->relActividadPromotoria($insert);
			}
			else
			{
	          $datos=$this->ws_sicas->buscaDocumento($_POST['poliza']);
	          if((int)$datos->TableControl->MaxRecords>0)
	          {
		        $IDCia=(int)$datos->TableInfo->IDCia;
		        $consulta='select (count(idPromotoria))total from catalog_promotorias c where c.IDCia='.$IDCia;
                $existePromotoria=$this->db->query($consulta)->result()[0]->total;
                if($existePromotoria==0)
                {
      	         $insert['IDCia']=$IDCia;
      	         $insert['Promotoria']=(string)$datos->TableInfo->CiaNombre;
      	         $insert['activoPromotoria']=1;
      	         $this->db->insert('catalog_promotorias',$insert);
                }                                 			   
			    $insert['idPromotoria']				= $IDCia;
			    $insert['folioActividad']			= $folioActividad;
			    $insert['idSubRamo']				= $this->input->post('IDSRamo', TRUE);
			    $insert['idRelActividadPromotoria']	= -1;
			    $insert['tipoActividad']			= $this->input->post('tipoActividad', TRUE);
			    $this->catalogos_model->relActividadPromotoria($insert);
  
	           }
			}
		}
		
	/*====================================================================================*/

			$tipoCliente		= $this->input->post('tipoCliente', TRUE);
			$TipoEnt			= $this->input->post('tipoEntidad',TRUE);

			if("Fisica" == $TipoEnt){$TipoEnt = "0";} 
			else {$TipoEnt = "1";}
			if($tipoCliente == "Existente")
			{
				$idCliente				= $this->input->post('IDCli', TRUE);
				$idContacto				= (string)$this->input->post('IDCont', TRUE);
				$cel					= $this->input->post('Telefono1', TRUE);
				$mail					= $this->input->post('EMail1', TRUE);
				$data2					= array('cel'=>$cel,'mail'=>$mail,);			
			/*	$this->webservice_sicas_soap->UpdateCliente($data2);//SE DESHABILITO EL GUARDADO  POR MIENTRAS SE VAN A GUARDAR LOS DATOS EN DIFERENTE*/
               if($this->input->post('tipoActividad', TRUE)=='Emision' || $this->input->post('tipoActividad', TRUE)=='CambiodeConducto' || $this->input->post('tipoActividad', TRUE)=='CapturaEmision')
               {
               	 if($this->input->post('tipoActividad', TRUE)!=$this->input->post('tipoActividad', TRUE))
               	 {

               	 }
               }
			} else if($tipoCliente == "Nuevo")
			{
				$clienteContactoSicas	= $this->capsysdre_actividades->CrearClienteContacto($TipoEnt);
				$idCliente				= $clienteContactoSicas[0]->NewIDValue;
				$idContacto				= (string)$clienteContactoSicas[0]->NewSubIDValue;   
			}

/*=========CAMBIO 15052020=======*/			
			//$infoCliente				= $this->capsysdre_actividades->DetalleCliente($idCliente.'-'.$idContacto);

               $infoCliente=$this->ws_sicas->obtenerClienteInfo($idCliente)->TableInfo;			
			
		$nombreCliente	= $infoCliente->NombreCompleto;
			$tipoActividadSicas			= $this->input->post('tipoActividadSicas', TRUE);
			
/*============PARA GRABAR DATOS EN LA TABLA CLIENTES Y EL DE VERIFICACLIENTES===========================*/
			if($this->input->post('tipoActividad', TRUE)=='Emision' || $this->input->post('tipoActividad', TRUE)=='Cotizacion'  || $this->input->post('tipoActividad', TRUE)=='CambiodeConducto' || $this->input->post('tipoActividad', TRUE)=='CapturaEmision'){
				if($this->input->post('tipoCliente', TRUE) == "Nuevo")
				{
					
					if($this->input->post('tipoActividad',TRUE)=='Emision')
					{
						$insertar['preferenciaComunicacion']=$this->input->post('preferenciaComunicacion', TRUE) ;
						$insertar['horarioComunicacion']=$this->input->post('horarioComunicacion', TRUE) ;
						$insertar['diaComunicacion']=$this->input->post('diaComunicacion', TRUE) ;
					}
					if($this->input->post('tipoEntidad')=='Fisica'){
						$insertar['EMail1']= $this->input->post('EMail1', TRUE);
						$insertar['Sexo']= $this->input->post('Sexo', TRUE) ;
						if($insertar['Sexo']==''){$insertar['Sexo']=1;}
						$insertar['fecha_nacimiento']= $this->input->post('fecha_nacimiento', TRUE) ;
						(string)$insertar['ApellidoP']= $this->input->post('ApellidoP', TRUE) ;
						(string)$insertar['ApellidoM']= $this->input->post('ApellidoM', TRUE) ;
						(string)$insertar['NombreCompleto']= $this->input->post('ApellidoP', TRUE) .' '.$this->input->post('ApellidoM', TRUE).' '.$this->input->post('Nombre', TRUE);
						$insertar['Sexo']=(int)$insertar['Sexo'];
					} else {
						$insertar['fecha_nacimiento']= $this->input->post('fecha_constitucion', TRUE) ;
						$insertar['EMail1']= $this->input->post('Email1', TRUE);
						$insertar['NombreCompleto']=$this->input->post('Nombre', TRUE) ;
					}
					
			$insertar['Nombre']= (string)$this->input->post('Nombre', TRUE) ;
			$insertar['idContacto']=(int)$idContacto;
            $insertar['tipoEntidad']= (string)$this->input->post('tipoEntidad', TRUE) ;
            $insertar['IDCli']=(int)$idCliente;                  
            $insertar['Telefono1']= (string)$this->input->post('Telefono1', TRUE) ;
            $insertar['claveEstado']=(int)$this->input->post('claveEstado');
            $insertar['IDVend']=(int)$_POST['IDVend'];

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
					$buscaEstado['clave']	= $this->input->post('claveEstado', TRUE);
					$buscaGiro['idGiro']	= $this->input->post('giroCliente', TRUE);
					
					$datos['ramo']				= $this->input->post('tipoRamo', TRUE);
					$datos['subRamo']			= $this->input->post('tipoSubRamo', TRUE);
			        $datos['usuarioCreacion']	= $this->input->post('usuarioCreacion', TRUE);
	    		    $datos['nombreCliente']		= $this->input->post('Nombre', TRUE).' '.$this->input->post('ApellidoP', TRUE).' '.$this->input->post('ApellidoM', TRUE);
			        $datos['Telefono1']			= $this->input->post('Telefono1', TRUE);
	    		    $datos['claveEstado']		= $this->input->post('claveEstado', TRUE);
			        $datos['giroCliente']		= $this->input->post('giroCliente', TRUE);
			        $datos['giroActividad']		= $this->input->post('giroActividad', TRUE);	       
			        $datos['nombreEstado']		= $this->catalogos_model->catalog_estados($buscaEstado)[0]->estado;
	    		    $datos['nombreGiro']		= $this->catalogos_model->catalogo_giros($buscaGiro)[0]->giro;
			        $datos['EMail1']			= $email;
	        
					$this->email_model->clienteParaFianzas($datos);
					$this->email_model->clientesParaServiciosEspeciales($datos);
				}
				
				if($this->input->post('giroCliente', TRUE)!='' && $this->input->post('giroActividad', TRUE)!=''){
             		$insert	=array(); //"";
             		$insert['idGiro']		= $this->input->post('giroCliente', TRUE);
             		$insert['actividad']	= $this->input->post('giroActividad', TRUE);
					
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
             $insertar['IDVend']=$_POST['IDVend'];
             $this->clientemodelo->insertarCliente($insertar);
           	}
           	else{
           		$update=array();
           		$update['idContacto']=(string)$idContacto;
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
 /*==================================================================================================================*/

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
				 else{$urge=0;}	
			}	
/*========================ASIGNA A USUARIO RESPONSABLE==========================================*/

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
		  if($this->input->post('tipoRamo', TRUE)=="DANOS" || $this->input->post('tipoRamo', TRUE)=="DAÑOS")	{
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
if($this->input->post('IDSRamo', TRUE)==20){$userResponsable="AUTOSRENOVACIONES@ASESORESCAPITAL.COM";}
 $email=$this->tank_auth->get_usermail();
if($email=="CLIENTECORPORATIVO"){$userResponsable="EJECUTIVOCORPORATIVO@AGENTECAPITAL.COM";$idColaboradorArea="6";}else{$idColaboradorArea="0";}


/*===================================VALIDA QUE EL CLIENTE CORPORATIVO NO DUPLIQUE LAS ACTIVIDADES======================================*/

if($this->tank_auth->get_usermail()=="CLIENTECORPORATIVO"){
	$consultaActividad=$this->capsysdre_actividades->consultarActSiniestros($this->input->post('poliza', TRUE), $this->input->post('folioSiniestros', TRUE));
	if($consultaActividad){
		echo("ActividadEncontrada");
		exit();
	}
}

/*=========================================================================*/
//
                    $pagoFormas=0;$pagoConducto=0;$pagoFactura=0;
                    if($this->input->post('pagoFormas', TRUE)>=1 || $this->input->post('pagoFormas', TRUE)<=4){$pagoFormas=$this->input->post('pagoFormas', TRUE);}
                    if($this->input->post('pagoConducto', TRUE)>=1 || $this->input->post('pagoConducto', TRUE)<=4)
                    	{$pagoConducto=$this->input->post('pagoConducto', TRUE);}
                    if($this->input->post('pagoFactura', TRUE)>=1 || $this->input->post('pagoFactura', TRUE)<=3){$pagoFactura=$this->input->post('pagoFactura', TRUE);}
                    $seRequiereFactura=0;
                    if($pagoFormas==''){$pagoFormas=0;}
                    if($pagoConducto==''){$pagoConducto=0;}
                    if($pagoFactura==''){$pagoFactura=0;}
                   if(isset($_POST['actividadRequiereFactura']))
                   {
                   	$seRequiereFactura=1;
                   }
       $userResponsable=$this->obtenerResponsableActividad($_POST['tipoActividad'],$this->input->post('tipoRamo', TRUE),$this->input->post('IDSRamo', TRUE),$_POST['IDVend']); 
       $insertMonitoreo['tipoActividad']=$_POST['tipoActividad'];
       $insertMonitoreo['tipoRamo']=$this->input->post('tipoRamo', TRUE);
       $insertMonitoreo['IDSRamo']=$this->input->post('IDSRamo', TRUE);
       $insertMonitoreo['userResponsable']=$userResponsable;
       $insertMonitoreo['folioActividad']=$folioActividad;
       $this->db->insert('actividademonitoreocreacion',$insertMonitoreo);

			$data = array(
				'folioActividad'	=>	$folioActividad,
				'fechaCreacion'		=>	(string)date('Y-m-d H:i:s'),
				'idSicas'			=>	(string)$idSicas,
				'ClaveBit'			=>	(string)$ClaveBit,
				'IDBit'				=>	(string)$IDBit,
				'Status'			=>	"5",
				'NumSolicitud'		=>	"".$NumSolicitud."",
				'tipoActividadSicas'=>	$this->input->post('tipoActividadSicas', TRUE),
				'idCliente'			=>	(string)$idCliente,
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
				
				'tarjetaNumero'		=>	(string)$this->input->post('numeroTarjeta', TRUE),
				'tarjetaCcv'		=>	$this->input->post('ccv', TRUE),
				'tarjetaMes'		=>	$this->input->post('mesTarjeta', TRUE),
				'tarjetaYear'		=>	$this->input->post('yearTarjeta', TRUE),				
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
			    'IDCliClienteActualiza'		=>	$this->input->post('IDCliClienteActualiza', TRUE),
				'IDSRamo'=>$this->input->post('IDSRamo', TRUE),
				'seRequiereFactura'=>(int)$seRequiereFactura,
				'folioPadre'=>(string)$folioPadre,
				'idInternoPadre'=>(int)$idInternoPadre,
				'folioActividadSiniestros'=>$this->input->post('folioSiniestros', TRUE), //edwin marin
			    'IDDocto'=>$this->input->post('IDDocto', TRUE),
				'idColaboradorArea'=>$idColaboradorArea,
				//'polizaVerde'=>$this->input->post('tarjetaVerde', TRUE),
				//'tarjetaNumeroEncriptado'		=>	$this->input->post('numeroTarjeta', TRUE),
				//'tarjetaCodigoSeguridad'		=>	$this->input->post('ccv', TRUE),
			    //'idInternoPadre'		=>	$this->input->post('idInternoPadre', TRUE),
			    'cruce_cartera' => ($this->input->post('cruce') != false) ? "Si" : "No", // [Suemy][2024-06-26]
			); 
  
$this->capsysdre_actividades->actividades_agregarGuardar($data);

			//CREAMOS CARPETA TARGET_ENDOSO CON DOCUMENTO EN BLANCO SOLAMENTE PARA ENDOSOS

			if($this->input->post('tipoActividad', TRUE)=='Endoso')
			 {	

				if ($_FILES['DocumentoFiles']["error"] > 0){echo "Error: " . $_FILES['DocumentoFiles']['error'] . "<br>";} 
				else 
				{				
				$nameFileSicas="vacio.txt"; //paso nombre por default archivo txt en blanco
				$destination	= '/home/admin/domains/v3prod.capsys.site/public_html/V3/assets/img/tmp/'.$nameFileSicas;
				move_uploaded_file($_FILES['DocumentoFiles']['tmp_name'], $destination);
				 $ListFilesURL	= base_url().'assets/img/tmp/'.$nameFileSicas;				
				$TypeDestinoCDigital	= "CLIENT";
				$IDValuePK				= $idCliente;
				$FolderDestino			= "Target_Endoso";
				$polizita =$this->input->post('poliza', TRUE);
				if($polizita!=""){$FolderDestino			.= "\\".$polizita;}             
			    $this->capsysdre_actividades->CargarDocumento($TypeDestinoCDigital, $IDValuePK, $ListFilesURL, $FolderDestino);//++
                }
             }
             
                
			 
/*=============== GUARDA TARJETA DE CREDITO(LOCM) ===========================*/
             if($_POST['numeroTarjeta']!='' and $_POST['ccv']!='')
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
/*==========================================================================*/			 
/*==================== GUARDAR SI SE CAMBIO RFC=============================*/		
if($tipoCliente == "Existente")
{
  if($this->input->post('tipoActividad', TRUE)=='Emision' || $this->input->post('tipoActividad', TRUE)=='CambiodeConducto' || $this->input->post('tipoActividad', TRUE)=='CapturaEmision')

  {
  	    if($this->input->post('oldValueRFC', TRUE)!=$this->input->post('rfcCliente', TRUE))
               	 {
                    
                   $datos['RFC']=$this->input->post('rfcCliente', TRUE);
                   $datos['IDCont']=$this->input->post('IDCont', TRUE);
                   $datos['IdCli']=$this->input->post('IDCli', TRUE);

                   $this->ws_sicas->actualizarContactoSicas($datos);
                   $oldValue['RFC']=$this->input->post('oldValueRFC', TRUE);
                   $newValue['RFC']=$this->input->post('rfcCliente', TRUE);
                    $insert['IDCli']=$this->input->post('IDCli', TRUE);
                    $insert['IDCont']=$this->input->post('IDCont', TRUE);
                    $insert['emailUser']=$this->tank_auth->get_usermail();
                    $insert['oldValue']=json_encode($oldValue);
                    $insert['newValue']=json_encode($newValue);
                    $this->clientemodelo->bitacoraclientesactualizacionInsertar($this->input->post('IDCli', TRUE),$this->input->post('IDCont', TRUE),$newValue,$oldValue);         	 	
               	 }
  }

}
/*=======================================================*/		

//====================== SI LA ACTIVIDAD ES NUEVO CLIENTE Y SI ES EMISION O ==============================//
			 if($this->input->post('IDPcien') >0)
			 {	
					$fecharegistro=(string)date('Y-m-d H:i:s');
					$correoProcedente=$this->tank_auth->get_usermail();
           			$IDCli2 = $this->input->post('IDPcien');
           			//Cambios Edwin Marin
                $puntos=$this->personamodelo->obtenerPuntosProspeccionIndividual("EMITIR");    
                $esEmision=0;
                if($this->input->post('tipoActividad', TRUE)=='Emision' || $this->input->post('tipoActividad', TRUE)=='CapturaEmision' || $this->input->post('tipoActividad', TRUE)=='CambiodeConducto')
                	{$esEmision=1;
			/*$sqlInsert_Referencia = "Update `clientes_actualiza` set `EstadoActual` = 'COTIZADO', `folioActividad`='".$folioActividad."',`IDCliSikas`='".$idCliente."' where `IDCli`='".$IDCli2."'"; */
			    $actualizaCA['EstadoActual']= 'EMITIDO';
			    $actualizaCA['folioActividad']= $folioActividad;
			    $actualizaCA['IDCliSikas']=$idCliente;
			    $actualizaCA['estaEmitido']=$esEmision;
			    $this->db->where('IDCli',$IDCli2)  ;
			    $this->db->update('clientes_actualiza',$actualizaCA);                
			   // $this->db->query($sqlInsert_Referencia);
			  //$referencia = $this->db->insert_id();
						$sqlInsert_grabapuntos = "Insert Ignore Into `puntaje` (`Usuario`, `IDCliente`,`FechaRegistro`,`EdoAnterior`,`EdoActual`,`PuntosGenerados`,`FolioActividad`,`idSicas`,`OT`,`IdClienteSikas`) Values(
									    '".$correoProcedente."',
									    '".$IDCli2."',
										'".$fecharegistro."', 
										'REGISTRADO',
										'EMITIDO',
										'".$puntos."',
										'".$folioActividad."',
										'".$idSicas."',
										'".$NumSolicitud."',
										'".$idCliente."'
									);
											";                         
						$this->db->query($sqlInsert_grabapuntos);
            }
						//$referencia = $this->db->insert_id();
            }
/*==================================================FIN DE COMENTARIO====================================================*/

/*==============================New Envio Correo Importante=====================================*/
			if($importante==1)
			{
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
			if($bandRecotizacion)
			{
				if(isset($_POST['documentosWWW']))
				{
					$documentosWWW=explode(';', $_POST['documentosWWW']);
					foreach ($documentosWWW as  $valueWWW) 
					{
						if($valueWWW!='')
						{
						 $archivo['TypeDestinoCDigital'] = 'DOCUMENT';
                         $archivo['IDValuePK']= $idSicas;//$infoActividad->idSicas;                      
                         $archivo['FolderDestino']= "";  
                         $archivo['wsAction'] = "PUTFiles";
                         $archivo['ListFilesURL']= $valueWWW;
                         $respuesta=$this->ws_sicas->subirArchivoSicas($archivo);
                          sleep(2);
						}
					}
				}
			}

			if($userResponsable=="EJECUTIVOCORPORATIVO@AGENTECAPITAL.COM"){
				$insertCorreo="insert into envio_correos(fechacreacion,desde,para,copia,copiaoculta,asunto,mensaje,status,fechaenvio,identificaModulo)";
			$insertCorreo=$insertCorreo.'values(now(), "Avisos de GAP<avisosgap@aserorescpital.com>","'.$userResponsable.'",0,0,"Actividad asignada","La actividad con folio ['.$folioActividad.'] se te ha sido asignada",0,now(),"Notificacion");';
			
			 $this->db->query($insertCorreo);
			}

                
		if(isset($_POST['tipoAjax'])){return $folioActividad;}
		else{redirect('actividades/ver/'.$folioActividad);}
		}
	}/*! agregarGuardar */
//--------------------------------------------------------------------------

function editaFolioSiniestros(){
				$consultaActividad=$this->capsysdre_actividades->consultarActSiniestros($this->input->post('poliza', TRUE),$this->input->post('folioActividadSiniestros', TRUE));
					if($consultaActividad){
						echo("ActividadEncontrada");
						exit();
					}
				$dataUpdateActividad['folioActividadSiniestros']				= $this->input->post('folioActividadSiniestros', TRUE);
				$this->db->where('actividades.folioActividad', $this->input->post('folioActividad', TRUE));
				$this->db->update('actividades', $dataUpdateActividad);
				return $this->input->post('folioActividad', TRUE);
}
	
//--------------------------------------------------------------------------
function eliminaComentarioAcitividad()
{
	
	$consulta['id']=$_GET['id'];
	$notificacion=$ultimoId=$this->notificacionmodel->notificacion($consulta);
	if($notificacion->email==$this->tank_auth->get_usermail())
	{
     $actualizar['id']=$_GET['id'];
     $actualizar['check']=2;
     $this->notificacionmodel->actualizarNotificacion($actualizar);
	}
	redirect('actividades/ver/'.$_GET['folioActividad']);
	
}	
//-----------------------------------------------------------
function af()
{
  $this->agregarNotificacionActividad('SW42314','pruebaComentario');
}
//-----------------------------------------------------------
function agregarNotificacionActividad($folioActividad,$comentarioAdicional)
{
	$consulta='select a.usuarioResponsable,u.idPersona,u.email,a.idInterno from actividades a left join users u on u.email=a.usuarioResponsable where u.idPersona is not null and a.folioActividad="'.$folioActividad.'"';
	$consulta.=' union ';
	$consulta.='select a.usuarioResponsable,u.idPersona,u.email,a.idInterno from actividades a left join users u on u.email=a.usuarioCreacion where u.idPersona is not null and a.folioActividad="'.$folioActividad.'"';
	$consulta.=' union ';
	$consulta.='select a.usuarioResponsable,u.idPersona,u.email,a.idInterno from actividades a left join users u on u.email=a.usuarioVendedor where u.idPersona is not null and a.folioActividad="'.$folioActividad.'"';


	$actividad=$this->db->query($consulta)->result();
    $emailLogin=$this->tank_auth->get_usermail();
    foreach ($actividad as $key => $value) 
    {
    	if($value->email!=$emailLogin)
    	{ 
	    $notificacion['tabla']='actividades';          
        $notificacion['idTabla']=$value->idInterno;
        $notificacion['persona_id']=$value->idPersona;
        $notificacion['email']=  $value->email;
        $notificacion['tipo_id']='email';
        $notificacion['referencia']='COMENTARIO_ACTIVIDAD';
        $notificacion['referencia_id']='1001';
        $notificacion['check']=0;
        $notificacion['comentarioAdicional']=$comentarioAdicional.' '.$folioActividad;
        $notificacion['id']=-1;
        $notificacion['tipo']='OTRO';
        $notificacion['controlador']='actividades/eliminaComentarioAcitividad?folioActividad='.$folioActividad;        
        $ultimoId=$this->notificacionmodel->notificacion($notificacion);
        $actualizar['id']=$ultimoId;
        $actualizar['controlador']='actividades/eliminaComentarioAcitividad?folioActividad='.$folioActividad.'&id='.$ultimoId;
        $this->notificacionmodel->actualizarNotificacion($actualizar);
    	}
    }
/*     $emailUsuarioResponsable='';
     $idlUsuarioResponsable='';
     $idTabla=0;
     if(count($actividad)>1)
     	{
     	  $emailUsuarioResponsable=$actividad[1]->usuarioResponsable;
         $idlUsuarioResponsable=$actividad[1]->idPersona;
         $idTabla=$actividad[1]->idInterno;
        }
     else{     	  $emailUsuarioResponsable=$actividad[0]->usuarioResponsable;
         $idlUsuarioResponsable=$actividad[0]->idPersona;
         $id=$actividad[0]->idInterno;
           }
	    $notificacion['tabla']='actividades';          
        $notificacion['idTabla']=$id;
        $notificacion['persona_id']=$idlUsuarioResponsable;
        $notificacion['email']=  $emailUsuarioResponsable;
        $notificacion['tipo_id']='email';
        $notificacion['referencia']='COMENTARIO_ACTIVIDAD';
        $notificacion['referencia_id']='1001';
        $notificacion['check']=0;
        $notificacion['comentarioAdicional']=$comentarioAdicional.' '.$folioActividad;
        $notificacion['id']=-1;
        $notificacion['tipo']='OTRO';
        $notificacion['controlador']='actividades/eliminaComentarioAcitividad?folioActividad='.$folioActividad;        
        $ultimoId=$this->notificacionmodel->notificacion($notificacion);
        $actualizar['id']=$ultimoId;
        $actualizar['controlador']='actividades/eliminaComentarioAcitividad?folioActividad='.$folioActividad.'&id='.$ultimoId;
        $this->notificacionmodel->actualizarNotificacion($actualizar);*/

}
//---------------------------------------------------
	function agregarSeguimiento()
	{		
        //
		if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
		else 
		{
			$oldPosicion	= $this->input->get_post('oldPosicion', TRUE);
			$enviar			= $this->input->get_post('enviar', TRUE);
			$ClaveBit		= $this->input->get_post('ClaveBit', TRUE);
			$Procedencia	= $this->input->get_post('Procedencia', TRUE);
			$Comentario	    = $this->input->get_post('Comentario', TRUE)." \r";
			$Comentario	   .= "(*) ".$this->tank_auth->get_usernamecomplete()." ";
			$Comentario	   .= "[".$this->tank_auth->get_usermail()."]";

		 			
$folio=$this->comprobarActividadClienteNuevo($_POST['folioActividad']);			

    if($folio->bandera)
    {
    	  $insertar['folioActividad']=$_POST['folioActividad'];
               $insertar['comentario']=$this->input->get_post('Comentario', TRUE);
               $this->comentariosGuardar($insertar);
				
	  if($oldPosicion!=0){
    	if($oldPosicion==1)
			{
				$posicion	= 5;
				$IDDocto	= $this->input->get_post('IDDocto', TRUE);								
				
				$dataUpdateActividad['Status']				= $posicion;
				$dataUpdateActividad['comentarioTemporal']	= $this->input->get_post('Comentario', TRUE);
				$this->db->where('actividades.folioActividad', $_POST['folioActividad']);
				$this->db->update('actividades', $dataUpdateActividad);
                $this->agregarNotificacionActividad($this->input->get_post('folioActividad', TRUE),'Se realiza un cambio se status');
			   $insertar['folioActividad']=$_POST['folioActividad'];
               $insertar['comentario']='La actividad esta en curso';
               $this->comentariosGuardar($insertar);
             
			}
			else
			{
								$posicion	= $oldPosicion;
				$IDDocto	= $this->input->get_post('IDDocto', TRUE);								
				
				$dataUpdateActividad['Status']				= $posicion;
				$dataUpdateActividad['comentarioTemporal']	= $this->input->get_post('Comentario', TRUE);
				$this->db->where('actividades.folioActividad', $_POST['folioActividad']);
				$this->db->update('actividades', $dataUpdateActividad);
                $this->agregarNotificacionActividad($this->input->get_post('folioActividad', TRUE),'Se realiza un cambio se status');
			   $insertar['folioActividad']=$_POST['folioActividad'];
               $insertar['comentario']='La actividad esta en curso';
               $this->comentariosGuardar($insertar);
			}
		}
     }
     else
     {    	  if($oldPosicion!=0){	    		
			if($oldPosicion==1)
			{
				$posicion	= 5;
				$IDDocto	= $this->input->get_post('IDDocto', TRUE);				
				if($this->input->get_post('tipoActividadSicas', TRUE) == "ot"){$StatusUser			= $this->capsysdre_actividades->CambiaStatusUser($IDDocto,$posicion);} 
				else {$StatusUserTarea	= $this->capsysdre_actividades->CambiaStatusUserTarea($IDDocto,$posicion);}
				
				$dataUpdateActividad['Status']				= $posicion;
				$dataUpdateActividad['comentarioTemporal']	= $this->input->get_post('Comentario', TRUE);
				$this->db->where('actividades.idSicas', $IDDocto);
				$this->db->update('actividades', $dataUpdateActividad);
				$this->agregarNotificacionActividad($this->input->get_post('folioActividad', TRUE),'Se realiza un cambio se status');
				}
			else
			{
								$posicion	= $oldPosicion;
				$IDDocto	= $this->input->get_post('IDDocto', TRUE);				
				if($this->input->get_post('tipoActividadSicas', TRUE) == "ot"){$StatusUser			= $this->capsysdre_actividades->CambiaStatusUser($IDDocto,$posicion);} 
				else {$StatusUserTarea	= $this->capsysdre_actividades->CambiaStatusUserTarea($IDDocto,$posicion);}
				
				$dataUpdateActividad['Status']				= $posicion;
				$dataUpdateActividad['comentarioTemporal']	= $this->input->get_post('Comentario', TRUE);
				$this->db->where('actividades.idSicas', $IDDocto);
				$this->db->update('actividades', $dataUpdateActividad);
				$this->agregarNotificacionActividad($this->input->get_post('folioActividad', TRUE),'Se realiza un cambio se status');
			}
			}
		  }	
$this->agregarNotificacionActividad($this->input->get_post('folioActividad', TRUE),'Se agrego un nuevo comentario al folio ');
		  //if($oldPosicion==1){$this->agregarNotificacionActividad($this->input->get_post('folioActividad', TRUE),'Se agrego un nuevo comentario al folio ');}
		  $bitacoraSicas	= $this->capsysdre_actividades->CrearBitacora($ClaveBit, $Procedencia, $Comentario);
		  if(isset($_POST['peticionAJAX'])){$respuesta['success']=true;echo json_encode($respuesta);}
		  else{redirect('actividades/ver/'.$this->input->get_post('folioActividad', TRUE));}
	}
  }/*! agregarSeguimiento */
	
//--------------------------------------------------------------------------
	function agregarDocumentoPromotoria()
	{
		if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
		else {
			
			if ($_FILES['DocumentoFiles']["error"] > 0){echo "Error: " . $_FILES['DocumentoFiles']['error'] . "<br>";} 
			else 
			{

             $folio=array();
     	     $folio=$this->comprobarActividadClienteNuevo($this->input->post('folioActividad', TRUE));
             $folioActividad	= $this->input->post('folioActividad', TRUE);		
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
             
             if($folio->bandera)
              {
                $FolderDestino			= $folio->IDCliClienteActualiza.'/Documentos/';
                //$destination	= 'C:/wamp64/www/Capsys/www/V3/assets/img/archivosClientesNuevos/'.$FolderDestino;
				$destination	= '/home/admin/domains/v3prod.capsys.site/public_html/V3/assets/img/archivosClientesNuevos/'.$FolderDestino;
				if (!file_exists($destination)) {mkdir($destination, 0777, true);}
				$destination.=$nameFileSicas;
				move_uploaded_file($_FILES['DocumentoFiles']['tmp_name'], $destination);

              }
             else 
              {

				$destination	= '/home/admin/domains/v3prod.capsys.site/public_html/V3/assets/img/tmp/'.$nameFileSicas;				
				move_uploaded_file($_FILES['DocumentoFiles']['tmp_name'], $destination);
				$ListFilesURL	= base_url().'assets/img/tmp/'.$nameFileSicas;
				
				$TypeDestinoCDigital	= $this->input->post('TypeDestinoCDigital', TRUE);
				$IDValuePK				= $this->input->post('IDValuePK', TRUE);
				$FolderDestino			= $this->input->post('FolderDestino', TRUE);        	
				$this->capsysdre_actividades->CargarDocumento($TypeDestinoCDigital, $IDValuePK, $ListFilesURL, $FolderDestino);
			 }
			}
            $array['idRelActividadPromotoria']=$this->input->post('idRelActividadPromotoria', TRUE);
            $array['operacion']=1;             		
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
		$this->load->model('manejodocumento_modelo');
   		$folio=array();
	     $folio=$this->comprobarActividadClienteNuevo($this->input->post('folioActividad', TRUE));
         $folioActividad	= $this->input->post('folioActividad', TRUE);		

       if($folio->bandera)
       {
             	if ($_FILES['DocumentoFiles']["error"] > 0){echo "Error: " . $_FILES['DocumentoFiles']['error'] . "<br>";} 
	else 
	{
        		switch($this->input->post('tipoImg_0', TRUE))
				{
					
					case "IFE":							## 01 ##
					case "RFC":							## 02 ##
					case "COMPROBANTE DOMICILIARIO":	## 03 ##
					case "ACTA CONSTITUTIVA":			## 04 ##
					case "PODER REPRESENTANTE LEGAL":	## 05 ##
					case "ACTA DE PROTOCOLIZACION":		## 06 ##
						$FolderDestino			= $folio->IDCliClienteActualiza.'/';
					break;
					
					default:
						$FolderDestino			= $folio->IDCliClienteActualiza.'/Documentos/';
					break;
				}

   				$idCliente		= $this->input->post('idCliente', TRUE);                
				$nameFileSicas	= str_replace(' ','_',$this->input->post('tipoImg_0', TRUE));
				$nameFileSicas	.= "-".strtoupper($this->input->post('descripcionArchivo', TRUE));
				$nameFileSicas	.= "-".date('YmdHi');
				$nameFileSicas	.= ".".strrev(strstr(strrev($_FILES['DocumentoFiles']['name']), '.', true));
				// $destination	= 'C:\wamp\www\V3Presentacion\assets\img\tmp\\'.$nameFileSicas;
				//$destination	= '/home/admin/domains/v3prod.capsys.site/public_html/V3/assets/\img\tmp\\'.$nameFileSicas;
				
				//$destination	= '/home/admin/domains/v3prod.capsys.site/public_html/V3/assets/\img\archivosClientesNuevos\\'.$FolderDestino;
				$destination	= '/home/admin/domains/v3prod.capsys.site/public_html/V3/assets/img/archivosClientesNuevos/'.$FolderDestino;
				if (!file_exists($destination)) {mkdir($destination, 0777, true);}
				$destination.=$nameFileSicas;
				                   ///home/admin/domains/v3prod.capsys.site/public_html/V3/assets/\img
				
				
				//$destination	= '/var/www/html/capsys.com.mx/public_html/V3/assets/img/tmp/'.$nameFileSicas;
				  //$destination	= "https://capsys.com.mx/V3/assets/img/tmp/IFE-INE-202103091402.pdf";
				 
				move_uploaded_file($_FILES['DocumentoFiles']['tmp_name'], $destination);
            			$enviar			= $this->input->post('enviar', TRUE);									
  			     $insertar['folioActividad']=$_POST['folioActividad'];
                 $insertar['comentario']='Se adiciono el archivo '.$nameFileSicas;
                 $this->comentariosGuardar($insertar);       
 		
            	if($this->input->post('enviar', TRUE)==5)
            	{
                  $insertar['folioActividad']=$folioActividad;
                  $insertar['comentario']='La actividad esta en curso';
                  $this->comentariosGuardar($insertar);                       
                  $this->db->where('folioActividad',$folioActividad);
                  $update['Status']=5;
                  $this->db->update('actividades',$update);
            	}

         $this->agregarNotificacionActividad($this->input->get_post('folioActividad', TRUE),'Se agrego el documento '.$nameFileSicas.' al folio ');
       redirect('actividades/ver/'.$folioActividad);
       }
    }
	    else{
			if ($_FILES['DocumentoFiles']["error"] > 0){echo "Error: " . $_FILES['DocumentoFiles']['error'] . "<br>";} 
			else 
			{
				$this->load->model('manejodocumento_modelo');
				$idCliente		= $this->input->post('idCliente', TRUE);                
				$nameFileSicas	= str_replace(' ','_',$this->input->post('tipoImg_0', TRUE));
				$nameFileSicas	.= "-".strtoupper($this->input->post('descripcionArchivo', TRUE));
				$nameFileSicas	.= "-".date('YmdHi');
				$nameFileSicas	.= ".".strrev(strstr(strrev($_FILES['DocumentoFiles']['name']), '.', true));
				$destination	= '/home/admin/domains/v3prod.capsys.site/public_html/V3/assets/img/tmp/'.$nameFileSicas;				
				move_uploaded_file($_FILES['DocumentoFiles']['tmp_name'], $destination);
				$Cliente=null;
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
						$Cliente=$idCliente;
					break;					
					default:
						$ListFilesURL			= base_url().'assets/img/tmp/'.$nameFileSicas;
						$TypeDestinoCDigital	= $this->input->post('TypeDestinoCDigital', TRUE);
						$IDValuePK				= $this->input->post('IDValuePK', TRUE);
						$FolderDestino			= $this->input->post('FolderDestino', TRUE);
					break;
				}
				
			$this->capsysdre_actividades->CargarDocumento($TypeDestinoCDigital, $IDValuePK, $ListFilesURL, $FolderDestino,$Cliente);
			}

			$oldPosicion	= $this->input->post('oldPosicion', TRUE);
			$enviar			= $this->input->post('enviar', TRUE);						
			$folioActividad	= $this->input->post('folioActividad', TRUE);
			
			switch($this->tank_auth->get_userprofile())
			{
				case 1:
				case 2:$posicion = "5";break;				
				case 3:
				case 4:$posicion = $enviar; break;				
				case 5:$posicion = "1";break;
			}
		    $IDDocto = $this->input->post('IDDocto', TRUE);			
			if($this->input->post('tipoActividadSicas', TRUE) == "ot"){$StatusUser = $this->capsysdre_actividades->CambiaStatusUser($IDDocto,$posicion);} 
			else {$StatusUserTarea = $this->capsysdre_actividades->CambiaStatusUserTarea($IDDocto,$posicion);}
           $this->agregarNotificacionActividad($this->input->get_post('folioActividad', TRUE),'Se agrego el documento '.$nameFileSicas.' al folio ');
			redirect('actividades/ver/'.$folioActividad);
		}
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
            
            if($satisfaccion=='malo')
            	{
            		$insertNoConformidad['idCBITipo']=1;
            		$insertNoConformidad['idCBIOpcion']=29;
            		$insertNoConformidad['idCBIArea']=24;
            		$this->procesamientoncmodel->insertarNC($insertNoConformidad);
            	}

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

$data['infoFolioActividad']		= $this->capsysdre_actividades->infoFolioActividad($this->uri->segment(3));	
			$data['configModulos'] = array( 'modulo' => 'configuraciones');
			$data['SelectTipoImg'] = $this->capsysdre_actividades->SelectTipoImg(0);			
			$data['companias']=$this->capsysdre_actividades->obtenerPromotoriaPorActividad($data['infoFolioActividad']->folioActividad,"Cotizacion");
				
  $folio=$this->comprobarActividadClienteNuevo($this->uri->segment(3));  
if($folio->bandera)
{
	$xmlstr = <<<XML
<?xml version='1.0' standalone='yes'?>
<cliente>
<IDCli>7</IDCli>
</cliente>
XML;

$data['ClienteContact']['cliente']=new SimpleXMLElement($xmlstr);
$xmlVerDoxumentosActividad=<<<XML
<?xml version='1.0' standalone='yes'?>
XML;


$data['verDocumentosActividad']	=array();
$data['cliente']=array();//BUSCAR LOS DATOS EN LA TABLA DE CRM
//$_GET['IDCli']=1;
 $bitacora=$this->db->query("select ac.folioActividad,(concat(ac.comentario,' [',ac.username,']')) as Comentario,(ac.fechaInsercion) as FechaHora,'5' as IDUser,'' as Procedencia from actividadescomentarios 
ac where ac.folioActividad='".$this->uri->segment(3)."' order by ac.idComentario desc")->result(); 
$data['verBitacoraActividad']=$bitacora;
$cliente='select (cc.IDCli) as IDCli,0 as PUNTOS,(concat(cc.Nombre," ",cc.ApellidoP," ",cc.ApellidoM)) as NombreCompleto,"" as idPersonaAgente,((concat(cc.Nombre," ",cc.ApellidoP," ",cc.ApellidoM))) as nombreCliente,cc.preferenciaComunicacion,cc.horarioComunicacion,cc.diaComunicacion,cc.Telefono1,"" as idContacto,cc.EMail1,cc.ApellidoP,cc.ApellidoM,cc.Nombre,cc.RFC,"" as CURP,cc.tipoEntidad,"" as Calidad,"" as Expediente,"" as TipoEnt,"" as FechaNac,"" as FechaConst,"" as Edad,"" as ClaveTKM,cc.Sexo,"" as RazonSocial,"" as IDCont from clientes_actualiza cc where cc.IDCli='.$folio->IDCliClienteActualiza;

//$data['cliente']=$this->db->query($cliente)->result(); 

$data['infoCliente']=$this->db->query($cliente)->result();
$data["ClienteContact"]['cliente']	=$this->db->query($cliente)->result()[0];

}
else{
			
			$idSicas						= $data['infoFolioActividad']->idSicas;			
			$data['infoDocumento']			= $this->capsysdre_actividades->DetalleDocumento($idSicas);		
			$idCliente						= $data['infoFolioActividad']->idCliente;
			$idContacto						= $data['infoFolioActividad']->idContacto;
			$data['infoCliente']			= $this->ws_sicas->obtenerClienteInfo($idCliente);//
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
	}		
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

function agregarEmitir2()
{
	$folio=$this->comprobarActividadClienteNuevo($_POST['folioActividad']);
	$directorio = FCPATH.'assets/img/archivosClientesNuevos/'.$folio->IDCliClienteActualiza;
$ficheros1=array();
if(file_exists ($directorio))
{
 $ficheros1  = scandir($directorio);
 foreach ($ficheros1 as $value) 
 {
 	if(is_file($directorio.'/'.$value))
 	{
      print_r($directorio.'/'.$value.'---ES DOCUMETO DEL CLIENTE<br>');
      print_r(base_url().'assets/img/archivosClientesNuevos/'.$folio->IDCliClienteActualiza.'/'.$value.'<br>');
 	}
 	
 }
 
}
 $directorioDoc = FCPATH.'assets/img/archivosClientesNuevos/'.$folio->IDCliClienteActualiza.'/Documentos';
$ficherosDoc=array();
if(file_exists ($directorioDoc))
{
 $ficherosDoc  = scandir($directorioDoc);
 foreach ($ficherosDoc as $value) 
 {
 	if(is_file($directorioDoc.'/'.$value))
 	{
      print_r($directorio.'/'.$value.'---ES DOCUMETO DE LA ACTIVIDAD<br>');
      print_r(base_url().'assets/img/archivosClientesNuevos/'.$folio->IDCliClienteActualiza.'/Documentos/'.$value.'<br>');
 	}
 	
 }
 
}
}
//-----------------------------------------------------------
function agregarEmitir()
{
	if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');}
   else 
  {			
    $folio=$this->comprobarActividadClienteNuevo($_POST['folioActividad']);
    if($folio->bandera)
   {
    
    $this->db->from("actividades");
    $this->db->where("actividades.folioActividad", $this->input->post('folioActividad', TRUE));
    $query = $this->db->get();
    $infoActividad = $query->row();
    $this->db->from("clientes_actualiza");
    $this->db->where("clientes_actualiza.IDCli", $infoActividad->IDCliClienteActualiza);
    $query = $this->db->get();
    $clienteActualiza = $query->row();
    
    switch ($infoActividad->IDSRamo) 
     {
     	case '17':$_POST['IDEjecut']=2;break;
     	case '19':$_POST['IDEjecut']=2;break;
     	case '21':$_POST['IDEjecut']=2;break;
     	case '20':$_POST['IDEjecut']=1;break;
     	case '16':$_POST['IDEjecut']=3;break;
     	case '52':$_POST['IDEjecut']=1;break;
         case '47':$_POST['IDEjecut']=6;break;
     	default:$_POST['IDEjecut']=2;break;     	
     }
	    $TipoEnt=1;
	    $_POST['Nombre']=$clienteActualiza->RazonSocial;	    	    	    	    
       	if("Fisica" == $clienteActualiza->tipoEntidad)
       	{
       		$TipoEnt = "0";
       		$_POST['Nombre']=$clienteActualiza->Nombre;
        } 		
       if($clienteActualiza->Sexo!='0' and $clienteActualiza->Sexo!='1'){$clienteActualiza->Sexo=0;}     
       if($clienteActualiza->fecha_nacimiento=='0000-00-00' or $clienteActualiza->fecha_nacimiento==NULL){$clienteActualiza->fecha_nacimiento='2000-01-01';}
       if($clienteActualiza->fecha_constitucion=='0000-00-00' or $clienteActualiza->fecha_constitucion==NULL){$clienteActualiza->fecha_constitucion='2000-01-01';}

     $_POST['fecha_nacimiento']=$clienteActualiza->fecha_nacimiento;
     $_POST['fecha_constitucion']=$clienteActualiza->fecha_constitucion;
    $_POST['IDSRamo']=$infoActividad->IDSRamo;
    $_POST['ApellidoP']=$clienteActualiza->ApellidoP;
    $_POST['ApellidoM']=$clienteActualiza->ApellidoM;    
    $_POST['Sexo']=$clienteActualiza->Sexo;
    $_POST['EMail1']=$clienteActualiza->EMail1;
    $_POST['Telefono1']=$clienteActualiza->Telefono1;
    $_POST['tipoEntidad']=$TipoEnt;
    $_POST['claveEstado']=$clienteActualiza->claveEstado;
    $_POST['IDVend']=$infoActividad->IDVend;
    $_POST['IDDir'] = -1;
    $_POST['IDAgente'] = 63;
    $_POST['IDGrupo'] = 1;
    $_POST['tipoActividadSicas'] ='ot';
    $_POST['TipoDocto'] = 0;
  	$clienteContactoSicas	= $this->capsysdre_actividades->CrearClienteContacto($TipoEnt);
  	
	$idCliente				= $clienteContactoSicas[0]->NewIDValue;
	$idContacto				= (string)$clienteContactoSicas[0]->NewSubIDValue;   
	$actividadSicas = $this->capsysdre_actividades->CrearOt($this->input->post('folioActividad', TRUE),$idCliente);
	$idSicas		= $actividadSicas[0]->NewIDValue;//++
	$ClaveBit		= $actividadSicas[0]->ClaveBit;//++
	$NumSolicitud	= $actividadSicas[0]->NumSolicitud;//++


		try{
	        if(empty($idSicas) or is_null($idSicas) or empty($NumSolicitud) ){throw new Exception('Varaible de SICAS no generada vuelva Intentar');}
             }
        catch (Exception $e)
        {    
            echo $e->getMessage();
            redirect('/auth/login/');
        }// fin del try que cacha si no genera el idsicas 28 dic 2016
    $actualizarActividad['idSicas']=(string)$idSicas;
    $actualizarActividad['ClaveBit']=(string)$ClaveBit;
    $actualizarActividad['NumSolicitud']=(string)$NumSolicitud;
    $actualizarActividad['Documento']=(string)$NumSolicitud;
    $actualizarActividad['idContacto']=(string)$idContacto;
    $actualizarActividad['idCliente']=(string)$idCliente;
    $actualizarActividad['tipoActividadSicas']='ot';
    $this->db->where('folioActividad',$_POST['folioActividad']);
    $this->db->update('actividades',$actualizarActividad);

     //====== CREAMOS COMENTARIOS EN SICAS=====================//
					$Procedencia	= $this->input->post('tipoActividad',TRUE)." Capsys Web ".$_POST['folioActividad'];
					$Comentario	   = $this->input->post('datosExpres', TRUE)." \r";
					if($this->input->post('actividadUrgente', TRUE) == 1){ $Comentario	.= "(*)Urgente !!! \r"; }
					$Comentario	   .= "(*) ".$this->tank_auth->get_usernamecomplete()." ";
					$Comentario	   .= "[".$this->tank_auth->get_usermail()."]";
					$bitacoraSicas	= $this->capsysdre_actividades->CrearBitacora($ClaveBit, $Procedencia, $Comentario);//++
					$IDBit			= $bitacoraSicas[0]->NewIDValue;

  //=======================================================//
  //=================GUARDAMOS EL CLIENTE EN NUESTRA BASE DE DATOS=================//
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
  //===============================================================================// 
  $_POST['ClaveBit']=(string)$ClaveBit;
  $_POST['Procedencia']='Cotizacion Capsys Web '.$_POST['folioActividad'];
  $_POST['IDDocto']=(string)$idSicas;

 $directorio = FCPATH.'assets/img/archivosClientesNuevos/'.$folio->IDCliClienteActualiza;
$ficheros1=array();
if(file_exists ($directorio))
{
 $ficheros1  = scandir($directorio);
 foreach ($ficheros1 as $value) 
 {
 	if(is_file($directorio.'/'.$value))
 	{
 	  $archivo['TypeDestinoCDigital'] = 'CLIENT';
      $archivo['IDValuePK']= $idCliente;                      
      $archivo['FolderDestino']= "";  
      $archivo['wsAction'] = "PUTFiles";
      $archivo['ListFilesURL']= base_url().'assets/img/archivosClientesNuevos/'.$folio->IDCliClienteActualiza.'/'.$value;
      $respuesta=$this->ws_sicas->subirArchivoSicas($archivo);
      sleep(2);
 	}
 	
 } 
}
 $directorioDoc = FCPATH.'assets/img/archivosClientesNuevos/'.$folio->IDCliClienteActualiza.'/Documentos';
$ficherosDoc=array();
if(file_exists ($directorioDoc))
{
 $ficherosDoc  = scandir($directorioDoc);
 foreach ($ficherosDoc as $value) 
 {
 	if(is_file($directorioDoc.'/'.$value))
 	{
 	  $archivo['TypeDestinoCDigital'] = 'DOCUMENT';
      $archivo['IDValuePK']= $idSicas;//$infoActividad->idSicas;                      
      $archivo['FolderDestino']= "";  
      $archivo['wsAction'] = "PUTFiles";
      $archivo['ListFilesURL']= base_url().'assets/img/archivosClientesNuevos/'.$folio->IDCliClienteActualiza.'/Documentos/'.$value;
      $respuesta=$this->ws_sicas->subirArchivoSicas($archivo);
      sleep(2);
 	}
 	
 }
}
  $this->db->from("actividades");
 $this->db->where("actividades.idSicas", $idSicas);
 $query = $this->db->get();
 $infoActividad = $query->row();
}
else
{
 $this->db->from("actividades");
 $this->db->where("actividades.idSicas", $this->input->post('IDDocto', TRUE));
 $query = $this->db->get();
 $infoActividad = $query->row();

}
/*========================================ASIGNA A USUARIO RESPONSABLE==========================*/
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
else{$userResponsable="CAPTURA@ASESORESCAPITAL.COM";}
/*===============================================================================================*/			
			$ClaveBit		= $this->input->post('ClaveBit', TRUE);
			$Procedencia	= $this->input->post('Procedencia', TRUE);
			$Comentario	    = $this->input->post('ComentarioEmision', TRUE)." \r";
			$Comentario	   .= "(*) EMISION \r";
			$Comentario	   .= "(*) ".$this->tank_auth->get_usernamecomplete()." ";
			$Comentario	   .= "[".$this->tank_auth->get_usermail()."]";
			$bitacoraSicas	= $this->capsysdre_actividades->CrearBitacora($ClaveBit, $Procedencia, $Comentario);
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
			$StatusUser = $this->capsysdre_actividades->CambiaStatusEmision($IDDocto,$posicion,$Concepto);			
            $usuarioResponsable=$this->catalogos_model->devolverRamoConIdSubramo($infoActividad->IDSRamo);
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
				//$data['usuarioResponsable']	=$usuarioResponsable[0]->emailResponsable;

                $data['usuarioResponsable']=$this->obtenerResponsableActividad("Emision",$infoActividad->ramoActividad,$infoActividad->IDSRamo,$infoActividad->IDVend);
				$data['nombreUsuarioCreacion']	= $infoActividad->nombreUsuarioCreacion;

				//$data['nombreUsuarioResponsable']	= $infoActividad->nombreUsuarioResponsable;
                $data['nombreUsuarioResponsable']	= $this->capsysdre->NombreCompletoUsuarioResponsable($data['usuarioResponsable']);/*$usuarioResponsable[0]->nombres.' '.$usuarioResponsable[0]->apellidoPaterno.' '.$usuarioResponsable[0]->apellidoMaterno;*/
                $data['polizaVerde']	= $infoActividad->polizaVerde;
                $data['IDSRamo']	= $infoActividad->IDSRamo;
				$data['fechaCreacion']		= date('Y-m-d H:i:s');
				$data['IDCliClienteActualiza']	= $infoActividad->IDCliClienteActualiza;
				$this->db->insert('actividades', $data);

             	if(isset($_POST['selectCompania'])){
             		$insert['idPromotoria']=$_POST['selectCompania'];
             		$insert['folioActividad']=$infoActividad->folioActividad;
             		$insert['idSubRamo']=$infoActividad->IDSRamo;
             		$insert['idRelActividadPromotoria']=-1;
             		$insert['tipoActividad']="Emision";
             		$this->catalogos_model->relActividadPromotoria($insert);
             	
               }
            if($this->input->post('folioActividad', TRUE)!='')
            {
            	$consulta='select (count(c.folioActividad)) as total,c.* from clientes_actualiza c where c.folioActividad="'.$this->input->post('folioActividad', TRUE).'"';
            	$total=$this->db->query($consulta)->result();           	
            	if($total[0]->total>0)
            	{
            	  /*$update='update clientes_actualiza set estaEmitido=1 where folioActividad="'.$this->input->post('folioActividad', TRUE).'"';
            		$this->db->query($update);*/
            		//Cambios Edwin Marin
            		$puntos=$this->personamodelo->obtenerPuntosProspeccionIndividual("EMITIR");
                 $actualizaCA['EstadoActual']= 'EMITIDO';
			     $actualizaCA['folioActividad']= $this->input->post('folioActividad', TRUE);
			     $actualizaCA['IDCliSikas']=$infoActividad->idCliente;
			     $actualizaCA['estaEmitido']='1';
			     $this->db->where('IDCli',$total[0]->IDCli)  ;
			     $this->db->update('clientes_actualiza',$actualizaCA);
                 $insertCN['Usuario']=$this->tank_auth->get_usermail();
                 $insertCN['IDCliente']=$total[0]->IDCli;
                 //$insertCN['FechaRegistro']=$fecharegistro;
                 $insertCN['EdoAnterior']=$total[0]->EstadoActual;
                 $insertCN['EdoActual']='EMITIDO';
                 $insertCN['PuntosGenerados']=$puntos;
                 $insertCN['FolioActividad']=$this->input->post('folioActividad', TRUE);
                 $insertCN['idSicas']=$infoActividad->idSicas;
                 $insertCN['OT']=$infoActividad->NumSolicitud;
                 $insertCN['IdClienteSikas']=$infoActividad->idCliente;
                 $this->db->insert('puntaje',$insertCN);            		   
            	}
            }
          }
			redirect('actividades/ver/'.$this->input->post('folioActividad', TRUE));
		
	}/*! agregarEmitir */

//------------------------------------------------------------------------------------

//-----------------------------------------------------------
	function agregarEmitirOriginal()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			

/*===========================================================ASIGNA A USUARIO RESPONSABLE========================*/
if($this->input->post('tipoActividad', TRUE)!="CapturaEmision")
{
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
/*=============================================================================*/

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
				$data['Status']				= "5";//$posicion;
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
            if($this->input->post('folioActividad', TRUE)!='')
            {
            	$consulta='select (count(c.folioActividad)) as total from clientes_actualiza c where c.folioActividad="'.$this->input->post('folioActividad', TRUE).'"';
            	$total=$this->db->query($consulta)->result();
           
            	if($total[0]->total>0)
            	{
            		$update='update clientes_actualiza set estaEmitido=1 where folioActividad="'.$this->input->post('folioActividad', TRUE).'"';
            		$this->db->query($update);
         

            	}
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
		if($calificacionMala==0)
		{
			$consulta['idInterno']=$_POST['idInterno'];        	 
			$datosActividad=$this->capsysdre_actividades->actividades($consulta);      	      	      	
			$consultaIdResponsable=$this->personamodelo->devolverUsersPorEmail($datosActividad->usuarioCreacion);
			$insertNoConformidad['nombreTabla']='calificacionactividad';            
			$insertNoConformidad['idPersonaInconforme']=$this->tank_auth->get_idPersona();
			$insertNoConformidad['idRowTabla']=$_POST['idInterno'];
			$insertNoConformidad['idPersonaResponsable']=$consultaIdResponsable->idPersona;
			$insertNoConformidad['idCBITipo']=1;
            $insertNoConformidad['idCBIOpcion']=29;
            $insertNoConformidad['idCBIArea']=23;
			$this->procesamientoncmodel->insertarNC($insertNoConformidad);
		}
       if(isset($_POST['peticionAJAX']))
       {
	    $respuesta=array();
	    $respuesta['success']=true;
       echo json_encode($respuesta);
       }
       else{
		$direccion	= 'Location:'.base_url()."actividades/ver/".$_POST['folioActividad'];
    	header($direccion);}
	}/*! guardarCalificacion */

//--------------------------------------------------------------
function pasarActividadParacobranza()
{
	
	
	if(isset($_POST['comentarioParaCobranza']))
    {

      if($_POST['comentarioParaCobranza']!=''){
      $consultaCobranza='select * from cobranzaactividad where folioActividad="'.$_POST['folioActividad'].'"';
      $resp=$this->db->query($consultaCobranza)->result();
      if(count($resp)==0)
       {
         $ins['comentario']=$_POST['comentarioParaCobranza'];
         $ins['folioActividad']=$_POST['folioActividad'];
         $ins['idActividad']=$_POST['idInterno'];
         $this->db->insert('cobranzaactividad',$ins);
          $nombre=$this->db->query('select name_complete from users u where u.email="COBRANZA@ASESORESCAPITAL.COM"')->result()[0]->name_complete;
         $update['usuarioResponsable']='COBRANZA@ASESORESCAPITAL.COM';
         $update['nombreUsuarioResponsable']=(string)$nombre;
         $update['semaforoIncremento']='00:00:00';
         $update['responsableAntesDeCobranza']=$_POST['usuarioResponsable'];
         $this->db->where('idInterno',$_POST['idInterno']);
         $this->db->update('actividades',$update);
         			  	$insertCorreo="insert into envio_correos(fechacreacion,desde,para,copia,copiaoculta,asunto,mensaje,status,fechaenvio,identificaModulo)";
			$insertCorreo=$insertCorreo.'values(now(), "Cambio da actividad<avisosgap@aserorescpital.com>","'.$_POST['usuarioCreacion'].'",0,0,"Actividad en cobranza","La actividad '.$_POST['folioActividad'].' se encuentra en cobranza",0,now(),"Actividad");';
			
			 $this->db->query($insertCorreo);


       }
       
      }
    }

}
//----------------------------------------------------------------
	function modificarActividad()
	{
		
	     $folio=$this->comprobarActividadClienteNuevo($this->input->post('folioActividad', TRUE));
         $folioActividad	= $this->input->post('folioActividad', TRUE);		
         $Comentario	='';

       if($folio->bandera)
       {
			if(isset($_POST['motivoCambio'])){$actualizar['motivoCambio']=$_POST['motivoCambio'];}
	 		$actualizar['Status']=$_POST['Status'];	 	
	 	    $actualizar['idPersonaTrabaja']=0;
            $actualizar['trabajandoseActividad']=0;	 
            $actualizar['comentarioTemporal']=$_POST['textoComentario'];
            $this->agregarNotificacionActividad($_POST['folioActividad'],'Se realizo un cambio');
	 		$this->capsysdre_actividades->actualizarActividad($_POST['folioActividad'],$actualizar);
	 		$status='';

	 		if($_POST['Status']==1){$status='AGENTE GAP';}
	 		if($_POST['Status']==2){$status='ASEGURADORA';}
	 		if($_POST['Status']==5){$status='EN CURSO';}
	 		if($_POST['Status']==6){$status='FINALIZADA';}

	 		    $insertar['folioActividad']=$_POST['folioActividad'];
         $insertar['comentario']='La actividad esta en '.$status;
        $this->comentariosGuardar($insertar);
       }
       else{
		if(isset($_POST['Concepto'])){$update['Concepto']=$_POST['Concepto'];}
		if(isset($_POST['FEmision'])){$update['FEmision']=$_POST['FEmision'];}
		/*=============================PARA CAPTURA======================================*/
		if(isset($_POST['cambioPropietario'])){$update['IDUSERR']=20;$actualizar['captura']=1;}
		                     /*===============================FIN DE COMENTARIO===============================*/
		if($_POST['tipoActividadSicas']=='tarea')
		{
			$update['IDTarea']=$_POST['IDDocto'];
			$update['Status']=$_POST['Status'];
			//$update['IDUSERR']=20;
			$respuesta=$this->ws_sicas->actualizaTarea($update);
		}else{
			$update['IDDocto']=$_POST['IDDocto']; 
			$update['StatusUser']=$_POST['Status'];
			$respuesta=$this->ws_sicas->actualizaOT($update);
		}
	
		if($_POST['Status']==1  && $_POST['motivoCambio']!=''){
			$consulta		='select p.celPersonal from actividades a left join persona p on  p.IDVend=a.IDVend where a.folioActividad="'.$_POST['folioActividad'].'"';
			$motivoConsulta	= 'select motivoCambio from catalog_motivocambioactividades where idMotivaCambio='.$_POST['motivoCambio'];		
    	    $motivo	= $this->db->query($motivoConsulta)->result()[0]->motivoCambio;
			$resp	= $this->db->query($consulta)->result();
			if((count($resp))>0){
				$telefono=$this->whatssms->comprobarNumero($resp[0]->celPersonal);
				if($telefono!=0){
					$sms['message']='La actividad '.$_POST['folioActividad'].' a sido devuelta,'.$motivo.','.base_url().'actividades/ver/'.$_POST['folioActividad'];
          			
           			$sms['numbers']=$telefono; 
					$res=$this->whatssms->enviarSMS($sms);
				}
			}
		}

		if(isset($respuesta['Sucess']))
		{
			if($respuesta['Sucess']){	 		 
			$Procedencia	= $this->input->post('Procedencia', TRUE);			
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
	 		$actualizar['Status']=$_POST['Status'];	 	
	 	    $actualizar['idPersonaTrabaja']=0;
            $actualizar['trabajandoseActividad']=0;	 
            $actualizar['comentarioTemporal']=$_POST['textoComentario'];
             $this->agregarNotificacionActividad($_POST['folioActividad'],'Se realizo un cambio ');
	 		$this->capsysdre_actividades->actualizarActividad($_POST['folioActividad'],$actualizar);

			}
		}
    $this->pasarActividadParacobranza();
    }

    $insertACE['folioActividad']=$_POST['folioActividad'];
    $insertACE['idInterno']=$_POST['idInterno'];
    $insertACE['jsonActividad']=json_encode($_POST);
    $insertACE['userEmail']=$this->tank_auth->get_usermail();
    $this->db->insert('actividadescambiosestado',$insertACE);
    if(isset($_POST['peticionAJAX'])){$respuesta['success']=1;echo json_encode($respuesta);}
    else{$direccion='Location:'.base_url()."actividades/ver/".$_POST['folioActividad'];
    header($direccion);}
	}/*! modificarActividad */


//----------------------------------------
function devolverBitacoraDeActividad()
{
  $respuesta['success']=true;

  	$bitacora=$this->db->query("select ac.folioActividad,(concat(ac.comentario,' [',ac.username,']')) as Comentario,(ac.fechaInsercion) as FechaHora,'5' as IDUser,'' as Procedencia from actividadescomentarios 
ac where ac.folioActividad='".$_POST['folioActividad']."' order by ac.idComentario desc")->result();
  	
$respuesta['verBitacoraActividadCotizacion']=array(); 
$respuesta['verBitacoraActividad']=array();
$respuesta['actividad']=array();
if(count($bitacora)>0){
$respuesta['verBitacoraActividadCotizacion']=$bitacora;
}
			/*$data['infoCliente']			= $this->ws_sicas->obtenerClientePorID($idCliente)->TableInfo;//$this->capsysdre_actividades->DetalleCliente($idCliente.'-'.$idContacto);
			$data['cliente']				= $this->clientemodelo->obtenerDatosCliente($idCliente);
						
			$claveBit						= $data['infoFolioActividad']->ClaveBit;*/


			if($_POST['ClaveBit']!=''){
			$respuesta['verBitacoraActividad'] 	= $this->capsysdre_actividades->InfoBitacoras($_POST['ClaveBit']);
              }
              
      if(isset($_POST['idInterno'])){
   		$respuesta['actividad']=$this->actividades_model->actividadPorIdObtener($_POST['idInterno'])['actividad'];
  
      }
  if(isset($_POST['peticionAJAX']))
  	{
  echo json_encode($respuesta);
  	}
  else{return $respuesta;}
}
//----------------------------------------

	function agregarCompaniaAdicional()
	{
		$respuesta=array();
		$respuesta['mensaje']="YA EXISTE ESA COMPANIA RELACIONADA A ESTA ACTIVIDAD";
		$respuesta['success']=false;
		$existeFolio=$this->capsysdre_actividades->comprobarExistenciaActividad($_POST['folioActividad']);
		$existePromotoria=$this->catalogos_model->comprobarExistenciaPromotoria($_POST['idPromotoria']);
		if($existeFolio && $existePromotoria)
		{
			if(!$this->capsysdre_actividades->comprobarExistenciaRAP($_POST['folioActividad'],$_POST['idPromotoria']))
		{
				$insert['idPromotoria']=$_POST['idPromotoria'];
				$insert['folioActividad']=$_POST['folioActividad'];
				$insert['idSubRamo']=$_POST['IDSRamo'];
          $insert['tipoActividad']=$_POST['tipoActividad'];
          $insert['idPersona']=$this->tank_auth->get_idPersona();
          $insert['idRelActividadPromotoria']=-1;
          $this->catalogos_model->relActividadPromotoria($insert);
          $respuesta['mensaje']="COMPANIA GUARDADA PARA LA ACTIVIDAD";
          $respuesta['success']=true;
          	//Modificado [Suemy][2024-07-23]
            $this->verificaExistenciaSemaforo($_POST['idPromotoria'],$_POST['IDSRamo'],"agregarCompaniaAdicional");
         }

        }
    if(isset($_POST['peticionAJAX'])){echo json_encode($respuesta);}
     else
     {
	 $direccion='Location:'.base_url()."actividades/ver/".$_POST['folioActividad'];
     header($direccion);
    }

	}/*! agregarCompaniaAdicional */
	
//------------------------------------------------------------------------------------

	function ver()
	{
		$this->load->library(array("webservice_sicas_soap","role"));
		
		if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
		else if(!$this->uri->segment(3)){ redirect('actividades');} 
		else {			
		/*============ VERIFICA QUE EL FOLIO EXISTA=========================*/
			if(!$this->capsysdre_actividades->validacionFolioActividad($this->uri->segment(3))){redirect('actividades');}
$data['verDocumentosActividad']=array();
			$data['saldo']					= $this->saldo_model->saldo($this->tank_auth->get_user_id());
			$data['statusActividades']		= $this->capsysdre_actividades->statusActividades();		
			$data['configModulos']			= array( 'modulo' => 'configuraciones');
			$data['SelectTipoImg']			= $this->capsysdre_actividades->SelectTipoImg(0);			
			$data['infoFolioActividad']		= $this->capsysdre_actividades->infoFolioActividad($this->uri->segment(3));
			$data['infoFolioActividadEmi']	= $this->capsysdre_actividades->infoFolioActividadEmi($this->uri->segment(3));
			$data['calificaciones']			= $this->capsysdre_actividades->obtenerCalificaciones();
			if($data['infoFolioActividadEmi'] == "")
			{
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
				 $data['tipoActividadParaCaptura']=$data['infoFolioActividad']->tipoActividad;
			} 
			else 
			{

				$data['promotorias']							= $this->capsysdre_actividades->obtenerPromotoriaPorActividad($data['infoFolioActividad']->folioActividad,'Emision');
				$data['infoFolioActividad']->usuarioResponsable	= $data['infoFolioActividadEmi']->usuarioResponsable;
				$data['infoFolioActividad']->motivoCambio=$data['infoFolioActividadEmi']->motivoCambio;
				$data['tipoActividadParaCaptura']=$data['infoFolioActividadEmi']->tipoActividad;
			}
		 
			if($data['infoFolioActividad']->usuarioResponsable==$this->tank_auth->get_usermail()){

				//$data['permisos']['tarjetaBancoActividad']	= "";
				$data['permisos']							= $this->personamodelo->permisosPersona('actividades');
								$data['permisos']['modificarActividad']		= "";
				$data['permisos']['calificarActividad']		= "";
			} 
			else { $data['permisos']							= $this->personamodelo->permisosPersona('actividades');}

			if(isset($data['permisos']['tarjetaBancoActividad']))
			{

				$idCliente['IDCli']=$data['infoFolioActividad']->idCliente;
				$data['tarjetasDelCliente']=  $this->personamodelo->tarjetaPersona($idCliente);

			}

			$idSicas						= $data['infoFolioActividad']->idSicas;
			
			if($data['infoFolioActividad']->tipoActividadSicas == "ot"){$data['infoDocumento']		= $this->capsysdre_actividades->DetalleDocumento($idSicas);} 

            $data['actividadCalificada']	= $this->capsysdre_actividades->obtenerActividadCalificada($data['infoFolioActividad']->folioActividad,$data['infoFolioActividad']->tipoActividad)[0]->total;
            //	
			$idCliente						= $data['infoFolioActividad']->idCliente;
			$idContacto						= $data['infoFolioActividad']->idContacto;
            
			//$data['infoCliente']			= $this->capsysdre_actividades->DetalleCliente($idCliente.'-'.$idContacto);
		$data['configModulos'] = $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());
     	$data['ckeditor']				= array('id'		=> 	'Comentario',
												'path'		=>	'assets/js/ckeditor',
												'config'	=> array('width' 	=> 	"99%",		//Setting a custom width
																	 'height' 	=> 	'100px',	//Setting a custom height
																	'toolbar' 	=> 	array('/')
																	 )
											  );

 			$folio=array();
			$folio=$this->comprobarActividadClienteNuevo($this->uri->segment(3));
			$data['ocultarParaClienteNuevo']='';
if($folio->bandera)
{
	$data['ocultarParaClienteNuevo']='display:none';
$xmlstr = <<<XML
<?xml version='1.0' standalone='yes'?>
<cliente>
<IDCli>7</IDCli>
</cliente>
XML;

$data['ClienteContact']['cliente']=new SimpleXMLElement($xmlstr);
$xmlVerDoxumentosActividad=<<<XML
<?xml version='1.0' standalone='yes'?>
XML;


$data['verDocumentosActividad']	=array();
$data['cliente']=array();//BUSCAR LOS DATOS EN LA TABLA DE CRM
//$_GET['IDCli']=1;
 $bitacora=$this->db->query("select ac.folioActividad,(concat(ac.comentario,' [',ac.username,']')) as Comentario,(ac.fechaInsercion) as FechaHora,'5' as IDUser,'' as Procedencia from actividadescomentarios 
ac where ac.folioActividad='".$this->uri->segment(3)."' order by ac.idComentario desc")->result(); 
#$data['verBitacoraActividad']=$bitacora;
$cliente='select (cc.IDCli) as IDCli,0 as PUNTOS,(concat(cc.Nombre," ",cc.ApellidoP," ",cc.ApellidoM)) as NombreCompleto,"" as idPersonaAgente,((concat(cc.Nombre," ",cc.ApellidoP," ",cc.ApellidoM))) as nombreCliente,cc.preferenciaComunicacion,cc.horarioComunicacion,cc.diaComunicacion,cc.Telefono1,"" as idContacto,cc.EMail1,cc.ApellidoP,cc.ApellidoM,cc.Nombre,cc.RFC,"" as CURP,cc.tipoEntidad,"" as Calidad,"" as Expediente,"" as TipoEnt,(cc.fecha_nacimiento) as FechaNac,(cc.fecha_constitucion) as FechaConst,(TIMESTAMPDIFF(year,cc.fecha_nacimiento,curdate())) as Edad,"" as ClaveTKM,cc.Sexo as Sexo,cc.RazonSocial,"" as IDCont,if(cc.CP is null,"SIN CP",cc.CP) as codigoPostal,(TIMESTAMPDIFF(year,cc.fecha_nacimiento,curdate())) as edad from clientes_actualiza cc where cc.IDCli='.$folio->IDCliClienteActualiza;

$data['cliente']=$this->db->query($cliente)->result(); 
$data['infoCliente']=$this->db->query($cliente)->result();
$data["ClienteContact"]['cliente']	=$this->db->query($cliente)->result()[0];
if($data["ClienteContact"]['cliente']->tipoEntidad=='Moral'){$data["ClienteContact"]['cliente']->TipoEnt=1;}
else{$data["ClienteContact"]['cliente']->TipoEnt=0;}
#$archivoCliente=$this->manejodocumento_modelo->devolverArchivos('assets/img/archivosClientesNuevos/'.$folio->IDCliClienteActualiza.'/');
#$archivoDocumento=$this->manejodocumento_modelo->devolverArchivos('assets/img/archivosClientesNuevos/'.$folio->IDCliClienteActualiza.'/Documentos/');
$archivos=array();
  
$archivoMostrar=array();
#$archivos=array_merge($archivoCliente,$archivoDocumento);
foreach ($archivos as $key => $value) 
{
	  $agregar=new stdClass ;
	  $agregar->text=$value['nombreArchivo'];
	  $agregar->NameShow=$value['nombreArchivo'];
	  $agregar->href=$value['PathWWW'];
	  $agregar->PathWWW=$value['PathWWW'];
	  $agregar->DateModify=$value['DateModify'];
	  $agregar->Tipo=1;
  array_push($archivoMostrar, $agregar)	;
}
$data["msj"] = '';
$data['infoFolioActividad']->tipoActividadSicas="ot";
#$data['verDocumentosActividad']=$archivoMostrar;
$data['verBitacoraActividadCotizacion']=array();

} 
else{

	$bitacora=$this->db->query("select ac.folioActividad,(concat(ac.comentario,' [',ac.username,']')) as Comentario,(ac.fechaInsercion) as FechaHora,'5' as IDUser,'' as Procedencia from actividadescomentarios 
ac where ac.folioActividad='".$this->uri->segment(3)."' order by ac.idComentario desc")->result(); 
#$data['verBitacoraActividadCotizacion']=$bitacora;
			$data['infoCliente']			= $this->ws_sicas->obtenerClientePorID($idCliente)->TableInfo;//$this->capsysdre_actividades->DetalleCliente($idCliente.'-'.$idContacto);
			$data['cliente']				= $this->clientemodelo->obtenerDatosCliente($idCliente);
						
			$claveBit						= $data['infoFolioActividad']->ClaveBit;
#			$data['verBitacoraActividad'] 	= $this->capsysdre_actividades->InfoBitacoras($claveBit);

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
	
			
			$data["msj"] = '';
			if (array_key_exists("msj", $_GET)){$data["msj"] = $_GET["msj"];}
			
			// ** !New Info Cliente **//
			
			
			if($data['infoFolioActividad']->tipoActividadSicas == "ot"){
				$TypeDestinoCDigital		= "DOCUMENT";
				$IDValuePK					= $data['infoFolioActividad']->idSicas;
			} else {
				$TypeDestinoCDigital		= "CLIENT";
				$IDValuePK					= $data['infoFolioActividad']->idCliente;
			}
             //
			#$data['verDocumentosActividad']	= $this->capsysdre_actividades->InfoDocumento($TypeDestinoCDigital, $IDValuePK);

		#$data['verDocumentosActividad']	= $this->ws_sicas->docDeActividades($IDValuePK,$TypeDestinoCDigital);
			if($data['infoFolioActividad']->tipoActividad=="Cotizacion" || $data['infoFolioActividad']->tipoActividad=="Emision"){
				$data['agregarCompania']	=$this->catalogos_model->devolverCompanias();
			} 
			

			//** $this->load->view('actividades/ver', $data);
    }
error_reporting(0);			
    foreach ($data['verDocumentosActividad'] as $key => $value) 
    	{
    		$fecMatriz=explode('/', $value->DateModify);
    		$value->DateModify=$fecMatriz[2].'/'.$fecMatriz[1].'/'.$fecMatriz[0];
    	}     
usort($data['verDocumentosActividad'], $this->object_sorter('DateModify','DESC'));

	  session_start();
if(!isset($_SESSION['versionNuevaActividad'])){$_SESSION['versionNuevaActividad']=false;}
	
			

							if(isset($_GET['servidor']))
				{
                    if(($_GET['servidor']))
                    {  
                    $_SESSION['versionNuevaActividad']=true;

                    $this->load->view('actividades/verS',$data);
				}
                   else
                   {
                   	$_SESSION['versionNuevaActividad']=false;
                    $this->load->view('actividades/ver',$data);
			}
		}
	            else
	             {	
	               if($_SESSION['versionNuevaActividad']){$this->load->view('actividades/verS',$data);}		
	             	else{$this->load->view('actividades/ver',$data);}
	             }
	          
			

		}
	}/*! ver */
	
//----------------------------------------------------
function object_sorter($clave,$orden=null) {
    return function ($a, $b) use ($clave,$orden) {
          $result=  ($orden=="DESC") ? strtotime($b->$clave) > strtotime($a->$clave) :  strtotime($a->$clave)>strtotime( $b->$clave);
         
          return $result;
    };
}
//-------------------------------------
function pruebaDocto()
{
	$d=$this->ws_sicas->docPrueba(143702);
	
}	
//----------------------------------------
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

	$mysqli = new mysqli('www.capsys.com.mx','root','VikinGo@52x','capsysV3');

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
		if(is_numeric($valores[1])){$array['montoRAP']=$valores[1];}
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
	function updateClient(){
		
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
							"Param3"		=> $IdCli,
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
			
###########################$res = $this->webservice_sicas_soap->UpdateContacto($data);
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
			
//			$res = $this->webservice_sicas_soap->UpdateContacto($data);cffff
######################################			$res = $this->UpdateContacto($data);
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
					"IDRelation"	=> '0',
					"Param3"		=> '0'
				  );
			
		//echo '<pre>';
		//print_r($data);
			
####$res	= $this->UpdateContacto($data);
		$msj	= '';
		
//		var_dump($res);	

		if ($res->DATAINFO->Sucess[0] == "0")
		{
			$msj = htmlentities($res->DATAINFO->MsgError);
			redirect('actividades/ver/'.$folioActividad.'?msj=').$msj;
		} 
		else {redirect('actividades/ver/'.$folioActividad);}

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
   $consulta['where']='';
   if($condicion!=''){$consulta['where']=' and('.$condicion.')'; }
    $datos['actividades']=$this->capsysdre_actividades->devolverActividades($consulta);
    $cantActividades=count($datos['actividades']);
    $personaVendedorCant=count($personaVendedor);
    for($i=0;$i<$cantActividades;$i++)
    {
    	$in.=$datos['actividades'][$i]->idInterno.',';
     
      for($j=0;$j<$personaVendedorCant;$j++)
      {
      	if($datos['actividades'][$i]->IDVend==$personaVendedor[$j]->idVend)
      	{
      	 $datos['actividades'][$i]->idPersona=$personaVendedor[$j]->idPersona;
      	 $datos['actividades'][$i]->nombreVendedor=$personaVendedor[$j]->nombres.' '.$personaVendedor[$j]->apellidoPaterno.' '.$personaVendedor[$j]->apellidoMaterno;
      	 /*if($datos['actividades'][$i]->motivoCambio==1)
      	 {
      	 	$consultaCompleta='select * from actividadespartidas a where a.idInterno='.$datos['actividades'][$i]->idInterno;
      	 	$respCompleta=$this->db->query($consultaCompleta)->result();
      	 	
      	 	if(count($respCompleta)<=2)
      	 	{
              $datos['actividades'][$i]->motivoCambio='COMPLETA';
      	 	}
      	 	else
      	 	{
              $datos['actividades'][$i]->motivoCambio='COMPLETA(RETRABAJO)';
      	 	}
      	 }*/
      	}

      }	
    }
     $in = substr($in, 0, -1);
   
 	$this->load->view('actividades/consultaActividades',$datos);
 }
 //-------------------------------------------------------------------
function devolverActividades()
 {
 	$select['IDVend']=$_POST['idVend'];
 	$respuesta['actividades']=$this->capsysdre_actividades->devolverActividades($select);
 	
 	echo json_encode($respuesta);
 }
//--------------------------------------
function z()
{
	$d=$this->db->query('select * from actividades a where a.`Status`=1 and a.motivoCambio=1')->result();
	$cad='';
	foreach ($d as $key => $value) 
	{
	  $cad.=$value->idInterno.',';	
	}
	
}
//--------------------------------------
function devolverActividadesPartidas()
{
  $datos=array();
  $respuesta='';
  
  //$fFinal=$this->libreriav3->convierteFecha($_POST['fFinal']);
  //$fInicial=$this->libreriav3->convierteFecha($_POST['fInicial']);
   $fFinal=$_POST['fFinal'];
   $fInicial=$_POST['fInicial'];
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
  // 
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
//echo "<pre>";

		(string)$xml = "";
		$xml	= '<?xml version="1.0" encoding="utf-8"?><soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:tem="http://tempuri.org/"> <soap:Header/> <soap:Body> <ProcesarWS xmlns="http://tempuri.org/"> <oDataWS> <Credentials>';
		
		$xml	= $xml.'<UserName>'.$this->user.'</UserName>';
		$xml	= $xml.'<Password>'.$this->pass.'</Password>';
		$xml	= $xml.'<CodeAuth>'.$this->auth.'</CodeAuth></Credentials>';
		$xml	= $xml.'<CredentialsUserSICAS><UserName>SISTEMAS@ASESORESCAPITAL.COM</UserName>';
		$xml	= $xml.'<Password>ACHAN2019</Password></CredentialsUserSICAS>';
		
//		print_r($wsdata);
		
		foreach($wsdata as $key => $value){
			if($key != "XML"){
			$xml	= $xml.'<'.$key.'>'.(string)$value.'</'.$key.'>';
			}
//			print($value."<br />");
//			print($xml."<br />");
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
					curl_setopt($ch, CURLOPT_URL, 'https://www.sicasonline.info/SOnlineWS/WS_SICASOnline.asmx?WSDL');
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

	function setSemaforo($idInterno,$semaforo){
		$sql="UPDATE actividades set semaforo='$semaforo' where idInterno='$idInterno'";
		$this->db->query($sql);
	}
//======================================================
/*||NUEVO CODIGO PARA CREAR ACTIVIDADES DE PROSPECCION||*/
//======================================================
function obtenerResponsableActividad($actividad='',$ramo='',$subRamo='', $idVend='')
{

  $userResponsable="";
/*if($this->input->post('tipoActividad', TRUE)!="CapturaEmision" && $this->input->post('tipoActividad', TRUE)!="AclaraciondeComisiones" ){
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
		  if($this->input->post('tipoRamo', TRUE)=="DANOS" || $this->input->post('tipoRamo', TRUE)=="DAÑOS")	{
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
	else{$userResponsable="AUTOSRENOVACIONES@ASESORESCAPITAL.COM";}
}
if($this->input->post('IDSRamo', TRUE)==20){$userResponsable="AUTOSRENOVACIONES@ASESORESCAPITAL.COM";}*/
/*$consultaSucursal='select d_catalog_sucursales FROM persona WHERE IDVend='.$idVend;
$datosSucursal=$this->db->query($consultaSucursal)->result();
$consultaCanal= 'select d_catalog_canales FROM persona WHERE IDVend='.$idVend;
$datosCanal=$this->db->query($consultaCanal)->result();
if ($datosSucursal){
	if($datosSucursal[0]->d_catalog_sucursales=1 or $datosSucursal[0]->d_catalog_sucursales=7){
		$area="COORDINADOR@CAPCAPITAL.COM.MX";
	}else{
		if($datosSucursal[0]->d_catalog_sucursales=2){
			$area="COORDINADORCOMERCIAL@CAPCAPITAL.COM.MX";
		}
	}
}
if ($datosCanal){
	if($datosCanal[0]->d_catalog_canales=2){
		$area="COORDINADORINSTITUCIONAL@AGENTECAPITAL.COM";
	}else{
		if($datosCanal[0]->d_catalog_canales=3){
			$area="COORDINADORCOMERCIAL@FIANZASCAPITAL.COM";
		}
	}
}*/

//$consultaArea='select userEmailCreacion FROM persona WHERE IDVend='.$idVend;
$consultaArea='select p.userEmailCreacion FROM users u left join persona p on p.idPersona=u.idPersona WHERE  u.banned=0 and u.activated=1 and u.IDVend='.$idVend;
$datosArea=$this->db->query($consultaArea)->result();


if($ramo=="ACCIDENTES_Y_ENFERMEDADES"){$ramo='ACCIDENTES Y ENFERMEDADES';}

if(count($datosArea)>=1)
{
	$consulta='select ap.email from actividadespermisos ap where ap.actividad="'.$actividad.'" and  ap.ramo="'.$ramo.'" and ap.subRamo="'.$subRamo.'" and ap.area="'.$datosArea[0]->userEmailCreacion.'"';	
	$datos=$this->db->query($consulta)->result();
}
else
{
	$consulta='select ap.email from actividadespermisos ap where ap.actividad="'.$actividad.'" and  ap.ramo="'.$ramo.'" and ap.subRamo="'.$subRamo.'"';
	$datos=$this->db->query($consulta)->result();
}

if(count($datos)==0)
{
	$consulta='select ap.email from actividadespermisos ap where ap.actividad="'.$actividad.'" and  ap.ramo="'.$ramo.'" and ap.subRamo="'.$subRamo.'"';
	$datos=$this->db->query($consulta)->result();
}

if(count($datos)==1){$userResponsable=$datos[0]->email;	}else
{
	if(count($datos)==0){ $userResponsable='GERENTECOMERCIAL@AGENTECAPITAL.COM';}  
	else{$userResponsable=$datos[0]->email;}
}

$email=$this->tank_auth->get_usermail();
if($email=="CLIENTECORPORATIVO"){$userResponsable="EJECUTIVOCORPORATIVO@AGENTECAPITAL.COM";}
//echo($userResponsable);
return $userResponsable;

}

//---------------------------------------------------
function mandarCorreoImportante()
{
	/*=============================== SI ES UN CORREO IMPORTANTE MANDAMOS EL CORREOS=============*/
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
			#$this->email->send();
			}
			/* !New Envio Correo Importante */

/*============================================================================================*/

}
//---------------------------------------------------
function grabarActividadCompania($array=null)
{
/*================================================================*/
/*===============ESTABLECE LA RELACION ENTRE LA ACTIVIDAD Y LA COMPANIA=============*/
			if($this->input->post('tipoActividad', TRUE)=='Cotizacion')
			{	
				if(isset($_POST['cbCompania'])){
					foreach ($_POST['cbCompania'] as  $value) 
					{	
						//Modificado [Suemy][2024-07-23]
						$this->verificaExistenciaSemaforo($value,$this->input->post('IDSRamo', TRUE),"grabarActividadCompania");	
						$insert['idPromotoria']				= $value;
	             		$insert['folioActividad']			= $this->input->post('folioActividad', TRUE);
    	         		$insert['idSubRamo']				= $this->input->post('IDSRamo', TRUE);
        	     		$insert['idRelActividadPromotoria']	= -1;
            	 		$insert['tipoActividad']			= $this->input->post('tipoActividad', TRUE);
             			$this->catalogos_model->relActividadPromotoria($insert);
					}
				}
			}
			else
			{	
				if(isset($_POST['selectCompania']))
				{  $idPromotoria=0;
					if($this->input->post('selectCompania', TRUE)!=''){$idPromotoria=$this->input->post('selectCompania', TRUE);}
					$insert['idPromotoria']				=$idPromotoria; //$_POST['selectCompania'];
             		$insert['folioActividad']			= $folioActividad;
             		$insert['idSubRamo']				= $this->input->post('IDSRamo', TRUE);
             		$insert['idRelActividadPromotoria']	= -1;
             		$insert['tipoActividad']=$this->input->post('tipoActividad',TRUE);
             		//$insert['tipoActividad']			= "Emision";
             		//$insert['tipoActividad']			= "Endoso";
             		//$this->catalogos_model->relActividadPromotoria($insert);             	
				}
			}		
/*==========================================================================================*/	

}

function comprobarDatosActividad()
{
$array['valida']=true;
$array['mensaje']='';
$array['idObjeto']='';
$array['clienteExistente']='';

if(trim($this->input->post('datosExpres', TRUE))==''){$array['mensaje']='Es necesario agregar un comentario';$array['idObjeto']='datosExpres'; }
  if($this->input->post('tipoActividad', TRUE)=='Cotizacion')
  {
  	if(!isset($_POST['cbCompania'])){$array['mensaje']='Debe seleccionar Compania';$array['idObjeto']='cbCompania';}  	
  }  	
  else
  {
  	if($this->input->post('tipoActividad', TRUE)=='Emision')
  	{
  	  if(isset($_POST['selectCompania']))
     	{
  	    if($_POST['selectCompania']==''){$array['mensaje']='Debe seleccionar Compania';$array['idObjeto']='tipoActividad';}
  	    }  
  	   if(isset($_POST['pagoConducto']))
  	    {
  	     if($_POST['pagoConducto']==''){$array['mensaje']='Debe seleccionar un conducto de pago';$array['idObjeto']='pagoFormas';}
  	    }  
  	   if(isset($_POST['pagoFormas']))
      	{
  	     if($_POST['pagoFormas']==''){$array['mensaje']='Debe seleccionar forma de pago';$array['idObjeto']='pagoFormas';}
  	    }


  	}
  	else
  	{
       if(isset($_POST['polizaNew']))
       {
       	if(trim($_POST['polizaNew'])==''){$array['mensaje']='Debe escribir el numero impreso de la poliza';$array['idObjeto']='polizaNew';}
       }
  	} 
  	  	    if(isset($_POST['rfcCliente']))
      	{
  	     if($_POST['rfcCliente']==''){$array['mensaje']='Escribir el RFC';$array['idObjeto']='rfcCliente';}
  	     else
  	     {
  	     	
  	     	$clienteExistente=$this->ws_sicas->rfcClienteObtener($_POST['rfcCliente']);
  	     	//
  	     	if((int)$clienteExistente->TableControl->MaxRecords==0)
  	     	{
               $resRFC=$this->libreriav3->comprobarRFC($_POST['rfcCliente'],$_POST['entidad']);
                if($resRFC['esRFC']==0){$array['mensaje']=$resRFC['mensaje'];}
  	     	}
  	     	else
  	     	{
  	     	  $array['mensaje']='Esta rfc ya esta relacionado con un cliente';
  	     	  $array['clienteExistente']=$clienteExistente->TableInfo;	
  	     	}

  	     }
  	    } 
  }

if($this->input->post('IDVend', TRUE)==''){$array['mensaje']='Debe seleccionar un agente';$array['idObjeto']='IDVend'; }
if(trim($this->input->post('EMail1', TRUE))==''){$array['mensaje']='Agregar un Email';$array['idObjeto']='textEmail'; }
else{if(!filter_var($this->input->post('EMail1', TRUE), FILTER_VALIDATE_EMAIL)){$array['mensaje']='No es un Email valido';$array['idObjeto']='textEmail';}}


   if(trim($this->input->post('celular', TRUE))==''){$array['mensaje']='Agregar Celular';$array['idObjeto']='textCelular'; }
  if($this->input->post('giroCliente', TRUE)==''){$array['mensaje']='Debe seleccionar un giro';$array['idObjeto']='giroCliente'; }
  if($this->input->post('entidad', TRUE)==''){$array['mensaje']='Debe seleccionar un Tipo Entidad';$array['idObjeto']='entidad'; }

 

  if($this->input->post('entidad', TRUE)=='Fisica')
  {
  
    if(trim($this->input->post('Nombre', TRUE))==''){$array['mensaje']='Debe agregar un nombre';$array['idObjeto']='textNombres';}
    if(trim($this->input->post('ApellidoM', TRUE))==''){$array['mensaje']='Debe agregar un apellido materno';$array['idObjeto']='textApellidoMaterno';}
    if(trim($this->input->post('ApellidoP', TRUE))==''){$array['mensaje']='Debe agregar un apellido paterno';$array['idObjeto']='textApellidoPaterno';}
  	if($this->input->post('fecha_nacimiento', TRUE)==''){$array['mensaje']='Debe seleccionar fecha de nacimiento';$array['idObjeto']='fecha_nacimiento';}
  	if($this->input->post('Sexo', TRUE)==''){$array['mensaje']='Debe seleccionar un Sexo';$array['idObjeto']='selectSexo';}
  }
  else
  {
    
    if($this->input->post('razonSocial', TRUE)==''){$array['mensaje']='Debe agregar la razon social';$array['idObjeto']='textRazonSocial';}
    if($this->input->post('fechaConstitucion', TRUE)==''){$array['mensaje']='Debe seleccionar fecha de constitucion';$array['idObjeto']='fechaConstitucion';}
  }

  if($this->input->post('entidad', TRUE)==''){$array['mensaje']='Debe seleccionar una entidad';$array['idObjeto']='selectRazon';}
  if($array['mensaje']!=''){$array['valida']=false;}
if($this->input->post('IDSRamo', TRUE)==''){$array['mensaje']='Debe seleccionar un SubRamo';$array['idObjeto']='selectSubRamo'; }
   	if($this->input->post('tipoRamo', TRUE)==''){$array['mensaje']='Debe seleccionar un Ramo';$array['idObjeto']='selectRamo';}
  return $array;
}
//---------------------------------------------------
function crearActividad($array=null)
{
/*===================ASIGNA A USUARIO RESPONSABLE Y CREAMOS LA ACTIVIDAD====================*/
$usuarioResponsable='';
$usuarioResponsable=$this->obtenerResponsableActividad($this->input->post('tipoActividad', TRUE),$this->input->post('tipoRamo', TRUE),$this->input->post('IDSRamo', TRUE),$_POST['IDVend']);


			$data = array(
				'folioActividad'	=>	$this->input->post('folioActividad', TRUE),
				'fechaCreacion'		=>	(string)date('Y-m-d H:i:s'),												
				'Status'			=>	"5",				
				'Status_Txt'			=>	"EN CURSO",				
				//'idCliente'			=>	$idCliente,
				'nombreCliente'		=>	$this->input->post('nombreCliente', TRUE),
				//'idContacto'		=>	$idContacto,
				'tipoActividad'		=>	$this->input->post('tipoActividad', TRUE),
				'ramoActividad'		=>	$this->input->post('tipoRamo', TRUE),
				'subRamoActividad'	=>	$this->input->post('tipoSubRamo', TRUE),
				//'actividadUrgente'	=>	$urge,
				//'actividadImportante'	=> $importante,
				'usuarioCreacion'	=>	$this->input->post('usuarioCreacion', TRUE),
				'usuarioResponsable'=>	$usuarioResponsable,/*$this->input->post('userResponsable', TRUE)*/
				'usuarioBolita'		=>	$this->input->post('userResponsable', TRUE),
				'datosExpres'		=>	$this->input->post('datosExpres', TRUE),
				//'poliza'			=>	$this->input->post('poliza', TRUE),
				'IDVend'			=>	$this->input->post('IDVend', TRUE),
				'usuarioVendedor'	=>	$this->capsysdre->EmailVendedor($this->input->post('IDVend', TRUE)),
				'nombreUsuarioVendedor'	=>	$this->capsysdre->NombreCompletoVendedor($this->input->post('IDVend', TRUE)),
				'notasDre'	=>	$this->capsysdre->NombreCompletoVendedor($this->input->post('IDVend', TRUE)),
				'nombreUsuarioCreacion'	=>  $this->capsysdre->NombreCompletoUsuarioCreacion($this->input->post('usuarioCreacion', TRUE)),
				'nombreUsuarioResponsable'	=> $this->capsysdre->NombreCompletoUsuarioResponsable($usuarioResponsable),				
				'tarjetaNumero'		=>	$this->input->post('numeroTarjeta', TRUE),
				'tarjetaMes'		=>	$this->input->post('mesTarjeta', TRUE),
				'tarjetaYear'		=>	$this->input->post('yearTarjeta', TRUE),
				'tarjetaCcv'		=>	$this->input->post('ccv', TRUE),
				'tarjetaTitular'	=>	$this->input->post('titularTarjeta', TRUE),
				'tarjetaTipo'		=>	$this->input->post('tipoTarjeta', TRUE),
				'tarjetaBanco'		=>	$this->input->post('bancoTarjeta', TRUE),
				'tarjetaTipoPago'	=>	$this->input->post('tipoPagoTarjeta', TRUE),
				//'idPagoConducto'	=>	$pagoConducto,
				//'idPagoFactura'	=>	$pagoFactura,
				//'idPagoFormas'	=>	$pagoFormas,
				//'direccionFactura'	=>	$this->input->post('direccionFactura', TRUE),
				//'cpFactura'	=>	$this->input->post('cpFactura', TRUE),
				//'rfcFactura'	=>	$this->input->post('rfcFactura', TRUE),
				'IDSRamo'=>$this->input->post('IDSRamo', TRUE),
				//'polizaVerde'=>$this->input->post('tarjetaVerde', TRUE),
				'tarjetaNumeroEncriptado'		=>	$this->input->post('numeroTarjeta', TRUE),
				'tarjetaCodigoSeguridad'		=>	$this->input->post('ccv', TRUE),
			    'idInternoPadre'		=>	$this->input->post('idInternoPadre', TRUE),
			    'IDCliClienteActualiza'		=>	$this->input->post('IDCliClienteActualiza', TRUE),
			); 
			  
     			$this->capsysdre_actividades->actividades_agregarGuardar($data);


}
//---------------------------------------------------
function comentariosGuardar($array)
{
  $array['username']=$this->tank_auth->get_usermail();
  $this->db->insert('actividadescomentarios',$array);
}

//---------------------------------------------------
function actualizarClienteActualiza($array=null)
{
  $fecharegistro=(string)date('Y-m-d H:i:s');
  $correoProcedente=$this->tank_auth->get_usermail();
  $idCliente= $this->input->post('IDCliSikas');
  $IDCli2=$this->input->post('IDPcien');
  $idSicas=$this->input->post('idSicas');
  $NumSolicitud=$this->input->post('NumSolicitud');
  $folioActividad=$this->input->post('folioActividad');
  //Cambios Edwin Marin
 $puntos=$this->personamodelo->obtenerPuntosProspeccionIndividual("COTIZAR");  
	$sqlInsert_Referencia = "Update `clientes_actualiza` set `EstadoActual` = 'COTIZADO', `folioActividad`='".$folioActividad."',`IDCliSikas`='".$idCliente."' where `IDCli`='".$IDCli2."'";                         
     $this->db->query($sqlInsert_Referencia);
	$referencia = $this->db->insert_id();
	$sqlInsert_grabapuntos = "Insert Ignore Into `puntaje` (`Usuario`, `IDCliente`,`FechaRegistro`,`EdoAnterior`,`EdoActual`,`PuntosGenerados`,`FolioActividad`,`idSicas`,`OT`,`IdClienteSikas`) Values(
									    '".$correoProcedente."',
									    '".$IDCli2."',
										'".$fecharegistro."', 
										'REGISTRADO',
										'COTIZADO',
										'".$puntos."',
										'".$folioActividad."',
										'".$idSicas."',
										'".$NumSolicitud."',
										'".$idCliente."'
									);
											";                         
	$this->db->query($sqlInsert_grabapuntos);
	$referencia = $this->db->insert_id();
	if(isset($_POST['tipoEntidad'])){$actualizarCliente['tipoEntidad']=$_POST['tipoEntidad'];}
    if(isset($_POST['fecha_nacimiento'])){if($_POST['fecha_nacimiento']!=''){$actualizarCliente['fecha_nacimiento']=$_POST['fecha_nacimiento'];}}
    if(isset($_POST['fechaConstitucion'])){if($_POST['fechaConstitucion']!=''){$actualizarCliente['fecha_constitucion']=$_POST['fechaConstitucion'];}}
    if(isset($_POST['Sexo'])){ if($_POST['Sexo']!=''){ $actualizarCliente['Sexo']=$_POST['Sexo'];}}
    if(isset($_POST['estado'])){$actualizarCliente['claveEstado']=$_POST['estado'];}
     $this->db->where('IDCli',$IDCli2);     
     $this->db->update('clientes_actualiza',$actualizarCliente);



}
//---------------------------------------------------
function actualizarCliente_Actualiza($array)
{
	if(isset($array['IDCli']))
	{
		if(isset($array['fecha_nacimiento']))
		{
		 $valFN = explode('-', $array['fecha_nacimiento']);
		 if(count($valFN) == 3)
		 {
		 	if(!checkdate($valFN[1], $valFN[2],$valFN[0])){unset($array['fecha_nacimiento']);}
		 }
		 else{unset($array['fecha_nacimiento']);}
		}
	  if(isset($array['fecha_constitucion']))
		{
		 $valFC = explode('-', $array['fecha_constitucion']);
		 if(count($valFC) == 3)
		 {
		 	if(!checkdate($valFC[1], $valFC[2], $valFC[0])){unset($array['fecha_constitucion']);}
		 }
		 else{unset($array['fecha_constitucion']);}
		}

		$this->db->where('IDCli',($array['IDCli']));
		$this->db->update('clientes_actualiza',$array);
       
	}
}
//---------------------------------------------------
function crearRecotizacionProspeccion()
{
	
	$actividad=$this->db->query('select * from actividades a where a.idInterno='.$_POST['idInternoPadre'])->result_array()[0];
	$idInternoPadre=$actividad['idInterno'];
	$folioPadre=$actividad['folioActividad'];
	unset($actividad['idInterno']);
	$actividad['folioActividad']=$this->capsysdre_actividades->CalculaNewFolioActividad();
	$actividad['Status']=5;
	$actividad['motivoCambio']=0;
	$actividad['idInternoPadre']=$idInternoPadre;
	$actividad['folioPadre']=$folioPadre;
	$this->db->insert('actividades',$actividad);
	 $promotorias=$this->capsysdre_actividades->devolverPromotoriActividad($_POST['folioActividad']);     


    $insertar['folioActividad']=$actividad['folioActividad'];
    $insertar['comentario']='Se adiciono una cotizacion con el folio '.$actividad['folioActividad'];
    $this->comentariosGuardar($insertar);       
    $insertar['folioActividad']=$actividad['folioActividad'];
    $insertar['comentario']=$this->input->post('datosExpres', TRUE);
    $this->comentariosGuardar($insertar);
     foreach ($promotorias as $key => $value) 
     {
     	$ins=array();
     	$ins['idPromotoria']=$value->idPromotoria;
     	$ins['folioActividad']=$actividad['folioActividad'];
     	$ins['idSubRamo']=$value->idSubRamo;
     	$ins['tipoActividad']=$value->tipoActividad;
     	$this->db->insert('relactividadpromotoria',$ins);
     }

	
	redirect('actividades/ver/'.$actividad['folioActividad']);
}
//---------------------------------------------------
function guardarActividad()
{
	
  $data=array();
  $data['mensaje']='';
  $data['exito']=true;  
  $data['folioActividad']='';
  //$hayCotizacion=0;
  $valida=array();
  $hayCotizacion=$this->db->query('select (count(a.idInterno)) as contador from actividades a where a.IDCliClienteActualiza='.$_POST['IDCliClienteActualiza'])->result()[0]->contador;
  
  if($hayCotizacion>0)
  	{
  	 $valida['idObjeto']='datosExpres';
     $valida['mensaje']="YA EXISTE UNA COTIZACION PARA ESTE PROSPECTO Y POR EL MOMENTO NO SE PUEDE REALIZAR OTRA COTIZACION A ESTE PROSPECTO";
     $valida['valida']=FALSE;
      $data['exito']=$valida['valida'];
    }
    else
    {
       $valida=$this->comprobarDatosActividad();
      $data['exito']=$valida['valida'];
    }

  if($valida['valida'])
  {
     $consulta='select (csr.Nombre) as subRamo,(cr.Nombre) as ramo from catalog_subRamos csr left join catalog_ramos cr on cr.IDRamo=csr.IDRamo where IDSRamo='.$this->input->post('IDSRamo', TRUE);
     $nombreRamoSubRamo=$this->db->query($consulta)->result()[0];     
     if($nombreRamoSubRamo->ramo=='ACCIDENTES Y ENFERMEDADES'){$nombreRamoSubRamo->ramo='ACCIDENTES_Y_ENFERMEDADES';}
     if($nombreRamoSubRamo->ramo=='DAÑOS'){$nombreRamoSubRamo->ramo='DANOS';}     

     $actualizarCA['IDCli']=(int)$_POST['IDCliClienteActualiza'];
     $actualizarCA['Telefono1']=(string)$_POST['celular'];
     $actualizarCA['EMail1']=(string)$_POST['EMail1'];
     $actualizarCA['Sexo']=(int)$_POST['Sexo'];
     $actualizarCA['ApellidoP']=(string)$_POST['ApellidoP'];
     $actualizarCA['ApellidoM']=(string)$_POST['ApellidoM'];
     $actualizarCA['Nombre']=(string)$_POST['Nombre'];
     $actualizarCA['RazonSocial']=(string)$_POST['razonSocial'];
     $actualizarCA['fecha_nacimiento']=$_POST['fecha_nacimiento'];
     $actualizarCA['fecha_constitucion']=$_POST['fechaConstitucion'];
     $this->actualizarCliente_Actualiza($actualizarCA);
       
   if($_POST['tipoActividad']=='Emision' || $_POST['tipoActividad']=='CapturaEmision' || $_POST['tipoActividad']=='CambiodeConducto')
   {
   	 $_POST['tipoEntidad'] =$_POST['entidad'];
   	 $_POST['fecha_constitucion'] =$_POST['fechaConstitucion'];     
   	  $_POST['claveEstado'] =$_POST['estado'];          
      $_POST['giroActividad'] =$_POST['giroCliente'];
      $_POST['Telefono1'] =$_POST['celular'];                                   
      $_POST['tipoSubRamo'] =$nombreRamoSubRamo->subRamo;
      $_POST['tipoCliente'] ='Nuevo';
      $_POST['TipoEnt'] = 1;
      $_POST['IDDir'] = -1;
     $_POST['IDAgente'] = 63;
      $_POST['IDGrupo'] = 1;
      $_POST['tipoActividadSicas'] ='ot';
      $_POST['TipoDocto'] = 0; 
      $_POST['usuarioCreacion'] = $this->tank_auth->get_usermail();
      $_POST['usuarioResponsable'] =$this->obtenerResponsableActividad($_POST['tipoActividad'],$nombreRamoSubRamo->ramo,$_POST['IDSRamo'],$_POST['IDVend']);
      $_POST['usuarioBolita'] =$this->obtenerResponsableActividad($_POST['tipoActividad'],$nombreRamoSubRamo->ramo,$_POST['IDSRamo'],$_POST['IDVend']);          
      $_POST['funcionInterna']=true;
      $_POST['IDPcien']=$_POST['IDCliClienteActualiza'];    
      $_POST['tipoAjax']=1;
      $_POST['IDEjecut']=$_POST['IDSRamo'];
   	 if($_POST['tipoActividad']=='CapturaEmision')
   	 {
   	 	unset($_POST['selectCompania']);
   	 	unset($_POST['poliza']);
   	 }
   	 else
   	 {    
   	  if($_POST['tipoActividad']=='CambiodeConducto')
   	  {
        unset($_POST['polizaNew']);
        unset($_POST['selectCompania']);
   	 	unset($_POST['poliza']);
   	  }  
   	  else{            
   	  
      $_POST['selectCompania'] = $_POST['selectCompania'];            
      $_POST['poliza'] ='';
      unset($_POST['polizaNew']);
      
        }
     }
     $respuesta=$this->agregarGuardar();     

     $data['folioActividad']=$respuesta;

   }
   else
   {
    
   	$_POST['NumSolicitud']=null;
   	$_POST['IDCliSikas']=null;
   	$_POST['idSicas']=null;
	$_POST['folioActividad']		= $this->capsysdre_actividades->CalculaNewFolioActividad();     
     $_POST['tipoRamo']=$nombreRamoSubRamo->ramo;
     $_POST['tipoSubRamo']=$nombreRamoSubRamo->subRamo;

    $_POST['userResponsable']=$this->obtenerResponsableActividad($_POST['tipoActividad'],$nombreRamoSubRamo->ramo,$_POST['IDSRamo'],$_POST['IDVend']);  

    $_POST['nombreCliente']=$this->input->post('Nombre', TRUE).' '.$this->input->post('ApellidoP', TRUE).' '.$this->input->post('ApellidoM', TRUE);
    $_POST['usuarioCreacion']=$this->tank_auth->get_usermail();
    $_POST['IDPcien']=$_POST['IDCliClienteActualiza'];
    $this->grabarActividadCompania();    
    $this->crearActividad(null);   
    $insertar['folioActividad']=$_POST['folioActividad'];
    $insertar['comentario']='Se adiciono una cotizacion con el folio '.$_POST['folioActividad'];
    $this->comentariosGuardar($insertar);       
    $insertar['folioActividad']=$_POST['folioActividad'];
    $insertar['comentario']=$this->input->post('datosExpres', TRUE);
    $this->comentariosGuardar($insertar); 
    $this->actualizarClienteActualiza();

    $data['folioActividad']=$_POST['folioActividad'];
	}
  }
  else{$data['mensaje']=$valida['mensaje'];$data['idObjeto']=$valida['idObjeto'];}
   $data['idObjeto']=$valida['idObjeto'];
   $data['mensaje']=$valida['mensaje'];
   $data['clienteExistente']=$valida['clienteExistente'];
   echo json_encode($data);
}
//----------------------------------------------------
function agregrActividadParaClienteNuevo()
{

    $data=array();
    // 
    $data['estados']=$this->catalogos_model->catalog_estados(null);
    $data['giroCatalogo']	= $this->catalogos_model->catalogo_giros(null);	    
    $data['ramos']=$this->db->query('select * from catalog_ramos cr where cr.estaActivo=1 order by cr.orden')->result();
    $data['SelectVendedor']			= $this->capsysdre_actividades->SelectVendedor($this->tank_auth->get_IDVend(),$this->tank_auth->get_IDVendNS(),$this->tank_auth->get_userprofile());
    $data['permitirRanking']	= $this->personamodelo->obtenerRankingAgente();	
	//$data['companias']		= $this->capsysdre_actividades->obtenerCompaniasSubRamo($this->uri->segment(5));	
	$data['permisos']			= $this->personamodelo->permisosPersona('actividadesAgregar');
    $data['tipoEntidad'] = $this->input->post('tipoEntidad', TRUE);
    $data['enlaceProyecto100'] = $this->input->post('enlaceProyecto100', TRUE);
    $data['nombre'] = $this->input->post('nombre', TRUE);
    $data['apellidoPaterno'] = $this->input->post('apellidoPaterno', TRUE);
    $data['apellidoMaterno'] = $this->input->post('apellidoMaterno', TRUE);
    $data['razonSocial'] = $this->input->post('razonSocial', TRUE);
    $data['RFC'] = $this->input->post('RFC', TRUE);
    $data['celular'] = $this->input->post('celular', TRUE);
    $data['email'] = $this->input->post('email', TRUE);
    $data['IDVend'] = $this->input->post('IDVend', TRUE);
    $data['fecha_nacimiento'] = $this->input->post('fecha_nacimiento', TRUE);
    $data['fechaConstitucion'] = $this->input->post('fechaConstitucion', TRUE);
    $datosUsers=$this->personamodelo->obtenerDatosUsers($this->tank_auth->get_idPersona());

			//$data['codeSicas']=$datosUsers->CodeAuthUserPersonaSicas;

    if($this->input->post('enlaceProyecto100', TRUE)==''){$data['IDCliClienteActualiza']=0;}
    else{$data['IDCliClienteActualiza']=$this->input->post('enlaceProyecto100', TRUE);}
	$this->load->view('actividades/actividadParaClienteNuevo',$data);
}
//----------------------------------------------------
function actividadNuevaProspeccion()
{
	
	$consulta='select u.IDVend,c.* from clientes_actualiza c left join users u on u.email=c.Usuario where c.IDCli='.$_GET['IDCL'];
	$datos=$this->db->query($consulta)->result();

	$_POST['tipoEntidad']=$datos[0]->tipoEntidad;
    $_POST['enlaceProyecto100']=$_GET['IDCL'];
    $_POST['nombre']=$datos[0]->Nombre;
    $_POST['apellidoPaterno']=$datos[0]->ApellidoP;
    $_POST['apellidoMaterno']=$datos[0]->ApellidoM;
    $_POST['razonSocial']=$datos[0]->RazonSocial;
    $_POST['RFC']=$datos[0]->RFC;
    $_POST['email']=$datos[0]->EMail1;
    $_POST['celular']=$datos[0]->Telefono1;
    $_POST['IDVend']=$datos[0]->IDVend;
    $_POST['fecha_nacimiento']=$datos[0]->fecha_nacimiento;
    $_POST['fechaConstitucion']=$datos[0]->fecha_constitucion;
    if($datos[0]->tipoEntidad=='Moral'){$_POST['tipoEntidad']='Moral';}
    else{$_POST['tipoEntidad']='Fisica';}

	$this->agregrActividadParaClienteNuevo();
}
//----------------------------------------------------
function comprobarActividadClienteNuevo($folioActividad)
{
  $folio=$this->db->query('select * from actividades  where folioActividad="'.$folioActividad.'"')->result()[0];	
 $return=new stdClass();;  
  $return->bandera=false;
  $return->idSicas=$folio->idSicas;
  $return->IDCliClienteActualiza=$folio->IDCliClienteActualiza;
  $return->NumSolicitud=$folio->NumSolicitud;
  $return->usuarioResponsable=$folio->usuarioResponsable;
  $return->IDDocto=$folio->IDDocto;
  $return->folioActividadSiniestros=$folio->folioActividadSiniestros;
  $return->idCliente=$folio->idCliente;
  $return->idColaboradorArea=$folio->idColaboradorArea;
  $return->idInterno=$folio->idInterno;
  $return->folioActividad=$folio->folioActividad;
    if($folio->idSicas==0 and $folio->IDCliClienteActualiza>0){$return->bandera=true;}
    return 	$return;
}
//----------------------------------------------------
function obtenerCompaniaPorSubRamo()
{   
   
   $data['companias']=$this->capsysdre_actividades->obtenerCompaniasSubRamo($_POST['idSubRamo']);echo json_encode($data);
}
function pruebaFecha()
{
	$FechaConst = date_format(date_create('0000-00-00'), 'd/m/Y');
	echo $FechaConst;
}
//----------------------------------------------------
function copiarArchivo()
{
	$archivo=$_SERVER["DOCUMENT_ROOT"]."/Capsys/www/V3/assets/img/archivosClientesNuevos/IFE-PRUEBA-202104191717.PDF";
	$ubicacion=$_SERVER["DOCUMENT_ROOT"]."/Capsys/www/V3/assets/img/IFE-PRUEBA-202104191717.PDF";
  if (copy($archivo, $ubicacion)) 
  {
    echo 'Se ha copiado el archivo corretamente';
  }
}

//----------------------------------------------------
function cambiarResponsablesNuevos()
{
  $actividades=explode(',', $_POST['idInterno']);
  $nombre=$this->db->query('select name_complete from users u where u.email="'.$_POST['nuevoResponsable'].'"')->result()[0]->name_complete;
  
  foreach ($actividades as $value) 
  {
  	if($value!='')
  	{
      $update['usuarioResponsable']=$_POST['nuevoResponsable'];
      $update['nombreUsuarioResponsable']=(string)$nombre;
      $this->db->where('idInterno',$value);
      $this->db->update('actividades',$update); 
      $insert['userEmail']=$this->tank_auth->get_usermail();
      $insert['idInterno']=$value;
      $this->db->insert('actividadescambiousuario',$insert);
     
  	}
  }
  $respuesta['success']=1;
   echo json_encode($respuesta);
}
//----------------------------------------------------
public function exportarActividadePorFecha(){
    //Inicio de la instancia para la exportación en Excel



if(isset($_POST['peticionAJAX']))
{
 $consulta='select a.idInterno,a.tipoActividad,a.subRamoActividad,a.usuarioResponsable,a.folioActividad,a.Status_Txt,satisfaccion,a.satisfaccionEmision,
a.ramoActividad,a.subRamoActividad,a.usuarioCreacion,a.usuarioVendedor,a.fechaCreacion
from actividades a 
where cast(a.fechaCreacion as date)>="'.$_POST['fInicial'].'" and cast(a.fechaCreacion as date)<="'.$_POST['fFinal'].'"';
$actividades=$this->db->query($consulta)->result();
$in='';
foreach ($actividades as  $value) {$in.=$value->idInterno.',';}	
if($in!=''){
  $respuesta['actividades']=$actividades;
    $in = substr($in, 0, -1);
    $respuesta['partidas']=$this->db->query('select ap.*,cmc.motivoCambio,s.Nombre from actividadespartidas ap 
left join catalog_motivocambioactividades cmc on cmc.idMotivaCambio=ap.motivoCambio
left join actividadesStatus s on  s.idStatus=ap.`status`
where ap.idInterno in ('.$in.')')->result();}
    else{$respuesta['partidas']=array();$respuesta['actividades']=array();}
  echo json_encode($respuesta);
}
else{

$consulta='select a.idInterno,a.tipoActividad,a.subRamoActividad,a.usuarioResponsable,a.folioActividad,a.Status_Txt,satisfaccion,a.satisfaccionEmision,
a.ramoActividad,a.subRamoActividad,a.usuarioCreacion,a.usuarioVendedor,a.fechaCreacion,cmc.motivoCambio,ac.status,ac.fechaGrabado,s.Nombre,
(ac.usuarioResponsable) as usuarioResponsablePartida
from actividades a 
left join actividadespartidas ac on ac.idInterno=a.idInterno
left join catalog_motivocambioactividades cmc on cmc.idMotivaCambio=ac.motivoCambio
left join actividadesStatus s on  s.idStatus=ac.`status`
where cast(a.fechaCreacion as date)>="'.$_POST['fInicial'].'" and cast(a.fechaCreacion as date)<="'.$_POST['fFinal'].'"';
$actividades=$this->db->query($consulta)->result();
$tabla='<table><tr><td>TIPO DE ACTIVIDAD</td><td>SUB RAMO</td><td>USUARIO RESPONSABLE</td><td>FOLIO</td><td>STATUS DE LA ACTIVIDAD</td><td>SATISFACCION</td><td>USUARIO CREACION</td><td>USUARIO VENDEDOR</td><td>USUARIO RESPONSABLE</td><td>FECHA DE CREACION DE LA ACTIVIDAD</td><td>MOTIVO DEL CAMBIO</td><td>FECHA DEL CAMBIO</td><td>ESTADO DEL CAMBIO</td></tr>';
foreach ($actividades as  $value) 
{
  $tabla.='<tr>';
  $tabla.='<td>'.$value->tipoActividad.'</td>'; 
  $tabla.='<td>'.$value->subRamoActividad.'</td>'; 
  $tabla.='<td>'.$value->usuarioResponsable.'</td>'; 
  $tabla.='<td>'.$value->folioActividad.'</td>'; 
  $tabla.='<td>'.$value->Status_Txt.'</td>';
  $tabla.='<td>'.$value->satisfaccion.'</td>';  
  $tabla.='<td>'.$value->usuarioCreacion.'</td>'; 
  $tabla.='<td>'.$value->usuarioVendedor.'</td>'; 
  $tabla.='<td>'.$value->usuarioResponsablePartida.'</td>'; 
  $tabla.='<td>'.$value->fechaCreacion.'</td>'; 
  $tabla.='<td>'.$value->motivoCambio.'</td>';
  $tabla.='<td>'.$value->fechaGrabado.'</td>';  
  $tabla.='<td>'.$value->Nombre.'</td>'; 
  $tabla.='</tr>';
}
  header('Content-type: application/vnd.ms-excel');
  header("Content-Disposition: attachment; filename=actividades.xls");
  header("Pragma: no-cache");
  header("Expires: 0");

  echo $tabla;
  }
}
//-------------------------------------------------------------------
function guardarComentarioOperativo()
{
	$respuesta['success']=true;
     if(isset($_POST['idACO']))
     {
      if($_POST['idACO']==-1) 
      {
       $insert['idInterno']=$_POST['idInterno'];
       $insert['folioActividad']=$_POST['folioActividad'];
       $insert['userEmail']=$this->tank_auth->get_usermail();
       $insert['comentario']=$_POST['comentario'];
       $this->db->insert('actividadescomentariooperativo',$insert);
      } 
      else
      {
         //if()
      }     
     }
    $consulta='select * from actividadescomentariooperativo where folioActividad="'.$_POST['folioActividad'].'" order by fechaInsercion desc';
    $respuesta['comentarios']=$this->db->query($consulta)->result();
	 
	 echo json_encode($respuesta);
}
//-------------------------------------------------------------------
function listarArchivos(){
	print_r($_SERVER['DOCUMENT_ROOT']);//LA RUTA RAIZ
	print_r('<br>');
	print_r(__FILE__);//LA RUTA DEL ARCHIVO QUE SE EJECUTA
	print_r('<br>');
	print_r(base_url());//LA RUTA DEL ARCHIVO QUE SE EJECUTA
		print_r('<br>');
	print_r(FCPATH);//LA RUTA DEL ARCHIVO QUE SE EJECUTA
	print_r('<br>');
//$directorio = 'C:/wamp64/www/Capsys/www/V3/assets/img/archivosClientesNuevos/4/Documentos';
$directorio = FCPATH.'assets/img/archivosClientesNuevos/10575/Documentos';
$ficheros1=array();
if(file_exists ($directorio))
{
 $ficheros1  = scandir($directorio);
 foreach ($ficheros1 as $value) 
 {
 	if(is_file($directorio.'/'.$value))
 	{
 	  print_r($value.'<br>');	
 	}
 	
 }
 //$ficheros2  = scandir($directorio, 1);
}
 

//print_r($ficheros2);
}
//--------------------------
//---------------------------
function acx()
{
	/*$consulta="select * from bitacorarefrescado";
	$datos=$this->db->query($consulta)->result();
	foreach ($datos as $key => $value) 
	{
		$r=json_decode($value->info);
         
	}
	var_dump($r);*/
	//$datos=$this->ws_sicas->obtenerClientePorID(38037);
						$buscaEstado['clave']	= 'CWEW';
					$buscaGiro['idGiro']	= 'CWEW';
					
					$datos['ramo']				= 'CWEW';
					$datos['subRamo']			= 'CWEW';
			        $datos['usuarioCreacion']	= 'CWEW';
	    		    $datos['nombreCliente']		= 'CWEW';
			        $datos['Telefono1']			= 'CWEW';
	    		    $datos['claveEstado']		= 'CWEW';
			        $datos['giroCliente']		= 'CWEW';
			        $datos['giroActividad']		= 'CWEW';
			        $datos['nombreEstado']		= 'CWEW';
	    		    $datos['nombreGiro']		= 'CWEW';
			        $datos['EMail1']			= 'CWEW';
	        
	        
					$this->email_model->clienteParaFianzas($datos);
					$this->email_model->clientesParaServiciosEspeciales($datos);

    
}
//--------------------------------------------
function crearContacto()
{
	//$this->ws_sicas->crearContactoSicas();
	$array['IDCli']='13304';
	$array['IDCont']='52950';
	//$respuesta=$this->ws_sicas->modificarCliente($array);
	$respuesta=$this->ws_sicas->obtenerClienteInfo(13771);
	
}
//--------------------------------------------
function agregarModoTest()
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
			
				$this->load->view('actividades/agregarModoTest', $data);
			
		}
	}/*! agregar */

//---------------------------------------------------
	function verActividadesModoTest()
	{
		if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
		else 
		{

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
			$data['ejecutivos']=$this->db->query('select p.idPersona,u.email from persona p left join users u on u.idPersona=p.idPersona where p.idColaboradorArea=2 and u.activated=1 and u.banned=0')->result();


          $tipoFiltro="";
          $valorFiltro="";
          $arrayVal=array();
          $stringArray="";
          foreach ($data['ActividadesTrabajandose'] as $key => $value) 
          {

             foreach ($value as $valActividad) 
             {
             	$val['idInterno']=$valActividad->idInterno;
          	    $val['folioActividad']=$valActividad->folioActividad;
          	    array_push($arrayVal, $val);
             }



          	
          }
            if(isset($_GET['selectTipoFiltro'])){$data['selectTipoFiltro']=$_GET['selectTipoFiltro'];$tipoFiltro=$_GET['selectTipoFiltro'];}
            if(isset($_GET['selectValorFiltro'])){$data['selectValorFiltro']=$_GET['selectValorFiltro'];$valorFiltro=$_GET['selectValorFiltro'];}

          $insert['emailUser']=$this->tank_auth->get_usermail();
          $insert['idPersona']=$this->tank_auth->get_idPersona();;
          $insert['origen']='actividades';
          $insert['filtro']=$tipoFiltro;
          $insert['valorFiltro']=$valorFiltro; 
          $insert['info']=json_encode($arrayVal);
          $this->db->insert('bitacorarefrescado',$insert);

			$this->load->view('actividades/verActividadesModoTest',$data);
			
		}
	}/*! verActividades */


//---------------------------------------------------
	function verModoTest()
	{
		$this->load->library(array("webservice_sicas_soap","role"));
		
		if (!$this->tank_auth->is_logged_in()) {redirect('/auth/login/');} 
		else if(!$this->uri->segment(3)){ redirect('actividades');} 
		else {			
		/*============ VERIFICA QUE EL FOLIO EXISTA=========================*/
			if(!$this->capsysdre_actividades->validacionFolioActividad($this->uri->segment(3))){redirect('actividades');}
$data['verDocumentosActividad']=array();
			$data['saldo']					= $this->saldo_model->saldo($this->tank_auth->get_user_id());
			$data['statusActividades']		= $this->capsysdre_actividades->statusActividades();		
			$data['configModulos']			= array( 'modulo' => 'configuraciones');
			$data['SelectTipoImg']			= $this->capsysdre_actividades->SelectTipoImg(0);			
			$data['infoFolioActividad']		= $this->capsysdre_actividades->infoFolioActividad($this->uri->segment(3));
			$data['infoFolioActividadEmi']	= $this->capsysdre_actividades->infoFolioActividadEmi($this->uri->segment(3));
			$data['calificaciones']			= $this->capsysdre_actividades->obtenerCalificaciones();
			if($data['infoFolioActividadEmi'] == "")
			{
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
				 $data['tipoActividadParaCaptura']=$data['infoFolioActividad']->tipoActividad;
			} 
			else 
			{

				$data['promotorias']							= $this->capsysdre_actividades->obtenerPromotoriaPorActividad($data['infoFolioActividad']->folioActividad,'Emision');
				$data['infoFolioActividad']->usuarioResponsable	= $data['infoFolioActividadEmi']->usuarioResponsable;
				$data['infoFolioActividad']->motivoCambio=$data['infoFolioActividadEmi']->motivoCambio;
				$data['tipoActividadParaCaptura']=$data['infoFolioActividadEmi']->tipoActividad;
			}
		 
			if($data['infoFolioActividad']->usuarioResponsable==$this->tank_auth->get_usermail()){

				//$data['permisos']['tarjetaBancoActividad']	= "";
				$data['permisos']							= $this->personamodelo->permisosPersona('actividades');
								$data['permisos']['modificarActividad']		= "";
				$data['permisos']['calificarActividad']		= "";
			} 
			else { $data['permisos']							= $this->personamodelo->permisosPersona('actividades');}

			if(isset($data['permisos']['tarjetaBancoActividad']))
			{

				$idCliente['IDCli']=$data['infoFolioActividad']->idCliente;
				$data['tarjetasDelCliente']=  $this->personamodelo->tarjetaPersona($idCliente);

			}

			$idSicas						= $data['infoFolioActividad']->idSicas;
			
			if($data['infoFolioActividad']->tipoActividadSicas == "ot"){$data['infoDocumento']		= $this->capsysdre_actividades->DetalleDocumento($idSicas);} 

            $data['actividadCalificada']	= $this->capsysdre_actividades->obtenerActividadCalificada($data['infoFolioActividad']->folioActividad,$data['infoFolioActividad']->tipoActividad)[0]->total;
            //	
			$idCliente						= $data['infoFolioActividad']->idCliente;
			$idContacto						= $data['infoFolioActividad']->idContacto;
            
			//$data['infoCliente']			= $this->capsysdre_actividades->DetalleCliente($idCliente.'-'.$idContacto);
		$data['configModulos'] = $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());
     	$data['ckeditor']				= array('id'		=> 	'Comentario',
												'path'		=>	'assets/js/ckeditor',
												'config'	=> array('width' 	=> 	"99%",		//Setting a custom width
																	 'height' 	=> 	'100px',	//Setting a custom height
																	'toolbar' 	=> 	array('/')
																	 )
											  );

 			$folio=array();
			$folio=$this->comprobarActividadClienteNuevo($this->uri->segment(3));
			$data['ocultarParaClienteNuevo']='';
if($folio->bandera)
{
	$data['ocultarParaClienteNuevo']='display:none';
$xmlstr = <<<XML
<?xml version='1.0' standalone='yes'?>
<cliente>
<IDCli>7</IDCli>
</cliente>
XML;

$data['ClienteContact']['cliente']=new SimpleXMLElement($xmlstr);
$xmlVerDoxumentosActividad=<<<XML
<?xml version='1.0' standalone='yes'?>
XML;


$data['verDocumentosActividad']	=array();
$data['cliente']=array();//BUSCAR LOS DATOS EN LA TABLA DE CRM
//$_GET['IDCli']=1;
 $bitacora=$this->db->query("select ac.folioActividad,(concat(ac.comentario,' [',ac.username,']')) as Comentario,(ac.fechaInsercion) as FechaHora,'5' as IDUser,'' as Procedencia from actividadescomentarios 
ac where ac.folioActividad='".$this->uri->segment(3)."' order by ac.idComentario desc")->result(); 
$data['verBitacoraActividad']=$bitacora;
$cliente='select (cc.IDCli) as IDCli,0 as PUNTOS,(concat(cc.Nombre," ",cc.ApellidoP," ",cc.ApellidoM)) as NombreCompleto,"" as idPersonaAgente,((concat(cc.Nombre," ",cc.ApellidoP," ",cc.ApellidoM))) as nombreCliente,cc.preferenciaComunicacion,cc.horarioComunicacion,cc.diaComunicacion,cc.Telefono1,"" as idContacto,cc.EMail1,cc.ApellidoP,cc.ApellidoM,cc.Nombre,cc.RFC,"" as CURP,cc.tipoEntidad,"" as Calidad,"" as Expediente,"" as TipoEnt,(cc.fecha_nacimiento) as FechaNac,(cc.fecha_constitucion) as FechaConst,(TIMESTAMPDIFF(year,cc.fecha_nacimiento,curdate())) as Edad,"" as ClaveTKM,cc.Sexo as Sexo,cc.RazonSocial,"" as IDCont,if(cc.CP is null,"SIN CP",cc.CP) as codigoPostal,(TIMESTAMPDIFF(year,cc.fecha_nacimiento,curdate())) as edad from clientes_actualiza cc where cc.IDCli='.$folio->IDCliClienteActualiza;

$data['cliente']=$this->db->query($cliente)->result(); 
$data['infoCliente']=$this->db->query($cliente)->result();
$data["ClienteContact"]['cliente']	=$this->db->query($cliente)->result()[0];
if($data["ClienteContact"]['cliente']->tipoEntidad=='Moral'){$data["ClienteContact"]['cliente']->TipoEnt=1;}
else{$data["ClienteContact"]['cliente']->TipoEnt=0;}
$archivoCliente=$this->manejodocumento_modelo->devolverArchivos('assets/img/archivosClientesNuevos/'.$folio->IDCliClienteActualiza.'/');
$archivoDocumento=$this->manejodocumento_modelo->devolverArchivos('assets/img/archivosClientesNuevos/'.$folio->IDCliClienteActualiza.'/Documentos/');
$archivos=array();
  
$archivoMostrar=array();
$archivos=array_merge($archivoCliente,$archivoDocumento);
foreach ($archivos as $key => $value) 
{
	  $agregar=new stdClass ;
	  $agregar->text=$value['nombreArchivo'];
	  $agregar->NameShow=$value['nombreArchivo'];
	  $agregar->href=$value['PathWWW'];
	  $agregar->PathWWW=$value['PathWWW'];
	  $agregar->DateModify=$value['DateModify'];
	  $agregar->Tipo=1;
  array_push($archivoMostrar, $agregar)	;
}
$data["msj"] = '';
$data['infoFolioActividad']->tipoActividadSicas="ot";
$data['verDocumentosActividad']=$archivoMostrar;
$data['verBitacoraActividadCotizacion']=array();

} 
else{

	$bitacora=$this->db->query("select ac.folioActividad,(concat(ac.comentario,' [',ac.username,']')) as Comentario,(ac.fechaInsercion) as FechaHora,'5' as IDUser,'' as Procedencia from actividadescomentarios 
ac where ac.folioActividad='".$this->uri->segment(3)."' order by ac.idComentario desc")->result(); 
$data['verBitacoraActividadCotizacion']=$bitacora;
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
	
			
			$data["msj"] = '';
			if (array_key_exists("msj", $_GET)){$data["msj"] = $_GET["msj"];}
			
			// ** !New Info Cliente **//
			
			
			if($data['infoFolioActividad']->tipoActividadSicas == "ot"){
				$TypeDestinoCDigital		= "DOCUMENT";
				$IDValuePK					= $data['infoFolioActividad']->idSicas;
			} else {
				$TypeDestinoCDigital		= "CLIENT";
				$IDValuePK					= $data['infoFolioActividad']->idCliente;
			}
			$data['verDocumentosActividad']	= $this->capsysdre_actividades->InfoDocumento($TypeDestinoCDigital, $IDValuePK);
		$data['verDocumentosActividad']	= $this->ws_sicas->docDeActividades($IDValuePK,$TypeDestinoCDigital);
			if($data['infoFolioActividad']->tipoActividad=="Cotizacion" || $data['infoFolioActividad']->tipoActividad=="Emision"){
				$data['agregarCompania']	=$this->catalogos_model->devolverCompanias();
			} 
			

			//** $this->load->view('actividades/ver', $data);
    }
    
    foreach ($data['verDocumentosActividad'] as $key => $value) 
    	{
    		$fecMatriz=explode('/', $value->DateModify);
    		$value->DateModify=$fecMatriz[2].'/'.$fecMatriz[1].'/'.$fecMatriz[0];
    	}     
usort($data['verDocumentosActividad'], $this->object_sorter('DateModify','DESC'));

	
			
				$this->load->view('actividades/verModoTest',$data);
			
		}
	}/*! ver */
	
//----------------------------------------------------
function emitirModoTest()
	{
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else if(!$this->uri->segment(3)){ 
			redirect('actividades');
		} else {
			if(!$this->capsysdre_actividades->validacionFolioActividad($this->uri->segment(3))){
				redirect('actividades');
			}

$data['infoFolioActividad']		= $this->capsysdre_actividades->infoFolioActividad($this->uri->segment(3));	
			$data['configModulos'] = array( 'modulo' => 'configuraciones');
			$data['SelectTipoImg'] = $this->capsysdre_actividades->SelectTipoImg(0);			
			$data['companias']=$this->capsysdre_actividades->obtenerPromotoriaPorActividad($data['infoFolioActividad']->folioActividad,"Cotizacion");
				
  $folio=$this->comprobarActividadClienteNuevo($this->uri->segment(3));  
if($folio->bandera)
{
	$xmlstr = <<<XML
<?xml version='1.0' standalone='yes'?>
<cliente>
<IDCli>7</IDCli>
</cliente>
XML;

$data['ClienteContact']['cliente']=new SimpleXMLElement($xmlstr);
$xmlVerDoxumentosActividad=<<<XML
<?xml version='1.0' standalone='yes'?>
XML;


$data['verDocumentosActividad']	=array();
$data['cliente']=array();//BUSCAR LOS DATOS EN LA TABLA DE CRM
//$_GET['IDCli']=1;
 $bitacora=$this->db->query("select ac.folioActividad,(concat(ac.comentario,' [',ac.username,']')) as Comentario,(ac.fechaInsercion) as FechaHora,'5' as IDUser,'' as Procedencia from actividadescomentarios 
ac where ac.folioActividad='".$this->uri->segment(3)."' order by ac.idComentario desc")->result(); 
$data['verBitacoraActividad']=$bitacora;
$cliente='select (cc.IDCli) as IDCli,0 as PUNTOS,(concat(cc.Nombre," ",cc.ApellidoP," ",cc.ApellidoM)) as NombreCompleto,"" as idPersonaAgente,((concat(cc.Nombre," ",cc.ApellidoP," ",cc.ApellidoM))) as nombreCliente,cc.preferenciaComunicacion,cc.horarioComunicacion,cc.diaComunicacion,cc.Telefono1,"" as idContacto,cc.EMail1,cc.ApellidoP,cc.ApellidoM,cc.Nombre,cc.RFC,"" as CURP,cc.tipoEntidad,"" as Calidad,"" as Expediente,"" as TipoEnt,"" as FechaNac,"" as FechaConst,"" as Edad,"" as ClaveTKM,cc.Sexo,"" as RazonSocial,"" as IDCont from clientes_actualiza cc where cc.IDCli='.$folio->IDCliClienteActualiza;

//$data['cliente']=$this->db->query($cliente)->result(); 

$data['infoCliente']=$this->db->query($cliente)->result();
$data["ClienteContact"]['cliente']	=$this->db->query($cliente)->result()[0];

}
else{
			
			$idSicas						= $data['infoFolioActividad']->idSicas;			
			$data['infoDocumento']			= $this->capsysdre_actividades->DetalleDocumento($idSicas);		
			$idCliente						= $data['infoFolioActividad']->idCliente;
			$idContacto						= $data['infoFolioActividad']->idContacto;
			$data['infoCliente']			= $this->ws_sicas->obtenerClienteInfo($idCliente);//
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
	}		
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
			
			$this->load->view('actividades/emitirModoTest', $data);
		}

	}/*! emitir */
//-------------------------------
function actividadNuevaProspeccionModoTest()
{
	
	$consulta='select u.IDVend,c.* from clientes_actualiza c left join users u on u.email=c.Usuario where c.IDCli='.$_GET['IDCL'];
	$datos=$this->db->query($consulta)->result();

	$_POST['tipoEntidad']=$datos[0]->tipoEntidad;
    $_POST['enlaceProyecto100']=$_GET['IDCL'];
    $_POST['nombre']=$datos[0]->Nombre;
    $_POST['apellidoPaterno']=$datos[0]->ApellidoP;
    $_POST['apellidoMaterno']=$datos[0]->ApellidoM;
    $_POST['razonSocial']=$datos[0]->RazonSocial;
    $_POST['RFC']=$datos[0]->RFC;
    $_POST['email']=$datos[0]->EMail1;
    $_POST['celular']=$datos[0]->Telefono1;
    $_POST['IDVend']=$datos[0]->IDVend;
    $_POST['fecha_nacimiento']=$datos[0]->fecha_nacimiento;
    $_POST['fechaConstitucion']=$datos[0]->fecha_constitucion;
    if($datos[0]->tipoEntidad=='Moral'){$_POST['tipoEntidad']='Moral';}
    else{$_POST['tipoEntidad']='Fisica';}
    $data=array();
    
    $data['estados']=$this->catalogos_model->catalog_estados(null);
    $data['giroCatalogo']	= $this->catalogos_model->catalogo_giros(null);	    
    $data['ramos']=$this->db->query('select * from catalog_ramos cr where cr.estaActivo=1 order by cr.orden')->result();
    $data['SelectVendedor']			= $this->capsysdre_actividades->SelectVendedor($this->tank_auth->get_IDVend(),$this->tank_auth->get_IDVendNS(),$this->tank_auth->get_userprofile());
    $data['permitirRanking']	= $this->personamodelo->obtenerRankingAgente();	
	//$data['companias']		= $this->capsysdre_actividades->obtenerCompaniasSubRamo($this->uri->segment(5));	
	$data['permisos']			= $this->personamodelo->permisosPersona('actividadesAgregar');
    $data['tipoEntidad'] = $this->input->post('tipoEntidad', TRUE);
    $data['enlaceProyecto100'] = $this->input->post('enlaceProyecto100', TRUE);
    $data['nombre'] = $this->input->post('nombre', TRUE);
    $data['apellidoPaterno'] = $this->input->post('apellidoPaterno', TRUE);
    $data['apellidoMaterno'] = $this->input->post('apellidoMaterno', TRUE);
    $data['razonSocial'] = $this->input->post('razonSocial', TRUE);
    $data['RFC'] = $this->input->post('RFC', TRUE);
    $data['celular'] = $this->input->post('celular', TRUE);
    $data['email'] = $this->input->post('email', TRUE);
    $data['IDVend'] = $this->input->post('IDVend', TRUE);
    $data['fecha_nacimiento'] = $this->input->post('fecha_nacimiento', TRUE);
    $data['fechaConstitucion'] = $this->input->post('fechaConstitucion', TRUE);
    $datosUsers=$this->personamodelo->obtenerDatosUsers($this->tank_auth->get_idPersona());

			//$data['codeSicas']=$datosUsers->CodeAuthUserPersonaSicas;

    if($this->input->post('enlaceProyecto100', TRUE)==''){$data['IDCliClienteActualiza']=0;}
    else{$data['IDCliClienteActualiza']=$this->input->post('enlaceProyecto100', TRUE);}
	$this->load->view('actividades/actividadParaClienteNuevoModoTest',$data);
}
//-----------------------------------------
function rfcCliente()
{
	$res=$this->ws_sicas->rfcClienteObtener('CEUN600803');
	
}	
//----------------------------------------
 function comprobarInfoDelRFC()
 {
 	$respuesta['success']=1;
	$respuesta['infoRFC']=$this->libreriav3->comprobarRFC($_POST['rfcCliente'],$_POST['entidad']);
	echo json_encode($respuesta);
 }
//-----------------------------------------
function digitalAct()
{
	 //
/*	#$data['verDocumentosActividad']	= $this->capsysdre_actividades->InfoDocumento('DOCUMENT', 15275);
	$data['IDValuePK']=$_POST['IDValuePK'];
	$data['IDDocto']=6936;
	$data['RECEIPT']=1;
    $info=array();
	$info['documentos']=$this->ws_sicas->GetCDDigitalCliente($data,1);*/

	$consulta='select a.idCliente,a.idInterno,a.folioActividad,a.IDDocto,a.tipoActividad,a.folioActividadSiniestros from actividades a where tipoActividad="Endoso" and a.idColaboradorArea=6 and a.idCliente='.$_POST['IDValuePK'];
	
	$carpetasEndoso=$this->db->query($consulta)->result();
	$info=array();
    if(count($carpetasEndoso)>0)
	{
		$info['documentos']=array();
	   #$consulta="select * from actividades where idColaboradorArea=6 and idCliente=".$idC;
	   $info['documentos']['isFolder']=1;
	   $info['documentos']['text']='DOCUMENTOS';
	   $info['documentos']['children']=array();
	   
     foreach ($carpetasEndoso as  $value) 
	 {
		$folder='assets/img/centroDigital/'.$value->idCliente.'/'.$value->IDDocto.'/'.$value->folioActividad.'/';
		$agregarPadre['children']=array();
	  $archivoDocumento=$this->manejodocumento_modelo->devolverArchivos($folder);
	  
	      $agregar['isFolder']=1;
		  $agregar['text']='<a href="'.base_url().'actividades/ver/'.$value->folioActividad.'" target="_blank">'.$value->folioActividadSiniestros.' ('.$value->folioActividad.')</a>';		  
		  $agregar['level']=1;
		  $agregar['tipo']=0;
		  array_push($info['documentos']['children'],$agregar);
		  if(count($archivoDocumento)>0){
	     foreach ($archivoDocumento as  $valueArchivo) 
		 {
			$agregar['isFolder']='';
			$agregar['text']=$valueArchivo['nombreArchivo'];
			$agregar['href']=$valueArchivo['PathWWW'];
			$agregar['hrefTarget']='_blank';
			$agregar['level']=2;
			$agregar['Tipo']=1;
			array_push($info['documentos']['children'],$agregar);
		 }
		}
		else
		{
			$agregar['isFolder']='';
			$agregar['text']='';
			$agregar['href']='';
			$agregar['hrefTarget']='';
			$agregar['level']=2;
			$agregar['Tipo']=1;
			array_push($info['documentos']['children'],$agregar);	
		}
	  
	 }
	}
	else
	{
	 $data['IDValuePK']=$_POST['IDValuePK'];
	 $data['IDDocto']=6936;
	 $data['RECEIPT']=1;     
	 $info['documentos']=$this->ws_sicas->GetCDDigitalCliente($data,1); 	 
	  
	}
   
    echo json_encode($info);
}

//-------------------------------------
function validarRFCPrueba()
{
	$resRFC=$this->libreriav3->comprobarRFC('CSM970219832','MORAL');

}
//-------------------------------------
function obtenerPromotoriaPorActividad()
{
	
	$respuesta=array();
	switch ($_POST['tipoActividad']) 
	{
	 case 'Cotizacion':$respuesta['promotorias']=$this->capsysdre_actividades->obtenerPromotoriaPorActividad($_POST['folioActividad'],'Cotizacion');
			break;
		case 'Emision':$respuesta['promotorias']	= $this->capsysdre_actividades->obtenerPromotoriaPorActividad($_POST['folioActividad'],'Emision');
			break;
		
		default:$respuesta['promotorias']	= $this->capsysdre_actividades->obtenerPromotoriaPorActividad($_POST['folioActividad'],'Endoso');
			break;
	}
   echo json_encode($respuesta);
}
//-------------------------------------
function guardadDocumentoMontoPromotoria()
{
	$respuesta['success']=true;
	$_POST['function']=true;
	foreach ($_POST as $key => $value) 
	{
		$monto=explode('-', $key);
		if($monto[0]=='monto')
		{
			
			$array['idRelActividadPromotoria']=$monto[1];
		   if(is_numeric($value)){$array['montoRAP']=$value;}
           else{$array['montoRAP']=0;}
           $array['update']='';
           $respuesta=$this->capsysdre_actividades->relactividadpromotoria($array);
           
		}
	}
	
	foreach ($_FILES as $key => $value) 
	{
		
		if($value['name']!='' and $value['size']>0)
		{
	      $relActProm=$monto=explode('-', $key);
           $_POST['idRelActividadPromotoria']=$relActProm[1];
         $this->guardarDocumentoPromotoria($_POST['folioActividad'],$value);
		}
	}
	echo json_encode($respuesta);			
}
//-------------------------------------
function devolverDocumentoPromotoria()
{            
	$respuesta=array();
	$respuesta['saldo']             = $this->saldo_model->saldo($this->tank_auth->get_user_id());
	//$respuesta['verDocumentosActividad']	= $this->capsysdre_actividades->InfoDocumento('DOCUMENT', $_POST['idSicas']);
	$documento['IDDocto']=$_POST['idSicas'];
	$respuesta['verDocumentosClientes']=array();
	$respuesta['verDocumentosActividad']=array();
	$respuesta['verDocumentosEndoso']=array();
	$cliente['IDValuePK']=$_POST['IDCli'];
	
	  $folio=$this->comprobarActividadClienteNuevo($_POST['folioActividad']);
	  if($folio->bandera)
	  {
       
       $archivoCliente=$this->manejodocumento_modelo->devolverArchivos('assets/img/archivosClientesNuevos/'.$folio->IDCliClienteActualiza.'/');
       $archivoDocumento=$this->manejodocumento_modelo->devolverArchivos('assets/img/archivosClientesNuevos/'.$folio->IDCliClienteActualiza.'/Documentos/');
       $archivos=array();  
       $archivoMostrar=array();      
       $respuesta['verDocumentosClientes']['children']=array();
       foreach ($archivoCliente as $key => $value) 
       {	    
	    $agregar=array();
	    $agregar['text']=$value['nombreArchivo'];	    
	    $agregar['href']=$value['PathWWW'];	    
	    $agregar['Tipo']=1;
        array_push($respuesta['verDocumentosClientes']['children'], $agregar)	;
       }
       $respuesta['verDocumentosActividad']['children']=array();
    	      foreach ($archivoDocumento as $key => $value) 
       {
       	$agregar=array();	    
	    $agregar['text']=$value['nombreArchivo'];	    
	    $agregar['href']=$value['PathWWW'];
	    $agregar['Tipo']=1;
        array_push($respuesta['verDocumentosActividad']['children'], $agregar)	;
       }
       
	  }//FIN $folio->bandera
  else{
	    if($_POST['tipoTarea']=='ot')
		 {
			$respuesta['verDocumentosActividad']	= $this->ws_sicas->GetCDDigital($documento,1);
		 }
		else
		 {
			
			if($folio->idColaboradorArea==6)
			{

				$folder='assets/img/centroDigital/'.$folio->idCliente.'/'.$folio->IDDocto.'/'.$_POST['folioActividad'].'/';
				$archivoDocumento=$this->manejodocumento_modelo->devolverArchivos($folder);
				#$respuesta['verDocumentosEndoso']['children']=array();
				foreach ($archivoDocumento as $key => $value) 
				{
					$agregar=array();	    
				 $agregar['text']=$value['nombreArchivo'];	    
				 $agregar['href']=$value['PathWWW'];
				 $agregar['Tipo']=1;
				 array_push($respuesta['verDocumentosEndoso'], $agregar)	;
				}				
				//$respuesta['verDocumentosClientes']	= $this->ws_sicas->GetCDDigitalCliente($cliente,0);	 
						 

			}
			else
			{
				
			$respuesta['verDocumentosActividad']	= $this->ws_sicas->GetCDDigitalCliente($cliente,1);
			$borrar=array();
			foreach ($respuesta['verDocumentosActividad']['children'] as $key => $value) 
			{				
				if($value['Tipo']=='0'){array_push($borrar, $key);}
				else
				{
				 if(!strpos($value['href'], 'Target_'.$_POST['tipoActividad'])){array_push($borrar, $key);}
				 if(strpos($value['href'], 'Target_'.$_POST['tipoActividad'].'/'.$_POST['poliza']))
				 	{
				 		array_push($borrar, $key);
				 		array_push($respuesta['verDocumentosEndoso'], $value);
				 	}
			    }
			 }
 
			
			  foreach ($borrar as  $value) {unset($respuesta['verDocumentosActividad']['children'][$value]);}
			}
		  }
		  $respuesta['verDocumentosClientes']	= $this->ws_sicas->GetCDDigitalCliente($cliente,0);	

    }
	echo json_encode($respuesta);
         
   
}

//-----------------------------------------------------------
function guardarDocumentoPromotoria($folioActividad,$archivo)
{
   $folio=array();
   $respuesta['success']=true;
   $folio=$this->comprobarActividadClienteNuevo($folioActividad);
    
	$respuesta['success']=true;
   		
				$this->load->model("manejodocumento_modelo");
				$nombreArchivo=$this->manejodocumento_modelo->obtenerNombreArchivo($archivo['name']);
				$extensionArchivo=$this->manejodocumento_modelo->devolverExtension($archivo['name']);
				 $nombreArchivo = str_replace(' ','_',$nombreArchivo);
				 $nombreArchivo = str_replace('.','_',$nombreArchivo);
				 $nombreArchivo = str_replace(',','_',$nombreArchivo);	
				 $nombreArchivo = str_replace('-','_',$nombreArchivo);				 
				 $nombreArchivo = str_replace(':','_',$nombreArchivo);	
				 $nameFileSicas =  $nombreArchivo;
				 $nameFileSicas .="_".date('YmdHi');
				 $nameFileSicas .='.'.$extensionArchivo;
             
	$respuesta['success']=true;	
             if($folio->bandera)
              {
                $FolderDestino			= $folio->IDCliClienteActualiza.'/Documentos/';
                #$destination	= 'C:/wamp64/www/Capsys/www/V3/assets/img/archivosClientesNuevos/'.$FolderDestino;
				$destination	= '/home/admin/domains/v3prod.capsys.site/public_html/V3/assets/img/archivosClientesNuevos/'.$FolderDestino;
				if (!file_exists($destination)) {mkdir($destination, 0777, true);}
				$destination.=$nameFileSicas;
				move_uploaded_file($archivo['tmp_name'], $destination);

              }
             else 
              {
              	#$destination	= 'C:/wamp64/www/Capsys/www/V3/assets/img/archivosClientesNuevos/'.$FolderDestino;
				$destination	= '/home/admin/domains/v3prod.capsys.site/public_html/V3/assets/img/tmp/'.$nameFileSicas;				
						
				move_uploaded_file($archivo['tmp_name'], $destination);
				
				$ListFilesURL	= base_url().'assets/img/tmp/'.$nameFileSicas;				
				$TypeDestinoCDigital	= $this->input->post('TypeDestinoCDigital', TRUE);
				$IDValuePK				= $this->input->post('IDValuePK', TRUE);
				$FolderDestino			= $this->input->post('FolderDestino', TRUE);        	
				$this->capsysdre_actividades->CargarDocumento($TypeDestinoCDigital, $IDValuePK, $ListFilesURL, $FolderDestino);
				sleep(1);
			 }
			
            $array['idRelActividadPromotoria']=$this->input->post('idRelActividadPromotoria', TRUE);
            $array['operacion']=1;             		

			$respuesta=$this->catalogos_model->relActividadPromotoria($array);  			
    
    if(isset($_POST['function'])){return true;}
    else{ echo json_encode($respuesta);}
}

//-------------------------------------
function agregarDocumentos()
{
  $respuesta['success']=true;
  $this->load->model('manejodocumento_modelo');
      $this->load->model('permisooperativo');
if($_POST['moduloOrigen']=='moduloCobranza')
{
 	
    foreach ($_FILES as $key => $value) 
    {
      	        
        	$idTipo=$_POST[$key.'tipo'];
        	$descripcion=$_POST[$key.'descripcion'];
        switch ($idTipo) 
        {
        case 34:
           $extension=explode(".",$_FILES[$key]['name'] );
           $largo=count($extension);
           $ext=$extension[$largo-1];
           $nameFileSicas=$_POST['documentoGDD'].'_'.$_POST['periodoGDD'];
          if($_POST['endosoGDD']!=''){if($_POST['endosoIdGDD']>0){  $nameFileSicas=$_POST['documentoGDD'].'_'.$_POST['endosoGDD'].'_'.$_POST['periodoGDD'];}}
           $destination	= '/home/admin/domains/v3prod.capsys.site/public_html/V3/assets/img/tmp/'.$nameFileSicas.'XML.'.$ext;
		   move_uploaded_file($value['tmp_name'], $destination);
		   $archivo['ListFilesURL']= base_url().'assets/img/tmp/'.$nameFileSicas.'XML.'.$ext;				   
           $archivo['TypeDestinoCDigital']	= 'DOCUMENT';
		   $archivo['IDValuePK']= $_POST['IDDoctoGGD'];
		   $contRec=strlen($_POST['idReciboGDD']);
		   $contRec=9-$contRec;
		   $rec='';
           for($i=0;$i<$contRec;$i++){$rec.='0';}  
           $archivo['FolderDestino']= 'REC'.$rec.$_POST['idReciboGDD'];
		   if($_POST['endosoGDD']!='')
		   {
		   	if($_POST['endosoIdGDD']>0)
		   	{
		   	 $contRecEnd=strlen($_POST['endosoIdGDD']);
		     $contRecEnd=9-$contRecEnd;
		     $recEnd='';
		     for($i=0;$i<$contRecEnd;$i++){$recEnd.='0';}
             $archivo['FolderDestino']='END'.$recEnd.$_POST['endosoIdGDD'].'/'.'REC'.$rec.$_POST['idReciboGDD'];
		   	}


		   }

		   $archivo['wsAction'] = "PUTFiles";
		   $archivo['wsNodoExtrae']= "Datos";
		   sleep(2);		 
		   $respuesta=$this->ws_sicas->subirArchivoSicas($archivo);
	
    	 $idDocto = $_POST["IDDoctoGGD"];	
		   $data = array("IDDocto" => $idDocto);
          $respuesta = $this->ws_sicas->GetCDDigital($data);
          $respuesta['serie']=$_POST['serieGDD'];
          $respuesta['IDRecibo']=$_POST['idReciboGDD'];
          $respuesta['periodo']=$_POST['periodoGDD'];
          #$respuesta['bodyTable']=$_POST['inputBody'];
          $respuesta['documento']=$_POST['documentoGDD'];   
          $respuesta['inner']=$_POST['documentoGDD'];               	   
          $respuesta['endoso']=$_POST['endosoGDD']; 

        break;
        case 33:
           $extension=explode(".",$_FILES[$key]['name'] );
           $largo=count($extension);
           $ext=$extension[$largo-1];
           $nameFileSicas=$_POST['documentoGDD'].'_'.$_POST['periodoGDD'];
          if($_POST['endosoGDD']!=''){if($_POST['endosoIdGDD']>0){  $nameFileSicas=$_POST['documentoGDD'].'_'.$_POST['endosoGDD'].'_'.$_POST['periodoGDD'];}}
           $destination	= '/home/admin/domains/v3prod.capsys.site/public_html/V3/assets/img/tmp/'.$nameFileSicas.'Factura.'.$ext;
		   move_uploaded_file($value['tmp_name'], $destination);
		   $archivo['ListFilesURL']= base_url().'assets/img/tmp/'.$nameFileSicas.'Factura.'.$ext;				   
           $archivo['TypeDestinoCDigital']	= 'DOCUMENT';
		   $archivo['IDValuePK']= $_POST['IDDoctoGGD'];
		   $contRec=strlen($_POST['idReciboGDD']);
		   $contRec=9-$contRec;
		   $rec='';
           for($i=0;$i<$contRec;$i++){$rec.='0';}  
           $archivo['FolderDestino']= 'REC'.$rec.$_POST['idReciboGDD'];
		   if($_POST['endosoGDD']!='')
		   {
		   	if($_POST['endosoIdGDD']>0)
		   	{
		   	 $contRecEnd=strlen($_POST['endosoIdGDD']);
		     $contRecEnd=9-$contRecEnd;
		     $recEnd='';
		     for($i=0;$i<$contRecEnd;$i++){$recEnd.='0';}
             $archivo['FolderDestino']='END'.$recEnd.$_POST['endosoIdGDD'].'/'.'REC'.$rec.$_POST['idReciboGDD'];
		   	}


		   }

		   $archivo['wsAction'] = "PUTFiles";
		   $archivo['wsNodoExtrae']= "Datos";		 
		   sleep(2);	 
		   $respuesta=$this->ws_sicas->subirArchivoSicas($archivo);
	
    	 $idDocto = $_POST["IDDoctoGGD"];	
		   $data = array("IDDocto" => $idDocto);
          $respuesta = $this->ws_sicas->GetCDDigital($data);
          $respuesta['serie']=$_POST['serieGDD'];
          $respuesta['IDRecibo']=$_POST['idReciboGDD'];
          $respuesta['periodo']=$_POST['periodoGDD'];
          #$respuesta['bodyTable']=$_POST['inputBody'];
          $respuesta['documento']=$_POST['documentoGDD'];   
          $respuesta['inner']=$_POST['documentoGDD'];               	   
          $respuesta['endoso']=$_POST['endosoGDD']; 

        break;
        case 3:		
           $extension=explode(".",$_FILES[$key]['name'] );
           $largo=count($extension);
           $ext=$extension[$largo-1];
           $nameFileSicas=$_POST['documentoGDD'].'_'.$_POST['periodoGDD'];
          if($_POST['endosoGDD']!=''){if($_POST['endosoIdGDD']>0){  $nameFileSicas=$_POST['documentoGDD'].'_'.$_POST['endosoGDD'].'_'.$_POST['periodoGDD'];}}
           $destination	= '/home/admin/domains/v3prod.capsys.site/public_html/V3/assets/img/tmp/'.$nameFileSicas.'Comprobante.'.$ext;
		   move_uploaded_file($value['tmp_name'], $destination);
		   $archivo['ListFilesURL']= base_url().'assets/img/tmp/'.$nameFileSicas.'Comprobante.'.$ext;				   
           $archivo['TypeDestinoCDigital']	= 'DOCUMENT';
		   $archivo['IDValuePK']= $_POST['IDDoctoGGD'];
		   $contRec=strlen($_POST['idReciboGDD']);
		   $contRec=9-$contRec;
		   $rec='';
           for($i=0;$i<$contRec;$i++){$rec.='0';}  
           $archivo['FolderDestino']= 'REC'.$rec.$_POST['idReciboGDD'];
		   if($_POST['endosoGDD']!='')
		   {
		   	if($_POST['endosoIdGDD']>0)
		   	{
		   	 $contRecEnd=strlen($_POST['endosoIdGDD']);
		     $contRecEnd=9-$contRecEnd;
		     $recEnd='';
		     for($i=0;$i<$contRecEnd;$i++){$recEnd.='0';}
             $archivo['FolderDestino']='END'.$recEnd.$_POST['endosoIdGDD'].'/'.'REC'.$rec.$_POST['idReciboGDD'];
		   	}


		   }

		   $archivo['wsAction'] = "PUTFiles";
		   $archivo['wsNodoExtrae']= "Datos";		 
		   sleep(2);
		   $respuesta=$this->ws_sicas->subirArchivoSicas($archivo);
	
    	 $idDocto = $_POST["IDDoctoGGD"];	
		   $data = array("IDDocto" => $idDocto);
          $respuesta = $this->ws_sicas->GetCDDigital($data);
          $respuesta['serie']=$_POST['serieGDD'];
          $respuesta['IDRecibo']=$_POST['idReciboGDD'];
          $respuesta['periodo']=$_POST['periodoGDD'];
          #$respuesta['bodyTable']=$_POST['inputBody'];
          $respuesta['documento']=$_POST['documentoGDD'];   
          $respuesta['inner']=$_POST['documentoGDD'];               	   
          $respuesta['endoso']=$_POST['endosoGDD']; 
        break;
         case 19:
            
           $extension=explode(".",$_FILES[$key]['name'] );
           $largo=count($extension);
           $ext=$extension[$largo-1];
           $nameFileSicas=$_POST['documentoGDD'].'_'.$_POST['periodoGDD'];
           $descripcion=$_POST[$key.'descripcion'];
           $nameFileSicas=$descripcion;
    
      if($_POST['endosoGDD']!='')
		   {
		   	if($_POST['endosoIdGDD']>0){  $nameFileSicas=$_POST['documentoGDD'].'_'.$_POST['endosoGDD'].'_'.$_POST['periodoGDD'];}
		   }

           $destination	= '/home/admin/domains/v3prod.capsys.site/public_html/V3/assets/img/tmp/'.$nameFileSicas.'.'.$ext;
		   move_uploaded_file($value['tmp_name'], $destination);
		   $archivo['ListFilesURL']= base_url().'assets/img/tmp/'.$nameFileSicas.'.'.$ext;				   
		   $archivo['TypeDestinoCDigital']	= 'DOCUMENT';
		   $archivo['IDValuePK']= $_POST['IDDoctoGGD'];
		   $contRec=strlen($_POST['idReciboGDD']);
		   $contRec=9-$contRec;
		   $rec='';
		   for($i=0;$i<$contRec;$i++){$rec.='0';}                      
           $archivo['FolderDestino']= 'REC'.$rec.$_POST['idReciboGDD'];
       		   if($_POST['endosoGDD']!='')
		   {
		   	if($_POST['endosoIdGDD']>0)
		   	{
		   	 $contRecEnd=strlen($_POST['endosoIdGDD']);
		     $contRecEnd=9-$contRecEnd;
		     $recEnd='';
		     for($i=0;$i<$contRecEnd;$i++){$recEnd.='0';}
             $archivo['FolderDestino']='END'.$recEnd.$_POST['endosoIdGDD'].'/'.'REC'.$rec.$_POST['idReciboGDD'];
		   	}


		   }

		   $archivo['wsAction'] = "PUTFiles";
		   $archivo['wsNodoExtrae']= "Datos";		 
		   sleep(2);
		   $respuesta=$this->ws_sicas->subirArchivoSicas($archivo);
		          $array['value']=$_POST['enviarCorreoGDD'];
       $array['idLlavePermiso']='subirrecibocobranza';
		          $correos=$this->permisooperativo->PermisoModuloPersonaCorreos($array);
       foreach ($correos as  $value) 
      {
       $guardaMensaje['desde']="Avisos de GAP<avisosgap@aserorescpital.com>";
       $guardaMensaje['para']=$value->email;
       $guardaMensaje['mensaje']='<div>Se acaba de agregar un  recibo a la poliza:'.$_POST['documentoGDD'].' </div><div>Periodo:'.$_POST['periodoGDD'].'</div></div>';       
       if($_POST['endosoGDD']!=''){$guardaMensaje['mensaje']='<div>Se acaba de agregar un  recibo a la poliza: '.$_POST['documentoGDD'].'</div><div>Endoso'.$_POST['endosoGDD'].'</div><div> Periodo '.$_POST['periodoGDD'].'</div></div>'; }    
       $guardaMensaje['asunto']='Recibo';
      $guardaMensaje['identificaModulo']='subirRecibo|'.$_POST['documentoGDD'].'|'.$_POST['endosoGDD'].'|'.$_POST['periodoGDD'];     
      #$this->email_model->enviarCorreo($guardaMensaje);   
     }
    	 $idDocto = $_POST["IDDoctoGGD"];	
		   $data = array("IDDocto" => $idDocto);
          $respuesta = $this->ws_sicas->GetCDDigital($data);
          $respuesta['serie']=$_POST['serieGDD'];
          $respuesta['IDRecibo']=$_POST['idReciboGDD'];
          $respuesta['periodo']=$_POST['periodoGDD'];
          #$respuesta['bodyTable']=$_POST['inputBody'];
          $respuesta['documento']=$_POST['documentoGDD'];   
          $respuesta['inner']=$_POST['documentoGDD'];               	   
          $respuesta['endoso']=$_POST['endosoGDD']; 
         break;
      case 23:

           $extension=explode(".",$_FILES[$key]['name'] );
           $largo=count($extension);
           $ext=$extension[$largo-1];
           $nameFileSicas=$_POST['documentoGDD'].'_'.$_POST['periodoGDD'];
          if($_POST['endosoGDD']!=''){if($_POST['endosoIdGDD']>0){  $nameFileSicas=$_POST['documentoGDD'].'_'.$_POST['endosoGDD'].'_'.$_POST['periodoGDD'];}}
           $destination	= '/home/admin/domains/v3prod.capsys.site/public_html/V3/assets/img/tmp/'.$descripcion.'.'.$ext;
		   move_uploaded_file($value['tmp_name'], $destination);
		   $archivo['ListFilesURL']= base_url().'assets/img/tmp/'.$descripcion.'.'.$ext;				   
		   $archivo['TypeDestinoCDigital']	= 'DOCUMENT';
		   $archivo['IDValuePK']= $_POST['IDDoctoGGD'];
		   $contRec=strlen($_POST['idReciboGDD']);
		   $contRec=9-$contRec;
		   $rec='';
		   for($i=0;$i<$contRec;$i++){$rec.='0';}                      
           $archivo['FolderDestino']= 'REC'.$rec.$_POST['idReciboGDD'];
       		   if($_POST['endosoGDD']!='')
		   {
		   	if($_POST['endosoIdGDD']>0)
		   	{
		   	 $contRecEnd=strlen($_POST['endosoIdGDD']);
		     $contRecEnd=9-$contRecEnd;
		     $recEnd='';
		     for($i=0;$i<$contRecEnd;$i++){$recEnd.='0';}
             $archivo['FolderDestino']='END'.$recEnd.$_POST['endosoIdGDD'].'/'.'REC'.$rec.$_POST['idReciboGDD'];
		   	}


		   }

		   $archivo['wsAction'] = "PUTFiles";
		   $archivo['wsNodoExtrae']= "Datos";		 
		   sleep(2);
		   $respuesta=$this->ws_sicas->subirArchivoSicas($archivo);
	
    	 $idDocto = $_POST["IDDoctoGGD"];	
		   $data = array("IDDocto" => $idDocto);
          $respuesta = $this->ws_sicas->GetCDDigital($data);
          $respuesta['serie']=$_POST['serieGDD'];
          $respuesta['IDRecibo']=$_POST['idReciboGDD'];
          $respuesta['periodo']=$_POST['periodoGDD'];
          #$respuesta['bodyTable']=$_POST['inputBody'];
          $respuesta['documento']=$_POST['documentoGDD'];   
          $respuesta['inner']=$_POST['documentoGDD'];               	   
          $respuesta['endoso']=$_POST['endosoGDD']; 

      break;
         default:
           $idTipo=$_POST[$key.'tipo'];
        	$descripcion=$_POST[$key.'descripcion'];
        	   	 $tipoArchivoDescripcion=$this->db->query('SELECT nombre FROM catalog_tipoImg WHERE idTipoImg='.$idTipo)->result()[0]->nombre;
        	$idCliente		= $this->input->post('idCliente', TRUE);                
			$nameFileSicas	= str_replace(' ','_',$tipoArchivoDescripcion);
			$nameFileSicas	.= "-".strtoupper($descripcion);
			$nameFileSicas	.= "-".date('YmdHi');
			$nameFileSicas	.= ".".strrev(strstr(strrev($value['name']), '.', true));
			$destination	= '/home/admin/domains/v3prod.capsys.site/public_html/V3/assets/img/tmp/'.$nameFileSicas;				
			move_uploaded_file($value['tmp_name'], $destination);  
                  if($idTipo==5 || $idTipo==7 || $idTipo==11  || $idTipo==12 || $idTipo==21 || $idTipo==22)
         {         
           $ListFilesURL			= base_url().'assets/img/tmp/'.$nameFileSicas;
		   $TypeDestinoCDigital	= "CLIENT";
		   $IDValuePK				= $_POST['idCliente'];
		   $FolderDestino			= ""; 		                                          
         
         }
        	else
        	{
        		$ListFilesURL			= base_url().'assets/img/tmp/'.$nameFileSicas;
				$TypeDestinoCDigital	= 'DOCUMENT';
				$IDValuePK				= $_POST["IDDoctoGGD"];
				$FolderDestino			= "";

        	}
        	sleep(2);
             $this->capsysdre_actividades->CargarDocumento($TypeDestinoCDigital, $IDValuePK, $ListFilesURL, $FolderDestino);
        	
         break;
        }

     }
}
else
{
  
  $folio=new stdClass();  
  if($_POST['folioActividad']==''){$folio->bandera='';$folio->bandera=false;}
  else{ $folio=$this->comprobarActividadClienteNuevo($this->input->post('folioActividad', TRUE));}
         $folioActividad	= $this->input->post('folioActividad', TRUE);		
     if($folio->bandera)
     {    
        foreach ($_FILES as $key => $value) 
        {
        	sleep(1);
        	//
        	$idTipo=$_POST[$key.'tipo'];
        	$descripcion=$_POST[$key.'descripcion'];
        	if($idTipo==5 || $idTipo==7 || $idTipo==11 || $idTipo==12 || $idTipo==21 || $idTipo==22){$FolderDestino			= $folio->IDCliClienteActualiza.'/';}
        	else{$FolderDestino			= $folio->IDCliClienteActualiza.'/Documentos/';}
        	 $tipoArchivoDescripcion=$this->db->query('SELECT nombre FROM catalog_tipoImg WHERE idTipoImg='.$idTipo)->result()[0]->nombre;
        	 $idCliente		= $this->input->post('idCliente', TRUE);        	 
			 $nameFileSicas	= str_replace(' ','_',$tipoArchivoDescripcion);
			 $nameFileSicas	.= "-".strtoupper($descripcion);
			 $nameFileSicas	.= "-".date('YmdHi');
			 $nameFileSicas	.= ".".strrev(strstr(strrev($value['name']), '.', true));
				// $destination	= 'C:\wamp\www\V3Presentacion\assets\img\tmp\\'.$nameFileSicas;
				//$destination	= '/home/admin/domains/v3prod.capsys.site/public_html/V3/assets/\img\tmp\\'.$nameFileSicas;
				
			//$destination	= '/home/admin/domains/v3prod.capsys.site/public_html/V3/assets/\img\archivosClientesNuevos\\'.$FolderDestino;
			$destination	= '/home/admin/domains/v3prod.capsys.site/public_html/V3/assets/img/archivosClientesNuevos/'.$FolderDestino;
			if (!file_exists($destination)) {mkdir($destination, 0777, true);}
				$destination.=$nameFileSicas;
				move_uploaded_file($value['tmp_name'], $destination);
				 $insertar['folioActividad']=$_POST['folioActividad'];
                 $insertar['comentario']='Se adiciono el archivo '.$nameFileSicas;
                 $this->comentariosGuardar($insertar);    
                $this->agregarNotificacionActividad($this->input->get_post('folioActividad', TRUE),'Se agrego el documento '.$nameFileSicas.' al folio ');
 
        }           
             if(isset($_POST['pasarActividadEnCurso']))
             {
               if($_POST['pasarActividadEnCurso'])
            	{
                  $insertar['folioActividad']=$folioActividad;
                  $insertar['comentario']='La actividad esta en curso';
                  $this->comentariosGuardar($insertar);                       
                  $this->db->where('folioActividad',$folioActividad);
                  $update['Status']=5;
                  $this->db->update('actividades',$update);
            	}
              }

    }
else
{

	        foreach ($_FILES as $key => $value) 
            	{
        	        	$idTipo=$_POST[$key.'tipo'];
        	$descripcion=$_POST[$key.'descripcion'];
        	   	 $tipoArchivoDescripcion=$this->db->query('SELECT nombre FROM catalog_tipoImg WHERE idTipoImg='.$idTipo)->result()[0]->nombre;
        	$idCliente		= $this->input->post('idCliente', TRUE);                
			$nameFileSicas	= str_replace(' ','_',$tipoArchivoDescripcion);
			$nameFileSicas	.= "-".strtoupper($descripcion);
			$nameFileSicas	.= "-".date('YmdHi');
			$nameFileSicas	.= ".".strrev(strstr(strrev($value['name']), '.', true));
			$destination	= '/home/admin/domains/v3prod.capsys.site/public_html/V3/assets/img/tmp/'.$nameFileSicas;				
			$insertarEnSicas=1;
			move_uploaded_file($value['tmp_name'], $destination);        

        	if($idTipo==5 || $idTipo==7 || $idTipo==11 || $idTipo==12 || $idTipo==21 || $idTipo==22)
        	 {
        	 	$ListFilesURL			= base_url().'assets/img/tmp/'.$nameFileSicas;
				$TypeDestinoCDigital	= "CLIENT";
			    $IDValuePK				= $idCliente;
				$FolderDestino			= "";
        	 }
        	else
        	{
        		$ListFilesURL			= base_url().'assets/img/tmp/'.$nameFileSicas;
				$TypeDestinoCDigital	= $this->input->post('TypeDestinoCDigital', TRUE);
				$IDValuePK				= $this->input->post('IDValuePK', TRUE);
				$FolderDestino			= $this->input->post('FolderDestino', TRUE);
				
			 if($folio->idColaboradorArea==6)
			 {
				#$destination='/home/admin/domains/v3prod.capsys.site/public_html/V3/assets/\img\centroDigital\\'.$idCliente.'\\'.$folio->IDDocto.'\\'.$folio->folioActividad.'\\';
				$insertarEnSicas=0;
				$FolderDestino=$idCliente.'/'.$folio->IDDocto.'/'.$folio->folioActividad;
		    	$destination	= '/home/admin/domains/v3prod.capsys.site/public_html/V3/assets/img/centroDigital/'.$FolderDestino;
			if (!file_exists($destination)) {mkdir($destination, 0777, true);}
				$destination.=$nameFileSicas;
				move_uploaded_file($value['tmp_name'], $destination);
			
        	}
        	}
			if($insertarEnSicas==1){$this->capsysdre_actividades->CargarDocumento($TypeDestinoCDigital, $IDValuePK, $ListFilesURL, $FolderDestino);}
            				 $insertar['folioActividad']=$_POST['folioActividad'];
            sleep(2);
            if($this->input->get_post('folioActividad', TRUE)!=''){$this->agregarNotificacionActividad($this->input->get_post('folioActividad', TRUE),'Se agrego el documento '.$nameFileSicas.' al folio ');}
        }
              if(isset($_POST['pasarActividadEnCurso']))
             {
               if($_POST['pasarActividadEnCurso'])
            	{
                  $insertar['folioActividad']=$folioActividad;
                  $insertar['comentario']='La actividad esta en curso';
                  $this->comentariosGuardar($insertar);                       
                  $this->db->where('folioActividad',$folioActividad);
                  $update['Status']=5;
                  $this->db->update('actividades',$update);
            	
        		    $IDDocto = $this->input->post('IDDocto', TRUE);			
			       if($this->input->post('tipoActividadSicas', TRUE) == "ot"){$StatusUser = $this->capsysdre_actividades->CambiaStatusUser($IDDocto,5);} 
			       else {$StatusUserTarea = $this->capsysdre_actividades->CambiaStatusUserTarea($IDDocto,5);}
            	}
              }			
              }
			
		    $IDDocto = $this->input->post('IDDocto', TRUE);			
			#if($this->input->post('tipoActividadSicas', TRUE) == "ot"){$StatusUser = $this->capsysdre_actividades->CambiaStatusUser($IDDocto,$posicion);} 
			#else {$StatusUserTarea = $this->capsysdre_actividades->CambiaStatusUserTarea($IDDocto,$posicion);}
	}
  echo json_encode($respuesta);
}
//------------------------------------
function verificaExistenciaSemaforo($idPromotoria='',$idSubRamo='',$funcion) //Modificado [Suemy][2024-07-23]
{

	$consulta='select count(idRamoPromotoria) as total from relacionramopromotoria r where r.idSubRamo='.$idSubRamo.' and r.idPromotoria='.$idPromotoria;
	if($this->db->query($consulta)->result()[0]->total==0)
	{
		$subRamoText=$this->db->query('select Nombre from catalog_subRamos where IDSRamo='.$idSubRamo)->result()[0]->Nombre;
		$promotoriaText=$this->db->query('select Promotoria from catalog_promotorias where idPromotoria='.$idPromotoria)->result()[0]->Promotoria;
		//Crear relacion Promotoria
		$insert['idSubRamo']=$idSubRamo;
		$insert['idPromotoria']=$idPromotoria;
		$insert['horasOficinaCotizacion']=48;
		$insert['horasPortalCotizacion']=2;
		$insert['horasOficinaEmision']=144;
		$insert['horasPortalEmision']=2;
		$insert['horasOficinaEndosos']=144;
		$insert['horasPortalCaptura']=24;
		$insert['horasOficinaEndososB']=36;
		$insert['horasOficinaEndososD']=36;
		$insert['horasOficinaCancelaciones']=144;
		$insert['fechaCreacion'] = date("Y-m-d H:i:s");
		$this->db->insert('relacionramopromotoria',$insert);
		$result = $this->db->insert_id();
		//Insertar seguimiento
		$add = array(
			"idRamoPromotoria" => $result,
			//Pasa a ser la función donde se ejecutó
			//agregarGuardar y agregarCompaniaAdicional -> actividades, grabarActividadCompania -> prospección
			"campo" => $funcion,
			"valor" => "0",
			"accion" => "insertar",
			"hecho_por" => $this->tank_auth->get_idPersona()
		);
		$insert_training = $this->catalogos_model->insertTrainingRamoPromotoria($add);
		//Verifica módulo
		$modulo = $funcion != "grabarActividadCompania" ? "Actividades" : "Prospeccion";
		//Enviar correo
        $mensaje='<div>';
        $mensaje.='<div>La promotoria '.$promotoriaText.' no contaba con el semforo en el ramo '.$subRamoText.' por lo que se establecieron los siguientes valores:</div>';
        $mensaje.='<br>';
        $mensaje.='<div>Oficina cotizacion 48 horas</div>';
        $mensaje.='<div>Portal cotizacion 2 horas</div>';
        $mensaje.='<div>Oficina emision 144 horas</div>';
        $mensaje.='<div>Portal emision 2 horas</div>';
        $mensaje.='<div>Oficina endoso 144 horas</div>';
        $mensaje.='<div>Portal captura 24 horas</div>';
        $mensaje.='<div>Oficina endosoB 36 horas</div>';
        $mensaje.='<div>Oficina endosoD 36 horas</div>';
        $mensaje.='<div>Oficina cancelaciones 144 horas</div>';
        $mensaje.='<br><div>Acción realizada desde el módulo de <b>'.$modulo.'</b>.<br>Si requieres algun cambio solicitarlo a sistemas  SISTEMAS@ASESORESCAPITAL.COM</div>';
        $mensaje.='</div>';
			$insertCorreo['desde']="SEMAFORO<avisosgap@aserorescpital.com>";
			$insertCorreo['para']='DESARROLLO@AGENTECAPITAL.COM';
			$insertCorreo['copia']='0';
			$insertCorreo['copiaoculta']='0';
			$insertCorreo['asunto']='NUEVO SEMAFORO';
			$insertCorreo['mensaje']=$mensaje;
			$insertCorreo['status']='0';			
			$insertCorreo['identificaModulo']='ACTIVIDADES->verificaExistenciaSemaforo';
			$this->db->insert('envio_correos',$insertCorreo);

	}
}
//-----------------------------------------------------------
function verificaExistenciaDeSerie($serie)
{
	$band=false;
	$Poliza=$this->webservice_sicas_soap->SearchSerieAndPlaca($serie,5);
	foreach($Poliza["documentos"] as $doc)
	{
		if($doc->Serie==$serie)
		{
			$band=true;
		}
	}
	return $band;
}
//-----------------------------------------------------------
function verDocEnActividades()
{
	$this->load->view('generales/visorDocumentos');
}

//----------------------------------
function documentosEndoso()
{
	$datos['IDDocto']=166681;
	$datos['IDEnd']=17966;

	$respuesta=$this->ws_sicas->GetCDDigitalEndoso($datos);
	

}
//-----------------------------------------------------------
function agregarActividad()
{
	$data['vendedores']= $this->capsysdre_actividades->SelectVendedor($this->tank_auth->get_IDVend(),$this->tank_auth->get_IDVendNS(),$this->tank_auth->get_userprofile());
	$data['permitirRanking']	= $this->personamodelo->obtenerRankingAgente();	
	$data['pagoFactura']	= $this->capsysdre_actividades->pagoFactura();
	$data['preferenciaContacto']=$this->catalogos_model->preferenciaDeContactoCliente();
	
	
	$this->load->view('actividades/agregarActividad',$data);
}
//-----------------------------------------------------------
function agregarActividadBeta()
{
	$data['vendedores']= $this->capsysdre_actividades->SelectVendedor($this->tank_auth->get_IDVend(),$this->tank_auth->get_IDVendNS(),$this->tank_auth->get_userprofile());
	$data['permitirRanking']	= $this->personamodelo->obtenerRankingAgente();	
	$data['pagoFactura']	= $this->capsysdre_actividades->pagoFactura();
	$data['preferenciaContacto']=$this->catalogos_model->preferenciaDeContactoCliente();
	
	
	$this->load->view('actividades/agregarActividadBeta',$data);
}
//-----------------------------------------------------------
function obtenerRamosPorActividad()
{   
	$respuesta['succes']=true;
	$catalogoActividades=$this->actividades_model->idCatalogActividadesPorNombreObtener($_POST['nombreRamo'])[0];	
	$respuesta['ramos']=$this->actividades_model->TablaRamo($catalogoActividades->idActividad);
	echo json_encode($respuesta);
}
//-----------------------------------------------------------
function crearActivdadesAsincrono()
{
	$respuesta['success']=1;
	$_POST['usuarioCreacion']=$this->tank_auth->get_usermail();
	/*
	 SE CALCULAN CUANDO SE ENVIEN EN AGREGARGUARDAR
	  $POST['usuarioResponsable']
	  $POST['usuarioBolita']

	*/
	if(isset($_POST['cbCompania']))
	{
	 $cbCompania=explode(',',$_POST['cbCompania']);
	 $_POST['cbCompania']=$cbCompania;
	}
	
	$resultado=$this->comprobarDatosParaCrearActividad($_POST);
	$respuesta['success']=$resultado['success'];
	$respuesta['errorVacio']=$resultado['errorVacio'];
	echo json_encode($respuesta);
}
//-----------------------------------------------------------
function comprobarDatosParaCrearActividad($datos)
{
	
	$respuesta['success']=true;
	$respuesta['errorVacio']=array();
  $consulta='select (count(nombre)) as total from catalog_actividades where nombre="'.$datos['tipoActividad'].'"'; 
  if($this->db->query($consulta)->result()[0]->total==0){return false;}
  if(!(int)$_POST['IDCli']){array_push($respuesta['errorVacio'],'IDCli');}
  if($_POST['datosExpres']==''){array_push($respuesta['errorVacio'],'datosExpres');}
  if(!(int)$_POST['IDVend']){array_push($respuesta['errorVacio'],'IDVend');}
  switch ($datos['tipoActividad']) 
  {
	case 'Cotizacion':	
		if($_POST['cbCompania']==''){array_push($respuesta['errorVacio'],'cbCompania');}
		if($_POST['IDSRamo']=='17' || $_POST['IDSRamo']=='19' || $_POST['IDSRamo']=='21')
		{
			if($_POST['SerieAuto']==''){array_push($respuesta['errorVacio'],'SerieAuto');}
		}
	break;	

	case 'Emision':	
	break;
	case 'CambiodeConducto':
		if($_POST['rfcCliente']==''){array_push($respuesta['errorVacio'],'rfcCliente');}
	break;
	case 'Endoso':
		if($_POST['poliza']==''){array_push($respuesta['errorVacio'],'poliza');}
		if($_POST['tipoEndoso']==''){array_push($respuesta['errorVacio'],'tipoEndoso');}
	break;
	case 'CapturaEmision':
		if($_POST['rfcCliente']==''){array_push($respuesta['errorVacio'],'rfcCliente');}
		if($_POST['polizaNew']==''){array_push($respuesta['errorVacio'],'polizaNew');}
	break;
	case 'Sustitucion':
		if(!(int)$_POST['IDDocto']){array_push($respuesta['errorVacio'],'poliza');}
	break;
	case 'Cancelacion':
		if(!(int)$_POST['IDDocto']){array_push($respuesta['errorVacio'],'poliza');}
	break;

	default:
		
		break;
  }
  if(count($respuesta['errorVacio'])>0){$respuesta['success']=false;}
  return $respuesta;
}
//-----------------------------------------------------------
function traerDatosClienteRamo()
{
	$respuesta['success']=true;
	$consulta='select r.Abreviacion from catalog_ramos r left join catalog_subramos s on s.IDRamo=r.IDRamo where IDSRamo='.$_POST['IDSRamo'];

	$respuesta['Abreviacion']=$this->db->query($consulta)->result()[0]->Abreviacion;
	$respuesta['IDSRamo']=$_POST['IDSRamo'];
	$respuesta['cliente']=$this->ws_sicas->obtenerClientePorID($_POST['IDCli'])->TableInfo;
    
	echo json_encode($respuesta);
}
//-----------------------------------------------------------
function obtenerPreferencias()
{
	
}
//-----------------------------------------------------------
}
/* End of file actividades.php */
/* Location: ./application/controllers/actividades.php */