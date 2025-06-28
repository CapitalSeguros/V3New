<?php 

class califica_agente_model extends CI_Model{
	public function __Construct(){
		parent::__Construct();
	}

	function getActiveAgent($sql = "") {
		$query = $this->db->query('SELECT p.*, us.IDVend, us.email, p.userEmailCreacion FROM `persona` p LEFT JOIN `users` us ON us.idPersona = p.idPersona WHERE p.tipoPersona = 3 AND us.activated = 1 AND us.banned = 0 '.$sql)->result();
		foreach ($query as $val) {
			$con = $this->db->query('SELECT mc.canal FROM `meta_usuario_canal` mc WHERE mc.correo = "'.$val->userEmailCreacion.'"')->result();
			$val->canal = !empty($con) ? $con[0]->canal : "";
		}
		return $query;
	}

	function getActiveEmployee($sql = "") {
		$query = $this->db->query('SELECT p.*, us.IDVend, us.email, p.userEmailCreacion FROM `persona` p LEFT JOIN `users` us ON us.idPersona = p.idPersona WHERE p.tipoPersona = 1 AND us.activated = 1 AND us.banned = 0 '.$sql)->result();
		foreach ($query as $val) {
			$con = $this->db->query('SELECT mc.canal FROM `meta_usuario_canal` mc WHERE mc.correo = "'.$val->userEmailCreacion.'"')->result();
			$val->canal = !empty($con) ? $con[0]->canal : "";
		}
		return $query;
	}
    
  	function getPictureUser($idPersona) {
  		$query = $this->db->query('SELECT fotoUser FROM `user_miInfo` WHERE `idPersona` = '.$idPersona)->row();
  		return !empty($query) ? $query->fotoUser : "";
  	}

  	function getActiveEvaluation() {
  		$query = $this->db->query('SELECT * FROM `calificar_agente` WHERE `activa` = 0')->result();
  		return $query;
  	}

    function getQuestionEvaluation($id) {
      	$query = $this->db->query('SELECT * FROM `calificar_agente_preguntas` WHERE `id_valoracion` = '.$id)->result();
      	foreach ($query as $row) {
        	$options = "";
        	if ($row->tipo_respuesta == 2 || $row->tipo_respuesta == 3) {
        		$options = $this->db->query('SELECT titulo, respuesta  FROM `calificar_agente_opciones` WHERE `id_pregunta` = '.$row->id_pregunta)->result();
        	}
        	$row->opciones = $options;
      	}
      	return $query;
    }

    function getQuestionOptions($id) {
      	$query = $this->db->query('SELECT * FROM `calificar_agente_opciones` WHERE `id_pregunta` = '.$id)->result();
      	return $query;
    }

  	function insertQuestionEvaluation($data) {
      	$query = $this->db->insert('calificar_agente_preguntas',$data);
      	return $this->db->insert_id();
    }

    function insertQuestionOptions($data) {
      	$query = $this->db->insert('calificar_agente_opciones',$data);
      	return $this->db->insert_id();
    }

    function insertAnswerQuestionEvaluation($data) {
      	$query = $this->db->insert('calificar_agente_respuestas',$data);
      	return $this->db->insert_id();
    }

    function insertEvaluationResponse($data) {
      	$query = $this->db->insert('calificar_agente_resueltas',$data);
      	return $this->db->insert_id();
    }

    function insertSpecialtyEvaluation($data) {
      	$query = $this->db->insert('estrellas_calificacion_new',$data);
      	return $this->db->insert_id();
    }

    function updateQuestionEvaluation($id,$data) {
      	$this->db->where('id_pregunta',$id);
      	$query = $this->db->update('calificar_agente_preguntas',$data);
      	return $query;
    }

    function updateResponseEvaluation($id,$data) {
      	$this->db->where('id',$id);
      	$query = $this->db->update('calificar_agente_resueltas',$data);
      	return $query;
    }

    function updateAnswerQuestionEvaluation($id,$data) {
      	$this->db->where('id_respuesta',$id);
      	$query = $this->db->update('calificar_agente_respuestas',$data);
      	return $query;
    }

    function deleteQuestionEvaluation($data) {
      	$this->db->delete('calificar_agente_opciones', array('id_pregunta' => $data));
      	return $this->db->delete('calificar_agente_preguntas', array('id_pregunta' => $data));
    }

    function getInformationResponseEvaluation($sql) {
      	$query = $this->db->query('SELECT cr.*, us.name_complete AS agente_nombre, us.email FROM `calificar_agente_resueltas` cr INNER JOIN `users` us ON us.idPersona = cr.agente '.$sql)->result();
      	foreach ($query as $key => $val) {
        	//$question = $this->db->query('SELECT * FROM `calificar_agente_preguntas` WHERE `id_valoracion` = '.$val->id_valoracion)->result();
        	$response = $this->db->query('SELECT cr.*, cp.id_pregunta, cp.pregunta, cp.tipo_respuesta FROM `calificar_agente_respuestas` cr INNER JOIN `calificar_agente_preguntas` cp ON cp.id_pregunta = cr.id_pregunta WHERE cr.id_resuelta = '.$val->id.' ORDER BY cr.id_respuesta ASC')->result();
        	/*foreach ($response as $row) {
          		$options = $this->getQuestionOptions($row->id_pregunta);
          		$row->opciones = $options; 
        	}*/
        	foreach ($response as $row) {
        		$options = "";
        		if ($row->tipo_respuesta == 2 || $row->tipo_respuesta == 3) {
          			$options = $this->db->query('SELECT titulo, respuesta FROM `calificar_agente_opciones` WHERE `id_opcion` = '.$row->respuesta.' AND `id_pregunta` = '.$row->id_pregunta)->result();
          		}
          		$row->opcion = $options;
        	}
        	$val->respuestas = $response;
      	}
      	return $query;
    }

