<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class ejecutivos extends CI_Controller{

	function __construct(){
		parent::__construct();		
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		//$this->load->library('security');
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');
		$this->load->library(array("webservice_sicas_soap","role"));	
		$this->load->model('personamodelo');
	}
	

	function index(){
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {

            //  $data['ListaVendedores']		=$this->personamodelo->obtVendAct();// $this->capsysdre->ListaVendedoresSinFiltroEjecutivos($this->input->get('busquedaUsuario', TRUE));
              $data['coordinadores']=$this->personamodelo->devuelveCoordinadoresVentas();
              $this->load->view('reportes/reportecoordinadores',$data);
		}
	} /*! index */

	function Consulta(){		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
	    
			 // $data['ListaVendedores']		= $this->personamodelo->obtVendAct();//$this->capsysdre->ListaVendedoresSinFiltroEjecutivos($this->input->get('busquedaUsuario', TRUE));
			 
			 $data['ListaVendedores']=$this->personamodelo->devuelveAgentesPorCoordinadorActivos($_GET['selectCoordinadores']);
			  $data['coordinadores']=$this->personamodelo->devuelveCoordinadoresVentas();
			  $data['idPersona']=$_GET['selectCoordinadores'];
              $this->load->view('reportes/reportecoordinadores', $data);


		}
	} 

}
/* End of file configuracones.php */
/* Location: ./application/controllers/configuraciones.php */