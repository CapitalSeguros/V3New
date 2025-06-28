<?php
class calendar_model extends CI_Model{
	var $lsActividades = array();
	var $Actividad;
	var $Invitados;
	var $InvitadosAndPromotor = array();
	var $Promotores = array();
	var $Useralias = array();
	var $VendedorPromotor = array();
	var $data = array();
	var $data_id;
	var $foridNsUser = array();
	
	public function __Construct(){
		parent::__Construct();
	}
	public function Insert_Cal($data){
		
		//$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($data,TRUE));fclose($fp);

		$insert_value = false;
		
		try{
			
			$this->db->trans_begin();
			
			$data_table = array(
					'cal_id' => $data["cal_id"],
					'title' => $data["title"],
					'color' => $data["color"],
					'correo' => $data["correo"],
					'estatusOrganizador' => $data["estatusOrganizador"],
					'created_by' => $data["created_by"],
					'created_on' => $data["created_on"],
					'clasificacion'=>$data["clasificacion"], //[Dennis 2020-06-11]
					'categoria_capacitacion'=>$data["categoria_capacitacion"],
					'sub_categoria_capacitacion'=>$data["sub_categoria_capacitacion"],
					'ramo_capacitacion'=>$data["ramo_capacitacion"]
			);
			
			$this->db->insert('cal_events', $data_table);
			
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
			}
			else
			{
				$this->db->trans_commit();
				$insert_value = true;
			}

		}catch(Exception $e){
			
		}
		
