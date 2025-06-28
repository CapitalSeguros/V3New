<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class evaluacion_competencias_model extends CI_Model
{
        function __construct()
    {
        parent::__construct();
    }

    //obtiene las preguntas
    function getPreguntas($id)
    {
        $preguntas = $this->db->query('select * from preguntas_competencias  where competencia="' . $id . '"');
        return $preguntas->result_array();
    }

    function getRespuestas($idPersona)
    {
        $preguntas = $this->db->query('select * from respuestas_competencias  where idPersona="'. $idPersona .'"');
        return $preguntas->result_array();
    }
        function getRespuestasxCompetecia($valor,$idCalificador)
    {
        $preguntas = $this->db->query('select * from respuestas_competencias where `idCompetencia`='.$valor.' and`idCalificador`='.$idCalificador.'');
        return $preguntas->result_array();
    }
    
    
    function insertRespuestas($idPersona, $idPregunta, $respuesta, $idCompetencia, $idCalificador){
        //insertar respuestas 	
        $insert['respuesta']=$respuesta ;
        $insert['idPersona']=$idPersona ;
	    $insert['idPregunta']=$idPregunta ;
        $insert['idCompetencia']=$idCompetencia ;
	    $insert['idCalificador']=$idCalificador ;
	    $this->db->insert('respuestas_competencias',$insert);
        return $this->db->insert_id();
    }

}