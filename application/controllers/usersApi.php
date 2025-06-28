<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

header("Access-Control-Allow-Methods: GET, OPTIONS, PATCH, POST, DELETE");
header("Access-Control-Allow-Origin: * ");
header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding, x-requested-with, Session-User");

class usersApi extends CI_Controller
{

    var $descryptToken;
    var $method;
    var $method_ = "";
    var $tokenData = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->library('encrypt');
        $this->load->model(array("Diary_model", "modelo_usuario"));
        $this->method_ = $_SERVER["REQUEST_METHOD"];
        $urlDec = str_replace(" ", "+", urldecode($this->input->get_request_header("Session-user"))); //Localhost
        //$urlDec = str_replace(" ", "+", urldecode($this->input->get_request_header("Session-User"))); //Sandbox
        $this->tokenData = json_decode($this->encrypt->decode($urlDec), true);

        if ($this->method_ !== "OPTIONS" && empty($this->tokenData)) {
            $this->sendResponse(array(
                "code" => 401,
                "response" => array(
                    "test" => $this->tokenData,
                    "message" => "Sessión User no proporcionado o expirado",
                )
            ));
        }
    }
    //--------------------
    public function user($u)
    {
        switch ($this->method_) {
            case "GET":
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
    public function getMyUser()
    {
        switch ($this->method_) {
            case "GET":
                $this->sendResponse([
                    "code" => 200,
                    "response" => $this->tokenData
                ]);
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
    public function manage()
    {
        switch ($this->method_) {
            case "GET":
                try {
                    $response = [];
                    $createTmp = $this->modelo_usuario->usersTmpTable(); //Temporary table
                    $createPagination = $this->modelo_usuario->areaTmpPagination(); //Temporary table
                    $response = $this->getUsers();
                    $this->sendResponse(["code" => 200, "response" => $response]);
                } catch (Exception $e) {
                    $this->sendResponse(["code" => $e->getCode(), "response" => ["message" => $e->getMessage()]]);
                }
                break;
            case "OPTIONS":
                break;
            default:
                $this->sendResponse([
                    "code" => 405,
                    "response" => [
                        "message" => "Metodo " . $this->method_ . " no es permitido para esta ruta"
                    ]
                ]);
        }
    }
    //--------------------
    public function getDepartment($area)
    {
        switch ($this->method_) {
            case "GET":
                try {
                    $response = [];
                    $createTmp = $this->modelo_usuario->usersTmpTable(); //Temporary table
                    $createPagination = $this->modelo_usuario->areaTmpPagination(); //Temporary table
                    $response = $this->getUsers($area);
                    $this->sendResponse(["code" => 200, "response" => $response]);
                } catch (Exception $e) {
                    $this->sendResponse(["code" => $e->getCode(), "response" => ["message" => $e->getMessage()]]);
                }
                break;
            case "OPTIONS":
                break;
            default:
                $this->sendResponse(["code" => 405, "response" => ["message" => "Metodo " . $this->method_ . " no es permitido para esta ruta"]]);
        }
    }
    //--------------------
    public function pagination($area, $page)
    {
        switch ($this->method_) {
            case "GET":
                try {
                    $response = [];
                    $response = $this->getUsers($area, $page);
                    $this->sendResponse(["code" => 200, "response" => $response]);
                } catch (Exception $e) {
                    $this->sendResponse(["code" => $e->getCode(), "response" => ["message" => $e->getMessage()]]);
                }
                break;
            case "OPTIONS":
                break;
            default:
                $this->sendResponse(["code" => 405, "response" => ["message" => "Metodo " . $this->method_ . " no es permitido para esta ruta"]]);
        }
    }
    //--------------------
    private function getUsers($area_ = null, $pagination = null)
    {
        try {
            $response = [];
            $pagination_ = [];
            $pagination_["r2"] = !empty($pagination) ? $pagination * 10 : 10;
            $pagination_["r1"] = !empty($pagination) ? $pagination_["r2"] - 9 : 1;
            $getPagination = $this->modelo_usuario->getAreaPagination();
            $areas = array_column($getPagination, "getParam");


            if (!empty($area_) && !in_array(strtolower($area_), $areas)) {
                throw new Exception("No existe un departamento o area para esta solicitud", 400);
            }

            $_area = empty($area_) ? $getPagination : array_filter($getPagination, function ($ar) use ($area_) {
                return $ar["getParam"] === $area_;
            });

            $getAllUsers = $this->modelo_usuario->getUsers($area_, $pagination_);

            if (empty($getAllUsers)) {
                return ["message" => "No se encontraron resultados"];
            }

            foreach ($_area as $area) {
                array_push($response, [
                    "pagination" => [
                        "page" => !empty($pagination) ? (int)$pagination : 1,
                        "pages" => (int)$area["pages"],
                        "totalItems" => (int)$area["totalItems"]
                    ],
                    "area" => $area["AREA"],
                    "users" => array_reduce($getAllUsers, function ($acc, $curr) use ($area) {

                        if ($curr["department"] === $area["AREA"]) {
                            array_push($acc, ["p" => (int)$curr["p"], "thumb" => $curr["fotoUser"], "email" => $curr["email"], "name" => TRIM($curr["nombres"] . " " . $curr["apellidoPaterno"] . " " . $curr["apellidoMaterno"])]);
                        }

                        return $acc;
                    }, [])
                ]);
            }

            return $response;
        } catch (Exception $e) {
            $this->sendResponse([
                "code" => $e->getCode(),
                "response" => ["message" => $e->getMessage()]
            ]);
        }
    }
    //--------------------
    private function sendResponse($response)
    {

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

}
