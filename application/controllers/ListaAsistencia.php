<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//include($_SERVER["DOCUMENT_ROOT"]."/Capsys/www/V3/application/libraries/google/autoload.php");
include($_SERVER["DOCUMENT_ROOT"]."/V3/application/libraries/google/autoload.php");
//define("RUTA_CREDENCIAL", $_SERVER["DOCUMENT_ROOT"].'/Capsys/www/V3/application/libraries/configure/credentials/calendar-php.json');
define("RUTA_CREDENCIAL", $_SERVER["DOCUMENT_ROOT"].'/V3/application/libraries/configure/credentials/calendar-php.json');

class ListaAsistencia extends CI_Controller {

    public function __construct(){
        parent:: __construct();
        $this->load->model("calendar_model");
        $this->load->library(array("email"));
        $this->load->library("Calendarcenis");
        //$this->load->library("url");
        
        if (!$this->tank_auth->is_logged_in()){
            redirect('/auth/login/');
        } 
    }

    public function index(){

        $this->lista_de_invitados();
    }

    public function lista_de_invitados(){

        //-----------------------------------------------------------------------------------------------------------------------------
        //Conexión a la API de Google.
        //$rutaTemporal=$_SERVER["DOCUMENT_ROOT"]."/Capsys/www/V3/application/libraries";
        $rutaTemporal=$_SERVER["DOCUMENT_ROOT"]."/V3/application/libraries";
        //$rutaAuth=$rutaTemporal."/configure/client_secret_179521245354-jgqo8b01quoi4ledccqak6lajstnt024.apps.googleusercontent.com.json";
        $rutaAuth=$rutaTemporal."/configure/client_secret_4568272251-ts54cecsgth67t76utkksqf68tqfhpgf.apps.googleusercontent.com.json";

        $cliente= new Google_Client();
        $cliente->setAuthConfigFile($rutaAuth);
        $cliente->addScope(Google_Service_Calendar::CALENDAR);
        $cliente->addScope(Google_Service_Calendar::CALENDAR_READONLY);
        $cliente->setAccessType("offline");
        
        $accessToken = file_get_contents(RUTA_CREDENCIAL);
        $cliente->setAccessToken($accessToken);

        if ($cliente->isAccessTokenExpired()) {
          $cliente->refreshToken($cliente->getRefreshToken());
          file_put_contents(RUTA_CREDENCIAL, $cliente->getAccessToken());
        } 

        $servicio = new Google_Service_Calendar($cliente);

        //---------------------------------------------------------------------------------------------------------------------------

        $opciones=array(
          'singleEvents' => TRUE,
          "orderBy"=>"startTime",
			    'timeMin' => date('c'),
        );

        $evento=$servicio->events->listEvents("primary",$opciones);

        $listas=array();

        //var_dump("hay un total de: ".count($evento->getItems()));
        while(true) {
            foreach ($evento->getItems() as $listaEvento) {
              //echo $lista->getSummary();
              $lista["nombreEvento"]=$listaEvento->getSummary();
              $lista["id_evento"]=$listaEvento->getId();

              $fechaInicio=new DateTime($listaEvento->getStart()->getDateTime());
              $lista["inicio"]=$fechaInicio->format("Y-m-d H:i");
              //$lista["inicio"]=$listaEvento->getStart()->getDateTime();
              //$lista["inicio"]=$listaEvento->getEnd()->getDateTime();

              array_push($listas,$lista);
            }

            $pageToken=$evento->getNextPageToken();
            if($pageToken){
              $optParams=array('pageToken' => $pageToken);
              $events=$servicio->events->listEvents('primary', $optParams);
            } else {
              break;
            }
          }
          
          $data["evento"]=$listas;
          //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($data, TRUE));fclose($fp);
        $this->load->view("ListaAsistencia/principal", $data);
    }

    //------------------------------------------------------------------------------------------------------------------------------------
    function obtenerInvitados(){
      //echo $_GET["q"];
      $msgError="";

      if(isset($_GET["q"])){
        
        $parametro=$_GET["q"];
        $consulta=$this->calendar_model->devuelveInvitados($parametro);

        //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($consulta, TRUE));fclose($fp);

        if(isset($consulta)){
          echo json_encode($consulta);
         
        }
        else{
          $msgError="No hubo resultado alguno";
          echo $msgError;
        }
      } else{
        $msgError="No llego datos";
        echo $msgError;
      }

    }
    //------------------------------------------------------------------------------------------------------------------------------------

    function prueba(){
      $idInvitado=$_GET["q"];
      $estado=$_GET["r"];
      $band=false;

      if(isset($idInvitado) && isset($estado)){

        $actualiza=$this->calendar_model->actualizaEstado($idInvitado, array("estado"=>$estado));
        //echo $actualiza;
        if($actualiza){
          $respuesta=$this->correoRespuesta($idInvitado);
          echo $respuesta;
        } else {
          echo $band;
        }
      } else{
        $msgError="No se envio correctamente los datos";
        echo $band;
      }
    }

