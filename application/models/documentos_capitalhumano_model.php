<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class documentos_capitalhumano_model extends CI_Model
{

   function __construct()
   {
      parent::__construct();
   }

   public function get_documentos(){
		$query = $this->db->query("SELECT * from documentos_capitalhumano ORDER BY nombre ASC");
		$result = $query->result();
		return $result;
	}

//***Modificaciones 14-jun 2021
	 public function get_documentos_puesto($idPersona){
		$query = $this->db->query("SELECT documentos_capitalhumano.* from documentos_capitalhumano,personapuesto WHERE personapuesto.idPersona='$idPersona' and personapuesto.idPuesto=documentos_capitalhumano.idPuesto");
		$result = $query->result();
		return $result;
	}

	public function get_documentos_puesto_asignados(){
		$query = $this->db->query("SELECT documentos_capitalhumano.*,personapuesto.personaPuesto from documentos_capitalhumano,personapuesto WHERE personapuesto.idPuesto=documentos_capitalhumano.idPuesto");
		$result = $query->result();
		return $result;
	}
	//*************
	
	public function guardar_documento($data){
		$this->db->insert("documentos_capitalhumano",$data);
	}
	public function borrar_documento($id){
		return $this->db->query("DELETE from documentos_capitalhumano where id = {$id}");
	}

	public function modificar_url_video($data){
		$this->db->set('url_video',$data['video']);
		$this->db->where('id',$data['id']);
	    $this->db->update('videos');
	    return;
	}

	function eliminaDoc($q){

		$respuesta=false;

		$this->db->where("id",$q);
		$this->db->delete("documentos_capitalhumano");

		if($this->db->trans_status()===FALSE){
			$this->db->trans_rollback();
		} else{
			$this->db->trans_commit();
			$respuesta=true;
		}

		return $respuesta;
	}

	function selectDoc($q){

		$respuesta=array();

		$this->db->where("id",$q);
		$query=$this->db->get("documentos_capitalhumano");

		if($query->num_rows()>0){
			$respuesta=$query->row();
		}

		return $respuesta;
	}

	function validateExistsFile($condition){ //Dennis Castillo [2022-03-15]

		$this->db->where($condition);
		$query = $this->db->get("documentos_capitalhumano");

		return $query->num_rows() > 0 ? $query->result(): array();
	}

	function countFilesRegisters($condition){ //Dennis Castillo [2022-03-15]

		$this->db->select("COUNT(*) as total", false);
		$this->db->where($condition);
		$query = $this->db->get("documentos_capitalhumano");

		return $query->num_rows() > 0 ? $query->row() : array();
	}
  }

?>