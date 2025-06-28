<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class documentos_model extends CI_Model
{

   function __construct()
   {
      parent::__construct();
   }

   function saveDocument($data)
   {
      $res = $this->db->insert('documentos', $data);
      $insert_id = $this->db->insert_id();
      $result = new \stdClass;
      $result->status = true;
      $result->message = array();
      $result->id = $insert_id;
      //$this->_recuperarDocumentos($data,$result->data);
      if ($result->id > 0) {
         $result->status = true;
         $result->message[] = 'Se agrego correctamente';
      } else {
         $result->status = false;
         $result->message[] = 'No se encontra información en el sistema.';
      }
      return $result;
   }


   function getSiniestroTramite($id)
   {
      $obj = array();
      $this->db
         ->select("sr.*,tcg.id C_id, tcg.nombre C_nombre, setr.nombre estatus,setr.id id_est_tra,setr.orden orden_tram, indicador.dias,TIMESTAMPDIFF(DAY, tramite.fecha_inicio, CURDATE()) progreso,tramite.tipo_tramite,stg.nombre nombre_tramite,tramite.id id_tramite, setr.color, tramite.fecha_inicio,tramite.valores,tramite.descripcion tram_des,tramite.cobertura_afectada, tramite.cobertura_id,tramite.fecha_inicio fec_tram,tramite.folio_cia,tramite.fecha_fin fec_tram_F
		,if(tramite.fecha_inicio IS NULL, sr.inicio_ajuste,tramite.fecha_inicio) fecha_filtro,tramite.estatus_doc_cliente estatus_doc_revision, tramite.comentario_doc, tramite.user_doc, tramite.pass_doc ", false)
         ->where("sr.tipo_r", 'G')
         ->where("sr.id", $id)
         ->join("siniestro_tramite tramite", "sr.id=tramite.id_siniestro and tramite.id=(select max(tre.id) from siniestro_tramite tre where tre.id_siniestro=sr.id)", "left")
         ->join("tipo_coberturas_gmm tcg", "tramite.cobertura_id=tcg.id", "left")
         ->join("siniestro_tramite_gmm stg", "tramite.tipo_tramite=stg.id", "left")
         ->join("(select * from indicadores i where cliente_id=0 and i.sub_tipo_id=3) as indicador", "tramite.tipo_tramite=indicador.causa_id", "left")
         ->join("siniestro_estatus_tramites setr", "tramite.estatus=setr.id", "left");
      $this->db->group_by('sr.id');
      $obj = $this->db->get('siniestro_reportes sr');
      return $obj->result_array();
   }


   function getDocuments($tipo)
   {
      $sql = "select std.*,stip.nombre documento_nom from siniestro_tramite_documento std
		inner join siniestro_tipo_documento stip on std.id_tipo_documento=stip.id
		where std.modulo=3 and std.tramite='" . $tipo . "' ";
      $data = $this->db->query($sql);
      return $data->result_array();
   }

   function getUpDocuments($id)
   {
      $sql = "SELECT * from documentos WHERE referencia_id='" . $id . "' AND referencia='GMM'; ";
      $data = $this->db->query($sql);
      return $data->result_array();
   }

   function ValidateUser($data)
   {
      $sql = "SELECT * from siniestro_tramite WHERE user_doc='" . $data["usuario"] . "' AND pass_doc='" . $data["pass"] . "'; ";
      $data = $this->db->query($sql);
      return $data->result_array();
   }

   function UpdateAllDocs($id)
   {
      $sql = "UPDATE documentos SET estado='REVISION' WHERE referencia_id='" . $id . "' AND referencia='GMM' AND estado='PENDIENTE'; ";
      $data = $this->db->query($sql);
      return $data;
   }

   function UpdateTramiteEstatus($id, $estatus)
   {
      $sql = "UPDATE siniestro_tramite SET estatus_doc_cliente='" . $estatus . "' WHERE id='" . $id . "'; ";
      $data = $this->db->query($sql);
      return $data;
   }

   function UpdateTramiteComentario($id, $comentario)
   {
      $sql = "UPDATE siniestro_tramite SET comentario_doc='" . $comentario . "' WHERE id='" . $id . "'; ";
      $data = $this->db->query($sql);
      return $data;
   }

   function AgentValidateDoc($tipo, $estatus, $tramiteid)
   {
      $sql = "UPDATE documentos SET estado='" . $estatus . "' WHERE revision='" . $tipo . "' AND referencia_id='" . $tramiteid . "' AND referencia='GMM' ; ";
      $data = $this->db->query($sql);
      return $data;
   }

   function enviarCorreo($array)
   {
      $guardaMensaje['desde'] = "Avisos de GAP<avisosgap@aserorescpital.com>";
      $guardaMensaje['para'] = $array['para'];
      $guardaMensaje['asunto'] = $array['asunto'];
      $guardaMensaje['mensaje'] = $array['mensaje'];
      //$guardaMensaje['identificaModulo'] = $array['identificaModulo'];
      $guardaMensaje['status'] = 0;

      $guardaMensaje['fechaEnvio'] = date("Y-m-d H:i");
      $this->db->insert('envio_correos', $guardaMensaje);
   }

   function deleteDocDB($id){
      $sql = "DELETE FROM documentos WHERE file_id='".$id."';";
      $data = $this->db->query($sql);
      return $data;
   }

   function getAgenteByid($id){
      $sql = "select p.emailUsers as correo, CONCAT(p.nombres, ' ',p.apellidoPaterno, ' ',p.apellidoMaterno) as nombre from persona p
      inner join users u on p.idPersona=u.idPersona
      where p.idPersona='".$id."' ";
      $data = $this->db->query($sql);
      return $data->result_array();
   }

   function getSiniestroPoliza($id){
		$sql="SELECT * FROM siniestro_poliza WHERE poliza='".$id."';";
		$data=$this->db->query($sql);
		return $data->result_array();
	}

}
