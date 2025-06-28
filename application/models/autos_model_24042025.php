<?php
class autos_model extends CI_Model{

    public function __Construct(){
		parent::__Construct();
    }

    function getAllData($tabla){
		$tipos = $this->db->get($tabla);
        return $tipos->result_array();
	}
	
	function getAllDataWith($option,$tabla){
		$tipos = $this->db->where('opcion',$option)->get($tabla);
		return $tipos->result_array();
	}

    function addAutos($datos){
		$this->db->insert('siniestro_gmm', $datos);
        $insert_id = $this->db->insert_id();
        return $insert_id;
	}

	function updateAutos($id,$data){
		//$this->db->set($data);
        $this->db->where('id', $id);
		$res = $this->db->update('siniestro_reportes', $data);
        return $res;
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

	function getAllAutos($id_estatus,$year,$month=null,$agente=null){
		$obj=array();	
		$this->db
		->select("sr.*, st.nombre tipo_siniestro_nombre, sc.nombre causa_nombre,sta.nombre autoridad_nombre,indicador.dias,TIMESTAMPDIFF(DAY, sr.inicio_ajuste, CURDATE()) progreso, (SELECT soy.color from siniestro_estatus_tramites soy WHERE sr.status_id=soy.id) color,setr.nombre estatus,setr.orden, 
		tramite.id id_tramite,staa.nombre nombre_tramite, staa.id tipo_tramite, tramite.estatus tram_estatus, tramite.fecha_inicio tram_ini, setr.nombre tram_est_nom,setr.color tram_est_col, setr.valores tram_close, tramite.valores json_tram,if(tramite.fecha_inicio IS NULL, sr.inicio_ajuste,tramite.fecha_inicio) fecha_filtro,
		YEAR(sr.inicio_ajuste) ano_filtro, tramite.fecha_fin tram_fin", false)
		->where( "sr.tipo_r", 'A')
		->join("siniestro_tipo st", "sr.tipo_siniestro_id=st.id", "left")
		->join("siniestro_causa sc", "sr.causa_siniestro_id=sc.id", "left")
		->join("siniestro_tipoautoridad sta", "sr.autoridad_id=sta.id", "left")
		->join("(select * from indicadores i where cliente_id=0) as indicador", "sr.tipo_siniestro_id=indicador.causa_id", "left")
		->join("siniestro_tramite tramite", "sr.id=tramite.id_siniestro and tramite.id=(select max(tre.id) from siniestro_tramite tre where tre.id_siniestro=sr.id)", "left")
		->join("siniestro_tramite_autos staa", "tramite.tipo_tramite=staa.id", "left")
		->join("siniestro_estatus_tramites setr", "tramite.estatus=setr.id", "left");
		if($year!='0'){
			$this->db->where("year(sr.inicio_ajuste)", $year);
		}
		if($month!=null){
			$this->db->where("month(sr.inicio_ajuste)", $month);
		}
		if($id_estatus!='0'){
			//$this->db->where("sr.status_id", $id_estatus);
			$this->db->where("sr.status_id", $id_estatus);
		}
		if($agente>0){
			$this->db->where("sr.id_sicas_vendedor", $agente);
		}
		
		
		$obj=$this->db->get('siniestro_reportes sr');
		$row=[];
		$row=$obj->result_array();
		//return $obj->result_array();
		foreach ($row as $key => $value) {
            $Sestatus=json_decode($value["json_tram"],true);
            $row[$key]["Estatus_Reparacion"]= isset($Sestatus["Estatus_Reparacion"])? $Sestatus["Estatus_Reparacion"]: "N/A";
        }

		return $row;
	}

	function getResgistroAutos($id){
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
		$sql="select st.*, indicador.dias, TIMESTAMPDIFF(DAY, st.fecha_inicio, CURDATE()) progreso,sett.nombre,sett.color,stg.nombre tram_nom
		from siniestro_tramite st 
		left join (select * from indicadores i where cliente_id=0) as indicador on st.tipo_tramite=indicador.causa_id
		left join siniestro_estatus_tramites sett on st.estatus=sett.id
		left join siniestro_tramite_autos stg on st.tipo_tramite=stg.id
		left join tipo_coberturas_gmm tcg on st.cobertura_id=tcg.id
		where id_siniestro=".$id." group BY st.id order by st.id DESC";
		$data=$this->db->query($sql);
        return $data->result_array();
	}

	function getSiniestroPoliza($id){
		$sql="select sr.*,sp.*,ce.estado,st.nombre tipo_siniestro_nombre, sc.nombre causa_nombre,sta.nombre autoridad_nombre
		from siniestro_reportes sr
		left join siniestro_poliza sp on  sr.poliza=sp.poliza
		left join catalog_estados ce on sr.estado_id=ce.clave
		left join siniestro_tipo st on sr.tipo_siniestro_id=st.id
		left join siniestro_causa sc on sr.causa_siniestro_id=sc.id
		left join siniestro_tipoautoridad sta on sr.autoridad_id=sta.id
		where sr.id=".$id." group by sr.id";
		$data=$this->db->query($sql);
		return $data->result_array();
	}

	function getStatus(){
		/* $tipos = $this->db->order_by('orden','ASC')->get('siniestro_estatus_tramites'); */
		$sql="SELECT st.*, (select nombre from siniestro_estatus_tramites st2 where st2.id=st.depende  ) nom_dep FROM siniestro_estatus_tramites st where st.activo='1' order by st.orden ASC";
		$data=$this->db->query($sql);
        return $data->result_array();
	}

	function getDocuments(){
		$sql="select std.*,stip.nombre documento_nom from siniestro_tramite_documento std
		inner join siniestro_tipo_documento stip on std.id_tipo_documento=stip.id
		where std.modulo=2";
		$data=$this->db->query($sql);
		return $data->result_array();
	}

	function getTramitesDanos(){
		$tipos = $this->db->select('id, nombre')->get('siniestro_tramite_danos');
        return $tipos->result_array();
	}

	function addSeguimiento($data)
    {
        $this->db->insert('seguimiento', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
	}

	function getSeguimiento($id){
		$sql="select s.comentario,s.fecha_alta fecha_add,setr.nombre,u.name_complete,setr.color,IF(s.causa_id=0, 'SINIESTRO FINIQUITADO', (select sst.nombre from siniestro_tramite_autos sst where sst.id=s.causa_id)) tram_nombre
		from seguimiento s
		left join siniestro_reportes sr on s.referencia_id=sr.id 
		left join siniestro_estatus_tramites setr on s.estatus_id=setr.id
		left join users u on s.usuario_id=u.idPersona
		where s.referencia_id=".$id." and s.referencia='AUTOS' order by s.id DESC;";
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
	function findStatus($id){
		$tipos = $this->db->where('id',$id)->get('siniestro_estatus_tramites');
		$res=$tipos->result_array();
		return empty($res)?'':$res[0]['nombre'];
	}

	function getYearsDocs(){
		$sql="select year(sr.inicio_ajuste) opcion from siniestro_reportes sr where sr.tipo_r='A'
		group by year(sr.inicio_ajuste);";
		$data=$this->db->query($sql);
		return $data->result_array();
	}
	function ExistSiniestro($id,$poliza){
		$tipos = $this->db->where('siniestro_id', $id)->where('poliza', $poliza)->where('tipo_r', 'A')->get('siniestro_reportes');
		return empty($tipos->result_array())?true:false;
	}

	function ExistSiniestro2($id,$poliza){
		$tipos = $this->db->where('siniestro_id', $id)->where('poliza', $poliza)->where('tipo_r', 'A')->get('siniestro_reportes');
		return $tipos->result_array();
	}

	//nuevos
	function getAllAutostablaRango($id_estatus,$year,$month=null,$rango1=null,$rango2=null){
		$obj=array();	
		$this->db
		->select("sr.*, st.nombre tipo_siniestro_nombre, sc.nombre causa_nombre,sta.nombre autoridad_nombre,indicador.dias,TIMESTAMPDIFF(DAY, sr.inicio_ajuste, CURDATE()) progreso, setr.color,setr.nombre estatus,setr.orden")
		->where( "sr.tipo_r", 'A')
		->join("siniestro_tipo st", "sr.tipo_siniestro_id=st.id", "left")
		->join("siniestro_causa sc", "sr.causa_siniestro_id=sc.id", "left")
		->join("siniestro_tipoautoridad sta", "sr.autoridad_id=sta.id", "left")
		->join("(select * from indicadores i where cliente_id=0) as indicador", "sr.tipo_siniestro_id=indicador.causa_id", "left")
		->join("siniestro_estatus_tramites setr", "sr.siniestro_estatus=setr.nombre", "left");
		if($year!='0'){
			$this->db->where("year(sr.inicio_ajuste)", $year);
		}
		if($month!=null){
			$this->db->where("month(sr.inicio_ajuste)", $month);
		}
		if($id_estatus!='0'){
			$this->db->where("setr.id", $id_estatus);
		}
		if($rango1!=null){
			$this->db->where("TIMESTAMPDIFF(DAY, sr.inicio_ajuste, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))>=", $rango1);
		}
		if($rango2!=null){
			$this->db->where("TIMESTAMPDIFF(DAY, sr.inicio_ajuste, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))<=", $rango2);
		}
		
		
		$obj=$this->db->get('siniestro_reportes sr');
		return $obj->result_array();
	}

	function getDataExcelAutos($id_estatus,$year,$month=null,$rango1=null,$rango2=null){
		$obj=array();	
		$this->db
		->select("sr.siniestro_id siniestro, sr.asegurado_nombre, sr.poliza,sr.certificado,sr.siniestro_estatus,st.nombre tipo_siniestro_nombre,sc.nombre causa_nombre,sr.complemento_json")
		->where( "sr.tipo_r", 'A')
		->join("siniestro_tipo st", "sr.tipo_siniestro_id=st.id", "left")
		->join("siniestro_causa sc", "sr.causa_siniestro_id=sc.id", "left")
		->join("siniestro_tipoautoridad sta", "sr.autoridad_id=sta.id", "left")
		->join("(select * from indicadores i where cliente_id=0) as indicador", "sr.tipo_siniestro_id=indicador.causa_id", "left")
		->join("siniestro_estatus_tramites setr", "sr.siniestro_estatus=setr.nombre", "left");
		if($year!='0'){
			$this->db->where("year(sr.inicio_ajuste)", $year);
		}
		if($month!=null){
			$this->db->where("month(sr.inicio_ajuste)", $month);
		}
		if($id_estatus!='0'){
			$this->db->where("setr.id", $id_estatus);
		}
		if($rango1!=null){
			$this->db->where("TIMESTAMPDIFF(DAY, sr.inicio_ajuste, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))>=", $rango1);
		}
		if($rango2!=null){
			$this->db->where("TIMESTAMPDIFF(DAY, sr.inicio_ajuste, if(sr.fecha_fin is null,CURDATE(),sr.fecha_fin))<=", $rango2);
		}
		
		
		$obj=$this->db->get('siniestro_reportes sr');
		return $obj->result_array();
	}

	///nuevos metodos
	function getLlenadoSelect($Tipo){
        $this->db->where('tipo',$Tipo);
        $obj=$this->db->get('siniestros_autos_catalagos');
        return $obj->result_array();
    }
	function getTramite($id,$siniestro){
        if($id){
            $this->db->select("st.*,(select fecha_ocurrencia from siniestro_reportes where id='".$siniestro."') as fecha_ocurrencia,sr.* ");
            $this->db->where('st.id',$id);
			$this->db->join('siniestro_reportes sr', 'st.id_siniestro=sr.id');
            $obj=$this->db->get('siniestro_tramite st');
        }else{
            $this->db->select("sr.fecha_ocurrencia");
            $this->db->where('sr.id',$siniestro);
            $obj=$this->db->get('siniestro_reportes sr');
        }
        return $obj->result_array();
    }

	function getTramitesAutos(){
        $obj=$this->db->get('siniestro_tramite_autos');
        return $obj->result_array();
    }

	function opcionCerrarSiniestro($id){
        $this->db->select("*")->where("id",$id)->where("valores","1");
        $obj=$this->db->get('siniestro_estatus_tramites sr');
        $row=$obj->result_array();

        if(!isset($row[0])){
            return false;
        }else{
            return true;
        }
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

	function tiposiniestro(){
        //$tipos = $this->db->get('siniestro_tipo');
        $this->db->select('st.nombre,st.id');
        $this->db->where('sr.tipo_r','A');
        $this->db->join("siniestro_tipo st","sr.tipo_siniestro_id=st.id","inner");
        $this->db->group_by("st.id")->order_by('st.nombre','ASC');
        $tipos = $this->db->get('siniestro_reportes sr');
        return $tipos->result_array();
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