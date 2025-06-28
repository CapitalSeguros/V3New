<?php 

class capacita_modelo extends CI_Model{
	public function __Construct(){
		parent::__Construct();
	}
	function votar_video($data){
	    $query = "UPDATE videos SET valoracion = valoracion + 1 WHERE id={$data['video_id']}";
		$this->db->query($query);
	}

	function votar_vistas($data){
	    $query = "UPDATE videos SET vistas = vistas + 1 WHERE id={$data['video_id']}";
		$this->db->query($query);
	}

	function votar_vistas_nombres($data){
		$query= "select CONCAT(persona.nombres,' ',persona.apellidoPaterno,' ',persona.apellidoMaterno) as nombreCompleto, videos.nombre, COUNT(persona.nombres) AS numero from videos_vistos, persona, videos where persona.idPersona=videos_vistos.idPersona and videos.id=videos_vistos.video_id and videos_vistos.video_id={$data['video_id']} GROUP BY nombreCompleto";
		$query=$this->db->query($query);
		$result = $query->result();
		return $result;
	}
	
	function categoria_videos(){
		$query = $this->db->query("SELECT * from catalog_capacitacion");
		$result = $query->result();
		return $result;
	}

	function ramo_videos(){
		$query = $this->db->query("SELECT * from catalog_ramos");
		$result = $query->result();
		return $result;
	}

	//3.) modelo recepcion de parametro de consulta y retorno de query al controlador
	function sub_categoria_videos($id){
		$query = $this->db->query("SELECT * from catalog_certificacion WHERE id_capacitacion={$id}");
		$result = $query->result();
		return $result;
	}




	function get_videos(){
		$query = $this->db->query("SELECT videos.*,catalog_capacitacion.tipoCapacitacion,catalog_certificacion.nombreCertificado FROM videos,catalog_capacitacion,catalog_certificacion WHERE videos.categoria=catalog_capacitacion.id_capacitacion AND videos.subcategoria=catalog_certificacion.id_certificado ORDER BY videos.id DESC");
		$result = $query->result();
		return $result;
	}

	function get_contVistas(){
		$query = $this->db->query("SELECT `video_id`, count(*) as vistas FROM `videos_vistos` group by video_id");
		$result = $query->result();
		return $result;
	}
	function get_videos_categoria($id){
		$query = $this->db->query("SELECT videos.*,catalog_capacitacion.tipoCapacitacion,catalog_certificacion.nombreCertificado FROM videos,catalog_capacitacion,catalog_certificacion WHERE videos.categoria=catalog_capacitacion.id_capacitacion AND videos.subcategoria=catalog_certificacion.id_certificado AND videos.categoria='$id' ORDER BY videos.id DESC");
		$result = $query->result();
		return $result;
	}

	function get_videos_id($id){
		$query = $this->db->query("SELECT videos.*,catalog_capacitacion.tipoCapacitacion,catalog_certificacion.nombreCertificado FROM videos,catalog_capacitacion,catalog_certificacion WHERE videos.categoria=catalog_capacitacion.id_capacitacion AND videos.subcategoria=catalog_certificacion.id_certificado AND videos.id='$id' ORDER BY videos.id DESC");
		$result = $query->result();
		return $result;
	}
	
	function guardar_video($data){
		$this->db->insert("videos",$data);
	}
	
	public function borrar_video($id){
		return $this->db->query("DELETE from videos where id = {$id}");
	}
	public function modificar_url_video($data){
		$this->db->set('url_video',rawurlencode($data['video']));
		$this->db->where('id',$data['id']);
	    $this->db->update('videos');
	    return;
	}
	public function modificar_url_imagen($data){
		$this->db->set('url_imagen',$data['imagen']);
		$this->db->where('id',$data['id']);
	    $this->db->update('videos');
	    return;
	}
	public function modificar_url_documento($data){
		$this->db->set('url_documento',$data['documento']);
		$this->db->where('id',$data['id']);
	    $this->db->update('videos');
	    return;
	}


	public function modificar_video($data){
		$this->db->set('nombre',$data['nombre']);
		$this->db->set('descripcion',$data['descripcion']);
		$this->db->set('categoria',$data['categoria']);
		$this->db->set('subcategoria',$data['subcategoria']);
		$this->db->set('ramo',$data['ramo']);
		$this->db->set('lecciones',$data['lecciones']);
		$this->db->set('examen',$data['examen']);
		$this->db->set('duracion',$data['duracion']);
		$this->db->set('estudiantes',$data['estudiantes']);
		$this->db->set('certificado',$data['certificado']);
		$this->db->set('id_ramo',$data['id_ramo']);
		$this->db->where('id',$data['id']);
	    $this->db->update('videos');
	    return;
	}

