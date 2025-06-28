<?php
    require 'vendor/autoload.php';
    use \Mailjet\Resources;
    class Sendmailforcalendarevents{

        function executeRequest($array){

            try{
                $mj = new \Mailjet\Client('682216c90487823470a996858e0e8660', 'b9791edd0629bb940973089fd063af9c',true,['version' => 'v3.1']);
                $body = [
                    'Messages' => [
                        [
                            'From' => $array["from"],
                            'To' => $array["to"],
                            'Subject' => $array["subject"],//"Your email flight plan!",
                            'TextPart' => $array["textPart"], //"Dear passenger 1, welcome to Mailjet! May the delivery force be with you!",
                            'HTMLPart' => $array["htmlPart"], //"<h3>Dear passenger 1, welcome to <img src=\"cid:id1\"> <a href=\"https://www.mailjet.com/\">Mailjet</a>!</h3><br />May the delivery force be with you!",
                            'Attachments' => $array["attachments"],
                            'InlinedAttachments' => $array["inlinedAttachments"]
                        ]
                    ]
                ];
                //var_dump($body);
                //$fp =fopen('resultadoJason.txt', 'a');fwrite($fp, print_r($body, TRUE));fclose($fp);
                $response = $mj->post(Resources::$Email, ['body' => $body]);
                //$response->success() &&  var_dump($response->getData()); //$response->success() && 
                return $response->success();
            } catch(Exception $e){
                echo "Excepción capturada". $e->getMessage();
            }
        }
    }
?>