<?php
class gmm_model extends CI_Model{

    public function __Construct(){
		parent::__Construct();
	}

	function addGMM($datos){
		$this->db->insert('siniestro_gmm', $datos);
        $insert_id = $this->db->insert_id();
        return $insert_id;
	}

	function updateGMM($id,$data){
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

	function insertTramite($data)
    {
		$insert_id=0;
		$this->db->trans_start();
		$this->db->trans_strict(FALSE);
        $this->db->insert('siniestro_tramite', $data);
		$insert_id = $this->db->insert_id();
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$insert_id=0;
		} 
		else {
			$this->db->trans_commit();
			//$insert_id = $this->db->insert_id();
		}
		
        return $insert_id;
	}
	
	function updateSiniestro($id,$data){
		$res='';
		$this->db->trans_start();
		$this->db->trans_strict(FALSE);
        $this->db->where('id', $id);
        $res = $this->db->update('siniestro_reportes', $data);
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return $res='Error';
		} 
		else {
			$this->db->trans_commit();
			return $res;
		}
        //return $res;
    }

	function getAllGMM($id_estatus,$year,$agente=null){ //Modificado [Suemy][2024-09-06]
		/* $sql="select sr.*,tcg.id C_id, tcg.nombre C_nombre, setr.nombre estatus,setr.id id_est_tra,setr.orden orden_tram, indicador.dias,TIMESTAMPDIFF(DAY, tramite.fecha_inicio, CURDATE()) progreso,tramite.tipo_tramite,stg.nombre nombre_tramite,tramite.id id_tramite, setr.color, tramite.fecha_inicio,tramite.valores,tramite.descripcion tram_des,tramite.cobertura_afectada, tramite.cobertura_id,tramite.fecha_inicio fec_tram,tramite.folio_cia,tramite.fecha_fin fec_tram_F
		from siniestro_reportes sr 
		left join siniestro_tramite tramite on sr.id=tramite.id_siniestro and tramite.id=(select max(tre.id) from siniestro_tramite tre where tre.id_siniestro=sr.id)
		left join tipo_coberturas_gmm tcg on tramite.cobertura_id=tcg.id
		left join siniestro_tramite_gmm stg on tramite.tipo_tramite=stg.id
		left join (select * from indicadores i where cliente_id=0) as indicador on tramite.tipo_tramite=indicador.causa_id
		left join siniestro_estatus_tramites setr on tramite.estatus=setr.id
		where sr.tipo_r='G' group by sr.id;";
		$data=$this->db->query($sql);
		return $data->result_array(); */
		$obj=array();	
		$this->db
		->select("sr.*,tcg.id C_id, tcg.nombre C_nombre, setr.nombre estatus,setr.id id_est_tra,setr.orden orden_tram, indicador.dias,TIMESTAMPDIFF(DAY, tramite.fecha_inicio, CURDATE()) progreso,tramite.tipo_tramite,stg.nombre nombre_tramite,tramite.id id_tramite, setr.color, tramite.fecha_inicio,tramite.valores,tramite.descripcion tram_des,tramite.cobertura_afectada, tramite.cobertura_id,tramite.fecha_inicio fec_tram,tramite.folio_cia,tramite.fecha_fin fec_tram_F,
		,if(tramite.fecha_inicio IS NULL, sr.inicio_ajuste,tramite.fecha_inicio) fecha_filtro",false)
		->where( "sr.tipo_r", 'G')
		->join("siniestro_tramite tramite", "sr.id=tramite.id_siniestro and tramite.id=(select max(tre.id) from siniestro_tramite tre where tre.id_siniestro=sr.id)", "left")
		->join("tipo_coberturas_gmm tcg", "tramite.cobertura_id=tcg.id", "left")
		->join("siniestro_tramite_gmm stg", "tramite.tipo_tramite=stg.id", "left")
		->join("(select * from indicadores i where cliente_id=0 and i.sub_tipo_id=3) as indicador", "tramite.tipo_tramite=indicador.causa_id", "left")
		->join("siniestro_estatus_tramites setr", "tramite.estatus=setr.id", "left");
		if($year!='0'){
			$this->db->where("year(sr.inicio_ajuste)", $year);
		}
		if($id_estatus!='0'){
			$this->db->where("tramite.estatus", $id_estatus);
		}
		if($agente>0){
			$this->db->where("sr.id_sicas_vendedor", $agente);
		}
		$this->db->group_by('sr.id');
		
		$obj=$this->db->get('siniestro_reportes sr')->result();
		foreach ($obj as $key => $val) {
			$add['evidencia'] = $this->db->query("select * from documentos_siniestros where ramo = 'gmm' and siniestro = '".$val->siniestro_id."' and poliza = '".$val->poliza."'")->result();
			$add['estatus'] = $this->db->query("select * from encuesta_siniestro_resueltas where siniestro = '".$val->siniestro_id."' and poliza = '".$val->poliza."' and contestado = 1")->result();
			$val->encuesta = $add;
		}
		return $obj;
		//return $obj->result_array();
	}

	function getAllTramitesTable($id_estatus,$year,$month=null){
		$obj=array();	
		$this->db
		->select("sr.*,tcg.id C_id, tcg.nombre C_nombre, setr.nombre estatus,setr.id id_est_tra,setr.orden orden_tram, indicador.dias,TIMESTAMPDIFF(DAY, tramite.fecha_inicio, CURDATE()) progreso,tramite.tipo_tramite,stg.nombre nombre_tramite,tramite.id id_tramite, setr.color, tramite.fecha_inicio,tramite.valores,tramite.descripcion tram_des,tramite.cobertura_afectada, tramite.cobertura_id,tramite.fecha_inicio fec_tram,tramite.folio_cia,tramite.fecha_fin fec_tram_F")
		->where( "sr.tipo_r", 'G')
		->join("siniestro_reportes sr", "tramite.id_siniestro=sr.id", "left")
		->join("tipo_coberturas_gmm tcg", "tramite.cobertura_id=tcg.id", "left")
		->join("siniestro_tramite_gmm stg", "tramite.tipo_tramite=stg.id", "left")
		->join("(select * from indicadores i where cliente_id=0 and i.sub_tipo_id=3) as indicador", "tramite.tipo_tramite=indicador.causa_id", "left")
		->join("siniestro_estatus_tramites setr", "tramite.estatus=setr.id", "left");
		if($year!='0'){
			$this->db->where("year(tramite.fecha_inicio)", $year);
		}
		if($month!=null){
			$this->db->where("month(tramite.fecha_inicio)", $month);
		}
		if($id_estatus!='0'){
			$this->db->where("tramite.estatus", $id_estatus);
		}
		//$this->db->group_by('sr.id');
		
		//$obj=$this->db->get('siniestro_reportes sr');
		$obj=$this->db->get('siniestro_tramite tramite');
		return $obj->result_array();
	}

	function getAllCoberturas(){
		$tipos = $this->db->where('Tipo','GMM')->get('tipo_coberturas_gmm');
        return $tipos->result_array();
	}
	function getResgistroGMM($id){
		/* $tipos = $this->db->where('id',$id)
		->get('siniestro_reportes'); */
		if($id!=null){
			$sql="Select sr.*,sg.*,tcg.* from siniestro_reportes sr,siniestro_gmm sg, tipo_coberturas_gmm tcg
			where sr.id=".$id." and sg.id_siniestro=sr.id and tcg.id=cobertura_id;";
			$data=$this->db->query($sql);
			return $data->result_array();
		}else{
			return [];
		}
	}

	function insertCobertura($datos){
		$this->db->insert('tipo_coberturas_gmm', $datos);
        $insert_id = $this->db->insert_id();
        return $insert_id;
	}

	function updateCobertura($id,$data){
		$this->db->set($data);
        $this->db->where('id', $id);
		return $this->db->update('tipo_coberturas_gmm');
		
	}

	function ExisCobertura($nombre,$tipo,$tabla){
		$tipos = $this->db->where('nombre', $nombre)->where('Tipo', $tipo)->get($tabla);
		return empty($tipos->result_array())?true:false;
		//return $tipos->result_array();
	  }
	function ExistName($nombre,$tabla){
		$tipos = $this->db->where('nombre', $nombre)->get($tabla);
		return empty($tipos->result_array())?true:false;
		//return $tipos->result_array();
	}

	function deleteCobertura($id){
		if (!$this->db->delete('tipo_coberturas_gmm', array('id' => $id))) {
            return false;
        }
        return true;
	}

	function getCoberturasGMM(){
		$tipos = $this->db->where('Tipo','GMM')
		->get('tipo_coberturas_gmm');
        return $tipos->result_array();
	}

	function getEstados(){
		$tipos = $this->db->get('catalog_estados');
        return $tipos->result_array();
	}

	function getEstatus(){
		$this->db->where('activo','1');
		$tipos = $this->db->get('siniestro_estatus_tramites');
        return $tipos->result_array();
	}

	function getTramites($id){
		/* $tipos = $this->db->where('id_siniestro',$id)
		->order_by('tipo_tramite','DESC')
		->get('siniestro_tramite');
		return $tipos->result_array(); */
		$sql="select st.*, indicador.dias, TIMESTAMPDIFF(DAY, st.fecha_inicio, CURDATE()) progreso,sett.nombre,sett.color,stg.nombre tram_nom,tcg.nombre cobertura_nombre
		from siniestro_tramite st 
		left join (select * from indicadores i where cliente_id=0) as indicador on st.tipo_tramite=indicador.causa_id
		left join siniestro_estatus_tramites sett on st.estatus=sett.id
		left join siniestro_tramite_gmm stg on st.tipo_tramite=stg.id
		left join tipo_coberturas_gmm tcg on st.cobertura_id=tcg.id
		where id_siniestro=".$id ."  group BY st.id order by st.id DESC";
		$data=$this->db->query($sql);
        return $data->result_array();
	}

	function getTipostramites(){
		$tipos = $this->db->get('siniestro_tramite_gmm');
        return $tipos->result_array();
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

	function insert_Complemento($data){
		$this->db->insert('siniestro_g_d', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
	}

	function getSiniestroPoliza($id){
		$sql="Select sr.*,sp.*, ce.estado from siniestro_reportes sr
		left join siniestro_poliza sp on  sr.poliza=sp.poliza 
		left join catalog_estados ce on sr.estado_id=ce.clave
		where sr.id=".$id;
		$data=$this->db->query($sql);
		return $data->result_array();
	}

	function getStatus(){
		/* $tipos = $this->db->order_by('orden','ASC')->get('siniestro_estatus_tramites'); */
		$sql="SELECT st.*, (select nombre from siniestro_estatus_tramites st2 where st2.id=st.depende  ) nom_dep FROM siniestro_estatus_tramites st where activo='1' order by st.orden ASC";
		$data=$this->db->query($sql);
        return $data->result_array();
	}

	function saveEstatus($data){
		$this->db->insert('siniestro_estatus_tramites', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
	}

	function getResgistroOrden($orden){
		$this->db->where('activo','1');
		$data=$this->db->where('orden',$orden)->get('siniestro_estatus_tramites');
		return $data->result_array();
	}

	function updateStatus($data,$id){
		$this->db->set($data);
        $this->db->where('id', $id);
		return $this->db->update('siniestro_estatus_tramites');
		
	}

	function getlastorden(){
		$sql="SELECT orden FROM siniestro_estatus_tramites where activo='1' ORDER BY orden DESC LIMIT 1;";
		$data=$this->db->query($sql);
		$res=$data->result_array();
		$r=isset($res[0]['orden'])?$res[0]['orden']+1:1;
		return $r;
		/* return $data->result_array(); */
	}

	function getAllorderDelete($orden){
		$sql="select * from siniestro_estatus_tramites where activo='1' and orden>".$orden;
		$data=$this->db->query($sql);
		return $data->result_array();
	}

	function deleteEstatus($id){
		if (!$this->db->delete('siniestro_estatus_tramites', array('id' => $id))) {
            return false;
        }
        return true;
	}

	function updateTramite($id,$data){
		$this->db->set($data);
		$this->db->where('id', $id);
        return $this->db->update('siniestro_tramite');
	}

	function getDocuments(){
		$sql="select std.*,stip.nombre documento_nom from siniestro_tramite_documento std
		inner join siniestro_tipo_documento stip on std.id_tipo_documento=stip.id
		where std.modulo=3";
		$data=$this->db->query($sql);
		return $data->result_array();
	}

	function getAllDocumentTramites($id){
		$sql="select * from documentos d where d.referencia_id=".$id;
		$data=$this->db->query($sql);
		return $data->result_array();
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
		where s.referencia_id=".$id." and s.referencia='GMM';"; */
		$sql="select s.comentario,s.fecha fecha_add,u.name_complete,setr.color,
		case 
			when s.causa_id is not null then (select st.nombre from sininestro_causa_cerrar st where st.id=s.causa_id)
			when s.causa_id is null then (setr.nombre)
			else 'NADA'
		end nombre
		  from seguimiento s
				left join siniestro_estatus_tramites setr on s.estatus_id=setr.id
				left join users u on s.usuario_id=u.idPersona
				left join siniestro_tramite st on st.id=s.tramite_id
				left join siniestro_tramite_gmm std on st.tipo_tramite=std.id
				where s.referencia_id=".$id." and s.referencia='GMM' order by s.id desc;";
		$data=$this->db->query($sql);
		return $data->result_array();
	}

	function getSeguimientoT($id){
		$sql="select s.comentario,s.fecha_alta,u.name_complete,setr.color,std.nombre tram_n,
		case 
			when s.causa_id is not null then (select st.nombre from sininestro_causa_cerrar st where st.id=s.causa_id)
			when s.causa_id is null then (setr.nombre)
			else 'NADA'
		end nombre
		  from seguimiento s
				left join siniestro_estatus_tramites setr on s.estatus_id=setr.id
				left join users u on s.usuario_id=u.idPersona
				left join siniestro_tramite st on st.id=s.tramite_id
				left join siniestro_tramite_gmm std on st.tipo_tramite=std.id
				where s.referencia_id=".$id." and s.referencia='GMM_T' order by s.id desc;";
		$data=$this->db->query($sql);
		return $data->result_array();
	}

	function getCausaCierre(){
		$tipos = $this->db->get('sininestro_causa_cerrar');
        return $tipos->result_array();
	}

	function getParentescos(){
		$tipos = $this->db->get('siniestro_parentesco');
        return $tipos->result_array();
	}

	function getSeguimientogeneral($id){
		$sql="select s.*,std.nombre,setr.color,u.name_complete,setr.nombre estatus_n
		from seguimiento s
		left join siniestro_tramite st on st.id=s.referencia_id
		left join siniestro_reportes sr on st.id_siniestro=sr.id
		left join siniestro_tramite_gmm std on st.tipo_tramite=std.id
		left join siniestro_estatus_tramites setr on s.estatus_id=setr.id
		left join users u on s.usuario_id=u.idPersona 
		where sr.id=".$id." and s.referencia='GMM_T' order by s.id DESC;";
		$data=$this->db->query($sql);
		return $data->result_array();
	}

	function getidSiniestroTramite($id){
		$tipos = $this->db->where('id',$id)->get('siniestro_tramite');
		$res=$tipos->result_array();
		return empty($res)?0:$res[0]['id_siniestro'];
	}

	function getYearsDocs(){
		$sql="select year(sr.inicio_ajuste) opcion from siniestro_reportes sr where sr.tipo_r='G'
		group by year(sr.inicio_ajuste);";
		$data=$this->db->query($sql);
		return $data->result_array();
	}

	function ExistSiniestro($id,$poliza){
		$tipos = $this->db->where('siniestro_id', $id)->where('poliza', $poliza)->where('tipo_r', 'G')->get('siniestro_reportes');
		return empty($tipos->result_array())?true:false;
	}

	function getCoberurasGmm(){
		$cobertura=$this->db->get('siniestro_gmm_cobertura');
		return $cobertura->result_array();
	}

	///nuevos

	function getAllTramitesTableRangos($id_estatus,$year,$month=null,$rango1=null,$rango2=null){
		$obj=array();	
		$this->db
		->select("sr.*,tcg.id C_id, tcg.nombre C_nombre, setr.nombre estatus,setr.id id_est_tra,setr.orden orden_tram, indicador.dias,TIMESTAMPDIFF(DAY, tramite.fecha_inicio, CURDATE()) progreso,tramite.tipo_tramite,stg.nombre nombre_tramite,tramite.id id_tramite, setr.color, tramite.fecha_inicio,tramite.valores,tramite.descripcion tram_des,tramite.cobertura_afectada, tramite.cobertura_id,tramite.fecha_inicio fec_tram,tramite.folio_cia,tramite.fecha_fin fec_tram_F")
		->where( "sr.tipo_r", 'G')
		->join("siniestro_reportes sr", "tramite.id_siniestro=sr.id", "left")
		->join("tipo_coberturas_gmm tcg", "tramite.cobertura_id=tcg.id", "left")
		->join("siniestro_tramite_gmm stg", "tramite.tipo_tramite=stg.id", "left")
		->join("(select * from indicadores i where cliente_id=0 and i.sub_tipo_id=3) as indicador", "tramite.tipo_tramite=indicador.causa_id", "left")
		->join("siniestro_estatus_tramites setr", "tramite.estatus=setr.id", "left");
		if($year!='0'){
			$this->db->where("year(tramite.fecha_inicio)", $year);
		}
		if($month!=null){
			$this->db->where("month(tramite.fecha_inicio)", $month);
		}
		if($id_estatus!='0'){
			$this->db->where("tramite.estatus", $id_estatus);
		}
		if($rango1!=null){
			$this->db->where("TIMESTAMPDIFF(DAY, tramite.fecha_inicio, if(tramite.fecha_fin is null,CURDATE()+1,tramite.fecha_fin))>=", $rango1);
		}
		if($rango2!=null){
			$this->db->where("TIMESTAMPDIFF(DAY, tramite.fecha_inicio, if(tramite.fecha_fin is null,CURDATE()+1,tramite.fecha_fin))<=", $rango2);
		}
		$obj=$this->db->get('siniestro_tramite tramite');
		return $obj->result_array();
	}

	function getAllTramitesExcel($id_estatus,$year,$month=null,$rango1=null,$rango2=null){
		$obj=array();	
		$this->db
		->select("sr.siniestro_id siniestro, sr.asegurado_nombre, sr.poliza,tramite.folio_cia, tcg.nombre padecimiento,sgcm.nombre cobertura,tramite.descripcion,stg.nombre nombre_tramite,sr.complemento_json,tramite.valores")
		->where( "sr.tipo_r", 'G')
		->join("siniestro_reportes sr", "tramite.id_siniestro=sr.id", "left")
		->join("tipo_coberturas_gmm tcg", "tramite.cobertura_id=tcg.id", "left")
		->join("siniestro_gmm_cobertura sgcm","tramite.cobertura_afectada=sgcm.id","left")
		->join("siniestro_tramite_gmm stg", "tramite.tipo_tramite=stg.id", "left")
		->join("(select * from indicadores i where cliente_id=0 and i.sub_tipo_id=3) as indicador", "tramite.tipo_tramite=indicador.causa_id", "left")
		->join("siniestro_estatus_tramites setr", "tramite.estatus=setr.id", "left");
		if($year!='0'){
			$this->db->where("year(tramite.fecha_inicio)", $year);
		}
		if($month!=null){
			$this->db->where("month(tramite.fecha_inicio)", $month);
		}
		if($id_estatus!='0'){
			$this->db->where("tramite.estatus", $id_estatus);
		}
		if($rango1!=null){
			$this->db->where("TIMESTAMPDIFF(DAY, tramite.fecha_inicio, if(tramite.fecha_fin is null,CURDATE()+1,tramite.fecha_fin))>=", $rango1);
		}
		if($rango2!=null){
			$this->db->where("TIMESTAMPDIFF(DAY, tramite.fecha_inicio, if(tramite.fecha_fin is null,CURDATE()+1,tramite.fecha_fin))<=", $rango2);
		}
		$obj=$this->db->get('siniestro_tramite tramite');
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
	function getAseguradoras($tipo){
        $this->db->select('cat.Promotoria nombre,cat.idPromotoria id');
        $this->db->where('sr.tipo_r',$tipo);
        $this->db->join('siniestro_reportes sr','cat.idPromotoria=sr.aseguradora_id','left')
        ->group_by('cat.idPromotoria')->order_by('cat.Promotoria','ASC');
        $obj=$this->db->get('catalog_promotorias cat');
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