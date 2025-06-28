<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class cotizador extends CI_Controller{
var $datos;
	function __construct(){
		parent::__construct();     
		$this->CI =& get_instance();
			$this->load->model('PersonaModelo');

	}

	function index(){		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$datosUsers=$this->PersonaModelo->obtenerDatosUsers($this->tank_auth->get_idPersona());
			$this->datos['codeSicas']=$datosUsers->CodeAuthUserPersonaSicas;
			if($this->tank_auth->get_View()!= "App"){
				$this->load->view('cotizador/principal',$this->datos);
			} else {
				$this->load->view('cotizador/principalApp',$this->datos);
			}
		}
	}/*! index */

}
