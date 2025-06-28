<?php 
    if(!defined("BASEPATH")) exit('No direct script access allowed');

    class cambiodemoneda extends CI_Controller{
    
        function __construct(){
            parent::__construct();
            $this->load->model("crmproyecto_model");

        }


        function generaCambioDeDivisas(){
            try{

                date_default_timezone_set('America/Mexico_City');
                //echo date("Y-m-d H:i:s", 1620658800);

                $_rate_selected= !empty($_GET["tipo"]) ? $_GET["tipo"] : "";

                // Inicializar CURL:
                $ch = curl_init("https://openexchangerates.org/api/latest.json?app_id=72cd40ed0fd14278a0ab8231a8a0ed1b");
                //curl_init('http://api.exchangeratesapi.io/v1/'.$endpoint.'?access_key='.$access_key.'&base=USD&symbols=GBP,JPY,EUR'); //&base=USD&symbols=GBP,JPY,EUR
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            
                // Almacenar los datos:
                $json = curl_exec($ch);
                curl_close($ch);
            
                // Decode JSON respuesta:
                $exchangeRates = json_decode($json, true);
            
                //echo $exchangeRates['rates']['MXN'];
                //Almacenar en DB
                if(!empty($exchangeRates)){

                    $array_divisa = array();
                    foreach($exchangeRates["rates"] as $rate => $cambio){

                        if(!empty($_rate_selected) && $_rate_selected == $rate){

                            $array_divisa["base"] = $exchangeRates["base"];
                            $array_divisa["rate"] = $rate;
                            $array_divisa["cambio"] = $cambio;
                            $array_divisa["fecha_consulta_api"] = date("Y-m-d H:i:s", $exchangeRates["timestamp"]);
                            $array_divisa["fecha_tarea_programada"] = date("Y-m-d H:i:s");

                        } elseif(empty($_rate_selected) && $rate == "MXN"){

                            $array_divisa["base"] = $exchangeRates["base"];
                            $array_divisa["rate"] = $rate;
                            $array_divisa["cambio"] = $cambio;
                            $array_divisa["fecha_consulta_api"] = date("Y-m-d H:i:s", $exchangeRates["timestamp"]);
                            $array_divisa["fecha_tarea_programada"] = date("Y-m-d H:i:s");
                        }
                    }

                    //Inserta en DB
                    $respuesta = $this->crmproyecto_model->insertaCambioDivisas($array_divisa);
                    $responde = $respuesta == true ? $array_divisa : "No se insertó correctamente";
                    var_dump($responde);
                    
                } else{
                    
                    throw new Exception("RESPUESTA VACIA. REFRESCAR LA PÁGINA");
                }

            } catch(Exception $e){
                echo "NUEVA EXCEPCION CAPTURADA: ", $e->getMessage(), "\n";

            }
        }

        function timesss(){

            date_default_timezone_set('America/Mexico_City');
            echo date("Y-m-d H:i:s", 1620658800);

        }

    } //----------- FIN DE LA CLASE-------------
?>