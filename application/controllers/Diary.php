<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

header("Access-Control-Allow-Methods: GET, OPTIONS, PATCH, POST, DELETE");
header("Access-Control-Allow-Origin: * ");
header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding, x-requested-with, Session-User");

class Diary extends CI_Controller
{
    var $method_ = "";
    var $tokenData = array();
    var $index_ = true;
    //--------------------
    public function __construct()
    {
        parent::__construct();
        $this->load->library(array('encrypt', 'WhatsSMS')); //jsonEntriesValidator
        $this->load->model(array("Diary_model", "modelo_usuario", "personamodelo", "notificacionModel", "manejodocumento_modelo", "capsysdre", "capsysdre_actividades"));
        $this->method_ = $_SERVER["REQUEST_METHOD"];
        $urlDec = str_replace(" ", "+", urldecode($this->input->get_request_header("Session-user"))); //Localhost
        //$urlDec = str_replace(" ", "+", urldecode($this->input->get_request_header("Session-User"))); //Sandbox
        $this->tokenData = json_decode($this->encrypt->decode($urlDec), true);

        if ($this->method_ !== "OPTIONS" && empty($this->tokenData)) {
            $this->sendResponse(array(
                "code" => 401,
                "response" => array(
                    //"status" => "error",
                    "message" => "Sessión User no proporcionado o expirado",
                )
            ));
        }
    }
    //--------------------
    public function index()
    {
        switch ($this->method_) {
            case "GET":
                $this->load->view("diary/calendar.php");
                break;
            case "OPTIONS":
                break;
        }
    }
    //--------------------
    public function manage()
    {
        switch ($this->method_) {
            case "GET":

                $this->getEvents($this->tokenData["account"]);
                break;
            case "POST":
                $jsonRequest = json_decode(file_get_contents('php://input'), true);

                if (!empty($this->tokenData)) {
                    $jsonRequest["organizer"] = $this->tokenData["account"];
                }

                $this->insertEvent($jsonRequest); //No borrar, agregar al calendario versión v2.0

                if (in_array($jsonRequest["type"], ["tarjetadigital", "asesoresonline"])) {
                    $this->setToCalendar($jsonRequest); //Comentar, solo activo para la versión del calendario v1.
                }
                break;
            case "OPTIONS":
                break;
            default:
                $this->sendResponse(array(
                    "code" => 404,
                    "response" => array(
                        "status" => "error",
                        "message" => "Página no encontrada",
                    )
                ));
        }
    }
    //--------------------
    public function event($event)
    {
        switch ($this->method_) {
            case "GET":
                $userData = $this->tokenData;
                //$eventData = [];
                //$sessionUserPhoto = $this->personamodelo->getPersonalPicture($userData["id"]);
                //$sessionUserName = $this->personamodelo->obtenerNombrePersona($userData["id"]);
                $event_ = $this->Diary_model->getEventById($event);
                $eventData = [
                    "idEvent" => $event_["idEvent"],
                    "title" => $event_["title"],
                    "description" => $event_["description"],
                    "location" => $event_["location"],
                    "type" => $event_["type"],
                    "active" => $event_["active"],
                    "organizer" => $event_["organizer"],
                ];
                $meet = [
                    "meet" => $event_["meet"],
                    "meetPassword" => $event_["meetPassword"],
                    "meetActive" => $event_["meetActive"],
                    "contactType" => $event_["contactType"],
                ];

                $dateTime = [
                    "startDate" => date("Y-m-d H:i:s", strtotime($event_["startDate"])),
                    "endDate" => date("Y-m-d H:i:s", strtotime($event_["endDate"])),
                ];
                $guest = array_map(function ($ob) {
                    $ob["tumb"] = base_url() . "assets/img/miInfo/userPhotos/" . $ob["fotoUser"];
                    $ob["nameComplete"] = $ob["nombres"] . " " . $ob["apellidoPaterno"] . " " . $ob["apellidoMaterno"];
                    return [
                        "id" => $ob["id"],
                        "guest" => $ob["guest"],
                        "participation" => $ob["participation"],
                        "thumb" => $ob["tumb"],
                        "nameComplete" => $ob["nameComplete"],
                        "area" => $ob["area"]
                    ];
                }, $this->Diary_model->getAttendes($event));


                if (!empty($event_["service_id"])) {

                    $service = $this->getService($event_["service"], $event_["service_id"]);
                    //$service = [];
                } else {
                    $client = [
                        "idClient" => $event_["idClient"],
                        "name" => $event_["name"],
                        "lastName" => $event_["lastName"],
                        "motherLastName" => $event_["motherLastName"],
                        "email" => $event_["email"],
                        "phone" => $event_["phone"],
                    ];
                }

                $this->sendResponse(array(
                    "code" => 200,
                    "response" => compact("eventData", "guest", "meet", "client", "service", "dateTime"),
                ));
                break;
            case "DELETE":

                $status = array("active" => false);
                $this->Diary_model->updateEvent($event, array("event" => $status));
                $this->sendResponse([
                    "code" => 200,
                    "response" => [
                        "deleted" => true
                    ]
                ]);
                break;
            case "PATCH":

                $jsonRequest = json_decode(file_get_contents('php://input'), true);

                if (!empty($userData)) {
                    $jsonRequest["organizer"] = $jsonRequest["organizer"] == $userData["account"] ? $userData["account"] : $jsonRequest["organizer"];
                }

                $this->updateEvent($event, $jsonRequest);
                break;
            case "OPTIONS":
                break;
            default:
                $this->sendResponse(array(
                    "code" => 404,
                    "status" => "error",
                    "message" => "Página no encontrada",
                ));
        }
    }
    //--------------------
    public function guest($guest)
    {
        switch ($this->method_) {
            case "PATCH":
                $request = json_decode(file_get_contents("php://input"), true);
                $this->takeParticipation($request, $guest);

                break;
            case "OPTIONS":
                break;
            default:
                $this->sendResponse([
                    "code" => 405,
                    "response" => ["message" => "Metodo " . $this->method_ . " no es permitido para esta ruta"]
                ]);
        }
    }
    //--------------------
    private function getEvents($account)
    {

        $events = $this->Diary_model->getEvents($account);
        $this->sendResponse(array(
            "code" => 200,
            "response" => $events /* [
                //"status" => "success",
                "data" => $events,
            ] */
        ));
    }
    //--------------------
    private function insertEvent($eventJson)
    {

        try {

            /* if (!empty($this->jsonentriesvalidator->inspectEntries($eventJson, "eventPost"))) {
                throw new Exception(json_encode($this->jsonentriesvalidator->inspectEntries($eventJson, "eventPost")), 400);
            } */

            $arrSDate = explode("-", $eventJson["startDate"]);
            $dateS = date("Y-m-d H:i:s", mktime($eventJson["startTime"]["hour"], $eventJson["startTime"]["minutes"], 0, $arrSDate[1], $arrSDate[2], $arrSDate[0]));

            $arrEDate = explode("-", $eventJson["endDate"]);
            $dateE = date("Y-m-d H:i:s", mktime($eventJson["endTime"]["hour"], $eventJson["endTime"]["minutes"], 0, $arrEDate[1], $arrEDate[2], $arrEDate[0]));

            if (strtotime($eventJson["startDate"]) > strtotime($eventJson["endDate"])) {
                throw new Exception(json_encode(["La fecha u hora de inicio no puede ser mayor a la de fecha final"]), 400);
            }

            $date["event"] = array(
                "title" => isset($eventJson["title"]) ? $eventJson["title"] : null,
                "description" => isset($eventJson["description"]) ? $eventJson["description"] : null,
                "startDate" => $dateS, //$eventJson["startDate"],
                "endDate" => $dateE, //$eventJson["endDate"],
                "location" => isset($eventJson["location"]) ? $eventJson["location"] : null,
                "type" => $eventJson["type"],
                "organizer" => $eventJson["organizer"],
                "contactType" => isset($eventJson["contactType"]) ? $eventJson["contactType"] : null,
                "idGoogleEvent" => null
            );

            if (isset($eventJson["client"])) {

                $date["client"] = array(
                    "name" => $eventJson["client"]["name"],
                    "lastName" => $eventJson["client"]["lastName"],
                    "motherLastName" => $eventJson["client"]["motherLastName"],
                    "email" => $eventJson["organizer"],
                    "phone" => $eventJson["client"]["phone"],
                    "creationDate" => date("Y-m-d H:i:s"),
                );
            }

            if (isset($eventJson["meet"])) {

                $date["meet"] = array(
                    "meet" => $eventJson["meet"]["meet"],
                    "meetPassword" => $eventJson["meet"]["password"],
                );
            }

            if (isset($eventJson["attendes"])) {

                //$getUsers = $this->modelo_usuario->getUsers(implode(",", $eventJson["attendes"]));
                $date["attendes"] = array_map(function ($user) {
                    return array("guest" => $user, "participation" => "tentative");
                }, $eventJson["attendes"]);
            }

            //---------- Proceso de servicio ---------------
            if (isset($eventJson["service"])) {
                $date["service"] = [
                    "service" => $eventJson["service"]["service"],
                    "service_id" => $eventJson["service"]["service_id"],
                ];
            }
            //---------------------------------------------

            //$fp = fopen('resultadoJason.txt', 'w');
            /* fwrite($fp, print_r($date, TRUE));
            fclose($fp);
            die; */
            $insert = $this->Diary_model->insertEvent($date);

            if (!empty($insert)) {
                $this->setToService($eventJson); //Apunta a los servicios - No borrar
            }

            if (!in_array($date["type"], ["tarjetadigital", "asesoresonline"])) {
                $this->sendResponse(array(
                    "code" => 201,
                    "response" => ["id" => $insert]
                ));
            }
        } catch (Exception $e) {

            $this->sendResponse(array(
                "code" => $e->getCode(),
                "response" => array("status" => "error", "message" => json_decode($e->getMessage()))
            ));
        }
    }
    //--------------------
    private function setToCalendar($eventJson)
    { //Citas de asesores online versión v1

        try {

            if (!isset($eventJson["startDate"]) || !isset($eventJson["endDate"])) {
                throw new Exception("Los campos de fecha de inicio y fecha final son requeridos", 400);
            }

            if (strtotime($eventJson["startDate"]) > strtotime($eventJson["endDate"])) {
                throw new Exception("La fecha u hora de inicio no puede ser mayor a la de fecha final", 400);
            }

            $arrSDate = explode("-", $eventJson["startDate"]);
            $dateS = date("Y-m-d H:i:s", mktime($eventJson["startTime"]["hour"], $eventJson["startTime"]["minutes"], 0, $arrSDate[1], $arrSDate[2], $arrSDate[0]));

            $arrEDate = explode("-", $eventJson["endDate"]);
            $dateE = date("Y-m-d H:i:s", mktime($eventJson["endTime"]["hour"], $eventJson["endTime"]["minutes"], 0, $arrEDate[1], $arrEDate[2], $arrEDate[0]));
            $emailAttendes = $this->personamodelo->obtenerEmail($eventJson["attendes"][0]);

            $getDay = "";
            switch (date("N", strtotime($eventJson["startDate"]))) {
                case 0:
                    $getDay = "Domingo";
                    break;
                case 1:
                    $getDay = "Lunes";
                    break;
                case 2:
                    $getDay = "Martes";
                    break;
                case 3:
                    $getDay = "Miercóles";
                    break;
                case 4:
                    $getDay = "Jueves";
                    break;
                case 5:
                    $getDay = "Viernes";
                    break;
                case 6:
                    $getDay = "Sábado";
                    break;
            }

            $jsonForInsert = array();
            $jsonCalendar = array();
            $jsonForInsert["cliente"] = $eventJson["client"]["name"] . " " . $eventJson["client"]["lastName"] . " " . $eventJson["client"]["motherLastName"];
            $jsonForInsert["correo"] = $eventJson["organizer"];
            $jsonForInsert["telefono"] = $eventJson["client"]["phone"];
            $jsonForInsert["detalle"] = $eventJson["description"];
            $jsonForInsert["activo"] = 0;
            $jsonForInsert["medio"] = $eventJson["contactType"];
            $jsonForInsert["id_userInfo"] = $eventJson["attendes"][0];
            $jsonForInsert["dia"] = $getDay;
            $jsonForInsert["fecha"] = date("d/m/Y", strtotime($eventJson["startDate"]));
            $jsonForInsert["hora"] = $eventJson["startTime"]["hour"] . ":00";
            $jsonForInsert["token"] = null;
            $jsonForInsert["asesor_online"] = $eventJson["advisors"];

            $jsonCalendar["fechaGuardado"] = date("Y-m-d H:i:s");
            $jsonCalendar["emailUsuario"] = $emailAttendes->email;
            $jsonCalendar["titulo"] = "Cita Online Asesores Capital";
            $jsonCalendar["fechaInicial"] = $dateS;
            $jsonCalendar["fechaFinal"] = $dateE;
            $jsonCalendar["emailEstado"] = "A";
            $jsonCalendar["tabla"] = "citascalendar";

            $insert = $this->Diary_model->insertEvent1v($jsonForInsert);
            $insertInCalendar = $this->Diary_model->insertInCalendar1v($jsonCalendar);
            $messaje_ = $this->load->view("emailTemplates/asesoresOnlineTemplate", array("data" => $jsonForInsert), true);
            $emailRequest = array(
                "fechaCreacion" => date("Y-m-d H:i:s"),
                "desde" => "<Avisos de GAP<avisosgap@aserorescapital.com>",
                "para" => $emailAttendes->email, //"denniscastle24@gmail.com", //$emailAttendes->email,
                "copia" => 0,
                "copiaOculta" => 0,
                "asunto" => "Solicitud de reunión (asesores online, tarjeta digital)",
                "mensaje" => $messaje_,
                "status" => 0,
                "fechaEnvio" => date("Y-m-d H:i:s")

            );
            $sendEmail = $this->notificacionModel->insertCorreo($emailRequest);
            //echo json_encode($emailRequest);
            //exit;
            /* $nameComplete = $this->personamodelo->obtenerNombrePersona($eventJson["attendes"][0]);
            $smsRequest["country_code"] = 52;
            $smsRequest["numbers"] = "9993671600";
            $smsRequest["message"] = "Solicitud de Creacion - Liga para VideoLlamada AsesoresOnline GAP/Asesor: ".$nameComplete."/Fecha de la cita: ".$jsonForInsert["fecha"]. " - ".$jsonForInsert["hora"]."hrs/Medio: ".$eventJson["contactType"]."";
            $smsApiv2 = $this->whatssms->sendSMSV2($smsRequest);*/

            $this->sendResponse(array(
                "code" => 201,
                "status" => "success",
                //"data" => $events,
            ));
            //echo json_encode($jsonForInsert);

        } catch (Excetion $e) {

            $this->sendResponse(array(
                "code" => $e->getCode(),
                "status" => "error",
                "message" => $e->getMessage()
            ));
        }
    }
    //--------------------
    private function updateEvent($event, $jsonRequest)
    {

        try {

            /* if (!empty($this->jsonentriesvalidator->inspectEntries($jsonRequest, "eventPatch"))) {
                throw new Exception(json_encode($this->jsonentriesvalidator->inspectEntries($jsonRequest, "eventPatch")), 400);
            } */

            $arrSDate = explode("-", $jsonRequest["startDate"]);
            $dateS = date("Y-m-d H:i:s", mktime($jsonRequest["startTime"]["hour"], $jsonRequest["startTime"]["minutes"], 0, $arrSDate[1], $arrSDate[2], $arrSDate[0]));

            $arrEDate = explode("-", $jsonRequest["endDate"]);
            $dateE = date("Y-m-d H:i:s", mktime($jsonRequest["endTime"]["hour"], $jsonRequest["endTime"]["minutes"], 0, $arrEDate[1], $arrEDate[2], $arrEDate[0]));

            if (strtotime($jsonRequest["startDate"]) > strtotime($jsonRequest["endDate"])) {
                throw new Exception(json_encode(["La fecha u hora de inicio no puede ser mayor a la de fecha final"]), 400);
            }

            $rootKeys = ["title", "description", "startDate", "endDate", "location", "type", "organizer", "contactType"];
            $setUpdate = array();

            foreach ($rootKeys as $key_) {
                if (array_key_exists($key_, $jsonRequest)) {
                    $setUpdate["event"][$key_] = $key_ === 'startDate' ? $dateS : ($key_ === 'endDate' ? $dateE : $jsonRequest[$key_]);
                }
            }

            if (isset($jsonRequest["meet"]) && !isset($jsonRequest["meet"]["remove"])) {

                $setUpdate["meet"]["id"] = $event;
                $setUpdate["meet"]["meet"] = $jsonRequest["meet"]["meet"];
                $setUpdate["meet"]["meetPassword"] = $jsonRequest["meet"]["password"];
            }

            if (isset($jsonRequest["meet"]) &&  isset($jsonRequest["meet"]["remove"]) && $jsonRequest["meet"]["remove"]) {
                $this->Diary_model->deleteMeet($event);
            }

            if (array_key_exists("service", $jsonRequest)) {
                //$setUpdate["service"] = $jsonRequest["service"];
            }

            if (array_key_exists("client", $jsonRequest)) {
                $setUpdate["client"] = $jsonRequest["client"];
            }

            if (array_key_exists("attendes", $jsonRequest)) {
                if (array_key_exists("agree", $jsonRequest["attendes"])) {
                    $setUpdate["attendes"]["agree"] = array_map(function ($ob) use ($event) {
                        return [
                            "guest" => $ob,
                            "participation" => "tentative",
                            "event" => $event
                        ];
                    }, $jsonRequest["attendes"]["agree"]);
                }

                if (array_key_exists("delete", $jsonRequest["attendes"])) {
                    $setUpdate["attendes"]["delete"] = $jsonRequest["attendes"]["delete"];
                }
            }

            $update = $this->Diary_model->updateEvent($event, $setUpdate, true);

            $this->sendResponse(array(
                "code" => 200,
                "response" => array("updated" => true)
                //"data" => $events,
            ));

            //echo json_encode($setUpdate);
        } catch (Exception $e) {
            $this->sendResponse(array(
                "code" => $e->getCode(),
                "response" => ["message" => json_decode($e->getMessage())]
            ));
        }
    }
    //--------------------
    private function sendResponse($response)
    {
        //echo json_encode($response);
        $this->output
            ->set_status_header($response["code"])
            ->set_content_type("application/json", "utf-8")
            ->set_output(
                json_encode(
                    $response["response"],
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                )
            )
            ->_display();
        exit;
    }
    //--------------------
    private function getService($service, $id)
    {
        $response = [];
        switch ($service) {
            case "prospection":
                $data = $this->capsysdre->detalleProspecto($id);
                $exclusiveData = $this->capsysdre_actividades->getEvents($id);
                if (!empty($data)) {

                    $singleValue = is_array($data) ? $data[0] : $data;

                    $response = array(
                        "name" => $singleValue->Nombre,
                        "lastName" =>
                        $singleValue->ApellidoP,
                        "motherLastName"  =>
                        $singleValue->ApellidoM,
                        "businessName" =>
                        $singleValue->RazonSocial,
                        "email" =>
                        $singleValue->EMail1,
                        "phone" =>
                        $singleValue->Telefono1,
                        "RFC" =>
                        $singleValue->RFC,
                        "state" => $singleValue->EstadoActual,
                        "entity" => $singleValue->tipoEntidad,
                        "exclusiveData" => !empty($exclusiveData) ? array_map(function ($ob) {
                            return [
                                "idCCC" => $ob["idCCC"],
                                "statusCCC" => $ob["statusCCC"],
                                "tipoCCC" => $ob["tipoCCC"],
                                "comentarioCCC" => $ob["comentarioCCC"],
                            ];
                        }, $exclusiveData) : []
                    );
                }
                break;
        }

        return $response;
    }
    //--------------------
    private function setToService($service)
    {

        switch ($service["service"]["service"]) {
            case "prospection":
                $_GET["idProspecto"] = $service["service"]["service_id"];
                $_GET["citaContacto"] = $service["startDate"];
                $_GET["comentarioCCC"] = $service["title"];
                $_GET["tipoCCC"] = $service["service"]["exclusiveValue"]["tipoCCC"];
                //$this->capsysdre_actividades->guardarContactoCita();
                break;
        }
        return [];
    }
    //--------------------
    function getToken()
    {

        /* $data = array(
          "account" => $this->tank_auth->get_usermail(), 
          "id" => $this->tank_auth->get_idPersona()
        ); */

        $this->sendResponse(array(
            "code" => 200,
            "status" => "success",
            "data" => array(
                "token" => $this->input->get_request_header("Session-User"), //$this->encrypt->encode(json_encode($data)),
                "other" => $this->encrypt->decode($this->input->get_request_header("Session-User")),
            ),
        ));
    }
    //--------------------
    private function takeParticipation($request, $guest)
    {

        try {
            $participation = $this->Diary_model->takeMyParticipation(["condition" => ["guest" => (int)$guest, "event" => $request["event"]], "participation" => $request["participation"]]);

            $this->sendResponse(["code" => 200, "response" => ["participation" => $participation]]);
        } catch (Exception $e) {

            $this->sendResponse([
                "code" => $e->getCode(),
                "response" => ["message" => $e->getMessage()]
            ]);
        }
    }
    //--------------------
}