    function getInformationCompleteEvaluation($info = NULL) {
      	$data = array();
      	$query = $this->db->query('SELECT * FROM `calificar_agente` WHERE `activa` = 0 '.$info['sql_e'])->result();
      	foreach ($query as $key => $value) {
      	  	$sql_r = 'WHERE cr.id_valoracion = '.$value->id_valoracion.' '.(isset($info['sql_r']) ? $info['sql_r'] : "");
      	  	$questions = $this->getQuestionEvaluation($value->id_valoracion);
      	  	$result = $this->getInformationResponseEvaluation($sql_r);
      	  	$value->preguntas = $questions;
      	  	$value->generadas = $result;
      	}
      	return $query;
    }

    function getCommentsByAgent($idPersona) {
    	$query = $this->db->query('SELECT * FROM `calificar_agente_resueltas` WHERE `agente` = '.$idPersona.' ORDER BY `fecha_creacion` DESC')->result();
    	foreach ($query as $val) {
    		$response = $this->db->query('SELECT cr.*, cp.pregunta, cp.tipo_respuesta FROM `calificar_agente_respuestas` cr INNER JOIN `calificar_agente_preguntas` cp ON cp.id_pregunta = cr.id_pregunta WHERE cr.id_resuelta = '.$val->id)->result();
    		$val->respuestas = $response;
    		$val->comentario = "";
    		$val->estrellas = "";
    		$val->comunicacion = 0;
    		$val->presentacion = 0;
    		$val->puntualidad = 0;
    		$val->conocimiento = 0;
    		$val->aptitud = 0;
    		foreach ($response as $row) {
    			$options = "";
        		if ($row->tipo_respuesta == 2 || $row->tipo_respuesta == 3) {
          			$options = $this->db->query('SELECT titulo, respuesta FROM `calificar_agente_opciones` WHERE `id_opcion` = '.$row->respuesta.' AND `id_pregunta` = '.$row->id_pregunta)->result();
          		}
          		$row->opcion = $options;

    			switch($row->tipo_respuesta) {
    				case 3: 
    					switch($row->respuesta) {
    						case 1: $val->comunicacion++; break;
    						case 2: $val->presentacion++; break;
    						case 3: $val->conocimiento++; break;
    						case 4: $val->puntualidad++; break;
    						case 5: $val->aptitud++; break;
    					}
    				break;
    				case 4: $val->estrellas = $row->respuesta; break;
    				case 5: $val->comentario = $row->respuesta; break;
    			}
    		}
    	}
    	return $query;
    }

    function getScoresByAgent($idPersona) {
    	$query = $this->db->query('SELECT um.idPersona, um.IDVend, um.IDValida, um.apellidop, um.apellidom, um.nombre, um.fotoUser, um.emailUser FROM `user_miInfo` um WHERE um.idPersona = '.$idPersona)->result();
    	foreach ($query as $value) {
    		$consult = $this->db->query('SELECT * FROM `calificar_agente_resueltas` WHERE `agente` = '.$value->idPersona.' ORDER BY `fecha_creacion` DESC')->result();
    		$value->generadas = $consult;
    		$value->comunicacion = 0;
    		$value->presentacion = 0;
    		$value->puntualidad = 0;
    		$value->conocimiento = 0;
    		$value->aptitud = 0;
    		foreach ($consult as $val) {
    			$response = $this->db->query('SELECT cr.*, cp.pregunta, cp.tipo_respuesta FROM `calificar_agente_respuestas` cr INNER JOIN `calificar_agente_preguntas` cp ON cp.id_pregunta = cr.id_pregunta WHERE cr.id_resuelta = '.$val->id)->result();
    			$val->respuestas = $response;
    			$val->comentario = "";
    			$val->estrellas = "";
    			foreach ($response as $row) {
    				$options = "";
        			if ($row->tipo_respuesta == 2 || $row->tipo_respuesta == 3) {
          				$options = $this->db->query('SELECT titulo, respuesta FROM `calificar_agente_opciones` WHERE `id_opcion` = '.$row->respuesta.' AND `id_pregunta` = '.$row->id_pregunta)->result();
        	  		}
        	  		$row->opcion = $options;

    				switch($row->tipo_respuesta) {
    					case 3: 
    						switch($row->respuesta) {
    							case 1: $value->comunicacion++; break;
    							case 2: $value->presentacion++; break;
    							case 3: $value->conocimiento++; break;
    							case 4: $value->puntualidad++; break;
    							case 5: $value->aptitud++; break;
    						}
    					break;
    					case 4: $val->estrellas = $row->respuesta; break;
    					case 5: $val->comentario = $row->respuesta; break;
    				}
    			}
    		}
    	}
    	return $query;
    }
}