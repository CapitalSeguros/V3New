<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class evaluacion_periodos_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function select()
    {
        /* $obj = $this->db
            ->where("estatus <>", "ELIMINADO")
            ->get('evaluacion_periodos'); */
        $obj = $this->db->query("select * from evaluacion_periodos where estatus <> 'ELIMINADO' order by fecha_inicio desc");
        return $obj->result_array();
    }

    function selectCerrados()
    {
        $obj = $this->db
            ->where_in("estatus", array("CERRADO", "LIBERADO"))
            ->get('evaluacion_periodos');
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

    function activo()
    {
        $obj = $this->db
            ->where("estatus", "CERRADO")
            ->order_by("id DESC")
            ->get('evaluacion_periodos');

        return $obj->row();
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
            IF(ISNULL(epe.fecha_finalizacion),0,1) complete ,
            e.titulo,
            e.descripcion,
            e.tipo_evaluacion_id,
            p.nombres empleado, 
            p.idPersonaPuesto, 
            pp.personaPuesto puesto,
            epr.porcentaje,
            epr.respuesta,
            epe.puesto_id,
            (select p.nombres from persona p where p.idPersona=epe.aplica_id) evaluador", false)
            ->where("periodo_id", $id)
            ->where("evaluacion_id", $evId)
            ->join("persona p", "epe.empleado_id = p.idPersona", "left")
            ->join("personapuesto pp", "p.idPersonaPuesto = pp.idPuesto", "left")
            ->join("evaluaciones e", "epe.evaluacion_id = e.id", "left")
            ->join("evaluacion_periodo_respuesta epr", "epe.id = epr.evaluacion_p_e_id", "left")
            ->get('evaluacion_periodo_empleado epe');
        return $obj->result();
    }

    function getCompleteTest($id, $evId)
    {
        $query = $this->db
            ->query("SELECT count(isnull(fecha_finalizacion)) completas,count(id) total  from evaluacion_periodo_empleado epe 
            where epe.evaluacion_id=" . $evId . " and epe.periodo_id=" . $id);

        return $query->result();
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
                    (select us.name_complete from users us where us.idPersona=epp.empleado_id) as evaluado,
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

    function selectEvaluacionesByEmpelado($idp, $id)
    {
        $obj = $this->db
            ->select("epe.*,
            e.titulo,
            e.descripcion,
            e.tipo_evaluacion_id,
            p.nombres empleado, 
            p.idPersonaPuesto, 
            pp.personaPuesto puesto,
            ep.fecha_inicio FechaInicio")
            ->where("epe.periodo_id", $idp)
            ->where("epe.aplica_id", $id)
            ->join("evaluacion_periodos ep", "epe.periodo_id = ep.id", "inner")
            ->join("evaluaciones e", "epe.evaluacion_id = e.id", "inner")
            ->join("evaluacion_tipo et", "et.id = e.tipo_evaluacion_id AND et.visible = 1", "inner")
            ->join("persona p", "epe.empleado_id = p.idPersona", "inner")
            ->join("personapuesto pp", "p.idPersonaPuesto = pp.idPuesto", "inner")
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
            ep.fecha_inicio FechaInicio")
            ->where("epe.periodo_id", $idp)
            ->where("epe.aplica_id", $id)
            ->where("fecha_finalizacion IS NULL")
            ->join("evaluacion_periodos ep", "epe.periodo_id = ep.id", "inner")
            ->join("evaluaciones e", "epe.evaluacion_id = e.id", "inner")
            ->join("persona p", "epe.empleado_id = p.idPersona", "inner")
            ->join("personapuesto pp", "p.idPersonaPuesto = pp.idPuesto", "inner")
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
            ->join("persona p", "epe.empleado_id = p.idPersona", "left")
            ->join("personapuesto pp", "p.idPersonaPuesto = pp.idPuesto", "left")
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
                    p.tipo_pregunta_id tipo,
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
                    INNER JOIN evaluacion_periodo_competencias epc ON epc.evaluacion_periodo_id = epe.periodo_id 
                    AND epe.puesto_id=epc.puesto_id
                WHERE epe.id = $id";//AND epc.competencias_id = epr.competencia_id
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

    function getusuariosEvaluados($idPeriodo)
    {
        $SQL = "SELECT epe.*,pp.personaPuesto,pp.idPuesto,avg(ifnull(epe.calificacion,0)) promedio,concat(p.nombres,' ',p.apellidoPaterno,' ',apellidoMaterno) nombres
        from evaluacion_periodo_empleado epe
        left join persona p on epe.empleado_id=p.idPersona
        left join personapuesto pp on p.idPersonaPuesto=pp.idPuesto
        where periodo_id=" . $idPeriodo . " group by empleado_id; ";
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
    function getusuariosEvaluadores($idPeriodo)
    {
        $SQL = "SELECT epp.calificacion,e.titulo,et.nombre,IF(ISNULL(epp.fecha_finalizacion),0,1) complete,epp.aplica_id,epp.empleado_id,
        epp.fecha_aplicacion,epp.fecha_finalizacion,concat(p.nombres,' ',p.apellidoPaterno,' ',apellidoMaterno) nombres
        from evaluacion_periodo_empleado epp
        inner join persona p on epp.aplica_id=p.idPersona
        inner join evaluaciones e on epp.evaluacion_id=e.id
        inner join evaluacion_tipo et on e.tipo_evaluacion_id=et.id
        where epp.periodo_id=" . $idPeriodo . " order by epp.empleado_id";
        $query = $this->db->query($SQL);

        return $query->result_array();
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

    function getTotalesEvaluacion($idPeriodo)
    {
        $SQL = "SELECT sum(isnull(fecha_finalizacion)) incomplete, count(id) total from evaluacion_periodo_empleado epe 
        where epe.periodo_id=" . $idPeriodo;
        $query = $this->db->query($SQL);

        return $query->result();
    }

    function get_EmpleadoByPuesto($id)
    {
        $tipos = $this->db->select("p.idPersona id, p.nombres nombre, p.fecIngresoPersona fecha_ingreso,p.idPersonaPuesto")
            ->where("p.bajaPersona", 0)
            ->where_in("p.idPersonaPuesto", $id)
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
            ->where("p.bajaPersona", 0)
            ->join("personapuesto pp", "pp.idPuesto=p.idPersonaPuesto", "inner")
            ->get('persona p');
        return $obj->row();
    }

    function getParentPersonas($id)
    {
        $obj = $this->db
            ->where("p.idPersonaPuesto", $id)
            ->where("p.bajaPersona", 0)
            ->get('persona p');
        return $obj->result();
    }
    function getPuestoSubordinados($id)
    {
        $obj = $this->db
            ->where("padrePuesto", $id)
            ->get('personapuesto');
        return $obj->result();
    }

    function getPersonasEvaluador($id)
    {
        $obj = $this->db
            ->where("idPersonaPuesto", $id)
            ->where("bajaPersona", 0)
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

    function getTipoPreguntaEvaluacion($id)
    {
        $tipos = $this->db->query('');
        return $tipos->result_array();
    }

    function CailiFEval($id)
    {
        $tipos = $this->db->query("SELECT * FROM evaluacion_periodos_puesto where evaluacion_periodo_id=" . $id . ";");
        return $tipos->result_array();
    }

    function getBono($calificacion, $Puesto)
    {
        $tipos = $this->db->query("select sueldo from tabulador_sueldos where calificacion<=" . $calificacion . " and puesto_id=" . $Puesto . " order by calificacion DESC limit 1;");
        $result = $tipos->result_array();
        if (empty($result)) {
            return [];
        } else {
            return $result[0];
        }
    }

    function getPeriodosN()
    {
        /* $tipos = $this->db->query("select  ep.id,
        (if(current_date()>=ep.fecha_inicio,true,false))Inicio,
        (if(current_date()>=ep.fecha_final,true,false)) termino, ep.dias_previos diasP,
        abs(timestampdiff(DAY,ep.fecha_inicio,current_date())) diasA
        from evaluacion_periodos ep where ep.estatus='LIBERADO' order by ep.fecha_inicio desc;"); */
        $tipos = $this->db->query("SELECT *, (if(fecha_inicio<=curdate(),1,0))estado,
        abs(timestampdiff(DAY,ep.fecha_inicio,current_date())) diasNoti
        from evaluacion_periodos ep 
        where ep.fecha_final>=curdate() and ep.estatus='LIBERADO' order by fecha_final ASC;");;
        return $tipos->result_array();
    }

    function getNoContestados($idP)
    {
        $tipos = $this->db->query("SELECT * from evaluacion_periodo_empleado evpe where evpe.periodo_id=" . $idP . " and evpe.calificacion is null;");;
        return $tipos->result_array();
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
        $periodosE = $this->db->query("SELECT ep.titulo,ep.id,epe.aplica_id,epe.empleado_id, 'EVALUADOR' tipo FROM 
        evaluacion_periodo_empleado epe
        INNER JOIN evaluacion_periodos ep ON epe.periodo_id=ep.id
        WHERE epe.aplica_id=" . $idpersona . " AND epe.calificacion IS NULL AND ep.estatus='LIBERADO' GROUP BY ep.id,epe.empleado_id,epe.aplica_id having count(*)>0 ");
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
        $query = "Select  ep.titulo,ep.id, epp.tipo,epe.aplica_id,epe.empleado_id from evaluacion_periodos_puesto epp 
        inner join evaluacion_periodos ep ON epp.evaluacion_periodo_id=ep.id
        inner join evaluacion_periodo_empleado epe on epp.evaluacion_periodo_id=epe.periodo_id
        where epp.puesto_id=" . $puesto . " and epp.tipo='EVALUADO' and ep.estatus='LIBERADO'  GROUP BY ep.id,epe.empleado_id,epe.aplica_id having count(*)>0;";
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


    ///obtener los evaluadores de la 360
    function getEvaluadores360($id)
    {
        $res = $this->db->query('select epe.periodo_id,epe.evaluacion_id,epe.empleado_id, epe.aplica_id, curdate() fecha_registro
       from evaluacion_periodo_empleado epe where epe.periodo_id=' . $id);
        return $res->result_array();
    }

    function getInfoPeriodo($idPeriodo)
    {
        $obj = $this->db->where("ep.id", $idPeriodo)
            ->get('evaluacion_periodos ep');
        return $obj->result();
    }


    function getnullEmpleado()
    {
        $obj = $this->db->where("ep.puesto_id IS NULL", null, false)
            ->get('evaluacion_periodo_empleado ep');
        return $obj->result_array();
    }

    function getPuestoPrueba($id)
    {
        $obj = $this->db->where("ep.idPersona", $id)
            ->get('persona ep');
        $res = $obj->result_array();
        return empty($res) ? null : $res[0]['idPersonaPuesto'];
        //return $obj->result_array();
    }

    function batchEvalPrueba($data)
    {
        $this->db->update_batch('evaluacion_periodo_empleado', $data, 'id');
    }

    function getPersonaResultado($id)
    {
        $sql = "select u.name_complete nombre,pp.personaPuesto puesto, p.idpersonarankingagente rank
        from evaluacion_periodo_empleado epe
        left join users u on epe.empleado_id=u.idPersona
        LEFT JOIN persona p ON epe.empleado_id=p.idPersona
        left join personapuesto pp ON p.idPersonaPuesto=pp.idPersonaPuesto
        where epe.id=" . $id;
        $consulta = $this->db->query($sql);
        return $consulta->result_array();
    }

    //Nuevo querys de la actualizacion
    function getRankActivo()
    {
        $sql = "SELECT pk.personaRankingAgente rank FROM personarankingagente pk WHERE pk.activoPRA=1";
        $consulta = $this->db->query($sql);
        return $consulta->result_array();
    }

    function getPersonasRank($rank)
    {
        $sql = "SELECT p.idPersonaPuesto puesto,p.userEmailCreacion creador,p.tipoPersona tipo_p ,p.idPersona id, u.name_complete FROM persona p 
        LEFT JOIN users u ON p.idPersona=u.idPersona
        WHERE p.idpersonarankingagente='" . $rank . "' AND p.bajaPersona=0 AND u.activated=1 AND u.banned=0 AND p.esAgenteColaborador=0 AND p.tipoPersona=3 AND p.idPersonaPuesto<>10";
        $consulta = $this->db->query($sql);
        return $consulta->result_array();
    }

    function getPersonaRank($idPersona)
    {
        $sql = "SELECT p.* FROM persona p WHERE p.idPersona=" . $idPersona ." and p.bajaPersona=0;";
        $consulta = $this->db->query($sql);
        return $consulta->row();
    }

    function findSuperiorRank($find)
    {
        $sql = "SELECT u.idPersona FROM users u WHERE u.email='" . $find . "' and u.activated=1 and u.banned=0";
        $consulta = $this->db->query($sql);
        return $consulta->row();
    }

    public function devolverPuestos($devolucion = NULL, $padrePuesto = null)
    {
        //$consulta="select * from personapuesto where statusPuesto=1 order by personaPuesto";

        if ($devolucion == null) {
            $consulta = 'select pp.*,c.idColaboradorArea,c.colaboradorArea,p.nombres,p.apellidoPaterno,p.apellidoMaterno  from personapuesto pp left join colaboradorarea c on c.idColaboradorArea=pp.idColaboradorArea left join persona p on p.idPersona=pp.idPersona where pp.statusPuesto=1 and pp.idPersona=' . $this->tank_auth->get_idPersona();

            $datos = $this->db->query($consulta)->result();
            $info = array();
            $idPadre = '';
            array_push($info, $datos[0]);
            while ((count($datos)) > 0) {
                $consulta = 'select pp.*,c.idColaboradorArea,c.colaboradorArea,p.nombres,p.apellidoPaterno,p.apellidoMaterno  from personapuesto pp left join colaboradorarea c on c.idColaboradorArea=pp.idColaboradorArea left join persona p on p.idPersona=pp.idPersona  where pp.statusPuesto=1 and pp.padrePuesto in (';
                $idPadre = '';
                foreach ($datos as $key => $value) {
                    if ($value === end($datos)) {
                        $idPadre .= $value->idPuesto;
                    } else {
                        $idPadre .= $value->idPuesto . ',';
                    }
                }
                $consulta .= $idPadre . ')';
                $datos = $this->db->query($consulta)->result();
                foreach ($datos as $key => $value) {
                    array_push($info, $value);
                }
            }
        } else {
            $complemento = '';
            if ($padrePuesto != null && $padrePuesto != 7) {
                $complemento = "AND pp.padrePuesto=" . $padrePuesto;
            }
            $consulta = 'select pp.*,c.idColaboradorArea,c.colaboradorArea ,p.nombres,p.apellidoPaterno,p.apellidoMaterno from personapuesto pp left join colaboradorarea c on c.idColaboradorArea=pp.idColaboradorArea left join persona p on p.idPersona=pp.idPersona where pp.statusPuesto=1 and pp.idPuesto!=1 and pp.idPuesto!=98 ' . $complemento;
            $info = $this->db->query($consulta)->result();
        }

        $respuesta = array();
        foreach ($info as $key => $value) {
            $nombre = $value->colaboradorArea;
            if (!isset($respuesta[$nombre])) {
                $respuesta[$nombre] = array();
            }
            array_push($respuesta[$nombre], $value);
        }
        // $fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($respuesta, TRUE));fclose($fp);   
        return $respuesta;
    }

    public function dataNotificacion($id, $idperiodo)
    {
        $res = new \stdClass();
        $sql = "SELECT epe.*, ep.titulo, e.tipo_evaluacion_id
        from evaluacion_periodo_empleado epe 
        LEFT JOIN evaluacion_periodos ep ON epe.periodo_id=ep.id 
        LEFT JOIN evaluaciones e ON epe.evaluacion_id=e.id 
        where epe.periodo_id='" . $idperiodo . "' and epe.id='" . $id . "' ";
        $consulta = $this->db->query($sql);
        $res->info = $consulta->row();

        $sql2 = "SELECT p.idpersonarankingagente, p.userEmailCreacion creador, u.IdSucursal, u.idCanal , p.idPersonaPuesto puesto, pp.padrePuesto, p.idPersona,u.name_complete
        from persona p 
        LEFT JOIN users u ON p.idPersona=u.idPersona
        LEFT JOIN personapuesto pp ON p.idPersonaPuesto=pp.idPuesto
        WHERE p.idPersona=" . $res->info->empleado_id;
        $consulta2 = $this->db->query($sql2);
        $res->usuario = $consulta2->row();

        return $res;
    }

    function selectPadre($idpuesto)
    {
        $sql = "SELECT p.*,u.*
        from persona p 
        LEFT JOIN users u ON p.idPersona=u.idPersona
        LEFT JOIN personapuesto pp ON p.idPersonaPuesto=pp.idPuesto
        WHERE p.idPersonaPuesto=" . $idpuesto;
        $consulta = $this->db->query($sql);
        return $consulta->row();
    }

    function selectPadreEmail($correo)
    {
        $sql = "SELECT p.*,u.*
        from persona p 
        LEFT JOIN users u ON p.idPersona=u.idPersona
        LEFT JOIN personapuesto pp ON p.idPersonaPuesto=pp.idPuesto
        WHERE u.username='$correo';";
        $consulta = $this->db->query($sql);
        return $consulta->row();
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

    //Metodoss para añadir las nuevas notificaciones
    function insertNnormal($data){
        $this->db->insert('notificacion', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function getPersona($id){
        $sql = "SELECT * FROM users u WHERE  idPersona ='$id';";
        $consulta = $this->db->query($sql);
        return $consulta->row();
    }

}
