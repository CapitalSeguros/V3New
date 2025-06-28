<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class conferencia extends CI_Controller{
	var $mensaje="";
	var $datos	= array(); //"";
	function __construct(){
		parent::__construct();
		//$this->load->model('PersonaModelo');
		//$this->load->model('manejodocumento_modelo');
		//$this->load->model('capitalhumano_model');

  }
  function index(){

  	$this->load->view('conferencia/conferencia.php');
  }
}