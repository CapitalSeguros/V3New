<?php
/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
defined('DIR_ASSETS')       or define('DIR_ASSETS',  'assets/gap/');
defined('DIR_IMAGES')       or define('DIR_IMAGES',  '/V3/assets/gap/');
defined('DIR_APP')       or define('DIR_APP',  '/V3/');
class TIC_Controller extends MX_Controller
{
    protected $allowed_img_types;
    public $vendor_id;
    public $vendor_name;
    public $vendor_url;
    private $result_footer;
    private $result_header;
    public $global;
    public function __construct()
    {
        parent::__construct();
        $this->config->load('global', TRUE);
        $this->global = $this->config->item('global');
        $this->loginCheck();
        $this->createMenu();
        $this->dataNotificaciones();
        $this->load->library('breadcrumbs');
        $this->load->library('notifications', $this->global);
        $this->load->model('notificacionmodel', 'notificacion');
        $this->load->model('capitalhumano_model', 'capitalH');
        $this->lang->load('tank_auth');
    }
    protected function loginCheck()
    {
        if (!$this->tank_auth->is_logged_in()) {
            redirect('/auth/login/');
        }
    }
    //funcion antigua
    /* public function render($template, $head, $data, $footer)
    {
        $head["_scripts"] = $this->result_header;
        $this->load->view('_parts/header', $head);
        $this->load->view($template, $data);
        $footer["_scripts"] = $this->result_footer;
        $this->load->view('_parts/footer', $footer);
    } */
    public function render($template, $head, $data, $footer)
    {
        //$this->load->model('servicios_model', 'servicio');
        $head["_scripts"] = $this->result_header;
        $head["ticc"]=true;
        $data["uri"]=$this->partial_uri();
        $this->load->view('headers/header',$head);
        $this->load->view('headers/menu');
        //$this->load->view('_parts/sidemenu',$data);
        //$data["tipo"]="CapitalHumano";
        //$data["tipo"]="Siniestros";
        //$this->load->view('_parts/header', $head);
        /* if(!empty($this->servicio->permiso($this->tank_auth->get_idPersonaPuesto(),$this->partial_uri()))){
            $this->load->view($template, $data);
        }else{
            if($this->partial_uri()=="evaluaciones/aplicar"){
                $this->load->view($template, $data);
               
            }else{
                $this->load->view("validation/errorpermiso", $data);
            }
            
        } */
        $this->load->view($template, $data);
        
        //$this->load->view($template, $data);
        $footer["_scripts"] = $this->result_footer;
        $this->load->view('footers/footer',$footer);
    }
    /**
     * @$elements array(type:JS o CSS, path)
     */
    public function footerScripts($elements)
    {
        $this->processScript($elements, $this->result_footer);
    }
    /**
     * @$elements array(type:JS o CSS, path)
     */
    public function headerScripts($elements)
    {
        $this->processScript($elements, $this->result_header);
    }

