
<?php 

class Binconformidad_model extends CI_Model {
    public function __Construct(){
		parent::__Construct();
	}

    function insertaInconformidad($array, $moreFunctions){

        $response = array();
        $forBitacora = array();
        $this->db->trans_begin();
        $this->db->insert("inconformidades", $array);
        $response["id"] = $this->db->insert_id();
        
        $this->db->where("id", $response["id"])->update("inconformidades", array("folioInconformidad" => "IN".$response["id"]));

        $this->db->insert("tablanoconformidad", array(
            "nombreTabla" => "inconformidades",
            "idRowTabla" => $response["id"],
            "idPersonaInconforme" => $this->tank_auth->get_idPersona(),
            "aFavor" => 0
        ));

        array_push($forBitacora, array(
            "inconformidad" => $response["id"], 
            "movimiento" => "Se ha creado una inconformidad con folio(ticket): IN".$response["id"].".",
            "fechaMovimiento" => date("Y-m-d H:i:s"),
            "email" => $this->tank_auth->get_usermail(),
        ));
        //$this->db->insert("inconformidades_bitacora", );

        if($moreFunctions["sendEmail"]){
            //Pass NC to email
            $this->db->insert("envio_correos", array(
                "desde" => "Buzon de quejas<avisosgap@aserorescapital.com>",
                "para" => $this->tank_auth->get_usermail(),
                "asunto" => "Notificación del buzón de inconformidad",
                "mensaje" => "Su ticket de seguimiento a su inconformidad es: IN".$response["id"],
            ));


        if($array['idCBITipo']==30)
        {
            $this->db->insert("envio_correos", array(
                "desde" => "Buzon de quejas<avisosgap@aserorescapital.com>",
                "para" => 'ASISTENTEDIRECCION@AGENTECAPITAL.COM',
                "asunto" => "Se genero una inconformidad del modulo de cobranza",
                "mensaje" => "Su ticket de seguimiento a su inconformidad es: IN".$response["id"],
            ));
        }
        if($array['idCBITipo']==2 && $array['idCBIOpcion']==6)
        {
            $correo='';
            if($array['idCBIArea']==20){$correo='SISTEMAS@ASESORESCAPITAL.COM';}
            else{if($array['idCBIArea']==31){$correo='DESARROLLO@AGENTECAPITAL.COM';}}
            if($correo!='')
            {
                           $this->db->insert("envio_correos", array(
                "desde" => "Buzon de quejas<avisosgap@aserorescapital.com>",
                "para" => $correo,
                "asunto" => "Se genero una inconformidad para tu area",
                "mensaje" => "Su ticket de seguimiento para esta inconformidad es: IN".$response["id"],
            )); 
            }
        }

            array_push($forBitacora, array(
                "inconformidad" => $response["id"], 
                "movimiento" => "Se ha enviado a su correo corporativo el folio de seguimiento a su inconformidad.",
                "fechaMovimiento" => date("Y-m-d H:i:s"),
                "email" => $this->tank_auth->get_usermail(),
            ));

            $consultaNumero="select celSMS FROM `incidencias_sms`";
             $numeros= $this->db->query($consultaNumero)->result();
             foreach ($numeros as $cel) {
        $message="*Asistente CAPSYS* \nSe ha creado un nuevo buzón de inconformidad con el folio: IN".$response["id"] ;
        $search     = array('{', '}', '"');
        $replace    = array('', '', '');        
        $params = array("message" => $message,"numbers" => $cel->celSMS,"country_code" => 52);
        $headers = array(
            "apikey: 0bf959dfc9127cef8131396dd312548c6f93354c"
        );
        
        curl_setopt_array($ch = curl_init(), array(
            CURLOPT_URL => "https://api.smsmasivos.com.mx/sms/send",
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HEADER => 0,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => http_build_query($params),
            CURLOPT_RETURNTRANSFER => 1
        ));
    
        $responseSMS = curl_exec($ch);
        curl_close($ch);
             }
        

        }

        $this->db->insert_batch("inconformidades_bitacora", $forBitacora);

        $response["success"] = (filter_var(strtolower($this->db->trans_status()), FILTER_VALIDATE_BOOLEAN));

        if($this->db->trans_status() == FALSE){
            $this->db->trans_rollback();
        } else{
            $this->db->trans_commit();
        }

        return $response;
    }

