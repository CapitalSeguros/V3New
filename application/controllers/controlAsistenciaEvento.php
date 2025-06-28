<?php 
    if(!defined("BASEPATH")) exit("No direct script access allowed");

class ControlAsistenciaEvento extends CI_Controller{

    function __construct(){
        parent::__construct();

        $this->load->model("calendar_model");
        $this->load->model("crmproyecto_model");
        $this->load->model("capacita_modelo");
        $this->load->model("personamodelo");

        if (!$this->tank_auth->is_logged_in()){
            redirect('/auth/login/');
        } 
    }

    function index(){
        //$this->listarEventos();
        $this->listEvents();
    }

    function listEvents(){

        $events = array();
        $listEvents = array();
        $allEvents = array_map(function($obj){
            return $obj->id_cal;
        }, $this->calendar_model->devuelveCapacitaciones(null, "capacitacion"));
        
        foreach($allEvents as $id_event){

            $dataEventAndGuest = $this->calendar_model->getDataEvent($id_event);

            /*$guestFiltered = array_filter($dataEventAndGuest, function($obj){ return $obj->estado == "aceptado"; });*/

            if(!empty($dataEventAndGuest)){
                foreach($dataEventAndGuest as $d_e){

                    $startDate_ = explode("-", $d_e->fecha_inicio);
                    $startHour_ = explode(":", $d_e->hora_inicio);
                    $endDate_ = explode("-", $d_e->fecha_final);
                    $endHour_ = explode(":", $d_e->hora_final);

                    $startDate = date("d-m-Y H:i:s", mktime($startHour_[0], $startHour_[1], 0, $startDate_[1], $startDate_[2], $startDate_[0]));
                    $endDate = date("d-m-Y H:i:s", mktime($endHour_[0], $endHour_[1], 0, $endDate_[1], $endDate_[2], $endDate_[0]));
                    $validOldEvent = strtotime($startDate) >= strtotime(date("Y-m-d H:i:s")) ? "activo" : "antiguo";
                    $totalHours = abs(strtotime($startDate) - strtotime($endDate)) / 3600;
                    $idTraninig = $this->capacita_modelo->getIdTraining($d_e->id_invitado);

                    $listEvents[$d_e->id_cal] = array("title" => $d_e->titulo, "status" => $validOldEvent);
                    /*$listEvents[$validOldEvent][$d_e->id_cal] = $d_e->titulo; array(
                        "title" => $d_e->titulo,
                        "idCal" => $d_e->id_cal
                    );*/
                    $events[$d_e->id_cal]["title"] = $d_e->titulo;
                    $events[$d_e->id_cal]["description"] = $d_e->descripcion;
                    $events[$d_e->id_cal]["startDate"] = $startDate;
                    $events[$d_e->id_cal]["endDate"] = $endDate;
                    $events[$d_e->id_cal]["totalHours"] = $totalHours;

                    if(!empty($d_e->id_invitado)){
                        $events[$d_e->id_cal]["guest"][] = array(
                            "idGuest" => $d_e->id_invitado,
                            "name" => $d_e->nombres." ".$d_e->apellido_paterno." ".$d_e->apellido_materno,
                            "email" => $d_e->correo_lectronico,
                            "status" => $d_e->estado,
                            "checkAssist" => !empty($idTraninig->checkStatus) ? $idTraninig->checkStatus : null,
                            "type" => $d_e->tipo_invitado,
                            "trainingRecord" => !empty($idTraninig->idRegistro) ? $idTraninig->idRegistro : 0
                        );
                    }
                }
            }
        }

        $data["events"]["listEvents"] = $listEvents;
        $data["events"]["events"] = $events;
        $fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($events, TRUE));fclose($fp);
        $this->load->view("controlAsistenciaEvento/listEvents", $data);
    }
    //------------------------------------
    function recordsTrainingData_respaldo(){

        $jsonData = json_decode($_POST["data_"]);
        $dataEvent = $this->crmproyecto_model->getConvocatoriaReunionJson($jsonData->event);
        $dataGuest = $this->calendar_model->obtenerInvitado($jsonData->reg, "interno");
        $subCategory =$this->capacita_modelo->getTrainingSubCategoryByName($dataEvent->sub_categoria_capacitacion);
        $category = $this->capacita_modelo->getTrainingCategoryById($subCategory->id_capacitacion);
        $typeLastCategory = $dataEvent->ramo_capacitacion == "Ninguno" ? "profesional" : $dataEvent->ramo_capacitacion;
        $ramo = $this->capacita_modelo->devuelveRamo(($typeLastCategory != "GMM" ? strtolower($typeLastCategory) : $typeLastCategory));
        $guest = $this->personamodelo->obtenerIdPersonaPorEmail($dataGuest->correo_lectronico);
        $responsable = $this->personamodelo->obtenerIdPersonaPorEmail($dataEvent->correo);
        $arrayResponse = array();
        $arrayResponse["idGuest"] = $jsonData->reg;
        $arrayResponse["idTraining"] = 0;
        $arrayResponse["status"] = false;

        if($jsonData->confirma == "aceptado"){
            if(!empty($guest) && $jsonData->recordTraining == 0){ //&& $jsonData->recordTraining == 0
                $insertaHora = $this->capacita_modelo->insertaRegistro(array(
                    "fecha" => $dataEvent->fecha_inicio,
                    "horas" => $jsonData->hours,
                    "idSubCapacitacion" => $subCategory->id_certificado,
                ), "capacita_registros_horas");
                
                $insertaRelacionHoraRamo = $this->capacita_modelo->insertaRegistro(array(
                    "idRegistroHora" => $insertaHora,
                    "idR" => $ramo->idR
                ), "capacita_relacion_hora_ramo");
        
                $insertaCreador = $this->capacita_modelo->insertaRegistro(array(
                    "idRegistroHora" => $insertaHora,
                    "creadorAlta" => $dataEvent->correo,
                ),"capacita_usuario_creador");
    
                $insertaRegistros = $this->capacita_modelo->insertaRegistro(array(
                    "idPersona" => $guest->idPersona,
                    "idRegistroHora" => $insertaHora,
                    "tipoRegistro" => "interno",
                    "estado" => "activo",
                ), "capacita_registros");
    
                $insertaReferenciaResponsable = $this->capacita_modelo->insertaRegistro(array(
                    "responsable" => $responsable->idPersona,
                    "fechaCompromiso" => $dataEvent->fecha_inicio, //$anexo["fechaParaCapacitacion"],
                    "idRegistro" => $insertaRegistros
                ), "capacita_responsable");
    
                $insertGuesAndRecordRelationship = $this->capacita_modelo->insertaRegistro(array(
                    "id_invitado" => $jsonData->reg,
                    "idRegistro" => $insertaRegistros
                ), "capacita_relacion_invitado_registro");
    
                $arrayResponse["idTraining"] = $insertaRegistros;
                $arrayResponse["status"] = true;
            } else{
                $update = $this->capacita_modelo->updateTrainingData(array("hours" => $jsonData->hours, "idRegistro" => $jsonData->recordTraining, "estado" => "activo"));
                $arrayResponse["idTraining"] = $jsonData->recordTraining;
                $arrayResponse["status"] = true;
            }
        } else{
            //$deleteRegister = $this->capacita_modelo->deleteRelationshipTrainingAndEvent($jsonData->recordTraining);
            $update = $this->capacita_modelo->updateTrainingDataSafely(
                array("idRegistro" => $jsonData->recordTraining), //Condition
                array("estado" => "inactivo"), //Set
                "capacita_registros" //Table
            );
            $arrayResponse["idTraining"] = $jsonData->recordTraining;
        }
        //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($jsonData, TRUE));fclose($fp);
        echo json_encode($arrayResponse);
    }
    //------------------------------------
    function recordsTrainingData(){

        $jsonData = json_decode($_POST["data_"]);
        $dataEvent = $this->crmproyecto_model->getConvocatoriaReunionJson($jsonData->event);
        $dataGuest = $this->calendar_model->obtenerInvitado($jsonData->reg, "interno");
        $subCategory =$this->capacita_modelo->getTrainingSubCategoryByName($dataEvent->sub_categoria_capacitacion);
        $category = $this->capacita_modelo->getTrainingCategoryById($subCategory->id_capacitacion);
        $typeLastCategory = $dataEvent->ramo_capacitacion == "Ninguno" ? "profesional" : $dataEvent->ramo_capacitacion;
        $ramo = $this->capacita_modelo->devuelveRamo(($typeLastCategory != "GMM" ? strtolower($typeLastCategory) : $typeLastCategory));
        $guest = $this->personamodelo->obtenerIdPersonaPorEmail($dataGuest->correo_lectronico);
        $responsable = $this->personamodelo->obtenerIdPersonaPorEmail($dataEvent->correo);
        $confirm = $jsonData->confirma == "aceptado" ? "activo" : "inactivo";
        $arrayResponse = array();
        $arrayResponse["idGuest"] = $jsonData->reg;
        $arrayResponse["idTraining"] = 0;
        $arrayResponse["status"] = $jsonData->confirma == "aceptado" ? true : false;
        //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($jsonData, TRUE));fclose($fp);
        
        if(!empty($guest) && $jsonData->recordTraining == 0){ //&& $jsonData->recordTraining == 0
            $insertaHora = $this->capacita_modelo->insertaRegistro(array(
                "fecha" => $dataEvent->fecha_inicio,
                "horas" => $jsonData->hours,
                "idSubCapacitacion" => $subCategory->id_certificado,
            ), "capacita_registros_horas");
            
            $insertaRelacionHoraRamo = $this->capacita_modelo->insertaRegistro(array(
                "idRegistroHora" => $insertaHora["lastId"],
                "idR" => $ramo->idR
            ), "capacita_relacion_hora_ramo");
    
            $insertaCreador = $this->capacita_modelo->insertaRegistro(array(
                "idRegistroHora" => $insertaHora["lastId"],
                "creadorAlta" => $dataEvent->correo,
            ),"capacita_usuario_creador");

            $insertaRegistros = $this->capacita_modelo->insertaRegistro(array(
                "idPersona" => $guest->idPersona,
                "idRegistroHora" => $insertaHora["lastId"],
                "tipoRegistro" => "interno",
                "estado" => $confirm,
            ), "capacita_registros");

            $insertaReferenciaResponsable = $this->capacita_modelo->insertaRegistro(array(
                "responsable" => $responsable->idPersona,
                "fechaCompromiso" => $dataEvent->fecha_inicio, //$anexo["fechaParaCapacitacion"],
                "idRegistro" => $insertaRegistros["lastId"]
            ), "capacita_responsable");

            $insertGuesAndRecordRelationship = $this->capacita_modelo->insertaRegistro(array(
                "id_invitado" => $jsonData->reg,
                "idRegistro" => $insertaRegistros["lastId"]
            ), "capacita_relacion_invitado_registro");

            $arrayResponse["idTraining"] = $insertaRegistros["lastId"];
            //$arrayResponse["status"] = $jsonData->confirma == "aceptado" ? true : false;
        } else{
            $update = $this->capacita_modelo->updateTrainingData(array("idR" => $ramo->idR, "hours" => $jsonData->hours, "idRegistro" => $jsonData->recordTraining, "estado" => $confirm));
            $arrayResponse["idTraining"] = $jsonData->recordTraining;
            //$arrayResponse["status"] = $jsonData->confirma == "aceptado" ? true : false;
        }

        //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($jsonData, TRUE));fclose($fp);
        echo json_encode($arrayResponse);
    }
}

?>