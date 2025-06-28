<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Notifications
{

    // private $NotificacionTable;
    private $new_option = array();
    private $only_unread = 0;
    private $error;
    private $tipo = '';
    private $clave = '';
    // private $page_limit = 0;
    // private $page_offset = 0;
    private $id = 0;
    public $notificaciones = array();
    public $contacts = array();
    public $parametros = array();
    public $notificationTable;
    private $persona_id = 0;
    private $ci;
    public $notificationUserTable;
    private $tipo_id = 0;
    private $comment = '';
    private $token = '';

    function __construct($global)
    {
        $this->CI = &get_instance();
        $this->CI->load->model('notificacionmodel');
        $this->CI->load->library('parser');
        $this->CI->load->library('email');
        $this->CI->load->library('phpmailer_lib');
        //$this->CI->load->config('email');
        $this->config($global);
    }

    public function config($global, $new_options = [])
    {
        $options = $global;
        //combina los arrays que tenga en uno solo
        $options = array_merge($options, $new_options);  //array_merge ([0]=>verde,[1]=>azul,[2] => rojo)

        $this->notificaciones = $options['notificationes'];
        $this->contacts = $options["contacts"];
        $this->notificationTable     = $options['notification_table'];
        $this->notificationUserTable = $options['notification_read_tracking_table'];
    }

    public function sendemail($from, $to, $subject, $body, $cc, $bcc)
    {
        $mail = $this->CI->phpmailer_lib->load();
        $mail->isSMTP();
        $mail->Host     = 'smtp.googlemail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'elisandro1033@gmail.com';
        $mail->Password = 'Mikemaple55@';
        $mail->SMTPSecure = 'tls';
        $mail->Port     = 587;
        $mail->CharSet = "UTF-8";

        if (empty($from)) {
            $mail->setFrom("noreply@ticc.com.mx","noreply@ticc");
            //$from = $this->CI->config->item('from');
        }

        $fromLabel = "";
        $fromValue = "";
        if (is_array($from)) {
            $fromLabel = key($from);
            $fromValue = $from[key($from)];
        } else {
            $fromLabel = $from;
            $fromValue = $from;
        }
        foreach ($to as $key => $value) {
            $mail->addAddress($value);
        }
        $mail->Subject = $subject;
        $mail->isHTML(true);
        $mail->Body=$body;
        //var_dump($mail);
        /* if(!$mail->send()){
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }else{
            echo 'Message has been sent';
        } */
        //nuevo envio
        $data=array(
            "desde"=>"Avisos de GAP<avisosgap@aserorescapital.com>",
            "asunto"=>$subject,
            "mensaje"=>$body,
            "para"=>"",
            "status"=>0,
            "fechaEnvio"=>date("Y-m-d H:i:s")
        );
        foreach ($to as $key => $value) {
            if($value!=''){
                $data["para"]=$value;
                //echo 'No hau error';
                $this->CI->notificacionmodel->insertCorreo($data);
            }
        }
        
    }

    //DISPONIBLE_EVALUACION,INCIDENCIAS,tipo('web','email'),2020-02-05, disponiblidad_evaluacion,parametros
    public function notify($obNoti, $parametros)
    {
        if (empty($obNoti["function"]) || empty($obNoti["plantilla"])) {
            return false;
        }
        switch ($obNoti["function"]) {
            case 'before_vacaciones':
                $data = $this->before_vacaciones($obNoti, $parametros);
                break;
            case 'disponibilidad_evaluacion':
                $data = $this->incidencia($parametros);
                break;
            case 'antes_evaluacion':
                $data = $this->antes_evaluacion($obNoti, $parametros);
                break;
            case 'antes_evaluacion_cierre':
                $data = $this->antes_evaluacion_cierre($obNoti, $parametros);
                break;
            case 'incidencia':
                $data = $this->incidencia($parametros);
                break;
            case 'incidencia2':
                $data = $this->incidencias2($parametros);
                break;
            case 'faltas':
                $data = $this->incidencia($parametros);
                break;
            case 'bonos':
                $data = $this->bonos($parametros);
                break;
            case 'Periodos_liberar':
                $data = $this->Periodos_liberar($parametros);
                break;
            case 'siniestros':
                $data = $this->siniestros($parametros);
                break;
            case 'alerta':
                $data = $this->alertas($parametros);
                break;
            case 'alerta_evaluacion':
                $data = $this->alerta_evaluacion($parametros);
                break;
            case 'alerta_compartir':
                $data = $this->alerta_archvio($parametros);
                break;
            case 'alerta_pip':
                $data = $this->alerta_pip($parametros);
                break;
            default:
                break;
        }

        $result = new  \stdClass;
        if (count($data) > 0) {
            $result->html = $this->parseNotification($obNoti["plantilla"], $data);
            $result->data = $data;
            return $result;
        }
    }

    public function parseNotification($pathString, $data)
    {
        if (!empty($pathString) && !empty($data)) {
            $view = $this->CI->parser->parse($pathString, $data, TRUE);
            return $view;
        }
    }


    // /*RECUPERA DE UN STORE PROCEDURE EL ID Y EL CORREO PARA NOTIFICAR */
    // function recuperarContacto($parametros)
    // {
    //     $result = $this->CI->db->query('CALL recuperar_contacto_tic(?)', $parametros);
    //     $res = $result->result();
    //     $result->next_result();
    //     $result->free_result();
    //     return $res;
    // }

    public function error()
    {
        $this->error;
        return $this;
    }

    public function unread()
    {
        $this->only_unread = 1;
        return $this;
    }

    public function mark_as_read()
    {
        if ($this->persona_id) {
            $this->ci->db->where('persona_id', $this->persona_id);
        }
        if ($this->id) {
            $this->ci->db->where('notificacion_id', $this->id);
        }

        $this->ci->db->update($this->notificationUserTable, array("leido" => date("Y:m:d H:i:s", time())));
    }

    public function mark_as_unread()
    {
        if ($this->persona_id) {
        }
        $this->ci->db->where('persona_id', $this->persona_id);
        if ($this->id) {
            $this->ci->db->where('notificacion_id', $this->id);
        }

        $this->ci->db->update($this->notificationUserTable, array("leido" => NULL));
    }

    // private function _querybuilder()
    // {
    //     if ($this->tipo) {
    //         $this->ci->db->where("{$this->notificationTable}.tipo", $this->tipo);
    //     }
    //     if ($this->tipo_id) {
    //         $this->ci->db->where("{$this->notificationTable}.tipo_id", $this->tipo_id);
    //     }
    //     if ($this->token) {
    //         $this->ci->db->where("{$this->notificationTable}.token", $this->token);
    //     }
    //     if ($this->comment) {
    //         $this->ci->db->where("{$this->notificationTable}.comment", $this->comment);
    //     }
    //     if ($this->persona_id) {
    //         $this->ci->db->where("{$this->notificationUserTable}.persona_id", $this->persona_id);
    //     }
    //     if ($this->only_unread) {
    //         $this->ci->db->where("{$this->notificationUserTable}.leido", NULL);
    //     }
    //     if ($this->id) {
    //         $this->ci->db->where("{$this->notificationUserTable}.notificacion_id", $this->id);
    //     }
    // }


    // public function pagination($offset, $limit = 0){
    //     if($limit){
    //         $this->page_limit = $limit;                
    //     }else{
    //         $this->page_offset = $offset - 1;
    //     }
    //     return $this;
    // }

    public function dbclearn($result)
    {

        if ($result->num_rows() > 1) {
            return $result->result();
        }
        if ($result->num_rows() == 0) {
            return $result->row();
        } else {
            return false;
        }
    }


    /*ANTES_VACACIONES*/
    function before_vacaciones($obNoti, $parametros)
    {
        $newparametrosdata = array();

        if (empty($obNoti["dias_previos"])) {
            return;
        }
        // $newparametrosdata["referencia"] = $parametros["data"]->idincidencias;
        // // $parametros["reference_id"] = $parametros["data"]->id;
        $dias_previos = $obNoti["dias_previos"];
        $date = date('Y-m-d');
        $fechaini = $parametros["data"]->fecha_inicio;
        $fecha = date("Y-m-d", strtotime("$fechaini -$dias_previos day"));
        $fecha_interval = date_create($date);
        $fecha_xd = date_create($fecha);
        $fecha_diff = date_diff($fecha_interval, $fecha_xd);
        if ($fecha_diff->days == 0) {
            $empleado_id = $parametros["data"]->empleado_id;
            $tipo = $obNoti["categoria"];

            $contactos = $this->CI->notificacionmodel->recuperarContacto($tipo, $empleado_id);
            // if (count($contactos) > 0) {
            array_push($newparametrosdata, array("contactos_notificar" => $contactos, "referencia" => $parametros["data"]->idincidencias));
            // }else{
            //     array_push($newparametrosdata, array("referencia" => $parametros["data"]->idincidencias));
            // }
        }
        return $newparametrosdata;
    }

    /*DISPONIBLE_EVALUACION */
    function disponibilidad_evaluacion($tipo, $idPersona, $clave)
    {
    }

    /*ANTES_EVALUACION*/
    function antes_evaluacion($obNoti, $parametros)
    {
        $array_parametros = json_decode(json_encode($parametros["data"]), True);
        $group = $this->group_by("puesto_id", $array_parametros);
        $new = array();
        foreach ($group as $key => $value) {
            if (is_array($value) || is_object($value)) {

                foreach ($value as $key => $item) {
                    if (empty($item["dias_previos"]) & empty($item["tipo_evaluacion"]) & $item["puesto_id"] > 0) {
                        return;
                    }
                    $dias_previos = $item["dias_previos"];
                    $date = date('Y-m-d');
                    $fechaini = $item["fecha_inicio"];
                    $fecha = date("Y-m-d", strtotime("$fechaini -$dias_previos day"));
                    $fecha_interval = date_create($date);
                    $fecha_xd = date_create($fecha);
                    $fecha_diff = date_diff($fecha_interval, $fecha_xd);
                    if ($fecha_diff->days == 0) {
                        $tipo = $item["tipo"];
                        $puesto = $item["puesto_id"];

                        $contactos = $this->CI->notificacionmodel->recuperarContacto($tipo, $puesto);
                        // if (count($contactos) > 0) {
                        // $newparametrosdata["contactos_notificar"] = $contactos;
                        // $newparametrosdata["data"] = $group;          
                        $array = array_merge(array("referencia" => $item), array("contactos_notificar" => $contactos));

                        array_push($new, $array);
                        // }
                    }
                }
            }
        }
        return $new;
    }

    /*ANTES_EVALUACION_CIERRE */
    function antes_evaluacion_cierre($obNoti, $parametros)
    {
        $array_parametros = json_decode(json_encode($parametros["data"]), True);
        $group = $this->group_by("puesto_id", $array_parametros);
        $new = array();
        foreach ($group as $key => $value) {

            if (is_array($value) || is_object($value)) {

                foreach ($value as $key => $item) {
                    if (empty($item["dias_previos"]) & empty($item["tipo_evaluacion"]) & $item["puesto_id"] > 0) {
                        return;
                    }

                    $dias_previos = $item["dias_previos"];
                    $date = date('Y-m-d');
                    $fechaini = $item["fecha_inicio"]; //2020-03-02
                    $periodo_evaluacion = $item["tiempo_periodo"]; //3
                    $fecha = date("Y-m-d", strtotime("$fechaini +$periodo_evaluacion month"));
                    $fecha_real = date("Y-m-d", strtotime("$fecha -$dias_previos day"));
                    $fecha_today = date_create($date);
                    $fecha_xd = date_create($fecha_real);
                    $fecha_diff = date_diff($fecha_today, $fecha_xd);
                    if ($fecha_diff->days == 0) {
                        $tipo = $item["tipo"];
                        $puesto = $item["puesto_id"];

                        $contactos = $this->CI->notificacionmodel->recuperarContacto($tipo, $puesto);
                        // if (count($contactos) > 0) {
                        $array = array_merge(array("referencia" => $item), array("contactos_notificar" => $contactos));
                        array_push($new, $array);
                        // }
                    }
                }
            }
        }
        return $new;
    }

    /*INCIDENCIA*/
    function incidencia($parametros)
    {
        $new = array();
        $tipo = $parametros["tipo"];
        $id_persona = $parametros["id_persona"];
        $contactos = $this->CI->notificacionmodel->recuperarContacto($tipo, $id_persona);
        $usrDataPe=array();
        $usrDataPe[0]['URL'] = base_url().'incidencias';
        array_push($new, array("contactos_notificar" => $contactos,"dataCorreo" => $usrDataPe));
        return $new;
    }
    /*SINIESTROS */
    function siniestros($parametros){
        $new = array();
        //$contactos = $this->CI->notificacionmodel->getUsrBonos();
        $contactos=$this->CI->notificacionmodel->getUsrAlertas($parametros["id_persona"]);
        $usrDataPe=array();
        //$usrDataPe = $this->CI->notificacionmodel->getdataSiniestro($parametros['idSeguimiento']);
        $usrDataPe[0]['Titulo'] = "MÓDULO DE SINIESTROS";
        $usrDataPe[0]['Estado'] = "AGREGADO";
        $usrDataPe[0]['Agregados'] = $parametros['Agregados'];
        $usrDataPe[0]['Actualizados'] = $parametros['Actualizados'];
        $usrDataPe[0]['Fecha'] = $parametros['fecha'];
        $usrDataPe[0]['URL'] = base_url().'Siniestros/registros';

        array_push($new, array("referencia" => $parametros['referencia'], "contactos_notificar" => $contactos, "dataCorreo" => $usrDataPe));
        //var_dump($new);
        return $new;
    }

    /*ALERTAS*/
    function alertas($parametros){
        $new = array();
        $contactos = $this->CI->notificacionmodel->getUsrAlertas($parametros["usuario"]);
        $usrDataPe=array();
        //$usrDataPe = $this->CI->notificacionmodel->getdataSiniestro($parametros['idSeguimiento']);
        if($parametros["Tipo"]==1){
            $usrDataPe[0]['Contenido'] = "Los siguientes siniestros han pasado los dias de acción para su atención, verifique la plataforma:";
        }else{
            $usrDataPe[0]['Contenido'] = "Los siguientes siniestros han escalado los dias de acción para su atención por parte de los ajustadores, verifique la plataforma:";
        }
        $usrDataPe[0]['Titulo'] = "MÓDULO DE SINIESTROS";
        $usrDataPe[0]['Tabla']=$parametros["tabla"];
        $usrDataPe[0]['URL'] = base_url().'Siniestros/registros';

        array_push($new, array("referencia" => $parametros['referencia'], "contactos_notificar" => $contactos, "dataCorreo" => $usrDataPe));
        //var_dump($new);
        return $new;
    }


    function alerta_evaluacion($parametros){
        $new = array();
        $tipo = $parametros["tipo"];
        $contactos = $this->CI->notificacionmodel->getUsrAlertas($parametros["usuario"]);
        $usrDataPe=array();
        if ($tipo==1){
            $usrDataPe[0]['Titulo'] = "EVALUACIÓN POR EMPEZAR";
            $usrDataPe[0]['Contenido'] = "El período ". $parametros["Periodo"]." esta por iniciar en ".$parametros["Dias"]." dias, este al pendiente de este evento cuando inicie el dia ".$parametros["FechaP"].".";
            $usrDataPe[0]['URL'] = base_url();
        }else{
            $usrDataPe[0]['Titulo'] = "EVALUACIÓN PENDIENTE";
            $usrDataPe[0]['Contenido'] = "Tiene una evaluacion pendiente por reponder del periodo ".$parametros["Periodo"].", ingrese a la plataforma contestarla.";
            $usrDataPe[0]['URL'] = base_url()."miInfo/?periodo=".$parametros["referencia"]."#evaluaciones";
        }
        //var_dump($usrDataPe);
        array_push($new, array("referencia" => $parametros['referencia'], "contactos_notificar" => $contactos, "dataCorreo" => $usrDataPe));
        //var_dump($new);
        return $new;
    }

    function alerta_archvio($parametros){
        $new = array();
        $usrDataPe=array();
        $usrDataPe[0]['Titulo'] = "ARCHIVO COMPARTIDO";
        $usrDataPe[0]['Contenido']=$parametros["Mensaje"];
        if ($parametros["File"]["mimeType"]=="application/vnd.google-apps.folder"){
            $usrDataPe[0]['Archivo'] = "https://drive.google.com/drive/folders/".$parametros["File"]["id"]."?usp=sharing";
        }else{
            $usrDataPe[0]['Archivo'] = "https://drive.google.com/file/d/".$parametros["File"]["id"]."?usp=sharing";
        }
        $contactos = $this->CI->notificacionmodel->getUserByPuestos($parametros["Puestos"]);
        array_push($new, array("referencia" => $parametros['referencia'], "contactos_notificar" => $contactos, "dataCorreo" => $usrDataPe));
        return $new;
        //var_dump($contactos);
        //var_dump($parametros);
    }

    function alerta_pip($parametros){
        $new = array();
        $usrDataPe=array();
        $dataPIP=$this->CI->notificacionmodel->getInfoPIP($parametros["referencia"]);
        $usrDataPe[0]['Titulo'] = "PIP (PERFORMANCE IMPPROVEMENT PLAN)";
        $usrDataPe[0]['Usuario']=$dataPIP[0]["nombre"];
        $usrDataPe[0]['URL']=base_url()."miInfo#otros";
        $contactos = $this->CI->notificacionmodel->getUsrEmail($parametros["id_persona"]);

        array_push($new, array("referencia" => $parametros['referencia'], "contactos_notificar" => $contactos, "dataCorreo" => $usrDataPe));
        return $new;
    }

    /*BONOS*/
    function bonos($parametros)
    {
        $new = array();
        $usrDataPe = $this->CI->notificacionmodel->getUsrByBonoPeticion($parametros['idSeguimiento']); //retorna info del usr para la peticion
        $usrDataPe[0]['URL'] = base_url().'Bonos';
        if ($parametros['TipoBono'] == 1) {
            $usrDataPe[0]['Titulo'] = "BONO PENDIENTE";
            $usrDataPe[0]['Estado'] = "PENDIENTE";
            $contactos = $this->CI->notificacionmodel->getUsrBonos();
        } elseif ($parametros['TipoBono'] == 4) {
            $usrDataPe[0]['Titulo'] = "BONO REPLICA";
            $usrDataPe[0]['Estado'] = "REPLICA";
            $contactos = $this->CI->notificacionmodel->getUsrBonos();
        } else {
            $parametros['TipoBono'] == 2 ? $usrDataPe[0]['Titulo'] = "BONO APROBADO" : $usrDataPe[0]['Titulo'] = "BONO REACHAZADO";
            $parametros['TipoBono'] == 2 ? $usrDataPe[0]['Estado'] = "APROBADA" : $usrDataPe[0]['Estado'] = "REACHAZADA";
            //Persona a notificar
            $usrdta = $this->CI->notificacionmodel->getUsrEmail($parametros["id_persona"]);
            $contactosD = $this->CI->notificacionmodel->getUsrBonos();
            $contactos = array_merge($contactosD, $usrdta);
        }
        //print_r($new);
        //print_r($contactos);
        array_push($new, array("referencia" => $parametros['referencia'], "contactos_notificar" => $contactos, "dataCorreo" => $usrDataPe));
        return $new;
    }

    function incidencias2($parametros)
    {
        $new = array();
        $usrDataPe = array();
        $contactosAdm = $this->CI->notificacionmodel->getUsrBonos();
        $usr = $this->CI->notificacionmodel->getPersonaIncidencia($parametros["id_persona"]);

        $usrDataPe = $this->CI->notificacionmodel->getDtaIncidencia($parametros["id_incidencia"]);
        $usrDataPe[0]['URL'] = base_url().'incidencias';
        if (empty($usr)) {
            $usrNew = $this->CI->notificacionmodel->getPersonaIncidencia($parametros["id_persona"]);
           $contactos = array_merge($contactosAdm, $usrNew);
        } else {
            $contactosD = $this->CI->notificacionmodel->getUsNotIncidencias($usr[0]->padrePuesto);
            $cont = $this->CI->notificacionmodel->getUserContIncidencias(); //Buscar el id del usuario de Contabilidad
            $contactos = array_merge($contactosD, $usr, $contactosAdm, $cont);
        }
        if ($parametros['Tipoinc'] == 2) { //datos especificos para el email
            $parametros['Opcion'] == 'INCIDENCIA_APROBADA' ? $usrDataPe[0]['Titulo'] = "INCIDENCIA APROBADA" : $usrDataPe[0]['Titulo'] = "INCIDENCIA RECHAZADA";
        } else {
            $usrDataPe[0]['Titulo'] = "INCIDENCIA ACTIVA";

        }
        //$contactos = array_merge($contactosD, $usr, $contactosAdm);
        /* print_r($contactos);
        print_r($usrDataPe); */
        array_push($new, array("referencia" => $parametros['referencia'], "contactos_notificar" => $contactos, "dataCorreo" => $usrDataPe));
        return $new;
    }

    function Periodos_liberar($parametros)
    {
        $new = array();
        $arrayRepeat=array();
        $contactosAdm = $this->CI->notificacionmodel->getUsrBonos();
        $usrDataPe = $this->CI->notificacionmodel->getDataPeridos($parametros['referencia']);
        $usrDataPe[0]['URL'] = base_url().'miInfo';
        $contactos = array();
        foreach ($parametros['Allrows'] as $key => $value) {
            array_push($arrayRepeat,$value['aplica_id']);
            array_push($arrayRepeat,$value['empleado_id']);
            if(in_array($value['aplica_id'],$arrayRepeat)){
                $usr = $this->CI->notificacionmodel->getPersonaIncidencia($value['aplica_id']);
                if(!empty($usr)){
                    array_push($contactos, $usr[0]);
                }
            }
            if(in_array($value['empleado_id'],$arrayRepeat)){
                $usr = $this->CI->notificacionmodel->getPersonaIncidencia($value['empleado_id']);
                if(!empty($usr)){
                    array_push($contactos, $usr[0]);
                }
            }
        }
        //$completContactos=$contactos;
        //$completContactos=array_merge($contactos,$contactosAdm);
        if ($parametros['Opcion'] == 1) {
            $parametros['Tipo'] == "ESPERA" ? $usrDataPe[0]["Titulo"] = "INICIO DEL PERÍODO DE EVALUACIONES" : $usrDataPe[0]["Titulo"] = "PERÍODO DE EVALUACIONES ACTIVO";
            $usrDataPe[0]["dias"] = $parametros['Dias'];
        } else {
            $usrDataPe[0]["Titulo"] = "PERÍODO DE EVALUACIONES LIBERADO";
        }
        $usrDataPe[0]['URL'] = base_url();
        $completContactos=array_merge($contactos, $contactosAdm);
        $completContactos2=array_map("unserialize", array_unique(array_map("serialize", $completContactos)));
        array_push($new, array("referencia" => $parametros['referencia'], "contactos_notificar" => $completContactos2, "dataCorreo" => $usrDataPe));
        return $new;
    }

    /*VALIDA SI EL EMAIL ES VALIDO */
    function validate_email($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo 'correo valido';
        } else {
            echo 'correo invalido';
        }
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

        foreach ($data as $val => $item) {
            if (array_key_exists($key, $item)) {
                $result[$item[$key]][] = $item;
            } else {
                $result[""][] = $item;
            }
        }
        return $result;
    }
}
