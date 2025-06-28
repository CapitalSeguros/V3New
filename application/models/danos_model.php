<?php
class danos_model extends CI_Model{

    public function __Construct(){
		parent::__Construct();
	}

	function addDanos($datos){
		$this->db->insert('siniestro_gmm', $datos);
        $insert_id = $this->db->insert_id();
        return $insert_id;
	}

	function updateDanos($id,$data){
		$this->db->set($data);
        $this->db->where('id_siniestro', $id);
        return $this->db->update('siniestro_gmm');
	}

	function insertSiniestro($data)
    {
        $this->db->insert('siniestro_reportes', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
	}
	
	function updateSiniestro($id,$data){
        $this->db->where('id', $id);
        $res = $this->db->update('siniestro_reportes', $data);
        return $res;
    }
//update
	function getAllDanos($id_estatus,$year,$month=null,$agente=null){
		$obj=array();	
		$this->db
		->select("sr.*,tcg.id C_id, tcg.nombre C_nombre, setr.nombre estatus,setr.id id_est_tra,setr.orden orden_tram, indicador.dias,TIMESTAMPDIFF(DAY, tramite.fecha_inicio, CURDATE()) progreso_t,TIMESTAMPDIFF(DAY, sr.inicio_ajuste, CURDATE()) progreso,tramite.tipo_tramite,stg.nombre nombre_tramite,tramite.id id_tramite, setr.color, tramite.folio_cia,tramite.fecha_fin fec_tram_F,tramite.fecha_inicio, concat(sr.siniestro_id, ' ') id_siniestro_2,stg.order order_tipo_t,
		(select s.fecha_inicio from siniestro_tramite s where s.id_siniestro=sr.id order by s.id DESC limit 1) f_lasttram, setr.id tram_estatus",false)
		->where( "sr.tipo_r", 'D')
		->join("siniestro_tramite tramite", "sr.id=tramite.id_siniestro and tramite.id=(select max(tre.id) from siniestro_tramite tre where tre.id_siniestro=sr.id)", "left")
		->join("tipo_coberturas_gmm tcg", "tramite.cobertura_id=tcg.id", "left")
		->join("siniestro_tramite_danos stg", "tramite.tipo_tramite=stg.id", "left")
		->join("(select * from indicadores i where cliente_id=0 and sub_tipo_id=1) as indicador", "sr.id_tipo_d=indicador.causa_id", "left")
		->join("siniestro_estatus_tramites setr", "tramite.estatus=setr.id", "left");
		if($year!='0'){
			$this->db->where("year(sr.inicio_ajuste)", $year);
		}
		if($id_estatus!='0'){
			$this->db->where("setr.id", $id_estatus);
		}
		if($month!=null){
			$this->db->where("month(sr.inicio_ajuste)", $month);
		}
		if($agente>0){
			$this->db->where("sr.id_sicas_vendedor", $agente);
		}
		$this->db->group_by('sr.id');
		
		
		$obj=$this->db->get('siniestro_reportes sr');
		return $obj->result_array();
	}
	

	function getResgistroDanos($id){
		if($id!=null){
			$sql="Select sr.*,sg.*,tcg.* from siniestro_reportes sr,siniestro_gmm sg, tipo_coberturas_gmm tcg
			where sr.id=".$id." and sg.id_siniestro=sr.id and tcg.id=cobertura_id;";
			$data=$this->db->query($sql);
			return $data->result_array();
		}else{
			return [];
		}
    }
    
	function getCoberturasDanos(){
		$tipos = $this->db->where('Tipo','DAÑOS')
		->get('tipo_coberturas_gmm');
        return $tipos->result_array();
	}

	function getEstados(){
		$tipos = $this->db->get('catalog_estados');
        return $tipos->result_array();
	}

	function insertTramite($data)
    {
        $this->db->insert('siniestro_tramite', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
	}

	function updateTramite($id,$data){
		$this->db->set($data);
		$this->db->where('id', $id);
        return $this->db->update('siniestro_tramite');
	}

	function getTramites($id){
		/* $tipos = $this->db->where('id_siniestro',$id)
		->order_by('tipo_tramite','DESC')
		->get('siniestro_tramite'); */
		$sql="select st.*, indicador.dias, TIMESTAMPDIFF(DAY, st.fecha_inicio, CURDATE()+1) progreso,sett.nombre,std.url ,std.nombre tram_nom
		from siniestro_tramite st 
		left join (select * from indicadores i where cliente_id=0) as indicador on st.tipo_tramite=indicador.causa_id
		left join siniestro_estatus_tramites sett on st.estatus=sett.id
		left join siniestro_tramite_danos std on st.tipo_tramite=std.id
		where id_siniestro=".$id." group by st.id order by st.id DESC;";
		$data=$this->db->query($sql);
        return $data->result_array();
	}

	function getSiniestroPoliza($id){
		/* $sql="Select sr.*,sp.* from siniestro_reportes sr
		left join siniestro_poliza sp on  sr.poliza=sp.poliza where sr.id=".$id; */
		$sql="Select sr.id idregistro,sr.*,sp.*,tcg.*,u.name_complete, ce.estado, tcg.nombre tipoC,tcg.id tipoC_id
		from siniestro_reportes sr
		left join siniestro_poliza sp on  sr.poliza=sp.poliza
		left join users u on sr.agregado_por=u.idPersona
		left join tipo_coberturas_gmm tcg on sr.id_tipo_d=tcg.id
		left join catalog_estados ce on sr.estado_id=ce.clave
		where sr.id=".$id. " group by sr.id";
		$data=$this->db->query($sql);
		return $data->result_array();
	}

	function getStatus(){
		/* $tipos = $this->db->order_by('orden','ASC')->get('siniestro_estatus_tramites'); */
		$sql="SELECT st.*, (select nombre from siniestro_estatus_tramites st2 where st2.id=st.depende  ) nom_dep FROM siniestro_estatus_tramites st where activo='1' order by st.orden ASC";
		$data=$this->db->query($sql);
        return $data->result_array();
	}

	function getDocuments(){
		$sql="select std.*,stip.nombre documento_nom from siniestro_tramite_documento std
		inner join siniestro_tipo_documento stip on std.id_tipo_documento=stip.id
		where std.modulo=1";
		$data=$this->db->query($sql);
		return $data->result_array();
	}
//update
	function getTramitesDanos(){
		$tipos = $this->db->select('s.id, s.nombre,s.order')->where('s.delete',NULL)->order_by("s.order","ASC")->get('siniestro_tramite_danos s');
        return $tipos->result_array();
	}

	function addSeguimiento($data)
    {
        $this->db->insert('seguimiento', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
	}

	function getSeguimiento($id){
		/* $sql="select s.comentario,s.fecha fecha_add,setr.nombre,u.name_complete,setr.color  from seguimiento s
		left join siniestro_estatus_tramites setr on s.estatus_id=setr.id
		left join users u on s.usuario_id=u.idPersona
		left join siniestro_tramite st on st.id=s.tramite_id
		left join siniestro_tramite_gmm std on st.tipo_tramite=std.id
		where s.tramite_id=".$id." and s.referencia='DANOS' order by s.id DESC;"; */
		$sql="select s.comentario,s.fecha_alta ,setr.nombre,u.name_complete,setr.color, std.nombre tram_nom
		from seguimiento s
		left join siniestro_estatus_tramites setr on s.estatus_id=setr.id
		left join users u on s.usuario_id=u.idPersona
		left join siniestro_tramite st on st.id=s.tramite_id
		left join siniestro_tramite_danos std on st.tipo_tramite=std.id
		where s.tramite_id=".$id." and s.referencia='DANOS' order by s.id DESC;";
		$data=$this->db->query($sql);
		return $data->result_array();
	}

	function insert_poliza($data){
		$this->db->insert('siniestro_poliza', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
	}

	function existPoliza($id){
		$tipos = $this->db->where('poliza',$id)
		->get('siniestro_poliza');
		$res=empty($tipos->result_array())?false:true;
        return $res;
	}

	function getSeguimientogeneral($id){
		$sql="select s.comentario,s.fecha_alta,setr.nombre,u.name_complete,setr.color, std.nombre tram_nom
		from seguimiento s
		left join siniestro_estatus_tramites setr on s.estatus_id=setr.id
		left join users u on s.usuario_id=u.idPersona
		left join siniestro_tramite st on st.id=s.tramite_id
		left join siniestro_tramite_danos std on st.tipo_tramite=std.id
		where s.referencia_id=".$id." and s.referencia='DANOS' order by s.id DESC;";
		$data=$this->db->query($sql);
		return $data->result_array();
	}

	function getYearsDocs(){
		$sql="select year(sr.inicio_ajuste) opcion from siniestro_reportes sr where sr.tipo_r='D'
		group by year(sr.inicio_ajuste);";
		$data=$this->db->query($sql);
		return $data->result_array();
	}

	function ExistSiniestro($id,$poliza){
		$tipos = $this->db->where('siniestro_id', $id)->where('poliza', $poliza)->where('tipo_r', 'D')->get('siniestro_reportes');
		return empty($tipos->result_array())?true:false;
	}

////nuevos
	function getAllDanos2($id_estatus,$year,$month=null){
		$obj=array();	
		$this->db
		->select("sr.*,tcg.id C_id, tcg.nombre C_nombre, setr.nombre estatus,setr.id id_est_tra,setr.orden orden_tram, indicador.dias,TIMESTAMPDIFF(DAY, tramite.fecha_inicio, CURDATE()) progreso_t,TIMESTAMPDIFF(DAY, sr.inicio_ajuste, CURDATE()) progreso,tramite.tipo_tramite,stg.nombre nombre_tramite,tramite.id id_tramite, setr.color, tramite.folio_cia,tramite.fecha_fin fec_tram_F,tramite.fecha_inicio")
		->where( "sr.tipo_r", 'D')
		->join("siniestro_tramite tramite", "sr.id=tramite.id_siniestro and tramite.id=(select max(tre.id) from siniestro_tramite tre where tre.id_siniestro=sr.id)", "left")
		->join("tipo_coberturas_gmm tcg", "tramite.cobertura_id=tcg.id", "left")
		->join("siniestro_tramite_danos stg", "tramite.tipo_tramite=stg.id", "left")
		->join("(select * from indicadores i where cliente_id=0 and sub_tipo_id=1) as indicador", "sr.id_tipo_d=indicador.causa_id", "left")
		->join("siniestro_estatus_tramites setr", "tramite.estatus=setr.id", "left");
		if($year!='0'){
			$this->db->where("year(sr.inicio_ajuste)", $year);
		}
		if($id_estatus!='0'){
			$this->db->where("sr.status_id", $id_estatus);
		}
		if($month!=null){
			$this->db->where("month(sr.inicio_ajuste)", $month);
		}
		$this->db->group_by('sr.id');
		
		
		$obj=$this->db->get('siniestro_reportes sr');
		return $obj->result_array();
	}

	function getAllDanosTablaRangos($id_estatus,$year,$month=null,$rango1=null,$rango2=null){
		$obj=array();	
		$this->db
		->select("sr.*,tcg.id C_id, tcg.nombre C_nombre, setr.nombre estatus,setr.id id_est_tra,setr.orden orden_tram, indicador.dias,TIMESTAMPDIFF(DAY, tramite.fecha_inicio, CURDATE()) progreso_t,TIMESTAMPDIFF(DAY, sr.inicio_ajuste, CURDATE()) progreso,tramite.tipo_tramite,stg.nombre nombre_tramite,tramite.id id_tramite, setr.color, tramite.folio_cia,tramite.fecha_fin fec_tram_F,tramite.fecha_inicio")
		->where( "sr.tipo_r", 'D')
		->join("siniestro_tramite tramite", "sr.id=tramite.id_siniestro and tramite.id=(select max(tre.id) from siniestro_tramite tre where tre.id_siniestro=sr.id)", "left")
		->join("tipo_coberturas_gmm tcg", "tramite.cobertura_id=tcg.id", "left")
		->join("siniestro_tramite_danos stg", "tramite.tipo_tramite=stg.id", "left")
		->join("(select * from indicadores i where cliente_id=0 and sub_tipo_id=1) as indicador", "sr.id_tipo_d=indicador.causa_id", "left")
		->join("siniestro_estatus_tramites setr", "tramite.estatus=setr.id", "left");
		if($year!='0'){
			$this->db->where("year(sr.inicio_ajuste)", $year);
		}
		if($id_estatus!='0'){
			$this->db->where("sr.status_id", $id_estatus);
		}
		if($month!=null){
			$this->db->where("month(sr.inicio_ajuste)", $month);
		}
		if($rango1!=null){
			$this->db->where("TIMESTAMPDIFF(DAY, sr.inicio_ajuste, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))>=", $rango1);
		}
		if($rango2!=null){
			$this->db->where("TIMESTAMPDIFF(DAY, sr.inicio_ajuste, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))<=", $rango2);
		}
		$this->db->group_by('sr.id');
		
		
		$obj=$this->db->get('siniestro_reportes sr');
		return $obj->result_array();
	}
	function DataExcelDanos($id_estatus,$year,$month=null,$rango1=null,$rango2=null){
		$obj=array();	
		$this->db
		->select("sr.siniestro_id siniestro, sr.asegurado_nombre, sr.poliza, sr.certificado, sr.inicio_ajuste fecha_inicio, sr.siniestro_estatus, stg.nombre ultimo_tramite,sr.complemento_json")
		->where( "sr.tipo_r", 'D')
		->join("siniestro_tramite tramite", "sr.id=tramite.id_siniestro and tramite.id=(select max(tre.id) from siniestro_tramite tre where tre.id_siniestro=sr.id)", "left")
		->join("tipo_coberturas_gmm tcg", "tramite.cobertura_id=tcg.id", "left")
		->join("siniestro_tramite_danos stg", "tramite.tipo_tramite=stg.id", "left")
		->join("(select * from indicadores i where cliente_id=0 and sub_tipo_id=1) as indicador", "sr.id_tipo_d=indicador.causa_id", "left")
		->join("siniestro_estatus_tramites setr", "tramite.estatus=setr.id", "left");
		if($year!='0'){
			$this->db->where("year(sr.inicio_ajuste)", $year);
		}
		if($id_estatus!='0'){
			$this->db->where("sr.status_id", $id_estatus);
		}
		if($month!=null){
			$this->db->where("month(sr.inicio_ajuste)", $month);
		}
		if($rango1!=null){
			$this->db->where("TIMESTAMPDIFF(DAY, sr.inicio_ajuste, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))>=", $rango1);
		}
		if($rango2!=null){
			$this->db->where("TIMESTAMPDIFF(DAY, sr.inicio_ajuste, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))<=", $rango2);
		}
		$this->db->group_by('sr.id');
		
		
		$obj=$this->db->get('siniestro_reportes sr');
		return $obj->result_array();
	}

	///nuevos para el orden de los daños
	function getmax($id=null){
		$val=0;
		$this->db->select("max(s.order) orden");
		$this->db->where('s.delete',NULL);
		if($id){
			$this->db->where("s.id", $id);
		}
		$obj=$this->db->get("siniestro_tramite_danos s");
		$value=$obj->result_array();
		if(!empty($value)){
			//var_dump($value[0]["orden"]);
			$val=$value[0]["orden"];
		}
		return $val;
	}

	function getIdTipotramite($order){
		$this->db->where("s.order",$order);
		//$this->db->where("s.order",null);
		$obj=$this->db->get("siniestro_tramite_danos s");
		$val=$obj->result_array();
		return $val[0]["id"];
	}

	function testpruebaids(){
		$this->db->where_in("sr.tipo_r",array("A","G","D"));
		$this->db->join("siniestro_poliza p","sr.poliza=p.poliza", "inner");
		$obj=$this->db->get("siniestro_reportes sr");
		return $obj->result_array();
	}
	function insertLogDormido($data){
        $this->db->insert('siniestros_tramite_logs', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

	function updateTramitelog($idtramite,$data){
        $this->db->set($data);
        $this->db->where('id_registro', $idtramite);
        $this->db->where('estatus',6);
        return $this->db->update('siniestros_tramite_logs');
    }
	
	function getAllDocumentTramites($id){
		$sql="select * from documentos d where d.referencia_id=".$id;
		$data=$this->db->query($sql);
		return $data->result_array();
	}
	
    function getAseguradoras($tipo){
        $this->db->select('cat.Promotoria nombre,cat.idPromotoria id');
        $this->db->where('sr.tipo_r',$tipo);
        $this->db->join('siniestro_reportes sr','cat.idPromotoria=sr.aseguradora_id','left')
        ->group_by('cat.idPromotoria')->order_by('cat.Promotoria','ASC');
        $obj=$this->db->get('catalog_promotorias cat');
        return $obj->result_array();
       
    }

	function gettramitesDocs($id){
		$this->db->select('s.*,sd.nombre');
        $this->db->where('s.id_siniestro',$id);
        $this->db->join('siniestro_tramite_danos sd','s.tipo_tramite=sd.id','left')
        ->order_by('s.id','DESC');
        $obj=$this->db->get('siniestro_tramite s');
        return $obj->result_array();
	}

	function delete_doc_drive($id){
		$this->db->where('file_id', $id);
		$this->db->delete('documentos');
	}

	//----------------------------- //Dennis Castillo [2022-01-18]
	function insertRecordSafely($table, $data){

		$response["lastId"] = 0;
		$response["bool"] = false;

		$this->db->trans_begin();
		$this->db->insert($table, $data);
		$response["lastId"] = $this->db->insert_id();

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
		} else{
			$this->db->trans_commit();
			$response["bool"] = true;
		}

		return $response;
	}
	//----------------------------- //Dennis Castillo [2022-01-18]
	function insertMultipleRecordSafely($table, $data){

		//$response["lastId"] = 0;
		$response["bool"] = false;

		$this->db->trans_begin();
		$this->db->insert_batch($table, $data);
		//$response["lastId"] = $this->db->insert_id();

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
		} else{
			$this->db->trans_commit();
			$response["bool"] = true;
		}

		return $response;
	}
	//----------------------------- //Dennis Castillo [2022-01-18]
	function updateRecordSafely($table, $condition, $data){

		$response["bool"] = false;
		$this->db->trans_begin();
		$this->db->update($table, $data, $condition);

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
		} else{
			$this->db->trans_commit();
			$response["bool"] = true;
		}

		return $response;
	}
	//----------------------------- //Dennis Castillo [2022-01-18]
	function getNotes($id){

		$query = $this->db->where("idSinister", $id)
							->get("sininisterNotes");
		return $query->num_rows() > 0 ? $query->result() : array();
	}
	//----------------------------- //Dennis Castillo [2022-01-18]
	function getAllDataNote($id = null){
		$this->db->select("a.id, f.nombre tipo_siniestro_nombre,  e.email,  note, dateCreate, idSinister, dateCreate, creator, b.idPersona, nombres, apellidoPaterno, apellidoMaterno, poliza, siniestro_id, asegurado_nombre, tipo_r")
			->join("sinisterNotesAssigned b", "b.idNote = a.id", "inner")
			->join("persona c", "c.idPersona = b.idPersona", "left")
			->join("siniestro_reportes d", "d.id = a.idSinister", "inner")
			->join("users e", "c.idPersona = e.idPersona", "left")
			->join("siniestro_tipo f", "d.tipo_siniestro_id = f.id", "left");
			
			if(!empty($id)){
				$this->db->where("a.idSinister", $id);
			}
		$query = $this->db->order_by("dateCreate", "desc")->get("sininisterNotes a");

		return $query->num_rows() > 0 ? $query->result() : array();
	}
	//----------------------------- //Dennis Castillo [2022-01-18]
	function deleteNoteSafely($table, $where){

		$response = false;
		$this->db->trans_begin();
		$this->db->where($where);
		$this->db->delete($table);
		
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
		} else{
			$this->db->trans_commit();
			$response = true;
		}

		return $response;
	}
	//--------------------------- //Dennis Castillo [2022-01-18]
	function getAssigned($id){

		$query = $this->db->where("idNote", $id)
				->get("sinisterNotesAssigned");

		return $query->num_rows() > 0 ? $query->result() : array();
	}
	//--------------------------- //Dennis Castillo [2022-01-18]
	function getNote($id){

		$query = $this->db->where("id", $id)
				->get("sininisterNotes");

		return $query->num_rows() > 0 ? $query->row() : array();
	}
	//---------------------------
}