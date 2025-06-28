<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class videotutoriales extends CI_Controller{

	function __construct(){
		parent::__construct();
	
			$params['id_sicas'] = $this->tank_auth->get_IDUserSICAS(); "get_IDUserSICAS";
			$params['user_sicas'] = $this->tank_auth->get_UserSICAS(); "get_UserSICAS";
			$params['pass_sicas'] = $this->tank_auth->get_PassSICAS(); "get_PassSICAS";
			$this->load->library('Ws_sicasdre',$params);
			$this->load->library('webservice_sicas_soap');
			$this->load->library('localfileuploader');

			$this->load->helper('ckeditor');
			$this->load->model('capsysdre_miinfo');
	}

   function index(){
		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			
			
			$this->load->view('videotutoriales/principal');
		}
	}

	

}