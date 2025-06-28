<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class evaluaciones_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }


    function get_evaluaciones($withComp = false)
    {
        $query = $this->db
            ->select("e.*,et.nombre as tipo_evaluacion")
            ->join("evaluacion_tipo et", "e.tipo_evaluacion_id = et.id", "inner")
            ->where("e.estatus", "ACTIVO")
            ->get("evaluaciones e");
        $res  = $query->result();
        if ($withComp) {
            foreach ($res as $key => $value) {
                $rcomp = $this->db
                    ->select("ec.competencias_id, ec.evaluacion_id, p.tipo_pregunta_id")
                    ->join("competencias c", "ec.competencias_id = c.id", "inner")
                    ->join("competencias_preguntas cp", "c.id = cp.competencias_id", "inner")
                    ->join("preguntas p", "cp.pregunta_id = p.id", "inner")
                    ->where("ec.evaluacion_id", $value->id)
                    ->group_by("p.tipo_pregunta_id, ec.competencias_id, ec.evaluacion_id")
                    ->get("evaluacion_competencias ec");
                $value->competencia = $rcomp->result();
            }
        }

        return $res;
    }
    //metodos de la tabla pregunt

    function get_evaluacionesByUser($id)
    {
        $result = new \stdClass();
        $result->ok = false;
        $query = $this->db->get("evaluaciones");
        $result->data = array();
        $result->ok = true;
        if ($query->num_rows() > 0) {
            $result->data = $query->result();
            $result->rows = $query->num_rows();
        } else {
            $result->ok = false;
        }
        return $result;
    }

    function getEvaluacionId($id)
    {
        $result  = new \stdClass();
        $result->data = array();
        $query = $this->db
            ->where("e.id", $id)
            ->where("e.estatus", "ACTIVO")
            ->select("e.*,et.nombre as tipo_evaluacion")
            ->join("evaluacion_tipo et", "e.tipo_evaluacion_id = et.id", "inner")
            ->get("evaluaciones e");

        if ($query->num_rows() > 0) {
            $result->data = $query->row();
            $qury = $this->db
                ->where("evaluacion_id", $id)
                ->get("evaluacion_competencias");

            $result->data->competencias = $qury->result();
        }
        return $result;
    }

    function get_evaluacion($id)
    {
        $result = new \stdClass();
        $result->ok = false;
        $result->data = array();

        $query = $this->db->query("SELECT 
                                        e.*, 
                                        (SELECT concat(pr.nombres, ' ', pr.apellidoPaterno, ' ', pr.apellidoMaterno) FROM persona pr WHERE pr.idPersona = e.empleado_id) name_complete, 
                                        p.personaPuesto puesto 
                                    FROM (`evaluaciones` e) 
                                        INNER JOIN `evaluacion_relacion` er ON `e`.`id` = `er`.`evaluacion_id` 
                                        INNER JOIN `users` u ON `er`.`relacion_id` = `u`.`idPersona` 
                                        INNER JOIN `personapuesto` p ON `e`.`puesto_id` = `p`.`idPuesto` 
                                    WHERE `e`.`id` = '$id'");

        if ($query->num_rows() > 0) {
            $result->data = $query->row();
            $result->rows = $query->num_rows();
        } else {
            $result->ok = false;
        }
        return $result;
    }

    function get_preguntas_evaluacion($id, $id_p, $id_puesto)
    {
        $result = new \stdClass();
        $result->ok = false;
        $result->data = array();

        $query = $this->db->select('ec.competencias_id ,epc.grado, ec.evaluacion_id, c.titulo titulo_competencia, cp.pregunta_id,cp.orden,p.id pregunta_id,p.titulo,p.descripcion, p.tipo_pregunta_id,tp.clave,p.json_content')
            ->from('evaluacion_competencias ec')
            ->join('evaluacion_periodo_competencias epc', "epc.evaluacion_id = ec.evaluacion_id AND epc.competencias_id = ec.competencias_id AND epc.puesto_id = $id_puesto", 'inner')
            ->join('competencias_preguntas cp', 'ec.competencias_id = cp.competencias_id', 'inner')
            ->join('competencias c', 'c.id = cp.competencias_id', 'inner')
            ->join('preguntas p', 'cp.pregunta_id = p.id', 'inner')
            ->join('tipo_pregunta tp', 'tp.id = p.tipo_pregunta_id', 'inner')
            ->where("ec.evaluacion_id", $id)
            ->where("epc.evaluacion_periodo_id", $id_p)
            ->get();
        if ($query->num_rows() > 0) {
            $result->data = $query->result();
            $result->rows = $query->num_rows();
        } else {
            $result->ok = false;
        }

        return $result;
    }

    function get_respuesta_evaluacion($id, $idpe, $e_id)
    {
        $result = new  \stdClass();
        $result->ok = true;
        $result->data = array();
        try {
            $exist_ev = $this->db->where('evaluacion_p_e_id', $id)
                ->where("empleado_id", $e_id)
                ->where("evaluacion_periodo_id", $idpe)
                ->select("respuesta")
                ->get("evaluacion_periodo_respuesta");
            if ($exist_ev->num_rows() > 0) {
                $result->data = $exist_ev->row()->respuesta;
            }
        } catch (\Throwable $th) {
            $result->ok = false;
            $result->message = "Ocurrio un error al recuperar la información.";
        }
        return $result;
    }

    function updateTipoPregunta($id, $data)
    {
        $this->db->where('id', $id);
        $res = $this->db->update('tipo_pregunta', $data);
        return $res;
    }
    function selectTipoPregunta()
    {
        $tipos = $this->db->get('tipo_pregunta');
        return $tipos->result_array();
    }

    function getTipoPregunta()
    {
        $tipos = $this->db->select('id,clave,json_template')
            ->get('tipo_pregunta');
        return $tipos->result_array();
    }

    function insertEvaluacionRespuesta($data)
    {
        $result = new \stdClass();
        $result->ok = false;

        $exist_ev = $this->db->where('evaluacion_periodo_id', $data["evaluacion_periodo_id"])
            ->where("empleado_id", $data["empleado_id"])
            ->where("evaluacion_p_e_id", $data["evaluacion_p_e_id"])
            ->select("evaluacion_periodo_id")
            ->get("evaluacion_periodo_respuesta");

        if ($exist_ev->num_rows() > 0) {
            $result->ok = $this->db->where('evaluacion_periodo_id', $data["evaluacion_periodo_id"])
                ->where("empleado_id", $data["empleado_id"])
                ->where("evaluacion_p_e_id", $data["evaluacion_p_e_id"])
                ->update("evaluacion_periodo_respuesta", array("respuesta" => $data["respuesta"], "porcentaje" => $data["porcentaje"]));
        } else {
            $result->ok = $this->db->insert("evaluacion_periodo_respuesta", $data);
        }
        return $result;
    }

    function insertEvaluacionRespuestas($data)
    {
        $result = new \stdClass();
        $result->ok = false;
        $result->ok = $this->db->insert_batch("evaluacion_periodo_respuestas", $data);

        return $result;
    }

    function getEmpleadosPorEvaluacion($periodo, $empleado, $tipo_evaluacion)
    {
        $SQL = "SELECT 
                    epe.id
                FROM evaluacion_periodo_empleado epe
                INNER JOIN evaluaciones e ON e.id = epe.evaluacion_id 
                INNER JOIN evaluacion_tipo et ON et.id = e.tipo_evaluacion_id
                WHERE 
                    et.id = $tipo_evaluacion AND
                    epe.empleado_id = $empleado AND
                    epe.periodo_id = $periodo";
        $query = $this->db->query($SQL);

        return $query->result();
    }

    function getResultadoEvaluacion($periodo, $empleado, $tipo_evaluacion)
    {
        if ($periodo == null)
            $periodo = 0;

        $SQL = "SELECT 
                    eprs.empleado_id,
                    AVG(eprs.porcentaje) calificacion
                FROM 
                    evaluacion_periodo_respuestas eprs
                INNER JOIN evaluacion_periodo_empleado epe ON eprs.evaluacion_p_e_id = epe.id
                INNER JOIN evaluaciones e ON e.id = epe.evaluacion_id 
                INNER JOIN evaluacion_tipo et ON et.id = e.tipo_evaluacion_id
                WHERE 
                    epe.empleado_id = $empleado AND 
                    et.id = $tipo_evaluacion AND
                    eprs.evaluacion_periodo_id = $periodo
                GROUP BY eprs.empleado_id";
        $query = $this->db->query($SQL);

        return $query->result();
    }

    function getgraficaEvaluacion($periodo)
    {
        if ($periodo == null)
            $periodo = 0;
        $SQL = "SELECT eprs.empleado_id AS empleado,
                AVG(eprs.porcentaje) calificacion,u.name_complete AS nombre
            FROM 
                evaluacion_periodo_respuestas eprs
            INNER JOIN evaluacion_periodo_empleado epe ON eprs.evaluacion_p_e_id = epe.id
            INNER JOIN evaluaciones e ON e.id = epe.evaluacion_id 
            INNER JOIN evaluacion_tipo et ON et.id = e.tipo_evaluacion_id
            inner JOIN persona p ON(p.idpersona =  eprs.empleado_id) inner JOIN users u ON(p.idpersona = u.idpersona)
            WHERE 
                eprs.evaluacion_periodo_id = $periodo
            GROUP BY eprs.empleado_id";
        $query = $this->db->query($SQL);

        return $query->result();
    }

    function getEvaluacionByCompetencia($filtro)
    {

        $empleado = "";
        $puesto = "";
        if (!empty($filtro["puesto"])) {
            $puesto = $filtro["puesto"]["value"];
            $this->db->where("epp.puesto_id = $puesto");
        }
        if (!empty($filtro["colaborador"])) {
            $empleado = $filtro["colaborador"]["value"];
            $this->db->where("epr.empleado_id = $empleado");
        }

        $this->db->select_avg("epr.porcentaje");
        $this->db->select("epr.empleado_id, epp.puesto_id,c.titulo");
        $this->db->join("competencias c", "epr.competencia_id = c.id", "inner");
        $this->db->join("evaluacion_periodos_puesto epp", "epp.evaluacion_periodo_id = epr.evaluacion_periodo_id", "inner");
        $this->db->join("evaluacion_competencias ec", "ec.evaluacion_id = epp.evaluacion_id", "inner");
        $this->db->group_by("c.id");

        $query = $this->db->get("evaluacion_periodo_respuestas epr");

        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result();
        }
        return $row;
    }

    function getEvaluacionDesempenio($periodo)
    {
        if ($periodo == null)
            $periodo = 0;
        $SQL = "SELECT
        SUM(case when tmp.calificacion > 85 then 1 else 0 end) mayores,
        SUM(case when tmp.calificacion = 85 then 1 else 0 end) iguales,
        SUM(case when tmp.calificacion < 85 then 1 else 0 end) menores
        FROM (SELECT eprs.empleado_id AS empleado,
                           AVG(eprs.porcentaje) calificacion
                       FROM
                           evaluacion_periodo_respuestas eprs
                       INNER JOIN evaluacion_periodo_empleado epe ON eprs.evaluacion_p_e_id = epe.id
                       INNER JOIN evaluaciones e ON e.id = epe.evaluacion_id
                       INNER JOIN evaluacion_tipo et ON et.id = e.tipo_evaluacion_id
                       inner JOIN persona p ON(p.idpersona =  epe.empleado_id) inner JOIN users u ON(p.idpersona = u.idpersona)
                       WHERE
                           eprs.evaluacion_periodo_id = $periodo
                       GROUP BY eprs.empleado_id) tmp";

        $query = $this->db->query($SQL);

        return $query->result();
    }


    function getReporteEvaluaciones($periodo, $filtro = null)
    {
        if ($periodo == null)
            $periodo = 0;

        $WHERE = "eprs.evaluacion_periodo_id = $periodo";
        if ($filtro != null) {
            if (!empty($filtro["puesto"]["value"])) {
                $WHERE .= "  AND p.idPersonaPuesto = " . $filtro["puesto"]["value"] . "";
            }
            if (!empty($filtro["colaborador"]["value"])) {
                $WHERE .= "  AND p.idPersona = " . $filtro["colaborador"]["value"] . "";
            }
        }
        $SQL = "SELECT
                    *
                FROM (
                        SELECT 
                            eprs.empleado_id AS empleado_id,
                            u.name_complete AS empleado,
                            pp.personaPuesto AS puesto,
                            AVG(eprs.porcentaje) calificacion
                    FROM evaluacion_periodo_respuestas eprs
                    INNER JOIN evaluacion_periodo_empleado epe ON eprs.evaluacion_p_e_id = epe.id
                        INNER JOIN evaluaciones e ON e.id = epe.evaluacion_id
                        INNER JOIN evaluacion_tipo et ON et.id = e.tipo_evaluacion_id
                        INNER JOIN persona p ON(p.idpersona =  epe.empleado_id) 
                        INNER JOIN personapuesto pp ON p.idPersonaPuesto = pp.idPuesto
                        INNER JOIN users u ON(p.idpersona = u.idpersona)
                        WHERE
                            $WHERE
                        GROUP BY eprs.empleado_id
                ) tmp";

        $query = $this->db->query($SQL);

        return $query->result();
    }

    function detalleDesempenio($filtro, $calificacion)
    {
        $puesto = "";
        if ($filtro > 0) {
            $this->db->where("eprs.evaluacion_periodo_id = $filtro");
        }
        if (!empty($calificacion)) {
            if ($calificacion == "Mayores de 85") {
                $this->db->where("epe.calificacion > 85");
            } else {
                if ($calificacion == "Iguales a 85") {
                    $this->db->where("epe.calificacion = 85");
                } else {
                    $this->db->where("epe.calificacion < 85");
                }
            }
        }

        $this->db->select("u.name_complete as nombre,round(epe.calificacion,2) as calificación", false);
        $this->db->join("evaluacion_periodo_empleado epe", "eprs.evaluacion_p_e_id = epe.id", "inner");
        $this->db->join("evaluaciones e", "e.id = epe.evaluacion_id", "inner");
        $this->db->join("evaluacion_tipo et", "et.id = e.tipo_evaluacion_id", "inner");
        $this->db->join("persona p", "p.idpersona = eprs.empleado_id", "inner");
        $this->db->join("users u", "p.idpersona = u.idpersona", "inner");
        $this->db->group_by("eprs.empleado_id");

        $query = $this->db->get("evaluacion_periodo_respuestas eprs");

        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result();
        }
        return $row;
    }

    //metodos de la tabla evaluaciones
    function inserteEvaluaciones($data)
    {
        $this->db->insert('evaluaciones', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function updateDelete($id, $idPersona)
    {
        $this->db->where('id', $id);
        $res = $this->db->update('evaluaciones', array(
            "estatus" => "BAJA",
            "baja_por" => $idPersona,
            "deleted" => date("Y-m-d")
        ));
        return $res;
    }
    function updateEvaluaciones($id, $data)
    {
        $this->db->where('id', $id);
        $res = $this->db->update('evaluaciones', $data);
        return $res;
    }
    function delCompetenciaBy($id)
    {
        $this->db->where('evaluacion_id', $id);
        $res = $this->db->delete('evaluacion_competencias');
        return $res;
    }

    function selectEvaluaciones()
    {
        $tipos = $this->db->get('evaluaciones');
        return $tipos->result_array();
    }

    //metodos de la tabla evaluacion_relacion
    function insertEvaluacion_relacion($data)
    {
        $this->db->insert('evaluacion_relacion', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function insertEvaluacion_relacion_batch($data)
    {

        // $insert_id = $this->db->insert_id();
        return $this->db->insert_batch('evaluacion_relacion', $data);
    }


    function updateEvaluacion_relacion($id, $data)
    {
        $this->db->where('id', $id);
        $res = $this->db->update('evaluacion_relacion', $data);
        return $res;
    }
    function selectEvaluacion_relacion()
    {
        $tipos = $this->db->get('evaluacion_relacion');
        return $tipos->result_array();
    }

    //metodos de la tabla evaluacion_evaluados
    function insertEvaluacion_evaluados($data)
    {
        $this->db->insert('evaluacion_evaluados', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function insertEvaluacion_evaluados_batch($data)
    {
        // $insert_id = $this->db->insert_id();
        return $this->db->insert_batch('evaluacion_evaluados', $data);
    }


    function updateEvaluacion_evaluados($id, $data)
    {
        $this->db->where('id', $id);
        $res = $this->db->update('evaluacion_evaluados', $data);
        return $res;
    }
    function selectEvaluacion_evaluados()
    {
        $tipos = $this->db->get('evaluacion_evaluados');
        return $tipos->result_array();
    }

    //metodos de la tabla evaluacion_competencia
    function insertEvaluacion_competencia($data)
    {
        $this->db->insert('evaluacion_competencias', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function insertEvaluacion_competencia_batch($data)
    {
        if (!empty($data))
            return $this->db->insert_batch('evaluacion_competencias', $data);
        return true;
    }
    function updateEvaluacion_competencia($id, $data)
    {
        $this->db->where('id', $id);
        $res = $this->db->update('evaluacion_competencias', $data);
        return $res;
    }
    function selectEvaluacion_competencia()
    {
        $tipos = $this->db->get('evaluacion_competencias');
        return $tipos->result_array();
    }

    //metodos de la tabla competencias
    function insertCompetencias($data)
    {
        $this->db->insert('competencias', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function updateCompetencias($id, $data)
    {
        $this->db->where('id', $id);
        $res = $this->db->update('competencias', $data);
        return $res;
    }
    function selectCompetencias()
    {
        $tipos = $this->db->get('competencias');
        return $tipos->result_array();
    }

    //metodos de la tabla competencias_puestos
    function insertCompetencias_puestos($data)
    {
        $this->db->insert('competencias_puestos', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function updateCompetencias_puestos($id, $data)
    {
        $this->db->where('id', $id);
        $res = $this->db->update('competencias_puestos', $data);
        return $res;
    }
    function selectCompetencias_puestos()
    {
        $tipos = $this->db->get('competencias_puestos');
        return $tipos->result_array();
    }

    // function get_Puestos()
    // {
    //     $tipos = $this->db->select("idPuesto id, personaPuesto name, padrePuesto parent")
    //         ->where("statusPuesto", 1)
    //         ->get('personapuesto');
    //     return $tipos->result_array();
    // }

    function get_EmpleadoByPuesto($id)
    {
        $tipos = $this->db->select("p.idPersona id, p.nombres nombre, p.fecIngresoPersona fecha_ingreso,p.idPersonaPuesto")
            ->where_in("idPersonaPuesto", $id)
            ->get('persona p');

        return $tipos->result_array();
    }

    //metodos de la tabla competencias_preguntas
    function insertCompetencias_preguntas($data)
    {
        $this->db->insert('competencias_preguntas', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function updateCompetencias_preguntas($id, $data)
    {
        $this->db->where('id', $id);
        $res = $this->db->update('competencias_preguntas', $data);
        return $res;
    }
    function selectCompetencias_preguntas()
    {
        $tipos = $this->db->get('competencias_preguntas');
        return $tipos->result_array();
    }

    //metodo de la tabla respuesta
    function insertRespuesta($data)
    {
        $this->db->insert('respuesta', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }
    function updateRespuesta($id, $data)
    {
        $this->db->where('id', $id);
        $res = $this->db->update('respuesta', $data);
        return $res;
    }
    function selectRespuesta()
    {
        $tipos = $this->db->get('respuesta');
        return $tipos->result_array();
    }

    //metodo para obtner el ultimo indice las tablas
    function getLastIndexTable($nameTable)
    {
        $res = $this->db->get($nameTable);
        return $res->num_rows();
    }
    //obtine el tipo de pregunta de la competencia
    function getTipoCompetencia($Nombre)
    {
        $SQL = "SELECT  c.id competencia,p.id pregunta,p.tipo_pregunta_id tipo from competencias_preguntas cp
        inner join competencias c on cp.competencias_id=c.id
        inner join preguntas p on cp.pregunta_id=p.id
        inner join tipo_pregunta tp on p.tipo_pregunta_id=tp.id
        where p.titulo='".$Nombre."'
        limit 1";
        $query = $this->db->query($SQL);

        return $query->result_array();
    }
    //valida la respuesta correcta
    function validateRespuesta($respuesta,$idPregunta){
        $SQL = "SELECT * from preguntas where id=".$idPregunta." and respuesta='".$respuesta."'";
        $query = $this->db->query($SQL);
        $row=[];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }
    ///funicones de pruebas

    function getRespuestasJson(){
        $SQL="select *
        from evaluacion_periodo_respuesta epr
        inner join evaluacion_periodo_empleado epe on epr.evaluacion_p_e_id=epe.id";
        $query = $this->db->query($SQL);
        $row=[];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }

    function getCompetenciasGrado($periodo,$evaluacion,$puesto,$titulo){
        $SQL="select * 
        from evaluacion_periodo_competencias  epc
        left join competencias c on epc.competencias_id=c.id
        where epc.evaluacion_periodo_id=".$periodo." and epc.evaluacion_id=".$evaluacion." and epc.puesto_id=".$puesto." and c.titulo='".$titulo."' ";;
        $query = $this->db->query($SQL);
        $row=[];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }

    function get_evaluacion_periodo_empleado($id){
        $SQL = "SELECT empleado_id, padre_id, aplica_id FROM evaluacion_periodo_empleado WHERE id = '$id'";
        $query = $this->db->query($SQL);
        $row=[];
        if ($query->num_rows() > 0) {
            $row = $query->row();
        }
        return $row;
    }
}