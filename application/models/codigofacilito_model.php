<? if(!defined('BASEPATH')) exit('No direct script access allowed');
class Codigofacilito_model extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->load->database();
	
	}
	function crearCurso($data){
			//$this->config->db->database();
		$this->load->database();
		//$this->db->insert('cursos',array('nombreCurso'=>$data['nombre'],'videosCurso'=>$data['videos']));
	}
	function obtenerCursos(){
		$this->load->database();
		$query=$this->db->get('cursos');
		if($query->num_rows()>0) return $query;
		else return false;
	}

}
?>