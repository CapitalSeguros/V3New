<?php
defined('BASEPATH') OR exit('No direct script access allowed');

 class Codigofacilito extends CI_Controller
  {
 	function __Codigofacilito()
 	    {
         parent::__construct();
    	 }

      function index()
      {
      	//$this->load->library('menu',array('blanco','rojo','verde'));
     // $data['mi_menu']=$this->menu->construirMenu();
      	//$this->load->helper('mihelpre');
      	//$this->load->view('codigofacilito/bienvenido',$data);
          $this->load->view('codigofacilito/formulario');
      }
      function nuevo(){
      	  $this->load->helper('form');
      	$this->load->view('codigofacilito/formulario');
      }
      function recibirDatos(){
       
        $data=array('nombre'=>$this->input->post('nombre'),
          'videos'=>$this->input->post('videos'));
         $this->load->model('codigofacilito_model');
         $this->codigofacilito_model->crearCurso($data);
         $this->nuevo();
         
      }

    }
?>