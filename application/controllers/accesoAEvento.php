<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class accesoAEvento extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model("calendar_model");
        //$this->load->model("zoom_model");
        $this->load->model("crmproyecto_model");
        //$this->CI=& get_instance();
     }


    public function index(){
    }
    //-------------------------------------
    function evento($evento, $invitado, $tipo){ // funcion actual de gestoria de eventos

        $evento_ = $this->crmproyecto_model->getConvocatoriaReunionJson($evento); //getAllEmailConvocatoriaInternos
        $invitado_ = $this->calendar_model->obtenerInvitado($invitado,$tipo);
        //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($invitado, TRUE));fclose($fp);
        //$datos = array();
        $existe = 0;

        if(!empty($evento_) && !empty($invitado_)){
            $datos["titulo"] = $evento_->titulo;
            $datos["descripcion"] = $evento_->descripcion;
            $datos["fecha"] = $evento_->fecha_inicio." ".$evento_->hora_inicio." a ".$evento_->fecha_final." ".$evento_->hora_final;
            $datos["clasificacion"] = strtoupper($evento_->clasificacion);
            $datos["categoria"] = $evento_->sub_categoria_capacitacion;
            $datos["liga"] = $evento_->liga;
            $datos["contrasena"] = $evento_->password;
            $datos["idReunion"] = $evento_->idLiga;
            $datos["tipo"] = $tipo;
            $datos["evento"] = $evento;
            $datos["registro"] = $tipo == "interno" ? "registrado" : "nuevo";
            $datos["invitado"] = $invitado;
            if($tipo == "externo"){

                $datos["solicitud"] = $invitado_->activo;
            } else{
                $datos["estado"] = $invitado_->estado;
            }

            $existe = 1;
        }

        $datos["existe"] = $existe;
        //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($datos, TRUE));fclose($fp);
        $this->load->view("accesoAEvento/vistaAcceso", $datos);
    }
    //-------------------------------------
    function registraInvitado(){
        
        $nombre = $_POST["nombre"];
        $apellidoP = $_POST["apellidoP"];
        $apellidoM = $_POST["apellidoM"];
        $email = $_POST["correo"];
        $telefono = $_POST["telefono"];
        $ciudad = $_POST["ciudad"];
        $organizacion = $_POST["organizacion"];
        $puesto = $_POST["puesto"];
        $evento = $_POST["evento"];
        $tipo = $_POST["tipo"];
        $invitadoExt = $_POST["invitado"];
        $contenedor = array();

        $insertar = $this->calendar_model->inserta_invitados(array(
            "nombres" => $nombre, 
            "apellido_paterno" => $apellidoP, 
            "apellido_materno" => $apellidoM, 
            "correo_lectronico" => $email, 
            "telefono" => $telefono, 
            "ciudad" => $ciudad, 
            "organizacion" => $organizacion, 
            "puesto" => $puesto, 
            "id_evento" => $evento, 
            "tipo_invitado" => $tipo, 
            "estado" => "tentativo"
        ));

        if($insertar > 0){

            $actualiza=$this->calendar_model->cancelaCorreoExterno($invitadoExt, array("activo"=>0));
        }

        echo json_encode(array("resultado" => $insertar));

    }
    //-------------------------------------
    function createIcsFile(){
        
        $event = $_GET["q"];
        $eventData = $this->crmproyecto_model->getConvocatoriaReunionJson($event);
        $guest = $_GET["r"];
        $type = $_GET["p"];
        date_default_timezone_set('America/Mexico_City');
        //set_time_limit(0);
        if(!empty($eventData)){

            $dateStart = explode("-", $eventData->fecha_inicio);
            $dateEnd = explode("-", $eventData->fecha_final);
            $hourStart = explode(":", $eventData->hora_inicio);
            $hourEnd = explode(":", $eventData->hora_final);

            $dateStart_ = date("Ymd\THis", mktime($hourStart[0], $hourStart[1], 0, $dateStart[1], $dateStart[2], $dateStart[0]));
            $dateEnd_ = date("Ymd\THis", mktime($hourEnd[0], $hourEnd[1], 0, $dateEnd[1], $dateEnd[2], $dateEnd[0]));

            $ical = "
            BEGIN:VCALENDAR
            VERSION:2.0
            CALSCALE:GREGORIAN
            METHOD:REQUEST
            BEGIN:VEVENT
            ORGANIZER;CN=SISTEMAS@ASESORESCAPITAL.COM:mailto: SISTEMAS@ASESORESCAPITAL.COM
            UID:".md5($eventData->titulo)."
            CLASS:PUBLIC
            DTSTART:".$dateStart_."
            DTEND:".$dateEnd_."
            LOCATION:".addslashes($eventData->lugar)."
            STATUS:CONFIRMED
            SUMMARY:".addslashes($eventData->titulo)."
            ACTION:EMAIL
            DESCRIPTION: Este evento tiene una videollamada. Puedes encontrarlo accediendo a la siguiente liga: ".base_url()."accesoAEvento/evento/".$eventData->id_cal."/".$guest."/".$type."
            BEGIN:VALARM
            TRIGGER:-PT30M
            REPEAT:2
            DURATION:PT15M
            ACTION:DISPLAY
            DESCRIPTION:Aviso de reunión. Tema: ".$eventData->titulo."
            END:VALARM
            END:VEVENT
		    END:VCALENDAR";

            $_1ical = str_replace("    ", "", $ical);
            $_2ical = str_replace("\t", "", $_1ical);
            //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($dateStart_, TRUE));fclose($fp);

            header('Content-type: text/calendar; charset=utf-8');
            header('Content-Disposition: attachment; filename=invite.ics');
            
            echo "data:text/calendar;charset=utf8; base64,". base64_encode($_2ical);
        }
    }
    //-------------------------------------
}
?>
