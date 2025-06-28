<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Capsysdre_directorio extends CI_Model {
	
	function __construct(){
		parent::__construct();
	}/*! */
	
	function data_result_Proveedores($busqueda, $pagina){
		$nextPage = $pagina*25;
		$sqlBusquedaProveedores = "
			Select * From
				`directorio_proveedores`
			Where
				`Nombre_organizacion` Like '%".$busqueda."%'
			Group By
				`Nombre_organizacion`
			Limit
				".$nextPage.",25
									";
		$query = $this->db->query($sqlBusquedaProveedores);

		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return false;
		}	
	} /* !data_result_Proveedores */
	
	function detalleProveedor($IdProveedor){
		$sqlBusquedaProveedores = "
			Select * From
				`directorio_proveedores`
			Where
				`organizacion_id` = '$IdProveedor'
								  ";
		$query = $this->db->query($sqlBusquedaProveedores);

		if($query->num_rows() > 0){
			return $query->result();
		} else {
			return false;
		}
	} /* !detalleProveedor */
	
	//----------------------------
	function devuelveFormasDeContactoCliente($idcliente){

		$array_resultado=array();

		$this->db->where("IDCli", $idcliente);
		$query=$this->db->get("clientelealtadpuntos");

		if($query->num_rows()>0){
			$array_resultado=$query->result();
		}

		return $array_resultado;
	}
	//---------------------------
	function actualizaInformacionContacto($cliente, $informacion){

		$this->db->where("IDCli",$cliente);
		$this->db->update("clientelealtadpuntos",$informacion);

		$resultado=false;

		if($this->db->trans_status()===FALSE){
			$this->db->trans_rollback();
		} else{
			$this->db->trans_commit();
			$resultado=true;
		}

		return $resultado;

	}
	//---------------------------
	function generaNotaCliente($array){

		$resultado=false;

		$this->db->insert("notas_asignadas_en_clientes",$array);

		return $this->db->insert_id();

	}
	//----------------------------
	function asignaNotaAAgente($array){
		
		$resultado=false;

		$this->db->insert("notas_para_agente_de_clientes", $array);

		if($this->db->trans_status()===FALSE){
			$this->db->trans_rollback();
		} else {
			$this->db->trans_commit();
			$resultado=true;
		}

		return $resultado;
	}
	//----------------------------
	function consultaNotasCliente($idCli){

		$respuesta=array();

		$this->db->from("notas_asignadas_en_clientes");
		$this->db->join("notas_para_agente_de_clientes","notas_para_agente_de_clientes.Id_nota_comentario=notas_asignadas_en_clientes.id_nota_cliente","left");
		$this->db->join("persona","notas_para_agente_de_clientes.id_agente_asignado=persona.idPersona","left");
		$this->db->join("users","users.idPersona=persona.idPersona","left");
		$this->db->where("id_cliente",$idCli);
		$query=$this->db->get();

		if(!empty($query)){
			$respuesta=$query->result();
		}

		return $respuesta;
	}
	//---------------------------
	function eliminarRegistroDeNota($idNota){

		$resultado=false;

		$this->db->where("notas_asignadas_en_clientes.id_nota_cliente",$idNota)->delete("notas_asignadas_en_clientes");
		$this->db->where("notas_para_agente_de_clientes.Id_nota_comentario",$idNota)->delete("notas_para_agente_de_clientes");
		$this->db->where("referencia","NOTAS")
				->where("referencia_id",$idNota)
				->delete("notificacion");
		$this->db->where("idNota",$idNota)->delete("tareas");

		if($this->db->trans_status()===FALSE){
			$this->db->trans_rollback();
		} else{
			$this->db->trans_commit();
			$resultado=true;
		}

		return $resultado;
	}
	//---------------------------
	/*function eliminarRegistroDeNota($idNota){

		$resultado=false;

		$this->db->where("notas_asignadas_en_clientes.id_nota_cliente",$idNota)->delete("notas_asignadas_en_clientes");
		$this->db->where("notas_para_agente_de_clientes.Id_nota_comentario",$idNota)->delete("notas_para_agente_de_clientes");

		if($this->db->trans_status()===FALSE){
			$this->db->trans_rollback();
		} else{
			$this->db->trans_commit();
			$resultado=true;
		}

		return $resultado;
	}*/
	//---------------------------
	function actualizaNotaCliente($array,$nota){

		$resultado=false;

		$this->db->where("id_nota_cliente",$nota);
		$this->db->update("notas_asignadas_en_clientes",$array);

		if($this->db->trans_status()===FALSE){
			$this->db->trans_rollback();
		} else{
			$this->db->trans_commit();
			$resultado=true;
		}

		return $resultado;
	}
	//---------------------------
	function devuelveAgenteEnNota($idPersona){

		$resultado=array();

		$this->db->where("id_agente_asignado",$idPersona);
		$query=$this->db->get("notas_para_agente_de_clientes");

		if($query->num_rows()>0){
			$resultado=$query->result();
		}

		return $resultado;
	}
	//---------------------------
	function removerAgenteDeNota($agente,$nota){

		$resultado=false;
		$validador=array();

		$this->db->where("id_agente_asignado",$agente);
		$this->db->where("Id_nota_comentario", $nota);
		$this->db->delete("notas_para_agente_de_clientes");

		$removerDeProyectos=$this->removerTareaDeProyectos($agente,$nota);
		array_push($validador, $removerDeProyectos);

		if($this->db->trans_status()===FALSE){
			$this->db->trans_rollback();
		}
		else{
			$this->db->trans_commit();
			$resultado=true;
		}

		array_push($validador, $resultado);

		return  in_array(false,$validador) ? false : true; //return $resultado;
	}
	//---------------------------
	function removerTareaDeProyectos($idagente,$nota){

		$delete="DELETE tareas FROM tareas INNER JOIN proyectos ON tareas.idproyecto=proyectos.idproyecto WHERE proyectos.usuario=".$idagente." AND tareas.idNota=".$nota."";

		$query=$this->db->query($delete);

		return $query;
	}
	//---------------------------
	function consultaNotaPorId($nota){

		$resultado=array();

		$this->db->where("id_nota_cliente",$nota);
		$query=$this->db->get("notas_asignadas_en_clientes");

		if($query->num_rows()>0){
			//$resultado=$query->row();
			$resultado=$query->result();
		}

		return $resultado;
	}
	//---------------------------
	function consultaNotaPorAgenteAsignado(){

		$agente=$this->tank_auth->get_idPersona();
		$resultado=array();

		$this->db->from("notas_para_agente_de_clientes");
		$this->db->join("notas_asignadas_en_clientes", "notas_asignadas_en_clientes.id_nota_cliente=notas_para_agente_de_clientes.Id_nota_comentario", "inner");
		$this->db->where("notas_para_agente_de_clientes.id_agente_asignado", $agente);
		$query=$this->db->get();

		if($query->num_rows()>0){

			$resultado=$query->result();
		}

		return $resultado;
	}
	//---------------------------
	//Consulta de siniestros en activo para los contactos --Miguel Avila- Ticc Consultores
	function SiniestrosActivos($idCli=null,$Poliza=null){
		$this->db->select('count(*) activos')->where('sr.fecha_fin',null);
		if($idCli!=null){
			$this->db->where('sr.id_sicas_cliente', $idCli);
		}
		if($Poliza!=null){
			$this->db->where('sr.poliza', $Poliza);
		}
		$obj=$this->db->get('siniestro_reportes sr');
		$testsql=$this->db->last_query(); 
        $return=$obj->result_array();
		return $return[0]["activos"];
	}
	//---------------------------
	//Consulta de siniestros en activo (toda la informacion para mostar) para los contactos --Miguel Avila- Ticc Consultores
	function InfoSiniestrosActivos($idCli){
		$this->db->select('sr.*')->where('sr.fecha_fin')->where('sr.id_sicas_cliente', $idCli)->order_by("sr.inicio_ajuste","DESC");
		$obj=$this->db->get('siniestro_reportes sr');
        return $return=$obj->result_array();
	}	
}