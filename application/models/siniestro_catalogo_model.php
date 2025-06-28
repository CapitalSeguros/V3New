<?php
class siniestro_catalogo_model extends CI_Model{

    public function __Construct(){
		parent::__Construct();
    }

    function getAllData($tabla){
		$tipos = $this->db->get($tabla);
        return $tipos->result_array();
    }

    function insertData($data,$tabla)
    {
        $this->db->insert($tabla, $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    
    function updateData($id,$data,$tabla){
        $this->db->where('id', $id);
        $res = $this->db->update($tabla, $data);
        return $res;
    }

    function deleteData($id,$tabla){
		if (!$this->db->delete($tabla, array('id' => $id))) {
            return false;
        }
        return true;
    }

    function ExistName($nombre,$tabla){
      $tipos = $this->db->where('nombre', $nombre)->get($tabla);
      return empty($tipos->result_array())?true:false;
      //return $tipos->result_array();
    }
    function ExistNameAndTipo($nombre,$tipo,$tabla){
      $tipos = $this->db->where('nombre', $nombre)->where('tipo_c', $tipo)->get($tabla);
      return empty($tipos->result_array())?true:false;
      //return $tipos->result_array();
    }

    function ExistNameDocTramite($tipo_doc,$tramite,$modulo){
      $tipos = $this->db->where('modulo', $modulo)->where('id_tipo_documento', $tipo_doc)->where('tramite', $tramite)->get('siniestro_tramite_documento');
      return empty($tipos->result_array())?true:false;
      //return $tipos->result_array();
    }

    function ExistCausa($tipo,$nombre){
      $tipos = $this->db->where('tipo_siniestro_id', $tipo)->where('nombre', $nombre)->get('siniestro_causa');
      return empty($tipos->result_array())?true:false;
      //return $tipos->result_array();
    }

    function getLastidTipo(){
        $sql='Select MAX(id) id from siniestro_tipo';
        $data=$this->db->query($sql);
        $obj=$data->result_array();
		    return $obj[0]['id'];
    }

    function getLastidCausa(){
      $sql='Select MAX(id) id from siniestro_causa';
      $data=$this->db->query($sql);
      $obj=$data->result_array();
      return $obj[0]['id'];
  }

    
    
    function getAllDoucumentosTramites(){
        $sql="select std.id,std.modulo modulo_id,std.id_tipo_documento documento_id,std.tramite tramite_id,ind.nombre modulo_nom,stip.nombre documento_nom,
        case
          when std.modulo=3 then (select stg.nombre from siniestro_tramite_gmm stg where std.tramite=stg.id)
          when std.modulo=1 then (select stdd.nombre from siniestro_tramite_danos stdd where std.tramite=stdd.id)
          when std.modulo=2 then (select stda.nombre from siniestro_tramite_autos stda where std.tramite=stda.id)
            else ''
        end tram_nom
        from siniestro_tramite_documento std
        inner join indicador_sub_tipo ind on std.modulo=ind.id
        inner join siniestro_tipo_documento stip on std.id_tipo_documento=stip.id";
		$data=$this->db->query($sql);
		return $data->result_array();
    }

    function getCoberturasDanos(){
      $sql="select * from tipo_coberturas_gmm tc where tc.Tipo='DAÑOS';";
      $data=$this->db->query($sql);
		  return $data->result_array();
    }

    function getcausasAutos(){
      $sql="select sc.id, sc.tipo_siniestro_id tipo_id, st.nombre tipo_nombre, sc.nombre from siniestro_causa sc
      left join siniestro_tipo st on sc.tipo_siniestro_id=st.id order by st.id";
      $data=$this->db->query($sql);
		  return $data->result_array();
    }

    function getAllCoberturaGMM(){
      $res=$this->db->get('siniestro_gmm_cobertura');
      return $res->result_array();
    }

    //nuevo
    function getAfterchange($orden){
      $this->db->where('s.order',$orden);
      $obj=$this->db->get('siniestro_tramite_danos s');
      return $obj->result_array();
    }
    function getAfterchangeNombre($orden){
      $this->db->where('s.id',$orden);
      $obj=$this->db->get('siniestro_tramite_danos s');
      return $obj->result_array();
    }

    function getalltramitesD(){
      $this->db->where('s.delete',NULL);
      $this->db->order_by('s.order','ASC');
      $obj=$this->db->get('siniestro_tramite_danos s');
      return $obj->result_array();
    }

    function getAllDeletetipos($order){
      $this->db->where('s.delete',NULL);
      $this->db->where("s.order >",$order);
      //$this->db->where("s.id",$id);
      $obj=$this->db->get("siniestro_tramite_danos s");
      return $obj->result_array();
    }

    function deleteDataTramites($id,$data){
     $this->db->where("id",$id);
     $this->db->update("siniestro_tramite_danos",$data);
     return true;
    }

  //-------------------------------------------------------------------------------------------------------
    function uploadDocumentSiniestros($data) { //Creado [Suemy][2024-05-21]
      $query = $this->db->insert('documentos_siniestros',$data);
      return $this->db->insert_id();
    }

    function deleteDocumentSiniestros($data) {
      return $this->db->delete('documentos_siniestros', array('id' => $data));
    }

    function verifyDocumentSiniestros($data) { //Creado [Suemy][2024-05-21]
      $this->db->select("COUNT(*) as total");
      $this->db->where($data);
      $query = $this->db->get("documentos_siniestros");
      return $query->num_rows() > 0 ? $query->row() : array();
    }

    function getDocumentSiniestrosById($id) { //Creado [Suemy][2024-05-21]
      $query = $this->db->select('*')->where('id',$id)->get('documentos_siniestros');
      return $query->num_rows() > 0 ? $query->row() : array();
    }

    function getDocumentSiniestros($data) { //Creado [Suemy][2024-05-21]
      $query = $this->db->query('SELECT d.*, u.name_complete, u.email, p.tipoPersona FROM documentos_siniestros d INNER JOIN users u ON u.idPersona = d.registrado_por INNER JOIN persona p ON p.idPersona = d.registrado_por '.$data.' ORDER BY d.registro DESC')->result();
      return $query;
    }

    function getPersonById($idPersona) { //Creado [Suemy][2024-05-21]
      $this->db->select('p.*, us.email');
      $this->db->join('users us','us.idPersona = p.idPersona','inner');
      $this->db->where('p.idPersona', $idPersona);
      $query = $this->db->get('persona p');
      return $query->num_rows() > 0 ? $query->result() : array();
    }

    function getBoosById($id,$type) { //Creado [Suemy][2024-05-21]
      if ($type == 1) {
        $sql = 'select pp.idPuesto, pp.personaPuesto as puesto, pp.idPersona, pj.apellidoPaterno as apellidoPJ, pj.apellidoMaterno as apellidoMJ, pj.nombres as nombreJefe, ppj.personaPuesto as jefePuesto, ppj.email as jefeEmail, c.colaboradorArea as area, p.nombres, p.apellidoPaterno, p.apellidoMaterno, p.fechaNacimiento, p.telOficina, p.celOficina, p.celPersonal, p.fecAltaSistemPersona as altaSistema, TIMESTAMPDIFF(YEAR, (p.fecAltaSistemPersona), DATE(NOW())) as antiguedad, us.email from personapuesto pp left join colaboradorarea c on c.idColaboradorArea=pp.idColaboradorArea left join persona p on p.idPersona=pp.idPersona left join users us on us.idPersona = pp.idPersona left join personapuesto ppj on ppj.idPuesto = pp.padrePuesto inner join persona pj on pj.idPersona = ppj.idPersona where pp.statusPuesto=1 and pp.idPersona != 0 and pp.idPersona='.$id;
      } 
      else {
        $sql = 'select * from persona where idPersona = '.$id;
      }
      $query = $this->db->query($sql);
      return $query->num_rows() > 0 ? $query->result() : array();
    }

  //-------------------------- Encuestas Siniestros | Creado [Suemy][2024-09-06] --------------------------
    //Encuestas Siniestros | Creado [Suemy][2024-09-06]
    function getSurvey($sql = NULL) {
      $query = $this->db->query('SELECT es.*, cr.Nombre AS nombre_ramo, us.name_complete AS nombre_creador FROM encuesta_siniestro es INNER JOIN catalog_ramos cr ON cr.IDRamo = es.idRamo INNER JOIN users us ON us.idPersona = es.creado_por '.$sql)->result();
      foreach ($query as $val) {
        $val->preguntas = $this->getQuestionSurvey($val->idEncuesta);
      }
      return $query;
    }

    function getQuestionSurvey($id) {
      $query = $this->db->query('SELECT * FROM encuesta_siniestro_preguntas WHERE idEncuesta = '.$id)->result();
      foreach ($query as $row) {
        $options = ($row->tipo == 1) ? $this->db->query('SELECT titulo FROM encuesta_siniestro_opciones WHERE idPregunta = '.$row->idPregunta)->result() : "";
          $row->opciones = $options;
      }
      return $query;
    }

    function getQuestionOptions($id) {
      $query = $this->db->query('SELECT * FROM encuesta_siniestro_opciones WHERE idPregunta = '.$id)->result();
      return $query;
    }

    function getAnswerQuestionSurvey($id) {
      $query = $this->db->query('SELECT * FROM encuesta_siniestro_respuestas WHERE idResuelta = '.$id)->result();
      return $query;
    }

    function getResponseSurvey($id) {
      $query = $this->db->query('SELECT * FROM encuesta_siniestro_resueltas WHERE id = '.$id)->result();
      return $query;
    }

    function insertSurvey($data) {
      $query = $this->db->insert('encuesta_siniestro',$data);
      return $this->db->insert_id();
    }

    function insertQuestionSurvey($data) {
      $query = $this->db->insert('encuesta_siniestro_preguntas',$data);
      return $this->db->insert_id();
    }

    function insertQuestionOptions($data) {
      $query = $this->db->insert('encuesta_siniestro_opciones',$data);
      return $this->db->insert_id();
    }

    function insertAnswerQuestionSurvey($data) {
      $query = $this->db->insert('encuesta_siniestro_respuestas',$data);
      return $this->db->insert_id();
    }

    function insertSurveyResponse($data) {
      $query = $this->db->insert('encuesta_siniestro_resueltas',$data);
      return $this->db->insert_id();
    }

    function updateSurvey($id,$data) {
      $this->db->where('idEncuesta',$id);
      $query = $this->db->update('encuesta_siniestro',$data);
      return $query;
    }

    function updateQuestionSurvey($id,$data) {
      $this->db->where('idPregunta',$id);
      $query = $this->db->update('encuesta_siniestro_preguntas',$data);
      return $query;
    }

    function updateResponseSurvey($id,$data) {
      $this->db->where('id',$id);
      $query = $this->db->update('encuesta_siniestro_resueltas',$data);
      return $query;
    }

    function updateAnswerQuestionSurvey($id,$data) {
      $this->db->where('idRespuesta',$id);
      $query = $this->db->update('encuesta_siniestro_respuestas',$data);
      return $query;
    }

    function deleteQuestionSurvey($data) {
      $this->db->delete('encuesta_siniestro_opciones', array('idPregunta' => $data));
      return $this->db->delete('encuesta_siniestro_preguntas', array('idPregunta' => $data));
    }

    function getSurveyExist($data) {
      $query = $this->db->select('*')->where($data)->get('encuesta_siniestro_resueltas');
      /*$query = $this->db->select('esr.*,sr.*')
        ->join('siniestro_reportes sr', 'sr.poliza = esr.poliza and sr.siniestro_id = esr.siniestro', 'inner')
        ->where($data)->get('encuesta_siniestro_resueltas esr');*/
      return $query->num_rows() > 0 ? $query->result() : array();
    }

    function getCompleteResponse($id) {
      $query = $this->db->query('SELECT esr.*, esa.*, us.name_complete, us.email FROM encuesta_siniestro_resueltas esr INNER JOIN encuesta_siniestro_respuestas esa ON esa.idResuelta = esr.id INNER JOIN users us ON us.idPersona = esr.responsable WHERE esr.id = '.$id)->result();
      return $query;
    }

    function getResponseBySurvey($sql) {
      $query = $this->db->query('SELECT esr.*, us.name_complete, us.email FROM encuesta_siniestro_resueltas esr INNER JOIN users us ON us.idPersona = esr.responsable '.$sql)->result();
      return $query;
    }

    function getResponseSurveyBySiniestro($sql) { //Eliminar
      $query = $this->db->query('SELECT esr.*, sr.asegurado_nombre FROM encuesta_siniestro_resueltas esr INNER JOIN siniestro_reportes sr ON sr.poliza = esr.poliza AND sr.siniestro_id = esr.siniestro '.$sql)->result();
      return $query;
    }

    function getInformationResponseSurvey($sql) {
      $query = $this->db->query('SELECT esr.*, es.titulo AS encuesta, sr.asegurado_nombre, sr.siniestro_estatus, us.name_complete AS responsable_nombre, sr.id_sicas_vendedor, us.email FROM encuesta_siniestro_resueltas esr INNER JOIN encuesta_siniestro es ON es.idEncuesta = esr.idEncuesta INNER JOIN users us ON us.idPersona = esr.responsable INNER JOIN siniestro_reportes sr ON sr.poliza = esr.poliza AND sr.siniestro_id = esr.siniestro '.$sql)->result();
      foreach ($query as $key => $val) {
        $val->agente = $this->db->query('SELECT name_complete FROM users WHERE IDVend = '.$val->id_sicas_vendedor)->row()->name_complete;
        $val->documento = $this->db->query("SELECT * FROM documentos_siniestros WHERE siniestro = '".$val->siniestro."' AND poliza = '".$val->poliza."'")->result();
        //$question = $this->db->query('SELECT * FROM encuesta_siniestro_preguntas WHERE idEncuesta = '.$val->idEncuesta)->result();
        $response = $this->db->query('SELECT sr.*, sp.idPregunta, sp.pregunta, sp.tipo FROM encuesta_siniestro_respuestas sr INNER JOIN encuesta_siniestro_preguntas sp ON sp.idPregunta = sr.idPregunta WHERE sr.idResuelta = '.$val->id.' ORDER BY sr.idRespuesta ASC')->result();
        /*foreach ($question as $row) {
          $options = ($row->tipo == 1) ? $this->getQuestionOptions($row->idPregunta) : "";
          $row->opciones = $options; 
        }*/
        foreach ($response as $row) {
          $options = ($row->tipo == 1) ? $this->db->query('SELECT titulo FROM encuesta_siniestro_opciones WHERE idOpcion = '.$row->respuesta.' AND idPregunta = '.$row->idPregunta)->row()->titulo : "";
          $row->opcion = $options;
        }
        //$val->preguntas = $question;
        $val->respuestas = $response;
      }
      return $query;
    }

    function getInformationCompleteSurvey($info = NULL) {
      $data = array();
      $query = $this->db->query('SELECT * FROM encuesta_siniestro WHERE activa = 0 '.$info['sql_e'])->result();
      foreach ($query as $key => $value) {
        $sql_a = 'WHERE esr.idEncuesta = '.$value->idEncuesta.' '.(isset($info['sql_a']) ? $info['sql_a'] : "");
        $sql_r = 'WHERE esr.idEncuesta = '.$value->idEncuesta.' '.(isset($info['sql_r']) ? $info['sql_r'] : "");
        $questions = $this->getQuestionSurvey($value->idEncuesta);
        $response = $this->getInformationResponseSurvey($sql_a);
        $result = $this->getInformationResponseSurvey($sql_r);
        $documents = $this->db->query('SELECT * FROM documentos_siniestros '.$info['sql_d'])->result();
        $value->preguntas = $questions;
        $value->resueltas = $response;
        $value->generadas = $result;
        $value->documentos = $documents;
      }
      return $query;
    }
  //-------------------------------------------------------------------------------------------------------
}