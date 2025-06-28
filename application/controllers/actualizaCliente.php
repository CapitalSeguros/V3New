<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class ActualizaCliente extends CI_Controller{

	function __construct(){
		parent::__construct();
			$this->load->library(array('webservice_sicas_soap',));
			$this->load->model(array('capsysdre_actualizacliente',));

	}

	function index()
	{
		$busquedaCliente = '';
		$poliza = '';
		if($this->input->post('busquedaCliente') != null){
			$busquedaCliente = strtoupper($this->input->post('busquedaCliente'));
		}

		if($this->input->post('poliza') != null){
			$poliza = strtoupper($this->input->post('poliza'));
		}
		
		$Regimen = '-1';		
		if($this->input->post('RegimenFiscal') != null){
			$Regimen = $this->input->post('RegimenFiscal');
		}

		$data['actualiza'] = "clienteWeb";
		$data['busquedaCliente'] = $busquedaCliente;
		$data['Regimen'] = $Regimen;
		$data['ListaClientes'] =  null;
		$data['poliza'] = $poliza;
		
		if(isset($busquedaCliente) && $busquedaCliente != ""){
			
			$datos = array(
				"role" 			  => 0,
				"id"  			  => 0,
				"busquedaCliente" => $busquedaCliente,
				"regimen" 	      => $Regimen,
				"documento"       => $poliza
				);
			$data['ListaClientes']	= $this->webservice_sicas_soap->GetClient_forNameClient($datos);
			
			if(empty($data['ListaClientes'][0])){
				$data['Regimen'] = -1;
			}
			
		}
		#echo json_encode($data);
		$this->load->view('actualizaCliente/principal',$data);
	}
	
	/*
	* guardarActualizacionDatos = Guarda todos los elementos capturados en la vista
	*/
	function guardarActualizacionDatos()
	{	
		
		$data['actualiza']   = 'clienteWeb';
		$data['IDCli'] 	 	 = $_REQUEST['IDCli'];
		$data['IDCont'] 	 = $_REQUEST['IDCont'];
		$data['TipoEnt'] 	 = $_REQUEST['TipoEnt'];
		$data['Nombre'] 	 = $_REQUEST['Nombre'];
		$data['ApellidoP'] 	 = $_REQUEST['ApellidoP'];
		$data['ApellidoM'] 	 = $_REQUEST['ApellidoM'];
		$data['RazonSocial'] = $_REQUEST['RazonSocial'];
		$data['RFC'] 		 = $_REQUEST['RFC'];
		$data['EMail1'] 	 = $_REQUEST['Correo'];
		$data['Telefono1'] 	 = $_REQUEST['Telefono'];
		
		if(empty($data['TipoEnt'] ))
			$data['TipoEnt'] 	 = $_REQUEST['RegimenFiscal'];
		if(empty($data['RazonSocial'] ))
			$data['RazonSocial'] = $_REQUEST['rsocial'];
		
		$result = $this->capsysdre_actualizacliente->ActualizaCliente($data);
		
		return $result;
	}
}

/* End of file actualizaCliente.php */
/* Location: ./application/controllers/actualizaCliente.php */