    //------------------------------------------------------------------------------------------------------------------------------------
    function correoRespuesta($idInvitado){

      //---------------------------------------------------------------------------------------------------------
      //Invocamos a la API de nuevo.
      $rutaTemporal=$_SERVER["DOCUMENT_ROOT"]."/V3/application/libraries";
      //$rutaTemporal=$_SERVER["DOCUMENT_ROOT"]."/Capsys/www/V3/application/libraries";
      //$rutaAuth=$rutaTemporal."/configure/client_secret_179521245354-jgqo8b01quoi4ledccqak6lajstnt024.apps.googleusercontent.com.json";
      $rutaAuth=$rutaTemporal."/configure/client_secret_4568272251-ts54cecsgth67t76utkksqf68tqfhpgf.apps.googleusercontent.com.json";

      $cliente= new Google_Client();
      $cliente->setAuthConfigFile($rutaAuth);
      $cliente->addScope(Google_Service_Calendar::CALENDAR);
      $cliente->addScope(Google_Service_Calendar::CALENDAR_READONLY);
      $cliente->setAccessType("offline");
        
      $accessToken = file_get_contents(RUTA_CREDENCIAL);
      $cliente->setAccessToken($accessToken);

      if ($cliente->isAccessTokenExpired()) {
        $cliente->refreshToken($cliente->getRefreshToken());
        file_put_contents(RUTA_CREDENCIAL, $cliente->getAccessToken());
      } 

      $servicio = new Google_Service_Calendar($cliente);
      //---------------------------------------------------------------------------------------------------------

      //consultamos al invitado externo.
      $invitado=$this->calendar_model->obtenerInvitado($idInvitado);

      //configuracion del correo para protocolo: SMTP.
      $config=array(
        "protocol"=>"smtp",
        "smtp_host"=>"mail.agentecapital.com",
        "smtp_user"=>"auxiliardesarrollo@agentecapital.com",
        "smtp_pass"=>"AuxiliarDes2020#",
        "smtp_port"=>587,
        "mailtype"=>"html",
        "wordwrap"=>TRUE
      );

      $respuesta="";

      //Incializamos la configuración SMTP para la librería email.
      $this->email->initialize($config);

      $datosIcs=array();

      if(isset($invitado)){
        foreach($invitado as $datos){

          //Generamos el nombre completo del invitado.
          $nombreCompleto=ucwords($datos->nombres)." ".ucwords($datos->apellido_paterno)." ".ucwords($datos->apellido_materno);

          //obtenemos el evento de su registro.
          $evento=$servicio->events->get("primary", $datos->id_evento);
          
          //Enviamos un array asociativo a la vista.
          $data["datos"]["nombreC"]=$nombreCompleto;
          $data["datos"]["nombreEvento"]=$evento->getSummary();
          $data["datos"]["estado"]=strtoupper($datos->estado);
          $data["datos"]["idEvento"]=$evento->getId();
          $data["datos"]["idInvitado"]=$datos->id_invitado;

          //$this->creaIcsFile($datosCorreo,$datos->id_invitado,"externo",$datos->estado);

          $fechaI= new DateTime($evento->getStart()->getDateTime());
          $datosIcs["fecha_inicio"]=$fechaI->format("Y-m-d");
          $datosIcs["hora_inicio"]=$fechaI->format("H:i:s");

          $fechaF= new DateTime($evento->getEnd()->getDateTime());
          $datosIcs["fecha_final"]=$fechaF->format("d-M-y");
          $datosIcs["hora_final"]=$fechaF->format("H:i:s");

          $datosIcs["iCal"]=$evento->getICalUID();
          $datosIcs["titulo"]=$evento->getSummary();
          $datosIcs["descripcion"]=$evento->getDescription();
          $datosIcs["idEvento"]=$evento->getId();
          $datosIcs["lugar"]=$evento->getLocation();

          //$datosCorreo,$id_invitado,$tipoEmail,$estado
          $ics_file=$this->calendarcenis->creaIcsFile($datosIcs,$datos->id_invitado,"externo",$datos->estado);
          
          $cuerpoMensaje=$this->load->view("accesoAEvento/vistaRespuesta", $data, true);
          
          //Proceso de envio de correo de respuesta.
          $this->email->from($this->tank_auth->get_usermail());
          $this->email->to($datos->correo_lectronico);
          $this->email->subject("Respuesta al evento: ".$evento->getSummary());
          $this->email->message($cuerpoMensaje);
          $this->email->attach($ics_file);

          if(!$this->email->send()){
            $respuesta=$this->email->print_debugger();
          } else{
              $respuesta=$datos->estado;
          }          
        }
      }

      return $respuesta;
    }

    //-----------------------------------------------------------------------------------------------------------------------------------

//------------------------------------------------------ FIN DE LA CLASE ------------------------------------------------------------------
}

?>