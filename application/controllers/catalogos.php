<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class catalogos extends CI_Controller
{
  function __construct()
  {
		parent::__construct();
       $this->load->library('Libreriav3');
       
  }
  function index(){}
  function documentosPersonales()
  {
    $respuesta['success']=1;
    $respuesta['catalogos']=$this->db->query('select * from catalogotipodocumento')->result();
    echo json_encode($respuesta);
  }
  
}