    //----------------------------------------
    function getList($condition){

        $query = $this->db->select("
                a.id,
                b.aFavor,
                b.correoResponsable,
                b.idPersonaResponsable,
                SUBSTRING(a.descripcion, 1, 10) AS descripcion,
                DATE_FORMAT(a.fechaRegistro, '%d/%m/%Y %r') AS fechaRegistro, 
                (SELECT catalogBuzonInconformidad FROM catalog_buzoninconformidad WHERE idCBI = a.idCBITipo) AS idCBITipo,
                (SELECT catalogBuzonInconformidad FROM catalog_buzoninconformidad WHERE idCBI = a.idCBIOpcion) AS idCBIOpcion,
                (SELECT catalogBuzonInconformidad FROM catalog_buzoninconformidad WHERE idCBI = a.idCBIArea) AS idCBIArea,
                IF(c.status IS NULL, 'NUEVO', c.status) AS status,
                CASE
                    WHEN b.aFavor = 0 THEN 'primary'
                    WHEN b.aFavor = 1 THEN 'success'
                    WHEN b.aFavor = 3 THEN 'danger'
                    ELSE 'oka'
                END AS label ", false)
        ->join("(SELECT d.idRowTabla, d.aFavor, d.idPersonaResponsable, IF(d.idPersonaResponsable IS NOT NULL, e.email, 'Sin responsable') as correoResponsable FROM tablanoconformidad d LEFT JOIN users e ON d.idPersonaResponsable = e.idPersona) b", "a.id = b.idRowTabla", "left") //tablanoconformidad
        ->join("tablanoconformidadstatus c", "b.aFavor = c.idTNCStatus", "left")
        ->where($condition)
        ->order_by("id", "DESC")
        ->get("inconformidades a") //inconformidades
        ->result();

        return $query;
    }
    //----------------------------------------
    function getList_2($condition){

        $query = $this->db->select("
            a.idRowTabla,
            a.aFavor,
            a.idPersonaResponsable,
            b.id,
            SUBSTRING(b.descripcion, 1, 10) AS descripcion,
            DATE_FORMAT(b.fechaRegistro, '%d/%m/%Y %r') AS fechaRegistro,
            (SELECT catalogBuzonInconformidad FROM catalog_buzoninconformidad WHERE idCBI = b.idCBITipo) AS idCBITipo,
            (SELECT catalogBuzonInconformidad FROM catalog_buzoninconformidad WHERE idCBI = b.idCBIOpcion) AS idCBIOpcion,
            (SELECT catalogBuzonInconformidad FROM catalog_buzoninconformidad WHERE idCBI = b.idCBIArea) AS idCBIArea,
            IF(a.idPersonaResponsable IS NOT NULL, c.email, 'Sin responsable') as correoResponsable,
            IF(d.status IS NULL, 'NUEVO', d.status) AS status,
            CASE
                WHEN a.aFavor = 0 THEN 'primary'
                WHEN a.aFavor = 1 THEN 'success'
                WHEN a.aFavor = 3 THEN 'danger'
                ELSE 'oka'
            END AS label
        ", false)
        ->join("inconformidades b", "a.idRowTabla = b.id", "left")
        ->join("users c", "a.idPersonaResponsable = c.idPersona", "left")
        ->join("tablanoconformidadstatus d", "d.idTNCStatus = a.aFavor", "left")
        ->join("actividades e", "a.idRowTabla = e.idInterno", "left")
        ->where($condition)
        ->get("tablanoconformidad a")
        ->result();

        return $query;
    }
    //----------------------------------------
    function getNCBinnacle($id){

        return $this->db->select("movimiento, inconformidad, DATE_FORMAT(fechaMovimiento, '%d-%m-%Y %r') AS fechaMovimiento", false)->where("inconformidad", $id)->get("inconformidades_bitacora")->result();
    }
    //----------------------------------------
    function getNCListFiltered($condition){ //Obsoleto

        $query = $this->db->select("id,
            descripcion,
            DATE_FORMAT(fechaRegistro, '%d/%m/%Y %r') AS fechaRegistro,
            (SELECT catalogBuzonInconformidad FROM catalog_buzoninconformidad WHERE idCBI = idCBITipo) AS idCBITipo,
            (SELECT catalogBuzonInconformidad FROM catalog_buzoninconformidad WHERE idCBI = idCBIOpcion) AS idCBIOpcion,
            (SELECT catalogBuzonInconformidad FROM catalog_buzoninconformidad WHERE idCBI = idCBIArea) AS idCBIArea,"
        , false)
        ->where($condition)
        ->get("inconformidades")
        ->result();

        return $query;
    }
    //----------------------------------------
    function updateNCReg($condition){

        $response = array();
        $this->db->trans_begin();
        $this->db->where($condition);
        $this->db->update("tablanoconformidad", array("aFavor" => 1));

        $this->db->insert("inconformidades_bitacora", array(
            "inconformidad" => $condition["idRowTabla"],
            "movimiento" => "La inconformidad IN".$condition["idRowTabla"]." ha cambiado de estado a RESUELTO",
            "fechaMovimiento" => date("Y-m-d H:i:s"),
            "email" => $this->tank_auth->get_usermail()
        ));

        $response["success"] = filter_var(strtolower($this->db->trans_status()), FILTER_VALIDATE_BOOLEAN);

        if($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
        } else{
            $this->db->trans_commit();
        }

        return $response;
    }
    //----------------------------------------

  /**
   * Obtiene una lista de evaluadores asociados a las tareas separandolos por IDs
   *
   * @param array $data_ids Un arreglo de IDs de tareas que se utilizarán para filtrar los resultados de la consulta
   * @return array Un arreglo asociativo donde la clave es el ID de la tarea y el valor es un string con los nombres y correos de los evaluadores
   */
  public function obtenerListaEvaluadoresNC($data_ids)
  {
    $resultados = array();

    $this->db->select('t.idTabla, te.nombre_persona, te.email_persona');
    $this->db->from('tareas t');
    $this->db->join('tareas_evaluadores te', 't.idtarea = te.id_tarea', 'inner');
    $this->db->where_in('t.idTabla', $data_ids); // Usamos where_in para filtrar por IDs

    $query = $this->db->get();

    if ($query->num_rows() > 0) {
      foreach ($query->result() as $row) {
        if (!isset($resultados[ $row->idTabla ])) {
          $resultados[ $row->idTabla ] = '';
        }

        $resultados[ $row->idTabla ] .= $row->nombre_persona . " (" . $row->email_persona . ")<br>";
      }
    }

    return $resultados;
  }

}
?>