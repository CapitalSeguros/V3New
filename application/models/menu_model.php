<?php
class menu_model extends CI_Model{

	
	public function __Construct(){
		parent::__Construct();
			//$this->load->library('localfileuploader');
	}
public function buscaFotoPersonal($idPersona){
/*BUSCA SI EXISTE LA FOTO QUE VA EN LA CABECERA DEVUELVE LOS CAMPOS*/
	if($idPersona!=''){
	 //Miguel Jaime 16/10/2020
		$sql="SELECT fotoUser from user_miInfo where idPersona='$idPersona'";
		$datos=$this->db->query($sql)->result();
		foreach ($datos as $row){
	    		return $row->fotoUser;
	    	}
	}
	}
}
