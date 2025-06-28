<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class evaluacion_periodos_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function select()
    {
        $obj = $this->db
            ->where("estatus <>", "ELIMINADO")
            ->get('evaluacion_periodos');
        return $obj->result_array();
    }

    function selectCerrados($id)
    {

        /* $obj = $this->db
            ->where_in("estatus", array("CERRADO", "LIBERADO"))
            ->get('evaluacion_periodos'); */
        $obj = $this->db->query("select ep.* from evaluacion_periodos ep
             inner join evaluacion_periodo_empleado epe on ep.id=epe.periodo_id 
             where ep.estatus in ('CERRADO', 'LIBERADO') and epe.aplica_id=" . $id . " or epe.empleado_id=" . $id . " or epe.padre_id=" . $id . " group by ep.titulo order by ep.estatus,ep.fecha_inicio DESC limit 10");
        return $obj->result_array();
    }

    function select_listado_Cerrados()
    {
        $obj = $this->db
            ->where("estatus", "CERRADO")
            ->select("id value, titulo label")
            ->get('evaluacion_periodos');
        return $obj->result_array();
    }

    function existBytitulo($titulo)
    {
        $obj = $this->db
            ->where("titulo", $titulo)
            ->get('evaluacion_periodos');
        return $obj->num_rows() > 0;
    }

    function selectById($id, $full = null)
    {
        $rslt = null;
        $obj = $this->db
            ->where("id", $id)
            ->get('evaluacion_periodos');
        $rslt = $obj->row();

        if (gettype($full) == "string") {
            $epp = $this->db
                ->where("ep.evaluacion_periodo_id", $id)
                ->join("evaluaciones e", "ep.evaluacion_id=e.id", "inner")
                ->get("evaluacion_periodos_puesto ep");

            $rslt->evaluacion_puesto = $epp->result();

            $epc = $this->db
                ->where("evaluacion_periodo_id", $id)
                ->get("evaluacion_periodo_competencias");

            $rslt->evaluacion_competencias = $epc->result();
        }
        return $rslt;
    }

    function activo($id)
    {
        //cambios TIC_Consultores 17/03/2021
        /*  $obj = $this->db
            ->where("estatus", "CERRADO")
            ->order_by("id DESC")
            ->get('evaluacion_periodos');

        return $obj->row(); */
        $obj = $this->db->query("select ep.*
        from evaluacion_periodos ep
        left join evaluacion_periodo_empleado epe on ep.id=epe.periodo_id
        WHERE  ep.estatus in ('CERRADO','LIBERADO') and epe.aplica_id=" . $id . " or epe.empleado_id=" . $id . "
        group by ep.id
        ORDER BY ep.id DESC");
        $res = $obj->row();
        return $res;
    }

    function selectEvaluacionPuesto($id)
    {
        $obj = $this->db
            ->where("evaluacion_periodo_id", $id)
            ->get('evaluacion_periodos_puesto');
        return $obj->result();
    }
    function selectEvaluacionEmpleado($id, $evId)
    {
        $obj = $this->db
            ->where("periodo_id", $id)
            ->where("evaluacion_id", $evId)
            ->get('evaluacion_periodo_empleado');
        return $obj->result();
    }

    function selectEvaluacionEmpleadoEstado($id, $evId)
    {
        $obj = $this->db
            ->select("epe.*,
                e.titulo,
                e.descripcion,
                e.tipo_evaluacion_id,
                p.nombres empleado, 
                p.idPersonaPuesto, 
                pp.personaPuesto puesto,
                epr.porcentaje,
                epr.respuesta")
            ->where("periodo_id", $id)
            ->where("evaluacion_id", $evId)
            ->join("persona p", "epe.empleado_id = p.idPersona", "inner")
            ->join("personapuesto pp", "p.idPersonaPuesto = pp.idPuesto", "inner")
            ->join("evaluaciones e", "epe.evaluacion_id = e.id", "inner")
            ->join("evaluacion_periodo_respuesta epr", "epe.id = epr.evaluacion_p_e_id", "left")
            ->get('evaluacion_periodo_empleado epe');

        return $obj->result();
    }

    function selectEvaluacionByEmpleado($idP, $id)
    {
        $query = $this->db
            ->query("SELECT 
                    epp.periodo_id, 
                    epp.evaluacion_id, 
                    epp.empleado_id,
                    ep.fecha_final,
                    ep.fecha_inicio,
                    e.titulo,
                    COUNT(epp.periodo_id) = SUM(IF(epp.fecha_finalizacion IS NOT NULL,1,0)) complete
                FROM 
                    evaluacion_periodo_empleado epp 
                    INNER JOIN evaluacion_periodos ep ON epp.periodo_id=ep.id
                    INNER JOIN evaluaciones e ON e.id = epp.evaluacion_id
                    INNER JOIN evaluacion_tipo et ON e.tipo_evaluacion_id = et.id AND et.visible = 1
                WHERE 
                    epp.periodo_id = $idP AND 
                    epp.empleado_id = $id
                GROUP BY epp.empleado_id");

        return $query->result();
    }

    function selectEvaluacionAllByEmpleado($idP, $id, $tipo)
    {
        $SQL = "SELECT 
                    epp.id,
                    epp.periodo_id, 
                    epp.evaluacion_id, 
                    epp.empleado_id,
                    e.titulo,
                    epp.fecha_aplicacion,
                    epp.fecha_finalizacion,
                    epp.aplica_id,
                    epp.calificacion,
                    u.name_complete,
                    IF(epp.fecha_finalizacion IS NOT NULL,1,0) complete
                FROM 
                    evaluacion_periodo_empleado epp 
                    INNER JOIN evaluaciones e ON e.id = epp.evaluacion_id
                    INNER JOIN evaluacion_tipo et ON e.tipo_evaluacion_id = et.id AND et.visible = 1
                    INNER JOIN users u ON u.idPersona = epp.aplica_id
                WHERE
                    e.tipo_evaluacion_id = $tipo AND
                    epp.periodo_id = $idP AND 
                    epp.empleado_id = $id";

        $query = $this->db->query($SQL);
        return $query->result();
    }

    function getPromedioEvaluaciones($idPeriodo, $evaluado)
    {
        $SQL = "SELECT avg(ifnull(epp.calificacion,0)) promedio, et.nombre,count(tipo_evaluacion_id) total, e.id
        from evaluacion_periodo_empleado epp
        inner join evaluaciones e on epp.evaluacion_id=e.id
        inner join evaluacion_tipo et on e.tipo_evaluacion_id=et.id
        where epp.periodo_id=" . $idPeriodo . " and epp.empleado_id=" . $evaluado . "
        group by epp.evaluacion_id";
        $query = $this->db->query($SQL);

        return $query->result_array();
    }

    function selectEvaluacionesByEmpelado($idp, $id)
    {
        $obj = $this->db
            ->select("epe.*,
            e.titulo,
            e.descripcion,
            e.tipo_evaluacion_id,
            CONCAT(p.nombres, ' ', p.apellidoPaterno, ' ', p.apellidoMaterno) empleado, 
            p.idPersonaPuesto, 
            pp.personaPuesto puesto,
            ep.fecha_inicio FechaInicio,
            ep.tiempo_evaluacion FechaFin,
            e.tipo_evaluacion_id", FALSE) //  ep.fecha_final FechaFin
            ->where("epe.periodo_id", $idp)
            ->where("epe.aplica_id", $id)
            ->or_where("epe.padre_id",$id)
            ->join("evaluacion_periodos ep", "epe.periodo_id = ep.id", "inner")
            ->join("evaluaciones e", "epe.evaluacion_id = e.id", "inner")
            ->join("evaluacion_tipo et", "et.id = e.tipo_evaluacion_id AND et.visible = 1", "inner")
            ->join("persona p", "epe.empleado_id = p.idPersona", "left")
            ->join("personapuesto pp", "p.idPersonaPuesto = pp.idPuesto", "left")
            ->order_by("ep.fecha_inicio","desc")
            ->get('evaluacion_periodo_empleado epe');

        return $obj->result();
    }

    function selectEvaluacionesByEmpeladoPendiente($idp, $id)
    {
        $obj = $this->db
            ->select("epe.*,
            e.titulo,
            e.descripcion,
            e.tipo_evaluacion_id,
            p.nombres empleado, 
            p.idPersonaPuesto, 
            pp.personaPuesto puesto,
            ep.fecha_inicio FechaInicio,
            ep.tiempo_evaluacion FechaFin") //ep.fecha_final FechaFin
            ->where("epe.periodo_id", $idp)
            ->where("epe.aplica_id", $id)
            ->where("fecha_finalizacion IS NULL")
            ->join("evaluacion_periodos ep", "epe.periodo_id = ep.id", "inner")
            ->join("evaluaciones e", "epe.evaluacion_id = e.id", "inner")
            ->join("persona p", "epe.empleado_id = p.idPersona", "inner")
            ->join("personapuesto pp", "p.idPersonaPuesto = pp.idPuesto", "inner")
            ->order_by("ep.fecha_inicio","desc")
            ->get('evaluacion_periodo_empleado epe');
        return $obj->result();
    }




    function selectEvaluacionEmpleadoByEmpleadoId($id, $idp)
    {
        $obj = $this->db
            ->select("epe.*,
        e.titulo,
        e.descripcion,
        e.tipo_evaluacion_id,
        p.nombres empleado, 
        p.idPersonaPuesto, 
        pp.personaPuesto puesto")
            ->where("epe.empleado_id", $id)
            ->where("epe.periodo_id", $idp)
            ->join("evaluaciones e", "epe.evaluacion_id = e.id", "inner")
            ->join("persona p", "epe.empleado_id = p.idPersona", "inner")
            ->join("personapuesto pp", "p.idPersonaPuesto = pp.idPuesto", "inner")
            ->get('evaluacion_periodo_empleado epe');

        return $obj->result();
    }

    function selectEvaluacionEmpleadoById($id)
    {
        $obj = $this->db
            ->select("epe.*,
        e.titulo,
        e.descripcion,
        e.tipo_evaluacion_id,
        p.nombres empleado, 
        p.idPersonaPuesto, 
        pp.personaPuesto puesto,")
            ->where("epe.id", $id)
            ->join("evaluaciones e", "epe.evaluacion_id = e.id", "inner")
            ->join("persona p", "epe.empleado_id = p.idPersona", "inner")
            ->join("personapuesto pp", "p.idPersonaPuesto = pp.idPuesto", "inner")
            ->get('evaluacion_periodo_empleado epe');

        return $obj->row();
    }

    function add($data)
    {
        $this->db->insert('evaluacion_periodos', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('evaluacion_periodos', $data);
    }

    function updateEvaluacionEmpleado($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('evaluacion_periodo_empleado', $data);
    }

    function delete($id)
    {
        $result = new \stdClass();
        $result->ok = false;
        $result->message = "No puedes dar de baja el periodo";
        $qury = $this->db
            ->select("id")
            ->where("estatus", "BORRADOR")
            ->where("id", $id)
            ->get("evaluacion_periodos");

        if ($qury->num_rows) {
            $this->db->where('id', $id);
            $result->ok = $this->db->update("evaluacion_periodos", array("estatus" => "ELIMINADO"));
            $result->message = "Se proceso con exíto la baja del registro.";
            return $result;
        }
        return $result;
    }

    function close($id)
    {
        $result = new \stdClass();
        $result->ok = false;
        $result->message = "No puedes dar de baja el periodo";
        $qury = $this->db
            ->select("id")
            ->where("estatus", "LIBERADO")
            ->where("id", $id)
            ->get("evaluacion_periodos");

        if ($qury->num_rows) {
            $this->db->where('id', $id);
            $result->ok = $this->db->update("evaluacion_periodos", array("estatus" => "CERRADO", "modified" => date("Y-m-d H:i:s")));
            $result->message = "Se proceso con exíto la baja del registro.";
            return $result;
        }
        return $result;
    }

    function getRespuestasEmpleadoByid($id)
    {
        $SQL = "SELECT 
                    c.id,
                    c.titulo competencia,
                    p.titulo pregunta,
                    p.json_content,
                    p.id,
                    epr.porcentaje,
                    epr.respuesta,
                    epc.grado
                FROM 
                    evaluacion_periodo_empleado epe
                    INNER JOIN evaluacion_periodo_respuestas epr ON epe.id = epr.evaluacion_p_e_id
                    INNER JOIN competencias c ON epr.competencia_id = c.id
                    INNER JOIN preguntas p ON p.id = epr.pregunta_id
                    INNER JOIN evaluacion_periodo_competencias epc ON epc.evaluacion_periodo_id = epe.periodo_id AND epc.competencias_id = epr.competencia_id
                WHERE epe.id = $id";
        $query = $this->db->query($SQL);
        return $query->result_array();
    }

    function getResultadoByEmpleado($periodoId, $id)
    {
        $SQL = "SELECT
                    temp.empleado_id,
                    SUM(temp.cal_ponderado) calificacion
                FROM(
                SELECT 
                    epp.evaluacion_id,
                    epe.empleado_id,
                    IFNULL(AVG(epe.calificacion) * (epp.valor/100),0) cal_ponderado
                FROM evaluacion_periodo_empleado epe
                INNER JOIN evaluacion_periodos_puesto epp ON 
                    epe.evaluacion_id = epp.evaluacion_id AND 
                    epp.evaluacion_periodo_id = epe.periodo_id AND
                    epp.tipo = 'EVALUADO'
                WHERE 
                    epe.periodo_id = $periodoId AND
                    epe.empleado_id = $id 
                GROUP BY epp.evaluacion_id, epe.empleado_id
                ) temp
                GROUP BY temp.empleado_id;";

        $query = $this->db->query($SQL);
        return $query->row();
    }
    function get_evaluacionesByPeriodo($idPeriodo)
    {
        $SQL = "SELECT 
                    e.id,
                    e.titulo,
                    e.tipo_evaluacion_id,
                    et.nombre
                FROM evaluacion_periodo_empleado epp
                INNER JOIN evaluaciones e ON epp.evaluacion_id = e.id
                INNER JOIN evaluacion_tipo et ON et.id = e.tipo_evaluacion_id 
                WHERE epp.periodo_id = $idPeriodo
                GROUP BY epp.evaluacion_id";
        $query = $this->db->query($SQL);

        return $query->result();
    }

    function get_evaluacionesEmpleadoByPeriodo($idPeriodo)
    {
        $SQL = "SELECT 
                    e.id,
                    e.titulo,
                    e.tipo_evaluacion_id,
                    et.nombre
                FROM evaluacion_periodo_empleado epp
                INNER JOIN evaluaciones e ON epp.evaluacion_id = e.id
                INNER JOIN evaluacion_tipo et ON et.id = e.tipo_evaluacion_id 
                WHERE epp.periodo_id = $idPeriodo
                GROUP BY epp.evaluacion_id";
        $query = $this->db->query($SQL);

        return $query->result();
    }

    function get_evaluacionesByEmpleado($idPeriodo, $empleado_id)
    {
        $SQL = "SELECT 
                    e.id,
                    e.titulo,
                    e.tipo_evaluacion_id,
                    et.nombre
                FROM evaluacion_periodo_empleado epp
                INNER JOIN evaluaciones e ON epp.evaluacion_id = e.id
                INNER JOIN evaluacion_tipo et ON et.id = e.tipo_evaluacion_id 
                WHERE epp.periodo_id = $idPeriodo AND
                    epp.empleado_id = $empleado_id
                GROUP BY epp.evaluacion_id";
        $query = $this->db->query($SQL);

        return $query->result();
    }

    function get_EmpleadoByPuesto($id)
    {
        $tipos = $this->db->select("p.idPersona id, p.nombres nombre, p.fecIngresoPersona fecha_ingreso,p.idPersonaPuesto")
            ->where_in("idPersonaPuesto", $id)
            ->get('persona p');

        return $tipos->result_array();
    }

    function addEvaluacionCompetenciasBatch($data)
    {
        if (count($data) > 0) {
            return $this->db->insert_batch('evaluacion_periodo_competencias', $data);
        }
        return true;
    }
    function addEvaluacionEmpleadosBatch($data)
    {
        if (count($data) > 0) {
            return $this->db->insert_batch('evaluacion_periodo_empleado', $data);
        }
        return true;
    }
    function addEvaluacionPuestosBatch($data)
    {
        if (count($data) > 0) {
            return $this->db->insert_batch('evaluacion_periodos_puesto', $data);
        }
        return true;
    }

    function deleteEvaluacionCompetenciasBatch($id)
    {
        return $this->db
            ->where("evaluacion_periodo_id", $id)
            ->delete('evaluacion_periodo_competencias');
    }
    function deleteEvaluacionEmpleadosBatch($id)
    {
        return $this->db
            ->where("periodo_id", $id)
            ->delete('evaluacion_periodo_empleado');
    }
    function deleteEvaluacionPuestosBatch($id)
    {
        return $this->db
            ->where("evaluacion_periodo_id", $id)
            ->delete('evaluacion_periodos_puesto');
    }
    //metodos nuevos para liberar periodo
    function getIdParentPuesto($id)
    {
        $obj = $this->db
            ->select("pp.*")
            ->where("p.idPersona", $id)
            ->join("personapuesto pp", "pp.idPuesto=p.idPersonaPuesto", "inner")
            ->get('persona p');
        return $obj->row();
    }

    function getParentPersonas($id)
    {
        $obj = $this->db
            ->where("idPersonaPuesto", $id)
            ->get('persona');
        return $obj->result();
    }

    function getPersonasEvaluador($id)
    {
        $obj = $this->db
            ->where("idPersonaPuesto", $id)
            ->get('persona');
        return $obj->result();
    }

    function allTypePuestoCompetencia($id)
    {
        $tipos = $this->db->query('select ep.*,et.id as tipo_evaluacion,et.nombre,e.titulo,e.id
        from evaluacion_periodos_puesto ep, evaluaciones e, evaluacion_tipo et
        where ep.evaluacion_id=e.id and e.tipo_evaluacion_id=et.id and ep.evaluacion_periodo_id="' . $id . '"');
        return $tipos->result_array();
    }

    function getPersonas($idpuesto)
    {
        $tipos = $this->db->query('select u.name_complete,pp.personaPuesto,p.idPersona,pp.idPuesto from persona p, personapuesto pp, users u
        where u.idPersona=p.idPersona and pp.idPuesto=p.idPersonaPuesto and p.idPersonaPuesto="' . $idpuesto . '"');
        return $tipos->result_array();
    }
    function getdataEvaluacion($id, $puesto)
    {
        $obj = $this->db
            ->select("e.*,pp.personaPuesto")
            ->where("e.id", $id)
            ->where("ep.puesto_id", $puesto)
            ->join("evaluacion_periodos_puesto ep", "e.id=ep.evaluacion_id", "inner")
            ->join("personapuesto pp", "ep.puesto_id=pp.idPuesto", "inner")
            ->get('evaluaciones e');
        return $obj->result();
    }

    function getPuesto($id)
    {
        $obj = $this->db
            ->select('pp.personaPuesto')
            ->where("pp.idPuesto", $id)
            ->get('personapuesto pp');
        return $obj->result();
    }

    function getInfoPerido($id)
    {
        $tipos = $this->db->query('select p.titulo,p.comentario,p.estatus from evaluacion_periodos p where p.id="' . $id . '"');
        return $tipos->result_array();
    }

    function getEvalaudores360($idUsr, $idEva, $idPe)
    {
        $tipos = $this->db->query('select u.name_complete,pe.aplica_id as idPersona, p.idPersonaPuesto, pe.id
        from evaluacion_periodo_empleado pe, persona p, users u 
        where u.idPersona=pe.aplica_id and p.idPersona=pe.empleado_id 
        and pe.empleado_id="' . $idUsr . '" and pe.evaluacion_id="' . $idEva . '" and pe.periodo_id="' . $idPe . '"');
        return $tipos->result_array();
    }

    function insertEval360($data)
    {
        $this->db->insert('evaluacion_periodo_empleado', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function deleteEval360($id)
    {
        return $this->db
            ->where("id", $id)
            ->delete('evaluacion_periodo_empleado');
    }

    function getPeriodosLiberados()
    {
        $obj = $this->db
            ->select('ep.*')
            ->where("ep.estatus", "LIBERADO")
            ->get('evaluacion_periodos ep');
        return $obj->result();
    }

    function getEvaluadores($periodo, $puesto)
    {
        $tipos = $this->db->query("select pp.personaPuesto from evaluacion_periodos_puesto epp
        inner join  evaluacion_periodos ep on epp.evaluacion_periodo_id=ep.id
        inner join personapuesto pp on epp.puesto_id=pp.idPuesto 
        where epp.tipo='EVALUADOR' and epp.evaluacion_periodo_id=" . $periodo);
        $res = $tipos->result_array();
        $return = array();
        array_push($return, $this->padrePuesto($puesto));
        foreach ($res as $key => $value) {
            array_push($return, $value["personaPuesto"]);
        }
        return $return;
    }

    function padrePuesto($puesto)
    {
        $tipos = $this->db->query("select personapuesto,padrePuesto from personapuesto
        where idPuesto=" . $puesto);
        $ARadre = $tipos->result_array();

        $tipos2 = $this->db->query("select personapuesto,padrePuesto from personapuesto
        where idPuesto=" . $ARadre[0]["padrePuesto"]);
        $ARadre2 = $tipos2->result_array();

        return $ARadre2[0]["personapuesto"];
    }

    function ntMyInfo($puesto, $idpersona)
    {
        $allReturn = array();
        /* $periodosE = $this->db->query("SELECT ep.titulo,ep.id,epe.aplica_id,epe.empleado_id, 'EVALUADOR' tipo FROM 
        evaluacion_periodo_empleado epe
        INNER JOIN evaluacion_periodos ep ON epe.periodo_id=ep.id
        WHERE epe.aplica_id=".$idpersona." AND epe.calificacion IS NULL AND ep.estatus='LIBERADO' GROUP BY ep.id,epe.empleado_id,epe.aplica_id having count(*)>0"); */
        $periodosE = $this->db->query("SELECT ep.titulo,ep.id,epe.aplica_id,epe.empleado_id, 'EVALUADOR' tipo FROM 
        evaluacion_periodo_empleado epe
        INNER JOIN evaluacion_periodos ep ON epe.periodo_id=ep.id
        WHERE epe.aplica_id=" . $idpersona . " AND epe.calificacion IS NULL AND ep.estatus='LIBERADO' GROUP BY ep.id;");
        $TPE = $periodosE->result_array();

        $peridosArr = array();

        //evalauciones normales con puesto
        foreach ($TPE as $key => $value) {
            array_push($peridosArr, $value["id"]);
            $allReturn[] = array(
                "perido" => $value["titulo"],
                "id" => $value["id"],
                "tipo" => $value["tipo"],
                "puestos" => array(),
                "empleado_id" => $value["empleado_id"],
                "aplica_id" => $value["aplica_id"]
            );
        }
        //cuando se agrega un exterior en la 360
        /* $query="Select  ep.titulo,ep.id, epp.tipo,epe.aplica_id,epe.empleado_id from evaluacion_periodos_puesto epp 
        inner join evaluacion_periodos ep ON epp.evaluacion_periodo_id=ep.id
        inner join evaluacion_periodo_empleado epe on epp.evaluacion_periodo_id=epe.periodo_id
        where epp.puesto_id=".$puesto." and epp.tipo='EVALUADO' and ep.estatus='LIBERADO' GROUP BY ep.id,epe.empleado_id,epe.aplica_id having count(*)>0;"; */
        $query = "Select  ep.titulo,ep.id, epp.tipo,epe.aplica_id,epe.empleado_id from evaluacion_periodos_puesto epp 
        inner join evaluacion_periodos ep ON epp.evaluacion_periodo_id=ep.id
        inner join evaluacion_periodo_empleado epe on epp.evaluacion_periodo_id=epe.periodo_id
        where epp.puesto_id=" . $puesto . " and epp.tipo='EVALUADO' and ep.estatus='LIBERADO' GROUP BY ep.id;";
        /* if(!empty($peridosArr)){
            $query=$query+" and epe.perido_id NOT IN (".implode(",",$peridosArr).")";
        } */
        $consulta = $this->db->query($query);
        $res = $consulta->result_array();
        foreach ($res as $key => $val) {
            $allReturn[] = array(
                "perido" => $val["titulo"],
                "tipo" => $val["tipo"],
                "id" => $val["id"],
                "puestos" => $this->getEvaluadores($val["id"], $puesto),
                "empleado_id" => $val["empleado_id"],
                "aplica_id" => $val["aplica_id"]
            );
        }

        return $allReturn;
    }

    //Actualizacion Miguel Avila
    /* function getEvalPosterior($usuario, $tipo_eval)
    {
        $tipos = $this->db->query("SELECT epm.id,e.titulo,epm.fecha_finalizacion,epm.fecha_aplicacion,epm.calificacion,u.name_complete empleado, pp.personaPuesto puesto, ep.fecha_final FechaFin, ep.fecha_inicio FechaInicio
        FROM evaluacion_periodo_empleado epm
        LEFT JOIN evaluacion_periodos ep ON epm.periodo_id=ep.id
        LEFT JOIN evaluaciones e ON epm.evaluacion_id=e.id
        LEFT JOIN users u ON epm.empleado_id=u.idPersona
        LEFT JOIN persona p ON epm.empleado_id=p.idPersona
        LEFT JOIN personapuesto pp ON p.idPersonaPuesto=pp.idPuesto
        WHERE epm.empleado_id=" . $usuario . " AND e.tipo_evaluacion_id=" . $tipo_eval . "
        AND epm.fecha_finalizacion IS NOT NULL ORDER BY epm.id DESC LIMIT 5");
        return $tipos->result();
    } */

    function getEvalPosterior($usuario, $tipo_eval,$seguimiento)
    {
        $opcionNueva="";
        if($seguimiento!="NA"){
            $opcionNueva=" AND  epm.id<>'".$seguimiento."' ";
        }

        $tipos = $this->db->query("SELECT epm.id,e.titulo,epm.fecha_finalizacion,epm.fecha_aplicacion,epm.calificacion,u.name_complete empleado, pp.personaPuesto puesto, ep.fecha_final FechaFin, ep.fecha_inicio FechaInicio
        FROM evaluacion_periodo_empleado epm
        LEFT JOIN evaluacion_periodos ep ON epm.periodo_id=ep.id
        LEFT JOIN evaluaciones e ON epm.evaluacion_id=e.id
        LEFT JOIN users u ON epm.empleado_id=u.idPersona
        LEFT JOIN persona p ON epm.empleado_id=p.idPersona
        LEFT JOIN personapuesto pp ON p.idPersonaPuesto=pp.idPuesto
        WHERE epm.empleado_id=" . $usuario . " AND e.tipo_evaluacion_id=" . $tipo_eval . "
        AND YEAR(ep.fecha_final) = YEAR(NOW()) " . $opcionNueva . "
        AND epm.fecha_finalizacion IS NOT NULL ORDER BY ep.fecha_final desc");
        return $tipos->result();
    }

    function selectEvaluacionesByEmpeladoPendienteNew($idp, $id)
    {
        $obj = $this->db
            ->select("epe.*,
        e.titulo,
        e.descripcion,
        e.tipo_evaluacion_id,
        CONCAT(p.nombres, ' ', p.apellidoPaterno, ' ', p.apellidoMaterno) empleado, 
        p.idPersonaPuesto, 
        pp.personaPuesto puesto,
        ep.fecha_inicio FechaInicio,
        ep.tiempo_evaluacion FechaFin,
        e.tipo_evaluacion_id", FALSE) //  ep.fecha_final FechaFin
            //->where("epe.periodo_id", $idp)
            ->where("epe.aplica_id", $id)
            ->where("fecha_finalizacion IS NULL")
            ->where("ep.fecha_inicio >=",date("Y-m-d"))
            ->join("evaluacion_periodos ep", "epe.periodo_id = ep.id", "inner")
            ->join("evaluaciones e", "epe.evaluacion_id = e.id", "inner")
            ->join("evaluacion_tipo et", "et.id = e.tipo_evaluacion_id AND et.visible = 1", "inner")
            ->join("persona p", "epe.empleado_id = p.idPersona", "left")
            ->join("personapuesto pp", "p.idPersonaPuesto = pp.idPuesto", "left")
            ->order_by("ep.fecha_inicio","desc")
            ->get('evaluacion_periodo_empleado epe');

        return $obj->result();
    }

    public function obtener($id, $full = null)
	{
		$query = $this->db->where("u.idPersona", $id)
			->where("u.activated",1)
			->where("u.banned",0)
			//->where("p.tipoPersona",1)
			->select("p.*,u.name_complete")
			->join("users u", "u.idPersona = p.idPersona", "inner")
			->get("persona p");

		$rslt = $query->row();

		if (gettype($full) == "string") {
			$epp = $this->db
				->where("pp.idPuesto", $rslt->idPersonaPuesto)
				->get("personapuesto pp");

			$rslt->puesto = $epp->row();
		}

		return $query->row();
	}
}
