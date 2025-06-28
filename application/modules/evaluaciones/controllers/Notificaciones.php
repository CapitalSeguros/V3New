<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Notificaciones extends TIC_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library(array('session'));
        $this->load->helper('url');
        $this->load->model('notificacionmodel', 'notificacion');
        $this->lang->load('tank_auth');
    }

    public function index($id, $referencia,$idregistro)
    {
        //id= id de la referencia de bono,incidencia,periodo insertado como notificacion.
        //referencia= es el nombre del modulo donde se genero la incidencia.
        $url='';
        $this->session->set_flashdata('id', $id);
        $data = $this->notificacion->getdataRedirect($referencia, $id);
        $personaPuesto = $this->notificacion->getPersonaIncidencia($this->tank_auth->get_idPersona());
        $singleUpdate=$this->notificacion->updateSingle($idregistro);

        //$fp = fopen('resultadoJason.txt', 'a');fwrite($fp, print_r( $data, TRUE));fclose($fp); 

        empty($personaPuesto) ? $personaPuesto = 0 : $personaPuesto = $personaPuesto;
        if(empty($data)){
            $data= new \stdClass;
        }
        
        switch ($referencia) {
            case "BONOS":
                if ($data->Empleado == $this->tank_auth->get_idPersona() && !in_array($personaPuesto[0]->padrePuesto, [7, 58, 9, 1])) {
                    $url = "miInfo#Bonos";
                } else {
                    $url = "Bonos";
                }
                break;
            case "INCIDENCIAS":
                if ($data->Empleado == $this->tank_auth->get_idPersona() && !in_array($personaPuesto[0]->padrePuesto, [7, 58, 9, 1])) {
                    $url = "miInfo/#incidencias";
                } else {
                    $url = "incidencias";
                }
                break;
            case "PERIODOS":
                if (/* $data->Empleado == $this->tank_auth->get_idPersona() && */ !in_array($personaPuesto[0]->padrePuesto, [7, 58, 9, 1])) {
                    $url = "miInfo#Evaluaciones";
                } else {
                    $url = "periodos";
                }
                break;
            case "SINIESTROS":
                $data = new \stdClass();
                $data->Empleado=0;
                if ($data->Empleado == $this->tank_auth->get_idPersona() && !in_array($personaPuesto[0]->padrePuesto, [7, 58, 9, 1])) {
                    $url = "miInfo#Siniestros";
                } else {
                    $url = "Siniestros/registros";
                }
                break;
            case "ALERTA":
                $this->session->set_flashdata('id', 0);
                $data->Empleado=0;
                if ($data->Empleado == $this->tank_auth->get_idPersona() && !in_array($personaPuesto[0]->padrePuesto, [7, 58, 9, 1])) {
                        $url = "miInfo#Siniestros";
                } else {
                    $url = "Siniestros/registros";
                }
                break;
            case "PIP":
                $this->session->set_flashdata('id', 0);
                $data= new \stdClass;
                $data->Empleado=$this->tank_auth->get_idPersona();
                if ($data->Empleado == $this->tank_auth->get_idPersona() && !in_array($personaPuesto[0]->padrePuesto, [7, 58, 9, 1])) {
                    $url = "miInfo#otros";
                } else {
                    $url = "PIP/0";
                }
                break;
            //--------------------------------------------------
            //Dennis [2021-04-22]
            //Anexo de referencias para notificaciones del directorio y cumpleaños
            case "NOTAS":
                $data = new \stdClass();
                //$data->Empleado=0;
                $data->Empleado=$this->tank_auth->get_idPersona();
                if ($data->Empleado == $this->tank_auth->get_idPersona()) { //&& !in_array($personaPuesto[0]->padrePuesto, [7, 58, 9, 1])
                    $url = "directorio?cli=".$id."#notas_contenedor_get";
                } else {
                    $url = "directorio";
                }
                break;
            case "CUMPLEANIO":
                $data = new \stdClass();
                //$data->Empleado=0;
                $data->Empleado=$this->tank_auth->get_idPersona();
                if ($data->Empleado == $this->tank_auth->get_idPersona()) { //&& !in_array($personaPuesto[0]->padrePuesto, [7, 58, 9, 1])
                    $url = "directorio"; //?cli=".$id."#notas_contenedor_get";
                } else {
                    $url = "directorio";
                }
                break;
            //-------------------------------------------------
            //Dennis [2021-10-31]
            case "LIBERAR":
                $data = new \stdClass();
                $data->Empleado = $this->tank_auth->get_idPersona();

                if ($data->Empleado == $this->tank_auth->get_idPersona() && $this->tank_auth->get_usermail() == "SISTEMAS@ASESORESCAPITAL.COM") { //&& !in_array($personaPuesto[0]->padrePuesto, [7, 58, 9, 1])
                    $url = "persona/agente?liberar=".$id; //?cli=".$id."#notas_contenedor_get";
                } 
                /*elseif($data->Empleado == $this->tank_auth->get_idPersona() && $this->tank_auth->get_usermail() == "ASISTENTEDIRECCION@AGENTECAPITAL.COM"){
                    $url = "";
                }*/
                else {
                    $url = "";
                }
                break;
            //-------------------------------------------------
            //Dennis [2021-10-31]
            case "ALTA":
                $data = new \stdClass();
                $data->Empleado = $this->tank_auth->get_idPersona();

                if ($data->Empleado == $this->tank_auth->get_idPersona() && $this->tank_auth->get_usermail() == "CAPITALHUMANO@AGENTECAPITAL.COM") { //&& !in_array($personaPuesto[0]->padrePuesto, [7, 58, 9, 1])
                    $url = "persona/agente?permitir=".$id; //?cli=".$id."#notas_contenedor_get";
                } 
                elseif($data->Empleado == $this->tank_auth->get_idPersona() && $this->tank_auth->get_usermail() == "SISTEMAS@ASESORESCAPITAL.COM"){
                    $url = "";
                }
                else {
                    $url = "";
                }
                break;
            //-------------------------------------------------
            //Dennis [2021-10-31]
            case "RESPUESTA_ALTA":
                $data = new \stdClass();
                $data->Empleado = $this->tank_auth->get_idPersona();

                if($data->Empleado == $this->tank_auth->get_idPersona()){
                    $url = "";
                }
                else {
                    $url = "";
                }
                break;
            //-------------------------------------------------
            case "PROGRESO_DOCUMENTACION_COLABORADOR": //PROGRESO_INDUCCION
                //$data = new \stdClass();
                $data->Empleado = $this->tank_auth->get_idPersona();
                $tab = $data->tipoPersona == 1 ? "colaboradores" : "agentes";

                if($data->Empleado == $this->tank_auth->get_idPersona()){
                    $url = "persona/inducctionProgress?q=".$data->idPersona."&r=".$tab; //"persona/inducctionProgress/".$data->tipoPersona."/".$tab;
                }
                else {
                    $url = "";
                }
                break;
            //-------------------------------------------------
            case "PROGRESO_DOCUMENTACION_AGENTE": //PROGRESO_INDUCCION
                //$data = new \stdClass();
                $data->Empleado = $this->tank_auth->get_idPersona();
                $tab = $data->tipoPersona == 1 ? "colaboradores" : "agentes";

                if($data->Empleado == $this->tank_auth->get_idPersona()){
                    $url = "persona/inducctionProgress?q=".$data->idPersona."&r=".$tab; //"persona/inducctionProgress/".$data->tipoPersona."/".$tab;
                }
                else {
                    $url = "";
                }
                break;
            //-------------------------------------------------
            case "NOTA_SINIESTRO":
                //$data = new \stdClass();
                //$data->Empleado=0;
                $data->Empleado=$this->tank_auth->get_idPersona();
                if ($data->Empleado == $this->tank_auth->get_idPersona()) { //&& !in_array($personaPuesto[0]->padrePuesto, [7, 58, 9, 1])

                    $controller = $data->tipo_r == "S" ? "Siniestros" : "Siniestro_catalogos";
                    $dateAncla = date("d-m-Y", strtotime($data->dateCreate));
                    $url = $controller."/getMyNotes?tipo=".$data->tipo_r."&note=".$data->id."#".$dateAncla;
                } else {
                    $url = "";
                }
                break;
            //-------------------------------------------------
            case "SOLICITUD_BAJA":
                $url = "persona/agente";
                break;
            //-------------------------------------------------
			case "SOLICITUD_VACACION":

                $url = "fastFile/vacaciones/".$data->idPersona."";
                break;
            //-------------------------------------------------

        }
        //echo $url;
        //var_dump($personaPuesto);
        redirect(base_url() . $url, 'refresh');
    }


    public function notificaciones(){
        $search_incidencias = $this->notificacion->search_incidencias();
        foreach ($search_incidencias as $key => $value) {
            $this->sendNotificacionManual($value->notificacion, array("id_persona" => $value->empleado_id, "data" => $value));
        }
    }

    public function erorpermisos(){
        $head = array('title' => 'Capsys - Sin permisos');
        $data=array();
        $footer=array();
        $this->render('validation/errorpermiso', $head, $data, $footer);
    }

    public function UpdateAll(){
        $id=$this->input->post('id');
        $this->notificacion->updateAll($id);
        var_dump($id);
    }
    //------------------- //Dennis Castillo [2022-03-02]
    function updateSingle(){
        $id = $this->input->post("id");
        $update = $this->notificacion->updateSingle($id);

        echo json_encode(array(
            "bool" => $update, 
            "message" => (!$update ? "Ocurrió un error al momento de la ejecución.\nFavor de contactar a sistemas" : "")
        ));
    }
    //-------------------
}
