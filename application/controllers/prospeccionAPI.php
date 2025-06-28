<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');
header("Access-Control-Allow-Methods: GET, OPTIONS, PATCH, POST, DELETE");
header("Access-Control-Allow-Origin: * ");
header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding, x-requested-with, Session-User");


class ProspeccionApi extends CI_Controller
{

    var $userSession;
    var $codeStatus = 200;
    var $method_ = "";
    var $tokenData = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->library("encrypt");
        $this->load->model("capsysdre");
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

    public function index()
    {
        switch ($this->method_) {
            case "GET":
                $response = array();
                $uriSegmet = $this->uri->segment_array();
                $getProspecter = $this->capsysdre->detalleProspecto($uriSegmet[4]);

                if (!empty($getProspecter)) {

                    $singleValue = is_array($getProspecter) ? $getProspecter[0] : $getProspecter;

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
                    );
                }

                $this->sendResponse(["code" => 200, "response" => $response]);
                break;
            case "OPTIONS":
                break;
            default:
                $this->sendResponse(["code" => 405, "response" => ["message" => "Metodo " . $this->method_ . " no es permitido para esta ruta"]]);
        }
    }

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
}
