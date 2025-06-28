<?php
 require 'vendor/autoload.php';
 use \Mailjet\Resources;

class Mailjet_api{
    
    function ejecuta_api_envio_de_correos($array){
        //var_dump($array);
        try {

            $mj = new \Mailjet\Client('47fedff9be502f8e331e135dbc9d23fb','87ef76370b90a9b2a50afb8332586118',true,['version' => 'v3.1']);
            $body = [
                'Messages' => [
                    [
                        'From' => [
                            'Email' => "sistemas@asesorescapital.com",
                            'Name' => "Notificacion Agente"
                        ],
                        'To' => [
                            [
                                'Email' => $array["to"],
                                'Name' => $array["to"]
                            ]
                        ],
                        'Subject' => $array["titulo"],
                        'TextPart' => $array["mensaje"],
                        'HTMLPart' => $array["mensaje"],
                        'InlinedAttachments'=> [
                            [
                                'ContentType' => "image/png",
                                'Filename' => $array["nombre_archivo"],
                                'ContentID' => "id1",//.$array["id_enbeded"],
                                'Base64Content'=> $array["encode_base64"] //base64_encode(file_get_contents($array["ruta_archivo"]))
                            ]
                        ]
                    ]
                ]
            ];

            //var_dump($body);

            $response = $mj->post(Resources::$Email, ['body' => $body]);
            $response->success(); //&& var_dump($response->getData());

            return $response->getData(); 

        } catch(Exception $e){

            echo "Excepcion capturada".$e->getMessage();

        }
    }
    
    function envio_correos_convocatoria_reunion($array){
        try {

            $mj = new \Mailjet\Client('47fedff9be502f8e331e135dbc9d23fb','87ef76370b90a9b2a50afb8332586118',true,['version' => 'v3.1']);
            $body = [
                'Messages' => [
                    [
                        'From' => [
                            'Email' => "Avisos GAP<avisos@agentecapital.com>",
                            'Name' => "Capital Seguros y Fianzas"
                        ],
                        'To' => [
                            [
                                'Email' => $array["to"],
                                'Name' => $array["to"]
                            ]
                        ],
                        'Subject' => $array["titulo"],
                        'TextPart' => $array["mensaje"],
                        'HTMLPart' => $array["mensaje"]
                    ]
                ]
            ];

            $response = $mj->post(Resources::$Email, ['body' => $body]);
            $response->success() && var_dump($response->getData());

        } catch(Exception $e){

            echo "Excepcion capturada".$e->getMessage();

        }
    }
}
?>
