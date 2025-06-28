<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class incidenciasModel extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    //obtienes el tipo de incidencia 
    function getTipoIncidencias()
    {
        $tipos = $this->db->get('tipo_incidencias');
        return $tipos->result_array();
    }

    // function getEmpleados()
    // {
    //     $this->db->where("activated", 1);
    //     $this->db->where("banned", 0);
    //     $this->db->select("idPersona as value,name_complete as label");
    //     $tipos = $this->db->get('users');
    //     return $tipos->result_array();
    // }

    function getIncidencia($empleado_id, $fecha, $dia, $tipo)
    {
        $result = $this->db->where('empleado_id', $empleado_id)
            ->where('fecha_inicio', $fecha)
            ->where('dias', $dia)
            ->where('tipo_incidencias_id', $tipo)
            ->where('estatus', 'AUTORIZADO')
            ->select('idincidencias')
            ->get("incidencias");
        return $result->row();
    }
    //inserta las incidencia
    function insertIncidencias($datos)
    {
        $this->db->insert('incidencias', $datos);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function getIncidenciasTable()
    {
        $this->db->select('tipo_incidencias.nombre, incidencias.idincidencias as id, incidencias.empleado_id, incidencias.tipo_incidencias_id, incidencias.fecha_inicio, incidencias.dias, users.name_complete,incidencias.comentario, incidencias.estatus');
        $this->db->from('incidencias');
        //$this->db->where('estatus IN ("ACTIVO")');
        $this->db->join('tipo_incidencias', 'incidencias.tipo_incidencias_id = tipo_incidencias.id');
        $this->db->join('users', 'incidencias.empleado_id = users.idPersona');
        $this->db->order_by('incidencias.fecha_inicio', 'desc');
        $tabla = $this->db->get();
        return $tabla->result_array();
    }

    //obtiene todas las incidencias de un usuario especifico
    function getUserIncidenciasByUsuario($id)
    {
        $this->db->select('incidencias.*,tipo_incidencias.*,users.name_complete');
        $this->db->from('incidencias');
        //$this->db->where('estatus IN ("ACTIVO")');
        $this->db->join('tipo_incidencias', 'incidencias.tipo_incidencias_id = tipo_incidencias.id');
        $this->db->join('users', 'incidencias.empleado_id = users.id');
        $this->db->order_by('incidencias.fecha_inicio', 'desc');
        $tabla = $this->db->get();
        return $tabla->result_array();
    }
    //------------------------ //Dennis Castillo [2022-03-23]
    function getUserIncidenciasByUsuarioAlterno($id)
    {
        $this->db->select('incidencias.*,tipo_incidencias.*,users.name_complete');
        $this->db->from('incidencias');
        //$this->db->where('estatus IN ("ACTIVO")');
        $this->db->join('tipo_incidencias', 'incidencias.tipo_incidencias_id = tipo_incidencias.id');
        $this->db->join('users', 'incidencias.empleado_id = users.idPersona');
        $this->db->order_by('incidencias.fecha_inicio', 'desc');
        $tabla = $this->db->get();
        return $tabla->result_array();
    }
    //------------------------
    //metodos de para el modal de aprobación de las incidencias
    function getDataIncidencia($id)
    {
        $this->db->select('incidencias.*,tipo_incidencias.*,users.name_complete');
        $this->db->from('incidencias');
        $this->db->where('incidencias.idincidencias', $id);
        $this->db->join('tipo_incidencias', 'incidencias.tipo_incidencias_id = tipo_incidencias.id');
        $this->db->join('users', 'incidencias.empleado_id = users.idPersona');
        $tabla = $this->db->get();
        return $tabla->row();
    }

    function insertDocument($datos)
    {
        if (!$this->db->insert('documentos', $datos)) {
            return false;
        }
        return true;
    }

    function getDocuments($ref, $ref_id, $usr_id)
    {
        $this->db->select('*');
        $this->db->from('documentos');
        $array = array('referencia_id' => $ref_id, 'referencia' => $ref, 'usuario_alta_id' => $usr_id);
        $this->db->where($array);
        $tabla = $this->db->get();
        return $tabla;
    }

    //metodos que sirven en la parte de tipos_incidencia
    function inserTipoIncidencia($data)
    {
        if (!$this->db->insert('tipo_incidencias', $data)) {
            return false;
        }
        return true;
    }

    //Elimina el tipo de incidencia del sistema
    function EliminarTipoInicidencia($id)
    {
        if (!$this->db->delete('tipo_incidencias', array('id' => $id))) {
            return false;
        }
        return true;
    }
    //obtiene la información de un tipo de incidencia especifico
    function getTipoIncidencia($id)
    {
        $this->db->select();
        $this->db->from('tipo_incidencias');
        $this->db->where('id', $id);
        $tabla = $this->db->get();

        return $tabla->row();
    }
    //edita los tipos de incidencia
    function editTipoincidencia($id, $data)
    {
        $this->db->set($data);
        $this->db->where('id', $id);
        return $this->db->update('tipo_incidencias');
    }
    function editIncidencia($id, $data)
    {
        $this->db->set($data);
        $this->db->where('idincidencias', $id);
        return $this->db->update('incidencias');
    }
    //inserta los tipos de incidencias
    function insertTipoIncidencia($datos)
    {
        if (!$this->db->insert('tipo_incidencias', $datos)) {
            return false;
        }
        return true;
    }

    //obtiene los documentos del mismo dia que la incidencia ocurrio
    function getDocumentosIncidencia($id, $ref = "INCIDENCIAS")
    {
        //$algo="'/".$fecha."'/";
        $this->db->select('nombre_completo,ruta_completa');
        $this->db->from('documentos');
        $this->db->where(array('referencia_id' => $id, 'referencia' => $ref));
        $tabla = $this->db->get();

        return $tabla->result_array();
    }

    //modelo para la acreditacion de una incidencia
    function updateEstadoIncidencia($data, $id)
    {
        $this->db->where('idincidencias', $id);
        $res = $this->db->update('incidencias', $data);
        //$this->db->set($data);
        //$this->db->where('idincidencias', $id);
        //$res=$this->db->update('incidencias');
        return $res;
    }

    //metodo que obtine todas las incidencias
    function getAllIncidencias()
    {
        $this->db->select();
        $this->db->from('incidencias');
        $res = $this->db->get();
        return $res->result_array();
    }

    function getLastIndexTable($nameTable)
    {
        $res = $this->db->get($nameTable);
        return $res->num_rows() + 1;
    }

    function getLastMaxIndexTable($nameTable)
    {
        $res = $this->db->select_max('id')->get($nameTable)->row()->id;
        return $res + 1;
    }

    function validOnMinute($empleado_id, $fecha)
    {
        $this->db->where("fecha", $fecha);
        $this->db->where("empleado_id", $empleado_id);
        $query = $this->db->get("incidencias_on_minute");
        return $query->num_rows() > 0;
    }

    function postOnMinute($data)
    {
        $result = new \stdClass();
        $result->ok = false;
        $data_insert = array();
        foreach ($data as $key => $value) {
            if ($this->validOnMinute($value["empleado_id"], $value["fecha"])) {
                unset($data[$key]);
            } else {
                $obInc = $this->getIncidencia($value["empleado_id"], $value["fecha"], 1, $value["tipo_incidencia_id"]);
                if ($obInc != null) {
                    $this->editIncidencia($obInc->idincidencias, array(
                        "justificado" => true
                    ));
                } else {
                    if ($value["tipo_incidencia_id"] != null) {
                        $this->insertIncidencias(array(
                            "tipo_incidencias_id" => $value["tipo_incidencia_id"],
                            "estatus" => "ACTIVO",
                            "estado" => "AUTO",
                            "justificado" => false,
                            "fecha_inicio" => $value["fecha"],
                            "dias" => 1,
                            "comentario" => $value["incidencia"],
                            "fecha_alta" => date("Y-m-d"),
                            "fecha_ultima_modificacion" => date("Y-m-d"),
                            "empleado_id" =>  $value["empleado_id"]
                        ));
                    }
                }
                unset($value["tipo_incidencia_id"]);
                unset($value["empleado"]);
                unset($value["incidencia"]);
                array_push($data_insert, $value);
            }
        }
        if (count($data) > 0)
            $result->ok = $this->db->insert_batch('incidencias_on_minute', $data_insert);

        $result->data = $data;
        return $result;
    }

    function getEmpleadoOnTheMinute($id)
    {
        $result = $this->db->where("idOnTheMinute", $id)
            ->get("personaontheminute");

        return $result->row();
    }

    function getIncidenciasSinJustificar()
    {
        $result = $this->db->where('justificado', 0)
            ->where('estado', 'AUTO')
            ->where("estatus <> 'RECHAZADO'")
            ->get("incidencias");

        return $result->result();
    }

    function getIncidenciasJustifiado($e_id, $fecha, $dia, $tipo)
    {
        $result = $this->db->where('empleado_id', $e_id)
            ->where('fecha_inicio', $fecha)
            ->where('dias', $dia)
            ->where('estado', 'MANUAL')
            ->where('tipo_incidencias_id', $tipo)
            ->where('estatus', 'AUTORIZADO')
            ->select('idincidencias')
            ->get("incidencias");

        return $result->row();
    }


    function validarIncidencia($empleado, $fecha, $dia, $tipo)
    {
        $id = null;
        $result = $this->db->where("empleado_id", $empleado)
            ->where("fecha_inicio", $fecha)
            ->where('dias', $dia)
            ->where('tipo_incidencias_id', $tipo)
            ->where('estatus', 'RECHAZADO')
            ->get("incidencias");

        if ($result->num_rows() > 0) {
            $incidencia = $result->row();
            $day = $incidencia->dias;
            $startDate = $incidencia->fecha_inicio;
            $rDay = $this->db->query("SELECT tic_valid_days(?,?,?)", array(
                "starDate" => $startDate,
                "validDate" => $fecha,
                "days" => $day
            ));

            if ($rDay->num_rows() > 0) {
                $id = $incidencia->idincidencias;
            }
        }
        return $id;
    }

    function incidencias_mensuales($start, $end)
    {

        $SQL = "SELECT * FROM incidencias i INNER JOIN tipo_incidencias ti ON (i.tipo_incidencias_id = ti.id) WHERE i.fecha_inicio BETWEEN '$start' AND '$end'";
        $query = $this->db->query($SQL);

        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        } else {
            $row = "";
        }
        return $row;
    }

    function getnombre_empleado($id)
    {
        $SQL = "SELECT concat(p.nombres,' ', p.apellidoPaterno,' ', p.apellidoMaterno)  FROM persona p WHERE p.idPersona = $id";
        $query = $this->db->query($SQL);

        if ($query->num_rows() > 0) {
            $row = $query->result();
        } else {
            $row = "";
        }
        return $row;
    }

    function getVacacionesByfechas($empleado_id)
    {
        $result = $this->db
            ->where("tipo_incidencias_id", 1)
            ->where("empleado_id", $empleado_id)
            ->join("tipo_incidencias ti", "ti.id = i.tipo_incidencias_id", 'INNER')
            ->get("incidencias i");

        return $result->result();
    }

    function getIncidenciasByfechas($start, $end, $empleado_id)
    {
        $result = $this->db
            ->where("empleado_id", $empleado_id)
            ->where("fecha_inicio BETWEEN '$start' AND '$end'")
            ->join("tipo_incidencias ti", "ti.id = i.tipo_incidencias_id", 'INNER')
            ->get("incidencias i");

        return $result->result();
    }

    function detalle_incidencias_mensuales($start, $end, $key, $filtro = null)
    {
        $key = $key[key($key)];

        $puesto = "";
        $this->db->where("fecha_inicio BETWEEN '$start' AND '$end'");

        if ($key["valor"] > 0) {
            $where_in = $key["valor"];
            $this->db->where_in("ti.id", $where_in);
            $this->db->join("tipo_incidencias ti", "ti.id = i.tipo_incidencias_id", "inner");
        }

        if (!empty($filtro->puesto)) {
            if ($filtro->puesto == "-1") {
                $puesto = "";
            } else {

                if ($filtro->puesto->value >= 0) {
                    $puesto = $filtro->puesto->value;
                }
            }

            if ($puesto != "") {
                $this->db->where("p.idPersonaPuesto", $puesto);
                $this->db->join("persona p", "i.empleado_id = p.idPersona", "inner");
            }
        }

        if (!empty($filtro->colaborador)) {
            $colaborador = $filtro->colaborador;
            $this->db->where("i.empleado_id", $filtro->colaborador->value);
        }

        // $this->db->select("get_nombre_completo(i.empleado_id) as nombre");
        $this->db->join("users u", "i.empleado_id = u.idPersona", "inner");
        $this->db->select("u.name_complete as nombre,COUNT(i.empleado_id) as cantidad");
        $this->db->group_by("i.empleado_id");
        $query = $this->db->get("incidencias i");

        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result();
        }

        return $row;
    }

    function tipoincidenciaByFecha($start, $end, $filtro = null)
    {
        $puesto = "";
        $this->db->where("fecha_inicio BETWEEN '$start' AND '$end'");
        if (!empty($filtro["puesto"])) {
            if ($filtro["puesto"] == "-1") {
                $puesto = "";
            } else {
                if ($filtro["puesto"]["value"] >= 0) {
                    $puesto = $filtro["puesto"]["value"];
                }
            }
            if ($puesto != "") {
                $this->db->where("p.idPersonaPuesto", $puesto);
                $this->db->join("persona p", "i.empleado_id = p.idPersona", "inner");
            }
        }

        if (!empty($filtro["colaborador"])) {
            $this->db->where("i.empleado_id", $filtro["colaborador"]["value"]);
        }

        $this->db->select("i.tipo_incidencias_id, COUNT(i.idincidencias) total,ti.nombre");
        $this->db->join("tipo_incidencias ti", "ti.id = i.tipo_incidencias_id", "inner");
        $this->db->group_by("i.tipo_incidencias_id");
        $query = $this->db->get("incidencias i");

        // print_r($query);
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }

        return $row;
    }

    function tipoincidenciaByFechaColaborador($start, $end, $filtro = null)
    {    
        $colaborador = "";
        $implode = array();
        $array_colaboradores = array();

        $this->db->where("fecha_inicio BETWEEN '$start' AND '$end'");
        
        if (is_array($filtro["colaborador"])) {            
            array_values($filtro["colaborador"]);
            $colaboradores = $filtro["colaborador"];   

            foreach($colaboradores as $value){
                if(!empty($value["value"])){
                    array_push($array_colaboradores,$value["value"]);
                }else{
                    $colaborador = $colaboradores["value"];
                    // print_r($colaborador);
                }
            }           
        }else{
            $colaborador = $filtro["colaborador"];
            $this->db->where("i.empleado_id", $colaborador);
        }

        if(count($array_colaboradores)>0){
            $implode = array_values($array_colaboradores);
             $this->db->where_in("i.empleado_id", $implode);
             $this->db->group_by("i.empleado_id");
        }

        $this->db->select("COUNT(i.idincidencias) total, MONTH(i.fecha_inicio) as fecha, i.empleado_id as empleado,u.name_complete AS nombre");
        $this->db->join("persona p ","p.idpersona = i.empleado_id","LEFT");
        $this->db->join("users u ","p.idpersona = u.idpersona","LEFT");
        $this->db->group_by("MONTH(i.fecha_inicio)");
        $query = $this->db->get("incidencias i");
        $row = [];
        if ($query->num_rows() > 0) {
            if(count($colaborador) == $query->result()){
                $row = $query->result();
            }else{
                if(count($array_colaboradores) == $query->result() ){
                    $row = $query->result();
                }else{          
                    $row = $query->result();   
                }
            }
        }
        
        return $row;
    }

    function detalle_anual_mensual($start, $end, $punto, $filtro)
    {
        $idPersona = $this->tank_auth->get_idPersona();

        $colaborador = "";
        $colaboradores = array();
        if ($punto == "") {
            $start = $start;
            $end = $end;
        } else {
            $start_1 = explode('-', $start);
            $end_2 = explode('-', $end);
            $anio_start = $start_1[0];
            $mes_start = ($punto >= 0) ? $punto + 1 : $start_1[0];
            $dia_start = $start_1[2];
            $start = $anio_start . "-" . $mes_start . "-" . $dia_start;
            $anio_end = $end_2[0];
            $mes_end = ($punto >= 0) ? $punto + 1 : 1;
            $dia_end = $end_2[2];
            $end = $anio_end . "-" . $mes_end . "-" . $dia_end;
        }

        $this->db->where("fecha_inicio BETWEEN '$start' AND '$end'");
        if($filtro == ""){
            $this->db->where("i.empleado_id = $idPersona");
        }else {
            if (!empty($filtro->colaborador->value)) {
                $colaborador = $filtro->colaborador->value;
            } else {
                
                if (count($filtro->colaborador) > 0){
                    
                    foreach($filtro->colaborador as $value){
                        array_push($colaboradores,$value->value);
                    }
                }else if(!empty($filtro["colaborador"])){
                    
                    $colaborador = $filtro["colaborador"];
                }
            }
        }

        if(!empty($colaborador)){
            $this->db->where("i.empleado_id = $colaborador");
        }else{
           if(count($colaboradores) > 0){
            $this->db->where_in("i.empleado_id", $colaboradores);
           }
        }
        $this->db->select("ti.nombre, DATE_FORMAT(i.fecha_inicio,'%Y-%m-%d') as Fecha", false);
        $this->db->join("tipo_incidencias ti", "ti.id = i.tipo_incidencias_id", "inner");
        $query = $this->db->get("incidencias i");

        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result();
        }
        return $row;
    }

    function count_bajapersonal($fechaini, $fechafin, $filtro = null)
    {
        if($filtro != null){
            if(!empty($filtro["puesto"])){
                $puesto = $filtro["puesto"]["value"];
                $this->db->where("p.idPersonaPuesto",$puesto);
            }
        }
        $this->db->where("p.tipoPersona = 1 AND p.bajaPersona = 1 AND p.fecha_baja BETWEEN '$fechaini' AND '$fechafin'");
        //$this->db->where("p.fecha_baja BETWEEN '$fechaini' AND '$fechafin' AND p.tipoPersona = 1 ");
        $this->db->select("SUM(CASE WHEN p.bajaPersona = 1 THEN 1 END) AS baja,YEAR(p.fecha_baja) AS anio,DATE_FORMAT(p.fecha_baja,'%Y-%m-%d') as fecha, (SELECT COUNT(p.idpersona) FROM persona p
        WHERE p.tipoPersona = 1) AS total", false);
        $this->db->join("users u ", "u.idpersona = p.idpersona AND u.activated = 1", "inner");
        $this->db->group_by("YEAR(p.fecha_baja)");
        $query = $this->db->get("persona p");
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result_array();
        }
        return $row;
    }

    function detalle_rotacion_anual($fecha, $filtro = null)
    {
        $fechaini = $fecha["fecha_inicio_anual"];
        $fechafin = $fecha["fecha_fin_anual"];

        if($filtro != null){
            if(count($filtro->puesto) > 0){
                   $puesto = $filtro->puesto->value;
                   $this->db->where("p.idPersonaPuesto",$puesto);
            }
        }        
        
        $this->db->where("p.fecha_baja BETWEEN '$fechaini' AND '$fechafin' AND p.tipoPersona = 1  AND u.activated = 1 AND p.bajaPersona = 1 ");
        $this->db->select("u.name_complete as nombre,DATE_FORMAT(p.fecha_baja,'%Y-%m-%d') as fecha", false);
        $this->db->join("users u","u.idPersona = p.idPersona","inner");
        $query = $this->db->get("persona p");
        $row = [];
        if ($query->num_rows() > 0) {
            $row = $query->result();
        }
        return $row;
    }
    /**
     * Function that groups an array of associative arrays by some key.
     * 
     * @param {String} $key Property to sort by.
     * @param {Array} $data Array that stores multiple associative arrays.
     */
    function group_by($key, $data)
    {
        $result = array();

        foreach ($data as $val) {
            if (array_key_exists($key, $val)) {
                $result[$val[$key]][] = $val;
            } else {
                $result[""][] = $val;
            }
        }

        return $result;
    }