    private function processScript($elements, &$result_ref)
    {
        $result_ref = array();
        foreach ($elements as $key => $value) {
            switch ($value["type"]) {
                case 'JS':
                    array_push($result_ref, '<script src="' . base_url() . 'assets/' . $value["path"] . '" type="text/javascript" ></script>');
                    break;
                case 'CSS':
                    array_push($result_ref, '<link href="' . base_url() . 'assets/' . $value["path"] . '" rel="stylesheet"></link>');
                    break;
                case 'JSHTML':
                    array_push($result_ref, '<script type="text/javascript">' . $value["data"] . '</script>');
                    break;
                case 'JSON':
                    array_push($result_ref, '<script type="text/javascript" >' . $value["path"] . '</script>');
                    break;
                default:
                    break;
            }
        }
    }

    
    private function createMenu()
    {
        $menu = array(
            "dashboard" => array(
                "title" => "Tablero",
                "href" => DIR_APP . "evaluaciones/tablero",
                "icon" => "fa-eval"
            ),
            "periodos" => array(
                "title" => "Periodos",
                "href" => DIR_APP . "periodo",
                "icon" => "fa-eval"
            ),

            "incidencias" => array(
                "title" => "Incidencias",
                "href" => DIR_APP . "incidencias",
                "icon" => "fa-eval"
            ),
            "baja_catalogo" => array(
                "title" => "Catalogos",
                "child" => array(
                    array(
                        "title"=>"Capital humano",
                        "type"=>'CapitalHumano',
                        "child"=>array(
                            array(
                                "title" => "Tablero",
                                "icon"=>"fa fa-bar-chart",
                                "href" => DIR_APP . "evaluaciones/tablero",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Preguntas",
                                "icon"=>"fa fa-question",
                                "href" => DIR_APP . "Preguntas",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Competencias",
                                "icon"=>"fa fa-trophy",
                                "href" => DIR_APP . "Competencias",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Evaluaciones",
                                "icon"=>"fa fa-list",
                                "href" => DIR_APP . "evaluaciones/",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Periodos",
                                "icon"=>"fa fa-list",
                                "href" => DIR_APP . "periodo",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Tabulador de bonos",
                                "icon"=>"fa fa-table",
                                "href" => DIR_APP . "TabuladorBonos",
                                "tipo"=>0
                            ),
                        )
                    ),
                    array(
                        "title"=>"Siniestros",
                        "type"=>'Siniestros',
                        "child"=>array(
                            array(
                                "title" => "Tablero",
                                "icon"=>"fa fa-bar-chart",
                                "href" => DIR_APP . "Siniestros",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Registro de siniestros",
                                "icon"=>"fa fa-file-text-o",
                                "href" => DIR_APP . "siniestroCorporativo",
                                "tipo"=>0
                            ),
			    array(
                                "title" => "Reportes",
                                "icon" => "fa fa-bar-chart",
                                "href" => DIR_APP . "siniestroCorporativo/TableroReportes",
                                "tipo" => 0
                            ),
                            array(
                                "title" => "Pólizas",
                                "icon" => "fa fa-sticky-note-o",
                                "href" => DIR_APP . "siniestroCorporativo/Polizas",
                                "tipo" => 0
                            ),
                            array(
                                "title" => "Configuración aseguradoras",
                                "href" => DIR_APP . "Serviciosws/servicioWSAseguradoras",
                                "icon"=>"fa fa-cogs",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Clientes",
                                "href" => DIR_APP . "Serviciosws/servicioWSClientes",
                                "icon"=>"fa fa-user-plus",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Cliente-Ejecutivo",
                                "icon"=>"fa fa-users",
                                "href" => DIR_APP . "Serviciosws/cliente-ejecutivo",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Rangos de siniestros",
                                "href" => DIR_APP . "Siniestros/rangos",
                                "icon"=>"fa fa-list-ol",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Indicadores",
                                "icon"=>"fa fa-sort-numeric-asc",
                                "href" => DIR_APP . "Serviciosws/indicadores",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Configuración de alertas",
                                "icon"=>"fa fa-bell",
                                "href" => DIR_APP . "Serviciosws/notificaciones",
                                "tipo"=>0
                            ),
                            array( //Dennis Castillo [2022-01-18]
                                "title" => "Mis notas",
                                "icon"=>"fa fa-sticky-note-o",
                                "href" => base_url()."Siniestros/getMyNotes?tipo=S"
                            ),
                            /* array(
                                "title" => "Permisos",
                                "icon"=>"fa fa-bell",
                                "href" => DIR_APP . "Permisos"
                            ), */
                            
                        )
                    ),
                    array(
                        "title"=>"C_siniestros",
                        "type"=>'C_siniestros',
                        "child"=>array(
                            array(
                                "title" => "Estatus",
                                "icon"=>"fa fa-hourglass-start",
                                "href" => DIR_APP . "GMM/siniestro_estatus",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Tipo padecimientos GMM",
                                "icon"=>"fa fa-list-alt",
                                "href" => DIR_APP . "GMM/TiposCobertura",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Tipo cobertura Daños",
                                "icon"=>"fa fa-list-alt",
                                "href" => DIR_APP . "Siniestro_catalogos/TipoCoberturaDanos",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Tipo documento",
                                "icon"=>"fa fa-file-text-o",
                                "href" => DIR_APP . "Siniestro_catalogos/Tipo_documento",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Documentos trámites",
                                "icon"=>"fa fa-list-ol",
                                "href" => DIR_APP . "Siniestro_catalogos/TramitesDocumentos",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Trámites Daños",
                                "icon"=>"fa fa-list-alt",
                                "href" => DIR_APP . "Siniestro_catalogos/TiposTramitesDanos",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Trámites GMM",
                                "icon"=>"fa fa-list-alt",
                                "href" => DIR_APP . "Siniestro_catalogos/TiposTramitesGmm",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Causa cierre siniestro",
                                "icon"=>"fa fa-list-alt",
                                "href" => DIR_APP . "Siniestro_catalogos/Siniestro_causa_cierre",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Tipos Siniestro Autos",
                                "icon"=>"fa fa-list-alt",
                                "href" => DIR_APP . "Siniestro_catalogos/SiniestroTipoAutos",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Causas Siniestro Autos",
                                "icon"=>"fa fa-list-alt",
                                "href" => DIR_APP . "Siniestro_catalogos/SiniestroCausaAutos",
                                "tipo"=>0
                            ),
                        )
                    )
                    ,
                    array(
                        "title"=>"C_GMM",
                        "type"=>'C_GMM',
                        "child"=>array(
                            array(
                                "title" => "GMM",
                                "icon"=>"fa fa-heartbeat",
                                "href" => DIR_APP . "GMM",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Estatus",
                                "icon"=>"fa fa-hourglass-start",
                                "href" => DIR_APP . "Siniestro_catalogos/siniestro_estatus?tipo=G",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Tipo padecimientos GMM",
                                "icon"=>"fa fa-list-alt",
                                "href" => DIR_APP . "Siniestro_catalogos/Padecimientos?tipo=G",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Tipo documento",
                                "icon"=>"fa fa-file-text-o",
                                "href" => DIR_APP . "Siniestro_catalogos/Tipo_documento?tipo=G",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Documentos trámites",
                                "icon"=>"fa fa-list-ol",
                                "href" => DIR_APP . "Siniestro_catalogos/TramitesDocumentos?tipo=G",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Trámites GMM",
                                "icon"=>"fa fa-list-alt",
                                "href" => DIR_APP . "Siniestro_catalogos/TiposTramitesGmm?tipo=G",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Coberturas GMM",
                                "icon"=>"fa fa-list-alt",
                                "href" => DIR_APP . "Siniestro_catalogos/Coberturas_GMM?tipo=G",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Cierre Causa Siniestro",
                                "icon"=>"fa fa-list-alt",
                                "href" => DIR_APP . "Siniestro_catalogos/Siniestro_causa_cierre?tipo=G",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Indicadores",
                                "icon"=>"fa fa-sort-numeric-asc",
                                "href" => DIR_APP . "Serviciosws/indicadores?tipo=G",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Configuración de alertas",
                                "icon"=>"fa fa-bell",
                                "href" => DIR_APP . "Serviciosws/notificaciones?tipo=G",
                                "tipo"=>0
                            ),
                            array( //Dennis Castillo [2022-01-18]
                                "title" => "Mis notas",
                                "icon"=>"fa fa-sticky-note-o",
                                "href" => base_url()."Siniestro_catalogos/getMyNotes?tipo=G"
                            ),
                        )
                    )
                    ,
                    array(
                        "title"=>"C_DANOS",
                        "type"=>'C_DANOS',
                        "child"=>array(
                            array(
                                "title" => "DAÑOS",
                                "icon"=>"fa fa-wrench",
                                "href" => DIR_APP . "Danos",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Estatus",
                                "icon"=>"fa fa-hourglass-start",
                                "href" => DIR_APP . "Siniestro_catalogos/siniestro_estatus?tipo=D",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Tipo cobertura Daños",
                                "icon"=>"fa fa-list-alt",
                                "href" => DIR_APP . "Siniestro_catalogos/TipoCoberturaDanos?tipo=D",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Tipo documento",
                                "icon"=>"fa fa-file-text-o",
                                "href" => DIR_APP . "Siniestro_catalogos/Tipo_documento?tipo=D",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Documentos trámites",
                                "icon"=>"fa fa-list-ol",
                                "href" => DIR_APP . "Siniestro_catalogos/TramitesDocumentos?tipo=D",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Trámites Daños",
                                "icon"=>"fa fa-list-alt",
                                "href" => DIR_APP . "Siniestro_catalogos/TiposTramitesDanos?tipo=D",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Indicadores",
                                "icon"=>"fa fa-sort-numeric-asc",
                                "href" => DIR_APP . "Serviciosws/indicadores?tipo=D",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Configuración de alertas",
                                "icon"=>"fa fa-bell",
                                "href" => DIR_APP . "Serviciosws/notificaciones?tipo=D",
                                "tipo"=>0
                            ),
                            array( //Dennis Castillo [2022-01-18]
                                "title" => "Mis notas",
                                "icon"=>"fa fa-sticky-note-o",
                                "href" => base_url()."Siniestro_catalogos/getMyNotes?tipo=D"
                            ),
                        )
                    )
                    ,
                    array(
                        "title"=>"C_AUTOS",
                        "type"=>'C_AUTOS',
                        "child"=>array(
                            array(
                                "title" => "AUTOS",
                                "icon"=>"fa fa-car",
                                "href" => DIR_APP . "Autos",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Estatus",
                                "icon"=>"fa fa-hourglass-start",
                                "href" => DIR_APP . "GMM/siniestro_estatus",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Tipos Siniestro Autos",
                                "icon"=>"fa fa-list-alt",
                                "href" => DIR_APP . "Siniestro_catalogos/SiniestroTipoAutos?tipo=A",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Causa Tipo Autos",
                                "icon"=>"fa fa-list-alt",
                                "href" => DIR_APP . "Siniestro_catalogos/SiniestroCausaAutos?tipo=A",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Tipo documento",
                                "icon"=>"fa fa-file-text-o",
                                "href" => DIR_APP . "Siniestro_catalogos/Tipo_documento?tipo=A",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Documentos trámites",
                                "icon"=>"fa fa-list-ol",
                                "href" => DIR_APP . "Siniestro_catalogos/TramitesDocumentos/A",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Indicadores",
                                "icon"=>"fa fa-sort-numeric-asc",
                                "href" => DIR_APP . "Serviciosws/indicadores?tipo=A",
                                "tipo"=>0
                            ),
                            array(
                                "title" => "Configuración de alertas",
                                "icon"=>"fa fa-bell",
                                "href" => DIR_APP . "Serviciosws/notificaciones?tipo=A",
                                "tipo"=>0
                            ),
                            array( //Dennis Castillo [2022-01-18]
                                "title" => "Mis notas",
                                "icon"=>"fa fa-sticky-note-o",
                                "href" => base_url()."Siniestro_catalogos/getMyNotes?tipo=A"
                            ),
                        )
                    )
                    
                ),
                "href" => DIR_APP . "#",
                "icon" => "fa-eval"
            ),
            "Siniestros" => array(
                "title" => "Siniestros",
                "href" => DIR_APP . "Siniestros",
                "icon" => "fa-eval"
            ),
            // "PIP" => array(
            //     "title" => "PIP",
            //     "href" => DIR_APP . "PIP",
            //     "icon" => "fa-eval"
            // )
        );
        $this->menu = $menu;
    }

