<?php
class catalogos_kpi extends CI_Model{

	public function __Construct(){
		parent::__Construct();
	}
	function guardar_indicadores($data){
		$query = "UPDATE catalog_kpi SET pco={$data['pco']}, df={$data['df']}, dc={$data['dc']} WHERE id=0";
		$this->db->query($query);
	}
	function get_indicadores(){
		$query = $this->db->query("SELECT * from catalog_kpi WHERE id=0");
		$result = $query->result();
		return $result;
	}
}

?>
