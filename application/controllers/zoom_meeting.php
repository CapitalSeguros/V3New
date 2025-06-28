<?php 
    require_once 'zoom/class-db.php';
    require_once 'zoom/vendor/autoload.php';

    define('CLIENT_ID', 'w76N74xKQnm1AzN3gQCQ7w');
    define('CLIENT_SECRET', 'Xc0J6zu4Rklr20X9nLQzyCJjzwamObxm');
    define('REDIRECT_URI', 'https://www.capsys.com.mx/V3/zoom_meeting.php');

class zoom_meeting extends CI_Controller{

    function __construct(){
        parent::__construct();

        $this->load->model("zoom_model");

        try {
            $client = new GuzzleHttp\Client(['base_uri' => 'https://zoom.us']);
         
            $response = $client->request('POST', '/oauth/token', [
                "headers" => [
                    "Authorization" => "Basic ". base64_encode(CLIENT_ID.':'.CLIENT_SECRET)
                ],
                'form_params' => [
                    "grant_type" => "authorization_code",
                    "code" => $_GET['code'],
                    "redirect_uri" => REDIRECT_URI
                ],
            ]);
         
            $token = json_decode($response->getBody()->getContents(), true);
            
            $resp=$this->oauthZoom($token);

            echo $resp;

        } catch(Exception $e) {
            echo $e->getMessage();
        }

    }


    function index(){
        //$this->oauthZoom();

    }

    function oauthZoom($token){

        $respuesta="";

        $resultado=$this->zoom_model->inserta_token(array("token"=>json_encode($token)));

        if($resultado){
           $respuesta="succesfull";
        }

        return $respuesta;
    }
}
?>
