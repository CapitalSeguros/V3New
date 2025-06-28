<?php defined('BASEPATH') or exit('no direccionar');
class Cursos extends CI_Controller{
	function __Cursos(){
		 parent::__construct();
	}
	function index(){
	//	 $this->load->helper('form');
	//	$this->load->view('cursos/formulario');
		$this->load->model('codigofacilito_model');
     $data['cursos']=$this->codigofacilito_model->obtenerCursos();
     $this->load->view('cursos/cursos',$data);
	}

}

?>