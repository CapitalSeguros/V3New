<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class notificacionModel extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    /*LLAMADA AL STORE PROCEDURE(recuperar_contacto_tic) */
    function recuperarContacto($tipo, $id_persona)
    {
        $result = $this->db->query('CALL recuperar_contacto_tic(?,?)', array(
            "tipo" => $tipo,
            "id_persona" => $id_persona

        ));

        $res = $result->result();
        $result->next_result();
        $result->free_result();
        return $res;
    }

//--------------------------------------------------
    /*ACTUALIZA  LA TABLA DE NOTIFICACION*/
    function actualizarNotificacion($array)
    {
        if(isset($array['id']))
        {                 
        $this->db->where('id',$array['id']);        
        $this->db->update('notificacion',$array);         
        }
        else
        {
        $this->db->where('referencia',$array['referencia']);
        $this->db->where('idTabla',$array['idTabla']);
        $this->db->update('notificacion',$array);
       }
    }
//---------------------------------------------------
    /*INSERTA EN LA TABLA DE NOTIFICACION*/
    function notificacion($array)
    {
        if(isset($array['id']))
        {
            if($array['id']==-1)
            {
                unset($array['id']);
                $this->db->insert('notificacion',$array);
                $last=$this->db->insert_id();
                return  $last;

            }
            else
            {
                $consulta='select * from notificacion where id='.$array['id'];
                return $this->db->query($consulta)->result()[0];
            }
        }
    }