    private function dataNotificaciones()
    {
        $this->load->library('notifications', $this->global);
        $this->load->model('notificacionmodel', 'notificacion');
        $data = $this->notificacion->getAllNotificaciones($this->tank_auth->get_idPersona());
        /* $data=$this->tank_auth->get_idPersona(); */
        $this->dataNotificacion = $data;
    }

    public function response($code, $message, $data)
    {
        return array('code' => $code, 'message' => $message, 'data' => $data);
    }

    public function responseJSON($code, $message, $data)
    {
        header('Content-Type: application/json');
        echo json_encode(array('code' => $code, 'message' => $message, 'data' => $data), JSON_NUMERIC_CHECK);
        die;
    }

    public function sendNotificacionManual($clave, $parametros,$tipe=null) //Modificado [Suemy][2024-05-31]
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

           /*  if (count($resultNoti) > 0) { */
            if (is_object($resultNoti)) {
                foreach ($resultNoti->data as $result) {
                    foreach ($tipos as $key => $value) {

                        switch ($value) {
                            case 'email':
                                $obContact = null;
                                //var_dump($result);
                                //$obContact = null;
                                /* foreach ($this->notifications->contacts as $key => $value) {
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
                                } */
                                //var_dump($obContact);
                                // $obContact = $obContact[key($obContact)];

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
                                $subject = (isset($parametros['Asunto'])) ? $parametros['Asunto'] : "Notificación Capsys";
                                //$subject = (isset($result->data["subject"])) ? $result->data["subject"] : @$obContact["subject"];
                                $cc = @$obContact["cc"];
                                $bcc = @$obContact["bcc"];

                                //$body = $resultNoti->html;
                                $body = $this->parseTemplate($resultNoti->html, $result['dataCorreo']);
                                //var_dump($body);

                                /* $obContact = array_filter($this->notifications->contacts, function ($item, $key) use ($clave) {
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
                                $body=$this->parseTemplate($resultNoti->html,$result['dataCorreo']); */
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
                                $contacto_notificar = (isset($result->data["contactos_notificar"])) ? $result->data["contactos_notificar"] : array();
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

    //funcion para cambiar las variables del template

    public function parseTemplate($template, $variables)
    {
        foreach ($variables[0] as $key => $value) {
            $template = str_replace('{{ ' . $key . ' }}', $value, $template);
        }
        //echo $template;
        return $template;
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
    //funcion para validar los permisos
    public function comprobarpermiso($url,$id){
        $this->load->model('notificacionmodel', 'notificacion');
        $head=array();
        $data=array();
        $footer=array();
        $validate=$this->notificacion->validacion($url,$id);
        if(!$validate){
            redirect('erorrPermisos');
        }
    }

    public function partial_uri($start = 0) {
        $instancia= get_instance()->uri->segment_array();
        if(count($instancia)>=2){
            if(intval($instancia[2])>=6){
                return "PIP/AgregarPIP";
            }
            if(intval($instancia[2])>0 &&intval($instancia[2])<6){
                return join('/',array_slice($instancia, $start,1));
            }
            else{
                return join('/',array_slice($instancia, $start,2));
            }
        }else{
            return join('/',array_slice($instancia, $start));
        }
        
    }

    public function getPuestos()
    {
        $data = $this->capitalH->devolverPuestos(1);
        $fullA = array();
        //estructura que se necesita el select especifico
        foreach ($data as $key => $value) {
            $algo = array(
                "label" => $key,
                "options" => array()
            );
            foreach ($value as  $valuePP) {
                array_push($algo["options"], array("value" => $valuePP->idPuesto, "label" => $valuePP->personaPuesto));
            }
            array_push($fullA, $algo);
        }
        $otro = array(
            "label" => "Sin puesto",
            "options" => array(
                /*  array(
                    "value"=>"98",
                    "label"=>"MOVER DE PUESTO",
                    "color"=>"green"
                ), */
                array(
                    "value" => "0",
                    "label" => "SIN PUESTO",
                    "color" => "green"
                )
            )
        );
        //Pruebas
        $Prueba = array(
            "label" => "Personas Rankings",
            "options" => array(
                /* array(
                    "value"=>1000,
                    "label"=>"BRONCE",
                    "color"=>"green"
                ),
                array(
                    "value"=>2000,
                    "label"=>"ORO",
                    "color"=>"green"
                ),
                array(
                    "value"=>3000,
                    "label"=>"PLATINO VIP",
                    "color"=>"green"
                ) */)
        );
        $this->load->model('evaluacion_periodos_model', 'periodo');
        $ranks = $this->periodo->getRankActivo();
        $id = 0;
        foreach ($ranks as $key => $value) {
            $id = $id + 1000;
            $Prueba["options"][] = array(
                "value" => $id,
                "label" => $value["rank"],
                "color" => "green"
            );
        }
        array_push($fullA, $Prueba);
        array_push($fullA, $otro);
        sort($fullA);
        return $fullA;
    }

    public function getPuestosNuevo($padre=null,$ranks=null)
    {
        $this->load->model('evaluacion_periodos_model', 'periodo');
        //$data = $this->capitalH->devolverPuestos(1);
        $data=$this->periodo->devolverPuestos(1,$padre);
        $fullA = array();
        //estructura que se necesita el select especifico
        foreach ($data as $key => $value) {
            $algo = array(
                "label" => $key,
                "options" => array()
            );
            foreach ($value as  $valuePP) {
                array_push($algo["options"], array("value" => $valuePP->idPuesto, "label" => $valuePP->personaPuesto));
            }
            array_push($fullA, $algo);
        }
        $otro = array(
            "label" => "Sin puesto",
            "options" => array(
                /*  array(
                    "value"=>"98",
                    "label"=>"MOVER DE PUESTO",
                    "color"=>"green"
                ), */
                array(
                    "value" => "0",
                    "label" => "SIN PUESTO",
                    "color" => "green"
                )
            )
        );
        //Pruebas
        if($ranks!=null){
            $Prueba = array(
                "label" => "Personas Rankings",
                "options" => array()
            );
           
            $ranks = $this->periodo->getRankActivo();
            $id = 0;
            foreach ($ranks as $key => $value) {
                $id = $id + 1000;
                $Prueba["options"][] = array(
                    "value" => $id,
                    "label" => $value["rank"],
                    "color" => "green"
                );
            }
            array_push($fullA, $otro);
            array_push($fullA, $Prueba);
        }

        sort($fullA);
        return $fullA;
    }
}
