<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Inicio extends CI_Controller{

	function __construct(){
		parent::__construct();

			$params['id_sicas'] = $this->tank_auth->get_IDUserSICAS(); "get_IDUserSICAS";
			$params['user_sicas'] = $this->tank_auth->get_UserSICAS(); "get_UserSICAS";
			$params['pass_sicas'] = $this->tank_auth->get_PassSICAS(); "get_PassSICAS";
			$this->load->library('Ws_sicasdre',$params);

			$this->load->helper('ckeditor');
			$this->load->model('capsysdre_actividades');
			$this->load->model('preguntamodel');
	}
//-----------------------------------------------------------
	function index()
	{		
		if (!$this->tank_auth->is_logged_in()) {
			redirect('/auth/login/');
		} else {
			$idusuario =  $this->tank_auth->get_idPersona();			
			$this->db->from("calificaencuesta");
		    $this->db->where("idusuario",$idusuario);
		    $this->db->where("activa",'0');
		    $this->db->where("cliente",'0');
		    $id = -1;
		    $query =$this->db->get();
		    $data['usua'] = $idusuario;
		    $data['enc'] = 0;
		    foreach ($query->result() as $reg) {
		    	
		   		    $id = $reg->idcalificaencuesta;
            }
		   if($query->num_rows() > 0){
			 $data['enc'] =1;			 
             $data['Pre'] = $this->preguntamodel->TEncuestaEmpleado($id);
             $data['ide']= $id;
             
		    } else {
			  $data['enc'] =0;
		      $data['Pre'] =null;
              $data['ide']= $id;
		     }

			if($this->tank_auth->get_View()!= "App"){
				$this->load->view('inicio/principal',$data);
			} else {
				$this->load->view('inicio/principalApp',$data);
			}
		}
	}
//-----------------------------------------------------------	
function inicioBeta()
{		
	if (!$this->tank_auth->is_logged_in()) {
		redirect('/auth/login/');
	} else {
		$idusuario =  $this->tank_auth->get_idPersona();			
		$this->db->from("calificaencuesta");
		$this->db->where("idusuario",$idusuario);
		$this->db->where("activa",'0');
		$this->db->where("cliente",'0');
		$id = -1;
		$query =$this->db->get();
		$data['usua'] = $idusuario;
		$data['enc'] = 0;
		foreach ($query->result() as $reg) {
			
				   $id = $reg->idcalificaencuesta;
		}
	   if($query->num_rows() > 0){
		 $data['enc'] =1;			 
		 $data['Pre'] = $this->preguntamodel->TEncuestaEmpleado($id);
		 $data['ide']= $id;
		 
		} else {
		  $data['enc'] =0;
		  $data['Pre'] =null;
		  $data['ide']= $id;
		 }

		if($this->tank_auth->get_View()!= "App"){
			$this->load->view('inicio/principalBeta',$data);
		} else {
			$this->load->view('inicio/principalApp',$data);
		}
	}
}
//-----------------------------------------------------------	
}
