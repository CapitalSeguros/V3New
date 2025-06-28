<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class cambiaVariableSecion extends CI_Controller{
	
	var $meses;
	function __construct(){
		parent::__construct();
		$this->meses = 
		array(
			'Enero',
			'Febrero',
			'Marzo',
			'Abril',
			'Mayo',
			'Junio',
			'Julio',
			'Agosto',
			'Septiembre',
			'Octubre',
			'Noviembre',
			'Diciembre',
		);
		$this->load->library(array("webservice_sicas_soap","role"));	
		$this->load->model(array("catalogos_model","capsysdre_actividades","reportes_model"));	
	}
function index(){  

$_SESSION['BOXLIGHT']=false;

   }
 function cierraBox(){  
//session_unset($_SESSION['BOXLIGHT']); 
 	session_start(); 
$_SESSION['BOXLIGHT']=false;


   }
}