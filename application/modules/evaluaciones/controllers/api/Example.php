<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
//require(APPPATH.'core/TIC_Controller.php');
//require(APPPATH.'/libraries/Rest.php');
class Example extends REST{
    public $global;
    function __construct()
    {
        parent::__construct();
        error_reporting(E_ALL & ~E_NOTICE);
        //$this->dataNotificaciones();
        $this->config->load('global', TRUE);
        $this->global = $this->config->item('global');
        //$this->load->model('servicios_model', 'bonos');
        $this->load->library('notifications', $this->global);
        $this->load->library('webservice');
        $this->load->model('notificacionmodel', 'notificacion');
        $this->load->model('siniestros_model', 'siniestros');
        $this->load->model('servicios_model', 'servicios');

    }

    public function get_index()
    {
        header('Access-Control-Allow-Origin: *');
        $all=$this->servicios->getAllAPI();
        try {
            foreach ($all as $key => $value) {
                //$this->insertsiniestros($value["aseguradora_id"],$value["cliente_id"]);
                //$this->escalaSiniestros($value["aseguradora_id"],$value["cliente_id"]);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }

        $this->response($all);
    }

    function insertsiniestros($aseguradora,$cliente){
        date_default_timezone_set('UTC');
        $fechaI = date("Y-m-d");
        $fechaF = date('Y-m-d', strtotime("+1 day"));
        $validate=$this->siniestros->validateServicio($aseguradora,$cliente,"RANGO","SERVICIO");
        $validateUP=$this->siniestros->validateServicio($aseguradora,$cliente,"INDIVIDUAL","SERVICIO");
        $datos2=$this->datos_WS($validateUP);
        if(!empty($validate)){
            $datos=$this->datos_WS($validate);
            $datos['conexion']->FechaInicio=$fechaI;
            $datos['conexion']->FechaFin=$fechaF;
            $data=$this->webservice->consumoWS($datos['conexion'],$datos['url']);
            $actualizados=0;
            $Agregados=0;
            if($data['codigo']!=400){
                //actualizacion de los siniestros
                $siniestros_update=$this->siniestros->getAll_siniestros_Update();
                foreach($siniestros_update as $registro){
                    $datos2['conexion']->solicitud=$id;
                    $responseUdp=$this->webservice->consumoWS($datos2["conexion"],$datos2["url"]);
                    $value=$this->validate_update($registro,$responseUdp["Data"][0]);
                    $actualizados=$actualizados+$value;
                }
                //Agrega los nuevos siniestros en la fecha correspondiente seleccionada
                foreach($data["Data"] as $value){
                    if(is_array($value)){
                        $today = date("Y-m-d H:i");
                        if($this->siniestros->find_id_siniestro($value["cabina_id"])!=TRUE){
                            //$value+=['aseguradora_id'=>$aseguradora,'cliente_id'=>$cliente];
                            $value["aseguradora_id"]=$aseguradora;
                            $value["cliente_id"]=$cliente;
                            //$value["agregado_por"]=$this->tank_auth->get_idPersona();
                            $value["agregado"]=$today;
                            $this->siniestros->insertSiniestro($value);
                            $Agregados++;
                        }
                    }
                }
            }
            if($actualizados!=0 ||$Agregados!=0){
                $usuarios=$this->servicios->getUsersCliente($cliente);
                $format=array();
                foreach ($usuarios as $key => $value) {
                    //$this->sendNotificacionManual("SINIESTROS", array("idSeguimiento" => "15", "id_persona" => $value['id'],"Agregados"=>$Agregados,"Actualizados"=>$actualizados, "fecha"=>$today, "referencia" => "15"));
                }
                $array_update=array("aseguradora_id"=>$cliente,"fecha"=>$today);
                //$this->siniestros->insertUpdate($array_update);
            }
            $result=array("actualizados"=>$actualizados,"Agregados"=>$Agregados);
            //$this->response($data["codigo"], $data["codigo"]!=200?"Servicio no disponible":"Exíto", $data["Data"]);
        }else{
           // $this->response("400", "No se cuentan con los permisos", []);
        }
    }
    function escalaSiniestros($aseguradora,$cliente){
        $siniestros=array();
        $escala=$this->servicios->escalamiento($cliente);
        $usuarios=array("esc_1"=>array(),"esc_2"=>array());
        $dias1='';$dias2='';
        $siniestros=array("esc_1"=>array(),"esc_2"=>array());
        foreach ($escala as $key => $value) {

            $dtESC1=(array)json_decode($value["escalamiento_1"]);
            foreach ($dtESC1 as $key2 => $value2) {
                foreach ((array)$value2 as $key3 => $value3) {
                   if($key2=="usuarios"){
                       if(!in_array($value3->value,$usuarios["esc_1"])){
                            $usuarios["esc_1"][]=$value3->value;
                       }
                   }else{
                       $dias1=intval($value3);
                   }
                }
            }
            $dtESC2=(array)json_decode($value["escalamiento_2"]);
            foreach ($dtESC2 as $key2 => $value2) {
                foreach ((array)$value2 as $key3 => $value3) {
                   if($key2=="usuarios"){
                       if(!in_array($value3->value,$usuarios["esc_2"])){
                            $usuarios["esc_2"][]=$value3->value;
                       }
                   }else{
                        $dias2=intval($value3);
                    }
                }
            }
            $datsiniestros=$this->servicios->getSiniestrosEscala(1,$dias1,$dias2,$value["Tipo"]);
            foreach ($datsiniestros as $keyd => $valued) {
                if($valued["tipo"]=="esc_1"){
                    $siniestros["esc_1"][]=array("siniestro_id"=>$valued["siniestro_id"],"parametro"=>$valued["diasI"],"diasD"=>$valued["trans"]);
                }else{
                    $siniestros["esc_2"][]=array("siniestro_id"=>$valued["siniestro_id"],"parametro"=>$valued["diasI"],"diasD"=>$valued["trans"]);
                }
                
            }
        }

        foreach ($usuarios["esc_1"] as $key => $value) {
            //$this->sendNotificacionManual("ALERTA", array("tabla"=>$this->tablacorreoES($siniestros["esc_1"]),"usuario"=>$value,"referencia" => "20","Tipo"=>2),array('web','email'));
        }
        foreach ($usuarios["esc_2"] as $key => $value) {
            //$this->sendNotificacionManual("ALERTA", array("tabla"=>$this->tablacorreoES($siniestros["esc_2"]),"usuario"=>$value,"referencia" => "20","Tipo"=>2),array('web','email'));
        }
    }
    function datos_WS($data){
        $datosSQL=json_decode($data[0]["datos"]);
        return array("url"=>$datosSQL->url,"conexion"=>$datosSQL->objetojson);
    }
    function sendNotificacionManual($clave, $parametros,$tipe=null)
    {
        $result = array();

        if (empty($clave)) {
            return;
        }

        $obNoti = array_filter($this->notifications->notificaciones, function ($item) use ($clave) {
            return $item["clave"] == $clave;
        });

        if (count($obNoti) > 0) {
            $obNoti = $obNoti[key($obNoti)];
            $tipos = $tipe==null?$obNoti["tipo"]:$tipe;

            if (empty($obNoti["plantilla"]) || empty($obNoti["function"])) {
                return;
            }

            if (!empty($obNoti["categoria"])) {
                $referencia_id = $obNoti["categoria"];
            }

            if (!empty($obNoti["clave"]) == $clave) {
                $clave_tipo = $obNoti["clave"];
            }

            // $clave = $obNoti["clave"];
            // $categoria = $obNoti["categoria"];

            $resultNoti = $this->notifications->notify($obNoti, $parametros);
            //var_dump($resultNoti);

            if (count($resultNoti) > 0) {
                foreach ($resultNoti->data as $result) {
                    foreach ($tipos as $key => $value) {

                        switch ($value) {
                            case 'email':
                                /* $obContact = null;
                                foreach ($this->notifications->contacts as $key => $value) {
                                    if ($key == $clave) {
                                        $obContact = $value;
                                        return;
                                    }
                                }

                                if ($obContact == null) {
                                    foreach ($this->notifications->contacts as $key => $value) {
                                        if ($key == "default") {
                                            $obContact = $value;
                                            return;
                                        }
                                    }
                                }
                                // $obContact = $obContact[key($obContact)];

                                $contacto_notificar = (isset($result["contactos_notificar"])) ? $result["contactos_notificar"] : null;
                                $referencias = (isset($result["referencia"])) ? $result["referencia"] : null;
                                var_dump($contacto_notificar);

                                $recuv_email = array();
                                $idpersona_and_email = array();

                                if (count($contacto_notificar) > 0) {
                                    $recuv_email = array_map(function ($item) {
                                        return $item->email;
                                    }, $contacto_notificar);

                                    $idpersona_and_email = array_map(function ($item) {
                                        return $item;
                                    }, $contacto_notificar);
                                }

                                if (!is_array(@$obContact["to"])) {
                                    $obContact["to"] = explode(",", $obContact["to"]);
                                }
                                if (count($recuv_email) > 0) {
                                    $to = array_unique(array_merge($recuv_email, $obContact["to"]));
                                } else {
                                    $to = @$obContact["to"];
                                }

                                $from = @$obContact["from"];
                                $subject = (isset($result->data["subject"])) ? $result->data["subject"] : @$obContact["subject"];
                                $cc = @$obContact["cc"];
                                $bcc = @$obContact["bcc"];

                                //$body = $resultNoti->html;
                                $body = $this->parseTemplate($resultNoti->html, $result['dataCorreo']); */
                                //var_dump($body);

                                $obContact = array_filter($this->notifications->contacts, function ($item, $key) use ($clave) {
                                    return $key == $clave;
                                }, ARRAY_FILTER_USE_BOTH);
    
                                if (count($obContact) == 0) {
                                    $obContact = array_filter($this->notifications->contacts, function ($item, $key) {
                                        return $key == "default";
                                    }, ARRAY_FILTER_USE_BOTH);
                                }
    
                                $obContact = $obContact[key($obContact)];
    
                                $contacto_notificar = (isset($result["contactos_notificar"])) ? $result["contactos_notificar"] : null;
                                $referencias = (isset($result["referencia"])) ? $result["referencia"] : null;
    
                                $recuv_email = array();
                                $idpersona_and_email = array();
    
                                if (count($contacto_notificar) > 0) {
                                    $recuv_email = array_map(function ($item) {
                                        return $item->email;
                                    }, $contacto_notificar);
    
                                    $idpersona_and_email = array_map(function ($item) {
                                        return $item;
                                    }, $contacto_notificar);
                                }
    
                                if (!is_array(@$obContact["to"])) {
                                    $obContact["to"] = explode(",", $obContact["to"]);
                                }
                                if (count($recuv_email) > 0) {
                                    $to = array_unique(array_merge($recuv_email, $obContact["to"]));
                                } else {
                                    $to = @$obContact["to"];
                                }
    
                                $from = @$obContact["from"];
                                $subject="Notificación Capsys";
                                //$subject = (isset($result->data["subject"])) ? $result->data["subject"] : @$obContact["subject"];
                                $cc = @$obContact["cc"];
                                $bcc = @$obContact["bcc"];
                                
                                //$body = $resultNoti->html;
                                $body=$this->parseTemplate($resultNoti->html,$result['dataCorreo']);
                                //var_dump($body);
                                if (count($to) > 0) {
                                    $this->notifications->sendemail($from, $to, $subject, $body, $cc, $bcc);
                                }
                                // /*$idpersona_and_email == EMAILS */
                                // /*$value = email o web */
                                // /*$resultNoti->html == plantilla para el correo*/
                                // /*$clave_tipo == nombre de la funcion(before_vacaciones,antes_evaluacion_cierre) */
                                // /*$referencia_id ==  EVALUACION O INDICENCIAS O FALTAS*/
                                // /*$referencias == referencia de la incidencia o evaluacion o faltas */
                                $this->notificacion->add($idpersona_and_email, $value, 'ENVIADA'/* $resultNoti->html */, $clave_tipo, $referencia_id, $referencias);
                                break;
                            case 'web':
                                /*VERIFICAR DE NUEVO EL DE WEB */
                                $obContact = array();
                                foreach ($this->notifications->contacts as $key => $value) {
                                    if ($key == $clave) {
                                        $obContact[] = $value;
                                        break;
                                    }
                                }

                                if (count($obContact) == 0) {
                                    foreach ($this->notifications->contacts as $key => $value) {
                                        if ($key == "default") {
                                            $obContact[] = $value;
                                            break;
                                        }
                                    }
                                }

                                $obContact = $obContact[key($obContact)];
                                $contacto_notificar = (isset($result->data["contactos_notificar"])) ? $result->data["contactos_notificar"] : null;
                                $referencias = (isset($result->data["data"])) ? $result->data["data"] : null;

                                $recuv_email = array();
                                $idpersona_and_email = array();

                                if (count($contacto_notificar) > 0) {
                                    $recuv_email = array_map(function ($item) {
                                        return $item->email;
                                    }, $contacto_notificar);

                                    $idpersona_and_email = array_map(function ($item) {
                                        return $item;
                                    }, $contacto_notificar);
                                }

                                if (!is_array(@$obContact["to"])) {
                                    $obContact["to"] = explode(",", $obContact["to"]);
                                }
                                if (count($recuv_email) > 0) {
                                    $to = array_unique(array_merge($recuv_email, $obContact["to"]));
                                } else {
                                    $to = @$obContact["to"];
                                }

                                //$this->notificacion->add($idpersona_and_email, $value, $result->html, $clave, $referencias);
                                break;
                        }
                    }
                }
            }
        }
    }

    public function parseTemplate($template, $variables)
    {
        foreach ($variables[0] as $key => $value) {
            $template = str_replace('{{ ' . $key . ' }}', $value, $template);
        }
        //echo $template;
        return $template;
    }
    function validate_update($registro,$response){
        $diff=[];
        foreach ($response as $key => $value) {
            if(strval($registro[$key])!=strval($value)){
                $diff[$key]=$value;
            }
         }
        date_default_timezone_set('America/Mexico_City');
        $today=date("Y-m-d H:i:s");
        if(!empty($diff)){
            $siniestroAllData=$this->siniestros->get_single_siniestro_all($registro["cabina_id"]);
            $data=array(
                'siniestro_id'=>$registro["cabina_id"],
                'informacion'=>json_encode($siniestroAllData),
                'modificado'=>$today,
                'modificado_por'=>$this->tank_auth->get_idPersona(),
                'aseguradora_id'=>0
            );
            $diff["modificado_por"]=0;
            $diff["modificado"]=$today;
            $this->siniestros->insert_siniestro_bitacora($data);
            $this->siniestros->updateSiniestroWS($registro["cabina_id"],$diff);
            return 1;
        }else{
            return 0;
        }
    }


    private function dataNotificaciones()
    {
        $this->load->library('notifications', $this->global);
        $this->load->model('notificacionmodel', 'notificacion');
        $data = $this->notificacion->getAllNotificaciones($this->tank_auth->get_idPersona());
        /* $data=$this->tank_auth->get_idPersona(); */
        $this->dataNotificacion = $data;
    }

}