		return $insert_value;
	}	
	
	public function update_Cal($data){
		
		$insert_value = false;
		
		try{
			
			$this->db->trans_begin();
			
			$data_table = array(
					'cal_id' => $data["cal_id"],
					'title' => $data["title"],
					'color' => $data["color"],
					'correo' => $data["correo"],
					'estatusOrganizador' => $data["estatusOrganizador"],
					'modified_by' => $data["modified_by"],
					'updated_on' => $data["updated_on"],
					'clasificacion'=>$data["clasificacion"], //[Dennis 2020-06-11]
					'categoria_capacitacion'=>$data["categoria_capacitacion"],
					'sub_categoria_capacitacion'=>$data["sub_categoria_capacitacion"],
					'ramo_capacitacion'=>$data["ramo_capacitacion"]
			);
			$this->db->where('cal_id', $data["cal_id"]);
			$this->db->update('cal_events', $data_table);
			
			if ($this->db->trans_status() === FALSE)
			{
				$this->db->trans_rollback();
			}
			else
			{
				$this->db->trans_commit();
				$insert_value = true;
			}

		}catch(Exception $e){
			
		}
		
		return $insert_value;
	}
	public function select_event($eventId){
		
		$insert_value = false;
		
		try{
			
			//$this->db->select("id,cal_id,title,color,correo");
			$this->db->select("id,cal_id,title,color,correo,clasificacion"); //[Dennis 2020-06-011]
			$this->db->where("cal_id",$eventId);
			
			$this->Invitados = $this->db->get("cal_events");
			
			if ($this->Invitados->num_rows() > 0){

				$result = $this->Invitados->result_array();
			}else{
				$result = array();
			}

		}catch(Exception $e){
			
		}
		
		return $result;
	}
	public function select_event_email($correo){
		
		$insert_value = false;
		
		try{
			
			$this->db->select("cal_id");
			$this->db->where("correo",$correo);
			
			$this->Invitados = $this->db->get("cal_events");
			
			if ($this->Invitados->num_rows() > 0){

				$result = $this->Invitados->result_array();
			}else{
				$result = array();
			}

		}catch(Exception $e){
			
		}
		
		return $result;
	}
	public function correoAlternativo($correo){
		$this->db->select("emailAlternativo");
		$this->db->where("email",$correo);
		$correos=$this->db->get("users");
		
		if($correos->num_rows()>0){
		
			//$res['emailAlternativo']=$this->$correos->result_array();
			foreach ($correos->result() as $value) {
				   if($value->emailAlternativo==""){
                     $result=0;

				   }else
					{$result=$value->emailAlternativo;}
				}	

		}else{
			$result="N";
		}
	//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($result, TRUE));fclose($fp);	
		return $result;
	}

	//-----------------------------------------------------------------------------------------------
	//[Dennis 2020-07-01]
	//Sección para invitados
	function inserta_invitados($datosInvitado){

		//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($datosInvitado, TRUE));fclose($fp);
		$estadoFunction=false;

		$this->db->insert("invitados_eventos", $datosInvitado);
		$obtenerId=$this->db->insert_id();

		//realizamos la transacciones para posibles errores.
		if($this->db->trans_status()===FALSE){
			$this->db->trans_rollback();

		} else{
			
			$this->db->trans_commit();
			$estadoFunction=true;
		}

		return $obtenerId;
		//$this->db->insert("invitados_externos", $datosInvitado);
	}
	//------------------------------------------------------------------------------------------------------
	//[Dennis 2020-07-02]: obtencion de datos de invitados internos.
	function obtener_invitado_interno($correo){
		
		$this->db->select("persona.idPersona,persona.nombres, persona.apellidoPaterno, persona.apellidoMaterno, users.email, persona.celPersonal, persona.municipioDomicilio, catalog_tipouser.nombre");
		$this->db->from("persona");
		$this->db->join("users","users.idPersona=persona.idPersona","inner");
		$this->db->join("catalog_tipouser", "catalog_tipouser.idTipoUser=users.idTipoUser","inner");
		$this->db->where("persona.bajaPersona",0);
		$this->db->where("users.activated",1);
		$this->db->where("users.banned",0);
		$this->db->where("users.email",$correo);
		$resultado=$this->db->get()->result();

		if(empty($resultado)){
			$resultado=array();
		}

		return $resultado;
	}

	//------------------------------------------------------------------------------------------------------
	function devuelveInvitados($idEvento){

		//$this->db->distinct();
		$this->db->where("id_evento",$idEvento);
		//$this->db->where("tipo_invitado", $tipo);
		$query=$this->db->get("invitados_eventos");

		if($query->num_rows()>0){
			$resultado=$query->result();
		} else{
			$resultado=array();
		}

		return $resultado;
	}
	//------------------------------------------------------------------------------------------------------
	function consultaInvitados($correo, $evento){

		$bandera=false;

		$this->db->where("correo_lectronico",$correo);
		$this->db->where("id_evento", $evento);
		$query=$this->db->get("invitados_eventos");

		if($query->num_rows()>0){
			$bandera=true;
		}

		return $bandera;

	}

	//------------------------------------------------------------------------------------------------------

	function actualizaEstado($idInvitado, $estado){

		$this->db->where("id_invitado",$idInvitado);
		$this->db->update("invitados_eventos", $estado);

		$band=false;

		if($this->db->trans_status()===FALSE){
			$this->db->trans_rollback();

		} else{
			$this->db->trans_commit();
			$band=true;
		}

		return $band;
	}

	//------------------------------------------------------------------------------------------------------
	function obtenerInvitado($idInvitado){

		$resultado=array();

		$this->db->where("id_invitado", $idInvitado);
		$query=$this->db->get("invitados_eventos");

		if($query->num_rows()>0){
			$resultado=$query->result();
		}

		return $resultado;
	}
	//------------------------------------------------------------------------------------------------------
	function devuelve_invitado_unitario($correo, $idEvento){

		$respuesta=array();

		$select="SELECT * FROM invitados_eventos WHERE correo_lectronico='".$correo."' AND id_evento='".$idEvento."' AND (estado='aceptado' OR estado='pendiente')";
		$query=$this->db->query($select);

		if($query->num_rows()>0){
			$respuesta=$query->result();
		}

		return $respuesta;
	}
	//------------------------------------------------------------------------------------------------------
	function actualizaEstadoInterno($evento, $invitado, $estado){

		$bandera=false;

		$this->db->where("id_evento", $evento);
		$this->db->where("id_invitado", $invitado);
		$this->db->update("invitados_eventos", $estado);

		if($this->db->trans_status()==FALSE){
			$this->db->trans_rollback();
		} else{
			$this->db->trans_commit();
			$bandera=true;
		}

		return $bandera;
	}

	//--------------------------------------------------------------------------------------------------------
	function cancelaCorreoExterno($correo, $evento, $cambio){

		$bandera=false;

		$this->db->where("correo_externo", $correo);
		$this->db->where("id_evento",$evento);
		$this->db->update("catalog_correos_externos",$cambio);

		if($this->db->trans_status()===FALSE){
			$this->db->trans_rollback();
		} else{
			$this->db->trans_commit();
			$bandera=true;
		}

		return $bandera;
	}
	//--------------------------------------------------------------------------------------------------------
	function insertaEnTemporal($datos){

		$resultado=false;

		$this->db->insert("tmp_events_hours",$datos);

		if($this->db->trans_status()===FALSE){
			$this->db->trans_rollback();
		}else{
			$this->db->trans_commit();
			$resultado=true;
		}

		return $resultado;
	}
	//-------------------------------------------------------------------------------------------------------
	function actualizaEnTemporal($datos,$invitado){
		$resultado=false;

		$this->db->where("id_invitado",$invitado);
		$this->db->update("tmp_events_hours",$datos);

		if($this->db->trans_status()===FALSE){
			$this->db->trans_rollback();
		} else{
			$this->db->trans_commit();
			$respuesta=true;
		}

		return $respuesta;
	}
	//-------------------------------------------------------------------------------------------------------
	function pruebaProcedimiento($invitado,$evento){

		$resultado=array();

		//Conexión a la db2 por problemas con MySqli
		$db2=$this->load->database("db2",true);

		$query=$db2->query("CALL tmpHrs_trainingHrs_transaction(".$invitado.",'".$evento."')");

		if($query->num_rows()>0){
			$resultado=$query->result();
		}
	
		return $resultado;
	}
	//-------------------------------------------------------------------------------------------------------
	function devuelveInfoTmp($invitado){

		$resultado=array();

		$this->db->where("id_invitado",$invitado);
		$query=$this->db->get("tmp_events_hours");

		if($query->num_rows()>0){
			$resultado=$query->result();
		}

		return $resultado;
	}
	//-------------------------------------------------------------------------------------------------------
	function devuelveInvitadosTmp($evento){

		$resultado=array();

		$this->db->where("id_evento",$evento);
		$query=$this->db->get("tmp_events_hours");

		if($query->num_rows()>0){
			$resultado=$query->result();
		}

		return $resultado;

	}
	//-------------------------------------------------------------------------------------------------------

	function actualizaTmpInterno($evento,$invitado,$estado){
		$bandera=false;

		$this->db->where("id_evento", $evento);
		$this->db->where("id_invitado", $invitado);
		$this->db->update("tmp_events_hours", $estado);

		if($this->db->trans_status()==FALSE){
			$this->db->trans_rollback();
		} else{
			$this->db->trans_commit();
			$bandera=true;
		}

		return $bandera;
	}
	//-------------------------------------------------------------------------------------------------------
	function devuelvePendientesTmp($evento){

		$resultado=array();

		$this->db->where("id_evento",$evento)
				->where("estado","aceptado");
		$query=$this->db->get("tmp_events_hours");

		if($query->num_rows()>0){
			$resultado=$query->result();
		}

		return $resultado;
	}
	//-------------------------------------------------------------------------------------------------------
	function eliminaInfoCapacitacion($evento){

		$tablas=array("tmp_events_hours","registro_certificacion","invitados_eventos");

		$this->db->where("id_evento",$evento);
		$this->db->delete($tablas);

	}
	//-------------------------------------------------------------------------------------------------------
	function retornaClasificacionEvento($evento){
		
		$resultado=array();

		$this->db->select("clasificacion")
				->where("cal_id",$evento);
		$query=$this->db->get("cal_events");

		if($query->num_rows()>0){
			$resultado=$query->row();
		}

		return $resultado;
	}
	//-------------------------------------------------------------------------------------------------------
	function retornaReporteEvento($evento){

		$resultado=array();

		$this->db->where("id_evento",$evento);
		$query=$this->db->get("registro_certificacion");

		if($query->num_rows()>0){
			$resultado=$query->result();
		}

		return $resultado;
	}
	//-------------------------------------------------------------------------------------------------------
	function devuelveInfoTotal($evento){

		$resultado=array();

		$where="`tmp_events_hours`.`id_evento`='".$evento."' AND (`invitados_eventos`.`estado`='aceptado' OR `invitados_eventos`.`estado`='rechazado')";

		$this->db->select("registro_certificacion.idCertificacion,invitados_eventos.id_evento,id_persona,invitados_eventos.id_invitado,nombres,apellido_paterno,apellido_materno,correo_lectronico,tipo_invitado,invitados_eventos.estado")
				->from("tmp_events_hours")
				->join("invitados_eventos","tmp_events_hours.id_invitado=invitados_eventos.id_invitado","left")
				->join("registro_certificacion","tmp_events_hours.id_invitado=registro_certificacion.id_invitado","left")
				->where("invitados_eventos.estado","aceptado")
				//->where("invitados_eventos.estado !=","pendiente")
				->where("invitados_eventos.id_evento",$evento);
				//->group_by("tmp_events_hours.id_persona");
				//->where($where);
		$query=$this->db->get();

		if($query->num_rows()>0){
			$resultado=$query->result();
		}

		return $resultado;
	}
	//------------------------------------------------------------------------------------------------------
	

	//-------------------------------------------------------------------------------------------------------
	function eliminaRegistroCapacitacion($agente,$evento){

		$resultado=false;

		$this->db->where("idPersona",$agente)
				->where("id_evento",$evento)
				->delete("registro_certificacion");

		if($this->db->trans_status()===FALSE){
			$this->db->trans_rollback();
		} else{
			$this->db->trans_commit();
			$resultado=true;
		}

		return $resultado;
	}
	//-------------------------------------------------------------------------------------------------------
}
?>