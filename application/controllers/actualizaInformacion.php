<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class actualizaInformacion extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
   		$config = array (
			'user_sicas' => $this->tank_auth->get_UserSICAS(),
			'pass_sicas' => $this->tank_auth->get_PassSICAS()
	   	);
		$this->load->library("webservice_sicas_soap",$config);
		// $this->load->model("capsysdre_actividades");
		// $this->load->model("catalogos_model");	
	}


	function actualizarClienteVendedores(){ //trae clientes en filedint1 en ceros
		$this->webservice_sicas_soap->UpdateClienteForVendedor(1);//Numero de Paginas
		// echo "<script>window.close();</script>";
		// echo "<script type='text/javascript'> window.onfocus=function(){ window.close();} </script>";
		$data["script"] = "<script type='text/javascript'> window.onfocus=function(){ window.close();} </script>";
		$this->load->view('actualizaInformacion/actualizarClienteVendedores', $data);
    	

	}
	function actualizarProspectosClientes(){
		$this->webservice_sicas_soap->UpdateClient_forPolicy(1);//Numero de Paginas
	}
	
	function index(){
		
		// $ars = explode('|', '||||||2|3||2||3||2||2||2|');

		// echo '<pre>';
		// print_r(array_filter($ars));


		$res = $this->webservice_sicas_soap->UpdateClienteForVendedorNew(1);



	}
} ?>