//---------------------------------------------
    //Configuraciones: Tipo de Incidencias
    function selectTI(){
        $this->db->select('*');
        $query = $this->db->get('tipo_incidencias');
        return $query->num_rows() > 0 ? $query->result() : array();
    }

    function addTI($name,$description){
        $data = array (
          'nombre'=>$name,
          'descripcion'=>$description,
          //'notificacion'=>$notification,
          //'documento'=>"0"
        );
        return $this->db->insert('tipo_incidencias',$data);
    }
    function updateTI($id,$name,$description) {
        $this->db->where('id',$id);
        $this->db->set('nombre',$name);
        $this->db->set('descripcion',$description);
        //$this->db->set('notificacion',$notification);
        //$this->db->set('documento',$document);
        return $this->db->update('tipo_incidencias');
    }

    function deleteTI($id){
        $this->db->delete('tipo_incidencias',array('id' => $id));
    }
    //---- Aumento Sueldo ----
    function save_request($data) {
        $this->db->insert('incidencias',$data);
        $query = $this->db->query("SELECT idincidencias FROM incidencias WHERE tipo_incidencias_id = 11 ORDER BY idincidencias DESC LIMIT 1");
        return $query->row()->idincidencias;
    }

    function update_incidencia($id,$data) {
        $this->db->where('idincidencias',$id);
        return $this->db->update('incidencias',$data);
    }
    //--------------------------------------------------------------------------------------
    function insertCelSMS($data,$id){
        $consulta= "select * FROM `incidencias_sms` WHERE idpersona=".$id;
        $response= $this->db->query($consulta)->result();
        if($response){
            return $this->db->update('incidencias_sms',$data)->result();
        }else{
            return $this->db->insert('incidencias_sms',$data)->result();
        }
    }
}