//-----------------------------------------------------
    function add($idpersona_and_email = null, $tipoenvio, $body, $tipo, $referencia, $referencia_id = null)
    {
        $data_referencia_id = "";

        if (!empty($referencia_id["evaluacion_id"])) {
            $data_referencia_id = $referencia_id["evaluacion_id"];
            //     }          
        } else if ($referencia_id > 0) {
            $data_referencia_id = $referencia_id;
        }

        if (is_array($idpersona_and_email)) {

            if (count($idpersona_and_email) > 0) {
                foreach ($idpersona_and_email as $value) {
                    if (!empty($value->email)) {
                        $data = array(
                            "tipo" => $tipo,
                            "tipo_id" => $tipoenvio,
                            "persona_id" => (!empty($value->idPersona)) ? $value->idPersona : null,
                            "fecha_alta" => date('Y-m-d H:i:s'),
                            "email" => (!empty($value->email)) ? $value->email : null,
                            "comment" => $body,
                            "referencia" => $referencia,
                            "referencia_id" => ($data_referencia_id == "") ? null : $data_referencia_id
                        );
                        if($tipo=="PERIODO_LIBERADO"){
                            $result=$this->selectById($data_referencia_id);
                            $data["comentarioAdicional"]=$this->aditionalmessage($result->tiempo_periodo,$result->fecha_inicio,$result->titulo);
                        }
                        // echo '<pre>';
                        // print_r($data["referencia"]);
                        // print_r("inserto");
                        $olw = $this->si_existe_registro($referencia, $value->email, $value->idPersona, $data["referencia_id"]);
                        if ($olw == 0) {
                            $this->db->insert('notificacion', $data);
                            $id = $this->db->insert_id();
                        }
                    }
                }
            } else {
                $data = array(
                    "tipo" => $tipo,
                    "tipo_id" => $tipoenvio,
                    "persona_id" => null,
                    "fecha_alta" => date('Y-m-d H:i:s'),
                    "email" => null,
                    "comment" => $body,
                    "referencia" => $referencia,
                    "referencia_id" => ($data_referencia_id == "") ? null : $data_referencia_id
                );

                $olw = $this->si_existe_registro($referencia, null, null, $data["referencia_id"]);
                if ($olw == 0) {
                    $this->db->insert('notificacion', $data);
                    $id = $this->db->insert_id();
                }
            }
        }
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

    /*BUSCAR LAS INCIDENCIAS QUE ESTEN AUTORIZADAS CON EL TIPO DE INCIDENCIAS */
    function search_incidencias()
    {
        $SQL = "SELECT * FROM incidencias i INNER JOIN tipo_incidencias ti ON (ti.id = i.tipo_incidencias_id) WHERE estatus = 'AUTORIZADO' AND ti.notificacion <> ''";
        $query = $this->db->query($SQL);
        if ($query->num_rows() > 0) {
            $row = $query->result();
        } else {
            $row = "";
        }
        return $row;
    }

    /*BUSCA LAS EVALUACIONES QUE ESTEN AUTORIZADAS CON EL TIPO DE INCIDENCIA */
    function search_evaluaciones()
    {
        //$SQL = "SELECT ep.tipo as tipo_evaluacion,ep.puesto_id,e.fecha_inicio,e.dias_previos,ep.evaluacion_id FROM evaluaciones e INNER JOIN evaluacion_puesto ep ON(ep.evaluacion_id = e.id) WHERE e.estatus = 'LIBERADO'";
        $SQL = "SELECT * FROM evaluacion_periodos ep2 INNER JOIN evaluacion_periodos_puesto ep ON (ep.evaluacion_periodo_id = ep2.id) WHERE ep2.estatus = 'LIBERADO'";
        $query = $this->db->query($SQL);
        if ($query->num_rows() > 0) {
            $row = $query->result();
        } else {
            $row = "";
        }
        return $row;
    }

    /*VERIFICA CONFORME A LA REFERENCIA_ID,REFERENCIA Y EL EMAIL */
    function si_existe_registro($referencia, $email = null, $idPersona = null, $data_referencia_id = null)
    {
        $row = "";
        if ($data_referencia_id > 0) {

            if ($email == null && $idPersona == null) {
                $SQL = "SELECT * FROM notificacion n
                INNER JOIN incidencias i ON (n.referencia_id = i.idincidencias AND n.referencia = 'incidencias')
                WHERE i.estatus = 'AUTORIZADO' and n.referencia_id = $data_referencia_id AND n.referencia = '$referencia' AND n.email is null AND n.persona_id is null GROUP BY n.referencia_id,n.referencia ";

                $query = $this->db->query($SQL);

                if ($query->num_rows() > 0) {
                    $row = $query->result();
                }
            } else {
                $SQL = "SELECT * FROM notificacion n
                INNER JOIN incidencias i ON (n.referencia_id = i.idincidencias AND n.referencia = 'incidencias')
                WHERE i.estatus = 'AUTORIZADO' and n.referencia_id = $data_referencia_id AND n.referencia = '$referencia' AND n.email = '$email' AND n.persona_id = $idPersona GROUP BY n.email ";

                $query = $this->db->query($SQL);

                if ($query->num_rows() > 0) {
                    $row = $query->result();
                } else {
                    $SQL1 = "SELECT * FROM notificacion n
                            INNER JOIN evaluacion_periodos_puesto ep2 ON (n.referencia_id = ep2.evaluacion_id) INNER JOIN evaluacion_periodos ep ON(ep.id = ep2.evaluacion_periodo_id) 
                            AND ep.estatus = 'LIBERADO' AND n.referencia = '$referencia' AND n.referencia_id = $data_referencia_id AND n.email = '$email' AND n.persona_id = $idPersona GROUP BY ep2.puesto_id,ep2.evaluacion_id, ep2.tipo,n.email";
                    $query = $this->db->query($SQL1);
                    if ($query->num_rows() > 0) {
                        $row = $query->result();
                    } else {
                        $row = "";
                    }
                }
            }
        } else {
            $SQL = "SELECT * FROM  incidencias i 
                    LEFT JOIN tipo_incidencias ti ON(i.tipo_incidencias_id = ti.id) 
                    INNER JOIN notificacion n ON (n.tipo = 'incidencia')
                    WHERE i.estatus ='AUTORIZADO' AND ti.notificacion <> '' AND n.referencia_id IS NULL AND n.persona_id = $idPersona AND n.email = '$email' GROUP BY n.email, n.referencia";
            $query = $this->db->query($SQL);
            if ($query->num_rows() > 0) {
                $row = $query->result();
            } else {
                $row = "";
            }
        }

        return $row;
    }


    function getUsrBonos()
    {
        /*A�adir lo de distinto persona al agregar notficiacion de bono --p.idPersonaPuesto<>$id*/
        $SQL = "SELECT p.idPersona, u.email FROM persona p,users u 
        WHERE u.idPersona=p.idPersona AND p.idPersonaPuesto IN(7,58)";
        $query = $this->db->query($SQL);
        if ($query->num_rows() > 0) {
            $row = $query->result();
        } else {
            $row = "";
        }
        return $row;
    }

    function getUsrAlertas($id){
        $SQL = " SELECT p.idPersona, u.email FROM persona p,users u 
        WHERE u.idPersona=p.idPersona AND p.idPersona=".$id;
        $query = $this->db->query($SQL);
        if ($query->num_rows() > 0) {
            $row = $query->result();
        } else {
            $row = "";
        }
        return $row;
    }

    function getUsrEmail($id)
    {
        $SQL = "SELECT p.idPersona, u.email FROM persona p,users u 
        WHERE u.idPersona=p.idPersona AND p.idPersona=$id";
        $query = $this->db->query($SQL);
        if ($query->num_rows() > 0) {
            $row = $query->result();
        } else {
            $row = "";
        }
        return $row;
    }

    function getAllNotificaciones($id)
    {
        $SQL = "SELECT n.*,
        CASE 
        WHEN n.tipo = 'INCIDENCIA_ACTIVA' THEN 'INCIDENCIA ACTIVA,Tiene una nueva solicitud de incidencia,1'
        WHEN n.tipo = 'INCIDENCIA_APROBADA' THEN 'INCIDENCIA APROBADA,Se aprovo una incidencia,1'
        WHEN n.tipo = 'INCIDENCIA_RECHAZADA' THEN 'INCIDENCIA RECHAZADA,Se rechazo la incidencia,1'
        WHEN n.tipo = 'PERIODO_LIBERADO' THEN 'PERÍODO LIBERADO,Se liberó un período de evaluaciones,1'
        WHEN n.tipo = 'PERIODO_POR_EMPEZAR' THEN 'PERÍODO POR EMPEZAR,Están por comenzar las evaluaciones,1'
        WHEN n.tipo = 'PERIODO_POR_TERMINAR' THEN 'TERMINO DE PERÍODO,El período esta por terminar asegurate de responder todas tus evaluaciones,1'
        WHEN n.tipo = 'BONO_AUTORIZADO' THEN 'BONO AUTORIZADO,Se ha autorizado un bono,1'
        WHEN n.tipo = 'BONO_PENDIENTE' THEN 'BONO PENDIENTE,Tiene una nueva solicitud de bono,1'
        WHEN n.tipo = 'BONO_REPLICA' THEN 'BONO REPLICA,Se ha realizado una replica de un bono,1'
        WHEN n.tipo = 'BONO_RECHAZADO' THEN 'BONO RECHAZADO,Se ha rechazado un bono,1'
        WHEN n.tipo = 'BONO_AUTORIZADO' THEN 'BONO AUTORIZADO,Se ha autorizado un bono,1'
        WHEN n.tipo = 'ANTES_VACACIONES' THEN 'VACACIONES ANTES,Se han registrado vacaciones antes,1'
        WHEN n.tipo = 'SINIESTROS' THEN 'SINIESTROS,Se ha registrado un siniestro,1'
        WHEN n.tipo = 'ALERTA' THEN 'ALERTA,Han escalado algunos siniestros,1'
        WHEN n.tipo = 'PIP' THEN 'PIP,Tiene que dar seguimiento a un PIP,1'
        WHEN n.tipo = 'OTRO' THEN '--'
        WHEN n.tipo = 'NUEVA_NOTA' THEN 'NOTA,Se ha agregado una nota al directorio,1'
        WHEN n.tipo = 'ACTUALIZACION_NOTA' THEN 'NOTA,Se ha modificado el contenido de una nota del directorio,1'
        WHEN n.tipo = 'FELICITACION' THEN 'CUMPLEAÑOS,Un miembro del equipo Agente Capital cumple años,1'
        WHEN n.tipo = 'LIBERAR_AGENTE' THEN 'LIBERAR,Un agente ha concluido su inducción. Hay que liberarlo,1'
        WHEN n.tipo = 'LIBERAR_COLABORADOR' THEN 'LIBERAR,Un colaborador ha concluido su inducción. Hay que liberarlo,1'
        WHEN n.tipo = 'SOLICITUD_DE_ALTA_DE_AGENTE' THEN 'ALTA,Se ha realizado una solicitud de alta de agente. Revisar en capital humano,1'
        WHEN n.tipo = 'SOLICITUD_DE_ALTA_DE_COLABORADOR' THEN 'ALTA,Se ha realizado una solicitud de alta de colaborador. Revisar en capital humano,1'
        WHEN n.tipo = 'RESPUESTA_ALTA' THEN 'RESPUESTA DE ALTA,Se ha dado de alta al usuario solicitado. Por favor proceda con la documentación del mismo.,1'
        WHEN n.tipo = 'PROGRESO_INDUCCION' THEN 'INDUCCIÓN EN PROGRESO,Un usuario se ha liberado para inducción. Favor de validar.,1'
        WHEN n.tipo = 'PROGRESO_DOCUMENTACION_COLABORADOR' THEN 'NUEVO USUARIO CON DOCUMENTACIÓN EN PROGRESO,Un usuario se ha liberado. Favor de validar su documentación.,1'
        WHEN n.tipo = 'PROGRESO_DOCUMENTACION_AGENTE' THEN 'NUEVO USUARIO CON DOCUMENTACIÓN EN PROGRESO,Un usuario se ha liberado. Favor de validar su documentación.,1'
        WHEN n.tipo = 'NUEVA_NOTA_SINIESTRO' THEN 'NOTA DE SINIESTRO,Se ha agregado una nota al módulo de siniestros.,1'
        WHEN n.tipo = 'ACTUALIZACION_NOTA_SINIESTRO' THEN 'ACTUALIZACIÓN DE NOTA DE SINIESTRO,Se ha modificado el contenido de una nota en el módulo de siniestros,1'
        WHEN n.tipo = 'SOLICITUD_BAJA' THEN 'SOLICITUD DE BAJA DE PERSONAL,Se ha realizado una solicitud de baja de personal,1'
		WHEN n.tipo = 'SOLICITUD_VACACION' THEN 'SOLICITUD DE VACACIÓN,Se ha realizado una solicitud de vacación,1'
        ELSE 'Notificacion,Sin observacion,0'
        END AS Contenido
        from notificacion n where n.persona_id=$id and n.check!=2 ORDER BY n.fecha_alta DESC LIMIT 10";
        
         //---------------------
        //Dennis [2021-04-22]
        //Se realizó el anexo de tipo en la consulta SQL para mostrar en notificaciones.
        //WHEN n.tipo = 'NUEVA_NOTA' THEN 'NOTA,Se ha agregado una nota al directorio,1'
        //WHEN n.tipo = 'ACTUALIZACION_NOTA' THEN 'NOTA,Se ha modificado el contenido de una nota del directorio,1'
        //WHEN n.tipo = 'FELICITACION' THEN 'CUMPLEAÑOS,Un miembro del equipo Agente Capital cumple años,1'
        //---------------------

        $query = $this->db->query($SQL);
        if ($query->num_rows() > 0) {
            $row = $query->result();
        } else {
            $row = array();
        }
        return $row;
    }

    function getPersonaIncidencia($id)
    {
        $obj = $this->db
            ->select("p.idPersona,u.email, pp.padrePuesto")
            ->where('p.idPersona', $id)
            ->join("personapuesto pp", "p.idPersonaPuesto=pp.idPuesto", "inner")
            ->join("users u", "p.idPersona=u.idPersona", "inner")
            ->get('persona p');
        return $obj->result();
    }


    function getPersonaWithoutPuesto($id)
    {
        $obj = $this->db
            ->select("p.idPersona,u.email")
            ->where('p.idPersona', $id)
            ->join("users u", "p.idPersona=u.idPersona", "inner")
            ->get('persona p');
        return $obj->result();
    }

    function getDtaIncidencia($id)
    {
        $obj = $this->db
            ->select("i.fecha_autorizacion,i.estatus,u.name_complete,i.dias,ti.nombre as Tipo")
            ->where('i.idincidencias', $id)
            ->join("tipo_incidencias ti", "ti.id=i.tipo_incidencias_id", "inner")
            ->join("users u", "u.idPersona=i.empleado_id", "inner")
            ->get('incidencias i');
        return $obj->result_array();
    }

    function getUsNotIncidencias($id)
    {
        $obj = $this->db
            ->select("p.idPersona,u.email")
            ->where('p.idPersonaPuesto', $id)
            ->join("users u", "p.idPersona=u.idPersona", "inner")
            ->get('persona p');

        return $obj->result();
    }

    function getUsrByBonoPeticion($id)
    {
        $obj = $this->db
            ->select("u.name_complete,s.fecha,s.fecha_aplicacion")
            ->where('s.id', $id)
            ->join("users u", "u.idPersona=s.empleado_id", "inner")
            ->get('solicitud_sueldo s');
        return $obj->result_array();
    }
    function getDataPeridos($id)
    {
        $obj = $this->db
            ->select("ep.titulo,date_format(ep.fecha_final,'%d-%m-%Y') fecha_final,date_format(ep.fecha_inicio,'%d-%m-%Y') fecha_inicio")
            ->where('ep.id', $id)
            ->get('evaluacion_periodos ep');
        $dta= $obj->result_array();
        $SQL ="select pp.personaPuesto from evaluacion_periodos_puesto ep
        inner join personapuesto pp on ep.puesto_id=pp.idPuesto
        where ep.evaluacion_periodo_id=".$id." and ep.tipo='Evaluador';";
        $query = $this->db->query($SQL);
        $dta2=$query->result_array();
        $puestos="";
        foreach ($dta2 as $key => $value) {
            if(end($value)){
                $puestos=$puestos.$value["personaPuesto"];
            }else{
                $puestos=$puestos.','.$value["personaPuesto"];
            }
        }

        $dta[0]["puestos"]=$puestos;
        return $dta;

    }

    function getdataRedirect($tipo, $id)
    {
        switch ($tipo) {
            case 'BONOS':
                $obj = $this->db
                    ->select("s.id as Id,s.empleado_id as Empleado")
                    ->where('s.id', $id)
                    ->get('solicitud_sueldo s');
                break;
            case 'INCIDENCIAS':
                $obj = $this->db
                    ->select("i.idincidencias as Id,i.empleado_id as Empleado")
                    ->where('i.idincidencias', $id)
                    ->get('incidencias i');
                break;
            case 'PERIODOS':
                $obj = $this->db
                    ->select("e.id,e.fecha_inicio")
                    ->where('e.id', $id)
                    ->get('evaluacion_periodos e');
                break;
            case 'SINIESTROS':
                 $obj = $this->db
                    ->select("*")
                    ->where('sr.id', $id)
                    ->get('siniestro_reportes sr');
                break;
            case 'ALERTA':
                    $obj = $this->db
                       ->select("*")
                       ->where('sr.id', $id)
                       ->get('siniestro_reportes sr');
                   break;
            //----------------------------------------------
            //Anexo de referencias por Dennis Castillo [2021-04-22]
            case 'NOTAS':
                $obj = $this->db
                   //->select("*")
                   ->where('id_nota_cliente', $id)
                   ->get('notas_asignadas_en_clientes');
               break;
            case 'CUMPLEANIO':
                $obj = $this->db
                   //->select("*")
                   ->where('id_nota_cliente', $id)
                   ->get('notas_asignadas_en_clientes');
               break;
            //----------------------------------------------
            case 'PROGRESO_DOCUMENTACION_COLABORADOR': //PROGRESO_INDUCCION
                $obj = $this->db
                   //->select("*")
                   ->where('idPersona', $id)
                   ->get('employe_to_user');
               break;
            //----------------------------------------------
            case 'PROGRESO_DOCUMENTACION_AGENTE': //PROGRESO_INDUCCION
                $obj = $this->db
                   //->select("*")
                   ->where('idPersona', $id)
                   ->get('prospective_to_user');
               break;
            //----------------------------------------------
            //Dennis Castillo [2022-01-18]
            case 'NOTA_SINIESTRO':
                $obj = $this->db
                    ->select("a.*, b.tipo_r")
                    ->join("siniestro_reportes b", "a.idSinister = b.id", "left")
                    ->where('a.id', $id)
                    ->get('sininisterNotes a');
               break;
            //----------------------------------------------
            //Dennis Castillo [2022-02-11]
            case 'SOLICITUD_BAJA':
                $obj = $this->db->where("id", $id)->get("casualty_list");
                break;
            //----------------------------------------------
			//Dennis Castillo [2022-06-27]
            case 'SOLICITUD_VACACION':
                $obj = $this->db->where("id", $id)->get("vacaciones");
                break;
            //----------------------------------------------
            default:
                $obj = "";
                break;
        }
        if($obj){
            return $obj->row();
        }else{
            return $obj=[];
        }
    }


    function validacion($url,$id){
        $SQL ="SELECT * from modulo_permiso where url='".$url."' and usuarios regexp '".$id."'";
        $query = $this->db->query($SQL);
        $row = [];
        if ($query->num_rows() > 0) {
            return true;
        }
        else{
            return false;
        }
        
    }

    function insertCorreo($data){
        $this->db->insert('envio_correos', $data);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function getUserByPuestos($puestos){
        $obj = $this->db
            ->select("p.idPersona,u.email")
            ->where_in('p.idPersona', $puestos)
            ->join("persona p", "u.idPersona=p.idPersona", "inner")
            ->get('users u');
        return $obj->result();
    }

    function updateAll($id){
        //$obj=$this->db->set('check', 1)->where('persona_id', $id)->update('notificacion n');
        $obj=$this->db->set('check', 1)->where('persona_id', $id)->where('check',0)->update('notificacion n');
        $obj=$this->db->set('check', 1)->where('aplica_id', $id)->update('evaluacion_periodo_empleado n');
       /*  $obj2=$this->db->query("UPDATE evaluacion_periodo_empleado set check=1 where aplica_id=".$id);
        $obj2->result(); */
        return true;
    }

    function NuevasN($id){
        $obj=$this->db->query("select sum((select count(*) from evaluacion_periodo_empleado e where e.aplica_id=".$id." and e.check=0)+
        (select count(*) from notificacion n where n.persona_id=".$id." and n.check=0)) as result");
        return $obj->result_array();
    }

    function updateSingle($id){
        $this->db->set('check', 2)
        ->where('id',$id)
        ->update('notificacion');
        return true;
    }
     //----------------------------------
     //Dennis [2021-04-22]
     function replaceDataNotification($tipo = null, $referencia = null, $referencia_id = null, $update_data){

        $respuesta=false;

        if(!empty($tipo) && !empty($referencia) && !empty($referencia_id)){

            $this->db->where("tipo", $tipo);
            $this->db->where("referencia", $referencia);
            $this->db->where("referencia_id", $referencia_id);
            $this->db->update("notificacion", $update_data);

            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
            } else{
                $this->db->trans_commit();
                $respuesta=true;
            }

        }

        return $respuesta;
    }
    //----------------------------------

    function getUsrEmailRow($id)
    {
        $SQL = "SELECT p.idPersona, u.email FROM persona p,users u 
        WHERE u.idPersona=p.idPersona AND p.idPersona=$id";
        $query = $this->db->query($SQL);
        if ($query->num_rows() > 0) {
            $row = $query->row();
        } else {
            $row = "";
        }
        return $row;
    }

    //-------------------------------------
    ///Metodos para poner comentariosextra
    //Funcion del trimestre
    public function trimestre($datetime)
    {
        $mes = date("m",strtotime($datetime));
        $mes = is_null($mes) ? date('m') : $mes;
        $trim=floor(($mes-1) / 3)+1;
        return $trim;
    }

    public function bimestre($mes)
    {
        $bimestre="";
        switch ($mes) {
            case '1':
            case '2':
                $bimestre=1;
                break;
            case '3':
            case '4':
                $bimestre=2;
                 break;
            case '5':
            case '6':
                $bimestre=3;
                break;
            case '7':
            case '8':
                $bimestre=4;
                break;
            case '9':
            case '10':
                $bimestre=5;
                break;
            case '11':
            case '12':
                $bimestre=6;
                break;                     
        }
        return $bimestre;
    }

    public function aditionalmessage($perido,$fecha,$nombre){
        $msg='';
        $formatedDate=date("d/m/Y", strtotime($fecha));
        switch ($perido) {
            case '1':
                $mes=date("m",strtotime($fecha));
                $msg="con el nombre $nombre del $mes mes con fecha de inicio $formatedDate";
                break;
            case '2':
                $mes=date("m",strtotime($fecha));
                $bimestre=$this->bimestre($mes);
                $msg="con el nombre $nombre del $bimestre bimestre con fecha de inicio $formatedDate";
                break;
            case '3':
                $timestre=$this->trimestre($fecha);
                $msg="con el nombre $nombre del $timestre trimestre con fecha de inicio $formatedDate";
                break;
            case '6':
                $mes=date("m",strtotime($fecha));
                $semetres=$mes<=6?1:2;
                $msg="con el nombre $nombre del $semetres semestre con fecha de inicio $formatedDate";
                break;
            case '12':
                $msg="con el nombre $nombre de tipo anual con fecha de inicio $formatedDate";
                break;
        }
        return $msg;
    }

}
