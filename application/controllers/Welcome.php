<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Welcome extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('googledrive');
	}
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	//FUNCION QUE SE CARGA POR DEFECTO DEL CONTROLADOR 
	public function index()
	{ //INDICA QUE SE CARGUE LA 
		//INDICA QUE SE LA views SE CARGUE LA PAGINA welcome_message.PHP
		$dato['string'] = 'del controlador a la vista';
		$this->load->view('welcome_message', $dato);
	}
}