	function guardar_solicitud_evaluacion($data){
		$this->db->insert("solicitud_evaluacion",$data);
	}
	//---------------------
	function devuelveCapacitaciones($id){ //Funcion obsoleta

		$res = array();

		$this->db->select("mes,nombreCertificado,tipoCapacitacion");
		$this->db->select_sum("certificacion");
		$this->db->select_sum("certificacionAutos");
		$this->db->select_sum("certificacionGmm");
		$this->db->select_sum("certificacionVida");
		$this->db->select_sum("certificacionDanos");
		$this->db->select_sum("certificacionFianzas");
		$this->db->from("registro_certificacion");
		$this->db->join("catalog_certificacion", "catalog_certificacion.id_certificado = registro_certificacion.id_certificado", "inner");
		$this->db->join("catalog_capacitacion", "catalog_capacitacion.id_capacitacion = catalog_certificacion.id_capacitacion", "inner");
		$this->db->where("idPersona", $id);
		$this->db->group_by("nombreCertificado");
		//$this->db->group_by("mes");
		$this->db->order_by("mes", "ASC");
		$query = $this->db->get("");

		if($query->num_rows() > 0){
			$res = $query->result();
		}

		return $res;
	}
	//---------------------
	function obtenerCategorias(){

		$resultado = array();

		$this->db->from("catalog_certificacion");
		$this->db->join("catalog_capacitacion", "catalog_capacitacion.id_capacitacion = catalog_certificacion.id_capacitacion","inner");
		$this->db->where("catalog_certificacion.activo", 1);
		$this->db->where("catalog_capacitacion.activo", 1);
		$query = $this->db->get();

		if($query->num_rows() > 0){
			$resultado = $query->result();
		}

		return $resultado;
	}
	//---------------------
	function devuelveCapacitacionEspecifica($array){ //Funcion obsoleta

		$res = array();

		$this->db->select("emailCreador, fechaAsignada, registro_certificacion.descripcion, nombreCertificado, tipoCapacitacion");

		switch($array["r"]){
			case "profesional": $this->db->select("certificacion as tiempo");
			break;
			case "autos": $this->db->select("certificacionAutos as tiempo");
			break;
			case "gmm": $this->db->select("certificacionGmm as tiempo");
			break;
			case "vida": $this->db->select("certificacionVida as tiempo");
			break;
			case "danio": $this->db->select("certificacionDanos as tiempo");
			break;
			case "fianzas": $this->db->select("certificacionFianzas as tiempo");
			break;
		}

		$this->db->from("registro_certificacion");
		$this->db->join("catalog_certificacion", "catalog_certificacion.id_certificado=registro_certificacion.id_certificado", "inner");
		$this->db->join("catalog_capacitacion", "catalog_capacitacion.id_capacitacion=catalog_certificacion.id_capacitacion", "inner");
		$this->db->where("registro_certificacion.idPersona", $array["u"]);
		$this->db->where("catalog_capacitacion.tipoCapacitacion",$array["c"]);
		$this->db->where("catalog_certificacion.nombreCertificado",$array["sc"]);
		$this->db->where("registro_certificacion.mes",$array["t"]);
		$query = $this->db->get();

		if($query->num_rows()>0){

			$res = $query->result();
		}

		return $res;
	}
	//--------------------
	function devuelveAltasCapacitaciones($correo, $mes){ //Funcion obsoleta

		$correos_validos=array("SISTEMAS@ASESORESCAPITAL.COM","ASISTENTEDIRECCION@AGENTECAPITAL.COM","DIRECTORGENERAL@AGENTECAPITAL.COM","DIRECTORCOMERCIAL@AGENTECAPITAL.COM","GERENTECORPORATIVO@CAPITALSEGUROS.COM.MX","MARKETING@AGENTECAPITAL.COM","GERENTEOPERATIVO@AGENTECAPITAL.COM");

		$r = array();
		$this->db->select("persona.idPersona, users.username, persona.nombres, persona.apellidoPaterno, persona.apellidoMaterno, registro_certificacion.emailCreador, catalog_certificacion.nombreCertificado, catalog_certificacion.id_certificado, catalog_capacitacion.tipoCapacitacion, catalog_capacitacion.id_capacitacion");
		$this->db->from("registro_certificacion");
		$this->db->join("catalog_certificacion", "catalog_certificacion.id_certificado = registro_certificacion.id_certificado", "inner");
		$this->db->join("catalog_capacitacion", "catalog_capacitacion.id_capacitacion = catalog_certificacion.id_capacitacion", "inner");
		$this->db->join("persona", "persona.idPersona = registro_certificacion.idPersona", "left");
		$this->db->join("users", "users.idPersona = registro_certificacion.idPersona", "left");
		//$this->db->where("registro_certificacion.mes", $mes);

		if(!in_array($correo, $correos_validos)){

			$this->db->where("registro_certificacion.emailCreador", $correo);
		}
		
		$this->db->group_by(array("registro_certificacion.idPersona","registro_certificacion.id_certificado"));
		$query = $this->db->get();

		if($query->num_rows > 0){
			$r = $query->result();
		}

		return $r;
	}
	//-------------------
	function devuelveCapacitacionPersona($array){ //Funcion obsoleta

		$res = array();

		$this->db->from("registro_certificacion");
		$this->db->join("catalog_certificacion", "catalog_certificacion.id_certificado=registro_certificacion.id_certificado", "inner");
		$this->db->join("catalog_capacitacion", "catalog_capacitacion.id_capacitacion=catalog_certificacion.id_capacitacion", "inner");
		$this->db->where("registro_certificacion.idPersona", $array["u"]);
		$this->db->where("catalog_capacitacion.id_capacitacion",$array["c"]);
		$this->db->where("catalog_certificacion.id_certificado",$array["sc"]);
		$this->db->where("registro_certificacion.mes",$array["t"]);
		$query = $this->db->get();

		if($query->num_rows()>0){

			$res = $query->result();
		}

		return $res;
	}
	//------------------
	function destruyeRegistroDeCapacitacion($idRegistro){ //Dennis [2021-08-18]

		$res = false;
		$conteo = $this->devuelveCantidadRegistros($idRegistro);
		$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($conteo, TRUE));fclose($fp);

		//$tables = array()

