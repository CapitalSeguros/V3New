<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class preguntasmodel extends CI_Model
{

    function insertPregunta($data)
    {
        $this->db->insert('preguntas', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function updatePregunta($id, $data)
    {
        $this->db->where('id', $id);
        $res = $this->db->update('preguntas', $data);
        return $res;
    }
    function selectPregunta()
    {
        $tipos = $this->db->query('select *, preguntas.id as Idp from preguntas,tipo_pregunta where preguntas.tipo_pregunta_id=tipo_pregunta.id ORDER BY preguntas.id DESC');
        //$tipos=$this->db->query('Select *,pregunta.id as Idp,GROUP_CONCAT(DISTINCT respuesta.respuesta ORDER BY pregunta.id)as respuestas FROM pregunta,pregunta_respuestas,respuesta,tipo_pregunta WHERE pregunta.id=pregunta_respuestas.pregunta_id and pregunta_respuestas.respuesta_id=respuesta.id and pregunta.tipo_pregunta_id=tipo_pregunta.id');
        return $tipos->result_array();
    }
    function getPregunta($id)
    {
        $tipos = $this->db->query('select *, preguntas.id as Idp, tipo_pregunta.clave as clave from preguntas,tipo_pregunta where preguntas.id="' . $id . '" and preguntas.tipo_pregunta_id=tipo_pregunta.id');
        return $tipos->result_array();
    }
    function DeletePregunta($id)
    {
        try {
            $this->db->where('pregunta_id', $id);
            $this->db->delete('competencias_preguntas');
        } catch (\Throwable $th) {
            return $erro = "Error" + $th;
        }
        $this->db->where('id', $id);
        $this->db->delete('preguntas');
        return true;
    }

    function getTipoPregunta()
    {
        $res = $this->db
            ->where("estado", 1)
            ->select("id,clave,nombre")
            ->get("tipo_pregunta");

        return $res->result();
    }
    function getIdTipopregunta($tipo)
    {
        $value = "";
        $res = $this->db->query('select id from tipo_pregunta where clave="' . $tipo . '"');
        foreach ($res->result_array() as $row) {
            $value = $row['id'];
        }
        return $value;
    }
    //metodos de la tabla tipo_pregunta
    function insertTipopregunta($data)
    {
        $this->db->insert('tipo_pregunta', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function getLastIndexTable($nameTable)
    {
        $res = $this->db->query("select id from " . $nameTable . " ORDER BY `id` DESC LIMIT 1");
        foreach ($res->result_array() as $row) {
            $value = $row['id'];
        }
        return $value + 1;
    }
}
