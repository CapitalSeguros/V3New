<?php 

    require_once 'google/vendor2/autoload.php';

    define('CLIENT_ID', 'w76N74xKQnm1AzN3gQCQ7w');
    define('CLIENT_SECRET', 'Xc0J6zu4Rklr20X9nLQzyCJjzwamObxm');
    define('REDIRECT_URI', 'https://www.capsys.com.mx/V3/libraries/zoom/callback.php');

class meetingcenis {

    function __construct(){

    }

    function conexion(){

        $url = "https://zoom.us/oauth/authorize?response_type=code&client_id=".CLIENT_ID."&redirect_uri=".REDIRECT_URI;

        echo "<a href=".$url.">Login with Zoom</a>";
    }
    
    function create_meeting_event($datosEvento){

        $datos_retorno=array();

        date_default_timezone_set("America/Mexico_City");

        $CI=&get_instance();
        $CI->load->model("zoom_model");
        $info_token=$CI->zoom_model->get_access_token();
        $ac_token=$info_token->access_token; 

        $contrasenia="";

        for($i=0;$i<7;$i++){
            $contrasenia.=rand(0, 9);
        }

        $fecha=$datosEvento["FechaInicio"]."T".$datosEvento["starttime"].":00";
        //$contrasenia.=rand(0,9);
        $titulo=$datosEvento["TituloEvento"];

        $client = new GuzzleHttp\Client(['base_uri' => 'https://api.zoom.us']);
        //$db = new DB();
        //$arr_token = $db->get_access_token();
        //$accessToken = $arr_token->access_token;
        try {
            $response = $client->request('POST', '/v2/users/me/meetings', [
                "headers" => [
                    "Authorization" => "Bearer $ac_token"
                ],
                'json' => [
                    "topic" => $titulo, //'Prueba de meeting', //
                    "type" => 2,
                    //"start_time" => "2020-05-05T20:30:00",
                    "start_time" => "2020-12-10T12:00:00", //$fecha, //"2020-11-13T06:00:00", //
                    "duration" => "30", // 30 mins
                    "password" => $contrasenia
                ],
            ]);
    
            $data = json_decode($response->getBody());
            
            $datos_retorno["zoom_url"]=$data->join_url;
            $datos_retorno["zoom_contrasenia"]=$data->password;
            $datos_retorno["zoom_idZoom"]=$data->id;
            
            //$fp = fopen('resultadoJason.txt', 'w');fwrite($fp, print_r($fecha, TRUE));fclose($fp);
            
            //$datos_retorno["zoom_fecha"]=$fecha;

            return $datos_retorno;
            //return $ac_token;
            //$liga_zoom= $data->join_url;
            //$password_liga=$data->password;

        } catch(Exception $e) {
            if( 401 == $e->getCode() ) {
                //$refresh_token = $db->get_refersh_token();
    
                $client = new GuzzleHttp\Client(['base_uri' => 'https://zoom.us']);
                $response = $client->request('POST', '/oauth/token', [
                    "headers" => [
                        "Authorization" => "Basic ". base64_encode(CLIENT_ID.':'.CLIENT_SECRET)
                    ],
                    'form_params' => [
                        "grant_type" => "refresh_token",
                        "refresh_token" => $ac_token
                    ],
                ]); 
                //$db->update_access_token($response->getBody());
                //create_meeting();
            } else {
                return $e->getMessage();
            }
        }
    }

} //Final de la clase.
?>
