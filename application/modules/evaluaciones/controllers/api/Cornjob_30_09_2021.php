<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cornjob extends CI_Controller
{
    public $global;
    function __construct()
	{
        parent::__construct();
        error_reporting(E_ALL & ~E_NOTICE);
        $this->config->load('global', TRUE);
        $this->global = $this->config->item('global');
        //$this->load->model('servicios_model', 'bonos');
        $this->load->library('notifications', $this->global);
        $this->load->library('webservice');
        $this->load->model('notificacionmodel', 'notificacion');
        $this->load->model('siniestros_model', 'siniestros');
        $this->load->model('servicios_model', 'servicios');
        $this->load->model('evaluacion_periodos_model','periodos');

    }
    
    public function index()
    {
        header('Content-Type: application/json');
        $all=$this->servicios->getAllAPI();
        $allother=$this->servicios->getAllusersNoty();
        
        try {
            //sniestros de Autos Coporativo, asi como la actaulizacion automatica
            foreach ($all as $key => $value) {
                $this->insertsiniestros($value["aseguradora_id"],$value["cliente_id"]);
                $this->escalaSiniestros($value["aseguradora_id"],$value["cliente_id"]);
            }
            //escaala otros modulos
            foreach ($allother as $key => $value) {
                $this->escalaSiniestrosNuevos($value);
             }

        } catch (\Throwable $th) {
            //throw $th;
        }
        echo json_encode(array(
            "code"=>http_response_code(200),
            "message"=>"Exito",
            "data"=>[]
        ));
        die;
    }

    function insertsiniestros($aseguradora,$cliente){
        date_default_timezone_set('America/Mexico_City');
        $fechaI = date("Y-m-d",strtotime("-1 day"));
        $fechaF = date('Y-m-d', strtotime("+1 day"));
       /*  $fechaI = date("Y-m-d");
        $fechaF = date('Y-m-d', strtotime("+1 day")); */
        $validate=$this->siniestros->validateServicio($aseguradora,$cliente,"RANGO","SERVICIO");
        $validateUP=$this->siniestros->validateServicio($aseguradora,$cliente,"INDIVIDUAL","SERVICIO");
        $datos2=$this->datos_WS($validateUP);
        if(!empty($validate)){
            $datos=$this->datos_WS($validate);
            $datos['conexion']->FechaInicio=$fechaI;
            $datos['conexion']->FechaFin=$fechaF;
            $data=$this->webservice->consumoWS($datos['conexion'],$datos['url']);
            //var_dump($data);
            $actualizados=0;
            $Agregados=0;
            if($data['codigo']!=400){
                //actualizacion de los siniestros
                if(!empty($validateUP)){
                    /* $siniestros_update=$this->siniestros->getAll_siniestros_Update();
                    foreach($siniestros_update as $registro){
                        $datos2['conexion']->solicitud=$registro["cabina_id"];
                        $responseUdp=$this->webservice->consumoWS($datos2["conexion"],$datos2["url"]);
                        $value=$this->validate_update($registro,$responseUdp["Data"][0]);
                        $actualizados=$actualizados+$value;
                    } */
                }
                //Agrega los nuevos siniestros en la fecha correspondiente seleccionada
                foreach($data["Data"] as $value){
                    if(is_array($value)){
                        $today = date("Y-m-d H:i");
                        if($this->siniestros->find_id_siniestro($value["cabina_id"])!=TRUE){
                            //$value+=['aseguradora_id'=>$aseguradora,'cliente_id'=>$cliente];
                            $value["aseguradora_id"]=$aseguradora;
                            $value["cliente_id"]=$cliente;
                            $value["agregado_por"]=0;
                            $value["agregado"]=$today;
                            if($value["cabina_id"]){
                                $this->siniestros->insertSiniestro($value);
                            }
                            $Agregados++;
                        }
                    }
                }
            }
            if($actualizados!=0 ||$Agregados!=0){
                $usuarios=$this->servicios->getUsersCliente($cliente);
                $format=array();
                foreach ($usuarios as $key => $value) {
                    if($value['id']!='6'){
                        $this->sendNotificacionManual("SINIESTROS", array("idSeguimiento" => "15", "id_persona" => $value['id'],"Agregados"=>$Agregados,"Actualizados"=>$actualizados, "fecha"=>$today, "referencia" => "15"));
                    }
                }
                $array_update=array("aseguradora_id"=>$cliente,"fecha"=>$today);
                $this->siniestros->insertUpdate($array_update);
            }
            $result=array("actualizados"=>$actualizados,"Agregados"=>$Agregados);
           // $this->responseJSON($data["codigo"], $data["codigo"]!=200?"Servicio no disponible":"Exíto", $data["Data"]);
        }else{
            //$this->responseJSON("400", "No se cuentan con los permisos", []);
        }
    }
    function escalaSiniestros($aseguradora,$cliente){
       //alertas de los siniestros en caso de que esten escalados
       $usuarios = $this->servicios->getUsersCliente($cliente);
       foreach ($usuarios as $key => $value) {
           ///siniestros que son escalados
           $es_0 = $this->servicios->escalamiento($cliente, 'esc_0', $value['id']); ///escala 0
           $es_1 = $this->servicios->escalamiento($cliente, 'esc_1', $value['id']); ///escala 1
           $es_2 = $this->servicios->escalamiento($cliente, 'esc_2', $value['id']); ///escala 2
           $full=array_merge($es_0, $es_1, $es_2);
           if(!empty($full)){
                $tabla = $this->tablacorreoE($full);
                $this->sendNotificacionManual("ALERTA", array("tabla" => $tabla, "usuario" => $value['id'], "referencia" => "20", "Tipo" => 1), array('web', 'email'));
           }
       }
    }
    function escalaSiniestrosNuevos($usuario){
        $es_0A = $this->servicios->escalamientoAutosI('esc_0', $usuario); ///escala 0
        $es_1A = $this->servicios->escalamientoAutosI('esc_1', $usuario); ///escala 1
        $es_2A = $this->servicios->escalamientoAutosI('esc_2', $usuario); ///escala 2

        $es_0D = $this->servicios->escalamientoDanos('esc_0', $usuario); ///escala 0
        $es_1D = $this->servicios->escalamientoDanos('esc_1', $usuario); ///escala 1
        $es_2D = $this->servicios->escalamientoDanos('esc_2', $usuario); ///escala 2

        $es_0G = $this->servicios->escalamientoGMM('esc_0', $usuario); ///escala 0
        $es_1G = $this->servicios->escalamientoGMM('esc_1', $usuario); ///escala 1
        $es_2G = $this->servicios->escalamientoGMM('esc_2', $usuario); ///escala 2
        $full=array_merge( $es_0A, $es_1A, $es_2A, $es_0D, $es_1D, $es_2D, $es_0G, $es_1G, $es_2G);
        if(!empty($full)){
            $tabla = $this->tablacorreoE($full);
            //echo  $usuario.'<br>';
            //echo '<table>';
            //echo $tabla;
            //echo '</table>';
            //var_dump($full);
            //echo '<br>------------------------------lol-----------------------------';
            $this->sendNotificacionManual("ALERTA", array("tabla" => $tabla, "usuario" =>  $usuario, "referencia" => "20", "Tipo" => 1), array('web', 'email'));
        }else{
            echo 'Sin datos de escala por el usuario';
        }
    }
    function datos_WS($data){
        $datosSQL=json_decode($data[0]["datos"]);
        return array("url"=>$datosSQL->url,"conexion"=>$datosSQL->objetojson);
    }
    public function sendNotificacionManual($clave, $parametros,$tipe=null)
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
                                $obContact = null;

                                $contacto_notificar = (isset($result["contactos_notificar"])) ? $result["contactos_notificar"] : null;
                                //var_dump($contacto_notificar);
                                $referencias = (isset($result["referencia"])) ? $result["referencia"] : null;
                                //var_dump($contacto_notificar);

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
                                $body = $this->parseTemplate($resultNoti->html, $result['dataCorreo']);
                                
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

    function tablacorreoE($array)
    {
        $table = "";
        $tipo = "";
        foreach ($array as $key => $value) {
            $valor=$value["transcurrido"]/$value["dias"];
            if ($tipo != $value["modulo"]) {
                $tipo = $value["modulo"];
                $modulo=isset($value["modulo"])?'-'.$value["modulo"]:'';
                //$titulo=$value["tipo"].$modulo;
                $table = $table . "<tr style='background-color:#ffffff;color: #472380;'><th colspan='6'>".$value["tipo"].$modulo."</th></tr>
                <tr style='background-color: #ccc;color: #472380;'>
                    <th>SINIESTRO</th>
                    <th>FECHA INICIO</th>
                    <th>TIPO</th>
                    <th>PARAMETRO</th>
                    <th>DÍAS TRANSCURRIDOS</th>
                    <th>SEMAFORO</th>
                </tr>";
            }
            $table = $table . "<tr style='background-color: #f7f5fa;color: #472380;'>
                <th>" . $value["siniestro_id"] . "</th>
                <th>" . date('d-m-y',strtotime($value["ocurrencia"])) . "</th>
                <th>" . strtoupper($value["nombre"]) . "</th>
                <th>" . $value["dias"] . "</th>
                <th>" . $value["transcurrido"] . "</th>
                <th style='background-color:".$this->semaforo($valor)."'></th>
            </tr>";
        }
        $table = $table . " <tr style='background-color:#ffffff;color: #ffffff;'><th style='height: 10px;' colspan='6'></th></tr>";
        return $table;
    }

    function semaforo($valor){
        $color='';
        if($valor>=0 && $valor <= 0.40){
            $color="#6dca6d";
        }
        if($valor > 0.40 && $valor <= 0.60){
            $color="#e8f051";
        }
        if($valor > 0.60 && $valor < 1){
            $color="#e68d10";
        }
        if($valor >= 1){
            $color="#db311a";
        }
        return $color;
    }

    function test(){
        echo 'test';
        $all=$this->servicios->getAllusersNoty();
        var_dump($all);
        //var_dump($this->servicios->getAllusersNoty());
        foreach ($all as $key => $value) {
            echo $value.'</br>';
           //$this->escalaSiniestrosNuevos($value);
        }
    }
   /*  function tablacorreoE($array)
    {
        $table = "";
        $tipo = "";
        foreach ($array as $key => $value) {
            if ($tipo != $value["tipo"]) {
                $tipo = $value["tipo"];
                $table = $table . "<tr style='background-color:#ffffff;color: #472380;'><th colspan='3'>$tipo</th></tr><tr style='background-color: #ccc;color: #472380;'><th>SINIESTRO</th><th>PARAMETRO</th><th>DÍAS TRANSCURRIDOS</th></tr>";
            }
            $table = $table . "<tr style='background-color: #f7f5fa;color: #472380;'><th>" . $value["cabina_id"] . "</th><th>" . $value["dias"] . "</th><th>" . $value["transcurrido"] . "</th></tr>";
        }
        $table = $table . " <tr style='background-color:#ffffff;color: #ffffff;'><th style='height: 10px;' colspan='3'></th></tr>";
        return $table;
    } */
}
