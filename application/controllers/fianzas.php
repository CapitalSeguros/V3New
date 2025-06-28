<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class fianzas extends CI_Controller{

	function __construct(){
		parent::__construct();   
			$this->load->model('clientelealtadmodelo'); 
			$this->load->model('personamodelo');  
			$this->load->library('Ws_sicas'); 
	}

	function index(){		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['configModulos']			= $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());

			$this->load->view('fianzas/principal', $data);
		}
	}/*! index */
	
	
	
	function ver(){		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['configModulos']			= $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());

			$this->load->view('fianzas/principal', $data);
		}
	}/*! ver */
	
	function agregar(){		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$data['configModulos']			= $this->capsysdre->ConfiguracionUsuarios($this->tank_auth->get_usermail());

			$this->load->view('fianzas/principal', $data);
		}
	}/*! ver */

}

/* End of file inicio.php */
/* Location: ./application/controllers/fianzas.php */