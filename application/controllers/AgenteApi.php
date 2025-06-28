<?php 

header("Access-Control-Allow-Methods: GET, OPTIONS, PATCH, POST, DELETE");
header("Access-Control-Allow-Origin: * ");
header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding, x-requested-with, Session-User");

class AgenteApi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("agente_model");
        $this->load->helper("file");
    }

    public function getData($agentId) {
        
        $method = $_SERVER["REQUEST_METHOD"];

        if($method == "GET"){
            
            $timesFormats = array();
            $getAgentData = $this->agente_model->getAgent($agentId);
            $getAvailable = $this->agente_model->getAvailable($agentId);

            foreach($getAvailable as $value){

                $hours = array();

                for($init = (Int) $value["hinicio"]; $init <= $value["hfinal"]; $init++){
                    array_push($hours, $init);
                }

                $timesFormats[$value["mes"]] = $hours;
            }

            $getAgentData["horarios"] = $timesFormats;

            echo json_encode(array(
                "status" => "success", 
                "data" => $getAgentData,
                "code" => 200
            ));
            die;
        }

        echo json_encode(array("status" => "error", "code" => 405, "message" => "Método de solicitud no permitido para este servicio"));
        
    }

    public function getCountryCodes(){

        try{
            
            $file = base_url()."assets/json/countryCodes.json";
            $headers = @get_headers($file);

            if(!in_array($_SERVER["REQUEST_METHOD"], ["GET", "OPTIONS"])){
                
                throw new Exception("El método solicitado no está permitido por el servicio", 405);
            }

            if($_SERVER["REQUEST_METHOD"] == "OPTIONS"){
                exit;
            }

            if($headers && strpos($headers[0], '404')){
                throw new Exception("El archivo de consulta de códigos de paises no existe", 404);
            }

            $getArrayContent = json_decode(file_get_contents($file), true);
    
            http_response_code(200);
            header('Content-Type: application/json');
            echo json_encode($getArrayContent);
            exit;

        } catch(Exception $e){

            http_response_code($e->getCode());
            header('Content-Type: application/json');
            echo json_encode(array("error" => $e->getMessage()));
            exit;
        }
    }
}

?>