		$this->db->where("idRegistro",$idRegistro);
		$this->db->delete(array("capacita_registros", "capacita_documentacion","capacita_relacion_invitado_registro"));

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
		} else{
			$this->db->trans_commit();
			$res = true;
		}

		return $res;
	}
	//------------------------
	function devuelveCantidadRegistros($idRegistro){

		//$count = "SELECT COUNT(*) FROM capacita_registros a INNER JOIN capacita_registros_horas b ON a.idRegistroHora = b.idRegistroHora WHERE a.idRegistro = ".$idRegistro."";
		//$query = $this->db->query($count);

		//$this->db->select("idRegistroHora");
		$this->db->from("capacita_registros a");
		$this->db->join("capacita_registros_horas b", "a.idRegistroHora = b.idRegistroHora", "inner");
		$this->db->where("a.idRegistro", $idRegistro);

		return $this->db->count_all_results();
		//return $query->result();
	}
	//------------------------
	function devuelveHorasCapacitacion(){ //$c //Nuevo Dennis [2021-08-18] //Para sincronizar las tablas

		//$this->db->select("idPersona");
		//$this->db->select_sum("certificacion");
		//$this->db->select_sum("certificacionAutos");
		//$this->db->select_sum("certificacionGmm");
		//$this->db->select_sum("certificacionVida");
		//$this->db->select_sum("certificacionDanos");
		//$this->db->select_sum("certificacionFianzas");
		//$this->db->where("emailCreador", $c);
		//$this->db->group_by("idPersona");
		$query = $this->db->get("registro_certificacion");

		return $query->num_rows() > 0 ? $query->result() : array();
	}
	//------------------------
	function delvuelveAltaDeCapacitacion($correo){ //Nuevo

		$correos_validos=array(
			"SISTEMAS@ASESORESCAPITAL.COM",
			"ASISTENTEDIRECCION@AGENTECAPITAL.COM",
			"DIRECTORGENERAL@AGENTECAPITAL.COM",
			"DIRECTORCOMERCIAL@AGENTECAPITAL.COM",
			"GERENTECORPORATIVO@CAPITALSEGUROS.COM.MX",
			"MARKETING@AGENTECAPITAL.COM",
			"GERENTEOPERATIVO@AGENTECAPITAL.COM",
			"CAPITALHUMANO@AGENTECAPITAL.COM",
			"ASISTENTEDIRECTOR@AGENTECAPITAL.COM",
			"SERVICIOSESPECIALES@AGENTECAPITAL.COM",
		);

		$this->db->select("a.idPersona, c.nombres, c.apellidoPaterno, c.apellidoMaterno, e.creadorAlta, d.email");
		$this->db->from("capacita_registros a");
		$this->db->join("capacita_registros_horas b", "a.idRegistroHora = b.idRegistroHora", "inner");
		$this->db->join("capacita_usuario_creador e", "b.idRegistroHora = e.idRegistroHora", "inner");
		$this->db->join("persona c", "a.idPersona = c.idPersona", "inner");
		$this->db->join("users d", "a.idPersona = d.idPersona", "inner");
		$this->db->where("a.estado", "activo");
		//$this->db->join("capacita_relacion_registro_tipo_capacitacion e","a.idRegistro = e.idRegistro", "inner");

		if(!in_array($correo, $correos_validos)){

			$this->db->where("e.creadorAlta", $correo);
		}

		$this->db->group_by("a.idPersona");
		$query = $this->db->get();

		return $query->num_rows() > 0 ? $query->result() : array();
	}
	//-------------------
	function devuelveMiCapacitacion($idPersona){ //Nuevo

		$this->db->select("a.idPersona, b.fecha, d.nombre_ramo, e.nombreCertificado, f.tipoCapacitacion, g.creadorAlta");
		$this->db->select_sum("b.horas");
		$this->db->from("capacita_registros a");
		$this->db->join("capacita_registros_horas b", "a.idRegistroHora = b.idRegistroHora", "inner");
		$this->db->join("capacita_relacion_hora_ramo c", "b.idRegistroHora = c.idRegistroHora", "inner");
		$this->db->join("ramos d", "c.idR = d.idR", "inner");
		$this->db->join("catalog_certificacion e", "b.idSubCapacitacion = e.id_certificado", "inner");
		$this->db->join("catalog_capacitacion f", "e.id_capacitacion = f.id_capacitacion", "inner");
		$this->db->join("capacita_usuario_creador g", "b.idRegistroHora = g.idRegistroHora", "inner");
		$this->db->where("a.estado", "activo");
		$this->db->where("a.idPersona", $idPersona);
		$this->db->group_by("d.nombre_ramo");
		$this->db->group_by("f.tipoCapacitacion");
		$this->db->group_by("e.nombreCertificado");
		$query = $this->db->get();

		return $query->num_rows() >0 ? $query->result() : array();
	}
	//-------------------
	function devuelveInformacionDeCapacitacion($idPersona){ //Nuevo

		$this->db->select("h.archivo, f.id_capacitacion, a.idRegistro, b.horas, a.idPersona, a.tipoRegistro, b.fecha, d.nombre_ramo, e.nombreCertificado, f.tipoCapacitacion, g.creadorAlta"); //h.archivo,
		$this->db->from("capacita_registros a");
		$this->db->join("capacita_registros_horas b", "a.idRegistroHora = b.idRegistroHora", "inner");
		$this->db->join("capacita_relacion_hora_ramo c", "b.idRegistroHora = c.idRegistroHora", "inner");
		$this->db->join("ramos d", "c.idR = d.idR", "inner");
		$this->db->join("catalog_certificacion e", "b.idSubCapacitacion = e.id_certificado", "inner");
		$this->db->join("catalog_capacitacion f", "e.id_capacitacion = f.id_capacitacion", "inner");
		$this->db->join("capacita_usuario_creador g", "b.idRegistroHora = g.idRegistroHora", "inner");
		$this->db->join("capacita_documentacion h", "a.idRegistro = h.idRegistro", "left");
		$this->db->where("a.estado", "activo");
		//$this->db->join("capacita_documentacion i", "a.idRegistro = i.idRegistro", "left");
		$this->db->where("a.idPersona", $idPersona);
		$this->db->group_by("a.idRegistro");
		$query = $this->db->get();

		return $query->num_rows() >0 ? $query->result() : array();
	}
	//------------------- //Nuevo
	function devuelveResponsables($registro){

		$this->db->where("idRegistro", $registro);
		$query = $this->db->get("capacita_responsable");

		return $query->num_rows() > 0 ? $query->result() : array();
	}	
	//-------------------
	function devuelveCapacitacionPorIdRegistro($idRegistro){ //Nuevo

		//$this->db->select("h.archivo, f.id_capacitacion, a.idRegistro, b.horas, a.idPersona, b.fecha, d.nombre_ramo, e.nombreCertificado, f.tipoCapacitacion, g.creadorAlta");
		$this->db->from("capacita_registros a");
		$this->db->join("capacita_registros_horas b", "a.idRegistroHora = b.idRegistroHora", "inner");
		$this->db->join("capacita_relacion_hora_ramo c", "b.idRegistroHora = c.idRegistroHora", "inner");
		$this->db->join("ramos d", "c.idR = d.idR", "inner");
		$this->db->join("catalog_certificacion e", "b.idSubCapacitacion = e.id_certificado", "inner");
		$this->db->join("catalog_capacitacion f", "e.id_capacitacion = f.id_capacitacion", "inner");
		$this->db->join("capacita_usuario_creador g", "b.idRegistroHora = g.idRegistroHora", "inner");
		//$this->db->join("capacita_documentacion h", "a.idRegistro = h.idRegistro", "left");
		//$this->db->join("capacita_documentacion h", "a.idRegistro = h.idRegistro", "left");
		$this->db->join("persona i", "a.idPersona = i.idPersona");
		$this->db->join("users j", "a.idPersona = j.idPersona");
		$this->db->where("a.idRegistro", $idRegistro);
		$this->db->where("a.estado", "activo");
		$this->db->where("i.bajaPersona",0);
		$this->db->where("j.banned",0);
		$this->db->where("j.activated",1);
		//$this->db->group_by("a.idRegistro");
		$query = $this->db->get();

		return $query->num_rows() >0 ? $query->row() : array();

	}
	//------------------
	function devuelveHorasCapacitacionNuevo(){ //Nuevo

		$this->db->select("a.*, d.nombre_ramo, b.horas");
		$this->db->select_sum("b.horas");
		$this->db->from("capacita_registros a");
		$this->db->join("capacita_registros_horas b", "a.idRegistroHora = b.idRegistroHora", "inner");
		$this->db->join("capacita_relacion_hora_ramo c", "b.idRegistroHora = c.idRegistroHora", "inner");
		$this->db->join("ramos d", "c.idR = d.idR", "inner");
		$this->db->where("a.estado", "activo");
		$this->db->group_by("a.idPersona");
		$this->db->group_by("d.nombre_ramo");
		$query = $this->db->get();

		return $query->num_rows() > 0 ? $query->result() : array();
	}
	//------------------------
	function insertaRegistro($array, $tabla){ //Nuevo

		$response["lastId"] = 0;
		$response["bool"] = false;

		$this->db->trans_begin();
		$this->db->insert($tabla, $array);
		$response["lastId"] = $this->db->insert_id();
		
		if($this->db->trans_status() === FALSE){

			$this->db->trans_rollback();
		} else{

			$this->db->trans_commit();
			$response["bool"] = true;
		}

		return $response;
	}
	//------------------------
	function devuelveRamo($ramo){ //Nuevo

		$this->db->where("nombre_ramo",$ramo);
		$query = $this->db->get("ramos");

		return $query->num_rows() > 0 ? $query->row() : array();
	}
	//------------------------
	function actualizaRegistro($array){ //Nuevo

		//$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($array, TRUE));fclose($fp);

		$success = false;

		$update = "update capacita_registros a inner join capacita_registros_horas b on a.idRegistroHora = b.idRegistroHora
			inner join capacita_relacion_hora_ramo c on a.idRegistroHora = c.idRegistroHora
			inner join capacita_documentacion d on a.idRegistro = d.idRegistro
			set b.horas = ".$array["horas"].", d.archivo = '".$array["archivo"]."', b.idSubCapacitacion = ".$array["subCapacitacion"].", c.idR = ".$array["ramo"]." 
			where a.idRegistro = ".$array["idRegistro"]."";

		$this->db->query($update);
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
		} else{
			$this->db->trans_commit();
			$success = true;
		}

		return $success;
	}
	//------------------------
	function getTrainingSubCategoryByName($subCategory){

		 $this->db->where("nombreCertificado", $subCategory);
		 $query = $this->db->get("catalog_certificacion");

		 return $query->num_rows() > 0 ? $query->row() : array();
	}
	//------------------------
	function getTrainingCategoryById($category){

		$this->db->where("id_capacitacion", $category);
		$query = $this->db->get("catalog_capacitacion");

		return $query->num_rows() > 0 ? $query->row() : array();
   }
   //------------------------
   function getIdTraining($guest){

		$this->db->select("a.*, b.estado as checkStatus");
		$this->db->where("id_invitado", $guest);
		$this->db->join("capacita_registros b", "a.idRegistro = b.idRegistro", "inner");
		$query = $this->db->get("capacita_relacion_invitado_registro a");

		return $query->num_rows() > 0 ? $query->row() : array();
   }
   //------------------------
   function updateTrainingData($data){

		$update = "update capacita_registros a inner join capacita_registros_horas b on a.idRegistroHora = b.idRegistroHora inner join capacita_relacion_hora_ramo c ON b.idRegistroHora = c.idRegistroHora set c.idR = ".$data["idR"].", b.horas = ".$data["hours"].", a.estado = '".$data["estado"]."' where a.idRegistro = ".$data["idRegistro"]."";
		$query = $this->db->query($update);

		return $query;
   }
   //------------------------
   function obtenerArchivosDeCapacitacion($dataReg){

		$this->db->where("idRegistro", $dataReg);
		$query = $this->db->get("capacita_documentacion");

		return $query->num_rows() > 0 ? $query->row() : array();
   }
   //------------------------
   function actualizaRegistroInterno_($array){ //Nuevo

	$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($array, TRUE));fclose($fp);

	$success = false;
	$update = "update capacita_registros a inner join capacita_registros_horas b on a.idRegistroHora = b.idRegistroHora
		inner join capacita_relacion_hora_ramo c on a.idRegistroHora = c.idRegistroHora
		set b.horas = ".$array["horas"].", b.idSubCapacitacion = ".$array["subCapacitacion"].", c.idR = ".$array["ramo"]." 
		where a.idRegistro = ".$array["idRegistro"]."";

	$this->db->query($update);
	if($this->db->trans_status() === FALSE){
		$this->db->trans_rollback();
	} else{
		$this->db->trans_commit();
		$success = true;
	}

	return $success;
}
   //------------------------
   function deleleteRegister($array){

		$this->db->where($array["condition"]);
		$delete = $this->db->delete($array["table"]);

		return true;
   }
   //------------------------
   function deleteRelationshipTrainingAndEvent($idRegistro){
		
	$delete = 'delete a, b, c, d from capacita_registros a 
		inner join capacita_relacion_invitado_registro b on a.idRegistro = b.idRegistro 
		inner join capacita_registros_horas c on a.idRegistroHora = c.idRegistroHora
		inner join capacita_responsable d on b.idRegistro = d.idRegistro
		where a.idRegistro = '.$idRegistro.'';
	$delete = $this->db->query($delete);
	
	return $delete;
   }
   //------------------------
   function getInternalTrainingDates(){

		//$this->db->select("MONTH(fechaCompromiso)");
		$this->db->select("fechaCompromiso");
		$this->db->where("YEAR(fechaCompromiso)", date("Y"));
		$query = $this->db->get("capacita_responsable");

		return $query->num_rows() > 0 ? $query->result() : array();
   }
   //------------------------
   function getExternalTrainingDates(){

		//$this->db->select("MONTH(fecha)");
		$this->db->select("fecha");
		$this->db->from("capacita_registros a");
		$this->db->join("capacita_registros_horas b", "a.idRegistroHora = b.idRegistroHora", "inner");
		$this->db->where("a.tipoRegistro", "externo");
		$this->db->where("YEAR(b.fecha)", date("Y"));
		$query = $this->db->get();

		return $query->num_rows() > 0 ? $query->result() : array();
   }
   //-----------------------
   function getGeneralTrainingData(){

	$select = 'SELECT
			a.idRegistro, 
			a.idRegistroHora, 
			a.idPersona, 
			CONCAT(f.nombres, " ",f.apellidoPaterno," ", f.apellidoMaterno) as nombre_completo, 
			SUM(b.horas) as sumatoriaHoras, 
			e.nombre_ramo, 
			IF(tipoRegistro = "interno", c.fechaCompromiso, b.fecha) AS fechaCapacitacion,
			a.tipoRegistro,
			h.nombreCertificado AS subCapacitacion,
			j.tipoCapacitacion AS capacitacion,
			f.tipoPersona, 
			f.personaTipoAgente, 
			f.id_catalog_sucursales, 
			f.id_catalog_canales
		FROM capacita_registros a
		INNER JOIN capacita_registros_horas b ON a.idRegistroHora = b.idRegistroHora
		LEFT JOIN capacita_responsable c ON a.idRegistro = c.idRegistro
		INNER JOIN capacita_relacion_hora_ramo d ON b.idRegistroHora = d.idRegistroHora
		INNER JOIN ramos e ON d.idR = e.idR
		LEFT JOIN persona f ON a.idPersona = f.idPersona
		LEFT JOIN users g ON f.idPersona = g.idPersona
		INNER JOIN catalog_certificacion h ON b.idSubCapacitacion = h.id_certificado
		INNER JOIN catalog_capacitacion j ON h.id_capacitacion = j.id_capacitacion
		INNER JOIN capacita_usuario_creador k ON b.idRegistroHora = k.idRegistroHora
		WHERE f.bajaPersona = 0 AND g.banned = 0 AND g.activated = 1 AND a.estado = "activo"
		GROUP BY idPersona, nombre_ramo, fechaCapacitacion
		ORDER BY nombre_completo ASC';

		$query = $this->db->query($select);

		return $query->num_rows() > 0 ? $query->result() : array();
   }
   //------------------------
   function getGeneralTrainingData_($month, $year){

	$filterDates = '';

	if(!empty($month)){
		$filterDates .= 'AND (MONTH(c.fechaCompromiso) = '.$month.' || MONTH(b.fecha) = '.$month.')';
	}
	if(!empty($year)){
		$filterDates .= 'AND (YEAR(c.fechaCompromiso) = '.$year.' || YEAR(b.fecha) = '.$year.')';
	}

	$select = 'SELECT
			a.idRegistro, 
			a.idRegistroHora, 
			a.idPersona, 
			CONCAT(f.nombres, " ",f.apellidoPaterno," ", f.apellidoMaterno) as nombre_completo, 
			SUM(b.horas) as sumatoriaHoras, 
			e.nombre_ramo, 
			IF(tipoRegistro = "interno", c.fechaCompromiso, b.fecha) AS fechaCapacitacion,
			a.tipoRegistro,
			h.nombreCertificado AS subCapacitacion,
			j.tipoCapacitacion AS capacitacion,
			j.id_capacitacion,
			h.id_certificado,
			f.tipoPersona, 
			f.personaTipoAgente, 
			f.id_catalog_sucursales, 
			f.id_catalog_canales,
			l.NombreSucursal,
			e.idR
		FROM capacita_registros a
		INNER JOIN capacita_registros_horas b ON a.idRegistroHora = b.idRegistroHora
		LEFT JOIN capacita_responsable c ON a.idRegistro = c.idRegistro
		INNER JOIN capacita_relacion_hora_ramo d ON b.idRegistroHora = d.idRegistroHora
		INNER JOIN ramos e ON d.idR = e.idR
		LEFT JOIN persona f ON a.idPersona = f.idPersona
		LEFT JOIN users g ON f.idPersona = g.idPersona
		INNER JOIN catalog_certificacion h ON b.idSubCapacitacion = h.id_certificado
		INNER JOIN catalog_capacitacion j ON h.id_capacitacion = j.id_capacitacion
		INNER JOIN capacita_usuario_creador k ON b.idRegistroHora = k.idRegistroHora
		LEFT JOIN catalog_sucursales l ON  f.id_catalog_sucursales = l.IdSucursal 
		WHERE f.bajaPersona = 0 AND g.banned = 0 AND g.activated = 1 AND a.estado = "activo"
		GROUP BY idPersona, nombre_ramo, fechaCapacitacion
		ORDER BY nombre_completo ASC';

		$query = $this->db->query($select);

		return $query->num_rows() > 0 ? $query->result() : array();
   }
   //-----------------------
   function getTrainingProgress($month, $year){

		$this->db->select("e.id_capacitacion, e.tipoCapacitacion, d.id_certificado, d.nombreCertificado, c.idR, LOWER(c.nombre_ramo) as nombre_ramo, SUM(a.horas) AS total");
		$this->db->from("capacita_registros_horas a");
		$this->db->join("capacita_relacion_hora_ramo b", "a.idRegistroHora = b.idRegistroHora", "left");
		$this->db->join("ramos c", "b.idR = c.idR", "left");
		$this->db->join("catalog_certificacion d", "a.idSubCapacitacion = d.id_certificado", "left");
		$this->db->join("catalog_capacitacion e", "d.id_capacitacion = e.id_capacitacion", "left");
		$this->db->join("capacita_registros f", " a.idRegistroHora = f.idRegistroHora", "left"); //capacita_responsable
		$this->db->join("capacita_responsable g", " f.idRegistro = g.idRegistro", "left");
		$this->db->where("f.estado" , "activo");

		if(!empty($month)){
			$this->db->where("month(a.fecha) = ".$month."");
		}
		//$this->db->where("e.id_capacitacion", 2);
		$this->db->group_by("e.tipoCapacitacion");
		$this->db->group_by("d.nombreCertificado");
		$this->db->group_by("c.nombre_ramo");
		$query = $this->db->get();
		//$this->db->select_sum("a.horas");
		return $query->num_rows() > 0 ? $query->result() : array();
   }
   //-----------------------
   function getTraining(){

		$this->db->where("activo", 1);
		$query = $this->db->get("catalog_capacitacion");

		return $query->num_rows() > 0 ? $query->result() : array();
   }
   //-----------------------
   function getSubTraining(){
	
		$this->db->where("activo", 1);
		$query = $this->db->get("catalog_certificacion");

		return $query->num_rows() > 0 ? $query->result() : array();
   }
   //-----------------------
   function getTrainings(){

		$this->db->select("c.nombreCertificado, d.tipoCapacitacion, SUM(horas) horas, d.id_capacitacion", false)
				->from("capacita_registros_horas a")
				->join("capacita_registros b", "a.idRegistroHora = b.idRegistroHora", "inner")
				->join("catalog_certificacion c", "a.idSubCapacitacion = c.id_certificado", "inner")
				->join("catalog_capacitacion d", "c.id_capacitacion = d.id_capacitacion", "inner")
				->where("b.estado", "activo")
				->group_by("c.nombreCertificado");
		$query = $this->db->get();

		return $query->num_rows() > 0 ? $query->result() : array();
   }
   //-----------------------
   function getTrainingsWithDates(){

		$this->db->select("c.nombreCertificado, d.tipoCapacitacion, SUM(horas) as horas, d.id_capacitacion, IF(b.tipoRegistro = 'interno', e.fechaCompromiso, a.fecha) as fechaRegistro", false)
			->from("capacita_registros_horas a")
			->join("capacita_registros b", "a.idRegistroHora = b.idRegistroHora", "inner")
			->join("catalog_certificacion c", "a.idSubCapacitacion = c.id_certificado", "inner")
			->join("catalog_capacitacion d", "c.id_capacitacion = d.id_capacitacion", "left")
			->join("capacita_responsable e", "b.idRegistro = e.idRegistro", "left")
			->where("b.estado", "activo")
			//->where("d.tipoCapacitacion", "CAPACITACION TECNICA")
			->group_by("fechaRegistro")
			->group_by("c.nombreCertificado");
		$query = $this->db->get();

		return $query->num_rows() > 0 ? $query->result() : array();
   }
   //-----------------------
   function getPeopleWithTraining(){

		$this->db->select("b.idPersona, CONCAT(e.nombres, ' ' , e.apellidoPaterno,' ' , e.apellidoMaterno) AS nombre, SUM(a.horas) AS sumatoria_horas, d.nombre_ramo, IF(b.tipoRegistro = 'interno', f.fechaCompromiso, a.fecha) AS fechaRow,a.fecha AS registro", false);
		$this->db->from("capacita_registros_horas a");
		$this->db->join("capacita_registros b", "a.idRegistroHora = b.idRegistroHora", "inner");
		$this->db->join("capacita_relacion_hora_ramo c", "a.idRegistroHora = c.idRegistroHora", "left");
		$this->db->join("ramos d", "c.idR = d.idR", "inner");
		$this->db->join("persona e", "b.idPersona = e.idPersona", "left");
		$this->db->join("capacita_responsable f", "b.idRegistro = f.idRegistro", "inner");
		$this->db->where("b.estado", "activo");
		#$this->db->where("b.idPersona", 25);
		$this->db->group_by("b.idPersona");
		$this->db->group_by("fechaRow");
		$this->db->group_by("d.nombre_ramo");
		$query = $this->db->get();

		return $query->num_rows() > 0 ? $query->result() : array();
   }
   //----------------------
   function getSubTrainings($id){

		$this->db->where("id_capacitacion", $id);
		$this->db->where("activo", 1);
		$query = $this->db->get("catalog_certificacion");

		return $query->num_rows() > 0 ? $query->result() : array();
   }
   //----------------------
   function getPeopleWithTypes($training, $subtraining, $tipoPersona=null){

			$this->db->select("b.idPersona, g.id_certificado, h.id_capacitacion,  h.tipoCapacitacion, d.nombre_ramo, IF(b.tipoRegistro = 'interno', f.fechaCompromiso, a.fecha) AS fechaOficial, SUM(a.horas) AS horas, CONCAT(e.nombres, ' ', e.apellidoPaterno,' ', e.apellidoMaterno) AS nombre, e.tipoPersona, f.*, b.idRegistroHora", false)
				->from("capacita_registros_horas a")
				//->join("(SELECT * FROM capacita_registros WHERE tipoRegistro = 'interno') b", "a.idRegistroHora = b.idRegistroHora", "inner")
				->join("capacita_registros b", "a.idRegistroHora = b.idRegistroHora", "inner")
				->join("capacita_relacion_hora_ramo c", "a.idRegistroHora = c.idRegistroHora", "left")
				->join("ramos d", "c.idR = d.idR", "left")
				->join("persona e", "b.idPersona = e.idPersona", "left")
				//->join("(SELECT idRegistro, fechaCompromiso AS fechaOficial FROM capacita_responsable) f","b.idRegistro = f.idRegistro", "left")
				->join("capacita_responsable f", "b.idRegistro = f.idRegistro", "left")
				->join("catalog_certificacion g", "a.idSubCapacitacion = g.id_certificado", "left")
				->join("catalog_capacitacion h", "g.id_capacitacion = h.id_capacitacion", "left")
				->where("b.estado", "activo");

				if(!empty($training)){
					$this->db->where("h.id_capacitacion", $training);
				}
				if(!empty($subtraining)){
					$this->db->where("g.id_certificado", $subtraining);
				}
				if(!empty($tipoPersona)){
					$this->db->where("e.tipoPersona", $tipoPersona);
				}

				$query = $this->db->group_by("b.idRegistro")
					->group_by("d.nombre_ramo")
					->group_by("fechaOficial")
					->get();

		return $query->num_rows() > 0 ? $query->result() : array();
   }
   function getCapaciExternas(){
   	$query = $this->db->select("*", false)->from("capacita_externo")->get();
   	return $query->num_rows() > 0 ? $query->result() : array();
   }
   function emailAgentes(){
   	$query = $this->db->query("SELECT u.username, p.idPersona, concat(p.apellidoPaterno,' ' ,p.apellidoMaterno,' ' ,p.nombres) as name FROM `users` u INNER JOIN `persona` p on p.idPersona=u.idPersona where p.tipoPersona=3 and u.activated=1 and u.idTipoUser!=12");
   	return $query->num_rows() > 0 ? $query->result() : array();
   }
   //----------------------
   function agentsInTraining(){

		$query = $this->db->select("b.idRegistro, b.idPersona, e.id_capacitacion, a.idSubCapacitacion, e.tipoCapacitacion, d.nombreCertificado, IF(b.tipoRegistro = 'interno', c.fechaCompromiso, a.fecha) AS fechaOficial", false)
				->from("capacita_registros_horas a")
				->join("capacita_registros b", "a.idRegistroHora = b.idRegistroHora", "inner")
				->join("capacita_responsable c", "b.idRegistro = c.idRegistro", "left")
				->join("catalog_certificacion d", "d.id_certificado = a.idSubCapacitacion", "inner")
				->join("catalog_capacitacion e", "d.id_capacitacion = e.id_capacitacion", "left")
				->where("b.estado" , "activo")
				->group_by("a.idSubCapacitacion")
				->group_by("fechaOficial")
				->group_by("a.idRegistroHora")->get();

		return $query->num_rows() > 0 ? $query->result() : array();
   }
   //----------------------
   function getYears(){

		$query = $this->db->select("DISTINCT(IF(tipoRegistro = 'interno', YEAR(c.fechaCompromiso), YEAR(a.fecha))) AS dateTraining", false)
				->from("capacita_registros_horas a")
				->join("capacita_registros b", "a.idRegistroHora = b.idRegistroHora", "left")
				->join("capacita_responsable c", "b.idRegistro = c.idRegistro", "left")
				->where("b.estado", "activo")
				->order_by('dateTraining','desc')
				->get();
		
		return $query->num_rows() > 0 ? $query->result() : array();
   }
   //----------------------
   function updateTrainingDataSafely($where, $set, $table){

		$response = false;
		$this->db->trans_begin();
		$this->db->where($where);
		$this->db->update($table, $set);

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
		} else{
			$this->db->trans_commit();
			$response = true;
		}

		return $response;
   }
   //--------------------------------------------------------------------------------
   	function get_subcategoria($id) {
   		$query = $this->db->query("SELECT nombreCertificado FROM catalog_certificacion WHERE id_certificado = '$id'");
		return $query->row()->nombreCertificado;
   	}

   	function get_ramo($id) {
   		$query = $this->db->query("SELECT Nombre FROM catalog_ramos WHERE IDRamo = '$id'");
		return $query->row()->Nombre;
   	}

	function get_videos_vistos($user,$category) {
		$query = $this->db->query("SELECT * FROM videos_vistos WHERE idPersona = '$user' AND id_capacitacion = '$category' ORDER BY id ASC");
		return $query->result();
	}

	function registrar_accion($data) {
		return $this->db->insert('videos_vistos',$data);
	}

	function actualizar_accion($data) {
		$this->db->where('id',$data['id']);
		$this->db->set('ultimo_acceso',$data['ultimo_acceso']);	
		return $this->db->update('videos_vistos');
	}

	function quitar_voto($data) {
		$query = "UPDATE videos SET valoracion = valoracion - 1 WHERE id = {$data['video_id']}";
		$this->db->query($query);
	}

	function eliminar_accion($id) {
		$this->db->delete('videos_vistos', array('id' => $id));
	}

	function eliminar_video($video) {
		$this->db->delete('videos_vistos', array('video_id' => $video));
	}
	//---------------------------------------------------------------------------------
	function ver_revistas() {
		// $query = $this->db->query("SELECT * FROM revistas ORDER BY id DESC");
		// return $query->result();
		$this->db->select('r.*');
        $this->db->order_by('r.fechaRegistro', 'desc');
        //$this->db->group_by('f.fecha');
        $query = $this->db->get('revistas r');
        return $query->num_rows() > 0 ? $query->result() : array();
	}

	function consultar_revista($id) {
		$query = $this->db->query("SELECT * FROM revistas WHERE id = '$id'");
		return $query->result();
	}

	function registrar_revista($data) {
		return $this->db->insert('revistas',$data);
	}

	function actualizar_revista($id,$data) {
		$this->db->where('id',$id);
		return $this->db->update('revistas',$data);
	}

	function consult_ramo($id) {
		$query = $this->db->query("SELECT Nombre FROM catalog_ramos WHERE IDRamo = '$id'");
		$data = $query->result();
		foreach ($data as $value) {
			$name = $value->Nombre;
		}
		echo json_encode($name);
	}

	function eliminar_revista($id) {
		$this->db->delete('revistas', array('id' => $id));
		return $message = "Eliminado";
	}

	function guardar_archivo($id,$file) {
		$this->db->where('id',$id);
		$this->db->set('archivo',rawurlencode($file));
		$this->db->update('revistas');
		return $message = "Archivo agregado";
	}

	//-----------------------------------------------------------------------------------------
	function ver_tutoriales() {
		$query = $this->db->query("SELECT * FROM tutorial_videos ORDER BY idTutorial DESC");
		return $query->num_rows() > 0 ? $query->result() : array();
	}

	function consultar_tutorial($id) {
		$query = $this->db->query("SELECT * FROM tutorial_videos WHERE idTutorial = '$id'");
		return $query->result();
	}
	function registrar_tutorial($data) {
		$this->db->insert('tutorial_videos',$data);
		$last=$this->db->insert_id();
		$insert['idModule']=6;
		$insert['idTutorial']=$last;
		$this->db->insert('tutorial_module_relationship',$insert);
		return $message = "Registrado";
	}

	function actualizar_tutorial($id,$data) {
		$this->db->where('idTutorial',$id);
		$this->db->update('tutorial_videos',$data);
		return $message = "Actualizado";
	}

	function eliminar_tutorial($id) {
		$this->db->delete('tutorial_videos', array('idTutorial' => $id));
		return $message = "Eliminado";
	}

	function modificar_url_tutorial($id,$data) {
		$this->db->where('idTutorial',$id);
		$this->db->update('tutorial_videos',$data);
		return $message = "Archivo agregado";
	}

	//------------------------------------------------------------------------------------------
	function registerUserEvent($data) {//Creado [2024-04-26]
		$this->db->insert('capacita_externo',$data);
		return $this->db->insert_id();
	}

	function getInfoExternalEvent($idPersona){//Creado [2024-04-26]
		$query = $this->db->query('SELECT * FROM capacita_externo WHERE idPersona = '.$idPersona.' ORDER BY registration_date DESC');
		return $query->result();
	}

	function getExternalEvents(){//Creado [2024-04-26]
		$query = $this->db->query('SELECT c.*, p.nombres, p.apellidoPaterno, p.apellidoMaterno FROM capacita_externo c INNER JOIN persona p ON p.idPersona = c.idPersona ORDER BY registration_date DESC');
		return $query->result();
	}

	function deleteExternalEvent($id) { //Creado [Suemy][2024-04-26]
		return $this->db->delete('capacita_externo', array('id' => $id));
	}
}