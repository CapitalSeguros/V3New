<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class competenciasmodel extends CI_Model
{

    //obtiene los puestos registrados
    function getPuestos()
    {
        $tipos = $this->db->query('select idPuesto,personaPuesto from personapuesto;');
        return $tipos->result_array();
    }
    //obtiene los tipos de preguntas registrados
    function getTipodePregunta()
    {
        $tipos = $this->db->query('select * from tipo_pregunta where estado=1');
        return $tipos->result_array();
    }
    //inserta la nueva competencia generada
    function addCompetencia($data)
    {
        $this->db->insert('competencias', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    //inserta en la relación de las tablas competencia-puesto
    function addCompetenciaPuesto($data)
    {
        $this->db->insert('competencia_puestos', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function addPreguntasCompetencias($data)
    {
        $this->db->insert('competencias_preguntas', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    //metodos para la tabla de competencias
    function getALlCompetencias()
    {
        $tipos = $this->db->query('select *,(select count(competencias_id) from competencias_preguntas where competencias_preguntas.competencias_id=competencias.id) as numPreg from competencias');
        return $tipos->result_array();
    }

    function getAllPreguntasCompetencias()
    {
        $tipos = $this->db->query('select * from tipo_pregunta');
        return $tipos->result_array();
    }

    /* function getCompetencia($id){
        $tipos=$this->db->query('select * from competencias,competencia_puestos  where competencias.id=competencia_puestos.competencias_id and competencias.id="'.$id.'"');
        return $tipos->result_array();
    } */
    function getCompetencia($id)
    {
        $tipos = $this->db->query('select * from competencias  where competencias.id="' . $id . '"');
        return $tipos->result_array();
    }

    function getPuesto($id)
    {
        $tipos = $this->db->query('select pp.idPuesto as value,pp.personaPuesto as label from competencia_puestos cp,personapuesto pp
        where pp.idPuesto=cp.puestos_id and cp.competencias_id="' . $id . '"');
        return $tipos->result_array();
    }
    //metodos para el update de las preguntas
    function getCompletePreguntas()
    {
        $tipos = $this->db->query('select preguntas.titulo as titulo, preguntas.id as Idp,preguntas.descripcion as descripcion, tipo_pregunta.id as tipo_pregunta_id, preguntas.cantidad,tipo_pregunta.nombre as nombre,json_content as template from preguntas,tipo_pregunta where preguntas.tipo_pregunta_id=tipo_pregunta.id');
        return $tipos->result_array();
    }
    function getSelectedPreguntas($id)
    {
        $tipos = $this->db->query('select preguntas.titulo as titulo, preguntas.id as Idp,preguntas.descripcion as descripcion, tipo_pregunta.id as tipo_pregunta_id, preguntas.cantidad,tipo_pregunta.nombre as nombre, json_content as template,competencias_preguntas.orden from preguntas,tipo_pregunta,competencias_preguntas where preguntas.tipo_pregunta_id=tipo_pregunta.id and preguntas.id=competencias_preguntas.pregunta_id and competencias_preguntas.competencias_id="' . $id . '"');
        return $tipos->result_array();
    }
    //funciones para eliminar y actualizar
    function eliminarPreguntasCompetencia($id)
    {
        $tipos = $this->db->query('delete from competencias_preguntas where competencias_preguntas.competencias_id="' . $id . '"');
        //return $tipos->result_array();
    }
    function updateInfoCompetencia($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('competencias', $data);
    }

    function updatePuestoCompetencia($ids, $data)
    {
        $this->db->where('competencias_id', $ids);
        $this->db->update('competencia_puestos', $data);
    }

    function getLastIndexTable($nameTable)
    {
        $res = $this->db->query("select id from " . $nameTable . " ORDER BY `id` DESC LIMIT 1");
        foreach ($res->result_array() as $row) {
            $value = $row['id'];
        }
        return $value + 1;
    }

    function Comprobacion($id)
    {
        $res = $this->db->query('select * from evaluacion_competencias where evaluacion_competencias.competencias_id="' . $id . '"');
        if (!empty($res->result_array())) {
            return 1;
        } else {
            return 0;
        }
    }
    function EliminarCompetencia($id)
    {
        $res = $this->db->query('Delete from competencias where id="' . $id . '"');
        //$res->result_array();
        return true;
    }

    function DeletePreguntasCompetencias($id)
    {
        $res = $this->db->query('Delete from competencias_preguntas where competencias_id="' . $id . '"');
        return true;
    }
    function DeletePuestosCompetencias($id)
    {
        $res = $this->db->query('Delete from competencia_puestos where competencias_id="' . $id . '"');
        return true;
    }

    public function getCompetencias()
    {
        $query = $this->db->select("c.id,
                            c.titulo nombre,
                            c.descripcion,
                            CONCAT('A')  grado,
                            pp.personaPuesto puesto,
                            pp.idPuesto puesto_id,
                            (select tp.id from competencias_preguntas cp inner join preguntas p on cp.pregunta_id=p.id inner join tipo_pregunta tp on p.tipo_pregunta_id=tp.id where cp.competencias_id=c.id limit 1) Tipo")
            ->join("competencia_puestos cp", "c.id = cp.competencias_id", 'LEFT')
            ->join("personapuesto pp", "cp.puestos_id = pp.idPuesto", 'LEFT')
            ->get("competencias c");

        return $query->result();
    }

    public function getCompetenciasBy($id)
    {
        $query = $this->db->select("c.id,
                            c.titulo nombre,
                            c.descripcion,
                            CONCAT('A')  grado,
                            pp.personaPuesto puesto,
                            pp.idPuesto puesto_id")
            ->join("competencia_puestos cp", "c.id = cp.competencias_id", 'LEFT')
            ->join("personapuesto pp", "cp.puestos_id = pp.idPuesto", 'LEFT')
            ->where_in("c.id", $id)
            ->get("competencias c");

        return $query->result();
    }
}
