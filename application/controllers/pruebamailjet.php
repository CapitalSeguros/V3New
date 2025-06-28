<?php 

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pruebamailjet extends CI_Controller{

    function __construct(){
        parent::__construct();

        $this->load->library("mailjet_api");

    }

    function index(){}

    function prueba_envio_correo(){

        $this->mailjet_api->ejecuta_api_envio_de_correos();

    }
    //----------------------------------------------------
    //Envio de correos de felicitación de cumpleaños.
    function avisoCumpleanio_tareaprogramada(){

        $this->load->model("personamodelo");
        $this->load->library("imgedit_cenis");

        $personas=$this->personamodelo->obtenerTodasLasPersonas();

        $dia=$_GET["dia"];
        $mes=$_GET["mes"];

        if(!empty($personas)){
            foreach($personas as $aa){
            
                if(empty($aa->fechaNacimiento)){
                    $aa->fechaNacimiento="0000-00-00";
                }

                $f_c=explode("-",$aa->fechaNacimiento);
                $_dia=$f_c[2];
                $_mes=$f_c[1];

                $_datos_hb=array();

                if($dia==$_dia && $mes==$_mes){
                    
                    $pp=$this->imgedit_cenis->crear_img_edit($aa,$dia,$mes); //Ruta del archivo.

                    //$img_p_hb=base_url()."assets/"

                    $_datos_hb["to"]=$aa->emailUsers;
                    $_datos_hb["titulo"]="¡Feliz Cumpleaños ".$aa->nombres."!";

                    $mensaje="<html>
                    <head>
                    </head>
                    <body>
                        <div>
                        <p style='font-family: helvetica; color: #2155B5; font-weight: bold'>Estimado ".$aa->nombres.":</p>
                        <p style='font-family: helvetica; color: #2155B5; font-weight: bold'>Sabemos que el día de hoy es un día especial e importante, por lo que la Familia Capital Seguros y Fianzas quiere felicitarte esperando que disfrutes cada instante acompañado de tu familia y compañeros en la distancia.</p>
                        <h2 style='font-family: helvetica; color: #2155B5; font-weight: bold'>¡Feliz Cumpleaños!<h2>
                        <div style='margin-top: 30px'>
                            <img src=\"cid:id1\"></img>  
                        </div>
                        </div>
                    </body>
                    </html>";
                    //<img src=\'cid:id".$aa->idPersona."\'></img>  
                    $_datos_hb["mensaje"]=$mensaje; //\'".base_url()."assets/plantillas_hb/".$mes.$dia."/".$aa->idPersona."_hb.png'
                    $_datos_hb["nombre_archivo"]=$aa->idPersona."_hb.png";
                    $_datos_hb["id_enbeded"]=$aa->idPersona;
                    $_datos_hb["ruta_archivo"]=$_SERVER["DOCUMENT_ROOT"]."/V3/assets/plantillas_hb/".$mes.$dia."/".$aa->idPersona."_hb.png";//$aa->idPersona; //$_SERVER["DOCUMENT_ROOT"]."/V3/
                    $_datos_hb["encode_base64"]=base64_encode(file_get_contents($_SERVER["DOCUMENT_ROOT"]."/V3/assets/plantillas_hb/".$mes.$dia."/".$aa->idPersona."_hb.png")); //$aa->idPersona."_hb.png";
                        //Ruta localhost: $_SERVER["DOCUMENT_ROOT"]."/Capsys/www/V3/assets/plantillas_hb/".$mes.$dia."/".$aa->idPersona."_hb.png"

                    //var_dump($_datos_hb);

                    $emm=$this->mailjet_api->ejecuta_api_envio_de_correos($_datos_hb);
                    echo $emm;
                }
            }
        }
    }
    //----------------------------------------------------
}
?>