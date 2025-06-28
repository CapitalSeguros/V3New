<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class serviciotic_model extends CI_Model {
	
	public function __Construct(){
		parent::__Construct();
	}
	
	
    function getPermisosPuesto($puesto, $url)
    {
        $SQL = "select mp.acciones permisos, mp.id id_permiso from modulo_permisos mp
        left join modulo_url mu on mp.id_url=mu.id
        where mp.id_puestoPersona=" . $puesto . " and mu.url='" . $url . "'";
        $query = $this->db->query($SQL);
        return $query->result_array();
    }

}